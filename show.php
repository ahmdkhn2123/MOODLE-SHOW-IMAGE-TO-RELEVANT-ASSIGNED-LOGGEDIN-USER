<?php

/**
 * @package       block_add
 * @author        Mohammad ahmad
 * @license       http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');
global $DB,$OUTPUT,$USER;

$a=$USER->username;

if ($a=='yahoo_un' OR $a=='nasmak_un') {
    $sql="SELECT * FROM {blocks_table} WHERE message_attribute='$a'";
    $get=$DB->get_records_sql($sql);
    $templatecontext=(object)[
        'show'=>array_values($get),
    ];
    echo $OUTPUT->render_from_template('block_add/manage', $templatecontext);
    
}elseif($USER->username=='admin') {
    $sql="SELECT * FROM {blocks_table}";
    $get=$DB->get_records_sql($sql);
    $templatecontext=(object)[
        'show'=>array_values($get),
    ];
    echo $OUTPUT->render_from_template('block_add/manage', $templatecontext);
 
}else{
    echo "Sorry, No Match Picture Exist";

}

