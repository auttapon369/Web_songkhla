<?php
//////////////////////////////////main//////////////////////////////////

$conn = connDB("odbc");

if($p_format=="f_15")
{		
	$name="ราย 15 นาที";
}
else if($p_format=="f_hr")
{
	$name="รายชั่วโมง";
}
else if($p_format=="f_mean")
{
	$name="รายวัน-เฉลี่ย";
}
else if($p_format=="f_min")
{
	$name="รายวัน-ต่ำสุด";
}
else
{
	$name="รายวัน-สูงสุด";
}


	/* $setion="SELECT STN_ID,STN_NAME_THAI FROM TM_STN where STN_ID='$station'";
	$resetion = odbc_exec($connection,$setion);
	$namestation=odbc_fetch_array($resetion);
    $namestn=$namestation['STN_ID'];
	$namethai=$namestation['STN_NAME_THAI'];
	$Dstn=iconv('TIS-620', 'UTF-8', $namestn);
	$Dname=iconv('TIS-620', 'UTF-8', $namethai);*/

	$aname="ข้อมูล".$name;
	$an=str_replace(" ","",$aname);

	$filename = $an.".xls";
	header("Content-Disposition: attachment; filename=\"$an.xls\"");#ชื่อไฟล์ 
	header("Content-Type: application/vnd.ms-excel");
?>
<html xmlns:o="urn:schemas-microsoft-com:office:office"xmlns:x="urn:schemas-microsoft-com:office:excel"xmlns="http://www.w3.org/TR/REC-html40">
<BODY>
<?php

///////////////////////////show data ////////////////////////////////////////
?>
	<TABLE border='1' width="100%">
					<tr> 
						<th rowspan="2">วันที่</th>
						<?php if($p_rain=="Y" && $nrf<>""){ ?><th colspan="<?php echo $nrf?>">ปริมาณน้ำฝน<Q CLASS="fs_small">(มม.)</Q></th><? }else{}?>
						<?php if($p_water=="Y" && $nwl<>""){ ?><th colspan="<?php echo $nwl?>">ระดับน้ำ<Q CLASS="fs_small">(ม.รทก)</Q></th><? }else{}?>
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