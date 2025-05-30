<?php

namespace App\Form;

use App\Document\Traits;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TraitsFormInterface extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('name', TextType::class, [
				'label' => 'Name',
				'required' => true,
			])
			->add('description', TextareaType::class, [
				'label' => 'Description',
				'required' => true,
				'attr' => [
					'rows' => 5
				]
			])
		;
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			                       'data_class' => Traits::class,
		                       ]);
	}
}
