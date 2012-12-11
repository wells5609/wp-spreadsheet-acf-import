<div class="wrap">
  <form
    id="csvaf-upload"
    method="POST"
    enctype="multipart/form-data"
    action="<?php echo $action; ?>"
  >
    <input
      type="hidden"
      name="<?php echo $noncekey ?>"
      value="<?php echo $noncevalue ?>"
    />
    <label for="csvaf_data">
      <?php _e('Select spreadsheet file:', 'csvaf'); ?>
    </label>
    <input type="file" name="csvaf_data" />
    <input type="submit" name="submit" value="Upload" />
  </form>
</div>
