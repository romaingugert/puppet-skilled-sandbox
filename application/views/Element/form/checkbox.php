<?php
$defaults = [
    'name' => $this->fetch('name'),
    'id'    => preg_replace('/[^A-Za-z0-9\_\-]/', '_', $this->fetch('name')),
    'type' => 'checkbox',
    'class' => 'custom-control-input',
];

$extra = ($this->fetch('extra')?:[]);
$defaults = $extra + $defaults;
$selected = (array) $this->fetch('default_value');
$error = form_error($this->fetch('name'), '<div class="invalid-feedback d-flex"><i class="material-icons">warning</i> ', '</div>');
?>
<div>
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
    <div class="custom-control custom-checkbox">
        <input <?= _attributes_to_string($attr) ?> <?= set_checkbox($this->fetch('name'), $key, in_array($key, $selected)) ?> />
        <label class="custom-control-label" for="<?= $attr['id'] ?>"><?= lang_libelle($val) ?></label>
    </div>
<?php
endforeach;
?>
</div>
<?= $error ?>
