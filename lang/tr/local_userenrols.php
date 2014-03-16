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


    $string['pluginname']               = 'Kullancı Yükleme, Kaydetme & Grup Atamaları';

    $string['IMPORT_MENU_LONG']         = 'Kullancı Yükle';
    $string['IMPORT_MENU_SHORT']        = 'Yükle';

    $string['ASSIGN_MENU_LONG']         = 'Grup (Meta)';
    $string['ASSIGN_MENU_SHORT']        = 'Grup Bilgileri';

    $string['LBL_IMPORT_TITLE']         = 'CSV Kullanıcı Yükleme ve Kaydetme';
    $string['LBL_ASSIGN_TITLE']         = 'Group Assignment by Metacourse';

    $string['LBL_IMPORT']               = 'Yükle';
    $string['LBL_IDENTITY_OPTIONS']     = 'Kullanıcı Kimliği';
    $string['LBL_ENROLL_OPTIONS']       = 'Kaydetme Seçenekleri';
    $string['LBL_GROUP_OPTIONS']        = 'Grup Seçenekleri';
    $string['LBL_FILE_OPTIONS']         = 'Dosya Yükle';
    $string['LBL_ROLE_ID']              = 'Rol:';
    $string['LBL_ROLE_ID_help']         = 'What role do you want the imported users to have in the course. If \'No Enrollment\' then only group assignments will be made.';
    $string['LBL_FILE_help']            = 'Upload or pick from a repository a delimited data file with user and optional group information. File should have either a .txt or .csv extension.';
    $string['LBL_USER_ID_FIELD']        = 'Kullanıcı alanı:';
    $string['LBL_USER_ID_FIELD_help']   = 'Specify field in the user record is represented in the first column of the import file.';
    $string['LBL_GROUP']                = 'Gruplara atama yap:';
    $string['LBL_GROUP_help']           = 'Make groups assignments, either based on file input, or a selected group.';
    $string['LBL_GROUP_ID']             = 'Grup kullan:';
    $string['LBL_GROUP_ID_help']        = 'Choose to use the group name in input file, if supplied, or select an existing group and ignore the input data.';
    $string['LBL_GROUP_CREATE']         = 'Grupları oluştur:';
    $string['LBL_GROUP_CREATE_help']    = 'If groups in import file do not exist, create new ones as needed, otherwise only assign users to groups if the group name specified already exists.';
    $string['LBL_NO_ROLE_ID']           = 'No Enrollments';
    $string['LBL_NO_GROUP_ID']          = 'Dosyadaki bilgiyi kullan';

    $string['LBL_ASSIGN']               = 'Atama yap';
    $string['LBL_ASSIGN_TO']            = 'Gruba ata:';
    $string['LBL_ASSIGN_TO_help']       = 'Select a group to which to assign users enrolled in this metacourse.';
    $string['LBL_ASSIGN_COURSE']        = 'Ders: {$a}';
    $string['LBL_REMOVE_CURRENT']       = 'Varolanı kaldır:';
    $string['LBL_REMOVE_CURRENT_help']  = 'Remove any other group assignments users have.';

    $string['VAL_NO_FILES']             = 'Seçili dosya yok';
    $string['VAL_INVALID_SELECTION']    = 'Geçersiz seçim';
    $string['VAL_INVALID_FORM_DATA']    = 'Invalid form data submission.';

    $string['INF_METACOURSE_WARN']      = '<b>WARNING</b>: You can not import enrollments directly into a metacourse. Instead, make enrollments into one of its child courses.<br /><br />';
    $string['INF_IMPORT_SUCCESS']       = 'Kullanıcı yükleme ve kaydetme gerçekleştirildi';
    $string['INF_ASSIGN_SUCCESS']       = 'Grup atamaları gerçekleştirildi';
    $string['INF_USERCREATE_SUCCESS']   = "Line %u: Yeni kullanıcı oluşturuldu '%s'\n";
    $string['INF_ENROLL_SUCCESS']   	= "Line %u: Kullanıcı derse kaydedildi '%s'\n";

    $string['ERR_NO_MANUAL_ENROL']      = "Course must have Manual enrol plugin enabled.";
    $string['ERR_NO_META_ENROL']        = "Course must have 'Course meta link' enrol plugin enabled.";
    $string['ERR_PATTERN_MATCH']        = "Line %u: Unable to parse the line contents '%s'\n";
    $string['ERR_USERNAME_MATCH']       = "Line %u: Unable to parse the line username '%s'. Username must contain 9 digit.\n";
    $string['ERR_INVALID_GROUP_ID']     = "The group id %u is invalid for this course.\n";
    $string['ERR_USERID_INVALID']       = "Line %u: Invalid userid value '%s'\n";
    $string['ERR_ENROLL_FAILED']        = "Line %u: Unable to create role assignment for userid '%s'\n";
    $string['ERR_ENROLL_META']          = "Line %u: No existing enrollment in metacourse for userid '%s'\n";
    $string['ERR_CREATE_GROUP']         = "Line %u: Unable to create group '%s'\n";
    $string['ERR_GROUP_MEMBER']         = "Line %u: Unable to add user '%s' to group '%s'\n";

    $string['HELP_PAGE_IMPORT']         = 'Kullancı Yükleme, Kaydetme & Grup Atamaları';
    $string['HELP_PAGE_IMPORT_help']    = '
<p>
Use this course import plugin to import user enrollments from a delimited text
file into the course. New user accounts will not be created, so each of the
users listed in the input file must already have an account set up in the site.<br />
<br />
If a group name is include with any user record (line) then that user will be
added to that group if it exists. You can optionally create new groups if needed.
</p>

<ul>
  <li>Each line of the import file represents a signle record</li>
  <li>Each record should at least contain one field with a userid value, whether it be a username, an e-mail address, or an internal idnumber.</li>
  <li>Each record may contain an additional group name field, separated by a comma, semi-colon, or tab character.</li>
  <li>The role to which these users are assigned can be selected, but should default to the course\'s default role.</li>
  <li>Any, or none, of the fields can be quoted, and the group name field will need to be if it contains a semi-colon or comma</li>
  <li>Blank lines in the import file will be skipped</li>
  <li>Note: If a user is already enrolled in the course, no changes will be made to that user\'s enrollment (i.e. no role change).</li>
</ul>

<p>
A note about metacourses: this plugin will not import user enrollments into a
metacourse, as the enrollment should be made in one of the child courses. It
will, however, make group assignments, and create groups if needed, when the
userid specified is already associated with the metacourse via a child course
enrollment.
</p>

<h3>Examples</h3>

Internal idnumber value and group
<pre>
2144323548;Tuesday Laborary
2144323623
2144323647;Wednesday Laborary
2144323638;Wednesday Laborary
</pre>

E-mail addresses
<pre>
smith-john@university.edu
janedoe@university.edu, "Honors"
alan.jones@university.edu, "HonorsPlus"
</pre>

Usernames (separated from group field with a tab character)
<pre>
johnsonf    "Presentation, Group One"
samsel      Ten O\'Clock Testing
</pre>';


    $string['HELP_PAGE_ASSIGN']         = 'Metacourse Group Assignments';
    $string['HELP_PAGE_ASSIGN_help']    = '
<p>
Use this metacourse group assignment tool to assign users from individual child
courses into separate groups. You can optionally remove any other current group
assignments users might have.
</p>';
