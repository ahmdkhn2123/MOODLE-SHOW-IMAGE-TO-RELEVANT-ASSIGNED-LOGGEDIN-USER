<?php

/**
 * @package       local_message
 * @author        Mohammad Ahmad
 * @license       http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once (__DIR__ . '/../../config.php');
require_once('edit_form.php');


global $DB,$PAGE;

$mform=new edit_form();
$table='blocks_table';

$id=required_param('id', PARAM_INT);
$info=$DB->get_record($table,array('id' => $id));


if ($mform->is_cancelled()) {
    print_r("1");
} else if ($fromform = $mform->get_data()) {
    $record = new stdClass();
    $record->id=$id;
    $a=$fromform->message['text'];
    $b=preg_match_all('#src="([^\s]+)"#', $a, $matches);
    $c=implode(' ',$matches[1]);
    $record->message=$c;
    $record->message_type = $fromform->message_type;
    $record->message_attribute = $fromform->message_attribute;
    $DB->update_record($table, $record);
    return redirect($CFG->wwwroot.'/blocks/add/show.php');

}

echo $OUTPUT->header();
$mform->set_data($info);
$mform->display();
echo $OUTPUT->footer();