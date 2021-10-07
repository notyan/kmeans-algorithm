<?php
require __DIR__ . '/kmeans.php';
use TugasSatu\KMeans;

$kmeans = new KMeans();
$data = $kmeans->loadData('dataset.csv');
$center = $kmeans->randomDataset($data);
//print_r ($center);
$oldCenter = $center; $newCenter = []; $cluster ; $newCluster;
$identical = false;
while(!$identical){
    $cluster = $kmeans->kMeans($data, $oldCenter);
    $newCenter = $kmeans->newCentroid($data, $cluster);
    if ($oldCenter == $newCenter){
        $identical = true;
        print_r($cluster);
    }
    else{
        $oldCenter = $newCenter;
        echo "1 \n";
    } 
}

// require __DIR__ . '/kmeans.php';
// use TugasSatu\KMeans;

// $kmeans = new KMeans();
// $data = $kmeans->loadData('dataset.csv');
// //$center = $kmeans->randomGenerator(0,19,4);
// $center = array(0,1,2,3);
// $euclidRes = [];
// for( $i=0 ; $i < 4 ; $i++){
//     $euclidRes[] = $kmeans->euclid($data[$center[$i]], $data);
// }
// $oldCluster = $kmeans->clustering($euclidRes);
// //$newCluster = $kmeans->newCentroid($data, $oldCluster);
// print_r ($kmeans->newCentroid($data, $oldCluster));

//print_r($center);

//print_r ($oldCluster);








