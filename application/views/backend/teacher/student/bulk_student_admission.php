<?php $school_id = school_id(); ?>
<form method="POST" class="col-md-12 ajaxForm" action="<?php echo route('student/create_bulk_student'); ?>" id = "student_admission_form">
    <div class="row justify-content-md-center">
        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3 mb-lg-0">
            <select name="class_id" id="class_id" class="form-control select2" data-toggle = "select2" onchange="classWiseSection(this.value)" required>
                <option value=""><?php echo get_phrase('select_a_class'); ?></option>
                <?php $classes = $this->db->get_where('classes', array('school_id' => $school_id))->result_array(); ?>
                <?php foreach($classes as $class){ ?>
                    <?php 
                        if($class['use_sections'] > 0) {
                           if($this->db->get_where('sections', array('class_id' => $class['id']))->num_rows() > 0){ ?>
                            <option value="<?php echo $class['id']; ?>"><?php echo $class['name']; ?></option>
                           <?php } ?>
                        <?php }else{ ?>
                            <option value="<?php echo $class['id']; ?>"><?php echo $class['name']; ?></option>
                        <?php } ?>
                <?php } ?>
            </select>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3 mb-lg-0" id = "section_content">
            <select name="section_id" id="section_id" class="form-control select2" data-toggle = "select2" required >
                <option value=""><?php echo get_phrase('select_section'); ?></option>
            </select>
        </div>
    </div>
    <br> 
    <div id = "first-row">
        <div class="row">
            <div class="col-xl-11 col-lg-11 col-md-12 col-sm-12 mb-3 mb-lg-0">
                <div class="row justify-content-md-center">
                    <div class="form-group col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-1 mb-lg-0">
                        <label class="form-label" for="name"><?php echo get_phrase('full_name_in_order_of_birth_certificate'); ?></label>
                        <input type="text" name="name[]" class="form-control"  value="" placeholder="<?php echo get_phrase('full_name_in_order_of_birth_certificate'); ?>" required>
                    </div>
                    <div class="form-group col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-1 mb-lg-0">
                        <label class="form-label" for="name"><?php echo get_phrase('birthdate'); ?> mm/dd/yy</label>
                        <input type="text" name="name[]" class="form-control"  value="" placeholder="<?php echo get_phrase('full_name_in_order_of_birth_certificate'); ?>" required>
                    </div>
                      
                    <div class="form-group col-xl-2 col-lg-2 col-md-12 col-sm-12 mb-1 mb-lg-0">
                        <label class="form-label" for="name"><?php echo get_phrase('gender'); ?></label>
                        <select name="gender[]" class="form-control" required>
                            <option value="Male"><?php echo get_phrase('male'); ?></option>
                            <option value="Female"><?php echo get_phrase('female'); ?></option>
                            <option value="Others"><?php echo get_phrase('others'); ?></option>
                        </select>
                    </div>
                    <div class="form-group col-xl-2 col-lg-2 col-md-12 col-sm-12 mb-1 mb-lg-0">
                        <label class="form-label" for="name"><?php echo get_phrase('abilities'); ?></label>
                        <select name="sa[]" class="form-control" required>
                            <option value="apt"><?php echo get_phrase('apt'); ?></option>
                            <option value="unfit"><?php echo get_phrase('unfit'); ?></option>
                        </select>
                    </div>
                    <div class="form-group col-xl-2 col-lg-2 col-md-12 col-sm-12 mb-1 mb-lg-0">
                        <label class="form-label" for="name"><?php echo get_phrase('status'); ?></label>
                        <select name="ss[]" class="form-control" required>
                            <option value="new"><?php echo get_phrase('new'); ?></option>
                            <option value="redoubling"><?php echo get_phrase('redoubling'); ?></option>
                        </select>
                    </div>

                </div>
            </div>
            <div class="col-xl-1 col-lg-1 col-md-12 col-sm-12 mb-3 mb-lg-0">
                <div class="row justify-content-md-center">
                    <div class="form-group col">
                        <label class="form-label" for="name"> + / -</label>
                        <button type="button" class="btn btn-icon btn-success" onclick="appendRow()"> <i class="mdi mdi-plus"></i> </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-primary col-md-12 col-sm-12 mb-4 mt-2"><?php echo get_phrase('add_students'); ?></button>
    </div>
</form>

<div id = "blank-row" style="display: none;">
    <div class="row student-row">
        <div class="col-xl-11 col-lg-11 col-md-12 col-sm-12 mb-3 mb-lg-0">
            <div class="row justify-content-md-center">
                <div class="form-group col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-1 mb-lg-0">
                    <input type="text" name="name[]" class="form-control"  value="" placeholder="<?php echo get_phrase('full_name_in_order_of_birth_certificate'); ?>">
                </div>

                <div class="form-group col-xl-2 col-lg-2 col-md-12 col-sm-12 mb-1 mb-lg-0">
                    <select name="gender[]" class="form-control">
                        <option value="Male"><?php echo get_phrase('male'); ?></option>
                        <option value="Female"><?php echo get_phrase('female'); ?></option>
                        <option value="Others"><?php echo get_phrase('others'); ?></option>
                    </select>
                </div>
                <div class="form-group col-xl-2 col-lg-2 col-md-12 col-sm-12 mb-1 mb-lg-0">
                    <select name="sa[]" class="form-control" required>
                        <option value="apt"><?php echo get_phrase('apt'); ?></option>
                        <option value="unfit"><?php echo get_phrase('unfit'); ?></option>
                    </select>
                </div>
                <div class="form-group col-xl-2 col-lg-2 col-md-12 col-sm-12 mb-1 mb-lg-0">
                    <select name="ss[]" class="form-control" required>
                        <option value="new"><?php echo get_phrase('new'); ?></option>
                        <option value="redoubling"><?php echo get_phrase('redoubling'); ?></option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-xl-1 col-lg-1 col-md-12 col-sm-12 mb-3 mb-lg-0">
            <div class="row justify-content-md-center">
                <div class="form-group col">
                    <button type="button" class="btn btn-icon btn-danger" onclick="removeRow(this)"> <i class="mdi mdi-window-close"></i> </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
var blank_field = $('#blank-row').html();

function appendRow() {
    $('#first-row').append(blank_field);
}

function removeRow(elem) {
    $(elem).closest('.student-row').remove();
}
</script>

<script>
var form;
$(".ajaxForm").submit(function(e) {
    form = $(this);
    ajaxSubmit(e, form, refreshForm);
});
var refreshForm = function () {
    form.trigger("reset");
}
</script>
