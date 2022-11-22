<?php
$sections = $this->db->get_where('department', array('region_id' => $dep_id))->result_array();
if (count($sections) > 0):
  foreach ($sections as $section): ?>
    <option value="<?php echo $section['id']; ?>"><?php echo $section['name']; ?></option>
  <?php endforeach; ?>
  <?php else: ?>
  <option value=""><?php echo get_phrase('no_department_found'); ?></option>
<?php endif; ?>

