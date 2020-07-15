<?php
$conn = connDB("odbc");

if ( $_REQUEST['update'] )
{

	/*
	echo $_POST['day']."<BR>";
	echo $_POST['month']."<BR>";
	echo $_POST['year']."<BR>";
	echo $_POST['timeH']."<BR>";
	echo $_POST['timeM']."<BR>";
	*/

	// Var
	$update = date('Y-m-d H:i:s');
	$date = $_POST['date'].' '.$_POST['timeH'].':'.$_POST['timeM'].':00';
	//$date = $_POST['year'].'-'.$_POST['month'].'-'.$_POST['day'].' '.$_POST['timeH'].':'.$_POST['timeM'].':00';
	$now = 0;


	// Insert
	$sql = "INSERT INTO [PATTANI].[dbo].control_log (cl_no,cl_update,cl_date,cl_type,cl_value,c_id) VALUES";


	// Total
	$sql_total = 'SELECT SUM(c_door_water) total FROM [PATTANI].[dbo].control';
	$res_total =odbc_exec($conn,$sql_total);
	$arr_total = odbc_fetch_array($res_total);
	$total = $arr_total['total'];


	// Select
	$sql_stn = 'SELECT c_id, c_door_water FROM [PATTANI].[dbo].control ORDER BY c_id';
	$res_stn = odbc_exec($conn,$sql_stn);


	while ( $arr_stn = odbc_fetch_array($res_stn) )
	{	
		$id = $arr_stn['c_id'];
		$count = $arr_stn['c_door_water'];

		for ( $i = 1; $i <= $count; $i++ )
		{
			$door = 'd_'.$id.'_'.$i;
			$value = trim($_POST[$door]);
			$value = ( empty($value) ) ? 0 : $value;
			$now++;

			//echo $door.' == '.$_POST[$door]."<BR>";

			$sql .= " ('".$i."', '".$update."', '".$date."', 'W', '".$value."', '".$id."')";
			$sql .= ( $now == $total ) ? '' : ',';
		}
	}

	// END Insert
	
	//echo $sql ;
	$res = odbc_exec($conn,$sql);

	// Echo
	if ( $res )
	{
		echo 'Success';
	}
	else
	{
		echo 'Error';
	}

	echo '<META HTTP-EQUIV="refresh" CONTENT="1; URL=./?page=panel&view=door">';

	//@odbc_close();
}
else
{
	$sql_stn = 'SELECT * FROM [PATTANI].[dbo].control ORDER BY c_id';
	$res_stn = odbc_exec($conn,$sql_stn);

	$sql_log = 'SELECT DISTINCT cl_date FROM [PATTANI].[dbo].control_log ORDER BY cl_date DESC';
	$res_log = odbc_exec($conn,$sql_log);
?>
<DIV CLASS="title">
	<H2 CLASS="fc_pri"><?php echo $_cfg_menu_7 ?></H2>
</DIV>

<FORM METHOD="post" CLASS="topLeft">
	<H3>ตั้งค่าเวลายกบานประตู</H3>
	<TABLE CLASS="control">
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
			$sql_no = "SELECT TOP ".$arr_stn['c_door_water']." * FROM [PATTANI].[dbo].control_log WHERE c_id = '".$arr_stn['c_id']."' AND cl_type = 'W' ORDER BY cl_update DESC, cl_no";
			$res_no = odbc_exec($conn,$sql_no);

			echo "<TR>\n";
			echo "<TD CLASS=\"left\">".iconv('TIS-620', 'UTF-8', $arr_stn['c_name'])."</TD>\n";

			$n = 0;
			while ( $arr_no = odbc_fetch_array($res_no) )
			{
				$n++;

				echo "<TD><INPUT TYPE=\"text\" NAME=\"d_".$arr_stn['c_id']."_".$arr_no['cl_no']."\" VALUE=\"".$arr_no['cl_value']."\" /></TD>\n";
						
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

	<DIV CLASS="filter dc_fade">
		<TABLE>
			<TR>
				<TD>
					<LABEL CLASS="fs_small">เลือกวันที่</LABEL>
					<SPAN><INPUT TYPE="text" NAME="date" VALUE="<? echo date('Y-m-d') ?>" CLASS="tcal" /></SPAN>
				</TD>
				<TD>
					<LABEL CLASS="fs_small">เลือกช่วงเวลา</LABEL>
					<SELECT NAME="timeH" CLASS="bc_fade">
					<?php
					for ( $i = 0; $i < 24; $i++ )
					{
						$value = sprintf('%02d', $i);
						$select = ( date('H') == $value ) ? ' SELECTED' : '';
						echo '<OPTION VALUE="'.$value.'"'.$select.'>'.$value.'</OPTION>';
					}
					?>
					</SELECT>
					<SELECT name="timeM" CLASS="bc_fade">
					<?php
					for ( $i = 0; $i < 12; $i++ )
					{
						$n = $i * 5;
						$value = sprintf('%02d', $n);
						echo '<OPTION VALUE="'.$value.'">'.$value.'</OPTION>';
					}
					?>
					</SELECT>	
				</TD>
				<TD>
					<LABEL CLASS="l5 fs_small">&nbsp;</LABEL>
					<INPUT TYPE="submit" NAME="update" CLASS="button bc_sec fc_white" VALUE="บันทึกข้อมูล" />
				</TD>
			</TR>
		</TABLE>
	</DIV>

</FORM>

<DIV CLASS="topRight">
	<H3>รายการบันทึกย้อนหลัง</H3>
	<UL CLASS="history">
	<?php
	while ( $arr_log = odbc_fetch_array($res_log) )
	{
		echo "<LI><A HREF=\"".$_cfg_path_page."excels.php?date=".date('Y-m-d H:i', strtotime($arr_log['cl_date']))."\"><IMG SRC=\"../img/ic_excel.png\" WIDTH=\"32\" ALT=\"excel\" target=\"_blank\"> water_door_".date('Y_m_d', strtotime($arr_log['cl_date'])).".xls<Q CLASS=\"fs_small\">".date('Y-m-d H:i', strtotime($arr_log['cl_date']))."</Q></A></LI>\n";
	}
	?>
	</UL>
</DIV>

<?php
}
?>

<SCRIPT TYPE="text/javascript" SRC="../js/tcal/tcal.js"></script>
<SCRIPT TYPE="text/javascript">
$(document).ready
(		
	function()
	{
		var x = new Date();
		var d = x.getDate();
		var m = x.getMonth();
		var y = x.getFullYear();
		
		$('#inp_day').prop('selectedIndex',d-1);
		$('#inp_month').prop('selectedIndex',m);
		$('#inp_year').val(y);
	}
);
</SCRIPT> 