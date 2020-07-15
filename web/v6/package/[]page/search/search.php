<?php
ob_start();
session_start();

if ( empty($_POST['stn']) )
{ 
	header('location:../../../?page=search');
}

include('../../../data/config.php');
include('../../class/index.php');

//$conn = connDB("odbc");

$_call = new Tele($_cfg_tb,$_cfg_conn);

$p_stn = $_POST['stn'];
$p_rain = $_POST['s_rain'];	
$p_water = $_POST['s_water'];
$p_flow = $_POST['s_flow'];
$p_day1 = $_POST['date1'];
$p_day2 = $_POST['date2'];
$p_format = $_POST['format'];
$name_report = "<H3>".$_cfg_report_h_1."</H3>".$_call->dateReport($p_day1, $p_day2);

$num = count($p_stn);
/*echo "<pre>";
var_dump($p_stn);
echo "</pre>";
echo $p_rain."<BR>".$p_water."<BR>".$p_flow."<BR>".$p_day1."<BR>".$p_day2."<BR>".$p_format;

*/
//exit();

//$sta = explode("-", $p_stn);
//$ssite=$sta[0];

//$mi="-1"; // ����� 00
$mi="-421"; // ����� 07

function numm($n)
{
	if($n=="")
	{
		$s="-";
	}
	else
	{
		$s=number_format($n,2);
	}
	return $s;
}
function addValue($value,$cp)
{
	if($cp=="0")
	{
		$x = numm($value);
	}
	else
	{
		$x = "";
	}
	return $x;
}

function C_rf($check,$p_rain)
{
	if($check=="0")
	{
		$x = "no";
	}
	else
	{
		if($p_rain=="Y")
		{
			$x = "show";
		}
		else
		{ $x = "no"; }
	}
	return $x;
}
function C_wl($check,$p_water)
{
	if($check=="0")
	{
		$x = "no";
	}
	else
	{
		if($p_water=="Y")
		{
			$x = "show";
		}
		else
		{ $x = "no"; }
	}
	return $x;
}
function C_wle($check,$p_water,$wl_e)
{
	if($wl_e=="Y")
	{
		if($p_water=="Y")
		{
			$x = "show";
		}
		else
		{ $x = "no"; }
	}
	else
	{
		$x = "no";
	}
	return $x;
}
function C_fl($check,$p_flow)
{
	if($check=="0")
	{
		$x = "no";
	}
	else
	{
		if($p_flow=="Y")
		{
			$x = "show";
		}
		else
		{ $x = "no"; }
	}
	return $x;
}

function C_fle($check,$p_flow,$wl_e)
{
	if($wl_e=="Y")
	{
		if($p_flow=="Y")
		{
			$x = "show";
		}
		else
		{ $x = "no"; }
	}
	else
	{
		$x = "no";
	}
	return $x;
}

/*$rf=C_rf($ssite,$p_rain);
$wl=C_wl($ssite,$p_water);
$wle=C_wle($ssite,$p_water);
$fl=C_fl($ssite,$p_flow);
$fle=C_fle($ssite,$p_flow);*/


function cut($id)
{
	$sta = explode("-", $id);
	$ss[0]=$sta[0];

	//rf
	$ss[1]=$sta[1];

	//wl
	$ss[2]=$sta[2];

	//fl
	$ss[3]=$sta[3];

	$ns = explode(".", $ss[0]);
	$ss[4]=$ns[0].$ns[1];

	//wl_end
	$ss[5]=$sta[4];

	return $ss;
}

if($p_stn=="")
{
	echo "��س����͡ʶҹ�";
}
else
{

	foreach($p_stn as $id)
	{
		$_value = cut($id);
		$ssite = $_value[0];
		$rf=$_value[1];
		$wl=$_value[2];
		$fl=$_value[3];
		$wl_end=$_value[5];

		if($rf == "1") 
		{  
			$nrf += 1;  
		} 
		if($wl == "1") 
		{  
			$nwl += 1;  
		} 
		if($wl == "1") 
		{  
			$nfl += 1;  
		} 	
		
		if($wl_end=="Y")
		{
			$nwle+= 1; 
			$cwle="Y";
		}
	}
}
?>
<!DOCTYPE HTML>
<HTML LANG="th-TH">
<HEAD>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8" />
<LINK HREF="../../../<?php echo $_cfg_path['img'] ?>favicon.ico" REL="shortcut icon" />
<LINK HREF="../../../<?php echo $_cfg_path['img'] ?>apple-touch-icon.png" REL="apple-touch-icon" />
<LINK HREF="../../../<?php echo $_cfg_path['css'] ?>reset.css" REL="stylesheet" TYPE="text/css" />
<LINK HREF="../../../<?php echo $_cfg_path['css'] ?>style.css" REL="stylesheet" TYPE="text/css" />
<LINK HREF="../../../data/color.css" REL="stylesheet" TYPE="text/css" />
<SCRIPT TYPE="text/javascript" SRC="../../../<?php echo $_cfg_path['js'] ?>jquery-1.10.2.min.js"></SCRIPT>
<SCRIPT TYPE="text/javascript" SRC="../../../<?php echo $_cfg_path['js'] ?>chart/highstock.js"></SCRIPT>
<SCRIPT TYPE="text/javascript" SRC="../../../<?php echo $_cfg_path['js'] ?>chart/exporting.js"></SCRIPT>
<TITLE><?php echo $_cfg_title ?></TITLE>
</HEAD>

<BODY CLASS="body-report">
	<H3><?php echo $_cfg_report_h_1 ?></H3>
	<Q><?php echo $_call->dateReport($p_day1, $p_day2) ?></Q>
	<BR><BR>
	<?php
	if ( !empty($_GET['view']) )
	{
		$view = $_GET['view'].".php";
			
		if ( file_exists($view) )
		{
			include($view);
		}
		else
		{
			echo $_cfg_error_page;
		}
	}
	?>
</BODY>
</HTML>