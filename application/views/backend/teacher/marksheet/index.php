<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-file-pdf title_icon"></i> <?php echo get_phrase('student_marksheets'); ?>
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
                    <select name="exam" id="exam_id" class="form-control select2" data-toggle = "select2" required>
                        <?php $school_id = school_id();
                        $schools = $this->db->get_where('exams',array('school_id' => $school_id, 'session' => active_session()))->result_array();
                         foreach ($schools as $exam): ?>
                                    <option value="<?php echo $exam['id']; ?>"><?php echo $exam['name'].' / '.$exam['name_fr'];?></option>
                        <?php endforeach; ?>
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
                    <select name="subject" id="subject_id" class="form-control select2" data-toggle = "select2" required>
                        <option value=""><?php echo get_phrase('select_subject'); ?></option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-block btn-secondary" onclick="filter_attendance()" ><?php echo get_phrase('filter'); ?></button>
                </div> 
                <div class="col-md-2">
                    <div class="row justify-content-md-center" style="margin-bottom: 10px;">
                      <div class="col-md-12 col-sm-12 mb-3 mb-lg-0">
                        <button type="button" class="btn btn-icon btn-primary form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><?php echo get_phrase('export'); ?></button>
                        <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 37px, 0px);">
                          <a class="dropdown-item" id="export-pdf" href="javascript:0" onclick="getExportUrl('pdf')">PDF</a>
                          <a class="dropdown-item" id="export-print" href="javascript:0" onclick="getExportUrl('print')"><?php echo get_phrase('print'); ?></a>
                        </div>
                      </div>
                </div>
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

function classWiseSection(classId) {
    $.ajax({
        url: "<?php echo route('section/list/'); ?>"+classId,
        success: function(response){
            $('#section_id').html(response);
            classWiseSubject(classId);
        }
    });
}
       
function getExportUrl(type) {
  var url = '<?php echo route('export_marksheet/url'); ?>';
    var exam = $('#exam_id').val();
    var class_id = $('#class_id').val();
    var section_id = $('#section_id').val();
    var subject = $('#subject_id').val();
  $.ajax({
    type : 'post',
    url: url,
    data : {type : type, class_id : class_id, section_id : section_id, subject : subject, exam : exam},
    success : function(response) {
      if (type == 'csv') {
        window.open(response, '_self');
      }else{
        window.open(response, '_blank');
      }
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
    var exam = $('#exam_id').val();
    var class_id = $('#class_id').val();
    var section_id = $('#section_id').val();
    var subject = $('#subject_id').val();
    if(class_id != "" && section_id != "" && exam != "" && subject != ""){
        $.ajax({
            type: 'POST',
            url: '<?php echo route('marksheet/list') ?>',
            data: {class_id : class_id, section_id : section_id, subject : subject, exam : exam},
            success: function(response){
                $('.mark_content').html(response);
            }
        });
    }else{
        toastr.error('<?php echo get_phrase('please_select_in_all_fields !'); ?>');
    }
}
</script>
