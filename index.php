<?php
require_once 'rajaOngkir1.php';

$init = new RajaOngkir('2ed7475e86beecc9cd2e68cc9f2ec480', true);
//echo $init->getCost(2, 1, 1000,'jne');
//$init = new RajaOngkir('yourApiKey', true);
echo $init->getProvince();

?>