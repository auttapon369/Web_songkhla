<?php
session_start();
include dirname(__FILE__).DIRECTORY_SEPARATOR.'/class.SQL.php';
include dirname(__FILE__).DIRECTORY_SEPARATOR.'/class.General.php';
include dirname(__FILE__).DIRECTORY_SEPARATOR.'/class.IMG.php';
include dirname(__FILE__).DIRECTORY_SEPARATOR.'/class.Tele.php';
include dirname(__FILE__).DIRECTORY_SEPARATOR.'/class.SVG.php';
if($_SESSION['leau'] == 'en')
{
include dirname(__FILE__).DIRECTORY_SEPARATOR.'/class.SVG.New_en.php';
}
else
{
include dirname(__FILE__).DIRECTORY_SEPARATOR.'/class.SVG.New.php';
}
?>