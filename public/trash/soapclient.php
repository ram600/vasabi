<?php
ini_set("display_errors",1);
ini_set("display_startup_errors",1);
ini_set("error_reporting",E_ALL);

$client = new 
    SoapClient( 
        "http://soap.amazon.com/schemas2/AmazonWebServices.wsdl" 
    ); 
print_r($client->__getFunctions());//
print_r($client->KeywordSearchRequestKeywordSearchRequest('sql'));

//print($client->getQuote("ibm")); 

?>
