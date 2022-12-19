<?php
//mot de passe coucou
$connexionBdd = mysqli_connect("localhost", "root", "");
mysqli_set_charset($connexionBdd, "utf8");
$selectionBdd = mysqli_select_db($connexionBdd, "egs_ladder");

$amount = 100;

for($i = 1; $i <= $amount; $i++){
    //creer 100 utilisateurs
    $requete = "INSERT INTO user(email, roles, password, name, firstname)
                VALUES ('test$i@gmail.com','[\"string\"]','$2y$13\$TH4/O/TS8ZdkpIZJ8l3e8Oabxz5NXexL0oeS944Pay1IyVsa7rVue','test$i','prenom$i')";
  
    $resultat = mysqli_query($connexionBdd, $requete);
    //$insertId = mysqli_insert_id();
        //creation des elos tous les jours sur 1 an
        for($k = 1; $k <= 365; $k++){
                $eloRandom = rand(0, 15000);
                $requete = "INSERT INTO to_play(date_register_elo, date_start, date_end, elo, pseudonyme, account_id, user_id, game_id)
                VALUES (NOW() + INTERVAL $k DAY,'2022-08-22 08:53:02',NULL,'$eloRandom','pseudo $i','12344566','$i','6')";
            $resultat = mysqli_query($connexionBdd, $requete);            

        }
        
}


