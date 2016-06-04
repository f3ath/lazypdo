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

    public function execute($bound_input_params = NULL)
    {
        return $this->getPDOStatement()->execute($bound_input_params);
    }

    public function fetch($fetch_style = null, $cursor_orientation = PDO::FETCH_ORI_NEXT, $cursor_offset = 0)
    {
        return $this->getPDOStatement()->fetch($fetch_style, $cursor_orientation, $cursor_offset);
    }

    public function bindParam($parameter, &$variable, $data_type = PDO::PARAM_STR, $length = null, $driver_options = null)
    {
        return $this->getPDOStatement()->bindParam($parameter, $variable, $data_type, $length, $driver_options);
    }

    public function bindColumn($column, &$param, $type = null, $maxlen = null, $driverdata = null)
    {
        return $this->getPDOStatement()->bindColumn($column, $param, $type, $maxlen, $driverdata);
    }

    public function bindValue($parameter, $value, $data_type = PDO::PARAM_STR)
    {
        return $this->getPDOStatement()->bindValue($parameter, $value, $data_type);
    }

    public function rowCount()
    {
        return $this->getPDOStatement()->rowCount();
    }

    public function fetchColumn($column_number = 0)
    {
        return $this->getPDOStatement()->fetchColumn($column_number);
    }

    public function fetchAll($fetch_style = null, $fetch_argument = null, $ctor_args = null)
    {
        return $this->getPDOStatement()->fetchAll($fetch_style, $fetch_argument, $ctor_args);
    }

    public function fetchObject($class_name = "stdClass", $ctor_args = null)
    {
        return $this->getPDOStatement()->fetchObject($class_name, $ctor_args);
    }

    public function errorCode()
    {
        return $this->getPDOStatement()->errorCode();
    }

    public function errorInfo()
    {
        return $this->getPDOStatement()->errorInfo();
    }

    public function setAttribute($attribute, $value)
    {
        return $this->getPDOStatement()->setAttribute($attribute, $value);
    }

    public function getAttribute($attribute)
    {
        return $this->getPDOStatement()->getAttribute($attribute);
    }

    public function columnCount()
    {
        return $this->getPDOStatement()->columnCount();
    }

    public function getColumnMeta($column)
    {
        return $this->getPDOStatement()->getColumnMeta($column);
    }

    public function setFetchMode($mode, $arg2 = null, $arg3 = null)
    {
        return $this->getPDOStatement()->setFetchMode($mode, $arg2, $arg3);
    }

    public function nextRowset()
    {
        return $this->getPDOStatement()->nextRowset();
    }

    public function closeCursor()
    {
        return $this->getPDOStatement()->closeCursor();
    }

    public function debugDumpParams()
    {
        return $this->getPDOStatement()->debugDumpParams();
    }

}
