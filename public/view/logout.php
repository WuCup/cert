<?php

use Lib\Account;

Account::logout();
header('Location: login');