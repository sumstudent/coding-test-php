<?php
use Migrations\AbstractMigration;

class CreateLikesTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('likes');
        $table->addColumn('article_id', 'integer')
              ->addColumn('user_id', 'integer')
              ->addIndex(['article_id', 'user_id'], ['unique' => true])
              ->addForeignKey('article_id', 'articles', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
              ->addForeignKey('user_id', 'users', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
              ->create();
    }
}
