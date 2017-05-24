<?php
	require_once dirname(__FILE__).'/php_libs/funcs.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/../app-def/initcontents2.php';

	// �����󤷤Ƥ������TOP��
	$me = checkLogin();
	if($me){
		jump('history.php');
	}

if(isset($_REQUEST['login']) && empty($_SESSION['me'])){
	
	$args = array($_REQUEST['email']);
	$conndb = new Conndb(_API_U);

	// ���顼�����å�
	if(empty($_REQUEST['email'])) {
		$err = '�᡼�륢�ɥ쥹�����Ϥ��Ʋ�������';
	}else if(!$conndb->checkExistEmail($args)) {
		$err = "���Υ᡼�륢�ɥ쥹����Ͽ����Ƥ��ޤ���";
	}else if(empty($_REQUEST['pass'])) {
		$err = '�ѥ���ɤ����Ϥ��Ʋ�������';
	}else{
		$args = array('email'=>$_REQUEST['email'], 'pass'=>$_REQUEST['pass']);
		$me = $conndb->getUser($args);
		if(!$me){
			$err = "�᡼�륢�ɥ쥹���ѥ���ɤ�ǧ���Ǥ��ޤ��󡣤���ǧ��������";
		}
	}
	
	if(empty($err)){
		// ���å����ϥ�����å��к�
		session_regenerate_id(true);
		
		// ��������֤��ݻ�
		if($_REQUEST['save']) {
			//setcoocie(session_name(), sesion_id(), time()+60*60*24*7);
		}
		
		$_SESSION['me'] = $me;
		jump('history.php');
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>������ �� ���ꥸ�ʥ�ѡ������Υ������åȥ���å�</title>
  <meta charset="euc-jp">
  <meta name="google-site-verification" content="2diSaROfDF6R2o7GL9xAmgiwFv1VecKcMvHyMs0cmsA">
  <meta name="description" content="���ꥸ�ʥ�ѡ������Υǥ�����ˤ���������ϥ������åȥ���å���̵���������ޤ����ѡ������Υա��ɤ�µ���ȥ졼�ʡ����������åȥѥ�Ĥˤ⥪�ꥸ�ʥ�ǥ������ץ��ȡ�ʸ�������Ǥ��ޤ�����û����ȯ����Ǽ�����ᤤ�ΤȲ��ʤ�¤��Τ���ħ�Ǥ���">
  <meta name="keywords" content="���ꥸ�ʥ�,�ѡ�����,����,�ץ���">
<!-- viewport -->
	<meta name="viewport" content="width=device-width,user-scalable=no,maximum-scale=1" />

	<link rel="shortcut icon" href="/icon/favicon.ico" />
<!-- msgbox begin-->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
<!-- msgbox end-->


<!-- css -->
	<link rel="stylesheet" type="text/css" href="/css/lazyboard_responsive.css" media="all" />
	<link rel='stylesheet' href='/css/header-footer_responsive.css' type='text/css' media='all' />
	<link rel='stylesheet' href='/css/newtop_responsive.css' type='text/css' media='all' />

	<link rel="stylesheet" type="text/css" media="screen" href="./css/style_responsive.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="./css/login_responsive.css" />

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
	<script type="text/javascript" src="./js/login.js"></script>
<!--calendar-->
	<script src="/js/jquery.mmenu.min.all.js"></script>
 	<script type="text/javascript" src="/calendar/js/deliveryday.js"></script>

	<script type="text/javascript">
		_LOGIN_STATE = '<?php echo $err; ?>';
		
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
					<h1>������</h1>
				</div>
			</div>
			
			<div id="loginform_wrapper" class="section">
				<form class="form_m" name="loginform" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post" onsubmit="return false;">
					<div class="close_form"></div>
					<label>�᡼�륢�ɥ쥹</label>
					<input type="text" value="" name="email" autofocus />
					<label>�ѥ����</label>
					<input type="password" value="" name="pass" />
					<div class="resend_pass"><a href="resend_pass.php">�ѥ���ɤ�˺�줿���Ϥ������</a></div>
	 				<div class="btn_wrap">
						<div id="login_button"></div>
  					<!--<p><a href="register.php" style="display:none;">�桼������Ͽ</a></p>-->
					</div>
					<input type="hidden" name="login" value="1">
					<input type="hidden" name="reg_site" value="5">
				</form>
			</div>
			
		</div>
	</div>
	
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

<!-- msgbox begin-->
		<div id="msgbox" class="modal fade" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">��å�����</h4>
			 		</div>
			 		<div class="modal-body">
						<p></p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary is-ok" data-dismiss="modal">OK</button>
						<button type="button" class="btn btn-default is-cancel" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
		</div>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- msgbox end-->



</body>
</html>
