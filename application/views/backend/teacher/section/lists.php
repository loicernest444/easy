<?php

$sections = $this->db->get_where('exam_option', array('exam_id' => $class_id))->result_array();
if (count($sections) > 0):
  foreach ($sections as $section): ?>
    <option value="<?php echo $section['id']; ?>"><?php echo $section['name'].' / '.$section['name_fr']; ?></option>
  <?php endforeach; ?>
    <option value="0"><?php echo get_phrase('the_term'); ?></option>
  <?php else: ?>
  <option value=""><?php echo get_phrase('global_term_result'); ?></option>
<?php endif; ?>

 