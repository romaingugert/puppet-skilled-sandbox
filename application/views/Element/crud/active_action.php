<?php
$routeKey = $this->fetch('route_key') ?:  $this->fetch('item')->getRouteKey();
$baseUrl = $this->fetch('base_url') ?: current_base_url();
if($this->fetch('item')->active):
?>
<?= csrf_anchor(
    $baseUrl . '/active_toggle/' . $routeKey,
    '<i class="material-icons">lock_open</i>',
    [
        'class' => 'btn btn-sm btn-success',
        'title' => lang('general_action_inactive'),
        'data-toggle' => "tooltip",
        'data-placement' => 'top',
        'data-confirm' => lang('general_message_disable-confirm')
    ],
    $baseUrl . '/active_toggle/' . $routeKey,
    false
) ?>
<?php else: ?>
<?= csrf_anchor(
    $baseUrl . '/active_toggle/' . $routeKey,
    '<i class="material-icons">lock</i>',
    [
        'class' => 'btn btn-sm btn-danger',
        'title' => lang('general_action_active'),
        'data-toggle' => "tooltip",
        'data-placement' => 'top',
        'data-confirm' => lang('general_message_enable-confirm')
    ],
    $baseUrl . '/active_toggle/' . $routeKey,
    false
) ?>
<?php endif; ?>
