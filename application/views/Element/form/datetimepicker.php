<?php
$defaults = [
    'type'  => 'text',
    'name'  => $this->fetch('name'),
    'class' => 'form-control js-datetimepicker flatpickr-input',
    'id'    => $this->fetch('name'),
    'placeholder' => lang('general_label_datetimepicker_format'),
];
$defaults['value'] = set_value($this->fetch('name'), $this->fetch('default_value'), false);
$extra = ($this->fetch('extra')?:[]);
$defaults = $extra + $defaults;
if (($error = form_error($this->fetch('name'), '<div class="form-control-feedback"><i class="material-icons">warning</i> ', '</div>'))) {
    $defaults['class'] .= ' form-control-danger';
}
$this->asset->enqueueStyle('flatpickr.css');
$this->asset->enqueueScript('locales.js');
?>
<input <?= _attributes_to_string($defaults) ?> />
<?=  $error ?>
