<?php

namespace Grupanel\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/")
 */
class FileUploadController extends Controller
{
    /**
     * @Route("/", name="file_upload")
     * @Template()
     */
    public function indexAction()
    {
    }

}
