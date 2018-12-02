<?php

namespace Grupanel\BackendBundle\Controller;

use Ivory\GoogleMap\Control\ControlPosition;
use Ivory\GoogleMap\Control\MapTypeControl;
use Ivory\GoogleMap\Control\MapTypeControlStyle;
use Ivory\GoogleMap\Control\ZoomControl;
use Ivory\GoogleMap\Control\ZoomControlStyle;
use Ivory\GoogleMap\Helper\Builder\ApiHelperBuilder;
use Ivory\GoogleMap\Helper\Builder\MapHelperBuilder;
use Ivory\GoogleMap\Layer\KmlLayer;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\MapTypeId;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\JsonResponse;
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
	public function indexAction(Request $request)
	{
		$photos = $this->getPhotos();
		return array(
			'photos' => $photos,
		);

	}

	/**
	 * @Route("/map", name="information_city_map")
	 * @Method("GET")
	 */
	public function createMap(Request $request)
	{
		$kmlFile = $request->get('kmlFile');
		$map = $this->getMap($this->createUrlMap($kmlFile));

		return new JsonResponse($map);
	}

	private function createUrlMap($nameFile)
	{
		$domainMap = 'http://45.55.160.102/grupanel-uploads/maps/';
		return $domainMap . $nameFile;
	}

	private function getPhotos()
	{
		$appPath = $this->container->getParameter('kernel.root_dir');
		$informationCityPhotosPath = realpath($appPath . '/../web/bundles/backend/img/information_city_photos');

		$finder = new Finder();
		$finder->files()->in($informationCityPhotosPath);

		foreach ($finder as $file) {
			$photosPath[] = $file->getRelativePathname();
		}

		return $photosPath;
	}

	/**
	 * @param $url
	 * @return array
	 * Example $url: http://45.55.160.102/grupanel-uploads/maps/setor_abastecimento.kmz or setor_abastecimento.kml
	 */
	private function getMap($url)
	{
		$kmlLayer = new KmlLayer($url);
		$kmlLayer->setUrl($url);
		$kmlLayer->setVariable('kml_layer');

		$map = new Map();
		$map->setStylesheetOptions(array(
			'height' => '700px',
			'width'  => 'auto',
		));
		$map->getLayerManager()->addKmlLayer($kmlLayer);
		$mapHelper = MapHelperBuilder::create()->build();
		$apiHelper = ApiHelperBuilder::create()
			->setKey('AIzaSyCwYLCJIsEjKBlxh-tdqnyUqzef7nD6egg')
			->build();

		$mapTypeControl = new MapTypeControl(
			[MapTypeId::ROADMAP, MapTypeId::TERRAIN],
			ControlPosition::TOP_RIGHT,
			MapTypeControlStyle::DEFAULT_
		);

		$map->getControlManager()->setMapTypeControl($mapTypeControl);

		$zoomControl = new ZoomControl(
			ControlPosition::TOP_LEFT,
			ZoomControlStyle::DEFAULT_
		);

		$map->getControlManager()->setZoomControl($zoomControl);

		return array(
			'api' => $apiHelper->render(array($map)),
			'map' => $mapHelper->render($map)
		);
	}

}
