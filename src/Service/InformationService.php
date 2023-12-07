<?php

namespace App\Service;

use App\DTO\Input\InformationInput;
use App\Repository\TunnelInformationRepository;
use App\Soap\ClientSoap;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\MailerInterface;

final class InformationService extends CommonService
{
    private AuthenticationService $authService;
    public function __construct(
        EntityManagerInterface $em,
        ParameterBagInterface $parameters,
        MailerInterface $emailService,
        LoggerInterface $logger,
        TunnelInformationRepository $tunnelInformationRepository,
        AuthenticationService $authenticationService
    ) {
        parent::__construct($em, $parameters, $emailService, $logger, $tunnelInformationRepository);
        $this->authService = $authenticationService;
    }

    public function products(string $environment): array
    {
        $out = [];
        $tunnel = $this->tiRepo->findOneBy([
            'type' => $environment,
            'isActive' => true,
            'removedAt' => null,
        ]);
        $tokenId = $this->authService->checkAuthentication($environment);
        if (!is_null($tokenId) && !is_null($tunnel)) {
            $soapClient = new ClientSoap($tunnel->getTunnelUrl()."/VirtualPayment/SalesService.svc?wsdl");

            $args = [
                'GetPackagesRequest' => [
                    'SessionTicket' => [
                        'Ticket' => $tokenId,
                    ],
                ],
            ];

            $response = $soapClient->__call('GetPackages', $args);
            if ($response->Result->ValueOk && property_exists($response->Packages, 'Packages')) {
                foreach ($response->Packages->Packages as $key => $value) {
                    $out[] = $value;
                }
            }
        }

        return $out;
    }

    public function nationalities(string $environment): array {
        $out = [];
        $tunnel = $this->tiRepo->findOneBy([
            'type' => $environment,
            'isActive' => true,
            'removedAt' => null,
        ]);
        $tokenId = $this->authService->checkAuthentication($environment);
        if (!is_null($tokenId) && !is_null($tunnel)) {
            $soapClient = new ClientSoap($tunnel->getTunnelUrl()."/VirtualPayment/SalesService.svc?wsdl");

            $args = [
                'GetNationalitiesRequest' => [
                    'SessionTicket' => [
                        'Ticket' => $tokenId,
                    ],
                ],
            ];

            $response = $soapClient->__call('GetNationalities', $args);
            if ($response->Result->ValueOk && property_exists($response->Nationalities, 'Nationalities')) {
                foreach ($response->Nationalities->Nationalities as $key => $value) {
                    $out[] = $value;
                }
            }
        }

        return $out;
    }

    public function provinces(string $environment): array {
        $out = [];
        $tunnel = $this->tiRepo->findOneBy([
            'type' => $environment,
            'isActive' => true,
            'removedAt' => null,
        ]);
        $tokenId = $this->authService->checkAuthentication($environment);
        if (!is_null($tokenId) && !is_null($tunnel)) {
            $soapClient = new ClientSoap($tunnel->getTunnelUrl()."/VirtualPayment/SalesService.svc?wsdl");

            $args = [
                'GetProvincesRequest' => [
                    'SessionTicket' => [
                        'Ticket' => $tokenId,
                    ],
                ],
            ];

            $response = $soapClient->__call('GetProvinces', $args);
            if ($response->Result->ValueOk && property_exists($response->Provinces, 'Provinces')) {
                foreach ($response->Provinces->Provinces as $key => $value) {
                    $out[] = $value;
                }
            }
        }

        return $out;
    }

    public function commercialOffices(InformationInput $input): array {
        $out = [];
        $tunnel = $this->tiRepo->findOneBy([
            'type' => $input->getEnvironment(),
            'isActive' => true,
            'removedAt' => null,
        ]);
        $tokenId = $this->authService->checkAuthentication($input->getEnvironment());
        if (!is_null($tokenId) && !is_null($tunnel)) {
            $soapClient = new ClientSoap($tunnel->getTunnelUrl()."/VirtualPayment/SalesService.svc?wsdl");

            $args = [
                'GetCommercialOfficesRequest' => [
                    'SessionTicket' => [
                        'Ticket' => $tokenId,
                    ],
                    'ProvinceId' => $input->getProvinceId()
                ],
            ];

            $response = $soapClient->__call('GetCommercialOffices', $args);
            if ($response->Result->ValueOk && property_exists($response->ComercialOffices, 'CommercialOffices')) {
                foreach ($response->ComercialOffices->CommercialOffices as $key => $value) {
                    $out[] = $value;
                }
            }
        }

        return $out;
    }

    public function identificationType(InformationInput $input): array {
        $out = [];
        $tunnel = $this->tiRepo->findOneBy([
            'type' => $input->getEnvironment(),
            'isActive' => true,
            'removedAt' => null,
        ]);
        $tokenId = $this->authService->checkAuthentication($input->getEnvironment());
        if (!is_null($tokenId) && !is_null($tunnel)) {
            $soapClient = new ClientSoap($tunnel->getTunnelUrl()."/VirtualPayment/SalesService.svc?wsdl");

            $args = [
                'GetIdentificationTypesRequest' => [
                    'SessionTicket' => [
                        'Ticket' => $tokenId,
                    ]
                ],
            ];

            $response = $soapClient->__call('GetIdentificationTypes', $args);
            if ($response->Result->ValueOk && property_exists($response->ComercialOffices, 'CommercialOffices')) {
                foreach ($response->ComercialOffices->CommercialOffices as $key => $value) {
                    $out[] = $value;
                }
            }
        }

        return $out;
    }

}
