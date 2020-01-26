CREATE TABLE `general_settings` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `sent_emails` (
  `id` int(11) NOT NULL,
  `to_email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `sent_emails`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `general_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `sent_emails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
  
# settings to be filled in with real SMTP server settings during testing of your application  
INSERT INTO `general_settings` (`id`, `name`, `value`, `created`, `modified`) VALUES
(1, 'smtp_host', '', '2016-10-06 00:00:00', '0000-00-00 00:00:00'),
(6, 'smtp_ssl', '', '2016-10-06 00:00:00', '2016-10-06 00:00:00'),
(3, 'smtp_port', '', '2016-10-06 00:00:00', '2016-10-06 00:00:00'),
(4, 'smtp_username', '', '2016-10-06 00:00:00', '2016-10-06 00:00:00'),
(5, 'smtp_password', '', '2016-10-06 00:00:00', '2016-10-06 00:00:00'),
(7, 'smtp_tls', '', '2016-10-06 00:00:00', '2016-10-06 00:00:00');