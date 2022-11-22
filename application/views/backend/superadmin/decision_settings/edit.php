<?php $school_id = school_id(); ?>
<?php $subjects = $this->db->get_where('decisions', array('id' => $param1))->result_array(); ?>
<?php foreach($subjects as $subject){ ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('decision_settings/update/'.$param1); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
          <label for="bt"><?php echo get_phrase('type_of_decision'); ?></label>
          <select name="type" id="bt" class="form-control select2" data-toggle="select2" required onchange="get_form_val(this.value)">
            <option value=""><?php echo get_phrase('choose_settings_to_add'); ?></option>
            <option value="discipline"<?php if($subject['type'] == 'discipline'):?> selected <?php endif; ?>><?php echo get_phrase('discipline_decisions'); ?></option>
            <option value="class_council"<?php if($subject['type'] == 'class_council'):?> selected <?php endif; ?>><?php echo get_phrase('class_council_decisions'); ?></option>
            <option value="school_result"<?php if($subject['type'] == 'school_result'):?> selected <?php endif; ?>><?php echo get_phrase('school_result_decisions'); ?></option>
            <option value="promotion"<?php if($subject['type'] == 'promotion'):?> selected <?php endif; ?>><?php echo get_phrase('school_result_decisions'); ?></option>
          </select>
          <small id="class_help" class="form-text text-muted"><?php echo get_phrase('select_a_type'); ?></small>
        </div>
        <div class="form-group col-md-12" <?php if ($subject['type'] != 'discipline'){?>style="display:none"<?php } ?> id="bd1">
          <label for="opt"><?php echo get_phrase('discipline_option'); ?></label>
          <select class="form-control select2" data-toggle = "select2" name="option" id = "opt" required>
            <option value=""><?php echo get_phrase('select_an_option'); ?></option>
            <?php
            $expense_categories = $this->db->get_where('discipline_option')->result_array();
            foreach ($expense_categories as $ex): ?>
            <option value="<?php echo $ex['id']; ?>"<?php if($subject['option'] == $ex['id']):?> selected <?php endif; ?>><?php echo $ex['name'].' / '.$ex['name_fr']; ?></option>
          <?php endforeach; ?>
        </select>
           <small id="name_help" class="form-text text-muted"><?php echo get_phrase('choose_discipline_option'); ?></small>
      </div>
        
        <div class="form-group col-md-6">
            <label for="mark_from"><?php echo get_phrase('mark_from'); ?></label>
            <input type="number" class="form-control" id="mark_from" name = "mark_from" placeholder="<?php echo get_phrase('from'); ?>" value="<?php echo $subject['from']; ?>" required>
        </div>

        <div class="form-group col-md-6">
            <label for="mark_upto"><?php echo get_phrase('mark_upto'); ?></label>
            <input type="number" class="form-control" id="mark_upto" name = "mark_upto" placeholder="<?php echo get_phrase('mark_upto'); ?>" value="<?php echo $subject['to']; ?>" required>
        </div>
        <div class="form-group col-md-12">
<!--            <h3> <?php echo get_phrase('values_for_passing_classes'); ?> </h3>-->
            <label for="name"><?php echo get_phrase('name'); ?></label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $subject['name']; ?>" required>
            <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_english_name'); ?></small>
        </div>
        <div class="form-group col-md-12">
            <label for="frname"><?php echo get_phrase('name'); ?> <em>Fr</em></label>
            <input type="text" class="form-control" id="frname" name="frname" value="<?php echo $subject['name_fr']; ?>" required>
            <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_french_name'); ?></small>
        </div> 
<!--
        
        <div class="form-group col-md-12">
            <h3> <?php echo get_phrase('values_for_exam_classes'); ?> </h3>
            <label for="name"><?php echo get_phrase('name'); ?></label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $subject['typec']; ?>" required>
            <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_english_name_for_exam_classes'); ?></small>
        </div>
        <div class="form-group col-md-12">
            <label for="frname"><?php echo get_phrase('name'); ?> <em>Fr</em></label>
            <input type="text" class="form-control" id="frname" name="frname" value="<?php echo $subject['typecfr']; ?>" required>
            <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_french_name_for_exam_classes'); ?></small>
        </div> 
-->
        
<!--
        <div class="form-group col-md-12">
            <label for="u"><?php echo get_phrase('kind_of_class'); ?> ?</label>
            <select name="typec" id="typec" class="form-control select2" data-toggle = "select2">
                <option value="0"<?php if($subject['typec'] == 0){ echo 'selected'; } ?>><?php echo get_phrase('not_applicable'); ?></option>
                <option value="1"<?php if($subject['typec'] == 1){ echo 'selected'; } ?>><?php echo get_phrase('exam_class'); ?></option>
            </select>
            <small id="" class="form-text text-muted"><?php echo get_phrase('is_it_exam_class_or_not'); ?> ?</small>
        </div> 
-->

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update'); ?></button>
        </div>
    </div>
</form>
<?php } ?>

<script>
    $(document).ready(function() {
  initSelect2(['#bt','#opt']);
});
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
  var form = $(this);
  ajaxSubmit(e, form, showAllSubjects);
});

$(document).ready(function() {
  initSelect2(['#class_id_on_create']);
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