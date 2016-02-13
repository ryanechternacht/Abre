<?php
	
	/*
	* Copyright 2015 Hamilton City School District	
	* 		
	* This program is free software: you can redistribute it and/or modify
    * it under the terms of the GNU General Public License as published by
    * the Free Software Foundation, either version 3 of the License, or
    * (at your option) any later version.
	* 
    * This program is distributed in the hope that it will be useful,
    * but WITHOUT ANY WARRANTY; without even the implied warranty of
    * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    * GNU General Public License for more details.
	* 
    * You should have received a copy of the GNU General Public License
    * along with this program.  If not, see <http://www.gnu.org/licenses/>.
    */
	
	//Configuration
	require(dirname(__FILE__) . '/../../configuration.php'); 
	
	//Login Validation
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php'); 
	
	require_once('permissions.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php'); 
	
	if($pageaccess==1)
	{	
	
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=data.csv');
		
		$output = fopen('php://output', 'w');
		
		fputcsv($output, array('Picture', 'First Name', 'Last Name', 'Middle Name', 'SSN', 'Date of Birth', 'Address', 'City', 'State', 'Zip', 'Phone', 'Email', 'Title', 'Classification', 'Location', 'Date of Hire', 'Seniority Date', 'Effective Date', 'Step', 'Salary', 'Hours' , 'Probation Report Date', 'State Background Check' , 'Federal Background Check', 'State Educator ID', 'License 1 Type', 'License 1 Issue Date', 'License 1 Expiration Date', 'License 1 Term', 'License 2 Type', 'License 2 Issue Date', 'License 2 Expiration Date', 'License 2 Term', 'License 3 Type', 'License 3 Issue Date', 'License 3 Expiration Date', 'License 3 Term', 'License 4 Type', 'License 4 Issue Date', 'License 4 Expiration Date', 'License 4 Term', 'License 5 Type', 'License 5 Issue Date', 'License 5 Expiration Date', 'License 5 Term', 'License 6 Type', 'License 6 Issue Date', 'License 6 Expiration Date', 'License 6 Term'));
		include "../../core/abre_dbconnect.php";
		$rows = mysqli_query($db, 'SELECT * FROM directory order by lastname');
		
		while ($row = mysqli_fetch_assoc($rows)) {
			$picture=htmlspecialchars($row["picture"], ENT_QUOTES); 
			$picture=stripslashes($picture);
			$firstname=htmlspecialchars($row["firstname"], ENT_QUOTES); 
			$firstname=stripslashes(decrypt($firstname, ""));
			$lastname=htmlspecialchars($row["lastname"], ENT_QUOTES); 
			$lastname=stripslashes(decrypt($lastname, ""));
			$middlename=htmlspecialchars($row["middlename"], ENT_QUOTES); 
			$middlename=stripslashes(decrypt($middlename, ""));
			$ss=htmlspecialchars($row["ss"], ENT_QUOTES); 
			$ss=stripslashes(decrypt($ss, ""));
			$dob=htmlspecialchars($row["dob"], ENT_QUOTES); 
			$dob=stripslashes(decrypt($dob, ""));
			$address=htmlspecialchars($row["address"], ENT_QUOTES); 
			$address=stripslashes(decrypt($address, ""));
			$city=htmlspecialchars($row["city"], ENT_QUOTES); 
			$city=stripslashes(decrypt($city, ""));
			$state=htmlspecialchars($row["state"], ENT_QUOTES); 
			$state=stripslashes(decrypt($state, ""));
			$zip=htmlspecialchars($row["zip"], ENT_QUOTES); 
			$zip=stripslashes(decrypt($zip, ""));
			$phone=htmlspecialchars($row["phone"], ENT_QUOTES); 
			$phone=stripslashes(decrypt($phone, ""));
			$email=htmlspecialchars($row["email"], ENT_QUOTES); 
			$email=stripslashes(decrypt($email, ""));
			$title=htmlspecialchars($row["title"], ENT_QUOTES); 
			$title=stripslashes(decrypt($title, ""));
			$classification=htmlspecialchars($row["classification"], ENT_QUOTES); 
			$classification=stripslashes(decrypt($classification, ""));
			$location=htmlspecialchars($row["location"], ENT_QUOTES); 
			$location=stripslashes(decrypt($location, ""));
			$doh=htmlspecialchars($row["doh"], ENT_QUOTES); 
			$doh=stripslashes(decrypt($doh, ""));
			$senioritydate=htmlspecialchars($row["senioritydate"], ENT_QUOTES); 
			$senioritydate=stripslashes(decrypt($senioritydate, ""));
			$effectivedate=htmlspecialchars($row["effectivedate"], ENT_QUOTES); 
			$effectivedate=stripslashes(decrypt($effectivedate, ""));
			$step=htmlspecialchars($row["step"], ENT_QUOTES); 
			$step=stripslashes(decrypt($step, ""));
			$salary=htmlspecialchars($row["salary"], ENT_QUOTES); 
			$salary=stripslashes(decrypt($salary, ""));
			$hours=htmlspecialchars($row["hours"], ENT_QUOTES); 
			$hours=stripslashes(decrypt($hours, ""));
			$probationreportdate=htmlspecialchars($row["probationreportdate"], ENT_QUOTES); 
			$probationreportdate=stripslashes(decrypt($probationreportdate, ""));
			$statebackgroundcheck=htmlspecialchars($row["statebackgroundcheck"], ENT_QUOTES); 
			$statebackgroundcheck=stripslashes(decrypt($statebackgroundcheck, ""));
			$federalbackgroundcheck=htmlspecialchars($row["federalbackgroundcheck"], ENT_QUOTES); 
			$federalbackgroundcheck=stripslashes(decrypt($federalbackgroundcheck, ""));
			$stateeducatorid=htmlspecialchars($row["stateeducatorid"], ENT_QUOTES); 
			$stateeducatorid=stripslashes(decrypt($stateeducatorid, ""));
			$l1_1=htmlspecialchars($row["licensetype1"], ENT_QUOTES); 
			$l1_1=stripslashes(decrypt($l1_1, ""));
			$l1_2=htmlspecialchars($row["licenseissuedate1"], ENT_QUOTES); 
			$l1_2=stripslashes(decrypt($l1_2, ""));
			$l1_3=htmlspecialchars($row["licenseexpirationdate1"], ENT_QUOTES); 
			$l1_3=stripslashes(decrypt($l1_3, ""));
			$l1_4=htmlspecialchars($row["licenseterm1"], ENT_QUOTES); 
			$l1_4=stripslashes(decrypt($l1_4, ""));
			$l2_1=htmlspecialchars($row["licensetype2"], ENT_QUOTES); 
			$l2_1=stripslashes(decrypt($l2_1, ""));
			$l2_2=htmlspecialchars($row["licenseissuedate2"], ENT_QUOTES); 
			$l2_2=stripslashes(decrypt($l2_2, ""));
			$l2_3=htmlspecialchars($row["licenseexpirationdate2"], ENT_QUOTES); 
			$l2_3=stripslashes(decrypt($l2_3, ""));
			$l2_4=htmlspecialchars($row["licenseterm2"], ENT_QUOTES); 
			$l2_4=stripslashes(decrypt($l2_4, ""));
			$l3_1=htmlspecialchars($row["licensetype3"], ENT_QUOTES); 
			$l3_1=stripslashes(decrypt($l3_1, ""));
			$l3_2=htmlspecialchars($row["licenseissuedate3"], ENT_QUOTES); 
			$l3_2=stripslashes(decrypt($l3_2, ""));
			$l3_3=htmlspecialchars($row["licenseexpirationdate3"], ENT_QUOTES); 
			$l3_3=stripslashes(decrypt($l3_3, ""));
			$l3_4=htmlspecialchars($row["licenseterm3"], ENT_QUOTES); 
			$l3_4=stripslashes(decrypt($l3_4, ""));
			$l4_1=htmlspecialchars($row["licensetype4"], ENT_QUOTES); 
			$l4_1=stripslashes(decrypt($l4_1, ""));
			$l4_2=htmlspecialchars($row["licenseissuedate4"], ENT_QUOTES); 
			$l4_2=stripslashes(decrypt($l4_2, ""));
			$l4_3=htmlspecialchars($row["licenseexpirationdate4"], ENT_QUOTES); 
			$l4_3=stripslashes(decrypt($l4_3, ""));
			$l4_4=htmlspecialchars($row["licenseterm4"], ENT_QUOTES); 
			$l4_4=stripslashes(decrypt($l4_4, ""));
			$l5_1=htmlspecialchars($row["licensetype5"], ENT_QUOTES); 
			$l5_1=stripslashes(decrypt($l5_1, ""));
			$l5_2=htmlspecialchars($row["licenseissuedate5"], ENT_QUOTES); 
			$l5_2=stripslashes(decrypt($l5_2, ""));
			$l5_3=htmlspecialchars($row["licenseexpirationdate5"], ENT_QUOTES); 
			$l5_3=stripslashes(decrypt($l5_3, ""));
			$l5_4=htmlspecialchars($row["licenseterm5"], ENT_QUOTES); 
			$l5_4=stripslashes(decrypt($l5_4, ""));
			$l6_1=htmlspecialchars($row["licensetype6"], ENT_QUOTES); 
			$l6_1=stripslashes(decrypt($l6_1, ""));
			$l6_2=htmlspecialchars($row["licenseissuedate6"], ENT_QUOTES); 
			$l6_2=stripslashes(decrypt($l6_2, ""));
			$l6_3=htmlspecialchars($row["licenseexpirationdate6"], ENT_QUOTES); 
			$l6_3=stripslashes(decrypt($l6_3, ""));
			$l6_4=htmlspecialchars($row["licenseterm6"], ENT_QUOTES); 
			$l6_4=stripslashes(decrypt($l6_4, ""));
			$data = [$picture,$firstname,$lastname,$middlename,$ss,$dob,$address,$city,$state,$zip,$phone,$email,$title,$classification,$location,$doh,$senioritydate,$effectivedate,$step,$salary,$hours,$probationreportdate,$statebackgroundcheck,$federalbackgroundcheck,$stateeducatorid,$l1_1,$l1_2,$l1_3,$l1_4,$l2_1,$l2_2,$l2_3,$l2_4,$l3_1,$l3_2,$l3_3,$l3_4,$l4_1,$l4_2,$l4_3,$l4_4,$l5_1,$l5_2,$l5_3,$l5_4,$l6_1,$l6_2,$l6_3,$l6_4];
			fputcsv($output, $data);
		}
		fclose($output);
		mysqli_close($db);
		exit();
		
	}
  
?>