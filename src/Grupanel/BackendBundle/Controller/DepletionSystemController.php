<?php

namespace Grupanel\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Depletion System.
 *
 * @Route("/depletion_system")
 */
class DepletionSystemController extends Controller
{

	/**
	 * @Route("/", name="depletion_system")
	 * @Method("GET")
	 * @Template()
	 */
	public function indexAction(Request $request)
	{

	}
}
