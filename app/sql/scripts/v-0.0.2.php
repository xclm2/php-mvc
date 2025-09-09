<?php

use App\Framework\DB\Create\Table;
use App\Framework\DB\Table\Column;
use App\Framework\DB\Table\Column\Type;

$table = new Table('users');

$table->addColumn(new Column('id', Type::INT, 11, false, true, true)) 
      ->addUniqueColumn(new Column('email', Type::VARCHAR, 255))
      ->addColumn(new Column('password', Type::VARCHAR, 255))  
      ->addColumn(new Column('name', Type::VARCHAR, 255))      
      ->addColumn(new Column('role', Type::ENUM, ['user','admin'], false, false, false, 'user'))
      ->addColumn(new Column('status', Type::TINYINT, 1, false, false, false, 1))
      ->timestamps();

$table->create($table);