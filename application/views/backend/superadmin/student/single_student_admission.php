<?php $school_id = school_id(); ?>

<form method="POST" class="col-12 d-block ajaxForm" action="<?php echo route('student/create_single_student'); ?>" id = "student_admission_form" enctype="multipart/form-data">
    <div class="col-md-12">
        <div class="form-group row mb-3">
            <div class="col-md-12">
            <label class="form-label" for="name"><?php echo get_phrase('name'); ?></label>
                <input type="text" id="name" name="name" class="form-control" placeholder="<?php echo get_phrase('full_name_in_order_of_birth_certificate'); ?>" required>
            </div>
        </div>
 
        <div class="form-group row mb-3">
            <div class="col-md-4">
                <label class="form-label" for="class_id"><?php echo get_phrase('class'); ?></label>
                <select name="class_id" id="class_id" class="form-control select2" data-toggle = "select2" required onchange="classWiseSection(this.value)">
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
            <div class="col-md-4">
                <label class="form-label" for="section_id"><?php echo get_phrase('section'); ?></label>
                <select name="section_id" id="section_id" class="form-control select2" data-toggle = "select2" >
                    <option value=""><?php echo get_phrase('select_section'); ?></option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label" for="cs"><?php echo get_phrase('student_status'); ?></label>
                <select name="student_status" id="cs" class="form-control select2" data-toggle = "select2"  required>
                    <option value="new"><?php echo get_phrase('new'); ?></option>
                    <option value="redoubling"><?php echo get_phrase('redoubling'); ?></option>
                </select>
            </div>   
        </div>

        <div class="form-group row mb-3">
            <div class="col-md-4">
            <label class="form-label" for="bt"><?php echo get_phrase('birth_type'); ?></label>
               <select name="bt" id="bt" class="form-control select" data-toggle = "select2"  required onchange="get_form_val(this.value)">
                    <option value="on"><?php echo get_phrase('born_on'); ?></option>
                    <option value="around"><?php echo get_phrase('born_around'); ?></option>
                </select>
            </div>
            <div class="col-md-4" id="bd1">
                <label class="form-label" for="birthdatepicker"><?php echo get_phrase('birthday'); ?></label>
                <input type="text" class="form-control" name = "birthday"   value="<?php echo date("d/m/Y"); ?>">
            </div>
        
            <div class="col-md-4" style="display:none" id="bd">
                 <label class="form-label"><?php echo get_phrase('year_of_birth'); ?></label>
                <input type="text" name="birthday1" class="form-control" placeholder="<?php echo get_phrase('year_of_birth'); ?>">  
            </div>
              
            <div class="col-md-4">
                <label class="form-label" for="name"><?php echo get_phrase('place_of_birth'); ?></label>
                <input type="text" id="place" name="place" class="form-control" placeholder="<?php echo get_phrase('place_of_birth'); ?>" required>  
            </div>
            
        </div>
        <div class="form-group row mb-3">
            <div class="col-md-4">
            <label class="form-label" for="region"><?php echo get_phrase('region_of_origin'); ?></label>
                <select name="region" id="region" class="form-control select2" data-toggle = "select2" onchange="regionDepartment(this.value)">
                    <option value=""><?php echo get_phrase('select_a_region'); ?></option>
                    <?php $classes = $this->db->get_where('regions')->result_array(); ?>
                    <?php foreach($classes as $class){ ?>
                        <option value="<?php echo $class['id']; ?>"><?php echo $class['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label" for="section_id"><?php echo get_phrase('department'); ?></label>
                <select name="dep" id="dep_id" class="form-control select2" data-toggle = "select2" required >
                    <option value=""><?php echo get_phrase('department_of_origin'); ?></option>
                </select>
            </div>
            
            <div class="col-md-4">
                <label class="form-label" for="nat"><?php echo get_phrase('nationality'); ?></label>
                <input type="text" id="nat" name="nat" value="Cameroon" class="form-control" placeholder="<?php echo get_phrase('nationality'); ?>" required>  
            </div> 
        </div>   

        <div class="form-group row mb-3">
        <div class="col-md-6">
            <label class="form-label" for="gender"><?php echo get_phrase('gender'); ?></label>
                <select name="gender" id="gender" class="form-control select2" data-toggle = "select2"  required>
                    <option value="Male"><?php echo get_phrase('male'); ?></option>
                    <option value="Female"><?php echo get_phrase('female'); ?></option>
                    <option value="Others"><?php echo get_phrase('others'); ?></option>
                </select>
            </div>
            <div class="col-md-6">
            <label class="form-label" for="sa"><?php echo get_phrase('sporting_ability'); ?></label>
                <select name="sa" id="sa" class="form-control select2" data-toggle = "select2">
                    <option value="apt"><?php echo get_phrase('apt'); ?></option>
                    <option value="unfit"><?php echo get_phrase('unfit'); ?></option>
                </select>
            </div>
        </div>

        <div class="form-group row mb-3">
            <div class="col-md-6">
            <label class="form-label" for="example-textarea"><?php echo get_phrase('address'); ?></label>
                <textarea class="form-control" id="example-textarea" rows="1" name = "address" placeholder="address"></textarea>
            </div>
           <div class="col-md-6">
            <label class="form-label" for="phone"><?php echo get_phrase('phone'); ?></label>
                <input type="text" id="phone" name="phone" class="form-control" placeholder="phone">
           </div>
        </div>

        <div class="form-group row mb-3">
        
           <div class="col-md-6">
            <label class="form-label" for="email"><?php echo get_phrase('email'); ?></label>
                <input type="email" class="form-control" id="email" name="email" placeholder="email">
           </div>
            <div class="col-md-6" <?php if(get_settings('allow_student_auth') < 1){ ?> style="display:none;" <?php } ?>>
            <label class="col-md-3 col-form-label" for="password"><?php echo get_phrase('password'); ?></label>
                <input type="password" class="form-control" id="password" name="password" placeholder="password">
            </div>
        </div>

        <div class="form-group row mb-3">
        <div class="col-md-12">
            <label class="form-label" for="example-fileinput"><?php echo get_phrase('student_profile_image'); ?></label>
            <div class="col-md-9 custom-file-upload">
                <div class="wrapper-image-preview" style="margin-left: -6px;">
                    <div class="box" style="width: 250px;">
                        <div class="js--image-preview" style="background-image: url(<?php echo base_url('uploads/users/placeholder.jpg'); ?>); background-color: #F5F5F5;"></div>
                        <div class="upload-options">
                            <label for="student_image" class="btn"> <i class="mdi mdi-camera"></i> <?php echo get_phrase('upload_an_image'); ?> </label>
                            <input id="student_image" style="visibility:hidden;" type="file" class="image-upload" name="student_image" accept="image/*">
                        </div>
                    </div>
                </div>
                </div>
                </div>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary col-md-12 col-sm-12 mb-4"><?php echo get_phrase('add_student'); ?></button>
        </div>
    </div>
</form>

<script type="text/javascript">
var form;
$(".ajaxForm").submit(function(e) {
  form = $(this);
  ajaxSubmit(e, form, refreshForm);
});
var refreshForm = function () {
    form.trigger("reset");
}
</script>
<script type="text/javascript">

    function get_form_val(bt) {
        bt = $("#bt").val();
        
        if(bt == 'on'){
            $("#bd").hide();
            $("#bd1").show();
        }
        else{ 
            $("#bd1").hide();
            $("#bd").show();
    }
}
    

</script>