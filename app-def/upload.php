<?php
	// 添付ファイルがある場合の処理
	if( isset($_POST['uploader']) ){
		$attach_id = $_POST['uploader'];// 添付ファイルの識別ID
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
				echo 'parWin.$("#attached_design").text("（デザイン添付済み）");';
			}else{
				echo 'parWin.$("#attached_card").text("（学生証添付済み）");';
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