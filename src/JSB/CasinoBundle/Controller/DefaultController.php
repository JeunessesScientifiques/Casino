<?php

namespace JSB\CasinoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use JSB\CasinoBundle\Form\TransactionType;
use JSB\CasinoBundle\Entity\Transaction;
use JSB\CasinoBundle\Form\PartType;
use JSB\CasinoBundle\Entity\Part;

class DefaultController extends Controller {

    /**
     * @Route("/", name="index")
     * @Template()
     */
    public function indexAction() {
        $personneRepo = $this->getDoctrine()->getRepository("JSB\CasinoBundle\Entity\Personne");

        $personnes = $personneRepo->findAll();

        return $this->render('JSBCasinoBundle:Default:index.html.twig', array('personnes' => $personnes));
    }

    /**
     * 
     * @Route("/account/{id}", requirements={"id" = "\d+"}, name="transactions")
     * @Template()
     */
    public function transactionsViewAction($id) {
        $transactionRepo = $this->getDoctrine()->getRepository("JSB\CasinoBundle\Entity\Transaction");
        $transactions = $transactionRepo->findBy(array("personne" => $id), array('dateHeure' => "DESC"));

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

        return $this->render("JSBCasinoBundle:Default:form.html.twig", array("form" => $form->createView(), "personne" => $personne));
    }

    /**
     * 
     * @Route("/nouveauTour/{i}", name="newTour", requirements={"i" = "\d+"})
     */
    public function nouveauTourAction($i) {
        $personnesRepo = $this->getDoctrine()->getRepository("JSB\CasinoBundle\Entity\Personne");
        $personnes = $personnesRepo->findAll();

        $manager = $this->getDoctrine()->getManager();
        $tauxPositif = $i / 1000;
        $tauxNegatif = round($tauxPositif * 1.75, 2);

        foreach ($personnes as $personne) {

            $solde = $personne->getSolde();
            $temp = new Transaction();

            $temp->setPersonne($personne);

            if ($solde >= 0) {
                $temp->setMontant($solde * $tauxPositif);
                $temp->setDescription("Taux d'interet de fin de tour. Taux d'interet appliqué : " . ($i / 10) . "% et le solde : $solde");
            } else {
                $temp->setMontant($solde * $tauxNegatif);
                $temp->setDescription("Taux de prêt d'argent pour une dette en fin de tour. Taux d'interêt appliqué " . ($tauxNegatif * 100) . " % et le solde en fin de tour : $solde ");
            }
            
            $parts = $personne->getParts();
            
            foreach($parts as $part){
                
                $transaction = new Transaction();
                $transaction->setDescription("Dividende de la part de l'entreprise ".$part->getEntreprise()->getNom());
                $transaction->setMontant($tauxPositif * 1.4 * $part->getEntreprise()->getValeur() / 10);
                $transaction->setPersonne($personne);
                
                $manager->persist($transaction);
            }

            $manager->persist($temp);
        }

        $manager->flush();

        $this->addFlash("success", "Nous sommes passé au prochain tour");

        return $this->redirect($this->generateUrl("index"));
    }

    /**
     * @Route("/entreprises", name="viewEntreprise")
     * @Template()
     */
    public function listEntrepriseAction() {

        $entrepriseRepo = $this->getDoctrine()->getRepository("JSB\CasinoBundle\Entity\Entreprise");
        $entreprises = $entrepriseRepo->findAll();

        return array("entreprises" => $entreprises);
    }

    /**
     * @Route("/addPart/{idEntreprise}", requirements={ "idEntreprise" : "\d+" },  name="entreprise")
     */
    public function addPart(Request $request, $idEntreprise) {
        $entrepriseRepo = $this->getDoctrine()->getRepository("JSB\CasinoBundle\Entity\Entreprise");
        $entreprise = $entrepriseRepo->find($idEntreprise);

        $part = new Part();
        $part->setEntreprise($entreprise);

        $form = $this->createForm(new PartType(), $part);

        $form->add("Bingo !", "submit");

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();

            $part = $form->getData();
            
            $transaction = new Transaction();
            $transaction->setDescription("Achat d'une part de l'entreprise ".$entreprise->getNom());
            $transaction->setMontant($entreprise->getValeur()/-10);
            $transaction->setPersonne($part->getProprietaire());

            $manager->persist($part);
            $manager->persist($transaction);
            $manager->flush();
            
            $this->addFlash("success", "La part a bien été achetée");
            
            return $this->redirect($this->generateUrl("viewEntreprise"));
        }

        return $this->render("JSBCasinoBundle:Default:form.html.twig", array("form" => $form->createView()));
    }
    
    /**
     * @Route("/viewPart/{idEntreprise}", requirements={ "idEntreprise" : "\d+" },  name="viewPart")
     * @Template()
     */
    public function viewPartAction($idEntreprise){
        $parts = $this->getDoctrine()->getRepository("JSB\CasinoBundle\Entity\Part")->findBy(array('entreprise'=>$idEntreprise));
        
        return array("parts"=>$parts);
    }
    
    /**
     * @Route("/revendrePart/{idPart}", requirements={ "idPart" : "\d+" },  name="revendrePart")
     */
    public function deletePart($idPart){
        
        $part = $this->getDoctrine()->getRepository("JSB\CasinoBundle\Entity\Part")->find($idPart);
        
        $transaction = new Transaction();
        $transaction->setMontant($part->getEntreprise()->getValeur() * 0.85 / 10);
        $transaction->setPersonne($part->getProprietaire());
        $transaction->setDescription("Revente d'une part dans l'entreprise ".$part->getEntreprise()->getNom());
        
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($part);
        $manager->persist($transaction);
        
        $manager->flush();
        
        $this->addFlash("success", "La part a bien été revendue");
        
        return $this->redirect($this->generateUrl("viewEntreprise"));
        
    }

}
