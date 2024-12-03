<?php

require "config.php";
require "session.php";

if (!$USUARIO_ES_ADMIN) header("Location: " . APP_ROOT);

require APP_PATH . "views/user_management.view.php";