<?php
$defaults = [
    'type'  => 'text',
    'name'  => $this->fetch('name'),
    'class' => 'form-control',
    'id'    => preg_replace('/[^A-Za-z0-9\_\-]/', '_', $this->fetch('name')),
];
$value = set_value($this->fetch('name'), $this->fetch('default_value'));
$extra = ($this->fetch('extra')?:[]);
$defaults = $extra + $defaults;
if (form_error($this->fetch('name'))) {
    $defaults['class'] .= ' is-invalid';
}
?>
<textarea <?= _attributes_to_string($defaults) ?>><?= $value ?></textarea>
<?= form_error($this->fetch('name'), '<div class="invalid-feedback"><i class="material-icons">warning</i> ', '</div>') ?>
