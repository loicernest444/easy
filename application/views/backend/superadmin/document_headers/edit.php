<?php $departments = $this->db->get_where('document_headers', array('id' => $param1))->result_array(); ?>
<?php foreach($departments as $dep){ ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('document_headers/update/'.$param1); ?>">
    
    <div class="form-row">
        <?php 
                $n = $this->crud_model->get_schools()->num_rows();
                if ($n > 1){
        ?>
        <div class="col-md-12">
            <label for="name"><?php echo get_phrase('choose_school'); ?></label>
            <select name="school" id="school" class="form-control select2" data-toggle = "select2" required>
                <option value=""><?php echo get_phrase('choose_school'); ?></option>
                <?php
                $schools = $this->crud_model->get_schools()->result_array();
                foreach ($schools as $school): ?>
                <option value="<?php echo $school['id']; ?>"<?php if($dep['school_id'] == $school['id']){?> selected <?php } ?>><?php echo $school['name'].' / '.$school['name_fr']; ?></option>
              <?php endforeach; ?>
            </select>
            <small id="" class="form-text text-muted"><?php echo get_phrase('choose_school'); ?> ?</small>
        </div>
        <?php } else{?> 
        <input type="hidden" name="school_id" value="<?php echo school_id(); ?>">
        <?php } ?>
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('title'); ?></label>
            <input type="text" class="form-control" id="name" value="<?php echo $dep['title']; ?>" name = "name" required>
            <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_line_title'); ?></small>
        </div>
         <div class="col-md-6">
            <label for="type"><?php echo get_phrase('color'); ?></label>
            <select name="color" id="co" class="form-control select2" data-toggle = "select2" >
                <option value="black"<?php if($dep['color'] == 'black'){?> selected <?php } ?>><?php echo get_phrase('black'); ?></option>
                <option value="red"<?php if($dep['color'] == 'red'){?> selected <?php } ?>><?php echo get_phrase('red'); ?></option>
                <option value="blue"<?php if($dep['color'] == 'blue'){?> selected <?php } ?>><?php echo get_phrase('blue'); ?></option>
                <option value="green"<?php if($dep['color'] == 'green'){?> selected <?php } ?>><?php echo get_phrase('green'); ?></option>
            </select>
            <small id="" class="form-text text-muted"><?php echo get_phrase('choose_text_color'); ?> ?</small>
        </div> 
        <div class="col-md-6">
            <label for="bo"><?php echo get_phrase('font_size'); ?></label>
            <input type="number" class="form-control" id="size"  value="<?php echo $dep['size']; ?>"  name = "size" min="0" step="1">
            <small id="" class="form-text text-muted"><?php echo get_phrase('font_size'); ?> ?</small>
        </div> 
        <div class="col-md-6">
            <label for="type"><?php echo get_phrase('type'); ?></label>
            <select name="type" id="type" class="form-control select2" data-toggle = "select2" required onchange="get_form_val(this.value)">
                <option value="1"<?php if($dep['type'] == 1){?> selected <?php } ?>><?php echo get_phrase('one_line'); ?></option>
                <option value="2"<?php if($dep['type'] == 2){?> selected <?php } ?>><?php echo get_phrase('two_columns'); ?></option>
                <option value="3"<?php if($dep['type'] == 3){?> selected <?php } ?>><?php echo get_phrase('three_columns'); ?></option>
                <option value="4"<?php if($dep['type'] == 4){?> selected <?php } ?>><?php echo get_phrase('four_columns'); ?></option>
                 
            </select>
            <small id="" class="form-text text-muted"><?php echo get_phrase('choose_number_of_column'); ?> ?</small>
        </div>
        <div class="col-md-6">
            <label for="bo"><?php echo get_phrase('border'); ?></label>
            <input type="number" class="form-control" id="border" value="<?php echo $dep['border']; ?>"  name = "border"  min="0" step="1">
            <small id="" class="form-text text-muted"><?php echo get_phrase('border'); ?> ?</small>
        </div> 
        <div class="col-md-12">
            <label for="type"><?php echo get_phrase('order_of_display'); ?></label>
            <input type="number" class="form-control" id="order" name = "order" value="<?php echo $dep['orderh']; ?>" required>
            <small id="" class="form-text text-muted"><?php echo get_phrase('choose_order_to_display'); ?> ?</small>
        </div><br>
        <div class="form-group col-md-12" id="u">
        <table width="100%">
                <thead>
                    <tr style="background-color: #313a46; color: #fff;">
                        <th style="text-align:center;"> </th>
                    </tr>
                </thead>
            </table>
        <div class="col-md-12">
        <label class="form-label" for="example-textarea"><?php echo get_phrase('first_column_text'); ?></label>
            <textarea class="form-control" id="example-textarea" rows="2" name = "col1" placeholder="<?php echo get_phrase('first_column_text'); ?>"><?php echo $dep['col1']; ?> </textarea>
            <small id="" class="form-text text-muted"><?php echo get_phrase('if_you_want_to_go_to_the_line_put_a_semicolon_'); ?> :'<strong> ; </strong>'</small>
        </div>
        <div class="col-md-12">
            <label for="col"><?php echo get_phrase('upload_picture'); ?></label>
            <div class="custom-file-upload">
                <input type="file" class="form-control" id="col1p" name = "col1p">
            </div>
        </div>   
        </div>
        <div class="form-group col-md-12" id="d" <?php if($dep['type'] < 2){?> style="display:none;" <?php } ?> >
        <table width="100%">
                <thead>
                    <tr style="background-color: #313a46; color: #fff;">
                        <th style="text-align:center;"> </th>
                    </tr>
                </thead>
            </table>
        <div class="col-md-12">
        <label class="form-label" for="example-textarea"><?php echo get_phrase('second_column_text'); ?></label>
            <textarea class="form-control" id="example-textarea" rows="2" name = "col2" placeholder="<?php echo get_phrase('second_column_text'); ?>"><?php echo $dep['col2']; ?></textarea>
            <small id="" class="form-text text-muted"><?php echo get_phrase('if_you_want_to_go_to_the_line_put_a_semicolon_'); ?> :'<strong> ; </strong>'</small>
        </div>
        <div class="col-md-12">
            <label for="col"><?php echo get_phrase('upload_picture'); ?></label>
            <div class="custom-file-upload">
                <input type="file" class="form-control" id="col2p" name = "col2p">
            </div>
        </div>   
        </div>
        <div class="form-group col-md-12" id="t" <?php if($dep['type'] < 3){?> style="display:none;" <?php } ?>>
        <table width="100%">
                <thead>
                    <tr style="background-color: #313a46; color: #fff;">
                        <th style="text-align:center;"> </th>
                    </tr>
                </thead>
            </table>
        <div class="col-md-12">
        <label class="form-label" for="example-textarea"><?php echo get_phrase('third_column_text'); ?></label>
            <textarea class="form-control" id="example-textarea" rows="2" name = "col3" placeholder="<?php echo get_phrase('third_column_text'); ?>"><?php echo $dep['col3']; ?></textarea>
            <small id="" class="form-text text-muted"><?php echo get_phrase('if_you_want_to_go_to_the_line_put_a_semicolon_'); ?> :'<strong> ; </strong>'</small>
        </div>
        <div class="col-md-12">
            <label for="col"><?php echo get_phrase('upload_picture'); ?></label>
            <div class="custom-file-upload">
                <input type="file" class="form-control" id="col3p" name = "col3p">
            </div>
        </div>   
        </div>
        <div class="form-group col-md-12" id="q" <?php if($dep['type'] < 4){?> style="display:none;" <?php } ?>>
        <table width="100%">
                <thead>
                    <tr style="background-color: #313a46; color: #fff;">
                        <th style="text-align:center;"> </th>
                    </tr>
                </thead>
            </table>
        <div class="col-md-12">
        <label class="form-label" for="example-textarea"><?php echo get_phrase('fourth_column_text'); ?></label>
            <textarea class="form-control" id="example-textarea" rows="2" name = "col4" placeholder="<?php echo get_phrase('fourth_column_text'); ?>"><?php echo $dep['col4']; ?></textarea>
            <small id="" class="form-text text-muted"><?php echo get_phrase('if_you_want_to_go_to_the_line_put_a_semicolon_'); ?> :'<strong> ; </strong>'</small>
        </div>
        <div class="col-md-12">
            <label for="col"><?php echo get_phrase('upload_picture'); ?></label>
            <div class="custom-file-upload">
                <input type="file" class="form-control" id="col4p" name = "col4p">
            </div>
        </div>   
        </div>

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_header_line'); ?></button>
        </div>
    </div>
</form>
<?php } ?>

<script>
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllDepartments);
});
    $(document).ready(function() {
    initSelect2(['#type', '#co', '#school']);
});
</script>
<script type="text/javascript">

    function get_form_val(u) {
        decision = $("#type").val();
        
        if(decision == '1'){
            $("#u").show();
            $("#d").hide();
            $("#t").hide();
            $("#q").hide();
        }
        else if(decision == '2'){
            $("#u").show();
            $("#d").show();
            $("#t").hide();
            $("#q").hide();
        }
        else if(decision == '3'){
            $("#t").show();
            $("#d").show();
            $("#u").show();
            $("#q").hide();
        }
        else if(decision == '4'){
            $("#q").show();
            $("#t").show();
            $("#d").show();
            $("#u").show();
        }
    }
            
</script>