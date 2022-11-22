<?php
  $school_id = school_id();
?>

<h4><?php echo get_phrase('student_mark_list'); ?></h4>
        <span><?php echo get_phrase('class'); ?> : <?php echo $this->db->get_where('classes', array('id' => $class_id))->row('name'); ?></span><br>
        <span><?php echo get_phrase('section'); ?> : <?php echo $this->db->get_where('sections', array('id' => $section_id))->row('name'); ?></span><br>
<table width="100%" style="border-collapse: collapse;">
  <thead>
    <tr style="background-color: #313a46; text-align: center;">
      <th style="border : 1px solid black; color: #fff; ">#</th>
      <th style="border : 1px solid black; color: #fff; "><?php echo get_phrase('name'); ?></th>
      <th style="border : 1px solid black; color: #fff; "><?php echo get_phrase('birth'); ?></th>
      <th style="border : 1px solid black; color: #fff; "><?php echo get_phrase('mark'); ?></th>
      <th style="border : 1px solid black; color: #fff; "><?php echo get_phrase('mark'); ?></th>
      <th style="border : 1px solid black; color: #fff; "><?php echo get_phrase('mark'); ?></th>
      <th style="border : 1px solid black; color: #fff; "><?php echo get_phrase('mark'); ?></th>
      <th style="border : 1px solid black; color: #fff; "><?php echo get_phrase('mark'); ?></th>
    </tr>
  </thead>
  <tbody>
    <?php
    $count=1;
    $enrols = $this->crud_model->get_stlist($class_id,$section_id);
    
    foreach($enrols as $enroll){
      $student = $this->db->get_where('students', array('id' => $enroll['student_id']))->row_array();
      ?>
      <tr>
        <td style="border : 1px solid black; color: #000; "><?php echo $count++; ?></td>
        <td style="border : 1px solid black; color: #000; "><?php echo $this->user_model->get_user_details($student['user_id'], 'name'); ?></td>
        <td style="border : 1px solid black; color: #000; ">
            <?php 
            $bt = $this->user_model->get_user_details($student['user_id'], 'birthtype');
            if ($bt =='around'){
               $bd = $this->user_model->get_user_details($student['user_id'], 'birthday'); 
            }else{
               $bd = date('d-M-Y', $this->user_model->get_user_details($student['user_id'], 'birthday')); 
            }
            echo $this->user_model->get_user_details($student['user_id'], 'birthplace').', '.get_phrase($bt).' '.$bd; 
            
            ?>
          
        </td>
        <td style="border : 1px solid black; color: #000; "> </td> 
        <td style="border : 1px solid black; color: #000; "> </td> 
        <td style="border : 1px solid black; color: #000; "> </td> 
        <td style="border : 1px solid black; color: #000; "> </td> 
        <td style="border : 1px solid black; color: #000; "> </td> 
      </tr>
    <?php } ?>
  </tbody>
</table>

<script type="text/javascript">
  initDataTable('basic-datatable');
</script>
