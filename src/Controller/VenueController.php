<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Region;
use App\Entity\Venue;
use App\Form\CityType;
use App\Form\RegionType;
use App\Form\VenueType;
use App\Repository\CityRepository;
use App\Repository\RegionRepository;
use App\Repository\VenueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * }, name="venue", defaults={"id": 0}, requirements={"id"="\d+"})
     * @param Request $request
     * @param VenueRepository $venueRepository
     * @param null $venue_id
     * @return RedirectResponse|Response
     */
    public function venue_edit(Request $request, VenueRepository $venueRepository, Venue $venue = null)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if (null == $venue) {
            $venue = new Venue();
        }

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



    /**
     * @Route({
     *     "en": "/venue/list",
     *     "es": "/lugar/lista"
     * }, name="venue_list")
     * @param Request $request
     * @param VenueRepository $venueRepository
     * @return RedirectResponse|Response
     */
    public function venue_list(Request $request, VenueRepository $venueRepository)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $em = $this->getDoctrine()->getManager();

        $venues_repo = $this->getDoctrine()->getRepository(Venue::class);
        $venues = $venues_repo->findBy([],['id' => 'DESC']);

        return $this->render('venue/index.html.twig', [
            'list' => true,
            'venues' => $venues
        ]);
    }


    /**
     * @Route({
     *     "en": "/region/{id}",
     *     "es": "/region/{id}"
     * }, name="region", defaults={"id": 0}, requirements={"id"="\d+"})
     * @param Request $request
     * @param VenueRepository $venueRepository
     * @param Region|null $region
     * @return RedirectResponse|Response
     */
    public function region_edit(Request $request, VenueRepository $venueRepository, Region $region = null)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if (null == $region) {
            $region = new Region();
        }

        $form = $this->createForm(RegionType::class, $region, array(
            "isAdmin" => $this->isGranted('ROLE_ADMIN'),
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($region);
            $em->flush();

            return $this->redirect(
                $this->generateUrl("region", ['id' => $region->getId()])
            );
        }

        return $this->render('venue/index.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route({
     *     "en": "/region/list",
     *     "es": "/region/lista"
     * }, name="region_list")
     * @param Request $request
     * @param VenueRepository $regionRepository
     * @return RedirectResponse|Response
     */
    public function region_list(Request $request, RegionRepository $regionRepository)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $regions = $regionRepository->findBy([],['id' => 'DESC']);

        return $this->render('venue/index.region.html.twig', [
            'list' => true,
            'regions' => $regions
        ]);
    }


    /**
     * @Route({
     *     "en": "/city/{id}",
     *     "es": "/ciudad/{id}"
     * }, name="city", defaults={"id": 0}, requirements={"id"="\d+"})
     * @param Request $request
     * @param VenueRepository $venueRepository
     * @param Region|null $city
     * @return RedirectResponse|Response
     */
    public function city_edit(Request $request, City $city = null)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if (null == $city) {
            $city = new City();
        }

        $form = $this->createForm(CityType::class, $city, array(
            "isAdmin" => $this->isGranted('ROLE_ADMIN'),
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($city);
            $em->flush();

            return $this->redirect(
                $this->generateUrl("city", ['id' => $city->getId()])
            );
        }

        return $this->render('venue/index.city.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route({
     *     "en": "/city/list",
     *     "es": "/city/lista"
     * }, name="city_list")
     * @param Request $request
     * @param CityRepository $cityRepository
     * @return RedirectResponse|Response
     */
    public function city_list(Request $request, CityRepository $cityRepository)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $cities = $cityRepository->findBy([],['name' => 'ASC']);

        uasort($cities, function ($a, $b) {
            //return ($a->getRegion()->getName() < $b->getRegion()->getName()) ? -1 : 1;
            if ($a->getRegion()->getName() < $b->getRegion()->getName()) return -1;
            if ($a->getRegion()->getName() == $b->getRegion()->getName()) {
                if ($a->getName() < $b->getName()) return -1;
            }
            return 1;
        });
        //$cities = new ArrayCollection(iterator_to_array($iterator));

        return $this->render('venue/index.city.html.twig', [
            'list' => true,
            'cities' => $cities
        ]);
    }

}
