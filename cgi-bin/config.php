<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/php_libs/conndb_holiday.php';
require_once dirname(__FILE__).'/JSON.php';

define('_DOMAIN', 'http://'.$_SERVER['HTTP_HOST']);
define('_DOC_ROOT', $_SERVER['DOCUMENT_ROOT'].'/');

define('_SESS_SAVE_PATH',$_SERVER['DOCUMENT_ROOT'].'/sesstmp/');
define('_GUEST_IMAGE_PATH', 'user/guest/data/');
define('_MEMBER_IMAGE_PATH', 'user/member/data/');
define('_ORDER_TEMP_PATH', 'user/member/data/tmp/');
define('_MAXIMUM_SIZE', 20971520);		// max upload file size is 20MB.

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
define('_CREDIT_RATE', 0.05);	// カード手数料率

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

//    　休業案内入力欄

//$_NOTICE_HOLIDAY = "\n<==========  年末年始のお知らせ  ==========>\n";
//$_NOTICE_HOLIDAY .= "12月27日(火)から1月5日(木)の間、休業とさせて頂きます。\n";
//$_NOTICE_HOLIDAY .= "休業期間中に頂きましたお問合せにつきましては、1月6日(金)以降対応させて頂きます。\n";
//$_NOTICE_HOLIDAY .= "お急ぎの方はご注意下さい。何卒よろしくお願い致します。\n\n";

//$_NOTICE_HOLIDAY = '';

define('_NOTICE_HOLIDAY', $notice);


//$_EXTRA_NOTICE = "\n\n<==========  アイテム価格改定のお知らせ  ==========>\n";
//$_EXTRA_NOTICE .= "タカハマライフアートをご利用頂きありがとうございます。\n";
//$_EXTRA_NOTICE .= "為替の影響と原産国の人件費の上昇による各社メーカーの値上げに伴い\n";
//$_EXTRA_NOTICE .= "平成27年4月より当社もアイテムの値上げさせていただくことになりました。\n";
//$_EXTRA_NOTICE .= "アイテムにより10%?30%値上げの予定です。\n";
//$_EXTRA_NOTICE .= "そのため、3月中のお見積もり内容の有効期限を3月31日（火）ご注文確定分（13時まで）とさせていただきます。\n";
//$_EXTRA_NOTICE .= "\n\n";

//$_EXTRA_NOTICE = '';

define('_EXTRA_NOTICE', $extra_noitce);
?>
