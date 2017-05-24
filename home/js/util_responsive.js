/*!
 * Takahama Life Art
 * JavaScript Library(euc-jp)
 *
 * Copyright 2010, Takahama Life Art
 *
 * Date: Sat July 17 00:00:00 2010
 */

/**************************************************************
*		外部ソースの読込
***************************************************************/
$.ajaxSetup({scriptCharset:'utf-8'});
$.getScript('../js/phonehash.js');

jQuery(function($){

 	/* 入力エリアに透かし文字で説明を表示 */
 	$.updnWatermark.attachAll();

 	/* 入力制御 */
 	jQuery.fn.extend({
 		setAddress: function(target){	/* 都道府県から市区町村一覧を取得 */
 			var val = $(this).val();
 			if(val==""){
 				target.html('<option value="" selected="selected">---</option>');
 				return this;
 			}
			target.html('<option value="" selected="selected">--- 取得中 ---</option>');
			$.ajax({url:'../../app-def/getAddr.php', type:'POST', dataType:'text', async:false,
				data: {'mode':'word', 'parm':val, 'city':true}, timeout:3000,
				success:function(r){
					var addr = "";
					var list = '<option vlaue="" selected="selected">---</option>';
					var lines = r.split(';');
					if(lines.length>1){
						for(var i=0; i<lines.length; i++){
							list += '<option value="'+lines[i]+'">'+lines[i]+'</option>';
						}
						target.html(list);
					}else{
						target.html('<option value="" selected="selected">---</option>');
						alert('通信エラーです。');
					}

					return this;
				},
				error: function(XMLHttpRequest, textStatus, errorThrown){
					alert('通信エラーです。'+textStatus);
					return this;
				}
			});
 		},
		restrictKey: function(e, mode){
			var code=(e.charCode) ? e.charCode : ((e.which) ? e.which : e.keyCode);
			switch(mode){
			case 'num':
				if (   !e.ctrlKey 				// Ctrl+?
			        && !e.altKey 				// Alt+?
			        && code != 0 				// ?
			        && code != 8 				// BACKSPACE
			        && code != 9 				// TAB
			        && code != 13 				// Enter
			        && code != 37 && code != 39 // ←→
			        && code != 46				// Delete
			        && (code < 48 || code > 57)) // 0..9
			    	//e.preventDefault();

			    if(code == 13 || code == 3) this.change();
		    	break;
		    case 'date':
				if (   !e.ctrlKey 				// Ctrl+?
			        && !e.altKey 				// Alt+?
			        && code != 0 				// ?
			        && code != 8 				// BACKSPACE
			        && code != 9 				// TAB
			        && code != 13 				// Enter
			        && code != 37 && code != 39 // ←→
			        && code != 46				// Delete
			        && (code < 47 || code > 57)) // 0..9 /
			    	//e.preventDefault();

			    if(code == 13 || code == 3) this.change();
		    	break;
		    }

		    return this;
		}
	});


	// 桁区切り数値に変換
    $('.forNumeric_2').keypress(function(e) {
		$(this).restrictKey(e, 'num');
    }).focus( function(){
    	var c = this.value;
      	this.value = c.replace(/,/g, '');
      	var self = this;
      	$(self).select();
    }).blur(function(){
    	var c = this.value;
    	this.value = $.addFigure(c);
    }).change(function(){
    	this.blur();
    });

	// 数値のみ（全角半角）それ以外はブランクにする
	$('.forNumeric_3').keypress(function(e) {
		$(this).restrictKey(e,'num');
    }).blur(function(){
		var c = this.value.replace(/[０-９]/g, function(m){
    				var a = "０１２３４５６７８９";
	    			var r = a.indexOf(m);
	    			return r==-1? m: r;
	    		});
    	this.value = c.match(/^\d+$/)? c-0: '';
    }).change(function(){
    	this.blur();
    });

   // tel and fax mask 
	$(window).on('keypress', '.forPhone, .phone',function(e) {
		$(this).restrictKey(e,'num');
    }).on('focusin', '.forPhone, .phone', function(){
    	$.restrict_num(13, this);
    }).on('focusout', '.forPhone, .phone', function(e){
    	var res = $.phone_mask(this.value); 
    	this.maxLength = res.l;
    	this.value = res.c
    });

   // zipcode mask
	$(window).on('keypress', '.forZip', function(e) {
		$(this).restrictKey(e,'num');
    }).on('focusin', '.forZip', function(){
    	$.restrict_num(8, this);
    }).on('focusout', '.forZip', function(e){
    	this.maxLength = 8;
    	this.value = $.zip_mask(this.value);
    });


	/* このページのトップに戻る */
	$('.page_top span, .page_top2 span').click(function(){
 		$('html,body').animate({ scrollTop: '0px' }, 1000, 'easeInOutExpo');
 	});

 	/* アンカーでスムーズにスクロール */
 	$('a[href*=#]').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
            var $target = $(this.hash);
            $target = $target.length && $target || $('[name=' + this.hash.slice(1) +']');
            if ($target.length) {
            	var targetOffset = $target.offset().top;
            	if(!$.support['cssFloat']){		/* IE */
                	//targetOffset += $('html').scrollTop();
                }
                //$($.browser.opera ? document.compatMode == 'BackCompat' ? 'body' : 'html' :'html,body')
                $('html,body').animate({ scrollTop: targetOffset }, 1000, 'easeInOutExpo');
                return false;
            }
        }
    });
    
    
    /* グローバルメニューのプルダウン
	$('#gmenu > li').hover(
		function(){$('ul',this).stop(false,true).slideDown('normal');},
		function(){$('ul',this).stop(false,true).slideUp('fast');}
	);
	*/
	$("#gmenu li ul").hover(
		function(){
			var h = $('li', this).length * 35 + 34;
			$(this).stop().animate({height:h+'px'},{queue:false,duration:300});
		},
		function(){
			$(this).stop().animate({height:'69px'},{queue:false,duration:300});
		}
	);
	

});


/***************************************************
*		アニメーション拡張
*/
jQuery.extend( jQuery.easing, {
	def: 'easeOutQuad',
	swing: function (x, t, b, c, d) {
		//alert(jQuery.easing.default);
		return jQuery.easing[jQuery.easing.def](x, t, b, c, d);
	},
	easeOutQuad: function (x, t, b, c, d) {
		return -c *(t/=d)*(t-2) + b;
	},
	easeInExpo: function (x, t, b, c, d) {
		return (t==0) ? b : c * Math.pow(2, 10 * (t/d - 1)) + b;
	},
	easeOutExpo: function (x, t, b, c, d) {
		return (t==d) ? b+c : c * (-Math.pow(2, -10 * t/d) + 1) + b;
	},
	easeInOutExpo: function (x, t, b, c, d) {
		if (t==0) return b;
		if (t==d) return b+c;
		if ((t/=d/2) < 1) return c/2 * Math.pow(2, 10 * (t - 1)) + b;
		return c/2 * (-Math.pow(2, -10 * --t) + 2) + b;
	}
});


/***************************************************
*		アイテムカラーのスライダー
*/
jQuery.fn.slideviewer = function( settings ) {
	settings = jQuery.extend({
        headline : "slider",
        speed : "normal",
		slideBy : 2
    }, settings);
    return this.each(function() {
		jQuery.fn.slideviewer.run( jQuery( this ), settings );
    });
};

jQuery.fn.slideviewer.run = function( $this, settings ) {
	var ul = jQuery( "ul:eq(0)", $this );
	var li = ul.children();
	var adjust = 10;	/* 10 is border 1px + margin 1px + padding 8px */
	var $next = jQuery( ".next_slider", $this );
	var $back = jQuery( ".back_slider", $this );
	$back.css( "display", "none" );
	$next.css( "display", "none" );
	if ( li.length > settings.slideBy ) {
		var liWidth = jQuery( li[0] ).width()+adjust;
		var animating = false;
		ul.css( "width", ( li.length * liWidth ) );
		$next.click(function() {
			if ( !animating ) {
				animating = true;
				offsetLeft = parseInt( ul.css( "left" ) ) - ( liWidth * settings.slideBy );
				if ( offsetLeft + ul.width() > 0 ) {
					$back.css( "display", "block" );
					ul.animate({
						left: offsetLeft
					}, settings.speed, function() {
						if ( parseInt( ul.css( "left" ) ) + ul.width() <= liWidth * settings.slideBy ) {
							$next.css( "display", "none" );
						}
						animating = false;
					});
				} else {
					animating = false;
				}
			}
			return false;
		});
		$back.click(function() {
			if ( !animating ) {
				animating = true;
				offsetRight = parseInt( ul.css( "left" ) ) + ( liWidth * settings.slideBy );
				if ( offsetRight + ul.width() <= ul.width() ) {
					$next.css( "display", "block" );
					ul.animate({
						left: offsetRight
					}, settings.speed, function() {
						if ( parseInt( ul.css( "left" ) ) == 0 ) {
							$back.css( "display", "none" );
						}
						animating = false;
					});
				} else {
					animating = false;
				}
			}
			return false;
		});
		
		$next.css( "display", "block" );
	}
};


/***************************************************
*		checker チェック用画像の操作
*/
jQuery.fn.extend({
	checker: function(fn){
		$(this).mouseover( function(){
			var check = $(this).find('.check');
			if(!check.is('.current')) check.css('top', '-45px');
		}).mouseout( function(){
			var check = $(this).find('.check');
			if(!check.is('.current')) check.css('top', '-25px');
		}).click( fn );
		return $(this);
	},
	slide_checker: function(fn, $target){
		$(this).mouseover( function(){
			var check = $(this).find('.check');
			var code = $(this).parent().attr('class').substr(1);
			if(!check.is('.current')) check.css('top', '-45px');
			$target[0].text(check.attr('alt'));
		}).mouseout( function(){
			var check = $(this).find('.check');
			if(!check.is('.current')) check.css('top', '-25px');
			$target[0].text($target[1].color_name);
		}).click( fn );
		return this;
	}
});


/***************************************************
*		入力エリアの透かし文字
*/
(function($) {
    $.fn.updnWatermark = function(options) {
        options = $.extend({}, $.fn.updnWatermark.defaults, options);
        return this.each(function() {
            var $input = $(this);
			// Checks to see if watermark already applied.
            var $watermark = $input.data("updnWatermark");
            // Only create watermark if title attribute exists
            if (!$watermark && this.title) {
            	$watermark = this.title;
            	$input.data("updnWatermark", $watermark);

            }
			// Hook up blur/focus handlers to show/hide watermark.
            if ($watermark) {
                $input
                    .focus(function(ev) {
                    	var c = this.value.trim();
                    	if(c==$watermark){
                    		$input.val("").css('color','#333');
                    	}
                    })
                    .blur(function(ev) {
                        if (!$(this).val()) {
                            $input.val($watermark).css('color','#999');
                        }else{
                        	$input.css('color','#333');
                        }
                    });
                // Sets initial watermark state.
                if (!$input.val()) {
                    $input.val($watermark).css('color','#999');
                }
            }
        });
    };
    $.fn.updnWatermark.defaults = {
        cssClass: "updnWatermark"
    };
    $.updnWatermark = {
        attachAll: function(options) {
			$("input:text[title!=''],input:password[title!=''],textarea[title!='']").updnWatermark(options);
        }
    };
})(jQuery);


/***************************************************
*		プリロード
*/
(function($) {
	var cache = [];
	$.preLoadImages = function() {
		var args = arguments[0].split(',');
		var args_len = args.length;
		for (var i=0; i<args_len; i++) {
			var cacheImage = document.createElement('img');
			cacheImage.src = args[i];
			cache.push(cacheImage);
		}
	};
})(jQuery);

/***************************************************
*		ライブラリ拡張
*/
	jQuery.extend({
		holidayInfo:{},
		addFigure:function(arg){
			var str = new String(arg);
			str = str.replace(/[０-９]/g, function(m){
	    				var a = "０１２３４５６７８９";
		    			var r = a.indexOf(m);
		    			return r==-1? m: r;
		    		});
		    str -= 0;
	    	var num = new String(str);
	    	if( num.match(/^[-]?\d+(\.\d+)?/) ){
	    		while(num != (num = num.replace(/^(-?\d+)(\d{3})/, "$1,$2")));
	    	}else{
	    		num = "0";
	    	}
	    	return num;
		},
		check_NaN:function(my){
		/*
		*	自然数かどうか
		*	@my			Object
		*
		*	@return		自然数でない場合に0を返す、第二引数があれば、自然数以外のときの返り値として使用
		*/
			var err = arguments.length>1? arguments[1]: 0;
			var str = my.value.trim().replace(/[０-９]/g, function(m){
	    				var a = "０１２３４５６７８９";
		    			var r = a.indexOf(m);
		    			return r==-1? m: r;
		    		});
		    my.value = (str.match(/^\d+$/))? str-0: err;
		    return my.value;
		},
		check_Real: function(my){
		/*
		*	実数かどうか（整数、小数点）
		*	@my			Object
		*
		*	@return		不正値は0
		*/
			var str = my.value.trim().replace(/[０-９]/g, function(m){
				var a = "０１２３４５６７８９";
				var r = a.indexOf(m);
				return r==-1? m: r;
			});
			my.value = (str.match(/^-?[0-9]+([\.]{1}[0-9]+)?$/))? str-0: 0;
			return my.value;
		},
		screenOverlay: function(mode){
			var body_w = $(document).width();
			var body_h = $(document).height();
			if(mode){
				$('#overlay').css({ 'width': body_w+'px',
									'height': body_h+'px',
									'opacity': 0.5}).show();
			}else{
				$('#overlay').css({ 'width': '0px',	'height': '0px'}).hide("1000");
			}
		},
		restrict_num:function(n, my) {
			var c = my.value.replace(/[０-９]/g, function(m){
	    				var a = "０１２３４５６７８９";
		    			var r = a.indexOf(m);
		    			return r==-1? m: r;
		    		});
			c = c.replace(/[^\d]/g, '');

		    my.maxLength = n;
		    my.value = c;
		    var self = my;
		    $(self).select();
	    },
		zip_mask:function(args) {
	    /*
	    *	郵便番号を「-」で区切る
	    *	@args		郵便番号
	    *
	    *	@return		「-」で区切った郵便番号を返す
	    */
	    	var c = args.replace(/[０-９]/g, function(m){
	    				var a = "０１２３４５６７８９";
		    			var r = a.indexOf(m);
		    			return r==-1? m: r;
		    		});
	      	c = c.replace(/[^\d]/g, '');
	      	if(c.length >= 3) c = c.substr(0, 3) + '-' + c.substr(3);
	      	
	      	return c;
		},
		phone_mask:function(args){
		/*
		*	電話番号を「-」で区切る
		*	@args		電話番号
		*
		*	@return		[c:電話番号, l:桁数]　
		*/
			var l = 12;
			var c = args.replace(/[０-９]/g, function(m){
	    				var a = "０１２３４５６７８９";
		    			var r = a.indexOf(m);
		    			return r==-1? m: r;
		    		});
	      	c = c.replace(/[^\d]/g, '');
      		if($.check_phone_separate(c, 5)){
      			c = c.substr(0, 5) + '-' + c.substr(5, 1) + '-' + c.substr(6, 4);
      		}
      		else if($.check_phone_separate(c, 4)){
      			c = c.substr(0, 4) + '-' + c.substr(4, 2) + '-' + c.substr(6, 4);
      		}
	      	else{
	      		var tel1 = c.substr(0, 3);
	      		if(tel1.match(/^0[5789]0$/)){
	      			c = c.substr(0, 3) + '-' + c.substr(3, 4) + '-' + c.substr(7, 4);
	      			l = 13;
	      		}
	      		else if($.check_phone_separate(c, 3)){
	      			c = c.substr(0, 3) + '-' + c.substr(3, 3) + '-' + c.substr(6, 4);
	      		}
	      		else if($.check_phone_separate(c, 2)){
		      		c = c.substr(0, 2) + '-' + c.substr(2, 4) + '-' + c.substr(6, 4);
		      	}
		    }
		    
		    return {'c':c,'l':l};
		},
		check_phone_separate:function(c, count){
      		var tel1 = c.substr(0, count);
      		var flg = false;
      		var phone = '';
      		switch(count){
      			case 5:		phone = $.phonedata.phone5;
      						break;
      			case 4:		phone = $.phonedata.phone4;
      						break;
      			case 3:		phone = $.phonedata.phone3;
      						break;
      			case 2:		phone = $.phonedata.phone2;
      						break;
      			default:	return flg;
      		}

      		for(var i=0; i<phone.length; i++){
	      		if(phone[i]==tel1){
	      			flg = true;
	      			break;
	      		}
	      	}

	      	return flg;
		},
		check_email: function(email){
		/*
		*	メールアドレスの妥当性チェック
		*	@email		メールアドレス
		*
		*	@return		OK: true	NG: false
		*/
	   
			if(email.trim()=="" || !email.match(/@/)){
				$.msgbox('メールアドレスではありません。');
				return false;
			}

			var res = false;
			
			/*	RFC2822 addr_spec 準拠パターン							*/
			/*	atom       = {[a-zA-Z0-9_!#\$\%&'*+/=?\^`{}~|\-]+};		*/
			/*  dot_atom   = {$atom(?:\.$atom)*};						*/
			/*  quoted     = {"(?:\\[^\r\n]|[^\\"])*"};					*/
			/*  local      = {(?:$dot_atom|$quoted)};					*/
			/*  domain_lit = {\[(?:\\\S|[\x21-\x5a\x5e-\x7e])*\]};		*/
			/*  domain     = {(?:$dot_atom|$domain_lit)};				*/
			/*  addr_spec  = {$local\@$domain};							*/
			$.ajax({
				url:'/php_libs/checkDNS.php', async:false, type:'POST', dataType:'text', data:{'email': email}, 
				success:function(r){
					if(r){
						if( email.match(/^(?:(?:(?:(?:[a-zA-Z0-9_!#\$\%&'*+/=?\^`{}~|\-]+)(?:\.(?:[a-zA-Z0-9_!#\$\%&'*+/=?\^`{}~|\-]+))*)|(?:"(?:\\[^\r\n]|[^\\"])*")))\@(?:(?:(?:(?:[a-zA-Z0-9_!#\$\%&'*+/=?\^`{}~|\-]+)(?:\.(?:[a-zA-Z0-9_!#\$\%&'*+/=?\^`{}~|\-]+))*)|(?:\[(?:\\\S|[\x21-\x5a\x5e-\x7e])*\])))$/)){
							//$.msgbox('OK!\n確認メールを送信してください。');
							res = true;
						}else{
							$.msgbox('メールアドレスを確認してください。');
						}
					}else{
						$.msgbox('@マークより後を確認してください。');
					}
				}
			});
			
			return res;
			
		},
		scrollto: function(target){
		/*
		*	指定位置にスクロール
		*	@target		jQuery オブジェクト
		*	第二引数	コールバック関数
		*/
			var fnc = null;
			if(arguments.length>1 && typeof arguments[1]=="function") fnc = arguments[1];	// 第二引数があれば、コールバック関数として使用 
			var targetOffset = target.offset().top;
			//$($.browser.opera ? document.compatMode == 'BackCompat' ? 'body' : 'html' :'html,body')
			$('html,body').animate({scrollTop: targetOffset}, 500, 'easeInOutExpo', fnc);
        },
		msgbox: function(msg){
		/*
		*	メッセージボックス
		*	@msg		表示するメッセージ文
		*	@arguments	タイトルを指定、指定なしの場合は「メッセージ」
		*/
			var title = arguments.length==2? arguments[1]: 'メッセージ';
			$('#msgbox').off('show.bs.modal').on('show.bs.modal', {'message': msg, 'title':title}, function (e) {
				$('.modal-footer').hide();
				$('#msgbox .modal-title').html(e.data.title);
				$('#msgbox .modal-body p').html(e.data.message);
			});
			$('#msgbox').modal('show');
    	},
		confbox: {
		/*
		*	確認ボックス
		*	@msg		表示するメッセージ文
		*	@fn			callback ボタンが押された後の処理　OK:true, Cancel:false
		*/
			show: function(msg, fn){
				$.confbox.result.data = false;
				$('#msgbox').off('show.bs.modal').on('show.bs.modal', {'message': msg}, function (e) {
					$('.modal-footer').show();
					$('#msgbox .modal-body p').html(e.data.message);
					$(this).one('click', '.is-ok', function(){
						$.confbox.result.data = true;
					});
					$(this).one('click', '.is-cancel', function(){
						$.confbox.result.data = false;
					});
				});
				$('#msgbox').off('hidden.bs.modal').on('hidden.bs.modal', function (e) {
					fn();
				});
				$('#msgbox').modal('show');
			},
			result: {
				'data':false
			}
		},
		TLA: {
			'api':'http://takahamalifeart.com/v1/api'
		}
	});


/***************************************************
*		全ての画像の読込みを完了してから処理を実行させる
*/
$.fn.imagesLoaded = function(callback){
	var elems = this.filter('img'),
    	len = elems.length,
    	blank = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";
      
	elems.bind('load.imgloaded',function(){
		if(--len <= 0 && this.src !== blank){
			elems.unbind('load.imgloaded');
			callback.call(elems,this);
		}
	}).each(function(){
     	// cached images don't fire load sometimes, so we reset src.
		if (this.complete || this.complete === undefined){
			var src = this.src;
        	// webkit hack from http://groups.google.com/group/jquery-dev/browse_thread/thread/eee6ab7b2da50e1f
        	// data uri bypasses webkit log warning (thx doug jones)
			this.src = blank;
			this.src = src;
		}
	});

	return this;
};


/***************************************************
*		プロパティ
*/
	String.prototype.trim = function(){ return this.replace(/^[\s　]+|[\s　]+$/g, ''); };
