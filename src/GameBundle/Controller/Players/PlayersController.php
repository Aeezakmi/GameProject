<?php

namespace GameBundle\Controller\Players;

use GameBundle\Entity\Apartment;
use GameBundle\Entity\Attack;
use GameBundle\Entity\Base;
use GameBundle\Entity\Building;
use GameBundle\Entity\Discotech;
use GameBundle\Entity\Player;
use GameBundle\Entity\Resource;
use GameBundle\Entity\Role;
use GameBundle\Entity\Type;
use GameBundle\Form\PlayerType;
use GameBundle\Repository\AttackRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class PlayersController extends Controller
{
    /**
     * @Route("/register", name="player_register_form")
     * @Method("GET")
     */
    public function registerPlayerForm()
    {
        if ($this->get("security.authorization_checker")->isGranted("ROLE_USER")) {
            return $this->redirectToRoute("homepage");
        }

        $form = $this->createForm(PlayerType::class);

        return $this->render(':users:register.html.twig',
            [
                'playerForm' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/register", name="player_register_action")
     * @Method("POST")
     */
    public function registerPlayerAction(Request $request)
    {

        if ($this->get("security.authorization_checker")->isGranted("ROLE_USER")) {
            return $this->redirectToRoute("homepage");
        }

        $player = new Player();

        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        $age = $player->calcAge($player->getBirthdate());

        if ($form->isValid() && $age >= 18) {

            $player->setAge($age);
            $typeRepo = $this->getDoctrine()->getRepository(Type::class);

            $types = $typeRepo->findAll();
            foreach ($types as $type) {
                $building = new Building();
                $building->setType($type);
                $building->setPlayer($player);
                $building->setResource($type->getStartingResource());
                $player->addBuilding($building);
            }

            $roleRepository = $this->getDoctrine()->getRepository(Role::class);
            $player->addRole($roleRepository->findOneBy(['name' => 'ROLE_USER']));

            $baseRepo = $this->getDoctrine()->getRepository(Player::class);
            $base = new Base();
            $base->addBase($player, $baseRepo);

            $password = $this->get('security.password_encoder')
                ->encodePassword($player, $player->getPassword());
            $player->setPassword($password);

            $em = $this->getDoctrine()
                ->getManager();
            $em->persist($player);
            $em->flush();

            $this->addFlash('success', "You registered successfully.");

            return $this->redirectToRoute('security_login');

        }
        if ($age < 18) {
            $this->addFlash('error', "You need to be over 18 to register!");
        }

        return $this->render(':users:register.html.twig',
            [
                'playerForm' => $form->createView()
            ]
        );
    }

    /**
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @Route("/profile", name="player_profile")
     */
    public function profileAction()
    {
        $player = $this->getUser();
        return $this->render('users/profile.html.twig',
            [
                'player' => $player
            ]);
    }

    /**
     * @Route("/reports", name="player_report")
     */
    public function reportAction()
    {
        /** @var Player $player */
        $player = $this->getUser();
        $repo = $this->getDoctrine()->getRepository(Attack::class);

        $reports = $repo->getReports($player->getId());


        return $this->render('players/reports.html.twig',
            [
                'attacks' => $reports,
                'user' => $player
            ]);
    }
}
