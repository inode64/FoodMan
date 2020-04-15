--
-- Table structure for table `#__foodman_groups`
--

CREATE TABLE IF NOT EXISTS `#__foodman_groups`
(
    `id`               int(11)             NOT NULL AUTO_INCREMENT,
    `name`             varchar(255)        NOT NULL DEFAULT '',
    `state`            tinyint(3)          NOT NULL DEFAULT 0,
    `userid`           int(11)             NOT NULL DEFAULT 0,
    `description`      text                NOT NULL,
    `ordering`         int(11)             NOT NULL DEFAULT 0,
    `params`           text                NOT NULL,
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
-- Table structure for table `#__foodman_group_user`
--

CREATE TABLE IF NOT EXISTS `#__foodman_group_user`
(
    `id`       int(11) NOT NULL AUTO_INCREMENT,
    `groupid`  int(11) NOT NULL DEFAULT 0,
    `userid`   int(11) NOT NULL DEFAULT 0,
    `ordering` int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    UNIQUE KEY `group_user` (`groupid`, `userid`),
    KEY `groupid` (`groupid`),
    KEY `userid` (`userid`)
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
    `userid`           int(11)             NOT NULL DEFAULT 0,
    `description`      text                NOT NULL,
    `ordering`         int(11)             NOT NULL DEFAULT 0,
    `params`           text                NOT NULL,
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

CREATE TABLE IF NOT EXISTS `#__foodman_shops`
(
    `id`               int(11)             NOT NULL AUTO_INCREMENT,
    `name`             varchar(255)        NOT NULL DEFAULT '',
    `state`            tinyint(3)          NOT NULL DEFAULT 0,
    `userid`           int(11)             NOT NULL DEFAULT 0,
    `description`      text                NOT NULL,
    `ordering`         int(11)             NOT NULL DEFAULT 0,
    `params`           text                NOT NULL,
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
    `userid`           int(11)             NOT NULL DEFAULT 0,
    `description`      text                NOT NULL,
    `ordering`         int(11)             NOT NULL DEFAULT 0,
    `params`           text                NOT NULL,
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
    `expiration`       tinyint(3)          NOT NULL DEFAULT 0,
    `state`            tinyint(3)          NOT NULL DEFAULT 0,
    `userid`           int(11)             NOT NULL DEFAULT 0,
    `description`      text                NOT NULL,
    `ordering`         int(11)             NOT NULL DEFAULT 0,
    `params`           text                NOT NULL,
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
-- Table structure for table `#__foodman_category_location`
--

CREATE TABLE IF NOT EXISTS `#__foodman_category_location`
(
    `id`       int(11) NOT NULL AUTO_INCREMENT,
    `catid`    int(11) NOT NULL DEFAULT 0,
    `locid`    int(11) NOT NULL DEFAULT 0,
    `ordering` int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    UNIQUE KEY `category_location` (`catid`, `locid`),
    KEY `catid` (`catid`),
    KEY `locid` (`locid`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  DEFAULT COLLATE = utf8mb4_unicode_ci
  AUTO_INCREMENT = 1000;

--
-- Table structure for table `#__foodman_category_shop`
--

CREATE TABLE IF NOT EXISTS `#__foodman_category_shop`
(
    `id`       int(11) NOT NULL AUTO_INCREMENT,
    `catid`    int(11) NOT NULL DEFAULT 0,
    `shopid`   int(11) NOT NULL DEFAULT 0,
    `ordering` int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    UNIQUE KEY `category shop` (`catid`, `shopid`),
    KEY `catid` (`catid`),
    KEY `shopid` (`shopid`)
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
    `userid`           int(11)             NOT NULL DEFAULT 0,
    `description`      text                NOT NULL,
    `ordering`         int(11)             NOT NULL DEFAULT 0,
    `params`           text                NOT NULL,
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
-- Table structure for table `#__foodman_list_location`
--

CREATE TABLE IF NOT EXISTS `#__foodman_list_shop`
(
    `id`       int(11) NOT NULL AUTO_INCREMENT,
    `listid`   int(11) NOT NULL DEFAULT 0,
    `shopid`   int(11) NOT NULL DEFAULT 0,
    `ordering` int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    UNIQUE KEY `list shop` (`listid`, `shopid`),
    KEY `listid` (`listid`),
    KEY `shopid` (`shopid`)
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
    `userid`           int(11)             NOT NULL DEFAULT 0,
    `catid`            int(11)             NOT NULL DEFAULT 0,
    `description`      text                NOT NULL,
    `ordering`         int(11)             NOT NULL DEFAULT 0,
    `expiration`       tinyint(3)          NOT NULL DEFAULT 0,
    `params`           text                NOT NULL,
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
-- Table structure for table `#__foodman_product_category`
--

CREATE TABLE IF NOT EXISTS `#__foodman_product_category`
(
    `id`       int(11) NOT NULL AUTO_INCREMENT,
    `proid`    int(11) NOT NULL DEFAULT 0,
    `catid`    int(11) NOT NULL DEFAULT 0,
    `ordering` int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    UNIQUE KEY `product_category` (`proid`, `catid`),
    KEY `proid` (`proid`),
    KEY `catid` (`catid`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  DEFAULT COLLATE = utf8mb4_unicode_ci
  AUTO_INCREMENT = 1000;

--
-- Table structure for table `#__foodman_product_location`
--

CREATE TABLE IF NOT EXISTS `#__foodman_product_location`
(
    `id`       int(11) NOT NULL AUTO_INCREMENT,
    `proid`    int(11) NOT NULL DEFAULT 0,
    `locid`    int(11) NOT NULL DEFAULT 0,
    `ordering` int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    UNIQUE KEY `product_location` (`proid`, `locid`),
    KEY `proid` (`proid`),
    KEY `locid` (`locid`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  DEFAULT COLLATE = utf8mb4_unicode_ci
  AUTO_INCREMENT = 1000;

--
-- Table structure for table `#__foodman_product_list`
--

CREATE TABLE IF NOT EXISTS `#__foodman_product_list`
(
    `id`       int(11)         NOT NULL AUTO_INCREMENT,
    `proid`    int(11)         NOT NULL DEFAULT 0,
    `listid`   int(11)         NOT NULL DEFAULT 0,
    `quantity` int(4) unsigned NOT NULL DEFAULT 0,
    `ordering` int(11)         NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    UNIQUE KEY `product_list` (`proid`, `listid`),
    KEY `proid` (`proid`),
    KEY `listid` (`listid`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  DEFAULT COLLATE = utf8mb4_unicode_ci
  AUTO_INCREMENT = 1000;

--
-- Table structure for table `#__foodman_stocks`
--

CREATE TABLE IF NOT EXISTS `#__foodman_stocks`
(
    `id`               int(11)             NOT NULL AUTO_INCREMENT,
    `state`            tinyint(3)          NOT NULL DEFAULT 0,
    `userid`           int(11)             NOT NULL DEFAULT 0,
    `proid`            int(11)             NOT NULL DEFAULT 0,
    `locid`            int(11)             NOT NULL DEFAULT 0,
    `quantity`         int(4) unsigned     NOT NULL DEFAULT 0,
    `expiration`       datetime            NOT NULL DEFAULT '0000-00-00 00:00:00',
    `open`             tinyint(3)          NOT NULL DEFAULT 0,
    `params`           text                NOT NULL,
    `ordering`         int(11)             NOT NULL DEFAULT 0,
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
    KEY `idx_language` (`language`),
    KEY `userid` (`userid`),
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
    `userid`           int(11)                NOT NULL DEFAULT 0,
    `locid`            int(11)                NOT NULL DEFAULT 0,
    `quantity`         int(4) unsigned        NOT NULL DEFAULT 0,
    `bought`           int(4) unsigned        NOT NULL DEFAULT 0,
    `price`            decimal(4, 2) unsigned NOT NULL DEFAULT '0.00',
    `comments`         text                   NOT NULL,
    `params`           text                   NOT NULL,
    `ordering`         int(11)                NOT NULL DEFAULT 0,
    `language`         char(7)                NOT NULL DEFAULT '',
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
    KEY `idx_language` (`language`),
    KEY `userid` (`userid`),
    KEY `proid` (`proid`),
    KEY `listid` (`listid`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  DEFAULT COLLATE = utf8mb4_unicode_ci
  AUTO_INCREMENT = 1000;

--
-- Table structure for table `#__foodman_movement`
--

CREATE TABLE IF NOT EXISTS `#__foodman_movement`
(
    `id`               int(11)                NOT NULL AUTO_INCREMENT,
    `state`            tinyint(3)             NOT NULL DEFAULT 0,
    `type`             tinyint(3)             NOT NULL DEFAULT 0,
    `proid`            int(11)                NOT NULL DEFAULT 0,
    `locid`            int(11)                NOT NULL DEFAULT 0,
    `listid`           int(11)                NOT NULL DEFAULT 0,
    `shopid`           int(11)                NOT NULL DEFAULT 0,
    `userid`           int(11)                NOT NULL DEFAULT 0,
    `quantity`         int(4) unsigned        NOT NULL DEFAULT 0,
    `price`            decimal(4, 2) unsigned NOT NULL DEFAULT '0.00',
    `comments`         text                   NOT NULL,
    `params`           text                   NOT NULL,
    `ordering`         int(11)                NOT NULL DEFAULT 0,
    `language`         char(7)                NOT NULL DEFAULT '',
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
    KEY `idx_language` (`language`),
    KEY `userid` (`userid`),
    KEY `proid` (`proid`),
    KEY `listid` (`listid`),
    KEY `shopid` (`shopid`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  DEFAULT COLLATE = utf8mb4_unicode_ci;

INSERT IGNORE INTO `#__foodman_categories` (`id`, `name`, `state`, `language`)
VALUES (1, 'Vegetables', 1, 'en-GB'),
       (2, 'Fruits', 1, 'en-GB'),
       (3, 'Dairy Products', 1, 'en-GB'),
       (4, 'Meat', 1, 'en-GB'),
       (5, 'Fish', 1, 'en-GB'),
       (6, 'Grains and Legumes', 1, 'en-GB'),
       (7, 'Drinks', 1, 'en-GB'),
       (8, 'Spirit drinks', 1, 'en-GB'),
       (9, 'frozen goods', 1, 'en-GB');

INSERT IGNORE INTO `#__foodman_locations` (`id`, `name`, `state`, `language`)
VALUES (1, 'Fridge', 1, 'en-GB'),
       (2, 'Freezer', 1, 'en-GB'),
       (3, 'Kitchen', 1, 'en-GB'),
       (4, 'Cupboard', 1, 'en-GB');

INSERT IGNORE INTO `#__foodman_shops` (`id`, `name`, `state`, `language`)
VALUES (1, 'Supermarkets', 1, 'en-GB'),
       (2, 'Shopping centre', 1, 'en-GB'),
       (3, 'Corner shop', 1, 'en-GB'),
       (4, 'Butcher’s', 1, 'en-GB'),
       (5, 'Chemist’s', 1, 'en-GB'),
       (6, 'Ironmonger’s ', 1, 'en-GB'),
       (7, 'Fruit shop', 1, 'en-GB'),
       (8, 'Herbalist’s shop', 1, 'en-GB'),
       (9, 'Superstore', 1, 'en-GB'),
       (10, 'Creamery', 1, 'en-GB'),
       (11, 'Market', 1, 'en-GB'),
       (12, 'Liquor store', 1, 'en-GB'),
       (13, 'Baker’s', 1, 'en-GB'),
       (14, 'Cake shop', 1, 'en-GB'),
       (15, 'Fishmonger’s', 1, 'en-GB'),
       (16, 'Delicatessen', 1, 'en-GB');

INSERT IGNORE INTO `#__foodman_products` (`id`, `name`, `catid`, `expiration`, `state`, `language`)
VALUES (1, 'Potatoes', 1, 1, 1, 'en-GB'),
       (2, 'Tomatoes', 1, 1, 1, 'en-GB'),
       (3, 'Pizza', 9, 1, 1, 'en-GB');
