<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/../app-def/initcontents2.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/../app-def/deliveryCounter.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/../app-def/iteminfo.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/../app-def/measure.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/../app-def/sendmail_multi.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/../cgi-bin/conndb.php';
	$conn = new Conndb();
	
	// ���ƥ���
	$item_category_name = '�ѡ��������������å�';
	$item_category = array(
		'�ѡ��������������å�',
		'�ȥ졼�ʡ�',
		'�������åȥѥ��',
		'T�����',
		'�֥륾��',
	);
	if(isset($_REQUEST['c'])){
		$item_category_name = $item_category[$_REQUEST['c']];
	}
	
	if(isset($_REQUEST['item_id'])){
		$item_id = $_REQUEST['item_id'];
	}else{
		$item_id = 124;
	}
	$itemdata = $iteminfo[$item_id];
	$rs = $conn->sjTablelist('item', $item_id);
	if(isset($_REQUEST['color_code'])){
		$color_code = $_REQUEST['color_code'];
	}else{
		$color_code = $rs[0]['i_color_code'];
	}
	
	// maker
	$maker_id = $rs[0]['maker_id'];
	
	/* ��ʸ�ؿʤ�ܥ������ʸ�ڡ������Ϥ��ѿ�
	$order_param = array();
	parse_str($_SERVER['QUERY_STRING'], $order_param);
	*/
	
	// item information
	$price = $conn->sjItemPrice($item_id, 0, 1, 1);
	$itemname = mb_convert_encoding($rs[0]['item_name'],'euc-jp','utf-8');
	$itemcode = $rs[0]['item_code'];
	switch($_REQUEST['c']){
		case '0':
		case '1':
		case '2':
			$imgPath = _IMG_PSS.'items/sweat/';
			$categorykey = 'sweat';
			break;
		case '3':
			$imgPath = _IMG_PSS.'items/t-shirts/';
			$categorykey = 't-shirts';
			break;
		case '4':
			$imgPath = _IMG_PSS.'items/outer/';
			$categorykey = 'outer';
			break;
	}
	
	$img_src = $itemcode.'/'.$itemcode.'_'.$color_code.'.jpg';
	$zoom_src = $itemcode.'/'.$itemcode.'_'.$color_code.'.jpg';
	$oz = $rs[0]['oz'];
	$material = mb_convert_encoding($rs[0]['i_material'],'euc-jp','utf-8');
	$description = mb_convert_encoding($rs[0]['i_description'],'euc-jp','utf-8');
	
	// measure image path
	$measure_src = '/img/lineup/parker_300_210.png';
	$measure_img = array(
		'/img/lineup/parker_300_210.png',
		'/img/lineup/trainer_300_210.png',
		'/img/lineup/pants_300_210_pocket.png',
		'/img/lineup/trainer_300_210.png',
		'/img/lineup/trainer_300_210.png'
	);
	if(isset($_REQUEST['c'])){
		if($_REQUEST['c']==5 && $item_id==551){
			// Champion chmp-f1049
			$measure_src = '/img/lineup/trainer_300_210.png';
		}else if($_REQUEST['c']==2 && ($item_id==181 || $item_id==251)){
			$measure_src = '/img/lineup/shorts_300_210_pocket.png';
		}else{
			$measure_src = $measure_img[$_REQUEST['c']];
		}
	}

	// item color slider
	$itemcolor_count = count($rs);
	for($i=0; $i<$itemcolor_count; $i++){
		$color_name = mb_convert_encoding($rs[$i]['color_name'],'euc-jp','utf-8');
		$sliderlist .= '<li class="c'.$rs[$i]['color_code'].'"><div class="wrapper">';
		$sliderlist .= '<div><img alt="'.$color_name.'" src="'.$imgPath.$itemcode.'/'.$itemcode.'_'.$rs[$i]['color_code'].'_s.jpg" width="18"></div>';
		$sliderlist .= '<div class="checkcolor_wrapper"><img alt="'.$color_name.'" src="../img/slideviewer/check-multi.gif" class="check';
		if($rs[$i]['color_code']==$color_code){
			$sliderlist .= ' current" style="top:-65px;';
			$current_color_name = $color_name;
		}
		$sliderlist .= '" /></div></div></li>';
	}

	// thumbnails �ʥ����������̾�Ͼ��ʥ�����_style_ɽ�����֡�
	$filename = $conn->getStylePhoto($categorykey, $itemcode);
	for ($i=0; $i < count($filename); $i++) {
		$tmp[] = $imgPath.$itemcode.'/'.$filename[$i];
	}
	$thumb = '<div class="thumb_size"><div><img id="item_colors_thumb" alt="item colors" src="'.$imgPath.$img_src.'" width="59" class="thumbs" /><p class="check_wrapper"><img alt="" src="../img/slideviewer/check-multi.gif" class="check current" style="top: -65px;" /></p></div></div>';
	foreach($tmp as $key=>$val){
		$thumb .= '<div class="thumb_size"><div><img alt="" src="'.$val.'" width="59" class="thumbs" /><p class="check_wrapper"><img alt="" src="../img/slideviewer/check-multi.gif" class="check" /></p></div></div>';
	}
	$mod = 4-(count($tmp)+1)%4;
	if($mod<4){
		for($i=0; $i<$mod; $i++){
			$thumb .= '<div class="thumb_size"></div>';
		}
	}
	
	// size table
	$itemMeasure = $conn->getItemMeasure($itemcode);
	$len = count($itemMeasure);
	$curMeasure = $itemMeasure[0]["measure_id"];
	$tblType = array();
	$tblHead = "<tr><td>SIZE</td>";
	for($i=0; $i < $len; $i++){
		$tblType[] = $itemMeasure[$i];
		if($itemMeasure[$i]["measure_id"]==$curMeasure){
			$tblHead .= "<td>".$itemMeasure[$i]["size_name"]."</td>";
		}
	}
	$itemsize_table = "";
	$tblHash = '';
	$curMeasure = 0;
	$preDimension = "";
	$col_number = 1;
	$col = 0;
	$len = count($tblType);
	for($i=0; $i<$len; $i++){
		if(empty($tblHash)){
			$tblHash .= '<table class="mytable"><tbody>'.$tblHead.="</tr>";
		}
		if($tblType[$i]["measure_id"]!=$curMeasure){
			if($curMeasure!=0){
				if($col==1){
					$tblHash .= '<td>';
				}else{
					$tblHash .= '<td colspan="'.$col.'">';
				}
				$tblHash .= $preDimension.'</td>';
				$col = 0;
				$col_number = 1;
				$preDimension = "";
				$tblHash .= "</tr>";
			}
			$tblHash .= "<tr><td>".mb_convert_encoding($tblType[$i]["measure_name"],'euc-jp','utf-8')."</td>";
			$curMeasure = $tblType[$i]["measure_id"];
		}
		if($preDimension!="" && $preDimension!=$tblType[$i]["dimension"]){
			if($col==1){
				$tblHash .= '<td>';
			}else{
				$tblHash .= '<td colspan="'.$col.'">';
			}
			$tblHash .= mb_convert_encoding($preDimension,'euc-jp','utf-8').'</td>';
			$col = 1;
			$preDimension = $tblType[$i]["dimension"];
		}else{
			$col++;
			$preDimension = $tblType[$i]["dimension"];
		}
		$col_number++;
	}
	if($col==1){
		$tblHash .= '<td>';
	}else{
		$tblHash .= '<td colspan="'.$col.'">';
	}
	$tblHash .= mb_convert_encoding($preDimension,'euc-jp','utf-8').'</td>';
	$itemsize_table .= $tblHash.'</tr></tbody>';
	$itemsize_table .= '<tfoot><tr><td colspan="'.$col_number.'">cm</td></tr></tfoot>';
	$itemsize_table .= '</table>';
	
	// ���������Ȥβ��ʤȥ᡼�������ʡ��������
	$size = $conn->sjTablelist('itemsize', $item_id, $color_code);
	$p = 0;
	$count = count($size);
	for($t=0; $t<$count; $t++){
		if($t==0){
			$price_list[$p]['size_from'] = strtoupper($size[$t]['size_name']);
			$price_list[$p]['size_to'] = "";
			$price_list[$p]['price_color'] = $size[$t]['price_color'];
			$price_list[$p]['price_white'] = $size[$t]['price_white'];
			$price_list[$p]['price_color_maker'] = $size[$t]['price_color_maker'];
			$price_list[$p]['price_white_maker'] = $size[$t]['price_white_maker'];
			$ratio_from = 100-round(($size[$t]['price_white']*100) / $size[$t]['price_white_maker']);
			$ratio_to = $ratio_from;
		}else{
			if($price_list[$p]['price_color'] != $size[$t]['price_color']){
				$p++;
				$price_list[$p]['size_from'] = strtoupper($size[$t]['size_name']);
				$price_list[$p]['size_to'] = "";
				$price_list[$p]['price_color'] = $size[$t]['price_color'];
				$price_list[$p]['price_white'] = $size[$t]['price_white'];
				$price_list[$p]['price_color_maker'] = $size[$t]['price_color_maker'];
				$price_list[$p]['price_white_maker'] = $size[$t]['price_white_maker'];
				$tmp = 100-round(($size[$t]['price_white']*100) / $size[$t]['price_white_maker']);
				if($tmp<$ratio_from){
					$ratio_from = $tmp;
				}else if($tmp>$ratio_to){
					$ratio_to = $tmp;
				}
			}else{
				$price_list[$p]['size_to'] = '-'.strtoupper($size[$t]['size_name']);
			}
		}
	}
	if($ratio_from!=$ratio_to){
		$discount_ratio = $ratio_from.'��'.$ratio_to;
	}else{
		$discount_ratio = $ratio_from;
	}


	/*
	*	��ӥ塼�����ޡ���
	*	ɾ����0.5ñ�̤��Ѵ��������ѥ����֤�
	*/
	function getStar($args){
		if($args<0.5){
			$r = 'star00';
		}else if($args>=0.5 && $args<1){
			$r = 'star05';
		}else if($args>=1 && $args<1.5){
			$r = 'star10';
		}else if($args>=1.5 && $args<2){
			$r = 'star15';
		}else if($args>=2 && $args<2.5){
			$r = 'star20';
		}else if($args>=2.5 && $args<3){
			$r = 'star25';
		}else if($args>=3 && $args<3.5){
			$r = 'star30';
		}else if($args>=3.5 && $args<4){
			$r = 'star35';
		}else if($args>=4 && $args<4.5){
			$r = 'star40';
		}else if($args>=4.5 && $args<5){
			$r = 'star45';
		}else{
			$r = 'star50';
		}
		return $r;
	}


	// �����ƥ��ӥ塼
	$review = '';
	$itemreview = '';
	$review_data = $conn->getItemReview(array('sort'=>'post', 'itemid'=>$item_id));
	$review_len = count($review_data);
	if($review_len>0){
		if($review_len>2){
			$end = 2;	// ��ӥ塼��2��ޤ�ɽ��
		}else{
			$end = $review_len;
		}
		$review_list = '';
		for($i=0; $i<$end; $i++){
			$star = getStar($review_data[$i]['vote']);
			$review_text = $review_data[$i]['review'];
			$review_text = nl2br(mb_convert_encoding($review_text, 'euc-jp', 'utf-8'));
			$review_list .= '<div class="unit_body">';
				$review_list .= '<p><img src="/itemreviews/img/'.$star.'.png" width="114" height="21" alt=""><ins>'.$review_data[$i]['vote'].'</ins></p>';
				$review_list .= '<p>'.$review_text.'</p>';
			$review_list .= '</div>';
		}
		$itemreview = '<h2 id="review_side">�����ƥ��ӥ塼</h2>';
		$itemreview .= $review_list;
		//$itemreview .= '<p class="tor"><a href="/itemreviews/index.php?item='.$data['itemid'].'">��äȸ����'.$review_len.'���</a></p>';
	}
	
	
	/* �岼���åȤ��оݾ���
	$setup = $conn->sjItemInfo(99);  
	if(!empty($itemdata['setup'])){
		$setuper = '<h2 class="features">���åȾ���</h2><div class="inner">';
		for($i=0; $i<count($itemdata['setup']); $i++){
			$set_id = $itemdata['setup'][$i];
			if(empty($setup[$set_id])) continue;
			$setuper .= '<div class="box clearfix"><img alt="���åȾ���" src="../img/lineup/tag_setup.png" class="lblSetup" />';
			$setuper .= '<p class="note">�����ξ��ʤȥ��åȤǹ����Ǥ��ޤ���</p>';
			$setuper .= '<h3>'.mb_convert_encoding($setup[$set_id]['item_name'],'euc-jp','utf-8').'</h3>';
	 		$setuper .= '<p class="price">&yen; '.number_format($setup[$set_id]['price_1']).' ��</p>';
			$setuper .= '<img class="thumb" alt="�岼���å�" width="200" src="'.$imgPath.$setup[$set_id]['item_code'].'/'.$setup[$set_id]['item_code'].'_'.$setup[$set_id]['i_color_code'].'.jpg" />';
		 	$setuper .= '<p><a href="./detail_item.php?item_id='.$set_id.'">�ܺ٤Ϥ�����</a></p>';
		 	$setuper .= '</div>';
		}
	}
	*/
	
	// ȯ��ͽ�����Υϥå���
	$fin = DeliveryCounter::counter();
		
	// �ߤ�ʤ˥᡼��
	if(isset($_POST['multimail'])){
		// �᡼������
		$prm = array("���֡�����̾","ñ��","��������");
		$subject = $_POST['subject'];
		$mail_msg = "�������������������ڡ�".$subject."���ۨ�����������������\n\n";
		$mail_msg .= "���Τ��Ӥϡ��������åȥ���å������Ѥ����������ˤ��꤬�Ȥ��������ޤ���\n";
		$mail_msg .= $_POST['myname']." �ͤ���θ渫�Ѥ�Τ��Τ餻�Ǥ���\n\n";

		$mail_msg .= "����������������������\n";
		$mail_msg .= "�������渫�Ѥ�����\n";
		$mail_msg .= "����������������������\n";
		$mail_msg .= "��ȯ����������������ʸ��".$fin['Year']."ǯ".$fin['Month']."��".$fin['Day']."����ȯ���Ǥ���\n";
		for($i=0; $i<count($prm); $i++){
			$mail_msg .= "��".$prm[$i]."����".$_POST['param'][$i]."\n";
		}
		$mail_msg .= "������������������������������������������\n\n";
		$mail_msg .= "��������������������\n";
		$mail_msg .= "��������å�����\n";
		$mail_msg .= "��������������������\n";
		$mail_msg .= $_POST['message']."\n";
		$mail_msg .= "������������������������������������������\n\n";
		$mail_msg .= "���Υ������åȤμ̿���".substr(_DOMAIN,0,-1).$_SERVER['SCRIPT_NAME'].'?'.$_SERVER['QUERY_STRING']."\n";

		for($i=0; $i<count($_POST['email']); $i++){
			if(!empty($_POST['email'][$i])) $emails[] = $_POST['email'][$i];
		}
		$fromname = $_POST['myname'];
		$fromaddr = $_POST['myemail'];
		$result = send_mail_multi($mail_msg,$subject,$emails,$fromname,$fromaddr);
		$boundary = substr(md5(uniqid(rand())),0,10);
		$res = $boundary.implode($boundary, $result);
	}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="euc-jp" />
    <title><?php echo $itemname.' �� ���ꥸ�ʥ�ѡ������Υ������åȥ���å�'; ?></title>
    <meta name="description" content="<?php echo $itemname;?>�ξܺ٥ڡ����Ǥ���1������̤Υץ��Ȥޤǡ����ꥸ�ʥ�ѡ��������������åȤκ������ץ��Ȥϡ�����Υ������åȥ���å��ء����󥹥�����������०�����ʤɤ����Ѥ���ʸ���ס��ΰ�פΥ��٥�Ȥ�������Ǥ���" />
    <meta name="keywords" content="�ѡ�����,���åץѡ�����,���ꥸ�ʥ�ѡ�����,�������å�,�������åȥѥ��,����,�ץ���,���,¨��,��û" />
<!--m2 begin-->
	<meta name="viewport" content="width=device-width,user-scalable=no,maximum-scale=1" />
<!--m2 end--> 
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <meta http-equiv="Content-Script-Type" content="text/javascript" />
    <link rel="shortcut icon" href="/icon/favicon.ico" />
<link rel='stylesheet' id='contact-form-7-css'  href='../css/header-footer_responsive.css' type='text/css' media='all' />
    <link rel="stylesheet" type="text/css" media="screen" href="../css/template1_responsive.css" />

    <link rel="stylesheet" type="text/css" media="screen" href="../js/modalbox/css/jquery.modalbox.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../js/cloud-zoom/cloud-zoom.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../css/detail1_responsive.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../popup/css/mailform_responsive.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../popup/css/printform_responsive.css" />

<!--m2 begin-->
    <link rel="stylesheet" type="text/css" href="/m2/common/css/common1_responsive.css" media="all">
<!--m2 end--> 
    <script type="text/javascript" src="../js/jquery.js"></script>
    <script type="text/javascript" src="../js/modalbox/jquery.modalbox-min.js"></script>
    <script type="text/javascript" src="../js/cloud-zoom/cloud-zoom.js"></script>
    <script type="text/javascript" src="../js/util.js"></script>
    <script type="text/javascript" src="../js/detail.js"></script>
    <script type="text/javascript">
        $.currentitem['color_code'] = "<?php echo $color_code;?>";
        $.currentitem['color_name'] = "<?php echo $current_color_name;?>";
        var _res_mail = "<?php echo $res; ?>";
        var _maker_id = "<?php echo $maker_id; ?>";
    </script>

	<script type="text/javascript">
		jQuery(function($) {
		  
		var nav    = $('#fixedBox'),
		    offset = nav.offset();
		  
		$(window).scroll(function () {
		  if($(window).scrollTop() > offset.top) {
		    nav.addClass('fixed');
		  } else {
		    nav.removeClass('fixed');
		  }
		});
		  
		});
	</script>

	<style>

		.fixed {
		    position: fixed;
		    top: 0;
		    width: 100%;
		    z-index: 10000;
		}

	</style>


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

<div id="wrapper-all">
		<header class="site-header"><?php echo $header; ?>			

				
			<div  id="fixedBox" class="nav">
				<nav id="global-navigation"><?php echo $menu; ?></nav>	
			</div>
</header>
<!-- m2 begin-->
<div id="m2_header">
<h1>���ꥸ�ʥ륢���ƥ�ץ��ȡ�������</h1>
<?php 
		$php = file_get_contents($_SERVER['DOCUMENT_ROOT']."/m2/common/inc/headinc1.html");
		eval('?>'. mb_convert_encoding($php, 'euc-jp', 'UTF-8'). '<?');
?>

<nav id="global-navigation"><?php 
		$php = file_get_contents($_SERVER['DOCUMENT_ROOT']."/m2/common/inc/gnav1.html");
		eval('?>'. mb_convert_encoding($php, 'euc-jp', 'UTF-8'). '<?');
?></nav>
</div>
<!-- m2 end-->	
	<div class="container">

		<div class="contents">
			
			<?php echo $msgbar; ?>

			<div class="summary">
				<h2><?php echo $itemname; ?></h2>
				<p class="features">
				<?php 
					echo mb_convert_encoding($rs[0]['i_caption'],'euc-jp','utf-8');
					if($item_category_name=='�����ԥ���'){
						echo '<ins class="fontred">������ȯ��Τ���߸ˤ�Ǽ�����׳�ǧ</ins>';
					}
				?>
				</p>
			</div>
			
			<div class="right_wrapper">
				
				<p>���ʥ����ɡ� <?php echo $itemcode; ?></p>
				
				<div class="full_size">

					<div class="itemview">
						<a href="<?php echo $imgPath.$zoom_src;?>" class="cloud-zoom" id="zoom1" rel="position:'inside', adjustX:-4, adjustY:-4">
							<img alt="" src="<?php echo $imgPath.$img_src;?>" width="100%" id="itemimage" title="<?php echo $itemname; ?>" />
						</a>
					</div>

					<div class="slideviewer item_color_slider" id="slider1">
						<div class="back_slider"></div>
						<div class="next_slider"></div>
						<div class="slider_wrapper">
							<ul><?php echo $sliderlist; ?></ul>
						</div>
					</div>

					<div class="color_text">���顼�� <span id="current_color_name"><?php echo $current_color_name; ?></span></div>

				</div>

				<div class="clearfix">
					<?php echo $thumb; ?>
				</div>
			</div>

			<div class="left_wrapper">

				<div class="price_wrapper">
					<h2 class="features">����</h2>
					<div class="clearfix inner">
						<div class="fl">
							<?php
								$maker_price = array();		// �᡼����������
								$selling_price = array();;	// �������
								$price = '<table><tbody>';
								for($i=0; $i<count($price_list); $i++){
									$off_white = $price_list[$i]['price_white_maker'] - $price_list[$i]['price_white'];
									$off_color = $price_list[$i]['price_color_maker'] - $price_list[$i]['price_color'];
									
									if($price_list[$i]['price_white']!=$price_list[$i]['price_color']){
										$price .= '<tr><td>'.$price_list[$i]['size_from'].$price_list[$i]['size_to'].'</td><td> : (�ۥ磻��) </td>';
										$price .= '<td class="fontred">&yen;'.number_format($price_list[$i]['price_white']).' </td>';
										$price .= '<td>(���顼)</td><td class="fontred">&yen;'.number_format($price_list[$i]['price_color']).' </td>';
									}else{
										$price .= '<tr><td>'.$price_list[$i]['size_from'].$price_list[$i]['size_to'].'</td><td> : </td>';
										$price .= '<td class="fontred">&yen;'.number_format($price_list[$i]['price_color']).' </td>';
									}
									
									if($price_list[$i]['price_white']!=$price_list[$i]['price_color']){
										if($i==0){
											$maker_price[0] = $price_list[$i]['price_white_maker'];
											$selling_price[0] = $price_list[$i]['price_white'];
										}
										$maker_price[1] = $price_list[$i]['price_color_maker'];
										$selling_price[1] = $price_list[$i]['price_color'];
									
									}else{
										if($i==0){
											$maker_price[0] = $price_list[$i]['price_color_maker'];
											$selling_price[0] = $price_list[$i]['price_color'];
										}
										$maker_price[1] = $price_list[$i]['price_color_maker'];
										$selling_price[1] = $price_list[$i]['price_color'];
									}
								}
								
								// �᡼����������
								if($maker_price[0]==$maker_price[1]){
									$maker_price[3] = '&yen;'.number_format($maker_price[0]);
								}else{
									$maker_price[3] = '&yen;'.number_format($maker_price[0]).' �� &yen;'.number_format($maker_price[1]);
								}
								
								// ���������
								if($selling_price[0]==$selling_price[1]){
									$selling_price[3] = '&yen;'.number_format($selling_price[0]);
								}else{
									$selling_price[3] = '&yen;'.number_format($selling_price[0]).' �� &yen;'.number_format($selling_price[1]);
								}
								
								$price .= '<tr><td colspan="3"><a class="f2" href="#sizetable">������ɽ�򸫤�</a></td></tr>';
								$price .= '</tbody></table>';
								
								
								echo '<p class="maker_price">�᡼�������ʡ�<ins>'.$maker_price[3].'</ins></p>';
								echo '<p class="selling_price">Web���ʡ�<ins>'.$selling_price[3].'</ins></p>';
								echo $price;
							?>
							<h2 class="features">���顼</h2>
							<div class="txt">
								<ins><?php echo $itemcolor_count; ?></ins> ��
							</div>
							
							<h2 class="features">����</h2>
							<div class="txt">
								<p class="oz"><a href="#oz_introduction"><?php echo $oz?>����</a></p>
								<br>
								<?php
									if(!empty($itemdata['cloth']['weave'])){
										echo '<p class="weave"><a href="#weave_introduction">'.$itemdata['cloth']['weave'].'</a></p>';
									}
								?>
							</div>
							
						</div>
						
						<div class="discount">
							<div>
							<?php 
								echo '<p>����'.$item_category_name.'��<br>�᡼�������ʤ�<br><span><ins>'.$discount_ratio.'</ins>% <ins>OFF</ins></span><br>�Ǥ���</p>';
							?>
							</div>
							<div id="pcpage" class="send_mail"></div>
							<div id="pcpage" class="print_out"></div>
						</div>
						
						<div class="btn_wrap to_order">
							<form action="../order/index1.php?<?php echo $_SERVER['QUERY_STRING']; ?>" method="post" onSubmit="return false">
								<div class="order_button"></div>
							</form>
							<p class="note"><span>��</span>̵�ϤǤι��������⤳�����</p>
						</div>
					</div>
					
					<h2 class="features">�Ǻ�</h2>
					<div class="txt">
						<?php echo $material; ?>
					</div>
					
				</div>

				<div class="desc">
					<h2 class="features">�ݥ����</h2>
					<div class="txt">
						<!--<img alt="" src="/img/lineup/icon_boss.png" />-->
						<?php echo $description; ?>
					</div>
					<div class="try_on">
						<?php
							echo $itemreview;
						?>
					</div>
				</div>
				
				<div class="desc" id="oz_introduction">
					<h2 class="features">����(oz.)</h2>
							<p style="line-height:1.6;">�֥��󥹡�oz.�ˡפȤϡ����ϤνŤ���ɽ��ñ�̤Τ��ȤǤ���<br>
							���Ϥθ����ϡɣ��䡼�ɡߣ��䡼��ñ�����ѡɤνŤ���ɥ��󥹡ɤ�ɽ���Ƥ��ޤ������ο��ͤ��礭���ʤ�ۤɽŤ��ʤꡢ���Ϥϸ����ʤ�ޤ���<br>
							���ꥸ�ʥ�ѡ��������������åȤ����Ӻݤ��ܰ¤Ȥ��Ƥ��Ȥ�����������</p>
							<br><img src="/img/lineup/oz.png" width="80%">
				</div>
					<?php
						if(!empty($itemdata['cloth']['weave'])){
								$txt = "";
								if($itemdata['cloth']['weave']=="�ѥ���"){
									$txt = '<div class="desc" id="weave_introduction">';
									$txt .= '<h2 class="features">�ѥ����΢�ӡ�</h2>';
									$txt .= '<img src="/img/lineup/pairu.jpg" style="float:right; margin-left:20px;">';
									$txt .= '<p style="line-height:1.6;">�֥ѥ���פȤϡ�����ɽ�̤˻夬�ؤä��ˤʤäƽФ�褦���Ԥޤ�Ƥ������ϤǤ���<br>';
									$txt .= '�ꤶ���ϥ������ȥ졼�ʡ���΢�Ϥδ����ΤǤ���';
									$txt .= '�ѥ��뤬��֤��������ޤि�ᡢ�դ��ꡢ�٥��äȤ��ʤ���Ŭ���忴�Ϥ�Ϳ���Ƥ���ޤ���<Br>';
									$txt .= '���ꥸ�ʥ�ѡ��������������åȤ����Ӻݤ��ܰ¤Ȥ��Ƥ��Ȥ�����������</p>';
									$txt .= '</div>';
								}else{
									$txt = '<div class="desc" id="oz_introduction">';
									$txt .= '<h2 class="features">΢����</h2>';
									$txt .= '<img src="/img/lineup/urakimou.jpg" style="float:right; margin-left:20px;">';
									$txt .= '<p style="line-height:1.6;">��΢���ӡפȤϡ��ѥ������ʪ��ɽ�̤���ä������ӱ�Ω������ʪ�Ǥ���';
									$txt .= '����ӱ�Ω�����뤳�Ȥǡ��⤳�⤳���������ˤʤꡢ �դ�����餫���������ߤ���꿨��ǡ����ϤΥܥ�塼�ശ������ޤ���<br>';
									$txt .= '���ꥸ�ʥ�ѡ��������������åȤ����Ӻݤ��ܰ¤Ȥ��Ƥ��Ȥ�����������</p>';
									$txt .= '</div>';
								}
							echo $txt;
						}
					?>

				<div class="size_tbl" id="sizetable">
					<h2 class="features">������ɽ</h2>
					<p id="show_measure"><span>��ˡ��¬�����򸫤Ƥߤ� <img alt="����ǳ����ޤ�" src="/img/icon_question.png" /></span></p>
					<?php echo $itemsize_table; ?>
				</div>
			
			</div>
			
			<div class="setup_wrap">
				<?php echo $setuper;?>
				<div class="btn_wrap">
					<form action="../order/index1.php?<?php echo $_SERVER['QUERY_STRING']; ?>" method="post" onSubmit="return false">
						<div class="order_button"></div>
					</form>
					<p class="note"><span>��</span>̵�ϤǤι��������⤳�����</p>
				</div>
			</div>

			<p class="page_top"><span><?php echo $itemname; ?>���ڡ����ȥåפ�</span></p>

		</div><!-- /contents -->

	</div>

	<div id="measure">
		<div class="img_wrapper">
			<img alt="��ˡ" src="<?php echo $measure_src; ?>" />
		</div>
		<table class="mytable">
			<thead>
				<tr><th>��ˡ</th><th>��ˡ��¬����</th></tr>
			</thead>
			<tbody>
			<?php
				if($_REQUEST['c']==2){
					echo '<tr>
						<th><span class="fontred">1.</span>���</th><td>�������ľ�ü���Ƥ�˥���ܤˤ��äƿ��ޤ�</td>
					</tr>
					<tr>
						<th><span class="fontred">2.</span>��������</th><td>�������ľ�ü���ʿ��ü��ü�ޤ�</td>
					</tr>
					<tr>
						<th><span class="fontred">3.</span>�Բ�</th><td>�Ԥ�˥���ܤθ򺹡����ޤ�</td>
					</tr>
					<tr>
						<th><span class="fontred">4.</span>�Ծ�</th><td>�Ԥ�˥���ܤθ򺹡��������ľ�ü�ޤ�</td>
					</tr>';
				}else{
					echo '<tr>
						<th><span class="fontred">1.</span>�Ⱦ�</th><td>���������դ����Ꮅ���ޤ�</td>
					</tr>
					<tr>
						<th><span class="fontred">2.</span>�ȶ�</th><td>�������Ƥ���1.0cm�����ä���</td>
					</tr>
					<tr>
						<th><span class="fontred">3.</span>����</th><td>�����θ����դ����Ꮅ�դ����ޤ�</td>
					</tr>
					<tr>
						<th><span class="fontred">4.</span>µ��</th><td>�����դ����Ꮅµ��ޤ�</td>
					</tr>';
				}
			?>
			</tbody>
		</table>
	</div>
	
	<div id="mailform_contents">

		<form id="mailform" name="orderform" action="<?php echo $_SERVER['SCRIPT_NAME'].'?'.$_SERVER['QUERY_STRING']; ?>" method="post" onSubmit="return false">

			<div class="inner">
				<h2>���θ渫�Ѥ��᡼��Ǥ��ޤ������٤ˣ��ͤޤ������Ǥ��ޤ���</h2>
				<div class="half_l">
					<p><label>�᡼��1<input type="text" name="email[]" value="" class="email" /></label></p>
					<p><label>�᡼��2<input type="text" name="email[]" value="" class="email" /></label></p>
					<p><label>�᡼��3<input type="text" name="email[]" value="" class="email" /></label></p>
				</div>

				<div class="half_r">
					<p><label>�᡼��4<input type="text" name="email[]" value="" class="email" /></label></p>
					<p><label>�᡼��5<input type="text" name="email[]" value="" class="email" /></label></p>
					<p><label>�᡼��6<input type="text" name="email[]" value="" class="email" /></label></p>
				</div>
			</div>

			<div class="inner">
				<h2>������</h2>
				<div class="box_l">
					<p>��̾��<span class="fontred">��</span></p>
					<p>�᡼�륢�ɥ쥹<span class="fontred">��</span></p>
					<p>�����ȥ�ʷ�̾��</p>
				</div>
				<div class="box_r">
					<p><input type="text" name="myname" value="" /></p>
					<p><input type="text" name="myemail" value="" class="email" /></p>
					<p><input type="text" name="subject" value="" /></p>
				</div>
			</div>

			<div class="inner">
				<h2>�᡼�������</h2>
				<div class="box_l">
					<p>��å�����</p>
				</div>
				<div class="box_r">
					<div class="wrap"><textarea rows="5" cols="50" name="message"></textarea></div>
				</div>

				<table id="mail_text">
				<tbody>
					<tr><th>ȯ����</th><td><?php echo "��������ʸ�� ".$fin['Year']."ǯ".$fin['Month']."��".$fin['Day']."����ȯ���Ǥ���"; ?></td></tr>
					<tr><th>���֡�����̾</th><td><?php echo $itemcode." ".$itemname; ?></td></tr>
					<tr><th>ñ��</th>
						<td>
						<?php
							$price = $price_list[0]['price_white'];
							$maker = $price_list[0]['price_white_maker'];
							$ratio = 100-round(($price*100)/$maker);
							$discount = $maker-$price;
							echo "��".number_format($price)."  ��".$ratio."�� �ʡ�".number_format($discount)."��OFF��";
						?>
						</td>
					</tr>
					<tr><td colspan="2"><?php echo $description; ?></td></tr>
				</tbody>
				</table>
			</div>

			<p class="comment">
				���Υ������åȤμ̿���<?php echo substr(_DOMAIN,0,-1).$_SERVER['SCRIPT_NAME'].'?'.$_SERVER['QUERY_STRING']; ?><br />
				WEB����åפ�URL��<?php echo _DOMAIN; ?>
			</p>
			<div id="send_mail_detail"></div>
			<input class="closeModalBox" type="hidden" name="customCloseButton" value="" />
			<input type="hidden" name="multimail" value="true" />
			<input type="hidden" name="param[]" value="<?php echo $itemcode." ".$itemname; ?>" class="param" />
			<input type="hidden" name="param[]" value="<?php echo "��".number_format($price)."  ��".$ratio."�� �ʡ�".number_format($discount)."��OFF��"; ?>" class="param" />
			<input type="hidden" name="param[]" value="<?php echo $description; ?>" class="param" />
			<input type="hidden" name="itemid" value="<?php echo $item_id; ?>" class="param" />

		</form>

	</div>

	<div id="printform_contents">
		<?php
			// ���ʲ���
			$item_images = '<td class="thumb"><img alt="" src="'.$imgPath.$img_src.'" width="135" /></td>';
			// ñ��
			$low_price = $price_list[0]['price_white'];
			$off_price = $price_list[0]['price_white_maker'] - $price_list[0]['price_white'];
			$discount_ratio = round(($off_price*100)/$price_list[0]['price_white_maker']);
		?>
		<form name="printform" id="printform" action="/popup/printform.php" target="_blank" method="post" onSubmit="return false">

			<div class="inner">
				<h2>������������</h2>
				<table><tbody>
					<tr><?php echo $item_images; ?></tr>
				</tbody></table>
				<table>
				<tbody>
					<tr><th>ȯ����</th><td style="width:470px;"><?php echo "������ʸ�� ".$fin['Year']."ǯ".$fin['Month']."��".$fin['Day']."����ȯ���Ǥ���"; ?></td></tr>
					<tr><th>���֡�����̾</th><td><?php echo $itemcode." ".$itemname; ?></td></tr>
					<tr><th>ñ��</th><td><?php echo "��".number_format($low_price)." ��".$discount_ratio."%(��".number_format($off_price).") OFF"; ?></td></tr>
					<tr><td colspan="2"><?php echo $description; ?></td></tr>
				</tbody>
				</table>
			</div>

			<p class="comment">
				���Υ������åȤμ̿���<?php echo substr(_DOMAIN,0,-1).$_SERVER['SCRIPT_NAME'].'?'.$_SERVER['QUERY_STRING']; ?><br />
				WEB����åפ�URL��<?php echo _DOMAIN; ?>
			</p>
			<div id="printout_detail"></div>
			<input class="closeModalBox" type="hidden" name="customCloseButton" value="" />

		</form>
	</div>

	<div id="message_wrapper" style="display:none;"></div>
	
	<footer>
<!-- m2 begin -->
		<div class="footer-wrapper" id="pcpage"><?php echo $footer; ?> </div>
		<div class="footer-wrapper" id="phonepage"><?php
			$php = file_get_contents($_SERVER['DOCUMENT_ROOT']."/m2/common/inc/footer1.html");
			eval('?>'. mb_convert_encoding($php, 'euc-jp', 'UTF-8'). '<?');
		?>
	</div>
<!-- m2 end -->
	</footer>
    </div><!-- /wrapper-all-->

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