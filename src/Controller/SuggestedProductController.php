<?php

namespace App\Controller;

use App\Entity\Food;
use App\Entity\SuggestedProduct;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/user", name="suggested_product_")
 */
class SuggestedProductController extends Controller
{
    /**
     * @Route("/suggested/product", name="suggested_product")
     */
    public function index()
    {
        return $this->render('suggested_product/index.html.twig', [
            'controller_name' => 'SuggestedProductController',
        ]);
    }

    /**
     * @Route("/suggested/new/{id}", name="new")
     */
    public function newSuggestedProduct(Request $request)
    {
        $id = $request->get('id');
        $food = $this->getDoctrine()->getRepository(Food::class)->find($id);

        $suggestProduct = new SuggestedProduct();
        $suggestProduct->setFood($food);

        $em = $this->getDoctrine()->getManager();
        $em->persist($suggestProduct);
        $em->flush();

        return $this->redirectToRoute('food_show_detail', ['id' => $food->getId()]);

    }
}
