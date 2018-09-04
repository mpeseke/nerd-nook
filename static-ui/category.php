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

		<!--FontAwesome-->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

		<title>The Nerd Nook Categories</title>
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
				<h1 class="display-4"><strong>Categories</strong></h1>
				<p class="lead"><strong>Nerd Herd</strong>, <em>noun</em>,<br/>
					A large group of nerds of either one or multiple kinds, who are mutually friends.</p>
			</div>
		</div>

		<!-- Card Categories -->

		<div class="row mx-0 justify-content-center">
			<div class="card text-success bg-dark col-lg-4 col-md-6 col-sm-10 m-2">
				<img class="card-img-top" src="content/controllers.jpg" alt="video games">
				<div class="card-body">
					<h5 class="card-title">Video Games</h5>
					<p class="card-text">Meetup with friends for LAN parties, split screen, or to trade your favorites pocket monsters!</p>
					<a href="#" class="btn btn-success">Link Up!</a>
				</div>
			</div>

			<div class="card text-success bg-dark col-lg-4 col-md-6 col-sm-10 m-2">
				<img class="card-img-top" src="content/cosplay.jpg" alt="cosplay">
				<div class="card-body">
					<h5 class="card-title">Cosplay</h5>
					<p class="card-text">Join with your cohort of ruffians to sew, craft, and build the best costumes you can.</p>
					<a href="#" class="btn btn-success">Suit Up!</a>
				</div>
			</div>

			<div class="card text-success bg-dark col-lg-4 col-md-6 col-sm-10 m-2">
				<img class="card-img-top" src="content/dungeons.jpg" alt="table games">
				<div class="card-body">
					<h5 class="card-title">Table Games</h5>
					<p class="card-text">Roll some dice, raid the dungeon, save the princess, crush your enemies!</p>
					<a href="#" class="btn btn-success">Roll for Initiative!</a>
				</div>
			</div>

			<div class="card text-success bg-dark col-lg-4 col-md-6 col-sm-10 m-2">
				<img class="card-img-top" src="content/tv.jpg" alt="movies">
				<div class="card-body">
					<h5 class="card-title">Movies and TV</h5>
					<p class="card-text">Every movie buff needs someone to argue with, find your nemesis here!</p>
					<a href="#" class="btn btn-success">On screen!</a>
				</div>
			</div>

			<div class="card text-success bg-dark col-lg-4 col-md-6 col-sm-10 m-2">
				<img class="card-img-top" src="content/books.jpg" alt="books">
				<div class="card-body">
					<h5 class="card-title">Books</h5>
					<p class="card-text">Find fellow book worms to discuss plot holes, inconsistencies, and talk about the next part of your favorite series.</p>
					<a href="#" class="btn btn-success">Find a quiet place.</a>
				</div>
			</div>
		</div>

<!--		<div class="row mx-0 text-center">-->
<!--			-->
<!--		</div>-->

<!--			<div class="card-deck">-->
<!--				<div class="card-fluid col-lg-3 col-md-6 col-sm-12 bg-light my-2 mx-2 ml-auto">-->
<!--					<img class="card-img-top" src=".../100px200/" alt="Card image cap">-->
<!--					<div class="card-body">-->
<!--						<h5 class="card-title">Table Games</h5>-->
<!--					</div>-->
<!--				</div>-->
<!--				<div class="card-fluid col-lg-3 col-md-6 col-sm-12 bg-light my-2 mx-2">-->
<!--					<img class="card-img-top" src=".../100px200/" alt="Card image cap">-->
<!--					<div class="card-body">-->
<!--						<h5 class="card-title">Video Games</h5>-->
<!--					</div>-->
<!--				</div>-->
<!--				<div class="card-fluid col-lg-3 col-md-6 col-sm-12 bg-light my-2 mx-2 mr-auto">-->
<!--					<img class="card-img-top" src=".../100px200/" alt="Card image cap">-->
<!--					<div class="card-body">-->
<!--						<h5 class="card-title">Cosplay</h5>-->
<!--					</div>-->
<!--				</div>-->
<!--			</div>-->
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
