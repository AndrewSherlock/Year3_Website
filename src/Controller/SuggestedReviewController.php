<?php

namespace App\Controller;

use App\Entity\Review;
use App\Entity\SuggestedReview;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * @Route("/suggested_review", name="suggested_review_")
 */
class SuggestedReviewController extends Controller
{
    /**
     * @Route("/suggested_review/new/{id}", name="new")
     */
    public function newSuggestedProduct(Request $request)
    {
        $id = $request->get('id');
        $review = $this->getDoctrine()->getRepository(Review::class)->find($id);

        $suggestedReview = new SuggestedReview();
        $suggestedReview->setReview($review);

        $em = $this->getDoctrine()->getManager();
        $em->persist($suggestedReview);
        $em->flush();

        return $this->redirectToRoute('food_show_detail', ['id' => $review->getFood()->getId()]);
    }
}
