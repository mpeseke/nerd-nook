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

		<title>The Nerd Nook HomePage</title>

		<style>
			/* Bordered form */
			form {
				border: 3px solid black;
			}
			body {
			background-image: url("app/img/matrix door2.jpg");
			background-repeat: no-repeat;
			}


			/* Full-width inputs */
			input[type=text], input[type=password] {
				width: 75%;
				padding: 12px 20px;
				margin: 8px 0;
				display: inline-block;
				border: 1px solid #ccc;
				box-sizing: border-box;
			}

			.password-label {
				display: block;
			}

			.email-label {
				display: block;
			}


			/* Set a style for all buttons */
			button {
				background-color: #008600;
				color: white;
				padding: 14px 20px;
				margin: 8px 0;
				border: none;
				cursor: pointer;
				width: 20rem;
			}

			/* Add a hover effect for buttons */
			button:hover {
				opacity: 0.8;
			}


			/* Add padding to containers */
			.container {
				padding: 15rem;
				position: absolute;
				top: 10rem;
				left: 55rem;
				text-align: center;
			}

			/* Change styles for span and cancel button on extra small screens */
			@media screen and (max-width: 300px) {
				span {
					display: block;
					float: none;
				}
			}
		</style>

	</head>

	<body>

		<div class="container" type="SignIn">
			<form action="#">
				<h1>Login</h1>

				<label class="email-label" for="email"><b>Email Address</b></label>
				<input type="text" placeholder="Enter Email Address" name="email" required>

				<label class="password-label" for="psw"><b>Password</b></label>
				<input type="password" placeholder="Enter Password" name="psw" required>

				<button type="submit">Login</button>

		</div>
		</form>
	</body>
</html>