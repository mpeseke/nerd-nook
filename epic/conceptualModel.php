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
			<li>commentId (Primary Key)</li>
			<li>commentEventId (Foreign Key)</li>
			<li>commentProfileId (Foreign Key) </li>
			<li>commentContent</li>
			<li>commentDateTime</li>
		</ul>
	<h3>Category</h3>
	<ul>
		<li>categoryId (Primary Key)</li>
		<li>categoryName</li>
		<li>categoryType</li>
	</ul>
	<h3>Event</h3>
		<ul>
			<li>eventId (Primary Key)</li>
			<li>eventProfileId (Foreign Key)</li>
			<li>eventCategoryId (Foreign Key)</li>
			<li>eventDetails </li>
			<li>eventLocation</li>
			<li>eventType</li>
			<li>eventStart</li>
			<li>eventEnd</li>
		</ul>
	<h3>Check In</h3>
		<ul>
			<li>checkInEventId (Foreign Key)</li>
			<li>checkInProfileId (Foreign Key)</li>
			<li>checkInDateTime</li>
			<li>checkInRep</li>
		</ul>
	<h3> Relationships</h3>
		<ul>
			<li>One category can have many events (1 to n)</li>
			<li>Many profiles can attend multiple events (m to n)</li>
			<li>Many profiles can comment on many events (m to n)</li>
			<li>Many profiles can have many check ins (m to n)</li>
		</ul>

		<img src="../epic/content/capstone-erg.svg" alt="Nerd Nook ERD">

		<a href="anthonyPersona.php">Persona- Anthony McMillan</a>
		<a href="anthonyUseCase.php">Use Case- Anthony McMillan</a>
		<a href="carla.php">Persona- Carla Higgins</a>
		<a href="carlaUseCase.php">Use Case- Carla Higgins</a>
	</body>
</html>