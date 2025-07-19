<?php
$xml = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
               xmlns:xsd="http://www.w3.org/2001/XMLSchema"
               xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <AddEmployee xmlns="http://tempuri.org/">
      <APIKey>11</APIKey>
      <EmployeeCode>1123</EmployeeCode>
      <EmployeeName>Amitkumar</EmployeeName>
      <CardNumber>778956</CardNumber>
      <SerialNumber>BRM9202760325</SerialNumber>
      <UserName>Test</UserName>
      <UserPassword>Test@1234</UserPassword>
      <CommandId></CommandId>
    </AddEmployee>
  </soap:Body>
</soap:Envelope>
XML;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://192.168.1.140/iclock/WebAPIService.asmx");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: text/xml; charset=utf-8",
    "SOAPAction: \"http://tempuri.org/AddEmployee\"",
    "Content-Length: " . strlen($xml),
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
$response = curl_exec($ch);
curl_close($ch);

echo htmlentities($response);
var_dump($response);
?>
