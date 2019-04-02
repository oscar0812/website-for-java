<?php

namespace Base;

use \Scene as ChildScene;
use \SceneQuery as ChildSceneQuery;
use \Exception;
use \PDO;
use Map\SceneTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'scene' table.
 *
 *
 *
 * @method     ChildSceneQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSceneQuery orderByItemId($order = Criteria::ASC) Order by the item_id column
 * @method     ChildSceneQuery orderByTrapId($order = Criteria::ASC) Order by the trap_id column
 * @method     ChildSceneQuery orderByParentSceneId($order = Criteria::ASC) Order by the parent_scene_id column
 * @method     ChildSceneQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildSceneQuery orderByPlacement($order = Criteria::ASC) Order by the placement column
 *
 * @method     ChildSceneQuery groupById() Group by the id column
 * @method     ChildSceneQuery groupByItemId() Group by the item_id column
 * @method     ChildSceneQuery groupByTrapId() Group by the trap_id column
 * @method     ChildSceneQuery groupByParentSceneId() Group by the parent_scene_id column
 * @method     ChildSceneQuery groupByDescription() Group by the description column
 * @method     ChildSceneQuery groupByPlacement() Group by the placement column
 *
 * @method     ChildSceneQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSceneQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSceneQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSceneQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildSceneQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildSceneQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildSceneQuery leftJoinItem($relationAlias = null) Adds a LEFT JOIN clause to the query using the Item relation
 * @method     ChildSceneQuery rightJoinItem($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Item relation
 * @method     ChildSceneQuery innerJoinItem($relationAlias = null) Adds a INNER JOIN clause to the query using the Item relation
 *
 * @method     ChildSceneQuery joinWithItem($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Item relation
 *
 * @method     ChildSceneQuery leftJoinWithItem() Adds a LEFT JOIN clause and with to the query using the Item relation
 * @method     ChildSceneQuery rightJoinWithItem() Adds a RIGHT JOIN clause and with to the query using the Item relation
 * @method     ChildSceneQuery innerJoinWithItem() Adds a INNER JOIN clause and with to the query using the Item relation
 *
 * @method     ChildSceneQuery leftJoinTrap($relationAlias = null) Adds a LEFT JOIN clause to the query using the Trap relation
 * @method     ChildSceneQuery rightJoinTrap($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Trap relation
 * @method     ChildSceneQuery innerJoinTrap($relationAlias = null) Adds a INNER JOIN clause to the query using the Trap relation
 *
 * @method     ChildSceneQuery joinWithTrap($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Trap relation
 *
 * @method     ChildSceneQuery leftJoinWithTrap() Adds a LEFT JOIN clause and with to the query using the Trap relation
 * @method     ChildSceneQuery rightJoinWithTrap() Adds a RIGHT JOIN clause and with to the query using the Trap relation
 * @method     ChildSceneQuery innerJoinWithTrap() Adds a INNER JOIN clause and with to the query using the Trap relation
 *
 * @method     \ItemQuery|\TrapQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildScene findOne(ConnectionInterface $con = null) Return the first ChildScene matching the query
 * @method     ChildScene findOneOrCreate(ConnectionInterface $con = null) Return the first ChildScene matching the query, or a new ChildScene object populated from the query conditions when no match is found
 *
 * @method     ChildScene findOneById(int $id) Return the first ChildScene filtered by the id column
 * @method     ChildScene findOneByItemId(int $item_id) Return the first ChildScene filtered by the item_id column
 * @method     ChildScene findOneByTrapId(int $trap_id) Return the first ChildScene filtered by the trap_id column
 * @method     ChildScene findOneByParentSceneId(int $parent_scene_id) Return the first ChildScene filtered by the parent_scene_id column
 * @method     ChildScene findOneByDescription(string $description) Return the first ChildScene filtered by the description column
 * @method     ChildScene findOneByPlacement(int $placement) Return the first ChildScene filtered by the placement column *

 * @method     ChildScene requirePk($key, ConnectionInterface $con = null) Return the ChildScene by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildScene requireOne(ConnectionInterface $con = null) Return the first ChildScene matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildScene requireOneById(int $id) Return the first ChildScene filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildScene requireOneByItemId(int $item_id) Return the first ChildScene filtered by the item_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildScene requireOneByTrapId(int $trap_id) Return the first ChildScene filtered by the trap_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildScene requireOneByParentSceneId(int $parent_scene_id) Return the first ChildScene filtered by the parent_scene_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildScene requireOneByDescription(string $description) Return the first ChildScene filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildScene requireOneByPlacement(int $placement) Return the first ChildScene filtered by the placement column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildScene[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildScene objects based on current ModelCriteria
 * @method     ChildScene[]|ObjectCollection findById(int $id) Return ChildScene objects filtered by the id column
 * @method     ChildScene[]|ObjectCollection findByItemId(int $item_id) Return ChildScene objects filtered by the item_id column
 * @method     ChildScene[]|ObjectCollection findByTrapId(int $trap_id) Return ChildScene objects filtered by the trap_id column
 * @method     ChildScene[]|ObjectCollection findByParentSceneId(int $parent_scene_id) Return ChildScene objects filtered by the parent_scene_id column
 * @method     ChildScene[]|ObjectCollection findByDescription(string $description) Return ChildScene objects filtered by the description column
 * @method     ChildScene[]|ObjectCollection findByPlacement(int $placement) Return ChildScene objects filtered by the placement column
 * @method     ChildScene[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SceneQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\SceneQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Scene', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSceneQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSceneQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSceneQuery) {
            return $criteria;
        }
        $query = new ChildSceneQuery();
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
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildScene|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SceneTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = SceneTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildScene A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, item_id, trap_id, parent_scene_id, description, placement FROM scene WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildScene $obj */
            $obj = new ChildScene();
            $obj->hydrate($row);
            SceneTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildScene|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(12, 56, 832), $con);
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
     * @return $this|ChildSceneQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SceneTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSceneQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SceneTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSceneQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SceneTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SceneTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SceneTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the item_id column
     *
     * Example usage:
     * <code>
     * $query->filterByItemId(1234); // WHERE item_id = 1234
     * $query->filterByItemId(array(12, 34)); // WHERE item_id IN (12, 34)
     * $query->filterByItemId(array('min' => 12)); // WHERE item_id > 12
     * </code>
     *
     * @see       filterByItem()
     *
     * @param     mixed $itemId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSceneQuery The current query, for fluid interface
     */
    public function filterByItemId($itemId = null, $comparison = null)
    {
        if (is_array($itemId)) {
            $useMinMax = false;
            if (isset($itemId['min'])) {
                $this->addUsingAlias(SceneTableMap::COL_ITEM_ID, $itemId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($itemId['max'])) {
                $this->addUsingAlias(SceneTableMap::COL_ITEM_ID, $itemId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SceneTableMap::COL_ITEM_ID, $itemId, $comparison);
    }

    /**
     * Filter the query on the trap_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTrapId(1234); // WHERE trap_id = 1234
     * $query->filterByTrapId(array(12, 34)); // WHERE trap_id IN (12, 34)
     * $query->filterByTrapId(array('min' => 12)); // WHERE trap_id > 12
     * </code>
     *
     * @see       filterByTrap()
     *
     * @param     mixed $trapId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSceneQuery The current query, for fluid interface
     */
    public function filterByTrapId($trapId = null, $comparison = null)
    {
        if (is_array($trapId)) {
            $useMinMax = false;
            if (isset($trapId['min'])) {
                $this->addUsingAlias(SceneTableMap::COL_TRAP_ID, $trapId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($trapId['max'])) {
                $this->addUsingAlias(SceneTableMap::COL_TRAP_ID, $trapId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SceneTableMap::COL_TRAP_ID, $trapId, $comparison);
    }

    /**
     * Filter the query on the parent_scene_id column
     *
     * Example usage:
     * <code>
     * $query->filterByParentSceneId(1234); // WHERE parent_scene_id = 1234
     * $query->filterByParentSceneId(array(12, 34)); // WHERE parent_scene_id IN (12, 34)
     * $query->filterByParentSceneId(array('min' => 12)); // WHERE parent_scene_id > 12
     * </code>
     *
     * @param     mixed $parentSceneId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSceneQuery The current query, for fluid interface
     */
    public function filterByParentSceneId($parentSceneId = null, $comparison = null)
    {
        if (is_array($parentSceneId)) {
            $useMinMax = false;
            if (isset($parentSceneId['min'])) {
                $this->addUsingAlias(SceneTableMap::COL_PARENT_SCENE_ID, $parentSceneId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parentSceneId['max'])) {
                $this->addUsingAlias(SceneTableMap::COL_PARENT_SCENE_ID, $parentSceneId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SceneTableMap::COL_PARENT_SCENE_ID, $parentSceneId, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%', Criteria::LIKE); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSceneQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SceneTableMap::COL_DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the placement column
     *
     * Example usage:
     * <code>
     * $query->filterByPlacement(1234); // WHERE placement = 1234
     * $query->filterByPlacement(array(12, 34)); // WHERE placement IN (12, 34)
     * $query->filterByPlacement(array('min' => 12)); // WHERE placement > 12
     * </code>
     *
     * @param     mixed $placement The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSceneQuery The current query, for fluid interface
     */
    public function filterByPlacement($placement = null, $comparison = null)
    {
        if (is_array($placement)) {
            $useMinMax = false;
            if (isset($placement['min'])) {
                $this->addUsingAlias(SceneTableMap::COL_PLACEMENT, $placement['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($placement['max'])) {
                $this->addUsingAlias(SceneTableMap::COL_PLACEMENT, $placement['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SceneTableMap::COL_PLACEMENT, $placement, $comparison);
    }

    /**
     * Filter the query by a related \Item object
     *
     * @param \Item|ObjectCollection $item The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSceneQuery The current query, for fluid interface
     */
    public function filterByItem($item, $comparison = null)
    {
        if ($item instanceof \Item) {
            return $this
                ->addUsingAlias(SceneTableMap::COL_ITEM_ID, $item->getId(), $comparison);
        } elseif ($item instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SceneTableMap::COL_ITEM_ID, $item->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByItem() only accepts arguments of type \Item or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Item relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSceneQuery The current query, for fluid interface
     */
    public function joinItem($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Item');

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
            $this->addJoinObject($join, 'Item');
        }

        return $this;
    }

    /**
     * Use the Item relation Item object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ItemQuery A secondary query class using the current class as primary query
     */
    public function useItemQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinItem($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Item', '\ItemQuery');
    }

    /**
     * Filter the query by a related \Trap object
     *
     * @param \Trap|ObjectCollection $trap The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSceneQuery The current query, for fluid interface
     */
    public function filterByTrap($trap, $comparison = null)
    {
        if ($trap instanceof \Trap) {
            return $this
                ->addUsingAlias(SceneTableMap::COL_TRAP_ID, $trap->getId(), $comparison);
        } elseif ($trap instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SceneTableMap::COL_TRAP_ID, $trap->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByTrap() only accepts arguments of type \Trap or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Trap relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSceneQuery The current query, for fluid interface
     */
    public function joinTrap($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Trap');

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
            $this->addJoinObject($join, 'Trap');
        }

        return $this;
    }

    /**
     * Use the Trap relation Trap object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \TrapQuery A secondary query class using the current class as primary query
     */
    public function useTrapQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTrap($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Trap', '\TrapQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildScene $scene Object to remove from the list of results
     *
     * @return $this|ChildSceneQuery The current query, for fluid interface
     */
    public function prune($scene = null)
    {
        if ($scene) {
            $this->addUsingAlias(SceneTableMap::COL_ID, $scene->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the scene table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SceneTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SceneTableMap::clearInstancePool();
            SceneTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SceneTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SceneTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SceneTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SceneTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SceneQuery
