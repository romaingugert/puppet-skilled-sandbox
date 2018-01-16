<?php
$pager = $this->fetch('pager');
$pagerResult = $pager->getResult();
$pagination =  $this->element('crud/pagination', ['pager_result' => $pagerResult]);
$baseUrl = $this->fetch('base_url') ?: current_base_url();
?>
<?= $pagination ?>
<div class="table-wrap mt-4 mb-4">
<table class="table table-hover table-bordered">
<thead>
    <tr>
<?php
foreach ($this->fetch('displayed_fields') as $value) :
    $queryKey = (isset($value['query_key']) ? $value['query_key'] : null);
    $label = $value['label'];
?>
            <th>
<?php
if ($queryKey && ($urlKey = $pager->isSortable($queryKey))) :
    if ($pagerResult['sort'] == $queryKey) :
        if ($pagerResult['direction'] == 'desc') :
?>
<?= anchor($baseUrl . '?order=' . $queryKey . '&direction=asc', lang_libelle($label) . ' <i class="material-icons">arrow_drop_down</i>', ['title' => lang_libelle($label)]) ?>
<?php
        else :
?>
<?= anchor($baseUrl . '?order=' . $queryKey . '&direction=desc', lang_libelle($label) . ' <i class="material-icons">arrow_drop_up</i>', ['title' => lang_libelle($label)]) ?>
<?php
        endif;
    else :
?>
<?= anchor($baseUrl . '?order=' . $queryKey, lang_libelle($label) . ' <i class="material-icons">import_export</i>', ['title' => lang_libelle($label)]) ?>
<?php
    endif;
else :
?>
<?= lang_libelle($label) ?>
<?php
endif;
?>
        </th>
<?php
endforeach;
?>
    </tr>
</thead>
<tbody>
<?php
if (empty($pagerResult['result'])) :
?>
<td colspan="<?= count($this->fetch('displayed_fields')) ?>"><?= lang_libelle('lang:general_label_no-result-found') ?></td>
<?php
else :
    foreach ($pagerResult['result'] as $item) :
?>
        <tr>
<?php
        foreach ($this->fetch('displayed_fields') as $key => $value) :
            if (isset($value['formater'])) :
?>
        <td  class="<?= (isset($value['class'])? $value['class'] : '') ?>"><?= call_user_func($value['formater'], $item) ?></td>
<?php
            elseif ($item->{$value['query_key']} instanceof Carbon\Carbon) :
?>
        <td  class="<?= (isset($value['class'])? $value['class'] : '') ?>"><?= user_date_format($item->{$value['query_key']}) ?></td>
<?php
            else :
?>
        <td class="<?= (isset($value['class'])? $value['class'] : '') ?>"><?= html_escape($item->{$value['query_key']}) ?></td>
<?php
            endif;
        endforeach;
?>
        </tr>
<?php
    endforeach;
endif;
?>
</tbody>
</table>
</div>
<?= $pagination ?>
