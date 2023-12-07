<?php

namespace App\Service;

use App\Repository\TunnelInformationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\MailerInterface;

class CommonService
{
    protected EntityManagerInterface $em;
    protected ParameterBagInterface $parameters;
    protected MailerInterface $emailService;
    protected LoggerInterface $logger;
    protected TunnelInformationRepository $tiRepo;

    /**
     * @param EntityManagerInterface $em
     * @param ParameterBagInterface $parameters
     * @param MailerInterface $emailService
     * @param LoggerInterface $logger
     */
    public function __construct(EntityManagerInterface $em, ParameterBagInterface $parameters, MailerInterface $emailService, LoggerInterface $logger, TunnelInformationRepository $tunnelInformationRepository)
    {
        $this->em = $em;
        $this->parameters = $parameters;
        $this->emailService = $emailService;
        $this->logger = $logger;
        $this->tiRepo = $tunnelInformationRepository;
    }
}
