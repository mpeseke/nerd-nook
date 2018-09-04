<!DOCTYPE html>
<html lang="en">
	<head>
		<!--Meta Tags-->
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!--Bootstrap CSS-->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<!--Bootstrap JS-->
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
		<!--Custom CSS-->
		<link rel="stylesheet" href="styles.css">
	</head>
	<body>
		<header>
			<nav class="navbar navbar-expand-md navbar-dark bg-dark p-2">
				<a class="navbar-brand text-success text-monospace" href="#">The Nerd Nook</a>
				<button class="navbar-toggler text-success" type="button" data-toggle="collapse" data-target="#nerdNav">
					<span><i class="fas fa-glasses"></i></span>
				</button>
				<div class="collapse navbar-collapse" id="nerdNav">
					<ul class="navbar-nav ml-auto text-success text-monospace">
						<li class="nav-item active">
							<a class="nav-link text-success" href="#"><i class="fas fa-home pr-2"></i>Home</a>
						</li>
						<li class="nav-item active">
							<a class="nav-link text-success" href="#"><i class="fas fa-journal-whills fa-fw pr-2"></i>Categories</a>
						</li>
						<li class="nav-item active">
							<a class="nav-link text-success" href="#"><i class="fas fa-calendar-check fa-fw pr-2"></i>Events</a>
						</li>
						<li class="nav-item active">
							<a class="nav-link text-success" href="#"><i class="fas fa-user-circle fa-fw pr-2"></i>Profile</a>
						</li>
						<li class="nav-item active">
							<a class="nav-link text-success" href="#"><i class="fas fa-sign-out-alt fa-fw pr-2"></i>Sign Out</a>
						</li>
					</ul>
				</div>
			</nav>
		</header>

		<div class="jumbotron jumbotronBG jumbotronImg jumbotron-fluid text-light">
			<div class="container">
				<h1 class="display-4">Categories</h1>
				<p class="lead"><strong>Category</strong>, <em>noun</em>,<br/>
					A class or division of people or things regarded as having particular shared characteristics.</p>
			</div>
		</div>
		<div class="card-deck p-4">
			<div class="card">
				<img class="card-img-top" src="content/monopoly.jpg" alt="Card image cap">
				<div class="card-body">
					<h5 class="card-title">Table Games</h5>
				</div>
			</div>
			<div class="card">
				<img class="card-img-top" src="content/" alt="Card image cap">
				<div class="card-body">
					<h5 class="card-title">Video Games</h5>
				</div>
			</div>
			<div class="card">
				<img class="card-img-top" src="content/cosplay.jpg" alt="Card image cap">
				<div class="card-body">
					<h5 class="card-title">Cosplay</h5>
				</div>
			</div>
		</div>
<!--			<div class="card-deck">-->
<!--				<div class="card-fluid col-lg-6 col-md-6 col-sm-12 bg-light my-2 mx-2 ml-auto">-->
<!--					<img class="card-img-top" src=".../100px200/" alt="Card image cap">-->
<!--					<div class="card-body">-->
<!--						<h5 class="card-title">Books</h5>-->
<!--					</div>-->
<!--				</div>-->
<!--				<div class="card-fluid col-lg-6 col-md-6 col-sm-12 bg-light my-2 mx-2 mr-auto">-->
<!--					<img class="card-img-top" src=".../100px200/" alt="Card image cap">-->
<!--					<div class="card-body">-->
<!--						<h5 class="card-title">Movies & TV</h5>-->
<!--					</div>-->
<!--				</div>-->
<!--			</div>-->
	</body>
</html>
