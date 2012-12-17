JOO.setMode('static');
var jq = jQuery;
JOO.apply('SSOClient', {
	baseURL: 'http://www.kaifu.com/',
	loginData: null,
	URLParam: function(){
		var get = document.location.search.substring(1).split('&'),
		params = new Object();
		if(get == "")
			return [];
		
		var has = false;
		for(var i in get){
			var param = get[i].split('=');
			if(param.length == 2){
				params[param[0]] = param[1];
				has = true;
			}
		}
		return has ? params : [];
	}(),
	timestamp: function(){
		return parseInt((new Date()).getTime()/1000)
	},
	redirect: function(url, blank){
		blank ? window.open(url) : window.location = url;
	},
	showPopup: function(){
		var base = 'http://res.kaifu.com/isy/templates/front/images/';
		if(jq.popup.isOpen())
			return true;
		jq.popup({
			title: '您还没有登录',
			opacity: 0.5,
			width:350,
			content: '<form onsubmit="return false;" class="pop-wrap wrap">'
			+'<div class="clear"></div>'
		
			+'<div class="ssologin-wrap">'
			+'<div class="msgbox"></div>'
			+'<div><span>用户名</span><input type="text" class="username" maxlength="15"/></div>'
			+'<div><span>密  码</span><input type="password" class="password"/></div>'
			+'<div><span>验证码</span><input type="text" class="verify"/><img class="verify-code" height="26" width="51" align="absmiddle" onclick="SSOClient.reload(this);"/></div>'
			+'<div><input type="checkbox" id="popRemember" class="checkbox remember"/> <label for="popRemember">记住密码</label> <a href="/passwordback.php">忘记密码</a></div>'
			+'<div><input type="submit" class="submit" value=""/> <a href="/register.php">注册新用户</a></div>'
			+'<div>使用其他帐号登录</div>'
			+'<div class="wbdiv">'
			+'<a href="/applogin/sina"><img src="'+base+'xl_01.jpg" width="18" height="18" /> 新浪微博账号</a>'
			+'<a href="/applogin/tencent"><img src="'+base+'tx_01.jpg" width="18" height="18" /> 腾讯微博账号</a>'
			+'<a href="/applogin/sohu"><img src="'+base+'souh_01.jpg" width="18" height="18" /> 搜狐账号</a>'
			+'<a href="/applogin/renren"><img src="'+base+'rr_01.jpg" width="18" height="18" /> 人人网账号</a>'
			+'<a href="/applogin/kaixin"><img src="'+base+'kx_01.jpg" width="18" height="18" /> 开心网账号</a>'
			+'<a href="/applogin/baidu"><img src="'+base+'bd_01.jpg" width="18" height="18" /> 百度账号</a>'
			+'</div>'
			+'</div>'

			+'</form>'

			+'<div class="full-msg"></div>'
		});
		var self = this;
		jq('.pop-wrap .ssologin').click(function(){
			self.toLogin()
		});
		jq('.pop-wrap .ssoreg').click(function(){
			self.toRegister()
		});
		jq('.pop-bind .existing').click(function(){
			self.toLoginBind()
		});
		jq('.pop-bind .newaccount').click(function(){
			self.toRegisterBind()
		});
	},

	login: function(){
		this.showPopup();
		this.toLogin();
	},

	register: function(){
		this.showPopup();
		this.toRegister();
	},

	toRegister: function(){
		this.showPopup();
		jq('#dialog').removeClass().addClass('dialog-register');
		jq('.ssoreg').addClass('on');
		jq('.ssologin').removeClass('on');
		jq('.ssologin-wrap').hide();
		jq('.ssoreg-wrap').show().find('img').attr('src', this.baseURL + 'imgcode.php?' +  Math.random());
		jq.popup.resize();

		var self = this;
		this.initRegister('.ssoreg-wrap', function(){
			self.doRegister(function(d){
				if(d.status == 0){
					self.setLoginInfo(d);
				}else{
					if (d.status == 15)
						document.location.href = '/binding.php?action=useremail';
					self.msgBox(d.msg);
				}
			});
		});
	},

	initRegister: function(wrap, loginCallback, msgbox){
		var self = this;
		this.currWrap = this.registerWrap = jq(wrap);
		this.currWrap.click(function(){
			self.currWrap = self.registerWrap = jq(this);
		});
		msgbox = msgbox || function(currObj, status, msg){
			var msgel = currObj.nextAll('span.pub-msgbox,span').removeClass('info error ok');

			if(status == 'OK')
				msgel.addClass('ok').html('');
			else if(status == 'ERROR_K')
				currObj.nextAll('span.pub-msgbox,span').removeClass('info error ok');
			else if(status == 'ERROR')
				msgel.addClass('error').html(msg);
			else
				msgel.addClass('info').html(msg);
			return false;
		};
		var RegTaskChecker = new TaskChecker();
		var checkUserName = function(str_tmp){
			var el = self.registerWrap.find('.regusername');
			if(el.val() != '' && el.val() == el.attr('taskChecked')){
				msgbox(el, 'OK');
				RegTaskChecker.checkTaskNow(true);
				return true;
			}else{
				el.removeAttr('taskChecked');
			}

			if(el.val() == '' && str_tmp == 0)
				return msgbox(el, 'ERROR_K', '1');
			if(el.val() == '' && str_tmp == 1)
				return msgbox(el, 'ERROR', '请输入您的账号');
			if(!/^[a-zA-Z].*[a-zA-Z0-9]$/.test(el.val()))
				return msgbox(el, 'ERROR',  '账号只能以字母开头,字母或数字结尾');
			if(!/^[a-zA-Z][a-zA-Z0-9_]{2,13}[a-zA-Z0-9]$/.test(el.val()))
				return msgbox(el, 'ERROR',  '账号由4-15位英文、数字或者下划线组成');

			_Ajax.getJSON(self.baseURL + 'sso.php', {
				action: 'checkUsername',
				username : el.val()
			}, function(d){
				if(d.status == 0){
					el.attr('taskChecked', el.val());
					RegTaskChecker.checkTaskNow(true);
					msgbox(el, 'OK');
				}else
					msgbox(el, 'ERROR', d.msg);
			});
		};
		var checkEmail = function(str_tmp){
			var emailReg = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
			var el = self.registerWrap.find('.regemail');
			if(el.val() != '' && el.val() == el.attr('taskChecked')){
				msgbox(el, 'OK');
				return true;
			}else
				el.removeAttr('taskChecked');

			if(el.val() == '' && str_tmp == 0)
				return msgbox(el, 'ERROR_K', '');
			if(el.val() == '' && str_tmp == 1)
				return msgbox(el, 'ERROR', '请输入您的E-MAIL');				
			if(!emailReg.test(el.val()))
				return msgbox(el, 'ERROR', '邮箱地址不符合规则');
			
			msgbox(el, 'OK');
			el.attr('taskChecked', el.val());
			return true;
		};
		var checkPassword = function(str_tmp){
			var pwdReg = /^[0-9a-zA-Z~`!@#$%\^&\*\(\)-_+=|\\\{\[\}\]:;\"\'<,>\.?/]{6,15}$/;
			var el = self.registerWrap.find('.regpassword');
			if(el.val() != '' && el.val() == el.attr('taskChecked')){
				msgbox(el, 'OK');
				return true;
			}else
				el.removeAttr('taskChecked');

			if(el.val() == '' && str_tmp == 0)
				return msgbox(el, 'ERROR_K', '');
			if(el.val() == '' && str_tmp == 1)
				return msgbox(el, 'ERROR', '请输入您的密码');
			if(!pwdReg.test(el.val()))
				return msgbox(el, 'ERROR', '密码由6-15位英文字母、数字及字符组成');
			
			msgbox(el, 'OK');
			el.attr('taskChecked', el.val());
			return true;
		};
		var checkRePassword = function(str_tmp){
			var el = self.registerWrap.find('.regrepassword');
			if(el.val() != '' && el.val() == el.attr('taskChecked')){
				msgbox(el, 'OK');
				return true;
			}else
				el.removeAttr('taskChecked');

			if(el.val() == '' && str_tmp == 0)
				return msgbox(el, 'ERROR_K', '');
			if(el.val() == '' && str_tmp == 1)
				return msgbox(el, 'ERROR', '请重复输入密码');
			if(el.val() != self.registerWrap.find('.regpassword').val())
				return msgbox(el, 'ERROR', '两次输入的密码不一致');

			msgbox(el, 'OK');
			el.attr('taskChecked', el.val());
			return true;
		};
		var checkVerify = function(str_tmp){
			var el = self.registerWrap.find('.regverify');
			if(el.val() != '' && el.val() == el.attr('taskChecked')){
				msgbox(el, 'OK');
				RegTaskChecker.checkTaskNow(true);
				return true;
			}else
				el.removeAttr('taskChecked');
			
			if(el.val() == '' && str_tmp == 0)
				return msgbox(el, 'ERROR_K', '');
			if(el.val() == '' && str_tmp == 1)
				return msgbox(el, 'ERROR', '请输入验证码');
			if(!/^[0-9]{4,4}$/.test(el.val()))
				return msgbox(el, 'ERROR', '请输入正确的验证码');

			_Ajax.getJSON(self.baseURL + 'sso.php', {
				action: 'checkVerify',
				verify : el.val()
			}, function(d){
				if(d.status == 0){
					el.attr('taskChecked', el.val());
					RegTaskChecker.checkTaskNow(true);
					msgbox(el, 'OK');
				}else
					msgbox(el, 'ERROR', d.msg);
			});
		};
		var checkProtocol = function(){
			var el = self.registerWrap.find('.regprotocol');
			if(!el.attr('checked'))
				return msgbox(el, 'ERROR', '不同意《开服网用户服务协议》无法注册');			
			msgbox(el, 'OK');
			return true;
		};
		this.registerWrap.find('.regusername').focus(function(){
			msgbox(jq(this), null, '账号由4-15位英文或者数字以及下划线组成');
		}).blur(function(){
			checkUserName(0);
		});
		this.registerWrap.find('.regemail').focus(function(){
			msgbox(jq(this), null, '请输入您的Email邮箱地址');
		}).blur(function(){
			checkEmail(0)
		});
		this.registerWrap.find('.regpassword').focus(function(){
			msgbox(jq(this), null, '密码由6-15位英文字母、数字及字符组成');
		}).blur(function(){
			checkPassword(0)
		});
		this.registerWrap.find('.regrepassword').focus(function(){
			msgbox(jq(this), null, '请再次输入您的登录密码');
		}).blur(function(){
			checkRePassword(0)
		});
		this.registerWrap.find('.regverify').focus(function(){
			msgbox(jq(this), null, '请输入验证码');
		}).blur(function(){
			checkVerify(0)
		
		});

		this.registerWrap.find('.regsubmit').click(function(){
			RegTaskChecker.initCheckTask();
			RegTaskChecker.addCheckTask('ajax', checkUserName(1));
			RegTaskChecker.addCheckTask('noajax', checkEmail(1));
			RegTaskChecker.addCheckTask('noajax', checkPassword(1));
			RegTaskChecker.addCheckTask('noajax', checkRePassword(1));
			RegTaskChecker.addCheckTask('ajax', checkVerify(1));
			RegTaskChecker.addCheckTask('noajax', checkProtocol(1));
			RegTaskChecker.onCheckComplete(loginCallback);
			RegTaskChecker.checkTaskNow();
		});
	},

	doRegister: function(registerCallback){
		this.msgBox('正在提交注册信息，请稍候...');
		jq('.regsubmit').attr('disabled',true);
		_Ajax.getJSON(this.baseURL + 'sso.php', jq.extend({
			action: 'register',
			username: this.registerWrap.find('.regusername').val(),
			email: this.registerWrap.find('.regemail').val(),
			password: this.registerWrap.find('.regpassword').val(),
			repassword: this.registerWrap.find('.regrepassword').val(),
			verify: this.registerWrap.find('.regverify').val()
		}, (this.URLParam['client'] != undefined ? {
			client: this.URLParam['client']
		} : {}), (this.URLParam['sid'] != undefined ? {
			sid: this.URLParam['sid']
		} : {})), function(d){
			registerCallback(d);
		});
	},

	toRegisterBind: function(){
		this.showPopup();
		jq('#dialog').removeClass().addClass('dialog-bind');
		jq('#dialog-title').html('绑定账号');
		jq('.pop-wrap').css('display', 'none');
		jq('.pop-bind').css('display', 'inline');
		jq('.newaccount').addClass('on');
		jq('.existing').removeClass('on');
		jq('.pop-bind-wrap').hide();
		jq('.pop-regbind-wrap').show().find('img').attr('src', this.baseURL + 'imgcode.php?' +  Math.random());
		var self = this;
		this.initRegister('.pop-regbind-wrap', function(d){
			self.doRegister(function(d){
				if(self.registerBindCallback)
					self.registerBindCallback(d);
				else
					self.setLoginInfo(d);
			});
		});
	},

	toLogin: function(){
		this.showPopup();
		jq('#dialog').removeClass().addClass('dialog-login');
		jq('.ssologin').addClass('on');
		jq('.ssoreg').removeClass('on');
		jq('.ssoreg-wrap').hide();
		jq('.ssologin-wrap').show().find('img.verify-code').attr('src', this.baseURL + 'imgcode.php?' +  Math.random());
		jq.popup.resize();
		var self = this;
		this.initLogin('.ssologin-wrap', function(d){
			self.doLogin(function(d){
				self.setLoginInfo(d);
				if(d.status != 0)
					self.reload(self.currWrap.find('img.verify-code')[0]);
				else
					top.location.reload();
			});
		});
		this.loginWrap.find('.username,.username-on').focus();
	},
	
	initLogin: function(wrap, loginCallback){
		var self = this;
		this.currWrap = this.loginWrap = jq(wrap);
		this.currWrap.click(function(){
			self.currWrap = self.loginWrap = jq(this);
		});
		var blur = function(currObj){
			if(currObj.val() != '')
				currObj.attr('class', currObj.attr('class').split('-')[0]+'-on');
			else
				currObj.attr('class', currObj.attr('class').split('-')[0]);
		};
		this.loginWrap.find('.username,.password,.verify').focus(function(){
			jq(this).attr('class', this.className.split('-')[0]+'-on');
		});

		var username = function(){
			return self.loginWrap.find('.username,.username-on')
		},
		password = function(){
			return self.loginWrap.find('.password,.password-on')
		},
		verify = function(){
			return self.loginWrap.find('.verify,.verify-on')
		};
		
		var LoginTaskChecker = new TaskChecker();

		var checkUserName = function(){
			self.msgBox('');
			var el = username();
			blur(el);
			if(el.val() == '')
				return self.msgBox('请填写用户名');
			
			return true;
		};
		var checkPassword = function(){
			self.msgBox('');
			var el = password();
			blur(el);
			if(el.val() == '')
				return self.msgBox('请填写登录密码');
			
			return true;
		};
		var checkVerify = function(){
			self.msgBox('');
			var el = verify();
			if(el.length == 0){
				LoginTaskChecker.checkTaskNow(true);
				return true;
			}
			blur(el);
			if(el.val() != '' && el.val() == el.attr('taskChecked')){
				LoginTaskChecker.checkTaskNow(true);
				return true;
			}else
				el.removeAttr('taskChecked');
			
			if(el.val() == '')
				return self.msgBox('请填写验证码');
			if(el.val().length != 4)
				return self.msgBox('请填写正确的验证码');

			
			_Ajax.getJSON(self.baseURL + 'sso.php', {
				action: 'checkVerify',
				verify : el.val()
			}, function(d){
				if(d.status == 0){
					el.attr('taskChecked', el.val());
					LoginTaskChecker.checkTaskNow(true);
				}else{
					self.msgBox(d.msg);
				}
			});
		};

		username().blur(checkUserName);
		password().blur(checkPassword);
		verify().blur(checkVerify);
		this.loginWrap.find('.submit').click(function(){
			LoginTaskChecker.initCheckTask();
			LoginTaskChecker.addCheckTask('noajax', checkUserName);
			LoginTaskChecker.addCheckTask('noajax', checkPassword);
			LoginTaskChecker.addCheckTask('ajax', checkVerify);
			LoginTaskChecker.onCheckComplete(loginCallback);
			LoginTaskChecker.checkTaskNow();
		});
	},

	doLogin: function(loginCallback){
		var self = this;
		var username = function(){
			return self.loginWrap.find('.username,.username-on')
		},
		password = function(){
			return self.loginWrap.find('.password,.password-on')
		},
		verify = function(){
			var verify = self.loginWrap.find('.verify,.verify-on');
			return verify.length == 0 ? '' : verify.val();
		},
		remember = this.loginWrap.find('.remember');

		this.msgBox('正在登录，请稍候...');
		
		_Ajax.getJSON(this.baseURL + 'sso.php', {
			action: 'login',
			username: escape(username().val()),
			password: jq.md5(password().val()),
			timestamp: this.timestamp(),
			verify: escape(verify()),
			remember: remember.attr('checked') ? 1 : 0
		}, loginCallback);
	},

	checkLogin: function(loginCallback){
		var self = this;
		if(jq.cookie('kaifu_user_id')){
			_Ajax.getJSON(this.baseURL + 'sso.php', {
				action: 'checkLogin'
			}, function(d){
				self.loginData = d;
				loginCallback(d);
			});
		}
	},
	
	setLoginInfo: function(d){
		var self = this;
		this.Banner.showUserInfo(d);
		if(d){
			if(d.url)
				document.location.href = d.url;
			if(d.status == 0){
				jq.popup.hide();
			}else
				this.msgBox(d.msg);
		}else{
			this.checkLogin(function(d){
				self.Banner.showUserInfo(d);
				if(d.status == 0)
					self.Banner.checkNewPM();
			});
		}
	},

	logout: function(){
		var self = this;
		this.doLogout(function(){
			self.setLoginInfo();
			top.location.reload();
		});
	},

	doLogout: function(logoutCallback){
		if(jq.cookie('kaifu_user_id')){
			_Ajax.getJSON(this.baseURL + 'sso.php', {
				action: 'logout'
			}, logoutCallback);
		}else{
			logoutCallback();
		}
	},

	showUserInfoToLoginWrap: function(d){
		try{
			var login = $('.ssoindexlogin-wrap'),
			nologin = $('.ssoindexnologin-wrap');
			if(d && d.status == 0){
				login.show();
				try{
					nologin.find('form')[0].reset();
				}catch(e){};
				nologin.hide();
				nologin.find('.username-on,.password-on').blur();
				nologin.find('.msgbox').html('');
				login.find('#username').html(d.userInfo.username);
			}else{
				nologin.show();
				login.hide();
			}
		}catch(e){}
	},

	reload: function(currObj){
		var index = currObj.src.indexOf('?');
		var src = index != -1 ? currObj.src.substring(0, index) : currObj.src;
		currObj.src = src + '?' + Math.random();
	},

	msgBox: function(msg, el){
		this.currWrap.find('.msgbox').html(msg);
		if(el)
			el.click().focus();
		return false;
	},

	fullMsgBox: function(msg){
		jq.popup.hide();
		return;
		jq('#dialog-content').find('form').css('display', 'none');
		jq('#dialog-content').find('div.full-msg').show().html(msg);
		setTimeout(jq.popup.hide, 3000);
	}
});

JOO.apply('SSOClient.Banner', {
	topbar: null,

	show: function(){
		
		this.showCSS();
                
		document.write('<div id="tools">');
		document.write('<div class="tminmenu ">');
		document.write('<ul class="fl tminmenu_l"><li><a class="bhome black" href="/">首页</a></li><li id="sitemap"><a class="black menu" href="#">站内导航</a></li><li id="played"><a class="black menu" href="#">我玩过的</a></li><li><a class="black" href="http://www.kaifu.com/index.php?action=index_4_5 " target="_blank">旧版开服网</a></li><li><a class="black" href="javascript:;" onclick="$(\'#suggest\').show();$(\'html,body\').animate({scrollTop:$(\'#suggest\').offset().top},1,\'\',function(){$(\'#fcontent\').focus();});">改版反馈</a></li></ul>');
		document.write('<div class="fr tminmenu_2 login-info"></div>');
		document.write('</div></div>');
                
		this.topbar = jq('#tools');
		
		var navlist = '<div id="navlist" class="downlist" style="display:none;">';
		navlist += '<a href="http://www.kaifu.com/" target="_blank">返回首页</a>';
		navlist += '<a href="http://www.kaifu.com/serverlist.html" target="_blank">新服大全</a>';
		navlist += '<a href="http://www.kaifu.com/gamelist.html" target="_blank">找游戏</a>';
		navlist += '<a href="http://www.kaifu.com/gift.html" target="_blank">新手卡/激活码</a>';
		navlist += '<a href="http://www.kaifu.com/article-100--0-0-0-0-0-0-0.html" target="_blank">评测</a>';
		navlist += '<a href="http://www.kaifu.com/gametest-0.html" target="_blank">新游戏</a>';
		navlist += '<a href="http://www.kaifu.com/chart-webgame.html" target="_blank">开服统计</a>';		
		navlist += '<a href="http://www.kaifu.com/guildlist.html" target="_blank">公会</a>';
		navlist += '<a href="http://www.kaifu.com/gametop-webgame.html" target="_blank">排行榜</a>';
		navlist += '<a href="http://www.kaifu.com/article.html" target="_blank">资讯</a>';
		navlist += '<a href="http://www.kaifu.com/platformlist.html" target="_blank">运营商</a>';
		navlist += '<a href="http://www.kaifu.com/picturebooklet-0-0.html" target="_blank">图库</a>';
		navlist += '</div>';
                
		$('#sitemap').append(navlist);
		$("#sitemap").hover(function(){
			$("#navlist").show();
		},function(){
			$("#navlist").hide();
		});
                
		this.showlishijilu();
		
		this.parent.setLoginInfo();
	},
	showlishijilu: function(){
		var webgame = '<div id="played_games" class="downlist" style="display:none;">';
		var lishijilu = $.localStorage('lishijilu');
		//var lishijilu = jQuery.cookie('lishijilu');
		if (lishijilu){
			var lishijilu_a = new Array();
			var lishijilu_b = new Array();
			lishijilu_a = lishijilu.split(",");
			for (var i=0;i<lishijilu_a.length;i++){
				lishijilu_b = lishijilu_a[i].split("|");
				webgame += '<a href="http://www.kaifu.com/gamewebsite-'+lishijilu_b[1]+'.html" title="'+lishijilu_b[0]+'" target="_blank">'+lishijilu_b[0]+'</a></li>';
			}
		}else{
			webgame += '<span class="no_played_games">暂无浏览记录</span>';
		}
		webgame += '</div>';
		$("#played").append(webgame);
		$("#played").hover(function(){
			$("#played_games").show();
		},function(){
			$("#played_games").hide();
		});
	},
	showCSS: function(){
		var base = 'http://res.kaifu.com/isy/templates/front/images/';
		var css = '<style type="text/css">';
		css += '#tools{ width:100%; height:37px; background:url('+base+'back23u1.gif) repeat-x;}';
		css += '#tools .t_b{ width:1000px; height:37px; margin:0 auto;}';
		css += '#tools .t_b .logo_1{  background:url('+base+'back23u.gif) 0 -235px no-repeat ; display: block; float: left; height: 37px; line-height: 37px;overflow: hidden;padding-left: 60px; width: 210px; }';
		css += '#tools .t_b .login-info{  float: left;  height: 37px; line-height: 37px; padding-right: 5px; text-align: left; width: 410px;  }';
		css += '#tools .t_b .reg_div{  float: right;  height: 37px; line-height: 37px; padding-right: 5px; text-align: right; width: 550px;  }';
		css += '#tools .t_b .reg_div a{ margin-left: 2px; margin-right: 2px; }';
		css += '#tools .t_b .reg_div a.row_icon,#tools .t_b .login-info a.row_icon{ background:url('+base+'back23u.gif) right -643px no-repeat; display: inline-block; width:auto; text-align:left; padding-right:15px;}';
		css += '#tools .list{position:relative;height:auto;margin:0 5px 0 0;padding:0;z-index:999999;}';
		//display:block;
		css += '#tools .list-wrap { background: none repeat scroll 0 0 #FFFFFF; border: 1px solid #D1D1D1;  display: none; padding: 5px 0;position: absolute;  right: -12px;  text-align: left;  top: 29px;  width: 100px; z-index: 999999; }';
		css += '#tools .over .list-wrap{display:block;}';
		css += '#tools .list-wrap ul li{width:100px;float:left;overflow:hidden;text-align:center;line-height:12px;}';
		css += '#tools .list-wrap ul li a{line-height:22px;text-decoration: none;}';

		css += '#tools .list-wrap2{display:none;position:absolute;left:0;_left:-1px;top:29px;_top:30px;text-align:left;width:200px;overflow:hidden;background:#FFF;border:1px solid #D1D1D1;padding:5px 0; z-index:9999;overflow:hidden;}';
		css += '#tools .over .list-wrap2{display:block;}';
		css += '#tools .list-wrap2 ul li{width:200px;height:22px;float:left;overflow:hidden;line-height:12px;}';
		css += '#tools .list-wrap2 ul li a{line-height:22px;text-decoration: none;}';
		css += '.clear{clear:both;}';

		css += 'html body #tools a.orange{color:#ff6600;}';
		css += 'html body #tools a.red{color:#ff0000;}';
		css += '#dialog{position:absolute;border:1px solid #DDDDDD;background:#FFF;}';
		css += '#dialog .full-msg{display:none;height:30px;color:red;text-align:center;font-size:14px;font-weight:bold;line-height:300px}';
		css += '#dialog .p14{font-size:14px;}';
		css += 'body .dialog-login{width:400px;}';
		css += 'body .dialog-register{width:650px;}';
		css += '#dialog-header{height:37px;background:url('+base+'toolsback.jpg) repeat-x 0 -75px;}';
		css += '#dialog-title{float:left;display:inline;font:14px/24px "宋体";font-weight:bold;line-height:37px;padding-left:16px;}';
		css += '#dialog-close{float:right;margin:5px 5px 0 0;cursor:pointer;width:22px;height:22px;background:url('+base+'Closed2.gif);}';
		css += '#dialog-content .popup-tab{width:50%; text-align:center; float:left; height:39px;cursor:pointer; background:url('+base+'toolsback.jpg) 0 -37px; line-height:39px;color: #00B7FF;}';
		css += '#dialog-content .popup-tab span{height:39px; margin-left:auto; margin-right:auto; font-weight:bold;line-height:39px; background:url('+base+'index-q2_23.gif) left center no-repeat;padding-left:20px;}';
		css += '#dialog-content .on{background: none;color:#666;}';
		css += '#dialog-content .on span{background-image:url('+base+'index-q2_21.gif)}';
		css += '#dialog-content{clear:left;}';
		css += '#dialog-content .wrap{border:1px solid #DDDDDD;background: url("'+base+'backtop.gif") no-repeat scroll center 3px #FFFFFF;}';
		css += '#dialog-mask{position:absolute;top:0;left:0;height:500px;width:100%;background:#000;z-index:100}';
		css += '.clear{clear:both;}';
		css += '#dialog .ssologin-wrap{margin:0px 0px 5px 0px; padding:25px 0px 0px 25px;_padding-bottom:10px;width:320px;overflow:hidden;}';
		css += '#dialog .ssologin-wrap div{clear:both;}';
		css += '#dialog input{font-size:14px;}';
		css += '.msgbox, #dialog .msgbox{display:block;margin:0;font-size:14px;height:16px;line-height:16px;font-weight:bold;color:red;text-indent:10px;}';
		css += '.username,.username-on,.password,.password-on,.verify,.verify-on{float: left;vertical-align:middle;margin:5px 0;padding-top:4px;height:20px;width:190px;border:1px solid #7f9db9; background:url('+base+'loginicon.gif) 5px 0 no-repeat; font-size:14px;line-height:14px; color:#333; text-indent: 26px }';
		css += '.username-on{background-position:5px -23px;}';
		css += '.password{background-image:url('+base+'loginicon.gif); background-position:5px -48px;}';
		css += '.password-on{background-position:5px -72px;}';
		css += '.input3{width:75px; height:28px; background:url('+base+'index_77.jpg); text-align:center; line-height:26px; border:none}';
		css += '.verify{background-image:url('+base+'loginicon.gif); background-position:5px -96px;width:137px;}';
		css += '.verify-on{background-position:5px -120px;width:137px;}';
		css += '.verify-code{float:left;vertical-align:middle;margin:5px 0 0 5px;}';
		css += '.checkbox{margin:-1px auto auto 0px;_margin-left:-4px;vertical-align:middle;}';
		css += '#popProtocol{margin-left:39px;_margin-left:32px;}';
		css += '.ssologin-wrap label{margin-left:-4px;}';
		css += '.submit{margin:12px auto;width:188px; height:46px; background:url('+base+'index_13.jpg) no-repeat; border:none; cursor:pointer;}';
		css += '.regbt{background:url('+base+'index-q2_32.gif); width:188px; height:46px; border:none; cursor:pointer;}';
		css += '.applogin{display:inline-block;width:16px;height:16px;}';
		css += '.qq{background: url('+base+'applogin/qq.jpg) no-repeat;}';
		css += '.qq_w{background: url('+base+'applogin/qq_w.jpg) no-repeat;}';
		css += '#dialog-content span {float: left;padding-right: 10px;text-align: right; width: 50px;line-height:40px}';

		css += '.ssoreg-wrap div,.pop-regbind-wrap div{clear:both;margin:5px 12px;padding:0;}';
		css += '.ssoreg-wrap div label{display:inline-block;vertical-align:middle;height:26px;line-height:26px;}';
		css += '.pop-regbind-wrap div.msgbox{margin:0;margin-left:5em;}';
		css += '.ssoreg-wrap div img,.pop-regbind-wrap div img,.ssologin-wrap div img{cursor:pointer;}';
		css += '.ssoreg-wrap div span,.ssoregindex-wrap div span,.pop-regbind-wrap div span,#dialog span.pub-msgbox{display:none;margin:0px auto auto 20px;vertical-align:top;background:#EBFAFF url('+base+'wicon.gif) no-repeat 2px 4px;border:1px solid #7CE0FD;min-height:20px;_height:20px;_margin-top:1px;line-height:20px;padding:2px 0 2px 20px;width:240px;}';
		css += '#dialog span.error{display:inline-block;border:1px solid #fe0000;background:#fff4ef url('+base+'wrong.jpg) no-repeat 2px 4px; color:#fe0000}';
		css += '#dialog span.ok{display:inline-block;border:1px solid #fff;background:transparent url('+base+'ok.gif) no-repeat 2px 4px; color:#00b7ff}';
		css += '#dialog span.info{display:inline-block; color:#00b7ff}';
		css += '#dialog-content .wbdiv a {display: inline-block;line-height: 25px; width:100px;}';
		css += '#dialog-content .wbdiv a img {padding: 5px 0px 5px 0;vertical-align: middle;}';

		css += '.reginput{width:200px;height:20px;padding-top:4px;text-indent:3px;vertical-align:top;border:1px solid #7F9DB9;}';
		css += '#dialog .regverify{width:144px;margin-right:5px;}';
		css += '.dialog-bind{width:650px;}';
		css += '.ssoreg-wrap, .pop-bind,.pop-regbind-wrap{display:none;}';
		css += '.pop-bind .bind-tip{margin:24px 36px 0;}';
		css += '.pop-bind .bind-tip img{vertical-align:middle;}';
		css += '.pop-bind .submit{width:96px;height:35px;background:url('+base+'bdbt.gif);}';
		css += '.pop-bind-wrap{margin:12px auto;overflow: hidden; width: 222px;*width: 220px;}';
		css += '</style>';
		document.write(css);
	},
	showUserInfo: function(d){
		if (d && d.status == 17)
			document.location.href = '/binding.php?action=useremail';
		
		if(d && d.status == 0){
			this.topbar.find('.login-info').html('<div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare fr" onclick="GameInfo.fenxiang_jifen()"><span class="fr top_weibo"><a class="bds_tqq" title="腾讯微博"></a><a class="bds_tsina" title="新浪微博"></a></span><span class="fr wb_txt">分享:</span></div><span class="fr">您好，<a href="/userindex.php" class="org" target="_blank">' + d.userInfo.nickname + '</a> <a href="/userindex.php" target="_blank">我的游戏</a> 通知(<a href="/usernotice.php" target="_blank"><span class="pm-new org" >0</span></a>) 金币(<a href="/userwealth.php" target="_blank"><span class="gold org" >0</span></a>) <a href="javascript:void(0);" onclick="SSOClient.logout();return false;">退出</a>&nbsp;&nbsp;</span>');
		}else if (!jq.cookie('kaifu_user_id')){

                        var otherLogin = '<div class="fr" id="otherLogin"><a href="javascript:;" class="black menu">其他账号登录</a>&nbsp;&nbsp;<div id="othersUrl" class="downlist" style="display:none;">'
                                +'<a target="_blank" href="/applogin/sina">新浪微博账号</a>'
                                +'<a target="_blank" href="/applogin/tencent">腾讯微博账号</a>'
                                +'<a target="_blank" href="/applogin/sohu">搜狐账号</a>'
                                +'<a target="_blank" href="/applogin/renren">人人网账号</a>'
                                +'<a target="_blank" href="/applogin/kaixin">开心网账号</a>'
                                +'<a target="_blank" href="/applogin/baidu">百度账号</a>' 
                                +'</div></div>';
                        
			this.topbar.find('.login-info').html('<span class="bdshare_t"><span class="fr top_weibo"><a class="sina_weibo" title="新浪微博" target="_blank" href="http://www.weibo.com/kaifuwang"></a><a class="tencent_weibo" title="腾讯微博" href="http://t.qq.com/kaifu-wang" target="_blank"></a></span><span class="fr">官方微博:</span> </span><span class="fr">'+otherLogin+'<span class="log_reg"><a target="_blank" rel="nofollow" href="/login.php">登录</a> | <a target="_blank" rel="nofollow" href="/register.php">注册</a>&nbsp;&nbsp;</span></span>');
                        $("#otherLogin").hover(function(){$(this).find("#othersUrl").show();},function(){$(this).find("#othersUrl").hide();});
		}
	},
	/**
	 * 检查新短消息
	 *
	 * @author dengxh at 2011-5-23
	 * @return void
	 */
	checkNewPM: function(){
		_Ajax.getJSON(this.parent.baseURL + 'api/pm.php', {
			action:'checkNew'
		}, function(d){
			jq('span.pm-new').css('display', 'inline-block').html(d.msg.pm);
			jq('span.gold').css('display', 'inline-block').html(d.msg.gold);
			jq('.list-wrap2').html(d.msg.GamePlay);
		});
	},
	lishijilu: function(){
		var lishijilu = $.localStorage('lishijilu');
		if (lishijilu){
			Ajax.post("http://www.kaifu.com/api/gameinfo.php?action=upgameplay", {
				str:lishijilu
			});
		//$.localStorage('lishijilu', null);
		}
	},
	save2desktop: function(){
		var domain = document.domain;
		var title = '开服网';
		//document.location.href
		window.open('http://www.kaifu.com/api/save2desktop.php?url=' + encodeURIComponent('http://'+domain+'/') + '&title=' + encodeURIComponent(title));
	}
});