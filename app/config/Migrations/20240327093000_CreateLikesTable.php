<?php
use Migrations\AbstractMigration;

class CreateLikesTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('likes');
        $table->addColumn('user_id', 'integer')
              ->addColumn('article_id', 'integer')
              ->addForeignKey('user_id', 'users', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
              ->addForeignKey('article_id', 'articles', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
              ->create();
    }
}
