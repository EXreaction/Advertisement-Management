#
# $Id$
#

BEGIN TRANSACTION;

# Table: 'phpbb_ads'
CREATE TABLE phpbb_ads (
	ad_id INTEGER PRIMARY KEY NOT NULL ,
	ad_name varchar(255) NOT NULL DEFAULT '',
	ad_code text(65535) NOT NULL DEFAULT '',
	ad_views INTEGER UNSIGNED NOT NULL DEFAULT '0',
	ad_priority tinyint(1) NOT NULL DEFAULT '5',
	ad_enabled INTEGER UNSIGNED NOT NULL DEFAULT '1',
	all_forums INTEGER UNSIGNED NOT NULL DEFAULT '0'
);


# Table: 'phpbb_ads_forums'
CREATE TABLE phpbb_ads_forums (
	ad_id INTEGER UNSIGNED NOT NULL DEFAULT '0',
	forum_id INTEGER UNSIGNED NOT NULL DEFAULT '0'
);

CREATE INDEX phpbb_ads_forums_ad_forum ON phpbb_ads_forums (ad_id, forum_id);

# Table: 'phpbb_ads_groups'
CREATE TABLE phpbb_ads_groups (
	ad_id INTEGER UNSIGNED NOT NULL DEFAULT '0',
	group_id INTEGER UNSIGNED NOT NULL DEFAULT '0'
);

CREATE INDEX phpbb_ads_groups_ad_group ON phpbb_ads_groups (ad_id, group_id);

# Table: 'phpbb_ads_in_positions'
CREATE TABLE phpbb_ads_in_positions (
	ad_id INTEGER UNSIGNED NOT NULL DEFAULT '0',
	position_id INTEGER UNSIGNED NOT NULL DEFAULT '0',
	ad_priority tinyint(1) NOT NULL DEFAULT '5',
	ad_enabled INTEGER UNSIGNED NOT NULL DEFAULT '1',
	all_forums INTEGER UNSIGNED NOT NULL DEFAULT '0'
);

CREATE INDEX phpbb_ads_in_positions_ad_position ON phpbb_ads_in_positions (ad_id, position_id);
CREATE INDEX phpbb_ads_in_positions_ad_priority ON phpbb_ads_in_positions (ad_priority);
CREATE INDEX phpbb_ads_in_positions_ad_enabled ON phpbb_ads_in_positions (ad_enabled);
CREATE INDEX phpbb_ads_in_positions_all_forums ON phpbb_ads_in_positions (all_forums);

# Table: 'phpbb_ads_positions'
CREATE TABLE phpbb_ads_positions (
	position_id INTEGER PRIMARY KEY NOT NULL ,
	lang_key text(65535) NOT NULL DEFAULT ''
);



COMMIT;