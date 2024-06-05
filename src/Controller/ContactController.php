<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request,MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        // $address = $form->get('Email')->getData();
     
         $form->handleRequest($request);

         if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $address = $data['Email'];
            $emailBody = $data['Contenu'];
            $email = (new Email())
            ->from($address)
            ->to('tommyhas743@gmail.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Prise de Contact')
            ->text('Salutations')
            ->html($emailBody);

        $mailer->send($email);

            return $this->redirectToRoute('app_contact');
         }
         
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'ContactController',
        ]);
    }
}
