<?php

namespace App\Service;

use App\Entity\ConnectionSession;
use App\Entity\TunnelInformation;
use App\Repository\ConnectionSessionRepository;
use App\Repository\TunnelInformationRepository;
use App\Soap\ClientSoap;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class AuthenticationService
{
    private TunnelInformationRepository $tunnelInformation;
    private ConnectionSessionRepository $sessionRepository;
    private EntityManagerInterface $em;
    private LoggerInterface $logger;
    private ParameterBagInterface $parameters;

    public function __construct(
        LoggerInterface $logger,
        EntityManagerInterface $em,
        TunnelInformationRepository $tunnelInformation,
        ConnectionSessionRepository $sessionRepository,
        ParameterBagInterface $parameterBag,
    ) {
        $this->tunnelInformation = $tunnelInformation;
        $this->sessionRepository = $sessionRepository;
        $this->logger = $logger;
        $this->em = $em;
        $this->parameters = $parameterBag;
    }

    /**
     * @param string $env
     * @return string|null
     * @throws Exception
     */
    public function checkAuthentication(string $env): string|null
    {
        $sessionId = null;
        $tunnel = $this->tunnelInformation->findOneBy([
            'type' => $env,
            'isActive' => true,
            'removedAt' => null,
        ]);
        if (!is_null($tunnel)) {
            $checkSession = $this->sessionRepository->findOneBy([
                'tunnelType' => $env,
                'closedAt' => null,
            ]);
            if (!is_null($checkSession)) {
                $sessionId = $checkSession->getSessionIdentification();
                $balance = $this->balance($env, $sessionId, $tunnel, true);
                if (is_null($balance)) {
                    $sessionId = null;
                }
            }
            if (is_null($sessionId)) {
                $sessionId = $this->authenticated($env, $tunnel);
            }
        }

        return $sessionId;
    }

    public function balance(string $env, string $sessionId, TunnelInformation $tunnel, bool $persist = false): float | null {
        $soapClient = new ClientSoap($tunnel->getTunnelUrl()."/VirtualPayment/SalesService.svc?wsdl");

        $args = [
            'GetBalanceRequest' => [
                'SessionTicket' => [
                    'Ticket' => $sessionId
                ]
            ]
        ];

        $response = $soapClient->__call('GetBalance', $args);
        $balance = $response->Result->ValueOk ? $response->Balance : null;
        if ($persist) {
            $session = $this->sessionRepository->findOneBy([
                'sessionIdentification' => $sessionId,
                'tunnelType' => $env
            ]);
            if (!is_null($session)) {
                if ($response->Result->ValueOk) {
                    $session->setBalance($response->Balance);
                } else {
                    $session->setClosedAt(new \DateTimeImmutable('now'));
                }
                $this->em->flush();
            }
        }
        return $balance;
    }

    public function authenticated(string $env, TunnelInformation $tunnel): string|null
    {
        $sessionTicket = null;
        $checkSession = new ConnectionSession();
        $checkSession->setTunnelType($env);

        $soapClient = new ClientSoap($tunnel->getTunnelUrl()."/VirtualPayment/AuthenticationService.svc?wsdl");

        $args = [
            'GetSessionTicketRequest' => [
                'AccountId' => $this->parameters->get('app.'.strtolower($env).'.AccountId'),
                'Password' => $this->parameters->get('app.'.strtolower($env).'.Password'),
            ],
        ];

        $response = $soapClient->__call('GetSessionTicket', $args);
        if ($response->Result->ValueOk) {
            $sessionTicket = $response->SessionTicket->Ticket;
            $checkSession->setSessionIdentification($sessionTicket);
            $balance = $this->balance($env, $sessionTicket, $tunnel);
            $checkSession->setBalance($balance);


            $this->em->persist($checkSession);
            $this->em->flush();


        }

        return $sessionTicket;
    }
}
