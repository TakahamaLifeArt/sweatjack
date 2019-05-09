<?php
	require_once dirname(__FILE__)."/session_my_handler.php";
	require_once $_SERVER['DOCUMENT_ROOT'].'/../cgi-bin/config.php';
	$myname = $_SERVER['SCRIPT_FILENAME'];
	
	$isTest = false;
	if(strpos(dirname($_SERVER['SCRIPT_NAME']), _TEST_NAME)===1){
		$myname = $_SERVER['DOCUMENT_ROOT'].substr(dirname($_SERVER['SCRIPT_NAME']), strlen(_TEST_NAME)+1).'/'.basename($_SERVER['SCRIPT_NAME']);
		$isTest = true;
	}

	$itemis = 'parker';		// default item.
	$itemname_text = array('parker'=>'パーカー', 'trainer'=>'トレーナー・スウェット', 'jacket'=>'ジャケット', 'champion'=>'チャンピオンパーカー・スウェット', 'pants'=>'スウェットパンツ', 'setup'=>'上下セット');
	$itemcategory_text = array('parker','trainer','pants','jacket','champion');
	$comment = '';
	$pan_navigation = '';
	
	switch($myname){
	case _DOC_ROOT.'index.php':
	case _DOC_ROOT.'t_index.php':
			// $comment = '<p>かっこいいオリジナルスウェットやパーカー作成を！デザイン、納期など、なんでもご相談下さい、スウェットジャックがお手伝いします。</p>';
			$page = 'home';
			break;
	case _DOC_ROOT.'gallery/gallery_body.php':
	case _DOC_ROOT.'gallery/gallery_hood.php':
	case _DOC_ROOT.'gallery/gallery_pants.php':
	case _DOC_ROOT.'gallery/gallery_setup.php':
	case _DOC_ROOT.'gallery/gallery_sleeve.php':
			$comment = '<h1>オリジナルパーカー・スウェット製作例。</h1><p>１枚あたりの製作予算、使用したスウェットやインク、プリントした位置、プリント方法など、オリジナルスウェット製作のご参考に！</p>';
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; これが作れる</li></ul>';
			$page = 'gallery';
			break;
	case _DOC_ROOT.'order/orderform_parker.php':
	case _DOC_ROOT.'order/orderform_pants.php':
	case _DOC_ROOT.'order/orderform_setup.php':
	case _DOC_ROOT.'order/orderform.php':
			$comment = '<h1>オリジナルパーカー・スウェットのお申し込み。</h1><p>見積り金額が自動計算されます。</p>';
			$page = '';
			$gnavi = "navi_1";
			$itemis = substr(basename($myname, '.php'), strpos(basename($myname, '.php'), '_')+1);
			break;
	case _DOC_ROOT.'order/finish.php':
			$comment = '<p>お申し込みを受付いたしました。</p>';
			$page = '';
			$gnavi = "navi_4";
			break;
	case _DOC_ROOT.'order_new/index.php':
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; お申し込みフォーム</li></ul>';
			$page = '';
			break;
	case _DOC_ROOT.'order_new/ordercomplete.php':
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; お申し込みメール送信</li></ul>';
			$page = '';
			break;
	case _DOC_ROOT.'order/register.php':
			$comment = '<h1>お届け先の入力。</h1><p>お名前・ご連絡先・ご住所などをご入力ください。<strong>領収証も、この画面で発行</strong>できます。</p>';
			$page = '';
			$gnavi = "navi_2";
			break;
	case _DOC_ROOT.'order/confirm.php':
			$comment = '<h1>ご注文内容をご確認ください。</h1><p>ご注文の申込をするボタンで、ご注文（申込）メールを送信いたします。</p>';
			$page = '';
			$gnavi = "navi_3";
			break;
	case _DOC_ROOT.'lineup/lineup_parker.php':
	case _DOC_ROOT.'https://www.takahama428.com/items/category/sweat/':
			/*
			$comment = '<h1>オリジナルパーカーを選ぼう。</h1><p><strong>メーカー価格（メ）</strong>の<strong>39〜48％OFF!!!</strong> の超目玉特価です！</p>';
			$itemis = substr(basename($myname, '.php'), strpos(basename($myname, '.php'), '_')+1);
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; '.$itemname_text[$itemis].'一覧</li></ul>';
			*/		
	 		$page = basename($myname, '.php');
			break;
	case _DOC_ROOT.'lineup/lineup_trainer.php':
	case _DOC_ROOT.'https://www.takahama428.com/items/category/sweat/?cat=2&shilhouette%5B%5D=15':
			/*
			$comment = '<h1>オリジナルトレーナー・スウェットを選ぼう。</h1><p><strong>メーカー価格（メ）</strong>の<strong>39〜48％OFF!!!</strong> の超目玉特価です！</p>';
			$itemis = substr(basename($myname, '.php'), strpos(basename($myname, '.php'), '_')+1);
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; '.$itemname_text[$itemis].'一覧</li></ul>';
			*/
			$page = basename($myname, '.php');
			break;
	case _DOC_ROOT.'lineup/lineup_jacket.php':
			/*
			$comment = '<h1>オリジナルジャケットを選ぼう。</h1><p><strong>メーカー価格（メ）</strong>の<strong>39〜48％OFF!!!</strong> の超目玉特価です！</p>';
			$itemis = substr(basename($myname, '.php'), strpos(basename($myname, '.php'), '_')+1);
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; '.$itemname_text[$itemis].'一覧</li></ul>';
			*/
			$page = basename($myname, '.php');
			break;
	case _DOC_ROOT.'lineup/lineup_champion.php':
			/*
			$comment = '<h1>オリジナルチャンピオンパーカー・スウェットを選ぼう。</h1><p><strong>メーカー価格（メ）</strong>の<strong>39〜48％OFF!!!</strong> の超目玉特価です！</p>';
			$itemis = substr(basename($myname, '.php'), strpos(basename($myname, '.php'), '_')+1);
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; '.$itemname_text[$itemis].'一覧</li></ul>';
			*/
			$page = basename($myname, '.php');
			break;
	case _DOC_ROOT.'lineup/lineup_pants.php':
	case _DOC_ROOT.'https://www.takahama428.com/items/category/sweat/?cat=2&shilhouette%5B%5D=16':
			/*
			$comment = '<h1>オリジナルスウェットパンツを選ぼう。</h1><p><strong>メーカー価格（メ）</strong>の<strong>39〜48％OFF!!!</strong> の超目玉特価です！</p>';
			$itemis = substr(basename($myname, '.php'), strpos(basename($myname, '.php'), '_')+1);
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; '.$itemname_text[$itemis].'一覧</li></ul>';
			*/
			$page = basename($myname, '.php');
			break;
	case _DOC_ROOT.'https://www.takahama428.com/items/category/t-shirts/':
			/*
			$comment = '<h1>オリジナルTシャツを選ぼう。</h1><p><strong>メーカー価格（メ）</strong>の<strong>39〜48％OFF!!!</strong> の超目玉特価です！</p>';
			$itemis = substr(basename($myname, '.php'), strpos(basename($myname, '.php'), '_')+1);
			$pan_navigation = '<ul><li><a href="/">オリジナルTシャツTOP</a></li><li>&gt; '.$itemname_text[$itemis].'一覧</li></ul>';
			*/
			$page = basename($myname, '.php');
			break;
	case _DOC_ROOT.'https://www.takahama428.com/items/category/outer/':
			/*
			$comment = '<h1>オリジナルブルゾンを選ぼう。</h1><p><strong>メーカー価格（メ）</strong>の<strong>39〜48％OFF!!!</strong> の超目玉特価です！</p>';
			$itemis = substr(basename($myname, '.php'), strpos(basename($myname, '.php'), '_')+1);
			$pan_navigation = '<ul><li><a href="/">オリジナルブルゾンTOP</a></li><li>&gt; '.$itemname_text[$itemis].'一覧</li></ul>';
			*/
			$page = basename($myname, '.php');
			break;
	case _DOC_ROOT.'lineup/lineup_setup.php':
			$comment = '<h1>オリジナルパーカー・スウェットパンツを選ぼう。</h1><p><strong>メーカー価格（メ）</strong>の<strong>39〜48％OFF!!!</strong> の超目玉特価です！</p>';
			$itemis = substr(basename($myname, '.php'), strpos(basename($myname, '.php'), '_')+1);
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; '.$itemname_text[$itemis].'一覧</li></ul>';
			$page = basename($myname, '.php');
			break;
	case _DOC_ROOT.'lineup/detail_parker.php':
			$comment = '<h1>パーカー・スウェットを選ぼう。</h1><p><strong>メーカー価格（メ）</strong>の<strong>39〜48％OFF!!!</strong> の超目玉特価です！</p>';
			$itemis = substr(basename($myname, '.php'), strpos(basename($myname, '.php'), '_')+1);
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; <a href="/lineup/lineup_'.$itemis.'.php">'.$itemname_text[$itemis].'一覧</a></li><li>&gt; アイテム詳細</li></ul>';
			$page = '';
			break;
	case _DOC_ROOT.'lineup/detail_pants.php':
			$comment = '<h1>パンツを選ぼう。</h1><p><strong>メーカー価格（メ）</strong>の<strong>39〜48％OFF!!!</strong> の超目玉特価です！</p>';
			$itemis = substr(basename($myname, '.php'), strpos(basename($myname, '.php'), '_')+1);
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; <a href="/lineup/lineup_'.$itemis.'.php">'.$itemname_text[$itemis].'一覧</a></li><li>&gt; アイテム詳細</li></ul>';
			$page = '';
			break;
	case _DOC_ROOT.'lineup/detail_item.php':
			if(isset($_GET['c'])){
				$itemis = $itemcategory_text[$_GET['c']];
				
			}
			$comment = '<h1>オリジナル'.$itemname_text[$itemis].'を選ぶ時のポイントは生地の厚さ（オンス）と裏生地（パイル・裏起毛）！！</h1>';
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; <a href="/lineup/lineup_'.$itemis.'.php">'.$itemname_text[$itemis].'一覧</a></li><li>&gt; アイテム詳細</li></ul>';
			$page = '';
			break;
	case _DOC_ROOT.'lineup/detail_setup.php':
			$comment = '<h1>オリジナルパーカー・スウェットパンツを選ぶ時のポイントは生地の厚さ（オンス）と裏生地（パイル・裏起毛）！！</h1>';
			$itemis = substr(basename($myname, '.php'), strpos(basename($myname, '.php'), '_')+1);
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; <a href="/lineup/lineup_'.$itemis.'.php">'.$itemname_text[$itemis].'一覧</a></li><li>&gt; アイテム詳細</li></ul>';
			$page = '';
			break;
	case _DOC_ROOT.'guide/original_parker.php':
			$page = 'howto';
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; オリジナルパーカーの作成</li></ul>';
			break;
	case _DOC_ROOT.'guide/intro.php':
			$page = 'intro';
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; はじめての方へ</li></ul>';
			break;
	case _DOC_ROOT.'guide/guide.php':
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; ご注文の流れ</li></ul>';
			$page = 'orderflow';
			break;
	case _DOC_ROOT.'guide/design_tech.php':
			$comment = '<h1>オリジナルパーカー・スウェット製作ガイド。</h1><p>全力バックアップ！のコーナーです。製作費の出し方、割引の使い方、プリントの違い、デザイン・テクニックなど、大公開！</p>';
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; デザインの作り方</li></ul>';
			$page = 'design_tech';
			break;
	case _DOC_ROOT.'guide/guide_3days.php':
			$comment = '<h1>オリジナルパーカー・スウェット製作ガイド。</h1><p>全力バックアップ！のコーナーです。製作費の出し方、割引の使い方、プリントの違い、デザイン・テクニックなど、大公開！</p>';
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; オリジナルスウェットができるまで</li></ul>';
			$page = 'printing';
			break;
	case _DOC_ROOT.'guide/guide_estimate.php':
			$comment = '<h1>オリジナルパーカー・スウェット製作ガイド。</h1><p>全力バックアップ！のコーナーです。製作費の出し方、割引の使い方、プリントの違い、デザイン・テクニックなど、大公開！</p>';
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; お見積りの仕方</li></ul>';
			$page = 'guide_estimate';
			break;
	case _DOC_ROOT.'guide/catalog.php':
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; カタログ・サンプル</li></ul>';
			$page = 'catalog';
			break;
	case _DOC_ROOT.'guide/discount.php':
			$comment = '<h1>オリジナルパーカー・スウェット製作ガイド。</h1><p>全力バックアップ！のコーナーです。製作費の出し方、割引の使い方、プリントの違い、デザイン・テクニックなど、大公開！</p>';
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; 割引</li></ul>';
			$page = 'discount';
			break;
	case _DOC_ROOT.'guide/font.php':
			$comment = '<h1>オリジナルパーカー・スウェット製作ガイド。</h1><p>全力バックアップ！のコーナーです。製作費の出し方、割引の使い方、プリントの違い、デザイン・テクニックなど、大公開！</p>';
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; 使えるフォント</li></ul>';
			$page = 'font';
			break;
	case _DOC_ROOT.'guide/ink.php':
			$comment = '<h1>オリジナルパーカー・スウェット製作ガイド。</h1><p>全力バックアップ！のコーナーです。製作費の出し方、割引の使い方、プリントの違い、デザイン・テクニックなど、大公開！</p>';
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; 使えるインク・シート</li></ul>';
			$page = 'ink';
			break;
	case _DOC_ROOT.'guide/print_guide.php':
			$comment = '<h1>オリジナルパーカー・スウェット製作ガイド。</h1><p>全力バックアップ！のコーナーです。製作費の出し方、割引の使い方、プリントの違い、デザイン・テクニックなど、大公開！</p>';
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; プリント方法</li></ul>';
			$page = 'print_guide';
			break;
	case _DOC_ROOT.'guide/print_navi.php':
			$comment = '<h1>オリジナルパーカー・スウェット製作ガイド。</h1><p>全力バックアップ！のコーナーです。製作費の出し方、割引の使い方、プリントの違い、デザイン・テクニックなど、大公開！</p>';
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; プリント条件から選ぶ</li></ul>';
			$page = 'print_navi';
			break;
	case _DOC_ROOT.'guide/sheet.php':
			$comment = '<h1>オリジナルパーカー・スウェット製作ガイド。</h1><p>全力バックアップ！のコーナーです。製作費の出し方、割引の使い方、プリントの違い、デザイン・テクニックなど、大公開！</p>';
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; デザイン用紙ダウンロード</li></ul>';
			$page = 'sheet';
			break;
	case _DOC_ROOT.'guide/sweat_navi.php':
			$comment = '<h1>オリジナルパーカー・スウェット製作ガイド。</h1><p>全力バックアップ！のコーナーです。製作費の出し方、割引の使い方、プリントの違い、デザイン・テクニックなど、大公開！</p>';
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; アイテムの条件から探す</li></ul>';
			$page = 'sweat_navi';
			break;
	case _DOC_ROOT.'faq/index.php':
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; よくある質問</li></ul>';
			$page = 'faq';
			break;
	case _DOC_ROOT.'faq/cancel.php':
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; <a href="/faq/">よくある質問</a></li><li>&gt; 変更・キャンセルについて Q&amp;A</li></ul>';
			$page = 'cancel';
			break;
	case _DOC_ROOT.'faq/cost.php':
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; <a href="/faq/">よくある質問</a></li><li>&gt; 料金について Q&amp;A</li></ul>';
			$page = 'cost';
			break;
	case _DOC_ROOT.'faq/delivery.php':
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; <a href="/faq/">よくある質問</a></li><li>&gt; お届けについて Q&amp;A</li></ul>';
			$page = 'delivery';
			break;
	case _DOC_ROOT.'faq/design.php':
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; <a href="/faq/">よくある質問</a></li><li>&gt; デザインについて Q&amp;A</li></ul>';
			$page = 'design';
			break;
	case _DOC_ROOT.'faq/items.php':
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; <a href="/faq/">よくある質問</a></li><li>&gt; 商品について Q&amp;A</li></ul>';
			$page = 'items';
			break;
	case _DOC_ROOT.'faq/order.php':
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; <a href="/faq/">よくある質問</a></li><li>&gt; ご注文について Q&amp;A</li></ul>';
			$page = 'order';
			break;
	case _DOC_ROOT.'faq/payment.php':
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; <a href="/faq/">よくある質問</a></li><li>&gt; お支払いについて Q&amp;A</li></ul>';
			$page = 'payment';
			break;
	case _DOC_ROOT.'faq/printing.php':
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; <a href="/faq/">よくある質問</a></li><li>&gt; プリントについて Q&amp;A</li></ul>';
			$page = 'printing';
			break;
	case _DOC_ROOT.'faq/printing.php':
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; <a href="/faq/">よくある質問</a></li><li>&gt; 変更・キャンセルについて Q&amp;A</li></ul>';
			$page = 'printing';
			break;
			

	/*
	case _DOC_ROOT.'temp/temp06.php':
			$comment = 'ただ今、おとりおき中のオリジナルスウェットです。';
			$page = 'hold';
			break;
	*/

	case _DOC_ROOT.'calendar/calendar.php':
			$comment = '<h1>最短お届け日を自動計算できます！</h1><p><a href="/estimate/sos.php#ad_dtl_6">有料オプション特急製作</a> で、業界最特急クラス、<strong>翌日仕上げ</strong>も可能！';
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; 早い！最短１日仕上げ</li></ul>';
			$page = 'delidate';
			break;
	case _DOC_ROOT.'estimate/estimate.php':
			$comment = '<h1>オリジナルパーカー・スウェットの製作費自動計算。</h1><p>今すぐ計算できます！（<strong>プリント位置を指定する</strong>→<strong>スウェットを選ぶ</strong>→<strong>枚数を入力</strong>→<strong>割引をチェック</strong>→<strong>完了！</strong>）</p>';
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; 製作費自動計算</li></ul>';
			$page = 'estimation';
			break;
	case _DOC_ROOT.'estimate/sos.php':
			$comment = "<h1>予算オーバー？ なんとかなるかも！</h1><p>オリジナルパーカー・スウェットの製作費、Let’sダウン！！！</p>";
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; <a href="/estimate/estimate.php">製作費自動計算</a></li><li>&gt; 安いパーカー作成裏ワザ</li></ul>';
			$page = 'sos';
			break;
	case _DOC_ROOT.'estimate/jumboprint.php':
			$comment = '<h1>ジャンボプリント！</h1><p>サイズは、なんと！MAX <strong">H43cm×W32cm</strong> の特大サイズ！当社標準（業界標準）サイズの<strong">約1.5倍</strong>！</p>';
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; ジャンボプリント</li></ul>';
			$page = 'jumboprint';
			break;
	case _DOC_ROOT.'customer/contact.php':
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; お問い合わせ</li></ul>';
			$page = '';
			break;
	case _DOC_ROOT.'company/company.php':
			$comment = '<h1>企業情報。</h1><p>なんと！東京23区の下町に、3F建てのプリント工場（兼オフィス）がひょっこりあります。近くの土手からは東京スカイツリーも丸見えです。</p>';
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; 企業情報</li></ul>';
			$page = '';
			break;
	case _DOC_ROOT.'company/factory.php':
			$comment = '<h1>東京工場のご案内。</h1><p>なんと！東京23区の下町に、3F建てのプリント工場（兼オフィス）がひょっこりあります。近くの土手からは東京スカイツリーも丸見えです。</p>';
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; 工場案内</li></ul>';
			$page = '';
			break;
	case _DOC_ROOT.'company/member.php':
			$comment = '<h1>作り手。</h1><p>なんと！東京23区の下町に、3F建てのプリント工場（兼オフィス）がひょっこりあります。近くの土手からは東京スカイツリーも丸見えです。</p>';
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; 作り手</li></ul>';
			$page = '';
			break;
	case _DOC_ROOT.'policy/policy.php':
			$comment = '<h1>プライバシーポリシー。</h1><p>タカハマライフアートでは、弊社に関係する方々すべての個人情報の管理・保護を重視しています。</p>';
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; プライバシーポリシー</li></ul>';
			$page = '';
			break;
	case _DOC_ROOT.'law/law.php':
			$term = date(Y)-1998;
			$comment = '<h1>特定商取引法にもとづく表記。</h1><p>タカハマライフアートの創業は1998年。プリントひと筋'.$term.'年の実績があります。</p>';
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; 特定商取引法</li></ul>';
			$page = '';
			break;
	case _DOC_ROOT.'sitemap/sitemap.php':
			$comment = '<h1>サイトマップ</h1></p>';
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; サイトマップ</li></ul>';
			$page = '';
			break;
	case _DOC_ROOT.'design/index.php':
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; デザインテンプレート集</li></ul>';
			$page = 'design_temp';
			break;
	case _DOC_ROOT.'design/detail.php':
			$pan_navigation = '';
			$page = 'design_temp';
			break;
	case _DOC_ROOT.'dancer/index.php':
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; ダンス</li></ul>';
			$page = 'dance';
			break;
			
	case _DOC_ROOT.'lp1/index.php':
			$pan_navigation = '<ul><li><a href="/">オリジナルパーカー・スウェットTOP</a></li><li>&gt; 無料お問合せ</li></ul>';
			$page = 'lp1';
			break;
			
	default: $comment = '';
	}


    /*	global menu
    *	2013-09-10	適用
    */
    
    // 各種案内
	$menu .= '<ul class="menu">';
	
		$menu .= '<li class="menu__single">';
		
		$menu .= '<a href="#" class="init-bottom">各種案内</a>';
		
		$menu .= '<ul class="menu__second-level" style="top: 50px;">';

		
		if($page!='orderflow') $menu .= '<li><a href="https://www.takahama428.com/guide/orderflow.php" rel=“nofollow">ご注文の流れ</a></li>';
		else $menu .= '<li><p>ご注文の流れ</p></li>';
		
		if($page!='jumboprint') $menu .= '<li><a href="https://www.takahama428.com/price/estimate.php" rel=“nofollow">１０秒見積もり</a></li>';
		else $menu .= '<li><p>１０秒見積もり</p></li>';
		
		if($page!='calendar') $menu .= '<li><a href="https://www.takahama428.com/delivery/" rel=“nofollow">お届け計算</a></li>';
		else $menu .= '<li><p>お届け計算</p></li>';
		
		if($page!='print_guide') $menu .= '<li><a href="/guide/print_guide1.php">プリント方法</a></li>';
		else $menu .= '<li><p>プリント方法</p></li>';
		
		$menu .= '</ul>';
	
	        $menu .= '</li>';
	
	// アイテム
	        $menu .= '<li class="menu__single">';
	
		$menu .= '<a href="#" class="init-bottom">アイテム</a>';

		$menu .= '<ul class="menu__second-level" style="top: 50px;">';
		
		if($page!='lineup_parker') $menu .= '<li><a href="https://www.takahama428.com/items/category/sweat/" rel=“nofollow">パーカー</a></li>';
		else $menu .= '<li><p>パーカー</p></li>';
		
		if($page!='lineup_trainer') $menu .= '<li><a href="https://www.takahama428.com/items/category/sweat/?cat=2&shilhouette%5B%5D=15" rel=“nofollow">トレーナー</a></li>';
		else $menu .= '<li><p>トレーナー</p></li>';
		
		if($page!='lineup_pants') $menu .= '<li><a href="https://www.takahama428.com/items/category/sweat/?cat=2&shilhouette%5B%5D=16" rel=“nofollow">パンツ</a></li>';
		else $menu .= '<li><p>パンツ</p></li>';
		
		if($page!='lineup_t-shirts') $menu .= '<li><a href="https://www.takahama428.com/items/category/t-shirts/" rel=“nofollow">Tシャツ</a></li>';
		else $menu .= '<li><p>Tシャツ</p></li>';
		
		if($page!='lineup_outer') $menu .= '<li><a href="https://www.takahama428.com/items/category/outer/" rel=“nofollow">ブルゾン</a></li>';
		else $menu .= '<li><p>ブルゾン</p></li>';
		
		$menu .= '</ul>';
	
	        $menu .= '</li>';
	
	// デザイン
		$menu .= '<li class="menu__single">';
	
		$menu .= '<a href="#" class="init-bottom">デザイン</a>';

		$menu .= '<ul class="menu__second-level" style="top: 50px;">';
		
		if($page!='gallery') $menu .= '<li><a href="/gallery/gallery_body1.php">制作実例</a></li>';
		else $menu .= '<li><p>制作実例</p></li>';
		
		if($page!='font') $menu .= '<li><a href="/guide/ink_font.php">インクとフォント</a></li>';
		else $menu .= '<li><p>インクとフォント</p></li>';
		
		if($page!='design_temp') $menu .= '<li><a href="/design/index1.php">テンプレート</a></li>';
		else $menu .= '<li><p>テンプレート</p></li>';
		
		if($page!='sheet') $menu .= '<li><a href="/guide/sheet1.php">デザイン用紙</a></li>';
		else $menu .= '<li><p>デザイン用紙</p></li>';
		
		$menu .= '</ul>';
	
		$menu .= '</li>';
	
	// お申込み
		$menu .= '<li class="menu__single">';
	
		$menu .= '<a href="#" class="init-bottom">申し込み</a>';

		$menu .= '<ul class="menu__second-level" style="top: 50px;">';
		
		if($page!='order') $menu .= '<li><a href="https://www.takahama428.com/order/order_entrace.php" rel=“nofollow">申し込み</a></li>';
		else $menu .= '<li><p>申し込み</p></li>';
		
		if($page!='contact') $menu .= '<li><a href="/customer/contact1.php">お問い合わせ</a></li>';
		else $menu .= '<li><p>お問い合わせ</p></li>';
				
		if($page!='estimation') $menu .= '<li><a href="/guide/catalog1.php">資料請求</a></li>';
		else $menu .= '<li><p>資料請求</p></li>';
		
		if($page!='discount') $menu .= '<li><a href="/guide/discount1.php">割引プラン</a></li>';
		else $menu .= '<li><p>割引プラン</p></li>';

		$menu .= '</ul>';
		
		$menu .= '</li>';
	
	// 会社概要
		$menu .= '<li class="menu__single">';
	
		$menu .= '<a href="#" class="init-bottom">会社概要</a>';

		$menu .= '<ul class="menu__second-level" style="top: 50px;">';
		
		if($page!='gallery') $menu .= '<li><a href="/company/company1.php">企業情報</a></li>';
		else $menu .= '<li><p>企業情報</p></li>';
		
		if($page!='font') $menu .= '<li><a href="/law/law1.php">特定商取引</a></li>';
		else $menu .= '<li><p>特定商取引</p></li>';
		
		if($page!='design_temp') $menu .= '<li><a href="/policy/policy1.php">プライバシーポリシー</a></li>';
		else $menu .= '<li><p>プライバシーポリシー</p></li>';
		
		if($page!='sheet') $menu .= '<li><a href="https://www.takahama428.com/guide/faq.php" rel=“nofollow">Q&A</a></li>';
		else $menu .= '<li><p>Q&A</p></li>';
		
		$menu .= '</ul>';
	
		$menu .= '</li>';
		$menu .= '</ul>';

	/**
	 * header
	 * 2013-09-10	適用
	 * 2013-10-22	h1を変更
	 * 2016-09-21	homeのタグを変更
	 * 2016-09-28	h1を修正
	 */


	$header .= '<div id="header">';
	if($page=='home'){
		$header .= '<h1  class="header1">オリジナルパーカーの作成ならスウェットジャック</a></h1>';
	}else{
		$header .= '<h1  class="header1">オリジナルパーカーの作成ならスウェットジャック</a></h1>';
	}
	$header .='<h2 class="site-title"><a href="http://www.sweatjack.jp/"><img src="/img/home/logo_01.png" alt="SweatJack"  width="100%" rel=“nofollow"/></a></h2>';
	$header .='<div class="function">';
	$header .='<p class="btn-cart"><a href="/customer/contact1.php"><img src="/img/home/hd_mail.png" alt="お問い合わせ"/><span style="position:absolute; top:35%;">お問い合わせ</span></a></p>';
	$header .='<p class="btn-login"><a href="#"><img src="/img/home/hd_tel.png" alt="0120-130-428" /><span style="position:absolute; top:25%;">0120-130-428<br>営業時間(10:00-18:00)</span></a></p>';
	$header .='<p class="btn-cart"><a href="https://www.takahama428.com/order/?update=1"><img src="/img/home/hd_cart.png" rel=“nofollow" alt="カート" /><span style="position:absolute; top:35%;">カート</span></a></p>';
	//$header .='<p class="btn-mypage"><a href="/user/login.php"><span style="position:absolute; top:35%;">マイページ</span></a></p>';
	$header .='<p class="btn-mypage"><a href="https://www.takahama428.com/user/login.php" rel=“nofollow"><img src="/img/home/hd_mypage.png" style="width:34px;height:34px;"alt="カート" /><span style="position:absolute; top:35%;">マイページ</span></a></p>';
	$header .='</div>';	
	if(!empty($_SESSION['me'])){
		$wel_name = mb_convert_encoding($_SESSION['me']['customername'], 'euc-jp', 'utf-8');
		$header .='<div class="userinfo"><p class="wel_name" style="font-weight:bold">ようこそ '.$wel_name.' 様　　　</p><a href="/user/logout.php" id="mypage_btn">ログアウト</a></div>';	
	}
	
	/* header 
	*	2012-11-16　適用
	*	2013-09-10	廃止
	*
	$header = '<div class="topline">';
	if($page=='home'){
		$header .= '<h1>かっこいいオリジナルスウェットやパーカーの作成はスウェットジャック！</h1>';
	}else{
		$header .= '<p class="header1">かっこいいオリジナルスウェットやパーカーの作成はスウェットジャック！</p>';
	}
	$header .= '<a href="/guide/guide.php" id="guidance"></a>';
	$header .= '<a href="/company/company.php" id="aboutme"></a>';
	$header .= '<a href="/sitemap/sitemap.php" id="sitemap"></a>';
	$header .= '</div>';
	$header .= '<div class="inner">';
	$header .= '<a href="/" id="logo"><img alt="デザイン、納期など、なんでもご相談下さい！スウェットジャックがお手伝いします。" src="/image/logo.jpg" /></a>';
	$header .= '<img alt="お問い合わせ　0120-130-428" src="/image/contact.jpg" class="contact" />';
	$header .= '<a href="/customer/contact.php" class="btn_contact"></a>';
	$header .= '</div>';
	*/
	
	/*	header
	*	2012-11-16	廃止
    $header = '<div class="mainmenu">';

    if($page=='home') $header .= '<p class="home"></p>';
    else $header .= '<a class="home" href="/"></a>';

    if($page=='gallery') $header .= '<p class="gallery"></p>';
    else $header .= '<a class="gallery" href="/gallery/gallery_body.php"></a>';

    if($page=='lineup') $header .= '<p class="lineup"></p>';
    else $header .='<a class="lineup" href="/lineup/lineup_parker.php"></a>';

    if($page=='guide') $header .= '<p class="guide"></p>';
    else $header .='<a  class="guide" href="/guide/guide.php"></a>';

    if($page=='faq') $header .= '<p class="faq"></p>';
    else $header .='<a  class="faq" href="/faq/cost.php"></a>';

    if($page=='schedule') $header .= '<p class="delidate"></p>';
    else $header .='<a class="delidate" href="/calendar/calendar.php"></a>';

    if($page=='estimation') $header .= '<p class="estimation"></p>';
    else $header .='<a class="estimation" href="/estimate/estimate.php"></a>';

    $header .= '</div>';
    */
    
    
    /* global menu
    	2012-11-16　追加
    	2013-09-10	廃止
    
	$menu = '<ul id="gmenu">';
	
	if($page!='orderflow') $menu .= '<li><a href="/guide/guide.php" id="orderflow"></a></li>';
	else $menu .= '<li><p id="orderflow"></p></li>';
	
	if($page!='lineup') $menu .= '<li><a href="/lineup/lineup_'.$itemis.'.php" id="lineup"></a></li>';
	else $menu .= '<li><p id="lineup"></p></li>';
	
	if($page!='designtech') $menu .= '<li><a href="/guide/design_tech.php" id="design"></a>';
	else $menu .= '<li><p id="design"></p>';
	
		$menu .= '<ul>';
		if($page!='gallery') $menu .= '<li><a href="/gallery/gallery_body.php" id="designsample"></a></li>';
		else $menu .= '<li><p id="designsample"></p></li>';
		$menu .= '</ul>';
	
	$menu .= '</li>';
	
	if($page!='estimation') $menu .= '<li><a href="/estimate/estimate.php" id="price"></a></li>';
	else $menu .= '<li><p id="price"></p></li>';
	
	if($page!='schedule') $menu .= '<li><a href="/calendar/calendar.php" id="delivery"></a></li>';
	else $menu .= '<li><p id="delivery"></p></li>';
	
	if($page!='printing') $menu .= '<li><a href="/guide/guide_3days.php" id="print"></a>';
	else $menu .= '<li><p id="print"></p>';
	
		$menu .= '<ul>';
		if($page!='jumboprint') $menu .= '<li><a href="/estimate/jumboprint.php" id="jumboprint"></a></li>';
		else $menu .= '<li><p id="jumboprint"></p></li>';
		$menu .= '</ul>';
	
	$menu .= '</li>';
	
	if($page!='faq') $menu .= '<li><a href="/faq/cost.php" id="faq"></a></li>';
	else $menu .= '<li><p id="faq"></p></li>';
	$menu .= '</ul>';
	*/
	
	
	/*	message bar 
	*	2012-11-16　追加
	*/
	if(!empty($comment)){
		$msgbar .= '<div class="messagebar"><div>'.$comment.'</div>';
		if(!empty($pan_navigation)){
			$msgbar .= $pan_navigation;
		}
		$msgbar .= '</div>';
	}else if(!empty($pan_navigation)){
		$msgbar = '<div class="messagebar">'.$pan_navigation.'</div>';
	}


    /* navigation bar */
    if(!empty($gnavi)){
    	if(isset($_SESSION['orders']['item'])){
			$refpage = $_SESSION['orders']['item']['refpage'];	// 注文入力ページへのパス
		}
		
		/* 2012-12-31 注文フローをリニューアル
		if(!$isTest){
			$navi_info = array(	array("ラインナップ","/lineup/lineup_parker.php"),
		    					array("スウェット選ぶ","/lineup/lineup_parker.php"),
		    					array("ご注文の入力",$refpage),
		    					array("お届け先の入力","/order/register.php"),
		    					array("ご注文内容の確認","/order/confirm.php"),
		    					array("お申込完了！","/order/finish.php")
		    					);
		    $menu .= '<div class="global_navi '.$gnavi.'"><ul>';
		    $menu .= '<li><a href="/">HOME</a></li>';
		    $navi_id = substr($gnavi, -1)+1;
		    for($i=0; $i<6; $i++){
		    	if($i<$navi_id){
		    		$cls[$i] = "pass";
		    		$navi_page = '<a href="'.$navi_info[$i][1].'">'.$navi_info[$i][0].'</a>';
		    	}else if($i==$navi_id){
		    		$cls[$i] = "curr";
		    		$navi_page = $navi_info[$i][0];
		    	}else{
		    		$cls[$i] = "none";
		    		$navi_page = $navi_info[$i][0];
		    	}
		    	$menu .= '<li class="'.$cls[$i].'">'.$navi_page.'</li>';
		    }
		    $menu .= '</ul></div>';
	    }else{
	    */
	    
		    $navi_info = array(	array("ご注文の入力",$refpage),
		    					array("お届け先の入力","/order/register.php"),
		    					array("ご注文内容の確認","/order/confirm.php"),
		    					array("ご注文の申込","/order/finish.php")
		    					);
		    									
		    $order_navi .= '<div class="global_navi '.$gnavi.'"><ul class="crumbs">';
		    $navi_id = substr($gnavi, -1)-1;
		    if($navi_id==3){
		    // 申し込み完了
		    	for($i=0; $i<3; $i++){
			    	$order_navi .= '<li><p>'.$navi_info[$i][0].'</p></li>';
			    }
			    $order_navi .= '<li class="fin"><p>'.$navi_info[$i][0].'</p></li>';
		    }else{
		    	for($i=0; $i<4; $i++){
			    	if($i<$navi_id){
			    		$cls[$i] = "pass";
			    		$navi_page = '<a href="'.$navi_info[$i][1].'">'.$navi_info[$i][0].'</a>';
			    	}else if($i==$navi_id){
			    		$cls[$i] = "curr";
			    		$navi_page = '<p>'.$navi_info[$i][0].'</p>';
			    	}else{
			    		$cls[$i] = "none";
			    		$navi_page = '<p>'.$navi_info[$i][0].'</p>';
			    	}
			    	$order_navi .= '<li class="'.$cls[$i].'">'.$navi_page.'</li>';
			    }
			}
			$order_navi .= '</ul></div>';
			
	   // }
    }


	/*	footer
	*	2013-09-10	適用
	*	2013-10-29	アイテムにトレーナー、ジャケット、チャンピオンのカテゴリを追加
	*/
	$footer = '<div class="wrap">';
	$footer .= '<div class="clearfix">';
	$footer .= '<ul><li><p class="guidance">各種案内</p></li><li><a href="https://www.takahama428.com/guide/orderflow.php" rel=“nofollow">ご注文の流れ</a></li><li><a href="https://www.takahama428.com/price/estimate.php" rel=“nofollow">10秒見積もり</a></li><li><a href="https://www.takahama428.com/delivery/">お届け日計算</a></li><li><a href="/guide/print_guide1.php">プリント方法</a></li></ul>';
	$footer .= '<ul><li><p class="itemlist">アイテム一覧</p></li><li><a href="https://www.takahama428.com/items/category/sweat/" rel=“nofollow">パーカー</a></li><li><a href="https://www.takahama428.com/items/category/sweat/?cat=2&shilhouette%5B%5D=15" rel=“nofollow">トレーナー</a></li><li><a href="https://www.takahama428.com/items/category/sweat/?cat=2&shilhouette%5B%5D=16" rel=“nofollow">パンツ</a></li><li><a href="https://www.takahama428.com/items/category/t-shirts/" rel=“nofollow">Tシャツ</a></li><li><a href="https://www.takahama428.com/items/category/outer/" rel=“nofollow">ブルゾン</a></li></ul>';
	$footer .= '<ul><li><p class="design">デザイン</p></li><li><a href="/gallery/gallery_body1.php">制作実例</a></li><li><a href="/guide/ink_font.php">インクとフォント</a></li><li><a href="/design/index1.php">デザインテンプレート集</a></li><li><a href="/guide/sheet1.php">デザイン用紙</a></li></ul>';
	$footer .= '<ul><li><p class="price">申し込み</p></li><li><a href="https://www.takahama428.com/order/order_entrace.php" rel=“nofollow">申し込み</a></li><li><a href="/customer/contact1.php">お問い合わせ</a></li><li><a href="/guide/catalog1.php">資料請求</a></li><li><a href="/guide/discount1.php">割引プラン</a></li></ul>';
	$footer .= '<ul><li><p class="company">会社概要</p></li><li><a href="/company/company1.php">企業情報</a></li><li><a href="/law/law1.php">特定商取引法</a></li><li><a href="/policy/policy1.php">プライバシーポリシー</a></li><li><a href="https://www.takahama428.com/guide/faq.php" rel=“nofollow">Ｑ＆Ａ</a></li><li><a href="/sitemap/sitemap.php">サイトマップ</a></li></ul>';
	$footer .= '</div>';
	$footer .= '<div class="inner">';
	$footer .= '<div class="logo"><img alt="タカハマライフアート" src="/common/img/logo_footer.png" /></div>';
	$footer .= '<img alt="お問い合わせ　0120-130-428" src="/common/img/contact.png" class="contact" />';
/*	$footer .= '<a href="/customer/contact1.php" class="btn_contact"></a>';  */
	$footer .= '</div>';
	$footer .= '<p>Copyright &copy; '.date(Y).'  <a href="http://www.sweatjack.jp">オリジナルパーカー・スウェットのスウェットジャック</a> All rights reserved.</p>';
	$footer .= '</div>';
	
	
    /* footer 
    *	2012-11-16　変更
    *	2013-09-10	廃止
    *
    $footer = '<ul><li><a href="/">ホーム</a></li><li><a href="/guide/guide.php">ご注文の流れ</a></li><li><a href="/lineup/lineup_parker.php">アイテム一覧</a></li><li><a href="/gallery/gallery_body.php">デザイン例</a></li><li><a href="/estimate/estimate.php">料金について</a></li><li><a href="/guide/design_tech.php">デザインについて</a></li><li><a href="/guide/guide_3days.php">加工について</a></li></ul>';
    $footer .= '<ul><li><a href="/dance/">オリジナルダンススウェット</a></li><li><a href="/guide/guide.php">初めての方へ</a></li><li><a href="/faq/cost.php">よくある質問</a></li><li><a href="/customer/contact.php" >お客様窓口</a></li></ul>';
    $footer .= '<ul><li><a href="/company/company.php" >企業情報</a></li><li><a href="/policy/policy.php" >プライバシーポリシー</a></li><li><a href="/law/law.php" >特定商取引法</a></li><li><a href="/sitemap/sitemap.php" >サイトマップ</a></li></ul>';
    $footer .= '<p class="logo"><img alt="タカハマライフアート" src="/image/footer_logo.jpg" /></p>';
    $footer .= '<div class="contact_inner">';
	$footer .= '<img alt="お問い合わせ　0120-130-428" src="/image/contact.jpg" class="contact" />';
    $footer .= '<a href="/customer/contact.php" class="btn_contact"></a>';
    $footer .= '<p>東京都葛飾区西新小岩３-１４-２６</p>';
	$footer .= '</div>';
	$footer .= '<p>Copyright &copy; '.date(Y).'  <a href="/">オリジナルパーカー・スウェットのタカハマライフアート</a> All rights reserved.</p>';
	*/
	
    /*	footer
    *	2013-11-16	廃止
    $footer = '<div>';
    $footer .= '<ul><li><a href="/customer/contact.php" >お客様窓口</a></li><li><a href="/company/company.php" >企業情報</a></li><li><a href="/policy/policy.php" >プライバシーポリシー</a></li><li><a href="/law/law.php" >特定商取引法</a></li><li><a href="/sitemap/sitemap.php" >サイトマップ</a></li><li><a href="http://www.takahama428.com/" >オリジナルTシャツ作成</a></li></ul>';
    $footer .= '<p>Copyright &copy; '.date(Y).'  <a href="/">オリジナルスウェットのタカハマライフアート</a> All rights reserved.</p>';
    $footer .= '</div>';
    */
    


    /* インクのコードとインク名 */
    $inkcolors['c21'] = 'ホワイト';
    $inkcolors['c22'] = 'ブラック';
    $inkcolors['c23'] = 'ダークグレー';
    $inkcolors['c24'] = 'ライトグレー';
    $inkcolors['c25'] = 'ラディッシュ';
    $inkcolors['c26'] = 'レッド';
    $inkcolors['c27'] = 'ホットピンク';
    $inkcolors['c28'] = 'ライトピンク';
    $inkcolors['c29'] = 'オレンジ';
    $inkcolors['c30'] = 'サンフラワー';
    $inkcolors['c31'] = 'イエロー';
    $inkcolors['c32'] = 'ダークグリーン';
    $inkcolors['c33'] = 'グリーン';
    $inkcolors['c34'] = 'イエローグリーン';
    $inkcolors['c35'] = 'ネイビー';
    $inkcolors['c36'] = 'ブルー';
    $inkcolors['c37'] = 'サックス';
    $inkcolors['c38'] = 'パープル';
    $inkcolors['c39'] = 'ダークブラウン';
    $inkcolors['c40'] = 'ライトブラウン';
    $inkcolors['c41'] = 'シルバー';
    $inkcolors['c42'] = 'ゴールド';
    $inkcolors['c43'] = 'クリーム';
    $inkcolors['c44'] = 'リフレックスブルー';
    $inkcolors['c45'] = '蛍光イエロー';
    $inkcolors['c46'] = '蛍光オレンジ';
    $inkcolors['c47'] = '蛍光ピンク';
    $inkcolors['c48'] = '蛍光ブルー';
    $inkcolors['c49'] = '蛍光グリーン';
    $inkcolors['c50'] = 'ゴールドイエロー';
    $inkcolors['c51'] = 'ワインレッド';
    $inkcolors['c52'] = 'バイオレット';
    $inkcolors['c53'] = 'オーシャン';
    $inkcolors['c54'] = 'オリーブ';
    $inkcolors['c55'] = 'アプリコット';
    $inkcolors['c56'] = 'ラベンダー';
    $inkcolors['c57'] = 'エメラルドグリーン';
    $inkcolors['c58'] = 'グラスグリーン';
    $inkcolors['c59'] = 'ライム';
    $inkcolors['c60'] = 'パステルイエロー';
    $inkcolors['c61'] = 'フレッシュ';
    $inkcolors['c62'] = 'ライラック';
    $inkcolors['c63'] = 'ミントグリーン';
    $inkcolors['c64'] = 'ペールグリーン';
    $inkcolors['c65'] = 'ベージュ';
    $inkcolors['c66'] = 'ストロー';
    $inkcolors['c67'] = 'サーモンピンク';
    $inkcolors['c68'] = 'ピンク';
    $inkcolors['c69'] = 'ラベンダーグレイ';
    $inkcolors['c70'] = 'グリーンティ';
    $inkcolors['c71'] = 'ショッキングピンク';


    /* フォント */
    $font_lang = array( "ja"=>"和文", "en"=>"英文");
    $font_type = array( 'basic'=>'基本',
						'brush'=>'純和風',
						'pop'=>'ポップ',
						'retro'=>'レトロ',
						'others'=>'その他',
						'impact'=>'インパクト',
						'sports'=>'スポーツ',
						'art'=>'アート'
    );
    $font_name = array(	 'AMOSN___'=>'アモス',
						 'C018016D'=>'クーパー',
						 'CAVEMAN_'=>'ケイヴマン',
						 'DEFECAFO'=>'ディフェカ',
						 'FATASSFI'=>'ファット',
						 'GRAFFITI'=>'グラフィティー',
						 'jaggyfries'=>'ジャギー',
						 'american-bold'=>'アメリカン',
						 'american-med'=>'ミディアム',
    					 'HORSERADISH'=>'ホースラディッシュ',
						 'Plain Germanica'=>'ジャーマニカ',
						 'amsterdam'=>'アムステルダム',
						 'Daft Font'=>'ダフト',
						 'Megadeth'=>'メガデス',
						 'MISFITS_'=>'ミスフィッツ',
						 'NITEMARE'=>'ナイトメアー',
						 'RUFA'=>'ルーファ',
						 'renaissance'=>'ルネッサンス',
						 'WREXHAM_'=>'レクハム',
						 'AMAZR___'=>'アメイズ',
						 'AppleGaramond'=>'アップル',
						 'MarketingScript'=>'マーケティング',
						 'Anderson'=>'アンダーソン',
						 'CloisterBlack'=>'クリスター',
						 'Army'=>'アーミー',
						 'ENGLN___'=>'イングランド',
						 'judasc__'=>'アイロン',
						 'allstar'=>'オールスター',
						 'COLLEGEB'=>'カレッジ',
						 'DEFTONE'=>'デフトーン',
						 'varsity_regular'=>'バーシティ',
						 'ARCADEPI'=>'アーケデピックス',
						 'NIRVANA'=>'ニルバーナ',
						 'vintage'=>'ヴィンテージ',
						 'Yahoo'=>'ヤフー',
						 'GREMSN__'=>'グレムリン',
						 'LCD2N___'=>'LCD',
						 'DFGOTC'=>'極太ゴシック',
						 'DFKAI9'=>'極太楷書',
						 'DFMINC'=>'極太明朝',
						 'CRBajoka-R'=>'バジョカ',
						 'DCKGMC'=>'籠',
						 'DCYSM7'=>'寄席',
						 'DFSGYO5'=>'祥南行書',
						 'KswGoryuNew'=>'豪龍',
						 'samurai'=>'さむらい',
						 'SMODERN'=>'昭和モダン',
						 'DFCRS9'=>'クラフト墨',
						 'DFMRGC'=>'極太丸ゴシック',
						 'DFMRM9'=>'まるもじ',
						 'nipple'=>'ニップル',
						 'DFRULE7'=>'流麗',
						 'DFSHT7'=>'しんてん',
						 'DFSOGE7'=>'そうげい'
    );

	$hashFontInfo = array('lang'=>$font_lang, 'type'=>$font_type, 'name'=>$font_name);

    /* アップローダー */
    require dirname(__FILE__)."/upload.php";
?>