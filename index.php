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
    $regex = "/(.*).pdf/i";
    $jpg_quality = 100;
    $arr = array();
    $pdf_height = "800";
    $pdf_width = "100%";
    $blacklist = array('.', '..', 'incoming', '.DS_Store', '.placeholder', '.AppleDB');
    $blacklist2 = array('.', '..', 'incoming', '.DS_Store', '.placeholder', '.AppleDB', './scans','./scans/incoming');

    $iter = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach($iter as $file) {
        if ($file->getFilename() == '.') {
            if (!in_array($file->getPath(), $blacklist2)) {
                $ziele[] = $file->getPath();
            }
        }
    }
    sort($ziele);

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
                        <input type="text" name="newname" id="newname" class="form-control" id="floatingInput" pattern="[a-zA-Z0-9-_]+" tabindex=1 autofocus>
                        <label for="floatingInput">Neuer Name (a-zA-Z0-9-_)</label>
                    </div>
                </div>
                <div class="col">
                    Zielordner:
                    <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="renamed_dir" id="renamed_dir" tabindex=2>
                    <?php foreach ($ziele as $ziel) {
                        $ziel = substr($ziel, strlen($dir));
                        print "<option value=".$dir."/".$ziel.">$ziel</option>";
                    } ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <button type="submit" class="btn btn-primary" tabindex=3>Umbenennen</button>
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
    <?php
        echo "Derzeitiger Name: ".substr(strrchr($indir.$arr[0], "/"), 1);
    ?>
    <br />
    <div><embed src=" <?php echo $indir.$arr[0] ?>" height="<?php echo $pdf_height ?>" width="<?php echo $pdf_width ?>"></div>
<?php } ?>
</body>
</html>

