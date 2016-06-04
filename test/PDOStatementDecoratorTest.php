<?php
namespace F3\LazyPDO;


class PDOStatementDecoratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PDOStatement
     */
    protected $pdoStatementDecorator;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $pdoStatementStub;

    protected function setUp()
    {
        $this->pdoStatementStub = $this->getMockBuilder('stdClass')
            ->setMethods(array(
                'execute',
                'fetch',
                'bindParam',
                'bindColumn',
                'bindValue',
                'rowCount',
                'fetchColumn',
                'fetchAll',
                'fetchObject',
                'errorCode',
                'errorInfo',
                'setAttribute',
                'getAttribute',
                'columnCount',
                'getColumnMeta',
                'setFetchMode',
                'nextRowset',
                'closeCursor',
                'debugDumpParams',
            ))->disableArgumentCloning()
            ->getMock();

        $this->pdoStatementDecorator = $this->getMockForAbstractClass('F3\\LazyPDO\\PDOStatementDecorator');

        $this->pdoStatementDecorator->expects($this->any())
            ->method('getPDOStatement')
            ->will($this->returnValue($this->pdoStatementStub));
    }

    public function methods()
    {
        return array(
            array('execute', array(1)),
            array('fetch', array(1, 2, 3)),
            array('bindValue', array(1, 2, 3)),
            array('rowCount', array()),
            array('fetchColumn', array(1)),
            array('fetchAll', array(1, 2, 3)),
            array('fetchObject', array(1, 2)),
            array('errorCode', array()),
            array('errorInfo', array()),
            array('setAttribute', array(1, 2)),
            array('getAttribute', array(1)),
            array('columnCount', array()),
            array('getColumnMeta', array(1)),
            array('setFetchMode', array(1, 2, 3)),
            array('nextRowset', array()),
            array('closeCursor', array()),
            array('debugDumpParams', array()),
        );
    }


    public function testBindParam()
    {
        $this->pdoStatementStub->expects($this->once())
            ->method('bindParam')
            ->with(1, 2, 3, 4, 5)
            ->willReturn(42);

        $var = 2;
        $this->assertEquals(42, $this->pdoStatementDecorator->bindParam(1, $var, 3, 4, 5));
    }

    public function testBindColumn()
    {
        $this->pdoStatementStub->expects($this->once())
            ->method('bindColumn')
            ->with(1, 2, 3, 4, 5)
            ->willReturn(42);

        $var = 2;
        $this->assertEquals(42, $this->pdoStatementDecorator->bindColumn(1, $var, 3, 4, 5));
    }


    /**
     * @dataProvider methods
     * @param       $methodName
     * @param array $params
     */
    public function testMethod($methodName, array $params)
    {
        $method = $this->pdoStatementStub->expects($this->once())
            ->method($methodName);
        $method = call_user_func_array(array($method, 'with'), $params);
        $method->willReturn(42);

        $this->assertEquals(42, call_user_func_array(array($this->pdoStatementDecorator, $methodName), $params));
    }
}
