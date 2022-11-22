<form method="POST" class="d-block ajaxForm" action="<?php echo route('subject_settings/create'); ?>">
  <div class="form-row">

    <input type="hidden" name="school_id" value="<?php echo school_id(); ?>">
    <input type="hidden" name="session" value="<?php echo active_session();?>">

    <div class="form-group col-md-12">
      <label for="class_id_on_create"><?php echo get_phrase('type_of_setting'); ?></label>
      <select name="class_id" id="class_id_on_create" class="form-control select2" data-toggle="select2" required>
        <option value="1"><?php echo get_phrase('subject_group'); ?></option>
        <option value="2"><?php echo get_phrase('subject_type'); ?></option>
        
      </select>
      <small id="class_help" class="form-text text-muted"><?php echo get_phrase('select_a_type'); ?></small>
    </div>

    <div class="form-group col-md-12">
      <label for="name"><?php echo get_phrase('name'); ?><em>En</em></label>
      <input type="text" class="form-control" id="name" name="name" required>
      <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_english_name'); ?></small>
    </div>
    <div class="form-group col-md-12">
      <label for="frname"><?php echo get_phrase('name'); ?><em>Fr</em></label>
      <input type="text" class="form-control" id="frname" name="frname" required>
      <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_french_name'); ?></small>
    </div>
      
    <div class="form-group col-md-12">
      <label for="dname"><?php echo get_phrase('description'); ?><em>En</em></label>
      <input type="text" class="form-control" id="dname" name="dname">
      <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_english_description'); ?></small>
    </div>
    <div class="form-group col-md-12">
      <label for="dfrname"><?php echo get_phrase('description'); ?><em>Fr</em></label>
      <input type="text" class="form-control" id="dfrname" name="dfrname">
      <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_french_description'); ?></small>
    </div>

    <div class="form-group  col-md-12">
      <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('create'); ?></button>
    </div>
  </div>
</form>

<script>
$(document).ready(function() {
  initSelect2(['#class_id_on_create']);
});
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
  var form = $(this);
  ajaxSubmit(e, form, showAllSubjects);
});
</script>
