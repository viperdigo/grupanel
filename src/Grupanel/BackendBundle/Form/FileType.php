<?php

namespace Grupanel\BackendBundle\Form;

use Grupanel\CoreBundle\Entity\File;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FileType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			// ...
			->add('name', 'file', array('label' => 'TESTE'))
			->add('save', 'submit', array(
				'attr' => array('class' => 'save'),
			))
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => File::class,
		));
	}

	public function getName()
	{
		return 'file';
	}
}