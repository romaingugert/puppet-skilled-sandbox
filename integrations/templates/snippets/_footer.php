<?php extract([
    'charts' => false,
    'dropzone' => false,
    'debug' => false,
], EXTR_SKIP) ?>
            </div>
        </section>
    </main>


    <?php view('templates/snippets/dialog') ?>


    <!-- Scripts -->
    <script src="dist/scripts/vendor.js"></script>
    <?php if ($charts): ?>
    <script src="dist/scripts/lib/Chart.min.js"></script>
    <?php endif ?>
    <?php if ($dropzone): ?>
    <script src="dist/scripts/lib/dropzone.min.js"></script>
    <script>
    Dropzone.autoDiscover = false;
    window.DropzoneL10n = {
        dictDefaultMessage: "Drop files here to upload",
        dictFallbackMessage: "Your browser does not support drag'n'drop file uploads.",
        dictFallbackText: "Please use the fallback form below to upload your files like in the olden days.",
        dictFileTooBig: "File is too big ({{filesize}}MiB). Max filesize: {{maxFilesize}}MiB.",
        dictInvalidFileType: "You can't upload files of this type.",
        dictResponseError: "Server responded with {{statusCode}} code.",
        dictCancelUpload: "Cancel upload",
        dictCancelUploadConfirmation: "Are you sure you want to cancel this upload?",
        dictRemoveFile: "Remove file",
        dictRemoveFileConfirmation: null,
        dictMaxFilesExceeded: "You can not upload any more files.",
    };
    // Dropzone upload
    $('.dropzone').dropzone(DropzoneL10n);
    </script>
    <?php endif ?>
    <?php if ($debug): ?>
    <script src="dist/scripts/lib/debug.js"></script>
    <?php endif ?>
    <script src="dist/scripts/locales.js"></script>
    <script src="dist/scripts/main.js"></script>

    <?php if ($debug): ?>
    <?php view('templates/snippets/debug') ?>
    <?php endif ?>
</body>
</html>
