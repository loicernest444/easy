<?php $school_id = school_id(); ?>
<?php $subjects = $this->db->get_where('subject_settings', array('id' => $param1))->result_array(); ?>
<?php foreach($subjects as $subject){ ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('subject_settings/update/'.$param1); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="class"><?php echo get_phrase('type'); ?></label>
            <select name="class_id" id="class_id_on_create" class="form-control select2" data-toggle="select2" required>
                <option value="1" <?php if($subject['type'] ==1){ echo 'selected'; } ?>><?php echo get_phrase('subject_group'); ?></option>
                <option value="2" <?php if($subject['type'] ==2){ echo 'selected'; } ?>><?php echo get_phrase('subject_type'); ?></option>
            </select>
            <small id="class_help" class="form-text text-muted"><?php echo get_phrase('select_a_type'); ?></small>
        </div>

        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('name'); ?></label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $subject['name']; ?>" required>
            <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_english_name'); ?></small>
        </div>
        <div class="form-group col-md-12">
            <label for="frname"><?php echo get_phrase('name'); ?><em>Fr</em></label>
            <input type="text" class="form-control" id="frname" name="frname" value="<?php echo $subject['name_fr']; ?>" required>
            <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_french_name'); ?></small>
        </div>
        
        <div class="form-group col-md-12">
          <label for="dname"><?php echo get_phrase('description'); ?><em>En</em></label>
          <input type="text" class="form-control" id="dname" name="dname" value="<?php echo $subject['description']; ?>">
          <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_english_description'); ?></small>
        </div>
        <div class="form-group col-md-12">
          <label for="dfrname"><?php echo get_phrase('description'); ?><em>Fr</em></label>
          <input type="text" class="form-control" id="dfrname" name="dfrname" value="<?php echo $subject['description_fr']; ?>">
          <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_french_description'); ?></small>
        </div>

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update'); ?></button>
        </div>
    </div>
</form>
<?php } ?>

<script>
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
  var form = $(this);
  ajaxSubmit(e, form, showAllSubjects);
});

$(document).ready(function() {
  initSelect2(['#class_id_on_create']);
});
</script>
