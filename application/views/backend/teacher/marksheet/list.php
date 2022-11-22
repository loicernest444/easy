<?php
if($exam > 0){
  $term = $this->db->get_where('exam_option', array('id' => $exam))->row()->name;
}
elseif($exam_id > 0){
  $term = $this->db->get_where('exams', array('id' => $exam_id))->row()->name;
}
?>

<div class="row mb-3">
    <div class="col-md-12">
        <div class="col-md-3">
        </div>
    </div>
    <div class="col-md-4"></div>
    <div class="col-md-12 toll-free-box text-center text-white pb-2" style="background-color: #6c757d; border-radius: 10px;">
        <h4><?php echo get_phrase('student_marksheets  '); ?></h4>
        <span><?php echo get_phrase('class'); ?> : <?php echo $this->db->get_where('classes', array('id' => $class_id))->row('name'); ?></span><br>
        <span><?php echo get_phrase('section'); ?> : <?php echo $this->db->get_where('sections', array('id' => $section_id))->row('name'); ?></span><br>
        
        <?php if($subject_id > 0){?>
        <span><?php echo get_phrase('subject'); ?> : <?php echo $this->db->get_where('subjects', array('id' => $subject_id))->row('name'); ?></span><br>
        <?php } ?>
    </div>
</div>
<?php
$school_id = school_id();
$marks = $this->crud_model->get_marks_average($class_id, $section_id, $subject_id, $exam_id)->result_array();
$numm = $this->crud_model->get_marks_average($class_id, $section_id, $subject_id, $exam_id)->num_rows();
$enrols = $this->crud_model->get_stu_average($class_id, $section_id)->result_array();

if($numm < 1){
  $marks = $this->db->get_where('enrols', array('class_id' => $class_id, 'section_id' => $section_id, 'school_id' => school_id(), 'session' => active_session()))->result_array();
}
?> 
<?php if (count($marks) > 0): ?> 
    <?php if ($subject_id == "all"){ ?> 
    <table class="table table-bordered table-responsive-sm" width="100%"  style="overflow: auto; white-space: nowrap;">
        <thead class="thead-dark">
            <?php 
                  $subs =$this->db->get_where('subjects', array('class_id' => $class_id,'section_id' => $section_id,'school_id' => school_id(),'session' => active_session()))->result_array();
    
                  $exs =$this->db->get_where('exam_option', array('exam_id' => $exam_id))->result_array();
                  $nnexs =$this->db->get_where('exam_option', array('exam_id' => $exam_id))->num_rows();
                  $tcol = ($nnexs * 3) +3;
            ?>
            
            <tr style="text-align : center;">
                <th><i class="mdi mdi-sort-descending"></i></th>
                <th><?php echo get_phrase('exams'); ?> <i class="mdi mdi-arrow-right-bold-circle"></i></th>
                <?php
                   foreach($exs as $bids){
                    $nn=0;
                    foreach($subs as $sub){ 
                        $c =$this->db->get_where('subjects', array('id' => $sub['id']))->row('behavior');
                        $co =$this->db->get_where('mark_behavior_option', array('mark_behavior_id' => $c))->num_rows();
                        if($co == 1){$nn+= $co;}else{$nn+=$co +1;}
                    }?>
                     <th colspan="<?php echo $nn; ?>"><?php echo $bids['name']; ?></th>
                <?php } ?>
                <th colspan="<?php echo $tcol; ?>"><?php echo get_phrase('total'); ?></th>
            </tr>
            
            <tr  style="text-align : center;">
                <th><i class="mdi mdi-arrow-collapse"></i></th>
                <th><?php echo get_phrase('subjects'); ?> <i class="mdi mdi-arrow-right-bold-circle"></i></th>
                <?php
                foreach($exs as $bids){
                    foreach($subs as $sub){  
                    $c =$this->db->get_where('subjects', array('id' => $sub['id']))->row('behavior');
                    $co =$this->db->get_where('mark_behavior_option', array('mark_behavior_id' => $c))->num_rows();
                    if($co == 1){$cs = $co;}else{$cs=$co +1;}
                    ?>
                     <th colspan="<?php echo $cs; ?>"><?php echo $sub['short_name']; ?></th>
                <?php } } ?>
                <?php foreach($exs as $bids){ ?>
                    <th colspan="3"><?php echo $bids['name']; ?></th>
                <?php } ?>
                  <th colspan="3"><?php echo get_phrase('total'); ?></th>
            </tr> 
            
            <tr style="text-align : center;">
                <th>#</th>
                <th><?php echo get_phrase('student_names'); ?></th>
                <?php
                foreach($exs as $bids){
                  foreach($subs as $sub){ 
                    $c =$this->db->get_where('subjects', array('id' => $sub['id']))->row('behavior');
                    $co = $this->db->get_where('mark_behavior_option', array('mark_behavior_id' => $c))->num_rows();
                      
                    $cos =$this->db->get_where('mark_behavior_option', array('mark_behavior_id' => $c))->result_array();
                    if($co == 1){$cs = $co;}else{$cs=$co +1;}
                    
                        if($co == 1){ ?>
                            <th><?php echo '* '.$sub['coef']; ?></th>
                        <?php }else{
                        foreach($cos as $coss){?>
                          <th><?php echo $coss['name_fr']; ?></th>
                        <?php }   ?>
                          <th><?php echo get_phrase('total'); ?></th>
                        <?php }   ?>
                <?php } ?>
                <?php } ?>
                <?php 
                foreach($exs as $bids){ ?>
                    <th><?php echo get_phrase('mark'); ?></th>
                    <th><?php echo get_phrase('coef'); ?></th>
                    <th><?php echo get_phrase('average'); ?></th>
                <?php } ?>
                <th><?php echo get_phrase('mark'); ?></th>
                    <th><?php echo get_phrase('coef'); ?></th>
                    <th><?php echo get_phrase('average'); ?></th>
            </tr>
        </thead> 
        <tbody>
        <?php 
              $subs =$this->db->get_where('subjects', array('class_id' => $class_id,'section_id' => $section_id,'school_id' => school_id(),'session' => active_session()))->result_array();
              $exs =$this->db->get_where('exam_option', array('exam_id' => $exam_id))->result_array();
            $count = 1; 
            foreach($enrols as $mark):
            $student = $this->db->get_where('students', array('id' => $mark['student_id']))->row_array(); ?>
            <tr>
                    <td><?php echo $count++; ?></td>
                    <td><?php echo $this->user_model->get_user_details($student['user_id'], 'name'); ?></td>
                
                    <?php
                      foreach($exs as $bids){
                        foreach($subs as $sub){ 
                        $c =$this->db->get_where('subjects', array('id' => $sub['id']))->row('behavior');
                        $co = $this->db->get_where('mark_behavior_option', array('mark_behavior_id' => $c))->num_rows();

                        $cos =$this->db->get_where('mark_behavior_option', array('mark_behavior_id' => $c))->result_array();
                        if($co == 1){$cs = $co;}else{$cs=$co +1;}
                        $id = $this->crud_model->get_idmarks_average($mark['class_id'], $mark['section_id'], $sub['id'], $bids['id'], $mark['student_id']);
                            if($co == 1){ ?>
                                <td><?php echo $this->crud_model->get_stmarks_average($mark['class_id'], $mark['section_id'], $sub['id'], $bids['id'], $mark['student_id'])->row()->mark_obtained;?></td>
                            <?php }else{
                            foreach($cos as $coss){?>
                              <td><?php echo $this->crud_model->get_bmarks_average($coss['id'], $id);?></td>
                            <?php }   ?>
                              <td><?php echo 
                                    $this->crud_model->get_stmarks_average($mark['class_id'], $mark['section_id'], $sub['id'], $bids['id'], $mark['student_id'])->row()->mark_obtained;?></td>
                            <?php }   ?>
                    <?php } ?>
                    <?php } ?>
                    <?php
                    foreach($exs as $bids){ ?>
                        <td style="background-color: #ccc;"> <?php echo $this->crud_model->get_subdiv_average($class_id, $section_id, $bids['id'], $mark['student_id'])->row()->total_mark; ?></td>
                        <td style="text-align:center;"><?php echo $this->crud_model->get_subdiv_average($class_id, $section_id, $bids['id'], $mark['student_id'])->row()->total_coef;?></td>
                        <td style="background-color: #ccc;"><?php echo $this->crud_model->get_subdiv_average($class_id, $section_id, $bids['id'], $mark['student_id'])->row()->average;?></td>
                    <?php } ?>
                        <td style="background-color: #ccc;"><?php echo $this->crud_model->get_div_average($class_id, $section_id, $exam_id, $mark['student_id'])->row()->total_mark;?></td>
                        <td style="text-align:center;"><?php echo $this->crud_model->get_div_average($class_id, $section_id, $exam_id, $mark['student_id'])->row()->total_coef;?></td>
                        <td style="background-color: #ccc;"><?php echo $this->crud_model->get_div_average($class_id, $section_id, $exam_id, $mark['student_id'])->row()->average;?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php }else{ ?>
    <table class="table table-bordered table-responsive-sm" width="100%"  style="overflow: auto; white-space: nowrap;">
        <thead class="thead-dark">
            <?php 
                  $exs =$this->db->get_where('exam_option', array('exam_id' => $exam_id))->result_array();
            ?>
            
            <tr style="text-align : center;">
                <th><i class="mdi mdi-sort-descending"></i></th>
                <th><?php echo get_phrase('exams'); ?> <i class="mdi mdi-arrow-right-bold-circle"></i></th>
                <?php
                   foreach($exs as $bids){
                    $nn=0;
                        $c =$this->db->get_where('subjects', array('id' => $subject_id))->row('behavior');
                        $co =$this->db->get_where('mark_behavior_option', array('mark_behavior_id' => $c))->num_rows();
                        if($co == 1){$nn+= $co;}else{$nn+=$co +1;}
                    ?>
                     <th colspan="<?php echo $nn; ?>"><?php echo $bids['name']; ?></th>
                <?php } ?>
                <th colspan="3"><?php echo get_phrase('total'); ?></th>
            </tr>
            
            
            <tr style="text-align : center;">
                <th>#</th>
                <th><?php echo get_phrase('student_names'); ?></th>
                <?php
                foreach($exs as $bids){ 
                    $c =$this->db->get_where('subjects', array('id' => $subject_id))->row('behavior');
                    $co = $this->db->get_where('mark_behavior_option', array('mark_behavior_id' => $c))->num_rows();
                      
                    $cos =$this->db->get_where('mark_behavior_option', array('mark_behavior_id' => $c))->result_array();
                    if($co == 1){$cs = $co;}else{$cs=$co +1;}
                    
                        if($co == 1){ ?>
                             <th><?php echo get_phrase('mark'); ?></th>
                        <?php }else{
                        foreach($cos as $coss){?>
                          <th><?php echo $coss['name_fr']; ?></th>
                        <?php }   ?>
                          <th><?php echo get_phrase('total'); ?></th>
                        <?php }   ?>
                <?php } ?>
                <th><?php echo get_phrase('coef'); ?></th>
                <th><?php echo get_phrase('average'); ?></th>
            </tr>
        </thead> 
        <tbody>
        <?php 
              $exs =$this->db->get_where('exam_option', array('exam_id' => $exam_id))->result_array();
            $count = 1; 
            foreach($marks as $mark):
            $student = $this->db->get_where('students', array('id' => $mark['student_id']))->row_array(); ?>
            <tr>
                    <td><?php echo $count++; ?></td>
                    <td><?php echo $this->user_model->get_user_details($student['user_id'], 'name'); ?></td>
                
                    <?php
                      foreach($exs as $bids){
                        $c =$this->db->get_where('subjects', array('id' => $subject_id))->row('behavior');
                        $co = $this->db->get_where('mark_behavior_option', array('mark_behavior_id' => $c))->num_rows();
                        $cos =$this->db->get_where('mark_behavior_option', array('mark_behavior_id' => $c))->result_array();
                          
                        if($co == 1){$cs = $co;}else{$cs=$co +1;}
                        $id = $this->crud_model->get_idmarks_average($mark['class_id'], $mark['section_id'], $subject_id, $bids['id'], $mark['student_id']);
                          
                            if($co == 1){ ?>
                                <td><?php echo $this->crud_model->get_stmarks_average($mark['class_id'], $mark['section_id'], $subject_id, $bids['id'], $mark['student_id'])->row()->mark_obtained;?></td>
                            <?php }else{
                            foreach($cos as $coss){?>
                              <td><?php echo $this->crud_model->get_bmarks_average($coss['id'], $id);?></td>
                            <?php }   ?>
                              <td><?php echo $this->crud_model->get_stmarks_average($mark['class_id'], $mark['section_id'], $subject_id, $bids['id'], $mark['student_id'])->row()->mark_obtained;;?></td>
                            <?php }   ?>
                    <?php } ?>
                
                    <td style="background-color: #ccc;"><?php echo $this->crud_model->get_subject_average($mark['class_id'], $mark['section_id'], $subject_id, $exam_id, $mark['student_id'])->row()->coef; ?></td>
                    <td><?php echo $this->crud_model->get_subject_average($mark['class_id'], $mark['section_id'], $subject_id, $exam_id, $mark['student_id'])->row()->mark_obtained; ?></td>
                    
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <?php } ?>
<?php else: ?>
<?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>

<script>
    function get_grade(exam_mark, id){
        $.ajax({
            url : '<?php echo route('get_grade'); ?>/'+exam_mark,
            success : function(response){
                $('#grade-for-'+id).text(response);
            }
        });
    }
</script>
