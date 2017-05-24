<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/../app-def/initcontents2.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/../app-def/iteminfo.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/../cgi-bin/conndb.php';
	$conn = new Conndb();
	
	// 消費税
	$tax = $conn->getSalesTax();
	$tax /= 100;
	
	$idx = 0;
	$list = $conn->sjItemInfo(90);
	foreach($list as $id=>$val){
		if($idx==0){
			$idx++;
			$selected = ' selected="selected"';
			$parkerPath = _IMG_PSS.'items/sweat/'.$val['item_code'].'/'.$val['item_code'].'_'.$val['i_color_code'].'.jpg';
		}else{
			$selected = '';
		}
		$item_name = $val['item_code']." ".mb_convert_encoding($val['item_name'], 'euc-jp', 'utf-8');
		$parker_selector .= '<option data-code="'.$val['i_color_code'].'" value="'.$id.'"'.$selected.'>'.$item_name.'</option>';
	}
	
	$idx = 0;
	$list = $conn->sjItemInfo(2);
	foreach($list as $id=>$val){
		if($idx==0){
			$idx++;
			$selected = ' selected="selected"';
			$pantsPath = _IMG_PSS.'items/sweat/'.$val['item_code'].'/'.$val['item_code'].'_'.$val['i_color_code'].'.jpg';
		}else{
			$selected = '';
		}
		$item_name = $val['item_code']." ".mb_convert_encoding($val['item_name'], 'euc-jp', 'utf-8');
		$pants_selector .= '<option data-code="'.$val['i_color_code'].'" value="'.$id.'"'.$selected.'>'.$item_name.'</option>';
	}
	
	$idx = 0;
	$list = $conn->sjItemInfo(1);
	foreach($list as $id=>$val){
		if($idx==0){
			$idx++;
			$selected = ' selected="selected"';
			$tshirtsPath = _IMG_PSS.'items/t-shirts/'.$val['item_code'].'/'.$val['item_code'].'_'.$val['i_color_code'].'.jpg';
		}else{
			$selected = '';
		}
		$item_name = $val['item_code']." ".mb_convert_encoding($val['item_name'], 'euc-jp', 'utf-8');
		$tshirts_selector .= '<option data-code="'.$val['i_color_code'].'" value="'.$id.'"'.$selected.'>'.$item_name.'</option>';
	}
	
	$idx = 0;
	$list = $conn->sjItemInfo(6);
	foreach($list as $id=>$val){
		if($idx==0){
			$idx++;
			$selected = ' selected="selected"';
			$outerPath = _IMG_PSS.'items/outer/'.$val['item_code'].'/'.$val['item_code'].'_'.$val['i_color_code'].'.jpg';
		}else{
			$selected = '';
		}
		$item_name = $val['item_code']." ".mb_convert_encoding($val['item_name'], 'euc-jp', 'utf-8');
		$outer_selector .= '<option data-code="'.$val['i_color_code'].'" value="'.$id.'"'.$selected.'>'.$item_name.'</option>';
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="euc-jp">
    <title>オンライン見積 ｜ オリジナルパーカーのスウェットジャック</title>
    <meta name="description" content="製作費をパッと自動計算！ご予算にあっているか簡単にお見積がわかります。オリジナルスウェットを作るならスウェットジャックへ" />
    <meta name="keywords" content="スウェット,オリジナルスウェット,パーカー,オリジナルパーカー,プリント,見積,製作費" />
<!--m2 begin-->
	<meta name="viewport" content="width=device-width,user-scalable=no,maximum-scale=1" />
<!--m2 end--> 
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <meta http-equiv="Content-Script-Type" content="text/javascript" />
	<link rel="shortcut icon" href="/icon/favicon.ico" />
<!-- msgbox begin-->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
<!-- msgbox end-->
    <link rel="stylesheet" type="text/css" media="screen" href="../css/template1_responsive.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../js/modalbox/css/jquery.modalbox.css" />
<link rel='stylesheet' id='contact-form-7-css'  href='../css/header-footer_responsive.css' type='text/css' media='all' />
    <link rel="stylesheet" type="text/css" media="screen" href="../css/estimate1_responsive.css" />

<!--m2 begin-->
    <link rel="stylesheet" type="text/css" href="/m2/common/css/common1_responsive.css" media="all">
<!--m2 end--> 

<!-- msgbox begin-->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/jquery-ui.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
	<script src="//ajaxzip3.github.io/ajaxzip3.js" charset="utf-8"></script>
<!-- msgbox end-->
    <script type="text/javascript" src="../js/util_responsive.js"></script>
    <script type="text/javascript" src="../js/jumboprint_responsive.js"></script>
    <script type="text/javascript">
        var _TAX = <?php echo $tax; ?>;
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
<div id="wrapper-all">
		<header class="site-header"><?php echo $header; ?>			

				
			<div  id="fixedBox" class="nav">
				<nav id="global-navigation"><?php echo $menu; ?></nav>	
			</div>
</header>
<!-- m2 begin-->
<div id="m2_header">
<h1>オリジナル<?php echo $item_name;?>を作成！</h1>
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
	
	<div class="container">
        
        <?php echo $msgbar; ?>

        <div class="contents">
<h2 class="titlelogo"><img src="../img/estimate/jumboprint/mi_main_img_01.jpg" width="98%" /></h2>

			<div class="wrap_1" id="compare_size"><p>まずは料金を入りたい！という方はこちらから、<br>簡単にお見積もりができます。</p></div>
			<div class="wrap_1"><img src="../img/estimate/jumboprint/mi_main_img_02.jpg" width="100%" /></div>
                        <div class="wrap_1"  id="compare_price"><p><span="red">※</span>注意：こちらの料金は概算となります。シルクプリントのみのお見積もりです。<br>その他のご要望は、お問合せください。
正確な金額は、デザイン確認後にお見積もりいたします。</p></div>
            </div>

			<div class="wrap_2">
				<h3 class="top_logo">簡単10秒見積もり</h3>
				<div class="img_wrapper"><img alt="" src="<?php echo $parkerPath;?>" width="280" id="parker_back_image" /></div>
				<div class="calc_wrapper">
					<table id="calc_parker_back">
						<tr><th>製作枚数は？</th><td><input type="text" name="amount" value="10" class="amount" /> 枚</td></tr>
						<tr><th>スウェットは？</th><td><select class="item_selector" id="parker_back"><?php echo $parker_selector; ?></select>　</td></tr>
						<tr><th>プリント方法は？</th><td><span class="font04c">シルクスクリーンプリント</span>　</td></tr>
						<tr><th>使うインクの色は？</th><td><input type="text" name="ink" value="1" class="ink" /> 色　</td></tr>
						<tr><th>通常プリント<br /><span>REGULAR</span></th>
							<td>
								<div class="wrap_3 regular">
									<p>TOTAL　&yen;<span>0</span></p>
									<div class="clearfix">
										<div class="title">1枚あたりの製作費</div>
										<div class="price">&yen;<span id="regular_price_back">0</span></div>
										<div class="price2">&yen;<span id="plus_back">0</span></div>
										<div>でジャンボ！</div>
									</div>
								</div>
							</td>
						</tr>
						<tr><th>ジャンボプリント<br /><span>JUMBO</span></th>
							<td>
								<div class="wrap_3 jumbo" >
									<p>TOTAL　&yen;<span>0</span></p>
									<div class="clearfix">
										<div class="title">1枚あたりの製作費</div>
										<div class="price">&yen;<span id="jumbo_price_back">0</span></div>
									</div>
								</div>
							</td>
						</tr>
					</table>
					<div class="attn">
						<p><span class="fontred">※Lサイズ（ホワイト）で算出しています。<br>※ジャンボプリントはシルクスクリーンプリント限定です。</span></p>
					</div>
				</div>
			</div>

			<div class="wrap_2">
				<div class="img_wrapper"><img alt="" src="<?php echo $pantsPath;?>" width="280" id="pants_side_image" /></div>
				<div class="calc_wrapper">
					<table id="calc_pants_side">
						<tr><th>製作枚数は？</th><td><input type="text" name="amount" value="10" class="amount" /> 枚　</td></tr>
						<tr><th>スウェットは？</th><td><select class="item_selector" id="pants_side"><?php echo $pants_selector; ?></select>　</td></tr>
						<tr><th>プリント方法は？</th><td><span class="font04c">シルクスクリーンプリント</span>　</td></tr>
						<tr><th>使うインクの色は？</th><td><input type="text" name="ink" value="1" class="ink" /> 色　</td></tr>
						<tr><th>通常プリント<br /><span>REGULAR</span></th>
							<td>
								<div class="wrap_3 regular">
									<p>TOTAL　&yen;<span>0</span></p>
									<div class="clearfix">
										<div class="title">1枚あたりの製作費</div>
										<div class="price">&yen;<span id="regular_price_side">0</span></div>
										<div class="price2">&yen;<span id="plus_side">0</span></div>
										<div>でジャンボ！</div>
									</div>
								
								</div>
							</td>
						</tr>
						<tr><th>ジャンボプリント<br /><span>JUMBO</span></th>
							<td>
								<div class="wrap_3 jumbo">
									<p>TOTAL　&yen;<span>0</span></p>
									<div class="clearfix">
										<div class="title">1枚あたりの製作費</div>
										<div class="price">&yen;<span id="jumbo_price_side">0</span></div>
									</div>
								</div>
							</td>
						</tr>

					</table>
					<div class="attn">
						<p><span class="fontred">※Lサイズ（ホワイト）で算出しています。<br>※ジャンボプリントはシルクスクリーンプリント限定です。</span></p>
					</div>
				</div>
			</div>
			
			<div class="wrap_2">
				<div class="img_wrapper"><img alt="" src="<?php echo $tshirtsPath;?>" width="280" id="t-shirts_image" /></div>
				<div class="calc_wrapper">
					<table id="calc_t-shirts_front1">
						<tr><th>製作枚数は？</th><td><input type="text" name="amount" value="10" class="amount" /> 枚　</td></tr>
						<tr><th>Tシャツは？</th><td><select class="item_selector" id="t-shirts"><?php echo $tshirts_selector; ?></select>　</td></tr>
						<tr><th>プリント方法は？</th><td><span class="font04c">シルクスクリーンプリント</span>　</td></tr>
						<tr><th>使うインクの色は？</th><td><input type="text" name="ink" value="1" class="ink" /> 色　</td></tr>
						<tr><th>通常プリント<br /><span>REGULAR</span></th>
							<td>
								<div class="wrap_3 regular">
									<p>TOTAL　&yen;<span>0</span></p>
									<div class="clearfix">
										<div class="title">1枚あたりの製作費</div>
										<div class="price">&yen;<span id="regular_price_front1">0</span></div>
										<div class="price2">&yen;<span id="plus_front1">0</span></div>
										<div>でジャンボ！</div>
									</div>
								
								</div>
							</td>
						</tr>
						<tr><th>ジャンボプリント<br /><span>JUMBO</span></th>
							<td>
								<div class="wrap_3 jumbo">
									<p>TOTAL　&yen;<span>0</span></p>
									<div class="clearfix">
										<div class="title">1枚あたりの製作費</div>
										<div class="price">&yen;<span id="jumbo_price_front1">0</span></div>
									</div>
								</div>
							</td>
						</tr>

					</table>
					<div class="attn">
						<p><span class="fontred">※Lサイズ（ホワイト）で算出しています。<br>※ジャンボプリントはシルクスクリーンプリント限定です。</span></p>
					</div>
				</div>
			</div>
			
			<div class="wrap_2">
				<div class="img_wrapper"><img alt="" src="<?php echo $outerPath;?>" width="280" id="outer_image" /></div>
				<div class="calc_wrapper">
					<table id="calc_outer_front2">
						<tr><th>製作枚数は？</th><td><input type="text" name="amount" value="10" class="amount" /> 枚　</td></tr>
						<tr><th>ブルゾンは？</th><td><select class="item_selector" id="outer"><?php echo $outer_selector; ?></select>　</td></tr>
						<tr><th>プリント方法は？</th><td><span class="font04c">シルクスクリーンプリント</span>　</td></tr>
						<tr><th>使うインクの色は？</th><td><input type="text" name="ink" value="1" class="ink" /> 色　</td></tr>
						<tr><th>通常プリント<br /><span>REGULAR</span></th>
							<td>
								<div class="wrap_3 regular">
									<p>TOTAL　&yen;<span>0</span></p>
									<div class="clearfix">
										<div class="title">1枚あたりの製作費</div>
										<div class="price">&yen;<span id="regular_price_front2">0</span></div>
										<div class="price2">&yen;<span id="plus_front2">0</span></div>
										<div>でジャンボ！</div>
									</div>
								
								</div>
							</td>
						</tr>
						<tr><th>ジャンボプリント<br /><span>JUMBO</span></th>
							<td>
								<div class="wrap_3 jumbo">
									<p>TOTAL　&yen;<span>0</span></p>
									<div class="clearfix">
										<div class="title">1枚あたりの製作費</div>
										<div class="price">&yen;<span id="jumbo_price_front2">0</span></div>
									</div>
								</div>
							</td>
						</tr>

					</table>
					<div class="attn">
						<p><span class="fontred">※Lサイズ（ホワイト）で算出しています。<br>※ジャンボプリントはシルクスクリーンプリント限定です。</span></p>
					</div>
				</div>
			</div>
			
			<div class="pan_navi">
            	<ul>
            		<li><a href="http://www.sweatjack.jp/">HOME</a></li>
            		<li><a href="#compare_size">サイズを見くらべる</a></li>
            		<li><a href="#compare_price">制作費をくらべる</a></li>
            		<li class="last"><a href="/gallery/gallery_body1.php">制作実例を見る！</a></li>
            	</ul>
            </div>

				<div class="clearfix">
					<div class="inner">
						<p>
							ご希望のアイテムやプリント箇所が決まりましたら、それぞれのアイテムページにある「見積り・注文に進む」ボタンからお申し込みが可能です。電話やFAXでのお申し込みも承っております。
						</p>
					</div>
					<div class="wrap">
						<p class="btnp"><a href="/order/index1.php" id="btn_rescue">&raquo;申し込みへ</a></p>
						<p class="contactimg"><img src="/common/img/contact.png" alt="お問い合わせ 0120-130-428" width="100%" /></p>
					</div>
				</div>
            <p class="page_top"><span>お見積もり　ページトップへ</span></p>

        </div><!-- /contents -->

    </div>

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
<!-- msgbox begin-->
		<div id="msgbox" class="modal fade" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">メッセージ</h4>
			 		</div>
			 		<div class="modal-body">
						<p></p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary is-ok" data-dismiss="modal">OK</button>
						<button type="button" class="btn btn-default is-cancel" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
		</div>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- msgbox end-->

</body>
</html>