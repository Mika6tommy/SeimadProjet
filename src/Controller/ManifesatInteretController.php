<?php

namespace App\Controller;

use App\Form\ManifestationInteretType;
use App\Repository\UserRepository;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;

class ManifesatInteretController extends AbstractController
{
    
    #[Route('/ManifestInteret', name: 'app_manifesat_interet')]
public function index(Request $request,MailerInterface $mailer,UserRepository $userRepository): Response
{

    $form = $this->createForm(ManifestationInteretType::class);
   // $address = $form->get('Email')->getData();

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $data = $form->getData();
    $address = $data['Email'];
       // $data = $form->getData();
        //dd($data);
$emailBody = "Nom: {$data['Nom']}<br>";
$emailBody .= "Prénom: {$data['prenom']}<br>";
$emailBody .= "Email: {$data['Email']}<br>";
$emailBody .= "Numéro de téléphone: {$data['Numero']}<br>";
$emailBody .= "Adresse: {$data['Adresse']}<br>";
$emailBody .= "Profession: {$data['profession']}<br>";
$emailBody .= "Statut professionnel: {$data['StatutProfessionnel']}<br>";
$emailBody .= "Les Renseignements: {$data['LesRenseignement']}<br>";
$emailBody .= "Nom: {$data['Nom']}<br>";
$emailBody .= "Prénom: {$data['Prenom']}<br>";
$emailBody .= "Profession: {$data['Profession']}<br>";
$emailBody .= "Établissement employeur: {$data['etablissementEmployeur']}<br>";
$emailBody .= "Revenu mensuel autres activités: {$data['revenuMensuelAutresActivites']}<br>";
$emailBody .= "Revenu mensuel net: {$data['revenuMensuelNet']}<br>";
$emailBody .= "Situation actuelle: {$data['situationActuelle']}<br>";
$emailBody .= "De préférence à: {$data['dePreferenceA']}<br>";
$emailBody .= "Projet SEIMAD: {$data['projetSEIMAD']}<br>";
$emailBody .= "Type de maison: {$data['typeMaison']}<br>";
$emailBody .= "Surface de la parcelle: {$data['surfaceParcelle']}<br>";
$emailBody .= "Surface habitable de la maison: {$data['surfaceHabitableMaison']}<br>";
$emailBody .= "Estimation d'achat: {$data['estimationAchat']}<br>";
$emailBody .= "Modalité de paiement: {$data['modalitePaiement']}<br>";
$emailBody .= "Banque: {$data['banque']}<br>";
$emailBody .= "Premier versement: {$data['premierVersement']}<br>";
$emailBody .= "Possibilité de paiement mensuel: {$data['possibilitePaiementMensuel']}<br>";
$emailBody .= "Acceptation traitement données: " . ($data['acceptationTraitementDonnees'] ? 'Oui' : 'Non') . "<br>";

        $email = (new Email())
            ->from($address)
            ->to('tommyhas743@gmail.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('')
            ->html($emailBody);

        $mailer->send($email);

            return $this->redirectToRoute('app_manifesat_interet'); // Redirection après soumission du formulaire
        }

    

    return $this->render('manifesat_interet/index.html.twig', [
        'form' => $form->createView(),
    ]);
}
}