<?php

namespace GameBundle\Controller\Admins;

use GameBundle\Entity\Type;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NavbarController extends Controller
{
    public function indexAction()
    {
        $typeRepo = $this->getDoctrine()->getRepository(Type::class);
        $buildingTypes = $typeRepo->findAll();

        return $this->render('nav.html.twig',
            [
                'types' => $buildingTypes
            ]);
    }
}
