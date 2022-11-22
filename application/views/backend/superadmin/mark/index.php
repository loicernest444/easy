<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card alert alert-info">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-format-list-numbered title_icon"></i> <?php echo get_phrase('manage_marks'); ?>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div> 
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="row mt-3"> 
                
                <div class="col-md-3 mb-1">
                    <small id="" class="form-text text-muted"><?php echo get_phrase('select_exam'); ?></small>
                    <select name="exam" id="exam_id" class="form-control select2" data-toggle = "select2" required onchange="filter_attendanc()">
                        <option value=""><?php echo get_phrase('select_an_exam'); ?></option>
                        <?php $school_id = school_id();
                        $schools = $this->db->get_where('exams',array('school_id' => $school_id, 'session' => active_session()))->result_array();
                         foreach ($schools as $school): ?>
                          <optgroup label="<?php echo $school['name']; ?>">
                            <?php    
                            $exams = $this->db->get_where('exam_option', array('exam_id' => $school['id']))->result_array();
                              
                                foreach($exams as $exam){ ?>
                                    <option value="<?php echo $exam['id']; ?>"><?php echo $exam['name'];?></option>
                               <?php } ?>
                          </optgroup>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3 mb-1">
                    <small id="" class="form-text text-muted"><?php echo get_phrase('select_a_class'); ?></small>
                    <select name="class" id="class_id" class="form-control select2" data-toggle = "select2" required onchange="classWiseSection(this.value)">
                        <option value=""><?php echo get_phrase('select_a_class'); ?></option>
                        <?php
                        $classes = $this->db->get_where('classes', array('school_id' => school_id()))->result_array();
                        foreach($classes as $class){
                            ?>
                            <option value="<?php echo $class['id']; ?>"><?php echo $class['name']; ?></option>
                        <?php } ?>
                         
                    </select> 
                </div>
                <div class="col-md-3 mb-1">
                    <small id="" class="form-text text-muted"><?php echo get_phrase('select_section'); ?></small>
                    <select name="section" id="section_id" class="form-control select2" data-toggle = "select2" required onchange="classWiseSubject(this.value)">
                        <option value=""><?php echo get_phrase('select_section'); ?></option>
                    </select>
                </div>
                <div class="col-md-3 mb-1">
                    <small id="" class="form-text text-muted"><?php echo get_phrase('select_subject'); ?></small>
                    <select name="subject" id="subject_id" class="form-control select2" data-toggle = "select2" required onchange="filter_attendance()">
                        <option value=""><?php echo get_phrase('select_subject'); ?></option>
                    </select>
                </div>
<!-- 
                <div class="col-md-2">
                    <small id="" class="form-text text-muted"><?php echo get_phrase('click_to_display'); ?></small>
                    <button class="btn btn-block btn-secondary" onclick="filter_attendance()" ><?php echo get_phrase('filter'); ?></button>
                </div>
-->
            </div>
            <div class="card-body mark_content" >
                <div class="empty_box">
                    <img class="mb-3" width="150px" src="<?php echo base_url('assets/backend/images/empty_box.png'); ?>" />
                    <br>
                    <span class=""><?php echo get_phrase('no_data_found'); ?></span>
                </div>
            </div>
        </div>
    </div> 
</div> 
  
<script>
$('document').ready(function(){
    initSelect2(['#class_id', '#exam_id', '#section_id', '#subject_id']);
});

function classWiseSection(classId) {
    $.ajax({
        url: "<?php echo route('section/list/'); ?>"+classId,
        success: function(response){
            $('#section_id').html(response);
            classWiseSubject();
        }
    });
}
 
function classWiseSubject() {
    var exam_id = $('#exam_id').val();
    var classId = $('#class_id').val();
    var section_id = $('#section_id').val();
    if(exam_id != ""){
    $.ajax({
        url: "<?php echo route('class_wise_subject/'); ?>"+classId+'/'+section_id+'/'+exam_id,
        success: function(response){
            $('#subject_id').html(response);
            filter_attendance();
        }
    });
    }else{
        toastr.error('<?php echo get_phrase('please_select_the_concerned_exam !'); ?>');
    }
}

    
function filter_attendance(){
    var exam = $('#exam_id').val();
    var class_id = $('#class_id').val();
    var section_id = $('#section_id').val();
    var subject = $('#subject_id').val();
    if(class_id != "" && section_id != "" && exam != "" && subject != ""){
        $.ajax({
            type: 'POST',
            url: '<?php echo route('mark/list') ?>',
            data: {class_id : class_id, section_id : section_id, subject : subject, exam : exam},
            success: function(response){
                $('.mark_content').html(response);
            }
        });
    }else{
        toastr.error('<?php echo get_phrase('please_select_in_all_fields !'); ?>');
    }
}
    
function filter_attendanc(){
    var exam = $('#exam_id').val();
    var class_id = $('#class_id').val();
    var section_id = $('#section_id').val();
    var subject = $('#subject_id').val();
    if(class_id != "" && section_id != "" && exam != "" && subject != ""){
        $.ajax({
            type: 'POST',
            url: '<?php echo route('mark/list') ?>',
            data: {class_id : class_id, section_id : section_id, subject : subject, exam : exam},
            success: function(response){
                $('.mark_content').html(response);
            }
        });
    }else{
        toastr.warning('<?php echo get_phrase('select_class_and_subject_now!'); ?>');
    }
}
    
</script>
