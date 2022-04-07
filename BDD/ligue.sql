USE `fredi21`; 
DROP TABLE if EXISTS ligue ;
CREATE TABLE `ligue` (
  `id_ligue` int(11) NOT NULL PRIMARY KEY,
  `lib_ligue` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

  
ALTER TABLE `ligue`
  MODIFY `id_ligue` int(11) NOT NULL AUTO_INCREMENT;



