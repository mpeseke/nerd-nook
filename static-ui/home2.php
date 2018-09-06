<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width = device-width, initial-scale = 1, shrink-to-fit = no"/>

		<!--	Bootstrap	-->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

		<!-- jQuery for Bootstrap -->
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

		<!-- FontAwesome -->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

		<link rel="stylesheet" href="styles.css">


		<title>The Nerd Nook HomePage</title>

		<style>

			.homeBody {
				background: url("content/matrix-bg.jpg") no-repeat;
			}
			.logInForm {
				position: fixed;
				top: 50%;
				left: 50%;
				/* bring your own prefixes */
				transform: translate(-50%, -50%);
			}

		</style>

	</head>




	<body class="homeBody">

		<header>
			<nav class="navbar navbar-expand-md navbar-dark bg-dark p-2">
				<a class="navbar-brand text-success text-monospace" href="#">The Nerd Nook</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nerdNav">
					<span><i class="fas fa-glasses"></i></span>
				</button>
				<div class="collapse navbar-collapse" id="nerdNav">
					<ul class="navbar-nav ml-auto">
						<li class="nav-item active">
							<a class="nav-link text-success text-monospace" href="#"><i class="fas fa-user-secret fa-fw pr-2"></i>Profile</a>
						</li>
						<li class="nav-item active">
							<a class="nav-link text-success text-monospace" href="#"><i class="fas fa-archive fa-fw pr-2"></i>Categories</a>
						</li>
						<li class="nav-item active">
							<a class="nav-link text-success text-monospace" href="#"><i class="fas fa-calendar-check fa-fw pr-2"></i>Events</a>
						</li>
						<li class="nav-item active">
							<a class="nav-link text-success text-monospace" href="#"><i class="fas fa-user-plus fa-fw pr-2"></i>Sign Up</a>
						</li>
						<li class="nav-item active">
							<a class="nav-link text-success text-monospace" href="#"><i class="fas fa-sign-out-alt fa-fw pr-2"></i>Sign Out</a>
						</li>
					</ul>
				</div>

			</nav>
		</header>

		<div class="row m-0 justify-content-center">

			<div class="card centered bg-dark col-md-4 bg-dark text-light p-3 logInForm">

				<form>
					<div class="form-group">
						<label for="email">Email address</label><br/>
						<input type="email" class="form-control bg-success text-light" id="email" aria-describedby="email" placeholder="Enter email">
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" class="form-control bg-success text-light" id="password" placeholder="Password">
					</div>
					<button type="submit" class="btn btn-success">Log In</button>
				</form>

				<div class="my-3">
					Not nerdalicious enough to be a member of the Nook? Join here now! Resistance is futile...
				</div>

				<button type="button" class="btn btn-success">Sign Me Up!</button>

			</div>
		</div>

		<div class="footerEv container-fluid bg-success text-light text-center text-monospace mt-5 pt-4 pb-3">
			<h5>"Come to the Nerd Side; we have π..."</h5>
		</div>
	</body>
</html>