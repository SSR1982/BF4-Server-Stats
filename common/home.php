<?php
// server stats home page by Ty_ger07 at http://open-web-community.com/

// DON'T EDIT ANYTHING BELOW UNLESS YOU KNOW WHAT YOU ARE DOING

// change heading text based on if this is welcome page or top players page
if(!($_GET['topplayers']))
{
	echo '
	<div class="middlecontent">
	<table width="100%" border="0">
	<tr><td  class="headline">
	<br/><center><b>Home Page</b></center><br/>
	</td></tr>
	</table>
	';
}
else
{
	echo '
	<div class="middlecontent">
	<table width="100%" border="0">
	<tr><td  class="headline">
	<br/><center><b>Top Players</b></center><br/>
	</td></tr>
	</table>
	';
}
echo '
<table width="100%" border="0">
<tr><td>
<br/>
<center>Statistics data presented is not from all BF4 servers.  These are the statistics of each player only in this server.</center>
<br/>
</td></tr>
</table>
</div>
<br/>
<br/>
';
// show scoreboard on welcome page
if(!($_GET['topplayers']))
{
	// show scoreboard
	scoreboard($ServerID, $ServerName, $mode_array, $map_array, $squad_array, $country_array, $BF4stats);
	echo '<br/><br/>';
}
echo '
<table width="100%" border="0">
<tr>
<td valign="top" align="center">
<div class="middlecontent">
<table width="100%" border="0">
<tr>
<th class="headline"><b>Top Players</b></th>
</tr>
<tr>
<td>
<div class="innercontent">
';
// pagination code thanks to: http://www.phpfreaks.com/tutorial/basic-pagination
// find out how many rows are in the table 
$TotalRows_q = @mysqli_query($BF4stats,"
	SELECT COUNT(tpd.SoldierName)
	FROM tbl_playerstats tps
	INNER JOIN tbl_server_player tsp ON tsp.StatsID = tps.StatsID
	INNER JOIN tbl_playerdata tpd ON tsp.PlayerID = tpd.PlayerID
	WHERE tsp.ServerID = {$ServerID}
");
$TotalRows_r = @mysqli_fetch_row($TotalRows_q);
$numrows = $TotalRows_r[0];
// number of rows to show per page
$rowsperpage = 25;
// find out total pages
$totalpages = ceil($numrows / $rowsperpage);
// get the current page or set a default
if(isset($_GET['currentpage']) && is_numeric($_GET['currentpage']))
{
	// cast var as int
	$currentpage = (int) $_GET['currentpage'];
}
else
{
	// default page num
	$currentpage = 1;
}
// if current page is greater than total pages...
if ($currentpage > $totalpages)
{
	// set current page to last page
	$currentpage = $totalpages;
}
// if current page is less than first page...
if ($currentpage < 1)
{
	// set current page to first page
	$currentpage = 1;
}
// get current rank query details
if(isset($_GET['rank']) AND !empty($_GET['rank']))
{
	$rank = $_GET['rank'];
	// filter out SQL injection
	if($rank != 'SoldierName' AND $rank != 'Score' AND $rank != 'Rounds' AND $rank != 'Kills' AND $rank != 'Deaths' AND $rank != 'KDR' AND $rank != 'Headshots' AND $rank != 'HSR')
	{
		// unexpected input detected
		// use default instead
		$rank = 'Score';
	}
}
// set default if no rank provided in URL
else
{
	$rank = 'Score';
}
// get current order query details
if(isset($_GET['order']) AND !empty($_GET['order']))
{
	$order = $_GET['order'];
	// filter out SQL injection
	if($order != 'DESC' AND $order != 'ASC')
	{
		// unexpected input detected
		// use default instead
		$order = 'DESC';
		$nextorder = 'ASC';
	}
	else
	{
		if($order == 'DESC')
		{
			$nextorder = 'ASC';
		}
		else
		{
			$nextorder = 'DESC';
		}
	}
}
// set default if no order provided in URL
else
{
	$order = 'DESC';
	$nextorder = 'ASC';
}
// the offset of the list, based on current page 
$offset = ($currentpage - 1) * $rowsperpage;
// get the info from the db 
$Players_q  = @mysqli_query($BF4stats,"
	SELECT tpd.SoldierName, tpd.PlayerID, tps.Score, tps.Kills, tps.Deaths, (tps.Kills/tps.Deaths) AS KDR, tps.Rounds, tps.Headshots, (tps.Headshots/tps.Kills) AS HSR
	FROM tbl_playerstats tps
	INNER JOIN tbl_server_player tsp ON tsp.StatsID = tps.StatsID
	INNER JOIN tbl_playerdata tpd ON tsp.PlayerID = tpd.PlayerID
	WHERE tsp.ServerID = {$ServerID}
	ORDER BY {$rank} {$order}, SoldierName {$nextorder} LIMIT {$offset}, {$rowsperpage}");
// offset of player rank count to show on scoreboard
$count = ($currentpage * 25) - 25;
// check if there are rows returned
if(@mysqli_num_rows($Players_q) != 0)
{
	echo '
	<table width="98%" align="center" class="prettytable" border="0">
	<tr>
	<th width="5%" style="text-align:left">#</th>
	<th width="18%" style="text-align:left;"><a href="' . $_SERVER['PHP_SELF'] . '?ServerID=' . $ServerID . '&amp;topplayers=1&amp;currentpage=' . $currentpage . '&amp;rank=SoldierName&amp;order=';
	if($rank != 'SoldierName')
	{
		echo 'ASC';
	}
	else
	{
		echo $nextorder;
	}
	echo '"><span class="orderheader">Player</span></a></th>
	<th width="11%" style="text-align:left;"><a href="' . $_SERVER['PHP_SELF'] . '?ServerID=' . $ServerID . '&amp;topplayers=1&amp;currentpage=' . $currentpage . '&amp;rank=Score&amp;order=';
	if($rank != 'Score')
	{
		echo 'DESC';
	}
	else
	{
		echo $nextorder;
	}
	echo '"><span class="orderheader">Score</span></a></th>
	<th width="11%" style="text-align:left;"><a href="' . $_SERVER['PHP_SELF'] . '?ServerID=' . $ServerID . '&amp;topplayers=1&amp;currentpage=' . $currentpage . '&amp;rank=Rounds&amp;order=';
	if($rank != 'Rounds')
	{
		echo 'DESC';
	}
	else
	{
		echo $nextorder;
	}
	echo '"><span class="orderheader">Rounds Played</span></a></th>
	<th width="11%" style="text-align:left;"><a href="' . $_SERVER['PHP_SELF'] . '?ServerID=' . $ServerID . '&amp;topplayers=1&amp;currentpage=' . $currentpage . '&amp;rank=Kills&amp;order=';
	if($rank != 'Kills')
	{
		echo 'DESC';
	}
	else
	{
		echo $nextorder;
	}
	echo '"><span class="orderheader">Kills</span></a></th>
	<th width="11%" style="text-align:left;"><a href="' . $_SERVER['PHP_SELF'] . '?ServerID=' . $ServerID . '&amp;topplayers=1&amp;currentpage=' . $currentpage . '&amp;rank=Deaths&amp;order=';
	if($rank != 'Deaths')
	{
		echo 'DESC';
	}
	else
	{
		echo $nextorder;
	}
	echo '"><span class="orderheader">Deaths</span></a></th>
	<th width="11%" style="text-align:left;"><a href="' . $_SERVER['PHP_SELF'] . '?ServerID=' . $ServerID . '&amp;topplayers=1&amp;currentpage=' . $currentpage . '&amp;rank=KDR&amp;order=';
	if($rank != 'KDR')
	{
		echo 'DESC';
	}
	else
	{
		echo $nextorder;
	}
	echo '"><span class="orderheader">Kill/Death Ratio</span></a></th>
	<th width="11%" style="text-align:left;"><a href="' . $_SERVER['PHP_SELF'] . '?ServerID=' . $ServerID . '&amp;topplayers=1&amp;currentpage=' . $currentpage . '&amp;rank=Headshots&amp;order=';
	if($rank != 'Headshots')
	{
		echo 'DESC';
	}
	else
	{
		echo $nextorder;
	}
	echo '"><span class="orderheader">Headshots</span></a></th>
	<th width="11%" style="text-align:left;"><a href="' . $_SERVER['PHP_SELF'] . '?ServerID=' . $ServerID . '&amp;topplayers=1&amp;currentpage=' . $currentpage . '&amp;rank=HSR&amp;order=';
	if($rank != 'HSR')
	{
		echo 'DESC';
	}
	else
	{
		echo $nextorder;
	}
	echo '"><span class="orderheader">Headshot Ratio</span></a></th>
	</tr>';
	// while there are rows to be fetched...
	while($Players_r = @mysqli_fetch_assoc($Players_q))
	{
		$Score = $Players_r['Score'];
		$SoldierName = $Players_r['SoldierName'];
		$PlayerID = $Players_r['PlayerID'];
		$Kills = $Players_r['Kills'];
		$Deaths = $Players_r['Deaths'];
		$Headshots = $Players_r['Headshots'];
		$KDR = round($Players_r['KDR'], 2);
		$HSR = round(($Players_r['HSR']*100),2);
		$Rounds = $Players_r['Rounds'];
		$count++;
		echo '
		<tr>
		<td class="tablecontents" width="5%"><font class="information">' . $count . ':</font></td>
		<td width="18%" class="tablecontents"><a href="' . $_SERVER['PHP_SELF'] . '?ServerID=' . $ServerID . '&amp;PlayerID=' . $PlayerID . '&amp;search=1">' . $SoldierName . '</a></td>
		<td width="11%" class="tablecontents">' . $Score . '</td>
		<td width="11%" class="tablecontents">' . $Rounds . '</td>
		<td width="11%" class="tablecontents">' . $Kills . '</td>
		<td width="11%" class="tablecontents">' . $Deaths . '</td>
		<td width="11%" class="tablecontents">' . $KDR . '</td>
		<td width="11%" class="tablecontents">' . $Headshots . '</td>
		<td width="11%" class="tablecontents">' . $HSR . '<font class="information"> %</font></td>
		</tr>	
		';
	}
	echo '</table>';
}
else
{
	echo '
	<table width="95%" align="center" border="0">
	<tr>
	<td style="text-align: left;" width="100%"><br/><center><font class="information">No player stats found for this server.</font></center><br/></td>
	</tr>
	</table>
	';
}
// free up players query memory
@mysqli_free_result($Players_q);
// build the pagination links
// don't display pagination links if no players found
if(@mysqli_num_rows($TotalRows_q) != 0)
{
	echo '
	<div class="pagination">
	<center>
	';
	// range of num links to show
	$range = 3;
	// if on page 1, don't show back links
	if ($currentpage > 1)
	{
		// show << link to go back to first page
		echo '<a href="' . $_SERVER['PHP_SELF'] . '?ServerID=' . $ServerID . '&amp;topplayers=1&amp;currentpage=1&amp;rank=' . $rank . '&amp;order=' . $order . '">&lt;&lt;</a>';
		// get previous page num
		$prevpage = $currentpage - 1;
		// show < link to go back one page
		echo ' <a href="' . $_SERVER['PHP_SELF'] . '?ServerID=' . $ServerID . '&amp;topplayers=1&amp;currentpage=' . $prevpage . '&amp;rank=' . $rank . '&amp;order=' . $order . '">&lt;</a> ';
	}
	// loop to show links to range of pages around current page
	for($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++)
	{
		// if it's a valid page number...
		if (($x > 0) && ($x <= $totalpages))
		{
			// if we're on current page...
			if ($x == $currentpage)
			{
				// 'highlight' it but don't make a link
				echo ' [<font class="information">' . $x . '</font>] ';
			}
			else
			{
				// make it a link
				echo ' <a href="' . $_SERVER['PHP_SELF'] . '?ServerID=' . $ServerID . '&amp;topplayers=1&amp;currentpage=' . $x . '&amp;rank=' . $rank . '&amp;order=' . $order . '">' . $x . '</a> ';
			}
		}
	}
	// if not on last page, show forward links        
	if ($currentpage != $totalpages)
	{
		// get next page
		$nextpage = $currentpage + 1;
		// show > link to go forward one page
		echo ' <a href="' . $_SERVER['PHP_SELF'] . '?ServerID=' . $ServerID . '&amp;topplayers=1&amp;currentpage=' . $nextpage . '&amp;rank=' . $rank . '&amp;order=' . $order . '">&gt;</a> ';
		// show >> link to last page
		echo '<a href="' . $_SERVER['PHP_SELF'] . '?ServerID=' . $ServerID . '&amp;topplayers=1&amp;currentpage=' . $totalpages . '&amp;rank=' . $rank . '&amp;order=' . $order . '">&gt;&gt;</a>';
	}
	echo '
	</center>
	</div>
	';
}
// end build pagination links and end block
// free up total rows query memory
@mysqli_free_result($TotalRows_q);
echo '
</div>
</td>
</tr>
</table>
</div>
</td></tr>
</table>
';
?>