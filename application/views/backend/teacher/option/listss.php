<?php
$sections = $this->db->get_where('division_option', array('division_id' => $class_id))->result_array();
$use = $this->db->get_where('classes', array('id' => $class_id))->row()->use_sections;
if($use < 1){
?>
<div class="col-md-12">
    <label for="u"><?php echo get_phrase('subject_group'); ?> </label>
    <select name="group" id="group" class="form-control select2" data-toggle = "select2">
        <option value=""><?php echo get_phrase('not_linked'); ?></option>
        <?php $groups = $this->db->get_where('subject_settings', array('type' => 1))->result_array(); ?>
        <?php foreach($groups as $class){ ?>
            <option value="<?php echo $class['id']; ?>"><?php echo $class['name'].' / '.$class['name_fr']; ?></option>
        <?php } ?>
    </select> 
</div>
<div class="col-md-12">
    <label for="u"><?php echo get_phrase('subject_type'); ?> </label>
    <select name="type" id="type" class="form-control select2" data-toggle = "select2">
        <option value=""><?php echo get_phrase('not_linked'); ?></option>
        <?php $groups = $this->db->get_where('subject_settings', array('type' => 2))->result_array(); ?>
        <?php foreach($groups as $class){ ?>
            <option value="<?php echo $class['id']; ?>"><?php echo $class['name'].' / '.$class['name_fr']; ?></option>
        <?php } ?>
    </select>
</div>
<div class="col-md-12"> 
    <label for="u"><?php echo get_phrase('subject_behavior'); ?> </label>
    <select name="behavior" id="behavior" class="form-control select2" data-toggle = "select2">
        <?php $groups = $this->db->get_where('mark_behavior')->result_array(); ?>
        <?php foreach($groups as $class){ ?>
            <option value="<?php echo $class['id']; ?>"><?php echo $class['name'].' / '.$class['name_fr']; ?></option>
        <?php } ?>
    </select>
</div>
<div class="col-md-12">
  <label for="name"><?php echo get_phrase('coef'); ?></label>
  <input type="number" min="0" step="0.01" class="form-control" id="coef" name="coef" >
</div>

<div class="col-md-12">
    <label for="u"><?php echo get_phrase('teacher'); ?> </label>
    <select name="teacher" id="teacher" class="form-control select2" data-toggle = "select2">
        <option value=""><?php echo get_phrase('not_linked'); ?></option>
        <?php $groups = $this->db->get_where('teachers', array('session' => active_session("id")))->result_array(); ?>
        <?php foreach($groups as $class){ ?>
            <option value="<?php echo $class['id']; ?>"><?php echo $this->db->get_where('users', array('id' => $class['user_id']))->row()->name;; ?></option>
        <?php } ?>
    </select>
</div> 
<?php } else{ ?>
<?php
$uses = $this->db->get_where('sections', array('class_id' => $class_id))->result_array();
foreach($uses as $uses){ ?>
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
        <option value="1"><?php echo get_phrase('yes'); ?></option>
        <option value="0"><?php echo get_phrase('no'); ?></option>
    </select>
</div>
<div class="col-md-6">
    <label for="u"><?php echo get_phrase('subject_behavior'); ?> </label>
    <select name="behavior<?php echo $uses['id']; ?>" id="behavior" class="form-control select2" data-toggle = "select2">
        <?php $groups = $this->db->get_where('mark_behavior')->result_array(); ?>
        <?php foreach($groups as $class){ ?>
            <option value="<?php echo $class['id']; ?>"><?php echo $class['name'].' / '.$class['name_fr']; ?></option>
        <?php } ?>
    </select>
</div>
<div class="col-md-6">
    <label for="u"><?php echo get_phrase('subject_group'); ?> </label>
    <select name="group<?php echo $uses['id']; ?>" id="group" class="form-control select2" data-toggle = "select2">
        <option value=""><?php echo get_phrase('not_linked'); ?></option>
        <?php $groups = $this->db->get_where('subject_settings', array('type' => 1))->result_array(); ?>
        <?php foreach($groups as $class){ ?>
            <option value="<?php echo $class['id']; ?>"><?php echo $class['name'].' / '.$class['name_fr']; ?></option>
        <?php } ?>
    </select>
</div>

<div class="col-md-6">
    <label for="u"><?php echo get_phrase('subject_type'); ?> </label>
    <select name="type<?php echo $uses['id']; ?>" id="type<?php echo $uses['id']; ?>" class="form-control select2" data-toggle = "select2">
        <option value=""><?php echo get_phrase('not_linked'); ?></option>
        <?php $groups = $this->db->get_where('subject_settings', array('type' => 2))->result_array(); ?>
        <?php foreach($groups as $class){ ?>
            <option value="<?php echo $class['id']; ?>"><?php echo $class['name'].' / '.$class['name_fr']; ?></option>
        <?php } ?>
    </select>
</div>
<div class="col-md-6">
    <label for="u"><?php echo get_phrase('teacher'); ?> </label>
    <select name="teacher<?php echo $uses['id']; ?>" id="teacher<?php echo $uses['id']; ?>" class="form-control select2" data-toggle = "select2">
        <option value=""><?php echo get_phrase('not_linked'); ?></option>
        <?php $groups = $this->db->get_where('teachers', array('session' => active_session("id")))->result_array(); ?>
        <?php foreach($groups as $class){ ?>
            <option value="<?php echo $class['id']; ?>"><?php echo $this->db->get_where('users', array('id' => $class['user_id']))->row()->name;; ?></option>
        <?php } ?>
    </select>
</div>
<div class="form-group col-md-6">
  <label for="name"><?php echo get_phrase('coef'); ?></label>
  <input type="number" min="0" step="0.01" class="form-control" id="coef<?php echo $uses['id']; ?>" name="coef<?php echo $uses['id']; ?>">
</div>

<?php } ?>
<?php } ?>