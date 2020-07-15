<?php
//if($_GET['q'] != 'data')
//{
$dom = new DOMDocument('1.0', 'UTF-8');

// Creates the root KML element and appends it to the root document.
$node = $dom->createElementNS('http://earth.google.com/kml/2.1', 'kml');
$parNode = $dom->appendChild($node);

// Creates a KML Document element and append it to the KML element.
$dnode = $dom->createElement('Folder');
$docNode = $parNode->appendChild($dnode);

// Creates the two Style elements, one for restaurant and one for bar, and append the elements to the Document element.
	$restStyleNode = $dom->createElement('name','Floodmap1hr');//name
	$docNode->appendChild($restStyleNode);
	$restIconstyleNode = $dom->createElement('description','2014-11-18 16:38:34');//description
	$docNode->appendChild($restIconstyleNode);

	$restGroundOverlay=$dom->createElement('GroundOverlay');//GroundOverlay

		$restname= $dom->createElement('name','2014-11-15-07-00');
		$restGroundOverlay->appendChild($restname);
		$restdest= $dom->createElement('description','2014-11-15-07-00');
		$restGroundOverlay->appendChild($restdest);

		$restIconNode = $dom->createElement('Icon');
			$restHref = $dom->createElement('href', 'http://telekolok.com/web/v5/data/img/map/floodmap/Floodmap1hr 2014-11-15-07-00.png');
			$restIconNode->appendChild($restHref);
		$restGroundOverlay->appendChild($restIconNode);

		$restlatlonbox=$dom->createElement('LatLonBox');

			$restn=$dom->createElement('north','6.303.93');
			$restlatlonbox->appendChild($restn);
			$rests=$dom->createElement('south','5.673489');
			$restlatlonbox->appendChild($rests);
			$reste=$dom->createElement('east','102.235555');
			$restlatlonbox->appendChild($reste);
			$restw=$dom->createElement('west','101.631604');
			$restlatlonbox->appendChild($restw);

		$restGroundOverlay->appendChild($restlatlonbox);

	$docNode->appendChild($restGroundOverlay);


$kmlOutput = $dom->saveXML();
header('Content-type: application/vnd.google-earth.kml+xml');
header('Content-Disposition: attachment; filename="floodmap.kml"');
echo $kmlOutput;

//}
	

					$files = scandir("../../../data/img/map/floodmap");
					$i=0;
					while($i<=count($files))
					{
						$extension = pathinfo($files[$i], PATHINFO_EXTENSION);
							if ($extension == 'png') {
								
						echo'<option value="'.$i.'">'.explode_name($files[$i]).'</option>';
							}
						$i++;
					}	
					
	

function explode_name($file)
{
	$name1=explode('.',$file);
	$name2=explode(' ',$name1[0]);
	return $name2[1];
}


?>