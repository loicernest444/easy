<?php $school_id = school_id(); ?>
<?php $subjects = $this->db->get_where('subjects', array('id' => $param1))->result_array(); ?>
<?php foreach($subjects as $subject){ ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('subject/update/'.$param1); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('subject_name'); ?></label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $subject['name']; ?>" required>
            <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $subject['id']; ?>">
            <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_subject_name'); ?></small>
        </div>
        <div class="form-group col-md-12">
            <label for="sname"><?php echo get_phrase('subject_short_name'); ?></label>
            <input type="text" class="form-control" id="sname" name="sname" value="<?php echo $subject['short_name']; ?>" >
            <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_subject_short_name'); ?></small>
        </div>
        <div class="form-group col-md-12">
      <label for="class_id_on_create"><?php echo get_phrase('class'); ?></label>
      <select name="class_id" id="class_id" class="form-control select2" data-toggle="select2" required>
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
                                    <option value="<?php echo $secti['id']; ?>"<?php if($secti['id'] == $subject['class_id']){ echo 'selected'; } ?>><?php echo $secti['name']; ?></option>
                                   <?php } ?>
                                   <?php } else{ ?>
                                    <option value="<?php echo $secti['id']; ?>"<?php if($secti['id'] == $subject['class_id']){ echo 'selected'; } ?>><?php echo $secti['name']; ?></option>
                                   <?php } ?>
                              <?php endforeach; ?>
                          </optgroup>
                        <?php } ?>
                     <?php endforeach; ?>
      </select>
      <small id="class_help" class="form-text text-muted"><?php echo get_phrase('select_a_class'); ?></small>
    </div> 
    <div class="form-group row mb-3" id="suite">
      <?php 
        $use = $this->db->get_where('classes', array('id' => $subject['class_id']))->row()->use_sections;
        if($use < 1){
        $n=$this->db->get_where('subjects', array('id' => $id, 'class_id'=>$subject['class_id']))->num_rows(); 
        ?>
        <div class="col-md-12">
            <label for="u"><?php echo get_phrase('subject_group'); ?> </label>
            <select name="group" id="group" class="form-control select2" data-toggle = "select2">
                <option value=""><?php echo get_phrase('not_linked'); ?></option>
                <?php $groups = $this->db->get_where('subject_settings', array('type' => 1))->result_array(); ?>
                <?php foreach($groups as $class){ ?>
                    <option value="<?php echo $class['id']; ?>"<?php if($subject['group'] == $class['id']) echo 'selected'; ?>><?php echo $class['name'].' / '.$class['name_fr']; ?></option>
                <?php } ?> 
            </select>
        </div>
        <div class="col-md-12">
            <label for="u"><?php echo get_phrase('subject_behavior'); ?> </label>
            <select name="behavior" id="behavior" class="form-control select2" data-toggle = "select2">
                <?php $groups = $this->db->get_where('mark_behavior')->result_array(); ?>
                <?php foreach($groups as $class){ ?>
                    <option value="<?php echo $class['id']; ?>"<?php if($subject['behavior'] == $class['id']) echo 'selected'; ?>><?php echo $class['name'].' / '.$class['name_fr']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-12">
            <label for="u"><?php echo get_phrase('subject_type'); ?> </label>
            <select name="type" id="type" class="form-control select2" data-toggle = "select2">
                <option value=""><?php echo get_phrase('not_linked'); ?></option>
                <?php $groups = $this->db->get_where('subject_settings', array('type' => 2))->result_array(); ?>
                <?php foreach($groups as $class){ ?>
                    <option value="<?php echo $class['id']; ?>"<?php if($subject['type'] == $class['id']) echo 'selected'; ?>><?php echo $class['name'].' / '.$class['name_fr']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-12">
          <label for="name"><?php echo get_phrase('coef'); ?></label>
          <input type="number" min="0" step="0.01" class="form-control" value="<?php echo $subject['coef']; ?>" id="coef" name="coef" >
        </div>

        <div class="col-md-12">
            <label for="u"><?php echo get_phrase('teacher'); ?> </label>
            <select name="teacher" id="teacher" class="form-control select2" data-toggle = "select2">
                <option value=""><?php echo get_phrase('not_linked'); ?></option>
                <?php $groups = $this->db->get_where('teachers', array('session' => active_session("id")))->result_array(); ?>
                <?php foreach($groups as $class){ ?>
                    <option value="<?php echo $class['id']; ?>"<?php if($subject['teacher_id'] == $class['id']) echo 'selected'; ?>><?php echo $this->db->get_where('users', array('id' => $class['user_id']))->row()->name; ?></option>
                <?php } ?>
            </select>
        </div>
        
        <div class="col-md-12">
            <label for="u"><?php echo get_phrase('period'); ?> </label>
            <select name="period" id="period" class="form-control select2" data-toggle = "select2">
                <?php $groups = $this->db->get_where('exams', array('session' => active_session("id"), 'school_id' =>$school_id))->result_array(); ?>
                <?php foreach($groups as $class){ ?>
                    <option value="<?php echo $class['id']; ?>"<?php if($subject['doing_period'] == $class['id']) echo 'selected'; ?>><?php echo $class['name'].' / '.$class['name_fr']; ?></option>
                <?php } ?>
                
                <option value="0"<?php if($subject['doing_period'] == 0) echo 'selected'; ?>><?php echo get_phrase('do_it_all_the_year'); ?></option>
            </select>
        </div> 
        <?php } else{ ?>
        <?php
        $uses = $this->db->get_where('sections', array('class_id' => $subject['class_id']))->result_array();
        foreach($uses as $uses){ 
        $n=$this->db->get_where('subjects', array('id' => $subject['id'], 'subhead' =>$param1, 'class_id'=>$subject['class_id'], 'section_id' =>$uses['id']))->num_rows();  ?> 
        <table width="100%">
            <thead>
                <tr style="background-color: #313a46; color: #fff;">
                    <th style="text-align:center;"><h4><?php echo $uses['name']; ?></h4> </th>
                </tr>
            </thead>
        </table>
        <div class="col-md-6">
            <label for="u"><?php echo get_phrase('use_in_this_class'); ?> ?</label>
            <select name="use<?php echo $uses['id']; ?>" id="u" class="form-control select2" data-toggle = "select2">
                <option value="1"<?php if($n > 0) echo 'selected'; ?>><?php echo get_phrase('yes'); ?></option>
                <option value="0"<?php if($n < 1) echo 'selected'; ?>><?php echo get_phrase('no'); ?></option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="u"><?php echo get_phrase('subject_behavior'); ?> </label>
            <select name="behavior<?php echo $uses['id']; ?>" id="behavior" class="form-control select2" data-toggle = "select2">
                <?php $groups = $this->db->get_where('mark_behavior')->result_array(); ?>
                <?php foreach($groups as $class){ ?>
                    <option value="<?php echo $class['id']; ?>"<?php if($subject['behavior'] == $class['id']) echo 'selected'; ?>><?php echo $class['name'].' / '.$class['name_fr']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-6">
            <label for="u"><?php echo get_phrase('subject_group'); ?> </label>
            <select name="group<?php echo $uses['id']; ?>" id="group" class="form-control select2" data-toggle = "select2">
                <option value=""><?php echo get_phrase('not_linked'); ?></option>
                <?php 
                $groups = $this->db->get_where('subject_settings', array('type' => 1))->result_array(); ?>
                <?php foreach($groups as $class){ ?>
                    <option value="<?php echo $class['id']; ?>"<?php if($n > 0) {if($subject['group'] == $class['id']) echo 'selected';} ?>><?php echo $class['name'].' / '.$class['name_fr']; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="col-md-6">
            <label for="u"><?php echo get_phrase('subject_type'); ?> </label>
            <select name="type<?php echo $uses['id']; ?>" id="type<?php echo $uses['id']; ?>" class="form-control select2" data-toggle = "select2">
                <option value=""><?php echo get_phrase('not_linked'); ?></option>
                <?php $groups = $this->db->get_where('subject_settings', array('type' => 2))->result_array(); ?>
                <?php foreach($groups as $class){ ?>
                    <option value="<?php echo $class['id']; ?>"<?php if($n > 0) {if($subject['type'] == $class['id']) echo 'selected'; }?>><?php echo $class['name'].' / '.$class['name_fr']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-6">
            <label for="u"><?php echo get_phrase('teacher'); ?> </label>
            <select name="teacher<?php echo $uses['id']; ?>" id="teacher<?php echo $uses['id']; ?>" class="form-control select2" data-toggle = "select2">
                <option value=""><?php echo get_phrase('not_linked'); ?></option>
                <?php $groups = $this->db->get_where('teachers', array('session' => active_session("id")))->result_array(); ?>
                <?php foreach($groups as $class){ ?>
                    <option value="<?php echo $class['id']; ?>"<?php if($subject['teacher_id'] == $class['id']) echo 'selected'; ?>><?php echo $this->db->get_where('users', array('id' => $class['user_id']))->row()->name; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group col-md-6">
          <label for="name"><?php echo get_phrase('coef'); ?></label>
          
            <input type="hidden" class="form-control" id="subh" name="subh<?php echo $uses['id']; ?>" value="<?php echo $subject['subhead']; ?>">
          <input type="number" min="0" step="0.01" class="form-control" value="<?php if($n > 0) {echo $subject['coef'];} ?>" id="coef<?php echo $uses['id']; ?>" name="coef<?php echo $uses['id']; ?>">
        </div>
        <div class="col-md-12">
            <label for="u"><?php echo get_phrase('period'); ?> </label>
            <select name="period<?php echo $uses['id']; ?>" id="period<?php echo $uses['id']; ?>" class="form-control select2" data-toggle = "select2">
                <?php $groups = $this->db->get_where('exams', array('session' => active_session("id"), 'school_id' =>$school_id))->result_array(); ?>
                <?php foreach($groups as $class){ ?>
                    <option value="<?php echo $class['id']; ?>"<?php if($usesub['doing_period'] == $class['id']) echo 'selected'; ?>><?php echo $class['name'].' / '.$class['name_fr']; ?></option>
                <?php } ?>
                
                <option value="0"<?php if($usesub['doing_period'] == 0) echo 'selected'; ?>><?php echo get_phrase('do_it_all_the_year'); ?></option>
            </select>
        </div> 
        <?php } ?>
        <?php } ?>
    </div>

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_subject'); ?></button>
        </div>
    </div>
</form>
<?php } ?> 

<script>
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
  var form = $(this);
  ajaxSubmit(e, form, showAllSubjects);
});

$(document).ready(function() {
  initSelect2(['#class_id_on_create']);
});
    
function classWiseOption(classId) {
    var id = $('#id').text();
    $.ajax({
        url: "<?php echo route('option/lists_edit/'); ?>"+classId+'/'+id,
        success: function(response){
            $('#suite').html(response);
        }
    }); 
}  
</script>
