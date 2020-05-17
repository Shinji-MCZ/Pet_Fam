# Pet Fam

create user shinji identified by '1212';

grant all on Pet_Fam.* to shinji;

CREATE TABLE users (
id int not null PRIMARY KEY AUTO_INCREMENT,
username VARCHAR(50) not null,
email VARCHAR(255) not null UNIQUE KEY,
password VARCHAR(255) not null,
profile text not null,
created_at TIMESTAMP not null DEFAULT CURRENT_TIMESTAMP,
updated_at TIMESTAMP not null default	CURRENT_TIMESTAMP
)

CREATE TABLE pets (
id int not null PRIMARY KEY AUTO_INCREMENT,
petname VARCHAR(255) not null,
type_name VARCHAR(255) not null,
username_id int not null,
categories_id int not null,
created_at TIMESTAMP not null DEFAULT CURRENT_TIMESTAMP,
updated_at TIMESTAMP not null DEFAULT CURRENT_TIMESTAMP
)

CREATE TABLE categories (
  id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  type VARCHAR(50) NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE photos (
id int not null PRIMARY KEY AUTO_INCREMENT,
image_name VARCHAR(255) not null,
user_id int not null,
type_name_id int not null,
comments VARCHAR(255) not null,
created_at TIMESTAMP not null DEFAULT CURRENT_TIMESTAMP,
updated_at TIMESTAMP not null DEFAULT CURRENT_TIMESTAMP
)

CREATE TABLE good (
id int not null PRIMARY KEY AUTO_INCREMENT,
username_id int not null,
photos_id int not null,
created_at TIMESTAMP not null DEFAULT CURRENT_TIMESTAMP
)

CREATE TABLE lost_pet (
id int not null PRIMARY KEY AUTO_INCREMENT,
name VARCHAR(50),
from TEXT not null,
type int not null,
type_id int not null,
comments VARCHAR(255) not null,
created_at TIMESTAMP not null DEFAULT CURRENT_TIMESTAMP,
updated_at TIMESTAMP not null DEFAULT CURRENT_TIMESTAMP
)

INSERT INTO categories (type, created_at, updated_at) VALUES
 ('犬', now(), now()),
  ('猫', now(), now()),
  ('鳥類', now(), now()),
  ('爬虫類･両生類', now(), now()),
  ('小動物', now(), now()),
  ('アクア', now(), now());
