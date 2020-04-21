<?php


namespace App\Controller;


use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{
    /**
     * @var PropertyRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(PropertyRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }



    /**
     * @Route("/biens", name="property.index")
     * @param PropertyRepository $repository
     * @return Response
     */
    public function index(): Response
    {

        $property = $this->repository->findAllVisible();

//        $property[0]->setSold(true);
//        $this->em->flush();



        return $this->render('property/index.html.twig', [
            'current_menu'=>'properties'
        ]);
    }

    /**
     *
     * @param Property $property
     * @param string $slug
     * @return Response
     * @Route("/biens/{slug}/{id}", name="property.show")
     */
    public function show(Property $property, string $slug): Response
    {
        if($property->getSlug() !== $slug){
          return  $this->redirectToRoute('property.show', [
               'id'=>$property->getId(),
               'slug'=>$property->getSlug()
            ], 301);
        }

        dump($property);

        return $this->render('property/show.html.twig', [
            'property'=>$property,
            'current_menu'=>'properties'
        ]);
    }

}