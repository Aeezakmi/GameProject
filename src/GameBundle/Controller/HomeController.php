<?php

namespace GameBundle\Controller;


use DateTime;
use GameBundle\Entity\Attack;
use GameBundle\Entity\Player;
use GameBundle\Entity\Type;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Method("GET")
     */
    public function indexAction()
    {

        $players = $this->getDoctrine()->getRepository(Player::class)->findAll();
        $attacksRepo = $this->getDoctrine()->getRepository(Attack::class);
        $attacks = null;
        $player = null;

        if ($this->get("security.authorization_checker")->isGranted("ROLE_USER")) {
            /** @var Player $player */
            $player = $this->getUser();
            $attacks = $attacksRepo->getAttacks($player->getId());
        }

        return $this->render('users/index.html.twig',
            [
                'players' => $players,
                'user' => $player,
                'attacks' => $attacks
            ]);
    }

    /**
     *
     * @Route("/", name="players_attack")
     * @Method("POST")
     */
    public function attack()
    {
        $attack = new Attack();
        $attack->setAttackerId($this->getUser()->getId());
        $attack->setTargetId(intval($_POST['attack']));
        $attack->setTime(time() + intval($_POST['time']));

        $em = $this->getDoctrine()->getManager();
        $em->persist($attack);
        $em->flush();

        return $this->redirect("/");
    }

    /**
     *
     * @Route("/attack", name="players_attack_action")
     * @Method("POST")
     */
    public function attackAction(){

        $id = intval($_POST['id']);
        /** @var Attack $attack */
        $attack = $this->getDoctrine()->getRepository(Attack::class)->find($id);
        /** @var Player $player1 */
        $player1 = $this->getDoctrine()->getRepository(Player::class)->find($attack->getAttackerId());
        /** @var Player $player2 */
        $player2 = $this->getDoctrine()->getRepository(Player::class)->find($attack->getTargetId());

        $player1Mutri = $player1 ->getBuilding('discotech')->getResource();
        $player2Mutri = $player2 ->getBuilding('discotech')->getResource();

        if ($player1Mutri > $player2Mutri){
            $player1 ->getBuilding('discotech')->setResource($player1Mutri - $player2Mutri);
            $player2 ->getBuilding('discotech')->setResource(0);
            $attack->setWinner($player1->getId());
        }
        else if ($player1Mutri < $player2Mutri){
            $player2 ->getBuilding('discotech')->setResource($player2Mutri - $player1Mutri);
            $player1 ->getBuilding('discotech')->setResource(0);
            $attack->setWinner($player2->getId());
        }
        else{
            $player1 ->getBuilding('discotech')->setResource(0);
            $player2 ->getBuilding('discotech')->setResource(0);
        }
        $attack->setResource(min($player1Mutri,$player2Mutri));

        $em = $this->getDoctrine()->getManager();
        $em->persist($player1);
        $em->persist($player2);
        $em->persist($attack);
        $em->flush();

        return new Response();
    }
}
