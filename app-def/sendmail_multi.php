<?php
	/**
	*	ʣ���᡼������
	*	@mail_info		�᡼����ʸ
	*	@subject		��̾
	*	@sendto			������Υ᡼�륢�ɥ쥹������
	*	@formname		�����Ԥ�̾��
	*	@fromaddr		�����ԤΥ᡼�륢�ɥ쥹��Reply-To �������
	*	@bcc			BCC �Υ᡼�륢�ɥ쥹 default ""
	*	@cc				CC �Υ᡼�륢�ɥ쥹 default ""
	*	@attach			ź�եե������������� default ""
	*	�֤���			��������Ф��Ƥη�̤�������֤���
	*/

	function send_mail_multi($mail_info, $subject, $sendto, $fromname, $formaddr, $bcc="", $cc="", $attach=""){
		mb_language("japanese");
		//mb_internal_encoding("EUC-JP");
		$autoReply = false;					// �ֿ��᡼���̵ͭ��true���ֿ������
		$msg = "";							// ����ʸ
		$boundary = md5(uniqid(rand())); 	// �Х�����꡼ʸ���ʥ᡼���å�������ź�եե�����ζ����Ȥ���ʸ����������
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



/*
			$msg .= "\n<==========  �Ƶ��ٶȤΤ��Τ餻  ==========>\n";
			$msg .= "8��10������8��18���ޤǤϵٶȤȤʤ�ޤ���\n";
			$msg .= "�ٶȴ�����ˤ�Ϣ���ĺ������硢\n";
			$msg .= "8��19���ʹߤ��б��Ȥʤ�ޤ��ΤǤ�λ����������\n\n";
					



*/


		$mail_info .= "\n���������������������ޤ����鲼����Ϣ����ޤǤ�Ϣ����������\n";
		$mail_info .= "����������������������������������������\n";
		$mail_info .= "���������åȥ���å�\n";
		$mail_info .= "��Tel: "._OFFICE_TEL."\n";
		$mail_info .= "��E-mail: info@takahama428.com\n";
		$mail_info .= "��URL: "._DOMAIN."\n";
		$mail_info .= "����������������������������������������\n";
		$msg .= mb_convert_encoding($mail_info,"JIS","EUC-JP");	// ��������ʸ�򥨥󥳡��ɤ�������

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
		$subject  = mb_encode_mimeheader(mb_convert_encoding($subject,"JIS","EUC-JP"));

		// �᡼������
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
					$res[$i] = "0";	// ����
				}else{
					$res[$i] = $sendto[$i];	// ���Ԥ������ɥ쥹
				}
			}
		}

		return $res;
	}

?>