<?php
$school_id = school_id();
$n = $this->crud_model->get_schools()->num_rows();
$classes = $this->db->get_where('classes')->result_array();
if (count($classes) > 0): ?>
<table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
    <thead>
        <tr style="background-color: #313a46; color: #ababab;">
            <th>#</th>
            <th><?php echo get_phrase('name'); ?></th>
            <th><?php echo get_phrase('section'); ?></th>
            <th><?php echo get_phrase('school'); ?></th>
            <th style="text-align : center;">...</th>
        </tr>
    </thead>
    <tbody>
        <?php $c=1;foreach($classes as $class): ?>
            <tr>
                <td><?php echo $c++; ?></td>
                <td><?php echo $class['short_name'].' - '.$class['name']; ?></td>
                <td>
                    <?php
                        if ($class['use_sections'] > 0 ){ ?>
                    
                        <?php
                        $sections = $this->db->get_where('sections', array('class_id' => $class['id']))->result_array();
                        foreach($sections as $section){
                        $on = $this->db->get_where('division_option', array('id' => $section['option_id']))->row()->name;
                        $onf = $this->db->get_where('division_option', array('id' => $section['option_id']))->row()->name_fr;
                        $dn = $this->db->get_where('divisions', array('id' => $section['division_id']))->row()->name;
                        $dnf = $this->db->get_where('divisions', array('id' => $section['division_id']))->row()->name_fr;?>
                            <i class="mdi mdi-arrow-right-bold-circle"></i><?php echo $section['name'].'/ '.$section['name_fr']; ?><a href="javascript:void(0);" onclick="confirmModal('<?php echo route('manage_class/delete_option/'.$section['id']); ?>', showAllClasses)"><i class="mdi mdi-close-circle" style="color:red;"></i></a>
                            <?php if($section['option_id'] > 0){ echo '<br><em><small class="form-text text-muted">'.get_phrase('option').' : '.$on.' / '.$onf.'</small></em>'; }?>
                            <?php if($section['division_id'] > 0){ echo '<br><em><small class="form-text text-muted">'.get_phrase('division').' : '.$dn.' / '.$dnf.'</small></em>'; }?>
                        <?php }
                        ?>
                    <?php } else {?> - <?php } ?>
                </td>
                <?php //if ($n > 1){ ?>
                <td>
                    <?php 
                        $sn = $this->db->get_where('schools', array('id' => $class['school_id']))->row()->name;
                        $us = $this->db->get_where('schools', array('id' => $class['school_id']))->row()->use_divisions;
                        $dn = $this->db->get_where('divisions', array('id' => $class['division_id']))->row()->short_name;
                        if($us > 0 ){
                            echo '<strong>'.$dn.' - '.$sn;
                        }else{
                            echo '<strong>'.$sn; 
                        }
                    ?>
                </td>
                <?php //} ?>
                <td>
                    <div class="dropdown text-center">
                        <button type="button" class="btn btn-sm btn-icon btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- item-->
                            <?php if($class['use_sections'] > 0) {?>
                            <a href="javascript:void(0);" class="dropdown-item" onclick="rightModal('<?php echo site_url('modal/popup/class/sections/'.$class['id'])?>', '<?php echo get_phrase('sections'); ?>');"><?php echo get_phrase('sections'); ?></a>
                            <?php } ?>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item" onclick="rightModal('<?php echo site_url('modal/popup/class/edit/'.$class['id'])?>', '<?php echo get_phrase('update_class'); ?>');"><?php echo get_phrase('edit'); ?></a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('manage_class/delete/'.$class['id']); ?>', showAllClasses)"><?php echo get_phrase('delete'); ?></a>
                        </div>
                    </div>
                </td>
            </tr> 
        <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
    <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>
