<form method="POST" class="d-block ajaxForm" action="<?php echo route('subject/create'); ?>">
 

    <input type="hidden" name="school_id" value="<?php echo school_id(); ?>">
    <input type="hidden" name="session" value="<?php echo active_session();?>">
      
    <div class=" col-md-12">
        <label class="form-label" for="ic"><?php echo get_phrase('new_or_copy_from_another'); ?></label>
        <select name="ic" id="ic" class="form-control select2" data-toggle = "select2"  required onchange="get_form_val(this.value)">
            <option value="0"><?php echo get_phrase('new'); ?></option>
            <option value="1"><?php echo get_phrase('copy_from_another_class'); ?></option>
        </select>
    </div> <br>
      
    <div class="form-row" id="copy" style="display:none;">
       <div class="form-group col-md-6">
           <label class="form-label" for="ic"><?php echo get_phrase('copy_from'); ?></label>
            <select name="c1" id="c1" class="form-control select2" data-toggle = "select2" required onchange="classWiseSection1(this.value)">
                <option value=""><?php echo get_phrase('select_a_class'); ?></option>
                <?php
                $classes = $this->db->get_where('classes', array('school_id' => school_id()))->result_array();?>
                <?php foreach ($classes as $class): ?>
                    <option value="<?php echo $class['id']; ?>"><?php echo $class['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label class="form-label" for="ic">-</label>
            <select name="s1" id="s1" class="form-control select2" data-toggle = "select2" required>
                <option value=""><?php echo get_phrase('select_section'); ?></option>
            </select>
        </div> 
       <div class="form-group col-md-6">
           <label class="form-label" for="ic"><?php echo get_phrase('copy_to'); ?></label>
            <select name="c2" id="c2" class="form-control select2" data-toggle = "select2" required onchange="classWiseSection2(this.value)">
                <option value=""><?php echo get_phrase('select_a_class'); ?></option>
                <?php
                $classes = $this->db->get_where('classes', array('school_id' => school_id()))->result_array();?>
                <?php foreach ($classes as $class): ?>
                    <option value="<?php echo $class['id']; ?>"><?php echo $class['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label class="form-label" for="ic">-</label>
            <select name="s2" id="s2" class="form-control select2" data-toggle = "select2" required>
                <option value=""><?php echo get_phrase('select_section'); ?></option>
            </select>
        </div> 
    </div>
    <div class="form-row" id="new">
    <div class="form-group col-md-12">
      <label for="name"><?php echo get_phrase('subject_name'); ?></label>
      <input type="text" class="form-control" id="name" name="name" required>
      <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_subject_name'); ?></small>
    </div>
    <div class="form-group col-md-12">
      <label for="sname"><?php echo get_phrase('subject_short_name'); ?></label>
      <input type="text" class="form-control" id="sname" name="sname">
      <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_subject_short_name'); ?></small>
    </div>
    <div class="form-group col-md-12">
      <label for="class_id_on_create"><?php echo get_phrase('class'); ?></label>
      <select name="class_id" id="class_id_on_create" class="form-control select2" data-toggle="select2" onchange="classWiseOption(this.value)" required>
        <option value=""><?php echo get_phrase('select_a_class'); ?></option>
          <?php
                   $schools = $this->db->get_where('schools')->result_array();
                      foreach ($schools as $school): ?>
                         <?php if($this->db->get_where('classes', array('school_id' => $school['id']))->num_rows() > 0) {?>
                          <optgroup label="<?php echo $school['name'].' / '.$school['name_fr']; ?>">
                              <?php
                                                                                                                           
                              $secti = $this->db->get_where('classes', array('school_id' => $school['id']))->result_array();
                              foreach ($secti as $secti): 
                                  if($secti['use_sections'] > 0){
                                    if($this->db->get_where('sections', array('class_id' => $secti['id']))->num_rows() > 0){?>
                                    <option value="<?php echo $secti['id']; ?>"><?php echo $secti['name'].' / '.$secti['name_fr']; ?></option>
                                   <?php } ?>
                                   <?php } else{ ?>
                                    <option value="<?php echo $secti['id']; ?>"><?php echo $secti['name']; ?></option>
                                   <?php } ?>
                              <?php endforeach; ?>
                          </optgroup>
                        <?php } ?>
                     <?php endforeach; ?>
      </select>
      <small id="class_help" class="form-text text-muted"><?php echo get_phrase('select_a_class'); ?></small>
    </div>
    </div>
    <div class="form-group row mb-3" id="suite">
        
    </div>

    <div class="form-group  col-md-12">
      <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('create_subject'); ?></button>
    </div>

</form>  
 
<script>
$(document).ready(function() {
  initSelect2(['#class_id_on_create','#c1','#c2','#s1','#s2']);
});
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
  var form = $(this);
  ajaxSubmit(e, form, showAllSubjects);
});
    
function classWiseOption(classId) {
    $.ajax({
        url: "<?php echo route('option/lists/'); ?>"+classId,
        success: function(response){
            $('#suite').html(response);
        }
    });
}
  
function classWiseSection1(classId) {
    $.ajax({
        url: "<?php echo route('section/list/'); ?>"+classId,
        success: function(response){
            $('#s1').html(response);
        }
    });
}
    
function classWiseSection2(classId) {
    $.ajax({
        url: "<?php echo route('section/list/'); ?>"+classId,
        success: function(response){
            $('#s2').html(response);
        }
    });
}
    
function get_form_val(u) {
        decision = $("#ic").val();
        
        if(decision == '1'){
             $("#copy").show();
            $("#new").hide();
        }
        else{
            $("#new").show();
            $("#copy").hide();
        }
    }
</script>
