<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/../cgi-bin/config.php';
	require_once dirname(__FILE__).'/jd/japaneseDate.php';
	/*
	*	ȯ�����η׻�
	*	�˺����ʳ��ε٤ߤ�������ϡ�$fin['Day']==��������ꤹ��
	*	��夫������������ˤ���ˤϡ��������֤��ÿ�ʬ��­����$baseSec = time()+43200;
	*/

	$jd = new japaneseDate();
	$result_date = true;

	$_from_holiday = strtotime(_FROM_HOLIDAY);
	$_to_holiday	= strtotime(_TO_HOLIDAY);

	if(isset($_POST['act'], $_POST['base'])){
		switch($_POST['act']){
		case 'ms':
			// ���ơ���������ǧ������ȯ������׻�
				$one_day = 86400;						// �������ÿ�
				$cnt = 3;
				if($_POST['package']=="yes") $cnt = 4;	// �޵ͤᤢ��ξ��
				$baseSec = $_POST['base'];
				$fin = getDeliveryDay($baseSec, $one_day, $cnt);
				break;

		case 'send':
			// ���Ϥ�������ȯ���������ơ�����׻�
				$one_day = -86400;

				// �����ˤ���������
				if(isset($_POST['cnt'])){
					$cnt = $_POST['cnt'];
				}else{
					$cnt = 0;	// �����Ϥ�
				}

				// ���Ϥ�������ȯ������ʿ���ˤ�ջ�
				$baseSec = $_POST['base'] + ($one_day*$cnt);
				$fin = $jd->makeDateArray($baseSec);
				while( (($fin['Weekday']==0 || $fin['Weekday']==6) || $fin['Holiday']!=0) || ($baseSec>=$_from_holiday && $_to_holiday>=$baseSec) ){
					$baseSec += $one_day;
					$fin = $jd->makeDateArray($baseSec);
				}
				$sendDay = $fin['Year'].'/'.$fin['Month'].'/'.$fin['Day'];

				// ȯ�����������ơ�����ջ�
				$cnt = 3;
				if($_POST['package']=="yes") $cnt = 4;	// �޵ͤᤢ��ξ��
				$fin = getDeliveryDay($baseSec, $one_day, $cnt);
				$baseSec = mktime(0, 0, 0, $fin['Month'], $fin['Day'], $fin['Year']);
				$baseDay = $fin['Year'].'/'.$fin['Month'].'/'.$fin['Day'];

				// ���ߤΥ����ॹ����פ���������ξ�����������
				$time_stamp = time()+43200;
				$year  = date("Y", $time_stamp);
				$month = date("m", $time_stamp);
				$day   = date("d", $time_stamp);
				$today = mktime(0, 0, 0, $month, $day, $year);

				// ȯ���������ߤ������ˤʤ����"0"���֤�
				if($baseSec<$today){
					$baseDay = "0";
				}

				echo $sendDay.','.$baseDay;
				exit(0);
				break;

		case 'works':
				$one_day = 86400;
				$baseSec = $_POST['base']+$one_day;
				$workday1 = 0;
				$workday2 = 0;

				if(isset($_POST['deli'])){
				/*
				*	���ơ��Ȥ��Ϥ�����������Ķ�����
				*/
					$deliSec = $_POST['deli'];
					$fin = $jd->makeDateArray($baseSec);

					while( $deliSec > $baseSec ){
						if( (($fin['Weekday']>0 && $fin['Weekday']<6) && $fin['Holiday']==0) && ($baseSec<$_from_holiday || $_to_holiday<$baseSec) ){
							$workday1++;
						}
						$baseSec += $one_day;
						$fin = $jd->makeDateArray($baseSec);
					}
				}

				if(isset($_POST['send'])){
				/*
				*	��������
				*	���ơ�������ȯ�����������ޤǤαĶ���
				*/
					$today = $_POST['base'];
					$sendSec = $_POST['send'];
					$fin = $jd->makeDateArray($today);
					while( $today < $sendSec ){
						if( (($fin['Weekday']>0 && $fin['Weekday']<6) && $fin['Holiday']==0) && ($today<$_from_holiday || $_to_holiday<$today) ){
							$workday2++;
						}
						$today += $one_day;
						$fin = $jd->makeDateArray($today);
					}
				}

				$result_date = false;
				echo $workday1.','.$workday2;
				break;

		}


	}

	if($result_date) echo $fin['Year'].'/'.$fin['Month'].'/'.$fin['Day'];


	/*
	*	��Ȥ��פ���Ķ������򥫥���Ȥ���ȯ�������֤�
	*
	*	@baseSec	��������UNIX�����ॹ����פ��ÿ���
	*	@one_day	�������ÿ���86400��
	*	@cnt		�Ķ����Ȥ��ƿ������������̾�������ޤ�ƣ��Ķ�����
	*
	*	return		�٤ߤǤϤʤ�����ȯ�����Ȥ����֤���japaneseData���֥������ȡ�
	*/
	function getDeliveryDay($baseSec, $one_day, $cnt){
		global $_from_holiday, $_to_holiday;
		$jd = new japaneseDate();
		$workday=0;
		while($workday<=$cnt){
			$fin = $jd->makeDateArray($baseSec);
			if( (($fin['Weekday']>0 && $fin['Weekday']<6) && $fin['Holiday']==0) && ($baseSec<$_from_holiday || $_to_holiday<$baseSec) ){
				$workday++;
			}
			$baseSec += $one_day;
		}

		return $fin;
	}
?>