<?php

//$username = $_POST['username'];
$username = filter_input(INPUT_POST, 'username');
$password = filter_input(INPUT_POST, 'password');

echo "Username: $username | Password: $password";
