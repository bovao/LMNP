<?php
class DateComponent extends Component{
    var $label_jour=array("","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche");
    var $label_mois=array("","Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
    // Routines a adapter selon les langues à gérer pour correspondre aux formats du pays
        
    // Transforme une date Y-m-d H:i:s en d/m/Y H:i:s
    function dmyhis($dateYmdHis, $timezone=null){
        $jour=substr($dateYmdHis,0,19);
        try {
            $jour=date_create_from_format("Y-m-d H:i:s",$jour);
            if (!is_null($timezone)) {
                date_timezone_set($jour, new DateTimeZone($timezone));
            }
            $date=date_format($jour,"d/m/Y H:i:s");                        
        } catch (Exception $e) {
            $date="Inconnue";
        }
        return $date; 
    }

    // Transforme une date Y-m-d H:i:s en d/m/Y H:i
    function dmyhi($dateYmdHis,$timezone=null){
        $jour=substr($dateYmdHis,0,19);
        try {
            $jour=date_create_from_format("Y-m-d H:i:s",$jour);
            if (!is_null($timezone)) {
                date_timezone_set($jour, new DateTimeZone($timezone));
            }
            $date=date_format($jour,"d/m/Y H:i");                        
        } catch (Exception $e) {
            $date="Inconnue";
        }
        return $date; 
    }
    
    // Transforme une date Y-m-d H:i:s en d/m/Y 
    function dmy($dateYmdHis, $timezone=null){
        $jour=substr($dateYmdHis,0,19);
        try {
            $jour=date_create_from_format("Y-m-d H:i:s",$jour);
            if (!is_null($timezone)) {
                date_timezone_set($jour, new DateTimeZone($timezone));
            }
            $date=date_format($jour,"d/m/Y");                        
        } catch (Exception $e) {
            $date="Inconnue";
        }
        return $date; 
    }
    function date2dmy($date, $timezone=null){
        if (empty($date)) return;        
        $jour=substr($date,0,10);
        try {
            $jour=date_create_from_format("Y-m-d",$jour);
            if (!is_null($timezone)) {
                date_timezone_set($jour, new DateTimeZone($timezone));
            }
            $date=date_format($jour,"d/m/Y");                        
        } catch (Exception $e) {
            $date="Inconnue";
        }
        return $date; 
    }
    
    // Transforme une date Y-m-d H:i:s en H:i:s
    function his($dateYmdHis, $timezone=null){
        $jour=substr($dateYmdHis,0,19);
        try {
            $jour=date_create_from_format("Y-m-d H:i:s",$jour);
            if (!is_null($timezone)) {
                date_timezone_set($jour, new DateTimeZone($timezone));
            }
            $date=date_format($jour,"H:i:s");                        
        } catch (Exception $e) {
            $date="Inconnue";
        }
        return $date; 
    }
    
    // Transforme une date Y-m-d H:i:s en H:i
    function hi($dateYmdHis, $timezone=null){
        $jour=substr($dateYmdHis,0,19);
        try {            
            $jour=date_create_from_format("Y-m-d H:i:s",$jour);
            if (!is_null($timezone)) {
                date_timezone_set($jour, new DateTimeZone($timezone));
            }
            $date=date_format($jour,"H:i");                        
        } catch (Exception $e) {
            $date="Inconnue";
        }
        return $date; 
    }
    
    // Transforme une date Y-m-d H:i:s en lundi xx septembre
    function dmYText($dateYmdHis, $timezone=null){
        $jour=substr($dateYmdHis,0,19);
        try {
            $jour=date_create_from_format("Y-m-d H:i:s",$jour);
            if (!is_null($timezone)) {
                date_timezone_set($jour, new DateTimeZone($timezone));
            }
            $date=$this->label_jour[date_format($jour,"N")]." ".date_format($jour,"d")." ".$this->label_mois[date_format($jour,"n")]." ".date_format($jour,"Y");
        } catch (Exception $e) {
            $date="Inconnue";
        }
        return $date; 
    }
    function dmYText2($datetime, $timezone=null){
        try {            
            $jour=$datetime;
            if (!is_null($timezone)) {
                date_timezone_set($jour, new DateTimeZone($timezone));
            }
            $date=$this->label_jour[date_format($jour,"N")]." ".date_format($jour,"d")." ".$this->label_mois[date_format($jour,"n")]." ".date_format($jour,"Y");
        } catch (Exception $e) {
            $date="Inconnue";
        }
        return $date;
    }

    // Transforme une date Y-m-d H:i:s en lundi xx septembre 14h01
    function dmYHiText($dateYmdHis, $timezone=null){
        if (empty($dateYmdHis)) return;    
        $jour=substr($dateYmdHis,0,19);
        try {
            $jour=date_create_from_format("Y-m-d H:i:s",$jour);
            if (!is_null($timezone)) {
                date_timezone_set($jour, new DateTimeZone($timezone));
            }
            $date=$this->label_jour[date_format($jour,"N")]." ".date_format($jour,"d")." ".$this->label_mois[date_format($jour,"n")]." ".date_format($jour,"Y")." ".date_format($jour,"H")."h".date_format($jour,"i");
        } catch (Exception $e) {
            $date="Inconnue";
        }
        return $date; 
    }
    
    // Transforme une date Y-m-d H:i:s en septembre
    function mText($dateYmdHis, $timezone=null){
        if (empty($dateYmdHis)) return;        
        $jour=substr($dateYmdHis,0,19);
        try {
            $jour=date_create_from_format("Y-m-d H:i:s",$jour);
            if (!is_null($timezone)) {
                date_timezone_set($jour, new DateTimeZone($timezone));
            }
            $date=$this->label_mois[date_format($jour,"n")];
        } catch (Exception $e) {
            $date="Inconnue";
        }
        return $date; 
    }
    
    function highchart_ymdhi($dateYmdHis, $timezone=null){
        // Pour highchart les mois vont de 0 à 11 ..        
        $jour=substr($dateYmdHis,0,19);
        try {
            $jour=date_create_from_format("Y-m-d H:i:s",$jour);
            if (!is_null($timezone)) {
                date_timezone_set($jour, new DateTimeZone($timezone));
            }
            $date=date_format($jour,"Y, ").(date_format($jour,"m")-1).date_format($jour,", d, H, i");                        
        } catch (Exception $e) {
            $date="Inconnue";
        }
        return $date; 
    }
    
    function highchart_ymd($dateYmdHis, $timezone=null){
        // Pour highchart les mois vont de 0 à 11 ..
        $jour=substr($dateYmdHis,0,19);
        try {
            $jour=date_create_from_format("Y-m-d H:i:s",$jour);
            if (!is_null($timezone)) {
                date_timezone_set($jour, new DateTimeZone($timezone));
            }
            $date=date_format($jour,"Y, ").(date_format($jour,"m")-1).date_format($jour,", d");                        
        } catch (Exception $e) {
            $date="Inconnue";
        }
        return $date; 
    }
    
    function javascriptUTCDate($dateYmdHis, $timezone=null){
        // Pour highchart les mois vont de 0 à 11 ..
        $jour=substr($dateYmdHis,0,19);        
        try {
            $jour=date_create_from_format("Y-m-d H:i:s",$jour);
            if (!is_null($timezone)) {
                date_timezone_set($jour, new DateTimeZone($timezone));
            }
            $date=date_format($jour,"U");                        
        } catch (Exception $e) {
            $date="Inconnue";
        }
        return $date; 
    }
    
    // Tranforme un date FR en date EN
    function dateFR2EN($dateFR) {
        $jour=substr($dateFR,0,2);
        $mois=substr($dateFR,3,2);
        $an=substr($dateFR,6,4);
        return $an."-".$mois."-".$jour;
    }
}