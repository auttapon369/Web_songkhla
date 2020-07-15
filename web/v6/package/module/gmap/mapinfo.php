<!DOCTYPE html >  
<head>   
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<title>PHP/MySQL & Google Maps Example</title>    
<INPUT TYPE="hidden" ID="path-img" VALUE="<?php echo $_cfg_root.$_cfg_path['img'] ?>" />
<? 
$name=$_id; 
?>
<script type="text/javascript">   
//<![CDATA[   
var nn='<?=$name?>'; 
var bounds = new google.maps.LatLngBounds();
var icon = $('#path-img').val() + 'ic_dot.png';   

function load() 
{      
	var map = new google.maps.Map(document.getElementById("map"),
	{
		center: new google.maps.LatLng(17.33733849904745,103.46965174246351),
		zoom:12,
		mapTypeId: 'roadmap'
	});
	
	var infoWindow = new google.maps.InfoWindow;      // Change this depending on the name of your PHP file    
	var url="./package/module/gmap/marks.php?name="+nn;
	downloadUrl(url, function(data) 
	{   
		var xml = data.responseXML;    
		var markers = xml.documentElement.getElementsByTagName("marker");  
		
		for (var i = 0; i < markers.length; i++) 
		{         
			var stn=markers[i].getAttribute("stn");
			var rf =markers[i].getAttribute("c_rf");
			var wl =markers[i].getAttribute("c_wl");
			var point = new google.maps.LatLng
			(    
				parseFloat(markers[i].getAttribute("lat")),       
				parseFloat(markers[i].getAttribute("lng"))
			); 
			
			bounds.extend(point);
			

			    
			
			var ic_rf = ( rf == 1 ) ? 'rf_green'+' ' : null;
			var ic_wl = ( wl == 1 ) ? 'wl_green'+' ' : null;
			var alarm = ic_rf+ic_wl+'i24';
			
				// icon
			var div_id = '<DIV CLASS="id bc_white">'+stn+'</DIV>';
			var div_color ='<DIV CLASS="icon '+alarm+' "></DIV>';

			var marker = new MarkerWithLabel
			(
				{
					map: map,
					position: point,
					icon: icon,
					labelContent: div_id + div_color /*+ alert*/,
					labelAnchor: new google.maps.Point(12, 18),
					labelClass: 'labels fs_small'
				}
			);
//			var marker = new google.maps.Marker
//			({    
//				map: map,     
//				position: point,   
//				icon: icon.icon, 
//				shadow: icon.shadow   
//			});        
			
			//bindInfoWindow(marker, map, infoWindow, html);       
		}    
		
		//map.fitBounds(bounds);
		map.setCenter(bounds.getCenter());
	});  
}   

function bindInfoWindow(marker, map, infoWindow, html) 
{    
	google.maps.event.addListener(marker, 'click', function()
	{  
		infoWindow.setContent(html);      
		infoWindow.open(map, marker);     
	});   
}  

function downloadUrl(url, callback)
{    
	var request = window.ActiveXObject ?     
	new ActiveXObject('Microsoft.XMLHTTP') : 
	new XMLHttpRequest;    
	
	request.onreadystatechange = function()
	{     
		if (request.readyState == 4)
		{       
			request.onreadystatechange = doNothing;       
			callback(request, request.status);     
		}     
	};     
	
	request.open('GET', url, true);      
	request.send(null);   
}    
function doNothing() {}    //]]> 
</script> 
</head> 
<body onload="load()">   
<div id="map" style="width:420px; height: 200px"></div>
</body>
</html>