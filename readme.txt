## BF4 Server Stats Overview


This page requires the use of a stats database which is created by XpKiller's PRoCon "BF4 Chat, GUID, Stats and Mapstats Logger" Plugin.  If you need help with his plugin, you must seek assistance in XpKiller's plugin thread.

For best compatibility with this code, use the following settings in XpKiller's PRoCon logging plugin:
"Enable Statslogging?" : Yes
"Enable Weaponstats?" : Yes
"Enable Livescoreboard in DB?" : Yes
"tableSuffix" : None
"MapStats ON?" : Yes
"Session ON?" : Yes
"Save Sessiondata to DB?" : Yes
"Log playerdata only (no playerstats)?" : No


## Demo


http://open-web-community.com/bf4stats/player-stats/index.php


## Additional Info


Valid!

http://validator.w3.org/check?uri=http%3A%2F%2Fopen-web-community.com%2Fbf4stats%2Fplayer-stats%2Findex.php&charset=%28detect+automatically%29&doctype=Inline&group=0&user-agent=W3C_Validator%2F1.3+http%3A%2F%2Fvalidator.w3.org%2Fservices


## Installation Steps


Download the following file:

https://github.com/tyger07/BF4-Server-Stats/zipball/master

Extract the files.

You may change the appearance of the page by modifying the stats.css file in the common folder.

Fill in the required parameters before using this code.  You must place the necessary data between the single quotation marks (''). 

Note:  You may not include single quotation marks (') in the following fields.  For instance, you may not call your clan 'Ty_ger07's Clan' as it will create a PHP compilation error.
For example, this would not work:


$clan_name = 'Ty_ger07's Clan'; // your gaming clan or organization name


You must use a PHP delimiter if you wish to use single quotes within the following fields.
For example, this would work:


$clan_name = 'Ty_ger07\'s Clan'; // your gaming clan or organization name


**You must fill in the following information in the config.php file found in the config folder**


**1)** Input your stats database host, stats database user name, stats database password, and stats database name.


// DATABASE INFORMATION

DEFINE('HOST', '');													// database host address

DEFINE('PORT', '3306');												// database port - default is 3306

DEFINE('NAME', '');													// database name

DEFINE('USER', '');													// database user name - sometimes the same as the database name

DEFINE('PASS', '');													// database password


For example:


// DATABASE INFORMATION

DEFINE('HOST', '100.200.300.400');									// database host address

DEFINE('PORT', '3306');												// database port - default is 3306

DEFINE('NAME', 'database');											// database name

DEFINE('USER', 'user');												// database user name - sometimes the same as the database name

DEFINE('PASS', 'pass');												// database password


**Note:** Some web server providers (such as GoDaddy) use the same value for database name and database user name.


**2)** Input your clan name as you would like it to appear in the stats pages.


$clan_name = ''; // your gaming clan or organization name


For example:


$clan_name = 'Junglewraiths'; // your gaming clan or organization name


**3)** Input your desired banner image URL if you want one other than the default to be displayed.


$banner_image = './images/bf4-logo.png'; // your desired page banner


**4)** Enter the URL which you would like users to redirect to if they click your banner image.


$banner_url = 'http://tyger07.github.io/BF4-Server-Stats/'; // where clicking the banner will take you


Enjoy!


## Changelog:

2-19-2014:
- Added missing Second Assault banner images
- Added updated pChart API

2-18-2014:
- Added Second Assault Maps, Mode, and Weapons

1-23-2014:
- Bug fixes
- Code size reduction
- Style changes
- Added map pie chart to maps page and moved daily player quantity data chart from maps page to server info page
- Reverted back to on-demand signature images instead of caching signature images on the server (for server space usage reasons and to ensure up-to-date data is displayed)

1-3-2014:
- Fixed server info graphs showing old data instead of new data.
- Use GameID associated specifically with 'BF4' instead of just the most common GameID in the database.
- Better error explanations if database doesn't connect or BF4 servers aren't found in the database.

12-30-2013:
- Fixed players of the week page grouping by player id instead of stats id to remove duplicates

12-26-2013:
- Fixed a stats conformity issue by filtering out false database data for players with incorrect secondary Player IDs.
- Fixed signature images by allowing most data to be available in the signature image even if weapon stats are disabled.

12-23-2013:
- Added stats  signature generator
- Added pagination to player of the week pages
- Added player stats signatures to player stats pages

12-22-2013:
- More server banner generator help in example file and an additional option to adjust online player count

12-20-2013:
- Minor bug fix with counting sessions on the index page and global stats pages
- Added server banner generator for generating server banners for website homepage

12-19-2013:
- Slightly different directory structure moving the config file from the common folder to the config folder and renaming it from common.php to config.php
- Change database connection variables to constants
- Made dog tag names in global pages links to global player stats page
- Better battlelog link
- Minor bug fixes
- Removal of map images since they didn't fit the appearance of the page
- Sleeker appearance

12-18-2013:
- Made code more uniform and removed unnecessary duplicate code and duplicate files
- Minor bug fixes
- Added visual indicator to show which column is currently ordered and which direction it is ordered
- Added more comments in code where needed

12-17-2013:
- Disabled global stats if only one server is in the database
- Added more graphs
- Bug fix for battlelog link
- Fixed a typo
- Added players of the week
- Added missing weapon groups

12-16-2013:
- Global stats pages finished off with menus and more pages

12-15-2013:
- Global stats added
- Ranks simplified to speed up pages
- Maps in maps page ordered by game mode

12-14-2013:
- SQL injection security fix by only allowing expected inputs
- New code structure splitting code into different files in the common folder to make finding code easier
- One single index file which leads to all available servers automatically without needing to know server IDs or create multiple separate pages
- More comments in the code to explain what is going on
- Formatting SQL queries to make them more readable
- SQL queries executed with a connection link to avoid issues which might happen if you executed this page inside another page
- Minor SQL optimizations
- Minor file size reductions
- Better error handling
- URL query strings changed to make them slightly shorter and to reference PlayerID instead of SoldierName
- More graphs
- Vehicle stats (as much as the crippled Rcon will allow)
- Added DLC

11-26-2013:
- Map image transparency fixed.
- CSS cleaned up a bit.
- Scoreboard header fixed up a bit.

11-25-2013:
- Popular requests added.
- New directory structure.
- Images added.
- common.php file in the common folder has shared stats page info so less info has to be changed on each individual stats page
- Added this project on GitHub ( https://github.com/tyger07/BF4-Server-Stats )

11-22-2013:
- Appearance renovated to look like BF4

11-21-2013:
- Many more stats
- Tables can be organized by various categories
- Scoreboard takes up less area
- Weapon ranks added
- More ranks in more places

11-20-2013:
- Initial release modified and transferred over from BF3 stats page version