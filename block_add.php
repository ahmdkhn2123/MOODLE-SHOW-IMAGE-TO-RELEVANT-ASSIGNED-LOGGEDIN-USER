<?php /** @noinspection ALL */
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
 *
 * @package    block_add
 * @copyright  Mohammad Ahmad
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once('edit_form.php');
require_once (__DIR__ . '/../../config.php');


class block_add extends block_base
{
    

    public function init(){
		$this->title = 'Your Block';
	}
	public function get_content(){
        global $CFG,$DB,$OUTPUT,$USER;
		$this->content = new stdClass();
		$mform = new edit_form();
		if ($mform->is_cancelled()) {
			echo "sorry";
		}else if ($fromform = $mform->get_data()) {
            $record= new stdClass();
            $record->id = $fromform->id;
            $a=$fromform->message['text'];
			$b=preg_match_all('#src="([^\s]+)"#', $a, $matches);
            $c=implode(' ',$matches[1]);
			$record->message=$c;
			$record->message_type=$fromform->message_type;
			$record->message_attribute=$fromform->message_attribute;
			$DB->insert_record('blocks_table', $record);



		    $a=$DB->get_records('blocks_table');
		    foreach($a as $data){
				$roles = $DB->get_records('blocks_table',['id'=>$data->id]);
			foreach ($roles as $role) {
				$a = "message_atrribute  = ".$role->message_attribute;
		}	
	}


	        $a=$USER->username;
			if ($role->message_attribute=='admin' AND $USER->username=='admin') {
				$sql="SELECT * FROM {blocks_table}";
				$get=$DB->get_records_sql($sql);
				$templatecontext=(object)[
					'show'=>array_values($get),
				];
				$this->content->text=$OUTPUT->render_from_template('block_add/manage', $templatecontext);

			}elseif($role->message_attribute==$a){
				$sql="SELECT * FROM {blocks_table} WHERE message_attribute='$a'";
				$get=$DB->get_records_sql($sql);
				$templatecontext=(object)[
					'show'=>array_values($get),
				];
				$this->content->text=$OUTPUT->render_from_template('block_add/manage', $templatecontext);
			}else{
				$this->content->footer= 'Not Found With '.$role->message_attribute.' <b>Enter Correct Name<b>';
			}


		}else{
			$this->content->text = $mform->render();
		}
		return $this->content;
	}


	function has_config() {return true;}
}

