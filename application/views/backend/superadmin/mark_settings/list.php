<?php
$n = get_settings('multiple_school');
$classes = $this->db->get_where('mark_behavior', array('session' => active_session("id")))->result_array();
if (count($classes) > 0): ?>
<table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
    <thead>
        <tr style="background-color: #313a46; color: #ababab;">
            <th><?php echo get_phrase('name'); ?></th>
            <th><?php echo get_phrase('behaviors'); ?></th>
            <?php if ($n > 0){?>
            <th><?php echo get_phrase('school'); ?></th>
            <?php } ?>
            <th style="text-align : center;">...</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($classes as $class): ?>
            <tr>
                <td>
                    <?php echo $class['short_name'].' - '.$class['name']; ?><br>
                    <small class="form-text text-muted"><?php echo $class['short_name_fr'].' - '.$class['name_fr']; ?></small>
                </td>
                <td>
                    
                        <?php
                        $sections = $this->db->get_where('mark_behavior_option', array('mark_behavior_id' => $class['id']))->result_array();
                        foreach($sections as $section){
                            echo $section['name_fr'].'-'.$section['name'].' : '.$section['percentage'].'%<br>';
                        }
                        ?>
                    
                </td>
                <?php if ($n > 0){ ?>
                <td>
                    <?php 
                        $sn = $this->db->get_where('schools', array('id' => $class['school_id']))->row()->name;
                        $us = $this->db->get_where('schools', array('id' => $class['school_id']))->row()->use_divisions;
                        $dn = $this->db->get_where('divisions', array('id' => $class['division_id']))->row()->short_name;
                        if($us > 0 ){
                            echo '<strong>'.$sn.' - '.'('.$dn.')';
                        }else{
                            echo '<strong>'.$sn; 
                        }
                    ?>
                </td>
                <?php } ?>
                <td>
                    <div class="dropdown text-center">
                        <button type="button" class="btn btn-sm btn-icon btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item" onclick="rightModal('<?php echo site_url('modal/popup/mark_settings/sections/'.$class['id'])?>', '<?php echo get_phrase('behaviors'); ?>');"><?php echo get_phrase('behaviors'); ?></a>
                           
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item" onclick="rightModal('<?php echo site_url('modal/popup/mark_settings/edit/'.$class['id'])?>', '<?php echo get_phrase('update_mark_behavior'); ?>');"><?php echo get_phrase('edit'); ?></a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('mark_settings/delete/'.$class['id']); ?>', showAllClasses)"><?php echo get_phrase('delete'); ?></a>
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
