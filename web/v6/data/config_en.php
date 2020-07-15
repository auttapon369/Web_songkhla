<?php
/* --------------------------------------------------------------------------------------- #PATH */
//$_cfg_domain = "192.168.111.25/telesongkhla";
$_cfg_domain = "202.129.59.96";
$_cfg_root = "http://".$_cfg_domain."/web/v6/";

$_cfg_ws_ip = "ws://".$_cfg_domain.":8200";

$_cfg_path = array
(
	"class"			=> $_cfg_path_root."package/class/",
	"css"				=> $_cfg_path_root."package/css/",
	"script"			=> $_cfg_path_root."package/script/",
	"page"			=> $_cfg_path_root."package/template/",
	"sys"				=> $_cfg_path_root."package/module/",
	"data"			=> $_cfg_path_root."data/",
	"img"				=> $_cfg_path_root."data/img/",
	"temp"			=> $_cfg_path_root."data/temp/",
	"download"		=> $_cfg_path_root."data/download/"
);

$_cfg_today = date('Y-m-d H:')."00";
$_cfg_day = date('Y-m-d');
$_cfg_time = date('H').":00";
$_d = explode('-', str_replace(' ', '-', $_cfg_today));
//$_t = explode(':', $_d[3]);
$_now = $_cfg_path['temp'].$_d[0]."/".(int)$_d[1]."/".(int)$_d[2]."/";
$_fixed = $_cfg_path['temp'];
//$_cfg_path_today = ( is_dir($_now) && count(scandir($_now)) > 2 ) ? $_now : $_fixed;
//$_cfg_path_root = "";
$dir1 = $_cfg_path['temp'];
$dir2 = $dir1.scan_auto($dir1)."/";
$dir3 = $dir2.scan_auto($dir2)."/";
$dir4 = $dir3.scan_auto($dir3)."/";
$_cfg_path_today = $dir4;
$_cfg_path_root = "";

function scan_auto($dir)
{
	if (is_dir($dir))
	{
  		if ($dh=opendir($dir))
		{
			$r = array();
    		while (($file = readdir($dh)) !== false)
			{
				if (is_numeric($file))
				{
     	 			array_push($r, $file);
				}
    		}
    		closedir($dh);
			return max($r);	
  		}
	}

	return false;
}


/* ------------------------------------------------------------------------------------ #CONNECT */
$_cfg_conn = array
(
	'host'		=> '192.168.191.232',
	'user'		=> 'sa',
	'pass'		=> 'ata+ee&c',
	'db'		=> 'DWR_SongKhla',
	'sql'		=> 'odbc'
);
$_cfg_tb = array
(
	'stn'				=> "[".$_cfg_conn['db']."].[dbo].[Stnname]",
	'daily'				=> "[".$_cfg_conn['db']."].[dbo].[val]",
	'dailytime'		=> "[".$_cfg_conn['db']."].[dbo].[valtime]",
	'backup'			=> "[".$_cfg_conn['db']."].[dbo].[DATA_Backup]",
	'q'					=> "[".$_cfg_conn['db']."].[dbo].[WL2Q]",
	'user'				=> "[".$_cfg_conn['db']."].[dbo].[TBuser]",
	'door'				=> "[".$_cfg_conn['db']."].[dbo].[control]",
	'door_details'	=> "[".$_cfg_conn['db']."].[dbo].[control_log]"
);
$_cfg_cctv = array
(
	'ip'			=> $_cfg_domain,
	'user'		=> 'ftp_cctv',
	'pass'		=> 'dwrwoc',
	'path'		=> '/cctv'
);
$_cfg_map = "7.2 100.3 9";
$_cfg_spot = "http://192.168.103.13/SpotlightService/Switch/";


global $_cfg_conn;

function connDB( $sql = null )
{
	global $_cfg_conn;

	$mode = ( empty($sql) ) ? $_cfg_conn['sql'] : $sql;

	if ( $mode == "odbc" )
	{
		$hosting = "Driver={SQL Server}; Server=$_cfg_conn[host]; Database=$_cfg_conn[db]";
		$conn = odbc_connect($hosting, $_cfg_conn['user'], $_cfg_conn['pass']);
	}
	else if ( $mode == "ms" )
	{
		$conn = mssql_connect($_cfg_conn['host'], $_cfg_conn['user'], $_cfg_conn['pass']);
	}
	else
	{
		$conn = false;
	}

	return $conn;
}


/* ------------------------------------------------------------------------------------ #CONTENT */
$_cfg_name = "ทะเลสาบสงขลา";

$_cfg_key = "โครงการโทรมาตร, โทรมาตร, ลุ่มน้ำ".$_cfg_name.", ".$_cfg_name.", สถานการณ์น้ำ";

$_cfg_desc = "โครงการตรวจวัดสภาพน้ำทางไกลอัตโนมัติลุ่มน้ำ".$_cfg_name;

$_cfg_title = "Songkhla Basin | Telemetering System";

$_cfg_footer = "Department of Water Resources (Floor 11) Soi 34 180/3 Phibun Watthana 13 Alley, Samsen Nai, Bangkok 10400";
//$_cfg_footer .= "<BR><font color=red>* ระบบอยู่ในช่วงทดสอบและปรับแต่ง ข้อมูลยังไม่สามารถนำไปใช้ในการอ้างอิงได้</font>";

$_cfg_report_head = "ข้อมูลการตรวจวัดจากระบบโทรมาตร";

$_cfg_txt_load = "Loading...";
$_cfg_txt_error = "<BR>---- ไม่พบข้อมูล ----";

$_cfg_form_success = "<BR>บันทึกข้อมูลเรียบร้อยค่ะ, กำลังเปลี่ยนหน้า...";
$_cfg_form_error = "<BR>ไม่สามารถบันทึกข้อมูลได้, กำลังเปลี่ยนหน้า...";


/* ------------------------------------------------------------------- #MENU */
$_cfg_menu_path_1 = "./?page=";
$_cfg_menu_path_2 = "&view=";
$_cfg_menu_main = array
(
	'map' => array
	(
		'name'		=> "Home",
		'title'			=> "Home",
		'expand'		=> false,
		'function'		=> null,
		'glyphicon'  =>"glyphicon glyphicon-home",
		'link'			=> $_cfg_menu_path_1."map",
		'jump'			=> array('class'=>null, 'target'=>null),
		'display'		=> array('default'=>true, 'admin'=>true)
	),
	'station' => array
	(
		'name'		=> "Telemetry Station",
		'title'			=> "Telemetry Station",
		'expand'		=> false,
		'function'		=> "null",
		'glyphicon'  => "glyphicon glyphicon-map-marker",
		'link'			=> $_cfg_menu_path_1."station&id=STN01",
		'jump'			=> array('class'=>"null", 'target'=>null),
		'display'		=> array('default'=>true, 'admin'=>true)
	),
	'about' => array
	(
		'name'		=> "Project Infomation",
		'title'			=> "Project Infomation",
		'expand'		=> false,
		'function'		=> null,
		'glyphicon'  =>"glyphicon glyphicon-info-sign",
		//'link'			=> "javascript:expand('about')",
		'link'			=> $_cfg_menu_path_1."about&view=project",
		'jump'			=> array('class'=>"null", 'target'=>null),
		'display'		=> array('default'=>true, 'admin'=>true)
	),
	'report' => array
	(
		'name'		=> "Report",
		'title'			=> "Report",
		'expand'		=> false,
		'function'		=> null,
		'glyphicon'  =>"glyphicon glyphicon-file",
		'link'			=> $_cfg_menu_path_1."report".$_cfg_menu_path_2."now",
		'jump'			=> array('class'=>"new", 'target'=>null),
		'display'		=> array('default'=>true, 'admin'=>true)
	),
	'cctv' => array
	(
		'name'		=> 'CCTV',
		'title'			=> 'CCTV',
		'expand'		=> false,
		'function'		=> null,
		'glyphicon'  =>"glyphicon glyphicon-facetime-video",
		'link'			=> $_cfg_menu_path_1."cctv",
		'jump'			=> array('class'=>null, 'target'=>null),
		'display'		=> array('default'=>true, 'admin'=>true)
	),
	'service' => array
	(
		'name'		=> 'Web Service',
		'title'			=> 'Web Service',
		'expand'		=> false,
		'function'		=> null,
		'glyphicon'  =>"glyphicon glyphicon-link",
		'link'			=> $_cfg_menu_path_1."service",
		'jump'			=> array('class'=>null, 'target'=>null),
		'display'		=> array('default'=>true, 'admin'=>true)
	),
	'admin' => array
	(
		'name'		=> "SystemAdmin",
		'title'			=> "SystemAdmin",
		'expand'		=> true,
		'function'		=> null,
		'glyphicon'  =>"glyphicon glyphicon-list-alt",
		'link'			=> $_cfg_menu_path_1."admin",
		'jump'			=> array('class'=>"expand", 'target'=>null),
		'display'		=> array('default'=>false, 'admin'=>true)
	),
	'logout' => array
	(
		'name'		=> "Logout",
		'title'			=> "Logout",
		'expand'		=> false,
		'function'		=> null,
		'glyphicon'  =>"glyphicon glyphicon-list-alt",
		'link'			=> $_cfg_menu_path_1."login&sign=out",
		'jump'			=> array('class'=>null, 'target'=>null),
		'display'		=> array('default'=>false, 'admin'=>true)
	),
	'login' => array
	(
		'name'		=> "Login",
		'title'			=> "Login",
		'expand'		=> false,
		'function'		=> null,
		'glyphicon'  =>"glyphicon glyphicon-user",
		'link'			=> $_cfg_menu_path_1."login",
		'jump'			=> array('class'=>null, 'target'=>null),
		'display'		=> array('default'=>true, 'admin'=>false)
	)
);

$_cfg_menu_sub = array
(
	'about' => array
	(
		'project' => array
		(
			'name'	=> 'ความเป็นมาของโครงการ',
			'title'		=> 'ความเป็นมาของโครงการ',
			'link'		=> $_cfg_menu_path_1."about".$_cfg_menu_path_2."project",
			'jump'		=> array('class'=>null, 'target'=>null)
		),
		'station' => array
		(
			'name'	=> 'รายละเอียดสถานีโทรมาตร',
			'title'		=> 'รายละเอียดสถานีโทรมาตร',
			'link'		=> $_cfg_menu_path_1."about".$_cfg_menu_path_2."station",
			'jump'		=> array('class'=>null, 'target'=>null)
		)
	),
	'report' => array
	(
		'now' => array
		(
			'name'	=> 'รายงานสรุปข้อมูลปัจจุบัน',
			'title'		=> 'รายงานสรุปข้อมูลปัจจุบัน',
			'link'		=> $_cfg_menu_path_1."report".$_cfg_menu_path_2."now",
			'jump'		=> array('class'=>null, 'target'=>null)
		),

	),
	'panel' => array
	(
		'station' => array
		(
			'name'	=> 'แก้ไขข้อมูลสถานี',
			'title'		=> 'ข้อมูลสถานีโทรมาตร',
			'link'		=> $_cfg_menu_path_1."panel".$_cfg_menu_path_2."station",
			'jump'		=> array('class'=>null, 'target'=>null)
		),
		'alarm' => array
		(
			'name'	=> 'แก้ไขค่าระดับเตือนภัย',
			'title'		=> 'ตั้งค่าระดับเตือนภัยลุ่มน้ำ',
			'link'		=> $_cfg_menu_path_1."panel".$_cfg_menu_path_2."alarm",
			'jump'		=> array('class'=>null, 'target'=>null)
		),
		'door' => array
		(
			'name'	=> 'ข้อมูลระยะยกบาน',
			'title'		=> 'การเก็บบันทึกข้อมูลระยะยกบาน (ปตร./ ทรบ.)',
			'link'		=> $_cfg_menu_path_1."panel".$_cfg_menu_path_2."door",
			'jump'		=> array('class'=>null, 'target'=>null)
		),
		'spot' => array
		(
			'name'	=> 'ตั้งค่าอุปกรณ์',
			'title'		=> 'การตั้งค่าอุปกรณ์',
			'link'		=> $_cfg_menu_path_1."panel".$_cfg_menu_path_2."spot",
			'jump'		=> array('class'=>null, 'target'=>null)
		)
	)
);


/* ---------------------------------------------------------------- DATATYPE */
$_cfg_data_type = array
(
	'rf' => array("Rainfall", "mm./Day"),
	'wl' => array("Waterlevel", "m.(MSL)"),
	'fl' => array("อัตราการไหล", "ลบ.ม./วินาที"),
	'ca' => array("ความจุลำน้ำ", "%"),
	'rf24' => array("Rain24H","mm.")

);


/* ------------------------------------------------------------------ #LABEL */
$_cfg_label = array
(
	"stn"				=> "สถานี",
	"date"			=> "วันที่",
	"time"			=> "ช่วงเวลา",
	"type"			=> "ประเภท",
	"data"			=> "ข้อมูล",
	"format"			=> "รูปแบบ",
	"download"		=> "ดาวโหลด"
);


/* ----------------------------------------------------------------- #BUTTON */
$_cfg_btn = array
(
	"login"		=> "Sing In",
	"search"		=> "ค้นหา",
	"graph"		=> "แสดงกราฟ",
	"table"		=> "แสดงตาราง",
	"excel"		=> "Excel",
	"pdf"			=> "PDF"
);


/* ----------------------------------------------------------------- #SELECT */
$_cfg_select = array
(
	"time" => array
	(
		array(600, "เช้ามืด, 0:00-5:59 น.", ""),
		array(1900, "กลางวัน, 6:00-18:59 น.", "SELECTED"),
		array(2400, "กลางคืน, 19:00-23:59 น.", "")
	),
	"report" => array
	(
		array("f_15", "ราย 15 นาที", ""),
		array("f_hr", "รายชั่วโมง", ""),
		array("f_mean", "รายวัน-เฉลี่ย", ""),
		array("f_min", "รายวัน-ต่ำสุด", ""),
		array("f_max", "รายวัน-สูงสุด", "")
	)
);


/* ---------------------------------------------------------------- #STATION */
$_cfg_station = array
(
	'MS' => array
	(
		'name'		=> 'สถานีหลัก กรมทรัพยากรน้ำ (ชั้น 11)',
		'address'		=> 'ศูนย์ควบคุมระบบโทรมาตร ชั้น 11 ',
		'utm'			=> '663,840E 1,524,614N',
		'tool'			=> 'เครื่องแม่ข่าย 4 ชุด (SCADA Server, Flood Forecast Sever, Database Sever, Internet/Web Sever) เครื่องเวิร์คสเตชั่น 3 ชุด (SCADA View, FLOOD FORECAST View, Internet Sever) และอุปกรณ์บริวาร',
		'adsl'			=> 'ควบคุมการทำงานของสถานีโทรมาตรสนามและรับข้อมูลตรวจวัดจากสถานีโทรมาตรสนามผ่าน GPRS สำหรับเชื่อมโยงกับสถานีหลักย่อยใช้ ADSL Modem'
	)
	//,
//	'SMS1' => array
//	(
//		'name'		=> 'สถานีหลักย่อย ศูนย์อุทกวิทยาและบริหารน้ำภาคใต้ จ.พัทลุง',
//		'address'		=> 'ศูนย์อุทกวิทยาและบริหารน้ำภาคใต้ โครงการชลประทานพัทลุง ถนนราเมศวร์ ต.คูหาสวรรค์ อ.เมือง จ.พัทลุง',
//		'utm'			=> '617,330E 841,076N',
//		'tool'			=> "เครื่องเวิร์คสเตชั่น 1 ชุด (SCADA View)",
//		'adsl'			=> "เชื่อมโยงกับสถานีหลัก ใช้ ADSL Modem"
//	),
//	'SMS2' => array
//	(
//		'name'		=> 'สถานีหลักย่อย สำนักชลประทานที่ 17',
//		'address'		=> 'ศูนย์ประมวลวิเคราะห์สถานการณ์น้ำ โครงการชลประทานนราธิวาส เลขที่ 3/1 หมู่ที่ 3 ตำบลกะลุวอเหนือ อำเภอเมือง จังหวัดนราธิวาส ',
//		'utm'			=> "6°24'36.2\"N 101°50'05.4\"E",
//		'tool'			=> "เครื่องเวิร์คสเตชั่น 1 ชุด (SCADA View) และอุปกรณ์บริวาร",
//		'adsl'			=> "เชื่อมโยงกับสถานีหลัก ใช้ ADSL Modem"
//	),
//	'SMS3' => array
//	(
//		'name'		=> "สถานีหลักย่อย เขื่อนปัตตานี",
//		'address'		=> "ศูนย์อุทกวิทยาและบริหารน้ำภาคใต้ โครงการชลประทานปัตตานี 198 หมู่ 4 ต.บางเขา อ.หนองจิก จ.ปัตตานี",
//		'utm'			=> "6.677256 101.286747",
//		'tool'			=> "เครื่องเวิร์คสเตชั่น 1 ชุด (SCADA View)",
//		'adsl'			=> "เชื่อมโยงกับสถานีหลัก ใช้ ADSL Modem"
//	),
//	'SMS4' => array
//	(
//		'name'		=> "สถานีหลักย่อย ยะลา",
//		'address'		=> "ศูนย์อุทกวิทยาและบริหารน้ำภาคใต้ โครงการชลประทานยะลา เลขที่ 38 ถนนสิโรรส ต.สะเตง อ.เมือง จ.ยะลา",
//		'utm'			=> "6.536885, 101.261502",
//		'tool'			=> "เครื่องเวิร์คสเตชั่น 1 ชุด (SCADA View)",
//		'adsl'			=> "เชื่อมโยงกับสถานีหลัก ใช้ ADSL Modem"
//	),

);


/* ------------------------------------------------------------------ #ABOUT */
$_cfg_about = array
(
	array
	(
		'title'			=>	'Project Source',
		'content'		=>	array
								(
									"Automatic water measurement distance. It is a tool for managing water resources effectively, the system will detect data Meteorology - Hydrology is more rainfall, water level and water quality in monitoring water automatically at set intervals (Time. Mode system) and / or the status designated (event Mode system) and storage in the data provided (Real Time data collection) immediately so they can be related. Data were analyzed and predicted the situation in a timely manner",
									
									"For Songkhla Lake Basin Department of Water Resources The installation of an automatic water level monitoring system has been implemented. (Call system) 11 stations from the fiscal year 2010, the system has been in continuous use for many years. Enables electronic devices with limited lifetime. Therefore, to provide automatic long-distance monitoring of the Songkhla Lake, 11 stations, as well as main stations. It can measure, transmit, analyze and analyze rainfall data, water level and water quality to accurately predict water situation. Department of Water Resources Therefore, it is the intention to hire repair work to improve the automatic long-distance monitoring system. In Songkhla Lake Basin",
									"By repairing the automatic long-distance monitoring system. In Songkhla Lake Basin It operates in two main components of the system"

								),
		'list'			=>	array
								(
									'1) The main station is equipped with hardware and software of the remote control (Scada), database systems, website systems and other components',

									'2) 11 field stations are equipped with measuring instruments. Data transmission device And related equipment'
																	),
		'file'			=>	null,
		'img'			=>	'pic_about_1.jpg'
	),
	array
	(
		'title'			=>	'Objective',
		'content'		=>	array
								(
									'Department of Water Resources There are plans to carry out repair work to improve automatic water level monitoring system. In Songkhla Lake Basin To call Songkhla lake system. Be available at all times. The main objectives of the project are as follows'
								),
		'list'			=>	array
								(
									'2.1 To repair or replace defective equipment in the field station. As well as calibrating and calibrating the device, the data can be accurately measured and met the standard of use',

									'2.2 To repair the data transmission system. Database system and website system to be up-to-date and effective',
									'2.3 To repair or replace defective hardware and software in the server of the remote water level monitoring system. Songkhla Lake Basin ',
								
									'2.4 To increase the skill and efficiency of the operation of the staff in the use and maintenance of the telephone system.'
								),
		'file'			=>	null,
		'img'			=>	'pic_about_2.jpg'
	),
	//array
	//(
	//	'title'			=>	'องค์ประกอบหลักของระบบ',
//	'content'		=>	array
//								(
//									'ใน ปี 2555 กรมชลประทานได้ดำเนินการเชื่อมโยงข้อมูล ระบบโทรมาตรของโครงการโทรมาตรลุ่มน้ำ'.$_cfg_name.' ให้จัดเก็บและแสดงผลแบบเวลาจริง พร้อมทั้งจัดหาโปรแกรม และพัฒนาระบบพยากรณ์และระบบ Website ขึ้นใหม่ โดยปฏิบัติการ ณ ศูนย์โทรมาตร กรมชลประทาน สามเสน กรุงเทพฯ ระบบโทรมาตรลุ่มน้ำ'.$_cfg_name.' มี 3 ส่วนหลัก ได้แก่ สถานีศูนย์ควบคุมหลัก สถานีหลักย่อย และสถานีสนาม'
//								),
//		'list'			=>	array
//								(
//									'สถานีศูนย์ควบคุมหลัก (Master Station) ซึ่งเป็นที่ตั้งของห้องควบคุมระบบโทรมาตร (Control Room) ตั้งอยู่ที่กรมชลประทาน สามเสน',
//
//									'สถานีหลักย่อย (Sub-Master Station) ทำหน้าที่ติดตามและเฝ้าระวัง จำนวน 4 แห่ง ได้แก่
//									<br>- '.$_cfg_station['SMS1']['name'].'
//									<br>- '.$_cfg_station['SMS2']['name'].'
//									<br>- '.$_cfg_station['SMS3']['name'].'
//									<br>- '.$_cfg_station['SMS4']['name'].'',
//
//									'สถานีสนาม (Remote Station) จำนวน 26 สถานี ประกอบด้วย
//									<br>- สถานีวัดปริมาณน้ำฝนอย่างเดียว 7 สถานี
//									<br>- สถานีวัดระดับน้ำอย่างเดียว 5 สถานี
//									<br>- สถานีวัดปริมาณน้ำฝนและวัดระดับน้ำ 14 สถานี'
//								),
//		'file'			=>	null,
//		'img'			=>	'pic_about_3.jpg'
//	),
	array
	(
		'title'			=>	'List of stations',
		'content'		=>	null,
		'list'			=>	null,
		'file'			=>	'table_en.php',
		'img'			=>	null
		//'img'			=>	'pic_map.jpg'
	)
);


/* ------------------------------------------------------------------ #LOGIN */
$_cfg_sign_form = array
(
	"id"		=> "ID",
	"pass"	=> "Password",
	"verify"	=> "Verify"
);
$_cfg_sign_ms = array
(
	"yes" => array
	(
		"ms" => "Logging in, Please wait.",
		"style" => "process fs_big fc_pri"
	),
	"no" => array
	(
		"ms" => "Username or Password incorrect, Please try again.",
		"style" => "process fs_big fc_danger"
	),
	"verify" => array
	(
		"ms" => "Verify incorrect.",
		"style" => "process fs_big fc_danger"
	)
);


/* ---------------------------------------------------------------------------------------- #XML */
$_cfg_xml = array
(
	array("http://www.tmd.go.th/xml/weather_report.php?StationNumber=48568", 1),
	array("http://www.tmd.go.th/xml/weather_report.php?StationNumber=48560", 0),
	array("http://www.tmd.go.th/xml/region_daily_forecast.php?RegionID=5", 1),
	//array("http://www.tmd.go.th/xml/region_daily_forecast.php?RegionID=6", 0),
	array("http://www.tmd.go.th/xml/warning.php", 1)
);


/* --------------------------------------------------------------------------------------- #LINK */
$_cfg_link = array
(
	array
	(
		'name' => 'Department of Water Resources',
		'link' => 'http://www.dwr.go.th'
	),
//	array
//	(
//		'name' => 'HAM',
//		'link' => 'http://wx.hamweather.com/?country=th&state=&place=trang&from=wxdir'
//	),
//	array
//	(
//		'name' => 'WATER',
//		'link' => 'http://water.rid.go.th'
//	),
	array
	(
		'name' => 'Center Mekhala',
		'link' => 'http://mekhala.dwr.go.th/main/'
	),
//	array
//	(
//		'name' => 'RI17',
//		'link' => 'http://irrigation.rid.go.th/rid17'
//	),
//	array
//	(
//		'name' => 'patani',
//		'link' => 'http://ridceo.rid.go.th/patani'
//	)
);


/* -------------------------------------------------------------------------------------- #BLOCK */
$_cfg_flow = array
(
	'Tpat.1',
	'Tpat.2',
	'Tpat.3',
	'Tpat.6',
	'Tpat.11',
	'Tpat.12',
	'Tpat.14'
);
$_cfg_block_cctv = array
(
	'Tpat.9'
	//'Tpat.12'
);
?>