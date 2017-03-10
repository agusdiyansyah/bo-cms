<div class="sidebar-header">
	<h4>Login Form</h4>
</div>
<div class="sidebar-content login-widget">
	<form action="<?php echo base_url();?>admin.php/login/login_proses" method="post">
		<div class="input-prepend">
			<span class="add-on "><i class="icon-user"></i></span>
			<input type="text" class="span2" placeholder="username" name="userid">
		</div>
		<div class="input-prepend">
			<span class="add-on "><i class="icon-lock"></i></span>
			<input type="password" class="span2" placeholder="password" name="password">
		</div>
		<div class="input-prepend"><?php echo $html_captcha;?></div>
		<div class="controls">
			<button class="btn signin" type="submit">Login</button>
		</div>
	</form>
</div>