CREATE TABLE opere (
ID int(5) AUTO_INCREMENT,
Nome varchar(30) NOT NULL,
Autore varchar(30) NOT NULL,
Corrente_artistica varchar(30) NOT NULL,
Anno_realizzazione varchar(4) NOT NULL,
Categoria enum('Dipinto','Disegno','Fotografia','Scultura','Mosaico','Vaso','Altro') NOT NULL,
Dimensioni varchar(15) NOT NULL,
Ubicazione varchar(50) NOT NULL,
Descrizione varchar(1000) NOT NULL,
Immagine varchar(100),
PRIMARY KEY (ID),
FOREIGN KEY (Ubicazione) REFERENCES struttura_museale(Nome));



CREATE TABLE struttura_museale (
ID smallint(5) unsigned NOT NULL AUTO_INCREMENT,
Nome varchar(50) NOT NULL UNIQUE,
Indirizzo varchar(50) NOT NULL,
Descrizione varchar(500) NOT NULL,
Responsabile varchar(30) NOT NULL,
Orario_apertura varchar(30) NOT NULL,
PRIMARY KEY (ID));

CREATE TABLE utenti (
ID smallint(5) AUTO_INCREMENT,
Nome varchar(30) NOT NULL,
Cognome varchar(30) NOT NULL,
Username varchar(50) UNIQUE NOT NULL,
Password varchar(50) NOT NULL,
Ruolo enum('Amministratore','Operatore') NOT NULL,
PRIMARY KEY (ID));

