CREATE TABLE `user` (
   `id` varchar(255) not null,
   `name` varchar(255) not null,
   `email` varchar(255),
   `cell_number` varchar(255),
   `rating` varchar(255),
   `notifications` varchar(255),
   `last_login` datetime not null,
   `last_updated` timestamp default current_timestamp on update current_timestamp,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
