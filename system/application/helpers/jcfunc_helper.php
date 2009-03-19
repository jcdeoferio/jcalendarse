<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function sorty($array,$index){
		for($j=0;$j<count($array);$j++){
			$key = $array[$j];
			$i = $j-1;
			while ($i>=0 && $array[$i][$index]>$key[$index]){
				$array[$i+1] = $array[$i];
				$i--;
			}
			$array[$i+1] = $key;
		}
		return $array;
	}

if ( ! function_exists('months_array'))
{
	function months_array()
	{
		$months=array(	'1'=>'January',
 				'2'=>'February',
				'3'=>'March',
				'4'=>'April',
				'5'=>'May',
				'6'=>'June',
				'7'=>'July',
				'8'=>'August',
				'9'=>'September',
				'10'=>'October',
				'11'=>'November',
				'12'=>'December');
		return ($months);
	}

	function days_array(){
		 $days = array();
		 for($i = 1; $i <= 31; $i++){
		 	$day = ($i <= 9)?'0'.$i:$i;
		 	$days += array($day => $day);
		 }

		 return ($days);
	}

	function years_array(){
		 $years = array();
		 for($i = 2006; $i <= 2010; $i++){
		 	$years += array($i => $i);
		 }

		 return ($years);
	}

	function hours_array(){
		 $hours = array();
		 for($i = 0; $i <= 23; $i++){
		 	$hour = ($i <= 9)?'0'.$i:$i;
		 	$hours += array($hour => $hour);
		 }

		 return ($hours);
	}

	function minutes_array(){
		 $minutes = array();
		 for($i = 0; $i <= 55; $i+=5){
		 	$minute = ($i <= 9)?'0'.$i:$i;
		 	$minutes += array($minute => $minute);
		 }

		 return ($minutes);
	}

	function months_array_reverse(){
		$months=array(	'January'=>'01',
 				'February'=>'02',
				'March'=>'03',
				'April'=>'04',
				'May'=>'05',
				'June'=>'06',
				'July'=>'07',
				'August'=>'08',
				'September'=>'09',
				'October'=>'10',
				'November'=>'11',
				'December'=>'12');
		return ($months);
	}

	function days_array_reverse(){
		$months=array(	'Sun'=>'0',
 				'Mon'=>'1',
				'Tue'=>'2',
				'Wed'=>'3',
				'Thu'=>'4',
				'Fri'=>'5',
				'Sat'=>'6');
		return ($months);
	}
}

/* End of file jcfunc.php */
/* Location: ./system/helpers/jcfunc.php */