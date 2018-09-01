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
				background: linear-gradient(rgba(0, 0, 0, 0.15) 0%, rgba(0, 0, 0, 0.65) 100%), url("content/chess.jpg") no-repeat;
				img {
					width: 100%;
				}
			}
		</style>


		<title>The Nerd Nook Events</title>
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
				<h1 class="display-4">Events</h1>
				<p class="lead"><strong>Nerd Herd</strong>, <em>noun</em>,<br/>
				A large group of nerds of either one or multiple kinds, who are mutually friends.</p>
			</div>
		</div>

		<main>
			<div class="row mx-0">
				<div class="col-md-5 px-4">
					<h1 class="eventName">Pathfinder One-Shot</h1>
					<p class="eventDetails">
						We are getting together for a one-shot campaign through a the Dungeon of Lost Souls! Characters are pre-rolled and no
						prior knowledge of d20 systems is needed. If you have been wanting to learn how to play table-top RPG's, this is the
						event for you!
					</p>
				</div>

				<div class="col-md-7">
					<h4 class="eventStart">Event Start Time:</h4><p>September 5, 2018 @ 5:00 p.m.</p>
					<h4 class="eventEnd">Event End Time:</h4><p>September 5, 2018 @ 8:00 p.m.</p>
					<h4 class="eventLocation">Event Location:</h4><p>Active Imagination, 11200 Montgomery Blvd NE, Albuquerque, NM 87111</p>
					<hr/>
					<button class="btn btn-primary"><i class="far fa-calendar-check fa-fw"></i>RSVP</button>
					<button class="btn btn-success"><i class="fas fa-check-double fa-fw"></i>Check-In</button>
					<button class="btn btn-info"><i class="far fa-comments fa-fw"></i>Comments</button>

				</div>

			</div>



			<div class="footer text-center bg-dark text-white mt-5 pt-4 pb-3">
				<h5>"Come to the Nerd Side; we have π..."</h5>
			</div>
		</main>

	</body>
</html>