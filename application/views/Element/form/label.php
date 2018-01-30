<?php
$defaults = [
    'for' => $this->fetch('field'),
    'class' => 'col-form-label',
];
$extra = ($this->fetch('extra')?:[]);
$defaults = $extra + $defaults;
?>
<label <?= _attributes_to_string($defaults) ?>><?= lang_libelle($this->fetch('label')) ?><?= set_required_symbol($this->fetch('field')) ?></label>
