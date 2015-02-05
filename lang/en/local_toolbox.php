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

 *
 * @package   local
 * @subpackage toolbox
 * @copyright 2012 Universidad Adolfo Ibanez
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['toolbox'] = 'ToolBox';
$string['pluginname'] = 'Toolbox';
$string['Debesiniciarsesion'] = 'You have to login to access Toolbox';
$string['Copyrights2011'] = 'Copyrights 2011';
$string['miscursos'] = 'My Score';
$string['profesores'] = 'Teachers';
$string['facultades'] = 'Faculties';
$string['rolnoestandar'] = 'No standard role';
$string['ranking'] = 'Ranking';
$string['sinranking'] = 'No Ranking';
$string['rankingfacultad'] = 'Faculties Ranking';
$string['rankingglobal'] = 'UAI Ranking';
$string['acerca'] = 'About Toolbox';
$string['avanzado']= 'Advanced';
$string['intermedio'] = 'Medium';
$string['miscursosstudent'] = 'My Courses Score';
$string['minivel'] = 'My Level: ';
$string['minivelstudent'] = 'My Courses Level: ';
$string['miranking'] = 'My Ranking: ';
$string['mirankingde'] = ' out of ';


/**
renderer.php
*/
$string['c/h']='Course/Tool';
$string['foros']='Forum';
$string['cuestionarios']='Quizzes';
$string['calificaciones']='Grades';
$string['basico']='Basic';
$string['intermedio']='Medium';
$string['avanzado']='Advanced';
$string['experto']='Expert';
$string['error']='Error';
$string['filtro']='Filter';
$string['nivel']='Level';
$string['ranking']='Ranking';
$string['profesor']='Teacher';

$string['textabout'] = 'Toolbox is a tool created for the teachers use evaluation in Webcursos.
       To do this, the tool considers the level of utilization of three tools that the system has (Forum,Quizzes and Grades) per course and then calculate the average of each evaluation.
       With this data, it obtained the User Level,which appears in the front page of Toolbox.
       Futhermore, you will be capable to see a position table of the teachers in both the university and every faculty in "See Ranking". The result will be appear in descendant order per evaluation received in the system.
       For more information about how you can improve your evaluation, review the manuals for Webcursos utilization that appears in the tutorials.';

/**
View.php
*/
$string['pagetitle'] = 'ToolBox';
$string['miscursos'] = 'My score';
$string['descripcionmiscursos'] ='My score';
								
$string['ranking'] = 'Ranking';
$string['descripcionranking'] = 'Ranking';
								
$string['profesores'] = 'teacher';
$string['descripcionprofesores'] = 'Ranking';
								
$string['facultades'] = 'Faculties';
$string['descripcionfacultades'] = 'Ranking';
$string['facultad'] = 'Faculty';

$string['descripcionacerca'] = 'About Toolbox';

/**
 Settings.php
 */

$string['cron']= 'Toolbox settings';
$string['cronnow'] = 'Toolbox cron activated';
$string['cronnow_desc'] = 'Update toolbox manually.';
$string['back'] = 'Back';
$string['success']= 'Successful';
$string['failureone'] = 'Error executing cron';
$string['failuretwo'] = 'Error connecting to the Database';
$string['yes'] = 'Yes';
$string['no'] = 'No';
$string['cronactive'] = 'Cron Executed Successfully';
$string['cronactive_desc'] = 'Active the periodic realization of the Cron to update the data of the teachers automatically';
$string['starttime'] = 'Starting time';
$string['starttime_desc'] ='Starting time for cron to be executed';
$string['finishtime'] = 'Ending Time';
$string['finishtime_desc'] = 'Time until cron could be executed';
$string['interval'] = 'Time intervals';
$string['interval_desc'] = 'Time interval between cron activations.';

/**
 About
*/
$string['about_content'] = '<table>
						    <tr>
						    <td rowspan="2" valign="top"><img src="img/tit_toolbox.gif" width="53" height="207" alt="Toolbox Webcursos" /></td>
						    <td valign="top" align="justify"><b>Toolbox</b> es una herramienta creada para la evaluación del uso de los profesores en WebCursos.
						       Para realizar esto, se toma en cuenta el nivel de utilización de tres herramientas que posee el sistema (Foro,Cuestionarios y Calificaciones) por curso y luego se promedian cada una de las evaluaciones.<br />
						       <br />
						       Con estos datos, se obtiene el Nivel del Usuario, que es el que aparece al inicio del módulo Toolbox.
						       Además, se podrá ver en una tabla de posiciones de los profesores, tanto en la universidad como en cada facultad, en Ver Ranking. Estos aparecerán en orden descendiente por evaluación recibida en el sistema.
						       <br />
						       <br />
						       Para mayor información de como mejorar su evaluación, revise los manuales para la utilización de Webcursos que aparecen en <a href="http://webcursos.cloudlab.cl/tutoriales/">Tutoriales</a>.</td></tr>
						    <tr>
						      <td align="center"><br />        <img src="img/RankingToolBox.png" width="600" height="222" /></td>
						    </tr>
						    </table>';

/////////vista bloque toolbox///////

$string['local_toolbox:viewtoolboxmanager'] = 'view manager toolbox';
$string['local_toolbox:viewtoolboxstudent'] = 'view student toolbox';
$string['local_toolbox:viewtoolboxteacher'] = 'view teacher tollbox';
$string['local_toolbox:viewtoolboxuser'] = 'view user toolbox';
