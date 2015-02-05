<?php



// We define a new capability, the ability to modify the toolbox
$capabilities = array(

    'local/toolbox:viewtoolboxmanager' => array(
    	// Capability type (write, read, etc.)
        'captype' => 'read',
        // Context in which the capability can be set (course, category, etc.)
        'contextlevel' => CONTEXT_SYSTEM,
        // Default values for different roles (only teachers and managers can modify)
        'legacy' => array(
            'teacher' => CAP_PROHIBIT,
            'editingteacher' => CAP_PROHIBIT,
            'manager' => CAP_ALLOW,
			'student'=>CAP_PROHIBIT)),

	'local/toolbox:viewtoolboxstudent'=> array(
		'captype' => 'read',
		'contextlevel' =>CONTEXT_SYSTEM,
		'legacy' => array(
            'manager' => CAP_ALLOW,
			'student'=>CAP_ALLOW,
'teacher' => CAP_ALLOW)),

	'local/toolbox:viewtoolboxteacher' => array(
    	// Capability type (write, read, etc.)
        'captype' => 'read',
        // Context in which the capability can be set (course, category, etc.)
        'contextlevel' => CONTEXT_SYSTEM,
        // Default values for different roles (only teachers and managers can modify)
        'legacy' => array(
            'teacher' => CAP_PROHIBIT,
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW,
            'student'=>CAP_PROHIBIT)),

'local/toolbox:viewtoolboxuser' => array(
    	// Capability type (write, read, etc.)
        'captype' => 'read',
        // Context in which the capability can be set (course, category, etc.)
        'contextlevel' => CONTEXT_SYSTEM,
        // Default values for different roles (only teachers and managers can modify)
        'legacy' => array(
            'teacher' => CAP_PROHIBIT,
            'editingteacher' => CAP_PROHIBIT,
            'manager' => CAP_ALLOW,
            'student'=>CAP_PROHIBIT,
'user' => CAP_ALLOW,
'frontpage' => CAP_ALLOW))
);