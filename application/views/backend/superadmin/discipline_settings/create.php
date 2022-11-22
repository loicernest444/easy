<form method="POST" class="d-block ajaxForm" action="<?php echo route('discipline_settings/create'); ?>">
  <div class="form-row">

    <input type="hidden" name="school_id" value="<?php echo school_id(); ?>">
    <input type="hidden" name="session" value="<?php echo active_session();?>">

    <div class="form-group col-md-12">
      <label for="class_id_on_create"><?php echo get_phrase('type_of_setting'); ?></label>
      <select name="type" id="class_id_on_create" class="form-control select2" data-toggle="select2" required onchange="get_form_val(this.value)">
        <option value="1"><?php echo get_phrase('discipline_option'); ?></option>
        <option value="2"><?php echo get_phrase('discipline_decision'); ?></option>
        
      </select>
      <small id="class_help" class="form-text text-muted"><?php echo get_phrase('select_a_type'); ?></small>
    </div>
      
    <div class="form-group row mb-3" id="bd1">
    <div class="col-md-12">
      <label for="name"><?php echo get_phrase('name'); ?> <em>En</em></label>
      <input type="text" class="form-control" id="name" name="sname" required>
      <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_english_name'); ?></small>
    </div>
    <div class="col-md-12">
      <label for="frname"><?php echo get_phrase('name'); ?> <em>Fr</em></label>
      <input type="text" class="form-control" id="frname" name="sfrname" required>
      <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_french_name'); ?></small>
    </div>
    <div class="form-group col-md-12">
      <label for="dname"><?php echo get_phrase('description'); ?> <em>En</em></label>
      <input type="text" class="form-control" id="dname" name="dname" value="">
      <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_english_description'); ?></small>
    </div>
    <div class="form-group col-md-12">
      <label for="dfrname"><?php echo get_phrase('description'); ?> <em>Fr</em></label>
      <input type="text" class="form-control" id="dfrname" name="dfrname" value="">
      <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_french_description'); ?></small>
    </div>
    </div>
    <div class="form-group row mb-3"  style="display:none" id="bd">
       <div class="col-md-12">
          <label for="opt"><?php echo get_phrase('discipline_option'); ?></label>
          <select class="form-control select2" data-toggle = "select2" name="option" id = "opt" required>
            <option value=""><?php echo get_phrase('select_an_option'); ?></option>
            <?php
            $expense_categories = $this->db->get_where('discipline_option')->result_array();
            foreach ($expense_categories as $ex): ?>
            <option value="<?php echo $ex['id']; ?>"><?php echo $ex['name'].' / '.$ex['name_fr']; ?></option>
          <?php endforeach; ?>
        </select>
           <small id="name_help" class="form-text text-muted"><?php echo get_phrase('choose_discipline_option'); ?></small>
      </div>
      <div class="col-md-12">
      <label for="name"><?php echo get_phrase('name'); ?> <em>En</em></label>
      <input type="text" class="form-control" id="name" name="name" required>
      <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_english_name'); ?></small>
    </div>
    <div class="col-md-12">
      <label for="frname"><?php echo get_phrase('name'); ?> <em>Fr</em></label>
      <input type="text" class="form-control" id="frname" name="frname" required>
      <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_french_name'); ?></small>
    </div>
    <div class="col-md-6">
            <label for="mark_from"><?php echo get_phrase('from'); ?></label>
            <input type="number" class="form-control" id="mark_from" name = "mark_from" placeholder="<?php echo get_phrase('mark_from'); ?>" required>
    </div>

    <div class="col-md-6">
        <label for="mark_upto"><?php echo get_phrase('upto'); ?></label>
        <input type="number" class="form-control" id="mark_upto" name = "mark_upto" placeholder="<?php echo get_phrase('upto'); ?>" required>
    </div>
      
    </div>

    <div class="form-group  col-md-12">
      <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('create'); ?></button>
    </div>
  </div>
</form> 

<script>
$(document).ready(function() {
  initSelect2(['#class_id_on_create','#opt']);
});
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
  var form = $(this);
  ajaxSubmit(e, form, showAllSubjects);
});
</script>

<script type="text/javascript">

    function get_form_val(bt) {
        bt = $("#class_id_on_create").val();
        
        if(bt == '1'){
            $("#bd").hide();
            $("#bd1").show();
        }
        else{ 
            $("#bd1").hide();
            $("#bd").show();
    }
}
    

</script>