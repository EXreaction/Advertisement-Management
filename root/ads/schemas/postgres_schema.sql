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
	ad_views INT4 DEFAULT '0' NOT NULL CHECK (ad_views >= 0),
	ad_max_views INT4 DEFAULT '0' NOT NULL CHECK (ad_max_views >= 0),
	ad_priority INT2 DEFAULT '5' NOT NULL,
	ad_enabled INT2 DEFAULT '1' NOT NULL CHECK (ad_enabled >= 0),
	all_forums INT2 DEFAULT '0' NOT NULL CHECK (all_forums >= 0),
	PRIMARY KEY (ad_id)
);


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
	Table: 'phpbb_ads_in_positions'
*/
CREATE TABLE phpbb_ads_in_positions (
	ad_id INT4 DEFAULT '0' NOT NULL CHECK (ad_id >= 0),
	position_id INT4 DEFAULT '0' NOT NULL CHECK (position_id >= 0),
	ad_views INT4 DEFAULT '0' NOT NULL CHECK (ad_views >= 0),
	ad_max_views INT4 DEFAULT '0' NOT NULL CHECK (ad_max_views >= 0),
	ad_priority INT2 DEFAULT '5' NOT NULL,
	ad_enabled INT2 DEFAULT '1' NOT NULL CHECK (ad_enabled >= 0),
	all_forums INT2 DEFAULT '0' NOT NULL CHECK (all_forums >= 0)
);

CREATE INDEX phpbb_ads_in_positions_ad_position ON phpbb_ads_in_positions (ad_id, position_id);
CREATE INDEX phpbb_ads_in_positions_ad_views ON phpbb_ads_in_positions (ad_views);
CREATE INDEX phpbb_ads_in_positions_ad_max_views ON phpbb_ads_in_positions (ad_max_views);
CREATE INDEX phpbb_ads_in_positions_ad_priority ON phpbb_ads_in_positions (ad_priority);
CREATE INDEX phpbb_ads_in_positions_ad_enabled ON phpbb_ads_in_positions (ad_enabled);
CREATE INDEX phpbb_ads_in_positions_all_forums ON phpbb_ads_in_positions (all_forums);

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