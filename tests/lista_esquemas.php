<?php

require_once '../src/pgInfoDB.php';

pg_connect("host=localhost dbname=smt user=postgres");

$info = new \Craos\Smart\Backup\pgInfoDB();
var_dump($info->Esquemas);
