<?php
App::uses('AppController', 'Controller');

// Simulation LMNP
class SimulationController extends AppController {

    echo("coucou");

    public $uses = array();

    public function index() {
        $errors=array();
        if (($this->request->is('post') || $this->request->is('put'))) {
            $data = $this->request->data;  
            $this->set(compact('data'));  
            
            $debug=isset($this->request->query['debug']);
            
            // Traitement des entrées
            $data['SimulationLmnp']['invabi']=$this->Tools->processInput($data['SimulationLmnp']['invabi']);
            $data['SimulationLmnp']['invamo']=$this->Tools->processInput($data['SimulationLmnp']['invamo']);
            $data['SimulationLmnp']['inloyann']=$this->Tools->processInput($data['SimulationLmnp']['inloyann']);
            $data['SimulationLmnp']['inchann']=$this->Tools->processInput($data['SimulationLmnp']['inchann']);
            $data['SimulationLmnp']['inempmtt']=$this->Tools->processInput($data['SimulationLmnp']['inempmtt']);
            $data['SimulationLmnp']['inemptx']=$this->Tools->processInput($data['SimulationLmnp']['inemptx']);
            
                        
            // Contrôle de saisie
            $this->loadModel('SimulationLmnp');
            $this->SimulationLmnp->set($data['SimulationLmnp']);
            if (!$this->SimulationLmnp->validates()) {
                $errors=$this->SimulationLmnp->validationErrors;                
            } 
            $this->loadModel('SimulationProspect');
            $this->SimulationProspect->set($data['SimulationProspect']);
            if (!$this->SimulationProspect->validates()) {
                $errors2=$this->SimulationProspect->validationErrors;                
                $errors=array_merge($errors,$errors2);
            } 
            // Contrôle complémentaire
            $data['SimulationLmnp']['invabi']=round($data['SimulationLmnp']['invabi'],0);
            $data['SimulationLmnp']['invamo']=round($data['SimulationLmnp']['invamo'],0);
            $data['SimulationLmnp']['inloyann']=round($data['SimulationLmnp']['inloyann'],0);
            $data['SimulationLmnp']['inchann']=round($data['SimulationLmnp']['inchann'],0);
            if (trim($data['SimulationLmnp']['indabi'])>date('Y')) {
                $errors['indabi'][0]="Vous ne pouvez pas simuler une acquisition dans le futur";
            }
            if (isset($data['SimulationLmnp']['inempon']) && $data['SimulationLmnp']['inempon']==1) {                                
                if (trim($data['SimulationLmnp']['inempmtt'])=='') {
                    $errors['inempmtt'][0]="Merci de renseigner la valeur de votre emprunt";
                } elseif (!is_numeric($data['SimulationLmnp']['inempmtt']))  {
                    $errors['inempmtt'][0]="Merci de renseigner une valeur numérique";
                } elseif ($data['SimulationLmnp']['inempmtt']>$data['SimulationLmnp']['invabi']) {
                    $errors['inempmtt'][0]="Le montant de votre emprunt ne peut être supérieur au montant de votre bien";
                }
                if (trim($data['SimulationLmnp']['inemptx'])=='') {
                    $errors['inemptx'][0]="Merci de renseigner le taux de votre emprunt";
                } elseif (!is_numeric($data['SimulationLmnp']['inemptx']))  {
                    $errors['inemptx'][0]="Merci de renseigner une valeur numérique";
                }     
                if (trim($data['SimulationLmnp']['inempduree'])=='') {
                    $errors['inempduree'][0]="Merci de renseigner la durée de votre emprunt";
                } elseif (!is_numeric($data['SimulationLmnp']['inempduree']))  {
                    $errors['inempduree'][0]="Merci de renseigner une valeur numérique";
                }     
                if (count($errors)==0) {
                    $data['SimulationLmnp']['inempmtt']=round($data['SimulationLmnp']['inempmtt'],0);
                    $data['SimulationLmnp']['inemptx']=round($data['SimulationLmnp']['inemptx'],2);
                }
            }
            if (isset($data['SimulationLmnp']['inmodeloc']) and trim($data['SimulationLmnp']['inmodeloc'])=="M") {
                if (!isset($data['SimulationLmnp']['inmodeloc']) or trim($data['SimulationLmnp']['inlocsai'])=='') {
                    $errors['inemptx'][0]="Merci de cocher la case adéquate";
                }    
            }
            if (count($errors)>0) {
                $this->set(compact('errors'));   
                return;
            }
                        
            // input
            $invabi=round($data['SimulationLmnp']['invabi'],0);
            $invamo=round($data['SimulationLmnp']['invamo'],0);
            $indabi=$data['SimulationLmnp']['indabi'];
            $inempon=$data['SimulationLmnp']['inempon'];
            $inmodeloc=$data['SimulationLmnp']['inmodeloc'];
            $inloyann=round($data['SimulationLmnp']['inloyann'],0);
            $inchann=round($data['SimulationLmnp']['inchann'],0);
            $inlocsai=(isset($data['SimulationLmnp']['inlocsai']) ?$data['SimulationLmnp']['inlocsai']:0);            
            $intxmarg=$data['SimulationLmnp']['intxmarg']/100;
            $inmicrobic=($inmodeloc=='M' ? 1:0);
            $inempmtt=$data['SimulationLmnp']['inempmtt'];
            $inempduree=$data['SimulationLmnp']['inempduree'];
            $inemptx=$data['SimulationLmnp']['inemptx']/100;
            
            // Enregistre les champs saisis en base
            $data['SimulationProspect']['id']=null;
            $this->SimulationProspect->save($data['SimulationProspect'],false,array('email', 'nom', 'prenom','tel'));
            $data['SimulationLmnp']['id']=null;
            $data['SimulationLmnp']['prospect_id']=$this->SimulationProspect->id;
            $this->SimulationLmnp->save($data['SimulationLmnp'],false);
            
            // Champs techniques
            $teannee=date("Y");// TEANNEE = année de la date du jour
            $tenumannee=$teannee-$indabi+1;// numéro d’ordre de l’année dans les échéances de l’emprunt 

            // CSG+CRDS
            $paramtxps=Configure::read('paramtxps');
            $paramTxChargeMBicSais=Configure::read('paramTxChargeMBicSais');
            $paramTxChargeMBicNSais=Configure::read('paramTxChargeMBicNSais');
            $paramHonoraire=Configure::read('paramHonoraire');
            $parammajobenef=Configure::read('parammajobenef');
                                                                                             
            $rfloyann=$brloyann=$inloyann;
            $brchloc=$inchann;
            $rfchloc=$brchloc;
            $outLabelSituationActuelle="Revenus fonciers";
            if ($inmicrobic==1) {
                // Cas on est déjà en microbic                
                $outLabelSituationActuelle=($inlocsai==1 ? "Revenus Micro BIC saisonniers " : "Revenus Micro BIC ");   
                $rfchloc=($inlocsai==1 ? $inloyann * $paramTxChargeMBicSais : $inloyann*$paramTxChargeMBicNSais);
            } 
                        
            // Intérêts de l'emprunt
            $tabIntEmp=array();
            for($n=1;$n<=10;$n++) {
                $tabIntEmp[$n]=0;
            }
            if ($inempon==1) {
                list($tabCrd,$tabMip)=$this->_computeInteretEmprunt($inempmtt, $inempduree, $inemptx);
                // Regroupement par année
                
                // On stocke les intérets des 10 années à venir
                for($n=1;$n<=10;$n++) {
                    $tabIntEmp[$n]=0;
                    $debutAnnee=($tenumannee-1)+($n-1);
                    $finAnnee=($tenumannee-1)+$n;
                    for($mois=($debutAnnee*12);$mois<($finAnnee*12) and $mois<($inempduree*12);$mois++) {
                        $tabIntEmp[$n]+=$tabMip[$mois];
                    }
                }
            }
                        
            // Amortissement
            $tabAmort25=$this->_computeAmortissement($invabi,$invamo);
            // Si on est en meublé le tableau amort démarre à la date achat, si on est en nu le tableau démarre à l'année en cours
            //$currentYearAmmo donne l'occurence du tableau d'amortissement à considérer cette année
            $tabMttAmo=array();
            for($n=1;$n<=10;$n++) {
                $tabMttAmo[$n]=0;
            }
            // UPDATED 22/09/2014 Mail Nadège Parmentier            
            //$currentYearAmmo=($inmodeloc=='M') ? $tenumannee:1;            
            $currentYearAmmo=1;
            // Tableau amortissement sur 10 ans
            $n=1;
            for($annee=$currentYearAmmo;$annee<=($currentYearAmmo+9) and $annee<=count($tabAmort25);$annee++) {
                $tabMttAmo[$n]=$tabAmort25[$annee];                    
                $n++;
            }
            
            // Résultat de chaque année          
            for($n=1;$n<=10;$n++) {  
                // En microbic on ne tient pas compte des intérêt
                $tabResRf[$n]=$rfloyann-$rfchloc- ($inmicrobic!=1 ? $tabIntEmp[$n] : 0);
                $tabResBr[$n]=$rfloyann-$brchloc-$paramHonoraire-$tabIntEmp[$n];
            }

            //Revenu imposable Foncier
            for($n=1;$n<=10;$n++) {  
                $tabRevenuIrf[$n]=$tabResRf[$n];
                $tabRevenuIrf[$n]=($tabRevenuIrf[$n]<0 ? 0 : $tabRevenuIrf[$n]);
            }
            
            //Revenu imposable Bic Réel / 
            for($n=1;$n<=10;$n++) {  
                $tabRevenuIbr[$n]= $tabResBr[$n] -$tabMttAmo[$n];
                $tabRevenuIbr[$n]=($tabRevenuIbr[$n]<0 ? 0 : $tabRevenuIbr[$n]*$parammajobenef);
            }
            
            //Déficit reportable 
            $tabDefRep[0]=0;
            for($n=1;$n<=10;$n++) {  
                $tabDefRep[$n]=$tabRevenuIbr[$n]+$tabDefRep[$n-1];
                $tabDefRep[$n]=($tabDefRep[$n]>0 ? 0 : $tabDefRep[$n]);
            }         
            
            //Imposition foncier ou micro bic selon le cas
            for($n=1;$n<=10;$n++) {  
                $tabImpRf[$n]=round($tabRevenuIrf[$n] * ($intxmarg+$paramtxps),0);
            }
            //Imposition bic réel
            for($n=1;$n<=10;$n++) {  
                $tabImpBr[$n]=round($tabRevenuIbr[$n] * ($intxmarg+$paramtxps),0);
            }
            
            $brintemp=0;
            //if ($tenumannee<=10) {
                //$brintemp=$tabIntEmp[$tenumannee];
                $brintemp=$tabIntEmp[1];
                $brintemp=round($brintemp,0);
            //}
            $rfintemp=($inmicrobic==0 ? $brintemp : 0);
            

            $brmttamo=$tabMttAmo[1]; 

            $rfrevimp=round($tabRevenuIrf[1],0); // Revenu imposable RF ou micro bic selon le cas
            $brrevimp=round($tabRevenuIbr[1],0); // Revenu imposable bic réel
            
            //
            $g10revimp=0;    // Revenu imposable rf ou micro bic selon le cas sur 10 ans
            for($n=1;$n<=10;$n++) {
                $g10revimp+=round($tabRevenuIrf[$n],0);
            }
            $g10revimp=$g10revimp*-1;

            $rfmttimp=($tabImpRf[1]<0 ? 0 : $tabImpRf[1]); // imposition rf ou micro bic
            $brmttimp=($tabImpBr[1]<0 ? 0 : $tabImpBr[1]); // imposition bic réel           
            
            $rfmttimp10=0; // Imposition rf ou micro bic sur 10 ans
            for($n=1;$n<=10;$n++) {  
                $rfmttimp10+=$tabImpRf[$n];
            }
            $brmttimp10=0;// imposition bic réel sur 10 ans
            for($n=1;$n<=10;$n++) {  
                $brmttimp10+=$tabImpBr[$n];
            }
            
            $g1mttimp=($brmttimp-$rfmttimp)*-1;  // gain sur 1 an            
            $g10mttimp=($brmttimp10-$rfmttimp10)*-1; // gain sur 10 ans
            if ($g10mttimp>0) {
                $conclusion="<h1>Vous pouvez économiser jusqu’à ".$this->Tools->formatNombre($g10mttimp,0)." €  sur 10 ans</h1>";              
                $synthese="Vous économisez ".$this->Tools->formatNombre($g1mttimp,0)." &euro;&nbsp;&nbsp;&nbsp;dès la première année et ".$this->Tools->formatNombre($g10mttimp,0)." &euro;&nbsp;&nbsp;&nbsp;sur 10 ans.";    
            } else {
                $conclusion="<h1>La solution régime réel BIC n’est pas, dans votre cas, plus avantageuse.</h1>";
                $synthese="La solution régime réel BIC n’est pas, dans votre cas, plus avantageuse.";
            }
                
            $emailProspect=$data['SimulationProspect']['email']; 
            if ($debug) {
                $this->set(compact('rfloyann','brloyann','rfchloc','brchloc','rfintemp','brintemp','brmttamo'));   
                $this->set(compact('rfrevimp','brrevimp'));
                $this->set(compact('rfmttimp','brmttimp','g1mttimp','outLabelSituationActuelle'));
                $this->set(compact('rfrevimp','brrevimp','tabIntEmp'));
                
            }                             
            
            $this->set(compact('emailProspect','g10mttimp','debug'));   
            
            $errorMailOutput="";
            // Préparation de la pièce jointe pdf
            $xfdfdata="<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
            $xfdfdata.="<xfdf xmlns=\"http://ns.adobe.com/xfdf/\" xml:space=\"preserve\">";
            $xfdfdata.="<fields>";
            $xfdfdata.="<field name=\"invabi\"><value>".$this->Tools->formatNombre($invabi,0)." &euro;&nbsp;&nbsp;</value></field>";
            $xfdfdata.="<field name=\"indabi\"><value>".$indabi."</value></field>";
            $xfdfdata.="<field name=\"inloyann\"><value>".$this->Tools->formatNombre($inloyann,0)." &euro;&nbsp;&nbsp;</value></field>";
            $xfdfdata.="<field name=\"inchann\"><value>".$this->Tools->formatNombre($inchann,0)." &euro;&nbsp;&nbsp;</value></field>";
            $xfdfdata.="<field name=\"invamo\"><value>".$this->Tools->formatNombre($invamo,0)." &euro;&nbsp;&nbsp;</value></field>";
            $xfdfdata.="<field name=\"inempmtt\"><value>".((isset($data['SimulationLmnp']['inempon']) && $data['SimulationLmnp']['inempon']==1) ?$this->Tools->formatNombre($inempmtt,0):'0')." &euro;&nbsp;&nbsp;</value></field>";
            $xfdfdata.="<field name=\"inempduree\"><value>".((isset($data['SimulationLmnp']['inempon']) && $data['SimulationLmnp']['inempon']==1) ?$this->Tools->formatNombre($inempduree,0).' ans':'')." </value></field>";
            $xfdfdata.="<field name=\"inemptx\"><value>".((isset($data['SimulationLmnp']['inempon']) && $data['SimulationLmnp']['inempon']==1) ?$this->Tools->formatNombre($inemptx*100,2)."%":'')."</value></field>";
            $xfdfdata.="<field name=\"intxmarg\"><value>".($intxmarg*100)."%</value></field>";
            
            $xfdfdata.="<field name=\"LABELCOL1\"><value>".$outLabelSituationActuelle."</value></field>";
            $xfdfdata.="<field name=\"LABELCOL2\"><value>Revenus meublés au régime réel BIC</value></field>";
            $xfdfdata.="<field name=\"RFLOYANN\"><value>".$this->Tools->formatNombre($rfloyann,0)." &euro;&nbsp;&nbsp;</value></field>";
            $xfdfdata.="<field name=\"BRLOYANN\"><value>".$this->Tools->formatNombre($brloyann,0)." &euro;&nbsp;&nbsp;</value></field>";
            $xfdfdata.="<field name=\"RFCHLOC\"><value>".$this->Tools->formatNombre($rfchloc,0)." &euro;&nbsp;&nbsp;</value></field>";
            $xfdfdata.="<field name=\"BRCHLOC\"><value>".$this->Tools->formatNombre($brchloc,0)." &euro;&nbsp;&nbsp;</value></field>";
            $xfdfdata.="<field name=\"RFINTEMP\"><value>".$this->Tools->formatNombre($rfintemp,0)." &euro;&nbsp;&nbsp;</value></field>";
            $xfdfdata.="<field name=\"BRINTEMP\"><value>".$this->Tools->formatNombre($brintemp,0)." &euro;&nbsp;&nbsp;</value></field>";
            $xfdfdata.="<field name=\"BRMTTAMO\"><value>".$this->Tools->formatNombre($brmttamo,0)." &euro;&nbsp;&nbsp;</value></field>";
            $xfdfdata.="<field name=\"RFREVIMP\"><value>".$this->Tools->formatNombre($rfrevimp,0)." &euro;&nbsp;&nbsp;</value></field>";
            $xfdfdata.="<field name=\"BRREVIMP\"><value>".$this->Tools->formatNombre($brrevimp,0)." &euro;&nbsp;&nbsp;</value></field>";
            $xfdfdata.="<field name=\"RFMTTIMP\"><value>".$this->Tools->formatNombre($rfmttimp,0)." &euro;&nbsp;&nbsp;</value></field>";
            $xfdfdata.="<field name=\"BRMTTIMP\"><value>".$this->Tools->formatNombre($brmttimp,0)." &euro;&nbsp;&nbsp;</value></field>";            
            $xfdfdata.="<field name=\"RFHONO\"><value>0 &euro;&nbsp;&nbsp;</value></field>";            
            $xfdfdata.="<field name=\"BRHONO\"><value>".$this->Tools->formatNombre($paramHonoraire,0)." &euro;&nbsp;&nbsp;</value></field>";            
            $xfdfdata.="<field name=\"synthese\"><value>".$synthese."</value></field>";
            $xfdfdata.="</fields>";
            $xfdfdata.="</xfdf>";

            $outFilename=Configure::read('dir_temp').uniqid().'.pdf';
            $xfdf_fn= Configure::read('dir_temp').uniqid().'.xfdf';
            $fp= fopen( $xfdf_fn, 'w' );
            if( $fp ) {
                fwrite( $fp, $xfdfdata );
                fclose( $fp );

                //passthru( Configure::read('pdftk_path').'pdftk.exe '.Configure::read('pdftk_path').'simulation.pdf fill_form '. $fdf_fn. ' output '.$outFilename.' flatten' );
                passthru( Configure::read('pdftk_path').'pdftk.exe '.Configure::read('pdftk_path').'simulation.pdf fill_form '.$xfdf_fn.' output '.$outFilename.' flatten' );

                // Envoi du mail
                App::uses('CakeEmail', 'Network/Email');
                $email = new CakeEmail();
                $error=null;
                $viewvar= array('url'=>Configure::read('url'));
                $email->to($emailProspect)
                    ->config('default')
                    ->subject("Votre SIMULATION location meublée")
                    ->emailFormat('html')
                    ->helpers('Html')
                    ->template('simulation', 'default')
                    ->attachments(array(
                        'simulation.pdf' => array(
                            'file' => $outFilename
                        )
                    ))
                    ->viewVars($viewvar);
                    
                $error=null;
                try {
                    $mailClientSend=true;            
                    $mailClientSend=$email->send();             
                } catch(Exception $e) {
                    $mailClientSend=false;
                    $error=$e->getMessage();
                }

                if (!$mailClientSend) {
                    $msg="Problème pour envoyer une simulation à l'adresse : $emailProspect<br />Erreur : $error <br />";
                    $this->Log($msg, LOG_DEBUG);  
                    $errorMailOutput="Un problème est survenu lors de l'envoi des résultats à l'adresse $emailProspect (Merci de bien vouloir réessayer svp ou de contacter <a href=\"inelys@inelys.fr\">Inelys</a> si le problème persiste)";                   
                } 
                
                // Envoi du mail au destinataires encopie en précisant le nom et le téléphone du client en debut de mail
                $email_copy=Configure::read('email_copy');
                if (!empty($email_copy)) {

                    App::uses('CakeEmail', 'Network/Email');
                    $email = new CakeEmail();

                    $email_copy=Configure::read('email_copy');
                    if (!empty($email_copy)) {
                        $temp=explode(";",$email_copy);
                        $listDest=array();
                        foreach($temp as $cc) { 
                            array_push($listDest,$cc);
                        }                                                
                        $email->to($listDest); 
                    }
                    $error=null;
                    $viewvar= array('url'=>Configure::read('url'),
                        'email'=>$data['SimulationProspect']['email'],
                        'error'=>$error,
                        'nom'=>$data['SimulationProspect']['nom'],
                        'prenom'=>$data['SimulationProspect']['prenom'],
                        'tel'=>$data['SimulationProspect']['tel'],
                    );
                    $email->config('default')
                        ->subject("Votre SIMULATION location meublée")
                        ->emailFormat('html')
                        ->helpers('Html')
                        ->template('simulation', 'default')
                        ->attachments(array(
                            'simulation.pdf' => array(
                                'file' => $outFilename
                            )
                        ))
                        ->viewVars($viewvar);
                    $email->send();
                }
                //@unlink( $outFilename ); // delete output file
            } else {
                $errorMailOutput="Un problème est survenu lors de la génération des résultats (Merci de bien vouloir réessayer svp ou de contacter <a href=\"inelys@inelys.fr\">Inelys</a> si le problème persiste)";    
            }
                
             if (empty($errorMailOutput)) {
                $conclusion.="<h2>Le calcul détaillé de votre simulation vient de vous être transmis par mail <br />à ".$emailProspect."</h2>";
            } else {
                $conclusion.="<h2>Le calcul détaillé de votre simulation n'a pas pû vous être transmis sur votre email pour la raison suivante : <i style='color:red'>".$errorMailOutput."</i></h2>";
            } 
            $this->set(compact('conclusion'));  
            
            // Enregistre les résultats en base
            $this->SimulationLmnp->save(array(
                'id'=>$this->SimulationLmnp->id,
                'gain1an'=>$g1mttimp,
                'gain10ans'=>$g10mttimp,
                'mail_sent'=>((empty($errorMailOutput) and $g10mttimp>0) ? 1 : 0)
                ),false);
            
            
            $this->render('resultat');            
        }
        $this->set(compact('errors'));   
    }
    
    // Retourne les intérets d'enmprunt et le capitale restant dû de chaque mois de l'emprunt
    private function _computeInteretEmprunt($inempmtt, $inempduree, $inemptx) {
        // $inempmtt: montant de l'emprunt
        // $tetxmens: taux mensuel de l'emprunt
        // $inempduree: durée emprunt
        $tetxmens=$inemptx/12;
        $temttmens= ($inempmtt * $tetxmens) / ( 1- pow(1+$tetxmens,$inempduree*12*-1)); //Montant des mensualités 

        $crd=array(); // Tableau du capital restant dû chaque fin de mois
        $crd[0]=$inempmtt;
        $mip=array(); // Tableau des intérêts de chaque mois
        $mip[0]=0;
        for($mois=1;$mois<=$inempduree*12;$mois++) {
            $mip[$mois]=$crd[$mois-1]*$tetxmens;
            $crd[$mois] = (  pow(1+$tetxmens,$mois) * ($inempmtt - ( $temttmens/$tetxmens) ) ) +  ($temttmens / $tetxmens  );
        }
        array_shift($mip); // Supprime le mois 0
        array_shift($crd); // Supprime le mois 0
        return array($crd,$mip);
    }
    
    // Retourne l'amrtissement sur 25ans
    private function _computeAmortissement($invabi, $invamo) {
        //Amortissement immobilier sur 25 ans et amortissement du mobilier sur 7 ans
        //La partie immobilière est calculée sur 90% de la valeur du bien (pour décompter forfaitairement la valeur du terrain estimée à 10%)
        $amort=array();
        for($annee=1;$annee<=25;$annee++) {
            $amort[$annee]=round($invabi*0.9/25,0);
            // Partie mobilière les 7 premières années
            if ($annee<=7) {
                $amort[$annee]+=round($invamo/7,0);   
            }
        }
        return $amort;
    }
    
}
