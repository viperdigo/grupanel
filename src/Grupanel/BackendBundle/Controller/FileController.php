<?php

namespace Grupanel\BackendBundle\Controller;

use Grupanel\BackendBundle\Form\FileType as FormFileType;
use Grupanel\CoreBundle\Entity\File;
use Grupanel\CoreBundle\Entity\FileType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Acl\Exception\Exception;

/**
 * @Route("/file")
 */
class FileController extends Controller
{
	/**
	 * @Route("/", name="file_list")
	 * @Template()
	 * @return array
	 * @throws \Exception
	 */
	public function listAction()
	{
		$filter = $this->get('filter')->createFilterBuilder('CoreBundle:File')
			->addField('id', array('length' => 2))
			->addField('name', array('length' => 4))
			->addField('extension', array('length' => 2))
			->addField('createdAt')
			->addOrder('createdAt', 'DESC')
			->addPagination(10)
			->addCache(0)
			->build();

		return array(
			'filter' => $filter,
			'result' => $filter->getResult(),
		);
	}

	/**
	 * @Route("/new", name="file_new")
	 * @param Request $request
	 * @Template()
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 */
	public function newAction(Request $request)
	{
		$entityFile = new File();
		$form = $this->createForm(new FormFileType(), $entityFile);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

			$file = $this->uploadFile($entityFile);
			$this->saveFileInEntity($entityFile, $file);

			return $this->redirect($this->generateUrl('file_list'));
		}

		return $this->render('@Backend/FileUpload/new.html.twig', array(
			'form' => $form->createView(),
		));
	}

	/**
	 * @Route("/{id}/delete", name="file_delete")
	 * @Method("GET")
	 * @Template()
	 * @param $id
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */
	public function deleteAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		$entity = $em->getRepository('CoreBundle:File')->find($id);
		if (!$entity) {
			throw $this->createNotFoundException('Unable to find Order entity.');
		}
		try {
			$fileName = $this->createFileName($entity->getName(), $entity->getExtension());

			if ($this->removeFile($fileName)) {
				$em->remove($entity);
				$em->flush();
				$this->get('session')->getFlashBag()->add(
					'success',
					sprintf('Arquivo excluído com sucesso!')
				);
			}
		} catch (\Exception $exception) {
			$this->get('session')->getFlashBag()->add(
				'error',
				sprintf('Não foi possível excluir o arquivo, contato o Adrministrador. Erro nº %s Mensagem %s',
					$exception->getCode(),
					$exception->getMessage())
			);
		}
		return $this->redirect($this->generateUrl('file_list'));
	}

	/**
	 * @param string $name
	 * @param string $extension
	 * @return string
	 */
	private function createFileName($name, $extension)
	{
		return sprintf('%s.%s', $name, $extension);
	}

	/**
	 * @param $fileName
	 * @return bool
	 */
	private function removeFile($fileName)
	{
		$filePath = $this->getParameter('media_directory') . '/' . $fileName;
		if (file_exists($filePath)) {
			try {
				unlink($filePath);
				return true;
			} catch (Exception $exception) {
				$this->get('session')->getFlashBag()->add(
					'error',
					sprintf('Não foi possível excluir o arquivo, contato o Administrador. Erro nº %s Mensagem: %s',
						$exception->getCode(),
						$exception->getMessage()
					)
				);
			}
		} else {
			$this->get('session')->getFlashBag()->add(
				'error', sprintf('Arquivo não existe!')
			);
		}
		return false;
	}

	/**
	 * @Route("/{id}/edit", name="file_edit")
	 * @Method("GET")
	 * @Template()
	 * @param $id
	 * @return array
	 */
	public function editAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		$entity = $em->getRepository('CoreBundle:File')->find($id);
		if (!$entity) {
			throw $this->createNotFoundException('Unable to find File entity.');
		}
		$editForm = $this->createEditForm($entity);
		return array(
			'entity'    => $entity,
			'edit_form' => $editForm->createView(),
		);
	}

	/**
	 * @param File $entity
	 * @return \Symfony\Component\Form\Form
	 */
	private function createEditForm(File $entity)
	{
		$form = $this->createForm(
			new FormFileType(),
			$entity,
			array(
				'action' => $this->generateUrl('file_update', array('id' => $entity->getId())),
				'method' => 'PUT',
				'attr'   => array(
					'class' => 'form-horizontal',
				),
			)
		);
//        $form->add('submit', 'submit', array('label' => 'Update'));
		return $form;
	}

	/**
	 * @Route("/{id}", name="file_update")
	 * @param Request $request
	 * @param $id
	 * @Method("PUT")
	 * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
	 */
	public function updateAction(Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$entity = $em->getRepository('CoreBundle:File')->find($id);
		if (!$entity instanceof File) {
			throw $this->createNotFoundException('Unable to find File entity.');
		}
		$editForm = $this->createEditForm($entity);
		$editForm->handleRequest($request);
		if ($editForm->isValid()) {
			$em->flush();
			$this->get('session')->getFlashBag()->add(
				'success',
				$this->get('translator')->trans('File %name% changed.', array("%name%" => $entity->getName()))
			);
			return $this->redirect($this->generateUrl('file_list'));
		}
		return array(
			'entity'    => $entity,
			'edit_form' => $editForm->createView(),
		);
	}

	/**
	 * @return string
	 */
	private function generateUniqueFileName()
	{
		return md5(uniqid());
	}

	/**
	 * @param File $entity
	 * @return array
	 */
	private function uploadFile(File $entity)
	{
		/** @var UploadedFile $file */
		$file = $entity->getName();
		$fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();

		try {
			$file->move($this->getParameter('media_directory'), $fileName);
		} catch (\Exception $exception) {
			$this->get('session')->getFlashBag()->add(
				'error',
				sprintf('Não foi possível fazer o upload, contato o Administrador. Erro nº %s Mensagem: %s',
					$file->getError(),
					$file->getErrorMessage()
				)
			);
		}

		return [
			'fileName'     => $fileName,
			'extension'    => $file->guessExtension(),
			'size'         => $file->getSize(),
			'errorCode'    => $file->getError(),
			'errorMessage' => $file->getErrorMessage(),
		];
	}

	/**
	 * @param File $entity
	 * @param array $file
	 */
	private function saveFileInEntity(File $entity, $file)
	{
		$entityManager = $this->getDoctrine()->getManager();
		$fileType = $entityManager->find(FileType::class, 1);

		try {
			$entity->setName($file['fileName']);
			$entity->setFileType($fileType);
			$entity->setExtension($file['extension']);

			$entityManager->persist($entity);
			$entityManager->flush();

		} catch (\Exception $exception) {
			$this->get('session')->getFlashBag()->add(
				'error',
				sprintf('Não foi possível salvar na tabela de arquivos, contato o Administrador. Erro nº %s Mensagem: %s',
					$exception->getCode(),
					$exception->getMessage()
				)
			);
		}
	}

}
