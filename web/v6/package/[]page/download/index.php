<?php
$path = $_cfg_path['download'];
global $path;

function findItem($loc, $type, $format)
{
	global $path;
	$dir = $path.$loc."/";
  
    // Open the folder
    $dir_handle = @opendir($dir) or die("Unable to open $dir");
  
    // Loop through the files
    while (($file = readdir($dir_handle)) !== false)
	{
		if ($file == "." || $file == ".." ) continue;
		$file_utf8 = iconv("TIS-620", "utf-8", $file);
		$filename = basename ($file_utf8, $type);

		if ( $format == "list" )
		{
			echo '<LI CLASS="fc_sec"><A HREF="'.$dir.$file_utf8.'" TARGET="_blank" CLASS="fc_black">'.$filename.'</A></LI>';
		}
		else if ( $format == "option" )
		{
			echo '<OPTION VALUE="'.$dir.$file_utf8.'" TARGET="_blank">'.$filename.'</OPTION>';
		}
		else
		{
			echo '';
		}
    }

    // Close
    closedir($dir_handle);
}
?>
<BR>
<H3>รายงานความก้าวหน้าประจำงวดที่</H3>
<SELECT ONCHANGE="downloadit(this.value)" CLASS="<?php echo $_cfg_css_select ?>">
<?php findItem('monthly', '.pdf', 'option') ?>
</SELECT>
<HR CLASS="dc_fade">

				
<H3>รายงานของโครงการ</H3>
<UL CLASS="list-item">
<?php findItem('project', '.pdf', 'list') ?>
</UL>
<HR CLASS="dc_fade">


<H3>คู่มือการใช้งาน</H3>
<UL CLASS="list-item">
<?php findItem('manual', '.pdf', 'list') ?>
</UL>
<HR CLASS="dc_fade">


<H3>ไฟล์นำเสนอโครงการ</H3>
<SELECT ONCHANGE="downloadit(this.value)" CLASS="<?php echo $_cfg_css_select ?>">
<?php findItem('presentation', '.pdf', 'option') ?>
</SELECT>
<HR CLASS="dc_fade">


<H3>รายงาน Follow Up</H3>
<UL CLASS="list-item">
<?php findItem('follow', '.pdf', 'list') ?>
</UL>


<SCRIPT TYPE="text/javascript">
function downloadit(filename)
{
	if (filename != "")
	{
		//location.href = filename;
		window.open(filename);
	}

	return false;
}
</SCRIPT>

<!--
						<option value="" selected="selected">กรุณาเลือก</option>
						<option value="package/page/download/MonthlyReport/FU1Report.pdf"> 1 : วันที่ 2 มีนาคม 2554 ถึงวันที่ 31 มีนาคม 2554 </option>
						<option value="package/page/download/MonthlyReport/FU2Report.pdf"> 2 : วันที่ 1 เมษายน 2554 ถึงวันที่ 30 เมษายน 2554 </option>
						<option value="package/page/download/MonthlyReport/FU3Report.pdf"> 3 : วันที่ 1 พฤษภาคม 2554 ถึงวันที่ 30 พฤษภาคม 2554 </option>
						<option value="package/page/download/MonthlyReport/FU4Report.pdf"> 4 : วันที่ 31 พฤษภาคม 2554 ถึงวันที่ 29 มิถุนายน 2554 </option>
						<option value="package/page/download/MonthlyReport/FU5Report.pdf"> 5 : วันที่ 30 มิถุนายน 2554 ถึงวันที่ 29 กรกฎาคม 2554 </option>
						<option value="package/page/download/MonthlyReport/FU6Report.pdf"> 6 : วันที่ 30 กรกฎาคม 2554 ถึงวันที่ 28 สิงหาคม 2554 </option>
						<option value="package/page/download/MonthlyReport/FU7Report.pdf"> 7 : วันที่ 29 สิงหาคม 2554 ถึงวันที่ 27 กันยายน 2554 </option>
						<option value="package/page/download/MonthlyReport/FU8Report.pdf"> 8 : วันที่ 28 กันยายน 2554 ถึงวันที่ 27 ตุลาคม 2554 </option>
						<option value="package/page/download/MonthlyReport/FU9Report.pdf"> 9 : วันที่ 28 ตุลาคม 2554 ถึงวันที่ 26 พฤศจิกายน 2554 </option>
						<option value="package/page/download/MonthlyReport/FU10Report.pdf"> 10 : วันที่ 27 พฤศจิกายน 2554 ถึงวันที่ 26 ธันวาคม 2554 </option>
						<option value="package/page/download/MonthlyReport/FU11Report.pdf"> 11 : วันที่ 27 ธันวาคม 2554 ถึงวันที่ 25 มกราคม 2555 </option>
						<option value="package/page/download/MonthlyReport/FU12Report.pdf"> 12 : วันที่ 26 มกราคม 2555 ถึงวันที่ 24 กุมภาพันธ์ 2555 </option>
						<option value="package/page/download/MonthlyReport/FU13Report.pdf"> 13 : วันที่ 25 กุมภาพันธ์ 2555 ถึงวันที่ 25 มีนาคม 2555 </option>
						<option value="package/page/download/MonthlyReport/FU14Report.pdf"> 14 : วันที่ 26 มีนาคม 2555 ถึงวันที่ 24 เมษายน 2555 </option>
						<option value="package/page/download/MonthlyReport/FU15Report.pdf"> 15 : วันที่ 25 เมษายน 2555 ถึงวันที่ 24 พฤษภาคม 2555 </option>
						<option value="package/page/download/MonthlyReport/FU16Report.pdf"> 16 : วันที่ 25 พฤษภาคม 2555 ถึงวันที่ 23 มิถุนายน 2555 </option>
						<option value="package/page/download/MonthlyReport/FU17Report.pdf"> 17 : วันที่ 24 มิถุนายน 2555 ถึงวันที่ 23 กรกฎาคม 2555 </option>
						<option value="package/page/download/MonthlyReport/FU18Report.pdf"> 18 : วันที่ 24 กรกฎาคม 2555 ถึงวันที่ 22 สิงหาคม 2555 </option>
						<option value="package/page/download/MonthlyReport/FU19Report.pdf"> 19 : วันที่ 23 สิงหาคม 2555 ถึงวันที่ 21 กันยายน 2555 </option>
						<option value="package/page/download/MonthlyReport/FU20Report.pdf"> 20 : วันที่ 22 กันยายน 2555 ถึงวันที่ 21 ตุลาคม 2555 </option>
						<option value="package/page/download/MonthlyReport/FU21Report.pdf"> 21 : วันที่ 22 ตุลาคม 2555 ถึงวันที่ 20 พฤศจิกายน 2555 </option>
						<option value="package/page/download/MonthlyReport/FU22Report.pdf"> 22 : วันที่ 21 พฤศจิกายน 2555 ถึงวันที่ 20 ธันวาคม 2555 </option>
						<option value="package/page/download/MonthlyReport/FU23Report.pdf"> 23 : วันที่ 21 ธันวาคม 2555 ถึงวันที่ 19 มกราคม 2556 </option>
						<option value="package/page/download/MonthlyReport/FU24Report.pdf"> 24 : วันที่ 20 มกราคม 2556 ถึงวันที่ 18 กุมภาพันธ์ 2556 </option>
						<option value="package/page/download/MonthlyReport/FU25Report.pdf"> 25 : วันที่ 19 กุมภาพันธ์ 2556 ถึงวันที่ 20 มีนาคม 2556 </option>
						<option value="package/page/download/MonthlyReport/FU26Report.pdf"> 26 : วันที่ 21 มีนาคม 2556 ถึงวันที่ 19 เมษายน 2556 </option>
						<option value="package/page/download/MonthlyReport/FU27Report.pdf"> 27 : วันที่ 20 เมษายน 2556 ถึงวันที่ 19 พฤษภาคม 2556 </option>
						-->
						<!-- <option value="download/Presentation/PPTWorkPlan.pdf">แผนปฏิบัติงาน</option>
<option value="download/Presentation/PPTInception.pdf">การเริ่มงาน</option>
<option value="download/Presentation/PPTStudyNetwork.pdf">ผลการศึกษาวางโครงข่าย</option>
<option value="download/Presentation/PPTUserSubMasterStation.pdf">การใช้งานระบบโทรมาตร สถานีหลักย่อย</option>
<option value="download/Presentation/PPTFinal.pdf">ภาพรวมระบบพยากรณ์น้ำและเตือนภัยลุ่มน้ำทะเลสาบสงขลา</option>
<option value="download/Presentation/PPTTeleSetup.pdf">การติดตั้งระบบโทรมาตร</option>
<option value="download/Presentation/PPTWIZCON.pdf">การติดตั้ง พัฒนา และแก้ไข โปรแกรมควบคุมระบบโทรมาตร</option>
<option value="download/Presentation/PPTMaintenance.pdf">การดูแลบำรุงรักษาอุปกรณ์ระบบโทรมาตร</option>
<option value="download/Presentation/PPTSQL.pdf">การติดตั้ง พัฒนา และแก้ไขระบบฐานข้อมูล</option>
<option value="download/Presentation/PPTMIKE11.pdf">การพัฒนา และแก้ไขแบบจำลองคณิตศาสตร์พยากรณ์น้ำ</option>
<option value="download/Presentation/PPTFloodwatch.pdf">การพัฒนา การใช้งาน และการแก้ไขระบบพยากรณ์น้ำ</option>
<option value="download/Presentation/PPTWeb.pdf">โครงสร้างเวบไซต์และการแก้ไขข้อมูลที่แสดงบนเวบไซต์</option>
<option value="download/Presentation/PPTMasterStation.pdf">การดูแล ตรวจสอบ และแก้ไขปัญหาที่สถานีหลัก</option> -->