<?php

namespace App\Controller;

use App\Entity\Venue;
use App\Form\VenueType;
use App\Repository\VenueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/backend")
 */
class VenueController extends AbstractController
{
    /**
     * @Route({
     *     "en": "/venue/{id}",
     *     "es": "/lugar/{id}"
     * }, name="venue", defaults={"id": null})
     * @param Request $request
     * @param VenueRepository $venueRepository
     * @param null $venue_id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, VenueRepository $venueRepository, Venue $venue = null)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if (null == $venue) {
            $venue = new Venue();
        }
//        } else {
//            $venue = $venueRepository->find($venue_id);
//        }

        $form = $this->createForm(VenueType::class, $venue, array(
            "isAdmin" => $this->isGranted('ROLE_ADMIN'),
        ));


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($venue);
            $em->flush();

            return $this->redirect(
                $this->generateUrl("venue", ['id' => $venue->getId()])
            );
        }

        return $this->render('venue/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
