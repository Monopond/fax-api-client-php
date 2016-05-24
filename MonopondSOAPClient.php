
<?php

class MonopondSOAPClientV2 {
		private $_username;
		private $_password;
		private $_wsdl;
		private $_SoapClient;
		private $_strWSSENS = "http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd";
		
		function __construct($username, $password, $wsdl) {
			// Setup monopond API credentials
			$this->_username=$username;
			$this->_password=$password;
			$this->_wsdl = $wsdl;
			
			// Setting up SOAP ready headers with authentication
			$WSSEAuth = new SoapVar(array('ns1:Username' => $this->_username,'ns1:Password' => $this->_password),
									SOAP_ENC_OBJECT,NULL,$this->_strWSSENS,NULL, $this->_strWSSENS);
			$WSSEToken = new clsWSSEToken($WSSEAuth);
			$SoapVarWSSEToken = new SoapVar($WSSEToken,SOAP_ENC_OBJECT,NULL,$this->_strWSSENS,NULL,$this->_strWSSENS);
			$SoapVarHeaderVal=new SoapVar($SoapVarWSSEToken,SOAP_ENC_OBJECT,NULL,$this->_strWSSENS,NULL,$this->_strWSSENS);
			$SoapHeader = new SoapHeader($this->_strWSSENS,'Security',$SoapVarHeaderVal,true);
			
			// Creating the SOAP client 
			$this->_SoapClient = new SoapClient($this->_wsdl, array("trace" => 1));
			$this->_SoapClient->__setSoapHeaders(array($SoapHeader));
		}
		
		private function convertDocumentArrayToSoapArray($documentArray) {
			// Initialise a blank array
			$soapDocuments = array();
				
			// Setup Documents as SOAP Objects
			foreach($documentArray as $document) {
				// Makes each individual document into a SOAP ready object
				$soapDocuments[] = new SoapVar($document, SOAP_ENC_OBJECT,null,null,"Document");

				if(!empty($document->DocMergeData)) {
					$document->DocMergeData = $this->convertDocMergeDataArrayToSoapArray($document->DocMergeData);
				}
			}

			// Make documents array SOAP ready
			$soapDocuments = new SoapVar($soapDocuments,SOAP_ENC_OBJECT);

			return $soapDocuments;
		}

		private function convertDocMergeDataArrayToSoapArray($docMergeDataArray) {
			$mergeFields = array();

			foreach ($docMergeDataArray as $mergeField) {
				$mergeFields[] = new SoapVar($mergeField, SOAP_ENC_OBJECT, null, null, "MergeFields");
			}

			$mergeFields = new SoapVar($mergeFields, SOAP_ENC_OBJECT);

			return $mergeFields;
		}

		private function removeNullValues($object) {
				foreach($object as $key => $value) {
						if (!isset($value)) {
								unset($object->$key);
						}
				}
				return $object;
		}
		
		public function sendFax($SendFaxRequest) {
			$SendFaxRequest = $this->removeNullValues($SendFaxRequest);        
			
			foreach($SendFaxRequest->FaxMessages as $faxMessage) {
				$faxMessage = $this->removeNullValues($faxMessage);
				// Assign SOAP ready documents array to the fax Message
				if (!empty($faxMessage->Documents)) {
					$faxMessage->Documents = $this->convertDocumentArrayToSoapArray($faxMessage->Documents);    
				}
				
				
				// Add SOAP ready fax message to an array of fax messages
				$soapFaxMessages[] = new SoapVar($faxMessage,SOAP_ENC_OBJECT,null,null,"FaxMessage");
			}
			
			// Make fax messages array SOAP ready
			$soapFaxMessages = new SoapVar($soapFaxMessages,SOAP_ENC_OBJECT);
			
			// Add soap read fax messages to send reaquest
			$SendFaxRequest->FaxMessages = $soapFaxMessages;
			
			// Assign SOAP ready documents array to the send fax request
			if (!empty($SendFaxRequest->Documents)) {
				$SendFaxRequest->Documents = $this->convertDocumentArrayToSoapArray($SendFaxRequest->Documents);    
			}
			
			// Make fax request SOAP ready
			$SendFaxRequest = new SoapVar($SendFaxRequest,SOAP_ENC_OBJECT,NULL,$this->_strWSSENS,NULL,$this->_strWSSENS);

			try{
					// Try to call send fax
					$this->_SoapClient->SendFax($SendFaxRequest);
			}catch (SoapFault $exception) {
					// Print exception if one occured
					print_r($exception->getMessage());
					// Uncomment the line below to print the XML of the request just made  
					//print_r($this->_SoapClient->__getLastRequest());
			}


			// Uncomment the line below to print the XML of the request just made  
			//print_r($this->_SoapClient->__getLastResponse());


			$XMLResponseString = $this->_SoapClient->__getLastResponse();
			$XMLResponseString = str_replace("soap:", "", $XMLResponseString);
			$XMLResponseString = str_replace("ns2:", "", $XMLResponseString);

			$element = new SimpleXMLElement($XMLResponseString);
			
			$messagesResponses = $element->Body->SendFaxResponse->FaxMessages;

			return new MonopondSendFaxResponse($messagesResponses);
		}
		
		public function faxStatus($faxStatusRequest) {
			$faxStatusRequest = $this->removeNullValues($faxStatusRequest);
			$faxStatusRequest = new SoapVar($faxStatusRequest,SOAP_ENC_OBJECT,NULL,$this->_strWSSENS,NULL,$this->_strWSSENS);
			try{
					// Try to call fax status
					$this->_SoapClient->FaxStatus($faxStatusRequest);
			}catch (SoapFault $exception) {
					//echo "exception caught";
					print_r($exception->getMessage());
					//print_r($this->_SoapClient->__getLastResponse());
			}
		   
			$XMLResponseString = $this->_SoapClient->__getLastResponse();
			$XMLResponseString = str_replace("soap:", "", $XMLResponseString);
			$XMLResponseString = str_replace("ns2:", "", $XMLResponseString);
			
			$element = new SimpleXMLElement($XMLResponseString);

			$messagesResponses = $element->Body->FaxStatusResponse;
			return new MonopondFaxStatusResponse($messagesResponses);         
		}

		public function stopFax($stopFaxRequest) {
			$stopFaxRequest = $this->removeNullValues($stopFaxRequest);
			$stopFaxRequest = new SoapVar($stopFaxRequest,SOAP_ENC_OBJECT,NULL,$this->_strWSSENS,NULL,$this->_strWSSENS);
			try{
					// Try to call stop fax
					$this->_SoapClient->StopFax($stopFaxRequest);
			}catch (SoapFault $exception) {
					//echo "exception caught";
					print_r($exception->getMessage());
					//print_r($this->_SoapClient->__getLastResponse());
			}
		   
			$XMLResponseString = $this->_SoapClient->__getLastResponse();
			$XMLResponseString = str_replace("soap:", "", $XMLResponseString);
			$XMLResponseString = str_replace("ns2:", "", $XMLResponseString);

			$element = new SimpleXMLElement($XMLResponseString);

			$messagesResponses = $element->Body->StopFaxResponse;

			return new MonopondStopFaxResponse($messagesResponses);         
		}

		public function pauseFax($pauseFaxRequest) {
			$pauseFaxRequest = $this->removeNullValues($pauseFaxRequest);
			$pauseFaxRequest = new SoapVar($pauseFaxRequest,SOAP_ENC_OBJECT,NULL,$this->_strWSSENS,NULL,$this->_strWSSENS);
			try{
					// Try to call pause fax
					$this->_SoapClient->PauseFax($pauseFaxRequest);
			}catch (SoapFault $exception) {
					//echo "exception caught";
					print_r($exception->getMessage());
					//print_r($this->_SoapClient->__getLastResponse());
			}
		   
			$XMLResponseString = $this->_SoapClient->__getLastResponse();
			$XMLResponseString = str_replace("soap:", "", $XMLResponseString);
			$XMLResponseString = str_replace("ns2:", "", $XMLResponseString);
			
			$element = new SimpleXMLElement($XMLResponseString);


			$messagesResponses = $element->Body->PauseFaxResponse;


			return new MonopondPauseFaxResponse($messagesResponses);         
		}

		public function resumeFax($resumeFaxRequest) {
			$resumeFaxRequest = $this->removeNullValues($resumeFaxRequest);
			$resumeFaxRequest = new SoapVar($resumeFaxRequest,SOAP_ENC_OBJECT,NULL,$this->_strWSSENS,NULL,$this->_strWSSENS);
			
			try{
				// Try to call resume fax
				$this->_SoapClient->ResumeFax($resumeFaxRequest);
			}catch (SoapFault $exception) {
				//echo "exception caught";
				print_r($exception->getMessage());
				//print_r($this->_SoapClient->__getLastResponse());
			}

			$XMLResponseString = $this->_SoapClient->__getLastResponse();
			$XMLResponseString = str_replace("soap:", "", $XMLResponseString);
			$XMLResponseString = str_replace("ns2:", "", $XMLResponseString);

			$element = new SimpleXMLElement($XMLResponseString);

			$messagesResponses = $element->Body->ResumeFaxResponse;

			return new MonopondResumeFaxResponse($messagesResponses);         
		}
	}         

	class MPENV {
		const Production = "https://api.monopond.com/fax/soap/v2.2/?wsdl";
		const Test = "http://test.api.monopond.com/fax/soap/v2.2/?wsdl";
		const Local = "http://localhost:8000/fax/soap/v2.2?wsdl";
	}

	class clsWSSEToken {
		private $UsernameToken;
		
		function __construct ($innerVal) {
		  $this->UsernameToken = $innerVal;
		}
	}

	class MergeField {
	    public $Key;
	    public $Value;
	}

	class MonopondDocument {
		public $FileName;
		public $FileData;
		public $Order;
		public $DocMergeData;
		public $DocumentRef;
	}

	class MonopondFaxMessage {
		public $MessageRef;
		public $SendTo;
		public $SendFrom;
		public $Resolution;
		public $Retries;
		public $BusyRetries;
		public $Documents;
		public $ScheduledStartTime;
		public $HeaderFormat;
		public $CLI;
	}

	class MonopondFaxDetailsResponse {
		public $sendFrom;
		public $resolution;
		public $retries;
		public $busyRetries;
		public $headerFormat;

		function __construct($response) {
			$this->sendFrom = (string)$response["sendFrom"][0];
			$this->resolution = (string)$response["resolution"][0];
			$this->retries = (string)$response["retries"][0];
			$this->busyRetries = (string)$response["busyRetries"][0];
			$this->headerFormat = (string)$response["headerFormat"][0];
		}
	}

	class MonopondFaxResultsResponse {
		public $attempt;
		public $result;
		public $error;
		public $cost;
		public $pages;
		public $scheduledStartTime;
		public $dateCallStarted;
		public $dateCallEnded;

		function __construct($response) {
			$this->attempt = (string)$response["attempt"][0];
			$this->result = (string)$response["result"][0];
			$this->error = new MonopondFaxErrorResponse($response->Error);
			$this->cost = (string)$response["cost"][0];
			$this->pages = (string)$response["pages"][0];
			$this->scheduledStartTime = (string)$response["scheduledStartTime"][0];
			$this->dateCallStarted = (string)$response["dateCallEnded"][0];
		}
	}

	class MonopondFaxErrorResponse {
		public $code;
		public $name;


		function __construct($response) {
			$this->code = (string)$response["code"][0];
			$this->name = (string)$response["name"][0];
		}
	}

	class MonopondFaxMessageResponse {    
		public $status;
		public $sendTo;
		public $broadcastRef;
		public $sendRef;
		public $messageRef;
		public $faxDetails; 
		public $faxResults;
	 
		function __construct($faxMessageResponse) {
			$this->status = (string)$faxMessageResponse["status"][0];
			$this->sendTo = (string)$faxMessageResponse["sendTo"][0];
			$this->broadcastRef = (string)$faxMessageResponse["broadcastRef"][0];
			$this->sendRef = (string)$faxMessageResponse["sendRef"][0];
			$this->messageRef = (string)$faxMessageResponse["messageRef"][0];

			if ($faxMessageResponse->FaxDetails != null) {
			   $this->faxDetails = new MonopondFaxDetailsResponse($faxMessageResponse->FaxDetails);
			}

			if (!empty($faxMessageResponse->FaxResults)) {
			   foreach($faxMessageResponse->FaxResults->FaxResult as $faxResult) {
				$this->faxResults[] = new MonopondFaxResultsResponse($faxResult);
			   }
			}
		}
	}

	/* SendFax */
	class MonopondSendFaxRequest{
		public $BroadcastRef;
		public $SendRef;
		public $FaxMessages;
		public $SendFrom;
		public $Resolution;
		public $Retries;
		public $BusyRetries;
		public $Documents;
		public $ScheduledStartTime;
		public $HeaderFormat;
		public $CLI;
	}

	class MonopondSendFaxResponse{   
		public $FaxMessages;

		function __construct($responses) {
			foreach($responses->FaxMessage as $response) {
				$this->FaxMessages[] = new MonopondFaxMessageResponse($response);
			}   
		}
	}

	/* FaxStatus */
	class MonopondFaxStatusRequest {
		public $BroadcastRef;
		public $SendRef;
		public $MessageRef;
		public $Verbosity = "brief";
	}


	class MonopondFaxStatusResponse {
		public $FaxStatusTotals;
		public $FaxResultsTotals;
		public $FaxMessages;


		function __construct($response) {
			$this->FaxStatusTotals = new MonopondFaxStatusTotalsResponse($response->FaxStatusTotals);
			$this->FaxResultsTotals = new MonopondFaxResultsTotalsResponse($response->FaxResultsTotals);

			if (!empty($response->FaxMessages)) {
			   foreach ($response->FaxMessages->FaxMessage as $faxMessage) {                
				$this->FaxMessages[] =  new MonopondFaxMessageResponse($faxMessage);
			   } 
			}
		}
	}

	class MonopondFaxStatusTotalsResponse {
		public $pending;
		public $processing;
		public $queued;
		public $starting;
		public $sending;
		public $pausing;
		public $paused;
		public $resuming;
		public $stopping;
		public $finalizing;
		public $done;
		
		function __construct($response) {
			$this->pending = (string)$response["pending"][0];
			$this->processing = (string)$response["processing"][0];
			$this->queued = (string)$response["queued"][0];
			$this->starting = (string)$response["starting"][0];
			$this->sending = (string)$response["sending"][0];
			$this->pausing = (string)$response["pausing"][0];
			$this->paused = (string)$response["paused"][0];
			$this->resuming = (string)$response["resuming"][0];
			$this->stopping = (string)$response["stopping"][0];
			$this->finalizing = (string)$response["finalizing"][0];
			$this->done = (string)$response["done"][0];
		}        
	}

	class MonopondFaxResultsTotalsResponse {
		public $success;
		public $blocked;
		public $failed;
		public $totalAttempts;
		public $totalFaxDuration;
		public $totalPages;
		
		function __construct($response) {
			$this->success = (string)$response["success"][0];
			$this->blocked = (string)$response["blocked"][0];
			$this->failed = (string)$response["failed"][0];
			$this->totalAttempts = (string)$response["totalAttempts"][0];
			$this->totalFaxDuration = (string)$response["totalFaxDuration"][0];
			$this->totalPages = (string)$response["totalPages"][0];
		}
	}

	/* StopFax */
	class MonopondStopFaxRequest {
		public $BroadcastRef;
		public $SendRef;
		public $MessageRef;
	}

	class MonopondStopFaxResponse {
		public $FaxMessages;
		
		function __construct($responses) {
			foreach($responses->FaxMessages->FaxMessage as $response) {
				$this->FaxMessages[] = new MonopondFaxMessageResponse($response);
			}   
		}
	}

	/* PauseFax */
	class MonopondPauseFaxRequest {
		public $BroadcastRef;
		public $SendRef;
		public $MessageRef;
	}

	class MonopondPauseFaxResponse {
		public $FaxMessages;
		
		function __construct($responses) {
			foreach($responses->FaxMessages->FaxMessage as $response) {
				$this->FaxMessages[] = new MonopondFaxMessageResponse($response);
			}   
		}
	}

	/* ResumeFax */
	class MonopondResumeFaxRequest {
		public $BroadcastRef;
		public $SendRef;
		public $MessageRef;
	}

	class MonopondResumeFaxResponse {
		public $FaxMessages;
		
		function __construct($responses) {
			foreach($responses->FaxMessages->FaxMessage as $response) {
				$this->FaxMessages[] = new MonopondFaxMessageResponse($response);
			}   
		}
	}
?>