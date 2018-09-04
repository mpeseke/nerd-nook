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
					background: linear-gradient(rgba(0, 0, 0, 0.15) 0%, rgba(0, 0, 0, 0.65) 100%), url("content/bowtie.jpg") center center no-repeat;
					width:100%;
					height:100%;
					background-size: cover;
				}

				.footer {
					background-color: #53A451;
					position: fixed;
					left: 0;
					bottom: 0;
					width: 100%;
					color: white;
					text-align: center;
					padding: 5px;
					margin-top: 10px;
				}

				span:after{
					content:" ";
					display: inline-block;
					width:32px;
				}

				span {
					font-size: x-large;
				}
			</style>

			<title>Nerd Nook Profile</title>
		</head>
	<body>
		<!-- Navbar -->
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
							<a class="nav-link text-success" href="#"><i class="fas fa-sign-out-alt fa-fw pr-2"></i>Sign Out</a>
						</li>
					</ul>
				</div>
			</nav>
		</header>

		<!-- Jumbotron containing Profile background image -->
		<div class="jumbotron jumbotron-fluid text-light">
			<div class="container">
				<h1 class="display-4">Profile</h1>
				<p class="lead"><strong>Nerdemic</strong>, <em>noun</em>,<br/>
					 A widespread outbreak of,  overtaking by, Nerds</p>
			</div>
		</div>

		<!-- Profile Information -->
		<section>
				<div class="row mx-0">
					<div class="col-md-5 px-4">
							<h2 class="profileFirstName">First Name</h2>
							<h2 class="profileLastName">Last Name</h2>
							<hr/>
					</div>

					<div class="col-md-7">
						<h2 class="profileAtHandle">@handle</h2>
						<h2 class="joinDate">Join Date</h2>
						<hr/>
					</div>
				</div>
		</section>

		<!-- Footer containing Profile Stats -->
		<div class="footer container-fluid text-center text-monospace mt-5 pt-4 pb-3">
			<span>Rep:</span>
			<span>Comments:</span>
			<span>Events:</span>
		</div>
	</body>
</html>