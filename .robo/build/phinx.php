<?php

/**
 *  Migration base class
 */
class PuppetSkilledMigration extends \Phinx\Migration\AbstractMigration {

    protected function uuid($trim = false)
    {
        $format = ($trim == false) ? '%04x%04x-%04x-%04x-%04x-%04x%04x%04x' : '%04x%04x%04x%04x%04x%04x%04x%04x';

        return sprintf(
            $format,
            // 32 bits for "time_low"
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),
            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,
            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,
            // 48 bits for "node"
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }
}

/**
 * Own Adapter
 */
class PuppetSkilledAdaptater extends \Phinx\Db\Adapter\MysqlAdapter {

    /**
     * Get the defintion for a `DEFAULT` statement.
     *
     * @param  mixed $default
     * @return string
     */
    protected function getDefaultValueDefinition($default)
    {
        if (is_string($default) && !preg_match('/^CURRENT_TIMESTAMP/', $default)) {
            $default = $this->getConnection()->quote($default);
        } elseif (is_bool($default)) {
            $default = $this->castToBool($default);
        }
        return isset($default) ? ' DEFAULT ' . $default : '';
    }

    /**
     * {@inheritdoc}
     */
    public function getSqlType($type, $limit = null)
    {
        switch ($type) {
            case static::PHINX_TYPE_STRING:
                return array('name' => 'varchar', 'limit' => $limit ? $limit : 255);
                break;
            case static::PHINX_TYPE_CHAR:
                return array('name' => 'char', 'limit' => $limit ? $limit : 255);
                break;
            case static::PHINX_TYPE_TEXT:
                if ($limit) {
                    $sizes = array(
                        // Order matters! Size must always be tested from longest to shortest!
                        'longtext'   => static::TEXT_LONG,
                        'mediumtext' => static::TEXT_MEDIUM,
                        'text'       => static::TEXT_REGULAR,
                        'tinytext'   => static::TEXT_SMALL,
                    );
                    foreach ($sizes as $name => $length) {
                        if ($limit >= $length) {
                            return array('name' => $name);
                        }
                    }
                }
                return array('name' => 'text');
                break;
            case static::PHINX_TYPE_BINARY:
                return array('name' => 'binary', 'limit' => $limit ? $limit : 255);
                break;
            case static::PHINX_TYPE_VARBINARY:
                return array('name' => 'varbinary', 'limit' => $limit ? $limit : 255);
                break;
            case static::PHINX_TYPE_BLOB:
                if ($limit) {
                    $sizes = array(
                        // Order matters! Size must always be tested from longest to shortest!
                        'longblob'   => static::BLOB_LONG,
                        'mediumblob' => static::BLOB_MEDIUM,
                        'blob'       => static::BLOB_REGULAR,
                        'tinyblob'   => static::BLOB_SMALL,
                    );
                    foreach ($sizes as $name => $length) {
                        if ($limit >= $length) {
                            return array('name' => $name);
                        }
                    }
                }
                return array('name' => 'blob');
                break;
            case static::PHINX_TYPE_INTEGER:
                if ($limit && $limit >= static::INT_TINY) {
                    $sizes = array(
                        // Order matters! Size must always be tested from longest to shortest!
                        'bigint'    => static::INT_BIG,
                        'int'       => static::INT_REGULAR,
                        'mediumint' => static::INT_MEDIUM,
                        'smallint'  => static::INT_SMALL,
                        'tinyint'   => static::INT_TINY,
                    );
                    $limits = array(
                        'int'    => 11,
                        'bigint' => 20,
                    );
                    foreach ($sizes as $name => $length) {
                        if ($limit >= $length) {
                            $def = array('name' => $name);
                            if (isset($limits[$name])) {
                                $def['limit'] = $limits[$name];
                            }
                            return $def;
                        }
                    }
                } elseif (!$limit) {
                    $limit = 11;
                }
                return array('name' => 'int', 'limit' => $limit);
                break;
            case static::PHINX_TYPE_BIG_INTEGER:
                return array('name' => 'bigint', 'limit' => 20);
                break;
            case static::PHINX_TYPE_FLOAT:
                return array('name' => 'float');
                break;
            case static::PHINX_TYPE_DECIMAL:
                return array('name' => 'decimal');
                break;
            case static::PHINX_TYPE_DATETIME:
                return array('name' => 'datetime', 'limit' => $limit ? $limit : 0);
                break;
            case static::PHINX_TYPE_TIMESTAMP:
                return array('name' => 'timestamp');
                break;
            case static::PHINX_TYPE_TIME:
                return array('name' => 'time');
                break;
            case static::PHINX_TYPE_DATE:
                return array('name' => 'date');
                break;
            case static::PHINX_TYPE_BOOLEAN:
                return array('name' => 'tinyint', 'limit' => 1);
                break;
            case static::PHINX_TYPE_UUID:
                return array('name' => 'char', 'limit' => 36);
            // Geospatial database types
            case static::PHINX_TYPE_GEOMETRY:
            case static::PHINX_TYPE_POINT:
            case static::PHINX_TYPE_LINESTRING:
            case static::PHINX_TYPE_POLYGON:
                return array('name' => $type);
            case static::PHINX_TYPE_ENUM:
                return array('name' => 'enum');
                break;
            case static::PHINX_TYPE_SET:
                return array('name' => 'set');
                break;
            case static::TYPE_YEAR:
                if (!$limit || in_array($limit, array(2, 4)))
                    $limit = 4;
                return array('name' => 'year', 'limit' => $limit);
                break;
            case static::PHINX_TYPE_JSON:
                return array('name' => 'json');
                break;
            default:
                throw new \RuntimeException('The type: "' . $type . '" is not supported.');
        }
    }
}

\Phinx\Db\Adapter\AdapterFactory::instance()->registerAdapter('mysql', '\PuppetSkilledAdaptater');

// Define phinx env
return [
    'paths' => [
        'migrations' => 'migrations',
        'seeds' => '<##SEEDS_FOLDER##>',
    ],
    'migration_base_class' => 'PuppetSkilledMigration',
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_database' => 'database',
        'database' => [
            'adapter' => 'mysql',
            'host' => '<##DB_HOST##>',
            'name' => '<##DB_NAME##>',
            'user' => '<##DB_USER##>',
            'pass' => '<##DB_PASSWORD##>',
            'port' => '<##DB_PORT##>',
            'charset' => 'utf8',
        ]
    ],
];
