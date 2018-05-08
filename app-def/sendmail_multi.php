<?php
	/**
	*	複数メール送信
	*	@mail_info		メール本文
	*	@subject		件名
	*	@sendto			送信先のメールアドレスの配列
	*	@formname		送信者の名前
	*	@fromaddr		送信者のメールアドレス（Reply-To に設定）
	*	@bcc			BCC のメールアドレス default ""
	*	@cc				CC のメールアドレス default ""
	*	@attach			添付ファイル情報の配列 default ""
	*	返り値			送信先に対しての結果を配列で返す。
	*/

	function send_mail_multi($mail_info, $subject, $sendto, $fromname, $formaddr, $bcc="", $cc="", $attach=""){
		mb_language("japanese");
		//mb_internal_encoding("EUC-JP");
		$autoReply = false;					// 返信メールの有無（trueで返信する）
		$msg = "";							// 送信文
		$boundary = md5(uniqid(rand())); 	// バウンダリー文字（メールメッセージと添付ファイルの境界とする文字列を設定）
		$from = mb_encode_mimeheader(mb_convert_encoding($fromname,"JIS","EUC-JP"))."<"._INFO_EMAIL.">";
		$replay = mb_encode_mimeheader(mb_convert_encoding($fromname,"JIS","EUC-JP"))."<".$formaddr.">";
		$header = "From: $from\n";
		$header .= "Reply-To: $replay\n";
		if(!empty($bcc)){
			$header .= "Bcc: ".$bcc."\n";
		}
		if(!empty($cc)){
			$header .= "Cc: ".$cc."\n";
		}
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



/*
			$msg .= "\n<==========  夏季休業のお知らせ  ==========>\n";
			$msg .= "8月10日から8月18日までは休業となります。\n";
			$msg .= "休業期間中にご連絡を頂いた場合、\n";
			$msg .= "8月19日以降の対応となりますのでご了承下さい。\n\n";
					



*/


		$mail_info .= "\n※ご不明な点等ございましたら下記の連絡先までご連絡ください。\n";
		$mail_info .= "┏━━━━━━━━━━━━━━━━━━━\n";
		$mail_info .= "┃スウェットジャック\n";
		$mail_info .= "┃Tel: "._OFFICE_TEL."\n";
		$mail_info .= "┃E-mail: info@takahama428.com\n";
		$mail_info .= "┃URL: "._DOMAIN."\n";
		$mail_info .= "┗━━━━━━━━━━━━━━━━━━━\n";
		$msg .= mb_convert_encoding($mail_info,"JIS","EUC-JP");	// ここで本文をエンコードして設定

		if(!empty($attach)){		// 添付ファイル情報
			for($i=0; $i<count($attach); $i++){
				$msg .= "\n\n--$boundary\n";
				$msg .= "Content-Type: " . $attach[$i]['type'] . ";\n";
				$msg .= "\tname=\"".$attach[$i]['name']."\"\n";
				$msg .= "Content-Transfer-Encoding: base64\n";
				$msg .= "Content-Disposition: attachment;\n";
				$msg .= "\tfilename=\"".$attach[$i]['name']."\"\n\n";
				$msg .= $attach[$i]['file']."\n";
			}
			$msg .= "--$boundary--";
		}

		// 件名のマルチバイトをエンコード
		$subject  = mb_encode_mimeheader(mb_convert_encoding($subject,"JIS","EUC-JP"));

		// メール送信
		for($i=0; $i<count($sendto); $i++){
			if(strpos($sendto[$i], "@")===false){
				$res[$i] = $sendto[$i];
				continue;
			}
			list($localname, $domain) = explode("@", $sendto[$i]);
			if(!checkdnsrr($domain, 'MX')){
				$res[$i] = $sendto[$i];
			}else{
				if(mail($sendto[$i], $subject, $msg, $header)){
					$res[$i] = "0";	// 成功
				}else{
					$res[$i] = $sendto[$i];	// 失敗したアドレス
				}
			}
		}

		return $res;
	}

?>