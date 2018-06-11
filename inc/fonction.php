<?php 

# création d'une fonction pour afficher les var_dump et print_r : 
function debug($var, $mode = 1) {
    echo '<div style="color: white; font-weight: bold; text-align: center; padding: 20px; background: #' . rand(111, 999) . '">';

    $trace = debug_backtrace(); #récup infos où il y a une erreur
    $trace = array_shift($trace); #casse le 1er rang d'un array multidimensionel pr renvoyer les premiers résultats

    echo "Le débug a été ddé ds le fichier $trace[file] à la ligne $trace[line] <hr>";
   
    echo "<pre style='color: white; text-align: center;'>";

    switch ($mode) {
        case '1': 
            var_dump($var);
            break;
        default : 
            print_r($var);
            break;
    }
    
    echo "</pre>";

    echo '</div>';
}

# création d'une fonction pour vérifier user = connecté 
function userConnect() {
    if(isset($_SESSION['membre'])) return TRUE; // le fait de n'avoir qu'un élément conditionné permet cette syntaxe simplifiée
    else return FALSE;
}

# création d'une fonction pour vérifier si l'user = admin
function userAdmin() {
    if(userConnect() && $_SESSION['membre']['statut'] == 1) return TRUE;
    else return FALSE;
}

?>