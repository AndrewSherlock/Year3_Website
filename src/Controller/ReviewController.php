<?php

/**
 * Comment for the file
 */
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
 * The review system controller
 * @Route("/review", name="review_")
 * Class ReviewController
 * @package App\Controller
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
     * When a user wants to create a new review for a food
     * @Route("/new/{id}", name="new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newReviewAction(Request $request)
    {
        $id = $request->get('id');
        $user_id = $this->getUser()->getId();
        $template = 'review/new.html.twig';
        $review = new Review();

        $form = $this->createFormBuilder($review)
            ->add('summary', TextType::class)
            ->add('placeOfPurchase', TextType::class)
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
            $review->setPlaceOfPurchase($reviewValues['placeOfPurchase']);
            $review->setSummary($reviewValues['summary']);
            $review->setStars($reviewValues['stars']);
            $review->setReviewScore(0);
            $review->setIsPublic(false);

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

    }

    /**
     * Used to set the score the review depending on the thumbs up and down
     * @Route("/setScore/{id}", name="set_score")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function setScore(Request $request)
    {
        $id = $request->get('id');
        $food_id = $request->get('food_id');
        $value = $request->get('value');

        $reviewRP = $this->getDoctrine()->getManager()->getRepository(Review::class);
        $reviewRP->changeReviewScore($id, $value);

        $this->addFlash('success', 'Review voted');
        return $this->redirectToRoute('food_show_detail',array('id' => $food_id));
    }

//    /**
//     * @Route("/{id}", name="show")
//     * @Method("GET")
//     */
//    public function show(Review $review)
//    {
//        return $this->render('review/show.html.twig', [
//            'review' => $review,
//        ]);
//    }
//
//    /**
//     * @Route("/{id}/edit", name="edit")
//     * @Method({"GET", "POST"})
//     */
//    public function edit(Request $request, Review $review)
//    {
//        $form = $this->createForm(ReviewType::class, $review);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $this->getDoctrine()->getManager()->flush();
//
//            $this->addFlash('success', 'Review edited successfully.');
//            return $this->redirectToRoute('food_show_detail', ['id' => $review->getFood()->getId()]);
//        }
//
//        return $this->render('review/edit.html.twig', [
//            'review' => $review,
//            'form' => $form->createView(),
//        ]);
//    }

//    /**
//     * @Route("/{id}/delete", name="delete")
//     */
//    public function delete(Request $request, Review $review)
//    {
////        if (!$this->isCsrfTokenValid('delete'.$review->getId(), $request->request->get('_token'))) {
////            return $this->redirectToRoute('review_index');
////        }
//
//        $em = $this->getDoctrine()->getManager();
//        $em->remove($review);
//        $em->flush();
//
//        $this->addFlash('success', 'Review deleted successfully.');
//        return $this->redirectToRoute('food_show_detail', ['id'=>$review->getFood()->getId()]);
//    }

//    /**
//     * @Route("/show_users/{id}", name="show_users")
//     */
//    public function showUsersReviews(Request $request)
//    {
//        $id = $request->get('id');
//
//        $reviews = $this->getDoctrine()->getRepository(Review::class)->findBy(['addedBy' => $id]);
//
//        return $this->render('review/show_users.html.twig', [
//            'reviews' => $reviews,
//        ]);
//    }

}
