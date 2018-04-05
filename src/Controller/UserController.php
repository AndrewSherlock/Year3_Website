<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/user", name="user_")
 */
class UserController extends Controller
{
    /**
     * @Route("/", name="index")
     *
     * @return Response
     */
    public function index()
    {
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        return $this->render('user/index.html.twig', ['users' => $users]);
    }

    /**
     * @Route("/new", name="new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $session = $request->getSession();
        $data = $session->get('data');
        $session->set('data', null);


        $userRp = $this->getDoctrine()->getRepository('App:User');
        $foundUser  = $userRp->findOneByUsername($data['username']);

        if($foundUser)
        {
            $this->addFlash('error', 'User already exists');
            return $this->redirectToRoute('register');
        }

        $user = new User();
        $user->setUsername($data['username']);

        $newPassword = password_hash($data['password'], PASSWORD_BCRYPT);
        $user->setPassword($newPassword); //TODO add requirment checks to fields

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $this->addFlash('success', 'User successfully created');

        if($this->getUser() != null && in_array('ROLE_ADMIN',  $user->getRoles()))
        {
            return $this->redirectToRoute('admin_users');
        }

        return $this->redirectToRoute('login');
    }

    /**
     * @Route("/{id}", name="show")
     * @Method("GET")
     */
    public function show(User $user, Request $request)
    {
        if($this->getUser() != null)
            $user_id = $this->getUser()->getId();
        else{
            return $this->redirectToRoute('login');
        }

        if($this->getUser() != null && $user->getId() != $user_id)
        {
            if(!in_array('ROLE_ADMIN', $this->getUser()->getRoles()))
            {
                $this->addFlash('error', 'You do not have the access to do this');
                return $this->redirectToRoute('login');
            }
        }

        return $this->render('user/show.html.twig', [
            'user' => $user,
            'user_id' => $user_id
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit")
     * @Method({"GET", "POST"})
     */
    public function edit(Request $request, User $user)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $edittingUser = $this->getUser()->getId();

            if($user->getId() == $edittingUser) {
                return $this->redirectToRoute('user_edit', ['id' => $user->getId()]);
            } else {
                return $this->redirectToRoute('admin_users');
            }
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
 * @Route("delete/{id}", name="delete")
 * @Method("DELETE")
 */
    public function delete(Request $request, User $user)
    {
//        if (!$this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
//            return $this->redirectToRoute('user_index');
//        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('user_index');
    }
}
