<?php

	/*
	* Copyright (C) 2016-2018 Abre.io Inc.
	*
	* This program is free software: you can redistribute it and/or modify
    * it under the terms of the Affero General Public License version 3
    * as published by the Free Software Foundation.
	*
    * This program is distributed in the hope that it will be useful,
    * but WITHOUT ANY WARRANTY; without even the implied warranty of
    * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    * GNU Affero General Public License for more details.
	*
    * You should have received a copy of the Affero General Public License
    * version 3 along with this program.  If not, see https://www.gnu.org/licenses/agpl-3.0.en.html.
    */

	//Required configuration files
	require(dirname(__FILE__) . '/../../configuration.php');
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once('functions.php');
	//Filter admin results by access buildings
	$query = "SELECT SchoolCode FROM Abre_Staff WHERE EMail1='".$_SESSION['useremail']."'";
	$dbreturn = databasequery($query);
	$buildingfilter = "SchoolCode=''";
	foreach ($dbreturn as $value)
	{
		$AdminSchoolCode = htmlspecialchars($value["SchoolCode"], ENT_QUOTES);
		$buildingfilter = "$buildingfilter OR  SchoolCode='$AdminSchoolCode'";
	}
	if(admin())
	{
		$buildingfilter = "SchoolCode='' OR  SchoolCode = 'HA' OR  SchoolCode = 'HABP' OR  SchoolCode = 'HABW' OR  SchoolCode = 'HACW' OR  SchoolCode = 'HAFS' OR  SchoolCode = 'HAFW' OR  SchoolCode = 'HAGA' OR  SchoolCode = 'HAHL' OR  SchoolCode = 'HAHS' OR  SchoolCode = 'HALN' OR  SchoolCode = 'HARV' OR  SchoolCode = 'HARW' OR  SchoolCode = 'HAWI'";
	}
	if(admin() or conductAdminCheck($_SESSION['useremail']))
	{
		$useremailaccess = "";
	}
	else
	{
		$useremailaccess = "and Owner='".$_SESSION['useremail']."'";
	}
	if(isset($_POST["conductsearch"])){ $ConductSearch = mysqli_real_escape_string($db, $_POST["conductsearch"]); }else{ $ConductSearch = ""; }
	if(isset($_POST["conductfrom"])){ $ConductFrom = mysqli_real_escape_string($db, $_POST["conductfrom"]); $ConductFrom = str_replace('/', '-', $ConductFrom); }else{ $ConductFrom=""; }
	if(isset($_POST["conductthru"])){ $ConductThur = mysqli_real_escape_string($db, $_POST["conductthru"]); $ConductThur = str_replace('/', '-', $ConductThur); }else{ $ConductThur=""; }
	if(isset($_POST["page"])){ $PageNumber = $_POST["page"]; if($PageNumber == ""){ $PageNumber = 1; } }else{ $PageNumber = 1; }
	if(isset($_POST["sort"]) && $_POST["sort"] != ""){ $PageSort = $_POST["sort"]; }else{ $PageSort = "conduct_discipline.Submission_Time"; }
	if(isset($_POST["method"])){ $SortMethod = $_POST["method"]; }else{ $SortMethod = "ASC"; }
	if($SortMethod == "DESC"){ $SortMethod = "ASC"; }else{ $SortMethod = "DESC"; }

	$PerPage = 50;

	$LowerBound = $PerPage*($PageNumber-1);
	$UpperBound = $PerPage*$PageNumber;

	if($ConductFrom != "" && $ConductThur != ""){
		$querycount = "SELECT * FROM conduct_discipline LEFT JOIN conduct_discipline_consequences ON conduct_discipline.ID = conduct_discipline_consequences.Incident_ID WHERE ((conduct_discipline.Type = 'Office' $useremailaccess AND conduct_discipline.Served = '1' AND ($buildingfilter)) OR (conduct_discipline.Type = 'Personal' AND conduct_discipline.Owner = '".$_SESSION['useremail']."' AND conduct_discipline.Served = '1') OR (conduct_discipline.Type = 'Office' AND conduct_discipline.Served = '1' AND conduct_discipline.Owner = '".$_SESSION['useremail']."')) AND (conduct_discipline.Type LIKE '%$ConductSearch%' OR conduct_discipline.Building LIKE '%$ConductSearch%' OR conduct_discipline.Student_LastName LIKE '%$ConductSearch%' OR conduct_discipline.StudentID LIKE '%$ConductSearch%' OR conduct_discipline.Offence LIKE '%$ConductSearch%' OR conduct_discipline.Location LIKE '%$ConductSearch%' OR conduct_discipline_consequences.Consequence_Name LIKE '%$ConductSearch%' OR conduct_discipline.Owner_Name LIKE '%$ConductSearch%') AND (conduct_discipline.Submission_Time BETWEEN '$ConductFrom' AND '$ConductThur' AND conduct_discipline.Archived='0') GROUP BY conduct_discipline.ID";
		$query = "SELECT * FROM conduct_discipline LEFT JOIN conduct_discipline_consequences ON conduct_discipline.ID = conduct_discipline_consequences.Incident_ID WHERE ((conduct_discipline.Type = 'Office' $useremailaccess AND conduct_discipline.Served = '1' AND ($buildingfilter)) OR (conduct_discipline.Type = 'Personal' AND conduct_discipline.Owner = '".$_SESSION['useremail']."' AND conduct_discipline.Served = '1') OR (conduct_discipline.Type = 'Office' AND conduct_discipline.Served = '1' AND conduct_discipline.Owner = '".$_SESSION['useremail']."')) AND (conduct_discipline.Type LIKE '%$ConductSearch%' OR conduct_discipline.Building LIKE '%$ConductSearch%' OR conduct_discipline.Student_LastName LIKE '%$ConductSearch%' OR conduct_discipline.StudentID LIKE '%$ConductSearch%' OR conduct_discipline.Offence LIKE '%$ConductSearch%' OR conduct_discipline.Location LIKE '%$ConductSearch%' OR conduct_discipline_consequences.Consequence_Name LIKE '%$ConductSearch%' OR conduct_discipline.Owner_Name LIKE '%$ConductSearch%') AND (conduct_discipline.Submission_Time BETWEEN '$ConductFrom' AND '$ConductThur' AND conduct_discipline.Archived='0') GROUP BY conduct_discipline.ID ORDER BY $PageSort $SortMethod LIMIT $LowerBound, $PerPage";
	}
	if($ConductFrom == "" && $ConductThur == ""){
		$querycount = "SELECT * FROM conduct_discipline LEFT JOIN conduct_discipline_consequences ON conduct_discipline.ID = conduct_discipline_consequences.Incident_ID WHERE ((conduct_discipline.Type = 'Office' $useremailaccess AND conduct_discipline.Served = '1' AND ($buildingfilter)) OR (conduct_discipline.Type = 'Personal' AND conduct_discipline.Owner = '".$_SESSION['useremail']."' AND conduct_discipline.Served = '1') OR (conduct_discipline.Type = 'Office' AND conduct_discipline.Served = '1' AND conduct_discipline.Owner = '".$_SESSION['useremail']."')) AND (conduct_discipline.Type LIKE '%$ConductSearch%' OR conduct_discipline.Building LIKE '%$ConductSearch%' OR conduct_discipline.Student_LastName LIKE '%$ConductSearch%' OR conduct_discipline.StudentID LIKE '%$ConductSearch%' OR conduct_discipline.Offence LIKE '%$ConductSearch%' OR conduct_discipline.Location LIKE '%$ConductSearch%' OR conduct_discipline_consequences.Consequence_Name LIKE '%$ConductSearch%' OR conduct_discipline.Owner_Name LIKE '%$ConductSearch%') AND conduct_discipline.Archived = '0' GROUP BY conduct_discipline.ID";
		$query = "SELECT * FROM conduct_discipline LEFT JOIN conduct_discipline_consequences ON conduct_discipline.ID = conduct_discipline_consequences.Incident_ID WHERE ((conduct_discipline.Type = 'Office' $useremailaccess AND conduct_discipline.Served = '1' AND ($buildingfilter)) OR (conduct_discipline.Type = 'Personal' AND conduct_discipline.Owner = '".$_SESSION['useremail']."' AND conduct_discipline.Served = '1') OR (conduct_discipline.Type = 'Office' AND conduct_discipline.Served = '1' AND conduct_discipline.Owner = '".$_SESSION['useremail']."')) AND (conduct_discipline.Type LIKE '%$ConductSearch%' OR conduct_discipline.Building LIKE '%$ConductSearch%' OR conduct_discipline.Student_LastName LIKE '%$ConductSearch%' OR conduct_discipline.StudentID LIKE '%$ConductSearch%' OR conduct_discipline.Offence LIKE '%$ConductSearch%' OR conduct_discipline.Location LIKE '%$ConductSearch%' OR conduct_discipline_consequences.Consequence_Name LIKE '%$ConductSearch%' OR conduct_discipline.Owner_Name LIKE '%$ConductSearch%') AND conduct_discipline.Archived = '0' GROUP BY conduct_discipline.ID ORDER BY $PageSort $SortMethod LIMIT $LowerBound, $PerPage";
	}
	if($ConductFrom != "" && $ConductThur == ""){
		$querycount = "SELECT * FROM conduct_discipline LEFT JOIN conduct_discipline_consequences ON conduct_discipline.ID = conduct_discipline_consequences.Incident_ID WHERE ((conduct_discipline.Type = 'Office' $useremailaccess AND conduct_discipline.Served = '1' AND ($buildingfilter)) OR (conduct_discipline.Type = 'Personal' AND conduct_discipline.Owner = '".$_SESSION['useremail']."' AND conduct_discipline.Served = '1') OR (conduct_discipline.Type = 'Office' AND conduct_discipline.Served = '1' AND conduct_discipline.Owner = '".$_SESSION['useremail']."')) AND (conduct_discipline.Type LIKE '%$ConductSearch%' OR conduct_discipline.Building LIKE '%$ConductSearch%' OR conduct_discipline.Student_LastName LIKE '%$ConductSearch%' OR conduct_discipline.StudentID LIKE '%$ConductSearch%' OR conduct_discipline.Offence LIKE '%$ConductSearch%' OR conduct_discipline.Location LIKE '%$ConductSearch%' OR conduct_discipline_consequences.Consequence_Name LIKE '%$ConductSearch%' OR conduct_discipline.Owner_Name LIKE '%$ConductSearch%') AND (conduct_discipline.Submission_Time > '$ConductFrom' AND conduct_discipline.Archived = '0') GROUP BY conduct_discipline.ID";
		$query = "SELECT * FROM conduct_discipline LEFT JOIN conduct_discipline_consequences ON conduct_discipline.ID = conduct_discipline_consequences.Incident_ID WHERE ((conduct_discipline.Type = 'Office' $useremailaccess AND conduct_discipline.Served = '1' AND ($buildingfilter)) OR (conduct_discipline.Type = 'Personal' AND conduct_discipline.Owner = '".$_SESSION['useremail']."' AND conduct_discipline.Served = '1') OR (conduct_discipline.Type = 'Office' AND conduct_discipline.Served = '1' AND conduct_discipline.Owner = '".$_SESSION['useremail']."')) AND (conduct_discipline.Type LIKE '%$ConductSearch%' OR conduct_discipline.Building LIKE '%$ConductSearch%' OR conduct_discipline.Student_LastName LIKE '%$ConductSearch%' OR conduct_discipline.StudentID LIKE '%$ConductSearch%' OR conduct_discipline.Offence LIKE '%$ConductSearch%' OR conduct_discipline.Location LIKE '%$ConductSearch%' OR conduct_discipline_consequences.Consequence_Name LIKE '%$ConductSearch%' OR conduct_discipline.Owner_Name LIKE '%$ConductSearch%') AND (conduct_discipline.Submission_Time > '$ConductFrom' AND conduct_discipline.Archived = '0') GROUP BY conduct_discipline.ID ORDER BY $PageSort $SortMethod LIMIT $LowerBound, $PerPage";
	}
	if($ConductFrom == "" && $ConductThur != ""){
		$querycount = "SELECT * FROM conduct_discipline LEFT JOIN conduct_discipline_consequences ON conduct_discipline.ID = conduct_discipline_consequences.Incident_ID WHERE ((conduct_discipline.Type = 'Office' $useremailaccess AND conduct_discipline.Served = '1' AND ($buildingfilter)) OR (conduct_discipline.Type = 'Personal' AND conduct_discipline.Owner = '".$_SESSION['useremail']."' AND conduct_discipline.Served = '1') OR (conduct_discipline.Type = 'Office' AND conduct_discipline.Served = '1' AND conduct_discipline.Owner = '".$_SESSION['useremail']."')) AND (conduct_discipline.Type LIKE '%$ConductSearch%' OR conduct_discipline.Building LIKE '%$ConductSearch%' OR conduct_discipline.Student_LastName LIKE '%$ConductSearch%' OR conduct_discipline.StudentID LIKE '%$ConductSearch%' OR conduct_discipline.Offence LIKE '%$ConductSearch%' OR conduct_discipline.Location LIKE '%$ConductSearch%' OR conduct_discipline_consequences.Consequence_Name LIKE '%$ConductSearch%' OR conduct_discipline.Owner_Name LIKE '%$ConductSearch%') AND (conduct_discipline.Submission_Time < '$ConductThur' AND conduct_discipline.Archived = '0') GROUP BY conduct_discipline.ID";
		$query = "SELECT * FROM conduct_discipline LEFT JOIN conduct_discipline_consequences ON conduct_discipline.ID = conduct_discipline_consequences.Incident_ID WHERE ((conduct_discipline.Type = 'Office' $useremailaccess AND conduct_discipline.Served = '1' AND ($buildingfilter)) OR (conduct_discipline.Type = 'Personal' AND conduct_discipline.Owner = '".$_SESSION['useremail']."' AND conduct_discipline.Served = '1') OR (conduct_discipline.Type = 'Office' AND conduct_discipline.Served = '1' AND conduct_discipline.Owner = '".$_SESSION['useremail']."')) AND (conduct_discipline.Type LIKE '%$ConductSearch%' OR conduct_discipline.Building LIKE '%$ConductSearch%' OR conduct_discipline.Student_LastName LIKE '%$ConductSearch%' OR conduct_discipline.StudentID LIKE '%$ConductSearch%' OR conduct_discipline.Offence LIKE '%$ConductSearch%' OR conduct_discipline.Location LIKE '%$ConductSearch%' OR conduct_discipline_consequences.Consequence_Name LIKE '%$ConductSearch%' OR conduct_discipline.Owner_Name LIKE '%$ConductSearch%') AND (conduct_discipline.Submission_Time < '$ConductThur' AND conduct_discipline.Archived = '0') GROUP BY conduct_discipline.ID ORDER BY $PageSort $SortMethod LIMIT $LowerBound, $PerPage";
	}

	$dbreturn = databasequery($query);
	$totalresults = count($dbreturn);
	$dbreturnpossible = databasequery($querycount);
	$totalpossibleresults = count($dbreturnpossible);

	$resultcounter = 0;
	foreach ($dbreturn as $value){
		if($resultcounter == 0){
			echo "<div class='page_container mdl-shadow--4dp'>";
			echo "<div class='page'>";
			echo "<div class='row'><div class='col s12'>";
			echo "<table id='myTable' class='tablesorter striped'>";
			echo "<thead>";
			echo "<tr class='pointer'>";
			echo "<th class='sortbuttonclosed' data-sort='Submission_Time' data-sortmethod='$SortMethod' width='250px'>Submission</th>";
			echo "<th class='sortbuttonclosed' data-sort='Student_LastName' data-sortmethod='$SortMethod'>Student</th>";
			echo "<th class='sortbuttonclosed' data-sort='Offence' data-sortmethod='$SortMethod'>Offense</th>";
			echo "<th class='sortbuttonclosed' data-sort='Owner_Name' data-sortmethod='$SortMethod'>Submitter</th>";
			echo "<th class='sortbuttonclosed' data-sort='Type' data-sortmethod='$SortMethod'>Type</th>";
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
		}
		$SubmissionID = htmlspecialchars($value["ID"], ENT_QUOTES);
		$Submission_Time = htmlspecialchars($value["Submission_Time"], ENT_QUOTES);
		$Student_FirstName = htmlspecialchars($value["Student_FirstName"], ENT_QUOTES);
		$Student_MiddleName = htmlspecialchars($value["Student_MiddleName"], ENT_QUOTES);
		$Student_LastName = htmlspecialchars($value["Student_LastName"], ENT_QUOTES);
		$Incident_Date = htmlspecialchars($value["Incident_Date"], ENT_QUOTES);
		$Incident_Time = htmlspecialchars($value["Incident_Time"], ENT_QUOTES);
		$Type = htmlspecialchars($value["Type"], ENT_QUOTES);
		$StudentID = htmlspecialchars($value["StudentID"], ENT_QUOTES);
		$StudentIEP = htmlspecialchars($value["Student_IEP"], ENT_QUOTES);
		$SchoolCode = htmlspecialchars($value["SchoolCode"], ENT_QUOTES);
		$Building = htmlspecialchars($value["Building"], ENT_QUOTES);
		$Type = htmlspecialchars($value["Type"], ENT_QUOTES);
		$Offence = htmlspecialchars($value["Offence"], ENT_QUOTES);
		$Location = htmlspecialchars($value["Location"], ENT_QUOTES);
		$Description = htmlspecialchars($value["Description"], ENT_QUOTES);
		$Information = htmlspecialchars($value["Information"], ENT_QUOTES);
		$Owner_Name = htmlspecialchars($value["Owner_Name"], ENT_QUOTES);
    $dupIncidentId = htmlspecialchars($value["dupIncidentId"], ENT_QUOTES);
		$Offence_Display = str_replace(array("'", "\"", "&quot;"), "", $Offence);

		//find all consequences that have that the same id as the incident found
		//and push their values to an array that will later construct a comma
		//separated string. If there are no entries, return an empty string automatically
		$query = "SELECT Consequence_ID, Consequence_Name, Serve_Date, Thru_Date, Total_Days, Consequence_Served FROM conduct_discipline_consequences WHERE Incident_ID = '$SubmissionID'";
		$dbreturn2 = databasequery($query);
		if(count($dbreturn2) == 0 ){
		  $Consequence = '';
		  $Serve_Date = '';
		  $Thru_Date = '';
		  $Total_Days = '';
			$Consequence_ID = '';
			$Consequence_Served = '';
		}else{
			$consequenceIDArray = array();
			$consequenceArray = array();
			$serveArray = array();
			$thruArray = array();
			$daysArray = array();
			$consequenceServedArray = array();
		  foreach($dbreturn2 as $value2){
				array_push($consequenceIDArray, htmlspecialchars($value2["Consequence_ID"], ENT_QUOTES));
		    array_push($consequenceArray, htmlspecialchars($value2["Consequence_Name"], ENT_QUOTES));
		    array_push($serveArray, htmlspecialchars($value2["Serve_Date"], ENT_QUOTES));
		    array_push($thruArray, htmlspecialchars($value2["Thru_Date"], ENT_QUOTES));
		    array_push($daysArray, htmlspecialchars($value2["Total_Days"], ENT_QUOTES));
				array_push($consequenceServedArray, htmlspecialchars($value2["Consequence_Served"], ENT_QUOTES));
		  }
			//construct the comma separated string
			$Consequence = implode(",", $consequenceArray);
			$Serve_Date = implode(",", $serveArray);
			$Thru_Date = implode(",", $thruArray);
			$Total_Days = implode(",", $daysArray);
			$Consequence_ID = implode(",", $consequenceIDArray);
			$Consequence_Served = implode(",", $consequenceServedArray);
		}

		$Submission_Time_Date = date( "M jS, Y", strtotime($Submission_Time));
		$Submission_Time_Time = date( "g:iA", strtotime($Submission_Time));
		$Submission_Time = "$Submission_Time_Date at $Submission_Time_Time";

		echo "<tr class='incidentdetails pointer' data-studentname='$Student_FirstName $Student_LastName' data-type='$Type' data-offence='$Offence' data-location='$Location' data-description='$Description' data-information='$Information' data-studentid='$StudentID' data-studentiep='$StudentIEP' data-studentbuilding='$Building' data-studentcode='$SchoolCode' data-submissionid='$SubmissionID' data-consequence='$Consequence' data-incidentdate='$Incident_Date' data-incidenttime='$Incident_Time' data-served='$Consequence_Served' data-owner='$Owner_Name' data-servedate='$Serve_Date' data-thrudate='$Thru_Date' data-totaldays='$Total_Days' data-consequenceid='$Consequence_ID' data-firstname='$Student_FirstName' data-lastname='$Student_LastName' data-middlename='$Student_MiddleName' data-dupincidentid = '$dupIncidentId' data-reload='closed'>";
		echo "<td>$Submission_Time</td>";
		echo "<td>$Student_LastName, $Student_FirstName</td>";
		echo "<td>$Offence_Display</td>";
		echo "<td>$Owner_Name</td>";
		echo "<td>$Type</td>";
		echo "</tr>";

		$resultcounter++;
		if($totalresults == $resultcounter){
			echo "</tbody>";
			echo "</table>";
			echo "</div>";
			echo "</div>";
			//Paging
			$totalpages = ceil($totalpossibleresults / $PerPage);
			if($totalpossibleresults > $PerPage){
				$previouspage = $PageNumber - 1;
				$nextpage = $PageNumber + 1;
				if($PageNumber > 5){
					if($totalpages > $PageNumber + 5){
						$pagingstart = $PageNumber - 5;
						$pagingend = $PageNumber + 5;
					}else{
						$pagingstart = $PageNumber - 5; $pagingend = $totalpages;
					}
				}else{
					if($totalpages >= 10){ $pagingstart = 1; $pagingend = 10; }else{ $pagingstart = 1; $pagingend = $totalpages; }
				}
				echo "<div class='row'><br>";
				echo "<ul class='pagination center-align'>";
					if($PageNumber != 1){ echo "<li class='pagebuttonclosed' data-page='$previouspage' data-sort='$PageSort' data-sortmethod='$SortMethod'><a href='#'><i class='material-icons'>chevron_left</i></a></li>"; }
					for ($x = $pagingstart; $x <= $pagingend; $x++){
						if($PageNumber == $x){
							echo "<li class='active pagebuttonclosed' style='background-color: ".getSiteColor().";' data-page='$x'><a href='#'>$x</a></li>";
						}else{
							echo "<li class='waves-effect pagebuttonclosed' data-page='$x' data-sort='$PageSort' data-sortmethod='$SortMethod'><a href='#'>$x</a></li>";
						}
					}
					if($PageNumber != $totalpages){ echo "<li class='waves-effect pagebuttonclosed' data-page='$nextpage' data-sort='$PageSort' data-sortmethod='$SortMethod'><a href='#'><i class='material-icons'>chevron_right</i></a></li>"; }
				echo "</ul>";
				echo "</div>";
			}
			echo "</div>";
		}
	}
	if($totalresults == 0){
		echo "<div style='padding:56px; text-align:center; width:100%;'><span style='font-size: 22px; font-weight:700'>No Closed Incidents</span><br><p style='font-size:16px; margin:20px 0 0 0;'>Click the '+' in the bottom right to create an incident.</p></div>";
	}
	require "button_discipline.php";
?>

<script>

	$(function(){
		//Choose Student and Send to Modal
		$( ".incidentdetails" ).unbind().click(function(){
			event.preventDefault();
			var Student_ID = $(this).data('studentid');
			$("#Incident_Student_ID").val(Student_ID);
			//Hide Fields
			var d = new Date();
			for(var i = 0; i < 8; i++){
				$("#Consequence"+i).val("");
				$("#NumberOfDaysServed"+i).val("");
				$('#servedCheckbox'+i).prop('checked',false);
				$('#pdfOption'+i).val("");
				$("#"+i).hide();
				$("#"+i).addClass("toAdd");
			}
			$("#conduct_search").hide();
			$("#searchresults").hide();
			$("#conduct_footer").show();
			$("#conduct_consequence").show();
			$(".pdfOption").val("");
			$('#studentsearch').prop('required',false);

			//Fill Fields
			var Reload = $(this).data('reload');
			$("#Incident_Reload").val(Reload);
			var StudentName = $(this).data('studentname');
			<?php if(file_exists("$portal_path_root/modules/Abre-Students/setup.txt")){ ?>
								$("#conducttitle").html(StudentName+' <a class="modal-studentlook" data-studentid="'+Student_ID+'" href="#studentlook" style="color:#fff;"><i class="material-icons">remove_red_eye</i></a>');
			<?php }else{ ?>
								$("#conducttitle").html(StudentName);
			<?php } ?>
			var Owner = $(this).data('owner');
			$("#conductsubtitle").html('Submitted by: '+Owner);
			var StudentIEP = $(this).data('studentiep');
			if(StudentIEP == "Y"){
				$("#conducttags").html("<div class='chip'>IEP</div>");
			}else{
				$("#conducttags").html("");
			}
			var Offence = $(this).data('offence');
			if(Offence != ""){
				var Offence_String = String(Offence);
				if( Offence_String.indexOf(',') >= 0){
					var dataarray = Offence.split(/,(?=(?:(?:[^"]*"){2})*[^"]*$)/);
					for(var i = 0; i < dataarray.length; i++){
						dataarray[i] = dataarray[i].replace(/["']/g, "").trim();
					}
					$("#Offence").val(dataarray);
				}else{
					$("#Offence").val(Offence_String.replace(/["']/g, ""));
				}
			}else{
				$("#Offence").val('');
			}
			var Location = $(this).data('location');
			$("#Location").val(Location);
			var Description = $(this).data('description');
			$("#Description").val(Description);
			var Information = $(this).data('information');
			$("#Information").val(Information);
			var Type = $(this).data('type');
			if(Type === "Office"){ $('#office').prop('checked',true); }
			if(Type === "Personal"){ $('#personal').prop('checked',true); }
			<?php if(conductAdminCheck($_SESSION['useremail']) || admin()){ ?> $('#archiveIncident').show(); <?php } ?>

			//Fill Hidden Fields
			var Submission_ID = $(this).data('submissionid');
			$("#Incident_ID").val(Submission_ID);
			var Student_Building = $(this).data('studentbuilding');
			$("#Incident_Student_Building").val(Student_Building);
			var Student_Code = $(this).data('studentcode');
			$("#Incident_Student_Code").val(Student_Code);
			var IncidentDate = $(this).data('incidentdate');
			var picker = $('#IncidentDate').pickadate('picker');
			picker.set('select', IncidentDate);
			var IncidentTime = $(this).data('incidenttime');
			$("#IncidentTime").val(IncidentTime);
			var StudentFirstName = $(this).data('firstname');
			$("#Incident_Student_FirstName").val(StudentFirstName);
			var StudentMiddleName = $(this).data('middlename');
			$("#Incident_Student_MiddleName").val(StudentMiddleName);
			var StudentLastName = $(this).data('lastname');
			$("#Incident_Student_LastName").val(StudentLastName);
      var dupIncidentId = $(this).data('dupincidentid');
      $("#dupIncidentId").val(dupIncidentId);

			//split the comma separated strings that are stored on row element
			//for each consequence that isnt null fill in the corresponding fields
			var ConsequencesID = $(this).data('consequenceid').toString().split(",");
			var Consequences = $(this).data('consequence').split(",");
			var Serve_Date = $(this).data('servedate').split(",");
			var Thru_Date = $(this).data('thrudate').split(",");
			var Total_Days = $(this).data('totaldays').toString().split(",");
			var Served= $(this).data('served').toString().split(",");
			for(var i = 0; i < 8; i++){
				if(Consequences[i] != null){
					$("#Consequence_ID"+i).val(ConsequencesID[i]);
					$("#Consequence"+i).val(Consequences[i]);
					if(Consequences[i] != ""){
						var picker = $('#ServeDate'+i).pickadate('picker');
						picker.set('select', Serve_Date[i]);
						var picker = $('#ThruDate'+i).pickadate('picker');
						picker.set('select', Thru_Date[i]);
					}
					$("#NumberOfDaysServed"+i).val(Total_Days[i]);
					if(Served[i] == 1){ $('#servedCheckbox'+i).prop('checked',true); }
					$("#"+i).show();
					$("#"+i).removeClass("toAdd");
				}
			}
			if(Consequences[7] != null ){
				$("#addconsequencebutton").hide();
			}else{
				$("#addconsequencebutton").show();
			}

			//post to get previous offences for student. The previous offences will not include the selected
			//incident.
			$.ajax({
				type: 'POST',
				url: 'modules/Abre-Conduct/getOffences.php',
				data: {studentid: Student_ID, submissionID: Submission_ID }
			})
			.done(function(response) {
				$('#previousOffences').html(response);
			});

			//Disable the Fields
			<?php
			if(!admin() && !conductAdminCheck($_SESSION['useremail']))
			{
			?>
				if(Type=="Office"){
					$("#setTimeButton").hide();
					$("#conduct_footer").hide();
					$("input[name=Type]").prop("disabled", true);
					$("#Offence").prop("disabled", true);
					$("#Location").prop("disabled", true);
					$("#Description").prop("disabled", true);
					$("#Information").prop("disabled", true);
					$("#IncidentDate").prop("disabled", true);
					$(".ServeDate").prop("disabled", true);
					$(".ThruDate").prop("disabled", true);
					$(".NumberOfDaysServed").prop("disabled", true);
					$("#IncidentTime").prop("disabled", true);
					$("#conductserved").prop("disabled", true);
					$(".Consequence").prop("disabled", true);
				}else{
					$("#setTimeButton").show();
					$("#conduct_footer").show();
					$("input[name=Type]").prop("disabled", false);
					$("#Offence").prop("disabled", false);
					$("#Location").prop("disabled", false);
					$("#Description").prop("disabled", false);
					$("#Information").prop("disabled", false);
					$("#IncidentDate").prop("disabled", false);
					$(".ServeDate").prop("disabled", false);
					$(".ThruDate").prop("disabled", false);
					$(".NumberOfDaysServed").prop("disabled", false);
					$("#IncidentTime").prop("disabled", false);
					$("#conductserved").prop("disabled", false);
					$(".Consequence").prop("disabled", false);
					$(".pdfOption").prop("disabled", true);
				}
			<?php
			}
			?>

			//Update Material
			$('select').material_select();
			Materialize.updateTextFields();
			$('#conductincident').openModal({ in_duration: 0, out_duration: 0, ready: function() { $('.modal-content').scrollTop(0); } });

		});
	});

</script>