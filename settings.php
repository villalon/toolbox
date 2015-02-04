<?php

defined('MOODLE_INTERNAL') || die;

global $PAGE; 

if ($hassiteconfig) {

	$settings = new admin_settingpage('local_uai_toolbox', 'Toolbox');
    $ADMIN->add('localplugins', $settings);
	
    $options = array('yes'=>get_string('yes','local_uai_toolbox'), 'no'=>get_string('no','local_uai_toolbox')); 
	$settings->add(new admin_setting_configselect('local_uai_toolbox_cron_activate',get_string('cronactive','local_uai_toolbox'), 
                       get_string('cronactive_desc','local_uai_toolbox'),
						'no', $options));
	$time = array();
	for($i=0; $i<24; $i++){
		$time[$i]=$i;
	}
	
	$settings->add(new admin_setting_configselect('local_uai_toolbox_start_cron',get_string('starttime','local_uai_toolbox') , 
                           get_string('starttime_desc','local_uai_toolbox'),
                           '3', $time));
                           
    $settings->add(new admin_setting_configselect('local_uai_toolbox_finish_cron', get_string('finishtime','local_uai_toolbox'), 
                           get_string('finishtime_desc','local_uai_toolbox'),
                           '6', $time));
	$settings->add(new admin_setting_configtext('local_uai_toolbox_interval', get_string('interval','local_uai_toolbox'), 
                   get_string('interval_desc','local_uai_toolbox'),
	 23*60, PARAM_INT));                        
    
                           
                           
	$link='<a href="'.$CFG->wwwroot.'/local/uai_toolbox/execron.php">'.get_string('cronnow', 'local_uai_toolbox').'</a>'.'  '. '-'
	.'  '.get_string('cronnow_desc', 'local_uai_toolbox');  	

	$settings->add(new admin_setting_heading('local_uai_toolbox', '', $link));


}

