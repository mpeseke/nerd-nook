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
		<style>
			.checkInModal {
				text-align: center;
				background-color: #888888;
				color: #53A451;
			}
		</style>

	</head>

	<body>
		<p>
			<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#RSVP" aria-hidden="true" (click)="rsvp();"><i class="fas fa-user-plus fa-fw"></i>RSVP</button>
			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#CheckIn" aria-hidden="true" (click)="checkIntoEvent();"><i class="far fa-check-circle fa-fw"></i>Check In</button>
			<button class="btn btn-info"><i class="far fa-comments fa-fw"></i>Comments</button>
		</p>

		<!-- Modal -->
		<div class="modal fade" id="RSVP" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header checkInModal">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span class="checkInModalX" aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body checkInModal">Thank you for RSVP'ing, We look forward to seeing you there!</div>
					<div class="modal-footer checkInModal">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>