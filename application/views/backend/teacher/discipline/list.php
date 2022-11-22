<div class="row mb-3">
    <div class="col-md-4"></div>
    <div class="col-md-12 toll-free-box text-center text-white pb-2" style="background-color: #6c757d; border-radius: 10px;">
        <span><?php echo get_phrase('class'); ?> : <?php echo $this->db->get_where('classes', array('id' => $class_id))->row('name'); ?></span><br>
        <span><?php echo get_phrase('section'); ?> : <?php echo $this->db->get_where('sections', array('id' => $section_id))->row('name'); ?></span><br>
    </div>
</div>
<?php
$school_id = school_id();
$marks = $this->crud_model->get_discipline($class_id, $section_id, $exam_id)->result_array();
?>
<?php if (count($marks) > 0): ?>
    <table class="table table-bordered table-responsive-sm" width="100%">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th><?php echo get_phrase('student_name'); ?></th>
                <?php 
                  $bids=$this->db->get_where('discipline_option', array('school_id' => school_id(), 'session' => active_session()))->result_array();
                  foreach($bids as $bids){?>
                    <th><?php echo $bids['name']; ?></th>
                  <?php } ?>
                <th><?php echo get_phrase('action'); ?></th>
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
                  $bids=$this->db->get_where('discipline_option', array('school_id' => school_id(), 'session' => active_session()))->result_array();
                  foreach($bids as $bids){
                  $val=($this->db->get_where('discipline_data', array('option_id' => $bids['id'], 'discipline_id'=>$mark['id']))->row()->mark_obtained);?>
                    <td><input class="form-control" type="number" id="mark-<?php echo $mark['student_id']; ?>-<?php echo $bids['id']; ?>" name="mark" placeholder="mark" min="0" step="0.001" value="<?php echo $val; ?>" required onchange="get_grade(this.value, this.id)"></td>
                    <?php } ?>
                    <td class="text-center"><button class="btn btn-success" onclick="mark_update('<?php echo $mark['student_id']; ?>')"><i class="mdi mdi-checkbox-marked-circle"></i></button></td>
                </tr>
             <?php endforeach; ?> 
                <tr><td colspan="<?php echo $nbids +5; ?>"><button class="btn btn-success col-md-12" onclick="mark_update_all('<?php echo $class_id; ?>')"><i class="mdi mdi-checkbox-marked-circle"></i>  <?php echo get_phrase('save_all'); ?></button></td></tr>
        </tbody>
    </table>
<?php else: ?>
<?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>

<script>
    function mark_update(student_id){
        var class_id = '<?php echo $class_id; ?>';
        var section_id = '<?php echo $section_id; ?>';
        var exam_id = '<?php echo $exam_id; ?>';
        <?php 
          $bids=$this->db->get_where('discipline_option', array('school_id' => school_id(), 'session' => active_session()))->result_array();
          foreach($bids as $bi){?>
            var mark<?php echo $bi['id']; ?> = $('#mark-' + student_id + '-<?php echo $bi['id']; ?>').val();   
          <?php } ?>
        var comment = $('#comment-' + student_id).val();
        if(class_id != ""){
            $.ajax({
                type : 'POST',
                url : '<?php echo route('discipline/disciplines_update'); ?>',
                data : {student_id : student_id, class_id : class_id, section_id : section_id, exam_id : exam_id,<?php foreach($bids as $bi){?> mark<?php echo $bi['id']; ?> : mark<?php echo $bi['id']; ?>,<?php } ?> comment : comment},
                success : function(response){
                    toastr.success('<?php echo get_phrase('discipline_data_has_been_updated_successfully'); ?>');
                    filter_attendance();
                }
            });
        }else{
            toastr.error('<?php echo get_phrase('required_class_field'); ?>');
        }
    }
    
    function mark_update_all(class_id){
        var section_id = '<?php echo $section_id; ?>';
        var exam_id = '<?php echo $exam_id; ?>';
        <?php 
        $bids=$this->db->get_where('discipline_option', array('school_id' => school_id(), 'session' => active_session()))->result_array();
        foreach($marks as $mark){
          foreach($bids as $bi){ ?>
            var mark_<?php echo $mark['student_id']; ?>_<?php echo $bi['id']; ?> = $('#mark-' + <?php echo $mark['student_id']; ?> + '-<?php echo $bi['id']; ?>').val();
        <?php } ?>
        <?php } ?>
        if(exam_id != ""){
            $.ajax({
                type : 'POST',
                url : '<?php echo route('discipline/discipline_update_all'); ?>',
                data : { class_id : class_id, section_id : section_id, exam_id : exam_id, <?php  foreach($marks as $mark){ foreach($bids as $bi){ ?> mark_<?php echo $mark['student_id']; ?>_<?php echo $bi['id']; ?> : mark_<?php echo $mark['student_id']; ?>_<?php echo $bi['id']; ?> ,<?php }} ?>},
                success : function(response){
                    toastr.success('<?php echo get_phrase('discipline_has_been_updated_successfully'); ?>');
                    filter_attendance();
                }
            });
        }else{
            toastr.error('<?php echo get_phrase('required_mark_field'); ?>');
        }
    }

    
</script>
