<?php declare(strict_types=1);

namespace JobPosting\Adapter\Http\Web\Form;

use JobPosting\Adapter\Http\Web\Form\Dto\JobPostDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobPostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titolo',
                'required' => false,
                'empty_data' => '',
            ])

            ->add('description', TextareaType::class, [
                'required' => false,
                'label' => 'Descrizione',
                'empty_data' => '',
                'attr' => [
                    'label' => 'Descrizione-css',
                ],
            ])

            ->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'Salva',
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => JobPostDto::class,
            'csrf_token_id' => 'jobpost',
        ]);
    }
}
