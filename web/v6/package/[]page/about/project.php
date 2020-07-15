<?php
for ( $i = 0; $i < count($_cfg_about); $i++ )
{
	// IMG
	if ( !empty($_cfg_about[$i]['img']) )
	{
		echo "<IMG SRC=\"".$_cfg_root.$_cfg_path['img'].$_cfg_about[$i]['img']."\" WIDTH=\"100%\" />";
		echo "<BR>";
	}

	// TITLE
	echo "<BR>";
	echo "<H3>".$_cfg_about[$i]['title']."</H3>\n";
	
	// CONTENT
	if ( !empty($_cfg_about[$i]['content']) )
	{
		for ( $ia = 0; $ia < count($_cfg_about[$i]['content']); $ia++ )
		{
			echo "<P>".$_cfg_about[$i]['content'][$ia]."</P>\n";
		}
	}

	// LIST
	if ( !empty($_cfg_about[$i]['list']) )
	{
		echo "<UL CLASS=\"list-num\">\n";

		for ( $ib = 0; $ib < count($_cfg_about[$i]['list']); $ib++ )
		{
			echo "<LI>".$_cfg_about[$i]['list'][$ib]."</LI>\n";
		}

		echo "</UL>\n";
	}

	// FILE
	if ( !empty($_cfg_about[$i]['file']) )
	{
		if ( file_exists($_cfg_path_page.$_cfg_about[$i]['file']) )
		{
			include($_cfg_path_page.$_cfg_about[$i]['file']);
		}
		else
		{
			echo $_cfg_txt_error;
		}
	}

	echo "<BR>";
}

unset($i);
unset($ia);
unset($ib);
?>