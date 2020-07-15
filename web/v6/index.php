<?php
session_start();
ob_start();
if ( empty($_GET['page']) )
{
	header('location:./?page=map');
}

$urlStr = './?'.$_SERVER[QUERY_STRING];
if(!empty($_GET['lng']))
{
$_SESSION['leau']=$_GET['lng'];
}
if($_SESSION['leau']=='en')
{
@include('data/config_en.php');
$logo='logo_en.png';
}
else
{
@include('data/config.php');
$logo='logo.png';
}
@include($_cfg_path['class'].'index.php');
@include($_cfg_path['script'].'browser.php');

$_call = new Tele($_cfg_tb, $_cfg_conn);
$_id = ( empty($_GET['id']) ) ? null : $_GET['id'];
$_file = $_cfg_path['page']."page-".$_GET['page'].".php";
$_title = ( !empty($_GET['view']) ) ? " <SPAN CLASS=\"fs_big\">/ ".$_cfg_menu_sub[$_GET['page']][$_GET['view']]['title']."</SPAN>" : null;
$_title = $_cfg_menu_main[$_GET['page']]['title'].$_title;
$_stn = $_call->get_stn($_id);
$_refresh = '<META HTTP-EQUIV="refresh" CONTENT="2; URL=./?page='.$_GET['page'].'&view='.$_GET['view'].'">';

?>
<!doctype html>
<html lang="en">
	
	<head>

		<title><?php echo $_cfg_title ?></title>
		<meta charset="utf-8">
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
		
		<!-- css -->
		
		<LINK HREF="<?php echo $_cfg_path['img'] ?>favicon.ico" REL="shortcut icon" />
		<LINK HREF="<?php echo $_cfg_path['img'] ?>apple-touch-icon.png" REL="apple-touch-icon" />
		<!-- <LINK HREF="<?php echo $_cfg_path['css'] ?>reset.css" REL="stylesheet" TYPE="text/css" />-->
		<LINK HREF="<?php echo $_cfg_path['css'] ?>style.css?v=150202" REL="stylesheet" TYPE="text/css" /> 
	    <LINK HREF="<?php echo $_cfg_path['data'] ?>color.css" REL="stylesheet" TYPE="text/css" />
			<link href="<?php echo $_cfg_path['script'] ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" />	
		<link href="main.css" rel="stylesheet">		
		<!-- script -->
		<script src="<?php echo $_cfg_path['script'] ?>jquery-1.11.2.min.js"></script>			
		<script src="<?php echo $_cfg_path['script'] ?>bootstrap/js/bootstrap.min.js"></script>
	</head>

	<body >
		
		<DIV CLASS="container">

	
	 	<nav class="navbar navbar-default navbar-fixed-top">
			<div class="container">
					
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigationbar">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand"><img src="<?php echo $_cfg_path['img'].$logo; ?>" height="60" alt="TeleSongKhla"></a>
					</div>
					
					
					<div class="nav navbar-collapse collapse navbar-left" id="navigationbar">					
						<?php @include($_cfg_path['script'].'menu.php') ?>
						    
					</DIV> 
							<div class="nav navbar-collapse collapse navbar-right">
							<a href="<?php echo $urlStr.'&lng=th'?>"><img class="img-thumbnail bg-success" src="<?php echo $_cfg_path['img'] ?>th.png"></a>|<a href="<?php echo $urlStr.'&lng=en'?>"><img class="img-thumbnail bg-success" src="<?php echo $_cfg_path['img'] ?>en.png"></a>						
							 </div>

			</div>
		</nav> 



		
		


			<DIV CLASS="col-sm-12">
			
				<?php
				if ( !empty($_GET['page']) )
				{
					//echo $_file;
					if ( file_exists($_file) )
					{
						include($_file);
					}
					else
					{
						echo $_cfg_txt_error;
					}
				}
				?>
			</DIV>
		

		
		</DIV><!-- end container -->




	<!-- footer -->
		<DIV ID="footer" CLASS="footer">
		<?php
		for ( $i = 0; $i < count($_cfg_link); $i++ )
		{
			$s = ( $i == 0 ) ? "" : " | ";
			echo $s."<A HREF=\"".$_cfg_link[$i]['link']."\" TARGET=\"_blank\">".$_cfg_link[$i]['name']."</A>";
		}
		?>
		<SMALL><?php echo $_cfg_footer ?></SMALL>
		</DIV>

		<SCRIPT TYPE="text/javascript">
		$(document).ready
		(
			function()
			{
				if ( location.href.split("page=")[1].split("&")[0] == "map" )
				{
					$('#xml').show();
					$('#xml1').show();
				}
			}
		);
		</SCRIPT>
	</body>

</html>