
CREATE TABLE acos (
  id INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  parent_id INTEGER(10) DEFAULT NULL,
  model VARCHAR(255) DEFAULT '',
  foreign_key INTEGER(10) UNSIGNED DEFAULT NULL,
  alias VARCHAR(255) DEFAULT '',
  lft INTEGER(10) DEFAULT NULL,
  rght INTEGER(10) DEFAULT NULL,
  PRIMARY KEY  (id)
);

CREATE TABLE aros_acos (
  id INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  aro_id INTEGER(10) UNSIGNED NOT NULL,
  aco_id INTEGER(10) UNSIGNED NOT NULL,
  _create CHAR(2) NOT NULL DEFAULT 0,
  _read CHAR(2) NOT NULL DEFAULT 0,
  _update CHAR(2) NOT NULL DEFAULT 0,
  _delete CHAR(2) NOT NULL DEFAULT 0,
  PRIMARY KEY(id)
);

CREATE TABLE aros (
  id INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  parent_id INTEGER(10) DEFAULT NULL,
  model VARCHAR(255) DEFAULT '',
  foreign_key INTEGER(10) UNSIGNED DEFAULT NULL,
  alias VARCHAR(255) DEFAULT '',
  lft INTEGER(10) DEFAULT NULL,
  rght INTEGER(10) DEFAULT NULL,
  PRIMARY KEY  (id)
);

CREATE TABLE cake_sessions (
  id varchar(255) NOT NULL default '',
  data text,
  expires int(11) default NULL,
  PRIMARY KEY  (id)
);  
  
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `username_reset` varchar(50) default '',
  `password_reset` varchar(90)  default '',
  `nom` varchar(25) NOT NULL default '',
  `prenom` varchar(25) NOT NULL default '',
  `date_naissance` date DEFAULT NULL,
  `sexe` char (1),
  `adresse` varchar(30) NOT NULL default '',
  `code_postal` varchar(10) NOT NULL default '',
  `ville` varchar(30) NOT NULL default '',
  `mail` varchar(120)  ,
  `gsm` varchar(120)  ,
  `fixephone` varchar(120)  ,
  `club`   varchar(10) ,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
 PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;
  
  
  
  CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10),
  `user_id_responder` int(10),
  `request` varchar(200) NOT NULL,
  `response` varchar(200) NOT NULL,
  `comment` varchar(200)  default '',
  `type`   varchar(20) NOT NULL ,
  `status` varchar(10) NOT NULL default '',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
 PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;
  
  
  
  
  
  CREATE TABLE IF NOT EXISTS `licences` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10),
  `year` int(4),
  `type`   varchar(15) NOT NULL ,
  `club`   varchar(15) NOT NULL ,
  `status` varchar(15) NOT NULL default '',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
 PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

CREATE TABLE IF NOT EXISTS `clubs` (
  `id`  varchar(10) NOT NULL,
  `acronyme`  varchar(10) NOT NULL,
  `description` varchar(60),
 PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;


CREATE TABLE `message_lus` (
  `user_id` int(11) NOT NULL default '0',
  `message_id` int(11) NOT NULL default '0'
) TYPE=MyISAM;



--
-- Table structure for table `message_inscription`
--

CREATE TABLE `inscription_lists` (
  `id` int(11) NOT NULL auto_increment,
  `message_id` int(11) NOT NULL default '0',
  `isCourse` tinyint(1) default NULL,
  `description` text NOT NULL,
  `closed` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;


CREATE TABLE `inscriptions` (
  `id` int(11) NOT NULL auto_increment,
  `inscription_list_id` int(11) NOT NULL default '0',
  `user_id` int(11) NOT NULL default '0',
  `nom` varchar(25) default NULL,
  `prenom` varchar(25) default NULL,
  `licence` varchar(25) default NULL,
  `categorie` varchar(25) default NULL,
  `comment` text,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;


--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL auto_increment,
  `id_parent` int(11) NOT NULL default '0',
  `message` text NOT NULL,
  `user_id` int(11) NOT NULL default '0',
  `message_root_id` int(11) NOT NULL default '0',
  `message_date` date NOT NULL default '0000-00-00',
  `message_heure` time NOT NULL default '00:00:00',
  `message_objet` varchar(60) NOT NULL default 'sans sujet',
  `type` char(3) NOT NULL default 'mes',
  `calendar_start_date` date NOT NULL default '0000-00-00',
  `calendard_end_date` date NOT NULL default '0000-00-00',
  `on_welcome_page` tinyint(4) NOT NULL default '0',
  `archive` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM COMMENT='';





INSERT INTO `clubs` (`id`, `description`) VALUES ('CRBK', 'Cercle des Régates Bruxelles Kayak');
INSERT INTO `clubs` (`id`, `description`) VALUES ('RBKC', 'Royal Bruxelles Kayak Club');
  

INSERT INTO `acos` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, '', NULL, 'manageLicence', 1, 2),
(2, NULL, '', NULL, 'manageAutorisation', 3, 4),
(3, NULL, '', NULL, 'consultation', 5, 6),
(4, NULL, '', NULL, 'manageMember', 7, 8),
(5, NULL, '', NULL, 'accessMessagerie', 9, 10);


INSERT INTO `aros` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, '', NULL, 'clubSecretaire', 1, 2),
(2, NULL, '', NULL, 'admin', 3, 6),
(3, NULL, '', NULL, 'arbitre', 7, 8),
(4, NULL, '', NULL, 'federalSecretaire', 9, 10),
(24, 2, 'User', 1, '', 4, 5);


INSERT INTO `aros_acos` (`id`, `aro_id`, `aco_id`, `_create`, `_read`, `_update`, `_delete`) VALUES
(1, 4, 1, '1', '1', '1', '1'),
(2, 2, 2, '1', '1', '1', '1'),
(3, 1, 4, '1', '1', '1', '1'),
(4, 1 , 5, '1', '1', '1', '1'),
(5, 2 , 5, '1', '1', '1', '1'),
(6, 4 , 5, '1', '1', '1', '1'),
(7, 3 , 3, '1', '1', '1', '1'),
(8, 2 , 3, '1', '1', '1', '1');



INSERT INTO `users` (`id`, `username`, `password`, `username_reset`, `password_reset`, `nom`, `prenom`, `date_naissance`, `sexe`, `adresse`, `code_postal`, `ville`, `mail`, `gsm`, `fixephone`, `club`, `created`, `modified`) VALUES
(1, 'serge', '077107030ab13f866b6bb918b8ab445ceecda5a3', 'user', 'password', 'Guban', 'Serge', '1970-04-12', 'H', 'rue de l''obus ', '1070', 'Anderlecht', 'sergeguban@gmail.com', '0494 25 94 30', '02', 'CRBK', '2012-11-15 13:09:00', '2012-11-15 14:13:36');

  