<?php
// タカハマラフアート
// Sweatjack 商品データベース処理
// charset utf-8

	require_once $_SERVER['DOCUMENT_ROOT'].'/../cgi-bin/conndb.php';
	require_once dirname(__FILE__).'/iteminfo.php';
	
	$conn = new Conndb();
	
	if(isset($_POST['act'])){
		switch($_POST['act']){
			case 'item':
				$rs = $conn->sjTablelist($_POST['act'], $_POST['item_id']);
				if(count($rs)==1){
					$data = $rs[0];
					$filename = _IMG_PSS.'items/list/sweat/'.$data['item_code'].'.jpg';
					$color_name = $data['color_name'];
				}else{
					$ind = floor(count($rs)/2);
					$data = $rs[$ind];
					$filename = _IMG_PSS.'items/list/sweat/'.$data['item_code'].'/'.$data['item_code'].'_'.$data['color_code'].'.jpg';
					$color_name = $data['color_name'];
					$color_code = $data['color_code'];
				}
				$res = $filename.'|'.$color_name.'|'.$color_code.'|'.$data['printposition_id'];
				break;

			case 'itemsize':
				$size = $conn->sjTablelist($_POST['act'], $_POST['item_id'], $_POST['itemcolor_code']);
				$count = count($size);
				if(isset($_POST['selector'])){
					$res = '<option value="" selected="selected">サイズ</option>';
					for($t=0; $t<$count; $t++){
						if($_POST['item_id']=='115'){
							if(empty($_POST["gl"])){
								if( ($size[$t]['id']>=14 && $size[$t]['id']<=16) || ($size[$t]['id']>=29 && $size[$t]['id']<=31) ) continue;
							}else{
								if( !($size[$t]['id']>=14 && $size[$t]['id']<=16) || ($size[$t]['id']>=29 && $size[$t]['id']<=31) ) continue;
							}
						}
						$res .= '<option value="'.$size[$t]['id'].'">'.$size[$t]['size_name'].'</option>';
					}
				}else if(isset($_POST['selector2'])){
				// 無料サンプルページ
				// value=サイズ名
					for($t=0; $t<$count; $t++){
						if($_POST['item_id']=='115'){
							if(empty($_POST["gl"])){
								if( ($size[$t]['id']>=14 && $size[$t]['id']<=16) || ($size[$t]['id']>=29 && $size[$t]['id']<=31) ) continue;
							}else{
								if( !($size[$t]['id']>=14 && $size[$t]['id']<=16) || ($size[$t]['id']>=29 && $size[$t]['id']<=31) ) continue;
							}
						}
						$res .= '<option value="'.$size[$t]['size_name'].'"';
						if($t==0) $res .= ' selected="selected"';
						$res .= '>'.$size[$t]['size_name'].'</option>';
					}
				}else{
					for($t=0; $t<$count; $t++){
						$ex=$t;
						$res .= '<table class="itemsize_table"><thead><tr>';
						for($i=$t; $i<$count; $i++){
							if($i%4==0 && $i!=$ex) break;
							if($_POST['item_id']=='115'){
								if(empty($_POST["gl"])){
									if( ($size[$i]['id']>=14 && $size[$i]['id']<=16) || ($size[$i]['id']>=29 && $size[$i]['id']<=31) ) continue;
								}else{
									if( !($size[$i]['id']>=14 && $size[$i]['id']<=16) || ($size[$i]['id']>=29 && $size[$i]['id']<=31) ) continue;
								}
							}
							$res .= '<th>'.$size[$i]['size_name'].'</th>';
						}
						$res .= '</tr></thead>';
						$res .= '<tbody><tr>';
						for($i=$t; $i<$count; $i++){
							if($i%4==0 && $i!=$ex) break;
							if($_POST['item_id']=='115'){
								if(empty($_POST["gl"])){
									if( ($size[$i]['id']>=14 && $size[$i]['id']<=16) || ($size[$i]['id']>=29 && $size[$i]['id']<=31) ) continue;
								}else{
									if( !($size[$i]['id']>=14 && $size[$i]['id']<=16) || ($size[$i]['id']>=29 && $size[$i]['id']<=31) ) continue;
								}
							}
							$res .= '<td><input type="text" value="0" class="itemsize size_'.$size[$i]['id'].'" name="'.$size[$i]['size_name'].'" /></td>';
						}
						$res .= '</tr></tbody></table>';
						$i--;
						$t = $i;
					}
				}

				break;

			case 'itemcolorlist':
				$item_id = $_POST['item_id'];
				$rs = $conn->sjTablelist('item', $item_id);
				$selector = '<option value="" selected="selected">カラー</option>';
				for($i=0; $i<count($rs); $i++){
					$res .= '<li class="c'.$rs[$i]['color_code'].'"><div class="wrapper">';
					$res .= '<div class="color_'.$rs[$i]['color_id'].'"></div><div class="checkcolor_wrapper"><img alt="'.$rs[$i]['color_name'].'" src="../img/slideviewer/check-multi.gif" class="check';
					if($rs[$i]['color_code']==$_POST['itemcolor_code']){
						$res .= ' current " style="top:-65px;';
					}
					$res .= '" /></div></div></li>';

					$selector .= '<option value="'.$rs[$i]['color_code'].'">'.$rs[$i]['color_name'].'</option>';
				}
				$res .= '|'.$selector;
				break;

			case 'cost':
				$res = $conn->sjItemPrice($_POST['item_id'], $_POST['size_id'], $_POST['points'], $_POST['iswhite'], $_POST['maker']);
				if(isset($_POST['maker'])){
					$res = implode('|', $res);
				}
				break;

			case 'font':
				if(!isset($_POST['font_lang'], $_POST['font_type'])) break;
				if($_POST['font_lang']=='cutting'){
					$hash['ja'] = array('basic','brush','pop','retro','others');
					$hash['en'] = array('basic','art','pop','impact','sports','others');
					foreach($hash as $key=>$val){
						for($i=0; $i<count($val); $i++){
							$web_path = '/img/guide/font/'.$key.DIRECTORY_SEPARATOR.$val[$i].DIRECTORY_SEPARATOR;
							$tempfile_path = _DOC_ROOT.$web_path.'*.png';
							foreach (glob("$tempfile_path") as $tempfile) {
								$tmp[] = _DOMAIN.$web_path.basename($tempfile).'+++'.$key.'+++'.$val[$i];
							}
						}
					}
					$res = implode('|', $tmp);
				}else{
					$web_path = '/img/guide/font/'.$_POST['font_lang'].DIRECTORY_SEPARATOR.$_POST['font_type'].DIRECTORY_SEPARATOR;
					$tempfile_path = _DOC_ROOT.$web_path.'*.png';
					foreach (glob("$tempfile_path") as $tempfile) {
						$tmp[] = _DOMAIN.$web_path.basename($tempfile);
					}
					$res = implode('|', $tmp);
				}
				break;

			case 'printposition':
				$ppId = $_POST['ppId'];
				if( $ppId==8 || $ppId==9 || $ppId==58 || $ppId==59 ){
					// pants
					if($ppId==9 || $ppId==59){		// shorts
						$suffix = "_shorts";
						$area_front = array(
							'pants_front_1'=>array("h"=>"18","w"=>"20","pos"=>"右足前"),
							'pants_front_2'=>array("h"=>"18","w"=>"20","pos"=>"左足前")
						);
						$area_side = array(
							'pants_side_1'=>array("h"=>"18","w"=>"20","pos"=>"右足横"),
							'pants_side_2'=>array("h"=>"18","w"=>"20","pos"=>"左足横")
						);
						$area_back = array(
							'pants_back_1'=>array("h"=>"18","w"=>"20","pos"=>"左足後"),
							'pants_back_2'=>array("h"=>"18","w"=>"20","pos"=>"右足後")
						);
						if($item_id==9){	// pocket なし
							//$area_back['pants_back_3'] = array("h"=>"20","w"=>"30","pos"=>"お尻");
						}
						$area = array($area_front,$area_side,$area_back);

					}else{									// pants
						$area_front = array(
							'pants_front_1'=>array("h"=>"35","w"=>"15","pos"=>"右足前"),
							'pants_front_2'=>array("h"=>"43","w"=>"15","pos"=>"右足前ジャンボ"),
							'pants_front_3'=>array("h"=>"35","w"=>"15","pos"=>"左足前"),
							'pants_front_4'=>array("h"=>"43","w"=>"15","pos"=>"左足前ジャンボ"),
							'pants_front_5'=>array("h"=>"20","w"=>"30","pos"=>"パンツ前")
						);
						$area_side = array(
							'pants_side_1'=>array("h"=>"35","w"=>"15","pos"=>"右足横"),
							'pants_side_2'=>array("h"=>"43","w"=>"15","pos"=>"右足横ジャンボ"),
							'pants_side_3'=>array("h"=>"35","w"=>"15","pos"=>"左足横"),
							'pants_side_4'=>array("h"=>"43","w"=>"15","pos"=>"左足横ジャンボ")
						);
						$area_back = array(
							'pants_back_1'=>array("h"=>"35","w"=>"15","pos"=>"左足後"),
							'pants_back_2'=>array("h"=>"43","w"=>"15","pos"=>"左足後ジャンボ"),
							'pants_back_3'=>array("h"=>"35","w"=>"15","pos"=>"右足後"),
							'pants_back_4'=>array("h"=>"43","w"=>"15","pos"=>"右足後ジャンボ")
						);
						if($item_id!=8){	// pocket なし
							//$area_back['pants_back_5'] = array("h"=>"20","w"=>"30","pos"=>"お尻");
						}
						$area = array($area_front,$area_side,$area_back);
					}

					for($i=0; $i<3; $i++){
						$col = 0;
						foreach($area[$i] as $key=>$val){
							$printposition[$i] .= '<div class="place_cell';
							if($col==1){
								$printposition[$i] .= " rboder_none";
								$col=0;
							}else{
								$col=1;
							}
							if(!empty($data[$key][0])) $printposition[$i] .= ' place_selected">';
							else $printposition[$i] .= '">';

							// print position image
							if($i==2 && ($ppId==8 || $ppId==9)){
								$printposition[$i] .= '<img alt="'.$val['pos'].'" src="/img/order/printposition/pants/'.$key.$suffix.'_pocket.png" class="pos" />';
							}else{
								$printposition[$i] .= '<img alt="'.$val['pos'].'" src="/img/order/printposition/pants/'.$key.$suffix.'.png" class="pos" />';
							}

							// print size
							$printposition[$i] .= '<p class="size"><span>MAX</span>　H'.$val['h'].'cm × W'.$val['w'].'cm</p>';

							$printposition[$i] .= '<p><input type="button" value="インクの選択と解除" class="show_ink" /></p>';
							$printposition[$i] .= '<p class="txt"><span class="fontred">※</span> インクの取消は<img alt="" src="../img/icon_pointer.png" />ボタンからチェックを外してください</p>';

							// ink
							$opt = "";
							if(empty($data[$key][0])){
								$opt = '<option value="" selected="selected">未指定</option>';
							}else{
								for($t=0; $t<count($data[$key]); $t++){
									$opt .= '<option value="'.$data[$key][$t].'">'.$inkcolors[$data[$key][$t]].'</option>';
								}
							}
							$printposition[$i] .= '<select size="3" name="'.$key.'"';
							if($val['h']==43){	// ジャンボ版
								$printposition[$i] .= ' class="jumbo"';
							}
							$printposition[$i] .= '>'.$opt.'</select></div>';
						}
					}

				}else{
					if($ppId==6 || $ppId==55){
						// トレーナー
						$area_front = array(
							'trainer_front_1'=>array("h"=>"35","w"=>"27","pos"=>"正面"),
							'trainer_front_2'=>array("h"=>"43","w"=>"32","pos"=>"正面ジャンボ"),
						);
						$area_side = array(
							'trainer_sleeve_1'=>array("h"=>"35","w"=>"10","pos"=>"左袖"),
							'trainer_sleeve_2'=>array("h"=>"43","w"=>"10","pos"=>"左袖ジャンボ"),
							'trainer_sleeve_3'=>array("h"=>"35","w"=>"10","pos"=>"右袖"),
							'trainer_sleeve_4'=>array("h"=>"43","w"=>"10","pos"=>"右袖ジャンボ")
						);
						$area_back = array(
							'trainer_back_1'=>array("h"=>"35","w"=>"27","pos"=>"背中"),
							'trainer_back_2'=>array("h"=>"43","w"=>"32","pos"=>"背中ジャンボ"),
						);
					}else{
						// parker
						if($ppId==7 || $ppId==47){
							// プルオーバー
							$area_front = array(
								'parker_front_1'=>array("h"=>"15","w"=>"30","pos"=>"正面"),
								'parker_front_2'=>array("h"=>"7","w"=>"19","pos"=>"フード前"),
								'parker_front_3'=>array("h"=>"15","w"=>"15","pos"=>"ポケット"),
							);
						}else{
							// ジップあり
							$area_front = array(
								'parker_front_2'=>array("h"=>"7","w"=>"19","pos"=>"フード前"),
								'parker_front_4'=>array("h"=>"15","w"=>"10","pos"=>"左胸"),
								'parker_front_5'=>array("h"=>"15","w"=>"10","pos"=>"右胸")
							);
						}
						
						$area_side = array(
							'parker_side_1'=>array("h"=>"20","w"=>"14","pos"=>"左脇"),
							'parker_side_2'=>array("h"=>"20","w"=>"14","pos"=>"右脇"),
							'parker_side_3'=>array("h"=>"22","w"=>"14","pos"=>"フード左"),
							'parker_side_4'=>array("h"=>"22","w"=>"14","pos"=>"フード右"),
							'parker_sleeve_1'=>array("h"=>"35","w"=>"10","pos"=>"左袖"),
							'parker_sleeve_2'=>array("h"=>"43","w"=>"10","pos"=>"左袖ジャンボ"),
							'parker_sleeve_3'=>array("h"=>"35","w"=>"10","pos"=>"右袖"),
							'parker_sleeve_4'=>array("h"=>"43","w"=>"10","pos"=>"右袖ジャンボ")
						);
						$area_back = array(
							'parker_back_1'=>array("h"=>"35","w"=>"27","pos"=>"背中縦"),
							'parker_back_2'=>array("h"=>"43","w"=>"32","pos"=>"背中ジャンボ"),
							'parker_back_3'=>array("h"=>"27","w"=>"35","pos"=>"背中横")
						);
					}
					$area = array($area_front, $area_side, $area_back);

					for($i=0; $i<3; $i++){
						$col = 0;
						foreach($area[$i] as $key=>$val){
							$printposition[$i] .= '<div class="place_cell';
							if($col==1){
								$printposition[$i] .= " rboder_none";
								$col=0;
							}else{
								$col=1;
							}
							if(!empty($data[$key][0])) $printposition[$i] .= ' place_selected">';
							else $printposition[$i] .= '">';

							// print position image
							if($ppId==6 || $ppId==55){
								$printposition[$i] .= '<img alt="'.$val['pos'].'" src="/img/order/printposition/trainer/'.$key.'.png" class="pos" />';
							}else if($i==0 && ($ppId==7 || $ppId==47)){
								$printposition[$i] .= '<img alt="'.$val['pos'].'" src="/img/order/printposition/parker/'.$key.'_pull.png" class="pos" />';
							}else{
								$printposition[$i] .= '<img alt="'.$val['pos'].'" src="/img/order/printposition/parker/'.$key.'.png" class="pos" />';
							}

							// print size
							$printposition[$i] .= '<p class="size"><span>MAX</span>　H'.$val['h'].'cm × W'.$val['w'].'cm</p>';

							$printposition[$i] .= '<p><input type="button" value="インクの選択と解除" class="show_ink" /></p>';
							$printposition[$i] .= '<p class="txt"><span class="fontred">※</span> インクの取消は<img alt="" src="../img/icon_pointer.png" />ボタンからチェックを外してください</p>';

							// ink
							$opt = "";
							if(empty($data[$key][0])){
								$opt = '<option value="" selected="selected">未指定</option>';
							}else{
								for($t=0; $t<count($data[$key]); $t++){
									$opt .= '<option value="'.$data[$key][$t].'">'.$inkcolors[$data[$key][$t]].'</option>';
								}
							}
							
							$printposition[$i] .= '<select size="3" name="'.$key.'"';
							if($val['h']==43){	// ジャンボ版
								$printposition[$i] .= ' class="jumbo"';
							}
							$printposition[$i] .= '>'.$opt.'</select></div>';
						}
					}

				}

				$res = implode("|",$printposition);

				break;
		}

	}

	echo $res;
?>