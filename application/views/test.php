<?php
$dir = 'assets/foto_profil/';
if (is_writable($dir)) {
    echo "Folder bisa ditulisi.";
} else {
    echo "Folder TIDAK bisa ditulisi.";
}
?>
