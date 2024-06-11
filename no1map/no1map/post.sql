INSERT INTO gs_an_table (name, email, age, naiyou, indate) VALUES ('やま', 't01@com', 20, 'こんにちは', sysdate());
INSERT INTO gs_an_table (name, email, age, naiyou, indate) VALUES ('やまう', 't02@com', 20, 'こんち', sysdate());
INSERT INTO gs_an_table (name, email, age, naiyou, indate) VALUES ('やまあ', 't03@com', 50, 'こん', sysdate());
INSERT INTO gs_an_table (name, email, age, naiyou, indate) VALUES ('やまい', 't04@com', 40, 'こんに', sysdate());
INSERT INTO gs_an_table (name, email, age, naiyou, indate) VALUES ('やまえ', 't10@com', 30, 'こんにち', sysdate());

SELECT * FROM gs_an_table;
SELECT name,email FROM gs_an_table;

SELECT * FROM gs_an_table ORDER BY id ASC;

SELECT * FROM gs_an_table ORDER BY id DESC LIMIT 3;

INSERT INTO gs_an_table (name, email, age, naiyou, indate) VALUES (:name, :email, :age, :naiyou, sysdate());
