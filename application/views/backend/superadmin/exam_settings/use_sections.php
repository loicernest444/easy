
<table width="100%">
    <thead>
        <tr style="background-color: #313a46; color: #fff;">
            <th style="text-align:center;"><h4><?php echo get_phrase('Year_division_exams'); ?></h4></th>
        </tr>
    </thead>
</table><br>
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
    <div id = "section_area"></div>

 
<div id = "blank_section">
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
        <button class="btn btn-icon btn-danger" type="button" onclick="removeSection(this)"><i class="mdi mdi-window-close"></i></button>
    </div>
    </div>
</div>


 