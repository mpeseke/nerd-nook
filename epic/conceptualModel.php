<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="style.css"/>
		<title>Conceptual Model</title>
	</head>
	<body>
	<h1> Entities & Attributes</h1>
	<h3>Profile</h3>
		<ul>
			<li>profileId (Primary Key)</li>
			<li>profileActivationToken (For Account Verification)</li>
			<li>profileAtHandle</li>
			<li>profileEmail</li>
			<li>profileHash (For Account Password)</li>
		</ul>
	<h3>Comments</h3>
		<ul>
			<li>commentId (primary key)</li>
			<li>commentEventId(foreign key)</li>
			<li>commentProfileId (foreign key) </li>
			<li>commentContent</li>
			<li>commentDate</li>
		</ul>
		<h3>Categories</h3>
		<ul>
			<li>categoryId (primary key)</li>
			<li>categoryName</li>
			<li>categoryType</li>
		</ul>
	<h3>Events</h3>
		<ul>
			<li>eventId (Primary Key)</li>
			<li>eventProfileId (foreign key)</li>
			<li>eventCategory (foreign key)</li>
			<li>eventDateTime</li>
			<li>eventDetails </li>
			<li>eventLocation</li>
			<li>eventType</li>
		</ul>
	<h3>Check-In</h3>
		<ul>
			<li>checkEventId (foreign key)</li>
			<li>checkProfileId (foreign key)</li>
			<li>checkDateTime </li>
			<li>checkInRep</li>
		</ul>
	<h3> Relationships </h3>
		<ul>
			<li>one Profile can attend multiple Events (1 to n)</li>
			<li>one Profile can add multiple Comments (1 to n)</li>
			<li>many Comments can be posted to one Event (m to 1)</li>
			<li>one Category can have many Events</li>
			<li>many Events can have many Comments (m to n)</li>
			<li>one Event can have many Check-Ins (1 to n)</li>
			<li>one Check-In to One Profile to One Event (1 to 1 to 1)</li>
		</ul>

		<img src="content/capstone-erg.svg" alt="Nerd Nook ERD">

		<a href="anthonyPersona.php">Persona- Anthony McMillan</a>
		<a href="anthonyUseCase.php">Use Case- Anthony McMillan</a>
		<a href="carla.php">Persona- Carla Higgins</a>
		<a href="carlaUseCase.php">Use Case- Carla Higgins</a>

	</body>
</html>