<DIV CLASS="title">
	<H2 CLASS="fc_pri"><?php echo $_cfg_menu_8 ?></H2>
	<SPAN><A HREF="javascript:void()" TITLE="water1" CLASS="fc_pri">ตารางระดับน้ำ</A> | <A HREF="javascript:void()" TITLE="water2">กราฟระดับน้ำ</A> | <A HREF="javascript:void()" TITLE="map1">แผนที่เตือนภัย</A> | <A HREF="javascript:void()" TITLE="map2">แผนที่น้ำท่วม</A></SPAN>
</DIV>

<DIV CLASS="box_water1 hide">
	<H3>ตารางระดับน้ำ</H3>
	<IMG SRC="../img/weather/1.jpg" WIDTH="100%">
</DIV>

<DIV CLASS="box_water2 hide" STYLE="display:none">
	<H3>กราฟระดับน้ำ</H3>
	<IMG SRC="../img/weather/2.jpg" WIDTH="100%">
</DIV>

<DIV CLASS="box_map1 hide" STYLE="display:none">		
	<H3>แผนที่เตือนภัยน้ำท่วม</H3>
	<IMG SRC="../img/weather/3.jpg" WIDTH="100%">
</DIV>

<DIV CLASS="box_map2 hide" STYLE="display:none">		
	<H3>แผนที่น้ำท่วม</H3>
	<IMG SRC="../img/weather/4.jpg" WIDTH="100%">
</DIV>

<SCRIPT TYPE="text/javascript">
$(document).ready
(		
	function()
	{		
		$('.title a').click
		(
			function()
			{
				$('.hide').hide();
				$('.box_'+$(this).attr('title')).fadeIn();
				$('.title a').removeClass('fc_pri');
				$(this).addClass('fc_pri');
			}
		);
	}
);
</SCRIPT>