<?php
  $school_id = school_id();

if($action ==1){
?>

<table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
  <thead>
    <tr style="background-color: #313a46; color: #ababab;">
      <th>#</th>
      <th><?php echo get_phrase('photo'); ?></th>
      <th><?php echo get_phrase('name'); ?></th>
      <th><?php echo get_phrase('birth'); ?></th>
      <th><?php echo get_phrase('origin'); ?></th>
      <th><?php echo get_phrase('contact'); ?></th>
      <th><?php echo get_phrase('options'); ?></th>
    </tr>
  </thead>
  <tbody>
    <?php
      $c=1;
    $enrols = $this->db->get_where('enrols', array('class_id' => $class_id, 'section_id' => $section_id, 'school_id' => $school_id, 'session' => active_session()))->result_array();
    foreach($enrols as $enroll){
      $student = $this->db->get_where('students', array('id' => $enroll['student_id']))->row_array();
      ?>
      <tr>
        <td><?php echo $c++; ?></td>  
        <td>
          <img class="rounded-circle" width="50" height="50" src="<?php echo $this->user_model->get_user_image($student['user_id']); ?>">
        </td>
        <td><?php echo $this->user_model->get_user_details($student['user_id'], 'name'); ?></td>
        <td>
            <?php 
            $bt = $this->user_model->get_user_details($student['user_id'], 'birthtype');
            if ($bt =='around'){
               $bd = $this->user_model->get_user_details($student['user_id'], 'birthday'); 
            }else{
               $bd = $this->user_model->get_user_details($student['user_id'], 'birthday'); 
            }
            echo $this->user_model->get_user_details($student['user_id'], 'birthplace').'<br>'.get_phrase($bt).' '.$bd; 
            
            ?>
          
        </td>
        <td>
        <?php 
        $reg=$this->db->get_where('regions', array('id' => $this->user_model->get_user_details($student['user_id'], 'region_id')))->row()->name;
        $dep=$this->db->get_where('department', array('id' => $this->user_model->get_user_details($student['user_id'], 'department')))->row()->name;
        $nat=$this->user_model->get_user_details($student['user_id'], 'nationality');
        echo $dep.', '.$reg.', '.$nat; ?>
        </td>
        <td>
            <?php echo $this->user_model->get_user_details($student['user_id'], 'email'); ?><br>
            <?php echo $this->user_model->get_user_details($student['user_id'], 'phone'); ?><br>
            <?php echo $this->user_model->get_user_details($student['user_id'], 'address'); ?>
        </td>
        <td> 
          <div class="dropdown text-center">
  					<button type="button" class="btn btn-sm btn-icon btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
  					<div class="dropdown-menu dropdown-menu-right">
              <!-- item-->
              <?php if(addon_status('id-card')):?>
                <a href="javascript:void(0);" class="dropdown-item" onclick="largeModal('<?php echo site_url('modal/popup/student/id_card/'.$student['id'])?>', '<?php echo $this->db->get_where('schools', array('id' => $school_id))->row('name'); ?>')"><?php echo get_phrase('generate_id_card'); ?></a>
              <?php endif;?>
              <!-- item-->
  						<a href="javascript:void(0);" class="dropdown-item"  onclick="largeModal('<?php echo site_url('modal/popup/student/profile/'.$student['id'])?>', '<?php echo $this->db->get_where('schools', array('id' => $school_id))->row('name'); ?>')"><?php echo get_phrase('profile'); ?></a>
  						<!-- item-->
  						<a href="<?php echo route('student/edit/'.$student['id']); ?>" class="dropdown-item"><?php echo get_phrase('edit'); ?></a>
              <!-- item -->
              <a href="javascript:;" class="dropdown-item" onclick="confirmModal('<?php echo route('student/delete/'.$student['id'].'/'.$student['user_id']); ?>', showAllStudents)"><?php echo get_phrase('delete'); ?></a>
  					</div>
  				</div> 
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>

<?php }else{ ?>

<table class="table table-striped dt-responsive nowrap" width="100%">
  <thead>
    <tr style="background-color: #313a46; color: #ababab;">
      <th>#</th>
      <th><?php echo get_phrase('photo'); ?></th>
      <th><?php echo get_phrase('name'); ?></th>
      <th><?php echo get_phrase('origin'); ?></th>
      <th><?php echo get_phrase('contact'); ?></th>
    </tr>
  </thead>
  <tbody>
    <?php
      $c=1;
            
    $enrols = $this->db->get_where('enrols', array('class_id' => $class_id, 'section_id' => $section_id, 'school_id' => $school_id, 'session' => active_session()))->result_array();
    foreach($enrols as $enroll){
      $student = $this->db->get_where('students', array('id' => $enroll['student_id']))->row_array();
      ?>
      <tr id="stud<?php echo $enroll['student_id'];?>">
        <td><?php echo $c++; ?></td>  
        <td>
            <form method="POST" class="col-12 d-block ajaxForm<?php echo $enroll['student_id'];?>" action="<?php echo route('student/updated/'.$enroll['student_id'].'/'.$student['user_id']); ?>" id = "student_update_form" enctype="multipart/form-data">
            <div class="col-xl-6">
                  <div class="wrapper-image-preview<?php echo $enroll['student_id'];?>" style="margin-left: -16px;">
                    <div class="box" style="width: 250px;">
                      <div class="js--image-preview" style="background-image: url(<?php echo $this->user_model->get_user_image($student['user_id']); ?>); background-color: #F5F5F5;"></div>
                      <div class="upload-options">
                        <label for="student_image<?php echo $enroll['student_id'];?>" class="btn"> <i class="mdi mdi-camera"></i> <?php echo get_phrase('upload_another_image'); ?> </label>
                        <input id="student_image<?php echo $enroll['student_id'];?>" style="visibility:hidden;" type="file" class="image-upload" name="student_image<?php echo $enroll['student_id'];?>" accept="image/*" onchange="singleupdate(<?php echo $enroll['student_id'];?>)">
                      </div>
                    </div>
                  </div>
            </div>
            </form>
        </td>
        <td><?php echo $this->user_model->get_user_details($student['user_id'], 'name'); ?>
            <input type="hidden" id="user<?php echo $enroll['student_id'];?>" name="user<?php echo $enroll['student_id'];?>" class="form-control"  value="<?php echo $student['user_id']; ?>" >
            <input type="text" id="name<?php echo $enroll['student_id'];?>" name="name<?php echo $enroll['student_id'];?>" class="form-control"  value="<?php echo $this->user_model->get_user_details($student['user_id'], 'name'); ?>" placeholder="<?php echo get_phrase('full_name_in_order_of_birth_certificate'); ?>" required  onchange="singleupdate(<?php echo $enroll['student_id'];?>)">
            <?php echo get_phrase('gender'); ?>
            <select name="gender<?php echo $enroll['student_id'];?>" id="gender<?php echo $enroll['student_id'];?>" class="form-control select2"  data-toggle = "select2" required  onchange="singleupdate(<?php echo $enroll['student_id'];?>)">
                    <option value=""><?php echo get_phrase('select_gender'); ?></option>
                    <option value="Male" <?php if($this->user_model->get_user_details($student['user_id'], 'gender') == 'Male') echo 'selected'; ?>><?php echo get_phrase('male'); ?></option>
                    <option value="Female" <?php if($this->user_model->get_user_details($student['user_id'], 'gender') == 'Female') echo 'selected'; ?>><?php echo get_phrase('female'); ?></option>
                    <option value="Others" <?php if($this->user_model->get_user_details($student['user_id'], 'gender') == 'Others') echo 'selected'; ?>><?php echo get_phrase('others'); ?></option>
                </select>
            <?php echo get_phrase('birthday'); ?>/<?php echo get_phrase('year_of_birth'); ?>
                <input type="text" class="form-control" name = "birthday<?php echo $enroll['student_id'];?>" id = "birthday<?php echo $enroll['student_id'];?>"  value="<?php echo $this->user_model->get_user_details($student['user_id'], 'birthday'); ?>"  onchange="singleupdate(<?php echo $enroll['student_id'];?>)">
            
           <?php echo get_phrase('place_of_birth'); ?>
                <input type="text" id="place<?php echo $enroll['student_id'];?>" name="place<?php echo $enroll['student_id'];?>" class="form-control" placeholder="<?php echo get_phrase('place_of_birth'); ?>"  value="<?php echo $this->user_model->get_user_details($student['user_id'], 'birthplace'); ?>" required  onchange="singleupdate(<?php echo $enroll['student_id'];?>)">
            </td>
        <td>
        <?php 
        //$reg=$this->db->get_where('regions', array('id' => $this->user_model->get_user_details($student['user_id'], 'region_id')))->row()->name;
        //$dep=$this->db->get_where('department', array('id' => $this->user_model->get_user_details($student['user_id'], 'department')))->row()->name;
        //$nat=$this->user_model->get_user_details($student['user_id'], 'nationality');
        //echo $dep.', '.$reg.', '.$nat; ?>
            <?php echo get_phrase('region'); ?>
            <select name="region<?php echo $enroll['student_id'];?>" id="region<?php echo $enroll['student_id'];?>" class="form-control select2" data-toggle = "select2"  onchange="singleupdate(<?php echo $enroll['student_id'];?>)">
                <option value=""><?php echo get_phrase('select_a_region'); ?></option>
                <?php $classes = $this->db->get_where('regions')->result_array(); ?>
                <?php foreach($classes as $class){ ?>
                    <option value="<?php echo $class['id']; ?>"<?php if($this->user_model->get_user_details($student['user_id'], 'region_id') == $class['id']) echo 'selected'; ?>><?php echo $class['name']; ?></option>
                <?php } ?>
            </select>
            <?php echo get_phrase('department'); ?>
                <select name="dep_id<?php echo $enroll['student_id'];?>" id="dep_id<?php echo $enroll['student_id'];?>" class="form-control select2" data-toggle = "select2"  onchange="singleupdate(<?php echo $enroll['student_id'];?>)">
                    <option value=""><?php echo get_phrase('department_of_origin'); ?></option>
                    <?php 
                     $this->db->order_by("name", "asc"); $classes = $this->db->get_where('department')->result_array(); ?>
                    <?php foreach($classes as $class){ ?>
                        <option value="<?php echo $class['id']; ?>"<?php if($this->user_model->get_user_details($student['user_id'], 'department') == $class['id']) echo 'selected'; ?>><?php echo $class['name']; ?></option>
                    <?php } ?>
                </select>
           <?php echo get_phrase('nationality'); ?>
                <input type="text" id="nat<?php echo $enroll['student_id'];?>" name="nat<?php echo $enroll['student_id'];?>" value="<?php echo $this->user_model->get_user_details($student['user_id'], 'nationality'); ?>" class="form-control" placeholder="<?php echo get_phrase('nationality'); ?>" required  onchange="singleupdate(<?php echo $enroll['student_id'];?>)">  
        </td>
        <td>
            <?php echo $this->user_model->get_user_details($student['user_id'], 'email'); ?>
            <input type="email" class="form-control" id="email<?php echo $enroll['student_id'];?>" name="email<?php echo $enroll['student_id'];?>" id="email<?php echo $enroll['student_id'];?>" value="<?php echo $this->user_model->get_user_details($student['user_id'], 'email'); ?>" placeholder="email"  onchange="singleupdate(<?php echo $enroll['student_id'];?>)"><br>
            <?php echo $this->user_model->get_user_details($student['user_id'], 'phone'); ?>
            <input type="text" id="phone<?php echo $enroll['student_id'];?>" name="phone<?php echo $enroll['student_id'];?>" class="form-control" value="<?php echo $this->user_model->get_user_details($student['user_id'], 'phone'); ?>" placeholder="phone"  onchange="singleupdate(<?php echo $enroll['student_id'];?>)"><br>
            <?php echo $this->user_model->get_user_details($student['user_id'], 'address'); ?>
            <textarea class="form-control" id="address<?php echo $enroll['student_id'];?>" rows="1" name = "address<?php echo $enroll['student_id'];?>" placeholder="address"  onchange="singleupdate(<?php echo $enroll['student_id'];?>)"><?php echo $this->user_model->get_user_details($student['user_id'], 'address'); ?></textarea>
        </td>
      </tr> 
    <?php } ?>
  </tbody>
</table>

<?php } ?>
<script type="text/javascript">
  initDataTable('basic-datatable');
    
 function singleupdate(student) {
        
            var class_id = '<?php echo $class_id; ?>';
            var section_id = '<?php echo $section_id; ?>';
            var student_image = $('#student_image' + student).val(); 
            var name = $('#name' + student).val(); 
            var gender = $('#gender' + student).val(); 
            var birthday = $('#birthday' + student).val(); 
            var place = $('#place' + student).val(); 
            var region = $('#region' + student).val(); 
            var dep_id = $('#dep_id' + student).val(); 
            var user = $('#user' + student).val(); 
            var nat = $('#nat' + student).val(); 
            var email = $('#email' + student).val(); 
            var phone = $('#phone' + student).val(); 
            var address = $('#address' + student).val(); 

                $.ajax({
                    type : 'POST',
                    url : '<?php echo route('student/singleupdate'); ?>',
                    data : {student_id : student,user : user, class_id : class_id, section_id : section_id, student_image : student_image, name : name, gender : gender, birthday : birthday,birthday : birthday,region : region,dep_id : dep_id,nat : nat,email : email, phone : phone, address : address, place : place},
                    success : function(response){
                        
                        $(".ajaxForm"+ student).submit(function(e) {
                            form = $(this);
                            ajaxSubmit(e, form, refreshForm);
                        });
                    }
                });
    }
</script>
