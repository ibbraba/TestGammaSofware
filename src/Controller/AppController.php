<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AppController extends AbstractController
{
    /**
     * @Route("/app", name="app_app")
     */
    public function index(): Response
    {
        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController',
        ]);
    }


    /**
     * @Route("/upload-excel", name="xlsx")
     */
    public function upload(): Response
    {


        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController',
        ]);

    }
}
