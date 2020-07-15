<?php
$original_mem = ini_get('memory_limit');
 
// then set it to the value you think you need (experiment)
ini_set('memory_limit','640M');
 
ini_set('max_execution_time', 300);
// Include the main TCPDF library (search for installation path).
require_once('tcpdf/tcpdf.php');
include("tcpdf/class/class_curl.php");


if($p_format=="f_15")
{		
	$name="DATA_15_MIN";
}
else if($p_format=="f_hr")
{
	$name="DATA_HOUR";
}
else if($p_format=="f_mean")
{
	$name="DATA_Daily_AVG";
}
else if($p_format=="f_min")
{
	$name="DATA_Daily_MIN";
}
else
{
	$name="DATA_Daily_MAX";
}

$aname=$name;
$an=str_replace(" ","",$aname);

// การตั้งค่าข้อความ ที่เกี่ยวข้องให้ดูในไฟล์ 
// tcpdf / config /  tcpdf_config.php 

// เริ่มสร้างไฟล์ pdf
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

//$pdf->setBuffer(128M);
// กำหนดรายละเอียดของไฟล์ pdf
$pdf->SetCreator(PDF_CREATOR);
//$pdf->SetAuthor('ninenik');
//$pdf->SetTitle('TCPDF table report');
//$pdf->SetSubject('TCPDF ทดสอบ');
//$pdf->SetKeywords('TCPDF, PDF, ทดสอบ,ninenik, guide');

// กำหนดข้อความส่วนแสดง header
/*$pdf->SetHeaderData(
    PDF_HEADER_LOGO, // โลโก้ กำหนดค่าในไฟล์  tcpdf_config.php 
    PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001',
    PDF_HEADER_STRING, // กำหนดเพิ่มเติมในไฟล์  tcpdf_config.php 
    array(0,0,0),  // กำหนดสีของข้อความใน header rgb 
    array(0,0,0)   // กำหนดสีของเส้นคั่นใน header rgb 
);*/

$pdf->setFooterData(
    array(0,64,0),  // กำหนดสีของข้อความใน footer rgb 
    array(220,44,44)   // กำหนดสีของเส้นคั่นใน footer rgb 
);

// กำหนดฟอนท์ของ header และ footer  กำหนดเพิ่มเติมในไฟล์  tcpdf_config.php 
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// ำหนดฟอนท์ของ monospaced  กำหนดเพิ่มเติมในไฟล์  tcpdf_config.php 
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// กำหนดขอบเขตความห่างจากขอบ  กำหนดเพิ่มเติมในไฟล์  tcpdf_config.php 
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// กำหนดแบ่่งหน้าอัตโนมัติ
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// กำหนดสัดส่วนของรูปภาพ  กำหนดเพิ่มเติมในไฟล์  tcpdf_config.php 
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// อนุญาตให้สามารถกำหนดรุปแบบ ฟอนท์ย่อยเพิมเติมในหน้าใช้งานได้
$pdf->setFontSubsetting(true);

// กำหนด ฟอนท์
$pdf->SetFont('thsarabun', '', 14, '', true);

// เพิ่มหน้า 
$pdf->AddPage();

//ob_start();

// เรียกใช้งาน ฟังก์ชั่นดึงข้อมูลไฟล์มาใช้งาน
//$html = include("data_html.php");

$conn = connDB("odbc");
?>

<HTML xmlns="http://www.w3.org/TR/REC-html40">
<HEAD>
<?php header('Content-Type: text/html; charset=utf-8'); ?>
</HEAD>
<BODY>
		<TABLE style="width:100%;" border="1">
					<tr> 
						<th rowspan="2">วันที่</th>
						<?php if($p_rain=="Y" && $nrf<>""){?><th colspan="<?php echo $nrf?>">ปริมาณน้ำฝน<Q CLASS="fs_small">(มม.)</Q></th><? }else{}?>
						<?php if($p_water=="Y" && $nwl<>""){?><th colspan="<?php echo $nwl?>">ระดับน้ำ<Q CLASS="fs_small">(ม.รทก)</Q></th><? }else{}?>
					</tr>
					<tr>
					<?php
					foreach($p_stn as $id)
					{
						$_value = cut($id);
						$ssite = $_value[0];
						//$_code= $_value[6];
						$rf = C_rf($_value[1],$p_rain);

						if($rf=="show"){ ?><th rowspan="1"><?php echo $ssite?></th><?php }else{}
					}

					foreach($p_stn as $id)
					{
						$_value = cut($id);
						$ssite = $_value[0];
						//$_code= $_value[6];
						$wl = C_wl($_value[2],$p_water);

						if($wl=="show"){ ?><th rowspan="1"><?php echo $ssite?></th><?php }else{}
					}
					?>
					</tr>
				</thead>

<?php
if($p_format=="f_15")
{	
			
				$strQuery = "SELECT CONVERT(varchar(16),dtm,121) DT ";
						
				foreach($p_stn as $id)
				{
					$_value = cut($id);
					$ssite = $_value[0];
					//$nname = $_value[4];

					$strQuery .=",Sum(case when stn='".$ssite."' then rf  end) RF_".$ssite." ";
				}
				foreach($p_stn as $id)
				{
					$_value = cut($id);
					$ssite = $_value[0];
					//$nname = $_value[4];

					$strQuery .=",Sum(case when stn='".$ssite."' then wl  end) WL_".$ssite." ";
				}
				
				$strQuery .="FROM [dbo].[Daily]
					WHERE 
					CONVERT(varchar(16),dtm,121) between '".$p_day1." 00:00' and '".$p_day2." 23:45' AND (DATEPART(MINUTE ,dtm))%15='0'
					GROUP BY 
						CONVERT(varchar(16),dtm,121)
					ORDER BY 
						CONVERT(varchar(16),dtm,121)	";

				//echo $strQuery;

					$objExec = odbc_exec($conn,$strQuery);
					while($objResult = odbc_fetch_array($objExec))
					{
						?>
							<tr>
								<td><?php echo $objResult['DT'];?></td>
								<?php
								foreach($p_stn as $id)
								{
									$_value = cut($id);
									$ssite = $_value[0];
									$rf = C_rf($_value[1],$p_rain);
									//$nname = $_value[4];

									if($rf=="show"){ ?><td><?php echo numm($objResult['RF_'.$ssite.'']) ?></td><?php }else{}
								}
								foreach($p_stn as $id)
								{
									$_value = cut($id);
									$ssite = $_value[0];
									$wl = C_wl($_value[2],$p_water);
									//$nname = $_value[4];

									if($wl=="show"){ ?><td><?php echo numm($objResult['WL_'.$ssite.'']) ?></td><?php }else{}
								}
								?>
							</tr>
						<?php
					}


}
else if($p_format=="f_hr")
{	
				$strQuery = "SELECT CONVERT(varchar(16),dtm,121) DT ";	
				foreach($p_stn as $id)
				{
					$_value = cut($id);
					$ssite = $_value[0];
					//$nname = $_value[4];

					$strQuery .=",Sum(case when stn='".$ssite."' then rf  end) RF_".$ssite." ";
				}
				foreach($p_stn as $id)
				{
					$_value = cut($id);
					$ssite = $_value[0];
					//$nname = $_value[4];

					$strQuery .=",Sum(case when stn='".$ssite."' then wl  end) WL_".$ssite." ";
				}
				
				$strQuery .=" FROM [dbo].[Daily]
							WHERE CONVERT(varchar(16),dtm,121) between '".$p_day1." 00:00' and '".$p_day2." 23:45' 
								AND (DATEPART(MINUTE ,dtm))='00'
							GROUP BY 
								CONVERT(varchar(16),dtm,121)
							ORDER BY 
								CONVERT(varchar(16),dtm,121)	";

				$objExec = odbc_exec($conn,$strQuery);
				while($objResult = odbc_fetch_array($objExec))
				{

						$starhour=date("Y-m-d H:15",strtotime('-1 hour',strtotime($objResult['DT'])));
						$endhour=date("Y-m-d H:00",strtotime($objResult['DT']));
						
						//echo $starhour."<BR>";
						//echo $endhour."<BR>";

						$sumrain = "SELECT Sum(case when stn='' then rf end) aa";	
						foreach($p_stn as $id)
						{
							$_value = cut($id);
							$ssite = $_value[0];
							//$nname = $_value[4];

							$sumrain .=" ,CONVERT(decimal(38,2),SUM(case when stn='".$ssite."' then rf  end)) vhour_".$ssite." ";
						}					
						$sumrain .="FROM [dbo].[Daily] WHERE CONVERT(varchar(16),dtm,121) between '".$starhour."' and '".$endhour."'";

						$sumrf =odbc_exec($conn,$sumrain);
						$sumrfh=odbc_fetch_array($sumrf);

						?>
							<tr>
								<td><?php echo $objResult['DT'];?></td>
								<?php
								foreach($p_stn as $id)
								{
									$_value = cut($id);
									$ssite = $_value[0];
									$rf = C_rf($_value[1],$p_rain);
									//$nname = $_value[4];

									if($rf=="show"){ ?><td><?php echo numm($sumrfh['vhour_'.$ssite.'']) ?></td><?php }else{}
								}
								foreach($p_stn as $id)
								{
									$_value = cut($id);
									$ssite = $_value[0];
									$wl = C_wl($_value[2],$p_water);
									//$nname = $_value[4];

									if($wl=="show"){ ?><td><?php echo numm($objResult['WL_'.$ssite.'']) ?></td><?php }else{}
								}
								?>
							</tr>
						<?php
					}
}
else if($p_format=="f_mean")
{	
				$start = strtotime($p_day1);
				$end = strtotime($p_day2);
				for ( $a = $start; $a <= $end; $a += 86400 )
				{	
					$dt=date("Y-m-d",$a);

					$strQuery = "SELECT Sum(case when stn='' then rf end) aa";	
					foreach($p_stn as $id)
					{
						$_value = cut($id);
						$ssite = $_value[0];
						//$nname = $_value[4];

						$strQuery .=" ,Sum(case when stn='".$ssite."' then rf  end) RF_".$ssite." ";
					}
					foreach($p_stn as $id)
					{
						$_value = cut($id);
						$ssite = $_value[0];
						//$nname = $_value[4];

						$strQuery .=" ,avg(case when stn='".$ssite."' then wl  end) WL_".$ssite." ";
					}
					
					$strQuery .=" FROM 	[dbo].[Daily]
							WHERE dtm between (select convert(varchar(16),(convert(varchar(10),'".$dt."',120)+' 07:01'),120)) 
							and dateAdd(dd, 1, (select convert(varchar(16),(convert(varchar(10),'".$dt."',120)+' 07:01'),120)))	";
				
					$objExec = odbc_exec($conn,$strQuery);
					//$checkrow=odbc_num_rows($objExec);
					$date_now = $dt.' 07:00';
					while($objResult = odbc_fetch_array($objExec))
					{
						?>
							<tr>
								<td><?php echo $date_now;?></td>
								<?php
								foreach($p_stn as $id)
								{
									$_value = cut($id);
									$ssite = $_value[0];
									$rf = C_rf($_value[1],$p_rain);
									//$nname = $_value[4];

									if($rf=="show"){ ?><td><?php echo numm($objResult['RF_'.$ssite.'']) ?></td><?php }else{}
								}
								foreach($p_stn as $id)
								{
									$_value = cut($id);
									$ssite = $_value[0];
									$wl = C_wl($_value[2],$p_water);
									//$nname = $_value[4];

									if($wl=="show"){ ?><td><?php echo numm($objResult['WL_'.$ssite.'']) ?></td><?php }else{}
								}
								?>
							</tr>
						<?php
					}	
				}
}
else if($p_format=="f_min")
{	
				$start = strtotime($p_day1);
				$end = strtotime($p_day2);
				for ( $a = $start; $a <= $end; $a += 86400 )
				{	
					$dt=date("Y-m-d",$a);

					$strQuery = "SELECT min(case when stn='' then rf end) aa";	
					foreach($p_stn as $id)
					{
						$_value = cut($id);
						$ssite = $_value[0];
						//$nname = $_value[4];

						$strQuery .=" ,min(case when stn='".$ssite."' then rf  end) RF_".$ssite." ";
					}
					foreach($p_stn as $id)
					{
						$_value = cut($id);
						$ssite = $_value[0];
						//$nname = $_value[4];

						$strQuery .=" ,min(case when stn='".$ssite."' then wl  end) WL_".$ssite." ";
					}
					
					$strQuery .=" FROM 	[dbo].[Daily]
							WHERE dtm between (select convert(varchar(16),(convert(varchar(10),'".$dt."',120)+' 07:01'),120)) 
							and dateAdd(dd, 1, (select convert(varchar(16),(convert(varchar(10),'".$dt."',120)+' 07:01'),120)))	";
				
					$objExec = odbc_exec($conn,$strQuery);
					//$checkrow=odbc_num_rows($objExec);
					$date_now = $dt.' 07:00';
					while($objResult = odbc_fetch_array($objExec))
					{
						?>
							<tr>
								<td><?php echo $date_now;?></td>
								<?php
								foreach($p_stn as $id)
								{
									$_value = cut($id);
									$ssite = $_value[0];
									$rf = C_rf($_value[1],$p_rain);
									//$nname = $_value[4];

									if($rf=="show"){ ?><td><?php echo numm($objResult['RF_'.$ssite.'']) ?></td><?php }else{}
								}
								foreach($p_stn as $id)
								{
									$_value = cut($id);
									$ssite = $_value[0];
									$wl = C_wl($_value[2],$p_water);
									//$nname = $_value[4];

									if($wl=="show"){ ?><td><?php echo numm($objResult['WL_'.$ssite.'']) ?></td><?php }else{}
								}
								?>
							</tr>
						<?php
					}	
				}
}
else if($p_format=="f_max")
{	
				$start = strtotime($p_day1);
				$end = strtotime($p_day2);
				for ( $a = $start; $a <= $end; $a += 86400 )
				{	
					$dt=date("Y-m-d",$a);

					$strQuery = "SELECT max(case when stn='' then rf end) aa";	
					foreach($p_stn as $id)
					{
						$_value = cut($id);
						$ssite = $_value[0];
						//$nname = $_value[4];

						$strQuery .=" ,max(case when stn='".$ssite."' then rf  end) RF_".$ssite." ";
					}
					foreach($p_stn as $id)
					{
						$_value = cut($id);
						$ssite = $_value[0];
						//$nname = $_value[4];

						$strQuery .=" ,max(case when stn='".$ssite."' then wl  end) WL_".$ssite." ";
					}
					
					$strQuery .=" FROM 	[dbo].[Daily]
							WHERE dtm between (select convert(varchar(16),(convert(varchar(10),'".$dt."',120)+' 07:01'),120)) 
							and dateAdd(dd, 1, (select convert(varchar(16),(convert(varchar(10),'".$dt."',120)+' 07:01'),120)))	";
				
					$objExec = odbc_exec($conn,$strQuery);
					//$checkrow=odbc_num_rows($objExec);
					$date_now = $dt.' 07:00';
					while($objResult = odbc_fetch_array($objExec))
					{
						?>
							<tr>
								<td><?php echo $date_now;?></td>
								<?php
								foreach($p_stn as $id)
								{
									$_value = cut($id);
									$ssite = $_value[0];
									$rf = C_rf($_value[1],$p_rain);
									//$nname = $_value[4];

									if($rf=="show"){ ?><td><?php echo numm($objResult['RF_'.$ssite.'']) ?></td><?php }else{}
								}
								foreach($p_stn as $id)
								{
									$_value = cut($id);
									$ssite = $_value[0];
									$wl = C_wl($_value[2],$p_water);
									//$nname = $_value[4];

									if($wl=="show"){ ?><td><?php echo numm($objResult['WL_'.$ssite.'']) ?></td><?php }else{}
								}
								?>
							</tr>
						<?php
					}	
				}
}
else {}

///else///

?>
</table>
</BODY>
</HTML>
<?Php
$HTMLoutput = ob_get_contents();

//$pdf->writeHTMLCell(0, 0, '', '', $HTMLoutput, 0, 1, 0, true, '', true);
$pdf->writeHTML($HTMLoutput, true, false, true, false, '');
//ob_clean();
ob_end_clean();
//ob_flush();
//flush(); 
 
// แสดงไฟล์ pdf
$pdf->Output("$aname.pdf", 'I');
ini_set('memory_limit',$original_mem);
?>