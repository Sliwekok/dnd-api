<?php

namespace App\Form;

use App\Document\Languages;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LanguageFormInterface extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('name', TextType::class, [
				'label' => 'Name',
				'required' => true,
			])
            ->add('rarity', TextType::class, [
                'label' => 'Rarity',
                'required' => true,
            ])
            ->add('origin', TextType::class, [
                'label' => 'Origin',
                'required' => true,
            ])

		;
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			                       'data_class' => Languages::class,
		                       ]);
	}
}
