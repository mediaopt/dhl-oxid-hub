<?php
namespace Mediaopt\DHL;

use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\ViewConfig;

/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2016 Mediaopt GmbH
 */

/**
 * Installation and deinstallation of the module.
 *
 * @author Mediaopt GmbH
 */
class Install
{
    /**
     * @throws \Exception
     */
    public static function onActivate()
    {
        static::addBootstrapLoader();
        static::ensureConfigVariableNameLength();
        static::addTables();
        static::addColumns();
        static::ensureDocumentsFolderExists();
        static::cleanUp();
    }

    protected function ensureDocumentsFolderExists()
    {
        $path = Registry::get(ViewConfig::class)->getModulePath('mo_dhl', '') . 'documents';
        if (!is_dir($path)) {
            mkdir($path);
        }
        if (!is_dir($path)) {
            Registry::getUtilsView()->addErrorToDisplay(sprintf(Registry::getLang()->translateString('MO_DHL__INSTALL_FOLDER_ERROR'), $path));
        }
    }

    /**
     * Adds a line to the functions.php in the modules directory to ensure that the bootstrap is included.
     */
    protected static function addBootstrapLoader()
    {
        $lines = file_exists(static::getFunctionsFile()) ? file(static::getFunctionsFile(), FILE_IGNORE_NEW_LINES) : ['<?php'];
        $bootstrapLoader = static::getBootstrapLoaderStatement();

        if (in_array($bootstrapLoader, $lines, true)) {
            return;
        }

        $lineOfClosingTag = array_search('?>', $lines, true);
        if ($lineOfClosingTag !== false) {
            $lines = array_slice($lines, 0, $lineOfClosingTag);
        }
        $lines[] = $bootstrapLoader;

        file_put_contents(static::getFunctionsFile(), implode(PHP_EOL, $lines) . PHP_EOL);
    }

    /**
     * @return string
     */
    protected static function getFunctionsFile()
    {
        return OX_BASE_PATH . 'modules/functions.php';
    }

    /**
     * @return string
     */
    protected static function getBootstrapLoaderStatement()
    {
        $comment = 'This line was automatically generated.';
        return "require_once __DIR__ . '/mo/mo_dhl/bootstrap.php'; // {$comment}";
    }

    /**
     * Add a new column with specified type to a table.
     *
     * This method intercepts exceptions signaling that the given column already exists.
     *
     * @param string $table
     * @param string $column
     * @param string $type
     * @return int
     * @throws \Exception
     */
    protected static function addColumn($table, $column, $type)
    {
        try {
            \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->execute("ALTER TABLE {$table} ADD COLUMN {$column} {$type};");
            return 1;
        } catch (\Exception $ex) {
            if ($ex->getCode() === 1060) {
                return 0;
            }
            throw $ex;
        }
    }

    /**
     * Deletes every file in the tmp directory.
     */
    protected static function cleanUp()
    {
        foreach (glob(\OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam('sCompileDir') . '*') as $pathToFile) {
            if (is_file($pathToFile)) {
                unlink($pathToFile);
            }
        }
    }

    /**
     * Removes the bootstrap loader.
     */
    public static function onDeactivate()
    {
        static::removeBootstrapLoader();
        static::cleanUp();
    }

    /**
     * Removes the line in the functions.php in the modules directory that loads the bootstrap, in case this line
     * exists.
     */
    protected static function removeBootstrapLoader()
    {
        if (!file_exists(static::getFunctionsFile())) {
            return;
        }

        $lines = file(static::getFunctionsFile(), FILE_IGNORE_NEW_LINES);
        $lineOfBootstrapLoader = array_search(static::getBootstrapLoaderStatement(), $lines, true);
        if ($lineOfBootstrapLoader !== false) {
            unset($lines[$lineOfBootstrapLoader]);
        }
        file_put_contents(static::getFunctionsFile(), implode(PHP_EOL, $lines) . PHP_EOL);
    }

    /**
     * @throws \Exception
     */
    protected static function addTables()
    {
        self::addTable('mo_dhl_labels', "(
        `OXID` CHAR(32) COLLATE latin1_general_ci NOT NULL,
        `OXSHOPID` INT DEFAULT 1 NOT NULL,
        `orderId` CHAR(32) COLLATE latin1_general_ci,
        `shipmentNumber` VARCHAR(39),
        `returnShipmentNumber` VARCHAR(39),
        `labelUrl` VARCHAR(512),
        `returnLabelUrl` VARCHAR(512),
        `exportLabelUrl` VARCHAR(512),
        `createdAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY (OXID)
        );
        CREATE INDEX MoDhlLabelIndex ON mo_dhl_labels (OXSHOPID, orderId);");
    }

    /**
     * @throws \Exception
     */
    protected static function addColumns()
    {
        $payments = self::addColumn('oxpayments', 'MO_DHL_EXCLUDED', 'TINYINT(1) NOT NULL DEFAULT 0');
        $delivery = self::addColumn('oxdeliveryset', 'MO_DHL_EXCLUDED', 'TINYINT(1) NOT NULL DEFAULT 0')
            + self::addColumn('oxdelivery', 'MO_DHL_EXCLUDED', 'TINYINT(1) NOT NULL DEFAULT 0')
            + self::addColumn('oxdeliveryset', 'MO_DHL_PROCESS', 'VARCHAR(32)')
            + self::addColumn('oxdeliveryset', 'MO_DHL_OPERATOR', 'VARCHAR(40)')
            + self::addColumn('oxdeliveryset', 'MO_DHL_PARTICIPATION', 'CHAR(2)');
        $order = self::addColumn('oxorder', 'MO_DHL_EKP', 'CHAR(10)')
            + self::addColumn('oxorder', 'MO_DHL_PROCESS', 'VARCHAR(32)')
            + self::addColumn('oxorder', 'MO_DHL_OPERATOR', 'VARCHAR(40)')
            + self::addColumn('oxorder', 'MO_DHL_PARTICIPATION', 'CHAR(2)')
            + self::addColumn('oxorder', 'MO_DHL_LAST_LABEL_CREATION_STATUS', 'VARCHAR(100)')
            + self::addColumn('oxorder', 'MO_DHL_ALLOW_NOTIFICATION', 'TINYINT(1) NOT NULL DEFAULT 0')
            + self::addColumn('oxcountry', 'MO_DHL_RETOURE_RECEIVER_ID', 'VARCHAR(32)')
            + self::addColumn('mo_dhl_labels', 'type', 'ENUM("delivery", "retoure") DEFAULT "delivery"')
            + self::addColumn('mo_dhl_labels', 'qrLabelUrl', 'VARCHAR(512)');
        if (max($payments, $delivery, $order) === 0) {
            return;
        }

        $db = \OxidEsales\Eshop\Core\DatabaseProvider::getDb(\OxidEsales\Eshop\Core\DatabaseProvider::FETCH_MODE_ASSOC);
        if ($payments > 0) {
            $paymentsExcludedByDefault = ['oxidpayadvance', 'oxidcashondel'];
            $oxids = implode(', ', array_map([$db, 'quote'], $paymentsExcludedByDefault));
            $db->execute("UPDATE oxpayments SET MO_DHL_EXCLUDED = 1 WHERE OXID IN ({$oxids})");
        }
        \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\DbMetaDataHandler::class)->updateViews();
    }

    /**
     * This method ensures that the OXVARNAME column is large enough for our configuration variable names.
     */
    protected static function ensureConfigVariableNameLength()
    {
        $db = \OxidEsales\Eshop\Core\DatabaseProvider::getDb(\OxidEsales\Eshop\Core\DatabaseProvider::FETCH_MODE_ASSOC);
        $fieldInformation = $db->getRow("SHOW COLUMNS FROM oxconfig WHERE Field = 'OXVARNAME'");
        $length = substr($fieldInformation['Type'], strlen('VARCHAR('), -1);
        if ($length < 100) {
            $db->execute("ALTER TABLE oxconfig MODIFY OXVARNAME VARCHAR(100) DEFAULT '' NOT NULL");
        }
    }

    /**
     * @param string $table
     * @param string $params
     * @return int
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseErrorException
     */
    protected static function addTable($table, $params)
    {
        if (self::tableExists($table)) {
            return 0;
        }
        \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->execute("CREATE TABLE $table $params");
        return 1;
    }

    /**
     * check if table already exists
     *
     * @param string $tableName
     * @return bool
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     */
    private static function tableExists(string $tableName)
    {
        $dbName = \OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam('dbName');
        $sQuery = 'SELECT 1 FROM information_schema.tables WHERE table_schema = ? AND table_name = ?';
        return (bool)\OxidEsales\Eshop\Core\DatabaseProvider::getDb()->getOne($sQuery, [$dbName, $tableName]);
    }
}
