<html>
<head>
<title>Result Table</title>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style type="text/css">
		body {
			font-size: 15px;
			color: #343d44;
			font-family: "segoe-ui", "open-sans", tahoma, arial;
			padding: 0;
			margin: 0;
		}
		table {
			margin: auto;
			font-family: "Lucida Sans Unicode", "Lucida Grande", "Segoe Ui";
			font-size: 12px;
		}

		h1 {
			margin: 25px auto 0;
			text-align: center;
			text-transform: uppercase;
			font-size: 17px;
		}

		table td {
			transition: all .5s;
		}
		
		/* Table */
		.data-table {
			border-collapse: collapse;
			font-size: 14px;
			min-width: 537px;
		}

		.data-table th, 
		.data-table td {
			border: 1px solid #e1edff;
			padding: 7px 17px;
		}
		.data-table caption {
			margin: 7px;
		}

		/* Table Header */
		.data-table thead th {
			background-color: #508abb;
			color: #FFFFFF;
			border-color: #6ea1cc !important;
			text-transform: uppercase;
		}

		/* Table Body */
		.data-table tbody td {
			color: #353535;
		}
		.data-table tbody td:first-child,
		.data-table tbody td:nth-child(4),
		.data-table tbody td:last-child {
			text-align: right;
		}

		.data-table tbody tr:nth-child(odd) td {
			background-color: #f4fbff;
		}
		.data-table tbody tr:hover td {
			background-color: #ffffa2;
			border-color: #ffff0f;
		}

		/* Table Footer */
		.data-table tfoot th {
			background-color: #e5f5ff;
			text-align: right;
		}
		.data-table tfoot th:first-child {
			text-align: left;
		}
		.data-table tbody td:empty
		{
			background-color: #ffcccc;
		}
	</style>
</head>
<body>
	<div style="margin-left: 530px;margin-top: 100px;">
		<a href="display.php" class="btn btn-info" role="button">Back</a>
	</div>
	<h1><strong>Temporal Database Report </strong></h1></br>
	<table class="data-table">
	<thead>
	<tr>
				
	<?php

	if($c=oci_connect("ADB_TEAM4_2017","nepal123","adb"))
	{
		
					$query = "SELECT CourseId, Dates, Atars FROM 
								TEMPATAR_TAB";


					

			echo "<th>CourseId</th>
				<th>Year</th>
				<th>Atar</th>
		
				
			</tr>
			</thead>
			<tbody>";
			
			if(!$query)
			{
				die("Query failed");

			}
	 //Parse the SQL string & execute it
	     	 $row_count=oci_parse($c,$query);
	     
	     	 oci_execute($row_count);

	     	while(oci_fetch_array($row_count))
	     	{	
	     		echo "test";
	     		$CourseId = OCI_Result($row_count,1);
	     		$year = OCI_Result($row_count,2);
	     		$atar = OCI_Result($row_count,3);
	     		
	     		echo "<tr>";
	     		echo "<td>";
	     		echo $CourseId;
	     		echo "</td>";

	     		foreach ($year as $y){
	     			echo "<td>";
		     		print_r($y);
		     		echo "</td>";
	     		}
	    
	     		foreach ($atar as $a){
	     			echo "<td>";
		     		print_r($a);
		     		echo "</td>";
	     		}
	     		echo "</tr>";

	     	}
	     
			// Free the resources that were used for this query
			OCIFreeStatement($row_count);
				
	}
	else
	{
		echo "Error connecting to the oracle";
	}


?>
		</tbody>
		</table>
</body>
</html>