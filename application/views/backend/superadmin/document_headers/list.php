<?php
//$departments = $this->db->order_by("orderh", "asc");
$departments = $this->db->get_where('document_headers', array('session' => active_session("id")))->result_array();
if (count($departments) > 0): ?>
<?php foreach($departments as $department): ?>
<?php
    if($department['type'] ==1){
        $n=1;
    }else if($department['type'] ==2){  
        $n=2;
    }else if($department['type'] ==3){
        $n=3;
    }else if($department['type'] ==4){
        $n=4;
    } $m=$n+1;
?>
<table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
	<thead>
		<tr style="background-color: #313a46; color: #ababab;">
			<th colspan="<?php echo $m;?>"><?php echo $department['title']; ?></th>
			
		</tr>
	</thead>
	<tbody>
		
			<tr>
               <?php if($department['type'] ==1){?>
                    <td>
                        <?php $arr = explode(";",$department['col1']); 
                                 foreach($arr as $val){
                                    echo $val.'<br>';
                                 }?>
                        <?php if (file_exists('uploads/column/col1/'.$department['id'].'.png')){?>
                        <img class="rounded-circle" width="100" height="100" src="<?php echo $this->crud_model->get_col1_image($department['id']); ?>">
                        <?php } ?>
                    </td>
               <?php } elseif($department['type'] ==2){?>
                    <td>
                        <?php $arr = explode(";",$department['col1']); 
                                 foreach($arr as $val){
                                    echo $val.'<br>';
                                 }?>
                        <?php if (file_exists('uploads/column/col1/'.$department['id'].'.png')){?>
                        <img class="rounded-circle" width="100" height="100" src="<?php echo $this->crud_model->get_col1_image($department['id']); ?>">
                        <?php } ?>
                    </td>
                    <td>
                        <?php $arr = explode(";",$department['col2']); 
                                 foreach($arr as $val){
                                    echo $val.'<br>';
                                 }?>
                        <?php if (file_exists('uploads/column/col2/'.$department['id'].'.png')){?>
                        <img class="rounded-circle" width="100" height="100" src="<?php echo $this->crud_model->get_col2_image($department['id']); ?>">
                        <?php } ?>
                    </td>
               <?php } elseif($department['type'] ==3){?>
                    <td>
                        <?php $arr = explode(";",$department['col1']); 
                                 foreach($arr as $val){
                                    echo $val.'<br>';
                                 }?>
                        <?php if (file_exists('uploads/column/col1/'.$department['id'].'.png')){?>
                        <img class="rounded-circle" width="100" height="100" src="<?php echo $this->crud_model->get_col1_image($department['id']); ?>">
                        <?php } ?>
                    </td>
                    <td>
                        <?php $arr = explode(";",$department['col2']); 
                                 foreach($arr as $val){
                                    echo $val.'<br>';
                                 }?>
                        <?php if (file_exists('uploads/column/col2/'.$department['id'].'.png')){?>
                        <img class="rounded-circle" width="100" height="100" src="<?php echo $this->crud_model->get_col2_image($department['id']); ?>">
                        <?php } ?>
                    </td>
                    <td>
                        <?php $arr = explode(";",$department['col3']); 
                                 foreach($arr as $val){
                                    echo $val.'<br>';
                                 }?>
                        <?php if (file_exists('uploads/column/col3/'.$department['id'].'.png')){?>
                        <img class="rounded-circle" width="100" height="100" src="<?php echo $this->crud_model->get_col3_image($department['id']); ?>">
                        <?php } ?>
                    </td>
               <?php } elseif($department['type'] ==4){?>
                    <td>
                        <?php $arr = explode(";",$department['col1']); 
                                 foreach($arr as $val){
                                    echo $val.'<br>';
                                 }?>
                        <?php if (file_exists('uploads/column/col1/'.$department['id'].'.png')){?>
                        <img class="rounded-circle" width="100" height="100" src="<?php echo $this->crud_model->get_col1_image($department['id']); ?>">
                        <?php } ?>
                    </td>
                    <td>
                        <?php $arr = explode(";",$department['col2']); 
                                 foreach($arr as $val){
                                    echo $val.'<br>';
                                 }?>
                        <?php if (file_exists('uploads/column/col2/'.$department['id'].'.png')){?>
                        <img class="rounded-circle" width="100" height="100" src="<?php echo $this->crud_model->get_col2_image($department['id']); ?>">
                        <?php } ?>
                    </td>
                    <td>
                        <?php $arr = explode(";",$department['col3']); 
                                 foreach($arr as $val){
                                    echo $val.'<br>';
                                 }?>
                        <?php if (file_exists('uploads/column/col3/'.$department['id'].'.png')){?>
                        <img class="rounded-circle" width="100" height="100" src="<?php echo $this->crud_model->get_col3_image($department['id']); ?>">
                        <?php } ?>
                    </td>
                    <td>
                        <?php $arr = explode(";",$department['col4']); 
                                 foreach($arr as $val){
                                    echo $val.'<br>';
                                 }?>
                        <?php if (file_exists('uploads/column/col4/'.$department['id'].'.png')){?>
                        <img class="rounded-circle" width="100" height="100" src="<?php echo $this->crud_model->get_col4_image($department['id']); ?>">
                        <?php } ?>
                    </td>
               <?php } ?>
                <td>
                    <div class="dropdown text-center">
						<button type="button" class="btn btn-sm btn-icon btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
						<div class="dropdown-menu dropdown-menu-right">
							<!-- item-->
							<a href="javascript:void(0);" class="dropdown-item" onclick="rightModal('<?php echo site_url('modal/popup/document_headers/edit/'.$department['id'])?>', '<?php echo get_phrase('update_header_line'); ?>');"><?php echo get_phrase('edit'); ?></a>
							<!-- item-->
							<a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('document_headers/delete/'.$department['id']); ?>', showAllDepartments)"><?php echo get_phrase('delete'); ?></a>
						</div>
					</div>
                </td>
			</tr> 
		
	</tbody>
</table>
<?php endforeach; ?>
<?php else: ?>
	<?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>
 