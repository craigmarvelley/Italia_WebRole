<?php

class BlobStorageClientFactory {
	
	public static function getClient() {
		if (azure_getconfig('UseDevelopmentStorage') == 'false') {
			$host = Microsoft_WindowsAzure_Storage::URL_CLOUD_BLOB;
    		$accountName = azure_getconfig('StorageAccountName');
    		$accountKey = azure_getconfig('StorageAccountKey');
    		$usePathStyleUri = false;

    		$retryPolicy = Microsoft_WindowsAzure_RetryPolicy_RetryPolicyAbstract::retryN(10, 250);

    		$blobStorageClient = new Microsoft_WindowsAzure_Storage_Blob(
    			$host,
    			$accountName,
    			$accountKey,
    			$usePathStyleUri,
    			$retryPolicy
    		);
  		}
  		else {
    		$blobStorageClient = new Microsoft_WindowsAzure_Storage_Blob();
  		}
  		
  		return $blobStorageClient;
	}
	
}