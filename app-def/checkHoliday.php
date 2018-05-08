<?php
/*
*	Takahama Life Art
*	charset utf-8
*------------------------------------
*
*	check holiday
*	return day:holiday name
*/
	require_once dirname(__FILE__).'/jd/japaneseDate.php';
	require_once dirname(__FILE__).'/jd/myCalendarIndex.php';
	$res = "";

	if(isset($_REQUEST['datesec'])){
		$jd = new myCalendarIndex();
		$fin = $jd->makeCalendar();
		if(!empty($fin)){
			foreach($fin as $key=>$val){

				if(empty($info)){
					$info[] = $key;
					$info[] = $key;
				}else{
					$info[] = $key;
				}
			}
		$res = implode(',', $info);
		}
	}
	
	echo $res;
