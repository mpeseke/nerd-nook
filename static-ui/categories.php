<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width = device-width, initial-scale = 1, shrink-to-fit = no"/>

		<!-- Bootstrap -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<!-- jQuery for Bootstrap -->
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

		<!-- FontAwesome -->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

		<!-- CSS Custom -->
		<style>
			.jumbotron {
				background: linear-gradient(rgba(0, 0, 0, 0.15) 0%, rgba(0, 0, 0, 0.65) 100%), url("content/imagine.jpg") no-repeat;
			img {
				width: 100%;
			}
			}
			footer {
				position: absolute;
				bottom: 0;
			}

			/*.card-img-top {*/
				/*max-width: 15em;*/
				/*height: auto;*/
			/*}*/
		</style>


		<title>The Nerd Nook Categories</title>
	</head>
	<body>
		<header>
			<nav class="navbar navbar-expand-md navbar-dark bg-dark p-2">
				<a class="navbar-brand" href="#">The Nerd Nook</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nerdNav">
					<span><i class="fas fa-glasses"></i></span>
				</button>
				<div class="collapse navbar-collapse" id="nerdNav">
					<ul class="navbar-nav ml-auto">
						<li class="nav-item active">
							<a class="nav-link text-light" href="#"><i class="fas fa-home pr-2"></i>Home</a>
						</li>
						<li class="nav-item active">
							<a class="nav-link text-light" href="#"><i class="fas fa-journal-whills fa-fw pr-2"></i>Categories</a>
						</li>
						<li class="nav-item active">
							<a class="nav-link text-light" href="#"><i class="fas fa-calendar-check fa-fw pr-2"></i>Events</a>
						</li>
						<li class="nav-item active">
							<a class="nav-link text-light" href="#"><i class="fas fa-sign-out-alt fa-fw pr-2"></i>Sign Out</a>
						</li>
					</ul>
				</div>

			</nav>
		</header>

		<div class="jumbotron jumbotron-fluid text-light">
			<div class="container">
				<h1 class="display-4">Categories</h1>
				<p class="lead">
					"Come with me, and you'll see a world of pure imagination..."
				</p>
			</div>
		</div>
		<section>
			<div class="row">

				<div class="col-sm-6 col-md-4 col-lg-3">
					<div class="card">
						<img class="card-img-top" src="content/cosplay.jpg">
						<div class="card-block">
							<h4 class="card-title">Cosplay</h4>
							<div class="card-text">Get together with friends to learn best practices, plan cons, and go all out!</div>
						</div>
					</div>
				</div>

				<div class="col-sm-6 col-md-4 col-lg-3">
					<div class="card">
						<img class="card-img-top" src="content/cosplay.jpg">
						<div class="card-block">
							<h4 class="card-title">Cosplay</h4>
							<div class="card-text">Get together with friends to learn best practices, plan cons, and go all out!</div>
						</div>
					</div>
				</div>

				<div class="col-sm-6 col-md-4 col-lg-3">
					<div class="card">
						<img class="card-img-top" src="content/cosplay.jpg">
						<div class="card-block">
							<h4 class="card-title">Cosplay</h4>
							<div class="card-text">Get together with friends to learn best practices, plan cons, and go all out!</div>
						</div>
					</div>
				</div>

				<div class="col-sm-6 col-md-4 col-lg-3">
					<div class="card">
						<img class="card-img-top" src="content/cosplay.jpg">
						<div class="card-block">
							<h4 class="card-title">Cosplay</h4>
							<div class="card-text">Get together with friends to learn best practices, plan cons, and go all out!</div>
						</div>
					</div>
				</div>

				<div class="col-sm-6 col-md-4 col-lg-3">
					<div class="card">
						<img class="card-img-top" src="content/cosplay.jpg">
						<div class="card-block">
							<h4 class="card-title">Cosplay</h4>
							<div class="card-text">Get together with friends to learn best practices, plan cons, and go all out!</div>
						</div>
					</div>
				</div>


			</div>


		</section>



		<div class="footer container-fluid text-center bg-dark text-white mt-5 pt-4 pb-3">
			<h5>"Come to the Nerd Side; we have π..."</h5>
		</div>

	</body>
</html>