<?php
namespace F3\LazyPDO;

use PDO;
use PDOStatement;

abstract class PDOStatementDecorator extends PDOStatement
{
    /**
     * @return PDOStatement
     */
    abstract protected function getPDOStatement();

    /**
     * Original queryString can not be copied over. Use this method assess $queryString
     * @return string
     */
    public function getQueryString()
    {
        return $this->getPDOStatement()->queryString;
    }

    /**
     * @inheritdoc
     */
    public function execute($bound_input_params = null)
    {
        return call_user_func_array(array($this->getPDOStatement(), 'execute'), func_get_args());
    }

    /**
     * @inheritdoc
     */
    public function fetch($fetch_style = null, $cursor_orientation = PDO::FETCH_ORI_NEXT, $cursor_offset = 0)
    {
        return call_user_func_array(array($this->getPDOStatement(), 'fetch'), func_get_args());
    }

    /**
     * @inheritdoc
     */
    public function bindParam($parameter, &$variable, $type = null, $maxlen = null, $driverdata = null)
    {
        $args = func_get_args();
        $args[1] = &$variable;
        return call_user_func_array(array($this->getPDOStatement(), 'bindParam'), $args);
    }

    /**
     * @inheritdoc
     */
    public function bindColumn($column, &$param, $type = null, $maxlen = null, $driverdata = null)
    {
        $args = func_get_args();
        $args[1] = &$param;
        return call_user_func_array(array($this->getPDOStatement(), 'bindColumn'), $args);
    }
    
    /**
     * @inheritdoc
     */
    public function bindValue($parameter, $value, $data_type = PDO::PARAM_STR)
    {
        return call_user_func_array(array($this->getPDOStatement(), 'bindValue'), func_get_args());
    }

    /**
     * @inheritdoc
     */
    public function rowCount()
    {
        return $this->getPDOStatement()->rowCount();
    }

    /**
     * @inheritdoc
     */
    public function fetchColumn($column_number = 0)
    {
        return call_user_func_array(array($this->getPDOStatement(), 'fetchColumn'), func_get_args());
    }

    /**
     * @inheritdoc
     */
    public function fetchAll($fetch_style = null, $fetch_argument = null, $ctor_args = null)
    {
        return call_user_func_array(array($this->getPDOStatement(), 'fetchAll'), func_get_args());
    }

    /**
     * @inheritdoc
     */
    public function fetchObject($class_name = "stdClass", $ctor_args = null)
    {
        return call_user_func_array(array($this->getPDOStatement(), 'fetchObject'), func_get_args());
    }

    /**
     * @inheritdoc
     */
    public function errorCode()
    {
        return $this->getPDOStatement()->errorCode();
    }

    /**
     * @inheritdoc
     */
    public function errorInfo()
    {
        return $this->getPDOStatement()->errorInfo();
    }

    /**
     * @inheritdoc
     */
    public function setAttribute($attribute, $value)
    {
        return $this->getPDOStatement()->setAttribute($attribute, $value);
    }

    /**
     * @inheritdoc
     */
    public function getAttribute($attribute)
    {
        return $this->getPDOStatement()->getAttribute($attribute);
    }

    /**
     * @inheritdoc
     */
    public function columnCount()
    {
        return $this->getPDOStatement()->columnCount();
    }

    /**
     * @inheritdoc
     */
    public function getColumnMeta($column)
    {
        return $this->getPDOStatement()->getColumnMeta($column);
    }

    /**
     * @inheritdoc
     */
    public function setFetchMode($mode, $arg2 = null, $arg3 = null)
    {
        return call_user_func_array(array($this->getPDOStatement(), 'setFetchMode'), func_get_args());
    }

    /**
     * @inheritdoc
     */
    public function nextRowset()
    {
        return $this->getPDOStatement()->nextRowset();
    }

    /**
     * @inheritdoc
     */
    public function closeCursor()
    {
        return $this->getPDOStatement()->closeCursor();
    }

    /**
     * @inheritdoc
     */
    public function debugDumpParams()
    {
        return $this->getPDOStatement()->debugDumpParams();
    }
}
