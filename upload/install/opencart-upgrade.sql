-- --------------------------------------------------------

--
-- Database: `opencart`
--

-- --------------------------------------------------------

SET SQL_MODE = "";

--
-- Table structure for table `oc_address`
--

DROP TABLE IF EXISTS `oc_address`;
CREATE TABLE `oc_address` (
  `zone_id` int(11) NOT NULL DEFAULT '0',
  `country_id` int(11) NOT NULL DEFAULT '0',
  `postcode` varchar(10) NOT NULL,
  `city` varchar(128) NOT NULL,
  `address_2` varchar(128) NOT NULL,
  `address_1` varchar(128) NOT NULL,
  `tax_id` varchar(32) NOT NULL,
  `company_id` varchar(32) NOT NULL,
  `company` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`address_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_affiliate`
--

DROP TABLE IF EXISTS `oc_affiliate`;
CREATE TABLE `oc_affiliate` (
  `date_added` datetime NOT NULL,
  `approved` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `bank_account_number` varchar(64) NOT NULL,
  `bank_account_name` varchar(64) NOT NULL,
  `bank_swift_code` varchar(64) NOT NULL,
  `bank_branch_number` varchar(64) NOT NULL,
  `bank_name` varchar(64) NOT NULL,
  `paypal` varchar(64) NOT NULL,
  `cheque` varchar(100) NOT NULL,
  `payment` varchar(6) NOT NULL,
  `tax` varchar(64) NOT NULL,
  `commission` decimal(4,2) NOT NULL DEFAULT '0.00',
  `code` varchar(64) NOT NULL,
  `zone_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `postcode` varchar(10) NOT NULL,
  `city` varchar(128) NOT NULL,
  `address_2` varchar(128) NOT NULL,
  `address_1` varchar(128) NOT NULL,
  `website` varchar(255) NOT NULL,
  `company` varchar(32) NOT NULL,
  `salt` varchar(9) NOT NULL,
  `password` varchar(40) NOT NULL,
  `fax` varchar(32) NOT NULL,
  `telephone` varchar(32) NOT NULL,
  `email` varchar(96) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `affiliate_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`affiliate_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_affiliate_transaction`
--

DROP TABLE IF EXISTS `oc_affiliate_transaction`;
CREATE TABLE `oc_affiliate_transaction` (
  `date_added` datetime NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `order_id` int(11) NOT NULL,
  `affiliate_id` int(11) NOT NULL,
  `affiliate_transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`affiliate_transaction_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_attribute`
--

DROP TABLE IF EXISTS `oc_attribute`;
CREATE TABLE `oc_attribute` (
  `sort_order` int(3) NOT NULL,
  `attribute_group_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`attribute_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_attribute_description`
--

DROP TABLE IF EXISTS `oc_attribute_description`;
CREATE TABLE `oc_attribute_description` (
  `name` varchar(64) NOT NULL,
  `language_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  PRIMARY KEY (`attribute_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_attribute_group`
--

DROP TABLE IF EXISTS `oc_attribute_group`;
CREATE TABLE `oc_attribute_group` (
  `sort_order` int(3) NOT NULL,
  `attribute_group_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`attribute_group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_attribute_group_description`
--

DROP TABLE IF EXISTS `oc_attribute_group_description`;
CREATE TABLE `oc_attribute_group_description` (
  `name` varchar(64) NOT NULL,
  `language_id` int(11) NOT NULL,
  `attribute_group_id` int(11) NOT NULL,
  PRIMARY KEY (`attribute_group_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_banner`
--

DROP TABLE IF EXISTS `oc_banner`;
CREATE TABLE `oc_banner` (
  `status` tinyint(1) NOT NULL,
  `name` varchar(64) NOT NULL,
  `banner_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`banner_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_banner_image`
--

DROP TABLE IF EXISTS `oc_banner_image`;
CREATE TABLE `oc_banner_image` (
  `image` varchar(255) NOT NULL,
  `external_link` tinyint(1) NOT NULL,
  `link` varchar(255) NOT NULL,
  `banner_id` int(11) NOT NULL,
  `banner_image_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`banner_image_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_banner_image_description`
--

DROP TABLE IF EXISTS `oc_banner_image_description`;
CREATE TABLE `oc_banner_image_description` (
  `title` varchar(64) NOT NULL,
  `banner_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `banner_image_id` int(11) NOT NULL,
  PRIMARY KEY (`banner_image_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_block_ip`
--

DROP TABLE IF EXISTS `oc_block_ip`;
CREATE TABLE `oc_block_ip` (
  `to_ip` varchar(32) NOT NULL,
  `from_ip` varchar(32) NOT NULL,
  `block_ip_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`block_ip_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_category`
--

DROP TABLE IF EXISTS `oc_category`;
CREATE TABLE `oc_category` (
  `date_modified` datetime NOT NULL,
  `date_added` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `column` int(3) NOT NULL,
  `top` tinyint(1) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `image` varchar(255) DEFAULT NULL,
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`category_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_category_description`
--

DROP TABLE IF EXISTS `oc_category_description`;
CREATE TABLE `oc_category_description` (
  `meta_keyword` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `name` varchar(255) NOT NULL,
  `language_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`category_id`,`language_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_category_filter`
--

DROP TABLE IF EXISTS `oc_category_filter`;
CREATE TABLE `oc_category_filter` (
  `filter_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`category_id`,`filter_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_category_path`
--

DROP TABLE IF EXISTS `oc_category_path`;
CREATE TABLE `oc_category_path` (
  `level` int(11) NOT NULL,
  `path_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`category_id`,`path_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_category_to_layout`
--

DROP TABLE IF EXISTS `oc_category_to_layout`;
CREATE TABLE `oc_category_to_layout` (
  `layout_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`category_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_category_to_store`
--

DROP TABLE IF EXISTS `oc_category_to_store`;
CREATE TABLE `oc_category_to_store` (
  `store_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`category_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_connection`
--

DROP TABLE IF EXISTS `oc_connection`;
CREATE TABLE `oc_connection` (
  `frontend` tinyint(1) NOT NULL,
  `backend` tinyint(1) NOT NULL,
  `name` varchar(64) NOT NULL,
  `connection_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`connection_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_connection_route`
--

DROP TABLE IF EXISTS `oc_connection_route`;
CREATE TABLE `oc_connection_route` (
  `route` varchar(255) NOT NULL,
  `title` varchar(64) NOT NULL,
  `connection_id` int(11) NOT NULL,
  `connection_route_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`connection_route_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_country`
--

DROP TABLE IF EXISTS `oc_country`;
CREATE TABLE `oc_country` (
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `postcode_required` tinyint(1) NOT NULL,
  `address_format` text CHARACTER SET utf8 NOT NULL,
  `iso_code_3` varchar(3) NOT NULL,
  `iso_code_2` varchar(2) NOT NULL,
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`country_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_country_description`
--

DROP TABLE IF EXISTS `oc_country_description`;
CREATE TABLE `oc_country_description` (
  `name` varchar(128) NOT NULL,
  `language_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  PRIMARY KEY (`country_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_coupon`
--

DROP TABLE IF EXISTS `oc_coupon`;
CREATE TABLE `oc_coupon` (
  `date_added` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `uses_customer` varchar(11) NOT NULL,
  `uses_total` int(11) NOT NULL,
  `date_end` date NOT NULL DEFAULT '0000-00-00',
  `date_start` date NOT NULL DEFAULT '0000-00-00',
  `total` decimal(15,4) NOT NULL,
  `shipping` tinyint(1) NOT NULL,
  `logged` tinyint(1) NOT NULL,
  `discount` decimal(15,4) NOT NULL,
  `type` char(1) NOT NULL,
  `code` varchar(10) NOT NULL,
  `name` varchar(128) NOT NULL,
  `coupon_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`coupon_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_coupon_category`
--

DROP TABLE IF EXISTS `oc_coupon_category`;
CREATE TABLE `oc_coupon_category` (
  `category_id` int(11) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  PRIMARY KEY (`coupon_id`,`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_coupon_history`
--

DROP TABLE IF EXISTS `oc_coupon_history`;
CREATE TABLE `oc_coupon_history` (
  `date_added` datetime NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `coupon_history_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`coupon_history_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_coupon_product`
--

DROP TABLE IF EXISTS `oc_coupon_product`;
CREATE TABLE `oc_coupon_product` (
  `product_id` int(11) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `coupon_product_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`coupon_product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_currency`
--

DROP TABLE IF EXISTS `oc_currency`;
CREATE TABLE `oc_currency` (
  `date_modified` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `value` float(15,8) NOT NULL,
  `decimal_place` char(1) NOT NULL,
  `symbol_right` varchar(12) NOT NULL,
  `symbol_left` varchar(12) NOT NULL,
  `code` varchar(3) NOT NULL,
  `title` varchar(32) NOT NULL,
  `currency_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`currency_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_customer`
--

DROP TABLE IF EXISTS `oc_customer`;
CREATE TABLE `oc_customer` (
  `date_added` datetime NOT NULL,
  `token` varchar(255) NOT NULL,
  `approved` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `ip` varchar(32) NOT NULL DEFAULT '0',
  `customer_group_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL DEFAULT '0',
  `newsletter` tinyint(1) NOT NULL DEFAULT '0',
  `wishlist` text CHARACTER SET utf8,
  `cart` text CHARACTER SET utf8,
  `salt` varchar(9) NOT NULL,
  `password` varchar(40) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` varchar(32) NOT NULL,
  `fax` varchar(32) NOT NULL,
  `telephone` varchar(32) NOT NULL,
  `email` varchar(96) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`customer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_customer_ban_ip`
--

DROP TABLE IF EXISTS `oc_customer_ban_ip`;
CREATE TABLE `oc_customer_ban_ip` (
  `ip` varchar(32) NOT NULL,
  `customer_ban_ip_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`customer_ban_ip_id`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_customer_group`
--

DROP TABLE IF EXISTS `oc_customer_group`;
CREATE TABLE `oc_customer_group` (
  `sort_order` int(3) NOT NULL,
  `tax_id_required` int(1) NOT NULL,
  `tax_id_display` int(1) NOT NULL,
  `company_id_required` int(1) NOT NULL,
  `company_id_display` int(1) NOT NULL,
  `approval` int(1) NOT NULL,
  `customer_group_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`customer_group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_customer_group_description`
--

DROP TABLE IF EXISTS `oc_customer_group_description`;
CREATE TABLE `oc_customer_group_description` (
  `description` text CHARACTER SET utf8 NOT NULL,
  `name` varchar(32) NOT NULL,
  `language_id` int(11) NOT NULL,
  `customer_group_id` int(11) NOT NULL,
  PRIMARY KEY (`customer_group_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_customer_history`
--

DROP TABLE IF EXISTS `oc_customer_history`;
CREATE TABLE `oc_customer_history` (
  `date_added` datetime NOT NULL,
  `comment` text CHARACTER SET utf8 NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer_history_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`customer_history_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_customer_ip`
--

DROP TABLE IF EXISTS `oc_customer_ip`;
CREATE TABLE `oc_customer_ip` (
  `date_added` datetime NOT NULL,
  `ip` varchar(32) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer_ip_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`customer_ip_id`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_customer_online`
--

DROP TABLE IF EXISTS `oc_customer_online`;
CREATE TABLE `oc_customer_online` (
  `date_added` datetime NOT NULL,
  `user_agent` text NOT NULL,
  `referer` text NOT NULL,
  `url` text CHARACTER SET utf8 NOT NULL,
  `customer_id` int(11) NOT NULL,
  `ip` varchar(32) NOT NULL,
  PRIMARY KEY (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_customer_reward`
--

DROP TABLE IF EXISTS `oc_customer_reward`;
CREATE TABLE `oc_customer_reward` (
  `date_added` datetime NOT NULL,
  `points` int(8) NOT NULL DEFAULT '0',
  `description` text CHARACTER SET utf8 NOT NULL,
  `order_id` int(11) NOT NULL DEFAULT '0',
  `customer_id` int(11) NOT NULL DEFAULT '0',
  `customer_reward_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`customer_reward_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_customer_transaction`
--

DROP TABLE IF EXISTS `oc_customer_transaction`;
CREATE TABLE `oc_customer_transaction` (
  `date_added` datetime NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer_transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`customer_transaction_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_download`
--

DROP TABLE IF EXISTS `oc_download`;
CREATE TABLE `oc_download` (
  `date_added` datetime NOT NULL,
  `remaining` int(11) NOT NULL DEFAULT '0',
  `mask` varchar(128) NOT NULL,
  `filename` varchar(128) NOT NULL,
  `download_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`download_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_download_description`
--

DROP TABLE IF EXISTS `oc_download_description`;
CREATE TABLE `oc_download_description` (
  `name` varchar(128) NOT NULL,
  `language_id` int(11) NOT NULL,
  `download_id` int(11) NOT NULL,
  PRIMARY KEY (`download_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_eucountry`
--

DROP TABLE IF EXISTS `oc_eucountry`;
CREATE TABLE `oc_eucountry` (
  `status` tinyint(1) NOT NULL,
  `rate` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `code` varchar(2) DEFAULT NULL,
  `eucountry_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`eucountry_id`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_eucountry_description`
--

DROP TABLE IF EXISTS `oc_eucountry_description`;
CREATE TABLE `oc_eucountry_description` (
  `description` text CHARACTER SET utf8 NOT NULL,
  `eucountry` varchar(128) NOT NULL,
  `language_id` int(11) NOT NULL,
  `eucountry_id` int(11) NOT NULL,
  PRIMARY KEY (`eucountry_id`,`language_id`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_eucountry_to_store`
--

DROP TABLE IF EXISTS `oc_eucountry_to_store`;
CREATE TABLE `oc_eucountry_to_store` (
  `store_id` int(11) NOT NULL DEFAULT '0',
  `eucountry_id` int(11) NOT NULL,
  PRIMARY KEY (`eucountry_id`,`store_id`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_extension`
--

DROP TABLE IF EXISTS `oc_extension`;
CREATE TABLE `oc_extension` (
  `code` varchar(32) NOT NULL,
  `type` varchar(32) NOT NULL,
  `extension_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`extension_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_filter`
--

DROP TABLE IF EXISTS `oc_filter`;
CREATE TABLE `oc_filter` (
  `sort_order` int(3) NOT NULL,
  `filter_group_id` int(11) NOT NULL,
  `filter_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`filter_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_filter_description`
--

DROP TABLE IF EXISTS `oc_filter_description`;
CREATE TABLE `oc_filter_description` (
  `name` varchar(64) NOT NULL,
  `filter_group_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `filter_id` int(11) NOT NULL,
  PRIMARY KEY (`filter_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_filter_group`
--

DROP TABLE IF EXISTS `oc_filter_group`;
CREATE TABLE `oc_filter_group` (
  `sort_order` int(3) NOT NULL,
  `filter_group_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`filter_group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_filter_group_description`
--

DROP TABLE IF EXISTS `oc_filter_group_description`;
CREATE TABLE `oc_filter_group_description` (
  `name` varchar(64) NOT NULL,
  `language_id` int(11) NOT NULL,
  `filter_group_id` int(11) NOT NULL,
  PRIMARY KEY (`filter_group_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_footer`
--

DROP TABLE IF EXISTS `oc_footer`;
CREATE TABLE `oc_footer` (
  `status` tinyint(1) NOT NULL,
  `position` tinyint(1) NOT NULL,
  `footer_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`footer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_footer_description`
--

DROP TABLE IF EXISTS `oc_footer_description`;
CREATE TABLE `oc_footer_description` (
  `name` varchar(64) NOT NULL,
  `language_id` int(11) NOT NULL,
  `footer_id` int(11) NOT NULL,
  PRIMARY KEY (`footer_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_footer_route`
--

DROP TABLE IF EXISTS `oc_footer_route`;
CREATE TABLE `oc_footer_route` (
  `sort_order` int(3) NOT NULL,
  `external_link` tinyint(1) NOT NULL,
  `route` varchar(255) NOT NULL,
  `footer_id` int(11) NOT NULL,
  `footer_route_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`footer_route_id`,`footer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_footer_route_description`
--

DROP TABLE IF EXISTS `oc_footer_route_description`;
CREATE TABLE `oc_footer_route_description` (
  `title` varchar(64) NOT NULL,
  `footer_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `footer_route_id` int(11) NOT NULL,
  PRIMARY KEY (`footer_route_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_footer_to_store`
--

DROP TABLE IF EXISTS `oc_footer_to_store`;
CREATE TABLE `oc_footer_to_store` (
  `store_id` int(11) NOT NULL,
  `footer_id` int(11) NOT NULL,
  PRIMARY KEY (`footer_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_geo_zone`
--

DROP TABLE IF EXISTS `oc_geo_zone`;
CREATE TABLE `oc_geo_zone` (
  `date_modified` datetime NOT NULL,
  `date_added` datetime NOT NULL,
  `description` varchar(255) NOT NULL,
  `name` varchar(32) NOT NULL,
  `geo_zone_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`geo_zone_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_information`
--

DROP TABLE IF EXISTS `oc_information`;
CREATE TABLE `oc_information` (
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `bottom` int(1) NOT NULL DEFAULT '0',
  `information_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`information_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_information_description`
--

DROP TABLE IF EXISTS `oc_information_description`;
CREATE TABLE `oc_information_description` (
  `description` text NOT NULL,
  `meta_keyword` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `title` varchar(64) NOT NULL,
  `language_id` int(11) NOT NULL,
  `information_id` int(11) NOT NULL,
  PRIMARY KEY (`information_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_information_to_layout`
--

DROP TABLE IF EXISTS `oc_information_to_layout`;
CREATE TABLE `oc_information_to_layout` (
  `layout_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `information_id` int(11) NOT NULL,
  PRIMARY KEY (`information_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_information_to_store`
--

DROP TABLE IF EXISTS `oc_information_to_store`;
CREATE TABLE `oc_information_to_store` (
  `store_id` int(11) NOT NULL,
  `information_id` int(11) NOT NULL,
  PRIMARY KEY (`information_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_language`
--

DROP TABLE IF EXISTS `oc_language`;
CREATE TABLE `oc_language` (
  `status` tinyint(1) NOT NULL,
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `filename` varchar(64) NOT NULL,
  `directory` varchar(32) NOT NULL,
  `image` varchar(64) NOT NULL,
  `locale` varchar(255) NOT NULL,
  `code` varchar(5) NOT NULL,
  `name` varchar(32) NOT NULL,
  `language_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`language_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_layout`
--

DROP TABLE IF EXISTS `oc_layout`;
CREATE TABLE `oc_layout` (
  `name` varchar(64) NOT NULL,
  `layout_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`layout_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_layout_route`
--

DROP TABLE IF EXISTS `oc_layout_route`;
CREATE TABLE `oc_layout_route` (
  `route` varchar(255) NOT NULL,
  `store_id` int(11) NOT NULL,
  `layout_id` int(11) NOT NULL,
  `layout_route_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`layout_route_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_length_class`
--

DROP TABLE IF EXISTS `oc_length_class`;
CREATE TABLE `oc_length_class` (
  `value` decimal(15,8) NOT NULL,
  `length_class_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`length_class_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_length_class_description`
--

DROP TABLE IF EXISTS `oc_length_class_description`;
CREATE TABLE `oc_length_class_description` (
  `unit` varchar(4) NOT NULL,
  `title` varchar(32) NOT NULL,
  `language_id` int(11) NOT NULL,
  `length_class_id` int(11) NOT NULL,
  PRIMARY KEY (`length_class_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_location`
--

DROP TABLE IF EXISTS `oc_location`;
CREATE TABLE `oc_location` (
  `comment` text CHARACTER SET utf8 NOT NULL,
  `open` text CHARACTER SET utf8 NOT NULL,
  `longitude` varchar(32) NOT NULL,
  `latitude` varchar(32) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `telephone` varchar(32) NOT NULL,
  `address` text CHARACTER SET utf8 NOT NULL,
  `name` varchar(64) NOT NULL,
  `location_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`location_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_manufacturer`
--

DROP TABLE IF EXISTS `oc_manufacturer`;
CREATE TABLE `oc_manufacturer` (
  `status` tinyint(1) NOT NULL,
  `sort_order` int(3) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `manufacturer_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`manufacturer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_manufacturer_description`
--

DROP TABLE IF EXISTS `oc_manufacturer_description`;
CREATE TABLE `oc_manufacturer_description` (
  `description` text CHARACTER SET utf8 NOT NULL,
  `name` varchar(128) NOT NULL,
  `language_id` int(11) NOT NULL,
  `manufacturer_id` int(11) NOT NULL,
  PRIMARY KEY (`manufacturer_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_manufacturer_to_store`
--

DROP TABLE IF EXISTS `oc_manufacturer_to_store`;
CREATE TABLE `oc_manufacturer_to_store` (
  `store_id` int(11) NOT NULL,
  `manufacturer_id` int(11) NOT NULL,
  PRIMARY KEY (`manufacturer_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_menu`
--

DROP TABLE IF EXISTS `oc_menu`;
CREATE TABLE `oc_menu` (
  `status` tinyint(1) NOT NULL,
  `title` varchar(64) NOT NULL,
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`menu_id`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_menu_item`
--

DROP TABLE IF EXISTS `oc_menu_item`;
CREATE TABLE `oc_menu_item` (
  `status` tinyint(1) NOT NULL,
  `sort_order` int(3) NOT NULL,
  `external_link` tinyint(1) NOT NULL,
  `menu_item_link` varchar(255) NOT NULL,
  `parent_id` int(11) DEFAULT '0',
  `menu_id` int(11) NOT NULL,
  `menu_item_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`menu_item_id`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_menu_item_description`
--

DROP TABLE IF EXISTS `oc_menu_item_description`;
CREATE TABLE `oc_menu_item_description` (
  `meta_keyword` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `menu_item_name` varchar(64) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `menu_item_id` int(11) NOT NULL,
  PRIMARY KEY (`menu_item_id`,`language_id`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_menu_item_path`
--

DROP TABLE IF EXISTS `oc_menu_item_path`;
CREATE TABLE `oc_menu_item_path` (
  `level` int(11) NOT NULL,
  `path_id` int(11) NOT NULL,
  `menu_item_id` int(11) NOT NULL,
  PRIMARY KEY (`menu_item_id`,`path_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_menu_to_store`
--

DROP TABLE IF EXISTS `oc_menu_to_store`;
CREATE TABLE `oc_menu_to_store` (
  `store_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  PRIMARY KEY (`menu_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_news`
--

DROP TABLE IF EXISTS `oc_news`;
CREATE TABLE `oc_news` (
  `status` tinyint(1) NOT NULL,
  `viewed` int(11) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `news_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`news_id`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_news_description`
--

DROP TABLE IF EXISTS `oc_news_description`;
CREATE TABLE `oc_news_description` (
  `keyword` varchar(255) NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `meta_description` VARCHAR(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `language_id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  PRIMARY KEY (`news_id`,`language_id`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_news_to_store`
--

DROP TABLE IF EXISTS `oc_news_to_store`;
CREATE TABLE `oc_news_to_store` (
  `store_id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  PRIMARY KEY (`news_id`,`store_id`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_offer_category_category`
--

DROP TABLE IF EXISTS `oc_offer_category_category`;
CREATE TABLE `oc_offer_category_category` (
  `date_added` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_end` date NOT NULL DEFAULT '0000-00-00',
  `date_start` date NOT NULL DEFAULT '0000-00-00',
  `category_two` int(11) NOT NULL,
  `category_one` int(11) NOT NULL,
  `logged` tinyint(1) NOT NULL,
  `discount` decimal(15,4) NOT NULL,
  `type` char(1) NOT NULL,
  `name` varchar(128) NOT NULL,
  `offer_category_category_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`offer_category_category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_offer_category_product`
--

DROP TABLE IF EXISTS `oc_offer_category_product`;
CREATE TABLE `oc_offer_category_product` (
  `date_added` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_end` date NOT NULL DEFAULT '0000-00-00',
  `date_start` date NOT NULL DEFAULT '0000-00-00',
  `product_two` int(11) NOT NULL,
  `category_one` int(11) NOT NULL,
  `logged` tinyint(1) NOT NULL,
  `discount` decimal(15,4) NOT NULL,
  `type` char(1) NOT NULL,
  `name` varchar(128) NOT NULL,
  `offer_category_product_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`offer_category_product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_offer_product_category`
--

DROP TABLE IF EXISTS `oc_offer_product_category`;
CREATE TABLE `oc_offer_product_category` (
  `date_added` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_end` date NOT NULL DEFAULT '0000-00-00',
  `date_start` date NOT NULL DEFAULT '0000-00-00',
  `category_two` int(11) NOT NULL,
  `product_one` int(11) NOT NULL,
  `logged` tinyint(1) NOT NULL,
  `discount` decimal(15,4) NOT NULL,
  `type` char(1) NOT NULL,
  `name` varchar(128) NOT NULL,
  `offer_product_category_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`offer_product_category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_offer_product_product`
--

DROP TABLE IF EXISTS `oc_offer_product_product`;
CREATE TABLE `oc_offer_product_product` (
  `date_added` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_end` date NOT NULL DEFAULT '0000-00-00',
  `date_start` date NOT NULL DEFAULT '0000-00-00',
  `product_two` int(11) NOT NULL,
  `product_one` int(11) NOT NULL,
  `logged` tinyint(1) NOT NULL,
  `discount` decimal(15,4) NOT NULL,
  `type` char(1) NOT NULL,
  `name` varchar(128) NOT NULL,
  `offer_product_product_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`offer_product_product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_option`
--

DROP TABLE IF EXISTS `oc_option`;
CREATE TABLE `oc_option` (
  `sort_order` int(3) NOT NULL,
  `type` varchar(32) NOT NULL,
  `option_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`option_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_option_description`
--

DROP TABLE IF EXISTS `oc_option_description`;
CREATE TABLE `oc_option_description` (
  `name` varchar(128) NOT NULL,
  `language_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  PRIMARY KEY (`option_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_option_value`
--

DROP TABLE IF EXISTS `oc_option_value`;
CREATE TABLE `oc_option_value` (
  `sort_order` int(3) NOT NULL,
  `image` varchar(255) NOT NULL,
  `option_id` int(11) NOT NULL,
  `option_value_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`option_value_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_option_value_description`
--

DROP TABLE IF EXISTS `oc_option_value_description`;
CREATE TABLE `oc_option_value_description` (
  `name` varchar(128) NOT NULL,
  `option_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `option_value_id` int(11) NOT NULL,
  PRIMARY KEY (`option_value_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_order`
--

DROP TABLE IF EXISTS `oc_order`;
CREATE TABLE `oc_order` (
  `date_modified` datetime NOT NULL,
  `date_added` datetime NOT NULL,
  `accept_language` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `forwarded_ip` varchar(32) NOT NULL,
  `ip` varchar(32) NOT NULL,
  `currency_value` decimal(15,8) NOT NULL DEFAULT '1.00000000',
  `currency_code` varchar(3) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `commission` decimal(15,4) NOT NULL,
  `affiliate_id` int(11) NOT NULL,
  `order_status_id` int(11) NOT NULL DEFAULT '0',
  `total` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `comment` text CHARACTER SET utf8 NOT NULL,
  `shipping_code` varchar(128) NOT NULL,
  `shipping_method` varchar(128) NOT NULL,
  `shipping_address_format` text CHARACTER SET utf8 NOT NULL,
  `shipping_zone_id` int(11) NOT NULL,
  `shipping_zone` varchar(128) NOT NULL,
  `shipping_country_id` int(11) NOT NULL,
  `shipping_country` varchar(128) NOT NULL,
  `shipping_postcode` varchar(10) NOT NULL,
  `shipping_city` varchar(128) NOT NULL,
  `shipping_address_2` varchar(128) NOT NULL,
  `shipping_address_1` varchar(128) NOT NULL,
  `shipping_company` varchar(32) NOT NULL,
  `shipping_lastname` varchar(32) NOT NULL,
  `shipping_firstname` varchar(32) NOT NULL,
  `payment_code` varchar(128) NOT NULL,
  `payment_method` varchar(128) NOT NULL,
  `payment_address_format` text CHARACTER SET utf8 NOT NULL,
  `payment_zone_id` int(11) NOT NULL,
  `payment_zone` varchar(128) NOT NULL,
  `payment_country_id` int(11) NOT NULL,
  `payment_country` varchar(128) NOT NULL,
  `payment_postcode` varchar(10) NOT NULL,
  `payment_city` varchar(128) NOT NULL,
  `payment_address_2` varchar(128) NOT NULL,
  `payment_address_1` varchar(128) NOT NULL,
  `payment_tax_id` varchar(32) NOT NULL,
  `payment_company_id` varchar(32) NOT NULL,
  `payment_company` varchar(32) NOT NULL,
  `payment_lastname` varchar(32) NOT NULL,
  `payment_firstname` varchar(32) NOT NULL,
  `fax` varchar(32) NOT NULL,
  `telephone` varchar(32) NOT NULL,
  `email` varchar(96) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `customer_group_id` int(11) NOT NULL DEFAULT '0',
  `customer_id` int(11) NOT NULL DEFAULT '0',
  `store_url` varchar(255) NOT NULL,
  `store_name` varchar(64) NOT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `invoice_prefix` varchar(32) NOT NULL,
  `invoice_no` int(11) NOT NULL DEFAULT '0',
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_order_download`
--

DROP TABLE IF EXISTS `oc_order_download`;
CREATE TABLE `oc_order_download` (
  `remaining` int(3) NOT NULL DEFAULT '0',
  `mask` varchar(128) NOT NULL,
  `filename` varchar(128) NOT NULL,
  `name` varchar(64) NOT NULL,
  `order_product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_download_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`order_download_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_order_history`
--

DROP TABLE IF EXISTS `oc_order_history`;
CREATE TABLE `oc_order_history` (
  `date_added` datetime NOT NULL,
  `comment` text CHARACTER SET utf8 NOT NULL,
  `notify` tinyint(1) NOT NULL DEFAULT '0',
  `order_status_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_history_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`order_history_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_order_option`
--

DROP TABLE IF EXISTS `oc_order_option`;
CREATE TABLE `oc_order_option` (
  `type` varchar(32) NOT NULL,
  `value` text CHARACTER SET utf8 NOT NULL,
  `name` varchar(255) NOT NULL,
  `product_option_value_id` int(11) NOT NULL DEFAULT '0',
  `product_option_id` int(11) NOT NULL,
  `order_product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_option_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`order_option_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_order_product`
--

DROP TABLE IF EXISTS `oc_order_product`;
CREATE TABLE `oc_order_product` (
  `backordered` varchar(255) NOT NULL,
  `picked` tinyint(1) NOT NULL,
  `reward` int(8) NOT NULL,
  `tax` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `total` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `cost` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `quantity` int(4) NOT NULL,
  `model` varchar(64) NOT NULL,
  `name` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_product_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`order_product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_order_recurring`
--

DROP TABLE IF EXISTS `oc_order_recurring`;
CREATE TABLE `oc_order_recurring` (
  `profile_reference` varchar(255) NOT NULL,
  `trial_price` decimal(10,4) NOT NULL,
  `trial_duration` smallint(6) NOT NULL,
  `trial_cycle` smallint(6) NOT NULL,
  `trial_frequency` varchar(25) NOT NULL,
  `trial` tinyint(1) NOT NULL,
  `recurring_price` decimal(10,4) NOT NULL,
  `recurring_duration` smallint(6) NOT NULL,
  `recurring_cycle` smallint(6) NOT NULL,
  `recurring_frequency` varchar(25) NOT NULL,
  `profile_description` varchar(255) NOT NULL,
  `profile_name` varchar(255) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created` datetime NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_recurring_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`order_recurring_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_order_recurring_transaction`
--

DROP TABLE IF EXISTS `oc_order_recurring_transaction`;
CREATE TABLE `oc_order_recurring_transaction` (
  `type` varchar(255) NOT NULL,
  `amount` decimal(10,4) NOT NULL,
  `created` datetime NOT NULL,
  `order_recurring_id` int(11) NOT NULL,
  `order_recurring_transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`order_recurring_transaction_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_order_status`
--

DROP TABLE IF EXISTS `oc_order_status`;
CREATE TABLE `oc_order_status` (
  `name` varchar(32) NOT NULL,
  `language_id` int(11) NOT NULL,
  `order_status_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`order_status_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_order_total`
--

DROP TABLE IF EXISTS `oc_order_total`;
CREATE TABLE `oc_order_total` (
  `sort_order` int(3) NOT NULL,
  `value` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `text` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `code` varchar(32) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_total_id` int(10) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`order_total_id`),
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_order_voucher`
--

DROP TABLE IF EXISTS `oc_order_voucher`;
CREATE TABLE `oc_order_voucher` (
  `amount` decimal(15,4) NOT NULL,
  `message` text CHARACTER SET utf8 NOT NULL,
  `voucher_theme_id` int(11) NOT NULL,
  `to_email` varchar(96) NOT NULL,
  `to_name` varchar(64) NOT NULL,
  `from_email` varchar(96) NOT NULL,
  `from_name` varchar(64) NOT NULL,
  `code` varchar(10) NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `voucher_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_voucher_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`order_voucher_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------
--
-- Table structure for table `oc_palette`
--

DROP TABLE IF EXISTS `oc_palette`;
CREATE TABLE `oc_palette` (
  `name` varchar(64) NOT NULL,
  `palette_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`palette_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_palette_color`
--

DROP TABLE IF EXISTS `oc_palette_color`;
CREATE TABLE `oc_palette_color` (
  `color` varchar(6) NOT NULL,
  `palette_id` int(11) NOT NULL,
  `palette_color_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`palette_color_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_palette_color_description`
--

DROP TABLE IF EXISTS `oc_palette_color_description`;
CREATE TABLE `oc_palette_color_description` (
  `title` varchar(64) NOT NULL,
  `palette_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `palette_color_id` int(11) NOT NULL,
  PRIMARY KEY (`palette_color_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_payment_image`
--

DROP TABLE IF EXISTS `oc_payment_image`;
CREATE TABLE `oc_payment_image` (
  `status` tinyint(1) NOT NULL,
  `image` varchar(255) NOT NULL,
  `payment` varchar(64) NOT NULL,
  `name` varchar(128) NOT NULL,
  `payment_image_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`payment_image_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_product`
--

DROP TABLE IF EXISTS `oc_product`;
CREATE TABLE `oc_product` (
  `viewed` int(8) NOT NULL DEFAULT '0',
  `date_modified` datetime NOT NULL,
  `date_added` datetime NOT NULL,
  `points` int(8) NOT NULL DEFAULT '0',
  `manufacturer_id` int(11) NOT NULL,
  `weight_class_id` int(11) NOT NULL DEFAULT '0',
  `weight` decimal(15,8) NOT NULL DEFAULT '0.00000000',
  `length_class_id` int(11) NOT NULL DEFAULT '0',
  `height` decimal(15,8) NOT NULL DEFAULT '0.00000000',
  `width` decimal(15,8) NOT NULL DEFAULT '0.00000000',
  `length` decimal(15,8) NOT NULL DEFAULT '0.00000000',
  `location` varchar(128) NOT NULL,
  `mpn` varchar(64) NOT NULL,
  `isbn` varchar(13) NOT NULL,
  `jan` varchar(13) NOT NULL,
  `ean` varchar(14) NOT NULL,
  `upc` varchar(12) NOT NULL,
  `sku` varchar(64) NOT NULL,
  `shipping` tinyint(1) NOT NULL DEFAULT '1',
  `stock_status_id` int(11) NOT NULL,
  `subtract` tinyint(1) NOT NULL DEFAULT '1',
  `minimum` int(11) NOT NULL DEFAULT '1',
  `quantity` int(4) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `palette_id` int(11) NOT NULL,
  `date_available` date NOT NULL,
  `tax_class_id` int(11) NOT NULL,
  `age_minimum` int(2) NOT NULL,
  `quote` tinyint(1) NOT NULL DEFAULT '0',
  `cost` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `image` varchar(255) DEFAULT NULL,
  `model` varchar(64) NOT NULL,
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_product_attribute`
--

DROP TABLE IF EXISTS `oc_product_attribute`;
CREATE TABLE `oc_product_attribute` (
  `text` text NOT NULL,
  `language_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`attribute_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_product_color`
--

DROP TABLE IF EXISTS `oc_product_color`;
CREATE TABLE `oc_product_color` (
  `palette_color_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_color_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`product_color_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_product_description`
--

DROP TABLE IF EXISTS `oc_product_description`;
CREATE TABLE `oc_product_description` (
  `tag` text CHARACTER SET utf8 NOT NULL,
  `meta_keyword` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `name` varchar(255) NOT NULL,
  `language_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`language_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_product_discount`
--

DROP TABLE IF EXISTS `oc_product_discount`;
CREATE TABLE `oc_product_discount` (
  `date_end` date NOT NULL DEFAULT '0000-00-00',
  `date_start` date NOT NULL DEFAULT '0000-00-00',
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `priority` int(5) NOT NULL DEFAULT '1',
  `quantity` int(4) NOT NULL DEFAULT '0',
  `customer_group_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_discount_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`product_discount_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_product_filter`
--

DROP TABLE IF EXISTS `oc_product_filter`;
CREATE TABLE `oc_product_filter` (
  `filter_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`filter_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_product_image`
--

DROP TABLE IF EXISTS `oc_product_image`;
CREATE TABLE `oc_product_image` (
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `palette_color_id` int(11) NOT NULL DEFAULT '0',
  `image` varchar(255) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `product_image_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`product_image_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_product_option`
--

DROP TABLE IF EXISTS `oc_product_option`;
CREATE TABLE `oc_product_option` (
  `required` tinyint(1) NOT NULL,
  `option_value` text CHARACTER SET utf8 NOT NULL,
  `option_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_option_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`product_option_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_product_option_value`
--

DROP TABLE IF EXISTS `oc_product_option_value`;
CREATE TABLE `oc_product_option_value` (
  `weight_prefix` varchar(1) NOT NULL,
  `weight` decimal(15,8) NOT NULL,
  `points_prefix` varchar(1) NOT NULL,
  `points` int(8) NOT NULL,
  `price_prefix` varchar(1) NOT NULL,
  `price` decimal(15,4) NOT NULL,
  `subtract` tinyint(1) NOT NULL,
  `quantity` int(3) NOT NULL,
  `option_value_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_option_id` int(11) NOT NULL,
  `product_option_value_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`product_option_value_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_product_profile`
--

DROP TABLE IF EXISTS `oc_product_profile`;
CREATE TABLE `oc_product_profile` (
  `customer_group_id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`profile_id`,`customer_group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_product_recurring`
--

DROP TABLE IF EXISTS `oc_product_recurring`;
CREATE TABLE `oc_product_recurring` (
  `store_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_product_related`
--

DROP TABLE IF EXISTS `oc_product_related`;
CREATE TABLE `oc_product_related` (
  `related_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`related_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_product_reward`
--

DROP TABLE IF EXISTS `oc_product_reward`;
CREATE TABLE `oc_product_reward` (
  `points` int(8) NOT NULL DEFAULT '0',
  `customer_group_id` int(11) NOT NULL DEFAULT '0',
  `product_id` int(11) NOT NULL DEFAULT '0',
  `product_reward_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`product_reward_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_product_special`
--

DROP TABLE IF EXISTS `oc_product_special`;
CREATE TABLE `oc_product_special` (
  `date_end` date NOT NULL DEFAULT '0000-00-00',
  `date_start` date NOT NULL DEFAULT '0000-00-00',
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `priority` int(5) NOT NULL DEFAULT '1',
  `customer_group_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_special_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`product_special_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_product_tag`
--

DROP TABLE IF EXISTS `oc_product_tag`;
CREATE TABLE `oc_product_tag` (
  `tag` varchar(64) NOT NULL,
  `language_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_tag_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`product_tag_id`),
  KEY `product_id` (`product_id`),
  KEY `language_id` (`language_id`),
  KEY `tag` (`tag`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_product_to_category`
--

DROP TABLE IF EXISTS `oc_product_to_category`;
CREATE TABLE `oc_product_to_category` (
  `category_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`category_id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_product_to_download`
--

DROP TABLE IF EXISTS `oc_product_to_download`;
CREATE TABLE `oc_product_to_download` (
  `download_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`download_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_product_to_layout`
--

DROP TABLE IF EXISTS `oc_product_to_layout`;
CREATE TABLE `oc_product_to_layout` (
  `layout_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_product_to_location`
--

DROP TABLE IF EXISTS `oc_product_to_location`;
CREATE TABLE `oc_product_to_location` (
  `location_id` int(11) NOT NULL DEFAULT '0',
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`location_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_product_to_store`
--

DROP TABLE IF EXISTS `oc_product_to_store`;
CREATE TABLE `oc_product_to_store` (
  `store_id` int(11) NOT NULL DEFAULT '0',
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_profile`
--

DROP TABLE IF EXISTS `oc_profile`;
CREATE TABLE `oc_profile` (
  `trial_cycle` int(10) unsigned NOT NULL,
  `trial_duration` int(10) unsigned NOT NULL,
  `trial_frequency` enum('day','week','semi_month','month','year') NOT NULL,
  `trial_price` decimal(10,4) NOT NULL,
  `trial_status` tinyint(4) NOT NULL,
  `cycle` int(10) unsigned NOT NULL,
  `duration` int(10) unsigned NOT NULL,
  `frequency` enum('day','week','semi_month','month','year') NOT NULL,
  `price` decimal(10,4) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`profile_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_profile_description`
--

DROP TABLE IF EXISTS `oc_profile_description`;
CREATE TABLE `oc_profile_description` (
  `name` varchar(255) NOT NULL,
  `language_id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  PRIMARY KEY (`profile_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_return`
--

DROP TABLE IF EXISTS `oc_return`;
CREATE TABLE `oc_return` (
  `date_modified` datetime NOT NULL,
  `date_added` datetime NOT NULL,
  `date_ordered` date NOT NULL,
  `comment` text CHARACTER SET utf8,
  `return_status_id` int(11) NOT NULL,
  `return_action_id` int(11) NOT NULL,
  `return_reason_id` int(11) NOT NULL,
  `opened` tinyint(1) NOT NULL,
  `quantity` int(4) NOT NULL,
  `model` varchar(64) NOT NULL,
  `product` varchar(255) NOT NULL,
  `telephone` varchar(32) NOT NULL,
  `email` varchar(96) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `return_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`return_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_return_action`
--

DROP TABLE IF EXISTS `oc_return_action`;
CREATE TABLE `oc_return_action` (
  `name` varchar(64) NOT NULL,
  `language_id` int(11) NOT NULL DEFAULT '0',
  `return_action_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`return_action_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_return_history`
--

DROP TABLE IF EXISTS `oc_return_history`;
CREATE TABLE `oc_return_history` (
  `date_added` datetime NOT NULL,
  `comment` text CHARACTER SET utf8 NOT NULL,
  `notify` tinyint(1) NOT NULL,
  `return_status_id` int(11) NOT NULL,
  `return_id` int(11) NOT NULL,
  `return_history_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`return_history_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_return_reason`
--

DROP TABLE IF EXISTS `oc_return_reason`;
CREATE TABLE `oc_return_reason` (
  `name` varchar(128) NOT NULL,
  `language_id` int(11) NOT NULL DEFAULT '0',
  `return_reason_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`return_reason_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_return_status`
--

DROP TABLE IF EXISTS `oc_return_status`;
CREATE TABLE `oc_return_status` (
  `name` varchar(32) NOT NULL,
  `language_id` int(11) NOT NULL DEFAULT '0',
  `return_status_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`return_status_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_review`
--

DROP TABLE IF EXISTS `oc_review`;
CREATE TABLE `oc_review` (
  `date_modified` datetime NOT NULL,
  `date_added` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `rating` int(1) NOT NULL,
  `text` text CHARACTER SET utf8 NOT NULL,
  `author` varchar(64) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `review_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`review_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_setting`
--

DROP TABLE IF EXISTS `oc_setting`;
CREATE TABLE `oc_setting` (
  `serialized` tinyint(1) NOT NULL,
  `value` text CHARACTER SET utf8 NOT NULL,
  `key` varchar(64) NOT NULL,
  `group` varchar(32) NOT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`setting_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_stock_status`
--

DROP TABLE IF EXISTS `oc_stock_status`;
CREATE TABLE `oc_stock_status` (
  `name` varchar(32) NOT NULL,
  `language_id` int(11) NOT NULL,
  `stock_status_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`stock_status_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_store`
--

DROP TABLE IF EXISTS `oc_store`;
CREATE TABLE `oc_store` (
  `ssl` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `name` varchar(64) NOT NULL,
  `store_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_tax_class`
--

DROP TABLE IF EXISTS `oc_tax_class`;
CREATE TABLE `oc_tax_class` (
  `date_modified` datetime NOT NULL,
  `date_added` datetime NOT NULL,
  `description` varchar(255) NOT NULL,
  `title` varchar(32) NOT NULL,
  `tax_class_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`tax_class_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_tax_rate`
--

DROP TABLE IF EXISTS `oc_tax_rate`;
CREATE TABLE `oc_tax_rate` (
  `date_modified` datetime NOT NULL,
  `date_added` datetime NOT NULL,
  `type` char(1) NOT NULL,
  `rate` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `name` varchar(32) NOT NULL,
  `geo_zone_id` int(11) NOT NULL DEFAULT '0',
  `tax_rate_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`tax_rate_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_tax_rate_to_customer_group`
--

DROP TABLE IF EXISTS `oc_tax_rate_to_customer_group`;
CREATE TABLE `oc_tax_rate_to_customer_group` (
  `customer_group_id` int(11) NOT NULL,
  `tax_rate_id` int(11) NOT NULL,
  PRIMARY KEY (`tax_rate_id`,`customer_group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_tax_rule`
--

DROP TABLE IF EXISTS `oc_tax_rule`;
CREATE TABLE `oc_tax_rule` (
  `priority` int(5) NOT NULL DEFAULT '1',
  `based` varchar(32) NOT NULL,
  `tax_rate_id` int(11) NOT NULL,
  `tax_class_id` int(11) NOT NULL,
  `tax_rule_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`tax_rule_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_upload`
--

DROP TABLE IF EXISTS `oc_upload`;
CREATE TABLE `oc_upload` (
  `date_added` datetime NOT NULL,
  `code` varchar(32) NOT NULL,
  `filename` varchar(128) NOT NULL,
  `name` varchar(64) NOT NULL,
  `upload_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`upload_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_url_alias`
--

DROP TABLE IF EXISTS `oc_url_alias`;
CREATE TABLE `oc_url_alias` (
  `keyword` varchar(255) NOT NULL,
  `query` varchar(255) NOT NULL,
  `url_alias_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`url_alias_id`),
  KEY `query` (`query`),
  KEY `keyword` (`keyword`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_user`
--

DROP TABLE IF EXISTS `oc_user`;
CREATE TABLE `oc_user` (
  `date_added` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `ip` varchar(32) NOT NULL,
  `code` varchar(40) NOT NULL,
  `email` varchar(96) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `salt` varchar(9) NOT NULL,
  `password` varchar(40) NOT NULL,
  `username` varchar(20) NOT NULL,
  `user_group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_user_group`
--

DROP TABLE IF EXISTS `oc_user_group`;
CREATE TABLE `oc_user_group` (
  `permission` text CHARACTER SET utf8 NOT NULL,
  `name` varchar(64) NOT NULL,
  `user_group_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`user_group_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_voucher`
--

DROP TABLE IF EXISTS `oc_voucher`;
CREATE TABLE `oc_voucher` (
  `date_added` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `message` text CHARACTER SET utf8 NOT NULL,
  `voucher_theme_id` int(11) NOT NULL,
  `to_email` varchar(96) NOT NULL,
  `to_name` varchar(64) NOT NULL,
  `from_email` varchar(96) NOT NULL,
  `from_name` varchar(64) NOT NULL,
  `code` varchar(10) NOT NULL,
  `order_id` int(11) NOT NULL,
  `voucher_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`voucher_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_voucher_history`
--

DROP TABLE IF EXISTS `oc_voucher_history`;
CREATE TABLE `oc_voucher_history` (
  `date_added` datetime NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `order_id` int(11) NOT NULL,
  `voucher_id` int(11) NOT NULL,
  `voucher_history_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`voucher_history_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_voucher_theme`
--

DROP TABLE IF EXISTS `oc_voucher_theme`;
CREATE TABLE `oc_voucher_theme` (
  `image` varchar(255) NOT NULL,
  `voucher_theme_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`voucher_theme_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_voucher_theme_description`
--

DROP TABLE IF EXISTS `oc_voucher_theme_description`;
CREATE TABLE `oc_voucher_theme_description` (
  `name` varchar(32) NOT NULL,
  `language_id` int(11) NOT NULL,
  `voucher_theme_id` int(11) NOT NULL,
  PRIMARY KEY (`voucher_theme_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_weight_class`
--

DROP TABLE IF EXISTS `oc_weight_class`;
CREATE TABLE `oc_weight_class` (
  `value` decimal(15,8) NOT NULL DEFAULT '0.00000000',
  `weight_class_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`weight_class_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_weight_class_description`
--

DROP TABLE IF EXISTS `oc_weight_class_description`;
CREATE TABLE `oc_weight_class_description` (
  `unit` varchar(4) NOT NULL,
  `title` varchar(32) NOT NULL,
  `language_id` int(11) NOT NULL,
  `weight_class_id` int(11) NOT NULL,
  PRIMARY KEY (`weight_class_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_zone`
--

DROP TABLE IF EXISTS `oc_zone`;
CREATE TABLE `oc_zone` (
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `name` varchar(128) NOT NULL,
  `code` varchar(32) NOT NULL,
  `country_id` int(11) NOT NULL,
  `zone_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`zone_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_zone_to_geo_zone`
--

DROP TABLE IF EXISTS `oc_zone_to_geo_zone`;
CREATE TABLE `oc_zone_to_geo_zone` (
  `date_modified` datetime NOT NULL,
  `date_added` datetime NOT NULL,
  `geo_zone_id` int(11) NOT NULL,
  `zone_id` int(11) NOT NULL DEFAULT '0',
  `country_id` int(11) NOT NULL,
  `zone_to_geo_zone_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`zone_to_geo_zone_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------
