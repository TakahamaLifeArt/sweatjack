<?php
/*
*	Database connection
*	charset utf-8
*
*/
require_once $_SERVER['DOCUMENT_ROOT'].'/../cgi-bin/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/../cgi-bin/JSON.php';
require_once dirname(__FILE__).'/http.php';

class Conndb extends HTTP {
	
	public function __construct($args=_API){
		parent::__construct($args);
	}
	
	
	/*
	*	消費税率を取得
	*	@curdate		検索する日付（default:今日）
	*	@mode			general(default):2014-05-26より前は内税のため0を返す、industry:消費税率
	*
	*	@return			消費税率
	*/
	public function getSalesTax($curdate='', $mode='general'){
		if(empty($curdate)){
			$curdate = date('Y-m-d');
		}
		$res = parent::request('POST', array('act'=>'salestax', 'curdate'=>$curdate, 'ordertype'=>$mode));
		$data = unserialize($res);
		
		return $data;
	}
	
	
	/*
	*	商品カテゴリー一覧
	*
	*	@return		[id:category_id, code:category_key, name:category_name][...]
	*/
	public function categoryList(){
		$res = parent::request('POST', array('act'=>'category'));
		$data = unserialize($res);
		
		return $data;
	}


	/*
	*	商品一覧
	*	@categoryid		カテゴリーID　default: 1
	*	@mode			NULL:default,　'item':第一引数でアイテムIDを渡す場合
	*
	*	@return			[id:item_id, code:item_code, name:item_name, posid:printposition_id][...]
	*/
	public function itemList($categoryid=1, $mode=NULL){
		$res = parent::request('POST', array('act'=>'item', 'categoryid'=>$categoryid, 'mode'=>$mode ,'show_site'=>_SITE));
		$data = unserialize($res);

		return $data;
	}
	
	
	/*
	*	サイズ一覧
	*	@id				アイテムID
	*	@colorcode		カラーコード
	*	@mode			id:アイテムID(default),  code:アイテムコード
	*
	*	@return			[id:size_from, name:size_name][...]
	*/
	public function itemSize($id, $colorcode=NULL, $mode='id'){
		$res = parent::request('POST', array('act'=>'size', 'itemid'=>$id, 'colorcode'=>$colorcode, 'mode'=>$mode));
		$data = unserialize($res);

		return $data;
	}
	
	
	/*
	*	商品価格
	*	@id				アイテムID
	*	@mode			id:アイテムID(default), code:アイテムコード
	*
	*	@return			[sizeid:size_from, price_color:price_0, price_white:price_1, maker_color:price_0, maker_white:price_1]
	*/
	public function itemPrice($id, $mode='id'){
		$res = parent::request('POST', array('act'=>'price', 'itemid'=>$id, 'mode'=>$mode));
		$data = unserialize($res);

		return $data;
	}
	
	
	/*
	*	アイテムコードからIDを返す
	*	@itemcode		アイテムコード
	*
	*	@return			item_id
	*/
	public function itemID($itemcode){
		$res = parent::request('POST', array('act'=>'itemid', 'itemcode'=>$itemcode));
		$data = unserialize($res);

		return $data;
	}
	
	
	/*
	*	アイテムごとに、シルクとデジタル転写で最安のプリント代を計算（プリント位置は1ヵ所）して最安の商品単価から見積り
	*	（商品詳細とシーン別ページ用）
	*	@itemid		アイテムコードの配列
	*	@amount		枚数の配列
	*	@ink		インク数の配列
	*	@pos		プリント位置の配列
	*	@sheetsize	転写のデザインサイズ　default:1
	*
	*	@return		{item_code:['price':見積金額, 'perone':1枚あたり],[...]}　引数に配列以外を設定した時はNULL
	*/
	public function estimateEach($itemcode, $amount, $ink, $pos, $sheetsize='1'){
		$res = parent::request('POST', array('act'=>'estimateeach', 'sheetsize'=>$sheetsize, 'itemcode'=>$itemcode, 'amount'=>$amount, 'ink'=>$ink, 'pos'=>$pos));
		$data = unserialize($res);
		
		return $data;
	}
		
	
	/*
	*	プリント位置（絵型）の画像情報を返す
	*	@curitemid		アイテムID
	*	@mode			id:アイテムID(default), code:アイテムコード
	*
	*	@return			[プリント位置の絵型を配置するタグのテキストファイルへのパス, 位置名, position_id][...]
	*/
	public function positionFor($curitemid, $mode='id'){
		$res = parent::request('POST', array('act'=>'position', 'itemid'=>$curitemid, 'mode'=>$mode));
		$data = unserialize($res);
		
		/*---------------------------------------------------
		*	2013-10-24 
		*	下記2点のパーカーの絵型（フード前なし）の暫定的対応
		*	ID:348	241-cfh 裏起毛プルパーカー
		*	ID:349	242-cfz 裏起毛ジップパーカー
		*/
		
		if($curitemid=='348'){
			$data[0]['item']='parker-non-hood';
		}else if($curitemid=='349'){
			$data[0]['item']='zip-parker-non-hood';
		}
		
		//---------------------------------------------------
		$path = dirname(__FILE__).'/../common/txt/'.$data[0]['category'].'/'.$data[0]['item'].'/*.txt';
		$posid = $data[0]['id'];
		foreach (glob($path) as $filename) {
			$base = basename($filename, '.txt');
			if(strpos($base, 'front')!==false){
				$base_name = '前';
				$tmp[0] = array('filename'=>$filename, 'base_name'=>$base_name, 'posid'=>$posid, 'ppdata'=>$data[0]);
			}elseif(strpos($base, 'back')!==false){
				$base_name = '後';
				$tmp[1] = array('filename'=>$filename, 'base_name'=>$base_name, 'posid'=>$posid, 'ppdata'=>$data[0]);
			}elseif(strpos($base, 'side')!==false){
				$base_name = '横';
				$tmp[2] = array('filename'=>$filename, 'base_name'=>$base_name, 'posid'=>$posid, 'ppdata'=>$data[0]);
			}elseif(strpos($base, 'noprint')!==false){
				$base_name = 'プリントなし';
				$tmp[0] = array('filename'=>$filename, 'base_name'=>$base_name, 'posid'=>$posid, 'ppdata'=>$data[0]);
			}
		}
		
		// 添え字indexの付替え
		ksort($tmp, SORT_NUMERIC);
		foreach($tmp as $index=>$dat){
			$files[] = $dat;
		}
		
		return $files;
	}


	/*
	*	見積ページ
	************************************************/
	
	/*
	*	価格ごとのサイズ構成を取得してテーブルデータタグを生成
	*	@curitemid		アイテムID
	*	@colormode		白色が白色以外かの指定　white(default), color
	*	@mode			id:アイテムID(default), code:アイテムコード
	*
	*	@return			[[サイズ - サイズ　0,000円～, ...],白色が安い商品はture,[size_id:price,...]]
	*/
	public function priceFor($curitemid, $colormode='white', $mode='id'){
		$res = parent::request('POST', array('act'=>'price', 'itemid'=>$curitemid, 'mode'=>$mode));
		$data = unserialize($res);
		$isSwitch = false;
		if(empty($colormode)) $colormode = 'white';
		foreach($data as $key=>$val){
			$price[$val['sizeid']] = $val['price_'.$colormode];
			if($val['price_white']<$val['price_color']){
				$isSwitch = true;
			}
		}
		
		// 価格ごとにサイズ展開を設定して配列に代入
		$res = parent::request('POST', array('act'=>'size', 'itemid'=>$curitemid, 'mode'=>$mode));
		$size = unserialize($res);
		$rows = array();
		foreach($size as $key=>$val){
			if(empty($size_from)){
				$size_from = $val['name'];
				$size_to = '';
				$minprice = $price[$val['id']];
				$size_id = $val['id'];
			}else if($minprice==$price[$val['id']]){
				$size_to = $val['name'];
			}else{
				if($size_to==''){
					$rows[] = '<th class="sizefrom_'.$size_id.'">'.$size_from.'</th><td>'.number_format($minprice).'円&#65374;'.'</td>';
				}else{
					$rows[] = '<th class="sizefrom_'.$size_id.'">'.$size_from.' &minus; '.$size_to.'</th><td>'.number_format($minprice).'円&#65374;'.'</td>';
				}
				$size_from = $val['name'];
				$size_to = '';
				$minprice = $price[$val['id']];
				$size_id = $val['id'];
			}
		}
		if($size_to==''){
			$rows[] = '<th class="sizefrom_'.$size_id.'">'.$size_from.'</th><td>'.number_format($minprice).'円&#65374;'.'</td>';
		}else{
			$rows[] = '<th class="sizefrom_'.$size_id.'">'.$size_from.' &minus; '.$size_to.'</th><td>'.number_format($minprice).'円&#65374;'.'</td>';
		}
		
		$line ='';
		for($i=0; $i<count($rows); $i++){
			$line .= '<tr>'.$rows[$i].'<td><input type="number" value="0" min="0" class="forNum" /> '.'枚'.'</td></tr>';
		}
		
		return array($line, $isSwitch, $price);
	}

	
	/*
	*	注文フォーム、商品ページ
	************************************************/
	
	/*
	*	商品名とカラーごとのコード一覧データ
	*	@itemid			アイテムID　default: 1
	*
	*	@return			['name':[アイテムコード:アイテム名], 'category':[カテゴリーキー:カテゴリー名], code:[code:カラー名, ...], size[...], ppid:プリントポジションID]
	*					codeのフォーマットは、「アイテムコード＿カラーコード」　ex) 085-cvt_001
	*/
	public function itemAttr($itemid=1){
		$res = parent::request('POST', array('act'=>'itemattr', 'itemid'=>$itemid));
		$data = unserialize($res);
		
		return $data;
	}
	
	/*
	*	カテゴリーの商品情報
	*	@categoryid		カテゴリーID
	*	@mode			id:カテゴリーID、code:カテゴリーキー、list:カテゴリーIDで全サイズのリスト
	*
	*	@return			[category_key,item_id,item_name,item_code,size_id,size_from,size_to,colors,cost,pos_id][...]
	*/
	public function categories($categoryid, $mode='id'){
		$res = parent::request('POST', array('act'=>'categories', 'id'=>$categoryid, 'mode'=>$mode, 'show_site'=>_SITE));
		$data = unserialize($res);
		
		return $data;
	}
	
	
	/*
	*	商品ページの基本情報（サイズ数、カラー数、最安価格）
	*	@id				アイテムID
	*	@mode			id:アイテムID、code:アイテムコード
	*
	*	@return			{'item_name':item_name, 'sizes':size_count, 'colors':color_count, 'mincost':mincost}
	*/
	public function itemPageInfo($id, $mode='id'){
		$res = parent::request('POST', array('act'=>'itempageinfo', 'id'=>$id, 'mode'=>$mode));
		$data = unserialize($res);
		
		return $data;
	}
	
	
	/*
	*	注文フォーム
	************************************************/
	
	/*
	*	サイズと価格のデータ
	*	@curitemid		アイテムID　default: 1
	*	@colorcode		アイテムカラーコード　default: ''
	*
	*	@return			['id':サイズID, 'name':サイズ名, 'cost':販売価格, 'series':サイズシリーズID][...]
	*/
	public function sizePrice($itemid=1, $colorcode=''){
		$res = parent::request('POST', array('act'=>'sizeprice', 'itemid'=>$itemid, 'colorcode'=>$colorcode));
		$data = unserialize($res);
		
		return $data;
	}
	
	
	/*
	*	シルクとデジタル転写で最安のプリント代合計を返す
	*	@args		['itemid'=>itemid, 'amount'=>amount, 'ink'=>inkcount, 'pos'=>posname][][]
	*	@sheetsize	転写のデザインサイズ　default:1
	*
	*	@return		['printfee':プリント代, 'volume':枚数, 'tax':消費税率]　引数に配列以外を設定した時はNULL
	*/
	public function printfee($args, $sheetsize='1'){
		$res = parent::request('POST', array('act'=>'printfee', 'sheetsize'=>$sheetsize, 'args'=>$args, 'show_site'=>_SITE));
		$data = unserialize($res);
		
		return $data;
	}
	
	
	
	/*
	*	資料請求ページ
	*	フォームの内容をデータベースに登録
	*	
	*	@args			["requester", "subject", "message", "reqmail", "site_id"]
	*
	*	@return			成功：ID　失敗：null
	************************************************/
	public function requestmail($args){
		$res = parent::request('POST', array('act'=>'requestmail', 'args'=>$args));
		$data = unserialize($res);
		
		return $data;
	}
	
	
	
	/*
	*	商品到着確認後のアンケート結果を
	*	データベースに登録
	*	
	*	@args			["requester", "subject", "message", "reqmail", "site_id"]
	*
	*	@return			成功：ID　失敗：null
	************************************************/
	public function setEnquete($args){
		$res = parent::request('POST', array('act'=>'enquete', 'args'=>$args));
		$data = unserialize($res);
		
		return $data;
	}
	
	
	
	
	/*
	*	カスタマーセンター
	************************************************/
	
	/*
	*	ユーザー情報の取得
	*	
	*	@args			[customer.id(default: null)]
	*
	*	@return			[顧客情報]
	************************************************/
	public function getUserList($args=null) {
		$res = parent::request('POST', array('act'=>'getuserlist', 'args'=>$args));
		$data = unserialize($res);
		
		return $data;
	}
	
	
	
	/*
	*	メールアドレスの存在確認
	*	
	*	@args			[e-mail,]
	*
	*	@return			[顧客情報]
	************************************************/
	public function checkExistEmail($args){
		$res = parent::request('POST', array('act'=>'checkexistemail', 'args'=>$args));
		$data = unserialize($res);
		
		return $data;
	}	

	
	/*
	*	お知らせメールの配信停止処理
	*	
	*	@args			{'customer_id', 'cancel'(停止:1)'
	*
	*	@return			成功:true  失敗:false
	************************************************/
	public function unsubscribe($args){
		$res = parent::request('POST', array('act'=>'unsubscribe', 'args'=>$args));
		$data = unserialize($res);
		
		return $data;
	}
}
?>
