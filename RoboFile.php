<?php

use Globalis\Robo\Core\Command;
use Globalis\Robo\Core\GitCommand;
use Globalis\Robo\Core\SemanticVersion;
use Symfony\Component\Process\Process;

class RoboFile extends \Globalis\Robo\Tasks
{

    /**
     * Répertoire contenant les variables de configuration
     * @var string
     */
    private $configDirectory = __DIR__ . '/.robo/config/';

    /**
     * Répertoire contenant les fichiers de configuration de l'application
     * @var string
     */
    private $buildDirectory = __DIR__ . '/.robo/build';

    /**
     * @var string
     */
    private $partsDirectory = __DIR__ . '/.robo/parts';

    /**
     * Install project
     */
    public function install()
    {
        $this->loadConfig();
        $this->buildApp(__DIR__);
        $this->installDependencies(__DIR__);
        $this->_assetsBuild(__DIR__);
        $this->migrateUp();
    }

    private function installDependencies($appPath)
    {
        // Install composer dependencies
        $task = $this->taskComposerInstall()
            ->workingDir($appPath)
            ->preferDist();
        if ($this->configVariables['ENVIRONEMENT'] == 'production') {
            $task->noDev()
                ->optimizeAutoloader();
        }
        $task->run();
        // Install NPM dependencies
        $task = $this->taskExec('make')
            ->arg('install')
            ->dir($appPath . '/integrations')
            ->run();
    }

    /**
     * Build portal assets
     */
    public function assetsBuild()
    {
        $this->loadConfig();
        $this->_assetsBuild(__DIR__);
    }

    /**
     * Watch changes on portal assets
     */
    public function assetsWatch()
    {
        $this->loadConfig();

        $this->taskWatch()
            ->monitor('integrations/assets/styles', function () {
                $this->_assetsBuildStyles(__DIR__);
            })
            ->monitor('integrations/assets/scripts', function () {
                $this->_assetsBuildScripts(__DIR__);
            })
            ->monitor('integrations/assets/images', function () {
                $this->_assetsBuildImages(__DIR__);
            })
            ->monitor('integrations/assets/fonts', function () {
                $this->_assetsBuildFonts(__DIR__);
            })->run();
    }

    private function _assetsBuild($appPath)
    {
        $this->_assetsBuildStyles($appPath);
        $this->_assetsBuildScripts($appPath);
        $this->_assetsBuildImages($appPath);
        $this->_assetsBuildFonts($appPath);
    }

    private function _assetsBuildStyles($appPath)
    {
        $this->taskExec('node_modules/.bin/node-sass')
                ->dir(__DIR__ . '/integrations/')
                ->rawArg('--output-style=compressed')
                ->rawArg('assets/styles/main.scss')
                ->rawArg('-o ' . $appPath .'/public/styles/')
            ->taskExec('node_modules/.bin/postcss')
                ->dir(__DIR__ . '/integrations/')
                ->rawArg('--config postcss.js')
                ->rawArg('--replace ' . $appPath .'/public/styles/main.css')
            ->run();
    }

    private function _assetsBuildScripts($appPath)
    {
        $this->taskExec('node_modules/.bin/uglifyjs')
                ->dir(__DIR__ . '/integrations/')
                ->rawArg(__DIR__ . '/integrations/assets/scripts/*.js')
                ->rawArg('-o ' . $appPath .'/public/scripts/main.js')
            ->run();
        $this->taskExec('node_modules/.bin/uglifyjs')
                ->dir(__DIR__ . '/integrations/')
                ->rawArg(__DIR__ . '/integrations/node_modules/jquery/dist/jquery.js')
                ->rawArg(__DIR__ . '/integrations/node_modules/popper.js/dist/umd/popper.js')
                ->rawArg(__DIR__ . '/integrations/node_modules/bootstrap/dist/js/bootstrap.js')
                ->rawArg('-o ' . $appPath .'/public/scripts/vendor.js')
            ->run();
    }

    private function _assetsBuildImages($appPath)
    {
        $this->taskImageMinify(__DIR__ . '/integrations/assets/images/*')
                ->to($appPath .'/public/images/')
            ->run();
    }

    private function _assetsBuildFonts($appPath)
    {
        $this->taskRsync()
            ->fromPath(__DIR__ . '/integrations/assets/fonts')
            ->toPath($appPath . '/public')
            ->recursive()
            ->delete()
            ->option('perms')
            ->option('chmod', 'Du=rwx,Dgo=rx,Fu=rw,Fgo=r')
            ->run();
    }

    private function buildApp($appPath)
    {
        $this->taskCopyReplaceDir([$this->buildDirectory => $appPath])
            ->from(array_keys($this->configVariables))
            ->to($this->configVariables)
            ->startDelimiter('<##')
            ->endDelimiter('##>')
            ->dirPermissions(0755)
            ->filePermissions(0644)
            ->run();
        // Build part
        $this->buildParts($appPath);
    }

    private function buildParts($path, $config = null)
    {

        $config = ($config?: $this->configVariables);
        $env = $config['ENVIRONEMENT'];


        $htaccess_parts_path = $this->partsDirectory . '/htaccess/';
        $htaccess_parts =
        [
            $htaccess_parts_path . 'htaccess-general',
            $htaccess_parts_path . 'htaccess-urls',
            $htaccess_parts_path . 'htaccess-performances',
            $htaccess_parts_path . 'htaccess-php',
            $htaccess_parts_path . 'htaccess-security',
        ];

        foreach($htaccess_parts as $key => $part) {
            $part_env = $part . '-' . $env;
            if(file_exists($part_env)) {
                $htaccess_parts[$key] = $part_env;
            }
        }

        $this->taskConcat($htaccess_parts)
        ->to($path . '/.htaccess')
        ->run();

        $this->taskReplacePlaceholders($path . '/.htaccess')
         ->from(array_keys($config))
         ->to($config)
         ->startDelimiter('<##')
         ->endDelimiter('##>')
         ->run();
    }

    /**
     * Configure App
     */
    public function config()
    {
        $this->configVariables = $this->taskConfiguration()
            ->initConfig($this->getProperties('config'))
            ->initLocal($this->getProperties('local'))
            ->initSettings($this->getProperties('settings'))
            ->configFilePath($this->configDirectory . 'my.config')
            ->force(true)
            ->run()
            ->getData();
        // Install project
        $this->install();
    }

    private function loadConfig()
    {
        $this->configVariables = $this->taskConfiguration()
         ->initConfig($this->getProperties('config'))
         ->initLocal($this->getProperties('local'))
         ->initSettings($this->getProperties('settings'))
         ->configFilePath($this->configDirectory . 'my.config')
         ->run()
         ->getData();
    }

    /**
     * Retourne les propriétés de configurations
     *
     * @param  string $type
     * @return array
     */
    private function getProperties($type)
    {
        if (!isset($this->properties)) {
            $this->properties = include $this->configDirectory . 'properties.php';
        }
        return $this->properties[$type];
    }

    /**
     * Database migrate
     * Runs all of the available migrations, optionally up to a specific version
     */
    public function migrateUp()
    {
        $this->taskExec('vendor/bin/phinx')
            ->arg('migrate')
            ->run();
    }

    /**
     * Migration rollback
     * Undo previous migrations executed, optionally down to a specific version
     */
    public function migrateDown()
    {
        $this->taskExec('vendor/bin/phinx')
            ->arg('rollback')
            ->run();
    }

    /**
     * Migration create
     * Create a new migration file
     *
     * @param  string $name The migration name
     */
    public function migrateCreate($name)
    {
        $name = explode(' ', str_replace(['_', '-'], ' ', $name));
        foreach ($name as &$word) {
            $word = mb_strtoupper(mb_substr($word, 0, 1)) . mb_substr($word, 1);
        }
        $name= implode('', $name);

        $this->taskExec('vendor/bin/phinx')
            ->arg('create')
            ->arg($name)
            ->run();
    }
    /**
     * Seed create
     * Create a seed file
     *
     * @param  string $name The seed name
     */
    public function seedCreate($name)
    {
        $this->taskExec('vendor/bin/phinx')
            ->arg('seed:create')
            ->arg($name)
            ->run();
    }

    /**
     * Seed run
     * Run a seed file
     *
     * @param  string $name The seed name
     */
    public function seedRun($name = null)
    {
        $task = $this->taskExec('vendor/bin/phinx')
            ->arg('seed:run');
        if ($name) {
            $task->option('-s ' . $name);
        }
        return $task->run();
    }

    /**
     * Clean project
     */
    public function clean()
    {
        $this->cleanGit();
        $this->cleanWaste();
    }

    /**
     * Git prune
     */
    public function cleanGit()
    {
        $this->loadConfig();
        $this->taskGitStack()
         ->stopOnFail()
         ->exec('fetch --all --prune')
         ->run();
    }

    /**
     * Delete files likes ._* .DS_Store, etc.
     */
    public function cleanWaste()
    {
        $this->taskCleanWaste(__DIR__)->run();
    }

    /**
     * Start a new feature
     *
     * @param  string $name The feature name
     */
    public function featureStart($name)
    {
        $this->loadConfig();
        return $this->taskFeatureStart($name, $this->configVariables['GIT_PATH'])->run();
    }

    /**
     * Finish a feature
     *
     * @param  string $name The feature name
     */
    public function featureFinish($name)
    {
        $this->loadConfig();
        return $this->taskFeatureFinish($name, $this->configVariables['GIT_PATH'])->run();
    }

    /**
     * Start a new hotfix
     *
     * @option string $semversion Version number
     * @option string $type    Hotfix type (path, minor)
     */
    public function hotfixStart($opts = ['semversion' => null, 'type' => 'patch'])
    {
        $this->loadConfig();
        if (empty($opts['semversion'])) {
            $version = $this->getVersion()
                ->increment($opts['type']);
        } else {
            $version = $opts['semversion'];
        }
        $this->loadConfig();
        return $this->taskHotfixStart((string)$version, $this->configVariables['GIT_PATH'])->run();
    }

    /**
     * Finish a hotfix
     *
     * @option string $semversion Version number
     * @option string $type    Hotfix type (path, minor)
     */
    public function hotfixFinish($opts = ['semversion' => null, 'type' => 'patch'])
    {
        $this->loadConfig();
        if (empty($opts['semversion'])) {
            $version = $this->getVersion()
                ->increment($opts['type']);
        } else {
            $version = $opts['semversion'];
        }
        return $this->taskHotfixFinish((string)$version, $this->configVariables['GIT_PATH'])->run();
    }

    /**
     * Start a new release
     *
     * @option string $semversion Version number
     * @option string $type    Relase type (minor, major)
     */
    public function releaseStart($opts = ['semversion' => null, 'type' => 'minor'])
    {
        $this->loadConfig();
        if (empty($opts['semversion'])) {
            $version = $this->getVersion()
                ->increment($opts['type']);
        } else {
            $version = $opts['semversion'];
        }
        return $this->taskReleaseStart((string)$version, $this->configVariables['GIT_PATH'])->run();
    }

    /**
     * Finish a release
     *
     * @option string $semversion Version number
     * @option string $type    Relase type (minor, major)
     */
    public function releaseFinish($opts = ['semversion' => null, 'type' => 'minor'])
    {
        $this->loadConfig();
        if (empty($opts['semversion'])) {
            $version = $this->getVersion()
                ->increment($opts['type']);
        } else {
            $version = $opts['semversion'];
        }
        return $this->taskReleaseFinish((string)$version, $this->configVariables['GIT_PATH'])->run();
    }

    /**
     * Return current version
     *
     * @return SemanticVersion
     */
    private function getVersion()
    {
        // Get version from tag
        $cmd = new Command($this->configVariables['GIT_PATH']);
        $cmd = $cmd->arg('tag')
            ->execute();
        $output = explode(PHP_EOL, trim($cmd->getOutput()));
        $currentVersion = '0.0.0';
        foreach ($output as $tag) {
            if (preg_match(SemanticVersion::REGEX, $tag)) {
                if (version_compare($currentVersion, $tag, '<')) {
                    $currentVersion = $tag;
                }
            }
        }
        return new SemanticVersion($currentVersion);
    }

    private function gitCheckout($branch)
    {
        $cmd = new GitCommand($this->configVariables['GIT_PATH']);
        if (!$cmd->isCleanWorkingTree()) {
            $this->io->error("Working tree contains unstaged changes. Aborting.");
            return false;
        }
        return $cmd->checkout($branch);
    }
}
