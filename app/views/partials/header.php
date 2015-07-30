<header>
	<div class="container">
		<div class="logo">
			Social.net
		</div>
		<?php if (app()->auth()->check()): ?>
			<div class="logout">
				<form action="/auth/logout" method="POST">
					<div class="btn btn-green input-button">
						<input type="submit">
						<span><?php echo $this->trans('logout-button'); ?></span>
					</div>
				</form>
			</div>
		<?php endif ?>
	</div>
</header>