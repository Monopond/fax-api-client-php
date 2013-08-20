<?php
    include_once './MonopondSOAPClient.php';
    
    // TODO: Enter your own credentials here
    $client = new MonopondSOAPClientV2("username", "password", MPENV::Production);
    
    // TODO: Put your file path here
    $filedata = fread(fopen("./test.txt", "r"), filesize("./test.txt"));
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
    
    
    $document4 = new MonopondDocument();
    $document4->FileName = "AnyFileName4.txt";
    $document4->FileData = $filedata;
    $document4->Order = 0;
    
    /* Setup FaxMessages (Each contains an array of document objects) */
    $faxMessage = new MonopondFaxMessage();
    $faxMessage->MessageRef = "Testing-message-1";
    $faxMessage->SendTo = "61011111111";
    $faxMessage->SendFrom = "Test Fax";
    $faxMessage->Resolution = "normal";
    $faxMessage->Retries = 0;
    $faxMessage->BusyRetries = 2;
    
    $faxMessage2 = new MonopondFaxMessage();
    $faxMessage2->MessageRef = "Testing-message-2";
    $faxMessage2->SendTo = "61011111111";
    $faxMessage2->SendFrom = "Test Fax 2";
    $faxMessage2->Resolution = "normal";
    $faxMessage2->Retries = 0;
    $faxMessage2->BusyRetries = 2;
    
    /* Setup FaxSendRequest (Each contains an array of fax messages) */
    $sendFaxRequest = new MonopondSendFaxRequest();
    $sendFaxRequest->BroadcastRef = "Broadcast-test-1";
    $sendFaxRequest->SendRef = "Send-Ref-1";
    $sendFaxRequest->HeaderFormat = "Testing";
    $sendFaxRequest->FaxMessages[] = $faxMessage;
    $sendFaxRequest->FaxMessages[] = $faxMessage2;
    $sendFaxRequest->Documents = array($document);

    /* Send request to Monopond */
    $sendRespone = $client->sendFax($sendFaxRequest);
    /* Display response */
    print_r($sendRespone);

    /* Setup FaxStatusRequest */
    $faxStatusRequest = new MonopondFaxStatusRequest();
    $faxStatusRequest->MessageRef = "test-2-1-1";
    $faxStatusRequest->Verbosity = "all";

    /* Send request to Monopond */
    $faxStatus = $client->faxStatus($faxStatusRequest);
    /* Display response */
    print_r($faxStatus);

    /* Setup StopFaxRequest */
    $stopFaxRequest = new MonopondStopFaxRequest();
    $stopFaxRequest->MessageRef = "test-2-2-1";

    /* Send request to Monopond */
    $stopFax = $client->resumeFax($stopFaxRequest);
    /* Display response */
    print_r($stopFax);
    
    /* Setup StopFaxRequest */
    $stopFaxRequest = new MonopondStopFaxRequest();
    $stopFaxRequest->MessageRef = "test-2-2-1";

    /* Send request to Monopond */
    $stopFax = $client->stopFax($stopFaxRequest);
    /* Display response */
    print_r($stopFax);

    /* Setup PauseFaxRequest */
    $pauseFaxRequest = new MonopondPauseFaxRequest();
    $pauseFaxRequest->MessageRef = "test-2-2-1";

    /* Send request to Monopond */
    $pauseFax = $client->pauseFax($pauseFaxRequest);
    /* Display response */
    print_r($pauseFax);

    /* Setup ResumeFaxRequest */
    $resumeFaxRequest = new MonopondResumeFaxRequest();
    $resumeFaxRequest->MessageRef = "test-2-2-1";

    /* Send request to Monopond */
    $resumeFax = $client->resumeFax($resumeFaxRequest);
    /* Display response */
    print_r($resumeFax);
?>

