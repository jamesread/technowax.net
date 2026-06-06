-- +migrate Up
--
-- Application columns and bootstrap data not covered by libAllure createTables().

ALTER TABLE `groups`
  ADD COLUMN IF NOT EXISTS `css` varchar(255) DEFAULT NULL AFTER `title`;

ALTER TABLE `users`
  ADD COLUMN IF NOT EXISTS `email` varchar(255) DEFAULT NULL AFTER `password`,
  ADD COLUMN IF NOT EXISTS `registered` datetime DEFAULT NULL AFTER `email`;

ALTER TABLE `users`
  MODIFY COLUMN `username` varchar(32) NOT NULL,
  MODIFY COLUMN `group` int(11) NOT NULL DEFAULT 1;

ALTER TABLE `users`
  ADD UNIQUE INDEX IF NOT EXISTS `users_username_unique` (`username`);

INSERT INTO `groups` (`id`, `title`)
VALUES (1, 'Users')
ON DUPLICATE KEY UPDATE `title` = VALUES(`title`);

INSERT INTO `permissions` (`id`, `key`, `description`)
VALUES (1, 'SUPERUSER', 'Full administrative access')
ON DUPLICATE KEY UPDATE `description` = VALUES(`description`);

-- +migrate Down

DELETE FROM `permissions` WHERE `key` = 'SUPERUSER';
DELETE FROM `groups` WHERE `id` = 1;

ALTER TABLE `users`
  DROP INDEX IF EXISTS `users_username_unique`,
  MODIFY COLUMN `username` varchar(32) DEFAULT NULL,
  MODIFY COLUMN `group` int(11) DEFAULT NULL,
  DROP COLUMN IF EXISTS `registered`,
  DROP COLUMN IF EXISTS `email`;

ALTER TABLE `groups`
  DROP COLUMN IF EXISTS `css`;
