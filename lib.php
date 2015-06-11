<?php
/**
 * Este archivo contiene las funciones principales del ToolBox
 * @author Clark Jeria
 * @copyright 2011 Clark Jeria
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 o superior
 * @package blocks
 * @subpackage toolbox
 * @since Moodle 2.0
 */

require_once($CFG->dirroot.'/lib/enrollib.php');
require_once($CFG->dirroot.'/lib/datalib.php');
require_once($CFG->dirroot.'/lib/accesslib.php');

/**
 * Obtiene arreglo que indica el nivel general del usuario, su ranking a nivel de facultad, su ranking a nivel general (UAI)
 *  y el id de la facultad a la que pertenece e.g.array('nivel' => 'textonivel (valornivel)', 'facultad' => 'rankfacultad', 'uai' => 'rankuai', 'idfacultad' => 'idfacultad1').
 * @return array.
 */
function get_summary(){
	global $DB, $USER, $SESSION;
	
    if(isset($SESSION->summary)){
  	  return $SESSION->summary;
	  exit;
	}
	//Consulta anterior, eliminada por el bajo alcance, dado que solo sirve para los profesores, pero no
	//para los alumnos y/o ayudantes.	
	if(get_rol()=='Profesor' || get_rol()=='Decano' || get_rol()=='Rector'){
		
		$nivel = $DB->get_field_sql("SELECT nivel FROM (SELECT round(AVG(puntaje),3) as nivel, id_profesor		
	                             FROM {local_toolbox_score}			
	                             GROUP BY id_profesor) as Profesor
								 WHERE id_profesor =".$USER->id);
		
		if(empty($nivel)){
			return null;
		}
	
	  	$idfacultad = $DB->get_field_sql("SELECT MIN(id_facultad) as facultad
									FROM {local_toolbox_score}
									GROUP BY id_profesor HAVING id_profesor =".$USER->id);
	  	
	  	$test = $DB->execute("SET @rownum := 0");  	
	  	$rankuai = "0";
  		
  	
  		
  		$rankuai = $DB->get_field_sql("SELECT cuenta
									   FROM (Select count(*) + 1 as cuenta
									   FROM (SELECT id_profesor, round(AVG(puntaje),3) as score
									   FROM {local_toolbox_score}
									   GROUP BY id_profesor
									   HAVING score > $nivel) as a) as b"); 														
  	

	  	$test = $DB->execute("SET @rownum := 0");  	
	  	$rankfacultad = "0";
  	
	  	if($test){
	  		$nivelfacultad = $DB->get_field_sql("SELECT nivel FROM (SELECT round(AVG(puntaje),3) as nivel, id_profesor		
			                             FROM {local_toolbox_score} WHERE id_facultad = ".$idfacultad." 			
			                             GROUP BY id_profesor) as Profesor
										 WHERE id_profesor =".$USER->id);

	  		$rankfacultad = $DB->get_field_sql("SELECT cuenta
									   FROM (Select count(*) + 1 as cuenta
									   FROM (SELECT id_profesor, round(AVG(puntaje),3) as score
									   FROM {local_toolbox_score} WHERE id_facultad = ".$idfacultad." 
									   GROUP BY id_profesor
									   HAVING score > $nivelfacultad) as a) as b"); 	
	  	} 
  		$summary = array('nivel' => $nivel, 'facultad' => $rankfacultad, 'uai' => $rankuai, 'idfacultad' => $idfacultad);
  	
	  	$SESSION->summary = $summary;
	  	
	  	if($summary['nivel'] == 'NULL'){
	  		return NULL;
	  	}
	  	$valor = $summary['nivel'];
  	
	}else{
		$nivel = get_nivel();
		$summary = array('nivel' => $nivel);
	}  	
	
  	return $summary;
}

/**
 * Obtiene el rol del usuario logeado.
 * @return string Rol {'Alumno', 'Profesor', 'Decano', 'Rector'}
 */
function get_rol(){
	global $USER, $DB, $SESSION;
	
	if(isset($SESSION->rol)){
	return $SESSION->rol;
	exit;
	}
	
	$context = context_system::instance();
	$rolesportada = get_user_roles($context, false);
	
	foreach($rolesportada as $rol){
		if($rol->name == 'Rector'){
			$SESSION->rol = 'Rector';
			return 'Rector';
		}
	}
	
	$facultades = $DB->get_records_sql("SELECT DISTINCT {course}.category
										FROM {course} INNER JOIN {context} ON ({course}.category = {context}.instanceid)
										INNER JOIN {role_assignments} ON ({context}.id = {role_assignments}.contextid)
										INNER JOIN {role} ON ({role_assignments}.roleid = {role}.id)
										WHERE {role}.name = 'Decano' AND {role_assignments}.userid = ".$USER->id);
	if(!empty($facultades)){
		$SESSION->rol = 'Decano';
		$SESSION->facultades = array_keys($facultades);
		return 'Decano';
	}
	
	$profesores = $DB->get_records_sql("SELECT DISTINCT id_profesor FROM {local_toolbox_score}");
	if(array_key_exists($USER->id, $profesores)){
		$SESSION->rol = 'Profesor';
		return 'Profesor';
	}
	
	$SESSION->rol = 'Alumno';
	return 'Alumno';
}

/**
 * Obtiene texto asociado al score {Básico, Intermedio, Avanzado, Experto}
 * @param float $score Valor del score (nivel) e.g 1.23
 * @return string Texto.
 */
function get_score_text($score){
    	global $CFG;
    	
    	
    	$final_score = round((float)$score);
    	
    	switch ($final_score){
    		case 0:
    			$scr = 'Básico';
    			break;
    		case 1:
    			$scr = 'Intermedio';
    			break;
    		case 2:
    			$scr = 'Avanzado';
    			break;
    		case 3:
    			$scr = 'Experto';
    			break;
    		default:
    			$scr = 'Error';
    			break;    			
    	}
    	
    	return $scr;    	
}

/**
 * Obtiene una ruta relativa de la imagen asociada al valor del score.
 * @param float $score Valor del score (nivel) e.g 1.23
 * @return string Ruta.
 */
function get_img_source($score){
    	global $CFG;
    	
    	$final_score = round((float)$score);
    	$ruta = $CFG->wwwroot.'/local/toolbox/';
    	
    	switch ($final_score){
    		case 0:
    			$scr = $ruta.'scoreBasico.png';
    			break;
    		case 1:
    			$scr = $ruta.'scoreIntermedio.png';
    			break;
    		case 2:
    			$scr = $ruta.'scoreAvanzado.png';
    			break;
    		case 3:
    			$scr = $ruta.'scoreExperto.png';
    			break;
    		default:
    			break;    			
    	}
    	
    	return $scr;    	
}
/**
 * Obtiene los datos necesarios para la matriz de cursos.
 * @param int $userId id del usuario que se requieren los cursos (si esta vacio se buscan los del usuario actual ('mis cursos')).
 * @return array Cursos.
 */
function get_cursos($userId = ''){
	global $DB, $USER;
	
	if($userId == ''){
		$userId = $USER->id;
		$miscursos = enrol_get_my_courses(array('id'));
	}else{
		$miscursos = enrol_get_users_courses($userId, true, array('id'));
	}
	$cursos = array();
	
	foreach($miscursos as $idCurso => $curso){
		$fullname = $DB->get_field_sql("SELECT fullname FROM {course}  WHERE id = ".$idCurso);
		$rol = $DB->get_field_sql("SELECT {role}.name
									FROM {course}  INNER JOIN {context} ON ({course}.id = {context}.instanceid)
									INNER JOIN {role_assignments} ON ({context}.id = {role_assignments}.contextid) 
									INNER JOIN {role} ON ({role_assignments}.roleid = {role}.id)
									WHERE {course}.id =".$idCurso." AND {role_assignments}.userid =".$userId);
		$foro = $DB->get_field_sql("SELECT Distinct puntaje
									FROM {local_toolbox_score}
									WHERE id_tool = 'Foro' AND id_curso =".$idCurso);
		
		if(!isset($foro)){
			continue;
		}
		$cuestionario = $DB->get_field_sql("SELECT Distinct puntaje
									FROM {local_toolbox_score}
									WHERE id_tool = 'Cuestionario' AND id_curso =".$idCurso);
		$calificacion = $DB->get_field_sql("SELECT DISTINCT puntaje FROM {local_toolbox_score}
									WHERE id_tool = 'Calificacion' AND id_curso =".$idCurso);

		
		$cursos[$idCurso] = array('nombre' => $fullname." (".$rol.")",
									'Foro' => $foro,
									'Cuestionario' => $cuestionario,
									'Calificacion' => $calificacion);
	}
	
	return $cursos;
}
/**
 * Obtiene los datos necesarios para realizar el ranking de alguna facultad
 * @param int $idFacultad número de la facultad que se desea hacer el ranking
 * @return array Ranking.
 */
function get_ranking($idFacultad = ''){
	global $DB;
	
	$DB->execute("SET @rownum := 0"); 
	$DB->execute("SET @score := -1"); 
	$DB->execute("SET @count := 1"); 

	$sql = "SELECT id_profesor, nombre, CASE (score) WHEN @score THEN @rownum:= @rownum ELSE @rownum:= @rownum+ @count END as rank, score, 
 			CASE (score) WHEN @score THEN @count := @count + 1 ELSE @count := 1 END, @score := score FROM (
			SELECT id_profesor, CONCAT( firstname,  ' ', lastname ) AS nombre, ROUND( AVG( puntaje ) , 3 ) AS score
			FROM {local_toolbox_score}
			INNER JOIN {user} ON ( id_profesor = id";
	
	$sql .= ($idFacultad != '') ? " AND id_facultad = ".$idFacultad.")":")";
	
	$sql .= " GROUP BY id_profesor ORDER BY score DESC) AS TEMP ORDER BY rank";
	
	return $DB->get_records_sql($sql);	
}
/**
 * Obtiene una lista de los profesores de la facultad especificada
 * @param int $idFacultad
 * @return string Ruta.
 */
function get_profesores($idFacultad = ''){
	global $DB;
	
	$result = array();
	
	$sql = "SELECT DISTINCT {user}.id, CONCAT(firstname, ' ', lastname) as nombre
			FROM {course} INNER JOIN {context} ON ({course}.id = {context}.instanceid)
			INNER JOIN {role_assignments} ON ({context}.id = {role_assignments}.contextid)
			INNER JOIN {user} ON ({role_assignments}.userid = {user}.id)
			WHERE {role_assignments}.roleid in (3,4)";
	if($idFacultad != ''){
		$sql .= " AND {course}.category =".$idFacultad;
	}
	
	$profesores = $DB->get_records_sql($sql);
	
	foreach($profesores as $id => $profesor){
		$result[$id] = $profesor->nombre;
	}
	
	return $result;
}
/**
 * Obtiene el ranking de facultades del ToolBox.
 * @return array Ranking.
 */
function get_ranking_facultades(){
	global $DB;
	
    $DB->execute("SET @rownum := 0"); 
	
	$sql = "SELECT id_facultad, {course_categories}.name as nombre, @rownum := @rownum + 1 as rank, AVG(puntaje) as score 
			FROM {local_toolbox_score} INNER JOIN {course} ON (id_curso = {course}.id)
			INNER JOIN {course_categories} ON ({course}.category = {course_categories}.id)
			GROUP BY id_facultad ORDER BY (AVG(puntaje))";

	
	return $DB->get_records_sql($sql);
}
/**
 * Obtiene la lista de Facultades existentes en el ToolBox.
 * @return array facultades.
 */
function get_facultades(){
	global $DB;
	
	$result = array();
	
	$sql = "SELECT DISTINCT id_facultad, {course_categories}.name as nombre
			FROM {local_toolbox_score} INNER JOIN {course} ON (id_curso = {course}.id)
			INNER JOIN {course_categories} ON (id_facultad = {course_categories}.id)";
	
	$facultades = $DB->get_records_sql($sql);
	
	foreach($facultades as $id => $facultad){
		$result[$id] = $facultad->nombre;
	}
	
	return $result;
}
/**
 * 
 * Hola no se hacer un m�todo.
 */
function get_total_teachers()
{
	global $DB, $CFG;
	
	$db = mysqli_connect($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
	$db->select_db($CFG->dbname );
	
	$sql= "SELECT COUNT(DISTINCT u.id,ra.roleid, ra.userid) FROM {user} AS u, {role_assignments} AS ra WHERE roleid = 3 AND u.id = ra.userid";
	
	return $DB->get_field_sql($sql);
}

/**
 * Lo que busca esta función es encontrar todos los cursos que posee un alumno
 * @return Devuelve el nivel del usuario como un número.
 */
function get_nivel(){
	$datos = get_cursos();
	$promedio = 0;
	if(count($datos)!=0){
	foreach($datos as $idCurso => $dato){
		$suma = round(($dato['Foro']+$dato['Cuestionario']+$dato['Calificacion'])/3,2);
		$promedio = $promedio + $suma;
	}
	$nivel = $promedio/count($datos);}else{
		$nivel = 0;
	}
	
	return $nivel;	
}

