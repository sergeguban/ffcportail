ALTER TABLE `licences`
  DROP `club_number`,
  DROP `global_number`;
  
ALTER TABLE `users`
  add `ffc_id` int(11);
  

TRUNCATE TABLE `constants` ;
INSERT INTO `constants` (`id`, `name`, `value`) VALUES
(1, 'ffc_id', '3000'),
(2, 'yearly_number', '200');

  