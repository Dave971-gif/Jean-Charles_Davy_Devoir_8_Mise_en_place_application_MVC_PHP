<?php

require_once 'app/model/db.php';
require_once 'app/model/postModel.php';

$users = getAllUsers();

include 'app/templates/home.php';

?>