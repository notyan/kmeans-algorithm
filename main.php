<?php
require __DIR__ . '/kmeans.php';
use TugasSatu\KMeans;

$kmeans = new KMeans();
$data = $kmeans->loadData('dataset.csv');
$center = $kmeans->randomDataset($data);
$oldCenter = $center; $newCenter = []; $cluster ; $newCluster;
$identical = false;
while(!$identical){
    $cluster = $kmeans->kMeans($data, $oldCenter);
    $newCenter = $kmeans->newCentroid($data, $cluster);
    if ($oldCenter == $newCenter){
        $identical = true;
        $kmeans->printer($data, $cluster, $newCenter, $center);
    }
    else{
        $oldCenter = $newCenter;
    } 
}







