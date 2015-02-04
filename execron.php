<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Script to let a user manage Cron for Block Toolbox. 
 * 
 */

global $CFG, $DB; 
require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->libdir . '/tablelib.php');

require_login();

$returnurl = optional_param('returnurl', '', PARAM_LOCALURL);


$context = get_context_instance(CONTEXT_SYSTEM);
$PAGE->set_context($context);


$urlparams = array();
$baseurl = new moodle_url('/local/uai_toolbox/execron.php', $urlparams);
$PAGE->set_url($baseurl);


$strmanage = get_string('cron', 'uai_toolbox');

$PAGE->set_pagelayout('standard');
$PAGE->set_title($strmanage);
$PAGE->set_heading($strmanage);

$settingsurl = new moodle_url('/admin/settings.php?section=localsettingtoolbox');
$managefeeds = new moodle_url('/local/uai_toolbox/execron.php', $urlparams);
$PAGE->navbar->add(get_string('local'));
$PAGE->navbar->add(get_string('cron', 'uai_toolbox'), $settingsurl);
$PAGE->navbar->add(get_string('cronnow', 'uai_toolbox'), $managefeeds);
echo $OUTPUT->header();
 
/*
 * Here goes the query that executes the procedure that is in the Cron. 
 * Principally the procedure completes the Database of Block Toolbox and 
 * recalculate the scores. 
 */

require_once($CFG->dirroot.'/local/uai_toolbox/db/procedure.php');

   if($db = mysqli_connect($CFG->dbhost,$CFG->dbuser,$CFG->dbpass))
{
       $db->select_db($CFG->dbname );
	   mysqli_query($db,"DROP PROCEDURE IF EXISTS getCursosScore");
	   mysqli_query($db, $sqlCreate);
	   mysqli_query($db, "DROP table {toolbox_score}");
	  
	   if ($result = mysqli_query($db,"CALL getCursosScore"))
	   {
			echo "<br>";
			echo "<p>". get_string('success','uai_toolbox')."</p>"; 
			echo "<br>";
			echo '<div class="backlink">' . $OUTPUT->single_button($settingsurl, get_string('back', 'uai_toolbox'), 'get') . '</div>';

			echo $OUTPUT->footer();

			return true;
		} 
			
			else 
		{
			echo "<br>";
			echo "<p>". get_string('failureone','uai_toolbox')."</p>"; 
			echo "<br>";
			echo '<div class="backlink">' . $OUTPUT->single_button($settingsurl, get_string('back', 'uai_toolbox'), 'get') . '</div>';

			echo $OUTPUT->footer();

			return false;
   		}
  }
			else
			  {
				echo "<br>";	
				echo "<p>". get_string('failuretwo','uai_toolbox')."</p>";  
				echo "<br>";
				echo '<div class="backlink">' . $OUTPUT->single_button($settingsurl, get_string('back', 'uai_toolbox'), 'get') . '</div>';

				echo $OUTPUT->footer();

				return false;
			  }

      
	echo '<div class="backlink">' . $OUTPUT->single_button($settingsurl, get_string('back', 'uai_toolbox'), 'get') . '</div>';

	echo $OUTPUT->footer();
