<?php

namespace App\Controller;

use App\Form\UploadFileType;
use App\Service\EntityField;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Service\FileReaderService;


class AppController extends AbstractController
{

    protected $fileReader;
    protected $entityField;

    public function __construct( FileReaderService  $fileReaderService, EntityField $entityField)
    {
        $this->fileReader = $fileReaderService;
        $this->entityField = $entityField;
    }


    /**
     * @Route("/app", name="app_app")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        /*$data = $this->fileReader->read();
        dd($data);*/
        $ok = 'ok';


        $form = $this->createForm(UploadFileType::class, [ 'action' => $this->generateUrl('upload'),
            'method' => 'GET',]);
        $form->handleRequest($request);
        if ( $form->isSubmitted() && $form->isValid() ){
              $file = $form['file']->getData();

               $array = $this->fileReader->read($file);

                $groups = $this->entityField->createEntityField($array);

        }


        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController',
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/upload", name="upload")
     */
    public function upload(Request $request): Response
    {

        $file = $request->getContent();
        dd($file);


/*        $file = $request->getFiles(); // get the file from the sent request
        $file[1]->getClientOriginalName();


        $fileFolder = __DIR__ . '/../../public/uploads/';  //choose the folder in which the uploaded file will be stored
        $filePathName = md5(uniqid()) . $file->getClientOriginalName();
        // apply md5 function to generate an unique identifier for the file and concat it with the file extension
        try {
            $file->move($fileFolder, $filePathName);
        } catch (FileException $e) {
            dd($e);
        }*/


        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController',
        ]);

    }
}
