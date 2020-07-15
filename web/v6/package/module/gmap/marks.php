<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("content-type:text/xml");

$user = 'sa';
$password = 'ata+ee&c';

$connection = odbc_connect("Driver={SQL Server};Server=192.168.191.232;Database=DWR_Songkhla;", $user, $password);
$name =$_GET['name'];


echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
echo "<markers>";



$query="SELECT stn,Check_rf,Check_wl,UTM_N,UTM_E FROM [DWR_SongKhla].[dbo].[Stnname] where stn='".$name."'";
$results = odbc_exec($connection,$query);
	while ($row=odbc_fetch_array($results))
	{
	$point = UTMtoLL($row['UTM_N'], $row['UTM_E'], 47);
    $lat=$point[1];
	$lng=$point[0];
	echo '<marker lat="'.$lat.'" lng="'.$lng.'" stn="'.$row['stn'].'" c_rf="'.$row['Check_rf'].'" c_wl="'.$row['Check_wl'].'" />'; 
	}

echo "</markers>";


     
function UTMtoLL($f, $f1, $j)
	{
		 $d = 0.99960000000000004;
		 $d1 = 6378137;
		 $d2 = 0.0066943799999999998;
	   
		 $d4 = (1 - sqrt(1-$d2))/(1 + sqrt(1 - $d2));
		 $d15 = $f1 - 500000;
		 $d16 = $f;
		 $d11 = (($j - 1) * 6 - 180) + 3;
	   
		 $d3 = $d2/(1 - $d2);
		 $d10 = $d16 / $d;
		 $d12 = $d10 / ($d1 * (1 - $d2/4 - (3 * $d2 *$d2)/64 - (5 * pow($d2,3))/256));
		 $d14 = $d12 + ((3*$d4)/2 - (27*pow($d4,3))/32) * sin(2*$d12) + ((21*$d4*$d4)/16 - (55 * pow($d4,4))/32) * sin(4*$d12) + ((151 * pow($d4,3))/96) * sin(6*$d12);
		 $d13 = $d14 * 180 / M_PI;
		 $d5 = $d1 / sqrt(1 - $d2 * sin($d14) * sin($d14));
		 $d6 = tan($d14)*tan($d14);
		 $d7 = $d3 * cos($d14) * cos($d14);
		 $d8 = ($d1 * (1 - $d2))/pow(1-$d2*sin($d14)*sin($d14),1.5);
	   
		 $d9 = $d15/($d5 * $d);
		 $d17 = $d14 - (($d5 * tan($d14))/$d8)*((($d9*$d9)/2-(((5 + 3*$d6 + 10*$d7) - 4*$d7*$d7-9*$d3)*pow($d9,4))/24) + (((61 +90*$d6 + 298*$d7 + 45*$d6*$d6) - 252*$d3 -3 * $d7 *$d7) * pow($d9,6))/720); 
		 $d17 = $d17 * 180 / M_PI;
		 $d18 = (($d9 - ((1 + 2 * $d6 + $d7) * pow($d9,3))/6) + (((((5 - 2 * $d7) + 28*$d6) - 3 * $d7 * $d7) + 8 * $d3 + 24 * $d6 * $d6) * pow($d9,5))/120)/cos($d14);
		 $d18 = $d11 + $d18 * 180 / M_PI;
		 $arr = array ( $d18,$d17);
	   
		 return $arr;
	}
?>
