<?php
$defaults = [
    'name' => $this->fetch('name'),
    'id'    => preg_replace('/[^A-Za-z0-9\_\-]/', '_', $this->fetch('name')),
    'type' => 'radio',
    'class' => 'custom-control-input',
];

$extra = ($this->fetch('extra')?:[]);
$defaults = $extra + $defaults;
$selected = $this->fetch('default_value');
?>
<div>
<?php
foreach ($this->fetch('options') as $key => $val) :
    $key = (string) $key;
    $attr = $defaults;
    $attr['id'] = $attr['id'] . $key;
    $attr['value'] = $key;
?>
<div class="input-group">
    <label class="custom-control custom-radio">
        <input <?= _attributes_to_string($attr) ?> <?= set_radio($this->fetch('name'), $key, $key === $selected) ?> />
        <span class="custom-control-indicator"></span>
        <span class="custom-control-description"><?= lang_libelle($val) ?></span>
    </label>
</div>
<?php
endforeach;
?>
</div>
<?= form_error($this->fetch('name'), '<div class="form-control-feedback"><i class="material-icons">warning</i> ', '</div>') ?>
