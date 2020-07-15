<DIV ID="map"><?php echo $_cfg_txt_load ?></DIV>
	
<DIV ID="guide">

	<H4>ข้อมูลภูมิศาสตร์</H4>
	<UL ID="layers"></UL>
	<HR CLASS="dc_fade">

	<H4>สัญลักษณ์</H4>
	<TABLE WIDTH="100%" CLASS="fs_small">
		<TR>
			<TD CLASS="center">ปริมาณฝน</TD>
			<TD CLASS="center"><B>สถานการณ์</B></TD>
			<TD CLASS="center">ระดับน้ำ</TD>
		</TR>
		<TR>
			<TD CLASS="center"><DIV CLASS="icon rf_green"></DIV></TD>
			<TD CLASS="center">ปกติ</TD>
			<TD CLASS="center"><DIV CLASS="icon wl_green"></DIV></TD>
		</TR>
		<TR>
			<TD CLASS="center"><DIV CLASS="icon rf_yellow"></DIV></TD>
			<TD CLASS="center">เฝ้าระวัง</TD>
			<TD CLASS="center"><DIV CLASS="icon wl_yellow"></DIV></TD>
		</TR>
		<TR>
			<TD CLASS="center"><DIV CLASS="icon rf_red"></DIV></TD>
			<TD CLASS="center">เตือนภัย</TD>
			<TD CLASS="center"><DIV CLASS="icon wl_red"></DIV></TD>
		</TR>
		<TR>
			<TD CLASS="center"><DIV CLASS="icon rf_black"></DIV></TD>
			<TD CLASS="center">ขัดข้องไม่เกิน 1 ชม.</TD>
			<TD CLASS="center"><DIV CLASS="icon wl_black"></DIV></TD>
		</TR>
		<TR>
			<TD CLASS="center"><DIV CLASS="icon rf_gray"></DIV></TD>
			<TD CLASS="center">ขัดข้องไม่เกิน 3 วัน</TD>
			<TD CLASS="center"><DIV CLASS="icon wl_gray"></DIV></TD>
		</TR>
		<TR>
			<TD CLASS="center"><DIV CLASS="icon rf_white"></DIV></TD>
			<TD CLASS="center">ขัดข้องเกิน 3 วัน</TD>
			<TD CLASS="center"><DIV CLASS="icon wl_white"></DIV></TD>
		</TR>
	</TABLE>
	<HR CLASS="dc_fade">

	<H4>เหตุการณ์</H4>
	<UL>
		<LI><DIV CLASS="icon li"></DIV> AC Surge (alert)</LI>
		<LI><DIV CLASS="icon ac"></DIV> ไฟฟ้าขัดข้อง</LI>
		<LI><DIV CLASS="icon dr"></DIV> ประตูเปิด</LI>
	</UL>
	<HR CLASS="dc_fade">

	<H4>ความลึกน้ำท่วม (เมตร)</H4>
	<UL>
		<LI><DIV CLASS="icon" STYLE="background-color:#ff0000"></DIV> > 10</LI>
		<LI><DIV CLASS="icon" STYLE="background-color:#ff6600"></DIV> 9.0 - 10.0</LI>
		<LI><DIV CLASS="icon" STYLE="background-color:#ffcc00"></DIV> 8.0 - 9.0</LI>
		<LI><DIV CLASS="icon" STYLE="background-color:#ffff00"></DIV> 7.0 - 8.0</LI>
		<LI><DIV CLASS="icon" STYLE="background-color:#cbfe01"></DIV> 6.0 - 7.0</LI>
		<LI><DIV CLASS="icon" STYLE="background-color:#79ff00"></DIV> 5.0 - 6.0</LI>
		<LI><DIV CLASS="icon" STYLE="background-color:#00ff00"></DIV> 4.5 - 5.0</LI>		
		<LI><DIV CLASS="icon" STYLE="background-color:#00ff6c"></DIV> 4.0 - 4.5</LI>
		<LI><DIV CLASS="icon" STYLE="background-color:#00ffb3"></DIV> 3.5 - 4.0</LI>
		<LI><DIV CLASS="icon" STYLE="background-color:#00e6ff"></DIV> 3.0 - 3.5</LI>
		<LI><DIV CLASS="icon" STYLE="background-color:#00a6ff"></DIV> 2.5 - 3.0</LI>
		<LI><DIV CLASS="icon" STYLE="background-color:#0166fe"></DIV> 2.0 - 2.5</LI>
		<LI><DIV CLASS="icon" STYLE="background-color:#0000ff"></DIV> 1.5 - 2.0</LI>
		<LI><DIV CLASS="icon" STYLE="background-color:#5900ff"></DIV> 1.0 - 1.5</LI>
		<LI><DIV CLASS="icon" STYLE="background-color:#8080ff"></DIV> 0.3 - 1.0</LI>
		<LI><DIV CLASS="icon" STYLE="background-color:#b8e0fe"></DIV> 0.1 - 0.3</LI>
		<LI><DIV CLASS="icon" STYLE="background-color:#ffffff"></DIV> < 0.1</LI>
	</UL>
</DIV>
<INPUT TYPE="hidden" ID="path" VALUE="<?php echo $_cfg_root.$_cfg_path_page ?>" />
<INPUT TYPE="hidden" ID="path-img" VALUE="<?php echo $_cfg_root.$_cfg_path['img'] ?>" />
<LINK TYPE="text/css" REL="stylesheet" HREF="<?php echo $_cfg_root.$_cfg_path['css'] ?>map.css" />
<SCRIPT TYPE="text/javascript" SRC="http://maps.googleapis.com/maps/api/js?sensor=false&amp;language=th-TH"></SCRIPT> 
<SCRIPT TYPE="text/javascript" SRC="<?php echo $_cfg_root.$_cfg_path['js'] ?>markerwithlabel.js"></SCRIPT>
<SCRIPT TYPE="text/javascript" SRC="<?php echo $_cfg_root.$_cfg_path['js'] ?>gmap.js"></SCRIPT>
<SCRIPT TYPE="text/javascript">
$(document).ready
(		
	function()
	{	
		googleMap();
	}
);
</SCRIPT>