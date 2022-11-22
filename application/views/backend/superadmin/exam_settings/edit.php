<?php $classes = $this->db->get_where('exams', array('id' => $param1))->result_array(); ?>
<?php foreach($classes as $class){ ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('exam/update/'.$param1); ?>">
    <div class="form-row">
        <div class="form-group col-md-6">
        <label for="starting_date"><?php echo get_phrase('starting_date'); ?></label>
        <input type="text" value="<?php echo date('m/d/Y', $class['starting_date']); ?>" class="form-control date" id="starting_date" data-toggle="date-picker" data-single-date-picker="true" name = "starting_date" required>
        <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_starting_date'); ?></small>
      </div>

      <div class="form-group col-md-6">
        <label for="ending_date"><?php echo get_phrase('ending_date'); ?></label>
        <input type="text" value="<?php echo date('m/d/Y', $class['ending_date']); ?>" class="form-control date" id="ending_date" data-toggle="date-picker" data-single-date-picker="true" name = "ending_date" required>
        <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_ending_date'); ?></small>
      </div>
        <div class="form-group col-md-12">
            <label for="nameen"><?php echo get_phrase('year_division_name'); ?> <em>En</em></label>
            <input type="text" class="form-control" id="nameen" name = "nameen" value="<?php echo $class['name']; ?>" required>
            <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_english_name'); ?></small>
        </div>
        <div class="form-group col-md-12">
            <label for="namefr"><?php echo get_phrase('year_division_name'); ?> <em>Fr</em></label>
            <input type="text" class="form-control" id="namefr" name = "namefr" value="<?php echo $class['name_fr']; ?>" required>
            <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_french_name'); ?></small>
        </div>
        
        <div class="form-group col-md-6">
            <label for="ensname"><?php echo get_phrase('short_name'); ?> <em>En</em></label>
            <input type="text" class="form-control" id="ensname" name = "ensname" value="<?php echo $class['short_name']; ?>"  required>
            <small id="sname_help" class="form-text text-muted"><?php echo get_phrase('provide_english_short_name'); ?></small>
        </div>
        <div class="form-group col-md-6">
            <label for="frsname"><?php echo get_phrase('short_name'); ?> <em>Fr</em></label>
            <input type="text" class="form-control" id="frsname" name = "frsname" value="<?php echo $class['short_name_fr']; ?>"  required>
            <small id="sname_help" class="form-text text-muted"><?php echo get_phrase('provide_french_short_name'); ?></small>
        </div>
         
        <div class="form-group  col-md-12">
            <?php include 'edit_use_sections.php'; ?>
        </div>
        
        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_year_division'); ?></button>
        </div>
    </div>
</form>
<?php } ?>

<script>
  $(".ajaxForm").validate({}); // Jquery form validation initialization
  $(".ajaxForm").submit(function(e) {
      var form = $(this);
      ajaxSubmit(e, form, showAllClasses);
  });
</script>
 