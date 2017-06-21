<?php
	ini_set('memory_limit', '128M');
	require_once $_SERVER['DOCUMENT_ROOT'].'/../app-def/initcontents2.php';
	require_once dirname(__FILE__).'/../php_libs/orders.php';
	require_once dirname(__FILE__).'/ordermail.php';
	
	if( isset($_POST['ticket'], $_SESSION['ticket'], $_SESSION['orders']) && $_POST['ticket']==$_SESSION['ticket'] ) {
		$email = $_SESSION['orders']['customer']['email'];
		$customer = mb_convert_encoding($_SESSION['orders']['customer']['customername'], 'euc-jp', auto);
		$ordermail = new Ordermail();
		$isSend = $ordermail->send();
	}else{
		$isSend = false;
	}
 	
 	/* 注文フローのセッションを破棄 */
	if($isSend){
		unset($_SESSION['ticket']);
		$_SESSION['orders'] = array();
//		setcookie(session_name(), "", time()-86400, "/");
		unset($_SESSION['orders']);
	}
	
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="euc-jp" />
	<title>お申し込みメール送信完了　|　オリジナルパーカーのスウェットジャック</title>
    <meta name="description" content="オリジナルパーカーのご注文はこちらから。オーダーフォームに入力すると見積も自動でできる！オーダー前に予算がわかり安心です。オリジナルスウェットを作るならスウェットジャックへ" />
    <meta name="keywords" content="スウェット,オリジナルスウェット,パーカー,オリジナルパーカー,プリント,注文,オーダーフォーム" />
<!--m2 begin-->
	<meta name="viewport" content="width=device-width,user-scalable=no,maximum-scale=1" />
<!--m2 end-->

	<link rel="shortcut icon" href="/icon/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="/css/template1_responsive.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="./css/finish1_responsive.css" media="screen" />
	<link rel='stylesheet' id='contact-form-7-css'  href='../css/header-footer_responsive.css' type='text/css' media='all' />
<!--m2 begin-->
    <link rel="stylesheet" type="text/css" href="/m2/common/css/common1_responsive.css" media="all">
<!--m2 end--> 

	<script type="text/javascript" src="/js/jquery.js"></script>
	<script type="text/javascript" src="/js/util.js"></script>
	<script type="text/javascript">
		jQuery(function($) {
		  
		var nav    = $('#fixedBox'),
		    offset = nav.offset();
		  
		$(window).scroll(function () {
		  if($(window).scrollTop() > offset.top) {
		    nav.addClass('fixed');
		  } else {
		    nav.removeClass('fixed');
		  }
		});
		  
		});
	</script>

	<style>

		.fixed {
		    position: fixed;
		    top: 0;
		    width: 100%;
		    z-index: 10000;
		}

	</style>

</head>

<body>
	<!-- Google Tag Manager -->
	<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-KZ5DQL"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-KZ5DQL');</script>
	<!-- End Google Tag Manager -->

	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	
	  ga('create', 'UA-11155922-6', 'auto');
	  ga('send', 'pageview');
	
	</script>

<div id="wrapper-all">
		<header class="site-header"><?php echo $header; ?>			

				
			<div  id="fixedBox" class="nav">
				<nav id="global-navigation"><?php echo $menu; ?></nav>	
			</div>
</header>
<!-- m2 begin-->
<div id="m2_header">
<h1>オリジナルスウェットならスウェットジャック!</h1>
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
				echo $msgbar;
				
				$cst = 'cst';
				function cst($constant){
					return $constant;
				}
				
				if($isSend){
					$heading = 'お申し込み内容の確認メールを返信中です。<br>必ずご確認ください！';
					$html = <<<DOC
				<div class="inner">
					<p>{$customer}　様</p>
					<p>この度はタカハマライフアートをご利用いただき、誠にありがとうございます。</p>
				</div>
				
				<div class="remarks">
					<h3>制作の開始について</h3>
					<p>現時点では、<span class="highlights">ご注文は確定していません。</span></p>
					<p>
						制作を開始するにあたり、お電話によるデザインの確認をもって注文確定とさせていただいております。<br>
						弊社から御見積りメールをお送りいたしますので、
						大変お手数ですが、ご確認後フリーダイヤル<ins> {$cst(_TOLL_FREE)} </ins>までご連絡ください。
					</p>
				</div>
				
				<div class="inner">
					<h3>【 <span class="highlights">確認メールが届かない場合</span> 】</h3>
					<p>
						ご入力頂いたメールアドレス {$email} 宛に、お申し込み内容の確認メールを送信しています。<br>
						お客様に確認メールが届いていない場合、弊社にお申し込みメールが届いていない可能性がございますので、<br>
						恐れ入りますが、フリーダイヤル<ins> {$cst(_TOLL_FREE)} </ins>までお問い合わせ下さい。
					</p>
				</div>
				
				<div class="inner">
					<h3>【 ご注文に関するお問い合わせ 】</h3>
					<p>
						お急ぎのお客様は、フリーダイヤル {$cst(_TOLL_FREE)} までお気軽にご連絡ください。
					</p>
					<p><a href="/customer/contact1.php">メールでのお問い合わせはこちらから</a></p>
					<hr />
					<p class="gohome"><a href="/">ホームページに戻る</a></p>
				</div>

DOC;
				}else{
					$heading = '送信エラー！';
					$html = <<<DOC
				<div class="inner">
					<p>{$customer}　様</p>
					<div class="remarks">
						<h3>お申し込みメールの送信が出来ませんでした。</h3>
						<p>お申し込みメールの送信中にエラーが発生いたしました。</p>
					</div>
					<p>恐れ入りますが、再度 <a href="/order/">お申し込みフォーム</a> に戻り [ 注文する ] ボタンをクリックして下さい。</p>
				</div>
				<div class="inner">
					<h3>【 ご注文に関するお問い合わせ 】</h3>
					<p class="note">お急ぎのお客様は、フリーダイヤル {$cst(_TOLL_FREE)} までお気軽にご連絡ください。</p>
					<p><a href="/customer/contact1.php">メールでのお問い合わせはこちらから</a></p>
					<hr />
					<p class="gohome"><a href="/order/">お申し込みフォームに戻る</a></p>
				</div>
DOC;
				}
				
			?>
			
			<div class="heading1_wrapper">
				<h1><?php echo $heading;?></h1>
				<p class="comment"></p>
			</div>
			<p class="heading"></p>
			<div class="wrap">
				<?php echo $html;?>
			</div>
		</div>
		
	</div>
	
	<p class="page_top"><span>お申し込みメールの送信完了　ページトップへ</span></p>

	
	<footer>
<!-- m2 begin -->
		<div class="footer-wrapper" id="pcpage"><?php echo $footer; ?> </div>
		<div class="footer-wrapper" id="phonepage"><?php
			$php = file_get_contents($_SERVER['DOCUMENT_ROOT']."/m2/common/inc/footer1.html");
			eval('?>'. mb_convert_encoding($php, 'euc-jp', 'UTF-8'). '<?');
		?>
	</div>
<!-- m2 end -->
	</footer>
    </div><!-- /wrapper-all-->

	<script type="text/javascript">
	  (function () {
		var tagjs = document.createElement("script");
		var s = document.getElementsByTagName("script")[0];
		tagjs.async = true;
		tagjs.src = "//s.yjtag.jp/tag.js#site=gfjjZ2r";
		s.parentNode.insertBefore(tagjs, s);
	  }());
	</script>
	<noscript>
	  <iframe src="//b.yjtag.jp/iframe?c=gfjjZ2r" width="1" height="1" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
	</noscript>
<script type="text/javascript">
  (function () {
    var tagjs = document.createElement("script");
    var s = document.getElementsByTagName("script")[0];
   　tagjs.async = true;
    tagjs.src = "//s.yjtag.jp/tag.js#site=gfjjZ2r";
    s.parentNode.insertBefore(tagjs, s);
  }());
</script>
<noscript>
<iframe src="//b.yjtag.jp/iframe?c=gfjjZ2r" width="1" height="1" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
</noscript>

</body>
</html>
