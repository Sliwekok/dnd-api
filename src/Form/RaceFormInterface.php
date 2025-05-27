<?php

namespace App\Form;

use App\Document\Languages;
use App\Document\Race;
use App\Document\Traits;
use Symfony\Component\Form\AbstractType;
use Doctrine\Bundle\MongoDBBundle\Form\Type\DocumentType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RaceFormInterface extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('name', TextType::class, [
				'label' => 'Name',
				'required' => true,
			])
			->add('description', TextareaType::class, [
				'label' => 'Description & Story',
				'required' => true,
				'attr' => [
					'rows' => 5
				]
			])
			->add('traits', DocumentType::class, [
				'label' => 'Traits',
				'class' => Traits::class,
				'expanded' => false,
				'multiple' => true,
				'required' => true,
                'query_builder' => function ($repository) {
                    return $repository->createQueryBuilder();
                },
				'attr' => [
					'class' => 'select2',
					'data-placeholder' => 'Select Traits',
				],
			])
			->add('languages', DocumentType::class, [
				'label' => 'Languages',
				'class' => Languages::class,
				'expanded' => false,
				'multiple' => true,
				'required' => true,
                'query_builder' => function ($repository) {
                    return $repository->createQueryBuilder();
                },
				'attr' => [
					'class' => 'select2',
					'data-placeholder' => 'Select Languages',
				],
			])
			->add('speed', IntegerType::class, [
				'label' => 'Speed (in feet)',
				'required' => true,
			])
			->add('subrace', DocumentType::class, [
				'label' => 'Subraces',
				'class' => Traits::class,
				'expanded' => false,
				'multiple' => true,
				'required' => true,
				'attr' => [
					'class' => 'select2',
					'data-placeholder' => 'Select Traits',
				],
			])
			->add('type', TextType::class, [
				'label' => 'Type',
				'required' => true,
			])
			->add('size', TextType::class, [
				'label' => 'Size',
				'required' => true,
			]);
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			                       'data_class' => Race::class,
		                       ]);
	}
}
