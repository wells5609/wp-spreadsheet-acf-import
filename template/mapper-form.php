<?php var_dump($fields); ?>

<form
  id="csvaf-mapper"
  method="POST"
  enctype="multipart/form-data"
  action="<?php echo $action; ?>"
>
  <input
    type="hidden"
    name="<?php echo $noncekey ?>"
    value="<?php echo $noncevalue ?>"
  />
  <input
    type="hidden"
    name="csvaf_filename"
    value="<?php echo htmlentities($filename); ?>"
  />

  <script type="text/javascript">
    var CSVAFFIELDS = (<?php echo json_encode($fields); ?>)
    var CSVAFTYPES  = (<?php echo json_encode(array_keys($posttypes)); ?>)
  </script>
  <script
    type="text/javascript"
    src="<?php echo CSVAFURL . 'scripts/mapper.js'; ?>">
  </script>

  <ul>
    <?php foreach ($headers as $column => $header): ?>
      <?php
      $idprefix = 'csvaf_column_' . $column . '_';
      $lookup   = false;
      $format   = false;
      ?>
    <li>
      <label for="<?php echo $idprefix; ?>field">
        <strong><?php echo $column; ?></strong>: <?php echo $header; ?>
      </label>
      <select name="<?php echo $idprefix; ?>field">
        <option value="" selected="selected">DO NOT INSERT</option>
        <?php foreach ($fields as $field): ?>
        <option value="<?php echo $field['key']; ?>">
          <?php echo $field['name']; ?>
        </option>
        <?php endforeach; ?>
      </select>

      <div class="optional-wrap"></div>

      <label for="<?php echo $idprefix; ?>default">
        <?php _e('Default:', 'csvaf'); ?>
      </label>
      <input
        type="text"
        name="<?php echo $idprefix; ?>default"
        value="<?php echo ($field['default'] ? $fields['default'] : ''); ?>"
      />
    </li>
    <?php endforeach; ?>
  </ul>

  <input type="submit" name="submit" value="Upload" />
</form>
