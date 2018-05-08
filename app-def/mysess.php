<?php
	require dirname(__FILE__)."/session_my_handler.php";
	// SESSION
	// charset euc-jp

	if(isset($_POST['act'])){
		if($_POST['act']=='get'){
			if(isset($_SESSION['orders'][$_POST['mode']])){
				$tmp = $_SESSION['orders'][$_POST['mode']];
				if(isset($_POST['target'])){
					echo $tmp[$_POST['target']];
				}else{
					foreach($tmp as $key=>$val){
						if(is_array($key)){
							for($i=0; $i<count($tmp[$key]); $i++){
								$data .= "&".$key."=".$val;
							}
						}else{
							$data .= "&".$key."=".$val;
						}
					}
					echo substr($data,1);
				}
			}else{
				echo "";
			}

		}else if($_POST['act']=='set'){
			if($_POST['mode']=="estimate"){		// initialize data if mode name is the estimate.
				$_SESSION['orders'][$_POST['mode']][$_POST['navi']] = array();
				foreach($_POST as $key=>$val){
					if($key=='act' || $key=='mode' || $key=='navi') continue;
					$_SESSION['estimate'][$_POST['navi']][$key] = $val;
				}
			}else{
				if($_POST['mode']=="register") $_SESSION['orders'][$_POST['mode']] = array();	// initialize data if mode name is the register.
				if($_POST['mode']=="item" && ($_POST['refpage']!=$_SESSION['orders']['item']['refpage'] && isset($_SESSION['orders']['item']['refpage'])) ){
					$_SESSION['orders'][$_POST['mode']] = array();								// initialize data if mode name is the item and refpage is different.
				}
				foreach($_POST as $key=>$val){
					if($key=='act' || $key=='mode') continue;
					$_SESSION['orders'][$_POST['mode']][$key] = $val;
				}
			}
		}else{
			// remove all
			$_SESSION['orders'][$_POST['mode']] = array();
			unset($_SESSION['orders'][$_POST['mode']]);
		}
	}else{
		echo "";
	}
?>