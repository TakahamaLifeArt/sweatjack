<?php
/*
	send mail module
	charset euc-jp
*/
	require_once $_SERVER['DOCUMENT_ROOT'].'/../cgi-bin/conndb.php';

	if(empty($mail_title)) $mail_title = "お問い合わせ";
	
	if( isset($_POST['ticket'], $_SESSION['ticket']) && $_POST['ticket']==$_SESSION['ticket'] ) {
		unset($_SESSION['ticket']);
		try{
			$name = htmlspecialchars(mb_convert_encoding($_POST['name'], 'euc-jp'), ENT_QUOTES);
			$email = htmlspecialchars(mb_convert_encoding($_POST['email'], 'euc-jp'), ENT_QUOTES);
			$subject = htmlspecialchars(mb_convert_encoding($_POST['subject'], 'euc-jp'), ENT_QUOTES);
			
			$attach = array();
			
			// 添付ファイルがある場合の処理
			$t=0;
			$max_file_size = _MAXIMUM_SIZE;
			$attach_count = count($_FILES['attachfile']['tmp_name']);
			for($i=0; $i<$attach_count; $i++) {
				if( is_uploaded_file($_FILES['attachfile']['tmp_name'][$i]) ){
					$result = 'ERROR';
					if ($_FILES['attachfile']['error'][$i] == UPLOAD_ERR_OK){

				    	$tmp_path = $_FILES['attachfile']['tmp_name'][$i];
				    	$filename = $_FILES['attachfile']['name'][$i];
						$filetype = $_FILES['attachfile']['type'][$i];
						$filesize = $_FILES['attachfile']['size'][$i];
						$files_len += $filesize;

						if($files_len > $max_file_size){
							$result_msg = '添付ファイルサイズは20MBまでにして下さい。';
						}else{
							$uploadfile = file_get_contents($tmp_path);
							$img_encode64 = chunk_split(base64_encode($uploadfile));

					      	$result = 'OK';
						}

				    }else{
				     	$result_msg = '添付ファイルのアップロード中にエラーです。添付ファイルの指定をやり直してください。';
				    }

				    if($result == 'OK'){
				    	$attach[$t]['file'] = $img_encode64;
						$attach[$t]['name'] = $filename;
						$attach[$t]['type'] = $filetype;
						$attach[$t]['size'] = $filesize;
						$t++;
				    }else{
				    	break;
				    }
				}
			}

		    if($result == 'ERROR'){
		    	$html = '<h1>送信エラー</h1>';
				$html .= '<p class="err">※&nbsp;'.$result_msg.'</p>';

		    }else{
		    	$classify = 1;
				$mail_info = "【　".$mail_title."　】\n";
				$mail_info .= "■お名前：　$name 様\n";
				if(isset($_POST['company'])){	// カタログ・サンプル
					$company = htmlspecialchars(mb_convert_encoding($_POST['company'], 'euc-jp'), ENT_QUOTES);
					$ruby = htmlspecialchars(mb_convert_encoding($_POST['ruby'], 'euc-jp'), ENT_QUOTES);
					$mail_info .= "■フリガナ：　$ruby 様\n";
					$mail_info .= "■会社名：　$company\n";
				}
				$mail_info .= "■E-Mail：　$email\n";
				if(isset($_POST['tel'])){	// お客様窓口、プライバシーポリシー、無料レンタル
					$tel = htmlspecialchars(mb_convert_encoding($_POST['tel'], 'euc-jp'), ENT_QUOTES);
					$mail_info .= "■TEL：　$tel\n";
				}
		    	if(isset($_POST['zipcode'])){	// カタログ・サンプル
		    		$classify = 2;
					$zipcode = htmlspecialchars(mb_convert_encoding($_POST['zipcode'], 'euc-jp'), ENT_QUOTES);
					$addr1 = htmlspecialchars(mb_convert_encoding($_POST['addr1'], 'euc-jp'), ENT_QUOTES);
					$addr2 = htmlspecialchars(mb_convert_encoding($_POST['addr2'], 'euc-jp'), ENT_QUOTES);
					$mail_info .= "■郵便番号：　$zipcode\n";
					$mail_info .= "■ご住所：　$addr1 $addr2\n";
				}
				if(isset($_POST['repeater'])){	// お問合せ
					$repeat = htmlspecialchars(mb_convert_encoding($_POST['repeater'], 'euc-jp'), ENT_QUOTES);
					$mail_info .= "■弊社ご利用について：　$repeat\n";
				}
				if(isset($_POST['sample']) && $_POST['sample']=="sample"){	// カタログ・サンプル（無料レンタルあり）
					$classify = 2;
					$item = htmlspecialchars(mb_convert_encoding($_POST['item'], 'euc-jp'), ENT_QUOTES);
					$size = htmlspecialchars(mb_convert_encoding($_POST['size'], 'euc-jp'), ENT_QUOTES);
					$mail_info .= "\n【　サンプル無料レンタルのお申込み　】\n";
					$mail_info .= "■アイテム：　$item\n";
					$mail_info .= "■サイズ：　$size\n";
				}else{
					$mail_info .= "\n【　". $subject."　】\n";
				}
				if(isset($_POST['volume'])){// 予算SOS
					$classify = 3;
					$item = htmlspecialchars(mb_convert_encoding($_POST['item'], 'euc-jp'), ENT_QUOTES);
					$volume = htmlspecialchars(mb_convert_encoding($_POST['volume'], 'euc-jp'), ENT_QUOTES);
					$price = htmlspecialchars(mb_convert_encoding($_POST['price'], 'euc-jp'), ENT_QUOTES);
					$ink = htmlspecialchars(mb_convert_encoding($_POST['ink'], 'euc-jp'), ENT_QUOTES);
					$request = htmlspecialchars(mb_convert_encoding($_POST['request'], 'euc-jp'), ENT_QUOTES);
					$mail_info .= "■アイテム：　$item\n";
					$mail_info .= "■枚数：　$volume 枚\n";
					$mail_info .= "■ご予算：　$price\n";
					$mail_info .= "■色数：　$ink 色\n";
					$mail_info .= "■デザインのご要望：　\n".$request."\n\n";
				}
				if(isset($_POST['message'])){
					$message = htmlspecialchars(mb_convert_encoding($_POST['message'], 'euc-jp'), ENT_QUOTES);
					$mail_info .= "■お問合せ内容：　\n";
					$mail_info .= "$message\n\n";
				}
				if(isset($_POST['visitdate'])){
					$date = htmlspecialchars(mb_convert_encoding($_POST['visitdate'], 'euc-jp'), ENT_QUOTES);
					$mail_info .= "■工場見学のご希望日：　\n";
					$mail_info .= "$date\n\n";
				}
				for($i=0; $i<count($attach); $i++){
					$f_name = $attach[$i]['name'];
					$mail_info .= "■添付ファイル：　$f_name\n";
				}
				$mail_info .= "■----------------------------------------\n\n";
				
			/*=============== DEBUG =================
				if($_POST['dummy']=='test'){
					$classify = 'test';
				}
			=======================================*/
				
				if(!send_mail($mail_info, $mail_title, $name, $email, $attach, $classify)){
					$html = '<h1>送信エラー</h1>';
					$html .= '<p class="err">※&nbsp;'.$mail_title.'の送信が出来ませんでした。</p>';
				}else{
					// カタログ資料請求の場合
					if($_POST['requestform']){
						$addr = htmlspecialchars(mb_convert_encoding($_POST['addr1'], "utf-8"), ENT_QUOTES);
						if(!empty($_POST['addr2'])){
							$addr = $addr.' '.htmlspecialchars(mb_convert_encoding($_POST['addr2'], "utf-8"), ENT_QUOTES);
						}
						$args = array(
							"requester"=>htmlspecialchars(mb_convert_encoding($_POST['name'], "utf-8"), ENT_QUOTES),
							"subject"=>htmlspecialchars(mb_convert_encoding("資料請求", "utf-8"), ENT_QUOTES),
							"message"=>htmlspecialchars(mb_convert_encoding($_POST['message'], "utf-8"), ENT_QUOTES),
							"reqmail"=>$_POST['email'],
							"reqzip"=>htmlspecialchars($_POST['zipcode'], ENT_QUOTES),
							"reqaddr"=>$addr,
							"site_id"=>5
						);
						$conn = new ConnDB();
						$conn->requestmail($args);
					}
					

					$html = '<h1>'.$name.'&nbsp;様</h1><p>このたびは'.$mail_title.'ありがとうございます。</p>';
					$html .= '<p>おってスタッフよりご連絡をさせていただきます。</p>';
					$html .= '<p>なお、返信メールが届かない場合には、お手数ですが '._TOLL_FREE.' までご連絡下さい。</p>';
				}
			}

		}catch (Exception $e) {
			$html = '<h1>送信エラー</h1>';
			$html .= '<p class="err">※&nbsp;'.$mail_title.'の送信が出来ませんでした。'.$e->getMessage().'</p>';
		}

	}


	$ticket = htmlspecialchars(md5(uniqid().mt_rand()), ENT_QUOTES);
	$_SESSION['ticket'] = $ticket;



	/**
	*	メール送信
	*	@mail_info		顧客情報と注文内容
	*	@mail_title		件名
	*	@name			お客様の名前
	*	@to				返信先のメールアドレス
	*	@attach			添付ファイル情報
	*	@classify		メールの種類	1：問い合わせ、2：資料請求、3：見積
	*
	*	返り値			true:送信成功 , false:送信失敗
	*/

	function send_mail($mail_info, $mail_title, $name, $to, $attach, $classify){
		mb_language("japanese");
		//mb_internal_encoding("EUC-JP");
		switch($classify){
			case '1':
				//$URI = "info@takahama428.com";
				$URI = _INFO_EMAIL;
				$replyfrom = _INFO_EMAIL;
				break;
			case '2':
				//$URI = "info@takahama428.com";
				$URI = _INFO_EMAIL;
				$replyfrom = _REQUEST_EMAIL;
				break;
			case '3':
				//$URI = "estimate@takahama428.com";
				$URI = _ESTIMATE_EMAIL;
				$replyfrom = _ESTIMATE_EMAIL;
				break;
			case 'test':
				//$URI = "test@takahama428.com";
				$URI = _TEST_EMAIL;
				$replyfrom = _INFO_EMAIL;
				break;
			default:
				//$URI = "info@takahama428.com";
				$URI = _INFO_EMAIL;
				$replyfrom = _INFO_EMAIL;
				break;
		}

		$sendto = $URI;						// 送信先メールアドレス
		$autoReply = true;					// 返信メールの有無（trueで返信する）
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

		$msg .= mb_convert_encoding($mail_info,"JIS","EUC-JP");	// ここで注文情報をエンコードして設定

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
		$subject = $mail_title."　Sweatjack";
		$subject  = mb_encode_mimeheader(mb_convert_encoding($subject,"JIS","EUC-JP"));

		// メール送信
		if(mail($sendto, $subject, $msg, $header)){
			if($autoReply){
				$sendto = $to;
				$subject = mb_encode_mimeheader(mb_convert_encoding($mail_title."の受付","JIS","EUC-JP"));
				$fromname = "スウェットジャック";
				$from = mb_encode_mimeheader(mb_convert_encoding($fromname,"JIS","EUC-JP"))."<".$replyfrom.">";

				$header = "From: $from\n";
				$header .= "Reply-To: $from\n";
				$header .= "X-Mailer: PHP/".phpversion()."\n";
				$header .= "MIME-version: 1.0\n";
				$header .= "Content-Type: text/plain; charset=ISO-2022-JP\n";
				$header .= "Content-Transfer-Encoding: 7bit\n";

				$msg = $name."　様\n";
				$msg .= "このたびは、スウェットジャックをご利用いただき誠にありがとうございます。\n";
				$msg .= "以下の内容で".$mail_title."を受付いたしました。おって弊社スタッフより連絡をさせていただきます。\n\n";
				
				
				// 休業の告知文を挿入
				$msg .= mb_convert_encoding(_NOTICE_HOLIDAY,"euc-jp",'utf-8');
				
				
				// 臨時の告知文を挿入
				$msg .= mb_convert_encoding(_EXTRA_NOTICE,"euc-jp",'utf-8');
				
				
				$msg .= "<==========  ".$mail_title."内容  ==========>\n\n";
				$msg .= $mail_info;
				$msg .= "\n※ご不明な点等ございましたら下記の連絡先までご連絡ください。\n";
				$msg .= "┏━━━━━━━━━━━━━━━━━━━\n";
				$msg .= "┃スウェットジャック\n";
				$msg .= "┃"._OFFICE_TEL."\n";
				$msg .= "┃info@takahama428.com\n";
				$msg .= "┃"._DOMAIN."\n";
				$msg .= "┗━━━━━━━━━━━━━━━━━━━\n";

				$msg = mb_convert_encoding($msg,"JIS","EUC-JP");

				mail($sendto, $subject, $msg, $header);
			}
			return true;	// 成功
		}else{
			return false;	// 失敗
		}
	}
?>