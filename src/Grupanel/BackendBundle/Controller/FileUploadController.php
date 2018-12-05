<?php

namespace Grupanel\BackendBundle\Controller;

use Grupanel\BackendBundle\Form\FileType;
use Grupanel\CoreBundle\Entity\File;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/file")
 */
class FileUploadController extends Controller
{
    /**
     * @Route("/", name="file_upload")
     * @Template()
     */
    public function indexAction(Request $request)
    {
		$entityFile = new File();
		$form = $this->createForm(new FileType(), $entityFile);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			// $file stores the uploaded PDF file
			/** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
			$file = $entityFile->getName();

			$fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

			// moves the file to the directory where brochures are stored
			$file->move(
				$this->getParameter('file_uploader.web_base_path'),
				$fileName
			);

			// updates the 'brochure' property to store the PDF file name
			// instead of its contents
			$entityFile->setName($fileName);

			// ... persist the $product variable or any other work

			return $this->redirect($this->generateUrl('file_upload'));
		}

		return $this->render('@Backend/FileUpload/index.html.twig', array(
			'form' => $form->createView(),
		));
    }

	/**
	 * @return string
	 */
	private function generateUniqueFileName()
	{
		// md5() reduces the similarity of the file names generated by
		// uniqid(), which is based on timestamps
		return md5(uniqid());
	}

}
