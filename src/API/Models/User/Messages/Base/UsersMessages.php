<?php

namespace API\Models\User\Messages\Base;

use \DateTime;
use \Exception;
use \PDO;
use API\Models\Event\EventsUser;
use API\Models\Event\EventsUserQuery;
use API\Models\User\Messages\UsersMessagesQuery as ChildUsersMessagesQuery;
use API\Models\User\Messages\Map\UsersMessagesTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'users_messages' table.
 *
 *
 *
 * @package    propel.generator.API.Models.User.Messages.Base
 */
abstract class UsersMessages implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\API\\Models\\User\\Messages\\Map\\UsersMessagesTableMap';


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
     * The value for the users_messageid field.
     *
     * @var        int
     */
    protected $users_messageid;

    /**
     * The value for the from_events_userid field.
     *
     * @var        int
     */
    protected $from_events_userid;

    /**
     * The value for the to_events_userid field.
     *
     * @var        int
     */
    protected $to_events_userid;

    /**
     * The value for the message field.
     *
     * @var        string
     */
    protected $message;

    /**
     * The value for the date field.
     *
     * @var        DateTime
     */
    protected $date;

    /**
     * The value for the readed field.
     *
     * @var        boolean
     */
    protected $readed;

    /**
     * @var        EventsUser
     */
    protected $aEventsUserRelatedByFromEventsUserid;

    /**
     * @var        EventsUser
     */
    protected $aEventsUserRelatedByToEventsUserid;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Initializes internal state of API\Models\User\Messages\Base\UsersMessages object.
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
     * Compares this with another <code>UsersMessages</code> instance.  If
     * <code>obj</code> is an instance of <code>UsersMessages</code>, delegates to
     * <code>equals(UsersMessages)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|UsersMessages The current object, for fluid interface
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
     * Get the [users_messageid] column value.
     *
     * @return int
     */
    public function getUsersMessageid()
    {
        return $this->users_messageid;
    }

    /**
     * Get the [from_events_userid] column value.
     *
     * @return int
     */
    public function getFromEventsUserid()
    {
        return $this->from_events_userid;
    }

    /**
     * Get the [to_events_userid] column value.
     *
     * @return int
     */
    public function getToEventsUserid()
    {
        return $this->to_events_userid;
    }

    /**
     * Get the [message] column value.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Get the [optionally formatted] temporal [date] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDate($format = NULL)
    {
        if ($format === null) {
            return $this->date;
        } else {
            return $this->date instanceof \DateTimeInterface ? $this->date->format($format) : null;
        }
    }

    /**
     * Get the [readed] column value.
     *
     * @return boolean
     */
    public function getReaded()
    {
        return $this->readed;
    }

    /**
     * Get the [readed] column value.
     *
     * @return boolean
     */
    public function isReaded()
    {
        return $this->getReaded();
    }

    /**
     * Set the value of [users_messageid] column.
     *
     * @param int $v new value
     * @return $this|\API\Models\User\Messages\UsersMessages The current object (for fluent API support)
     */
    public function setUsersMessageid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->users_messageid !== $v) {
            $this->users_messageid = $v;
            $this->modifiedColumns[UsersMessagesTableMap::COL_USERS_MESSAGEID] = true;
        }

        return $this;
    } // setUsersMessageid()

    /**
     * Set the value of [from_events_userid] column.
     *
     * @param int $v new value
     * @return $this|\API\Models\User\Messages\UsersMessages The current object (for fluent API support)
     */
    public function setFromEventsUserid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->from_events_userid !== $v) {
            $this->from_events_userid = $v;
            $this->modifiedColumns[UsersMessagesTableMap::COL_FROM_EVENTS_USERID] = true;
        }

        if ($this->aEventsUserRelatedByFromEventsUserid !== null && $this->aEventsUserRelatedByFromEventsUserid->getEventsUserid() !== $v) {
            $this->aEventsUserRelatedByFromEventsUserid = null;
        }

        return $this;
    } // setFromEventsUserid()

    /**
     * Set the value of [to_events_userid] column.
     *
     * @param int $v new value
     * @return $this|\API\Models\User\Messages\UsersMessages The current object (for fluent API support)
     */
    public function setToEventsUserid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->to_events_userid !== $v) {
            $this->to_events_userid = $v;
            $this->modifiedColumns[UsersMessagesTableMap::COL_TO_EVENTS_USERID] = true;
        }

        if ($this->aEventsUserRelatedByToEventsUserid !== null && $this->aEventsUserRelatedByToEventsUserid->getEventsUserid() !== $v) {
            $this->aEventsUserRelatedByToEventsUserid = null;
        }

        return $this;
    } // setToEventsUserid()

    /**
     * Set the value of [message] column.
     *
     * @param string $v new value
     * @return $this|\API\Models\User\Messages\UsersMessages The current object (for fluent API support)
     */
    public function setMessage($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->message !== $v) {
            $this->message = $v;
            $this->modifiedColumns[UsersMessagesTableMap::COL_MESSAGE] = true;
        }

        return $this;
    } // setMessage()

    /**
     * Sets the value of [date] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\API\Models\User\Messages\UsersMessages The current object (for fluent API support)
     */
    public function setDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->date !== null || $dt !== null) {
            if ($this->date === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->date->format("Y-m-d H:i:s.u")) {
                $this->date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[UsersMessagesTableMap::COL_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setDate()

    /**
     * Sets the value of the [readed] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\API\Models\User\Messages\UsersMessages The current object (for fluent API support)
     */
    public function setReaded($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->readed !== $v) {
            $this->readed = $v;
            $this->modifiedColumns[UsersMessagesTableMap::COL_READED] = true;
        }

        return $this;
    } // setReaded()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : UsersMessagesTableMap::translateFieldName('UsersMessageid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->users_messageid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : UsersMessagesTableMap::translateFieldName('FromEventsUserid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->from_events_userid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : UsersMessagesTableMap::translateFieldName('ToEventsUserid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->to_events_userid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : UsersMessagesTableMap::translateFieldName('Message', TableMap::TYPE_PHPNAME, $indexType)];
            $this->message = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : UsersMessagesTableMap::translateFieldName('Date', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : UsersMessagesTableMap::translateFieldName('Readed', TableMap::TYPE_PHPNAME, $indexType)];
            $this->readed = (null !== $col) ? (boolean) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 6; // 6 = UsersMessagesTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\API\\Models\\User\\Messages\\UsersMessages'), 0, $e);
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
        if ($this->aEventsUserRelatedByFromEventsUserid !== null && $this->from_events_userid !== $this->aEventsUserRelatedByFromEventsUserid->getEventsUserid()) {
            $this->aEventsUserRelatedByFromEventsUserid = null;
        }
        if ($this->aEventsUserRelatedByToEventsUserid !== null && $this->to_events_userid !== $this->aEventsUserRelatedByToEventsUserid->getEventsUserid()) {
            $this->aEventsUserRelatedByToEventsUserid = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(UsersMessagesTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildUsersMessagesQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aEventsUserRelatedByFromEventsUserid = null;
            $this->aEventsUserRelatedByToEventsUserid = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see UsersMessages::setDeleted()
     * @see UsersMessages::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(UsersMessagesTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildUsersMessagesQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(UsersMessagesTableMap::DATABASE_NAME);
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
                UsersMessagesTableMap::addInstanceToPool($this);
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

            if ($this->aEventsUserRelatedByFromEventsUserid !== null) {
                if ($this->aEventsUserRelatedByFromEventsUserid->isModified() || $this->aEventsUserRelatedByFromEventsUserid->isNew()) {
                    $affectedRows += $this->aEventsUserRelatedByFromEventsUserid->save($con);
                }
                $this->setEventsUserRelatedByFromEventsUserid($this->aEventsUserRelatedByFromEventsUserid);
            }

            if ($this->aEventsUserRelatedByToEventsUserid !== null) {
                if ($this->aEventsUserRelatedByToEventsUserid->isModified() || $this->aEventsUserRelatedByToEventsUserid->isNew()) {
                    $affectedRows += $this->aEventsUserRelatedByToEventsUserid->save($con);
                }
                $this->setEventsUserRelatedByToEventsUserid($this->aEventsUserRelatedByToEventsUserid);
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

        $this->modifiedColumns[UsersMessagesTableMap::COL_USERS_MESSAGEID] = true;
        if (null !== $this->users_messageid) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . UsersMessagesTableMap::COL_USERS_MESSAGEID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(UsersMessagesTableMap::COL_USERS_MESSAGEID)) {
            $modifiedColumns[':p' . $index++]  = 'users_messageid';
        }
        if ($this->isColumnModified(UsersMessagesTableMap::COL_FROM_EVENTS_USERID)) {
            $modifiedColumns[':p' . $index++]  = 'from_events_userid';
        }
        if ($this->isColumnModified(UsersMessagesTableMap::COL_TO_EVENTS_USERID)) {
            $modifiedColumns[':p' . $index++]  = 'to_events_userid';
        }
        if ($this->isColumnModified(UsersMessagesTableMap::COL_MESSAGE)) {
            $modifiedColumns[':p' . $index++]  = 'message';
        }
        if ($this->isColumnModified(UsersMessagesTableMap::COL_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'date';
        }
        if ($this->isColumnModified(UsersMessagesTableMap::COL_READED)) {
            $modifiedColumns[':p' . $index++]  = 'readed';
        }

        $sql = sprintf(
            'INSERT INTO users_messages (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'users_messageid':
                        $stmt->bindValue($identifier, $this->users_messageid, PDO::PARAM_INT);
                        break;
                    case 'from_events_userid':
                        $stmt->bindValue($identifier, $this->from_events_userid, PDO::PARAM_INT);
                        break;
                    case 'to_events_userid':
                        $stmt->bindValue($identifier, $this->to_events_userid, PDO::PARAM_INT);
                        break;
                    case 'message':
                        $stmt->bindValue($identifier, $this->message, PDO::PARAM_STR);
                        break;
                    case 'date':
                        $stmt->bindValue($identifier, $this->date ? $this->date->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'readed':
                        $stmt->bindValue($identifier, (int) $this->readed, PDO::PARAM_INT);
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
        $this->setUsersMessageid($pk);

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
        $pos = UsersMessagesTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getUsersMessageid();
                break;
            case 1:
                return $this->getFromEventsUserid();
                break;
            case 2:
                return $this->getToEventsUserid();
                break;
            case 3:
                return $this->getMessage();
                break;
            case 4:
                return $this->getDate();
                break;
            case 5:
                return $this->getReaded();
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

        if (isset($alreadyDumpedObjects['UsersMessages'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['UsersMessages'][$this->hashCode()] = true;
        $keys = UsersMessagesTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getUsersMessageid(),
            $keys[1] => $this->getFromEventsUserid(),
            $keys[2] => $this->getToEventsUserid(),
            $keys[3] => $this->getMessage(),
            $keys[4] => $this->getDate(),
            $keys[5] => $this->getReaded(),
        );
        if ($result[$keys[4]] instanceof \DateTime) {
            $result[$keys[4]] = $result[$keys[4]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aEventsUserRelatedByFromEventsUserid) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'eventsUser';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'events_user';
                        break;
                    default:
                        $key = 'EventsUser';
                }

                $result[$key] = $this->aEventsUserRelatedByFromEventsUserid->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aEventsUserRelatedByToEventsUserid) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'eventsUser';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'events_user';
                        break;
                    default:
                        $key = 'EventsUser';
                }

                $result[$key] = $this->aEventsUserRelatedByToEventsUserid->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
     * @return $this|\API\Models\User\Messages\UsersMessages
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = UsersMessagesTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\API\Models\User\Messages\UsersMessages
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setUsersMessageid($value);
                break;
            case 1:
                $this->setFromEventsUserid($value);
                break;
            case 2:
                $this->setToEventsUserid($value);
                break;
            case 3:
                $this->setMessage($value);
                break;
            case 4:
                $this->setDate($value);
                break;
            case 5:
                $this->setReaded($value);
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
        $keys = UsersMessagesTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setUsersMessageid($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setFromEventsUserid($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setToEventsUserid($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setMessage($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setDate($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setReaded($arr[$keys[5]]);
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
     * @return $this|\API\Models\User\Messages\UsersMessages The current object, for fluid interface
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
        $criteria = new Criteria(UsersMessagesTableMap::DATABASE_NAME);

        if ($this->isColumnModified(UsersMessagesTableMap::COL_USERS_MESSAGEID)) {
            $criteria->add(UsersMessagesTableMap::COL_USERS_MESSAGEID, $this->users_messageid);
        }
        if ($this->isColumnModified(UsersMessagesTableMap::COL_FROM_EVENTS_USERID)) {
            $criteria->add(UsersMessagesTableMap::COL_FROM_EVENTS_USERID, $this->from_events_userid);
        }
        if ($this->isColumnModified(UsersMessagesTableMap::COL_TO_EVENTS_USERID)) {
            $criteria->add(UsersMessagesTableMap::COL_TO_EVENTS_USERID, $this->to_events_userid);
        }
        if ($this->isColumnModified(UsersMessagesTableMap::COL_MESSAGE)) {
            $criteria->add(UsersMessagesTableMap::COL_MESSAGE, $this->message);
        }
        if ($this->isColumnModified(UsersMessagesTableMap::COL_DATE)) {
            $criteria->add(UsersMessagesTableMap::COL_DATE, $this->date);
        }
        if ($this->isColumnModified(UsersMessagesTableMap::COL_READED)) {
            $criteria->add(UsersMessagesTableMap::COL_READED, $this->readed);
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
        $criteria = ChildUsersMessagesQuery::create();
        $criteria->add(UsersMessagesTableMap::COL_USERS_MESSAGEID, $this->users_messageid);
        $criteria->add(UsersMessagesTableMap::COL_TO_EVENTS_USERID, $this->to_events_userid);

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
        $validPk = null !== $this->getUsersMessageid() &&
            null !== $this->getToEventsUserid();

        $validPrimaryKeyFKs = 1;
        $primaryKeyFKs = [];

        //relation fk_users_chat_events_user2 to table events_user
        if ($this->aEventsUserRelatedByToEventsUserid && $hash = spl_object_hash($this->aEventsUserRelatedByToEventsUserid)) {
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
        $pks[0] = $this->getUsersMessageid();
        $pks[1] = $this->getToEventsUserid();

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
        $this->setUsersMessageid($keys[0]);
        $this->setToEventsUserid($keys[1]);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return (null === $this->getUsersMessageid()) && (null === $this->getToEventsUserid());
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \API\Models\User\Messages\UsersMessages (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setFromEventsUserid($this->getFromEventsUserid());
        $copyObj->setToEventsUserid($this->getToEventsUserid());
        $copyObj->setMessage($this->getMessage());
        $copyObj->setDate($this->getDate());
        $copyObj->setReaded($this->getReaded());
        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setUsersMessageid(NULL); // this is a auto-increment column, so set to default value
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
     * @return \API\Models\User\Messages\UsersMessages Clone of current object.
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
     * Declares an association between this object and a EventsUser object.
     *
     * @param  EventsUser $v
     * @return $this|\API\Models\User\Messages\UsersMessages The current object (for fluent API support)
     * @throws PropelException
     */
    public function setEventsUserRelatedByFromEventsUserid(EventsUser $v = null)
    {
        if ($v === null) {
            $this->setFromEventsUserid(NULL);
        } else {
            $this->setFromEventsUserid($v->getEventsUserid());
        }

        $this->aEventsUserRelatedByFromEventsUserid = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the EventsUser object, it will not be re-added.
        if ($v !== null) {
            $v->addUsersMessagesRelatedByFromEventsUserid($this);
        }


        return $this;
    }


    /**
     * Get the associated EventsUser object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return EventsUser The associated EventsUser object.
     * @throws PropelException
     */
    public function getEventsUserRelatedByFromEventsUserid(ConnectionInterface $con = null)
    {
        if ($this->aEventsUserRelatedByFromEventsUserid === null && ($this->from_events_userid !== null)) {
            $this->aEventsUserRelatedByFromEventsUserid = EventsUserQuery::create()
                ->filterByUsersMessagesRelatedByFromEventsUserid($this) // here
                ->findOne($con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aEventsUserRelatedByFromEventsUserid->addUsersMessagessRelatedByFromEventsUserid($this);
             */
        }

        return $this->aEventsUserRelatedByFromEventsUserid;
    }

    /**
     * Declares an association between this object and a EventsUser object.
     *
     * @param  EventsUser $v
     * @return $this|\API\Models\User\Messages\UsersMessages The current object (for fluent API support)
     * @throws PropelException
     */
    public function setEventsUserRelatedByToEventsUserid(EventsUser $v = null)
    {
        if ($v === null) {
            $this->setToEventsUserid(NULL);
        } else {
            $this->setToEventsUserid($v->getEventsUserid());
        }

        $this->aEventsUserRelatedByToEventsUserid = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the EventsUser object, it will not be re-added.
        if ($v !== null) {
            $v->addUsersMessagesRelatedByToEventsUserid($this);
        }


        return $this;
    }


    /**
     * Get the associated EventsUser object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return EventsUser The associated EventsUser object.
     * @throws PropelException
     */
    public function getEventsUserRelatedByToEventsUserid(ConnectionInterface $con = null)
    {
        if ($this->aEventsUserRelatedByToEventsUserid === null && ($this->to_events_userid !== null)) {
            $this->aEventsUserRelatedByToEventsUserid = EventsUserQuery::create()
                ->filterByUsersMessagesRelatedByToEventsUserid($this) // here
                ->findOne($con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aEventsUserRelatedByToEventsUserid->addUsersMessagessRelatedByToEventsUserid($this);
             */
        }

        return $this->aEventsUserRelatedByToEventsUserid;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aEventsUserRelatedByFromEventsUserid) {
            $this->aEventsUserRelatedByFromEventsUserid->removeUsersMessagesRelatedByFromEventsUserid($this);
        }
        if (null !== $this->aEventsUserRelatedByToEventsUserid) {
            $this->aEventsUserRelatedByToEventsUserid->removeUsersMessagesRelatedByToEventsUserid($this);
        }
        $this->users_messageid = null;
        $this->from_events_userid = null;
        $this->to_events_userid = null;
        $this->message = null;
        $this->date = null;
        $this->readed = null;
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
        } // if ($deep)

        $this->aEventsUserRelatedByFromEventsUserid = null;
        $this->aEventsUserRelatedByToEventsUserid = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(UsersMessagesTableMap::DEFAULT_STRING_FORMAT);
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