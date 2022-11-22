<?php
//$departments = $this->db->order_by("orderh", "asc");
$departments = $this->db->get_where('document_headers', array('session' => active_session("id")))->result_array();
foreach($departments as $department): 
$fs = $department['size'];
$fc = $department['color'];
$bor = $department['border'];
?>

<table style="width : 100%;" style="border-collapse: collapse; font-size:9px">
	<thead>
		
			<tr style=" 
                       <?php if($bor >0){ echo 'border :'.$bor.'px solid black;';}else{ echo 'border : 1px solid white;';}?> <?php if($fs >0){ echo 'font-size:'.$fs;}?> color: <?php echo $fc;?>; text-align:center ">
               <?php if($department['type'] ==1){?>
                    <td><strong>
                        <?php $arr = explode(";",$department['col1']); 
                                 foreach($arr as $val){
                                    echo $val.'<br>';
                                 }?>
                        <?php if (file_exists('uploads/column/col1/'.$department['id'].'.png')){?>
                        <img style="margin-top: -5px; " class="rounded-circle" width="70" height="70" src="<?php echo $this->crud_model->get_col1_image($department['id']); ?>"></strong>
                        <?php } ?>
                    </td>
               <?php } elseif($department['type'] ==2){?>
                    <td>
                        <?php $arr = explode(";",$department['col1']); 
                                 foreach($arr as $val){
                                    echo $val.'<br>';
                                 }?>
                        <?php if (file_exists('uploads/column/col1/'.$department['id'].'.png')){?>
                        <img style="margin-top: -5px; " class="rounded-circle" width="70" height="70" src="<?php echo $this->crud_model->get_col1_image($department['id']); ?>">
                        <?php } ?>
                    </td>
                    <td> 
                        <?php $arr = explode(";",$department['col2']); 
                                 foreach($arr as $val){
                                    echo $val.'<br>';
                                 }?>
                        <?php if (file_exists('uploads/column/col2/'.$department['id'].'.png')){?>
                        <img style="margin-top: -5px; " class="rounded-circle" width="70" height="70" src="<?php echo $this->crud_model->get_col2_image($department['id']); ?>">
                        <?php } ?>
                    </td>
               <?php } elseif($department['type'] ==3){?>
                    <td>
                        <?php $arr = explode(";",$department['col1']); 
                                 foreach($arr as $val){
                                    echo $val.'<br>';
                                 }?>
                        <?php if (file_exists('uploads/column/col1/'.$department['id'].'.png')){?>
                        <img style="margin-top: -5px; " class="rounded-circle" width="70" height="70" src="<?php echo $this->crud_model->get_col1_image($department['id']); ?>">
                        <?php } ?>
                    </td>
                    <td>
                        <?php $arr = explode(";",$department['col2']); 
                                 foreach($arr as $val){
                                    echo $val.'<br>';
                                 }?>
                        <?php if (file_exists('uploads/column/col2/'.$department['id'].'.png')){?>
                        <img style="margin-top: -5px; " class="rounded-circle" width="70" height="70" src="<?php echo $this->crud_model->get_col2_image($department['id']); ?>">
                        <?php } ?>
                    </td>
                    <td>
                        <?php $arr = explode(";",$department['col3']); 
                                 foreach($arr as $val){
                                    echo $val.'<br>';
                                 }?>
                        <?php if (file_exists('uploads/column/col3/'.$department['id'].'.png')){?>
                        <img style="margin-top: -5px; " class="rounded-circle" width="70" height="70" src="<?php echo $this->crud_model->get_col3_image($department['id']); ?>">
                        <?php } ?>
                    </td>
               <?php } elseif($department['type'] ==4){?>
                    <td>
                        <?php $arr = explode(";",$department['col1']); 
                                 foreach($arr as $val){
                                    echo $val.'<br>';
                                 }?>
                        <?php if (file_exists('uploads/column/col1/'.$department['id'].'.png')){?>
                        <img style="margin-top: -5px; " class="rounded-circle" width="70" height="70" src="<?php echo $this->crud_model->get_col1_image($department['id']); ?>">
                        <?php } ?>
                    </td>
                    <td>
                        <?php $arr = explode(";",$department['col2']); 
                                 foreach($arr as $val){
                                    echo $val.'<br>';
                                 }?>
                        <?php if (file_exists('uploads/column/col2/'.$department['id'].'.png')){?>
                        <img style="margin-top: -5px; " class="rounded-circle" width="70" height="70" src="<?php echo $this->crud_model->get_col2_image($department['id']); ?>">
                        <?php } ?>
                    </td>
                    <td>
                        <?php $arr = explode(";",$department['col3']); 
                                 foreach($arr as $val){
                                    echo $val.'<br>';
                                 }?>
                        <?php if (file_exists('uploads/column/col3/'.$department['id'].'.png')){?>
                        <img style="margin-top: -5px; " class="rounded-circle" width="70" height="70" src="<?php echo $this->crud_model->get_col3_image($department['id']); ?>">
                        <?php } ?>
                    </td>
                    <td>
                        <?php $arr = explode(";",$department['col4']); 
                                 foreach($arr as $val){
                                    echo $val.'<br>';
                                 }?>
                        <?php if (file_exists('uploads/column/col4/'.$department['id'].'.png')){?>
                        <img style="margin-top: -5px; " class="rounded-circle" width="70" height="70" src="<?php echo $this->crud_model->get_col4_image($department['id']); ?>">
                        <?php } ?>
                    </td>
               <?php } ?>
			</tr> 
		
	</thead>
</table>
<?php endforeach; ?>