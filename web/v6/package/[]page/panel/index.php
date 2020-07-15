<?php
if ( !empty($_GET['view']) )
{
	$file = $_cfg_path['page'].$_GET['page']."/".$_GET['view'].".php";
		
	if ( file_exists($file) )
	{
		include($file);
	}
	else
	{
		echo $_cfg_error_login;
	}
}
?>