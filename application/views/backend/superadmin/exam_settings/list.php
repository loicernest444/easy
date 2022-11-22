<?php
$n = get_settings('multiple_school');
$classes = $this->db->get_where('exams', array('session' => active_session("id")))->result_array();
if (count($classes) > 0): ?>
<table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
    <thead>
        <tr style="background-color: #313a46; color: #ababab;">
            <th><?php echo get_phrase('division'); ?></th>
            <th><?php echo get_phrase('exams'); ?></th>
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
                    <small class="form-text text-muted"><?php echo $class['short_name_fr'].' - '.$class['name_fr']; ?></small><br>
                    <?php echo date('D, d-M-Y', strtotime($exam['starting_date'])).' '.get_phrase('to').' '.date('d M-Y', strtotime($exam['ending_date'])); ?>
                </td>
                <td>
                        <?php
                        $sections = $this->db->get_where('exam_option', array('exam_id' => $class['id']))->result_array();
                        foreach($sections as $section){
                            echo $section['short_name'].' - '.$section['name'].'<br><small class="form-text text-muted">'.$section['short_name_fr'].' - '.$section['name_fr'].'</small>';
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
                            <a href="javascript:void(0);" class="dropdown-item" onclick="rightModal('<?php echo site_url('modal/popup/exam_settings/sections/'.$class['id'])?>', '<?php echo get_phrase('exams'); ?>');"><?php echo get_phrase('exams'); ?></a>
                           
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item" onclick="rightModal('<?php echo site_url('modal/popup/exam_settings/edit/'.$class['id'])?>', '<?php echo get_phrase('update_year_division'); ?>');"><?php echo get_phrase('edit'); ?></a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('exam/delete/'.$class['id']); ?>', showAllClasses)"><?php echo get_phrase('delete'); ?></a>
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
