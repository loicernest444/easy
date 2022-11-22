<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-file-pdf title_icon"></i> <?php echo get_phrase('report_cards'); ?>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>
<div class="row"> 
    <div class="col-12"> 
        <div class="card">
            <div class="row mt-3">
                <div class="col-md-2 mb-1">
                    <select name="exam" id="exam_id" class="form-control select2" data-toggle = "select2" required onchange="wiseExam(this.value)">
                        
                        <option value=""><?php echo get_phrase('choose_year_division'); ?></option>
                        <?php $school_id = school_id();
                        $schools = $this->db->get_where('exams',array('school_id' => $school_id, 'session' => active_session()))->result_array();
                         foreach ($schools as $exam): ?>
                            <option value="<?php echo $exam['id']; ?>"><?php echo $exam['name'].' / '.$exam['name_fr'];?></option>
                        <?php endforeach; ?>
                        <option value="0"><?php echo get_phrase('global_results'); ?></option>
                    </select>
                </div>
                <div class="col-md-2 mb-1">
                    <select name="exam" id="exam" class="form-control select2" data-toggle = "select2" required>
                        <option value=""><?php echo get_phrase('select_exam'); ?></option>
                    </select>
                </div>
                <div class="col-md-2 mb-1">
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
                <div class="col-md-2 mb-1">
                    <select name="section" id="section_id" class="form-control select2" data-toggle = "select2" required>
                        <option value=""><?php echo get_phrase('select_section'); ?></option>
                    </select>
                </div>
                <div class="col-md-2 mb-1">
                    <select name="display" id="display" class="form-control select2" data-toggle = "select2" required>
                        <option value="0"><?php echo get_phrase('do_not_display_subject_groups'); ?></option>
                        <option value="1"><?php echo get_phrase('display_subject_groups'); ?></option>
                    </select>
                </div> 
                
                <div class="col-md-2">
                    <button class="btn btn-block btn-secondary" onclick="filter_attendance()" ><i class="mdi mdi-refresh"></i> <?php echo get_phrase('filter'); ?></button>
                </div>
            </div>
            <div class="card-body mark_content" style="overflow: auto; white-space: nowrap; height: 100%;">
                <div class="empty_box" >
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

function wiseExam(classId) {
    $.ajax({
        url: "<?php echo route('section/lists/'); ?>"+classId,
        success: function(response){
            $('#exam').html(response);
        }
    });
}
function classWiseSection(classId) {
    $.ajax({
        url: "<?php echo route('section/list/'); ?>"+classId,
        success: function(response){
            $('#section_id').html(response);
        }
    });
}

function classWiseSubject(classId) {
    var exam_id = $('#exam_id').val();
    $.ajax({
        url: "<?php echo route('class_wise_subjects/'); ?>"+classId+'/'+exam_id,
        success: function(response){
            $('#subject_id').html(response);
        }
    });
}
    
function filter_attendance(){
    var exam = $('#exam').val();
    var exam_id = $('#exam_id').val();
    var class_id = $('#class_id').val();
    var section_id = $('#section_id').val();
    var display = $('#display').val();
    if(class_id != "" && section_id != "" && exam != "" && exam != ""){
        $.ajax({
            type: 'POST',
            url: '<?php echo route('report_card/list') ?>',
            data: {class_id : class_id, section_id : section_id, exam : exam, exam_id : exam_id, display : display},
            success: function(response){
                $('.mark_content').html(response);
            }
        });
    }else{
        toastr.error('<?php echo get_phrase('please_select_in_all_fields !'); ?>');
    }
}
</script>
