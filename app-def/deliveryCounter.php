<?php
/*
 *
 * 発送予定日の計算
 * charset EUC-JP
 *
 * */

//	require_once dirname(__FILE__).'/jd/japaneseDate.php';

	class DeliveryCounter{

		/**
		*	発送予定日の計算
		*
		*	@days			作業に要する日数 default 4（３営業日＋発送日）
		*
		*	@return			$fin[]	(Year,Month,Day,...)
		*/
		public static function counter($days=4){
			$jd = new japaneseDate();
			$one_day = 86400;									// 一日の秒数
			$time_stamp = time()+43200;							// 午後からは翌日扱いのため１２時間の秒数分を足す
			$year  = date("Y", $time_stamp);
			$month = date("m", $time_stamp);
			$day   = date("d", $time_stamp);
			$baseSec = mktime(0, 0, 0, $month, $day, $year);	//計算開始日の00:00のtimestampを取得
			$workday=0;											// 作業に要する日数をカウント
			$_from_holiday = strtotime(_FROM_HOLIDAY);			// お休み開始日
			$_to_holiday	= strtotime(_TO_HOLIDAY);			// お休み最終日
			while($workday<$days){
				$fin = $jd->makeDateArray($baseSec);
				if( (($fin['Weekday']>0 && $fin['Weekday']<6) && $fin['Holiday']==0) && ($baseSec<$_from_holiday || $_to_holiday<$baseSec) ){
					$workday++;
				}
				$baseSec += $one_day;
			}

			return $fin;
		}

	}
?>