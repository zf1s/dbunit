<?php
/*
 * This file is part of DBUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Provides iterative access to tables from a database instance.
 *
 * @package    DbUnit
 * @author     Mike Lively <m@digitalsandwich.com>
 * @copyright  2010-2014 Mike Lively <m@digitalsandwich.com>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @version    Release: @package_version@
 * @link       http://www.phpunit.de/
 * @since      Class available since Release 1.0.0
 */
class PHPUnit_Extensions_Database_DB_TableIterator implements PHPUnit_Extensions_Database_DataSet_ITableIterator
{

    /**
     * An array of tablenames.
     *
     * @var Array
     */
    protected $tableNames;

    /**
     * If this property is true then the tables will be iterated in reverse
     * order.
     *
     * @var bool
     */
    protected $reverse;

    /**
     * The database dataset that this iterator iterates over.
     *
     * @var PHPUnit_Extensions_Database_DB_DataSet
     */
    protected $dataSet;

    public function __construct($tableNames, PHPUnit_Extensions_Database_DB_DataSet $dataSet, $reverse = FALSE)
    {
        $this->tableNames = $tableNames;
        $this->dataSet    = $dataSet;
        $this->reverse    = $reverse;

        $this->rewind();
    }

    /**
     * Returns the current table.
     *
     * @return PHPUnit_Extensions_Database_DataSet_ITable
     */
    public function getTable()
    {
        return $this->current();
    }

    /**
     * Returns the current table's meta data.
     *
     * @return PHPUnit_Extensions_Database_DataSet_ITableMetaData
     */
    public function getTableMetaData()
    {
        return $this->current()->getTableMetaData();
    }

    /**
     * Returns the current table.
     *
     * @return PHPUnit_Extensions_Database_DataSet_ITable
     */
    #[ReturnTypeWillChange]
    public function current()
    {
        $tableName = current($this->tableNames);
        return $this->dataSet->getTable($tableName);
    }

    /**
     * Returns the name of the current table.
     *
     * @return string
     */
    #[ReturnTypeWillChange]
    public function key()
    {
        return $this->current()->getTableMetaData()->getTableName();
    }

    /**
     * advances to the next element.
     *
     */
    #[ReturnTypeWillChange]
    public function next()
    {
        if ($this->reverse) {
            prev($this->tableNames);
        } else {
            next($this->tableNames);
        }
    }

    /**
     * Rewinds to the first element
     */
    #[ReturnTypeWillChange]
    public function rewind()
    {
        if ($this->reverse) {
            end($this->tableNames);
        } else {
            reset($this->tableNames);
        }
    }

    /**
     * Returns true if the current index is valid
     *
     * @return bool
     */
    #[ReturnTypeWillChange]
    public function valid()
    {
        return (current($this->tableNames) !== FALSE);
    }
}
