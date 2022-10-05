<?php


session_start();
session_unset();
session_destroy();

header("location: https://thomascavelier.sites.3wa.io/GEARS_FINAL/" );
exit();

