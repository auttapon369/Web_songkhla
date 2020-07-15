<style>
table {
    border-collapse: separate;
    empty-cells: hide;
}
</style>
<TABLE width="100%" CLASS="tb_report fs_small">
	<THEAD CLASS="bc_fade dc_black">
		<TR>
		<TH ROWSPAN="2"><?php echo ($_SESSION['leau']=='en')?"Row":"ลำดับ";?></TH>
			<TH ROWSPAN="2"><?php echo ($_SESSION['leau']=='en')?"Telemetry Station":"สถานีโทรมาตร";?></TH>
			<TH ROWSPAN="2"><?php echo ($_SESSION['leau']=='en')?"Date Time":"วัน,เวลา(น)";?></TH>
			<!-- <TH ROWSPAN="2"><?php echo $_cfg_data_type['rf'][0]." <br>(".$_cfg_data_type['rf'][1].")"; ?></TH> -->
			<TH ROWSPAN="2"><?php echo $_cfg_data_type['rf24'][0]." <br>(".$_cfg_data_type['rf24'][1].")"; ?></TH>
			<TH ROWSPAN="2"><?php echo $_cfg_data_type['wl'][0]."<br> (".$_cfg_data_type['wl'][1].")"; ?></TH>
			
			<TH ROWSPAN="2"><?php echo ($_SESSION['leau']=='en')?"Status":"สถานะ";?><br><?php echo ($_SESSION['leau']=='en')?"Station":"สถานี";?></TH>
			
			<!-- <TH ROWSPAN="2"><?php echo ($_SESSION['leau']=='en')?"":"";?></TH> -->

		
			
		
				
			<TH ROWSPAN="2"><?php echo ($_SESSION['leau']=='en')?"RainFall":"น้ำฝน";?></TH>
			<TH ROWSPAN="2" ><?php echo ($_SESSION['leau']=='en')?"Water Level":"ระดับน้ำ";?></TH>
			<TH ROWSPAN="2"><?php echo ($_SESSION['leau']=='en')?"Situation":"สถานการณ์<br>น้ำ";?></TH>

		</TR>
	</THEAD>
	<TBODY CLASS="dc_fade">	
	<?php 
	for ( $i = 0; $i < count($_stn); $i++ )
	{
		
		$n = $i + 1;
		$val = $_call->get_values($_stn[$i]['id']);
		
		$error = $_call->TimeDiff($val['date'], date('Y-m-d H:i'));
		$ef_lost = ( $error > 2 ) ? "fc_gray" : null;
		$ic_rf = "rf_".$_call->alarmCheck($val['rf_24'], $_stn[$i]['rf1'], $_stn[$i]['rf2'],'0','0', $error);
		$ic_wl = "wl_".$_call->alarmCheck($val['wl'], $_stn[$i]['wl1'], $_stn[$i]['wl2'], $_stn[$i]['wl0'], $_stn[$i]['wl00'], $error);

		$wl_alarm1;
			if($val['wl'] > $_stn[$i]['wl2']){$wl_alarm1 ='label label-danger';}
			else if($val['wl'] > $_stn[$i]['wl1']){$wl_alarm1 ='label label-warning';}
			else if($val['wl'] < $_stn[$i]['wl00']){$wl_alarm1 ='label label-danger';}
			else if($val['wl'] < $_stn[$i]['wl0']){$wl_alarm1 ='label label-warning';}
			else{$wl_alarm1 ='';}
///
///
		$rf_alarm1;

			if($val['rf_24'] > $_stn[$i]['rf2']){$rf_alarm1 ='label label-danger';}
			else if($val['rf_24'] > $_stn[$i]['rf1']){$rf_alarm1 ='label label-warning';}
			else{$rf_alarm1 ='';}

		//$error1 = $_call->TimeDiff($value['date'], date('Y-m-d H:i'));

		$stat_station = $_call->alarmCheck($val['wl'], $_stn[$i]['wl1'], $_stn[$i]['wl2'], $_stn[$i]['wl0'], $_stn[$i]['wl00'], $error, "txt");
		
		// rf
		if ( $_stn[$i]['rf'] == 1 )
		{
			if($_stn[$i]['showrf'] == '1')
			{
			$ic_rf = "<DIV CLASS=\"icon ".$ic_rf."\"></DIV>";
			//$bc_rf = null;
			$val_rf = $val['rf_77'];
			$val_rf_1 = $val['rf_1h'];
			$val_rf_24 = $val['rf_24'];
			}
			else
			{
				$val_rf = null;
				$ic_rf = null;
				$val_rf_24 = null;
				$rf_alarm1 = '';
			}
		}
		else
		{
			$ic_rf = null;
			//$bc_rf = "bc_gray";
			$val_rf = "-";
			$val_rf_1 = "-";
			$val_rf_24 = "-";

			
		}
		$stat_wl_text = $_call->alarmCheck($val['wl'], $_stn[$i]['wl1'], $_stn[$i]['wl2'], $_stn[$i]['wl0'], $_stn[$i]['wl00'], $error, "wl");
		// wl
		if ( $_stn[$i]['wl'] == 1 )
		{
			if($_stn[$i]['showwl'] == '1')
			{
			$ic_wl = "<DIV CLASS=\"icon ".$ic_wl."\"></DIV>";
			//$bc_wl = null;
			$lv1_wl = $_stn[$i]['wl1'];
			$val_wl = $val['wl'];
			$val_wle = ( $_stn[$i]['end'] == "Y" ) ? $val['wle'] : "-";
			$val_fl = ( !in_array($_stn[$i]['id'], $_cfg_flow) ) ? $val['fl'] : '-';
			$val_ca = ( !in_array($_stn[$i]['id'], $_cfg_flow) ) ? $val['ca'] : '-';
			$stat_wl_text = $_call->alarmCheck($val['wl'], $_stn[$i]['wl1'], $_stn[$i]['wl2'], $_stn[$i]['wl0'], $_stn[$i]['wl00'], $error, "wl");
			}else
			{
				$ic_wl = null;
				$val_wl = null;
				$wl_alarm1 = '';
				$stat_wl_text = null;
			}
		}
		else
		{
			$ic_wl = null;
			//$bc_wl = "bc_gray";
			$lv1_wl = "-";
			$val_wl = "-";
			$val_wle = "-";
			$val_fl = "-";
			$val_ca = "-";
			$stat_wl_text = "";

			
		}

		//$bc_wle = ( $_stn[$i]['end'] == "Y" ) ? null : "bc_gray";
		$_name = ($_SESSION['leau']=='en')?$_stn[$i]['name_en']:$_stn[$i]['name'];
		echo "<TR CLASS=\"".$ef_lost."\">\n";
		echo "\t<TD  CLASS=\"center nowrap\">".($i + 1)."</TD>";
		echo "\t<TD CLASS=\"left nowrap\"><A HREF=\"./?page=station&id=".$_stn[$i]['id']."\">".$_stn[$i]['code']." ".$_name."</A></TD>";
		echo "<TD CLASS=\"center nowrap\" ID=\"DT".$n."\"><SPAN>".$_call->date_simple($val['date'])."</SPAN></TD>";
		echo "<TD CLASS=\"right ".$bc_rf."\" ID=\"RF_15MIN".$n."\"><SPAN ID=\"RF_15MIN_".$n."\" CLASS=\"".$rf_alarm1."\">".$val_rf_24."</SPAN></TD>";
//		echo "<TD CLASS=\"right ".$bc_rf."\" ID=\"RF_15MIN".$n."\"><SPAN ID=\"RF_15MIN_".$n."\" CLASS=\"".$rf_alarm1."\">".$val_rf_24."</SPAN></TD>";
		//echo "<TD CLASS=\"right ".$bc_rf."\" ID=\"RF_1H".$n."\"><SPAN>".$val_rf_1."</SPAN></TD>";
		//echo "<TD CLASS=\"right ".$bc_rf."\" ID=\"RF_24H".$n."\"><SPAN>".$val_rf_24."</SPAN></TD>";
	
		echo "<TD CLASS=\"right ".$bc_wl."\" ID=\"WL".$n."\"><SPAN ID=\"WL_".$n."\" CLASS=\"".$wl_alarm1."\">".$val_wl."</SPAN></TD>";

		$check = $_stn[$i]['showwl'] + $_stn[$i]['showrf'];
		if($check < 2)
			{
			$stat_station_ch='';
			$sty = 'ic_aaa';
			}
		else{
			$stat_station_ch=$stat_station;
			$sty = '';
			}
		echo "<TD CLASS=\"center\"><SPAN CLASS=\"".$sty."\">".$stat_station_ch."</SPAN></TD>";
		echo "<TD CLASS=\"center\">".$ic_rf."</TD>";
		echo "<TD CLASS=\"center\">".$ic_wl."</TD>\n";
		echo "<TD CLASS=\"left\">".$stat_wl_text."</TD>\n";
		
		echo "</TR>\n";
		
		flush();
		ob_flush();
	}
	unset($i);
	?>
	</TBODY>
</TABLE>