<form method="POST" class="d-block ajaxForm" action="<?php echo route('grade/create'); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="grade"><?php echo get_phrase('grade_name'); ?></label>
            <input type="text" class="form-control" id="grade" name = "grade" placeholder="<?php echo get_phrase('grade_name'); ?>" required>
        </div>

        <div class="form-group col-md-12">
            <label for="gradesn"><?php echo get_phrase('grade_short_name'); ?></label>
            <input type="text" class="form-control" id="gradesn" name = "gradesn" placeholder="<?php echo get_phrase('grade_short_name'); ?>" required>
        </div>
        
        <div class="form-group col-md-12">
            <label for="grade"><?php echo get_phrase('grade_name'); ?> Fr</label>
            <input type="text" class="form-control" id="gradef" name = "gradef" placeholder="<?php echo get_phrase('grade_name'); ?>" required>
        </div>

        <div class="form-group col-md-12">
            <label for="gradesn"><?php echo get_phrase('grade_short_name'); ?> Fr</label>
            <input type="text" class="form-control" id="gradesnf" name = "gradesnf" placeholder="<?php echo get_phrase('grade_short_name'); ?>" required>
        </div>

        <div class="form-group col-md-6">
            <label for="mark_from"><?php echo get_phrase('mark_from'); ?></label>
            <input type="number" class="form-control" id="mark_from" name = "mark_from" placeholder="<?php echo get_phrase('mark_from'); ?>" required>
        </div>

        <div class="form-group col-md-6">
            <label for="mark_upto"><?php echo get_phrase('mark_upto'); ?></label>
            <input type="number" class="form-control" id="mark_upto" name = "mark_upto" placeholder="<?php echo get_phrase('mark_upto'); ?>" required>
        </div>


        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('create_grade'); ?></button>
        </div>
    </div>
</form>

<script>
    $(".ajaxForm").validate({}); // Jquery form validation initialization
    $(".ajaxForm").submit(function(e) {
        var form = $(this);
        ajaxSubmit(e, form, showAllGrades);
    });
</script>
