<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;

use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
        $session = new Session();
        $user = $session->get('user_id');

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'user_id' => $user
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
    public function loginAction(Request $request)
    {
        $template = 'default/login.html.twig';

        $user = new User();

        $form = $this->createFormBuilder($user)
            ->add('username', TextType::class)
            ->add('password', PasswordType::class)
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
                $this->addFlash('error', 'No such user found.');
                return $this->redirectToRoute('home');;
            }

            if(password_verify($password, $user_info_array['password']))
            {
                $session = new Session();
                $session->set('user_id', $user_info_array['id']);
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

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        $session = new Session();

        //$session->set('user', null);
        $session->clear();
        return $this->redirectToRoute('home');
    }
}
