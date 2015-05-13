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
$string['Debesiniciarsesion'] = 'Debes iniciar sesión para acceder al ToolBox';
$string['Copyrights2011'] = 'Copyrights 2011';
$string['miscursos'] = 'Mi Califación';
$string['profesores'] = 'Profesores';
$string['facultades'] = 'Facultades';
$string['rolnoestandar'] = 'Rol no estandar';
$string['ranking'] = 'Ranking';
$string['sinranking'] = 'Sin Ranking';
$string['rankingfacultad'] = 'Ranking Facultad';
$string['rankingglobal'] = 'Ranking UAI';
$string['acerca'] = 'Acerca de Toolbox';
$string['avanzado']= 'Avanzado';
$string['intermedio'] = 'Intermedio';
$string['miscursosstudent'] = 'Calificación de mis Cursos';
$string['minivel'] = 'Mi Nivel: ';
$string['minivelstudent'] = 'Nivel de mis cursos: ';
$string['miranking'] = 'Mi Ranking: ';
$string['mirankingde'] = ' de ';
$string['toolbox:viewtoolboxmanager'] = 'view manager toolbox';
$string['toolbox:viewtoolboxstudent'] = 'view student toolbox';
$string['toolbox:viewtoolboxteacher'] = 'view teacher tollbox';
$string['toolbox:viewtoolboxuser'] = 'view user toolbox';

/**
renderer.php
*/
$string['c/h']='Curso/Herramienta';
$string['foros']='Foros';
$string['cuestionarios']='Cuestionarios';
$string['calificaciones']='Calificaciones';
$string['basico']='Básico';
$string['intermedio']='Intermedio';
$string['avanzado']='Avanzado';
$string['experto']='Experto';
$string['error']='Error';
$string['filtro']='Filtro';
$string['nivel']='Nivel';
$string['ranking']='Ranking';
$string['profesor']='Profesor';

$string['textabout'] = 'Toolbox es una herramienta creada para la evaluaci&oacute;n del uso de los profesores en webcursos.
       Para realizar esto, se toma en cuenta el nivel de utilizaci&oacute;n de tres herramientas que posee el sistema (Foro,Cuestionarios y Calificaciones) por curso y luego se promedian cada una de las evaluaciones.
       Con estos datos, se obtiene el Nivel del Usuario, que es el que aparece al inicio del m&oacute;dulo Toolbox.
       Además, se podrá ver en una tabla de posiciones de los profesores, tanto en la universidad como en cada facultad, en Ver Ranking. Estos aparecerán en orden descendiente por evaluación recibida en el sistema.
       Para mayor información de como mejorar su evaluación, revise los manuales para la utilización de Webcursos que aparecen en tutoriales.';

/**
View.php
*/
$string['pagetitle'] = 'ToolBox';
$string['miscursos'] = 'Mi Calificación';
$string['descripcionmiscursos'] ='Mi Calificación de uso de Webcursos.';
								
$string['ranking'] = 'Ranking';
$string['descripcionranking'] = 'Ranking';
								
$string['profesores'] = 'Profesores';
$string['descripcionprofesores'] = 'Ranking';
								
$string['facultades'] = 'Facultades';
$string['descripcionfacultades'] = 'Ranking';
$string['facultad'] = 'Facultad';

$string['descripcionacerca'] = 'Acerca de Toolbox';

/**
 Settings.php
 */

$string['cron']= 'Configuración del Cron Toolbox';
$string['cronnow'] = 'Activación Cron Toolbox';
$string['cronnow_desc'] = 'Realizar actualizar los datos de Toolbox de manera manual.';
$string['back'] = 'Volver';
$string['success']= 'Ejecutado con exito';
$string['failureone'] = 'Error al ejecutar el procedimiento de actualización de datos';
$string['failuretwo'] = 'Error al conectarse a la base de datos.';
$string['yes'] = 'Si';
$string['no'] = 'No';
$string['cronactive'] = 'Cron Activado';
$string['cronactive_desc'] = 'Activar la realización periodíca del cron para actualizar los datos de los profesores de manera automática';
$string['starttime'] = 'Hora de Inicio';
$string['starttime_desc'] ='Hora de inicio en la que el cron podría empezar a ejecutarse.';
$string['finishtime'] = 'Hora de Término';
$string['finishtime_desc'] = 'Hora hasta la que se podría ejecutar el cron.';
$string['interval'] = 'Intervalos de Tiempo';
$string['interval_desc'] = 'Intervalo de tiempo entre las ejecuciones que realiza el cron (minutos).';

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