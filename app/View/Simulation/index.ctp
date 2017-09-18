
<div class="col-md-12">
<div class="row">
    <!-- Bannière information texte -->
    <div class="bannerInfo">
        <p class="Mt10px">Propriétaire d'un bien loué, d'une location saisonnière / Nu ou non meublé ?<br>
            <b>Optimisez votre investissement !</b></p>
    </div>

<!-- Photo centre avec bouton lancement simulation -->
    <img src="/img/accueil.jpg" class="Accueil" />


    <!-- Bannière information -->
    <div class="bannerInfo2">
        <p class="pInfo">Calculer <b>gratuitement</b> et <b>sans engagement</b>, vos économies d'impôts grâce à l'option pour le régime réel simplifié.<br>
            Comment ça marche ? En moins de 2 minutes, obtenez une simulation gratuitement de vos gains fiscaux !</p>
            <a href="#Formulaire" class="btnAccueil">Effectuer une simulation</a>
    </div>
    
<div class="retourligne"></div>  
</div>    
</div>


<!----- Formulaire simulateur -->    
<div class="ColSimulateur col-md-12" id="form_main">
<form action="/" role="form" method="POST" novalidate="novalidate" id="indexForm" accept-charset="utf-8">
<input type="hidden" name="_method" value="POST">

<div class="container">
<?php echo $this->element('main_form'); ?>

<center id="bouton" class="mt25 pb25">
    <input type="submit" class="btnSubmit" id="suivant3" value="Lancer la simulation"/>
</center>

<div class="clearfix"></div>
</div>


</form>

<div class="retourligne"></div>

</div><!-- fin ColSimulateur -->


<!----- FOOTER -->
<div class="col-md-12">
<div class="row colFooter">
    <div class="col-md-4">
        <p class="pFooter1">Inelys, spécialiste de la gestion fiscale des loueurs en meublé, présent en France entière.</p>
    </div>
    <div class="col-md-4">
        <p class="pFooter2">Inelys Expertise <br> Mail: Inelys@inelys.fr <br> Tél : 04.81.11.01.00</p>
    </div>
    
    <div class="col-md-4">
        <p class="pFooter3"><a href="mentions-legales.html">Mentions légales</a></p>
    </div>
</div>
</div>


<script>
$(function() {
    var init=true;            
    
    <?php if (!empty($errors)) {?>
        $('html, body').animate({scrollTop: $("#form_begin").offset().top}, 2000);
    <?php } ?>
    
     $("#indexForm").submit(function(event) {
        $("#bouton").html("Simulation en cours ...");
    });
    
    init=false;
});
</script>
