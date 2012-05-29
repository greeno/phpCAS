<?php

require_once 'CAS.php';
#phpCAS::setDebug("/opt/highpoint/apache2/htdocs/phpCAS/cas.log");

// Fixing a config until I can have apache restarted
date_default_timezone_set('America/Phoenix');

// Initialize phpCAS
phpCAS::proxy(CAS_VERSION_2_0, 'cas-test.nau.edu', 443, "cas");
phpCAS::setPGTStorageFile("/opt/highpoint/CasPGTStore");
phpCAS::setCasServerCACert("/opt/highpoint/nau.ca.crt");
phpCAS::setFixedServiceURL("https://hpt-dev.ucc.nau.edu/phpCAS/getToken.php");
phpCAS::forceAuthentication();
phpCAS::setExtraCurlOption(CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
?>
<html>
<body>
<p>Username is <?php echo phpCAS::getUser();?></p>
<?php
// Get info from PS
$service = phpCAS::getProxiedService(PHPCAS_PROXIED_SERVICE_HTTP_GET);
$service->setUrl("https://psdv2.ucc.nau.edu:8444/psp/ps9006/?cmd=start");
$service->setServiceUrl("http://peoplesoft.nau.edu/");
$service->send();
$cookies=$service->getCookies()->getAllCookies(); 
foreach ($cookies as $cookie) {
	if($cookie['name']=='PS_TOKEN'){
		$PS_TOKEN=$cookie['value'];
	}
}
?>
<h1> The users PS_TOKEN is <?php echo $PS_TOKEN ?></h1>
</body>
</html>
