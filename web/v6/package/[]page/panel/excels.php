<?
//include("config.php");
$date = $_GET['date'];

//$sta = explode("-", $station);
//$ssite=$sta[0];

include('../../../data/config.php');

$conn = connDB("odbc");

/*$host = "192.168.102.12";
$username = "sa";
$password = "ata+ee&c";
$dbname = "KOLOK";
$hosting = "Driver={SQL Server}; Server=$host; Database=$dbname";

$conn = mssql_connect($host, $username, $password);
$conodbc = odbc_connect($hosting, $username, $password);*/


//////////////////////////////////main//////////////////////////////////
	
	$dateshow=date('Y_m_d H:i', strtotime($date));
	$aname="water_door"."_".$date;
	$an=str_replace("","",$aname); 
	header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$an.xls");

?>

<html xmlns:o="urn:schemas-microsoft-com:office:office"

xmlns:x="urn:schemas-microsoft-com:office:excel"

xmlns="http://www.w3.org/TR/REC-html40">
<HEAD>
<meta http-equiv="Content-type" content="text/html;charset=utf-8" />
	<TITLE>แสดงผลข้อมูล</TITLE>
	<style>
	.xl29
	{mso-style-parent:style0;
	font-family:Tahoma, sans-serif;
	mso-font-charset:0;
	mso-number-format:Fixed;
	text-align:center;
	border:.5pt solid black;
	background:white;
	mso-pattern:auto none;
	white-space:normal;}
	</style>
</HEAD>
<BODY>
<?

	$sql_stn = "SELECT * FROM [dbo].control ORDER BY c_id";
	$res_stn = odbc_exec($conn,$sql_stn);

	$sql_log = "SELECT cl_date FROM [dbo].control_log where cl_date ='".$date."' ORDER BY cl_date DESC";
	$res_log = odbc_exec($conn,$sql_log);
	$arr_log = odbc_fetch_array($res_log);

///////////////////////////show data ////////////////////////////////////////
?>
		<TABLE CLASS="control" border="1">
		<TR CLASS="bc_fade">
			<TH ROWSPAN="2">ปตร. / ทรบ.</TH>
			<TH COLSPAN="7">ระยะยกบาน <SPAN CLASS="fs_small">(หน่วย : เมตร)</SPAN></TH>
		</TR>
		<TR CLASS="bc_fade">
			<TH>บานที่ 1</TH>
			<TH>บานที่ 2</TH>
			<TH>บานที่ 3</TH>
			<TH>บานที่ 4</TH>
			<TH>บานที่ 5</TH>
			<TH>บานที่ 6</TH>
			<TH>บานที่ 7</TH>
		</TR>
		<?php
		while ( $arr_stn = odbc_fetch_array($res_stn) )
		{
			$sql_no = "SELECT TOP ".$arr_stn['c_door_water']." * FROM [dbo].control_log WHERE cl_date ='".$arr_log['cl_date']."' and c_id = '".$arr_stn['c_id']."' AND cl_type = 'W' ORDER BY cl_update DESC, cl_no";
			$res_no = odbc_exec($conn,$sql_no);

			echo "<TR>\n";
			echo "<TD CLASS=\"left\">".iconv('TIS-620', 'UTF-8', $arr_stn['c_name'])."</TD>\n";

			$n = 0;
			while ( $arr_no = odbc_fetch_array($res_no) )
			{
				$n++;

				//echo "<TD><INPUT TYPE=\"text\" NAME=\"d_".$arr_stn['c_id']."_".$arr_no['cl_no']."\" VALUE=\"".$arr_no['cl_value']."\" /></TD>\n";
				echo "<TD>".$arr_no['cl_value']."</TD>\n";
						
				//$datetime = date('Y-m-d H:i:s', strtotime($arr_no['cl_date']));
			}

			if ( $n < 7 )
			{
				for ( $i = 0; $i < ( 7 - $n ); $i++ )
				{
					echo "<TD CLASS=\"bc_gray\">&nbsp;</TD>\n";
				}
			}

			echo "</TR>\n";
		}
		?>
	</TABLE>
</BODY>
</HTML>