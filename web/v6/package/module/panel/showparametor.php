
<div class="panel panel-success">
<div class="panel-heading"><i class="glyphicon glyphicon-link"></i><a href="<?php echo$_cfg_menu_path_1."admin";?>">สำหรับเจ้าหน้าที่</a> >การแสดงผลค่าตรวจวัด</div>
<div class="panel-body">

<TABLE class="table">
	<THEAD>
		<TR> 
			<TH>-</TH>
			
			<TH>สถานี</TH>			
			<TH>ระดับน้ำ</TH>
			<TH>น้ำฝน</TH>
		</TR>
	</THEAD>
	<TBODY>
	<?php
	for ( $i = 0; $i < count($_stn); $i++ )
	{
	
							 	
		if ( $_stn[$i]['showwl'] == "1" )
		{
			$on_webwl = '<SPAN CLASS="text-success">แสดง</SPAN>';
		}
		else
		{
			$on_webwl = '<SPAN CLASS="text-danger">ซ่อน</SPAN>';
		}
			
			if ( $_stn[$i]['showrf'] == "1" )
		{
			$on_webrf = '<SPAN CLASS="text-success">แสดง</SPAN>';
		}
		else
		{
			$on_webrf = '<SPAN CLASS="text-danger">ซ่อน</SPAN>';
		}

	?>
		<TR>
			<TD><A HREF="<?php echo$_cfg_menu_path_1."panel".$_cfg_menu_path_2."editshowparametor&id=".$_stn[$i]['code'] ?>"><i class="glyphicon glyphicon-pencil" title="แก้ไขค่า"></i></A></TD>
			
			<TD><?php echo $_stn[$i]['name']; ?></TD>
			<TD><?php echo $on_webwl; ?></TD>
			<TD><?php echo $on_webrf; ?></TD>
		</TR>
	<?php
	}
	?>
	</TBODY>
</TABLE>

</div>
</div>