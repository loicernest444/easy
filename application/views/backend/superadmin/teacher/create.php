<form method="POST" class="d-block ajaxForm" action="<?php echo route('teacher/create'); ?>" enctype="multipart/form-data">
    <div class="form-row">
        <div class="form-group col-md-12">
            <input type="hidden" name="school_id" value="<?php echo school_id(); ?>">
            <label for="name"><?php echo get_phrase('name'); ?></label>
            <input type="text" class="form-control" id="name" name = "name" required>
            <small id="" class="form-text text-muted"><?php echo get_phrase('provide_teacher_full_name'); ?></small>
        </div>
        
        <div class="col-md-6">
        <label class="form-label" for="bt"><?php echo get_phrase('birth_type'); ?></label>
           <select name="bt" id="bt" class="form-control select" data-toggle = "select2"  required onchange="get_form_val(this.value)">
                <option value="on"><?php echo get_phrase('born_on'); ?></option>
                <option value="around"><?php echo get_phrase('born_around'); ?></option>
            </select>
            <small id="" class="form-text text-muted"><?php echo get_phrase('provide_birthtype'); ?></small>
        </div>
        <div class="col-md-6" id="bd1">
            <label class="form-label" for="birthdatepicker"><?php echo get_phrase('birthday'); ?></label>
            <input type="text" class="form-control date" id="date" data-toggle="date-picker" data-single-date-picker="true" name = "birthday"   value="<?php echo date('m/d/Y'); ?>">
            <small id="" class="form-text text-muted"><?php echo get_phrase('provide_birthday'); ?></small>
        </div>

        <div class="col-md-6" style="display:none" id="bd">
            <label class="form-label"><?php echo get_phrase('year_of_birth'); ?></label>
            <input type="text" name="birthday1" class="form-control" placeholder="<?php echo get_phrase('year_of_birth'); ?>">  
            <small id="" class="form-text text-muted"><?php echo get_phrase('provide_year_of_birth'); ?></small>
        </div>

        <div class="col-md-6">
            <label class="form-label" for="name"><?php echo get_phrase('place_of_birth'); ?></label>
            <input type="text" id="place" name="place" class="form-control" placeholder="<?php echo get_phrase('place_of_birth'); ?>"> 
            <small id="" class="form-text text-muted"><?php echo get_phrase('provide_place_of_birth'); ?></small> 
        </div>
 
        <div class="form-group col-md-6">
            <label for="email"><?php echo get_phrase('email'); ?></label>
            <input type="email" class="form-control" id="email" name = "email" required>
            <small id="" class="form-text text-muted"><?php echo get_phrase('provide_teacher_email'); ?></small>
        </div>
        

        <div class="form-group col-md-6">
            <label for="designation"><?php echo get_phrase('designation'); ?></label>
            <input type="text" class="form-control" id="designation" name = "designation" placeholder="PLET, PLEG, ... ">
            <small id="" class="form-text text-muted"><?php echo get_phrase('provide_teacher_designation'); ?></small>
        </div>

        <div class="form-group col-md-6">
            <label for="department"><?php echo get_phrase('department'); ?></label>
            <select name="department" id="department" class="form-control select2" data-toggle = "select2">
                <option value=""><?php echo get_phrase('select_a_department'); ?></option>
                <?php $departments = $this->db->get_where('departments', array('school_id' => school_id()))->result_array();
                foreach($departments as $department){
                    ?>
                    <option value="<?php echo $department['id']; ?>"><?php echo $department['name']; ?></option>
                <?php } ?>
            </select>
            <small id="" class="form-text text-muted"><?php echo get_phrase('provide_a_department'); ?></small>
        </div>

        <div class="form-group col-md-6">
            <label for="phone"><?php echo get_phrase('phone_number'); ?></label>
            <input type="text" class="form-control" id="phone" name = "phone">
            <small id="" class="form-text text-muted"><?php echo get_phrase('provide_teacher_phone_number'); ?></small>
        </div>

        <div class="form-group col-md-6">
            <label for="gender"><?php echo get_phrase('gender'); ?></label>
            <select name="gender" id="gender" class="form-control select2" data-toggle = "select2">
                <option value=""><?php echo get_phrase('select_a_gender'); ?></option>
                <option value="Male"><?php echo get_phrase('male'); ?></option>
                <option value="Female"><?php echo get_phrase('female'); ?></option>
                <option value="Others"><?php echo get_phrase('others'); ?></option>
            </select>
            <small id="" class="form-text text-muted"><?php echo get_phrase('provide_teacher_gender'); ?></small>
        </div>

        <!--
        <div class="form-group col-md-12">
            <label for="blood_group"><?php echo get_phrase('blood_group'); ?></label>
            <select name="blood_group" id="blood_group" class="form-control select2" data-toggle = "select2">
                <option value=""><?php echo get_phrase('select_a_blood_group'); ?></option>
                <option value="a+">A+</option>
                <option value="a-">A-</option>
                <option value="b+">B+</option>
                <option value="b-">B-</option>
                <option value="ab+">AB+</option>
                <option value="ab-">AB-</option>
                <option value="o+">O+</option>
                <option value="o-">O-</option>
            </select>
            <small id="" class="form-text text-muted"><?php echo get_phrase('provide_teacher_blood_group'); ?></small>
        </div>

        <div class="form-group col-md-12">
            <label><?php echo get_phrase('facebook_profile_link'); ?></label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="mdi mdi-facebook"></i></span>
                </div>
                <input type="text" class="form-control" name="facebook_link">
            </div>
            <small id="" class="form-text text-muted"><?php echo get_phrase('facebook_profile_link'); ?></small>
        </div>

        <div class="form-group col-md-12">
            <label><?php echo get_phrase('twitter_profile_link'); ?></label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="mdi mdi-twitter"></i></span>
                </div>
                <input type="text" class="form-control" name="twitter_link">
            </div>
            <small id="" class="form-text text-muted"><?php echo get_phrase('twitter_profile_link'); ?></small>
        </div>

        <div class="form-group col-md-12">
            <label><?php echo get_phrase('linkedin_profile_link'); ?></label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="mdi mdi-linkedin"></i></span>
                </div>
                <input type="text" class="form-control" name="linkedin_link">
            </div>
            <small id="" class="form-text text-muted"><?php echo get_phrase('linkedin_profile_link'); ?></small>
        </div> 



        <div class="form-group col-md-12">
          <label for="show_on_website"><?php echo get_phrase('show_on_website'); ?></label>
          <select name="show_on_website" id="show_on_website" class="form-control select2" data-toggle = "select2">
            <option value="0"><?php echo get_phrase('do_not_need_to_show'); ?></option>
            <option value="1"><?php echo get_phrase('show'); ?></option>
          </select>
          <small id="" class="form-text text-muted"><?php echo get_phrase('show_this_teacher_on_website'); ?></small>
        </div>-->

        <div class="form-group col-md-12">
            <label for="phone"><?php echo get_phrase('address'); ?></label>
            <textarea class="form-control" id="address" name = "address" rows="2"></textarea>
            <small id="" class="form-text text-muted"><?php echo get_phrase('provide_teacher_address'); ?></small>
        </div>

        <div class="form-group col-md-12">
            <label for="about"><?php echo get_phrase('additional_information'); ?></label>
            <textarea class="form-control" id="about" name = "about" rows="2"></textarea>
            <small id="" class="form-text text-muted"><?php echo get_phrase('provide_a_small_about'); ?></small>
        </div>

        <div class="form-group col-md-12">
            <label for="image_file"><?php echo get_phrase('upload_profil_image'); ?></label>
            <input type="file" class="form-control" id="image_file" name = "image_file">
        </div>
        
        
        <div class="form-group col-md-12">
            <label for="email"><?php echo get_phrase('password'); ?></label>
            <input type="text" value="123456" class="form-control" id="password" required name = "password">
        </div>

        <div class="form-group mt-2 col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('create_teacher'); ?></button>
        </div>
    </div>
</form>

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
<script>
$(document).ready(function () {
    initSelect2(['#department', '#gender', '#blood_group', '#show_on_website']);
     $('#date').daterangepicker();
});
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllTeachers);
});

// initCustomFileUploader();
</script>
