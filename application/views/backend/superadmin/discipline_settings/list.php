<?php
if (isset($class_id)):
  $school_id  = school_id();
  if($class_id < 2){
      $check_data = $this->db->get_where('discipline_option', array('school_id' => $school_id, 'session' => active_session()))->result_array();
  
  if (count($check_data) > 0):?>
  <table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
    <thead>
      <tr style="background-color: #313a46; color: #ababab;">
        <th><?php echo get_phrase('name'); ?></th>
        <th><?php echo get_phrase('description'); ?></th>
        <th>...</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $school_id = school_id();
      $subjects = $this->db->get_where('discipline_option', array('school_id' => $school_id, 'session' => active_session()))->result_array();
      foreach($subjects as $subject){
        ?>
        <tr>
          <td><?php echo $subject['name']; ?><br><em><?php echo $subject['name_fr']; ?></em></td>
          <td><?php echo $subject['description']; ?><br><em><?php echo $subject['description_fr']; ?></em></td>
          <td>

            <div class="dropdown text-center">
    					<button type="button" class="btn btn-sm btn-icon btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
    					<div class="dropdown-menu dropdown-menu-right">
    						<!-- item-->
    						<a href="javascript:void(0);" class="dropdown-item" onclick="rightModal('<?php echo site_url('modal/popup/discipline_settings/edit/'.$subject['id'])?>', '<?php echo get_phrase('update_discipline_option'); ?>');"><?php echo get_phrase('edit'); ?></a>
    						<!-- item-->
    						<a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('discipline_settings/delete/'.$subject['id']); ?>', showAllSubjects)"><?php echo get_phrase('delete'); ?></a>
    					</div>
    				</div>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
<?php else: ?>
  <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>

<?php
 }
else{
      $check_data = $this->db->get_where('decisions', array('school_id' => $school_id, 'session' => active_session(), 'type' =>'discipline'))->result_array();
  
  if (count($check_data) > 0):?>
  <table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
    <thead>
      <tr style="background-color: #313a46; color: #ababab;">
        <th><?php echo get_phrase('discipline_option'); ?></th>
        <th><?php echo get_phrase('interval'); ?></th>
        <th><?php echo get_phrase('value'); ?></th>
        <th>...</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $school_id = school_id();
      $subjects = $this->db->get_where('decisions', array('school_id' => $school_id, 'session' => active_session(), 'type' =>"discipline"))->result_array();
      foreach($subjects as $subject){
          $x = $this->db->get_where('discipline_option', array('id' => $subject['option']))->row()->name;
          $y = $this->db->get_where('discipline_option', array('id' => $subject['option']))->row()->name_fr;
        ?>
        <tr>
            <td><?php echo $x.' / '.$y; ?></td>
            <td><?php echo $subject['from'].' '.get_phrase('to').' '.$subject['to']; ?>
                </td>
          <td><?php echo $subject['name']; ?><br><em><?php echo $subject['name_fr']; ?></em></td>
          <td>

            <div class="dropdown text-center">
    					<button type="button" class="btn btn-sm btn-icon btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
    					<div class="dropdown-menu dropdown-menu-right">
    						<!-- item-->
    						<a href="javascript:void(0);" class="dropdown-item" onclick="rightModal('<?php echo site_url('modal/popup/decision_settings/edit/'.$subject['id'])?>', '<?php echo get_phrase('update_decision'); ?>');"><?php echo get_phrase('edit'); ?></a>
    						<!-- item-->
    						<a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('decision_settings/delete/'.$subject['id']); ?>', showAllSubjects)"><?php echo get_phrase('delete'); ?></a>
    					</div>
    				</div>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
<?php else: ?>
  <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>
<?php } ?>

<?php else: ?>
  <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>