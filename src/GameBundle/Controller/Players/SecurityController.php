<?php

namespace GameBundle\Controller\Players;


use DateTime;
use GameBundle\Form\LoginForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class SecurityController extends Controller
{

    /**
     * @Route("/login", name="security_login")
     */
    public function loginPlayerAction(Request $request)
    {
        if ($this->get("security.authorization_checker")->isGranted("ROLE_USER")) {
            return $this->redirectToRoute("homepage");
        }

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(LoginForm::class,
            [
                '_username' => $lastUsername
            ]);

        return $this->render('players/login.html.twig', array(
            'form' => $form->createView(),
            'error'         => $error,
        ));

    }
    /**
     * @Route("/logout", name="security_logout")
     */
    public function logoutPlayerAction()
    {
    throw new \Exception('This should not be reached!');
    }

}
