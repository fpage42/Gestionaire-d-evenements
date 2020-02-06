<?php
ini_set('display_errors','on');

include_once("include/mysql.php");

$db->query('CREATE DATABASE IF NOT EXISTS '.$database.'');
//Creation de la table des types d'evenements
$db->query('CREATE TABLE IF NOT EXISTS '.$database.'.`type` (
	`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT ,
	`nom_type` VARCHAR(100),
	`color` INT,
	`nom_event` VARCHAR(100),
	`description` TEXT,
	`id_lieu` INT,
	`id_salle` INT,
	`nb_place` INT,
	`deve_month` INT,
	`deve_day` INT,
	`03` BOOLEAN,
	`36` BOOLEAN,
	`612` BOOLEAN,
	`12` BOOLEAN,
	`adulte` BOOLEAN)');

//Creation de la table des evenements
$db->query('CREATE TABLE IF NOT EXISTS '.$database.'.`evenement` (
	`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT ,
	`nom_event` VARCHAR(100),
	`description` TEXT,
	`id_lieu` INT,
	`id_salle` INT,
	`nb_place` INT,
	`timestamp` TIMESTAMP NOT NULL ,
	`deve_month` INT,
	`deve_day` INT,
	`03` BOOLEAN,
	`36` BOOLEAN,
	`612` BOOLEAN,
	`12` BOOLEAN,
	`adulte` BOOLEAN,
	`type_id` INT)');
	
//Creation de la table contenant les utilisateur inscrit aux evenements
$db->query('CREATE TABLE IF NOT EXISTS '.$database.'.`inscrit` (
	`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	`id_event` INT,
	`nom` VARCHAR(100),
	`prenom` VARCHAR(100),
	`email` VARCHAR(100),
	`telephone` VARCHAR(100),
	`age` INT,
	`mois` INT,
	`comment` VARCHAR(255))');
	
$db->query('CREATE TABLE IF NOT EXISTS '.$database.'.`lieu` (
	`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	`nom` VARCHAR(100),
	`telephone` VARCHAR(20))');

$db->query('CREATE TABLE IF NOT EXISTS '.$database.'.`salle` (
	`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	`id_lieu` INT,
	`nom` VARCHAR(100))');
	
$db->query('CREATE TABLE IF NOT EXISTS '.$database.'.`archive_evenement` (
	`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT ,
	`nom_event` VARCHAR(100),
	`description` TEXT,
	`lieu` VARCHAR(100),
	`salle` VARCHAR(100),
	`nb_place` INT,
	`timestamp` TIMESTAMP NOT NULL ,
	`deve_month` INT,
	`deve_day` INT,
	`03` BOOLEAN,
	`36` BOOLEAN,
	`612` BOOLEAN,
	`12` BOOLEAN,
	`adulte` BOOLEAN,
	`type` VARCHAR(100),
	`meth` INT,
	`nb_pres` INT)');
	
$db->query('CREATE TABLE IF NOT EXISTS '.$database.'.`archive_inscrit` (
	`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	`id_event` INT,
	`nom` VARCHAR(100),
	`prenom` VARCHAR(100),
	`email` VARCHAR(100),
	`telephone` VARCHAR(100),
	`age` INT,
	`mois` INT,
	`present` INT,
	`comment` VARCHAR(255))');

	$file = fopen('data/password', 'c+');
	ftruncate($file, 0);
	fputs($file, 'pass');
	
	echo "Installation terminées<br />";
	echo "<a href='index.php'>Acces au site</a>";
?>