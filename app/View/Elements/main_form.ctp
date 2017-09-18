
<div class="container">
    <div class="container">
        <!----- Etape formulaire -->
        <div class="row etapes" id="boutons">
            <div class="col-md-3 etape active" id="a1">
                <div class="numero">1</div>
                <p class="texteEtape">Investisssement</p>
            </div>
            <div class="separateur-etape"></div>
            
              <div class="col-md-3 etape" id="a2">
                <div class="numero">2</div>
                <p class="texteEtape">Financement</p>
            </div>
            <div class="separateur-etape"></div>
            
            <div class="col-md-3 etape" id="a3">
                <div class="numero">3</div>
                <p class="texteEtape">Coordonnées</p>
            </div> 
        <div class="retourligne"></div>
        </div>
    </div>
<a id="Formulaire"></a><!-- ancre-->


  <div class="partie col-md-12"><!----- Partie 1 : Investissement -->
    <fieldset id="form_begin">
        <legend><u>Votre investissement</u></legend> 
        <div class="columns2 col-md-6">
            <div class="field is-focused form-group <?=(array_key_exists('invabi',$errors)? "has-error":"")?> ">
                <label for="" class="field-label control-label">Valeur <strong><u>estimée</u></strong> de votre bien immobilier €</label>
                <?php echo $this->Form->text('SimulationLmnp.invabi', array('div' => false, 'class' => 'field-input etape1 obligatoire', 'label' => false)); ?> 

                <?=(array_key_exists('invabi',$errors)? "<div class='error-message'>".$errors['invabi'][0]."</div>":"")?>
                <p class="error"></p>
            </div>
            
            <div class="field is-focused form-group <?=(array_key_exists('indabi',$errors)? "has-error":"")?> "> 
            <label for="" class="field-label control-label">Année d'acquisition</label>
            <?php echo $this->Form->text('SimulationLmnp.indabi', array('div' => false, 'class' => 'field-input etape1 obligatoire', 'label' => false)); ?> 
            <?=(array_key_exists('indabi',$errors)? "<div class='error-message'>".$errors['indabi'][0]."</div>":"")?>
            <p class="error"></p>
            </div>
            

            <div class="custom-field is-focused form-group <?=(array_key_exists('inmodeloc',$errors)? "has-error":"")?>">
            <label for="" class="control-label top6px">Comment votre bien est il loué aujourd'hui ? €</label><br/>
            <input type="radio" name="data[SimulationLmnp][inmodeloc]" class="obligatoire custom-radio inmodelocSel" value="N" required="true" checked="checked"
            <?=(isset($data['SimulationLmnp']['inmodeloc']) && $data['SimulationLmnp']['inmodeloc']=='N')?"checked":""?> />Nu

            <input type="radio" name="data[SimulationLmnp][inmodeloc]" class="obligatoire custom-radio inmodelocSel" value="M" required="true"
            <?=(isset($data['SimulationLmnp']['inmodeloc']) && $data['SimulationLmnp']['inmodeloc']=='M')?"checked":""?> />Meublé

            <?=(array_key_exists('inmodeloc',$errors)? "<div class='error-message'>".$errors['inmodeloc'][0]."</div>":"")?>
            <p class="error"></p>
            </div>     
            
            
            <div id="locasaison" class="is-focused custom-field2 form-group <?=(array_key_exists('inlocsai',$errors)? "has-error":"")?>">
            <label for="" class="control-label">Est-ce une location à courte durée, ayant fait l'objet d'un classement ? <img src="img/help.png" class="help tootltip" data-toggle="tooltip" data-placement="top" title="Location de courte durée, inférieure à 90 jours" /></label><br>
            <input type="radio" name="data[SimulationLmnp][inlocsai]" class="obligatoire custom-radio " value="1" required="true"
             <?=(isset($data['SimulationLmnp']['inlocsai']) && $data['SimulationLmnp']['inlocsai']==1)?"checked":""?> />Oui

            <input type="radio" name="data[SimulationLmnp][inlocsai]" class="obligatoire custom-radio " value="0" required="true"
             <?=(isset($data['SimulationLmnp']['inlocsai']) &&  $data['SimulationLmnp']['inlocsai']==0)?"checked":""?> />Non

             <?=(array_key_exists('inlocsai',$errors)? "<div class='error-message'>".$errors['inlocsai'][0]."</div>":"")?>
            <p class="error"></p>
            </div>
        </div><!-- end columns2 -->
        

    <div class="columns2 col-md-6">     
            <div class="field is-focused form-group <?=(array_key_exists('invamo',$errors)? "has-error":"")?> ">
            <label for="" class="field-label control-label">Valeur actuelle du mobilie € <img src="img/help.png" class="help tootltip" data-toggle="tooltip" data-placement="top" title="Il s'agit de la valeur du mobilier acquis pour meubler l'appartement : table, chaises, lit, armoire ..." /></label>
            <input type="number" name="data[SimulationLmnp][invamo]" class="field-input etape1 obligatoire" required="true">
            <?=(array_key_exists('invamo',$errors)? "<div class='error-message'>".$errors['invamo'][0]."</div>":"")?>    
            <p class="error"></p>
            </div>

            <div class="field is-focused form-group <?=(array_key_exists('inloyann',$errors)? "has-error":"")?> ">
            <label for="loyerAnnuels" class="field-label control-label">Vos loyers annuels €</label>
            <input type="number" name="data[SimulationLmnp][inloyann]" class="field-input etape1 obligatoire" required="true">

            <?=(array_key_exists('inloyann',$errors)? "<div class='error-message'>".$errors['inloyann'][0]."</div>":"")?>
            <p class="error"></p>
            </div>

            <div class="field is-focused form-group <?=(array_key_exists('inchann',$errors)? "has-error":"")?> ">
            <label for="" class="field-label etape1 control-label">Vos charges annuelles, hors emprunt € <img src="img/help.png" class="help tootltip" data-toggle="tooltip" data-placement="top" title="Il s'agit des charges payées : charges de copropriété, assurance, taxe foncière ... hors emprunt" /></label>
            <input type="number" id="chargeAnnuelles" name="data[SimulationLmnp][inchann]" class="field-input etape1 obligatoire" required="true">
             <?=(array_key_exists('inchann',$errors)? "<div class='error-message'>".$errors['inchann'][0]."</div>":"")?>
            <p class="error"></p>
            </div>
    </div>
            <span class="btnSubmit suivant" id="suivant1" >Etapes suivante</span>
            <div class="clearfix"></div>
</fieldset>        
        
</div><!----- /Fin Partie 1 -->




<!-- Partie 2 : Financement -->
<div class="partie"><!----- Partie 2 : Financement -->

<fieldset>
<legend><u>Votre Financement</u></legend> 

    <div class="row">
        <div class="field3 is-focused custom-field2 form-group <?=(array_key_exists('inempon',$errors)? "has-error":"")?> ">
        <label for="" class="color999 top6px">Avez-vous emprunté pour financer votre bien ?</label>
        <input type="radio" name="data[SimulationLmnp][inempon]" class="obligatoire custom-radio empruntSel" value="1" required="true" 
        <?=(isset($data['SimulationLmnp']['inempon']) && $data['SimulationLmnp']['inempon']==1)?"checked":""?> />Oui
        <input type="radio" name="data[SimulationLmnp][inempon]" class="obligatoire custom-radio empruntSel" value="0" required="true" 
        <?=(isset($data['SimulationLmnp']['inempon']) &&  $data['SimulationLmnp']['inempon']==0)?"checked":""?> />Non

        <?=(array_key_exists('inempon',$errors)? "<div class='error-message'>".$errors['inempon'][0]."</div>":"")?>
        <p class="error"></p>
        </div>
        <div class="retourligne"></div>
    </div>
    
<div class="container" id="invisible">
<div class="columns2 col-md-6">
        <div class="field is-focused form-group <?=(array_key_exists('inempmtt',$errors)? "has-error":"")?>">
        <label for="" class="field-label etape2 control-label">Montant de votre emprunt €</label>
        <input type="number" name="data[SimulationLmnp][inempmtt]" class="field-input etape2">
        <?=(array_key_exists('inempmtt',$errors)? "<div class='error-message'>".$errors['inempmtt'][0]."</div>":"")?>
        <p class="error"></p>
        </div>
    
        <div class="field4 is-focused form-group <?=(array_key_exists('inempduree',$errors)? "has-error":"")?>">
        <label for="duree" class="top6px control-label">Durée</label>
            <select name="data[SimulationLmnp][inempduree]" class="customSelect">
            <option disabled selected value> -- Nombre d'année -- </option>
            <option>1 ans</option>
            <option>30 ans</option>
            </select>
        <?=(array_key_exists('inempduree',$errors)? "<div class='error-message'>".$errors['inempduree'][0]."</div>":"")?>
        <p class="error"></p>
        </div>
</div>
    
<div class="columns2 col-md-6">
       <div class="field is-focused form-group <?=(array_key_exists('inemptx',$errors)? "has-error":"")?>">
        <label for="" class="field-label etape2 control-label">Taux %</label>
        <input type="number" name="data[SimulationLmnp][inemptx]" class="field-input etape2">
        <?=(array_key_exists('inemptx',$errors)? "<div class='error-message'>".$errors['inemptx'][0]."</div>":"")?>
        <p class="error"></p>
        </div>

     <div class="field4 is-focused form-group <?=(array_key_exists('intxmarg',$errors)? "has-error":"")?> ">
        <label for="" class="top6px control-label">Votre taux marginal d'imposition (TMI)
        <img src="img/help.png" class="help tootltip" data-toggle="tooltip" data-placement="top"  title="Le taux marginal d'imposition est la tranche maximum du barème qui vous est applicable.
<div style='text-align:left'>Exemple : <br />- Couple sans enfant : 
<div style='padding-left:25px'>Revenu imposable = 60 000 € -> TMI = 30% <br /> Revenu imposable = 30 000 € -> TMI = 14%</div>
- Couple avec 2 enfants : 
<div style='padding-left:25px'>Revenu imposable = 60 000 € -> TMI = 14% <br /> Revenu imposable = 30 000 € -> TMI = 5,5 %</div>
- Vous ne payez pas d'impôt, TMI = 0</div>" /></label>
            <select name="data[SimulationLmnp][intxmarg]" class="customSelect">
            <option disabled selected value> -- Pourcentage -- </option>
            <option>0 %</option>
            <option>14 %</option>
            <option>30 %</option>
            <option>41 %</option>
            <option>45 %</option>
            </select>
        <p class="error"></p>
        </div>    
</div>
</div>    
        <span class="btnSubmit suivant" id="suivant2" >Etapes suivante</span>
        <div class="clearfix"></div>
</fieldset>
</div><!----- /Fin Partie 2 -->
    



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


</fieldset>
</div><!-- /Fin Partie 3 -->























<!-- end container formulaire -->

