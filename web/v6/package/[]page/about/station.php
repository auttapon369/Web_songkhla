<BR>
<H3>สถานีหลัก</H3>
<UL CLASS="list-item">
	<?php
	foreach ( $_cfg_station as $key => $val )
	{
		echo "<LI CLASS=\"fc_sec\"><A HREF=\"javascript:info('main', '".$key."')\" CLASS=\"fc_black\">".$key." ".$val['name']."</A></LI>\n";
	}
	?>	
</UL>
<BR>
<H3>สถานีสนาม</H3>
<UL CLASS="list-item">
	<?php $_call->get_stn_list('info') ?>
</UL>

<DIV ID="info" CLASS="bc_fade"></DIV>
<INPUT TYPE="hidden" ID="path" VALUE="<?php echo $_cfg_path_page ?>">

<SCRIPT TYPE="text/javascript">
function info(view, target)
{
    $.post
	(
		$('#path').val()+"info.php",
		{
			id: target,
			type: view
		},
		function(data, status)
		{
			//alert("Data: " + data + "\nStatus: " + status);
			$('#info').html(data);
			$('#info').show();
		}
	);
}
$(document).ready
(
	function()
	{
		$('body').click
		(
			function()
			{
				$('#info').fadeOut();
			}
		);
	}
);
</SCRIPT>