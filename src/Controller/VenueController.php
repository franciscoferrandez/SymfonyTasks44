<?php

namespace App\Controller;

use App\Entity\Venue;
use App\Form\VenueType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class VenueController extends AbstractController
{
    /**
     * @Route("/venue", name="venue")
     */
    public function index(Request $request)
    {

        $venue = new Venue();

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
