    <!DOCTYPE html>
    <html lang="en">
        <head>
            <title></title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link href="css/style.css" rel="stylesheet">
        </head>
        <body>
<div id="contenu">
    <?php 

function listDirectory(string $chemin){
    $typeNotAccepted = ['image/jpeg'];
    $dir = opendir($chemin);
    echo '<ul>';

    while($file = readdir($dir))
    {
        if(!is_dir($chemin.$file))
        {
            echo '<li>';
            if(!in_array(mime_content_type($chemin.$file),$typeNotAccepted))
                {
                    echo '<a href="?f='.$chemin.$file.'">'.$file.'</a>';
                }
            else
                {
                    echo $file;
                }
        echo '   <a class="deleteLink" href="?del='.$chemin.$file.'">Delete</a>';
        echo '</li>';     
        }
        elseif(!in_array($file,array(".",".."))){
            echo '<li>'.$file.'  <a class="deleteLink" href="?delf='.$chemin.$file.'">Delete</a></li>';
            listDirectory($chemin.$file.'/');           
        }
    }
    echo '</ul>';
} 

    //CANCELLA CORRETTAMENTE
    /* function eraseFichier($chemin){
        unlink($chemin);
    }
    eraseFichier('files/TEST2.PHP'); */

    function deleteFile($file)
    {
        if(file_exists($file))
        {
            unlink($file);
        }
    }

    function deleteFolder($folder)
    {
        return rmdir($folder);
    }

    if(isset($_POST["contenu"]))
    {
        $fichier = $_POST["file"];;
        $file= fopen($fichier,"w");
        fwrite($file,$_POST["contenu"]);
        fclose($file);
    }
    if(isset($_GET['del']))
    {
        deleteFile($_GET['del']);
    }
    if(isset($_GET['delf']))
    {
        if(!deleteFolder($_GET['delf']))
        {
            echo "Please delete all the files before deleting the folder";
        }
    }
    ?>
    <?php include('inc/head.php'); ?>

    <div>    
        <?php
        $origin = 'files/';
        listDirectory($origin);
        ?>
    </div>

/*    listDirectory("files/uk");
    listDirectory("files/roswell");  
 */    
 <?php
    if(isset($_GET["f"]))
    {
        $fichier = $_GET["f"];
        $contenu = file_get_contents($fichier);   
?>

        <form method="POST" action="">
            <textarea name="contenu" cols="30" rows="10" style="width:100%;eight:200px;">
                <?php echo $contenu ?>
            </textarea>
            <input type="hidden" name="file" value="<?php echo $fichier?>">
            <input type="submit" value="Envoyer">        
        </form>
    <?php
         }
    ?>
</div>
    </body>
    </html>

<?php include('inc/foot.php'); ?>