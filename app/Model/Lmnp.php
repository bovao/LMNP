<?php
class Lmnp extends AppModel{
    
    public $useTable = "lmnp";
    public $actsAs = array('Containable');
    
    
    public $validate = array(
        'invabi' => array(
            'r1'=>array(
                'rule' => 'notEmpty',
                'required' => true,
                'allowEmpty' => false, 
                'message' => "Merci de renseigner la valeur de votre bien"
            ),
            'r2'=> array(
                'rule' => 'numeric',
                'message' => "Merci de renseigner une valeur numérique"),
        ),
        'indabi' => array(
            'r1'=> array(
                'rule' => 'notEmpty',
                'required' => true,
                'allowEmpty' => false, 
                'message' => "Merci de renseigner l'année d'acquisition de votre bien"
            ),
            'r2'=> array(
                'rule' => array('maxLength',4),
                'message' => "Merci de renseigner une année valide (numérique 4 chiffres)"
            ),
            'r3'=> array(
                'rule' => array('minLength',4),
                'message' => "Merci de renseigner une année valide (numérique 4 chiffres)"
            ),            
            'r4'=> array(
                'rule' => 'numeric',
                'message' => "Merci de renseigner une année valide (numérique 4 chiffres)"
            )
        ),
        'inempon' => array(
            'rule' => 'notEmpty',
            'required' => true,
            'allowEmpty' => false, 
            'message' => "Merci de cocher la case adéquate"
        ),
        'inmodeloc' => array(
            'rule' => 'notEmpty',
            'required' => true,
            'allowEmpty' => false, 
            'message' => "Merci de cocher la case adéquate"
        ),
        'inloyann' => array(
            'r1'=>array(
                'rule' => 'notEmpty',
                'required' => true,
                'allowEmpty' => false, 
                'message' => "Merci de renseigner la valeur de vos loyers annuels"
            ),
            'r2'=> array(
                'rule' => 'numeric',
                'message' => "Merci de renseigner une valeur numérique"),
        ),
        'inchann' => array(
            'r1'=>array(
                'rule' => 'notEmpty',
                'required' => true,
                'allowEmpty' => false, 
                'message' => "Merci de renseigner la valeur de vos charges annuelles"
            ),
            'r2'=> array(
                'rule' => 'numeric',
                'message' => "Merci de renseigner une valeur numérique")
        ),
        'intxmarg' => array(
            'r1'=> array(
                'rule' => 'notEmpty',
                'required' => true,
                'allowEmpty' => false, 
                'message' => "Merci de renseigner votre taux marginal d'imposition")
        ),
        'inempmtt' => array(
            'r1'=> array(
                'rule' => 'numeric',                
                'required' => false,
                'allowEmpty' => true,
                'message' => "Merci de renseigner une valeur numérique")
        ),
        'inempduree' => array(
            'r1'=> array(
                'rule' => 'numeric',
                'required' => false,
                'allowEmpty' => true, 
                'message' => "Merci de renseigner une valeur numérique")
        ),
        'inemptx' => array(
            'r1'=> array(
                'rule' => 'numeric',
                'required' => false,
                'allowEmpty' => true, 
                'message' => "Merci de renseigner une valeur numérique")
        )
        
    );

}