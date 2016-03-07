<?php

namespace Adition\AdBundle\Tests\Repository;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class RepositoryTestCase extends WebTestCase
{

    /**
     * @var EntityManager $em
     */
    protected $em;

    /**
     * Pre setup for repository test
     */
    public function setUp()
    {
        parent::setUp();

        $kernel = static::createKernel();
        $kernel->boot();
        $this->em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
    }

    /**
     * Execute after test is complete
     */
    public function tearDown()
    {
        // TODO:Truncate database after each test
        $this->truncateTables();
        parent::tearDown();
    }

    abstract protected function getTables();

    protected function truncateTables()
    {
        $connection = $this->em->getConnection();
        $dbPlatform = $connection->getDatabasePlatform();
        $connection->query('SET FOREIGN_KEY_CHECKS=0');
        foreach ($this->getTables() as $table) {
            $q = $dbPlatform->getTruncateTableSql($table);
            $connection->executeUpdate($q);
        }
        $connection->query('SET FOREIGN_KEY_CHECKS=1');
    }
}
