<!DOCTYPE html>
<html lang="<?php echo $this->locale; ?>">
<head>
	<meta charset="UTF-8">
	<title>Social.net</title>
	<link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body class="dark">
<div class="background"></div>
<?php include views_path() . '/partials/header.php'; ?>
<div class="container">
	<div class="auth">
		<div class="col">
			<?php include views_path() . '/partials/login.php'; ?>
		</div>
		<div class="separator"></div>
		<div class="col">
			<?php include views_path() . '/partials/registration.php'; ?>
		</div>
	</div>
</div>

<?php include views_path() . '/partials/flash.php'; ?>
<?php include views_path() . '/partials/footer.php'; ?>
<script src="/assets/js/app.js"></script>
</body>
</html>