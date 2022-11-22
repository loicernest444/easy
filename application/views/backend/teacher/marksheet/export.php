<div class="row mb-3">
        <h4><?php echo get_phrase('student_marksheets  '); ?>
        <span><?php echo get_phrase('class'); ?> : <?php echo $this->db->get_where('classes', array('id' => $class_id))->row('name').' '.$this->db->get_where('sections', array('id' => $section_id))->row('name'); ?></span></h4><br>
        
        <?php if($subject_id > 0){?>
        <span><?php echo get_phrase('subject'); ?> : <?php echo $this->db->get_where('subjects', array('id' => $subject_id))->row('name'); ?></span><br>
        <?php } ?>
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
    <table width="100%"  style="border-collapse: collapse; font-size:9px">
        <thead>
            <?php 
                  $subs =$this->db->get_where('subjects', array('class_id' => $class_id,'section_id' => $section_id,'school_id' => school_id(),'session' => active_session()))->result_array();
    
                  $exs =$this->db->get_where('exam_option', array('exam_id' => $exam_id))->result_array();
                  $nnexs =$this->db->get_where('exam_option', array('exam_id' => $exam_id))->num_rows();
                  $tcol = ($nnexs * 3) +3;
            ?>
            
            <tr style="text-align : center;" style="border : 1px solid black; color: #000; background-color : #ccc; text-align : center;">
                <th colspan="2" style="border : 1px solid black; color: #000; background-color : #ccc; text-align : center;"><?php echo get_phrase('exams'); ?> <i class="mdi mdi-arrow-right-bold-circle"></i></th>
                <?php
                   foreach($exs as $bids){
                    $nn=0;
                    foreach($subs as $sub){ 
                        $c =$this->db->get_where('subjects', array('id' => $sub['id']))->row('behavior');
                        $co =$this->db->get_where('mark_behavior_option', array('mark_behavior_id' => $c))->num_rows();
                        if($co == 1){$nn+= $co;}else{$nn+=$co +1;}
                    }?>
                     <th colspan="<?php echo $nn; ?>" style="border : 1px solid black; color: #000; background-color : #ccc; text-align : center;"><?php echo $bids['name']; ?></th>
                <?php } ?>
                <th style="border : 1px solid black; color: #000; background-color : #ccc; text-align : center;" colspan="<?php echo $tcol; ?>"><?php echo get_phrase('total'); ?></th>
            </tr>
            
            <tr  style="text-align : center;" style="border : 1px solid black; color: #000; background-color : #ccc; text-align : center;">
                <th colspan="2" style="border : 1px solid black; color: #000; background-color : #ccc; text-align : center;"><?php echo get_phrase('subjects'); ?> <i class="mdi mdi-arrow-right-bold-circle"></i></th>
                <?php
                foreach($exs as $bids){
                    foreach($subs as $sub){ 
                    $c =$this->db->get_where('subjects', array('id' => $sub['id']))->row('behavior');
                    $co =$this->db->get_where('mark_behavior_option', array('mark_behavior_id' => $c))->num_rows();
                    if($co == 1){$cs = $co;}else{$cs=$co +1;}
                    ?>
                     <th style="border : 1px solid black; color: #000; background-color : #ccc; text-align : center;" colspan="<?php echo $cs; ?>"><?php echo $sub['short_name']; ?></th>
                <?php } } ?>
                <?php foreach($exs as $bids){ ?>
                    <th style="border : 1px solid black; color: #000; background-color : #ccc; text-align : center;" colspan="3"><?php echo $bids['name']; ?></th>
                <?php } ?>
                  <th style="border : 1px solid black; color: #000; background-color : #ccc; text-align : center;" colspan="3"><?php echo get_phrase('total'); ?></th>
            </tr> 
            
            <tr style="text-align : center;" style="border : 1px solid black; color: #000; background-color : #ccc; text-align : center;">
                <th style="border : 1px solid black; color: #000; background-color : #ccc; text-align : center;">#</th>
                <th style="border : 1px solid black; color: #000; background-color : #ccc; text-align : center;"><?php echo get_phrase('student_names'); ?></th>
                <?php
                foreach($exs as $bids){
                  foreach($subs as $sub){ 
                    $c =$this->db->get_where('subjects', array('id' => $sub['id']))->row('behavior');
                    $co = $this->db->get_where('mark_behavior_option', array('mark_behavior_id' => $c))->num_rows();
                      
                    $cos =$this->db->get_where('mark_behavior_option', array('mark_behavior_id' => $c))->result_array();
                    if($co == 1){$cs = $co;}else{$cs=$co +1;}
                    
                        if($co == 1){ ?>
                            <th style="border : 1px solid black; color: #000; background-color : #ccc; text-align : center;"><?php echo get_phrase('mark'); ?></th>
                        <?php }else{
                        foreach($cos as $coss){?>
                          <th style="border : 1px solid black; color: #000; background-color : #ccc; text-align : center;"><?php echo $coss['name_fr']; ?></th>
                        <?php }   ?>
                          <th style="border : 1px solid black; color: #000; background-color : #ccc; text-align : center;"><?php echo get_phrase('total'); ?></th>
                        <?php }   ?>
                <?php } ?>
                <?php } ?>
                <?php
                foreach($exs as $bids){ ?>
                    <th style="border : 1px solid black; color: #000; background-color : #ccc; text-align : center;"><?php echo get_phrase('mark'); ?></th>
                    <th style="border : 1px solid black; color: #000; background-color : #ccc; text-align : center;"><?php echo get_phrase('coef'); ?></th>
                    <th style="border : 1px solid black; color: #000; background-color : #ccc; text-align : center;"><?php echo get_phrase('average'); ?></th>
                <?php } ?>
                <th style="border : 1px solid black; color: #000; background-color : #ccc; text-align : center;"><?php echo get_phrase('mark'); ?></th>
                    <th style="border : 1px solid black; color: #000; background-color : #ccc; text-align : center;"><?php echo get_phrase('coef'); ?></th>
                    <th style="border : 1px solid black; color: #000; background-color : #ccc; text-align : center;"><?php echo get_phrase('average'); ?></th>
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
                    <td style="border : 1px solid black; color: #000; text-align : center;"><?php echo $count++; ?></td>
                    <td style="border : 1px solid black; color: #000; "><?php echo $this->user_model->get_user_details($student['user_id'], 'name'); ?></td>
                
                    <?php
                      foreach($exs as $bids){ 
                        foreach($subs as $sub){ 
                        $c =$this->db->get_where('subjects', array('id' => $sub['id']))->row('behavior');
                        $co = $this->db->get_where('mark_behavior_option', array('mark_behavior_id' => $c))->num_rows();

                        $cos =$this->db->get_where('mark_behavior_option', array('mark_behavior_id' => $c))->result_array();
                        if($co == 1){$cs = $co;}else{$cs=$co +1;}
                        $id = $this->crud_model->get_idmarks_average($mark['class_id'], $mark['section_id'], $sub['id'], $bids['id'], $mark['student_id']);
                            if($co == 1){ ?>
                                <td style="border : 1px solid black; color: #000; text-align : center;"><?php echo $this->crud_model->get_stmarks_average($mark['class_id'], $mark['section_id'], $sub['id'], $bids['id'], $mark['student_id']);?></td>
                            <?php }else{
                            foreach($cos as $coss){?>
                              <td style="border : 1px solid black; color: #000; text-align : center;"><?php echo $this->crud_model->get_bmarks_average($coss['id'], $id);?></td>
                            <?php }   ?>
                              <td style="border : 1px solid black; color: #000; text-align : center;"><?php echo 
                                    $this->crud_model->get_stmarks_average($mark['class_id'], $mark['section_id'], $sub['id'], $bids['id'], $mark['student_id'])->row()->mark_obtained;?></td>
                            <?php }   ?>
                    <?php } ?>
                    <?php } ?>
                    <?php
                    foreach($exs as $bids){ ?>
                        <td style="background-color: #ccc;border : 1px solid black; color: #000; text-align : center;"> <?php echo $this->crud_model->get_subdiv_average($class_id, $section_id, $bids['id'], $mark['student_id'])->row()->total_mark; ?></td>
                        <td style="border : 1px solid black; text-align : center;"><?php echo $this->crud_model->get_subdiv_average($class_id, $section_id, $bids['id'], $mark['student_id'])->row()->total_coef;?></td>
                        <td style="background-color: #ccc; border : 1px solid black; color: #000; text-align : center;"><?php echo $this->crud_model->get_subdiv_average($class_id, $section_id, $bids['id'], $mark['student_id'])->row()->average;?></td>
                    <?php } ?>
                        <td  style="background-color: #ccc;border : 1px solid black; color: #000; text-align : center;"><?php echo $this->crud_model->get_div_average($class_id, $section_id, $exam_id, $mark['student_id'])->row()->total_mark;?></td>
                        <td  style="border : 1px solid black;text-align : center;"><?php echo $this->crud_model->get_div_average($class_id, $section_id, $exam_id, $mark['student_id'])->row()->total_coef;?></td>
                        <td  style="background-color: #ccc;border : 1px solid black; color: #000; text-align : center;"><?php echo $this->crud_model->get_div_average($class_id, $section_id, $exam_id, $mark['student_id'])->row()->average;?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php }else{ ?>
    <table width="100%" style="border-collapse: collapse; font-size:9px">
        <thead class="thead-dark">
            <?php 
                  $exs =$this->db->get_where('exam_option', array('exam_id' => $exam_id))->result_array();
            ?>
            
            <tr style="text-align : center;" style="border : 1px solid black; color: #000; background-color : #ccc; text-align : center;">
                <th colspan="2" style="border : 1px solid black; color: #000; background-color : #ccc; text-align : center;"><?php echo get_phrase('exams'); ?> <i class="mdi mdi-arrow-right-bold-circle"></i></th>
                <?php
                   foreach($exs as $bids){
                    $nn=0;
                        $c =$this->db->get_where('subjects', array('id' => $subject_id))->row('behavior');
                        $co =$this->db->get_where('mark_behavior_option', array('mark_behavior_id' => $c))->num_rows();
                        if($co == 1){$nn+= $co;}else{$nn+=$co +1;}
                    ?>
                     <th  style="border : 1px solid black; color: #000; background-color : #ccc; text-align : center;" colspan="<?php echo $nn; ?>"><?php echo $bids['name']; ?></th>
                <?php } ?>
                <th  style="border : 1px solid black; color: #000; background-color : #ccc; text-align : center;" colspan="2"><?php echo get_phrase('total'); ?></th>
            </tr>
            
            
            <tr  style="text-align : center;" style="border : 1px solid black; color: #000; background-color : #ccc; text-align : center;">
                <th style="border : 1px solid black; color: #000; background-color : #ccc; text-align : center;">#</th>
                <th style="border : 1px solid black; color: #000; background-color : #ccc; text-align : center;"><?php echo get_phrase('student_names'); ?></th>
                <?php
                foreach($exs as $bids){ 
                    $c =$this->db->get_where('subjects', array('id' => $subject_id))->row('behavior');
                    $co = $this->db->get_where('mark_behavior_option', array('mark_behavior_id' => $c))->num_rows();
                      
                    $cos =$this->db->get_where('mark_behavior_option', array('mark_behavior_id' => $c))->result_array();
                    if($co == 1){$cs = $co;}else{$cs=$co +1;}
                    
                        if($co == 1){ ?>
                            <th style="border : 1px solid black; color: #000; background-color : #ccc; text-align : center;"><?php echo get_phrase('mark'); ?></th>
                        <?php }else{
                        foreach($cos as $coss){?>
                          <th style="border : 1px solid black; color: #000; background-color : #ccc; text-align : center;"><?php echo $coss['name_fr']; ?></th>
                        <?php }   ?>
                          <th style="border : 1px solid black; color: #000; background-color : #ccc; text-align : center;"><?php echo get_phrase('total'); ?></th>
                        <?php }   ?>
                <?php } ?>
                <th style="border : 1px solid black; color: #000; background-color : #ccc; text-align : center;"><?php echo get_phrase('coef'); ?></th>
                <th style="border : 1px solid black; color: #000; background-color : #ccc; text-align : center;"><?php echo get_phrase('average'); ?></th>
            </tr>
        </thead> 
        <tbody>
        <?php 
              $exs =$this->db->get_where('exam_option', array('exam_id' => $exam_id))->result_array();
            $count = 1; 
            foreach($marks as $mark):
            $student = $this->db->get_where('students', array('id' => $mark['student_id']))->row_array(); ?>
            <tr>
                    <td style="border : 1px solid black; text-align : center;"><?php echo $count++; ?></td>
                    <td style="border : 1px solid black; text-align : center;"><?php echo $this->user_model->get_user_details($student['user_id'], 'name'); ?></td>
                
                    <?php
                      foreach($exs as $bids){
                        $c =$this->db->get_where('subjects', array('id' => $subject_id))->row('behavior');
                        $co = $this->db->get_where('mark_behavior_option', array('mark_behavior_id' => $c))->num_rows();
                        $cos =$this->db->get_where('mark_behavior_option', array('mark_behavior_id' => $c))->result_array();
                          
                        if($co == 1){$cs = $co;}else{$cs=$co +1;}
                        $id = $this->crud_model->get_idmarks_average($mark['class_id'], $mark['section_id'], $subject_id, $bids['id'], $mark['student_id']);
                          
                            if($co == 1){ ?>
                                <td style="border : 1px solid black; text-align : center;"><?php echo $this->crud_model->get_stmarks_average($mark['class_id'], $mark['section_id'], $subject_id, $bids['id'], $mark['student_id']);?></td>
                            <?php }else{
                            foreach($cos as $coss){?>
                              <td style="border : 1px solid black; text-align : center;text-align : center;"><?php echo $this->crud_model->get_bmarks_average($coss['id'], $id);?></td>
                            <?php }   ?>
                              <td style="border : 1px solid black; text-align : center;"><?php echo $this->crud_model->get_stmarks_average($mark['class_id'], $mark['section_id'], $subject_id, $bids['id'], $mark['student_id'])->row()->mark_obtained;?></td>
                            <?php }   ?>
                    <?php } ?>
                
                    <td style="border : 1px solid black; background-color: #ccc;"><?php echo $this->crud_model->get_subject_average($mark['class_id'], $mark['section_id'], $subject_id, $exam_id, $mark['student_id'])->row()->coef; ?></td>
                    <td style="border : 1px solid black; text-align : center;"><?php echo $this->crud_model->get_subject_average($mark['class_id'], $mark['section_id'], $subject_id, $exam_id, $mark['student_id'])->row()->mark_obtained; ?></td>
                    
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
