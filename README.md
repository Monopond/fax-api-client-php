api-client-php
==============

Monopond Fax API PHP Client

#Building a Request
To use Monopond SOAP PHP Client, start by including the `MonopondSOAPClient.php` then creating an instance of the client by supplying your credentials. Your username and password should be enclosed in quotation marks.

```php
<?php
     include_once './MonopondSOAPClient.php';
     
     // TODO: Enter your own credentials here
     $client = new MonopondSOAPClientV2_1("myusername", "mypassword", MPENV::PRODUCTION);
     
     // TODO: Set up your request here
 ?>
```

## SendFax
### Description
This is the core function in the API allowing you to send faxes on the platform. 

Your specific faxing requirements will dictate which send request type below should be used. The two common use cases would be the sending of a single fax document to one destination and the sending of a single fax document to multiple destinations.

### Sending a single fax:
To send a fax to a single destination a request similar to the following example can be used:

```php
	// TODO: Put your file path here
	$filedata = fread(fopen("tests/sample.txt", "r"), filesize("tests/sample.txt"));
	$filedata = base64_encode($filedata);
    
	// TODO: Setup Document
	$document = new MonopondDocument();
	$document->FileName = "AnyFileName1.txt";
	$document->FileData = $filedata;
	$document->Order = 0;
     
	// TODO: Setup FaxMessage
	$faxMessage = new MonopondFaxMessage();
	$faxMessage->MessageRef = "Testing-message-1";
	$faxMessage->SendTo = "61011111111";
	$faxMessage->Documents = array($document);
     
	// TODO: Setup FaxSendRequest 
	$sendFaxRequest = new MonopondSendFaxRequest();
	$sendFaxRequest->FaxMessages[] = $faxMessage;

	// Call send fax method
	$sendRespone = $client->sendFax($sendFaxRequest);
	print_r($sendRespone);
```
You can visit the following properties of MonopondDocument, MonopondFaxMessage, and MonopondSendFaxRequest to know the definitions:
* [MonopondDocument Properties](#monoponddocument-properties)
* [MonopondFaxMessage Properties](#monopondfaxmessage-properties)
* [MonopondSendFaxRequest Properties](#monopondsendfaxrequest-properties)

### Assigning DocumentRef in MonopondDocument
DocumentRef must be unique and a request must be similar to this example:
```php
    // TODO: Put your file path here
    $filedata = fread(fopen("tests/sample.txt", "r"), filesize("tests/sample.txt"));
    $filedata = base64_encode($filedata);
    
    /* Setup Documents */
    $document = new MonopondDocument();
    $document->FileName = "AnyFileName1.txt";
    $document->FileData = $filedata;
    $document->Order = 0;
    $document->DocumentRef = "Sample DocumentRef";

    $document2 = new MonopondDocument();
    $document2->FileName = "AnyFileName1.txt";
    $document2->FileData = $filedata;
    $document2->Order = 0;
    $document2->DocumentRef = "Sample DocumentRef2";

    /* Setup FaxMessages (Each contains an array of document objects) */
    $faxMessage = new MonopondFaxMessage();
    $faxMessage->MessageRef = "Testing-message-1";
    $faxMessage->SendTo = "61011111111";

    $faxMessage2 = new MonopondFaxMessage();
    $faxMessage2->MessageRef = "Testing-message-2";
    $faxMessage2->SendTo = "61011111112";

    $faxMessage3 = new MonopondFaxMessage();
    $faxMessage3->MessageRef = "Testing-message-3";
    $faxMessage3->SendTo = "61011111112";

    /* Setup FaxSendRequest (Each contains an array of fax messages) */
    $sendFaxRequest = new MonopondSendFaxRequest();
    $sendFaxRequest->FaxMessages = array($faxMessage, $faxMessage2, $faxMessage3);
    $sendFaxRequest->Documents = array($document, $document2);

    /* Send request to Monopond */
    $sendRespone = $client->sendFax($sendFaxRequest);
    /* Display response */
    print_r($sendRespone);
```
You can visit here to check the definition of DocumentRef:
* [MonopondDocument Properties](#monoponddocument-properties)

### Assigning SendRef and BroadcastRef in MonopondSendFaxRequest
To assign SendRef and BroadcastRef in MonopondSendFaxRequest, a request must be similar to this example:
```php
    // TODO: Put your file path here
    $filedata = fread(fopen("tests/sample.txt", "r"), filesize("tests/sample.txt"));
    $filedata = base64_encode($filedata);
    
    /* Setup Documents */
    $document = new MonopondDocument();
    $document->FileName = "AnyFileName1.txt";
    $document->FileData = $filedata;
    $document->Order = 0;

    /* Setup FaxMessages (Each contains an array of document objects) */
    $faxMessage = new MonopondFaxMessage();
    $faxMessage->MessageRef = "Testing-message-1";
    $faxMessage->SendTo = "Testing";

    /* Setup FaxSendRequest (Each contains an array of fax messages) */
    $sendFaxRequest = new MonopondSendFaxRequest();
    $sendFaxRequest->FaxMessages[] = $faxMessage;
    $sendFaxRequest->Documents = array($document);
    $sendFaxRequest->BroadcastRef = "BroadcastRef";
    $sendFaxRequest->SendRef = "SendRef";

    /* Send request to Monopond */
    $sendRespone = $client->sendFax($sendFaxRequest);
    /* Display response */
    print_r($sendRespone);
 ```
Visit here to know the definitions of SendRef and BroadcastRef:
* [MonopondSendFaxRequest Properties](#monopondsendfaxrequest-properties)

### Sending a Fax with Retries inside a MonopondFaxMessage
To set-up a fax to have retries a request similar to the following example can be used.

```php
 	// TODO: Put your file path here
    $filedata = fread(fopen("tests/sample.txt", "r"), filesize("tests/sample.txt"));
    $filedata = base64_encode($filedata);
    
    /* Setup Documents */
    $document = new MonopondDocument();
    $document->FileName = "AnyFileName1.txt";
    $document->FileData = $filedata;
    $document->Order = 0;
    
    /* Setup FaxMessages (Each contains an array of document objects) */
    $faxMessage = new MonopondFaxMessage();
    $faxMessage->MessageRef = "Testing-message-1";
    $faxMessage->SendTo = "61011111111";
    $faxMessage->Retries = 0;
    
    /* Setup FaxSendRequest (Each contains an array of fax messages) */
    $sendFaxRequest = new MonopondSendFaxRequest();
    $sendFaxRequest->FaxMessages[] = $faxMessage;
    $sendFaxRequest->Documents = array($document);

    /* Send request to Monopond */
    $sendRespone = $client->sendFax($sendFaxRequest);
    /* Display response */
    print_r($sendRespone);
```
You can visit the following properties of MonopondDocument, MonopondFaxMessage, and MonopondSendFaxRequest to know their definitions:
* [MonopondDocument Properties](#monoponddocument-properties)
* [MonopondFaxMessage Properties](#monopondfaxmessage-properties)
* [MonopondSendFaxRequest Properties](#monopondsendfaxrequest-properties)

### Sending a Fax with Retries inside a MonopondSendFaxRequest
To set-up a fax to have retries a request similar to the following example can be used.
```php
    // TODO: Put your file path here
    $filedata = fread(fopen("tests/sample.txt", "r"), filesize("tests/sample.txt"));
    $filedata = base64_encode($filedata);
    
    /* Setup Documents */
    $document = new MonopondDocument();
    $document->FileName = "AnyFileName1.txt";
    $document->FileData = $filedata;
    $document->Order = 0;
    
    /* Setup FaxMessages (Each contains an array of document objects) */
    $faxMessage = new MonopondFaxMessage();
    $faxMessage->MessageRef = "Testing-message-1";
    $faxMessage->SendTo = "61011111111";
    
    /* Setup FaxSendRequest (Each contains an array of fax messages) */
    $sendFaxRequest = new MonopondSendFaxRequest();
    $sendFaxRequest->FaxMessages[] = $faxMessage;
    $sendFaxRequest->Documents = array($document);
    $sendFaxRequest->Retries = 1;

    /* Send request to Monopond */
    $sendRespone = $client->sendFax($sendFaxRequest);
    /* Display response */
    print_r($sendRespone);
```
You can visit the following properties of MonopondDocument, MonopondFaxMessage, and MonopondSendFaxRequest to know their definitions:
* [MonopondDocument Properties](#monoponddocument-properties)
* [MonopondFaxMessage Properties](#monopondfaxmessage-properties)
* [MonopondSendFaxRequest Properties](#monopondsendfaxrequest-properties)

### Sending a Fax with BusyRetries inside a MonopondFaxMessage
To set-up a fax to have busyRetries a request similar to the following example can be used.
```php
    // TODO: Put your file path here
    $filedata = fread(fopen("tests/sample.txt", "r"), filesize("tests/sample.txt"));
    $filedata = base64_encode($filedata);
    
    /* Setup Documents */
    $document = new MonopondDocument();
    $document->FileName = "AnyFileName1.txt";
    $document->FileData = $filedata;
    $document->Order = 0;
    
    /* Setup FaxMessages (Each contains an array of document objects) */
    $faxMessage = new MonopondFaxMessage();
    $faxMessage->MessageRef = "Testing-message-1";
    $faxMessage->SendTo = "61011111111";
    $faxMessage->BusyRetries = 1;
    
    /* Setup FaxSendRequest (Each contains an array of fax messages) */
    $sendFaxRequest = new MonopondSendFaxRequest();
    $sendFaxRequest->FaxMessages[] = $faxMessage;
    $sendFaxRequest->Documents = array($document);

    /* Send request to Monopond */
    $sendRespone = $client->sendFax($sendFaxRequest);
    /* Display response */
    print_r($sendRespone);
```
You can visit the following properties of MonopondDocument, MonopondFaxMessage, and MonopondSendFaxRequest to know their definitions:
* [MonopondDocument Properties](#monoponddocument-properties)
* [MonopondFaxMessage Properties](#monopondfaxmessage-properties)
* [MonopondSendFaxRequest Properties](#monopondsendfaxrequest-properties)

### Sending a Fax with BusyRetries inside a MonopondSendFaxRequest
To set-up a fax to have busyRetries a request similar to the following example can be used.
```php
    // TODO: Put your file path here
    $filedata = fread(fopen("tests/sample.txt", "r"), filesize("tests/sample.txt"));
    $filedata = base64_encode($filedata);
    
    /* Setup Documents */
    $document = new MonopondDocument();
    $document->FileName = "AnyFileName1.txt";
    $document->FileData = $filedata;
    $document->Order = 0;
    
    /* Setup FaxMessages (Each contains an array of document objects) */
    $faxMessage = new MonopondFaxMessage();
    $faxMessage->MessageRef = "Testing-message-1";
    $faxMessage->SendTo = "61011111111";
    
    /* Setup FaxSendRequest (Each contains an array of fax messages) */
    $sendFaxRequest = new MonopondSendFaxRequest();
    $sendFaxRequest->FaxMessages[] = $faxMessage;
    $sendFaxRequest->Documents = array($document);
    $sendFaxRequest->BusyRetries = 1;

    /* Send request to Monopond */
    $sendRespone = $client->sendFax($sendFaxRequest);
    /* Display response */
    print_r($sendRespone);
```
You can visit the following properties of MonopondDocument, MonopondFaxMessage, and MonopondSendFaxRequest to know their definitions:
* [MonopondDocument Properties](#monoponddocument-properties)
* [MonopondFaxMessage Properties](#monopondfaxmessage-properties)
* [MonopondSendFaxRequest Properties](#monopondsendfaxrequest-properties)

### Sending a Fax with Resolution in MonopondFaxMessage
To assign the fax resolution, a request similar to the following example can be used.
```php
    // TODO: Put your file path here
    $filedata = fread(fopen("tests/sample.txt", "r"), filesize("tests/sample.txt"));
    $filedata = base64_encode($filedata);
    
    /* Setup Documents */
    $document = new MonopondDocument();
    $document->FileName = "AnyFileName1.txt";
    $document->FileData = $filedata;
    $document->Order = 0;
    
    /* Setup FaxMessages (Each contains an array of document objects) */
    $faxMessage = new MonopondFaxMessage();
    $faxMessage->MessageRef = "Testing-message-1";
    $faxMessage->SendTo = "61011111111";
    $faxMessage->Resolution = "normal";
    
    /* Setup FaxSendRequest (Each contains an array of fax messages) */
    $sendFaxRequest = new MonopondSendFaxRequest();
    $sendFaxRequest->FaxMessages[] = $faxMessage;
    $sendFaxRequest->Documents = array($document);

    /* Send request to Monopond */
    $sendRespone = $client->sendFax($sendFaxRequest);
    /* Display response */
    print_r($sendRespone);

```
You can visit the definition of Resolution and its values here:
* [MonopondFaxMessage Properties](#monopondfaxmessage-properties)
* [Resolution Levels](#resolution-levels)

### Sending a Fax with Resolution in MonopondSendFaxRequest
To assign the fax resolution, a request similar to the following example can be used.
```php
	
    // TODO: Put your file path here
    $filedata = fread(fopen("tests/sample.txt", "r"), filesize("tests/sample.txt"));
    $filedata = base64_encode($filedata);
    
    /* Setup Documents */
    $document = new MonopondDocument();
    $document->FileName = "AnyFileName1.txt";
    $document->FileData = $filedata;
    $document->Order = 0;
    
    /* Setup FaxMessages (Each contains an array of document objects) */
    $faxMessage = new MonopondFaxMessage();
    $faxMessage->MessageRef = "Testing-message-1";
    $faxMessage->SendTo = "61011111111";
    
    /* Setup FaxSendRequest (Each contains an array of fax messages) */
    $sendFaxRequest = new MonopondSendFaxRequest();
    $sendFaxRequest->FaxMessages[] = $faxMessage;
    $sendFaxRequest->Documents = array($document);
    $sendFaxRequest->Resolution = "fine";

    /* Send request to Monopond */
    $sendRespone = $client->sendFax($sendFaxRequest);
    /* Display response */
    print_r($sendRespone);
```
You can visit the definition of Resolution and its values here:
* [MonopondSendFaxRequest Properties](#monopondsendfaxrequest-properties)
* [Resolution Levels](#resolution-levels)

### Sending a Fax with FaxDitheringTechnique in MonopondDocument:
To set the fax FaxDitheringTechnique, a request similar to the following example can be used.
```php
    // TODO: Put your file path here
    $filedata = fread(fopen("tests/sample.txt", "r"), filesize("tests/sample.txt"));
    $filedata = base64_encode($filedata);
    
    /* Setup Documents */
    $document = new MonopondDocument();
    $document->FileName = "AnyFileName1.txt";
    $document->FileData = $filedata;
    $document->Order = 0;
    $document->DitheringTechnique = "turbo";
    
    /* Setup FaxMessages (Each contains an array of document objects) */
    $faxMessage = new MonopondFaxMessage();
    $faxMessage->MessageRef = "Testing-message-1";
    $faxMessage->SendTo = "61011111111";
    
    /* Setup FaxSendRequest (Each contains an array of fax messages) */
    $sendFaxRequest = new MonopondSendFaxRequest();
    $sendFaxRequest->FaxMessages[] = $faxMessage;
    $sendFaxRequest->Documents = array($document);

    /* Send request to Monopond */
    $sendRespone = $client->sendFax($sendFaxRequest);
    /* Display response */
    print_r($sendRespone);

```
You can visit the different values of FaxDitheringTechnique here:
* [FaxDitheringTechniques](#faxditheringtechnique)

### Assigning a Timezone in MonopondFaxMessage
The Timezone is used to format the datetime display in the fax header.
```php
    // TODO: Put your file path here
    $filedata = fread(fopen("tests/sample.txt", "r"), filesize("tests/sample.txt"));
    $filedata = base64_encode($filedata);
    
    /* Setup Documents */
    $document = new MonopondDocument();
    $document->FileName = "AnyFileName1.txt";
    $document->FileData = $filedata;
    $document->Order = 0;
    
    /* Setup FaxMessages (Each contains an array of document objects) */
    $faxMessage = new MonopondFaxMessage();
    $faxMessage->MessageRef = "Testing-message-1";
    $faxMessage->SendTo = "61011111111";
    $faxMessage->TimeZone = "Australia/Adelaide";
    
    /* Setup FaxSendRequest (Each contains an array of fax messages) */
    $sendFaxRequest = new MonopondSendFaxRequest();
    $sendFaxRequest->FaxMessages[] = $faxMessage;
    $sendFaxRequest->Documents = array($document);

    /* Send request to Monopond */
    $sendRespone = $client->sendFax($sendFaxRequest);
    /* Display response */
    print_r($sendRespone);

```
### Assigning a Timezone in MonopondSendFaxRequest
The Timezone is used to format the datetime display in the fax header. Applying it to the MonopondSendFaxRequest will apply this to all MonopondFaxMessages in the request.
```php
    /* Setup Documents */
    $document = new MonopondDocument();
    $document->FileName = "AnyFileName1.txt";
    $document->FileData = $filedata;
    $document->Order = 0;
    
    /* Setup FaxMessages (Each contains an array of document objects) */
    $faxMessage = new MonopondFaxMessage();
    $faxMessage->MessageRef = "Testing-message-1";
    $faxMessage->SendTo = "61011111111";
    
    /* Setup FaxSendRequest (Each contains an array of fax messages) */
    $sendFaxRequest = new MonopondSendFaxRequest();
    $sendFaxRequest->FaxMessages[] = $faxMessage;
    $sendFaxRequest->Documents = array($document);
    $sendFaxRequest->TimeZone = "Australia/Adelaide";

    /* Send request to Monopond */
    $sendRespone = $client->sendFax($sendFaxRequest);
    /* Display response */
    print_r($sendRespone);
```

### Assigning SendFrom in MonopondFaxMessage
To send fax with SendFrom in MonopondFaxMessage a request similar to the following example can be used.
```php
    // TODO: Put your file path here
    $filedata = fread(fopen("tests/sample.txt", "r"), filesize("tests/sample.txt"));
    $filedata = base64_encode($filedata);
    
    /* Setup Documents */
    $document = new MonopondDocument();
    $document->FileName = "AnyFileName1.txt";
    $document->FileData = $filedata;
    $document->Order = 0;
    
    /* Setup FaxMessages (Each contains an array of document objects) */
    $faxMessage = new MonopondFaxMessage();
    $faxMessage->MessageRef = "Testing-message-1";
    $faxMessage->SendTo = "61011111111";
    $faxMessage->SendFrom = "Sample SendFrom";
    
    /* Setup FaxSendRequest (Each contains an array of fax messages) */
    $sendFaxRequest = new MonopondSendFaxRequest();
    $sendFaxRequest->FaxMessages[] = $faxMessage;
    $sendFaxRequest->Documents = array($document);

    /* Send request to Monopond */
    $sendRespone = $client->sendFax($sendFaxRequest);
    /* Display response */
    print_r($sendRespone);
```
You can visit the definition of SendFrom here:
* [MonopondFaxMessage Properties](#monopondfaxmessage-properties)

### Assigning SendFrom in MonopondSendFaxRequest
To send fax with SendFrom in MonopondSendFaxRequest a request similar to the following example can be used.
```php
    // TODO: Put your file path here
    $filedata = fread(fopen("tests/sample.txt", "r"), filesize("tests/sample.txt"));
    $filedata = base64_encode($filedata);
    
    /* Setup Documents */
    $document = new MonopondDocument();
    $document->FileName = "AnyFileName1.txt";
    $document->FileData = $filedata;
    $document->Order = 0;
    
    /* Setup FaxMessages (Each contains an array of document objects) */
    $faxMessage = new MonopondFaxMessage();
    $faxMessage->MessageRef = "Testing-message-1";
    $faxMessage->SendTo = "61011111111";
    
    /* Setup FaxSendRequest (Each contains an array of fax messages) */
    $sendFaxRequest = new MonopondSendFaxRequest();
    $sendFaxRequest->FaxMessages[] = $faxMessage;
    $sendFaxRequest->Documents = array($document);
    $sendFaxRequest->SendFrom = "Test Example";

    /* Send request to Monopond */
    $sendRespone = $client->sendFax($sendFaxRequest);
    /* Display response */
    print_r($sendRespone);

```
You can visit the definition of SendFrom here:
* [MonopondSendFaxRequest Properties](#monopondsendfaxrequest-properties)

### Assigning a HeaderFormat in MonopondFaxMessage
Allows the header format that appears at the top of the transmitted fax to be changed.
```php
    // TODO: Put your file path here
    $filedata = fread(fopen("tests/sample.txt", "r"), filesize("tests/sample.txt"));
    $filedata = base64_encode($filedata);
    
    /* Setup Documents */
    $document = new MonopondDocument();
    $document->FileName = "AnyFileName1.txt";
    $document->FileData = $filedata;
    $document->Order = 0;
    
    /* Setup FaxMessages (Each contains an array of document objects) */
    $faxMessage = new MonopondFaxMessage();
    $faxMessage->MessageRef = "Testing-message-1";
    $faxMessage->SendTo = "61011111111";
    $faxMessage->HeaderFormat = "From %from%, To %to%|%a %b %d %H:%M %Y";
    
    /* Setup FaxSendRequest (Each contains an array of fax messages) */
    $sendFaxRequest = new MonopondSendFaxRequest();
    $sendFaxRequest->FaxMessages[] = $faxMessage;
    $sendFaxRequest->Documents = array($document);

    /* Send request to Monopond */
    $sendRespone = $client->sendFax($sendFaxRequest);
    /* Display response */
    print_r($sendRespone);

```
For more information, visit the following on how to setup the HeaderFormat value:
* [Header Format](#header-format)

### Assigning a HeaderFormat in MonopondSendFaxRequest
Allows the header format that appears at the top of the transmitted fax to be changed.
```php
    // TODO: Put your file path here
    $filedata = fread(fopen("tests/sample.txt", "r"), filesize("tests/sample.txt"));
    $filedata = base64_encode($filedata);
    
    /* Setup Documents */
    $document = new MonopondDocument();
    $document->FileName = "AnyFileName1.txt";
    $document->FileData = $filedata;
    $document->Order = 0;
    
    /* Setup FaxMessages (Each contains an array of document objects) */
    $faxMessage = new MonopondFaxMessage();
    $faxMessage->MessageRef = "Testing-message-1";
    $faxMessage->SendTo = "61011111111";
    
    /* Setup FaxSendRequest (Each contains an array of fax messages) */
    $sendFaxRequest = new MonopondSendFaxRequest();
    $sendFaxRequest->FaxMessages[] = $faxMessage;
    $sendFaxRequest->Documents = array($document);
    $sendFaxRequest->HeaderFormat = "From %from%, To %to%|%a %b %d %H:%M %Y";

    /* Send request to Monopond */
    $sendRespone = $client->sendFax($sendFaxRequest);
    /* Display response */
    print_r($sendRespone);
```

For more information, visit the following on how to setup the HeaderFormat value:
* [Header Format](#header-format)

### Assigning CLI in MonopondFaxMessage
Assigning a CLI in the MonopondFaxMessage, a request similar to the following example below.
```php
    // TODO: Put your file path here
    $filedata = fread(fopen("tests/sample.txt", "r"), filesize("tests/sample.txt"));
    $filedata = base64_encode($filedata);
    
    /* Setup Documents */
    $document = new MonopondDocument();
    $document->FileName = "AnyFileName1.txt";
    $document->FileData = $filedata;
    $document->Order = 0;
    
    /* Setup FaxMessages (Each contains an array of document objects) */
    $faxMessage = new MonopondFaxMessage();
    $faxMessage->MessageRef = "Testing-message-1";
    $faxMessage->SendTo = "61011111111";
    $faxMessage->CLI = "61011111111";

    /* Setup FaxSendRequest (Each contains an array of fax messages) */
    $sendFaxRequest = new MonopondSendFaxRequest();
    $sendFaxRequest->FaxMessages[] = $faxMessage;
    $sendFaxRequest->Documents = array($document);

    /* Send request to Monopond */
    $sendRespone = $client->sendFax($sendFaxRequest);
    /* Display response */
    print_r($sendRespone);
```
You can visit the definition of CLI here:
* [MonopondFaxMessage Properties](#monopondfaxmessage-properties)

### Sending a Fax with DNCR enabled in MonopondFaxMessage
To check if a number is on the Do Not Call Register (Australian) before the fax is sent:
```php
    // TODO: Put your file path here
    $filedata = fread(fopen("tests/sample.txt", "r"), filesize("tests/sample.txt"));
    $filedata = base64_encode($filedata);
    
    /* Setup Documents */
    $document = new MonopondDocument();
    $document->FileName = "AnyFileName1.txt";
    $document->FileData = $filedata;
    $document->Order = 0;
    
    /* Setup Blocklists */
    $monopondBlocklists = new MonopondBlocklist();
    $monopondBlocklists->dncr = "true";

    /* Setup FaxMessages (Each contains an array of document objects) */
    $faxMessage = new MonopondFaxMessage();
    $faxMessage->MessageRef = "Testing-message-1";
    $faxMessage->SendTo = "61011111111";
    $faxMessage->Blocklists = $monopondBlocklists;

    /* Setup FaxSendRequest (Each contains an array of fax messages) */
    $sendFaxRequest = new MonopondSendFaxRequest();
    $sendFaxRequest->FaxMessages[] = $faxMessage;
    $sendFaxRequest->Documents = array($document);

    /* Send request to Monopond */
    $sendRespone = $client->sendFax($sendFaxRequest);
    /* Display response */
    print_r($sendRespone);

```
You can visit here the definition of Blocklists and its paremeters:
* [MonopondFaxMessage Properties](#monopondfaxmessage-properties)
* [Blocklists Parameters](#blocklists-parameters);

### Sending a Fax with FPS enabled in MonopondFaxMessage
To check if a number is on the FPS blacklist (UK) before the fax is sent:
```php
    // TODO: Put your file path here
    $filedata = fread(fopen("tests/sample.txt", "r"), filesize("tests/sample.txt"));
    $filedata = base64_encode($filedata);
    
    /* Setup Documents */
    $document = new MonopondDocument();
    $document->FileName = "AnyFileName1.txt";
    $document->FileData = $filedata;
    $document->Order = 0;
    
    /* Setup Blocklists */
    $monopondBlocklists = new MonopondBlocklist();
    $monopondBlocklists->fps = "true";

    /* Setup FaxMessages (Each contains an array of document objects) */
    $faxMessage = new MonopondFaxMessage();
    $faxMessage->MessageRef = "Testing-message-1";
    $faxMessage->SendTo = "61011111111";
    $faxMessage->Blocklists = $monopondBlocklists;

    /* Setup FaxSendRequest (Each contains an array of fax messages) */
    $sendFaxRequest = new MonopondSendFaxRequest();
    $sendFaxRequest->FaxMessages[] = $faxMessage;
    $sendFaxRequest->Documents = array($document);

    /* Send request to Monopond */
    $sendRespone = $client->sendFax($sendFaxRequest);
    /* Display response */
    print_r($sendRespone);
```
You can visit here the definition of Blocklists and its paremeters:
* [MonopondFaxMessage Properties](#monopondfaxmessage-properties)
* [Blocklists Parameters](#blocklists-parameters);

### Sending a Fax with Smartblock enabled in MonopondFaxMessage
To check if a number is on the Smartblock list before the fax is sent:
```php
    // TODO: Put your file path here
    $filedata = fread(fopen("tests/sample.txt", "r"), filesize("tests/sample.txt"));
    $filedata = base64_encode($filedata);
    
    /* Setup Documents */
    $document = new MonopondDocument();
    $document->FileName = "AnyFileName1.txt";
    $document->FileData = $filedata;
    $document->Order = 0;
    
    /* Setup Blocklists */
    $monopondBlocklists = new MonopondBlocklist();
    $monopondBlocklists->smartblock = "true";

    /* Setup FaxMessages (Each contains an array of document objects) */
    $faxMessage = new MonopondFaxMessage();
    $faxMessage->MessageRef = "Testing-message-1";
    $faxMessage->SendTo = "61011111111";
    $faxMessage->Blocklists = $monopondBlocklists;

    /* Setup FaxSendRequest (Each contains an array of fax messages) */
    $sendFaxRequest = new MonopondSendFaxRequest();
    $sendFaxRequest->FaxMessages[] = $faxMessage;
    $sendFaxRequest->Documents = array($document);

    /* Send request to Monopond */
    $sendRespone = $client->sendFax($sendFaxRequest);
    /* Display response */
    print_r($sendRespone);

```
You can visit here the definition of Blocklists and its paremeters:
* [MonopondFaxMessage Properties](#monopondfaxmessage-properties)
* [Blocklists Parameters](#blocklists-parameters);

### Add a Blocklists in MonopondSendFaxRequest
If you want to validate all numbers in DNCR or FPS or Smarblock, a request must be similiar to this example:

```php
    /* Setup Documents */
    $document = new MonopondDocument();
    $document->FileName = "AnyFileName1.txt";
    $document->FileData = $filedata;
    $document->Order = 0;
    
    /* Setup Blocklists */
    $monopondBlocklists = new MonopondBlocklist();
    $monopondBlocklists->dncr = "true";

    /* Setup FaxMessages (Each contains an array of document objects) */
    $faxMessage = new MonopondFaxMessage();
    $faxMessage->MessageRef = "Testing-message-1";
    $faxMessage->SendTo = "61011111111";

    $faxMessage2 = new MonopondFaxMessage();
    $faxMessage2->MessageRef = "Testing-message-2";
    $faxMessage2->SendTo = "61011111112";

    /* Setup FaxSendRequest (Each contains an array of fax messages) */
    $sendFaxRequest = new MonopondSendFaxRequest();
    $sendFaxRequest->FaxMessages = array($faxMessage, $faxMessage2);
    $sendFaxRequest->Documents = array($document);
    $sendFaxRequest->Blocklists = $monopondBlocklists;

    /* Send request to Monopond */
    $sendRespone = $client->sendFax($sendFaxRequest);
    /* Display response */
    print_r($sendRespone);
```
You can visit here the definition of Blocklists and its paremeters:
* [MonopondSendFaxRequest Properties](#monopondsendfaxrequest-properties)
* [Blocklists Parameters](#blocklists-parameters);

### Sending a Fax with ScheduledStartTime in MonopondFaxMessage
To set a ScheduledStartTime for the MonopondFaxMessage, a request similar to the following can be used.
```php
    // TODO: Put your file path here
    $filedata = fread(fopen("tests/sample.txt", "r"), filesize("tests/sample.txt"));
    $filedata = base64_encode($filedata);
    
    /* Setup Documents */
    $document = new MonopondDocument();
    $document->FileName = "AnyFileName1.txt";
    $document->FileData = $filedata;
    $document->Order = 0;

    /* Setup FaxMessages (Each contains an array of document objects) */
    $faxMessage = new MonopondFaxMessage();
    $faxMessage->MessageRef = "Testing-message-1";
    $faxMessage->SendTo = "61011111111";
    $faxMessage->ScheduledStartTime = "2017-06-25T12:00:00Z";

    $faxMessage2 = new MonopondFaxMessage();
    $faxMessage2->MessageRef = "Testing-message-2";
    $faxMessage2->SendTo = "61011111112";
    $faxMessage2->ScheduledStartTime = "2017-06-25T12:00:00Z";

    /* Setup FaxSendRequest (Each contains an array of fax messages) */
    $sendFaxRequest = new MonopondSendFaxRequest();
    $sendFaxRequest->FaxMessages = array($faxMessage, $faxMessage2);
    $sendFaxRequest->Documents = array($document);

    /* Send request to Monopond */
    $sendRespone = $client->sendFax($sendFaxRequest);
    /* Display response */
    print_r($sendRespone);
```

You can visit here the definition of ScheduledStartTime here:
* [MonopondFaxMessage Properties](#monopondfaxmessage-properties)

### Sending a Fax with ScheduledStartTime in MonopondSendFaxRequest
To set a ScheduledStartTime for the MonopondSendFaxRequest, a request similar to the following can be used.
```php
    // TODO: Put your file path here
    $filedata = fread(fopen("tests/sample.txt", "r"), filesize("tests/sample.txt"));
    $filedata = base64_encode($filedata);
    
    /* Setup Documents */
    $document = new MonopondDocument();
    $document->FileName = "AnyFileName1.txt";
    $document->FileData = $filedata;
    $document->Order = 0;

    /* Setup FaxMessages (Each contains an array of document objects) */
    $faxMessage = new MonopondFaxMessage();
    $faxMessage->MessageRef = "Testing-message-1";
    $faxMessage->SendTo = "61011111111";

    $faxMessage2 = new MonopondFaxMessage();
    $faxMessage2->MessageRef = "Testing-message-2";
    $faxMessage2->SendTo = "61011111112";

    /* Setup FaxSendRequest (Each contains an array of fax messages) */
    $sendFaxRequest = new MonopondSendFaxRequest();
    $sendFaxRequest->FaxMessages = array($faxMessage, $faxMessage2);
    $sendFaxRequest->Documents = array($document);
    $sendFaxRequest->ScheduledStartTime = "2017-06-25T12:00:00Z";

    /* Send request to Monopond */
    $sendRespone = $client->sendFax($sendFaxRequest);
    /* Display response */
    print_r($sendRespone);

```
You can visit here the definition of ScheduledStartTime here:
* [MonopondSendFaxRequest Properties](#monopondsendfaxrequest-properties)

### Sending a Fax with MustBeSentBeforeDate in MonopondFaxMessage
To set a MustBeSentBeforeDate for MonopondFaxMessage, a request similar to the following can be used.
```php
    // TODO: Put your file path here
    $filedata = fread(fopen("tests/sample.txt", "r"), filesize("tests/sample.txt"));
    $filedata = base64_encode($filedata);
    
    /* Setup Documents */
    $document = new MonopondDocument();
    $document->FileName = "AnyFileName1.txt";
    $document->FileData = $filedata;
    $document->Order = 0;

    /* Setup FaxMessages (Each contains an array of document objects) */
    $faxMessage = new MonopondFaxMessage();
    $faxMessage->MessageRef = "Testing-message-1";
    $faxMessage->SendTo = "61011111111";
    $faxMessage->MustBeSentBeforeDate = "2017-09-05T21:30:17+10:00";

    $faxMessage2 = new MonopondFaxMessage();
    $faxMessage2->MessageRef = "Testing-message-2";
    $faxMessage2->SendTo = "61011111112";
    $faxMessage2->MustBeSentBeforeDate = "2017-09-05T21:30:17+10:00";

    /* Setup FaxSendRequest (Each contains an array of fax messages) */
    $sendFaxRequest = new MonopondSendFaxRequest();
    $sendFaxRequest->FaxMessages = array($faxMessage, $faxMessage2);
    $sendFaxRequest->Documents = array($document);

    /* Send request to Monopond */
    $sendRespone = $client->sendFax($sendFaxRequest);
    /* Display response */
    print_r($sendRespone);

```
To know more about MustBeSentBeforeDate you can check it here:
* [MonopondFaxMessage Properties](#monopondfaxmessage-properties)

### Sending a Fax with MustBeSentBeforeDate in MonopondSendFaxRequest
To set a MustBeSentBeforeDate for MonopondSendFaxRequest, a request similar to the following can be used.
```php
    // TODO: Put your file path here
    $filedata = fread(fopen("tests/sample.txt", "r"), filesize("tests/sample.txt"));
    $filedata = base64_encode($filedata);
    
    /* Setup Documents */
    $document = new MonopondDocument();
    $document->FileName = "AnyFileName1.txt";
    $document->FileData = $filedata;
    $document->Order = 0;

    /* Setup FaxMessages (Each contains an array of document objects) */
    $faxMessage = new MonopondFaxMessage();
    $faxMessage->MessageRef = "Testing-message-1";
    $faxMessage->SendTo = "61011111111";

    $faxMessage2 = new MonopondFaxMessage();
    $faxMessage2->MessageRef = "Testing-message-2";
    $faxMessage2->SendTo = "61011111112";

    /* Setup FaxSendRequest (Each contains an array of fax messages) */
    $sendFaxRequest = new MonopondSendFaxRequest();
    $sendFaxRequest->FaxMessages = array($faxMessage, $faxMessage2);
    $sendFaxRequest->Documents = array($document);
    $sendFaxRequest->MustBeSentBeforeDate = "2017-09-05T21:30:17+10:00";

    /* Send request to Monopond */
    $sendRespone = $client->sendFax($sendFaxRequest);
    /* Display response */
    print_r($sendRespone);
```
To know more about MustBeSentBeforeDate you can check it here:
* [MonopondSendFaxRequest Properties](#monopondsendfaxrequest-properties)

### Sending a Fax with MaxFaxPages in MonopondFaxMessage
To set a MaxFaxPages for MonopondFaxMessage, a request similar to the following can be used.
```php
    // TODO: Put your file path here
    $filedata = fread(fopen("tests/sample.txt", "r"), filesize("tests/sample.txt"));
    $filedata = base64_encode($filedata);
    
    /* Setup Documents */
    $document = new MonopondDocument();
    $document->FileName = "AnyFileName1.txt";
    $document->FileData = $filedata;
    $document->Order = 0;

    /* Setup FaxMessages (Each contains an array of document objects) */
    $faxMessage = new MonopondFaxMessage();
    $faxMessage->MessageRef = "Testing-message-1";
    $faxMessage->SendTo = "61011111111";
    $faxMessage->MaxFaxPages = 1;

    $faxMessage2 = new MonopondFaxMessage();
    $faxMessage2->MessageRef = "Testing-message-2";
    $faxMessage2->SendTo = "61011111112";
    $faxMessage2->MaxFaxPages = 2;

    /* Setup FaxSendRequest (Each contains an array of fax messages) */
    $sendFaxRequest = new MonopondSendFaxRequest();
    $sendFaxRequest->FaxMessages = array($faxMessage, $faxMessage2);
    $sendFaxRequest->Documents = array($document);

    /* Send request to Monopond */
    $sendRespone = $client->sendFax($sendFaxRequest);
    /* Display response */
    print_r($sendRespone);
```
To know more about MaxFaxPages you can check it here:
* [MonopondFaxMessage Properties](#monopondfaxmessage-properties)

### Sending a Fax with MaxFaxPages in MonopondSendFaxRequest
To set a MaxFaxPages for MonopondSendFaxRequest, a request similar to the following can be used.
```php
    // TODO: Put your file path here
    $filedata = fread(fopen("tests/sample.txt", "r"), filesize("tests/sample.txt"));
    $filedata = base64_encode($filedata);
    
    /* Setup Documents */
    $document = new MonopondDocument();
    $document->FileName = "AnyFileName1.txt";
    $document->FileData = $filedata;
    $document->Order = 0;

    /* Setup FaxMessages (Each contains an array of document objects) */
    $faxMessage = new MonopondFaxMessage();
    $faxMessage->MessageRef = "Testing-message-1";
    $faxMessage->SendTo = "61011111111";

    $faxMessage2 = new MonopondFaxMessage();
    $faxMessage2->MessageRef = "Testing-message-2";
    $faxMessage2->SendTo = "61011111112";

    /* Setup FaxSendRequest (Each contains an array of fax messages) */
    $sendFaxRequest = new MonopondSendFaxRequest();
    $sendFaxRequest->FaxMessages = array($faxMessage, $faxMessage2);
    $sendFaxRequest->Documents = array($document);
    $sendFaxRequest->MaxFaxPages = 2;

    /* Send request to Monopond */
    $sendRespone = $client->sendFax($sendFaxRequest);
    /* Display response */
    print_r($sendRespone);
```
To know more about MaxFaxPages you can check it here:
* [MonopondSendFaxRequest Properties](#monopondsendfaxrequest-properties)

### Sending multiple faxes:
To send faxes to multiple destinations a request similar to the following example can be used. Please note the addition of another `FaxMessage`:

```php
    // TODO: Put your file path here
    $filedata = fread(fopen("tests/sample.txt", "r"), filesize("tests/sample.txt"));
    $filedata = base64_encode($filedata);
    
    /* Setup Documents */
    $document = new MonopondDocument();
    $document->FileName = "AnyFileName1.txt";
    $document->FileData = $filedata;
    $document->Order = 0;

    $document2 = new MonopondDocument();
    $document2->FileName = "AnyFileName2.txt";
    $document2->FileData = $filedata;
    $document2->Order = 0;

    $document3 = new MonopondDocument();
    $document3->FileName = "AnyFileName3.txt";
    $document3->FileData = $filedata;
    $document3->Order = 0;

    /* Setup FaxMessages (Each contains an array of document objects) */
    $faxMessage = new MonopondFaxMessage();
    $faxMessage->MessageRef = "Testing-message-1";
    $faxMessage->SendTo = "61011111111";
    $faxMessage->Documents[] = $document;

    $faxMessage2 = new MonopondFaxMessage();
    $faxMessage2->MessageRef = "Testing-message-2";
    $faxMessage2->SendTo = "61011111112";
    $faxMessage2->Documents[] = $document2;

    $faxMessage3 = new MonopondFaxMessage();
    $faxMessage3->MessageRef = "Testing-message-3";
    $faxMessage3->SendTo = "61011111112";
    $faxMessage3->Documents[] = $document3;

    /* Setup FaxSendRequest (Each contains an array of fax messages) */
    $sendFaxRequest = new MonopondSendFaxRequest();
    $sendFaxRequest->FaxMessages = array($faxMessage, $faxMessage2, $faxMessage3);

    /* Send request to Monopond */
    $sendRespone = $client->sendFax($sendFaxRequest);
    /* Display response */
    print_r($sendRespone);

```

### Sending faxes to multiple destinations with the same document (broadcasting):
To send the same fax content to multiple destinations (broadcasting) a request similar to the example below can be used.

This method is recommended for broadcasting as it takes advantage of the multiple tiers in the send request. This eliminates the repeated parameters out of the individual fax message elements which are instead inherited from the parent send fax request. An example below shows `SendFrom` being used for both FaxMessages. While not shown in the example below further control can be achieved over individual fax elements to override the parameters set in the parent.

When sending multiple faxes in batch it is recommended to group them into requests of around 600 fax messages for optimal performance. If you are sending the same document to multiple destinations it is strongly advised to only attach the document once in the root of the send request rather than attaching a document for each destination.

```php
    // TODO: Put your file path here
    $filedata = fread(fopen("tests/sample.txt", "r"), filesize("tests/sample.txt"));
    $filedata = base64_encode($filedata);
    
    /* Setup Documents */
    $document = new MonopondDocument();
    $document->FileName = "AnyFileName1.txt";
    $document->FileData = $filedata;
    $document->Order = 0;

    $document2 = new MonopondDocument();
    $document2->FileName = "AnyFileName1.txt";
    $document2->FileData = $filedata;
    $document2->Order = 0;

    /* Setup FaxMessages (Each contains an array of document objects) */
    $faxMessage = new MonopondFaxMessage();
    $faxMessage->MessageRef = "Testing-message-1";
    $faxMessage->SendTo = "61011111111";

    $faxMessage2 = new MonopondFaxMessage();
    $faxMessage2->MessageRef = "Testing-message-2";
    $faxMessage2->SendTo = "61011111112";

    $faxMessage3 = new MonopondFaxMessage();
    $faxMessage3->MessageRef = "Testing-message-3";
    $faxMessage3->SendTo = "61011111112";

    /* Setup FaxSendRequest (Each contains an array of fax messages) */
    $sendFaxRequest = new MonopondSendFaxRequest();
    $sendFaxRequest->FaxMessages = array($faxMessage, $faxMessage2, $faxMessage3);
    $sendFaxRequest->Documents = array($document, $document2);

    /* Send request to Monopond */
    $sendRespone = $client->sendFax($sendFaxRequest);
    /* Display response */
    print_r($sendRespone);
```

### Sending Microsoft Documents With DocMergeData:
(This request only works in version 2.1(or higher) of the fax-api.)

This request is used to send a Microsoft document with replaceable variables or merge fields. The merge field follows the pattern ```<mf:key>```.  If your key is ```field1```, it should be typed as ```<mf:field1>``` in the document. Note that the key must be unique within the whole document. The screenshots below are examples of what the request does.

Original .doc file:

![before](https://github.com/Monopond/fax-api/raw/master/img/DocMergeData/before.png)

This is what the file looks like after the fields ```field1```,```field2``` and ```field3``` have been replaced with values ```lazy dog```, ```fat pig``` and ```fat pig```:

![stamp](https://github.com/Monopond/fax-api/raw/master/img/DocMergeData/after.png)

##### Sample Request
The example below shows ```field1``` will be replaced by the value of ```Test```.

```php
	// TODO: Put your file path here
	$filedata = fread(fopen("tests/sample.doc", "r"), filesize("tests/sample.doc"));
	$filedata = base64_encode($filedata);

	$mergeField = new MonopondMergeField();
	$mergeField->Key = "name";
	$mergeField->Value = "Raspberry Pi";

	$document1 = new MonopondDocument();
	$document1->DocumentRef = "send-1-document";
	$document1->DocMergeData[] = $mergeField;

	/* Setup FaxMessages (Each contains an array of document objects) */
	$faxMessage = new MonopondFaxMessage();
	$faxMessage->MessageRef = "message-1";
	$faxMessage->SendTo = "61290120211";
	$faxMessage->SendFrom = "Test Fax";
	$faxMessage->Resolution = "normal";
	$faxMessage->Retries = 0;
	$faxMessage->BusyRetries = 2;
	$faxMessage->CLI = 61290120211;
	$faxMessage->Documents = array($document1);

	$mergeField2 = new MonopondMergeField();
	$mergeField2->Key = "name";
	$mergeField2->Value = "Raspberry Pi 2";

	$document2 = new MonopondDocument();
	$document2->DocumentRef = "send-1-document";
	$document2->DocMergeData[] = $mergeField2;

	$faxMessage2 = new MonopondFaxMessage();
	$faxMessage2->MessageRef = "message-2";
	$faxMessage2->SendTo = "61290120211";
	$faxMessage2->SendFrom = "Test Fax 2";
	$faxMessage2->Resolution = "normal";
	$faxMessage2->Retries = 0;
	$faxMessage2->BusyRetries = 2;
	$faxMessage2->CLI = 61011114111;
	$faxMessage2->Documents = array($document2);

	$baseDocument = new MonopondDocument();
	$baseDocument->DocumentRef = "send-1-document2";
	$baseDocument->FileName = "file.doc";
	$baseDocument->FileData = $filedata;
	$baseDocument->Order = 0;

	/* Setup FaxSendRequest (Each contains an array of fax messages) */
	$sendFaxRequest = new MonopondSendFaxRequest();
	$sendFaxRequest->BroadcastRef = "broadcast-1";
	$sendFaxRequest->SendRef = "send-1";
	$sendFaxRequest->HeaderFormat = "Testing";
	$sendFaxRequest->FaxMessages[] = $faxMessage;
	$sendFaxRequest->FaxMessages[] = $faxMessage2;
	$sendFaxRequest->Documents = array($baseDocument);

	/* Send request to Monopond */
	$sendRespone = $client->sendFax($sendFaxRequest);
	/* Display response */
	print_r($sendRespone);
```

### Sending Tiff and PDF files with StampMergeData:
(This request only works in version 2.1(or higher) of the fax-api.)

This request allows a TIFF file to be stamped with an image or text, based on X-Y coordinates. The x and y coordinates (0,0) starts at the top left part of the document. The screenshots below are examples of what the request does.

Original tiff file:

![before](https://github.com/Monopond/fax-api/raw/master/img/StampMergeData/image_stamp/before.png)

Sample stamp image:

![stamp](https://github.com/Monopond/fax-api/raw/master/img/StampMergeData/image_stamp/stamp.png)

This is what the tiff file looks like after stamping it with the image above:

![after](https://github.com/Monopond/fax-api/raw/master/img/StampMergeData/image_stamp/after.png) 

The same tiff file, but this time, with a text stamp:

![after](https://github.com/Monopond/fax-api/raw/master/img/StampMergeData/text_stamp/after.png) 

##### Sample Request

The example below shows a TIFF that will be stamped with the text “Hello” at xCoord=“1287” and yCoord=“421”, and an image at xCoord=“283” and yCoord=“120”

```php
    // TODO: Put your file path here
    $filedata = fread(fopen("tests/document.tiff", "r"), filesize("tests/document.tiff"));
    $filedata = base64_encode($filedata);

    $stampMergeFieldKey = new MonopondStampMergeFieldKey();
    $stampMergeFieldKey->xCoord = "1287";
    $stampMergeFieldKey->yCoord = "421";

    $stampMergeFieldTextValue = new MonopondStampMergeFieldTextValue();
    $stampMergeFieldTextValue->fontName = "Bookman-DemiItalic";
    $stampMergeFieldTextValue->Value = "Hello";

    $stampMergeField = new MonopondStampMergeField();
    $stampMergeField->StampMergeFieldKey = $stampMergeFieldKey;
    $stampMergeField->TextValue = $stampMergeFieldTextValue;

    // TODO: Setup Document
    $document = new MonopondDocument();
    $document->FileName = "AnyFileName1.tiff";
    $document->FileData = $filedata;
    $document->Order = 0;
    $document->StampMergeData[] = $stampMergeField;

    // TODO: Setup FaxMessage
    $faxMessage = new MonopondFaxMessage();
    $faxMessage->MessageRef = "Testing-message-1";
    $faxMessage->SendTo = "61011111111";
    $faxMessage->SendFrom = "Test Fax";
    $faxMessage->Documents = array($document);
    $faxMessage->Resolution = "normal";

    // // TODO: Setup FaxSendRequest 
    $sendFaxRequest = new MonopondSendFaxRequest();
    $sendFaxRequest->BroadcastRef = "Broadcast-test-1";
    $sendFaxRequest->SendRef = "Send-Ref-1";
    $sendFaxRequest->FaxMessages[] = $faxMessage;

    // // Call send fax method
    $sendRespone = $client->sendFax($sendFaxRequest);
    print_r($sendRespone);
```

### Request with Image Stamping
```php
    // TODO: Put your file path here
    $filedata = fread(fopen("tests/document.tiff", "r"), filesize("tests/document.tiff"));
    $filedata = base64_encode($filedata);

    $stampFiledata = fread(fopen("tests/stamp.png", "r"), filesize("tests/stamp.png"));
    $stampFiledata = base64_encode($stampFiledata);
    
    $stampMergeFieldKey = new MonopondStampMergeFieldKey();
    $stampMergeFieldKey->xCoord = "283";
    $stampMergeFieldKey->yCoord = "120";

    $stampMergeFieldImageValue = new MonopondStampMergeFieldImageValue();
    $stampMergeFieldImageValue->FileName = "hello.png";
    $stampMergeFieldImageValue->FileData = $stampFiledata;
    $stampMergeFieldImageValue->width = "25";
    $stampMergeFieldImageValue->height = "25";

    $stampMergeField = new MonopondStampMergeField();
    $stampMergeField->StampMergeFieldKey = $stampMergeFieldKey;
    $stampMergeField->ImageValue = $stampMergeFieldImageValue;

    // TODO: Setup Document
    $document = new MonopondDocument();
    $document->FileName = "AnyFileName1.tiff";
    $document->FileData = $filedata;
    $document->Order = 0;
    $document->StampMergeData[] = $stampMergeField;

    // TODO: Setup FaxMessage
    $faxMessage = new MonopondFaxMessage();
    $faxMessage->MessageRef = "Testing-message-1";
    $faxMessage->SendTo = "61011111111";
    $faxMessage->SendFrom = "Test Fax";
    $faxMessage->Documents = array($document);
    $faxMessage->Resolution = "normal";

    // // TODO: Setup FaxSendRequest 
    $sendFaxRequest = new MonopondSendFaxRequest();
    $sendFaxRequest->BroadcastRef = "Broadcast-test-1";
    $sendFaxRequest->SendRef = "Send-Ref-1";
    $sendFaxRequest->FaxMessages[] = $faxMessage;

    // // Call send fax method
    $sendRespone = $client->sendFax($sendFaxRequest);
    print_r($sendRespone);
```

<a name="docMergeDataParameters"></a> 

**DocMergeData Mergefield Properties:**

|**Name** | **Required** | **Type** | **Description** |
|-----|-----|-----|-----|
|**Key** | | *String* | A unique identifier used to determine which fields need replacing. |
|**Value** | | *String* | The value that replaces the key. |

<a name="stampMergeDataParameters"></a> 
**StampMergeData Mergefield Properties:**

|**Name** | **Required** | **Type** | **Description** |
|-----|-----|-----|-----|
|**Key** |  | *StampMergeFieldKey* | Contains x and y coordinates where the ImageValue or TextValue should be placed. |
|**TextValue** |  | *StampMergeFieldTextValue* | The text value that replaces the key. |
|**ImageValue** |  | *StampMergeFieldImageValue* | The image value that replaces the key. |

 **StampMergeFieldKey Properties:**

| **Name** | **Required** | **Type** | **Description** |
|----|-----|-----|-----|
| **xCoord** |  | *Int* | X coordinate. |
| **yCoord** |  | *Int* | Y coordinate. |

**StampMergeFieldTextValue Properties:**

|**Name** | **Required** | **Type** | **Description** |
|-----|-----|-----|-----|
|**fontName** |  | *String* | Font name to be used. |
|**fontSize** |  | *Decimal* | Font size to be used. |

**StampMergeFieldImageValue Properties:**

|**Name** | **Required** | **Type** | **Description** |
|-----|-----|-----|-----|
|**fileName** |  | *String* | The document filename including extension. This is important as it is used to help identify the document MIME type. |
|**fileData** |  | *Base64* | The document encoded in Base64 format. |

### Response
The response received from a `SendFaxRequest` matches the response you receive when calling the `FaxStatus` method call with a `send` verbosity level.

### SOAP Faults
This function will throw one of the following SOAP faults/exceptions if something went wrong:
**InvalidArgumentsException, NoMessagesFoundException, DocumentContentTypeNotFoundException, or InternalServerException.**
You can find more details on these faults [here](#section5).

## FaxStatus
### Description

This function provides you with a method of retrieving the status, details and results of fax messages sent. While this is a legitimate method of retrieving results we strongly advise that you take advantage of our callback service, which will push these fax results to you as they are completed.

When making a status request, you must provide at least a `BroadcastRef`, `SendRef` or `MessageRef`. The 
function will also accept a combination of these to further narrow the request query.
- Limiting by a `BroadcastRef` allows you to retrieve faxes contained in a group of send requests.
- Limiting by `SendRef` allows you to retrieve faxes contained in a single send request.
- Limiting by `MessageRef` allows you to retrieve a single fax message.

There are multiple levels of verbosity available in the request; these are explained in detail below.

**FaxStatusRequest Properties:**

| **Name** | **Required** | **Type** | **Description** |
|--- | --- | --- | --- | 
|**BroadcastRef**|  | *String* | User-defined broadcast reference. |
|**SendRef**|  | *String* | User-defined send reference. |
|**MessageRef**|  | *String* | User-defined message reference. |
|**Verbosity**|  | *String* | Verbosity String The level of detail in the status response. Please see below for a list of possible values.| |

**Verbosity Levels:**	
  
| **Value** | **Description** |
| --- | --- |
| **brief** | Gives you an overall view of the messages. This simply shows very high-level statistics, consisting of counts of how many faxes are at each status (i.e. processing, queued,sending) and totals of the results of these faxes (success, failed, blocked). |
| **send** | send Includes the results from ***“brief”*** while also including an itemised list of each fax message in the request. |
| **details** | details Includes the results from ***“send”*** along with details of the properties used to send the fax messages. |
| **results** |Includes the results from ***“send”*** along with the sending results of the fax messages. |
| **all** | all Includes the results from both ***“details”*** and ***“results”*** along with some extra uncommon fields. |

### Sending a faxStatus Request with “brief” verbosity:
```php
 // TODO: Setup FaxStatusRequest 
 $faxStatusRequest = new MonopondFaxStatusRequest();
 $faxStatusRequest->MessageRef = "Testing-message-1";
$faxStatusRequest->Verbosity = "brief";
 // Call fax status method
 $faxStatus = $client->faxStatus($faxStatusRequest);
 print_r($faxStatus);
```
### Sending a faxStatus Request with “send” verbosity:

```php
 // TODO: Setup FaxStatusRequest 
 $faxStatusRequest = new MonopondFaxStatusRequest();
 $faxStatusRequest->MessageRef = "Testing-message-1";
 $faxStatusRequest->Verbosity = "send";
 // Call fax status method
 $faxStatus = $client->faxStatus($faxStatusRequest);
 print_r($faxStatus);
```
### Sending a faxStatus Request with “details” verbosity:
```php
 // TODO: Setup FaxStatusRequest 
 $faxStatusRequest = new MonopondFaxStatusRequest();
 $faxStatusRequest->MessageRef = "Testing-message-1";
 $faxStatusRequest->Verbosity = "details";
 // Call fax status method
 $faxStatus = $client->faxStatus($faxStatusRequest);
 print_r($faxStatus);
```
### Sending a faxStatus Request with “results” verbosity:

```php
 // TODO: Setup FaxStatusRequest 
 $faxStatusRequest = new MonopondFaxStatusRequest();
 $faxStatusRequest->MessageRef = "Testing-message-1";
 $faxStatusRequest->Verbosity = "results";
 // Call fax status method
 $faxStatus = $client->faxStatus($faxStatusRequest);
 print_r($faxStatus);
```
### Response
The response received depends entirely on the verbosity level specified.

**FaxStatusResponse:**

| Name | Type | Verbosity | Description |
| --- | --- | --- | --- |
| **FaxStatusTotals** | *FaxStatusTotals* | *brief* | Counts of how many faxes are at each status. See below for more details. |
| **FaxResultsTotals** | *FaxResultsTotals* | *brief* | FaxResultsTotals FaxResultsTotals brief Totals of the end results of the faxes. See below for more details. |
| **FaxMessages** | *Array of FaxMessage* | *send* | send List of each fax in the query. See below for more details. |

**FaxStatusTotals:**

Contains the total count of how many faxes are at each status. 
To see more information on each fax status, view the FaxStatus table below.

| Name | Type | Verbosity | Description |
| --- | --- | --- | --- |
| **pending** | *Long* | *brief* | Fax is pending on the system and waiting to be processed.|
| **processing** | *Long* | *brief* | Fax is in the initial processing stages. |
| **queued** | *Long* | *brief* | Fax has finished processing and is queued, ready to send out at the send time. |
| **starting** | *Long* | *brief* | Fax is ready to be sent out. |
| **sending** | *Long* | *brief* | Fax has been spooled to our servers and is in the process of being sent out. |
| **finalizing** | *Long* | *brief* | Fax has finished sending and the results are being processed.|
| **done** | *Long* | *brief* | Fax has completed and no further actions will take place. The detailed results are available at this status. |

**FaxResultsTotals:**

Contains the total count of how many faxes ended in each result, as well as some additional totals. To view more information on each fax result, view the FaxResults table below.

| Name | Type | Verbosity | Description |
| --- | --- | --- | --- |
| **success** | *Long* | *brief* | Fax has successfully been delivered to its destination.|
| **blocked** | *Long* |  *brief* | Destination number was found in one of the block lists. |
| **failed** | *Long* | *brief* | Fax failed getting to its destination.|
| **totalAttempts** | *Long* | *brief* |Total attempts made in the reference context.|
| **totalFaxDuration** | *Long* | *brief* |totalFaxDuration Long brief Total time spent on the line in the reference context.|
| **totalPages** | *Long* | *brief* | Total pages sent in the reference context.|


**apiFaxMessageStatus:**

| Name | Type | Verbosity | Description |
| --- | --- | --- | --- |
| **messageRef** | *String* | *send* | |
| **sendRef** | *String* | *send* | |
| **broadcastRef** | *String* | *send* | |
| **sendTo** | *String* | *send* | |
| **status** |  | *send* | The current status of the fax message. See the FaxStatus table above for possible status values. |
| **FaxDetails** | *FaxDetails* | *details* | Contains the details and settings the fax was sent with. See below for more details. |
| **FaxResults** | *Array of FaxResult* | *results* | Contains the results of each attempt at sending the fax message and their connection details. See below for more details. |

**FaxDetails:**

| Name | Type | Verbosity |
| --- | --- | --- |
| **sendFrom** | *Alphanumeric String* | *details* |
| **resolution** | *String* | *details* |
| **retries** | *Integer* | *details* |
| **busyRetries** | *Integer* | *details* |
| **headerFormat** | *String* | *details* |

**FaxResults:**

| Name | Type | Verbosity | Description |
| --- | --- | --- | --- |
| **attempt** | *Integer* | *results* | The attempt number of the FaxResult. |
| **result** | *String* | *results* | The result of the fax message. See the FaxResults table above for all possible results values. |
| **Error** | *FaxError* | *results* |  The fax error code if the fax was not successful. See below for all possible values. |
| **cost** | *BigDecimal* | *results* | The final cost of the fax message. | 
| **pages** | *Integer* | *results* | Total pages sent to the end fax machine. |
| **scheduledStartTime** | *DateTime* | *results* | The date and time the fax is scheduled to start. |
| **dateCallStarted** | *DateTime* | *results* | Date and time the fax started transmitting. |
| **dateCallEnded** | *DateTime* | *results* | Date and time the fax finished transmitting. |

**FaxError:**

| Value | Error Name |
| --- | --- |
| **DOCUMENT_EXCEEDS_PAGE_LIMIT** | Document exceeds page limit |
| **DOCUMENT_UNSUPPORTED** | Unsupported document type |
| **DOCUMENT_FAILED_CONVERSION** | Document failed conversion |
| **FUNDS_INSUFFICIENT** | Insufficient funds |
| **FUNDS_FAILED** | Failed to transfer funds |
| **BLOCK_ACCOUNT** | Number cannot be sent from this account |
| **BLOCK_GLOBAL** | Number found in the Global blocklist |
| **BLOCK_SMART** | Number found in the Smart blocklist |
| **BLOCK_DNCR** | Number found in the DNCR blocklist |
| **BLOCK_CUSTOM** | Number found in a user specified blocklist |
| **FAX_NEGOTIATION_FAILED** | Negotiation failed |
| **FAX_EARLY_HANGUP** | Early hang-up on call |
| **FAX_INCOMPATIBLE_MACHINE** | Incompatible fax machine |
| **FAX_BUSY** | Phone number busy |
| **FAX_NUMBER_UNOBTAINABLE** | Number unobtainable |
| **FAX_SENDING_FAILED** | Sending fax failed |
| **FAX_CANCELLED** | Cancelled |
| **FAX_NO_ANSWER** | No answer |
| **FAX_UNKNOWN** | Unknown fax error |

### SOAP Faults

This function will throw one of the following SOAP faults/exceptions if something went wrong:

**InvalidArgumentsException**, **NoMessagesFoundException**, or **InternalServerException**.
You can find more details on these faults [here](#section5).

## StopFax

### Description
Stops a fax message from sending. This fax message must either be paused, queued, starting or sending. Please note the fax cannot be stopped if the fax is currently in the process of being transmitted to the destination device.

When making a stop request you must provide at least a `BroadcastRef`, `SendRef` or `MessageRef`. The function will also accept a combination of these to further narrow down the request.

### Request
#### StopFaxRequest Properties:

| Name | Required | Type | Description |
| --- | --- | --- | --- |
| **BroadcastRef** | | *String* | User-defined broadcast reference. |
| **SendRef** |  | *String* | User-defined send reference. |
| **MessageRef** |  | *String* | User-defined message reference. |

### StopFax Request limiting by BroadcastRef:
```php
// TODO: Setup StopFaxRequest
 $stopFaxRequest = new MonopondStopFaxRequest();
 $stopFaxRequest->BroadcastRef = "Broadcast-test-1";
 $stopFax = $client->stopFax($stopFaxRequest);
 print_r($stopFax);
```
### StopFax Request limiting by SendRef:

```php
$stopFaxRequest = new MonopondStopFaxRequest();
 $stopFaxRequest->SendRef = "Send-Ref-1";
 $stopFax = $client->stopFax($stopFaxRequest);
 print_r($stopFax);
```
### StopFax Request limiting by MessageRef:
```php
 // TODO: Setup StopFaxRequest
 $stopFaxRequest = new MonopondStopFaxRequest();
 $stopFaxRequest->MessageRef = "Testing-message-1";
 $stopFax = $client->stopFax($stopFaxRequest);
 print_r($stopFax);
```

### Response
The response received from a `StopFaxRequest` is the same response you would receive when calling the `FaxStatus` method call with the `send` verbosity level.

### SOAP Faults
This function will throw one of the following SOAP faults/exceptions if something went wrong:

**InvalidArgumentsException**, **NoMessagesFoundException**, or **InternalServerException**.
You can find more details on these faults [here](#section5).
## PauseFax

### Description
Pauses a fax message before it starts transmitting. This fax message must either be queued, starting or sending. Please note the fax cannot be paused if the message is currently being transmitted to the destination device.

When making a pause request, you must provide at least a `BroadcastRef`, `SendRef` or `MessageRef`. The function will also accept a combination of these to further narrow down the request. 

### Request
#### PauseFaxRequest Properties:
| Name | Required | Type | Description |
| --- | --- | --- | --- |
| **BroadcastRef** | | *String* | User-defined broadcast reference. |
| **SendRef** | | *String* | User-defined send reference. |
| **MessageRef** | | *String* | User-defined message reference. |


### PauseFax Request limiting by BroadcastRef:
```php
// TODO: Setup PauseFaxRequest
 $pauseFaxRequest = new MonopondPauseFaxRequest();
 $pauseFaxRequest->BroadcastRef = "Broadcast-test-1";
 $pauseFax = $client->pauseFax($pauseFaxRequest);
 print_r($pauseFax);
```

### PauseFax Request limiting by SendRef:
```php
 // TODO: Setup PauseFaxRequest
 $pauseFaxRequest = new MonopondPauseFaxRequest();
 $pauseFaxRequest->SendRef = "Send-Ref-1";
 $pauseFax = $client->pauseFax($pauseFaxRequest);
 print_r($pauseFax);
```

### PauseFax Request limiting by MessageRef:
```php
// TODO: Setup PauseFaxRequest
 $pauseFaxRequest = new MonopondPauseFaxRequest();
 $pauseFaxRequest->MessageRef = "Testing-message-1";
 $pauseFax = $client->pauseFax($pauseFaxRequest);
 print_r($pauseFax);
```
### Response
The response received from a `PauseFaxRequest` is the same response you would receive when calling the `FaxStatus` method call with the `send` verbosity level. 

### SOAP Faults
This function will throw one of the following SOAP faults/exceptions if something went wrong:
**InvalidArgumentsException**, **NoMessagesFoundException**, or **InternalServerException**.
You can find more details on these faults in [here](#section5).

## ResumeFax

When making a resume request, you must provide at least a `BroadcastRef`, `SendRef` or `MessageRef`. The function will also accept a combination of these to further narrow down the request. 

### Request
#### ResumeFaxRequest Properties:
| Name | Required | Type | Description |
| --- | --- | --- | --- |
| **BroadcastRef** | | *String* | User-defined broadcast reference. |
| **SendRef** | | *String* | User-defined send reference. |
| **MessageRef** | | *String* | User-defined message reference. |

### ResumeFax Request limiting by BroadcastRef:
```php
 // TODO: Setup ResumeFaxRequest
 $resumeFaxRequest = new MonopondResumeFaxRequest();
 $resumeFaxRequest->BroadcastRef = "Broadcast-test-1";
 $resumeFax = $client->resumeFax($resumeFaxRequest);
 print_r($resumeFax);
```
### ResumeFax Request limiting by SendRef:
```php
// TODO: Setup ResumeFaxRequest
 $resumeFaxRequest = new MonopondResumeFaxRequest();
 $resumeFaxRequest->SendRef = "Send-Ref-1";
 $resumeFax = $client->resumeFax($resumeFaxRequest);
 print_r($resumeFax);
```
### ResumeFax Request limiting by MessageRef:
```php
 $resumeFaxRequest = new MonopondResumeFaxRequest();
 $resumeFaxRequest->MessageRef = "Testing-message-1";
 $resumeFax = $client->resumeFax($resumeFaxRequest);
 print_r($resumeFax);
```

### Response
The response received from a `ResumeFaxRequest` is the same response you would receive when calling the `FaxStatus` method call with the `send` verbosity level. 

### SOAP Faults
This function will throw one of the following SOAP faults/exceptions if something went wrong:
**InvalidArgumentsException**, **NoMessagesFoundException**, or **InternalServerException**.
You can find more details on these faults [here](#section5).

## PreviewFaxDocument
### Description

This function provides you with a method to generate a preview of a saved document at different resolutions with various dithering settings. It returns a tiff data in base64 along with a page count.

### Normal PreviewFaxDocument Request
```php
    // TODO: Put your file path here
    $faxDocumentPreviewRequest = new MonopondFaxDocumentPreviewRequest();
    $faxDocumentPreviewRequest->DocumentRef = "hello-space2021";
    $faxDocumentPreviewRequest->Resolution = "fine";
    $faxDocumentPreviewRequest->DitheringTechnique = "normal";

    $faxDocumentPreviewResponse = $client->faxDocumentPreview($faxDocumentPreviewRequest);
    print_r($faxDocumentPreviewResponse);
```

### PreviewFaxDocument Request with StampMergeFieldText
```php
    // TODO: Put your file path here
    $filedata = fread(fopen("tests/document.tiff", "r"), filesize("tests/document.tiff"));
    $filedata = base64_encode($filedata);

    $stampFiledata = fread(fopen("tests/stamp.png", "r"), filesize("tests/stamp.png"));
    $stampFiledata = base64_encode($stampFiledata);

    $stampMergeFieldKey = new MonopondStampMergeFieldKey();
    $stampMergeFieldKey->xCoord = "390";
    $stampMergeFieldKey->yCoord = "757";

    $stampMergeFieldTextValue = new MonopondStampMergeFieldTextValue();
    $stampMergeFieldTextValue->fontName = "Bookman-DemiItalic";
    $stampMergeFieldTextValue->Value = "Hello World!";

    $monopondStampMergeField = new MonopondStampMergeField();
    $monopondStampMergeField->StampMergeFieldKey = $stampMergeFieldKey;
    $monopondStampMergeField->TextValue = $stampMergeFieldTextValue;

    $faxDocumentPreviewRequest = new MonopondFaxDocumentPreviewRequest();
    $faxDocumentPreviewRequest->DocumentRef = "sample-document-ref";
    $faxDocumentPreviewRequest->Resolution = "fine";
    $faxDocumentPreviewRequest->DitheringTechnique = "normal";
    $faxDocumentPreviewRequest->StampMergeData = array($monopondStampMergeField);

    $faxDocumentPreviewResponse = $client->faxDocumentPreview($faxDocumentPreviewRequest);
    print_r($faxDocumentPreviewResponse);
```

### PreviewFaxDocument Request with StampMergeFieldText
```php
    $filedata = fread(fopen("tests/document.tiff", "r"), filesize("tests/document.tiff"));
    $filedata = base64_encode($filedata);

    $stampFiledata = fread(fopen("tests/stamp.png", "r"), filesize("tests/stamp.png"));
    $stampFiledata = base64_encode($stampFiledata);

    $stampMergeFieldKey = new MonopondStampMergeFieldKey();
    $stampMergeFieldKey->xCoord = "390";
    $stampMergeFieldKey->yCoord = "757";

    $stampMergeFieldImageValue = new MonopondStampMergeFieldImageValue();
    $stampMergeFieldImageValue->FileName = "hello.png";
    $stampMergeFieldImageValue->FileData = $stampFiledata;
    $stampMergeFieldImageValue->width = "25";
    $stampMergeFieldImageValue->height = "25";

    $stampMergeField = new MonopondStampMergeField();
    $stampMergeField->StampMergeFieldKey = $stampMergeFieldKey;
    $stampMergeField->ImageValue = $stampMergeFieldImageValue;

    $faxDocumentPreviewRequest = new MonopondFaxDocumentPreviewRequest();
    $faxDocumentPreviewRequest->DocumentRef = "hello-space2021";
    $faxDocumentPreviewRequest->Resolution = "fine";
    $faxDocumentPreviewRequest->DitheringTechnique = "normal";
    $faxDocumentPreviewRequest->StampMergeData = array($stampMergeField);

    $faxDocumentPreviewResponse = $client->faxDocumentPreview($faxDocumentPreviewRequest);
    print_r($faxDocumentPreviewResponse);
```

### PreviewFaxDocument Request with DocMergeData
```php
    // TODO: Put your file path here
    $filedata = fread(fopen("tests/sample.doc", "r"), filesize("tests/sample.doc"));
    $filedata = base64_encode($filedata);

    $mergeField = new MonopondMergeField();
    $mergeField->Key = "field1";
    $mergeField->Value = "Raspberry Pi";

    $mergeField2 = new MonopondMergeField();
    $mergeField2->Key = "field2";
    $mergeField2->Value = "Human";

    $faxDocumentPreviewRequest = new MonopondFaxDocumentPreviewRequest();
    $faxDocumentPreviewRequest->DocumentRef = "sample-documentref";
    $faxDocumentPreviewRequest->Resolution = "fine";
    $faxDocumentPreviewRequest->DitheringTechnique = "normal";
    $faxDocumentPreviewRequest->DocMergeData = array($mergeField, $mergeField2);

    $faxDocumentPreviewResponse = $client->faxDocumentPreview($faxDocumentPreviewRequest);
    print_r($faxDocumentPreviewResponse);

```

### Request
**FaxDocumentPreviewRequest Parameters:**

| **Name** | **Required** | **Type** | **Description** | **Default** |
|--- | --- | --- | --- | ---|
|**Resolution**|  | *Resolution* |Resolution setting of the fax document. Refer to the resolution table below for possible resolution values.| normal |
|**DitheringTechnique**| | *FaxDitheringTechnique* | Applies a custom dithering method to the fax document before transmission. | |
|**DocMergeData** | | *Array of DocMergeData MergeFields* | Each mergefield has a key and a value. The system will look for the keys in a document and replace them with their corresponding value. ||
|**StampMergeData** | | *Array of StampMergeData MergeFields* | Each mergefield has a key a corressponding TextValue/ImageValue. The system will look for the keys in a document and replace them with their corresponding value. | | |

**DocMergeData Mergefield Parameters:**

|**Name** | **Required** | **Type** | **Description** |
|-----|-----|-----|-----|
|**Key** | | *String* | A unique identifier used to determine which fields need replacing. |
|**Value** | | *String* | The value that replaces the key. |

**StampMergeData Mergefield Parameters:**

|**Name** | **Required** | **Type** | **Description** |
|-----|-----|-----|-----|
|**Key** |  | *StampMergeFieldKey* | Contains x and y coordinates where the ImageValue or TextValue should be placed. |
|**TextValue** |  | *StampMergeFieldTextValue* | The text value that replaces the key. |
|**ImageValue** |  | *StampMergeFieldImageValue* | The image value that replaces the key. |

 **StampMergeFieldKey Parameters:**

| **Name** | **Required** | **Type** | **Description** |
|----|-----|-----|-----|
| **xCoord** |  | *Int* | X coordinate. |
| **yCoord** |  | *Int* | Y coordinate. |

**StampMergeFieldTextValue Parameters:**

|**Name** | **Required** | **Type** | **Description** |
|-----|-----|-----|-----|
|**fontName** |  | *String* | Font name to be used. |
|**fontSize** |  | *Decimal* | Font size to be used. |

**StampMergeFieldImageValue Parameters:**

|**Name** | **Required** | **Type** | **Description** |
|-----|-----|-----|-----|
|**fileName** |  | *String* | The document filename including extension. This is important as it is used to help identify the document MIME type. |
|**fileData** |  | *Base64* | The document encoded in Base64 format. |

**FaxDocumentPreviewResponse**

**Name** | **Type** | **Description** 
-----|-----|-----
**TiffPreview** | *String* | A preview version of the document encoded in Base64 format. 
**NumberOfPages** | *Int* | Total number of pages in the document preview.

### SOAP Faults
This function will throw one of the following SOAP faults/exceptions if something went wrong:
**DocumentRefDoesNotExistException**, **InternalServerException**, **UnsupportedDocumentContentType**, **MergeFieldDoesNotMatchDocumentTypeException**, **UnknownHostException**.
You can find more details on these faults in Section 5 of this document.You can find more details on these faults in the next section of this document.

## SaveFaxDocument
### Description

This function allows you to upload a document and save it under a document reference (DocumentRef) for later use. (Note: These saved documents only last 30 days on the system.)

### Sample Request

```php
    $filedata = fread(fopen("tests/test.pdf", "r"), filesize("tests/test.pdf"));
    $filedata = base64_encode($filedata);

    $saveFaxDocumentRequest = new MonopondSaveFaxDocumentRequest();
    $saveFaxDocumentRequest->DocumentRef = "sample-document-ref";
    $saveFaxDocumentRequest->FileName = "test.pdf";
    $saveFaxDocumentRequest->FileData = $filedata;

    $saveFaxDocumentResponse = $client->saveFaxDocument($saveFaxDocumentRequest);
    print_r($saveFaxDocumentResponse);
```

### Request
**SaveFaxDocumentRequest Parameters:**

| **Name** | **Required** | **Type** | **Description** |
|--- | --- | --- | --- | 
|**DocumentRef**| **X** | *String* | Unique identifier for the document to be uploaded. |
|**FileName**| **X** | *String* | The document filename including extension. This is important as it is used to help identify the document MIME type. |
| **FileData**|**X**| *Base64* |The document encoded in Base64 format.| |

### SOAP Faults
This function will throw one of the following SOAP faults/exceptions if something went wrong:
**DocumentRefAlreadyExistsException**, **DocumentContentTypeNotFoundException**, **InternalServerException**.
You can find more details on these faults in Section 5 of this document.You can find more details on these faults in the next section of this document.

## DeleteFaxDocument
### Description

This function removes a saved fax document from the system.

### Sample Request
```php
    // TODO: Put your file path here
    $filedata = fread(fopen("tests/test.pdf", "r"), filesize("tests/test.pdf"));
    $filedata = base64_encode($filedata);

    $deleteFaxDocumentRequest = new MonopondDeleteFaxDocumentRequest();
    $deleteFaxDocumentRequest->DocumentRef = "sample-document-ref";

    // Call delete FaxDocument method
    $deleteRespone = $client->deleteFaxDocument($deleteFaxDocumentRequest);
    print_r($deleteRespone);
```

### Request
**DeleteFaxDocumentRequest Parameters:**

| **Name** | **Required** | **Type** | **Description** |
|--- | --- | --- | --- | 
|**DocumentRef**| | *String* | Unique identifier for the document to be deleted. |
|**MessageRef**| | *String* | User-defined message reference. |
|**SendRef**| | *String* | User-defined send reference. |
|**BroadcastRef**| | *String* | User-defined broadcast reference. |

### SOAP Faults
This function will throw one of the following SOAP faults/exceptions if something went wrong:
**DocumentRefDoesNotExistException**, **InternalServerException**.
You can find more details on these faults in Section 5 of this document.You can find more details on these faults in the next section of this document.

<a name="section5"></a> 
# More Information
## Exceptions/SOAP Faults
If an error occurs during a request on the Monopond Fax API the service will throw a SOAP fault or exception. Each exception is listed in detail below. 
### InvalidArgumentsException
One or more of the arguments passed in the request were invalid. Each element that failed validation is included in the fault details along with the reason for failure.
### DocumentContentTypeNotFoundException
There was an error while decoding the document provided; we were unable to determine its content type.
### DocumentRefAlreadyExistsException
There is already a document on your account with this DocumentRef.
### DocumentContentTypeNotFoundException
Content type could not be found for the document.
### NoMessagesFoundException
Based on the references sent in the request no messages could be found that match the criteria.
### InternalServerException
An unusual error occurred on the platform. If this error occurs please contact support for further instruction.

## General Properties and File Formatting
### File Encoding
All files are encoded in the Base64 encoding specified in RFC 2045 - MIME (Multipurpose Internet Mail Extensions). The Base64 encoding is designed to represent arbitrary sequences of octets in a form that need not be humanly readable. A 65-character subset ([A-Za-z0-9+/=]) of US-ASCII is used, enabling 6 bits to be represented per printable character. For more information see http://tools.ietf.org/html/rfc2045 and http://en.wikipedia.org/wiki/Base64

### Dates
Dates are always passed in ISO-8601 format with time zone. For example: “2012-07-17T19:27:23+08:00”

### MonopondSendFaxRequest Properties
**Name**|**Required**|**Type**|**Description**|**Default**
-----|-----|-----|-----|-----
**BroadcastRef**||String|Allows the user to tag all faxes in this request with a user-defined broadcastreference. These faxes can then be retrieved at a later point based on this reference.|
**SendRef**||String|Similar to the BroadcastRef, this allows the user to tag all faxes in this request with a send reference. The SendRef is used to represent all faxes in this request only, so naturally it must be unique.|
**FaxMessages**|**X**| Array of FaxMessage |FaxMessages describe each individual fax message and its destination. See below for details.|
**SendFrom**||Alphanumeric String|A customisable string used to identify the sender of the fax. Also known as the Transmitting Subscriber Identification (TSID). The maximum string length is 32 characters|Fax
**Documents**|**X**|Array of apiFaxDocument|Each FaxDocument object describes a fax document to be sent. Multiple documents can be defined here which will be concatenated and sent in the same message. See below for details.|
**Resolution**||Resolution|Resolution setting of the fax document. Refer to the resolution table below for possible resolution values.|normal
**ScheduledStartTime**||DateTime|The date and time the transmission of the fax will start.|Current time (immediate sending)
**Blocklists**||Blocklists|The blocklists that will be checked and filtered against before sending the message. See below for details.WARNING: This feature is inactive and non-functional in this (2.1) version of the Fax API.|
**Retries**||Unsigned Integer|The number of times to retry sending the fax if it fails. Each account has a maximum number of retries that can be changed by consultation with your account manager.|Account Default
**BusyRetries**||Unsigned Integer|Certain fax errors such as “NO_ANSWER” or “BUSY” are not included in the above retries limit and can be set separately. Each account has a maximum number of busy retries that can be changed by consultation with your account manager.|Account default
**HeaderFormat**||String|Allows the header format that appears at the top of the transmitted fax to be changed. See below for an explanation of how to format this field.| From: X, To: X
**MustBeSentBeforeDate** | | DateTime |  Specifies a time the fax must be delivered by. Once the specified time is reached the fax will be cancelled across the system. | 
**MaxFaxPages** | | Unsigned Integer |  Sets a limit on the amount of pages allowed in a single fax transmission. Especially useful if the user is blindly submitting their customer's documents to the platform. | 20

### MonopondFaxMessage Properties
This represents a single fax message being sent to a destination.

**Name** | **Required** | **Type** | **Description** | **Default** 
-----|-----|-----|-----|-----
**MessageRef** | **X** | String | A unique user-provided identifier that is used to identify the fax message. This can be used at a later point to retrieve the results of the fax message. |
**SendTo** | **X** | String | The phone number the fax message will be sent to. |
**SendFrom** | | Alphanumeric String | A customisable string used to identify the sender of the fax. Also known as the Transmitting Subscriber Identification (TSID). The maximum string length is 32 characters | Empty
**Documents** | **X** | Array of apiFaxDocument | Each FaxDocument object describes a fax document to be sent. Multiple documents can be defined here which will be concatenated and sent in the same message. See below for details. | 
**Resolution** | | Resolution|Resolution setting of the fax document. Refer to the resolution table below for possible resolution values.| normal
**ScheduledStartTime** | | DateTime | The date and time the transmission of the fax will start. | Start now
**Blocklists** | | Blocklists | The blocklists that will be checked and filtered against before sending the message. See below for details. WARNING: This feature is inactive and non-functional in this (2.1) version of the Fax API. |
**Retries** | | Unsigned Integer | The number of times to retry sending the fax if it fails. Each account has a maximum number of retries that can be changed by consultation with your account manager. | Account Default
**BusyRetries** | | Unsigned Integer | Certain fax errors such as “NO_ANSWER” or “BUSY” are not included in the above retries limit and can be set separately. Please consult with your account manager in regards to maximum value.|account default
**HeaderFormat** | | String | Allows the header format that appears at the top of the transmitted fax to be changed. See below for an explanation of how to format this field. | From： X, To: X
**MustBeSentBeforeDate** | | DateTime |  Specifies a time the fax must be delivered by. Once the specified time is reached the fax will be cancelled across the system. | 
**MaxFaxPages** | | Unsigned Integer |  Sets a limit on the amount of pages allowed in a single fax transmission. Especially useful if the user is blindly submitting their customer's documents to the platform. | 20
**CLI**| | String| Allows a customer called ID. Note: Must be enabled on the account before it can be used.

### MonopondDocument Properties
Represents a fax document to be sent through the system. Supported file types are: PDF, TIFF, PNG, JPG, GIF, TXT, PS, RTF, DOC, DOCX, XLS, XLSX, PPT, PPTX.

**Name**|**Required**|**Type**|**Description**|**Default**
-----|-----|-----|-----|-----
**FileName**|**X**|String|The document filename including extension. This is important as it is used to help identify the document MIME type.|
**FileData**|**X**|Base64|The document encoded in Base64 format.|
**Order** |**X** | Integer|If multiple documents are defined on a message this value will determine the order in which they will be transmitted.|0|
**DocMergeData**|||An Array of MergeFields|
**StampMergeData**|||An Array of MergeFields|

### Resolution Levels

| **Value** | **Description** |
| --- | --- |
| **normal** | Normal standard resolution (98 scan lines per inch) |
| **fine** | Fine resolution (196 scan lines per inch) |

### FaxDitheringTechnique

| Value | Fax Dithering Technique |
| --- | --- |
| **none** | No dithering. |
| **normal** | Normal dithering.|
| **turbo** | Turbo dithering.|
| **darken** | Darken dithering.|
| **darken_more** | Darken more dithering.|
| **darken_extra** | Darken extra dithering.|
| **lighten** | Lighten dithering.|
| **lighten_more** | Lighten more dithering. |
| **crosshatch** | Crosshatch dithering. |
| **DETAILED** | Detailed dithering. |

### Header Format
Determines the format of the header line that is printed on the top of the transmitted fax message.
This is set to **rom %from%, To %to%|%a %b %d %H:%M %Y”**y default which produces the following:

From TSID, To 61022221234 Mon Aug 28 15:32 2012 1 of 1

**Value** | **Description**
--- | ---
**%from%**|The value of the **SendFrom** field in the message.
**%to%**|The value of the **SendTo** field in the message.
**%a**|Weekday name (abbreviated)
**%A**|Weekday name
**%b**|Month name (abbreviated)
**%B**|Month name
**%d**|Day of the month as a decimal (01 – 31)
**%m**|Month as a decimal (01 – 12)
**%y**|Year as a decimal (abbreviated)
**%Y**|Year as a decimal
**%H**|Hour as a decimal using a 24-hour clock (00 – 23)
**%I**|Hour as a decimal using a 12-hour clock (01 – 12)
**%M**|Minute as a decimal (00 – 59)
**%S**|Second as a decimal (00 – 59)
**%p**|AM or PM
**%j**|Day of the year as a decimal (001 – 366)
**%U**|Week of the year as a decimal (Monday as first day of the week) (00 – 53)
**%W**|Day of the year as a decimal (001 – 366)
**%w**|Day of the week as a decimal (0 – 6) (Sunday being 0)
**%%**|A literal % character

TODO: The default value is set to: “From %from%, To %to%|%a %b %d %H:%M %Y”

### Blocklists Parameters

| **Name** | **Required** | **Type** | **Description** |
| --- | --- | --- | --- |
| **smartblock** | false | boolean | Blocks sending to a number if it has consistently failed in the past. |
| **fps** | false | boolean | Wash numbers against the fps blocklist. |
| **dncr** | false | boolean | Wash numbers against the dncr blocklist. |
