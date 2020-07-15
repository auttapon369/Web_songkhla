<?php
if ( $_POST['update'] )
{
//		for ( $i=0; $i < count($_stn); $i++ )
//		{
//			$al = 0;
//			$up = array();
//
//			if ( $_POST['RF1'][$i] != $_POST['RF1_h'][$i] )
//			{
//				$up[] = "alarm_RF1 = '".$_POST['RF1'][$i]."'";
//				$al++;
//			}
//			if ( $_POST['RF2'][$i] != $_POST['RF2_h'][$i] )
//			{
//				$up[] = "alarm_RF2 = '".$_POST['RF2'][$i]."'";
//				$al++;
//			}
//			if ( $_POST['WL1'][$i] != $_POST['WL1_h'][$i] )
//			{
//				$up[] = "alarm_WL1 = '".$_POST['WL1'][$i]."'";
//				$al++;
//			}
//			if ( $_POST['WL2'][$i] != $_POST['WL2_h'][$i] )
//			{
//				$up[] = "alarm_WL2 = '".$_POST['WL2'][$i]."' ";
//				$al++;
//			}
//			if ( $_POST['WL0'][$i] != $_POST['WL0_h'][$i] )
//			{
//				$up[] = "alarm_WL0 = '".$_POST['WL0'][$i]."' ";
//				$al++;
//			}
//			if ( $_POST['WL00'][$i] != $_POST['WL00_h'][$i] )
//			{
//				$up[] = "alarm_WL00 = '".$_POST['WL00'][$i]."' ";
//				$al++;
//			}
//			
//
//			if ( $al > 0 )
//			{
//				$n = 0;
//
//				//$update .= $c." > ";
//
//				$update .= "UPDATE ".$_cfg_tb['stn']." SET ";
//				foreach ( $up as $x )
//				{
//					$update .= ( $n > 0 ) ? ", ".$x : $x;
//					$n++;
//				}
//
//				$update .= " WHERE stn = '".$_stn[$i]['id']."'";
//				//$update .= "<br>";
//			}
///*
//			else
//			{
//				$update .= "no change<br>";
//			}
//*/
//
//			unset($up);	
//		}
//
//	//echo $update;
//	$res = odbc_exec($conn,$update);
//
//	if ( $res )
//	{
//		echo $_cfg_form_success;
//	}
//	else
//	{
//		echo $_cfg_form_error;
//	}

	if($_POST['wl'] != null)
	{echo'null wl';}
	if($_POST['rf'] != null)
	{echo'null rf';}

	echo"<br>";
	echo"<br>";
	echo $_POST['stn'].$_POST['dt'].$_POST['wl'].$_POST['rf'];
	echo"<br>";
	echo $_cfg_form_success;
	
	//echo $_refresh;
}
else
{
?>
<div class="panel panel-success">
<div class="panel-heading"><i class="glyphicon glyphicon-link"></i><a href="<?php echo$_cfg_menu_path_1."admin";?>">สำหรับเจ้าหน้าที่</a> > แก้ไขค่าตรวจวัด</div>
<div class="panel-body">
<FORM METHOD="post" ONSUBMIT="return confirmation()">

	<TABLE class="table table-striped">
		
			<TR>
				<td></td>
				<td></td>
				<td> รหัสสถานี</td>
				<td>
				<select class="form-control" id="stn" name="stn">
				<option value='STN01'>คลองอู่ตะเภาตอนบน</option>
				<option value='STN02'>คลองอู่ตะเภาตอนล่าง</option>
				<option value='STN03'>คลองรัตภูมิ</option>
				<option value='STN04'>คลองตะโหมด</option>
				<option value='STN05'>คลองนาท่อม</option>
				<option value='STN06'>คลองท่าแนะ</option>
				<option value='STN07'>ปากทะเลสาบสงขลา</option>
				<option value='STN08'>ปากรอ</option>
			    <option value='STN09'>ลำปำ</option>
				<option value='STN10'>บางแก้ว</option>
				<option value='STN11'>เขาพระ</option>
				</select>
				</td>
			</TR>
			<TR>
				<td></td>
				<td></td>
				<td>วัน/เวลา </td>
				<td><input type="datetime-local" class="form-control" name="dt" id="dt">  </td>
			</TR>
			<TR>
				<td></td>
				<td></td>
				<td>ระดับน้ำ </td>
				<td><input type="text" class="form-control" name="wl" id="wl"> </td>
			</TR>
			<TR>
				<td></td>
				<td></td>
				<td>น้ำฝน </td>
				<td><input type="text" class="form-control" name="rf" id="rf"> </td>
			</TR>
			<TR>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				
			</TR>
			
		
	</TABLE>
	
	<div><INPUT TYPE="submit" ID="update" NAME="update" STYLE="height: 50px" CLASS="button bc_sec fc_white fs_big f_right" VALUE="บันทึกการแก้ไขข้อมูล" /></div>
	</FORM>

<?php
}
?>
</div>
</div>