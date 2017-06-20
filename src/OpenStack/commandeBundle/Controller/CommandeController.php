<?php

namespace OpenStack\commandeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use OpenStack\commandeBundle\Entity\Commande;
use OpenStack\commandeBundle\Entity\Utilisateur;
use OpenStack\commandeBundle\Entity\User;

class CommandeController extends Controller
{
    public function indexAction()
    {
        $repository = $this->getDoctrine()
                ->getManager()
                ->getRepository('OpenStackcommandeBundle:Produit');
        $listeProduits = $repository->findAll();
        
        return $this->render('OpenStackcommandeBundle:Commande:index.html.twig', array('listeProduits' => $listeProduits));
    }
    
    
    public function listeProduitsAction()
    {
        $repository = $this->getDoctrine()
                ->getManager()
                ->getRepository('OpenStackcommandeBundle:Produit');
        $listeProduits = $repository->findAll();
        
        return $this->render('OpenStackcommandeBundle:Commande:listeproduits.html.twig', array('listeProduits' => $listeProduits));
    }
    
    
    
    public function commandeAction()
    {
        /*$listeCategories = $this->getDoctrine()
                ->getManager()
                ->getRepository('OpenStackcommandeBundle:Categorie')
                ->findAll();*/
        
        $formBuilderProduits = $this->createFormBuilder();
        
        $listeProduits = $this->getDoctrine()
                ->getManager()
                ->getRepository('OpenStackcommandeBundle:Produit')
                ->findAll();
        
        //foreach ($listeCategories as $Categorie){
            
            /*$idCategorie = $Categorie->getId();
            
            $listeProduits = $this->getDoctrine()
                ->getManager()
                ->getRepository('OpenStackcommandeBundle:Produit')
                ->find($idCategorie);*/
            
            //$form = $this->createFormBuilder($listeProduits);
            $formBuilder = $this->get('form.factory')->createNamedBuilder('listeProduits', 'form', $listeProduits);
            
            $formBuilder->add('produit', 'entity', array('class' => 'OpenStackcommandeBundle:Produit', 
                        'property' => 'nom', 
                        'multiple' => false,
                        'empty_value' => '- Choisissez un produit -'))
                    ->add('Confirmer', 'submit');
            
            $formBuilderProduits->add($formBuilder);
        //}
        
        $form = $formBuilderProduits->getForm();
        
        $request = $this->getRequest();
        if($request->getMethod() == 'POST'){
            $form->bind($request);
            if($form->isValid()){
               $id = $form['listeProduits']['produit']->getData()->getId();  // On récupère l'id du produit sélectionné
               return $this->redirect($this->generateUrl('openstack_commande_valider', array('id' => $id)));
            }
        }
        
        
        return $this->render('OpenStackcommandeBundle:Commande:commande.html.twig', array('form' => $form->createView()));
        //return $this->render('OpenStackcommandeBundle:Commande:commande.html.twig', array('listeCategories' => $listeCategories, 'form' => $form->createView()));
    }
    
    
    public function validerAction($id)
    {
        $produit = $this->getDoctrine()
                ->getManager()
                ->getRepository('OpenStackcommandeBundle:Produit')
                ->find($id);
        
        $commande = new Commande();
        $commande->setIdUser(1);
        $commande->setIdProd($produit->getId());
        $commande->setDate(new \DateTime());
        
        if ($produit == null)
        {
            throw $this->createNotFoundException("Produit[id='$id'] inexistant.");
        }
        
        $formBuilder= $this->createFormBuilder($commande)
                ->add('Commander', 'submit');
        
        $form = $formBuilder->getForm();
        
        $request = $this->getRequest();
        if($request->getMethod() == 'POST'){
            $form->bind($request);
            if($form->isValid()){
               $em = $this->getDoctrine()->getManager();
               $em->persist($commande);
               $em->flush();
               
               // Envoi de mail à la validation de la commande
                $message = \Swift_Message::newInstance()
                    ->setSubject('Validation de votre commande')
                    ->setFrom(array('anderson.luc69@gmail.com' => 'Anderson Luc'))
                    ->setTo('anderson.luc69@gmail.com')
                    ->setCharset('utf-8')
                    ->setContentType('text/html')
                    ->setBody($this->renderView('OpenStackcommandeBundle:Commande:mail.html.twig', array('commande' => $commande)));

                $this->get('mailer')->send($message);
                
               
               $this->get('session')->getFlashBag()->add('info', 'Commande envoyée');
               return $this->redirect($this->generateUrl('openstack_commande_homepage'));
            }
        }
        
        
        return $this->render('OpenStackcommandeBundle:Commande:valider.html.twig', array('produit' => $produit, 'form' => $form->createView()));

    }
    
    
}