<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Login</title>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css'>
  <link rel="stylesheet" href="./assets/css/index.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
	<div class="logpad">
		<div class="logo">
			<img src="https://images.pexels.com/photos/1214205/pexels-photo-1214205.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940" height="100" width="100">
		</div>
		<div>
			<span>Login</span>
		</div>
    <form action="login.php" method="POST">
		<div class="logbox">
			<label>Email</label>
			<input type="email" name="email" required>
			<label>Password</label>
			<input type="password" name="password" required>
		</div>
		<button>Login</button>
    </form>
	</div>
<!-- <div class="container" id="container">
  <div class="form-container sign-in-container">
    <form action="login.php" method="POST">
      <h1>User Login</h1>
      <span></span>
      <input type="email" name="email" placeholder="email" required />
      <input type="password" name="password" placeholder="password" required />
      <button type="submit">Sign In</button>
    </form>
  </div>
  <div class="overlay-container">
    <div class="overlay">
      <div class="overlay-panel overlay-right">
        <h1>Welcome Back!</h1>
      </div>
    </div>
  </div>
</div>
-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
