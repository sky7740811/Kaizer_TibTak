drop table if exists participe;
drop table if exists vehicule;
drop table if exists trajet;
drop table if exists ville;
drop table if exists compte;

create table compte
(
    id_c int(11) NOT NULL auto_increment,
    nom VARCHAR(30),
    prenom VARCHAR(30),
    datenaissance VARCHAR(6),
    login VARCHAR(30),
    mdp VARCHAR(20),
    argent int(4),
    photo varchar(50) DEFAULT NULL,
    isAdmin BOOLEAN NOT NULL default 0,
    PRIMARY KEY(id_c)
);

create table vehicule
(
    id_v int(11) NOT NULL auto_increment,
    id_c int(11) NOT NULL,
    marque VARCHAR(30),
    modele VARCHAR(30),
    couleur VARCHAR(30),
    nb_place int(2),
    annee INT(4),
    FOREIGN KEY(id_c) REFERENCES compte(id_c),
    PRIMARY KEY(id_v)
);

create table ville
(
    id_ville int(11) NOT NULL auto_increment,
    nom VARCHAR(30),
    dept VARCHAR(30),
    PRIMARY KEY(id_ville)
);

create table trajet
(
    id_t int(11) NOT NULL auto_increment,
    id_conducteur int(11) NOT NULL,
    ville_dep int(11),
    ville_arriv int(11),
    date_dep VARCHAR(6),
    heure_dep VARCHAR(2),
    nb_place_dispo int(1),
    prix int(3),
    isEffectue boolean NOT NULL default 0,
    FOREIGN KEY(id_conducteur) REFERENCES compte(id_c),
    FOREIGN KEY(ville_dep) REFERENCES ville(id_ville),
    FOREIGN KEY(ville_arriv) REFERENCES ville(id_ville),
    PRIMARY KEY(id_t)
);

create table participe
(
    id_t int(11) NOT NULL,
    id_passager int(11) NOT NULL,
    FOREIGN KEY(id_passager) REFERENCES compte(id_c),
    FOREIGN KEY(id_t) REFERENCES trajet(id_t)
);

INSERT INTO `compte` (`id_c`, `nom`, `prenom`, `datenaissance`, `login`, `mdp`, `argent`, `photo`, `isAdmin`) VALUES
(1, 'admin', 'admin', '070694', 'admin', 'admin', 0, 'default.png', 1);

insert into ville values(NULL,'Troyes','Aube');
insert into ville values(NULL,'Reims','Aube');
insert into ville values(NULL,'Paris','Paris');
insert into ville values(NULL,'Clermont-Ferrand','Puy-de-Dome');
insert into compte values(NULL,'admin','admin','070694','admin','admin',0,'1');
    
