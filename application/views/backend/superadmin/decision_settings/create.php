<form method="POST" class="d-block ajaxForm" action="<?php echo route('decision_settings/create'); ?>">
  <div class="form-row">

    <input type="hidden" name="school_id" value="<?php echo school_id(); ?>">
    <input type="hidden" name="session" value="<?php echo active_session();?>">

    <div class="form-group col-md-12">
      <label for="bt"><?php echo get_phrase('type_of_decision'); ?></label>
      <select name="type" id="bt" class="form-control select2" data-toggle="select2" required onchange="get_form_val(this.value)">
<!--        <option value=""><?php echo get_phrase('choose_settings_to_add'); ?></option>-->
        <option value="discipline"><?php echo get_phrase('discipline_decisions'); ?></option>
        <option value="class_council"><?php echo get_phrase('class_council_decisions'); ?></option>
        <option value="school_result"><?php echo get_phrase('school_result_decisions'); ?></option>
<!--        <option value="promotion"><?php echo get_phrase('promotion_decisions'); ?></option>-->
      </select>
      <small id="class_help" class="form-text text-muted"><?php echo get_phrase('select_a_type'); ?></small>
    </div>
      
    <div class="form-group col-mb-12" id="bd1">
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
    <div class="col-md-6">
            <label for="mark_from"><?php echo get_phrase('from'); ?></label>
            <input type="number" class="form-control" id="mark_from" name = "mark_from" placeholder="<?php echo get_phrase('mark_from'); ?>" required>
    </div>
 
    <div class="col-md-6">
        <label for="mark_upto"><?php echo get_phrase('upto'); ?></label>
        <input type="number" class="form-control" id="mark_upto" name = "mark_upto" placeholder="<?php echo get_phrase('upto'); ?>" required>
    </div>
       
    <div class="form-group row mb-3">
      <div class="col-md-12">
<!--        <h3> <?php echo get_phrase('values_for_passing_classes'); ?> </h3>-->
      <label for="name"><?php echo get_phrase('name'); ?> <em>En</em></label>
      <input type="text" class="form-control" id="name" name="name" required>
      <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_english_name'); ?></small>
    </div>
    <div class="col-md-12">
      <label for="frname"><?php echo get_phrase('name'); ?> <em>Fr</em></label>
      <input type="text" class="form-control" id="frname" name="frname" required>
      <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_french_name'); ?></small>
    </div>
<!--
       
      <div class="col-md-12">
          
        <h3> <?php echo get_phrase('values_for_exam_classes'); ?> </h3>
      <label for="namee"><?php echo get_phrase('name'); ?> <em>En</em></label>
      <input type="text" class="form-control" id="namee" name="namee" required>
      <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_english_name_for_exam_classes'); ?></small>
    </div>
    <div class="col-md-12">
      <label for="frnamee"><?php echo get_phrase('name'); ?> <em>Fr</em></label>
      <input type="text" class="form-control" id="frnamee" name="frnamee" required>
      <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_french_name_for_exam_classes'); ?></small>
    </div>
-->
    

    <div class="form-group  col-md-12">
      <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('create'); ?></button>
    </div>
  </div>
  </div>
</form> 

<script>
$(document).ready(function() {
  initSelect2(['#bt','#opt']);
});
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
  var form = $(this);
  ajaxSubmit(e, form, showAllSubjects);
});
</script>

<script type="text/javascript">

    function get_form_val(bt) {
        bt = $("#bt").val();
        
        if(bt == 'discipline'){
            $("#bd1").show();
        }
        else{ 
            $("#bd1").hide();
    }
}
    

</script>