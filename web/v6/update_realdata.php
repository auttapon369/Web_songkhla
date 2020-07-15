<?php

@include('data/config.php');
$conn = connDB("odbc");

echo$sql="UPDATE dbo.DATA_DAILY_RF_WL SET DT =CONVERT(DATETIME,'2017-09-08 11:15',120),TM = CONVERT(DATETIME,'11:15',108) WHERE STN_ID='STN04' AND DT=CONVERT(datetime,'2020-09-30 10:45',120) ";
//$sql="select * from dbo.DATA_DAILY_RF_WL where stn_id='STN04'";
$r=odbc_exec($conn,$sql);
//$w=odbc_fetch_array($r);
//echo $w['DT'];

?>