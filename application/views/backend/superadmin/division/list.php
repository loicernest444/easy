<?php
$use = $this->db->get_where('schools', array('id' => $class_id))->row()->use_divisions;
if($use > 0){
$sections = $this->db->get_where('divisions', array('school_id' => $class_id))->result_array();
if (count($sections) > 0):
  foreach ($sections as $section): ?>
    <option value=""><?php echo get_phrase('no_need_to_link_to_division'); ?></option>
    <option value="<?php echo $section['id']; ?>"><?php echo $section['name'].' / '.$section['name_fr']; ?></option>
  <?php endforeach; ?>
<?php else: ?>
  <option value=""><?php echo get_phrase('no_division_found'); ?></option>
<?php endif; ?>
<?php } else{?>
  <option value=""><?php echo get_phrase('this_school_does_not_have_divisions'); ?></option>
<?php } ?>