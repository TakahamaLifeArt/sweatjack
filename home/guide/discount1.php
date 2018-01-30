<?php require_once $_SERVER['DOCUMENT_ROOT'].'/../app-def/initcontents2.php'; ?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="euc-jp" />
	<title>割引の使い方 ｜ オリジナルパーカーのスウェットジャック</title>
	<meta name="description" content="オリジナルスウェットをお得に作る”割引”が盛りだくさん！学割をはじめ、ほかの割引と併用可能なものも。オリジナルスウェットを作るならスウェットジャックへ" />
	<meta name="keywords" content="スウェット,オリジナルスウェット,パーカー,オリジナルパーカー,プリント,割引,学割,お得" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<meta http-equiv="Content-Script-Type" content="text/javascript" />
	<link rel="shortcut icon" href="/icon/favicon.ico" />
	<link href="../css/template1.css" rel="stylesheet" type="text/css" media="screen" />
	<link rel='stylesheet' id='contact-form-7-css' href='../css/header-footer_responsive.css' type='text/css' media='all' />
	<link href="../css/discount1.css" rel="stylesheet" type="text/css" media="screen" />

	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/util.js"></script>


	<script type="text/javascript">
		jQuery(function($) {

			var nav = $('#fixedBox'),
				offset = nav.offset();

			$(window).scroll(function() {
				if ($(window).scrollTop() > offset.top) {
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
	<script>
		(function(w, d, s, l, i) {
			w[l] = w[l] || [];
			w[l].push({
				'gtm.start': new Date().getTime(),
				event: 'gtm.js'
			});
			var f = d.getElementsByTagName(s)[0],
				j = d.createElement(s),
				dl = l != 'dataLayer' ? '&l=' + l : '';
			j.async = true;
			j.src =
				'//www.googletagmanager.com/gtm.js?id=' + i + dl;
			f.parentNode.insertBefore(j, f);
		})(window, document, 'script', 'dataLayer', 'GTM-KZ5DQL');

	</script>
	<!-- End Google Tag Manager -->

	<script>
		(function(i, s, o, g, r, a, m) {
			i['GoogleAnalyticsObject'] = r;
			i[r] = i[r] || function() {
				(i[r].q = i[r].q || []).push(arguments)
			}, i[r].l = 1 * new Date();
			a = s.createElement(o),
				m = s.getElementsByTagName(o)[0];
			a.async = 1;
			a.src = g;
			m.parentNode.insertBefore(a, m)
		})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

		ga('create', 'UA-11155922-6', 'auto');
		ga('send', 'pageview');

	</script>

	<div id="wrapper-all">
		<header class="site-header">
			<?php echo $header; ?>


			<div id="fixedBox" class="nav">
				<nav id="global-navigation">
					<?php echo $menu; ?>
				</nav>
			</div>
		</header>

		<div class="container">

			<div class="contents">

				<?php echo $msgbar; ?>

				<div class="notes_wrapper">


					<div id="main">

						<h2 class="titlelogo">割引プラン</h2>
						<div class="dis_title">
							<p>タカハマライフアートでは、お得な割引プランをご用意しています。</p>
							<p>最大13%＋1000円の大幅割引となっておりますので、ぜひご利用ください。</p>
						</div>

						<div class="big_ttl">
							<h2 class="lines-on-sides">学割</h2>
							<div class="content">
								<img class="discount_img" src="../img/guide/discount/sp_discount_student.jpg" alt="学割" width="100%">
								<div class="content_right">
									<p class="off">3%OFF</p>
									<p>学生（幼・保・小・中・高・専・短・大・院）の方に 適用されるプランです。
									</p>
									<h4>使用方法：</h4>
									<p>注文時に学校名の提示をお願いします。</p>
								</div>
							</div>
						</div>

						<div class="big_ttl">
							<h2 class="lines-on-sides">写真掲載割</h2>
							<div class="content">
								<img class="discount_img" src="../img/guide/discount/sp_discount_photo.jpg" alt="写真掲載割" width="100%">
								<div class="content_right">
									<p class="off">3%OFF</p>
									<p>ご注文の着用写真、または商品写真をWEB掲載可能な方に 適用されるプランです。
									</p>
									<h4>使用方法：</h4>
									<p>購入後お送りするメールのアンケートにて、写真とご感想をお送りください。</p>
								</div>
							</div>
						</div>

						<div class="big_ttl">
							<h2 class="lines-on-sides">そのままプリント割</h2>
							<div class="content">
								<img class="discount_img" src="../img/guide/discount/sp_discount_print.jpg" alt="そのままプリント割" width="100%">
								<div class="content_right">
									<p class="off">1000円OFF</p>
									<p>お客様の入稿したデータが、修正無しで使用できる場合に適用されるプランです。 お客様が修正した場合は、再入稿でも利用可能となっております。 データの拡大縮小は無料で行います。
									</p>
									<h4>使用方法：</h4>
									<p>注文確定のお電話にて、デザインのお打ち合わせを致します。 割引ご希望のお客様は、お打ち合わせ時にお伝えください。
									</p>
								</div>
							</div>
						</div>

					</div>

				</div>
				<!-- /clearfix -->



				<p class="page_top"><span>割引の使い方　ページトップへ</span></p>

			</div>
			<!-- /contents -->

		</div>

		<footer>
			<div class="footer-wrapper">
				<?php echo $footer; ?> </div>
		</footer>
	</div>
	<!-- /wrapper-all-->

	<script type="text/javascript">
		(function() {
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
