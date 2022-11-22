<?php
$sections = $this->db->get_where('division_option', array('division_id' => $class_id))->result_array();
$use = $this->db->get_where('division_option', array('division_id' => $class_id))->num_rows();
if($use > 0){
$sections = $this->db->get_where('division_option', array('division_id' => $class_id))->result_array();
if (count($sections) > 0):
  foreach ($sections as $section): ?>
    <option value=""><?php echo get_phrase('no_need_to_link_to_option'); ?></option>
    <option value="<?php echo $section['id']; ?>"><?php echo $section['name'].' / '.$section['name_fr']; ?></option>
  <?php endforeach; ?>
<?php else: ?>
  <option value=""><?php echo get_phrase('no_option_found'); ?></option>
<?php endif; ?>
<?php } else{?>
  <option value=""><?php echo get_phrase('this_division_does_not_have_options'); ?></option>
<?php } ?>