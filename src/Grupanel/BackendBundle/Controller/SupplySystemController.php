<?php

namespace Grupanel\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Supply System.
 *
 * @Route("/supply_system")
 */
class SupplySystemController extends Controller
{

	/**
	 * @Route("/", name="supply_system")
	 * @Method("GET")
	 * @Template()
	 */
	public function indexAction(Request $request)
	{

	}
}
