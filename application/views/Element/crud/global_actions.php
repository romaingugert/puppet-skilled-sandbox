<div class="text-right mb-4">
<?php foreach ($this->fetch('actions') as $action): ?>
    <?= navigation_anchor(
        $action['uri'],
        $action['label'],
        (isset($action['extra'])? $action['extra'] : []),
        true,
        false
    ) ?>
<?php endforeach; ?>
</div>
