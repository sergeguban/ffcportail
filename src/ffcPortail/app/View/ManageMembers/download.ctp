Nom;Prénom;Date naissance;Lieu de naissance;Sexe;Adresse;Code postal;Ville;Mail;Téléphone fixe;Gsm;Club;
<?php 
foreach ($members as $member){
   echo       "" . $member['User']['nom']
           . ";" . $member['User']['prenom']
           . ";" . $member['User']['date_naissance']
           . ";" . $member['User']['lieu_de_naissance']
           . ";" . $member['User']['sexe']
           . ";" . $member['User']['adresse']
           . ";" . $member['User']['code_postal']
           . ";" . $member['User']['ville']
           . ";" . $member['User']['mail']
           . ";" . $member['User']['fixephone']
           . ";" . $member['User']['gsm']
           . ";" . $member['User']['club']
           . ";\n";
   
}


?>