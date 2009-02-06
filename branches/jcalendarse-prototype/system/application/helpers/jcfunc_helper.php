<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('months_array'))
{
	function months_array()
	{
		$months=array(	'01'=>'January',
 				'02'=>'February',
				'03'=>'March',
				'04'=>'April',
				'05'=>'May',
				'06'=>'June',
				'07'=>'July',
				'08'=>'August',
				'09'=>'September',
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
}

/* End of file jcfunc.php */
/* Location: ./system/helpers/jcfunc.php */