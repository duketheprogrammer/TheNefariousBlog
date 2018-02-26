	CREATE DATABASE thenefariousblog;
	
	CREATE TABLE user_table
	(
	username varchar(25),
	email varchar(35),
	password varchar(25),
	status varchar(7) DEFAULT 'member',
	firstname varchar(25),
	lastname varchar(25),
	PRIMARY KEY (username)
	);

	CREATE TABLE blog_entries
	(
	username varchar(25),
	entry_id varchar(10),
	entry_title varchar(50),
	entry_body text(1000),
	entry_date date,
	PRIMARY KEY(entry_id),
	FOREIGN KEY (username) REFERENCES user_table(username)
	);
	
	CREATE TABLE entry_comments
	(
	username varchar(25),
	entry_id varchar(10),
	comment_id INT AUTO_INCREMENT,
	entry_comment text,
    PRIMARY KEY (comment_id),
	FOREIGN KEY (username) REFERENCES user_table(username),
	FOREIGN KEY (entry_id) REFERENCES blog_entries(entry_id)
	);
	
	CREATE TABLE contact_us
	(
		contact_id INT AUTO_INCREMENT,
		firstname varchar (25),
		lastname varchar (25),
		email varchar(35),
		title varchar(50),
		message text,
		PRIMARY KEY (contact_id)
	);
	
	CREATE TABLE profile_image_table 
	( 
	username varchar(25), 
	imageID int AUTO_INCREMENT, 
	imageName varchar(30), 
	imageLocation varchar(100), 
	PRIMARY KEY(imageID), 
	FOREIGN KEY (username) REFERENCES user_table(username) 
	);
	
	INSERT INTO user_table VALUES('bunnyhop', 'smithjohn@gmail.com', 'bhop123', 'admin', 'John', 'Smith');
	INSERT INTO user_table (username, email, password, firstname, lastname) VALUES ('princess_loudmouth', 'garner.nicole@yahoo.com', 'nicolepriee619', 'Nicole', 'Garner');