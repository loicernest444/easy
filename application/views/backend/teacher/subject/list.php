<?php
  $school_id  = school_id();
  $check_data = $this->db->get_where('subjects', array('session' => active_session(), 'class_id' => $class_id, 'section_id' => $section_id))->result_array();
  if (count($check_data) > 0):?>
 <table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
    <thead>
      <tr style="background-color: #313a46; color: #ababab;">
        <th>#</th>
        <th><?php echo get_phrase('name'); ?></th>
        <th><?php echo get_phrase('details'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php
        $c=1;
      $school_id = school_id();
      $subjects = $this->db->get_where('subjects', array('session' => active_session(), 'class_id' => $class_id, 'section_id' => $section_id))->result_array();
      $use = $this->db->get_where('classes', array('id' => $class_id))->row()->use_sections;

      $n=$this->db->get_where('subjects', array('class_id'=>$class_id, 'session' => active_session()))->num_rows(); 
      foreach($subjects as $subject){
        ?>
        <tr>
          <td><?php echo $c++; ?></td>
          <td><?php echo $subject['name'].' - '.$subject['short_name']; ?></td>
          
          <td>
              <em><?php echo get_phrase('coef'); ?> : </em><?php echo $subject['coef']; ?><br>
              <em><?php echo get_phrase('group'); ?> : </em><?php echo $this->db->get_where('subject_settings', array('id' => $subject['group']))->row()->name; ?><br>
              <em><?php echo get_phrase('type'); ?> : </em><?php echo $this->db->get_where('subject_settings', array('id' => $subject['type']))->row()->name; ?><br>
              <em><?php echo get_phrase('mark_behavior'); ?> : </em><?php echo $this->db->get_where('mark_behavior', array('id' => $subject['behavior']))->row()->name; ?><br>
              <em><?php echo get_phrase('teacher'); ?> : </em><?php $tid= $this->db->get_where('teachers', array('id' => $subject['teacher_id']))->row()->user_id; echo $this->db->get_where('users', array('id' => $tid))->row()->name; ?><br>
              <em><?php echo get_phrase('period'); ?> : </em><?php 
               $tid= $this->db->get_where('exams', array('id' => $subject['doing_period']))->row()->name; 
               $tidf= $this->db->get_where('exams', array('id' => $subject['doing_period']))->row()->name_fr; 
          
               if ($subject['doing_period'] == 0){
                   echo get_phrase('all_the_year');
                } else{
                   echo $tid.' / '.$tidf;
               } ?><br>
          </td>
        </tr>
        <?php } ?>
    </tbody>
  </table>
<?php else: ?>
  <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>
