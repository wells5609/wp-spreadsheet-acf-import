<h2>Error logs</h2>

<pre><?php
foreach ($validations as $row => $validation) {
  print("Row $row had the following invalid fields: ");

  $names = array();

  foreach ($validation as $field) {
    $names[] = $field['name'];
  }

  print(implode(', ', $names) . "\n");
}

foreach ($uniques as $unique) {
  print(
      "Row {$unique['realrow']} did not pass the unique test. "
    . "Possible duplicate.\n"
  );
}
?></pre>
