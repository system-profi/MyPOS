<?php

namespace API\Models\ORM\Invoice\Map;

use API\Models\ORM\Invoice\InvoiceWarning;
use API\Models\ORM\Invoice\InvoiceWarningQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'invoice_warning' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class InvoiceWarningTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'API.Models.ORM.Invoice.Map.InvoiceWarningTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'invoice_warning';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\API\\Models\\ORM\\Invoice\\InvoiceWarning';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'API.Models.ORM.Invoice.InvoiceWarning';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 6;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 6;

    /**
     * the column name for the invoice_warningid field
     */
    const COL_INVOICE_WARNINGID = 'invoice_warning.invoice_warningid';

    /**
     * the column name for the invoiceid field
     */
    const COL_INVOICEID = 'invoice_warning.invoiceid';

    /**
     * the column name for the invoice_warning_typeid field
     */
    const COL_INVOICE_WARNING_TYPEID = 'invoice_warning.invoice_warning_typeid';

    /**
     * the column name for the warning_date field
     */
    const COL_WARNING_DATE = 'invoice_warning.warning_date';

    /**
     * the column name for the maturity_date field
     */
    const COL_MATURITY_DATE = 'invoice_warning.maturity_date';

    /**
     * the column name for the warning_value field
     */
    const COL_WARNING_VALUE = 'invoice_warning.warning_value';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('InvoiceWarningid', 'Invoiceid', 'InvoiceWarningTypeid', 'WarningDate', 'MaturityDate', 'WarningValue', ),
        self::TYPE_CAMELNAME     => array('invoiceWarningid', 'invoiceid', 'invoiceWarningTypeid', 'warningDate', 'maturityDate', 'warningValue', ),
        self::TYPE_COLNAME       => array(InvoiceWarningTableMap::COL_INVOICE_WARNINGID, InvoiceWarningTableMap::COL_INVOICEID, InvoiceWarningTableMap::COL_INVOICE_WARNING_TYPEID, InvoiceWarningTableMap::COL_WARNING_DATE, InvoiceWarningTableMap::COL_MATURITY_DATE, InvoiceWarningTableMap::COL_WARNING_VALUE, ),
        self::TYPE_FIELDNAME     => array('invoice_warningid', 'invoiceid', 'invoice_warning_typeid', 'warning_date', 'maturity_date', 'warning_value', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('InvoiceWarningid' => 0, 'Invoiceid' => 1, 'InvoiceWarningTypeid' => 2, 'WarningDate' => 3, 'MaturityDate' => 4, 'WarningValue' => 5, ),
        self::TYPE_CAMELNAME     => array('invoiceWarningid' => 0, 'invoiceid' => 1, 'invoiceWarningTypeid' => 2, 'warningDate' => 3, 'maturityDate' => 4, 'warningValue' => 5, ),
        self::TYPE_COLNAME       => array(InvoiceWarningTableMap::COL_INVOICE_WARNINGID => 0, InvoiceWarningTableMap::COL_INVOICEID => 1, InvoiceWarningTableMap::COL_INVOICE_WARNING_TYPEID => 2, InvoiceWarningTableMap::COL_WARNING_DATE => 3, InvoiceWarningTableMap::COL_MATURITY_DATE => 4, InvoiceWarningTableMap::COL_WARNING_VALUE => 5, ),
        self::TYPE_FIELDNAME     => array('invoice_warningid' => 0, 'invoiceid' => 1, 'invoice_warning_typeid' => 2, 'warning_date' => 3, 'maturity_date' => 4, 'warning_value' => 5, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('invoice_warning');
        $this->setPhpName('InvoiceWarning');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\API\\Models\\ORM\\Invoice\\InvoiceWarning');
        $this->setPackage('API.Models.ORM.Invoice');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('invoice_warningid', 'InvoiceWarningid', 'INTEGER', true, null, null);
        $this->addForeignKey('invoiceid', 'Invoiceid', 'INTEGER', 'invoice', 'invoiceid', true, null, null);
        $this->addForeignKey('invoice_warning_typeid', 'InvoiceWarningTypeid', 'INTEGER', 'invoice_warning_type', 'invoice_warning_typeid', true, null, null);
        $this->addColumn('warning_date', 'WarningDate', 'TIMESTAMP', true, null, null);
        $this->addColumn('maturity_date', 'MaturityDate', 'TIMESTAMP', true, null, null);
        $this->addColumn('warning_value', 'WarningValue', 'DECIMAL', true, 7, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Invoice', '\\API\\Models\\ORM\\Invoice\\Invoice', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':invoiceid',
    1 => ':invoiceid',
  ),
), null, null, null, false);
        $this->addRelation('InvoiceWarningType', '\\API\\Models\\ORM\\Invoice\\InvoiceWarningType', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':invoice_warning_typeid',
    1 => ':invoice_warning_typeid',
  ),
), null, null, null, false);
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('InvoiceWarningid', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('InvoiceWarningid', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('InvoiceWarningid', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('InvoiceWarningid', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('InvoiceWarningid', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('InvoiceWarningid', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('InvoiceWarningid', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }
    
    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? InvoiceWarningTableMap::CLASS_DEFAULT : InvoiceWarningTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (InvoiceWarning object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = InvoiceWarningTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = InvoiceWarningTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + InvoiceWarningTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = InvoiceWarningTableMap::OM_CLASS;
            /** @var InvoiceWarning $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            InvoiceWarningTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();
    
        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = InvoiceWarningTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = InvoiceWarningTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var InvoiceWarning $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                InvoiceWarningTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(InvoiceWarningTableMap::COL_INVOICE_WARNINGID);
            $criteria->addSelectColumn(InvoiceWarningTableMap::COL_INVOICEID);
            $criteria->addSelectColumn(InvoiceWarningTableMap::COL_INVOICE_WARNING_TYPEID);
            $criteria->addSelectColumn(InvoiceWarningTableMap::COL_WARNING_DATE);
            $criteria->addSelectColumn(InvoiceWarningTableMap::COL_MATURITY_DATE);
            $criteria->addSelectColumn(InvoiceWarningTableMap::COL_WARNING_VALUE);
        } else {
            $criteria->addSelectColumn($alias . '.invoice_warningid');
            $criteria->addSelectColumn($alias . '.invoiceid');
            $criteria->addSelectColumn($alias . '.invoice_warning_typeid');
            $criteria->addSelectColumn($alias . '.warning_date');
            $criteria->addSelectColumn($alias . '.maturity_date');
            $criteria->addSelectColumn($alias . '.warning_value');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(InvoiceWarningTableMap::DATABASE_NAME)->getTable(InvoiceWarningTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(InvoiceWarningTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(InvoiceWarningTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new InvoiceWarningTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a InvoiceWarning or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or InvoiceWarning object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(InvoiceWarningTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \API\Models\ORM\Invoice\InvoiceWarning) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(InvoiceWarningTableMap::DATABASE_NAME);
            $criteria->add(InvoiceWarningTableMap::COL_INVOICE_WARNINGID, (array) $values, Criteria::IN);
        }

        $query = InvoiceWarningQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            InvoiceWarningTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                InvoiceWarningTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the invoice_warning table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return InvoiceWarningQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a InvoiceWarning or Criteria object.
     *
     * @param mixed               $criteria Criteria or InvoiceWarning object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(InvoiceWarningTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from InvoiceWarning object
        }

        if ($criteria->containsKey(InvoiceWarningTableMap::COL_INVOICE_WARNINGID) && $criteria->keyContainsValue(InvoiceWarningTableMap::COL_INVOICE_WARNINGID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.InvoiceWarningTableMap::COL_INVOICE_WARNINGID.')');
        }


        // Set the correct dbName
        $query = InvoiceWarningQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // InvoiceWarningTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
InvoiceWarningTableMap::buildTableMap();
