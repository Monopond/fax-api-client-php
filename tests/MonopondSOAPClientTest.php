<?php

    require_once dirname(__FILE__) . '/../MonopondSOAPClient.php';

class MonopondSOAPClientV2Test extends PHPUnit_Framework_TestCase {

    public function testFaxStatusWithBriefVerbosity(){
    	$client = $this->getMockFromWsdl('faxapi-v2.wsdl', 'faxStatus');

    	$client->expects($this->any())
    		->method('faxStatus')
    		->will($this->returnValue(new MonopondFaxStatusResponse(new SimpleXMLElement(
    			"<FaxStatusResponse>
    				<FaxStatusTotals processing='2'/>
    				<FaxResultsTotals totalAttempts='0' totalFaxDuration='0' totalPages='0'/>
    			</FaxStatusResponse>"))));

    	$faxStatusRequest = new MonopondFaxStatusRequest();
    	$faxStatusRequest->MessageRef = "test-2-1-1";

    	$faxStatus = $client->faxStatus($faxStatusRequest);
    	$this->assertFaxTotals($faxStatus);
    }

    public function testFaxStatusWithSendVerbosity(){
    	$client = $this->getMockFromWsdl('faxapi-v2.wsdl', 'faxStatus');

    	$client->expects($this->any())
    		->method('faxStatus')
    		->will($this->returnValue(new MonopondFaxStatusResponse(new SimpleXMLElement(
    			"<FaxStatusResponse>
    				<FaxStatusTotals processing='2'/>
         				<FaxResultsTotals totalAttempts='0' totalFaxDuration='0' totalPages='0'/>
         				<FaxMessages>
            				<FaxMessage messageRef='test-2-1-1' sendRef='test-2-1' broadcastRef='test-27' sendTo='61280039890' status='stopping'/>
            				<FaxMessage messageRef='test-2-1-1' sendRef='test-2-1' broadcastRef='test-tps' sendTo='61280039890' status='stopping'/>
         				</FaxMessages>
         			</FaxStatusResponse>"))));

    	$faxStatusRequest = new MonopondFaxStatusRequest();
    	$faxStatusRequest->MessageRef = "test-2-1-1";
    	$faxStatusRequest->Verbosity = "send";

    	$faxStatus = $client->faxStatus($faxStatusRequest);
    	$this->assertFaxTotals($faxStatus);
    	$this->assertFaxResultsTotals($faxStatus);
    	$this->assertFaxMessages($faxStatus);
    }

    public function testFaxStatusWithDetailsVerbosity(){

    	$client = $this->getMockFromWsdl('faxapi-v2.wsdl', 'faxStatus');

    	$client->expects($this->any())
    		->method('faxStatus')
    		->will($this->returnValue(new MonopondFaxStatusResponse(new SimpleXMLElement(
    			"<FaxStatusResponse>
			         <FaxStatusTotals processing='2'/>
			         <FaxResultsTotals totalAttempts='0' totalFaxDuration='0' totalPages='0'/>
			         <FaxMessages>
			          		<FaxMessage messageRef='test-2-1-1' sendRef='test-2-1' broadcastRef='test-27' sendTo='61280039890' status='stopping'>
			               		<FaxDetails sendFrom='Test Fax' resolution='normal' retries='2' busyRetries='2'/>
			            	</FaxMessage>
			            	<FaxMessage messageRef='test-2-1-1' sendRef='test-2-1' broadcastRef='test-tps' sendTo='61280039890' status='stopping'>
			               		<FaxDetails sendFrom='Test Fax' resolution='normal' retries='2' busyRetries='2'/>
			            	</FaxMessage>
			         </FaxMessages>
      			</FaxStatusResponse>"))));

    	$faxStatusRequest = new MonopondFaxStatusRequest();
    	$faxStatusRequest->MessageRef = "test-2-1-1";
    	$faxStatusRequest->Verbosity = "details";

    	$faxStatus = $client->faxStatus($faxStatusRequest);
    	$this->assertFaxTotals($faxStatus);
    	$this->assertFaxResultsTotals($faxStatus);
    	$this->assertFaxMessages($faxStatus);
    	$this->assertFaxDetails($faxStatus);
    }

    public function testFaxStatusWithResultsVerbosity(){
	$client = $this->getMockFromWsdl('faxapi-v2.wsdl', 'faxStatus');

    	$client->expects($this->any())
    		->method('faxStatus')
    		->will($this->returnValue(new MonopondFaxStatusResponse(new SimpleXMLElement(
    			"<FaxStatusResponse>
			         <FaxStatusTotals processing='2'/>
			         <FaxResultsTotals totalAttempts='0' totalFaxDuration='0' totalPages='0'/>
			         <FaxMessages>
			          		<FaxMessage messageRef='test-2-1-1' sendRef='test-2-1' broadcastRef='test-27' sendTo='61280039890' status='stopping'>
			               		<FaxResults>
                  						<FaxResult attempt='1' scheduledStartTime='2013-09-03T16:43:49.215+08:00'/>
               					</FaxResults>
			            	</FaxMessage>
			            	<FaxMessage messageRef='test-2-1-1' sendRef='test-2-1' broadcastRef='test-tps' sendTo='61280039890' status='stopping'>
			               		<FaxResults>
                  						<FaxResult attempt='1' scheduledStartTime='2013-09-03T16:47:36.542+08:00'/>
               					</FaxResults>
			            	</FaxMessage>
			         </FaxMessages>
      			</FaxStatusResponse>"))));

    	$faxStatusRequest = new MonopondFaxStatusRequest();
    	$faxStatusRequest->MessageRef = "test-2-1-1";
    	$faxStatusRequest->Verbosity = "results";

    	$faxStatus = $client->faxStatus($faxStatusRequest);
    	$this->assertFaxTotals($faxStatus);
    	$this->assertFaxResultsTotals($faxStatus);
    	$this->assertFaxMessages($faxStatus);
    	$this->assertFaxResults($faxStatus);

    }

    public function testFaxStatusWithAllVerbosity(){
    	$client = $this->getMockFromWsdl('faxapi-v2.wsdl', 'faxStatus');

    	$client->expects($this->any())
    		->method('faxStatus')
    		->will($this->returnValue(new MonopondFaxStatusResponse(new SimpleXMLElement(
    			"<FaxStatusResponse>
			         <FaxStatusTotals processing='2'/>
			         <FaxResultsTotals totalAttempts='0' totalFaxDuration='0' totalPages='0'/>
			         <FaxMessages>
			          		<FaxMessage messageRef='test-2-1-1' sendRef='test-2-1' broadcastRef='test-27' sendTo='61280039890' status='stopping'>
			          			<FaxDetails sendFrom='Test Fax' resolution='normal' retries='2' busyRetries='2'/>
			               		<FaxResults>
                  						<FaxResult attempt='1' scheduledStartTime='2013-09-03T16:43:49.215+08:00'/>
               					</FaxResults>
			            	</FaxMessage>
			            	<FaxMessage messageRef='test-2-1-1' sendRef='test-2-1' broadcastRef='test-tps' sendTo='61280039890' status='stopping'>
			            		<FaxDetails sendFrom='Test Fax' resolution='normal' retries='2' busyRetries='2'/>
			               		<FaxResults>
                  						<FaxResult attempt='1' scheduledStartTime='2013-09-03T16:47:36.542+08:00'/>
               					</FaxResults>
			            	</FaxMessage>
			         </FaxMessages>
      			</FaxStatusResponse>"))));

    	$faxStatusRequest = new MonopondFaxStatusRequest();
    	$faxStatusRequest->MessageRef = "test-2-1-1";
    	$faxStatusRequest->Verbosity = "results";

    	$faxStatus = $client->faxStatus($faxStatusRequest);
    	$this->assertFaxTotals($faxStatus);
    	$this->assertFaxResultsTotals($faxStatus);
    	$this->assertFaxMessages($faxStatus);
    	$this->assertFaxDetails($faxStatus);
    	$this->assertFaxResults($faxStatus);
    }

    function assertFaxTotals($faxStatus) {
    	$this->assertEquals(2, $faxStatus->FaxStatusTotals->processing);
    }

    function assertFaxResultsTotals($faxStatus){
    	$this->assertEquals(0, $faxStatus->FaxResultsTotals->totalAttempts);
   	$this->assertEquals(0, $faxStatus->FaxResultsTotals->totalFaxDuration);
   	$this->assertEquals(0, $faxStatus->FaxResultsTotals->totalPages);
    }

    function assertFaxMessages($faxStatus){
    	$this->assertEquals('test-2-1-1', $faxStatus->FaxMessages[0]->messageRef);
   	$this->assertEquals('test-2-1', $faxStatus->FaxMessages[0]->sendRef);
   	$this->assertEquals('test-27', $faxStatus->FaxMessages[0]->broadcastRef);
   	$this->assertEquals('61280039890', $faxStatus->FaxMessages[0]->sendTo);
   	$this->assertEquals('stopping', $faxStatus->FaxMessages[0]->status); 

   	$this->assertEquals('test-2-1-1', $faxStatus->FaxMessages[1]->messageRef);
   	$this->assertEquals('test-2-1', $faxStatus->FaxMessages[1]->sendRef);
   	$this->assertEquals('test-tps', $faxStatus->FaxMessages[1]->broadcastRef);
   	$this->assertEquals('61280039890', $faxStatus->FaxMessages[1]->sendTo);
   	$this->assertEquals('stopping', $faxStatus->FaxMessages[1]->status); 
    }

    function assertFaxDetails($faxStatus){
    	$this->assertEquals('Test Fax', $faxStatus->FaxMessages[0]->faxDetails->sendFrom);
    	$this->assertEquals('normal', $faxStatus->FaxMessages[0]->faxDetails->resolution);
    	$this->assertEquals(2, $faxStatus->FaxMessages[0]->faxDetails->retries);
    	$this->assertEquals(2, $faxStatus->FaxMessages[0]->faxDetails->busyRetries);

    	$this->assertEquals('Test Fax', $faxStatus->FaxMessages[1]->faxDetails->sendFrom);
    	$this->assertEquals('normal', $faxStatus->FaxMessages[1]->faxDetails->resolution);
    	$this->assertEquals(2, $faxStatus->FaxMessages[1]->faxDetails->retries);
    	$this->assertEquals(2, $faxStatus->FaxMessages[1]->faxDetails->busyRetries);
    }

    function assertFaxResults($faxStatus){
    	$this->assertEquals(1, $faxStatus->FaxMessages[0]->faxResults[0]->attempt);
    	$this->assertEquals("2013-09-03T16:43:49.215+08:00", $faxStatus->FaxMessages[0]->faxResults[0]->scheduledStartTime);

    	$this->assertEquals(1, $faxStatus->FaxMessages[1]->faxResults[0]->attempt);
    	$this->assertEquals("2013-09-03T16:47:36.542+08:00", $faxStatus->FaxMessages[1]->faxResults[0]->scheduledStartTime);
    }

    public function testStopFaxByBroadcastRef() {
	$client = $this->getMockFromWsdl('faxapi-v2.wsdl', 'stopFax');

    	$client->expects($this->any())
    		->method('stopFax')
    		->will($this->returnValue(new MonopondStopFaxResponse(new SimpleXMLElement(
    			"<FaxStatusResponse>
			         <FaxMessages>
				            <FaxMessage status='stopping' sendTo='61280039890' broadcastRef='test-27' sendRef='test-2-1' messageRef='test-2-1-1'/>
				            <FaxMessage status='stopping' sendTo='61280039890' broadcastRef='test-27' sendRef='test-2-1' messageRef='test-2-1-1'/>
         				</FaxMessages>
      			</FaxStatusResponse>"))));

    	$stopFaxRequest = new MonopondStopFaxRequest();
	$stopFaxRequest->BroadcastRef = "test-27";

    	$stopFax = $client->stopFax($stopFaxRequest);
    	$this->assertStopFaxResponse($stopFax);
    }

    public function testStopFaxBySendRef(){
	$client = $this->getMockFromWsdl('faxapi-v2.wsdl', 'stopFax');

    	$client->expects($this->any())
    		->method('stopFax')
    		->will($this->returnValue(new MonopondStopFaxResponse(new SimpleXMLElement(
    			"<FaxStatusResponse>
			         <FaxMessages>
				            <FaxMessage status='stopping' sendTo='61280039890' broadcastRef='test-27' sendRef='test-2-1' messageRef='test-2-1-1'/>
				            <FaxMessage status='stopping' sendTo='61280039890' broadcastRef='test-27' sendRef='test-2-1' messageRef='test-2-1-1'/>
         				</FaxMessages>
      			</FaxStatusResponse>"))));

    	$stopFaxRequest = new MonopondStopFaxRequest();
	$stopFaxRequest->SendRef = "test-2-1";

	$stopFax = $client->stopFax($stopFaxRequest);
	$this->assertStopFaxResponse($stopFax);
    }

        public function testStopFaxByMessageRef(){
	$client = $this->getMockFromWsdl('faxapi-v2.wsdl', 'stopFax');

    	$client->expects($this->any())
    		->method('stopFax')
    		->will($this->returnValue(new MonopondStopFaxResponse(new SimpleXMLElement(
    			"<FaxStatusResponse>
			         <FaxMessages>
				            <FaxMessage status='stopping' sendTo='61280039890' broadcastRef='test-27' sendRef='test-2-1' messageRef='test-2-1-1'/>
				            <FaxMessage status='stopping' sendTo='61280039890' broadcastRef='test-27' sendRef='test-2-1' messageRef='test-2-1-1'/>
         				</FaxMessages>
      			</FaxStatusResponse>"))));

    	$stopFaxRequest = new MonopondStopFaxRequest();
	$stopFaxRequest->MessageRef = "test-2-1-1";

	$stopFax = $client->stopFax($stopFaxRequest);
	$this->assertStopFaxResponse($stopFax);
    }

    function assertStopFaxResponse($stopFax){
    	for ($i=0; $i < 2; $i++) { 
    		$this->assertEquals("stopping", $stopFax->FaxMessages[$i]->status);
		$this->assertEquals("61280039890", $stopFax->FaxMessages[$i]->sendTo);
		$this->assertEquals("test-27", $stopFax->FaxMessages[$i]->broadcastRef);
		$this->assertEquals("test-2-1", $stopFax->FaxMessages[$i]->sendRef);
		$this->assertEquals("test-2-1-1", $stopFax->FaxMessages[$i]->messageRef);
    	}
    }

    public function testPauseFaxByBroadcastRef(){
	$client = $this->getMockFromWsdl('faxapi-v2.wsdl', 'pauseFax');

    	$client->expects($this->any())
    		->method('pauseFax')
    		->will($this->returnValue(new MonopondPauseFaxResponse(new SimpleXMLElement(
    			"<PauseFaxResponse>
			         <FaxMessages>
				            <FaxMessage status='pausing' sendTo='61280039890' broadcastRef='test-27' sendRef='test-2-1' messageRef='test-2-1-1'/>
				            <FaxMessage status='pausing' sendTo='61280039890' broadcastRef='test-27' sendRef='test-2-1' messageRef='test-2-1-1'/>
         				</FaxMessages>
      			</PauseFaxResponse>"))));

    	$pauseFaxRequest = new MonopondPauseFaxRequest();
    	$pauseFaxRequest->BroadcastRef="test-27";

    	$pauseFax = $client->pauseFax($pauseFaxRequest);
    	$this->assertPauseFaxResponse($pauseFax);
    }

    public function testPauseFaxBySendRef(){
	$client = $this->getMockFromWsdl('faxapi-v2.wsdl', 'pauseFax');

    	$client->expects($this->any())
    		->method('pauseFax')
    		->will($this->returnValue(new MonopondPauseFaxResponse(new SimpleXMLElement(
    			"<PauseFaxResponse>
			         <FaxMessages>
				            <FaxMessage status='pausing' sendTo='61280039890' broadcastRef='test-27' sendRef='test-2-1' messageRef='test-2-1-1'/>
				            <FaxMessage status='pausing' sendTo='61280039890' broadcastRef='test-27' sendRef='test-2-1' messageRef='test-2-1-1'/>
         				</FaxMessages>
      			</PauseFaxResponse>"))));

      	$pauseFaxRequest = new MonopondPauseFaxRequest();
    	$pauseFaxRequest->BroadcastRef="test-2-1";

    	$pauseFax = $client->pauseFax($pauseFaxRequest);
    	$this->assertPauseFaxResponse($pauseFax);
    }

    public function testPauseFaxByMessageRef(){
	$client = $this->getMockFromWsdl('faxapi-v2.wsdl', 'pauseFax');

    	$client->expects($this->any())
    		->method('pauseFax')
    		->will($this->returnValue(new MonopondPauseFaxResponse(new SimpleXMLElement(
    			"<PauseFaxResponse>
			         <FaxMessages>
				            <FaxMessage status='pausing' sendTo='61280039890' broadcastRef='test-27' sendRef='test-2-1' messageRef='test-2-1-1'/>
				            <FaxMessage status='pausing' sendTo='61280039890' broadcastRef='test-27' sendRef='test-2-1' messageRef='test-2-1-1'/>
         				</FaxMessages>
      			</PauseFaxResponse>"))));

      	$pauseFaxRequest = new MonopondPauseFaxRequest();
    	$pauseFaxRequest->MessageRef="test-2-1-1";

    	$pauseFax = $client->pauseFax($pauseFaxRequest);
    	$this->assertPauseFaxResponse($pauseFax);
    }

    function assertPauseFaxResponse($pauseFax){
    	for ($i=0; $i < 2; $i++) { 
    		$this->assertEquals("pausing", $pauseFax->FaxMessages[$i]->status);
		$this->assertEquals("61280039890", $pauseFax->FaxMessages[$i]->sendTo);
		$this->assertEquals("test-27", $pauseFax->FaxMessages[$i]->broadcastRef);
		$this->assertEquals("test-2-1", $pauseFax->FaxMessages[$i]->sendRef);
		$this->assertEquals("test-2-1-1", $pauseFax->FaxMessages[$i]->messageRef);
    	}
    }

    public function testResumeFaxByBroadcastRef(){
    	$client = $this->getMockFromWsdl('faxapi-v2.wsdl', 'resumeFax');

    	$client->expects($this->any())
    		->method('resumeFax')
    		->will($this->returnValue(new MonopondResumeFaxResponse(new SimpleXMLElement(
    			"<ResumeFaxResponse>
			         <FaxMessages>
				            <FaxMessage status='starting' sendTo='61280039890' broadcastRef='test-27' sendRef='test-2-1' messageRef='test-2-1-1'/>
				            <FaxMessage status='starting' sendTo='61280039890' broadcastRef='test-27' sendRef='test-2-1' messageRef='test-2-1-1'/>
         				</FaxMessages>
      			</ResumeFaxResponse>"))));

      	$resumeFaxRequest = new MonopondPauseFaxRequest();
    	$resumeFaxRequest->MessageRef="test-27";

    	$resumeFax = $client->resumeFax($resumeFaxRequest);
    	$this->assertResumeFaxResponse($resumeFax);	
    }

        public function testResumeFaxBySendRef(){
    	$client = $this->getMockFromWsdl('faxapi-v2.wsdl', 'resumeFax');

    	$client->expects($this->any())
    		->method('resumeFax')
    		->will($this->returnValue(new MonopondResumeFaxResponse(new SimpleXMLElement(
    			"<ResumeFaxResponse>
			         <FaxMessages>
				            <FaxMessage status='starting' sendTo='61280039890' broadcastRef='test-27' sendRef='test-2-1' messageRef='test-2-1-1'/>
				            <FaxMessage status='starting' sendTo='61280039890' broadcastRef='test-27' sendRef='test-2-1' messageRef='test-2-1-1'/>
         				</FaxMessages>
      			</ResumeFaxResponse>"))));

      	$resumeFaxRequest = new MonopondPauseFaxRequest();
    	$resumeFaxRequest->SendRef="test-2-1";

    	$resumeFax = $client->resumeFax($resumeFaxRequest);
    	$this->assertResumeFaxResponse($resumeFax);	
    }

        public function testResumeFaxByMessageRef(){
    	$client = $this->getMockFromWsdl('faxapi-v2.wsdl', 'resumeFax');

    	$client->expects($this->any())
    		->method('resumeFax')
    		->will($this->returnValue(new MonopondResumeFaxResponse(new SimpleXMLElement(
    			"<ResumeFaxResponse>
			         <FaxMessages>
				            <FaxMessage status='starting' sendTo='61280039890' broadcastRef='test-27' sendRef='test-2-1' messageRef='test-2-1-1'/>
				            <FaxMessage status='starting' sendTo='61280039890' broadcastRef='test-27' sendRef='test-2-1' messageRef='test-2-1-1'/>
         				</FaxMessages>
      			</ResumeFaxResponse>"))));

      	$resumeFaxRequest = new MonopondPauseFaxRequest();
    	$resumeFaxRequest->MessageRef="test-2-1-1";

    	$resumeFax = $client->resumeFax($resumeFaxRequest);
    	$this->assertResumeFaxResponse($resumeFax);	
    }

    function assertResumeFaxResponse($resumeFax){
    	for ($i=0; $i < 2; $i++) { 
    		$this->assertEquals("starting", $resumeFax->FaxMessages[$i]->status);
		$this->assertEquals("61280039890", $resumeFax->FaxMessages[$i]->sendTo);
		$this->assertEquals("test-27", $resumeFax->FaxMessages[$i]->broadcastRef);
		$this->assertEquals("test-2-1", $resumeFax->FaxMessages[$i]->sendRef);
		$this->assertEquals("test-2-1-1", $resumeFax->FaxMessages[$i]->messageRef);
    	}
    }

    public function testSendFaxSendSingleFax(){
    	//needs actual connection
    	//replace with valid username and password
    	$client = new MonopondSOAPClientV2("user", "password", MPENV::Local);
    	$filedata = fread(fopen("./tests/sample.txt", "r"), filesize("./tests/sample.txt"));
    	$filedata = base64_encode($filedata);

    	$document = new MonopondDocument();
    	$document->FileName = "sample.txt";
    	$document->FileData = $filedata;
    	$document->Order = 0;

    	$faxMessage = new MonopondFaxMessage();
    	$faxMessage->MessageRef = "Testing-message-1";
    	$faxMessage->SendTo = "61011111111";
    	$faxMessage->SendFrom = "Test Fax";
    	$faxMessage->Documents = array($document);
    	$faxMessage->Resolution = "normal";
    	$faxMessage->Retries = 0;
    	$faxMessage->BusyRetries = 2;

    	$sendFaxRequest = new MonopondSendFaxRequest();
    	$sendFaxRequest->BroadcastRef = "Broadcast-test-1";
    	$sendFaxRequest->SendRef = "Send-Ref-1";
    	$sendFaxRequest->FaxMessages[] = $faxMessage;

    	$sendRespone = $client->sendFax($sendFaxRequest);
    	// print_r($sendRespone);

    }

    public function testSendFaxMultipleFaxes(){
	//needs actual connection
    	//replace with valid username and password
    	$client = new MonopondSOAPClientV2("user", "password", MPENV::Local);
    	$filedata = fread(fopen("./tests/sample.txt", "r"), filesize("./tests/sample.txt"));
    	$filedata = base64_encode($filedata);

    	$document = new MonopondDocument();
    	$document->FileName = "sample.txt";
    	$document->FileData = $filedata;
    	$document->Order = 0;

    	$document2 = new MonopondDocument();
    	$document2->FileName = "sample.txt";
    	$document2->FileData = $filedata;
    	$document2->Order = 0;
    
    	$document3 = new MonopondDocument();
    	$document3->FileName = "sample.txt";
    	$document3->FileData = $filedata;
    	$document3->Order = 0;

    	$faxMessage = new MonopondFaxMessage();
    	$faxMessage->MessageRef = "Testing-message-1";
    	$faxMessage->SendTo = "61011111111";
    	$faxMessage->SendFrom = "Test Fax";
    	$faxMessage->Documents = array($document);
    	$faxMessage->Resolution = "normal";
    	$faxMessage->Retries = 0;
    	$faxMessage->BusyRetries = 2;

    	$faxMessage2 = new MonopondFaxMessage();
    	$faxMessage2->MessageRef = "Testing-message-2";
    	$faxMessage2->SendTo = "61011111111";
    	$faxMessage2->SendFrom = "Test Fax 2";
    	$faxMessage2->Documents = array($document2, $document3);
    	$faxMessage2->Resolution = "normal";
    	$faxMessage2->Retries = 0;
    	$faxMessage2->BusyRetries = 3;

    	$sendFaxRequest = new MonopondSendFaxRequest();
    	$sendFaxRequest->BroadcastRef = "Broadcast-test-1";
    	$sendFaxRequest->SendRef = "Send-Ref-1";
    	$sendFaxRequest->FaxMessages[] = $faxMessage;
    	$sendFaxRequest->FaxMessages[] = $faxMessage2;

    	$sendRespone = $client->sendFax($sendFaxRequest);
    	// print_r($sendRespone);

    }

    public function testSendFaxSendBroadcast(){
    	//needs actual connection
    	//replace with valid username and password
    	$client = new MonopondSOAPClientV2("user", "password", MPENV::Local);
    	$filedata = fread(fopen("./tests/sample.txt", "r"), filesize("./tests/sample.txt"));
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

    	$faxMessage2 = new MonopondFaxMessage();
    	$faxMessage2->MessageRef = "Testing-message-2";
    	$faxMessage2->SendTo = "61011111111";

    	// TODO: Setup FaxSendRequest 
    	$sendFaxRequest = new MonopondSendFaxRequest();
    	$sendFaxRequest->BroadcastRef = "Broadcast-test-1";
    	$sendFaxRequest->SendRef = "Send-Ref-1";
    	$sendFaxRequest->FaxMessages[] = $faxMessage;
    	$sendFaxRequest->FaxMessages[] = $faxMessage2;
    	$sendFaxRequest->Documents = array($document);
    	$sendFaxRequest->SendFrom = "Test Fax";

    	// Call send fax method
    	$sendRespone = $client->sendFax($sendFaxRequest);
    	// print_r($sendRespone);

    }

}

?>