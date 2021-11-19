<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendNotification()
    {
        $email = (new Email())
            ->from('tricouille.notification@gmail.com')
            ->to('mickael.gbaguidi@gmail.com')
            ->subject('Nouvelle dépense Tricouille')
            ->text('Sending emails is fun again!')
            ->html('<p>Une nouvelle dépense a été ajoutée à votre Tricouille</p>');

        $this->mailer->send($email);
    }
}