<?php
class Prospect extends AppModel{
    
    public $useTable = "prospects";
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
                'message' => "Merci de renseigner votre prenom"
            ),
        ),
        'email' => array(
            'r1'=>array(
                'rule' => 'email',
                'required' => true,
                'allowEmpty' => false, 
                'message' => "Merci de renseigner un email valide"
            ),
        )
    );

}