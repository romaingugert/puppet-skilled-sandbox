<?php
$defaults = [
    'name'  => $this->fetch('name'),
    'class' => 'form-control',
    'id'    => preg_replace('/[^A-Za-z0-9\_\-]/', '_', $this->fetch('name')),
];
$defaults['value'] = set_value($this->fetch('name'), $this->fetch('default_value'), false);
$extra = ($this->fetch('extra')?:[]);
$defaults = $extra + $defaults;
if (($error = form_error($this->fetch('name'), '<div class="form-control-feedback"><i class="material-icons">warning</i> ', '</div>'))) {
    $defaults['class'] .= ' form-control-danger';
}
?>
<input <?= _attributes_to_string([
    'type' => 'hidden',
    'name' => $defaults['name'],
    'value' => $defaults['value'] ?: 'empty',
]) ?>>
<input type='file' <?= _attributes_to_string($defaults) ?> />

<?php if (isset($defaults['file_url'])): ?>
<a href="<?= html_escape($defaults['file_url']) ?>" target="_blank"><?= html_escape($defaults['value']) ?></a>
<?php else: ?>
<?= html_escape($defaults['value']) ?>
<?php endif ?>

<?php if (!is_required_field($defaults['name']) && !empty($defaults['value'])): ?>
<button <?= _attributes_to_string([
    'type' => 'submit',
    'name' => '_upload_clear',
    'value' => $defaults['name'],
]) ?>><?= lang('general_action_delete') ?></button>
<?php endif ?>
<?= $error ?>
