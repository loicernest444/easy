<?php
$teach =$this->db->get_where('teachers', array('user_id' => $this->session->userdata('user_id')))->row()->id;
$subjects = $this->db->get_where('subjects', array('class_id' => $class_id, 'school_id' =>school_id(),'session' => active_session(),'doing_period' => $doing))->result_array();

$subjectsy = $this->db->get_where('subjects', array('class_id' => $class_id, 'school_id' =>school_id(),'session' => active_session(),'doing_period' => 0))->result_array();
if ((count($subjects) > 0) || (count($subjectsy) > 0)): ?>
   <option value="all"><?php echo get_phrase('all'); ?></option>
  <?php
  foreach ($subjects as $subject): ?>
    <option value="<?php echo $subject['id']; ?>"><?php echo $subject['name']; ?></option>
  <?php endforeach; ?>
    <?php
  foreach ($subjectsy as $subject): ?>
    <option value="<?php echo $subject['id']; ?>"><?php echo $subject['name']; ?></option>
  <?php endforeach; ?>
<?php else: ?>
  <option value=""><?php echo get_phrase('no_subject_found'); ?></option>
<?php endif; ?>