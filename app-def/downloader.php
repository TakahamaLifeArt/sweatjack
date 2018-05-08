<?php
/*
* 	�ե��������������
*	char_set	EUC-JP
*/

	if(isset($_POST['downloadfile'], $_POST['act'])){
		if($_POST['act']=='download'){
			$target = _DOC_ROOT.$_POST['downloadfile'];
			if(!is_file($target)){
				header("Location: "._DOMAIN);
			}else{
				Downloader::done($target);
			}
		}
	}


	class Downloader{

		/*
		 * �����ϥ������åȥե�����ؤ������������Хѥ�
		 */
		public static function done($path_file){
			/* �ե������¸�߳�ǧ */
			if (!file_exists($path_file)) {
				return false;
				die("Error: File(".$path_file.") does not exist");
			}
			/* �����ץ�Ǥ��뤫��ǧ */
			if (!($fp = fopen($path_file, "r"))) {
				return false;
				// die("Error: Cannot open the file(".$path_file.")");
			}
			fclose($fp);
			/* �ե����륵�����γ�ǧ */
			if (($content_length = filesize($path_file)) == 0) {
				return false;
				// die("Error: File size is 0.(".$path_file.")");
			}
			/* ����������Ѥ�HTTP�إå����� */
			header("Content-Disposition: attachment; filename=\"".basename($path_file)."\"");
			header("Content-Length: ".$content_length);
			header("Content-Type: application/octet-stream");
			/* �ե�������ɤ�ǽ��� */
			if (!readfile($path_file)) {
				return false;
				// die("Cannot read the file(".$path_file.")");
			}

			return true;
		}
	}
?>