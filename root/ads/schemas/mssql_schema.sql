/*

 $Id$

*/

BEGIN TRANSACTION
GO

/*
	Table: 'phpbb_ads'
*/
CREATE TABLE [phpbb_ads] (
	[ad_id] [int] IDENTITY (1, 1) NOT NULL ,
	[ad_name] [varchar] (255) DEFAULT ('') NOT NULL ,
	[ad_code] [varchar] (4000) DEFAULT ('') NOT NULL ,
	[ad_views] [int] DEFAULT (0) NOT NULL ,
	[ad_max_views] [int] DEFAULT (0) NOT NULL ,
	[ad_priority] [int] DEFAULT (5) NOT NULL ,
	[ad_enabled] [int] DEFAULT (1) NOT NULL ,
	[all_forums] [int] DEFAULT (0) NOT NULL 
) ON [PRIMARY]
GO

ALTER TABLE [phpbb_ads] WITH NOCHECK ADD 
	CONSTRAINT [PK_phpbb_ads] PRIMARY KEY  CLUSTERED 
	(
		[ad_id]
	)  ON [PRIMARY] 
GO

CREATE  INDEX [ad_views] ON [phpbb_ads]([ad_views]) ON [PRIMARY]
GO

CREATE  INDEX [ad_max_views] ON [phpbb_ads]([ad_max_views]) ON [PRIMARY]
GO

CREATE  INDEX [ad_priority] ON [phpbb_ads]([ad_priority]) ON [PRIMARY]
GO

CREATE  INDEX [ad_enabled] ON [phpbb_ads]([ad_enabled]) ON [PRIMARY]
GO

CREATE  INDEX [all_forums] ON [phpbb_ads]([all_forums]) ON [PRIMARY]
GO


/*
	Table: 'phpbb_ads_forums'
*/
CREATE TABLE [phpbb_ads_forums] (
	[ad_id] [int] DEFAULT (0) NOT NULL ,
	[forum_id] [int] DEFAULT (0) NOT NULL 
) ON [PRIMARY]
GO

CREATE  INDEX [ad_forum] ON [phpbb_ads_forums]([ad_id], [forum_id]) ON [PRIMARY]
GO


/*
	Table: 'phpbb_ads_groups'
*/
CREATE TABLE [phpbb_ads_groups] (
	[ad_id] [int] DEFAULT (0) NOT NULL ,
	[group_id] [int] DEFAULT (0) NOT NULL 
) ON [PRIMARY]
GO

CREATE  INDEX [ad_group] ON [phpbb_ads_groups]([ad_id], [group_id]) ON [PRIMARY]
GO


/*
	Table: 'phpbb_ads_in_positions'
*/
CREATE TABLE [phpbb_ads_in_positions] (
	[ad_id] [int] DEFAULT (0) NOT NULL ,
	[position_id] [int] DEFAULT (0) NOT NULL ,
	[ad_views] [int] DEFAULT (0) NOT NULL ,
	[ad_max_views] [int] DEFAULT (0) NOT NULL ,
	[ad_priority] [int] DEFAULT (5) NOT NULL ,
	[ad_enabled] [int] DEFAULT (1) NOT NULL ,
	[all_forums] [int] DEFAULT (0) NOT NULL 
) ON [PRIMARY]
GO

CREATE  INDEX [ad_position] ON [phpbb_ads_in_positions]([ad_id], [position_id]) ON [PRIMARY]
GO

CREATE  INDEX [ad_views] ON [phpbb_ads_in_positions]([ad_views]) ON [PRIMARY]
GO

CREATE  INDEX [ad_max_views] ON [phpbb_ads_in_positions]([ad_max_views]) ON [PRIMARY]
GO

CREATE  INDEX [ad_priority] ON [phpbb_ads_in_positions]([ad_priority]) ON [PRIMARY]
GO

CREATE  INDEX [ad_enabled] ON [phpbb_ads_in_positions]([ad_enabled]) ON [PRIMARY]
GO

CREATE  INDEX [all_forums] ON [phpbb_ads_in_positions]([all_forums]) ON [PRIMARY]
GO


/*
	Table: 'phpbb_ads_positions'
*/
CREATE TABLE [phpbb_ads_positions] (
	[position_id] [int] IDENTITY (1, 1) NOT NULL ,
	[lang_key] [varchar] (4000) DEFAULT ('') NOT NULL 
) ON [PRIMARY]
GO

ALTER TABLE [phpbb_ads_positions] WITH NOCHECK ADD 
	CONSTRAINT [PK_phpbb_ads_positions] PRIMARY KEY  CLUSTERED 
	(
		[position_id]
	)  ON [PRIMARY] 
GO



COMMIT
GO

