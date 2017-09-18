<?php
class SimulationProspect extends AppModel{
    
    public $actsAs = array('Containable');
    
    
    public $validate = array(
        'nom' => array(
            'r1'=>array(
                'rule' => 'notEmpty',
                'required' => true,
                'allowEmpty' => false, 
                'message' => "Merci de renseigner votre nom"
            ),
        ),
        'prenom' => array(
            'r1'=>array(
                'rule' => 'notEmpty',
                'required' => true,
                'allowEmpty' => false, 
                'message' => "Merci de renseigner votre prénom"
            ),
        ),
        'email' => array(
            'r1'=>array(
                'rule' => 'email',
                'required' => true,
                'allowEmpty' => false, 
                'message' => "Merci de renseigner un email valide"
            ),
        ),
        'tel' => array(
            'r1'=>array(
                'rule' => 'notEmpty',
                'required' => true,
                'allowEmpty' => false, 
                'message' => "Merci de renseigner votre téléphone"
            ),
            'r2'=> array(
                'rule' => 'numeric',                
                'message' => "Merci de renseigner téléphone valide (Chiffres uniquement)")        
        )
    );

}