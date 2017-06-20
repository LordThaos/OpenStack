<?php
namespace OpenStack\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

class SecurityController extends Controller
{
  public function loginAction(Request $request)
  {
    // Si le visiteur est déjà identifié, on le redirige vers l'accueil
    if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
      return $this->redirectToRoute('openstack_commande_homepage');
    }
    
    // Le service authentication_utils permet de récupérer le nom d'utilisateur
    // et l'erreur dans le cas où le formulaire a déjà été soumis mais était invalide
    // (mauvais mot de passe par exemple)
    $authenticationUtils = $this->get('security.authentication_utils');

    return $this->render('OpenStackUserBundle:Security:login.html.twig', array(
      'last_username' => $authenticationUtils->getLastUsername(),
      'error'         => $authenticationUtils->getLastAuthenticationError(),
    ));
  }
  
  
  /*public function inscriptionAction()
    {
        $user = new User();
        
        /*$formBuilder = $this->createFormBuilder($user)
                ->add('login', 'text', array('label' => "Nom d'utilisateur"))
                ->add('password', 'text', array('label' => 'Mot de passe'))
                ->add('nom', 'text', array('label' => 'Nom'))
                ->add('prenom', 'text', array('label' => 'Prénom'))
                ->add('adresse', 'text', array('label' => 'Adresse'))
                ->add('dateNaissance', 'date', array('label' => 'Date de naissance'))
                ->add('email', 'email', array('label' => 'Adresse mail'))
                ->add('Valider', 'submit');
        
        $form = $formBuilder->getForm();
        
        $request = $this->get('request');
        
        if($request->getMethod() == 'POST') {
            
            $form->bind($request);
            
            if($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
            
                $this->get('session')->getFlashBag()->add('info', 'Inscription réussie');
                
                return $this->redirect($this->generateUrl('openstack_commande_homepage'));
            }
        }      
        
        //return $this->render('OpenStackcommandeBundle:Commande:inscription.html.twig', array('form' => $form->createView()));
        
    }*/
  
}