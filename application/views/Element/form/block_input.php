<?php
$id = ($this->fetch('id')) ?: $this->fetch('name');
$extra_input =  ($this->fetch('extra'))?: [];
$extra_input['id'] = $id;
$class = 'form-group';
?>
<div class="<?= $class ?>">
    <?= $this->element(
        'form/label',
        [
            'label' => $this->fetch('label'),
            'field' => $this->fetch('name'),
            'extra' => ['for' => $id]
        ]
    ) ?>
    <?= $this->element(
        $this->fetch('input_element'),
        [
            'name' => $this->fetch('name'),
            'default_value' => $this->fetch('default_value'),
            'extra' => $extra_input,
            'options' => $this->fetch('options')
        ]
    ) ?>
<?php if($this->fetch('help')): ?>
    <small class="form-text text-muted"><?= lang_libelle($this->fetch('help')) ?></small>
<?php endif; ?>
</div>
