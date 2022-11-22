<!--title-->
<?php 
$ms = get_settings('multiple_school');
$ns = get_settings('number_of');
$n = $this->crud_model->get_schools()->num_rows();
?>
<div class="row ">
  <div class="col-xl-12">
    <div class="card alert alert-info">
      <div class="card-body">
        <h4 class="page-title">
            <i class="mdi mdi-settings-box title_icon"></i> <?php echo get_phrase('manage_school'); ?>
            <?php if(($n < $ns) && ($ms > 0)){?>
            <button type="button" class="btn btn-outline-primary alignToTitle" onclick="rightModal('<?php echo site_url('modal/popup/school/create'); ?>', '<?php echo get_phrase('create_school'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_school'); ?></button>
            <?php } ?>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<?php $school_data = $this->settings_model->get_current_school_data(); ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body class_content">
                <?php include 'list.php'; ?>
            </div>
        </div>
    </div>
</div>

<script>
    var showAllClasses = function () {
        var url = '<?php echo route('manage_school/list'); ?>';

        $.ajax({
            type : 'GET',
            url: url,
            success : function(response) {
                $('.class_content').html(response);
                initDataTable('basic-datatable');
            }
        });
    }
    
function updateSchoolInfo() {
  $(".schoolForm").validate({});
  $(".schoolForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, reload);
  });
}
    
function reload() {
  setTimeout(
    function()
    {
      location.reload();
    }, 1000);
}
function doNothing() {

}
    
</script>
