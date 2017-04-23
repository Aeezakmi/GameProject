<?php

namespace GameBundle\Controller\Players;

use GameBundle\Entity\Player;
use GameBundle\Entity\Role;
use GameBundle\Form\PlayerType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PlayersController extends Controller
{
    /**
     * @Route("/register", name="player_register_form")
     * @Method("GET")
     */
    public function registerPlayerForm()
    {
        $form = $this->createForm(PlayerType::class);

        return $this->render(':players:register.html.twig',
            [
                'playerForm' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/register", name="player_register_action")
     * @Method("POST")
     */
    public function registerPlayerAction(Request $request){
        $player = new Player();

        $form = $this->createForm(PlayerType::class,$player);
        $form->handleRequest($request);

        $age = $player->calcAge($player->getBirthdate());

        if ($form->isValid() && $age >= 18){
            $player->setAge($age);

            $rollRepository = $this->getDoctrine()->getRepository(Role::class);
            $userRole = $rollRepository->findOneBy(['name' => 'ROLE_USER']);
            $player->addRole($userRole);

            $password = $this->get('security.password_encoder')
                ->encodePassword($player, $player->getPassword());
            $player->setPassword($password);

            $em= $this->getDoctrine()
                ->getManager();
            $em->persist($player);
            $em->flush();

            $this->addFlash('success', "You registered successfully.");

            return $this->redirectToRoute('security_login');

        }
        if ($age < 18) {
            $this->addFlash('error', "You need to be over 18 to register!");
        }

        return $this->redirectToRoute('player_register_form');

    }
}
