<?php
require_once dirname(__FILE__).'/php_libs/funcs.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/../app-def/initcontents2.php';

if($_SERVER['REQUEST_METHOD']!='POST'){
	setToken();
}else{
	chkToken();
	
	if(isset($_POST['resend'])){
		$conndb = new Conndb(_API_U);
		
		$param['email'] = trim(mb_convert_kana($_POST['email'],"s", "utf-8"));
		$args = array($param['email']);
		
		if(empty($param['email'])){
			$err['email'] = 'メールアドレスを入力して下さい。';
		}else if(!isValidEmailFormat($param['email'])){
			$err['email'] = 'メールアドレスが正しくありません。';
		}else{
			$user = $conndb->checkExistEmail($args);
			$userid = $user['id'];
			if(!$userid) $err['email'] = 'メールアドレスのご登録がありません。';
		}
		
		if(empty($err)) jump(_DOMAIN.'/user/support/transmit.php?ticket='.$_POST['token'].'&u='.$userid);
	}
	
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="euc-jp" />
<!-- m3 begin -->
	<meta name="viewport" content="width=device-width,user-scalable=no,maximum-scale=1" />
<!-- m3 end -->
	<title>パスワードを忘れた方 ｜ オリジナルパーカーのスウェットジャック</title>
	<meta name="Description" content="オリジナルパーカーのスウェットジャックを作るならスウェットジャックが早い！スウェットジャックをご利用のお客様へ、パスワードをお忘れですか？対処方法についての、ご案内をいたします。登録されたメールアドレスを入力してください。送信ボタンをクリックした後、登録された連絡先メールアドレス宛にお送り致します。">
	<meta name="keywords" content="オリジナル,tシャツ,パスワード">
	<link rel="shortcut icon" href="/icon/favicon.ico" />
<!-- css -->
	<link rel="stylesheet" type="text/css" href="/css/lazyboard_responsive.css" media="all" />
	<link rel='stylesheet' id='contact-form-7-css'  href='/css/header-footer_responsive.css' type='text/css' media='all' />
	<link rel='stylesheet' id='contact-form-7-css'  href='/css/newtop_responsive.css' type='text/css' media='all' />

	<link rel="stylesheet" type="text/css" media="screen" href="./css/style_responsive.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="./css/account_responsive.css" />

	<link rel="stylesheet" type="text/css" media="screen" href="/common/js/modalbox/css/jquery.modalbox.css">
	<!-- m2 -->
  <link rel="stylesheet" type="text/css" href="/m2/css/top1_responsive.css" media="all">
  <link rel="stylesheet" type="text/css" href="/m2/common/css/common1_responsive.css" media="all">
<!-- msgbox begin-->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/jquery-ui.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
	<script src="//ajaxzip3.github.io/ajaxzip3.js" charset="utf-8"></script>
<!-- msgbox end-->

	<script type="text/javascript" src="./js/common.js"></script>
	<script type="text/javascript" src="./js/resendpass.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
<!--calendar-->
	<script src="/js/jquery.mmenu.min.all.js"></script>
  	<script type="text/javascript" src="/calendar/js/deliveryday.js"></script>

	<!-- OGP -->
	<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#  website: http://ogp.me/ns/website#">
	<meta property="og:title" content="世界最速！？オリジナルTシャツを当日仕上げ！！" />
	<meta property="og:type" content="article" /> 
	<meta property="og:description" content="業界No. 1短納期でオリジナルTシャツを1枚から作成します。通常でも3日で仕上げます。" />
	<meta property="og:url" content="http://www.sweatjack.jp/" />
	<meta property="og:site_name" content="オリジナルパーカーのスウェットジャック" />
	<meta property="og:image" content="http://www.takahama428.com/common/img/header/Facebook_main.png" />
	<meta property="fb:app_id" content="1605142019732010" />
	<!--  -->
	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-11155922-2']);
		_gaq.push(['_trackPageview']);
		
		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	</script>
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
			<div class="toolbar">
				<div class="toolbar_inner clearfix">
					<div class="menu_wrap">
						<?php if(checkLogin()) echo $menu;?>
					</div>
					<h1>パスワードを忘れた方</h1>
				</div>
			</div>
			
			<div class="section">
				<form name="pass" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post" onsubmit="return false;">
					<table class="form_table me" id="pass_table">
						<caption>登録されたメールアドレスに仮パスワードを送信いたします。</caption>
						<tfoot>
							<tr>
								<td colspan="2">
									<input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
									<input type="hidden" name="resend" value="1">
									<p><span class="ok_button">送信</span></p>
								</td>
							</tr>
						</tfoot>
						<tbody>
							<tr>
								<th>メールアドレス</th>
								<td><input type="text" name="email" value="<?php echo $_POST['email'];?>"><br><ins class="err"> <?php echo $err['email']; ?></ins></td>
							</tr>
						</tbody>
					</table>
				</form>
			</div>
		</div>
	
	</div>
	
	<p class="scroll_top"><a href="#header">パスワードを忘れた方　ページトップへ</a></p>
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