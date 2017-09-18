<div class="partie"><!----- Partie 3 : Coordonnées -->
<fieldset>
<legend><u>Vos coordonnées</u></legend> 
    <p>Dès validation, vous obtenez <b>le montant des économies </b> réalisées avec le régime réel <br>
    Les détails des calcules vous sont automatiquement <b>transmis par mail</b>.</p>

<div clas="row">
<div class="columns2 col-md-6">
        <div class="field is-focused form-group <?=(array_key_exists('email',$errors)? "has-error":"")?> ">
        <label for="" class="field-label etape3 control-label">Email</label>
        <input type="email" name="data[SimulationProspect][email]" class="field-input etape3" maxlength="150" tabindex="20">
        <?=(array_key_exists('email',$errors)? "<div class='error-message'>".$errors['email'][0]."</div>":"")?>
        <p class="error"></p>
        </div>
    
        <div class="field is-focused form-group <?=(array_key_exists('nom',$errors)? "has-error":"")?> ">
        <label for="" class="field-label etape3 control-label">Nom</label>
        <input type="text" name="data[SimulationProspect][nom]" class="field-input etape3" maxlength="50" tabindex="21">
        <?=(array_key_exists('nom',$errors)? "<div class='error-message'>".$errors['nom'][0]."</div>":"")?>
        <p class="error"></p>
        </div>
</div>    

<div class="columns2 col-md-6">
        <div class="field is-focused form-group <?=(array_key_exists('prenom',$errors)? "has-error":"")?> ">
        <label for="" class="field-label etape3 control-label">Prénom</label>
        <input type="text"  name="data[SimulationProspect][prenom]" class="field-input etape3" maxlength="50" tabindex="22">
         <?=(array_key_exists('prenom',$errors)? "<div class='error-message'>".$errors['prenom'][0]."</div>":"")?>
        <p class="error"></p>
        </div>
        
        <div class="field is-focused form-group <?=(array_key_exists('tel',$errors)? "has-error":"")?> ">
        <label for="commentLoue" class="field-label etape3 control-label">Téléphone</label> 
        <input type="number" id="valeurMobilie" name="data[SimulationProspect][tel]" class="field-input etape3" maxlength="10" tabindex="23">
         <?=(array_key_exists('tel',$errors)? "<div class='error-message'>".$errors['tel'][0]."</div>":"")?>
        <p class="error"></p>
        </div>
</div>
</div>
    <input type="submit" class="btnSubmit" id="suivant3" value="Lancer la simulation"/>
    <div class="clearfix"></div>
</fieldset>
</div><!-- /Fin Partie 3 -->




<!----- Partie 4 : Information envoi email -->
<!-- <div class="partie">
<fieldset>
<legend><u>Merci de votre confiance !</u></legend> 
    <p>Dès validation, vous obtenez <b>le montant des économies </b> réalisées avec le régime réel <br>
    Les détails des calcules vous sont automatiquement <b>transmis par mail</b>.</p>

<div clas="row">
    <div class="columns2 col-md-6">
        <div id="solutions">
            Changez de régime fiscal et <span class="">Optimisez vos impôts</span> dès maintenant ! <br />
            <a href="http://www.compta-loueur-meuble.com" title="Découvrir nos solutions"><input type="button" value="" class="decouvrir"></a>
        </div>

        <img src="/img/clients.jpg" class="custom-img"/>
        <div id="link_web">
            <a href="http://www.compta-loueur-meuble.com">www.compta-loueur-meuble.com</a>
        </div>
    </div>    

    <div class="columns2 col-md-6">
        <div id="decouvrir">
            <img src="/img/decouvrir_inelys_expertise.png"/>
            <p>> Plus de 4000 biens imobiliers géré chaque année</p>
            <p>> Une expertise reconnue dans la gestion fiscale des locations meublées</p>
            <p>> Société inscrite à l'Ordre des Experts Comptables
            <p>> Des équipes dédiées et spécialisées</p>
            <hr class="custom-hr"><br />
            <center >
            <span class="tel">Tél : 04.81.11.01.00</span><br/>
                <a href="mailto:inelys@inelys.fr" class="email">inelys@inelys.fr</a><br/>
                <div class="mt15">
                <p>Contactez nos équipes spécialisées ! <br/> Les conseillers Inelys sont à votre écoute <br/> pour répondre à toutes vos questions.</p>
                </div>
            </center>
        </div>

        <div class="retourligne"></div>
        <div id="kit" class="mt15">
            <p>Le kit fiscal Inelys Expertise : <br />
            Vos avantages ...<br /></p>

            <p>> Optimisez vos impôts et faites des économies</p>
            <p>> Confiez la gestion fiscale à des experts</p>
        </div>    
    </div><!-- end col-md-6 columns2
</div><!-- end row -->
<!-- <div class="clearfix"></div>
    
</fieldset>
<br />
    
<center id="bouton" class="mt25 pb25">
    <input type="button" value="" id="new" class="new">
</center>
</div><!----- /Fin Partie 4 -->