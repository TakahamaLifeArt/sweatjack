/*
 * Takahama Life Art
 * JavaScript Library(euc-jp)  jumboprint module
 *
 * Copyright 2010, Takahama Life Art
 *
 * Date: Thu March 10 00:00:00 2010
 * Log: 20160-09-21 �ץ�����׻������򹹿�
 */

jQuery(function($){

	// �����ƥ���ѹ�
	$('.item_selector').change(function(){
		var id = $(this).attr('id');
		//var item_id = $(this).val();
		//var isGirl = $(this).children('option:selected').is('.gl')? 1: 0;
		var item_code = $(this).children('option:selected').text().split(' ')[0].toLowerCase();
		var src = $('#'+id+'_image').attr('src');
		var code = $(this).children('option:selected').attr('data-code');
		var pattern = (id=='t-shirts' || id=='outer')? id: 'sweat';
		var len = pattern.length + 2;
		src = src.slice(0, src.lastIndexOf('/'+pattern+'/')+len) + item_code + '/' + item_code + '_'+code+'.jpg';
		$('#'+id+'_image').attr('src', src);

		$.estimate.silk(this);
	});


	// ����ȥ��󥯤ο���
	$('input[type="text"]', '.calc_wrapper').keypress( function(e){
		$(this).restrictKey(e,'num');
    }).focus( function(){
    	var c = this.value;
      	this.value = c.replace(/,/g, '');
    	var self = this;
	    $(self).select();
	}).blur( function(){
    	var c = this.value;
    	this.value = $.addFigure(c);
    	$.estimate.silk(this);
    }).change(function(){
    	this.blur();
    });


	/* ���󥯥ѥ�åȤ�ɽ�� */
	$('.show_ink').on("click", function(){
		$.ink_selector = $(this).siblings('select');
		$.show_ink($.ink_selector.attr('id').slice(5));
	});


	// �ܥ���Υ֥�󥯽���
	$('a.to_sos, a.send_mail, a.print_out').mouseenter( function(){
		$(this).effect('pulsate',{'times':2},200);
	});


	// ���ɽ����1��1���θ��Ѥ�ɽ��
	$(window).one('load', function(){
		$('.wrap_2 select').each( function(){
			$.estimate.silk(this);
		});
	});


	/*
	 * ���Ѥ�׻�
	 * ���Ѥ��ۤΥǥ�����ɽ��
	 * ���å�������Ͽ
	 */
    jQuery.extend({
    	estimate: {
    		silk: function(my){
    			/*
    			 * ������	L(ID 20)
    			 * ���顼	��
    			 * �˸���
    			 */
    			var tbl = $(my).closest('table');
    			var pos = tbl.attr('id').split('_')[2];
//		    	var area = [1];
//				var extra = [1];
    			var ink = tbl.find('.ink').val() - 0;
    			if (ink<1) {
    				if (!$(my).is('.item_selector')) $.msgbox('���󥯤ο�������ꤷ�Ʋ�������');
    				return;
    			}
    			var amount = tbl.find('.amount').val();
    			if (amount<1) {
    				if(!$(my).is('.item_selector')) $.msgbox('�����������ꤷ�Ʋ�������');
    				return;
    			}
    			var item_id = tbl.find('select').val();
    			var itemprice = 0;		// ������
//    			var print_fee = [];		// �ץ������0���̾�	1���������ǡ�
    			var cost = [];			// ��׶�ۡ�0���̾�	1���������ǡ�
				
				var ids = {};
					ids[item_id] = amount;
				var argsNormal = {'vol':amount, 'ink':ink, 'ids':ids, 'size':0};
				var argsJumbo = {'vol':amount, 'ink':ink, 'ids':ids, 'size':1};

				$.when(
					$.getJSON($.TLA.api+'?callback=?', {'act':'price', 'itemid':item_id, 'amount':amount, 'output':'jsonp'}),
					$.getJSON($.TLA.api+'?callback=?', {'act':'printfee2', 'printmethod':'silk', 'args':argsNormal, 'output':'jsonp', 'curdate':'2017-05-25'}),
					$.getJSON($.TLA.api+'?callback=?', {'act':'printfee2', 'printmethod':'silk', 'args':argsJumbo, 'output':'jsonp', 'curdate':'2017-05-25'})
				).then(function(r1, r2, r3){
					if (!r1 || !r2 || !r3) {
						$.msgbox('�̿����顼�� �ǡ����μ����˼��Ԥ��ޤ�����');
						return;
					}
					for (var i=0; i<r1[0].length; i++) {
						if (r1[0][i]['sizeid']==20) {
							itemprice = amount * (r1[0][i]['price_white'] - 0);
							break;
						}
					}
					
					// �̾�
					var fee = r2[0]['tot']-0;
					tbl.find('.regular').children('p').children('span').text($.addFigure(itemprice+fee));
					cost[0] = Math.round( ((itemprice+fee)*(1+_TAX)) / amount );
					$('#regular_price_'+pos).text($.addFigure(cost[0]));

					// ������
					fee = r3[0]['tot']-0;
					tbl.find('.jumbo').children('p').children('span').text($.addFigure(itemprice+fee));
					cost[1] = Math.round( ((itemprice+fee)*(1+_TAX)) / amount );
					$('#jumbo_price_'+pos).text($.addFigure(cost[1]));
					
					// ����
					var plus = cost[1] - cost[0];
					$('#plus_'+pos).text($.addFigure(plus));
					$('#regular_price_'+pos+', #jumbo_price_'+pos).effect('pulsate',{'times':3},200);
				});
	    	}
    	},
    	digits:function($target, args, setup){
    		var price = $target.text().replace(/,/g,"") - 0;	// ���ζ��
			var plus = Math.abs(args - price);					// ����
			if(plus==0){
				// SET UP ��פΤߤ򹹿�
				if( setup!=($('#setup_estimation').text()-0) ){
	    			$('#setup_estimation').text($.addFigure(setup)).effect('pulsate',{'times':3},250, function(){
	    				$(this).removeAttr('style');	// IE��ʸ�����Ĥ�Τǥ��ե����ȸ�˺������
	    			});
				}
				return;
			}
			var limit = 10;										// �񴹤�����
			var inc = 0;										// ����������
			var strUA = navigator.userAgent.toLowerCase();		// �֥饦�����̤���٤Υ桼������������Ȥ����
			if(strUA.indexOf("msie") != -1){					// �񴹤�������Ĵ������
				limit = 40;
				inc = 25;
			}else if(strUA.indexOf("firefox") != -1){
				limit = 40;
				inc = 25;
			}else{
				limit = 100;
				inc = 10;
			}
			if(plus<=1000){										// ���ۤ�¿�ɤ��¹Ի��֤˱ƶ����ʤ��褦��Ĵ��
				limit = Math.floor(plus / inc);
			}else{
				inc = Math.floor(plus / limit);
			}
			if(args-price<0){ inc = -1*inc; }					// ��ۤ�������
			var str = 0;										// ����ڤ�Ѥߤ�ɽ�����
			var cnt = 0;										// ���󥯥���Ȳ��
			var intervalID = setInterval( function(){			// 1�ߥ��ä��Ȥ˼¹�
			    price += inc;
				str = new String(price);
				while(str != (str = str.replace(/^(-?\d+)(\d{3})/, "$1,$2")));
				$target.text(str);
				cnt++;
				if(cnt>=limit){
					clearInterval(intervalID);
					$target.text($.addFigure(args));
					// SET UP ��פ򹹿�
	    			$('#setup_estimation').text($.addFigure(setup)).effect('pulsate',{'times':3},250, function(){
	    				$(this).removeAttr('style');	// IE��ʸ�����Ĥ�Τǥ��ե����ȸ�˺������
	    			});
				}
			},1);
    	}
    });


});