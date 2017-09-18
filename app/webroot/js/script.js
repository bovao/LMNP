$(window).on("load", function() {

//remonte la page on refresh
 $("html,body").animate({scrollTop: 0}, 'slow');

    
// Effets ancre
    $('a[href^="#"]').click(function(){
	var the_id = $(this).attr("href");

	$('html, body').animate({
		scrollTop:$(the_id).offset().top
	}, 'slow');
	return false;
});

  //  Au focus
  $('.field-input').focus(function(){
    $(this).parent().addClass('is-focused has-label');
  });

  // à la perte du focus des inputs
  $('.field-input').blur(function(){
    $parent = $(this).parent();
      
    //si les champs sont vide, erreur à coté du champs
    if($(this).val() === ''){
      $parent.removeClass('has-label');
        var $error = $('error');
        $(this).next($error).show().text("Merci de renseigner ce champ");
    } 
    //Si non, on masque l'erreur du input, et on opacite le btnsuivant à 1
    else if($(this).val() !== '') {
        $(this).next($error).hide();
        $(btSuivant[0]).css({'opacity':'1', 'cursor':'pointer'});
    }
    $parent.removeClass('is-focused');
  });
    
    
  // si un champs est rempli on rajoute directement la class has-label
  $('.field-input').each(function(){
    if($(this).val() != ''){
      $(this).parent().addClass('has-label');
    }
  });
        
         
    //2. compter le nombre de partie
    var mesParties = $('.partie');
    var nbreParties = mesParties.lenght;
    
    $(mesParties).css({'visibility':'hidden', 'display':'none', 'z-index':'50'});       //2.a masque tout les partie sauf la partie 1ère
	$(mesParties[0]).css({'visibility':'visible', 'display':'block', 'z-index':'60'});    //affiche la partie 1
    //!!! pensez à remettre partie[0]    
    
    
    //2.b masque les erreurs
    $('p.error').css({'display':'none', 'visiblity':'hidden'});
    
    //3. compte le nombre de bouton suivant
    var btSuivant = $('.suivant');
    var nbSuivant = btSuivant.length;
    
    //3.a donne opacite au bouton suivant partie 1
    $(btSuivant[0]).css({'opacity':'0.5', 'cursor':'default'});

    
    
    //fonction verifie champs formulaire partie 1
    function verifEtape1(){
    var test = '';
    $('.etape1').each(function(){
        $parent = $(this).parent();
        var $error = $('error');
        //Si vide
        if($(this).val() == ''){
            //affiche error (<p class="error">)
            $(this).next($error).show().text("Merci de renseigner ce champ");
            test = true;
        }
        else if($('.etape1').val() != ''){
            $(this).next($error).hide();
            test = false;
        }
    });
    return test;
};
    
//function verifRadioEtape1(){
//    if( $('#commentLoue').attr('checked')  ){
//        test = false;
//    }else {
//        $(this).next($error).show().text("Merci de cocher ce champ");
//        test = true;
//    }
//}
    
    //affiche la partie financement 2
    $(btSuivant[0]).click(function(){
        //vérifie que les étapes sont rempli et que les inputs ont bien la class has-label
        if(verifEtape1() != true){
            Suivant(1);
        }

    //affiche la partie coordonées 3
    $(btSuivant[1]).click(function(){
            if(test() != true){
                Suivant(2);
            }
    })

       //QUand on clic sur .numero ex: 2 affiche la partie 2 et disabled les autres partie : retour arrière partie
});



    //fonction verifie champs formulaire partie 2
    $('#bouton').css({'display':'none'});
    function test(){
        
        var value = $(".empruntSel:checked").val();
        var $error = $('error');
        var result = '';
        
        //si radio n'est pas cocher 
        if(value == undefined){
           alert('Vous devez cocher une case');
            $(this).next($error).show().text("Merci de renseigner ce champ");
            result = true;
        }
        
        $('.etape2').each(function(){
            $parent = $(this).parent();

            if($(this).val() == '' && value == "1" ){
                $(this).next($error).show().text("Merci de renseigner ce champ");
                result = true;
            }

            else if($(this).val() != '') {
                $(this).next($error).hide();
                result = false;
                
            }

        $('#bouton').css({'display':'block'}); // si etape2 complet affiche bouton de lancement

        });
    return result;
};
    
 	numero=0;
	function Suivant(parametre){
		numero = parametre;
		$(mesParties).toggle("slide");
		$(mesParties).css({'visibility':'hidden', 'display':'none', 'z-index':'50'});
        
		$(mesParties[numero]).css({'visibility':'visible', 'display':'block', 'z-index':'60'}); 
		var HauteurPartie = $(mesParties[numero]).height();
        
        $('#a'+[numero]).addClass('complet');
        $('#a'+[numero]).removeClass('active');
        $('#a'+[numero + 1]).addClass('active'); 
	};


$('#locasaison').css({'display':'none'});
//retourne la valeur du input radio comment louer
$(".inmodelocSel").change(function(){
    var value = $(".inmodelocSel:checked").val();
    if(value == "M"){
      $("#locasaison").slideDown("slow");
      $('#locasaison').css({'display':'block'});
    }
   else if(value == "N"){
     $("#locasaison").slideUp("slow");  
    }
});



// pour empruntFianan : Avez-vous emprunté pour financer votre bien ?
$('#invisible').css({'display':'none'});
    
$(".empruntSel").change(function(){
    var value = $(".empruntSel:checked").val();
    if(value == "1"){
        $("#invisible").slideDown("slow");
        $('#invisible').css({'display':'block'});
    }
    else if(value == "0"){
     $("#invisible").slideUp("slow");  
    }
});




    
    
    
    
});