<?php
/**
 *  commeent for the file
 */
namespace App\Controller;

use App\Entity\Food;
use App\Entity\Review;
use App\Form\FoodType;
use App\Utils\ImageUploader;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Food pages controller
 * @Route("/food", name="food_")
 * Class FoodController
 * @package App\Controller
 */
class FoodController extends Controller
{
    /**
     * Gets the food home page
     * @Route("/", name="index")
     * @return Response
     */
    public function index()
    {
        if($this->isGranted("ROLE_USER")) {
            $foods = $this->getDoctrine()
                ->getRepository(Food::class)
                ->findAll();
        } else{
            $foods = $this->getDoctrine()
                ->getRepository(Food::class)
                ->findBy([
                    'isPublic' => true,
                ]);
        }

        $photoLink = [];

        foreach ($foods as $food)
        {
            $photo = $this->getPhotoLinks($food->getPhotoLink())[0];
            array_push($photoLink, $photo);
        }


        return $this->render('food/index.html.twig', [
            'foods' => $foods,
            'photos' => $photoLink
        ]);
    }

    /**
     * shows all of the foods added by a user
     * @Route("/user/{id}", name="show_users")
     * @return Response
     */
    public function showAllUsersPosts(Request $request)
    {
        $id = $request->get('id');

        $foods = $this->getDoctrine()->getRepository(Food::class)->findBy(['addedBy' => $id]);

        $photoLink = [];

//        foreach ($foods as $food)
//        {
//            $photo = $this->getPhotoLinks($food->getPhotoLink())[0];
//            array_push($photoLink, $photo);
//        }


        return $this->render('food/users_food_list.html.twig', [
            'foods' => $foods,
            'photos' => $photoLink
        ]);
    }

    /**
     * the detailed page of the foods
     * @Route("/detail/{id}", name="show_detail")
     * @Method("GET")
     */
    public function showFoodDetailAction(Food $food)
    {
        if(!$food->getisPublic() && !$this->isGranted("ROLE_USER"))
        {
            $this->addFlash('error', 'Access not granted');
            return $this->redirectToRoute("food_index");
        }

        $reviewRp = $this->getDoctrine()->getRepository(Review::class);
        $reviews = $reviewRp->findBy(
            [
                'food' => $food->getId(),
        ], array('review_score' => 'DESC'));

        $averageScore = 0;

        foreach ($reviews as $review)
        {
            $averageScore += floatval($review->getStars());
        }

        $photos = $food->getPhotoLink();
        $photoList = $this->getPhotoLinks($photos);

        if(sizeof($reviews) > 0) {
            $averageScore = $averageScore / sizeof($reviews);
        }

        return $this->render('food/detail.html.twig', [
            'food' => $food,
            'average' => $averageScore,
            'reviews' => $reviews,
            'photos' => $photoList
        ]);
    }

    /**
     * new food page
     * @Route("/new", name="new")
     * @Method({"GET", "POST"})
     */
    public function new(Request $request)
    {
        if($this->getUser() != null) {
            $user_id = $this->getUser()->getId();
        } else{
            $this->addFlash('error', 'You must be logged in for this action');
            return $this->redirectToRoute('home');
        }

        $userRP = $this->getDoctrine()->getRepository('App:User');
        $user = $userRP->find($user_id);

        $food = new Food();
        $form = $this->createForm(FoodType::class, $food);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageUploader = new ImageUploader($request->files->get('food')['photoLink']);
            $fileAddress = $imageUploader->beginUpload();

            if(!empty($request->files->get('food')['photoLink']) && $fileAddress == null)
            {
                $this->addFlash('error', 'There was a probelm with your images');
                return $this->redirectToRoute('food_new');
            }

           // var_dump($fileAddress); die();
            $arrayString = '';

            foreach($fileAddress as $address)
            {
                $arrayString .= '{'. $address .'},';
            }


            $date = new \DateTime(date('Y-m-d'));

            $food->setDateAdded($date);
            $food->setAddedBy($user);
            $food->setPhotoLink($arrayString);
            $food->setIsPublic(false);

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

//    /**
//     * @Route("/{id}", name="show")
//     * @Method("GET")
//     */
//    public function show(Food $food)
//    {
//        return $this->render('food/show.html.twig', [
//            'food' => $food,
//        ]);
//    }

    /**
     * edit the food page
     * @Route("/{id}/edit", name="edit")
     * @Method({"GET", "POST"})
     */
    public function edit(Request $request, Food $food)
    {
        $form = $this->createForm(FoodType::class, $food);
        $form->handleRequest($request);

        if($this->getUser() == null)
        {
            $this->addFlash('error', 'You must be logged in for that');
            return $this->redirectToRoute('/');
        }

        $user_id = $this->getUser()->getId();

        if(!in_array('ROLE_ADMIN', $this->getUser()->getRoles()) && $user_id != $food->getAddedBy()->getId())
        {
            $this->addFlash('error', 'You do not have access to do that');


            return $this->redirectToRoute('/');
        }

        if ($form->isSubmitted() && $form->isValid()) {

            if($form['food[photoLink]'][0] == null)
            {
                $food->setPhotoLink($food->getPhotoLink());
            }

            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('food_edit', ['id' => $food->getId()]);
        }

        return $this->render('food/edit.html.twig', [
            'food' => $food,
            'form' => $form->createView(),
        ]);
    }

    /**
     * delete the food page
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Request $request, Food $food)
    {
//        if (!$this->isCsrfTokenValid('delete'.$food->getId(), $request->request->get('_token'))) {
//            return $this->redirectToRoute('food_index');
//        }


        $reviewManager = $this->getDoctrine()->getRepository(Review::class);
        $reviews = $reviewManager->findBy(['food' => $food->getId()]);
        $reviewManager->deleteReviews($reviews);

        $em = $this->getDoctrine()->getManager();
        $em->remove($food);
        $em->flush();

        return $this->redirectToRoute('food_index');
    }

//    /**
//     * @Route("/list/{id}", name="show_list")
//     */
//    public function showFoodsForUser(Request $request)
//    {
//        $user_id = $request->getSession()->get('user_id');
//        $foodRP = $this->getDoctrine()->getRepository(Food::class);
//
//        $foodList = $foodRP->findBy(['addedBy' => $user_id]);
//
//
//        $args = [
//                'foods' => $foodList,
//                'user_id' => $user_id
//            ];
//
//        $template = 'food\index.html.twig';
//
//        return $this->render($template, $args);
//    }

    /**
     * processes the foods images
     * @param string $fileString
     * @return array
     */
    private function getPhotoLinks($fileString)
    {
        $array = [];

        if($fileString != null)
        {
            $temp = explode(",", $fileString);

            foreach ($temp as $photo)
            {
                if($photo != "" || !empty($photo)) {

                    $photo = str_replace('{', '', $photo);
                    $photo = str_replace('}', '', $photo);
                    $photo = trim($photo);

                    array_push($array, $photo);
                }
            }
        }

        return $array;
    }

    /**
     * search system for the food page
     * @Route("/search", name="process_search")
     * @return Response
     */
    public function foodSearch(Request $request)
    {
        $textSearch = $request->get('text_search');
        $date = $request->get('date_search');
        $priceRange = $request->get('price_range');

        $foods = [];
        
        if($textSearch != "" && !empty($textSearch))
        {
            $checkFoods = $this->getDoctrine()->getRepository(Food::class)->findAll();
            foreach ($checkFoods as $food)
            {
                $nameOfFood = $food->getTitle();
                if(strpos( strtolower($nameOfFood),  strtolower($textSearch)) !== false)
                {
                    $foods[] = $food;
                }
            }
        }

        if($date != '' && !empty($date))
        {
            $datetime = new \DateTime($date);

            if(empty($foods))
            {
                $checkFoods = $this->getDoctrine()->getRepository(Food::class)->findBy(['dateAdded' => $datetime]);
                $foods = $checkFoods;
            } else{

                $temp = [];

                foreach ($foods as $food)
                {
                    if($food->getDateAdded() == $datetime)
                    {
                        $temp[] = $food;
                    }
                }

                $foods = $temp;
            }
        }

        if($priceRange != '' && !empty($priceRange))
        {
            if(empty($foods))
            {
                $checkFoods = $this->getDoctrine()->getRepository(Food::class)->findAll();
                foreach ($checkFoods as $food)
                {
                    if($this->getCheckFoodForPriceRange($priceRange, $food))
                    {
                        $foods[] = $food;
                    }
                }
            } else{

                $temp = [];

                foreach ($foods as $food)
                {
                    if($this->getCheckFoodForPriceRange($priceRange, $food))
                    {
                        $temp[] = $food;
                    }
                }

                $foods = $temp;
            }
        }

        $photoLink = [];

        foreach ($foods as $food)
        {
            $photo = $this->getPhotoLinks($food->getPhotoLink())[0];
            array_push($photoLink, $photo);
        }


        return $this->render('food/index.html.twig', [
            'foods' => $foods,
            'photos' => $photoLink
        ]);

    }

    /**
     * checks of the food is in a particular range
     * @param string $priceValue
     * @param Food $food
     * @return bool
     */
    public function getCheckFoodForPriceRange($priceValue, $food)
    {
        $price = $food->getPrice();
        switch ($priceValue)
        {
            case 0:
                if($price <= 1)
                {
                    return true;
                }
            case 1:
                if($price > 1 && $price <= 3 )
                {
                    return true;
                }
            case 2:
                if($price > 3 && $price <= 5)
                {
                    return true;
                }
            case 3:
                if($price > 5)
                {
                    return true;
                }
            default:
                return false;
        }
    }
}
