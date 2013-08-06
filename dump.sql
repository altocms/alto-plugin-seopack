CREATE TABLE IF NOT EXISTS `prefix_seopack` (
  `seopack_id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(250) default NULL,
  `title` text default NULL,
  `description` text default NULL,
  `keywords` text default NULL,
  PRIMARY KEY (`seopack_id`),
  UNIQUE KEY `url` (`url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;