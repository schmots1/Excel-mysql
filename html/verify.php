<?php

echo "<html><body>";
echo "Are you sure you want to delete this set?<br>";
echo "<a href=index.php?delete=" . $_GET['delete'] . ">YES</a> <a href=index.php>NO</a>";
echo "</body></html>";

?>
