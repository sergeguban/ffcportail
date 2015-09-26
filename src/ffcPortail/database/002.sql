CREATE TABLE  `constants` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` VARCHAR( 50 ) NOT NULL ,
`value` VARCHAR( 50 ) NOT NULL
);

ALTER TABLE  `users` 
	ADD  `lieu_de_naissance` VARCHAR( 60 ) NOT NULL AFTER  `date_naissance`;
	


ALTER TABLE  `licences` 
	ADD  `club_number` VARCHAR( 2 ) NOT NULL ,
	ADD  `global_number` VARCHAR( 4 ) NOT NULL ,
	ADD  `yearly_number` VARCHAR( 4 ) NOT NULL;