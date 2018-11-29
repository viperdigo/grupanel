<?php

namespace Grupanel\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/")
 */
class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     * @Template()
     */
    public function indexAction()
    {

        if ($this->getUser())
            return $this->render('@Backend/Home/dashboard.html.twig');
        else
            return $this->redirect($this->generateUrl('login'));
    }

    /**
     * @Route("/dashboard", name="home_dashboard")
     * @Template()
     */
    public function dashboardAction()
    {
        return array();
    }

}
