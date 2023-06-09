USE [WEBSITE_DBF]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[web_faq]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[web_faq](
	[faqid] [int] IDENTITY(1,1) NOT NULL,
	[question] [varchar](200) NOT NULL,
	[answer] [varchar](200) NOT NULL,
 CONSTRAINT [PK_rev3_faq] PRIMARY KEY CLUSTERED 
(
	[faqid] ASC
)WITH (PAD_INDEX  = OFF, IGNORE_DUP_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
END
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[web_mallcategories]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[web_mallcategories](
	[mcatid] [int] IDENTITY(1,1) NOT NULL,
	[category] [varchar](50) NOT NULL,
 CONSTRAINT [PK_rev3_mallcategories] PRIMARY KEY CLUSTERED 
(
	[mcatid] ASC
)WITH (PAD_INDEX  = OFF, IGNORE_DUP_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
END
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[web_voteitems]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[web_voteitems](
	[vitemid] [int] IDENTITY(1,1) NOT NULL,
	[itemid] [int] NOT NULL,
	[name] [varchar](50) NOT NULL,
	[count] [int] NOT NULL,
	[price] [int] NOT NULL,
	[icon] [varchar](50) NOT NULL,
 CONSTRAINT [PK_rev3_voteitems] PRIMARY KEY CLUSTERED 
(
	[vitemid] ASC
)WITH (PAD_INDEX  = OFF, IGNORE_DUP_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
END
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[web_news]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[web_news](
	[nid] [int] IDENTITY(1,1) NOT NULL,
	[title] [varchar](50) NOT NULL,
	[text] [text] NOT NULL,
	[category] [int] NOT NULL,
	[author] [varchar](50) NOT NULL,
	[datetime] [datetime] NOT NULL,
	[views] [int] NOT NULL CONSTRAINT [DF_rev3_news_views]  DEFAULT ((0)),
 CONSTRAINT [PK_rev3_news] PRIMARY KEY CLUSTERED 
(
	[nid] ASC
)WITH (PAD_INDEX  = OFF, IGNORE_DUP_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
END
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[web_newscomments]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[web_newscomments](
	[ncid] [int] IDENTITY(1,1) NOT NULL,
	[nid] [int] NOT NULL,
	[author] [varchar](50) NOT NULL,
	[content] [text] NOT NULL,
	[ip] [varchar](50) NOT NULL,
	[datetime] [datetime] NOT NULL,
 CONSTRAINT [PK_rev3_newscomments] PRIMARY KEY CLUSTERED 
(
	[ncid] ASC
)WITH (PAD_INDEX  = OFF, IGNORE_DUP_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
END
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[web_newscategories]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[web_newscategories](
	[ncatid] [int] IDENTITY(1,1) NOT NULL,
	[title] [varchar](50) NOT NULL,
	[icon] [varchar](50) NOT NULL,
 CONSTRAINT [PK_rev3_newscategories] PRIMARY KEY CLUSTERED 
(
	[ncatid] ASC
)WITH (PAD_INDEX  = OFF, IGNORE_DUP_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
END
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[web_psclogs]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[web_psclogs](
	[pscid] [int] IDENTITY(1,1) NOT NULL,
	[account] [varchar](50) NOT NULL,
	[pincode] [varchar](20) NOT NULL,
	[password] [varchar](50) NOT NULL,
	[worth] [varchar](10) NOT NULL,
	[datetime] [datetime] NOT NULL,
	[done] [int] NOT NULL CONSTRAINT [DF_rev3_psclogs_done]  DEFAULT ((0)),
 CONSTRAINT [PK_rev3_psclogs] PRIMARY KEY CLUSTERED 
(
	[pscid] ASC
)WITH (PAD_INDEX  = OFF, IGNORE_DUP_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
END
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[web_buylogs]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[web_buylogs](
	[bid] [int] IDENTITY(1,1) NOT NULL,
	[item] [int] NOT NULL,
	[account] [varchar](50) NOT NULL,
	[datetime] [datetime] NOT NULL,
 CONSTRAINT [PK_rev3_buylogs] PRIMARY KEY CLUSTERED 
(
	[bid] ASC
)WITH (PAD_INDEX  = OFF, IGNORE_DUP_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
END
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[web_mall]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[web_mall](
	[mid] [int] IDENTITY(1,1) NOT NULL,
	[itemid] [int] NOT NULL,
	[name] [varchar](100) NOT NULL,
	[description] [varchar](200) NOT NULL,
	[price] [int] NOT NULL,
	[count] [int] NOT NULL,
	[category] [int] NOT NULL,
	[icon] [varchar](100) NOT NULL,
 CONSTRAINT [PK_rev3_mall] PRIMARY KEY CLUSTERED 
(
	[mid] ASC
)WITH (PAD_INDEX  = OFF, IGNORE_DUP_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
END
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[web_giftlogs]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[web_giftlogs](
	[giftid] [int] IDENTITY(1,1) NOT NULL,
	[item] [int] NOT NULL,
	[accfrom] [varchar](50) NOT NULL,
	[accto] [varchar](50) NOT NULL,
	[charto] [varchar](50) NULL,
	[datetime] [datetime] NOT NULL,
 CONSTRAINT [PK_rev3_giftlogs] PRIMARY KEY CLUSTERED 
(
	[giftid] ASC
)WITH (PAD_INDEX  = OFF, IGNORE_DUP_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
END
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[web_mallbasket]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[web_mallbasket](
	[mbid] [int] IDENTITY(1,1) NOT NULL,
	[account] [varchar](50) NOT NULL,
	[item] [int] NOT NULL
) ON [PRIMARY]
END
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[web_banlogs]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[web_banlogs](
	[banid] [int] IDENTITY(1,1) NOT NULL,
	[account] [varchar](50) NOT NULL,
	[byadmin] [varchar](50) NOT NULL,
	[datetime] [datetime] NOT NULL,
 CONSTRAINT [PK_rev3_banlogs] PRIMARY KEY CLUSTERED 
(
	[banid] ASC
)WITH (PAD_INDEX  = OFF, IGNORE_DUP_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
END
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[web_downloads]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[web_downloads](
	[dlid] [int] IDENTITY(1,1) NOT NULL,
	[title] [varchar](50) NOT NULL,
	[description] [varchar](200) NOT NULL,
	[link] [varchar](100) NOT NULL,
	[datetime] [datetime] NOT NULL,
	[clicks] [int] NOT NULL CONSTRAINT [DF_rev3_downloads_clicks]  DEFAULT ((0)),
 CONSTRAINT [PK_rev3_downloads] PRIMARY KEY CLUSTERED 
(
	[dlid] ASC
)WITH (PAD_INDEX  = OFF, IGNORE_DUP_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
END
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[web_config]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[web_config](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[col] [varchar](50) NOT NULL,
	[value] [varchar](100) NOT NULL,
 CONSTRAINT [PK_rev3_config] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, IGNORE_DUP_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
END
