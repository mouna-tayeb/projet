<?php
if (securite(2))
{
    if(isset($_POST['DS'])){
    $cnx=connect();
    $req='SELECT el.idUtil FROM eleve el, participe pa WHERE pa.idExam="'.$_POST['DS'].'" AND pa.numEtudiant=el.numEtudiant';
    $res=execReq($req);
    while($donnee=mysql_fetch_assoc($res))
    {
        $req2='UPDATE participe pa, eleve el SET pa.note="'.$_POST['note_'.$donnee['idUtil'].''].'" WHERE pa.numEtudiant=el.numEtudiant AND el.idUtil="'.$donnee['idUtil'].'"';
        $res2=execReq($req2);
    }
    foreach (($_POST['util']) as $nb){
    $req='INSERT INTO participe VALUES("'.$nb.'","'.$_POST['DS'].'","")';
    $res=execReq($req);
    }
    deconnect($cnx);
    echo'les notes ont bien été modifiées';
    }
    else{
?>
    <form id="form_module" name="form1" action="#" method="POST">
        <fieldset>
            <label>Choix du module :</label>
                 <select OnChange="afficher_matiere2()" id="module">
                    <option></option>
                        <?php
                            $cnx=connect();
                            if ($_SESSION['idRole']==2){
                                $req='select * from module m, eleve e  where e.idUtil="'.$_SESSION['idUtil'].'" and e.idPromo=m.idPromo';
                            }
                            else {
                                $req='select * from module';
                            }
                            $res=execReq($req);
                            while($module=mysql_fetch_assoc($res))
                            {
                            echo'<option  value="'.$module['idMod'].'">'.$module['libelle'].'</option>';
                            }
                            deconnect($cnx);
                        ?>
                  </select>
            <div id="affmat">
            </div>
             <div id="affds">
            </div>
            <div id="affnote">
            </div>
            <div id="choixeleve">
            </div>
    </form>
            
<?php } }
else
{
     echo'<SCRIPT LANGUAGE="JavaScript">
     document.location.href="index.php" 
</SCRIPT>';
}

?>