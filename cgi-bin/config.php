<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/php_libs/conndb_holiday.php';
require_once dirname(__FILE__).'/JSON.php';

define('_DOMAIN', 'http://'.$_SERVER['HTTP_HOST']);
define('_DOC_ROOT', $_SERVER['DOCUMENT_ROOT'].'/');

define('_SESS_SAVE_PATH',$_SERVER['DOCUMENT_ROOT'].'/sesstmp/');
define('_GUEST_IMAGE_PATH', 'user/guest/data/');
define('_MEMBER_IMAGE_PATH', 'user/member/data/');
define('_ORDER_TEMP_PATH', 'user/member/data/tmp/');
define('_MAXIMUM_SIZE', 104857600);		// max upload file size is 100MB(1024*1024*100).

define('_INFO_EMAIL', 'info@sweatjack.jp');
define('_ORDER_EMAIL', 'order@sweatjack.jp');
define('_ESTIMATE_EMAIL', 'estimate@sweatjack.jp');
define('_REQUEST_EMAIL', 'request@sweatjack.jp');
define('_SERVICE_EMAIL', 'service@sweatjack.jp');

define('_MAIN_EMAIL', 'info@takahama428.com');
define('_TEST_EMAIL', 'test@takahama428.com');

define('_OFFICE_TEL', '03-5670-0787');
define('_OFFICE_FAX', '03-5670-0730');
define('_TOLL_FREE', '0120-130-428');

define('_PACK_FEE', 50);
define('_NO_PACK_FEE', 10);
define('_NO_PRINT_RATE', 1.1);	// プリントなしの割増
define('_CREDIT_RATE', 0);	// カード手数料率 - 廃止2018-01-30

define('_API', 'http://takahamalifeart.com/v1/api');
define('_API_U', 'http://takahamalifeart.com/v1/apiu');
define('_IMG_PSS', 'http://takahamalifeart.com/weblib/img/');
define('_ORDER_INFO', 'http://original-sweat.com/system/php_libs/ordersinfo.php');

define('_TEST_NAME', 'test.sweatjack.jp');	// 2012-11-20 sub domain for a alpha test

//本サイトの識別子
//define('_SHOW_SITE', 'sweatjack');
define('_SITE', '5');

//休業終始日付、お知らせの取得
$hol = new Conndb_holiday();
//$holiday_data=$holidayinfo->getHolidayinfo(_SITE);
$holiday_data=$hol->getHolidayinfo();
if($holiday_data['notice']=="" && $holiday_data['notice-ext']==""){
	$notice = "";
	$extra_noitce = "";
}else{
	$notice = $holiday_data['notice'];
	$extra_noitce = $holiday_data['notice-ext'];
}
$time_start = str_replace("-","/",$holiday_data['start']);
$time_end = str_replace("-","/",$holiday_data['end']);

//休業終始日付、お知らせ
define('_FROM_HOLIDAY', $time_start);
define('_TO_HOLIDAY', $time_end);
define('_NOTICE_HOLIDAY', $notice);
define('_EXTRA_NOTICE', $extra_noitce);

// 会員割の適用開始日
define('_START_RANKING', '2018-01-30');
?>
