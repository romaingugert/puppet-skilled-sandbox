<header class="Navbar">
    <label for="sidenav-token" class="Navbar-toggler">
        <i class="material-icons">menu</i>
    </label>
    <h1 class="Navbar-title hidden-md-down"><?= lang_libelle($this->fetch('page_title')) ?></h1>
    <div class="dropdown hidden-lg-up">
        <button class="Navbar-title dropdown-toggle" type="button" id="dropdownBreadcrumbMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?= lang_libelle($this->fetch('page_title')) ?>
        </button>
<?php
$breadcrumb = $this->fetch('breadcrumb');
if (!empty($breadcrumb)):
end($breadcrumb);
$lastKey = key($breadcrumb);
?>
        <div class="dropdown-menu" aria-labelledby="dropdownBreadcrumbMenuButton">
<?php
foreach ($this->fetch('breadcrumb') as $key => $value):
?>
            <?= anchor(
                $value['uri'],
                lang_libelle($value['label']),
                [
                    'class' =>  'dropdown-item' . (($key === $lastKey)? ' active' : '')
                ]
            ) ?>
<?php endforeach; ?>
        </div>
<?php endif; ?>
    </div>
</header>
