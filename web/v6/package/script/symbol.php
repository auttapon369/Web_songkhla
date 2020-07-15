<TABLE WIDTH="100%" CLASS="fs_small">
		<TR>
			<TH HEIGHT="24" CLASS="center"><?php echo($_SESSION['leau']=='en')?'Rainfall':'ปริมาณฝน';?></TH>
			<TH CLASS="center"><?php echo($_SESSION['leau']=='en')?'Situation':'สถานการณ์';?></TH>
			<TH CLASS="center"><?php echo($_SESSION['leau']=='en')?'Waterlevel':'ระดับน้ำ';?></TH>
		</TR>
		<TR>
			<TD CLASS="center"><DIV CLASS="icon rf_green"></DIV></TD>
			<TD CLASS="center"><?php echo($_SESSION['leau']=='en')?'Normal':'ปกติ';?></TD>
			<TD CLASS="center"><DIV CLASS="icon wl_green"></DIV></TD>
		</TR>
		<TR>
			<TD CLASS="center"><DIV CLASS="icon rf_yellow"></DIV></TD>
			<TD CLASS="center"><?php echo($_SESSION['leau']=='en')?'Warning':'เฝ้าระวัง';?></TD>
			<TD CLASS="center"><DIV CLASS="icon wl_yellow"></DIV></TD>
		</TR>
		<TR>
			<TD CLASS="center"><DIV CLASS="icon rf_red"></DIV></TD>
			<TD CLASS="center"><?php echo($_SESSION['leau']=='en')?'Danger':'วิกฤต';?></TD>
			<TD CLASS="center"><DIV CLASS="icon wl_red"></DIV></TD>
		</TR>
		<TR>
			<TD CLASS="center"><DIV CLASS="icon rf_black"></DIV></TD>
			<TD CLASS="center nowrap"><?php echo($_SESSION['leau']=='en')?'Crash Not Over 3Hour':'ขัดข้องไม่เกิน 3 ชม.';?></TD>
			<TD CLASS="center"><DIV CLASS="icon wl_black"></DIV></TD>
		</TR>
		<TR>
			<TD CLASS="center"><DIV CLASS="icon rf_gray"></DIV></TD>
			<TD CLASS="center nowrap"><?php echo($_SESSION['leau']=='en')?'Crash Not Over 3Day':'ขัดข้องไม่เกิน 3 วัน';?></TD>
			<TD CLASS="center"><DIV CLASS="icon wl_gray"></DIV></TD>
		</TR>
		<TR>
			<TD CLASS="center"><DIV CLASS="icon rf_white"></DIV></TD>
			<TD CLASS="center nowrap"><?php echo($_SESSION['leau']=='en')?'Crash Over 3Day':'ขัดข้องเกิน 3 วัน';?></TD>
			<TD CLASS="center"><DIV CLASS="icon wl_white"></DIV></TD>
		</TR>
</TABLE>