<?php
require_once ("../utils/Bible.php");

$b = new Bible();
print_r($b->get_books("john"));
?>