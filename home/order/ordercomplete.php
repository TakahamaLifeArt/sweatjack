<?php
	ini_set('memory_limit', '128M');
	require_once $_SERVER['DOCUMENT_ROOT'].'/../app-def/initcontents2.php';
	require_once dirname(__FILE__).'/../php_libs/orders.php';
	require_once dirname(__FILE__).'/ordermail.php';
	
	if( isset($_POST['ticket'], $_SESSION['ticket'], $_SESSION['orders']) && $_POST['ticket']==$_SESSION['ticket'] ) {
		$email = $_SESSION['orders']['customer']['email'];
		$customer = mb_convert_encoding($_SESSION['orders']['customer']['customername'], 'euc-jp', auto);
		$ordermail = new Ordermail();
		$isSend = $ordermail->send();
	}else{
		$isSend = false;
	}
 	
 	/* ��ʸ�ե��Υ��å������˴� */
	if($isSend){
		unset($_SESSION['ticket']);
		$_SESSION['orders'] = array();
//		setcookie(session_name(), "", time()-86400, "/");
		unset($_SESSION['orders']);
	}
	
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="euc-jp" />
	<title>���������ߥ᡼��������λ��|�����ꥸ�ʥ�ѡ������Υ������åȥ���å�</title>
    <meta name="description" content="���ꥸ�ʥ�ѡ������Τ���ʸ�Ϥ����餫�顣���������ե���������Ϥ���ȸ��Ѥ⼫ư�ǤǤ��롪������������ͽ�����狼��¿��Ǥ������ꥸ�ʥ륹�����åȤ���ʤ饹�����åȥ���å���" />
    <meta name="keywords" content="�������å�,���ꥸ�ʥ륹�����å�,�ѡ�����,���ꥸ�ʥ�ѡ�����,�ץ���,��ʸ,���������ե�����" />
<!--m2 begin-->
	<meta name="viewport" content="width=device-width,user-scalable=no,maximum-scale=1" />
<!--m2 end-->

	<link rel="shortcut icon" href="/icon/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="/css/template1_responsive.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="./css/finish1_responsive.css" media="screen" />
	<link rel='stylesheet' id='contact-form-7-css'  href='../css/header-footer_responsive.css' type='text/css' media='all' />
<!--m2 begin-->
    <link rel="stylesheet" type="text/css" href="/m2/common/css/common1_responsive.css" media="all">
<!--m2 end--> 

	<script type="text/javascript" src="/js/jquery.js"></script>
	<script type="text/javascript" src="/js/util.js"></script>
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
<h1>���ꥸ�ʥ륹�����åȤʤ饹�����åȥ���å�!</h1>
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
	
	<div id="container">
		
		<div class="contents">
			<?php
				echo $msgbar;
				
				$cst = 'cst';
				function cst($constant){
					return $constant;
				}
				
				if($isSend){
					$heading = '�������������Ƥγ�ǧ�᡼����ֿ���Ǥ���<br>ɬ������ǧ����������';
					$html = <<<DOC
				<div class="inner">
					<p>{$customer}����</p>
					<p>�����٤ϥ����ϥޥ饤�ե����Ȥ����Ѥ������������ˤ��꤬�Ȥ��������ޤ���</p>
				</div>
				
				<div class="remarks">
					<h3>����γ��ϤˤĤ���</h3>
					<p>�������Ǥϡ�<span class="highlights">����ʸ�ϳ��ꤷ�Ƥ��ޤ���</span></p>
					<p>
						����򳫻Ϥ���ˤ����ꡢ�����äˤ��ǥ�����γ�ǧ���ä���ʸ����Ȥ����Ƥ��������Ƥ���ޤ���<br>
						���Ҥ���渫�Ѥ�᡼������ꤤ�����ޤ��Τǡ�
						���Ѥ�����Ǥ���������ǧ��ե꡼�������<ins> {$cst(_TOLL_FREE)} </ins>�ޤǤ�Ϣ����������
					</p>
				</div>
				
				<div class="inner">
					<h3>�� <span class="highlights">��ǧ�᡼�뤬�Ϥ��ʤ����</span> ��</h3>
					<p>
						������ĺ�����᡼�륢�ɥ쥹 {$email} ���ˡ��������������Ƥγ�ǧ�᡼����������Ƥ��ޤ���<br>
						�����ͤ˳�ǧ�᡼�뤬�Ϥ��Ƥ��ʤ���硢���Ҥˤ��������ߥ᡼�뤬�Ϥ��Ƥ��ʤ���ǽ�����������ޤ��Τǡ�<br>
						��������ޤ������ե꡼�������<ins> {$cst(_TOLL_FREE)} </ins>�ޤǤ��䤤��碌��������
					</p>
				</div>
				
				<div class="inner">
					<h3>�� ����ʸ�˴ؤ��뤪�䤤��碌 ��</h3>
					<p>
						���ޤ��Τ����ͤϡ��ե꡼������� {$cst(_TOLL_FREE)} �ޤǤ����ڤˤ�Ϣ����������
					</p>
					<p><a href="/customer/contact1.php">�᡼��ǤΤ��䤤��碌�Ϥ����餫��</a></p>
					<hr />
					<p class="gohome"><a href="/">�ۡ���ڡ��������</a></p>
				</div>

DOC;
				}else{
					$heading = '�������顼��';
					$html = <<<DOC
				<div class="inner">
					<p>{$customer}����</p>
					<div class="remarks">
						<h3>���������ߥ᡼�������������ޤ���Ǥ�����</h3>
						<p>���������ߥ᡼���������˥��顼��ȯ���������ޤ�����</p>
					</div>
					<p>��������ޤ��������� <a href="/order/">���������ߥե�����</a> ����� [ ��ʸ���� ] �ܥ���򥯥�å����Ʋ�������</p>
				</div>
				<div class="inner">
					<h3>�� ����ʸ�˴ؤ��뤪�䤤��碌 ��</h3>
					<p class="note">���ޤ��Τ����ͤϡ��ե꡼������� {$cst(_TOLL_FREE)} �ޤǤ����ڤˤ�Ϣ����������</p>
					<p><a href="/customer/contact1.php">�᡼��ǤΤ��䤤��碌�Ϥ����餫��</a></p>
					<hr />
					<p class="gohome"><a href="/order/">���������ߥե���������</a></p>
				</div>
DOC;
				}
				
			?>
			
			<div class="heading1_wrapper">
				<h1><?php echo $heading;?></h1>
				<p class="comment"></p>
			</div>
			<p class="heading"></p>
			<div class="wrap">
				<?php echo $html;?>
			</div>
		</div>
		
	</div>
	
	<p class="page_top"><span>���������ߥ᡼���������λ���ڡ����ȥåפ�</span></p>

	
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
<script type="text/javascript">
  (function () {
    var tagjs = document.createElement("script");
    var s = document.getElementsByTagName("script")[0];
   ��tagjs.async = true;
    tagjs.src = "//s.yjtag.jp/tag.js#site=gfjjZ2r";
    s.parentNode.insertBefore(tagjs, s);
  }());
</script>
<noscript>
<iframe src="//b.yjtag.jp/iframe?c=gfjjZ2r" width="1" height="1" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
</noscript>

</body>
</html>
