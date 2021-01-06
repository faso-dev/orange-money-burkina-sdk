# sdk orange-money-burkina  
Ce package est une API qui encapsule l'API de base de Orange Money Burkina afin de faciliter son usage et son intégration par les développeurs.  
  
**Simple utilisation**  

    $api=OMSDK::init("username","pass","numero marchand");


    $api->setMontant(1000) 
        ->setCodeOtp(121212)
        ->setNumeroClient(76819212);
**Resultat** 

    $result=$api->processPaiement();
    
    if($result->status==200){  
	    echo " paiement effectuée";
	    echo $result->transID;
    }else {
	    print_r($result);
	    echo $result->message;
    }

**Authors**
https://github.com/faso-dev 
https://github.com/yenteck 

Merci de contribuer !
