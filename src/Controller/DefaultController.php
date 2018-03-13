<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $session = new Session();
        $user = $session->get('user');

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'user' => $user
        ]);
    }

    /**
     * @Route("/login", name="login", methods={"GET", "POST"})
     */
    public function loginAction(Request $request)
    {
        $template = 'default/login.html.twig';

        $user = new User();

        $form = $this->createFormBuilder($user)
            ->add('username', TextType::class)
            ->add('password', TextType::class)
            ->add('login', SubmitType::class,
                array('label' => 'Login'))->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $username = $request->request->get('form')['username'];
            $password = $request->request->get('form')['password'];

            $userRp =  $this->getDoctrine()->getRepository('App:User');
            $user_info_array = $userRp->findOneByUsername($username);

            if($user_info_array == null || empty($user_info_array))
            {
                return;
            }

            if(password_verify($password, $user_info_array['password']))
            {
                $session = new Session();
                $session->set('user', $username);
                return $this->redirectToRoute('home');
            } else{
                $this->addFlash('error', 'Incorrect login information');
            }
        }

        $args = [
            'login_form' => $form->createView(),
        ];

        return $this->render($template, $args);
    }
}
