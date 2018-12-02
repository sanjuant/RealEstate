<?php

namespace App\Form;

use App\Entity\Option;
use App\Entity\PropertySearch;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertySearchType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('minSurface', IntegerType::class, [
				'required' => false,
				'label' => false,
				'attr' => [
					'placeholder' => 'minSurface'
				]
			])
			->add('maxPrice', IntegerType::class, [
				'required' => false,
				'label' => false,
				'attr' => [
					'placeholder' => 'maxPrice'
				]
			])
			->add('options', EntityType::class, [
				'class'=> Option::class,
				'required' => false,
				'label' => false,
				'choice_label' => 'name',
				'multiple' => true,
				'attr' => [
					'placeholder' => 'options'
				]
			])
			->add('location', TextType::class, [
				'required' => false,
				'label' => false,
				'attr' => [
					'placeholder' => 'location'
				]
			])
			->add('distance', ChoiceType::class, [
				'required' => false,
				'label' => false,
				'choices' => [
					'5' => 5,
					'10' => 10,
					'20' => 20,
					'30' => 30,
					'50' => 50,
					'100' => 100,
					'500' => 500
				],
				'attr' => [
					'placeholder' => 'distance'
				]
			])
			->add('city', HiddenType::class)
			->add('postal_code', HiddenType::class)
			->add('lat', HiddenType::class)
			->add('lng', HiddenType::class)
		;
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => PropertySearch::class,
			'translation_domain' => 'forms',
			'method' => 'get',
			'csrf_protection' => false,
		]);
	}

	public function getBlockPrefix(): string
	{
		return 'search';
	}
}
