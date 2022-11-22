<?php
if($section_from > 0){
    $fn = ' - '.$this->db->get_where('sections', array('id' => $section_from))->row()->name;
}
if($section_to > 0){
  $tn = ' - '.$this->db->get_where('sections', array('id' => $section_to))->row()->name;
}else
if (isset($enrolments)): ?>

    <div class="row justify-content-md-center">
            <div class="col-md-10 mt-2">
                <div class="card text-white bg-secondary">
                    <div class="card-body">
                        <div class="toll-free-box text-left">
                            <h4 style="text-align : center"> <i class="mdi mdi-chart-bar-stacked"></i> <?php echo strtoupper(get_phrase('student_promotion')); ?></h4>
                            <h5><?php echo get_phrase('from').': '.$class_from_details['name'].$fn.' <br>'.get_phrase('to').' : '.$class_to_details['name'].$tn; ?></h5>
                            <h5 style="text-align : right"><?php echo get_phrase('from').' '.$session_from_details['name'].' '.get_phrase('to').' '.$session_to_details['name']; ?></h5>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

  <?php if (count($winners) > 0): ?>
        <div class="row justify-content-md-center">
            <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12 mb-3 mb-lg-0">
                <div class="table-responsive-sm">
                    <table class="table table-bordered table-striped dt-responsive nowrap" width="100%">
                        <thead class="thead-dark">
                        <tr>
                            <th colspan="6" style="text-align : center"><?php echo strtoupper(get_phrase('admitted_to_a_higher_class')); ?></th>
                        </tr>
                        <tr>
                            <th>#</th>
                            <th><?php echo get_phrase('image'); ?></th>
                            <th><?php echo get_phrase('student_name'); ?></th>
                            <th><?php echo get_phrase('averages'); ?></th>
<!--                            <th><?php echo get_phrase('status'); ?></th>-->
<!--                            <th><?php echo get_phrase('action'); ?></th>-->
                            <th><?php echo get_phrase('action'); ?></th>
                        </tr>
                        </thead>
                        <tbody id="succ">
                            <?php 
                            $c=1; foreach ($winners as $enrolment):
                                  $student_details = $this->user_model->get_student_details_by_id('student', $enrolment['student_id']);
                            
                            $cc = $this->crud_model->checkenroll($session_to, $student_details['id'])->num_rows();
                             ?>
                              <tr> 
                                  <td class="text-center">  <?php echo $c++; ?></td>
                                  <td class="text-center">
                                    <img src="<?php echo $this->user_model->get_user_image($student_details['id']); ?>" height="50" alt=""><br>
                                  </td>
                                  <td>
                                    <?php echo $student_details['name']; ?>
                                    <br>
                                    <small><b><?php echo get_phrase('student_code'); ?>:</b><?php echo $student_details['code']; ?></small>
                                  </td>
                                  <td>
                                    <?php echo $this->crud_model->get_global_averagepro($class_id_from, $section_from, $student_details['id'], $session_from)->row()->average ?>
                                  </td>
<!--
                                  <td style="text-align: center;">
                                      <span class="badge badge-info-lighten" id = "success_<?php echo $student_details['id']; ?>" style="display: none;"><?php echo get_phrase('promoted'); ?></span>
                                      <span class="badge badge-light"  id = "danger_<?php echo $student_details['id'] ?>"><?php echo get_phrase('not_promoted_yet'); ?></span>
                                  </td>
-->
<!--
                                  <td style="text-align: center;">
                                      <select class="form-control select2" data-toggle = "select2" required >
                                        <option value="1"><?php echo get_phrase('promote_to').' '.$class_to_details['name'];?></option>
                                        <option value="2"><?php echo get_phrase('redouble').' '.$class_from_details['name'];?></option>
                                        <option value="0"><?php echo get_phrase('not_applicable');?></option>

                                    </select> 
                                  </td>
-->
                                  <td style="text-align: center;">
                                      <?php if($cc < 1){?>
                                      <button type="button" class="btn btn-icon btn-success btn-sm" onclick="enrollStudent('<?php echo $enrolment['student_id'].'-'.$class_id_to.'-'.$section_to.'-'.$session_to; ?>', '<?php echo $enrolment['id']; ?>')"> <?php echo get_phrase('promote_to'); ?> <strong> <?php echo $class_to_details['name'].$tn; ?> </strong> </button> 
                                      <?php } else{?>
                                        <span class="badge badge-info-lighten" id = "success_<?php echo $student_details['id']; ?>" style="display: none;"><?php echo get_phrase('already_enrolled'); ?></span>
                                      <?php } ?>
                                  </td>
                              </tr>
                            <?php endforeach; ?>
                            <tr><td colspan="6">
                                <button type="button" class="btn btn-icon btn-success btn-sm" onclick="enrollStudentprom()"> <?php echo get_phrase('validate_all_promotion_to'); ?> <strong> <?php echo $class_to_details['name'].$tn; ?> </strong> </button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
  <?php else: ?>
         <table class="table table-bordered table-striped dt-responsive nowrap" width="100%">
            <thead class="thead-dark">
                <tr>
                    <th colspan="6" style="text-align : center"><?php echo strtoupper(get_phrase('admitted_to_a_higher_class')); ?></th>
                </tr>
            </thead>
        </table>
      <?php include APPPATH.'views/backend/empty.php'; ?>
      <table class="table table-bordered table-striped dt-responsive nowrap" width="100%">
            <thead class="thead-dark">
                <tr>
                    <th colspan="6" style="text-align : center"></th>
                </tr>
            </thead>
        </table>
  <?php endif; ?>

  <?php if (count($losers) > 0): ?>
        <div class="row justify-content-md-center">
            <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12 mb-3 mb-lg-0">
                <div class="table-responsive-sm">
                    <table class="table table-bordered table-striped dt-responsive nowrap" width="100%">
                        <thead class="thead-dark">
                        <tr>
                            <th colspan="6" style="text-align : center"><?php echo strtoupper(get_phrase('admitted_to_redouble')); ?></th>
                        </tr>
                        <tr>
                            <th>#</th>
                            <th><?php echo get_phrase('image'); ?></th>
                            <th><?php echo get_phrase('student_name'); ?></th>
                            <th><?php echo get_phrase('averages'); ?></th>
<!--                            <th><?php echo get_phrase('status'); ?></th>-->
<!--                            <th><?php echo get_phrase('action'); ?></th>-->
                            <th><?php echo get_phrase('action'); ?></th>
                        </tr>
                        </thead>
                        <tbody id="red">
                            <?php $c=1; foreach ($losers as $enrolment):
                                  $student_details = $this->user_model->get_student_details_by_id('student', $enrolment['student_id']);
                                $cc = $this->crud_model->checkenroll($session_to, $student_details['id'])->num_rows();
                            ?>
                              <tr> 
                                  <td class="text-center">  <?php echo $c++; ?></td>
                                  <td class="text-center">
                                    <img src="<?php echo $this->user_model->get_user_image($student_details['id']); ?>" height="50" alt=""><br>
                                  </td>
                                  <td>
                                    <?php echo $student_details['name']; ?>
                                    <br>
                                    <small><b><?php echo get_phrase('student_code'); ?>:</b><?php echo $student_details['code']; ?></small>
                                  </td>
                                  <td>
                                    <?php echo $this->crud_model->get_global_averagepro($class_id_from, $section_from, $student_details['id'], $session_from)->row()->average ?>
                                  </td>
<!--
                                  <td style="text-align: center;">
                                      <span class="badge badge-info-lighten" id = "success_<?php echo $student_details['id']; ?>" style="display: none;"><?php echo get_phrase('enrolled'); ?></span>
                                      <span class="badge badge-light"  id = "danger_<?php echo $student_details['id'] ?>"><?php echo get_phrase('not_enrolled_yet'); ?></span>
                                  </td>
-->
<!--
                                  <td style="text-align: center;">
                                      <select class="form-control select2" data-toggle = "select2" required >
                                        <option value="1"><?php echo get_phrase('promote_to').' '.$class_to_details['name'];?></option>
                                        <option value="2"><?php echo get_phrase('redouble').' '.$class_from_details['name'];?></option>
                                        <option value="0"><?php echo get_phrase('not_applicable');?></option>

                                    </select> 
                                  </td>
-->
                                  <td style="text-align: center;">
                                      <?php if($cc < 1){?>
                                      <button type="button" class="btn btn-icon btn-success btn-sm" onclick="enrollStudent('<?php echo $enrolment['student_id'].'-'.$class_id_to.'-'.$section_to.'-'.$session_to; ?>', '<?php echo $enrolment['id']; ?>')"> <?php echo get_phrase('promote_to'); ?> <strong> <?php echo $class_to_details['name'].$tn; ?> </strong> </button> 
                                      
                                      <button style="width : 100%; text-align : center;" type="button" class="btn btn-icon btn-secondary btn-sm" onclick="enrollStudent('<?php echo $enrolment['student_id'].'-'.$class_id_from.'-'.$section_from.'-'.$session_to; ?>', '<?php echo $enrolment['id']; ?>')"> <?php echo get_phrase('enroll_to'); ?> <strong> <?php echo $class_from_details['name'].$fn; ?> </strong> </button>
                                      <?php } else{?>
                                        <span class="badge badge-info-lighten" id = "success_<?php echo $student_details['id']; ?>" style="display: none;"><?php echo get_phrase('already_enrolled'); ?></span>
                                      <?php } ?>
                                      
                                  </td>
                              </tr>
                            <?php endforeach; ?>
                            <tr>
                            <td colspan="6">
                              <button type="button" class="btn btn-icon btn-secondary" onclick="enrollStudentred()"> <?php echo get_phrase('validate_all_enrollment_to'); ?> <strong> <?php echo $class_from_details['name'].$fn; ?> </strong> </button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
  <?php else: ?>
<div class="row justify-content-md-center">
            <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12 mb-3 mb-lg-0">
                <div class="table-responsive-sm">
         <table class="table table-bordered table-striped dt-responsive nowrap" width="100%">
            <thead class="thead-dark">
                <tr>
                    <th colspan="6" style="text-align : center"><?php echo strtoupper(get_phrase('admitted_to_a_higher_class')); ?></th>
                </tr>
            </thead>
        </table>
      <?php include APPPATH.'views/backend/empty.php'; ?>
      <table class="table table-bordered table-striped dt-responsive nowrap" width="100%">
            <thead class="thead-dark">
                <tr>
                    <th colspan="6" style="text-align : center"></th>
                </tr>
            </thead>
        </table>
</div>
            </div>
        </div>
  <?php endif; ?>

<?php else: ?>
  <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>
