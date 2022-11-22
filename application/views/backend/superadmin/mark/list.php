<div class="row mb-3">
    <div class="col-md-4"></div>
    <div class="col-md-12 toll-free-box text-center text-white pb-2" style="background-color: #6c757d; border-radius: 10px;"> 
        <h4><?php echo get_phrase('manage_marks'); ?></h4>
        <span><?php echo get_phrase('class'); ?> : <?php echo $this->db->get_where('classes', array('id' => $class_id))->row('name').' - '.$this->db->get_where('sections', array('id' => $section_id))->row('name'); ?></span><br>
        <span><?php echo get_phrase('subject'); ?> : <?php if($subject_id > 0){echo $this->db->get_where('subjects', array('id' => $subject_id))->row('name');}else{echo get_phrase('all');} ?></span>
    </div>
</div>

<div style="overflow: auto; white-space: nowrap; height: 100%;">
<?php 
$school_id = school_id();
$marks = $this->crud_model->get_marks($class_id, $section_id, $subject_id, $exam_id)->result_array();
if($subject_id >0){
    
}
?>

   <?php if($subject_id > 0){ 
   $marks = $this->crud_model->get_marks($class_id, $section_id, $subject_id, $exam_id)->result_array(); ?>
    <?php if (count($marks) > 0): ?>
    <table class="table table-bordered table-responsive-sm" width="100%">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th><?php echo strtoupper(get_phrase('student_name')); ?></th>
                <?php 
                  $bi=$this->db->get_where('subjects', array('id' => $subject_id))->row('behavior');
                  $bidss=$this->db->get_where('mark_behavior_option', array('mark_behavior_id' => $bi))->result_array();
                  foreach($bidss as $bidss){?>
                    <th><?php echo $bidss['name']; ?>
<!--                <input class="form-control" type="number" id="markm-<?php echo $bidss['id']; ?>" name="mark" min="0" step="0.001" value="<?php echo $val; ?>" required onchange="update_button(<?php echo $bidss['id']; ?>)">-->
                </th>
                  <?php } ?>
                <th><?php echo get_phrase('final_mark'); ?></th>
                <th><?php echo get_phrase('justification'); ?></th>
                <!--<th><?php echo get_phrase('action'); ?></th>-->
            </tr>
        </thead> 
        <tbody>   
        <?php 
            $count = 1; 
            foreach($marks as $mark):
                $student = $this->db->get_where('students', array('id' => $mark['student_id']))->row_array();?>
                <tr>
                    <td><?php echo $count++; ?></td>
                    <td><?php echo $this->user_model->get_user_details($student['user_id'], 'name'); ?></td>
                    <?php 
                  $bid=$this->db->get_where('subjects', array('id' => $subject_id))->row('behavior');
                  $bids=$this->db->get_where('mark_behavior_option', array('mark_behavior_id' => $bid))->result_array();
                  $nbids=$this->db->get_where('mark_behavior_option', array('mark_behavior_id' => $bid))->num_rows();
                  foreach($bids as $bids){
                      
                  $val=($this->db->get_where('mark_option', array('behavior_option_id' => $bids['id'], 'mark_id'=>$mark['id']))->row()->mark_obtained * 100)/$bids['percentage'];
                    if (($val==0) &&($mark['coef'] ==0)){$val='';}?>
                    <td> 
                        <input class="form-control" type="number" id="mark-<?php echo $mark['student_id']; ?>-<?php echo $bids['id']; ?>" name="mark" placeholder="<?php echo get_phrase('between_0_and_20'); ?>" min="0" max="20" step="0.001" value="<?php echo $val; ?>" required onchange="hide_button(<?php echo $mark['student_id']; ?>, <?php echo $bids['id']; ?>)">
                    <small style="display:none; color:red;" id="stu<?php echo $mark['student_id']; ?>-<?php echo $bids['id']; ?>" ><?php echo get_phrase('between_0_and_20'); ?></small>
                    </td> 
                    <?php } ?>
                    
                    <td><span <?php if($mark['mark_obtained'] < 10) { ?> style="color:red;" <?php } ?>  id="final-<?php echo $mark['student_id']; ?>"><?php echo $mark['mark_obtained']; ?></span> </td>
                    
                    
                    <td>
                        <select id="comment-<?php echo $mark['student_id']; ?>" name="comment-<?php echo $mark['student_id']; ?>" class="form-control select2" data-toggle = "select2" required  onchange="hide_button(<?php echo $mark['student_id']; ?>, <?php echo $bids['id']; ?>)">
                            <option value="2"<?php if ($mark['comment'] ==2)echo 'selected';?>><?php echo get_phrase('was_present');?></option>

                            <option value="0"<?php if ($mark['comment'] ==0)echo 'selected';?>><?php echo get_phrase('not_justified_absence');?></option>
                            <option value="1"<?php if ($mark['comment'] ==1)echo 'selected';?>><?php echo get_phrase('justified_absence');?>/<?php echo get_phrase('not_applicable');?></option>

                        </select> 
                    </td>
                    
                    
                </tr>
             <?php endforeach; ?>
                <!--
                <tr><td colspan="<?php echo $nbids +5; ?>"><button id="save" class="btn btn-success col-md-12" onclick="mark_update_all('<?php echo $class_id; ?>')"><i class="mdi mdi-checkbox-marked-circle"></i>  <?php echo get_phrase('save_all'); ?></button></td></tr> -->
        </tbody>
    </table>
    <?php else: ?>
    <?php include APPPATH.'views/backend/empty.php'; ?>
    <?php endif; ?>
   <?php }
elseif($subject_id == "all"){
     $this->db->order_by("name", "asc");
     $marks = $this->db->get_where('enrols', array('class_id' => $class_id, 'section_id' => $section_id, 'school_id' => $school_id, 'session' => active_session()))->result_array();
    
    $subs =$this->db->get_where('subjects', array('class_id' => $class_id,'section_id' => $section_id,'school_id' => school_id(),'session' => active_session()))->result_array();
 ?>
    <?php if (count($marks) > 0): ?>
    <table class="table table-bordered table-responsive-sm" width="100%" style="overflow: auto; white-space: nowrap;">
        <thead class="thead-dark">
            <tr>
                <th style="position: sticky; left:0; width:10px;">#</th>
                <th style="left:0px; position: sticky; background-color:#6c757d;z-index:20;color:#fff; font-style:bold;"><?php echo strtoupper(get_phrase('student_name')); ?></th>
                <?php 
                foreach($subs as $sub){ ?>  
                    <th><?php echo $sub['name']; ?>(*<?php echo $sub['coef']; ?>)</th>
                  <?php } ?>
                <th style="right:150px; position: sticky;z-index:20; width:40px; background-color:#6c757d;color:#fff;"><?php echo get_phrase('total_mark'); ?></th>
                <th style="right:70px; position: sticky;z-index:20; width:40px;"><?php echo get_phrase('total_coef'); ?></th>
                <th style="right:0px; position: sticky;z-index:20; background-color:#6c757d;color:#fff;"><?php echo get_phrase('average'); ?></th>
            </tr>
        </thead> 
        <tbody>   
        <?php
            $count = 1; $val="";
            foreach($marks as $mark):
                $student = $this->db->get_where('students', array('id' => $mark['student_id']))->row_array();?>
                <tr>
                    <td style="left:0px;position: sticky;width:10px;"><?php echo $count++; ?></td>
                    <td style="left:0px; position: sticky; background-color:#6c757d;color:#fff; font-style:bold;z-index:20; "><?php echo $this->user_model->get_user_details($student['user_id'], 'name'); ?></td>
                    <?php 
                  foreach($subs as $sub){ 
                  $bid=$this->db->get_where('subjects', array('id' => $sub['id']))->row('behavior');
                      
                  $mid = $this->db->get_where('marks', array('subject_id' => $sub['id'],'student_id' => $mark['student_id'], 'class_id' => $class_id,'section_id' => $section_id,'school_id' => school_id(),'session' => active_session(), 'exam_id'=>$exam_id))->row('id');
                      
                    $bids=$this->db->get_where('mark_behavior_option', array('mark_behavior_id' => $bid))->result_array();
                      
                    $nbids=$this->db->get_where('mark_behavior_option', array('mark_behavior_id' => $bid))->num_rows();
                  foreach($bids as $bids){
                  
                  if($mid >0){
                      $val=($this->db->get_where('mark_option', array('behavior_option_id' => $bids['id'], 'mark_id'=>$mid))->row()->mark_obtained * 100)/$bids['percentage'];
                  }
                  
                    if (($val==0) &&($mark['coef'] ==0)){$val='';}?>
                    <td style="min-width:150px; text-align:center;"> 
                        <input class="form-control" type="number" id="mark-<?php echo $mark['student_id']; ?>-<?php echo $sub['id']; ?>-<?php echo $bids['id']; ?>" name="mark" placeholder="<?php echo get_phrase('between_0_and_20'); ?>" min="0" max="20" step="0.001" value="<?php echo $val; ?>" required onchange="hide_buttons(<?php echo $mark['student_id']; ?>, <?php echo $bids['id']; ?>, <?php echo $sub['id']; ?>)">
                    <small style="display:none; color:red;" id="stu<?php echo $mark['student_id']; ?>-<?php echo $bids['id']; ?>" ><?php echo get_phrase('between_0_and_20'); ?></small>
                    </td> 
                    <?php } ?>
                    <?php } ?>
                    
                     <td style="right:150px; position: sticky; background-color:#6c757d;color:#fff; font-style:bold;z-index:20;width:40px; " id="tm-<?php echo $mark['student_id']; ?>" style="background-color: #ccc;"> <?php echo $this->crud_model->get_subdiv_average($class_id, $section_id, $exam_id, $mark['student_id'])->row()->total_mark; ?></td>
                    
                    <td style="right:70px; position: sticky;z-index:20; width:40px;background-color:#fff;" id="tc-<?php echo $mark['student_id']; ?>"><?php echo $this->crud_model->get_subdiv_average($class_id, $section_id, $exam_id, $mark['student_id'])->row()->total_coef;?></td>
                    
                    <td style="right:0px; position: sticky; background-color:#6c757d;color:#fff; font-style:bold;z-index:20; width:30px; " id="av-<?php echo $mark['student_id']; ?>" style="background-color: #ccc;"><?php echo $this->crud_model->get_subdiv_average($class_id, $section_id, $exam_id, $mark['student_id'])->row()->average;?></td>
               
                
                </tr>
             <?php endforeach; ?>
                
        </tbody>
    </table>
    <?php else: ?>
    <?php include APPPATH.'views/backend/empty.php'; ?>
    <?php endif; ?>
   <?php } ?>

    </div>

<script>
    
    function update_button(option) {
        mark = $('#markm-'+ option).val();
        
        if(mark < 0){
             toastr.warning('<?php echo get_phrase('mark_must_be_between_0_and_20'); ?>');
        }else{ 
             toastr.success('<?php echo get_phrase('mark_has_been_updated_successfully'); ?>');
            var class_id = '<?php echo $class_id; ?>';
            var section_id = '<?php echo $section_id; ?>';
            var subject_id = '<?php echo $subject_id; ?>';
            var exam_id = '<?php echo $exam_id; ?>'; 
            
                $.ajax({
                    type : 'POST',
                    url : '<?php echo route('mark/mark_update_max'); ?>',
                    data : {student_id : student, class_id : class_id, section_id : section_id, subject_id : subject_id, exam_id : exam_id, behavior : option},
                    success : function(response){
                        filtermarks(option);
                    }
                });
            
        }
        
    }
    
    function hide_button(student, option) {
        mark = $('#mark-' + student + '-' + option).val();
        
        if((mark > 20) ||(mark < 0)){
            
             toastr.warning('<?php echo get_phrase('mark_must_be_positive'); ?>');
             toastr.warning('<?php echo get_phrase('mark_must_be_between_0_and_20'); ?>');
             toastr.error('<?php echo get_phrase('impossible_to_save'); ?>');
             $('#stu' + student+ '-' + option).show();
             $('#stu' + student).hide();
        }else{ 
             toastr.success('<?php echo get_phrase('mark_has_been_updated_successfully'); ?>');
             $('#stu' + student+ '-' + option).hide();
             $('#stu' + student).show();
            
            var class_id = '<?php echo $class_id; ?>';
            var section_id = '<?php echo $section_id; ?>';
            var subject_id = '<?php echo $subject_id; ?>';
            var exam_id = '<?php echo $exam_id; ?>';
            var mark = $('#mark-' + student + '-' + option).val();   

            var comment = $('#comment-' + student).val();
            if(subject_id != ""){
                $.ajax({
                    type : 'POST',
                    url : '<?php echo route('mark/mark_update'); ?>',
                    data : {student_id : student, class_id : class_id, section_id : section_id, subject_id : subject_id, exam_id : exam_id, mark : mark, comment : comment, behavior : option},
                    success : function(response){
                        filtermark(student, option);
                    }
                });
            }else{
                toastr.error('<?php echo get_phrase('required_mark_field'); ?>');
            }
        }
    }
    
    function hide_buttons(student, option, subject_id) {
        mark = $('#mark-' + student + '-' + subject_id + '-' + option).val();
        
        toastr.warning(student);
             
        toastr.warning(option);
        toastr.error(subject_id);
        if((mark > 20) ||(mark < 0)){
            
             toastr.warning('<?php echo get_phrase('mark_must_be_positive'); ?>');
             toastr.warning('<?php echo get_phrase('mark_must_be_between_0_and_20'); ?>');
             toastr.error('<?php echo get_phrase('impossible_to_save'); ?>');
             $('#stu' + student+ '-' + option).show();
             $('#stu' + student).hide();
        }else{ 
             toastr.success('<?php echo get_phrase('mark_has_been_updated_successfully'); ?>');
             $('#stu' + student+ '-' + option).hide();
             $('#stu' + student).show();
            
            var class_id = '<?php echo $class_id; ?>';
            var section_id = '<?php echo $section_id; ?>';
            var exam_id = '<?php echo $exam_id; ?>';
            var mark = $('#mark-' + student + '-' + subject_id + '-' + option).val();   

            if(subject_id != ""){
                $.ajax({
                    type : 'POST',
                    url : '<?php echo route('mark/mark_update'); ?>',
                    data : {student_id : student, class_id : class_id, section_id : section_id, subject_id : subject_id, exam_id : exam_id, mark : mark, comment : comment, behavior : option},
                    success : function(response){
                        filtermarkc(student, section_id,exam_id,student);
                        filtermarka(student, section_id,exam_id,student);
                        filtermarkt(student, section_id,exam_id,student);
                    }
                });
            }else{
                toastr.error('<?php echo get_phrase('required_mark_field'); ?>');
            }
        }
    }
    
    function filtermark(student, option){
    var exam = $('#exam_id').val();
    var class_id = $('#class_id').val();
    var section_id = $('#section_id').val();
    var subject = $('#subject_id').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo route('get_mark') ?>/'+class_id+'/'+section_id+'/'+subject+'/'+exam+'/'+student,
            success: function(response){
                $('#final-' + student).html(response);
            }
        });
    }
    
    function filtermarkc(student, section_id,exam_id,student){
        $.ajax({
            type: 'POST',
            url: '<?php echo route('get_t_coef') ?>/'+class_id+'/'+section_id+'/'+exam_id+'/'+student,
            success: function(response){
                $('#tc-' + student).html(response);
            }
        });
    } 
    function filtermarka(student, section_id,exam_id,student){
        $.ajax({
            type: 'POST',
            url: '<?php echo route('get_t_average') ?>/'+class_id+'/'+section_id+'/'+exam_id+'/'+student,
            success: function(response){
                $('#av-' + student).html(response);
            }
        });
    } 
    function filtermarkc(student, section_id,exam_id,student){
        $.ajax({
            type: 'POST',
            url: '<?php echo route('get_t_mark') ?>/'+class_id+'/'+section_id+'/'+exam_id+'/'+student,
            success: function(response){
                $('#tm-' + student).html(response);
            }
        });
    }
    
    
    function mark_update(student_id){
        var class_id = '<?php echo $class_id; ?>';
        var section_id = '<?php echo $section_id; ?>';
        var subject_id = '<?php echo $subject_id; ?>';
        var exam_id = '<?php echo $exam_id; ?>';
        <?php 
          $bid=$this->db->get_where('subjects', array('id' => $subject_id))->row('behavior');
          $bids=$this->db->get_where('mark_behavior_option', array('mark_behavior_id' => $bid))->result_array();
          foreach($bids as $bi){?>
            var mark<?php echo $bi['id']; ?> = $('#mark-' + student_id + '-<?php echo $bi['id']; ?>').val(); 
            if(mark<?php echo $bi['id']; ?> > 20){
                toastr.warning('<?php echo get_phrase('mark_can_not_be_higher_than_20'); ?>');
                toastr.error('<?php echo get_phrase('impossible_to_save'); ?>');
            }  else if(mark<?php echo $bi['id']; ?> < 0){
                    toastr.warning('<?php echo get_phrase('mark_can_not_be_positive'); ?>');
                    toastr.error('<?php echo get_phrase('impossible_to_save'); ?>');
                }   
          <?php } ?>
        
        var comment = $('#comment-' + student_id).val();
        if(subject_id != ""){
            $.ajax({
                type : 'POST',
                url : '<?php echo route('mark/mark_update'); ?>',
                data : {student_id : student_id, class_id : class_id, section_id : section_id, subject_id : subject_id, exam_id : exam_id,<?php foreach($bids as $bi){?> mark<?php echo $bi['id']; ?> : mark<?php echo $bi['id']; ?>,<?php } ?> comment : comment},
                success : function(response){
                    toastr.success('<?php echo get_phrase('mark_has_been_updated_successfully'); ?>');
                    filter_attendance();
                }
            });
        }else{
            toastr.error('<?php echo get_phrase('required_mark_field'); ?>');
        }
    }
    
    function mark_update_all(class_id){
        var section_id = '<?php echo $section_id; ?>';
        var subject_id = '<?php echo $subject_id; ?>';
        var exam_id = '<?php echo $exam_id; ?>';
        <?php 
          $bid=$this->db->get_where('subjects', array('id' => $subject_id))->row('behavior');
          $bids=$this->db->get_where('mark_behavior_option', array('mark_behavior_id' => $bid))->result_array();
        foreach($marks as $mark){
          foreach($bids as $bi){ ?>
            var mark_<?php echo $mark['student_id']; ?>_<?php echo $bi['id']; ?> = $('#mark-' + <?php echo $mark['student_id']; ?> + '-<?php echo $bi['id']; ?>').val();
        <?php } ?>
            var comment = $('#comment-' + '<?php echo $mark['student_id']; ?>').val();
        <?php } ?>
        if(subject_id != ""){
            $.ajax({
                type : 'POST',
                url : '<?php echo route('mark/mark_update_all'); ?>',
                data : { class_id : class_id, section_id : section_id, subject_id : subject_id, exam_id : exam_id,<?php  foreach($marks as $mark){foreach($bids as $bi){ ?> mark_<?php echo $mark['student_id']; ?>_<?php echo $bi['id']; ?> : mark_<?php echo $mark['student_id']; ?>_<?php echo $bi['id']; ?>, <?php } } ?> comment : comment},
                success : function(response){
                    toastr.success('<?php echo get_phrase('marks_has_been_updated_successfully'); ?>');
                    filter_attendance();
                }
            });
        }else{
            toastr.error('<?php echo get_phrase('required_mark_field'); ?>');
        }
    }

    function get_grade(exam_mark, id){
        $.ajax({
            url : '<?php echo route('get_grade'); ?>/'+exam_mark,
            success : function(response){
                $('#grade-for-'+id).text(response);
            }
        });
    }
</script>
