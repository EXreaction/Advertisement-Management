#
# $Id$
#


# Table: 'phpbb_ads'
CREATE TABLE phpbb_ads (
	ad_id INTEGER NOT NULL,
	ad_name VARCHAR(255) CHARACTER SET NONE DEFAULT '' NOT NULL,
	ad_code BLOB SUB_TYPE TEXT CHARACTER SET UTF8 DEFAULT '' NOT NULL,
	ad_position INTEGER DEFAULT 0 NOT NULL,
	ad_views INTEGER DEFAULT 0 NOT NULL,
	ad_max_views INTEGER DEFAULT 0 NOT NULL,
	ad_priority INTEGER DEFAULT 5 NOT NULL,
	all_forums INTEGER DEFAULT 0 NOT NULL
);;

ALTER TABLE phpbb_ads ADD PRIMARY KEY (ad_id);;

CREATE INDEX phpbb_ads_ad_position ON phpbb_ads(ad_position);;
CREATE INDEX phpbb_ads_ad_views ON phpbb_ads(ad_views);;
CREATE INDEX phpbb_ads_ad_max_views ON phpbb_ads(ad_max_views);;
CREATE INDEX phpbb_ads_ad_priority ON phpbb_ads(ad_priority);;
CREATE INDEX phpbb_ads_all_forums ON phpbb_ads(all_forums);;

CREATE GENERATOR phpbb_ads_gen;;
SET GENERATOR phpbb_ads_gen TO 0;;

CREATE TRIGGER t_phpbb_ads FOR phpbb_ads
BEFORE INSERT
AS
BEGIN
	NEW.ad_id = GEN_ID(phpbb_ads_gen, 1);
END;;


# Table: 'phpbb_ads_forums'
CREATE TABLE phpbb_ads_forums (
	ad_id INTEGER DEFAULT 0 NOT NULL,
	forum_id INTEGER DEFAULT 0 NOT NULL
);;

CREATE INDEX phpbb_ads_forums_ad_forum ON phpbb_ads_forums(ad_id, forum_id);;

# Table: 'phpbb_ads_groups'
CREATE TABLE phpbb_ads_groups (
	ad_id INTEGER DEFAULT 0 NOT NULL,
	group_id INTEGER DEFAULT 0 NOT NULL
);;

CREATE INDEX phpbb_ads_groups_ad_group ON phpbb_ads_groups(ad_id, group_id);;

# Table: 'phpbb_ads_positions'
CREATE TABLE phpbb_ads_positions (
	position_id INTEGER NOT NULL,
	lang_key BLOB SUB_TYPE TEXT CHARACTER SET UTF8 DEFAULT '' NOT NULL
);;

ALTER TABLE phpbb_ads_positions ADD PRIMARY KEY (position_id);;


CREATE GENERATOR phpbb_ads_positions_gen;;
SET GENERATOR phpbb_ads_positions_gen TO 0;;

CREATE TRIGGER t_phpbb_ads_positions FOR phpbb_ads_positions
BEFORE INSERT
AS
BEGIN
	NEW.position_id = GEN_ID(phpbb_ads_positions_gen, 1);
END;;


