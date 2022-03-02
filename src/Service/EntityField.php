<?php


namespace App\Service;


use App\Entity\Group;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\Persistence\ManagerRegistry;

class EntityField
{

    protected $doctrine;
    protected $uniqueViolation;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->uniqueViolation = false;
    }


    /**
     *
     * @param  $array
     * @param bool $firstLine
     */
    public function createEntityField($array, $firstLine = false){

        $entityManger = $this->doctrine->getManager();

        /**
         * Decide if firstline should be counted as a row to flush in DB
         */
        $firstLine ? $start = 0 : $start = 1 ;

        $arrayLength = sizeof($array);;

        for ($i = $start; $i<$arrayLength; $i++) {
            $group = new Group();
            $group->setName($array[$i][0])
                ->setOrigin($array[$i][1])
                ->setCity($array[$i][2])
                ->setDebutYear($array[$i][3])
                ->setEndYear($array[$i][4])
                ->setFounder($array[$i][5])
                ->setMembers($array[$i][6])
                ->setCategory($array[$i][7])
                ->setPresentation($array[$i][8]);

            $entityManger->persist($group);
        }

        $entityManger->flush();
    }



}