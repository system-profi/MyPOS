<?php

namespace Model\Menues\Base;

use \Exception;
use \PDO;
use Model\DistributionPlace\DistributionsPlacesGroupes;
use Model\DistributionPlace\DistributionsPlacesTables;
use Model\Menues\MenuGroupes as ChildMenuGroupes;
use Model\Menues\MenuGroupesQuery as ChildMenuGroupesQuery;
use Model\Menues\Map\MenuGroupesTableMap;
use Model\OIP\OrdersInProgress;
use Model\Ordering\OrdersDetails;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'menu_groupes' table.
 *
 *
 *
 * @method     ChildMenuGroupesQuery orderByMenuGroupid($order = Criteria::ASC) Order by the menu_groupid column
 * @method     ChildMenuGroupesQuery orderByMenuTypeid($order = Criteria::ASC) Order by the menu_typeid column
 * @method     ChildMenuGroupesQuery orderByName($order = Criteria::ASC) Order by the name column
 *
 * @method     ChildMenuGroupesQuery groupByMenuGroupid() Group by the menu_groupid column
 * @method     ChildMenuGroupesQuery groupByMenuTypeid() Group by the menu_typeid column
 * @method     ChildMenuGroupesQuery groupByName() Group by the name column
 *
 * @method     ChildMenuGroupesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMenuGroupesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMenuGroupesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMenuGroupesQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildMenuGroupesQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildMenuGroupesQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildMenuGroupesQuery leftJoinMenuTypes($relationAlias = null) Adds a LEFT JOIN clause to the query using the MenuTypes relation
 * @method     ChildMenuGroupesQuery rightJoinMenuTypes($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MenuTypes relation
 * @method     ChildMenuGroupesQuery innerJoinMenuTypes($relationAlias = null) Adds a INNER JOIN clause to the query using the MenuTypes relation
 *
 * @method     ChildMenuGroupesQuery joinWithMenuTypes($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the MenuTypes relation
 *
 * @method     ChildMenuGroupesQuery leftJoinWithMenuTypes() Adds a LEFT JOIN clause and with to the query using the MenuTypes relation
 * @method     ChildMenuGroupesQuery rightJoinWithMenuTypes() Adds a RIGHT JOIN clause and with to the query using the MenuTypes relation
 * @method     ChildMenuGroupesQuery innerJoinWithMenuTypes() Adds a INNER JOIN clause and with to the query using the MenuTypes relation
 *
 * @method     ChildMenuGroupesQuery leftJoinDistributionsPlacesGroupes($relationAlias = null) Adds a LEFT JOIN clause to the query using the DistributionsPlacesGroupes relation
 * @method     ChildMenuGroupesQuery rightJoinDistributionsPlacesGroupes($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DistributionsPlacesGroupes relation
 * @method     ChildMenuGroupesQuery innerJoinDistributionsPlacesGroupes($relationAlias = null) Adds a INNER JOIN clause to the query using the DistributionsPlacesGroupes relation
 *
 * @method     ChildMenuGroupesQuery joinWithDistributionsPlacesGroupes($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the DistributionsPlacesGroupes relation
 *
 * @method     ChildMenuGroupesQuery leftJoinWithDistributionsPlacesGroupes() Adds a LEFT JOIN clause and with to the query using the DistributionsPlacesGroupes relation
 * @method     ChildMenuGroupesQuery rightJoinWithDistributionsPlacesGroupes() Adds a RIGHT JOIN clause and with to the query using the DistributionsPlacesGroupes relation
 * @method     ChildMenuGroupesQuery innerJoinWithDistributionsPlacesGroupes() Adds a INNER JOIN clause and with to the query using the DistributionsPlacesGroupes relation
 *
 * @method     ChildMenuGroupesQuery leftJoinDistributionsPlacesTables($relationAlias = null) Adds a LEFT JOIN clause to the query using the DistributionsPlacesTables relation
 * @method     ChildMenuGroupesQuery rightJoinDistributionsPlacesTables($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DistributionsPlacesTables relation
 * @method     ChildMenuGroupesQuery innerJoinDistributionsPlacesTables($relationAlias = null) Adds a INNER JOIN clause to the query using the DistributionsPlacesTables relation
 *
 * @method     ChildMenuGroupesQuery joinWithDistributionsPlacesTables($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the DistributionsPlacesTables relation
 *
 * @method     ChildMenuGroupesQuery leftJoinWithDistributionsPlacesTables() Adds a LEFT JOIN clause and with to the query using the DistributionsPlacesTables relation
 * @method     ChildMenuGroupesQuery rightJoinWithDistributionsPlacesTables() Adds a RIGHT JOIN clause and with to the query using the DistributionsPlacesTables relation
 * @method     ChildMenuGroupesQuery innerJoinWithDistributionsPlacesTables() Adds a INNER JOIN clause and with to the query using the DistributionsPlacesTables relation
 *
 * @method     ChildMenuGroupesQuery leftJoinMenues($relationAlias = null) Adds a LEFT JOIN clause to the query using the Menues relation
 * @method     ChildMenuGroupesQuery rightJoinMenues($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Menues relation
 * @method     ChildMenuGroupesQuery innerJoinMenues($relationAlias = null) Adds a INNER JOIN clause to the query using the Menues relation
 *
 * @method     ChildMenuGroupesQuery joinWithMenues($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Menues relation
 *
 * @method     ChildMenuGroupesQuery leftJoinWithMenues() Adds a LEFT JOIN clause and with to the query using the Menues relation
 * @method     ChildMenuGroupesQuery rightJoinWithMenues() Adds a RIGHT JOIN clause and with to the query using the Menues relation
 * @method     ChildMenuGroupesQuery innerJoinWithMenues() Adds a INNER JOIN clause and with to the query using the Menues relation
 *
 * @method     ChildMenuGroupesQuery leftJoinOrdersDetails($relationAlias = null) Adds a LEFT JOIN clause to the query using the OrdersDetails relation
 * @method     ChildMenuGroupesQuery rightJoinOrdersDetails($relationAlias = null) Adds a RIGHT JOIN clause to the query using the OrdersDetails relation
 * @method     ChildMenuGroupesQuery innerJoinOrdersDetails($relationAlias = null) Adds a INNER JOIN clause to the query using the OrdersDetails relation
 *
 * @method     ChildMenuGroupesQuery joinWithOrdersDetails($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the OrdersDetails relation
 *
 * @method     ChildMenuGroupesQuery leftJoinWithOrdersDetails() Adds a LEFT JOIN clause and with to the query using the OrdersDetails relation
 * @method     ChildMenuGroupesQuery rightJoinWithOrdersDetails() Adds a RIGHT JOIN clause and with to the query using the OrdersDetails relation
 * @method     ChildMenuGroupesQuery innerJoinWithOrdersDetails() Adds a INNER JOIN clause and with to the query using the OrdersDetails relation
 *
 * @method     ChildMenuGroupesQuery leftJoinOrdersInProgress($relationAlias = null) Adds a LEFT JOIN clause to the query using the OrdersInProgress relation
 * @method     ChildMenuGroupesQuery rightJoinOrdersInProgress($relationAlias = null) Adds a RIGHT JOIN clause to the query using the OrdersInProgress relation
 * @method     ChildMenuGroupesQuery innerJoinOrdersInProgress($relationAlias = null) Adds a INNER JOIN clause to the query using the OrdersInProgress relation
 *
 * @method     ChildMenuGroupesQuery joinWithOrdersInProgress($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the OrdersInProgress relation
 *
 * @method     ChildMenuGroupesQuery leftJoinWithOrdersInProgress() Adds a LEFT JOIN clause and with to the query using the OrdersInProgress relation
 * @method     ChildMenuGroupesQuery rightJoinWithOrdersInProgress() Adds a RIGHT JOIN clause and with to the query using the OrdersInProgress relation
 * @method     ChildMenuGroupesQuery innerJoinWithOrdersInProgress() Adds a INNER JOIN clause and with to the query using the OrdersInProgress relation
 *
 * @method     \Model\Menues\MenuTypesQuery|\Model\DistributionPlace\DistributionsPlacesGroupesQuery|\Model\DistributionPlace\DistributionsPlacesTablesQuery|\Model\Menues\MenuesQuery|\Model\Ordering\OrdersDetailsQuery|\Model\OIP\OrdersInProgressQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildMenuGroupes findOne(ConnectionInterface $con = null) Return the first ChildMenuGroupes matching the query
 * @method     ChildMenuGroupes findOneOrCreate(ConnectionInterface $con = null) Return the first ChildMenuGroupes matching the query, or a new ChildMenuGroupes object populated from the query conditions when no match is found
 *
 * @method     ChildMenuGroupes findOneByMenuGroupid(int $menu_groupid) Return the first ChildMenuGroupes filtered by the menu_groupid column
 * @method     ChildMenuGroupes findOneByMenuTypeid(int $menu_typeid) Return the first ChildMenuGroupes filtered by the menu_typeid column
 * @method     ChildMenuGroupes findOneByName(string $name) Return the first ChildMenuGroupes filtered by the name column *

 * @method     ChildMenuGroupes requirePk($key, ConnectionInterface $con = null) Return the ChildMenuGroupes by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMenuGroupes requireOne(ConnectionInterface $con = null) Return the first ChildMenuGroupes matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMenuGroupes requireOneByMenuGroupid(int $menu_groupid) Return the first ChildMenuGroupes filtered by the menu_groupid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMenuGroupes requireOneByMenuTypeid(int $menu_typeid) Return the first ChildMenuGroupes filtered by the menu_typeid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMenuGroupes requireOneByName(string $name) Return the first ChildMenuGroupes filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMenuGroupes[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildMenuGroupes objects based on current ModelCriteria
 * @method     ChildMenuGroupes[]|ObjectCollection findByMenuGroupid(int $menu_groupid) Return ChildMenuGroupes objects filtered by the menu_groupid column
 * @method     ChildMenuGroupes[]|ObjectCollection findByMenuTypeid(int $menu_typeid) Return ChildMenuGroupes objects filtered by the menu_typeid column
 * @method     ChildMenuGroupes[]|ObjectCollection findByName(string $name) Return ChildMenuGroupes objects filtered by the name column
 * @method     ChildMenuGroupes[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class MenuGroupesQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Model\Menues\Base\MenuGroupesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Model\\Menues\\MenuGroupes', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMenuGroupesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMenuGroupesQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildMenuGroupesQuery) {
            return $criteria;
        }
        $query = new ChildMenuGroupesQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$menu_groupid, $menu_typeid] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildMenuGroupes|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MenuGroupesTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = MenuGroupesTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildMenuGroupes A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT menu_groupid, menu_typeid, name FROM menu_groupes WHERE menu_groupid = :p0 AND menu_typeid = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildMenuGroupes $obj */
            $obj = new ChildMenuGroupes();
            $obj->hydrate($row);
            MenuGroupesTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildMenuGroupes|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildMenuGroupesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(MenuGroupesTableMap::COL_MENU_GROUPID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(MenuGroupesTableMap::COL_MENU_TYPEID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildMenuGroupesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(MenuGroupesTableMap::COL_MENU_GROUPID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(MenuGroupesTableMap::COL_MENU_TYPEID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the menu_groupid column
     *
     * Example usage:
     * <code>
     * $query->filterByMenuGroupid(1234); // WHERE menu_groupid = 1234
     * $query->filterByMenuGroupid(array(12, 34)); // WHERE menu_groupid IN (12, 34)
     * $query->filterByMenuGroupid(array('min' => 12)); // WHERE menu_groupid > 12
     * </code>
     *
     * @param     mixed $menuGroupid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMenuGroupesQuery The current query, for fluid interface
     */
    public function filterByMenuGroupid($menuGroupid = null, $comparison = null)
    {
        if (is_array($menuGroupid)) {
            $useMinMax = false;
            if (isset($menuGroupid['min'])) {
                $this->addUsingAlias(MenuGroupesTableMap::COL_MENU_GROUPID, $menuGroupid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($menuGroupid['max'])) {
                $this->addUsingAlias(MenuGroupesTableMap::COL_MENU_GROUPID, $menuGroupid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MenuGroupesTableMap::COL_MENU_GROUPID, $menuGroupid, $comparison);
    }

    /**
     * Filter the query on the menu_typeid column
     *
     * Example usage:
     * <code>
     * $query->filterByMenuTypeid(1234); // WHERE menu_typeid = 1234
     * $query->filterByMenuTypeid(array(12, 34)); // WHERE menu_typeid IN (12, 34)
     * $query->filterByMenuTypeid(array('min' => 12)); // WHERE menu_typeid > 12
     * </code>
     *
     * @see       filterByMenuTypes()
     *
     * @param     mixed $menuTypeid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMenuGroupesQuery The current query, for fluid interface
     */
    public function filterByMenuTypeid($menuTypeid = null, $comparison = null)
    {
        if (is_array($menuTypeid)) {
            $useMinMax = false;
            if (isset($menuTypeid['min'])) {
                $this->addUsingAlias(MenuGroupesTableMap::COL_MENU_TYPEID, $menuTypeid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($menuTypeid['max'])) {
                $this->addUsingAlias(MenuGroupesTableMap::COL_MENU_TYPEID, $menuTypeid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MenuGroupesTableMap::COL_MENU_TYPEID, $menuTypeid, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMenuGroupesQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MenuGroupesTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query by a related \Model\Menues\MenuTypes object
     *
     * @param \Model\Menues\MenuTypes|ObjectCollection $menuTypes The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildMenuGroupesQuery The current query, for fluid interface
     */
    public function filterByMenuTypes($menuTypes, $comparison = null)
    {
        if ($menuTypes instanceof \Model\Menues\MenuTypes) {
            return $this
                ->addUsingAlias(MenuGroupesTableMap::COL_MENU_TYPEID, $menuTypes->getMenuTypeid(), $comparison);
        } elseif ($menuTypes instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MenuGroupesTableMap::COL_MENU_TYPEID, $menuTypes->toKeyValue('MenuTypeid', 'MenuTypeid'), $comparison);
        } else {
            throw new PropelException('filterByMenuTypes() only accepts arguments of type \Model\Menues\MenuTypes or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MenuTypes relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMenuGroupesQuery The current query, for fluid interface
     */
    public function joinMenuTypes($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MenuTypes');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'MenuTypes');
        }

        return $this;
    }

    /**
     * Use the MenuTypes relation MenuTypes object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\Menues\MenuTypesQuery A secondary query class using the current class as primary query
     */
    public function useMenuTypesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMenuTypes($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MenuTypes', '\Model\Menues\MenuTypesQuery');
    }

    /**
     * Filter the query by a related \Model\DistributionPlace\DistributionsPlacesGroupes object
     *
     * @param \Model\DistributionPlace\DistributionsPlacesGroupes|ObjectCollection $distributionsPlacesGroupes the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMenuGroupesQuery The current query, for fluid interface
     */
    public function filterByDistributionsPlacesGroupes($distributionsPlacesGroupes, $comparison = null)
    {
        if ($distributionsPlacesGroupes instanceof \Model\DistributionPlace\DistributionsPlacesGroupes) {
            return $this
                ->addUsingAlias(MenuGroupesTableMap::COL_MENU_GROUPID, $distributionsPlacesGroupes->getMenuGroupid(), $comparison);
        } elseif ($distributionsPlacesGroupes instanceof ObjectCollection) {
            return $this
                ->useDistributionsPlacesGroupesQuery()
                ->filterByPrimaryKeys($distributionsPlacesGroupes->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDistributionsPlacesGroupes() only accepts arguments of type \Model\DistributionPlace\DistributionsPlacesGroupes or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DistributionsPlacesGroupes relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMenuGroupesQuery The current query, for fluid interface
     */
    public function joinDistributionsPlacesGroupes($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('DistributionsPlacesGroupes');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'DistributionsPlacesGroupes');
        }

        return $this;
    }

    /**
     * Use the DistributionsPlacesGroupes relation DistributionsPlacesGroupes object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\DistributionPlace\DistributionsPlacesGroupesQuery A secondary query class using the current class as primary query
     */
    public function useDistributionsPlacesGroupesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDistributionsPlacesGroupes($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DistributionsPlacesGroupes', '\Model\DistributionPlace\DistributionsPlacesGroupesQuery');
    }

    /**
     * Filter the query by a related \Model\DistributionPlace\DistributionsPlacesTables object
     *
     * @param \Model\DistributionPlace\DistributionsPlacesTables|ObjectCollection $distributionsPlacesTables the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMenuGroupesQuery The current query, for fluid interface
     */
    public function filterByDistributionsPlacesTables($distributionsPlacesTables, $comparison = null)
    {
        if ($distributionsPlacesTables instanceof \Model\DistributionPlace\DistributionsPlacesTables) {
            return $this
                ->addUsingAlias(MenuGroupesTableMap::COL_MENU_GROUPID, $distributionsPlacesTables->getMenuGroupid(), $comparison);
        } elseif ($distributionsPlacesTables instanceof ObjectCollection) {
            return $this
                ->useDistributionsPlacesTablesQuery()
                ->filterByPrimaryKeys($distributionsPlacesTables->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDistributionsPlacesTables() only accepts arguments of type \Model\DistributionPlace\DistributionsPlacesTables or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DistributionsPlacesTables relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMenuGroupesQuery The current query, for fluid interface
     */
    public function joinDistributionsPlacesTables($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('DistributionsPlacesTables');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'DistributionsPlacesTables');
        }

        return $this;
    }

    /**
     * Use the DistributionsPlacesTables relation DistributionsPlacesTables object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\DistributionPlace\DistributionsPlacesTablesQuery A secondary query class using the current class as primary query
     */
    public function useDistributionsPlacesTablesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDistributionsPlacesTables($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DistributionsPlacesTables', '\Model\DistributionPlace\DistributionsPlacesTablesQuery');
    }

    /**
     * Filter the query by a related \Model\Menues\Menues object
     *
     * @param \Model\Menues\Menues|ObjectCollection $menues the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMenuGroupesQuery The current query, for fluid interface
     */
    public function filterByMenues($menues, $comparison = null)
    {
        if ($menues instanceof \Model\Menues\Menues) {
            return $this
                ->addUsingAlias(MenuGroupesTableMap::COL_MENU_GROUPID, $menues->getMenuGroupid(), $comparison);
        } elseif ($menues instanceof ObjectCollection) {
            return $this
                ->useMenuesQuery()
                ->filterByPrimaryKeys($menues->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMenues() only accepts arguments of type \Model\Menues\Menues or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Menues relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMenuGroupesQuery The current query, for fluid interface
     */
    public function joinMenues($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Menues');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Menues');
        }

        return $this;
    }

    /**
     * Use the Menues relation Menues object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\Menues\MenuesQuery A secondary query class using the current class as primary query
     */
    public function useMenuesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMenues($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Menues', '\Model\Menues\MenuesQuery');
    }

    /**
     * Filter the query by a related \Model\Ordering\OrdersDetails object
     *
     * @param \Model\Ordering\OrdersDetails|ObjectCollection $ordersDetails the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMenuGroupesQuery The current query, for fluid interface
     */
    public function filterByOrdersDetails($ordersDetails, $comparison = null)
    {
        if ($ordersDetails instanceof \Model\Ordering\OrdersDetails) {
            return $this
                ->addUsingAlias(MenuGroupesTableMap::COL_MENU_GROUPID, $ordersDetails->getMenuGroupid(), $comparison);
        } elseif ($ordersDetails instanceof ObjectCollection) {
            return $this
                ->useOrdersDetailsQuery()
                ->filterByPrimaryKeys($ordersDetails->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByOrdersDetails() only accepts arguments of type \Model\Ordering\OrdersDetails or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the OrdersDetails relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMenuGroupesQuery The current query, for fluid interface
     */
    public function joinOrdersDetails($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('OrdersDetails');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'OrdersDetails');
        }

        return $this;
    }

    /**
     * Use the OrdersDetails relation OrdersDetails object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\Ordering\OrdersDetailsQuery A secondary query class using the current class as primary query
     */
    public function useOrdersDetailsQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinOrdersDetails($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'OrdersDetails', '\Model\Ordering\OrdersDetailsQuery');
    }

    /**
     * Filter the query by a related \Model\OIP\OrdersInProgress object
     *
     * @param \Model\OIP\OrdersInProgress|ObjectCollection $ordersInProgress the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMenuGroupesQuery The current query, for fluid interface
     */
    public function filterByOrdersInProgress($ordersInProgress, $comparison = null)
    {
        if ($ordersInProgress instanceof \Model\OIP\OrdersInProgress) {
            return $this
                ->addUsingAlias(MenuGroupesTableMap::COL_MENU_GROUPID, $ordersInProgress->getMenuGroupid(), $comparison);
        } elseif ($ordersInProgress instanceof ObjectCollection) {
            return $this
                ->useOrdersInProgressQuery()
                ->filterByPrimaryKeys($ordersInProgress->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByOrdersInProgress() only accepts arguments of type \Model\OIP\OrdersInProgress or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the OrdersInProgress relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMenuGroupesQuery The current query, for fluid interface
     */
    public function joinOrdersInProgress($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('OrdersInProgress');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'OrdersInProgress');
        }

        return $this;
    }

    /**
     * Use the OrdersInProgress relation OrdersInProgress object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\OIP\OrdersInProgressQuery A secondary query class using the current class as primary query
     */
    public function useOrdersInProgressQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinOrdersInProgress($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'OrdersInProgress', '\Model\OIP\OrdersInProgressQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildMenuGroupes $menuGroupes Object to remove from the list of results
     *
     * @return $this|ChildMenuGroupesQuery The current query, for fluid interface
     */
    public function prune($menuGroupes = null)
    {
        if ($menuGroupes) {
            $this->addCond('pruneCond0', $this->getAliasedColName(MenuGroupesTableMap::COL_MENU_GROUPID), $menuGroupes->getMenuGroupid(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(MenuGroupesTableMap::COL_MENU_TYPEID), $menuGroupes->getMenuTypeid(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the menu_groupes table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MenuGroupesTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            MenuGroupesTableMap::clearInstancePool();
            MenuGroupesTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MenuGroupesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MenuGroupesTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            MenuGroupesTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            MenuGroupesTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // MenuGroupesQuery
