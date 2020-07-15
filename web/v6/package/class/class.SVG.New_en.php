<?php
class SVG_New
{	
	// size
	protected $width = "100%";
	protected $height = "100%";
	//protected $width = "560px";
	//protected $height = "400px";

	// axis > space
	protected $x_num = 6;						protected $y_num = 4;
	protected $x_minimum = -100;			protected $y_minimum = 5;

	// axis > point corner
	protected $x_topLeft = 15;					protected $y_topLeft = 10;
	protected $x_topRight = 85;				protected $y_topRight = 10;
	protected $x_bottomRight = 85;			protected $y_bottomRight = 80;
	protected $x_bottomLeft = 15;			protected $y_bottomLeft = 80;
	protected $x_bottomMid = 50;			protected $y_bottomMid = 50;
	protected $x_minYvalue = 50;
	
	// axis > line
	protected $line_width = 0.25;
	protected $line_min = 0.1;

	// font
	protected $font_size = "2.5";
	protected $font_min = "1.5";
	protected $font_family = "Arial, Helvetica, sans-serif";
	protected $font_anchor = "middle";

	// color
	protected $color_tran = "transparent";
	protected $color_black = "black";
	protected $color_white = "white";
	protected $color_blue = "#3cd5fe";
	protected $color_brown = "#8c5c4a";
	protected $color_yel = "yellow";
	protected $color_red = "red";

	// file
	protected $file_path = "../../data/img/cross/";
	protected $file_type = ".txt";




	// set array
	public function crossSection($id, $wl, $lv1, $lv2, $lv0, $lv00, $bm, $zg, $bd, $left, $right)
	{
		// define
		$x = $this->line("x", $id);
		$y = $this->line("y", $id);
		$wl = ( !empty($wl) ) ? $wl : 0;
		$min_x = min($x);
		$max_x = max($x);
		$v_left = $min_x - 10;
		$v_width = $max_x - $min_x + 37.5;
		$min_y = max($y) + 10;
		$max_y = min($y) - 10;
		$v_top = $max_y - 10;
		$v_height = $min_y - $max_y + 20;
		$this->x_bottomLeft = $min_x;
		$this->x_bottomRight = $max_x;
		$this->y_bottomLeft = $min_y;
		$this->y_bottomRight = $min_y;
		$this->x_bottomMid = $min_x + ($max_x - $min_x) / 2;
		$this->x_topLeft = $min_x;
		$this->x_topRight = $max_x;
		$this->y_topLeft = $max_y;
		$this->y_topRight = $max_y;
		$this->y_bottomMid = ($min_y - $max_y) / 2 + $max_y;
		$this->x_minYvalue = $x[array_keys($y,min($y),false)[0]];
		//print_r($x[array_keys($y,min($y),false)[0]]);

		// start SVG
		echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\" standalone=\"no\"?>\n";
		echo "<!DOCTYPE svg PUBLIC \"-//W3C//DTD SVG 1.1//EN\" \"http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd\">\n";
		echo "<svg id=\"svg-cross\" xmlns=\"http://www.w3.org/2000/svg\" width=\"".$this->width."\" height=\"".$this->height."\" viewBox=\"".$v_left." ".$v_top." ".$v_width." ".$v_height."\" preserveAspectRatio=\"xMidYMid\" style=\"font-family: 'Super Sans', Helvetica, sans-serif;\">\n";

		//echo "<rect x=\"".$v_left."\" y=\"".$v_top."\" width=\"".$v_width."\" height=\"".$v_height."\" style=\"fill:none;stroke-width:0.2;stroke:rgb(0,0,0)\" />";

		// water
		echo $this->water('build', $y, $wl)."\n";



		// terrain
		echo $this->terrain($x, $y)."\n";
		
		// axis X
		echo $this->axisX($x)."\n";
		
		// axis Y
		echo $this->axisY($y)."\n";

		// guide
		echo $this->guideLine($y, $lv1, $this->color_yel, 0.5, 0.5, "")."\n";
		echo $this->guideLine($y, $lv2, $this->color_red, 0.5, 0.5, "")."\n";
		echo $this->guideLine($y, $lv0, $this->color_yel, 0.5, 0.5, "")."\n";
		echo $this->guideLine($y, $lv00, $this->color_red, 0.5, 0.5, "")."\n";
		echo $this->guideLine($y, $zg, $this->color_white, 0.5, 0.5, "&#x0e17;&#x0e49;&#x0e2d;&#x0e07;&#x0e04;&#x0e25;&#x0e2d;&#x0e07;")."\n";
		echo $this->guideText($y, $left, $this->x_bottomLeft, 1, "Leftbank",$this->font_size,$this->color_black)."\n";
		echo $this->guideText($y, $right, $this->x_bottomRight, -15, "Rightbank",$this->font_size,$this->color_black)."\n";


		echo $this->guideText($y, ($lv1 - 3), $this->x_bottomRight, 1, "Above Warning".$lv1,$this->font_min,$this->color_brown/*." &#x0E21;.&#x0E23;&#x0E17;&#x0E01;."*/)."\n";
		echo $this->guideText($y, ($lv2 - 1.5 ), $this->x_bottomRight, 1, "Above Danger".$lv2,$this->font_min,$this->color_brown)."\n";
		echo $this->guideText($y, ($lv0 - 1.5), $this->x_bottomRight, 1, "Below Warning".$lv0,$this->font_min,$this->color_brown)."\n";
		echo $this->guideText($y, ($lv00 - 3), $this->x_bottomRight, 1, "Below Danger".$lv00,$this->font_min,$this->color_brown)."\n";
		
		// value
		echo $this->water('value', $y, $wl)."\n";

		// end SVG		
		echo "Sorry, your browser does not support inline SVG.\n";
		echo "</svg>";
	}




	// build terrain
	public function terrain($x_line, $y_line)
	{		
		// poly (start)
		$point =	$this->x_bottomLeft.",".$this->y_bottomLeft." ";

		for ( $i = 0; $i < count($x_line); $i++ )
		{			
			// convert
			$x = $this->limit("width", $this->x_bottomLeft, $this->x_bottomRight, $x_line[$i]);
			$y = $this->limit("height", $this->y_bottomLeft, $this->y_topLeft, $y_line[$i]);
				
			// poly default
			$point .= $x.",".$y." ";
		}
		
		// poly fake
		$point .= $this->x_bottomRight.','.( $y - 2 )." ";
		
		// poly (end)
		$point .= $this->x_bottomRight.','.$this->y_bottomRight;
		
		$temp = "<polygon points=\"".$point."\" style=\"fill: ".$this->color_brown."\" />\n";

		return $temp;
	}




	// build water
	public function water($type, $y_line, $wl)
	{
		//$y_range = $this->_range("y", $y_line);
		$min = min($y_line);
		$max = max($y_line);
		$level = $this->limit("height",$this->y_bottomLeft, $this->y_topLeft, $wl);

		if ( $type == "build" )
		{
			$point =		$this->x_bottomLeft.','.$this->y_bottomLeft.' '.
							$this->x_bottomLeft.','.$level.' '.
							$this->x_bottomRight.','.$level.' '.
							$this->x_bottomRight.','.$this->y_bottomRight;

			$temp = "<polygon points=\"".$point."\" style=\"fill: ".$this->color_blue."\" />\n";
		}
		else if ( $type == "value" )
		{
			$point =		($this->x_minYvalue - 2).','.($level - 2).' '.
							($this->x_minYvalue).','.$level.' '.
							($this->x_minYvalue + 2).','.($level - 2);

			$temp = "<polygon points=\"".$point."\" style=\"fill: ".$this->color_blue."\" />\n";
			$temp .= "<text x=\"".$this->x_minYvalue."\" y=\"".$level."\" dy=\"-3\" fill=\"".$this->color_blue."\" font-size=\"".$this->font_size."\" stroke=\"none\" text-anchor=\"".$this->font_anchor."\">".$wl."</text>\n";
		}
		else
		{
			$temp = null;
		}

		return $temp;
	}
	

	// guide line
	public function guideLine($line, $level, $color, $pad_x, $pad_y, $text)
	{
		if($level == "")
			return;
		$level = $this->limit("height",$this->y_bottomLeft, $this->y_topLeft, $level);
		
		$temp = "<line x1=\"".$this->x_bottomLeft."\" y1=\"".$level."\" x2=\"".$this->x_bottomRight."\" y2=\"".$level."\" style=\"stroke: ".$color."; stroke-width: ".$this->line_min."\" />\n";
		//$temp .= "<text x=\"".$this->x_bottomRight."\" y=\"".$level."\" dx=\"".$pad_x."\" dy=\"".$pad_y."\" font-size=\"".$this->font_min."\"  fill=\"".$this->color_blue."\" stroke=\"none\" text-anchor=\"start\">".$text."</text>\n";

		return $temp;
	}


	// guide text
	public function guideText($line, $level, $float, $pad, $text,$font_s,$color_r)
	{
		if($level == '-1.5' or $level == '-3')
			return;
		$h = $this->limit("height", $this->y_bottomLeft, $this->y_topLeft, $level);
		if($color_r=="black")
		{
			$tl=$text." ".$level;
		}
		else
		{
			$tl=$text;
		}

		$temp .= "<text x=\"".$float."\" y=\"".$h."\" dx=\"".$pad."\" dy=\"-2\" font-size=\"".$font_s."\" fill=\"".$color_r."\" stroke=\"none\" text-anchor=\"start\">".$tl."</text>\n";

		return $temp;
	}


	// limit
	private function limit($type, $min, $max, $val)
	{		
		
		if ( $type == "width" )
		{
			if ( $val < $min )
			{
				$a = $min;
			}
			else if ( $val > $max )
			{
				$a = $max;
			}
			else
			{
				$a = $val;
			}
			$v1 = ( $a - $min ) / ( $max - $min );
			$v2 = $this->x_bottomLeft + ( $v1 * ( $this->x_bottomRight - $this->x_bottomLeft ) );
		}
		else if ( $type == "height" )
		{
			if ( $val > $min )
			{
				$a = $min;
			}
			else if ( $val < $max )
			{
				$a = $max;
			}
			else
			{
				$a = $val;
			}
			$v1 = ( $a - $max ) / ( $min - $max );
			$v2 = $this->y_bottomLeft - ( $v1 * ( $this->y_bottomLeft - $this->y_topLeft ) );
		}
		else
		{
			$v2 = 0;
		}

		return $v2;
	}




	// set axis X
	private function axisX($x_line)
	{		
		// line
		$line = "<line x1=\"".$this->x_bottomLeft."\" y1=\"".$this->y_bottomLeft."\" x2=\"".$this->x_bottomRight."\" y2=\"".$this->y_bottomRight."\" style=\"stroke: ".$this->color_black."; stroke-width: ".$this->line_width."\" />\n";

		// text
		$text = "<g font-size=\"".$this->font_size."\" fill=\"".$this->color_black."\" stroke=\"none\" text-anchor=\"".$this->font_anchor."\">\n";
		
		// cal
		$min = ($this->x_bottomLeft < 0) ? ceil($this->x_bottomLeft / 10) * 10 : floor($this->x_bottomLeft / 10) * 10;
		$max = ($this->x_bottomRight < 0) ? ceil($this->x_bottomRight / 10) * 10 : floor($this->x_bottomRight / 10) * 10;
		$space = 10;
		$num = (($max - $min) / $space) + 1;

		for ( $i = 0; $i < $num; $i++ )
		{
			$x = $min + ( $i * $space );
			$y = $this->y_bottomLeft;
			$v = $min + ( $i * $space );
			
			
			$text .= "<line x1=\"".$x."\" y1=\"".$y."\" x2=\"".$x."\" y2=\"".( $y + 1 )."\" style=\"stroke: ".$this->color_black."; stroke-width: ".$this->line_width."\" />\n";
			$text .= "<text x=\"".$x."\" y=\"".$y."\" dy=\"3\">".$v."</text>\n";
		}
	
		$text .= "</g>\n";
		
		$text .= "<text font-size=\"".$this->font_size."\" fill=\"".$this->color_brown."\" stroke=\"none\" text-anchor=\"".$this->font_anchor."\" x=\"".$this->x_bottomMid."\" y=\"".$this->y_bottomLeft."\" dy=\"6\">Distance : m.</text>\n";


		return $line.$text;
	}


	// set axis Y
	private function axisY($y_line)
	{		
		// line
		$line = "<line x1=\"".$this->x_topLeft."\" y1=\"".$this->y_topLeft."\" x2=\"".$this->x_bottomLeft."\" y2=\"".$this->y_bottomLeft."\" style=\"stroke: ".$this->color_black."; stroke-width: ".$this->line_width."\" />\n";

		// text
		$text = "<g font-size=\"".$this->font_size."\" fill=\"".$this->color_black."\" stroke=\"none\" text-anchor=\"".$this->font_anchor."\">\n";
		
		// calc
		$bottom_y_axis = ($this->y_bottomLeft < 0) ? ceil($this->y_bottomLeft / 5) * 5 : floor($this->y_bottomLeft / 5) * 5;
		$top_y_axis = ($this->y_topLeft < 0) ? ceil($this->y_topLeft / 5) * 5 : ceil($this->y_topLeft / 5) * 5;
		$space = 5;
		$num = floor(($bottom_y_axis - $top_y_axis) / $space);

		//$text .= "<text x=\"".$this->x_bottomMid."\" y=\"".$this->y_bottomMid."\">".$this->y_topLeft."/".$top_y_axis."</text>\n";
		for ( $i = 0; $i <= $num; $i++ )
		{
			$x = $this->x_bottomLeft;
			$y = $this->y_bottomLeft - ($bottom_y_axis - ( $i * $space ) - $this->y_topLeft);
			$v = $bottom_y_axis - ( $i * $space );
			
			$text .= "<line x1=\"".$x."\" y1=\"".$y."\" x2=\"".( $x - 1 )."\" y2=\"".$y."\" style=\"stroke: ".$this->color_black."; stroke-width: ".$this->line_width."\" />\n";
			$text .= "<text x=\"".$x."\" y=\"".$y."\" dx=\"-3\" dy=\"1\">".$v."</text>\n";
		}
		
		$text .= "</g>\n";
		
		$text .= "<text font-size=\"".$this->font_size."\" fill=\"".$this->color_brown."\" stroke=\"none\" text-anchor=\"".$this->font_anchor."\" x=\"".$this->x_bottomLeft."\" y=\"".$this->y_bottomMid."\" dy=\"-6\" transform=\"rotate(-90,".$this->x_bottomLeft.",".$this->y_bottomMid.")\">Water Level : m.(msl)</text>\n";
		//

		return $line.$text;
	}

	// set line
	public function line($type, $id)
	{
/*
		$filename = "http://docs.google.com/spreadsheet/pub?key=0AqFan3NXBzkYdGtUbnp3V09vbFFlUWJmODd6Z09BbGc&gid=1&output=csv";
		$x = fopen($filename, "r");
		$x = fread($x, 8192);
		print_r($x);
*/

		$filename = $this->file_path.$id.$this->file_type;

		if ( file_exists($filename) )
		{
			$lines = file($filename, FILE_IGNORE_NEW_LINES);
			$x = explode(",", preg_replace('/\s+/', '', $lines[0]));
			$y = explode(",", preg_replace('/\s+/', '', $lines[1]));
		}
		else
		{
			$x = array(0, 0, 90, 90);
			$y = array(10, 10, 10, 10);
		}

		if ( $type == "x" )
		{
			return $x;
		}
		else if ( $type == "y" )
		{
			return $y;
		}
		else
		{
			return false;
		}
	}

}
?>