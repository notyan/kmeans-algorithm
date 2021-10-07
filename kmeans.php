<?php
namespace TugasSatu;
class KMeans{

    //==============================================================//
    //                          lOAD DATASET                        //
    //==============================================================//

    public function loadData($data){
        $dataset = [];
        if($file = fopen($data, 'r')){
            while(($line = fgetcsv($file)) !== FALSE){
                $dataset[] = $line;
            }
            fclose($file);
        }
        return($dataset);
    }
    
    //==============================================================//
    //                 GET RANDOM DATA FROM DATASET                 //
    //==============================================================//
    function randomGenerator($min, $max, $total){
        $num = range($min, $max);
        shuffle($num);
        return array_slice($num,0,$total);
    }
    function randomDataset($data){
        $index = $this->randomGenerator(0,19,4);
        $res = [];
        for( $i=0 ; $i < 4 ; $i++){
            $res[] = $data[$index[$i]];
        }
        return ($res);
    }

    //==============================================================//
    //                    FINDING EUCLID DISTANCE                   //
    //==============================================================//

    public function euclidFormula($centroid,$data){
        $output = sqrt( pow(($centroid[0]- $data[0]), 2) +
                        pow(($centroid[1]- $data[1]), 2) +
                        pow(($centroid[2]- $data[2]), 2)
                      );
        return ($output);
    }

    public function euclid($centroid, $dataset){
        $output = [];
        foreach($dataset as $i){
            $output[] = round($this->euclidFormula($centroid,$i), 3);
        }
        return($output);
    }    
    //==============================================================//
    //                          FIND CLUSTER                        //
    //==============================================================//

    public function clustering($eRes){
        $c1 = []; $c2 = []; $c3 = []; $c4 = [];
        for($i = 0; $i<20; $i++){
            $compare = array($eRes[0][$i],$eRes[1][$i],$eRes[2][$i],$eRes[3][$i]);
            $min = min($compare);
            $index = array_search($min, $compare);
            switch($index){
                case 0:     $c1[] = $i;     break;
                case 1:     $c2[] = $i;     break;
                case 2:     $c3[] = $i;     break;
                case 3:     $c4[] = $i;     break;
                default:                    break;
            }
        }
        return (array($c1, $c2, $c3, $c4));
    }

    //==============================================================//
    //                      FINDING NEW CENTROID                    //
    //==============================================================//

    public function centroidFormula($data){
        $sum = sizeof($data);
        $x = 0; $y = 0; $z = 0;
        foreach($data as $d){
            $x += $d[0]; $y += $d[1]; $z += $d[2];
        }
        return ( array( round($x/$sum, 3) , round($y/$sum, 3), round($z/$sum, 3), ) );
    }
    public function newCentroid($data, $clust){
        $sum = sizeof($clust);
        $temp = [];
        $centroid = [];
        for($i = 0 ; $i <4 ;$i++){
            $temp = [];
            foreach($clust[$i] as $c){
                $temp[] = $data[$c];
            }
            array_push( $centroid, $this->centroidFormula($temp) );
        }
        return($centroid);
    }

    //==============================================================//
    //                      KMEANS-ALGORITHM                        //
    //==============================================================//

    public function kMeans($data, $center){
        $euclidRes = [];
        for( $i=0 ; $i < 4 ; $i++){
            $euclidRes[] = $this->euclid($center[$i], $data);
        }
        $cluster = $this->clustering($euclidRes);
        return($cluster);
    }
}
