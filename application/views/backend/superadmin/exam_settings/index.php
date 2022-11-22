<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card alert alert-info">
      <div class="card-body">
        <h4 class="page-title">
            <i class="mdi mdi-book-open-page-variant title_icon"></i> <?php echo get_phrase('exam_settings'); ?>
            <span class="badge badge-success pt-1" id="active_session"><?php echo active_session("name"); ?></span>
            <button type="button" class="btn btn-outline-primary alignToTitle" onclick="rightModal('<?php echo site_url('modal/popup/exam_settings/create'); ?>', '<?php echo get_phrase('create_new_division'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_new_year_division'); ?></button>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

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
        var url = '<?php echo route('exam/list'); ?>';

        $.ajax({
            type : 'GET',
            url: url,
            success : function(response) {
                $('.class_content').html(response);
                initDataTable('basic-datatable');
            }
        });
    }
</script>
