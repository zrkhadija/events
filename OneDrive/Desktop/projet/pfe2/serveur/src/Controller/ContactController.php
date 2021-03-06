<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index( Request $request, \Swift_Mailer $mailer   ): Response
    {   
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $contact= $form->getData();
            $message = (new \Swift_Message('nouveau email') )
             ->setFrom($contact['Email'])
             ->setTo('zkhadija722@gmail.com')
             ->setBody(
                 $this->renderView(
                     'emails/contact.html.twig' , compact('contact')
                 ),
                 'text/html'
             )
        ;
        $mailer->send($message);
        $this->addFlash('message' , 'envoie reussie');
        
        }
        return $this->render('contact/index.html.twig',
    [
        'ContactForm' => $form->createView()
    ]);
    }
}
