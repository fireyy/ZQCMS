<?php render('layout/header'); ?>

<div class="content">
	<?php render('layout/nav'); ?>

	<div class="article">
		<h1>阅读许可协议</h1>
		<div class="pr-agreement">
				<p>版权所有 &copy; ZQCMS.com 保留所有权利。 </p>
				<p>感谢您选择智趣页游资讯系统（以下简称ZQCMS），基于 PHP + MySQL   的技术开发，全部源码开放。</p>
				<p>ZQCMS 的官方网址是： <a href="http://www.ZQCMS.com" target="_blank">www.ZQCMS.com</a> 交流论坛：<a href="http://bbs.ZQCMS.com" target="_blank"> bbs.ZQCMS.com</a></p>
				<p>为了使你正确并合法的使用本软件，请你在使用前务必阅读清楚下面的协议条款：</p>
			<h3>一、协议许可的权利 </h3>
				<p>1、您可以在完全遵守本最终用户授权协议的基础上，将本软件应用于非商业用途，而不必支付软件版权授权费用。 </p>
				<p>2、您可以在协议规定的约束和限制范围内修改 ZQCMS 源代码或界面风格以适应您的网站要求。 </p>
				<p>3、您拥有使用本软件构建的网站全部内容所有权，并独立承担与这些内容的相关法律义务。 </p>
			<h3>二、协议规定的约束和限制 </h3>
				<p>1、未经官方许可，不得对本软件或与之关联的商业授权进行出租、出售、抵押或发放子许可证。</p>
				<p>2、未经官方许可，禁止在 ZQCMS   的整体或任何部分基础上以发展任何派生版本、修改版本或第三方版本用于重新分发。</p>
			<h3>三、有限担保和免责声明 </h3>
				<p>1、本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的。 </p>
				<p>2、用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未购买产品技术服务之前，我们不承诺对免费用户提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任。 </p>
				<p>3、电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和等同的法律效力。您一旦开始确认本协议并安装   ZQCMS，即被视为完全理解并接受本协议的各项条款，在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。</p>
				<p>4、如果本软件带有其它软件的整合API示范例子包，这些文件版权不属于本软件官方，并且这些文件是没经过授权发布的，请参考相关软件的使用许可合法的使用。</p>
				<p><b>协议发布时间：</b> 2012年12月18日</p>
				<p><b>版本最新更新：</b> 2012年12月29日 By ZQCMS.com</p>
		</div>
	</div>

	<form autocomplete="off">
		<p>
			<input name="readpact" type="checkbox" id="readpact" value="" style="width:auto;margin-right: 5px;" /><label for="readpact"><strong class="fc-690 fs-14">我已经阅读并同意此协议</strong></label>
		</p>

		<div class="options">
			<button type="button" onclick="document.getElementById('readpact').checked ?window.location.href='index.php?action=stage2' : alert('您必须同意软件许可协议才能安装！');">下一步 &raquo;</button>
			<div class="test"></div>
		</div>
	</form>
</div>

<?php render('layout/footer'); ?>