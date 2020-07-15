<?php
$value = $_call->get_values($_id);

$link = $_cfg_path['script']."crossNew.php?id=".$_id."&wl=".$value['wl']."&lv1=".$_stn[0]['wl1']."&lv2=".$_stn[0]['wl2']."&lv0=".$_stn[0]['wl0']."&lv00=".$_stn[0]['wl00']."&bm=".$_stn[0]['bm']."&zg=".$_stn[0]['zg']."&bd=".$_stn[0]['bottom']."&left=".$_stn[0]['left']."&right=".$_stn[0]['right'];

$error = $_call->TimeDiff($value['date'], date('Y-m-d H:i'));
$rf = $_call->alarmCheck($value['rf_77'], $_stn[0]['rf1'], $_stn[0]['rf2'],"0","0", $error, "txt");
$wl = $_call->alarmCheck($value['wl'], $_stn[0]['wl1'], $_stn[0]['wl2'], $_stn[0]['wl0'], $_stn[0]['wl00'], $error, "txt");

/// alarm wl
if($_SESSION['leau'] == 'en')
{
$str_wl2="Above Danger";
$str_wl1="Above Warning";
$str_wl00="Below Danger";
$str_wl0="Below Warning";
$str_rf2="Danger";
$str_rf1="Warning";
$str_wl="Normal";
$str_rf="Normal";

}else
{
$str_wl2="วิกฤตน้ำท่วม";
$str_wl1="เฝ้าระวังน้ำท่วม";
$str_wl00="วิกฤตน้ำแล้ง";
$str_wl0="เฝ้าระวังน้ำแล้ง";
$str_rf2="วิกฤตน้ำฝน";
$str_rf1="เฝ้าระวังน้ำฝน";

$str_wl="ปกติ";
$str_rf="ปกติ";
}
$wl_alarm;
			if($value['wl'] > $_stn[0]['wl2']){$wl_alarm ='<button type="button" class="btn btn-danger">'.$str_wl2.'</button>';}
			else if($value['wl'] > $_stn[0]['wl1']){$wl_alarm ='<button type="button" class="btn btn-warning">'.$str_wl1.'</button>';}
			else if($value['wl'] < $_stn[0]['wl00']){$wl_alarm ='<button type="button" class="btn btn-danger">'.$str_wl00.'</button>';}
			else if($value['wl'] < $_stn[0]['wl0']){$wl_alarm ='<button type="button" class="btn btn-warning">'.$str_wl0.'</button>';}
			else{$wl_alarm ='<button type="button" class="btn btn-success">'.$str_wl.'</button>';}
///
///
$rf_alarm;

	if($value['rf_77'] > $_stn[0]['rf2']){$rf_alarm ='<button type="button" class="btn btn-danger">'.$str_rf2.'</button>';}
			else if($value['rf_77'] > $_stn[0]['rf1']){$rf_alarm ='<button type="button" class="btn btn-warning">'.$str_rf1.'</button>';}
			else{$rf_alarm ='<button type="button" class="btn btn-success">'.$str_rf.'</button>';}

//
$camera = ( $_stn[0]['camera'] == "1" ) ? " CCTV" : ""; 
$info_tool_1 = ( $_stn[0]['wl'] == "1" ) ? "Waterlevel , Staff Gauge, ".$camera : "";
$info_tool_2 = ( $_stn[0]['rf'] == "1" ) ? "Rain, " : "";
$info_tool_3 = ( $_stn[0]['fl'] == "1" ) ? "Flow Meter" : "";
//$info_adsl = "ข้อมูลตรวจวัดทั้งหมดจะถูกส่งแบบอัตโนมัติไปยังสถานีหลักกรมชลประทาน สามเสน ผ่านเครือข่ายการสื่อสารแบบ GPRS";
$info_adsl = "";
$info_adsl .= ( $_stn[0]['adsl'] == "1" ) ? "ADSL / " : null;
$info_adsl .= ( $_stn[0]['adsl'] == "2" ) ? "Fiber Optic / " : null;
$info_adsl .= ( $_stn[0]['sim'] == "1" ) ? "Cellular" : null;
$info_adsl .= ( $_stn[0]['sim'] == "2" ) ? "SIM Card (DTAC)" : null;
$info_adsl .= ( $_stn[0]['sim'] == "3" ) ? "SIM Card (AIS & DTAC)" : null;
$info_more = ( $_stn[0]['solar'] == "1" ) ? " Solar Cell" : "-";

$img = $_cfg_path['img']."station/".$_id.".jpg";
$thumb = $_cfg_path['img']."station/thumb_".$_id.".jpg";
$cctvnone= $_cfg_path['img']."bg_logo.gif";
$cctv = new Imgs($_cfg_cctv);

if ( $_stn[0]['wl'] == 1 )
{
	if ( $_stn[0]['end'] == "Y" )
	{
		$cctv1 = $cctv->img_scan('../../img/cctv/'.$_id.'_UP/');
		$cctv2 = $cctv->img_scan('../../img/cctv/'.$_id.'_DOWN/');
	}
	else
	{
		$cctv1 = $cctv->img_scan('../../img/cctv/'.$_id.'/');
		$cctv2 = null;
	}
}




$c = $_call->get_camera($_id);

?>
<DIV class="row">
<DIV class="panel">
<DIV class="col-sm-2">
<DIV class="well">
<ul class="nav nav-pills nav-stacked">

  <?php
  $stn_list = $_call->get_stn();
 

  for ( $i = 0; $i < count($stn_list); $i++ )
	{
		$a="";
		$stn_show = ($_SESSION['leau'] == 'en')?$stn_list[$i]['name_en']:$stn_list[$i]['name'];
		if($stn_list[$i]['id']==$_GET['id'])
			$a="active";
		echo"<li role=\"presentation\" class=\"".$a."\">
		<A HREF=\"./?page=station&id=".$stn_list[$i]['id']."\">".$stn_show."</A></li>";
	}
	?>
</ul>
</DIV>
</DIV>

<DIV class="col-sm-10">

<DIV ID="station">

	<div class="row">

			 <div class="table-responsive">          
				<table class="table table-bordered">
					<thead>
					<tr>
					<th class="bg-success"><i class="glyphicon glyphicon-map-marker"></i><?php echo($_SESSION['leau']=='en')?'Telemetry Station':'สถานีโทรมาตร';?>  - <?php echo $_stn[0]['code'] ?> <?php echo ($_SESSION['leau']=='en')?$_stn[0]['name_en']:$_stn[0]['name']; ?> </th>
				   
				  </tr>
				</thead>
				<tbody>
				  <tr>
					<td>
      
						<div class="col-sm-6">
								<!-- INFO -->
								<div class="text-primary"><i class="glyphicon glyphicon-time"></i> <?php echo($_SESSION['leau']=='en')?'Update':'ข้อมูลล่าสุด';?>  : <?php echo ($_SESSION['leau']=='en')?$_call->date_en($value['date']):$_call->date_thai($value['date']); ?></div>
								<div class="table-responsive"> 
								<TABLE  CLASS="table">
									<TR>
										<TH CLASS="right bc_pri fc_white"><?php echo($_SESSION['leau']=='en')?'Station ID':'รหัส';?></TH>
										<TD CLASS="fc_pri"><?php echo $_stn[0]['code'] ?></TD>
									</TR>
									<TR>
										<TH CLASS="right bc_pri fc_white"><?php echo($_SESSION['leau']=='en')?'Station Name':'ชื่อสถานี';?></TH>
										<TD CLASS="fc_pri"><?php echo ($_SESSION['leau']=='en')?$_stn[0]['name_en']:$_stn[0]['name']; ?></TD>
									</TR>
									<TR>
										<TH CLASS="right bc_fade"><?php echo($_SESSION['leau']=='en')?'Position':'ที่ตั้ง';?></TH>
										<TD><?php echo ($_SESSION['leau']=='en')?$_stn[0]['detail_en']:$_stn[0]['detail']; ?></TD>
									</TR>
									<TR>
										<TH CLASS="right bc_fade"><?php echo($_SESSION['leau']=='en')?'UTM':'พิกัด UTM';?></TH>
										<TD><?php echo "N ".$_stn[0]['n'].", E ".$_stn[0]['e'] ?></TD>
									</TR>
									<TR>
										<TH CLASS="right bc_fade">อุปกรณ์ตรวจวัด</TH>
										<TD><?php echo $info_tool_2." ".$info_tool_1; ?></TD>
									</TR>
									<TR>
										<TH CLASS="right bc_fade"><?php echo($_SESSION['leau']=='en')?'Electrical System':'ระบบไฟฟ้า';?></TH>
										<TD><?php echo $info_more ?></TD>
									</TR>
									
									<TR>
										<TH CLASS="right bc_fade">การสื่อสาร</TH>
										<TD><?php echo $info_adsl ?></TD>
									</TR>
									<TR>
										<TH CLASS="right bc_fade">หมายเหตุ</TH>
										<TD><?php echo "-";//$info_more ?></TD>
									</TR>
								</TABLE>
								</div>
						</div>

						<div class="col-sm-6">

								<div class="row">
										<div class="col-sm-6">	
										<div class="col-sm-12">
														<div class="table-responsive">          
														<table class="table">
															<thead>
															<tr>
															<th><A HREF="<?php echo $img ?>" CLASS="fancybox"><IMG SRC="<?php echo $thumb ?>" class="img-responsive" ALT="loading..." /></A></th>
															</tr>
															<tr>
															<th class="right"><A HREF="<?php echo $img ?>" CLASS="fancybox"><i class="glyphicon glyphicon-fullscreen"></i> <?php echo($_SESSION['leau']=='en')?'Zoom':'คลิกเพื่อขยาย';?>  </A></th>
														   
														  </tr>
														</thead>
														</table>
														</div>
												</div>
										</div>
										<div class="col-sm-6">
											<div class="col-sm-12">
														<div class="table-responsive">          
														<table class="table">
															<thead >
															<tr>
															<th><?php if ( $_stn[0]['camera'] == "1" ) { ?><IMG  SRC="<?php echo$c[0];?>" class="img-responsive" ALT="loading..." /> <?php }else{?><IMG  SRC="<?php echo$cctvnone?>" class="img-responsive" ALT="loading..." /><?php } ?></th>
															<tr>
															<tr>
															<th class="right"><?php if ( $_stn[0]['camera'] == "1" ) { ?><A HREF="<?php echo$c[1];?>" target="_bank"><i class="glyphicon glyphicon-link"></i> ภาพ Real time </A><?php }else{echo($_SESSION['leau']=='en')?"NO CCTV": "ไม่ได้ติดตั้ง CCTV";} ?></th>														   
														  </tr>
														</thead>
														</table>
														</div>
												</div>

										</div>
								</div>

								<div class="row">
								<div class="col-sm-12">
								
									
								<!-- <LINK TYPE="text/css" REL="stylesheet" HREF="<?php echo $_cfg_root.$_cfg_path['css'] ?>map.css" /> -->
								<SCRIPT TYPE="text/javascript" SRC="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyBuNSO9184XWePN4z8xLXXeZ4rWc8M0sR0&language=th-TH"></SCRIPT> 
								<SCRIPT TYPE="text/javascript" SRC="<?php echo $_cfg_root.$_cfg_path['sys'] ?>map/markerwithlabel.js"></SCRIPT>
								

								<div class="table-responsive">          
														<table class="table">
															<thead>
															<tr>
															<th><?php include("./package/module/gmap/mapinfo.php");?></th>
															</tr>
															<tr>
															<th class="right"><i class="glyphicon glyphicon-map-marker"></i> <?php echo($_SESSION['leau']=='en')?'Position':'ตำแหน่งจุดติดตั้ง';?>  </th>														   
														  </tr>
														</thead>
														</table>
														</div>

								</div>
								</div>


						</div>


		
				 </td>
				</tr>
				</tbody>
				</table>
			</div>

	  </div>



	<?php if ( $_stn[0]['rf'] == "1" ) { ?>
		
	
	<div class="row">

			 <div class="table-responsive">          
				<table class="table table-bordered">
					<thead>
					<tr>
					<th class="bg-success"><i class="glyphicon glyphicon-tint"> <?php echo($_SESSION['leau'] == "en")?'Data':'ข้อมูล';?> <?php echo $_cfg_data_type['rf'][0] ?></i> <?php echo $rf_alarm;?></th>
				   
				  </tr>
				</thead>
				<tbody>
				  <tr>
					<td>
	<!-- RAIN -->

	<!-- <HR CLASS="dc_fade"> -->
	<!-- <H3>ข้อมูล<?php echo $_cfg_data_type['rf'][0] ?></H3> -->
	<DIV ID="graph" CLASS="frames">graph loading...</DIV>
	<DIV CLASS="side">
		<TABLE WIDTH="100%" CLASS="tb_info dc_fade">
			<TR>
				<TH WIDTH="80" CLASS="right bc_pri fc_white"><?php echo($_SESSION['leau']=='en')?'Rainfall Today':'ฝนวันนี้';?></TH>
				<TD CLASS="fc_pri"><?php echo $value['rf_77']." ".$_cfg_data_type['rf'][1] ?></TD>
			</TR>
			<TR>
				<TH CLASS="right bc_fade"><?php echo($_SESSION['leau']=='en')?'Rainfall Last Hour':'ฝนรายชั่วโมง';?></TH>
				<TD><?php echo $value['rf_1h']." ".$_cfg_data_type['rf'][1] ?></TD>
			</TR>		
			<TR>
				<TH CLASS="right bc_fade"><?php echo($_SESSION['leau']=='en')?'Rainfall Last 24Hour':'ฝนสะสม 24 ชม.';?></TH>
				<TD><?php echo $value['rf_24']." ".$_cfg_data_type['rf'][1] ?></TD>
			</TR>
		</TABLE>
		<BR>
		<TABLE WIDTH="100%" CLASS="tb_info dc_fade">
			<TR>
				<TH WIDTH="80" CLASS="right bc_fade fc_warn"><?php echo($_SESSION['leau']=='en')?'Warning':'เฝ้าระวัง';?></TH>
				<TD class="fc_warn"><?php echo $_stn[0]['rf1']." ".$_cfg_data_type['rf'][1] ?></TD>
			</TR>
			<TR>
				<TH CLASS="right bc_fade fc_danger"><?php echo($_SESSION['leau']=='en')?'Danger':'วิกฤต';?></TH>
				<TD Class="fc_danger"><?php echo $_stn[0]['rf2']." ".$_cfg_data_type['rf'][1] ?></TD>
			</TR>
		</TABLE>
		<BR>
		<TABLE WIDTH="100%" CLASS="tb_info dc_fade">
			<TR>
				<TH WIDTH="80" CLASS="right bc_fade"><?php echo($_SESSION['leau']=='en')?'Station Status':'สถานะสถานี';?></TH>
				<TD><?php echo $rf ?></TD>
			</TR>
			<TR>
				<TH CLASS="right bc_fade"><?php echo($_SESSION['leau']=='en')?'Last Data':'ข้อมูลวันที่';?></TH>
				<TD><?php echo $_call->date_simple($value['date'])." น."; ?></TD>
			</TR>
		</TABLE>
		<BR>
		<BUTTON ONCLICK="window.open('./?page=search');" CLASS="button bc_sec fc_white"><?php echo($_SESSION['leau']=='en')?'Search Data':'ค้นหาข้อมูลย้อนหลัง คลิกที่นี่';?></BUTTON>
	</DIV>



		 </td>
				</tr>
				</tbody>
				</table>
			</div>

	  </div>

	<?php } if ( $_stn[0]['wl'] == "1" ) { ?>

		<div class="row">

			 <div class="table-responsive">          
				<table class="table table-bordered">
					<thead>
					<tr>
					<th class="bg-success"><i class="glyphicon glyphicon-equalizer"> <?php echo($_SESSION['leau'] == "en")?'Data':'ข้อมูล';?> <?php echo $_cfg_data_type['wl'][0] ?></i> <?php echo $wl_alarm;?></th>
				   
				  </tr>
				</thead>
				<tbody>
				  <tr>
					<td>

	<!-- WATER -->
	<!-- <HR CLASS="dc_fade"> -->
	<!-- <H3>ข้อมูล<?php echo $_cfg_data_type['wl'][0] ?></H3> -->
	<IFRAME CLASS="frames" SRC="<?php if($_id == "STN07" OR $_id == "STN08"){} else{echo $link;} ?>" FRAMEBORDER="0" SCROLLING="no"></IFRAME>
	<DIV CLASS="side">
		<TABLE WIDTH="100%" CLASS="tb_info dc_fade">

			<?php if ( $_stn[0]['end'] == "Y" ) { ?>

			<TR>
				<TH CLASS="right bc_pri fc_white">ระดับเหนือน้ำ</TH>
				<TD><?php echo $value['wl']." ".$_cfg_data_type['wl'][1] ?></TD>
			</TR>
			<TR>
				<TH CLASS="right bc_pri fc_white">ระดับท้ายน้ำ</TH>
				<TD><?php echo $value['wle']." ".$_cfg_data_type['wl'][1] ?></TD>
			</TR>

			<?php } else { ?>

			<TR>
				<TH CLASS="right bc_pri fc_white"><?php echo($_SESSION['leau']=='en')?'Waterlevel':'ระดับน้ำ';?></TH>
				<TD><?php echo $value['wl']." ".$_cfg_data_type['wl'][1] ?></TD>
			</TR>

			<?php } ?>

			<?php if ( !in_array($_id, $_cfg_flow) ) { ?>

		
			
			<?php } ?>

		</TABLE>
		<BR>
		<TABLE WIDTH="100%" CLASS="tb_info dc_fade">
			<TR>
				<TH WIDTH="80" CLASS="right bc_fade"><?php echo($_SESSION['leau']=='en')?'Leftbank':'ตลิ่งซ้าย';?></TH>
				<TD><?php echo $_stn[0]['left']." ".$_cfg_data_type['wl'][1] ?></TD>
			</TR>
			<TR>
				<TH CLASS="right bc_fade"><?php echo($_SESSION['leau']=='en')?'Rightbank':'ตลิ่งขวา';?></TH>
				<TD><?php echo $_stn[0]['right']." ".$_cfg_data_type['wl'][1] ?></TD>
			</TR>
			<TR>
				<TH CLASS="right bc_fade"><?php echo($_SESSION['leau']=='en')?'Zero Gauge':'ท้องน้ำ';?></TH>
				<TD><?php echo $_stn[0]['bottom']." ".$_cfg_data_type['wl'][1] ?></TD>
			</TR>
		
		</TABLE>
		<BR>
		<TABLE WIDTH="100%" CLASS="tb_info dc_fade">
		<TR>
				<TH CLASS="right bc_fade fc_danger"><?php echo($_SESSION['leau']=='en')?'Above Danger':'วิกฤตน้ำท่วม';?></TH>
				<TD class="fc_danger"><?php echo $_stn[0]['wl2']." ".$_cfg_data_type['wl'][1] ?></TD>
			</TR>
			<TR>
				<TH WIDTH="80" CLASS="right bc_fade fc_warn"><?php echo($_SESSION['leau']=='en')?'Above Warning':'เฝ้าระวังน้ำท่วม';?></TH>
				<TD class="fc_warn"><?php echo $_stn[0]['wl1']." ".$_cfg_data_type['wl'][1] ?></TD>
			</TR>
			<TR>
				<TH WIDTH="80" CLASS="right bc_fade fc_warn"><?php echo($_SESSION['leau']=='en')?'Below Warning':'เฝ้าระวังน้ำแล้ง';?></TH>
				<TD class="fc_warn"><?php echo $_stn[0]['wl0']." ".$_cfg_data_type['wl'][1] ?></TD>
			</TR>
			<TR>
				<TH CLASS="right bc_fade fc_danger"><?php echo($_SESSION['leau']=='en')?'Below Danger':'วิกฤตน้ำแล้ง';?></TH>
				<TD class="fc_danger"><?php echo $_stn[0]['wl00']." ".$_cfg_data_type['wl'][1] ?></TD>
			</TR>
			
			
		</TABLE>
		<BR>
		<TABLE WIDTH="100%" CLASS="tb_info dc_fade">
			<TR>
				<TH WIDTH="80" CLASS="right bc_fade"><?php echo($_SESSION['leau']=='en')?'Station Status':'สถานะสถานี';?></TH>
				<TD><?php echo $wl ?></TD>
			</TR>
			<TR>
				<TH CLASS="right bc_fade"><?php echo($_SESSION['leau']=='en')?'Update':'ข้อมูลวันที่';?></TH>
				<TD><?php echo $_call->date_simple($value['date'])." น."; ?></TD>
			</TR>
		</TABLE>
		<BR>
		<!-- <A HREF="<?php echo $link ?>" data-fancybox-type="iframe" CLASS="button bc_black fc_white zoom">ขยายภาพตัดลำน้ำ คลิกที่นี่</A> -->
		<BUTTON ONCLICK="window.open('./?page=search');" CLASS="button bc_sec fc_white"><?php echo($_SESSION['leau']=='en')?'Search Data':'ค้นหาข้อมูลย้อนหลัง คลิกที่นี่';?></BUTTON>
		<BUTTON ONCLICK="window.open('./?page=cctv');" CLASS="button bc_sec fc_white"><?php echo($_SESSION['leau']=='en')?'Search CCTV':'ค้นหา CCTV ย้อนหลัง คลิกที่นี่';?></BUTTON>
	</DIV>


	<?php 
	} 
	?>


				</td>
				</tr>
				</tbody>
				</table>
			</div>

	  </div>


</DIV>

</DIV>
</DIV>
</DIV>

<INPUT TYPE="hidden" ID="inp-path" VALUE="<?php echo $_cfg_path['sys']."stats/rain-graph.php"; ?>">
<INPUT TYPE="hidden" ID="inp-date" VALUE="<?php echo $value['date'] ?>">

<LINK HREF="<?php echo $_cfg_root.$_cfg_path['script'] ?>fancybox/source/jquery.fancybox.css" REL="stylesheet" TYPE="text/css" />
<SCRIPT TYPE="text/javascript" SRC="<?php echo $_cfg_root.$_cfg_path['script'] ?>fancybox/source/jquery.fancybox.js?v=2.1.5"></SCRIPT>
<SCRIPT TYPE="text/javascript" SRC="<?php echo $_cfg_root.$_cfg_path['sys'] ?>stats/chart/highstock.js"></SCRIPT>
<SCRIPT TYPE="text/javascript" SRC="<?php echo $_cfg_root.$_cfg_path['sys'] ?>stats/chart/exporting.js"></SCRIPT>
<SCRIPT TYPE="text/javascript">
$(document).ready
(		
	function()
	{
		$('.fancybox').fancybox
		(
			{
				padding: 0,

				openEffect : 'elastic',
				openSpeed  : 150,

				closeEffect : 'elastic',
				closeSpeed  : 150,

				closeClick : true,

				helpers :
				{
					overlay : null
				}
			}
		);
		$(".zoom").fancybox
		(
			{
				maxWidth	: 1080,
				maxHeight	: 800,
				fitToView	: false,
				width			: '80%',
				height		: '80%',
				autoSize		: false,
				closeClick	: false,
				openEffect	: 'none',
				closeEffect	: 'none'
			}
		);


		if ( $('#graph').length > 0 )
		{
		

			$.post
			(
				$('#inp-path').val(),
				{
					id: location.href.split("&id=")[1],
					view: 'RF',
					format: '15MIN',
					date1: $('#inp-date').val(),
					date2: $('#inp-date').val()
				},
				function(data)
				{
						
					$('#graph').html(data);
				}
			);
		}
	}
);
</SCRIPT>