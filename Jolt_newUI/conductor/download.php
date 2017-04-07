<?php
header('Content-Type: application/download');
    header('Content-Disposition: attachment; filename="MultipleQuestionTemplate.csv"');
    header("Content-Length: " . filesize("Multi-temple.csv"));

    $fp = fopen("Multi-temple.csv", "r");
    fpassthru($fp);
    fclose($fp);
?>