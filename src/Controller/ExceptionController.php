<?php
/**
 * comment for file
 */
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Page 404 controller
 * Class ExceptionController
 * @package App\Controller
 */
class ExceptionController extends Controller
{
    /**
     * function to show the exception
     * @Route("/exception", name="exception")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showException()
    {
        return $this->render('exception/page_not_found.html.twig', [
            'controller_name' => 'Page Not Found',
        ]);
    }
}
