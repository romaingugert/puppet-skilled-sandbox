<?= $this->element(
    'crud/default_filter',
    [
        'filters' => $this->fetch('filters'),
        'pager' => $this->fetch('pager')
    ]
) ?>
