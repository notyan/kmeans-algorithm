<?php
namespace TugasSatu;
class KMeans{
    private $dataKe = [];
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
        //$index = $this->randomGenerator(0,19,4);
        $index = array(0,1,2,3);
        $this->dataKe = $index;
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
                case 0:     $c1[] = $i+1;     break;
                case 1:     $c2[] = $i+1;     break;
                case 2:     $c3[] = $i+1;     break;
                case 3:     $c4[] = $i+1;     break;
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
                $temp[] = $data[$c-1];
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

    //==============================================================//
    //                   GET AND PRINT CLUSTER                      //
    //==============================================================//

    public function printer($data, $cluster, $center, $centerInit){
        $clusterData = array([],[],[],[]);
        $clusterIndex = [];
        $centroid = [];
        $init = [];
        for($i=0; $i <4 ; $i++){
            foreach($cluster[$i] as $c){
                array_push($clusterData[$i] , sprintf( "(%s)", implode(", ",$data[$c-1])) ); 
            }
            $init[] =  sprintf( "(%s)", implode(", ",$centerInit[$i]) ); 
            $centroid[] =  sprintf( "(%s)", implode(", ",$center[$i]) ); 
            $clusterIndex[] = implode(", " ,$cluster[$i]);
        }
        foreach($clusterData as $key=>$cd){
            echo ("\e[94m" . "Cluster Ke: \t" . ($key+1) . "\n" );
            echo ("\e[37m" . "Pusat Awal: \t" . $init[$key] ." | Data Ke-" . ($this->dataKe[$key]+1) . "\n" );
            echo ("\e[37m" . "Pusat Akhir: \t" . $centroid[$key] . "\n" );
            echo ("\e[92m" . "Data Ke: \t" .  $clusterIndex[$key] . "\n" );
            echo ("\e[32m" . "Dataset: \t" . implode("; ", $cd) . "\n");
            echo ("\n");
        }
    }
}
