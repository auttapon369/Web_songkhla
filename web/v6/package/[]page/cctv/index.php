<DIV CLASS="<?php echo $_cfg_css_filter ?>">
	<TABLE>
		<TR>
			<TD>
				<LABEL CLASS="<?php echo $_cfg_css_label ?>"><?php echo $_cfg_label['stn'] ?></LABEL>
				<SELECT ID="inp_stn" CLASS="<?php echo $_cfg_css_select ?>"><?php $_call->get_stn_list('option') ?></SELECT>
			</TD>
			<TD STYLE="display:none" CLASS="hide">					
				<LABEL CLASS="<?php echo $_cfg_css_label ?>"><?php echo $_cfg_label['date'] ?></LABEL>
				<INPUT ID="inp_date" TYPE="text" CLASS="tcal" VALUE="<?php echo date('Y-m-d') ?>" READONLY />
			</TD>
			<TD STYLE="display:none" CLASS="hide">
				<LABEL CLASS="<?php echo $_cfg_css_label ?>"><?php echo $_cfg_label['time'] ?></LABEL>
				<SELECT ID="inp_time" CLASS="<?php echo $_cfg_css_select ?>">
					<OPTION VALUE="600">เช้ามืด, 0:00-5:59 น.</OPTION>
					<OPTION VALUE="1800" SELECTED>กลางวัน, 6:00-17:59 น.</OPTION>
					<OPTION VALUE="2400">ค่ำมืด, 18:00-23:59 น.</OPTION>
				</SELECT>
			</TD>
			<TD>
				<LABEL>&nbsp;</LABEL>
				<BUTTON ID="search" CLASS="<?php echo $_cfg_css_btn ?>"><?php echo $_cfg_btn['search'] ?></BUTTON>
			</TD>
		</TR>
	</TABLE>
</DIV>

<DIV ID="cctv"><?php echo $_cfg_txt_load ?></DIV>

<DIV CLASS="loader"></DIV>

<INPUT TYPE="hidden" ID="path" VALUE="<?php echo $_cfg_path_page ?>cctv.php" />
<LINK HREF="<?php echo $_cfg_root.$_cfg_path['script'] ?>fancybox/source/jquery.fancybox.css" REL="stylesheet" TYPE="text/css" />
<LINK HREF="<?php echo $_cfg_root.$_cfg_path['script'] ?>tcal/tcal.css" REL="stylesheet" TYPE="text/css" />
<SCRIPT TYPE="text/javascript" SRC="<?php echo $_cfg_root.$_cfg_path['js'] ?>fancybox/source/jquery.fancybox.js?v=2.1.5"></SCRIPT>
<SCRIPT TYPE="text/javascript" SRC="<?php echo $_cfg_root.$_cfg_path['js'] ?>tcal/tcal.js"></script>
<SCRIPT TYPE="text/javascript">
function change()
{
	if ( $('#inp_stn option:selected').val() == "0" )
	{
		$('.hide').hide();
	}
	else
	{
		$('.hide').show();
	}
}

function loadCCTV()
{
	$('#cctv').html('');
	$(".loader").show();
	$.post
	(
		$('#path').val(),
		{ 
			p_time: $('#inp_time').val(),
			p_date: $('#inp_date').val(),
			p_stn: $('#inp_stn').val()
		},
		function(data)
		{
			$('#cctv').html(data);
			$('.loader').fadeOut();
		}
	);
}
$(document).ready
(		
	function()
	{	
		// default
		$("#inp_stn").prop('selectedIndex', 0);
		$('#cctv').load($('#path').val());

		// change
		$('#inp_stn').change
		(
			function()
			{	
				change();
			}
		);

		// search
		$('#search').click
		(
			function()
			{	
				loadCCTV();
			}
		);

	}
);
</SCRIPT>