<?php

namespace GameBundle\Controller\Admins;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    /**
     * @Route("/admin/admin_page", name="admin_page")
     */
    public function indexAction(){

        return $this->render('admins/admins.html.twig');
    }
}
