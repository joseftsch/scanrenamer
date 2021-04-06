<?

$oldname = $_GET["oldname"];
$newname = $_GET["newname"];
$indir = $_GET["indir"];
$renamed_dir = $_GET["renamed_dir"];
$rotate = isset($_GET["rotate"]) ? $_GET["rotate"] : "";
$host  = $_SERVER['HTTP_HOST'];

$src_file = $indir.$oldname;
$dst_file = $renamed_dir."/".$newname . ".pdf";

//rotate pdf before renaming it
if ( $rotate == 1 )
{
    $mv_orig = "mv " . $src_file . " " . $src_file . "-orig.pdf 2>&1";
    exec($mv_orig,$op_mv_orig, $rv_mv_orig);
    if ( $rv_mv_orig != 0 )
    {
        for ($i = 0; $i < sizeof($op_mv_orig); $i++ )
        {
            $error_message .= $op_mv_orig[$i];
        }

    header("Location: http://$host/error.php?message=" . $error_message );
    }

    $pdf90 = "pdf90 " . $src_file . "-orig.pdf --outfile " . $src_file . "-90-orig.pdf 2>&1";
    exec($pdf90,$op_pdf90,$rv_pdf90);

    if ( $rv_pdf90 != 0 )
    {
        for ($i = 0; $i < sizeof($op_pdf90); $i++ )
        {
            $error_message .= $op_pdf90[$i];
        }

    header("Location: http://$host/error.php?message=" . $error_message );
    }

    $pdf180 = "pdf90 " . $src_file . "-90-orig.pdf --outfile " . $src_file . "  2>&1";
    exec($pdf180,$op_pdf180,$rv_pdf180);

    if ( $rv_pdf180 != 0 )
    {
        for ($i = 0; $i < sizeof($op_pdf180); $i++ )
        {
            $error_message .= $op_pdf180[$i];
        }

    header("Location: http://$host/error.php?message=" . $error_message );
    }

    $rm = "rm " .$src_file . "-90-orig.pdf" . " " . $src_file . "-orig.pdf 2>&1";
    exec($rm,$op_rm,$rv_rm);

    if ( $rv_rm != 0 )
    {
        for ($i = 0; $i < sizeof($op_rm); $i++ )
        {
            $error_message .= $op_rm[$i];
        }
    header("Location: http://$host/error.php?message=" . $error_message );
    }
}

if ( file_exists($dst_file) )
{
    $error_message = "Die Datei ist im Zielordner bereits vorhanden";
    $rv_mv_final = 1;
}
else
{
    $mv_final = "mv " . $src_file . " " . $dst_file . " 2>&1";
    exec($mv_final,$op_mv_final,$rv_mv_final);
}

if ( $rv_mv_final != 0 )
{
    if (isset($op_mv_final)) {
        if ( sizeof($op_mv_final) > 0 )
        {
            for ($i = 0; $i < sizeof($op_mv_final); $i++ )
            {
                $error_message .= $op_mv_final[$i];
            }
        }
    }

    header("Location: http://$host/error.php?message=" . $error_message );
}
else
{
    header("Location: http://$host");
}
?>

