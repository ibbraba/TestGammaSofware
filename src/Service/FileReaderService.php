<?php


namespace App\Service;

use PhpOffice\PhpSpreadsheet\IOFactory;

class FileReaderService
    {

    /**
     * @param $file
     * @return array
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * Read the file and convert sheets row in Array
     */
        public function read ($file){
            $inputFileName = $file;


            /**  Identify the type of $inputFileName  **/
            $inputFileType = IOFactory::identify($inputFileName);

            /**  Create a new Reader of the type that has been identified  **/
            $reader = IOFactory::createReader($inputFileType);

            /**  Load $inputFileName to a Spreadsheet Object  **/
            $spreadsheet = $reader->load($inputFileName);

            /**  Convert Spreadsheet Object to an Array for ease of use  **/
            $schdeules = $spreadsheet->getActiveSheet()->toArray();


            return $schdeules;


        }
    }