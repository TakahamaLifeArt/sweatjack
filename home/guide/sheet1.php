<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/../app-def/initcontents2.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/../app-def/downloader.php';
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="euc-jp" />
	<title>デザイン用紙ダウンロード ｜ オリジナルパーカーのスウェットジャック</title>
	<meta name="description" content="オリジナルスウェットをデザインするときに使うデザイン用紙（パーカー用）は、ここからダウンロードできます。イラストレーター用、手書き用があります。オリジナルスウェットを作るならスウェットジャックへ" />
	<meta name="keywords" content="スウェット,オリジナルスウェット,パーカー,オリジナルパーカー,プリント,デザイン,用紙,ダウンロード" />
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
					<h1>入稿テンプレート</h1>
				</div>

				<div class="section clearfix hidden-sm-down">
					<h2>イラレテンプレートをダウンロード</h2>
					<p class="comment"><span class="red_txt">※</span>ご利用の際には Adobe Illustratorがご必要です。</p>
					<div class="dl_more">
						<a href="#howto" class="next_btn_2">使い方はこちら</a>
						<a href="#caution" class="next_btn_2">注意点はこちら</a>
					</div>
					<div class="clearfix">
						<a href="/design/illust/tmp_tshirts.ai" class="box tmp_1" alt="tshirts" download="tmp_tshirts.ai">
							<p>Tシャツ</p>
						</a>
						<a href="/design/illust/tmp_longshirts.ai" class="box tmp_2" alt="longshirts" download="tmp_longshirts.ai">
							<p>ロングTシャツ</p>
						</a>
						<a href="/design/illust/tmp_poloshirts-pocket.ai" class="box tmp_3" alt="poloshirts-pocket" download="tmp_poloshirts-pocket.ai">
							<p>ポロシャツ（ﾎﾟｹ有）</p>
						</a>
						<a href="/design/illust/tmp_poloshirts.ai" class="box tmp_4" alt="poloshirts" download="tmp_poloshirts.ai">
							<p>ポロシャツ（ﾎﾟｹ無）</p>
						</a>
						<a href="/design/illust/tmp_trainer.ai" class="box tmp_5" alt="trainer" download="tmp_trainer.ai">
							<p>トレーナー</p>
						</a>
						<a href="/design/illust/tmp_parker.ai" class="box tmp_6" alt="parker" download="tmp_parker.ai">
							<p>プルオーバーパーカー</p>
						</a>
						<a href="/design/illust/tmp_zipparker.ai" class="box tmp_7" alt="zipparker" download="tmp_zipparker.ai">
							<p>ジップパーカー</p>
						</a>
						<a href="/design/illust/tmp_sweatpants.ai" class="box tmp_8" alt="sweatpants" download="tmp_sweatpants.ai">
							<p>スウェットパンツ</p>
						</a>
						<a href="/design/illust/tmp_halfpants.ai" class="box tmp_9" alt="halfpants" download="tmp_halfpants.ai">
							<p>ハーフパンツ</p>
						</a>
						<a href="/design/illust/tmp_blouson.ai" class="box tmp_10" alt="blouson" download="tmp_blouson.ai">
							<p>ブルゾン・ジャンパー</p>
						</a>
						<a href="/design/illust/tmp_cap.ai" class="box tmp_11" alt="cap" download="tmp_cap.ai">
							<p>キャップ・帽子</p>
						</a>
						<a href="/design/illust/tmp_towel.ai" class="box tmp_12" alt="towel" download="tmp_towel.ai">
							<p>タオル</p>
						</a>
					</div>
				</div>


				<div class="sp_display hidden-md-up">
					<h2>テンプレートダウンロード場所</h2>
					<p class="comment">イラレテンプレートをPCからダウンロードできます。是非ご利用くださいませ。</p>
					<div class="dl_place">
						<p>1. PCサイトのトップページの「デザイン」から「デザインの入稿・作り方」をクリックする。</p>
						<div class="sp_box">
							<img src="/img/dl_page/sp_temple_place.jpg" width="100%">
						</div>
					</div>

					<div class="dl_place">
						<p>2. 下にスクロールして「おすすめ」から「イラレテンプレート」をクリックする。</p>
						<div class="sp_box">
							<img src="/img/dl_page/sp_temple_support.jpg" width="100%">
						</div>
					</div>

					<div class="dl_place">
						<p>3. イラレテンプレートページで、テンプレートをダウンロードする。</p>
						<div class="sp_box">
							<img src="/img/dl_page/sp_temple_dl_page.jpg" width="100%">
						</div>
					</div>
				</div>


				<span id="howto" class="anchorlink"></span>
				<div>
					<h2>4STEPで簡単！使い方</h2>
					<div>
						<h3><span class="orange_txt">STEP1</span>　まずはダウンロード</h3>
						<p class="step_txt">使用したいアイテムを選びダウンロードのボタンをクリック！</p>
						<div class="step_img">
							<img src="/img/dl_page/sp_temple_dl.jpg" width="100%">
						</div>
					</div>
					<div>
						<h3><span class="orange_txt">STEP2</span>　サイズを選択</h3>
						<p class="step_txt">テンプレートを開き、着用する1番小さいサイズの絵型を選択レイヤーを操作して絵型を表示します。</p>
						<div class="step_inner">
							<div class="inner_left">
								<div class="red_box">絵型にデザインにのせるのは1サイズのみ</div>
								<div class="inner_img">
									<img src="/img/dl_page/sp_temple_size_01.png" width="100%">
								</div>
							</div>
							<div class="inner_right">
								<p class="top20_txt">多数サイズがあるお客様は注文する一番小さいサイズのみデザインを作成ください。</p>
								<p class="top20_txt">例：S、M、Lで作成する場合はSサイズのみレイヤーを表示しデザインをのせてください。</p>
								<div class="inner_img_2">
									<img src="/img/dl_page/sp_temple_size_02.png" width="100%">
								</div>
							</div>
						</div>
					</div>
					<div>
						<h3><span class="orange_txt">STEP3</span>　新規レイヤーを作成し、オリジナルデザインを絵型に配置</h3>
						<p class="step_txt">新しいレイヤーを1番上に作成し、名前を「デザイン」にして作成します。下の「プリントサイズ枠」を参照にデザインの大きさを調整して、プリン トを希望する位置に配置します。
						</p>
						<p class="min_txt">
							<sapn class="red">※</sapn>アイテムやサイズによってはご希望にそえない場合がございます。</p>
						<div class="step_inner">
							<div class="inner_left">
								<div class="red_txt">�／卦�レイヤー<br>「デザイン」を作成</div>
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
						<h3><span class="orange_txt">STEP4</span>　インクのカラーを配置</h3>
						<p class="step_txt">左から希望のインクのカラーを持ってきて、絵型の下に配置し、グラデーションが含まれる場合や写真は「フルカラー」を選択して保存します。</p>
						<div class="step_img">
							<img src="/img/dl_page/sp_temple_ink.png" width="100%">
						</div>
					</div>
				</div>


				<span id="caution" class="anchorlink"></span>
				<div>
					<h2>7つの注意点</h2>
					<p>イラレテンプレートを使う前にデザインの注意点をご確認ください。</p>
					<div class="caution_wrapper">
						<div class="caution_box">
							<p class="caution_ttl">1.カラーモードはCMYKになっていますか？</p>
							<div class="gray_back"><img src="/img/dl_page/sp_temple_point_01.png" width="100%"></div>
						</div>
						<div class="caution_box">
							<p class="caution_ttl">2.デザインはプリントする原寸の大きさですか？</p>
							<div class="gray_back"><img src="/img/dl_page/sp_temple_point_02.png" width="100%"></div>
						</div>
					</div>
					<div class="caution_wrapper">
						<div class="caution_box">
							<p class="caution_ttl">3.画像は埋め込まれていますか？</p>
							<div class="gray_back"><img src="/img/dl_page/sp_temple_point_03.png" width="100%"></div>
						</div>
						<div class="caution_box">
							<p class="caution_ttl">4.線の太さは0.3ｍｍ、隙間は1ｍｍありますか?</p>
							<div class="gray_back"><img src="/img/dl_page/sp_temple_point_04.png" width="100%"></div>
						</div>
					</div>
					<div class="caution_wrapper">
						<div class="caution_box">
							<p class="caution_ttl">5.テキストと線はアウトライン化されていますか？</p>
							<div class="gray_back"><img src="/img/dl_page/sp_temple_point_05.png" width="100%"></div>
						</div>
						<div class="caution_box">
							<p class="caution_ttl">6.ワープツール使用のデザインは分割しましたか？</p>
							<div class="gray_back"><img src="/img/dl_page/sp_temple_point_06.png" width="100%"></div>
						</div>
					</div>
					<div class="caution_wrapper_2">
						<div class="caution_box">
							<p class="caution_ttl">7.Illustratorの形式はCS?CS6ですか？</p>
							<div class="gray_back"><img src="/img/dl_page/sp_temple_point_07.png" width="100%"></div>
						</div>
					</div>
					<p class="bold_last_txt">疑問点はお電話またはメールでお気軽にお問い合わせください！</p>
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
