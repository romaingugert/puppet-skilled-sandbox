<?php
$defaults = [
    'name'  => $this->fetch('name'),
    'class' => 'form-control-plaintext',
    'id'    => preg_replace('/[^A-Za-z0-9\_\-]/', '_', $this->fetch('name')),
];
$extra = ($this->fetch('extra')?:[]);
$defaults = $extra + $defaults;

$value = $this->fetch('default_value');
if ($value instanceof Carbon\Carbon) {
    $value = user_date_format($value);
}
?>
<p <?= _attributes_to_string($defaults) ?> ><?= html_escape($value) ?></p>
