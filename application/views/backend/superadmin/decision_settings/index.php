 <!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card alert alert-info">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-checkbox-marked-circle title_icon"></i> <?php echo get_phrase('school_decisions'); ?><span class="badge badge-success pt-1" id="active_session"><?php echo active_session("name"); ?></span>
          <button type="button" class="btn btn-outline-primary alignToTitle" onclick="rightModal('<?php echo site_url('modal/popup/decision_settings/create'); ?>', '<?php echo get_phrase('create_school_decision'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_new'); ?></button>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="row mt-3">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <select name="class_id" id="class_id" class="form-control select2" data-toggle = "select2" required  onchange="filter_class()">
                        <option value=""><?php echo get_phrase('choose_settings_to_display'); ?></option>
                        <option value="discipline"><?php echo get_phrase('discipline_decisions'); ?></option>
                        <option value="class_council"><?php echo get_phrase('class_council_decisions'); ?></option>
                        <option value="school_result"><?php echo get_phrase('school_result_decisions'); ?></option>
                        <option value="promotion"><?php echo get_phrase('promotion_decisions'); ?></option>
                    </select>
                </div>
<!--
                <div class="col-md-2">
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
        toastr.error('<?php echo get_phrase('please_select_a_type'); ?>');
    }
}

var showAllSubjects = function () {
    var class_id = $('#class_id').val();
    if(class_id != ""){
        $.ajax({
            url: '<?php echo route('decision_settings/list/') ?>'+class_id,
            success: function(response){
                $('.subject_content').html(response);
            }
        });
    }
}
</script>
 