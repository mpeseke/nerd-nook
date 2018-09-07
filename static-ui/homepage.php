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

<!--		<link rel="stylesheet" href="styles.css">-->


		<title>The Nerd Nook HomePage</title>
<!---->
<!--		<style>-->
<!--			:root {-->
<!--				--body-bg: #c1bdba;-->
<!--				--form-bg: #13232f;-->
<!--				--white: #ffffff;-->
<!--				--main: #1ab188;-->
<!--				--main-light: #1ab188,5%;-->
<!--				--main-dark: #1ab188,5%;-->
<!--				--gray-light: #a0b3b0;-->
<!--				--gray: #ddd;-->
<!--				--thin: 300;-->
<!--				--normal: 400;-->
<!--				--bold: 600;-->
<!--				--br: 4px;-->
<!--			}-->
<!---->
<!--			*, *:before, *:after {-->
<!--				box-sizing: border-box;-->
<!--			}-->
<!---->
<!--			html {-->
<!--				overflow-y: scroll;-->
<!--			}-->
<!---->
<!--			body {-->
<!--				background-image: url("../src/app/img/matrix-door2.jpg");-->
<!--				font-family: 'Titillium Web', sans-serif;-->
<!--			}-->
<!---->
<!--			a {-->
<!--				text-decoration: none;-->
<!--				color: var(--main);-->
<!--				transition: .5s ease;-->
<!--			}-->
<!--			a:hover {-->
<!--				color: var(--main-dark);-->
<!--			}-->
<!---->
<!--			.form {-->
<!--				background: var(--form-bg);-->
<!--				padding: 40px;-->
<!--				max-width: 600px;-->
<!--				margin: 40px auto;-->
<!--				border-radius: var(--br);-->
<!--				box-shadow: 0 4px 10px 4px var(--form-bg);-->
<!--				top: 20rem;-->
<!--				left: 55rem;-->
<!--				float: right;-->
<!--			}-->
<!---->
<!--			.tab-group {-->
<!--				list-style: none;-->
<!--				padding: 0;-->
<!--				margin: 0 0 40px 0;-->
<!--			}-->
<!--			.tab-group:after {-->
<!--				content: "";-->
<!--				display: table;-->
<!--				clear: both;-->
<!--			}-->
<!--			.tab-group li a {-->
<!--				display: block;-->
<!--				text-decoration: none;-->
<!--				padding: 15px;-->
<!--				background: var(--gray-light);-->
<!--				color: var(--gray-light);-->
<!--				font-size: 20px;-->
<!--				float: left;-->
<!--				width: 50%;-->
<!--				text-align: center;-->
<!--				cursor: pointer;-->
<!--				transition: .5s ease;-->
<!--			}-->
<!--			.tab-group li a:hover {-->
<!--				background: var(--main-dark);-->
<!--				color: var(--white);-->
<!--			}-->
<!--			.tab-group .active a {-->
<!--				background: var(--main);-->
<!--				color: var(--white);-->
<!--			}-->
<!---->
<!--			.tab-content > div:last-child {-->
<!--				display: none;-->
<!--			}-->
<!---->
<!--			h1 {-->
<!--				text-align: center;-->
<!--				color: var(--white);-->
<!--				font-weight: var(--thin);-->
<!--				margin: 0 0 40px;-->
<!--			}-->
<!---->
<!--			label {-->
<!--				position: absolute;-->
<!--				-webkit-transform: translateY(6px);-->
<!--				transform: translateY(6px);-->
<!--				left: 13px;-->
<!--				color: var(--white);-->
<!--				transition: all 0.25s ease;-->
<!--				-webkit-backface-visibility: hidden;-->
<!--				pointer-events: none;-->
<!--				font-size: 22px;-->
<!--			}-->
<!--			label .req {-->
<!--				margin: 2px;-->
<!--			}-->
<!---->
<!--			label.active {-->
<!--				-webkit-transform: translateY(50px);-->
<!--				transform: translateY(50px);-->
<!--				left: 2px;-->
<!--				font-size: 14px;-->
<!--			}-->
<!--			label.active .req {-->
<!--				opacity: 0;-->
<!--			}-->
<!---->
<!--			label.highlight {-->
<!--				color: var(--white);-->
<!--			}-->
<!---->
<!--			input, textarea {-->
<!--				font-size: 22px;-->
<!--				display: block;-->
<!--				width: 100%;-->
<!--				height: 100%;-->
<!--				padding: 5px 10px;-->
<!--				background: none;-->
<!--				background-image: none;-->
<!--				border: 1px solid var(--gray-light);-->
<!--				color: var(--white);-->
<!--				border-radius: 0;-->
<!--				transition: border-color .25s ease, box-shadow .25s ease;-->
<!--			}-->
<!--			input:focus, textarea:focus {-->
<!--				outline: 0;-->
<!--				border-color: var(--main);-->
<!--			}-->
<!---->
<!--			textarea {-->
<!--				border: 2px solid var(--gray-light);-->
<!--				resize: vertical;-->
<!--			}-->
<!---->
<!--			.field-wrap {-->
<!--				position: relative;-->
<!--				margin-bottom: 40px;-->
<!--			}-->
<!---->
<!--			.top-row:after {-->
<!--				content: "";-->
<!--				display: table;-->
<!--				clear: both;-->
<!--			}-->
<!--			.top-row > div {-->
<!--				float: left;-->
<!--				width: 48%;-->
<!--				margin-right: 4%;-->
<!--			}-->
<!--			.top-row > div:last-child {-->
<!--				margin: 0;-->
<!--			}-->
<!---->
<!--			.button {-->
<!--				border: 0;-->
<!--				outline: none;-->
<!--				border-radius: 0;-->
<!--				padding: 15px 0;-->
<!--				font-size: 2rem;-->
<!--				font-weight: var(--bold);-->
<!--				text-transform: uppercase;-->
<!--				letter-spacing: .1em;-->
<!--				background:#53A451;-->
<!--				color: var(--white);-->
<!--				transition: all 0.5s ease;-->
<!--				-webkit-appearance: none;-->
<!--			}-->
<!--			.button:hover, .button:focus {-->
<!--				background: var(--main-dark);-->
<!--			}-->
<!---->
<!--			.button-block {-->
<!--				display: block;-->
<!--				width: 100%;-->
<!--			}-->
<!---->
<!--			.forgot {-->
<!--				margin-top: -20px;-->
<!--				text-align: right;-->
<!--			}-->
<!--		</style>-->
	</head>

	<body class="homebody">

		<div class="form">

			<ul class="tab-group">
				<li class="tab active"><a href="#signup">Sign Up</a></li>
				<li class="tab"><a href="#login">Log In</a></li>
			</ul>

			<div class="tab-content">
				<div id="signup">
					<h1>Sign Up for Free</h1>

					<form action="/" method="post">

						<div class="top-row">
							<div class="field-wrap">
								<label>
									Name<span class="req">*</span>
								</label>
								<input type="text" required autocomplete="off">
							</div>

							<div class="field-wrap">
								<label>
									UserName<span class="req">*</span>
								</label>
								<input type="text" required autocomplete="off"/>
							</div>
						</div>

						<div class="field-wrap">
							<label>
								Email Address<span class="req">*</span>
							</label>
							<input type="email" required autocomplete="off"/>
						</div>

						<div class="field-wrap">
							<label>
								Set Password<span class="req">*</span>
							</label>
							<input type="password" required autocomplete="off"/>
						</div>

						<div class="field-wrap">
							<label>
								Confirm Password<span class="req">*</span>
							</label>
							<input type="password" required autocomplete="off"/>
						</div>

						<button type="submit" class="button button-block"/>Get Started</button>

					</form>

				</div>

				<div id="login">
					<h1>Welcome Back!</h1>

					<form action="/" method="post">

						<div class="field-wrap">
							<label>
								Email Address<span class="req">*</span>
							</label>
							<input type="email" required autocomplete="off"/>
						</div>

						<div class="field-wrap">
							<label>
								Password<span class="req">*</span>
							</label>
							<input type="password" required autocomplete="off"/>
						</div>
						<button type="submit" class="button button-block"/>Log In</button>

					</form>

				</div>

			</div><!-- tab-content -->

		</div> <!-- /form -->


		<script src='https://code.jquery.com/jquery-3.3.1.min.js'></script>
		<script>

			$('.form').find('input, textarea').on('keyup blur focus', function (e) {

				var $this = $(this),
					label = $this.prev('label');

				if (e.type === 'keyup') {
					if ($this.val() === '') {
						label.removeClass('active highlight');
					} else {
						label.addClass('active highlight');
					}
				} else if (e.type === 'blur') {
					if( $this.val() === '' ) {
						label.removeClass('active highlight');
					} else {
						label.removeClass('highlight');
					}
				} else if (e.type === 'focus') {

					if( $this.val() === '' ) {
						label.removeClass('highlight');
					}
					else if( $this.val() !== '' ) {
						label.addClass('highlight');
					}
				}

			});

			$('.tab a').click(function() {
					$('#login').animate({height:"toggle", opacity:"toggle"}, "slow");
					$('#signup').animate({height:"toggle", opacity:"toggle"}, "slow");
				e.preventDefault();

				$(this).parent().addClass('active');
				$(this).parent().siblings().removeClass('active');

				$target = $(this).attr('href');

				$('.tab-content > div').not(target).hide();

				$(target).fadeIn(600);

			});


		</script>
	</body>
</html>