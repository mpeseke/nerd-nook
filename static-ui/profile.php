<!DOCTYPE html>
<html lang="en-US">
		<head>
			<meta charset="utf-8"/>
			<meta name="viewport" content="width = device-width, initial-scale = 1, shrink-to-fit = no"/>
			<meta name="author" content="Caleb, Chelsea, Marlon, Ryan"/>
			<meta name="description" content="NerdNook, is a social platform allowing people to search and attend user created events for various hobbies & passions."/>

			<!-- Bootstrap CSS -->
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

			<!-- Font Awesome link -->
			<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

			<!-- NerdNook CSS -->
			<link rel="stylesheet" href="./styles.css">

			<!-- jQuery, Popper.js, Bootstrap JS -->
			<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

			<style>
				.jumbotron {
					background: linear-gradient(rgba(0, 0, 0, 0.15) 0%, rgba(0, 0, 0, 0.65) 100%), url("content/bowtie.jpg") center center no-repeat;
					width:100%;
					height:100%;
					background-size: cover;
				}
			</style>

			<title>The Nerd Nook Profile</title>
		</head>
	<!-- start of page, header/navbar -->
	<body>
	<header>
		<nav class="navbar navbar-expand-md navbar-dark bg-dark p-2 text-success text-monospace">
			<a class="navbar-brand text-success text-monospace" href="#">The Nerd Nook</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nerdNav">
				<span><i class="fas fa-glasses"></i></span>
			</button>
			<div class="collapse navbar-collapse" id="nerdNav">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item active">
						<a class="nav-link text-success text-monospace" href="#"><i class="fas fa-home pr-2"></i>Home</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link text-success text-monospace" href="#"><i class="fas fa-journal-whills fa-fw pr-2"></i>Categories</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link text-success text-monospace" href="#"><i class="fas fa-calendar-check fa-fw pr-2"></i>Events</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link text-success text-monospace" href="#"><i class="fas fa-sign-out-alt fa-fw pr-2"></i>Sign Out</a>
					</li>
				</ul>
			</div>
		</nav>
	</header>

		<div class="jumbotron jumbotron-fluid text-light">
			<div class="container">
				<h1 class="display-4">Profile</h1>
				<p class="lead"><strong>Nerdemic</strong>, <em>noun</em>,<br/>
					 A widespread outbreak of,  overtaking by, Nerds</p>
			</div>
		</div>

		<section>
				<div class="row mx-0">
					<div class="col-md-5 px-4">
							<h1 class="profileName">First Name Last Name</h1>
							<p class="profileDetails">
							@Handle <br>
							Join Date

							</p>
					</div>
				</div>
		</section>

				<footer>
					<div class="container-fluid text-center text-white text-monospace mt-5 pt-4 pb-3" id="footer">
						<span>Rep:</span>
						<span>Comments:</span>
						<span>Events:</span>
					</div>
				</footer>
	</body>
</html>