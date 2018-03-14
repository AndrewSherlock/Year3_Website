<?php

namespace App\Controller;

use App\Entity\Review;
use App\Form\ReviewType;

use App\Entity\Food;
use App\Entity\User;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/review", name="review_")
 */
class ReviewController extends Controller
{
//    /**
//     * @Route("/", name="index")
//     *
//     * @return Response
//     */
//    public function index()
//    {
//        $reviews = $this->getDoctrine()
//            ->getRepository(Review::class)
//            ->findAll();
//
//        return $this->render('review/index.html.twig', ['reviews' => $reviews]);
//    }

    /**
     * @Route("/new/{id}", name="new")
     * @Method({"GET", "POST"})
     */
    public function newReviewAction(Request $request)
    {
        $id = $request->get('id');
        $user_id = $request->getSession()->get('user_id');
        $template = 'review/new.html.twig';
        $review = new Review();

        $form = $this->createFormBuilder($review)
            ->add('summary', TextType::class)
            ->add('price', NumberType::class)
            ->add('stars', NumberType::class)
            ->add('login', SubmitType::class,
                array('label' => 'Submit Review'))->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isSubmitted())
        {
            $reviewValues = $request->get('form');

            if($reviewValues['stars'] > 5 || $reviewValues['stars'] < 0)
            {
                $this->addFlash('error', 'Enter a value between 0 and 5');
                return $this->redirectToRoute('review_new', array( 'id' => $id));
            }

            $date = new \DateTime(date('Y-m-d'));

            $review->setDate($date);
            $review->setPrice($reviewValues['price']);
            $review->setSummary($reviewValues['summary']);
            $review->setStars($reviewValues['stars']);

            $foodRp = $this->getDoctrine()->getRepository(Food::class);
            $food = $foodRp->find($id);
            $review->setFood($food);

            $userRp = $this->getDoctrine()->getRepository(User::class);
            $user = $userRp->find($user_id);
            $review->setAddedBy($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($review);
            $em->flush();

            return $this->redirectToRoute('food_show_detail', array('id' => $id));
        }

        $args =[
            'form' => $form->createView(),
            'product_id' => $id,
            'user_id' => $user_id
        ];

        return $this->render($template, $args);

//        $review = new Review();
//        $form = $this->createForm(ReviewType::class, $review);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($review);
//            $em->flush();
//
//            return $this->redirectToRoute('review_edit', ['id' => $review->getId()]);
//        }
//
//        return $this->render('review/new.html.twig', [
//            'review' => $review,
//            'form' => $form->createView(),
//        ]);
    }

    /**
     * @Route("/{id}", name="show")
     * @Method("GET")
     */
    public function show(Review $review)
    {
        return $this->render('review/show.html.twig', [
            'review' => $review,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit")
     * @Method({"GET", "POST"})
     */
    public function edit(Request $request, Review $review)
    {
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('review_edit', ['id' => $review->getId()]);
        }

        return $this->render('review/edit.html.twig', [
            'review' => $review,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete")
     * @Method("DELETE")
     */
    public function delete(Request $request, Review $review)
    {
        if (!$this->isCsrfTokenValid('delete'.$review->getId(), $request->request->get('_token'))) {
            return $this->redirectToRoute('review_index');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($review);
        $em->flush();

        return $this->redirectToRoute('review_index');
    }
}
