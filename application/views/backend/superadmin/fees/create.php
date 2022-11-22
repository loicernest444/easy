<form method="POST" class="d-block ajaxForm" action="<?php echo route('fees/create'); ?>">
    <div class="form-row">
       
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('name'); ?></label>
            <input type="text" class="form-control" id="name" name = "name" required>
            <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_name'); ?></small>
        </div>
        <div class="form-group col-md-12">
            <label for="sname"><?php echo get_phrase('short_name'); ?></label>
            <input type="text" class="form-control" id="sname" name = "sname" required>
            <small id="sname_help" class="form-text text-muted"><?php echo get_phrase('provide_short_name'); ?></small>
        </div>
        <div class="form-group col-md-12">
            <label for="u"><?php echo get_phrase('fees_type'); ?> </label>
            <select name="type" id="u" class="form-control select2" data-toggle = "select2">
                <option value="mandatory"><?php echo get_phrase('mandatory'); ?></option>
                <option value="optional"><?php echo get_phrase('optional'); ?></option>
            </select>
            <small id="" class="form-text text-muted"><?php echo get_phrase('fees_type'); ?> ?</small>
        </div>
        <div class="form-group col-md-12">
            <label for="u1"><?php echo get_phrase('exigibility'); ?> </label>
            <select name="exigibility" id="u1" class="form-control select2" data-toggle = "select2">
                <option value="all_registration"><?php echo get_phrase('all_at_registration'); ?></option>
                <option value="anytime"><?php echo get_phrase('anytime'); ?></option>
            </select>
            <small id="" class="form-text text-muted"><?php echo get_phrase('exigibility_time_of_fees'); ?> ?</small>
        </div>
        <div class="form-group col-md-12">
        <label for="u2"><?php echo get_phrase('school_year'); ?> </label>
                <select name="session" class="form-control select2" data-toggle="select2" id = "u2">
                    <option value = ""><?php echo get_phrase('select_a_session'); ?></option>
                    <?php $sessions = $this->db->get('sessions')->result_array();
                    foreach($sessions as $session):?>
                    <option value="<?php echo $session['id']; ?>" <?php if($session['status'] == 1)echo 'selected'; ?>><?php echo $session['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group col-md-12">
            <label for="ad"><?php echo get_phrase('description'); ?></label>
            <textarea class="form-control" id="ad" name = "description" rows="3"></textarea>
            <small id="sname_help" class="form-text text-muted"><?php echo get_phrase('provide_fees_description'); ?></small>
        </div>
        
        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('create_fees'); ?></button>
        </div>
    </div>
</form>

<script>

var blank_section_field = $('#blank_section').html();

$(document).ready(function() {
    $('#blank_section').hide();
    initSelect2(['#u','#u1', '#u2', '#school']);
});
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllClasses);
});

function appendSection() {
    $('#section_area').append(blank_section_field);
}

function removeSection(elem) {
    $(elem).closest('.form-row').remove();
}

</script>

