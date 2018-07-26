<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Conceptual Model</title>
	</head>
	<h1> Entity & Attributes</h1>
	<h3>Comments</h3>
	<ul>
		<li>commentId (primary key)</li>
		<li>commentProfileId (foreign key) </li>
		<li>commentEventId(foreign key)</li>
		<li>commentContent</li>
		<li>commentDate</li>
	</ul>
	<h1> Relationships </h1>
	<ul>
	<li>many comments can be posted to one event ( 1 to n)</li>
	<li>many comments can be posted by 1 profile (n to 1 )</li>
	</ul>
	<a href="carlaUseCase.php">Use Case</a>
	<a href="carla.php">Persona</a>
</html>