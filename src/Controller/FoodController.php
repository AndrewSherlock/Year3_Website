<?php

namespace App\Controller;

use App\Entity\Food;
use App\Entity\Review;
use App\Form\FoodType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/food", name="food_")
 */
class FoodController extends Controller
{
    /**
     * @Route("/", name="index")
     *
     * @return Response
     */
    public function index()
    {
        $foods = $this->getDoctrine()
            ->getRepository(Food::class)
            ->findAll();

        return $this->render('food/index.html.twig', ['foods' => $foods]);
    }

    /**
     * @Route("/detail/{id}", name="show_detail")
     * @Method("GET")
     */
    public function showFoodDetailAction(Food $food)
    {
        $reviewRp = $this->getDoctrine()->getRepository(Review::class);
        $reviews = $reviewRp->findBy(['food' => $food->getId()]);

        $averageScore = 0;

        foreach ($reviews as $review)
        {
            $averageScore += floatval($review->getStars());
        }

        $averageScore = $averageScore / sizeof($reviews);

        return $this->render('food/detail.html.twig', [
            'food' => $food,
            'average' => $averageScore,
            'reviews' => $reviews
        ]);
    }

    /**
     * @Route("/new", name="new")
     * @Method({"GET", "POST"})
     */
    public function new(Request $request)
    {
        $user_id  = $request->getSession()->get('user_id');
        $userRP = $this->getDoctrine()->getRepository('App:User');
        $user = $userRP->find($user_id);

        if($user_id == null)
        {
            $this->addFlash('error', 'You must be logged in for this action');
            return $this->redirectToRoute('home');
        }

        $food = new Food();
        $form = $this->createForm(FoodType::class, $food);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $date = new \DateTime(date('Y-m-d'));

            $food->setDateAdded($date);
            $food->setAddedBy($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($food);
            $em->flush();

            return $this->redirectToRoute('food_index');
        }

        return $this->render('food/new.html.twig', [
            'food' => $food,
            'form' => $form->createView(),
            'user_id' => $user_id
        ]);
    }

    /**
     * @Route("/{id}", name="show")
     * @Method("GET")
     */
    public function show(Food $food)
    {
        return $this->render('food/show.html.twig', [
            'food' => $food,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit")
     * @Method({"GET", "POST"})
     */
    public function edit(Request $request, Food $food)
    {
        $form = $this->createForm(FoodType::class, $food);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('food_edit', ['id' => $food->getId()]);
        }

        return $this->render('food/edit.html.twig', [
            'food' => $food,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete")
     * @Method("DELETE")
     */
    public function delete(Request $request, Food $food)
    {
        if (!$this->isCsrfTokenValid('delete'.$food->getId(), $request->request->get('_token'))) {
            return $this->redirectToRoute('food_index');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($food);
        $em->flush();

        return $this->redirectToRoute('food_index');
    }

    /**
     * @Route("/list/{id}", name="show_list")
     */
    public function showFoodsForUser(Request $request)
    {
        $user_id = $request->getSession()->get('user_id');
        $foodRP = $this->getDoctrine()->getRepository(Food::class);

        $foodList = $foodRP->findBy(['addedBy' => $user_id]);


        $args = [
                'foods' => $foodList,
                'user_id' => $user_id
            ];

        $template = 'food\index.html.twig';

        return $this->render($template, $args);
    }
}
