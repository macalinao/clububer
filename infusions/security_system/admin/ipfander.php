<?
if (!defined("IN_FUSION") || !iADMIN && !checkrights("IP")) {die();}
$userip=(!empty($_GET['searchip']) ? stripinput($_GET['searchip']) : "");
if(phpversion() >= "4.2.0"){
   extract($_POST);
   extract($_GET);
   extract($_SERVER);
   extract($_ENV);
}

echo "<script>
function m(el) {
  if (el.defaultValue==el.value) el.value = \"\"
}
</script>\n";


echo "<div align='center'>
  <form method='post' action='".FUSION_SELF."?pagefile=ipfander&searchip=".(isset($_POST['target']) ? stripinput($_POST['target']) : $userip)."'>
    <table width='60%' border='0' cellspacing='1' cellpadding='1' class='tbl-border'>
      <tr bgcolor='#9999FF' class='tbl2'>
        <td width='100%' colspan='2' bgcolor='#6666FF' class='tbl2'><b>Security System IP Suche / Security System IP Search </b></td>
      </tr>
      <tr valign='top' class='tbl1'>
        <td>
           <font size='2' face='Verdana, Arial, Helvetica, sans-serif'>
            <input type='radio' name='queryType' value='lookup'>
            Resolve/Reverse Lookup</td><td><input type='radio' name='queryType' value='arin'>
            Whois (IP owner)</font></td></tr>
            <tr valign='top' class='tbl2'><td>
            <font size='2' face='Verdana, Arial, Helvetica, sans-serif'>
			<input type='radio' name='queryType' value='secsys_online'>
            Online Users</font></td><td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><input type='radio' name='queryType' value='users' checked>
            Mitglieder DB / Member DB</font>
        </td>
      </tr>
      <tr bgcolor='#9999FF' class='tbl2'>
        <td colspan='2'>
          <div align='center'>
            <input class='textbox' type='text' name='target'
value='".$userip."'>
            <input type='submit' name='Submit' value='Jetzt Prüfen / Check Now' class='button'>
          </div>
        </td>
      </tr>
    </table>
  </form>
</div>";

#Global kludge for new gethostbyaddr() behavior in PHP 4.1x
$ntarget = "";
$queryType = (isset($_POST['queryType']) ? stripinput($_POST['queryType']) : ""); 
$target=(isset($_POST['target']) ? stripinput($_POST['target']) : "");

#Some functions

function message($msg){
echo "<font face=\"verdana,arial\" size=2>$msg</font>";
flush();
}

function lookup($target){
global $ntarget;
$msg = "<p><b>Online User Results:</b> <blockquote> ".$target ." resolved to ";
if( eregi("[a-zA-Z]", $target) )
  $ntarget = gethostbyname($target);
else
  $ntarget = gethostbyaddr($target);
$msg .= $ntarget."</blockquote></p>";
message($msg);
}

function secsys_online($target){
$msg="";	
$target_entry=stripinput($target);	
$res=dbquery("SELECT * FROM ".DB_PREFIX."online WHERE online_ip='$target_entry'");
if (dbrows($res)>0) {
	$user_data=dbarray($res);
} else {
	$user_data="";
}
if ($user_data!="" && $user_data['online_user']>0) {
	$user=dbarray(dbquery("SELECT * FROM ".DB_PREFIX."users WHERE user_id='".$user_data['online_user']."'"));
} else {
	$user=""; $user['user_name']="n/a";$user['user_level']=0;
}
message("<p><b>Online User Results:</b> <blockquote>".$user['user_name']);
$msg.=($user_data!='' && $user_data['online_user']>0 && $user['user_level']==101 ? " <a href='".ADMIN."members.php?aid=".iAUTH."&step=ban&act=on&sortby=all&rowstart=0&user_id=".$user['user_name']."'>Sperren / Lock</a>" : '');

$msg .= "</blockquote></p>";
message($msg);
}

function secsys_users($target){
$msg="";	
$target_entry=stripinput($target);	
$res=dbquery("SELECT * FROM ".DB_PREFIX."users WHERE user_ip='$target_entry'");
if (dbrows($res)>0) {
	$user_data=dbarray($res);
} else {
	$user_data="";
}
if ($user_data!="" && $user_data['user_id']>0) {
	$user=$user_data['user_name']. ($user['user_level']==101 ? " <a href='".ADMIN."members.php?aid=".iAUTH."&step=ban&act=on&sortby=all&rowstart=0&user_id=".$user['user_name']."'>Sperren / Lock</a>" : "");
} else {
	$user="n/a";
}
message("<p><b>Member Resultat:</b> <blockquote>".$user);

$msg .= "</blockquote></p>";
message($msg);
}

function arin($target){
$server = "whois.arin.net";
$msg=""; $buffer="";$extra="";$nextServer="";
message("<p><b>IP Whois Results:</b><blockquote>");
if (!$target = gethostbyname($target))
  $msg .= "Can't IP Whois without an IP address.";
else{
  message("Connecting to $server...<br><br>");
  if (! $sock = fsockopen($server, 43, $num, $error, 20)){
    unset($sock);
    $msg .= "Timed-out connecting to $server (port 43)";
    }
  else{
    fputs($sock, "$target\n");
    while (!feof($sock))
      $buffer .= fgets($sock, 10240);
    fclose($sock);
    }
   if (eregi("RIPE.NET", $buffer))
     $nextServer = "whois.ripe.net";
   else if (eregi("whois.apnic.net", $buffer))
     $nextServer = "whois.apnic.net";
   else if (eregi("nic.ad.jp", $buffer)){
     $nextServer = "whois.nic.ad.jp";
     #/e suppresses Japanese character output from JPNIC
     $extra = "/e";
     }
   else if (eregi("whois.registro.br", $buffer))
     $nextServer = "whois.registro.br";
   if($nextServer){
     $buffer = "";
     message("Deferred to specific whois server: $nextServer...<br><br>");
     if(! $sock = fsockopen($nextServer, 43, $num, $error, 10)){
       unset($sock);
       $msg .= "Timed-out connecting to $nextServer (port 43)";
       }
     else{
       fputs($sock, "$target$extra\n");
       while (!feof($sock))
         $buffer .= fgets($sock, 10240);
       fclose($sock);
       }
     }
  $buffer = str_replace(" ", "&nbsp;", $buffer);
  $msg .= nl2br($buffer);
  }
$msg .= "</blockquote></p>";
message($msg);
}


#If the form has been posted, process the query, otherwise there's
#nothing to do yet

if(!$queryType)
  exit;

#Make sure the target appears valid

if( (!$target) || (!preg_match("/^[\w\d\.\-]+\.[\w\d]{1,4}$/i",$target)) ){ #bugfix
  message("Error: You did not specify a valid target host or IP.");
  exit;
  }

#Figure out which tasks to perform, and do them

if( ($queryType=="all") || ($queryType=="lookup") )
  lookup($target);
if( ($queryType=="all") || ($queryType=="secsys_online") )
  secsys_online($target);
if( ($queryType=="all") || ($queryType=="users") )
  secsys_users($target);
if( ($queryType=="all") || ($queryType=="arin") )
  arin($target);

closetable();
?>

