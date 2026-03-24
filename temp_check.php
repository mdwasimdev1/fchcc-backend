<?php
$f = file_get_contents('database/seeders/HomeBannerSeeder.php');
$first = substr($f, 0, 10);
$ords = array_map('ord', str_split($first));
echo implode(',', $ords) . "\n";

