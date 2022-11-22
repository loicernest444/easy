
<table width="100%">
    <thead>
        <tr style="background-color: #313a46; color: #fff;">
            <th style="text-align:center;"><h4><?php echo get_phrase('Year_division_exams'); ?></h4></th>
        </tr>
    </thead>
</table><br> 
    <?php $count = 0; ?>
    <?php $sections = $this->db->get_where('exam_option', array('exam_id' => $param1))->result_array(); ?>
    <?php $n = $this->db->get_where('exam_option', array('exam_id' => $param1))->num_rows(); ?>
     
    <?php if($n == 0){ ?>
            <div class="form-row mr-2">
                <div class="form-group col-6">
                    <label><?php echo get_phrase('name'); ?> <em>En</em></label>
                    <input type="text" class="form-control" id="optenname" name = "optenname[]" value="" required>
                </div>
                <div class="form-group col-6">
                    <label><?php echo get_phrase('name'); ?> <em>Fr</em></label>
                    <input type="text" class="form-control" id="optfrname" name = "optfrname[]" value="" required>
                </div>
                <div class="form-group col-5">
                    <label><?php echo get_phrase('short_name'); ?> <em>En</em></label>
                    <input type="text" class="form-control" id="optensname" name = "optensname[]" value="" required>
                </div>
                <div class="form-group col-5">
                    <label><?php echo get_phrase('short_name'); ?> <em>Fr</em></label>
                    <input type="text" class="form-control" id="optfrsname" name = "optfrsname[]" value="" required>
                </div>
                <div class="form-group col-1">
                    <label><em>+/-</em></label>
                    <!-- <button class="btn btn-icon btn-danger" type="button" onclick="deleteSection(this)"><i class="mdi mdi-window-close"></i></button> -->
                    <button class="btn btn-icon btn-success" type="button" onclick="appendSection()"><i class="mdi mdi-plus"></i></button>
                </div>
            </div>
        <?php } ?>

    <?php foreach($sections as $section){
        $count++; ?>
    
        <?php if($count == 1){ ?>
            <div class="form-row mr-2">
                <div class="form-group col-6">
                    <label><?php echo get_phrase('name'); ?> <em>En</em></label>
                    <input type="hidden" class="form-control" id="section" name = "section_id[]" value="<?php echo $section['id']; ?>">
                    <input type="text" class="form-control" id="optenname" name = "optenname[]" value="<?php echo $section['name']; ?>" required>
                </div>
                <div class="form-group col-6">
                    <label><?php echo get_phrase('name'); ?> <em>Fr</em></label>
                    <input type="text" class="form-control" id="optfrname" name = "optfrname[]" value="<?php echo $section['name_fr']; ?>" required>
                </div>
                <div class="form-group col-5">
                    <label><?php echo get_phrase('short_name'); ?> <em>En</em></label>
                    <input type="text" class="form-control" id="optensname" name = "optensname[]" value="<?php echo $section['short_name']; ?>" required>
                </div>
                <div class="form-group col-5">
                    <label><?php echo get_phrase('short_name'); ?> <em>Fr</em></label>
                    <input type="text" class="form-control" id="optfrsname" name = "optfrsname[]" value="<?php echo $section['short_name_fr']; ?>" required>
                </div>
                <div class="form-group col-1">
                    <label><em>+/-</em></label>
                    <!-- <button class="btn btn-icon btn-danger" type="button" onclick="deleteSection(this)"><i class="mdi mdi-window-close"></i></button> -->
                    <button class="btn btn-icon btn-success" type="button" onclick="appendSection()"><i class="mdi mdi-plus"></i></button>
                </div>
            </div>
        <?php } ?>
 
        <?php if($count != 1){ ?>
            <div class="form-row mr-2" id="sectionDatabase<?php echo $section['id']; ?>">
                <div class="form-group col-6">
                    <label><?php echo get_phrase('name'); ?> <em>En</em></label>
                    <input type="hidden" class="form-control" id="section<?php echo $section['id']; ?>" name = "section_id[]" value="<?php echo $section['id']; ?>">
                    <input type="text" class="form-control" id="optenname" name = "optenname[]" value="<?php echo $section['name']; ?>" required>
                </div>
                <div class="form-group col-6">
                    <label><?php echo get_phrase('name'); ?> <em>Fr</em></label>
                    <input type="text" class="form-control" id="optfrname" name = "optfrname[]" value="<?php echo $section['name_fr']; ?>" required>
                </div>
                <div class="form-group col-5">
                    <label><?php echo get_phrase('short_name'); ?> <em>En</em></label>
                    <input type="text" class="form-control" id="optensname" name = "optensname[]" value="<?php echo $section['short_name']; ?>" required>
                </div>
                <div class="form-group col-5">
                    <label><?php echo get_phrase('short_name'); ?> <em>Fr</em></label>
                    <input type="text" class="form-control" id="optfrsname" name = "optfrsname[]" value="<?php echo $section['short_name_fr']; ?>" required>
                </div>
                <div class="form-group col-1">
                    <label><em>+/-</em></label>
                    <button class="btn btn-icon btn-danger" type="button" onclick="removeSectionDatabase('<?php echo $section['id']; ?>')"><i class="mdi mdi-window-close"></i></button>
                </div>
            </div>
        <?php } ?>

    <?php } ?>
    <div id = "section_area"></div>


<div id = "blank_section">
    <div class="form-row mr-2">
        <div class="form-group col-6">
            <label><?php echo get_phrase('name'); ?> <em>En</em></label>
            <input type="hidden" class="form-control" name = "section_id[]" value="0">
            <input type="text" class="form-control" id="optenname" name = "optenname[]" value="" required>
        </div>
        <div class="form-group col-6">
            <label><?php echo get_phrase('name'); ?> <em>Fr</em></label>
            <input type="text" class="form-control" id="optfrname" name = "optfrname[]" value="" required>
        </div>
        <div class="form-group col-5">
            <label><?php echo get_phrase('short_name'); ?> <em>En</em></label>
            <input type="text" class="form-control" id="optensname" name = "optensname[]" value="" required>
        </div>
        <div class="form-group col-5">
            <label><?php echo get_phrase('short_name'); ?> <em>Fr</em></label>
            <input type="text" class="form-control" id="optfrsname" name = "optfrsname[]" value="" required>
        </div>
        <div class="form-group col-1">
            <button class="btn btn-icon btn-danger" type="button" onclick="removeSection(this)"><i class="mdi mdi-window-close"></i></button>
        </div>
    </div>
</div>


<script>

//update form
 // Jquery form validation initialization

var blank_section_field = $('#blank_section').html();

$(document).ready(function() {
    $('#blank_section').hide();
});


function appendSection() {
    $('#section_area').append(blank_section_field);
}

function removeSection(elem) {
    $(elem).closest('.form-row').remove();
}

function removeSectionDatabase(section_id) {
    $('#sectionDatabase'+section_id).hide();
    $('#section'+section_id).val(section_id+'delete');
}
</script>
