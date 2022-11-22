
<form method="POST" class="d-block ajaxForm" action="<?php echo route('manage_class/section/'.$param1); ?>">
    <?php $count = 0; ?>
    <?php $thesec = $this->db->get_where('sections', array('class_id' => $param1))->result_array(); ?>
    <?php $n = $this->db->get_where('sections', array('class_id' => $param1))->num_rows(); ?>
    <span class="badge badge-warning pt-1">!</span><?php echo get_phrase('you_must_link_classes_either_to_options_or_to_school_divisions'); ?>
    <?php if($n == 0){ ?>
            <div class="form-row mr-2">
            <div class="form-group col-8">
                <input type="hidden" class="form-control" id="section" name = "section_id[]" value="0">
                <small id="name_help" class="form-text text-muted"><?php echo get_phrase('name'); ?> <em></em></small>
                <input type="text" class="form-control" id="section_name" name = "section_name[]" placeholder="<?php echo get_phrase('name_in_english'); ?>" value="" required>
            </div>
            <div class="form-group col-4">
                <small id="name_help" class="form-text text-muted"><?php echo get_phrase('short_name'); ?> <em></em></small>
                <input type="text" class="form-control" id="section_sname" name = "section_sname[]" placeholder="<?php echo get_phrase('short_name_in_english'); ?>" value="" required>
            </div>
            <div class="form-group col-8">
                <small id="name_help" class="form-text text-muted"><?php echo get_phrase('name'); ?> <em>Fr</em></small>
                <input type="text" class="form-control" id="fsection_name" name = "fsection_name[]" placeholder="<?php echo get_phrase('name_in_french'); ?>" value="" required>
            </div>
            <div class="form-group col-4">
                <small id="name_help" class="form-text text-muted"><?php echo get_phrase('short_name'); ?> <em>Fr</em></small>
                <input type="text" class="form-control" id="fsection_sname" name = "fsection_sname[]" placeholder="<?php echo get_phrase('short_name_in_french'); ?>" value="" required>
            </div>
            <?php 
                $n = $this->crud_model->get_schools()->num_rows();
                if ($n > 1){
            ?>
            <div class="form-group col-md-5">
                <small id="name_help" class="form-text text-muted"><?php echo get_phrase('link_to_division'); ?></small>
                <select name="division[]" id="division" class="form-control select2" data-toggle = "select2">
                    <option value=""><?php echo get_phrase('no_need_to_link_to_division'); ?></option>
                    <?php
                    $schools = $this->db->get_where('schools')->result_array();
                      foreach ($schools as $school): ?>
                         <?php if($this->db->get_where('divisions', array('school_id' => $school['id']))->num_rows() > 0) {?>
                          <optgroup label="<?php echo $school['name'].' / '.$school['name_fr']; ?>">
                              <?php
                                                                                                                           
                                $sectionss = $this->db->get_where('divisions', array('school_id' => $school['id']))->result_array(); ?>
                              <?php
                              foreach ($sectionss as $sectionss): ?>
                                    <option value="<?php echo $sectionss['id']; ?>"><?php echo $sectionss['name'].' / '.$sectionss['name_fr']; ?></option>
                              <?php endforeach; ?>
                          </optgroup>
                        <?php } ?>
                     <?php endforeach; ?>
                  </select> 
            </div>
            <div class="form-group col-md-5">
                <small id="name_help" class="form-text text-muted"><?php echo get_phrase('link_to_option'); ?></small>
                <select name="option[]" id="option" class="form-control select2" data-toggle = "select2">
                    <option value=""><?php echo get_phrase('no_need_to_link_to_option'); ?></option>
                    <?php
                    $schoo = $this->db->get_where('divisions')->result_array();
                      foreach ($schoo as $schoo): ?>
                         <?php if($this->db->get_where('division_option', array('division_id' => $schoo['id']))->num_rows() > 0) {?>
                          <optgroup label="<?php echo $schoo['name'].' / '.$schoo['name_fr']; ?>">
                              <?php
                                                                                                                           
                                $sectionss = $this->db->get_where('division_option', array('division_id' => $schoo['id']))->result_array();
                                  foreach ($sectionss as $sectionss): ?>
                                   <option value="<?php echo $sectionss['id']; ?>"><?php echo $sectionss['name'].' / '.$sectionss['name_fr']; ?></option>
                                  <?php endforeach; ?>
                          </optgroup>
                        <?php } ?>
                    <?php endforeach; ?>
                    <?php $nsec = $this->db->get_where('division_option', array('division_id' => 0))->num_rows();
                         if($nsec > 0){?>
                          <optgroup label="<?php echo get_phrase('others'); ?>">
                              <?php                                                                                      
                                $sectio = $this->db->get_where('division_option', array('division_id' => 0))->result_array();
                                  foreach ($sectio as $sectio): ?>
                                    <option value="<?php echo $sectio['id']; ?>"><?php echo $sectio['name'].' / '.$sectio['name_fr']; ?></option>
                                  <?php endforeach; ?>
                          </optgroup>
                         <?php } ?>
                  </select>
            </div>
            <?php } else{ ?>
            
            <div class="form-group col-md-5">
                <small id="name_help" class="form-text text-muted"><?php echo get_phrase('link_to_division'); ?></small>
                <select name="division[]" id="division" class="form-control select2" data-toggle = "select2">
                    <option value=""><?php echo get_phrase('no_need_to_link_to_division'); ?></option>
                         <?php if($this->db->get_where('divisions', array('school_id' => school_id()))->num_rows() > 0) {
                            $sectionss = $this->db->get_where('divisions', array('school_id' => school_id()))->result_array(); 
                              foreach ($sectionss as $sectionss): ?>
                                    <option value="<?php echo $sectionss['id']; ?>"><?php echo $sectionss['name'].' / '.$sectionss['name_fr']; ?></option>
                              <?php endforeach; ?>
                        <?php } else { ?>
                    <option value=""><?php echo get_phrase('this_school_does_not_have_divisions'); ?></option>
                        <?php } ?>
                  </select>
            </div>
            <div class="form-group col-md-5">
                <small id="name_help" class="form-text text-muted"><?php echo get_phrase('link_to_option'); ?></small>
                <select name="option[]" id="option" class="form-control select2" data-toggle = "select2">
                    <option value=""><?php echo get_phrase('no_need_to_link_to_option'); ?></option>
                    <?php
                    $schoo = $this->db->get_where('divisions', array('school_id'=>school_id()))->result_array();
                      foreach ($schoo as $schoo): ?>
                         <?php if($this->db->get_where('division_option', array('division_id' => $schoo['id']))->num_rows() > 0) {?>
                          <optgroup label="<?php echo $schoo['name'].' / '.$schoo['name_fr']; ?>">
                              <?php
                                                                                                                           
                                $sectionss = $this->db->get_where('division_option', array('division_id' => $schoo['id']))->result_array();
                                  foreach ($sectionss as $sectionss): ?>
                                    <option value="<?php echo $sectionss['id']; ?>"><?php echo $sectionss['name'].' / '.$sectionss['name_fr']; ?></option>
                                  <?php endforeach; ?>
                          </optgroup>
                        <?php } ?>
                    <?php endforeach; ?>
                         <?php $nsec = $this->db->get_where('division_option', array('division_id' => 0))->num_rows();
                         if($nsec > 0){?>
                          <optgroup label="<?php echo get_phrase('others'); ?>">
                              <?php                                                                                      
                                $sectio = $this->db->get_where('division_option', array('division_id' => 0))->result_array();
                                  foreach ($sectio as $sectio): ?>
                                    <option value="<?php echo $sectio['id']; ?>"><?php echo $sectio['name'].' / '.$sectio['name_fr']; ?></option>
                                  <?php endforeach; ?>
                          </optgroup>
                          <?php }?>
                  </select>
            </div> 
            <?php }?>
                
            <div class="form-group col-2">
                <small id="name_help" class="form-text text-muted"> + </small>
                <button class="btn btn-icon btn-success" type="button" onclick="appendSection()"><i class="mdi mdi-plus-circle"></i></button>
            </div>
        </div>
        <?php } ?>
    
    <?php foreach($thesec as $section){
        $count++; ?>
    
        <?php if($count == 1){ ?>
    
            <div class="form-row mr-2">
            <input type="hidden" class="form-control" id="section" name = "section_id[]" value="<?php echo $section['id']; ?>">
            <div class="form-group col-8">
                <small id="name_help" class="form-text text-muted"><?php echo get_phrase('name'); ?> <em></em></small>
                <input type="text" class="form-control" id="section_name" value="<?php echo $section['name']; ?>" name = "section_name[]" placeholder="<?php echo get_phrase('name_in_english'); ?>" value="" required>
            </div>
            <div class="form-group col-4">
                <small id="name_help" class="form-text text-muted"><?php echo get_phrase('short_name'); ?> <em></em></small>
                <input type="text" class="form-control" id="section_sname" value="<?php echo $section['short_name']; ?>" name = "section_sname[]" placeholder="<?php echo get_phrase('short_name_in_english'); ?>" value="" required>
            </div>
            <div class="form-group col-8">
                <small id="name_help" class="form-text text-muted"><?php echo get_phrase('name'); ?> <em>Fr</em></small>
                <input type="text" class="form-control" id="fsection_name" value="<?php echo $section['name_fr']; ?>" name = "fsection_name[]" placeholder="<?php echo get_phrase('name_in_french'); ?>" value="" required>
            </div>
            <div class="form-group col-4">
                <small id="name_help" class="form-text text-muted"><?php echo get_phrase('short_name'); ?> <em>Fr</em></small>
                <input type="text" class="form-control" id="fsection_sname" value="<?php echo $section['short_name_fr']; ?>" name = "fsection_sname[]" placeholder="<?php echo get_phrase('short_name_in_french'); ?>" value="" required>
            </div>
            <?php 
                $n = $this->crud_model->get_schools()->num_rows();
                if ($n > 1){
            ?>
            <div class="form-group col-md-5">
                <small id="name_help" class="form-text text-muted"><?php echo get_phrase('link_to_division'); ?></small>
                <select name="division[]" id="division" class="form-control select2" data-toggle = "select2">
                    <option value=""><?php echo get_phrase('no_need_to_link_to_division'); ?></option>
                    <?php
                    $schools = $this->db->get_where('schools')->result_array();
                      foreach ($schools as $school): ?>
                         <?php if($this->db->get_where('divisions', array('school_id' => $school['id']))->num_rows() > 0) {?>
                          <optgroup label="<?php echo $school['name'].' / '.$school['name_fr']; ?>">
                              <?php
                                                                                                                           
                                $secti = $this->db->get_where('divisions', array('school_id' => $school['id']))->result_array(); ?>
                              <?php
                              foreach ($secti as $secti): ?>
                                    <option value="<?php echo $secti['id']; ?>"<?php if($section['division_id'] == $secti['id']){?> selected <?php } ?>><?php echo $secti['name'].' / '.$secti['name_fr']; ?></option>
                              <?php endforeach; ?>
                          </optgroup>
                        <?php } ?>
                     <?php endforeach; ?>
                  </select>
            </div>
            <div class="form-group col-md-5">
                <small id="name_help" class="form-text text-muted"><?php echo get_phrase('link_to_option'); ?></small>
                <select name="option[]" id="option" class="form-control select2" data-toggle = "select2">
                    <option value=""><?php echo get_phrase('no_need_to_link_to_option'); ?></option>
                    <?php
                    $schoo = $this->db->get_where('divisions')->result_array();
                      foreach ($schoo as $schoo): ?>
                         <?php if($this->db->get_where('division_option', array('division_id' => $schoo['id']))->num_rows() > 0) {?>
                          <optgroup label="<?php echo $schoo['name'].' / '.$schoo['name_fr']; ?>">
                              <?php
                                                                                                                           
                                $sect = $this->db->get_where('division_option', array('division_id' => $schoo['id']))->result_array();
                                  foreach ($sect as $sect): ?>
                                    <option value="<?php echo $sect['id']; ?>"<?php if($section['option_id'] == $sect['id']){?> selected <?php } ?>><?php echo $sect['name'].' / '.$sect['name_fr']; ?></option>
                                  <?php endforeach; ?>
                          </optgroup>
                        <?php } ?>
                    <?php endforeach; ?>
                    <?php $nsec = $this->db->get_where('division_option', array('division_id' => 0))->num_rows();
                         if($nsec > 0){?>
                          <optgroup label="<?php echo get_phrase('others'); ?>">
                              <?php                                                                                      
                                $sec = $this->db->get_where('division_option', array('division_id' => 0))->result_array();
                                  foreach ($sec as $sec): ?>
                                    <option value="<?php echo $sec['id']; ?>"<?php if($section['option_id'] == $sec['id']){?> selected <?php } ?>><?php echo $sec['name'].' / '.$sec['name_fr']; ?></option>
                                  <?php endforeach; ?>
                          </optgroup>
                         <?php }?>
                  </select>
            </div>
            <?php } 
                else{ ?>
            
            <div class="form-group col-md-5">
                <small id="name_help" class="form-text text-muted"><?php echo get_phrase('link_to_division'); ?></small>
                <select name="division[]" id="division" class="form-control select2" data-toggle = "select2">
                         <?php if($this->db->get_where('divisions', array('school_id' => school_id()))->num_rows() > 0) {
                            $secti = $this->db->get_where('divisions', array('school_id' => school_id()))->result_array(); ?>
                                    <option value=""><?php echo get_phrase('no_need_to_link_to_division'); ?></option>
                              <?php foreach ($secti as $secti): ?>
                                    <option value="<?php echo $section['id']; ?>"<?php if($section['division_id'] == $secti['id']){?> selected <?php } ?>><?php echo $secti['name'].' / '.$secti['name_fr']; ?></option>
                              <?php endforeach; ?>
                        <?php } else { ?>
                    <option value=""><?php echo get_phrase('this_school_does_not_have_divisions'); ?></option>
                        <?php } ?>
                  </select>
            </div>
            <div class="form-group col-md-5">
                <small id="name_help" class="form-text text-muted"><?php echo get_phrase('link_to_option'); ?></small>
                <select name="option[]" id="option" class="form-control select2" data-toggle = "select2">
                    <option value=""><?php echo get_phrase('no_need_to_link_to_option'); ?></option>
                    <?php
                    $schoo = $this->db->get_where('divisions', array('school_id'=>school_id()))->result_array();
                      foreach ($schoo as $schoo): ?>
                         <?php if($this->db->get_where('division_option', array('division_id' => $schoo['id']))->num_rows() > 0) {?>
                          <optgroup label="<?php echo $schoo['name'].' / '.$schoo['name_fr']; ?>">
                              <?php
                                                                                                                           
                                $sect = $this->db->get_where('division_option', array('division_id' => $schoo['id']))->result_array();
                                  foreach ($sect as $sect): ?>
                                    <option value="<?php echo $sect['id']; ?>"<?php if($section['option_id'] == $sect['id']){?> selected <?php } ?>><?php echo $sect['name'].' / '.$sect['name_fr']; ?></option>
                                  <?php endforeach; ?>
                          </optgroup>
                        <?php } ?>
                    <?php endforeach; ?>
                    <?php $nsec = $this->db->get_where('division_option', array('division_id' => 0))->num_rows();
                         if($nsec > 0){?>
                          <optgroup label="<?php echo get_phrase('others'); ?>">
                              <?php                                                                                      
                                $sec = $this->db->get_where('division_option', array('division_id' => 0))->result_array();
                                  foreach ($sec as $sec): ?>
                                    <option value="<?php echo $sec['id']; ?>"<?php if($section['option_id'] == $sec['id']){?> selected <?php } ?>><?php echo $sec['name'].' / '.$sec['name_fr']; ?></option>
                                  <?php endforeach; ?>
                          </optgroup>
                         <?php }?>
                  </select>
            </div> 
            <?php }?>
                
            <div class="form-group col-2">
                <small id="name_help" class="form-text text-muted"> + </small>
                <button class="btn btn-icon btn-success" type="button" onclick="appendSection()"><i class="mdi mdi-plus-circle"></i></button>
            </div>
            </div>
        <?php } ?> 

        <?php if($count != 1){ ?>
            <div class="form-row mr-2" id="sectionDatabase<?php echo $section['id']; ?>">
            <table width="100%">
                <thead>
                    <tr style="background-color: #313a46; color: #fff;">
                        <th style="text-align:center;"> </th>
                    </tr>
                </thead>
            </table>
            <div class="form-group col-8">
                <input type="hidden" class="form-control" id="section<?php echo $section['id']; ?>" name = "section_id[]" value="<?php echo $section['id']; ?>">
                <small id="name_help" class="form-text text-muted"><?php echo get_phrase('name'); ?> <em></em></small>
                <input type="text" class="form-control" id="section_name" value="<?php echo $section['name']; ?>" name = "section_name[]" placeholder="<?php echo get_phrase('name_in_english'); ?>" value="" required>
            </div>
            <div class="form-group col-4">
                <small id="name_help" class="form-text text-muted"><?php echo get_phrase('short_name'); ?> <em></em></small>
                <input type="text" class="form-control" id="section_sname" value="<?php echo $section['short_name']; ?>" name = "section_sname[]" placeholder="<?php echo get_phrase('short_name_in_english'); ?>" value="" required>
            </div>
            <div class="form-group col-8">
                <small id="name_help" class="form-text text-muted"><?php echo get_phrase('name'); ?> <em>Fr</em></small>
                <input type="text" class="form-control" id="fsection_name" value="<?php echo $section['name_fr']; ?>" name = "fsection_name[]" placeholder="<?php echo get_phrase('name_in_french'); ?>" value="" required>
            </div>
            <div class="form-group col-4">
                <small id="name_help" class="form-text text-muted"><?php echo get_phrase('short_name'); ?> <em>Fr</em></small>
                <input type="text" class="form-control" id="fsection_sname" value="<?php echo $section['short_name_fr']; ?>" name = "fsection_sname[]" placeholder="<?php echo get_phrase('short_name_in_french'); ?>" value="" required>
            </div>
            <?php 
                $n = $this->crud_model->get_schools()->num_rows();
                if ($n > 1){
            ?>
            <div class="form-group col-md-5">
                <small id="name_help" class="form-text text-muted"><?php echo get_phrase('link_to_division'); ?></small>
                <select name="division[]" id="division" class="form-control select2" data-toggle = "select2">
                    <option value=""><?php echo get_phrase('no_need_to_link_to_division'); ?></option>
                    <?php
                    $schools = $this->db->get_where('schools')->result_array();
                      foreach ($schools as $school): ?>
                         <?php if($this->db->get_where('divisions', array('school_id' => $school['id']))->num_rows() > 0) {?>
                          <optgroup label="<?php echo $school['name'].' / '.$school['name_fr']; ?>">
                              <?php
                                                                                                                           
                                $secti = $this->db->get_where('divisions', array('school_id' => $school['id']))->result_array(); ?>
                              <?php
                              foreach ($secti as $secti): ?>
                                    <option value="<?php echo $secti['id']; ?>"<?php if($section['division_id'] == $secti['id']){?> selected <?php } ?>><?php echo $secti['name'].' / '.$secti['name_fr']; ?></option>
                              <?php endforeach; ?>
                          </optgroup>
                        <?php } ?>
                     <?php endforeach; ?>
                  </select>
            </div>
            <div class="form-group col-md-5">
                <small id="name_help" class="form-text text-muted"><?php echo get_phrase('link_to_option'); ?></small>
                <select name="option[]" id="option" class="form-control select2" data-toggle = "select2">
                    <option value=""><?php echo get_phrase('no_need_to_link_to_option'); ?></option>
                    <?php
                    $schoo = $this->db->get_where('divisions')->result_array();
                      foreach ($schoo as $schoo): ?>
                         <?php if($this->db->get_where('division_option', array('division_id' => $schoo['id']))->num_rows() > 0) {?>
                          <optgroup label="<?php echo $schoo['name'].' / '.$schoo['name_fr']; ?>">
                              <?php
                                                                                                                           
                                $sect = $this->db->get_where('division_option', array('division_id' => $schoo['id']))->result_array();
                                  foreach ($sect as $sect): ?>
                                    <option value="<?php echo $sect['id']; ?>"<?php if($section['option_id'] == $sect['id']){?> selected <?php } ?>><?php echo $sect['name'].' / '.$sect['name_fr']; ?></option>
                                  <?php endforeach; ?>
                          </optgroup>
                        <?php } ?>
                    <?php endforeach; ?>
                    <?php $nsec = $this->db->get_where('division_option', array('division_id' => 0))->num_rows();
                         if($nsec > 0){?>
                          <optgroup label="<?php echo get_phrase('others'); ?>">
                              <?php                                                                                      
                                $sec = $this->db->get_where('division_option', array('division_id' => 0))->result_array();
                                  foreach ($sec as $sec): ?>
                                    <option value="<?php echo $sec['id']; ?>"<?php if($section['option_id'] == $sec['id']){?> selected <?php } ?>><?php echo $sec['name'].' / '.$sec['name_fr']; ?></option>
                                  <?php endforeach; ?>
                          </optgroup>
                         <?php }?>
                  </select>
            </div>
            <?php } 
                else{ ?>
            
            <div class="form-group col-md-5">
                <small id="name_help" class="form-text text-muted"><?php echo get_phrase('link_to_division'); ?></small>
                <select name="division[]" id="division" class="form-control select2" data-toggle = "select2">
                         <?php if($this->db->get_where('divisions', array('school_id' => school_id()))->num_rows() > 0) {
                            $secti = $this->db->get_where('divisions', array('school_id' => school_id()))->result_array(); ?>
                                    <option value=""><?php echo get_phrase('no_need_to_link_to_division'); ?></option>
                              <?php foreach ($secti as $secti): ?>
                                    <option value="<?php echo $section['id']; ?>"<?php if($section['division_id'] == $secti['id']){?> selected <?php } ?>><?php echo $secti['name'].' / '.$secti['name_fr']; ?></option>
                              <?php endforeach; ?>
                        <?php } else { ?>
                    <option value=""><?php echo get_phrase('this_school_does_not_have_divisions'); ?></option>
                        <?php } ?>
                  </select>
            </div>
            <div class="form-group col-md-5">
                <small id="name_help" class="form-text text-muted"><?php echo get_phrase('link_to_option'); ?></small>
                <select name="option[]" id="option" class="form-control select2" data-toggle = "select2">
                    <option value=""><?php echo get_phrase('no_need_to_link_to_option'); ?></option>
                    <?php
                    $schoo = $this->db->get_where('divisions', array('school_id'=>school_id()))->result_array();
                      foreach ($schoo as $schoo): ?>
                         <?php if($this->db->get_where('division_option', array('division_id' => $schoo['id']))->num_rows() > 0) {?>
                          <optgroup label="<?php echo $schoo['name'].' / '.$schoo['name_fr']; ?>">
                              <?php
                                                                                                                           
                                $sect = $this->db->get_where('division_option', array('division_id' => $schoo['id']))->result_array();
                                  foreach ($sect as $sect): ?>
                                    <option value="<?php echo $sect['id']; ?>"<?php if($section['option_id'] == $sect['id']){?> selected <?php } ?>><?php echo $sect['name'].' / '.$sect['name_fr']; ?></option>
                                  <?php endforeach; ?>
                          </optgroup>
                        <?php } ?>
                    <?php endforeach; ?>
                    <?php $nsec = $this->db->get_where('division_option', array('division_id' => 0))->num_rows();
                         if($nsec > 0){?>
                          <optgroup label="<?php echo get_phrase('others'); ?>">
                              <?php                                                                                      
                                $sec = $this->db->get_where('division_option', array('division_id' => 0))->result_array();
                                  foreach ($sec as $sec): ?>
                                    <option value="<?php echo $sec['id']; ?>"<?php if($section['option_id'] == $sec['id']){?> selected <?php } ?>><?php echo $sec['name'].' / '.$sec['name_fr']; ?></option>
                                  <?php endforeach; ?>
                          </optgroup>
                         <?php }?>
                  </select>
            </div> 
            <?php }?>
                
                <div class="form-group col-2">
                <small id="name_help" class="form-text text-muted"> - </small>
                    <button class="btn btn-icon btn-danger" type="button" onclick="removeSectionDatabase('<?php echo $section['id']; ?>')"><i class="mdi mdi-close-circle"></i></button>
                </div>
            </div>
        <?php } ?>

    <?php } ?>
    <div id = "section_area"></div>
    <span class="badge badge-danger pt-1">!</span><?php echo get_phrase('you_must_link_classes_either_to_options_or_to_school_divisions'); ?>
    <div class="row no-gutters">
        <div class="form-group  col-md-12 p-0 mt-2">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update'); ?></button>
        </div>
    </div>
</form>

<div id = "blank_section">
         <div class="form-row mr-2">
            <table width="100%">
                <thead>
                    <tr style="background-color: #313a46; color: #fff;">
                        <th style="text-align:center;"> </th>
                    </tr>
                </thead>
            </table>
            <div class="form-group col-8">
                <input type="hidden" class="form-control" name = "section_id[]" value="0">
                <small id="name_help" class="form-text text-muted"><?php echo get_phrase('name'); ?> <em></em></small>
                <input type="text" class="form-control" id="section_name" name = "section_name[]" placeholder="<?php echo get_phrase('name_in_english'); ?>" value="" required>
            </div>
            <div class="form-group col-4">
                <small id="name_help" class="form-text text-muted"><?php echo get_phrase('short_name'); ?> <em></em></small>
                <input type="text" class="form-control" id="section_sname" name = "section_sname[]" placeholder="<?php echo get_phrase('short_name_in_english'); ?>" value="" required>
            </div>
            <div class="form-group col-8">
                <small id="name_help" class="form-text text-muted"><?php echo get_phrase('name'); ?> <em>Fr</em></small>
                <input type="text" class="form-control" id="fsection_name" name = "fsection_name[]" placeholder="<?php echo get_phrase('name_in_french'); ?>" value="" required>
            </div>
            <div class="form-group col-4">
                <small id="name_help" class="form-text text-muted"><?php echo get_phrase('short_name'); ?> <em>Fr</em></small>
                <input type="text" class="form-control" id="fsection_sname" name = "fsection_sname[]" placeholder="<?php echo get_phrase('short_name_in_french'); ?>" value="" required>
            </div>
            <?php 
                $n = $this->crud_model->get_schools()->num_rows();
                if ($n > 1){
            ?>
            <div class="form-group col-md-5">
                <small id="name_help" class="form-text text-muted"><?php echo get_phrase('link_to_division'); ?></small>
                <select name="division[]" id="division" class="form-control select2" data-toggle = "select2">
                    <option value=""><?php echo get_phrase('no_need_to_link_to_division'); ?></option>
                    <?php
                    $schools = $this->db->get_where('schools')->result_array();
                      foreach ($schools as $school): ?>
                         <?php if($this->db->get_where('divisions', array('school_id' => $school['id']))->num_rows() > 0) {?>
                          <optgroup label="<?php echo $school['name'].' / '.$school['name_fr']; ?>">
                              <?php
                                                                                                                           
                                $sectionss = $this->db->get_where('divisions', array('school_id' => $school['id']))->result_array(); ?>
                              <?php
                              foreach ($sectionss as $sectionss): ?>
                                    <option value="<?php echo $sectionss['id']; ?>"><?php echo $sectionss['name'].' / '.$sectionss['name_fr']; ?></option>
                              <?php endforeach; ?>
                          </optgroup>
                        <?php } ?>
                     <?php endforeach; ?>
                  </select>
            </div>
            <div class="form-group col-md-5">
                <small id="name_help" class="form-text text-muted"><?php echo get_phrase('link_to_option'); ?></small>
                <select name="option[]" id="option" class="form-control select2" data-toggle = "select2">
                    <option value=""><?php echo get_phrase('no_need_to_link_to_option'); ?></option>
                    <?php
                    $schoo = $this->db->get_where('divisions')->result_array();
                      foreach ($schoo as $schoo): ?>
                         <?php if($this->db->get_where('division_option', array('division_id' => $schoo['id']))->num_rows() > 0) {?>
                          <optgroup label="<?php echo $schoo['name'].' / '.$schoo['name_fr']; ?>">
                              <?php
                                                                                                                           
                                $sectionss = $this->db->get_where('division_option', array('division_id' => $schoo['id']))->result_array();
                                  foreach ($sectionss as $sectionss): ?>
                                   <option value="<?php echo $sectionss['id']; ?>"><?php echo $sectionss['name'].' / '.$sectionss['name_fr']; ?></option>
                                  <?php endforeach; ?>
                          </optgroup>
                        <?php } ?>
                    <?php endforeach; ?>
                    <?php $nsec = $this->db->get_where('division_option', array('division_id' => 0))->num_rows();
                         if($nsec > 0){?>
                          <optgroup label="<?php echo get_phrase('others'); ?>">
                              <?php                                                                                      
                                $sectio = $this->db->get_where('division_option', array('division_id' => 0))->result_array();
                                  foreach ($sectio as $sectio): ?>
                                    <option value="<?php echo $sectio['id']; ?>"><?php echo $sectio['name'].' / '.$sectio['name_fr']; ?></option>
                                  <?php endforeach; ?>
                          </optgroup>
                         <?php } ?>
                  </select>
            </div>
            <?php } else{ ?>
            
            <div class="form-group col-md-5">
                <small id="name_help" class="form-text text-muted"><?php echo get_phrase('link_to_division'); ?></small>
                <select name="division[]" id="division" class="form-control select2" data-toggle = "select2">
                    <option value=""><?php echo get_phrase('no_need_to_link_to_division'); ?></option>
                         <?php if($this->db->get_where('divisions', array('school_id' => school_id()))->num_rows() > 0) {
                            $sectionss = $this->db->get_where('divisions', array('school_id' => school_id()))->result_array(); 
                              foreach ($sectionss as $sectionss): ?>
                                    <option value="<?php echo $sectionss['id']; ?>"><?php echo $sectionss['name'].' / '.$sectionss['name_fr']; ?></option>
                              <?php endforeach; ?>
                        <?php } else { ?>
                    <option value=""><?php echo get_phrase('this_school_does_not_have_divisions'); ?></option>
                        <?php } ?>
                  </select>
            </div>
            <div class="form-group col-md-5">
                <small id="name_help" class="form-text text-muted"><?php echo get_phrase('link_to_option'); ?></small>
                <select name="option[]" id="option" class="form-control select2" data-toggle = "select2">
                    <option value=""><?php echo get_phrase('no_need_to_link_to_option'); ?></option>
                    <?php
                    $schoo = $this->db->get_where('divisions', array('school_id'=>school_id()))->result_array();
                      foreach ($schoo as $schoo): ?>
                         <?php if($this->db->get_where('division_option', array('division_id' => $schoo['id']))->num_rows() > 0) {?>
                          <optgroup label="<?php echo $schoo['name'].' / '.$schoo['name_fr']; ?>">
                              <?php
                                                                                                                           
                                $sectionss = $this->db->get_where('division_option', array('division_id' => $schoo['id']))->result_array();
                                  foreach ($sectionss as $sectionss): ?>
                                    <option value="<?php echo $sectionss['id']; ?>"><?php echo $sectionss['name'].' / '.$sectionss['name_fr']; ?></option>
                                  <?php endforeach; ?>
                          </optgroup>
                        <?php } ?>
                    <?php endforeach; ?>
                         <?php $nsec = $this->db->get_where('division_option', array('division_id' => 0))->num_rows();
                         if($nsec > 0){?>
                          <optgroup label="<?php echo get_phrase('others'); ?>">
                              <?php                                                                                      
                                $sectio = $this->db->get_where('division_option', array('division_id' => 0))->result_array();
                                  foreach ($sectio as $sectio): ?>
                                    <option value="<?php echo $sectio['id']; ?>"><?php echo $sectio['name'].' / '.$sectio['name_fr']; ?></option>
                                  <?php endforeach; ?>
                          </optgroup>
                          <?php }?>
                  </select>
            </div> 
            <?php }?>
                
            <div class="form-group col-2">
                <small id="name_help" class="form-text text-muted"> - </small>
                <button class="btn btn-icon btn-danger" type="button" onclick="removeSection(this)"><i class="mdi mdi-close-circle"></i></button>
            </div>
        </div>
</div>


<script>
$(document).ready(function() {
    $('#blank_section').hide();
    initSelect2(['#division', '#option']);
});
//update form
 // Jquery form validation initialization
$(".ajaxForm").validate({});
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllClasses);
});

var blank_section_field = $('#blank_section').html();

$(document).ready(function() {
    $('#blank_section').hide();
});


function appendSection() {
    $('#section_area').append(blank_section_field);
}

function removeSection(elem) {
    $(elem).closest('.form-row').remove();
}

function removeSectionDatabase(section_id) {
    $('#sectionDatabase'+section_id).hide();
    $('#section'+section_id).val(section_id+'delete');
}
</script>
