
<form method="POST" class="d-block ajaxForm" action="<?php echo route('manage_school/division/'.$param1); ?>">
    <?php $count = 0; ?>
    <?php $sections = $this->db->get_where('divisions', array('school_id' => $param1))->result_array(); ?>
    <?php $n = $this->db->get_where('divisions', array('school_id' => $param1))->num_rows(); ?>
    
    <?php if($n == 0){ ?>
            <div class="form-row mr-2">
                <div class="form-group col-6">
                    <?php echo get_phrase('name'); ?>
                    <input type="text" class="form-control" id="division_name" name = "division_name[]" placeholder="<?php echo get_phrase('english_name'); ?>" value="" required>
                </div>
                <div class="form-group col-6">
                    <?php echo get_phrase('name'); ?> <em>Fr</em>
                    <input type="text" class="form-control" id="fdivision_name" placeholder="<?php echo get_phrase('french_name'); ?>" name = "fdivision_name[]" value="" required>
                </div>
                
                <div class="form-group col-5">
                    <?php echo get_phrase('short_name'); ?>
                    <input type="text" class="form-control" id="division_sname" placeholder="<?php echo get_phrase('english_short_name'); ?>" name = "division_sname[]" value="" required>
                </div>
                
                <div class="form-group col-5">
                    <?php echo get_phrase('short_name'); ?> <em>Fr</em>
                    <input type="text" class="form-control" id="fdivision_sname" placeholder="<?php echo get_phrase('french_short_name'); ?>" name = "fdivision_sname[]" value="" required>
                </div>
                <div class="form-group col-2"><br>
                    <button class="btn btn-icon btn-success" type="button" onclick="appendSection()"><i class="mdi mdi-plus"></i></button>
                </div>
            </div>
        <?php } ?>
    
    <?php foreach($sections as $section){
        $count++; ?>
    
        <?php if($count == 1){ ?>
            <div class="form-row mr-2">
                
                <div class="form-group col-6">
                    <?php echo get_phrase('name'); ?>
                    <input type="text" class="form-control" id="division_name" placeholder="<?php echo get_phrase('english_name'); ?>" name = "division_name[]" value="<?php echo $section['name']; ?>" required>
                </div>
                <div class="form-group col-6">
                    <?php echo get_phrase('name'); ?> <em>Fr</em>
                    <input type="text" class="form-control" id="fdivision_name" name = "fdivision_name[]" value="<?php echo $section['name_fr']; ?>" placeholder="<?php echo get_phrase('french_name'); ?>" required>
                </div>
                <div class="form-group col-5">
                    <?php echo get_phrase('short_name'); ?>
                    <input type="hidden" class="form-control" id="division" name = "division_id[]" value="<?php echo $section['id']; ?>">
                    <input type="text" class="form-control" id="division_sname" name = "division_sname[]" value="<?php echo $section['short_name']; ?>" placeholder="<?php echo get_phrase('english_short_name'); ?>" required>
                </div>
                <div class="form-group col-5">
                    <?php echo get_phrase('short_name'); ?> <em>Fr</em>
                    <input type="text" class="form-control" id="fdivision_sname" name = "fdivision_sname[]" value="<?php echo $section['short_name_fr']; ?>" placeholder="<?php echo get_phrase('french_short_name'); ?>" required>
                </div>
                <div class="form-group col-2"><br>
                    <button class="btn btn-icon btn-success" type="button" onclick="appendSection()"><i class="mdi mdi-plus"></i></button>
                </div>
            </div>
        <?php } ?>

        <?php if($count > 1){ ?>
            <div class="form-row mr-2" id="sectionDatabase<?php echo $section['id']; ?>">
                
                <div class="form-group col-6">
                    <input type="text" class="form-control" id="division_name" name = "division_name[]" value="<?php echo $section['name']; ?>" placeholder="<?php echo get_phrase('english_name'); ?>" required>
                </div>
                <div class="form-group col-6">
                    <input type="text" class="form-control" id="fdivision_name" name = "fdivision_name[]" value="<?php echo $section['name_fr']; ?>" placeholder="<?php echo get_phrase('french_name'); ?>" required>
                </div>
                <div class="form-group col-5">
                    <input type="hidden" class="form-control" id="division<?php echo $section['id']; ?>" name = "division_id[]" value="<?php echo $section['id']; ?>">
                    <input type="text" class="form-control" id="division_sname" name = "division_sname[]" value="<?php echo $section['short_name']; ?>" placeholder="<?php echo get_phrase('english_short_name'); ?>" required>
                </div>
                <div class="form-group col-5">
                    <input type="text" class="form-control" id="fdivision_sname" name = "fdivision_sname[]" value="<?php echo $section['short_name_fr']; ?>" placeholder="<?php echo get_phrase('french_short_name'); ?>" required>
                </div>
                <div class="form-group col-2">
                    <button class="btn btn-icon btn-danger" type="button" onclick="removeSectionDatabase('<?php echo $section['id']; ?>')"><i class="mdi mdi-window-close"></i></button>
                </div>
            </div>
        <?php } ?>

    <?php } ?>
    <div id = "section_area"></div>
    <div class="row no-gutters">
    <div class="form-group  col-md-12 p-0 mt-2">
        <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update'); ?></button>
    </div>
</div>
</form>

<div id = "blank_section">
    <div class="form-row mr-2">
        <div class="form-group col-6">
            <input type="text" class="form-control" name = "division_name[]" placeholder="<?php echo get_phrase('english_name'); ?>" value="" required>
        </div>
        <div class="form-group col-6">
            <input type="text" class="form-control" name = "fdivision_name[]" placeholder="<?php echo get_phrase('french_name'); ?>" value="" required>
        </div>
        <div class="form-group col-5">
            <input type="hidden" class="form-control" name = "division_id[]" value="0">
            <input type="text" class="form-control" name = "division_sname[]" placeholder="<?php echo get_phrase('english_short_name'); ?>" value="" required>
        </div>
        <div class="form-group col-5">
            <input type="text" class="form-control" name = "fdivision_sname[]" placeholder="<?php echo get_phrase('french_short_name'); ?>" value="" required>
        </div>
        <div class="form-group col-2">
            <button class="btn btn-icon btn-danger" type="button" onclick="removeSection(this)"><i class="mdi mdi-window-close"></i></button>
        </div>
    </div>
</div>


<script>

//update form
 // Jquery form validation initialization
$(".ajaxForm").validate({});
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllClasses);
});

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
    $('#division'+section_id).val(section_id+'delete');
}
</script>
