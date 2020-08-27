<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\CustomerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/backend")
 */
class CustomerController extends AbstractController
{
    /**
     * @Route({
     *     "en": "/customers",
     *     "es": "/clientes"
     * }, name="customers")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();

        $entity_repo = $this->getDoctrine()->getRepository(Customer::class);
        $rows = $entity_repo->findBy([],['id' => 'DESC']);

        return $this->render('customer/index.html.twig', [
            'rows' => $rows,
        ]);

    }

    /**
     * @Route({
     *     "en": "/customers/mine",
     *     "es": "/mis-clientes"
     * }, name="customers_mine")
     */
    public function myTasks(UserInterface $user)
    {
        $rows = $user->getCustomers();

        return $this->render('customer/index.html.twig', [
            'rows' => $rows,
        ]);
    }


    /**
     * @Route({
     *     "en": "/customer/create",
     *     "es": "/cliente/crear"
     * }, name="customer_create")
     */
    public function create(Request $request, UserInterface $user)
    {
        $entity = new Customer();
        $form = $this->createForm(CustomerType::class, $entity);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entity->setCreatedAt(new \DateTime());
            $entity->setUser($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect(
                $this->generateUrl("customers_mine"/*, ['id' => $entity->getId()]*/)
            );
        }

        return $this->render('customer/create.html.twig', array(
            'form' => $form->createView()
        ));
    }


    /**
     * @Route({
     *     "en": "/customer/edit/{id}",
     *     "es": "/cliente/editar/{id}"
     * }, name="customer_edit")
     */
    public function edit(Request $request, UserInterface $user, Customer $customer)
    {
        if ($user && $user->getId() != $customer->getUser()->getId()) {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
            //return $this->redirectToRoute("tasks");
        }

        $form = $this->createForm(CustomerType::class, $customer);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();

            return $this->redirect(
                $this->generateUrl("customers_mine")
            );
        }

        return $this->render('customer/create.html.twig', array(
            'form' => $form->createView(),
            'edit' => true
        ));
    }

    /**
     * @Route({
     *     "en": "/customer/delete/{id}",
     *     "es": "/cliente/borrar/{id}"
     * }, name="customer_delete")
     */
    public function delete (Customer $customer, UserInterface $user) {
        if (!$customer || !$user || ($user->getId() != $customer->getUser()->getId())) {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
            //return $this->redirectToRoute("tasks");
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($customer);
        $em->flush();

        return $this->redirectToRoute("customers_mine");

    }
}
