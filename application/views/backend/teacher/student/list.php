<?php
  $school_id = school_id();
?>
<table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
  <thead>
    <tr style="background-color: #313a46; color: #ababab;">
      <th>#</th>
      <th><?php echo get_phrase('photo'); ?></th>
      <th><?php echo get_phrase('name'); ?></th>
      <th><?php echo get_phrase('birth'); ?></th>
      <th><?php echo get_phrase('origin'); ?></th>
      <th><?php echo get_phrase('contact'); ?></th>
      <th><?php echo get_phrase('options'); ?></th>
    </tr>
  </thead>
  <tbody>
    <?php
      $c=1;
    $enrols = $this->db->get_where('enrols', array('class_id' => $class_id, 'section_id' => $section_id, 'school_id' => $school_id, 'session' => active_session()))->result_array();
    foreach($enrols as $enroll){
      $student = $this->db->get_where('students', array('id' => $enroll['student_id']))->row_array();
      ?>
      <tr>
        <td><?php echo $c++; ?></td>  
        <td>
          <img class="rounded-circle" width="50" height="50" src="<?php echo $this->user_model->get_user_image($student['user_id']); ?>">
        </td>
        <td><?php echo $this->user_model->get_user_details($student['user_id'], 'name'); ?></td>
        <td>
            <?php 
            $bt = $this->user_model->get_user_details($student['user_id'], 'birthtype');
            if ($bt =='around'){
               $bd = $this->user_model->get_user_details($student['user_id'], 'birthday'); 
            }else{
               $bd = date('d-M-Y', $this->user_model->get_user_details($student['user_id'], 'birthday')); 
            }
            echo $this->user_model->get_user_details($student['user_id'], 'birthplace').'<br>'.get_phrase($bt).' '.$bd; 
            
            ?>
          
        </td>
        <td>
        <?php 
        $reg=$this->db->get_where('regions', array('id' => $this->user_model->get_user_details($student['user_id'], 'region_id')))->row()->name;
        $dep=$this->db->get_where('department', array('id' => $this->user_model->get_user_details($student['user_id'], 'department')))->row()->name;
        $nat=$this->user_model->get_user_details($student['user_id'], 'nationality');
        echo $dep.', '.$reg.', '.$nat; ?>
        </td>
        <td>
            <?php echo $this->user_model->get_user_details($student['user_id'], 'email'); ?><br>
            <?php echo $this->user_model->get_user_details($student['user_id'], 'phone'); ?><br>
            <?php echo $this->user_model->get_user_details($student['user_id'], 'address'); ?>
        </td>
        <td>
          <div class="dropdown text-center">
  					<button type="button" class="btn btn-sm btn-icon btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
  					<div class="dropdown-menu dropdown-menu-right">
              <!-- item-->
              <?php if(addon_status('id-card')):?>
                <a href="javascript:void(0);" class="dropdown-item" onclick="largeModal('<?php echo site_url('modal/popup/student/id_card/'.$student['id'])?>', '<?php echo $this->db->get_where('schools', array('id' => $school_id))->row('name'); ?>')"><?php echo get_phrase('generate_id_card'); ?></a>
              <?php endif;?>
              <!-- item-->
  						<a href="javascript:void(0);" class="dropdown-item"  onclick="largeModal('<?php echo site_url('modal/popup/student/profile/'.$student['id'])?>', '<?php echo $this->db->get_where('schools', array('id' => $school_id))->row('name'); ?>')"><?php echo get_phrase('profile'); ?></a>
  						<!-- item-->
  					</div>
  				</div> 
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>

<script type="text/javascript">
  initDataTable('basic-datatable');
</script>
