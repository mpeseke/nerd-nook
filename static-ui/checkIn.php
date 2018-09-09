<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css"
				integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ"
				crossorigin="anonymous"/>
		<!-- Bootstrap -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
				integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<!-- jQuery for Bootstrap -->
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
				  integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
				  crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
				  integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
				  crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
				  integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
				  crossorigin="anonymous"></script>
		<title></title>

	</head>

	<body>
		<p>
			<button class="btn btn-success" type="button" data-toggle="collapse" data-target="#collapseRSVP" aria-expanded="false" aria-controls="collapseRSVP">RSVP</button>
			<button class="btn btn-success" type="button" data-toggle="collapse" data-target="#collapseCheckIn" aria-expanded="false" aria-controls="collapseCheckIn">Check In</button>
		</p>
		<div class="row mx-0 justify-content-center text-center centered">
			<div class="text-success col-lg-4 col-md-6 col-sm-6 m-2 collapse multi-collapse" id="collapseRSVP">
				<div class="card card-body bg-secondary">
					<p class="card-text fsz">Thank you for RSVP'ing</p>
					<i class="fas fa-calendar-check ico"></i>
					<p class="card-text fsz">We look forward to seeing you there! </p>
				</div>
			</div>
		</div>
		<div class="row mx-0 justify-content-center text-center centered">
			<div class="text-success col-lg-4 col-md-6 col-sm-6 m-2 collapse multi-collapse" id="collapseCheckIn">
				<div class="card card-body bg-secondary">
					<p class="card-text fsz">Check In</p>
					<i class="fas fa-check-circle ico"></i>
					<p class="card-text fsz">Successful</p>
				</div>
			</div>
		</div>
	</body>
</html>