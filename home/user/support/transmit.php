<?php
	require_once dirname(__FILE__).'/../php_libs/funcs.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/../app-def/initcontents2.php';
/**
 * 仮パスワード送信
 */
ini_set('memory_limit', '128M');
require_once dirname(__FILE__).'/../php_libs/mailer.php';
require_once dirname(__FILE__).'/../php_libs/conndb.php';

if( isset($_REQUEST['ticket'], $_REQUEST['u']) ) {
	$conndb = new Conndb(_API_U);
	
	$newpass = substr(sha1(time().mt_rand()),0,10);
	$args = array('userid'=>$_REQUEST['u'], 'pass'=>$newpass);
	$res = $conndb->updatePass($args);
	if($res){
		$dat = $conndb->getUserList($_REQUEST['u']);
		$args = array('email'=>$dat[0]['email'], 'newpass'=>$newpass, 'username'=>$dat[0]['customername']);
		$mailer = new Mailer($args);
		$isSend = $mailer->send_pass();
	}
}
/*
else{
	unset($_SESSION['ticket']);
	header("Location: "._DOMAIN);
}
*/
/* セッションの使用を廃止
if($isSend){
	unset($_SESSION['ticket']);
}
*/
	
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="EUC-JP" />
	<meta name="description" content=リジナルパーカー・スウェットお客様マイページ仮パスワード発行はこちらから。パスワードをお忘れのお客様に仮パスワードをお送りいたします！スタッフTシャツ、イベントTシャツの作成は短納期で早いオリジナルパーカーのスウェットジャックへ。">
	<meta name="keywords" content="リジナルパーカー・スウェット,パスワード発行,即日,ログイン,お客様情報">
	<meta name="viewport" content="width=device-width,user-scalable=no,maximum-scale=1" />
	<title>メール送信 | リジナルパーカー・スウェット</title>
	<link rel="shortcut icon" href="/icon/favicon.ico" />
<!-- css -->
	<link rel="stylesheet" type="text/css" href="/css/lazyboard_responsive.css" media="all" />
	<link rel='stylesheet' id='contact-form-7-css'  href='/css/header-footer_responsive.css' type='text/css' media='all' />
	<link rel='stylesheet' id='contact-form-7-css'  href='/css/newtop_responsive.css' type='text/css' media='all' />

	<link rel="stylesheet" type="text/css" media="screen" href="../css/style_responsive.css" />
	<link rel="stylesheet" type="text/css" href="./css/finish_responsive.css" media="screen" />

	<link rel="stylesheet" type="text/css" media="screen" href="/common/js/modalbox/css/jquery.modalbox.css">
	<!-- m2 -->
  <link rel="stylesheet" type="text/css" href="/m2/css/top1_responsive.css" media="all">
  <link rel="stylesheet" type="text/css" href="/m2/common/css/common1_responsive.css" media="all">

<!--calendar-->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/jquery-ui.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
	<script src="//ajaxzip3.github.io/ajaxzip3.js" charset="utf-8"></script>

		<script src="/js/jquery.mmenu.min.all.js"></script>
  	<script type="text/javascript" src="/calendar/js/deliveryday.js"></script>


</head>

<body class="home page page-id-141 page-template page-template-home page-template-home-php full-width">

		<!-- Google Tag Manager -->
		<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-T5NQFM"
		height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-T5NQFM');</script>
		<!-- End Google Tag Manager -->

	<div>
			<header class="site-header"><?php echo $header; ?>			
				<div  id="fixedBox" class="nav">
					<nav id="global-navigation"><?php echo $menu; ?></nav>	
				</div>
			</header>
	</div>

<!-- m2 begin-->
<div id="m2_header">
<h1>オリジナルアイテムプリント・作成！</h1>
<?php 
		$php = file_get_contents($_SERVER['DOCUMENT_ROOT']."/m2/common/inc/headinc1.html");
		eval('?>'. mb_convert_encoding($php, 'euc-jp', 'UTF-8'). '<?');
?>

<nav id="global-navigation"><?php 
		$php = file_get_contents($_SERVER['DOCUMENT_ROOT']."/m2/common/inc/gnav1.html");
		eval('?>'. mb_convert_encoding($php, 'euc-jp', 'UTF-8'). '<?');
?></nav>
</div>
<!-- m2 end-->	
	<div id="container">

			<div class="contents">
			
			<?php
				$cst = 'cst';
				function cst($constant){
					return $constant;
				}
				if($isSend){
					$heading = '仮パスワードを送信しています。<br>ご確認ください！';
					$sub = 'Sending';
					$html = <<<DOC
				<div class="inner">
					<p>この度はオリジナルパーカーのスウェットジャックをご利用いただき、誠にありがとうございます。</p>
					<p>仮パスワードは、ログイン後にマイページで変更できます。</p>
				</div>
				<div class="inner">
					<h3>【 <span class="highlights">メールが届かない場合</span> 】</h3>
					<p>
						お客様が入力されました {$args['email']} 宛てに確認メールを返信しておりますが。届かない場合には、<br>
						お手数ですが下記の連絡先までお問い合わせください。<br>
						お急ぎのお客様は、フリーダイヤル {$cst(_TOLL_FREE)} までお気軽にご連絡ください。
					</p>
					<p id="pcpage"><a href="/customer/contact1.php">メールでのお問い合わせはこちらから</a></p>
					<hr />
					<p class="gohome"><a href="/">ホームページに戻る</a></p>
				</div>
DOC;

				}else{
					$heading = '送信エラー！';
					$sub = 'Error';
					$html = <<<DOC
				<div class="inner">
					<div class="remarks">
						<p><strong>メールの送信が出来ませんでした。</strong></p>
						<p>メールの送信中にエラーが発生いたしました。</p>
					</div>
					<p>恐れ入りますが、再度 [ 送信 ] ボタンをクリックして下さい。</p>
				</div>
				<div class="inner">
					<h3>【 親切対応でしっかりサポート 】</h3>
					<p class="note">お急ぎのお客様は、フリーダイヤル {$cst(_TOLL_FREE)} までお気軽にご連絡ください。</p>
					<p id="pcpage"><a href="/customer/contact1.php">メールでのお問い合わせはこちらから</a></p>
					<hr />
					<p class="gohome"><a href="/">ホームページに戻る</a></p>
				</div>
DOC;
				}
			?>
			
			<div class="heading1_wrapper">
				<h2 class="heading2"><?php echo $heading;?></h2>
				<p class="comment"></p>
				<p class="sub"><?php echo $sub;?></p>
			</div>
			<?php echo $html;?>
		</div>

	

			</section>
		</div>
	<footer>
		<div id="pcpage">
			<div class="other">
				<div id="othermenu"><h2 class="header-home"><span><a href="">other</a></span></h2>
					<section class="home-company">
						<h4><a href="/company/company1.php">企業情報</a></h4>
					</section>
					<section class="home-guide">
						<h4><a href="/customer/contact1.php">お問い合わせ</a></h4>
					</section>
					<section class="home-info">
						<h4><a href="/faq/index1.php">Q&A</a></h4>
					</section>
					<section class="home-order">
						<h4><a href="/guide/guide1.php">ご注文の流れ</a></h4>
					</section>
					<section class="home-design">
						<h4><a href="/guide/design_tech1.php">デザインの作り方</a></h4>
					</section>
				</div>
				<div class="caler">
					<div class="calendar_wrapper">
	          <div id="datepicker"></div>
	          <p class="openhours">営業時間　10:00~18:00（月~金）</p>
	          <p><span class="fontred">※</span>定休日：土・日・祝</p>
					</div>
				</div>	
			</div>
			<div class="footer-wrapper"><?php echo $footer; ?> </div>
		</div>
		<div id="phonepage">
			<div class="footer-wrapper">
<!--m2 begin-->
				<?php
					$php = file_get_contents($_SERVER['DOCUMENT_ROOT']."/m2/common/inc/footer1.html");
					eval('?>'. mb_convert_encoding($php, 'euc-jp', 'UTF-8'). '<?');
				?>
<!--m2 end-->
			</div>
		</div>
	</footer>

<!--Yahoo!タグマネージャー導入 2014.04 -->
<script type="text/javascript">
  (function () {
    var tagjs = document.createElement("script");
    var s = document.getElementsByTagName("script")[0];
    tagjs.async = true;
    tagjs.src = "//s.yjtag.jp/tag.js#site=bTZi1c8";
    s.parentNode.insertBefore(tagjs, s);
  }());
</script>
<noscript>
  <iframe src="//b.yjtag.jp/iframe?c=bTZi1c8" width="1" height="1" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
</noscript>
	
</body>
</html>
