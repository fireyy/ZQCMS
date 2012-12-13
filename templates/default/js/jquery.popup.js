(function($){
	var defaultSetting = {
		width: null,
		height: null,
		opacity: 0.7,
		url: null,
		content: null,
		scroll: true,
		resize: true
	};
	
	var dialog = null;
	var mask = null;

	$.popup = function(opt){
		if(opt == undefined)
			opt = {};
		opt = $.extend(defaultSetting, opt)

		dialog = $('#dialog');
		$('select:visible').css('visibility', 'hidden');
		if (dialog.length == 0){
			dialog = $('<div id="dialog" class="dialog"><div id="dialog-header"><div id="dialog-title"></div><div id="dialog-close"></div></div><div id="dialog-content"><div id="dialog-content-inner"/></div></div>')
				.appendTo(document.body);
			$('#dialog-title').html(opt.title);
			if(opt.url != null)
				$('#dialog-content').html('<iframe src="'+opt.url+'" frameborder="0" width="100%" height="100%" scrolling="no"></iframe>');
			else if(opt.content != null)
				$('#dialog-content').html(opt.content);
			
			mask = $('<div id="dialog-mask"></div>').appendTo(document.body)
				.css('z-index', 99998)
				.animate({opacity:opt.opacity}, 0);
			
			dialog.css('width', opt.width).css('height', opt.height).css('z-index', 99999);
			$('#dialog-content').css('height', dialog.outerHeight()-$('#dialog-header').outerHeight());
			$('#dialog-close').click($.popup.hide);

			if(opt.resize == true)
				$(window).resize(function(){$.popup.resize()});
			if(opt.scroll == true)
				$(window).scroll(function(){$.popup.resize()});
			$(document).keydown(function(event){
				if(event.keyCode == 27)
					$.popup.hide();
			});
		}
		$.popup.resize();
		$.popup.show();
		dialog.focus();
	};

	$.popup.resize = function(){
		var height = parseInt(($(window).height()-parseInt(dialog.outerHeight()))/2.3+$(window).scrollTop());
		dialog.css('left', (($(window).width())/2-(parseInt(dialog.outerWidth())/2))+'px')
		.css('top', (height < 0 ? 0 : height)+'px');
		mask.css('height', document.documentElement.scrollHeight+'px');
	}

	$.popup.isOpen = function(){
		return $('#dialog').length == 1 ? true : false;
	}

	$.popup.hide = function(){
		if(dialog)
			dialog.remove();
		if(dialog)
			mask.remove();
		$('select:visible').css('visibility', 'visible');
	};

	$.popup.show = function(){
		dialog.show();
		mask.show();
	}
})(jQuery);