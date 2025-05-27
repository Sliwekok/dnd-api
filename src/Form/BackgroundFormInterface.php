<?php

namespace App\Form;

use App\Document\Background;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BackgroundFormInterface extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$choices = [
			'Strength' => 'strength',
			'Dexterity' => 'dexterity',
			'Constitution' => 'constitution',
			'Intelligence' => 'intelligence',
			'Wisdom' => 'wisdom',
			'Charisma' => 'charisma',
		];

		$builder
			->add('name', TextType::class, [
				'label' => 'Name',
				'required' => true,
			])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'required' => true,
            ])
			->add('abilityScores', ChoiceType::class, [
				'label' => 'Ability Scores',
				'required' => true,
				'expanded' => false,
				'multiple' => true,
				'attr' => [
					'class' => 'select2',
					'data-placeholder' => 'Select ability scores',
				],
				'choices' => $choices,
			])
			->add('feature', TextType::class, [
				'label' => 'Feature',
				'required' => true,
			])
			->add('skillProficiency', ChoiceType::class, [
				'label' => 'Skill proficiencies',
				'required' => true,
				'expanded' => false,
				'multiple' => true,
				'attr' => [
					'class' => 'select2',
					'data-placeholder' => 'Select skill proficiencies',
				],
				'choices' => $choices,
			])
			->add('toolProficiency', ChoiceType::class, [
				'label' => 'Tool proficiencies',
				'required' => true,
				'expanded' => false,
				'multiple' => true,
				'attr' => [
					'class' => 'select2',
					'data-placeholder' => 'Select tool proficiencies',
				],
				'choices' => $choices,
			])
			->add('equipment', ChoiceType::class, [
				'label' => 'Equipment',
				'required' => true,
				'expanded' => false,
				'multiple' => true,
				'attr' => [
					'class' => 'select2',
					'data-placeholder' => 'Select equipment',
				],
				'choices' => $choices,
			])
		;
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			                       'data_class' => Background::class,
		                       ]);
	}
}
