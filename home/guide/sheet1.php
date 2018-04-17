<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/../app-def/initcontents2.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/../app-def/downloader.php';
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="euc-jp" />
	<title>�ǥ������ѻ��������� �� ���ꥸ�ʥ�ѡ������Υ������åȥ���å�</title>
	<meta name="description" content="���ꥸ�ʥ륹�����åȤ�ǥ����󤹤�Ȥ��˻Ȥ��ǥ������ѻ�ʥѡ������ѡˤϡ����������������ɤǤ��ޤ������饹�ȥ졼�����ѡ�����Ѥ�����ޤ������ꥸ�ʥ륹�����åȤ���ʤ饹�����åȥ���å���" />
	<meta name="keywords" content="�������å�,���ꥸ�ʥ륹�����å�,�ѡ�����,���ꥸ�ʥ�ѡ�����,�ץ���,�ǥ�����,�ѻ�,���������" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<meta http-equiv="Content-Script-Type" content="text/javascript" />
	<link rel="shortcut icon" href="/icon/favicon.ico" />
	<link rel='stylesheet' id='contact-form-7-css' href='../css/header-footer_responsive.css' type='text/css' media='all' />
	<link href="../css/temple.css" rel="stylesheet" type="text/css" media="screen" />

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

		<div id="container">
			<div class="contents">
				<div class="heading1_wrapper">
					<h1>���ƥƥ�ץ졼��</h1>
				</div>

				<div class="section clearfix hidden-sm-down">
					<h2>�����ƥ�ץ졼�Ȥ���������</h2>
					<p class="comment"><span class="red_txt">��</span>�����Ѥκݤˤ� Adobe Illustrator����ɬ�פǤ���</p>
					<div class="dl_more">
						<a href="#howto" class="next_btn_2">�Ȥ����Ϥ�����</a>
						<a href="#caution" class="next_btn_2">������Ϥ�����</a>
					</div>
					<div class="clearfix">
						<a href="/design/illust/tmp_tshirts.ai" class="box tmp_1" alt="tshirts" download="tmp_tshirts.ai">
							<p>T�����</p>
						</a>
						<a href="/design/illust/tmp_longshirts.ai" class="box tmp_2" alt="longshirts" download="tmp_longshirts.ai">
							<p>���T�����</p>
						</a>
						<a href="/design/illust/tmp_poloshirts-pocket.ai" class="box tmp_3" alt="poloshirts-pocket" download="tmp_poloshirts-pocket.ai">
							<p>�ݥ���ġʎΎߎ�ͭ��</p>
						</a>
						<a href="/design/illust/tmp_poloshirts.ai" class="box tmp_4" alt="poloshirts" download="tmp_poloshirts.ai">
							<p>�ݥ���ġʎΎߎ�̵��</p>
						</a>
						<a href="/design/illust/tmp_trainer.ai" class="box tmp_5" alt="trainer" download="tmp_trainer.ai">
							<p>�ȥ졼�ʡ�</p>
						</a>
						<a href="/design/illust/tmp_parker.ai" class="box tmp_6" alt="parker" download="tmp_parker.ai">
							<p>�ץ륪���С��ѡ�����</p>
						</a>
						<a href="/design/illust/tmp_zipparker.ai" class="box tmp_7" alt="zipparker" download="tmp_zipparker.ai">
							<p>���åץѡ�����</p>
						</a>
						<a href="/design/illust/tmp_sweatpants.ai" class="box tmp_8" alt="sweatpants" download="tmp_sweatpants.ai">
							<p>�������åȥѥ��</p>
						</a>
						<a href="/design/illust/tmp_halfpants.ai" class="box tmp_9" alt="halfpants" download="tmp_halfpants.ai">
							<p>�ϡ��եѥ��</p>
						</a>
						<a href="/design/illust/tmp_blouson.ai" class="box tmp_10" alt="blouson" download="tmp_blouson.ai">
							<p>�֥륾�󡦥����ѡ�</p>
						</a>
						<a href="/design/illust/tmp_cap.ai" class="box tmp_11" alt="cap" download="tmp_cap.ai">
							<p>����åס�˹��</p>
						</a>
						<a href="/design/illust/tmp_towel.ai" class="box tmp_12" alt="towel" download="tmp_towel.ai">
							<p>������</p>
						</a>
					</div>
				</div>


				<div class="sp_display hidden-md-up">
					<h2>�ƥ�ץ졼�ȥ�������ɾ��</h2>
					<p class="comment">�����ƥ�ץ졼�Ȥ�PC�����������ɤǤ��ޤ����������Ѥ��������ޤ���</p>
					<div class="dl_place">
						<p>1. PC�����ȤΥȥåץڡ����Ρ֥ǥ�����פ���֥ǥ���������ơ�������פ򥯥�å����롣</p>
						<div class="sp_box">
							<img src="/img/dl_page/sp_temple_place.jpg" width="100%">
						</div>
					</div>

					<div class="dl_place">
						<p>2. ���˥������뤷�ơ֤�������פ���֥����ƥ�ץ졼�ȡפ򥯥�å����롣</p>
						<div class="sp_box">
							<img src="/img/dl_page/sp_temple_support.jpg" width="100%">
						</div>
					</div>

					<div class="dl_place">
						<p>3. �����ƥ�ץ졼�ȥڡ����ǡ��ƥ�ץ졼�Ȥ��������ɤ��롣</p>
						<div class="sp_box">
							<img src="/img/dl_page/sp_temple_dl_page.jpg" width="100%">
						</div>
					</div>
				</div>


				<span id="howto" class="anchorlink"></span>
				<div>
					<h2>4STEP�Ǵ�ñ���Ȥ���</h2>
					<div>
						<h3><span class="orange_txt">STEP1</span>���ޤ��ϥ��������</h3>
						<p class="step_txt">���Ѥ����������ƥ�����ӥ�������ɤΥܥ���򥯥�å���</p>
						<div class="step_img">
							<img src="/img/dl_page/sp_temple_dl.jpg" width="100%">
						</div>
					</div>
					<div>
						<h3><span class="orange_txt">STEP2</span>��������������</h3>
						<p class="step_txt">�ƥ�ץ졼�Ȥ򳫤������Ѥ���1�־������������γ���������쥤�䡼�����Ƴ�����ɽ�����ޤ���</p>
						<div class="step_inner">
							<div class="inner_left">
								<div class="red_box">�����˥ǥ�����ˤΤ���Τ�1�������Τ�</div>
								<div class="inner_img">
									<img src="/img/dl_page/sp_temple_size_01.png" width="100%">
								</div>
							</div>
							<div class="inner_right">
								<p class="top20_txt">¿�������������뤪���ͤ���ʸ������־������������Τߥǥ�������������������</p>
								<p class="top20_txt">�㡧S��M��L�Ǻ����������S�������Τߥ쥤�䡼��ɽ�����ǥ������Τ��Ƥ���������</p>
								<div class="inner_img_2">
									<img src="/img/dl_page/sp_temple_size_02.png" width="100%">
								</div>
							</div>
						</div>
					</div>
					<div>
						<h3><span class="orange_txt">STEP3</span>�������쥤�䡼������������ꥸ�ʥ�ǥ�����򳨷�������</h3>
						<p class="step_txt">�������쥤�䡼��1�־�˺�������̾����֥ǥ�����פˤ��ƺ������ޤ������Ρ֥ץ��ȥ������ȡפ򻲾Ȥ˥ǥ�������礭����Ĵ�����ơ��ץ�� �Ȥ��˾������֤����֤��ޤ���
						</p>
						<p class="min_txt">
							<sapn class="red">��</sapn>�����ƥ�䥵�����ˤ�äƤϤ���˾�ˤ����ʤ���礬�������ޤ���</p>
						<div class="step_inner">
							<div class="inner_left">
								<div class="red_txt">�������쥤�䡼<br>�֥ǥ�����פ����</div>
								<div class="inner_img">
									<img src="/img/dl_page/sp_temple_placement_01.png" width="100%">
								</div>
							</div>
							<div class="inner_right">
								<div class="inner_img_2">
									<img src="/img/dl_page/sp_temple_placement_02.jpg" width="100%">
								</div>
							</div>
						</div>
					</div>
					<div>
						<h3><span class="orange_txt">STEP4</span>�����󥯤Υ��顼������</h3>
						<p class="step_txt">�������˾�Υ��󥯤Υ��顼����äƤ��ơ������β������֤�������ǡ�����󤬴ޤޤ�����̿��ϡ֥ե륫�顼�פ����򤷤���¸���ޤ���</p>
						<div class="step_img">
							<img src="/img/dl_page/sp_temple_ink.png" width="100%">
						</div>
					</div>
				</div>


				<span id="caution" class="anchorlink"></span>
				<div>
					<h2>7�Ĥ������</h2>
					<p>�����ƥ�ץ졼�Ȥ�Ȥ����˥ǥ������������򤴳�ǧ����������</p>
					<div class="caution_wrapper">
						<div class="caution_box">
							<p class="caution_ttl">1.���顼�⡼�ɤ�CMYK�ˤʤäƤ��ޤ�����</p>
							<div class="gray_back"><img src="/img/dl_page/sp_temple_point_01.png" width="100%"></div>
						</div>
						<div class="caution_box">
							<p class="caution_ttl">2.�ǥ�����ϥץ��Ȥ��븶�����礭���Ǥ�����</p>
							<div class="gray_back"><img src="/img/dl_page/sp_temple_point_02.png" width="100%"></div>
						</div>
					</div>
					<div class="caution_wrapper">
						<div class="caution_box">
							<p class="caution_ttl">3.�����������ޤ�Ƥ��ޤ�����</p>
							<div class="gray_back"><img src="/img/dl_page/sp_temple_point_03.png" width="100%"></div>
						</div>
						<div class="caution_box">
							<p class="caution_ttl">4.����������0.3�����֤�1�����ޤ���?</p>
							<div class="gray_back"><img src="/img/dl_page/sp_temple_point_04.png" width="100%"></div>
						</div>
					</div>
					<div class="caution_wrapper">
						<div class="caution_box">
							<p class="caution_ttl">5.�ƥ����Ȥ����ϥ����ȥ饤�󲽤���Ƥ��ޤ�����</p>
							<div class="gray_back"><img src="/img/dl_page/sp_temple_point_05.png" width="100%"></div>
						</div>
						<div class="caution_box">
							<p class="caution_ttl">6.��ץġ�����ѤΥǥ������ʬ�䤷�ޤ�������</p>
							<div class="gray_back"><img src="/img/dl_page/sp_temple_point_06.png" width="100%"></div>
						</div>
					</div>
					<div class="caution_wrapper_2">
						<div class="caution_box">
							<p class="caution_ttl">7.Illustrator�η�����CS?CS6�Ǥ�����</p>
							<div class="gray_back"><img src="/img/dl_page/sp_temple_point_07.png" width="100%"></div>
						</div>
					</div>
					<p class="bold_last_txt">�������Ϥ����äޤ��ϥ᡼��Ǥ����ڤˤ��䤤��碌����������</p>
				</div>


			</div>
		</div>


		<footer>
			<div class="footer-wrapper"><?php echo $footer; ?></div>
		</footer>
	</div>

	<form name="downloader" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post" onSubmit="return false;">
		<input type="hidden" name="downloadfile" value="" />
		<input type="hidden" name="act" value="download" />
	</form>

</body>

</html>
