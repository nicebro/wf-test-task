<div class="title"><?php echo $this->trans('login-title'); ?></div>
<div class="login">
	<form action="/auth/login" method="POST" id="login">
		<div class="input-group">
			<label for="l_email" class="required"><?php echo $this->trans('email'); ?></label>
			<input name="l_email" id="l_email" type="text" value="<?php echo $this->input('l_email'); ?>">
			<div class="error-message"><?php echo $this->error('l_email'); ?></div>
			<div class="valid-message">&#10003;</div>
		</div>
		<div class="input-group">
			<label for="l_password" class="required"><?php echo $this->trans('password'); ?></label>
			<input name="l_password" id="l_password" type="password">
			<div class="error-message"><?php echo $this->error('l_password'); ?></div>
			<div class="valid-message">&#10003;</div>
		</div>
		<div class="btn btn-green input-button">
			<input name="submit" type="submit">
			<span><?php echo $this->trans('login-button'); ?></span>
		</div>
	</form>
</div>