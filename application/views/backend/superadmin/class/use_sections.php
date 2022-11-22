
<table width="100%">
    <thead>
        <tr style="background-color: #313a46; color: #fff;">
            <th style="text-align:center;"><h4><?php echo get_phrase('sections'); ?></h4></th>
        </tr>
    </thead>
</table><br>
<div class="form-row mr-2">
    <div class="form-group col-8">
        <small id="name_help" class="form-text text-muted"><?php echo get_phrase('name'); ?> <em></em></small>
        <input type="text" class="form-control" id="section_name" name = "section_name[]" placeholder="<?php echo get_phrase('name_in_english'); ?>" value="" required>
    </div>
    <div class="form-group col-4">
        <small id="name_help" class="form-text text-muted"><?php echo get_phrase('short_name'); ?> <em></em></small>
        <input type="text" class="form-control" id="section_sname" name = "section_sname[]" placeholder="<?php echo get_phrase('short_name_in_english'); ?>" value="" required>
    </div>
    <div class="form-group col-8">
        <small id="name_help" class="form-text text-muted"><?php echo get_phrase('name'); ?> <em>Fr</em></small>
        <input type="text" class="form-control" id="fsection_name" name = "fsection_name[]" placeholder="<?php echo get_phrase('name_in_french'); ?>" value="" required>
    </div>
    <div class="form-group col-4">
        <small id="name_help" class="form-text text-muted"><?php echo get_phrase('short_name'); ?> <em>Fr</em></small>
        <input type="text" class="form-control" id="fsection_sname" name = "fsection_sname[]" placeholder="<?php echo get_phrase('short_name_in_french'); ?>" value="" required>
    </div>
    <div class="form-group col-md-5">
        <small id="name_help" class="form-text text-muted"><?php echo get_phrase('link_to_division'); ?></small>
        <select name="school" id="school" class="form-control select2" data-toggle = "select2" onchange="classWiseSection(this.value)">
            <option value=""><?php echo get_phrase('choose_division_to_link'); ?></option>
            <?php
            $schools = $this->db->get_where('schools', array('class_id' => $param1))->result_array()
            foreach ($schools as $school): ?>
            <option value="<?php echo $school['id']; ?>"><?php echo $school['name']; ?></option>
          <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group col-md-5">
        <small id="name_help" class="form-text text-muted"><?php echo get_phrase('link_to_section'); ?></small>
        <select name="div" id="div" class="form-control select2" data-toggle = "select2" onchange="classWiseSection(this.value)">
            <option value=""><?php echo get_phrase('choose_school'); ?></option>
            <?php
            $schools = $this->crud_model->get_schools()->result_array();
            foreach ($schools as $school): ?>
            <option value="<?php echo $school['id']; ?>"><?php echo $school['name']; ?></option>
          <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group col-2">
        <small id="name_help" class="form-text text-muted">+ / - </small>
        <button class="btn btn-icon btn-success" type="button" onclick="appendSection()"><i class="mdi mdi-plus"></i></button>
    </div>
</div>
    <div id = "section_area"></div>


<div id = "blank_section">
    <table width="100%">
    <thead>
        <tr style="background-color: #313a46; color: #fff;">
            <th style="text-align:center;"></th>
        </tr>
    </thead>
</table><br>
    <div class="form-row mr-2">
        <div class="form-group col-10">
            <input type="text" class="form-control" name = "section_name[]" value="" required>
        </div>
        <div class="form-group col-2">
            <button class="btn btn-icon btn-danger" type="button" onclick="removeSection(this)"><i class="mdi mdi-window-close"></i></button>
        </div>
    </div>
</div>


 