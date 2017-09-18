<?php
class ToolsHelper extends AppHelper{
    var $helpers = array('Session');
    
    // Formatage automatique ou formatage dirigé de nombre            
    function formatNombreAuto($valeur,$type) {
        if (strtolower($type)=="euro") {
            if ($valeur<10) {
                return $this->formatNombre($valeur,2);
            } elseif ($valeur<100) {
                return $this->formatNombre($valeur,1);
            }else {
                return $this->formatNombre($valeur,0);
            }
        }
        if (strtolower($type)=="kwh" or strtolower($type)=="m3") {
            if ($valeur<10) {
                return $this->formatNombre($valeur,3);
            } elseif ($valeur<100) {
                return $this->formatNombre($valeur,1);
            }else {
                return $this->formatNombre($valeur,0);
            }
        }        
        if (strtolower($type)=="l") {
            if ($valeur<10) {
                return $this->formatNombre($valeur,1);
            } elseif ($valeur<100) {
                return $this->formatNombre($valeur,1);
            }else {
                return $this->formatNombre($valeur,0);
            }
        }
        if (strtolower($type)=="wh") {
            if ($valeur<10) {
                return $this->formatNombre($valeur,0);
            } elseif ($valeur<100) {
                return $this->formatNombre($valeur,0);
            }else {
                return $this->formatNombre($valeur,0);
            }
        }
        if (strtolower($type)=="°c") {
                return $this->formatNombre($valeur,1);
        }        
    }
    function formatNombre($valeur,$decimal=0) {
        // Number_format n'enlève pas les zéro non significatifs (contrairement à ce qui est dit sur php.net à piori) donc on ajoute un round
        if (is_numeric($valeur)) {
            if ($decimal>0) {
                return rtrim(rtrim(number_format($valeur, $decimal, '.', ' '),'0'),'.');
            } else {
                return number_format($valeur, $decimal, '.', ' ');
            }
        }else {
            return $valeur;
        }        
    }    
    function removeSpaces($valeur) {
        // Enleve tous les espaces d'une chaines
        return str_replace(' ','',$valeur);
    }    
    
    function encode($param = null) {
        // Attention avec le cipher natif §CAKEPHP les encodages ne sont pas compatibles multi-platformes !! (utilisation de srand)
        // Le changement de version php rend également illisibles les encodages fait avec la précédente version
        // Utiliser encodeWithCompat ci-dessous pour avoir de la compatibilité
        return bin2hex(Security::cipher(serialize($param),Configure::read('Security.salt')));
    }
    function decode($param = null) {
        return unserialize(Security::cipher(pack("H*",$param),Configure::read('Security.salt')));
    }
    
    function encodeWithCompat($param = null) {
        // Encodage qui reste lisible meme si on change de système ou de version de php (pas d'utilisation de srand)
        return bin2hex(Security::$this->_cipherWithCompat(serialize($param),Configure::read('Security.salt')));
    }
    function decodeWithCompat($param = null) {
        return unserialize(Security::$this->_cipherWithCompat(pack("H*",$param),Configure::read('Security.salt')));
    }
        
          
    // Fonction cipher qui reste compatible multiplateforme contraitement au cipher natif cakephp
    // http://www.mail-archive.com/cake-php@googlegroups.com/msg82340.html
    private function _cipherWithCompat($text, $key = '') {
        
        $key .= Configure::read('Security.cipherSeed');

        $out = '';
        $textLength = strlen($text);
        $keyLength = strlen($key);
        $k = 0;

            for ($i = 0; $i < $textLength; $i++) {
            $seed = md5($key . $key[($k++) % $keyLength]);
            $mask = hexdec($seed[6] . $seed[9]); // :)
                    $out .= chr(ord($text[$i]) ^ $mask);
            }

            return $out;
    }
    
    /**
     * format price
     */
    public function priceFormat($price,$arrondi=2,$displayEuros=true) {
        if($displayEuros):
            return number_format($price, $arrondi, ',', ' ') . '€';
        else:
            return number_format($price, $arrondi, ',', ' ');
        endif;
        
    }
    
    
}
?>