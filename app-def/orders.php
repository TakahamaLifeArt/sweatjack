<?php
/*
*	タカハマライフアート
*	データベースの操作
*	charset UTF-8
*/

	require_once dirname(__FILE__).'/MYDB.php';

	class Orders {

		public function db($func, $table, $param){
			try{
				db_connect();

				switch($func){
				case 'insert':
					mysql_query('BEGIN');
					$result = $this->insert($table, $param);
					if(!is_null($result)) mysql_query('COMMIT');
					break;
				case 'update':
					mysql_query('BEGIN');
					$result = $this->update($table, $param);
					if(!is_null($result)) mysql_query('COMMIT');
					break;
				case 'delete':
					mysql_query('BEGIN');
					$result = $this->delete($table, $param);
					if(!is_null($result)) mysql_query('COMMIT');
					break;
				case 'search':
					$result = $this->search($table, $param);
					break;
				}
			}catch(Exception $e){
				$result = null;
			}

			mysql_close();

			return $result;
		}



		/**
		*		レコードの新規追加
		*		@table		テーブル名
		*		@data		追加データの配列、若しくは注文伝票ID
		*
		*		return		成功したら追加されたID
		*/
		private function insert($table, $data){
			try{
				switch($table){
				case 'contact':
					list($data1, $data2) = $data;
					foreach($data1 as $key=>$val){
						$info[$key]	= quote_smart($val);
					}

					// 登録日付
					$today = date('Y-m-d');

					// 既存顧客の確認
					$sql = sprintf("select * from customer where email='%s'", $info["email"]);
					$result = exe_sql($sql);
					if(mysql_num_rows($result)==0){
						// 顧客の新規登録
						$sql = sprintf("INSERT INTO customer(customername,zipcode,addr1,addr2,tel,email,mobile,company)
										VALUES('%s','%s','%s','%s','%s','%s','%s','%s')",
									   	$info["customername"],
										$info["zipcode"],
								 	   	$info["addr1"],
								 	   	$info["addr2"],
								 	   	$info["tel"],
								 	   	$info["email"],
								 	   	$info["mobile"],
								 	   	$info["company"]
									);
						if(exe_sql($sql)){
							$customer_id = mysql_insert_id();
							if( !exe_sql("UPDATE customer SET number=".$customer_id." WHERE id=".$customer_id) ){
								mysql_query('ROLLBACK');
								return null;
							}
						}else{
							mysql_query('ROLLBACK');
							return null;
						}
					}else{
						// 既存顧客のIDを取得
						$rec = mysql_fetch_assoc($result);
						$customer_id = $rec['id'];
					}

					// メールデータの登録
					$sql = sprintf("INSERT INTO contactinfo(contactname,subject,message,contactdate,phase_id,site_id,class_id,contact_refid)
									VALUES('%s','%s','%s','%s',%d,%d,%d,%d)",
									$info["contactname"],
								   	$info["subject"],
							 	   	$info["message"],
							 	   	$today,
							 	   	$info["phase_id"],
							 	   	$info["site_id"],
							 	   	$info["class_id"],
							 	   	$customer_id
								);
    				if(exe_sql($sql)){
						$contact_id = mysql_insert_id();
					}else{
						mysql_query('ROLLBACK');
						return null;
					}

					// 添付ファイルの登録
					if(!empty($data2)){
						$sql = "INSERT INTO attachinfo(attachdata,attachname,attachtype,attachsize,attachmode,attachdate,contact_id,attach_refid) VALUES";
						for($i=0; $i<count($data2); $i++){
							$sql .= "('".quote_smart($data2[$i]['attachdata'])."'";
							$sql .= ",'".quote_smart($data2[$i]['attachname'])."'";
							$sql .= ",'".quote_smart($data2[$i]['attachtype'])."'";
							$sql .= ",".quote_smart($data2[$i]['attachsize']);
							$sql .= ",".quote_smart($data2[$i]['attachmode']);
							$sql .= ",'".$today."'";
							$sql .= ",".$contact_id;
							$sql .= ",".$customer_id."),";
						}
						$sql = substr($sql, 0, -1);

						if(exe_sql($sql)===false){
							mysql_query('ROLLBACK');
							return null;
						}
					}

					// 返り値　問い合わせテーブルのID
					$rs = $contact_id;

					break;

				}

			}catch(Exception $e){
				mysql_query('ROLLBACK');
				$rs = null;
			}

			return $rs;
		}




		/**
		*		�쥳���ɤν�������
		*		@table		�ơ��֥�̾
		*		@data		�����ǡ���������
		*
		*		return		�����鹹�����줿�쥳���ɿ�
		*/
		private function update($table, $data){
			try{

			}catch(Exception $e){
				mysql_query('ROLLBACK');
				$rs = null;
			}

			return $rs;
		}



		/**
		*		�쥳���ɤθ���
		*		@table		�ơ��֥�̾
		*		@data		��������������
		*
		*		return		����̤�����
		*/
		private function search($table, $data){
			try{

			}catch(Exception $e){
				mysql_query('ROLLBACK');
				$rs = null;
			}

			return $rs;
		}
	}
?>