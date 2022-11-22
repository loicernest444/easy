<form method="POST" class="d-block ajaxForm" action="<?php echo route('manage_class/create'); ?>">
    <div class="form-row">
        
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('class_name'); ?></label>
            <input type="text" class="form-control" id="name" name = "name" required>
            <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_class_name'); ?></small>
        </div>
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('short_name'); ?></label>
            <input type="text" class="form-control" id="sname" name = "sname" required>
            <small id="sname_help" class="form-text text-muted"><?php echo get_phrase('provide_class_short_name'); ?></small>
        </div>
        <div class="form-group col-md-12">
            <label for="u"><?php echo get_phrase('use_sections'); ?> ?</label>
            <select name="use_sections" id="u" class="form-control select2" data-toggle = "select2" onchange="get_form_val(this.value)">
                <option value="0"><?php echo get_phrase('no'); ?></option>
                <option value="1"><?php echo get_phrase('yes'); ?></option>
            </select>
            <small id="" class="form-text text-muted"><?php echo get_phrase('is_this_class_having_sections'); ?> ?</small>
        </div> 
        <?php 
                $n = $this->crud_model->get_schools()->num_rows();
                if ($n > 1){
        ?>
        <div class="form-group col-md-12" id="s">
        <div class="col-md-12">
            <label for="name"><?php echo get_phrase('choose_school'); ?></label>
            <select name="school" id="school" class="form-control select2" data-toggle = "select2" required onchange="classWiseSection(this.value)">
                <option value=""><?php echo get_phrase('choose_school'); ?></option>
                <?php
                $schools = $this->crud_model->get_schools()->result_array();
                foreach ($schools as $school): ?>
                <option value="<?php echo $school['id']; ?>"><?php echo $school['name'].' / '.$school['name_fr']; ?></option>
              <?php endforeach; ?>
            </select>
            <small id="" class="form-text text-muted"><?php echo get_phrase('choose_school'); ?> ?</small>
        </div>
        <div class="col-md-12">
            <label for="name"><?php echo get_phrase('choose_school_division'); ?></label>
            <select name="section" id="section_id" class="form-control select2" data-toggle = "select2" onchange="classWiseOption(this.value)">
                <option value=""><?php echo get_phrase('select_school_first'); ?></option>
            </select>
            <small id="" class="form-text text-muted"><?php echo get_phrase('is_this_class_is_linked_to_division'); ?> ?</small>
        </div>
        <div class="col-md-12">
            <label for="option"><?php echo get_phrase('choose_option'); ?></label>
            <select name="option" id="option_id" class="form-control select2" data-toggle = "select2">
                <option value=""><?php echo get_phrase('select_school_division_first'); ?></option>
            </select>
            <small id="" class="form-text text-muted"><?php echo get_phrase('is_this_class_is_linked_to_option'); ?> ?</small>
        </div> 
        <?php } else{ ?>
            <input type="hidden" class="form-control" name = "school" value="<?php echo school_id(); ?>">
            <div class="col-md-12">
            <label for="section"><?php echo get_phrase('choose_school_division'); ?></label>
            <select name="sectionn" id="section" class="form-control select2" data-toggle = "select2" onchange="classWiseOption(this.value)">
                <?php
                    $use = $this->db->get_where('schools', array('id' => school_id()))->row()->use_divisions;
                    if($use > 0){
                    $sections = $this->db->get_where('divisions', array('school_id' => school_id()))->result_array();
                    if (count($sections) > 0): ?>
                      <option value=""><?php echo get_phrase('no_need_to_link_to_division'); ?></option>
                    <?php
                      foreach ($sections as $section): ?>
                        <option value="<?php echo $section['id']; ?>"><?php echo $section['name'].' / '.$section['name_fr']; ?></option>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <option value=""><?php echo get_phrase('no_division_found'); ?></option>
                    <?php endif; ?>
                    <?php } else{?>
                      <option value=""><?php echo get_phrase('this_school_does_not_have_divisions'); ?></option>
                    <?php } ?>
            </select>
            <small id="" class="form-text text-muted"><?php echo get_phrase('choose_school_division_if_necessary'); ?> </small>
            </div>
            <div class="col-md-12">
                <label for="option"><?php echo get_phrase('choose_option'); ?></label>
                <select name="optionn" id="option_id" class="form-control select2" data-toggle = "select2">
                    <option value=""><?php echo get_phrase('select_school_division_first'); ?></option>
                </select>
                <small id="" class="form-text text-muted"><?php echo get_phrase('is_this_class_is_linked_to_option'); ?> ?</small>
            </div>
        <?php } ?>
            
        </div><br><br>
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('previous_class'); ?></label>
            <select name="previous" id="previous" class="form-control select2" data-toggle = "select2" onchange="classWiseSection(this.value)">
                <option value=""><?php echo get_phrase('none'); ?></option>
                <?php
                $nsch= $this->db->get_where('schools')->num_rows();
                if($nsch > 1){
                    $sch = $this->db->get_where('schools')->result_array();
                    foreach ($sch as $sch): ?>
                         <?php if($this->db->get_where('classes', array('school_id' => $sch['id']))->num_rows() > 0) {?>
                          <optgroup label="<?php echo $sch['name'].' / '.$sch['name_fr']; ?>">
                              <?php                                                                                      
                                $sec = $this->db->get_where('classes', array('school_id' => $sch['id']))->result_array(); 
                              foreach ($sec as $sec): ?>
                                    <option value="<?php echo $sec['id']; ?>"><?php echo $sec['name']; ?></option>
                              <?php endforeach; ?>
                          </optgroup>
                        <?php } ?>
                     <?php endforeach; ?>
                <?php } else{?>
                    <?php                                                                                      
                      $sec = $this->db->get_where('classes')->result_array(); 
                      foreach ($sec as $sec): ?>
                            <option value="<?php echo $sec['id']; ?>"><?php echo $sec['name']; ?></option>
                      <?php endforeach; ?>
                <?php } ?>
            </select>
            <small id="" class="form-text text-muted"><?php echo get_phrase('choose_the_previous_class'); ?> ?</small>
        </div>
        
        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('create_class'); ?></button>
        </div>
</form>

<script>

var blank_section_field = $('#blank_section').html();

$(document).ready(function() {
    $('#blank_section').hide();
    initSelect2(['#u', '#school','#previous','#option_id','#optionn', '#section_id', '#section']);
});
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllClasses);
});

function appendSection() {
    $('#section_area').append(blank_section_field);
}

function removeSection(elem) {
    $(elem).closest('.form-row').remove();
}

function classWiseSection(classId) {
    $.ajax({
        url: "<?php echo route('division/list/'); ?>"+classId,
        success: function(response){
            $('#section_id').html(response);
        }
    });
}
    
function classWiseOption(classId) {
    $.ajax({
        url: "<?php echo route('option/list/'); ?>"+classId,
        success: function(response){
            $('#option_id').html(response);
        }
    });
}
</script>
<script type="text/javascript">

    function get_form_val(u) {
        decision = $("#u").val();
        
        if(decision == '1'){
            $("#s").hide();
        }
        else{
             $("#s").show();
        }
    }
            
</script>
