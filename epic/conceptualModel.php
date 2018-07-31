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
	<h3>Comment</h3>
		<ul>
			<li>commentId (primary key)</li>
			<li>commentEventId(foreign key)</li>
			<li>commentProfileId (foreign key) </li>
			<li>commentContent</li>
			<li>commentDateTime</li>
		</ul>
	<h3>Category</h3>
	<ul>
		<li>categoryId (primary key)</li>
		<li>categoryName</li>
		<li>categoryType</li>
	</ul>
	<h3>Event</h3>
		<ul>
			<li>eventId (Primary Key)</li>
			<li>eventProfileId (foreign key)</li>
			<li>eventCategoryId (foreign key)</li>
			<li>eventDateTime</li>
			<li>eventDetails </li>
			<li>eventLocation</li>
			<li>eventType</li>
		</ul>
	<h3>Check In</h3>
		<ul>
			<li>checkInEventId (foreign key)</li>
			<li>checkInProfileId (foreign key)</li>
			<li>checkInDateTime</li>
			<li>checkInRep</li>
		</ul>
	<h3> Relationships</h3>
		<ul>
			<li>One category can have many events(1 to n)</li>
			<li>Many profiles can attend multiple events (m to n)</li>
			<li>Many profiles can comment on many events (m to n)</li>
			<li>Many profiles can have many check ins(m to n)</li>
		</ul>

		<img src="../epic/content/capstone-erg.svg" alt="Nerd Nook ERD">

		<a href="anthonyPersona.php">Persona- Anthony McMillan</a>
		<a href="anthonyUseCase.php">Use Case- Anthony McMillan</a>
		<a href="carla.php">Persona- Carla Higgins</a>
		<a href="carlaUseCase.php">Use Case- Carla Higgins</a>
	</body>
</html>