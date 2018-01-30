<?php
$defaults = [
    'type'  => 'text',
    'name'  => $this->fetch('name'),
    'class' => 'form-control',
    'id'    => preg_replace('/[^A-Za-z0-9\_\-]/', '_', $this->fetch('name')),
];
$defaults['value'] = set_value($this->fetch('name'), $this->fetch('default_value'), false);
$extra = ($this->fetch('extra')?:[]);
$defaults = $extra + $defaults;
if ($defaults['type'] === 'password') {
    $defaults['value'] = '';
}
if (($error = form_error($this->fetch('name'), '<div class="invalid-feedback"><i class="material-icons">warning</i> ', '</div>'))) {
    $defaults['class'] .= ' is-invalid';
}
?>
<input <?= _attributes_to_string($defaults) ?> />
<?=  $error ?>
