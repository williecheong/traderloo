CREATE TABLE `user` (
   `id` varchar(255) not null,
   `name` varchar(255),
   `email` varchar(255),
   `rating` varchar(255),
   `last_login` varchar(255),
   `last_updated` timestamp default current_timestamp on update current_timestamp,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `trade` (
   `id` int(11) not null auto_increment,
   `stock` varchar(255),
   `shares` varchar(255),
   `opened_user` varchar(255),
   `opened_price` varchar(255),
   `opened_datetime` varchar(255),
   `closed_user` varchar(255),
   `closed_price` varchar(255),
   `closed_datetime` varchar(255),  
   `last_updated` timestamp default current_timestamp on update current_timestamp,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE `balance` (
   `id` int(11) not null auto_increment,
   `value` varchar(255),
   `reason` varchar(255),
   `reason_detail` varchar(255),
   `last_updated` timestamp default current_timestamp on update current_timestamp,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

INSERT INTO `balance` (`id`, `value`, `reason`, `reason_detail`) VALUES 
('1', '1000000', 'initial_deposit', '');