<?

$oldname = $_GET["oldname"];
$newname = $_GET["newname"];
$indir = $_GET["indir"];
$renamed_dir = $_GET["renamed_dir"];
$host  = $_SERVER['HTTP_HOST'];

if (empty($newname)) {
    $newname = mt_rand();
}

$src_file = $indir.$oldname;
$dst_file = $renamed_dir."/".$newname . ".pdf";

if ( file_exists($dst_file) )
{
    $error_message = "Die Datei ist im Zielordner bereits vorhanden";
    header("Location: http://$host/error.php?message=" . $error_message );
}
else
{
    if (rename($src_file, $dst_file))
    {
        header("Location: http://$host");
    }
    else
    {
        $error_message = "Fehler beim rename";
        header("Location: http://$host/error.php?message=" . $error_message );
    }
}

?>

