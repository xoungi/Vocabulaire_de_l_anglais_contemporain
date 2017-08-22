CREATE TABLE vocabulaire (
id SERIAL NOT NULL PRIMARY KEY, 
vocabulaire VARCHAR(255),
traduction VARCHAR(255),
id_groupedemot SERIAL,
id_groupedemot2 SERIAL,
id_grandecategorie SERIAL,
id_categorie SERIAL,
id_souscategorie SERIAL,
id_branche SERIAL,
id_sousbranche SERIAL) ;

CREATE TABLE grandecategorie (
id_grandecategorie SERIAL NOT NULL PRIMARY KEY,
grandecategorie VARCHAR(255));

CREATE TABLE categorie (
id_categorie SERIAL NOT NULL PRIMARY KEY,
categorie VARCHAR(255),
id_grandecategorie SERIAL);

CREATE TABLE souscategorie (
id_souscategorie SERIAL NOT NULL PRIMARY KEY,
souscategorie VARCHAR(255),
id_categorie SERIAL);

CREATE TABLE branche (
id_branche SERIAL NOT NULL PRIMARY KEY,
branche VARCHAR(255),
id_souscategorie SERIAL);

CREATE TABLE sousbranche (
id_sousbranche SERIAL NOT NULL PRIMARY KEY,
sousbranche VARCHAR(255),
id_branche SERIAL);