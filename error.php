<!DOCTYPE html>
<html>
<head>
<title>!!FEHLER!!</title>
</head>
<body>
<b>Fehler:</b>
<?
$error_message = $_GET["message"];
$host  = $_SERVER['HTTP_HOST'];
print "<div>" . $error_message . "</div>";
?>
    <br>
    <div>
        <a href="<? print "http://$host" ?>">Startseite</a>
    </div>
</body>
</html>

