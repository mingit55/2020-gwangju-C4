<?php
session_start();

define("ROOT", __DIR__);
define("SRC", ROOT."/src");
define("VIEW", SRC."/View");
define("FIMAGE", ROOT."/festivalImages");

require SRC."/autoload.php";
require SRC."/helper.php";
require SRC."/web.php";
