<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ExceptionController extends Controller
{
    /**
     * @Route("/exception", name="exception")
     */
    public function showException()
    {


        return $this->render('exception/page_not_found.html.twig', [
            'controller_name' => 'Page Not Found',
        ]);
    }
}
