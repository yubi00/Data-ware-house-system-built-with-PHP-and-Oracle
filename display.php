<!DOCTYPE html>
<html lang="en">
<head>
  <title>Tertiary Admission Centre</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script type="text/javascript">
	  $(document).ready(function(){

		 $('#topn').hide();
		  $('#topk').hide();

		 $('#topnradio').on('change', function(){
			  $('#topn').show();
			 $('#topk').hide();
		 })
		 
		 $('#topkradio').on('change', function(){
			  $('#topk').show();
			 $('#topn').hide();
		 })

     $('#showall').on('change', function(){
        $('#topk').hide();
       $('#topn').hide();
     })
	  });
	
	</script>
	<style>
    div.row {
    margin-left: 50px;
    margin-bottom: 25px;
}
</style>
	
</head>
<body>

<div class="jumbotron text-center">
  <h1>Tertiary Admission Centre</h1>
  
</div>
  
<div class="container">
  <form action="displayResult.php" method=GET>
  <div class="row">
    <div class="col-sm-4">
      <h3>Row </h3>
       <select name="rowChoice">
            <option selected="true" disabled="disabled">Choose row</option>  
            <option value="Courses_Dim/CourseID/CourseTitle/Course Title">Courses</option>
            <option value="Institutions_Dim/InstID/InstName/Institution">Instituition</option>
            <option value="Campuses_Dim/CampusID/CampusName/Campus">Campus</option>
            <option value="Gender_Dim/GenderID/GenderDesc/Gender">Student Gender</option>
            <option value="isYear12_Dim/Year12ID/Year12Desc/isYear12">IsYear12Student</option>
            <option value="StudyMethod_Dim/MethodID/Method_Desc/Study Method">Course Study Method (F/T or P/T)</option>
            <option value="Qualifications_Dim/QualifID/QualifName/Qualification">Qualification</option>
            <option value="InstituteType_Dim/InstType/InstType/Instituition Type">InstituitionType</option>
            <option value="primarystudyfield">Primary Study Field</option>
            <option value="suppstudyfield">Supplementary Study Field</option>
            <option value="FeeTypes_Dim/FeeTypeId/FeeTypeName/Fee Type">Fees Type</option>
            <option value="Pref_Rank_Dim/RankID/Rank_Desc/Rank">Preference Rank</option>
            <option value="Appdate_Dim/AppYear/AppYear/Application Year">Application Date</option>
         </select>
    </div>
    <div class="col-sm-4">
      <h3>Column </h3>
      <select name="columnChoice">
        <option selected="true" disabled="disabled">Choose column</option>  
           <option value="Courses_Dim/CourseID/CourseTitle/Course Title">Courses</option>
            <option value="Institutions_Dim/InstID/InstName/Institution">Instituition</option>
            <option value="Campuses_Dim/CampusID/CampusName/Campus">Campus</option>
            <option value="Gender_Dim/GenderID/GenderDesc/Gender">Student Gender</option>
            <option value="isYear12_Dim/Year12ID/Year12Desc/isYear12">IsYear12Student</option>
            <option value="StudyMethod_Dim/MethodID/Method_Desc/Study Method">Course Study Method (F/T or P/T)</option>
            <option value="Qualifications_Dim/QualifID/QualifName/Qualification">Qualification</option>
            <option value="InstituteType_Dim/InstType/InstType/Instituition Type">InstituitionType</option>
            <option value="primarystudyfield">Primary Study Field</option>
            <option value="suppstudyfield">Supplementary Study Field</option>
            <option value="FeeTypes_Dim/FeeTypeId/FeeTypeName/Fee Type">Fees Type</option>
            <option value="Pref_Rank_Dim/RankID/Rank_Desc/Rank">Preference Rank</option>
            <option value="Appdate_Dim/AppYear/AppYear/Application Year">Application Date</option>
         </select>
    </div>
    <div class="col-sm-4">
      <h3>Summary</h3>        
     <select name="summaryVariable">
      <option selected="true" disabled="disabled">Choose summary</option>  
            <option value="TAC_Fact/SUM(TNA)/Total Number of Applicants">Total Number of Applicants</option>
            <option value="TAC_Fact/SUM(TSC)/Total Student Contribution">Total Student Contribution</option>
            <option value="TAC_Fact/SUM(TIR)/Total Instituitional Revenue">Total Instituitional Revenue</option>
            <option value="TAC_Fact/AVGATAR/Avergae Student ATAR">Average Student ATAR</option> 
         </select>  
    </div>
  </div>
  <div class="row">
    	<h3>Choose one: </h3>
    	<input type="radio" name="resultselection" value="showall" id="showall" checked> Show All &nbsp;&nbsp;&nbsp;&nbsp;
	  	<input type="radio" name="resultselection" id="topkradio" value="topk"> Top k menu &nbsp;&nbsp;&nbsp;&nbsp;
	  	<select id="topk" name="topk">
        <option selected="true" disabled="disabled">Choose topk</option>  
		  <option value="top3">Top 3</option>
		  <option value="top5">Top 5</option>
		  <option value="top10">Top 10</option>
		</select>
	  	<input type="radio" name="resultselection" id="topnradio" value="topn"> Top n% menu	
	  	<select id="topn" name="topn">
        <option selected="true" disabled="disabled">Choose topn%</option>  
		  <option value="top10p">Top 10%</option>
		  <option value="top25p">Top 25%</option>
		  <option value="top50p">Top 50%</option>
		</select>
    </div>
    <br/>
    
     <div class="row" style="text-align: left;">
      <input type="submit" class="btn btn-info" value="Submit" id="submit">   
    </div>

	</form>
  <div style="margin-top: 50px;margin-left: 50px;">
  <h3>Generate Report</h3>
   <a href="report1.php" style="padding-left: 20px;">Report1: Total Institutional Revenue Report</a>
  <a href="report2.php" style="padding-left: 20px;">Report2: Student ATAR Report</a>
  <a href="report3.php" style="padding-left: 20px;">Report3: Student Application Report</a>
  </div>
 <div style="margin-top: 50px;margin-left: 50px;">
  <h3>Additional Report</h3>
   <a href="report4.php" style="padding-left: 20px;">Report4: Temporal database1</a>
  <a href="report5.php" style="padding-left: 20px;">Report5: Temporal database2</a>
  
  </div>
 
</div>

</body>
</html>


