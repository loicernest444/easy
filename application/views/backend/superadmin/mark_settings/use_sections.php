
<table width="100%">
    <thead>
        <tr style="background-color: #313a46; color: #fff;">
            <th style="text-align:center;"><h4><?php echo get_phrase('mark_behaviors'); ?></h4></th>
        </tr>
    </thead>
</table><br>
<div class="form-row mr-2">
    <div class="form-group col-4">
        <label><?php echo get_phrase('option_name'); ?></label>
        <input type="text" class="form-control" id="optenname" name = "optenname[]" value="" required>
    </div>
    <div class="form-group col-4">
        <label><?php echo get_phrase('short_name'); ?></label>
        <input type="text" class="form-control" id="optfrname" name = "optfrname[]" value="" required>
    </div>
    <div class="form-group col-3">
        <label><em>%</em></label>
        <input type="number" step="0.001" min="0" max="100" class="form-control" id="optrep" name = "optrep[]" value="" required>
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
        <div class="form-group col-4">
        <input type="text" class="form-control" id="optenname" name = "optenname[]" value="" required>
    </div>
    <div class="form-group col-4">
        <input type="text" class="form-control" id="optfrname" name = "optfrname[]" value="" required>
    </div>
    <div class="form-group col-3">
        <input type="number" step="0.001" min="0" max="100" class="form-control" id="optrep" name = "optrep[]" value="" required>
    </div>
        <div class="form-group col-1">
            <button class="btn btn-icon btn-danger" type="button" onclick="removeSection(this)"><i class="mdi mdi-window-close"></i></button>
        </div>
    </div>
</div>


 