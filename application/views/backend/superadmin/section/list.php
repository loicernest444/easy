<?php
$use = $this->db->get_where('classes', array('id' => $class_id))->row()->use_sections;
if($use > 0){
$sections = $this->db->get_where('sections', array('class_id' => $class_id))->result_array();
if (count($sections) > 0):
  foreach ($sections as $section): ?>
    <option value="<?php echo $section['id']; ?>"><?php echo $section['name']; ?></option>
  <?php endforeach; ?>
  <?php else: ?>
  <option value=""><?php echo get_phrase('no_section_found'); ?></option>
<?php endif; ?>

<?php } else{ ?>
  <option value="0">-</option>
<?php } ?>
