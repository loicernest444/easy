<?php
//$school_id = school_id();
//$n = $this->crud_model->get_schools()->num_rows();
$classes = $this->db->get_where('schools')->result_array();
if (count($classes) > 0): ?>
<table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
    <thead>
        <tr style="background-color: #313a46; color: #ababab;">
            <th><?php echo get_phrase('logo'); ?></th>
            <th><?php echo get_phrase('name'); ?></th>
            <th><?php echo get_phrase('divisions'); ?></th>
            <th><?php echo get_phrase('address'); ?></th>
            <th><?php echo get_phrase('contacts'); ?></th>
        
            <th>...</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($classes as $class): ?>
            <tr>
                <td>
                  <img class="rounded-circle" width="30" height="30" src="<?php echo $this->user_model->get_school_image($class['id']); ?>">
                </td>
                <td><?php echo $class['name'].' / '.$class['name_fr']; ?></td>
                <td>
                    <ul>
                        <?php
                        $sections = $this->db->get_where('divisions', array('school_id' => $class['id']))->result_array();
                        foreach($sections as $section){?>
                            <li><?php echo $section['short_name'].' - '.$section['name']; ?> / <?php echo $section['short_name_fr'].' - '.$section['name_fr']; ?>
                                <a href="javascript:void(0);" onclick="rightModal('<?php echo site_url('modal/popup/school/options/'.$section['id'])?>', '<?php echo get_phrase('update_division_options'); ?>');"><i class="mdi mdi-pencil-box title_icon"></i></a><br>
                                <?php $sect = $this->db->get_where('division_option', array('division_id' => $section['id']))->result_array();
                                foreach($sect as $sect){?>  
                                  <i class="mdi mdi-hand-pointing-right"></i><?php echo $sect['short_name'].' - '.$sect['name']; ?> / <?php echo $sect['short_name_fr'].' - '.$sect['name_fr']; ?>
                                <a href="javascript:void(0);" onclick="confirmModal('<?php echo route('manage_school/delete_option/'.$sect['id']); ?>', showAllClasses)"><i class="mdi mdi-close-circle" style="color:red;"></i></a><br> 
                                <?php }?>
                            </li>
                        <?php }
                        ?>
                    </ul> 
                </td>
                <td><?php echo $class['address']; ?></td>
                <td>
                    <?php echo $class['phone']; ?><br>
                    <?php echo $class['email']; ?>
                </td>
                <td>
                    <div class="dropdown text-center">
                        <button type="button" class="btn btn-sm btn-icon btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- item-->
                            <?php if($class['use_divisions'] > 0) {?>
                            <a href="javascript:void(0);" class="dropdown-item" onclick="rightModal('<?php echo site_url('modal/popup/school/divisions/'.$class['id'])?>', '<?php echo get_phrase('divisions'); ?>');"><?php echo get_phrase('divisions'); ?></a>
                            <?php } ?>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item" onclick="rightModal('<?php echo site_url('modal/popup/school/edit/'.$class['id'])?>', '<?php echo get_phrase('update_school'); ?>');"><?php echo get_phrase('edit'); ?></a>
                            <!-- item-->
                            <!-- unable the deletion of the first school-->
                            <?php if ($class['id'] > 1){?>
                            <a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('manage_school/delete/'.$class['id']); ?>', showAllClasses)"><?php echo get_phrase('delete'); ?></a>
                            <?php } ?>
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
