<?php
// タカハマラフアート
// Sweatjack 商品カタログ　クラス
// charset euc-jp

	require_once $_SERVER['DOCUMENT_ROOT'].'/../cgi-bin/conndb.php';

	/**
	*	getTableList		テーブルリストを返す
	*	getItemPrice		商品の単価を返す
	*/
	class Catalog extends Conndb{

		public function __construct(){
		}
		
		
		/**
		*	データベースのテーブルリストを返す
		*	@mode			データベースのテーブル名
		*	@item_id		アイテムID
		*	@itemcolor_code	アイテムのカラーコード
		*	@part			1:パーカー  2:パンツ  null(default):全て
		*
		*	@return			テーブルのレコード
		*/
		public function getTablelist($mode, $item_id=NULL, $itemcolor_code=NULL, $part=NULL){
			$rs = parent::sjTablelist($mode, $item_id, $itemcolor_code, $part);
			return $rs;
		}


		/**
		*		当該商品の単価を返す（サイズIDが0の時は最低価格を返す）
		*		@item_id		アイテムのID
		*		@size_id		サイズのID
		*		@points			プリントの有無（1..あり or 0..なし）
		*		@isWhite		白Ｔ..1 or それ以外..0(default)
		*		@mode			タカハマ価格のみ..0(default) or メーカー価格も返す..1
		*/
		public function getItemPrice($item_id, $size_id, $points, $isWhite=0, $mode=0){
			$rs = parent::sjItemPrice($item_id, $size_id, $points, $isWhite, $mode);
			return $rs;
		}


		/**
		*		当該商品の情報を返す（価格は最低価格帯のみ）
		*		価格は販売価格に計算済み
		*		@part			1:パーカー  2:パンツ  null(default):全て
		*		@keyname		返り値の配列のキーを指定、default ['item_id']
		*/
		public function getItemInfo($part=null, $keyname="item_id"){
			$rs = parent::sjItemInfo($part, $keyname);
			return $rs;
		}

	}
