<?php
$CI = get_instance();
$CI->load->database();
$CI->load->dbforge();

$parent_menu_id = 0;
// DATA TO INSERT OR UPDATE
$addon_parent_menu_data = array(
	'status' => 1,
	'superadmin_access' => 0,
	'admin_access' => 0,
	'teacher_access' => 1,
	'student_access' => 1,
	'is_addon' => 1,
	'unique_identifier' => "live-class",
	'route_name' => '',
	'displayed_name' => 'live_class',
	'parent' => 0,
	'sort_order' => 21,
	'icon' => 'dripicons-camcorder'
);

// CHECK IF THE DATA IS ALREADY THERE
$checker = array(
	'unique_identifier' => 'live-class'
);
$CI->db->where($checker);
$number_of_rows = $CI->db->get('menus')->num_rows();

// IF IT NOT, INSERT AS NEW ROW OR UPDATE THE EXISTING ONE.
if($number_of_rows > 0) {
	$CI->db->where($checker);
	$CI->db->update('menus', $addon_parent_menu_data);

	$CI->db->where($checker);
	$parent_menu_details = $CI->db->get('menus')->row_array();
	$parent_menu_id = $parent_menu_details['id'];

}else{

	$CI->db->insert('menus', $addon_parent_menu_data);
	$parent_menu_id = $CI->db->insert_id();
}

// ITS TIME TO INSERT OR UPDATE SOME SUB MENUS
// SUBMENU 1
$addon_submenu_data_1 = array(
	'status' => 1,
	'superadmin_access' => 0,
	'admin_access' => 0,
	'teacher_access' => 1,
	'is_addon' => 1,
	'unique_identifier' => "live-class-settings",
	'route_name' => 'live_class/settings',
	'displayed_name' => 'live_class_settings',
	'parent' => $parent_menu_id,
	'sort_order' => 3
);

// CHECK IF THE DATA IS ALREADY THERE
$checker_submenu_1 = array(
	'unique_identifier' => 'live-class-settings'
);
$CI->db->where($checker_submenu_1);
$number_of_rows_submenu_1 = $CI->db->get('menus')->num_rows();

// IF IT NOT, INSERT AS NEW ROW OR UPDATE THE EXISTING ONE.
if($number_of_rows_submenu_1 > 0) {
	$CI->db->where($checker_submenu_1);
	$CI->db->update('menus', $addon_submenu_data_1);

}else{

	$CI->db->insert('menus', $addon_submenu_data_1);
}

// SUBMENU 2
$addon_submenu_data_2 = array(
	'status' => 1,
	'teacher_access' => 1,
	'student_access' => 1,
	'is_addon' => 1,
	'unique_identifier' => "your-live-class",
	'route_name' => 'live_class',
	'displayed_name' => 'your_live_class',
	'parent' => $parent_menu_id,
	'sort_order' => 0
);

// CHECK IF THE DATA IS ALREADY THERE
$checker_submenu_2 = array(
	'unique_identifier' => 'your-live-class'
);
$CI->db->where($checker_submenu_2);
$number_of_rows_submenu_2 = $CI->db->get('menus')->num_rows();

// IF IT NOT, INSERT AS NEW ROW OR UPDATE THE EXISTING ONE.
if($number_of_rows_submenu_2 > 0) {
	$CI->db->where($checker_submenu_2);
	$CI->db->update('menus', $addon_submenu_data_2);

}else{

	$CI->db->insert('menus', $addon_submenu_data_2);
}

// SUBMENU 3
$addon_submenu_data_3 = array(
	'status' => 1,
	'teacher_access' => 1,
	'is_addon' => 1,
	'unique_identifier' => "add-new",
	'route_name' => 'live_class/create',
	'displayed_name' => 'add_new',
	'parent' => $parent_menu_id,
	'sort_order' => 0
);

// CHECK IF THE DATA IS ALREADY THERE
$checker_submenu_3 = array(
	'unique_identifier' => 'add-new'
);
$CI->db->where($checker_submenu_3);
$number_of_rows_submenu_3 = $CI->db->get('menus')->num_rows();

// IF IT NOT, INSERT AS NEW ROW OR UPDATE THE EXISTING ONE.
if($number_of_rows_submenu_3 > 0) {
	$CI->db->where($checker_submenu_3);
	$CI->db->update('menus', $addon_submenu_data_3);

}else{

	$CI->db->insert('menus', $addon_submenu_data_3);
}


// CREATING LIVE CLASS SETTINGS TABLE
$live_class_settings_fields = array(
	'id' => array(
		'type' => 'INT',
		'constraint' => 11,
		'unsigned' => TRUE,
		'auto_increment' => TRUE,
		'collation' => 'utf8_unicode_ci'
	),
	'zoom_api_key' => array(
		'type' => 'VARCHAR',
		'constraint' => '255',
		'default' => null,
		'null' => TRUE,
		'collation' => 'utf8_unicode_ci'
	),
	'zoom_secret_key' => array(
		'type' => 'VARCHAR',
		'constraint' => '255',
		'default' => null,
		'null' => TRUE,
		'collation' => 'utf8_unicode_ci'
	),
	'user_id' => array(
		'type' => 'INT',
		'constraint' => '11',
		'default' => null,
		'null' => TRUE,
		'collation' => 'utf8_unicode_ci'
	),
	'school_id' => array(
		'type' => 'INT',
		'constraint' => '11',
		'default' => null,
		'null' => TRUE,
		'collation' => 'utf8_unicode_ci'
	)
);
$CI->dbforge->add_field($live_class_settings_fields);
$CI->dbforge->add_key('id', TRUE);
$attributes = array('collation' => "utf8_unicode_ci");
$CI->dbforge->create_table('live_class_settings', TRUE);


// CREATING LIVE CLASS TABLE
$live_class_fields = array(
	'id' => array(
		'type' => 'INT',
		'constraint' => 11,
		'unsigned' => TRUE,
		'auto_increment' => TRUE,
		'collation' => 'utf8_unicode_ci'
	),
	'class_id' => array(
		'type' => 'INT',
		'constraint' => '11',
		'default' => null,
		'null' => TRUE,
		'collation' => 'utf8_unicode_ci'
	),
	'subject_id' => array(
		'type' => 'INT',
		'constraint' => '11',
		'default' => null,
		'null' => TRUE,
		'collation' => 'utf8_unicode_ci'
	),
	'date' => array(
		'type' => 'INT',
		'constraint' => '11',
		'default' => null,
		'null' => TRUE,
		'collation' => 'utf8_unicode_ci'
	),
	'time' => array(
		'type' => 'INT',
		'constraint' => '11',
		'default' => null,
		'null' => TRUE,
		'collation' => 'utf8_unicode_ci'
	),
	'teacher_id' => array(
		'type' => 'INT',
		'constraint' => '11',
		'default' => null,
		'null' => TRUE,
		'collation' => 'utf8_unicode_ci'
	),
	'zoom_meeting_id' => array(
		'type' => 'VARCHAR',
		'constraint' => '255',
		'default' => null,
		'null' => TRUE,
		'collation' => 'utf8_unicode_ci'
	),
	'zoom_meeting_password' => array(
		'type' => 'VARCHAR',
		'constraint' => '255',
		'default' => null,
		'null' => TRUE,
		'collation' => 'utf8_unicode_ci'
	),
	'topic' => array(
		'type' => 'longtext',
		'default' => null,
		'null' => TRUE,
		'collation' => 'utf8_unicode_ci'
	),
	'attachment' => array(
		'type' => 'VARCHAR',
		'constraint' => '255',
		'default' => null,
		'null' => TRUE,
		'collation' => 'utf8_unicode_ci'
	),
	'school_id' => array(
		'type' => 'INT',
		'constraint' => '11',
		'default' => null,
		'null' => TRUE,
		'collation' => 'utf8_unicode_ci'
	),
	'session' => array(
		'type' => 'VARCHAR',
		'constraint' => '255',
		'default' => null,
		'null' => TRUE,
		'collation' => 'utf8_unicode_ci'
	),
	'created_at' => array(
		'type' => 'INT',
		'constraint' => '11',
		'default' => null,
		'null' => TRUE,
		'collation' => 'utf8_unicode_ci'
	)
);
$CI->dbforge->add_field($live_class_fields);
$CI->dbforge->add_key('id', TRUE);
$attributes = array('collation' => "utf8_unicode_ci");
$CI->dbforge->create_table('live_classes', TRUE);
?>
