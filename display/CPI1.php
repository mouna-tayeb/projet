<?php           //affiche le tableau de la promo
$cnx=connect();
$req='select u.nom nom,u.prenom prenom, u.idUtil idUtil, e.numEtudiant numEtudiant from utilisateur u, eleve e where e.idPromo="1" AND u.idUtil=e.idUtil';
   $res=execReq($req);
   $promo=0;
   $eleve=0;
   echo'<table>';
   echo'<tr><td>Nom</td><td>Prenom</td><td>Numéro d\'étudiant</td><td>Moyenne</td></tr>';
   while($donnee=mysql_fetch_assoc($res))
   {
        $moyenne=0;
        $coef=0;
        $req2='select  pa.note, ty.coef from participe pa, examen ex, typexam ty where ex.idExam=pa.idExam AND pa.numEtudiant='.$donnee['numEtudiant'].' AND ex.idType=ty.idType';
        $res2=execReq($req2);
        while($note=mysql_fetch_assoc($res2))
        {
           if(($note['note']>=(0))&&($note['note']<=20))
                {
                $moyenne=$moyenne+($note['note']*$note['coef']);
                $coef=$coef+$note['coef'];
                }
        }
        if ($coef==0){$coef=1;};//division par zéro
        $moyenne=$moyenne/$coef;
        $promo=$promo+$moyenne;
        $eleve++;
        if ($donnee['idUtil']==$_SESSION['idUtil']){
                echo'<tr id="perso"><td>'.$donnee['nom'].'</td><td>'.$donnee['prenom'].'</td><td>'.$donnee['numEtudiant'].'</td><td>'.$moyenne.'</td></tr>';
            }
            else{
                echo'<tr><td>'.$donnee['nom'].'</td><td>'.$donnee['prenom'].'</td><td>'.$donnee['numEtudiant'].'</td><td>'.$moyenne.'</td></tr>';
            }
   }
   echo'<tr><td colspan=4> Moyenne generale : <b>'.$promo/$eleve.'</b></td></tr>';
   echo'</table>';
deconnect($cnx); 
?>
