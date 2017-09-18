<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
    <head>
      <title>Fiscalité location meublée</title>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="description" content="Location meublée : Faites des économies d'impôts ! En 2min, obtenez une simulation gratuite ! Préférez le régime fiscal REEL SIMPLIFIE au régime MICRO BIC et faites des économies significatives.">
        <meta http-equiv="keyword" content="Simulateur location meublée, Simulateur lmnp, Simulateur, Fiscalité location meublée, Réduction impôt lmnp, Calcul réduction impot lmnp, Calcul location meublée">


        <!-- feuille de style css et bootstrap -->
        <?php        
            echo $this->Html->css('bootstrap.min.css', null, array('inline' => false));
            echo $this->Html->css('bootstrap-theme.min.css', null, array('inline' => false));
            echo $this->Html->css('styles.css?20150106-1', null, array('inline' => false));
        
            //echo $this->Html->script('//code.jquery.com/jquery-1.11.0.min.js');
            echo $this->Html->script('//code.jquery.com/jquery-1.11.0.js');
            //echo $this->Html->script('jquery.tools.min.js');                
            echo $this->Html->script('bootstrap.min.js');
            echo $this->Html->script('script.js');
    
            echo $this->Html->meta('icon');

            echo $this->fetch('meta');
            echo $this->fetch('css');
            echo $this->fetch('script');
        ?>
</head>


<body>
<header><!-- en tête du fichier -->

<div class="col-md-12">
  <div class="row colHeader">
    <div class="col-md-4">
        <a href="/">
        <h1 class="h1-custom inlineBlock">Simulateur <h3 class="h3-custom inlineBlock"> gratuit</h3></h1>
        <h2 class="h2-custom ">Fiscalité des loueurs en meublée</h2>
        </a>
    </div>
    <div class="col-md-3"><!-- social -->
        <a href="#"><img src="/img/logo_linkdin.png" alt="Linkdin" class="iconSocial"></a>
        <a href="#"><img src="/img/logo_Twitter.png" alt="Twitter" class="iconSocial"></a>
        <a href="#"><img src="/img/logo_fb.svg" alt="Facebook" class="iconSocial"></a>
    </div>
    <div class="col-md-5">
      <a href="http://www.compta-loueur-meuble.com"><img src="/img/logoInelys.png" alt="Inelys expertise" id="iconInelys"></a><!-- icon inelys entête droite--> 
    </div>
  </div>
<div class="retourligne"></div>
</div>

</header><!-- fin en tête  -->

 
    <?php echo $this->Session->flash(); ?>
    <?php echo $this->fetch('content'); ?> <!-- correspond à index.ctp dans Simulation -->

<script>
$('.tootltip').tooltip({'container':'body','html':true});

<?if (Configure::read('platform')=='PROD') { ?>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-53254083-1', 'auto');
  ga('send', 'pageview');
<?}?>
</script>
</body>
</html>
