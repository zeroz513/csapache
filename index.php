<?php
session_start();
//exit();  // put # in front of exit(); to allow this script to work
// change $admin_pass to something else for security.
$admin_pass = "1234";  // password for upload files

// web upload
// by Sompan Chansilp
// Fri 04 Oct 2013 07:56:42 AM ICT 
//
// This script will allow upload a file to the same directory where this script resides
// display: Done   if upload success
//        : Error  if upload fail

//import_request_variables('pG', 'p_');
extract($_REQUEST, EXTR_PREFIX_ALL, 'p');
$to_link=trim($_SERVER['PHP_SELF']);

/*$gen_secret=''; if(isset($p_gen_secret)) $gen_secret=trim($p_gen_secret);
if($gen_secret=="y"){
        $str  = "112233445566778899AABBCCDDEEFFGGHHJJKKLLMMNNPPQQRRTTXXYYZZ";
        $pick = substr(str_shuffle($str), 0, 3);

        $_SESSION['secret']=$pick;
        header ("Content-type: image/png");
        $secret=$pick;
        $im = @imagecreatetruecolor(50, 20) or die("Cannot Initialize new GD image stream");
       // imagefill ($im, 0, 0, 180);
		imagefill ($im, 0, 0, 0);
        $text_color = imagecolorallocate($im, 255, 255, 255);
        imagestring($im, 12, 12, 2,  "$secret", $text_color);
        imagepng($im);
        imagedestroy($im);
        exit();
}*/

$password=''; if(isset($p_password)) $password=trim($p_password);
//$secret=''; if(isset($p_secret)) $secret=strtoupper(trim($p_secret));
$action=''; if(isset($p_action)) $action=trim($p_action);

$title = "Upload a file";
#************************ do not change any variables below this line *******************************#
//$pick=strtoupper(trim($_SESSION['secret']));

if ($action=="do_upload" and $password==$admin_pass){
	$file_name=trim($_FILES['userfile']['name']);
	$file_name=str_replace('.php','.php.txt',$file_name);
	$dlink = `pwd`;  //$dlink=/home/c423402/web
	$dlink = trim($dlink).'/'.$file_name;
	$temp_name=$_FILES['userfile']['tmp_name'];
	if(filesize($temp_name)==0) {
		head($title,"Error: File has no data.",$textcolor="#FB3E25");
	}elseif(is_file($dlink)){
		head($title,"Error: File exist.  Cannot replace it.",$textcolor="#FB3E25");
	}elseif(!move_uploaded_file($temp_name,$dlink)){
		head($title,"Error: cannot move upload file.",$textcolor="#FB3E25");
	}else{
		head($title,"Done...",$textcolor="#2133A6");
	}
	echo "<form action=\"$to_link\" method=\"post\" name =\"flogin\" id=\"flogin\">\n";
	echo "<center><br>";
	echo "<a href=\"$to_link\"><---- More upload---<</a><br>\n";
	echo "<hr><a href=\"http://localhost/download/.\"><---- Go back---<</a><br>\n";
	echo "</center>\n";
	echo "</form>\n";
	echo "</center>\n";
	echo "</body></html>";
	exit();
}

if ($action=="do_upload" and ($password!=$admin_pass)){
	head($title,"Wrong password, or secret code.  Go back and try again.",$textcolor="#FB3E25");
	`echo $_FILES >> /tmp/log.txt` ;
	echo "<form action=\"$to_link\" method=\"post\" name =\"flogin\" id=\"flogin\">\n";
	echo "<center><br>";
	echo "<a href=\"http://localhost/download/.\"><---- Go back---<</a><br>\n";
	echo "</center>\n";
	echo "</form>\n";
	exit();
}
Display_login_window();
exit();

####################################################################################################
function Display_login_window()
{
	global $title,$to_link;
	head($title); 
	echo "<form ENCTYPE=\"multipart/form-data\" action=\"$to_link\" method=\"post\">\n";
    echo "<table cellpadding=\"2\" cellspacing=\"2\" border=\"1\" width=\"60%\">\n";
    echo "<tbody>\n";

    $bg1="#DFB9DC";
    $bg2="#FF9999";
	$bg3="#99CCCC";
    echo "<tr>\n";
                echo "<td bgcolor=\"$bg1\" class=\"F6\" valign=\"middle\" width=\"30%\" align=\"left\">\n";
                echo "Give Filename\n";
                echo "</td>\n";
				echo "<td bgcolor=\"$bg1\" class=\"F6\" valign=\"middle\" width=\"70%\" align=\"left\">\n";
                echo "<INPUT NAME=\"userfile\" TYPE=\"file\" SIZE=\"30\">\n";
                echo "</td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
                echo "<td bgcolor=\"$bg2\" width=\"30%\" align=\"left\" valign=\"middle\">\n";
                echo "Password\n";
                echo "</td>\n";
				echo "<td bgcolor=\"$bg2\" width=\"70%\" align=\"left\" valign=\"middle\">\n";
                echo "<input type=\"password\" name=\"password\">";
                echo "</td>\n";
	echo "</tr>\n";

   /* echo "<tr>\n";
                echo "<td bgcolor=\"#9999FF\" width=\"30%\" align=\"left\" valign=\"bottom\">\n";
                echo "Secret code: <img  src=\"$to_link?gen_secret=y\" alt=\"secret_pic\" height=\"20\" width=\"50\">\n";
                echo "</td>\n";
				echo "<td bgcolor=\"#9999FF\" width=\"70%\" align=\"left\" valign=\"middle\">\n";
                echo "<input type=\"text\" name=\"secret\" >\n";
                echo "</td>\n";
	echo "</tr>\n";*/




    echo "<tr>\n";
                echo "<td bgcolor=\"$bg3\" colspan=\"2\" align=\"center\"  valign=\"middle\">\n";
                echo "<input type=\"hidden\" name=\"action\" value=\"do_upload\">\n";
                echo "<input name=\"reset\" type=\"reset\" value=\"   Clear   \">\n";
                echo "<input name=\"submit\" type=\"submit\" value=\"   Send   \">\n";
                echo "</td>\n";
    echo "</tr>\n";

    echo "</tbody>\n";
    echo "</table>\n";
    echo "</form>\n";
    echo "</center>\n";
    echo "</body>\n";
    echo "</html>\n";
}
####################################################################################################
function head($title,$msg="",$textcolor="#2133A6")
{

    if ($title!="") {
        echo "<html>";
        echo "<head>";
        echo "<title>$title</title>";
        echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=TIS-620\">";
        echo "<meta http-equiv=\"Expires: Mon, 26 Jul 1997 05:00:00 GMT\">";
        echo "</head>";
        echo "<body text=\"#000000\" bgcolor=\"#ccccff\" link=\"#000099\" vlink=\"#990099\" alink=\"#000099\">";
        echo "<center>\n";
        echo "<table cellpadding=\"2\" cellspacing=\"2\" border=\"1\" width=\"60%\">\n";
        echo "<tbody><tr>\n";
        echo "<td valign=\"middle\" bgcolor=\"#81ECCA\" align=\"center\">\n";
        echo "<div><font color=\"#3D48AC\"><b>$title</b></font></div>\n";
        echo "</td>\n";
        echo "</tr></tbody>\n";
        echo "</table>\n";
    }
    if ($msg != "") {
		echo "<br>\n";
		echo "<font color=\"$textcolor\">$msg<br></font>\n";
	}
}

?>