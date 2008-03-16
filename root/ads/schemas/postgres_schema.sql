/*

 $Id$

*/

BEGIN;


/*
	Table: 'phpbb_ads'
*/
CREATE SEQUENCE phpbb_ads_seq;

CREATE TABLE phpbb_ads (
	ad_id INT4 DEFAULT nextval('phpbb_ads_seq'),
	ad_name varchar(255) DEFAULT '' NOT NULL,
	ad_code varchar(4000) DEFAULT '' NOT NULL,
	ad_position INT4 DEFAULT '0' NOT NULL CHECK (ad_position >= 0),
	ad_views INT4 DEFAULT '0' NOT NULL CHECK (ad_views >= 0),
	ad_max_views INT4 DEFAULT '0' NOT NULL CHECK (ad_max_views >= 0),
	all_forums INT2 DEFAULT '0' NOT NULL CHECK (all_forums >= 0),
	PRIMARY KEY (ad_id)
);

CREATE INDEX phpbb_ads_ad_position ON phpbb_ads (ad_position);
CREATE INDEX phpbb_ads_ad_views ON phpbb_ads (ad_views);
CREATE INDEX phpbb_ads_ad_max_views ON phpbb_ads (ad_max_views);
CREATE INDEX phpbb_ads_all_forums ON phpbb_ads (all_forums);

/*
	Table: 'phpbb_ads_forums'
*/
CREATE TABLE phpbb_ads_forums (
	ad_id INT4 DEFAULT '0' NOT NULL CHECK (ad_id >= 0),
	forum_id INT4 DEFAULT '0' NOT NULL CHECK (forum_id >= 0)
);

CREATE INDEX phpbb_ads_forums_ad_forum ON phpbb_ads_forums (ad_id, forum_id);

/*
	Table: 'phpbb_ads_groups'
*/
CREATE TABLE phpbb_ads_groups (
	ad_id INT4 DEFAULT '0' NOT NULL CHECK (ad_id >= 0),
	group_id INT4 DEFAULT '0' NOT NULL CHECK (group_id >= 0)
);

CREATE INDEX phpbb_ads_groups_ad_group ON phpbb_ads_groups (ad_id, group_id);

/*
	Table: 'phpbb_ads_positions'
*/
CREATE SEQUENCE phpbb_ads_positions_seq;

CREATE TABLE phpbb_ads_positions (
	position_id INT4 DEFAULT nextval('phpbb_ads_positions_seq'),
	lang_key varchar(4000) DEFAULT '' NOT NULL,
	PRIMARY KEY (position_id)
);



COMMIT;