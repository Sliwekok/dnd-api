<?php

namespace App\Form;

use App\Document\Monster;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MonsterFormInterface extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('name', TextType::class, [
				'label' => 'Name',
				'required' => true,
			])
			->add('type', TextType::class, [
				'label' => 'Type',
				'required' => true,
			])
            ->add('abilities', MonsterAbilityType::class, [
                'label' => 'Abilities',
                'required' => false,
            ])
			->add('initiative', TextType::class, [
				'label' => 'Initiative',
				'required' => false,
			])
			->add('ac', TextType::class, [
				'label' => 'AC',
				'required' => true,
			])
			->add('hp', TextType::class, [
				'label' => 'HP',
				'required' => true,
			])
			->add('speed', TextType::class, [
				'label' => 'Speed',
				'required' => true,
			])
			->add('skills', CollectionType::class, [
				'label' => 'Skills',
                'entry_type' => TextType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'required' => false,
			])
			->add('senses', CollectionType::class, [
				'label' => 'Senses',
                'entry_type' => TextType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'required' => false,
			])
			->add('languages', CollectionType::class, [
				'label' => 'Languages',
                'entry_type' => TextType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'required' => false,
			])
			->add('cr', TextType::class, [
				'label' => 'Challenge Rating',
				'required' => true,
			])
			->add('description', TextareaType::class, [
				'label' => 'Description',
				'required' => false,
				'attr' => ['rows' => 4],
			])
			->add('actions', CollectionType::class, [
				'label' => 'Actions',
				'entry_type' => NamedDescriptionItemType::class,
				'allow_add' => true,
				'allow_delete' => true,
                'by_reference' => false,
				'required' => false,
			])
            ->add('bonusActions', CollectionType::class, [
                'label' => 'Bonus Actions',
                'entry_type' => NamedDescriptionItemType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'required' => false,
            ])
            ->add('legendaryActions', CollectionType::class, [
                'label' => 'Legendary Actions',
                'entry_type' => NamedDescriptionItemType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'required' => false,
            ])
			->add('reactions', CollectionType::class, [
				'label' => 'Reactions',
				'entry_type' => NamedDescriptionItemType::class,
				'allow_add' => true,
				'allow_delete' => true,
                'by_reference' => false,
                'required' => false,
			])
            ->add('traits', CollectionType::class, [
                'label' => 'Traits',
                'entry_type' => NamedDescriptionItemType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'required' => false,
                'by_reference' => false,
            ])
            ->add('accepted', CheckboxType::class, [
                'label' => 'Accepted',
                'required' => false,
            ])
            ->add('url', UrlType::class, [
                'label' => 'Source',
                'required' => false,
            ])
        ;
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			                       'data_class' => Monster::class,
		                       ]);
	}
}
