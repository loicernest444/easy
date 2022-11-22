<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card alert alert-info">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-book-open-page-variant title_icon"></i> <?php echo get_phrase('subject'); ?>
          <button type="button" class="btn btn-outline-primary alignToTitle" onclick="rightModal('<?php echo site_url('modal/popup/subject/create'); ?>', '<?php echo get_phrase('create_subject'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_subject'); ?></button>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="row mt-3">
                <div class="col-md-2"></div>
                <div class="col-md-4">
                    <small id="" class="form-text text-muted"><?php echo get_phrase('select_class'); ?></small>
                    <select name="class_id" id="class_id" class="form-control select2" data-toggle = "select2" required onchange="classWiseSection(this.value)">
                        <option value=""><?php echo get_phrase('select_a_class'); ?></option>
                        <?php
                        $classes = $this->db->get_where('classes', array('school_id' => $school_id))->result_array();?>
                        <?php foreach ($classes as $class): ?>
                            <option value="<?php echo $class['id']; ?>"><?php echo $class['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <small id="" class="form-text text-muted"><?php echo get_phrase('select_section'); ?></small>
                    <select name="section" id="section_id" class="form-control select2" data-toggle = "select2" required onchange="showAllSubjects()">
                        <option value=""><?php echo get_phrase('select_section'); ?></option>
                    </select>
                </div>
<!--
                <div class="col-md-3">
                    <button class="btn btn-block btn-secondary" onclick="filter_class()" ><?php echo get_phrase('filter'); ?></button>
                </div>
-->
            </div>
            <div class="card-body subject_content">
                <?php include 'list.php'; ?>
            </div>
        </div>
    </div> 
</div>
 

<script>
function filter_class(){
    var class_id = $('#class_id').val();
    if(class_id != ""){
        showAllSubjects();
    }else{
        toastr.error('<?php echo get_phrase('please_select_a_class'); ?>');
    }
}
    
function classWiseSection(classId) {
    $.ajax({
        url: "<?php echo route('section/list/'); ?>"+classId,
        success: function(response){
            $('#section_id').html(response);
            showAllSubjects();
        }
    });
}
    
var showAllSubjects = function () {
    var class_id = $('#class_id').val();
    var section_id = $('#section_id').val();
    if(class_id != ""){
        $.ajax({
            url: '<?php echo route('subject/list/') ?>'+class_id+'/'+section_id,
            success: function(response){
                $('.subject_content').html(response);
            }
        });
    }
}
</script>
