<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;

use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/register", name="register") methods={"GET", "POST"}
     */
    public function registerAction(Request $request)
    {
        //$session = new Session();
        $session = $request->getSession();
        $user = new User();
        $template = 'default/register.html.twig';

        if($session->get("user_id") != null)
        {
            $this->addFlash('error', 'You cannot do this while logged in');
            return $this->redirectToRoute('home');
        }

        $form = $this->createFormBuilder($user)
            ->add('username', TextType::class)
            ->add('password', RepeatedType::class,
                array(
                    'type' => PasswordType::class,
                    'invalid_message' => 'Passwords must match',
                    'required' => true,
                    'first_options' => array('label' => 'Password'),
                    'second_options' => array('label' => 'Retype Password')
                ))
            ->add('login', SubmitType::class,
                array('label' => 'Register'))->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $username = $request->request->get('form')['username'];
            $password = $request->request->get('form')['password']['first'];
            $retype =  $request->request->get('form')['password']['second'];

            $args = [
                'username' => $username,
                'password' => $password,
                'confirm' => $retype
            ];

            $session->set('data', $args);

            return $this->redirectToRoute('user_new');
        }

        $args = [
            'form' => $form->createView(),
        ];

        return $this->render($template, $args);


    }

    /**
     * @Route("/login", name="login", methods={"GET", "POST"})
     */
    public function loginAction(Request $request, AuthenticationUtils $authUtils)
    {
        $template = 'default/login.html.twig';
        $error = $authUtils->getLastAuthenticationError();
        $lastName = $authUtils->getLastUsername();

        $user = new User();

        $form = $this->createFormBuilder($user)
            ->add('username', TextType::class, array( 'data' => $lastName))
            ->add('password', PasswordType::class)
            ->add('login', SubmitType::class,
                array('label' => 'Login'))->getForm();


        $args = [
            'login_form' => $form->createView(),
            'error' => $error,
            'lastname' => $lastName
        ];

        return $this->render($template, $args);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
//        $session = new Session();
//
//        //$session->set('user', null);
//        $session->clear();
//        return $this->redirectToRoute('home');
    }
}
