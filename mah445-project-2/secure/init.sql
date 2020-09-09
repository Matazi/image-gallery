-- TODO: Put ALL SQL in between `BEGIN TRANSACTION` and `COMMIT`
BEGIN TRANSACTION;

-- TODO: create tables

-- CREATE TABLE `examples` (
-- 	`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
-- 	`name`	TEXT NOT NULL
-- );


-- TODO: initial seed data

-- INSERT INTO `examples` (id,name) VALUES (1, 'example-1');
-- INSERT INTO `examples` (id,name) VALUES (2, 'example-2');


CREATE TABLE images (
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	file_ext TEXT NOT NULL,
	description TEXT
);

-- Seed data

INSERT INTO images (id, file_ext, description) VALUES (1, 'jpg', 'snow day');
INSERT INTO images (id, file_ext, description) VALUES (2, 'jpg', 'snow day');
INSERT INTO images (id, file_ext, description) VALUES (3, 'jpg', 'snow day');
INSERT INTO images (id, file_ext, description) VALUES (9, 'jpg', 'snow day');
INSERT INTO images (id, file_ext, description) VALUES (7, 'jpg', 'snow day');
INSERT INTO images (id, file_ext, description) VALUES (5, 'jpg', 'snow day');
INSERT INTO images (id, file_ext, description) VALUES (8, 'jpg', 'snow day');
INSERT INTO images (id, file_ext, description) VALUES (10, 'jpg', 'snow day');
INSERT INTO images (id, file_ext, description) VALUES (11, 'jpg', 'snow day');
INSERT INTO images (id, file_ext, description) VALUES (13, 'jpg', 'snow day');
INSERT INTO images (id, file_ext, description) VALUES (25, 'jpeg', 'snow day');


CREATE TABLE tags (
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	tag NOT NULL UNIQUE
);

INSERT INTO tags (id, tag) VALUES (1, 'Nature');
INSERT INTO tags (id, tag) VALUES (2, 'Festival');
INSERT INTO tags (id, tag) VALUES (3, 'Snow');
INSERT INTO tags (id, tag) VALUES (4, 'Old');
INSERT INTO tags (id, tag) VALUES (5, 'Sport');
INSERT INTO tags (id, tag) VALUES (6, 'Water');
INSERT INTO tags (id, tag) VALUES (7, 'Tree');


CREATE TABLE image_tags (
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	tag_id  INTEGER,
    image_id INTEGER
);

INSERT INTO image_tags (id, tag_id, image_id) VALUES (1, 1, 1);
INSERT INTO image_tags (id, tag_id, image_id) VALUES (2, 1, 3);
INSERT INTO image_tags (id, tag_id, image_id) VALUES (3, 1, 9);
INSERT INTO image_tags (id, tag_id, image_id) VALUES (4, 1, 8);
INSERT INTO image_tags (id, tag_id, image_id) VALUES (5, 1, 11);

INSERT INTO image_tags (id, tag_id, image_id) VALUES (6, 2, 7);
INSERT INTO image_tags (id, tag_id, image_id) VALUES (7, 2, 2);
INSERT INTO image_tags (id, tag_id, image_id) VALUES (8, 2, 5);

INSERT INTO image_tags (id, tag_id, image_id) VALUES (9, 3, 1);
INSERT INTO image_tags (id, tag_id, image_id) VALUES (10, 3, 8);

INSERT INTO image_tags (id, tag_id, image_id) VALUES (11, 4, 10);

INSERT INTO image_tags (id, tag_id, image_id) VALUES (12, 5, 3);
INSERT INTO image_tags (id, tag_id, image_id) VALUES (13, 5, 25);

INSERT INTO image_tags (id, tag_id, image_id) VALUES (14, 6, 3);
INSERT INTO image_tags (id, tag_id, image_id) VALUES (15, 6, 9);
INSERT INTO image_tags (id, tag_id, image_id) VALUES (16, 6, 11);

INSERT INTO image_tags (id, tag_id, image_id) VALUES (17, 7, 1);
INSERT INTO image_tags (id, tag_id, image_id) VALUES (18, 7, 11);


COMMIT;
