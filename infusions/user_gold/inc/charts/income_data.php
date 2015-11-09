<?php
require_once "../../../../maincore.php";
require_once 'charts.php';
require_once INFUSIONS."user_gold/infusion_db.php";
//require_once INFUSIONS."user_gold/functions.php";

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*				Makes a range array for the transactions				*/
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
if (!function_exists("gold_range")) {
	function gold_range($low, $high, $step = 1) { 
		$arr = array(); 
		$step = (abs($step)>0)?abs($step):1; 
		$sign = ($low<=$high)?1:-1; 
		if(is_numeric($low) && is_numeric($high)) { 
			//numeric sequence 
			for ($i = (float)$low; $i*$sign <= $high*$sign; $i += $step*$sign) 
				$arr[] = $i; 
		}    else    { 
			//character sequence 
			if (is_numeric($low)) 
				return $this->range($low, 0, $step); 
			if (is_numeric($high)) 
				return $this->range(0, $high, $step); 
			$low = ord($low); 
			$high = ord($high); 
			for ($i = $low; $i*$sign <= $high*$sign; $i += $step*$sign) { 
					
				$arr[] = chr($i); 
			} 
		} 
		return $arr; 
	} 
}
/*****************************************************/

//Settings
$display = false; $count = "";
$text = "Income";

//Today
$today_timestamp = time();
$today_string = showdate("%Y-%m-%d", $today_timestamp);

//30 days ago
$past_timestamp = $today_timestamp-2592000;
$past_string = showdate("%Y-%m-%d", $past_timestamp);

echo ($display == TRUE ? "past_string = ".$past_string."<br>" : "");
echo ($display == TRUE ? "today_string = ".$today_string."<br>" : "");

echo ($display == TRUE ? "<br>" : "");

//Make timespan array
$timespan_arr = gold_range($today_timestamp,$past_timestamp,86400);
$timespan=$timespan_arr; $key=""; $time=""; $number=0; $timespan_new_arr = array();
while(list($key, $time) = each($timespan)){
	$number++;
	$newarrtime = showdate("%Y-%m-%d", $time);
	array_push($timespan_new_arr, $newarrtime);
	echo ($display == TRUE ? "Key: $key - Time: $newarrtime<br>" : "");
}

echo ($display == TRUE ? "<hr>" : "");

//The converted timespan array for myslq
$timespan=$timespan_new_arr; $key=""; $time=""; $number=0; 
while(list($key, $time) = each($timespan)){
	$newarrtime = $time;
	//Open Connection TO Table
	$result = dbquery("SELECT sum(transaction_value) AS sum, (date(transaction_timestamp)) AS thedate 
	FROM ".DB_UG3_TRANSACTIONS."
	WHERE date(transaction_timestamp)='".$time."' AND transaction_user_id='".$userdata['user_id']."'
		AND (transaction_type='cash' OR transaction_type='bank') AND transaction_status='2'
	GROUP BY thedate 
	ORDER BY thedate ASC");
	if (dbrows($result)) {
		$data = dbarray($result);
		$c_data[$key] = $data['sum'];
	} else {
		$c_data[$key] = 0;
	}	
	//End connection to table
	echo ($display == TRUE ? "Key: $key - Time: $time<br>" : "");
}

krsort($c_data);

$c_data_max = max($c_data);

/*****************************************************/


$chart[ 'axis_category' ] = array ( 'size'=>14, 'color'=>"000000", 'alpha'=>0, 'font'=>"arial", 'bold'=>true, 'skip'=>0 ,'orientation'=>"horizontal" ); 
$chart[ 'axis_ticks' ] = array ( 'value_ticks'=>true, 'category_ticks'=>true, 'major_thickness'=>2, 'minor_thickness'=>1, 'minor_count'=>1, 'major_color'=>"000000", 'minor_color'=>"222222" ,'position'=>"outside" );
$chart[ 'axis_value' ] = array (  'min'=>0, 'max'=>$c_data_max, 'font'=>"arial", 'bold'=>true, 'size'=>10, 'color'=>"ffffff", 'alpha'=>50, 'steps'=>6, 'prefix'=>"", 'suffix'=>"", 'decimals'=>0, 'separator'=>"", 'show_min'=>true );

$chart[ 'chart_border' ] = array ( 'color'=>"000000", 'top_thickness'=>1, 'bottom_thickness'=>1, 'left_thickness'=>2, 'right_thickness'=>1 );
$chart[ 'chart_data' ] = array ( array ( "","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31" ), array ( "Inclome",$c_data[30], $c_data[29], $c_data[28], $c_data[27], $c_data[26], $c_data[25], $c_data[24], $c_data[23], $c_data[22], $c_data[21], $c_data[20], $c_data[19], $c_data[18], $c_data[17], $c_data[16], $c_data[15], $c_data[14], $c_data[13], $c_data[12], $c_data[11], $c_data[10], $c_data[9], $c_data[8], $c_data[7], $c_data[6], $c_data[5], $c_data[4], $c_data[3], $c_data[2], $c_data[1], $c_data[0] ) );
$chart[ 'chart_grid_h' ] = array ( 'alpha'=>10, 'color'=>"000000", 'thickness'=>1, 'type'=>"solid" );
$chart[ 'chart_grid_v' ] = array ( 'alpha'=>10, 'color'=>"000000", 'thickness'=>1, 'type'=>"solid" );
$chart[ 'chart_pref' ] = array ( 'line_thickness'=>3, 'point_shape'=>"circle", 'fill_shape'=>true );
$chart[ 'chart_rect' ] = array ( 'x'=>20, 'y'=>10, 'width'=>550, 'height'=>120, 'positive_color'=>"000000", 'positive_alpha'=>5, 'negative_color'=>"ff0000",  'negative_alpha'=>10 );
$chart[ 'chart_type' ] = "Line";
$chart[ 'chart_value' ] = array ( 'prefix'=>$text.": ", 'suffix'=>"", 'decimals'=>0, 'separator'=>"", 'position'=>"cursor", 'hide_zero'=>true, 'as_percentage'=>false, 'font'=>"arial", 'bold'=>true, 'size'=>13, 'color'=>"000000", 'alpha'=>100 );

$chart[ 'draw' ] = array ( array ( 'type'=>"text", 'color'=>"000000", 'alpha'=>100, 'font'=>"arial", 'rotation'=>0, 'bold'=>true, 'size'=>10, 'x'=>5, 'y'=>134, 'width'=>100, 'height'=>50, 'text'=>"30 days ago", 'h_align'=>"center", 'v_align'=>"top" ),
                           array ( 'type'=>"text", 'color'=>"000000", 'alpha'=>100, 'font'=>"arial", 'rotation'=>0, 'bold'=>true, 'size'=>10, 'x'=>495, 'y'=>134, 'width'=>100, 'height'=>50, 'text'=>"Today", 'h_align'=>"center", 'v_align'=>"top" ) );

$chart[ 'legend_rect' ] = array ( 'x'=>-100, 'y'=>-100, 'width'=>10, 'height'=>10, 'margin'=>10 ); 

$chart[ 'series_color' ] = array ( "1f649d", "cc5511" ); 

SendChartData ( $chart );
?>