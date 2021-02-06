CREATE TABLE user(
    id int(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(20) NOT NULL,
    email VARCHAR(40) NOT NULL,
    password VARCHAR(255) NOT NULL
);
CREATE TABLE image(
    id int(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id int(10) unsigned NOT NULL,
    filename VARCHAR(22) NOT NULL
);
ALTER TABLE image ADD FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE;
ALTER TABLE user ADD UNIQUE (username);
ALTER TABLE user ADD UNIQUE (email);
ALTER TABLE image ADD UNIQUE (filename);
