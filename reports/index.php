<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="js/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
<script language="javascript" type="text/javascript" src="Includes/datetimepicker_css.js"></script>
 <script language="javascript" type="text/javascript" src="js/jquery.fixedtableheader.min.js"></script><!-- <script src="http://code.highcharts.com/highcharts.js"></script>  -->
<script src="js/highstock.js"></script>
<script src="js/exporting.js"></script>
</head>
<body>
<br>
<?
include('config.php');

// tool bar
include("Preport.php"); 

// view
	if($_REQUEST[search])
	{
		include("Pview.php");
	}
	else
	{
		
	}
?>

</body>
</html>