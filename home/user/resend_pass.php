<?php
require_once dirname(__FILE__).'/php_libs/funcs.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/../app-def/initcontents2.php';

if($_SERVER['REQUEST_METHOD']!='POST'){
	setToken();
}else{
	chkToken();
	
	if(isset($_POST['resend'])){
		$conndb = new Conndb(_API_U);
		
		$param['email'] = trim(mb_convert_kana($_POST['email'],"s", "utf-8"));
		$args = array($param['email']);
		
		if(empty($param['email'])){
			$err['email'] = '�᡼�륢�ɥ쥹�����Ϥ��Ʋ�������';
		}else if(!isValidEmailFormat($param['email'])){
			$err['email'] = '�᡼�륢�ɥ쥹������������ޤ���';
		}else{
			$user = $conndb->checkExistEmail($args);
			$userid = $user['id'];
			if(!$userid) $err['email'] = '�᡼�륢�ɥ쥹�Τ���Ͽ������ޤ���';
		}
		
		if(empty($err)) jump(_DOMAIN.'/user/support/transmit.php?ticket='.$_POST['token'].'&u='.$userid);
	}
	
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="euc-jp" />
<!-- m3 begin -->
	<meta name="viewport" content="width=device-width,user-scalable=no,maximum-scale=1" />
<!-- m3 end -->
	<title>�ѥ���ɤ�˺�줿�� �� ���ꥸ�ʥ�ѡ������Υ������åȥ���å�</title>
	<meta name="Description" content="���ꥸ�ʥ�ѡ������Υ������åȥ���å�����ʤ饹�����åȥ���å����ᤤ���������åȥ���å������ѤΤ����ͤء��ѥ���ɤ�˺��Ǥ������н���ˡ�ˤĤ��ƤΡ�������򤤤����ޤ�����Ͽ���줿�᡼�륢�ɥ쥹�����Ϥ��Ƥ��������������ܥ���򥯥�å������塢��Ͽ���줿Ϣ����᡼�륢�ɥ쥹���ˤ������פ��ޤ���">
	<meta name="keywords" content="���ꥸ�ʥ�,t�����,�ѥ����">
	<link rel="shortcut icon" href="/icon/favicon.ico" />
<!-- css -->
	<link rel="stylesheet" type="text/css" href="/css/lazyboard_responsive.css" media="all" />
	<link rel='stylesheet' id='contact-form-7-css'  href='/css/header-footer_responsive.css' type='text/css' media='all' />
	<link rel='stylesheet' id='contact-form-7-css'  href='/css/newtop_responsive.css' type='text/css' media='all' />

	<link rel="stylesheet" type="text/css" media="screen" href="./css/style_responsive.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="./css/account_responsive.css" />

	<link rel="stylesheet" type="text/css" media="screen" href="/common/js/modalbox/css/jquery.modalbox.css">
	<!-- m2 -->
  <link rel="stylesheet" type="text/css" href="/m2/css/top1_responsive.css" media="all">
  <link rel="stylesheet" type="text/css" href="/m2/common/css/common1_responsive.css" media="all">
<!-- msgbox begin-->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/jquery-ui.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
	<script src="//ajaxzip3.github.io/ajaxzip3.js" charset="utf-8"></script>
<!-- msgbox end-->

	<script type="text/javascript" src="./js/common.js"></script>
	<script type="text/javascript" src="./js/resendpass.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
<!--calendar-->
	<script src="/js/jquery.mmenu.min.all.js"></script>
  	<script type="text/javascript" src="/calendar/js/deliveryday.js"></script>

	<!-- OGP -->
	<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#  website: http://ogp.me/ns/website#">
	<meta property="og:title" content="������®�������ꥸ�ʥ�T����Ĥ������ž夲����" />
	<meta property="og:type" content="article" /> 
	<meta property="og:description" content="�ȳ�No. 1ûǼ���ǥ��ꥸ�ʥ�T����Ĥ�1�礫��������ޤ����̾�Ǥ�3���ǻž夲�ޤ���" />
	<meta property="og:url" content="http://www.sweatjack.jp/" />
	<meta property="og:site_name" content="���ꥸ�ʥ�ѡ������Υ������åȥ���å�" />
	<meta property="og:image" content="http://www.takahama428.com/common/img/header/Facebook_main.png" />
	<meta property="fb:app_id" content="1605142019732010" />
	<!--  -->
	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-11155922-2']);
		_gaq.push(['_trackPageview']);
		
		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	</script>
</head>
<body class="home page page-id-141 page-template page-template-home page-template-home-php full-width">

		<!-- Google Tag Manager -->
		<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-T5NQFM"
		height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-T5NQFM');</script>
		<!-- End Google Tag Manager -->

	<div>
			<header class="site-header"><?php echo $header; ?>			
				<div  id="fixedBox" class="nav">
					<nav id="global-navigation"><?php echo $menu; ?></nav>	
				</div>
			</header>
	</div>

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
	<div id="container">
		<div class="contents">
			<div class="toolbar">
				<div class="toolbar_inner clearfix">
					<div class="menu_wrap">
						<?php if(checkLogin()) echo $menu;?>
					</div>
					<h1>�ѥ���ɤ�˺�줿��</h1>
				</div>
			</div>
			
			<div class="section">
				<form name="pass" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post" onsubmit="return false;">
					<table class="form_table me" id="pass_table">
						<caption>��Ͽ���줿�᡼�륢�ɥ쥹�˲��ѥ���ɤ������������ޤ���</caption>
						<tfoot>
							<tr>
								<td colspan="2">
									<input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
									<input type="hidden" name="resend" value="1">
									<p><span class="ok_button">����</span></p>
								</td>
							</tr>
						</tfoot>
						<tbody>
							<tr>
								<th>�᡼�륢�ɥ쥹</th>
								<td><input type="text" name="email" value="<?php echo $_POST['email'];?>"><br><ins class="err"> <?php echo $err['email']; ?></ins></td>
							</tr>
						</tbody>
					</table>
				</form>
			</div>
		</div>
	
	</div>
	
	<p class="scroll_top"><a href="#header">�ѥ���ɤ�˺�줿�����ڡ����ȥåפ�</a></p>
	<footer>
		<div id="pcpage">
			<div class="other">
				<div id="othermenu"><h2 class="header-home"><span><a href="">other</a></span></h2>
					<section class="home-company">
						<h4><a href="/company/company1.php">��Ⱦ���</a></h4>
					</section>
					<section class="home-guide">
						<h4><a href="/customer/contact1.php">���䤤��碌</a></h4>
					</section>
					<section class="home-info">
						<h4><a href="/faq/index1.php">Q&A</a></h4>
					</section>
					<section class="home-order">
						<h4><a href="/guide/guide1.php">����ʸ��ή��</a></h4>
					</section>
					<section class="home-design">
						<h4><a href="/guide/design_tech1.php">�ǥ�����κ����</a></h4>
					</section>
				</div>
				<div class="caler">
					<div class="calendar_wrapper">
	          <div id="datepicker"></div>
	          <p class="openhours">�ĶȻ��֡�10:00���18:00�ʷ����</p>
	          <p><span class="fontred">��</span>��������ڡ�������</p>
					</div>
				</div>	
			</div>
			<div class="footer-wrapper"><?php echo $footer; ?> </div>
		</div>
		<div id="phonepage">
			<div class="footer-wrapper">
<!--m2 begin-->
				<?php
					$php = file_get_contents($_SERVER['DOCUMENT_ROOT']."/m2/common/inc/footer1.html");
					eval('?>'. mb_convert_encoding($php, 'euc-jp', 'UTF-8'). '<?');
				?>
<!--m2 end-->
			</div>
		</div>
	</footer>


<!--Yahoo!�����ޥ͡����㡼Ƴ�� 2014.04 -->
<script type="text/javascript">
  (function () {
    var tagjs = document.createElement("script");
    var s = document.getElementsByTagName("script")[0];
    tagjs.async = true;
    tagjs.src = "//s.yjtag.jp/tag.js#site=bTZi1c8";
    s.parentNode.insertBefore(tagjs, s);
  }());
</script>
<noscript>
  <iframe src="//b.yjtag.jp/iframe?c=bTZi1c8" width="1" height="1" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
</noscript>

</body>
</html>