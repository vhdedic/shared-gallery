CREATE TABLE users(
    id int(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(20) NOT NULL,
    email VARCHAR(40) NOT NULL,
    password VARCHAR(255) NOT NULL
);
CREATE TABLE images(
    id int(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id int(10) unsigned NOT NULL,
    image VARCHAR(22) NOT NULL
);
ALTER TABLE images ADD FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE;
ALTER TABLE users ADD UNIQUE (username);
ALTER TABLE users ADD UNIQUE (email);
ALTER TABLE images ADD UNIQUE (image);
