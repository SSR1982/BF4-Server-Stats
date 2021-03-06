<?php
// server stats player of the week page by Ty_ger07 at http://open-web-community.com/

// DON'T EDIT ANYTHING BELOW UNLESS YOU KNOW WHAT YOU ARE DOING

echo '
<div class="middlecontent">
<table width="100%" border="0">
<tr><td  class="headline">
';
// if there is a ServerID, this is a server stats page
if(!empty($ServerID))
{
	echo '<br/><center><b>These are the top players in this server over the last week.</b></center><br/>';
}
// or else this is a global stats page
else
{
	echo '<br/><center><b>These are the top players in ' . $clan_name . '\'s servers over the last week.</b></center><br/>';
}
echo  '
</td></tr>
</table>
<table width="100%" border="0">
<tr><td>
<br/>
<center>Stats listed below are the stats accumulated by each player only during the previous seven days.</center>
<br/>
</td></tr>
</table>
</div>
<br/><br/>
<div class="middlecontent">
<table width="100%" border="0">
<tr>
';
// pagination code thanks to: http://www.phpfreaks.com/tutorial/basic-pagination
// if there is a ServerID, this is a server stats page
if(!empty($ServerID))
{
	// find out how many rows are in the table 
	$TotalRows_q = @mysqli_query($BF4stats,"
		SELECT tpd.`PlayerID`, tpd.`SoldierName`, SUM(tss.`Score`) AS Score, SUM(tss.`Kills`) AS Kills, SUM(tss.`Deaths`) AS Deaths, (SUM(tss.`Kills`)/SUM(tss.`Deaths`)) AS KDR, SUM(tss.`Headshots`) AS Headshots, (SUM(tss.`Headshots`)/SUM(tss.`Kills`)) AS HSR
		FROM `tbl_sessions` tss
		INNER JOIN `tbl_server_player` tsp ON tss.`StatsID` = tsp.`StatsID`
		INNER JOIN `tbl_playerdata` tpd ON tsp.`PlayerID` = tpd.`PlayerID`
		WHERE tsp.`ServerID` = {$ServerID}
		AND tss.`Starttime` BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()
		AND tpd.`GameID` = {$GameID}
		GROUP BY tpd.`PlayerID`
	");
	$numrows = @mysqli_num_rows($TotalRows_q);
}
// or else this is a global stats page
else
{
	// find out how many rows are in the table
	$TotalRows_q = @mysqli_query($BF4stats,"
		SELECT tpd.`PlayerID`, tpd.`SoldierName`, SUM(tss.`Score`) AS Score, SUM(tss.`Kills`) AS Kills, SUM(tss.`Deaths`) AS Deaths, (SUM(tss.`Kills`)/SUM(tss.`Deaths`)) AS KDR, SUM(tss.`Headshots`) AS Headshots, (SUM(tss.`Headshots`)/SUM(tss.`Kills`)) AS HSR
		FROM `tbl_sessions` tss
		INNER JOIN `tbl_server_player` tsp ON tss.`StatsID` = tsp.`StatsID`
		INNER JOIN `tbl_playerdata` tpd ON tsp.`PlayerID` = tpd.`PlayerID`
		WHERE tss.`Starttime` BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()
		AND tpd.`GameID` = {$GameID}
		GROUP BY tpd.`PlayerID`
	");
	$numrows = @mysqli_num_rows($TotalRows_q);
}
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
if($currentpage > $totalpages)
{
	// set current page to last page
	$currentpage = $totalpages;
}
// if current page is less than first page...
if($currentpage < 1)
{
	// set current page to first page
	$currentpage = 1;
}
// get current rank query details
if(!empty($_GET['rank']))
{
	$rank = $_GET['rank'];
	// filter out SQL injection
	if($rank != 'Score' AND $rank != 'Kills' AND $rank != 'Deaths' AND $rank != 'KDR' AND $rank != 'Headshots' AND $rank != 'HSR')
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
if(!empty($_GET['order']))
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
// if there is a ServerID, this is a server stats page
if(!empty($ServerID))
{
	// query players
	$Player_q = @mysqli_query($BF4stats,"
		SELECT tpd.`PlayerID`, tpd.`SoldierName`, SUM(tss.`Score`) AS Score, SUM(tss.`Kills`) AS Kills, SUM(tss.`Deaths`) AS Deaths, (SUM(tss.`Kills`)/SUM(tss.`Deaths`)) AS KDR, SUM(tss.`Headshots`) AS Headshots, (SUM(tss.`Headshots`)/SUM(tss.`Kills`)) AS HSR
		FROM `tbl_sessions` tss
		INNER JOIN `tbl_server_player` tsp ON tss.`StatsID` = tsp.`StatsID`
		INNER JOIN `tbl_playerdata` tpd ON tsp.`PlayerID` = tpd.`PlayerID`
		WHERE tsp.`ServerID` = {$ServerID}
		AND tss.`Starttime` BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()
		AND tpd.`GameID` = {$GameID}
		GROUP BY tpd.`PlayerID`
		ORDER BY {$rank} {$order}, tpd.`SoldierName` {$nextorder}
		LIMIT {$offset}, {$rowsperpage}
	");
}
// or else this is a global stats page
else
{
	// query players
	$Player_q = @mysqli_query($BF4stats,"
		SELECT tpd.`PlayerID`, tpd.`SoldierName`, SUM(tss.`Score`) AS Score, SUM(tss.`Kills`) AS Kills, SUM(tss.`Deaths`) AS Deaths, (SUM(tss.`Kills`)/SUM(tss.`Deaths`)) AS KDR, SUM(tss.`Headshots`) AS Headshots, (SUM(tss.`Headshots`)/SUM(tss.`Kills`)) AS HSR
		FROM `tbl_sessions` tss
		INNER JOIN `tbl_server_player` tsp ON tss.`StatsID` = tsp.`StatsID`
		INNER JOIN `tbl_playerdata` tpd ON tsp.`PlayerID` = tpd.`PlayerID`
		WHERE tss.`Starttime` BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()
		AND tpd.`GameID` = {$GameID}
		GROUP BY tpd.`PlayerID`
		ORDER BY {$rank} {$order}, tpd.`SoldierName` {$nextorder}
		LIMIT {$offset}, {$rowsperpage}
	");
}
if(@mysqli_num_rows($Player_q) != 0)
{
	// if there is a ServerID, this is a server stats page
	if(!empty($ServerID))
	{
		echo '<th class="headline"><b>Players of the Week</b></th>';
	}
	// or else this is a global stats page
	else
	{
		echo '<th class="headline"><b>Global Players of the Week</b></th>';
	}
	echo '
	</tr>
	<tr>
	<td>
	<div class="innercontent">
	<br/>
	<table width="98%" align="center" border="0">
	<tr>
	<th width="5%" style="text-align:left">#</th>
	<th width="17%" style="text-align:left;">Player</th>
	';
	// if there is a ServerID, this is a server stats page
	if(!empty($ServerID))
	{
		echo '<th width="13%" style="text-align:left;"><a href="' . $_SERVER['PHP_SELF'] . '?ServerID=' . $ServerID . '&amp;potw=1&amp;rank=Score&amp;order=';
	}
	// or else this is a global stats page
	else
	{
		echo '<th width="13%" style="text-align:left;"><a href="' . $_SERVER['PHP_SELF'] . '?globalpotw=1&amp;rank=Score&amp;order=';
	}
	if($rank != 'Score')
	{
		echo 'DESC"><span class="orderheader">Score</span></a></th>';
	}
	else
	{
		echo $nextorder . '"><span class="ordered' . $order . 'header">Score</span></a></th>';
	}
	// if there is a ServerID, this is a server stats page
	if(!empty($ServerID))
	{
		echo '<th width="13%" style="text-align:left;"><a href="' . $_SERVER['PHP_SELF'] . '?ServerID=' . $ServerID . '&amp;potw=1&amp;rank=Kills&amp;order=';
	}
	// or else this is a global stats page
	else
	{
		echo '<th width="13%" style="text-align:left;"><a href="' . $_SERVER['PHP_SELF'] . '?globalpotw=1&amp;rank=Kills&amp;order=';
	}
	if($rank != 'Kills')
	{
		echo 'DESC"><span class="orderheader">Kills</span></a></th>';
	}
	else
	{
		echo $nextorder . '"><span class="ordered' . $order . 'header">Kills</span></a></th>';
	}
	// if there is a ServerID, this is a server stats page
	if(!empty($ServerID))
	{
		echo '<th width="13%" style="text-align:left;"><a href="' . $_SERVER['PHP_SELF'] . '?ServerID=' . $ServerID . '&amp;potw=1&amp;rank=Deaths&amp;order=';
	}
	// or else this is a global stats page
	else
	{
		echo '<th width="13%" style="text-align:left;"><a href="' . $_SERVER['PHP_SELF'] . '?globalpotw=1&amp;rank=Deaths&amp;order=';
	}
	if($rank != 'Deaths')
	{
		echo 'DESC"><span class="orderheader">Deaths</span></a></th>';
	}
	else
	{
		echo $nextorder . '"><span class="ordered' . $order . 'header">Deaths</span></a></th>';
	}
	// if there is a ServerID, this is a server stats page
	if(!empty($ServerID))
	{
		echo '<th width="13%" style="text-align:left;"><a href="' . $_SERVER['PHP_SELF'] . '?ServerID=' . $ServerID . '&amp;potw=1&amp;rank=KDR&amp;order=';
	}
	// or else this is a global stats page
	else
	{
		echo '<th width="13%" style="text-align:left;"><a href="' . $_SERVER['PHP_SELF'] . '?globalpotw=1&amp;rank=KDR&amp;order=';
	}
	if($rank != 'KDR')
	{
		echo 'DESC"><span class="orderheader">Kill/Death Ratio</span></a></th>';
	}
	else
	{
		echo $nextorder . '"><span class="ordered' . $order . 'header">Kill/Death Ratio</span></a></th>';
	}
	// if there is a ServerID, this is a server stats page
	if(!empty($ServerID))
	{
		echo '<th width="13%" style="text-align:left;"><a href="' . $_SERVER['PHP_SELF'] . '?ServerID=' . $ServerID . '&amp;potw=1&amp;rank=Headshots&amp;order=';
	}
	// or else this is a global stats page
	else
	{
		echo '<th width="13%" style="text-align:left;"><a href="' . $_SERVER['PHP_SELF'] . '?globalpotw=1&amp;rank=Headshots&amp;order=';
	}
	if($rank != 'Headshots')
	{
		echo 'DESC"><span class="orderheader">Headshots</span></a></th>';
	}
	else
	{
		echo $nextorder . '"><span class="ordered' . $order . 'header">Headshots</span></a></th>';
	}
	// if there is a ServerID, this is a server stats page
	if(!empty($ServerID))
	{
		echo '<th width="13%" style="text-align:left;"><a href="' . $_SERVER['PHP_SELF'] . '?ServerID=' . $ServerID . '&amp;potw=1&amp;rank=HSR&amp;order=';
	}
	// or else this is a global stats page
	else
	{
		echo '<th width="13%" style="text-align:left;"><a href="' . $_SERVER['PHP_SELF'] . '?globalpotw=1&amp;rank=HSR&amp;order=';
	}
	if($rank != 'HSR')
	{
		echo 'DESC"><span class="orderheader">Headshot Ratio</span></a></th>';
	}
	else
	{
		echo $nextorder . '"><span class="ordered' . $order . 'header">Headshot Ratio</span></a></th>';
	}
	echo '</tr>';
	// offset of player rank count to show on scoreboard
	$count = ($currentpage * 25) - 25;
	while($Player_r = @mysqli_fetch_assoc($Player_q))
	{
		$count++;
		$Soldier_Name = $Player_r['SoldierName'];
		$Player_ID = $Player_r['PlayerID'];
		$Score = $Player_r['Score'];
		$Kills = $Player_r['Kills'];
		$Deaths = $Player_r['Deaths'];
		$KDR = round($Player_r['KDR'],2);
		$Headshots = $Player_r['Headshots'];
		$HSR = round(($Player_r['HSR']*100),2);
		echo '
		<tr>
		<td width="5%" class="tablecontents" style="text-align: left;"><font class="information">' . $count . ':</font></td>
		';
		// if there is a ServerID, this is a server stats page
		if(!empty($ServerID))
		{
			echo '<td width="17%" class="tablecontents" style="text-align: left;"><a href="' . $_SERVER['PHP_SELF'] . '?ServerID=' . $ServerID . '&amp;PlayerID=' . $Player_ID . '&amp;search=1">' . $Soldier_Name . '</a></td>';
		}
		// or else this is a global stats page
		else
		{
			echo '<td width="17%" class="tablecontents" style="text-align: left;"><a href="' . $_SERVER['PHP_SELF'] . '?globalsearch=1&amp;PlayerID=' . $Player_ID . '">' . $Soldier_Name . '</a></td>';
		}
		echo '
		<td width="13%" class="tablecontents" style="text-align: left;">' . $Score . '</td>
		<td width="13%" class="tablecontents" style="text-align: left;">' . $Kills . '</td>
		<td width="13%" class="tablecontents" style="text-align: left;">' . $Deaths . '</td>
		<td width="13%" class="tablecontents" style="text-align: left;">' . $KDR . '</td>
		<td width="13%" class="tablecontents" style="text-align: left;">' . $Headshots . '</td>
		<td width="13%" class="tablecontents" style="text-align: left;">' . $HSR . '<font class="information"> %</font></td>
		</tr>
		';
	}
	echo '</table></div>';
}
else
{
	// if there is a ServerID, this is a server stats page
	if(!empty($ServerID))
	{
		echo '<td width="100%"><br/><center><font class="information">No session stats found for this server over the last week.</font></center><br/>';
	}
	// or else this is a global stats page
	else
	{
		echo '<td width="100%"><br/><center><font class="information">No session stats found for these servers over the last week.</font></center><br/>';
	}
}
// build the pagination links
// don't display pagination links if no players found
if(@mysqli_num_rows($Player_q) != 0)
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
		// if there is a ServerID, this is a server stats page
		if(!empty($ServerID))
		{
			echo '<a href="' . $_SERVER['PHP_SELF'] . '?ServerID=' . $ServerID . '&amp;potw=1&amp;currentpage=1&amp;rank=' . $rank . '&amp;order=' . $order . '">&lt;&lt;</a>';
		}
		// or else this is a global stats page
		else
		{
			echo '<a href="' . $_SERVER['PHP_SELF'] . '?currentpage=1&amp;globalpotw=1&amp;rank=' . $rank . '&amp;order=' . $order . '">&lt;&lt;</a>';
		}
		// get previous page num
		$prevpage = $currentpage - 1;
		// show < link to go back one page
		// if there is a ServerID, this is a server stats page
		if(!empty($ServerID))
		{
			echo ' <a href="' . $_SERVER['PHP_SELF'] . '?ServerID=' . $ServerID . '&amp;potw=1&amp;currentpage=' . $prevpage . '&amp;rank=' . $rank . '&amp;order=' . $order . '">&lt;</a> ';
		}
		// or else this is a global stats page
		else
		{
			echo ' <a href="' . $_SERVER['PHP_SELF'] . '?currentpage=' . $prevpage . '&amp;globalpotw=1&amp;rank=' . $rank . '&amp;order=' . $order . '">&lt;</a> ';
		}
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
				// if there is a ServerID, this is a server stats page
				if(!empty($ServerID))
				{
					echo ' <a href="' . $_SERVER['PHP_SELF'] . '?ServerID=' . $ServerID . '&amp;potw=1&amp;currentpage=' . $x . '&amp;rank=' . $rank . '&amp;order=' . $order . '">' . $x . '</a> ';
				}
				// or else this is a global stats page
				else
				{
					echo ' <a href="' . $_SERVER['PHP_SELF'] . '?currentpage=' . $x . '&amp;globalpotw=1&amp;rank=' . $rank . '&amp;order=' . $order . '">' . $x . '</a> ';
				}
			}
		}
	}
	// if not on last page, show forward links        
	if ($currentpage != $totalpages)
	{
		// get next page
		$nextpage = $currentpage + 1;
		// show > link to go forward one page
		// if there is a ServerID, this is a server stats page
		if(!empty($ServerID))
		{
			echo ' <a href="' . $_SERVER['PHP_SELF'] . '?ServerID=' . $ServerID . '&amp;potw=1&amp;currentpage=' . $nextpage . '&amp;rank=' . $rank . '&amp;order=' . $order . '">&gt;</a> ';
		}
		// or else this is a global stats page
		else
		{
			echo ' <a href="' . $_SERVER['PHP_SELF'] . '?currentpage=' . $nextpage . '&amp;globalpotw=1&amp;rank=' . $rank . '&amp;order=' . $order . '">&gt;</a> ';
		}
		// show >> link to last page
		// if there is a ServerID, this is a server stats page
		if(!empty($ServerID))
		{
			echo '<a href="' . $_SERVER['PHP_SELF'] . '?ServerID=' . $ServerID . '&amp;potw=1&amp;currentpage=' . $totalpages . '&amp;rank=' . $rank . '&amp;order=' . $order . '">&gt;&gt;</a>';
		}
		// or else this is a global stats page
		else
		{
			echo '<a href="' . $_SERVER['PHP_SELF'] . '?currentpage=' . $totalpages . '&amp;globalpotw=1&amp;rank=' . $rank . '&amp;order=' . $order . '">&gt;&gt;</a>';
		}
	}
	echo '
	</center>
	</div>
	';
}
// end build pagination links and end block
// free up total rows query memory
@mysqli_free_result($TotalRows_q);
// free up player stats query memory
@mysqli_free_result($Player_q);
echo '
</td>
</tr>
</table>
</div>
';
?>