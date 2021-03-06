<?php
	if(isset($_REQUEST['item_id'])){
		$_FLG_ITEM_ID = $_REQUEST['item_id'];
	}else if(isset($_REQUEST['pants_id'])){
		$_FLG_ITEM_ID = $_REQUEST['pants_id'];	// 上下セットアップ
	}else{
		$_FLG_ITEM_ID = 173;	// 185-nsz スタンダードジップパーカー
	}
	$_FLG_COLORCODE = isset($_REQUEST['color_code'])? $_REQUEST['color_code']: '';
	//$_UPDATED = empty($_REQUEST['update'])? 0: $_REQUEST['update'];
	if(isset($_REQUEST['c'])){
		$_UPDATED = 1;
		$args = $_REQUEST['c'];
	}else{
		$_UPDATED = 0;
		$args = 0;
	}
	
	if(isset($_REQUEST['cart'])){
		$_CART = 1;
	}else{
		$_CART = 0;
	}
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/../app-def/initcontents.php';
	
	// デザインテンプレートの指定がある場合
	if(isset($_REQUEST['tmpc'],$_REQUEST['tmpn'])){
		$template_category = array(
			'dance'=>'ダンス',
			'team'=>'チーム',
			'event'=>'イベント',
			'emblem'=>'エンブレム',
			'stamp'=>'スタンプ',
			'silhouette-animal'=>'シルエット動物',
			'silhouette-person'=>'シルエット人物',
			'parts'=>'パーツ',
			'other'=>'その他'
			
		);
		$_SESSION['orders']['customer']['note_template'] = mb_convert_encoding($template_category[$_REQUEST['tmpc']].' '.$_REQUEST['tmpn'], 'utf-8', 'euc-jp');
	}
	
	require_once dirname(__FILE__).'/../php_libs/orders.php';
	$order = new Orders();
	
	// 消費税
	$tax = $order->salestax();
	$tax /= 100;
	
	// カテゴリー情報を取得
	//$itemattr = $conn->itemAttr($_FLG_ITEM_ID);
	list($itemattr, $categories) = $order->getCategoryInfo($_FLG_ITEM_ID);
	
	list($categorykey, $categoryname) = each($itemattr['category']);
	$folder = $categorykey;
	$_CAT_KEY = $categorykey;
	$categoryname = mb_convert_encoding($categoryname,'euc-jp','utf-8');
	list($itemcode, $itemname) = each($itemattr['name']);
	list($code, $colorname) = each($itemattr['code']);
	$itemname = mb_convert_encoding($itemname,'euc-jp','utf-8');
	$curcolor = mb_convert_encoding($colorname,'euc-jp','utf-8');
	
	// アイテム一覧情報を取得
	$ite = new Items($categorykey);
	$res = $ite->getItemlist($args);		// 2013-12-06 引数を追加
	
	// estimattion data
	$data = $order->reqDetails();
	$total = $data['total']*(1+$tax);
	if($data['options']['payment']==3) $total = $total*(1+_CREDIT_RATE);
	$perone = floor($total/$data['amount']);
	$total = floor($total);
	
	// user info
	foreach($regist['customer'] as $key=>$val){
		$user[$key] = mb_convert_encoding($val, 'euc-jp', auto);
	}
	
	/* カテゴリーセレクター */
	$category_selector = '<select id="category_selector">';
	/* Sweatjack用に変更のため
	for($i=0; $i<count($categories); $i++){
		$category_selector .= '<option value="'.$categories[$i]['code'].'" rel="'.$categories[$i]['id'].'">'.mb_convert_encoding($categories[$i]['name'],'euc-jp','utf-8').'</option>';
	}
	*/
	$category_selector .= '<option value="0">パーカー</option>';
	$category_selector .= '<option value="1">トレーナー</option>';
	$category_selector .= '<option value="2">パンツ</option>';
	$category_selector .= '<option value="3">ジャケット</option>';
	$category_selector .= '<option value="4">チャンピオン</option>';
	$category_selector .= '</select>';
	$category_selector = str_replace('value="'.$args.'"', 'value="'.$args.'" selected="selected"', $category_selector);
	
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="euc-jp" />
	<title>お申し込みフォーム　|　オリジナルパーカーのスウェットジャック</title>
    <meta name="description" content="オリジナルパーカーのご注文はこちらから。オーダーフォームに入力すると見積も自動でできる！オーダー前に予算がわかり安心です。オリジナルスウェットを作るならスウェットジャックへ" />
    <meta name="keywords" content="スウェット,オリジナルスウェット,パーカー,オリジナルパーカー,プリント,注文,オーダーフォーム" />

	<link rel="shortcut icon" href="/icon/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="/css/template.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="/js/ui/ui-darkness/jquery.ui.all.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="/js/modalbox/css/jquery.modalbox.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="/common/js/uniform/css/uniform.default.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="/common/css/printposition.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="./css/order.css" media="screen" />
	
	<script type="text/javascript" src="/js/jquery.js"></script>
    <script type="text/javascript" src="/js/ui/ui.core.js"></script>
    <script type="text/javascript" src="/js/ui/ui.datepicker.js"></script>
    <script type="text/javascript" src="/js/ui/i18n/ui.datepicker-ja.js"></script>
	<script type="text/javascript" src="/js/modalbox/jquery.modalbox-min.js"></script>
	<script type="text/javascript" src="/common/js/uniform/jquery.uniform.js"></script>
	<script src="http://ajaxzip3.googlecode.com/svn/trunk/ajaxzip3/ajaxzip3.js" charset="utf-8"></script>
	<script type="text/javascript" src="/js/util.js"></script>
	<script type="text/javascript" src="./js/orderform.js"></script>
	<script type="text/javascript">
		var _CART = <?php echo $_CART; ?>;
		var _UPDATED = <?php echo $_UPDATED; ?>;
		var _ITEM_ID = <?php echo $_FLG_ITEM_ID; ?>;
		var _CAT_KEY = '<?php echo $_CAT_KEY; ?>';
		var _TAX = <?php echo $tax; ?>;
		var _CREDIT_RATE = <?php echo _CREDIT_RATE; ?>;
		var _IMG_PSS = '<?php echo _IMG_PSS;?>';
	</script>
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

	<div class="header" id="header"><?php echo $header; ?></div>
	
	<div id="container">
		
		<?php echo $msgbar; ?>
		
		<div class="contents" style="z-index:5;">
			
			<div class="heading1_wrapper">
				<h1>お申し込みフォーム</h1>
				<p class="comment">
					FAXでのお申し込みをご希望の方は、<br /><a href="/guide/sheet.php">FAX用デザイン用紙</a>をプリントして送信できます。
				</p>
				<img src="./img/order.png" style="margin-top:10px; border: 1px solid #efefef;">
			</div>
			
			<div id="gall">
				<div id="step1">
					<div class="heading"></div>
					<div class="crumbs_wrap">
						<div class="crumbs pass step_first">
							<p>Step1</p>
							<div>プリントする<br>アイテムを選択</div>
						</div>
						<div class="crumbs">
							<p>Step2</p>
							<div>カラー・サイズ<br>枚数入力</div>
						</div>
						<div class="crumbs">
							<p>Step3</p>
							<div>プリント位置<br>を指定</div>
						</div>
						<div class="crumbs">
							<p>Step4</p>
							<div><img alt="カート" src="./img/cart.png" />カート<br>に入れる</div>
						</div>
						<div class="crumbs">
							<p>Step5</p>
							<div>お客様情報<br>の入力</div>
						</div>
						<div class="crumbs step_fin">
							<p>Step6</p>
							<div class="fin">内容を確認して<br>お申し込み</div>
						</div>
					</div>
					
                    <div class="step_inner">
                        <h2><ins>Step1</ins>プリントするアイテムをお選びください</h2>
                        
                        <div class="category_list">
                            <h3><ins>１.</ins>カテゴリーを指定</h3>
                            <?php echo $category_selector; ?>
                        </div>
                        
                        <h3 id="h3_itemlist"><ins>２.</ins>アイテムを選択してください<span>（<?php echo count($res); ?> アイテム）</span></h3>
                        <div id="itemlist_wrap">
                        <?php
                            $recomend = '';
                            $ls='';
                            $tmp = array();
                            $i=0;
                            foreach($res as $code=>$v){
                                if($code=='085-cvt') $tmp[0] = array($code=>$res[$code]);
                                if($code=='5401') $tmp[1] = array($code=>$res[$code]);
                                if($code=='ss-1030') $tmp[2] = array($code=>$res[$code]);
                                
                                if($i%4==0){
                                    $firstlist = ' firstlist';
                                }else{
                                    $firstlist = '';
                                }
                                if( preg_match('/^p-/',$code) || $code=='ss-9999'){
									$suffix = '_style_0'; 
								}else{ 
									$suffix = '_'.$v['initcolor']; 
								}
                                $ls .= '<li class="listitems_ex'.$firstlist.'" id="itemid_'.$v['item_id'].'_'.$v['pos_id'].'">
                                            <ul class="maker_'.$v['maker_id'].'">
                                                <li class="point_s">'.mb_convert_encoding($v['features'],'euc-jp','utf-8').'</li>
                                                <li class="item_name_s">
                                                    <ul>
                                                        <li class="item_name_kata">'.strtoupper($code).'</li>
                                                        <li class="item_name_name">'.mb_convert_encoding($v['item_name'],'euc-jp','utf-8').'</li>
                                                    </ul>
                                                </li>
                                                <li class="item_image_s">
                                                    <img src="'._IMG_PSS.'items/'.$folder.'/'.$code.'/'.$code.$suffix.'.jpg" width="150" height="150" alt="'.strtoupper($code).'">
                                                    <img src="./img/crumbs_next.png" alt="" class="icon_arrow">
                                                </li>
                                                <li class="item_info_s">
                                                    <div class="colors">'.$v['colors'].'</div>
                                                    <div class="sizes">'.$v['sizes'].'</div>
                                                    <p class="price_s">
                                                        TAKAHAMA価格<br>
                                                        <span><span>'.$v['minprice'].'</span>円〜</span>
                                                    </p>
                                                </li>
                                            </ul>
                                        </li>';
                                $i++;
                            }
                            
                            if(!empty($tmp)){
                                for($i=0; $i<count($tmp); $i++){
                                    list($code, $v) = each($tmp[$i]);
                                    if($i==2) $lastli = ' lastli';
                                    $recomend .= '<li class="recitembox'.$lastli.'" id="itemid_'.$v['item_id'].'_'.$v['pos_id'].'">
                                        <img class="rankno" src="./img/no'.($i+1).'.png" width="60" height="55" alt="No1">
                                        <ul class="maker_'.$v['maker_id'].'">
                                            <li class="item_name">
                                                
                                                <p>'.mb_convert_encoding($v['features'],'euc-jp','utf-8').'</p>
                                                <ul class="popu_item_name">
                                                    <li class="item_name_kata">'.strtoupper($code).'</li>
                                                    <li class="item_name_name">'.mb_convert_encoding($v['item_name'],'euc-jp','utf-8').'</li>
                                                </ul>
                                            </li>
                                            <li class="item_image">
                                                <img src="'._IMG_PSS.'items/'.$folder.'/'.$code.'/'.$code.'_'.$v['initcolor'].'.jpg" width="250" alt="'.strtoupper($code).'">
                                                <img src="./img/crumbs_next.png" alt="" class="icon_arrow">
                                            </li>
                                            <li class="item_info clearfix">
                                                <div class="color">'.$v['colors'].'</div>
                                                <div class="size">'.$v['sizes'].'</div>
                                                <p class="price">
                                                    TAKAHAMA価格<br>
                                                    <span><span>'.$v['minprice'].'</span>円〜</span>
                                                </p>
                                            </li>
                                        </ul>
                                    </li>';
                                }
                                
                                echo '<ul class="recommend_item clearfix">'.$recomend.'</ul>';
                            }
                            
                            echo '<ul class="listitems clearfix">'.$ls.'</ul>';
                        ?>
                        </div>
					</div>
				</div>
				
				<div id="step2">
					<div class="heading clearfix"><p class="arrow prev"><span>戻る</span></p></div>
					<div class="crumbs_wrap">
						<div class="crumbs pass step_first passed">
							<p>Step1</p>
							<div>プリントする<br>アイテムを選択</div>
						</div>
						<div class="crumbs pass">
							<p>Step2</p>
							<div>カラー・サイズ<br>枚数入力</div>
						</div>
						<div class="crumbs">
							<p>Step3</p>
							<div>プリント位置<br>を指定</div>
						</div>
						<div class="crumbs">
							<p>Step4</p>
							<div><img alt="カート" src="./img/cart.png" />カート<br>に入れる</div>
						</div>
						<div class="crumbs">
							<p>Step5</p>
							<div>お客様情報<br>の入力</div>
						</div>
						<div class="crumbs step_fin">
							<p>Step6</p>
							<div class="fin">内容を確認して<br>お申し込み</div>
						</div>
					</div>
					<div class="step_inner">
						<h2><ins>Step2</ins>カラー・サイズ・枚数を指定してください</h2>
						
						<p id="cur_item_name_wrap">アイテム名：　<span id="cur_item_name" class="prop_1_1"><?php echo $itemname;?></span></p>
						
						<div class="pane">
							<h3><ins>1.</ins>アイテムカラーの指定</h3>
							<div class="thumb_wrap clearfix">
								<div class="item_thumb">
				                	<p class="thumb_h"><span>Color</span>全<span class="num_of_color"><?php echo $color_count; ?></span>色<span class="notes_color"><?php echo $curcolor; ?></span></p>
				                    <ul class="color_thumb"><?php echo $thumbs; ?></ul>
								</div>
								<div class="item_image"><?php echo $itemimage; ?></div>
							</div>
							
							<div class="sizeprice">
								<h3>
									<ins>2.</ins>サイズと枚数の指定　　　<span class="anchor pop_size">サイズの目安を見る</span>
								</h3>
								<table class="size_table">
								<caption></caption>
								<tbody><tr><td></td></tr></tbody></table>
								<div class="btmline">小計<span class="cur_amount"><?php echo $sum; ?></span>枚</div>
							</div>
						</div>
						
						<div class="btn_line">
							<span>※</span>色違いのアイテムを選べます
							<div id="add_item_color" class="btn_sub">別のカラーを追加する</div>
						</div>
						
						<div class="arrow_line"><div class="arrow prev"><span>戻る</span></div>
						<div class="step_next goto_position"onclick="ga('send','event','order','click','step2', 100 );">次へ進む</div>合計<span id="tot_amount">0</span>枚</div>
					</div>
                </div>
				
				<div id="step3">
					<div class="heading clearfix"><p class="arrow prev"><span>戻る</span></p></div>
					<div class="crumbs_wrap">
						<div class="crumbs pass step_first passed">
							<p>Step1</p>
							<div>プリントする<br>アイテムを選択</div>
						</div>
						<div class="crumbs pass passed">
							<p>Step2</p>
							<div>カラー・サイズ<br>枚数入力</div>
						</div>
						<div class="crumbs pass">
							<p>Step3</p>
							<div>プリント位置<br>を指定</div>
						</div>
						<div class="crumbs">
							<p>Step4</p>
							<div><img alt="カート" src="./img/cart.png" />カート<br>に入れる</div>
						</div>
						<div class="crumbs">
							<p>Step5</p>
							<div>お客様情報<br>の入力</div>
						</div>
						<div class="crumbs step_fin">
							<p>Step6</p>
							<div class="fin">内容を確認して<br>お申し込み</div>
						</div>
					</div>
					<div class="step_inner">
						<h2><ins>Step3</ins>プリントする位置とデザインの色数を指定してください</h2>
						
						<div>
							<p><label><input type="checkbox" name="noprint" id="noprint" value="1"> プリントなしで購入する</label></p>
							<p class="note"><span>※</span>プリントなしの場合1割増しになります。</p>
						</div>
						
						<div id="pos_wrap"></div>
						
						<div class="arrow_line"><div class="arrow prev"><span>戻る</span></div><div class="step_next goto_cart"onclick="ga('send','event','order','click','step3', 100 );">カートに入れる</div></div>
                    </div>
				</div>
				
				<div id="step4">
					<div class="heading clearfix"><p class="arrow prev" rel="0"><span>別の商品を見る</span></p></div>
					<div class="crumbs_wrap">
						<div class="crumbs pass step_first passed">
							<p>Step1</p>
							<div>プリントする<br>アイテムを選択</div>
						</div>
						<div class="crumbs pass passed">
							<p>Step2</p>
							<div>カラー・サイズ<br>枚数入力</div>
						</div>
						<div class="crumbs pass passed">
							<p>Step3</p>
							<div>プリント位置<br>を指定</div>
						</div>
						<div class="crumbs pass">
							<p>Step4</p>
							<div><img alt="カート" src="./img/cart.png" />カート<br>に入れる</div>
						</div>
						<div class="crumbs">
							<p>Step5</p>
							<div>お客様情報<br>の入力</div>
						</div>
						<div class="crumbs step_fin">
							<p>Step6</p>
							<div class="fin">内容を確認して<br>お申し込み</div>
						</div>
					</div>
					<div class="step_inner">
						<h2><ins>Step4</ins>カート</h2>
					
						<div id="estimation_wrap">
							<table>
								<caption>お見積り</caption>
								<thead>
									<tr><th colspan="2">商品名 / カラー</th><th>サイズ</th><th>単価</th><th>枚数</th><th>金額</th><th></th></tr>
								</thead>
								<tfoot>
									<tr><td colspan="4">商品代計</td><td class="ac"><ins class="totamount">0</ins> 枚</td><td class="itemsum">0</td><td></td></tr>
									<tr><td colspan="2">プリント代</td><td colspan="3" class="printing"></td><td class="printfee">0</td><td></td></tr>
									<tr><td colspan="5">送料</td><td class="carriage">0</td><td></td></tr>
									<tr><td colspan="5">代引手数料</td><td class="codfee">0</td><td></td></tr>
									<tr><td colspan="5">袋詰代</td><td class="package">0</td><td></td></tr>
									<tr><td colspan="2">割引</td><td colspan="3" class="discountname"></td><td class="discountfee">0</td><td></td></tr>
									<tr><td colspan="2">特急料金</td><td colspan="3" class="expressinfo"></td><td class="expressfee">0</td><td></td></tr>
									<tr class="foot_sub"><td colspan="5">計</td><td class="base">0</td><td></td></tr>
									<tr class="foot_sub"><td colspan="5">消費税</td><td class="tax">0</td><td></td></tr>
									<tr class="foot_sub"><td colspan="5">カード手数料</td><td class="credit">0</td><td></td></tr>
									<tr class="foot_total"><td colspan="5">お見積り合計</td><td class="total">0</td><td></td></tr>
									<tr class="foot_perone"><td colspan="5">1枚あたり</td><td class="perone">0</td><td></td></tr>
								</tfoot>
								<tbody>
									<tr><td colspan="7"></td><td class="last"></td></tr>
								</tbody>
							</table>
							<p class="note"><span>※</span>お見積りは概算です。デザインの内容によって変更になる場合がございます。</p>
						</div>
						
						<div class="inner option_wrap">
							<table id="option_table">
								<caption class="highlights">割引適用</caption>
								<tbody>
									<tr>
										<th>学生さんですか<ins>※1</ins></th>
										<td>
											<label><input type="radio" name="student" value="0" <?php if(empty($regist['options']['student'])) echo 'checked="checked"'; ?> />いいえ</label>
											<label><input type="radio" name="student" value="3" <?php if($regist['options']['student']==3) echo 'checked="checked"'; ?> />はい<ins>3%OFF</ins></label>
											<label><input type="radio" name="student" value="5" <?php if($regist['options']['student']==5) echo 'checked="checked"'; ?> />2クラス<ins>5%OFF</ins></label>
											<label><input type="radio" name="student" value="7" <?php if($regist['options']['student']==7) echo 'checked="checked"'; ?> />3クラス<ins>7%OFF</ins></label>
										</td>
									</tr>
									<tr>
										<th>レビューを掲載しますか</th>
										<td>
											<label><input type="radio" name="blog" value="0" <?php if(empty($regist['options']['blog'])) echo 'checked="checked"'; ?> />いいえ</label>
											<label><input type="radio" name="blog" value="3" <?php if($regist['options']['blog']==3) echo 'checked="checked"'; ?> />はい<ins>3%OFF</ins></label>
										</td>
									</tr>
									<tr>
										<th>Illustratorで入稿しますか</th>
										<td>
											<label><input type="radio" name="illust" value="0" <?php if(empty($regist['options']['illust'])) echo 'checked="checked"'; ?> />いいえ</label>
											<label><input type="radio" name="illust" value="1" <?php if($regist['options']['illust']==1) echo 'checked="checked"'; ?> />はい<ins>1,000円OFF</ins></label>
										</td>
									</tr>
									<tr>
										<th>弊社のお客様からのご紹介ですか<ins>※2</ins></th>
										<td>
											<label><input type="radio" name="intro" value="0" <?php if(empty($regist['options']['intro'])) echo 'checked="checked"'; ?> />いいえ</label>
											<label><input type="radio" name="intro" value="3" <?php if($regist['options']['intro']==1) echo 'checked="checked"'; ?> />はい<ins>3%OFF</ins></label>
										</td>
									</tr>
									<!--
									<tr>
										<th></th>
										<td><p class="note"><span>※1,※2</span>の割引は、30,000円以上お買い上げの場合に適用されます。</p></td>
									</tr>
									-->
									<tr class="separate">
										<th>袋詰め　<span class="anchor" id="pop_pack">袋詰めとは</span></th>
										<td>
											<label><input type="radio" name="pack" value="0" <?php if(empty($regist['options']['pack'])) echo 'checked="checked"'; ?> />希望しない</label>
											<label><input type="radio" name="pack" value="1" <?php if($regist['options']['pack']==1) echo 'checked="checked"'; ?> />希望する（1枚あたり50円）</label>
										</td>
									</tr>
									<tr>
										<th>お支払方法　<span class="anchor" id="pop_payment">注意点</span></th>
										<td>
											<label><input type="radio" name="payment" value="0" <?php if(empty($regist['options']['payment'])) echo 'checked="checked"'; ?> />銀行振込</label>
											<label><input type="radio" name="payment" value="2" <?php if($regist['options']['payment']==2) echo 'checked="checked"'; ?> />現金（工場で受取）</label>
											<label><input type="radio" name="payment" value="1" <?php if($regist['options']['payment']==1) echo 'checked="checked"'; ?> />代金引換（手数料800円）</label>
											<br>
											<label><input type="radio" name="payment" value="3" <?php if($regist['options']['payment']==3) echo 'checked="checked"'; ?> />カード決済（手数料5％）</label>
										</td>
									</tr>
								</tbody>
							</table>
							
							<div class="line">
								<label class="title">ご希望納期</label><input class="datepicker" id="deliveryday" type="text" size="14" name="deliveryday" value="<?php echo $regist['options']['deliveryday']; ?>" <?php if($regist['options']['nodeliday']==1) echo 'disabled'; ?> />
								<label><input type="checkbox" name="nodeliday" id="nodeliday" value="1" <?php if($regist['options']['nodeliday']==1) echo 'checked="checked"'; ?> > 納期の指定なし</label>
								<p id="express_notice"><span class="highlights">※<ins></ins></span><span class="anchor" id="pop_express">特急料金について</span></p>
								<p>
									<label class="title">お届時間帯の指定</label>
				 					<select name="deliverytime" id="deliverytime">
				 					<?php
										$option = '<option value="0">---</option>
				 						<option value="1">午前中</option>
				 						<option value="2">12:00-14:00</option>
				 						<option value="3">14:00-16:00</option>
				 						<option value="4">16:00-18:00</option>
				 						<option value="5">18:00-20:00</option>
				 						<option value="6">20:00-21:00</option>';
										$option = str_replace('value="'.$regist['options']['deliverytime'].'"', 'value="'.$regist['options']['deliverytime'].'" selected="selected"', $option);
										echo $option;
									?>
				 					</select>
			 					</p>
							</div>
						</div>
						
						<div class="inner">
							<h3 class="heading_mark">デザインの画像ファイルをお持ちの方はこちらから添付してください</h3>
							<form enctype="multipart/form-data" method="post" target="upload_iframe" action="/php_libs/orders.php" name="uploaderform" id="uploaderform">
								<input type="hidden" value="update" name="act" />
								<input type="hidden" value="attach" name="mode" />
								<input type="hidden" value="<?php echo $regist['attach'][0]['img']['name']; ?>" name="attachname[]" />
								<p><input type="file" onChange="this.form.submit()" name="attach[]" size="19" title="デザインファイルを指定してください" /><span class="del_attach"><img src="/common/img/delete.png" alt="取消">取消</span></p>
								<p><span class="add_attach btn_sub">別の添付ファイルを追加</span></p>
								<h4>デザインについてのご要望など</h4>
								<textarea id="note_design" name="note_design"><?php echo $user['note_design']; ?></textarea>
							</form>
							
							<div class="chapter">
								<h4>手描きのデザイン（ラフスケッチ）でプリントをご希望の場合</h4>
								<p>FAXでのお申し込みができます、<a href="/contact/faxorderform.pdf" target="_blank">FAX用フォーム</a>をプリントして送信してください。</p>
								<p>FAX: <?php echo _OFFICE_FAX;?></p>
							</div>
						</div>
						
						<div class="inner">
							<h3 class="heading_mark">プリントするデザインの色がお決まりの方はご記入ください</h3>
							<p class="note">例　前→レッド、　背面→ホワイト</p>
							<textarea id="note_printcolor" name="note_printcolor"><?php echo $user['note_printcolor']; ?></textarea>
						</div>
						
						<div class="inner">
							<h3 class="heading_mark">デザインテンプレートをご利用の場合</h3>
							<p class="note">例　ダンス 1</p>
							<textarea id="note_template" name="note_template"><?php echo $user['note_template']; ?></textarea>
						</div>
						
						<div class="arrow_line"><div class="arrow prev" rel="0"><span>別の商品を見る</span></div><div class="step_next goto_user"onclick="ga('send','event','order','click','step4', 100 );">次へ進む</div></div>
                    </div>
				</div>
				
				<div id="step5">
					<div class="heading clearfix"><p class="arrow prev"><span>戻る</span></p></div>
					<div class="crumbs_wrap">
						<div class="crumbs pass step_first passed">
							<p>Step1</p>
							<div>プリントする<br>アイテムを選択</div>
						</div>
						<div class="crumbs pass passed">
							<p>Step2</p>
							<div>カラー・サイズ<br>枚数入力</div>
						</div>
						<div class="crumbs pass passed">
							<p>Step3</p>
							<div>プリント位置<br>を指定</div>
						</div>
						<div class="crumbs pass passed">
							<p>Step4</p>
							<div><img alt="カート" src="./img/cart.png" />カート<br>に入れる</div>
						</div>
						<div class="crumbs pass">
							<p>Step5</p>
							<div>お客様情報<br>の入力</div>
						</div>
						<div class="crumbs step_fin">
							<p>Step6</p>
							<div class="fin">内容を確認して<br>お申し込み</div>
						</div>
					</div>
					<div class="step_inner">
						<h2><ins>Step5</ins>お客様情報を入力してください</h2>
					
						<div id="userinfo" class="clearfix">
							<p class="comment">「<span>※</span>」印は必須入力です。</p>
							
							<div id="user_wrap" class="clearfix inner">
								<div class="fl">
									<ul>
										<li>
											<label>お名前:<span class="fontred">※</span></label>
											<input type="text" id="customername" name="customername" value="<?php echo $user['customername']; ?>" />　様
										</li>
										<li>
											<label>フリガナ:</label><input type="text" id="ruby" name="ruby" value="<?php echo $user['ruby']; ?>">　様
										</li>
										<li><label>メールアドレス:<span class="fontred">※</span></label><input type="text" id="email" name="email" value="<?php echo $user['email']; ?>" /></li>
										<li><label>お電話番号:<span class="fontred">※</span></label><input type="text" id="tel" name="tel" class="forPhone"  value="<?php echo $user['tel']; ?>" /></li>
										<li><label>弊社ご利用について:<span class="fontred">※</span></label>
											<label class="lbl"><input type="radio" name="repeater" value="1" <?php if($user['repeater']==1) echo 'checked="checked"'; ?> /> 初めてのご利用</label>
											<label class="lbl"><input type="radio" name="repeater" value="2" <?php if($user['repeater']==2) echo 'checked="checked"'; ?> /> 以前にも注文したことがある</label>
										</li>
									</ul>
								</div>
								<div class="fr">
									<ul>
										<li><label>ご住所:<span class="fontred">※</span></label>
											<p>〒<input type="text" name="zipcode" class="forZip" id="zipcode1" value="<?php echo $user['zipcode']; ?>" onkeyup="AjaxZip3.zip2addr(this,'','addr0','addr1');" /></p>
											<p><input type="text" name="addr0" id="addr0" value="<?php echo $user['addr0']; ?>" placeholder="都道府県" maxlength="4" /></p>
											<p><input type="text" name="addr1" id="addr1" value="<?php echo $user['addr1']; ?>" placeholder="文字数は全角28文字、半角56文字です" maxlength="56" class="restrict" /></p>
											<p><input type="text" name="addr2" id="addr2" value="<?php echo $user['addr2']; ?>" placeholder="文字数は全角16文字、半角32文字です" maxlength="32" class="restrict" /></p>
										</li>
										<li><label>ご要望・ご質問など:</label><textarea cols="30" rows="5" name="comment"><?php echo $user['comment']; ?></textarea></li>
									</ul>
								</div>
							</div>
							
							<table class="inner">
								<tbody>
									<tr>
										<th>
											デザインの掲載について:
										</th>
										<td>
											<p class="txt">オリジナルプリントを作成される方の参考に、皆様のデザインをWEB上に<br>掲載させて頂いております。下記の選択をお願い致します。</p>
											<p class="line">
												<label><input type="radio" name="publish" value="0" <?php if(empty($regist['options']['publish'])) echo 'checked="checked"'; ?> /> 掲載可</label>
												<label><input type="radio" name="publish" value="1" <?php if($regist['options']['publish']==1) echo 'checked="checked"'; ?> /> 掲載不可</label>
											</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						
						<div class="arrow_line"><div class="arrow prev"><span>戻る</span></div><div class="step_next goto_confirm"onclick="ga('send','event','order','click','step5', 100 );">確認画面へ</div></div>
                    </div>
				</div>
				
				<div id="step6">
					<div class="heading clearfix"><p class="arrow prev"><span>戻る</span></p></div>
					<div class="crumbs_wrap">
						<div class="crumbs pass step_first passed">
							<p>Step1</p>
							<div>プリントする<br>アイテムを選択</div>
						</div>
						<div class="crumbs pass passed">
							<p>Step2</p>
							<div>カラー・サイズ<br>枚数入力</div>
						</div>
						<div class="crumbs pass passed">
							<p>Step3</p>
							<div>プリント位置<br>を指定</div>
						</div>
						<div class="crumbs pass passed">
							<p>Step4</p>
							<div><img alt="カート" src="./img/cart.png" />カート<br>に入れる</div>
						</div>
						<div class="crumbs pass passed">
							<p>Step5</p>
							<div>お客様情報<br>の入力</div>
						</div>
						<div class="crumbs pass step_fin">
							<p>Step6</p>
							<div class="fin">内容を確認して<br>お申し込み</div>
						</div>
					</div>
					
                    <div class="step_inner">
						<h2><ins>Step6</ins>お申し込み内容をご確認ください</h2>
						
						<form id="orderform" name="orderform" method="post" action="./ordercomplete.php" onSubmit="return false;">
						<?php
							$ticket = htmlspecialchars(md5(uniqid().mt_rand()), ENT_QUOTES);
							$_SESSION['ticket'] = $ticket;
						?>
							<input type="hidden" name="ticket" value="<?php echo $ticket; ?>">
	
							<div class="inner1">
								<table id="conf_item">
									<caption>アイテム</caption>
									<thead>
										<tr>
											<th>商品名 / カラー</th><th>サイズ</th><th>単価</th><th>枚数</th><th>金額</th>
										</tr>
									</thead>
									<tfoot>
										<tr class="foot_sub"><th colspan="4">計</th><td class="base"><ins>0</ins> 円</td><td></td></tr>
										<tr class="foot_sub"><th colspan="4">消費税</th><td class="tax"><ins>0</ins> 円</td><td></td></tr>
										<tr class="foot_sub"><th colspan="4">カード手数料</th><td class="credit"><ins>0</ins> 円</td><td></td></tr>
										<tr class="foot_total"><th colspan="4">お見積り合計</th><td class="tot"><ins>0</ins> 円</td></tr>
										<tr class="foot_perone"><th colspan="4">1枚あたり</th><td class="per"><ins>0</ins> 円</td></tr>
									</tfoot>
									<tbody></tbody>
								</table>
							</div>
	
							<div class="inner1">
								<table id="conf_print">
									<caption>プリント情報</caption>
									<thead>
										<tr>
											<th>アイテム</th><th>プリント位置</th><th>プリントするデザインの色数</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
								<table id="conf_option">
									<tbody>
										<tr><th>添付ファイル</th><td id="conf_attach"></td></tr>
										<tr><th>デザインの備考</th><td id="conf_note_design"></td></tr>
										<tr><th>デザインの色指定</th><td id="conf_note_printcolor"></td></tr>
										<tr><th>テンプレートの指定</th><td id="conf_note_template"></td></tr>
									</tbody>
								</table>
							</div>
	
							<div class="inner1">
								<table id="conf_user">
									<caption>お客様情報</caption>
									<thead>
										<tr>
											<th>項目</th><th>入力内容</th>
										</tr>
									</thead>
									<tbody>
										<tr><th>お名前</th><td id="conf_customername"></td></tr>
										<tr><th>フリガナ</th><td id="conf_ruby"></td></tr>
										<tr><th>メールアドレス</th><td id="conf_email"></td></tr>
										<tr><th>お電話番号</th><td id="conf_tel"></td></tr>
										<tr><th>ご住所</th><td>〒<ins id="conf_zipcode"></ins><br /><ins id="conf_addr0"></ins><ins id="conf_addr1"></ins><ind id="conf_addr2"></ind></td></tr>
										<tr><th>デザイン掲載</th><td id="conf_publish"></td></tr>
										<tr><th>ご希望納期</th><td id="conf_deliveryday"></td></tr>
										<tr><th>お届け時間</th><td id="conf_deliverytime"></td></tr>
										<tr><th>お支払方法</th><td id="conf_payment"></td></tr>
										<tr><th>ご要望・ご質問など</th><td id="conf_comment"></td></tr>
										<tr><th>弊社ご利用について</th><td id="conf_repeater"></td></tr>
									</tbody>
								</table>
							</div>
							
							<fieldset class="sendorder_wrap">
								<legend class="highlights">★重要</legend>
								<div class="inner">
									<h3>注意事項</h3>
									<p>
										制作を開始するにあたり、お電話によるデザインの確認をさせていただいております。<br>
										弊社よりお送りする御見積りメールをご確認いただいた後、
										フリーダイヤル<ins class="highlights"><?php echo _TOLL_FREE;?></ins>までお電話ください。
										（平日10:00-18:00）
									</p>
									<img src="./img/order_6.png" width="652" style="margin-top:10px; border:1px solid #efefef;">
								</div>
								<p><input type="checkbox" value="1" name="agree" id="agree"><label for="agree">確認しました</label></p>
									
								<div>
									<p class="pointer">チェック！</p>
									<div id="sendorder" class="disable_button"onclick="ga('send','event','order','click','step6', 100 );">注文する</div>
								</div>
							</fieldset>
							
							<div class="arrow_line"><div class="arrow prev"><span>戻る</span></div></div>
						</form>	
                    
					</div>
				</div>
			</div>
		
		</div>
		
		<div id="floatingbox">
			<table>
				<caption>お見積り</caption>
				<tbody>
					<tr><th>商品枚数</th><td><span><?php echo number_format($data['amount']); ?></span>枚</td></tr>
					<tr class="total"><th>合計金額</th><td><span><?php echo number_format($total); ?></span>円</td></tr>
					<tr><th>1枚あたり</th><td><span><?php echo number_format($perone); ?></span>円</td></tr>
				</tbody>
			</table>
			<div class="btn_sub viewcart"><img alt="カート" src="./img/cart.png" />カートを見る</div>
		</div>
		
	</div>
	
	<p class="page_top"><span>お申し込みフォーム　ページトップへ</span></p>

	<div class="footer"><?php echo $footer; ?></div>
	
	<iframe name="upload_iframe" style="display: none;"></iframe>

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
