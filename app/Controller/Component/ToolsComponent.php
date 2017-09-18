<?php
    class ToolsComponent extends Component {
        var $components = array('Session');
        
        public function sendEmailDev($sujet, $message) {
            $email = new CakeEmail('default');
            $email->to(explode(";",Configure::read('email_dev')));       
            $email->emailFormat('html');
            $email->subject(Configure::read('project_name')."|".Configure::read('project_level')."| ".$sujet);        
            $email->send($message);   
        }
        
        // Encodage à utiliser uniquement en oneshot genre pour encoder des id de formulaire
        // Attention avec le cipher natif §CAKEPHP les encodages ne sont pas compatibles multi-platformes !! (utilisation de srand)
        // Le changement de version php rend également illisibles les encodages fait avec la précédente version
        // Utiliser encodeWithCompat ci-dessous pour avoir de la compatibilité
        public function encode($param = null) {            
            return bin2hex(Security::cipher(serialize($param),Configure::read('Security.salt')));
        }
        public function decode($param = null) {
            return unserialize(Security::cipher(pack("H*",$param),Configure::read('Security.salt')));
        }
        
        // Encodage qui reste lisible meme si on change de système ou de version de php (pas d'utilisation de srand)
        public function encodeWithCompat($param = null) {            
            return bin2hex(Security::$this->_cipherWithCompat(serialize($param),Configure::read('Security.salt')));
        }
        public function decodeWithCompat($param = null) {
            return unserialize(Security::$this->_cipherWithCompat(pack("H*",$param),Configure::read('Security.salt')));
        }
        
        // Formatage d'un nombre
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
    
        // Remplace par exemple les ',' par des '.' dans les champs num�riques
        function processInput($data) {
            
            return str_replace(',','.',$data);
            
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
        
                
    }
?>