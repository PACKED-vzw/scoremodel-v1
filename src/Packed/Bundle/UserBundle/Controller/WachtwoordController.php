<?php

namespace Packed\Bundle\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Acl\Exception\Exception;


/**
 * Wachtwoord controller.
 *
 */
class WachtwoordController extends Controller
{
    private function generateToken()
    {
        $randomString = uniqid(rand(), true);
        $token = hash("sha256", $randomString);

        return $token;
    }

    public function tokenAanvragenAction()
    {

        // TODO beveiliging tegen 100X invoeren


        $translator = $this->get('translator');
        $request = $request = $this->getRequest();
        $email = $request->get("email");

        if($email!=""){
        $token = $this->generateToken();
        $succes = "";
        $boodschap = "";
        $usermanager = $this->get('fos_user.user_manager');
        if($gebruiker = $usermanager->findUserByEmail($email)){

            if($gebruiker->getUsername()=="anoniem" || $gebruiker->getUsername()=="anonymous"){
               echo "wachtwoord anonieme gebruiker kan niet gereset worden";die;
            }

            $succes = "ok";
            $gebruiker->setWachtwoordVergetenToken($token);
            $usermanager->updateUser($gebruiker);

            $url = $this->get('router')->generate('wachtwoord_nieuw_wachtwoord_instellen', array("_locale" => "nl" , "token" => $token, "email" => $email));


            $message = \Swift_Message::newInstance()
                ->setSubject('Scoremodel password reset')
                ->setFrom('it@packed.be')
                ->setTo($email)
                ->setBody($this->renderView('UserBundle:Wachtwoord:mail.html.twig', array('url' =>$url, 'gebruikersnaam' => $gebruiker->getUsername())), 'text/html')
            ;

            if(!$this->get('mailer')->send($message)){
                $boodschap .=  $translator->trans('probleem.versturen.mail');
            }
        }

        else {
            $boodschap .=  $translator->trans('gebruiker.nietgevonden');
            $succes = "nok";
        }



        $responseArray = array();
        $responseArray['success'] = $succes;
        $responseArray['boodschap'] = $boodschap;
         // $gebruiker->getOrganisatie();

        $response = new Response();
        $response->setContent(json_encode($responseArray));

        return $response;



        }

        else {
            return $this->render('UserBundle:Wachtwoord:wachtwoordVergeten.html.twig', array(
            ));

        }


    }

    public function nieuwWachtwoordInstellenAction($token,$email)
    {
        // checken of ww zelfde is en tussen 5 en 20    TODO ...


        $action = "invalidtoken";
        $request = $this->getRequest();
        $submitted = $request->get('submitted');
        $password = $request->get('passwO');


        if(!empty($token)&&!empty($email)){

                $usermanager = $this->get('fos_user.user_manager');
                if($gebruiker = $usermanager->findUserByEmail($email)){


                    $tokenInDB = $gebruiker->getWachtwoordVergetenToken();
                    if($tokenInDB!=""&&$tokenInDB == $token){
                        if($submitted=="subm"){
                            //verander ww
                            $gebruiker->setPlainPassword($password);
                            $usermanager->updatePassword($gebruiker);
                            $gebruiker->setWachtwoordVergetenToken("");
                            $action = "updated";
                        }
                        else{


                            $action = "validtoken";
                        }
                    }

                    $usermanager->updateUser($gebruiker);          // waar dit?


                }


            }


        return $this->render('UserBundle:Wachtwoord:wachtwoordOpnieuwInstellen.html.twig', array(
            "action" => $action,
        ));

    }



}