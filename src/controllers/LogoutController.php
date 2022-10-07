<?php
//methode de deconnexion
//on etabli la session
session_start();
//on desetabli la session ( pas sur du mot , mais je sait pas son equivalent francais)
session_unset();
//on detruit la session
session_destroy();
//on renvoi sur la page d'acceuil qui est la page de connexion
header("location: https://thomascavelier.sites.3wa.io/GEARS_FINAL/" );
exit();

