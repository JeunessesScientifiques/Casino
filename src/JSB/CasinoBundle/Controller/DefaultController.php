<?php

namespace JSB\CasinoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use JSB\CasinoBundle\Form\TransactionType;
use JSB\CasinoBundle\Entity\Transaction;


class DefaultController extends Controller {

    /**
     * @Route("/", name="index")
     * @Template()
     */
    public function indexAction() {
        $personneRepo = $this->getDoctrine()->getRepository("JSB\CasinoBundle\Entity\Personne");

        $personnes = $personneRepo->findAll();

        return $this->render('JSBCasinoBundle:Default:index.html.twig',array('personnes' => $personnes));
    }

    /**
     * 
     * @Route("/account/{id}", requirements={"id" = "\d+"}, name="transactions")
     * @Template()
     */
    public function transactionsViewAction($id) {
        $transactionRepo = $this->getDoctrine()->getRepository("JSB\CasinoBundle\Entity\Transaction");
        $transactions = $transactionRepo->findBy(array("personne" => $id), array('dateHeure' => "ASC"));

        $solde = 0;

        foreach ($transactions as $transaction) {
            $solde += $transaction->getMontant();
        }

        return array(
            'transactions' => $transactions,
            'solde' => $solde
        );
    }

    /**
     * 
     * @Route("/addTransaction/{idPersonne}", requirements={"idPersonne" = "\d+"}, name="newTransaction")
     * 
     * @Template()
     */
    public function addTransactionAction(Request $request, $idPersonne) {
        $personneRepo = $this->getDoctrine()->getRepository("JSB\CasinoBundle\Entity\Personne");
        $personne = $personneRepo->find($idPersonne);
        
        $transaction = new Transaction();
        $transaction->setDescription("Opération en banque");
        
        $form = $this->createForm(new TransactionType(), $transaction);
        
        $form->add("Bingo !", "submit");

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $transaction = $form->getData();
            
            
            $transaction->setPersonne($personne);
            
            $this->getDoctrine()->getManager()->persist($transaction);
            $this->getDoctrine()->getManager()->flush();
            
            $this->addFlash("success", "La transaction a bien été enregistrée ;-)");
            
            return $this->indexAction();
        }
        
        return array("form" => $form->createView(),"personne"=>$personne);
    }
    
    /**
     * 
     * @Route("/nouveauTour/{i}", name="newTour", requirements={"i" = "\d+"})
     */
    public function nouveauTourAction($i){
        $personnesRepo = $this->getDoctrine()->getRepository("JSB\CasinoBundle\Entity\Personne");
        $personnes = $personnesRepo->findAll();
        
        $manager = $this->getDoctrine()->getManager();
        $tauxPositif = $i/1000;
        $tauxNegatif = round($tauxPositif * 1.75 , 2);
        
        foreach($personnes as $personne){
            
            $solde = $personne->getSolde();
            $temp = new Transaction();
            
            $temp->setPersonne($personne);
            
            if($solde>=0)
            {
                $temp->setMontant($solde * $tauxPositif);
                $temp->setDescription("Taux d'interet de fin de tour. Taux d'interet appliqué : ".($i/10)."% et le solde : $solde");
            } else {
                $temp->setMontant($solde * $tauxNegatif);
                $temp->setDescription("Taux de prêt d'argent pour une dette en fin de tour. Taux d'interêt appliqué ". ($tauxNegatif*100) ." % et le solde en fin de tour : $solde "); 
            }
            
            $manager->persist($temp);
        }
        
        $manager->flush();
        
        $this->addFlash("success", "Nous sommes passé au prochain tour");
        
        return $this->redirect($this->generateUrl("index"));
    }

}
