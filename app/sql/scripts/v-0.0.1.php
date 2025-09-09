<?php

use App\Framework\DB\Create\Table;
use App\Framework\DB\Table\Column;
use App\Framework\DB\Table\Column\Type;

$table = new Table('db_version');
$table->addColumn(new Column('id', Type::INT, false, true, true))
      ->addColumn(new Column('version', 'VARCHAR(255)'))
      ->timestamps();

$table->create($table);