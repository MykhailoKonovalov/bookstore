<?php

namespace App\Service\Email;

use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

readonly class EmailSender
{
    public function __construct(
        private MailerInterface $mailer,
        private LoggerInterface $logger,
        private string $fromEmail,
        private string $fromName,
    ) {}

    public function send(
        string $userEmail,
        string $subject,
        string $template,
        array $context = [],
    ): void {
        try {
            $email = new TemplatedEmail();

            $email
                ->from(new Address($this->fromEmail, $this->fromName))
                ->to($userEmail)
                ->subject($subject)
                ->htmlTemplate($template)
                ->context($context);

            $this->mailer->send($email);
        } catch (TransportExceptionInterface $exception) {
            $this->logger->error($exception->getMessage());
        }
    }
}