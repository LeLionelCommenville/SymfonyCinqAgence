<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropertyController extends AbstractController
{

    /**
     * @var PropertyRepository
     */
    private $repository;

    public function __construct(PropertyRepository $repository, EntityManagerInterface  $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }
    /**
     * @Route("/property", name="property.index")
     */
    public function index(): Response
    {
        $property = $this->repository->findAllVisible(); 
        dump($property);
        return $this->render('property/property.html.twig', [
            'controller_name' => 'PropertyController',
            'current_menu' => 'property'
        ]);
    }

    /**
     * @Route("/property/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\ -]*"})
     */
    public function show(Property $property, string $slug): Response
    {
        if($property->getSlug() !== $slug) {
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }
        return $this->render('property/show.html.twig', [
            'property' => $property,
            'current_menu' => 'property'
        ]);
    }
}
