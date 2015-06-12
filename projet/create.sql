drop table if exists notes;
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
    appreciation float(4) DEFAULT NULL,
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
    nb_places int(11),
    id_passager int(11) NOT NULL,
    FOREIGN KEY(id_passager) REFERENCES compte(id_c),
    FOREIGN KEY(id_t) REFERENCES trajet(id_t)
);

create table notes
(
    id_note int(11) NOT NULL auto_increment,
    note float(4) DEFAULT NULL,
    id_donneur int(11) NOT NULL,
    FOREIGN KEY(id_donneur) REFERENCES compte(id_c),
    id_receveur int(11) NOT NULL,
    FOREIGN KEY(id_receveur) REFERENCES compte(id_c),
    id_trajet int(11) NOT NULL,
    FOREIGN KEY(id_trajet) REFERENCES trajet(id_t),
    PRIMARY KEY(id_note)
);

INSERT INTO `compte` (`id_c`, `nom`, `prenom`, `datenaissance`, `login`, `mdp`, `argent`, `photo`, `isAdmin`) VALUES
(1, 'admin', 'admin', '070694', 'admin', 'admin', 0, 'default.png', 1);


insert into ville values(NULL,'Bourg-en-Bresse','Ain');
insert into ville values(NULL,'Belley','Ain');
insert into ville values(NULL,'Gex','Ain');
insert into ville values(NULL,'Nantua','Ain');
insert into ville values(NULL,'Laon','Aisne');
insert into ville values(NULL,'Château-Thierry','Aisne');
insert into ville values(NULL,'Saint-Quentin','Aisne');
insert into ville values(NULL,'Soissons','Aisne');
insert into ville values(NULL,'Vervins','Aisne');
insert into ville values(NULL,'Moulins','Allier');
insert into ville values(NULL,'Montluçon','Allier');
insert into ville values(NULL,'Vichy','Allier');
insert into ville values(NULL,'Digne-les-Bains','Alpes-de-Haute-Provence');
insert into ville values(NULL,'Barcelonnette','Alpes-de-Haute-Provence');
insert into ville values(NULL,'Castellane','Alpes-de-Haute-Provence');
insert into ville values(NULL,'Forcalquier','Alpes-de-Haute-Provence');
insert into ville values(NULL,'Gap','Hautes-Alpes');
insert into ville values(NULL,'Briançon','Hautes-Alpes');
insert into ville values(NULL,'Nice','Alpes-Maritimes');
insert into ville values(NULL,'Grasse','Alpes-Maritimes');
insert into ville values(NULL,'Privas','Ardèche');
insert into ville values(NULL,'Largentière','Ardèche');
insert into ville values(NULL,'Tournon-sur-Rhône','Ardèche');
insert into ville values(NULL,'Charleville-Mézières','Ardennes');
insert into ville values(NULL,'Rethel','Ardennes');
insert into ville values(NULL,'Sedan','Ardennes');
insert into ville values(NULL,'Vouziers','Ardennes');
insert into ville values(NULL,'Foix','Ariège');
insert into ville values(NULL,'Pamiers','Ariège');
insert into ville values(NULL,'Saint-Girons','Ariège');
insert into ville values(NULL,'Troyes','Aube');
insert into ville values(NULL,'Bar-sur-Aube','Aube');
insert into ville values(NULL,'Nogent-sur-Seine','Aube');
insert into ville values(NULL,'Carcassonne','Aude');
insert into ville values(NULL,'Limoux','Aude');
insert into ville values(NULL,'Narbonne','Aude');
insert into ville values(NULL,'Rodez','Aveyron');
insert into ville values(NULL,'Millau','Aveyron');
insert into ville values(NULL,'Villefranche-de-Rouergue','Aveyron');
insert into ville values(NULL,'Marseille','Bouches-du-Rhône');
insert into ville values(NULL,'Aix-en-Provence','Bouches-du-Rhône');
insert into ville values(NULL,'Arles','Bouches-du-Rhône');
insert into ville values(NULL,'Istres','Bouches-du-Rhône');
insert into ville values(NULL,'Caen','Calvados');
insert into ville values(NULL,'Bayeux','Calvados');
insert into ville values(NULL,'Lizieux','Calvados');
insert into ville values(NULL,'Vire','Calvados');
insert into ville values(NULL,'Aurillac','Cantal');
insert into ville values(NULL,'Mauriac','Cantal');
insert into ville values(NULL,'Saint-Flour','Cantal');
insert into ville values(NULL,'Angoulême','Charente');
insert into ville values(NULL,'Cognac','Charente');
insert into ville values(NULL,'Confolens','Charente');
insert into ville values(NULL,'La Rochelle','Charente-Maritime');
insert into ville values(NULL,'Jonzac','Charente-Maritime');
insert into ville values(NULL,'Rochefort','Charente-Maritime');
insert into ville values(NULL,'Saintes','Charente-Maritime');
insert into ville values(NULL,"Saint-Jean-d'Angély",'Charente-Maritime');
insert into ville values(NULL,'Bourges','Cher');
insert into ville values(NULL,'Saint-Amand-Montrond','Cher');
insert into ville values(NULL,'Vierzon','Cher');
insert into ville values(NULL,'Tulle','Corrèze');
insert into ville values(NULL,'Brive-la-Gaillarde','Corrèze');
insert into ville values(NULL,'Ussel','Corrèze');
insert into ville values(NULL,'Dijon',"Côte-d'Or");
insert into ville values(NULL,'Beaune',"Côte-d'Or");
insert into ville values(NULL,'Montbard',"Côte-d'Or");
insert into ville values(NULL,'Saint-Brieuc',"Côtes-d'Armor");
insert into ville values(NULL,'Dinan',"Côtes-d'Armor");
insert into ville values(NULL,'Guingamp',"Côtes-d'Armor");
insert into ville values(NULL,'Lannion',"Côtes-d'Armor");
insert into ville values(NULL,'Guéret','Creuse');
insert into ville values(NULL,'Aubusson','Creuse');
insert into ville values(NULL,'Périgueux','Dordogne');
insert into ville values(NULL,'Bergerac','Dordogne');
insert into ville values(NULL,'Nontron','Dordogne');
insert into ville values(NULL,'Sarlat-la-Canéda','Dordogne');
insert into ville values(NULL,'Besançon','Doubs');
insert into ville values(NULL,'Montbéliard','Doubs');
insert into ville values(NULL,'Pontarlier','Doubs');
insert into ville values(NULL,'Valence','Drôme');
insert into ville values(NULL,'Die','Drôme');
insert into ville values(NULL,'Nyons','Drôme');
insert into ville values(NULL,'Évreux','Eure');
insert into ville values(NULL,'Les Andelys','Eure');
insert into ville values(NULL,'Bernay','Eure');
insert into ville values(NULL,'Chartres','Eure-et-Loir');
insert into ville values(NULL,'Châteaudun','Eure-et-Loir');
insert into ville values(NULL,'Dreux','Eure-et-Loir');
insert into ville values(NULL,'Nogent-le-Rotrou','Eure-et-Loir');
insert into ville values(NULL,'Quimper','Finistère');
insert into ville values(NULL,'Brest','Finistère');
insert into ville values(NULL,'Châteaulun','Finistère');
insert into ville values(NULL,'Morlaix','Finistère');
insert into ville values(NULL,'Nîmes','Gard');
insert into ville values(NULL,'Alès','Gard');
insert into ville values(NULL,'le Vigan','Gard');
insert into ville values(NULL,'Toulouse','Haute-Garonne');
insert into ville values(NULL,'Muret','Haute-Garonne');
insert into ville values(NULL,'Saint-Gaudens','Haute-Garonne');
insert into ville values(NULL,'Auch','Gers');
insert into ville values(NULL,'Condom','Gers');
insert into ville values(NULL,'Mirande','Gers');
insert into ville values(NULL,'Bordeaux','Gironde');
insert into ville values(NULL,'Arcachon','Gironde');
insert into ville values(NULL,'Blaye','Gironde');
insert into ville values(NULL,'Langon','Gironde');
insert into ville values(NULL,'Lesparre-Médoc','Gironde');
insert into ville values(NULL,'Libourne','Gironde');
insert into ville values(NULL,'Montpellier','Hérault');
insert into ville values(NULL,'Béziers','Hérault');
insert into ville values(NULL,'Lodève','Hérault');
insert into ville values(NULL,'Rennes','Ille-et-Vilaine');
insert into ville values(NULL,'Fougères','Ille-et-Vilaine');
insert into ville values(NULL,'Redon','Ille-et-Vilaine');
insert into ville values(NULL,'Saint-Malo','Ille-et-Vilaine');
insert into ville values(NULL,'Châteauroux','Indre');
insert into ville values(NULL,'Le Blanc','Indre');
insert into ville values(NULL,'La Châtre','Indre');
insert into ville values(NULL,'Issoudun','Indre');
insert into ville values(NULL,'Tours','Indre-et-Loire');
insert into ville values(NULL,'Chinon','Indre-et-Loire');
insert into ville values(NULL,'Loches','Indre-et-Loire');
insert into ville values(NULL,'Grenoble','Isère');
insert into ville values(NULL,'La-Tour-du-Pin','Isère');
insert into ville values(NULL,'Vienne','Isère');
insert into ville values(NULL,'Lons-le-Saunier','Jura');
insert into ville values(NULL,'Dole','Jura');
insert into ville values(NULL,'Saint-Claude','Jura');
insert into ville values(NULL,'Mont-de-Marsan','Landes');
insert into ville values(NULL,'Dax','Landes');
insert into ville values(NULL,'Blois','Loir-et-Cher');
insert into ville values(NULL,'Romorantin-Lanthenay','Loir-et-Cher');
insert into ville values(NULL,'Vendôme','Loir-et-Cher');
insert into ville values(NULL,'Saint-Étienne','Loire');
insert into ville values(NULL,'Montbrison','Loire');
insert into ville values(NULL,'Roanne','Loire');
insert into ville values(NULL,'Le-Puy-en-Velay','Haute-Loire');
insert into ville values(NULL,'Brioude','Haute-Loire');
insert into ville values(NULL,'Yssingeaux','Haute-Loire');
insert into ville values(NULL,'Nantes','Loire-Atlantique');
insert into ville values(NULL,'Ancenis','Loire-Atlantique');
insert into ville values(NULL,'Châteaubriant','Loire-Atlantique');
insert into ville values(NULL,'Saint-Nazaire','Loire-Atlantique');
insert into ville values(NULL,'Orléans','Loiret');
insert into ville values(NULL,'Montargis','Loiret');
insert into ville values(NULL,'Pithiviers','Loiret');
insert into ville values(NULL,'Cahors','Lot');
insert into ville values(NULL,'Figeac','Lot');
insert into ville values(NULL,'Gourdon','Lot');
insert into ville values(NULL,'Agen','Lot-et-Garonne');
insert into ville values(NULL,'Marmande','Lot-et-Garonne');
insert into ville values(NULL,'Nérac','Lot-et-Garonne');
insert into ville values(NULL,'Villeneuve-sur-Lot','Lot-et-Garonne');
insert into ville values(NULL,'Mende','Lozère');
insert into ville values(NULL,'Florac','Lozère');
insert into ville values(NULL,'Angers','Maine-et-Loire');
insert into ville values(NULL,'Cholet','Maine-et-Loire');
insert into ville values(NULL,'Saumur','Maine-et-Loire');
insert into ville values(NULL,'Segré','Maine-et-Loire');
insert into ville values(NULL,'Saint-Lô','Manche');
insert into ville values(NULL,'Avranches','Manche');
insert into ville values(NULL,'Cherbourg-Octeville','Manche');
insert into ville values(NULL,'Coutances','Manche');
insert into ville values(NULL,'Châlons-en-Champagne','Marne');
insert into ville values(NULL,'Épernay','Marne');
insert into ville values(NULL,'Reims','Marne');
insert into ville values(NULL,'Sainte-Menehould','Marne');
insert into ville values(NULL,'Vitry-le-François','Marne');
insert into ville values(NULL,'Chaumont','Haute-Marne');
insert into ville values(NULL,'Langres','Haute-Marne');
insert into ville values(NULL,'Saint-Dizier','Haute-Marne');
insert into ville values(NULL,'Laval','Mayenne');
insert into ville values(NULL,'Château-Gontier','Mayenne');
insert into ville values(NULL,'Mayenne','Mayenne');
insert into ville values(NULL,'Nancy','Meurthe-et-Moselle');
insert into ville values(NULL,'Briey','Meurthe-et-Moselle');
insert into ville values(NULL,'Lunéville','Meurthe-et-Moselle');
insert into ville values(NULL,'Toul','Meurthe-et-Moselle');
insert into ville values(NULL,'Bar-le-Duc','Meuse');
insert into ville values(NULL,'Commercy','Meuse');
insert into ville values(NULL,'Verdun','Meuse');
insert into ville values(NULL,'Vannes','Morbihan');
insert into ville values(NULL,'Lorient','Morbihan');
insert into ville values(NULL,'Pontivy','Morbihan');
insert into ville values(NULL,'Metz','Moselle');
insert into ville values(NULL,'Château-Salins','Moselle');
insert into ville values(NULL,'Forbach','Moselle');
insert into ville values(NULL,'Sarbourg','Moselle');
insert into ville values(NULL,'Sarreguemines','Moselle');
insert into ville values(NULL,'Thionville','Moselle');
insert into ville values(NULL,'Nevers','Nièvre');
insert into ville values(NULL,'Château-Chinon','Nièvre');
insert into ville values(NULL,'Clamecy','Nièvre');
insert into ville values(NULL,'Cosne-Cours-sur-Loire','Nièvre');
insert into ville values(NULL,'Lille','Nord');
insert into ville values(NULL,'Avesnes-sur-Helpe','Nord');
insert into ville values(NULL,'Cambrai','Nord');
insert into ville values(NULL,'Douai','Nord');
insert into ville values(NULL,'Dunkerque','Nord');
insert into ville values(NULL,'Valenciennes','Nord');
insert into ville values(NULL,'Beauvais','Oise');
insert into ville values(NULL,'Clermont','Oise');
insert into ville values(NULL,'Compiègne','Oise');
insert into ville values(NULL,'Senlis','Oise');
insert into ville values(NULL,'Alençon','Orne');
insert into ville values(NULL,'Argentan','Orne');
insert into ville values(NULL,'Morttagne-au-Perche','Orne');
insert into ville values(NULL,'Arras','Pas-de-Calais');
insert into ville values(NULL,'Béthune','Pas-de-Calais');
insert into ville values(NULL,'Boulogne-sur-Mer','Pas-de-Calais');
insert into ville values(NULL,'Calais','Pas-de-Calais');
insert into ville values(NULL,'Lens','Pas-de-Calais');
insert into ville values(NULL,'Montreuil','Pas-de-Calais');
insert into ville values(NULL,'Saint-Omer','Pas-de-Calais');
insert into ville values(NULL,'Clermont-Ferrand','Puy-de-Dôme');
insert into ville values(NULL,'Ambert','Puy-de-Dôme');
insert into ville values(NULL,'Issoire','Puy-de-Dôme');
insert into ville values(NULL,'Riom','Puy-de-Dôme');
insert into ville values(NULL,'Thiers','Puy-de-Dôme');
insert into ville values(NULL,'Pau','Pyrénées-Atlantiques');
insert into ville values(NULL,'Bayonne','Pyrénées-Atlantiques');
insert into ville values(NULL,'Oloron-Sainte-Marie','Pyrénées-Atlantiques');
insert into ville values(NULL,'Tarbes','Hautes-Pyrénées');
insert into ville values(NULL,'Argelès-Gazost','Hautes-Pyrénées');
insert into ville values(NULL,'Bagnères-de-Bigorre','Hautes-Pyrénées');
insert into ville values(NULL,'Perpignan','Pyrénées-Orientales');
insert into ville values(NULL,'Céret','Pyrénées-Orientales');
insert into ville values(NULL,'Prades','Pyrénées-Orientales');
insert into ville values(NULL,'Strasbourg','Bas-Rhin');
insert into ville values(NULL,'Haguenau','Bas-Rhin');
insert into ville values(NULL,'Molsheim','Bas-Rhin');
insert into ville values(NULL,'Saverne','Bas-Rhin');
insert into ville values(NULL,'Sélestat','Bas-Rhin');
insert into ville values(NULL,'Colmar','Haut-Rhin');
insert into ville values(NULL,'Altkirch','Haut-Rhin');
insert into ville values(NULL,'Mulhouse','Haut-Rhin');
insert into ville values(NULL,'Thann','Haut-Rhin');
insert into ville values(NULL,'Lyon','Rhône');
insert into ville values(NULL,'Villefranche-sur-Saône','Rhône');
insert into ville values(NULL,'Vesoul','Haute-Saône');
insert into ville values(NULL,'Lure','Haute-Saône');
insert into ville values(NULL,'Mâcon','Saône-et-Loire');
insert into ville values(NULL,'Autun','Saône-et-Loire');
insert into ville values(NULL,'Châlon-sur-Saône','Saône-et-Loire');
insert into ville values(NULL,'Charolles','Saône-et-Loire');
insert into ville values(NULL,'Louhans','Saône-et-Loire');
insert into ville values(NULL,'Le Mans','Sarthe');
insert into ville values(NULL,'La Flèche','Sarthe');
insert into ville values(NULL,'Mamers','Sarthe');
insert into ville values(NULL,'Chambéry','Savoie');
insert into ville values(NULL,'Albertville','Savoie');
insert into ville values(NULL,'Saint-Jean-de-Maurienne','Savoie');
insert into ville values(NULL,'Annecy','Haute-Savoie');
insert into ville values(NULL,'Bonneville','Haute-Savoie');
insert into ville values(NULL,'Saint-Julien-en-Genevois','Haute-Savoie');
insert into ville values(NULL,'Thonon-les-Bains','Haute-Savoie');
insert into ville values(NULL,'Paris','Paris');
insert into ville values(NULL,'Rouen','Seine-Maritime');
insert into ville values(NULL,'Dieppe','Seine-Maritime');
insert into ville values(NULL,'Le Havre','Seine-Maritime');
insert into ville values(NULL,'Melun','Seine-et-Marne');
insert into ville values(NULL,'Fontainebleau','Seine-et-Marne');
insert into ville values(NULL,'Meaux','Seine-et-Marne');
insert into ville values(NULL,'Provins','Seine-et-Marne');
insert into ville values(NULL,'Torcy','Seine-et-Marne');
insert into ville values(NULL,'Versailles','Yvelines');
insert into ville values(NULL,'Mantes-la-Jolie','Yvelines');
insert into ville values(NULL,'Rambouillet','Yvelines');
insert into ville values(NULL,'Saint-Germain-en-Laye','Yvelines');
insert into ville values(NULL,'Niort','Deux-Sèvres');
insert into ville values(NULL,'Bressuire','Deux-Sèvres');
insert into ville values(NULL,'Parthenay','Deux-Sèvres');
insert into ville values(NULL,'Amiens','Somme');
insert into ville values(NULL,'Abbeville','Somme');
insert into ville values(NULL,'Montdidier','Somme');
insert into ville values(NULL,'Péronne','Somme');
insert into ville values(NULL,'Albi','Tarn');
insert into ville values(NULL,'Castres','Tarn');
insert into ville values(NULL,'Montauban','Tarn-et-Garonne');
insert into ville values(NULL,'Castelsarrasin','Tarn-et-Garonne');
insert into ville values(NULL,'Toulon','Var');
insert into ville values(NULL,'Brignoles','Var');
insert into ville values(NULL,'Draguignan','Var');
insert into ville values(NULL,'Avignon','Vaucluse');
insert into ville values(NULL,'Apt','Vaucluse');
insert into ville values(NULL,'Carpentras','Vaucluse');
insert into ville values(NULL,'La-Roche-sur-Yon','Vendée');
insert into ville values(NULL,'Fontenay-le-Comte','Vendée');
insert into ville values(NULL,"Les-Sables-d'Olonne",'Vendée');
insert into ville values(NULL,'Poitiers','Vienne');
insert into ville values(NULL,'Châtellerault','Vienne');
insert into ville values(NULL,'Montmorillon','Vienne');
insert into ville values(NULL,'Limoges','Haute-Vienne');
insert into ville values(NULL,'Bellac','Haute-Vienne');
insert into ville values(NULL,'Rochechouart','Haute-Vienne');
insert into ville values(NULL,'Épinal','Vosges');
insert into ville values(NULL,'Neufchâteau','Vosges');
insert into ville values(NULL,'Saint-Dié-des-Vosges','Vosges');
insert into ville values(NULL,'Auxerre','Yonne');
insert into ville values(NULL,'Avallon','Yonne');
insert into ville values(NULL,'Sens','Yonne');
insert into ville values(NULL,'Belfort','Territoire de Belfort');
insert into ville values(NULL,'Évry','Essonne');
insert into ville values(NULL,'Étampes','Essonne');
insert into ville values(NULL,'Palaiseau','Essonne');
insert into ville values(NULL,'Nanterre','Hauts-de-Seine');
insert into ville values(NULL,'Antony','Hauts-de-Seine');
insert into ville values(NULL,'Boulogne-Billancourt','Hauts-de-Seine');
insert into ville values(NULL,'Bobigny','Seine-Saint-Denis');
insert into ville values(NULL,'Le Raincy','Seine-Saint-Denis');
insert into ville values(NULL,'Saint-Denis','Seine-Saint-Denis');
insert into ville values(NULL,'Créteil','Val-de-Marne');
insert into ville values(NULL,"L'Haÿ-les-Roses",'Val-de-Marne');
insert into ville values(NULL,'Nogent-sur-Marne','Val-de-Marne');
insert into ville values(NULL,'Cergy',"Val-d'Oise");
insert into ville values(NULL,'Argenteuil',"Val-d'Oise");
insert into ville values(NULL,'Sarcelles',"Val-d'Oise");
insert into ville values(NULL,'Pontoise',"Val-d'Oise");