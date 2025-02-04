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
class PHPUnit_Extensions_Database_DataSet_ReplacementTableIterator implements OuterIterator, PHPUnit_Extensions_Database_DataSet_ITableIterator
{

    /**
     * @var PHPUnit_Extensions_Database_DataSet_ITableIterator
     */
    protected $innerIterator;

    /**
     * @var array
     */
    protected $fullReplacements;

    /**
     * @var array
     */
    protected $subStrReplacements;

    /**
     * Creates a new replacement table iterator object.
     *
     * @param PHPUnit_Extensions_Database_DataSet_ITableIterator $innerIterator
     * @param array $fullReplacements
     * @param array $subStrReplacements
     */
    public function __construct(PHPUnit_Extensions_Database_DataSet_ITableIterator $innerIterator, Array $fullReplacements = array(), Array $subStrReplacements = array())
    {
        $this->innerIterator      = $innerIterator;
        $this->fullReplacements   = $fullReplacements;
        $this->subStrReplacements = $subStrReplacements;
    }

    /**
     * Adds a new full replacement
     *
     * Full replacements will only replace values if the FULL value is a match
     *
     * @param string $value
     * @param string $replacement
     */
    public function addFullReplacement($value, $replacement)
    {
        $this->fullReplacements[$value] = $replacement;
    }

    /**
     * Adds a new substr replacement
     *
     * Substr replacements will replace all occurances of the substr in every column
     *
     * @param string $value
     * @param string $replacement
     */
    public function addSubStrReplacement($value, $replacement)
    {
        $this->subStrReplacements[$value] = $replacement;
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
        $this->current()->getTableMetaData();
    }

    /**
     * Returns the current table.
     *
     * @return PHPUnit_Extensions_Database_DataSet_ITable
     */
    #[ReturnTypeWillChange]
    public function current()
    {
        return new PHPUnit_Extensions_Database_DataSet_ReplacementTable($this->innerIterator->current(), $this->fullReplacements, $this->subStrReplacements);
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
        $this->innerIterator->next();
    }

    /**
     * Rewinds to the first element
     */
    #[ReturnTypeWillChange]
    public function rewind()
    {
        $this->innerIterator->rewind();
    }

    /**
     * Returns true if the current index is valid
     *
     * @return bool
     */
    #[ReturnTypeWillChange]
    public function valid()
    {
        return $this->innerIterator->valid();
    }

	#[ReturnTypeWillChange]
    public function getInnerIterator()
    {
        return $this->innerIterator;
    }
}
