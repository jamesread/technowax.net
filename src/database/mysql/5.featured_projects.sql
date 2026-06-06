-- +migrate Up

CREATE TABLE IF NOT EXISTS `featured_projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(64) NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` text DEFAULT NULL,
  `homepage_url` varchar(512) DEFAULT NULL,
  `github_url` varchar(512) DEFAULT NULL,
  `docs_url` varchar(512) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `imported_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `featured_projects_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- +migrate Down

DROP TABLE IF EXISTS `featured_projects`;
