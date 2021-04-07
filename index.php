<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="style/css/bootstrap.min.css" rel="stylesheet">
<title>PDF Re-Namer</title>
</head>
<?php
    $indir = "./scans/incoming/";
    $dir = "./scans/";
    $regex = "/(.*).pdf/";
    $jpg_quality = 100;
    $arr = array();
    $pdf_height = "800";
    $pdf_width = "100%";

    if ($handle = opendir($dir)) {
        $blacklist = array('.', '..', 'incoming', '.DS_Store', '.placeholder', '.AppleDB');
        $ziele = array();
        while (false !== ($file = readdir($handle))) {
            if (!in_array($file, $blacklist)) {
                array_push($ziele, $file);
            }
        }
        sort($ziele);
        closedir($handle);
    }

    // open contract directory and put all files into $arr
    if ( is_dir($indir) )
    {
        if ( $dh = opendir($indir) )
        {
            while ( ($file = readdir($dh)) !== false )
            {
                if ( preg_match($regex,$file) )
                {
                    //echo 'DEBUG: Pushing File ' . $file . '<br>';
                    array_push($arr,$file);
                }
            }

            closedir($dh);
        }
    }
?>
<body>
<?php if ( sizeof($arr) == 0 ) { ?>
    <div class="alert alert-danger" role="alert">Der Ordner f&uuml;r eingescannte Dokumente ist leer.</div>
<?php } else { ?>
    <div class="container-fluid">
        <form action="rename.php" method="get">
            <input name="oldname" type="hidden" value="<? print $arr[0]; ?>">
            <input name="indir" type="hidden" value="<? print $indir; ?>">
            <div class="row">
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" name="newname" id="newname" class="form-control" id="floatingInput" pattern="[a-zA-Z0-9-_]+">
                        <label for="floatingInput">Neuer Name (a-zA-Z0-9-_)</label>
                    </div>
                </div>
                <div class="col">
                    Zielordner:
                    <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="renamed_dir" id="renamed_dir">
                    <?php foreach ($ziele as $ziel) {
                        print "<option value=".$dir."/".$ziel.">$ziel</option>";
                    } ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <button type="submit" class="btn btn-primary">Umbenennen</button>
                </div>
                <div class="col">
                <div class="mb-3">
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" disabled>
Datum_DrName_Kürzel_Details
Datum_Firma_ReNr_Details
Datum_Firma_Kürzel_Details
                </textarea>
            </div>
                </div>
            </div>

        </form>
    </div>
    <br />
    <div><embed src=" <?php echo $indir.$arr[0] ?>" height="<?php echo $pdf_height ?>" width="<?php echo $pdf_width ?>"></div>
<?php } ?>
</body>
</html>

