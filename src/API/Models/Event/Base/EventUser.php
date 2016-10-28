<?php

namespace API\Models\Event\Base;

use \Exception;
use \PDO;
use API\Models\Event\Event as ChildEvent;
use API\Models\Event\EventQuery as ChildEventQuery;
use API\Models\Event\EventUser as ChildEventUser;
use API\Models\Event\EventUserQuery as ChildEventUserQuery;
use API\Models\Event\Map\EventUserTableMap;
use API\Models\User\User;
use API\Models\User\UserQuery;
use API\Models\User\Messages\UserMessage;
use API\Models\User\Messages\UserMessageQuery;
use API\Models\User\Messages\Base\UserMessage as BaseUserMessage;
use API\Models\User\Messages\Map\UserMessageTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the 'event_user' table.
 *
 *
 *
 * @package    propel.generator.API.Models.Event.Base
 */
abstract class EventUser implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\API\\Models\\Event\\Map\\EventUserTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the event_userid field.
     *
     * @var        int
     */
    protected $event_userid;

    /**
     * The value for the eventid field.
     *
     * @var        int
     */
    protected $eventid;

    /**
     * The value for the userid field.
     *
     * @var        int
     */
    protected $userid;

    /**
     * The value for the user_roles field.
     *
     * @var        int
     */
    protected $user_roles;

    /**
     * The value for the begin_money field.
     *
     * @var        string
     */
    protected $begin_money;

    /**
     * @var        ChildEvent
     */
    protected $aEvent;

    /**
     * @var        User
     */
    protected $aUser;

    /**
     * @var        ObjectCollection|UserMessage[] Collection to store aggregation of UserMessage objects.
     */
    protected $collUserMessagesRelatedByFromEventUserid;
    protected $collUserMessagesRelatedByFromEventUseridPartial;

    /**
     * @var        ObjectCollection|UserMessage[] Collection to store aggregation of UserMessage objects.
     */
    protected $collUserMessagesRelatedByToEventUserid;
    protected $collUserMessagesRelatedByToEventUseridPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|UserMessage[]
     */
    protected $userMessagesRelatedByFromEventUseridScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|UserMessage[]
     */
    protected $userMessagesRelatedByToEventUseridScheduledForDeletion = null;

    /**
     * Initializes internal state of API\Models\Event\Base\EventUser object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>EventUser</code> instance.  If
     * <code>obj</code> is an instance of <code>EventUser</code>, delegates to
     * <code>equals(EventUser)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|EventUser The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [event_userid] column value.
     *
     * @return int
     */
    public function getEventUserid()
    {
        return $this->event_userid;
    }

    /**
     * Get the [eventid] column value.
     *
     * @return int
     */
    public function getEventid()
    {
        return $this->eventid;
    }

    /**
     * Get the [userid] column value.
     *
     * @return int
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * Get the [user_roles] column value.
     *
     * @return int
     */
    public function getUserRoles()
    {
        return $this->user_roles;
    }

    /**
     * Get the [begin_money] column value.
     *
     * @return string
     */
    public function getBeginMoney()
    {
        return $this->begin_money;
    }

    /**
     * Set the value of [event_userid] column.
     *
     * @param int $v new value
     * @return $this|\API\Models\Event\EventUser The current object (for fluent API support)
     */
    public function setEventUserid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->event_userid !== $v) {
            $this->event_userid = $v;
            $this->modifiedColumns[EventUserTableMap::COL_EVENT_USERID] = true;
        }

        return $this;
    } // setEventUserid()

    /**
     * Set the value of [eventid] column.
     *
     * @param int $v new value
     * @return $this|\API\Models\Event\EventUser The current object (for fluent API support)
     */
    public function setEventid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->eventid !== $v) {
            $this->eventid = $v;
            $this->modifiedColumns[EventUserTableMap::COL_EVENTID] = true;
        }

        if ($this->aEvent !== null && $this->aEvent->getEventid() !== $v) {
            $this->aEvent = null;
        }

        return $this;
    } // setEventid()

    /**
     * Set the value of [userid] column.
     *
     * @param int $v new value
     * @return $this|\API\Models\Event\EventUser The current object (for fluent API support)
     */
    public function setUserid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->userid !== $v) {
            $this->userid = $v;
            $this->modifiedColumns[EventUserTableMap::COL_USERID] = true;
        }

        if ($this->aUser !== null && $this->aUser->getUserid() !== $v) {
            $this->aUser = null;
        }

        return $this;
    } // setUserid()

    /**
     * Set the value of [user_roles] column.
     *
     * @param int $v new value
     * @return $this|\API\Models\Event\EventUser The current object (for fluent API support)
     */
    public function setUserRoles($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->user_roles !== $v) {
            $this->user_roles = $v;
            $this->modifiedColumns[EventUserTableMap::COL_USER_ROLES] = true;
        }

        return $this;
    } // setUserRoles()

    /**
     * Set the value of [begin_money] column.
     *
     * @param string $v new value
     * @return $this|\API\Models\Event\EventUser The current object (for fluent API support)
     */
    public function setBeginMoney($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->begin_money !== $v) {
            $this->begin_money = $v;
            $this->modifiedColumns[EventUserTableMap::COL_BEGIN_MONEY] = true;
        }

        return $this;
    } // setBeginMoney()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : EventUserTableMap::translateFieldName('EventUserid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->event_userid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : EventUserTableMap::translateFieldName('Eventid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->eventid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : EventUserTableMap::translateFieldName('Userid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->userid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : EventUserTableMap::translateFieldName('UserRoles', TableMap::TYPE_PHPNAME, $indexType)];
            $this->user_roles = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : EventUserTableMap::translateFieldName('BeginMoney', TableMap::TYPE_PHPNAME, $indexType)];
            $this->begin_money = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 5; // 5 = EventUserTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\API\\Models\\Event\\EventUser'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aEvent !== null && $this->eventid !== $this->aEvent->getEventid()) {
            $this->aEvent = null;
        }
        if ($this->aUser !== null && $this->userid !== $this->aUser->getUserid()) {
            $this->aUser = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(EventUserTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildEventUserQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aEvent = null;
            $this->aUser = null;
            $this->collUserMessagesRelatedByFromEventUserid = null;

            $this->collUserMessagesRelatedByToEventUserid = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see EventUser::setDeleted()
     * @see EventUser::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(EventUserTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildEventUserQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(EventUserTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                EventUserTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aEvent !== null) {
                if ($this->aEvent->isModified() || $this->aEvent->isNew()) {
                    $affectedRows += $this->aEvent->save($con);
                }
                $this->setEvent($this->aEvent);
            }

            if ($this->aUser !== null) {
                if ($this->aUser->isModified() || $this->aUser->isNew()) {
                    $affectedRows += $this->aUser->save($con);
                }
                $this->setUser($this->aUser);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->userMessagesRelatedByFromEventUseridScheduledForDeletion !== null) {
                if (!$this->userMessagesRelatedByFromEventUseridScheduledForDeletion->isEmpty()) {
                    \API\Models\User\Messages\UserMessageQuery::create()
                        ->filterByPrimaryKeys($this->userMessagesRelatedByFromEventUseridScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->userMessagesRelatedByFromEventUseridScheduledForDeletion = null;
                }
            }

            if ($this->collUserMessagesRelatedByFromEventUserid !== null) {
                foreach ($this->collUserMessagesRelatedByFromEventUserid as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->userMessagesRelatedByToEventUseridScheduledForDeletion !== null) {
                if (!$this->userMessagesRelatedByToEventUseridScheduledForDeletion->isEmpty()) {
                    \API\Models\User\Messages\UserMessageQuery::create()
                        ->filterByPrimaryKeys($this->userMessagesRelatedByToEventUseridScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->userMessagesRelatedByToEventUseridScheduledForDeletion = null;
                }
            }

            if ($this->collUserMessagesRelatedByToEventUserid !== null) {
                foreach ($this->collUserMessagesRelatedByToEventUserid as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[EventUserTableMap::COL_EVENT_USERID] = true;
        if (null !== $this->event_userid) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . EventUserTableMap::COL_EVENT_USERID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(EventUserTableMap::COL_EVENT_USERID)) {
            $modifiedColumns[':p' . $index++]  = 'event_userid';
        }
        if ($this->isColumnModified(EventUserTableMap::COL_EVENTID)) {
            $modifiedColumns[':p' . $index++]  = 'eventid';
        }
        if ($this->isColumnModified(EventUserTableMap::COL_USERID)) {
            $modifiedColumns[':p' . $index++]  = 'userid';
        }
        if ($this->isColumnModified(EventUserTableMap::COL_USER_ROLES)) {
            $modifiedColumns[':p' . $index++]  = 'user_roles';
        }
        if ($this->isColumnModified(EventUserTableMap::COL_BEGIN_MONEY)) {
            $modifiedColumns[':p' . $index++]  = 'begin_money';
        }

        $sql = sprintf(
            'INSERT INTO event_user (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'event_userid':
                        $stmt->bindValue($identifier, $this->event_userid, PDO::PARAM_INT);
                        break;
                    case 'eventid':
                        $stmt->bindValue($identifier, $this->eventid, PDO::PARAM_INT);
                        break;
                    case 'userid':
                        $stmt->bindValue($identifier, $this->userid, PDO::PARAM_INT);
                        break;
                    case 'user_roles':
                        $stmt->bindValue($identifier, $this->user_roles, PDO::PARAM_INT);
                        break;
                    case 'begin_money':
                        $stmt->bindValue($identifier, $this->begin_money, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setEventUserid($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = EventUserTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getEventUserid();
                break;
            case 1:
                return $this->getEventid();
                break;
            case 2:
                return $this->getUserid();
                break;
            case 3:
                return $this->getUserRoles();
                break;
            case 4:
                return $this->getBeginMoney();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['EventUser'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['EventUser'][$this->hashCode()] = true;
        $keys = EventUserTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getEventUserid(),
            $keys[1] => $this->getEventid(),
            $keys[2] => $this->getUserid(),
            $keys[3] => $this->getUserRoles(),
            $keys[4] => $this->getBeginMoney(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aEvent) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'event';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'event';
                        break;
                    default:
                        $key = 'Event';
                }

                $result[$key] = $this->aEvent->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aUser) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'user';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'user';
                        break;
                    default:
                        $key = 'User';
                }

                $result[$key] = $this->aUser->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collUserMessagesRelatedByFromEventUserid) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'userMessages';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'user_messages';
                        break;
                    default:
                        $key = 'UserMessages';
                }

                $result[$key] = $this->collUserMessagesRelatedByFromEventUserid->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collUserMessagesRelatedByToEventUserid) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'userMessages';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'user_messages';
                        break;
                    default:
                        $key = 'UserMessages';
                }

                $result[$key] = $this->collUserMessagesRelatedByToEventUserid->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\API\Models\Event\EventUser
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = EventUserTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\API\Models\Event\EventUser
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setEventUserid($value);
                break;
            case 1:
                $this->setEventid($value);
                break;
            case 2:
                $this->setUserid($value);
                break;
            case 3:
                $this->setUserRoles($value);
                break;
            case 4:
                $this->setBeginMoney($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = EventUserTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setEventUserid($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setEventid($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setUserid($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setUserRoles($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setBeginMoney($arr[$keys[4]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\API\Models\Event\EventUser The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(EventUserTableMap::DATABASE_NAME);

        if ($this->isColumnModified(EventUserTableMap::COL_EVENT_USERID)) {
            $criteria->add(EventUserTableMap::COL_EVENT_USERID, $this->event_userid);
        }
        if ($this->isColumnModified(EventUserTableMap::COL_EVENTID)) {
            $criteria->add(EventUserTableMap::COL_EVENTID, $this->eventid);
        }
        if ($this->isColumnModified(EventUserTableMap::COL_USERID)) {
            $criteria->add(EventUserTableMap::COL_USERID, $this->userid);
        }
        if ($this->isColumnModified(EventUserTableMap::COL_USER_ROLES)) {
            $criteria->add(EventUserTableMap::COL_USER_ROLES, $this->user_roles);
        }
        if ($this->isColumnModified(EventUserTableMap::COL_BEGIN_MONEY)) {
            $criteria->add(EventUserTableMap::COL_BEGIN_MONEY, $this->begin_money);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildEventUserQuery::create();
        $criteria->add(EventUserTableMap::COL_EVENT_USERID, $this->event_userid);
        $criteria->add(EventUserTableMap::COL_EVENTID, $this->eventid);
        $criteria->add(EventUserTableMap::COL_USERID, $this->userid);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getEventUserid() &&
            null !== $this->getEventid() &&
            null !== $this->getUserid();

        $validPrimaryKeyFKs = 2;
        $primaryKeyFKs = [];

        //relation fk_events_has_users_events1 to table event
        if ($this->aEvent && $hash = spl_object_hash($this->aEvent)) {
            $primaryKeyFKs[] = $hash;
        } else {
            $validPrimaryKeyFKs = false;
        }

        //relation fk_events_has_users_users1 to table user
        if ($this->aUser && $hash = spl_object_hash($this->aUser)) {
            $primaryKeyFKs[] = $hash;
        } else {
            $validPrimaryKeyFKs = false;
        }

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the composite primary key for this object.
     * The array elements will be in same order as specified in XML.
     * @return array
     */
    public function getPrimaryKey()
    {
        $pks = array();
        $pks[0] = $this->getEventUserid();
        $pks[1] = $this->getEventid();
        $pks[2] = $this->getUserid();

        return $pks;
    }

    /**
     * Set the [composite] primary key.
     *
     * @param      array $keys The elements of the composite key (order must match the order in XML file).
     * @return void
     */
    public function setPrimaryKey($keys)
    {
        $this->setEventUserid($keys[0]);
        $this->setEventid($keys[1]);
        $this->setUserid($keys[2]);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return (null === $this->getEventUserid()) && (null === $this->getEventid()) && (null === $this->getUserid());
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \API\Models\Event\EventUser (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setEventid($this->getEventid());
        $copyObj->setUserid($this->getUserid());
        $copyObj->setUserRoles($this->getUserRoles());
        $copyObj->setBeginMoney($this->getBeginMoney());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getUserMessagesRelatedByFromEventUserid() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addUserMessageRelatedByFromEventUserid($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getUserMessagesRelatedByToEventUserid() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addUserMessageRelatedByToEventUserid($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setEventUserid(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \API\Models\Event\EventUser Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildEvent object.
     *
     * @param  ChildEvent $v
     * @return $this|\API\Models\Event\EventUser The current object (for fluent API support)
     * @throws PropelException
     */
    public function setEvent(ChildEvent $v = null)
    {
        if ($v === null) {
            $this->setEventid(NULL);
        } else {
            $this->setEventid($v->getEventid());
        }

        $this->aEvent = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildEvent object, it will not be re-added.
        if ($v !== null) {
            $v->addEventUser($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildEvent object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildEvent The associated ChildEvent object.
     * @throws PropelException
     */
    public function getEvent(ConnectionInterface $con = null)
    {
        if ($this->aEvent === null && ($this->eventid !== null)) {
            $this->aEvent = ChildEventQuery::create()->findPk($this->eventid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aEvent->addEventUsers($this);
             */
        }

        return $this->aEvent;
    }

    /**
     * Declares an association between this object and a User object.
     *
     * @param  User $v
     * @return $this|\API\Models\Event\EventUser The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUser(User $v = null)
    {
        if ($v === null) {
            $this->setUserid(NULL);
        } else {
            $this->setUserid($v->getUserid());
        }

        $this->aUser = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the User object, it will not be re-added.
        if ($v !== null) {
            $v->addEventUser($this);
        }


        return $this;
    }


    /**
     * Get the associated User object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return User The associated User object.
     * @throws PropelException
     */
    public function getUser(ConnectionInterface $con = null)
    {
        if ($this->aUser === null && ($this->userid !== null)) {
            $this->aUser = UserQuery::create()->findPk($this->userid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUser->addEventUsers($this);
             */
        }

        return $this->aUser;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('UserMessageRelatedByFromEventUserid' == $relationName) {
            return $this->initUserMessagesRelatedByFromEventUserid();
        }
        if ('UserMessageRelatedByToEventUserid' == $relationName) {
            return $this->initUserMessagesRelatedByToEventUserid();
        }
    }

    /**
     * Clears out the collUserMessagesRelatedByFromEventUserid collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addUserMessagesRelatedByFromEventUserid()
     */
    public function clearUserMessagesRelatedByFromEventUserid()
    {
        $this->collUserMessagesRelatedByFromEventUserid = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collUserMessagesRelatedByFromEventUserid collection loaded partially.
     */
    public function resetPartialUserMessagesRelatedByFromEventUserid($v = true)
    {
        $this->collUserMessagesRelatedByFromEventUseridPartial = $v;
    }

    /**
     * Initializes the collUserMessagesRelatedByFromEventUserid collection.
     *
     * By default this just sets the collUserMessagesRelatedByFromEventUserid collection to an empty array (like clearcollUserMessagesRelatedByFromEventUserid());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initUserMessagesRelatedByFromEventUserid($overrideExisting = true)
    {
        if (null !== $this->collUserMessagesRelatedByFromEventUserid && !$overrideExisting) {
            return;
        }

        $collectionClassName = UserMessageTableMap::getTableMap()->getCollectionClassName();

        $this->collUserMessagesRelatedByFromEventUserid = new $collectionClassName;
        $this->collUserMessagesRelatedByFromEventUserid->setModel('\API\Models\User\Messages\UserMessage');
    }

    /**
     * Gets an array of UserMessage objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildEventUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|UserMessage[] List of UserMessage objects
     * @throws PropelException
     */
    public function getUserMessagesRelatedByFromEventUserid(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collUserMessagesRelatedByFromEventUseridPartial && !$this->isNew();
        if (null === $this->collUserMessagesRelatedByFromEventUserid || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collUserMessagesRelatedByFromEventUserid) {
                // return empty collection
                $this->initUserMessagesRelatedByFromEventUserid();
            } else {
                $collUserMessagesRelatedByFromEventUserid = UserMessageQuery::create(null, $criteria)
                    ->filterByEventUserRelatedByFromEventUserid($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collUserMessagesRelatedByFromEventUseridPartial && count($collUserMessagesRelatedByFromEventUserid)) {
                        $this->initUserMessagesRelatedByFromEventUserid(false);

                        foreach ($collUserMessagesRelatedByFromEventUserid as $obj) {
                            if (false == $this->collUserMessagesRelatedByFromEventUserid->contains($obj)) {
                                $this->collUserMessagesRelatedByFromEventUserid->append($obj);
                            }
                        }

                        $this->collUserMessagesRelatedByFromEventUseridPartial = true;
                    }

                    return $collUserMessagesRelatedByFromEventUserid;
                }

                if ($partial && $this->collUserMessagesRelatedByFromEventUserid) {
                    foreach ($this->collUserMessagesRelatedByFromEventUserid as $obj) {
                        if ($obj->isNew()) {
                            $collUserMessagesRelatedByFromEventUserid[] = $obj;
                        }
                    }
                }

                $this->collUserMessagesRelatedByFromEventUserid = $collUserMessagesRelatedByFromEventUserid;
                $this->collUserMessagesRelatedByFromEventUseridPartial = false;
            }
        }

        return $this->collUserMessagesRelatedByFromEventUserid;
    }

    /**
     * Sets a collection of UserMessage objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $userMessagesRelatedByFromEventUserid A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildEventUser The current object (for fluent API support)
     */
    public function setUserMessagesRelatedByFromEventUserid(Collection $userMessagesRelatedByFromEventUserid, ConnectionInterface $con = null)
    {
        /** @var UserMessage[] $userMessagesRelatedByFromEventUseridToDelete */
        $userMessagesRelatedByFromEventUseridToDelete = $this->getUserMessagesRelatedByFromEventUserid(new Criteria(), $con)->diff($userMessagesRelatedByFromEventUserid);


        $this->userMessagesRelatedByFromEventUseridScheduledForDeletion = $userMessagesRelatedByFromEventUseridToDelete;

        foreach ($userMessagesRelatedByFromEventUseridToDelete as $userMessageRelatedByFromEventUseridRemoved) {
            $userMessageRelatedByFromEventUseridRemoved->setEventUserRelatedByFromEventUserid(null);
        }

        $this->collUserMessagesRelatedByFromEventUserid = null;
        foreach ($userMessagesRelatedByFromEventUserid as $userMessageRelatedByFromEventUserid) {
            $this->addUserMessageRelatedByFromEventUserid($userMessageRelatedByFromEventUserid);
        }

        $this->collUserMessagesRelatedByFromEventUserid = $userMessagesRelatedByFromEventUserid;
        $this->collUserMessagesRelatedByFromEventUseridPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BaseUserMessage objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related BaseUserMessage objects.
     * @throws PropelException
     */
    public function countUserMessagesRelatedByFromEventUserid(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collUserMessagesRelatedByFromEventUseridPartial && !$this->isNew();
        if (null === $this->collUserMessagesRelatedByFromEventUserid || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collUserMessagesRelatedByFromEventUserid) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getUserMessagesRelatedByFromEventUserid());
            }

            $query = UserMessageQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByEventUserRelatedByFromEventUserid($this)
                ->count($con);
        }

        return count($this->collUserMessagesRelatedByFromEventUserid);
    }

    /**
     * Method called to associate a UserMessage object to this object
     * through the UserMessage foreign key attribute.
     *
     * @param  UserMessage $l UserMessage
     * @return $this|\API\Models\Event\EventUser The current object (for fluent API support)
     */
    public function addUserMessageRelatedByFromEventUserid(UserMessage $l)
    {
        if ($this->collUserMessagesRelatedByFromEventUserid === null) {
            $this->initUserMessagesRelatedByFromEventUserid();
            $this->collUserMessagesRelatedByFromEventUseridPartial = true;
        }

        if (!$this->collUserMessagesRelatedByFromEventUserid->contains($l)) {
            $this->doAddUserMessageRelatedByFromEventUserid($l);

            if ($this->userMessagesRelatedByFromEventUseridScheduledForDeletion and $this->userMessagesRelatedByFromEventUseridScheduledForDeletion->contains($l)) {
                $this->userMessagesRelatedByFromEventUseridScheduledForDeletion->remove($this->userMessagesRelatedByFromEventUseridScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param UserMessage $userMessageRelatedByFromEventUserid The UserMessage object to add.
     */
    protected function doAddUserMessageRelatedByFromEventUserid(UserMessage $userMessageRelatedByFromEventUserid)
    {
        $this->collUserMessagesRelatedByFromEventUserid[]= $userMessageRelatedByFromEventUserid;
        $userMessageRelatedByFromEventUserid->setEventUserRelatedByFromEventUserid($this);
    }

    /**
     * @param  UserMessage $userMessageRelatedByFromEventUserid The UserMessage object to remove.
     * @return $this|ChildEventUser The current object (for fluent API support)
     */
    public function removeUserMessageRelatedByFromEventUserid(UserMessage $userMessageRelatedByFromEventUserid)
    {
        if ($this->getUserMessagesRelatedByFromEventUserid()->contains($userMessageRelatedByFromEventUserid)) {
            $pos = $this->collUserMessagesRelatedByFromEventUserid->search($userMessageRelatedByFromEventUserid);
            $this->collUserMessagesRelatedByFromEventUserid->remove($pos);
            if (null === $this->userMessagesRelatedByFromEventUseridScheduledForDeletion) {
                $this->userMessagesRelatedByFromEventUseridScheduledForDeletion = clone $this->collUserMessagesRelatedByFromEventUserid;
                $this->userMessagesRelatedByFromEventUseridScheduledForDeletion->clear();
            }
            $this->userMessagesRelatedByFromEventUseridScheduledForDeletion[]= $userMessageRelatedByFromEventUserid;
            $userMessageRelatedByFromEventUserid->setEventUserRelatedByFromEventUserid(null);
        }

        return $this;
    }

    /**
     * Clears out the collUserMessagesRelatedByToEventUserid collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addUserMessagesRelatedByToEventUserid()
     */
    public function clearUserMessagesRelatedByToEventUserid()
    {
        $this->collUserMessagesRelatedByToEventUserid = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collUserMessagesRelatedByToEventUserid collection loaded partially.
     */
    public function resetPartialUserMessagesRelatedByToEventUserid($v = true)
    {
        $this->collUserMessagesRelatedByToEventUseridPartial = $v;
    }

    /**
     * Initializes the collUserMessagesRelatedByToEventUserid collection.
     *
     * By default this just sets the collUserMessagesRelatedByToEventUserid collection to an empty array (like clearcollUserMessagesRelatedByToEventUserid());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initUserMessagesRelatedByToEventUserid($overrideExisting = true)
    {
        if (null !== $this->collUserMessagesRelatedByToEventUserid && !$overrideExisting) {
            return;
        }

        $collectionClassName = UserMessageTableMap::getTableMap()->getCollectionClassName();

        $this->collUserMessagesRelatedByToEventUserid = new $collectionClassName;
        $this->collUserMessagesRelatedByToEventUserid->setModel('\API\Models\User\Messages\UserMessage');
    }

    /**
     * Gets an array of UserMessage objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildEventUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|UserMessage[] List of UserMessage objects
     * @throws PropelException
     */
    public function getUserMessagesRelatedByToEventUserid(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collUserMessagesRelatedByToEventUseridPartial && !$this->isNew();
        if (null === $this->collUserMessagesRelatedByToEventUserid || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collUserMessagesRelatedByToEventUserid) {
                // return empty collection
                $this->initUserMessagesRelatedByToEventUserid();
            } else {
                $collUserMessagesRelatedByToEventUserid = UserMessageQuery::create(null, $criteria)
                    ->filterByEventUserRelatedByToEventUserid($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collUserMessagesRelatedByToEventUseridPartial && count($collUserMessagesRelatedByToEventUserid)) {
                        $this->initUserMessagesRelatedByToEventUserid(false);

                        foreach ($collUserMessagesRelatedByToEventUserid as $obj) {
                            if (false == $this->collUserMessagesRelatedByToEventUserid->contains($obj)) {
                                $this->collUserMessagesRelatedByToEventUserid->append($obj);
                            }
                        }

                        $this->collUserMessagesRelatedByToEventUseridPartial = true;
                    }

                    return $collUserMessagesRelatedByToEventUserid;
                }

                if ($partial && $this->collUserMessagesRelatedByToEventUserid) {
                    foreach ($this->collUserMessagesRelatedByToEventUserid as $obj) {
                        if ($obj->isNew()) {
                            $collUserMessagesRelatedByToEventUserid[] = $obj;
                        }
                    }
                }

                $this->collUserMessagesRelatedByToEventUserid = $collUserMessagesRelatedByToEventUserid;
                $this->collUserMessagesRelatedByToEventUseridPartial = false;
            }
        }

        return $this->collUserMessagesRelatedByToEventUserid;
    }

    /**
     * Sets a collection of UserMessage objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $userMessagesRelatedByToEventUserid A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildEventUser The current object (for fluent API support)
     */
    public function setUserMessagesRelatedByToEventUserid(Collection $userMessagesRelatedByToEventUserid, ConnectionInterface $con = null)
    {
        /** @var UserMessage[] $userMessagesRelatedByToEventUseridToDelete */
        $userMessagesRelatedByToEventUseridToDelete = $this->getUserMessagesRelatedByToEventUserid(new Criteria(), $con)->diff($userMessagesRelatedByToEventUserid);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->userMessagesRelatedByToEventUseridScheduledForDeletion = clone $userMessagesRelatedByToEventUseridToDelete;

        foreach ($userMessagesRelatedByToEventUseridToDelete as $userMessageRelatedByToEventUseridRemoved) {
            $userMessageRelatedByToEventUseridRemoved->setEventUserRelatedByToEventUserid(null);
        }

        $this->collUserMessagesRelatedByToEventUserid = null;
        foreach ($userMessagesRelatedByToEventUserid as $userMessageRelatedByToEventUserid) {
            $this->addUserMessageRelatedByToEventUserid($userMessageRelatedByToEventUserid);
        }

        $this->collUserMessagesRelatedByToEventUserid = $userMessagesRelatedByToEventUserid;
        $this->collUserMessagesRelatedByToEventUseridPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BaseUserMessage objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related BaseUserMessage objects.
     * @throws PropelException
     */
    public function countUserMessagesRelatedByToEventUserid(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collUserMessagesRelatedByToEventUseridPartial && !$this->isNew();
        if (null === $this->collUserMessagesRelatedByToEventUserid || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collUserMessagesRelatedByToEventUserid) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getUserMessagesRelatedByToEventUserid());
            }

            $query = UserMessageQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByEventUserRelatedByToEventUserid($this)
                ->count($con);
        }

        return count($this->collUserMessagesRelatedByToEventUserid);
    }

    /**
     * Method called to associate a UserMessage object to this object
     * through the UserMessage foreign key attribute.
     *
     * @param  UserMessage $l UserMessage
     * @return $this|\API\Models\Event\EventUser The current object (for fluent API support)
     */
    public function addUserMessageRelatedByToEventUserid(UserMessage $l)
    {
        if ($this->collUserMessagesRelatedByToEventUserid === null) {
            $this->initUserMessagesRelatedByToEventUserid();
            $this->collUserMessagesRelatedByToEventUseridPartial = true;
        }

        if (!$this->collUserMessagesRelatedByToEventUserid->contains($l)) {
            $this->doAddUserMessageRelatedByToEventUserid($l);

            if ($this->userMessagesRelatedByToEventUseridScheduledForDeletion and $this->userMessagesRelatedByToEventUseridScheduledForDeletion->contains($l)) {
                $this->userMessagesRelatedByToEventUseridScheduledForDeletion->remove($this->userMessagesRelatedByToEventUseridScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param UserMessage $userMessageRelatedByToEventUserid The UserMessage object to add.
     */
    protected function doAddUserMessageRelatedByToEventUserid(UserMessage $userMessageRelatedByToEventUserid)
    {
        $this->collUserMessagesRelatedByToEventUserid[]= $userMessageRelatedByToEventUserid;
        $userMessageRelatedByToEventUserid->setEventUserRelatedByToEventUserid($this);
    }

    /**
     * @param  UserMessage $userMessageRelatedByToEventUserid The UserMessage object to remove.
     * @return $this|ChildEventUser The current object (for fluent API support)
     */
    public function removeUserMessageRelatedByToEventUserid(UserMessage $userMessageRelatedByToEventUserid)
    {
        if ($this->getUserMessagesRelatedByToEventUserid()->contains($userMessageRelatedByToEventUserid)) {
            $pos = $this->collUserMessagesRelatedByToEventUserid->search($userMessageRelatedByToEventUserid);
            $this->collUserMessagesRelatedByToEventUserid->remove($pos);
            if (null === $this->userMessagesRelatedByToEventUseridScheduledForDeletion) {
                $this->userMessagesRelatedByToEventUseridScheduledForDeletion = clone $this->collUserMessagesRelatedByToEventUserid;
                $this->userMessagesRelatedByToEventUseridScheduledForDeletion->clear();
            }
            $this->userMessagesRelatedByToEventUseridScheduledForDeletion[]= clone $userMessageRelatedByToEventUserid;
            $userMessageRelatedByToEventUserid->setEventUserRelatedByToEventUserid(null);
        }

        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aEvent) {
            $this->aEvent->removeEventUser($this);
        }
        if (null !== $this->aUser) {
            $this->aUser->removeEventUser($this);
        }
        $this->event_userid = null;
        $this->eventid = null;
        $this->userid = null;
        $this->user_roles = null;
        $this->begin_money = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collUserMessagesRelatedByFromEventUserid) {
                foreach ($this->collUserMessagesRelatedByFromEventUserid as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collUserMessagesRelatedByToEventUserid) {
                foreach ($this->collUserMessagesRelatedByToEventUserid as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collUserMessagesRelatedByFromEventUserid = null;
        $this->collUserMessagesRelatedByToEventUserid = null;
        $this->aEvent = null;
        $this->aUser = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(EventUserTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preSave')) {
            return parent::preSave($con);
        }
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postSave')) {
            parent::postSave($con);
        }
    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preInsert')) {
            return parent::preInsert($con);
        }
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postInsert')) {
            parent::postInsert($con);
        }
    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preUpdate')) {
            return parent::preUpdate($con);
        }
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postUpdate')) {
            parent::postUpdate($con);
        }
    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preDelete')) {
            return parent::preDelete($con);
        }
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postDelete')) {
            parent::postDelete($con);
        }
    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}