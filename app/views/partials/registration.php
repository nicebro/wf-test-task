<div class="title"><?php echo $this->trans('registration-title'); ?></div>
<div class="registration">
	<form action="/auth/registration" method="POST" enctype="multipart/form-data" id="registration">
		<div class="input-group">
			<label for="name" class="required"><?php echo $this->trans('full-name'); ?></label>
			<input name="name" id="name" type="text" value="<?php echo $this->input('name'); ?>">
			<div class="error-message"><?php echo $this->error('name'); ?></div>
			<div class="valid-message">&#10003;</div>
		</div>
		<div class="input-group">
			<label for="email" class="required"><?php echo $this->trans('email'); ?></label>
			<input name="email" id="email" type="text" value="<?php echo $this->input('email'); ?>">
			<div class="error-message"><?php echo $this->error('email'); ?></div>
			<div class="valid-message">&#10003;</div>
		</div>
		<div class="input-group">
			<label for="password" class="required"><?php echo $this->trans('password'); ?></label>
			<input name="password" id="password" type="password">
			<div class="error-message"><?php echo $this->error('password'); ?></div>
			<div class="valid-message">&#10003;</div>
		</div>
		<div class="input-group">
			<div class="btn btn-yellow upload-photo">
				<input type="file" name="photo" id="upload-photo">
				<span><?php echo $this->trans('upload-photo'); ?></span>
			</div>
			<div class="photo hidden">
				<img src="/assets/images/user.png" alt="" id="photo-preview">
			</div>
			<div class="error-message"><?php echo $this->error('photo'); ?></div>
		</div>
		<div class="input-group">
			<form action="/auth/registration" method="POST">
				<div class="btn btn-blue register-button">
					<input name="submit" type="submit">
					<span><?php echo $this->trans('registration-button'); ?></span>
				</div>
			</form>
		</div>
	</form>
</div>