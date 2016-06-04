<?php
namespace F3\LazyPDO;

use PDOStatement;

class SimplePDOStatementDecorator extends PDOStatementDecorator
{
    /**
     * @var PDOStatement
     */
    private $pdoStatement;

    /**
     * SimplePDOStatementDecorator constructor.
     * @param PDOStatement $pdoStatement
     */
    public function __construct(PDOStatement $pdoStatement)
    {
        $this->pdoStatement = $pdoStatement;
    }

    /**
     * @return PDOStatement
     */
    protected function getPDOStatement()
    {
        return $this->pdoStatement;
    }
}
