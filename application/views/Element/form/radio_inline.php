<?php
$defaults = [
    'name' => $this->fetch('name'),
    'id'    => preg_replace('/[^A-Za-z0-9\_\-]/', '_', $this->fetch('name')),
    'type' => 'radio',
    'class' => 'form-check-input custom-control-input',
    'wrapper' => true,
];

$extra = ($this->fetch('extra')?:[]);
$defaults = $extra + $defaults;
$selected = $this->fetch('default_value');
$error = form_error($this->fetch('name'), '<div class="invalid-feedback d-flex"><i class="material-icons">warning</i> ', '</div>');
?>
<?php if ($this->fetch('wrapper') !== false): ?>
<div class="<?= $this->fetch('wrapper') ?>">
<?php endif ?>
<?php
foreach ($this->fetch('options') as $key => $val) :
    $key = (string) $key;
    $attr = $defaults;
    $attr['id'] = $attr['id'] . $key;
    $attr['value'] = $key;
    if ($error) {
        $attr['class'] .= ' is-invalid';
    }
?>
<div class="form-check form-check-inline">
    <div class="custom-control custom-radio">
        <input <?= _attributes_to_string($attr) ?> <?= set_radio($this->fetch('name'), $key, $key === $selected) ?> />
        <label class="form-check-label custom-control-label" for="<?= $attr['id'] ?>"><?= lang_libelle($val) ?></label>
    </div>
</div>
<?php
endforeach;
?>
<?= $error ?>
<?php if ($this->fetch('wrapper') !== false): ?>
</div>
<?php endif ?>
