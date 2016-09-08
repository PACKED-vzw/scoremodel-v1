<?php
namespace Packed\Bundle\ScoreModelBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Packed\Bundle\ScoreModelBundle\Entity\Rapport;
use Packed\Bundle\ScoreModelBundle\Entity\Inhoud;
use Packed\Bundle\ScoreModelBundle\Form\RapportType;
use Packed\Bundle\ScoreModelBundle\Entity\Document;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * AdministrationInterface controller.
 *
 */
class AiController extends Controller
{
   /**
    *
    * toont de mogelijke beheeropties
    *
    */
   public function beheerIndexAction(){
       $t = "test";
       return $this->render('ScoreModelBundle:Rapport:aiBeheerIndex.html.twig', array(
           'introtekst' => $t,
       ));
   }



    /**
     *
     * toont lijst gebruikers
     */
    public function gebruikersIndexAction(){

        $gebruikers = $this->getDoctrine()->getRepository('UserBundle:User')->findAll();
        return $this->render('ScoreModelBundle:Rapport:aiGebruikersIndex.html.twig', array(
            'gebruikers' => $gebruikers,
        ));

    }


    /**
     * Toont info over gebruiker
     *
     */
    public function toonGebruikerAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $gebruiker = $em->getRepository('UserBundle:User')->find($id);

        if (!$gebruiker) {
            throw $this->createNotFoundException('Gebruiker kon niet gevonden worden');
        }

        //$deleteForm = $this->createDeleteForm($id);

        return $this->render('ScoreModelBundle:Rapport:aiShowGebruiker.html.twig', array(
            'gebruiker'      => $gebruiker,
            /*'delete_form' => $deleteForm->createView(),*/        ));
    }

    /**
     * Verwijdert gebruiker
     *
     */
    public function verwijderGebruikerAction($id)
    {
        if ($id != 0){
            $em          = $this->getDoctrine()->getManager();
            $gebruiker   = $em->getRepository('UserBundle:User')->find($id);


            $anoniem     = $em->getRepository('UserBundle:User')->findOneByUsername("anoniem");
            $rapporten   = $em->getRepository('ScoreModelBundle:Rapport')->findByGebruiker($gebruiker);
            // anonieme gebruikers kunnen niet verwijderd worden
            if ($gebruiker->getUsername()=="anoniem"||$gebruiker->getUsername()=="anonymous"||in_array("ROLE_ADMIN", $gebruiker->getRoles())){
                echo "Anonieme gebruikers en administrators kunnen niet verwijderd worden. Mail naar joris@packed.be"; die;
            }
            // alle rapporten naar anonieme gebruiker overzetten
            foreach ($rapporten as $rapport){
                $rapport->setGebruiker($anoniem);
                $em->persist($rapport);
            }
            $em->flush();

            $userManager = $this->container->get('fos_user.user_manager');
            $userManager->deleteUser($gebruiker);
            echo "Gebruiker verwijderd"; die;
        }
    }


    /**
     *
     * documenten beheren action
     *
     */
    public function documentenBeherenAction(){

        $document = new Document();
        $em = $this->getDoctrine()->getEntityManager();
        $form = $this->createFormBuilder($document)
            ->add('name', null, array('label'=>'Naam'))
            ->add('file', null, array('label'=>'Bestand'))
            ->add('beschrijvingNl', null, array('label'=>'Beschrijving NL'))
            ->add('beschrijvingEn', null, array('label'=>'Beschrijving EN'))
            ->getForm();

        if ($this->getRequest()->getMethod() === 'POST') {
            $form->bindRequest($this->getRequest());
            if ($form->isValid()) {




                $document->upload();

                $em->persist($document);
                $em->flush();

                $documents = $em->getRepository('ScoreModelBundle:Document')->findAll();

           return $this->render('ScoreModelBundle:Rapport:aiDocumentenBeheren.html.twig', array(
                'succes'         => "ok",
                'form'           => $form->createView(),
                'documents'      => $documents
            ));
        }
        }


        $documents = $em->getRepository('ScoreModelBundle:Document')->findAll();


        return $this->render('ScoreModelBundle:Rapport:aiDocumentenBeheren.html.twig', array(
            'form'           => $form->createView() ,
            'documents'      => $documents
                ));
    }





    /**
     *
     * statistieken
     *
     */
    public function statistiekenAction(){

        $sectieRepository = $this->getDoctrine()
            ->getRepository('ScoreModelBundle:Sectie');
        $secties = $sectieRepository->findAll();


        return $this->render('ScoreModelBundle:Rapport:aiStatistieken.html.twig', array(
               'secties' => $secties
        ));
    }


    /*
     * export sectie
     *
     */
    public function exportCsvAction($sectieId, $taal){
        /*$request = $this->getRequest();
        $sectieId = $request->get("sectie");
        $taal     = $request->get("taal"); */

        $sectieRepository = $this->getDoctrine()
            ->getRepository('ScoreModelBundle:Sectie');
        $sectie = $sectieRepository->find($sectieId);
        $eisen = $sectie->getEisen();
        $divider = '";"';

        $csvOutput = '"';  // start with enclosing

        if($taal=="nederlands"){
            $headerArrayNl = array("id", "vraag", "risicofactor", "context", "risico's", "voorbeeld", "doorverwijzing", "bronnen en voorbeelden");

            $csvOutput .= implode($divider, $headerArrayNl) . '"';
            $naam = $sectie->getWaarde();
            foreach($eisen as $eis){
                $csvOutputRow = array(
                    $eis->getID(),  // geen EN
                    $eis->getWaarde(),
                    $eis->getRisiconiveau(), // geen EN
                    $eis->getContext(),
                    $eis->getRisico(),
                    $eis->getVoorbeeld(),
                    $eis->getActie(),
                    $eis->getBronnen()
                );
                $csvOutput .= "\n" . '"' . implode($divider,$csvOutputRow);
                $csvOutput .= '"';
            }
        }
        else if($taal=="english"){
            $headerArrayEn = array("id", "demand", "risk level", "context", "risks", "example", "actions", "source and examples");

            $csvOutput .= implode($divider, $headerArrayEn) . '"';
            $naam = $sectie->getWaardeEn();
            foreach($eisen as $eis){
                $csvOutputRow = array(
                    $eis->getID(),  // geen EN
                    $eis->getWaardeEn(),
                    $eis->getRisiconiveau(), // geen EN
                    $eis->getContextEn(),
                    $eis->getRisicoEn(),
                    $eis->getVoorbeeldEn(),
                    $eis->getActieEn(),
                    $eis->getBronnenEn()
                );
                $csvOutput .= "\n" . '"' . implode($divider,$csvOutputRow);
                $csvOutput .= '"';
            }
        }



        $response = new Response();
        $response->headers->set('Content-Type', 'text/csv');
        $response->setStatusCode(200);
        $response->headers->set('Content-Disposition',
            sprintf('attachment;filename="%s.csv"', $naam));
        $response->setContent($csvOutput);

        return $response;

    }


    /**
     *
     * Beheren van statische inhoud
     *
     */
    public function statischeInhoudBeherenAction()
    {

        $em = $this->getDoctrine()->getManager();
        $inhoud = $em->getRepository('ScoreModelBundle:Inhoud')->findAll();
        $aantal = count($inhoud);
        if($aantal==0){
            $welkomsttekst = new Inhoud();
            $welkomsttekst->setNaam("welkomsttekst");
            $welkomsttekst->setWaarde("welkom");
            $welkomsttekst->setWaardeEn("welcome");
            $em->persist($welkomsttekst);

            $faqintro = new Inhoud();
            $faqintro->setNaam("faqintro");
            $faqintro->setWaarde("test");
            $faqintro->setWaardeEn("test");
            $em->persist($faqintro);

            $faq = new Inhoud();
            $faq->setNaam("faq");
            $faq->setWaarde("vraag1");
            $faq->setWaardeEn("question1");
            $em->persist($faq);

            $disc = new Inhoud();
            $disc->setNaam("disclaimer");
            $disc->setWaarde("disclaimer nl");
            $disc->setWaardeEn("disclaimer en");
            $em->persist($disc);
            $em->flush();

            $inhoud = $em->getRepository('ScoreModelBundle:Inhoud')->findAll();
        }



        foreach ($inhoud as $inh){
            switch ($inh->getNaam()){
                case "welkomsttekst":
                    $welkomsttekst = $inh;
                    break;
                case "faq":
                    $faq = $inh;
                    break;
                case "faqintro":
                    $faqintro = $inh;
                    break;
                case "disclaimer":
                    $disclaimer = $inh;
                    break;
            }

        }

        //print_r($inhoud);die;

        return $this->render('ScoreModelBundle:Rapport:aiStatischeInhoud.html.twig', array(
         'welkomsttekst' => $welkomsttekst,
         'faq' => $faq,
         'faqintro' => $faqintro,
         'disclaimer' => $disclaimer,
        ));
    }
     /**
      *
      * @param \Symfony\Component\HttpFoundation\Request $request
      * @return \Symfony\Component\HttpFoundation\Response
      * Wijzigen van statische inhoud mbv ajax
      *
      */
     public function  statischeInhoudWijzigenAction(Request $request){

         $response = new Response();
         $tekst = $request->get('wijzig_tekst');
         $wijzig = explode("_", $request->get('wijzig'));

         $naamElement = $wijzig[0];
         $taal = $wijzig[1];

         $em = $this->getDoctrine()->getManager();
         $inhoud = $em->getRepository('ScoreModelBundle:Inhoud')->findOneByNaam($naamElement);

         if($taal=="en"){
             $inhoud->setWaardeEn($tekst);
         }
         elseif($taal=='nl'){
             $inhoud->setWaarde($tekst);

         }
         $em->persist($inhoud);
         $em->flush();

         $response->setContent($tekst);
         return $response;
     }

    /**
     *
     * Beheren van secties en eisen  (vragen)
     *
     */
    public function sectiesEnEisenBeherenAction(){

        $secties = $this
            ->get('doctrine')
            ->getEntityManager()
            ->createQuery('SELECT s FROM ScoreModelBundle:Sectie s ORDER BY s.volgorde ASC')
            ->getResult();


        /*$eisenRepository = $this->getDoctrine()
            ->getRepository('ScoreModelBundle:Eis');
        $eisen = $eisenRepository->findAll();*/

        $eisen =   $this
            ->get('doctrine')
            ->getEntityManager()
            ->createQuery('SELECT e FROM ScoreModelBundle:Eis e ORDER BY e.volgorde ASC')
            ->getResult();

        $sectie_dubbels = $this->checkForDoubles($secties);
        $eisen_dubbels = FALSE;
        foreach ($secties as $sect){
        if($this->checkForDoubles($sect->getEisen())==TRUE){
            $eisen_dubbels = TRUE;
            break;
        }
        }


        return $this->render('ScoreModelBundle:Rapport:aiSectiesEnEisen.html.twig', array(
            'secties'=>$secties,
            'sectie_dubbels'=>$sectie_dubbels,
            'eisen_dubbels'=>$eisen_dubbels,
            'eisen'=>$eisen

        ));
    }
    /**
     *
     * dubbels in volgorde controleren ...
     *
     */
    private function checkForDoubles($result){
        $result_vids = array();     // sectie volgorde ids
        foreach($result as $res){
            $id = $res->getVolgorde();
            if(in_array($id,$result_vids)){
               return TRUE;
            }
            else{
                $result_vids[]=$id;
            }

        }
        return FALSE;
    }


}
