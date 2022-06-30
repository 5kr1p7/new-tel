<?php
namespace Newtel;

class Newtel {
  public $debug = true;
  private $apiUrl = 'https://api.new-tel.net';
  private $keyNewtel;
  private $writeKey;
  
  // ---
  function __construct(string $keyNewtel, string $writeKey) {
    $this->keyNewtel = $keyNewtel;
    $this->writeKey = $writeKey;
  }

  // ---
  private function getToken(string $methodName, string $params): string {
    return $this->keyNewtel . time() . hash('sha256',
                                            $methodName . "\n" .
                                            time() . "\n" .
                                            $this->keyNewtel . "\n" .
                                            $params . "\n" .
                                            $this->writeKey);
  }
  
  // ---
  private function makeRequest(string $method, string $data): string {
    $resId = curl_init();
    $token = $this->getToken($method, $data);

    curl_setopt_array($resId, [
      CURLINFO_HEADER_OUT => true,
      CURLOPT_HEADER => 0,
      CURLOPT_HTTPHEADER => [
                              'Authorization: Bearer '.$token ,
                              'Content-Type: application/json' ,
      ],
      CURLOPT_POST => true,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_URL => $this->apiUrl . '/' . $method,
      CURLOPT_POSTFIELDS => $data,
    ]);

    $response = curl_exec($resId);
    if ($this->debug) { echo $this->prettyPrint($response); }

    return $response;
  }
  
  // ---
  private function prettyPrint(string $response): string {
    return json_encode(json_decode($response), JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
  }
  
  // ---
  public function makeCall(string $phone, int $pin, int $timeout = 20): string {
    $method = 'call-password/start-password-call';
    $data = json_encode([
              'dstNumber' => $phone,
              'pin'       => $pin,
              'timeout'   => $timeout
           ]);

    $response = $this->makeRequest($method, $data);

    return $response;
  }
  
  // ---
  public function getPasswordCallStatus(string $callId): string {
    $method = 'call-password/get-password-call-status';
    $data = json_encode([
              'callId' => $callId,
            ]);
    
    $response = $this->makeRequest($method, $data);
    
    return $response;
  }
  
  // ---
  public function getState(): string {
    $method = 'company/get-state';
    $data = '';
    
    $response = $this->makeRequest($method, $data);

    return $response;
  }

}
