
CREATE TABLE IF NOT EXISTS `memberships` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `club` varchar(20) NOT NULL,
  `licence` int(11) NOT NULL,
  `l_type` varchar(20) ,
  `l_status` varchar(20) ,
  `l_created` date ,
  `l_modified` date ,
  `l_yearly_number` int(11) ,
  `is_secretary` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

