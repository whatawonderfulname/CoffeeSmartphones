<?php  
	include "../services/main.php";
	include "../services/database_connection.php";

	// search for keywords in the database
	if ($_POST) {
		$string = sanitize($_POST["query"]);
		$searchingResult = [];

		function search($table) {
			global $string;
			global $searchingResult;
			global $connection;
			$sql = "select `name`, `id` from `{$table}` where `visible` = 1 and ";
			$keywords = explode(" ", $string); // makes an array of a string using a space separator

			foreach ($keywords as $keyword) {
				$sql .= "`name` like '%{$keyword}%' or ";
			}
			
			$sql = substr($sql, 0, strlen($sql) - 3);
			$result = $connection->query($sql);

			while ($row = $result->fetch_assoc()) {
				$row["category"] = $table;
				array_push($searchingResult, $row);
			}
		}

		search("smartphone");
		search("cover");
		search("headphone");
		search("charger");
		$connection->close();

		// send the searching result as a response
		echo json_encode($searchingResult);
	}
?>