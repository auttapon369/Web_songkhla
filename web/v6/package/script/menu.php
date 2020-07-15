<?php
// --------------------------------------------------------------------- CONFIG

// get array menu list
$m_main = $_cfg_menu_main;			
$m_sub = $_cfg_menu_sub;

// set array menu list
$m_function = $_call;
$m_adm = $_SESSION['ses_user'];
$m_path = $_cfg_path['script'];

// set css
$m_style_ul = "navbar-nav";
$m_style_li = "nav-main";
$m_style_a = "menu";


// ---------------------------------------------------------------------- BUILD
echo "<UL class='nav navbar-nav'>\n";

foreach ( $m_main as $key => $prop )
{
	if ( ( empty($m_adm) AND $prop['display']['default'] == true ) || ( !empty($m_adm) AND $prop['display']['admin'] == true ) )
	{ 
		echo "<LI CLASS=\"".$prop['jump']['class']." ".$m_style_li.$key."\">\n";			
		echo "<A HREF=\"".$prop['link']."\" TARGET=\"".$prop['jump']['target']."\" CLASS=\"".$m_style_a."\"><span class=\"".$prop['glyphicon']."\"></span>".$prop['name']."</A>\n";
		
//		if ( $prop['expand'] == true )
//		{
//			echo "<UL CLASS=\"".$m_style_ul.$key."\" STYLE=\"display:none\">\n";
//
//			if ( !empty($prop['function']) )
//			{
//				$m_function->$prop['function']();
//			}
//			else
//			{
//				foreach ( $m_sub[$key] as $key_sub => $prop_sub )
//				{					
//					echo "<LI CLASS=\"".$prop_sub['jump']['class']."\"><A HREF=\"".$prop_sub['link']."\" TARGET=\"".$prop_sub['jump']['target']."\">".$prop_sub['name']."</A></LI>\n";
//				}
//			}
//
//			echo "</UL>\n";
//		}

		echo "</LI>\n";
	}
}

echo "</UL>\n";


// --------------------------------------------------------------------- SCRIPT
echo "<SCRIPT";
echo " SRC=\"".$m_path."menu.js\"";
echo " TYPE=\"text/javascript\"";
echo "></SCRIPT>\n";

unset($m_main);
unset($m_sub);
unset($m_function);
unset($m_adm);
unset($m_path);
unset($m_style_ul);
unset($m_style_li);
unset($m_style_a);
?>