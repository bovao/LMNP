
<table align="center" width="700" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td>&nbsp;</td>
    </tr>
</table>
<table width="700" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td bgcolor="#FFFFFF"><img src="http://inelys-lmnp/img/mail_header.jpg" width="700" height="148" style="display:block;border:none;" border="0"></td>
    </tr>
</table>
<table width="700" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td bgcolor="#FFFFFF" width="30">&nbsp;</td>
        <td bgcolor="#FFFFFF">
            <font face="Calibri" style="font-size:16px">
            <?if (isset($nom)) { ?>
                Une copie de l'email ci-dessous a été envoyé au propect suivant :<br />
                - email : <?=$email?> 
                <?if (!empty($error)) {?>
                    &nbsp;Attention, email non envoyé au prospect, raison : <?=$error?>
                <?}?>
                <br />
                - nom : <?=$nom?><br />
                - prenom : <?=$prenom?> <br />
                - tel :  <?=$tel?>
                <br /><br />
            
            <?}?>
                Bonjour,<br />
                <br />
                Vous avez effectué une simulation sur le site <b><a href="http://www.simulateur-location-meublee.com">www.simulateur-location-meublee.com</a></b>.<br />
                Retrouvez <b>en pièce jointe le détail des calculs</b>, sur la base des informations fournies.<br />
                <br />
                Si vous souhaitez bénéficier des avantages procurés par la location meublée, changez de régime fiscal et réduisez vos impôts.<br />
                <b>Contactez les équipes spécialisées d'INELYS EXPERTISE, cabinet d'expertise comptable</b><br /><br />

                <center><b>
                        Tél. 04 81 11 01 00<br />
                        <a href="mailto:inelys@inelys.fr">inelys@inelys.fr</a><br />
                        <a href="http://www.compta-loueur-meuble.com">www.compta-loueur-meuble.com</a><br />
                    </b></center><br />
                Nos conseillers sont à votre écoute pour répondre à toutes vos questions.<br />
                <table width="650" border="0" cellspacing="0" cellpadding="5">
                    <tr>
                        <td width="50"></td>
                        <td><font face="Calibri" style="font-size:16px">> Plus de 4000 biens immobiliers gérés chaque année</font></td>
                    </tr>
                    <tr>
                        <td width="50"></td>
                        <td><font face="Calibri" style="font-size:16px">> Une expertise reconnue dans la gestion fiscale des loueurs en meublé</font></td>
                    </tr>
                    <tr>
                        <td width="50"></td>
                        <td><font face="Calibri" style="font-size:16px">> Des équipes dédiées et spécialisées</font></td>
                    </tr>
                </table>  
                <br />
                <br />
                <br />
            </font>
        </td>
        <td bgcolor="#FFFFFF" width="30">&nbsp;</td>
    </tr>
</table>
