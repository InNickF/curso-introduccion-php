<?php

use Phinx\Db\Action\AddColumn;
use Phinx\Migration\AbstractMigration;

class ContactFormTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $existJobsTable = $this->hasTable('jobs');
        if(!$existJobsTable) {
            $jobTable = $this->table('jobs');
            $jobTable->addColumn('title', 'string')
            ->addColumn('description', 'string')
            ->addColumn('months', 'intiger')
            ->addColumn('logo', 'string')
            ->addColumn('visible', 'boolean')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->addColumn('deleted_at', 'datetime')
            ->create();
        }

        $existProjectsTable = $this->hasTable('projects');
        if(!$existProjectsTable) {
            $projectTable = $this->table('projects');
            $projectTable->addColumn('title', 'string')
            ->addColumn('description', 'string')
            ->addColumn('logo', 'string')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->addColumn('deleted_at', 'datetime')
            ->create();
        }

        $existUsersTable = $this->hasTable('users');
        if(!$existUsersTable) {
            $usersTable = $this->table('users');
            $usersTable->addColumn('name', 'string')
            ->addColumn('username', 'string', ['limit' => 40])
            ->addColumn('email', 'string', ['limit' => 40])
            ->addColumn('password', 'string')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->addColumn('deleted_at', 'datetime')
            ->addIndex(['username', 'email'], ['unique' => true])
            ->create();
        }

        $existContactFormTable = $this->hasTable('contact_form');
        if(!$existContactFormTable) {
            $usersTable = $this->table('contact_form');
            $usersTable->addColumn('name', 'string', ['limit' => 40])
            ->addColumn('email', 'string', ['limit' => 40])
            ->addColumn('message', 'string')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->addColumn('sended', 'boolean')
            ->create();
        }

    }
}
