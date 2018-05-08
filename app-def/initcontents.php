<?php
	require_once dirname(__FILE__)."/session_my_handler.php";
	require_once $_SERVER['DOCUMENT_ROOT'].'/../cgi-bin/config.php';
	$myname = $_SERVER['SCRIPT_FILENAME'];
	
	$isTest = false;
	if(strpos(dirname($_SERVER['SCRIPT_NAME']), _TEST_NAME)===1){
		$myname = $_SERVER['DOCUMENT_ROOT'].substr(dirname($_SERVER['SCRIPT_NAME']), strlen(_TEST_NAME)+1).'/'.basename($_SERVER['SCRIPT_NAME']);
		$isTest = true;
	}

	$itemis = 'parker';		// default item.
	$itemname_text = array('parker'=>'�ѡ�����', 'trainer'=>'�ȥ졼�ʡ����������å�', 'jacket'=>'���㥱�å�', 'champion'=>'�����ԥ���ѡ��������������å�', 'pants'=>'�������åȥѥ��', 'setup'=>'�岼���å�');
	$itemcategory_text = array('parker','trainer','pants','jacket','champion');
	$comment = '';
	$pan_navigation = '';
	
	switch($myname){
	case _DOC_ROOT.'index.php':
	case _DOC_ROOT.'t_index.php':
			// $comment = '<p>���ä��������ꥸ�ʥ륹�����åȤ�ѡ����������򡪥ǥ�����Ǽ���ʤɡ��ʤ�Ǥ⤴���̲��������������åȥ���å��������������ޤ���</p>';
			$page = 'home';
			
			require_once dirname(__FILE__).'/jd/myCalendar.php';
			list($year, $month) = explode(' ', date("Y n"));
			$myCalendar = new myCalendar($year, $month);
			list($year2, $month2) = explode(' ', date('Y n', mktime(0, 0, 0, date('n')+1, date('j'), date('Y'))));
			$myCalendar2 = new myCalendar($year2, $month2);
			break;
	case _DOC_ROOT.'gallery/gallery_body.php':
	case _DOC_ROOT.'gallery/gallery_hood.php':
	case _DOC_ROOT.'gallery/gallery_pants.php':
	case _DOC_ROOT.'gallery/gallery_setup.php':
	case _DOC_ROOT.'gallery/gallery_sleeve.php':
			$comment = '<h1>���ꥸ�ʥ�ѡ��������������å������㡣</h1><p>���礢���������ͽ�������Ѥ����������åȤ䥤�󥯡��ץ��Ȥ������֡��ץ�����ˡ�ʤɡ����ꥸ�ʥ륹�����å�����Τ����ͤˡ�</p>';
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; ���줬����</li></ul>';
			$page = 'gallery';
			break;
	case _DOC_ROOT.'order/orderform_parker.php':
	case _DOC_ROOT.'order/orderform_pants.php':
	case _DOC_ROOT.'order/orderform_setup.php':
	case _DOC_ROOT.'order/orderform.php':
			$comment = '<h1>���ꥸ�ʥ�ѡ��������������åȤΤ��������ߡ�</h1><p>���Ѥ��ۤ���ư�׻�����ޤ���</p>';
			$page = '';
			$gnavi = "navi_1";
			$itemis = substr(basename($myname, '.php'), strpos(basename($myname, '.php'), '_')+1);
			break;
	case _DOC_ROOT.'order/finish.php':
			$comment = '<p>���������ߤ���դ������ޤ�����</p>';
			$page = '';
			$gnavi = "navi_4";
			break;
	case _DOC_ROOT.'order_new/index.php':
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; ���������ߥե�����</li></ul>';
			$page = '';
			break;
	case _DOC_ROOT.'order_new/ordercomplete.php':
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; ���������ߥ᡼������</li></ul>';
			$page = '';
			break;
	case _DOC_ROOT.'order/register.php':
			$comment = '<h1>���Ϥ�������ϡ�</h1><p>��̾������Ϣ���衦������ʤɤ����Ϥ���������<strong>�μ��ڤ⡢���β��̤�ȯ��</strong>�Ǥ��ޤ���</p>';
			$page = '';
			$gnavi = "navi_2";
			break;
	case _DOC_ROOT.'order/confirm.php':
			$comment = '<h1>����ʸ���Ƥ򤴳�ǧ����������</h1><p>����ʸ�ο����򤹤�ܥ���ǡ�����ʸ�ʿ����˥᡼��������������ޤ���</p>';
			$page = '';
			$gnavi = "navi_3";
			break;
	case _DOC_ROOT.'lineup/lineup_parker.php':
			$comment = '<h1>���ꥸ�ʥ�ѡ����������ܤ���</h1><p><strong>�᡼�������ʡʥ��</strong>��<strong>39��48��OFF!!!</strong> ��Ķ�ܶ��ò��Ǥ���</p>';
			$itemis = substr(basename($myname, '.php'), strpos(basename($myname, '.php'), '_')+1);
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; '.$itemname_text[$itemis].'����</li></ul>';
			$page = basename($myname, '.php');
			break;
	case _DOC_ROOT.'lineup/lineup_trainer.php':
			$comment = '<h1>���ꥸ�ʥ�ȥ졼�ʡ����������åȤ����ܤ���</h1><p><strong>�᡼�������ʡʥ��</strong>��<strong>39��48��OFF!!!</strong> ��Ķ�ܶ��ò��Ǥ���</p>';
			$itemis = substr(basename($myname, '.php'), strpos(basename($myname, '.php'), '_')+1);
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; '.$itemname_text[$itemis].'����</li></ul>';
			$page = basename($myname, '.php');
			break;
	case _DOC_ROOT.'lineup/lineup_jacket.php':
			$comment = '<h1>���ꥸ�ʥ른�㥱�åȤ����ܤ���</h1><p><strong>�᡼�������ʡʥ��</strong>��<strong>39��48��OFF!!!</strong> ��Ķ�ܶ��ò��Ǥ���</p>';
			$itemis = substr(basename($myname, '.php'), strpos(basename($myname, '.php'), '_')+1);
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; '.$itemname_text[$itemis].'����</li></ul>';
			$page = basename($myname, '.php');
			break;
	case _DOC_ROOT.'lineup/lineup_champion.php':
			$comment = '<h1>���ꥸ�ʥ�����ԥ���ѡ��������������åȤ����ܤ���</h1><p><strong>�᡼�������ʡʥ��</strong>��<strong>39��48��OFF!!!</strong> ��Ķ�ܶ��ò��Ǥ���</p>';
			$itemis = substr(basename($myname, '.php'), strpos(basename($myname, '.php'), '_')+1);
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; '.$itemname_text[$itemis].'����</li></ul>';
			$page = basename($myname, '.php');
			break;
	case _DOC_ROOT.'lineup/lineup_pants.php':
			$comment = '<h1>���ꥸ�ʥ륹�����åȥѥ�Ĥ����ܤ���</h1><p><strong>�᡼�������ʡʥ��</strong>��<strong>39��48��OFF!!!</strong> ��Ķ�ܶ��ò��Ǥ���</p>';
			$itemis = substr(basename($myname, '.php'), strpos(basename($myname, '.php'), '_')+1);
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; '.$itemname_text[$itemis].'����</li></ul>';
			$page = basename($myname, '.php');
			break;
	case _DOC_ROOT.'lineup/lineup_setup.php':
			$comment = '<h1>���ꥸ�ʥ�ѡ��������������åȥѥ�Ĥ����ܤ���</h1><p><strong>�᡼�������ʡʥ��</strong>��<strong>39��48��OFF!!!</strong> ��Ķ�ܶ��ò��Ǥ���</p>';
			$itemis = substr(basename($myname, '.php'), strpos(basename($myname, '.php'), '_')+1);
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; '.$itemname_text[$itemis].'����</li></ul>';
			$page = basename($myname, '.php');
			break;
	case _DOC_ROOT.'lineup/detail_parker.php':
			$comment = '<h1>�ѡ��������������åȤ����ܤ���</h1><p><strong>�᡼�������ʡʥ��</strong>��<strong>39��48��OFF!!!</strong> ��Ķ�ܶ��ò��Ǥ���</p>';
			$itemis = substr(basename($myname, '.php'), strpos(basename($myname, '.php'), '_')+1);
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; <a href="/lineup/lineup_'.$itemis.'.php">'.$itemname_text[$itemis].'����</a></li><li>&gt; �����ƥ�ܺ�</li></ul>';
			$page = '';
			break;
	case _DOC_ROOT.'lineup/detail_pants.php':
			$comment = '<h1>�ѥ�Ĥ����ܤ���</h1><p><strong>�᡼�������ʡʥ��</strong>��<strong>39��48��OFF!!!</strong> ��Ķ�ܶ��ò��Ǥ���</p>';
			$itemis = substr(basename($myname, '.php'), strpos(basename($myname, '.php'), '_')+1);
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; <a href="/lineup/lineup_'.$itemis.'.php">'.$itemname_text[$itemis].'����</a></li><li>&gt; �����ƥ�ܺ�</li></ul>';
			$page = '';
			break;
	case _DOC_ROOT.'lineup/detail_item.php':
			if(isset($_GET['c'])){
				$itemis = $itemcategory_text[$_GET['c']];
				
			}
			$comment = '<h1>���ꥸ�ʥ�'.$itemname_text[$itemis].'�����ֻ��Υݥ���Ȥ����Ϥθ����ʥ��󥹡ˤ�΢���ϡʥѥ��롦΢���ӡˡ���</h1>';
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; <a href="/lineup/lineup_'.$itemis.'.php">'.$itemname_text[$itemis].'����</a></li><li>&gt; �����ƥ�ܺ�</li></ul>';
			$page = '';
			break;
	case _DOC_ROOT.'lineup/detail_setup.php':
			$comment = '<h1>���ꥸ�ʥ�ѡ��������������åȥѥ�Ĥ����ֻ��Υݥ���Ȥ����Ϥθ����ʥ��󥹡ˤ�΢���ϡʥѥ��롦΢���ӡˡ���</h1>';
			$itemis = substr(basename($myname, '.php'), strpos(basename($myname, '.php'), '_')+1);
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; <a href="/lineup/lineup_'.$itemis.'.php">'.$itemname_text[$itemis].'����</a></li><li>&gt; �����ƥ�ܺ�</li></ul>';
			$page = '';
			break;
	case _DOC_ROOT.'guide/original_parker.php':
			$page = 'howto';
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; ���ꥸ�ʥ�ѡ������κ���</li></ul>';
			break;
	case _DOC_ROOT.'guide/intro.php':
			$page = 'intro';
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; �Ϥ���Ƥ�����</li></ul>';
			break;
	case _DOC_ROOT.'guide/guide.php':
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; ����ʸ��ή��</li></ul>';
			$page = 'orderflow';
			break;
	case _DOC_ROOT.'guide/design_tech.php':
			$comment = '<h1>���ꥸ�ʥ�ѡ��������������å�������ɡ�</h1><p>���ϥХå����åס��Υ����ʡ��Ǥ���������νФ���������λȤ������ץ��Ȥΰ㤤���ǥ����󡦥ƥ��˥å��ʤɡ��������</p>';
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; �ǥ�����κ����</li></ul>';
			$page = 'design_tech';
			break;
	case _DOC_ROOT.'guide/guide_3days.php':
			$comment = '<h1>���ꥸ�ʥ�ѡ��������������å�������ɡ�</h1><p>���ϥХå����åס��Υ����ʡ��Ǥ���������νФ���������λȤ������ץ��Ȥΰ㤤���ǥ����󡦥ƥ��˥å��ʤɡ��������</p>';
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; ���ꥸ�ʥ륹�����åȤ��Ǥ���ޤ�</li></ul>';
			$page = 'printing';
			break;
	case _DOC_ROOT.'guide/guide_estimate.php':
			$comment = '<h1>���ꥸ�ʥ�ѡ��������������å�������ɡ�</h1><p>���ϥХå����åס��Υ����ʡ��Ǥ���������νФ���������λȤ������ץ��Ȥΰ㤤���ǥ����󡦥ƥ��˥å��ʤɡ��������</p>';
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; �����Ѥ�λ���</li></ul>';
			$page = 'guide_estimate';
			break;
	case _DOC_ROOT.'guide/catalog.php':
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; ������������ץ�</li></ul>';
			$page = 'catalog';
			break;
	case _DOC_ROOT.'guide/discount.php':
			$comment = '<h1>���ꥸ�ʥ�ѡ��������������å�������ɡ�</h1><p>���ϥХå����åס��Υ����ʡ��Ǥ���������νФ���������λȤ������ץ��Ȥΰ㤤���ǥ����󡦥ƥ��˥å��ʤɡ��������</p>';
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; ���</li></ul>';
			$page = 'discount';
			break;
	case _DOC_ROOT.'guide/font.php':
			$comment = '<h1>���ꥸ�ʥ�ѡ��������������å�������ɡ�</h1><p>���ϥХå����åס��Υ����ʡ��Ǥ���������νФ���������λȤ������ץ��Ȥΰ㤤���ǥ����󡦥ƥ��˥å��ʤɡ��������</p>';
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; �Ȥ���ե����</li></ul>';
			$page = 'font';
			break;
	case _DOC_ROOT.'guide/ink.php':
			$comment = '<h1>���ꥸ�ʥ�ѡ��������������å�������ɡ�</h1><p>���ϥХå����åס��Υ����ʡ��Ǥ���������νФ���������λȤ������ץ��Ȥΰ㤤���ǥ����󡦥ƥ��˥å��ʤɡ��������</p>';
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; �Ȥ��륤�󥯡�������</li></ul>';
			$page = 'ink';
			break;
	case _DOC_ROOT.'guide/print_guide.php':
			$comment = '<h1>���ꥸ�ʥ�ѡ��������������å�������ɡ�</h1><p>���ϥХå����åס��Υ����ʡ��Ǥ���������νФ���������λȤ������ץ��Ȥΰ㤤���ǥ����󡦥ƥ��˥å��ʤɡ��������</p>';
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; �ץ�����ˡ</li></ul>';
			$page = 'print_guide';
			break;
	case _DOC_ROOT.'guide/print_navi.php':
			$comment = '<h1>���ꥸ�ʥ�ѡ��������������å�������ɡ�</h1><p>���ϥХå����åס��Υ����ʡ��Ǥ���������νФ���������λȤ������ץ��Ȥΰ㤤���ǥ����󡦥ƥ��˥å��ʤɡ��������</p>';
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; �ץ��Ⱦ�狼������</li></ul>';
			$page = 'print_navi';
			break;
	case _DOC_ROOT.'guide/sheet.php':
			$comment = '<h1>���ꥸ�ʥ�ѡ��������������å�������ɡ�</h1><p>���ϥХå����åס��Υ����ʡ��Ǥ���������νФ���������λȤ������ץ��Ȥΰ㤤���ǥ����󡦥ƥ��˥å��ʤɡ��������</p>';
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; �ǥ������ѻ���������</li></ul>';
			$page = 'sheet';
			break;
	case _DOC_ROOT.'guide/sweat_navi.php':
			$comment = '<h1>���ꥸ�ʥ�ѡ��������������å�������ɡ�</h1><p>���ϥХå����åס��Υ����ʡ��Ǥ���������νФ���������λȤ������ץ��Ȥΰ㤤���ǥ����󡦥ƥ��˥å��ʤɡ��������</p>';
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; �����ƥ�ξ�狼��õ��</li></ul>';
			$page = 'sweat_navi';
			break;
	case _DOC_ROOT.'faq/index.php':
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; �褯�������</li></ul>';
			$page = 'faq';
			break;
	case _DOC_ROOT.'faq/cancel.php':
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; <a href="/faq/">�褯�������</a></li><li>&gt; �ѹ�������󥻥�ˤĤ��� Q&amp;A</li></ul>';
			$page = 'cancel';
			break;
	case _DOC_ROOT.'faq/cost.php':
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; <a href="/faq/">�褯�������</a></li><li>&gt; ����ˤĤ��� Q&amp;A</li></ul>';
			$page = 'cost';
			break;
	case _DOC_ROOT.'faq/delivery.php':
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; <a href="/faq/">�褯�������</a></li><li>&gt; ���Ϥ��ˤĤ��� Q&amp;A</li></ul>';
			$page = 'delivery';
			break;
	case _DOC_ROOT.'faq/design.php':
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; <a href="/faq/">�褯�������</a></li><li>&gt; �ǥ�����ˤĤ��� Q&amp;A</li></ul>';
			$page = 'design';
			break;
	case _DOC_ROOT.'faq/items.php':
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; <a href="/faq/">�褯�������</a></li><li>&gt; ���ʤˤĤ��� Q&amp;A</li></ul>';
			$page = 'items';
			break;
	case _DOC_ROOT.'faq/order.php':
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; <a href="/faq/">�褯�������</a></li><li>&gt; ����ʸ�ˤĤ��� Q&amp;A</li></ul>';
			$page = 'order';
			break;
	case _DOC_ROOT.'faq/payment.php':
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; <a href="/faq/">�褯�������</a></li><li>&gt; ����ʧ���ˤĤ��� Q&amp;A</li></ul>';
			$page = 'payment';
			break;
	case _DOC_ROOT.'faq/printing.php':
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; <a href="/faq/">�褯�������</a></li><li>&gt; �ץ��ȤˤĤ��� Q&amp;A</li></ul>';
			$page = 'printing';
			break;
	case _DOC_ROOT.'faq/printing.php':
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; <a href="/faq/">�褯�������</a></li><li>&gt; �ѹ�������󥻥�ˤĤ��� Q&amp;A</li></ul>';
			$page = 'printing';
			break;
			

	/*
	case _DOC_ROOT.'temp/temp06.php':
			$comment = '�����������Ȥꤪ����Υ��ꥸ�ʥ륹�����åȤǤ���';
			$page = 'hold';
			break;
	*/

	case _DOC_ROOT.'calendar/calendar.php':
			$comment = '<h1>��û���Ϥ�����ư�׻��Ǥ��ޤ���</h1><p><a href="/estimate/sos.php#ad_dtl_6">ͭ�����ץ�����õ�����</a> �ǡ��ȳ����õޥ��饹��<strong>�����ž夲</strong>���ǽ��';
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; �ᤤ����û�����ž夲</li></ul>';
			$page = 'delidate';
			break;
	case _DOC_ROOT.'estimate/estimate.php':
			$comment = '<h1>���ꥸ�ʥ�ѡ��������������åȤ�������ư�׻���</h1><p>�������׻��Ǥ��ޤ�����<strong>�ץ��Ȱ��֤���ꤹ��</strong>��<strong>�������åȤ�����</strong>��<strong>���������</strong>��<strong>���������å�</strong>��<strong>��λ��</strong>��</p>';
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; ������ư�׻�</li></ul>';
			$page = 'estimation';
			break;
	case _DOC_ROOT.'estimate/sos.php':
			$comment = "<h1>ͽ�������С��� �ʤ�Ȥ��ʤ뤫�⡪</h1><p>���ꥸ�ʥ�ѡ��������������åȤ�������Let��s�����󡪡���</p>";
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; <a href="/estimate/estimate.php">������ư�׻�</a></li><li>&gt; �¤��ѡ���������΢�略</li></ul>';
			$page = 'sos';
			break;
	case _DOC_ROOT.'estimate/jumboprint.php':
			$comment = '<h1>�����ܥץ��ȡ�</h1><p>�������ϡ��ʤ�ȡ�MAX <strong">H43cm��W32cm</strong> �����祵����������ɸ��ʶȳ�ɸ��˥�������<strong">��1.5��</strong>��</p>';
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; �����ܥץ���</li></ul>';
			$page = 'jumboprint';
			break;
	case _DOC_ROOT.'customer/contact.php':
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; ���䤤��碌</li></ul>';
			$page = '';
			break;
	case _DOC_ROOT.'company/company.php':
			$comment = '<h1>��Ⱦ���</h1><p>�ʤ�ȡ����23��β�Į�ˡ�3F���ƤΥץ��ȹ���ʷ󥪥ե����ˤ��Ҥ�ä��ꤢ��ޤ����᤯���ڼ꤫�������������ĥ꡼��ݸ����Ǥ���</p>';
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; ��Ⱦ���</li></ul>';
			$page = '';
			break;
	case _DOC_ROOT.'company/factory.php':
			$comment = '<h1>�������Τ����⡣</h1><p>�ʤ�ȡ����23��β�Į�ˡ�3F���ƤΥץ��ȹ���ʷ󥪥ե����ˤ��Ҥ�ä��ꤢ��ޤ����᤯���ڼ꤫�������������ĥ꡼��ݸ����Ǥ���</p>';
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; �������</li></ul>';
			$page = '';
			break;
	case _DOC_ROOT.'company/member.php':
			$comment = '<h1>���ꡣ</h1><p>�ʤ�ȡ����23��β�Į�ˡ�3F���ƤΥץ��ȹ���ʷ󥪥ե����ˤ��Ҥ�ä��ꤢ��ޤ����᤯���ڼ꤫�������������ĥ꡼��ݸ����Ǥ���</p>';
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; ����</li></ul>';
			$page = '';
			break;
	case _DOC_ROOT.'policy/policy.php':
			$comment = '<h1>�ץ饤�Х����ݥꥷ����</h1><p>�����ϥޥ饤�ե����ȤǤϡ����Ҥ˴ط������������٤ƤθĿ;���δ������ݸ��Ż뤷�Ƥ��ޤ���</p>';
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; �ץ饤�Х����ݥꥷ��</li></ul>';
			$page = '';
			break;
	case _DOC_ROOT.'law/law.php':
			$term = date(Y)-1998;
			$comment = '<h1>���꾦���ˡ�ˤ�ȤŤ�ɽ����</h1><p>�����ϥޥ饤�ե����Ȥ��϶Ȥ�1998ǯ���ץ��ȤҤȶ�'.$term.'ǯ�μ��Ӥ�����ޤ���</p>';
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; ���꾦���ˡ</li></ul>';
			$page = '';
			break;
	case _DOC_ROOT.'sitemap/sitemap.php':
			$comment = '<h1>�����ȥޥå�</h1></p>';
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; �����ȥޥå�</li></ul>';
			$page = '';
			break;
	case _DOC_ROOT.'design/index.php':
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; �ǥ�����ƥ�ץ졼�Ƚ�</li></ul>';
			$page = 'design_temp';
			break;
	case _DOC_ROOT.'design/detail.php':
			$pan_navigation = '';
			$page = 'design_temp';
			break;
	case _DOC_ROOT.'dancer/index.php':
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; ����</li></ul>';
			$page = 'dance';
			break;
			
	case _DOC_ROOT.'lp1/index.php':
			$pan_navigation = '<ul><li><a href="/">���ꥸ�ʥ�ѡ��������������å�TOP</a></li><li>&gt; ̵������礻</li></ul>';
			$page = 'lp1';
			break;
			
	default: $comment = '';
	}


    /*	global menu
    *	2013-09-10	Ŭ��
    */
    $menu = '<ul id="gmenu">';
    
    // ���ꥸ�ʥ�ʎߎ������κ���
	$menu .= '<li>';
	
		$menu .= '<ul class="pull01">';
		
		if($page!='howto') $menu .= '<li><a href="/guide/original_parker.php" class="howto">���ꥸ�ʥ�ѡ������κ���</a></li>';
		else $menu .= '<li><p class="howto">���ꥸ�ʥ�ѡ������κ���</p></li>';
		
		if($page!='intro') $menu .= '<li class="pull"><a href="/guide/intro.php">���Ƥ�����</a></li>';
		else $menu .= '<li class="pull"><p>���Ƥ�����</p></li>';
		
		if($page!='orderflow') $menu .= '<li class="pull"><a href="/guide/guide.php">����ʸ�οʤ���</a>';
		else $menu .= '<li class="pull"><p>����ʸ�οʤ���</p>';
		
		if($page!='guide_estimate') $menu .= '<li class="pull"><a href="/guide/guide_estimate.php">�����Ѥ�λ���</a></li>';
		else $menu .= '<li class="pull"><p>�����Ѥ�λ���</p></li>';
		
		if($page!='print_guide') $menu .= '<li class="pull"><a href="/guide/print_guide.php">�ץ�����ˡ</a></li>';
		else $menu .= '<li class="pull"><p>�ץ�����ˡ</p></li>';
		
		if($page!='print_guide') $menu .= '<li class="pull"><a href="/guide/print_navi.php">�ץ��ȥʥ�</a></li>';
		else $menu .= '<li class="pull"><p>�ץ��ȥʥ�</p></li>';
		
		if($page!='faq') $menu .= '<li class="pull"><a href="/faq/">�ѡ���</a></li>';
		else $menu .= '<li class="pull"><p>�ѡ���</p></li>';
		
		if($page!='intro') $menu .= '<li class="pull"><a href="/guide/intro.php">���Τ餻</a></li>';
		else $menu .= '<li class="pull"><p>���Τ餻</p></li>';
		
		$menu .= '</ul>';
	
	$menu .= '</li>';
	
	// �����ƥ�
	$menu .= '<li>';
	
		$menu .= '<ul class="pull02">';
		$menu .= '<li><span class="items">�����ƥ�</span></li>';
		
		if($page!='lineup_parker') $menu .= '<li class="pull"><a href="/lineup/lineup_parker.php">�ѡ�����</a></li>';
		else $menu .= '<li class="pull"><p>�ѡ�����</p></li>';
		
		if($page!='lineup_trainer') $menu .= '<li class="pull"><a href="/lineup/lineup_trainer.php">�ȥ졼�ʡ�</a></li>';
		else $menu .= '<li class="pull"><p>�ȥ졼�ʡ�</p></li>';
		
		if($page!='lineup_pants') $menu .= '<li class="pull"><a href="/lineup/lineup_pants.php">�ѥ��</a></li>';
		else $menu .= '<li class="pull"><p>�ѥ��</p></li>';
		
		if($page!='lineup_setup') $menu .= '<li class="pull"><a href="/lineup/lineup_setup.php">�岼���å�</a></li>';
		else $menu .= '<li class="pull"><p>�岼���å�</p></li>';
		
		if($page!='sweat_navi') $menu .= '<li class="pull"><a href="/guide/sweat_navi.php">��狼��õ��</a></li>';
		else $menu .= '<li class="pull"><p>��狼��õ��</p></li>';
		
		if($page!='catalog') $menu .= '<li class="pull"><a href="/guide/catalog.php">������������ץ�</a></li>';
		else $menu .= '<li class="pull"><p>������������ץ�</p></li>';
		
		$menu .= '</ul>';
	
	// �ǥ�����
	$menu .= '<li>';
	
		$menu .= '<ul class="pull03">';
		$menu .= '<li><span class="design">�ǥ�����</span></li>';
		
		if($page!='design_tech') $menu .= '<li class="pull"><a href="/guide/design_tech.php">�ǥ�����κ����</a></li>';
		else $menu .= '<li class="pull"><p>�ǥ�����κ����</p></li>';
		
		if($page!='gallery') $menu .= '<li class="pull"><a href="/gallery/gallery_body.php">������</a></li>';
		else $menu .= '<li class="pull"><p>������</p></li>';
		
		if($page!='font') $menu .= '<li class="pull"><a href="/guide/font.php">�Ȥ���ե����</a></li>';
		else $menu .= '<li class="pull"><p>�Ȥ���ե����</p></li>';
		
		if($page!='ink') $menu .= '<li class="pull"><a href="/guide/ink.php">�Ȥ��륤�󥯡�������</a></li>';
		else $menu .= '<li class="pull"><p>�Ȥ��륤�󥯡�������</p></li>';
		
		if($page!='design_temp') $menu .= '<li class="pull"><a href="/design/">�ǥ�����ƥ�ץ졼��</a></li>';
		else $menu .= '<li class="pull"><p>�ǥ�����ƥ�ץ졼��</p></li>';
		
		if($page!='jumboprint') $menu .= '<li class="pull"><a href="/estimate/jumboprint.php">�����ܥץ���</a></li>';
		else $menu .= '<li class="pull"><p>�����ܥץ���</p></li>';
		
		if($page!='sheet') $menu .= '<li class="pull"><a href="/guide/sheet.php">�ǥ������ѻ�</a></li>';
		else $menu .= '<li class="pull"><p>�ǥ������ѻ�</p></li>';
		
		$menu .= '</ul>';
	
	$menu .= '</li>';
	
	// ���Ѥ�
	$menu .= '<li>';
	
		$menu .= '<ul class="pull04">';
		$menu .= '<li><span class="estimation">������</span></li>';
		
		if($page!='estimation') $menu .= '<li class="pull"><a href="/estimate/estimate.php">���Ѥ�׻�</a></li>';
		else $menu .= '<li class="pull"><p>���Ѥ�׻�</p></li>';
		
		if($page!='sos') $menu .= '<li class="pull"><a href="/estimate/sos.php">�¤��ѡ���������΢�略</a></li>';
		else $menu .= '<li class="pull"><p>�¤��ѡ���������΢�略</p></li>';
		
		$menu .= '</ul>';
		
	$menu .= '</li>';
	
	// ���Ϥ���
	if($page!='delidate') $menu .= '<li><a href="/calendar/calendar.php" class="delidate">���Ϥ����׻�<br><ins>�ᤤ����û�����ž夲</ins></a></li>';
	else $menu .= '<li><p class="delidate">���Ϥ����׻�<br><ins>�ᤤ����û�����ž夲</ins></p></li>';
	
	
	/*	header
	*	2013-09-10	Ŭ��
	*	2013-10-22	h1���ѹ�
	*/
	$header = '<div class="wrap">';
	$header .= '<div class="topline">';
	if($page=='home'){
		$header .= '<h1>���ꥸ�ʥ�ѡ������κ����ʤ饹�����åȥ���å�</h1>';
	}else{
		$header .= '<p class="header1">���ꥸ�ʥ�ѡ������κ����ʤ饹�����åȥ���å�</p>';
	}
	$header .= '<a href="/faq/" id="qanda"></a>';
	$header .= '<a href="/sitemap/sitemap.php" id="sitemap"></a>';
	$header .= '<a href="/order/?cart=1" id="cart"></a>';
	$header .= '</div>';
	$header .= '<div class="inner">';
	$header .= '<a href="/" id="logo"><img alt="���ꥸ�ʥ�ѡ��������������åȤΥ������åȥ���å�" src="/common/img/logo.png" /></a>';
	$header .= '<img alt="���䤤��碌��0120-130-428" src="/common/img/contact.png" class="contact" />';
	$header .= '<a href="/customer/contact.php" class="btn_contact"></a>';
	$header .= '</div>';
	$header .= '</div>';
	
	$header .= '<div class="gmenu_wrap">';
	$header .= $menu;
	$header .= '</div>';
	
	/* header 
	*	2012-11-16��Ŭ��
	*	2013-09-10	�ѻ�
	*
	$header = '<div class="topline">';
	if($page=='home'){
		$header .= '<h1>���ä��������ꥸ�ʥ륹�����åȤ�ѡ������κ����ϥ������åȥ���å���</h1>';
	}else{
		$header .= '<p class="header1">���ä��������ꥸ�ʥ륹�����åȤ�ѡ������κ����ϥ������åȥ���å���</p>';
	}
	$header .= '<a href="/guide/guide.php" id="guidance"></a>';
	$header .= '<a href="/company/company.php" id="aboutme"></a>';
	$header .= '<a href="/sitemap/sitemap.php" id="sitemap"></a>';
	$header .= '</div>';
	$header .= '<div class="inner">';
	$header .= '<a href="/" id="logo"><img alt="�ǥ�����Ǽ���ʤɡ��ʤ�Ǥ⤴���̲��������������åȥ���å��������������ޤ���" src="/image/logo.jpg" /></a>';
	$header .= '<img alt="���䤤��碌��0120-130-428" src="/image/contact.jpg" class="contact" />';
	$header .= '<a href="/customer/contact.php" class="btn_contact"></a>';
	$header .= '</div>';
	*/
	
	/*	header
	*	2012-11-16	�ѻ�
    $header = '<div class="mainmenu">';

    if($page=='home') $header .= '<p class="home"></p>';
    else $header .= '<a class="home" href="/"></a>';

    if($page=='gallery') $header .= '<p class="gallery"></p>';
    else $header .= '<a class="gallery" href="/gallery/gallery_body.php"></a>';

    if($page=='lineup') $header .= '<p class="lineup"></p>';
    else $header .='<a class="lineup" href="/lineup/lineup_parker.php"></a>';

    if($page=='guide') $header .= '<p class="guide"></p>';
    else $header .='<a  class="guide" href="/guide/guide.php"></a>';

    if($page=='faq') $header .= '<p class="faq"></p>';
    else $header .='<a  class="faq" href="/faq/cost.php"></a>';

    if($page=='schedule') $header .= '<p class="delidate"></p>';
    else $header .='<a class="delidate" href="/calendar/calendar.php"></a>';

    if($page=='estimation') $header .= '<p class="estimation"></p>';
    else $header .='<a class="estimation" href="/estimate/estimate.php"></a>';

    $header .= '</div>';
    */
    
    
    /* global menu
    	2012-11-16���ɲ�
    	2013-09-10	�ѻ�
    
	$menu = '<ul id="gmenu">';
	
	if($page!='orderflow') $menu .= '<li><a href="/guide/guide.php" id="orderflow"></a></li>';
	else $menu .= '<li><p id="orderflow"></p></li>';
	
	if($page!='lineup') $menu .= '<li><a href="/lineup/lineup_'.$itemis.'.php" id="lineup"></a></li>';
	else $menu .= '<li><p id="lineup"></p></li>';
	
	if($page!='designtech') $menu .= '<li><a href="/guide/design_tech.php" id="design"></a>';
	else $menu .= '<li><p id="design"></p>';
	
		$menu .= '<ul>';
		if($page!='gallery') $menu .= '<li><a href="/gallery/gallery_body.php" id="designsample"></a></li>';
		else $menu .= '<li><p id="designsample"></p></li>';
		$menu .= '</ul>';
	
	$menu .= '</li>';
	
	if($page!='estimation') $menu .= '<li><a href="/estimate/estimate.php" id="price"></a></li>';
	else $menu .= '<li><p id="price"></p></li>';
	
	if($page!='schedule') $menu .= '<li><a href="/calendar/calendar.php" id="delivery"></a></li>';
	else $menu .= '<li><p id="delivery"></p></li>';
	
	if($page!='printing') $menu .= '<li><a href="/guide/guide_3days.php" id="print"></a>';
	else $menu .= '<li><p id="print"></p>';
	
		$menu .= '<ul>';
		if($page!='jumboprint') $menu .= '<li><a href="/estimate/jumboprint.php" id="jumboprint"></a></li>';
		else $menu .= '<li><p id="jumboprint"></p></li>';
		$menu .= '</ul>';
	
	$menu .= '</li>';
	
	if($page!='faq') $menu .= '<li><a href="/faq/cost.php" id="faq"></a></li>';
	else $menu .= '<li><p id="faq"></p></li>';
	$menu .= '</ul>';
	*/
	
	
	/*	message bar 
	*	2012-11-16���ɲ�
	*/
	if(!empty($comment)){
		$msgbar .= '<div class="messagebar"><div>'.$comment.'</div>';
		if(!empty($pan_navigation)){
			$msgbar .= $pan_navigation;
		}
		$msgbar .= '</div>';
	}else if(!empty($pan_navigation)){
		$msgbar = '<div class="messagebar">'.$pan_navigation.'</div>';
	}


    /* navigation bar */
    if(!empty($gnavi)){
    	if(isset($_SESSION['orders']['item'])){
			$refpage = $_SESSION['orders']['item']['refpage'];	// ��ʸ���ϥڡ����ؤΥѥ�
		}
		
		/* 2012-12-31 ��ʸ�ե����˥塼����
		if(!$isTest){
			$navi_info = array(	array("�饤��ʥå�","/lineup/lineup_parker.php"),
		    					array("�������å�����","/lineup/lineup_parker.php"),
		    					array("����ʸ������",$refpage),
		    					array("���Ϥ��������","/order/register.php"),
		    					array("����ʸ���Ƥγ�ǧ","/order/confirm.php"),
		    					array("��������λ��","/order/finish.php")
		    					);
		    $menu .= '<div class="global_navi '.$gnavi.'"><ul>';
		    $menu .= '<li><a href="/">HOME</a></li>';
		    $navi_id = substr($gnavi, -1)+1;
		    for($i=0; $i<6; $i++){
		    	if($i<$navi_id){
		    		$cls[$i] = "pass";
		    		$navi_page = '<a href="'.$navi_info[$i][1].'">'.$navi_info[$i][0].'</a>';
		    	}else if($i==$navi_id){
		    		$cls[$i] = "curr";
		    		$navi_page = $navi_info[$i][0];
		    	}else{
		    		$cls[$i] = "none";
		    		$navi_page = $navi_info[$i][0];
		    	}
		    	$menu .= '<li class="'.$cls[$i].'">'.$navi_page.'</li>';
		    }
		    $menu .= '</ul></div>';
	    }else{
	    */
	    
		    $navi_info = array(	array("����ʸ������",$refpage),
		    					array("���Ϥ��������","/order/register.php"),
		    					array("����ʸ���Ƥγ�ǧ","/order/confirm.php"),
		    					array("����ʸ�ο���","/order/finish.php")
		    					);
		    									
		    $order_navi .= '<div class="global_navi '.$gnavi.'"><ul class="crumbs">';
		    $navi_id = substr($gnavi, -1)-1;
		    if($navi_id==3){
		    // �������ߴ�λ
		    	for($i=0; $i<3; $i++){
			    	$order_navi .= '<li><p>'.$navi_info[$i][0].'</p></li>';
			    }
			    $order_navi .= '<li class="fin"><p>'.$navi_info[$i][0].'</p></li>';
		    }else{
		    	for($i=0; $i<4; $i++){
			    	if($i<$navi_id){
			    		$cls[$i] = "pass";
			    		$navi_page = '<a href="'.$navi_info[$i][1].'">'.$navi_info[$i][0].'</a>';
			    	}else if($i==$navi_id){
			    		$cls[$i] = "curr";
			    		$navi_page = '<p>'.$navi_info[$i][0].'</p>';
			    	}else{
			    		$cls[$i] = "none";
			    		$navi_page = '<p>'.$navi_info[$i][0].'</p>';
			    	}
			    	$order_navi .= '<li class="'.$cls[$i].'">'.$navi_page.'</li>';
			    }
			}
			$order_navi .= '</ul></div>';
			
	   // }
    }


	/*	footer
	*	2013-09-10	Ŭ��
	*	2013-10-29	�����ƥ�˥ȥ졼�ʡ������㥱�åȡ������ԥ���Υ��ƥ�����ɲ�
	*/
	$footer = '<div class="wrap">';
	$footer .= '<div class="clearfix">';
	$footer .= '<ul><li><p class="guidance">��������</p></li><li><a href="/guide/intro.php">���Ƥ�����</a></li><li><a href="/guide/guide.php">����ʸ��ή��</a></li><li><a href="/faq/">�ѡ���</a></li>';
	$footer .= '<li><p>��</p></li><li><p class="orderflow">������ͻ�</p></li><li><a href="/guide/guide_3days.php">���ʤ��Ǥ���ޤ�</a></li></ul>';
	$footer .= '<ul><li><p class="itemlist">�����ƥ����</p></li><li><a href="/lineup/lineup_parker.php">�ѡ�����</a></li><li><a href="/lineup/lineup_trainer.php">�ȥ졼�ʡ�</a></li><li><a href="/lineup/lineup_pants.php">�ѥ��</a></li><li><a href="/lineup/lineup_setup.php">�岼���å�</a></li><li><a href="/lineup/lineup_jacket.php">���㥱�å�</a></li><li><a href="/lineup/lineup_champion.php">�����ԥ���</a></li><li><a href="/guide/sweat_navi.php">��狼��õ��</a></li><li><a href="/guide/catalog.php">������������ץ�</a></li></ul>';
	$footer .= '<ul><li><p class="design">�ǥ�����</p></li><li><a href="/guide/design_tech.php">�ǥ�����κ����</a></li><li><a href="/gallery/gallery_body.php">������</a></li><li><a href="/guide/font.php">�Ȥ���ե����</a></li><li><a href="/guide/ink.php">�Ȥ��륤�󥯡�������</a></li><li><a href="/design/">�ǥ�����ƥ�ץ졼�Ƚ�</a></li><li><a href="/estimate/jumboprint.php">�����ܥץ���</a></li><li><a href="/guide/sheet.php">�ǥ������ѻ���������</a></li></ul>';
	$footer .= '<ul><li><p class="price">����</p></li><li><a href="/estimate/estimate.php">���Ѥ�׻�</a></li><li><a href="/guide/guide_estimate.php">�����Ѥ�λ���</a></li><li><a href="/guide/discount.php">�������</a></li><li><a href="/law/law.php#payment">����ʧ��ˡ</a></li><li><a href="/faq/cancel.php">�ѹ�������󥻥�</a></li></ul>';
	$footer .= '<ul><li><p class="delivery">���Ϥ�</p></li><li><a href="/calendar/calendar.php">��������ǧ</a></li><li><a href="/calendar/calendar.php#rescue1">�õ޻ž夲</a></li>';
	$footer .= '<li><p>��</p></li><li><p class="printing">�ץ�����ˡ</p></li><li><a href="/guide/print_guide.php">�ץ��Ȥ���ħ���㤤</a></li><li><a href="/guide/print_navi.php">��狼������</a></li></ul>';
	$footer .= '<ul><li><p class="company">��Ⱦ���</p></li><li><a href="/company/company.php">��Ⱦ���</a></li><li><a href="/company/factory.php">���츫��</a></li><li><a href="/law/law.php">���꾦���ˡ</a></li><li><a href="/policy/policy.php">�ץ饤�Х����ݥꥷ��</a></li></ul>';
	$footer .= '</div>';
	$footer .= '<div class="inner">';
	$footer .= '<div class="logo"><img alt="�����ϥޥ饤�ե�����" src="/common/img/logo_footer.png" /></div>';
	$footer .= '<img alt="���䤤��碌��0120-130-428" src="/common/img/contact.png" class="contact" />';
	$footer .= '<a href="/customer/contact.php" class="btn_contact"></a>';
	$footer .= '</div>';
	$footer .= '<p>Copyright &copy; '.date(Y).'  <a href="/">���ꥸ�ʥ�ѡ��������������åȤΥ������åȥ���å�</a> All rights reserved.</p>';
	$footer .= '</div>';
	
	
    /* footer 
    *	2012-11-16���ѹ�
    *	2013-09-10	�ѻ�
    *
    $footer = '<ul><li><a href="/">�ۡ���</a></li><li><a href="/guide/guide.php">����ʸ��ή��</a></li><li><a href="/lineup/lineup_parker.php">�����ƥ����</a></li><li><a href="/gallery/gallery_body.php">�ǥ�������</a></li><li><a href="/estimate/estimate.php">����ˤĤ���</a></li><li><a href="/guide/design_tech.php">�ǥ�����ˤĤ���</a></li><li><a href="/guide/guide_3days.php">�ù��ˤĤ���</a></li></ul>';
    $footer .= '<ul><li><a href="/dance/">���ꥸ�ʥ���󥹥������å�</a></li><li><a href="/guide/guide.php">���Ƥ�����</a></li><li><a href="/faq/cost.php">�褯�������</a></li><li><a href="/customer/contact.php" >���������</a></li></ul>';
    $footer .= '<ul><li><a href="/company/company.php" >��Ⱦ���</a></li><li><a href="/policy/policy.php" >�ץ饤�Х����ݥꥷ��</a></li><li><a href="/law/law.php" >���꾦���ˡ</a></li><li><a href="/sitemap/sitemap.php" >�����ȥޥå�</a></li></ul>';
    $footer .= '<p class="logo"><img alt="�����ϥޥ饤�ե�����" src="/image/footer_logo.jpg" /></p>';
    $footer .= '<div class="contact_inner">';
	$footer .= '<img alt="���䤤��碌��0120-130-428" src="/image/contact.jpg" class="contact" />';
    $footer .= '<a href="/customer/contact.php" class="btn_contact"></a>';
    $footer .= '<p>����Գ�����������䣳-����-����</p>';
	$footer .= '</div>';
	$footer .= '<p>Copyright &copy; '.date(Y).'  <a href="/">���ꥸ�ʥ�ѡ��������������åȤΥ����ϥޥ饤�ե�����</a> All rights reserved.</p>';
	*/
	
    /*	footer
    *	2013-11-16	�ѻ�
    $footer = '<div>';
    $footer .= '<ul><li><a href="/customer/contact.php" >���������</a></li><li><a href="/company/company.php" >��Ⱦ���</a></li><li><a href="/policy/policy.php" >�ץ饤�Х����ݥꥷ��</a></li><li><a href="/law/law.php" >���꾦���ˡ</a></li><li><a href="/sitemap/sitemap.php" >�����ȥޥå�</a></li><li><a href="http://www.takahama428.com/" >���ꥸ�ʥ�T����ĺ���</a></li></ul>';
    $footer .= '<p>Copyright &copy; '.date(Y).'  <a href="/">���ꥸ�ʥ륹�����åȤΥ����ϥޥ饤�ե�����</a> All rights reserved.</p>';
    $footer .= '</div>';
    */
    


    /* ���󥯤Υ����ɤȥ���̾ */
    $inkcolors['c21'] = '�ۥ磻��';
    $inkcolors['c22'] = '�֥�å�';
    $inkcolors['c23'] = '���������졼';
    $inkcolors['c24'] = '�饤�ȥ��졼';
    $inkcolors['c25'] = '��ǥ��å���';
    $inkcolors['c26'] = '��å�';
    $inkcolors['c27'] = '�ۥåȥԥ�';
    $inkcolors['c28'] = '�饤�ȥԥ�';
    $inkcolors['c29'] = '�����';
    $inkcolors['c30'] = '����ե�';
    $inkcolors['c31'] = '������';
    $inkcolors['c32'] = '���������꡼��';
    $inkcolors['c33'] = '���꡼��';
    $inkcolors['c34'] = '���������꡼��';
    $inkcolors['c35'] = '�ͥ��ӡ�';
    $inkcolors['c36'] = '�֥롼';
    $inkcolors['c37'] = '���å���';
    $inkcolors['c38'] = '�ѡ��ץ�';
    $inkcolors['c39'] = '�������֥饦��';
    $inkcolors['c40'] = '�饤�ȥ֥饦��';
    $inkcolors['c41'] = '����С�';
    $inkcolors['c42'] = '�������';
    $inkcolors['c43'] = '���꡼��';
    $inkcolors['c44'] = '��ե�å����֥롼';
    $inkcolors['c45'] = '�ָ�������';
    $inkcolors['c46'] = '�ָ������';
    $inkcolors['c47'] = '�ָ��ԥ�';
    $inkcolors['c48'] = '�ָ��֥롼';
    $inkcolors['c49'] = '�ָ����꡼��';
    $inkcolors['c50'] = '������ɥ�����';
    $inkcolors['c51'] = '�磻���å�';
    $inkcolors['c52'] = '�Х�����å�';
    $inkcolors['c53'] = '���������';
    $inkcolors['c54'] = '���꡼��';
    $inkcolors['c55'] = '���ץꥳ�å�';
    $inkcolors['c56'] = '��٥����';
    $inkcolors['c57'] = '������ɥ��꡼��';
    $inkcolors['c58'] = '���饹���꡼��';
    $inkcolors['c59'] = '�饤��';
    $inkcolors['c60'] = '�ѥ��ƥ륤����';
    $inkcolors['c61'] = '�ե�å���';
    $inkcolors['c62'] = '�饤��å�';
    $inkcolors['c63'] = '�ߥ�ȥ��꡼��';
    $inkcolors['c64'] = '�ڡ��륰�꡼��';
    $inkcolors['c65'] = '�١�����';
    $inkcolors['c66'] = '���ȥ�';
    $inkcolors['c67'] = '�������ԥ�';
    $inkcolors['c68'] = '�ԥ�';
    $inkcolors['c69'] = '��٥�������쥤';
    $inkcolors['c70'] = '���꡼��ƥ�';
    $inkcolors['c71'] = '����å��󥰥ԥ�';


    /* �ե���� */
    $font_lang = array( "ja"=>"��ʸ", "en"=>"��ʸ");
    $font_type = array( 'basic'=>'����',
						'brush'=>'������',
						'pop'=>'�ݥå�',
						'retro'=>'��ȥ�',
						'others'=>'����¾',
						'impact'=>'����ѥ���',
						'sports'=>'���ݡ���',
						'art'=>'������'
    );
    $font_name = array(	 'AMOSN___'=>'���⥹',
						 'C018016D'=>'�����ѡ�',
						 'CAVEMAN_'=>'�������ޥ�',
						 'DEFECAFO'=>'�ǥ��ե���',
						 'FATASSFI'=>'�ե��å�',
						 'GRAFFITI'=>'����ե��ƥ���',
						 'jaggyfries'=>'���㥮��',
						 'american-bold'=>'����ꥫ��',
						 'american-med'=>'�ߥǥ�����',
    					 'HORSERADISH'=>'�ۡ�����ǥ��å���',
						 'Plain Germanica'=>'���㡼�ޥ˥�',
						 'amsterdam'=>'���ॹ�ƥ����',
						 'Daft Font'=>'���ե�',
						 'Megadeth'=>'�ᥬ�ǥ�',
						 'MISFITS_'=>'�ߥ��ե��å�',
						 'NITEMARE'=>'�ʥ��ȥᥢ��',
						 'RUFA'=>'�롼�ե�',
						 'renaissance'=>'��ͥå���',
						 'WREXHAM_'=>'�쥯�ϥ�',
						 'AMAZR___'=>'���ᥤ��',
						 'AppleGaramond'=>'���åץ�',
						 'MarketingScript'=>'�ޡ����ƥ���',
						 'Anderson'=>'�����������',
						 'CloisterBlack'=>'���ꥹ����',
						 'Army'=>'�����ߡ�',
						 'ENGLN___'=>'���󥰥���',
						 'judasc__'=>'�������',
						 'allstar'=>'�����륹����',
						 'COLLEGEB'=>'����å�',
						 'DEFTONE'=>'�ǥեȡ���',
						 'varsity_regular'=>'�С����ƥ�',
						 'ARCADEPI'=>'�������ǥԥå���',
						 'NIRVANA'=>'�˥�С���',
						 'vintage'=>'������ơ���',
						 'Yahoo'=>'��ա�',
						 'GREMSN__'=>'�������',
						 'LCD2N___'=>'LCD',
						 'DFGOTC'=>'���������å�',
						 'DFKAI9'=>'����ܴ��',
						 'DFMINC'=>'������ī',
						 'CRBajoka-R'=>'�Х��祫',
						 'DCKGMC'=>'��',
						 'DCYSM7'=>'����',
						 'DFSGYO5'=>'����Խ�',
						 'KswGoryuNew'=>'��ζ',
						 'samurai'=>'����餤',
						 'SMODERN'=>'���¥����',
						 'DFCRS9'=>'����ե���',
						 'DFMRGC'=>'�����ݥ����å�',
						 'DFMRM9'=>'�ޤ�⤸',
						 'nipple'=>'�˥åץ�',
						 'DFRULE7'=>'ή��',
						 'DFSHT7'=>'����Ƥ�',
						 'DFSOGE7'=>'��������'
    );

	$hashFontInfo = array('lang'=>$font_lang, 'type'=>$font_type, 'name'=>$font_name);

    /* ���åץ����� */
    require dirname(__FILE__)."/upload.php";
?>