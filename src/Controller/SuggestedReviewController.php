<?php
/**
 * comment for the file
 */
namespace App\Controller;

use App\Entity\Review;
use App\Entity\SuggestedReview;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Suggested public review system
 * @Route("/suggested_review", name="suggested_review_")
 * Class SuggestedReviewController
 * @package App\Controller
 */
class SuggestedReviewController extends Controller
{
    /**
     * add a new suggeestion for public reviews
     * @Route("/suggested_review/new/{id}", name="new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
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
