<form method="POST" class="d-block ajaxForm" action="<?php echo route('exam/create'); ?>">
    <div class="form-row">
        <?php 
                $n = $this->crud_model->get_schools()->num_rows();
                if ($n > 1){
        ?>
        <div class="form-group col-md-12">
            <label for="school"><?php echo get_phrase('choose_school'); ?></label>
            <select name="school" id="school" class="form-control select2" data-toggle = "select2">
                <option value=""><?php echo get_phrase('choose_school'); ?></option>
                <option value="all"><?php echo get_phrase('all_school'); ?></option>
                <?php
                $schools = $this->crud_model->get_schools()->result_array();
                foreach ($schools as $school): ?>
                <option value="<?php echo $school['id']; ?>"><?php echo $school['name']; ?></option>
              <?php endforeach; ?>
            </select>
        </div> 
        <?php } else{ ?>
            <input type="hidden" class="form-control" name = "school" value="<?php echo school_id(); ?>">
        <?php }?>
         
        <div class="form-group col-md-12">
        <label for="u2"><?php echo get_phrase('school_year'); ?> </label>
            <span class="badge badge-success pt-1" id="active_session"><?php echo active_session("name"); ?></span>
                <select name="session" class="form-control select2" data-toggle="select2">
                    <?php $sessions = $this->db->get_where('sessions', array('status' => 1))->result_array();
                    foreach($sessions as $session):?>
                    <option value="<?php echo $session['id']; ?>" <?php if($session['status'] == 1)echo 'selected'; ?>><?php echo $session['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="starting_date"><?php echo get_phrase('starting_date'); ?></label>
            <input type="text" class="form-control date" id="starting_date" data-toggle="date-picker" data-single-date-picker="true" name = "starting_date" value="<?php echo date('m/d/Y'); ?>" required>
            <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_starting_date'); ?></small>
        </div>

        <div class="form-group col-md-6">
            <label for="ending_date"><?php echo get_phrase('ending_date'); ?></label>
            <input type="text" class="form-control date" id="ending_date" data-toggle="date-picker" data-single-date-picker="true" name = "ending_date"   value="<?php echo date('m/d/Y'); ?>" required>
            <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_ending_date'); ?></small>
        </div>
        
        <div class="form-group col-md-12">
            <label for="nameen"><?php echo get_phrase('year_division_name'); ?> <em>En</em></label>
            <input type="text" class="form-control" id="nameen" name = "nameen" required>
            <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_english_name'); ?></small>
        </div>
        <div class="form-group col-md-12">
            <label for="namefr"><?php echo get_phrase('year_division_name'); ?> <em>Fr</em></label>
            <input type="text" class="form-control" id="namefr" name = "namefr" required>
            <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_french_name'); ?></small>
        </div>
        
        <div class="form-group col-md-6">
            <label for="ensname"><?php echo get_phrase('short_name'); ?> <em>En</em></label>
            <input type="text" class="form-control" id="ensname" name = "ensname" required>
            <small id="sname_help" class="form-text text-muted"><?php echo get_phrase('provide_english_short_name'); ?></small>
        </div>
        <div class="form-group col-md-6">
            <label for="frsname"><?php echo get_phrase('short_name'); ?> <em>Fr</em></label>
            <input type="text" class="form-control" id="frsname" name = "frsname" required>
            <small id="sname_help" class="form-text text-muted"><?php echo get_phrase('provide_french_short_name'); ?></small>
        </div>
        
        <div class="form-group  col-md-12">
            <?php include 'use_sections.php'; ?>
        </div>
        
        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('create_year_division'); ?></button>
        </div>
    </div>
</form>

<script>

var blank_section_field = $('#blank_section').html();

$(document).ready(function() {
    $('#blank_section').hide();
    initSelect2(['#u', '#school']);
});
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllClasses);
});
    
    $("#starting_date" ).daterangepicker();
    $("#ending_date" ).daterangepicker();

function appendSection() {
    $('#section_area').append(blank_section_field);
}

function removeSection(elem) {
    $(elem).closest('.form-row').remove();
}

function classWiseSection(classId) {
    $.ajax({
        url: "<?php echo route('division/list/'); ?>"+classId,
        success: function(response){
            $('#section_id').html(response);
        }
    });
}
</script>
