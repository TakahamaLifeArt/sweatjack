<?php
	// ź�եե����뤬������ν���
	if( isset($_POST['uploader']) ){
		$attach_id = $_POST['uploader'];// ź�եե�����μ���ID
		$max_file_size = 10485760*2;	// 20MB
		$result = 'ERROR';
	  	$result_msg = 'No FILE field found';

		if (isset($_FILES['uploadfile'])) {
			unset($_SESSION['orders']['item']['attachfile'][$attach_id]);
			unset($_SESSION['orders']['item']['attachname'][$attach_id]);
			unset($_SESSION['orders']['item']['attachtype'][$attach_id]);

			$t=0;
			$attach_count = count($_FILES['uploadfile']['tmp_name']);
			for($i=0; $i<$attach_count; $i++) {
				if( is_uploaded_file($_FILES['uploadfile']['tmp_name'][$i]) ){
					$result = 'ERROR';
					if ($_FILES['uploadfile']['error'][$i] == UPLOAD_ERR_OK){

				    	$tmp_path = $_FILES['uploadfile']['tmp_name'][$i];
				    	$filename = $_FILES['uploadfile']['name'][$i];
						$filetype = $_FILES['uploadfile']['type'][$i];
						$files_len += $_FILES['uploadfile']['size'][$i];

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
						$t++;
				    }else{
				    	break;
				    }
				}
			}

		}

			// this code is outputted to IFRAME (embedded frame)
		echo '<html><head><meta http-equiv="Content-Type" content="text/html; charset=euc-jp" /><title>-</title></head><body>';
		echo '<script language="JavaScript" type="text/javascript">'."\n";
		echo 'var parWin = window.parent;';

		if ($result == 'OK'){
			for($a=0; $a<$t; $a++){
				$_SESSION['orders']['item']['attachfile'][$attach_id][$a] = $attach[$a]['file'];
				$_SESSION['orders']['item']['attachname'][$attach_id][$a] = $attach[$a]['name'];
				$_SESSION['orders']['item']['attachtype'][$attach_id][$a] = $attach[$a]['type'];
			}
			if($attach_id==1){
				echo 'parWin.$("#attached_design").text("�ʥǥ�����ź�պѤߡ�");';
			}else{
				echo 'parWin.$("#attached_card").text("�ʳ�����ź�պѤߡ�");';
			}
		}else{
			if($attach_id==1){
				echo 'parWin.document.forms["attach_design_form"].reset();';
				echo 'parWin.$("#attached_design").text("");';
			}else{
				echo 'parWin.document.forms["attach_identification_form"].reset();';
				echo 'parWin.$("#attached_card").text("");';
			}
			echo 'parWin.alert("'.$result_msg.'");';
		}

		echo "\n".'</script></body></html>';
		exit(); // do not go futher
	}
?>