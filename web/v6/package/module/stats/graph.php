<!--<script type="text/javascript" src="../../js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="chart/highstock.js"></script>
<script type="text/javascript" src="chart/exporting.js"></script>-->

<?php

$conn = connDB("odbc");

$tdt = explode("-",$datetime);
if($tdt[1]=='02' AND $tdt[2]>28)
{
	$info = cal_days_in_month( CAL_GREGORIAN , $tdt[1] , $tdt[0] ) ;
	$date2=$tdt[0]."-".$tdt[1]."-".$info;
}
if($tdt[1]=='04' AND $tdt[2]>30)
{
	$info = cal_days_in_month( CAL_GREGORIAN , $tdt[1] , $tdt[0] ) ;
	$date2=$tdt[0]."-".$tdt[1]."-".$info;
}
if($tdt[1]=='06' AND $tdt[2]>30)
{
	$info = cal_days_in_month( CAL_GREGORIAN , $tdt[1] , $tdt[0] ) ;
	$date2=$tdt[0]."-".$tdt[1]."-".$info;
}
if($tdt[1]=='09' AND $tdt[2]>30)
{
	$info = cal_days_in_month( CAL_GREGORIAN , $tdt[1] , $tdt[0] ) ;
	$date2=$tdt[0]."-".$tdt[1]."-".$info;
}
if($tdt[1]=='11' AND $tdt[2]>30)
{
	$info = cal_days_in_month( CAL_GREGORIAN , $tdt[1] , $tdt[0] ) ;
	$date2=$tdt[0]."-".$tdt[1]."-".$info;
}


//$chcount = 0;
foreach($p_stn as $id)
{
	$_value = cut($id);
	$ssite = $_value[0];
	//$nname = $_value[4];

	$s_rf = C_rf($_value[1],$p_rain);
	$s_wl = C_wl($_value[2],$p_water);

	//$chcount++;
	//echo $ssite."-".$chcount."<BR>";
}

//$chcount = 0;

$colors = array('','#228B22', '#528B8B', '#A0522D', '#483D8B', '#2F4F4F' , '#8B658B' , '#CD9B9B' , '#CD5555' , '#CD6839' , '#CD2626' , '#EE9A00' , '#CD6600' , '#CD0000' , '#CD1076' , '#8B4789' , '#C71585' , '#ECAB53' , '#008080' , '#00BB00' , '#778899' , '#97FFFF' , '#FFE4B5' , '#4876FF' , '#B0E0E6' , '#7CFC00' , '#2E8B57');

$v = array();
$e = array();
$rain = array();
$water = array();

foreach ( $p_stn as $index => $value )
{
		$n = $index + 1;
		$arr = explode('_', $value);
		$x = explode('.', $arr[0]);
		array_push($v, $arr[0]);

		$v1 = "tn".$arr[0];
		$$v1 = $arr[0];

		$v2 = "_namec".$arr[0];
		$$v2 = $arr[1];

		$v3 = "_nrow".$arr[0];
		$$v3 = str_replace('.', '', $arr[0]);

		$v4 = "cnumtn".$arr[0];
		$$v4 = $n;

		/*-------check rain--------------*/
		if( $arr[2] == "1" )
		{
			array_push($rain, $arr[0]);

			$v5 = "rf_tn".$arr[0];
			$$v5 = array();
		}
		/*-------check water--------------*/

		if( $arr[3] == "1" )
		{
			array_push($water, $arr[0]);

			$v6 = "wl_tn".$arr[0];
			$$v6 = array();
		}
//print_r ($arr);
}
//exit();

if($p_rain=="Y")
{
	$nametype="กราฟ".$_cfg_data_type["rf"][0]; 
	$yname=$_cfg_data_type["rf"][1];
	$yaname=$_cfg_data_type["rf"][0]." ".$_cfg_data_type["rf"][1];
	$typess="column";
	$minva=0;
	$maxva=100;
    
	if($p_format=="f_15")
	{
		
			$p_date=date("Y-m-d",strtotime($p_day1));
			$maxZ= 3 * 60 * 60 * 1000;//3 * 3600000;
			$pointIn= 900 * 1000; // 15 min
			$mmdate=date("m",strtotime($p_day1))-1;
			$formatdd="%e. %B %Y %H:%M";
			$minva = $maxva = null;
			$a=15;
			$b=900;

			$strQuery = "SELECT CONVERT(varchar(16),dtm,121) adate ";
						
				foreach($p_stn as $id)
				{
					$_value = cut($id);
					$ssite = $_value[0];
					//$nname = $_value[4];

					$strQuery .=",Sum(case when stn='".$ssite."' then rf  end) RF_".$ssite." ";
				}
				
				$strQuery .="FROM [dbo].[Daily]
					WHERE CONVERT(varchar(16),dtm,121) between '".$p_day1." 00:00' and '".$p_day2." 23:45' AND (DATEPART(MINUTE ,dtm))%15='0'
					GROUP BY CONVERT(varchar(16),dtm,121) ORDER BY CONVERT(varchar(16),dtm,121)";
		

		//echo $strQuery;

		$result = odbc_exec($conn,$strQuery);
		//$checkrow=mssql_num_rows($result);
		
		$stagearray=array();

		$stadatey=date("Y",strtotime($p_day1));	
		$stadatem=date("m",strtotime($p_day1));	
		$stadated=date("d",strtotime($p_day1));

		$stadateh=date("H",strtotime($p_day1));
		$stadatei=date("i",strtotime($p_day1));
				
		$sm=$stadatey."-".$stadatem;
		
		if ($p_format=="f_15")
		{
			$stadate=strtotime($p_day1);
			$enddate=strtotime($p_day2)+86400;
		}
		else{}

		while($stadate < $enddate)
		{

			if ($row = odbc_fetch_array($result))
			{
				
				$sname=strtotime($row['adate']);
				
				while($stadate < $sname)
				{
					foreach ( $v as $i )
					{
						if ( in_array($i, $rain) )
						{
							$x = "rf_tn".$i;
							array_push($$x,"[ Date.UTC(".($stadatey+543).",".($stadatem-1).",".$stadated.",".$stadateh.",".$stadatei."),  null]");
						}
					}

					if ($p_format=="f_15")
					{
						$stadatei+=$a;
						$stadate+=$a*60;
					}
					

				}

				foreach ( $v as $i )
				{
					$vv = "val_tn".$i;
					$r = "_nrow".$i;
					$x = "rf_tn".$i;
					
					if ( in_array($i, $rain) )
					{
						if($row['RF_'.$$r.'']==null){$$vv ="null";}else{$$vv =$row['RF_'.$$r.''];}
						array_push($$x,"[ Date.UTC(".($stadatey+543).",".($stadatem-1).",".$stadated.",".$stadateh.",".$stadatei."),  ".$$vv."]");
					}
				}

				if ($p_format=="f_15")
				{
					$stadatei+=$a;
					$stadate+=$a*60;
				}
			
			}
			else
			{
				foreach ( $v as $i )
				{
					if ( in_array($i, $rain) )
					{
						$x = "rf_tn".$i;
						array_push($$x,"[ Date.UTC(".($stadatey+543).",".($stadatem-1).",".$stadated.",".$stadateh.",".$stadatei."),  null]");
					}
				}

				if ($p_format=="f_15")
				{
					$stadatei+=$a;
					$stadate+=$a*60;
				}						
			}
		}

	}
	else if($p_format=="f_hr")
	{
		$p_date=date("Y-m-d",strtotime($p_day1));
		$maxZ= 3 * 60 * 60 * 1000;//3 * 3600000;
		$pointIn= 3600 * 1000; // 15 min
		$mmdate=date("m",strtotime($p_day1))-1;
		$formatdd="%e. %B %Y %H:%M";
		$minva = $maxva = null;
		$a=60;
		$b=3600;


		$start = strtotime($p_day1);
		$end = strtotime($p_day2)+86400;


		for ( $tt = $start; $tt <= $end; $tt += 3600 )
		{	
			$dt=date("Y-m-d H:i",$tt);

			$starhour=date("Y-m-d H:15",strtotime('-1 hour',strtotime($dt)));
			$endhour=date("Y-m-d H:00",strtotime($dt));

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
				
			//echo $sumrain;
			$sumrf =odbc_exec($conn,$sumrain);
			
			//echo $dt."_";
			//echo $row['vhour_'.$_nrow2.'']."<BR>";
			
			$stadatey=date("Y",strtotime($dt));	
			$stadatem=date("m",strtotime($dt));	
			$stadated=date("d",strtotime($dt));
			$stadateh=date("H",strtotime($dt));
			$stadatei=date("i",strtotime($dt));
					
			$sm=$stadatey."-".$stadatem;

			$row=odbc_fetch_array($sumrf);

			foreach ( $v as $i )
			{
				$vv = "val_tn".$i;
				$r = "_nrow".$i;
				$x = "rf_tn".$i;
				
				if ( in_array($i, $rain))
				{
					if($row['vhour_'.$$r.'']==null){$$vv ="null";}else{$$vv =$row['vhour_'.$$r.''];}
					array_push($$x,"[ Date.UTC(".($stadatey+543).",".($stadatem-1).",".$stadated.",".$stadateh.",".$stadatei."),  ".$$vv."]");
				}
			}

		}//for

	}
	else
	{

		$p_date=date("Y-m-d 07:00",strtotime($p_day1));
		$maxZ= 3 * 60 * 60 * 1000;//3 * 3600000;
		$pointIn=  24 * 3600 * 1000; // 15 min
		$mmdate=date("m",strtotime($p_day1))-1;
		$formatdd="%e. %B %Y %H:%M";
		$minva = $maxva = null;
		$a=1440;
		$b=86400;

		$start = strtotime($p_day1);
		$end = strtotime($p_day2);
		
		$stagearray=array();
		for ( $tt = $start; $tt <= $end; $tt += 86400 )
		{	
			$dt=date("Y-m-d",$tt);
			
			if($p_format=="f_mean")
			{
				$strQuery = "SELECT Sum(case when stn='' then rf end) aa";	
				foreach($p_stn as $id)
				{
					$_value = cut($id);
					$ssite = $_value[0];
					//$nname = $_value[4];

					$strQuery .=" ,Sum(case when stn='".$ssite."' then rf  end) RF_".$ssite." ";
				}					
				$strQuery .=" FROM 	[dbo].[Daily]
						WHERE dtm between (select convert(varchar(16),(convert(varchar(10),'".$dt."',120)+' 07:01'),120)) 
						and dateAdd(dd, 1, (select convert(varchar(16),(convert(varchar(10),'".$dt."',120)+' 07:01'),120)))	";
			}
			elseif($p_format=="f_min")
			{
				$strQuery = "SELECT Sum(case when stn='' then rf end) aa";	
				foreach($p_stn as $id)
				{
					$_value = cut($id);
					$ssite = $_value[0];
					//$nname = $_value[4];

					$strQuery .=" ,min(case when stn='".$ssite."' then rf  end) RF_".$ssite." ";
				}					
				$strQuery .=" FROM 	[dbo].[Daily]
						WHERE dtm between (select convert(varchar(16),(convert(varchar(10),'".$dt."',120)+' 07:01'),120)) 
						and dateAdd(dd, 1, (select convert(varchar(16),(convert(varchar(10),'".$dt."',120)+' 07:01'),120)))	";
			}
			elseif($p_format=="f_max")
			{
				$strQuery = "SELECT Sum(case when stn='' then rf end) aa";	
				foreach($p_stn as $id)
				{
					$_value = cut($id);
					$ssite = $_value[0];
					//$nname = $_value[4];

					$strQuery .=" ,max(case when stn='".$ssite."' then rf  end) RF_".$ssite." ";
				}					
				$strQuery .=" FROM 	[dbo].[Daily]
						WHERE dtm between (select convert(varchar(16),(convert(varchar(10),'".$dt."',120)+' 07:01'),120)) 
						and dateAdd(dd, 1, (select convert(varchar(16),(convert(varchar(10),'".$dt."',120)+' 07:01'),120)))	";
			}
			else{}
		
			//echo $strQuery;
			$result = odbc_exec($conn,$strQuery);
			//$checkrow=odbc_num_rows($objExec);
			$date_now = $dt.' 07:00';
			

			$stadatey=date("Y",strtotime($date_now));	
			$stadatem=date("m",strtotime($date_now));	
			$stadated=date("d",strtotime($date_now));
			$stadateh=date("H",strtotime($date_now));
			$stadatei=date("i",strtotime($date_now));
					
			$sm=$stadatey."-".$stadatem;
			
			$stadate=strtotime($date_now);
			$enddate=strtotime($date_now)+86400;
			$row = odbc_fetch_array($result);

			foreach ( $v as $i )
			{
				$vv = "val_tn".$i;
				$r = "_nrow".$i;
				$x = "rf_tn".$i;
				
				if ( in_array($i, $rain) )
				{
					if($row['RF_'.$$r.'']==null){$$vv ="null";}else{$$vv =$row['RF_'.$$r.''];}
					array_push($$x,"[ Date.UTC(".($stadatey+543).",".($stadatem-1).",".$stadated.",".$stadateh.",".$stadatei."),  ".$$vv."]");
				}
			}

		}
	}
		
	$se = array();
	foreach ( $v as $i )
	{
		//$ponts_tn1=implode(",",$wt_tn1);
		if ( in_array($i, $rain) )
		{
			$x = "rf_tn".$i;
			$p = "ponts_tn".$i;
			$$p = implode(",", $$x);
			$n = "_namec".$i;
			$s = '{
				type: "column",
				name: "'.$$n.'",
				data: ['.$$p.'],
				color: "'.$colors[$i].'",
				lineWidth: 1,
				dashStyle:"solid"
			}';

			array_push($se, $s);
		}
	}
	$ss = implode(",", $se);

	?>
	<BR>
	<div id="graphRF" style="<?php echo $st;?>"></div>
	<script type="text/javascript">
	//alert("aa");
	$(function () {
		var chart;
		$(document).ready(function() {
			Highcharts.setOptions({
			lang: {
				months: ['ม.ค.', 'ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']		}
		});
			chart = new Highcharts.Chart({
				chart: {
					zoomType: 'x',
					renderTo: 'graphRF',
					type: 'column',
					spacingLeft: 25 ,
					resetZoomButton: {
						position: {
						// align: 'right', // by default
						 // verticalAlign: 'top', // by default
						x: -30,
						y: -20
						}
					}
				},
				credits: {
				enabled: false
				},
				title: {
					text: '<?php echo $nametype;?>',
				
				style: {
					fontSize: '14px'
				}
				},
				subtitle: {
					text: ''
				},
				xAxis: {
					type: 'datetime',
					//maxZoom: <?php echo $maxZ;?>,
					minRange: '<?php echo $a;?>' * 60 * 1000 * 6,
					minTickInterval: '<?php echo $a;?>' * 60 * 1000,
					title: {
						text: null
					},
					labels:{
					rotation:-45,
					align:'right',
					fontSize: '8px'
						},
					dateTimeLabelFormats: {
					second: '%H:%M:%S',
					minute: '%H:%M',
					hour: '%H:%M',
					day: '%e %B %Y',
					week:'%e %B %Y',
					month:'%B %Y',
					year:'%Y'
				}
				},
				yAxis: {
					min: '<?php echo $minva;?>',
					title: {
						text: '<?php echo $yaname;?>'
					}
				},
				tooltip: {
					formatter: function() {
					return  Highcharts.dateFormat('<?php echo $formatdd;?>',this.x) + '<br><b>' + this.y +'</b>'+'  มม.';
				}
				},
				plotOptions: {
					column: {
						pointPadding: 0.2,
						borderWidth: 0
					},
					series: {
					marker: {
						enabled:false,
						lineWidth: 0
					}
					}
					},
					scrollbar: {
					 enabled: true
					},
					series: [<?php echo $ss?>]
					,
					exporting: {
				 url: 'http://telekpattani.com/exporting_server/index.php'
			  }
			});
		});

	});
	</script>
	<?php	
}

if($p_water=="Y")
{
	$nametype="กราฟ".$_cfg_data_type["wl"][0]; 
	$yname=$_cfg_data_type["wl"][1];
	$yaname=$_cfg_data_type["wl"][0]." ".$_cfg_data_type["wl"][1];
	$typess="line";
	$wlH="หน้า ปตร.";
	$wlL="ท้าย ปตร.";

	if($p_format=="f_15" || $p_format=="f_hr")
	{
		if($p_format=="f_15")
		{
			$p_date=date("Y-m-d",strtotime($p_day1));
			$maxZ= 3 * 60 * 60 * 1000;//3 * 3600000;
			$pointIn= 900 * 1000; // 15 min
			$mmdate=date("m",strtotime($p_day1))-1;
			$formatdd="%e. %B %Y %H:%M";
			$minva = $maxva = null;
			$a=15;
			$b=900;

			$strQuery = "SELECT CONVERT(varchar(16),dtm,121) adate ";
						
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
		}
		elseif($p_format=="f_hr")
		{
			$p_date=date("Y-m-d",strtotime($p_day1));
			$maxZ= 3 * 60 * 60 * 1000;//3 * 3600000;
			$pointIn= 3600 * 1000; // 15 min
			$mmdate=date("m",strtotime($p_day1))-1;
			$formatdd="%e. %B %Y %H:%M";
			$minva = $maxva = null;
			$a=60;
			$b=3600;

			$strQuery = "SELECT CONVERT(varchar(16),dtm,121) adate ";	
			foreach($p_stn as $id)
			{
				$_value = cut($id);
				$ssite = $_value[0];
				//$nname = $_value[4];

				$strQuery .=",Sum(case when stn='".$ssite."' then wl  end) WL_".$ssite." ";
			}		
			$strQuery .=" FROM [dbo].[Daily]
						WHERE CONVERT(varchar(16),dtm,121) between '".$p_day1." 00:00' and '".$p_day2." 23:00' 
							AND (DATEPART(MINUTE ,dtm))='00'
						GROUP BY 
							CONVERT(varchar(16),dtm,121)
						ORDER BY 
							CONVERT(varchar(16),dtm,121)	";
		}
		else{}

		//echo $strQuery;
		$result = odbc_exec($conn,$strQuery);
		//$checkrow=mssql_num_rows($result);

		$stagearray=array();
		
				$stadatey=date("Y",strtotime($p_day1));	
				$stadatem=date("m",strtotime($p_day1));	
				$stadated=date("d",strtotime($p_day1));

				$stadateh=date("H",strtotime($p_day1));
				$stadatei=date("i",strtotime($p_day1));
						
				$sm=$stadatey."-".$stadatem;
				
				if ($p_format=="f_15" or $p_format=="f_hr")
				{
					$stadate=strtotime($p_day1);
					$enddate=strtotime($p_day2)+86400;
				}
				else{}
		
				while($stadate < $enddate)
				{

					if ($row = odbc_fetch_array($result))
					{
						
						$sname=strtotime($row['adate']);
						
						while($stadate < $sname)
						{
							foreach ( $v as $i )
							{
								if ( in_array($i, $water))
								{
									$x = "wl_tn".$i;
									array_push($$x,"[ Date.UTC(".($stadatey+543).",".($stadatem-1).",".$stadated.",".$stadateh.",".$stadatei."),  null]");
								}

								if ( in_array($i, $e) )
								{
									$y = "wle_tn".$i;
									array_push($$y,"[ Date.UTC(".($stadatey+543).",".($stadatem-1).",".$stadated.",".$stadateh.",".$stadatei."),  null]");
								}
							}

							if ($p_format=="f_15" or $p_format=="f_hr")
							{
								$stadatei+=$a;
								$stadate+=$a*60;
							}
						
						}

						foreach ( $v as $i )
						{
							if ( in_array($i, $water))
							{
								$vv = "val_tn".$i;
								$r = "_nrow".$i;
								$x = "wl_tn".$i;
								
								if($row['WL_'.$$r.'']==null){$$vv ="null";}else{$$vv =$row['WL_'.$$r.''];}
								array_push($$x,"[ Date.UTC(".($stadatey+543).",".($stadatem-1).",".$stadated.",".$stadateh.",".$stadatei."),  ".$$vv."]");
							}
							if ( in_array($i, $e) )
							{
								$ve = "vale_tn".$i;
								$re = "_nrow".$i;
								$y = "wle_tn".$i;

								if($row['WLE_'.$$re.'']==null){$$ve ="null";}else{$$ve =$row['WLE_'.$$re.''];}
								array_push($$y,"[ Date.UTC(".($stadatey+543).",".($stadatem-1).",".$stadated.",".$stadateh.",".$stadatei."),  ".$$ve."]");
							}
						}

						if ($p_format=="f_15" or $p_format=="f_hr")
						{
							$stadatei+=$a;
							$stadate+=$a*60;
						}
					
					}
					else
					{
						foreach ( $v as $i )
						{
							if ( in_array($i, $water))
							{
								$x = "wl_tn".$i;
								array_push($$x,"[ Date.UTC(".($stadatey+543).",".($stadatem-1).",".$stadated.",".$stadateh.",".$stadatei."),  null]");
							}
							if ( in_array($i, $e) )
							{
								$y = "wle_tn".$i;
								array_push($$y,"[ Date.UTC(".($stadatey+543).",".($stadatem-1).",".$stadated.",".$stadateh.",".$stadatei."),  null]");
							}
						}
						
						if ($p_format=="f_15" or $p_format=="f_hr")
						{
							$stadatei+=$a;
							$stadate+=$a*60;
						}							
					}
				}
	}
	else
	{

			$p_date=date("Y-m-d 07:00",strtotime($p_day1));
			$maxZ= 3 * 60 * 60 * 1000;//3 * 3600000;
			$pointIn=  24 * 3600 * 1000; // 15 min
			$mmdate=date("m",strtotime($p_day1))-1;
			$formatdd="%e. %B %Y %H:%M";
			$minva = $maxva = null;
			$a=1440;
			$b=86400;

			$start = strtotime($p_day1);
			$end = strtotime($p_day2);

			for ( $tt = $start; $tt <= $end; $tt += 86400 )
			{	
				$dt=date("Y-m-d",$tt);
				
				if($p_format=="f_mean")
				{
					$strQuery = "SELECT Sum(case when stn='' then rf end) aa";	
					foreach($p_stn as $id)
					{
						$_value = cut($id);
						$ssite = $_value[0];
						//$nname = $_value[4];

						$strQuery .=" ,CONVERT(decimal(38,2),avg(case when stn='".$ssite."' then wl  end)) WL_".$ssite." ";
					}					
					$strQuery .=" FROM 	[dbo].[Daily]
							WHERE dtm between (select convert(varchar(16),(convert(varchar(10),'".$dt."',120)+' 07:01'),120)) 
							and dateAdd(dd, 1, (select convert(varchar(16),(convert(varchar(10),'".$dt."',120)+' 07:01'),120)))	";
				}
				elseif($p_format=="f_min")
				{
					$strQuery = "SELECT Sum(case when stn='' then rf end) aa";	
					foreach($p_stn as $id)
					{
						$_value = cut($id);
						$ssite = $_value[0];
						//$nname = $_value[4];

						$strQuery .=" ,CONVERT(decimal(38,2),min(case when stn='".$ssite."' then wl  end)) WL_".$ssite." ";
					}					
					$strQuery .=" FROM 	[dbo].[DATA_Backup]
							WHERE dtm between (select convert(varchar(16),(convert(varchar(10),'".$dt."',120)+' 07:01'),120)) 
							and dateAdd(dd, 1, (select convert(varchar(16),(convert(varchar(10),'".$dt."',120)+' 07:01'),120)))	";
				}
				elseif($p_format=="f_max")
				{
					$strQuery = "SELECT Sum(case when stn='' then rf end) aa";	
					foreach($p_stn as $id)
					{
						$_value = cut($id);
						$ssite = $_value[0];
						//$nname = $_value[4];

						$strQuery .=" ,CONVERT(decimal(38,2),max(case when stn='".$ssite."' then wl  end)) WL_".$ssite." ";
					}					
					$strQuery .=" FROM 	[dbo].[Daily]
							WHERE dtm between (select convert(varchar(16),(convert(varchar(10),'".$dt."',120)+' 07:01'),120)) 
							and dateAdd(dd, 1, (select convert(varchar(16),(convert(varchar(10),'".$dt."',120)+' 07:01'),120)))	";
				}
				else{}
			
				//echo $strQuery;
				$result = odbc_exec($conn,$strQuery);
				//$checkrow=odbc_num_rows($objExec);
				$date_now = $dt.' 07:00';
				

				$stadatey=date("Y",strtotime($date_now));	
				$stadatem=date("m",strtotime($date_now));	
				$stadated=date("d",strtotime($date_now));
				$stadateh=date("H",strtotime($date_now));
				$stadatei=date("i",strtotime($date_now));
						
				$sm=$stadatey."-".$stadatem;
				
				$stadate=strtotime($date_now);
				$enddate=strtotime($date_now)+86400;
				$row = odbc_fetch_array($result);
		
				foreach ( $v as $i )
				{
					if ( in_array($i, $water))
					{
						$vv = "val_tn".$i;
						$r = "_nrow".$i;
						$x = "wl_tn".$i;
						
						if($row['WL_'.$$r.'']==null){$$vv ="null";}else{$$vv =$row['WL_'.$$r.''];}
						array_push($$x,"[ Date.UTC(".($stadatey+543).",".($stadatem-1).",".$stadated.",".$stadateh.",".$stadatei."),  ".$$vv."]");
					}
					if ( in_array($i, $e) )
					{
						$ve = "vale_tn".$i;
						$re = "_nrow".$i;
						$y = "wle_tn".$i;

						if($row['WLE_'.$$re.'']==null){$$ve ="null";}else{$$ve =$row['WLE_'.$$re.''];}
						array_push($$y,"[ Date.UTC(".($stadatey+543).",".($stadatem-1).",".$stadated.",".$stadateh.",".$stadatei."),  ".$$ve."]");
					}
				}		

			}
		}

		$se = array();
		foreach ( $v as $i )
		{
			if ( in_array($i, $water))
			{
				$x = "wl_tn".$i;
				$p = "ponts_tn".$i;
				$$p = implode(",", $$x);
				$n = "_namec".$i;
				$s = '{
					type: "line",
					name: "'.$$n.'",
					data: ['.$$p.'],
					color: "'.$colors[$i].'",
					lineWidth: 1,
					dashStyle:"solid"
				}';

				array_push($se, $s);
			}
		}
		$ss = implode(",", $se);

		?>
		<BR>
		<div id="graphWL" style="<?php echo $st;?>"></div>
			<script type="text/javascript">
			$(function () {
				var chart;
				$(document).ready(function() {
					Highcharts.setOptions({
					lang: {
						months: ['ม.ค.', 'ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']		}
				});
					chart = new Highcharts.Chart({
						chart: {
							zoomType: 'x',
							renderTo: 'graphWL',
							type: 'line',
							spacingLeft: 25 ,
							resetZoomButton: {
								position: {
								// align: 'right', // by default
								 // verticalAlign: 'top', // by default
								x: -30,
								y: -20
								}
							}
						},
						credits: {
						enabled: false
						},
						title: {
							text: '<?php echo $nametype;?>',
						
						style: {
							fontSize: '14px'
						}
						},
						subtitle: {
							text: ''
						},
						xAxis: {
							type: 'datetime',
							//maxZoom: <?php echo $maxZ;?>,
							minRange: '<?php echo $a;?>' * 60 * 1000 * 6,
							minTickInterval: '<?php echo $a;?>' * 60 * 1000,
							title: {
								text: null
							},
							labels:{
							rotation:-45,
							align:'right',
							fontSize: '8px'
								},
							dateTimeLabelFormats: {
							day: '%e %B %Y',
							week:'%e %B %Y',
							month:'%B %Y',
							year:'%Y'
						}
						},
						yAxis: {
							//min: '<?php echo $minva;?>',
							minRange: 0.1,
							minPadding: 1,
							maxPadding: 1,
							title: {
								text: '<?php echo $yaname;?>'
							}
							,allowDecimals: true
							//,reversed: true
						},
						tooltip: {
							formatter: function() {
							return  Highcharts.dateFormat('<?php echo $formatdd;?>',this.x) + '<br><b>' + this.y +'</b>'+' <?php echo $yname;?>';
						}
						},
						plotOptions: {
							series:{marker:{enabled:false}}
						},
						scrollbar: {
							 enabled: true
						},
						series: [
								 <?php echo $ss?>
								 ]
							,
							exporting: {
                         url: 'http://telekpattani.com/exporting_server/index.php'
                      }
					});
				});

			});
			</script>
		<?php	
}
?>