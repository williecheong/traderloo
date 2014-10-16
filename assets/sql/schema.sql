CREATE TABLE `user` (
   `id` varchar(255) not null,
   `name` varchar(255),
   `rating` varchar(255),
   `last_login` varchar(255),
   `last_updated` timestamp default current_timestamp on update current_timestamp,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `trade` (
   `id` varchar(255) not null,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `account` (
   `property` varchar(255),
   `value` varchar(255),
   `last_updated` timestamp default current_timestamp on update current_timestamp,
   PRIMARY KEY (`property`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;