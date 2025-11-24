CREATE TABLE cours (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       numero_cours VARCHAR(7) NOT NULL,  -- format 999-999
                       titre VARCHAR(150) NOT NULL
);

CREATE TABLE etudiant (
                          id INT AUTO_INCREMENT PRIMARY KEY,
                          courriel VARCHAR(150) NOT NULL,
                          nom VARCHAR(150) NOT NULL
);

CREATE TABLE inscription (
                             id_etudiant INT,
                             id_cours INT,
                             session ENUM('AUT','HIV','ETE') NOT NULL,
                             annee INT NOT NULL,
                             note DECIMAL(5,2) DEFAULT NULL,
                             PRIMARY KEY (id_etudiant, id_cours),
                             FOREIGN KEY (id_etudiant) REFERENCES etudiant(id) ON DELETE CASCADE,
                             FOREIGN KEY (id_cours) REFERENCES cours(id) ON DELETE CASCADE
);
