<?php
//session_destroy();
//include $_cfg_path['script']."/check_server.php";
$cryptinstall = $_cfg_path['script']."crypt";
include $cryptinstall."/cryptographp.fct.php";

if ( $_GET['sign'] == "out" )
{
	session_destroy();
	echo '<META HTTP-EQUIV="refresh" CONTENT="0; URL=./?page=login">';
}
?>
<div class="panel panel-success">
<div class="panel-heading">เข้าสู่ระบบ</div>
<div class="panel-body">
<DIV CLASS="filter dc_gray well">
<?php
if ( $_POST['submit'] )
{
	
	
		 $ses_id = $_call->get_login($_POST['input_user'], $_POST['input_pass']);

		if ( $ses_id > 0 )
		{ 			
			$_SESSION['ses_user'] = $_POST['input_user'];
			echo "<SPAN CLASS=\"".$_cfg_sign_ms['yes']['style']."\">".$_cfg_sign_ms['yes']['ms']."</SPAN>";
			echo "<META HTTP-EQUIV=\"refresh\" CONTENT=\"2; URL=./?page=admin\">";
		}
		else
		{
			echo "<SPAN CLASS=\"".$_cfg_sign_ms['no']['style']."\">".$_cfg_sign_ms['no']['ms']."</SPAN>";
			echo "<META HTTP-EQUIV=\"refresh\" CONTENT=\"2; URL=./?".$_SERVER["QUERY_STRING"]."\">";
		}
	
}
else
{
?>

	<FORM METHOD="post">
		<TABLE CLASS="login">
			<TR>
				<TD CLASS="right"><?php echo $_cfg_sign_form['id'] ?></TD>
				<TD><INPUT TYPE="text" NAME="input_user" SIZE="20" VALUE="" CLASS="bc_fade" /></TD>
				<TD ROWSPAN="2"><INPUT TYPE="submit" NAME="submit" CLASS="button bc_sec fc_white" VALUE="<?php echo $_cfg_btn['login'] ?>" /></TD>
			</TR>
			<TR>
				<TD CLASS="right"><?php echo $_cfg_sign_form['pass'] ?></TD>
				<TD><INPUT TYPE="password" NAME="input_pass" SIZE="20" VALUE="" CLASS="bc_fade" /></TD>
			</TR>
		
		</TABLE>
	</FORM>
<?
}	
?>
</DIV>

</div>
</div>