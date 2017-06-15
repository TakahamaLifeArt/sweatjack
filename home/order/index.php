<?php
	if(isset($_REQUEST['item_id'])){
		$_FLG_ITEM_ID = $_REQUEST['item_id'];
	}else if(isset($_REQUEST['pants_id'])){
		$_FLG_ITEM_ID = $_REQUEST['pants_id'];	// �岼���åȥ��å�
	}else{
		$_FLG_ITEM_ID = 173;	// 185-nsz ����������ɥ��åץѡ�����
	}
	$_FLG_COLORCODE = isset($_REQUEST['color_code'])? $_REQUEST['color_code']: '';
	//$_UPDATED = empty($_REQUEST['update'])? 0: $_REQUEST['update'];
	if(isset($_REQUEST['c'])){
		$_UPDATED = 1;
		$args = $_REQUEST['c'];
	}else{
		$_UPDATED = 0;
		$args = 0;
	}
	
	if(isset($_REQUEST['cart'])){
		$_CART = 1;
	}else{
		$_CART = 0;
	}
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/../app-def/initcontents.php';
	
	// �ǥ�����ƥ�ץ졼�Ȥλ��꤬������
	if(isset($_REQUEST['tmpc'],$_REQUEST['tmpn'])){
		$template_category = array(
			'dance'=>'����',
			'team'=>'������',
			'event'=>'���٥��',
			'emblem'=>'����֥��',
			'stamp'=>'�������',
			'silhouette-animal'=>'���륨�å�ưʪ',
			'silhouette-person'=>'���륨�åȿ�ʪ',
			'parts'=>'�ѡ���',
			'other'=>'����¾'
			
		);
		$_SESSION['orders']['customer']['note_template'] = mb_convert_encoding($template_category[$_REQUEST['tmpc']].' '.$_REQUEST['tmpn'], 'utf-8', 'euc-jp');
	}
	
	require_once dirname(__FILE__).'/../php_libs/orders.php';
	$order = new Orders();
	
	// ������
	$tax = $order->salestax();
	$tax /= 100;
	
	// ���ƥ��꡼��������
	//$itemattr = $conn->itemAttr($_FLG_ITEM_ID);
	list($itemattr, $categories) = $order->getCategoryInfo($_FLG_ITEM_ID);
	
	list($categorykey, $categoryname) = each($itemattr['category']);
	$folder = $categorykey;
	$_CAT_KEY = $categorykey;
	$categoryname = mb_convert_encoding($categoryname,'euc-jp','utf-8');
	list($itemcode, $itemname) = each($itemattr['name']);
	list($code, $colorname) = each($itemattr['code']);
	$itemname = mb_convert_encoding($itemname,'euc-jp','utf-8');
	$curcolor = mb_convert_encoding($colorname,'euc-jp','utf-8');
	
	// �����ƥ������������
	$ite = new Items($categorykey);
	$res = $ite->getItemlist($args);		// 2013-12-06 �������ɲ�
	
	// estimattion data
	$data = $order->reqDetails();
	$total = $data['total']*(1+$tax);
	if($data['options']['payment']==3) $total = $total*(1+_CREDIT_RATE);
	$perone = floor($total/$data['amount']);
	$total = floor($total);
	
	// user info
	foreach($regist['customer'] as $key=>$val){
		$user[$key] = mb_convert_encoding($val, 'euc-jp', auto);
	}
	
	/* ���ƥ��꡼���쥯���� */
	$category_selector = '<select id="category_selector">';
	/* Sweatjack�Ѥ��ѹ��Τ���
	for($i=0; $i<count($categories); $i++){
		$category_selector .= '<option value="'.$categories[$i]['code'].'" rel="'.$categories[$i]['id'].'">'.mb_convert_encoding($categories[$i]['name'],'euc-jp','utf-8').'</option>';
	}
	*/
	$category_selector .= '<option value="0">�ѡ�����</option>';
	$category_selector .= '<option value="1">�ȥ졼�ʡ�</option>';
	$category_selector .= '<option value="2">�ѥ��</option>';
	$category_selector .= '<option value="3">���㥱�å�</option>';
	$category_selector .= '<option value="4">�����ԥ���</option>';
	$category_selector .= '</select>';
	$category_selector = str_replace('value="'.$args.'"', 'value="'.$args.'" selected="selected"', $category_selector);
	
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="euc-jp" />
	<title>���������ߥե����ࡡ|�����ꥸ�ʥ�ѡ������Υ������åȥ���å�</title>
    <meta name="description" content="���ꥸ�ʥ�ѡ������Τ���ʸ�Ϥ����餫�顣���������ե���������Ϥ���ȸ��Ѥ⼫ư�ǤǤ��롪������������ͽ�����狼��¿��Ǥ������ꥸ�ʥ륹�����åȤ���ʤ饹�����åȥ���å���" />
    <meta name="keywords" content="�������å�,���ꥸ�ʥ륹�����å�,�ѡ�����,���ꥸ�ʥ�ѡ�����,�ץ���,��ʸ,���������ե�����" />

	<link rel="shortcut icon" href="/icon/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="/css/template.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="/js/ui/ui-darkness/jquery.ui.all.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="/js/modalbox/css/jquery.modalbox.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="/common/js/uniform/css/uniform.default.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="/common/css/printposition.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="./css/order.css" media="screen" />
	
	<script type="text/javascript" src="/js/jquery.js"></script>
    <script type="text/javascript" src="/js/ui/ui.core.js"></script>
    <script type="text/javascript" src="/js/ui/ui.datepicker.js"></script>
    <script type="text/javascript" src="/js/ui/i18n/ui.datepicker-ja.js"></script>
	<script type="text/javascript" src="/js/modalbox/jquery.modalbox-min.js"></script>
	<script type="text/javascript" src="/common/js/uniform/jquery.uniform.js"></script>
	<script src="http://ajaxzip3.googlecode.com/svn/trunk/ajaxzip3/ajaxzip3.js" charset="utf-8"></script>
	<script type="text/javascript" src="/js/util.js"></script>
	<script type="text/javascript" src="./js/orderform.js"></script>
	<script type="text/javascript">
		var _CART = <?php echo $_CART; ?>;
		var _UPDATED = <?php echo $_UPDATED; ?>;
		var _ITEM_ID = <?php echo $_FLG_ITEM_ID; ?>;
		var _CAT_KEY = '<?php echo $_CAT_KEY; ?>';
		var _TAX = <?php echo $tax; ?>;
		var _CREDIT_RATE = <?php echo _CREDIT_RATE; ?>;
		var _IMG_PSS = '<?php echo _IMG_PSS;?>';
	</script>
</head>
<body>
	<!-- Google Tag Manager -->
	<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-KZ5DQL"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-KZ5DQL');</script>
	<!-- End Google Tag Manager -->

	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	
	  ga('create', 'UA-11155922-6', 'auto');
	  ga('send', 'pageview');
	
	</script>

	<div class="header" id="header"><?php echo $header; ?></div>
	
	<div id="container">
		
		<?php echo $msgbar; ?>
		
		<div class="contents" style="z-index:5;">
			
			<div class="heading1_wrapper">
				<h1>���������ߥե�����</h1>
				<p class="comment">
					FAX�ǤΤ��������ߤ򤴴�˾�����ϡ�<br /><a href="/guide/sheet.php">FAX�ѥǥ������ѻ�</a>��ץ��Ȥ��������Ǥ��ޤ���
				</p>
				<img src="./img/order.png" style="margin-top:10px; border: 1px solid #efefef;">
			</div>
			
			<div id="gall">
				<div id="step1">
					<div class="heading"></div>
					<div class="crumbs_wrap">
						<div class="crumbs pass step_first">
							<p>Step1</p>
							<div>�ץ��Ȥ���<br>�����ƥ������</div>
						</div>
						<div class="crumbs">
							<p>Step2</p>
							<div>���顼��������<br>�������</div>
						</div>
						<div class="crumbs">
							<p>Step3</p>
							<div>�ץ��Ȱ���<br>�����</div>
						</div>
						<div class="crumbs">
							<p>Step4</p>
							<div><img alt="������" src="./img/cart.png" />������<br>�������</div>
						</div>
						<div class="crumbs">
							<p>Step5</p>
							<div>�����;���<br>������</div>
						</div>
						<div class="crumbs step_fin">
							<p>Step6</p>
							<div class="fin">���Ƥ��ǧ����<br>����������</div>
						</div>
					</div>
					
                    <div class="step_inner">
                        <h2><ins>Step1</ins>�ץ��Ȥ��륢���ƥ�����Ӥ�������</h2>
                        
                        <div class="category_list">
                            <h3><ins>��.</ins>���ƥ��꡼�����</h3>
                            <?php echo $category_selector; ?>
                        </div>
                        
                        <h3 id="h3_itemlist"><ins>��.</ins>�����ƥ�����򤷤Ƥ�������<span>��<?php echo count($res); ?> �����ƥ��</span></h3>
                        <div id="itemlist_wrap">
                        <?php
                            $recomend = '';
                            $ls='';
                            $tmp = array();
                            $i=0;
                            foreach($res as $code=>$v){
                                if($code=='085-cvt') $tmp[0] = array($code=>$res[$code]);
                                if($code=='5401') $tmp[1] = array($code=>$res[$code]);
                                if($code=='ss-1030') $tmp[2] = array($code=>$res[$code]);
                                
                                if($i%4==0){
                                    $firstlist = ' firstlist';
                                }else{
                                    $firstlist = '';
                                }
                                if( preg_match('/^p-/',$code) || $code=='ss-9999'){
									$suffix = '_style_0'; 
								}else{ 
									$suffix = '_'.$v['initcolor']; 
								}
                                $ls .= '<li class="listitems_ex'.$firstlist.'" id="itemid_'.$v['item_id'].'_'.$v['pos_id'].'">
                                            <ul class="maker_'.$v['maker_id'].'">
                                                <li class="point_s">'.mb_convert_encoding($v['features'],'euc-jp','utf-8').'</li>
                                                <li class="item_name_s">
                                                    <ul>
                                                        <li class="item_name_kata">'.strtoupper($code).'</li>
                                                        <li class="item_name_name">'.mb_convert_encoding($v['item_name'],'euc-jp','utf-8').'</li>
                                                    </ul>
                                                </li>
                                                <li class="item_image_s">
                                                    <img src="'._IMG_PSS.'items/'.$folder.'/'.$code.'/'.$code.$suffix.'.jpg" width="150" height="150" alt="'.strtoupper($code).'">
                                                    <img src="./img/crumbs_next.png" alt="" class="icon_arrow">
                                                </li>
                                                <li class="item_info_s">
                                                    <div class="colors">'.$v['colors'].'</div>
                                                    <div class="sizes">'.$v['sizes'].'</div>
                                                    <p class="price_s">
                                                        TAKAHAMA����<br>
                                                        <span><span>'.$v['minprice'].'</span>�ߡ�</span>
                                                    </p>
                                                </li>
                                            </ul>
                                        </li>';
                                $i++;
                            }
                            
                            if(!empty($tmp)){
                                for($i=0; $i<count($tmp); $i++){
                                    list($code, $v) = each($tmp[$i]);
                                    if($i==2) $lastli = ' lastli';
                                    $recomend .= '<li class="recitembox'.$lastli.'" id="itemid_'.$v['item_id'].'_'.$v['pos_id'].'">
                                        <img class="rankno" src="./img/no'.($i+1).'.png" width="60" height="55" alt="No1">
                                        <ul class="maker_'.$v['maker_id'].'">
                                            <li class="item_name">
                                                
                                                <p>'.mb_convert_encoding($v['features'],'euc-jp','utf-8').'</p>
                                                <ul class="popu_item_name">
                                                    <li class="item_name_kata">'.strtoupper($code).'</li>
                                                    <li class="item_name_name">'.mb_convert_encoding($v['item_name'],'euc-jp','utf-8').'</li>
                                                </ul>
                                            </li>
                                            <li class="item_image">
                                                <img src="'._IMG_PSS.'items/'.$folder.'/'.$code.'/'.$code.'_'.$v['initcolor'].'.jpg" width="250" alt="'.strtoupper($code).'">
                                                <img src="./img/crumbs_next.png" alt="" class="icon_arrow">
                                            </li>
                                            <li class="item_info clearfix">
                                                <div class="color">'.$v['colors'].'</div>
                                                <div class="size">'.$v['sizes'].'</div>
                                                <p class="price">
                                                    TAKAHAMA����<br>
                                                    <span><span>'.$v['minprice'].'</span>�ߡ�</span>
                                                </p>
                                            </li>
                                        </ul>
                                    </li>';
                                }
                                
                                echo '<ul class="recommend_item clearfix">'.$recomend.'</ul>';
                            }
                            
                            echo '<ul class="listitems clearfix">'.$ls.'</ul>';
                        ?>
                        </div>
					</div>
				</div>
				
				<div id="step2">
					<div class="heading clearfix"><p class="arrow prev"><span>���</span></p></div>
					<div class="crumbs_wrap">
						<div class="crumbs pass step_first passed">
							<p>Step1</p>
							<div>�ץ��Ȥ���<br>�����ƥ������</div>
						</div>
						<div class="crumbs pass">
							<p>Step2</p>
							<div>���顼��������<br>�������</div>
						</div>
						<div class="crumbs">
							<p>Step3</p>
							<div>�ץ��Ȱ���<br>�����</div>
						</div>
						<div class="crumbs">
							<p>Step4</p>
							<div><img alt="������" src="./img/cart.png" />������<br>�������</div>
						</div>
						<div class="crumbs">
							<p>Step5</p>
							<div>�����;���<br>������</div>
						</div>
						<div class="crumbs step_fin">
							<p>Step6</p>
							<div class="fin">���Ƥ��ǧ����<br>����������</div>
						</div>
					</div>
					<div class="step_inner">
						<h2><ins>Step2</ins>���顼�����������������ꤷ�Ƥ�������</h2>
						
						<p id="cur_item_name_wrap">�����ƥ�̾����<span id="cur_item_name" class="prop_1_1"><?php echo $itemname;?></span></p>
						
						<div class="pane">
							<h3><ins>1.</ins>�����ƥ५�顼�λ���</h3>
							<div class="thumb_wrap clearfix">
								<div class="item_thumb">
				                	<p class="thumb_h"><span>Color</span>��<span class="num_of_color"><?php echo $color_count; ?></span>��<span class="notes_color"><?php echo $curcolor; ?></span></p>
				                    <ul class="color_thumb"><?php echo $thumbs; ?></ul>
								</div>
								<div class="item_image"><?php echo $itemimage; ?></div>
							</div>
							
							<div class="sizeprice">
								<h3>
									<ins>2.</ins>������������λ��ꡡ����<span class="anchor pop_size">���������ܰ¤򸫤�</span>
								</h3>
								<table class="size_table">
								<caption></caption>
								<tbody><tr><td></td></tr></tbody></table>
								<div class="btmline">����<span class="cur_amount"><?php echo $sum; ?></span>��</div>
							</div>
						</div>
						
						<div class="btn_line">
							<span>��</span>���㤤�Υ����ƥ�����٤ޤ�
							<div id="add_item_color" class="btn_sub">�̤Υ��顼���ɲä���</div>
						</div>
						
						<div class="arrow_line"><div class="arrow prev"><span>���</span></div>
						<div class="step_next goto_position"onclick="ga('send','event','order','click','step2', 100 );">���ؿʤ�</div>���<span id="tot_amount">0</span>��</div>
					</div>
                </div>
				
				<div id="step3">
					<div class="heading clearfix"><p class="arrow prev"><span>���</span></p></div>
					<div class="crumbs_wrap">
						<div class="crumbs pass step_first passed">
							<p>Step1</p>
							<div>�ץ��Ȥ���<br>�����ƥ������</div>
						</div>
						<div class="crumbs pass passed">
							<p>Step2</p>
							<div>���顼��������<br>�������</div>
						</div>
						<div class="crumbs pass">
							<p>Step3</p>
							<div>�ץ��Ȱ���<br>�����</div>
						</div>
						<div class="crumbs">
							<p>Step4</p>
							<div><img alt="������" src="./img/cart.png" />������<br>�������</div>
						</div>
						<div class="crumbs">
							<p>Step5</p>
							<div>�����;���<br>������</div>
						</div>
						<div class="crumbs step_fin">
							<p>Step6</p>
							<div class="fin">���Ƥ��ǧ����<br>����������</div>
						</div>
					</div>
					<div class="step_inner">
						<h2><ins>Step3</ins>�ץ��Ȥ�����֤ȥǥ�����ο�������ꤷ�Ƥ�������</h2>
						
						<div>
							<p><label><input type="checkbox" name="noprint" id="noprint" value="1"> �ץ��Ȥʤ��ǹ�������</label></p>
							<p class="note"><span>��</span>�ץ��Ȥʤ��ξ��1�������ˤʤ�ޤ���</p>
						</div>
						
						<div id="pos_wrap"></div>
						
						<div class="arrow_line"><div class="arrow prev"><span>���</span></div><div class="step_next goto_cart"onclick="ga('send','event','order','click','step3', 100 );">�����Ȥ������</div></div>
                    </div>
				</div>
				
				<div id="step4">
					<div class="heading clearfix"><p class="arrow prev" rel="0"><span>�̤ξ��ʤ򸫤�</span></p></div>
					<div class="crumbs_wrap">
						<div class="crumbs pass step_first passed">
							<p>Step1</p>
							<div>�ץ��Ȥ���<br>�����ƥ������</div>
						</div>
						<div class="crumbs pass passed">
							<p>Step2</p>
							<div>���顼��������<br>�������</div>
						</div>
						<div class="crumbs pass passed">
							<p>Step3</p>
							<div>�ץ��Ȱ���<br>�����</div>
						</div>
						<div class="crumbs pass">
							<p>Step4</p>
							<div><img alt="������" src="./img/cart.png" />������<br>�������</div>
						</div>
						<div class="crumbs">
							<p>Step5</p>
							<div>�����;���<br>������</div>
						</div>
						<div class="crumbs step_fin">
							<p>Step6</p>
							<div class="fin">���Ƥ��ǧ����<br>����������</div>
						</div>
					</div>
					<div class="step_inner">
						<h2><ins>Step4</ins>������</h2>
					
						<div id="estimation_wrap">
							<table>
								<caption>�����Ѥ�</caption>
								<thead>
									<tr><th colspan="2">����̾ / ���顼</th><th>������</th><th>ñ��</th><th>���</th><th>���</th><th></th></tr>
								</thead>
								<tfoot>
									<tr><td colspan="4">�������</td><td class="ac"><ins class="totamount">0</ins> ��</td><td class="itemsum">0</td><td></td></tr>
									<tr><td colspan="2">�ץ�����</td><td colspan="3" class="printing"></td><td class="printfee">0</td><td></td></tr>
									<tr><td colspan="5">����</td><td class="carriage">0</td><td></td></tr>
									<tr><td colspan="5">��������</td><td class="codfee">0</td><td></td></tr>
									<tr><td colspan="5">�޵���</td><td class="package">0</td><td></td></tr>
									<tr><td colspan="2">���</td><td colspan="3" class="discountname"></td><td class="discountfee">0</td><td></td></tr>
									<tr><td colspan="2">�õ�����</td><td colspan="3" class="expressinfo"></td><td class="expressfee">0</td><td></td></tr>
									<tr class="foot_sub"><td colspan="5">��</td><td class="base">0</td><td></td></tr>
									<tr class="foot_sub"><td colspan="5">������</td><td class="tax">0</td><td></td></tr>
									<tr class="foot_sub"><td colspan="5">�����ɼ����</td><td class="credit">0</td><td></td></tr>
									<tr class="foot_total"><td colspan="5">�����Ѥ���</td><td class="total">0</td><td></td></tr>
									<tr class="foot_perone"><td colspan="5">1�礢����</td><td class="perone">0</td><td></td></tr>
								</tfoot>
								<tbody>
									<tr><td colspan="7"></td><td class="last"></td></tr>
								</tbody>
							</table>
							<p class="note"><span>��</span>�����Ѥ�ϳ����Ǥ����ǥ���������Ƥˤ�ä��ѹ��ˤʤ��礬�������ޤ���</p>
						</div>
						
						<div class="inner option_wrap">
							<table id="option_table">
								<caption class="highlights">���Ŭ��</caption>
								<tbody>
									<tr>
										<th>��������Ǥ���<ins>��1</ins></th>
										<td>
											<label><input type="radio" name="student" value="0" <?php if(empty($regist['options']['student'])) echo 'checked="checked"'; ?> />������</label>
											<label><input type="radio" name="student" value="3" <?php if($regist['options']['student']==3) echo 'checked="checked"'; ?> />�Ϥ�<ins>3%OFF</ins></label>
											<label><input type="radio" name="student" value="5" <?php if($regist['options']['student']==5) echo 'checked="checked"'; ?> />2���饹<ins>5%OFF</ins></label>
											<label><input type="radio" name="student" value="7" <?php if($regist['options']['student']==7) echo 'checked="checked"'; ?> />3���饹<ins>7%OFF</ins></label>
										</td>
									</tr>
									<tr>
										<th>��ӥ塼��Ǻܤ��ޤ���</th>
										<td>
											<label><input type="radio" name="blog" value="0" <?php if(empty($regist['options']['blog'])) echo 'checked="checked"'; ?> />������</label>
											<label><input type="radio" name="blog" value="3" <?php if($regist['options']['blog']==3) echo 'checked="checked"'; ?> />�Ϥ�<ins>3%OFF</ins></label>
										</td>
									</tr>
									<tr>
										<th>Illustrator�����Ƥ��ޤ���</th>
										<td>
											<label><input type="radio" name="illust" value="0" <?php if(empty($regist['options']['illust'])) echo 'checked="checked"'; ?> />������</label>
											<label><input type="radio" name="illust" value="1" <?php if($regist['options']['illust']==1) echo 'checked="checked"'; ?> />�Ϥ�<ins>1,000��OFF</ins></label>
										</td>
									</tr>
									<tr>
										<th>���ҤΤ����ͤ���Τ��Ҳ�Ǥ���<ins>��2</ins></th>
										<td>
											<label><input type="radio" name="intro" value="0" <?php if(empty($regist['options']['intro'])) echo 'checked="checked"'; ?> />������</label>
											<label><input type="radio" name="intro" value="3" <?php if($regist['options']['intro']==1) echo 'checked="checked"'; ?> />�Ϥ�<ins>3%OFF</ins></label>
										</td>
									</tr>
									<!--
									<tr>
										<th></th>
										<td><p class="note"><span>��1,��2</span>�γ���ϡ�30,000�߰ʾ太�㤤�夲�ξ���Ŭ�Ѥ���ޤ���</p></td>
									</tr>
									-->
									<tr class="separate">
										<th>�޵ͤᡡ<span class="anchor" id="pop_pack">�޵ͤ�Ȥ�</span></th>
										<td>
											<label><input type="radio" name="pack" value="0" <?php if(empty($regist['options']['pack'])) echo 'checked="checked"'; ?> />��˾���ʤ�</label>
											<label><input type="radio" name="pack" value="1" <?php if($regist['options']['pack']==1) echo 'checked="checked"'; ?> />��˾�����1�礢����50�ߡ�</label>
										</td>
									</tr>
									<tr>
										<th>����ʧ��ˡ��<span class="anchor" id="pop_payment">�����</span></th>
										<td>
											<label><input type="radio" name="payment" value="0" <?php if(empty($regist['options']['payment'])) echo 'checked="checked"'; ?> />��Կ���</label>
											<label><input type="radio" name="payment" value="2" <?php if($regist['options']['payment']==2) echo 'checked="checked"'; ?> />����ʹ���Ǽ����</label>
											<label><input type="radio" name="payment" value="1" <?php if($regist['options']['payment']==1) echo 'checked="checked"'; ?> />�������ʼ����800�ߡ�</label>
											<br>
											<label><input type="radio" name="payment" value="3" <?php if($regist['options']['payment']==3) echo 'checked="checked"'; ?> />�����ɷ�ѡʼ����5���</label>
										</td>
									</tr>
								</tbody>
							</table>
							
							<div class="line">
								<label class="title">����˾Ǽ��</label><input class="datepicker" id="deliveryday" type="text" size="14" name="deliveryday" value="<?php echo $regist['options']['deliveryday']; ?>" <?php if($regist['options']['nodeliday']==1) echo 'disabled'; ?> />
								<label><input type="checkbox" name="nodeliday" id="nodeliday" value="1" <?php if($regist['options']['nodeliday']==1) echo 'checked="checked"'; ?> > Ǽ���λ���ʤ�</label>
								<p id="express_notice"><span class="highlights">��<ins></ins></span><span class="anchor" id="pop_express">�õ�����ˤĤ���</span></p>
								<p>
									<label class="title">���ϻ����Ӥλ���</label>
				 					<select name="deliverytime" id="deliverytime">
				 					<?php
										$option = '<option value="0">---</option>
				 						<option value="1">������</option>
				 						<option value="2">12:00-14:00</option>
				 						<option value="3">14:00-16:00</option>
				 						<option value="4">16:00-18:00</option>
				 						<option value="5">18:00-20:00</option>
				 						<option value="6">20:00-21:00</option>';
										$option = str_replace('value="'.$regist['options']['deliverytime'].'"', 'value="'.$regist['options']['deliverytime'].'" selected="selected"', $option);
										echo $option;
									?>
				 					</select>
			 					</p>
							</div>
						</div>
						
						<div class="inner">
							<h3 class="heading_mark">�ǥ�����β����ե�����򤪻��������Ϥ����餫��ź�դ��Ƥ�������</h3>
							<form enctype="multipart/form-data" method="post" target="upload_iframe" action="/php_libs/orders.php" name="uploaderform" id="uploaderform">
								<input type="hidden" value="update" name="act" />
								<input type="hidden" value="attach" name="mode" />
								<input type="hidden" value="<?php echo $regist['attach'][0]['img']['name']; ?>" name="attachname[]" />
								<p><input type="file" onChange="this.form.submit()" name="attach[]" size="19" title="�ǥ�����ե��������ꤷ�Ƥ�������" /><span class="del_attach"><img src="/common/img/delete.png" alt="���">���</span></p>
								<p><span class="add_attach btn_sub">�̤�ź�եե�������ɲ�</span></p>
								<h4>�ǥ�����ˤĤ��ƤΤ���˾�ʤ�</h4>
								<textarea id="note_design" name="note_design"><?php echo $user['note_design']; ?></textarea>
							</form>
							
							<div class="chapter">
								<h4>�������Υǥ�����ʥ�ե����å��ˤǥץ��Ȥ򤴴�˾�ξ��</h4>
								<p>FAX�ǤΤ��������ߤ��Ǥ��ޤ���<a href="/contact/faxorderform.pdf" target="_blank">FAX�ѥե�����</a>��ץ��Ȥ����������Ƥ���������</p>
								<p>FAX: <?php echo _OFFICE_FAX;?></p>
							</div>
						</div>
						
						<div class="inner">
							<h3 class="heading_mark">�ץ��Ȥ���ǥ�����ο�������ޤ�����Ϥ�������������</h3>
							<p class="note">�㡡������åɡ������̢��ۥ磻��</p>
							<textarea id="note_printcolor" name="note_printcolor"><?php echo $user['note_printcolor']; ?></textarea>
						</div>
						
						<div class="inner">
							<h3 class="heading_mark">�ǥ�����ƥ�ץ졼�Ȥ����Ѥξ��</h3>
							<p class="note">�㡡���� 1</p>
							<textarea id="note_template" name="note_template"><?php echo $user['note_template']; ?></textarea>
						</div>
						
						<div class="arrow_line"><div class="arrow prev" rel="0"><span>�̤ξ��ʤ򸫤�</span></div><div class="step_next goto_user"onclick="ga('send','event','order','click','step4', 100 );">���ؿʤ�</div></div>
                    </div>
				</div>
				
				<div id="step5">
					<div class="heading clearfix"><p class="arrow prev"><span>���</span></p></div>
					<div class="crumbs_wrap">
						<div class="crumbs pass step_first passed">
							<p>Step1</p>
							<div>�ץ��Ȥ���<br>�����ƥ������</div>
						</div>
						<div class="crumbs pass passed">
							<p>Step2</p>
							<div>���顼��������<br>�������</div>
						</div>
						<div class="crumbs pass passed">
							<p>Step3</p>
							<div>�ץ��Ȱ���<br>�����</div>
						</div>
						<div class="crumbs pass passed">
							<p>Step4</p>
							<div><img alt="������" src="./img/cart.png" />������<br>�������</div>
						</div>
						<div class="crumbs pass">
							<p>Step5</p>
							<div>�����;���<br>������</div>
						</div>
						<div class="crumbs step_fin">
							<p>Step6</p>
							<div class="fin">���Ƥ��ǧ����<br>����������</div>
						</div>
					</div>
					<div class="step_inner">
						<h2><ins>Step5</ins>�����;�������Ϥ��Ƥ�������</h2>
					
						<div id="userinfo" class="clearfix">
							<p class="comment">��<span>��</span>�װ���ɬ�����ϤǤ���</p>
							
							<div id="user_wrap" class="clearfix inner">
								<div class="fl">
									<ul>
										<li>
											<label>��̾��:<span class="fontred">��</span></label>
											<input type="text" id="customername" name="customername" value="<?php echo $user['customername']; ?>" />����
										</li>
										<li>
											<label>�եꥬ��:</label><input type="text" id="ruby" name="ruby" value="<?php echo $user['ruby']; ?>">����
										</li>
										<li><label>�᡼�륢�ɥ쥹:<span class="fontred">��</span></label><input type="text" id="email" name="email" value="<?php echo $user['email']; ?>" /></li>
										<li><label>�������ֹ�:<span class="fontred">��</span></label><input type="text" id="tel" name="tel" class="forPhone"  value="<?php echo $user['tel']; ?>" /></li>
										<li><label>���Ҥ����ѤˤĤ���:<span class="fontred">��</span></label>
											<label class="lbl"><input type="radio" name="repeater" value="1" <?php if($user['repeater']==1) echo 'checked="checked"'; ?> /> ���ƤΤ�����</label>
											<label class="lbl"><input type="radio" name="repeater" value="2" <?php if($user['repeater']==2) echo 'checked="checked"'; ?> /> �����ˤ���ʸ�������Ȥ�����</label>
										</li>
									</ul>
								</div>
								<div class="fr">
									<ul>
										<li><label>������:<span class="fontred">��</span></label>
											<p>��<input type="text" name="zipcode" class="forZip" id="zipcode1" value="<?php echo $user['zipcode']; ?>" onkeyup="AjaxZip3.zip2addr(this,'','addr0','addr1');" /></p>
											<p><input type="text" name="addr0" id="addr0" value="<?php echo $user['addr0']; ?>" placeholder="��ƻ�ܸ�" maxlength="4" /></p>
											<p><input type="text" name="addr1" id="addr1" value="<?php echo $user['addr1']; ?>" placeholder="ʸ����������28ʸ����Ⱦ��56ʸ���Ǥ�" maxlength="56" class="restrict" /></p>
											<p><input type="text" name="addr2" id="addr2" value="<?php echo $user['addr2']; ?>" placeholder="ʸ����������16ʸ����Ⱦ��32ʸ���Ǥ�" maxlength="32" class="restrict" /></p>
										</li>
										<li><label>����˾��������ʤ�:</label><textarea cols="30" rows="5" name="comment"><?php echo $user['comment']; ?></textarea></li>
									</ul>
								</div>
							</div>
							
							<table class="inner">
								<tbody>
									<tr>
										<th>
											�ǥ�����ηǺܤˤĤ���:
										</th>
										<td>
											<p class="txt">���ꥸ�ʥ�ץ��Ȥ������������λ��ͤˡ����ͤΥǥ������WEB���<br>�Ǻܤ�����ĺ���Ƥ���ޤ�������������򤪴ꤤ�פ��ޤ���</p>
											<p class="line">
												<label><input type="radio" name="publish" value="0" <?php if(empty($regist['options']['publish'])) echo 'checked="checked"'; ?> /> �Ǻܲ�</label>
												<label><input type="radio" name="publish" value="1" <?php if($regist['options']['publish']==1) echo 'checked="checked"'; ?> /> �Ǻ��Բ�</label>
											</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						
						<div class="arrow_line"><div class="arrow prev"><span>���</span></div><div class="step_next goto_confirm"onclick="ga('send','event','order','click','step5', 100 );">��ǧ���̤�</div></div>
                    </div>
				</div>
				
				<div id="step6">
					<div class="heading clearfix"><p class="arrow prev"><span>���</span></p></div>
					<div class="crumbs_wrap">
						<div class="crumbs pass step_first passed">
							<p>Step1</p>
							<div>�ץ��Ȥ���<br>�����ƥ������</div>
						</div>
						<div class="crumbs pass passed">
							<p>Step2</p>
							<div>���顼��������<br>�������</div>
						</div>
						<div class="crumbs pass passed">
							<p>Step3</p>
							<div>�ץ��Ȱ���<br>�����</div>
						</div>
						<div class="crumbs pass passed">
							<p>Step4</p>
							<div><img alt="������" src="./img/cart.png" />������<br>�������</div>
						</div>
						<div class="crumbs pass passed">
							<p>Step5</p>
							<div>�����;���<br>������</div>
						</div>
						<div class="crumbs pass step_fin">
							<p>Step6</p>
							<div class="fin">���Ƥ��ǧ����<br>����������</div>
						</div>
					</div>
					
                    <div class="step_inner">
						<h2><ins>Step6</ins>�������������Ƥ򤴳�ǧ��������</h2>
						
						<form id="orderform" name="orderform" method="post" action="./ordercomplete.php" onSubmit="return false;">
						<?php
							$ticket = htmlspecialchars(md5(uniqid().mt_rand()), ENT_QUOTES);
							$_SESSION['ticket'] = $ticket;
						?>
							<input type="hidden" name="ticket" value="<?php echo $ticket; ?>">
	
							<div class="inner1">
								<table id="conf_item">
									<caption>�����ƥ�</caption>
									<thead>
										<tr>
											<th>����̾ / ���顼</th><th>������</th><th>ñ��</th><th>���</th><th>���</th>
										</tr>
									</thead>
									<tfoot>
										<tr class="foot_sub"><th colspan="4">��</th><td class="base"><ins>0</ins> ��</td><td></td></tr>
										<tr class="foot_sub"><th colspan="4">������</th><td class="tax"><ins>0</ins> ��</td><td></td></tr>
										<tr class="foot_sub"><th colspan="4">�����ɼ����</th><td class="credit"><ins>0</ins> ��</td><td></td></tr>
										<tr class="foot_total"><th colspan="4">�����Ѥ���</th><td class="tot"><ins>0</ins> ��</td></tr>
										<tr class="foot_perone"><th colspan="4">1�礢����</th><td class="per"><ins>0</ins> ��</td></tr>
									</tfoot>
									<tbody></tbody>
								</table>
							</div>
	
							<div class="inner1">
								<table id="conf_print">
									<caption>�ץ��Ⱦ���</caption>
									<thead>
										<tr>
											<th>�����ƥ�</th><th>�ץ��Ȱ���</th><th>�ץ��Ȥ���ǥ�����ο���</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
								<table id="conf_option">
									<tbody>
										<tr><th>ź�եե�����</th><td id="conf_attach"></td></tr>
										<tr><th>�ǥ����������</th><td id="conf_note_design"></td></tr>
										<tr><th>�ǥ�����ο�����</th><td id="conf_note_printcolor"></td></tr>
										<tr><th>�ƥ�ץ졼�Ȥλ���</th><td id="conf_note_template"></td></tr>
									</tbody>
								</table>
							</div>
	
							<div class="inner1">
								<table id="conf_user">
									<caption>�����;���</caption>
									<thead>
										<tr>
											<th>����</th><th>��������</th>
										</tr>
									</thead>
									<tbody>
										<tr><th>��̾��</th><td id="conf_customername"></td></tr>
										<tr><th>�եꥬ��</th><td id="conf_ruby"></td></tr>
										<tr><th>�᡼�륢�ɥ쥹</th><td id="conf_email"></td></tr>
										<tr><th>�������ֹ�</th><td id="conf_tel"></td></tr>
										<tr><th>������</th><td>��<ins id="conf_zipcode"></ins><br /><ins id="conf_addr0"></ins><ins id="conf_addr1"></ins><ind id="conf_addr2"></ind></td></tr>
										<tr><th>�ǥ�����Ǻ�</th><td id="conf_publish"></td></tr>
										<tr><th>����˾Ǽ��</th><td id="conf_deliveryday"></td></tr>
										<tr><th>���Ϥ�����</th><td id="conf_deliverytime"></td></tr>
										<tr><th>����ʧ��ˡ</th><td id="conf_payment"></td></tr>
										<tr><th>����˾��������ʤ�</th><td id="conf_comment"></td></tr>
										<tr><th>���Ҥ����ѤˤĤ���</th><td id="conf_repeater"></td></tr>
									</tbody>
								</table>
							</div>
							
							<fieldset class="sendorder_wrap">
								<legend class="highlights">������</legend>
								<div class="inner">
									<h3>��ջ���</h3>
									<p>
										����򳫻Ϥ���ˤ����ꡢ�����äˤ��ǥ�����γ�ǧ�򤵤��Ƥ��������Ƥ���ޤ���<br>
										���Ҥ�ꤪ���ꤹ��渫�Ѥ�᡼��򤴳�ǧ�����������塢
										�ե꡼�������<ins class="highlights"><?php echo _TOLL_FREE;?></ins>�ޤǤ����ä���������
										��ʿ��10:00-18:00��
									</p>
									<img src="./img/order_6.png" width="652" style="margin-top:10px; border:1px solid #efefef;">
								</div>
								<p><input type="checkbox" value="1" name="agree" id="agree"><label for="agree">��ǧ���ޤ���</label></p>
									
								<div>
									<p class="pointer">�����å���</p>
									<div id="sendorder" class="disable_button"onclick="ga('send','event','order','click','step6', 100 );">��ʸ����</div>
								</div>
							</fieldset>
							
							<div class="arrow_line"><div class="arrow prev"><span>���</span></div></div>
						</form>	
                    
					</div>
				</div>
			</div>
		
		</div>
		
		<div id="floatingbox">
			<table>
				<caption>�����Ѥ�</caption>
				<tbody>
					<tr><th>�������</th><td><span><?php echo number_format($data['amount']); ?></span>��</td></tr>
					<tr class="total"><th>��׶��</th><td><span><?php echo number_format($total); ?></span>��</td></tr>
					<tr><th>1�礢����</th><td><span><?php echo number_format($perone); ?></span>��</td></tr>
				</tbody>
			</table>
			<div class="btn_sub viewcart"><img alt="������" src="./img/cart.png" />�����Ȥ򸫤�</div>
		</div>
		
	</div>
	
	<p class="page_top"><span>���������ߥե����ࡡ�ڡ����ȥåפ�</span></p>

	<div class="footer"><?php echo $footer; ?></div>
	
	<iframe name="upload_iframe" style="display: none;"></iframe>

	<script type="text/javascript">
	  (function () {
		var tagjs = document.createElement("script");
		var s = document.getElementsByTagName("script")[0];
		tagjs.async = true;
		tagjs.src = "//s.yjtag.jp/tag.js#site=gfjjZ2r";
		s.parentNode.insertBefore(tagjs, s);
	  }());
	</script>
	<noscript>
	  <iframe src="//b.yjtag.jp/iframe?c=gfjjZ2r" width="1" height="1" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
	</noscript>

</body>
</html>
