<?php
$sql = "SELECT * FROM DWR_SongKhla.dbo.Stnname WHERE stn = '".$_GET['id']."' ";
$res = odbc_exec($conn,$sql);
$arr = odbc_fetch_array($res);

$_statusrf = ( $arr['show_rf'] == "1" ) ? " CHECKED" : "";
$_statuswl = ( $arr['show_wl'] == "1" ) ? " CHECKED" : "";
?>
<div class="panel panel-success">
<div class="panel-heading"><i class="glyphicon glyphicon-link"></i><a href="<?php echo$_cfg_menu_path_1."panel".$_cfg_menu_path_2."showparametor";?>">การแสดงผลค่าตรวจวัด</a> > แก้ไขค่า</div>
<div class="panel-body">
 
<FORM METHOD="post" ONSUBMIT="return confirmBox()">
	<TABLE CLASS="noborder">
		<TR>
			<TD ALIGN="right" >สถานี :</TD>
			<TD ALIGN="left"><?php echo iconv('TIS-620', 'UTF-8', $arr['st_name']);?></TD>

		</TR>
		<TR>
			<TD ALIGN="right"></TD>
			<TD ALIGN="left"><INPUT TYPE="checkbox" NAME="statusrf" VALUE="Y"<?php echo $_statusrf ?> />แสดงน้ำฝนบนเว็บไซต์</TD>

		</TR>
		<TR>
			<TD></TD>
			<TD ALIGN="left"><INPUT TYPE="checkbox" NAME="statuswl" VALUE="Y"<?php echo $_statuswl ?> />แสดงระดับน้ำบนเว็บไซต์</TD>
		</TR>
		<TR>
			<TD></TD>
			<TD ALIGN="left">
				<BR>
				<INPUT TYPE="hidden" NAME="id" VALUE="<?php echo $_GET['id'] ?>" />
				<INPUT TYPE="submit" NAME="submit" CLASS="b_blue" VALUE="แก้ไข" />
				<INPUT TYPE="button" NAME="back" CLASS="b_gray" VALUE="ย้อนกลับ" ONCLICK="location.href='<?php echo$_cfg_menu_path_1."panel".$_cfg_menu_path_2."showparametor";?>'" />
			</TD>
		</TR>
	</TABLE>
</FORM>
<?php
if ( $_SERVER['REQUEST_METHOD'] === 'POST' )
{
	
	$statusrf = ( empty($_POST['statusrf']) ) ? '0' : '1';
	$statuswl = ( empty($_POST['statuswl']) ) ? '0' : '1';

	//echo $order.'<BR>'.$name_en.'<BR>'.$name_th.'<BR>'.$unit.'<BR>'.$status.'<BR>';

	$sql_up =	"UPDATE DWR_SongKhla.dbo.Stnname ".
						"SET ".						
							"show_rf = ".$statusrf.", ".
							"show_wl = ".$statuswl." ".
						"WHERE ".
							"stn = '".$_POST['id']."' ";

	$update = odbc_exec($conn,$sql_up);
	
	if ( $update )
	{
		//echo '<SPAN CLASS="msg f_green">ดำเนินการเรียบร้อย</SPAN>';
		echo '<META HTTP-EQUIV="refresh" CONTENT="0; url='.$_cfg_menu_path_1.'panel'.$_cfg_menu_path_2.'showparametor ">';
	}
	else
	{
		echo '<SPAN CLASS="msg f_red">พบข้อผิดพลาด!! กรุณา แก้ไข ให้ถูกต้อง</SPAN>'.$sql_up;
	}
}
?>
 <SCRIPT TYPE="text/javascript">
function confirmBox()
{
	if ( confirm("คุณต้องการแก้ไขข้อมูลนี้ใช่หรือไม่?") )
	{
		return true;
	}
	else
	{
		return false;
	}
}
</script>
</div>
</div>