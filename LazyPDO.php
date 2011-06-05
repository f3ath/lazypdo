<?php
use PDO, Serializable;

/**
 * LazyPDO does not call parent::__construct() unless it explicitly called via init()
 *
 * Also it can be (un)serialized
 *
 * @package
 * @version $id$
 * @author Alexey Karapetov <karapetov@gmail.com>
 */
class LazyPDO
    extends PDO
    implements Serializable
{
    private $dsn;
    private $user;
    private $password;
    private $options = array();

    private $suspended = true;

    /**
     * __construct
     *
     * @param string $dsn
     * @param string $user
     * @param string $password
     * @param array $options
     */
    public function __construct($dsn, $user = null, $password = null, array $options = array())
    {
        $this->dsn = $dsn;
        $this->user = $user;
        $this->password = $password;
        $this->options = $options;
    }

    /**
     * call parent::__construct()
     *
     * @return void
     */
    private function init()
    {
        if ($this->suspended)
        {
            parent::__construct($this->dsn, $this->user, $this->password, $this->options);
            $this->suspended = false;
        }
    }

    /**
     * serialize
     *
     * @return string
     */
    public function serialize()
    {
        return serialize(array(
            $this->dsn,
            $this->user,
            $this->password,
            $this->options,
        ));
    }

    /**
     * unserialize
     *
     * @param string $serialized
     * @return void
     */
    public function unserialize($serialized)
    {
        list($this->dsn, $this->user, $this->password, $this->options) = unserialize($serialized);
    }

    /**
     * setAttribute
     *
     * @param int $attr
     * @param mixed $value
     * @return boolean
     */
    public function setAttribute($attr, $value)
    {
        $this->init();
        $result = parent::setAttribute($attr, $value);
        if ($result)
        {
            $this->options[$attr] = $value;
        }
        return $result;
    }

    /**
     * getAttribute
     *
     * @param int $attr
     * @return mixed
     */
    public function getAttribute($attr)
    {
        $this->init();
        return parent::getAttribute($attr);
    }

    /**
     * inTransaction
     *
     * @return boolean
     */
    public function inTransaction()
    {
        $this->init();
        return (boolean) parent::inTransaction();
    }

    /**
     * beginTransaction
     *
     * @return boolean
     */
    public function beginTransaction()
    {
        $this->init();
        return (boolean) parent::beginTransaction();
    }

    /**
     * commit
     *
     * @return boolean
     */
    public function commit()
    {
        $this->init();
        return parent::commit();
    }

    /**
     * rollBack
     *
     * @return boolean
     */
    public function rollBack()
    {
        $this-> init();
        return parent::rollBack();
    }

    /**
     * errorCode
     *
     * @return mixed
     */
    public function errorCode()
    {
        $this->init();
        return parent::errorCode();
    }

    /**
     * errorInfo
     *
     * @return array
     */
    public function errorInfo()
    {
        $this->init();
        return parent::errorInfo();
    }

    /**
     * exec
     *
     * @param string $statement
     * @return int
     */
    public function exec($statement)
    {
        $this->init();
        return parent::exec($statement);
    }

    /**
     * prepare
     *
     * @param string $statement
     * @param array $options
     * @return PDOStatement
     */
    public function prepare($statement, $options = array())
    {
        $this->init();
        return parent::prepare($statement, $options);
    }

    /**
     * quote
     *
     * @param string $string
     * @param int $type
     * @return string
     */
    public function quote($string, $type = PDO::PARAM_STR)
    {
        $this->init();
        return parent::quote($string, $type);
    }

    /**
     * lastInsertId
     *
     * @param string $name
     * @return string
     */
    public function lastInsertId($name = null)
    {
        $this->init();
        return parent::lastInsertId($name);
    }

    /**
     * query
     * overloading supported
     *
     * @param string $statement
     * @return PDOStatement
     */
    public function query($statement)
    {
        $this->init();
        if (1 == func_num_args())
        {
            return parent::query($statement);
        }
        // this is much slower but supports overloading
        // http://php.net/manual/en/pdo.query.php
        return call_user_func_array(array('parent', __FUNCTION__), func_get_args());
    }
}
