<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Accounts extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $users = $this->table('users');
        $users->addColumn('accountid', 'string', ['limit' => 50])
            ->addColumn('username', 'string', ['limit' => 45])
            ->addColumn('password', 'string', ['limit' => 255])
            ->addColumn('email', 'string', ['limit' => 100, 'null' => true] )
            ->addColumn('blurb', 'string', ['limit' => 255])
            ->addColumn('RegisterIP', 'string', ['limit' => 255])
            ->addColumn('LastIP', 'string', ['limit' => 255])
            ->addColumn('registered', 'integer')
            ->addIndex(['username'], ['unique' => true])
            ->create();
    }
}
