<?php 
class AvatarMaker {
	var $img = null;
	var $width;
	var $height;
	var $type;
	var $debug = false;

	function AvatarMaker($width = UGAM_AVATAR_MAKER_WIDTH, $height = UGAM_AVATAR_MAKER_HEIGHT, $type = UGAM_IMAGE_TYPE) {
		$this->width = $width;
		$this->height = $height;
		$this->type = strtolower($type);
	}

	function log($str) {
		if($this->debug) {
			echo $str;
		}
	}

	function addImage($filename, $filetype)	{
		if ($filetype == ('gif' || 'png')) {
			$imagecreate = 'imagecreatefrom' . $filetype;
		}

		if (is_file($filename)) {
			if ($this->img == null) {
				$this->img = $imagecreate('images/space.' . $this->type);
			}
			$tmp_image = $imagecreate($filename);
			imagecopy($this->img, $tmp_image, 0, 0, 0, 0, $this->width, $this->height);
		}
	}

	function show() {
		header("Content-type: image/png");
		imagepng($this->img);
	}

	function save($filename, $mode = 0755) {
		imagepng($this->img, $filename);
		chmod($filename, $mode);
	}

	function destroy() {
		if ($this->img != null) {
			@imagedestroy($this->img);
			$this->img = null;
		}
	}

	function senddata() {
		global $settings, $userdata;
		if (!iMEMBER) {
			return false;
		}
		$oldavatar = $userdata['user_avatar'];
		if ($oldavatar && $oldavatar != 'no_avatar.gif') {
			@unlink(BASEDIR.'images/avatars/'.$oldavatar);
			$sql = "UPDATE ".DB_USERS." SET `user_avatar` = 'no_avatar.gif' WHERE user_id = ".$userdata['user_id'];
			dbquery($sql);
		}
		$file = $userdata['user_id'].'.png';
		$filename = BASEDIR . 'images/avatars/' . $file;
		$this->save($filename, 0666);

		$sql = "UPDATE ".DB_USERS." SET `user_avatar` = '".$file."' WHERE user_id = ".$userdata['user_id'];
		dbquery($sql);
		return true;
	}
}

function avatarmaker_check_file($i, &$array, $type = UGAM_IMAGE_TYPE) {
	$key = 'i' . $i;
	return (
		array_key_exists($key, $array) &&
		!empty($array[$key]) &&
		is_file('images/' . $array[$key] . '.' . strtolower($type))
	);
}

function links() {
	global $locale;
	echo "<div align='center'>
	[ <a href='#background'>".$locale['ugam_205']."</a> ]
	[ <a href='#bhair'>".$locale['ugam_206']."</a> ] 
	[ <a href='#ear'>".$locale['ugam_207']."</a> ] 
	[ <a href='#face'>".$locale['ugam_208']."</a> ] 
	[ <a href='#fhair'>".$locale['ugam_209']."</a> ] 
	[ <a href='#eyebrow'>".$locale['ugam_210']."</a> ]
	[ <a href='#eyes'>".$locale['ugam_211']."</a> ] 
	[ <a href='#nose'>".$locale['ugam_212']."</a> ] 
	[ <a href='#mouth'>".$locale['ugam_213']."</a> ] 
	[ <a href='#dress'>".$locale['ugam_214']."</a> ] 
	[ <a href='#others'>".$locale['ugam_215']."</a> ]
	</div>";
}

function make_number ($n) {
    if ($n > 9) {
    	$number = strval($n);
    } else {
    	$number = "0".strval($n);
    }
    return $number;
}
	
function make_tr_img($start, $code) {
	global $modversion;
	echo "<tr align='center' class='bg3'>\r\n";
	for ($i=$start; $i<($start+UGAM_IMAGESINROW); $i++) {
		if (file_exists(INFUSIONS."ug_avatarmaker/images/".$code."_0".make_number($i).".png")) {
			$td = "<td><img src='images/".$code."_0".make_number($i).".png' alt='".$code."_0".make_number($i)."' /></td>\r\n";
		} else {
			$td = "<td>\r\n</td>";
		}
		echo $td;
	}
    echo "</tr>\r\n";
}

function make_tr_radio($start, $code, $index) {
	global $HTTP_POST_VARS;
	echo "<tr align='center' class='bg1'>\r\n";
	for ($i=$start; $i<($start+UGAM_IMAGESINROW); $i++) {
		if (file_exists(INFUSIONS."ug_avatarmaker/images/".$code."_0".make_number($i).".png"))	{
			$td = "<td><input type='radio' name='i".$index."' value='".$code."_0".make_number($i)."'";
			if (isset($_POST) && array_key_exists("i".$index, $_POST) && $_POST["i".$index] == $code."_0".make_number($i) ) {
    			$td.= " checked='checked'";
    		}
			$td.= " /></td>\r\n";
		} else {
			$td = "<td>\r\n</td>";
		}
		echo $td;
	}
    echo "</tr>\r\n";
}

function make_table($name, $code, $constant, $index) {
	global $HTTP_POST_VARS, $settings, $userdata, $locale;
	echo "<div><table border='0' width='100%' class='bg2'>
    	<tr>
    	<th colspan='5' style='text-align: left;' id='".$name."'>".$constant."</th>
    	</tr>";
    if ($handle = opendir(INFUSIONS."ug_avatarmaker/images")) {
        $n = 0;       // contains number of images of $code
    	while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != ".." && (strpos($file, $code) !== false)) {
               $n++;
			}
        }
		closedir($handle);
    }
	$nrows = floor(($n-1)/UGAM_IMAGESINROW)+1;     // number of rows in table
	for ($i=0; $i<$nrows; $i++) {
		make_tr_img($i*UGAM_IMAGESINROW+1, $code);
		make_tr_radio($i*UGAM_IMAGESINROW+1, $code, $index);
	}
	echo "<tr>
        <td colspan='5' align='right'>
        <input type='radio' name='i".$index."' value='space'";
	if (!isset($_POST) || !array_key_exists("i".$index, $_POST) || $_POST["i".$index] == 'space' ) {
		echo " checked='checked'";
	}
	echo " />".$locale['ugam_204']."
        <input class='button' type='submit' name='preview' value='".$locale['ugam_200']."' />
        </td>
        </tr>
        </table></div>";
    
}
for($i = 1; $i <= UGAM_AVATAR_MAKER_IMAGE; $i++) {
	$key = 'i' . $i;
	$checkedOption = ' checked="checked"';
	if (!$_POST || !array_key_exists($key, $_POST) || $_POST[$key] == 'space') {
		$checked[$key]['space'] = $checkedOption;
	} else {
		$checked[$key][$_POST[$key]] = $checkedOption;
	}
}
?>
