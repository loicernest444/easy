<?php

$school_id = school_id();
$nen = $this->crud_model->get_stu_average($class_id, $section_id)->num_rows();
if($exam > 0){
  $term = $this->db->get_where('exam_option', array('id' => $exam))->row()->name;
  $enrols = $this->crud_model->get_subdiv_global_average($class_id, $section_id, $exam)->result_array();
  $numm = $this->crud_model->get_subdiv_global_average($class_id, $section_id, $exam)->num_rows();
}elseif($exam_id > 0){
  $term = $this->db->get_where('exams', array('id' => $exam_id))->row()->name;
    $enrols = $this->crud_model->get_div_global_average($class_id, $section_id, $exam_id)->result_array();
    $numm = $this->crud_model->get_subdiv_global_average($class_id, $section_id, $exam_id)->num_rows();
}

if($numm < 1){
  $enrols = $this->db->get_where('enrols', array('class_id' => $class_id, 'section_id' => $section_id, 'school_id' => school_id(), 'session' => active_session()))->result_array();
}
?>


<div class="row" style="font-size:10px;"> 
  <div class="col-12">
         
    <div id="top">  
          <?php 
          $rank=1; 
          foreach($enrols as $mark){?>
        <!-- Invoice Logo-->
       
    <div class="card" style="page-break-after : always;"> 
      <div class="card-body">
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
              if ($bt =='around'){
               $bd = $this->user_model->get_user_details($student['user_id'], 'birthday'); 
              }else{
               $bd = date('d/m/y', $this->user_model->get_user_details($student['user_id'], 'birthday')); 
               } 
              
              if($exam > 0){
                  $tid = $this->db->get_where('exam_option', array('id' => $exam))->row()->exam_id;
                  $term = $this->db->get_where('exams', array('id' => $tid))->row()->name;
                  $termf = $this->db->get_where('exams', array('id' => $tid))->row()->name_fr;
              }
              if($exam_id > 0){
                  $term = $this->db->get_where('exams', array('id' => $exam_id))->row()->name;
                  $termf = $this->db->get_where('exams', array('id' => $exam_id))->row()->name_fr;
              }
              $subs =$this->db->get_where('subjects', array('class_id' => $class_id,'section_id' => $section_id,'school_id' => school_id(),'session' => active_session()))->result_array();
              $exs =$this->db->get_where('exam_option', array('exam_id' => $exam_id))->result_array();
          
                  $exs =$this->db->get_where('exam_option', array('exam_id' => $exam_id))->result_array();
                  $nnexs =$this->db->get_where('exam_option', array('exam_id' => $exam_id))->num_rows();
                  $tcol = ($nnexs * 3) +3;
          ?>
          
             <?php include 'header2.php'; ?>
            <table style="width : 85%;">
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
                      <td>Term : <strong><?php echo $term; ?></strong>
                      <br><em>Trimestre : <?php echo $termf; ?></em> </td>
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
            
        <div class="row">
              <table style="width : 100%; border-collapse: collapse;">
                <?php if($exam > 0){?>
                  <tr style="border : 1px solid black; color: #000; background-color : #ccc; text-align : center;">
                    <th style="border : 1px solid black;">School subjects
                      <br><em>Matières</em> </th>
                    <th style="border : 1px solid black;">Notes
                      <br><em>Notes</em> </th>
                    <th style="border : 1px solid black;">Coef
                      <br><em>Coef</em> </th>
                    <th style="border : 1px solid black;">Mark*Coef
                      <br><em>Notes*Coef</em> </th>
                    <th style="border : 1px solid black;">Remarks
                      <br><em>Remarques</em> </th>
                    <th colspan="2" style="border : 1px solid black;">Teacher names and signatures
                      <br><em>Noms des enseignants et signatures</em> </th>
                  </tr>
                <?php } else{?>  
                <thead>
                  <tr style="border : 1px solid black; color: #000; background-color : #ccc; text-align : center;">
                    <th style="border : 1px solid black;">School subjects
                      <br><em>Matières</em> </th>
                    <?php
                     foreach($exs as $bids){ ?>
                       <th style="border : 1px solid black;"><?php echo $bids['name']; ?>
                      <br><em><?php echo $bids['name_fr']; ?></em> </th>
                    <?php } ?>
                    <th style="border : 1px solid black;">Mark
                      <br><em>Note</em> </th>
                    <th style="border : 1px solid black;">Coef
                      <br><em>Coef</em> </th>
                    <th style="border : 1px solid black;">Mark*Coef
                      <br><em>Notes*Coef</em> </th>
                    <th style="border : 1px solid black;">Remarks
                      <br><em>Remarques</em> </th>
                    <th colspan="2" style="border : 1px solid black;">Teacher names and signatures
                      <br><em>Noms des enseignants et signatures</em> </th>
                  </tr>
                </thead>
                  <?php } ?>
                <tbody>
                   <?php if($exam > 0){?> 
                    <?php
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
                    <tr style="border : 1px solid black; color: #000;">
                       <td style="border : 1px solid black;"><?php echo ' '.$sub['name']; ?></td> 
                       <td style="border : 1px solid black;text-align : center;"><?php echo $this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $exam, $mark['student_id'])->row()->mark_obtained ; ?></td> 
                        
                       <td style="border : 1px solid black;text-align : center;"><?php echo $sub['coef']; ?></td> 
                        
                       <td style="border : 1px solid black;text-align : center;"><?php if($coeff > 0){ echo $this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $exam, $mark['student_id'])->row()->mark_obtained *$this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $exam, $mark['student_id'])->row()->coef ;} ?></td>
                        
                       <td style="border : 1px solid black;text-align : center;"></td>
                       <td colspan="2" style="border : 1px solid black;"><?php $teach =$this->db->get_where('teachers', array('id' => $sub['teacher_id']))->row()->user_id; echo $this->db->get_where('users', array('id' => $teach))->row('name');?> </td>
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
                    <tr style="border : 1px solid black; color: #000;">
                       <td style="border : 1px solid black;"><?php echo ' '.$sub['name']; ?></td> 
                       <td style="border : 1px solid black;text-align : center;"><?php echo $this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $exam, $mark['student_id'])->row()->mark_obtained; ?></td> 
                        
                       <td style="border : 1px solid black;text-align : center;"><?php echo $sub['coef']; ?></td> 
                        
                       <td style="border : 1px solid black;text-align : center;"><?php if($coeff > 0){ echo $this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $exam, $mark['student_id'])->row()->mark_obtained *$this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $exam, $mark['student_id'])->row()->coef;} ?></td>
                        
                       <td style="border : 1px solid black;text-align : center;"></td>
                       <td colspan="2" style="border : 1px solid black;"><?php $teach =$this->db->get_where('teachers', array('id' => $sub['teacher_id']))->row()->user_id; echo $this->db->get_where('users', array('id' => $teach))->row('name');?> </td>
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
                    <tr style="border : 1px solid black; color: #000;">
                       <td style="border : 1px solid black;"><?php echo ' '.$sub['name']; ?></td> 
                       <td style="border : 1px solid black;text-align : center;"><?php echo $this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $exam, $mark['student_id'])->row()->mark_obtained ; ?></td> 
                        
                       <td style="border : 1px solid black;text-align : center;"><?php echo $sub['coef']; ?></td> 
                        
                       <td style="border : 1px solid black;text-align : center;"><?php if($coeff > 0){echo $this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $exam, $mark['student_id'])->row()->mark_obtained *$this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $exam, $mark['student_id'])->row()->coef;} ?></td>
                        
                       <td style="border : 1px solid black;text-align : center;"></td>
                       <td colspan="2" style="border : 1px solid black;"><?php $teach =$this->db->get_where('teachers', array('id' => $sub['teacher_id']))->row()->user_id; echo $this->db->get_where('users', array('id' => $teach))->row('name');?> </td>
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
                        <br><em>Moyenne générale de la classe</em> </td>
                        <td style="border : 1px solid black;text-align : center;"><strong>Total marks</strong>
                        <br><em>Total notes</em> </td>
                        <td colspan="2" style="border : 1px solid black;text-align : center;"><strong>Total coef</strong>
                        <br><em>Total coef</em> </td>
                        <td style="border : 1px solid black;text-align : center;"><strong>Rank</strong>
                        <br><em>Rang</em> </td>
                        <td colspan="2" style="border : 1px solid black;text-align : center;"><strong>Average</strong><br><em>Moyenne</em> </td>
                    </tr>
                    <tr style="border : 1px solid black; color: #000;background-color : #ccc; text-align : center;">
                        <td style="border : 1px solid black;text-align : center;"><strong> <?php echo $this->crud_model->get_subdiv_gaverage($class_id, $section_id, $exam)->row()->average ; ?></strong></td>
                        <td style="border : 1px solid black;text-align : center;"><strong><?php echo $this->crud_model->get_subdiv_average($class_id, $section_id, $exam, $mark['student_id'])->row()->total_mark ; ?></strong></td>
                        <td colspan="2" style="border : 1px solid black;text-align : center;"><strong><?php echo $this->crud_model->get_subdiv_average($class_id, $section_id, $exam, $mark['student_id'])->row()->total_coef ; ?></strong></td>
                        <td style="border : 1px solid black;text-align : center;"><strong><?php echo $rank++.'e /'.$nen; ?></strong></td>
                        <td colspan="2" style="border : 1px solid black;text-align : center;"><strong><?php echo $this->crud_model->get_subdiv_average($class_id, $section_id, $exam, $mark['student_id'])->row()->average; ?></strong></td>
                    </tr>
                    <tr style="border : 1px solid black; color: #000;text-align : center;">
                        <td  colspan="7"></td>
                    </tr>
                    <!-- display decisions -->
                    <tr style="border : 1px solid black; color: #000;background-color : #ccc; text-align : center;">
                        <td colspan="2" style="border : 1px solid black;text-align : center;"><strong>Discipline decisions</strong>
                        <br><em>Décisions du conseil de discipline</em> </td>
                        <td colspan="3" style="border : 1px solid black;text-align : center;"><strong>Class council decisions</strong><br><em>Décisions du conseil de classe</em> </td>
                        <td colspan="2" style="border : 1px solid black;text-align : center;"><strong>Appreciation</strong><br><em>Appréciations</em> </td>
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
                                </em> 
                              <?php } ?>
                        </td>
                        <td colspan="3" style="border : 1px solid black; text-align : center;">
                            <?php
                             $ave =$this->crud_model->get_div_average($class_id, $section_id, $exam, $mark['student_id'])->row()->average; 
                                echo get_class_council($ave,school_id(), active_session()); 
                            ?><br>
                            <br> - <em>
                                <?php
                                 echo get_class_councilf($ave, school_id(), active_session()); 
                            ?>
                                </em> 
                        </td>
                       
                        <td colspan="2" style="border : 1px solid black;text-align : center;"><strong>
                            <?php echo get_grade($ave) ; ?></strong>
                        </td>
                    </tr>
                    <tr style="border : 1px solid black; color: #000;">
                        <td colspan="2" style="border : 1px solid black;text-align : center;background-color : #ccc; "><strong>Subjects where efforts are needed </strong><br><em>Un éffort s'impose en</em> </td>
                        <td colspan="5" style="border : 1px solid black;text-align : center;"><strong><?php echo $this->db->get_where('schools', array('id' =>school_id()))->row()->address; ?>, .....................................</strong></td>
                    </tr>
                    
                    <tr style="border : 1px solid black; color: #000;">
                        <td colspan="2" style="border : 1px solid black;">
                        <?php
                          $sub= $this->db->get_where('marks', array('school_id' => $school_id, 'session' => active_session(), 'student_id' =>$mark['student_id'], 'exam_id' => $exam, 'class_id' => $class_id, 'section_id' => $section_id))->result_array(); 
                          $ca = get_settings('mark_to_catch');
                          foreach($sub as $su){
                              if (($su['mark_obtained'] < $ca) && ($su['coef'] > 0)){
                                 echo $this->db->get_where('subjects', array('id' => $su['subject_id']))->row('name').'; ';
                              }
                              }
                            
                      ?>
                        </td>
                        <td colspan="5" style="border : 1px solid black;">
                            <h5><?php echo $this->db->get_where('schools', array('id' =>school_id()))->row()->title; ?></h5><br><br>
                        </td>
                    </tr>
                  <?php } 
              
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
                    <tr style="border : 1px solid black; color: #000;">
                       <td style="border : 1px solid black;"><?php echo $sub['name']; ?></td> 
                       <?php
                        foreach($exs as $bids){ ?>
                         <td style="border : 1px solid black;text-align : center;"><?php echo $this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $bids['id'], $mark['student_id'])->row()->mark_obtained ; ?></td> 
                        <?php } ?>
                        
                        <td style="border : 1px solid black;text-align : center;"><?php echo $this->crud_model->get_subject_average($class_id, $section_id, $sub['id'], $exam_id, $mark['student_id'])->row()->mark_obtained; ?></td>
                        
                       <td style="border : 1px solid black;text-align : center;"><?php echo $sub['coef']; ?></td> 
                        
                       <td style="border : 1px solid black;text-align : center;"><?php if($coeff > 0){echo $this->crud_model->get_subject_average($class_id, $section_id, $sub['id'], $exam_id, $mark['student_id'])->row()->mark_obtained *$sub['coef'];} ?></td>
                        
                       <td style="border : 1px solid black;text-align : center;"></td>
                       <td colspan="2" style="border : 1px solid black;"><?php $teach =$this->db->get_where('teachers', array('id' => $sub['teacher_id']))->row()->user_id; echo $this->db->get_where('users', array('id' => $teach))->row('name');?> </td>
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
                    <tr style="border : 1px solid black; color: #000;">
                       <td style="border : 1px solid black;"><?php echo $sub['name']; ?></td> 
                       <?php
                        foreach($exs as $bids){ ?>
                         <td style="border : 1px solid black;text-align : center;"><?php echo $this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $bids['id'], $mark['student_id'])->row()->mark_obtained; ?></td> 
                        <?php } ?>
                        
                        <td style="border : 1px solid black;text-align : center;"><?php echo $this->crud_model->get_subject_average($class_id, $section_id, $sub['id'], $exam_id, $mark['student_id'])->row()->mark_obtained; ?></td>
                        
                       <td style="border : 1px solid black;text-align : center;"><?php echo $sub['coef']; ?></td> 
                        
                       <td style="border : 1px solid black;text-align : center;"><?php if($coeff > 0){echo $this->crud_model->get_subject_average($class_id, $section_id, $sub['id'], $exam_id, $mark['student_id'])->row()->mark_obtained *$sub['coef'];} ?></td>
                        
                       <td style="border : 1px solid black;text-align : center;"></td>
                       <td colspan="2" style="border : 1px solid black;"><?php $teach =$this->db->get_where('teachers', array('id' => $sub['teacher_id']))->row()->user_id; echo $this->db->get_where('users', array('id' => $teach))->row('name');?> </td>
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
                    <tr style="border : 1px solid black; color: #000;">
                       <td style="border : 1px solid black;"><?php echo $sub['name']; ?></td> 
                        <?php
                        foreach($exs as $bids){ ?>
                         <td style="border : 1px solid black;text-align : center;"><?php echo $this->crud_model->get_stmarks_average($class_id, $section_id, $sub['id'], $bids['id'], $mark['student_id'])->row()->mark_obtained; ?></td> 
                        <?php } ?>
                        
                       <td style="border : 1px solid black;text-align : center;"><?php echo $this->crud_model->get_subject_average($class_id, $section_id, $sub['id'], $exam_id, $mark['student_id'])->row()->mark_obtained; ?></td>
                        
                        <td style="border : 1px solid black;text-align : center;"><?php echo $sub['coef']; ?></td> 
                        
                        <td style="border : 1px solid black;text-align : center;"><?php if($coeff > 0){echo $this->crud_model->get_subject_average($class_id, $section_id, $sub['id'], $exam_id, $mark['student_id'])->row()->mark_obtained *$sub['coef'];} ?></td>
                        
                       <td style="border : 1px solid black;text-align : center;"></td>
                       <td colspan="2" style="border : 1px solid black;"><?php $teach =$this->db->get_where('teachers', array('id' => $sub['teacher_id']))->row()->user_id; echo $this->db->get_where('users', array('id' => $teach))->row('name');?> </td>
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
                        <br><em>Évaluations</em> </td>
                        <?php
                        foreach($exs as $bids){ ?>
                        <td style="border : 1px solid black;text-align : center;"><strong><?php echo $bids['name']; ?></strong><br><em><?php echo $bids['name_fr']; ?></em> </td>
                        <?php } ?>
                        <td colspan="2" style="border : 1px solid black;text-align : center;"><strong>Total marks</strong>
                        <br><em>Total notes</em> </td>
                        <td colspan="<?php echo $nnexs; ?>" style="border : 1px solid black;text-align : center;"><strong><?php echo $this->crud_model->get_div_average($class_id, $section_id, $exam_id, $mark['student_id'])->row()->total_mark;?></strong></td>
                        <td style="border : 1px solid black;text-align : center;"><strong>Rank</strong><br><em>Rang</em> </td>
                        <td style="border : 1px solid black;text-align : center;"><strong>Average</strong><br><em>Moyenne</em> </td>
                    </tr>
                    
                    <tr style="border : 1px solid black; color: #000;text-align : center;">
                        <td style="border : 1px solid black;text-align : center;background-color : #ccc; "><strong>Averages</strong><br><em>Moyennes</em> </td>
                        <?php
                        foreach($exs as $bids){ ?>
                        <td style="border : 1px solid black;text-align : center;"><strong><?php echo $this->crud_model->get_subdiv_average($class_id, $section_id, $bids['id'], $mark['student_id'])->row()->average ; ?></strong></td>
                        <?php } ?>
                        <td colspan="2" style="border : 1px solid black;text-align : center;background-color : #ccc;"><strong>Coefs</strong><br><em>Coefs</em> </td>
                        <td colspan="<?php echo $nnexs; ?>" style="border : 1px solid black;text-align : center;background-color : #ccc;"><strong><?php echo $this->crud_model->get_div_average($class_id, $section_id, $exam_id, $mark['student_id'])->row()->total_coef; ?></strong></td>
                        <td style="border : 1px solid black;text-align : center;"><strong><?php echo $rank++.'e /'.$nen; ?></strong></td>
                        <td style="border : 1px solid black;text-align : center;"><strong><?php echo $this->crud_model->get_div_average($class_id, $section_id, $exam_id, $mark['student_id'])->row()->average; ?></strong></td>
                    </tr>
                    <tr style="border : 1px solid black; color: #000;background-color : #ccc; text-align : center;">
                        <td colspan="<?php echo ($nnexs +7); ?>"><strong> General average of the class / Moyenne Générale de la classe : <?php echo $this->crud_model->get_div_gaverage($class_id, $section_id, $exam_id)->row()->average ; ?></strong></td>
                    </tr> 
                    <tr style="border : 1px solid black; color: #000;text-align : center;">
                        <td  colspan="<?php echo ($nnexs +7); ?>"></td>
                    </tr>
                    <!-- display decisions -->
                    <tr style="border : 1px solid black; color: #000;background-color : #ccc; text-align : center;">
                        <td colspan="2" style="border : 1px solid black;text-align : center;"><strong>Discipline decisions</strong><br><em>Décisions du conseil de discipline</em> </td>
                        <td colspan="4" style="border : 1px solid black;text-align : center;"><strong>Class council decisions</strong><br><em>Décisions du conseil de classe</em> </td>
                        <td colspan="<?php echo ($nnexs +1); ?>" style="border : 1px solid black;text-align : center;"><strong>Appreciation</strong><br><em>Appréciation</em> </td>
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
                              <br><em>
                                <?php
                                 echo get_discipline_decision($te, $bidsd['id'], school_id(), active_session());  ?>
                                </em> 
                              <?php } ?>
                        </td>
                        <td colspan="4" style="border : 1px solid black; text-align : center;">
                            <?php
                             $ave =$this->crud_model->get_div_average($class_id, $section_id, $exam_id, $mark['student_id'])->row()->average; 
                                echo get_class_council($ave,school_id(), active_session()); 
                            ?><br>
                            <br><em>
                                <?php
                                 echo get_class_councilf($ave, school_id(), active_session()); 
                            ?>
                                </em> 
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
                        <?php
                          $sub= $this->db->get_where('average_subject', array('school_id' => $school_id, 'session' => active_session(), 'student_id' =>$mark['student_id'], 'exam_id' => $exam_id, 'class_id' => $class_id, 'section_id' => $section_id))->result_array(); 
                          $ca = get_settings('mark_to_catch');
                          foreach($sub as $su){
                              if (($su['mark_obtained'] < $ca) && ($su['coef'] > 0)){
                                 echo $this->db->get_where('subjects', array('id' => $su['subject_id']))->row('name').'; ';
                              }
                              }
                            
                      ?>
                        </td>
                        <td colspan="5" style="border : 1px solid black;">
                            <h5><?php echo $this->db->get_where('schools', array('id' =>school_id()))->row()->title; ?></h5><br><br>
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
  </div>
</div>