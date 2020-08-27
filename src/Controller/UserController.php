<?php

namespace App\Controller;

use App\Form\UserPasswordChangeType;
use App\Service\CustomEmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;
use App\Form\RegisterType;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route({
     *     "en": "/backend/users",
     *     "es": "/backend/usuarios"
     * }, name="users")
     */
    public function index()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $em = $this->getDoctrine()->getManager();

        $user_repo = $this->getDoctrine()->getRepository(User::class);
        //$tasks = $task_repo->findAll();
        $users = $user_repo->findBy([], ['id' => 'DESC']);

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route({
     *     "en": "/register",
     *     "es": "/registro"
     * }, name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder, CustomEmailService $customEmailService)
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user, array(
            "isAdmin" => $this->isGranted('ROLE_ADMIN'),
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRole("ROLE_GUEST");
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);
            $user->setCreatedAt(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $customEmailService->signUpEmail($user);

            return $this->redirectToRoute("tasks");
        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route({
     *     "en": "/backend/user/password-change",
     *     "es": "/backend/usuario/cambio-password"
     * }, name="user_password_change")
     */
    public function passwordChange(Request $request, UserPasswordEncoderInterface $encoder)
    {

        $form = $this->createForm(UserPasswordChangeType::class );

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $old_pwd = $request->request->get('user_password_change')['old_password'];
            $new_pwd = $request->get('user_password_change')['password']['first'];
            $new_pwd_confirm = $request->get('user_password_change')['password']['second'];

            $user = $this->getUser();
            $checkPass = $encoder->isPasswordValid($user, $old_pwd);

            if($checkPass === true) {
                $new_pwd_encoded = $encoder->encodePassword($user, $new_pwd_confirm);
                $user->setPassword($new_pwd_encoded);

                dump($new_pwd_confirm);

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                return $this->redirectToRoute("home");
            } else {
                $this->addFlash(
                    'error',
                    'El password actual no es válido'
                );
            }




        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route({
     *     "en": "/backend/user/edit/{id}",
     *     "es": "/backend/usuario/editar/{id}"
     * }, name="user_edit")
     */
    public function edit(Request $request, UserInterface $user, User $user_edit)
    {
        if ($user && $user->getId() != $user_edit->getId()) {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
            //return $this->redirectToRoute("users");
        }

        $form = $this->createForm(RegisterType::class, $user_edit, array(
            "require_role" => $this->isGranted('ROLE_ADMIN'),
            "isAdmin" => $this->isGranted('ROLE_ADMIN'),
            "edit" => true,
            "submit_label" => "Guardar",
        ));

        $form->remove('password');

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute("users");
        }


        return $this->render('user/register.html.twig', [
            'form' => $form->createView(),
            'edit' => true
        ]);
    }

    /**
     * @Route({
     *     "en": "/backend/user/delete/{id}",
     *     "es": "/backend/usuario/borrar/{id}"
     * }, name="user_delete")
     */
    public function delete(User $user_delete, UserInterface $user)
    {
        if (!$user_delete || !$user) {
            throw $this->createAccessDeniedException();
        }
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $em = $this->getDoctrine()->getManager();
        $em->remove($user_delete);
        $em->flush();

        return $this->redirectToRoute("users");

    }

    /**
     * @Route({
     *     "en": "/login",
     *     "es": "/inicio-sesion"
     * }, name="login")
     */
    public function login(AuthenticationUtils $au)
    {
        $error = $au->getLastAuthenticationError();

        $lastUsername = $au->getLastUsername();

        return $this->render('user/login.html.twig', array(
            'error' => $error,
            'last_username' => $lastUsername
        ));
    }
}
