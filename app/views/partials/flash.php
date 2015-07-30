<?php if ($this->message()): ?>

	<div class="container">
		<div class="flash">
			<div class="flash-inner">
				<?php echo $this->message(); ?>
			</div>
		</div>
	</div>
<?php endif ?>