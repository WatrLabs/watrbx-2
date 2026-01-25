<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AccountSessions extends AbstractMigration
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
        $sessions = $this->table('sessions');
        $sessions->addColumn('userid', 'integer')
        ->addColumn('session', 'string')
        ->addColumn('expiration', 'integer', ['null'=>true])
        ->addColumn('data', 'json', ['null'=>true])
        ->addIndex(['session'], ['unique' => true])
        ->create();
    }
}
