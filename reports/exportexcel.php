<?php
	ini_set('max_execution_time',60);
	$site_id = $_REQUEST['site_id'];
	$type = $_REQUEST['type'];
	$date1 = $_REQUEST['date1'];
	$date2 = $_REQUEST['date2'];
	$dtmm1=date('Y-m',strtotime($date1));
	$dtmm2=date('Y-m',strtotime($date2));
	$dtyy=date('Y',strtotime($date1));
	$sta = explode("-", $site_id);
	$ssite=$sta[0];	
	
	$server = "192.168.211.3"; //database location
	//$server = "110.164.126.120"; //database location
	$user = "sa"; //database username
	$pass = "ata+ee&c"; //database password
	$db_name = "DWR_SongKhla"; //database name

	$dsn = "Driver={SQL Server};Server=$server;Database=$db_name";
	//$connection = mssql_connect($server, $user, $pass);
	$connection = odbc_connect($dsn, $user, $pass);
	//$connection = odbc_connect("SONGKHAM","sa","ata+ee&c") or die("Error Connect to Database");

	function dmonth($ddlM)
	{
				if($ddlM=="01" or $ddlM=="1")	{	    $mm="มกราคม";}
				elseif($ddlM=="02" or $ddlM=="2")	{	$mm="กุมภาพันธ์ ";}
				elseif($ddlM=="03" or $ddlM=="3")	{	$mm="มีนาคม ";}
				elseif($ddlM=="04" or $ddlM=="4")	{	$mm="เมษายน ";}
				elseif($ddlM=="05" or $ddlM=="5")	{	$mm="พฤษภาคม ";}
				elseif($ddlM=="06" or $ddlM=="6")	{	$mm="มิถุนายน ";}
				elseif($ddlM=="07" or $ddlM=="7")	{	$mm="กรกฎาคม ";}
				elseif($ddlM=="08" or $ddlM=="8")	{	$mm="สิงหาคม ";}
				elseif($ddlM=="09" or $ddlM=="9")	{	$mm="กันยายน ";}
				elseif($ddlM=="10")	{	$mm="ตุลาคม ";}
				elseif($ddlM=="11")	{	$mm="พฤศจิกายน ";}
				else{	$mm=" ธันวาคม";}
		return $mm;
	}

	function dyear($ddly)
	{
				if($ddly=="2012"){$yy="2555";}
				elseif($ddly=="2013"){$yy="2556 ";}
				elseif($ddly=="2014"){$yy="2557 ";}
				elseif($ddly=="2015"){$yy="2558 ";}
				elseif($ddly=="2016"){$yy="2559 ";}
				elseif($ddly=="2017"){$yy="2560 ";}
				else{$ddly=" 2561";}		
				return $yy;
	}

	if($type=="DS")
	{
				$ddate="select top 1 datepart(DD,DB.dtm) dday,datepart(MM,DB.dtm) dmm,datepart(YY,DB.dtm) dyy ,convert(varchar(10),DB.dtm,120) dt ,
		datepart(DD,DB1.dtm) dday1,datepart(MM,DB1.dtm) dmm1,datepart(YY,DB1.dtm) dyy1 ,convert(varchar(10),DB1.dtm,120) dt1
		from [DWR_SongKhla].[dbo].[Daily] DB,[DWR_SongKhla].[dbo].[Daily] DB1 where DB.dtm='$date1' and DB1.dtm='$date2' and DB.stn='$ssite'";
	}
	else if($type=="MS")
	{
	$ddate="select top 1 datepart(DD,DB.dtm) dday,datepart(MM,DB.dtm) dmm,datepart(YY,DB.dtm) dyy ,convert(varchar(10),DB.dtm,120) dt ,
		datepart(DD,DB1.dtm) dday1,datepart(MM,DB1.dtm) dmm1,datepart(YY,DB1.dtm) dyy1 ,convert(varchar(10),DB1.dtm,120) dt1
		from [DWR_SongKhla].[dbo].[Daily] DB,[DWR_SongKhla].[dbo].[Daily] DB1 where CONVERT(varchar(7),DB.dtm,120)='$dtmm1' and CONVERT(varchar(7),DB1.dtm,120)='$dtmm2'
		 and DB.stn='$ssite' order by DB.dtm";
	}
	else
	{
		$ddate="select top 1 datepart(DD,dtm) dday,datepart(MM,dtm) dmm,datepart(YY,dtm) dyy ,convert(varchar(10),dtm,120) dt
		from [DWR_SongKhla].[dbo].[Daily] DB where CONVERT(varchar(4),DB.dtm,120)='$dtyy' and stn='$ssite' order by dtm";
	}

	$dda = odbc_exec($connection,$ddate);
    $ndd=odbc_fetch_array($dda);
	$sday=$ndd['dday'];
	$smm=$ndd['dmm'];
	$syy=$ndd['dyy'];
	$dt=$ndd['dt'];
	$sday1=$ndd['dday1'];
	$smm1=$ndd['dmm1'];
	$syy1=$ndd['dyy1'];
	$dt1=$ndd['dt1'];
	
	
	$compare_T=DateDiff($date1,$date2);
	
	$dta = (int)$sday."-".$smm."-".$syy;
	$dta1 = (int)$sday1."-".$smm1."-".$syy1;
	$ndtm = $smm."-".$syy;
	$ndtm1 = $smm1."-".$syy1;
	$ndty = $syy;
	$ndty1 = $syy1;

	if($compare_T < 1)
	{
		if($type=="DS")
		{
			$namedateshow="วันที่  $dta";
		}
		elseif($type=="MS")
		{
			$namedateshow="เดือน  $ndtm";
		}
		elseif($type=="YS")
		{
			$namedateshow="ปี  $ndty";
		}
		else{}

	}
	else
	{
		if($type=="DS")
		{
			$namedateshow="ระหว่างวันที่  $dta ถึง $dta1";
		}
		elseif($type=="MS")
		{
			$namedateshow="ระหว่างเดือน  $ndtm ถึง $ndtm1";
		}
		else{}
	}
	
	$ss="SELECT stn,st_name FROM [DWR_SongKhla].[dbo].[Stnname] where stn='$ssite'";
    $ress = odbc_exec($connection,$ss);
    $namesta=odbc_fetch_array($ress);
    $stationss=$namesta['stn'];
	$sname=$namesta['stn'];
	$namethai=$namesta['st_name'];
	$Dname=iconv('TIS-620', 'UTF-8', $namethai);

$aname="สถานี"."-".$ssite."-".$namedateshow;
$an=str_replace(" ","",$aname);
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$an.xls");#ชื่อไฟล์ 

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

	$minrf=array();
	$hourrf=array();
	$wl=array();
	$wle=array();
	$wlavg=array();
	$wlmin=array();
	$wlmax=array();
	$wleavg=array();
	$wlemin=array();
	$wlemax=array();
	$timerf=array();
	$timeavg=array();
	$timemin=array();
	$timemax=array();
	$timeavge=array();
	$timemine=array();
	$timemaxe=array();

	$flow=array();
	$flowavg=array();
	$flowmin=array();
	$flowmax=array();
	$timeavgflow=array();
	$timeminflow=array();
	$timemaxflow=array();

	$velocity=array();
	$velocityavg=array();
	$velocitymin=array();
	$velocitymax=array();
	$timeavgvelocity=array();
	$timeminvelocity=array();
	$timemaxvelocity=array();

	$area=array();
	$areaavg=array();
	$areamin=array();
	$areamax=array();
	$timeavgarea=array();
	$timeminarea=array();
	$timemaxarea=array();

	if($type =="DS" or $type =="DB")
	{
		
	
		
	
		?>
	
				<table CLASS="datatable" align="center" border="1">
				<tr class="tr_head">
					<td rowspan="2">รหัสสถานี </td>
					<td rowspan="2">ชื่อสถานี </td>
					<td rowspan="2" >วันที่ - เวลา</td>
					<td colspan="1" >ปริมาณน้ำฝน (มม.)</td>
					<td colspan="1">ระดับน้ำ (เมตร รทก.)</td>
					
				</tr>
				<tr class="tr_head">
				<td >15 นาที</td>
				<td >15 นาที</td>
				
				</tr>	
				<tbody>
			<?
				if($type =="DS")
				{
						$sss="select distinct CONVERT(varchar(20),dtm,120) AS adate,
						 rf ,
						wl
						FROM [DWR_SongKhla].[dbo].[Daily]  WHERE dtm BETWEEN '".$date1." 00:00' AND '".$date2." 23:50' and stn='".$ssite."' 
						order by CONVERT(varchar(20),dtm,120)";
				}
				else{}

				$rs_check =odbc_exec($connection,$sss);
				$checkrow=odbc_num_rows($rs_check);					
				if($checkrow=="0" )
				{
					echo "<p align=\"center\"><font color=\"red\">ไม่พบข้อมูล</font></p>";
				}
				else
				{	$STN_ID1 = 1;
					while($r_check=odbc_fetch_array($rs_check))
					{
						$sqltm="select * from [DWR_SongKhla].[dbo].[Stnname]  WHERE stn='".$ssite."' order by d_id";
						$result = odbc_exec($connection,$sqltm);
						$row = odbc_fetch_array($result);
						$STN_ID = $row["stn"];
						
						$STN_NAME_THAI = iconv('TIS-620', 'UTF-8', $row["st_name"]); 
						
						if ( $r_check['rf'] != "" )
						{
							array_push($minrf,$r_check['rf']);
						}
						if ( $r_check['wl'] != "" )
						{
							array_push($wl,$r_check['wl']);
						}
						
				?>
							<tr >
								<td><?=$STN_ID1?></td>
								<td><?=$STN_NAME_THAI?></td>
								<td><? echo ShortThaiDate($r_check['adate'],1,$STN_ID,"no")?></td>
								<td><?=checkrf($r_check['rf'],$STN_ID,1)?></td>
								<td><?=checkna($r_check['wl'],$STN_ID,1)?></td>
								
							</tr>
					<?
								$STN_ID1++;
					}	//end while	 

					if (!empty($minrf)) 
					{
						$min15=min($minrf);
						$max15=max($minrf);
						$avgrf= array_sum($minrf)/ count($minrf);
						$totalrf= array_sum($minrf);
					}
					if (!empty($wl)) 
					{
						$minwl=min($wl);
						$maxwl=max($wl);
						$totalwl= array_sum($wl);					
						$avgwl= array_sum($wl) / count($wl);
					}
					
				}
			?> 
		</tbody>
		<tfoot>
		<tr class="tr_list" bgcolor='#EEEED1'>
			<td colspan="3">MIN</td>
			<td><?=checkrf($min15,$STN_ID,1)?></td>
			<td><?=checkna($minwl,$STN_ID,1)?></td>
			
		</tr>
		<tr class="tr_list" bgcolor='#EEEED1'>
			<td colspan="3">MAX</td>
			<td><?=checkrf($max15,$STN_ID,1)?></td>
			<td><?=checkna($maxwl,$STN_ID,1)?></td>
			
		</tr>
		<tr class="tr_list" bgcolor='#EEEED1'>
			<td colspan="3">SUM</td>
			<td><?=checkrf($totalrf,$STN_ID,1)?></td>
			<td>n/a</td>
			
		</tr>
		<tr class="tr_list" bgcolor='#EEEED1'>
			<td colspan="3">Average</td>
			<td>n/a</td>
			<td><?=checkna($avgwl,$STN_ID,1)?></td>
			
		</tr>
		</tfoot>
		</table>
	<?
		
	}
	//////////////////////////////month/////////////////////////////////
	else if($type =="MS" or $type =="MB")
	{
		?>
		<div>
		<table align="center" border="1">
				<tr class="tr_head">
					<td rowspan="2">รหัสสถานี </td>
					<td rowspan="2">ชื่อสถานี </td>
					<td rowspan="2" >วันที่ - เวลา</td>
					<td colspan="1" >ปริมาณน้ำฝน (มม.)</td>
					<td colspan="3">ระดับน้ำ เมตร (รทก.)</td>
				</tr>
				<tr class="tr_head">
				<td >น้ำฝนสะสมรายวัน</td>
				<td >เฉลี่ยรายวัน</td>
				<td >ต่ำสุดรายวัน</td>
				<td >สูงสุดรายวัน</td>
				</tr>		
			<tbody>
			<?
			
				if($type =="MS")
				{
					$sss="select distinct CONVERT(varchar(10),dtm,120) AS adate,
					sum(rf) rf00 ,
					CONVERT(decimal(38,2),avg(wl)) wlavg,
					max(wl) wlmax,
					min(wl) wlmin
					FROM [DWR_SongKhla].[dbo].[Daily]  WHERE CONVERT(varchar(7),dtm,120) BETWEEN '".$dtmm1."' AND '".$dtmm2."' 
					and stn='".$ssite."' 	
					group BY CONVERT(varchar(10),dtm,120) 
					order by CONVERT(varchar(10),dtm,120)";
				}
				else
				{
				}
				
				$rs_check =odbc_exec($connection,$sss);
				$row = 1;
				$checkrow=odbc_num_rows($rs_check);
					
				if($checkrow=="0")
				{
					echo "<p align=\"center\"><font color=\"red\">ไม่พบข้อมูล</font></p>";
				}
				else
				{$STN_ID1 =1;
					while($r_check=odbc_fetch_array($rs_check))
					{
						$sqltm="select * from [DWR_SongKhla].[dbo].[Stnname]  WHERE stn='".$ssite."' order by d_id";
						$result = odbc_exec($connection,$sqltm);
						$row = odbc_fetch_array($result);
						$STN_ID = $row["stn"];
						
						$STN_NAME_THAI = iconv('TIS-620', 'UTF-8', $row["st_name"]);

						array_push($minrf,$r_check['rf00']);
						array_push($wlavg,$r_check['wlavg']);
						array_push($wlmin,$r_check['wlmin']);
						array_push($wlmax,$r_check['wlmax']);
					
						$timerf[$r_check['adate']]= $r_check['rf00'];
						$timeavg[$r_check['adate']] = $r_check['wlavg'];
						$timemin[$r_check['adate']] = $r_check['wlmin'];
						$timemax[$r_check['adate']] = $r_check['wlmax'];
	
						

				?>
						<tr class="tr_list">
							<td><?=$STN_ID1?></td>
							<td><?=$STN_NAME_THAI?></td>
							<td><? echo ShortThaiDate($r_check['adate'],2,$STN_ID,"no")?></td>
							<td><?=checkrf($r_check['rf00'],$STN_ID,0)?></td>
							<td><?=checkna($r_check['wlavg'],$STN_ID,1)?></td>
							<td><?=checkna($r_check['wlmin'],$STN_ID,1)?></td>
							<td><?=checkna($r_check['wlmax'],$STN_ID,1)?></td>
						</tr>
				<?
						$row++;
				$STN_ID1++;
						}	//end while	
						$dtminrf = array_search(min($timerf),$timerf);
						$dtmaxrf = array_search(max($timerf),$timerf);
						$dtmin_avg = array_search(min($timeavg),$timeavg);
						$dtmax_avg = array_search(max($timeavg),$timeavg);
						$dtmin_min = array_search(min($timemin),$timemin);
						$dtmax_min = array_search(max($timemin),$timemin);
						$dtmin_max = array_search(min($timemax),$timemax);
						$dtmax_max = array_search(max($timemax),$timemax);
						$min15=min($minrf);
						$max15=max($minrf);
						$wlavg_min=min($wlavg);
						$wlavg_max=max($wlavg);
						$wlmin_min=min($wlmin);
						$wlmin_max=max($wlmin);
						$wlmax_min=min($wlmax);
						$wlmax_max=max($wlmax);
						$totalrf= array_sum($minrf);
						$avg_wl= array_sum($wlavg)/ count($wlavg);
						$min_wl= array_sum($wlmin)/ count($wlmin);
						$max_wl= array_sum($wlmax) / count($wlmax);
					}
			?>
			</tbody>
			<tfoot>
			<tr class="tr_list" bgcolor='#EEEED1'>
				<td colspan="3">MIN</td>
				<td><?=checkrf($min15,$STN_ID,0)?></td>
				<td><?=checkna($wlavg_min,$STN_ID,1)?></td>
				<td><?=checkna($wlmin_min,$STN_ID,1)?></td>
				<td><?=checkna($wlmax_min,$STN_ID,1)?></td>
			</tr>
			<tr class="tr_list" bgcolor='#EEEED1'>
				<td colspan="3">TIME MIN</td>
				<td><? echo ShortThaiDate($dtminrf,2,$STN_ID,"rf")?></td>
				<td><? echo ShortThaiDate($dtmin_avg,2,$STN_ID,"wl")?></td>
				<td><? echo ShortThaiDate($dtmin_min,2,$STN_ID,"wl")?></td>
				<td><? echo ShortThaiDate($dtmin_max,2,$STN_ID,"wl")?></td>
			</tr>
			<tr class="tr_list" bgcolor='#EEEED1'>
				<td colspan="3">MAX</td>
				<td><?=checkrf($max15,$STN_ID,0)?></td>
				<td><?=checkna($wlavg_max,$STN_ID,1)?></td>
				<td><?=checkna($wlmin_max,$STN_ID,1)?></td>
				<td><?=checkna($wlmax_max,$STN_ID,1)?></td>
			</tr>
			<tr class="tr_list" bgcolor='#EEEED1'>
				<td colspan="3">TIME MAX</td>
				<td><? echo ShortThaiDate($dtmaxrf,2,$STN_ID,"rf")?></td>
				<td><? echo ShortThaiDate($dtmax_avg,2,$STN_ID,"wl")?></td>
				<td><? echo ShortThaiDate($dtmax_min,2,$STN_ID,"wl")?></td>
				<td><? echo ShortThaiDate($dtmax_max,2,$STN_ID,"wl")?></td>
			</tr>
			<tr class="tr_list" bgcolor='#EEEED1'>
				<td colspan="3">SUM</td>
				<td><?=checkrf($totalrf,$STN_ID,0)?></td>
				<td>n/a</td>
				<td>n/a</td>
				<td>n/a</td>
			</tr>
			<tr class="tr_list" bgcolor='#EEEED1'>
				<td colspan="3">Average</td>
				<td>n/a</td>
				<td><?=checkna($avg_wl,$STN_ID,1)?></td>
				<td><?=checkna($min_wl,$STN_ID,1)?></td>
				<td><?=checkna($max_wl,$STN_ID,1)?></td>
			</tr>
		</tfoot>
		</table>
		</div>
		<?
	}
	///////////////////////////////year/////////////////////////////////
	else if($type =="YS" )
	{

		?>
		<div>
		<table align="center" border="1">
				<tr class="tr_head">
					<td rowspan="2">รหัสสถานี </td>
					<td rowspan="2">ชื่อสถานี </td>
					<td rowspan="2" >วันที่ - เวลา</td>
					<td colspan="1" >ปริมาณน้ำฝน (มม.)</td>
					<td colspan="3">ระดับน้ำ เมตร (รทก.)</td>
				</tr>
				<tr class="tr_head">
				<td >น้ำฝนสะสมรายเดือน</td>
				<td >เฉลี่ยรายเดือน</td>
				<td >ต่ำสุดรายเดือน</td>
				<td >สูงสุดรายเดือน</td>
				</tr>		
			<tbody>
			<?
		
				if($type =="YS")
				{
					$sss="select distinct CONVERT(varchar(7),dtm,120) AS adate,
					sum(rf) rf00 ,
					CONVERT(decimal(38,2),avg(wl)) wlavg,
					max(wl) wlmax,
					min(wl) wlmin
					FROM [DWR_SongKhla].[dbo].[Daily]  WHERE CONVERT(varchar(4),dtm,120) BETWEEN '".$dtyy."' AND '".$dtyy."' 
					and stn='".$ssite."' 
					group BY CONVERT(varchar(7),dtm,120) 
					order by CONVERT(varchar(7),dtm,120)  ";
				}
				
				else
				{
				}
				
				$rs_check =odbc_exec($connection,$sss);
				$row = 1;
				$checkrow=odbc_num_rows($rs_check);
					
				if($checkrow=="0")
				{
					echo "<p align=\"center\"><font color=\"red\">ไม่พบข้อมูล</font></p>";
				}
				else
				{$STN_ID1 = 1;
					while($r_check=odbc_fetch_array($rs_check))
					{
						$sqltm="select * from [DWR_SongKhla].[dbo].[Stnname]  WHERE stn='".$ssite."' order by d_id";
						$result = odbc_exec($connection,$sqltm);
						$row = odbc_fetch_array($result);
						$STN_ID = $row["stn"];
						
						$STN_NAME_THAI = iconv('TIS-620', 'UTF-8', $row["st_name"]);
						array_push($minrf,$r_check['rf00']);
						array_push($wlavg,$r_check['wlavg']);
						array_push($wlmin,$r_check['wlmin']);
						array_push($wlmax,$r_check['wlmax']);

						$timerf[$r_check['adate']] = $r_check['rf00'];
						$timeavg[$r_check['adate']] = $r_check['wlavg'];
						$timemin[$r_check['adate']] = $r_check['wlmin'];
						$timemax[$r_check['adate']] = $r_check['wlmax'];
				?>
						<tr class="tr_list">
							<td><?=$STN_ID1?></td>
							<td><?=$STN_NAME_THAI?></td>
							<td><? echo ShortThaiDate($r_check['adate'],3,$STN_ID,"no")?></td>
							<td><?=checkrf($r_check['rf00'],$STN_ID,0)?></td>
							<td><?=checkna($r_check['wlavg'],$STN_ID,1)?></td>
							<td><?=checkna($r_check['wlmin'],$STN_ID,1)?></td>
							<td><?=checkna($r_check['wlmax'],$STN_ID,1)?></td>
						</tr>
				<?
						$row++;
				$STN_ID1++;
						}	//end while	
						
						$dtminrf = array_search(min($timerf),$timerf);
						$dtmaxrf = array_search(max($timerf),$timerf);
						$dtmin_avg = array_search(min($timeavg),$timeavg);
						$dtmax_avg = array_search(max($timeavg),$timeavg);
						$dtmin_min = array_search(min($timemin),$timemin);
						$dtmax_min = array_search(max($timemin),$timemin);
						$dtmin_max = array_search(min($timemax),$timemax);
						$dtmax_max = array_search(max($timemax),$timemax);
						$min15=min($minrf);
						$max15=max($minrf);
						$wlavg_min=min($wlavg);
						$wlavg_max=max($wlavg);
						$wlmin_min=min($wlmin);
						$wlmin_max=max($wlmin);
						$wlmax_min=min($wlmax);
						$wlmax_max=max($wlmax);
						$totalrf= array_sum($minrf);
						$avg_wl= array_sum($wlavg)/ count($wlavg);
						$min_wl= array_sum($wlmin)/ count($wlmin);
						$max_wl= array_sum($wlmax) / count($wlmax);
					}
			?>
			</tbody>
			<tfoot>
			<tr class="tr_list" bgcolor='#EEEED1'>
				<td colspan="3">MIN</td>
				<td><?=checkrf($min15,$STN_ID,0)?></td>
				<td><?=checkna($wlavg_min,$STN_ID,1)?></td>
				<td><?=checkna($wlmin_min,$STN_ID,1)?></td>
				<td><?=checkna($wlmax_min,$STN_ID,1)?></td>
			</tr>
			<tr class="tr_list" bgcolor='#EEEED1'>
				<td colspan="3">TIME MIN</td>
				<td><? echo ShortThaiDate($dtminrf,3,$STN_ID,"rf")?></td>
				<td><? echo ShortThaiDate($dtmin_avg,3,$STN_ID,"wl")?></td>
				<td><? echo ShortThaiDate($dtmin_min,3,$STN_ID,"wl")?></td>
				<td><? echo ShortThaiDate($dtmin_max,3,$STN_ID,"wl")?></td>
			</tr>
			<tr class="tr_list" bgcolor='#EEEED1'>
				<td colspan="3">MAX</td>
				<td><?=checkrf($max15,$STN_ID,0)?></td>
				<td><?=checkna($wlavg_max,$STN_ID,1)?></td>
				<td><?=checkna($wlmin_max,$STN_ID,1)?></td>
				<td><?=checkna($wlmax_max,$STN_ID,1)?></td>
			</tr>
			<tr class="tr_list" bgcolor='#EEEED1'>
				<td colspan="3">TIME MAX</td>
				<td><? echo ShortThaiDate($dtmaxrf,3,$STN_ID,"rf")?></td>
				<td><? echo ShortThaiDate($dtmax_avg,3,$STN_ID,"wl")?></td>
				<td><? echo ShortThaiDate($dtmax_min,3,$STN_ID,"wl")?></td>
				<td><? echo ShortThaiDate($dtmax_max,3,$STN_ID,"wl")?></td>
			</tr>
			<tr class="tr_list" bgcolor='#EEEED1'>
				<td colspan="3">SUM</td>
				<td><?=checkrf($totalrf,$STN_ID,0)?></td>
				<td>n/a</td>
				<td>n/a</td>
				<td>n/a</td>
			</tr>
			<tr class="tr_list" bgcolor='#EEEED1'>
				<td colspan="3">Average</td>
				<td>n/a</td>
				<td><?=checkna($avg_wl,$STN_ID,1)?></td>
				<td><?=checkna($min_wl,$STN_ID,1)?></td>
				<td><?=checkna($max_wl,$STN_ID,1)?></td>
			</tr>
		</tfoot>
		</table>
		</div>
	<?
	}
	else{}

function checkrf($n,$ssite,$mm)
{
	if($ssite=="Tpat.1" || $ssite=="Tpat.2" || $ssite=="Tpat.6" || $ssite=="Tpat.7" || $ssite=="Tpat.12")
	{
		$s="n/a";
	}
	else
	{
		$s=number_format($n,2);
	}
	return $s;
}

function checkna($n,$ssite,$mm)
{
	if($ssite=="Tpat.16" || $ssite=="Tpat.18" || $ssite=="Tpat.19" || $ssite=="20" || $ssite=="Tpat.22" || $ssite=="Tpat.23" || $ssite=="Tpat.24")
	{
			if($mm=="0")
			{
				$s=number_format($n,2);
			}
			else
			{
				$s="n/a";
			}
	}
	elseif($n=="")
	{
		$s="-";
	}
	else
	{
		$s=number_format($n,2);
	}
	return $s;
}
function checkflow($n,$ssite,$mm)
{
	if($ssite=="Tpat.5" || $ssite=="Tpat.7")
	{
		if($n=="" && $n!="0")
		{
			$s="-";
		}
		else
		{
			if($mm=="1")
			{
				$s=number_format($n,2);
			}
			else
			{
				$s="n/a";
			}
		}
	}
	else
	{
		$s="n/a";
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
function DateDiff($strDate1,$strDate2)
{
	return (strtotime($strDate2) - strtotime($strDate1))/  ( 60 * 60 * 24 );  // 1 day = 60*60*24
}

function ShortThaiDate($txt,$ss,$ssite,$ty)
{
	global $ThaiSubMonth;
	$Year = substr(substr($txt, 0, 4), -4);
	$Month = substr($txt, 5, 2);
	$DayNo = substr($txt, 8, 2);
	$T = substr($txt, 11, 5);
	
	if($ty=="rf")
	{
		if($ssite=="Tpat.1" || $ssite=="Tpat.2" || $ssite=="Tpat.6" || $ssite=="Tpat.7" || $ssite=="Tpat.12")
		{
			$x="n/a";
		}
		else
		{
			if($ss==1)
			{
				$x = $Year."-".$Month."-".$DayNo." ".$T;
			}
			else if($ss==2)
			{
				$x = $Year."-".$Month."-".$DayNo;
			}
			else 
			{
				$x = $Year."-".$Month;
			}
		}
	}
	elseif($ty=="wl")
	{
		if($ssite=="Tpat.16" || $ssite=="Tpat.18" || $ssite=="Tpat.19" || $ssite=="20" || $ssite=="Tpat.22" || $ssite=="Tpat.23" || $ssite=="Tpat.24")
		{
			$x="n/a";
		}
		else
		{
			if($ss==1)
			{
				$x = $Year."-".$Month."-".$DayNo." ".$T;
			}
			else if($ss==2)
			{
				$x = $Year."-".$Month."-".$DayNo;
			}
			else 
			{
				$x = $Year."-".$Month;
			}
		}
	}
	else
	{
			if($ss==1)
			{
				$x = $Year."-".$Month."-".$DayNo." ".$T;
			}
			else if($ss==2)
			{
				$x = $Year."-".$Month."-".$DayNo;
			}
			else 
			{
				$x = $Year."-".$Month;
			}
	}
	return $x;
}
?>
</BODY>
</HTML>