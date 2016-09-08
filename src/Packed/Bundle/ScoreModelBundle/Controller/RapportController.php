<?php

namespace Packed\Bundle\ScoreModelBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Packed\Bundle\ScoreModelBundle\Entity\Rapport;
use Packed\Bundle\ScoreModelBundle\Form\RapportType;


use Packed\Bundle\ScoreModelBundle\Utils\TekenGrafiek;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Rapport controller.
 *
 */
class RapportController extends Controller
{



   /*
    * Deze methode doet enkel de berekening, score aanpassen gebeurt in functie puntenSchrijven
    *
    *
    */
   public function berekenPunten($score) {
       $em = $this->getDoctrine()->getManager();
        $puntenarray = array();

        foreach ($score as $sectieId=>$eisenArray){

            $A = $B = $C = 0;  // aantal
            $okA = $okB = $okC = 0; // aantal correcte
            $puntenPerA = $puntenPerB = $puntenPerC = 0;
            foreach ($eisenArray as $eisId=>$punt){
                if($eisId == 'totaal') break;
                $punt=trim($punt);
                $eis = $em->getRepository('ScoreModelBundle:Eis')->find($eisId);
                switch ($eis->getRisiconiveau()){
                    case "A":
                        $A++;
                        if($punt=="ja")
                        {$okA++;}
                        break;
                    case "B":
                        $B++;
                        if($punt=="ja")
                        {$okB++;}
                        break;
                    case "C":
                        $C++;
                        if($punt=="ja")
                        {$okC++;}
                        break;
                }
                }
            if($A!=0) $puntenPerA = 60 / $A;
            if($B!=0) $puntenPerB = 30 / $B;
            if($C!=0) $puntenPerC = 10 / $C;
            $totaal = ($puntenPerA*$okA);
            // als alle A zijn ingevuld wordt B erbij geteld
            if($A==$okA){
                $totaal += ($puntenPerB*$okB);
                // als alle B zijn ingevuld wordt C erbij geteld
                if($B==$okB){
                    $totaal += $puntenPerC*$okC;
                }
            }

            $score[$sectieId]['totaal'] = $totaal;

            // reset
            $A = $B = $C = 0;
            $okA = $okB = $okC = 0;
            $puntenPerA = $puntenPerB = $puntenPerC = 0;
        }
       return $score;
   }

   public function puntenInitialiseren($rapport){
       // 1. foreach

       // syntax van array waar score wordt bijgehouden
       // array([idsectie]=>array([id_eis]=>[score], [6]=>[8], [totaal]=>[totaal van behaald] )
       // score aanmaken
       $em = $this->getDoctrine()->getManager();

       $score = array();
       $sectieRepository = $this->getDoctrine()
           ->getRepository('ScoreModelBundle:Sectie');
       $eisenRepository = $this->getDoctrine()
           ->getRepository('ScoreModelBundle:Eis');
       $secties= $sectieRepository->findAll();


       foreach($secties as $sectie){
           $score[$sectie->getId()] = array();
           $eisen = $eisenRepository->findBy(
               array('sectie'=>$sectie->getId())
           );
           foreach($eisen as $eis){
               $score[$sectie->getId()][$eis->getId()] = "nee";
           }
           $score[$sectie->getId()]['totaal'] = 0;
       }
       $score = serialize($score);
       $rapport->setScore($score);

       $em->persist($rapport);
       $em->flush();
   }

   public function puntenSchrijven($rapport, $eisId, $sectieId, $waarde){
       $em = $this->getDoctrine()->getManager();
       $score = unserialize($rapport->getScore());
       $score[$sectieId][$eisId] = $waarde;
       $rapport->setScore(serialize($score));
       $em->persist($rapport);
       $em->flush();
   }

   private function berekenPuntenRisiconiveau($risiconiveau){
       $punt = 0;
       switch ($risiconiveau){
           case 'A':
               $punt=12;
               break;
           case 'B':
               $punt=8;
               break;
           case 'C':
               $punt=4;
               break;
       }
       return $punt;
   }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * berekent de score op de sectiepagina mbv ajax
     *
     */
   public function berekenscoreajaxAction(Request $request){

       $em = $this->getDoctrine()->getManager();
       $eis = explode("_", $request->get('eis'));

       $waarde = $eis[0]; //ja of nee
       $eis = $eis[1];

       //$eis = $em->getRepository('ScoreModelBundle:Eis')->find($eis);
       $rapport = $em->getRepository('ScoreModelBundle:Rapport')->find($request->get('rapport'));


       $this->puntenSchrijven($rapport, $eis, $request->get('sectie'), $waarde);

       $score = $this->berekenPunten(unserialize($rapport->getScore()));

       $rapport->setScore(serialize($score));
       $em->persist($rapport);
       $em->flush();
       $behaald = number_format($score[$request->get('sectie')]['totaal']);
       $score = array('behaald'=>$behaald,'totaal'=>100);

       $response = new Response();
       $response->setContent(json_encode($score));
       return $response;

   }

    /**
     * Faq
     *
     */
    public function faqAction()
    {
        $em = $this->getDoctrine()->getManager();
        $faq = $em->getRepository('ScoreModelBundle:Inhoud')->findOneByNaam('faq');
        $faq_intro = $em->getRepository('ScoreModelBundle:Inhoud')->findOneByNaam('faqintro');
        return $this->render('ScoreModelBundle:Rapport:faq.html.twig', array(
            'faq' => $faq,
            'faqintro' => $faq_intro
        ));
    }



    /**
     * documenten
     *
     */
    public function documentenAction()
    {

        $em = $this->getDoctrine()->getManager();
        $documents = $em->getRepository('ScoreModelBundle:Document')->findAll();



        return $this->render('ScoreModelBundle:Rapport:documenten.html.twig', array(

            'documents' => $documents

        ));
    }

    /**
     * disclaimer
     *
     */
    public function disclaimerAction()
    {
        $em = $this->getDoctrine()->getManager();
        $disclaimer = $em->getRepository('ScoreModelBundle:Inhoud')->findOneByNaam('disclaimer');

        return $this->render('ScoreModelBundle:Rapport:disclaimer.html.twig', array(
            'disclaimer' => $disclaimer


        ));
    }

    /**
     * Homepagina
     *
     */
    public function homeAction()
    {


        $rapporten = array();
        $em = $this->getDoctrine()->getManager();
        $welkomsttekst = $em->getRepository('ScoreModelBundle:Inhoud')->findOneByNaam('welkomsttekst');
        if( $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY') ){
            $gebruiker_id = $this->getUser()->getId();
            $rapporten= $this
                ->get('doctrine')
                ->getEntityManager()
                ->createQuery('SELECT r FROM ScoreModelBundle:Rapport r WHERE r.gebruiker = :gebruiker_id ORDER BY r.id DESC')
                ->setParameter('gebruiker_id', $gebruiker_id)
                ->setMaxResults(5)
                ->getResult();
        }

        return $this->render('ScoreModelBundle:Rapport:home.html.twig', array(
            'introtekst' => $welkomsttekst,
            'rapporten' => $rapporten
        ));
    }

    /**
     * controller stap1 gegevens
     *
     */
    public function stap1Action($id)
    {
        $em = $this->getDoctrine()->getManager();

        // $id = 0 als er geen rapport bestaat
        if($id>0){
            $rapport = $em->getRepository('ScoreModelBundle:Rapport')->find($id);
            if (!$rapport) {
                throw $this->createNotFoundException('Kan rapport niet vinden.');
            }
        }
        //maak een nieuw rapport aan
        else {
        $rapport = new Rapport();
        // TODO: moet dit niet in een constructor komen ????

        $rapport->setDatumGeneratie(new \DateTime("now"));
        $rapport->setGebruiker($this->getUser());
        $em->persist($rapport);
        $em->flush();
        $this->puntenInitialiseren($rapport);

        }

        if($rapport->getGebruiker()->getId()==$this->getUser()->getId()||$this->get('security.context')->isGranted('ROLE_ADMIN')==true){
           return $this->render('ScoreModelBundle:Rapport:stap1gegevens.html.twig', array(
               'rapport' => $rapport
           ));
        }
        else {
            throw new AccessDeniedException();
        }

    }

    /**
     * controller secties
     *
     */
    public function sectieAction($id,$sid)
    {
        $request = $this->getRequest();

        $em = $this->getDoctrine()->getManager();

            $rapport = $em->getRepository('ScoreModelBundle:Rapport')->find($id);
        if($request->request->get('naamrapport')!=""){
        $rapport
                ->setNaam($request->request->get('naamrapport'));
        }

            $em->persist($rapport);
            $em->flush();

            $secties = $this
                ->get('doctrine')
                ->getEntityManager()
                ->createQuery('SELECT s FROM ScoreModelBundle:Sectie s ORDER BY s.volgorde ASC')
                ->getResult();
            $aantal = count($secties);

        // percentage berkenen
        // $sid => moet hier key van secties zijn en niet ...
         /*$volgordeId = $id;
         $huidigeSectie = $em->getRepository('ScoreModelBundle:Sectie')->findByVolgorde($sid);

         // echo count($sectie2);

        foreach($huidigeSectie as $sec){
             $sid = $sec->getId();
         }

        $volgendeSectie = $em->getRepository('ScoreModelBundle:Sectie')->findByVolgorde($volgordeId + 1);
        foreach($huidigeSectie as $sec){
            $volgendeSectieId = $sec->getId();
        }

        $vorigeSectie = $em->getRepository('ScoreModelBundle:Sectie')->findByVolgorde($volgordeId - 1);
        foreach($huidigeSectie as $sec){
            $vorigeSectieId = $sec->getId();
        }       */





        if ($aantal>0&&$sid>0&&$sid<=$aantal)    // aantal klopt hier niet ...
        {
            $percentage =  10 + ((90 / $aantal) * $sid);   // dit is percentage voor progressbalk
            $sectie = $secties[$sid-1];              // FOUT HIER VOLGENS MIJ ... dit is niet sectieid maar volgordeid ... ?

            //$volgende_sectie = $secties[$sid];
            if($sid<$aantal){
                $volgende_sectie = $secties[$sid];
            }
            else{
                $volgende_sectie['waarde']="Samenvattend overzicht";
                $volgende_sectie['waardeEn']="Summary";
                $volgende_sectie['id']=0;
            }


            if($sid!=1){
            $vorige_sectie = $secties[$sid-2];
          }
          else{
                $vorige_sectie['waarde']="Controleer je gegevens";
                $vorige_sectie['waardeEn']="Check general information";
                $vorige_sectie['id']=0;
          }

        }
       else {
            throw $this->createNotFoundException('Probleem met de geselecteerde sectie');
       }

        $score = unserialize($rapport->getScore());

	if ($rapport->getGebruiker()) {
        if($rapport->getGebruiker()->getId()==$this->getUser()->getId()||$this->get('security.context')->isGranted('ROLE_ADMIN')==true){
        return $this->render('ScoreModelBundle:Rapport:sectie.html.twig', array(
            'rapport' => $rapport,
            'id' => $rapport->getId() ,
            'percentage' => $percentage,
            'sectie' => $sectie,
            'vorige_sectie' => $vorige_sectie,
            'volgende_sectie' => $volgende_sectie,
            'aantal' => $aantal,
            'score' => $score

        ));
        }
        else {
            throw new AccessDeniedException();
        }
} else {
	throw new AccessDeniedException();
}
    }


    /**
     * controlepagina
     *
     */
    public function controleAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        if($id>0){
            $rapport = $em->getRepository('ScoreModelBundle:Rapport')->find($id);
            if (!$rapport) {
                throw $this->createNotFoundException('Kan rapport niet vinden.');
            }
        }
        $secties = $this
            ->get('doctrine')
            ->getEntityManager()
            ->createQuery('SELECT s FROM ScoreModelBundle:Sectie s ORDER BY s.volgorde ASC')
            ->getResult();

       $scoreRapport = unserialize($rapport->getScore());

       $sectiesMetPunten = array();
       foreach($scoreRapport as $sectieId=>$score){

           $sec = $em->getRepository('ScoreModelBundle:Sectie')->find($sectieId);
           // die berekenscore moet ook in entiteit komen ?
	if ($sec) {
           $sectiesMetPunten[$sectieId] = array(
               'id' => $sectieId,
               'volgorde' => $sec->getVolgorde(),
               'waarde' => $sec->getWaarde(),
               'waardeEn' => $sec->getWaardeEn(),
               'score' => $score['totaal']
           );
	}

       }
        if($rapport->getGebruiker()->getId()==$this->getUser()->getId()||$this->get('security.context')->isGranted('ROLE_ADMIN')==true){
        return $this->render('ScoreModelBundle:Rapport:controle.html.twig', array(
            'id' => $id,
            'rapport' => $rapport,
            'secties' => $sectiesMetPunten
        ));
        }
        else {
            throw new AccessDeniedException();
        }
    }

    /**
     * bewerk profiel
     *
     */
    public function bewerkProfielAction()
    {

        $gebruiker = $this->getUser();
        return $this->render('ScoreModelBundle:Rapport:aiBewerkProfiel.html.twig', array(
            'gebruiker'      => $gebruiker,
              ));
    }



    /**
     * toon rapporten
     *
     */
    public function toonRapportAction()
    {

        $gebruiker = $this->getUser();
        return $this->render('ScoreModelBundle:Rapport:aiShowGebruiker.html.twig', array(
            'gebruiker'      => $gebruiker,
        ));
    }

    /**
     * Toon rapporten voor gebruiker. Geeft een lijst van alle rapporten voor de ingelogde gebruiker.
     *
     */
    public function toonRapportenVoorGebruikerAction(){
        $gebruiker = $this->getUser();
        return $this->render('ScoreModelBundle:Rapport:toonRapportenVoorGebruiker.html.twig', array(
            'gebruiker'      => $gebruiker,
        ));
    }

    /**
     * rapport controller
     * toont rapport
     *
     *
     */
    public function rapportAction($id)
    {

        $format = $this->get('request')->get('_format');

        //$this->genereerGrafiek(); die;
        $em = $this->getDoctrine()->getManager();
        if($id>0){
            $rapport = $em->getRepository('ScoreModelBundle:Rapport')->find($id);
            if (!$rapport) {
                throw $this->createNotFoundException('Kan rapport niet vinden.');
            }
        }

       // $score = unserialize($rapport->getScore());
       // print_r($score);die;
        $secties = $this
            ->get('doctrine')
            ->getEntityManager()
            ->createQuery('SELECT s FROM ScoreModelBundle:Sectie s ORDER BY s.volgorde ASC')
            ->getResult();

        $score = unserialize($rapport->getScore());

        $sectienamen = array();
        $punten = array();
        foreach($score as $sectieId=>$scoreArray){
            $sectie = $em->getRepository('ScoreModelBundle:Sectie')->find($sectieId);
	if ($sectie) {
            $sectienamen[] = $sectie->getWaarde();
            $punten[]=$scoreArray['totaal'];
}
        }


        $grafiek = new TekenGrafiek($punten, $rapport->getNaam(), $sectienamen);
        $grafiekUrl = $grafiek->getGrafiek();



        if($rapport->getGebruiker()->getId()==$this->getUser()->getId()||$this->get('security.context')->isGranted('ROLE_ADMIN')==true){
        if($format=="pdf"){

            $html =  $this->render(sprintf('ScoreModelBundle:Rapport:rapport.%s.twig', $format), array(
                'id' => $id,
                'rapport' => $rapport,
                'secties' => $secties,
                'score' => $score,
                'grafiek' => $grafiekUrl
            ));

            $options = array(
                 "header-html" => "/home/web/scoremodel/header.html",
                 "footer-html" => "/home/web/scoremodel/footer.html",
                 "margin-bottom" => "25",
                 "margin-top" => "20",
		"image-quality" => "100"
            );

            $pdf = $this->get('knp_snappy.pdf');
            $pdfInhoud = $pdf->getOutputFromHtml($html, $options);
            return new Response(
                $pdfInhoud,
                200,
                array(
                    'Content-Type'          => 'application/pdf',
                    'Content-Disposition'   => 'attachment; filename="rapport_'.$id.'pdf"'
                )
            );
        }

        else{
            return $this->render(sprintf('ScoreModelBundle:Rapport:rapport.%s.twig', $format), array(
                'id' => $id,
                'rapport' => $rapport,
                'secties' => $secties,
                'score' => $score,
                'grafiek' => $grafiekUrl
            ));}

        }
        else {
            throw new AccessDeniedException();        }
    }

    /**
     * Lists all Rapport entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ScoreModelBundle:Rapport')->findAll();

        return $this->render('ScoreModelBundle:Rapport:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Finds and displays a Rapport entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ScoreModelBundle:Rapport')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Rapport entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ScoreModelBundle:Rapport:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to create a new Rapport entity.
     *
     */
    public function newAction()
    {
        $entity = new Rapport();
        $form   = $this->createForm(new RapportType(), $entity);

        return $this->render('ScoreModelBundle:Rapport:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new Rapport entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Rapport();
        $form = $this->createForm(new RapportType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('rapport_show', array('id' => $entity->getId())));
        }

        return $this->render('ScoreModelBundle:Rapport:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Rapport entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ScoreModelBundle:Rapport')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Rapport entity.');
        }

        $editForm = $this->createForm(new RapportType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ScoreModelBundle:Rapport:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Rapport entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ScoreModelBundle:Rapport')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Rapport entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new RapportType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('rapport_edit', array('id' => $id)));
        }

        return $this->render('ScoreModelBundle:Rapport:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Rapport entity.
     *
     */
    public function deleteAction($id)
    {
        if ($id != 0){

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ScoreModelBundle:Rapport')->find($id);

        if($entity->getGebruiker()->getId()!=$this->getUser()->getId()||$this->get('security.context')->isGranted('ROLE_ADMIN')==false){
            throw new AccessDeniedException();
        }

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Rapport entity.');
        }

        $em->remove($entity);
        $em->flush();
        $response = new Response;
        $response->setContent("ok");
        return $response;
        }

    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }


}
