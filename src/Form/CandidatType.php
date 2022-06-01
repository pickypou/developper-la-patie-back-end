<?php

namespace App\Form;

use App\Entity\Candidat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class CandidatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname')
            ->add('lastmane')
            ->add('cv', FileType::class,[
                'label'=>'Choisir un docomment (PDF)',
                'mapped' => false,
                'constraints'=>[
                    new File([
                        'mimeTypes'=>[
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage'=>'Veuillez télécharger un document PDF valide'
                    ])
                ]


                ])
            ->add('submit', SubmitType::class,[
                'label'=>"Mettre a jour mes informations"
            ])



        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Candidat::class,
        ]);
    }
}
