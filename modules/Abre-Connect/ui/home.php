<?php

	/*
	* Copyright (C) 2016-2017 Abre.io LLC
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
	require_once(dirname(__FILE__) . '/../../../core/abre_verification.php');
	require(dirname(__FILE__) . '/../../../core/abre_dbconnect.php');
	require_once(dirname(__FILE__) . '/../../../core/abre_functions.php');

  class Journal {
    public $title;
    public $body;
  }

  $thisWeekJournals = [];

  $query = "SELECT * FROM Abre_Connect_Journal";
  $dbreturn = $db->query($query);
  
  while($row = $dbreturn->fetch_assoc()) {
    $j =  new Journal();
    $j->title = $row["title"];
    $j->body = $row["body"];
    $thisWeekJournals[] = $j;
  }
?>


<div class="container">
  <div id="home" class="col s12">home</div>

  <div id="journals" class="col s12">
    <h6 class="grey-text text-darken-2">This Week</h6>
    <ul class="collection">
      
      <?php
        for($i = 0; $i < count($thisWeekJournals); $i++) {
          $j = $thisWeekJournals[$i];
      ?>

        <li class="collection-item avatar" 
          style="width: auto; height: auto; border-radius: 0; ">
        
          <i class="material-icons circle">account_circle</i>
          <span class="title"><?php echo $j->title ?></span>
          <div class="row">
            <p class="truncate col s10"><?php echo $j->body ?></p>
            <i class="material-icons col s1">attach_file</i>
          </div>
          <div class="secondary-content">Today</div>
        </li>

      <?php } ?>
      
    </ul>  
  </div>
</div>