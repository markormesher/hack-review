<?php
require_once '../resources/_master-list.php';
$locaion = Events::getById(1);

$map =str_replace(" ","+", $locaion['address']. ",". $locaion[postcode].",". $locaion[country]);

echo '<iframe
  width="600"
  height="450"
  frameborder="0" style="border:0"
  src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDVcWjAzc8aXs_gKWgmqn0duBFAcrFzyqs
    &q='.$map.'">
</iframe>'
?>