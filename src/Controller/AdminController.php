<?php
/**
 * comment for the file
 */
namespace App\Controller;

use App\Entity\Category;
use App\Entity\Food;
use App\Entity\Review;
use App\Entity\SuggestedProduct;
use App\Entity\SuggestedReview;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Controls the admin section
 * @Route("/admin", name="admin")
 * Class AdminController
 * @package App\Controller
 */
class AdminController extends Controller
{
    /**
     *  Gets the home page of the admin panel
     * @Route("/", name="_home")
     * @Security("has_role('ROLE_ADMIN')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $template = 'admin/index.html.twig';
        $args = ['controller_name' => 'Admin Panel'];


        return $this->render($template, $args);
    }

    /**
     * admin user list page
     * @Route("/userList", name="_users")
     * @Security("has_role('ROLE_ADMIN')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showUserList()
    {
        $template = 'admin/show_users.html.twig';
        $userlist = $this->getDoctrine()->getRepository(User::class)->findAll();

        $args = [
            'controller_name' => 'Admin Panel - users',
            'userlist' => $userlist
            ];

        return $this->render($template, $args);
    }

    /**
     *  admin panel food list
     * @Route("/foodList", name="_foods")
     * @Security("has_role('ROLE_ADMIN')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showFoodList()
    {
        $template = 'admin/show_foods.html.twig';
        $foods = $this->getDoctrine()->getRepository(Food::class)->findAll();

        $args = [
            'page_name' => 'Admin Panel - foods',
            'foodlist' => $foods
        ];


        return $this->render($template, $args);
    }

    /**
     * Gets the foods that have to be approved for public viewing
     * @Route("/approveList", name="_approveList")
     * @Security("has_role('ROLE_ADMIN')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showApproveList()
    {
        $template = 'admin/suggestedfoods.html.twig';

        $suggestedPublicFoods = $this->getDoctrine()->getRepository(SuggestedProduct::class)->findAll();

        $args = [
            'controller_name' => 'Admin Panel - approve list',
            'suggestedfoods' => $suggestedPublicFoods
        ];


        return $this->render($template, $args);
    }

    /**
     *  shows our food categorys
     * @Route("/category_list", name="_cat_list")
     * @Security("has_role('ROLE_ADMIN')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showCatList()
    {
        $template = 'admin/category_list.html.twig';

        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();

        $args = [
            'page_name' => 'Admin Panel - Category list',
            'categories' => $categories
        ];


        return $this->render($template, $args);
    }


    /**
     * shows the list of reviews to make public
     * @Route("/approve_review_list", name="_approve_review_list")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function showApproveReviewList()
    {
        $template = 'admin/suggested_public_review.html.twig';

        $suggestedPublicReviews = $this->getDoctrine()->getRepository(SuggestedReview::class)->findAll();

        $args = [
            'controller_name' => 'Admin Panel - approve review list',
            'suggestedReviews' => $suggestedPublicReviews
        ];


        return $this->render($template, $args);
    }

    /**
     * accept food as public
     * @Route("/accept_public/{id}", name="_accept")
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function acceptPublicItem(Request $request)
    {
        $id = $request->get('id');
        $this->getDoctrine()->getRepository(Food::class)->setItemPublic($id);
        $this->getDoctrine()->getRepository(SuggestedProduct::class)->removeSuggestedItems($id);
        $this->addFlash('success', 'Item set to public');

        return $this->redirectToRoute('admin_foods');
    }

    /**
     * reject food as public
     * @Route("/reject_public/{id}", name="_reject")
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function rejectPublicItem(Request $request)
    {
        $id = $request->get('id');
        $this->getDoctrine()->getRepository(SuggestedProduct::class)->removeSuggestedItems($id);
        $this->addFlash('success', 'Item not set to public');

        return $this->redirectToRoute('admin_foods');
    }

    /**
     * promotes users to admin
     * @Route("/promote/{id}", name="_promote")
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function promoteUser(Request $request)
    {
        $id = $request->get('id');
        $nAccount = 'ROLE_ADMIN';

        $this->getDoctrine()->getRepository(User::class)->changeUserAccount($id, $nAccount);

        $this->addFlash('success', 'User account updated');
        return $this->redirectToRoute('admin_users');

    }

    /**
     * demotes users
     * @Route("/demote/{id}", name="_demote")
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function demoteUser(Request $request)
    {
        $id = $request->get('id');
        $nAccount = 'ROLE_USER';

        $this->getDoctrine()->getRepository(User::class)->changeUserAccount($id, $nAccount);

        $this->addFlash('success', 'User account updated');
        return $this->redirectToRoute('admin_users');

    }

    /**
     * the admins page to delete users
     * @Route("/delete/{id}", name="_delete_user")
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function adminDelete(Request $request)
    {
        $id = $request->get('id');
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id' => $id]);

        $reviewManager = $this->getDoctrine()->getRepository(Review::class);
        $reviews = $reviewManager->findBy(['addedBy' => $user->getId()]);
        $reviewManager->deleteReviews($reviews);


        $this->addFlash('success', "User deleted");
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('admin_users');
    }

    /**
     * Accept review as a public review
     * @Route("/accept_public_review/{id}", name="_accept_review")
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function acceptPublicReview(Request $request)
    {
        $id = $request->get('id');
        $this->getDoctrine()->getRepository(Review::class)->setItemPublic($id);
        $this->getDoctrine()->getRepository(SuggestedReview::class)->removeSuggestedItems($id);
        $this->addFlash('success', 'Item set to public');

        return $this->redirectToRoute('admin_foods');
    }

    /**
     * Reject food as a public item
     * @Route("/reject_public_review/{id}", name="_reject_review")
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function rejectPublicReview(Request $request)
    {
        $id = $request->get('id');
        $this->getDoctrine()->getRepository(SuggestedReview::class)->removeSuggestedItems($id);
        $this->addFlash('success', 'Item not set to public');

        return $this->redirectToRoute('admin_foods');
    }
}
