<div class="row">
<DIV class="panel">
<DIV class="col-lg-5 col-centered">
<DIV class="row">
<DIV ID="map" class="col-lg-12" ><?php echo $_cfg_txt_load ?></DIV>
</DIV>

</DIV>

<div class="col-lg-1 col-centered"></div>



<DIV class="col-lg-6 col-centered">
<div class="row ">
<span class="glyphicon glyphicon-bullhorn"> <?php echo($_SESSION['leau'] == "en")?'Water Situation':'สถานการณ์น้ำ';?></span>
</div>
<div class="row table-responsive">
<?php
include($_cfg_path['sys']."stats/live.php");
?>
</div>
<div class="row">

		
			<DIV CLASS="col-sm-6 col-centered">
			<DIV class="row">
			<DIV ID="guide" >
			<H4><i class="glyphicon glyphicon-warning-sign">  <?php echo($_SESSION['leau'] == "en")?'Threshold alarms':'เกณฑ์การเตือนภัย';?></i></H4>
			<?php @include($_cfg_path['script'].'symbol.php') ?>

			</DIV>
			</DIV>
			<DIV class="row">
			<a href="http://mekhala.dwr.go.th/situation-cate.php?txtreportcate=4" target="_blank"><img src="<?php echo $_cfg_path['img'] ?>banner_report_songkla.jpg" height="60" alt="TeleSongKhla"></a>
			</DIV>
			</DIV>

			<DIV CLASS="well col-sm-6 col-centered">
					
				<?php
						$_call->data_xml("http://www.tmd.go.th/xml/weather_report.php?StationNumber=48568");
						echo($_SESSION['leau'] == "en")?'<a href="?page=forecast"><button type="button" class="btn btn-success" ><span class="glyphicon glyphicon-collapse-down"></span>more</button></a>':'<a href="?page=forecast"><button type="button" class="btn btn-success" ><span class="glyphicon glyphicon-collapse-down"></span>รายละเอียด</button></a>';
						//echo'<div id="r-more" class="collapse out">';
				
					//echo'</div>';
				?>
				
				
			</DIV>
		


</div>

</DIV>


<div class="col-sm-12">
<DIV class="row">
<DIV ID="guide" class="col-sm-6">
<H4><?php echo($_SESSION['leau'] == 'en')?'GeoData':'ข้อมูลภูมิศาสตร์';?></H4>
	<UL ID="layers"></UL>
	<HR CLASS="dc_fade">
</DIV>
<DIV ID="guide" class="col-sm-6">
<H4><?php echo($_SESSION['leau'] =='en')?'Event':'เหตุการณ์';?></H4>
	<UL>
		<!-- <LI><DIV CLASS="icon ac"></DIV> AC Surge (alert)</LI>
		<LI><DIV CLASS="icon li"></DIV> ไฟฟ้าขัดข้อง</LI> -->
		<LI><DIV CLASS="icon dr"></DIV><?php echo($_SESSION['leau'] == 'en')?'Door Status':'ประตูเปิด';?> </LI>
	</UL>
	<HR CLASS="dc_fade">
</DIV>
</DIV>
</div>
</DIV>
</DIV>

	 

	






	<?php $map=($_SESSION['leau'] == 'en')?'map/gmap_en.js':'map/gmap.js';?>	


<INPUT TYPE="hidden" ID="path" VALUE="<?php echo $_cfg_root.$_cfg_path['sys'] ?>map/" />
<INPUT TYPE="hidden" ID="path-img" VALUE="<?php echo $_cfg_root.$_cfg_path['img'] ?>" />
<INPUT TYPE="hidden" ID="path-zone" VALUE="<?php echo $_cfg_map ?>" />

 <LINK TYPE="text/css" REL="stylesheet" HREF="<?php echo $_cfg_root.$_cfg_path['css'] ?>map.css" />
 <script type='text/javascript' > var s_session = "<?php echo$_SESSION['leau'];?>"; </script>
<SCRIPT TYPE="text/javascript" SRC="https://maps.googleapis.com/maps/api/js?v=3.exp&key=**********************&language=th-TH"></SCRIPT> 
<SCRIPT TYPE="text/javascript" SRC="<?php echo $_cfg_root.$_cfg_path['sys'] ?>map/markerwithlabel.js"></SCRIPT>
<SCRIPT TYPE="text/javascript" SRC="<?php echo $_cfg_root.$_cfg_path['sys'].$map ?>"></SCRIPT>
<SCRIPT TYPE="text/javascript" SRC="<?php echo $_cfg_root.$_cfg_path['script'] ?>jquery-1.6.4.min.js"></SCRIPT>
<SCRIPT TYPE="text/javascript" SRC="<?php echo $_cfg_root.$_cfg_path['script'] ?>jquery.signalR-1.2.2.min.js"></SCRIPT>
<SCRIPT TYPE="text/javascript" SRC="http://202.129.59.96/scadahost/signalr/hubs"></SCRIPT>
<SCRIPT TYPE="text/javascript">
$(document).ready
(		
	function()
	{	
		
		googleMap();

		//$.connection.hub.logging = true;
		//Set the hubs URL for the connection
		$.connection.hub.url = "http://202.129.59.96/scadahost/signalr";

		// Declare a proxy to reference the hub.
		var hubProxy = $.connection.scadaHost;

		// Create a function that the hub can call to broadcast messages.
		hubProxy.client.addMessage = function (message)
		{
			var msg = JSON.parse(message);
			//console.log(msg);
			var id = parseInt(msg.StationID.slice(-2));
			var d = msg.TimeStamp.match(/\d+/g);
			var dt = d[2] + '/' +
				d[1] + '/' + 
				(parseInt(d[0]) + 543).toString().slice(-2) + ', ' +
				d[3] + ':' + d[4];
			$('#DT' + id).html('<SPAN>' + dt + '</SPAN>');
			//console.log($('#DT' + id).html());
			if (msg.TagName == 'rf_D00_real' || msg.TagName == 'rf_D00_log')
			{
				$('#RF_15MIN_' + id).text(parseFloat(msg.TagValue).toFixed(2));
				//console.log($('#RF_15MIN' + id).html());
			} else if (msg.TagName == 'wl_real' || msg.TagName == 'wl_log')
			{
				$('#WL_' + id).text(parseFloat(msg.TagValue).toFixed(2));
				//console.log($('#WL' + id).html());
			}
		};

		// Start the connection.
		$.connection.hub.start().done
		(
			function ()
			{
				var timestamp = '[' + new Date().toLocaleString() + '] ';
				console.log(timestamp + "join group");
				hubProxy.server.joinGroup("AllStation_RealTime");
				hubProxy.server.joinGroup("AllStation_Log");
            }
		);

		$.connection.hub.disconnected(
			function() {
				var timestamp = '[' + new Date().toLocaleString() + '] ';
				console.log(timestamp + "hub disconnected");
				setTimeout(
					function() {
						var timestamp = '[' + new Date().toLocaleString() + '] ';
						console.log(timestamp + "restart hub connection");
						$.connection.hub.start().done(
							function() {
								var timestamp = '[' + new Date().toLocaleString() + '] ';
								console.log(timestamp + "reconnect success");
								hubProxy.server.joinGroup("AllStation_RealTime");
								hubProxy.server.joinGroup("AllStation_Log");
							}
						);
					}, 30000
				); // Restart connection after 5 seconds.
			}
		);

	}
);


</SCRIPT>