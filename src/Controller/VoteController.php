<?php

namespace App\Controller;

use App\Entity\Review;
use App\Entity\User;
use App\Entity\Vote;
use App\Form\VoteType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/vote", name="vote_")
 */
class VoteController extends Controller
{
//    /**
//     * @Route("/", name="index")
//     *
//     * @return Response
//     */
//    public function index()
//    {
//        $votes = $this->getDoctrine()
//            ->getRepository(Vote::class)
//            ->findAll();
//
//        return $this->render('vote/index.html.twig', ['votes' => $votes]);
//    }

    /**
     * @Route("/new", name="new")
     * @Method({"GET", "POST"})
     */
    public function new(Request $request)
    {
        $user_id = $this->getUser();

        $id = $request->get('id');
        $food_id = $request->get('food_id');
        $voteValue = $request->get('vote');

        $voteRp = $this->getDoctrine()->getRepository(Vote::class);
        $conflict = $voteRp->findBy(['review' => $id]);

        if($conflict != null)
        {
            $this->addFlash('error', 'You can not vote twice');
            return $this->redirectToRoute('food_show_detail', array('id' => $food_id));
        }

        $vote = new Vote();
        $vote->setVoteType($voteValue);

        $reviewRp = $this->getDoctrine()->getManager()->getRepository(Review::class);
        $review = $reviewRp->find($id);
        $vote->setReview($review);

        $userRp = $this->getDoctrine()->getManager()->getRepository(User::class);
        $user = $userRp->find($user_id);
        $vote->setUser($user);

        $em = $this->getDoctrine()->getManager();
        $em->persist($vote);
        $em->flush();

        return $this->redirectToRoute('review_set_score', array('id' => $id, 'value' => $vote->getVoteType(), 'food_id' => $food_id));
    }

//    /**
//     * @Route("/{id}", name="delete")
//     * @Method("DELETE")
//     */
//    public function delete(Request $request, Vote $vote)
//    {
//        if (!$this->isCsrfTokenValid('delete'.$vote->getId(), $request->request->get('_token'))) {
//            return $this->redirectToRoute('vote_index');
//        }
//
//        $em = $this->getDoctrine()->getManager();
//        $em->remove($vote);
//        $em->flush();
//
//        return $this->redirectToRoute('vote_index');
//    }
}
