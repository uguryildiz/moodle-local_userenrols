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


    $string['pluginname']               = 'Kullanıcı Yükleme';

    $string['IMPORT_MENU_LONG']         = 'Kullanıcı Yükle';
    $string['IMPORT_MENU_SHORT']        = 'Yükle';

    $string['ASSIGN_MENU_LONG']         = 'Grup (Meta)';
    $string['ASSIGN_MENU_SHORT']        = 'Grup Bilgileri';

    $string['LBL_IMPORT_TITLE']         = 'Kullanıcı Yükleme';
    $string['LBL_ASSIGN_TITLE']         = 'Group Assignment by Metacourse';

    $string['LBL_IMPORT']               = 'Yükle';
    $string['LBL_IDENTITY_OPTIONS']     = 'Kullanıcı Kimliği';
    $string['LBL_ENROLL_OPTIONS']       = 'Kaydetme Seçenekleri';
    $string['LBL_GROUP_OPTIONS']        = 'Grup Seçenekleri';
    $string['LBL_FILE_OPTIONS']         = 'Dosya Yükle';
    $string['LBL_ROLE_ID']              = 'Rol:';
    $string['LBL_ROLE_ID_help']         = 'İstenilen rolde derse kayıt yapılabilir. . Eğer \'Rol Ataması Yapma\' seçilirse sadece grup ataması yapılır.';
    $string['LBL_FILE_help']            = 'Upload or pick from a repository a delimited data file with user and optional group information. File should have either a .txt or .csv extension.';
    $string['LBL_USER_ID_FIELD']        = 'Tanımlayıcı:';
    $string['LBL_USER_ID_FIELD_help']   = 'Dosyadaki ilk alan kullanıcının sisteme giriş yapacağı kimlik bilgisidir. Öğrenci Numarası 9 haneli ve rakamlardan oluşmalıdır.';
    $string['LBL_GROUP']                = 'Grup Ataması:';
    $string['LBL_GROUP_help']           = 'Grup atama işlemini etkinleştirir.';
    $string['LBL_GROUP_ID']             = 'Grup:';
    $string['LBL_GROUP_ID_help']        = 'Bir grup seçerseniz dosyadaki grup bilgisi dikkate alınmaz.';
    $string['LBL_GROUP_CREATE']         = 'Grup Oluştur:';
    $string['LBL_GROUP_CREATE_help']    = 'Eğer dosyada belirtilen gruplar daha önce oluşturulmamışsa, gerektiğinde yenileri oluşturulur. Gruplar zaten tanımlı ise sadece atamaları yapılır.';
    $string['LBL_NO_ROLE_ID']           = 'Rol Ataması Yapma';
    $string['LBL_NO_GROUP_ID']          = 'Dosyadaki grup bilgisini kullan';

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
    $string['INF_IMPORT_SUCCESS']       = 'Kullanıcı yükleme ve derse kayıtları gerçekleştirildi';
    $string['INF_ASSIGN_SUCCESS']       = 'Grup atamaları gerçekleştirildi';
    $string['INF_USERCREATE_SUCCESS']   = "Satır %u: Yeni kullanıcı oluşturuldu '%s'\n";
    $string['INF_ENROLL_SUCCESS']   	= "Satır %u: Kullanıcı derse kaydedildi '%s'\n";

    $string['ERR_NO_MANUAL_ENROL']      = "Course must have Manual enrol plugin enabled.";
    $string['ERR_NO_META_ENROL']        = "Course must have 'Course meta link' enrol plugin enabled.";
    $string['ERR_PATTERN_MATCH']        = "Satır %u: dosya içeriği okunamadı '%s'\n";
    $string['ERR_USERNAME_MATCH']       = "Satır %u: kullanıcıadı  (username)  okunamadı '%s'. Kullanıcıadı (username) 9 haneli rakam olmalıdır.\n";
    $string['ERR_INVALID_GROUP_ID']     = "The group id %u is invalid for this course.\n";
    $string['ERR_USERID_INVALID']       = "Satır %u: Invalid userid value '%s'\n";
    $string['ERR_ENROLL_FAILED']        = "Satır %u: Unable to create role assignment for userid '%s'\n";
    $string['ERR_ENROLL_META']          = "Satır %u: No existing enrollment in metacourse for userid '%s'\n";
    $string['ERR_CREATE_GROUP']         = "Satır %u: Unable to create group '%s'\n";
    $string['ERR_GROUP_MEMBER']         = "Satır %u: Unable to add user '%s' to group '%s'\n";

    $string['HELP_PAGE_IMPORT']         = 'Kullancı Yükleme, Ders Kayıt, Grup Atama';
    $string['HELP_PAGE_IMPORT_help']    = '
<p>
Kocaeli Üniversitesi Öğrenci Bilgi Sistemi "E-Ders Bilgi aktar" bağlantısından indirilen csv uzantılı dosya ile sisteme yükleme yapılmaktadır. <br />
<br />
Öğrenci sistemde daha önce yüklü değilse sisteme eklenir, derse kaydedilir ve kendi sınıfına göre bir grup oluşturularak ataması yapılır.
</p>
';
