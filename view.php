<?php
/**
 * Este archivo despliega la p�gina del ToolBox
 * @author Clark Jeria
 * @copyright 2011 Clark Jeria
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 o superior
 * @package s
 * @subpackage toolbox
 * @since Moodle 2.0
 */

global $USER, $CFG;
require_once('../../config.php');
require_once($CFG->dirroot.'/course/lib.php');
require_once($CFG->dirroot.'/local/uai_toolbox/lib.php');

/*
optional_param() Similar a $_Require pero realiza un chequeo de la variable.
*/
$idProfesor = optional_param('idProfesor', 0, PARAM_INT);
$idFacultad = optional_param('idFacultad', 0, PARAM_INT);
$view = optional_param('view', 'miscursos', PARAM_ALPHA);
$page = optional_param('page', 0, PARAM_INT);
$rank = optional_param('rank', 0, PARAM_INT);
$site = get_site();
$url = new moodle_url('/local/uai_toolbox/view.php');

if ($idProfesor !== 0) {
    $url->param('idProfesor', $idProfesor);
}
if ($view !== 'miscursos') {
    $url->param('view', $view);
}
if ($page !== 0) {
    $url->param('page', $page);
}
if ($idFacultad !== 0) {
    $url->param('idFacultad', $idFacultad);
}
if ($rank !== 0) {
    $url->param('rank', $rank);
}

$pagetitle = get_string('pagetitle', 'local_uai_toolbox');
//$context = get_context_instance(CONTEXT_USER,$USER->id);
//reemplazado dado que ya esa función se reemplazó por la siguiente:
$context = context_user::instance($USER->id);
$PAGE->set_context($context);
$PAGE->set_url($url);
$PAGE->navbar->add($pagetitle,'');
$PAGE->set_title("$site->shortname: $pagetitle");


switch ($view){
	case 'miscursos':
		$toolname = get_string('miscursos', 'local_uai_toolbox');
		$desc = get_string('descripcionmiscursos', 'local_uai_toolbox');
		break;
	case 'ranking':
		$toolname = get_string('ranking', 'local_uai_toolbox');
		$desc = get_string('descripcionranking', 'local_uai_toolbox');
		break;
	case 'acerca':
		$toolname = get_string('acerca','local_uai_toolbox');
		$desc = get_string('descripcionacerca','local_uai_toolbox');
		break;   
	case 'profesores':
		$toolname = get_string('profesores', 'local_uai_toolbox');
		$desc = get_string('descripcionprofesores', 'local_uai_toolbox');
		break;
	case 'facultades':
		$toolname = get_string('facultades', 'local_uai_toolbox');
		$desc = get_string('descripcionfacultades', 'local_uai_toolbox');
		break;
	default:
		error("Opción invalida");
		break;
}

$PAGE->navbar->add($toolname);
$PAGE->set_heading($pagetitle.': '.$toolname);
$PAGE->set_pagelayout('standard');
$renderer = $PAGE->get_renderer('local_uai_toolbox');

echo $OUTPUT->header();
echo $renderer->start_layout();
echo $renderer->show_descripcion($desc);

$pageCount = 10; //Cantidad de Entradas a mostrar en el Ranking

switch ($view){
	case 'miscursos':
		$cursos = get_cursos();
		echo $renderer->show_cursos_grid($cursos);
		break;
	case 'ranking':
		$rol = get_rol();
		if($rol == 'Decano' || $rol == 'Rector'){
			$ranking = get_ranking($idFacultad);
			$facultades = get_facultades();
			$totalCount = count($ranking);
			echo $renderer->show_barrauai_toolbox($facultades, $view, get_string('facultad', 'uai_toolbox'), $idFacultad,'', 'Universidad');
			echo $renderer->show_ranking($ranking, $view, 'Profesor', $page, $rank, $idFacultad,$pageCount);
			if($rank != 0){
				$page = floor($rank/$pageCount);
				$page = ($page <= 0)?0:$page;
			}
			echo $OUTPUT->paging_bar($totalCount,$page,$pageCount,$CFG->wwwroot.'/s/toolbox/view.php?view=ranking&idFacultad='.$idFacultad,'page');
		}else{
			$cursos = get_cursos();
			echo $renderer->show_cursos_grid($cursos);
		}
		break;
	case 'acerca':
		echo $renderer->about();
		break;		
	
}

echo $renderer->complete_layout();
echo $OUTPUT->footer();
