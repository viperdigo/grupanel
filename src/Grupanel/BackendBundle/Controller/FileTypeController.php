<?php

namespace Grupanel\BackendBundle\Controller;

use Grupanel\BackendBundle\Form\FileTypeType;
use Grupanel\CoreBundle\Entity\FileType;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * FileType controller.
 *
 * @Route("/file_type")
 */
class FileTypeController extends Controller
{

	/**
	 * @Route("/", name="file_type")
	 * @Method("GET")
	 * @Template()
	 */
	public function indexAction()
	{
		$em = $this->getDoctrine()->getManager();

		$entities = $em->getRepository(FileType::class)->findAll();

		return array(
			'entities' => $entities,
		);
	}

	/**
	 * @Route("/new", name="file_type_create")
	 * @Method("POST")
	 */
	public function createAction(Request $request)
	{
		$entity = new FileType();
		$form = $this->createCreateForm($entity);
		$form->handleRequest($request);

		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($entity);
			$em->flush();

			return $this->redirect($this->generateUrl('file_type'));
		}

		return array(
			'entity' => $entity,
			'form'   => $form->createView(),
		);
	}

	/**
	 * @param FileType $entity The entity
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createCreateForm(FileType $entity)
	{

		$form = $this->createForm(
			new FileTypeType(),
			$entity,
			array(
				'action' => $this->generateUrl('file_type_create'),
				'method' => 'POST',
				'attr'   => array(
					'class' => 'form-horizontal'
				)
			)
		);

		return $form;
	}

	/**
	 * @Route("/new", name="file_type_new")
	 * @Method("GET")
	 * @Template()
	 */
	public function newAction()
	{
		$entity = new FileType();
		$form = $this->createCreateForm($entity);

		return array(
			'entity' => $entity,
			'form'   => $form->createView(),
		);
	}

	/**
	 * Displays a form to edit an existing File entity.
	 *
	 * @Route("/{id}/edit", name="file_type_edit")
	 * @Method("GET")
	 * @Template()
	 */
	public function editAction($id)
	{
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository(FileType::class)->find($id);

		if (!$entity) {
			throw $this->createNotFoundException('Unable to find FileType entity.');
		}

		$editForm = $this->createEditForm($entity);

		return array(
			'entity'    => $entity,
			'edit_form' => $editForm->createView(),
		);
	}

	/**
	 * Creates a form to edit a FileType entity.
	 *
	 * @param FileType $entity The entity
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createEditForm(FileType $entity)
	{
		$form = $this->createForm(
			new FileTypeType(),
			$entity,
			array(
				'action' => $this->generateUrl('file_type_update', array('id' => $entity->getId())),
				'method' => 'PUT',
				'attr'   => array(
					'class' => 'form-horizontal'
				)
			)
		);

		return $form;
	}

	/**
	 * Edits an existing FileType entity.
	 *
	 * @Route("/{id}", name="file_type_update")
	 * @Method("PUT")
	 */
	public function updateAction(Request $request, $id)
	{

		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository(FileType::class)->find($id);

		if (!$entity) {
			throw $this->createNotFoundException('Unable to find FileType entity.');
		}

		$editForm = $this->createEditForm($entity);
		$editForm->handleRequest($request);

		try {

			if ($editForm->isValid()) {

				$em->flush();

				$this->get('session')->getFlashBag()->add(
					'success',
					'Tipo de arquivo atualizado com sucesso!'
				);

				return $this->redirect($this->generateUrl('file_type'));
			}
		} catch (Exception $exception) {

			$this->get('session')->getFlashBag()->add(
				'error',
				sprintf('Não foi possível atualizar o tipo de arquivo, contate o administrador. Erro nº %s Mensagem %s',
					$exception->getCode(),
					$exception->getMessage())
			);

			return array(
				'entity'    => $entity,
				'edit_form' => $editForm->createView(),
			);

		}

	}

	/**
	 * Deletes a FileType entity.
	 *
	 * @Route("/{id}/delete", name="file_type_delete")
	 * @Method("GET")
	 * @Template()
	 */
	public function deleteAction($id)
	{
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository(FileType::class)->find($id);

		if (!$entity) {
			throw $this->createNotFoundException('Unable to find FileType entity.');
		}

		try {

			$em = $this->getDoctrine()->getManager();

			$em->remove($entity);
			$em->flush();

			$this->get('session')->getFlashBag()->add(
				'success',
				'Tipo de arquivo excluído com sucesso!'
			);

		} catch (Exception $exception) {

			$this->get('session')->getFlashBag()->add(
				'error',
				sprintf('Não foi possível excluir o tipo de arquivo. Erro nº %s Mensagem %s',
					$exception->getCode(),
					$exception->getMessage())
			);

		}

		return $this->redirect($this->generateUrl('file_type'));

	}

}
