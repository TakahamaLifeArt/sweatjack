<?php require_once $_SERVER['DOCUMENT_ROOT'].'/../app-def/initcontents2.php'; ?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="euc-jp" />
	<title>����λȤ��� �� ���ꥸ�ʥ�ѡ������Υ������åȥ���å�</title>
	<meta name="description" content="���ꥸ�ʥ륹�����åȤ����˺��ɳ���ɤ�����������󡪳س��Ϥ��ᡢ�ۤ��γ����ʻ�Ѳ�ǽ�ʤ�Τ⡣���ꥸ�ʥ륹�����åȤ���ʤ饹�����åȥ���å���" />
	<meta name="keywords" content="�������å�,���ꥸ�ʥ륹�����å�,�ѡ�����,���ꥸ�ʥ�ѡ�����,�ץ���,���,�س�,����" />
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

						<h2 class="titlelogo">����ץ��</h2>
						<div class="dis_title">
							<p>�����ϥޥ饤�ե����ȤǤϡ������ʳ���ץ����Ѱդ��Ƥ��ޤ���</p>
							<p>����13%��1000�ߤ���������ȤʤäƤ���ޤ��Τǡ����Ҥ����Ѥ���������</p>
						</div>

						<div class="big_ttl">
							<h2 class="lines-on-sides">�س�</h2>
							<div class="content">
								<img class="discount_img" src="../img/guide/discount/sp_discount_student.jpg" alt="�س�" width="100%">
								<div class="content_right">
									<p class="off">3%OFF</p>
									<p>�������ġ��ݡ������桦�⡦�졦û���硦���ˤ����� Ŭ�Ѥ����ץ��Ǥ���
									</p>
									<h4>������ˡ��</h4>
									<p>��ʸ���˳ع�̾���󼨤򤪴ꤤ���ޤ���</p>
								</div>
							</div>
						</div>

						<div class="big_ttl">
							<h2 class="lines-on-sides">�̿��Ǻܳ�</h2>
							<div class="content">
								<img class="discount_img" src="../img/guide/discount/sp_discount_photo.jpg" alt="�̿��Ǻܳ�" width="100%">
								<div class="content_right">
									<p class="off">3%OFF</p>
									<p>����ʸ�����Ѽ̿����ޤ��Ͼ��ʼ̿���WEB�Ǻܲ�ǽ������ Ŭ�Ѥ����ץ��Ǥ���
									</p>
									<h4>������ˡ��</h4>
									<p>�����太���ꤹ��᡼��Υ��󥱡��Ȥˤơ��̿��Ȥ����ۤ����꤯��������</p>
								</div>
							</div>
						</div>

						<div class="big_ttl">
							<h2 class="lines-on-sides">���Τޤޥץ��ȳ�</h2>
							<div class="content">
								<img class="discount_img" src="../img/guide/discount/sp_discount_print.jpg" alt="���Τޤޥץ��ȳ�" width="100%">
								<div class="content_right">
									<p class="off">1000��OFF</p>
									<p>�����ͤ����Ƥ����ǡ�����������̵���ǻ��ѤǤ������Ŭ�Ѥ����ץ��Ǥ��� �����ͤ������������ϡ������ƤǤ����Ѳ�ǽ�ȤʤäƤ���ޤ��� �ǡ����γ���̾���̵���ǹԤ��ޤ���
									</p>
									<h4>������ˡ��</h4>
									<p>��ʸ����Τ����äˤơ��ǥ�����Τ��Ǥ���碌���פ��ޤ��� �������˾�Τ����ͤϡ����Ǥ���碌���ˤ���������������
									</p>
								</div>
							</div>
						</div>

					</div>

				</div>
				<!-- /clearfix -->



				<p class="page_top"><span>����λȤ������ڡ����ȥåפ�</span></p>

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
