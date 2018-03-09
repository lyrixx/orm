<?php

declare(strict_types=1);

namespace Doctrine\Tests\ORM\Query;

use Doctrine\ORM\Query;
use Doctrine\ORM\Query\ParserResult;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\Tests\OrmTestCase;

/**
 * Tests for {@see \Doctrine\ORM\Query\SqlWalker}
 *
 * @covers \Doctrine\ORM\Query\SqlWalker
 */
class SqlWalkerTest extends OrmTestCase
{
    /** @var SqlWalker */
    private $sqlWalker;

    /**
     * {@inheritDoc}
     */
    protected function setUp() : void
    {
        $this->sqlWalker = new SqlWalker(new Query($this->getTestEntityManager()), new ParserResult(), []);
    }

    /**
     * @dataProvider getColumnNamesAndSqlAliases
     */
    public function testGetSQLTableAlias($tableName, $expectedAlias) : void
    {
        self::assertSame($expectedAlias, $this->sqlWalker->getSQLTableAlias($tableName));
    }

    /**
     * @dataProvider getColumnNamesAndSqlAliases
     */
    public function testGetSQLTableAliasIsSameForMultipleCalls($tableName) : void
    {
        self::assertSame(
            $this->sqlWalker->getSQLTableAlias($tableName),
            $this->sqlWalker->getSQLTableAlias($tableName)
        );
    }

    /**
     * @private data provider
     *
     * @return string[][]
     */
    public function getColumnNamesAndSqlAliases()
    {
        return [
            ['aaaaa', 't0'],
            ['table', 't0'],
            ['çtable', 't0'],
        ];
    }
}
