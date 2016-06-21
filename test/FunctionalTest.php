<?php
namespace F3\LazyPDO;

use PDO;

class FunctionalTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TestPDO
     */
    private $pdo;

    public function setUp()
    {
        if (false === extension_loaded('pdo_sqlite')) {
            $this->markTestSkipped('pdo_sqlite not loaded');
        }
        $this->pdo = new TestPDO('sqlite::memory:', null, null, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $this->pdo->exec('CREATE TABLE my_test (id INT, name TEXT)');

        $insert = $this->pdo->prepare('INSERT INTO my_test (id, name) VALUES (:id, :name)');
        $insert->execute(array(
            ':id' => 1,
            ':name' => 'foo',
        ));
        $insert->execute(array(
            ':id' => 2,
            ':name' => 'bar',
        ));
    }

    public function testFetchAll()
    {
        $select = $this->pdo->prepare('SELECT * FROM my_test ORDER BY id ASC');
        $select->execute();
        $result = $select->fetchAll(PDO::FETCH_ASSOC);

        $this->assertEquals(
            array(
                array(
                    'id' => 1,
                    'name' => 'foo'
                ),
                array(
                    'id' => 2,
                    'name' => 'bar'
                ),
            ),
            $result
        );
    }

    public function testBindColumn()
    {
        $select = $this->pdo->prepare('SELECT name FROM my_test ORDER BY id ASC');
        $select->execute();

        $select->bindColumn('name', $name);

        $select->fetch(PDO::FETCH_BOUND);
        $this->assertEquals('foo', $name);
    }
}

class TestPDO extends LazyPDO
{
    /**
     * @param string $statement
     * @param array $options
     * @return TestPDOStatement
     */
    public function prepare($statement, $options = array())
    {
        $statement = parent::prepare($statement, $options);
        return new TestPDOStatement($statement);
    }
}

class TestPDOStatement extends SimplePDOStatementDecorator
{
}