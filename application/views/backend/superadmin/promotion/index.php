<!-- start page title -->
<div class="row ">
  <div class="col-xl-12">
    <div class="card alert alert-info">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-account-switch title_icon"></i><?php echo get_phrase('student_promotion'); ?>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>
<!-- end page title -->

<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">

        <div class="row justify-content-md-center d-print-none" style="margin-bottom: 10px;">
            <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 mb-3 mb-lg-0">
                <label id=""><?php echo get_phrase('promote_from'); ?></label>
                <select name="class_id_from select2" data-toggle = "select2" id="class_id_from" class="form-control" required onchange="classWiseSection(this.value)">
                    <option value=""><?php echo get_phrase('promoting_from'); ?></option>
                    <?php $classes = $this->db->get_where('classes', array('school_id' => $school_id))->result_array(); ?>
                    <?php foreach($classes as $class){ ?>
                        <?php 
                        if($class['use_sections'] > 0) {
                           if($this->db->get_where('sections', array('class_id' => $class['id']))->num_rows() > 0){ ?>
                            <option value="<?php echo $class['id']; ?>"><?php echo $class['name']; ?></option>
                           <?php } ?>
                        <?php }else{ ?>
                            <option value="<?php echo $class['id']; ?>"><?php echo $class['name']; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select> 
            </div> 
            <div class="col-md-5 mb-1">
                <label id="" class="form-text text-muted">-</label>
                <select name="section" id="section_id" class="form-control select2" data-toggle = "select2" required onchange="filter_student()">
                    <option value=""><?php echo get_phrase('select_section'); ?></option>
                </select>
            </div>
            
            <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 mb-3 mb-lg-0">
                <label id=""><?php echo get_phrase('promote_to'); ?></label>
                <select name="class_id_to" class="form-control select2" data-toggle = "select2" id="class_id_to" required onchange="classWiseSection1(this.value)">
                    <option value=""><?php echo get_phrase('promoting_to'); ?></option>
                    <?php $classes = $this->db->get_where('classes', array('school_id' => $school_id))->result_array(); ?>
                    <?php foreach($classes as $class){ ?>
                        <?php 
                        if($class['use_sections'] > 0) {
                           if($this->db->get_where('sections', array('class_id' => $class['id']))->num_rows() > 0){ ?>
                            <option value="<?php echo $class['id']; ?>"><?php echo $class['name']; ?></option>
                           <?php } ?>
                        <?php }else{ ?>
                            <option value="<?php echo $class['id']; ?>"><?php echo $class['name']; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select> 
            </div>
            <div class="col-md-5 mb-1">
                <label id="" class="form-text text-muted">-</label>
                <select name="section1" id="section_id1" class="form-control select2" data-toggle = "select2" required onchange="filter_student()">
                    <option value=""><?php echo get_phrase('select_section'); ?></option>
                </select>
            </div>
            
          <div class="col-xl-4 col-lg-3 col-md-12 col-sm-12 mb-3 mb-lg-0">
            <label for="session_from"><?php echo get_phrase('previous_session'); ?></label>
            <select class="form-control select2" data-toggle = "select2" id = "session_from" name="session_from">
              <option value=""><?php echo get_phrase('session_from'); ?></option>
              <?php
              $sessions = $this->crud_model->get_session()->result_array();
              foreach ($sessions as $session): ?>
              <option value="<?php echo $session['id']; ?>"><?php echo $session['name']; ?></option>
            <?php endforeach; ?>
          </select>
          </div>

        <div class="col-md-4 mb-lg-0">
          <label for="session_to"><?php echo get_phrase('current_session'); ?></label>
          <select class="form-control select2" data-toggle = "select2" id = "session_to" name="session_to">
            <option value=""><?php echo get_phrase('session_to'); ?></option>
            <?php
            $sessions = $this->crud_model->get_session()->result_array();
            foreach ($sessions as $session): ?>
            <option value="<?php echo $session['id']; ?>"><?php echo $session['name']; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
 
  <div class="col-md-2 mb-lg-0">
    <label for="manage_student" style="color: white;">-</label>
    <button type="button" class="btn btn-icon btn-success form-control" id = "manage_student" onclick="manageStudent()"><?php echo get_phrase('manage_promotion'); ?></button>
  </div>
</div>

<div class="table-responsive-sm student_to_promote_content">
  <?php include 'list.php'; ?>
</div>
</div> <!-- end card body-->
</div> <!-- end card -->
</div><!-- end col-->
</div>

<script type="text/javascript">
$('document').ready(function(){
  initSelect2(['#session_from', '#session_to', '#section_id', '#section_id1', '#class_id_from', '#class_id_to']);
});
    
function classWiseSection(classId) {
    $.ajax({
        url: "<?php echo route('section/list/'); ?>"+classId,
        success: function(response){
            $('#section_id').html(response);
        }
    });
}
    
function classWiseSection1(classId) {
    $.ajax({
        url: "<?php echo route('section/list/'); ?>"+classId,
        success: function(response){
            $('#section_id1').html(response);
        }
    });
}

function manageStudent() {
  var session_from   = $('#session_from').val();
  var session_to     = $('#session_to').val();
  var section_from     = $('#section_id').val();
  var section_to     = $('#section_id1').val();
  var class_id_from  = $('#class_id_from').val();
  var class_id_to    = $('#class_id_to').val();
  if(session_from > 0 && session_to > 0 && class_id_from > 0 && class_id_to > 0 ) {
    var url = '<?php echo route('promotion/list'); ?>';
    $.ajax({
      type : 'POST',
      url: url,
      data : { session_from : session_from,section_from : section_from,section_to : section_to, session_to : session_to, class_id_from : class_id_from, class_id_to : class_id_to, _token : '{{ @csrf_token() }}' },
      success : function(response) {
        $('.student_to_promote_content').html(response);
      }
    });
  }else {
    toastr.error('<?php echo get_phrase('please_make_sure_to_fill_all_the_necessary_fields'); ?>');
  }
}

function enrollStudent(promotion_data, enroll_id) {
  $.ajax({
    type : 'get',
    url: '<?php echo route('promotion/promote/'); ?>'+promotion_data,
    success : function(response) {
      if (response) {
        $("#success_"+enroll_id).show();
        $("#danger_"+enroll_id).hide();
        toastr.success('<?php echo get_phrase('student_promoted_successfully'); ?>');
      }else{
        toastr.error('<?php echo get_phrase('an_error_occured'); ?>');
      }
    }
  });
}

    
function enrollStudentred() {
  var session_from   = $('#session_from').val();
  var session_to     = $('#session_to').val();
  var section_from     = $('#section_id').val();
  var section_to     = $('#section_id1').val();
  var class_id_from  = $('#class_id_from').val();
  var class_id_to    = $('#class_id_to').val();
    $.ajax({
    type : 'POST',
    url: '<?php echo route('promotion/promotered/'); ?>',
    data : { session_from : session_from,section_from : section_from,section_to : section_to, session_to : session_to, class_id_from : class_id_from, class_id_to : class_id_to},
    success : function(response) {
      if (response) {
        $("#prom").show();
        $("#danger_"+enroll_id).hide();
        toastr.success('<?php echo get_phrase('students_enrolled_successfully'); ?>');
      }else{
        toastr.error('<?php echo get_phrase('an_error_occured'); ?>');
      }
    }
  });
} 
function enrollStudentprom() {
  var session_from   = $('#session_from').val();
  var session_to     = $('#session_to').val();
  var section_from     = $('#section_id').val();
  var section_to     = $('#section_id1').val();
  var class_id_from  = $('#class_id_from').val();
  var class_id_to    = $('#class_id_to').val();
    $.ajax({
    type : 'POST',
    url: '<?php echo route('promotion/promoteprom/'); ?>',
    data : { session_from : session_from,section_from : section_from,section_to : section_to, session_to : session_to, class_id_from : class_id_from, class_id_to : class_id_to},
    success : function(response) {
      if (response) {
        $("#prom").show();
        $("#danger_"+enroll_id).hide();
        toastr.success('<?php echo get_phrase('students_promoted_successfully'); ?>');
      }else{
        toastr.error('<?php echo get_phrase('an_error_occured'); ?>');
      }
    }
  });
}
</script>
