<?php
$preprendId = uniqid();
$item = $this->fetch('item');
?>
<?= form_open($this->fetch('validator'), current_url(), ['class' => 'user_form']) ?>
<fieldset class="card mb-4">
    <h2 class="card-header bg-inverse text-white"><?= lang('user_label_general') ?></h2>
    <div class="card-block">
    <?= $this->element(
        'form/block_input',
        [
            'name' => 'username',
            'input_element' => 'form/input',
            'label' => 'lang:user_label_username',
            'id' => $preprendId . 'username',
            'default_value' => $item->username ?? null,
        ]
    ) ?>

    <?= $this->element(
        'form/block_input',
        [
            'name' => 'first_name',
            'input_element' => 'form/input',
            'label' => 'lang:user_label_first-name',
            'id' => $preprendId . 'first_name',
            'default_value' => $item->first_name ?? null,
        ]
    ) ?>

    <?= $this->element(
        'form/block_input',
        [
            'name' => 'last_name',
            'input_element' => 'form/input',
            'label' => 'lang:user_label_last-name',
            'id' => $preprendId . 'last_name',
            'default_value' => $item->last_name ?? null,
        ]
    ) ?>

    <?= $this->element(
        'form/block_input',
        [
            'name' => 'email',
            'input_element' => 'form/input',
            'label' => 'lang:user_label_email',
            'id' => $preprendId . 'email',
            'default_value' => $item->email ?? null,
        ]
    ) ?>
    </div>
</fieldset>
<fieldset class="card mb-4">
    <h2 class="card-header bg-inverse text-white"><?= lang('user_label_roles') ?></h2>
    <div class="card-block">
        <?= $this->element(
            'form/block_input',
            [
                'name' => 'roles[]',
                'input_element' => 'form/select',
                'label' => 'lang:user_label_roles',
                'id' => $preprendId . 'roles',
                'options' => array_pluck($this->fetch('roles'), 'name', 'id'),
                'default_value' => ($item ? array_pluck($item->roles, 'id') : []),
                'extra' => [
                    'multiple' => 'multiple'
                ]
            ]
        ) ?>
    </div>
</fieldset>

<fieldset class="card mb-4">
    <h2 class="card-header bg-inverse text-white"><?= lang('user_label_configuration') ?></h2>
    <div class="card-block">
        <?= $this->element(
            'form/block_input',
            [
                'name' => 'datetime_format',
                'input_element' => 'form/select',
                'label' => 'lang:user_label_date_format',
                'id' => $preprendId . 'datetime_format',
                'default_value' => $item->datetime_format ?? null,
                'options' => date_format_list(),
            ]
        ) ?>
        <?= $this->element(
            'form/block_input',
            [
                'name' => 'timezone',
                'input_element' => 'form/select',
                'label' => 'lang:user_label_timezone',
                'id' => $preprendId . 'timezone',
                'default_value' => $item->timezone ?? null,
                'options' => timezone_list(),
            ]
        ) ?>
    </div>
</fieldset>

<?php if (!$item || !$item->password): ?>
<fieldset class="card mb-4">
    <h2 class="card-header bg-inverse text-white"><?= lang('user_label_actions') ?></h2>
    <div class="card-block">
        <?= $this->element(
            'form/block_input',
            [
                'name' => 'notify',
                'input_element' => 'form/radio_inline',
                'label' => 'lang:user_label_notify',
                'id' => $preprendId . 'notify',
                'options' => [
                    '1' => 'lang:general_label_yes',
                    '0' => 'lang:general_label_no',
                ],
                'default_value' => '0',
            ]
        ) ?>
    </div>
</fieldset>
<?php endif; ?>

<?= $this->element('form/submit', ['label' => 'lang:general_action_edit']) ?>
</form>
