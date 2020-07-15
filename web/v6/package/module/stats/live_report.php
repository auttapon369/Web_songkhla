

<TABLE width="100%" CLASS="tb_report fs_small">
	<THEAD CLASS="bc_fade dc_black">
		<TR>
			<TH ROWSPAN="2"><?php echo ($_SESSION['leau']=='en')?"Telemetry Station":"สถานีโทรมาตร";?></TH>
			<TH ROWSPAN="2"><?php echo ($_SESSION['leau']=='en')?"Date Time":"วัน,เวลา (น)";?></TH>
			<TH COLSPAN="7"><?php echo $_cfg_data_type['wl'][2]."<br> (".$_cfg_data_type['wl'][1].")"; ?></TH>
			<TH COLSPAN="3"><?php echo $_cfg_data_type['wl'][0]."<br> (".$_cfg_data_type['wl'][1].")"; ?></TH>
			<TH ROWSPAN="2"><?php echo $_cfg_data_type['rf'][0]."<br> (".$_cfg_data_type['rf'][1].")"; ?></TH>
			<TH ROWSPAN="2"><?php echo $_cfg_data_type['rf24'][0]."<br> (".$_cfg_data_type['rf24'][1].")"; ?></TH>
			<TH COLSPAN="2"><?php echo ($_SESSION['leau']=='en')?"Situation":"สถานการณ์";?></TH>
		</TR>
		<TR>
			<?php $adate=date("Y-m-d");?>
		    <TH><?php echo date("d/m",strtotime("-7 days",strtotime($adate)));?></TH>
			<TH><?php echo date("d/m",strtotime("-6 days",strtotime($adate)));?></TH>
			<TH><?php echo date("d/m",strtotime("-5 days",strtotime($adate)));?></TH>
			<TH><?php echo date("d/m",strtotime("-4 days",strtotime($adate)));?></TH>
			<TH><?php echo date("d/m",strtotime("-3 days",strtotime($adate)));?></TH>
			<TH><?php echo date("d/m",strtotime("-2 days",strtotime($adate)));?></TH>
			<TH><?php echo date("d/m",strtotime("-1 days",strtotime($adate)));?></TH>
		
			
			<TH><?php echo ($_SESSION['leau']=='en')?"Now":"ปัจจุบัน";?></TH>
			<TH><?php echo ($_SESSION['leau']=='en')?"Danger":"วิกฤต";?></TH>
			<TH><?php echo ($_SESSION['leau']=='en')?"Diff":"ผลต่าง";?></TH>
		
		
		
			<TH><?php echo ($_SESSION['leau']=='en')?"RainFall":"น้ำฝน";?></TH>
			<TH><?php echo ($_SESSION['leau']=='en')?"Water Level":"ระดับน้ำ";?></TH>
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
		$ic_rf = "rf_".$_call->alarmCheck($val['rf_77'], $_stn[$i]['rf1'], $_stn[$i]['rf2'],'0','0', $error);
		$ic_wl = "wl_".$_call->alarmCheck($val['wl'], $_stn[$i]['wl1'], $_stn[$i]['wl2'], $_stn[$i]['wl0'], $_stn[$i]['wl00'], $error);

		// rf
		if ( $_stn[$i]['rf'] == 1 )
		{
			$ic_rf = "<DIV CLASS=\"icon ".$ic_rf."\"></DIV>";
			//$bc_rf = null;
			$val_rf = $val['rf_77'];
			$val_rf_1 = $val['rf_1h'];
			$val_rf_24 = $val['rf_24'];
		}
		else
		{
			$ic_rf = null;
			//$bc_rf = "bc_gray";
			$val_rf = "-";
			$val_rf_1 = "-";
			$val_rf_24 = "-";
		}

		// wl
		if ( $_stn[$i]['wl'] == 1 )
		{
			$ic_wl = "<DIV CLASS=\"icon ".$ic_wl."\"></DIV>";
			//$bc_wl = null;
			$lv1_wl = $_stn[$i]['wl1'];
			$val_wl = $val['wl'];
			$val_wle = ( $_stn[$i]['end'] == "Y" ) ? $val['wle'] : "-";
			$val_fl = ( !in_array($_stn[$i]['id'], $_cfg_flow) ) ? $val['fl'] : '-';
			$val_ca = ( !in_array($_stn[$i]['id'], $_cfg_flow) ) ? $val['ca'] : '-';
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
		}

		//$bc_wle = ( $_stn[$i]['end'] == "Y" ) ? null : "bc_gray";
		$_name = ($_SESSION['leau']=='en')?$_stn[$i]['name_en']:$_stn[$i]['name'];
		echo "<TR CLASS=\"".$ef_lost."\">\n";
		echo "\t<TD CLASS=\"left nowrap\"><A HREF=\"./?page=station&id=".$_stn[$i]['id']."\">".$_stn[$i]['code']." ".$_name."</A></TD>";
		echo "<TD CLASS=\"center nowrap\" ID=\"DT".$n."\"><SPAN>".$_call->date_simple($val['date'])."</SPAN></TD>";

		echo "<TD CLASS=\"right ".$bc_rf."\" ID=\"RF_15MIN".$n."\"><SPAN>".$val['wl7']."</SPAN></TD>";
		echo "<TD CLASS=\"right ".$bc_rf."\" ID=\"RF_15MIN".$n."\"><SPAN>".$val['wl6']."</SPAN></TD>";
		echo "<TD CLASS=\"right ".$bc_rf."\" ID=\"RF_15MIN".$n."\"><SPAN>".$val['wl5']."</SPAN></TD>";
		echo "<TD CLASS=\"right ".$bc_rf."\" ID=\"RF_15MIN".$n."\"><SPAN>".$val['wl4']."</SPAN></TD>";
		echo "<TD CLASS=\"right ".$bc_rf."\" ID=\"RF_15MIN".$n."\"><SPAN>".$val['wl3']."</SPAN></TD>";
		echo "<TD CLASS=\"right ".$bc_rf."\" ID=\"RF_15MIN".$n."\"><SPAN>".$val['wl2']."</SPAN></TD>";
		echo "<TD CLASS=\"right ".$bc_rf."\" ID=\"RF_15MIN".$n."\"><SPAN>".$val['wl1']."</SPAN></TD>";

		echo "<TD CLASS=\"right ".$bc_rf."\" ID=\"RF_15MIN".$n."\"><SPAN>".$val_wl."</SPAN></TD>";
		echo "<TD CLASS=\"right ".$bc_rf."\" ID=\"RF_1H".$n."\"><SPAN>".$_stn[$i]['wl2']."</SPAN></TD>";
		echo "<TD CLASS=\"right ".$bc_rf."\" ID=\"RF_24H".$n."\"><SPAN>".($val_wl - $_stn[$i]['wl2'])."</SPAN></TD>";
	
		echo "<TD CLASS=\"right ".$bc_wl."\" ID=\"WL".$n."\"><SPAN>".$val_rf."</SPAN></TD>";
		echo "<TD CLASS=\"right ".$bc_wl."\" ID=\"WL".$n."\"><SPAN>".$val_rf_24."</SPAN></TD>";

		
		echo "<TD CLASS=\"center\">".$ic_rf."</TD>";
		echo "<TD CLASS=\"center\">".$ic_wl."</TD>\n";
		echo "</TR>\n";
		
		flush();
		ob_flush();
	}
	unset($i);
	?>
	</TBODY>
</TABLE>

