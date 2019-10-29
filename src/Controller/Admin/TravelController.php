<?php

namespace App\Controller\Admin;

use App\Entity\Travel;
use App\Form\TravelType;
use App\Repository\TravelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Gedmo\Sluggable\Util\Urlizer;

/**
 * @Route("/travel")
 */
class TravelController extends AbstractController
{
    /**
     * @Route("/", name="travel_index", methods={"GET"})
     * @param TravelRepository $travelRepository
     * @return Response
     */
    public function index(TravelRepository $travelRepository): Response
    {
        return $this->render('admin/travel/index.html.twig', [
            'travels' => $travelRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="travel_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $travel = new Travel();
        $form = $this->createForm(TravelType::class, $travel);
        $form->handleRequest($request);

        // TODO: Permettre l'upload de plusieurs images grace à une méthode for ou foreach
        if ($form->isSubmitted() && $form->isValid()) {
            $pictures = $form["pictures"]->getData();

            foreach ($pictures as $picture) {
                if ($picture < 10) {
                    break;
                }
                $destination = $this->getParameter('kernel.project_dir') . '/public/images';
                $originalFilename = pathinfo($pictures->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = Urlizer::urlize($originalFilename) . '-' . uniqid() . '.' . $pictures->guessExtension();
                $pictures->move(
                    $destination,
                    $newFilename
                );
            }

            dd($pictures);
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($travel);
            // $entityManager->flush();

            return $this->redirectToRoute('admin_travel_index');
        }

        return $this->render('admin/travel/new.html.twig', [
            'travel' => $travel,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="travel_show", methods={"GET"})
     * @param Travel $travel
     * @return Response
     */
    public function show(Travel $travel): Response
    {
        return $this->render('admin/travel/show.html.twig', [
            'travel' => $travel,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="travel_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Travel $travel
     * @return Response
     */
    public function edit(Request $request, Travel $travel): Response
    {
        $form = $this->createForm(TravelType::class, $travel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //dd($form['pictures']->getData());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_travel_index');
        }

        return $this->render('admin/travel/edit.html.twig', [
            'travel' => $travel,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="travel_delete", methods={"DELETE"})
     * @param Request $request
     * @param Travel $travel
     * @return Response
     */
    public function delete(Request $request, Travel $travel): Response
    {
        if ($this->isCsrfTokenValid('delete' . $travel->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($travel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_travel_index');
    }
}
