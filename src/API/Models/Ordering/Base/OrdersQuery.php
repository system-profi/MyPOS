<?php

namespace API\Models\Ordering\Base;

use \Exception;
use \PDO;
use API\Models\Event\Events;
use API\Models\Event\EventsTables;
use API\Models\OIP\OrdersInProgress;
use API\Models\Ordering\Orders as ChildOrders;
use API\Models\Ordering\OrdersQuery as ChildOrdersQuery;
use API\Models\Ordering\Map\OrdersTableMap;
use API\Models\User\Users;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'orders' table.
 *
 *
 *
 * @method     ChildOrdersQuery orderByOrderid($order = Criteria::ASC) Order by the orderid column
 * @method     ChildOrdersQuery orderByEventid($order = Criteria::ASC) Order by the eventid column
 * @method     ChildOrdersQuery orderByTableid($order = Criteria::ASC) Order by the tableid column
 * @method     ChildOrdersQuery orderByUserid($order = Criteria::ASC) Order by the userid column
 * @method     ChildOrdersQuery orderByOrdertime($order = Criteria::ASC) Order by the ordertime column
 * @method     ChildOrdersQuery orderByPriority($order = Criteria::ASC) Order by the priority column
 * @method     ChildOrdersQuery orderByFinished($order = Criteria::ASC) Order by the finished column
 *
 * @method     ChildOrdersQuery groupByOrderid() Group by the orderid column
 * @method     ChildOrdersQuery groupByEventid() Group by the eventid column
 * @method     ChildOrdersQuery groupByTableid() Group by the tableid column
 * @method     ChildOrdersQuery groupByUserid() Group by the userid column
 * @method     ChildOrdersQuery groupByOrdertime() Group by the ordertime column
 * @method     ChildOrdersQuery groupByPriority() Group by the priority column
 * @method     ChildOrdersQuery groupByFinished() Group by the finished column
 *
 * @method     ChildOrdersQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildOrdersQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildOrdersQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildOrdersQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildOrdersQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildOrdersQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildOrdersQuery leftJoinEvents($relationAlias = null) Adds a LEFT JOIN clause to the query using the Events relation
 * @method     ChildOrdersQuery rightJoinEvents($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Events relation
 * @method     ChildOrdersQuery innerJoinEvents($relationAlias = null) Adds a INNER JOIN clause to the query using the Events relation
 *
 * @method     ChildOrdersQuery joinWithEvents($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Events relation
 *
 * @method     ChildOrdersQuery leftJoinWithEvents() Adds a LEFT JOIN clause and with to the query using the Events relation
 * @method     ChildOrdersQuery rightJoinWithEvents() Adds a RIGHT JOIN clause and with to the query using the Events relation
 * @method     ChildOrdersQuery innerJoinWithEvents() Adds a INNER JOIN clause and with to the query using the Events relation
 *
 * @method     ChildOrdersQuery leftJoinEventsTables($relationAlias = null) Adds a LEFT JOIN clause to the query using the EventsTables relation
 * @method     ChildOrdersQuery rightJoinEventsTables($relationAlias = null) Adds a RIGHT JOIN clause to the query using the EventsTables relation
 * @method     ChildOrdersQuery innerJoinEventsTables($relationAlias = null) Adds a INNER JOIN clause to the query using the EventsTables relation
 *
 * @method     ChildOrdersQuery joinWithEventsTables($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the EventsTables relation
 *
 * @method     ChildOrdersQuery leftJoinWithEventsTables() Adds a LEFT JOIN clause and with to the query using the EventsTables relation
 * @method     ChildOrdersQuery rightJoinWithEventsTables() Adds a RIGHT JOIN clause and with to the query using the EventsTables relation
 * @method     ChildOrdersQuery innerJoinWithEventsTables() Adds a INNER JOIN clause and with to the query using the EventsTables relation
 *
 * @method     ChildOrdersQuery leftJoinUsers($relationAlias = null) Adds a LEFT JOIN clause to the query using the Users relation
 * @method     ChildOrdersQuery rightJoinUsers($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Users relation
 * @method     ChildOrdersQuery innerJoinUsers($relationAlias = null) Adds a INNER JOIN clause to the query using the Users relation
 *
 * @method     ChildOrdersQuery joinWithUsers($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Users relation
 *
 * @method     ChildOrdersQuery leftJoinWithUsers() Adds a LEFT JOIN clause and with to the query using the Users relation
 * @method     ChildOrdersQuery rightJoinWithUsers() Adds a RIGHT JOIN clause and with to the query using the Users relation
 * @method     ChildOrdersQuery innerJoinWithUsers() Adds a INNER JOIN clause and with to the query using the Users relation
 *
 * @method     ChildOrdersQuery leftJoinOrdersDetails($relationAlias = null) Adds a LEFT JOIN clause to the query using the OrdersDetails relation
 * @method     ChildOrdersQuery rightJoinOrdersDetails($relationAlias = null) Adds a RIGHT JOIN clause to the query using the OrdersDetails relation
 * @method     ChildOrdersQuery innerJoinOrdersDetails($relationAlias = null) Adds a INNER JOIN clause to the query using the OrdersDetails relation
 *
 * @method     ChildOrdersQuery joinWithOrdersDetails($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the OrdersDetails relation
 *
 * @method     ChildOrdersQuery leftJoinWithOrdersDetails() Adds a LEFT JOIN clause and with to the query using the OrdersDetails relation
 * @method     ChildOrdersQuery rightJoinWithOrdersDetails() Adds a RIGHT JOIN clause and with to the query using the OrdersDetails relation
 * @method     ChildOrdersQuery innerJoinWithOrdersDetails() Adds a INNER JOIN clause and with to the query using the OrdersDetails relation
 *
 * @method     ChildOrdersQuery leftJoinOrdersInProgress($relationAlias = null) Adds a LEFT JOIN clause to the query using the OrdersInProgress relation
 * @method     ChildOrdersQuery rightJoinOrdersInProgress($relationAlias = null) Adds a RIGHT JOIN clause to the query using the OrdersInProgress relation
 * @method     ChildOrdersQuery innerJoinOrdersInProgress($relationAlias = null) Adds a INNER JOIN clause to the query using the OrdersInProgress relation
 *
 * @method     ChildOrdersQuery joinWithOrdersInProgress($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the OrdersInProgress relation
 *
 * @method     ChildOrdersQuery leftJoinWithOrdersInProgress() Adds a LEFT JOIN clause and with to the query using the OrdersInProgress relation
 * @method     ChildOrdersQuery rightJoinWithOrdersInProgress() Adds a RIGHT JOIN clause and with to the query using the OrdersInProgress relation
 * @method     ChildOrdersQuery innerJoinWithOrdersInProgress() Adds a INNER JOIN clause and with to the query using the OrdersInProgress relation
 *
 * @method     \API\Models\Event\EventsQuery|\API\Models\Event\EventsTablesQuery|\API\Models\User\UsersQuery|\API\Models\Ordering\OrdersDetailsQuery|\API\Models\OIP\OrdersInProgressQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildOrders findOne(ConnectionInterface $con = null) Return the first ChildOrders matching the query
 * @method     ChildOrders findOneOrCreate(ConnectionInterface $con = null) Return the first ChildOrders matching the query, or a new ChildOrders object populated from the query conditions when no match is found
 *
 * @method     ChildOrders findOneByOrderid(int $orderid) Return the first ChildOrders filtered by the orderid column
 * @method     ChildOrders findOneByEventid(int $eventid) Return the first ChildOrders filtered by the eventid column
 * @method     ChildOrders findOneByTableid(int $tableid) Return the first ChildOrders filtered by the tableid column
 * @method     ChildOrders findOneByUserid(int $userid) Return the first ChildOrders filtered by the userid column
 * @method     ChildOrders findOneByOrdertime(string $ordertime) Return the first ChildOrders filtered by the ordertime column
 * @method     ChildOrders findOneByPriority(int $priority) Return the first ChildOrders filtered by the priority column
 * @method     ChildOrders findOneByFinished(string $finished) Return the first ChildOrders filtered by the finished column *

 * @method     ChildOrders requirePk($key, ConnectionInterface $con = null) Return the ChildOrders by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOrders requireOne(ConnectionInterface $con = null) Return the first ChildOrders matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildOrders requireOneByOrderid(int $orderid) Return the first ChildOrders filtered by the orderid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOrders requireOneByEventid(int $eventid) Return the first ChildOrders filtered by the eventid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOrders requireOneByTableid(int $tableid) Return the first ChildOrders filtered by the tableid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOrders requireOneByUserid(int $userid) Return the first ChildOrders filtered by the userid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOrders requireOneByOrdertime(string $ordertime) Return the first ChildOrders filtered by the ordertime column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOrders requireOneByPriority(int $priority) Return the first ChildOrders filtered by the priority column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOrders requireOneByFinished(string $finished) Return the first ChildOrders filtered by the finished column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildOrders[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildOrders objects based on current ModelCriteria
 * @method     ChildOrders[]|ObjectCollection findByOrderid(int $orderid) Return ChildOrders objects filtered by the orderid column
 * @method     ChildOrders[]|ObjectCollection findByEventid(int $eventid) Return ChildOrders objects filtered by the eventid column
 * @method     ChildOrders[]|ObjectCollection findByTableid(int $tableid) Return ChildOrders objects filtered by the tableid column
 * @method     ChildOrders[]|ObjectCollection findByUserid(int $userid) Return ChildOrders objects filtered by the userid column
 * @method     ChildOrders[]|ObjectCollection findByOrdertime(string $ordertime) Return ChildOrders objects filtered by the ordertime column
 * @method     ChildOrders[]|ObjectCollection findByPriority(int $priority) Return ChildOrders objects filtered by the priority column
 * @method     ChildOrders[]|ObjectCollection findByFinished(string $finished) Return ChildOrders objects filtered by the finished column
 * @method     ChildOrders[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class OrdersQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \API\Models\Ordering\Base\OrdersQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\API\\Models\\Ordering\\Orders', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildOrdersQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildOrdersQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildOrdersQuery) {
            return $criteria;
        }
        $query = new ChildOrdersQuery();
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
     * $obj = $c->findPk(array(12, 34, 56, 78), $con);
     * </code>
     *
     * @param array[$orderid, $eventid, $tableid, $userid] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildOrders|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(OrdersTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = OrdersTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1]), (null === $key[2] || is_scalar($key[2]) || is_callable([$key[2], '__toString']) ? (string) $key[2] : $key[2]), (null === $key[3] || is_scalar($key[3]) || is_callable([$key[3], '__toString']) ? (string) $key[3] : $key[3])]))))) {
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
     * @return ChildOrders A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT orderid, eventid, tableid, userid, ordertime, priority, finished FROM orders WHERE orderid = :p0 AND eventid = :p1 AND tableid = :p2 AND userid = :p3';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->bindValue(':p2', $key[2], PDO::PARAM_INT);
            $stmt->bindValue(':p3', $key[3], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildOrders $obj */
            $obj = new ChildOrders();
            $obj->hydrate($row);
            OrdersTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1]), (null === $key[2] || is_scalar($key[2]) || is_callable([$key[2], '__toString']) ? (string) $key[2] : $key[2]), (null === $key[3] || is_scalar($key[3]) || is_callable([$key[3], '__toString']) ? (string) $key[3] : $key[3])]));
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
     * @return ChildOrders|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildOrdersQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(OrdersTableMap::COL_ORDERID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(OrdersTableMap::COL_EVENTID, $key[1], Criteria::EQUAL);
        $this->addUsingAlias(OrdersTableMap::COL_TABLEID, $key[2], Criteria::EQUAL);
        $this->addUsingAlias(OrdersTableMap::COL_USERID, $key[3], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildOrdersQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(OrdersTableMap::COL_ORDERID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(OrdersTableMap::COL_EVENTID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $cton2 = $this->getNewCriterion(OrdersTableMap::COL_TABLEID, $key[2], Criteria::EQUAL);
            $cton0->addAnd($cton2);
            $cton3 = $this->getNewCriterion(OrdersTableMap::COL_USERID, $key[3], Criteria::EQUAL);
            $cton0->addAnd($cton3);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the orderid column
     *
     * Example usage:
     * <code>
     * $query->filterByOrderid(1234); // WHERE orderid = 1234
     * $query->filterByOrderid(array(12, 34)); // WHERE orderid IN (12, 34)
     * $query->filterByOrderid(array('min' => 12)); // WHERE orderid > 12
     * </code>
     *
     * @param     mixed $orderid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOrdersQuery The current query, for fluid interface
     */
    public function filterByOrderid($orderid = null, $comparison = null)
    {
        if (is_array($orderid)) {
            $useMinMax = false;
            if (isset($orderid['min'])) {
                $this->addUsingAlias(OrdersTableMap::COL_ORDERID, $orderid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orderid['max'])) {
                $this->addUsingAlias(OrdersTableMap::COL_ORDERID, $orderid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrdersTableMap::COL_ORDERID, $orderid, $comparison);
    }

    /**
     * Filter the query on the eventid column
     *
     * Example usage:
     * <code>
     * $query->filterByEventid(1234); // WHERE eventid = 1234
     * $query->filterByEventid(array(12, 34)); // WHERE eventid IN (12, 34)
     * $query->filterByEventid(array('min' => 12)); // WHERE eventid > 12
     * </code>
     *
     * @see       filterByEvents()
     *
     * @param     mixed $eventid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOrdersQuery The current query, for fluid interface
     */
    public function filterByEventid($eventid = null, $comparison = null)
    {
        if (is_array($eventid)) {
            $useMinMax = false;
            if (isset($eventid['min'])) {
                $this->addUsingAlias(OrdersTableMap::COL_EVENTID, $eventid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($eventid['max'])) {
                $this->addUsingAlias(OrdersTableMap::COL_EVENTID, $eventid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrdersTableMap::COL_EVENTID, $eventid, $comparison);
    }

    /**
     * Filter the query on the tableid column
     *
     * Example usage:
     * <code>
     * $query->filterByTableid(1234); // WHERE tableid = 1234
     * $query->filterByTableid(array(12, 34)); // WHERE tableid IN (12, 34)
     * $query->filterByTableid(array('min' => 12)); // WHERE tableid > 12
     * </code>
     *
     * @see       filterByEventsTables()
     *
     * @param     mixed $tableid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOrdersQuery The current query, for fluid interface
     */
    public function filterByTableid($tableid = null, $comparison = null)
    {
        if (is_array($tableid)) {
            $useMinMax = false;
            if (isset($tableid['min'])) {
                $this->addUsingAlias(OrdersTableMap::COL_TABLEID, $tableid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($tableid['max'])) {
                $this->addUsingAlias(OrdersTableMap::COL_TABLEID, $tableid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrdersTableMap::COL_TABLEID, $tableid, $comparison);
    }

    /**
     * Filter the query on the userid column
     *
     * Example usage:
     * <code>
     * $query->filterByUserid(1234); // WHERE userid = 1234
     * $query->filterByUserid(array(12, 34)); // WHERE userid IN (12, 34)
     * $query->filterByUserid(array('min' => 12)); // WHERE userid > 12
     * </code>
     *
     * @see       filterByUsers()
     *
     * @param     mixed $userid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOrdersQuery The current query, for fluid interface
     */
    public function filterByUserid($userid = null, $comparison = null)
    {
        if (is_array($userid)) {
            $useMinMax = false;
            if (isset($userid['min'])) {
                $this->addUsingAlias(OrdersTableMap::COL_USERID, $userid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userid['max'])) {
                $this->addUsingAlias(OrdersTableMap::COL_USERID, $userid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrdersTableMap::COL_USERID, $userid, $comparison);
    }

    /**
     * Filter the query on the ordertime column
     *
     * Example usage:
     * <code>
     * $query->filterByOrdertime('2011-03-14'); // WHERE ordertime = '2011-03-14'
     * $query->filterByOrdertime('now'); // WHERE ordertime = '2011-03-14'
     * $query->filterByOrdertime(array('max' => 'yesterday')); // WHERE ordertime > '2011-03-13'
     * </code>
     *
     * @param     mixed $ordertime The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOrdersQuery The current query, for fluid interface
     */
    public function filterByOrdertime($ordertime = null, $comparison = null)
    {
        if (is_array($ordertime)) {
            $useMinMax = false;
            if (isset($ordertime['min'])) {
                $this->addUsingAlias(OrdersTableMap::COL_ORDERTIME, $ordertime['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($ordertime['max'])) {
                $this->addUsingAlias(OrdersTableMap::COL_ORDERTIME, $ordertime['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrdersTableMap::COL_ORDERTIME, $ordertime, $comparison);
    }

    /**
     * Filter the query on the priority column
     *
     * Example usage:
     * <code>
     * $query->filterByPriority(1234); // WHERE priority = 1234
     * $query->filterByPriority(array(12, 34)); // WHERE priority IN (12, 34)
     * $query->filterByPriority(array('min' => 12)); // WHERE priority > 12
     * </code>
     *
     * @param     mixed $priority The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOrdersQuery The current query, for fluid interface
     */
    public function filterByPriority($priority = null, $comparison = null)
    {
        if (is_array($priority)) {
            $useMinMax = false;
            if (isset($priority['min'])) {
                $this->addUsingAlias(OrdersTableMap::COL_PRIORITY, $priority['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($priority['max'])) {
                $this->addUsingAlias(OrdersTableMap::COL_PRIORITY, $priority['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrdersTableMap::COL_PRIORITY, $priority, $comparison);
    }

    /**
     * Filter the query on the finished column
     *
     * Example usage:
     * <code>
     * $query->filterByFinished('2011-03-14'); // WHERE finished = '2011-03-14'
     * $query->filterByFinished('now'); // WHERE finished = '2011-03-14'
     * $query->filterByFinished(array('max' => 'yesterday')); // WHERE finished > '2011-03-13'
     * </code>
     *
     * @param     mixed $finished The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOrdersQuery The current query, for fluid interface
     */
    public function filterByFinished($finished = null, $comparison = null)
    {
        if (is_array($finished)) {
            $useMinMax = false;
            if (isset($finished['min'])) {
                $this->addUsingAlias(OrdersTableMap::COL_FINISHED, $finished['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($finished['max'])) {
                $this->addUsingAlias(OrdersTableMap::COL_FINISHED, $finished['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrdersTableMap::COL_FINISHED, $finished, $comparison);
    }

    /**
     * Filter the query by a related \API\Models\Event\Events object
     *
     * @param \API\Models\Event\Events|ObjectCollection $events The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildOrdersQuery The current query, for fluid interface
     */
    public function filterByEvents($events, $comparison = null)
    {
        if ($events instanceof \API\Models\Event\Events) {
            return $this
                ->addUsingAlias(OrdersTableMap::COL_EVENTID, $events->getEventid(), $comparison);
        } elseif ($events instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(OrdersTableMap::COL_EVENTID, $events->toKeyValue('PrimaryKey', 'Eventid'), $comparison);
        } else {
            throw new PropelException('filterByEvents() only accepts arguments of type \API\Models\Event\Events or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Events relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildOrdersQuery The current query, for fluid interface
     */
    public function joinEvents($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Events');

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
            $this->addJoinObject($join, 'Events');
        }

        return $this;
    }

    /**
     * Use the Events relation Events object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \API\Models\Event\EventsQuery A secondary query class using the current class as primary query
     */
    public function useEventsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinEvents($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Events', '\API\Models\Event\EventsQuery');
    }

    /**
     * Filter the query by a related \API\Models\Event\EventsTables object
     *
     * @param \API\Models\Event\EventsTables|ObjectCollection $eventsTables The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildOrdersQuery The current query, for fluid interface
     */
    public function filterByEventsTables($eventsTables, $comparison = null)
    {
        if ($eventsTables instanceof \API\Models\Event\EventsTables) {
            return $this
                ->addUsingAlias(OrdersTableMap::COL_TABLEID, $eventsTables->getEventsTableid(), $comparison);
        } elseif ($eventsTables instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(OrdersTableMap::COL_TABLEID, $eventsTables->toKeyValue('EventsTableid', 'EventsTableid'), $comparison);
        } else {
            throw new PropelException('filterByEventsTables() only accepts arguments of type \API\Models\Event\EventsTables or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the EventsTables relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildOrdersQuery The current query, for fluid interface
     */
    public function joinEventsTables($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('EventsTables');

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
            $this->addJoinObject($join, 'EventsTables');
        }

        return $this;
    }

    /**
     * Use the EventsTables relation EventsTables object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \API\Models\Event\EventsTablesQuery A secondary query class using the current class as primary query
     */
    public function useEventsTablesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinEventsTables($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'EventsTables', '\API\Models\Event\EventsTablesQuery');
    }

    /**
     * Filter the query by a related \API\Models\User\Users object
     *
     * @param \API\Models\User\Users|ObjectCollection $users The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildOrdersQuery The current query, for fluid interface
     */
    public function filterByUsers($users, $comparison = null)
    {
        if ($users instanceof \API\Models\User\Users) {
            return $this
                ->addUsingAlias(OrdersTableMap::COL_USERID, $users->getUserid(), $comparison);
        } elseif ($users instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(OrdersTableMap::COL_USERID, $users->toKeyValue('PrimaryKey', 'Userid'), $comparison);
        } else {
            throw new PropelException('filterByUsers() only accepts arguments of type \API\Models\User\Users or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Users relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildOrdersQuery The current query, for fluid interface
     */
    public function joinUsers($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Users');

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
            $this->addJoinObject($join, 'Users');
        }

        return $this;
    }

    /**
     * Use the Users relation Users object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \API\Models\User\UsersQuery A secondary query class using the current class as primary query
     */
    public function useUsersQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUsers($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Users', '\API\Models\User\UsersQuery');
    }

    /**
     * Filter the query by a related \API\Models\Ordering\OrdersDetails object
     *
     * @param \API\Models\Ordering\OrdersDetails|ObjectCollection $ordersDetails the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrdersQuery The current query, for fluid interface
     */
    public function filterByOrdersDetails($ordersDetails, $comparison = null)
    {
        if ($ordersDetails instanceof \API\Models\Ordering\OrdersDetails) {
            return $this
                ->addUsingAlias(OrdersTableMap::COL_ORDERID, $ordersDetails->getOrderid(), $comparison);
        } elseif ($ordersDetails instanceof ObjectCollection) {
            return $this
                ->useOrdersDetailsQuery()
                ->filterByPrimaryKeys($ordersDetails->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByOrdersDetails() only accepts arguments of type \API\Models\Ordering\OrdersDetails or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the OrdersDetails relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildOrdersQuery The current query, for fluid interface
     */
    public function joinOrdersDetails($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
     * @return \API\Models\Ordering\OrdersDetailsQuery A secondary query class using the current class as primary query
     */
    public function useOrdersDetailsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinOrdersDetails($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'OrdersDetails', '\API\Models\Ordering\OrdersDetailsQuery');
    }

    /**
     * Filter the query by a related \API\Models\OIP\OrdersInProgress object
     *
     * @param \API\Models\OIP\OrdersInProgress|ObjectCollection $ordersInProgress the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrdersQuery The current query, for fluid interface
     */
    public function filterByOrdersInProgress($ordersInProgress, $comparison = null)
    {
        if ($ordersInProgress instanceof \API\Models\OIP\OrdersInProgress) {
            return $this
                ->addUsingAlias(OrdersTableMap::COL_ORDERID, $ordersInProgress->getOrderid(), $comparison);
        } elseif ($ordersInProgress instanceof ObjectCollection) {
            return $this
                ->useOrdersInProgressQuery()
                ->filterByPrimaryKeys($ordersInProgress->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByOrdersInProgress() only accepts arguments of type \API\Models\OIP\OrdersInProgress or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the OrdersInProgress relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildOrdersQuery The current query, for fluid interface
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
     * @return \API\Models\OIP\OrdersInProgressQuery A secondary query class using the current class as primary query
     */
    public function useOrdersInProgressQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinOrdersInProgress($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'OrdersInProgress', '\API\Models\OIP\OrdersInProgressQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildOrders $orders Object to remove from the list of results
     *
     * @return $this|ChildOrdersQuery The current query, for fluid interface
     */
    public function prune($orders = null)
    {
        if ($orders) {
            $this->addCond('pruneCond0', $this->getAliasedColName(OrdersTableMap::COL_ORDERID), $orders->getOrderid(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(OrdersTableMap::COL_EVENTID), $orders->getEventid(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond2', $this->getAliasedColName(OrdersTableMap::COL_TABLEID), $orders->getTableid(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond3', $this->getAliasedColName(OrdersTableMap::COL_USERID), $orders->getUserid(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1', 'pruneCond2', 'pruneCond3'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the orders table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OrdersTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            OrdersTableMap::clearInstancePool();
            OrdersTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(OrdersTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(OrdersTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            OrdersTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            OrdersTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // OrdersQuery