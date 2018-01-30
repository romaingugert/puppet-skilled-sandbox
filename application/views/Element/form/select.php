<?php
$defaults = [
    'name' => $this->fetch('name'),
    'id'    => preg_replace('/[^A-Za-z0-9\_\-]/', '_', $this->fetch('name')),
    'class' => 'form-control',
];

$selected = (array) $this->fetch('default_value');

if (count($selected) > 1) {
    $defaults['multiple'] = 'multiple';
}

if (($error = form_error($this->fetch('name'), '<div class="invalid-feedback"><i class="material-icons">warning</i> ', '</div>'))) {
    $defaults['class'] .= ' is-invalid';
}

$extra = ($this->fetch('extra')?:[]);
$defaults = $extra + $defaults;
?>
<select <?= _attributes_to_string($defaults) ?>>
     <option value="" <?= ((is_required_field($this->fetch('name'))) ? 'disabled' : '')?>><?= lang('general_label_choose-option') ?></option>
<?php
foreach ($this->fetch('options') as $key => $val) :
    $key = (string) $key;
    if (is_array($val)) :
        if (empty($val)) :
            continue;
        endif;
?>
    <optgroup label="<?= lang_libelle($key) ?>">
<?php
foreach ($val as $optgroup_key => $optgroup_val) :
    $optgroup_key = (string) $optgroup_key;
?>
<option value="<?= html_escape($optgroup_key) ?>" <?= set_select($this->fetch('name'), $optgroup_key, in_array($optgroup_key, $selected)) ?>>
<?= lang_libelle($optgroup_val) ?>
</option>
<?php
endforeach;
?>
    </optgroup>
<?php
    else :
?>
    <option value="<?= html_escape($key) ?>" <?= set_select($this->fetch('name'), $key, in_array($key, $selected)) ?> >
    <?= lang_libelle($val) ?>
    </option>
<?php
    endif;
endforeach;
?>
</select>
<?= $error ?>
