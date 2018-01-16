<link rel="stylesheet" href="<?= $this->asset->getStyleLink('debug.css'); ?>">
<div class="debug">
    <input type="checkbox" id="debug">
    <label for="debug" class="debug-toggle"></label>
    <div class="debug-wrap">
        <ul class="debug-bar">
            <li class="debug-dropdown" title="<?= lang('profiler_benchmarks') ?>">
                <i class="material-icons">alarm</i> <?= $this->fetch('benchmarks')['total_execution_time'] ?>
                <?= debug_benchmarks_dropdown($this) ?>
            </li>
            <li title="<?= lang('profiler_memory_usage') ?>">
                <i class="material-icons">memory</i> <?= (($usage = memory_get_usage()) != '' ? number_format($usage).' bytes' : lang('profiler_no_memory')) ?>
            </li>
            <li class="debug-dropdown" title="<?= lang('profiler_controller_info') ?>">
                <i class="material-icons">settings</i> <?= $this->fetch('controller_info') ?>
                <?= debug_controller_dropdown($this) ?>
            </li>
            <li class="debug-dropdown" title="<?= lang('profiler_queries') ?>">
                <i class="material-icons">storage</i> <?= lang('profiler_queries') ?>
                <?= debug_queries_dropdown($this) ?>
            </li>
            <li title="<?= lang('profiler_session_data') ?>">
                <a href="#ci_profiler_session_data_modal">
                    <i class="material-icons">face</i> <?= lang('profiler_session_data') ?>
                </a>
            </li>
            <li title="<?= lang('profiler_config') ?>">
                <a href="#ci_profiler_config_modal">
                    <i class="material-icons">build</i> <?= lang('profiler_config') ?>
                </a>
            </li>
            <?php if ($this->fetch('meta_content_not_found')): ?>
            <li title="<?= lang('profiler_load_content') ?>">
                <a href="#ci_profiler_content_modal">
                    <i class="material-icons">translate</i> <?= lang('profiler_load_content') ?>
                </a>
            </li>
            <?php endif; ?>
        </ul>
        <?= debug_controller_modal($this) ?>
        <?= debug_queries_modal($this) ?>
        <?= debug_session_modal($this) ?>
        <?= debug_config_modal($this) ?>
        <?= debug_meta_modal($this) ?>
    </div>
</div>
<?php
/* DROPDOWN BENCHMARKS */
function debug_benchmarks_dropdown($view) {
?>
<!-- benchmark -->
<ul class="debug-dropdown-content">
    <?php foreach ($view->fetch('benchmarks') as $key => $val) : ?>
    <li><span><b><?= ucwords(str_replace(array('_', '-'), ' ', $key)) ?>:</b> <?= $val ?></span></li>
    <?php endforeach; ?>
</ul>
<?php
}

/* CONTROLLER INFO  */
function debug_controller_dropdown($view) {
?>
<!-- controller info-->
<ul class="debug-dropdown-content">
    <li><a href="#ci_profiler_get_modal"><?= lang('profiler_get_data') ?></a></li>
    <li><a href="#ci_profiler_post_modal"><?= lang('profiler_post_data') ?></a></li>
    <li><a href="#ci_profiler_http_headers_modal"><?= lang('profiler_headers') ?></a></li>
    <li><span><b><?= lang('profiler_controller_info') ?>:</b> <?= $view->fetch('controller_info') ?></span></li>
    <li><span><b><?= lang('profiler_uri_string') ?>:</b> <?= $view->fetch('uri_string') ?></span></li>
</ul>
<?php
}

function debug_controller_modal($view) {
?>
<!-- GET Modal -->
<div class="debug-window" id="ci_profiler_get_modal">
    <a href="#" class="debug-window-close">&times;</a>
    <h2 class="debug-window-title"><?= lang('profiler_get_data') ?></h2>
    <?php if (count($_GET) === 0) : ?>
    <p><?= lang('profiler_no_get') ?></p>
    <?php else: ?>
    <table>
        <?php
        foreach ($_GET as $key => $val):
            $val = (is_array($val) or is_object($val))
                ? '<pre>'. html_escape(print_r($val, true)) . '</pre>'
                : html_escape($val);
        ?>
        <tr>
            <td>&#36;_GET['<?= html_escape($key) ?>]</td>
            <td><?= $val ?></td>
        </tr>
        <?php endforeach ?>
    </table>
    <?php endif; ?>
</div>

<!-- POST Modal -->
<div class="debug-window" id="ci_profiler_post_modal">
    <a href="#" class="debug-window-close">&times;</a>
    <h2 class="debug-window-title"><?= lang('profiler_post_data') ?></h2>
    <?php if (count($_POST) === 0) : ?>
    <p><?= lang('profiler_no_post') ?></p>
    <?php else: ?>
    <table>
        <?php
        foreach ($_POST as $key => $val):
            $val = (is_array($val) or is_object($val))
                ? '<pre>'. html_escape(print_r($val, true)) . '</pre>'
                : html_escape($val);
        ?>
        <tr>
            <td>&#36;_POST['<?= html_escape($key) ?>]</td>
            <td><?= $val ?></td>
        </tr>
        <?php endforeach ?>
    </table>
    <?php endif; ?>
</div>

<!-- HEADERS-->
<div class="debug-window" id="ci_profiler_http_headers_modal">
    <a href="#" class="debug-window-close">&times;</a>
    <h2 class="debug-window-title"><?= lang('profiler_headers') ?></h2>
    <table>
        <?php foreach (array('HTTP_ACCEPT', 'HTTP_USER_AGENT', 'HTTP_CONNECTION', 'SERVER_PORT', 'SERVER_NAME', 'REMOTE_ADDR', 'SERVER_SOFTWARE', 'HTTP_ACCEPT_LANGUAGE', 'SCRIPT_NAME', 'REQUEST_METHOD',' HTTP_HOST', 'REMOTE_HOST', 'CONTENT_TYPE', 'SERVER_PROTOCOL', 'QUERY_STRING', 'HTTP_ACCEPT_ENCODING', 'HTTP_X_FORWARDED_FOR', 'HTTP_DNT') as $header): ?>
        <tr>
            <td><?= $header ?></td>
            <td>
                <?= html_escape((isset($_SERVER[$header]) ? $_SERVER[$header] : '')) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php
}

/* QUERIES */
function debug_queries_dropdown($view) {
?>
<!-- Queries -->
<ul class="debug-dropdown-content">
    <?php foreach ($view->fetch('databases') as $db) : ?>
    <li>
        <a href="#ci_profiler_queries_<?= $db->database?>">
            <?= $db->database . ' '
                . lang('profiler_queries')
                . ': '.count($db->queries).' ('
                . number_format(array_sum($db->query_times), 4).' '. lang('profiler_seconds').')'
                .')'
            ?>
        </a>
    </li>
    <?php endforeach; ?>
</ul>
<?php
}

function debug_queries_modal($view) {
    foreach ($view->fetch('databases') as $db) :
?>
<!-- Queries -->
<div class="debug-window" id="ci_profiler_queries_<?= $db->database?>">
    <a href="#" class="debug-window-close">&times;</a>
    <h2 class="debug-window-title">
        <?= lang('profiler_database') ?>:
        <?= $db->database . ' '
        . lang('profiler_queries')
        . ': '.count($db->queries).' ('
        . number_format(array_sum($db->query_times), 4).' '. lang('profiler_seconds')
        .')'
        ?>
    </h2>
    <?php if (count($db->queries) === 0) : ?>
    <p><?= lang('profiler_no_queries') ?></p>
    <?php else: ?>
    <table>
        <?php
            $highlight = array('SELECT', 'DISTINCT', 'FROM', 'WHERE', 'AND', 'LEFT&nbsp;JOIN', 'ORDER&nbsp;BY', 'GROUP&nbsp;BY', 'LIMIT', 'INSERT', 'INTO', 'VALUES', 'UPDATE', 'OR&nbsp;', 'HAVING', 'OFFSET', 'NOT&nbsp;IN', 'IN', 'LIKE', 'NOT&nbsp;LIKE', 'COUNT', 'MAX', 'MIN', 'ON', 'AS', 'AVG', 'SUM', '(', ')');
            foreach ($db->queries as $key => $val):
                $time = number_format($db->query_times[$key], 4);
                $val = highlight_code($val);
                foreach ($highlight as $bold) {
                    $val = str_replace($bold, '<strong>'.$bold.'</strong>', $val);
                }
        ?>
        <tr>
            <td><?= $time ?></td>
            <td class="debug-highlight"><?= $val ?></td>
        </tr>
        <?php endforeach ?>
    </table>
    <?php endif; ?>
</div>
<?php
    endforeach;
}

function debug_session_modal($view) {
?>
<!-- Session data-->
<div class="debug-window" id="ci_profiler_session_data_modal">
    <a href="#" class="debug-window-close">&times;</a>
    <h2 class="debug-window-title"><?= lang('profiler_session_data') ?></h2>
    <table>
        <?php foreach ($_SESSION as $key => $val):
            if (is_array($val) or is_object($val)) {
                $uid = str_replace('.', '_', $key) . 'session_debug_collapse';
                $content = '<a class="btn btn-primary" data-toggle="collapse" href="#'.$uid.'" aria-expanded="false" aria-controls="'.$uid.'" >show</a>';
                $content .= '<div class="collapse" id="'.$uid.'"><pre>'. html_escape(print_r($val, true)) . '</pre></div>';
            } else {
                $content = html_escape($val);
            }
        ?>
        <tr>
            <td>&#36;_SESSION['<?= html_escape($key) ?>]</td>
            <td><?= $content ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php
}

/* CONFIG */
function debug_config_modal($view) {
?>
<!-- Config data-->
<div class="debug-window" id="ci_profiler_config_modal">
    <a href="#" class="debug-window-close">&times;</a>
    <h2 class="debug-window-title"><?= lang('profiler_config') ?></h2>
    <table>
        <?php foreach ($view->fetch('config') as $key => $val):
            $val = (is_array($val) or is_object($val))
                ? '<pre>'. html_escape(print_r($val, true)) . '</pre>'
                : html_escape($val);
        ?>
        <tr>
            <td><?= html_escape($key) ?></td>
            <td><?= $val ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php
}

/* META */
function debug_meta_modal($view) {
    if ($view->fetch('meta_content_not_found')):
?>
<!-- Content data-->
<div class="debug-window" id="ci_profiler_content_modal">
    <a href="#" class="debug-window-close">&times;</a>
    <h2 class="debug-window-title"><?= lang('profiler_loaded_content') ?></h2>
    <table>
        <?php
        foreach ($view->fetch('meta_content_not_found') as $values):
            foreach ($values as $key => $val):
            $val = (is_array($val) or is_object($val))
                ? '<pre>'. html_escape(print_r($val, true)) . '</pre>'
                : html_escape($val);
        ?>
        <tr>
            <td><?= html_escape($key) ?></td>
            <td><?= (($val) ?: '<span class="red-text">NULL</span>') ?></td>
        </tr>
        <?php endforeach; ?>
        <?php endforeach; ?>
    </table>
</div>
<?php
    endif;
}
?>
<script src="<?= $this->asset->getScriptLink('lib/debug.js'); ?>"></script>
