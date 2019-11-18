DROP DATABASE landlordmanager;

CREATE DATABASE IF NOT EXISTS landlordmanager DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE landlordmanager;

CREATE USER IF NOT EXISTS 'landlord_DB_user'@'localhost' IDENTIFIED BY 'LandL0rdMana6er';
GRANT ALL PRIVILEGES ON landlordmanager.* TO 'landlord_DB_user'@'localhost';

CREATE TABLE haus (
  hausID int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  bezeichnung varchar(100) NOT NULL,
  strasse_nr varchar(100) NOT NULL,
  plz int(4) NOT NULL,
  ort varchar(100) NOT NULL,
  anz_whg int(2) NOT NULL, -- wahrscheinlich unnötig
  baujahr int(4) NOT NULL
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE wohnung (
  wohnungID int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT, 
  wohnungsNummer varchar (10),
  zimmer decimal(10,1) NOT NULL,
  flaeche decimal(10,2) NOT NULL,
  FK_hausID int,
  FOREIGN KEY (FK_hausID) REFERENCES haus(hausID)
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE mieter (
  mieterID int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  anrede varchar(20) NOT NULL,
  vorname varchar(100) NOT NULL,
  name varchar(100) NOT NULL,
  geburtsdatum DATE NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE mietvertrag (
  mietVertragID int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  FK_mieterID int NOT NULL,
  FK_wohnungID int,
  mietbeginn date NOT NULL,
  mietende date,
  mietzins_mtl int(5) NOT NULL,
  nebenkosten_mtl int (5),
  
  FOREIGN KEY (FK_mieterID) REFERENCES mieter(mieterID),
  FOREIGN KEY (FK_wohnungID) REFERENCES wohnung(wohnungID)
  
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE perioden( -- braucht es auch ein JAHR?
periodID int PRIMARY KEY NOT NULL AUTO_INCREMENT,
periodeLang VARCHAR (20),
periodeKurz varchar (05)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE mietEingang(

  mietEingangID int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  datum date NOT NULL,
  mietBetrag int NOT NULL,
  nkBetrag int NOT NULL,
  FK_periode int,
  jahr int NOT NULL,
  FK_mietVertragID int,
  
 FOREIGN KEY (FK_mietVertragID) REFERENCES mietvertrag(mietvertragID),
 FOREIGN KEY (FK_Periode) REFERENCES perioden(periodID)
 
 )  ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE lieferanten (
	lieferantID int PRIMARY KEY NOT NULL AUTO_INCREMENT,
	name varchar(100) NOT NULL,
	strasse_nr varchar(100) NOT NULL,
	plz int(4) NOT NULL,
	ort varchar(100) NOT NULL
	
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE kostenKategorien(
	kostKatID int PRIMARY KEY NOT NULL AUTO_INCREMENT,
	beschreibung varchar(100),
	abrechnung varchar (20)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	

CREATE TABLE NKRechnungen (
	nkRechnungID int PRIMARY KEY NOT NULL AUTO_INCREMENT,
	rgdatum date,
	FK_hausID int,
	FK_lieferantID int,
	FK_kostKatID int,
	betrag decimal,
	
	FOREIGN KEY (FK_hausID) REFERENCES haus(hausID),
	FOREIGN KEY (FK_lieferantID) REFERENCES lieferanten(lieferantID),
	FOREIGN KEY (FK_kostKatID) REFERENCES kostenKategorien(kostKatID)

	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	

CREATE TABLE users(
  userID int(10) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  anrede varchar(20) NOT NULL,
  vorname varchar(100) NOT NULL,
  name varchar(100) NOT NULL,
  email varchar(255) DEFAULT NULL,
  pwd varchar(255) DEFAULT NULL,
  UNIQUE KEY email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


	
--
-- Dumping data
--

INSERT INTO haus (bezeichnung, strasse_nr, plz, ort, anz_whg, baujahr) VALUES
('Garten1', 'Gartenstrasse 1', 4600, 'Olten', 8, 1980),
('Brfchl-links', 'Brfchlstrasse 4c', 5018, 'Erlinsbach', 6, 2015),
('Garten2', 'Gartenstrasse 2', 4600, 'Olten', 12, 1981),
('Brfchl-rechts', 'Brfchlstrasse 4b', 5018, 'Erlinsbach', 7, 2015),
('Boiler', 'Rathausgasse 18', 5000, 'Aarau', 2, 1750);



INSERT INTO mieter (anrede, vorname, name, geburtsdatum) VALUES
('Frau', 'Sebrina', 'Pedrossi', '1994-05-17'),
('Herr', 'Jan', 'Wolter', '1993-08-03'),
('Frau', 'Sebrina', 'Rossi', '1994-05-17');


INSERT INTO wohnung (wohnungsNummer, zimmer, flaeche, fk_hausID) VALUES
(202, 6.0, 150.00, 5),
(100,  2.5, 60.00, 1),
(5, 2.5, 60.00, 3),
('3b', 5.5, 200.00, 2),
(00,5.0, 200.00, 1),
(1, 10.0, 300.00, 2);

Insert INTO mietvertrag (FK_mieterID, FK_wohnungID, mietbeginn, mietende, mietzins_mtl, nebenkosten_mtl) VALUES
(1, 4, '2019-10-01', NULL, 1500, 300),
(1, 2, '2019-01-01', NULL, 900, 150),
(3, 1, '2018-01-01', NULL, 700, 80);


INSERT INTO perioden (periodeKurz, periodeLang) VALUES
('Jan','Januar'),
('Feb','Februar'),
('Mär','März'),
('Apr','April'),
('Mai','Mai'),
('Jun','Juni'),
('Jul','Juli'),
('Aug','August'),
('Sep','September'),
('Okt','Oktober'),
('Nov','November'),
('Dez','Dezember');


INSERT INTO mieteingang (datum, mietBetrag, nkBetrag, FK_periode, jahr, FK_mietVertragID) VALUES

 ('2019-01-02', '300', '100', 2, 2019, 1),
 ('2019-01-02', '300', '100', 2, 2019, 2),
 ('2019-01-02', '300', '100', 2, 2019, 3);


INSERT INTO lieferanten (name, strasse_nr, plz, ort) VALUES
 ('HUSO AG', 'RandStreet 3', '9999', 'Stadt'),
 ('ACME', 'ACMESTREET 3', '9999', 'City'),
 ('Muster AG', 'Musterstrasse 3', '9999', 'Stadt');
  


INSERT INTO kostenkategorien (abrechnung) VALUES 
('Wohnfläche'),
('Wohneinheit');


INSERT INTO nkrechnungen (rgdatum, FK_hausID, FK_lieferantID, FK_kostKatID, betrag) VALUES
('2019-01-01', 1, 1, 2, 3500),
('2019-10-01', 1, 2, 2, 1500),
('2019-05-01', 1, 3, 1, 1700);

INSERT INTO users (userID, anrede, vorname, name, email, pwd) VALUES 
(NULL, 'frau', 'test', 'test', 'test.test@test.com', 'test');

create View nkrechnungenprohaus AS
select `landlordmanager`.`haus`.`bezeichnung` AS `Bezeichnung`,`landlordmanager`.`nkrechnungen`.`rgdatum` AS `Datum`,
`landlordmanager`.`lieferanten`.`name` AS `Lieferant`,`landlordmanager`.`nkrechnungen`.`betrag` AS `Betrag`,
`landlordmanager`.`kostenkategorien`.`beschreibung` AS `Beschreibung`,
`landlordmanager`.`kostenkategorien`.`abrechnung` AS `Abrechnung`,`landlordmanager`.`kostenkategorien`.`kostKatID` AS `kategorieID` 
from (((`landlordmanager`.`haus` join `landlordmanager`.`nkrechnungen`) join `landlordmanager`.`kostenkategorien`) 
join `landlordmanager`.`lieferanten`) where ((`landlordmanager`.`haus`.`hausID` = `landlordmanager`.`nkrechnungen`.`FK_hausID`) 
and (`landlordmanager`.`lieferanten`.`lieferantID` = `landlordmanager`.`nkrechnungen`.`FK_lieferantID`) 
and (`landlordmanager`.`kostenkategorien`.`kostKatID` = `landlordmanager`.`nkrechnungen`.`FK_kostKatID`));
