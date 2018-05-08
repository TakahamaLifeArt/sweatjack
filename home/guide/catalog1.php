<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/../app-def/initcontents2.php';
	if(isset($_POST['sample']) && $_POST['sample']=="sample"){
		$mail_title = "����ץ�̵����󥿥�Τ�������";
	}else{
		$mail_title = "���������դΤ�������";
	}
	require_once $_SERVER['DOCUMENT_ROOT'].'/../app-def/sendmail.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/../cgi-bin/conndb.php';
	$conn = new Conndb();
	$list = $conn->sjTablelist('items');
	$count= count($list);
	$selector = '<select name="item" id="item_selector">';
	$selector .= '<option value="̤����" class="0" selected="selected">---</option>';
	for($i=0; $i<$count; $i++){
		$item_name = $list[$i]['item_code']." ".mb_convert_encoding($list[$i]['item_name'],'euc-jp', 'utf-8');
		$cls = "id_".$list[$i]['id']."_".$list[$i]['color_code'];
		$selector .= '<option value="'.$item_name.'" class="'.$cls.'">'.$item_name.'</option>';
	}
	$selector .= '</select>';

	// size selector
	$list2 = $conn->sjTablelist('itemsize',$list[0]['id'], $list[0]['color_code']);
	$count= count($list2);
	$size = '<select name="size" id="size_selector">';
	$size .= '<option value="̤����" selected="selected">---</option>';
	for($i=0; $i<$count; $i++){
		$size .= '<option value="'.$list2[$i]['size_name'].'">'.$list2[$i]['size_name'].'</option>';
	}
	$size .= '</select>';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="euc-jp" />
    <title>������������ץ� �� ���ꥸ�ʥ�ѡ������Υ������åȥ���å�</title>
    <meta name="description" content="���ꥸ�ʥ륹�����åȤκ��ʽ����饤��ʥåץ������ϡ������餫�餪���ڤˤ����᤯������������ץ�̵����󥿥�⤷�Ƥ���ޤ������ꥸ�ʥ륹�����åȤ���ʤ饹�����åȥ���å���" />
    <meta name="keywords" content="�������å�,���ꥸ�ʥ륹�����å�,�ѡ�����,���ꥸ�ʥ�ѡ�����,�ץ���,������,����ץ�,̵����󥿥�" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <meta http-equiv="Content-Script-Type" content="text/javascript" />
	<link rel="shortcut icon" href="/icon/favicon.ico" />
    <link rel="stylesheet" type="text/css" media="screen" href="../css/template1.css" />
<link rel='stylesheet' id='contact-form-7-css'  href='../css/header-footer_responsive.css' type='text/css' media='all' />
    <link rel="stylesheet" type="text/css" media="screen" href="../css/catalog1.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../js/modalbox/css/jquery.modalbox.css" />

    <script type="text/javascript" src="../js/jquery.js"></script>
    <script type="text/javascript" src="../js/modalbox/jquery.modalbox-min.js"></script>
    <script type="text/javascript" src="../js/util.js"></script>
    <script type="text/javascript" src="../js/catalog.js"></script>

    <script type="text/javascript">
        var _res_mail = "<?php echo $html; ?>";
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
	
	<div class="container">
	
        <div class="contents inner">
			
			<?php echo $msgbar; ?>
			
			<h2 class="titlelogo">������������ץ�</h2>
			
			<div class="section">
				<p class="fb">
					�������å����ӤΤ��������������ȤǤ������ڤ�ʤ�̥�Ϥ˽в񤨤ޤ���
				</p>
			</div>
			
			<div class="section fix">
				<h2 class="top_logo">�᡼�����������ץ쥼���</h2>
				<p class="txtinfo">
					�ƥ������åȥ᡼�����Υ�������̵���Ǥ����ꤤ�����ޤ���<br>
					�����ȷǺܾ��ʰʳ����갷�äƤ���ޤ��Τǡ������ڤˤ��䤤��碌����������
				</p>
				<img src="/img/guide/catalog/image01.png">
			</div>
			
			<div class="section fix">
				<h2 class="top_logo">����ץ��ߤ��Ф�</h2>
				<p class="txtinfo">
					����˾�ξ���3���ޤǡ�10����̵���ǥ�󥿥뤬��ǽ�Ǥ���<br>
					���Ϥθ������꿨�ꡢ�������������顼�ʤɤ򤸤ä���Τ�����ޤ���
				</p>
				<p class="note"><span>��</span>���������Τߤ�������ô�򤪴ꤤ���Ƥ���ޤ���</p>
				<img src="/img/guide/catalog/image02.png">
			</div>
			
			<div class="section">
				<h2 class="top_logo">���������դΤ��������ߥե�����</h2>
				
				<form class="f_layout" name="form1" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post" onSubmit="return false" >
					<input type="hidden" name="subject" value="���������դΤ�������" />
					<input type="hidden" name="requestform" value="1" />
					<input type="hidden" name="ticket" value="<?php echo $ticket;?>" />
					<table>
						<tbody>
							<tr>
								<th>��̾<span>��ɬ�ܡ�</span></th>
								<td><input type="text" name="name" value="" class="wide" /></td>
							</tr>
							<tr>
								<th>�դ꤬��</th>
								<td><input type="text" name="ruby" value="" class="wide" /></td>
							</tr>
							<tr>
								<th>���Ϥ���ΰ�̾<br><ins>�ʸĿ��ͤ����פǤ���</ins></th>
								<td><input type="text" name="company" value="" class="wide" title="�ع�̾�����̾������̾�ʤ�"/></td>
							</tr>
							<tr>
								<th>�����ֹ�<span>��ɬ�ܡ�</span></th>
								<td><input type="text" name="tel" value="" class="wide phone" title="�ϥ��ե�-�����ס�����������OK�Ǥ�" /></td>
							</tr>
							<tr>
								<th>�᡼�륢�ɥ쥹<span>��ɬ�ܡ�</span></th>
								<td><input type="text" name="email" value="" class="wide" title="PC�����ӡ��ɤ���Ǥ�OK�Ǥ�" /></td>
							</tr>
							<tr>
								<th>���Ϥ��轻��<span>��ɬ�ܡ�</span></th>
								<td>
									�� <input type="text" name="zipcode" value="" class="zip" />
									<p><input type="text" name="addr1" value="" class="wide" title="��ƻ�ܸ����齻������Ϥ��Ƥ�������" /></p>
									<p><input type="text" name="addr2" value="" class="wide" title="���ϡ��ޥ󥷥��̾�ʤɤη�ʪ̾" /></p>
								<td>
							</tr>
							<tr>
								<th>����������</th>
								<td><textarea cols="30" rows="5" name="message" class="wide"></textarea></td>
							</tr>
						</tbody>
					</table>
					
					<div class="opt">
						<h3>���ʥ���ץ�Υ�󥿥�򤴴�˾�ξ��</h3>
						<div>
							<label><input type="checkbox" name="sample" value="sample"> ����ץ�Υ�󥿥�򿽤�����</label>
							<p>��󥿥��˾�ξ���̾</p>
							<?php echo $selector; ?>
							
							<p>��������<?php echo $size; ?></p>
							
							<p class="anchor"><a href="/lineup/lineup_parker1.php">���ʥ饤��ʥåפ򳫤�</a></p>
						</div>
					</div>
					
					<div id="send_mail" ><p>��������</p></div>
					
					<div class="message">
						<p class="note"><span>��</span>���Ƥˤ��ޤ��Ƥϲ����ޤǤˤ����֤򤤤�������礬�������ޤ���</p>
						<p class="note"><span>��</span>���ޤ��ξ���<span class="fontred"> <?php echo _TOLL_FREE; ?> </span>��ʿ��10:00��18:00�ˤޤǤ����ڤˡ�</p>
					</div>
				</form>
				
			</div>
			
			<p class="page_top"><span>������������ץ롡�ڡ����ȥåפ�</span></p>

		</div><!-- /contents -->

	</div>
	
									<footer>
				<div class="footer-wrapper"><?php echo $footer; ?> </div>
			</footer>
    </div><!-- /wrapper-all-->
	
	<div id="message_wrapper" style="display:none;"></div>

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