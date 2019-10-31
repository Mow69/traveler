<?php

namespace App\Controller\Admin;

use App\Entity\Destination;
use App\Form\DestinationType;
use App\Repository\DestinationRepository;
use App\Service\OpenStreetMapAPIService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * @Route("/destination")
 */
class DestinationController extends AbstractController
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @Route("/", name="destination_index", methods={"GET"})
     * @param DestinationRepository $destinationRepository
     * @return Response
     */
    public function index(DestinationRepository $destinationRepository): Response
    {
        return $this->render('admin/destination/index.html.twig', [
            'destinations' => $destinationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="destination_new", methods={"GET","POST"})
     * @param Request $request
     * @param OpenStreetMapAPIService $osmaService
     * @return Response
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function new(Request $request, OpenStreetMapAPIService $osmaService): Response
    {
        // On définit une entité vide
        $destination = new Destination();
        // Création du formulaire de type DestinationType
        // Se basera sur $destination pour lier les données envoyées depuis le formulaire
        $form = $this->createForm(DestinationType::class, $destination);
        // Prend en charge la requête envoyée
        // Si on a une requête POST avec des données de formulaire,
        // c'est à ce moment-là que l'on va remplir l'objet $destination
        $form->handleRequest($request);

        // Si on a bien une requête POST, c'est-à-dire que le formulaire a été soumis,
        // et que les données renseignées sont valides (bon format, dans les limites fixées, etc...)
        // on rentre dans le bloc d'instructions
        if ($form->isSubmitted() && $form->isValid()) {

// Affecte dans un tableau
            $tab = $osmaService->createConn($destination->getVille() . ', ' .$destination->getPays()->getNom());
            //var_dump($tab);
            $latitude = $tab[0]['lat'];
            $longitude = $tab[0]['lon'];
            $destination->setLat($latitude);
            $destination->setLng($longitude);




            // Récupération du gestionnaire d'entités
            $entityManager = $this->getDoctrine()->getManager();
            // On indique au gestionnaire d'entités qu'on veut insérer $destination en BDD
            // Pour cela, on appelle la méthode persist pour que l'entité en question
            // soit gérée par notre gestionnaire (donc si elle n'existe pas, comme c'est
            // le cas ici, elle sera créée)
            $entityManager->persist($destination);
            // On valide tous les changements demandés au gestionnaire pour envoi vers la base de données
            // C'est à ce moment-là que les requêtes SQL sont exécutées et pas avant
            // C'est pour ça que généralement nous ferons un seul appel à flush()
            // mais que nous aurons fait plusieurs insertions, modifications, etc...
            $entityManager->flush();

            return $this->redirectToRoute('admin_destination_index');
        }

        return $this->render('admin/destination/new.html.twig', [
            'destination' => $destination,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="destination_show", methods={"GET"})
     * @param Destination $destination
     * @return Response
     */
    public function show(Destination $destination): Response
    {
        return $this->render('admin/destination/show.html.twig', [
            'destination' => $destination,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="destination_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Destination $destination
     * @return Response
     */
    public function edit(Request $request, Destination $destination): Response
    {
        $form = $this->createForm(DestinationType::class, $destination);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_destination_index');
        }

        return $this->render('admin/destination/edit.html.twig', [
            'destination' => $destination,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="destination_delete", methods={"DELETE"})
     * @param Request $request
     * @param Destination $destination
     * @return Response
     */
    public function delete(Request $request, Destination $destination): Response
    {
        if ($this->isCsrfTokenValid('delete'.$destination->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($destination);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_destination_index');
    }

//// TODO: Faire la géolocalisation dans Controller
//
//    // CARTE
//    /**
//     * @Route("/carte", name="carte", methods={"GET"})
//     * @param OpenStreetMapAPIService $osmAPIService
//     * @return JsonResponse
//     */
//    public function getMap(OpenStreetMapAPIService $osmAPIService)
//    {
//        $mapData = $osmAPIService->getAllMap();
//
//        return new JsonResponse($mapData, 200, [], true);
//    }


}
