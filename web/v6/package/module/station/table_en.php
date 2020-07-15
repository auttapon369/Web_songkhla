<TABLE WIDTH="100%" CLASS="tb_report fs_small">
	<THEAD CLASS="bc_pri dc_fade">
		<TR>
			<!--<TH ROWSPAN="2">ลำดับ</TH>-->
			<TH ROWSPAN="2">Code</TH>
			<TH ROWSPAN="2">StationName</TH>
			<TH ROWSPAN="2">Location</TH>
			<TH COLSPAN="2">Coordinates location</TH>
			<TH COLSPAN="5">Device</TH>
		</TR>
		<TR>
			<TH WIDTH="50">E</TH>
			<TH WIDTH="50">N</TH>
			<TH WIDTH="40">Rainfall</TH>
			<TH WIDTH="40">WaterLevel</TH>
			<TH WIDTH="40">Downstream</TH>
			<TH WIDTH="40">Camera</TH>
			<TH WIDTH="40">Solar cell</TH>
		</TR>
	</THEAD>
	<TBODY CLASS="dc_fade">	
	<?php 
	for ( $i = 0; $i < count($_stn); $i++ )
	{
		$n = $i + 1;
		$rf = ( $_stn[$i]['rf'] == 1 ) ? "•" : "-";
		$wl = ( $_stn[$i]['wl'] == 1 ) ? "•" : "-";
		$end = ( $_stn[$i]['end'] == "Y" ) ? "•" : "-";
		$solar = ( $_stn[$i]['solar'] == 1 ) ? "•" : "-";
		
		echo "<TR>\n";
		//echo "<TD>".$n."</TD>\n";
		echo "<TD>".$_stn[$i]['code']."</TD>\n";
		echo "<TD CLASS=\"left\">".$_stn[$i]['name_en']."</TD>\n";
		echo "<TD CLASS=\"left wrap\">".$_stn[$i]['detail_en']."</TD>\n";
		echo "<TD>".$_stn[$i]['n']."</TD>\n";
		echo "<TD>".$_stn[$i]['e']."</TD>\n";
		echo "<TD>".$rf."</TD>\n";
		echo "<TD>".$wl."</TD>\n";
		echo "<TD>".$end."</TD>\n";
		echo "<TD>".$wl."</TD>\n";
		echo "<TD>".$solar."</TD>\n";
		echo "</TR>\n";
	}
	?>
	</TBODY>
</TABLE>