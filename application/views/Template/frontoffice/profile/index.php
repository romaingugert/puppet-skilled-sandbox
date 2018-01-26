<?php $preprendId = uniqid();?>
<?= form_open($this->fetch('validator'), current_url(), ['class' => 'profile_form']) ?>
<fieldset class="card mb-4">
    <h2 class="card-header bg-inverse text-white"><?= lang('profile_label_personal') ?></h2>
    <div class="card-block">

    <?= $this->element(
        'form/block_input',
        [
            'name' => 'first_last_name',
            'input_element' => 'form/info',
            'label' => 'lang:profile_label_first_last_name',
            'id' => $preprendId . 'first_last_name',
            'default_value' => $this->fetch('item')->first_name . " " . $this->fetch('item')->last_name
        ]
    ) ?>
    <?= $this->element(
        'form/block_input',
        [
            'name' => 'email',
            'input_element' => 'form/input',
            'label' => 'lang:profile_label_email',
            'id' => $preprendId . 'email',
            'default_value' => $this->fetch('item')->email
        ]
    ) ?>

    </div>
</fieldset>

<fieldset class="card mb-4">
    <h2 class="card-header bg-inverse text-white"><?= lang('profile_label_authentication') ?></h2>
    <div class="card-block">
        <?= $this->element(
            'form/block_input',
            [
                'name' => 'password',
                'input_element' => 'form/input',
                'label' => 'lang:profile_label_password',
                'id' => $preprendId . 'password',
                'default_value' => '',
                'extra' => [
                    'type' => 'password'
                ]
            ]
        ) ?>

        <?= $this->element(
            'form/block_input',
            [
                'name' => 'password_confirm',
                'input_element' => 'form/input',
                'label' => 'lang:profile_label_password_confirm',
                'id' => $preprendId . 'password_confirm',
                'default_value' => '',
                'extra' => [
                    'type' => 'password'
                ]
            ]
        ) ?>
    </div>
</fieldset>

<fieldset class="card mb-4">
    <h2 class="card-header bg-inverse text-white"><?= lang('profile_label_complement') ?></h2>
    <div class="card-block">
        <?= $this->element(
            'form/block_input',
            [
                'name' => 'language',
                'input_element' => 'form/select',
                'label' => 'lang:profile_label_language',
                'id' => $preprendId . 'language',
                'default_value' => $this->fetch('item')->language, // @TODO : TOUDOUX
                'options' => $this->fetch('languages')
            ]
        ) ?>
        <?= $this->element(
            'form/block_input',
            [
                'name' => 'date_format',
                'input_element' => 'form/select',
                'label' => 'lang:profile_label_date_format',
                'id' => $preprendId . 'date_format',
                'default_value' => $this->fetch('item')->datetime_format,
                'options' => date_format_list(),
            ]
        ) ?>
        <?= $this->element(
            'form/block_input',
            [
                'name' => 'timezone',
                'input_element' => 'form/select',
                'label' => 'lang:profile_label_timezone',
                'id' => $preprendId . 'timezone',
                'default_value' => $this->fetch('item')->timezone,
                'options' => timezone_list(),
            ]
        ) ?>
    </div>
</fieldset>
<?= $this->element('form/submit', ['label' => 'lang:general_action_save']) ?>
</form>