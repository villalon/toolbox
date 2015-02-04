<?php
/**
 * Este archivo contiene renderizaciones para el ToolBox
 * @author Clark Jeria
 * @copyright 2011 Clark Jeria
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 o superior
 * @package 
 * @subpackage toolbox
 * @since Moodle 2.0
 */

require_once('../../config.php');
require_once($CFG->dirroot.'/local/uai_toolbox/lib.php');

/**
 * El renderizador primario para el ToolBox.
 */
class local_uai_toolbox_renderer extends plugin_renderer_base {
	
    /**
     * Inicio del layout standard para la p�gina     *
     * @return string Fragmento HTML
     */
    public function start_layout() {
        return html_writer::start_tag('center').html_writer::start_tag('div', array('class'=>'maintoolbox'));
    }

    /**
     * Finaliza el layout de la p�gina     *
     * @return string Fragmento HTML
     */
    public function complete_layout() {
        return html_writer::end_tag('div').html_writer::end_tag('center');
    }
    /**
     * Obtiene una tabla donde se muestra los cursos inscritus y su rol, adem�s
     * de el nivel alcanzado en las herramientas: Foro con Nota, Cuestionarios, Calificaciones.
     * @param array $datos Matr�z con el nombre del curso y el score de cada herramienta 
     * e.g. array('idCurso' => array('nombre' => 'nombre1(rol1)', 'Foro' => 'X.XX', 'Cuestionario' => 'nombre1(X.XX)', 'Calificacion' => 'nombre1(X.XX)')etc.) 
     * @return string Fragmento HTML
     */
    public function show_cursos_grid(array $datos){
    	global $CFG;
    	
    	$grid = new html_table();
    	$grid->attributes = array('class'=>'gridCursos');
    	$grid->data = array();
    	
    	$grid->data[0] = new html_table_row();
    	$grid->data[0]->attributes['class'] .= 'gridCursosHeader';

    	$grid->data[0]->cells[0] = new html_table_cell(get_string('c/h','local_uai_toolbox'));
    	$grid->data[0]->cells[1] = new html_table_cell(html_writer::tag('a', get_string('foros','local_uai_toolbox'), array('href'=>'http://webcursos.cloudlab.cl/mod/page/view.php?id=334191','style'=>'color:#fff;')));
    	$grid->data[0]->cells[2] = new html_table_cell(html_writer::tag('a', get_string('cuestionarios','local_uai_toolbox'), array('href'=>'http://webcursos.cloudlab.cl/mod/page/view.php?id=334156','style'=>'color:#fff;')));
    	$grid->data[0]->cells[3] = new html_table_cell(html_writer::tag('a', get_string('calificaciones','local_uai_toolbox'), array('href'=>'http://webcursos.cloudlab.cl/mod/page/view.php?id=355417','style'=>'color:#fff;')));
    	
    	$row = 1;
    	foreach ($datos as $idCurso => $dato){
    		$cell = 0;
    		
    		$anchor_name = html_writer::tag('a', $dato['nombre'], array('href'=>$CFG->wwwroot.'/course/view.php?id='.$idCurso,'style'=>'color:#000'));
    		$img_foro = html_writer::empty_tag('img', array('src' => get_img_source($dato['Foro']), 'alt' => get_score_text($dato['Foro']), 'title' => get_score_text($dato['Foro']).' : '.$dato['Foro']));
    		$img_quiz = html_writer::empty_tag('img', array('src' => get_img_source($dato['Cuestionario']), 'alt' => get_score_text($dato['Cuestionario']), 'title' => get_score_text($dato['Cuestionario']).' : '.$dato['Cuestionario']));
    		$img_gradebook = html_writer::empty_tag('img', array('src' => get_img_source($dato['Calificacion']), 'alt' => get_score_text($dato['Calificacion']), 'title' => get_score_text($dato['Calificacion']).' : '.$dato['Calificacion']));
    		
    		
    		$grid->data[$row] = new html_table_row();
    		$grid->data[$row]->cells[$cell] = new html_table_cell($anchor_name);
    		$cell++;
    		
    		$grid->data[$row]->cells[$cell] = new html_table_cell($img_foro);
    		$cell++;
    		
    		$grid->data[$row]->cells[$cell] = new html_table_cell($img_quiz);
    		$cell++;
    		
    		$grid->data[$row]->cells[$cell] = new html_table_cell($img_gradebook);
    		$cell++;	
    		
    		$row++;
    	}
    	
    	$output = html_writer::table($grid);
    	
    	//Reemplazado por lo que aparece más abajo, dado que así se mantiene el orden.
    	$output .= html_writer::start_tag('div');
    	$tutorial = array();
    	
    	$tutorial[0][0] = html_writer::empty_tag('img', array('src' => get_img_source('0'), 'alt' => 'Básico', 'title' => 'Básico'));
    	$tutorial[0][1] = html_writer::empty_tag('img', array('src' => get_img_source('1'), 'alt' => 'Intermedio', 'title' => 'Intermedio'));    	
    	$tutorial[0][2] = html_writer::empty_tag('img', array('src' => get_img_source('2'), 'alt' => 'Avanzado', 'title' => 'Avanzado'));
    	$tutorial[0][3] = html_writer::empty_tag('img', array('src' => get_img_source('3'), 'alt' => 'Experto', 'title' => 'Experto'));
    	
    	$tutorial[1][0] = html_writer::start_tag('center').html_writer::start_tag('b').get_string('basico','local_uai_toolbox') .html_writer::end_tag('b').html_writer::end_tag('center');
    	$tutorial[1][1] = html_writer::start_tag('center').html_writer::start_tag('b').get_string('intermedio','local_uai_toolbox') .html_writer::end_tag('b').html_writer::end_tag('center');
    	$tutorial[1][2] = html_writer::start_tag('center').html_writer::start_tag('b').get_string('avanzado','local_uai_toolbox') .html_writer::end_tag('b').html_writer::end_tag('center');
    	$tutorial[1][3] = html_writer::start_tag('center').html_writer::start_tag('b').get_string('experto','local_uai_toolbox') .html_writer::end_tag('b').html_writer::end_tag('center');
    	
    	$logos = new html_table();
    	$logos->attributes = array('class'=>'logos');
    	
    	$logos->data = $tutorial;
    	
    	$output .= html_writer::table($logos);
    	
    	$output .= html_writer::end_tag('div');
    	/*
    	$output .= html_writer::start_tag('div', array('class' => 'tutoriales'));
    	$output .=html_writer::start_tag('table');
    	$output .= html_writer::start_tag('tr');
    	$output .= html_writer::empty_tag('td');
       	$output .= html_writer::empty_tag('img', array('src' => get_img_source('0'), 'alt' => 'Básico', 'title' => 'Básico'));
    	$output .= html_writer::empty_tag('td');
       	$output .= html_writer::empty_tag('img', array('src' => get_img_source('1'), 'alt' => 'Intermedio', 'title' => 'Intermedio'));    	
    	$output .= html_writer::empty_tag('td');
       	$output .= html_writer::empty_tag('img', array('src' => get_img_source('2'), 'alt' => 'Avanzado', 'title' => 'Avanzado'));
    	$output .= html_writer::empty_tag('td');
       	$output .= html_writer::empty_tag('img', array('src' => get_img_source('3'), 'alt' => 'Experto', 'title' => 'Experto'));    	
    	$output .= html_writer::empty_tag('td');
    //	$output .= html_writer::empty_tag('img', array('src' => get_img_source('4'), 'alt' => 'Error', 'title' => 'Error'));
    	$output .= html_writer::end_tag('tr');
    	$output .= html_writer::end_tag('table');
       	$output .= html_writer::end_tag('div');
    	$output .= html_writer::start_tag('div', array('class' => 'tutoriales'));
        $output .= html_writer::start_tag('b');
        $output .=html_writer::start_tag('table');
    	$output .= html_writer::start_tag('tr');
    	$output .= html_writer::empty_tag('td');
        $output .= html_writer::tag('a', ''.get_string('basico','uai_toolbox'), array('style'=>'color:#000;'));
        $output .= html_writer::empty_tag('td');
        $output .= html_writer::tag('a', ''.get_string('intermedio','uai_toolbox'), array('style'=>'color:#000;'));
        $output .= html_writer::empty_tag('td');
        $output .= html_writer::tag('a', ''.get_string('avanzado','uai_toolbox'), array('style'=>'color:#000;'));
        $output .= html_writer::empty_tag('td');
        $output .= html_writer::tag('a',''.get_string('experto','uai_toolbox'), array('style'=>'color:#000;'));
        $output .= html_writer::empty_tag('td');
        $output .= html_writer::end_tag('tr');
    	$output .= html_writer::end_tag('table');
        $output .= html_writer::end_tag('b');
    	$output .= html_writer::end_tag('div');
        
    	*/
    	
    	return $output;
    }    
    /**
     * Obtiene un Listbox con un Título en donde el m�todo onChange consiste en redirigir a la pagina
     * actual con parametros adicionales.
     * @param array $datos arreglo con el valor y el texto de las opciones del listbox e.g.
     * array('valor1' => 'texto1', 'valor2' => 'texto2', etc.).
     * @param string $view texto que representa el contexto donde se requiere el listbox.
     * @param string $text texto que representa el nombre del listbox y adem�s se usa para generar
     * el t�tulo 'Filtro $text'.
     * @param int $selectedId valor de la opci�n del listbox que aparecer� seleccionada .
     * @param int $idExtra valor de alg�n parametro adicional para el evento onChange del listbox.
     * @param string|bool $nothing
     * @return string Fragmento HTML
     */
    

	public function show_barra_toolbox($datos, $view, $text, $selectedId = '', $idExtra = '', $nothing = true){
		global $CFG;
		
		$output = html_writer::start_tag('div', array('class' => 'barraToolBox'));
    	$output .= html_writer::empty_tag('br');
    	
    	if($selectedId == 0){
    		$selectedId = '';
    	}
		if($idExtra == 0){
    		$idExtra = '';
    	}
    	
    	if($view == 'ranking'){
    		$ruta = $CFG->wwwroot.'/local/uai_toolbox/view.php?view='.$view.'&idFacultad=';
    	}else{
    		if($text == 'Profesor'){
    			$ruta = $CFG->wwwroot.'/local/uai_toolbox/view.php?view=profesores&idFacultad='.$idExtra.'&idProfesor=';
    		}else{
    			$ruta = $CFG->wwwroot.'/local/uai_toolbox/view.php?view=profesores&idProfesor='.$idExtra.'&idFacultad=';
    		}
    	}
    	
    	$output .= html_writer::start_tag('table');
    	$output .= html_writer::empty_tag('td');
    	$output .= html_writer::select($datos, $text, $selectedId, $nothing, array('onchange' => 'window.location="'.$ruta.'"+this.options[this.selectedIndex].value'));		
    	$output .= html_writer::empty_tag('td');
	    	
    	$ranking = get_summary();
   
	    if($selectedId == '' && !empty($ranking['uai']))
	    {		       	
	    	$output .= html_writer::label(''.get_string('miranking','uai_toolbox').'', null,'FALSE',array('style'=>'font-weight:bold;')); 
	    	$output .= html_writer::label($ranking['uai'], null,'FALSE',array('style'=>'font-weight:bold;'));		    	  	
	    }
	    elseif(!empty($ranking['facultad']) && $selectedId == $ranking['idfacultad'])
	    {
	    	$output .= html_writer::label(''.get_string('miranking','uai_toolbox').'', null,'FALSE',array('style'=>'font-weight:bold;')); 
	       	$output .= html_writer::label($ranking['facultad'], null,'FALSE',array('style'=>'font-weight:bold;'));	 	
	    }
    
	    $output .= html_writer::end_tag('table');
        $output .= html_writer::end_tag('div');
          
        return $output;
 }
    
    /**
     * Devuelve una tabla ordenada por el ranking de forma ascendente mostrando el
     * ranking, nombre y nivel de cada elemento, adem�s en caso que la cantidad de elementos
     * sea superior a $pageCount entrega en el footer de la tabla dos botones para hacer scroll de
     * las p�ginas.
     * @param array $datos arreglo con los datos del ranking e.g.
     * array('idDato' => stdClass object('nombre' => 'nombre1', 'rank' => 'rank1', 'score' => 'score1'), etc.).
     * @param string $view texto que representa el contexto donde se requiere la tabla. e.g. 'ranking'
     * @param string $text texto que representa el elemento 'nombre' e.g. 'Profesor'
     * @param int $pageId n�mero de la p�gina a mostrar.
     * @param bool $show_nombre boolean que representa si se puede o no ver los nombres de los datos.
     * @param int $rank n�mero que representa mi posici�n en el ranking actual.
     * @param int $idExtra valor de alg�n parametro adicional para el anchor del nombre.
     * @param int $pageCount n�mero de datos por p�gina.
     * @return string Fragmento HTML
     */
	public function show_ranking($datos, $view, $text, $pageId = 0, $rank = 0, $idExtra = '', $pageCount = 10){
		global $CFG, $USER;

		if($idExtra == 0){
    		$idExtra = '';
    	}
		
    	//Esto funciona cuando un profesor en específico intenta ingresar,
    	//lo envía a su página en el ranking.
		if($rank != 0){
			$pageId = floor($rank/$pageCount);		
		}
		
		//Se hace control de que si se fuerza la búsqueda de una página por el navegador,
		//esta se encuentre dentro del ranking, y la localice al final si se coloca un número
		//superior al número debido de páginas.
		if($pageId*$pageCount >= count($datos)){
				$pageId = floor(count($datos)/$pageCount);
		}
		//y al comienzo si es negativo.
		if($pageId < 0){
			$pageId = 0;
		}
		
    	$table = new html_table();    	
    	$table->attributes = array('class'=>'tablaRanking');
    	$table->data = array();
    	
    	$table->data[0] = new html_table_row();
    	$table->data[0]->attributes['class'] .= 'tablaRankingHeader';
    	
    	$cell = 0;
    	
    	$table->data[0]->cells[$cell] = new html_table_cell(get_string('ranking','uai_toolbox'));
    	$cell++;    	    
    	$table->data[0]->cells[$cell] = new html_table_cell(get_string('profesor','uai_toolbox'));
    	$cell++;
    	$table->data[0]->cells[$cell] = new html_table_cell(get_string('nivel','uai_toolbox'));
    	$cell++;
    	
    	$row = 1;
    	$inicio = 0;
    	
    	foreach($datos as $idDato => $dato){
    		if($row == $pageCount + 1){
    			break;
    		}
    		if($inicio < $pageId*$pageCount){
    			$inicio++;
    			continue;
    		}    		    		
    		
    		if($view == 'ranking'){
    			$anchor_name = html_writer::tag('a', $dato->nombre, array('href'=>$CFG->wwwroot.'//toolbox/view.php?view=profesores&idProfesor='.$idDato.'&idFacultad='.$idExtra));
    		}else{
    			$anchor_name = html_writer::tag('a', $dato->nombre, array('href'=>$CFG->wwwroot.'//toolbox/view.php?view=ranking&idFacultad='.$idDato));
    		}
    		
    		$cell = 0;
    		
    		$table->data[$row] = new html_table_row();
    		
    		if($view == 'ranking'){
	    		if($idDato == $USER->id){
	    			$table->data[$row]->attributes['class'] .= 'tablaRankingMiFila';
	    		
    		}   
         		 
    		$table->data[$row]->cells[$cell] = new html_table_cell($dato->rank); 
    		$cell++;
    		
    	 
    		
	    	$table->data[$row]->cells[$cell] = new html_table_cell(html_writer::tag('a', $dato->nombre, array('href'=>$CFG->wwwroot.'/user/profile.php?id='.$idDato,'style'=>'color:#000;font-weight:bold;')));	   
	    	$cell++;
    		
    	
    		
    		$table->data[$row]->cells[$cell] = new html_table_cell($dato->score); 
    		$cell++;
    		
    		$row++;
    		 }
    	}
    	
    	$output = html_writer::table($table);

    	
    	return $output;
	}
    
	
	/**
	 * Devuelve un parrafo de descripci�n del contexto actual.
	 * @param string $text texto de la descripci�n.
	 * @return string Fragmento HTML
	 */
    public function show_descripcion($text){
    	return html_writer::tag('p', $text, array('class' => 'descripcion'));
    }
    public function about()
    {
	
    global $CFG;
    $ruta = $CFG->wwwroot.'/local/uai_toolbox/';
	/**
	 * Esta funci�n contiene una tabla en la cual est� un texto de desprici�n del bloque y tambi�n una im�gen. El texto est� dentro de un string en uai_toolbox.php en la carpeta lang. 
	 * El array est� vac�o dado que no se necesita datos, solo texto e imagenes. 
	 * @param $table Crea la tabla .
	 * @param $output Se asigna el tag que se pondr� en la tabla, considerando tambi�n el contenido.
	 * @return string Fragmento HTML
	 */
    
    $output =html_writer::start_tag('div');
    $output .= get_string('about_content','local_uai_toolbox');
    $output .=html_writer::end_tag('div');
  
     return $output;
    }
 }
    
