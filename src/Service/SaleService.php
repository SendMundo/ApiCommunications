<?php

namespace App\Service;

use App\DTO\Input\RechargeInput;
use App\DTO\Input\SaleInfoInput;
use App\DTO\Input\SalePackageInput;
use App\DTO\Output\GetSaleInfo;
use App\DTO\Output\OutputResult;
use App\DTO\Output\OutResult;
use App\Entity\Operation;
use App\Exceptions\CustomException;
use App\Repository\OperationRepository;
use App\Repository\TunnelInformationRepository;
use App\Soap\ClientSoap;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\MailerInterface;

class SaleService extends CommonService
{
    private OperationRepository $opRepo;
    private AuthenticationService $authService;

    public function __construct(
        EntityManagerInterface $em,
        ParameterBagInterface $parameters,
        MailerInterface $emailService,
        LoggerInterface $logger,
        TunnelInformationRepository $tunnelInformationRepository,
        OperationRepository $operationRepository,
        AuthenticationService $authenticationService
    ) {
        parent::__construct($em, $parameters, $emailService, $logger, $tunnelInformationRepository);
        $this->opRepo = $operationRepository;
        $this->authService = $authenticationService;
    }

    /**
     * @param RechargeInput $input
     * @return OutputResult
     * @throws Exception
     */
    public function sale(RechargeInput $input): OutputResult
    {
        $out = new OutputResult();
        $tunnel = $this->tiRepo->findOneBy([
            'type' => $input->getEnvironment(),
            'isActive' => true,
            'removedAt' => null,
        ]);
        $tokenId = $this->authService->checkAuthentication($input->getEnvironment());
        if (!is_null($tokenId) && !is_null($tunnel)) {
            $soapClient = new ClientSoap($tunnel->getTunnelUrl()."/VirtualPayment/SalesService.svc?wsdl");

            $args = [
                'SaleRechargeRequest' => [
                    'RechargeData' => [
                        'PhoneNumber' => $input->getPhoneNumber(),
                        'Price' => $input->getProductPrice(),
                        'ProductCode' => $input->getProductCode(),
                    ],
                    'SessionTicket' => [
                        'Ticket' => $tokenId,
                    ],
                    'TransactionId' => $input->getTransactionId(),
                ],
            ];

            $response = $soapClient->__call('SaleRecharge', $args);

            if ($response->Result->ValueOk) {
                $operation = new Operation();
                $operation->setOrderId($response->OrderId);
                $operation->setConnectionId($tokenId);
                $operation->setResponseInfo([
                    'info' => $response,
                ]);
                $operation->setTunnelType($input->getEnvironment());
                $this->em->persist($operation);
                $this->em->flush();
                $out->setOrderId($response->OrderId);
                $out->setResult(
                    new OutResult(
                        $response->Result->ValueOk,
                        $response->Result->Message,
                        $response->Result->RequestTime,
                        $response->Result->ResponseTime
                    )
                );
                $this->em->flush();
            } else {
                throw new \RuntimeException($response->Result->Message, 422);
            }
        }

        return $out;
    }

    /**
     * @throws Exception
     */
    public function salePackage(SalePackageInput $input): OutputResult
    {
        $out = new OutputResult();
        $tunnel = $this->tiRepo->findOneBy([
            'type' => $input->getEnvironment(),
            'isActive' => true,
            'removedAt' => null,
        ]);
        $tokenId = $this->authService->checkAuthentication($input->getEnvironment());
        if (!is_null($tokenId) && !is_null($tunnel)) {
            $soapClient = new ClientSoap($tunnel->getTunnelUrl()."/VirtualPayment/SalesService.svc?wsdl");

            $args = [
                'SalePackageRequest' => [
                    'PackageData' => [
                        'Package' => [
                            'Id' => $input->getPackageInfo()?->getId(),
                            'PackageType' => $input->getPackageInfo()?->getPackageType(),
                        ],
                        'Client' => [
                            'Id' => $input->getClient()?->getId(),
                            'Name' => $input->getClient()?->getName(),
                            'CommercialOffice' => [
                                'Id' => $input->getClient()?->getCommercialOfficeId(),
                                'Province' => [
                                    'Id' => $input->getClient()?->getProvinceId(),
                                ],
                            ],
                            'IdentificationType' => [
                                'Id' => $input->getClient()?->getIdentificationType(),
                            ],
                            'ArrivalDate' => $input->getClient()?->getArrivalDate()->format('Y-m-d'),
                            'PickUpAirport' => $input->getClient()?->getIsAirport() ? 'S' : null,
                            'Nationality' => $input->getClient()?->getNationality(),
                        ],
                        'PhoneNumber' => $input->getPhoneNumber()
                    ],
                    'SessionTicket' => [
                        'Ticket' => $tokenId,
                    ],
                    'TransactionId' => $input->getTransactionId(),
                ],
            ];

            $response = $soapClient->__call('SalePackage', $args);
            if ($response->Result->ValueOk && !is_null($response->OrderId)) {
                $currentOperation = new Operation();
                $currentOperation->setOrderId($response->OrderId);
                $currentOperation->setConnectionId($tokenId);
                $currentOperation->setResponseInfo([
                    'info' => $response,
                ]);
                $currentOperation->setTunnelType($input->getEnvironment());

                $out->setOrderId($response->OrderId);
                $out->setResult(
                    new OutResult(
                        $response->Result->ValueOk,
                        $response->Result->Message,
                        $response->Result->RequestTime,
                        $response->Result->ResponseTime
                    )
                );

                $currentArgs = [
                    'GetSaleRequest' => [
                        'OrderId' => $response->OrderId,
                        'SessionTicket' => [
                            'Ticket' => $tokenId,
                        ],
                        'TransactionId' => $input->getTransactionId(),
                    ],
                ];

                $responseInfo = $soapClient->__call('GetSale', $currentArgs);
                if ($responseInfo->Result->ValueOk) {
                    $out->setFullResponse($responseInfo);
                    $out->setSale(
                        new GetSaleInfo(
                            $response->OrderId,
                            $input->getTransactionId(),
                            $responseInfo->Sale->State,
                            $responseInfo->Sale->PhoneNumber,
                            new \DateTime($responseInfo->Sale->CreatedDateTime),
                            new \DateTime($responseInfo->Sale->ExpiredDateTime),
                            new \DateTime($responseInfo->Sale->ProcessedDateTime),
                            $responseInfo->Sale->ExecutedDateTime,
                            $responseInfo->Sale->Code,
                            $responseInfo->Sale->Package->Enabled,
                        )
                    );
                    $currentOperation->setOperationInfo([
                        'info' => $responseInfo,
                    ]);
                }

                $this->em->persist($currentOperation);
                $this->em->flush();
            } else {
                $exc = new CustomException($response->Result->Message);
                $exc->setCustomData($response);

                throw $exc;
            }

        }

        return $out;
    }

    public function getInfoOfSale(SaleInfoInput $input): OutputResult
    {
        $out = new OutputResult();
        $tunnel = $this->tiRepo->findOneBy([
            'type' => $input->getEnvironment(),
            'isActive' => true,
            'removedAt' => null,
        ]);
        $tokenId = $this->authService->checkAuthentication($input->getEnvironment());
        if (!is_null($tokenId) && !is_null($tunnel)) {
            $soapClient = new ClientSoap($tunnel->getTunnelUrl()."/VirtualPayment/SalesService.svc?wsdl");

            $args = [
                'GetSaleRequest' => [
                    'OrderId' => $input->getOrderId(),
                    'SessionTicket' => [
                        'Ticket' => $tokenId,
                    ],
                    'TransactionId' => $input->getTransactionId(),
                ],
            ];

            $response = $soapClient->__call('GetSale', $args);
            if ($response->Result->ValueOk) {
                $out->setOrderId($input->getOrderId());
                $out->setResult(
                    new OutResult(
                        $response->Result->ValueOk,
                        $response->Result->Message,
                        $response->Result->RequestTime,
                        $response->Result->ResponseTime
                    )
                );
                $out->setFullResponse($response);
                $out->setSale(
                    new GetSaleInfo(
                        $input->getOrderId(),
                        $input->getTransactionId(),
                        $response->Sale?->State,
                        $response->Sale?->PhoneNumber,
                        new \DateTime($response->Sale?->CreatedDateTime),
                        new \DateTime($response->Sale?->ExpiredDateTime),
                        new \DateTime($response->Sale?->ProcessedDateTime),
                        $response->Sale?->ExecutedDateTime,
                        $response->Sale?->Code,
                        $response->Sale?->Package?->Enabled,
                    )
                );
            } else {
                $exc = new CustomException($response->Result->Message);
                $exc->setCustomData($response);

                throw $exc;
            }
        }
        return $out;
    }
}
