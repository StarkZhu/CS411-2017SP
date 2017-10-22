<?php
	
	$link = mysql_connect('housingbubble.web.engr.illinois.edu', 'housingbubble_cs411', 'cs411');
	if (!$link) {
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db('housingbubble_cs411');
	$search_id_array = $_POST["deletion"];

	foreach($_POST["deletion"] as $search_id){
    	$delete_condition .= " or search_id = ".$search_id;
	}

	$delete_query = "delete from history where search_id = -1 ".$delete_condition;
	$res = mysql_query($delete_query);
	print("
        <!DOCTYPE html>
        <html>
        <head>
	       <meta charset= 'utf-8'>
        </head>
        <body>
		<form action='../main.html' method='POST' enctype='multipart/form-data'>
			<input type = \"submit\" value = \"Complete\">
		</form>
        </body>
        </html>
        ");
	mysql_close($link);
?>