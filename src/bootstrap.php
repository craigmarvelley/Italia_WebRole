<?php

require_once __DIR__.'/silex.phar';

set_include_path(get_include_path() . PATH_SEPARATOR . $_SERVER["RoleRoot"] . "\\approot\\WindowsAzureSDKForPHP\\");

require_once 'Microsoft/WindowsAzure/Storage.php';
require_once 'Microsoft/WindowsAzure/Storage/Blob.php';

require_once __DIR__.'/BlobStorageClientFactory.php';