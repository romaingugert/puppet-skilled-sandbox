<?php extract([
    'debug' => false,
], EXTR_SKIP) ?>
            </div>
        </section>
    </main>


    <?php view('templates/snippets/dialog') ?>


    <!-- Scripts -->
    <script src="dist/scripts/vendor.js"></script>
    <?php if ($debug): ?>
    <script src="dist/scripts/lib/debug.js"></script>
    <?php endif ?>
    <script src="dist/scripts/main.js"></script>

    <?php if ($debug): ?>
    <?php view('templates/snippets/debug') ?>
    <?php endif ?>
</body>
</html>
