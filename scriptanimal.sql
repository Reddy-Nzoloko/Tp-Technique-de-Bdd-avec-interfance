-- creation de la table animal et espece
use animal;
CREATE TABLE Espece (
    idEspece INT AUTO_INCREMENT PRIMARY KEY,
    nomEspece VARCHAR(100) NOT NULL
);
CREATE TABLE Animal (
    idAnimal INT AUTO_INCREMENT PRIMARY KEY,
    nomAnimal VARCHAR(100) NOT NULL,
    ageAnimal INT,
    idEspece INT,
    FOREIGN KEY (idEspece) REFERENCES Espece(idEspece) ON DELETE CASCADE
);

-- ajout de l'index sur animal
CREATE INDEX idx_nomAnimal ON Animal(nomAnimal, idEspece);

-- ajout de 20 especes
INSERT INTO Espece (nomEspece) VALUES
('Chien'),
('Chat'),
('Lapin'),
('Hamster'),
('Poisson Rouge'),
('Perroquet'),
('Tortue'),
('Furet'),
('Cochon d''Inde'),
('Serpent'),
('Lézard'),
('Oiseau Canari'),
('Poney'),
('Cheval'),
('Vache'),
('Mouton'),
('Chèvre'),
('Poulet'),
('Dinde'),
('Autruche');

-- ajout de 50 animaux
INSERT INTO Animal (nomAnimal, ageAnimal, idEspece) VALUES
('Rex', 5, 1),
('Milo', 3, 2),
('Thumper', 2, 3),
('Nibbles', 1, 4),
('Goldie', 1, 5),
('Polly', 4, 6),
('Shelly', 10, 7),
('Fuzzy', 2, 8),
('Ginger', 3, 9),
('Slither', 4, 10),
('Lizzy', 2, 11),
('Tweety', 1, 12),
('Star', 6, 13),
('Spirit', 8, 14),
('Bessie', 4, 15),
('Woolly', 3, 16),
('Billy', 5, 17),
('Clucky', 1, 18),
('Daisy', 2, 19),
('Ozzy', 3, 20),
('Buddy', 4, 1),
('Luna', 2, 2),
('Coco', 1, 3),
('Pumpkin', 3, 4),
('Bubbles', 1, 5),
('Kiwi', 2, 6),
('Tank', 12, 7),
('Squeaky', 1, 8),
('Peanut', 2, 9),
('Venom', 5, 10),
('Iggy', 3, 11),
('Sunny', 2, 12),
('Duke', 7, 13),
('Blaze', 9, 14),
('MooMoo', 5, 15),
('Fluffy', 4, 16),
('Nanny', 6, 17),
('Feathers', 1, 18),
('Gobble', 2, 19),
('Strut', 3, 20),
('Max', 6, 1),
('Bella', 4, 2),
('Oliver', 2, 3),
('DaisyMae', 1, 4),
('Splash', 1, 5),
('Chirpy', 3, 6),
('Rocky', 11, 7),
('Whiskers', 2, 8),
('Cinnamon', 4, 9),
('Slinky', 6, 10);

insert INTO animal(nomAnimal, ageAnimal, idEspece) VALUES ('Slinky', 6, 10);

-- modification de l'index pour qu'il soit unique
DROP INDEX idx_nomAnimal ON Animal;
CREATE UNIQUE INDEX idx_nomAnimal ON Animal(nomAnimal, idEspece);   

--suppresion de la donnée dupliqué dans la base de donnée
DELETE FROM Animal WHERE idAnimal = (SELECT MIN(idAnimal) FROM (SELECT idAnimal FROM Animal WHERE nomAnimal = 'Slinky' AND idEspece = 10) AS temp);

insert INTO animal(nomAnimal, ageAnimal, idEspece) VALUES ('Slinky', 6, 10);

-- selectionne en utilisant une jointure
SELECT a.idAnimal, a.nomAnimal, a.ageAnimal, e.nomEspece