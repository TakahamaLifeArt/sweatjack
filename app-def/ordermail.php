<?php
/*
	send order mail module
	charset euc-jp
*/
	$mail_title = "����ʸ�Τ���������";
	if( isset($_POST['order_send'], $_POST['ticket'], $_SESSION['ticket']) && $_POST['ticket']==$_SESSION['ticket'] ) {
		unset($_SESSION['ticket']);
		try{
			$name = $info['ocustomername'];
			$email = $info['email'];
			$order_info = "�������������������ڡ�".$mail_title."���ۨ�����������������\n\n";
			$order_info .= "��������������������\n";
			$order_info .= "����������ʸ����\n";
			$order_info .= "��������������������\n";
			foreach($order_items as $key=>$val){
				foreach($val['size'] as $sizename=>$v){
					$item_subtotal += $v['price']*$v['volume'];
					$order_info .= "�������ƥࡧ��".$val['item_name']."\n";
					$order_info .= "�����顼����".$val['color_code']." ".$val['color_name']."\n";
					$order_info .= "������������".$sizename."\n";
					$order_info .= "��ñ������".number_format($v['price'])." ��\n";
					$order_info .= "���������".$v['volume']." ��\n";
					$order_info .= "�����ס���".number_format($v['price']*$v['volume'])." ��\n";
					$order_info .= "------------------------------------------\n\n";
				}
			}
			$order_info .= "�������塧��".number_format($item_subtotal)." ��\n";
			$order_info .= "���ץ����塧��".number_format($info['print_fee'])." ��\n";
			$order_info .= "�����������".$info['discount_text']."�ˢ�".number_format($info['discount_fee'])." ��\n";
			$order_info .= "���޵ͤ��塧��".number_format($pack_fee)." ��\n";
			$order_info .= "����������".number_format($info['carriage'])." ��\n";
			$order_info .= "��������������".number_format($info['cod_fee'])." ��\n";
			$order_info .= "������ʧ����ۡ���".number_format($estimation)." ��(�ǹ�)\n";
			$order_info .= "������������������������������������������\n\n";

			$order_info .= "����񤭤��Ǥ������ѥƥ����ȡ�\n".$info['retyping']."\n";
			$order_info .= "�����ѥե����̾����".$info['font']."\n";
			$order_info .= "------------------------------------------\n\n";

			$order_info .= $attach_info;

			$order_info .= "������������������������������������������\n\n";

			$order_info .= "��������������������������\n";
			$order_info .= "�������ץ��Ȱ��֤ȥ���\n";
			$order_info .= "��������������������������\n";
			$chk = false;
			foreach($area_hash as $key=>$val){
				if(is_array($val)){
					$order_info .= "���ץ��Ȱ��֡���".$val['area']['pos']."\n";
					$order_info .= "���ץ��ȥ�������[MAX] H".$val['area']['h']."cm �� W".$val['area']['w']."cm\n";
					for($i=0; $i<count($val['inks']); $i++){
						$order_info .= "������".$val['inks'][$i]."\n";
					}
					$order_info .= "�������������������������ס�".$i."��\n";
					$order_info .= "------------------------------------------\n";
					$chk = true;
				}
			}
			if(!$chk) $order_info .= "�ʤ�\n";
			$order_info .= "������������������������������������������\n\n";

			$order_info .= "��������������������\n";
			$order_info .= "�����������;���\n";
			$order_info .= "��������������������\n";
			$order_info .= "����̾������".$name."\n";
			$order_info .= "�������ꡧ����".$info['ozipcode']."\n";
			$order_info .= "����������������".$info['addr1'].$info['addr2']."\n";
			$order_info .= "����������������".$info['addr3']."\n";
			$order_info .= "��TEL����".$info['tel']."\n";
			$order_info .= "��E-Mail����".$email."\n";
			$order_info .= "�����Ҥ����ѤˤĤ��ơ���".$info['repeater']."\n";
			$order_info .= "������������������������������������������\n\n";

			$order_info .= "������������������\n";
			$order_info .= "���������Ϥ���\n";
			$order_info .= "������������������\n";
			if(empty($info['checkaddress'])){
				$order_info .= "�ʲ����ν���ˤ��Ϥ������\n";
			}else{
				$order_info .= "�ʾ嵭��Ϣ�����Ʊ�����ˤ��Ϥ������\n";
			}
			$order_info .= "����̾����".$info['assn']."\n";
			$order_info .= "����ô����̾����".$info['dfamilyname']." ".$info['dfirstname']."\n";
			$order_info .= "�����饹̾������".$info['dept']."\n";
			$order_info .= "�������ꡧ����".$info['dzipcode']."\n";
			$order_info .= "������������������".$info['deli1'].$info['deli2']."\n";
			$order_info .= "������������������".$info['deli3']."\n";
			$order_info .= "------------------------------------------\n\n";
			$order_info .= "������˾Ǽ������".$info['delidate']."\n";
			$order_info .= "������������������������������������������\n\n";

			$order_info .= "����������������������\n";
			$order_info .= "�������μ����ȯ��\n";
			$order_info .= "����������������������\n";
			if($info['isreceipt']=="����"){
				$order_info .= $info['isreceipt']."\n";
			}else{
				$order_info .= "����̾����".$info['rname']."\n";
				$order_info .= "��â���񤭡���".$info['subject']."\n";
				$order_info .= "���μ����������\n";
				$order_info .= "�������ꡧ����".$info['rzipcode']."\n";
				$order_info .= "������������������".$info['receipt1'].$info['receipt2']."\n";
				$order_info .= "������������������".$info['receipt3']."\n";
			}
			$order_info .= "������������������������������������������\n\n\n";

			$subject  = $mail_title."��Sweatjack";
			if(!send_mail($order_info, $subject, $name, $email, $attach)){
				$result_sendmail = '<h1>�������顼</h1>';
				$result_sendmail .= '<p class="err">��&nbsp;����ʸ�᡼�������������ޤ���Ǥ�����</p>';
			}else{
				$_SESSION['order_send']=$_POST['order_send'];
				header("Location: ./finish.php");
				exit(0);
			}

		}catch (Exception $e) {
			$result_sendmail = '<h1>�������顼</h1>';
			$result_sendmail .= '<p class="err">��&nbsp;���䤤��碌������������ޤ���Ǥ�����'.$e->getMessage().'</p>';
		}

	}


	$ticket = htmlspecialchars(md5(uniqid().mt_rand()), ENT_QUOTES);
	$_SESSION['ticket'] = $ticket;



	/**
	*	�᡼������
	*	@order_info		�ܵҾ������ʸ����
	*	@subject		��̾
	*	@name			�����ͤ�̾��
	*	@to				�ֿ���Υ᡼�륢�ɥ쥹
	*	@attach			ź�եե��������
	*	�֤���			true:�������� , false:��������
	*/

	function send_mail($order_info, $subject, $name, $to, $attach){
		mb_language("japanese");
		//mb_internal_encoding("EUC-JP");
		$autoReply = true;					// �ֿ��᡼���̵ͭ��true���ֿ������
		$sendto   = "order@takahama428.com";// ������
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

		$msg .= mb_convert_encoding($order_info,"JIS","EUC-JP");	// ��������ʸ����򥨥󥳡��ɤ�������

		if(!empty($attach)){		// ź�եե��������
			// �ǥ�����
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

			// ������
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

		// ��̾�Υޥ���Х��Ȥ򥨥󥳡���
		$subject  = mb_encode_mimeheader(mb_convert_encoding($subject,"JIS","EUC-JP"));

		// �᡼������
		if(mail($sendto, $subject, $msg, $header)){
			if($autoReply){
				$sendto = $to;
				$subject = mb_encode_mimeheader(mb_convert_encoding("����ʸ�Τ���������","JIS","EUC-JP"));
				$fromname = "�������åȥ���å�";
				$from = mb_encode_mimeheader(mb_convert_encoding($fromname,"JIS","EUC-JP"))."<"._INFO_EMAIL.">";

				$header = "From: $from\n";
				$header .= "Reply-To: $from\n";
				$header .= "X-Mailer: PHP/".phpversion()."\n";
				$header .= "MIME-version: 1.0\n";
				$header .= "Content-Type: text/plain; charset=ISO-2022-JP\n";
				$header .= "Content-Transfer-Encoding: 7bit\n";

				$msg = $name."����\n";
				$msg .= "���Τ��Ӥϡ��������åȥ���å������Ѥ����������ˤ��꤬�Ȥ��������ޤ���\n";
				$msg .= "���������ߤ򾵤�ޤ�����\n";
				$msg .= "���Υ᡼��Ϥ��������ߤ��������������ͤء����Ƴ�ǧ�μ�ư�ֿ��ȤʤäƤ���ޤ���\n\n";
				$msg .= "�Ը������ǤϤ���ʸ�ϳ��ꤷ�Ƥ���ޤ����\n\n";
				$msg .= "����򳫻Ϥ���ˤ����ꤪ���äˤ��ǥ�����ʤɤ��Ǥ���碌�򤵤��Ƥ��������Ƥ���ޤ���\n";
				$msg .= "���ҤǤ������������Ƥ��ǧ�����塢�ָ渫�Ѥ�᡼��פ����ꤤ�����ޤ���������򤴰��ɤξ塢";
				$msg .= "������Ǥ������ե꡼�������"._TOLL_FREE."�ޤǤ�Ϣ������������\n\n";
				$msg .= "�Ԥ���ʧ���ˤĤ��ޤ��ơ�\n\n";
				$msg .= "�ǽ��Ǥ���碌����λ��������ʸ�����ꤤ�����ޤ����顢����ʸ���ƤΡֳ�ǧ�᡼��פ����ꤤ�����ޤ���\n";
				$msg .= "�ְ㤤��̵��������ǧ�ξ塢��ǧ�᡼��˵��ܤ���ˡ�Ǥ���ʧ������������\n\n";
				$msg .= "����³�����ɤ�������������ꤤ�������ޤ���\n\n";
				



/*
			$msg .= "\n<==========  �Ƶ��ٶȤΤ��Τ餻  ==========>\n";
			$msg .= "8��10������8��18���ޤǤϵٶȤȤʤ�ޤ���\n";
			$msg .= "�ٶȴ�����ˤ�Ϣ����ĺ������硢\n";
			$msg .= "8��19���ʹߤ��б��Ȥʤ�ޤ��ΤǤ�λ����������\n\n";



*/

							
				$msg .= $order_info;
				$msg .= "\n���������������������ޤ����鲼����Ϣ����ޤǤ�Ϣ������������\n";
				$msg .= "���ĶȻ��֡�9:30 - 18:00���������������������\n\n";
				$msg .= "�� �������åȥ���å� ����������������������������������������������\n\n";
				$msg .= "��Phone������"._OFFICE_TEL."\n";
				$msg .= "��E-Mail������info@takahama428.com\n";
				$msg .= "��Web site����"._DOMAIN."/\n";
				$msg .= "������������������������������������������������������������������\n";

				$msg = mb_convert_encoding($msg,"JIS","EUC-JP");

				mail($sendto, $subject, $msg, $header);
			}
			return true;	// ����
		}else{
			return false;	// ����
		}
	}
?>