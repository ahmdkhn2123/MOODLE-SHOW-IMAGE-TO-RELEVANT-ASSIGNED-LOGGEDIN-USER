<?php

/**
 * @package       block_add
 * @author        Mohammad ahmad
 * @license       http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require_once (__DIR__ . '/../../config.php');
global $DB,$CFG;

$id = required_param('id', PARAM_INT);
$table='blocks_table';

if ($id === 0) {
    echo 'data not present';
}else{
    $DB->delete_records($table, array('id' => $id));
    return redirect($CFG->wwwroot.'/blocks/add/show.php');
}