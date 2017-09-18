<div id="resultat" class="global centered mt15">
    <center>
        <?=$conclusion?>
       <legend><u>Merci de votre confiance !</u></legend> 
    </center>
    <div id="content_wrapper">
        <div class="columns2"> 
            <div id="solutions">
                Changez de régime fiscal et <span class="">optimisez vos impôts</span> dès maintenant !<br />
                <a href="http://www.compta-loueur-meuble.com" title="Découvrir nos solutions"><input type="button" value="" class="decouvrir" /></a>

            </div>
            <img src="img/clients.jpg" class="mt15" />
            <div id="link_web">
                <a href="http://www.compta-loueur-meuble.com">www.compta-loueur-meuble.com</a>
            </div>
        </div>
        <div class="columns2"> 
            <div id="decouvrir">
                <img src="img/decouvrir_inelys_expertise.png" />
                <p>> Plus de 4000 biens immobiliers gérés chaque année</p>
                <p>> Une expertise reconnue dans la gestion fiscale des locations meublées </p>
                <p>> Société inscrite à l'Ordre des Experts Comptables   </p>
                 <p>> Des équipes dédiées et spécialisées</p>
                <hr />
                <center>
                <span class="tel">Tél. 04 81 11 01 00</span><br />
                <a href="mailto:inelys@inelys.fr" class="email">inelys@inelys.fr</a><br />
                <div class="mt15">
                Contactez nos équipes spécialisées !<br />Les conseillers Inelys sont à votre écoute<br /> pour répondre à toutes vos questions.
                </div>
                </center>


            </div>
            <div id="kit" class="mt15">
                Le kit fiscal INELYS EXPERTISE : <br />
                Vos avantages ...<br />

                <p>>  Optimisez vos impôts et faites des économies</p>
                <p>>  Confiez la gestion fiscale à des experts</p>

            </div>
        </div>
        <div class="clearfix"></div>
    </div>
<br />
    <center id="bouton" class="mt25 pb25">
        <input type="button" value="" id="new" class="new" />
    </center>
<br />
<br />
    </div>
    <div class="centered">
    <div id="mentionsLnk"><a href="/Mentions-legales" title="Voir les mentions légales">Mentions l&eacute;gales</a></div>&nbsp;
    </div>
    <div class="cl">&nbsp;</div>
<?if ($debug) {?>
<fieldset>
    <legend>Résultats</legend>
    <table class="table table-bordered table-striped">
    <thead>
    <tr>
        <td></td>
        <th><?=$outLabelSituationActuelle?></th>
        <th>Revenus meublés au régime réel BIC</th>
        <th>Gain sur 1 an</th>
        <th>Gain sur 10 ans</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Loyers</td>
        <td><?=$rfloyann?></td>
        <td><?=$brloyann?></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>- charges locatives</td>
        <td><?=$rfchloc?></td>
        <td><?=$brchloc?></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>- intérêts emprunts</td>
        <td><?=$rfintemp?></td>
        <td><?=$brintemp?></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>- amortissement</td>
        <td></td>
        <td><?=$brmttamo?></td>
        <td></td>
        <td></td>
    </tr>
    <tr><td colspan="5">&nbsp;</td></tr>
    <tr>
        <td>Revenu imposable</td>
        <td><?=$rfrevimp?></td>
        <td><?=$brrevimp?></td>
        <td></td>
        <td></td>
    </tr>
    <tr><td colspan="5">&nbsp;</td></tr>
    <tr>
        <td>Imposition</td>
        <td><?=$rfmttimp?></td>
        <td><?=$brmttimp?></td>
        <td><?=$g1mttimp?></td>
        <td><?=$g10mttimp?></td>
    </tr>
    </tbody>
    </table>
</fieldset>
<?debug($tabIntEmp);?>
<?}?>
<script>
$(function() {
    $("#new").click(function() {
        document.location.href="/";
    });
});
</script>