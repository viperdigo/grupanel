<?php

namespace Grupanel\BackendBundle\Controller;

use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Information City.
 *
 * @Route("/information_city")
 */
class InformationCityController extends Controller
{

	/**
	 * @Route("/", name="information_city")
	 * @Method("GET")
	 * @Template()
	 */
	public function indexAction(Request $request){}

	/**
	 * @Route("/photos", name="information_city_photos")
	 * @Method("GET")
	 * @Template()
	 */
	public function photosAction(Request $request)
	{
		$appPath = $this->container->getParameter('kernel.root_dir');
		$informationCityPhotosPath = realpath($appPath . '/../web/bundles/backend/img/information_city_photos');

		$finder = new Finder();
		$finder->files()->in($informationCityPhotosPath);

		foreach ($finder as $file) {
			$photosPath[] = $file->getRelativePathname();
		}

		return array(
			'photos' => $photosPath
		);
	}

	/**
	 * @Route("/maps", name="information_city_maps")
	 * @Method("GET")
	 * @Template()
	 */
	public function mapsAction(Request $request){}

}
