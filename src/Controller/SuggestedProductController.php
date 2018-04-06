<?php
/**
 * comment for file
 */
namespace App\Controller;

use App\Entity\Food;
use App\Entity\SuggestedProduct;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Suggested public foods controller
 * @Route("/suggested_product", name="suggested_product_")
 * Class SuggestedProductController
 * @package App\Controller
 */
class SuggestedProductController extends Controller
{
    /**
     * add a new suggestion
     * @Route("/suggested/new/{id}", name="new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
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
