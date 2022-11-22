
<table width="100%">
    <thead>
        <tr style="background-color: #313a46; color: #fff;">
            <th style="text-align:center;"><h4><?php echo get_phrase('divisions'); ?></h4></th>
        </tr>
    </thead> 
</table><br>
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
    <div id = "section_area"></div>


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


