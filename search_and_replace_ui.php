<?php
include "search_and_replace.php";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['text'])) {
    // echo "<p><strong>You entered: " . htmlspecialchars($_POST['text']) . "</strong></p>";
    //echo search_and_replace("http://wp-montoya-dev.com/", "http://wp-montoya-dev22.com/");

    $result = search_and_replace("http://wp-montoya-dev.com", "https://wp-montoya-dev.com");


    $file = "".DB_NAME."__backup.sql";
    $txt = fopen($file, "w") or die("Unable to open file!");
    fwrite($txt, $result);
    fclose($txt);
    header('Content-Description: File Transfer');
    header("Content-Type: application/octet-stream");
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit();
    // echo $result;
    // exit(); // Stop execution after responding
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTMX Form Example</title>
    <!-- <script src="https://unpkg.com/htmx.org@1.9.6"></script> -->
</head>
<body>
    <form action="" method="post" hx-post="<?php echo $_SERVER['PHP_SELF']; ?>" hx-target="#result" hx-swap="innerHTML">
        <input type="file" name="file_name">
        <input type="text" name="text">
        <button type="submit">Submit</button>
    </form>

    <div id="result"></div> <!-- HTMX will update this -->
</body>
</html>
