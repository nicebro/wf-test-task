<!DOCTYPE html>
<html lang="<?php echo $this->locale; ?>">
<head>
	<meta charset="UTF-8">
	<title>Social.net</title>
	<link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
<?php include views_path() . '/partials/header.php'; ?>

<div class="profile">
	<div class="photo">
		<img src="<?php echo $user->photo; ?>" alt="">
		<!-- <div class="photo-inner"></div> -->
	</div>
	<div class="info">
		<div class="name">
			<?php echo htmlspecialchars($user->name); ?>
		</div>
		<div class="email">
			<?php echo htmlspecialchars($user->email); ?>
		</div>
	</div>
</div>

<?php include views_path() . '/partials/flash.php'; ?>
<?php include views_path() . '/partials/footer.php'; ?>
</body>
</html>