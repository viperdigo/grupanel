<?php

namespace Grupanel\BackendBundle\Controller;

use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Helper\Builder\ApiHelperBuilder;
use Ivory\GoogleMap\Helper\Builder\MapHelperBuilder;
use Ivory\GoogleMap\Layer\GeoJsonLayer;
use Ivory\GoogleMap\Layer\KmlLayer;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\Overlay\Marker;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

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
	public function indexAction(Request $request)
	{
	}

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
	public function mapsAction(Request $request)
	{
		$appPath = $this->container->getParameter('kernel.root_dir');
		$kmlFileTest = realpath($appPath . '/../web/');

		$kmlLayer = new GeoJsonLayer('http://grupanel-dev.com/app_dev.php/uploads/maps/setor_beneficiado.json');
//		$kmlLayer->setVariable('kml_layer');
//		$kmlLayer->setUrl($kmlFileTest);

		$map = new Map();
		$map->getLayerManager()->addGeoJsonLayer($kmlLayer);
		$mapHelper = MapHelperBuilder::create()->build();
		$apiHelper = ApiHelperBuilder::create()
			->setKey('AIzaSyCwYLCJIsEjKBlxh-tdqnyUqzef7nD6egg')
			->build();

		return array(
			'api' => $apiHelper->render(array($map)),
			'map' => $mapHelper->render($map),
		);
	}
}
