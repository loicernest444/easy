
<div class="row mb-3">
    <div class="col-md-12 toll-free-box text-center text-white pb-2" style="background-color: #6c757d; border-radius: 10px;">
        <h4><?php echo get_phrase('student_report_cards'); ?></h4>
        <span><?php echo get_phrase('class'); ?> : <?php echo $this->db->get_where('classes', array('id' => $class_id))->row('name'); ?></span><br>
        <span><?php echo get_phrase('section'); ?> : <?php echo $this->db->get_where('sections', array('id' => $section_id))->row('name'); ?></span><br>
        
        <?php if($subject_id > 0){?>
        <span><?php echo get_phrase('class'); ?> : <?php echo $this->db->get_where('subjects', array('id' => $subject_id))->row('name'); ?></span><br>
        <?php } ?>
    </div>
</div> 
<?php
$school_id = school_id();
if($exam > 0){
  $enrols = $this->crud_model->get_subdiv_global_average($class_id, $section_id, $exam)->result_array();
}elseif($exam_id > 0){
    $enrols = $this->crud_model->get_div_averages($class_id, $section_id, $exam_id)->result_array();
}elseif($exam_id ==0 && $exam ==0){
    $enrols = $this->crud_model->get_global_averages($class_id, $section_id)->result_array();
}



$nen = $this->crud_model->get_stu_average($class_id, $section_id)->num_rows();

?>

<div class="row"> 
  <div class="col-12">
      
      <div class="d-print-none mt-6">
            <div class="text-right">
              <a style="color:#fff; cursor:pointer;" onClick="PrintElem('#top')" class="btn btn-primary"><i class="mdi mdi-printer"></i> <?php echo get_phrase('print'); ?></a>
            </div>
          </div>
      
         
    <div id="top" >  
          <?php 
          $rank=1;  
        
          foreach($enrols as $mark){
        
          $rang = $rank++;
          if(($rang ==1) && (get_settings('language') =='french')){
              $rang = "1er";
          }elseif(($rang ==1 ||$rang ==21 ||$rang ==31 ||$rang ==41 ||$rang ==61 ) && (get_settings('language') =='english')){
              $rang = $rang.'st';
          }elseif(($rang > 1) && (get_settings('language') =='french')){
              $rang = $rang.'ème';
          }elseif(($rang ==2 ||$rang ==22 ||$rang ==32 ||$rang ==42 ||$rang ==62 ) && (get_settings('language') =='english')){
              $rang = $rang.'nd';
          }elseif(($rang ==3 ||$rang ==23 ||$rang ==33 ||$rang ==43 ||$rang ==63 ) && (get_settings('language') =='english')){
              $rang = $rang.'rd';
          } ?>
        <!-- Invoice Logo-->
       
    <div class="card"  style="page-break-after : always; background-image:url(<?php echo base_url();?>uploads/system/logo/bg.png); background-repeat : no-repeat; min-width:100%; min-height:100%; background-size: contain;"> 
      <div class="card-body" >
        <?php
              $student = $this->db->get_where('students', array('id' => $mark['student_id']))->row_array();
              $bt =$this->user_model->get_user_details($student['user_id'], 'birthtype');
              $div = $this->db->get_where('classes', array('id' => $class_id))->row('division_id');
              
              $op = $this->db->get_where('classes', array('id' => $class_id))->row('option_id');
              $us = $this->db->get_where('classes', array('id' => $class_id))->row('use_sections');
              if($us > 0){
                 $op = $this->db->get_where('sections', array('id' => $section_id))->row('option_id');
                 $opn = $this->db->get_where('division_option', array('id' => $op))->row('name');
                 $opnf = $this->db->get_where('division_option', array('id' => $op))->row('name_fr');
              }else{
                 $op = $this->db->get_where('classes', array('id' => $class_id))->row('option_id');
                 $opn = $this->db->get_where('division_option', array('id' => $op))->row('name');
                 $opnf = $this->db->get_where('division_option', array('id' => $op))->row('name_fr');
              }
              
              $divn = $this->db->get_where('divisions', array('id' => $div))->row('name');
              $divnf = $this->db->get_where('divisions', array('id' => $div))->row('name_fr');
              if ($section_id > 0){
                  $sec = $this->db->get_where('sections', array('id' => $section_id))->row('short_name');
                  $cnn = $this->db->get_where('classes', array('id' => $class_id))->row('name').' - '.$sec;
              }else{
                  $sec=' ';
                  $cnn = $this->db->get_where('classes', array('id' => $class_id))->row('name');
              }
              
               $bd = $this->user_model->get_user_details($student['user_id'], 'birthday'); 
              
              if($exam > 0){
                  $tid = $this->db->get_where('exam_option', array('id' => $exam))->row()->exam_id;
                  $term = $this->db->get_where('exam_option', array('id' => $exam))->row()->name;
                  $termf = $this->db->get_where('exam_option', array('id' => $exam))->row()->name_fr;
                  $termt = get_phrase('exam');
                  $termtf = get_phrase('Evaluation');
              }elseif($exam_id > 0){
                  $term = $this->db->get_where('exams', array('id' => $exam_id))->row()->name;
                  $termf = $this->db->get_where('exams', array('id' => $exam_id))->row()->name_fr;
                  $termt = get_phrase('term');
                  $termtf = get_phrase('Trimestre');
              }
              $subs =$this->db->get_where('subjects', array('class_id' => $class_id,'section_id' => $section_id,'school_id' => school_id(),'session' => active_session()))->result_array();
              $exs =$this->db->get_where('exam_option', array('exam_id' => $exam_id))->result_array();
              $exsy =$this->db->get_where('exams', array('session' => active_session()))->result_array();     
              $classex = $this->db->get_where('classes', array('id' => $class_id))->row()->type; 
              $nnexs =$this->db->get_where('exam_option', array('exam_id' => $exam_id))->num_rows();
                  $tcol = ($nnexs * 3) +3;
          ?>
          
        <div class="row">
             <?php include 'header.php'; ?>
          </div>    
        <div class="row">
            <?php
               if($exam_id ==0 && $exam ==0){                     
            ?>
            <table style="width : 85%;font-size:10px;float: left;">
                 <tr style="border : 1px solid black; color: #000;">
                      <td>Name(s) and surname(s) : <strong><?php echo $this->user_model->get_user_details($student['user_id'], 'name'); ?></strong>
                      <br><em>Nom(s) et prénom(s)</em></td>
                      <?php if($bt=="around") {?>
                        <td>Born around : <strong><?php echo $bd; ?></strong>
                        <br><em>Né(e) vers</em></td>
                      <?php } else{?>
                        <td>Born on : <strong><?php echo $bd; ?></strong>
                        <br><em>Né(e) le</em> </td>
                      <?php }?>
                      <td>At : <strong> <?php echo $this->user_model->get_user_details($student['user_id'], 'birthplace'); ?></strong>
                      <br><em>À</em> </td>
                      <td>Sex : <strong> <?php echo get_phrase($this->user_model->get_user_details($student['user_id'], 'gender')); ?></strong>
                        <br><em>Sexe</em> </td>
                  </tr>
                    
                  <tr style="border : 1px solid black; color: #000; ">
                      <td>Academic year : <strong><?php echo active_session("name"); ?></strong>
                      <br><em>Année académique</em> </td>
                      <td>Class : <strong><?php echo $cnn; ?></strong>
                      <br><em>Classe</em> </td>
                      <td> <strong>ANNUAL RESULT</strong>
                      <br><em>RESULTAT ANNUEL</em> </td>
                      <td></td>
                  </tr>
                    
                  <tr style="border : 1px solid black; color: #000; ">
                      <td>Section : <strong><?php echo $divn; ?></strong>
                      <br><em>Section : <?php echo $divnf; ?></em> </td>
                      <td>Option : <strong><?php echo $opn; ?></strong>
                      <br><em>Filière : <?php echo $opnf; ?></em> </td>
                      <td> Effectif : <strong><?php echo $nen; ?></strong>
                      <br><em>Éffectif</em> </td>
                      <td> <strong></strong></td>
                  </tr>
            </table>
            <?php
               }else{                     
            ?>
            <table style="width : 85%;font-size:10px;float: left;">
                 <tr style="border : 1px solid black; color: #000;">
                      <td>Name(s) and surname(s) : <strong><?php echo $this->user_model->get_user_details($student['user_id'], 'name'); ?></strong>
                      <br><em>Nom(s) et prénom(s)</em></td>
                      <?php if($bt=="around") {?>
                        <td>Born around : <strong><?php echo $bd; ?></strong>
                        <br><em>Né(e) vers</em></td>
                      <?php } else{?>
                        <td>Born on : <strong><?php echo $bd; ?></strong>
                        <br><em>Né(e) le</em> </td>
                      <?php }?>
                      <td>At : <strong> <?php echo $this->user_model->get_user_details($student['user_id'], 'birthplace'); ?></strong>
                      <br><em>À</em> </td>
                      <td>Sex : <strong> <?php echo get_phrase($this->user_model->get_user_details($student['user_id'], 'gender')); ?></strong>
                        <br><em>Sexe</em> </td>
                  </tr>
                    
                  <tr style="border : 1px solid black; color: #000; ">
                      <td>Academic year : <strong><?php echo active_session("name"); ?></strong>
                      <br><em>Année académique</em> </td>
                      <td>Class : <strong><?php echo $cnn; ?></strong>
                      <br><em>Classe</em> </td>
                      <td><?php echo $termt; ?> : <strong><?php echo $term; ?></strong>
                      <br><em><?php echo $termtf; ?> : <?php echo $termf; ?></em> </td>
                      <td></td>
                  </tr>
                    
                  <tr style="border : 1px solid black; color: #000; ">
                      <td>Section : <strong><?php echo $divn; ?></strong>
                      <br><em>Section : <?php echo $divnf; ?></em> </td>
                      <td>Option : <strong><?php echo $opn; ?></strong>
                      <br><em>Filière : <?php echo $opnf; ?></em> </td>
                      <td> Effectif : <strong><?php echo $nen; ?></strong>
                      <br><em>Éffectif</em> </td>
                      <td> <strong></strong></td>
                  </tr>
            </table>
            <?php
               }                    
            ?>
            
            <table style="width : 15%;float: left;">
                
                  <tr style="border : 1px solid white; color: #000;text-align : center;">
                      <td><img class="rounded-circle" width="90" height="90" src="<?php echo $this->user_model->get_user_image($student['user_id']); ?>"></td>
                  </tr>
            </table>
            
        </div>
        <div class="row">
              <table style="width : 100%;font-size:10px;">
                <?php if($exam > 0){?>
                <thead>
                  <tr style="border : 1px solid black; color: #000; background-color : #ccc; text-align : center;">
                    <th style="border : 1px solid black;">School subjects
                      <small style="margin-top: -5px; " class="form-text"><em>Matières</em></small></th>
                    <th style="border : 1px solid black;">Notes
                      <small style="margin-top: -5px; " class="form-text"><em>Notes</em></small></th>
                    <th style="border : 1px solid black;">Coef
                      <small style="margin-top: -5px; " class="form-text"><em>Coef</em></small></th>
                    <th style="border : 1px solid black;">Mark*Coef
                      <small style="margin-top: -5px; " class="form-text"><em>Notes*Coef</em></small></th>
                    <th style="border : 1px solid black;">Remarks
                      <small style="margin-top: -5px; " class="form-text"><em>Remarques</em></small></th>
                    <th colspan="2" style="border : 1px solid black;">Teacher names and signatures
                      <small style="margin-top: -5px; " class="form-text"><em>Noms des enseignants et signatures</em></small></th>
                  </tr>
                </thead>
                <?php } elseif($exam_id > 0){?>  
                <thead>
                  <tr style="border : 1px solid black; color: #000; background-color : #ccc; text-align : center;">
                    <th style="border : 1px solid black;">School subjects
                      <small style="margin-top: -5px; " class="form-text"><em>Matières</em></small></th>
                    <?php
                     foreach($exs as $bids){ ?>
                       <th style="border : 1px solid black;"><?php echo $bids['name']; ?>
                      <small style="margin-top: -5px; " class="form-text"><em><?php echo $bids['name_fr']; ?></em></small></th>
                    <?php } ?>
                    <th style="border : 1px solid black;">Mark
                      <small style="margin-top: -5px; " class="form-text"><em>Note</em></small></th>
                    <th style="border : 1px solid black;">Coef
                      <small style="margin-top: -5px; " class="form-text"><em>Coef</em></small></th>
                    <th style="border : 1px solid black;">Mark*Coef
                      <small style="margin-top: -5px; " class="form-text"><em>Notes*Coef</em></small></th>
                    <th style="border : 1px solid black;">Remarks
                      <small style="margin-top: -5px; " class="form-text"><em>Remarques</em></small></th>
                    <th colspan="2" style="border : 1px solid black;">Teacher names and signatures
                      <small style="margin-top: -5px; " class="form-text"><em>Noms des enseignants et signatures</em></small></th>
                  </tr>
                </thead>
                <?php } elseif($exam ==0 && $exam_id ==0){?>  
                <thead>
                  <tr style="border : 1px solid black; color: #000; background-color : #ccc; text-align : center;">
                    <th style="border : 1px solid black;">School subjects
                      <small style="margin-top: -5px; " class="form-text"><em>Matières</em></small></th>
                    <?php
                   
                     foreach($exsy as $exsy){ 
                     $exs =$this->db->get_where('exam_option', array('exam_id' => $exsy['id']))->result_array();
                         foreach($exs as $bids){ ?>
                           <th style="border : 1px solid black;"><?php echo $bids['short_name']; ?>
                          <small style="margin-top: -5px; " class="form-text"><em><?php echo $bids['short_name_fr']; ?></em></small></th>
                        <?php } ?>
                    <?php } ?>
                    <th style="border : 1px solid black;">Mark
                      <small style="margin-top: -5px; " class="form-text"><em>Note</em></small></th>
                    <th style="border : 1px solid black;">Coef
                      <small style="margin-top: -5px; " class="form-text"><em>Coef</em></small></th>
                    <th style="border : 1px solid black;">Mark*Coef
                      <small style="margin-top: -5px; " class="form-text"><em>Notes*Coef</em></small></th>
                    <th style="border : 1px solid black;">Remarks
                      <small style="margin-top: -5px; " class="form-text"><em>Remarques</em></small></th>
                    <th colspan="2" style="border : 1px solid black;">Teacher names and signatures
                      <small style="margin-top: -5px; " class="form-text"><em>Noms des enseignants et signatures</em></small></th>
                  </tr>
                </thead>
                  <?php } ?>
                  
                <tbody>
                   <?php 
                    if($exam > 0){
                
              // if it is year subdivisions
                    if($display > 0){
                      $school_id = school_id();
                      $subjects = $this->db->get_where('subject_settings', array('school_id' => $school_id, 'session' => active_session(), 'type' => 1))->result_array();
                      foreach($subjects as $subject){
                      $tc=0; $tg=0;  
                      $is = $this->db->get_where('subjects', array('class_id' => $class_id,'section_id' => $section_id, 'group' => $subject['id']))->num_rows();
                      $subs = $this->db->get_where('subjects', array('class_id' => $class_id,'section_id' => $section_id, 'group' => $subject['id']))->result_array();
                      if ($is > 0){?>
                    
                    <!-- subject linked to groups -->
                    <tr style="border : 1px solid black; color: #000; text-align : center;">
                        <td colspan="7"><strong><?php echo $subject['name'].' / '.$subject['name_fr']; ?></strong></td>
                    </tr>
                    <?php
                    
                    foreach($subs as $sub){
                    $tc+=$this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $exam, $mark['student_id'])->row()->coef ;
                    $tg+=$this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $exam, $mark['student_id'])->row()->mark_obtained *$this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $exam, $mark['student_id'])->row()->coef;
                    $coeff =$this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $exam, $mark['student_id'])->row()->coef; ?>
                    <tr style="border : 1px solid black;">
                       <td style="border : 1px solid black;color: #000;"><?php echo ' '.$sub['name']; ?></td> 
                       <td style="border : 1px solid black;text-align : center;
                        <?php
                         if ($this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $exam, $mark['student_id'])->row()->mark_obtained < 10 && $coeff ==0 ){ $rr=1; ?> color: red; <?php } else{ $rr=0; ?>color: #000;<?php } ?>
                         "><?php if($coeff > 0){echo $this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $exam, $mark['student_id'])->row()->mark_obtained ;} ?></td> 
                        
                       <td style="border : 1px solid black;text-align : center;color: #000;"><?php echo $sub['coef']; ?></td> 
                        
                       <td style="border : 1px solid black;text-align : center; <?php if ($rr > 0){?> color: red;<?php } else {?> color: #000;<?php } ?>"><?php if($coeff > 0 ){ echo $this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $exam, $mark['student_id'])->row()->mark_obtained *$this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $exam, $mark['student_id'])->row()->coef ;} ?></td>
                        
                       <td style="border : 1px solid black;text-align : center;color: #000;"><strong>
                            <?php if($coeff > 0){echo get_grades($this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $exam, $mark['student_id'])->row()->mark_obtained) ;} ?></strong></td>
                       <td colspan="2" style="border : 1px solid black;color: #000;"><?php $teach =$this->db->get_where('teachers', array('id' => $sub['teacher_id']))->row()->user_id; echo $this->db->get_where('users', array('id' => $teach))->row('name');?> </td>
                    </tr>
                    <?php } ?>
                    <tr style="border : 1px solid black; color: #000;">
                        <td style="border : 1px solid black;  text-align : center;" colspan="2"><strong>Average of the group / Moyenne du groupe</strong></td>
                        <td style="border : 1px solid black; background-color : #ccc; text-align : center;"><strong><?php echo $tc; ?></strong></td>
                        <td style="border : 1px solid black; background-color : #ccc; text-align : center;"><strong><?php echo $tg; ?></strong></td>
                        <td style="border : 1px solid black;  background-color : #ccc; text-align : center;"><strong><?php if($tg > 0){ echo (Round(($tg/$tc),2));} ?></strong></td>
                        <td colspan="2" style="border : 1px solid black; text-align : center;"><strong><?php $t='class_council'; echo get_class_council($tg, $t, $school_id,active_session()); ?></strong></td>
                    </tr>
                    <?php } ?>
                    <?php } ?>
                    <!-- subject not linked to groups when displaying groups -->
                    <?php
                        
                    $subsn = $this->db->get_where('subjects', array('class_id' => $class_id,'section_id' => $section_id, 'group' => 0))->num_rows(); 
                    if($subsn > 0){
                    ?>
                    <tr style="border : 1px solid black; color: #000; text-align : center;">
                        <td colspan="7"><strong>Others / Autres</strong></td>
                    </tr>
                    <?php
                    $tc=0; $tg=0;  
                    $subs = $this->db->get_where('subjects', array('class_id' => $class_id,'section_id' => $section_id, 'group' => 0))->result_array();
                    foreach($subs as $sub){
                    $tc+=$this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $exam, $mark['student_id'])->row()->coef ;
                    $tg+=$this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $exam, $mark['student_id'])->row()->mark_obtained *$this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $exam, $mark['student_id'])->row()->coef ;
                    $coeff =$this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $exam, $mark['student_id'])->row()->coef;?>
                    <tr style="border : 1px solid black; ">
                       <td style="border : 1px solid black;color: #000;"><?php echo ' '.$sub['name']; ?></td> 
                       <td style="border : 1px solid black;text-align : center;
                        <?php
                         if ($this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $exam, $mark['student_id'])->row()->mark_obtained < 10){ $rr=1; ?> color: red; <?php } else{ $rr=0; ?>color: #000;<?php } ?>
                                  
                        "><?php if($coeff > 0){echo $this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $exam, $mark['student_id'])->row()->mark_obtained;} ?></td> 
                        
                       <td style="border : 1px solid black;text-align : center;color: #000;"><?php echo $sub['coef']; ?></td> 
                        
                       <td style="border : 1px solid black;text-align : center;<?php if ($rr > 0){?> color: red;<?php } else {?> color: #000;<?php } ?>"><?php if($coeff > 0){ echo $this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $exam, $mark['student_id'])->row()->mark_obtained *$this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $exam, $mark['student_id'])->row()->coef;} ?></td>
                        
                       <td style="border : 1px solid black;text-align : center;color: #000;"><?php if($coeff > 0){echo get_grades($this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $exam, $mark['student_id'])->row()->mark_obtained) ;} ?></td>
                       <td colspan="2" style="border : 1px solid black;color: #000;"><?php $teach =$this->db->get_where('teachers', array('id' => $sub['teacher_id']))->row()->user_id; echo $this->db->get_where('users', array('id' => $teach))->row('name');?> </td>
                    </tr>
                    <?php } ?>
                    <tr style="border : 1px solid black; color: #000;">
                        <td style="border : 1px solid black;  text-align : center;" colspan="2"><strong>Average of the group / Moyenne du groupe</strong></td>
                        <td style="border : 1px solid black; background-color : #ccc; text-align : center;"><strong><?php echo $tc; ?></strong></td>
                        <td style="border : 1px solid black; background-color : #ccc; text-align : center;"><strong><?php echo $tg; ?></strong></td>
                        <td style="border : 1px solid black;  background-color : #ccc; text-align : center;"><strong><?php if($tg > 0){ echo (Round(($tg/$tc),2));} ?></strong></td>
                        <td colspan="2" style="border : 1px solid black; text-align : center;"><strong><?php $t='class_council'; echo get_class_council($tg, $t, $school_id,active_session()); ?></strong></td>
                    </tr>
                    
                    <?php } ?>
                    <?php } else{
                    foreach($subs as $sub){ 
                    $coeff =$this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $exam, $mark['student_id'])->row()->coef;?>
                    <tr style="border : 1px solid black;">
                       <td style="border : 1px solid black;color: #000;"><?php echo ' '.$sub['name']; ?></td> 
                       <td style="border : 1px solid black;text-align : center;
                        <?php
                         if ($this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $exam, $mark['student_id'])->row()->mark_obtained < 10  && $coeff ==0 ){$rr=1;?> color: red; <?php } else{ $rr=0; ?>color: #000;<?php } ?>
                                  
                        "><?php if($coeff > 0){echo $this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $exam, $mark['student_id'])->row()->mark_obtained ;} ?></td> 
                        
                       <td style="border : 1px solid black;text-align : center;color: #000;"><?php echo $sub['coef']; ?></td> 
                        
                       <td style="border : 1px solid black;text-align : center;<?php if ($rr > 0){?> color: red;<?php } else {?> color: #000;<?php } ?>"><?php if($coeff > 0){echo $this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $exam, $mark['student_id'])->row()->mark_obtained *$this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $exam, $mark['student_id'])->row()->coef;} ?></td>
                        
                       <td style="border : 1px solid black;text-align : center;color: #000;"><?php if($coeff > 0){echo get_grades($this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $exam, $mark['student_id'])->row()->mark_obtained) ;} ?></td>
                       <td colspan="2" style="border : 1px solid black;color: #000;"><?php $teach =$this->db->get_where('teachers', array('id' => $sub['teacher_id']))->row()->user_id; echo $this->db->get_where('users', array('id' => $teach))->row('name');?> </td>
                    </tr>
                    
                    <?php } ?>
                  <?php }?> 
                    <tr style="border : 1px solid black; color: #000;text-align : center;">
                        <td  colspan="7"></td>
                    </tr>
                    <!-- display summary of the marksheet -->
                    <tr style="border : 1px solid black; color: #000;background-color : #ccc; text-align : center;">
                        <td colspan="7"><strong> Summary / Récapitulatif </strong></td>
                    </tr> 
                    <tr style="border : 1px solid black; color: #000;background-color : #ccc; text-align : center;">
                        <td style="border : 1px solid black;text-align : center;"><strong>General average of the class</strong>
                        <small style="margin-top: -5px; " class="form-text"><em>Moyenne générale de la classe</em></small></td>
                        <td style="border : 1px solid black;text-align : center;"><strong>Total marks</strong>
                        <small style="margin-top: -5px; " class="form-text"><em>Total notes</em></small></td>
                        <td colspan="2" style="border : 1px solid black;text-align : center;"><strong>Total coef</strong>
                        <small style="margin-top: -5px; " class="form-text"><em>Total coef</em></small></td>
                        <td style="border : 1px solid black;text-align : center;"><strong>Rank</strong>
                        <small style="margin-top: -5px; " class="form-text"><em>Rang</em></small></td>
                        <td colspan="2" style="border : 1px solid black;text-align : center;"><strong>Average</strong><small style="margin-top: -5px; " class="form-text"><em>Moyenne</em></small></td>
                    </tr>
                    <tr style="border : 1px solid black; color: #000;background-color : #ccc; text-align : center;">
                        <td style="border : 1px solid black;text-align : center;"><strong> <?php echo $this->crud_model->get_subdiv_gaverage($class_id, $section_id, $exam)->row()->average ; ?></strong></td>
                        <td style="border : 1px solid black;text-align : center;"><strong><?php echo $this->crud_model->get_subdiv_average($class_id, $section_id, $exam, $mark['student_id'])->row()->total_mark ; ?></strong></td>
                        <td colspan="2" style="border : 1px solid black;text-align : center;"><strong><?php echo $this->crud_model->get_subdiv_average($class_id, $section_id, $exam, $mark['student_id'])->row()->total_coef ; ?></strong></td>
                        <td style="border : 1px solid black;text-align : center;"><strong>
                        <?php echo $rang.' /'.$nen; ?>
                        </strong></td>
                        <td colspan="2" style="border : 1px solid black;text-align : center;"><strong><h4><?php echo round($this->crud_model->get_subdiv_average($class_id, $section_id, $exam, $mark['student_id'])->row()->average,2); ?></h4></strong></td>
                    </tr>
                    <tr style="border : 1px solid black; color: #000;text-align : center;">
                        <td  colspan="7"></td>
                    </tr>
                    <!-- display decisions -->
                    <tr style="border : 1px solid black; color: #000;background-color : #ccc; text-align : center;">
                        <td colspan="2" style="border : 1px solid black;text-align : center;"><strong>Discipline decisions</strong>
                        <small style="margin-top: -5px; " class="form-text"><em>Décisions du conseil de discipline</em></small></td>
                        <td colspan="3" style="border : 1px solid black;text-align : center;"><strong>Class council decisions</strong><small style="margin-top: -5px; " class="form-text"><em>Décisions du conseil de classe</em></small></td>
                        <td colspan="2" style="border : 1px solid black;text-align : center;"><strong>Appreciation</strong><small style="margin-top: -5px; " class="form-text"><em>Appréciations</em></small></td>
                    </tr>
                    <tr style="border : 1px solid black; color: #000;">
                        <td colspan="2" style="border : 1px solid black;">
                            <?php 
                              $bidsd=$this->db->get_where('discipline_option', array('school_id' => school_id(), 'session' => active_session()))->result_array();
              
                             $iid = $this->db->get_where('discipline', array('school_id' => school_id(), 'session' => active_session(),'class_id' => $class_id,'section_id' => $section_id,'exam_id' => $exam, 'student_id' =>$mark['student_id']))->row()->id;
              
                              foreach($bidsd as $bidsd){?>
                                <?php echo $bidsd['name'].'/'.$bidsd['name_fr'].' : <strong>'.$this->db->get_where('discipline_data', array('option_id' => $bidsd['id'], 'discipline_id' => $iid))->row('mark_obtained').'</strong>'; ?> <br>
                              <small style="margin-top: -5px;" class="form-text"><em>
                                <?php
                                 echo get_discipline_decision($this->db->get_where('discipline_data', array('option_id' => $bidsd['id'], 'discipline_id' => $iid))->row('mark_obtained'), $bidsd['id'], school_id(), active_session());  ?>
                                </em></small>
                              <?php } ?>
                        </td>
                        <td colspan="3" style="border : 1px solid black; text-align : center;">
                            <?php
                             $ave =$this->crud_model->get_div_average($class_id, $section_id, $exam, $mark['student_id'])->row()->average; 
                                echo get_class_council($ave,school_id(), active_session()); 
                            ?><br>
                            <small style="margin-top: -5px; " class="form-text"> - <em>
                                <?php
                                 echo get_class_councilf($ave, school_id(), active_session()); 
                            ?>
                                </em></small>
                        </td>
                       
                        <td colspan="2" style="border : 1px solid black;text-align : center;"><strong>
                            <?php echo get_grade($ave) ; ?></strong>
                        </td>
                    </tr>
                    <tr style="border : 1px solid black; color: #000;">
                        <td colspan="2" style="border : 1px solid black;text-align : center;background-color : #ccc; "><strong>Subjects where efforts are needed </strong><small style="margin-top: -5px; " class="form-text"><em>Un éffort s'impose en</em></small></td>
                        <td colspan="5" style="border : 1px solid black;text-align : center;"><strong><?php echo $this->db->get_where('schools', array('id' =>school_id()))->row()->address; ?>, .....................................</strong></td>
                    </tr>
                    
                    <tr style="border : 1px solid black; color: #000;">
                        <td colspan="2" style="border : 1px solid black;">
                        <?php
                          $sub= $this->db->get_where('marks', array('school_id' => $school_id, 'session' => active_session(), 'student_id' =>$mark['student_id'], 'exam_id' => $exam, 'class_id' => $class_id, 'section_id' => $section_id))->result_array(); 
                          $ca = get_settings('mark_to_catch'); 
              
                          foreach($sub as $su){
                              $z++;
                              if (($su['mark_obtained'] < $ca) && ($su['coef'] > 0)){
                                 echo $this->db->get_where('subjects', array('id' => $su['subject_id']))->row('name').'; <br>';
                              }
                              }
                      ?>
                        </td>
                        <td colspan="5" style="border : 1px solid black;">
                            <h5><?php echo $this->db->get_where('schools', array('id' =>school_id()))->row()->title; ?></h5><br><br>
                        </td>
                    </tr>
                  <?php 
            } 
               
              // if it is year division                
                    elseif($exam_id > 0){?>  
                    
                    <?php
                    if($display > 0){
                      $school_id = school_id();
                      $subjects = $this->db->get_where('subject_settings', array('school_id' => $school_id, 'session' => active_session(), 'type' => 1))->result_array();
                      foreach($subjects as $subject){
                      $tc=0; $tg=0;  
                      $is = $this->db->get_where('subjects', array('class_id' => $class_id,'section_id' => $section_id, 'group' => $subject['id']))->num_rows();
                      $subs = $this->db->get_where('subjects', array('class_id' => $class_id,'section_id' => $section_id, 'group' => $subject['id']))->result_array();
                      if ($is > 0){?>
                    
                    <!-- subject linked to groups -->
                    <tr style="border : 1px solid black; color: #000; text-align : center;">
                        <td colspan="<?php echo ($nnexs +7); ?>"><strong><?php echo $subject['name'].' / '.$subject['name_fr']; ?></strong></td>
                    </tr>
                    <?php
                    foreach($subs as $sub){
                    $tc+=$this->crud_model->get_subject_average($class_id, $section_id, $sub['id'], $exam_id, $mark['student_id'])->row()->coef;
                    $tg+=$this->crud_model->get_subject_average($class_id, $section_id, $sub['id'], $exam_id, $mark['student_id'])->row()->mark_obtained *$sub['coef'];
                    $coeff = $this->crud_model->get_subject_average($class_id, $section_id, $sub['id'], $exam_id, $mark['student_id'])->row()->coef; ?>
                    <tr style="border : 1px solid black;">
                       <td style="border : 1px solid black;"><?php echo $sub['name']; ?></td> 
                       <?php
                        foreach($exs as $bids){ ?>
                         <td style="border : 1px solid black;text-align : center;
                         <?php
                         if ($this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $bids['id'], $mark['student_id'])->row()->mark_obtained < 10){?> color: red; <?php } else{?>color: #000;<?php } ?>
                                    
                         "><?php if($coeff > 0){echo $this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $bids['id'], $mark['student_id'])->row()->mark_obtained ;} ?></td> 
                        <?php } ?>
                        
                        <td style="border : 1px solid black;text-align : center;<?php if ($this->crud_model->get_subject_average($class_id, $section_id, $sub['id'], $exam_id, $mark['student_id'])->row()->mark_obtained < 10){ $rr=1; ?> color: red;<?php } else {$rr =0; ?> color: #000;<?php } ?>"><?php if($coeff > 0){ echo $this->crud_model->get_subject_average($class_id, $section_id, $sub['id'], $exam_id, $mark['student_id'])->row()->mark_obtained;} ?></td>
                        
                       <td style="border : 1px solid black;text-align : center;color: #000;"><?php echo $sub['coef']; ?></td> 
                        
                       <td style="border : 1px solid black;text-align : center;<?php if ($rr > 0){?> color: red;<?php } else {?> color: #000;<?php } ?>"><?php if($coeff > 0){echo $this->crud_model->get_subject_average($class_id, $section_id, $sub['id'], $exam_id, $mark['student_id'])->row()->mark_obtained *$sub['coef'];} ?></td>
                        
                       <td style="border : 1px solid black;text-align : center;">
							 <?php if($coeff > 0){echo get_grades($this->crud_model->get_subject_average($class_id, $section_id, $sub['id'], $exam_id, $mark['student_id'])->row()->mark_obtained) ;} ?></td>
                      
                       <td colspan="2" style="border : 1px solid black;color: #000;"><?php $teach =$this->db->get_where('teachers', array('id' => $sub['teacher_id']))->row()->user_id; echo $this->db->get_where('users', array('id' => $teach))->row('name');?> </td>
                    </tr>
                    <?php } ?>
                    <tr style="border : 1px solid black; color: #000;">
                        <td style="border : 1px solid black;  text-align : center;" colspan="<?php echo ($nnexs +2); ?>"><strong>Average of the group / Moyenne du groupe</strong></td>
                        <td style="border : 1px solid black; background-color : #ccc; text-align : center;"><strong><?php echo $tc; ?></strong></td>
                        <td style="border : 1px solid black; background-color : #ccc; text-align : center;"><strong><?php echo $tg; ?></strong></td>
                        <td style="border : 1px solid black;  background-color : #ccc; text-align : center;"><strong><?php if($tg > 0){ echo (Round(($tg/$tc),2));} ?></strong></td>
                        <td colspan="2" style="border : 1px solid black; text-align : center;"><strong><?php $t='class_council'; echo get_class_council($tg, $t, $school_id,active_session()); ?></strong></td>
                    </tr>
                    <?php } ?>
                    <?php } ?>
                    <!-- subject not linked to groups when displaying groups -->
                    <?php
                    $tc=0; $tg=0;  
                    $subsn = $this->db->get_where('subjects', array('class_id' => $class_id,'section_id' => $section_id, 'group' => 0))->num_rows(); 
                    if($subsn > 0){?>
                    <tr style="border : 1px solid black; color: #000; text-align : center;">
                        <td colspan="<?php echo ($nnexs +7); ?>"><strong><?php echo get_phrase('others'); ?></strong></td>
                    </tr>
                    <?php
                    $tc=0; $tg=0;  
                    $subs = $this->db->get_where('subjects', array('class_id' => $class_id,'section_id' => $section_id, 'group' => 0))->result_array();
                    foreach($subs as $sub){
                    $tc+=$this->crud_model->get_subject_average($class_id, $section_id, $sub['id'], $exam_id, $mark['student_id'])->row()->coef;
                    $tg+=$this->crud_model->get_subject_average($class_id, $section_id, $sub['id'], $exam_id, $mark['student_id'])->row()->mark_obtained * $this->crud_model->get_subject_average($class_id, $section_id, $sub['id'], $exam_id, $mark['student_id'])->row()->coef;
                        
                    $coeff = $this->crud_model->get_subject_average($class_id, $section_id, $sub['id'], $exam_id, $mark['student_id'])->row()->coef;?>
                    <tr style="border : 1px solid black;">
                       <td style="border : 1px solid black;"><?php echo $sub['name']; ?></td> 
                       <?php
                        foreach($exs as $bids){ ?>
                         <td style="border : 1px solid black;text-align : center;
                        <?php
                         if ($this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $bids['id'], $mark['student_id'])->row()->mark_obtained < 10){?> color: red; <?php } else{?>color: #000;<?php } ?>            
                        "><?php if($coeff > 0){echo $this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $bids['id'], $mark['student_id'])->row()->mark_obtained;} ?></td> 
                        <?php } ?>
                        
                        <td style="border : 1px solid black;text-align : center; <?php if ($this->crud_model->get_subject_average($class_id, $section_id, $sub['id'], $exam_id, $mark['student_id'])->row()->mark_obtained < 10){$rr=1;?> color: red;<?php } else {$rr=0;?> color: #000;<?php } ?>"><?php if($coeff > 0){echo $this->crud_model->get_subject_average($class_id, $section_id, $sub['id'], $exam_id, $mark['student_id'])->row()->mark_obtained;} ?></td>
                        
                       <td style="border : 1px solid black;text-align : center; color: #000;"><?php echo $sub['coef']; ?></td> 
                        
                       <td style="border : 1px solid black;text-align : center; <?php if ($rr > 0){?> color: red;<?php } else {?> color: #000;<?php } ?>"><?php if($coeff > 0){echo $this->crud_model->get_subject_average($class_id, $section_id, $sub['id'], $exam_id, $mark['student_id'])->row()->mark_obtained *$sub['coef'];} ?></td>
                        
                       <td style="border : 1px solid black;text-align : center; color: #000;"> <?php if($coeff > 0){echo get_grades($this->crud_model->get_subject_average($class_id, $section_id, $sub['id'], $exam_id, $mark['student_id'])->row()->mark_obtained) ;} ?></td>
                      
                       <td colspan="2" style="border : 1px solid black; color: #000;"><?php $teach =$this->db->get_where('teachers', array('id' => $sub['teacher_id']))->row()->user_id; echo $this->db->get_where('users', array('id' => $teach))->row('name');?> </td>
                    </tr>
                    <?php } ?>
                    <tr style="border : 1px solid black; color: #000;">
                        <td style="border : 1px solid black;  text-align : center;" colspan="<?php echo ($nnexs +2); ?>"><strong>Average of the group / Moyenne du groupe</strong></td>
                        <td style="border : 1px solid black; background-color : #ccc; text-align : center;"><strong><?php echo $tc; ?></strong></td>
                        <td style="border : 1px solid black; background-color : #ccc; text-align : center;"><strong><?php echo $tg; ?></strong></td>
                        <td style="border : 1px solid black;  background-color : #ccc; text-align : center;"><strong><?php if($tg > 0){ echo (Round(($tg/$tc),2));} ?></strong></td>
                        <td colspan="2" style="border : 1px solid black; text-align : center;"><strong><?php $t='class_council'; echo get_class_council($tg, $t, $school_id,active_session()); ?></strong></td>
                    </tr>
                    
                    <?php } ?> 
                    <?php } else{ 
                    foreach($subs as $sub){ 
                    $coeff = $this->crud_model->get_subject_average($class_id, $section_id, $sub['id'], $exam_id, $mark['student_id'])->row()->coef;?>
                    <tr style="border : 1px solid black;">
                       <td style="border : 1px solid black;"><?php echo $sub['name']; ?></td> 
                        <?php
                        foreach($exs as $bids){ ?>
                         <td style="border : 1px solid black;text-align : center;
                        <?php
                         if ($this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $bids['id'], $mark['student_id'])->row()->mark_obtained < 10){?> color: red; <?php } else{?>color: #000;<?php } ?>             
                        "><?php if($coeff > 0){echo $this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $bids['id'], $mark['student_id'])->row()->mark_obtained;} ?></td> 
                        <?php } ?>
                        
                       <td style="border : 1px solid black;text-align : center;<?php if ($this->crud_model->get_subject_average($class_id, $section_id, $sub['id'], $exam_id, $mark['student_id'])->row()->mark_obtained < 10){ $rr=1; ?> color: red;<?php } else {$rr=0; ?> color: #000;<?php } ?>"><?php if($coeff > 0){echo $this->crud_model->get_subject_average($class_id, $section_id, $sub['id'], $exam_id, $mark['student_id'])->row()->mark_obtained;} ?></td>
                        
                        <td style="border : 1px solid black;text-align : center;color: #000;"><?php echo $sub['coef']; ?></td> 
                        
                        <td style="border : 1px solid black;text-align : center;<?php if ($rr > 0){?> color: red;<?php } else {?> color: #000;<?php } ?>"><?php if($coeff > 0){echo $this->crud_model->get_subject_average($class_id, $section_id, $sub['id'], $exam_id, $mark['student_id'])->row()->mark_obtained *$sub['coef'];} ?></td>
                        
                       <td style="border : 1px solid black;text-align : center;color: #000;"> <?php if($coeff > 0){echo get_grades($this->crud_model->get_subject_average($class_id, $section_id, $sub['id'], $exam_id, $mark['student_id'])->row()->mark_obtained) ;} ?>
                      </td>
                       <td colspan="2" style="border : 1px solid black;color: #000;"><?php $teach =$this->db->get_where('teachers', array('id' => $sub['teacher_id']))->row()->user_id; echo $this->db->get_where('users', array('id' => $teach))->row('name');?> </td>
                    </tr>
                    <?php } ?>
                    <?php } ?>
                    <tr style="border : 1px solid black; color: #000;text-align : center;">
                        <td  colspan="<?php echo ($nnexs +7); ?>"></td>
                    </tr>
                    <!-- display summary of the marksheet -->
                    <tr style="border : 1px solid black; color: #000;background-color : #ccc; text-align : center;">
                        <td colspan="<?php echo ($nnexs +7); ?>"><strong> Summary / Récapitulatif </strong></td>
                    </tr> 
                    
                    <tr style="border : 1px solid black; color: #000;background-color : #ccc; text-align : center;">
                        <td style="border : 1px solid black;text-align : center;"><strong>Exams</strong>
                        <small style="margin-top: -5px; " class="form-text"><em>Évaluations</em></small></td>
                        <?php
                        foreach($exs as $bids){ ?>
                        <td style="border : 1px solid black;text-align : center;"><strong><?php echo $bids['name']; ?></strong><small style="margin-top: -5px; " class="form-text"><em><?php echo $bids['name_fr']; ?></em></small></td>
                        <?php } ?>
                        <td colspan="2" style="border : 1px solid black;text-align : center;"><strong>Total marks</strong>
                        <small style="margin-top: -5px; " class="form-text"><em>Total notes</em></small></td>
                        <td colspan="<?php echo $nnexs; ?>" style="border : 1px solid black;text-align : center;"><strong><?php echo $this->crud_model->get_div_average($class_id, $section_id, $exam_id, $mark['student_id'])->row()->total_mark;?></strong></td>
                        <td style="border : 1px solid black;text-align : center;"><strong>Rank</strong><small style="margin-top: -5px; " class="form-text"><em>Rang</em></small></td>
                        <td style="border : 1px solid black;text-align : center;"><strong>Average</strong><small style="margin-top: -5px; " class="form-text"><em>Moyenne</em></small></td>
                    </tr>
                    
                    <tr style="border : 1px solid black; color: #000;text-align : center;">
                        <td style="border : 1px solid black;text-align : center;background-color : #ccc; "><strong>Averages</strong><small style="margin-top: -5px; " class="form-text"><em>Moyennes</em></small></td>
                        <?php
                        foreach($exs as $bids){ ?>
                        <td style="border : 1px solid black;text-align : center;"><strong><?php echo $this->crud_model->get_subdiv_average($class_id, $section_id, $bids['id'], $mark['student_id'])->row()->average ; ?></strong></td>
                        <?php } ?>
                        <td colspan="2" style="border : 1px solid black;text-align : center;background-color : #ccc;"><strong>Coefs</strong><small style="margin-top: -5px; " class="form-text"><em>Coefs</em></small></td>
                        <td colspan="<?php echo $nnexs; ?>" style="border : 1px solid black;text-align : center;background-color : #ccc;"><strong><?php echo $this->crud_model->get_div_average($class_id, $section_id, $exam_id, $mark['student_id'])->row()->total_coef; ?></strong></td>
                        <td style="border : 1px solid black;text-align : center;"><strong><?php echo $rang.' /'.$nen; ?></strong></td>
                        <td style="border : 1px solid black;text-align : center;"><strong><h4><?php echo round($this->crud_model->get_div_average($class_id, $section_id, $exam_id, $mark['student_id'])->row()->average,2); ?></h4></strong></td>
                    </tr>
                    <tr style="border : 1px solid black; color: #000;background-color : #ccc; text-align : center;">
                        <td colspan="<?php echo ($nnexs +7); ?>"><strong> General average of the class / Moyenne Générale de la classe : <?php echo $this->crud_model->get_global_gaverage($class_id, $section_id, $exam_id)->row()->average ; ?></strong></td>
                    </tr> 
                    <tr style="border : 1px solid black; color: #000;text-align : center;">
                        <td  colspan="<?php echo ($nnexs +7); ?>"></td>
                    </tr>
                    <!-- display decisions -->
                    <tr style="border : 1px solid black; color: #000;background-color : #ccc; text-align : center;">
                        <td colspan="2" style="border : 1px solid black;text-align : center;"><strong>Discipline decisions</strong><small style="margin-top: -5px; " class="form-text"><em>Décisions du conseil de discipline</em></small></td>
                        <td colspan="4" style="border : 1px solid black;text-align : center;"><strong>Class council decisions</strong><small style="margin-top: -5px; " class="form-text"><em>Décisions du conseil de classe</em></small></td>
                        <td colspan="<?php echo ($nnexs +1); ?>" style="border : 1px solid black;text-align : center;"><strong>Appreciation</strong><small style="margin-top: -5px; " class="form-text"><em>Appréciation</em></small></td>
                    </tr>
                    <tr style="border : 1px solid black; color: #000;">
                        <td colspan="2" style="border : 1px solid black;">
                            <?php 
                              $bidsd=$this->db->get_where('discipline_option', array('school_id' => school_id(), 'session' => active_session()))->result_array();
                             foreach($bidsd as $bidsd){
                               $te=0;  
                               foreach($exs as $bids){  
                               $iid = $this->db->get_where('discipline', array('school_id' => school_id(), 'session' => active_session(),'class_id' => $class_id,'section_id' => $section_id,'exam_id' => $bids['id'], 'student_id' =>$mark['student_id']))->row()->id;
                               $te+=$this->db->get_where('discipline_data', array('option_id' => $bidsd['id'], 'discipline_id' => $iid))->row('mark_obtained');
                               }?>
                              <?php echo $bidsd['name'].'/'.$bidsd['name_fr'].' : <strong>'.$te.'</strong>'; ?>
                              <small style="margin-top: -5px; " class="form-text"><em>
                                <?php
                                 echo get_discipline_decision($te, $bidsd['id'], school_id(), active_session());  ?>
                                </em></small>
                              <?php } ?>
                        </td>
                        <td colspan="4" style="border : 1px solid black; text-align : center;">
                            <?php
                             $ave =$this->crud_model->get_div_average($class_id, $section_id, $exam_id, $mark['student_id'])->row()->average; 
                                echo get_class_council($ave,school_id(), active_session()); 
                            ?><br>
                            <small style="margin-top: -5px; " class="form-text"><em>
                                <?php
                                 echo get_class_councilf($ave, school_id(), active_session()); 
                            ?>
                                </em></small>
                        </td>
                       
                        <td colspan="<?php echo ($nnexs +1); ?>" style="border : 1px solid black;text-align : center;"><strong><?php echo get_grade($ave) ; ?></strong></td>
                    </tr>
                    <tr style="border : 1px solid black; color: #000;">
                        <?php 
                         $chk = $this->db->get_where('exams', array('id' => $exam_id))->row()->is_last;
                        if ($chk > 0){
                        ?>
                        <td colspan="<?php echo ($nnexs +2); ?>" style="border : 1px solid black;text-align : center;background-color : #ccc; "><strong><?php echo get_phrase('school_decisions'); ?></strong></td>
                        <?php } else{?>
                        <td colspan="<?php echo ($nnexs +2); ?>" style="border : 1px solid black;text-align : center;background-color : #ccc; "><strong><?php echo get_phrase('subjects_where_efforts_are_needed'); ?></strong></td>
                        <?php } ?>
                        <td colspan="5" style="border : 1px solid black;text-align : center;"><strong><?php echo $this->db->get_where('schools', array('id' =>school_id()))->row()->address; ?>, .....................................</strong></td>
                    </tr>
                    
                    <tr style="border : 1px solid black; color: #000;">
                        <td colspan="<?php echo ($nnexs +2); ?>" style="border : 1px solid black;">
                            
                        <p style="inline-size: 350px;word-break: break-all;white-space: normal; " > 
                          <?php
                          $sub= $this->db->get_where('average_subject', array('school_id' => $school_id, 'session' => active_session(), 'student_id' =>$mark['student_id'], 'exam_id' => $exam_id, 'class_id' => $class_id, 'section_id' => $section_id))->result_array(); 
                          $ca = get_settings('mark_to_catch');
                          foreach($sub as $su){
                              if (($su['mark_obtained'] < $ca) && ($su['coef'] > 0)){
                                 echo $this->db->get_where('subjects', array('id' => $su['subject_id']))->row('name').'; ';
                              }
                              }
                            
                      ?>  
                        </p>
                        
                        </td>
                        <td colspan="5" style="border : 1px solid black; text-align:center;">
                            <h5><?php echo $this->db->get_where('schools', array('id' =>school_id()))->row()->title; ?></h5><br><br>
                        </td>
                    </tr>
                  
                    <?php } 
                   
    
                
              // if it is year result              
                    elseif($exam_id == 0 && $exam ==0){ ?>  
                    
                    <?php
              $exsy =$this->db->get_where('exams', array('session' => active_session()))->result_array();     
              $nnexsy=0;
              foreach($exsy as $exsy){ 
                    $a =$this->db->get_where('exam_option', array('exam_id' => $exsy['id']))->num_rows();
                    $nnexsy += $a;
              }
                   if($display > 0){
                      $school_id = school_id();
                      $subjects = $this->db->get_where('subject_settings', array('school_id' => $school_id, 'session' => active_session(), 'type' => 1))->result_array();
                      foreach($subjects as $subject){
                      $tc=0; $tg=0;  
                      $is = $this->db->get_where('subjects', array('class_id' => $class_id,'section_id' => $section_id, 'group' => $subject['id']))->num_rows();
                      $subs = $this->db->get_where('subjects', array('class_id' => $class_id,'section_id' => $section_id, 'group' => $subject['id']))->result_array();
                      if ($is > 0){?>
                    
                    <!-- subject linked to groups -->
                    <tr style="border : 1px solid black; color: #000; text-align : center;">
                        <td colspan="<?php echo ($nnexsy +7); ?>"><strong><?php echo $subject['name'].' / '.$subject['name_fr']; ?></strong></td>
                    </tr>
                    
                    <?php
                    foreach($subs as $sub){ 
                    
                    $tg+=$this->crud_model->get_subject_global_average($class_id, $section_id, $sub['id'], $mark['student_id'])->row()->mark_obtained *$sub['coef'];
                        
                    $coeff = $this->crud_model->get_subject_global_average($class_id, $section_id, $sub['id'], $mark['student_id'])->row()->coef; 
                    $tc+=$coeff; ?>
                    <tr style="border : 1px solid black;">
                       <td style="border : 1px solid black;"><?php echo $sub['name']; ?></td> 
                       <?php
                        $exsy =$this->db->get_where('exams', array('session' => active_session()))->result_array();
                        
                        foreach($exsy as $exsy){ 
                        $exs =$this->db->get_where('exam_option', array('exam_id' => $exsy['id']))->result_array();
                        foreach($exs as $bids){ ?>
                         <td style="border : 1px solid black;text-align : center;
                         <?php
                         if ($this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $bids['id'], $mark['student_id'])->row()->mark_obtained < 10){?> color: red; <?php } else{?>color: #000;<?php } ?>
                                    
                         "><?php echo $this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $bids['id'], $mark['student_id'])->row()->mark_obtained ; ?></td> 
                        <?php } ?>
                        <?php } ?>
                        
                        <td style="border : 1px solid black;text-align : center;background-color : #ccc; <?php if ($this->crud_model->get_subject_global_average($class_id, $section_id, $sub['id'], $mark['student_id'])->row()->mark_obtained < 10){ $rr=1; ?> color: red;<?php } else {$rr =0; ?> color: #000;<?php } ?>"> <?php if($coeff > 0){ echo ROUND($this->crud_model->get_subject_global_average($class_id, $section_id, $sub['id'], $mark['student_id'])->row()->mark_obtained, 2);} ?></td>
                        
                       <td style="border : 1px solid black;text-align : center;color: #000;"><?php echo $sub['coef']; ?></td> 
                        
                       <td style="border : 1px solid black;text-align : center;background-color : #ccc; <?php if ($rr > 0){?> color: red;<?php } else {?> color: #000;<?php } ?>"><?php if($coeff > 0){echo ROUND(($this->crud_model->get_subject_global_average($class_id, $section_id, $sub['id'], $mark['student_id'])->row()->mark_obtained *$sub['coef']),2);} ?></td>
                        
                       <td style="border : 1px solid black;text-align : center;">
							 <?php if($coeff > 0){echo get_grades($this->crud_model->get_subject_global_average($class_id, $section_id, $sub['id'], $mark['student_id'])->row()->mark_obtained) ;} ?></td>
                      
                       <td colspan="2" style="border : 1px solid black;color: #000;"><?php $teach =$this->db->get_where('teachers', array('id' => $sub['teacher_id']))->row()->user_id; echo $this->db->get_where('users', array('id' => $teach))->row('name');?> </td>
                    </tr>
                    <?php } ?>
                    <tr style="border : 1px solid black; color: #000;">
                        <td style="border : 1px solid black;  text-align : center;" colspan="<?php echo ($nnexsy +2); ?>"><strong>Average of the group / Moyenne du groupe</strong></td>
                        <td style="border : 1px solid black; background-color : #ccc; text-align : center;"><strong><?php echo $tc; ?></strong></td>
                        <td style="border : 1px solid black; background-color : #ccc; text-align : center;"><strong><?php echo $tg; ?></strong></td>
                        <td style="border : 1px solid black;  background-color : #ccc; text-align : center;"><strong><?php if($tg > 0){ echo (Round(($tg/$tc),2));} ?></strong></td>
                        <td colspan="2" style="border : 1px solid black; text-align : center;"><strong><?php $t='class_council'; echo get_class_council($tg, $t, $school_id,active_session()); ?></strong></td>
                    </tr>
                    <?php } ?>
                    <?php } ?>
                    <!-- subject not linked to groups when displaying groups -->
                    <?php 
                    $subsn = $this->db->get_where('subjects', array('class_id' => $class_id,'section_id' => $section_id, 'group' => 0))->num_rows(); 
                    if($subsn > 0){?>
                    <tr style="border : 1px solid black; color: #000; text-align : center;">
                        <td colspan="<?php echo ($nnexsy +7); ?>"><strong><?php echo get_phrase('others'); ?></strong></td>
                    </tr>
                    <?php
                    $tc=0; $tg=0;  
                    $subs = $this->db->get_where('subjects', array('class_id' => $class_id,'section_id' => $section_id, 'group' => 0))->result_array();
                    foreach($subs as $sub){
                    $tc+=$this->crud_model->get_subject_global_average($class_id, $section_id, $sub['id'], $mark['student_id'])->row()->coef;
                        
                    $tg+=$this->crud_model->get_subject_global_average($class_id, $section_id, $sub['id'], $mark['student_id'])->row()->mark_obtained * $this->crud_model->get_subject_global_average($class_id, $section_id, $sub['id'], $mark['student_id'])->row()->coef;
                        
                    $coeff = $this->crud_model->get_subject_global_average($class_id, $section_id, $sub['id'], $mark['student_id'])->row()->coef;?>
                    <tr style="border : 1px solid black;">
                       <td style="border : 1px solid black;"><?php echo $sub['name']; ?></td> 
                       <?php
                        $exsy =$this->db->get_where('exams', array('session' => active_session()))->result_array();
                        foreach($exsy as $exsy){ 
                        $exs =$this->db->get_where('exam_option', array('exam_id' => $exsy['id']))->result_array();
                        foreach($exs as $bids){ ?>
                         <td style="border : 1px solid black;text-align : center;
                        <?php
                         if ($this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $bids['id'], $mark['student_id'])->row()->mark_obtained < 10){?> color: red; <?php } else{?>color: #000;<?php } ?>            
                        "><?php echo $this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $bids['id'], $mark['student_id'])->row()->mark_obtained; ?></td> 
                        <?php } ?>
                        <?php } ?>
                        
                        <td style="border : 1px solid black;text-align : center; background-color : #ccc; <?php if ($this->crud_model->get_subject_global_average($class_id, $section_id, $sub['id'], $mark['student_id'])->row()->mark_obtained < 10){$rr=1;?> color: red;<?php } else {$rr=0;?> color: #000;<?php } ?>"> <?php if($coeff > 0){echo ROUND($this->crud_model->get_subject_global_average($class_id, $section_id, $sub['id'], $mark['student_id'])->row()->mark_obtained,2);} ?></td>
                        
                       <td style="border : 1px solid black;text-align : center; color: #000;"><?php echo $sub['coef']; ?></td> 
                        
                       <td style="border : 1px solid black;text-align : center;background-color : #ccc;  <?php if ($rr > 0){?> color: red;<?php } else {?> color: #000;<?php } ?>"><?php if($coeff > 0){ echo ROUND(($this->crud_model->get_subject_global_average($class_id, $section_id, $sub['id'], $mark['student_id'])->row()->mark_obtained *$sub['coef']),2);} ?></td>
                        
                       <td style="border : 1px solid black;text-align : center; color: #000;"> <?php if($coeff > 0){echo get_grades($this->crud_model->get_subject_global_average($class_id, $section_id, $sub['id'], $mark['student_id'])->row()->mark_obtained) ;} ?></td>
                      
                       <td colspan="2" style="border : 1px solid black; color: #000;"><?php $teach =$this->db->get_where('teachers', array('id' => $sub['teacher_id']))->row()->user_id; echo $this->db->get_where('users', array('id' => $teach))->row('name');?> </td>
                    </tr>
                    <?php } ?>
                    <tr style="border : 1px solid black; color: #000;">
                        <td style="border : 1px solid black;  text-align : center;" colspan="<?php echo ($nnexsy +2); ?>"><strong>Average of the group / Moyenne du groupe</strong></td>
                        <td style="border : 1px solid black; background-color : #ccc; text-align : center;"><strong><?php echo $tc; ?></strong></td>
                        <td style="border : 1px solid black; background-color : #ccc; text-align : center;"><strong><?php echo $tg; ?></strong></td>
                        <td style="border : 1px solid black;  background-color : #ccc; text-align : center;"><strong><?php if($tg > 0){ echo (Round(($tg/$tc),2));} ?></strong></td>
                        <td colspan="2" style="border : 1px solid black; text-align : center;"><strong><?php $t='class_council'; echo get_class_council($tg, $t, $school_id,active_session()); ?></strong></td>
                    </tr>
                    
                    <?php } ?> 
                    
<!--                    don't display subjects groups-->
                    <?php } 
                   else{ 
                    
                    foreach($subs as $sub){ 
                    $coeff = $this->crud_model->get_subject_global_average($class_id, $section_id, $sub['id'], $mark['student_id'])->row()->coef;?>
                    
                    <tr style="border : 1px solid black;">
                       <td style="border : 1px solid black;"><?php echo $sub['name']; ?></td> 
                        
                        <?php
                        $exsy =$this->db->get_where('exams', array('session' => active_session()))->result_array();
                        foreach($exsy as $exsy){ 
                       $exs =$this->db->get_where('exam_option', array('exam_id' => $exsy['id']))->result_array();
                        foreach($exs as $bids){ ?>
                         <td style="border : 1px solid black;text-align : center;
                         <?php
                         if ($this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $bids['id'], $mark['student_id'])->row()->mark_obtained < 10){?> color: red; <?php } else{?>color: #000;<?php } ?>
                                    
                         "><?php echo $this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $bids['id'], $mark['student_id'])->row()->mark_obtained ; ?></td>  
                        <?php }  ?>
                        <?php }  ?>
                        
                       <td style="border : 1px solid black;text-align : center;background-color : #ccc; <?php if ($this->crud_model->get_subject_global_average($class_id, $section_id, $sub['id'], $mark['student_id'])->row()->mark_obtained < 10){ $rr=1; ?> color: red;<?php } else {$rr=0; ?> color: #000;<?php } ?>"><?php if($coeff > 0){echo ROUND($this->crud_model->get_subject_global_average($class_id, $section_id, $sub['id'], $mark['student_id'])->row()->mark_obtained,2);} ?></td>
                        
                        <td style="border : 1px solid black;text-align : center;color: #000;"><?php echo $sub['coef']; ?></td> 
                        
                        <td style="border : 1px solid black;text-align : center;background-color : #ccc; <?php if ($rr > 0){?> color: red;<?php } else {?> color: #000;<?php } ?>"><?php if($coeff > 0){echo ROUND(($this->crud_model->get_subject_global_average($class_id, $section_id, $sub['id'], $mark['student_id'])->row()->mark_obtained * $sub['coef']),2);} ?></td>
                        
                       <td style="border : 1px solid black;text-align : center;color: #000;"> <?php if($coeff > 0){echo get_grades($this->crud_model->get_subject_global_average($class_id, $section_id, $sub['id'], $mark['student_id'])->row()->mark_obtained) ;} ?>
                      </td>
                       <td colspan="2" style="border : 1px solid black;color: #000;"><?php $teach =$this->db->get_where('teachers', array('id' => $sub['teacher_id']))->row()->user_id; echo $this->db->get_where('users', array('id' => $teach))->row('name');?> </td>
                    </tr>
                    <?php } ?>
                    <?php } ?>
                    <tr style="border : 1px solid black; color: #000;text-align : center;">
                        <td  colspan="<?php echo ($nnexsy +7); ?>"></td>
                    </tr>
                    <!-- display summary of the marksheet -->
                    <tr style="border : 1px solid black; color: #000;background-color : #ccc; text-align : center;">
                        <td colspan="<?php echo ($nnexsy +7); ?>"><strong> Summary / Récapitulatif </strong></td>
                    </tr> 
                    
                    <tr style="border : 1px solid black; color: #000;background-color : #ccc; text-align : center;">
                        <td style="border : 1px solid black;text-align : center;"><strong>Exams</strong>
                        <small style="margin-top: -5px; " class="form-text"><em>Évaluations</em></small></td>
                        <?php
                        $exsy =$this->db->get_where('exams', array('session' => active_session()))->result_array();
                        foreach($exsy as $exsy){ 
                       $exs =$this->db->get_where('exam_option', array('exam_id' => $exsy['id']))->result_array();
                        foreach($exs as $bids){ ?>
                        <td style="border : 1px solid black;text-align : center;"><strong><?php echo $bids['short_name']; ?></strong><small style="margin-top: -5px; " class="form-text"><em><?php echo $bids['short_name_fr']; ?></em></small></td>
                        <?php } ?>
                        <?php } ?>
                        
                        <td colspan="2" style="border : 1px solid black;text-align : center;"><strong>Total marks</strong>
                        <small style="margin-top: -5px; " class="form-text"><em>Total notes</em></small></td>
                        <td colspan="2" style="border : 1px solid black;text-align : center;"><strong><?php echo $this->crud_model->get_global_average($class_id, $section_id, $mark['student_id'])->row()->total_mark;?></strong></td>
                        <td style="border : 1px solid black;text-align : center;"><strong>Rank</strong><small style="margin-top: -5px; " class="form-text"><em>Rang</em></small></td>
                        <td style="border : 1px solid black;text-align : center;"><strong>Average</strong><small style="margin-top: -5px; " class="form-text"><em>Moyenne</em></small></td>
                    </tr>
                    
                    <tr style="border : 1px solid black; color: #000;text-align : center;">
                        <td style="border : 1px solid black;text-align : center;background-color : #ccc; "><strong>Averages</strong><small style="margin-top: -5px; " class="form-text"><em>Moyennes</em></small></td>
                        <?php
                        $exsy =$this->db->get_where('exams', array('session' => active_session()))->result_array();
                        foreach($exsy as $exsy){
                        $exs =$this->db->get_where('exam_option', array('exam_id' => $exsy['id']))->result_array();    
                        foreach($exs as $bids){ ?>
                        <td style="border : 1px solid black;text-align : center;"><strong>
                            <?php echo ROUND($this->crud_model->get_subdiv_average($class_id, $section_id, $bids['id'], $mark['student_id'])->row()->average,2) ; ?></strong></td>
                        <?php } ?>
                        <?php } ?>
                        <td colspan="2" style="border : 1px solid black;text-align : center;background-color : #ccc;"><strong>Coefs</strong><small style="margin-top: -5px; " class="form-text"><em>Coefs</em></small></td>
                        <td colspan="2" style="border : 1px solid black;text-align : center;background-color : #ccc;"><strong><?php echo $this->crud_model->get_global_average($class_id, $section_id, $mark['student_id'])->row()->total_coef; ?></strong></td>
                        <td style="border : 1px solid black;text-align : center;"><strong><h4><?php echo $rang.' /'.$nen; ?></h4></strong></td>
                        <td style="border : 1px solid black;text-align : center;"><strong><h4><?php echo round($this->crud_model->get_global_average($class_id, $section_id, $mark['student_id'])->row()->average,2); ?></h4></strong></td>
                    </tr> 
                    
                    <tr style="border : 1px solid black; color: #000;text-align : center;text-align : center;">
                        <td style="border : 1px solid black;text-align : center;background-color : #ccc; "><strong>General av. of the class</strong><small style="margin-top: -5px; " class="form-text"><em>Moyenne G. de la classe</em></small></td>
                        <?php
                        $exsy =$this->db->get_where('exams', array('session' => active_session()))->result_array();
                        foreach($exsy as $exsy){
                        $exs =$this->db->get_where('exam_option', array('exam_id' => $exsy['id']))->result_array(); 
                        foreach($exs as $bids){ ?>
                        <td style="border : 1px solid black;text-align : center;"><strong><?php echo ROUND($this->crud_model->get_subdiv_gaverage($class_id, $section_id, $bids['id'])->row()->average,2); ?></strong></td>
                        <?php } ?>
                        <?php } ?>
                        <td colspan="<?php echo $nnexsy +4; ?>" style="text-align : center;">
                        <strong> Session General average of the class  : </strong> <?php echo $this->crud_model->get_global_gaverage($class_id, $section_id)->row()->average ; ?>
                        <small style="margin-top: -5px; " class="form-text"><em>Moyenne G. de la classe annuelle </em></small> 
                        </td>
                    </tr>
<!--
                
-->
                    <tr style="border : 1px solid black; color: #000;text-align : center;">
                        <td  colspan="<?php echo ($nnexsy +7); ?>"></td>
                    </tr>
                    <!-- display decisions -->
                    <tr style="border : 1px solid black; color: #000;background-color : #ccc; text-align : center;">
                        <td colspan="2" style="border : 1px solid black;text-align : center;"><strong>Discipline decisions</strong><small style="margin-top: -5px; " class="form-text"><em>Décisions du conseil de discipline</em></small></td>
                        <td colspan="5" style="border : 1px solid black;text-align : center;"><strong>Class council decisions</strong><small style="margin-top: -5px; " class="form-text"><em>Décisions du conseil de classe</em></small></td>
                        <td colspan="<?php echo $nnexsy; ?>" style="border : 1px solid black;text-align : center;"><strong>Appreciation</strong><small style="margin-top: -5px; " class="form-text"><em>Appréciation</em></small></td>
                    </tr>
                    <tr style="border : 1px solid black; color: #000;">
                        <td colspan="2" style="border : 1px solid black;">
<!--
                            <?php 
                              $bidsd=$this->db->get_where('discipline_option', array('school_id' => school_id(), 'session' => active_session()))->result_array();
                             foreach($bidsd as $bidsd){
                               $te=0;  
                               foreach($exs as $bids){  
                               $iid = $this->db->get_where('discipline', array('school_id' => school_id(), 'session' => active_session(),'class_id' => $class_id,'section_id' => $section_id,'exam_id' => $bids['id'], 'student_id' =>$mark['student_id']))->row()->id;
                               $te+=$this->db->get_where('discipline_data', array('option_id' => $bidsd['id'], 'discipline_id' => $iid))->row('mark_obtained');
                               }?>
                              <?php echo $bidsd['name'].'/'.$bidsd['name_fr'].' : <strong>'.$te.'</strong>'; ?>
                              <small style="margin-top: -5px; " class="form-text"><em>
                                <?php
                                 echo get_discipline_decision($te, $bidsd['id'], school_id(), active_session());  ?>
                                </em></small>
                              <?php } ?>
-->
                        </td>
                        <td colspan="5" style="border : 1px solid black; text-align : center;">
                            <?php
                             $ave =$this->crud_model->get_global_average($class_id, $section_id, $mark['student_id'])->row()->average; 
                                echo get_class_council($ave,school_id(), active_session()); 
                            ?><br>
                            <small style="margin-top: -5px; " class="form-text"><em>
                                <?php
                                 echo get_class_councilf($ave, school_id(), active_session()); 
                            ?>
                                </em></small>
                        </td>
                       
                        <td colspan="<?php echo $nnexsy; ?>" style="border : 1px solid black;text-align : center;"><strong><?php echo get_grade($ave) ; ?></strong></td>
                    </tr>
                    <tr style="border : 1px solid black; color: #000;">

                        <td colspan="<?php echo ($nnexsy +2); ?>" style="border : 1px solid black;text-align : center;background-color : #ccc; "><strong><?php echo get_phrase('school_decisions'); ?></strong></td>
                        
                        <td colspan="5" style="border : 1px solid black;text-align : center;"><strong><?php echo $this->db->get_where('schools', array('id' =>school_id()))->row()->address; ?>, .....................................</strong></td>

                    </tr>
                    
                    <tr style="border : 1px solid black; color: #000;">
                        <td colspan="<?php echo ($nnexsy +2); ?>" style="border : 1px solid black;text-align : center;">
                        <h5>    
                        <p style="word-break: break-all;white-space: normal; " > 
                          

                            
                        </p>
                         </h5>   
                        
                        </td>
                        <td colspan="5" style="border : 1px solid black; text-align:center;">
                            <h4><?php echo $this->db->get_where('schools', array('id' =>school_id()))->row()->title; ?></h4><br><br>
                        </td>
                    </tr>
                  
                    <?php } ?>
                </tbody>
                </table>
          </div>
          <!-- end row -->
        </div> <!-- end card-body-->
      </div> <!-- end card -->
          <?php } ?>  
          <!-- end row-->
      </div>
       <div class="d-print-none mt-6">
            <div class="text-right">
              <a style="color:#fff; cursor:pointer;" onClick="PrintElem('#top')" class="btn btn-primary"><i class="mdi mdi-printer"></i> <?php echo get_phrase('print'); ?></a>
            </div>
          </div>
           <!--<div class="d-print-none mt-4">
            <div class="text-right">
            <div class="row justify-content-md-center" style="margin-bottom: 10px;">
              <div class="col-md-12 col-sm-12 mb-3 mb-lg-0">
                <button type="button" class="btn btn-icon btn-primary form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-printer"></i><?php echo get_phrase('export'); ?></button>
                <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 37px, 0px);">
                  <a class="dropdown-item" id="export-pdf" href="javascript:0" onclick="getExportUrl('pdf')">PDF</a>
                  <a class="dropdown-item" id="export-print" href="javascript:0" onclick="getExportUrl('print')"><?php echo get_phrase('print'); ?></a>
                </div>
              </div>
                
            </div>
              
          </div>
 
       
              
      
    </div> <!-- end col-->
  </div>
</div>
<script type="text/javascript">

    // print invoice function
    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data)
    {
        var mywindow = window.open('', 'report', 'height=900,width=1200');
        mywindow.document.write('<html><head><title>Bulletins / reports cards</title>');
        mywindow.document.write(data);
        mywindow.document.write('</body><style>table {border-collapse: collapse;} </style></html>');

        var is_chrome = Boolean(mywindow.chrome);
        if (is_chrome) {
            setTimeout(function() {
                mywindow.print();
                mywindow.close();

                return true;
            }, 250);
        }
        else {
            mywindow.print();
            mywindow.close();

            return true;
        }

        return true;
    }

</script>

<script type="text/javascript">
    
function getExportUrl(type) {
  var url = '<?php echo route('export_report_card/url'); ?>';
    var class_id = '<?php echo $class_id; ?>';
    var section_id = '<?php echo $section_id; ?>';
    var exam = '<?php echo $exam; ?>';
    var exam_id = '<?php echo $exam_id; ?>';
    var display = '<?php echo $display; ?>';
      $.ajax({
        type : 'post',
        url: url,
        data : {type : type, class_id : class_id, section_id : section_id, display : display, exam_id : exam_id, exam : exam,},
        success : function(response) {
          if (type == 'csv') {
            window.open(response, '_self');
          }else{
            window.open(response, '_blank');
          }
        }
      });
}

</script>