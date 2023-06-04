<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/models/table.php";

// table creation is going to be done here:
$Event = new Table('event', ['name', 'place', 'description', 'userid', 'date'], ['id']);
