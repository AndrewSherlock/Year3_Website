<?php

namespace App\Controller;

use App\Entity\Food;
use App\Entity\SuggestedProduct;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * @Route("/admin", name="admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/", name="_home")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function index()
    {
        $template = 'admin/index.html.twig';
        $args = ['controller_name' => 'Admin Panel'];


        return $this->render($template, $args);
    }

    /**
     * @Route("/userList", name="_users")
     * @Security("has_role('ROLE_ADMIN')")
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
     * @Route("/foodList", name="_foods")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function showFoodList()
    {
        $template = 'admin/show_foods.html.twig';
        $foods = $this->getDoctrine()->getRepository(Food::class)->findAll();

        $args = [
            'controller_name' => 'Admin Panel - foods',
            'foodlist' => $foods
        ];


        return $this->render($template, $args);
    }

    /**
     * @Route("/approveList", name="_approveList")
     * @Security("has_role('ROLE_ADMIN')")
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
     * @Route("/accept_public/{id}", name="_accept")
     * @Security("has_role('ROLE_ADMIN')")
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
     * @Route("/accept_public/{id}", name="_reject")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function rejectPublicItem(Request $request)
    {
        $id = $request->get('id');
        $this->getDoctrine()->getRepository(SuggestedProduct::class)->removeSuggestedItems($id);
        $this->addFlash('success', 'Item not set to public');

        return $this->redirectToRoute('admin_foods');
    }

    /**
     * @Route("/promote/{id}", name="_promote")
     * @Security("has_role('ROLE_ADMIN')")
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
     * @Route("/demote/{id}", name="_demote")
     * @Security("has_role('ROLE_ADMIN')")
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
     * @Route("/delete/{id}", name="_delete_user")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function adminDelete(Request $request)
    {
        $id = $request->get('id');
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id' => $id]);

        $this->addFlash('success', "User deleted");
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('admin_users');
    }
}
