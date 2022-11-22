<div class="row mb-3">
    <div class="col-md-4"></div>
    <div class="col-md-12 toll-free-box text-center text-white pb-2" style="background-color: #6c757d; border-radius: 10px;">
        <h4><?php echo get_phrase('manage_marks'); ?></h4>
        <span><?php echo get_phrase('class'); ?> : <?php echo $this->db->get_where('classes', array('id' => $class_id))->row('name'); ?></span><br>
        <span><?php echo get_phrase('section'); ?> : <?php echo $this->db->get_where('sections', array('id' => $section_id))->row('name'); ?></span><br>
        <span><?php echo get_phrase('subject'); ?> : <?php echo $this->db->get_where('subjects', array('id' => $subject_id))->row('name'); ?></span>
    </div>
</div>
<?php
$school_id = school_id();
$marks = $this->crud_model->get_marks($class_id, $section_id, $subject_id, $exam_id)->result_array();
?>
<?php if (count($marks) > 0): ?>
    <table class="table table-bordered table-responsive-sm" width="100%">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th><?php echo get_phrase('student_name'); ?></th>
                <?php 
                  $bid=$this->db->get_where('subjects', array('id' => $subject_id))->row('behavior');
                  $bids=$this->db->get_where('mark_behavior_option', array('mark_behavior_id' => $bid))->result_array();
                  foreach($bids as $bids){?>
                    <th><?php echo $bids['name']; ?></th>
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
                $student = $this->db->get_where('students', array('id' => $mark['student_id']))->row_array(); ?>
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
                    <td><span id="final-<?php echo $mark['student_id']; ?>"><?php echo $mark['mark_obtained']; ?></span> </td>
                    <td>
                        <select id="comment-<?php echo $mark['student_id']; ?>" name="comment-<?php echo $mark['student_id']; ?>" class="form-control select2" data-toggle = "select2" required>
                            <option value="2"<?php if ($mark['comment'] ==2)echo 'selected';?>><?php echo get_phrase('was_present');?></option>

                            <option value="0"<?php if ($mark['comment'] ==0)echo 'selected';?>><?php echo get_phrase('not_justified_absence');?></option>
                            <option value="1"<?php if ($mark['comment'] ==1)echo 'selected';?>><?php echo get_phrase('justified_absence');?></option>

                        </select>  
                    </td>
                    <!--<td class="text-center"><button id="stu<?php echo $mark['student_id']; ?>" class="btn btn-success" onclick="mark_update('<?php echo $mark['student_id']; ?>')"><i class="mdi mdi-checkbox-marked-circle"></i></button></td>-->
                </tr>
             <?php endforeach; ?>
                <!--
                <tr><td colspan="<?php echo $nbids +5; ?>"><button id="save" class="btn btn-success col-md-12" onclick="mark_update_all('<?php echo $class_id; ?>')"><i class="mdi mdi-checkbox-marked-circle"></i>  <?php echo get_phrase('save_all'); ?></button></td></tr> -->
        </tbody>
    </table>
<?php else: ?>
<?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>

<script>
    
    function hide_button(student, option) {
        mark = $('#mark-' + student + '-' + option).val();
        
        if((mark > 20) ||(mark < 0)){
            
             toastr.warning('<?php echo get_phrase('mark_can_mus_be_positive'); ?>');
             toastr.warning('<?php echo get_phrase('mark_can_must_be_between_0_and_20'); ?>');
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
    
    function filtermark(student, option){
    var exam = $('#exam_id').val();
    var class_id = $('#class_id').val();
    var section_id = $('#section_id').val();
    var subject = $('#subject_id').val();
    if(class_id != "" && section_id != "" && exam != "" && subject != ""){
        $.ajax({
            type: 'POST',
            url: '<?php echo route('get_mark') ?>/'+class_id+'/'+section_id+'/'+subject+'/'+exam+'/'+student,
            success: function(response){
                $('#final-' + student).html(response);
            }
        });
    }else{
        toastr.error('<?php echo get_phrase('please_select_in_all_fields !'); ?>');
    }
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
