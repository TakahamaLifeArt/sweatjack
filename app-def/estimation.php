<?php
/**
 * タカハマラフアート Sweatjack
 * 見積り計算　
 * charset euc-jp
 * 
 * log: 2016-09-21 シルクプリント代取得で、通常版とジャンボ版を一括取得
 */ 

	require_once $_SERVER['DOCUMENT_ROOT'].'/../cgi-bin/conndb.php';

	if(isset($_POST['act'])){
		switch($_POST['act']){
			case 'silkprintfee':
				$count = count($_POST['area']);
				for($i=0; $i<$count; $i++){
					$args[$i]['amount']=$_POST['amount'];
					$args[$i]['area']=$_POST['area'][$i];
					$args[$i]['ink']=$_POST['ink'][$i];
					$args[$i]['item_id']=$_POST['item_id'];
					$args[$i]['ratio']=1;
					$args[$i]['size']=$_POST['size'][$i];
					$args[$i]['extra']=$_POST['extra'][$i];
					$args[$i]['repeat']=0;
				}
				
				$conn = new Conndb();
				$res = $conn->silkprintfee($args);
				
				if(isset($_POST['jumbo'])){
					for($i=0; $i<$count; $i++){
						$args[$i]['amount']=$_POST['amount'];
						$args[$i]['area']=$_POST['area'][$i];
						$args[$i]['ink']=$_POST['ink'][$i];
						$args[$i]['item_id']=$_POST['item_id'];
						$args[$i]['ratio']=1;
						$args[$i]['size']=1;
						$args[$i]['extra']=$_POST['extra'][$i];
						$args[$i]['repeat']=0;
					}
					$res2 = $conn->silkprintfee($args);
					
					$res = $res."|".$res2;
				}
				
				break;
		}

		echo $res;
	}
?>