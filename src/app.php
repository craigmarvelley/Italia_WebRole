<?php

require_once('bootstrap.php');

use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();

$app->register(new Silex\Extension\TwigExtension(), array(
    'twig.path'       => __DIR__.'/views',
    'twig.class_path' => __DIR__.'/../vendor/twig/lib',
));

$app->error(function (\Exception $e) {
    return new Response('We are sorry, but something went terribly wrong.', 500);
});

$blobStorageClient = BlobStorageClientFactory::getClient();
if(! $blobStorageClient->containerExists('items')) {
	$blobStorageClient->createContainer('items');
	$blobStorageClient->setContainerAcl('items', Microsoft_WindowsAzure_Storage_Blob::ACL_PUBLIC);
}

// List items of content
$app->get('/', function () use ($app, $blobStorageClient) {
	
	$blobs = $blobStorageClient->listBlobs('items');
	$items = array();
	
	foreach($blobs as $blob) {
		
		if (azure_getconfig('UseDevelopmentStorage') == 'false') {
			$blobURL = "http://" . azure_getconfig('StorageAccountName')
	                 . "." . Microsoft_WindowsAzure_Storage::URL_CLOUD_BLOB
	                 . "/items/" . $blob->Name;
		}
		else {
			$blobURL = "http://" . Microsoft_WindowsAzure_Storage::URL_DEV_BLOB
		             . "/" . Microsoft_WindowsAzure_Credentials_CredentialsAbstract::DEVSTORE_ACCOUNT
			         . "/items/" . $blob->Name;
		}
		
		$items[] = array ( 
			'name' => $blob->Name,
			'contentType' => $blob->ContentType,
			'lastModified' => $blob->LastModified,
			'size' => $blob->Size,
			'url' => $blobURL
		);
	}
    
    return $app['twig']->render('index.twig', array(
        'items' => $items
    ));
    
});

// Create a content item from a file
$app->post('/', function () use ($app, $blobStorageClient) {
	
	$expires = new DateTime('Mon, 26 Jul 1997 05:00:00 GMT');
	$lastModified = new DateTime();
	
	foreach($_FILES as $uploadedFile) {
		$result = $blobStorageClient->putBlob(
			'items', 
			$uploadedFile['name'], 
			$uploadedFile['tmp_name']
		);
	}
	
	return new Response('', 201);
	
});

$app->get('/new', function () use ($app) {
	
	return $app['twig']->render('new.twig', array(
        
    ));
    
});

return $app;