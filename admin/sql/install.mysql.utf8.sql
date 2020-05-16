--
-- Table structure for table `#__foodman_groups`
--

CREATE TABLE IF NOT EXISTS `#__foodman_groups`
(
    `id`               int(11)             NOT NULL AUTO_INCREMENT,
    `name`             varchar(255)        NOT NULL DEFAULT '',
    `state`            tinyint(3)          NOT NULL DEFAULT 0,
    `description`      text                NOT NULL DEFAULT '',
    `ordering`         int(11)             NOT NULL DEFAULT 0,
    `params`           text                NOT NULL DEFAULT '',
    `language`         char(7)             NOT NULL DEFAULT '',
    `featured`         tinyint(3) unsigned NOT NULL DEFAULT 0,
    `created`          datetime            NOT NULL DEFAULT '0000-00-00 00:00:00',
    `created_by`       int(10) unsigned    NOT NULL DEFAULT 0,
    `modified`         datetime            NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by`      int(10) unsigned    NOT NULL DEFAULT 0,
    `checked_out`      INT(10)             NOT NULL DEFAULT '0',
    `checked_out_time` DATETIME            NOT NULL DEFAULT '0000-00-00 00:00:00',
    PRIMARY KEY (`id`),
    KEY `idx_state` (`state`),
    KEY `idx_createdby` (`created_by`),
    KEY `idx_language` (`language`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  DEFAULT COLLATE = utf8mb4_unicode_ci
  AUTO_INCREMENT = 1000;

--
-- Table structure for table `#__foodman_shops`
--

CREATE TABLE IF NOT EXISTS `#__foodman_shops`
(
    `id`               int(11)             NOT NULL AUTO_INCREMENT,
    `name`             varchar(255)        NOT NULL DEFAULT '',
    `state`            tinyint(3)          NOT NULL DEFAULT 0,
    `groupid`          int(11)             NOT NULL DEFAULT 0,
    `description`      text                NOT NULL DEFAULT '',
    `ordering`         int(11)             NOT NULL DEFAULT 0,
    `params`           text                NOT NULL DEFAULT '',
    `language`         char(7)             NOT NULL DEFAULT '',
    `featured`         tinyint(3) unsigned NOT NULL DEFAULT 0,
    `created`          datetime            NOT NULL DEFAULT '0000-00-00 00:00:00',
    `created_by`       int(10) unsigned    NOT NULL DEFAULT 0,
    `modified`         datetime            NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by`      int(10) unsigned    NOT NULL DEFAULT 0,
    `checked_out`      INT(10)             NOT NULL DEFAULT '0',
    `checked_out_time` DATETIME            NOT NULL DEFAULT '0000-00-00 00:00:00',
    PRIMARY KEY (`id`),
    KEY `idx_state` (`state`),
    KEY `idx_createdby` (`created_by`),
    KEY `idx_language` (`language`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  DEFAULT COLLATE = utf8mb4_unicode_ci
  AUTO_INCREMENT = 1000;

--
-- Table structure for table `#__foodman_locations`
--

CREATE TABLE IF NOT EXISTS `#__foodman_locations`
(
    `id`               int(11)             NOT NULL AUTO_INCREMENT,
    `name`             varchar(255)        NOT NULL DEFAULT '',
    `state`            tinyint(3)          NOT NULL DEFAULT 0,
    `groupid`          int(11)             NOT NULL DEFAULT 0,
    `description`      text                NOT NULL DEFAULT '',
    `ordering`         int(11)             NOT NULL DEFAULT 0,
    `params`           text                NOT NULL DEFAULT '',
    `language`         char(7)             NOT NULL DEFAULT '',
    `featured`         tinyint(3) unsigned NOT NULL DEFAULT 0,
    `created`          datetime            NOT NULL DEFAULT '0000-00-00 00:00:00',
    `created_by`       int(10) unsigned    NOT NULL DEFAULT 0,
    `modified`         datetime            NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by`      int(10) unsigned    NOT NULL DEFAULT 0,
    `checked_out`      INT(10)             NOT NULL DEFAULT '0',
    `checked_out_time` DATETIME            NOT NULL DEFAULT '0000-00-00 00:00:00',
    PRIMARY KEY (`id`),
    KEY `idx_state` (`state`),
    KEY `idx_createdby` (`created_by`),
    KEY `idx_language` (`language`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  DEFAULT COLLATE = utf8mb4_unicode_ci
  AUTO_INCREMENT = 1000;

--
-- Table structure for table `#__foodman_categories`
--

CREATE TABLE IF NOT EXISTS `#__foodman_categories`
(
    `id`               int(11)             NOT NULL AUTO_INCREMENT,
    `name`             varchar(255)        NOT NULL DEFAULT '',
    `expires`          tinyint(3)          NOT NULL DEFAULT 0,
    `state`            tinyint(3)          NOT NULL DEFAULT 0,
    `groupid`          int(11)             NOT NULL DEFAULT 0,
    `description`      text                NOT NULL DEFAULT '',
    `ordering`         int(11)             NOT NULL DEFAULT 0,
    `params`           text                NOT NULL DEFAULT '',
    `language`         char(7)             NOT NULL DEFAULT '',
    `featured`         tinyint(3) unsigned NOT NULL DEFAULT 0,
    `created`          datetime            NOT NULL DEFAULT '0000-00-00 00:00:00',
    `created_by`       int(10) unsigned    NOT NULL DEFAULT 0,
    `modified`         datetime            NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by`      int(10) unsigned    NOT NULL DEFAULT 0,
    `checked_out`      INT(10)             NOT NULL DEFAULT '0',
    `checked_out_time` DATETIME            NOT NULL DEFAULT '0000-00-00 00:00:00',
    PRIMARY KEY (`id`),
    KEY `idx_state` (`state`),
    KEY `idx_createdby` (`created_by`),
    KEY `idx_language` (`language`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  DEFAULT COLLATE = utf8mb4_unicode_ci
  AUTO_INCREMENT = 1000;

--
-- Table structure for table `#__foodman_lists`
--

CREATE TABLE IF NOT EXISTS `#__foodman_lists`
(
    `id`               int(11)             NOT NULL AUTO_INCREMENT,
    `name`             varchar(255)        NOT NULL DEFAULT '',
    `state`            tinyint(3)          NOT NULL DEFAULT 0,
    `groupid`          int(11)             NOT NULL DEFAULT 0,
    `description`      text                NOT NULL DEFAULT '',
    `ordering`         int(11)             NOT NULL DEFAULT 0,
    `params`           text                NOT NULL DEFAULT '',
    `featured`         tinyint(3) unsigned NOT NULL DEFAULT 0,
    `created`          datetime            NOT NULL DEFAULT '0000-00-00 00:00:00',
    `created_by`       int(10) unsigned    NOT NULL DEFAULT 0,
    `modified`         datetime            NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by`      int(10) unsigned    NOT NULL DEFAULT 0,
    `checked_out`      INT(10)             NOT NULL DEFAULT '0',
    `checked_out_time` DATETIME            NOT NULL DEFAULT '0000-00-00 00:00:00',
    PRIMARY KEY (`id`),
    KEY `idx_state` (`state`),
    KEY `idx_createdby` (`created_by`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  DEFAULT COLLATE = utf8mb4_unicode_ci
  AUTO_INCREMENT = 1000;

--
-- Table structure for table `#__foodman_products`
--

CREATE TABLE IF NOT EXISTS `#__foodman_products`
(
    `id`               int(11)             NOT NULL AUTO_INCREMENT,
    `name`             varchar(255)        NOT NULL DEFAULT '',
    `state`            tinyint(3)          NOT NULL DEFAULT 0,
    `groupid`          int(11)             NOT NULL DEFAULT 0,
    `catid`            int(11)             NOT NULL DEFAULT 0,
    `description`      text                NOT NULL DEFAULT '',
    `ordering`         int(11)             NOT NULL DEFAULT 0,
    `expires`          tinyint(3)          NOT NULL DEFAULT 0,
    `params`           text                NOT NULL DEFAULT '',
    `language`         char(7)             NOT NULL DEFAULT '',
    `minstock`         int(4) unsigned     NOT NULL DEFAULT 0,
    `maxstock`         int(4) unsigned     NOT NULL DEFAULT 0,
    `daysopen`         int(4) unsigned     NOT NULL DEFAULT 0,
    `featured`         tinyint(3) unsigned NOT NULL DEFAULT 0,
    `created`          datetime            NOT NULL DEFAULT '0000-00-00 00:00:00',
    `created_by`       int(10) unsigned    NOT NULL DEFAULT 0,
    `modified`         datetime            NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by`      int(10) unsigned    NOT NULL DEFAULT 0,
    `checked_out`      INT(10)             NOT NULL DEFAULT '0',
    `checked_out_time` DATETIME            NOT NULL DEFAULT '0000-00-00 00:00:00',
    PRIMARY KEY (`id`),
    KEY `idx_state` (`state`),
    KEY `idx_createdby` (`created_by`),
    KEY `idx_language` (`language`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  DEFAULT COLLATE = utf8mb4_unicode_ci
  AUTO_INCREMENT = 1000;

--
-- Table structure for table `#__foodman_stocks`
--

CREATE TABLE IF NOT EXISTS `#__foodman_stocks`
(
    `id`               int(11)                NOT NULL AUTO_INCREMENT,
    `state`            tinyint(3)             NOT NULL DEFAULT 0,
    `groupid`          int(11)                NOT NULL DEFAULT 0,
    `proid`            int(11)                NOT NULL DEFAULT 0,
    `locid`            int(11)                NOT NULL DEFAULT 0,
    `quantity`         decimal(9, 3) unsigned NOT NULL DEFAULT 0,
    `expiration`       datetime               NOT NULL DEFAULT '0000-00-00 00:00:00',
    `open`             tinyint(3)             NOT NULL DEFAULT 0,
    `params`           text                   NOT NULL DEFAULT '',
    `ordering`         int(11)                NOT NULL DEFAULT 0,
    `featured`         tinyint(3) unsigned    NOT NULL DEFAULT 0,
    `created`          datetime               NOT NULL DEFAULT '0000-00-00 00:00:00',
    `created_by`       int(10) unsigned       NOT NULL DEFAULT 0,
    `modified`         datetime               NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by`      int(10) unsigned       NOT NULL DEFAULT 0,
    `checked_out`      INT(10)                NOT NULL DEFAULT '0',
    `checked_out_time` DATETIME               NOT NULL DEFAULT '0000-00-00 00:00:00',
    PRIMARY KEY (`id`),
    KEY `idx_state` (`state`),
    KEY `idx_createdby` (`created_by`),
    KEY `groupid` (`groupid`),
    KEY `proid` (`proid`),
    KEY `locid` (`locid`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  DEFAULT COLLATE = utf8mb4_unicode_ci
  AUTO_INCREMENT = 1000;

--
-- Table structure for table `#__foodman_shopping`
--

CREATE TABLE IF NOT EXISTS `#__foodman_shopping`
(
    `id`               int(11)                NOT NULL AUTO_INCREMENT,
    `state`            tinyint(3)             NOT NULL DEFAULT 0,
    `process`          tinyint(3)             NOT NULL DEFAULT 0,
    `proid`            int(11)                NOT NULL DEFAULT 0,
    `listid`           int(11)                NOT NULL DEFAULT 0,
    `groupid`          int(11)                NOT NULL DEFAULT 0,
    `locid`            int(11)                NOT NULL DEFAULT 0,
    `quantity`         decimal(9, 3) unsigned NOT NULL DEFAULT 0,
    `bought`           decimal(9, 3) unsigned NOT NULL DEFAULT 0,
    `price`            decimal(9, 3) unsigned NOT NULL DEFAULT 0,
    `expiration`       datetime               NOT NULL DEFAULT '0000-00-00 00:00:00',
    `comments`         text                   NOT NULL DEFAULT '',
    `params`           text                   NOT NULL DEFAULT '',
    `ordering`         int(11)                NOT NULL DEFAULT 0,
    `featured`         tinyint(3) unsigned    NOT NULL DEFAULT 0,
    `created`          datetime               NOT NULL DEFAULT '0000-00-00 00:00:00',
    `created_by`       int(10) unsigned       NOT NULL DEFAULT 0,
    `modified`         datetime               NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by`      int(10) unsigned       NOT NULL DEFAULT 0,
    `checked_out`      INT(10)                NOT NULL DEFAULT '0',
    `checked_out_time` DATETIME               NOT NULL DEFAULT '0000-00-00 00:00:00',
    PRIMARY KEY (`id`),
    KEY `idx_state` (`state`),
    KEY `idx_createdby` (`created_by`),
    KEY `groupid` (`groupid`),
    KEY `proid` (`proid`),
    KEY `listid` (`listid`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  DEFAULT COLLATE = utf8mb4_unicode_ci
  AUTO_INCREMENT = 1000;

--
-- Table structure for table `#__foodman_movements`
--

CREATE TABLE IF NOT EXISTS `#__foodman_movements`
(
    `id`               int(11)                NOT NULL AUTO_INCREMENT,
    `state`            tinyint(3)             NOT NULL DEFAULT 0,
    `type`             tinyint(3)             NOT NULL DEFAULT 0,
    `proid`            int(11)                NOT NULL DEFAULT 0,
    `locid`            int(11)                NOT NULL DEFAULT 0,
    `listid`           int(11)                NOT NULL DEFAULT 0,
    `shopid`           int(11)                NOT NULL DEFAULT 0,
    `groupid`          int(11)                NOT NULL DEFAULT 0,
    `stockid`          int(11)                NOT NULL DEFAULT 0,
    `quantity`         decimal(9, 3) unsigned NOT NULL DEFAULT 0,
    `price`            decimal(9, 3) unsigned NOT NULL DEFAULT 0,
    `expiration`       datetime               NOT NULL DEFAULT '0000-00-00 00:00:00',
    `comments`         text                   NOT NULL DEFAULT '',
    `params`           text                   NOT NULL DEFAULT '',
    `ordering`         int(11)                NOT NULL DEFAULT 0,
    `featured`         tinyint(3) unsigned    NOT NULL DEFAULT 0,
    `created`          datetime               NOT NULL DEFAULT '0000-00-00 00:00:00',
    `created_by`       int(10) unsigned       NOT NULL DEFAULT 0,
    `modified`         datetime               NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by`      int(10) unsigned       NOT NULL DEFAULT 0,
    `checked_out`      INT(10)                NOT NULL DEFAULT '0',
    `checked_out_time` DATETIME               NOT NULL DEFAULT '0000-00-00 00:00:00',
    PRIMARY KEY (`id`),
    KEY `idx_state` (`state`),
    KEY `idx_createdby` (`created_by`),
    KEY `groupid` (`groupid`),
    KEY `proid` (`proid`),
    KEY `listid` (`listid`),
    KEY `shopid` (`shopid`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  DEFAULT COLLATE = utf8mb4_unicode_ci;

--
-- Table structure for table `#__foodman_xref`
--

CREATE TABLE IF NOT EXISTS `#__foodman_xref`
(
    `id`           int(11)  NOT NULL AUTO_INCREMENT,
    `KeyPrimary`   char(16) NOT NULL,
    `KeySecondary` char(16) NOT NULL,
    `primary`      int(11)  NOT NULL DEFAULT 0,
    `secondary`    int(11)  NOT NULL DEFAULT 0,
    `groupid`      int(11)           DEFAULT NULL,

    PRIMARY KEY (`id`),
    UNIQUE KEY `unique` (`KeyPrimary`, `KeySecondary`, `primary`, `secondary`),
    KEY `KeyPrimary` (`KeyPrimary`),
    KEY `KeySecondary` (`KeySecondary`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  DEFAULT COLLATE = utf8mb4_unicode_ci
  AUTO_INCREMENT = 1000;
