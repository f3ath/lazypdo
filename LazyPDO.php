<?php
require_once(__DIR__ . DIRECTORY_SEPARATOR . '/PDODecorator.php');

/**
 * LazyPDO does not instanciate real PDO until it is really needed
 *
 * Also it can be (un)serialized
 *
 * @package
 * @version $id$
 * @author Alexey Karapetov <karapetov@gmail.com>
 */
class F3_LazyPDO
    extends F3_PDODecorator
    implements Serializable
{
    private $dsn;
    private $user;
    private $password;
    private $options = array();

    private $pdo = null;

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
     * Get PDO object. Cache the result
     *
     * @return PDO
     */
    protected function getPDO()
    {
        if (NULL === $this->pdo)
        {
            $this->pdo = new PDO($this->dsn, $this->user, $this->password, $this->options);
        }
        return $this->pdo;
    }

    /**
     * Checks if inside a transaction
     *
     * @return bool
     */
    public function inTransaction()
    {
        // Do not call parent method if there is no pdo object
        return $this->pdo && parent::inTransaction();
    }

    /**
     * serialize
     *
     * @return string
     */
    public function serialize()
    {
        if ($this->inTransaction())
        {
            throw new RuntimeException('Can not serialize in transaction');
        }
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
     * @param int $attribute
     * @param mixed $value
     * @return boolean
     */
    public function setAttribute($attribute, $value)
    {
        if (parent::setAttribute($attribute, $value))
        {
            $this->options[$attribute] = $value;
            return true;
        }
        return false;
    }
}
