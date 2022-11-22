<?php
//$school_id = school_id();
//$n = $this->crud_model->get_schools()->num_rows();
$id = active_session("id"); 
$classes = $this->db->get_where('fees', array('session' => $id))->result_array();
if (count($classes) > 0): ?>
<table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
    <thead>
        <tr style="background-color: #313a46; color: #ababab;">
            <th><?php echo get_phrase('name'); ?><?php echo active_session("id"); ?></th>
            <th><?php echo get_phrase('description'); ?></th>
            <th><?php echo get_phrase('type'); ?></th>
            <th><?php echo get_phrase('exigibility'); ?></th>
            <th>...</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($classes as $class): ?>
            <tr>
                <td><?php echo $class['short_name'].' - '.$class['name']; ?></td>
                <td><?php echo $class['description']; ?></td>
                <td><?php echo get_phrase($class['type']); ?></td>
                <td><?php echo get_phrase($class['exigibility']); ?></td>
                <td>
                    <div class="dropdown text-center">
                        <button type="button" class="btn btn-sm btn-icon btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item" onclick="rightModal('<?php echo site_url('modal/popup/fees/edit/'.$class['id'])?>', '<?php echo get_phrase('update_school_fees'); ?>');"><?php echo get_phrase('edit'); ?></a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('fees/delete/'.$class['id']); ?>', showAllClasses)"><?php echo get_phrase('delete'); ?></a>
                            
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
