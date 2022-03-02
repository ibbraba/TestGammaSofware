<?php

namespace App\Controller;

use App\Form\UploadFileType;
use App\Service\EntityField;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Service\FileReaderService;
use ZipStream\Exception;


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
     * @Route("/app", name="app")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {

        /** STEP 1: Generate a form to upload a file   */
        $form = $this->createForm(UploadFileType::class);
        $form->handleRequest($request);

        if ( $form->isSubmitted() && $form->isValid() ){

        /** STEP 2: GET file from form and convert sheet data to PHP Array  */
            $file = $form['file']->getData();


            /**
             * Read file with PHPSpreadSheet bundle
             * Catching error if file is incorrect
             */
            try {
                $array = $this->fileReader->read($file);
            }catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $exception) {
                $this->addFlash("danger", "Le fichier n'a pu être lu (essayez un fichier au format .xlsx)");
                return $this->redirectToRoute("app", [], Response::HTTP_SEE_OTHER);
            }


            /**
             * STEP 3-4: Create a new instance of Group entity for each row and persist in Database
             * Catching error if data is already flush in Database
             * Redirect to App Page with Flash message to USER
             */
            try
            {   $this->entityField->createEntityField($array);
                $this->addFlash("success", "Vos données ont bien été enregistées !");
            }
            catch ( UniqueConstraintViolationException $exception){
                $this->addFlash("warning", "Vos données sont déja enreistrées !");
            } finally {
                $this->redirectToRoute("app", [], Response::HTTP_SEE_OTHER);
            }

        }


        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController',
            'form' => $form->createView()
        ]);
    }

}
