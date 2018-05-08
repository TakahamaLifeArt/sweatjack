<?php
/*
	send mail module
	charset euc-jp
*/
	require_once $_SERVER['DOCUMENT_ROOT'].'/../cgi-bin/conndb.php';

	if(empty($mail_title)) $mail_title = "���䤤��碌";
	
	if( isset($_POST['ticket'], $_SESSION['ticket']) && $_POST['ticket']==$_SESSION['ticket'] ) {
		unset($_SESSION['ticket']);
		try{
			$name = htmlspecialchars(mb_convert_encoding($_POST['name'], 'euc-jp'), ENT_QUOTES);
			$email = htmlspecialchars(mb_convert_encoding($_POST['email'], 'euc-jp'), ENT_QUOTES);
			$subject = htmlspecialchars(mb_convert_encoding($_POST['subject'], 'euc-jp'), ENT_QUOTES);
			
			$attach = array();
			
			// ź�եե����뤬������ν���
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
							$result_msg = 'ź�եե����륵������20MB�ޤǤˤ��Ʋ�������';
						}else{
							$uploadfile = file_get_contents($tmp_path);
							$img_encode64 = chunk_split(base64_encode($uploadfile));

					      	$result = 'OK';
						}

				    }else{
				     	$result_msg = 'ź�եե�����Υ��åץ�����˥��顼�Ǥ���ź�եե�����λ������ľ���Ƥ���������';
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
		    	$html = '<h1>�������顼</h1>';
				$html .= '<p class="err">��&nbsp;'.$result_msg.'</p>';

		    }else{
		    	$classify = 1;
				$mail_info = "�ڡ�".$mail_title."����\n";
				$mail_info .= "����̾������$name ��\n";
				if(isset($_POST['company'])){	// ������������ץ�
					$company = htmlspecialchars(mb_convert_encoding($_POST['company'], 'euc-jp'), ENT_QUOTES);
					$ruby = htmlspecialchars(mb_convert_encoding($_POST['ruby'], 'euc-jp'), ENT_QUOTES);
					$mail_info .= "���եꥬ�ʡ���$ruby ��\n";
					$mail_info .= "�����̾����$company\n";
				}
				$mail_info .= "��E-Mail����$email\n";
				if(isset($_POST['tel'])){	// ������������ץ饤�Х����ݥꥷ����̵����󥿥�
					$tel = htmlspecialchars(mb_convert_encoding($_POST['tel'], 'euc-jp'), ENT_QUOTES);
					$mail_info .= "��TEL����$tel\n";
				}
		    	if(isset($_POST['zipcode'])){	// ������������ץ�
		    		$classify = 2;
					$zipcode = htmlspecialchars(mb_convert_encoding($_POST['zipcode'], 'euc-jp'), ENT_QUOTES);
					$addr1 = htmlspecialchars(mb_convert_encoding($_POST['addr1'], 'euc-jp'), ENT_QUOTES);
					$addr2 = htmlspecialchars(mb_convert_encoding($_POST['addr2'], 'euc-jp'), ENT_QUOTES);
					$mail_info .= "��͹���ֹ桧��$zipcode\n";
					$mail_info .= "�������ꡧ��$addr1 $addr2\n";
				}
				if(isset($_POST['repeater'])){	// ����礻
					$repeat = htmlspecialchars(mb_convert_encoding($_POST['repeater'], 'euc-jp'), ENT_QUOTES);
					$mail_info .= "�����Ҥ����ѤˤĤ��ơ���$repeat\n";
				}
				if(isset($_POST['sample']) && $_POST['sample']=="sample"){	// ������������ץ��̵����󥿥뤢���
					$classify = 2;
					$item = htmlspecialchars(mb_convert_encoding($_POST['item'], 'euc-jp'), ENT_QUOTES);
					$size = htmlspecialchars(mb_convert_encoding($_POST['size'], 'euc-jp'), ENT_QUOTES);
					$mail_info .= "\n�ڡ�����ץ�̵����󥿥�Τ������ߡ���\n";
					$mail_info .= "�������ƥࡧ��$item\n";
					$mail_info .= "������������$size\n";
				}else{
					$mail_info .= "\n�ڡ�". $subject."����\n";
				}
				if(isset($_POST['volume'])){// ͽ��SOS
					$classify = 3;
					$item = htmlspecialchars(mb_convert_encoding($_POST['item'], 'euc-jp'), ENT_QUOTES);
					$volume = htmlspecialchars(mb_convert_encoding($_POST['volume'], 'euc-jp'), ENT_QUOTES);
					$price = htmlspecialchars(mb_convert_encoding($_POST['price'], 'euc-jp'), ENT_QUOTES);
					$ink = htmlspecialchars(mb_convert_encoding($_POST['ink'], 'euc-jp'), ENT_QUOTES);
					$request = htmlspecialchars(mb_convert_encoding($_POST['request'], 'euc-jp'), ENT_QUOTES);
					$mail_info .= "�������ƥࡧ��$item\n";
					$mail_info .= "���������$volume ��\n";
					$mail_info .= "����ͽ������$price\n";
					$mail_info .= "����������$ink ��\n";
					$mail_info .= "���ǥ�����Τ���˾����\n".$request."\n\n";
				}
				if(isset($_POST['message'])){
					$message = htmlspecialchars(mb_convert_encoding($_POST['message'], 'euc-jp'), ENT_QUOTES);
					$mail_info .= "������礻���ơ���\n";
					$mail_info .= "$message\n\n";
				}
				if(isset($_POST['visitdate'])){
					$date = htmlspecialchars(mb_convert_encoding($_POST['visitdate'], 'euc-jp'), ENT_QUOTES);
					$mail_info .= "�����츫�ؤΤ���˾������\n";
					$mail_info .= "$date\n\n";
				}
				for($i=0; $i<count($attach); $i++){
					$f_name = $attach[$i]['name'];
					$mail_info .= "��ź�եե����롧��$f_name\n";
				}
				$mail_info .= "��----------------------------------------\n\n";
				
			/*=============== DEBUG =================
				if($_POST['dummy']=='test'){
					$classify = 'test';
				}
			=======================================*/
				
				if(!send_mail($mail_info, $mail_title, $name, $email, $attach, $classify)){
					$html = '<h1>�������顼</h1>';
					$html .= '<p class="err">��&nbsp;'.$mail_title.'������������ޤ���Ǥ�����</p>';
				}else{
					// ��������������ξ��
					if($_POST['requestform']){
						$addr = htmlspecialchars(mb_convert_encoding($_POST['addr1'], "utf-8"), ENT_QUOTES);
						if(!empty($_POST['addr2'])){
							$addr = $addr.' '.htmlspecialchars(mb_convert_encoding($_POST['addr2'], "utf-8"), ENT_QUOTES);
						}
						$args = array(
							"requester"=>htmlspecialchars(mb_convert_encoding($_POST['name'], "utf-8"), ENT_QUOTES),
							"subject"=>htmlspecialchars(mb_convert_encoding("��������", "utf-8"), ENT_QUOTES),
							"message"=>htmlspecialchars(mb_convert_encoding($_POST['message'], "utf-8"), ENT_QUOTES),
							"reqmail"=>$_POST['email'],
							"reqzip"=>htmlspecialchars($_POST['zipcode'], ENT_QUOTES),
							"reqaddr"=>$addr,
							"site_id"=>5
						);
						$conn = new ConnDB();
						$conn->requestmail($args);
					}
					

					$html = '<h1>'.$name.'&nbsp;��</h1><p>���Τ��Ӥ�'.$mail_title.'���꤬�Ȥ��������ޤ���</p>';
					$html .= '<p>���äƥ����åդ�ꤴϢ��򤵤��Ƥ��������ޤ���</p>';
					$html .= '<p>�ʤ����ֿ��᡼�뤬�Ϥ��ʤ����ˤϡ�������Ǥ��� '._TOLL_FREE.' �ޤǤ�Ϣ��������</p>';
				}
			}

		}catch (Exception $e) {
			$html = '<h1>�������顼</h1>';
			$html .= '<p class="err">��&nbsp;'.$mail_title.'������������ޤ���Ǥ�����'.$e->getMessage().'</p>';
		}

	}


	$ticket = htmlspecialchars(md5(uniqid().mt_rand()), ENT_QUOTES);
	$_SESSION['ticket'] = $ticket;



	/**
	*	�᡼������
	*	@mail_info		�ܵҾ������ʸ����
	*	@mail_title		��̾
	*	@name			�����ͤ�̾��
	*	@to				�ֿ���Υ᡼�륢�ɥ쥹
	*	@attach			ź�եե��������
	*	@classify		�᡼��μ���	1���䤤��碌��2���������ᡢ3������
	*
	*	�֤���			true:�������� , false:��������
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

		$sendto = $URI;						// ������᡼�륢�ɥ쥹
		$autoReply = true;					// �ֿ��᡼���̵ͭ��true���ֿ������
		$msg = "";							// ����ʸ
		$boundary = md5(uniqid(rand())); 	// �Х�����꡼ʸ���ʥ᡼���å�������ź�եե�����ζ����Ȥ���ʸ����������

		$from = _INFO_EMAIL;
		$fromname = "�������åȥ���å�";
		$from = mb_encode_mimeheader(mb_convert_encoding($fromname,"JIS","EUC-JP"))."<".$from.">";
		$header = "From: $from\n";
		$header .= "Reply-To: $from\n";
		$header .= "X-Mailer: PHP/".phpversion()."\n";
		$header .= "MIME-version: 1.0\n";

		if(!empty($attach)){ 		// ź�եե����뤬����
			$header .= "Content-Type: multipart/mixed;\n";
			$header .= "\tboundary=\"$boundary\"\n";
			$msg .= "This is a multi-part message in MIME format.\n\n";
			$msg .= "--$boundary\n";
			$msg .= "Content-Type: text/plain; charset=ISO-2022-JP\n";
			$msg .= "Content-Transfer-Encoding: 7bit\n\n";
		}else{												// ź�եե�����ʤ�
			$header .= "Content-Type: text/plain; charset=ISO-2022-JP\n";
			$header .= "Content-Transfer-Encoding: 7bit\n";
		}

		$msg .= mb_convert_encoding($mail_info,"JIS","EUC-JP");	// ��������ʸ����򥨥󥳡��ɤ�������

		if(!empty($attach)){		// ź�եե��������
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

		// ��̾�Υޥ���Х��Ȥ򥨥󥳡���
		$subject = $mail_title."��Sweatjack";
		$subject  = mb_encode_mimeheader(mb_convert_encoding($subject,"JIS","EUC-JP"));

		// �᡼������
		if(mail($sendto, $subject, $msg, $header)){
			if($autoReply){
				$sendto = $to;
				$subject = mb_encode_mimeheader(mb_convert_encoding($mail_title."�μ���","JIS","EUC-JP"));
				$fromname = "�������åȥ���å�";
				$from = mb_encode_mimeheader(mb_convert_encoding($fromname,"JIS","EUC-JP"))."<".$replyfrom.">";

				$header = "From: $from\n";
				$header .= "Reply-To: $from\n";
				$header .= "X-Mailer: PHP/".phpversion()."\n";
				$header .= "MIME-version: 1.0\n";
				$header .= "Content-Type: text/plain; charset=ISO-2022-JP\n";
				$header .= "Content-Transfer-Encoding: 7bit\n";

				$msg = $name."����\n";
				$msg .= "���Τ��Ӥϡ��������åȥ���å������Ѥ����������ˤ��꤬�Ȥ��������ޤ���\n";
				$msg .= "�ʲ������Ƥ�".$mail_title."����դ������ޤ��������ä����ҥ����åդ��Ϣ��򤵤��Ƥ��������ޤ���\n\n";
				
				
				// �ٶȤι���ʸ������
				$msg .= mb_convert_encoding(_NOTICE_HOLIDAY,"euc-jp",'utf-8');
				
				
				// �׻��ι���ʸ������
				$msg .= mb_convert_encoding(_EXTRA_NOTICE,"euc-jp",'utf-8');
				
				
				$msg .= "<==========  ".$mail_title."����  ==========>\n\n";
				$msg .= $mail_info;
				$msg .= "\n���������������������ޤ����鲼����Ϣ����ޤǤ�Ϣ����������\n";
				$msg .= "����������������������������������������\n";
				$msg .= "���������åȥ���å�\n";
				$msg .= "��"._OFFICE_TEL."\n";
				$msg .= "��info@takahama428.com\n";
				$msg .= "��"._DOMAIN."\n";
				$msg .= "����������������������������������������\n";

				$msg = mb_convert_encoding($msg,"JIS","EUC-JP");

				mail($sendto, $subject, $msg, $header);
			}
			return true;	// ����
		}else{
			return false;	// ����
		}
	}
?>