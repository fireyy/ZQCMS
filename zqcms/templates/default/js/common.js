function getshowfmt()
{
	$('.fmt_nav_a1').hide();$('.play_fmt').show();	
	$('.fmt').eq(0).css("bottom","223px");
}
 function gethidefmt()
{
	$('.play_fmt').hide();$('.fmt_nav_a1').show();
	$('.fmt').eq(0).css("bottom","0");
}
$(function(){
	$('#content .ulmag #index_loginother').each(function(){
		var self = $(this);
		self.click(function(){
			if ($('#otherlogin').css('display') == "none"){
				$('#otherlogin').show();
				self.removeClass('input1_06');
				self.addClass('input1_07');
			}
			else{
				$('#otherlogin').hide();
				self.removeClass('input1_07');
				self.addClass('input1_06');
			}
		})
		$('#otherlogin ul').mouseover(function(){
			$('#otherlogin').show();
			self.removeClass('input1_06');
			self.addClass('input1_07');
		}).mouseout(function(){
			$('#otherlogin').hide();
			self.removeClass('input1_07');
			self.addClass('input1_06');
		});
	});
  
  $("#sitemap").hover(function(){
  			$("#navlist").show();
  		},function(){
  			$("#navlist").hide();
  		});

	$('#header .searchlistbutton').each(function(){
		var self = $(this);
		self.mouseover(function(){
			$("#header .changelist").show();
		});
		self.mouseout(function(){
			$("#header .changelist").hide();
		});
		
		self.find('div.changelist a').click(function(){
			var str = self.find('div.changelist a').index(this);

			switch (str) {
				case 0:
					$('#header .searchlistbutton #search_txt').html('游戏');
					$('#header #searchnav #searchtype_val').val("game");
					break;
				case 1:
					$('#header .searchlistbutton #search_txt').html('运营商');
                    $('#header #searchnav #searchtype_val').val("platform");
					break;
				case 2:
					$('#header .searchlistbutton #search_txt').html('资讯');
                    $('#header #searchnav #searchtype_val').val("article");
					break;
			}
		})
	});
        $("#searchForm").submit(function(){
                var type = $('#header #searchForm #searchtype_val').val();
                var keys = encodeURIComponent($('#header #searchForm #keys').val());
                var currHref = window.location.href;

                var target = /http:\/\/www\.kaifu\.com\/search\.php\?keys=/.test(currHref)||/http:\/\/www\.kaifu\.com\/platformsearch\.php\?keys=/.test(currHref)||/http:\/\/www\.kaifu\.com\/article\.php\?action=article_list&keys=/.test(currHref) ? 'self':'blank';
                switch(type){
                        case 'game':
                                if(target=='self'){
                                        window.location.href = "/search.php?keys="+keys;
                                }else{
                                        window.open("/search.php?keys="+keys);
                                }
                                
                                break;
                        case 'platform':
                                if(target=='self'){
                                        window.location.href = "/platformsearch.php?keys="+keys;
                                }else{
                                        window.open("/platformsearch.php?keys="+keys);
                                }
                                break;
                        case 'article':
                                if(target=='self'){
                                        window.location.href = "/article.php?action=article_list&keys="+keys;
                                }else{
                                        window.open("/article.php?action=article_list&keys="+keys);
                                }
                                break;
                        default:
                                
                }
                return false;
        });
	$('#gamelist_arr').each(function(){
		var self = $(this);
		self.find('li.d:gt(40)').css('display', 'none');
		self.find('li.more').click(function(){
			if ($(this).html()=="收缩&lt;&lt;&lt;"){
				$(this).html('全部&gt;&gt;&gt;');
				self.find('li.d:gt(40)').css('display', 'none');
			}else{
				$(this).html('收缩&lt;&lt;&lt;');
				self.find('li.d').css('display', 'block');
			}
		});
	});
	$('#gamelist_arr_k').each(function(){
		var self = $(this);
		self.find('li.d:gt(40)').css('display', 'none');
		self.find('li.more').click(function(){
			if ($(this).html()=="收缩&lt;&lt;&lt;"){
				$(this).html('全部&gt;&gt;&gt;');
				self.find('li.d:gt(40)').css('display', 'none');
			}else{
				$(this).html('收缩&lt;&lt;&lt;');
				self.find('li.d').css('display', 'block');
			}
		});
	});
	$("#searchbtn").each(function(){
		$(this).click(function(){
			if ($("TEXTAREA,input[focucmsg]").val() == $("TEXTAREA,input[focucmsg]").attr("focucmsg")){
				$("TEXTAREA,input[focucmsg]").val('');
				$("TEXTAREA,input[focucmsg]").focus;
				return false;
			}
		});
	});
	$("#rightdiv2").each(function(){
		$(this).mouseover(function(){
			$(this).attr('class', $(this).attr('class').replace('rightdiv2', 'rightdiv2_hover'))
		});
		$(this).mouseout(function(){
			$(this).attr('class', $(this).attr('class').replace('rightdiv2_hover', 'rightdiv2'))
		});
	});
	$("#rightdiv").each(function(){
		$(this).mouseover(function(){
			$(this).attr('class', $(this).attr('class').replace('rightdiv', 'rightdiv_hover'))
		});
		$(this).mouseout(function(){
			$(this).attr('class', $(this).attr('class').replace('rightdiv_hover', 'rightdiv'))
		});
	});
	$('#gnb').each(function(){
		var self = $(this);
		self.find('h1').mouseover(function(){
			self.find('h1').each(function(){
				$(this).attr('class', $(this).attr('class').replace('sty_1', 'sty_2'))
			});
			$(this).attr('class', $(this).attr('class').replace('sty_2', 'sty_1'))
			$(self.find('div.searchdiv div.searchdiv_form').css('display', 'none').get(self.find('h1').index(this))).css('display', 'block');
			$($('#content').find('.gamelistmenu').css('display', 'none').get(self.find('h1').index(this))).css('display', 'block');
			$($('#content').find('#kflist').css('display', 'none').get(self.find('h1').index(this))).css('display', 'block');
			$($('#content').find('.timelist_sub').css('display', 'none').get(self.find('h1').index(this))).css('display', 'block');
		});
	});
	$('#downdiv').each(function(){
		var self = $(this);
		$(this).mouseover(function(){
			$('#down_list').css('display', 'block');
		});
		$(this).mouseout(function(){
			$('#down_list').css('display', 'none');
		});
	});
	$(window).scroll(function () {
		var $body = $("body");
		if ($(window).scrollTop()>0) {
			$("#gototop").show();
		}else{
			$("#gototop").hide();
		}
	});
	$('#index_login').each(function(){
		if(jq.cookie('kaifu_user_id')){
			//$(this).attr('class', $(this).attr('class').replace('input1_03', 'input1_03_1'));
			$(this).val('个人中心');
		}else{
			//$(this).attr('class', $(this).attr('class').replace('input1_03_1', 'input1_03'));
			$(this).val('玩家登录');
		}
	});
	$("#index_gamelist div.focustopback").each(function(){
		var self = $(this);
		types = 0;
		type = 0;
		$(self.find('#day_left a.index_type')).click(function(){
			self.find('#day_left a.index_type').each(function(){
				$(this).attr('class', $(this).attr('class').replace('index_type enterpart_active padds', 'index_type enterpart backa padds'))
			});
			$(this).attr('class', $(this).attr('class').replace('index_type enterpart backa padds', 'index_type enterpart_active padds'));
			if ($(this).html() == '全部'){
				types = 0;
				self.find('#day_right a.index_types').each(function(){
					$(this).attr('class', $(this).attr('class').replace('index_types enterpart_active padds', 'index_types enterpart backa padds'))
				});
			}else if ($(this).html() == '昨日'){
				types = 1;
			}else if ($(this).html() == '今日'){
				types = 2;
			}else if ($(this).html() == '明日'){
				types = 3;
			}
			if ($("#index_gamelist div.focustopback #day_right a.enterpart_active").html() == '网页游戏'){
				type = 1;
			}else if ($("#index_gamelist div.focustopback #day_right a.enterpart_active").html() == '客户端游戏'){
				type = 2;
			}else if ($("#index_gamelist div.focustopback #day_right a.enterpart_active").html() == null){
				type = 0;
			}
			GameList.getGameList(types,type);
		});
		$(self.find('#day_right a.index_types')).click(function(){
			self.find('#day_right a.index_types').each(function(){
				$(this).attr('class', $(this).attr('class').replace('index_types enterpart_active padds', 'index_types enterpart backa padds'))
			});
			$(this).attr('class', $(this).attr('class').replace('index_types enterpart backa padds', 'index_types enterpart_active padds'));
			if ($(this).html() == '网页游戏'){
				type = 1;
			}else if ($(this).html() == '客户端游戏'){
				type = 2;
			}
			if ($("#index_gamelist div.focustopback #day_left a.enterpart_active").html() == '全部'){
				types = 0;
			}else if ($("#index_gamelist div.focustopback #day_left a.enterpart_active").html() == '昨日'){
				types = 1;
			}else if ($("#index_gamelist div.focustopback #day_left a.enterpart_active").html() == '今日'){
				types = 2;
			}else if ($("#index_gamelist div.focustopback #day_left a.enterpart_active").html() == '明日'){
				types = 3;
			}
			GameList.getGameList(types,type);
		});
	});
});

function rel_login(){
	top.location.href='http://www.kaifu.com/login.php';
}
function getDays(year, month){
	year = parseInt(year);
	month = parseInt(month);
	if(isNaN(year) || isNaN(month) || year < 1 || month < 1 || month > 12)
		return null;
	var days = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
	if(year % 4 == 0)
		days[1] = 29;
	return days[month-1];
};
function redirect_url(){
	var url=document.location.search
	if (url>""){
		var str=url.replace(/%2F/g, "/");
		str=str.replace(/%3A/g, ":");
		str=str.replace(/%3D/g, "=");
		str=str.replace(/%3F/g, "?");
		str=str.replace(/%26/g, "&");
		str=str.replace(/%40/g, "@");

		str=str.replace("?url=","");
		return str;
	}else{
		return null;
	}
}
var JOO = {
	mode: '',
	setMode: function(mode){
		this.mode = mode;
	},
	apply: function(packageName, object){
		if(this.mode != 'static' && this.mode != 'instance'){
			this.mode = '';
			return alert('模式只能设置为static或instance');
		}

		if(object === undefined)
			return false;
		var names = packageName.split('.');

		var pobj = window;
		for(var i=0; i<names.length-1; i++){
			if(pobj[names[i]] !== undefined){
				pobj = pobj[names[i]];
			}else{
				pobj[names[i]] = function(){};
				pobj[names[i]].className = names.slice(0, i+1).join('.');
				pobj[names[i]].parent = pobj;
				pobj = pobj[names[i]];
			}
		}
		if(pobj !== undefined){
			if(object != null && typeof object == 'object' && object.length == undefined){
				for(var i in object){
					this.apply([packageName, i].join('.'), object[i]);
				}
				return true;
			}

			if(this.mode == 'static' || pobj.prototype == undefined){
				if(pobj[names.slice(-1)])
					return alert(packageName + ' 已存在');
				pobj[names.slice(-1)] = object;
			}else if(this.mode == 'instance'){
				if(pobj.prototype[names.slice(-1)])
					return alert(packageName + ' 已存在');
				pobj.prototype[names.slice(-1)] = object;
			}
		}
		return true;
	}
};
JOO.setMode('instance');
JOO.apply('TaskChecker', {
	checkTask: [],
	checkedTask: [],
	checkProgress: 0,
	checkTaskDebug: false,
	checkTaskDebugEl: null,
	checkComplete: function(){},
	debug: function(msg){
		if(this.checkTaskDebugEl)
			this.checkTaskDebugEl.value += "\r\n" + msg;
	},
	initCheckTask: function(){
		this.checkTask = [];
		this.checkedTask = [];
		this.checkProgress = 0;
		this.checkComplete = function(){};
	},

	onCheckComplete: function(callback){
		this.checkComplete = callback;
	},
	addCheckTask: function(taskType, task){
		if(typeof task == 'function')
			this.checkTask.push([taskType, task]);
	},
	checkTaskNow: function(lastReturn){
		if(lastReturn === false)
			return false;
		this.debug('-------------------------------------');
		this.debug('开始检查任务，索引：' + this.checkProgress);
		if(this.checkedTask[this.checkProgress] == true){
			this.debug('任务已处理，程序退出');
			this.checkProgress++;
		}else if(this.checkProgress < this.checkTask.length){
			this.debug('任务索引在队列中');
			this.checkedTask[this.checkProgress] = true;
			if(this.checkTask[this.checkProgress][0] == 'noajax'){
				this.debug('任务为普通任务(noajax)');
				if(!this.checkTask[this.checkProgress][1]()){
					this.debug('任务执行失败，当前索引：' + this.checkProgress);
					this.debug('任务执行失败，函数：' + this.checkTask[this.checkProgress][1]);
					this.checkProgress++;
					this.initCheckTask();
					return false;
				}else{
					this.debug('函数执行成功，索引：' + this.checkProgress);
					this.checkProgress++;
					this.checkTaskNow();
				}
			}else{
				this.debug('任务为ajax任务，异步处理进程：'+this.checkProgress);
				this.checkProgress++;
				this.checkTask[this.checkProgress-1][1]();
				return false;
			}
		}else{
			this.debug('所有检查任务执行完成！');
			this.checkComplete();
			this.initCheckTask();
		}
	},
	onCheckComplete: function(completeEvent){
		this.checkComplete = completeEvent;
	}
});

JOO.setMode('static');
JOO.apply('GameList', {
	getGameList: function(types,type){
		Ajax.getJSON("http://www.kaifu.com/api/gamelist.php?action=indexlist", {
			types:types,
			type:type
		}, function(d){
			if(d.status){
				$('#day_gamelist').html(d.msg);
				$("#index_gamelist div ul li a").hover(function(){
					$(this).find('div').css('display', 'block')
				},function(){
					$(this).find('div').css('display', 'none')
				});
				if (d.msg){
					GameInfo.getGameGift();
				}				
			}
		});
	}
});

JOO.apply('GameInfo', {
	getGameTextShow: function(str){
		var menuid = 'fwin_dialog';
		var menuObj = $(menuid);
		menuObj = document.createElement('div');
		menuObj.style.display = 'block';
		menuObj.className = 'fwinmask';
		var mt = document.documentElement.scrollTop;
		menuObj.style.top = mt + 'px';
		menuObj.id = menuid;
		document.body.appendChild(menuObj);
		menuObj.innerHTML = str;
		
		var A = 100;
		var fadeOut = function(A) {
			if(A == 0) {
				clearTimeout(fadeOutTimer);
				menuObj.style.display = 'none';
				return;
			}
			menuObj.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity=' + A + ')';
			menuObj.style.opacity = A / 100;
			A -= 10;
			var fadeOutTimer = setTimeout(function () {
				fadeOut(A);
			}, 200);
		};
		fadeOut(A);
	},
	getGameRecommendGift: function(){
		Ajax.getJSON("http://www.kaifu.com/api/gameinfo.php?action=recommend", null, function(d){
			if(d.status){
				game_info=d.msg;
				for(i=0;i<game_info.length;i++){
					$('#game_recommend_'+game_info[i].id).html(game_info[i].txt);
				}
			}
		});
	},
	getNewGameGift: function(){
		var i = $('ul[name=Tag]'),id = [];
		i.each(function(){
			var str = $(this).attr("value");
			id.push(str);
		});
		
		var gid = id.join(',');
		Ajax.getJSON("http://www.kaifu.com/api/gameinfo.php?action=newgamegift", {
			gid:gid
		}, function(d){
			if(d.status){
				tmp_arr=d.msg;
				for(i=0;i<tmp_arr.length;i++){
					$('#gift_'+tmp_arr[i].id).html(tmp_arr[i].gift);
					$('#pc_'+tmp_arr[i].id).html(tmp_arr[i].pc);
				}
			}
		});
	},
	getMiscLandingPagesGameGift: function(){
		var i = $('li[name=Tag]'),id = [];
		i.each(function(){
			var str = $(this).attr("value");
			id.push(str);
		});
		
		var gid = id.join(',');
		Ajax.getJSON("http://www.kaifu.com/api/gameinfo.php?action=misclandingpagesgamegift", {
			gid:gid
		}, function(d){
			if(d.status){
				tmp_arr=d.msg;
				for(i=0;i<tmp_arr.length;i++){
					$('.gift_'+tmp_arr[i].id).html(tmp_arr[i].gift);
				}
			}
		});
	},
	getGameGift: function(){
		var i = $('li[name=Tag]'),id = [];
		i.each(function(){			
			var str = $(this).attr("value");
			id.push(str);
		});
		
		var gid = id.join(',');
		Ajax.getJSON("http://www.kaifu.com/api/gameinfo.php?action=gamegift", {
			gid:gid
		}, function(d){
			if(d.status){
				tmp_arr=d.msg;
				for(i=0;i<tmp_arr.length;i++){
					$('#gift_'+tmp_arr[i].id).html(tmp_arr[i].gift);
				}
			}
		});
	},
	getGameServerGift: function(){
		var i = $('li[name=Tag]'),id = [];
		i.each(function(){			
			var str = $(this).attr("value");
			id.push(str);
		});
		
		var gid = id.join(',');

		Ajax.post("http://www.kaifu.com/api/gameinfo.php?action=gameservergift", {
			gid:gid
		}, function(d){
			if(d.status){
				tmp_arr=d.msg;
				for(i=0;i<tmp_arr.length;i++){
					$('#gift_'+tmp_arr[i].id).html(tmp_arr[i].gift);
				}
			}
		});
	},
	getGameScreen: function(gid){
		Ajax.getJSON("http://www.kaifu.com/api/gameinfo.php?action=getGameScreen", {
			gid:gid
		}, function(d){
			if(d.status){
				$('#game_screen_'+gid).html(d.msg);
			}
		});
	},
	getGameOther: function(from){
		var i = $('[name=Tag]'),id = [];
		i.each(function(){
			var str = $(this).attr("value");
			id.push(str);
		});
		var gid = id.join(',');
		if (gid){
			Ajax.getJSON("http://www.kaifu.com/api/gameinfo.php?action=getGameOther", {
				gid:gid,
				from:from
			}, function(d){
				if(d.status){
					tmp_arr=d.msg;
					for(var i=0;i<tmp_arr.length;i++){
						$('#game_'+tmp_arr[i].id).html(tmp_arr[i].gift);
						$('#game_new_'+tmp_arr[i].id).html(tmp_arr[i].newserver);
						$('#game_down_'+tmp_arr[i].id).html(tmp_arr[i].down);
					}
				}
			});			
		}
	},
	getGameTestOther: function(from){
		var i = $('[name=Tag]'),id = [];
		i.each(function(){
			var str = $(this).attr("value");
			id.push(str);
		});
		var gid = id.join(',');
		Ajax.getJSON("http://www.kaifu.com/api/gameinfo.php?action=getGameTestOther", {
			gid:gid
		}, function(d){
			if(d.status){
				tmp_arr=d.msg;
				for(var i=0;i<tmp_arr.length;i++){
					$('#game_'+tmp_arr[i].id).html(tmp_arr[i].gift);
				}
			}
		});
	},
	getGameNewServer: function(gid){
		Ajax.getJSON("http://www.kaifu.com/api/gameinfo.php?action=getGameNewServer", {
			gid:gid
		}, function(d){
			if(d.status){
				$('#game_new_'+gid).html(d.msg);
			}
		});
	},
	getGameDown: function(gid){
		Ajax.getJSON("http://www.kaifu.com/api/gameinfo.php?action=getGameDown", {
			gid:gid
		}, function(d){
			if(d.status){
				$('#game_down_'+gid).html(d.msg);
			}
		});
	},
	updateGame: function(id,level){
		if ($.cookie('game_dc_'+id)){
			alert('您已经对该游戏评分过了！')
		}else{
			$.cookie('recommended_'+id,'1');
			Ajax.getJSON("http://www.kaifu.com/api/gameinfo.php?action=updateGameDc", {
				GAMEID:id,
				LEVEL:level
			}, function(d){
				if(d.status){
					$('#score').html(d.msg.average_score);
					$('#score_good').html(d.msg.score_good_count);
					$('#score_soso').html(d.msg.score_soso_count);
					$('#score_bad').html(d.msg.score_bad_count);
					alert('感谢您的评分！');
					$.cookie('game_dc_'+id,'1',{
						expires:30
					});
				}
			});
		}
	},
	attention: function(id){
		if($.cookie('kaifu_user_id')){
			Ajax.getJSON("http://www.kaifu.com/api/gameinfo.php?action=attention", {
				GAMEID:id
			}, function(d){
				if(d.status){
					alert("该游戏已添加到关注");
					$('#attention_count').html(d.msg);
				}else{
					alert(d.msg);
				}
			});
		}else{
			SSOClient.login();
		}
	},
	msgBox: function(str){
		jq.popup({
			title: '订阅游戏资讯',
			opacity: 0.5,
			width: 280,
			content: '<div id="wrap_view" class="wrap_view">'+str+'</div>'
		});
	},
	fenxiang: function(id,title,url){
		jq.popup({
			title: '分享微博',
			opacity: 0.5,
			width: 288,
			height: 118,
			content: '<div id="wrap_view" class="wrap_view" style="margin-top:10px;"><span>将点评分享到：</span><a href="javascript:void((function(){var f=\''+title+'\';var c=\''+url+'\';var e=encodeURI(\'1459b2ac3d2345d2a17396eec5ad3bd7\');var b=encodeURI(\'\');var a=\'\';var d=\'http://v.t.qq.com/share/share.php?url=\'+c+\'&appkey=\'+e+\'&site=\'+a+\'&pic=\'+b+\'&title=\'+f;window.open(d,\'\',\'width=700, height=680, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, location=yes, resizable=no, status=no\')})());" onclick="GameInfo.fenxiang_jifenComment(\''+id+'\')"><img src="http://res.kaifu.com/isy/templates/front/images/fenxiang_1.jpg" style="vertical-align: middle" alt="分享到腾讯微博" /></a> <a href="javascript:void((function(s,d,e,r,l,p,t,z,c){var f=\'http://t.sohu.com/third/post.jsp?\',u=z||d.location,p=[\'&url=\',e(u),\'&title=\',e(t||d.title),\'&content=\',c||\'gb2312\',\'&pic=\',e(p||\'\')].join(\'\');function%20a(){if(!window.open([f,p].join(\'\'),\'mb\',[\'toolbar=0,status=0,resizable=1,width=660,height=470,left=\',(s.width-660)/2,\',top=\',(s.height-470)/2].join(\'\')))u.href=[f,p].join(\'\');};if(/Firefox/.test(navigator.userAgent))setTimeout(a,0);else%20a();})(screen,document,encodeURIComponent,\'\',\'\',\'\',\''+title+'\',\''+url+'\',\'utf-8\'));" onclick="GameInfo.fenxiang_jifenComment(\''+id+'\')"><img src="http://res.kaifu.com/isy/templates/front/images/fenxiang_5.jpg" style="vertical-align: middle" alt="分享到搜狐微博" /></a> <a href="javascript:void((function(s,d,e,r,l,p,t,z,c){var%20f=\'http://v.t.sina.com.cn/share/share.php?appkey=3015934887\',u=z||d.location,p=[\'&url=\',e(u),\'&title=\',e(t||d.title),\'&source=\',e(r),\'&sourceUrl=\',e(l),\'&content=\',c||\'gb2312\',\'&pic=\',e(p||\'\')].join(\'\');function%20a(){var%20_url=[f,p].join(\'\');if(!window.open(_url,\'mb\',[\'toolbar=0,status=0,resizable=1,width=600,height=460,left=\',(s.width-600)/2,\',top=\',(s.height-460)/2].join(\'\')))u.href=_url;};if(/Firefox/.test(navigator.userAgent))setTimeout(a,0);else%20a();})(screen,document,encodeURIComponent,\'\',\'\',\'\',\''+title+'\',\''+url+'\',\'utf-8\'));" onclick="GameInfo.fenxiang_jifenComment(\''+id+'\')"><img src="http://res.kaifu.com/isy/templates/front/images/fenxiang_2.jpg" style="vertical-align: middle" alt="分享到新浪微博" /></a><div class="red" style="padding-top:10px">登录后分享点评可获得20金币</div></div>'
		});
	},
	fenxiang_jifenComment:function(id){
		if($.cookie('kaifu_user_id')){
			Ajax.getJSON("http://www.kaifu.com/api/gameinfo.php?action=fenxiangComment",{
				ID:id
			}, function(d){
				if(d.status){
					GameInfo.getGameTextShow(d.msg);
				}
			});
		}
	},
	dayLingqu:function(){
		if($.cookie('kaifu_user_id')){
			Ajax.getJSON("http://www.kaifu.com/api/gameinfo.php?action=daylingqu",{}, function(d){
				if(d.status){
					GameInfo.getGameTextShow(d.msg);
					$("#lijilingqu").attr('class','dollar_hover');
					SSOClient.Banner.checkNewPM();
				}else{
					alert(d.msg);
				}
			});
		}else{
			SSOClient.login();
		}
	},
	reurlgame:function(id){
		var tmp_str = $.localStorage('platformStat_'+id);
		var date = new Date();
		var year = date.getFullYear();
		var month = date.getMonth()+1;
		var day = date.getDate();
		var tmp_date = year+"-"+month+"-"+day;
		if (DateDiff(tmp_date,tmp_str)>0 || !tmp_str){
			$.localStorage('platformStat_'+id, tmp_date);
			Ajax.getJSON("http://www.kaifu.com/api/gameinfo.php?action=platformStat&type=1", {
				PID:id
			}, function(){});
		}else{
			Ajax.getJSON("http://www.kaifu.com/api/gameinfo.php?action=platformStat&type=2", {
				PID:id
			}, function(){});
		}
		
		if($.cookie('kaifu_user_id') || $.cookie('ssoUserId')){
			Ajax.getJSON("http://www.kaifu.com/api/gameinfo.php?action=GamePlayRecord",{
				GID:id
			}, function(d){});			
			Ajax.getJSON("http://www.kaifu.com/api/gameinfo.php?action=refresh",{
				ID:id
			}, function(d){
				if(d.status){
					GameInfo.getGameTextShow(d.msg);
				}
			});			
		}
	},
	fenxiang_jifen:function(){
		Ajax.getJSON("http://www.kaifu.com/api/gameinfo.php?action=fenxiang",{});
	},
	gameSubscribe: function(id,type){
		if($.cookie('kaifu_user_id')){
			Ajax.getJSON("http://www.kaifu.com/api/gameinfo.php?action=subscribe", {
				GAMEID:id,
				TYPE:type
			}, function(d){
				if(!d.status){
					//$('#subscribe').html(d.msg);
					GameInfo.msgBox(d.msg);
				}else{
					if (d.status == 3){
						top.location.href='http://www.kaifu.com/binding.php?action=email';
					}else if (d.status == 4){
						top.location.href='http://www.kaifu.com/binding.php?action=mobile';
					}else{
						GameInfo.msgBox(d.msg);
					}
				}
			});
		}else{
			SSOClient.login();
		}
	},
	comment: function(type,id){
		Ajax.getJSON("http://www.kaifu.com/api/gameinfo.php?action=updataComment", {
			ID:id,
			TYPE:type
		}, function(d){
			if(d.status){
				$('#comment_d_'+id).html("顶["+d.msg.support+"]");
				if ($('#h_comment_d_'+id))
					$('#h_comment_d_'+id).html("顶["+d.msg.support+"]");
				$('#comment_c_'+id).html("踩["+d.msg.against+"]");
				if ($('#h_comment_c_'+id))
					$('#h_comment_c_'+id).html("踩["+d.msg.against+"]");
			}
		});
	},
	dianping: function(type,id){
		if ($.cookie('dianping_'+id)){
			alert('您已经对该信息评价过了！')
		}else{
			Ajax.getJSON("http://www.kaifu.com/api/gameinfo.php?action=updataDianping", {
				ID:id,
				TYPE:type
			}, function(d){
				if(d.status){
					$('#dianping_s'+id).val("有用("+d.msg.support+")");
					$('#dianping_a'+id).val("无用("+d.msg.against+")");
					$.cookie('dianping_'+id,'1',{
						expires:30
					});
				}
			});
		}
	},
	getGameComment: function(id, url){
		var param;
		if(url != undefined){
			param = {};
			url = url;
		}else{
			param = {
				ID:id
			};
			url = "http://www.kaifu.com/api/gameinfo.php?action=CommentList";
		}
		
		Ajax.getJSON(url, param, function(d){
			if(d.status){
				var tmp = "";
				//$('#commentInfo').show();
				//$('#commentList').html(d.msg);
				if (d.msg.data){
					tmp_arr=d.msg.data;
					tmp_brr="";
					tmp_b = "";
				

					for(var i=0;i<tmp_arr.length;i++){
						tmp_brr=tmp_arr[i].data_r;
						if (tmp_brr){
							tmp_b = "";
							for(var j=0;j<tmp_brr.length;j++){
								tmp_b = tmp_b + '<div class="revert"><a href="'+tmp_brr[j].nickname_url+'" target="_blank">'+tmp_brr[j].nickname+'</a>&nbsp;<span class="gray">'+tmp_brr[j].created +' 回复：</span> <br/>'+tmp_brr[j].content+'<br/></div>';
							}
						}
						tmp = tmp + '<ul class="comment"><li><a href="'+tmp_arr[i].nickname_url+'" target="_blank">'+ tmp_arr[i].nickname +'</a>&nbsp;<span class="gray">'+ tmp_arr[i].created +' 说道</span><br/>'+ tmp_arr[i].content +' <br/>'+ tmp_b +'<div><input name="" id="replyBtn_'+ tmp_arr[i].id +'" type="button" onclick="commentCls.replyBtnClick(\''+ tmp_arr[i].id +'\');" class="comment_bt left"/><span class="gray">&nbsp;|&nbsp;来源于<a href="'+tmp_arr[i].from_url+'" target="_blank" class="gray decoration">'+tmp_arr[i].from_text+'</a></span></div><div class="revert_wind" id="comment_'+ tmp_arr[i].id +'" style="display:none;"><textarea class="text02box_1" rows="" cols="" name="textarea" id="replyContent_'+ tmp_arr[i].id +'"></textarea><div><input type="button" value="发表评论" onclick="commentCls.replyDo(\''+ tmp_arr[i].id +'\');" class="gameinputs" name="" /> <input type="button" value="取消" onclick="commentCls.replyCancel(\''+ tmp_arr[i].id +'\');" class="gameinputs" name="" /> <span id="tip_'+ tmp_arr[i].id +'" class="gray" >请输入1-100字的回复内容</span></div></div></li></ul>';
					}
				}else{
					$('#game_comment').hide();
				}
                                
				$('#Searchresult').html(tmp);
				if(d.pageNav)
					$('#Searchresult').append('<div class="qdiv">'+d.msg.pageNav+'</div>');
				$('#Searchresult .pages a').click(function(){
					GameInfo.getGameComment(null, $(this).attr('href'));
					return false;
				});
			}
		});
	},
	getGameReview: function(id){
		Ajax.getJSON("http://www.kaifu.com/api/gameinfo.php?action=ReviewList", {
			ID:id
		}, function(d){
			if(d.status){
				$('#reviewList').attr('class','p12 gameintroduce');
				$('#reviewList').html(d.msg);
			}
		});
	},
	getGameEvaluationComment: function(id){
		Ajax.getJSON("http://www.kaifu.com/api/gameinfo.php?action=EvaluationCommentList", {
			ID:id
		}, function(d){
			if(d.status){
				$('#hiddenresult').html(d.msg);
			}
		});
	},
	getGameReviewComment: function(id){
		Ajax.getJSON("http://www.kaifu.com/api/gameinfo.php?action=ReviewCommentList", {
			ID:id
		}, function(d){
			if(d.status){
				$('#game_comment').show();
				$('#hiddenresult').html(d.msg);
			}
		});
	},
	getGameInfo: function(id){
		
		var tmp_str = $.localStorage('gameStat_'+id);
		var date = new Date();
		var year = date.getFullYear();
		var month = date.getMonth()+1;
		var day = date.getDate();
		var tmp_date = year+"-"+month+"-"+day;

		if (DateDiff(tmp_date,tmp_str)>0 || !tmp_str){
			$.localStorage('gameStat_'+id, tmp_date);
			Ajax.getJSON("http://www.kaifu.com/api/gameinfo.php?action=GameStat&type=1", {
				GAMEID:id
			}, function(){});
		}else{
			Ajax.getJSON("http://www.kaifu.com/api/gameinfo.php?action=GameStat&type=2", {
				GAMEID:id
			}, function(){});
		}
		
		Ajax.getJSON("http://www.kaifu.com/api/gameinfo.php?action=getPlatformGame", {
			GAMEID:id
		}, function(d){
			if(d.status){
				if (d.msg){
					var tmp = d.msg;
					$('#platform_id').append('<option value="0">请选择</option>');
					for(var i=0;i<tmp.length;i++){
						$('#platform_id').append('<option value="'+ tmp[i].id +'">'+ tmp[i].name +'</option>');
					}					
				}
			}
		});

		Ajax.getJSON("http://www.kaifu.com/api/gameinfo.php?action=getGameInfo", {
			GAMEID:id
		}, function(d){
			if(d.status){
				$('#score').html(d.msg.average_score);
				$('#score_value').html(d.msg.score_value);
				$('#score_good').html(d.msg.score_good_count);
				$('#score_soso').html(d.msg.score_soso_count);
				$('#score_bad').html(d.msg.score_bad_count);
				$('#attention_count').html(d.msg.attention_count);
				$('#subscribe').html(d.msg.subscribe);
				$('#game_score_value').html(d.msg.game_score_value);
			}
		});
	},
	// 添加游戏历史记录
	addGameHistory:function (jsonStr){
                jsonStr = jsonStr.replace(/\^/ig,'"');
                var json = eval("("+jsonStr+")");
                
                if(typeof(json.pg_id)=="undefined"){
                        json.pg_id = 0;
                }
                if(typeof(json.platform_id)=="undefined"){
                        json.platform_id = 0;
                }
                if(typeof(json.game_id)=="undefined"){
                        json.game_id = 0;
                }
                if(typeof(json.pname)=="undefined"){
                        json.pname = '';
                }
                if(typeof(json.gname)=="undefined"){
                        json.gname = '';
                }
                if(typeof(json.g_dir_name)=="undefined"){
                        json.g_dir_name = '';
                }
                if(typeof(json.gpic)=="undefined"){
                        json.gpic = '';
                }
                
                
                var historyValue = "";
                var platformGameID = typeof(json.pg_id)=="undefined"?0:json.pg_id;
                if(json.gname!=''){
                       historyValue =  json.gname;
                       if(json.pname!=''){
                               historyValue += "("+json.pname+")"
                       }
                }
                
		var gHistory=$.localStorage('lishijilu');
		var gKey=historyValue+'|'+platformGameID;
		if(gHistory!=null && gHistory.indexOf(gKey)!==-1)
			return json;
		gHistory=gHistory ? gHistory.split(',') : [];
		gHistory.splice(4,gHistory.length);
		gHistory.splice(0,0,gKey);
		$.localStorage('lishijilu', gHistory);
		return json;
	},
	// 游戏投票
	addVote:function(gameID){
		var object2string = function(obj){
			var str = new Array();
			for(var i in obj){
				str.push(i+':'+obj[i]);
			}
			str.join(',');
			return str;
		}
		var string2object = function(string){
			var obj = {};
			string = (string||'').split(',');
			for(var i in string){
				var s = string[i].split(':');
				if(s.length==2)
					obj[s[0]]=s[1];
			}
			return obj;
		}
		var voteHistory = string2object($.localStorage('voteHistory'));
		var now = new Date();
		var time = parseInt((new Date(now.getFullYear(), now.getMonth(), now.getDate())).getTime()/1000);
		if(voteHistory === null)
			voteHistory = {};
		if(voteHistory[gameID] === undefined)
			voteHistory[gameID] = time;
		else if(voteHistory[gameID] >= time)
			return alert('你今天已经投过票了');
		else
			voteHistory[gameID] = time;
		Ajax.post('/api/gameinfo.php?action=addVote', {
			gameID:gameID
		}, function(d){
			alert(d.msg);
			if(d.status){
				var voteText = $('.vote-count-'+gameID).html();
				$('.vote-count-'+gameID).html((parseInt(voteText.match(/(\d+)/)[1])+1)+'票');
				$.localStorage('voteHistory', object2string(voteHistory));
			}
		});
		
		return false;
	}
});
var CustomFn = {
	setHomePage: function(){
		var url = window.location, domain, d = document, w = window;
		domain = url.protocol + '//' + url.hostname;
		if (d.all){
			d.body.style.behavior='url(#default#homepage)';
			d.body.setHomePage(domain);
		}else if (w.sidebar){
			if(w.netscape){
				try{
					w.netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
				}catch(e){
					alert( "该操作被浏览器拒绝，如果想启用该功能，请在地址栏内输入 about:config,然后将项 signed.applets.codebase_principal_support 值改为true" );
				}
			}
			try{
				var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components. interfaces.nsIPrefBranch);
				prefs.setCharPref('browser.startup.homepage', domain);
			}catch(e){
			}
		}
	},

	addFavorite: function() {
		if (document.all){
			window.external.addFavorite(window.location.href, document.title);
		}else if (window.sidebar){
			window.sidebar.addPanel(document.title, window.location.href, '');
		}
	}
};
var _Ajax = {
	tipSelector: null,
	tipText: '请稍候...',

	tip: function(selector, text){
		this.tipSelector = selector || this.tipSelector;
		this.tipText = text || this.tipText;
		return this;
	},

	showTip: function(){
		if(this.tipSelector != null){
			$(this.tipSelector).find('*').css('display', 'none').find('input').css('disabled', true);
			$(this.tipSelector).append('<span class="ajax-tip">'+ this.tipText +'</span>');
		}
		return this;
	},

	hideTip: function(){
		if(this.tipSelector != null){
			$(this.tipSelector).find('span.ajax-tip').remove();
			$(this.tipSelector).find('*').css('display', 'inline').find('input').css('disabled', false);
		}
	},
	
	post: function(url, params, callback){
		this.showTip();
		$.post(url, $.extend(params, {
			caller: 'ajax'
		}), function(d){
			callback(d), Ajax.hideTip();
		}, 'json');
	},

	get: function(url, params, callback){
		this.showTip();
		$.get(url, $.extend(params, {
			caller: 'ajax'
		}), function(d){
			callback(d), Ajax.hideTip();
		}, 'json');
	},

	postForm: function(formId, fn){
		fn = fn || function(){};
		var f = typeof(formId) == 'object' ? formId : $('#' + formId);
		f.find('input:submit').attr('disabled', 'disabled');
		f.ajaxSubmit({
			success: function(d){
				f.find('input:submit').removeAttr('disabled');
				fn(d);
			},
			data: {
				caller: 'ajax'
			},
			dataType : 'json'
		});
	},

	getJSON: function(url, params, callback, type){
		this.showTip();
		type = type || 'jsonp';
		if( type == 'jsonp' ){
			if( url.indexOf('?') == -1 )
				url += '?callback=?';
			else
				url += '&callback=?'
		}
		$.getJSON(url, $.extend(params, {
			format: type,
			caller: 'ajax'
		}), function(d){
			callback(d), Ajax.hideTip();
		});
	}
};
var Ajax = Ajax || _Ajax;

var Menu = {
	speed: 450,

	toggle: function(obj, selector, openIcon, closeIcon){
		var selector = $(selector);
		var fn =  function(){
			if(selector[0].style.display == 'none')
				$(obj).attr('src', closeIcon);
			else
				$(obj).attr('src', openIcon);
			
		}
		selector.stop(true, true).slideToggle(this.speed, fn);
	},

	setClass: function(selector, className){
		$(selector).find('a').attr('class', className);
	},

	selectItem: function(selector, index, selectedClass, defaultSelector){
		if(!selector || isNaN(index = parseInt(index)))
			$($(defaultSelector).find('a').get(0)).attr('class', selectedClass);
		else
			$($(selector).find('a').get(isNaN(index) ? 0 : index)).attr('class', selectedClass);
	}
}

$(function($){
	$.fn.disabled = function(){
		this.attr('disabled', true).css('opacity', 0.75).css('color', '#666');
		return this;
	}
	$.fn.enabled = function(){
		this.removeAttr('disabled').css('opacity', 1).css('color', '#000');
		return this;
	}
})

function DateDiff(d1,d2){
	var day = 24 * 60 * 60 *1000;
	try{
		var dateArr = d1.split("-");
		var checkDate = new Date();
		checkDate.setFullYear(dateArr[0], dateArr[1]-1, dateArr[2]);
		var checkTime = checkDate.getTime();

		var dateArr2 = d2.split("-");
		var checkDate2 = new Date();
		checkDate2.setFullYear(dateArr2[0], dateArr2[1]-1, dateArr2[2]);
		var checkTime2 = checkDate2.getTime();

		var cha = (checkTime - checkTime2)/day;
		return cha;
	}catch(e){
		return false;
	}
}//end fun
function msgbox(currObj, status, msg, focus){
	var msgel = currObj.nextAll('span.pub-msgbox').removeClass('info error ok');

	if(status === 'OK')
		msgel.addClass('ok').html('');
	else if(status === 'ERROR_K')
		msgel.removeClass('info error ok');
	else if(status == 'ERROR')
		msgel.addClass('error').html(msg);
	else
		msgel.addClass('info').html(msg);

	return false;
}
//复制指定数据到剪贴板
var copyToClipBoard = function (content, content1){
	var clipBoardContent= content;
	if(window.clipboardData){
		window.clipboardData.setData("Text", clipBoardContent);
	}else if(navigator.userAgent.indexOf("Opera") != -1){
		window.location = clipBoardContent;
	}else if (window.netscape){
		try{
			netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
		}catch (e){
			alert("您的当前浏览器设置已关闭此功能！请按以下步骤开启此功能！\n新开一个浏览器，在浏览器地址栏输入'about:config'并回车。\n然后找到'signed.applets.codebase_principal_support'项，双击后设置为'true'。\n声明：本功能不会危极您计算机或数据的安全！");
		}
		var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
		if (!clip) return;
		var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
		if (!trans) return;
		trans.addDataFlavor('text/unicode');
		var str = new Object();
		var len = new Object();
		var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
		var copytext = clipBoardContent;
		str.data = copytext;
		trans.setTransferData("text/unicode",str,copytext.length*2);
		var clipid = Components.interfaces.nsIClipboard;
		if (!clip) return false;
		clip.setData(trans,null,clipid.kGlobalClipboard);
	}
	content1 ? alert("复制"+content1+"成功！") : alert("已成功复制！");
	return true;
}
// 评分处理
$(function(){
    var items = $('#score-items a');
    var score_num = $('#score-num');
    var score_value = $('#score-value');
    var score_text = $('#score-text');
    function parseScore(score){
	return parseFloat(score).toFixed(1);
    }
    items.mouseover(function(){
	set_score(items.index(this)+1);
    }).bind('mouseout blur', function(){
	var score = parseScore(items.parent().attr('score'));
	set_score(score);
    }).click(function(){
	var item = items.parent();
	var key='game_score_'+item.attr('game_id');
	var now=parseInt((new Date()).getTime()/1000);
	var score = parseScore(items.index(this)+1);
	if($.localStorage(key)!=null && $.localStorage(key)>now){
	    alert('您今天已经评过分了');
	    return false;
	}

	$.post('/plus/score_ajax.php', {
	    id:item.attr('game_id'), 
	    score:score
	}, function(d){
	    item.attr('score', score);
	    set_score(score);
	    $.localStorage(key, now+86400);
	});
	
	reset_items();
	items.blur();
	items.unbind('mouseover mouseout blur click');
	items.focus(function(){
	    items.blur();
	})
    });
    function reset_items(){
	items.css('cursor', 'auto');
    }
    function set_score(score){
	score = parseScore(score);
	score_text.html($(items.get(score>0?parseInt(score-1):0)).attr('title'));
	score_num.removeClass().addClass('star_bar'+parseInt(score));
	score_value.html(score);
    }
    var score = parseScore(items.parent().attr('score'));
    set_score(score);
});


/**
 * 标签切换函数
 * @autor such
 * @since 2012-7-28
 * 如:
 * 切换按钮的id  xx_1 xx_2 xx_3
 * 切换的内容id xx_1_content xx_2_content xx_3_content
 * index 当前的索引 如示例中的:1|2|3
 * prefix 切换按钮ID前缀 则前缀为:xx_
 * total 切换标签的总数 如示例total为3
 * normalCss 未选中时的按钮样式数组 形如: ['class1','class2']
 * selectCss 选中时按钮的样式数组 形如: ['class3','class4']
 */

function shift_clear(prefix,total,normalCss,selectCss){
	for(var i=1;i<=total;++i){

		for(var j=0;j<selectCss.length;++j){
			$("#"+prefix+i).removeClass(selectCss[j]);
		}

		for(var x=0;x<normalCss.length;++x){
			$("#"+prefix+i).addClass(normalCss[x]);
		}

		$("#"+prefix+i+"_content").hide();
	}
}

function shift_choose(index,prefix,total,normalCss,selectCss){
	shift_clear(prefix,total,normalCss,selectCss);

	for(var x=0;x<normalCss.length;++x){
		$("#"+prefix+index).removeClass(normalCss[x]);
	}

	for(var j=0;j<selectCss.length;++j){
		$("#"+prefix+index).addClass(selectCss[j]);
	}
  if(prefix=="slist_" && index==1){
    $("#"+prefix+"1_content").show();
    $("#"+prefix+"2_content").show();
  }else{
    $("#"+prefix+index+"_content").show();
  }
}

String.prototype.trim = function() 
{ 
return this.replace(/(^\s*)|(\s*$)/g, ""); 
} 
String.prototype.ltrim = function() 
{ 
return this.replace(/(^\s*)/g, ""); 
} 
String.prototype.rtrim = function() 
{ 
return this.replace(/(\s*$)/g, ""); 
} 
