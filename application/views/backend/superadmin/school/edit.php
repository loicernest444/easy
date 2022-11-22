<?php $classes = $this->db->get_where('schools', array('id' => $param1))->result_array(); ?>
<?php foreach($classes as $class){ ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('manage_school/update/'.$param1); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('school_name'); ?></label>
            <input type="text" class="form-control" value="<?php echo $class['name']; ?>" id="name" name = "name" required>
            <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_school_name'); ?></small>
        </div>
        <div class="form-group col-md-12">
            <label for="fname"><?php echo get_phrase('school_name'); ?> <em>Fr</em></label>
            <input type="text" class="form-control" value="<?php echo $class['name_fr']; ?>" id="fname" name = "fname" required>
            <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_school_name_in_french'); ?></small>
        </div>
        <div class="form-group col-md-4">
            <label for="sname"><?php echo get_phrase('short_name'); ?></label>
            <input type="text" class="form-control"  value="<?php echo $class['short_name']; ?>" id="sname" name = "sname" required>
            <small id="sname_help" class="form-text text-muted"><?php echo get_phrase('short_name'); ?></small>
        </div>
        <div class="form-group col-md-4">
            <label for="fsname"><?php echo get_phrase('short_name'); ?> <em>Fr</em></label>
            <input type="text" class="form-control"  value="<?php echo $class['short_name_fr']; ?>" id="fsname" name = "fsname" required>
            <small id="sname_help" class="form-text text-muted"><?php echo get_phrase('french_short_name'); ?></small>
        </div>
        <div class="form-group col-md-4">
            <label for="phone"><?php echo get_phrase('phone'); ?></label>
            <input type="text" class="form-control"  value="<?php echo $class['phone']; ?>" id="phone" name = "phone" required>
            <small id="sname_help" class="form-text text-muted"><?php echo get_phrase('provide_phone_number'); ?></small>
        </div>
        <div class="form-group col-md-12">
            <label for="title"><?php echo get_phrase('title_of_the_head'); ?> <em>Fr</em></label>
            <input type="text" class="form-control" id="title" value="<?php echo $class['title']; ?>" name = "title" required>
            <small id="sname_help" class="form-text text-muted"><?php echo get_phrase('school_head_officer_title'); ?></small>
        </div>
        <div class="form-group col-md-12">
            <label for="email"><?php echo get_phrase('email'); ?></label>
            <input type="email" class="form-control"  value="<?php echo $class['email']; ?>" id="email" name = "email">
            <small id="sname_help" class="form-text text-muted"><?php echo get_phrase('provide_email'); ?></small>
        </div>
        <div class="form-group col-md-12">
            <label for="ad"><?php echo get_phrase('address'); ?></label>
            <textarea class="form-control" id="ad" name = "address" rows="2"><?php echo $class['address']; ?></textarea>
            <small id="sname_help" class="form-text text-muted"><?php echo get_phrase('provide_school_address'); ?></small>
        </div>
        <div class="form-group col-md-12">
            <label for="logo"><?php echo get_phrase('school_logo'); ?></label>
            <div class="custom-file-upload">
                <input type="file" class="form-control" id="logo" name = "logo"  accept="image/*">
            </div>
        </div>
         
        <div class="form-group col-md-12">
            <label for="u"><?php echo get_phrase('use_divisions'); ?> ?</label>
            <select name="use_divisions" id="u" class="form-control select2" data-toggle = "select2" onchange="get_form_val(this.value)">
                <option value="1"<?php if($class['use_divisions'] == 1){ echo 'selected'; } ?>><?php echo get_phrase('yes'); ?></option>
                <option value="0"<?php if($class['use_divisions'] == 0){ echo 'selected'; } ?>><?php echo get_phrase('no'); ?></option>
            </select>
            <small id="" class="form-text text-muted"><?php echo get_phrase('is_this_school_having_divisions'); ?> ?</small>
        </div>
        
        <div class="form-group  col-md-12" id="s" <?php if($class['use_divisions'] == 0){?> style="display:none;" <?php } ?>>
            <?php include 'edit_use_sections.php'; ?>
        </div>
        
        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_school'); ?></button>
        </div>
    </div>
</form>
<?php } ?> 

<script>
    $(document).ready(function() {
    $('#blank_section').hide();
    initSelect2(['#u', '#school']);
});
  $(".ajaxForm").validate({}); // Jquery form validation initialization
  $(".ajaxForm").submit(function(e) {
      var form = $(this);
      ajaxSubmit(e, form, showAllClasses);
  });
</script>
<script type="text/javascript">

function get_form_val(u) {
    decision = $("#u").val();
    
    if(decision == '1'){
         $("#s").show();
    }
    else{
        $("#s").hide();
    }
}
        
</script>