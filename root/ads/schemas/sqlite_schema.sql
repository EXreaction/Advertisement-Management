#
# $Id$
#

BEGIN TRANSACTION;

# Table: 'phpbb_ads'
CREATE TABLE phpbb_ads (
	ad_id INTEGER PRIMARY KEY NOT NULL ,
	ad_name varchar(255) NOT NULL DEFAULT '',
	ad_code text(65535) NOT NULL DEFAULT '',
	ad_position INTEGER UNSIGNED NOT NULL DEFAULT '0',
	ad_views INTEGER UNSIGNED NOT NULL DEFAULT '0',
	ad_max_views INTEGER UNSIGNED NOT NULL DEFAULT '0',
	all_forums INTEGER UNSIGNED NOT NULL DEFAULT '0'
);

CREATE INDEX phpbb_ads_ad_position ON phpbb_ads (ad_position);
CREATE INDEX phpbb_ads_ad_views ON phpbb_ads (ad_views);
CREATE INDEX phpbb_ads_ad_max_views ON phpbb_ads (ad_max_views);
CREATE INDEX phpbb_ads_all_forums ON phpbb_ads (all_forums);

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

# Table: 'phpbb_ads_positions'
CREATE TABLE phpbb_ads_positions (
	position_id INTEGER PRIMARY KEY NOT NULL ,
	lang_key text(65535) NOT NULL DEFAULT ''
);



COMMIT;