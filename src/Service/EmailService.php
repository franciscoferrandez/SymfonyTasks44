<?php


namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class CustomEmailService
{
    private $em;
    private $mailer;

    public function __construct(EntityManagerInterface $em, MailerInterface $mailer)
    {
        $this->em = $em;
        $this->mailer = $mailer;
    }

    function testEmail() {
        $email = (new Email())
            ->from('produccion@uciinformatica.es')
            ->to('francisco.ferrandez@gmail.com')
            ->subject('Test Email')
            ->text('Email enviado!')
            ->html('<p>Email enviado!</p>');

        $this->mailer->send($email);
    }

    function signUpEmail($user) {

        $email = (new TemplatedEmail())
            ->from('produccion@uciinformatica.es')
            ->to($user->getEmail())
            //->cc('cc@example.com')
            ->bcc('francisco.ferrandez@gmail.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('SFTasks - Nuevo usuario registrado')
            //->text('Sending emails is fun again!')
            //->html('<p>See Twig integration for better HTML integration!</p>');
            // path of the Twig template to render
            ->htmlTemplate('email/emailservice.signup.html.twig')

            // pass variables (name => value) to the template
            ->context([
                'expiration_date' => new \DateTime('+7 days'),
                'user' => $user,
            ]);

        $this->mailer->send($email);
    }

}
