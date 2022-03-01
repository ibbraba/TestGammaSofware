<?php


namespace App\Service;


use App\Entity\Group;

class EntityField
{
    /**
     *
     * @param  $array
     * @param bool $firstLine
     */
    public function createEntityField($array, $firstLine = false){

        $firstLine ? $start = 0 : $start = 1 ;

        $arrayLength = sizeof($array);;
        var_dump($arrayLength);


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
//           var_dump($group);
        }
    }



}