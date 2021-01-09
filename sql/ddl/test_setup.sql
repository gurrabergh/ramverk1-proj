--
-- Creating a sample table.
--



--
-- Table Book
--
DROP TABLE IF EXISTS answers;
CREATE TABLE answers (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "content" TEXT NOT NULL,
    "author" TEXT NOT NULL,
    "rating" INT NOT NULL DEFAULT 0,
    "accepted" INT NOT NULL DEFAULT 0,
    "date" TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    "question" INT NOT NULL
);

DROP TABLE IF EXISTS comments;
CREATE TABLE comments (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "content" TEXT NOT NULL,
    "author" TEXT NOT NULL,
    "rating" INT NOT NULL DEFAULT 0,
    "answer" INT NOT NULL,
    "question" INT NOT NULL
);

DROP TABLE IF EXISTS questions;
CREATE TABLE questions (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "content" TEXT NOT NULL,
    "author" TEXT NOT NULL,
    "rating" INT NOT NULL DEFAULT 0,
    "answers" INT NOT NULL DEFAULT 0,
    "solved" INT NOT NULL DEFAULT 0,
    "title" TEXT NOT NULL,
    "tags" TEXT
);

INSERT INTO questions (content, author, title)
VALUES ("test", ("test"), "test");

DROP TABLE IF EXISTS users;
CREATE TABLE users (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "nick" TEXT NOT NULL,
    "password" TEXT NOT NULL,
    "rep" INT NOT NULL DEFAULT 0,
    "votes" INT NOT NULL DEFAULT 0,
    "email" TEXT NOT NULL,
    "bio" TEXT NOT NULL
);

DROP TABLE IF EXISTS tags;
CREATE TABLE tags (
    "question" INTEGER NOT NULL,
    "tag" TEXT NOT NULL
);
