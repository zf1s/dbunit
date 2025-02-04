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
 * The default table iterator
 *
 * @package    DbUnit
 * @author     Mike Lively <m@digitalsandwich.com>
 * @copyright  2010-2014 Mike Lively <m@digitalsandwich.com>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @version    Release: @package_version@
 * @link       http://www.phpunit.de/
 * @since      Class available since Release 1.0.0
 */
class PHPUnit_Extensions_Database_DataSet_DefaultTableIterator implements PHPUnit_Extensions_Database_DataSet_ITableIterator
{
    /**
     * An array of tables in the iterator.
     *
     * @var Array
     */
    protected $tables;

    /**
     * If this property is true then the tables will be iterated in reverse
     * order.
     *
     * @var bool
     */
    protected $reverse;

    /**
     * Creates a new default table iterator object.
     *
     * @param array $tables
     * @param bool $reverse
     */
    public function __construct(Array $tables, $reverse = FALSE)
    {
        $this->tables  = $tables;
        $this->reverse = $reverse;

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
        return current($this->tables);
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
            prev($this->tables);
        } else {
            next($this->tables);
        }
    }

    /**
     * Rewinds to the first element
     */
    #[ReturnTypeWillChange]
    public function rewind()
    {
        if ($this->reverse) {
            end($this->tables);
        } else {
            reset($this->tables);
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
        return ($this->current() !== FALSE);
    }
}
