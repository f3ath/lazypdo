<?php
namespace F3\LazyPDO;

use PDO;

/**
 * PDO decorator, redirect calls to PDO methods
 *
 * @package LazyPDO
 * @version $id$
 * @copyright Alexey Karapetov
 * @author Alexey Karapetov <karapetov@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php The MIT License (MIT)
 */
abstract class PDODecorator
    extends PDO
{
    /**
     * Get the PDO object
     *
     * @return PDO
     */
    abstract protected function getPDO();

    /**
	 * Empty default constructor. Redefined the PDO's native one
	 * to prevent instantiating the PDO.
     */
    public function __construct() { }

    /**
     * Sets attribute
     *
     * @param int $attribute Attribute code
     * @param mixed $value
     * @return bool
     */
    public function setAttribute($attribute, $value)
    {
        return $this->getPDO()->setAttribute($attribute, $value);
    }

    /**
     * Returns attribute
     *
     * @param int $attribute Attribute code
     * @return mixed
     */
    public function getAttribute($attribute)
    {
        return $this->getPDO()->getAttribute($attribute);
    }

    /**
     * Checks if inside a transaction
     *
     * @return bool
     */
    public function inTransaction()
    {
        return $this->getPDO()->inTransaction();
    }

    /**
     * Initiates a transaction
     *
     * @return bool
     */
    public function beginTransaction()
    {
        return $this->getPDO()->beginTransaction();
    }

    /**
     * Commits a transaction
     *
     * @return bool
     */
    public function commit()
    {
        return $this->getPDO()->commit();
    }

    /**
     * Rolls back a transaction
     *
     * @return bool
     */
    public function rollBack()
    {
        return $this->getPDO()->rollBack();
    }

    /**
     * Returns the SQLSTATE associated with the last operation on the database handle
     *
     * @return mixed
     */
    public function errorCode()
    {
        return $this->getPDO()->errorCode();
    }

    /**
     * Fetch extended error information associated with the last operation on the database handle
     *
     * @return array
     */
    public function errorInfo()
    {
        return $this->getPDO()->errorInfo();
    }

    /**
     * Execute an SQL statement and return the number of affected rows
     *
     * @param string $statement
     * @return int
     */
    public function exec($statement)
    {
        return $this->getPDO()->exec($statement);
    }

    /**
     * Prepares a statement for execution and returns a statement object
     *
     * @param string $statement
     * @param array $options
     * @return PDOStatement
     */
    public function prepare($statement, $options = array())
    {
        return $this->getPDO()->prepare($statement, $options);
    }

    /**
     * Quotes a string for use in a query.
     *
     * @param string $string
     * @param int $type
     * @return string
     */
    public function quote($string, $type = PDO::PARAM_STR)
    {
		return $this->getPDO()->quote($string, $type);
    }

    /**
     * Returns the ID of the last inserted row or sequence value
     *
     * @param string $name
     * @return string
     */
    public function lastInsertId($name = NULL)
    {
        return $this->getPDO()->lastInsertId($name);
    }

    /**
     * Executes an SQL statement, returning a result set as a PDOStatement object
     * overloading supported
     *
     * @param string $statement
     * @return PDOStatement
     */
    public function query($statement)
    {
        if (1 == func_num_args())
        {
            return $this->getPDO()->query($statement);
        }
        // this way is much slower but supports overloading
        // http://php.net/manual/en/pdo.query.php
        return call_user_func_array(array($this->getPDO(), __FUNCTION__), func_get_args());
    }
}
