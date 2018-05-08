<?php
/*
	send order mail module
	charset euc-jp
*/
	$mail_title = "ご注文のお申し込み";
	if( isset($_POST['order_send'], $_POST['ticket'], $_SESSION['ticket']) && $_POST['ticket']==$_SESSION['ticket'] ) {
		unset($_SESSION['ticket']);
		try{
			$name = $info['ocustomername'];
			$email = $info['email'];
			$order_info = "☆━━━━━━━━【　".$mail_title."　】━━━━━━━━☆\n\n";
			$order_info .= "┏━━━━━━━━┓\n";
			$order_info .= "◆　　ご注文内容\n";
			$order_info .= "┗━━━━━━━━┛\n";
			foreach($order_items as $key=>$val){
				foreach($val['size'] as $sizename=>$v){
					$item_subtotal += $v['price']*$v['volume'];
					$order_info .= "◇アイテム：　".$val['item_name']."\n";
					$order_info .= "◇カラー：　".$val['color_code']." ".$val['color_name']."\n";
					$order_info .= "◇サイズ：　".$sizename."\n";
					$order_info .= "◇単価：　".number_format($v['price'])." 円\n";
					$order_info .= "◇枚数：　".$v['volume']." 枚\n";
					$order_info .= "◇小計：　".number_format($v['price']*$v['volume'])." 円\n";
					$order_info .= "------------------------------------------\n\n";
				}
			}
			$order_info .= "◇商品代：　".number_format($item_subtotal)." 円\n";
			$order_info .= "◇プリント代：　".number_format($info['print_fee'])." 円\n";
			$order_info .= "◇割引：　（".$info['discount_text']."）▲".number_format($info['discount_fee'])." 円\n";
			$order_info .= "◇袋詰め代：　".number_format($pack_fee)." 円\n";
			$order_info .= "◇送料：　".number_format($info['carriage'])." 円\n";
			$order_info .= "◇代引手数料：　".number_format($info['cod_fee'])." 円\n";
			$order_info .= "◇お支払い金額：　".number_format($estimation)." 円(税込)\n";
			$order_info .= "━━━━━━━━━━━━━━━━━━━━━\n\n";

			$order_info .= "◇手書きの打ち換え用テキスト：\n".$info['retyping']."\n";
			$order_info .= "◇使用フォント名：　".$info['font']."\n";
			$order_info .= "------------------------------------------\n\n";

			$order_info .= $attach_info;

			$order_info .= "━━━━━━━━━━━━━━━━━━━━━\n\n";

			$order_info .= "┏━━━━━━━━━━━┓\n";
			$order_info .= "◆　　プリント位置とインク\n";
			$order_info .= "┗━━━━━━━━━━━┛\n";
			$chk = false;
			foreach($area_hash as $key=>$val){
				if(is_array($val)){
					$order_info .= "◇プリント位置：　".$val['area']['pos']."\n";
					$order_info .= "◇プリントサイズ：[MAX] H".$val['area']['h']."cm × W".$val['area']['w']."cm\n";
					for($i=0; $i<count($val['inks']); $i++){
						$order_info .= "　　　".$val['inks'][$i]."\n";
					}
					$order_info .= "　　　　　　　　　　　　計　".$i."色\n";
					$order_info .= "------------------------------------------\n";
					$chk = true;
				}
			}
			if(!$chk) $order_info .= "なし\n";
			$order_info .= "━━━━━━━━━━━━━━━━━━━━━\n\n";

			$order_info .= "┏━━━━━━━━┓\n";
			$order_info .= "◆　　お客様情報\n";
			$order_info .= "┗━━━━━━━━┛\n";
			$order_info .= "◇お名前：　".$name."\n";
			$order_info .= "◇ご住所：　〒".$info['ozipcode']."\n";
			$order_info .= "　　　　　　　　".$info['addr1'].$info['addr2']."\n";
			$order_info .= "　　　　　　　　".$info['addr3']."\n";
			$order_info .= "◇TEL：　".$info['tel']."\n";
			$order_info .= "◇E-Mail：　".$email."\n";
			$order_info .= "◇弊社ご利用について：　".$info['repeater']."\n";
			$order_info .= "━━━━━━━━━━━━━━━━━━━━━\n\n";

			$order_info .= "┏━━━━━━━┓\n";
			$order_info .= "◆　　お届け先\n";
			$order_info .= "┗━━━━━━━┛\n";
			if(empty($info['checkaddress'])){
				$order_info .= "（下記の住所にお届けする）\n";
			}else{
				$order_info .= "（上記ご連絡先と同じ場所にお届けする）\n";
			}
			$order_info .= "◇宛名：　".$info['assn']."\n";
			$order_info .= "◇ご担当者名：　".$info['dfamilyname']." ".$info['dfirstname']."\n";
			$order_info .= "◇クラス名等：　".$info['dept']."\n";
			$order_info .= "◇ご住所：　〒".$info['dzipcode']."\n";
			$order_info .= "　　　　　　　　　".$info['deli1'].$info['deli2']."\n";
			$order_info .= "　　　　　　　　　".$info['deli3']."\n";
			$order_info .= "------------------------------------------\n\n";
			$order_info .= "◇ご希望納期：　".$info['delidate']."\n";
			$order_info .= "━━━━━━━━━━━━━━━━━━━━━\n\n";

			$order_info .= "┏━━━━━━━━━┓\n";
			$order_info .= "◆　　領収書の発行\n";
			$order_info .= "┗━━━━━━━━━┛\n";
			if($info['isreceipt']=="不要"){
				$order_info .= $info['isreceipt']."\n";
			}else{
				$order_info .= "◇宛名：　".$info['rname']."\n";
				$order_info .= "◇但し書き：　".$info['subject']."\n";
				$order_info .= "◇領収書の送り先\n";
				$order_info .= "◇ご住所：　〒".$info['rzipcode']."\n";
				$order_info .= "　　　　　　　　　".$info['receipt1'].$info['receipt2']."\n";
				$order_info .= "　　　　　　　　　".$info['receipt3']."\n";
			}
			$order_info .= "━━━━━━━━━━━━━━━━━━━━━\n\n\n";

			$subject  = $mail_title."　Sweatjack";
			if(!send_mail($order_info, $subject, $name, $email, $attach)){
				$result_sendmail = '<h1>送信エラー</h1>';
				$result_sendmail .= '<p class="err">※&nbsp;ご注文メールの送信が出来ませんでした。</p>';
			}else{
				$_SESSION['order_send']=$_POST['order_send'];
				header("Location: ./finish.php");
				exit(0);
			}

		}catch (Exception $e) {
			$result_sendmail = '<h1>送信エラー</h1>';
			$result_sendmail .= '<p class="err">※&nbsp;お問い合わせの送信が出来ませんでした。'.$e->getMessage().'</p>';
		}

	}


	$ticket = htmlspecialchars(md5(uniqid().mt_rand()), ENT_QUOTES);
	$_SESSION['ticket'] = $ticket;



	/**
	*	メール送信
	*	@order_info		顧客情報と注文内容
	*	@subject		件名
	*	@name			お客様の名前
	*	@to				返信先のメールアドレス
	*	@attach			添付ファイル情報
	*	返り値			true:送信成功 , false:送信失敗
	*/

	function send_mail($order_info, $subject, $name, $to, $attach){
		mb_language("japanese");
		//mb_internal_encoding("EUC-JP");
		$autoReply = true;					// 返信メールの有無（trueで返信する）
		$sendto   = "order@takahama428.com";// 送信先
		$msg = "";							// 送信文
		$boundary = md5(uniqid(rand())); 	// バウンダリー文字（メールメッセージと添付ファイルの境界とする文字列を設定）

		$from = _INFO_EMAIL;
		$fromname = "スウェットジャック";
		$from = mb_encode_mimeheader(mb_convert_encoding($fromname,"JIS","EUC-JP"))."<".$from.">";
		$header = "From: $from\n";
		$header .= "Reply-To: $from\n";
		$header .= "X-Mailer: PHP/".phpversion()."\n";
		$header .= "MIME-version: 1.0\n";

		if(!empty($attach)){ 		// 添付ファイルがあり
			$header .= "Content-Type: multipart/mixed;\n";
			$header .= "\tboundary=\"$boundary\"\n";
			$msg .= "This is a multi-part message in MIME format.\n\n";
			$msg .= "--$boundary\n";
			$msg .= "Content-Type: text/plain; charset=ISO-2022-JP\n";
			$msg .= "Content-Transfer-Encoding: 7bit\n\n";
		}else{												// 添付ファイルなし
			$header .= "Content-Type: text/plain; charset=ISO-2022-JP\n";
			$header .= "Content-Transfer-Encoding: 7bit\n";
		}

		$msg .= mb_convert_encoding($order_info,"JIS","EUC-JP");	// ここで注文情報をエンコードして設定

		if(!empty($attach)){		// 添付ファイル情報
			// デザイン
			for($i=0; $i<count($attach['design']); $i++){
				if(empty($attach['design']['name'][$i])) continue;
				$msg .= "\n\n--$boundary\n";
				$msg .= "Content-Type: " . $attach['design']['type'][$i] . ";\n";
				$msg .= "\tname=\"".$attach['design']['name'][$i]."\"\n";
				$msg .= "Content-Transfer-Encoding: base64\n";
				$msg .= "Content-Disposition: attachment;\n";
				$msg .= "\tfilename=\"".$attach['design']['name'][$i]."\"\n\n";
				$msg .= $attach['design']['file'][$i]."\n";
			}

			// 学生証
			if(!empty($attach['student']['name'])){
				$msg .= "\n\n--$boundary\n";
				$msg .= "Content-Type: " . $attach['student']['type'] . ";\n";
				$msg .= "\tname=\"".$attach['student']['name']."\"\n";
				$msg .= "Content-Transfer-Encoding: base64\n";
				$msg .= "Content-Disposition: attachment;\n";
				$msg .= "\tfilename=\"".$attach['student']['name']."\"\n\n";
				$msg .= $attach['student']['file']."\n";
			}

			$msg .= "--$boundary--";
		}

		// 件名のマルチバイトをエンコード
		$subject  = mb_encode_mimeheader(mb_convert_encoding($subject,"JIS","EUC-JP"));

		// メール送信
		if(mail($sendto, $subject, $msg, $header)){
			if($autoReply){
				$sendto = $to;
				$subject = mb_encode_mimeheader(mb_convert_encoding("ご注文のお申し込み","JIS","EUC-JP"));
				$fromname = "スウェットジャック";
				$from = mb_encode_mimeheader(mb_convert_encoding($fromname,"JIS","EUC-JP"))."<"._INFO_EMAIL.">";

				$header = "From: $from\n";
				$header .= "Reply-To: $from\n";
				$header .= "X-Mailer: PHP/".phpversion()."\n";
				$header .= "MIME-version: 1.0\n";
				$header .= "Content-Type: text/plain; charset=ISO-2022-JP\n";
				$header .= "Content-Transfer-Encoding: 7bit\n";

				$msg = $name."　様\n";
				$msg .= "このたびは、スウェットジャックをご利用いただき誠にありがとうございます。\n";
				$msg .= "お申し込みを承りました。\n";
				$msg .= "このメールはお申し込みいただいたお客様へ、内容確認の自動返信となっております。\n\n";
				$msg .= "《現時点ではご注文は確定しておりません》\n\n";
				$msg .= "制作を開始するにあたりお電話によるデザインなどの打ち合わせをさせていただいております。\n";
				$msg .= "弊社でお申し込み内容を確認した後、「御見積りメール」をお送りいたします。そちらをご一読の上、";
				$msg .= "お手数ですが、フリーダイヤル"._TOLL_FREE."までご連絡ください。\n\n";
				$msg .= "《お支払いにつきまして》\n\n";
				$msg .= "最終打ち合わせが終了し、ご注文が確定いたしましたら、ご注文内容の「確認メール」をお送りいたします。\n";
				$msg .= "間違いが無いかご確認の上、確認メールに記載の方法でお支払いください。\n\n";
				$msg .= "引き続き、どうぞよろしくお願いいたします。\n\n";
				



/*
			$msg .= "\n<==========  夏季休業のお知らせ  ==========>\n";
			$msg .= "8月10日から8月18日までは休業となります。\n";
			$msg .= "休業期間中にご連絡を頂いた場合、\n";
			$msg .= "8月19日以降の対応となりますのでご了承下さい。\n\n";



*/

							
				$msg .= $order_info;
				$msg .= "\n※ご不明な点等ございましたら下記の連絡先までご連絡ください。\n";
				$msg .= "■営業時間　9:30 - 18:00　　■定休日：　土日祝\n\n";
				$msg .= "━ スウェットジャック ━━━━━━━━━━━━━━━━━━━━━━━\n\n";
				$msg .= "　Phone：　　"._OFFICE_TEL."\n";
				$msg .= "　E-Mail：　　info@takahama428.com\n";
				$msg .= "　Web site：　"._DOMAIN."/\n";
				$msg .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

				$msg = mb_convert_encoding($msg,"JIS","EUC-JP");

				mail($sendto, $subject, $msg, $header);
			}
			return true;	// 成功
		}else{
			return false;	// 失敗
		}
	}
?>