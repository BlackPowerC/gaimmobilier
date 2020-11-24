<?php

namespace App\Notification;

use Twig\Environment;
use App\Entity\Contact;

class ContactNotification
{

    /**
     * Le composant swiftmail
     *
     * @var \Swift_Mailer
     */
    private $mailer ;

    /**
     * Le moteur de rendu twig
     *
     * @var Environment
     */
    private $renderer ;

    public function __construct(Environment $env, \Swift_Mailer $mailer) 
    {
        $this->mailer = $mailer ;
        $this->renderer = $env ;
    }

    public function notify(Contact $contact)
    {
        $message = (new \Swift_Message("Message : " . $contact->getImmo()->getTitle()))
            ->setFrom("noreply@immofutura.tg")
            ->setTo("contact@immofutura.tg")
            ->setReplyTo($contact->getEmail())
            ->setBody($this->renderer->render("email/contact.html.twig", [
                "lastname"=>$contact->getFirstname(),
                "firstname"=>$contact->getLastname(),
                "message"=>$contact->getMessage(),
                "email"=>$contact->getEmail()
            ]), "text/html") ;
        
            $this->mailer->send($message) ;
    }
}