<?php
// Manage GET parameters
define('ROOT', 'http://'.trim($_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']), '/').'/');
function params($arr, $overwrite = true) {
    if ($overwrite) $arr = array_merge($_GET, $arr);
    return '?'.http_build_query(array_filter($arr));
}


// Placeholder images using Placehold.it
function img($width, $height, $options = []) {
    $options = array_merge(['bg' => 'cccccc', 'color' => '969696', 'text' => null], $options);
    $path = 'placeholders/'.$width.'x'.$height.'_'.sha1(serialize($options)).'.png';
    if (!is_file($path)) {
        $img = file_get_contents('http://placehold.it/'.$width.'x'.$height.'/'.$options['bg'].'/'.$options['color'].'/?text='.urlencode($options['text']));
        file_put_contents($path, $img, LOCK_EX);
    }
    return $path;
}


// Pick random item in array
function pick($arr = []) {
    if (empty($arr)) return null;
    shuffle($arr);
    return array_pop($arr);
}


// Include view with data
function view($file, $data = array(), $return = false) {
    ob_start();
    extract($data);
    if (strtolower(strrchr($file, '.')) !== '.php') $file .= '.php';
    include $file;
    if ($return) return ob_get_clean();
    else ob_end_flush();
}


// Apply HTML classes conditionnally ("class => value" assoc array)
// NOTE if the value is false (or null, or 0), the class will be skipped
/* EXAMPLE:
<button class="<?php echo classes(array(
    'btn btn-default' => true,
    'btn-sm' => strlen($text) < 10,
    'btn-lg' => strlen($text) >= 10,
))"><?php echo $text ?></button>
*/
function classes($arr) {
    return implode(' ', array_keys(array_filter($arr)));
}


// Apply HTML tag attributes conditionnally ("attribute => value" assoc array)
// NOTE if the value is false (or null, or 0), the attribute will be skipped
/* EXAMPLE:
<input<?php echo attr(array(
    'type' => 'text',
    'name' => $name,
    'value' => $value,
    'placeholder' => $placeholder,
    'class' => classes(array(
        'form-control' => true,
        'disabled' => isset($error['name']),
    )),
))>
*/
function attr($arr) {
    $attr = array();
    foreach (array_filter($arr) as $key => $value) {
        if (is_array($value) || is_object($value)) $value = json_encode($value);
        $attr[] = $key.'="'.htmlentities($value, ENT_QUOTES).'"';
    }
    return count($attr) ? ' '.implode(' ', $attr) : null;
}


// Generate random words
function words($min, $max = false) {
    static $words = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec a nisl felis. Sed facilisis diam nec convallis blandit. In hac habitasse platea dictumst. Nullam consectetur consectetur tortor, sed posuere erat bibendum nec. Pellentesque felis justo, aliquam non molestie eu, luctus et magna. Curabitur sapien odio, luctus sit amet sem id, dignissim scelerisque nisl. Nam at arcu tellus. Maecenas condimentum ligula a metus molestie ullamcorper. Sed varius in eros ac tristique. Quisque ac velit lectus. Aenean rutrum sollicitudin malesuada. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; In a dictum risus. Cras sed odio ut dolor commodo efficitur. Proin faucibus orci maximus turpis tincidunt imperdiet.';
    if (is_string($words)) $words = explode(' ', preg_replace('/[^\w\s]/', '', strtolower($words)));
    shuffle($words);
    if (!$max) $max = $min;
    return ucfirst(join(' ', array_slice($words, 0, mt_rand($min, $max))));
}


// Escape value to prevent XSS
function xss($v, $quotes = false) {
    return $quotes ? htmlspecialchars($v, ENT_QUOTES) : htmlspecialchars($v);
}
