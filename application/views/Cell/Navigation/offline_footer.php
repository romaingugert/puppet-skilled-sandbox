<footer class="Offline-footer">
    <p>
        © 2017 <a href="https://github.com/globalis-ms/puppet-skilled-framework" rel="nofollow" target="_blank"><?= app()->config->item('name', 'site_settings') ?></a>
        <?php foreach ($this->fetch('footer_nav') as $nav): ?>
            • <?= anchor(
                $nav['uri'],
                lang_libelle($nav['label'])
            ) ?>
        <?php endforeach; ?>
        <br>
        <?= sprintf(lang('general_made_by'), '<a href="https://www.globalis-ms.com" rel="nofollow" target="_blank">GLOBALIS</a>') ?>
    </p>
</footer>
