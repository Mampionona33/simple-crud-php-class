<?php
function class_autoloader($className)
{
    // Liste des dossiers où chercher les classes
    $directories = [
        dirname(__DIR__) . '/controllers/',
        dirname(__DIR__)  . '/models/',
        dirname(__DIR__)  . '/views/',
        // Ajoutez d'autres dossiers si nécessaire
    ];

    foreach ($directories as $directory) {
        $file = $directory . $className . '.class.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }

    echo $className . " not exist";
}
