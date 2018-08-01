-- This will drop any currently existing tables --
DROP TABLE IF EXISTS comment;
DROP TABLE IF EXISTS checkIn;
DROP TABLE IF EXISTS event;
DROP TABLE IF EXISTS category;
DROP TABLE IF EXISTS profile;

-- creates the profile table --
CREATE TABLE profile (
	profileId BINARY (16) NOT NULL,
	profileActivationToken CHAR (32),
	profileAtHandle VARCHAR (32) NOT NULL,
	profileEmail VARCHAR (128) NOT NULL,
	profileHash CHAR (97) NOT NULL,
	-- unique index to avoid duplicate data
	UNIQUE (profileAtHandle),
	UNIQUE (profileEmail),
	-- officiates primary key for reviewer
	PRIMARY KEY(profileId)
);

-- creates the category table --
CREATE TABLE category (
	categoryId BINARY(16) NOT NULL,
	categoryName VARCHAR(32) NOT NULL,
	categoryType VARCHAR(24) NOT NULL,
	PRIMARY KEY (categoryId)
);

-- creates the event table --
CREATE TABLE event (
	-- creating attributes for primary key --
	-- NOT NULL = is required --
	eventId BINARY(16) NOT NULL,
	eventProfileId BINARY(16) NOT NULL,
	eventCategoryId BINARY(16) NOT NULL,
	eventDetails VARCHAR(512) NOT NULL,
	eventEndDateTime DATETIME(6),
	eventLat DECIMAL (9,6),
	eventLong DECIMAL (9,6),
	eventStartDateTime DATETIME(6),


	-- creating Indices --
	INDEX(eventCategoryId),
	INDEX(eventProfileId),


	-- this creates the foreign keys --
	FOREIGN KEY(eventProfileId) REFERENCES profile(profileId),
	FOREIGN KEY(eventCategoryId) REFERENCES category(categoryId),

	-- this creates the primary key --
	PRIMARY KEY(eventId)
);

-- creates the checkIn table --
CREATE TABLE checkIn (
	checkInEventId BINARY(16) NOT NULL,
	checkInProfileId BINARY(16) NOT NULL,
	checkInDateTime DATETIME,
	checkInRep TINYINT UNSIGNED,

	FOREIGN KEY (checkInEventId) REFERENCES event(eventId),
	FOREIGN KEY (checkInProfileId) REFERENCES profile (profileId)
);

-- creates the comment table --
CREATE TABLE comment (
	--  this is for the primary key --
	commentId BINARY(16) NOT NULL,
	--  this will be a foreign key --
	commentEventId BINARY (16) NOT NULL,
	commentProfileId BINARY (16) NOT NULL,
	commentContent VARCHAR(500) NOT NULL,
	commentDateTime DATETIME(6) NOT NULL,
	--  this creates an index before making a foreign key --
	INDEX(commentEventId),
	INDEX(commentProfileId),
	--  this creates the foreign key --
	FOREIGN KEY(commentEventId) REFERENCES event(eventId),
	FOREIGN KEY(commentProfileId) REFERENCES profile(profileId),
	--  and finally create the primary key --
	PRIMARY KEY (commentId)
);



