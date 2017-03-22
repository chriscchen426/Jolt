<?php
header('Content-Type: application/download');
    header('Content-Disposition: attachment; filename="OpenendedQuestionTemple.csv"');
    header("Content-Length: " . filesize("Op-temple.csv"));

    $fp = fopen("Op-temple.csv", "r");
    fpassthru($fp);
    fclose($fp);
?>