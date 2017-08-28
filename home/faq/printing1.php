<?php require_once $_SERVER['DOCUMENT_ROOT'].'/../app-def/initcontents2.php'; ?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="euc-jp" />
	<title>プリントについて ｜ オリジナルパーカーのスウェットジャック</title>
	<meta name="description" content="プリントについてのご質問を解決いたします。こちらでご確認ください。オリジナルスウェットを作るならスウェットジャックへ" />
	<meta name="keywords" content="スウェット,オリジナルスウェット,パーカー,オリジナルパーカー,プリント,QA" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<meta http-equiv="Content-Script-Type" content="text/javascript" />
	<link rel="shortcut icon" href="/icon/favicon.ico" />
	<link rel="stylesheet" type="text/css" media="screen" href="../css/template1.css" />
	<link rel='stylesheet' id='contact-form-7-css' href='../css/header-footer_responsive.css' type='text/css' media='all' />
	<link rel="stylesheet" type="text/css" media="screen" href="../css/faq1.css" />

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

			<div class="contents inner">
				<?php echo $msgbar; ?>

				<h2 class="titlelogo">よくある質問</h2>

				<div class="section first">
					<h2 class="top_logo">プリントについて</h2>

					<div class="inner">
						<h3>縫い目や、ZIPをまたがってプリント、できますか？</h3>
						現在対応しておりません。(研究中ですので今しばらくお待ち下さいませ。)</p>
					</div>

					<div class="inner">
						<h3>シルクスクリーン？デジタルコピー転写？カッティングシート？どう違うの？</h3>
						<p><a href="/guide/print_guide.php">プリントの違いページ</a>を是非！<br /> プリントの質感をなんとかお伝えたくて撮影した写真と、それぞれのプリントの得意・ニガテをまとめました。また、どのプリント方法にするか、で、お値段も変わります。
						</p>
						<p>ご不明点ございましたら、お気軽にご相談ください！<br /> （フリーダイヤル <span class="fontred"><?php echo _TOLL_FREE; ?></span> ※平日10:00~18:00／土日祝休）</p>
					</div>

					<div class="inner" id="ans_03">
						<h3>1枚1枚を違うデザインにすると、高くなりますか？</h3>
						<p>（1）版の製作が必要のない、カッティングシートの場合。 低予算で、1枚1枚に違うデザインを入れられます。
							<br /> ただ、文字やお名前など、シンプルなシルエットのデザインに限られてしまいます。
							<br /> 詳しくは
							<a href="../guide/print_guide.php#cutting">カッティングシートページ</a>を。</p>
						<p>（2）シルクスクリーン、デジタルコピー転写の場合。 版（デザインの型）の製作がデザインの数だけ必要になりますので、 その分、大分、お値段がかかります。
						</p>
					</div>

					<div class="inner">
						<h3>できるかぎり大きくプリントしたい！何cmまでできますか？</h3>
						<p><span class="fontred">H43×W32cm、これが当店の最大プリント、ジャンボプリント</span>です。</p>
						<p>
							プリント方法はシルクスクリーンになります。業界の標準（通常）サイズの1.5倍（当店比）のド迫力です。<br />
							<a href="../gallery/gallery_body.php">ジャンボプリントの製作例</a>、公開中です！
						</p>
						<p>
							そのほか、<span class="fontred">シルクスクリーンプリントの通常サイズのMAXプリントサイズ</span>は<span class="fontred">H35×W27cm以内</span>、
						</p>
						<p>
							<span class="fontred">デジタルコピー転写のMAXプリントサイズ</span>は<span class="fontred">H 38 × W 27cm 以内</span>となります。
						</p>
					</div>

					<div class="inner">
						<h3>フードにプリント、できますか？</h3>
						<p><strong>はい！ドンとお任せください！</strong><br /> 手間＆技術が必要なプリントなのですが、sweatJackは自社工場ですので、 ばっちり仕上げます！乞うご期待を！です！
						</p>
					</div>

					<div class="inner">
						<h3>ゴールド、シルバー、蛍光のインク、追加料金、かかりますか？</h3>
						<p><strong>いいえ、追加料金ございません。</strong></p>
						<p>ゴールドも、シルバーも、蛍光も、<a href="../guide/ink.php">全50色</a>、どのインクも同じお値段です。</p>
					</div>

					<div class="inner">
						<h3>写真で、オリジナルスウェット、製作できますか？</h3>
						<p><strong>はい！ドンとお任せください！</strong></p>
						<p><a href="../guide/print_guide.php#digital">デジタルコピー転写</a> で表現（フルカラー／モノクロどちらも対応）できます。
						</p>
						<p><span class="fontred">入稿方法は2点。</span></p>
						<p><strong>（1）画像の場合。</strong><br /> 実際にプリントしたい
							<span class="fontred">実寸大以上</span>＆<span class="fontred">解像度300dpi以上</span>で。<span class="fontred">20MB以内</span>でメール送付。
							<span class="fontred">写真をスキャニングして画像にされる場合、解像度を最高に設定</span>ください。</p>
						<p><strong>（2）現像したプリント写真の場合。</strong><br /> 実際にプリントしたい
							<span class="fontred">実寸以上の写真</span>を<a href="../company/company.php">東京工場</a> 宛てにご郵送ください。
							<span class="fontred">折り曲げ厳禁（折り目が仕上がりに影響します）</span> でお願いいたします。
						</p>
					</div>

					<div class="inner">
						<h3>デザインのほかに、それぞれの出席番号を入れたいです！できますか？</h3>
						<p><strong>はい！ドンとお任せください！</strong></p>
						<p>デザインの部分は、シルクスクリーン、または、デジタルコピー転写で。</p>
						<p>それぞれの出席番号の部分は、カッティングシートで実現できます。<br /> カッティングシートの場合、ひとりひとりのお名前や、 少しずつ違うワンポイントなども入れることができます。
							<br />
							<a href="../guide/ink.php#cutting">フランス製のカッティングシート</a> 、おしゃれですよ！是非、のぞいてみてください。
						</p>
					</div>

					<div class="inner">
						<h3>デザインが細かいのですが、表現できますか？</h3>
						<p>
							<strong>はい! 0.3mmまでの線を表現できます！</strong><br /> （インクがのる部分0.3mm以上、インクとインクとのあいだが1mm以上必要）。 自社工場のシルクスクリーン技術は、かなりの細かいところまで表現されている。と、 実際にご利用いただいたお客様からご評価をいただいています。
							<span class="fontred">是非、デザインを拝見させていただき、ご提案させてください。</span>
						</p>
					</div>

					<div class="inner">
						<h3>パンツの裾にプリント、できますか？</h3>
						<p><strong>はい！ドンとお任せください！</strong></p>
						<p>裾部分にむかってパンツがきゅっとすぼんでいくため、W9cm（プリント巾の寸法）が制限になりますが、プリントできます。</p>
					</div>

					<div class="inner">
						<h3>Jr~XXL、サイズまぜこぜです。プリントできますか？</h3>
						<p><strong>はい！ドンとお任せください！</strong></p>
						<p>ただ1点。プリントのサイズは、一番小さいサイズのスウェットにあわせたサイズになります。<br /> Jr~XXLではJrにあわせたプリントサイズになりますが、XXLでは小さく見えがちに…。
						</p>
						<p>プリントにあたって、版（デザインの型）を製作するのですが、 XXLサイズにあわせた版の大きさではJrサイズからハミ出してしまうので、 一番小さいスウェットにおさまる版のサイズで製作することになります。
						</p>
						<p>こだわり派は、大人用と、子供用の2版でご注文されますが、 お値段は大分アップしてしまいます。
						</p>
					</div>

					<div class="inner">
						<h3><a href="../guide/ink.php">インク見本</a>にのってない色でプリントできますか？</h3>
						<p><strong>いいえ、</strong>インク見本（全50色）からのプリントとなってしまいます。</p>
					</div>

					<div class="inner" id="ans_04">
						<h3>洗濯しても、はがれませんか？</h3>
						<p><strong>はい！ご家庭の一般的な洗濯で、はがれてしまった！という例はございません。</strong><br /> ネットに入れたり、プリント部分を裏返しにしてお洗濯いただければ、 いっそう長持ちいたします。
						</p>
						<p>ただし、<span class="fontred">乾燥機、ドライクリーニングは避けてください</span>。 プリント部分の品質を損なうおそれがあります。
						</p>
						<p>少しでも長持ちさせたいとい場合は、シルクスクリーンをご提案いたします。</p>
						<p>また、ご家庭での洗濯方法、干し方、保存状態によりましては、どのプリント方法でも、 色あせやヒビが入る可能性がございます。100％の保証はいたしかねます点、 あらかじめご了承ください。
						</p>
					</div>

					<div class="inner">
						<h3>同じデザインで、何枚かだけ、インクの色、変えられますか？</h3>
						<p><strong>はい！ドンとお任せください！</strong></p>
						<p>インクの色チェンジは1回＋1,500円で可能です。<br /> 1回インクの色を変更した場合、製作費全体に＋1,500円となります。
							<br /> 1枚あたり＋1,500円ではありませんので、ご安心ください （ややこしくてごめんなさい…）。
						</p>
					</div>

					<div class="inner">
						<h3>同じデザインで、何枚かだけ、カッティングの色、変えられますか？</h3>
						<p><strong>はい！ドンとお任せください！</strong></p>
						<p>カッティングシートの色チェンジは1回＋1,500円で可能です。<br /> 1回インクの色を変更した場合、製作費全体に＋1,500円となります。
							<br /> 1枚あたり＋1,500円ではありませんので、ご安心ください （ややこしくてごめんなさい…）。
						</p>
					</div>

					<div class="inner">
						<h3>持ち込んだスウェットにプリントしてくれますか？</h3>
						<p><strong>はい！持込プリント、お引き受け可能です。</strong></p>
						<p>ただ1点。生地などを確認させていただいた結果、お引き受けできない場合もございます。<br /> 事前に、
							<a href="../company/company.php">東京工場</a> あてに、生地（スウェット）をご郵送ください。
							<br /> 送料はお客様ご負担、返送料は弊社負担いたします。
						</p>
						<p>また、プリントテストの結果、失敗する可能性もございますが、 商品を補償することはできません。
							<br /> 予備のご準備とリスクのご理解、あらかじめ、お願いいたします。
						</p>
						<p>また、お持込の場合、スウェットのよごれ・ ほつれなどの品質につきましても一切の責任を負えませんので、 あらかじめ、ご了承ください。
						</p>
						<p><span class="fontred">※お持込でのプリントの場合、一切の割引サービスの適用外となります。あらかじめ、ご了承ください。</span></p>
					</div>

				</div>

				<div class="section">
					<h2 class="top_logo">カテゴリ一覧</h2>
					<table id="faq_category">
						<tbody>
							<tr>
								<td>
									<p class="home-btn"><a href="delivery1.php" class="cat_01">お届けについて</a></p>
								</td>
								<td>
									<p class="home-btn"><a href="cancel1.php" class="cat_02">変更・キャンセルについて</a></p>
								</td>
								<td>
									<p class="home-btn"><a href="cost1.php" class="cat_03">料金について</a></p>
								</td>
							</tr>
							<tr>
								<td>
									<p class="home-btn"><a href="payment1.php" class="cat_04">お支払いについて</a></p>
								</td>
								<td>
									<p class="home-btn"><a href="order1.php" class="cat_05">注文について</a></p>
								</td>
								<td>
									<p class="home-btn"><a href="printing1.php" class="cat_06">プリントについて</a></p>
								</td>
							</tr>
							<tr>
								<td>
									<p class="home-btn"><a href="items1.php" class="cat_07">商品について</a></p>
								</td>
								<td>
									<p class="home-btn"><a href="design1.php" class="cat_08">デザインについて</a></p>
								</td>
								<td></td>
							</tr>
						</tbody>
					</table>
				</div>

				<p class="page_top"><span>プリントについて　ページトップへ</span></p>

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
