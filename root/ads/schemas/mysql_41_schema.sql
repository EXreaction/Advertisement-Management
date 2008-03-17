#
# $Id$
#

# Table: 'phpbb_ads'
CREATE TABLE phpbb_ads (
	ad_id mediumint(8) UNSIGNED NOT NULL auto_increment,
	ad_name varchar(255) DEFAULT '' NOT NULL,
	ad_code text NOT NULL,
	ad_views mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,
	ad_max_views mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,
	ad_priority tinyint(1) DEFAULT '5' NOT NULL,
	ad_enabled tinyint(1) UNSIGNED DEFAULT '1' NOT NULL,
	all_forums tinyint(1) UNSIGNED DEFAULT '0' NOT NULL,
	PRIMARY KEY (ad_id)
) CHARACTER SET `utf8` COLLATE `utf8_bin`;


# Table: 'phpbb_ads_forums'
CREATE TABLE phpbb_ads_forums (
	ad_id mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,
	forum_id mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,
	KEY ad_forum (ad_id, forum_id)
) CHARACTER SET `utf8` COLLATE `utf8_bin`;


# Table: 'phpbb_ads_groups'
CREATE TABLE phpbb_ads_groups (
	ad_id mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,
	group_id mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,
	KEY ad_group (ad_id, group_id)
) CHARACTER SET `utf8` COLLATE `utf8_bin`;


# Table: 'phpbb_ads_in_positions'
CREATE TABLE phpbb_ads_in_positions (
	ad_id mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,
	position_id mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,
	ad_views mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,
	ad_max_views mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,
	ad_priority tinyint(1) DEFAULT '5' NOT NULL,
	ad_enabled tinyint(1) UNSIGNED DEFAULT '1' NOT NULL,
	all_forums tinyint(1) UNSIGNED DEFAULT '0' NOT NULL,
	KEY ad_position (ad_id, position_id),
	KEY ad_views (ad_views),
	KEY ad_max_views (ad_max_views),
	KEY ad_priority (ad_priority),
	KEY ad_enabled (ad_enabled),
	KEY all_forums (all_forums)
) CHARACTER SET `utf8` COLLATE `utf8_bin`;


# Table: 'phpbb_ads_positions'
CREATE TABLE phpbb_ads_positions (
	position_id mediumint(8) UNSIGNED NOT NULL auto_increment,
	lang_key text NOT NULL,
	PRIMARY KEY (position_id)
) CHARACTER SET `utf8` COLLATE `utf8_bin`;


