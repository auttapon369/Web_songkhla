<div class="panel panel-success">
<div class="panel-heading"><i class="glyphicon glyphicon-link"></i>Web Service</div>
<div class="panel-body">
<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#home">ข้อมูลรายวัน</a></li>
  <li><a data-toggle="tab" href="#menu1">ข้อมูลสัปดาห์</a></li>
  <li><a data-toggle="tab" href="#menu2">ข้อมูลเดือน</a></li>
</ul>

<div class="tab-content">
  <div id="home" class="tab-pane fade in active">
    
<u>Description</u>
<ul><li>บริการข้อมูลรายวัน</li></ul>
<u>ข้อมูลรับ (input)</u>

<ul>
<li>รหัสผู้ใช้ (user)</li>
<li>รหัสผ่าน (pass)</li>
<li>ประเภทข้อมูล</li>
<ul><li>GetDataDaily = ข้อมูลรายวัน</li>
<li>DataWeeklyResult = ข้อมูลรายสัปดาห์</li>
<li>DataMonthlyResult = ข้อมูลรายเดือน</li></ul>
<li>รูปแบบข้อมูล (dtype)</li>
<ul><li>dtype = 1 รูปแบบข้อมูล XML</li>
<li>dtype = 2 รูปแบบข้อมูล JSON</li></ul>
<li>วันที่ (ondate)</li>
<ul><li>ถ้าระดับผู้ใช้ คือ user ข้อมูลคือวันที่ล่าสุดเท่านั้น</li>
<li>ถ้าระดับผู้ใช้ คือ admin สามารถระบุวันที่ได้ดังนี้</li>
<li>ondate = dd/mm/yyyy</li></ul>
</ul>

<u>ข้อมูลส่งกลับ (output)</u>
<ul>
<li>รูปแบบข้อมูล XML</li>
<ul>
<li>&lt;Date&gt2559-04-20&lt;/Date&gt;</li>
    <ul>
	<li>&lt;Stations&gt;</li>
	<ul>
        <li>&lt;StationDailyInfo&gt;</li>
		<ul>
            <li>&lt;ID&gt;รหัสสถานี&lt;/ID&gt;</li>
            <li>&lt;Name&gt;ชื่อ&lt;/Name&gt;</li>
            <li>&lt;Rf24h&gt;ฝนย้อนหลัง 24 ชม.&lt;/Rf24h&gt;</li>
            <li>&lt;Rf00h&gt;ฝนสะสมรายวัน&lt;/Rf00h&gt;</li>
            <li>&lt;Rf77h&gt;ฝนสะสม 7 โมง&lt;/Rf77h&gt;</li>
            <li>&lt;RfMax&gt;ฝนสูงสุดรายวัน&lt;/RfMax&gt;</li>
            <li>&lt;RfMaxTime&gt;วัน-เวลาฝนสูงสุดรายวัน&lt;/RfMaxTime&gt;</li>
            <li>&lt;WlAvg&gt;ระดับน้ำเฉลี่ยรายวัน&lt;/WlAvg&gt;</li>
            <li>&lt;WlMin&gt;ระดับน้ำต่ำสุดรายวัน&lt;/WlMin&gt;</li>
            <li>&lt;WlMinTime&gt;วัน-เวลาระดับน้ำต่ำสุดรายวัน&lt;/WlMinTime&gt;</li>
            <li>&lt;WlMax&gt;ระดับน้ำสูงสุดรายวัน&lt;/WlMax&gt;</li>
            <li>&lt;WlMaxTime&gt;วัน-เวลาระดับน้ำสูงสุดรายวัน&lt;/WlMaxTime&gt;</li>
		</ul>
        <li>&lt;/StationDailyInfo&gt;</li>
		</ul>
		</ul>
</ul>
<li>รูปแบบข้อมูล JSON</li>
<ul>
<li>"ID": รหัสสถานี,</li>
           <li> "Name": ชื่อ,</li>
           <li> "Rf24h": ฝนย้อนหลัง 24 ชม.,</li>
           <li> "Rf00h": ฝนสะสมรายวัน,</li>
           <li> "Rf77h": ฝนสะสม 7 โมง,</li>
            <li>"RfMax": ฝนสูงสุดรายวัน,</li>
            <li>"RfMaxTime": วัน-เวลาฝนสูงสุดรายวัน,</li>
            <li>"WlAvg": ระดับน้ำเฉลี่ยรายวัน,</li>
            <li>"WlMin": ระดับน้ำต่ำสุดรายวัน,</li>
            <li>"WlMinTime": วัน-เวลาระดับน้ำต่ำสุดรายวัน,</li>
           <li> "WlMax": ระดับน้ำสูงสุดรายวัน,</li>
           <li> "WlMaxTime": วัน-เวลาระดับน้ำสูงสุดรายวัน</li>
</ul>
<li>กรณีระดับผู้ใช้ไม่ใช่ user และ admin</li>
<ul>
<li>- รูปแบบข้อมูล XML คือ <error>ระดับผู้ใช้ต้องเป็น User หรือ Admin เท่านั้น</error></li>
<li>- รูปแบบข้อมูล JSON คือ error:ระดับผู้ใช้ต้องเป็น User หรือ Admin เท่านั้น</li>
</ul>
</ul>
<u>ตัวอย่างการใช้งาน</u>
<ul>
<li>url = http://202.129.59.96/webservice/WebService.svc</li>
<li>กำหนดข้อมูลรับไปที่ท้าย url ดังนี้</li>
<li>http://202.129.59.96/webservice/WebService.svc/GetDataDaily?user=user&pass=password&ondate=yyyy-mm-dd</li>
</ul>
  </div>




  <div id="menu1" class="tab-pane fade">
    
<u>Description</u>
<ul><li>บริการข้อมูลรายสัปดาห์</li></ul>
<u>ข้อมูลรับ (input)</u>

<ul>
<li>รหัสผู้ใช้ (user)</li>
<li>รหัสผ่าน (pass)</li>
<li>ประเภทข้อมูล</li>
<ul><li>GetDataDaily = ข้อมูลรายวัน</li>
<li>DataWeeklyResult = ข้อมูลรายสัปดาห์</li>
<li>DataMonthlyResult = ข้อมูลรายเดือน</li></ul>
<li>รูปแบบข้อมูล (dtype)</li>
<ul><li>dtype = 1 รูปแบบข้อมูล XML</li>
<li>dtype = 2 รูปแบบข้อมูล JSON</li></ul>
<li>วันที่ (ondate)</li>
<ul><li>ถ้าระดับผู้ใช้ คือ user ข้อมูลคือวันที่ล่าสุดเท่านั้น</li>
<li>ถ้าระดับผู้ใช้ คือ admin สามารถระบุวันที่ได้ดังนี้</li>
<li>ondate = dd/mm/yyyy</li></ul>
</ul>

<u>ข้อมูลส่งกลับ (output)</u>
<ul>
<li>รูปแบบข้อมูล XML</li>
<ul>
<li>&lt;Date&gt2559-04-20&lt;/Date&gt;</li>
    <ul>
	<li>&lt;Stations&gt;</li>
	<ul>
        <li>&lt;StationDailyInfo&gt;</li>
		<ul>
            <li>&lt;ID&gt;รหัสสถานี&lt;/ID&gt;</li>
            <li>&lt;Name&gt;ชื่อ&lt;/Name&gt;</li>
            <li>&lt;Rf24h&gt;ฝนย้อนหลัง 1 วัน&lt;/Rf24h&gt;</li>
            <li>&lt;Rf48h&gt;ฝนย้อนหลัง 2 วัน&lt;/Rf48h&gt;</li>
            <li>&lt;Rf72h&gt;ฝนย้อนหลัง 3 วัน&lt;/Rf72h&gt;</li>
            <li>&lt;Rf96h&gt;ฝนย้อนหลัง 4 วัน&lt;/Rf96h&gt;</li>
            <li>&lt;Rf120h&gt;ฝนย้อนหลัง 5 วัน&lt;/Rf120h&gt;</li>
            <li>&lt;Rf144h&gt;ฝนย้อนหลัง 6 วัน&lt;/Rf144h&gt;</li>
            <li>&lt;Rf168h&gt;ฝนย้อนหลัง 7 วัน&lt;/Rf168h&gt;</li>
            <li>&lt;Wl24h&gt;ระดับน้ำเฉลี่ยย้อนหลัง 1 วัน&lt;/Wl24h&gt;</li>
            <li>&lt;Wl48h&gt;ระดับน้ำเฉลี่ยย้อนหลัง 2 วัน&lt;/Wl48h&gt;</li>
            <li>&lt;Wl72h&gt;ระดับน้ำเฉลี่ยย้อนหลัง 3 วัน&lt;/Wl72h&gt;</li>
            <li>&lt;Wl96h&gt;ระดับน้ำเฉลี่ยย้อนหลัง 4 วัน&lt;/Wl96h&gt;</li>
            <li>&lt;Wl120h&gt;ระดับน้ำเฉลี่ยย้อนหลัง 5 วัน&lt;/Wl120h&gt;</li>
            <li>&lt;Wl144h&gt;ระดับน้ำเฉลี่ยย้อนหลัง 6 วัน&lt;/Wl144h&gt;</li>
            <li>&lt;Wl168h&gt;ระดับน้ำเฉลี่ยย้อนหลัง 7 วัน&lt;/Wl168h&gt;</li>
		</ul>
        <li>&lt;/StationDailyInfo&gt;</li>
		</ul>
		</ul>
</ul>
<li>รูปแบบข้อมูล JSON</li>
<ul>
<li>"ID": รหัสสถานี,</li>
           <li> "Name": ชื่อ,</li>
           <li> "Rf24h": ฝนย้อนหลัง 1 วัน,</li>
           <li> "Rf48h": ฝนย้อนหลัง 2 วัน,</li>
           <li> "Rf72h": ฝนย้อนหลัง 3 วัน,</li>
            <li>"Rf96h": ฝนย้อนหลัง 4 วัน,</li>
            <li>"Rf120h": ฝนย้อนหลัง 5 วัน,</li>
            <li>"Rf144h": ฝนย้อนหลัง 6 วัน,</li>
            <li>"Rf168h": ฝนย้อนหลัง 7 วัน,</li>
            <li>"Wl24h": ระดับน้ำเฉลี่ยย้อนหลัง 1 วัน,</li>
           <li> "Wl48h": ระดับน้ำเฉลี่ยย้อนหลัง 2 วัน,</li>
           <li> "Wl72h": ระดับน้ำเฉลี่ยย้อนหลัง 3 วัน,</li>		
           <li>"Wl96h": ระดับน้ำเฉลี่ยย้อนหลัง 4 วัน,</li>
            <li>"Wl120h": ระดับน้ำเฉลี่ยย้อนหลัง 5 วัน,</li>
           <li>"Wl144h": ระดับน้ำเฉลี่ยย้อนหลัง 6 วัน,</li>
            <li>"Wl168h": ระดับน้ำเฉลี่ยย้อนหลัง 7 วัน</li>

</ul>
<li>กรณีระดับผู้ใช้ไม่ใช่ user และ admin</li>
<ul>
<li>- รูปแบบข้อมูล XML คือ <error>ระดับผู้ใช้ต้องเป็น User หรือ Admin เท่านั้น</error></li>
<li>- รูปแบบข้อมูล JSON คือ error:ระดับผู้ใช้ต้องเป็น User หรือ Admin เท่านั้น</li>
</ul>
</ul>
<u>ตัวอย่างการใช้งาน</u>
<ul>
<li>url = http://202.129.59.96/webservice/WebService.svc</li>
<li>กำหนดข้อมูลรับไปที่ท้าย url ดังนี้</li>
<li>http://202.129.59.96/webservice/WebService.svc/GetDataWeekly?user=user&pass=password&ondate=yyyy-mm-dd</li>
</ul>

  </div>



  <div id="menu2" class="tab-pane fade">
   <u>Description</u>
<ul><li>บริการข้อมูลรายเดือน</li></ul>
<u>ข้อมูลรับ (input)</u>

<ul>
<li>รหัสผู้ใช้ (user)</li>
<li>รหัสผ่าน (pass)</li>
<li>ประเภทข้อมูล</li>
<ul><li>GetDataDaily = ข้อมูลรายวัน</li>
<li>DataWeeklyResult = ข้อมูลรายสัปดาห์</li>
<li>DataMonthlyResult = ข้อมูลรายเดือน</li></ul>
<li>รูปแบบข้อมูล (dtype)</li>
<ul><li>dtype = 1 รูปแบบข้อมูล XML</li>
<li>dtype = 2 รูปแบบข้อมูล JSON</li></ul>
<li>วันที่ (ondate)</li>
<ul><li>ถ้าระดับผู้ใช้ คือ user ข้อมูลคือวันที่ล่าสุดเท่านั้น</li>
<li>ถ้าระดับผู้ใช้ คือ admin สามารถระบุวันที่ได้ดังนี้</li>
<li>ondate = dd/mm/yyyy</li></ul>
</ul>

<u>ข้อมูลส่งกลับ (output)</u>
<ul>
<li>รูปแบบข้อมูล XML</li>
<ul>
<li>&lt;Date&gt2559-04-20&lt;/Date&gt;</li>
    <ul>
	<li>&lt;Stations&gt;</li>
	<ul>
        <li>&lt;StationDailyInfo&gt;</li>
		<ul>
            <li>&lt;ID&gt;รหัสสถานี&lt;/ID&gt;</li>
            <li>&lt;Name&gt;ชื่อ&lt;/Name&gt;</li>
            <li>&lt;Rf24h&gt;ฝนย้อนหลัง 24 ชม.&lt;/Rf24h&gt;</li>
            <li>&lt;Rf00h&gt;ฝนสะสมรายวัน&lt;/Rf00h&gt;</li>
            <li>&lt;Rf77h&gt;ฝนสะสม 7 โมง&lt;/Rf77h&gt;</li>
            <li>&lt;RfMax&gt;ฝนสูงสุดรายวัน&lt;/RfMax&gt;</li>
            <li>&lt;RfMaxTime&gt;วัน-เวลาฝนสูงสุดรายวัน&lt;/RfMaxTime&gt;</li>
            <li>&lt;WlAvg&gt;ระดับน้ำเฉลี่ยรายวัน&lt;/WlAvg&gt;</li>
            <li>&lt;WlMin&gt;ระดับน้ำต่ำสุดรายวัน&lt;/WlMin&gt;</li>
            <li>&lt;WlMinTime&gt;วัน-เวลาระดับน้ำต่ำสุดรายวัน&lt;/WlMinTime&gt;</li>
            <li>&lt;WlMax&gt;ระดับน้ำสูงสุดรายวัน&lt;/WlMax&gt;</li>
            <li>&lt;WlMaxTime&gt;วัน-เวลาระดับน้ำสูงสุดรายวัน&lt;/WlMaxTime&gt;</li>
		</ul>
        <li>&lt;/StationDailyInfo&gt;</li>
		</ul>
		</ul>
</ul>
<li>รูปแบบข้อมูล JSON</li>
<ul>
<li>"ID": รหัสสถานี,</li>
           <li> "Name": ชื่อ,</li>
           <li> "Rf24h": ฝนย้อนหลัง 24 ชม.,</li>
           <li> "Rf00h": ฝนสะสมรายวัน,</li>
           <li> "Rf77h": ฝนสะสม 7 โมง,</li>
            <li>"RfMax": ฝนสูงสุดรายวัน,</li>
            <li>"RfMaxTime": วัน-เวลาฝนสูงสุดรายวัน,</li>
            <li>"WlAvg": ระดับน้ำเฉลี่ยรายวัน,</li>
            <li>"WlMin": ระดับน้ำต่ำสุดรายวัน,</li>
            <li>"WlMinTime": วัน-เวลาระดับน้ำต่ำสุดรายวัน,</li>
           <li> "WlMax": ระดับน้ำสูงสุดรายวัน,</li>
           <li> "WlMaxTime": วัน-เวลาระดับน้ำสูงสุดรายวัน</li>
</ul>
<li>กรณีระดับผู้ใช้ไม่ใช่ user และ admin</li>
<ul>
<li>- รูปแบบข้อมูล XML คือ <error>ระดับผู้ใช้ต้องเป็น User หรือ Admin เท่านั้น</error></li>
<li>- รูปแบบข้อมูล JSON คือ error:ระดับผู้ใช้ต้องเป็น User หรือ Admin เท่านั้น</li>
</ul>
</ul>
<u>ตัวอย่างการใช้งาน</u>
<ul>
<li>url = http://202.129.59.96/webservice/WebService.svc</li>
<li>กำหนดข้อมูลรับไปที่ท้าย url ดังนี้</li>
<li>http://202.129.59.96/webservice/WebService.svc/GetDataMonthly?user=user&pass=password&ondate=yyyy-mm-dd</li>
</ul>
  </div>





</div>



</div>
</div>


   