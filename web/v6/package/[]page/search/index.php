<FORM NAME="search" METHOD="post" TARGET="_blank">
<DIV CLASS="<?php echo $_cfg_css_filter ?>">
	<LABEL CLASS="<?php echo $_cfg_css_label ?>"><?php echo $_cfg_label['stn'] ?></LABEL>
	<UL CLASS="check-list"><?php $_call->get_stn_list('check') ?></UL>
	<TABLE>
		<TR>
			<TD>
				<LABEL CLASS="<?php echo $_cfg_css_label ?>"><?php echo $_cfg_label['type'] ?></LABEL>
				<INPUT TYPE="checkbox" NAME="s_rain" VALUE="Y" CHECKED /> ปริมาณน้ำฝน
				<BR>
				<INPUT TYPE="checkbox" NAME="s_water" VALUE="Y" CHECKED /> ระดับน้ำ
				<BR>
				<INPUT TYPE="checkbox" NAME="s_flow" VALUE="Y" CHECKED /> อัตราการไหล
			</TD>
			<TD>
				<LABEL CLASS="<?php echo $_cfg_css_label ?>"><?php echo $_cfg_label['time'] ?></LABEL>
				<INPUT TYPE="text" NAME="date1" VALUE="<?php echo date('Y-m-d') ?>" CLASS="tcal" />
				<BR>
				<INPUT TYPE="text" NAME="date2" VALUE="<?php echo date('Y-m-d') ?>" CLASS="tcal" />
			</TD>
			<TD>
				<LABEL CLASS="<?php echo $_cfg_css_label ?>"><?php echo $_cfg_label['data'] ?></LABEL>
				<SELECT NAME="format" CLASS="<?php echo $_cfg_css_select ?>">
					<OPTION VALUE="f_15">ราย 15 นาที</OPTION>
					<OPTION VALUE="f_hr">รายชั่วโมง</OPTION>
					<OPTION VALUE="f_mean">รายวัน-เฉลี่ย</OPTION>
					<OPTION VALUE="f_min">รายวัน-ต่ำสุด</OPTION>
					<OPTION VALUE="f_max">รายวัน-สูงสุด</OPTION>
				</SELECT>
			</TD>
			<TD>
				<LABEL CLASS="<?php echo $_cfg_css_label ?>"><?php echo $_cfg_label['format'] ?></LABEL>
				<BUTTON ONCLICK="showData('graph')" CLASS="<?php echo $_cfg_css_btn ?>"><?php echo $_cfg_btn['graph'] ?></BUTTON>
				<BUTTON ONCLICK="showData('table')" CLASS="<?php echo $_cfg_css_btn ?>"><?php echo $_cfg_btn['table'] ?></BUTTON>
				<BUTTON ONCLICK="showData('excel')" CLASS="<?php echo $_cfg_css_btn ?>"><?php echo $_cfg_btn['excel'] ?></BUTTON>
				<BUTTON ONCLICK="showData('pdf')" CLASS="<?php echo $_cfg_css_btn ?>"><?php echo $_cfg_btn['pdf'] ?></BUTTON>
			</TD>
		</TR>
	</TABLE>
</DIV>
<INPUT TYPE="hidden" ID="path" VALUE="<?php echo $_cfg_path_page ?>search.php?view=" />
</FORM>
<LINK HREF="<?php echo $_cfg_root.$_cfg_path['script'] ?>tcal/tcal.css" REL="stylesheet" TYPE="text/css" />
<SCRIPT TYPE="text/javascript" SRC="<?php echo $_cfg_root.$_cfg_path['js'] ?>tcal/tcal.js"></script>
<SCRIPT TYPE="text/javascript">
function showData(data)
{
	var target = $('#path').val() + data;

	$('form[name=search]').attr('action', target);
	$('form[name=search]').submit();
}
</SCRIPT>