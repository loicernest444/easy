<?php if($working_page == 'filter'): ?>
    <!--title-->
    <div class="row d-print-none">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="page-title">
                        <i class="mdi mdi-calendar-today title_icon"></i> <?php echo get_phrase('student'); ?>
                    </h4>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

    <div class="row d-print-none">
        <div class="col-12">
            <div class="card ">
                <div class="card-body">
                 <div class="row justify-content-md-center" style="margin-bottom: 10px;">
                    <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 mb-3 mb-lg-0">
                        <select name="class" id="class_id" class="form-control select2" data-toggle = "select2" required onchange="classWiseSection(this.value)">
                            <option value=""><?php echo get_phrase('select_a_class'); ?></option>
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
                    <div class="col-md-3 mb-1">
                        <select name="section" id="section_id" class="form-control select2" data-toggle = "select2" required>
                            <option value=""><?php echo get_phrase('select_section'); ?></option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-block btn-secondary" onclick="filter_student()" ><?php echo get_phrase('filter'); ?></button>
                    </div>
                </div> 
                <div class="row justify-content-md-center" style="margin-bottom: 10px;">
                      <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 mb-3 mb-lg-0">
                        <button type="button" class="btn btn-icon btn-primary form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><?php echo get_phrase('export_report'); ?></button>
                        <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 37px, 0px);">
                          <a class="dropdown-item" id="export-pdf" href="javascript:0" onclick="getExportUrl('pdf')">PDF</a>
                          <a class="dropdown-item" id="export-print" href="javascript:0" onclick="getExportUrl('print')"><?php echo get_phrase('print'); ?></a>
                          <a class="dropdown-item" id="export-print" href="javascript:0" onclick="getExportUrl('printm')"><?php echo get_phrase('print_for_marks'); ?></a>
                        </div>
                      </div>
                </div>
                </div>
                <div class="card-body student_content">
                    <div class="empty_box">
                        <img class="mb-3" width="150px" src="<?php echo base_url('assets/backend/images/empty_box.png'); ?>" />
                        <br>
                        <span class=""><?php echo get_phrase('no_data_found'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php elseif($working_page == 'create'): ?>
    <?php include 'create.php'; ?>
<?php elseif($working_page == 'edit'): ?>
    <?php include 'update.php'; ?>
<?php endif; ?>

<script>
$('document').ready(function(){

});

function classWiseSection(classId) {
    $.ajax({
        url: "<?php echo route('section/list/'); ?>"+classId,
        success: function(response){
            $('#section_id').html(response);
        }
    });
}
    
function regionDepartment(region) {
    $.ajax({
        url: "<?php echo route('region_department/list/'); ?>"+region,
        success: function(response){
            $('#dep_id').html(response);
        }
    });
}

function filter_student(){
    var class_id = $('#class_id').val();
    var section_id = $('#section_id').val();
    if(class_id != "" && section_id!= ""){
        showAllStudents();
    }else{
        toastr.error('<?php echo get_phrase('please_select_a_class_and_section'); ?>');
    }
}

    
function getExportUrl(type) {
  var url = '<?php echo route('export_student/url'); ?>';
  var class_id = $('#class_id').val();
  var section_id = $('#section_id').val();
  $.ajax({
    type : 'post',
    url: url,
    data : {type : type, class_id : class_id, section_id : section_id},
    success : function(response) {
      if (type == 'csv') {
        window.open(response, '_self');
      }else{
        window.open(response, '_blank');
      }
    }
  });
}
    
    
var showAllStudents = function() {
    var class_id = $('#class_id').val();
    var section_id = $('#section_id').val();
    if(class_id != "" && section_id!= ""){
        $.ajax({
            url: '<?php echo route('student/filter/') ?>'+class_id+'/'+section_id,
            success: function(response){
                $('.student_content').html(response);
            }
        });
    }
}
</script>
