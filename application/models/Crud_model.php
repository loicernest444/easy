<?php
defined('BASEPATH') OR exit('No direct script access allowed');



require APPPATH.'third_party/PHPExcel/IOFactory.php';
class Crud_model extends CI_Model {

	protected $school_id;
	protected $active_session;

	public function __construct()
	{
		parent::__construct();
		$this->school_id = school_id();
		$this->active_session = active_session();
	} 

 
	//START CLASS section
	public function get_classes($id = "") {

		$this->db->where('school_id', $this->school_id);

		if ($id > 0) {
			$this->db->where('id', $id);

		}
		return $this->db->get('classes');


	} 
	public function school_create()
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['name_fr'] = html_escape($this->input->post('fname'));
		$data['title'] = html_escape($this->input->post('title'));
		$data['use_divisions'] = html_escape($this->input->post('use_divisions'));
		$data['short_name'] = html_escape($this->input->post('sname'));
		$data['short_name_fr'] = html_escape($this->input->post('fsname'));
		$data['phone'] = html_escape($this->input->post('phone'));
		$data['email'] = html_escape($this->input->post('email'));
		$data['address'] = html_escape($this->input->post('address'));
        
        //if school uses divisions
		  $this->db->insert('schools', $data);
          $insert_id = $this->db->insert_id();
        
        if ($_FILES['logo']['name'] != "") {
          move_uploaded_file($_FILES['logo']['tmp_name'], 'uploads/system/school/'.$insert_id().'.png');
        } 
          //check if class use sections   
            if($data['use_divisions'] > 0){
                //start treating sections
                $section_name = html_escape($this->input->post('division_name'));
                $section_sname = html_escape($this->input->post('division_sname'));
                $fsection_name = html_escape($this->input->post('fdivision_name'));
                $fsection_sname = html_escape($this->input->post('fdivision_sname'));
                
                foreach($section_name as $key => $value):
                        $dat['school_id'] = $insert_id;
                        $dat['name'] = $section_name[$key];
                        $dat['short_name'] = $section_sname[$key];
                        $dat['name_fr'] = $fsection_name[$key];
                        $dat['short_name_fr'] = $fsection_sname[$key];
                        if($dat['name'] != null){
                                $this->db->insert('divisions', $dat);
                            }
                endforeach;
            }

        
		$response = array(
			'status' => true,
			'notification' => get_phrase('school_added_successfully')
		);
		return json_encode($response);
	}
	 
	 
	public function class_create()
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['type'] = html_escape($this->input->post('typec'));
        $n = $this->db->get('schools')->num_rows();
        if ($n > 1){
		   $data['division_id'] = html_escape($this->input->post('section'));
		   $data['school_id'] = html_escape($this->input->post('school'));
		   $data['option_id'] = html_escape($this->input->post('option'));
        }else{
           $data['division_id'] = html_escape($this->input->post('sectionn'));
		   $data['school_id'] = html_escape($this->input->post('school')); 
		   $data['option_id'] = html_escape($this->input->post('optionn'));
        }
               
		$data['use_sections'] = html_escape($this->input->post('use_sections'));
		$data['short_name'] = html_escape($this->input->post('sname'));
		$data['previous_class'] = html_escape($this->input->post('previous'));
        
        //for unique school
		  $this->db->insert('classes', $data);
          $insert_id = $this->db->insert_id();
          
         
		$response = array(
			'status' => true,
			'notification' => get_phrase('class_added_successfully')
		);
		return json_encode($response);
	}
    
    
	public function class_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['type'] = html_escape($this->input->post('typec'));
        $n = $this->crud_model->get_schools()->num_rows();
		if ($n > 1){
		   $data['division_id'] = html_escape($this->input->post('section'));
		   $data['school_id'] = html_escape($this->input->post('school'));
		   $data['option_id'] = html_escape($this->input->post('option'));
        }else{
           $data['division_id'] = html_escape($this->input->post('sectionn'));
		   $data['school_id'] = school_id(); 
		   $data['option_id'] = html_escape($this->input->post('optionn'));
        }
		$data['use_sections'] = html_escape($this->input->post('use_sections'));
		$data['previous_class'] = html_escape($this->input->post('previous'));
		$data['short_name'] = html_escape($this->input->post('sname'));
		$this->db->where('id', $param1);
		$this->db->update('classes', $data);
        //check the number of sections of the class
        
		$response = array(
			'status' => true,
			'notification' => get_phrase('class_updated_successfully')
		);
		return json_encode($response);
	}
    
	public function classs_create()
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['division_id'] = html_escape($this->input->post('section'));
		$data['use_sections'] = html_escape($this->input->post('use_sections'));
		$data['short_name'] = html_escape($this->input->post('sname'));
        
        //check multiple school cases
        if((html_escape($this->input->post('school'))) == 'all'){
          $schools = $this->db->get('schools')->result_array();
                foreach ($schools as $s){
                    $data['school_id']   = $s['id'];
                    $this->db->insert('classes', $data);
                    $insert_id = $this->db->insert_id();
                //check if class use sections   
                if($data['use_sections'] > 0){
                    
                    //start treating sections
                    $section_name = html_escape($this->input->post('section_name'));
                    
                    foreach($section_name as $key => $value):
                            $dat['class_id'] = $insert_id;
                            $dat['name'] = $section_name[$key];
                            if($dat['name'] != null){
                                $this->db->insert('sections', $dat);
                            }
                    endforeach;
                }
                }
        }else{
        //for unique school
		  $data['school_id'] = html_escape($this->input->post('school'));
		  $this->db->insert('classes', $data);
          $insert_id = $this->db->insert_id();
            
          //check if class use sections   
            if($data['use_sections'] > 0){
                //start treating sections
                $section_name = html_escape($this->input->post('section_name'));
                
                foreach($section_name as $key => $value):
                        $dat['class_id'] = $insert_id;
                        $dat['name'] = $section_name[$key];
                        if($dat['name'] != null){
                                $this->db->insert('sections', $dat);
                            }
                endforeach;
            }
        }
        
		$response = array(
			'status' => true,
			'notification' => get_phrase('class_added_successfully')
		);
		return json_encode($response);
	} 

	public function behavior_create()
	{
		$data['name'] = html_escape($this->input->post('nameen'));
		$data['name_fr'] = html_escape($this->input->post('namefr'));
		$data['short_name'] = html_escape($this->input->post('ensname'));
		$data['short_name_fr'] = html_escape($this->input->post('frsname'));
		$data['session'] = html_escape($this->input->post('session'));
        
        //check multiple school cases
        if((html_escape($this->input->post('school'))) == 'all'){
          $schools = $this->db->get('schools')->result_array();
                foreach ($schools as $s){
                    $data['school_id']   = $s['id'];
                    $this->db->insert('mark_behavior', $data);
                    $insert_id = $this->db->insert_id();
                    
                //save options  
                $name_en = html_escape($this->input->post('optenname'));
                $name_fr = html_escape($this->input->post('optfrname'));
                $percentage = html_escape($this->input->post('optrep'));
                    
                  foreach($name_en as $key => $value):  
                    $dat['mark_behavior_id'] = $insert_id;
                    $dat['name'] = $name_en[$key];
                    $dat['name_fr'] = $name_fr[$key];
                    $dat['percentage'] = $percentage[$key];
                    if($dat['name'] != null){
                         $this->db->insert('mark_behavior_option', $dat);
                    }
                  endforeach;  
                }
        }else{
        //for unique school
		  $data['school_id'] = html_escape($this->input->post('school'));
		  $this->db->insert('mark_behavior', $data);
          $insert_id = $this->db->insert_id();
            
                //save options
                $name_en = html_escape($this->input->post('optenname'));
                $name_fr = html_escape($this->input->post('optfrname'));
                $percentage = html_escape($this->input->post('optrep'));
                    
                  foreach($name_en as $key => $value):  
                    $dat['mark_behavior_id'] = $insert_id;
                    $dat['name'] = $name_en[$key];
                    $dat['name_fr'] = $name_fr[$key];
                    $dat['percentage'] = $percentage[$key];
                    if($dat['name'] != null){
                         $this->db->insert('mark_behavior_option', $dat);
                    }
                  endforeach;  
        }
        
		$response = array(
			'status' => true,
			'notification' => get_phrase('Mark_behavior_added_successfully')
		);
		return json_encode($response);
	}

	public function fees_create()
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['short_name'] = html_escape($this->input->post('sname'));
		$data['description'] = html_escape($this->input->post('description'));
        $data['type'] = html_escape($this->input->post('type'));
		$data['session'] = html_escape($this->input->post('session'));
		$data['exigibility'] = html_escape($this->input->post('exigibility'));
        //for unique school
		$this->db->insert('fees', $data);
		$response = array(
			'status' => true,
			'notification' => get_phrase('fees_added_successfully')
		);
		return json_encode($response);
	}

	public function school_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['name_fr'] = html_escape($this->input->post('fname'));
		$data['title'] = html_escape($this->input->post('title'));
		$data['use_divisions'] = html_escape($this->input->post('use_divisions'));
		$data['short_name'] = html_escape($this->input->post('sname'));
		$data['short_name_fr'] = html_escape($this->input->post('fsname'));
		$data['phone'] = html_escape($this->input->post('phone'));
		$data['email'] = html_escape($this->input->post('email'));
		$data['address'] = html_escape($this->input->post('address'));
        
        //if school uses divisions
		 
		$this->db->where('id', $param1);
		$this->db->update('schools', $data);
        
        if ($_FILES['logo']['name'] != "") {
          move_uploaded_file($_FILES['logo']['tmp_name'], 'uploads/system/school/'.$param1.'.png');
        }
        //check the number of sections of the class
        if($data['use_divisions'] > 0){
        $section_id = html_escape($this->input->post('division_id'));
		$section_name = html_escape($this->input->post('division_name'));
		$section_sname = html_escape($this->input->post('division_sname'));
        $fsection_name = html_escape($this->input->post('fdivision_name'));
        $fsection_sname = html_escape($this->input->post('fdivision_sname'));
		foreach($section_id as $key => $value){
			if($value == 0){
				$dat['school_id'] = $param1;
                $dat['name'] = $section_name[$key];
                $dat['short_name'] = $section_sname[$key];
                $dat['name_fr'] = $fsection_name[$key];
                $dat['short_name_fr'] = $fsection_sname[$key];
                if($dat['name'] != null){
                        $this->db->insert('divisions', $dat);
                    }
			}
			if($value != 0 && $value != 'delete'){
				$dat['name'] = $section_name[$key];
				$dat['short_name'] = $section_sname[$key];
                $dat['name_fr'] = $fsection_name[$key];
                $dat['short_name_fr'] = $fsection_sname[$key];
				$this->db->where('school_id', $param1);
				$this->db->where('id', $value);
				$this->db->update('divisions', $dat);
			}

			$section_value = null;
			if (strpos($value, 'delete') == true) {
				$section_value = str_replace('delete', '', $value);
			}
			if($value == $section_value.'delete'){
				$dat['name'] = $section_name[$key];
				$this->db->where('school_id', $param1);
				$this->db->where('id', $section_value);
				$this->db->delete('divisions');
			}
		} 
		}
		$response = array(
			'status' => true,
			'notification' => get_phrase('school_updated_successfully')
		);
		return json_encode($response);
	}
    
    
	//START EXAM section
	public function exam_create()
	{
		$data['name'] = html_escape($this->input->post('nameen'));
		$data['name_fr'] = html_escape($this->input->post('namefr'));
		$data['short_name'] = html_escape($this->input->post('ensname'));
		$data['short_name_fr'] = html_escape($this->input->post('frsname'));
		$data['session'] = html_escape($this->input->post('session'));
		$data['starting_date'] = strtotime($this->input->post('starting_date')); 
		$data['ending_date'] = strtotime($this->input->post('ending_date'));
        
        //check multiple school cases
        if((html_escape($this->input->post('school'))) == 'all'){
          $schools = $this->db->get('schools')->result_array();
                foreach ($schools as $s){
                    $data['school_id']   = $s['id'];
                    $this->db->insert('exams', $data);
                    $insert_id = $this->db->insert_id();
                    
                //save options  
                $name_en = html_escape($this->input->post('optenname'));
                $name_fr = html_escape($this->input->post('optfrname'));
                $sname_en = html_escape($this->input->post('optensname'));
                $sname_fr = html_escape($this->input->post('optfrsname'));
                    
                  foreach($name_en as $key => $value):  
                    $dat['exam_id'] = $insert_id;
                    $dat['name'] = $name_en[$key];
                    $dat['name_fr'] = $name_fr[$key];
                    $dat['short_name'] = $sname_en[$key];
                    $dat['short_name_fr'] = $sname_fr[$key];
                    if($dat['name'] != null){
                     $this->db->insert('exam_option', $dat);
                    }
                  endforeach;  
                }
        }else{
        //for unique school
		  $data['school_id'] = html_escape($this->input->post('school'));
		  $this->db->insert('exams', $data);
          $insert_id = $this->db->insert_id();
            
                //save options
                $name_en = html_escape($this->input->post('optenname'));
                $name_fr = html_escape($this->input->post('optfrname'));
                $sname_en = html_escape($this->input->post('optensname'));
                $sname_fr = html_escape($this->input->post('optfrsname'));
                    
                  foreach($name_en as $key => $value):  
                    $dat['exam_id'] = $insert_id;
                    $dat['name'] = $name_en[$key];
                    $dat['name_fr'] = $name_fr[$key];
                    $dat['short_name'] = $sname_en[$key];
                    $dat['short_name_fr'] = $sname_fr[$key];
                    if($dat['name'] != null){
                     $this->db->insert('exam_option', $dat);
                    }
                  endforeach;  
        }
        
		$response = array(
			'status' => true,
			'notification' => get_phrase('exam_division_added_successfully')
		);
		return json_encode($response);
	}

	public function exam_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('exams');
        
        $this->db->where('exam_id', $param1);
		$this->db->delete('exam_option');

		$response = array(
			'status' => true,
			'notification' => get_phrase('exam_deleted_successfully')
		);
		return json_encode($response);
	}
    
	public function exam_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('nameen'));
		$data['name_fr'] = html_escape($this->input->post('namefr'));
		$data['short_name'] = html_escape($this->input->post('ensname'));
		$data['short_name_fr'] = html_escape($this->input->post('frsname'));
		$data['starting_date'] = strtotime($this->input->post('starting_date'));
		$data['ending_date'] = strtotime($this->input->post('ending_date'));
		//$data['session'] = html_escape($this->input->post('session'));
		$this->db->where('id', $param1);
		$this->db->update('exams', $data);
        
        $section_id = html_escape($this->input->post('section_id'));
		$name_en = html_escape($this->input->post('optenname'));
        $name_fr = html_escape($this->input->post('optfrname'));
        $sname_en = html_escape($this->input->post('optensname'));
        $sname_fr = html_escape($this->input->post('optfrsname'));
        
		foreach($section_id as $key => $value){
			if($value == 0){
				$dat['exam_id'] = $param1;
                $dat['name'] = $name_en[$key];
                $dat['name_fr'] = $name_fr[$key];
                $dat['short_name'] = $sname_en[$key];
                $dat['short_name_fr'] = $sname_fr[$key];
                if($dat['name'] != null){
                    $this->db->insert('exam_option', $dat);
                }
			}
			if($value != 0 && $value != 'delete'){
                $dat['name'] = $name_en[$key];
                $dat['name_fr'] = $name_fr[$key];
                $dat['short_name'] = $sname_en[$key];
                $dat['short_name_fr'] = $sname_fr[$key];
				$this->db->where('exam_id', $param1);
				$this->db->where('id', $value);
				$this->db->update('exam_option', $dat);
			}

			$section_value = null;
			if (strpos($value, 'delete') == true) {
				$section_value = str_replace('delete', '', $value);
			}
			if($value == $section_value.'delete'){
				//$dat['name'] = $section_name[$key];
				$this->db->where('exam_id', $param1);
				$this->db->where('id', $section_value);
				$this->db->delete('exam_option');
			}
		} 
         
        
		$response = array(
			'status' => true,
			'notification' => get_phrase('year_division_updated_successfully')
		);
		return json_encode($response);
	}
    
    
	public function section_e_update($param1 = '')
	{
		$section_id = html_escape($this->input->post('section_id'));
		$name_en = html_escape($this->input->post('optenname'));
        $name_fr = html_escape($this->input->post('optfrname'));
        $sname_en = html_escape($this->input->post('optensname'));
        $sname_fr = html_escape($this->input->post('optfrsname'));
        
		foreach($section_id as $key => $value){
			if($value == 0){
				$dat['exam_id'] = $param1;
                $dat['name'] = $name_en[$key];
                $dat['name_fr'] = $name_fr[$key];
                $dat['short_name'] = $sname_en[$key];
                $dat['short_name_fr'] = $sname_fr[$key];
                if($dat['name'] != null){
                    $this->db->insert('exam_option', $dat);
                }
			}
			if($value != 0 && $value != 'delete'){
                $dat['name'] = $name_en[$key];
                $dat['name_fr'] = $name_fr[$key];
                $dat['short_name'] = $sname_en[$key];
                $dat['short_name_fr'] = $sname_fr[$key];
				$this->db->where('exam_id', $param1);
				$this->db->where('id', $value);
				$this->db->update('exam_option', $dat);
			}

			$section_value = null;
			if (strpos($value, 'delete') == true) {
				$section_value = str_replace('delete', '', $value);
			}
			if($value == $section_value.'delete'){
				//$dat['name'] = $section_name[$key];
				$this->db->where('exam_id', $param1);
				$this->db->where('id', $section_value);
				$this->db->delete('exam_option');
			}
		} 

		$response = array(
			'status' => true,
			'notification' => get_phrase('exams_updated_successfully')
		);
		return json_encode($response);
	}
    
	public function behavior_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('nameen'));
		$data['name_fr'] = html_escape($this->input->post('namefr'));
		$data['short_name'] = html_escape($this->input->post('ensname'));
		$data['short_name_fr'] = html_escape($this->input->post('frsname'));
		//$data['session'] = html_escape($this->input->post('session'));
		$this->db->where('id', $param1);
		$this->db->update('mark_behavior', $data);
        //check the number of sections of the class
        
        $section_id = html_escape($this->input->post('section_id'));
		$name_en = html_escape($this->input->post('optenname'));
        $name_fr = html_escape($this->input->post('optfrname'));
        $percentage = html_escape($this->input->post('optrep'));
        
		foreach($section_id as $key => $value){
			if($value == 0){
				$dat['mark_behavior_id'] = $param1;
				$dat['name'] = $name_en[$key];
				$dat['name_fr'] = $name_fr[$key];
				$dat['percentage'] = $percentage[$key];
                if($dat['name'] != null){
                    $this->db->insert('mark_behavior_option', $dat);
                }
			}
			if($value != 0 && $value != 'delete'){
				$dat['mark_behavior_id'] = $param1;
				$dat['name'] = $name_en[$key];
				$dat['name_fr'] = $name_fr[$key];
				$dat['percentage'] = $percentage[$key];
				$this->db->where('mark_behavior_id', $param1);
				$this->db->where('id', $value);
				$this->db->update('mark_behavior_option', $dat);
			}

			$section_value = null;
			if (strpos($value, 'delete') == true) {
				$section_value = str_replace('delete', '', $value);
			}
			if($value == $section_value.'delete'){
				//$dat['name'] = $section_name[$key];
				$this->db->where('mark_behavior_id', $param1);
				$this->db->where('id', $section_value);
				$this->db->delete('mark_behavior_option');
			}
		} 
         
        
		$response = array(
			'status' => true,
			'notification' => get_phrase('mark_behavior_updated_successfully')
		);
		return json_encode($response);
	}
    
	public function classs_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['division_id'] = html_escape($this->input->post('section'));
		$data['use_sections'] = html_escape($this->input->post('use_sections'));
		$data['short_name'] = html_escape($this->input->post('sname'));
		$this->db->where('id', $param1);
		$this->db->update('classes', $data);
        //check the number of sections of the class
        
        $section_id = html_escape($this->input->post('section_id'));
		$section_name = html_escape($this->input->post('section_name'));
		foreach($section_id as $key => $value){
			if($value == 0){
				$dat['class_id'] = $param1;
				$dat['name'] = $section_name[$key];
				if($dat['name'] != null){
                    $this->db->insert('sections', $dat);
                }
			}
			if($value != 0 && $value != 'delete'){
				$dat['name'] = $section_name[$key];
				$this->db->where('class_id', $param1);
				$this->db->where('id', $value);
				$this->db->update('sections', $dat);
			}

			$section_value = null;
			if (strpos($value, 'delete') == true) {
				$section_value = str_replace('delete', '', $value);
			}
			if($value == $section_value.'delete'){
				$dat['name'] = $section_name[$key];
				$this->db->where('class_id', $param1);
				$this->db->where('id', $section_value);
				$this->db->delete('sections');
			}
		} 
         
        
		$response = array(
			'status' => true,
			'notification' => get_phrase('class_updated_successfully')
		);
		return json_encode($response);
	}
    
	public function fees_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['short_name'] = html_escape($this->input->post('sname'));
		$data['description'] = html_escape($this->input->post('description'));
        $data['type'] = html_escape($this->input->post('type'));
		$data['session'] = html_escape($this->input->post('session'));
		$data['exigibility'] = html_escape($this->input->post('exigibility'));
		$this->db->where('id', $param1);
		$this->db->update('fees', $data);
        //check the number of sections of the class
         
		$response = array(
			'status' => true,
			'notification' => get_phrase('fees_updated_successfully')
		);
		return json_encode($response);
	}
    
	public function option_update($param1 = '')
	{
		$section_id = html_escape($this->input->post('division_id'));
		
        $section_name = html_escape($this->input->post('division_name'));
		$section_sname = html_escape($this->input->post('division_sname'));
        $fsection_name = html_escape($this->input->post('fdivision_name'));
        $fsection_sname = html_escape($this->input->post('fdivision_sname'));
        
		foreach($section_id as $key => $value){
			if($value == 0){
				$data['division_id'] = $param1;
				$data['name'] = $section_name[$key];
				$data['short_name'] = $section_sname[$key];
                $data['name_fr'] = $fsection_name[$key];
                $data['short_name_fr'] = $fsection_sname[$key];
				$this->db->insert('division_option', $data);
			}
			if($value != 0 && $value != 'delete'){
				$data['name'] = $section_name[$key];
				$data['short_name'] = $section_sname[$key];
                $data['name_fr'] = $fsection_name[$key];
                $data['short_name_fr'] = $fsection_sname[$key];
				//$this->db->where('school_id', $param1);
				$this->db->where('id', $value);
				$this->db->update('division_option', $data);
			}

			$section_value = null;
			if (strpos($value, 'delete') == true) {
				$section_value = str_replace('delete', '', $value);
			}
			if($value == $section_value.'delete'){
				$data['name'] = $section_name[$key];
				//$this->db->where('school_id', $param1);
				$this->db->where('id', $section_value);
				$this->db->delete('division_option');
			}
		}

		$response = array(
			'status' => true,
			'notification' => get_phrase('option_list_updated_successfully')
		);
		return json_encode($response);
	}
	public function division_update($param1 = '')
	{
		$section_id = html_escape($this->input->post('division_id'));
		$section_name = html_escape($this->input->post('division_name'));
		$section_sname = html_escape($this->input->post('division_sname'));
        $fsection_name = html_escape($this->input->post('fdivision_name'));
        $fsection_sname = html_escape($this->input->post('fdivision_sname'));
        
		foreach($section_id as $key => $value){
			if($value == 0){
				$data['school_id'] = $param1;
				$data['name'] = $section_name[$key];
				$data['short_name'] = $section_sname[$key];
                $data['name_fr'] = $fsection_name[$key];
                $data['short_name_fr'] = $fsection_sname[$key];
				$this->db->insert('divisions', $data);
			}
			if($value != 0 && $value != 'delete'){
				$data['name'] = $section_name[$key];
				$data['short_name'] = $section_sname[$key];
                $data['name_fr'] = $fsection_name[$key];
                $data['short_name_fr'] = $fsection_sname[$key];
				$this->db->where('school_id', $param1);
				$this->db->where('id', $value);
				$this->db->update('divisions', $data);
			}

			$section_value = null;
			if (strpos($value, 'delete') == true) {
				$section_value = str_replace('delete', '', $value);
			}
			if($value == $section_value.'delete'){
				$data['name'] = $section_name[$key];
				$this->db->where('school_id', $param1);
				$this->db->where('id', $section_value);
				$this->db->delete('divisions');
			}
		}

		$response = array(
			'status' => true,
			'notification' => get_phrase('division_list_updated_successfully')
		);
		return json_encode($response);
	}
    
	public function section_b_update($param1 = '')
	{
		$section_id = html_escape($this->input->post('section_id'));
		$name_en = html_escape($this->input->post('optenname'));
        $name_fr = html_escape($this->input->post('optfrname'));
        $percentage = html_escape($this->input->post('optrep'));
		foreach($section_id as $key => $value){
			if($value == 0){
				$dat['mark_behavior_id'] = $param1;
				$dat['name'] = $name_en[$key];
				$dat['name_fr'] = $name_fr[$key];
				$dat['percentage'] = $percentage[$key];
				if($dat['name'] != null){
                    $this->db->insert('mark_behavior_option', $dat);
                }
			}
			if($value != 0 && $value != 'delete'){
				$dat['mark_behavior_id'] = $param1;
				$dat['name'] = $name_en[$key];
				$dat['name_fr'] = $name_fr[$key];
				$dat['percentage'] = $percentage[$key];
				$this->db->where('mark_behavior_id', $param1);
				$this->db->where('id', $value);
				$this->db->update('mark_behavior_option', $dat);
			}

			$section_value = null;
			if (strpos($value, 'delete') == true) {
				$section_value = str_replace('delete', '', $value);
			}
			if($value == $section_value.'delete'){
				//$dat['name'] = $section_name[$key];
				$this->db->where('mark_behavior_id', $param1);
				$this->db->where('id', $section_value);
				$this->db->delete('mark_behavior_option');
			}
		}

		$response = array(
			'status' => true,
			'notification' => get_phrase('behavior_updated_successfully')
		);
		return json_encode($response);
	}
	public function section_update($param1 = '')
	{
		$section_id = html_escape($this->input->post('section_id'));
		$section_name = html_escape($this->input->post('section_name'));
		$fsection_name = html_escape($this->input->post('fsection_name'));
		$section_sname = html_escape($this->input->post('section_sname'));
		$fsection_sname = html_escape($this->input->post('fsection_sname'));
		$division = html_escape($this->input->post('division'));
		$option = html_escape($this->input->post('option'));
		foreach($section_id as $key => $value){
			if($value == 0){
				$data['class_id'] = $param1;
				$data['name'] = $section_name[$key];
				$data['name_fr'] = $fsection_name[$key];
				$data['short_name_fr'] = $fsection_sname[$key];
				$data['short_name'] = $section_sname[$key];
				$data['option_id'] = $option[$key];
				$data['division_id'] = $division[$key];
				$this->db->insert('sections', $data);
			}
			if($value != 0 && $value != 'delete'){
				$data['name'] = $section_name[$key];
				$data['name_fr'] = $fsection_name[$key];
				$data['short_name_fr'] = $fsection_sname[$key];
				$data['short_name'] = $section_sname[$key];
				$data['option_id'] = $option[$key];
				$data['division_id'] = $division[$key];
				$this->db->where('class_id', $param1);
				$this->db->where('id', $value);
				$this->db->update('sections', $data);
			}

			$section_value = null;
			if (strpos($value, 'delete') == true) {
				$section_value = str_replace('delete', '', $value);
			}
			if($value == $section_value.'delete'){
				//$this->db->where('class_id', $param1);
				$this->db->where('id', $section_value);
				$this->db->delete('sections');
			}
		}

		$response = array(
			'status' => true,
			'notification' => get_phrase('section_list_updated_successfully')
		);
		return json_encode($response);
	}

	public function fees_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('fees');

		$response = array(
			'status' => true,
			'notification' => get_phrase('fees_deleted_successfully')
		);
		return json_encode($response);
	}

	public function school_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('schools');

		$this->db->where('school_id', $param1);
		$this->db->delete('divisions');

		$response = array(
			'status' => true,
			'notification' => get_phrase('school_deleted_successfully')
		);
		return json_encode($response);
	}
    
	public function school_option_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('division_option');


		$response = array(
			'status' => true,
			'notification' => get_phrase('option_deleted_successfully')
		);
		return json_encode($response);
	}
	public function class_option_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('sections');


		$response = array(
			'status' => true,
			'notification' => get_phrase('option_deleted_successfully')
		);
		return json_encode($response);
	}

	public function class_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('classes');

		$this->db->where('class_id', $param1);
		$this->db->delete('sections');

		$response = array(
			'status' => true,
			'notification' => get_phrase('class_deleted_successfully')
		);
		return json_encode($response);
	}
    
	public function behavior_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('mark_behavior');

		$this->db->where('mark_behavior_id', $param1);
		$this->db->delete('mark_behavior_option');

		$response = array(
			'status' => true,
			'notification' => get_phrase('behavior_deleted_successfully')
		);
		return json_encode($response);
	}

	// Get section details by class and section id
	public function get_section_details_by_id($type = "", $id = "") {
		$section_details = array();
		if ($type == 'class') {
			$section_details = $this->db->get_where('sections', array('class_id' => $id));
		}elseif ($type == 'section') {
			$section_details = $this->db->get_where('sections', array('id' => $id));
		}
		return $section_details;
	}

	//get Class details by id
	public function get_class_details_by_id($id) {
		$class_details = $this->db->get_where('classes', array('id' => $id));
		return $class_details;
	}
	//END CLASS section


	//START CLASS_ROOM section
	public function class_room_create()
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['school_id'] = html_escape($this->input->post('school_id'));
		$this->db->insert('class_rooms', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('classroom_added_successfully')
		);
		return json_encode($response);
	}

	public function class_room_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$this->db->where('id', $param1);
		$this->db->update('class_rooms', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('classroom_updated_successfully')
		);
		return json_encode($response);
	}

	public function class_room_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('class_rooms');

		$response = array(
			'status' => true,
			'notification' => get_phrase('classroom_deleted_successfully')
		);
		return json_encode($response);
	}
    
	public function copydecision($param1 = '')
	{
		$dec = $this->db->get_where('decisions', array('school_id' => $this->school_id, 'session' => $this->active_session))->result_array();
            foreach($dec as $dec){
                $data['name'] = $dec['name'];
                $data['name_fr'] = $dec['name_fr'];
                $data['school_id'] = $dec['school_id'];
                $data['session'] = $param1;
                $data['from'] = $dec['from'];
                $data['to'] = $dec['to'];
                $data['option'] = $dec['option'];
                $data['type'] = $dec['type'];
                $this->db->insert('decisions', $data);
            }
	}
	public function copyss($param1 = '')
	{
		 $ss = $this->db->get_where('subject_settings', array('school_id' => $this->school_id, 'session' => $this->active_session))->result_array();
            foreach($ss as $us){
                $data['name'] = $us['name'];
                $data['name_fr'] = $us['name_fr'];
                $data['description'] = $us['description'];
                $data['description_fr'] = $us['description_fr'];
                $data['school_id'] = $us['school_id'];
                $data['session'] = $param1;
                $data['type'] = $us['type'];
                $this->db->insert('subject_settings', $data);
            }
	}
	public function copysh($param1 = '')
	{
		  $ssh = $this->db->get_where('subhead', array('school_id' => $this->school_id, 'session' => $this->active_session))->result_array();
            foreach($ssh as $us){
                $data['name'] = $us['name'];
                $data['short_name'] = $us['short_name'];
                $data['school_id'] = $us['school_id'];
                $data['session'] = $param1;
                $this->db->insert('subhead', $data);
            }
	}
    
	public function copymb($param1 = '')
	{
		  $mb = $this->db->get_where('mark_behavior', array('school_id' => $this->school_id, 'session' => $this->active_session))->result_array();
            foreach($mb as $us){
                $data['name'] = $us['name'];
                $data['name_fr'] = $us['name_fr'];
                $data['short_name'] = $us['short_name'];
                $data['short_name_fr'] = $us['short_name_fr'];
                $data['school_id'] = $us['school_id'];
                $data['session'] = $param1;
                $this->db->insert('mark_behavior', $data);
                $id = $this->db->insert_id();
                
                $mbo = $this->db->get_where('mark_behavior_option', array('mark_behavior_id' => $us['id']))->result_array();
                foreach($mbo as $uso){
                    $dat['name'] = $uso['name'];
                    $dat['name_fr'] = $uso['name_fr'];
                    $dat['percentage'] = $uso['percentage'];
                    $dat['mark_behavior'] = $id;
                    $this->db->insert('mark_behavior_option', $dat);
                }
            }
	}
	public function copyex($param1 = '')
	{
		  $mbe = $this->db->get_where('exams', array('school_id' => $this->school_id, 'session' => $this->active_session))->result_array();
            foreach($mbe as $us){
                $data['name'] = $us['name'];
                $data['name_fr'] = $us['name_fr'];
                $data['short_name'] = $us['short_name'];
                $data['short_name_fr'] = $us['short_name_fr'];
                $data['previous'] = $us['previous'];
                $data['is_last'] = $us['is_last'];
                $data['school_id'] = $us['school_id'];
                $data['session'] = $param1;
                $this->db->insert('exams', $data);
                $id = $this->db->insert_id();
                
                $mbo = $this->db->get_where('exam_option', array('exam_id' => $us['id']))->result_array();
                foreach($mbo as $uso){
                    $dat['name'] = $uso['name'];
                    $dat['name_fr'] = $uso['name_fr'];
                    $dat['short_name'] = $uso['short_name'];
                    $dat['short_name_fr'] = $uso['short_name_fr'];
                    $dat['status'] = $uso['status'];
                    $dat['exam_id'] = $id;
                    $this->db->insert('exam_option', $dat);
                }
            }
	}
	public function copydec($insert_id = '')
	{
		  $dic = $this->db->get_where('discipline_option', array('school_id' => $this->school_id, 'session' => $this->active_session))->result_array();
            foreach($dic as $us){
                $data['name'] = $us['name'];
                $data['name_fr'] = $us['name_fr'];
                $data['description'] = $us['description'];
                $data['description_fr'] = $us['description_fr'];
                $data['school_id'] = $us['school_id'];
                $data['session'] = $insert_id;
                $this->db->insert('discipline_option', $data);
            }
	}
	public function copyg($insert_id = '')
	{
		  $usg = $this->db->get_where('grades', array('school_id' => $this->school_id, 'session' => $this->active_session))->result_array();
            foreach($usg as $us){
                $data['name'] = $us['name'];
                $data['name_fr'] = $us['name_fr'];
                $data['short_name'] = $us['short_name'];
                $data['short_name_fr'] = $us['short_name_fr'];
                $data['school_id'] = $us['school_id'];
                $data['session'] = $insert_id;
                $data['grade_point'] = $us['grade_point'];
                $data['mark_from'] = $us['mark_from'];
                $data['mark_upto'] = $us['mark_upto'];
                $data['comment'] = $us['comment'];
                $this->db->insert('grades', $data);
            }
	}
	public function copyec($insert_id = '')
	{
		  $ex = $this->db->get_where('expense_categories', array('school_id' => $this->school_id, 'session' => $this->active_session))->result_array();
            foreach($ex as $us){
                $data['name'] = $us['name'];
                $data['school_id'] = $us['school_id'];
                $data['session'] = $insert_id;
                $this->db->insert('expense_categories', $data);
            }
	}
	public function copyh($insert_id = '')
	{
		  $ex = $this->db->get_where('document_headers', array('school_id' => $this->school_id, 'session' => $this->active_session))->result_array();
            foreach($ex as $us){
                $data['title'] = $us['title'];
                $data['type'] = $us['type'];
                $data['col1'] = $us['col1'];
                $data['col2'] = $us['col2'];
                $data['col3'] = $us['col3'];
                $data['col4'] = $us['col4'];
                $data['color'] = $us['color'];
                $data['size'] = $us['size'];
                $data['border'] = $us['border'];
                $data['orderh'] = $us['orderh'];
                $data['school_id'] = $us['school_id'];
                $data['session'] = $insert_id;
                $this->db->insert('document_headers', $data);
            }
	}
	public function copyteach($insert_id = '')
	{
		  $uss = $this->db->get_where('teachers', array('school_id' => $this->school_id, 'session' => $this->active_session))->result_array();
            foreach($uss as $us){
                $data['user_id'] = $us['user_id'];
                $data['department_id'] = $us['department_id'];
                $data['designation'] = $us['designation'];
                $data['about'] = $us['about'];
                $data['school_id'] = $us['school_id'];
                $data['session'] = $insert_id; 
                $this->db->insert('teachers', $data);
            }
	}
	public function copysub($param1 = '')
	{
		  $us = $this->db->get_where('subjects', array('school_id' => $this->school_id, 'session' => $this->active_session))->result_array();
            foreach($us as $us){
                $data['name'] = $us['name'];
                $data['short_name'] = $us['short_name'];
                $data['class_id'] = $us['class_id'];
                $data['section_id'] = $us['section_id'];
                $data['school_id'] = $us['school_id'];
                $data['session'] = $param1;
                $data['behavior'] = $us['behavior'];
                $data['group'] = $us['group'];
                $data['type'] = $us['type'];
                $data['subhead'] = $us['subhead'];
                $data['coef'] = $us['coef'];
                $data['teacher_id'] = $us['teacher_id'];  
                $data['doing_period'] = $us['doing_period']; 
                $this->db->insert('subjects', $data);
            }
	}
    
	//END CLASS_ROOM section


	//START MANAGE_SESSION section
	public function session_create()
	{
		$data['name'] = html_escape($this->input->post('session_title'));
		$this->db->insert('sessions', $data);
        $insert_id = $this->db->insert_id();
                 
        
        $this->copysub($insert_id);
        $this->copydecision($insert_id);
        $this->copyss($insert_id);
        $this->copydec($insert_id);
        $this->copysh($insert_id);
        $this->copymb($insert_id);
        $this->copyex($insert_id);
        $this->copyec($insert_id);
        $this->copyg($insert_id);           
        $this->copyh($insert_id);           
        $this->copyteach($insert_id);  
        
		$response = array(
			'status' => true,
			'notification' => get_phrase('session_has_been_created_successfully')
		);

		return json_encode($response);
	}

	public function session_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('session_title'));
		$this->db->where('id', $param1);
		$this->db->update('sessions', $data);
		$response = array(
			'status' => true,
			'notification' => get_phrase('session_has_been_updated_successfully')
		);

		return json_encode($response);
	}

	public function session_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('sessions');
		$response = array(
			'status' => true,
			'notification' => get_phrase('session_has_been_deleted_successfully')
		);

		return json_encode($response);
	}

	public function active_session($param1 = ''){
		$previous_session_id = active_session();
		$this->db->where('id', $previous_session_id);
		$this->db->update('sessions', array('status' => 0));
		$this->db->where('id', $param1);
		$this->db->update('sessions', array('status' => 1));
		$response = array(
			'status' => true,
			'notification' => get_phrase('session_has_been_activated')
		);
		return json_encode($response);
	}
	//END MANAGE_SESSION section


	//START SUBJECT section
	public function subject_create()
	{   
		$ic = html_escape($this->input->post('ic'));
		$c1 = html_escape($this->input->post('c1'));
		$c2 = html_escape($this->input->post('c2'));
		$s1 = html_escape($this->input->post('s1'));
		$s2 = html_escape($this->input->post('s2'));
        if($ic > 0){
            $us = $this->db->get_where('subjects', array('school_id' => $this->school_id, 'session' => $this->active_session, 'class_id' => $c1, 'section_id' => $s1))->result_array();
            foreach($us as $us){
                $data['name'] = $us['name'];
                $data['short_name'] = $us['short_name'];
                $data['class_id'] = $c2;
                $data['section_id'] = $s2;
                $data['school_id'] = html_escape($this->input->post('school_id'));
                $data['session'] = html_escape($this->input->post('session'));
                $data['behavior'] = $us['behavior'];
                $data['group'] = $us['group'];
                $data['type'] = $us['type'];
                $data['coef'] = $us['coef'];
                $data['teacher_id'] = $us['teacher_id'];  
                $data['doing_period'] = $us['doing_period']; 
                $this->db->insert('subjects', $data);
            }
        }else{
		$data['name'] = html_escape($this->input->post('name'));
		$data['short_name'] = html_escape($this->input->post('sname'));
		$data['class_id'] = html_escape($this->input->post('class_id'));
		$data['school_id'] = html_escape($this->input->post('school_id'));
		$data['session'] = html_escape($this->input->post('session'));
        $use = $this->db->get_where('classes', array('id' => $data['class_id']))->row()->use_sections;
        if($use < 1){
            $data['behavior'] = html_escape($this->input->post('behavior'));
            $data['group'] = html_escape($this->input->post('group'));
            $data['type'] = html_escape($this->input->post('type'));
            $data['coef'] = html_escape($this->input->post('coef'));
            $data['teacher_id'] = html_escape($this->input->post('teacher'));
            $data['doing_period'] = html_escape($this->input->post('period'));
            $this->db->insert('subjects', $data);
        }else{
            $dat['class_id'] = html_escape($this->input->post('class_id'));
		    $dat['school_id'] = html_escape($this->input->post('school_id'));
		    $dat['session'] = html_escape($this->input->post('session'));
            $dat['name'] = html_escape($this->input->post('name'));
            $dat['short_name'] = html_escape($this->input->post('sname'));
            $this->db->insert('subhead', $dat);
            $insert = $this->db->insert_id();
            
            $uses = $this->db->get_where('sections', array('class_id' => $data['class_id']))->result_array();
            foreach($uses as $uses){
            $d= html_escape($this->input->post('use'.$uses['id']));
            if($d > 0){
                $data['section_id'] = $uses['id'];
                $data['behavior'] = html_escape($this->input->post('behavior'.$uses['id']));
                $data['group'] = html_escape($this->input->post('group'.$uses['id']));
                $data['type'] = html_escape($this->input->post('type'.$uses['id']));
                $data['coef'] = html_escape($this->input->post('coef'.$uses['id']));
                $data['subhead'] = $insert;
                $data['teacher_id'] = html_escape($this->input->post('teacher'.$uses['id']));  
                $data['doing_period'] = html_escape($this->input->post('period'.$uses['id']));  
                $this->db->insert('subjects', $data);
            }
            }
        }
        }

		$response = array(
			'status' => true,
			'notification' => get_phrase('subject_has_been_added_successfully')
		);

		return json_encode($response);
	}//START SUBJECT section

    
    public function subjects_create()
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['name_fr'] = html_escape($this->input->post('frname'));
		$data['description'] = html_escape($this->input->post('dname'));
		$data['description_fr'] = html_escape($this->input->post('dfrname'));
		$data['type'] = html_escape($this->input->post('class_id'));
		$data['school_id'] = html_escape($this->input->post('school_id'));
		$data['session'] = html_escape($this->input->post('session'));
		$this->db->insert('subject_settings', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('subject_setting_has_been_added_successfully')
		);

		return json_encode($response);
	}
    
    public function discipline_create() 
	{
		$type = html_escape($this->input->post('type'));
        if($type == 1){
		$data['name'] = html_escape($this->input->post('sname'));
		$data['name_fr'] = html_escape($this->input->post('sfrname'));
		$data['description'] = html_escape($this->input->post('dname'));
		$data['description_fr'] = html_escape($this->input->post('dfrname'));
		$data['school_id'] = html_escape($this->input->post('school_id'));
		$data['session'] = html_escape($this->input->post('session'));
		$this->db->insert('discipline_option', $data);
        }else{
		$data['name'] = html_escape($this->input->post('name'));
		$data['type'] ="discipline";
		$data['name_fr'] = html_escape($this->input->post('frname')); 
		$data['from'] = html_escape($this->input->post('mark_from')); 
		$data['to'] = html_escape($this->input->post('mark_upto')); 
		$data['option'] = html_escape($this->input->post('option')); 
		$data['school_id'] = html_escape($this->input->post('school_id'));
		$data['session'] = html_escape($this->input->post('session'));
		$this->db->insert('decisions', $data);
        }

		$response = array(
			'status' => true,
			'notification' => get_phrase('setting_has_been_added_successfully')
		);

		return json_encode($response);
	}
    
    public function decision_create() 
	{
		$type = html_escape($this->input->post('type'));
		$data['option'] = html_escape($this->input->post('option')); 
        $data['name'] = html_escape($this->input->post('name'));
//        $data['typec'] = html_escape($this->input->post('namee'));
		$data['type'] =$type;
		$data['name_fr'] = html_escape($this->input->post('frname')); 
//		$data['typecfr'] = html_escape($this->input->post('frnamee')); 
		$data['from'] = html_escape($this->input->post('mark_from')); 
		$data['to'] = html_escape($this->input->post('mark_upto')); 
		$data['school_id'] = html_escape($this->input->post('school_id'));
		$data['session'] = html_escape($this->input->post('session'));
		$this->db->insert('decisions', $data);  
		$response = array(
			'status' => true,
			'notification' => get_phrase('decision_has_been_added_successfully')
		);

		return json_encode($response);
	}

	public function subject_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['short_name'] = html_escape($this->input->post('sname'));
		$data['class_id'] = html_escape($this->input->post('class_id'));
        
            $data['behavior'] = html_escape($this->input->post('behavior'));
            $data['group'] = html_escape($this->input->post('group'));
            $data['type'] = html_escape($this->input->post('type'));
            $data['coef'] = html_escape($this->input->post('coef'));
            $data['teacher_id'] = html_escape($this->input->post('teacher'));
            $data['doing_period'] = html_escape($this->input->post('period'));
            $n=$this->db->get_where('subjects', array('id' => $id, 'class_id'=>$class_id, 'section_id >' =>0))->num_rows(); 
            $this->db->where('id', $param1);
		    $this->db->update('subjects', $data);
        
            
            $dat['coef'] = html_escape($this->input->post('coef'));
            $this->db->where('subject_id', $param1);
            $this->db->where('session', $this->active_session);
		    $this->db->update('average_subject', $dat);
        
		$response = array(
			'status' => true,
			'notification' => get_phrase('subject_has_been_updated_successfully')
		);

		return json_encode($response);
	}
    
    	public function subject_delete($param1 = '')
	{
        $use = $this->db->get_where('subjects', array('id' => $param1))->row()->class_id;
		$this->db->where('id', $param1);
		$this->db->delete('subjects');
            
        $this->db->where('subject_id', $param1);
		$this->db->delete('average_global_subject');
            
        $this->db->where('subject_id', $param1);
		$this->db->delete('average_subject');
            
        $this->db->where('subject_id', $param1);
		$this->db->delete('marks');
            
        $this->db->where('subject_id', $param1);
		$this->db->delete('marks');

		$response = array(
			'status' => true,
			'notification' => get_phrase('subject_has_been_deleted_successfully')
		);

		return json_encode($response);
	}

	public function decision_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['option'] = html_escape($this->input->post('option')); 
		$data['type'] =html_escape($this->input->post('type'));
//        $data['typec'] = html_escape($this->input->post('namee'));
//		$data['typecfr'] = html_escape($this->input->post('frnamee')); 
		$data['name_fr'] = html_escape($this->input->post('frname')); 
		$data['from'] = html_escape($this->input->post('mark_from')); 
		$data['to'] = html_escape($this->input->post('mark_upto')); 
		$this->db->where('id', $param1);
		$this->db->update('decisions', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('discipline_option_has_been_updated_successfully')
		);

		return json_encode($response);
	}
	public function discipline_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['name_fr'] = html_escape($this->input->post('frname'));
		$data['description'] = html_escape($this->input->post('dname'));
		$data['description_fr'] = html_escape($this->input->post('dfrname'));
		$this->db->where('id', $param1);
		$this->db->update('discipline_option', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('discipline_option_has_been_updated_successfully')
		);

		return json_encode($response);
	}
    
	public function subjects_update($param1 = '')
	{
		$data['type'] = html_escape($this->input->post('class_id'));
		$data['name'] = html_escape($this->input->post('name'));
		$data['name_fr'] = html_escape($this->input->post('frname'));
		$data['description'] = html_escape($this->input->post('dname'));
		$data['description_fr'] = html_escape($this->input->post('dfrname'));
		$this->db->where('id', $param1);
		$this->db->update('subject_settings', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('subject_settings_has_been_updated_successfully')
		);

		return json_encode($response);
	}
    

	public function decision_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('decisions');

		$response = array(
			'status' => true,
			'notification' => get_phrase('decision_has_been_deleted_successfully')
		);

		return json_encode($response);
	}
    
	public function discipline_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('discipline_option');

		$response = array(
			'status' => true,
			'notification' => get_phrase('discipline_option_has_been_deleted_successfully')
		);

		return json_encode($response);
	}
    
    public function subjects_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('subject_settings');

		$response = array(
			'status' => true,
			'notification' => get_phrase('subject_settings_has_been_deleted_successfully')
		);

		return json_encode($response);
	}

	public function get_subject_by_id($subject_id = '') {
		return $this->db->get_where('subjects', array('id' => $subject_id))->row_array();
	}
	
	//END SUBJECT section


	//START DEPARTMENT section
	public function department_create()
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['school_id'] = html_escape($this->input->post('school_id'));
		$this->db->insert('departments', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('department_has_been_added_successfully')
		);

		return json_encode($response);
	}
    
    public function get_col1_image($user_id) {
		if (file_exists('uploads/column/col1/'.$user_id.'.png'))
		return base_url().'uploads/column/col1/'.$user_id.'.png';
	}
    
    public function get_col2_image($user_id) {
		if (file_exists('uploads/column/col2/'.$user_id.'.png'))
		return base_url().'uploads/column/col2/'.$user_id.'.png';
	}
    public function get_col3_image($user_id) {
		if (file_exists('uploads/column/col3/'.$user_id.'.png'))
		return base_url().'uploads/column/col3/'.$user_id.'.png';
	}
    public function get_col4_image($user_id) {
		if (file_exists('uploads/column/col4/'.$user_id.'.png'))
		return base_url().'uploads/column/col4/'.$user_id.'.png';
	}
	//START header section
	public function header_create()
	{
		$data['title'] = html_escape($this->input->post('name'));
		$data['type'] = html_escape($this->input->post('type'));
		$data['col1'] = html_escape($this->input->post('col1'));
		$data['col2'] = html_escape($this->input->post('col2'));
		$data['orderh'] = html_escape($this->input->post('order'));
		$data['border'] = html_escape($this->input->post('border'));
		$data['color'] = html_escape($this->input->post('color'));
		$data['size'] = html_escape($this->input->post('size'));
		$data['col3'] = html_escape($this->input->post('col3'));
		$data['col4'] = html_escape($this->input->post('col4'));
		$data['school_id'] = html_escape($this->input->post('school_id'));
		$data['session'] = $this->active_session;
		$this->db->insert('document_headers', $data);
        $id = $this->db->insert_id();
        
        if ($_FILES['col1p']['name'] != '') {
            move_uploaded_file($_FILES['col1p']['tmp_name'], 'uploads/column/col1/'.$id.'.png');
		}
        if ($_FILES['col2p']['name'] != '') {
			move_uploaded_file($_FILES['col2p']['tmp_name'], 'uploads/column/col2/'.$id.'.png');
		}
        if ($_FILES['col3p']['name'] != '') {
			move_uploaded_file($_FILES['col3p']['tmp_name'], 'uploads/column/col3/'.$id.'.png');
		}
        if ($_FILES['col4p']['name'] != '') {
			move_uploaded_file($_FILES['col4p']['tmp_name'], 'uploads/column/col4/'.$id.'.png');
		}

		$response = array(
			'status' => true,
			'notification' => get_phrase('header_line_has_been_added_successfully')
		);

		return json_encode($response);
	}

	public function header_update($param1 = '')
	{
		$data['title'] = html_escape($this->input->post('name'));
		$data['col1'] = html_escape($this->input->post('col1'));
		$data['orderh'] = html_escape($this->input->post('order'));
		$data['border'] = html_escape($this->input->post('border'));
		$data['color'] = html_escape($this->input->post('color'));
		$data['size'] = html_escape($this->input->post('size'));
		$data['col2'] = html_escape($this->input->post('col2'));
		$data['col3'] = html_escape($this->input->post('col3'));
		$data['col4'] = html_escape($this->input->post('col4'));
        $id = $param1;
        if ($_FILES['col1p']['name'] != '') {
            move_uploaded_file($_FILES['col1p']['tmp_name'], 'uploads/column/col1/'.$id.'.png');
		}
        if ($_FILES['col2p']['name'] != '') {
			move_uploaded_file($_FILES['col2p']['tmp_name'], 'uploads/column/col2/'.$id.'.png');
		}
        if ($_FILES['col3p']['name'] != '') {
			move_uploaded_file($_FILES['col3p']['tmp_name'], 'uploads/column/col3/'.$id.'.png');
		}
        if ($_FILES['col4p']['name'] != '') {
			move_uploaded_file($_FILES['col4p']['tmp_name'], 'uploads/column/col4/'.$id.'.png');
		}
        
		$this->db->where('id', $param1);
		$this->db->update('document_headers', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('header_line_has_been_updated_successfully')
		);

		return json_encode($response);
	}
    
    public function header_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('document_headers');

		$response = array(
			'status' => true,
			'notification' => get_phrase('header_line_has_been_deleted_successfully')
		);

		return json_encode($response);
	}

	public function department_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$this->db->where('id', $param1);
		$this->db->update('departments', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('department_has_been_updated_successfully')
		);

		return json_encode($response);
	}

	public function department_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('departments');

		$response = array(
			'status' => true,
			'notification' => get_phrase('department_has_been_deleted_successfully')
		);

		return json_encode($response);
	}
	//END DEPARTMENT section


	//START SYLLABUS section
	public function syllabus_create($param1 = '')
	{
		$data['title'] = html_escape($this->input->post('title'));
		$data['class_id'] = html_escape($this->input->post('class_id'));
		$data['section_id'] = html_escape($this->input->post('section_id'));
		$data['subject_id'] = html_escape($this->input->post('subject_id'));
		$data['session_id'] = html_escape($this->input->post('session_id'));
		$data['school_id'] = html_escape($this->input->post('school_id'));
		$file_ext = pathinfo($_FILES['syllabus_file']['name'], PATHINFO_EXTENSION);
		$data['file'] = md5(rand(10000000, 20000000)).'.'.$file_ext;
		move_uploaded_file($_FILES['syllabus_file']['tmp_name'], 'uploads/syllabus/'.$data['file']);
		$this->db->insert('syllabuses', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('syllabus_added_successfully')
		);
		return json_encode($response);
	}
	public function syllabus_delete($param1){
		$syllabus_details = $this->get_syllabus_by_id($param1);
		$this->db->where('id', $param1);
		$this->db->delete('syllabuses');
		$path = 'uploads/syllabus/'.$syllabus_details['file'];
		if (file_exists($path)){
				unlink($path);
		}
		$response = array(
			'status' => true,
			'notification' => get_phrase('syllabus_deleted_successfully')
		);
		return json_encode($response);
	}

	public function get_syllabus_by_id($syllabus_id = "") {
		return $this->db->get_where('syllabuses', array('id' => $syllabus_id))->row_array();
	}
	//END SYLLABUS section

	//START CLASS ROUTINE section
	public function routine_create()
	{
		$data['class_id'] = html_escape($this->input->post('class_id'));
		$data['section_id'] = html_escape($this->input->post('section_id'));
		$data['subject_id'] = html_escape($this->input->post('subject_id'));
		$data['teacher_id'] = html_escape($this->input->post('teacher_id'));
		$data['room_id'] = html_escape($this->input->post('class_room_id'));
		$data['day'] = html_escape($this->input->post('day'));
		$data['starting_hour'] = html_escape($this->input->post('starting_hour'));
		$data['starting_minute'] = html_escape($this->input->post('starting_minute'));
		$data['ending_hour'] = html_escape($this->input->post('ending_hour'));
		$data['ending_minute'] = html_escape($this->input->post('ending_minute'));
		$data['school_id'] = $this->school_id;
		$data['session_id'] = $this->active_session;
		$this->db->insert('routines', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('class_routine_added_successfully')
		);

		return json_encode($response);
	}

	public function routine_update($param1 = '')
	{
		$data['class_id'] = html_escape($this->input->post('class_id'));
		$data['section_id'] = html_escape($this->input->post('section_id'));
		$data['subject_id'] = html_escape($this->input->post('subject_id'));
		$data['teacher_id'] = html_escape($this->input->post('teacher_id'));
		$data['room_id'] = html_escape($this->input->post('class_room_id'));
		$data['day'] = html_escape($this->input->post('day'));
		$data['starting_hour'] = html_escape($this->input->post('starting_hour'));
		$data['starting_minute'] = html_escape($this->input->post('starting_minute'));
		$data['ending_hour'] = html_escape($this->input->post('ending_hour'));
		$data['ending_minute'] = html_escape($this->input->post('ending_minute'));
		$this->db->where('id', $param1);
		$this->db->update('routines', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('class_routine_updated_successfully')
		);

		return json_encode($response);
	}

	public function routine_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('routines');

		$response = array(
			'status' => true,
			'notification' => get_phrase('class_routine_deleted_successfully')
		);

		return json_encode($response);
	}
	//END CLASS ROUTINE section


	//START DAILY ATTENDANCE section
	public function take_attendance()
	{
		$students = $this->input->post('student_id');
		$data['timestamp'] = strtotime($this->input->post('date'));
		$data['class_id'] = html_escape($this->input->post('class_id'));
		$data['section_id'] = html_escape($this->input->post('section_id'));
		$data['school_id'] = $this->school_id;
		$data['session_id'] = $this->active_session;
		$check_data = $this->db->get_where('daily_attendances', array('timestamp' => $data['timestamp'], 'class_id' => $data['class_id'], 'section_id' => $data['section_id'], 'session_id' => $data['session_id'], 'school_id' => $data['school_id']));
		if($check_data->num_rows() > 0){
			foreach($students as $key => $student):
				$data['status'] = $this->input->post('status-'.$student);
				$data['student_id'] = $student;
				$attendance_id = $this->input->post('attendance_id');
				$this->db->where('id', $attendance_id[$key]);
				$this->db->update('daily_attendances', $data);
			endforeach;
		}else{
			foreach($students as $student):
				$data['status'] = $this->input->post('status-'.$student);
				$data['student_id'] = $student;
				$this->db->insert('daily_attendances', $data);
			endforeach;
		}

		$this->settings_model->last_updated_attendance_data();

		$response = array(
			'status' => true,
			'notification' => get_phrase('attendance_updated_successfully')
		);

		return json_encode($response);
	}

	public function get_todays_attendance() {
		$checker = array(
			'timestamp' => strtotime(date('Y-m-d')),
			'school_id' => $this->school_id,
			'status'    => 1
		);
		$todays_attendance = $this->db->get_where('daily_attendances', $checker);
		return $todays_attendance->num_rows();
	}
	//END DAILY ATTENDANCE section


	//START EVENT CALENDAR section
	public function event_calendar_create()
	{
		$data['title'] = html_escape($this->input->post('title'));
		$data['starting_date'] = $this->input->post('starting_date').' 00:00:1';
		$data['ending_date'] = $this->input->post('ending_date').' 23:59:59';
		$data['school_id'] = $this->school_id;
		$data['session'] = $this->active_session;
		$this->db->insert('event_calendars', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('event_has_been_added_successfully')
		);

		return json_encode($response);
	}

	public function event_calendar_update($param1 = '')
	{
		$data['title'] = html_escape($this->input->post('title'));
		$starting_date = strtotime(date('d/m/Y')) +1;
		$ending_date = strtotime(date('d/m/Y')) -1;
		$data['starting_date'] = $this->input->post('starting_date').' 00:00:1';
		$data['ending_date'] = $this->input->post('ending_date').' 23:59:59';
		$this->db->where('id', $param1);
		$this->db->update('event_calendars', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('event_has_been_updated_successfully')
		);

		return json_encode($response);
	}

	public function event_calendar_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('event_calendars');

		$response = array(
			'status' => true,
			'notification' => get_phrase('event_has_been_deleted_successfully')
		);

		return json_encode($response);
	}

	public function all_events(){

		$event_calendars = $this->db->get_where('event_calendars', array('school_id' => $this->school_id, 'session' => $this->active_session))->result_array();
		return json_encode($event_calendars);
	}

	public function get_current_month_events() {
		$this->db->where('school_id', $this->school_id);
		$this->db->where('session', $this->active_session);
		$events = $this->db->get('event_calendars');
		return $events;
	}
	//END EVENT CALENDAR section

	// START OF NOTICEBOARD SECTION
	public function create_notice() {
		$data['notice_title']     = html_escape($this->input->post('notice_title'));
		$data['notice']           = html_escape($this->input->post('notice'));
		$data['show_on_website']  = $this->input->post('show_on_website');
		$data['date'] 						= $this->input->post('date').' 00:00:1';
		$data['school_id'] 				= $this->school_id;
		$data['session'] 					= $this->active_session;
		if ($_FILES['notice_photo']['name'] != '') {
			$data['image']  = random(15).'.jpg';
			move_uploaded_file($_FILES['notice_photo']['tmp_name'], 'uploads/images/notice_images/'. $data['image']);
		}else{
			$data['image']  = 'placeholder.png';
		}
		$this->db->insert('noticeboard', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('notice_has_been_created')
		);

		return json_encode($response);
	}

	public function update_notice($notice_id) {
		$data['notice_title']     = html_escape($this->input->post('notice_title'));
		$data['notice']           = html_escape($this->input->post('notice'));
		$data['show_on_website']  = $this->input->post('show_on_website');
		$data['date'] 						= $this->input->post('date').' 00:00:1';
		if ($_FILES['notice_photo']['name'] != '') {
			$data['image']  = random(15).'.jpg';
			move_uploaded_file($_FILES['notice_photo']['tmp_name'], 'uploads/images/notice_images/'. $data['image']);
		}
		$this->db->where('id', $notice_id);
		$this->db->update('noticeboard', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('notice_has_been_updated')
		);

		return json_encode($response);
	}

	public function delete_notice($notice_id) {
		$this->db->where('id', $notice_id);
		$this->db->delete('noticeboard');

		$response = array(
			'status' => true,
			'notification' => get_phrase('notice_has_been_deleted')
		);

		return json_encode($response);
	}

	public function get_all_the_notices() {
		$notices = $this->db->get_where('noticeboard', array('school_id' => $this->school_id, 'session' => $this->active_session))->result_array();
		return json_encode($notices);
	}

	public function get_noticeboard_image($image) {
		if (file_exists('uploads/images/notice_images/'.$image))
		return base_url().'uploads/images/notice_images/'.$image;
		else
		return base_url().'uploads/images/notice_images/placeholder.png';
	}
	// END OF NOTICEBOARD SECTION


	public function get_exam_by_id($exam_id = "") {
		return $this->db->get_where('exams', array('id' => $exam_id))->row_array();
	}
	//END EXAM section


	//START MARKS section
	public function get_mark($class_id = "", $section_id = "", $subject_id = "", $exam_id = "", $student_id = "") {
        //$eid =$this->db->get_where('exam_option', array('id' => $exam_id))->row()->exam_id;
		$checker = array(
			'class_id' => $class_id,
			'section_id' => $section_id,
			'student_id' => $student_id,
			'subject_id' => $subject_id,
			'exam_id' => $exam_id,
			'school_id' => $this->school_id,
			'session' => $this->active_session
		);
        $this->db->order_by("name", "asc");
		$this->db->where($checker);
		return $this->db->get('marks')->row()->mark_obtained;
	}
    
	public function get_markm($class_id = "", $section_id = "", $subject_id = "", $exam_id = "", $behavior = ""){
        //$eid =$this->db->get_where('exam_option', array('id' => $exam_id))->row()->exam_id;
		$checker = array(
			'class_id' => $class_id,
			'section_id' => $section_id,
			'subject_id' => $subject_id,
			'behavior_option_id' => $behavior,
			'exam_id' => $exam_id,
			'school_id' => $this->school_id,
			'session' => $this->active_session
		);
		$this->db->where($checker);
		return $this->db->get('mark_option')->row()->max_mark;
	}	
    
    public function get_marks($class_id = "", $section_id = "", $subject_id = "", $exam_id = "") {
        //$eid =$this->db->get_where('exam_option', array('id' => $exam_id))->row()->exam_id;
		$checker = array(
			'class_id' => $class_id,
			'section_id' => $section_id,
			'subject_id' => $subject_id,
			'exam_id' => $exam_id,
			'school_id' => $this->school_id,
			'session' => $this->active_session
		);
        $this->db->order_by("name", "asc");
		$this->db->where($checker);
		return $this->db->get('marks');
	}	
    
    public function get_all_marks($class_id = "", $section_id = "", $exam_id = "") {
        //$eid =$this->db->get_where('exam_option', array('id' => $exam_id))->row()->exam_id;
		$checker = array(
			'class_id' => $class_id,
			'section_id' => $section_id,
			'exam_id' => $exam_id,
			'school_id' => $this->school_id,
			'session' => $this->active_session
		);
        $this->db->order_by("name", "asc");
		$this->db->where($checker);
		return $this->db->get('marks');
	}		
    
    //START MARKS AVERAGE selection
	public function get_marks_average($class_id = "", $section_id = "", $subject_id = "", $exam_id = "") {
        if($subject_id > 0){
            $checker = array(
                'class_id' => $class_id,
                'section_id' => $section_id,
                'subject_id' => $subject_id,
                'exam_id' => $exam_id,
                'school_id' => $this->school_id,
                'session' => $this->active_session
            );
        }else{
            $checker = array(
                'class_id' => $class_id,
                'section_id' => $section_id,
                'exam_id' => $exam_id,
                'school_id' => $this->school_id,
                'session' => $this->active_session
            );
        }
        $this->db->order_by("name", "asc");
		$this->db->where($checker);
		return $this->db->get('average_subject');
	}
    
	public function get_stu_marks_average($class_id = "", $section_id = "", $subject_id = "", $student_id = "") {
            $checker = array(
                'class_id' => $class_id,
                'section_id' => $section_id,
                'subject_id' => $subject_id,
                'student_id' => $student_id,
                'school_id' => $this->school_id,
                'session' => $this->active_session
            );
        
		$this->db->where($checker);
		return $this->db->get('average_global_subject');
	}    
    
	public function get_stlist($class_id = "", $section_id = "") {
            $checker = array(
                'class_id' => $class_id,
                'section_id' => $section_id,
                'school_id' => $this->school_id,
                'session' => $this->active_session
            );
        $this->db->order_by("name", "asc");
		$this->db->where($checker);
		return $this->db->get('enrols')->result_array();
	}   
    
    //START STUDENT MARKS AVERAGE selection
	public function get_stmarks_average($class_id = "", $section_id = "", $subject_id = "", $exam_id = "", $student_id = "") {
            $checker = array(
                'class_id' => $class_id,
                'section_id' => $section_id,
                'subject_id' => $subject_id,
                'exam_id' => $exam_id,
                'student_id' => $student_id,
                'school_id' => $this->school_id,
                'session' => $this->active_session
            );
		$this->db->where($checker);
		return $this->db->get('marks');
	}
    
    public function get_stmarks_averagecolor($class_id = "", $section_id = "", $subject_id = "", $exam_id = "", $student_id = "") {
            $checker = array(
                'class_id' => $class_id,
                'section_id' => $section_id,
                'subject_id' => $subject_id,
                'exam_id' => $exam_id,
                'student_id' => $student_id,
                'school_id' => $this->school_id,
                'session' => $this->active_session
            );
		$this->db->where($checker);
		$res = $this->db->get('marks')->row()->mark_obtained;
        if ($res < 10){ $col = "red";} else{$col ="black";}
        return $col;
	}	
    
    public function get_subdiv_averagemb($mark_id = "", $mb = "") {
            $checker = array(
                'mark_id' => $mark_id,
                'behavior_option_id' => $mb,
            );
		$this->db->where($checker);
		$res = $this->db->get('marks')->row()->mark_obtained;
        if ($res < 10){ $col = "red";} else{$col ="black";}
        return $col;
	}	
    
    public function get_subdiv_average($class_id = "", $section_id = "", $exam_id = "", $student_id = "") {
            $checker = array(
                'class_id' => $class_id,
                'section_id' => $section_id,
                'exam_option_id' => $exam_id,
                'student_id' => $student_id,
                'school_id' => $this->school_id,
                'session' => $this->active_session
            );
        $this->db->order_by('average','desc');
		$this->db->where($checker);
		return $this->db->get('average_subdivision');
	}	
    
    public function get_subdiv_gaverage($class_id = "", $section_id = "", $exam_id = "") {
            $checker = array(
                'class_id' => $class_id,
                'section_id' => $section_id,
                'exam_option_id' => $exam_id,
                'school_id' => $this->school_id,
                'session' => $this->active_session
            );
		$this->db->where($checker);
		return $this->db->get('general_exam_option_average');
	}	
    
    public function get_div_gaverage($class_id = "", $section_id = "", $exam_id = "") {
            $checker = array(
                'class_id' => $class_id,
                'section_id' => $section_id,
                'exam_id' => $exam_id, 
                'school_id' => $this->school_id,
                'session' => $this->active_session
            );
		$this->db->where($checker);
		return $this->db->get('general_exam_average');
	}
    
    public function get_global_gaverage($class_id = "", $section_id = "") {
            $checker = array(
                'class_id' => $class_id,
                'section_id' => $section_id,
                'school_id' => $this->school_id,
                'session' => $this->active_session
            );
		$this->db->where($checker);
		return $this->db->get('general_average');
	}	
    
    public function get_subdiv_global_average($class_id = "", $section_id = "", $exam_id = "") {
            $checker = array(
                'class_id' => $class_id,
                'section_id' => $section_id,
                'exam_option_id' => $exam_id,
                'school_id' => $this->school_id,
                'session' => $this->active_session
            );
        $this->db->order_by("average", "desc");
		$this->db->where($checker);
		return $this->db->get('average_subdivision');
	}
    
    public function get_div_average($class_id = "", $section_id = "", $exam_id = "", $student_id = "") {
            $checker = array(
                'class_id' => $class_id,
                'section_id' => $section_id,
                'exam_id' => $exam_id,
                'student_id' => $student_id,
                'school_id' => $this->school_id,
                'session' => $this->active_session
            );
        $this->db->order_by("average", "desc");
		$this->db->where($checker);
		return $this->db->get('average_division');
	} 
    
    //START MARKS AVERAGE selection
	public function get_stu_average($class_id = "", $section_id = "") {
            $checker = array(
                'class_id' => $class_id,
                'section_id' => $section_id,
                'school_id' => $this->school_id,
                'session' => $this->active_session
            );
        $this->db->order_by("name", "asc");
		$this->db->where($checker);
		return $this->db->get('enrols');
	} 
    
    public function get_global_average($class_id = "", $section_id = "",  $student_id = "") {
            $checker = array(
                'class_id' => $class_id,
                'section_id' => $section_id,
                'student_id' => $student_id,
                'school_id' => $this->school_id,
                'session' => $this->active_session
            );
        $this->db->order_by("average", "desc");
		$this->db->where($checker);
		return $this->db->get('average_session');
	}
    
    public function get_global_averagepro($class_id = "", $section_id = "",  $student_id = "", $session = "") {
            $checker = array(
                'class_id' => $class_id,
                'section_id' => $section_id,
                'student_id' => $student_id,
                'school_id' => $this->school_id,
                'session' => $session
            );
        $this->db->order_by("average", "desc");
		$this->db->where($checker);
		return $this->db->get('average_session');
	}
    
    public function get_global_averages($class_id = "", $section_id = "") {
            $checker = array(
                'class_id' => $class_id,
                'section_id' => $section_id,
                'school_id' => $this->school_id,
                'session' => $this->active_session
            );
        $this->db->order_by("average", "desc");
		$this->db->where($checker);
		return $this->db->get('average_session');
	}
    
    public function get_global_winners($class_id = "", $section_id = "") {
        $m=get_settings('average_promote');
            $checker = array(
                'class_id' => $class_id,
                'section_id' => $section_id,
                'school_id' => $this->school_id,
                'average >=' => $m,
                'session' => $this->active_session
            );
        $this->db->order_by("name", "asc");
		$this->db->where($checker);
		return $this->db->get('average_session');
	}
    
    public function get_global_losers($class_id = "", $section_id = "") {
        $m=get_settings('average_promote');
            $checker = array(
                'class_id' => $class_id,
                'section_id' => $section_id,
                'school_id' => $this->school_id,
                'average <' => $m,
                'session' => $this->active_session
            );
        $this->db->order_by("name", "asc");
		$this->db->where($checker);
		return $this->db->get('average_session');
	}
    
    public function checkenroll($session = "",$student_id = "") {
            $checker = array(
                'student_id' => $student_id,
                'school_id' => $this->school_id,
                'session' => $session
            );
		$this->db->where($checker);
		return $this->db->get('enrols');
	}
    
    public function get_div_averages($class_id = "", $section_id = "", $exam_id = "") {
            $checker = array(
                'class_id' => $class_id,
                'section_id' => $section_id,
                'exam_id' => $exam_id,
//                'student_id' => $student_id,
                'school_id' => $this->school_id,
                'session' => $this->active_session
            );
        $this->db->order_by("average", "desc");
		$this->db->where($checker);
		return $this->db->get('average_division');
	}    
    
    
    public function get_div_global_average($class_id = "", $section_id = "", $exam_id = "") {
            $checker = array(
                'class_id' => $class_id,
                'section_id' => $section_id,
                'exam_id' => $exam_id,
                'school_id' => $this->school_id,
                'session' => $this->active_session
            );
        $this->db->order_by("average", "desc");
		$this->db->where($checker);
		return $this->db->get('average_division');
	}
    
    public function get_session_average($class_id = "", $section_id = "", $exam_id = "", $student_id = "") {
            $checker = array(
                'class_id' => $class_id,
                'section_id' => $section_id,
                'student_id' => $student_id,
                'school_id' => $this->school_id,
                'session' => $this->active_session
            );
		$this->db->where($checker);
		return $this->db->get('average_session');
	}  
    
    public function get_session_global_average($class_id = "", $section_id = "", $exam_id = "") {
            $checker = array(
                'class_id' => $class_id,
                'section_id' => $section_id,
                'school_id' => $this->school_id,
                'session' => $this->active_session
            );
        $this->db->order_by("average", "desc");
		$this->db->where($checker);
		return $this->db->get('average_session');
	}
    
    //START STUDENT MARKS AVERAGE selection
	public function get_subject_average($class_id = "", $section_id = "", $subject_id = "", $exam_id = "", $student_id = "") {
            $checker = array(
                'class_id' => $class_id,
                'section_id' => $section_id,
                'subject_id' => $subject_id,
                'exam_id' => $exam_id,
                'student_id' => $student_id,
                'school_id' => $this->school_id,
                'session' => $this->active_session
            );
		$this->db->where($checker);
		return $this->db->get('average_subject');
	}
    
	public function get_subject_global_average($class_id = "", $section_id = "", $subject_id = "", $student_id = "") {
            $checker = array(
                'class_id' => $class_id,
                'section_id' => $section_id,
                'subject_id' => $subject_id,
                'student_id' => $student_id,
                'school_id' => $this->school_id,
                'session' => $this->active_session
            );
		$this->db->where($checker);
		return $this->db->get('average_global_subject');
	}
    
    public function get_idmarks_average($class_id = "", $section_id = "", $subject_id = "", $exam_id = "", $student_id = "") {
            $checker = array(
                'class_id' => $class_id,
                'section_id' => $section_id,
                'subject_id' => $subject_id,
                'exam_id' => $exam_id,
                'student_id' => $student_id,
                'school_id' => $this->school_id,
                'session' => $this->active_session
            );
		$this->db->where($checker);
		return $this->db->get('marks')->row()->id;
	}	
    
    public function get_bmarks_average($behavior_id = "", $mark_id = "") {
            $checker = array(
                'mark_id' => $mark_id,
                'behavior_option_id' => $behavior_id
            );
		$this->db->where($checker);
        $n =$this->db->get('mark_option')->row()->mark_obtained;
		return (ROUND($n, 2));
	}	
    
    public function get_discipline($class_id = "", $section_id = "", $exam_id = "") {
		$checker = array(
			'class_id' => $class_id,
			'section_id' => $section_id,
			'exam_id' => $exam_id,
			'school_id' => $this->school_id,
			'session' => $this->active_session
		);
        $this->db->order_by("name", "asc");
		$this->db->where($checker);
		return $this->db->get('discipline');
	}
    
	public function discipline_insert($class_id = "", $section_id = "", $exam_id = "") {
		$student_enrolments = $this->user_model->student_enrolment($section_id)->result_array();
        
		foreach ($student_enrolments as $student_enrolment) {
			$checker = array(
				'student_id' => $student_enrolment['student_id'],
				'class_id' => $class_id,
				'section_id' => $section_id,
				'exam_id' => $exam_id,
				'school_id' => $this->school_id,
				'session' => $this->active_session
			);
			$this->db->where($checker);
			$number_of_rows = $this->db->get('discipline')->num_rows();
			if($number_of_rows == 0) {
                $us =$this->db->get_where('students', array('id' => $student_enrolment['student_id']))->row()->user_id;
                
                $n=$this->user_model->get_user_details($us, 'name');
                $checkers = array(
                    'student_id' => $student_enrolment['student_id'],
                    'class_id' => $class_id,
                    'section_id' => $section_id,
                    'exam_id' => $exam_id,
                    'name' => $n,
                    'school_id' => $this->school_id,
                    'session' => $this->active_session
                );
				$this->db->insert('discipline', $checkers);
                $insert_id = $this->db->insert_id();
                
                //Insert mark options 
                $bids=$this->db->get_where('discipline_option', array('school_id' => $this->school_id, 'session' => $this->active_session))->result_array();
                  foreach($bids as $bi){
                     $data['discipline_id'] = $insert_id;
                     $data['option_id'] = $bi['id'];
				     $this->db->insert('discipline_data', $data);
                  }
			}
		}
	}
 
	public function discipline_update_all(){
		$data['class_id'] = html_escape($this->input->post('class_id'));
		$data['section_id'] = html_escape($this->input->post('section_id'));
		$data['exam_id'] = html_escape($this->input->post('exam_id'));
		$data['school_id'] = $this->school_id;
		$data['session'] = $this->active_session;
        
        $student_enrolments = $this->user_model->student_enrolment($data['section_id'])->result_array();
        
		foreach ($student_enrolments as $student_enrolment) {
        $data['student_id'] = $student_enrolment['student_id'];   
            
		$query = $this->db->get_where('discipline', array('student_id' => $data['student_id'], 'class_id' => $data['class_id'], 'section_id' => $data['section_id'], 'exam_id' => $data['exam_id'], 'session' => $data['session'], 'school_id' => $data['school_id']));
        $row = $query->row();
        
        $bids=$this->db->get_where('discipline_option', array('school_id' => $this->school_id, 'session' => $this->active_session))->result_array();
        
        foreach($bids as $bi){
             $obtained_marks = html_escape($this->input->post('mark_'.$data['student_id'].'_'.$bi['id'])); 
             $quer = $this->db->get_where('discipline_data', array('discipline_id'=>$row->id, 'option_id'=> $bi['id']));
             if($quer->num_rows() > 0){
                 $this->db->where('discipline_id' , $row->id);
                 $this->db->where('option_id' , $bi['id']);
                 $this->db->update('discipline_data' , array('mark_obtained' => $obtained_marks));
             }else{
                 $dat['discipline_id'] = $row->id;
                 $dat['option_id'] = $bi['id'];
                 $dat['mark_obtained'] = $obtained_marks;
				 $this->db->insert('discipline_data', $dat);
             }
          }
          }
        
	}
    
	public function disciplines_update(){
		$data['student_id'] = html_escape($this->input->post('student_id'));
		$data['class_id'] = html_escape($this->input->post('class_id'));
		$data['section_id'] = html_escape($this->input->post('section_id'));
		$data['exam_id'] = html_escape($this->input->post('exam_id'));
		$data['school_id'] = $this->school_id;
		$data['session'] = $this->active_session;
        
		$query = $this->db->get_where('discipline', array('student_id' => $data['student_id'], 'class_id' => $data['class_id'], 'section_id' => $data['section_id'], 'exam_id' => $data['exam_id'], 'session' => $data['session'], 'school_id' => $data['school_id']));
        $row = $query->row();
        
        $bids=$this->db->get_where('discipline_option', array('school_id' => $this->school_id, 'session' => $this->active_session))->result_array();
        
        foreach($bids as $bi){
             $obtained_marks = html_escape($this->input->post('mark'.$bi['id']));
            
             $quer = $this->db->get_where('discipline_data', array('discipline_id'=>$row->id, 'option_id'=> $bi['id']));
             if($quer->num_rows() > 0){
                 $this->db->where('discipline_id' , $row->id);
                 $this->db->where('option_id' , $bi['id']);
                 $this->db->update('discipline_data' , array('mark_obtained' => $obtained_marks));
             }else{
                 $dat['discipline_id'] = $row->id;
                 $dat['option_id'] = $bi['id'];
                 $dat['mark_obtained'] = $obtained_marks;
				 $this->db->insert('discipline_data', $dat);
             }
          }
        
	}
   
    public function mark_insert($class_id = "", $section_id = "", $subject_id = "", $exam_id = "") {
        
       
        $eid =$this->db->get_where('exam_option', array('id' => $exam_id))->row()->exam_id;
        
		$student_enrolments = $this->db->get_where('enrols', array('class_id' => $class_id,'section_id' => $section_id, 'school_id' => $this->school_id, 'session' => $this->active_session))->result_array();
        
		foreach ($student_enrolments as $student_enrolment) {
			$checker = array(
				'student_id' => $student_enrolment['student_id'],
				'class_id' => $class_id,
				'section_id' => $section_id,
				'subject_id' => $subject_id,
				'exam_id' => $exam_id,
				'school_id' => $this->school_id,
				'session' => $this->active_session
			);
			$this->db->where($checker);
			$rows = $this->db->get('marks');
			$number_of_rows = $rows->num_rows();
            
            $us =$this->db->get_where('students', array('id' => $student_enrolment['student_id']))->row()->user_id;
            $n=$this->user_model->get_user_details($us, 'name'); 
            
			if($number_of_rows == 0) {
                
                //Insert marks
                $this->i_marks($student_enrolment['student_id'], $n, $class_id, $section_id, $exam_id, $subject_id);
                
                //Insert subject average
                $checkerdiv1 = array(
                    'student_id' => $student_enrolment['student_id'],
                    'class_id' => $class_id,
                    'section_id' => $section_id,
                    'subject_id' => $subject_id,
                    'exam_id' => $eid,
                    'school_id' => $this->school_id,
                    'session' => $this->active_session
                );
                $checkerdivi1 = array(
                    'student_id' => $student_enrolment['student_id'],
                    'class_id' => $class_id,
                    'section_id' => $section_id,
                    'subject_id' => $subject_id,
                    'exam_id' => $eid,
                    'name' => $n,
                    'school_id' => $this->school_id,
                    'session' => $this->active_session
                );
        
                $this->db->where($checkerdiv1);
			    $rowss = $this->db->get('average_subject');
                if($rowss->num_rows() == 0) {
                  $this->db->insert('average_subject', $checkerdivi1);
                }
                
                //Insert subject global average
                $checkerdiv2 = array(
                    'student_id' => $student_enrolment['student_id'],
                    'class_id' => $class_id,
                    'section_id' => $section_id,
                    'subject_id' => $subject_id,
                    'school_id' => $this->school_id,
                    'session' => $this->active_session
                );
                $checkerdivi2 = array(
                    'student_id' => $student_enrolment['student_id'],
                    'class_id' => $class_id,
                    'section_id' => $section_id,
                    'subject_id' => $subject_id,
                    'name' => $n,
                    'school_id' => $this->school_id,
                    'session' => $this->active_session
                );
                $this->db->where($checkerdiv2);
			    $rowss = $this->db->get('average_global_subject');
                if($rowss->num_rows() == 0) {
                  $this->db->insert('average_global_subject', $checkerdivi2);
                }
                
                //Insert subdivision average
                $checkerdiv3 = array(
                    'student_id' => $student_enrolment['student_id'],
                    'class_id' => $class_id,
                    'section_id' => $section_id,
                    'exam_option_id' => $exam_id,
                    'school_id' => $this->school_id,
                    'session' => $this->active_session
                );
                $checkerdivi3 = array(
                    'student_id' => $student_enrolment['student_id'],
                    'class_id' => $class_id,
                    'section_id' => $section_id,
                    'exam_option_id' => $exam_id,
                    'name' => $n,
                    'school_id' => $this->school_id,
                    'session' => $this->active_session
                );
                $this->db->where($checkerdiv3);
			    $rowss = $this->db->get('average_subdivision');
                if($rowss->num_rows() == 0) {
                  $this->db->insert('average_subdivision', $checkerdivi3);
                }
                    
                //Insert division average
                $checkerdiv3 = array(
                    'student_id' => $student_enrolment['student_id'],
                    'class_id' => $class_id,
                    'section_id' => $section_id,
                    'exam_id' => $eid,
                    'school_id' => $this->school_id,
                    'session' => $this->active_session
                );
                $checkerdivi3 = array(
                    'student_id' => $student_enrolment['student_id'],
                    'class_id' => $class_id,
                    'section_id' => $section_id,
                    'exam_id' => $eid,
                    'name' => $n,
                    'school_id' => $this->school_id,
                    'session' => $this->active_session
                );
                $this->db->where($checkerdiv3);
			    $rowss = $this->db->get('average_division');
                if($rowss->num_rows() == 0) {
                  $this->db->insert('average_division', $checkerdivi3);
                }
                
                //Insert year or session average
                $checkerses= array(
                    'student_id' => $student_enrolment['student_id'],
                    'class_id' => $class_id,
                    'section_id' => $section_id,
                    'school_id' => $this->school_id,
                    'session' => $this->active_session
                );
                $checkersesi= array(
                    'student_id' => $student_enrolment['student_id'],
                    'class_id' => $class_id,
                    'section_id' => $section_id,
                    'name' => $n,
                    'school_id' => $this->school_id,
                    'session' => $this->active_session
                );
                
                $this->db->where($checkerses);
			    $rowss = $this->db->get('average_session');
                if($rowss->num_rows() == 0) {
                  $this->db->insert('average_session', $checkersesi);
                }
			}
            else{
                
                $mid = $this->db->get_where('marks', array(
                    'student_id' => $student_id,
                    'class_id' => $class_id,
                    'section_id' => $section_id,
                    'subject_id' => $subject_id,
                    'exam_id' => $exam_id,
                    'school_id' => $this->school_id,
                    'session' => $this->active_session
                ))->row()->id;
        
                $bid=$this->db->get_where('subjects', array('id' => $subject_id))->row('behavior');
                $bids=$this->db->get_where('mark_behavior_option', array('mark_behavior_id' => $bid))->result_array();
                  foreach($bids as $bi){
                     $if = $this->db->get_where('mark_option', array('mark_id' => $mid, 'behavior_option_id'=> $bi['id']))->num_rows();

                      if($if == 0){
                          $data['mark_id'] = $mid;
                          $data['behavior_option_id'] = $bi['id'];
                          $this->db->insert('mark_option', $data);
                      }
                  }
                 //Insert subject average
                $checkerdiv = array(
                    'student_id' => $student_enrolment['student_id'],
                    'class_id' => $class_id,
                    'section_id' => $section_id,
                    'subject_id' => $subject_id,
                    'exam_id' => $eid,
                    'school_id' => $this->school_id,
                    'session' => $this->active_session
                );
                $checkerdivi = array(
                    'student_id' => $student_enrolment['student_id'],
                    'class_id' => $class_id,
                    'section_id' => $section_id,
                    'subject_id' => $subject_id,
                    'exam_id' => $eid,
                    'name' => $n,
                    'school_id' => $this->school_id,
                    'session' => $this->active_session
                );
        
                $this->db->where($checkerdiv);
			    $rowss = $this->db->get('average_subject');
                if($rowss->num_rows() == 0) {
                  $this->db->insert('average_subject', $checkerdivi);
                }
                
                //Insert subject global average
                $checkerdiv1 = array(
                    'student_id' => $student_enrolment['student_id'],
                    'class_id' => $class_id,
                    'section_id' => $section_id,
                    'subject_id' => $subject_id,
                    'school_id' => $this->school_id,
                    'session' => $this->active_session
                );
                $checkerdivi1 = array(
                    'student_id' => $student_enrolment['student_id'],
                    'class_id' => $class_id,
                    'section_id' => $section_id,
                    'subject_id' => $subject_id,
                    'name' => $n,
                    'school_id' => $this->school_id,
                    'session' => $this->active_session
                );
                $this->db->where($checkerdiv1);
			    $rowss = $this->db->get('average_global_subject');
                if($rowss->num_rows() == 0) {
                  $this->db->insert('average_global_subject', $checkerdivi1);
                }
                
                //Insert subdivision average
                $checkerdiv2 = array(
                    'student_id' => $student_enrolment['student_id'],
                    'class_id' => $class_id,
                    'section_id' => $section_id,
                    'exam_option_id' => $exam_id,
                    'school_id' => $this->school_id,
                    'session' => $this->active_session
                );
                $checkerdivi2 = array(
                    'student_id' => $student_enrolment['student_id'],
                    'class_id' => $class_id,
                    'section_id' => $section_id,
                    'exam_option_id' => $exam_id,
                    'name' => $n,
                    'school_id' => $this->school_id,
                    'session' => $this->active_session
                );
                $this->db->where($checkerdiv2);
			    $rowss = $this->db->get('average_subdivision');
                if($rowss->num_rows() == 0) {
                  $this->db->insert('average_subdivision', $checkerdivi2);
                }
                
                //Insert division average
                $checkerdiv3 = array(
                    'student_id' => $student_enrolment['student_id'],
                    'class_id' => $class_id,
                    'section_id' => $section_id,
                    'exam_id' => $eid,
                    'school_id' => $this->school_id,
                    'session' => $this->active_session
                );
                
                $checkerdivi3 = array(
                    'student_id' => $student_enrolment['student_id'],
                    'class_id' => $class_id,
                    'section_id' => $section_id,
                    'exam_id' => $eid,
                    'name' => $n,
                    'school_id' => $this->school_id,
                    'session' => $this->active_session
                );
                $this->db->where($checkerdiv3);
			    $rowss = $this->db->get('average_division');
                if($rowss->num_rows() == 0) {
                  $this->db->insert('average_division', $checkerdivi3);
                }
                
                //Insert year or session average
                $checkerses= array(
                    'student_id' => $student_enrolment['student_id'],
                    'class_id' => $class_id,
                    'section_id' => $section_id,
                    'school_id' => $this->school_id,
                    'session' => $this->active_session
                );
                //Insert year or session average
                $checkersess= array(
                    'student_id' => $student_enrolment['student_id'],
                    'class_id' => $class_id,
                    'section_id' => $section_id,
                    'name' => $n,
                    'school_id' => $this->school_id,
                    'session' => $this->active_session
                );
                
                $this->db->where($checkerses);
			    $rowss = $this->db->get('average_session');
                if($rowss->num_rows() == 0) {
                  $this->db->insert('average_session', $checkersess);
                }
                
            }
		    }
	} 
    
    
	public function mark_update(){
        
		$data['student_id'] = html_escape($this->input->post('student_id'));
		$data['class_id'] = html_escape($this->input->post('class_id'));
		$data['section_id'] = html_escape($this->input->post('section_id'));
		$data['subject_id'] = html_escape($this->input->post('subject_id'));
		$data['exam_id'] = html_escape($this->input->post('exam_id'));
		$data['comment'] = html_escape($this->input->post('comment'));
		$data['school_id'] = $this->school_id;
		$data['session'] = $this->active_session;
		$behav = html_escape($this->input->post('behavior'));
        
		$nrow = $this->db->get_where('marks', array('student_id' => $data['student_id'], 'class_id' => $data['class_id'], 'section_id' => $data['section_id'], 'subject_id' => $data['subject_id'], 'exam_id' => $data['exam_id'], 'session' => $data['session'], 'school_id' => $data['school_id']))->num_rows();
        
        $us =$this->db->get_where('students', array('id' => $data['student_id']))->row()->user_id;
        $n=$this->user_model->get_user_details($us, 'name');
        
        $co= $this->db->get_where('subjects', array('id' => $data['subject_id']))->row()->coef;
        $bid=$this->db->get_where('subjects', array('id' => $data['subject_id']))->row('behavior');
        $perc=$this->db->get_where('mark_behavior_option', array('id' => $behav))->row('percentage');
        $mo=0; $su=0;
        
        //update marks options
         $obtained_marks = html_escape($this->input->post('mark'));
         $percentage =  $perc;
         $total = $obtained_marks*$percentage/100;

         if($nrow < 1){
             $data['name']=$n;
             $this->db->insert('marks', $data);
             $insert_id = $this->db->insert_id();
        }
        
        $query = $this->db->get_where('marks', array('student_id' => $data['student_id'], 'class_id' => $data['class_id'], 'section_id' => $data['section_id'], 'subject_id' => $data['subject_id'], 'exam_id' => $data['exam_id'], 'session' => $data['session'], 'school_id' => $data['school_id']));
        $row = $query->row();
        
         $quer = $this->db->get_where('mark_option', array('mark_id'=>$row->id, 'behavior_option_id'=> $behav));
         $ncc = $quer->num_rows();
        
         if($ncc > 0){
             $this->db->where('mark_id' , $row->id);
             $this->db->where('behavior_option_id' , $behav);
             $this->db->update('mark_option' , array('mark_obtained' => $total , 'max_mark' => $percentage));
         }else{
             $daa['mark_id'] = $row->id;
             $daa['mark_obtained'] = $total;
             $daa['max_mark'] = $percentage;
             $daa['behavior_option_id'] = $behav;
             $this->db->insert('mark_option', $daa);
         }
        $bids=$this->db->get_where('mark_behavior_option', array('mark_behavior_id' => $bid))->result_array();
        foreach($bids as $bi){
            $obtained_marks = $this->db->get_where('mark_option', array('mark_id' => $row->id, 'behavior_option_id' => $bi['id']))->row('mark_obtained');
            $percentage =  $bi['percentage'];
            $total = $obtained_marks;
            $mo+=$total;
        }  
        //update subdivision marks
        
			$val = html_escape($this->input->post('comment'));
			// if the mark is justified or not applicable
			if($val == 1){
				$update_data['coef'] = 0;
				$update_data['mark_obtained'] = 0;
			}else{
				$update_data['coef'] = $co;
				$update_data['mark_obtained'] = $mo;
			}
			
			$update_data['name'] = $n;
			$update_data['comment'] = html_escape($this->input->post('comment'));
			$this->db->where('id', $row->id);
			$this->db->update('marks', $update_data);
        
        //update subject mark average for the division
        $eid =$this->db->get_where('exam_option', array('id' => $data['exam_id']))->row()->exam_id;
        $exs =$this->db->get_where('exam_option', array('exam_id' => $eid))->result_array();
        $coef = $this->db->get_where('subjects', array('id' => $data['subject_id']))->row()->coef;
        if($val ==1){
            $coef = 0;
        }else{
            $coef = $this->db->get_where('subjects', array('id' => $data['subject_id']))->row()->coef;
        }
        
        //calculate average of the subject
        $tmark = 0;
        $tex = 0;
        foreach($exs as $ex){
            $checker = array(
				'student_id' => $data['student_id'],
				'class_id' => $data['class_id'],
				'section_id' => $data['section_id'],
				'subject_id' => $data['subject_id'],
				'exam_id' => $ex['id'],
				'school_id' => $this->school_id,
				'session' => $this->active_session
			);
            
			$this->db->where($checker);
			$rows = $this->db->get('marks')->row();
            $c=$rows->coef;
            if($c > 0){
               $tex += 1; 
               $tmark += $rows->mark_obtained;
            }
        }
        
        if($tex < 1){
           $themo = $tmark; 
        }else{
          $themo = $tmark / $tex;
        }
        
        $exxr =$this->db->get_where('average_subject', array(
            'student_id' => $data['student_id'],
            'class_id' => $data['class_id'],
            'section_id' => $data['section_id'],
            'subject_id' => $data['subject_id'],
            'exam_id' => $eid,
            'school_id' => $this->school_id, 
            'session' => $this->active_session))->num_rows();  
        
        $checker = array(
            'student_id' => $data['student_id'],
            'class_id' => $data['class_id'],
            'section_id' => $data['section_id'],
            'subject_id' => $data['subject_id'],
            'exam_id' => $eid,
            'school_id' => $this->school_id,
            'session' => $this->active_session
        ); 
        
        $checkerins = array(
            'student_id' => $data['student_id'],
            'class_id' => $data['class_id'],
            'section_id' => $data['section_id'],
            'subject_id' => $data['subject_id'],
            'exam_id' => $eid,
            'school_id' => $this->school_id,
            'mark_obtained' => $themo , 
            'name' => $n , 
            'coef' => $coef,
            'session' => $this->active_session
        );
        if($exxr > 0){
            $this->db->where($checker);
            $this->db->update('average_subject' , array('mark_obtained' => $themo , 'name' => $n , 'coef' => $coef));
        }else{
           $this->db->insert('average_subject', $checkerins); 
        }
        
        $exx =$this->db->get_where('average_global_subject', array(
            'student_id' => $data['student_id'],
            'class_id' => $data['class_id'],
            'section_id' => $data['section_id'],
            'subject_id' => $data['subject_id'],
            'school_id' => $this->school_id, 
            'session' => $this->active_session))->num_rows();  
        $tmarkg = 0;
        $texg = 0;
        
        $exsy =$this->db->get_where('exams', array('session' => $this->active_session))->result_array();  
            foreach($exsy as $exsy){
                
            $exs =$this->db->get_where('exam_option', array('exam_id' => $exsy['id']))->result_array();
            foreach($exs as $ex){
                
            $checker = array(
                'student_id' => $data['student_id'],
                'class_id' => $data['class_id'],
                'section_id' => $data['section_id'],
                'subject_id' => $data['subject_id'],
                'exam_id' => $ex['id'],
                'school_id' => $this->school_id,
                'session' => $this->active_session
            );
            $this->db->where($checker);
            $rows = $this->db->get('marks')->row();
            $c=$rows->coef;
            if($c > 0){
               $texg += 1; 
               $tmarkg += $rows->mark_obtained;
            }
            }
        
        }

            if($texg < 1){
               $themog = 0; 
            }else{
              $themog= $tmarkg / $texg;
            }

            $checker = array(
                'student_id' => $data['student_id'],
                'class_id' => $data['class_id'],
                'section_id' => $data['section_id'],
                'subject_id' => $data['subject_id'],
                'school_id' => $this->school_id,
                'session' => $this->active_session
            );
            if($exx < 1){
                $dataa['mark_obtained']=$themog;
                $dataa['coef']=$c;
                $dataa['school_id']=$this->school_id;
                $dataa['session']=$this->active_session;
                $dataa['name']=$n;
                $this->db->insert('average_global_subject', $dataa);
                
            }else{
               $this->db->where($checker);
               $this->db->update('average_global_subject' , array('mark_obtained' => $themog , 'name' => $n , 'coef' => $coef)); 
                
            }
        $this->single_subdiv_average_update($data['student_id'],$data['class_id'], $data['section_id'], $data['exam_id']);
        $this->single_div_average_update($data['student_id'],$data['class_id'], $data['section_id'], $eid);
        $this->single_session_average_update($data['student_id'],$data['class_id'], $data['section_id']);
	}

  
	
    public function marksheet_insert($class_id = "", $section_id = "", $subject_id = "", $exam_id = "") {
        
        $eid =$this->db->get_where('exam_option', array('id' => $exam_id))->row()->exam_id;
        
		$student_enrolments = $this->db->get_where('enrols', array('class_id' => $class_id,'section_id' => $section_id, 'school_id' => $this->school_id, 'session' => $this->active_session))->result_array();
        
		foreach ($student_enrolments as $student_enrolment) {
                //Insert marks
                $this->i_marks($student_enrolment['student_id'], $n, $class_id, $section_id, $exam_id, $subject_id);
                
                //Insert subject average
                $this->up_s_average($student_enrolment['student_id'], $n, $class_id, $section_id, $eid, $subject_id);
                
                //Insert subject global average
                $this->up_gs_average($student_enrolment['student_id'], $n, $class_id, $section_id, $subject_id);
                
                //Insert subdivision average
                $this->up_subdivision_average($student_enrolment['student_id'], $n, $class_id, $section_id, $exam_id);
                //Insert division average
                $this->up_division_average($student_enrolment['student_id'], $n, $class_id, $section_id, $eid);
                
                //Insert year or session average
                $this->up_session_average($student_enrolment['student_id'], $n, $class_id, $section_id);
		    }
	} 
	
    public function up_m($student_id = "", $class_id = "", $section_id = "", $subject_id = "", $exam_id = "") {
        
        $mid = $this->db->get_where('marks', array(
                    'student_id' => $student_id,
                    'class_id' => $class_id,
                    'section_id' => $section_id,
                    'subject_id' => $subject_id,
                    'exam_id' => $exam_id,
                    'school_id' => $this->school_id,
                    'session' => $this->active_session
                ))->row()->id;
        
        $bid=$this->db->get_where('subjects', array('id' => $subject_id))->row('behavior');
        $bids=$this->db->get_where('mark_behavior_option', array('mark_behavior_id' => $bid))->result_array();
          foreach($bids as $bi){
             $if = $this->db->get_where('mark_option', array('mark_id' => $mid, 'behavior_option_id'=> $bi['id']))->num_rows();

              if($if == 0){
                  $data['mark_id'] = $mid;
                  $data['behavior_option_id'] = $bi['id'];
                  $this->db->insert('mark_option', $data);
              }
          }
    }     
    
    public function i_marks($student_id = "",$n = "", $class_id = "", $section_id = "", $exam_id = "", $subject_id = "") {
             $checkers = array(
                    'student_id' => $student_id,
                    'class_id' => $class_id,
                    'section_id' => $section_id,
                    'subject_id' => $subject_id,
                    'exam_id' => $exam_id,
                    'name' => $n,
                    'school_id' => $this->school_id,
                    'session' => $this->active_session
                );
				$this->db->insert('marks', $checkers);
                $insert_id = $this->db->insert_id();
                
                //Insert mark options 
                $bid=$this->db->get_where('subjects', array('id' => $subject_id))->row('behavior');
                $bids=$this->db->get_where('mark_behavior_option', array('mark_behavior_id' => $bid))->result_array();
                
                  foreach($bids as $bi){
                     $data['mark_id'] = $insert_id;
                     $data['behavior_option_id'] = $bi['id'];
				     $this->db->insert('mark_option', $data);
                  }
        
    } 
	
    public function up_s_average($student_id = "",$n = "", $class_id = "", $section_id = "", $eid = "", $subject_id = "") {
              
                $checkerdivi = array(
                    'student_id' => $student_id,
                    'class_id' => $class_id,
                    'section_id' => $section_id,
                    'subject_id' => $subject_id,
                    'name' => $n,
                    'school_id' => $this->school_id,
                    'session' => $this->active_session
                );
        
//                $this->db->where($checkerdiv);
//			    $rows = $this->db->get('average_global_subject');
//                $number_of_rows = $rows->num_rows();
                //if($number_of_rows == 0) {
                  $this->db->insert('average_subject', $checkerdivi);
                //}
        
    } 
	
    public function up_gs_average($student_id = "",$n = "", $class_id = "", $section_id = "", $subject_id = "") {
                $checkerdiv = array(
                    'student_id' => $student_id,
                    'class_id' => $class_id,
                    'section_id' => $section_id,
                    'subject_id' => $subject_id,
                    'name' => $n,
                    'school_id' => $this->school_id,
                    'session' => $this->active_session
                );
//                $this->db->where($checkerdiv);
//			    $rows = $this->db->get('average_global_subject');
//                $number_of_rows = $rows->num_rows();
//                if($number_of_rows == 0) {
                  $this->db->insert('average_global_subject', $checkerdiv);
//                }
        
    } 
    
    public function up_subdivision_average($student_id = "",$n = "", $class_id = "", $section_id = "", $eid = "") {
                $checkerdiv = array(
                    'student_id' => $student_id,
                    'class_id' => $class_id,
                    'section_id' => $section_id,
                    'exam_option_id' => $eid,
                    'name' => $n,
                    'school_id' => $this->school_id,
                    'session' => $this->active_session
                );
//                $this->db->where($checkerdiv);
//			    $rows = $this->db->get('average_subdivision');
//                $number_of_rows = $rows->num_rows();
//                if($number_of_rows == 0) {
                  $this->db->insert('average_subdivision', $checkerdiv);
//                }
        
    } 
    
    public function up_division_average($student_id = "",$n = "", $class_id = "", $section_id = "", $exam_id = "") {
                $checkerdiv = array(
                    'student_id' => $student_id,
                    'class_id' => $class_id,
                    'section_id' => $section_id,
                    'exam_id' => $exam_id,
                    'name' => $n,
                    'school_id' => $this->school_id,
                    'session' => $this->active_session
                );
//                $this->db->where($checkerdiv);
//			    $rows = $this->db->get('average_division');
//                $number_of_rows = $rows->num_rows();
//                if($number_of_rows == 0) {
                  $this->db->insert('average_division', $checkerdiv);
//                }
        
    } 
    
    public function up_session_average($student_id = "",$n = "", $class_id = "", $section_id = "") {
                $checkerses= array(
                    'student_id' => $student_id,
                    'class_id' => $class_id,
                    'section_id' => $section_id,
                    'name' => $n,
                    'school_id' => $this->school_id,
                    'session' => $this->active_session
                );
                
//                $this->db->where($checkerses);
//			    $rows = $this->db->get('average_session');
//                $number_of_rows = $rows->num_rows();
//                if($number_of_rows == 0) {
                  $this->db->insert('average_session', $checkerses);
//                }
        
    }
        
        
    public function mark_inserts($class_id = "", $section_id = "", $subject_id = "", $exam_id = "") {
        
        
		$student_enrolments = $this->db->get_where('enrols', array('school_id' => $this->school_id, 'session' => $this->active_session))->result_array();
        
		foreach ($student_enrolments as $student_enrolment) {
			$checker = array(
				'student_id' => $student_enrolment['student_id'],
				'school_id' => $this->school_id,
				'session' => $this->active_session
			);
			$this->db->where($checker);
			$rows = $this->db->get('marks');
			$number_of_rows = $rows->num_rows();
            
            $us =$this->db->get_where('students', array('id' => $student_enrolment['student_id']))->row()->user_id;
            $n=$this->user_model->get_user_details($us, 'name');
                
                
                //Insert subdivision average
                $checkersub = array(
                    'student_id' => $student_enrolment['student_id'],
                    'school_id' => $this->school_id,
                    'session' => $this->active_session
                );
                $this->db->where($checkersub);
			    $rows = $this->db->get('average_subdivision');
                $number_of_rows = $rows->num_rows();
                if($number_of_rows == 0) {
                  $this->db->insert('average_subdivision', $checkeraa);
                }else{
                   $this->db->update('average_subdivision', array('name' => $n));
                }
                
                //Insert division average
                $checkerdiv = array(
                    'student_id' => $student_enrolment['student_id'],
                    'school_id' => $this->school_id,
                    'session' => $this->active_session
                );
                $this->db->where($checkerdiv);
			    $rows = $this->db->get('average_division');
                $number_of_rows = $rows->num_rows();
                if($number_of_rows == 0) {
                  $this->db->insert('average_division', $checkerdiv);
                }else{
                   $this->db->update('average_division', array('name' => $n));
                }
                
                //Insert year or session average
                $checkerses= array(
                    'student_id' => $student_enrolment['student_id'],
                    'school_id' => $this->school_id,
                    'session' => $this->active_session
                );
                
                $this->db->where($checkerses);
			    $rows = $this->db->get('average_session');
                $number_of_rows = $rows->num_rows();
                if($number_of_rows == 0) {
                  $this->db->insert('average_session', $checkerses);
                }else{
                   $this->db->update('average_session', array('name' => $n));
                }
                
		    }
	} 
	

   
	public function mark_updates(){
        
//		$data['student_id'] = html_escape($this->input->post('student_id'));
		$data['class_id'] = html_escape($this->input->post('class_id'));
		$data['section_id'] = html_escape($this->input->post('section_id'));
        
        //calculate the global average of the subject
        
        $student_enrolments = $this->db->get_where('enrols', 
                           array('class_id' => $data['class_id'],
                                 'section_id' => $data['section_id'], 
                                 'school_id' => $this->school_id, 
                                 'session' => $this->active_session))->result_array();
        
        $suub = $this->db->get_where('subjects', 
                            array('class_id' => $data['class_id'],
                                  'section_id' => $data['section_id'], 
                                  'school_id' => $this->school_id, 
                                  'session' => $this->active_session))->result_array();
        
		foreach ($suub as $suub) {
		foreach ($student_enrolments as $student_enrolment) {
            
        $data['student_id'] = $student_enrolment['student_id'];    
        $data['subject_id'] = $suub['id'];  
        $coef= $suub['coef'];
            
        $us =$this->db->get_where('students', array('id' => $data['student_id']))->row()->user_id;
        $n=$this->user_model->get_user_details($us, 'name');
            
        $tmarkg = 0;
        $texg = 0;
            
        $exx =$this->db->get_where('average_global_subject', 
                            array('student_id' => $data['student_id'],
                            'class_id' => $data['class_id'],
                            'section_id' => $data['section_id'],
                            'subject_id' => $data['subject_id'],
                            'school_id' => $this->school_id, 
                            'session' => $this->active_session))->num_rows();  
            
            $exsy =$this->db->get_where('exams', array('session' => $this->active_session))->result_array();  
            foreach($exsy as $exsy){ 
              $exs =$this->db->get_where('exam_option', array('exam_id' => $exsy['id']))->result_array();
               foreach($exs as $eidg){
                $exs =$this->db->get_where('exam_option', array('exam_id' => $eidg['id']))->result_array();
                foreach($exs as $ex){
                    $checker = array(
                        'student_id' => $data['student_id'],
                        'class_id' => $data['class_id'],
                        'section_id' => $data['section_id'],
                        'subject_id' => $data['subject_id'],
                        'exam_id' => $ex['id'],
                        'school_id' => $this->school_id,
                        'session' => $this->active_session
                    );
                    $this->db->where($checker);
                    $rows = $this->db->get('marks')->row();
                    $c=$rows->coef;
                    
                    if($c > 0){
                       $texg += 1; 
                       $tmarkg += $rows->mark_obtained;
                    }
                }
                }
            }

            if($texg < 1){
               $themog = $tmarkg; 
            }else{
              $themog= $tmarkg / $texg;
            }

            $checker = array(
                'student_id' => $data['student_id'],
                'class_id' => $data['class_id'],
                'section_id' => $data['section_id'],
                'subject_id' => $data['subject_id'],
                'school_id' => $this->school_id,
                'session' => $this->active_session
            );
            if($exx < 1){
                $data['mark_obtained']=$themog;
                $data['coef']=$coef;
                $data['school_id']=$this->school_id;
                $data['session']=$this->active_session;
                $data['name']=$n;
                $this->db->insert('average_global_subject', $data);
            }else{
               $this->db->where($checker);
               $this->db->update('average_global_subject' , array('mark_obtained' => $themog , 'name' => $n , 'coef' => $coef)); 
            }
	    }
	    }
	}
     
	public function mark_eupdates(){
        
        $student_enrolments = $this->db->get_where('enrols', 
                           array('school_id' => $this->school_id, 
                                 'session' => $this->active_session))->result_array();
        
		foreach ($student_enrolments as $student_enrolment) {
           
        $us =$this->db->get_where('students', array('id' => $student_enrolment['student_id']))->row()->user_id;
        $n=$this->user_model->get_user_details($us, 'name');
            

            $checker = array(
                'id' => $student_enrolment['student_id']
            );
            
               $this->db->where($checker);
               $this->db->update('enrols' , array('name' => $n )); 
            }
	    
	}
     

	public function average_updateg(){
        
		$class_id  = html_escape($this->input->post('class_id'));
		$exam = html_escape($this->input->post('exam'));
		$exam_id = html_escape($this->input->post('exam_id'));
		$section_id = html_escape($this->input->post('section_id')); 
        
        if($exam > 0){
           $n = $this->db->get_where('general_exam_option_average', array('class_id' => $class_id,'section_id' => $section_id, 'school_id' => $this->school_id, 'session' => $this->active_session, 'exam_option_id' => $exam))->num_rows();
           
               $avsub = $this->db->get_where('average_subdivision', array('class_id' => $class_id,'section_id' => $section_id, 'school_id' => $this->school_id, 'session' => $this->active_session,  'exam_option_id' => $exam))->result_array();
               
               $ts =0;$ta =0;
               foreach ($avsub as $avsu) {
                   if($avsu['total_coef'] > 0){
                       $ta += $avsu['average'];
                       $ts += 1;
                   }
                }
            
                $av = $ta / $ts;
            if($n > 0){      
                $checker = array(
                'class_id' => $class_id,
                'section_id' => $section_id,
                'exam_option_id' => $exam,
                'school_id' => $this->school_id,
                'session' => $this->active_session
                );
                $this->db->where($checker);
                $this->db->update('general_exam_option_average' , array('total_student' => $ts ,'total_average' => $ta ,'average' => $av));
            }else{
                $data['class_id'] = $class_id;
                $data['section_id'] = $section_id;
                $data['exam_option_id'] = $exam;
                $data['school_id'] = $this->school_id;
                $data['session'] = $this->active_session;
                $data['total_student'] = $ts;
                $data['total_average'] = $ta;
                $data['average'] = $av;
                $this->db->insert('general_exam_option_average', $data);
            }
    
        }
        elseif($exam_id > 0){
            
           $n = $this->db->get_where('general_exam_average', array('class_id' => $class_id,'section_id' => $section_id, 'school_id' => $this->school_id, 'session' => $this->active_session, 'exam_id' => $exam_id))->num_rows();
           
            $avsub = $this->db->get_where('average_division', array('class_id' => $class_id,'section_id' => $section_id, 'school_id' => $this->school_id, 'session' => $this->active_session, 'exam_id' => $exam_id))->result_array();
               
               $ts =0;$ta =0;
               foreach ($avsub as $avsu) {
                   if($avsu['total_coef'] > 0){
                       $ta += $avsu['average'];
                       $ts += 1;
                   }
                }
                $av = $ta / $ts;
            
            if($n > 0){      
                $checker = array(
                'class_id' => $class_id,
                'section_id' => $section_id,
                'exam_id' => $exam_id,
                'school_id' => $this->school_id,
                'session' => $this->active_session
                );
                $this->db->where($checker);
                $this->db->update('general_exam_average' , array('total_student' => $ts ,'total_average' => $ta ,'average' => $av));
            }else{
                $data['class_id'] = $class_id;
                $data['section_id'] = $section_id;
                $data['exam_id'] = $exam_id;
                $data['school_id'] = $this->school_id;
                $data['session'] = $this->active_session;
                $data['total_student'] = $ts;
                $data['total_average'] = $ta;
                $data['average'] = $av;
                $this->db->insert('general_exam_average', $data);
            }
            
            $term = $this->db->get_where('exam_option', array('exam_id' => $exam_id))->result_array();
            foreach ($term as $t) {
                $n = $this->db->get_where('general_exam_option_average', array('class_id' => $class_id,'section_id' => $section_id, 'school_id' => $this->school_id, 'session' => $this->active_session, 'exam_option_id' => $t['id']))->num_rows();
           
               $avsub = $this->db->get_where('average_subdivision', array('class_id' => $class_id,'section_id' => $section_id, 'school_id' => $this->school_id, 'session' => $this->active_session,  'exam_option_id' => $t['id']))->result_array();
               
               $ts =0;$ta =0;
               foreach ($avsub as $avsu) {
                   if($avsu['total_coef'] > 0){
                       $ta += $avsu['average'];
                       $ts += 1;
                   }
                }
            
                $av = $ta / $ts;
            if($n > 0){      
                $checker = array(
                'class_id' => $class_id,
                'section_id' => $section_id,
                'exam_option_id' => $t['id'],
                'school_id' => $this->school_id,
                'session' => $this->active_session
                );
                $this->db->where($checker);
                $this->db->update('general_exam_option_average' , array('total_student' => $ts ,'total_average' => $ta ,'average' => $av));
            }else{
                $data['class_id'] = $class_id;
                $data['section_id'] = $section_id;
                $data['exam_option_id'] = $t['id'];
                $data['school_id'] = $this->school_id;
                $data['session'] = $this->active_session;
                $data['total_student'] = $ts;
                $data['total_average'] = $ta;
                $data['average'] = $av;
                $this->db->insert('general_exam_option_average', $data);
            }
                
            }
            
        }
        
        elseif($exam_id==0 && $exam==0){
             
           $n = $this->db->get_where('general_average', array('class_id' => $class_id,'section_id' => $section_id, 'school_id' => $this->school_id, 'session' => $this->active_session))->num_rows();
           
            $avsub = $this->db->get_where('average_session', array('class_id' => $class_id,'section_id' => $section_id, 'school_id' => $this->school_id, 'session' => $this->active_session))->result_array();
               
               $ts =0;$ta =0;
               foreach ($avsub as $avsu) {
                   if($avsu['total_coef'] > 0){
                       $ta += $avsu['average'];
                       $ts += 1;
                   }
                }
                $av = $ta / $ts;
            if($n > 0){      
                $checker = array(
                'class_id' => $class_id,
                'section_id' => $section_id,
                'exam_id' => $exam_id,
                'school_id' => $this->school_id,
                'session' => $this->active_session
                );
                $this->db->where($checker);
                $this->db->update('general_exam_average' , array('total_student' => $ts ,'total_average' => $ta ,'average' => $av));
            }else{
                $data['class_id'] = $class_id;
                $data['section_id'] = $section_id;
                $data['exam_id'] = $exam_id;
                $data['school_id'] = $this->school_id;
                $data['session'] = $this->active_session;
                $data['total_student'] = $ts;
                $data['total_average'] = $ta;
                $data['average'] = $av;
                $this->db->insert('general_exam_average', $data);
            }
            
        }
        
	}
    
    public function single_subdiv_average_update($student_id = "",$class_id = "", $section_id = "", $exam = ""){
        
        $tsg=0; $tavg=0; $avg=0;
        
        $student_enrolment['student_id']=$student_id;
               
               $avsub = $this->db->get_where('marks', array('class_id' => $class_id,'section_id' => $section_id, 'school_id' => $this->school_id, 'session' => $this->active_session, 'exam_id' => $exam, 'student_id' =>$student_enrolment['student_id']))->result_array();
               $tm =0;$tc =0;
               foreach ($avsub as $avsu) {
				   $nsub = $this->db->get_where('subjects', array('id' => $avsu['subject_id']))->num_rows();
                   if(($avsu['coef'] > 0) && ($nsub > 0)){
                       $tm += $avsu['mark_obtained']*$avsu['coef'];
                       $tc += $avsu['coef'];
                   }
                   if($tc > 0){
                       $av = $tm / $tc;
                   }else{
                       $av =0;
                   }
                   
                   
            $checkerins = array(
                'student_id' => $student_enrolment['student_id'],
                'class_id' => $class_id,
                'section_id' => $section_id,
                'exam_option_id' => $exam,
                'school_id' => $this->school_id,
                'session' => $this->active_session,
                'total_mark' => $tm ,
                'total_coef' => $tc ,
                'average' => $av,
            );    
                   
            $checker = array(
                'student_id' => $student_enrolment['student_id'],
                'class_id' => $class_id,
                'section_id' => $section_id,
                'exam_option_id' => $exam,
                'school_id' => $this->school_id,
                'session' => $this->active_session
            );
                   
            $exx =$this->db->get_where('average_subdivision', array(
                'student_id' => $student_enrolment['student_id'],
                'class_id' => $class_id,
                'section_id' => $section_id,
                'exam_option_id' => $exam,
                'school_id' => $this->school_id,
                'session' => $this->active_session))->num_rows(); 
             
            if($exx > 0){
                $this->db->where($checker);
                $this->db->update('average_subdivision' , array('total_mark' => $tm ,'total_coef' => $tc ,'average' => $av));
            }else{
               $this->db->insert('average_subdivision', $checkerins); 
            }
               
            }
               //general average
               if($av > 0){
                   $tsg +=1;
                   $tavg += $av;
                   $avg = $tavg / $tsg;
               }
                
        //calculate general average of the class
          $n = $this->db->get_where('general_exam_option_average', array('class_id' => $class_id,'section_id' => $section_id, 'school_id' => $this->school_id, 'session' => $this->active_session, 'exam_option_id' => $exam))->num_rows();
           if($n > 0){      
                $checker = array(
                'class_id' => $class_id,
                'section_id' => $section_id,
                'exam_option_id' => $exam,
                'school_id' => $this->school_id,
                'session' => $this->active_session
                );
                $this->db->where($checker);
                $this->db->update('general_exam_option_average' , array('total_student' => $tsg ,'total_average' => $tavg ,'average' => $avg));
            }else{
                $data['class_id'] = $class_id;
                $data['section_id'] = $section_id;
                $data['exam_option_id'] = $exam;
                $data['school_id'] = $this->school_id;
                $data['session'] = $this->active_session;
                $data['total_student'] = $tsg;
                $data['total_average'] = $tavg;
                $data['average'] = $avg;
                $this->db->insert('general_exam_option_average', $data);
            } 
    }
    
    public function single_div_average_update($student_id = "", $class_id = "", $section_id = "", $exam_id = ""){
        
        $tsg=0; $tavg=0; $avg=0;
        $student_enrolment['student_id']=$student_id;
               
               $avsub = $this->db->get_where('average_subject', array('class_id' => $class_id,'section_id' => $section_id, 'school_id' => $this->school_id, 'session' => $this->active_session, 'exam_id' => $exam_id, 'student_id' =>$student_enrolment['student_id']))->result_array();
               
               $tm =0;$tc =0;
               
               foreach ($avsub as $avsu) {
                   $nsub = $this->db->get_where('subjects', array('id' => $avsu['subject_id']))->num_rows();
                   if(($avsu['coef'] > 0) && ($nsub > 0)){
                       $tm += $avsu['mark_obtained']*$avsu['coef'];
                       $tc += $avsu['coef'];
                   }
                   if($tc > 0){
                       $av = $tm / $tc;
                   }else{
                       $av =0;
                   }
                   
            $checker = array(
                'student_id' => $student_enrolment['student_id'],
                'class_id' => $class_id,
                'section_id' => $section_id,
                'exam_id' => $exam_id,
                'school_id' => $this->school_id,
                'session' => $this->active_session
            );
                
            $checkerins = array(
                'student_id' => $student_enrolment['student_id'],
                'class_id' => $class_id,
                'section_id' => $section_id,
                'exam_id' => $exam_id,
                'school_id' => $this->school_id,
                'session' => $this->active_session,
                'total_mark' => $tm ,
                'total_coef' => $tc ,
                'average' => $av
            ); 
                   
            $exx =$this->db->get_where('average_division', array(
                'student_id' => $student_enrolment['student_id'],
                'class_id' => $class_id,
                'section_id' => $section_id,
                'exam_id' => $exam_id,
                'school_id' => $this->school_id,
                'session' => $this->active_session))->num_rows(); 
             
            if($exx > 0){
                $this->db->where($checker);
                $this->db->update('average_division' , array('total_mark' => $tm ,'total_coef' => $tc ,'average' => $av));
            }else{
               $this->db->insert('average_division', $checkerins); 
            }
               
            }
               //general average
               if($av > 0){
                   $tsg +=1;
                   $tavg += $av;
                   $avg = $tavg / $tsg;
               }
             
            // calculate general div average
             $n = $this->db->get_where('general_exam_average', array('class_id' => $class_id,'section_id' => $section_id, 'school_id' => $this->school_id, 'session' => $this->active_session, 'exam_id' => $exam_id))->num_rows();
            if($n > 0){      
                $checker = array(
                'class_id' => $class_id,
                'section_id' => $section_id,
                'exam_id' => $exam_id,
                'school_id' => $this->school_id,
                'session' => $this->active_session
                );
                $this->db->where($checker);
                $this->db->update('general_exam_average' , array('total_student' => $tsg ,'total_average' => $tavg ,'average' => $avg));
            }else{
                $data['class_id'] = $class_id;
                $data['section_id'] = $section_id;
                $data['exam_id'] = $exam_id;
                $data['school_id'] = $this->school_id;
                $data['session'] = $this->active_session;
                $data['total_student'] = $tsg;
                $data['total_average'] = $tavg;
                $data['average'] = $avg;
                $this->db->insert('general_exam_average', $data);
            }
            
    }
    
    public function single_session_average_update($student_id = "",$class_id = "", $section_id = ""){
        $tsg=0; $tavg=0; $avg=0;
        $student_enrolment['student_id']=$student_id;
               
               $avsub = $this->db->get_where('average_global_subject', array('class_id' => $class_id,'section_id' => $section_id, 'school_id' => $this->school_id, 'session' => $this->active_session, 'student_id' =>$student_enrolment['student_id']))->result_array();
               
               $tm =0;$tc =0;
               
               foreach ($avsub as $avsu) {
                   $nsub = $this->db->get_where('subjects', array('id' => $avsu['subject_id']))->num_rows();
                   if(($avsu['coef'] > 0) && ($nsub > 0)){
                       $tm += $avsu['mark_obtained']*$avsu['coef'];
                       $tc += $avsu['coef'];
                   }
                   if($tc > 0){
                       $av = $tm / $tc;
                   }else{
                       $av =0;
                   }
                   
            $checker = array(
                'student_id' => $student_enrolment['student_id'],
                'class_id' => $class_id,
                'section_id' => $section_id,
                'school_id' => $this->school_id,
                'session' => $this->active_session
            );
                   
            $checkerins = array(
                'student_id' => $student_enrolment['student_id'],
                'class_id' => $class_id,
                'section_id' => $section_id,
                'school_id' => $this->school_id,
                'session' => $this->active_session,
                'total_mark' => $tm ,
                'total_coef' => $tc ,
                'average' => $av
            ); 
                   
            $exx =$this->db->get_where('average_session', array(
                'student_id' => $student_enrolment['student_id'],
                'class_id' => $class_id,
                'section_id' => $section_id,
                'school_id' => $this->school_id,
                'session' => $this->active_session))->num_rows(); 
             
            if($exx > 0){
                $this->db->where($checker);
                $this->db->update('average_session' , array('total_mark' => $tm ,'total_coef' => $tc ,'average' => $av));
            }else{
               $this->db->insert('average_session', $checkerins); 
            }
                
                   }
                //general average
               if($av > 0){
                   $tsg +=1;
                   $tavg += $av;
                   $avg = $tavg / $tsg;
               }
            
        
            $n = $this->db->get_where('general_average', array('class_id' => $class_id,'section_id' => $section_id, 'school_id' => $this->school_id, 'session' => $this->active_session))->num_rows();
            if($n > 0){      
                $checker = array(
                'class_id' => $class_id,
                'section_id' => $section_id,
                'school_id' => $this->school_id,
                'session' => $this->active_session
                );
                $this->db->where($checker);
                $this->db->update('general_average' , array('total_student' => $tsg ,'total_average' => $tavg ,'average' => $avg));
            }else{
                $data['class_id'] = $class_id;
                $data['section_id'] = $section_id;
                $data['school_id'] = $this->school_id;
                $data['session'] = $this->active_session;
                $data['total_student'] = $tsg;
                $data['total_average'] = $tavg;
                $data['average'] = $avg;
                $this->db->insert('general_average', $data);
            }
            
    }
    
    public function subdiv_average_update($class_id = "", $section_id = "", $exam = ""){
        
        $tsg=0; $tavg=0; $avg=0;
        
        $student_enrolments = $this->db->get_where('enrols', array('class_id' => $class_id,'section_id' => $section_id, 'school_id' => $this->school_id, 'session' => $this->active_session))->result_array();
        
           foreach ($student_enrolments as $student_enrolment) {
               
               $avsub = $this->db->get_where('marks', array('class_id' => $class_id,'section_id' => $section_id, 'school_id' => $this->school_id, 'session' => $this->active_session, 'exam_id' => $exam, 'student_id' =>$student_enrolment['student_id']))->result_array();
               $tm =0;$tc =0;
               foreach ($avsub as $avsu) {
				   $nsub = $this->db->get_where('subjects', array('id' => $avsu['subject_id']))->num_rows();
                   if(($avsu['coef'] > 0) && ($nsub > 0)){
                       $tm += $avsu['mark_obtained']*$avsu['coef'];
                       $tc += $avsu['coef'];
                   }
                   if($tc > 0){
                       $av = $tm / $tc;
                   }else{
                       $av =0;
                   }
                   
                   
            $checker = array(
            'student_id' => $student_enrolment['student_id'],
            'class_id' => $class_id,
            'section_id' => $section_id,
            'exam_option_id' => $exam,
            'school_id' => $this->school_id,
            'session' => $this->active_session
            );
            $this->db->where($checker);
            $this->db->update('average_subdivision' , array('total_mark' => $tm ,'total_coef' => $tc ,'average' => $av));
            }
               //general average
               if($av > 0){
                   $tsg +=1;
                   $tavg += $av;
                   $avg = $tavg / $tsg;
               }
               
           } 
        //calculate general average of the class
          $n = $this->db->get_where('general_exam_option_average', array('class_id' => $class_id,'section_id' => $section_id, 'school_id' => $this->school_id, 'session' => $this->active_session, 'exam_option_id' => $exam))->num_rows();
           if($n > 0){      
                $checker = array(
                'class_id' => $class_id,
                'section_id' => $section_id,
                'exam_option_id' => $exam,
                'school_id' => $this->school_id,
                'session' => $this->active_session
                );
                $this->db->where($checker);
                $this->db->update('general_exam_option_average' , array('total_student' => $tsg ,'total_average' => $tavg ,'average' => $avg));
            }else{
                $data['class_id'] = $class_id;
                $data['section_id'] = $section_id;
                $data['exam_option_id'] = $exam;
                $data['school_id'] = $this->school_id;
                $data['session'] = $this->active_session;
                $data['total_student'] = $tsg;
                $data['total_average'] = $tavg;
                $data['average'] = $avg;
                $this->db->insert('general_exam_option_average', $data);
            } 
    }
    
    public function div_average_update($class_id = "", $section_id = "", $exam_id = ""){
        
        $tsg=0; $tavg=0; $avg=0;
        $student_enrolments = $this->db->get_where('enrols', array('class_id' => $class_id,'section_id' => $section_id, 'school_id' => $this->school_id, 'session' => $this->active_session))->result_array();
           foreach ($student_enrolments as $student_enrolment) {
               
               $avsub = $this->db->get_where('average_subject', array('class_id' => $class_id,'section_id' => $section_id, 'school_id' => $this->school_id, 'session' => $this->active_session, 'exam_id' => $exam_id, 'student_id' =>$student_enrolment['student_id']))->result_array();
               
               $tm =0;$tc =0;
               
               foreach ($avsub as $avsu) {
                   $nsub = $this->db->get_where('subjects', array('id' => $avsu['subject_id']))->num_rows();
                   if(($avsu['coef'] > 0) && ($nsub > 0)){
                       $tm += $avsu['mark_obtained']*$avsu['coef'];
                       $tc += $avsu['coef'];
                   }
                   if($tc > 0){
                       $av = $tm / $tc;
                   }else{
                       $av =0;
                   }
                   
                $checker = array(
                'student_id' => $student_enrolment['student_id'],
                'class_id' => $class_id,
                'section_id' => $section_id,
                'exam_id' => $exam_id,
                'school_id' => $this->school_id,
                'session' => $this->active_session
                );
                $this->db->where($checker);
                $this->db->update('average_division' , array('total_mark' => $tm ,'total_coef' => $tc ,'average' => $av));
               
            }
               //general average
               if($av > 0){
                   $tsg +=1;
                   $tavg += $av;
                   $avg = $tavg / $tsg;
               }
            } 
            // calculate general div average
             $n = $this->db->get_where('general_exam_average', array('class_id' => $class_id,'section_id' => $section_id, 'school_id' => $this->school_id, 'session' => $this->active_session, 'exam_id' => $exam_id))->num_rows();
            if($n > 0){      
                $checker = array(
                'class_id' => $class_id,
                'section_id' => $section_id,
                'exam_id' => $exam_id,
                'school_id' => $this->school_id,
                'session' => $this->active_session
                );
                $this->db->where($checker);
                $this->db->update('general_exam_average' , array('total_student' => $tsg ,'total_average' => $tavg ,'average' => $avg));
            }else{
                $data['class_id'] = $class_id;
                $data['section_id'] = $section_id;
                $data['exam_id'] = $exam_id;
                $data['school_id'] = $this->school_id;
                $data['session'] = $this->active_session;
                $data['total_student'] = $tsg;
                $data['total_average'] = $tavg;
                $data['average'] = $avg;
                $this->db->insert('general_exam_average', $data);
            }
            
            //averages for each exam options
            $term = $this->db->get_where('exam_option', array('exam_id' => $exam_id))->result_array();
            foreach ($term as $t) {
                $this->subdiv_average_update($class_id, $section_id, $t);
            }
         
    }
    
    public function session_average_update($class_id = "", $section_id = ""){
        $tsg=0; $tavg=0; $avg=0;
        $student_enrolments = $this->db->get_where('enrols', array('class_id' => $class_id,'section_id' => $section_id, 'school_id' => $this->school_id, 'session' => $this->active_session))->result_array();
        foreach ($student_enrolments as $student_enrolment) {
               
               $avsub = $this->db->get_where('average_global_subject', array('class_id' => $class_id,'section_id' => $section_id, 'school_id' => $this->school_id, 'session' => $this->active_session, 'student_id' =>$student_enrolment['student_id']))->result_array();
               
               $tm =0;$tc =0;
               
               foreach ($avsub as $avsu) {
                   $nsub = $this->db->get_where('subjects', array('id' => $avsu['subject_id']))->num_rows();
                   if(($avsu['coef'] > 0) && ($nsub > 0)){
                       $tm += $avsu['mark_obtained']*$avsu['coef'];
                       $tc += $avsu['coef'];
                   }
                   if($tc > 0){
                       $av = $tm / $tc;
                   }else{
                       $av =0;
                   }
                   
                $checker = array(
                'student_id' => $student_enrolment['student_id'],
                'class_id' => $class_id,
                'section_id' => $section_id,
                'school_id' => $this->school_id,
                'session' => $this->active_session
                );
                $this->db->where($checker);
                $this->db->update('average_session' , array('total_mark' => $tm ,'total_coef' => $tc ,'average' => $av));
                   }
                //general average
               if($av > 0){
                   $tsg +=1;
                   $tavg += $av;
                   $avg = $tavg / $tsg;
               }
            }
        
            $n = $this->db->get_where('general_average', array('class_id' => $class_id,'section_id' => $section_id, 'school_id' => $this->school_id, 'session' => $this->active_session))->num_rows();
            if($n > 0){      
                $checker = array(
                'class_id' => $class_id,
                'section_id' => $section_id,
                'school_id' => $this->school_id,
                'session' => $this->active_session
                );
                $this->db->where($checker);
                $this->db->update('general_average' , array('total_student' => $tsg ,'total_average' => $tavg ,'average' => $avg));
            }else{
                $data['class_id'] = $class_id;
                $data['section_id'] = $section_id;
                $data['school_id'] = $this->school_id;
                $data['session'] = $this->active_session;
                $data['total_student'] = $tsg;
                $data['total_average'] = $tavg;
                $data['average'] = $avg;
                $this->db->insert('general_average', $data);
            }
            
    }
    
    
	public function average_update(){
        
		$class_id  = html_escape($this->input->post('class_id'));
		$exam = html_escape($this->input->post('exam'));
		$exam_id = html_escape($this->input->post('exam_id'));
		$section_id = html_escape($this->input->post('section_id'));
        
        if($exam > 0){
           $this->subdiv_average_update($class_id, $section_id, $exam);
        }
        elseif($exam_id > 0){
           $this->div_average_update($class_id, $section_id, $exam_id);
        }
        elseif($exam_id==0 && $exam==0){ 
           $this->session_average_update($class_id, $section_id);
        }
        
	}
    
	public function mark_update_all(){
        
		$data['class_id'] = html_escape($this->input->post('class_id'));
		$behav = html_escape($this->input->post('behavior'));
		$data['section_id'] = html_escape($this->input->post('section_id'));
        
        $student_enrolments = $this->db->get_where('enrols', array('class_id' => $data['class_id'],'section_id' => $data['section_id'], 'school_id' => $this->school_id, 'session' => $this->active_session))->result_array();
        
		foreach ($student_enrolments as $student_enrolment) {
		$data['student_id'] = $student_enrolment['student_id'];
		$data['subject_id'] = html_escape($this->input->post('subject_id'));
		$data['exam_id'] = html_escape($this->input->post('exam_id'));
		$data['comment'] = html_escape($this->input->post('comment_'.$data['student_id']));
		$data['school_id'] = $this->school_id;
		$data['session'] = $this->active_session;
        
		$query = $this->db->get_where('marks', array('student_id' => $data['student_id'], 'class_id' => $data['class_id'], 'section_id' => $data['section_id'], 'subject_id' => $data['subject_id'], 'exam_id' => $data['exam_id'], 'session' => $data['session'], 'school_id' => $data['school_id']));
        $row = $query->row();
        
        $us =$this->db->get_where('students', array('id' => $data['student_id']))->row()->user_id;
        $n=$this->user_model->get_user_details($us, 'name');
            
        $co= $this->db->get_where('subjects', array('id' => $data['subject_id']))->row()->coef;
        $bid=$this->db->get_where('subjects', array('id' => $data['subject_id']))->row('behavior');
        //$bids=$this->db->get_where('mark_behavior_option', array('id' => $behav))->result_array();
        $mo=0; $su=0;
        
        //foreach($bids as $bi){
             $obtained_marks = html_escape($this->input->post('mark_'.$data['student_id'].'_'.$behav));
             $percentage =  $bi['percentage'];
             $total = $obtained_marks*$percentage/100;
            
             $quer = $this->db->get_where('mark_option', array('mark_id'=>$row->id, 'behavior_option_id'=> $behav));
             if($quer->num_rows() > 0){
                 $this->db->where('mark_id' , $row->id);
                 $this->db->where('behavior_option_id' , $behav);
                 $this->db->update('mark_option' , array('mark_obtained' => $total , 'max_mark' => $percentage));
                 $mo+=$total;
                 $su+=$max;
             }else{
                 $dat['mark_id'] = $row->id;
                 $dat['behavior_option_id'] = $behav;
                 $dat['mark_obtained'] = $total;
                 $dat['max_mark'] = $percentage;
				 $this->db->insert('mark_option', $dat);
                 $mo+=$total;
                 $su+=$max;
             }
          //}
        
		if($query->num_rows() > 0){
			$update_data['mark_obtained'] = $mo;
			$update_data['coef'] = $co;
			$update_data['name'] = $n;
			$update_data['comment'] = html_escape($this->input->post('comment_'.$data['student_id']));
			$this->db->where('id', $row->id);
			$this->db->update('marks', $update_data);
		}else{
			$this->db->insert('marks', $data);
		}
            
        //update subject mark average
        $eid =$this->db->get_where('exam_option', array('id' => $data['exam_id']))->row()->exam_id;
        $exs =$this->db->get_where('exam_option', array('exam_id' => $eid))->result_array();
        $coef = $this->db->get_where('subjects', array('id' => $data['subject_id']))->row()->coef;;
        $tmark = 0;
        $tex = 0;
        foreach($exs as $ex){
            $checker = array(
				'student_id' => $data['student_id'],
				'class_id' => $data['class_id'],
				'section_id' => $data['section_id'],
				'subject_id' => $data['subject_id'],
				'exam_id' => $ex['id'],
				'school_id' => $this->school_id,
				'session' => $this->active_session
			);
			$this->db->where($checker);
			$rows = $this->db->get('marks')->row();
            $c=$rows->coef;
            if($c > 0){
               $tex += 1; 
               $tmark += $rows->mark_obtained;
            }
        }
        
        if($tex < 1){
           $themo = $tmark; 
        }else{
          $themo = $tmark / $tex;
        }
        $checker = array(
            'student_id' => $data['student_id'],
            'class_id' => $data['class_id'],
            'section_id' => $data['section_id'],
            'subject_id' => $data['subject_id'],
            'exam_id' => $eid,
            'school_id' => $this->school_id,
            'session' => $this->active_session
        );
        $this->db->where($checker);
        $this->db->update('average_subject' , array('mark_obtained' => $themo ,'name' => $n , 'coef' => $coef));
	    }
	}
	//END MARKS section

	// Grade creation
	public function grade_create() {
		$data['name'] = html_escape($this->input->post('grade'));
		$data['short_name'] = html_escape($this->input->post('gradesn'));
		$data['name_fr'] = html_escape($this->input->post('gradef'));
		$data['short_name_fr'] = html_escape($this->input->post('gradesnf'));
		$data['grade_point'] = htmlspecialchars($this->input->post('grade_point'));
		$data['mark_from'] = htmlspecialchars($this->input->post('mark_from'));
		$data['mark_upto'] = htmlspecialchars($this->input->post('mark_upto'));
		$data['school_id'] = $this->school_id;
		$data['session'] = $this->active_session;
		$this->db->insert('grades', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('grade_added_successfully')
		);
		return json_encode($response);
	}

	public function grade_update($id = "") {
		$data['name'] = html_escape($this->input->post('grade'));
		$data['short_name'] = html_escape($this->input->post('gradesn'));
		$data['name_fr'] = html_escape($this->input->post('gradef'));
		$data['short_name_fr'] = html_escape($this->input->post('gradesnf'));
		$data['grade_point'] = htmlspecialchars($this->input->post('grade_point'));
		$data['mark_from'] = htmlspecialchars($this->input->post('mark_from'));
		$data['mark_upto'] = htmlspecialchars($this->input->post('mark_upto'));
		$data['school_id'] = $this->school_id;
		$data['session'] = $this->active_session;

		$this->db->where('id', $id);
		$this->db->update('grades', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('grade_updated_successfully')
		);
		return json_encode($response);
	}

	public function grade_delete($id = '')
	{
		$this->db->where('id', $id);
		$this->db->delete('grades');
		$response = array(
			'status' => true,
			'notification' => get_phrase('grade_deleted_successfully')
		);
		return json_encode($response);
	}
	// Grade ends

	// Student Promotion section Starts
	public function get_student_list() {
		$session_from = htmlspecialchars($this->input->post('session_from'));
		$session_to = htmlspecialchars($this->input->post('session_to'));
		$class_id_from = htmlspecialchars($this->input->post('class_id_from'));
		$class_id_to = htmlspecialchars($this->input->post('class_id_to'));
		$section_from = htmlspecialchars($this->input->post('class_id_from'));
		$section_to = htmlspecialchars($this->input->post('class_id_to'));
		$checker = array(
			'class_id' => $class_id_from,
			'section_id' => $section_from,
			'session' => $session_from,
			'school_id' => $this->school_id
		);
		return $this->db->get_where('enrols', $checker);
	}

	//promote student
	public function promote_student($promotion_data = "") {
		$promotion_data = explode('-', $promotion_data);
		$enroll_id = $promotion_data[0];
		$class_id = $promotion_data[1];
		$section = $promotion_data[2];
		$session_id = $promotion_data[3];
        
		$enroll['student_id'] = $enroll_id;
        $us =$this->db->get_where('students', array('id' => $enroll['student_id']))->row()->user_id;
        $enroll['name']=$this->user_model->get_user_details($us, 'name');
		$enroll['class_id'] = $class_id;
		$enroll['section_id'] = $section;
		$enroll['session'] = $session_id;
		$enroll['school_id'] = $this->school_id;
        
		$this->db->insert('enrols', $enroll);
		return true;
	}
    
    
	public function promote_students($promotion_data = "") {
		$class_id = html_escape($this->input->post('class_id_to'));
		$section = html_escape($this->input->post('section_to'));
		$session_id = html_escape($this->input->post('session_to'));
		$cf = html_escape($this->input->post('class_id_from'));
		$sf = html_escape($this->input->post('section_from'));
        
        $w = $this->get_global_winners($cf, $sf)->result_array();
        
		foreach ($w as $ww) {
            if($this->checkenroll($session_id, $ww['student_id'])->num_rows() ==0){
                $enroll['student_id'] = $ww['student_id'];
                $us =$this->db->get_where('students', array('id' => $enroll['student_id']))->row()->user_id;
                $enroll['name']=$this->user_model->get_user_details($us, 'name');
                $enroll['class_id'] = $class_id;
                $enroll['section_id'] = $section;
                $enroll['session'] = $session_id;
                $enroll['school_id'] = $this->school_id;
                $this->db->insert('enrols', $enroll);
            }
        }
		return true;
	}  
    
	public function promote_studentss($promotion_data = "") {
		$class_id = html_escape($this->input->post('class_id_to'));
		$section = html_escape($this->input->post('section_to'));
		$session_id = html_escape($this->input->post('session_to'));
		$cf = html_escape($this->input->post('class_id_from'));
		$sf = html_escape($this->input->post('section_from'));
        
        $w = $this->get_global_winners($cf, $sf)->result_array();
        
		foreach ($w as $ww) {
            if($this->checkenroll($session_id, $ww['student_id'])->num_rows() ==0){
                $enroll['student_id'] = $ww['student_id'];
                $us =$this->db->get_where('students', array('id' => $enroll['student_id']))->row()->user_id;
                $enroll['name']=$this->user_model->get_user_details($us, 'name');
                $enroll['class_id'] = $class_id;
                $enroll['section_id'] = $section;
                $enroll['session'] = $session_id;
                $enroll['school_id'] = $this->school_id;
                $this->db->insert('enrols', $enroll);
            }
        }
		return true;
	}
    
	public function redouble_student($promotion_data = "") {
		$promotion_data = explode('-', $promotion_data);
		$class_id = html_escape($this->input->post('class_id_from'));
		$section = html_escape($this->input->post('section_from'));
		$session_id = html_escape($this->input->post('section_to'));
        
        $l = $this->get_global_losers($class_id, $section)->result_array();
        foreach ($l as $ww) {
        if($this->checkenroll($session_id, $ww['student_id'])->num_rows() < 1){
            $enroll['student_id'] = $ww['student_id'];
            $us =$this->db->get_where('students', array('id' => $enroll['student_id']))->row()->user_id;
            $enroll['name']=$this->user_model->get_user_details($us, 'name');
            $enroll['class_id'] = $class_id;
            $enroll['section_id'] = $section;
            $enroll['session'] = $session_id;
		    $enroll['school_id'] = $this->school_id;
            $this->db->insert('enrols', $enroll);
        }
        }
		return true;
	}
	// Student Promotion section Ends

	//STUDENT ACCOUNTING SECTION STARTS
	public function get_invoice_by_id($id = "") {
		return $this->db->get_where('invoices', array('id' => $id))->row_array();
	}

	public function get_invoice_by_date_range($date_from = "", $date_to = "", $selected_class = "", $selected_status = "") {
		if ($selected_class != "all") {
			$this->db->where('class_id', $selected_class);
		}
		if ($selected_status != "all") {
			$this->db->where('status', $selected_status);
		}
		$this->db->where('created_at >=', $date_from);
		$this->db->where('created_at <=', $date_to);
		$this->db->where('school_id', $this->school_id);
		$this->db->where('session', $this->active_session);
		return $this->db->get('invoices');
	}

	public function get_invoice_by_student_id($student_id = "") {
		$this->db->where('school_id', $this->school_id);
		$this->db->where('session', $this->active_session);
		$this->db->where('student_id', $student_id);
		return $this->db->get('invoices');
	}

	// This function will be triggered if parent logs in
	public function get_invoice_by_parent_id() {
		$parent_user_id = $this->session->userdata('user_id');
		$parent_data = $this->db->get_where('parents', array('user_id' => $parent_user_id))->row_array();
		$student_list = $this->user_model->get_student_list_of_logged_in_parent();
		$student_ids = array();
		foreach ($student_list as $student) {
			if(!in_array($student['student_id'], $student_ids)){
				array_push($student_ids, $student['student_id']);
			}
		}

		if (count($student_ids) > 0) {
			$this->db->where_in('student_id', $student_ids);
			$this->db->where('school_id', $this->school_id);
			$this->db->where('session', $this->active_session);
			return $this->db->get('invoices')->result_array();
		}else{
			return array();
		}
	}

	public function create_single_invoice() {
		$data['title'] = htmlspecialchars($this->input->post('title'));
		$data['total_amount'] = htmlspecialchars($this->input->post('total_amount'));
		$data['class_id'] = htmlspecialchars($this->input->post('class_id'));
		$data['student_id'] = htmlspecialchars($this->input->post('student_id'));
		$data['paid_amount'] = htmlspecialchars($this->input->post('paid_amount'));
		$data['status'] = htmlspecialchars($this->input->post('status'));
		$data['school_id'] = $this->school_id;
		$data['session'] = $this->active_session;
		$data['created_at'] = strtotime(date('d-M-Y'));

		/*KEEPING TRACK OF PAYMENT DATE*/
		if ($this->input->post('paid_amount') > 0) {
			$data['updated_at'] = strtotime(date('d-M-Y'));
		}

		if ($data['paid_amount'] > $data['total_amount']) {
			$response = array(
				'status' => false,
				'notification' => get_phrase('paid_amount_can_not_get_bigger_than_total_amount')
			);
			return json_encode($response);
		}
		if ($data['status'] == 'paid' && $data['total_amount'] != $data['paid_amount']) {
			$response = array(
				'status' => false,
				'notification' => get_phrase('paid_amount_is_not_equal_to_total_amount')
			);
			return json_encode($response);
		}

		$this->db->insert('invoices', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('invoice_added_successfully')
		);
		return json_encode($response);
	}

	public function create_mass_invoice() {
		$data['total_amount'] = htmlspecialchars($this->input->post('total_amount'));
		$data['paid_amount'] = htmlspecialchars($this->input->post('paid_amount'));
		$data['status'] = htmlspecialchars($this->input->post('status'));

		if ($data['paid_amount'] > $data['total_amount']) {
			$response = array(
				'status' => false,
				'notification' => get_phrase('paid_amount_can_not_get_bigger_than_total_amount')
			);
			return json_encode($response);
		}

		if ($data['status'] == 'paid' && $data['total_amount'] != $data['paid_amount']) {
			$response = array(
				'status' => false,
				'notification' => get_phrase('paid_amount_is_not_equal_to_total_amount')
			);
			return json_encode($response);
		}

		if ($data['total_amount'] == $data['paid_amount']) {
			$data['status'] = 'paid';
		}

		$data['title'] = htmlspecialchars($this->input->post('title'));
		$data['class_id'] = htmlspecialchars($this->input->post('class_id'));
		$data['school_id'] = $this->school_id;
		$data['session'] = $this->active_session;
		$data['created_at'] = strtotime(date('d-M-Y'));

		/*KEEPING TRACK OF PAYMENT DATE*/
		if ($this->input->post('paid_amount') > 0) {
			$data['updated_at'] = strtotime(date('d-M-Y'));
		}

		$enrolments = $this->user_model->get_student_details_by_id('section', htmlspecialchars($this->input->post('section_id')));
		foreach ($enrolments as $enrolment) {
			$data['student_id'] = $enrolment['student_id'];
			$this->db->insert('invoices', $data);
		}

		if (sizeof($enrolments) > 0) {
			$response = array(
				'status' => true,
				'notification' => get_phrase('invoice_added_successfully')
			);
		}else{
			$response = array(
				'status' => false,
				'notification' => get_phrase('no_student_found')
			);
		}
		return json_encode($response);
	}

	public function update_invoice($id = "") {

		/*GET THE PREVIOUS INVOICE DETAILS FOR GETTING THE PAID AMOUNT*/
		$previous_invoice_data = $this->db->get_where('invoices', array('id' => $id))->row_array();

		$data['title'] = htmlspecialchars($this->input->post('title'));
		$data['total_amount'] = htmlspecialchars($this->input->post('total_amount'));
		$data['class_id'] = htmlspecialchars($this->input->post('class_id'));
		$data['student_id'] = htmlspecialchars($this->input->post('student_id'));
		$data['paid_amount'] = htmlspecialchars($this->input->post('paid_amount'));
		$data['status'] = htmlspecialchars($this->input->post('status'));

		if ($data['paid_amount'] > $data['total_amount']) {
			$response = array(
				'status' => false,
				'notification' => get_phrase('paid_amount_can_not_get_bigger_than_total_amount')
			);
			return json_encode($response);
		}
		if ($data['status'] == 'paid' && $data['total_amount'] != $data['paid_amount']) {
			$response = array(
				'status' => false,
				'notification' => get_phrase('paid_amount_is_not_equal_to_total_amount')
			);
			return json_encode($response);
		}

		if ($data['total_amount'] == $data['paid_amount']) {
			$data['status'] = 'paid';
		}

		/*KEEPING TRACK OF PAYMENT DATE*/
		if ($this->input->post('paid_amount') != $previous_invoice_data && $this->input->post('paid_amount') > 0) {
			$data['updated_at'] = strtotime(date('d-M-Y'));
		}elseif ($this->input->post('paid_amount') == 0 || $this->input->post('paid_amount') == "") {
			$data['updated_at'] = 0;
		}

		$this->db->where('id', $id);
		$this->db->update('invoices', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('invoice_updated_successfully')
		);
		return json_encode($response);
	}

	public function delete_invoice($id = "") {
		$this->db->where('id', $id);
		$this->db->delete('invoices');

		$response = array(
			'status' => true,
			'notification' => get_phrase('invoice_deleted_successfully')
		);
		return json_encode($response);
	}
	//STUDENT ACCOUNTING SECTION ENDS

	//Expense Category Starts
	public function get_expense_categories($id = "") {
		if ($id > 0) {
			$this->db->where('id', $id);
		}
		$this->db->where('school_id', $this->school_id);
		$this->db->where('session', $this->active_session);
		return $this->db->get('expense_categories');
	}
	public function create_expense_category() {
		$data['name'] = htmlspecialchars($this->input->post('name'));
		$data['school_id'] = $this->school_id;
		$data['session'] = $this->active_session;
		$this->db->insert('expense_categories', $data);
		$response = array(
			'status' => true,
			'notification' => get_phrase('expense_category_added_successfully')
		);
		return json_encode($response);
	}

	public function update_expense_category($id) {
		$data['name'] = htmlspecialchars($this->input->post('name'));
		$this->db->where('id', $id);
		$this->db->update('expense_categories', $data);
		$response = array(
			'status' => true,
			'notification' => get_phrase('expense_category_updated_successfully')
		);
		return json_encode($response);
	}

	public function delete_expense_category($id) {
		$this->db->where('id', $id);
		$this->db->delete('expense_categories');
		$response = array(
			'status' => true,
			'notification' => get_phrase('expense_category_deleted_successfully')
		);
		return json_encode($response);
	}
	//Expense Category Ends

	//Expense Manager Starts
	public function get_expense_by_id($id = "") {
		return $this->db->get_where('expenses', array('id' => $id))->row_array();
	}

	public function get_expense($date_from = "", $date_to = "", $expense_category_id = "") {
		if ($expense_category_id > 0) {
			$this->db->where('expense_category_id', $expense_category_id);
		}
		$this->db->where('date >=', $date_from);
		$this->db->where('date <=', $date_to);
		$this->db->where('school_id', $this->school_id);
		$this->db->where('session', $this->active_session);
		return $this->db->get('expenses');
	}

	// creating
	public function create_expense() {
		$data['date'] = strtotime($this->input->post('date'));
		$data['amount'] = htmlspecialchars($this->input->post('amount'));
		$data['expense_category_id'] = htmlspecialchars($this->input->post('expense_category_id'));
		$data['school_id'] = $this->school_id;
		$data['session'] = $this->active_session;
		$data['created_at'] = strtotime(date('d-M-Y'));
		$this->db->insert('expenses', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('expense_added_successfully')
		);
		return json_encode($response);
	}

	// updating
	public function update_expense($id = "") {
		$data['date'] = strtotime($this->input->post('date'));
		$data['amount'] = htmlspecialchars($this->input->post('amount'));
		$data['expense_category_id'] = htmlspecialchars($this->input->post('expense_category_id'));
		$data['school_id'] = $this->school_id;
		$data['session'] = $this->active_session;
		$this->db->where('id', $id);
		$this->db->update('expenses', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('expense_updated_successfully')
		);
		return json_encode($response);
	}

	// deleting
	public function delete_expense($id = "") {
		$this->db->where('id', $id);
		$this->db->delete('expenses');

		$response = array(
			'status' => true,
			'notification' => get_phrase('expense_deleted_successfully')
		);
		return json_encode($response);
	}
	// Expense Manager Ends

	// PROVIDE ENTRY AFTER PAYMENT SUCCESS
	public function payment_success($data = array()) {
		$this->db->where('id', $data['invoice_id']);
		$invoice_details = $this->db->get('invoices')->row_array();
		$due_amount = $invoice_details['total_amount'] - $invoice_details['paid_amount'];
		if ($due_amount == $data['amount_paid']) {
			$updater = array(
				'status' => 'paid',
				'payment_method' => $data['payment_method'],
				'paid_amount' => $data['amount_paid'] + $invoice_details['paid_amount'],
				'updated_at'  => strtotime(date('d-M-Y'))
			);
			$this->db->where('id', $data['invoice_id']);
			$this->db->update('invoices', $updater);
		}
	}

	// Back Office Section Starts
	public function get_session($id = "") {
		if ($id > 0) {
			$this->db->where('id', $id);
		}
		$sessions = $this->db->get('sessions');
		return $sessions;
	}

	// Book Manager
	public function get_books() {
		$checker = array(
			'session' => $this->active_session,
			'school_id' => $this->school_id
		);
		return $this->db->get_where('books', $checker);
	}

	public function get_book_by_id($id = "") {
		return $this->db->get_where('books', array('id' => $id))->row_array();
	}

	public function create_book() {
		$data['name']      = htmlspecialchars($this->input->post('name'));
		$data['author']    = htmlspecialchars($this->input->post('author'));
		$data['copies']    = htmlspecialchars($this->input->post('copies'));
		$data['school_id'] = $this->school_id;
		$data['session']   = $this->active_session;
		$this->db->insert('books', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('books_added_successfully')
		);
		return json_encode($response);
	}

	public function update_book($id = "") {
		$data['name']      = htmlspecialchars($this->input->post('name'));
		$data['author']    = htmlspecialchars($this->input->post('author'));
		$data['copies']    = htmlspecialchars($this->input->post('copies'));
		$data['school_id'] = $this->school_id;
		$data['session']   = $this->active_session;

		$this->db->where('id', $id);
		$this->db->update('books', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('books_updated_successfully')
		);
		return json_encode($response);
	}

	public function delete_book($id = "") {
		$this->db->where('id', $id);
		$this->db->delete('books');

		$response = array(
			'status' => true,
			'notification' => get_phrase('books_deleted_successfully')
		);
		return json_encode($response);
	}

	// Book Issue
	public function get_book_issues($date_from = "", $date_to = "") {
		$this->db->where('session', $this->active_session);
		$this->db->where('school_id', $this->school_id);
		$this->db->where('issue_date >=', $date_from);
		$this->db->where('issue_date <=', $date_to);
		return $this->db->get('book_issues');
	}
	public function get_book_issues_by_student_id($student_id = "") {
		$this->db->where('student_id', $student_id);
		return $this->db->get('book_issues');
	}

	public function get_book_issue_by_id($id = "") {
		return $this->db->get_where('book_issues', array('id' => $id))->row_array();
	}

	public function create_book_issue() {
		$data['book_id']    = htmlspecialchars($this->input->post('book_id'));
		$data['class_id']   = htmlspecialchars($this->input->post('class_id'));
		$data['student_id'] = htmlspecialchars($this->input->post('student_id'));
		$data['issue_date'] = strtotime($this->input->post('issue_date'));
		$data['school_id'] = $this->school_id;
		$data['session']   = $this->active_session;

		$this->db->insert('book_issues', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('added_successfully')
		);
		return json_encode($response);
	}

	public function update_book_issue($id = "") {
		$data['book_id']    = htmlspecialchars($this->input->post('book_id'));
		$data['class_id']   = htmlspecialchars($this->input->post('class_id'));
		$data['student_id'] = htmlspecialchars($this->input->post('student_id'));
		$data['issue_date'] = strtotime($this->input->post('issue_date'));
		$data['school_id'] = $this->school_id;
		$data['session']   = $this->active_session;

		$this->db->where('id', $id);
		$this->db->update('book_issues', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('updated_successfully')
		);
		return json_encode($response);
	}

	public function return_issued_book($id = "") {
		$data['status']   = 1;

		$this->db->where('id', $id);
		$this->db->update('book_issues', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('returned_successfully')
		);
		return json_encode($response);
	}

	public function get_number_of_issued_book_by_id($id) {
		return $this->db->get_where('book_issues', array('book_id' => $id, 'status' => 0))->num_rows();
	}

	public function delete_book_issue($id = "") {
		$this->db->where('id', $id);
		$this->db->delete('book_issues');

		$response = array(
			'status' => true,
			'notification' => get_phrase('deleted_successfully')
		);
		return json_encode($response);
	}

	//SCHOOL DETAILS
	public function get_schools() {
		$schools = $this->db->get('schools');
		return $schools;
	}
	public function get_school_details_by_id($school_id = "") {
		return $this->db->get_where('schools', array('id' => $school_id))->row_array();
	}
	// Back Office Section Ends

	// GET INSTALLED ADDONS
	public function get_addons($unique_identifier = "") {
		if ($unique_identifier != "") {
			$addons = $this->db->get_where('addons', array('unique_identifier' => $unique_identifier));
		}else{
			$addons = $this->db->get_where('addons');
		}
		return $addons;
	}

	// A function to convert excel to csv
	public function excel_to_csv($file_path = "", $rename_to = "") {
		//read file from path
		$inputFileType = PHPExcel_IOFactory::identify($file_path);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objPHPExcel = $objReader->load($file_path);
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
		$index = 0;
		if ($objPHPExcel->getSheetCount() > 1) {
			foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
				$objPHPExcel->setActiveSheetIndex($index);
				$fileName = strtolower(str_replace(array("-"," "), "_", $worksheet->getTitle()));
				$outFile = str_replace(".", "", $fileName) .".csv";
				$objWriter->setSheetIndex($index);
				$objWriter->save("assets/csv_file/".$outFile);
				$index++;
			}
		}else{
			$outFile = $rename_to;
			$objWriter->setSheetIndex($index);
			$objWriter->save("assets/csv_file/".$outFile);
		}

		return true;
	} 

	public function check_recaptcha(){
        if (isset($_POST["g-recaptcha-response"])) {
            $url = 'https://www.google.com/recaptcha/api/siteverify';
            $data = array(
                'secret' => get_common_settings('recaptcha_secretkey'),
                'response' => $_POST["g-recaptcha-response"]
            );
                $query = http_build_query($data);
                $options = array(
                'http' => array (
                    'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
                        "Content-Length: ".strlen($query)."\r\n".
                        "User-Agent:MyAgent/1.0\r\n",
                    'method' => 'POST',
                    'content' => $query
                )
            );
            $context  = stream_context_create($options);
            $verify = file_get_contents($url, false, $context);
            $captcha_success = json_decode($verify);
            if ($captcha_success->success == false) {
                return false;
            } else if ($captcha_success->success == true) {
                return true;
            }
        } else {
            return false;
        }
    }
}
