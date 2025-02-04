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
 * Asserts whether or not two dbunit tables are equal.
 *
 * @package    DbUnit
 * @author     Mike Lively <m@digitalsandwich.com>
 * @copyright  2010-2014 Mike Lively <m@digitalsandwich.com>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @version    Release: @package_version@
 * @link       http://www.phpunit.de/
 * @since      Class available since Release 1.0.0
 */
class PHPUnit_Extensions_Database_Constraint_TableIsEqual extends PHPUnit_Framework_Constraint
{
    /**
     * @var PHPUnit_Extensions_Database_DataSet_ITable
     */
    protected $value;

    /**
     * @var string
     */
    protected $failure_reason;

    /**
     * Creates a new constraint.
     *
     * @param PHPUnit_Extensions_Database_DataSet_ITable $value
     */
    public function __construct(PHPUnit_Extensions_Database_DataSet_ITable $value)
    {
        $this->value = $value;
    }

    /**
     * Evaluates the constraint for parameter $other. Returns TRUE if the
     * constraint is met, FALSE otherwise.
     *
     * This method can be overridden to implement the evaluation algorithm.
     *
     * @param mixed $other Value or object to evaluate.
     * @return bool
     */
    protected function matches($other)
    {
        if (!$other instanceof PHPUnit_Extensions_Database_DataSet_ITable) {
            throw new InvalidArgumentException(
              'PHPUnit_Extensions_Database_DataSet_ITable expected'
            );
        }

        return $this->value->matches($other);
    }

    /**
     * Returns the description of the failure
     *
     * The beginning of failure messages is "Failed asserting that" in most
     * cases. This method should return the second part of that sentence.
     *
     * @param  mixed $other Evaluated value or object.
     * @return string
     */
    protected function failureDescription($other)
    {
        return $other->__toString() . ' ' . $this->toString();
    }

    /**
     * Returns a string representation of the constraint.
     *
     * @return string
     */
    public function toString()
    {
        return sprintf(
          'is equal to expected %s', $this->value->__toString()
        );
    }
}
