DROP DATABASE IF EXISTS MUSEE;
CREATE DATABASE MUSEE;
use MUSEE;
DROP TABLE IF EXISTS employee;
DROP TABLE IF EXISTS visitors;
DROP TABLE IF EXISTS visitorsmuseum;
DROP TABLE IF EXISTS typeacces;
DROP TABLE IF EXISTS expositions;

/* TABLE EMPLOYEE */

CREATE TABLE employee (
	username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
	role ENUM('vendeur')
);

/* MDP : VENDEUR74 */

INSERT INTO employee (username, password, role)
VALUES ('VENDEUR', '$2y$10$/X06RqsrbDaKS6EQ44HcTOUhuJS28pWwGjQZ5x6g2oU2qBqS9nNeO', 'vendeur');

/* TABLE CLIENTS */

CREATE TABLE visitors (
	id INT AUTO_INCREMENT PRIMARY KEY,
	sexe VARCHAR(10) NOT NULL,
    age INT(150),
    postal VARCHAR(16),
	pays VARCHAR(100) NOT NULL,
    heurearrive time,
    heuresortie time,
    date date,
    exposition VARCHAR(50) NOT NULL,
    acces VARCHAR(50) NOT NULL,
	FOREIGN KEY (acces) REFERENCES typeacces(type)
);

/* TABLE VISITORS MUSEUM */

CREATE TABLE visitorsmuseum (
    visitor_id INT,
    exposition_id INT,
    CONSTRAINT PK_Visitors PRIMARY KEY (visitor_id, exposition_id),
    FOREIGN KEY (visitor_id) REFERENCES visitors(id),
    FOREIGN KEY (exposition_id) REFERENCES expositions(id)
);

/* TABLE ACCES */

CREATE TABLE typeacces (
	id INT,
    type VARCHAR(50) NOT NULL PRIMARY KEY,
    price FLOAT NOT NULL,
    FOREIGN KEY (type) REFERENCES expositions(exposition)
);

INSERT INTO typeacces(id, type, price)
VALUES (1 , 'Permanent', 19.99),
(2, 'Temporaire', 24.99),
(3, 'Mixte', 27.99);

/* TABLE EXPOSITION */

CREATE TABLE expositions (
	id INT,
    exposition VARCHAR(100) PRIMARY KEY,
    FOREIGN KEY (exposition) REFERENCES typeacces (type)
);

INSERT INTO expositions(id, exposition)
VALUES (1, 'Exposition Permanente'),
(2, 'Exposition Temporaire');

/*
INSERT INTO visitors (id, sexe, age, postal, pays, heurearrive, date, exposition, acces)
VALUES (1, 'H', 30, '75001', 'France', '09:00:00', '2024-04-08', 'Exposition Permanente', 'Permanent'),
(2, 'F', 40, '75002', 'France', '09:15:00', '2024-04-09', 'Exposition Temporaire', 'Temporaire'),
(3, 'H', 55, '75003', 'France', '09:30:00', '2024-04-10', 'Exposition Temporaire + Exposition Permanente', 'Mixte'),
(4, 'F', 20, '75004', 'France', '09:45:00', '2024-04-11', 'Exposition Permanente', 'Permanent'),
(5, 'H', 65, '75005', 'France', '10:00:00', '2024-04-12', 'Exposition Temporaire', 'Temporaire'),
(6, 'F', 45, '75006', 'France', '10:15:00', '2024-04-13', 'Exposition Permanente', 'Permanent'),
(7, 'H', 25, '75007', 'France', '10:30:00', '2024-04-14', 'Exposition Temporaire', 'Temporaire'),
(8, 'F', 60, '75008', 'France', '10:45:00', '2024-04-15', 'Exposition Temporaire + Exposition Permanente', 'Mixte'),
(9, 'H', 35, '75009', 'France', '11:00:00', '2024-04-16', 'Exposition Permanente', 'Permanent'),
(10, 'F', 50, '75010', 'France', '11:15:00', '2024-04-17', 'Exposition Temporaire', 'Temporaire'),
(11, 'H', 28, '75011', 'France', '11:30:00', '2024-04-18', 'Exposition Permanente', 'Permanent'),
(12, 'F', 52, '75012', 'France', '11:45:00', '2024-04-19', 'Exposition Temporaire + Exposition Permanente', 'Mixte'),
(13, 'H', 33, '75013', 'France', '12:00:00', '2024-04-20', 'Exposition Permanente', 'Permanent'),
(14, 'F', 48, '75014', 'France', '12:15:00', '2024-04-21', 'Exposition Temporaire', 'Temporaire'),
(15, 'H', 38, '75015', 'France', '12:30:00', '2024-04-22', 'Exposition Temporaire + Exposition Permanente', 'Mixte'),
(16, 'F', 42, '75016', 'France', '12:45:00', '2024-04-23', 'Exposition Permanente', 'Permanent'),
(17, 'H', 70, '75017', 'France', '13:00:00', '2024-04-24', 'Exposition Temporaire', 'Temporaire'),
(18, 'F', 23, '75018', 'France', '13:15:00', '2024-04-25', 'Exposition Temporaire + Exposition Permanente', 'Mixte'),
(19, 'H', 29, '75019', 'France', '13:30:00', '2024-04-26', 'Exposition Permanente', 'Permanent'),
(20, 'F', 44, '75020', 'France', '13:45:00', '2024-04-27', 'Exposition Temporaire', 'Temporaire'),
(21, 'H', 58, '75021', 'France', '14:00:00', '2024-04-28', 'Exposition Temporaire + Exposition Permanente', 'Mixte'),
(22, 'F', 27, '75022', 'France', '14:15:00', '2024-04-29', 'Exposition Permanente', 'Permanent'),
(23, 'H', 64, '75023', 'France', '14:30:00', '2024-04-30', 'Exposition Temporaire', 'Temporaire'),
(24, 'F', 37, '75024', 'France', '14:45:00', '2024-04-08', 'Exposition Temporaire + Exposition Permanente', 'Mixte'),
(25, 'H', 47, '75025', 'France', '15:00:00', '2024-04-09', 'Exposition Permanente', 'Permanent'),
(26, 'F', 32, '75026', 'France', '15:15:00', '2024-04-10', 'Exposition Temporaire', 'Temporaire'),
(27, 'H', 67, '75027', 'France', '15:30:00', '2024-04-11', 'Exposition Temporaire + Exposition Permanente', 'Mixte'),
(28, 'F', 25, '75028', 'France', '15:45:00', '2024-04-12', 'Exposition Permanente', 'Permanent'),
(29, 'H', 53, '75029', 'France', '16:00:00', '2024-04-13', 'Exposition Temporaire', 'Temporaire'),
(30, 'F', 68, '75030', 'France', '16:15:00', '2024-04-14', 'Exposition Temporaire + Exposition Permanente', 'Mixte'),
(31, 'H', 36, '75031', 'France', '16:30:00', '2024-04-15', 'Exposition Permanente', 'Permanent'),
(32, 'F', 49, '75032', 'France', '16:45:00', '2024-04-16', 'Exposition Temporaire', 'Temporaire'),
(33, 'H', 45, '75033', 'France', '17:00:00', '2024-04-17', 'Exposition Temporaire + Exposition Permanente', 'Mixte'),
(34, 'F', 55, '75034', 'France', '17:15:00', '2024-04-03', 'Exposition Permanente', 'Permanent'),
(35, 'H', 30, '75035', 'France', '17:30:00', '2024-04-05', 'Exposition Temporaire', 'Temporaire'),
(36, 'F', 40, '75036', 'France', '17:45:00', '2024-04-10', 'Exposition Temporaire + Exposition Permanente', 'Mixte'),
(37, 'H', 50, '75037', 'France', '18:00:00', '2024-04-12', 'Exposition Permanente', 'Permanent'),
(38, 'F', 35, '75038', 'France', '18:15:00', '2024-04-14', 'Exposition Temporaire', 'Temporaire'),
(39, 'H', 60, '75039', 'France', '18:30:00', '2024-04-16', 'Exposition Temporaire + Exposition Permanente', 'Mixte'),
(40, 'F', 25, '75040', 'France', '18:45:00', '2024-04-18', 'Exposition Permanente', 'Permanent'),
(41, 'H', 65, '75041', 'France', '19:00:00', '2024-04-20', 'Exposition Temporaire', 'Temporaire'),
(42, 'F', 28, '75042', 'France', '19:15:00', '2024-04-22', 'Exposition Temporaire + Exposition Permanente', 'Mixte'),
(43, 'H', 55, '75043', 'France', '19:30:00', '2024-04-24', 'Exposition Permanente', 'Permanent'),
(44, 'F', 33, '75044', 'France', '19:45:00', '2024-04-26', 'Exposition Temporaire', 'Temporaire'),
(45, 'H', 42, '75045', 'France', '20:00:00', '2024-04-28', 'Exposition Temporaire + Exposition Permanente', 'Mixte'),
(46, 'F', 70, '75046', 'France', '20:15:00', '2024-04-02', 'Exposition Permanente', 'Permanent'),
(47, 'H', 23, '75047', 'France', '20:30:00', '2024-04-04', 'Exposition Temporaire', 'Temporaire'),
(48, 'F', 58, '75048', 'France', '20:45:00', '2024-04-06', 'Exposition Temporaire + Exposition Permanente', 'Mixte'),
(49, 'H', 37, '75049', 'France', '21:00:00', '2024-04-08', 'Exposition Permanente', 'Permanent'),
(50, 'F', 48, '75050', 'France', '21:15:00', '2024-04-30', 'Exposition Temporaire', 'Temporaire');



INSERT INTO visitorsmuseum (visitor_id, exposition_id)
VALUES (1, 1),
(2, 3),
(3, 2),
(4, 1),
(5, 2),
(6, 3),
(7, 1),
(8, 2),
(9, 3),
(10, 1),
(11, 2),
(12, 3),
(13, 1),
(14, 2),
(15, 3),
(16, 1),
(17, 2),
(18, 3),
(19, 1),
(20, 2),
(21, 3),
(22, 1),
(23, 2),
(24, 3),
(25, 1),
(26, 2),
(27, 3),
(28, 1),
(29, 2),
(30, 3),
(31, 1),
(32, 2),
(33, 3),
(34, 1),
(35, 2),
(36, 3),
(37, 1),
(38, 2),
(39, 3),
(40, 1),
(41, 2),
(42, 3),
(43, 1),
(44, 2),
(45, 3),
(46, 1),
(47, 2),
(48, 3),
(49, 1),
(50, 2);
*/

/* COMMANDES */

SELECT * FROM employee;

SELECT * FROM visitors;

SELECT * FROM visitorsmuseum;

SELECT * FROM typeacces;

SELECT * FROM expositions;

SELECT sexe, COUNT(*) as total FROM visitors WHERE heuresortie IS NULL GROUP BY sexe AND date BETWEEN 01-04-2024 AND 30-04-2024;
select * from visitors where sexe = 'H' AND date BETWEEN '2024-04-01' AND '2024-04-30';

SELECT sexe, COUNT(*) as total FROM visitors WHERE date BETWEEN '2024-04-01' AND '2024-04-30' GROUP BY sexe;
