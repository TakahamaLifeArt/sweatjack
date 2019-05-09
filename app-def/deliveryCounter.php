<?php
/*
 *
 * ȯ��ͽ�����η׻�
 * charset EUC-JP
 *
 * */

//	require_once dirname(__FILE__).'/jd/japaneseDate.php';

	class DeliveryCounter{

		/**
		*	ȯ��ͽ�����η׻�
		*
		*	@days			��Ȥ��פ������� default 4�ʣ��Ķ�����ȯ������
		*
		*	@return			$fin[]	(Year,Month,Day,...)
		*/
		public static function counter($days=4){
			$jd = new japaneseDate();
			$one_day = 86400;									// �������ÿ�
			$time_stamp = time()+43200;							// ��夫������������Τ��ᣱ�����֤��ÿ�ʬ��­��
			$year  = date("Y", $time_stamp);
			$month = date("m", $time_stamp);
			$day   = date("d", $time_stamp);
			$baseSec = mktime(0, 0, 0, $month, $day, $year);	//�׻���������00:00��timestamp�����
			$workday=0;											// ��Ȥ��פ��������򥫥����
			$_from_holiday = strtotime(_FROM_HOLIDAY);			// ���٤߳�����
			$_to_holiday	= strtotime(_TO_HOLIDAY);			// ���٤ߺǽ���
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