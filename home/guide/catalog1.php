<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/../app-def/initcontents2.php';
	if(isset($_POST['sample']) && $_POST['sample']=="sample"){
		$mail_title = "サンプル無料レンタルのお申込み";
	}else{
		$mail_title = "カタログ送付のお申込み";
	}
	require_once $_SERVER['DOCUMENT_ROOT'].'/../app-def/sendmail.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/../cgi-bin/conndb.php';
	$conn = new Conndb();
	$list = $conn->sjTablelist('items');
	$count= count($list);
	$selector = '<select name="item" id="item_selector">';
	$selector .= '<option value="未選択" class="0" selected="selected">---</option>';
	for($i=0; $i<$count; $i++){
		$item_name = $list[$i]['item_code']." ".mb_convert_encoding($list[$i]['item_name'],'euc-jp', 'utf-8');
		$cls = "id_".$list[$i]['id']."_".$list[$i]['color_code'];
		$selector .= '<option value="'.$item_name.'" class="'.$cls.'">'.$item_name.'</option>';
	}
	$selector .= '</select>';

	// size selector
	$list2 = $conn->sjTablelist('itemsize',$list[0]['id'], $list[0]['color_code']);
	$count= count($list2);
	$size = '<select name="size" id="size_selector">';
	$size .= '<option value="未選択" selected="selected">---</option>';
	for($i=0; $i<$count; $i++){
		$size .= '<option value="'.$list2[$i]['size_name'].'">'.$list2[$i]['size_name'].'</option>';
	}
	$size .= '</select>';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="euc-jp" />
    <title>カタログ・サンプル ｜ オリジナルパーカーのスウェットジャック</title>
    <meta name="description" content="オリジナルスウェットの作品集、ラインナップカタログは、こちらからお気軽にご請求ください。サンプル無料レンタルもしております。オリジナルスウェットを作るならスウェットジャックへ" />
    <meta name="keywords" content="スウェット,オリジナルスウェット,パーカー,オリジナルパーカー,プリント,カタログ,サンプル,無料レンタル" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <meta http-equiv="Content-Script-Type" content="text/javascript" />
	<link rel="shortcut icon" href="/icon/favicon.ico" />
    <link rel="stylesheet" type="text/css" media="screen" href="../css/template1.css" />
<link rel='stylesheet' id='contact-form-7-css'  href='../css/header-footer_responsive.css' type='text/css' media='all' />
    <link rel="stylesheet" type="text/css" media="screen" href="../css/catalog1.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../js/modalbox/css/jquery.modalbox.css" />

    <script type="text/javascript" src="../js/jquery.js"></script>
    <script type="text/javascript" src="../js/modalbox/jquery.modalbox-min.js"></script>
    <script type="text/javascript" src="../js/util.js"></script>
    <script type="text/javascript" src="../js/catalog.js"></script>

    <script type="text/javascript">
        var _res_mail = "<?php echo $html; ?>";
    </script>

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
	
	<div class="container">
	
        <div class="contents inner">
			
			<?php echo $msgbar; ?>
			
			<h2 class="titlelogo">カタログ・サンプル</h2>
			
			<div class="section">
				<p class="fb">
					スウェット選びのお手伝い。サイトでは伝え切れない魅力に出会えます。
				</p>
			</div>
			
			<div class="section fix">
				<h2 class="top_logo">メーカーカタログプレゼント</h2>
				<p class="txtinfo">
					各スウェットメーカーのカタログを無料でお送りいたします。<br>
					サイト掲載商品以外も取り扱っておりますので、お気軽にお問い合わせください。
				</p>
				<img src="/img/guide/catalog/image01.png">
			</div>
			
			<div class="section fix">
				<h2 class="top_logo">サンプル貸し出し</h2>
				<p class="txtinfo">
					ご希望の商品3点まで、10日間無料でレンタルが可能です。<br>
					生地の厚さ、手触り、サイズ感、カラーなどをじっくり確かめられます。
				</p>
				<p class="note"><span>※</span>ご返送料のみお客様負担をお願いしております。</p>
				<img src="/img/guide/catalog/image02.png">
			</div>
			
			<div class="section">
				<h2 class="top_logo">カタログ送付のお申し込みフォーム</h2>
				
				<form class="f_layout" name="form1" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post" onSubmit="return false" >
					<input type="hidden" name="subject" value="カタログ送付のお申込み" />
					<input type="hidden" name="requestform" value="1" />
					<input type="hidden" name="ticket" value="<?php echo $ticket;?>" />
					<table>
						<tbody>
							<tr>
								<th>氏名<span>（必須）</span></th>
								<td><input type="text" name="name" value="" class="wide" /></td>
							</tr>
							<tr>
								<th>ふりがな</th>
								<td><input type="text" name="ruby" value="" class="wide" /></td>
							</tr>
							<tr>
								<th>お届け先の宛名<br><ins>（個人様は不要です）</ins></th>
								<td><input type="text" name="company" value="" class="wide" title="学校名・企業名・部署名など"/></td>
							</tr>
							<tr>
								<th>電話番号<span>（必須）</span></th>
								<td><input type="text" name="tel" value="" class="wide phone" title="ハイフン｢-｣不要、数字だけでOKです" /></td>
							</tr>
							<tr>
								<th>メールアドレス<span>（必須）</span></th>
								<td><input type="text" name="email" value="" class="wide" title="PC・携帯、どちらでもOKです" /></td>
							</tr>
							<tr>
								<th>お届け先住所<span>（必須）</span></th>
								<td>
									〒 <input type="text" name="zipcode" value="" class="zip" />
									<p><input type="text" name="addr1" value="" class="wide" title="都道府県から住所を入力してください" /></p>
									<p><input type="text" name="addr2" value="" class="wide" title="番地、マンション名などの建物名" /></p>
								<td>
							</tr>
							<tr>
								<th>ご質問内容</th>
								<td><textarea cols="30" rows="5" name="message" class="wide"></textarea></td>
							</tr>
						</tbody>
					</table>
					
					<div class="opt">
						<h3>商品サンプルのレンタルをご希望の場合</h3>
						<div>
							<label><input type="checkbox" name="sample" value="sample"> サンプルのレンタルを申し込む</label>
							<p>レンタル希望の商品名</p>
							<?php echo $selector; ?>
							
							<p>サイズ：<?php echo $size; ?></p>
							
							<p class="anchor"><a href="/lineup/lineup_parker1.php">商品ラインナップを開く</a></p>
						</div>
					</div>
					
					<div id="send_mail" ><p>送信する</p></div>
					
					<div class="message">
						<p class="note"><span>※</span>内容によりましては回答までにお時間をいただく場合がございます。</p>
						<p class="note"><span>※</span>お急ぎの場合は<span class="fontred"> <?php echo _TOLL_FREE; ?> </span>（平日10:00〜18:00）までお気軽に！</p>
					</div>
				</form>
				
			</div>
			
			<p class="page_top"><span>カタログ・サンプル　ページトップへ</span></p>

		</div><!-- /contents -->

	</div>
	
									<footer>
				<div class="footer-wrapper"><?php echo $footer; ?> </div>
			</footer>
    </div><!-- /wrapper-all-->
	
	<div id="message_wrapper" style="display:none;"></div>

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