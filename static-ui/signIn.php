<head>
	<style>
		:root {
			--body-bg: #c1bdba;
			--form-bg: #13232f;
			--white: #ffffff;
			--main: #1ab188;
			--main-light: #1ab188,5%;
			--main-dark: #1ab188,5%;
			--gray-light: #a0b3b0;
			--gray: #ddd;
			--thin: 300;
			--normal: 400;
			--bold: 600;
			--br: 4px;
		}

		*, *:before, *:after {
			box-sizing: border-box;
		}

		html {
			overflow-y: scroll;
			/*(decided on solid BG color) background-image: url("../src/app/img/final-matrix-door.jpg");*/
			background-color: #343a40;
			font-family: 'Titillium Web', sans-serif;
		}

		form {
			background: var(--form-bg);
			padding: 40px;
			max-width: 600px;
			margin: 40px auto;
			border-radius: var(--br);
			box-shadow: 0 4px 10px 4px var(--form-bg);
			top: 20rem;
			left: 55rem;
			/*float: right;*/
		}


		h1 {
			text-align: center;
			color: var(--white);
			font-weight: var(--thin);
			margin: 0 0 40px;
		}

		label {
			color: var(--white);
			/*font-size: 22px;*/
		}
		label .req {
			margin: 2px;
		}

		input::placeholder{
			color: white;
		}

		label.active {
			-webkit-transform: translateY(50px);
			transform: translateY(50px);
			left: 2px;
			font-size: 14px;
		}
		label.active .req {
			opacity: 0;
		}

		label.highlight {
			color: var(--white);
		}

		input, textarea {
			font-size: 22px;
			display: block;
			width: 100%;
			height: 100%;
			padding: 5px 10px;
			background: none;
			background-image: none;
			border: 1px solid var(--gray-light);
			color: var(--white);
			border-radius: 0;
			transition: border-color .25s ease, box-shadow .25s ease;
		}
		input:focus, textarea:focus {
			outline: 0;
			border-color: var(--main);
		}

		textarea {
			border: 2px solid var(--gray-light);
			resize: vertical;
		}

		.top-row > div {
			float: left;
			width: 48%;
			margin-right: 4%;
		}
		.top-row > div:last-child {
			margin: 0;
		}

		.button {
			border: 0;
			outline: none;
			border-radius: 0;
			padding: 15px 0;
			font-size: 2rem;
			font-weight: var(--bold);
			text-transform: uppercase;
			letter-spacing: .1em;
			background: #53A451;
			color: var(--white);
			transition: all 0.5s ease;
			-webkit-appearance: none;
		}
		.button:hover, .button:focus {
			background: var(--main-dark);
		}

		.button-block {
			display: block;
			width: 100%;
		}

	</style>
</head>
<div class="sign-in">
	<div class="signin"></div>
	<h1>Sign In</h1>
	<h3>Welcome Back!</h3>

	<!--actual form-->
	<form #signInForm="ngForm" class="form-horizontal" name="signInForm" id="signInForm" novalidate (ngSubmit)="signIn();">

		<!-- Email here -->
		<div class="form-group">
			<label for="signin-email" class="control-label">Email</label>
			<input type="email" name="signin-email" id="signin-email" required [(ngModel)]=signin.profileEmail
					 #profileEmail="ngModel" class="form-control">
		</div>

		<!-- Password here-->
		<div class="form-group">
			<label for="signin-password" class="control-label">Password</label>
			<input type="password" id="signin-password" name="signin-password" required [(ngModel)]=signin.profilePassword
					 #profilePassword="ngModel" class="form-control">
		</div>



		<button type="submit" id="submit"[disabled]="signInForm.invalid" class="button button-block">Log In</button>
	</form>
	<!--<div *ngIf="status !== null" class="alert alert-dismissible" [class]="status.type" role="alert">-->
	<!--<button type="button" class="close" aria-label="Close" (click)="status = null;"><span aria-hidden="true">&times;</span></button>-->
	<!--{{ status.message }}-->
	<!--</div>-->

</div>