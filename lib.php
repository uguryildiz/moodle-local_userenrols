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
     *  local_userenrols
     *
     *  This plugin will import user enrollments and group assignments
     *  from a delimited text file. It does not create new user accounts
     *  in Moodle, it will only enroll existing users in a course.
     *
     * @author      Fred Woolard <woolardfa@appstate.edu>
     * @copyright   (c) 2013 Appalachian State Universtiy, Boone, NC
     * @license     GNU General Public License version 3
     * @package     local
     * @subpackage  userenrols
     */

    defined('MOODLE_INTERNAL') || die();

    require_once("$CFG->dirroot/lib/accesslib.php");
    require_once("$CFG->dirroot/lib/enrollib.php");
    require_once("$CFG->dirroot/lib/grouplib.php");
    require_once("$CFG->dirroot/lib/navigationlib.php");
    require_once("$CFG->dirroot/group/lib.php");


    /**
     * Hook to insert a link in global navigation menu block
     * @param global_navigation $navigation
     */
    /*
    function local_userenrols_extends_navigation(global_navigation $navigation, $context)
    {
    	//$navigation->add('deneme');
    	$navigation->add(
    			get_string('IMPORT_MENU_LONG', local_userenrols_plugin::PLUGIN_NAME), 
    			local_userenrols_plugin::get_plugin_url('import', $context->instanceid), 
    			navigation_node::TYPE_SETTING, null, null, new pix_icon('i/import', 'import'));
    	
    }*/
    
    function userenrols_extends_navigation(global_navigation $navigation)
    {
    	
    	global $PAGE;
    	
    	//$context = context_module::instance($PAGE->course->id);
    	//$coursenode = $PAGE->navigation->find($PAGE->course->id, navigation_node::TYPE_COURSE);
    	if ($PAGE->context == null || $PAGE->context->contextlevel != CONTEXT_COURSE || false == is_object($PAGE->settingsnav)) {
    		return;
    	}
    	
    	// When on front page there is 'frontpagesettings' node, other
    	// courses will have 'courseadmin' node
    	if (null == ($coursenode =  $PAGE->settingsnav->find('courseadmin',navigation_node::TYPE_COURSE))) {
    		// Keeps us off the front page
    		return;
    	}
    	
    	if(!has_capability(local_userenrols_plugin::REQUIRED_CAP, $PAGE->context))
    	{
    		return;
    	}

 
    	    	
    	//$coursenode = $PAGE->settingsnav->find('courseadmin',navigation_node::TYPE_COURSE);
    	//print_r($coursenode);
    	//echo $coursenode;
    	
    	//$PAGE->settingsnav->add(
    	$coursenode->add(
    			get_string('IMPORT_MENU_LONG', local_userenrols_plugin::PLUGIN_NAME),
    			local_userenrols_plugin::get_plugin_url('import', $PAGE->course->id),
    			navigation_node::TYPE_SETTING,
    			get_string('IMPORT_MENU_SHORT', local_userenrols_plugin::PLUGIN_NAME),
    			null, new pix_icon('i/group', get_string('IMPORT_MENU_LONG', local_userenrols_plugin::PLUGIN_NAME)));
    	
    	//echo $PAGE->course->id;
    	// Only add this settings item on non-site course pages.
    	/*
    	if (!$PAGE->course or $PAGE->course->id == 1) {
    		return;
    	}*/
    	
    	// Only let users with the appropriate capability see this settings item.
    	//$settingnode = $navigation->get('users');
    	//print_r($settingnode);
    	//echo $navigation->page->context->instanceid;
    	//$settingnode->add_node('test');
    	
    	/*
    	if ($settingnode = $settingsnav->find('courseadmin', navigation_node::TYPE_COURSE)) {
    		$strfoo = get_string('foo', 'local_userenrols');
    		$url = new moodle_url('/local/userenrols/import.php', array('id' => $PAGE->course->id));
    		$foonode = navigation_node::create(
    				$strfoo,
    				$url,
    				navigation_node::NODETYPE_LEAF,
    				'userenrols',
    				'userenrols',
    				new pix_icon('i/import', $strfoo)
    		);
    		if ($PAGE->url->compare($url, URL_MATCH_BASE)) {
    			$foonode->make_active();
    		}
    		$settingnode->add_node($foonode);
    	}*/
    	
    	//echo "test";
    	// If not in a course context, then leave
       /*
    	if ($context == null || $context->contextlevel != CONTEXT_COURSE) {
    		return;
    	}*/
    	//$courseadmin_node = $navigation->get('courseadmin');
    	//$courseadmin_node->add('test');
    
    	// When on front page there is 'frontpagesettings' node, other
    	// courses will have 'courseadmin' node
    	/*
    	if (null == ($courseadmin_node = $navigation->get('courseadmin'))) {
    		// Keeps us off the front page
    		return;
    	}
    	if (null == ($useradmin_node = $courseadmin_node->get('users'))) {
    		return;
    	}
    
    	// Add our links
    	$useradmin_node->add(
    			get_string('IMPORT_MENU_LONG', local_userenrols_plugin::PLUGIN_NAME),
    			local_userenrols_plugin::get_plugin_url('import', $context->instanceid),
    			navigation_node::TYPE_SETTING,
    			get_string('IMPORT_MENU_SHORT', local_userenrols_plugin::PLUGIN_NAME),
    			null, new pix_icon('i/import', 'import'));
    	/*
    	 $useradmin_node->add(
    	 		get_string('ASSIGN_MENU_LONG', local_userenrols_plugin::PLUGIN_NAME),
    	 		local_userenrols_plugin::get_plugin_url('assign', $context->instanceid),
    	 		navigation_node::TYPE_SETTING,
    	 		get_string('ASSIGN_MENU_SHORT', local_userenrols_plugin::PLUGIN_NAME),
    	 		null, new pix_icon('t/move', 'assign')); */
    
    }


    /**
     * Hook to insert a link in settings navigation menu block
     *
     * @param settings_navigation $navigation
     * @param course_context      $context
     * @return void
     */
    
    function local_userenrols_extends_settings_navigation(settings_navigation $navigation, $context)
    {	

        // If not in a course context, then leave
        
    	if ($context == null || $context->contextlevel != CONTEXT_COURSE) {
            return;
        }

        // When on front page there is 'frontpagesettings' node, other
        // courses will have 'courseadmin' node
        if (null == ($courseadmin_node = $navigation->get('courseadmin'))) {
            // Keeps us off the front page
            return;
        }
        if (null == ($useradmin_node = $courseadmin_node->get('users'))) {
            return;
        }

        // Add our links        
        $useradmin_node->add(
            get_string('IMPORT_MENU_LONG', local_userenrols_plugin::PLUGIN_NAME),
            local_userenrols_plugin::get_plugin_url('import', $context->instanceid),
            navigation_node::TYPE_SETTING,  		
            get_string('IMPORT_MENU_SHORT', local_userenrols_plugin::PLUGIN_NAME),
            null, new pix_icon('i/import', 'import')); 
		/*
        $useradmin_node->add(
            get_string('ASSIGN_MENU_LONG', local_userenrols_plugin::PLUGIN_NAME),
            local_userenrols_plugin::get_plugin_url('assign', $context->instanceid),
            navigation_node::TYPE_SETTING,
            get_string('ASSIGN_MENU_SHORT', local_userenrols_plugin::PLUGIN_NAME),
            null, new pix_icon('t/move', 'assign')); */

    }

   
    
    


    class local_userenrols_plugin
    {

        /*
         * Class constants
         */

        const PLUGIN_NAME                 = 'local_userenrols';
        const PLUGIN_PATH                 = 'local/userenrols';
        const PLUGIN_FILEAREA             = 'uploads';

        const REQUIRED_CAP                = 'moodle/course:managegroups';

        const PARAM_COURSE_ID             = 'id';

        const MAXFILESIZE                 = 51200;

        const FORMID_ROLE_ID              = 'role_id';
        const FORMID_USER_ID_FIELD        = 'user_id';
        const FORMID_GROUP                = 'group';
        const FORMID_GROUP_ID             = 'group_id';
        const FORMID_GROUP_CREATE         = 'group_create';
        const FORMID_FILES                = 'filepicker';
        const FORMID_METACOURSE           = 'metacourse';
        const FORMID_GROUPMODE            = 'groupmode';
        const FORMID_METAGROUP            = 'metagroup';
        const FORMID_REMOVE_CURRENT       = 'remove';

        const DEFAULT_USER_ID_FIELD       = 'username';



        /*
         * Member vars
         */

        /**
         * @access private
         * @staticvar array
         */
        private static $user_id_field_options    = null;



        /*
         * Methods
         */

        /**
         * Return a url for this plugin's interfaces
         *
         * @access public
         * @static
         * @param  int          $courseid        Optional id for course
         * @return moodle_url
         */
        public static function get_plugin_url($action, $courseid = 0)
        {
            global $CFG;



            return new moodle_url("$CFG->wwwroot/" . self::PLUGIN_PATH . "/{$action}.php", $courseid ? array(self::PARAM_COURSE_ID => $courseid) : null);

        }



        /**
         * Return list of valid options for user record field matching
         *
         * @access public
         * @static
         * @return array
         */
        public static function get_user_id_field_options()
        {

            if (self::$user_id_field_options == null) {
                self::$user_id_field_options = array(
                    'username' => get_string('username')
                    /*'email'    => get_string('email'),*/
                    /*'idnumber' => get_string('idnumber')*/
                );
            }

            return self::$user_id_field_options;

        }



        /**
         * Make a role assignment in the specified course using the specified role
         * id for the user whose id information is passed in the line data.
         *
         * @access public
         * @static
         * @param stdClass      $course           Course in which to make the role assignment
         * @param stdClass      $enrol_instance   Enrol instance to use for adding users to course
         * @param string        $id_field         The field (column) name in Moodle user rec against which to query using the imported data
         * @param int           $role_id          Id of the role to use in the role assignment
         * @param boolean       $group_assign     Whether or not to assign users to groups
         * @param int           $group_id         Id of group to assign to, 0 indicates use group name from import file
         * @param boolean       $group_create     Whether or not to create new groups if needed
         * @param stored_file   $import_file      File in local repository from which to get enrollment and group data
         * @return string                         String message with results
         *
         * @uses $DB
         */
        public static function import_file(stdClass $course, stdClass $enrol_instance, $id_field, $role_id, $group_assign, $group_id, $group_create, stored_file $import_file)
        {
            global $DB;



            // Default return value
            $result = '';

            // Need one of these in the loop
            $course_context = context_course::instance($course->id);

            // Choose the regex pattern based on the $id_field
            switch($id_field)
            {
                case 'email':
                    $regex_pattern = '/^"? *([a-z0-9][\w.%-]*@[a-z0-9][a-z0-9.-]{0,61}[a-z0-9]\.[a-z]{2,6}) *"?(?: *[;,\t] *"? *([a-z0-9][\w\' .,&-]+))? *"?$/Ui';
                    break;
                case 'idnumber':
                    $regex_pattern = '/^"? *(\d{1,32}) *"?(?: *[;,\t] *"? *([a-z0-9][\w\' .,&-]+))? *"?$/Ui';
                    break;
                default:
                    $regex_pattern = '/^"? *([a-z0-9][\w@.-]*) *"?(?: *[;,\t] *"? *([a-z0-9][\w\' .,&-]+))? *"?$/Ui';
                    break;
            }

            // If doing group assignments, want to know the valid
            // courses for the course
            $selected_group = null;
            if ($group_assign) {

                if (false === ($existing_groups = groups_get_all_groups($course->id))) {
                    $existing_groups = array();
                }

                if ($group_id > 0) {
                    if (array_key_exists($group_id, $existing_groups)) {
                        $selected_group = $existing_groups[$group_id];
                    } else {
                        // Error condition
                        return sprintf(get_string('ERR_INVALID_GROUP_ID', self::PLUGIN_NAME), $group_id);
                    }
                }

            }

            // Iterate the list of active enrol plugins looking for
            // the meta course plugin
            $metacourse = false;
            $enrols_enabled = enrol_get_instances($course->id, true);
            foreach($enrols_enabled as $enrol) {
                if ($enrol->enrol == 'meta') {
                    $metacourse = true;
                    break;
                }
            }

            // Get an instance of the enrol_manual_plugin (not to be confused
            // with the enrol_instance arg)
            $manual_enrol_plugin = enrol_get_plugin('manual');

            $user		  =
            $user_rec     =
            $new_group    =
            $new_grouping = null;
            
            // Open and fetch the file contents
            $fh = $import_file->get_content_file_handle();
            $line_num = 0;
            while (false !== ($line = fgets($fh))) {
                // first row pass
            	if($line_num != 0){
	            	
	
	                // Clean these up for each iteration
	                unset($user_rec, $new_group, $new_grouping, $user);
	                //echo mb_detect_encoding($line);
	                //exit;
	                if (!($line = mb_convert_encoding(trim($line),mb_detect_encoding($line), "Windows-1254"))) continue;
	
	                // Parse the line, from which we may get one or two
	                // matches since the group name is an optional item
	                // on a line by line basis
	                /*if (!preg_match($regex_pattern, $line, $matches)) {
	                    $result .= sprintf(get_string('ERR_PATTERN_MATCH', self::PLUGIN_NAME), $line_num, $line);
	                    continue;
	                }*/
	                
	                if(false === ($matches = explode(";",$line))){ 
	                	$result .= sprintf(get_string('ERR_PATTERN_MATCH', self::PLUGIN_NAME), $line_num, $line);
	                }
	                
	                
	
	                $user_id_value  = $matches[0];
	                $group_name     = isset($matches[8]) ? $matches[8] : '';
	                $firstname = $matches[2];
	                $lastname = $matches[3];
	
	                // User must already exist, we import enrollments
	                // into courses, not users into the system
	                if (false === ($user_rec = $DB->get_record('user', array($id_field => addslashes($user_id_value))))) {
	                	
	                	unset($user_rec);
	                	
	                	if(0 === preg_match("([0-9]{9})",$matches[0])){
	                		$result .= sprintf(get_string('ERR_USERNAME_MATCH', self::PLUGIN_NAME), $line_num, $user_id_value);
	                		$line_num++;
	                		continue;
	                	}else{
		                	// user object create
		                	$user = new StdClass();
		                	$user->auth = 'manual';
		                	$user->confirmed = 1;
		                	$user->mnethostid = 1;
		                	$user->email = $user_id_value."@kocaeli.edu.tr";
		                	$user->username = $user_id_value;
		                	$pass = $user_id_value . date("YmdHis");
		                	$user->password = md5($pass);
		                	$user->lastname = $lastname;
		                	$user->firstname = $firstname;
		                	$user->idnumber = $user_id_value;
		                	$user->lang = "tr";
		                	$user->city = "KOCAELİ";
		                	$user->country = "TR";	                	
		                	$user->id = $DB->insert_record('user', $user);
		                	
		                	$user_rec = $DB->get_record('user', array($id_field => addslashes($user_id_value)));
		                	$result .= sprintf(get_string('INF_USERCREATE_SUCCESS', self::PLUGIN_NAME), $line_num, $user_id_value);
	                	}
	                    //continue;
	                }else{
	                	
	                }
	
	                // Fetch all the role assignments this user might have for this course's context
	                $roles = get_user_roles($course_context, $user_rec->id, false);
	                // If a user has a role in this course, then we leave it alone and move on
	                // to the group assignment if there is one. If they have no role, then we
	                // should go ahead and add one, as long as it is not a metacourse.
	                if (!$roles && $role_id > 0) {
	                    if ($metacourse) {
	                        $result .= sprintf(get_string('ERR_ENROLL_META', self::PLUGIN_NAME), $line_num, $user_id_value);
	                    } else {
	                        try {
	                            $manual_enrol_plugin->enrol_user($enrol_instance, $user_rec->id, $role_id);
	                            $result .= sprintf(get_string('INF_ENROLL_SUCCESS', self::PLUGIN_NAME), $line_num, $user_id_value);
	                        }
	                        catch (Exception $exc) {
	                            $result .= sprintf(get_string('ERR_ENROLL_FAILED', self::PLUGIN_NAME), $line_num, $user_id_value);
	                            $result .= $exc->getMessage();
	                            continue;
	                        }
	                    }
	                }
	
	                // If no group assignments, or group is from file, but no
	                // group found, next line
	                if (!$group_assign ||($group_id == 0 && empty($group_name))) continue;
	
	                // If no group pre-selected, see if group from import already
	                // created for that course
	                $assign_group_id = 0;
	                $assign_group_name = '';
	                if ($selected_group != null) {
	
	                    $assign_group_id   = $selected_group->id;
	                    $assign_group_name = $selected_group->name;
	
	                } else {
	
	                    foreach($existing_groups as $existing_group) {
	                        if ($existing_group->name != $group_name)
	                            continue;
	                        $assign_group_id   = $existing_group->id;
	                        $assign_group_name = $existing_group->name;
	                        break;
	                    }
	
	                    // No group by that name
	                    if ($assign_group_id == 0) {
	
	                        // Can not create one, next line
	                        if (!$group_create) continue;
	
	                        // Make a new group for this course
	                        $new_group = new stdClass();
	                        $new_group->name = addslashes($group_name);
	                        $new_group->courseid = $course->id;
	                        if (false === ($assign_group_id = groups_create_group($new_group))) {
	                            $result .= sprintf(get_string('ERR_CREATE_GROUP', self::PLUGIN_NAME), $line_num, $group_name);
	                            continue;
	                        } else {
	                            // Add the new group to our list for the benefit of
	                            // the next contestant. Strip the slashes off the
	                            // name since we do a name comparison earlier when
	                            // trying to find the group in our local cache and
	                            // an escaped semi-colon will cause the test to fail.
	                            $new_group->name   =
	                            $assign_group_name = stripslashes($new_group->name);
	                            $new_group->id = $assign_group_id;
	                            $existing_groups[] = $new_group;
	                        }
	
	                    } // if ($assign_group_id == 0)
	
	                }
	
	                // Put the user in the group if not aleady in it
	                if (   !groups_is_member($assign_group_id, $user_rec->id)
	                    && !groups_add_member($assign_group_id, $user_rec->id)) {
	                    $result .= sprintf(get_string('ERR_GROUP_MEMBER', self::PLUGIN_NAME), $line_num, $user_id_value, $assign_group_name);
	                    continue;
	                }
	                
                } // first row pass
                
                $line_num++;
                // Any other work...

            } // while fgets

            fclose($fh);

            return (empty($result)) ? get_string('INF_IMPORT_SUCCESS', self::PLUGIN_NAME) : $result;

        } // import_file



        /**
         * Assign people to groups based on their metacourse enrollments
         *
         * @access public
         * @static
         * @param stdClass $course            The course in which group assignments are made
         * @param array    $group_selections  Assoc. array ($enrol_id => $group_id)
         * @param boolean  $remove_current    Remove users' current group assignments
         * @return void
         *
         * @uses $DB
         */
        public static function metagroup_assign(stdClass $course, $group_selections, $remove_current = false)
        {
            global $DB;



            $result = '';
            $course_groups = groups_get_all_groups($course->id);

            foreach($group_selections as $enrol_id => $assign_group_id) {

                // No assignment select for this enrol instance
                if (empty($assign_group_id)) {
                    continue;
                }

                // Get users association with this enrol instance
                if (false === ($userids = $DB->get_records('user_enrolments', array('enrolid' => $enrol_id), 'userid', 'userid'))) {
                    continue;
                }

                // Iterate the user id list for this enrol instance
                foreach($userids as $userid => $record_object) {

                    // Remove user from existing groups if needed
                    if ($remove_current) {
                        foreach ($course_groups as $course_group) {
                            if ($course_group->id != $assign_group_id) {
                                groups_remove_member($course_group->id, $userid);
                            }
                        }
                    }

                    // Got an existing group's id
                    groups_add_member($assign_group_id, $userid);

                } // foreach($userids...

            } // foreach($group_selections...

            self::set_group_prefs($course->id, $group_selections);

        } // metagroup_assign



        /**
         * Fetch meta course group selections
         *
         * @access public
         * @static
         * @param int      $course_id         The course in which group assignments are made
         * @return array
         *
         * @uses $DB
         */
        public static function get_group_prefs($course_id)
        {
            global $DB;



            $record_object = $DB->get_record('local_userenrols_metagroup', array('course' => $course_id), 'course, data');
            if (false === $record_object) {

                self::set_group_prefs($course_id);
                return array();

            } else {

                return (array)unserialize($record_object->data);

            }

        } // get_group_prefs



        /**
         * Fetch meta course group selections
         *
         * @access public
         * @static
         * @param int      $course_id         The course in which group assignments are made
         * @param array    $prefs             Array of prefs, group id values keyed by enrol id
         * @return void
         *
         * @uses $DB
         */
        public static function set_group_prefs($course_id, $prefs = array())
        {
            global $DB;


            try {

                $DB->delete_records('local_userenrols_metagroup', array('course' => $course_id));

                $record_object = new stdClass();
                $record_object->course = $course_id;
                $record_object->data   = serialize((array)$prefs);

                $DB->insert_record('local_userenrols_metagroup', $record_object, false);

            }
            catch (Exception $exc) {
                // Squelch the exception
            }

        } // get_group_prefs


    } // class
