<?php
$conn = connDB("odbc");

if ( $_POST['update_stn'] )
{

	
	for ( $i=0; $i < count($_stn); $i++ )
	{
		$c = 0;
		$up = array();

		if ( $_POST['name'][$i] != $_POST['name_h'][$i] )
		{
			//$text =$_POST['name'][$i];
			$text =iconv('UTF-8', 'TIS-620',$_POST['name'][$i]);
			$up[] = "STN_NAME_THAI = '".$text."'";
			$c++;
		}
		if ( $_POST['detail'][$i] != $_POST['detail_h'][$i] )
		{
			$up[] = "STN_DETAIL = '".$_POST['detail'][$i]."'";
			$c++;
		}
		if ( $_POST['n'][$i] != $_POST['n_h'][$i] )
		{
			$up[] = "UTM_N = '".$_POST['n'][$i]."'";
			$c++;
		}
		if ( $_POST['e'][$i] != $_POST['e_h'][$i] )
		{
			$up[] = "UTM_E = '".$_POST['e'][$i]."' ";
			$c++;
		}
		

		if ( $c > 0 )
		{
			$a = 0;

			//$update .= $c." > ";

			$update .= "UPDATE ".$_cfg_tb['stn']." SET ";
			foreach ( $up as $x )
			{
				$update .= ( $a > 0 ) ? ", ".$x : $x;
				$a++;
			}

			$update .= " WHERE STN_ID = '".$_stn[$i]['id']."'";
			//$update .= "<br>";
		}
		/*else
		{
			$update .= "no change<br>";
		}*/

		unset($up);	
	}

	//echo $update;
	$res = odbc_exec($conn,$update);

	if ( $res )
	{
		echo 'Success';
	}
	else
	{
		echo 'Error';
	}

	echo '<META HTTP-EQUIV="refresh" CONTENT="1; URL=./?page=panel&view=station">';

	//@mssql_close();
}
else
{
?>

<FORM METHOD="post">
<TABLE CLASS="">
	<THEAD CLASS="">
		<TR>
			<TH ROWSPAN="2">รหัสสถานี</TH>
			<TH ROWSPAN="2">ชื่อสถานี</TH>
			<TH ROWSPAN="2">ที่ตั้ง</TH>
			<TH COLSPAN="2">พิกัด</TH>
		</TR>
		<TR>
			<TH>N</TH>
			<TH>E</TH>
		</TR>
	</THEAD>
	<TBODY CLASS="">
	<?php
	/*for ( $i = 0; $i < $_stnNum; $i++ )
	{
		echo "<TR>\n";

		echo "<TD>".$_stn[$i]['id']."</TD>";
		echo "<TD>".$_stn[$i]['code']."</TD>";
		echo "<TD>".$_stn[$i]['name']."</TD>";
		echo "<TD>".$_stn[$i]['detail']."</TD>";

		echo "</TR>\n";
	}*/
		for ( $i = 0; $i < count($_stn); $i++ )
		{
			echo "<TR>\n";
			//echo "<TD><A HREF=\"./?sys=alarm&view=editalarm&stn=".$arr_stn['STN_ID']."\"><IMG SRC=\"../img/ic_edit.png\" WIDTH=\"16\" ALT=\"แก้ไข\"></A></TD>\n"; 

			echo "<TD >".$_stn[$i]['code']."</TD>\n";
			echo "<TD><INPUT TYPE=\"text\" NAME=\"name[]\" VALUE=\"".$_stn[$i]['name']."\" /><INPUT TYPE=\"hidden\" NAME=\"name_h[]\" VALUE=\"".$_stn[$i]['name']."\" /></TD>\n";
			
			echo "<TD><INPUT TYPE=\"text\" NAME=\"detail[]\" VALUE=\"".$_stn[$i]['detail']."\" /><INPUT TYPE=\"hidden\" NAME=\"detail_h[]\" VALUE=\"".$_stn[$i]['detail']."\" /></TD>\n";

			echo "<TD><INPUT TYPE=\"text\" NAME=\"n[]\" VALUE=\"".$_stn[$i]['n']."\" /><INPUT TYPE=\"hidden\" NAME=\"n_h[]\" VALUE=\"".$_stn[$i]['n']."\" /></TD>\n";
			echo "<TD><INPUT TYPE=\"text\" NAME=\"e[]\" VALUE=\"".$_stn[$i]['e']."\" /><INPUT TYPE=\"hidden\" NAME=\"e_h[]\" VALUE=\"".$_stn[$i]['e']."\" /></TD>\n";			

			echo "</TR>\n";
		}
		?>
	</TBODY>
</TABLE>

<DIV CLASS="filter dc_fade">
	<INPUT TYPE="submit" NAME="update_stn" CLASS="button bc_sec fc_white" VALUE="บันทึกข้อมูล" />		
</DIV>
</FORM>
<?php
}
/*
	'id'				=>	$res[$i]['STN_ID'],
	'code'			=>	$res[$i]['STN_CODE'],
	'name'		=>	$this->convTH($res[$i]['STN_NAME_THAI']),
	'detail'		=>	$this->convTH($res[$i]['STN_DETAIL']),
	'end'			=>	$res[$i]['stn_front_end'],
	'n'				=>	$res[$i]['UTM_N'],
	'e'				=>	$res[$i]['UTM_E'],
	'adsl'			=>	$res[$i]['ADSL'],
	'sim'			=>	$res[$i]['SIM'],
	'solar'			=>	$res[$i]['Solar_cell'],
	'rf'				=>	$res[$i]['Check_rf'],
	'wl'				=>	$res[$i]['Check_wl'],
	'fl'				=>	$res[$i]['Check_fl'],
	'rf1'			=>	$res[$i]['alarm_RF1'],
	'rf2'			=>	$res[$i]['alarm_RF2'],
	'wl1'			=>	$res[$i]['alarm_WL1'],
	'wl2'			=>	$res[$i]['alarm_WL2'],
	'bm'			=>	$res[$i]['cross_bm'],
	'zg'			=>	$res[$i]['cross_zg'],
	'bottom'		=>	$res[$i]['cross_bottom'],
	'left'			=>	$res[$i]['cross_left'],
	'right'			=>	$res[$i]['cross_right']
*/
?>