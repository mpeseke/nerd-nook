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
			<!-- Button trigger modal RSVP -->
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">RSVP</button>

			<!-- Modal -->
			<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i></span>
							</button>
						</div>
						<div class="modal-body">
							<h1>Thank you for RSVP'ing</h1>
							<i class="fa fa-check-circle checkInIcon"></i>
							<h1>we look forward to seeing you there!</h1>
						</div>
					</div>
				</div>
			</div>
			<!-- Button trigger modal -->
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal2">Check In</button>

			<!-- Modal -->
			<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModal2Title" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i></span>
							</button>
						</div>
						<div class="modal-body">
							<h1>Check In</h1>
							<i class="fa fa-check-circle checkInIcon"></i>
							<h1>Successful</h1>
						</div>
					</div>
				</div>
			</div>
		</body>
	</html>