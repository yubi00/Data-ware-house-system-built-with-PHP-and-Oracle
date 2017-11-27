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
	<div style="margin-left: 400px;margin-top: 100px;">
		<a href="display.php" class="btn btn-info" role="button">Back</a>
	</div>
	<h1><strong>Result Table</strong> </h1>
	<br/>
	<table class="data-table">
	<thead>
	<tr>
				
	<?php

	
//Get rowchoice 
	$row = $_GET['rowChoice']; 
	$column = $_GET['columnChoice'];
	 $summary = $_GET['summaryVariable'];
	 $resultselection = $_GET['resultselection'];
	  $topk = $_GET['topk'];
	  $topn = $_GET['topn'];
	 
	 if($row == $column){
		 echo "<script type='text/javascript'>alert('Row and column values cannot be same');</script>";
		 header("Location: display.php");
	 }

	 //connecting with the oracle
	 $c=OCILogon("ADB_TEAM4_2017","nepal123","adb");

	if($c)
	{

		
		list($rowtablename, $rowtableid, $rowfieldname, $rowdispname) =
		split('/', $row);

		list($coltablename, $coltableid, $colfieldname, $coldispname) =
		split('/', $column);

		list($sumtablename ,$sumagg, $sumdispname) = split('/', $summary);

		if($sumagg == "AVGATAR")
		{	
			$sumagg = "(SUM(TSATAR)/SUM(TNA))";
		}
 
//if users clicks on showall radio button
		if($resultselection == "showall")
		{
			//user selects row choice as primary study field
			if($row == "primarystudyfield")
			{
				

				$query = "SELECT S.StudyFieldName AS \"Primary Study Field\", 
						C.$colfieldname AS \"$coldispname\",
						ROUND($sumagg,2) AS \"$sumdispname\"

						FROM $sumtablename F, $coltablename C, StudyFields_DIM S
						WHERE (C.$coltableid = F.$coltableid) and
						(S.StudyFieldId = F.primarystudyfield)
						GROUP BY (S.StudyFieldName, C.$colfieldname)
						ORDER BY S.StudyFieldName, C.$colfieldname";

						echo "<th>";
			     		echo "Primary Study Field";
			     		echo "</th>";
			     		echo "<th>";
			     		echo $coldispname;
			     		echo "</th>";
			     		echo "<th>";
			     		echo $sumdispname;
			     		echo "</th>";
						
					
				echo "</tr></thead><tbody>"; 
				if(!$query)
				{
					die("Query failed");
				}
				else
				{
					
					$row_count=OCIParse($c,$query);

		     	 	$test = OCIExecute($row_count);
		     	 

		     	 	while(OCIFetch($row_count))
		     	 	{
		     	 		
		     	 		$firstcol = OCIResult($row_count,1);
		     	 		$secondcol = OCIResult($row_count,2);
		     	 		$summarycol = OCIResult($row_count,3);

		     	 		echo "<tr>";
			     		echo "<td>";
			     		echo $firstcol;
			     		echo "</td>";
			     		echo "<td>";
			     		echo $secondcol;
			     		echo "</td>";
			     		echo "<td>";
			     		echo $summarycol;
			     		echo "</td>";
			     		echo "</tr>";
		     	 	}
		     	 	OCIFreeStatement($row_count);
				}
				//user selects column choice as primary study field
			} elseif ($column == "primarystudyfield")
			{
				
				$query = "SELECT R.$rowfieldname AS \"$rowdispname\",
						S.StudyFieldName AS \"Primary Study Field\", 
						ROUND($sumagg,2) AS \"$sumdispname\"
						FROM $sumtablename F, $rowtablename R, StudyFields_DIM S
						WHERE (R.$rowtableid = F.$rowtableid) and
						(S.StudyFieldId = F.primarystudyfield)
						GROUP BY (S.StudyFieldName, R.$rowfieldname)
						ORDER BY S.StudyFieldName, R.$rowfieldname";
						
			     		echo "<th>";
			     		echo $rowdispname;
			     		echo "</th>";
			     		echo "<th>";
			     		echo "Primary Study Field";
			     		echo "</th>";
			     		echo "<th>";
			     		echo $sumdispname;
			     		echo "</th>";
						
					
				echo "</tr></thead><tbody>";
				 
				if(!$query)
				{
					die("Query failed");
				}
				else
				{
					
					$row_count=OCIParse($c,$query);

		     	 	$test = OCIExecute($row_count);
		     	 

		     	 	while(OCIFetch($row_count))
		     	 	{
		     	 		
		     	 		$firstcol = OCIResult($row_count,1);
		     	 		$secondcol = OCIResult($row_count,2);
		     	 		$summarycol = OCIResult($row_count,3);

		     	 		echo "<tr>";
			     		echo "<td>";
			     		echo $firstcol;
			     		echo "</td>";
			     		echo "<td>";
			     		echo $secondcol;
			     		echo "</td>";
			     		echo "<td>";
			     		echo $summarycol;
			     		echo "</td>";
			     		echo "</tr>";
		     	 	}
		     	 	OCIFreeStatement($row_count);
				}
				
			}//user selects row choice as supplementary study field
			elseif ($row == "suppstudyfield")
			{
				
				$query = "SELECT S.StudyFieldName AS \"Secondary Study Field\", 
						C.$colfieldname AS \"$coldispname\",
						ROUND($sumagg,2) AS \"$sumdispname\"

						FROM $sumtablename F, $coltablename C, StudyFields_DIM S
						WHERE (C.$coltableid = F.$coltableid) and
						(S.StudyFieldId = F.SupStudyField)
						GROUP BY (S.StudyFieldName, C.$colfieldname)
						ORDER BY S.StudyFieldName, C.$colfieldname";

						echo "<th>";
			     		echo "Supplementary Study Field";
			     		echo "</th>";
			     		echo "<th>";
			     		echo $coldispname;
			     		echo "</th>";
			     		echo "<th>";
			     		echo $sumdispname;
			     		echo "</th>";
						
					
				echo "</tr></thead><tbody>";
				 
				if(!$query)
				{
					die("Query failed");
				}
				else
				{
					
					$row_count=OCIParse($c,$query);

		     	 	$test = OCIExecute($row_count);
		     	 

		     	 	while(OCIFetch($row_count))
		     	 	{
		     	 		 
		     	 		$firstcol = OCIResult($row_count,1);
		     	 		$secondcol = OCIResult($row_count,2);
		     	 		$summarycol = OCIResult($row_count,3);

		     	 		echo "<tr>";
			     		echo "<td>";
			     		echo $firstcol;
			     		echo "</td>";
			     		echo "<td>";
			     		echo $secondcol;
			     		echo "</td>";
			     		echo "<td>";
			     		echo $summarycol;
			     		echo "</td>";
			     		echo "</tr>";
		     	 	}
		     	 	OCIFreeStatement($row_count);
				}
				
			}//user selects column choice as supp study field
			elseif ($column == "suppstudyfield")
			{
				
				
				$query = "SELECT R.$rowfieldname AS \"$rowdispname\",
						S.StudyFieldName AS \"Secondary Study Field\", 
						ROUND($sumagg,2) AS \"$sumdispname\"
						FROM $sumtablename F, $rowtablename R, StudyFields_DIM S
						WHERE (R.$rowtableid = F.$rowtableid) and
						(S.StudyFieldId = F.SupStudyField)
						GROUP BY (S.StudyFieldName, R.$rowfieldname)
						ORDER BY S.StudyFieldName, R.$rowfieldname";
						
			     		echo "<th>";
			     		echo $rowdispname;
			     		echo "</th>";
			     		echo "<th>";
			     		echo "Supplementary Study Field";
			     		echo "</th>";
			     		echo "<th>";
			     		echo $sumdispname;
			     		echo "</th>";
						
					
				echo "</tr></thead><tbody>";
				 
				if(!$query)
				{
					die("Query failed");
				}
				else
				{
					
					$row_count=OCIParse($c,$query);

		     	 	$test = OCIExecute($row_count);
		     	 

		     	 	while(OCIFetch($row_count))
		     	 	{
		     	 		
		     	 		$firstcol = OCIResult($row_count,1);
		     	 		$secondcol = OCIResult($row_count,2);
		     	 		$summarycol = OCIResult($row_count,3);

		     	 		echo "<tr>";
			     		echo "<td>";
			     		echo $firstcol;
			     		echo "</td>";
			     		echo "<td>";
			     		echo $secondcol;
			     		echo "</td>";
			     		echo "<td>";
			     		echo $summarycol;
			     		echo "</td>";
			     		echo "</tr>";
		     	 	}
		     	 	OCIFreeStatement($row_count);
				}
				
			}
			else
			{
				
				$query =  "SELECT R.$rowfieldname AS \"$rowdispname\",
						C.$colfieldname AS \"$coldispname\",
						ROUND($sumagg,2) AS \"$sumdispname\"
						FROM $sumtablename F, $coltablename C, $rowtablename R
						WHERE (C.$coltableid = F.$coltableid) and
						(R.$rowtableid = F.$rowtableid)
						GROUP BY (R.$rowfieldname, C.$colfieldname)
						ORDER BY R.$rowfieldname, C.$colfieldname";

						echo "<th>";
			     		echo $rowdispname;
			     		echo "</th>";
			     		echo "<th>";
			     		echo $coldispname;
			     		echo "</th>";
			     		echo "<th>";
			     		echo $sumdispname;
			     		echo "</th>";
						
					
				echo "</tr></thead><tbody>";
				
				if(!$query)
				{
					die("Query failed");
				}
				else
				{
					
					$row_count=OCIParse($c,$query);

		     	 	$test = OCIExecute($row_count);
		     	 

		     	 	while(OCIFetch($row_count))
		     	 	{
		     	 		
		     	 		$firstcol = OCIResult($row_count,1);
		     	 		$secondcol = OCIResult($row_count,2);
		     	 		$summarycol = OCIResult($row_count,3);

		     	 		echo "<tr>";
			     		echo "<td>";
			     		echo $firstcol;
			     		echo "</td>";
			     		echo "<td>";
			     		echo $secondcol;
			     		echo "</td>";
			     		echo "<td>";
			     		echo $summarycol;
			     		echo "</td>";
			     		echo "</tr>";
		     	 	}
		     	 	OCIFreeStatement($row_count);
				}


			}
		}
		else if($resultselection == "topk")
		{
			//if users clicks on topk dio button
			$num = 0; 

			if($topk == "top3")
			{
				$num = 3;
				
			}
			elseif ($topk == "top5") {
				$num = 5;
				
			}
			elseif ($topk == "top10") {
				$num = 10;
				
			}
			else
			{
				echo "invalid choice";
			}
			
			if($row == "primarystudyfield")
			{

				$query = "SELECT \"Primary Study Field\", \"$coldispname\",\"$sumdispname\" 
						FROM(SELECT S.StudyFieldName AS \"Primary Study Field\",
						C.$colfieldname AS \"$coldispname\",
						ROUND($sumagg,2) AS \"$sumdispname\",
						RANK () OVER( ORDER BY ROUND($sumagg,2)DESC) AS RankI
						FROM $sumtablename F, $coltablename C, StudyFields_DIM S
						WHERE (C.$coltableid = F.$coltableid) and
						(S.StudyFieldId = F.primarystudyfield)
						GROUP BY (S.StudyFieldName, C.$colfieldname))
						WHERE RankI<=$num";


						echo "<th>";
			     		echo "Primary Study Field";
			     		echo "</th>";
			     		echo "<th>";
			     		echo $coldispname;
			     		echo "</th>";
			     		echo "<th>";
			     		echo $sumdispname;
			     		echo "</th>";
						
					
				echo "</tr></thead><tbody>";
				
				if(!$query)
				{
					die("Query failed");
				}
				else
				{
					
					$row_count=OCIParse($c,$query);

		     	 	$test = OCIExecute($row_count);
		     	 

		     	 	while(OCIFetch($row_count))
		     	 	{
		     	 		
		     	 		$firstcol = OCIResult($row_count,1);
		     	 		$secondcol = OCIResult($row_count,2);
		     	 		$summarycol = OCIResult($row_count,3);

		     	 		echo "<tr>";
			     		echo "<td>";
			     		echo $firstcol;
			     		echo "</td>";
			     		echo "<td>";
			     		echo $secondcol;
			     		echo "</td>";
			     		echo "<td>";
			     		echo $summarycol;
			     		echo "</td>";
			     		echo "</tr>";
		     	 	}
		     	 	OCIFreeStatement($row_count);
				}
				//user selects column choice as primary study field
			}elseif($column == "primarystudyfield")
			{

				$query = "SELECT \"$rowdispname\", \"Primary Study Field\", \"$sumdispname\" 
						FROM(SELECT C.$rowfieldname AS \"$rowdispname\", 
						S.StudyFieldName AS \"Primary Study Field\",
						ROUND($sumagg,2) AS \"$sumdispname\",
						RANK () OVER( ORDER BY ROUND($sumagg,2)DESC) AS RankI
						FROM $sumtablename F, $rowtablename C, StudyFields_DIM S
						WHERE (C.$rowtableid = F.$rowtableid) and
						(S.StudyFieldId = F.primarystudyfield)
						GROUP BY (S.StudyFieldName, C.$rowfieldname))
						WHERE RankI<=$num";


						echo "<th>";
			     		echo $rowdispname;
			     		echo "</th>";
			     		echo "<th>";
			     		echo "Primary Study Field";
			     		echo "</th>";
			     		echo "<th>";
			     		echo $sumdispname;
			     		echo "</th>";
						
					
				echo "</tr></thead><tbody>";
				 
				if(!$query)
				{
					die("Query failed");
				}
				else
				{
					
					$row_count=OCIParse($c,$query);

		     	 	$test = OCIExecute($row_count);
		     	 

		     	 	while(OCIFetch($row_count))
		     	 	{
		     	 		
		     	 		$firstcol = OCIResult($row_count,1);
		     	 		$secondcol = OCIResult($row_count,2);
		     	 		$summarycol = OCIResult($row_count,3);

		     	 		echo "<tr>";
			     		echo "<td>";
			     		echo $firstcol;
			     		echo "</td>";
			     		echo "<td>";
			     		echo $secondcol;
			     		echo "</td>";
			     		echo "<td>";
			     		echo $summarycol;
			     		echo "</td>";
			     		echo "</tr>";
		     	 	}
		     	 	OCIFreeStatement($row_count);
				}
				//user selects column choice as primary study field
			}
			elseif($row == "suppstudyfield")
			{

				$query = "SELECT \"Supplementary Study Field\", \"$coldispname\",\"$sumdispname\" 
						FROM(SELECT S.StudyFieldName AS \"Supplementary Study Field\",
						C.$colfieldname AS \"$coldispname\",
						ROUND($sumagg,2) AS \"$sumdispname\",
						RANK () OVER( ORDER BY ROUND($sumagg,2)DESC) AS RankI
						FROM $sumtablename F, $coltablename C, StudyFields_DIM S
						WHERE (C.$coltableid = F.$coltableid) and
						(S.StudyFieldId = F.supstudyfield)
						GROUP BY (S.StudyFieldName, C.$colfieldname))
						WHERE RankI<=$num";


						echo "<th>";
			     		echo "Supplementary Study Field";
			     		echo "</th>";
			     		echo "<th>";
			     		echo $coldispname;
			     		echo "</th>";
			     		echo "<th>";
			     		echo $sumdispname;
			     		echo "</th>";
						
					
				echo "</tr></thead><tbody>";
				 
				if(!$query)
				{
					die("Query failed");
				}
				else
				{
					
					$row_count=OCIParse($c,$query);

		     	 	$test = OCIExecute($row_count);
		     	 

		     	 	while(OCIFetch($row_count))
		     	 	{
		     	 		 
		     	 		$firstcol = OCIResult($row_count,1);
		     	 		$secondcol = OCIResult($row_count,2);
		     	 		$summarycol = OCIResult($row_count,3);

		     	 		echo "<tr>";
			     		echo "<td>";
			     		echo $firstcol;
			     		echo "</td>";
			     		echo "<td>";
			     		echo $secondcol;
			     		echo "</td>";
			     		echo "<td>";
			     		echo $summarycol;
			     		echo "</td>";
			     		echo "</tr>";
		     	 	}
		     	 	OCIFreeStatement($row_count);
				}
				//user selects column choice as primary study field
			}elseif($column == "suppstudyfield")
			{

				$query = "SELECT \"$rowdispname\", \"Supplementary Study Field\", \"$sumdispname\" 
						FROM(SELECT C.$rowfieldname AS \"$rowdispname\", 
						S.StudyFieldName AS \"Supplementary Study Field\",
						ROUND($sumagg,2) AS \"$sumdispname\",
						RANK () OVER( ORDER BY ROUND($sumagg,2)DESC) AS RankI
						FROM $sumtablename F, $rowtablename C, StudyFields_DIM S
						WHERE (C.$rowtableid = F.$rowtableid) and
						(S.StudyFieldId = F.supstudyfield)
						GROUP BY (S.StudyFieldName, C.$rowfieldname))
						WHERE RankI<=$num";


						echo "<th>";
			     		echo $rowdispname;
			     		echo "</th>";
			     		echo "<th>";
			     		echo "Supplementary Study Field";
			     		echo "</th>";
			     		echo "<th>";
			     		echo $sumdispname;
			     		echo "</th>";
						
					
				echo "</tr></thead><tbody>";
				 
				if(!$query)
				{
					die("Query failed");
				}
				else
				{
					
					$row_count=OCIParse($c,$query);

		     	 	$test = OCIExecute($row_count);
		     	 

		     	 	while(OCIFetch($row_count))
		     	 	{
		     	 		
		     	 		$firstcol = OCIResult($row_count,1);
		     	 		$secondcol = OCIResult($row_count,2);
		     	 		$summarycol = OCIResult($row_count,3);

		     	 		echo "<tr>";
			     		echo "<td>";
			     		echo $firstcol;
			     		echo "</td>";
			     		echo "<td>";
			     		echo $secondcol;
			     		echo "</td>";
			     		echo "<td>";
			     		echo $summarycol;
			     		echo "</td>";
			     		echo "</tr>";
		     	 	}
		     	 	OCIFreeStatement($row_count);
				}
				//user selects column choice as primary study field
			}
			else
			{
				$query = "SELECT \"$rowdispname\", \"$coldispname\",\"$sumdispname\" FROM
						( SELECT R.$rowfieldname AS \"$rowdispname\",
						C.$colfieldname AS \"$coldispname\",
						ROUND($sumagg,2) AS \"$sumdispname\",
						RANK () OVER( ORDER BY ROUND($sumagg,2)DESC) AS RankI
						FROM $sumtablename F, $coltablename C, $rowtablename R
						WHERE C.$coltableid = F.$coltableid AND
						R.$rowtableid = F.$rowtableid
						GROUP BY (R.$rowfieldname, C.$colfieldname))
						WHERE RankI<=$num";
						
						echo "<th>";
							echo $rowdispname;
							echo "</th>";
							echo "<th>";
							echo $coldispname;
							echo "</th>";
							echo "<th>";
							echo $sumdispname;
							echo "</th>";
							
						
					echo "</tr></thead><tbody>";
					 
					if(!$query)
					{
						die("Query failed");
					}
					else
					{
						
						$row_count=OCIParse($c,$query);

						$test = OCIExecute($row_count);
					 

						while(OCIFetch($row_count))
						{
							 
							$firstcol = OCIResult($row_count,1);
							$secondcol = OCIResult($row_count,2);
							$summarycol = OCIResult($row_count,3);

							echo "<tr>";
							echo "<td>";
							echo $firstcol;
							echo "</td>";
							echo "<td>";
							echo $secondcol;
							echo "</td>";
							echo "<td>";
							echo $summarycol;
							echo "</td>";
							echo "</tr>";
						}
						OCIFreeStatement($row_count);
					}
			}


		}
		else if($resultselection == "topn")
		{
			//if users clicks on topn% radio button
			
			$num = 0; 

			if($topn == "top10p")
			{
				$num = 0.1;
				
			}
			elseif ($topn == "top25p") {
				$num = 0.25;
				
			}
			elseif ($topn == "top50p") {
				$num = 0.50;
				
			}
			else
			{
				echo "invalid choice";
			}
			if($row == "primarystudyfield")
			{

				$query = "SELECT \"Primary Study Field\", \"$coldispname\",\"$sumdispname\" 
						FROM(SELECT S.StudyFieldName AS \"Primary Study Field\",
						C.$colfieldname AS \"$coldispname\",
						ROUND($sumagg,2) AS \"$sumdispname\",
						RANK () OVER( ORDER BY ROUND($sumagg,2)DESC) AS RankI,
						COUNT(*) OVER() AS COUNTI
						FROM $sumtablename F, $coltablename C, StudyFields_DIM S
						WHERE (C.$coltableid = F.$coltableid) and
						(S.StudyFieldId = F.primarystudyfield)
						GROUP BY (S.StudyFieldName, C.$colfieldname))
						WHERE RankI<=$num*COUNTI";


						echo "<th>";
			     		echo "Primary Study Field";
			     		echo "</th>";
			     		echo "<th>";
			     		echo $coldispname;
			     		echo "</th>";
			     		echo "<th>";
			     		echo $sumdispname;
			     		echo "</th>";
						
					
				echo "</tr></thead><tbody>";
				 
				if(!$query)
				{
					die("Query failed");
				}
				else
				{
					
					$row_count=OCIParse($c,$query);

		     	 	$test = OCIExecute($row_count);
		     	 

		     	 	while(OCIFetch($row_count))
		     	 	{
		     	 		
		     	 		$firstcol = OCIResult($row_count,1);
		     	 		$secondcol = OCIResult($row_count,2);
		     	 		$summarycol = OCIResult($row_count,3);

		     	 		echo "<tr>";
			     		echo "<td>";
			     		echo $firstcol;
			     		echo "</td>";
			     		echo "<td>";
			     		echo $secondcol;
			     		echo "</td>";
			     		echo "<td>";
			     		echo $summarycol;
			     		echo "</td>";
			     		echo "</tr>";
		     	 	}
		     	 	OCIFreeStatement($row_count);
				}
				//user selects column choice as primary study field
			}elseif($column == "primarystudyfield")
			{

				$query = "SELECT \"$rowdispname\", \"Primary Study Field\", \"$sumdispname\" 
						FROM(SELECT C.$rowfieldname AS \"$rowdispname\", 
						S.StudyFieldName AS \"Primary Study Field\",
						ROUND($sumagg,2) AS \"$sumdispname\",
						RANK () OVER( ORDER BY ROUND($sumagg,2)DESC) AS RankI,
						COUNT(*) OVER() AS COUNTI
						FROM $sumtablename F, $rowtablename C, StudyFields_DIM S
						WHERE (C.$rowtableid = F.$rowtableid) and
						(S.StudyFieldId = F.primarystudyfield)
						GROUP BY (S.StudyFieldName, C.$rowfieldname))
						WHERE RankI<=$num*COUNTI";


						echo "<th>";
			     		echo $rowdispname;
			     		echo "</th>";
			     		echo "<th>";
			     		echo "Primary Study Field";
			     		echo "</th>";
			     		echo "<th>";
			     		echo $sumdispname;
			     		echo "</th>";
						
					
				echo "</tr></thead><tbody>";
				 
				if(!$query)
				{
					die("Query failed");
				}
				else
				{
					
					$row_count=OCIParse($c,$query);

		     	 	$test = OCIExecute($row_count);
		     	 

		     	 	while(OCIFetch($row_count))
		     	 	{
		     	 		
		     	 		$firstcol = OCIResult($row_count,1);
		     	 		$secondcol = OCIResult($row_count,2);
		     	 		$summarycol = OCIResult($row_count,3);

		     	 		echo "<tr>";
			     		echo "<td>";
			     		echo $firstcol;
			     		echo "</td>";
			     		echo "<td>";
			     		echo $secondcol;
			     		echo "</td>";
			     		echo "<td>";
			     		echo $summarycol;
			     		echo "</td>";
			     		echo "</tr>";
		     	 	}
		     	 	OCIFreeStatement($row_count);
				}
				//user selects column choice as primary study field
			}
			elseif($row == "suppstudyfield")
			{

				$query = "SELECT \"Supplementary Study Field\", \"$coldispname\",\"$sumdispname\" 
						FROM(SELECT S.StudyFieldName AS \"Supplementary Study Field\",
						C.$colfieldname AS \"$coldispname\",
						ROUND($sumagg,2) AS \"$sumdispname\",
						RANK () OVER( ORDER BY ROUND($sumagg,2)DESC) AS RankI,
						COUNT(*) OVER() AS COUNTI
						FROM $sumtablename F, $coltablename C, StudyFields_DIM S
						WHERE (C.$coltableid = F.$coltableid) and
						(S.StudyFieldId = F.supstudyfield)
						GROUP BY (S.StudyFieldName, C.$colfieldname))
						WHERE RankI<=$num*COUNTI";


						echo "<th>";
			     		echo "Supplementary Study Field";
			     		echo "</th>";
			     		echo "<th>";
			     		echo $coldispname;
			     		echo "</th>";
			     		echo "<th>";
			     		echo $sumdispname;
			     		echo "</th>";
						
					
				echo "</tr></thead><tbody>";
				 
				if(!$query)
				{
					die("Query failed");
				}
				else
				{
					
					$row_count=OCIParse($c,$query);

		     	 	$test = OCIExecute($row_count);
		     	 

		     	 	while(OCIFetch($row_count))
		     	 	{
		     	 	 
		     	 		$firstcol = OCIResult($row_count,1);
		     	 		$secondcol = OCIResult($row_count,2);
		     	 		$summarycol = OCIResult($row_count,3);

		     	 		echo "<tr>";
			     		echo "<td>";
			     		echo $firstcol;
			     		echo "</td>";
			     		echo "<td>";
			     		echo $secondcol;
			     		echo "</td>";
			     		echo "<td>";
			     		echo $summarycol;
			     		echo "</td>";
			     		echo "</tr>";
		     	 	}
		     	 	OCIFreeStatement($row_count);
				}
				//user selects column choice as primary study field
			}elseif($column == "suppstudyfield")
			{

				$query = "SELECT \"$rowdispname\", \"Supplementary Study Field\", \"$sumdispname\" 
						FROM(SELECT C.$rowfieldname AS \"$rowdispname\", 
						S.StudyFieldName AS \"Supplementary Study Field\",
						ROUND($sumagg,2) AS \"$sumdispname\",
						RANK () OVER( ORDER BY ROUND($sumagg,2)DESC) AS RankI,
						COUNT(*) OVER() AS COUNTI
						FROM $sumtablename F, $rowtablename C, StudyFields_DIM S
						WHERE (C.$rowtableid = F.$rowtableid) and
						(S.StudyFieldId = F.supstudyfield)
						GROUP BY (S.StudyFieldName, C.$rowfieldname))
						WHERE RankI<=$num*COUNTI";


						echo "<th>";
			     		echo $rowdispname;
			     		echo "</th>";
			     		echo "<th>";
			     		echo "Supplementary Study Field";
			     		echo "</th>";
			     		echo "<th>";
			     		echo $sumdispname;
			     		echo "</th>";
						
					
				echo "</tr></thead><tbody>";
				 
				if(!$query)
				{
					die("Query failed");
				}
				else
				{
					
					$row_count=OCIParse($c,$query);

		     	 	$test = OCIExecute($row_count);
		     	 

		     	 	while(OCIFetch($row_count))
		     	 	{
		     	 		 
		     	 		$firstcol = OCIResult($row_count,1);
		     	 		$secondcol = OCIResult($row_count,2);
		     	 		$summarycol = OCIResult($row_count,3);

		     	 		echo "<tr>";
			     		echo "<td>";
			     		echo $firstcol;
			     		echo "</td>";
			     		echo "<td>";
			     		echo $secondcol;
			     		echo "</td>";
			     		echo "<td>";
			     		echo $summarycol;
			     		echo "</td>";
			     		echo "</tr>";
		     	 	}
		     	 	OCIFreeStatement($row_count);
				}
				//user selects column choice as primary study field
			}
			else
			{
				$query = "SELECT \"$rowdispname\", \"$coldispname\",\"$sumdispname\" FROM
					( SELECT R.$rowfieldname AS \"$rowdispname\",
					C.$colfieldname AS \"$coldispname\",
					ROUND($sumagg,2) AS \"$sumdispname\",
					RANK () OVER( ORDER BY ROUND($sumagg,2)DESC) AS RankI,
					COUNT(*) OVER() AS COUNTI
					FROM $sumtablename F, $coltablename C, $rowtablename R
					WHERE C.$coltableid = F.$coltableid AND
					R.$rowtableid = F.$rowtableid
					GROUP BY (R.$rowfieldname, C.$colfieldname))
					WHERE RankI<$num*COUNTI";
					
					echo "<th>";
			     		echo $rowdispname;
			     		echo "</th>";
			     		echo "<th>";
			     		echo $coldispname;
			     		echo "</th>";
			     		echo "<th>";
			     		echo $sumdispname;
			     		echo "</th>";
						
					
				echo "</tr></thead><tbody>";
				
				if(!$query)
				{
					die("Query failed");
				}
				else
				{
					
					$row_count=OCIParse($c,$query);

		     	 	$test = OCIExecute($row_count);
		     	 

		     	 	while(OCIFetch($row_count))
		     	 	{
		     	 		 
		     	 		$firstcol = OCIResult($row_count,1);
		     	 		$secondcol = OCIResult($row_count,2);
		     	 		$summarycol = OCIResult($row_count,3);

		     	 		echo "<tr>";
			     		echo "<td>";
			     		echo $firstcol;
			     		echo "</td>";
			     		echo "<td>";
			     		echo $secondcol;
			     		echo "</td>";
			     		echo "<td>";
			     		echo $summarycol;
			     		echo "</td>";
			     		echo "</tr>";
		     	 	}
		     	 	OCIFreeStatement($row_count);
				}
			}


		}
		else
		{
			echo "invalid choice";
		}
		
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