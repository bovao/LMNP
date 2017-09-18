$(document).ready(function(){
     
     
    // the french localization
    $.tools.dateinput.localize("fr",  {
        months:        'janvier,f&eacute;vrier,mars,avril,mai,juin,juillet,' +
        'ao&ucirc;t,septembre,octobre,novembre,d&eacute;cembre',
        shortMonths:   'jan,f&eacute;v,mar,avr,mai,jun,jul,' +
        'ao&ucirc;,sep,oct,nov,d&eacute;c',
        days:          'Dimanche,Lundi,Mardi,Mercredi,Jeudi,Vendredi,Samedi',
        shortDays:     'dim,lun,mar,mer,jeu,ven,sam'
    });

       
       
    $.each($(".date-input-js"), function(i, value) {
        var dateInput = [];   
        var frontInput = [];
        
        dateInput[i] = $(":hidden",value);
        frontInput[i] = $(".frontdate",value);
        
        init(dateInput[i],frontInput[i]);

    });


    function init(date,front) {
        initDate = date.val();
        front.dateinput({
            lang: 'fr',
            firstDay: 1,
            format: 'dddd dd mmmm yyyy',
            offset: [30, 0],
            value : initDate,
            selectors : true,
            change: function() {
                isoDate = this.getValue('yyyy-mm-dd');
                date.val(isoDate).trigger('change');
            }
        });
           
    }
                   
                
                
});