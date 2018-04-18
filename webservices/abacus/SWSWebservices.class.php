<?php
if (!defined('PHP_SWS_PATH')) {
  define('PHP_SWS_PATH', (dirname(__FILE__) . "/"));
}

define('sinstanceurl', "/var/www/html/ctctravel.org/fit/");

require_once(PHP_SWS_PATH.'php_http_client_include.php');
class SWSWebService
{
        var $from="";
        var $conversation_id="";
        var $username="";
        var $password="";
        var $ipcc="";
        var $token="";
        var $error="";
        var $system="https://webservices.sabre.com/websvc";
        var $instanceurl = "/var/www/html/ctctravel.org/fit/";

        function SWSWebService($from,$username,$password,$ipcc,$system)
        {
            if(empty($from))
            {
              $from="awc.abacus.com.sg";
            }
            $this->from=$from;
            $this->password=$password;
            $this->username=$username;
            $this->ipcc=$ipcc;
            $this->conversation_id="".time()."@abacus.com.sg";
            if(!empty($system)) $this->system=$system;
        }

        function SessionCreate()
        {

           $SessionCreateRQ="<SessionCreateRQ><POS><Source PseudoCityCode='{$this->ipcc}' /></POS></SessionCreateRQ>";
           $rs_dom=$this->query("SessionCreateRQ",$SessionCreateRQ,"SabreXML","Session");
           if($rs_dom===false)
           {
             return false;
           }
           $xpath = new DOMXPath($rs_dom);
           $xpath->registerNamespace("SOAP-ENV","http://schemas.xmlsoap.org/soap/envelope/");
           $xpath->registerNamespace("wsse","http://schemas.xmlsoap.org/ws/2002/12/secext");
           $token=$xpath->query("/SOAP-ENV:Envelope/SOAP-ENV:Header/wsse:Security/wsse:BinarySecurityToken");
           if($token->length>0)
           {
              $this->token=$token->item(0)->nodeValue;
           }
           return true;
        }

        function SessionValidate()
        {
            $SessionValidateRQ="<SessionValidateRQ><POS><Source PseudoCityCode='{$this->ipcc}' /></POS></SessionValidateRQ>";
            $rs_dom=$this->query("SessionValidateRQ",$SessionValidateRQ,"SabreXML","Session");
            if($rs_dom)
            {
             return true;
            }
            else
             return false;
        }
        function SessionClose()
        {
            $SessionCloseRQ="<SessionCloseRQ><POS><Source PseudoCityCode='{$this->ipcc}' /></POS></SessionCloseRQ>";
            $rs_dom=$this->query("SessionCloseRQ",$SessionCloseRQ,"SabreXML","Session");
            if($rs_dom)
            {
             return true;
            }
            else
             return false;
        }
        function UTF2HOST($utf)
        {
           $pattern=array("\xE2\x80\xA1","\xE2\x80\xA0","\xE2\x80\xB0");
           $replace=array("&#135;","&#134;","\&#137;");
           return str_replace( $pattern,$replace,$utf);
        }
        function HOST2ENTITIES($host)
        {
           $pattern=array("\xC2\x87","\xC2\x86","\xC2\x89");
           $replace=array("&#8225;","&#8224;","&#8240;");
           return str_replace($pattern,$replace,$host);
        }
        function Execute($action,$payload,$eb_type,$eb_service)
        {
            if($this->token=="" && !$this->SessionCreate())
            {
               return false;
            }
            $rs_dom=$this->query($action,$payload,$eb_type,$eb_service);
            if(!$rs_dom)
            {
               return false;
            }else
            {
               $xpath = new DOMXPath($rs_dom);
               $xpath->registerNamespace("SOAP-ENV","http://schemas.xmlsoap.org/soap/envelope/");
               $body=$xpath->query("/SOAP-ENV:Envelope/SOAP-ENV:Body/*");
               if($body->length>0)
               {
                 $xml=$rs_dom->saveXML($body->item(0));
                 return $xml;
               }else
               {
                  $this->error=$rs_dom->saveXML();
                  return false;
               }
            }
        }

        function query($action,$payload,$eb_type,$eb_service)
        {
            $Security="";
            $payload=$this->UTF2HOST($payload);

            if($action=="SessionCreateRQ")
            {
                $Security="<wsse:UsernameToken>"
               ."<wsse:Username>{$this->username}</wsse:Username>"
               ."<wsse:Password>{$this->password}</wsse:Password>"
               ."<Organization>{$this->ipcc}</Organization>"
               ."<Domain>Default</Domain>"
               ."</wsse:UsernameToken>";
             }else
             {
                $Security="<wsse:BinarySecurityToken>{$this->token}</wsse:BinarySecurityToken>";
             }

             $message_id="mid:".time().$this->from;
             $timestamp=gmdate("Y-m-d\TH-i-s\Z");
             $timetolive=gmdate("Y-m-d\TH-i-s\Z");
             $envelope="<?xml version='1.0' encoding='utf-8'?>\n"
                      ."<soap-env:Envelope xmlns:soap-env='http://schemas.xmlsoap.org/soap/envelope/'>\n"
                      ."<soap-env:Header>\n"
                      ."    <eb:MessageHeader xmlns:eb='http://www.ebxml.org/namespaces/messageHeader'>\n"
                      ."        <eb:From><eb:PartyId eb:type='urn:x12.org.IO5:01'>{$this->from}</eb:PartyId></eb:From>\n"
                      ."        <eb:To><eb:PartyId eb:type='urn:x12.org.IO5:01'>webservices.sabre.com</eb:PartyId></eb:To>\n"
                      ."        <eb:ConversationId>{$this->conversation_id}</eb:ConversationId>\n"
                      ."        <eb:Service eb:type='$eb_type'>$eb_service</eb:Service>\n"
                      ."        <eb:Action>$action</eb:Action>\n"
                      ."        <eb:CPAID>{$this->ipcc}</eb:CPAID>"
                      ."        <eb:MessageData>\n"
                      ."            <eb:MessageId>{$message_id}</eb:MessageId>\n"
                      ."            <eb:Timestamp>{$timestamp}</eb:Timestamp>\n"
                      ."            <eb:TimeToLive>{$timetolive}</eb:TimeToLive>\n"
                      ."        </eb:MessageData>\n"
                      ."    </eb:MessageHeader>\n"
                      ."    <wsse:Security xmlns:wsse='http://schemas.xmlsoap.org/ws/2002/12/secext'>{$Security}</wsse:Security>\n"
                      ."</soap-env:Header>\n"
                      ."<soap-env:Body>$payload</soap-env:Body>\n"
                      ."</soap-env:Envelope>\n";

                           $url_parts=parse_url($this->system);
            $port="80";
            $host=$url_parts['host'];
            $path=$url_parts['path'];

            if(strtolower($url_parts['scheme'])=="https")
            {
                $port=443;
                $host="ssl://$host";
            }
            if(strtolower($url_parts['scheme'])=="http") $port=80;
            if(isset($url_parts['port'])) $port=$url_parts['port'];


            $http_conn=new php_http_client_generic("$host",$path,$port,30);
            $http_conn->setHeader('Content-Type', 'text/xml;charset=utf-8');
            $http_conn->setHeader('Host',"{$url_parts['host']}");
            $http_conn->setHeader('Content-Length', strlen($envelope));

            /*
            $http_conn=new php_http_client_generic("ssl://webservices.sabre.com","/".$this->system,443,30);
            $http_conn->setHeader('Content-Type', 'text/xml;charset=utf-8');
            $http_conn->setHeader('Host',"webservices.sabre.com");
            $http_conn->setHeader('Content-Length', strlen($envelope));
            */

            if(!$http_conn->connect())
            {
               $this->error=$http_conn->connection->errorString;
               return false;
            }
            //echo htmlspecialchars($envelope);
            $response=@$http_conn->send($envelope);
            $http_conn->disconnect();
            if($response->message=="")
            {
              $this->error="Can't Locate this resource--status line={$response->statusLine}";
              return false;
            }

            //file_put_contents ("/www/mambo/test.xml",$response->message);
            //$rs_dom = DOMDocument::loadXML($response->message);

            $rs_dom = new DOMDocument();
            $rs_dom->loadXML($response->message, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);

            /* $rs_dom = DOMDocument::loadXML($response->message); */

            if(!$rs_dom || $rs_dom->documentElement->localName!="Envelope")
            {
              $this->error=$response->message;
              return false;
            }

            $xpath = new DOMXPath($rs_dom);
            $xpath->registerNamespace("soap-env","http://schemas.xmlsoap.org/soap/envelope/");
            $childs_of_faults=$xpath->query("/soap-env:Envelope/soap-env:Body/soap-env:Fault");
            if($childs_of_faults->length>0)
            {
             /*
             foreach($childs_of_faults as $child)
             {
               $this->error.=$child->localName."=".$child->nodeValue;
             }
             */
             $this->error=$rs_dom->saveXML();
             return false;
            }else
            {
              return $rs_dom;
            }
            return false;
     }
}

function testFd()
{

        $service = new SWSWebService("ihsan.tay@ctc.com.sg","8888","CTC78866","8HYD","https://webservices.sabre.com/websvc");
        if($service->SessionCreate())
        {
            if($service->SessionValidate())
            {
                $EnhancedAirBookRQ = '
                <EnhancedAirBookRQ HaltOnError="true" version="3.7.0" xmlns="http://services.sabre.com/sp/eab/v3_7">
                  <OTA_AirBookRQ>
                    <HaltOnStatus Code="NO"/>
                    <HaltOnStatus Code="NN"/>
                    <HaltOnStatus Code="UC"/>
                    <HaltOnStatus Code="US"/>
                    <HaltOnStatus Code="UN"/>
                    <HaltOnStatus Code="LL"/>
                    <HaltOnStatus Code="HL"/>
                    <HaltOnStatus Code="WL"/>
                    <OriginDestinationInformation>
                      <FlightSegment DepartureDateTime="2018-04-11T20:15:00" ArrivalDateTime="2018-03-31T14:20:00" FlightNumber="962" NumberInParty="2" ResBookDesigCode="T" Status="NN">
                          <DestinationLocation LocationCode="USM"/>
                          <Equipment AirEquipType="319"/>
                          <MarketingAirline Code="PG" FlightNumber="962"/>
                          <MarriageGrp>O</MarriageGrp>
                          <OperatingAirline Code="PG"></OperatingAirline>
                          <OriginLocation LocationCode="SIN"></OriginLocation>
                      </FlightSegment>
                      <FlightSegment DepartureDateTime="2018-03-31T16:55:00" ArrivalDateTime="2018-03-31T18:30:00" FlightNumber="104" NumberInParty="2" ResBookDesigCode="T" Status="NN">
                          <DestinationLocation LocationCode="BKK"/>
                          <Equipment AirEquipType="319"/>
                          <MarketingAirline Code="PG" FlightNumber="104"/>
                          <MarriageGrp>O</MarriageGrp>
                          <OperatingAirline Code="PG"></OperatingAirline>
                          <OriginLocation LocationCode="USM"></OriginLocation>
                      </FlightSegment>
                    </OriginDestinationInformation>
                    <RedisplayReservation NumAttempts="3" WaitInterval="5000" />
                   </OTA_AirBookRQ>
                   <OTA_AirPriceRQ>
                      <PriceRequestInformation Retain="true">
                         <OptionalQualifiers>
                            <PricingQualifiers>
                               <PassengerType Code="ADT" Quantity="1"/>
                               <PassengerType Code="CNN" Quantity="1"/>
                            </PricingQualifiers>
                         </OptionalQualifiers>
                      </PriceRequestInformation>
                   </OTA_AirPriceRQ>
                  <PostProcessing IgnoreAfter="false">
                      <RedisplayReservation WaitInterval="1000"/>
                   </PostProcessing>
                  <PreProcessing IgnoreBefore="false"/>
                </EnhancedAirBookRQ>';

                /*echo '<xmp>'.$EnhancedAirBookRQ.'</xmp>';*/
                /*die();*/
                $xml = $service->Execute("EnhancedAirBookRQ",$EnhancedAirBookRQ,'OTA', 'Air');
//echo htmlspecialchars($service->error);
                $xml = true;
                if ( $xml ) {
                  /*echo 'ad';
                  $parseResult = simplexml_load_string($xml);
                  $arrayFinal  = json_decode(json_encode($parseResult), true);
                  $countArrayFinal = count($arrayFinal);
                  echo '<pre>';var_dump($parseResult);echo '</pre>';*/

                  //EndTransaction Ind=false to return no PNR
                  $PDBookRQ = '<PassengerDetailsRQ xmlns="http://services.sabre.com/sp/pd/v3_3" version="3.3.0" IgnoreOnError="false" HaltOnError="true" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
                      <PostProcessing IgnoreAfter="false" RedisplayReservation="true" UnmaskCreditCard="true">
                          <EndTransactionRQ>
                              <EndTransaction Ind="true" />
                              <Source ReceivedFrom="CTC TRAVEL"/>
                          </EndTransactionRQ>
                       </PostProcessing>
                      <PreProcessing IgnoreBefore="false">
                          <UniqueID ID="" />
                      </PreProcessing>
                      <PriceQuoteInfo>
                          <Link NameNumber="1.1" Record="1"/>
                          <Link NameNumber="2.1" Record="2"/>
                      </PriceQuoteInfo>
                      <SpecialReqDetails>
                          <SpecialServiceRQ>
                            <SpecialServiceInfo>
                              <AdvancePassenger SegmentNumber="A">
                                <Document ExpirationDate="2022-07-15" Number="e12345678j" Type="P">
                                    <IssueCountry>SG</IssueCountry>
                                    <NationalityCountry>SG</NationalityCountry>
                                </Document>
                                <PersonName DateOfBirth="1990-10-23" Gender="M" NameNumber="1.1" DocumentHolder="true">
                                  <GivenName>MINSHENGMR</GivenName><Surname>TAN</Surname>
                                </PersonName>
                              </AdvancePassenger>

                              <AdvancePassenger SegmentNumber="A">
                                <Document ExpirationDate="2022-07-14" Number="e74651728j" Type="P">
                                    <IssueCountry>SG</IssueCountry>
                                    <NationalityCountry>SG</NationalityCountry>
                                </Document>
                                <PersonName DateOfBirth="2014-10-21" Gender="M" NameNumber="2.1">
                                    <GivenName>CHENGPOHMSTR</GivenName><Surname>TAN</Surname>
                                </PersonName>
                              </AdvancePassenger>

                              <SecureFlight SegmentNumber="A">
                                <PersonName DateOfBirth="1990-10-23" Gender="M" NameNumber="1.1">
                                  <GivenName>MINSHENGMR</GivenName>
                                  <Surname>TAN</Surname>
                                </PersonName>
                                <VendorPrefs>
                                  <Airline Hosted="false"/>
                                </VendorPrefs>
                              </SecureFlight>

                              <SecureFlight SegmentNumber="A">
                                  <PersonName DateOfBirth="2014-10-21" Gender="M" NameNumber="2.1">
                                      <GivenName>CHENGPOHMSTR</GivenName>
                                      <Surname>TAN</Surname>
                                  </PersonName>
                                  <VendorPrefs>
                                    <Airline Hosted="false"/>
                                  </VendorPrefs>
                              </SecureFlight>
                              <Service SSR_Code="OSI">
                                  <PersonName NameNumber="1.1"/>
                                  <Text>PASSENGER NAME SHOULD BE TAN/MINSHENG MR</Text>
                                  <VendorPrefs>
                                      <Airline Code="PG" Hosted="false"/></VendorPrefs>
                              </Service>
                              <Service SegmentNumber="A" SSR_Code="CHLD">
                                <PersonName NameNumber="2.1"/>
                                <Text>21OCT14</Text>
                                <VendorPrefs>
                                  <Airline Hosted="false" />
                                </VendorPrefs>
                              </Service>
                          </SpecialServiceInfo>
                        </SpecialServiceRQ>
                      </SpecialReqDetails>
                      <TravelItineraryAddInfoRQ xmlns="http://services.sabre.com/sp/pd/v3_3">
                          <AgencyInfo>
                                <Address>
                                  <AddressLine>SABRE TRAVEL</AddressLine>
                                  <CityName>SOUTHLAKE</CityName>
                                  <CountryCode>US</CountryCode>
                                  <PostalCode>76092</PostalCode>
                                  <StateCountyProv StateCode="TX"/>
                                  <StreetNmbr>3150 SABRE DRIVE</StreetNmbr>
                              </Address>
                              <Ticketing TicketType="7TAW"/>
                          </AgencyInfo>
                          <CustomerInfo>
                            <ContactNumbers>
                              <ContactNumber NameNumber="1.1" Phone="9487-12345" PhoneUseType="H"/>
                            </ContactNumbers>
                            <Email Address="beto.thamrin@gmail.com" NameNumber="1.1" ShortText="CTC Ticket" Type="BC"/>
                            <PersonName Infant="false" NameNumber="1.1" PassengerType="ADT">
                                <GivenName>MINSHENGMR</GivenName>
                                <Surname>TAN</Surname>
                            </PersonName>
                            <PersonName Infant="false" NameNumber="2.1" PassengerType="CNN" NameReference="C05">
                                <GivenName>CHENGPOHMSTR</GivenName>
                                <Surname>TAN</Surname>
                            </PersonName>
                        </CustomerInfo>
                      </TravelItineraryAddInfoRQ>
                  </PassengerDetailsRQ>';
                     /* end PD true */
                    /*echo '<xmp>'.$PDBookRQ.'</xmp>';*/

                      $xml = $service->Execute("PassengerDetailsRQ",$PDBookRQ, 'OTA', 'Air');
                      if( $xml ) {
                        echo $xml;
                        $parseResult = simplexml_load_string($xml);
                        $arrayFinal  = json_decode(json_encode($parseResult), true);
                        echo '<pre>';
                        var_dump($parseResult);
                        var_dump($arrayFinal);
                        echo '</pre>';
                        die();
                    } else {

                      echo htmlspecialchars($service->error);
                      die();
                    }
                }
                else {
                    $txt  = "[".date("Y-m-d H:i:s")."] [Multi-PD][PD-2]". htmlspecialchars($service->error);

                    //log file
                    $myfile = fopen(sinstanceurl. "assets/api-logs/logs.txt", "a") or die("Unable to open file!");
                    // $txt  = "[".date("Y-m-d H:i:s")."] - ".$output;
                    fwrite($myfile, "\n". $txt);
                    fclose($myfile);
                    return 'error';
               }
            }
           }
    }
function saberCommand1()
{
  $service = new SWSWebService("ihsan.tay@ctc.com.sg","8888","CTC78866","8HYD","https://webservices.sabre.com/websvc");
  if($service->SessionCreate())
  {
      if($service->SessionValidate())
      {
        $SabreCommandLLSRQ = '
             <SabreCommandLLSRQ xmlns="http://webservices.sabre.com/sabreXML/2003/07" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" TimeStamp="2014-03-04T14:00:00" Version="1.8.1">

              <Request Output="SCREEN" CDATA="true">
                <HostCommand>*A</HostCommand>
              </Request>
            </SabreCommandLLSRQ>';
        $xml = $service->Execute("SabreCommandLLSRQ",$SabreCommandLLSRQ, 'OTA', 'Air');
        if( $xml ) {
          echo $xml;
            $parseResult = simplexml_load_string($xml);
            $arrayFinal  = json_decode(json_encode($parseResult), true);
            echo '<pre>';
            var_dump($parseResult);
            var_dump($arrayFinal);
            //return $arrayFinal['ItineraryRef']['@attributes']['ID'] ? $arrayFinal['ItineraryRef']['@attributes']['ID'] : '';
        } else {
            echo '1 - '.htmlspecialchars($service->error);
        }
      }
      else {
          echo '3 - '.htmlspecialchars($service->error);
      }
  }
  else {
      echo '4 - '.htmlspecialchars($service->error);
  }
}

function saberCommand2()
{
  $service = new SWSWebService("ihsan.tay@ctc.com.sg","8888","CTC78866","8HYD","https://webservices.sabre.com/websvc");
  if($service->SessionCreate())
  {
      if($service->SessionValidate())
      {
        $SabreCommandLLSRQ = '
            <SabreCommandLLSRQ xmlns="http://webservices.sabre.com/sabreXML/2003/07" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" TimeStamp="2014-03-04T14:00:00" Version="1.8.1">
              <Request Output="SCREEN" CDATA="true">
                <HostCommand>*P3</HostCommand>
              </Request>
            </SabreCommandLLSRQ>';
        $xml = $service->Execute("SabreCommandLLSRQ",$SabreCommandLLSRQ, 'OTA', 'Air');
        if( $xml ) {
          echo $xml;
            $parseResult = simplexml_load_string($xml);
            $arrayFinal  = json_decode(json_encode($parseResult), true);
            echo '<pre>';
            var_dump($parseResult);
            var_dump($arrayFinal);
            //return $arrayFinal['ItineraryRef']['@attributes']['ID'] ? $arrayFinal['ItineraryRef']['@attributes']['ID'] : '';
        } else {
            echo '1 - '.htmlspecialchars($service->error);
        }
      }
      else {
          echo '3 - '.htmlspecialchars($service->error);
      }
  }
  else {
      echo '4 - '.htmlspecialchars($service->error);
  }
}

function saberCommand3()
{
  $service = new SWSWebService("ihsan.tay@ctc.com.sg","8888","CTC78866","8HYD","https://webservices.sabre.com/websvc");
  if($service->SessionCreate())
  {
      if($service->SessionValidate())
      {
        $SabreCommandLLSRQ = '
           <SabreCommandLLSRQ xmlns="http://webservices.sabre.com/sabreXML/2003/07" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" TimeStamp="2014-03-04T14:00:00" Version="1.8.1">
              <Request Output="SCREEN" CDATA="true">
                <HostCommand>*P3D</HostCommand>
              </Request>
            </SabreCommandLLSRQ>';
        $xml = $service->Execute("SabreCommandLLSRQ",$SabreCommandLLSRQ, 'OTA', 'Air');
        if( $xml ) {
          echo $xml;
            $parseResult = simplexml_load_string($xml);
            $arrayFinal  = json_decode(json_encode($parseResult), true);
            echo '<pre>';
            var_dump($parseResult);
            var_dump($arrayFinal);
            //return $arrayFinal['ItineraryRef']['@attributes']['ID'] ? $arrayFinal['ItineraryRef']['@attributes']['ID'] : '';
        } else {
            echo '1 - '.htmlspecialchars($service->error);
        }
      }
      else {
          echo '3 - '.htmlspecialchars($service->error);
      }
  }
  else {
      echo '4 - '.htmlspecialchars($service->error);
  }
}

function readPassengerData()
{
  $service = new SWSWebService("ihsan.tay@ctc.com.sg","8888","CTC78866","8HYD","https://webservices.sabre.com/websvc");
  if($service->SessionCreate())
  {
      if($service->SessionValidate())
      {
      $PDDetailRQ = '
            <GetPassengerDataRQ validateCheckInRequirements="true" version="4.0.1">
             <ItineraryAndPassengerInfo>
                <Itinerary>
                <Airline>TR</Airline>
                <Flight>904</Flight>
                <DepartureDate>2018-04-24</DepartureDate>
                <Origin>SIN</Origin>
             </Itinerary>
                <PassengerList>
                   <Passenger>
                        <LastName>LOH</LastName>
                   </Passenger>
                </PassengerList>
             </ItineraryAndPassengerInfo>
          </GetPassengerDataRQ>';
      $xml = $service->Execute("GetPassengerDataRQ",$PDDetailRQ, 'OTA', 'Air');
      if( $xml ) {
          $parseResult = simplexml_load_string($xml);
          $arrayFinal  = json_decode(json_encode($parseResult), true);
          echo '<pre>';
          var_dump($parseResult);
          var_dump($arrayFinal);
          //return $arrayFinal['ItineraryRef']['@attributes']['ID'] ? $arrayFinal['ItineraryRef']['@attributes']['ID'] : '';
      } else {
          echo '1 - '.htmlspecialchars($service->error);
      }
    }
    else {
        echo '3 - '.htmlspecialchars($service->error);
    }
  }
  else {
      echo '4 - '.htmlspecialchars($service->error);
  }
}

function readTripData()
{
  $service = new SWSWebService("ihsan.tay@ctc.com.sg","8888","CTC78866","8HYD","https://webservices.sabre.com/websvc");
  if($service->SessionCreate())
  {
      if($service->SessionValidate())
      {
      $PDDetailRQ = '
            <Trip_SearchRQ Version="4.3.0" xmlns:ns2="http://webservices.sabre.com/sabreXML/2003/07" xmlns="http://webservices.sabre.com/triprecord">
<ReadRequests>
<ReservationReadRequest>
     <LocatorCriteria>
     <Locator Id="RYDBTI"/><!-- in this case TTY is not required, but can be still present -->
     </LocatorCriteria>
     <NameCriteria>
          <Name>
              <LastName MatchMode="SIMILAR">LOH</LastName>
          </Name>
      </NameCriteria>
     <PosCriteria AirlineCode="AA"/>
     <ReturnOptions ViewName="Default"
     MaxItemsReturned="500" ResponseFormat="STL"/>
</ReservationReadRequest>
</ReadRequests>
</Trip_SearchRQ>';
      $xml = $service->Execute("Trip_SearchRQ",$PDDetailRQ, 'OTA', 'Air');
      if( $xml ) {
          $parseResult = simplexml_load_string($xml);
          $arrayFinal  = json_decode(json_encode($parseResult), true);
          echo '<pre>';
          var_dump($parseResult);
          var_dump($arrayFinal);
          //return $arrayFinal['ItineraryRef']['@attributes']['ID'] ? $arrayFinal['ItineraryRef']['@attributes']['ID'] : '';
      } else {
          echo '1 - '.htmlspecialchars($service->error);
      }
    }
    else {
        echo '3 - '.htmlspecialchars($service->error);
    }
  }
  else {
      echo '4 - '.htmlspecialchars($service->error);
  }
}

function updatePassengerData()
{
  $service = new SWSWebService("ihsan.tay@ctc.com.sg","8888","CTC78866","8HYD","https://webservices.sabre.com/websvc");
  if($service->SessionCreate())
  {
    if($service->SessionValidate())
    {
    $EnhancedAirBookRQ = '
        <PassengerDetailsRQ xmlns="http://services.sabre.com/sp/pd/v3_3" version="3.3.0" IgnoreOnError="false" HaltOnError="false" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
            <PostProcessing IgnoreAfter="false" RedisplayReservation="true" UnmaskCreditCard="true" xmlns="http://services.sabre.com/sp/pd/v3_3">
                <EndTransactionRQ>
                    <EndTransaction Ind="true" />
                    <Source ReceivedFrom="CTC Test TRAVEL"/>
                </EndTransactionRQ>
             </PostProcessing>
            <PreProcessing xmlns="http://services.sabre.com/sp/pd/v3_3" IgnoreBefore="false">
                <UniqueID ID="" />
            </PreProcessing>
            '.$priceQuote.'
            <SpecialReqDetails>
                <SpecialServiceRQ>
                    <SpecialServiceInfo>
                        '.$APIs.'
                    </SpecialServiceInfo>
                </SpecialServiceRQ>
            </SpecialReqDetails>

            <TravelItineraryAddInfoRQ xmlns="http://services.sabre.com/sp/pd/v3_3">
                <AgencyInfo>
                    <Ticketing TicketType="'.$agencyTicketType.'"/>
                </AgencyInfo>
                <CustomerInfo>
                '.$customerContactNumberInfo.'
                '.$emailContact.'
                '.$customerContactNameInfo.'
                </CustomerInfo>
            </TravelItineraryAddInfoRQ>
        </PassengerDetailsRQ>';
    $xml = $service->Execute("PassengerDetailsRQ",$EnhancedAirBookRQ, 'OTA', 'Air');
    if( $xml ) {
        $parseResult = simplexml_load_string($xml);
        $arrayFinal  = json_decode(json_encode($parseResult), true);

        return $arrayFinal['ItineraryRef']['@attributes']['ID'] ? $arrayFinal['ItineraryRef']['@attributes']['ID'] : '';
    } else {
        echo '1 - '.htmlspecialchars($service->error);
    }
  }
    else {
        echo '3 - '.htmlspecialchars($service->error);
    }
  }
  else {
      echo '4 - '.htmlspecialchars($service->error);
  }
}
/* new 24 mei 2017 air rules */
function checkrules($departureDate, $destinationCode, $MarketingCarrier, $originCode, $fareBasisCode)
{
    error_reporting(E_ERROR );
    $service = new SWSWebService("ihsan.tay@ctc.com.sg","8888","CTC78866","8HYD","https://webservices.sabre.com/websvc");
    if($service->SessionCreate())
    {
        if($service->SessionValidate())
        {
            $fbcstring = '<FareBasis  Code="'.$fareBasisCode.'"/>';

            $AvailBookString = '<OTA_AirRulesRQ xmlns="http://webservices.sabre.com/sabreXML/2011/10" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ReturnHostCommand="true" Version="2.2.1">
                <OriginDestinationInformation>
                    <FlightSegment DepartureDateTime="'.$departureDate.'">
                        <DestinationLocation LocationCode="'.$destinationCode.'"/>
                        <MarketingCarrier Code="'.$MarketingCarrier.'"/>
                        <OriginLocation LocationCode="'.$originCode.'"/>
                    </FlightSegment>
                </OriginDestinationInformation>
                <RuleReqInfo>
                '.$fbcstring.'
                </RuleReqInfo>
                </OTA_AirRulesRQ>';
            $xml = $service->Execute("OTA_AirRulesLLSRQ",$AvailBookString, 'OTA', 'Air');

            if( $xml ) {
                /*$parseResult = simplexml_load_string($xml);
                $arrayFinal  = json_decode(json_encode($parseResult), true);
                var_dump($arrayFinal);
                die();*/
                /*$idx = 1;
                echo '<pre>';
echo 'asdasdasdasdsadsadassa';
var_dump($arrayFinal);*/

                /*foreach($arrayFinal['FareRuleInfo']['Rules']['Paragraph'] as $ruleParagraph) {
                    echo '<h4>'. $idx.'. '.$ruleParagraph['@attributes']['Title'].'</h4>';
                    echo '<p>'.$ruleParagraph['Text'].'</p><br>';
                    $idx++;
                }
                die();*/

                return $xml;
            } else {
                echo htmlspecialchars($service->error);
            }
        }
    } else {
        echo htmlspecialchars($service->error);
    }
}

function checkAirAvailability($flightCode, $flightNumber, $departureDate, $departureTime, $numberInParty, $ResBookDesigCode, $destinationCode, $originCode)
{
    error_reporting(E_ERROR );
    $service = new SWSWebService("ihsan.tay@ctc.com.sg","8888","CTC78866","8HYD","https://webservices.sabre.com/websvc");
    if($service->SessionCreate())
    {
        if($service->SessionValidate())
        {
            $AvailBookString = '<OTA_AirAvailRQ xmlns="http://webservices.sabre.com/sabreXML/2011/10" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" Version="2.4.0">
                    <OptionalQualifiers>
                        <FlightQualifiers DirectOnly="true" Scan="true">
                            <VendorPrefs>
                                <Airline Code="'.$flightCode.'"/>
                            </VendorPrefs>
                        </FlightQualifiers>
                    </OptionalQualifiers>
                    <OriginDestinationInformation>
                        <FlightSegment DepartureDateTime="'.$departureDate.'T'.$departureTime.'" NumberInParty="'.$numberInParty.'" ResBookDesigCode="'.$ResBookDesigCode.'">
                            <DestinationLocation LocationCode="'.$destinationCode.'"/>
                            <OriginLocation LocationCode="'.$originCode.'"/>
                        </FlightSegment>
                    </OriginDestinationInformation>
                </OTA_AirAvailRQ>';
            $xml = $service->Execute("OTA_AirAvailLLSRQ",$AvailBookString, 'OTA', 'Air');
            if( $xml ) {
                return $xml;
            } else {
                echo htmlspecialchars($service->error);
            }
        }
    } else {
        echo htmlspecialchars($service->error);
    }
}

/* UNUSED */
function checkAirAvailabilityTransit($flightCode, $flightName, $departureDate, $departureTime, $arrivalDate, $arrivalTime, $numberInParty, $ResBookDesigCode, $destinationCode, $originCode)
{
    error_reporting(E_ERROR );
    $service = new SWSWebService("ihsan.tay@ctc.com.sg","8888","CTC78866","8HYD","https://webservices.sabre.com/websvc");
    if($service->SessionCreate())
    {
        if($service->SessionValidate())
        {
            $arrDepartureFlightName         = explode("~", $flightName);
            $arrDepartureFlightCode         = explode("~", $flightCode);
            /*$arrDepartureTimeTaken        = explode("~", $arrayCart[$x]["departureTimeTaken"]);
            $arrDepartureBaggage            = explode("~", $arrayCart[$x]["departureBaggage"]);
            $arrDepartureMeal               = explode("~", $arrayCart[$x]["departureMeal"]);*/
            $arrDepartureDateFrom           = explode("~", $departureDate);
            $arrDepartureTimeFrom           = explode("~", $departureTime);
            $arrArrivalDateFrom             = explode("~", $arrivalDate);
            $arrArrivalTimeFrom             = explode("~", $arrivalTime);
            //$arrResBookDesigCode = explode("~", $arrayCart[$x]['flightClass']);
            $arrDestinationCode = explode("~", $destinationCode);
            $arrOriginCode = explode("~", $originCode);

            $explodeCount = count($arrDepartureFlightCode);

            $flightConn = '';
            for ($xe=0; $xe < $explodeCount; $xe++) {
                $flightCodeNumArray = explode(" ", $arrDepartureFlightCode[$xe]);

                /* check availability */
                if($xe == 0) {
                    $flightCode = $flightCodeNumArray[0];
                    $flightNumber = $flightCodeNumArray[1];

                    $departureDate = $arrDepartureDateFrom[$xe];
                    $departureTime = date("H:i", strtotime($arrDepartureTimeFrom[0]));
                    $departureTimeAfter = date("H:i", strtotime($arrDepartureTimeFrom[0]));
                    $departureTimeBefore = date("H:i", strtotime($arrArrivalTimeFrom[0]));
                    $originCode = $arrOriginCode[$xe];
                    $flightConn .= '<ConnectionLocation LocationCode="'.$arrDestinationCode[$xe].'"/>';
                }
                else if($xe == ($explodeCount -1)) {
                    $arrivalTimeAfter = date("H:i", strtotime($arrArrivalTimeFrom[$xe]));
                    $arrivalTimeBefore = date("H:i", strtotime($arrArrivalTimeFrom[$xe]));
                    $destinationCode = $arrDestinationCode[$xe];
                } else {
                    $flightConn .= '<ConnectionLocation LocationCode="'.$arrDestinationCode[$xe].'"/>';
                }
            }

            $flightSegment .= '<FlightSegment DepartureDateTime="'.$departureDate.'T'.$departureTime.'" NumberInParty="'.$numberInParty.'" ResBookDesigCode="'.$ResBookDesigCode.'">
                                <ConnectionLocations>
                                    '.$flightConn.'
                                </ConnectionLocations>
                                <DestinationLocation LocationCode="'.$destinationCode.'"/>
                                <OriginLocation LocationCode="'.$originCode.'"/>
                            </FlightSegment>';

            $AvailBookString = '<OTA_AirAvailRQ xmlns="http://webservices.sabre.com/sabreXML/2011/10" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" Version="2.4.0">
                            <OptionalQualifiers>
                                <FlightQualifiers>
                                    <VendorPrefs>
                                        <Airline Code="'.$flightCode.'"/>
                                    </VendorPrefs>
                                </FlightQualifiers>
                            </OptionalQualifiers>
                            <OriginDestinationInformation>

                            '.$flightSegment.'
                            </OriginDestinationInformation>
                        </OTA_AirAvailRQ>';
            $xml = $service->Execute("OTA_AirAvailLLSRQ",$AvailBookString, 'OTA', 'Air');
            //$xml = $service->Execute("OTA_AirAvailLLSRQ", $AvailBookString, 'OTA', 'Air');
            if( $xml ) {
                return $xml;
            } else {
                echo htmlspecialchars($service->error);
            }
        }
    } else {
        echo htmlspecialchars($service->error);
    }
}

function checkAirAvailabilityPrice ($flightCode, $flightNumber, $departureDate, $departureTime, $arrivalDate, $arrivalTime, $numberInParty, $ResBookDesigCode, $destinationCode, $originCode, $marriageGroup, $adultNo, $childNo, $infantNo,
    $arrivalFlightCode = "", $arrivalDepartureDate = "", $arrivalDepartureTime = "", $arrivalResBookDesigCode = "",
    $arrivalDestinationCode = "", $arrivalOriginCode = "", $arrivalMarriageGroup = ""
    )
{
    error_reporting(E_ERROR );
    $childExist        = "";
    $infantExist       = "";
    if( $childNo != 0 ) {
        $childExist = '<PassengerType Code="CNN" Quantity="'.$childNo.'" />';
    }
    if( $infantNo != 0 )
    {
        /* INF = infant without seat
        INS = infant with seat*/
        $infantExist = '<PassengerType Code="INF" Quantity="'.$infantNo.'" />';
    }
    $flightSegmentString = "";
    $seatRequested = $adultNo+$childNo;//+$infantNo;
    $service = new SWSWebService("ihsan.tay@ctc.com.sg","8888","CTC78866","8HYD","https://webservices.sabre.com/websvc");
    if($service->SessionCreate())
    {
       if($service->SessionValidate())
       {
        $flightSegmentString .= '<FlightSegment DepartureDateTime="'.$departureDate.'T'.$departureTime.'" FlightNumber="'.$flightNumber.'" NumberInParty="'.$numberInParty.'" ResBookDesigCode="'.$ResBookDesigCode.'" Status="NN">
                            <DestinationLocation LocationCode="'.$destinationCode.'" />
                            <MarketingAirline Code="'.$flightCode.'" FlightNumber="'.$flightNumber.'" />
                            <MarriageGrp>'.$marriageGroup.'</MarriageGrp>
                            <OperatingAirline Code="'.$flightCode.'" />
                            <OriginLocation LocationCode="'.$originCode.'"/>
                        </FlightSegment>';

            if ($arrivalFlightCode != "") {
                $flightCodeNumArray = explode(" ", $arrivalFlightCode);

                $flightSegmentString .= '<FlightSegment DepartureDateTime="'.$arrivalDepartureDate.'T'.$arrivalDepartureTime.'" FlightNumber="'.$flightCodeNumArray[1].'" NumberInParty="'.$numberInParty.'" ResBookDesigCode="'.$arrivalResBookDesigCode.'" Status="NN">
                            <DestinationLocation LocationCode="'.$arrivalDestinationCode.'" />
                            <MarketingAirline Code="'.$flightCodeNumArray[0].'" FlightNumber="'.$flightCodeNumArray[1].'" />
                            <MarriageGrp>'.$arrivalMarriageGroup.'</MarriageGrp>
                            <OperatingAirline Code="'.$flightCodeNumArray[0].'" />
                            <OriginLocation LocationCode="'.$arrivalOriginCode.'"/>
                        </FlightSegment>';
            }

            $OTA_AirLowFareSearchRQ='
                <EnhancedAirBookRQ xmlns="http://services.sabre.com/sp/eab/v3_7" version="3.7.0" HaltOnError="true">
                    <OTA_AirBookRQ>
                        <HaltOnStatus Code="NO"/>
                        <HaltOnStatus Code="NN"/>
                        <HaltOnStatus Code="UC"/>
                        <HaltOnStatus Code="US"/>
                        <HaltOnStatus Code="UN"/>
                        <HaltOnStatus Code="LL"/>
                        <HaltOnStatus Code="HL"/>
                        <HaltOnStatus Code="WL"/>
                        <OriginDestinationInformation>
                        '.$flightSegmentString.'
                        </OriginDestinationInformation>
                        <RedisplayReservation NumAttempts="3" WaitInterval="5000" />
                     </OTA_AirBookRQ>
                 <OTA_AirPriceRQ>
                    <PriceRequestInformation Retain="true">
                        <OptionalQualifiers>
                            <FlightQualifiers>
                                <VendorPrefs>
                                    <Airline Code="'.$flightCode.'"/>
                                </VendorPrefs>
                            </FlightQualifiers>
                            <PricingQualifiers>

                                <PassengerType Code="ADT" Quantity="'.$adultNo.'" />
                                '.$childExist.$infantExist.'
                            </PricingQualifiers>
                        </OptionalQualifiers>
                    </PriceRequestInformation>
                 </OTA_AirPriceRQ>
                <PostProcessing IgnoreAfter="true" xmlns="http://services.sabre.com/sp/eab/v3_7">
                    <RedisplayReservation WaitInterval="5000" UnmaskCreditCard="false"/>
                 </PostProcessing>
                <PreProcessing xmlns="http://services.sabre.com/sp/eab/v3_7" IgnoreBefore="true"/>
              </EnhancedAirBookRQ>';
              /*
                                */
            $xml = $service->Execute("EnhancedAirBookRQ",$OTA_AirLowFareSearchRQ,"OTA","Air");
            if( $xml ) {
                //$abc = htmlspecialchars($xml);
                //$result_test = XMLtoArray($xml);
                return $xml;
            }
            else {
                echo  htmlspecialchars($service->error);
            }
        }
        else {
            echo htmlspecialchars($service->error);
       }
    }
    else {
        echo htmlspecialchars($service->error);
    }
}

function checkAirAvailabilityPriceTransit ($flightCode, $departureDate, $departureTime, $arrivalDate, $arrivalTime, $numberInParty, $ResBookDesigCode, $destinationCode, $originCode, $marriageGroup, $adultNo, $childNo, $infantNo,
    $arrivalFlightCodeString = "", $arrivalDateFromString = "", $arrivalTimeFromString = "", $arrivalCityCodeFromString = "", $arrivalCityCodeToString = "", $arrivalFlightresBookDesigCodeString = "", $arrivalFlightAirEquipTypeString = "", $arrivalFlightMarriageGrpString = ""
    )
{
    error_reporting(E_ERROR );
    $childExist        = "";
    $infantExist       = "";
    if( $childNo != 0 ) {
        $childExist = '<PassengerType Code="CNN" Quantity="'.$childNo.'" />';
    }
    if( $infantNo != 0 )
    {
        /* INF = infant without seat
        INS = infant with seat*/
        $infantExist = '<PassengerType Code="INF" Quantity="'.$infantNo.'" />';
    }
    $seatRequested = $adultNo+$childNo;//+$infantNo;
    $service = new SWSWebService("ihsan.tay@ctc.com.sg","8888","CTC78866","8HYD","https://webservices.sabre.com/websvc");
    if($service->SessionCreate())
    {
       if($service->SessionValidate())
       {
            $flightSegmentString = "";
            /* make a flight segment for departure */
            $DepFlightCodeArray = explode("~", $flightCode);
            $DepflightNameArray = explode("~", $flightName);
            $flightCode = $flightCodeNumArray[0];
            $flightNumber = $flightCodeNumArray[1];
            $DepResBookDesigCode = explode("~", $ResBookDesigCode);
            $DepDateFromArray = explode("~", $departureDate);
            $DepTimeFromArray = explode("~", $departureTime);
            $DepCityCodeToArray = explode("~", $destinationCode);
            $DepFlightMarriageGrpArray = explode("~", $marriageGroup);
            $DepCityCodeFromArray = explode("~", $originCode);

            $totalCountFlight = count($DepFlightCodeArray);
            $prefVendor = "";
            for($idxSeg = 0; $idxSeg < $totalCountFlight; $idxSeg++) {
                $flightNumArr = explode(" ", $DepFlightCodeArray[$idxSeg]);
                $prefVendor = $flightNumArr[0]; //should be same for every flight
                $flightSegmentString .= '
                        <FlightSegment DepartureDateTime="'.$DepDateFromArray[$idxSeg].'T'.$DepTimeFromArray[$idxSeg].'" FlightNumber="'.$flightNumArr[1].'" NumberInParty="'.$numberInParty.'" ResBookDesigCode="'.$DepResBookDesigCode[$idxSeg].'" Status="NN">
                            <DestinationLocation LocationCode="'.$DepCityCodeToArray[$idxSeg].'" />
                            <MarketingAirline Code="'.$flightNumArr[0].'" FlightNumber="'.$flightNumArr[1].'" />
                            <MarriageGrp>'.$DepFlightMarriageGrpArray[$idxSeg].'</MarriageGrp>
                            <OperatingAirline Code="'.$flightNumArr[0].'" />
                            <OriginLocation LocationCode="'.$DepCityCodeFromArray[$idxSeg].'"/>
                        </FlightSegment>';
            }

            /* arrival part */
            if ($arrivalFlightCodeString != "") {
                $ArvFlightCodeArray = explode("~", $arrivalFlightCodeString);
            }

            if (count($ArvFlightCodeArray) > 1) {
                $ArvDateFromArray = explode("~", $arrivalDateFromString);
                $ArvTimeFromArray = explode("~", $arrivalTimeFromString);
                $ArvCityCodeFromArray = explode("~", $arrivalCityCodeFromString);
                $ArvCityCodeToArray = explode("~", $arrivalCityCodeToString);
                $ArvFlightCode = array();
                $ArvFlightNo = array();
                for ($idxCode = 0; $idxCode < count($ArvFlightCodeArray); $idxCode++)
                {
                    $codeExplodeArr = explode(" ", $ArvFlightCodeArray[$idxCode]);
                    $ArvFlightCode[$idxCode] = $codeExplodeArr[0];
                    $ArvFlightNo[$idxCode] = $codeExplodeArr[1];
                }
                $ArvFlightrResBookDesigCodeArray = explode("~", $arrivalFlightresBookDesigCodeString);
                $ArvFlightAirEquipTypeArray = explode("~", $arrivalFlightAirEquipTypeString);
                $ArvFlightMarriageGrpArray = explode("~", $arrivalFlightMarriageGrpString);
            }

            /* next, is to, make a flight segment for arrival */
            if(count($ArvFlightCodeArray) > 1) {
                for($idxSeg = 0; $idxSeg < count($ArvFlightCodeArray); $idxSeg++) {
                    $flightSegmentString .= '
                            <FlightSegment DepartureDateTime="'.$ArvDateFromArray[$idxSeg].'T'.$ArvTimeFromArray[$idxSeg].'" FlightNumber="'.$ArvFlightNo[$idxSeg].'" NumberInParty="'.$numberInParty.'" ResBookDesigCode="'.$ArvFlightrResBookDesigCodeArray[$idxSeg].'" Status="NN">
                                <DestinationLocation LocationCode="'.$ArvCityCodeToArray[$idxSeg].'" />
                                <MarketingAirline Code="'.$ArvFlightCode[$idxSeg].'" FlightNumber="'.$ArvFlightNo[$idxSeg].'" />
                                <MarriageGrp>'.$ArvFlightMarriageGrpArray[$idxSeg].'</MarriageGrp>
                                <OperatingAirline Code="'.$ArvFlightCode[$idxSeg].'" />
                                <OriginLocation LocationCode="'.$ArvCityCodeFromArray[$idxSeg].'"/>
                            </FlightSegment>';
                }
            }

            $OTA_AirLowFareSearchRQ='
                <EnhancedAirBookRQ xmlns="http://services.sabre.com/sp/eab/v3_7" version="3.7.0" HaltOnError="true">
                    <OTA_AirBookRQ>
                        <HaltOnStatus Code="NO"/>
                        <HaltOnStatus Code="NN"/>
                        <HaltOnStatus Code="UC"/>
                        <HaltOnStatus Code="US"/>
                        <HaltOnStatus Code="UN"/>
                        <HaltOnStatus Code="LL"/>
                        <HaltOnStatus Code="HL"/>
                        <HaltOnStatus Code="WL"/>
                        <OriginDestinationInformation>
                        '.$flightSegmentString.'
                        </OriginDestinationInformation>
                        <RedisplayReservation NumAttempts="3" WaitInterval="5000" />
                     </OTA_AirBookRQ>
                 <OTA_AirPriceRQ>
                    <PriceRequestInformation Retain="true">
                        <OptionalQualifiers>
                            <FlightQualifiers>
                                <VendorPrefs>
                                    <Airline Code="'.$prefVendor.'"/>
                                </VendorPrefs>
                            </FlightQualifiers>
                            <PricingQualifiers>
                                <BargainFinder/>
                                <PassengerType Code="ADT" Quantity="'.$adultNo.'" />
                                '.$childExist.$infantExist.'
                            </PricingQualifiers>
                        </OptionalQualifiers>
                    </PriceRequestInformation>
                 </OTA_AirPriceRQ>
                <PostProcessing IgnoreAfter="true" xmlns="http://services.sabre.com/sp/eab/v3_7">
                    <RedisplayReservation WaitInterval="5000" UnmaskCreditCard="false"/>
                 </PostProcessing>
                <PreProcessing xmlns="http://services.sabre.com/sp/eab/v3_7" IgnoreBefore="true"/>
              </EnhancedAirBookRQ>';

            $xml = $service->Execute("EnhancedAirBookRQ",$OTA_AirLowFareSearchRQ,"OTA","Air");
            if( $xml ) {
                //$abc = htmlspecialchars($xml);
                //$result_test = XMLtoArray($xml);
                return $xml;
            }
            else {
                echo  htmlspecialchars($service->error);
            }
        }
        else {
            echo htmlspecialchars($service->error);
       }
    }
    else {
        echo htmlspecialchars($service->error);
    }
}

function book_flight_segmentSINGLE($dateFrom, $timeFrom, $destinationLocationCode, $flightCode, $flightNo, $originLocationCode, $totalAdult, $totalChild, $totalInfant, $marriageGroup, $flightClass, $passengerDetails, $contactPerson_email, $contactPerson_phone)
{
    //header("Content-type: text/xml");
    $departureDateTime = $dateFrom."T".$timeFrom;
    $numberInParty     = $totalAdult+$totalChild;//+$totalInfant;
    $childExist        = "";
    $infantExist       = "";
    if( $totalChild != 0 ) {
        $childExist = '<PassengerType Code="CNN" Quantity="'.$totalChild.'" />';
    }
    if( $totalInfant != 0 )
    {
        /* INF = infant without seat
        INS = infant with seat*/
        $infantExist = '<PassengerType Code="INF" Quantity="'.$totalInfant.'" />';
    }
    $service = new SWSWebService("ihsan.tay@ctc.com.sg","8888","CTC78866","8HYD","https://webservices.sabre.com/websvc");
    if($service->SessionCreate())
    {
        if($service->SessionValidate())
        {
            $EnhancedAirBookRQ = '
                    <EnhancedAirBookRQ HaltOnError="true" version="3.7.0" xmlns="http://services.sabre.com/sp/eab/v3_7">
                         <OTA_AirBookRQ>
                            <HaltOnStatus Code="NO"/>
                            <HaltOnStatus Code="NN"/>
                            <HaltOnStatus Code="UC"/>
                            <HaltOnStatus Code="US"/>
                            <HaltOnStatus Code="UN"/>
                            <HaltOnStatus Code="LL"/>
                            <HaltOnStatus Code="HL"/>
                            <HaltOnStatus Code="WL"/>
                             <OriginDestinationInformation>
                                <FlightSegment DepartureDateTime="'.$dateFrom.'T'.$timeFrom.'" FlightNumber="'.$flightNo.'" NumberInParty="'.$numberInParty.'" ResBookDesigCode="'.$flightClass.'" Status="NN">
                                    <DestinationLocation LocationCode="'.$destinationLocationCode.'" />
                                    <MarketingAirline Code="'.$flightCode.'" FlightNumber="'.$flightNo.'" />
                                    <MarriageGrp>'.$marriageGroup.'</MarriageGrp>
                                    <OperatingAirline Code="'.$flightCode.'" />
                                    <OriginLocation LocationCode="'.$originLocationCode.'"/>
                                </FlightSegment>
                            </OriginDestinationInformation>
                            <RedisplayReservation NumAttempts="3" WaitInterval="5000" />
                         </OTA_AirBookRQ>
                         <OTA_AirPriceRQ>
                            <PriceRequestInformation Retain="true">
                               <OptionalQualifiers>
                                  <PricingQualifiers>
                                     <PassengerType Code="ADT" Quantity="'.$totalAdult.'" />'
                                     .$childExist.$infantExist.'
                                  </PricingQualifiers>
                               </OptionalQualifiers>
                            </PriceRequestInformation>
                         </OTA_AirPriceRQ>
                        <PostProcessing IgnoreAfter="false" xmlns="http://services.sabre.com/sp/eab/v3_7">
                            <RedisplayReservation/>
                         </PostProcessing>
                        <PreProcessing xmlns="http://services.sabre.com/sp/eab/v3_7" />
                      </EnhancedAirBookRQ>';
            $xml = $service->Execute("EnhancedAirBookRQ",$EnhancedAirBookRQ,'OTA', 'Air');
                if( $xml ) {
                    $parseResult = simplexml_load_string($xml);
                    $arrayFinal  = json_decode(json_encode($parseResult), true);
                    $countArrayFinal = count($arrayFinal);
            /*      echo '<h5>EnhancedAirBookRS</h5>';
                    echo "<pre>";
                    print_r($arrayFinal);
                    echo "</pre>";*/

                    /* get passenger detail */
                    $priceQuote = "";
                    $customerContactNumberInfo = '';
                    $customerContactNameInfo = '';
                    $APIs = ""; //advance passenger informations

                    if( $passengerDetails == TRUE ) {
                        $counter_number = 1;
                        $priceQuote = "<PriceQuoteInfo>";
                        $customerContactNumberInfo = '<ContactNumbers>';
                        $emailContact = '';

                        foreach( $passengerDetails AS $passenger ) {
                            $priceQuote .= '<Link NameNumber="'.$counter_number.'.1" Record="'.$counter_number.'" />';
                            $ptype = 'ADT';
                            $isInfant = '';
                            $isInfant = ' Infant="false"';
                            $nameRef = '';
                            $dob = $passenger->passengerDOB;
                            switch($passenger->passengerType) {
                                case 'ADULT' :
                                        $ptype = 'ADT';
                                    break;
                                case 'CHILD' :
                                    $birthdate = new DateTime($passenger->passengerDOB);
                                    $today   = new DateTime('today');
                                    $age = $birthdate->diff($today)->y;
                                    $age = $age < 10 ? '0'.$age : $age;
                                    //$ptype = 'C'.$age;
                                    $ptype = 'CNN';
                                    $nameRef = ' NameReference="C04"';
                                    break;
                                case 'INFANT' : $ptype = 'INF'; // INS
                                    $dob = '2017-01-01';
                                    $isInfant = ' Infant="true"';
                                    $nameRef = ' NameReference="I01"';
                                    break;
                                case 'STUDENT' :
                                    break;
                                case 'AGENT' :
                                    break;
                                case 'TOURS' :
                                    break;
                                case 'MILITARY' :
                                    break;
                                    default : break;

                            }

                            /* "PhoneUseType" is used to specify if the number is agency, "A," home, "H," business, "B," or fax, "F." */
                            $customerContactNumberInfo .= '<ContactNumber NameNumber="'.$counter_number.'.1" Phone="1234567890" PhoneUseType="H" />';//$contactPerson_phone
                            $emailContact .= '<Email Address="'.$contactPerson_email.'" NameNumber="'.$counter_number.'.1" ShortText="CTC Ticket" Type="BC"/>';

                            $passName = $passenger->passengerName;
                            $passNameArr = explode (" ", $passName);
                            $givenName = array_pop($passNameArr);
                            if (count($passNameArr) == 0) {
                                $surname = $givenName;
                            } else {
                                $surname = implode (" ", $passNameArr);
                            }

                            if($isInfant == 'true') {
                                $givenName = 'INF';$surname ='INFA';
                            }
                            $customerContactNameInfo .= '
                                    <PersonName'.$isInfant.' NameNumber="'.$counter_number.'.1" PassengerType="'.$ptype.'" '.$nameRef.'>
                                        <GivenName>'.$givenName.'</GivenName>
                                        <Surname>'.$surname.'</Surname>
                                    </PersonName>
                                    ';

                            $nationalitycountryCode = "";
                            $passissuecountryCode = "";
                            $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
                            //query mysql
                            $queryRes = mysqli_query(
                                $connection,
                                "
                                    SELECT * FROM country WHERE country_name = '".$passenger->passengerPassportIssueCountry."' LIMIT 0,1
                                "
                            );
                            if( mysqli_num_rows($queryRes) > 0 ) {
                                $queryRow = mysqli_fetch_array($queryRes, MYSQL_ASSOC);
                                $issuecountryCode = $queryRow["country_code"];
                            }

                            //query mysql
                            $queryRes = mysqli_query(
                                $connection,
                                "
                                    SELECT * FROM country WHERE country_name = '".$passenger->passengerNationality."' LIMIT 0,1
                                "
                            );
                            if( mysqli_num_rows($queryRes) > 0 ) {
                                $queryRow = mysqli_fetch_array($queryRes, MYSQL_ASSOC);
                                $passcountryCode =  $queryRow["country_code"];
                            }

                            $gender = strtolower($passenger->passengerTitle) == 'mr' || strtolower($passenger->passengerTitle) == 'master' ? 'M' : 'F';
                            if($isInfant) {
                                $gender = strtolower($passenger->passengerTitle) == 'mr' || strtolower($passenger->passengerTitle) == 'master' ? 'MI' : 'FI';
                            }
                           $APIs .= '<AdvancePassenger  SegmentNumber="A">
                                <Document ExpirationDate="'.$passenger->passengerPassportExpiryDate.'" Number="'.$passenger->passengerPassportNo.'" Type="P">
                                    <IssueCountry>'.$issuecountryCode.'</IssueCountry>
                                    <NationalityCountry>'.$passcountryCode.'</NationalityCountry>
                                </Document>
                                <PersonName DateOfBirth="'.$dob.'" Gender="'.$gender.'" NameNumber="'.$counter_number.'.1" '. (($passenger->passengerType == 'ADULT' && $counter_number == 1) ? 'DocumentHolder="true"' : '').'>
                                    <GivenName>'.strtoupper($passenger->passengerTitle).' '.$givenName.'</GivenName>
                                    <Surname>'.$surname.'</Surname>
                                </PersonName>
                            </AdvancePassenger >';
                            /*$APIs .= '<SecureFlight SegmentNumber="A" >
                                <PersonName DateOfBirth="'.$dob.'" Gender="'.$gender.'" NameNumber="'.$counter_number.'.1">
                                    <GivenName>'.$givenName.'</GivenName>
                                    <Surname>'.$surname.'</Surname>
                                </PersonName>
                                <VendorPrefs>
                                <Airline Hosted="true"></VendorPrefs>
                            </SecureFlight>';
*/
                            $counter_number++;
                        }
                        $priceQuote .= "</PriceQuoteInfo>";
                        $customerContactNumberInfo .= '</ContactNumbers>';
                    }

                    if($totalChild > 0) {
                        $APIs .= '<Service SegmentNumber="A" SSR_Code="CHLD" >
                                        <PersonName NameNumber="2" />
                                        <Text>01JAN12</Text>
                                    </Service>';
                    }
                    if($totalInfant > 0) {
                        $APIs .= '<Service SegmentNumber="A"  SSR_Code="INFT">
                                    <PersonName NameNumber="1" ></PersonName>
                                    <Text>3INFT/infantiot/infantiot/01JAN17</Text>
                                </Service>';//dob
                    }

                    $agencyTicketType = "7TAW"; // ticket at will;

                    $EnhancedAirBookRQ = '
                        <PassengerDetailsRQ xmlns="http://services.sabre.com/sp/pd/v3_3" version="3.3.0" IgnoreOnError="false" HaltOnError="false" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
                            <PostProcessing IgnoreAfter="false" RedisplayReservation="true" UnmaskCreditCard="true" xmlns="http://services.sabre.com/sp/pd/v3_3">
                                <EndTransactionRQ>
                                    <EndTransaction Ind="true" />
                                    <Source ReceivedFrom="CTC Test TRAVEL"/>
                                </EndTransactionRQ>
                             </PostProcessing>
                            <PreProcessing xmlns="http://services.sabre.com/sp/pd/v3_3" IgnoreBefore="false">
                                <UniqueID ID="" />
                            </PreProcessing>
                            '.$priceQuote.'
                            <SpecialReqDetails>
                                <SpecialServiceRQ>
                                    <SpecialServiceInfo>
                                        '.$APIs.'

                                    </SpecialServiceInfo>
                                </SpecialServiceRQ>
                            </SpecialReqDetails>

                            <TravelItineraryAddInfoRQ xmlns="http://services.sabre.com/sp/pd/v3_3">
                                <AgencyInfo>
                                    <Ticketing TicketType="'.$agencyTicketType.'"/>
                                </AgencyInfo>
                                <CustomerInfo>
                                '.$customerContactNumberInfo.'
                                '.$emailContact.'
                                '.$customerContactNameInfo.'
                                </CustomerInfo>
                            </TravelItineraryAddInfoRQ>
                        </PassengerDetailsRQ>';

                        $testEnch = '<PassengerDetailsRQ xmlns="http://services.sabre.com/sp/pd/v3_3" version="3.3.0" IgnoreOnError="false" HaltOnError="false" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
                            <PostProcessing IgnoreAfter="false" RedisplayReservation="true" UnmaskCreditCard="true" xmlns="http://services.sabre.com/sp/pd/v3_3">
                                <EndTransactionRQ>
                                    <EndTransaction Ind="true" />
                                    <Source ReceivedFrom="CTC Test TRAVEL"/>
                                </EndTransactionRQ>
                             </PostProcessing>
                            <PreProcessing xmlns="http://services.sabre.com/sp/pd/v3_3" IgnoreBefore="false">
                                <UniqueID ID="" />
                            </PreProcessing>
                            <PriceQuoteInfo>
                                <Link NameNumber="1" Record="1" />
                                <Link NameNumber="2" Record="2" />
                                <Link NameNumber="3" Record="3" />
                            </PriceQuoteInfo>
                            <SpecialReqDetails>
                                <SpecialServiceRQ>
                                    <SpecialServiceInfo>
                                        <AdvancePassenger SegmentNumber="A">
                                            <Document ExpirationDate="2022-02-01" Number="123451123" Type="P">
                                                <IssueCountry>SG</IssueCountry>
                                                <NationalityCountry>SG</NationalityCountry>
                                            </Document>
                                            <PersonName DateOfBirth="1988-01-01" Gender="MI" NameNumber="1" DocumentHolder="true">
                                                <GivenName>asdasda</GivenName>
                                                <Surname>asdasda</Surname>
                                            </PersonName>
                                        </AdvancePassenger>
                                        <AdvancePassenger SegmentNumber="A">
                                            <Document ExpirationDate="2022-01-01" Number="12211231" Type="P">
                                                <IssueCountry>SG</IssueCountry>
                                                <NationalityCountry>SG</NationalityCountry>
                                            </Document>
                                            <PersonName DateOfBirth="2012-01-01" Gender="M" NameNumber="2" >
                                                <GivenName>child</GivenName>
                                                <Surname>childiot</Surname>
                                            </PersonName>
                                        </AdvancePassenger>
                                        <AdvancePassenger SegmentNumber="A">
                                            <PersonName DateOfBirth="2017-01-01" Gender="FI" NameNumber="3" >
                                                <GivenName>test</GivenName>
                                                <Surname>infantiot</Surname>
                                            </PersonName>
                                        </AdvancePassenger>
                                        <Service SegmentNumber="A" SSR_Code="CHLD" >
                                            <PersonName NameNumber="2" />
                                            <Text>01JAN12</Text>
                                        </Service>
                                        <Service SegmentNumber="A" SSR_Code="INFT">
                                            <PersonName NameNumber="1"></PersonName>
                                            <Text>infantiot/test/01JAN17</Text>
                                        </Service>
                                    </SpecialServiceInfo>
                                </SpecialServiceRQ>
                            </SpecialReqDetails>

                            <TravelItineraryAddInfoRQ xmlns="http://services.sabre.com/sp/pd/v3_3">
                                <AgencyInfo>
                                    <Ticketing TicketType="7TAW"/>
                                </AgencyInfo>
                                <CustomerInfo>
                                <ContactNumbers>
                                    <ContactNumber NameNumber="1.1" Phone="012-555-1212" PhoneUseType="H" />
                                </ContactNumbers>
                                <Email Address="alberto@iotstream.io" NameNumber="1" ShortText="CTC Ticket" Type="BC"/>

                                    <PersonName Infant="false" NameNumber="1" PassengerType="ADT" >
                                        <GivenName>asdasda</GivenName>
                                        <Surname>asdasda</Surname>
                                    </PersonName>

                                    <PersonName Infant="false" NameNumber="2" PassengerType="CNN"  NameReference="C05">
                                        <GivenName>child</GivenName>
                                        <Surname>childiot</Surname>
                                    </PersonName>

                                    <PersonName Infant="true" NameNumber="3" PassengerType="INF"  NameReference="I01">
                                        <GivenName>test</GivenName>
                                        <Surname>infantiot</Surname>
                                    </PersonName>

                                </CustomerInfo>
                            </TravelItineraryAddInfoRQ>
                        </PassengerDetailsRQ>';
                        echo '<xmp>'.$testEnch.'</xmp>';
                    $xml = $service->Execute("PassengerDetailsRQ",$testEnch, 'OTA', 'Air');

                    if( $xml ) {
                        $parseResult = simplexml_load_string($xml);
                        $arrayFinal  = json_decode(json_encode($parseResult), true);
                        return $arrayFinal['ItineraryRef']['@attributes']['ID'] ? $arrayFinal['ItineraryRef']['@attributes']['ID'] : '';
                    } else {
                        echo '1 - '.htmlspecialchars($service->error);
                    }
                }
                else {
                    echo '2 - '.htmlspecialchars($service->error);
               }
        }
        else {
            echo '3 - '.htmlspecialchars($service->error);
        }
    }
    else {
        echo '4 - '.htmlspecialchars($service->error);
    }
}

function XMLtoArray($XML)
{
    $xml_parser = xml_parser_create();
    xml_parse_into_struct($xml_parser, $XML, $vals);
    xml_parser_free($xml_parser);
    // wyznaczamy tablice z powtarzajacymi sie tagami na tym samym poziomie
    $_tmp='';
    foreach ($vals as $xml_elem) {
        $x_tag=$xml_elem['tag'];
        $x_level=$xml_elem['level'];
        $x_type=$xml_elem['type'];
        if ($x_level!=1 && $x_type == 'close') {
            if (isset($multi_key[$x_tag][$x_level]))
                $multi_key[$x_tag][$x_level]=1;
            else
                $multi_key[$x_tag][$x_level]=0;
        }
        if ($x_level!=1 && $x_type == 'complete') {
            if ($_tmp==$x_tag)
                $multi_key[$x_tag][$x_level]=1;
            $_tmp=$x_tag;
        }
    }
    // jedziemy po tablicy
    foreach ($vals as $xml_elem) {
        $x_tag=$xml_elem['tag'];
        $x_level=$xml_elem['level'];
        $x_type=$xml_elem['type'];
        if ($x_type == 'open')
            $level[$x_level] = $x_tag;
        $start_level = 1;
        $php_stmt = '$xml_array';
        if ($x_type=='close' && $x_level!=1)
            $multi_key[$x_tag][$x_level]++;
        while ($start_level < $x_level) {
            $php_stmt .= '[$level['.$start_level.']]';
            if (isset($multi_key[$level[$start_level]][$start_level]) && $multi_key[$level[$start_level]][$start_level])
                $php_stmt .= '['.($multi_key[$level[$start_level]][$start_level]-1).']';
            $start_level++;
        }
        $add='';
        if (isset($multi_key[$x_tag][$x_level]) && $multi_key[$x_tag][$x_level] && ($x_type=='open' || $x_type=='complete')) {
            if (!isset($multi_key2[$x_tag][$x_level]))
                $multi_key2[$x_tag][$x_level]=0;
            else
                $multi_key2[$x_tag][$x_level]++;
            $add='['.$multi_key2[$x_tag][$x_level].']';
        }
        if (isset($xml_elem['value']) && trim($xml_elem['value'])!='' && !array_key_exists('attributes', $xml_elem)) {
            if ($x_type == 'open')
                $php_stmt_main=$php_stmt.'[$x_type]'.$add.'[\'content\'] = $xml_elem[\'value\'];';
            else
                $php_stmt_main=$php_stmt.'[$x_tag]'.$add.' = $xml_elem[\'value\'];';
            eval($php_stmt_main);
        }
        if (array_key_exists('attributes', $xml_elem)) {
            if (isset($xml_elem['value'])) {
                $php_stmt_main=$php_stmt.'[$x_tag]'.$add.'[\'content\'] = $xml_elem[\'value\'];';
                eval($php_stmt_main);
            }
            foreach ($xml_elem['attributes'] as $key=>$value) {
                $php_stmt_att=$php_stmt.'[$x_tag]'.$add.'[$key] = $value;';
                eval($php_stmt_att);
            }
        }
    }
    return $xml_array;
}

function getCurrencyRate()
{
    $service = new SWSWebService("ihsan.tay@ctc.com.sg","8888","CTC78866","8HYD","https://webservices.sabre.com/websvc");
    if($service->SessionCreate())
    {
       if($service->SessionValidate())
       {
           $DisplayCurrencyRQ=<<<EOT
                <DisplayCurrencyRQ xmlns="http://webservices.sabre.com/sabreXML/2011/10" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ReturnHostCommand="false" TimeStamp="2012-01-12T11:00:00-06:00" Version="2.1.0">
                    <CountryCode>US</CountryCode>
                    <CurrencyCode>CUR</CurrencyCode>
                </DisplayCurrencyRQ>
EOT;
            $xml = $service->Execute("DisplayCurrencyLLSRQ",$DisplayCurrencyRQ,"OTA","Air");
            if( $xml ) {
                //$abc = htmlspecialchars($xml);
                //$result_test = XMLtoArray($xml);
                return $xml;
            }
            else {
                echo  htmlspecialchars($service->error);
            }
        }
        else {
            echo htmlspecialchars($service->error);
       }
    }
    else {
        echo htmlspecialchars($service->error);
    }
}

function book_flight_segment()
{
    //header("Content-type: text/xml");
    $service = new SWSWebService("ihsan.tay@ctc.com.sg","8888","CTC78866","8HYD","https://webservices.sabre.com/websvc");
    if($service->SessionCreate())
    {
       if($service->SessionValidate())
       {
           $EnhancedAirBookRQ=<<<EOT
            <EnhancedAirBookRQ HaltOnError="true" version="3.7.0" xmlns="http://services.sabre.com/sp/eab/v3_7">
                 <OTA_AirBookRQ>
                    <HaltOnStatus Code="NO"/>
                    <HaltOnStatus Code="NN"/>
                    <HaltOnStatus Code="UC"/>
                    <HaltOnStatus Code="US"/>
                    <HaltOnStatus Code="UN"/>
                    <HaltOnStatus Code="LL"/>
                    <HaltOnStatus Code="HL"/>
                    <HaltOnStatus Code="WL"/>
                    <OriginDestinationInformation>
                       <FlightSegment DepartureDateTime="2017-01-20T18:50:00" FlightNumber="108" NumberInParty="1" ResBookDesigCode="L" Status="NN">
                          <DestinationLocation LocationCode="NRT"/>
                          <MarketingAirline Code="OZ" FlightNumber="108"/>
                          <MarriageGrp>O</MarriageGrp>
                          <OriginLocation LocationCode="ICN"/>
                       </FlightSegment>
                       <FlightSegment DepartureDateTime="2017-01-25T13:30:00" FlightNumber="103" NumberInParty="1" ResBookDesigCode="L" Status="NN">
                          <DestinationLocation LocationCode="ICN"/>
                          <MarketingAirline Code="OZ" FlightNumber="103"/>
                          <MarriageGrp>O</MarriageGrp>
                          <OriginLocation LocationCode="NRT"/>
                       </FlightSegment>
                    </OriginDestinationInformation>
                    <RedisplayReservation NumAttempts="3" WaitInterval="5000"/>
                 </OTA_AirBookRQ>
                 <OTA_AirPriceRQ>
                    <PriceRequestInformation Retain="true">
                       <OptionalQualifiers>
                          <PricingQualifiers>
                             <PassengerType Code="ADT" Quantity="1"/>
                          </PricingQualifiers>
                       </OptionalQualifiers>
                    </PriceRequestInformation>
                 </OTA_AirPriceRQ>
                 <PostProcessing IgnoreAfter="false">
                    <RedisplayReservation WaitInterval="5000"/>
                 </PostProcessing>
              </EnhancedAirBookRQ>
EOT;
           /*
            $EnhancedAirBookRQ=<<<EOT
                <EnhancedAirBookRQ version="3.7.0" HaltOnError="true">
                    <OTA_AirBookRQ>
                        <OriginDestinationInformation>
                            <FlightSegment DepartureDateTime="2016-12-21T11:20:00" FlightNumber="7154" NumberInParty="1" ResBookDesigCode="F" Status="NN">
                                <DestinationLocation LocationCode="SIN" />
                                <MarketingAirline Code="ID" FlightNumber="7154" />
                                <OriginLocation LocationCode="CGK" />
                            </FlightSegment>
                        </OriginDestinationInformation>
                    </OTA_AirBookRQ>
                    <PostProcessing IgnoreAfter="true">
                        <RedisplayReservation/>
                    </PostProcessing>
                    <PreProcessing IgnoreBefore="false">
                        <UniqueID ID="JEGYLT" />
                    </PreProcessing>
                </EnhancedAirBookRQ>
EOT;
            */
            $xml = $service->Execute("EnhancedAirBookRQ",$EnhancedAirBookRQ,"OTA","Air");
            if( $xml ) {
                //$abc = htmlspecialchars($xml);
                //$result_test = XMLtoArray($xml);
                return $xml;
            }
            else {
                echo  htmlspecialchars($service->error);
            }
        }
        else {
            echo htmlspecialchars($service->error);
       }
    }
    else {
        echo htmlspecialchars($service->error);
    }
}

function search_flight($destinationLocation, $originLocation, $departureDate, $adultNo, $childNo, $infantNo, $flightClass)
{
    $seatRequested = $adultNo+$childNo;//+$infantNo;
    $childExist  = "";
    $infantExist = "";
    if( $childNo != 0 ) {
        $childExist = '<PassengerTypeQuantity Code="CNN" Quantity="'.$childNo.'" />';
    }
    if( $infantNo != 0 ) {
        $infantExist = '<PassengerTypeQuantity Code="INF" Quantity="'.$infantNo.'" />';
    }
    $service = new SWSWebService("ihsan.tay@ctc.com.sg","8888","CTC78866","8HYD","https://webservices.sabre.com/websvc");
    if($service->SessionCreate())
    {
       if($service->SessionValidate())
       {
           $OTA_AirLowFareSearchRQ = '
                <OTA_AirLowFareSearchRQ xmlns="http://www.opentravel.org/OTA/2003/05" ResponseType="OTA" Version="3.4.0" AvailableFlightsOnly="true">
                    <POS>
                        <Source PseudoCityCode="8HYD">
                            <RequestorID ID="1" Type="1">
                                <CompanyName Code="TN" />
                            </RequestorID>
                        </Source>
                    </POS>
                    <OriginDestinationInformation RPH="1">
                        <DepartureDateTime>'.$departureDate.'</DepartureDateTime>
                        <OriginLocation LocationCode="'.$originLocation.'" />
                        <DestinationLocation LocationCode="'.$destinationLocation.'" />
                        <TPA_Extensions>
                            <SegmentType Code="O" />
                            <IncludeVendorPref Code="AA"/>
                            <IncludeVendorPref Code="AC"/>
                            <IncludeVendorPref Code="AF"/>
                            <IncludeVendorPref Code="AI"/>
                            <IncludeVendorPref Code="BA"/>
                            <IncludeVendorPref Code="BI"/>
                            <IncludeVendorPref Code="BR"/>
                            <IncludeVendorPref Code="CA"/>
                            <IncludeVendorPref Code="CI"/>
                            <IncludeVendorPref Code="CX"/>
                            <IncludeVendorPref Code="CZ"/>
                            <IncludeVendorPref Code="DG"/>
                            <IncludeVendorPref Code="DL"/>
                            <IncludeVendorPref Code="EK"/>
                            <IncludeVendorPref Code="EY"/>
                            <IncludeVendorPref Code="FJ"/>
                            <IncludeVendorPref Code="GA"/>
                            <IncludeVendorPref Code="GF"/>
                            <IncludeVendorPref Code="IT"/>
                            <IncludeVendorPref Code="JL"/>
                            <IncludeVendorPref Code="KE"/>
                            <IncludeVendorPref Code="KL"/>
                            <IncludeVendorPref Code="LA"/>
                            <IncludeVendorPref Code="LH"/>
                            <IncludeVendorPref Code="LX"/>
                            <IncludeVendorPref Code="MF"/>
                            <IncludeVendorPref Code="MH"/>
                            <IncludeVendorPref Code="MI"/>
                            <IncludeVendorPref Code="MK"/>
                            <IncludeVendorPref Code="MU"/>
                            <IncludeVendorPref Code="NH"/>
                            <IncludeVendorPref Code="NZ"/>
                            <IncludeVendorPref Code="OD"/>
                            <IncludeVendorPref Code="OZ"/>
                            <IncludeVendorPref Code="PG"/>
                            <IncludeVendorPref Code="PR"/>
                            <IncludeVendorPref Code="PX"/>
                            <IncludeVendorPref Code="QF"/>
                            <IncludeVendorPref Code="QR"/>
                            <IncludeVendorPref Code="QV"/>
                            <IncludeVendorPref Code="SK"/>
                            <IncludeVendorPref Code="SQ"/>
                            <IncludeVendorPref Code="SU"/>
                            <IncludeVendorPref Code="TG"/>
                            <IncludeVendorPref Code="TK"/>
                            ';
                      if($infantNo == 0) {
                        $OTA_AirLowFareSearchRQ .= '<IncludeVendorPref Code="TR"/><IncludeVendorPref Code="TT"/>
                            ';}
                          else if($childNo == 0) {
                              $OTA_BargainMaxFinder .= '
                          <IncludeVendorPref Code="OD"/>
                                  ';
                            }
                      else {

                      }
                      $OTA_AirLowFareSearchRQ .= '
                            <IncludeVendorPref Code="TZ"/><IncludeVendorPref Code="UA"/>
                            <IncludeVendorPref Code="UB"/>
                            <IncludeVendorPref Code="UL"/>
                            <IncludeVendorPref Code="VA"/>
                            <IncludeVendorPref Code="VN"/>
                            <IncludeVendorPref Code="WY"/>
                            <IncludeVendorPref Code="8M"/>
                            <IncludeVendorPref Code="9W"/>
                            <ClassOfService Code="'.$flightClass.'"/>
                        </TPA_Extensions>
                    </OriginDestinationInformation>
                    <TravelPreferences SmokingAllowed="false" ValidInterlineTicket="true" MaxStopsQuantity="2">
                        <CabinPref PreferLevel="Only" Cabin="'.$flightClass.'" />
                        <TPA_Extensions>
                            <TripType Value="OneWay" />
                            <LongConnectTime Min="780" Max="1200" Enable="true" />
                            <ExcludeCallDirectCarriers Enabled="true" />
                        </TPA_Extensions>
                    </TravelPreferences>
                    <TravelerInfoSummary>
                        <SeatsRequested>'.$seatRequested.'</SeatsRequested>
                        <AirTravelerAvail>
                            <PassengerTypeQuantity Code="ADT" Quantity="'.$adultNo.'" />
                            '.$childExist.'
                            '.$infantExist.'
                        </AirTravelerAvail>
                        <PriceRequestInformation NegotiatedFaresOnly="false" CurrencyCode="SGD">
                        </PriceRequestInformation>
                    </TravelerInfoSummary>
                    <TPA_Extensions>
                        <IntelliSellTransaction>
                            <RequestType Name="200ITINS" />
                        </IntelliSellTransaction>
                    </TPA_Extensions>
                </OTA_AirLowFareSearchRQ>​';
            $xml = $service->Execute("BargainFinderMaxRQ",$OTA_AirLowFareSearchRQ,"OTA","Air");

            if( $xml ) {

                //$result_test = XMLtoArray($xml);
                return $xml;
            }
            else {
                echo  htmlspecialchars($service->error);
            }
        }
        else {
            echo htmlspecialchars($service->error);
       }
    }
    else {
        echo htmlspecialchars($service->error);
    }
}

function search_flight_return($checkin, $checkout, $originLocation, $destinationLocation, $adultNo, $childNo, $infantNo, $flightClass)
{
    $seatRequested = $adultNo+$childNo;//+$infantNo;
    $childExist  = "";
    $infantExist = "";
    if( $childNo != 0 ) {
        $childExist = '<PassengerTypeQuantity Code="CNN" Quantity="'.$childNo.'" />';
    }
    if( $infantNo != 0 ) {
        $infantExist = '<PassengerTypeQuantity Code="INF" Quantity="'.$infantNo.'" />';
    }
    $service = new SWSWebService("ihsan.tay@ctc.com.sg","8888","CTC78866","8HYD","https://webservices.sabre.com/websvc");
    if($service->SessionCreate())
    {
       if($service->SessionValidate())
       {
           $OTA_BargainMaxFinder='
                <OTA_AirLowFareSearchRQ xmlns="http://www.opentravel.org/OTA/2003/05" ResponseType="OTA" AvailableFlightsOnly="true" DirectFlightsOnly="false" Version="3.4.0">
                    <POS>
                        <Source PseudoCityCode="8HYD">
                            <RequestorID ID="1" Type="1">
                                <CompanyName Code="TN" />
                            </RequestorID>
                        </Source>
                    </POS>
                    <OriginDestinationInformation RPH="1">
                        <DepartureDateTime>'.$checkin.'</DepartureDateTime>
                        <OriginLocation LocationCode="'.$originLocation.'" />
                        <DestinationLocation LocationCode="'.$destinationLocation.'" />
                        <TPA_Extensions>
                            <SegmentType Code="O" />

                            <IncludeVendorPref Code="AA"/>
                            <IncludeVendorPref Code="AC"/>
                            <IncludeVendorPref Code="AF"/>
                            <IncludeVendorPref Code="AI"/>
                            <IncludeVendorPref Code="BA"/>
                            <IncludeVendorPref Code="BI"/>
                            <IncludeVendorPref Code="BR"/>
                            <IncludeVendorPref Code="CA"/>
                            <IncludeVendorPref Code="CI"/>
                            <IncludeVendorPref Code="CX"/>
                            <IncludeVendorPref Code="CZ"/>
                            <IncludeVendorPref Code="DG"/>
                            <IncludeVendorPref Code="DL"/>
                            <IncludeVendorPref Code="EK"/>
                            <IncludeVendorPref Code="EY"/>
                            <IncludeVendorPref Code="FJ"/>
                            <IncludeVendorPref Code="GA"/>
                            <IncludeVendorPref Code="GF"/>
                            <IncludeVendorPref Code="IT"/>
                            <IncludeVendorPref Code="JL"/>
                            <IncludeVendorPref Code="KE"/>
                            <IncludeVendorPref Code="KL"/>
                            <IncludeVendorPref Code="LA"/>
                            <IncludeVendorPref Code="LH"/>
                            <IncludeVendorPref Code="LX"/>
                            <IncludeVendorPref Code="MF"/>
                            <IncludeVendorPref Code="MH"/>
                            <IncludeVendorPref Code="MI"/>
                            <IncludeVendorPref Code="MK"/>
                            <IncludeVendorPref Code="MU"/>
                            <IncludeVendorPref Code="NH"/>
                            <IncludeVendorPref Code="NZ"/>
                            <IncludeVendorPref Code="OZ"/>
                            <IncludeVendorPref Code="PG"/>
                            <IncludeVendorPref Code="PR"/>
                            <IncludeVendorPref Code="PX"/>
                            <IncludeVendorPref Code="QF"/>
                            <IncludeVendorPref Code="QR"/>
                            <IncludeVendorPref Code="QV"/>
                            <IncludeVendorPref Code="SK"/>
                            <IncludeVendorPref Code="SQ"/>
                            <IncludeVendorPref Code="SU"/>
                            <IncludeVendorPref Code="TG"/>
                            <IncludeVendorPref Code="TK"/>';
                            if($infantNo == 0) {
                            $OTA_BargainMaxFinder .= '<IncludeVendorPref Code="TT"/><IncludeVendorPref Code="TR"/>
                                  ';
                                }
                            else if($childNo == 0) {
                                $OTA_BargainMaxFinder .= '
                            <IncludeVendorPref Code="OD"/>
                                    ';
                            } else {
                            }
                          $OTA_BargainMaxFinder .= '<IncludeVendorPref Code="TZ"/>

                            <IncludeVendorPref Code="TT"/>
                            <IncludeVendorPref Code="TZ"/>
                            <IncludeVendorPref Code="UA"/>
                            <IncludeVendorPref Code="UB"/>
                            <IncludeVendorPref Code="UL"/>
                            <IncludeVendorPref Code="VA"/>
                            <IncludeVendorPref Code="VN"/>
                            <IncludeVendorPref Code="WY"/>
                            <IncludeVendorPref Code="8M"/>
                            <IncludeVendorPref Code="9W"/>
                            <ClassOfService Code="'.$flightClass.'"/>
                        </TPA_Extensions>
                    </OriginDestinationInformation>
                    <OriginDestinationInformation RPH="2">
                        <DepartureDateTime>'.$checkout.'</DepartureDateTime>
                        <OriginLocation LocationCode="'.$destinationLocation.'" />
                        <DestinationLocation LocationCode="'.$originLocation.'" />
                        <TPA_Extensions>
                            <SegmentType Code="O" />

                            <IncludeVendorPref Code="AA"/>
                            <IncludeVendorPref Code="AC"/>
                            <IncludeVendorPref Code="AF"/>
                            <IncludeVendorPref Code="AI"/>
                            <IncludeVendorPref Code="BA"/>
                            <IncludeVendorPref Code="BI"/>
                            <IncludeVendorPref Code="BR"/>
                            <IncludeVendorPref Code="CA"/>
                            <IncludeVendorPref Code="CI"/>
                            <IncludeVendorPref Code="CX"/>
                            <IncludeVendorPref Code="CZ"/>
                            <IncludeVendorPref Code="DG"/>
                            <IncludeVendorPref Code="DL"/>
                            <IncludeVendorPref Code="EK"/>
                            <IncludeVendorPref Code="EY"/>
                            <IncludeVendorPref Code="FJ"/>
                            <IncludeVendorPref Code="GA"/>
                            <IncludeVendorPref Code="GF"/>
                            <IncludeVendorPref Code="IT"/>
                            <IncludeVendorPref Code="JL"/>
                            <IncludeVendorPref Code="KE"/>
                            <IncludeVendorPref Code="KL"/>
                            <IncludeVendorPref Code="LA"/>
                            <IncludeVendorPref Code="LH"/>
                            <IncludeVendorPref Code="LX"/>
                            <IncludeVendorPref Code="MF"/>
                            <IncludeVendorPref Code="MH"/>
                            <IncludeVendorPref Code="MI"/>
                            <IncludeVendorPref Code="MK"/>
                            <IncludeVendorPref Code="MU"/>
                            <IncludeVendorPref Code="NH"/>
                            <IncludeVendorPref Code="NZ"/>
                            <IncludeVendorPref Code="OZ"/>
                            <IncludeVendorPref Code="PG"/>
                            <IncludeVendorPref Code="PR"/>
                            <IncludeVendorPref Code="PX"/>
                            <IncludeVendorPref Code="QF"/>
                            <IncludeVendorPref Code="QR"/>
                            <IncludeVendorPref Code="QV"/>
                            <IncludeVendorPref Code="SK"/>
                            <IncludeVendorPref Code="SQ"/>
                            <IncludeVendorPref Code="SU"/>
                            <IncludeVendorPref Code="TG"/>
                            <IncludeVendorPref Code="TK"/>
                            ';
                            if($infantNo == 0) {
                              $OTA_BargainMaxFinder .= '<IncludeVendorPref Code="TT"/><IncludeVendorPref Code="TR"/>
                                    ';
                                  }
                              else if($childNo == 0) {
                                $OTA_BargainMaxFinder .= '
                            <IncludeVendorPref Code="OD"/>
                                    ';
                              } else {

                              }
                            $OTA_BargainMaxFinder .= '
                            <IncludeVendorPref Code="TZ"/>
                            <IncludeVendorPref Code="UA"/>
                            <IncludeVendorPref Code="UB"/>
                            <IncludeVendorPref Code="UL"/>
                            <IncludeVendorPref Code="VA"/>
                            <IncludeVendorPref Code="VN"/>
                            <IncludeVendorPref Code="WY"/>
                            <IncludeVendorPref Code="8M"/>
                            <IncludeVendorPref Code="9W"/>
                            <ClassOfService Code="'.$flightClass.'"/>
                        </TPA_Extensions>
                    </OriginDestinationInformation>
                    <TravelPreferences ETicketDesired="false" SmokingAllowed="false" ValidInterlineTicket="true" >
                        <CabinPref PreferLevel="Only" Cabin="'.$flightClass.'" />
                        <TPA_Extensions>
                            <TripType Value="Return" />
                            <LongConnectTime Min="780" Max="1200" Enable="true" />
                            <FlightStopsAsConnections Ind="true"/>
                            <ExcludeCallDirectCarriers Enabled="true" />
                        </TPA_Extensions>
                    </TravelPreferences>
                    <TravelerInfoSummary>
                        <SeatsRequested>'.$seatRequested.'</SeatsRequested>
                        <AirTravelerAvail>
                            <PassengerTypeQuantity Code="ADT" Quantity="'.$adultNo.'" />
                            '.$childExist.'
                            '.$infantExist.'
                        </AirTravelerAvail>
                        <PriceRequestInformation NegotiatedFaresOnly="false" CurrencyCode="SGD">
                        </PriceRequestInformation>
                    </TravelerInfoSummary>
                    <TPA_Extensions>
                        <IntelliSellTransaction>
                            <RequestType Name="100ITINS" />
                        </IntelliSellTransaction>
                    </TPA_Extensions>
                </OTA_AirLowFareSearchRQ>​';
/*echo '<xmp>'.$OTA_BargainMaxFinder.'</xmp>';
die();*/
            $xml = $service->Execute("BargainFinderMaxRQ",$OTA_BargainMaxFinder,"OTA","Air");
            if( $xml ) {
                //$abc = htmlspecialchars($xml);
                //$result_test = XMLtoArray($xml);
/*              $parseResult = simplexml_load_string($xml);
                        $arrayFinal  = json_decode(json_encode($parseResult), true);
                        echo '<pre>';
                        var_dump($arrayFinal);
                        die();*/
                return $xml;
            }
            else {
                echo  htmlspecialchars($service->error);
            }
        }
        else {
            echo htmlspecialchars($service->error);
       }
    }
    else {
        echo htmlspecialchars($service->error);
    }
}

/* NEED TO TEST 9 maret 2017 albertto */

/*
* bto :
* hint : get return value of PNR for single flight
* last update : 9 Maret 2017
*/
/*
* bto :
* hint : get return value of PNR for single flight
* last update : 9 Maret 2017
*/
function book_flight_SINGLE(
    $dateFrom,
    $timeFrom,
    $destinationLocationCode,
    $flightCode,
    $flightNo,
    $originLocationCode,
    $totalAdult,
    $totalChild,
    $totalInfant,
    $marriageGroup,
    $flightClass,
    $passengerDetails,
    $contactPerson_email,
    $contactPerson_phone,
    $remarks = '',
    $phoneCodeArea = '65'

)
{
    /* +65 is sg */
    $departureDateTime = $dateFrom."T".$timeFrom;

    $childExist        = "";
    $infantExist       = "";
    if( $totalChild != 0 ) {
        $childExist = '<PassengerType Code="CNN" Quantity="'.$totalChild.'" />';
    }
    if( $totalInfant != 0 )
    {
        /* INF = infant without seat
        INS = infant with seat*/
        $infantExist = '<PassengerType Code="INF" Quantity="'.$totalInfant.'" />';
    }

    /* we don't count infant with code INF for number of party*/
    $numberInParty     = $totalAdult+$totalChild;//+$totalInfant;
    $service = new SWSWebService("ihsan.tay@ctc.com.sg","8888","CTC78866","8HYD","https://webservices.sabre.com/websvc");
    if($service->SessionCreate())
    {
        if($service->SessionValidate())
        {
            /* EAB */
            $EnhancedAirBookRQ = '
              <EnhancedAirBookRQ HaltOnError="true" version="3.7.0" xmlns="http://services.sabre.com/sp/eab/v3_7">
                <OTA_AirBookRQ>
                  <HaltOnStatus Code="NO"/>
                  <HaltOnStatus Code="NN"/>
                  <HaltOnStatus Code="UC"/>
                  <HaltOnStatus Code="US"/>
                  <HaltOnStatus Code="UN"/>
                  <HaltOnStatus Code="LL"/>
                  <HaltOnStatus Code="HL"/>
                  <HaltOnStatus Code="WL"/>
                   <OriginDestinationInformation>
                      <FlightSegment DepartureDateTime="'.$dateFrom.'T'.$timeFrom.'" FlightNumber="'.$flightNo.'" NumberInParty="'.$numberInParty.'" ResBookDesigCode="'.$flightClass.'" Status="NN">
                          <DestinationLocation LocationCode="'.$destinationLocationCode.'" />
                          <MarketingAirline Code="'.$flightCode.'" FlightNumber="'.$flightNo.'" />
                          <MarriageGrp>'.$marriageGroup.'</MarriageGrp>
                          <OperatingAirline Code="'.$flightCode.'" />
                          <OriginLocation LocationCode="'.$originLocationCode.'"/>
                      </FlightSegment>
                  </OriginDestinationInformation>
                  <RedisplayReservation NumAttempts="3" WaitInterval="5000" />
                </OTA_AirBookRQ>
                <OTA_AirPriceRQ>
                  <PriceRequestInformation Retain="true">
                     <OptionalQualifiers>
                        <PricingQualifiers>
                           <PassengerType Code="ADT" Quantity="'.$totalAdult.'" />'
                           .$childExist.$infantExist.'
                        </PricingQualifiers>
                     </OptionalQualifiers>
                  </PriceRequestInformation>
                </OTA_AirPriceRQ>
                <PostProcessing IgnoreAfter="false">
                  <RedisplayReservation WaitInterval="1000"/>
                </PostProcessing>
                <PreProcessing IgnoreBefore="false"/>
              </EnhancedAirBookRQ>';

            $xml = $service->Execute("EnhancedAirBookRQ",$EnhancedAirBookRQ,'OTA', 'Air');
            //$xml=true;
            if ( $xml ) {
                /*
                $parseResult = simplexml_load_string($xml);
                $arrayFinal  = json_decode(json_encode($parseResult), true);
                $countArrayFinal = count($arrayFinal);
                */
                /* init data */
                $priceQuoteInfo = ''; $isInfant = '';
                    $remarksPassenger = "";

                if ( $passengerDetails == TRUE ) {
                    $counter_number = 1;

                    /* every detail PD is different */
                    $specialServicePassengerInfo = '';
                    $securityServicePassengerInfo = '';
                    $serviceAdultInfo = '';
                    $serviceChildrenInfo = '';
                    $serviceInfantInfo = '';
                    $infantParentNameNumber = '1.1';
                    $tempIPNN = '';
                    $contactNumberInfo = '';
                    $contactEmailInfo = '';
                    $personInfo = '';
                    $passengerRemarksInfo = "";

                    foreach ( $passengerDetails AS $passenger ) {
                        $psgTitle = strtoupper($passenger->passengerTitle);
                        $rec = 1;
                        switch($passenger->passengerType) {
                          case 'ADULT' :$rec = 1; break;
                          case 'CHILD' : $rec = 2; break;
                          case 'INFANT' :
                            if($totalChild > 0) {
                                $rec = 3;
                            } else {
                                $rec = 2;
                            }
                            break;
                          default: break;
                        }

                        $priceQuoteInfo .= '<Link NameNumber="'.$counter_number.'.1" Record="'.$rec.'" />';
                        $isInfant = 'Infant="false"'; /* used for adult and children */
                        $dob = $passenger->passengerDOB;
                        $pdtype = 'ADT'; /* use to define passenger type in PD */
                        $passengerType = $passenger->passengerType;
                        $nameRef = '';

                        /* get passenger age, especially children and infant, very very need this */
                        $today   = new DateTime('today');
                        $birthdate = new DateTime($dob);
                        $passengerAge = $birthdate->diff($today)->y;
                        $passengerAge = $passengerAge < 10 ? '0'.$passengerAge : $passengerAge;

                        $passName = strtoupper(trim($passenger->passengerName));
                        $passNameArr = explode (" ", $passName);

                        if (count($passNameArr) == 1) {
                            $surname = $passName;
                            $givenName = $passName;
                        } else {
                            $givenName = array_shift($passNameArr);

                            if (count($passNameArr) > 0) {
                                $surname = implode("", $passNameArr);
                            } else {
                                $surname = $givenName;
                            }
                        }

                        $remarksPassenger .= "Name : ".$givenName. " ".$surname;
                            $remarksPassenger .= "; Passport No : ".$passenger->passengerPassportNo.", Passport Expiry Date: ". $passenger->passengerPassportExpiryDate.";";

                        /*$givenName = array_pop($passNameArr);
                        if (count($passNameArr) == 0) {
                            $surname = $givenName;
                        } else {
                            $surname = implode (" ", $passNameArr);
                        }*/
                        /*$surname = array_pop($passNameArr);*/
                        /*$middleName = "";*/
                        /*if (count($passNameArr) == 0) {
                            $givenName = $surname;
                        } else {
                            if(count($passNameArr) > 1) {
                                $givenName = implode("", $passNameArr);
                                /*array_shift($passNameArr);
                                $middleName = implode (" ", $passNameArr);
                            } else {
                                $givenName = $passNameArr[0];
                            }
                        }*/
                        /*$givenName = strtoupper(trim($passenger->passenger_givenname));
                        $surname = strtoupper(trim($passenger->passenger_surname));

                        $arrGN = explode(" ", $givenName);
                        if (count($arrGN)) {
                            $givenName = implode("", $arrGN);
                        }
                        $arrSN = explode(" ", $surname);
                        if (count($arrSN)) {
                            $surname = implode("", $arrSN);
                        }*/


                        /* get country code of passport and citizenship */
                        $nationalitycountryCode = "";
                        $passissuecountryCode = "";
                        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

                        //query mysql
                        $queryRes = mysqli_query(
                            $connection,
                            "
                                SELECT * FROM country WHERE country_name = '".$passenger->passengerPassportIssueCountry."' LIMIT 0,1
                            "
                        );
                        if( mysqli_num_rows($queryRes) > 0 ) {
                            $queryRow = mysqli_fetch_array($queryRes, MYSQL_ASSOC);
                            $nationalitycountryCode = $queryRow["country_code"];
                        }

                        //query mysql
                        $queryRes = mysqli_query(
                            $connection,
                            "
                                SELECT * FROM country WHERE country_name = '".$passenger->passengerNationality."' LIMIT 0,1
                            "
                        );
                        if( mysqli_num_rows($queryRes) > 0 ) {
                            $queryRow = mysqli_fetch_array($queryRes, MYSQL_ASSOC);
                            $passissuecountryCode =  $queryRow["country_code"];
                        }
                        /* END */

                        $gender = strtolower($passenger->passengerTitle) == 'mr' || strtolower($passenger->passengerTitle) == 'master' ? 'M' : 'F';


                        switch($passenger->passengerType) {
                            case 'ADULT' :
                                $passengerRemarksInfo.= '<Remark Code="H" SegmentNumber="A" Type="General">
                                        '.($passenger->passenger_remarks != ''? '<Text>'.$passenger->passenger_remarks . '-'.$counter_number.'.1</Text>': '<Text>No Remarks</Text>').'
                                    </Remark>';

                                if ($tempIPNN == '') {
                                    $tempIPNN = $counter_number.'.1';
                                    $infantParentNameNumber = $tempIPNN;
                                }
                                $specialServicePassengerInfo .= '<AdvancePassenger SegmentNumber="A">
                                                                    <Document ExpirationDate="'.$passenger->passengerPassportExpiryDate.'" Number="'.$passenger->passengerPassportNo.'" Type="P">
                                                                        <IssueCountry>'.$passissuecountryCode.'</IssueCountry>
                                                                        <NationalityCountry>'.$nationalitycountryCode.'</NationalityCountry>
                                                                    </Document>
                                                                    <PersonName DateOfBirth="'.$dob.'" Gender="'.$gender.'" NameNumber="'.$counter_number.'.1" DocumentHolder="true">
                                                                        <GivenName>'.$givenName.$psgTitle.'</GivenName>';
                                /*if ($middleName != "") {
                                    $specialServicePassengerInfo .= '<MiddleName>'.$middleName.'</MiddleName>';
                                }*/
                                $specialServicePassengerInfo .= '<Surname>'.$surname.'</Surname>
                                                                    </PersonName>
                                                                </AdvancePassenger>';
                                $securityServicePassengerInfo .= '<SecureFlight SegmentNumber="A" >
                                    <PersonName DateOfBirth="'.$dob.'" Gender="'.$gender.'" NameNumber="'.$counter_number.'.1">
                                        <GivenName>'.$givenName.'</GivenName>
                                        <Surname>'.$surname.'</Surname>
                                    </PersonName>
                                    <VendorPrefs>
                                        <Airline Hosted="false"/>
                                    </VendorPrefs>
                                </SecureFlight>';
                                /*
                                $serviceAdultInfo .= '
                                    <Service SSR_Code="OSI" >
                                        <PersonName NameNumber="'.$counter_number.'.1" />
                                        <Text>PASSENGER NAME SHOULD BE '.$surname.'/'.$givenName.' '.$psgTitle.'</Text>
                                        <VendorPrefs>
                                            <Airline Code="'.$flightCode.'" Hosted="false"/>
                                        </VendorPrefs>
                                    </Service>
                                    ';
                                */
                                $phoneNumber = preg_replace('/[^0-9]/','',$contactPerson_phone);

                                if(strlen($phoneNumber) > 10) {
                                    $countryCode = substr($phoneNumber, 0, strlen($phoneNumber)-10);
                                    $areaCode = substr($phoneNumber, -10, 3);
                                    $nextThree = substr($phoneNumber, -7, 3);
                                    $lastFour = substr($phoneNumber, -4, 4);

                                    $phoneNumber = $areaCode.$nextThree.'-'.$lastFour;
                                }
                                else if(strlen($phoneNumber) == 10) {
                                    $areaCode = substr($phoneNumber, 0, 3);
                                    $nextThree = substr($phoneNumber, 3, 3);
                                    $lastFour = substr($phoneNumber, 6, 4);

                                    $phoneNumber = $areaCode.$nextThree.'-'.$lastFour;
                                }
                                else if(strlen($phoneNumber) > 7 && strlen($phoneNumber) < 10) {
                                    $nextThree = substr($phoneNumber, 0, 3);
                                    $lastFour = substr($phoneNumber, 3, 5);

                                    $phoneNumber = $nextThree.'-'.$lastFour;
                                }
                                else if(strlen($phoneNumber) == 7) {
                                    $nextThree = substr($phoneNumber, 0, 3);
                                    $lastFour = substr($phoneNumber, 3, 4);

                                    $phoneNumber = $nextThree.'-'.$lastFour;
                                }

                                $contactNumberInfo .= '<ContactNumber NameNumber="'.$counter_number.'.1" Phone="'.$phoneNumber.' '.$passenger->passengerTitle.' '.$givenName.'" PhoneUseType="H" />';
                                $contactEmailInfo = '<Email Address="'.$contactPerson_email.'" NameNumber="'.$counter_number.'.1" ShortText="CTC Ticket" Type="BC"></Email>';
                                $personInfo .= '<PersonName '.$isInfant.' NameNumber="'.$counter_number.'.1" PassengerType="'.$pdtype.'">
                                    <GivenName>'.$givenName.$psgTitle.'</GivenName>
                                    <Surname>'.$surname.'</Surname>
                                </PersonName>';

                                break;
                            case 'CHILD' :
                                $passengerRemarksInfo.= '<Remark Code="H" SegmentNumber="A" Type="General">
                                        '.($passenger->passenger_remarks != ''? '<Text>'.$passenger->passenger_remarks. '-'.$counter_number.'.1</Text>' : '<Text>No Remarks</Text>').'
                                    </Remark>';

                                $pdtype = 'CNN';
                                $nameRef = 'NameReference="C'.$passengerAge.'"';
                                $specialServicePassengerInfo .= '<AdvancePassenger SegmentNumber="A">
                                <Document ExpirationDate="'.$passenger->passengerPassportExpiryDate.'" Number="'.$passenger->passengerPassportNo.'" Type="P">
                                    <IssueCountry>'.$passissuecountryCode.'</IssueCountry>
                                    <NationalityCountry>'.$nationalitycountryCode.'</NationalityCountry>
                                </Document>
                                <PersonName DateOfBirth="'.$dob.'" Gender="'.$gender.'" NameNumber="'.$counter_number.'.1" >
                                    <GivenName>'.$givenName.$psgTitle.'</GivenName>';
                                /*if ($middleName != "") {
                                    $specialServicePassengerInfo .= '<MiddleName>'.$middleName.'</MiddleName>';
                                }*/
                                $specialServicePassengerInfo .= '<Surname>'.$surname.'</Surname>
                                                                </PersonName>
                                                            </AdvancePassenger>';
                                $securityServicePassengerInfo .= '<SecureFlight SegmentNumber="A" >
                                    <PersonName DateOfBirth="'.$dob.'" Gender="'.$gender.'" NameNumber="'.$counter_number.'.1">
                                        <GivenName>'.$givenName.'</GivenName>
                                        <Surname>'.$surname.'</Surname>
                                    </PersonName>
                                    <VendorPrefs>
                                    <Airline Hosted="false"/></VendorPrefs>
                                </SecureFlight>';

                                /*<Service SSR_Code="OSI" >
                                        <PersonName NameNumber="'.$counter_number.'.1" />
                                        <Text>PASSENGER NAME SHOULD BE '.$surname.'/'.$givenName.' '.$psgTitle.'</Text>
                                        <VendorPrefs>
                                            <Airline Code="'.$flightCode.'"  Hosted="false"/>
                                        </VendorPrefs>
                                    </Service>*/
                                $serviceChildrenInfo .=  '
                                    <Service SegmentNumber="A" SSR_Code="CHLD" >
                                        <PersonName NameNumber="'.$counter_number.'.1" />
                                        <Text>'.strtoupper(date("dMy", strtotime($dob))).'</Text>
                                        <VendorPrefs>
                                            <Airline Hosted="false" />
                                        </VendorPrefs>
                                    </Service>';
                                $personInfo .= '<PersonName '.$isInfant.' NameNumber="'.$counter_number.'.1" PassengerType="'.$pdtype.'" '.$nameRef.'>
                                    <GivenName>'.$givenName.$psgTitle.'</GivenName>
                                    <Surname>'.$surname.'</Surname>
                                </PersonName>';

                                break;
                            case 'INFANT' :
                                $passengerRemarksInfo.= '<Remark Code="H" SegmentNumber="A" Type="General">
                                        '.($passenger->passenger_remarks != ''? '<Text>'.$passenger->passenger_remarks . '-'.$counter_number.'.1</Text>': '<Text>No Remarks</Text>').'
                                    </Remark>';

                                $pdtype = 'INF';
                                $isInfant = 'Infant="true"';
                                $passengerAge = $passengerAge == "00" ? "01" : $passengerAge;
                                $nameRef = 'NameReference="I'.$passengerAge.'"';
                                $gender = strtolower($passenger->passengerTitle) == 'mr' || strtolower($passenger->passengerTitle) == 'master' ? 'MI' : 'FI';
                                $specialServicePassengerInfo .= '<AdvancePassenger SegmentNumber="A">
                                    <Document ExpirationDate="'.$passenger->passengerPassportExpiryDate.'" Number="'.$passenger->passengerPassportNo.'" Type="P">
                                        <IssueCountry>'.$passissuecountryCode.'</IssueCountry>
                                        <NationalityCountry>'.$nationalitycountryCode.'</NationalityCountry>
                                    </Document>
                                    <PersonName DateOfBirth="'.$dob.'" Gender="'.$gender.'" NameNumber="'.$infantParentNameNumber.'" >
                                        <GivenName>'.$givenName.$psgTitle.'</GivenName>';
                                /*if ($middleName != "") {
                                    $specialServicePassengerInfo .= '<MiddleName>'.$middleName.'</MiddleName>';
                                }*/
                                $specialServicePassengerInfo .= '<Surname>'.$surname.'</Surname>
                                                                </PersonName>
                                                            </AdvancePassenger>';
                                $securityServicePassengerInfo .= '<SecureFlight SegmentNumber="A" >
                                    <PersonName DateOfBirth="'.$dob.'" Gender="'.$gender.'" NameNumber="'.$infantParentNameNumber.'">
                                        <GivenName>'.$givenName.'</GivenName>
                                        <Surname>'.$surname.'</Surname>
                                    </PersonName>
                                    <VendorPrefs>
                                    <Airline Hosted="false"/></VendorPrefs>
                                </SecureFlight>';
                                $serviceInfantInfo .=
                                    /*<Service SSR_Code="OSI" >
                                        <PersonName NameNumber="'.$infantParentNameNumber.'" />
                                        <Text>PASSENGER NAME SHOULD BE '.$surname.'/'.$givenName.' '.$psgTitle.'</Text>
                                        <VendorPrefs>
                                            <Airline Code="'.$flightCode.'" Hosted="false" />
                                        </VendorPrefs>
                                    </Service>*/
                                    '<Service SegmentNumber="A" SSR_Code="INFT">
                                        <PersonName NameNumber="'.$infantParentNameNumber.'" />
                                        <Text>'.strtoupper($surname).'/'.strtoupper($givenName).'/'.strtoupper(date("dMy", strtotime($dob))).'</Text>
                                        <VendorPrefs>
                                            <Airline Hosted="false" />
                                        </VendorPrefs>
                                    </Service>';

                                $personInfo .= '<PersonName '.$isInfant.' NameNumber="'.$counter_number.'.1" PassengerType="'.$pdtype.'" '.$nameRef.'>
                                    <GivenName>'.$givenName.$psgTitle.'</GivenName>
                                    <Surname>'.$surname.'</Surname>
                                </PersonName>';
                                break;
                            case 'STUDENT' :
                                break;
                            case 'AGENT' :
                                break;
                            case 'TOURS' :
                                break;
                            case 'MILITARY' :
                                break;
                                default : break;

                        }
                        $counter_number++;
                    }

                    $specialServicePassengerInfo .= $securityServicePassengerInfo. $serviceAdultInfo . $serviceChildrenInfo . $serviceInfantInfo;
                          /* put after special req details tag
                          <AddRemarkRQ>
                            <RemarkInfo>
                                <Remark Code="H" SegmentNumber="1" Type="General">
                                    <Text></Text>
                                </Remark>
                            </RemarkInfo>
                        </AddRemarkRQ> */

                    $PDBookRQ = '<PassengerDetailsRQ xmlns="http://services.sabre.com/sp/pd/v3_3" version="3.3.0" IgnoreOnError="false" HaltOnError="true" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
                        <PostProcessing IgnoreAfter="false" RedisplayReservation="true" UnmaskCreditCard="true" xmlns="http://services.sabre.com/sp/pd/v3_3">
                            <EndTransactionRQ>
                                <EndTransaction Ind="true" />
                                <Source ReceivedFrom="CTC TRAVEL"/>
                            </EndTransactionRQ>
                         </PostProcessing>
                        <PreProcessing xmlns="http://services.sabre.com/sp/pd/v3_3" IgnoreBefore="false">
                            <UniqueID ID="" />
                        </PreProcessing>
                        <PriceQuoteInfo>
                            '.$priceQuoteInfo.'
                        </PriceQuoteInfo>
                        <SpecialReqDetails>
                            <AddRemarkRQ>
                                <RemarkInfo>
                                    '.$passengerRemarksInfo.'
                                </RemarkInfo>
                            </AddRemarkRQ>
                            <SpecialServiceRQ>
                                <SpecialServiceInfo>
                                    '.$specialServicePassengerInfo.'
                                </SpecialServiceInfo>
                            </SpecialServiceRQ>
                        </SpecialReqDetails>
                        <TravelItineraryAddInfoRQ xmlns="http://services.sabre.com/sp/pd/v3_3">
                            <AgencyInfo>
                              <Address>
                                  <AddressLine>COMMONWEALTH TRAVEL SERVICE CORPORATION PTE LTD</AddressLine>
                                  <CityName>CHINATOWN POINT, SINGAPORE</CityName>
                                  <CountryCode>SG</CountryCode>
                                  <PostalCode>059413</PostalCode>
                                  <StreetNmbr>133 NEW BRIDGE ROAD 03-03</StreetNmbr>
                              </Address>
                              <Ticketing TicketType="7TAW"/>
                            </AgencyInfo>
                            <CustomerInfo>
                                <ContactNumbers>
                                    '.$contactNumberInfo.'
                                </ContactNumbers>
                                '.$contactEmailInfo.'
                                '.$personInfo.'
                            </CustomerInfo>
                        </TravelItineraryAddInfoRQ>
                    </PassengerDetailsRQ>';

                    /* end PD true */

                    $xml = $service->Execute("PassengerDetailsRQ",$PDBookRQ, 'OTA', 'Air');

                    /*echo '2<br>';
                    echo '<xmp>'.$EnhancedAirBookRQ.'</xmp>';
                    echo '<xmp>'.$PDBookRQ.'</xmp>';
                    if( $xml ) {
                        $parseResult = simplexml_load_string($xml);
                        $arrayFinal  = json_decode(json_encode($parseResult), true);
                        var_dump($arrayFinal);
                    } else {
                      echo htmlspecialchars($service->error);
                    }
                    die();
                    */
                    if( $xml ) {
                        $parseResult = simplexml_load_string($xml);
                        $arrayFinal  = json_decode(json_encode($parseResult), true);

                        $txt  = "[".date("Y-m-d H:i:s")."] [SGL][PD] Output  ". print_r($arrayFinal, true);
                        $txt  .= "[".date("Y-m-d H:i:s")."] [SGL][PD] XML  ". $xml;
                        //log file
                        $myfile = fopen(sinstanceurl."assets/api-logs/logs.txt", "a") or die("Unable to open file!");
                        // $txt  = "[".date("Y-m-d H:i:s")."] - ".$output;
                        fwrite($myfile, "\n". $txt);
                        fclose($myfile);

                        $countAF = count($arrayFinal);
                        return $countAF && array_key_exists('ItineraryRef', $arrayFinal) ? $arrayFinal['ItineraryRef']['@attributes']['ID'] : 'error';
                    } else {
                      $txt  = "[".date("Y-m-d H:i:s")."] [SGL][PD] ". htmlspecialchars($service->error);

                      //log file
                      $myfile = fopen(sinstanceurl."assets/api-logs/logs.txt", "a") or die("Unable to open file!");
                      // $txt  = "[".date("Y-m-d H:i:s")."] - ".$output;
                      fwrite($myfile, "\n". $txt);
                      fclose($myfile);
                      return 'error';
                    }
                } else {
                  $txt  = "[".date("Y-m-d H:i:s")."] [SGL][PD] NO Passenger Data";

                  //log file
                  $myfile = fopen(sinstanceurl."assets/api-logs/logs.txt", "a") or die("Unable to open file!");
                  // $txt  = "[".date("Y-m-d H:i:s")."] - ".$output;
                  fwrite($myfile, "\n". $txt);
                  fclose($myfile);
                  return 'error';
                }
            }
            else {
                $txt  = "[".date("Y-m-d H:i:s")."] [SGL][EAB-2] ". htmlspecialchars($service->error);

                //log file
                $myfile = fopen(sinstanceurl."assets/api-logs/logs.txt", "a") or die("Unable to open file!");
                // $txt  = "[".date("Y-m-d H:i:s")."] - ".$output;
                fwrite($myfile, "\n". $txt);
                fclose($myfile);
                return 'error';
            }
        }
        else {
            $txt  = "[".date("Y-m-d H:i:s")."] [SGL][EAB-3] ". htmlspecialchars($service->error);

            //log file
            $myfile = fopen(sinstanceurl."assets/api-logs/logs.txt", "a") or die("Unable to open file!");
            // $txt  = "[".date("Y-m-d H:i:s")."] - ".$output;
            fwrite($myfile, "\n". $txt);
            fclose($myfile);
            return 'error';
        }
    }
    else {
        $txt  = "[".date("Y-m-d H:i:s")."] [SGL][EAB-4] ". htmlspecialchars($service->error);

        //log file
        $myfile = fopen(sinstanceurl."assets/api-logs/logs.txt", "a") or die("Unable to open file!");
        // $txt  = "[".date("Y-m-d H:i:s")."] - ".$output;
        fwrite($myfile, "\n". $txt);
        fclose($myfile);
        return 'error';
    }
}
/* END END END */

/* hint : single flight with multi transit */
function book_flight_segmentSingleMulti(
                $dateFromString, $timeFromString,
                $CityCodeFromString, $cityCodeToString, $flightCodeString,
                $totalAdult, $totalChild, $totalInfant,
                $flightresBookDesigCodeString, $FlightAirEquipTypeString,
                $FlightMarriageGrpString,
                $contactPerson_email,
                $contactPerson_phone,
                $passengerDetails
            )
{
    $dateFromArray = explode("~", $dateFromString);
    $timeFromArray = explode("~", $timeFromString);
    $CityCodeFromArray = explode("~", $CityCodeFromString);
    $cityCodeToArray = explode("~", $cityCodeToString);
    $flightCodeArray = explode("~", $flightCodeString);

    $flightCode = array();
    $flightNo = array();
    for ($idxCode = 0; $idxCode < count($flightCodeArray); $idxCode++)
    {
        $codeExplodeArr = explode(" ", $flightCodeArray[$idxCode]);
        $flightCode[$idxCode] = $codeExplodeArr[0];
        $flightNo[$idxCode] = $codeExplodeArr[1];
    }
    $flightresBookDesigCodeArray = explode("~", $flightresBookDesigCodeString);
    $FlightAirEquipTypeArray = explode("~", $FlightAirEquipTypeString);
    $FlightMarriageGrpArray = explode("~", $FlightMarriageGrpString);

    //header("Content-type: text/xml");
    $numberInParty     = $totalAdult+$totalChild+$totalInfant;
    $childExist        = "";
    $infantExist       = "";
    if( $totalChild != 0 ) {
        $childExist = '<PassengerTypeQuantity Code="C07" Quantity="'.$totalChild.'" />';
    }
    if( $totalInfant != 0 ) {
        $infantExist = '<PassengerTypeQuantity Code="INS" Quantity="'.$totalInfant.'" />';
    }
    $service = new SWSWebService("ihsan.tay@ctc.com.sg","8888","CTC78866","8HYD","https://webservices.sabre.com/websvc");
    if($service->SessionCreate())
    {
        if($service->SessionValidate())
        {
            $flightSegmentString = "";
            for($idxSeg = 0; $idxSeg < count($flightCodeArray); $idxSeg++) {
                $flightSegmentString .= '
                        <FlightSegment DepartureDateTime="'.$dateFromArray[$idxSeg].'T'.$timeFromArray[$idxSeg].'" FlightNumber="'.$flightNo[$idxSeg].'" NumberInParty="'.$numberInParty.'" ResBookDesigCode="'.$flightresBookDesigCodeArray[$idxSeg].'" Status="NN">
                            <DestinationLocation LocationCode="'.$cityCodeToArray[$idxSeg].'" />
                            <MarketingAirline Code="'.$flightCode[$idxSeg].'" FlightNumber="'.$flightNo[$idxSeg].'" />
                            <MarriageGrp>'.$FlightMarriageGrpArray[$idxSeg].'</MarriageGrp>
                            <OperatingAirline Code="'.$flightCode[$idxSeg].'" />
                            <OriginLocation LocationCode="'.$CityCodeFromArray[$idxSeg].'"/>
                        </FlightSegment>';
            }

            $EnhancedAirBookRQ = '
                    <EnhancedAirBookRQ HaltOnError="true" version="3.7.0" xmlns="http://services.sabre.com/sp/eab/v3_7">
                         <OTA_AirBookRQ>
                            <HaltOnStatus Code="NO"/>
                            <HaltOnStatus Code="NN"/>
                            <HaltOnStatus Code="UC"/>
                            <HaltOnStatus Code="US"/>
                            <HaltOnStatus Code="UN"/>
                            <HaltOnStatus Code="LL"/>
                            <HaltOnStatus Code="HL"/>
                            <HaltOnStatus Code="WL"/>
                             <OriginDestinationInformation>
                             '.$flightSegmentString.'
                            </OriginDestinationInformation>
                            <RedisplayReservation NumAttempts="3" WaitInterval="5000" />
                         </OTA_AirBookRQ>
                         <OTA_AirPriceRQ>
                            <PriceRequestInformation Retain="true">
                               <OptionalQualifiers>
                                  <PricingQualifiers>
                                     <PassengerType Code="ADT" Quantity="'.$totalAdult.'" />'
                                     .$childExist.$infantExist.'
                                  </PricingQualifiers>
                               </OptionalQualifiers>
                            </PriceRequestInformation>
                         </OTA_AirPriceRQ>
                        <PostProcessing IgnoreAfter="false" xmlns="http://services.sabre.com/sp/eab/v3_7">
                            <RedisplayReservation/>
                         </PostProcessing>
                        <PreProcessing xmlns="http://services.sabre.com/sp/eab/v3_7" />
                      </EnhancedAirBookRQ>';

                $xml = $service->Execute("EnhancedAirBookRQ",$EnhancedAirBookRQ,'OTA', 'Air');
                if( $xml ) {
                    $parseResult = simplexml_load_string($xml);
                    $arrayFinal  = json_decode(json_encode($parseResult), true);
                    $countArrayFinal = count($arrayFinal);

                    /* get passenger detail */
                    $priceQuote = "";
                    $customerContactNumberInfo = '';
                    $customerContactNameInfo = '';
                    $APIs = ""; //advance passenger informations

                    if( $passengerDetails == TRUE ) {
                        $counter_number = 1;
                        $priceQuote = "<PriceQuoteInfo>";
                        $customerContactNumberInfo = '<ContactNumbers>';
                        $emailContact = '';

                        foreach( $passengerDetails AS $passenger ) {
                            $priceQuote .= '<Link HostedCarrier="false" NameNumber="'.$counter_number.'.1" Record="'.$counter_number.'"/>';
                            $ptype = 'ADT';
                            switch($passenger->passengerType) {
                                case 'ADULT' :
                                        $ptype = 'ADT';
                                    break;
                                case 'CHILD' :
                                    $birthdate = new DateTime($passenger->passengerDOB);
                                    $today   = new DateTime('today');
                                    $age = $birthdate->diff($today)->y;
                                    $age = $age < 10 ? '0'.$age : $age;
                                    $ptype = 'C'.$age;
                                    break;
                                case 'INFANT' : $ptype = 'INS';
                                    break;
                                case 'STUDENT' :
                                    break;
                                case 'AGENT' :
                                    break;
                                case 'TOURS' :
                                    break;
                                case 'MILITARY' :
                                    break;
                                    default : break;

                            }

                            /* "PhoneUseType" is used to specify if the number is agency, "A," home, "H," business, "B," or fax, "F." */
                            $emailContact .= '<Email Address="'.$contactPerson_email.'" ShortText="BCC Ticket" Type="TO"/>';
                            $customerContactNumberInfo .= '<ContactNumber NameNumber="'.$counter_number.'.1" Phone="012-555-1212" PhoneUseType="H" />';

                            $passName = $passenger->passengerName;
                            $passNameArr = explode (" ", $passName);
                            $givenName = array_pop($passNameArr);
                            if (count($passNameArr) == 0) {
                                $surname = $givenName;
                            } else {
                                $surname = implode (" ", $passNameArr);
                            }

                            $customerContactNameInfo .= '
                                    <PersonName Infant="false" NameNumber="'.$counter_number.'.1" PassengerType="'.$ptype.'">
                                        <GivenName>'.$givenName.'</GivenName>
                                        <Surname>'.$surname.'</Surname>
                                    </PersonName>
                                    ';

                            $issuecountryCode = "";
                            $passcountryCode = "";
                            $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
                            //query mysql
                            $queryRes = mysqli_query(
                                $connection,
                                "
                                    SELECT * FROM country WHERE country_name = '".$passenger->passengerPassportIssueCountry."' LIMIT 0,1
                                "
                            );
                            if( mysqli_num_rows($queryRes) > 0 ) {
                                $queryRow = mysqli_fetch_array($queryRes, MYSQL_ASSOC);
                                $issuecountryCode = $queryRow["country_code"];
                            }

                            //query mysql
                            $queryRes = mysqli_query(
                                $connection,
                                "
                                    SELECT * FROM country WHERE country_name = '".$passenger->passengerNationality."' LIMIT 0,1
                                "
                            );
                            if( mysqli_num_rows($queryRes) > 0 ) {
                                $queryRow = mysqli_fetch_array($queryRes, MYSQL_ASSOC);
                                $passcountryCode =  $queryRow["country_code"];
                            }

                            $gender = strtolower($passenger->passengerTitle) == 'mr' || strtolower($passenger->passengerTitle) == 'master' ? 'M' : 'F';
                            $APIs .= '<AdvancePassenger SegmentNumber="A">
                                <Document ExpirationDate="'.$passenger->passengerPassportExpiryDate.'" Number="'.$passenger->passengerPassportNo.'" Type="P">
                                    <IssueCountry>'.$issuecountryCode.'</IssueCountry>
                                    <NationalityCountry>'.$passcountryCode.'</NationalityCountry>
                                </Document>
                                <PersonName DateOfBirth="'.$passenger->passengerDOB.'" Gender="'.$gender.'" NameNumber="'.$counter_number.'.1" '. (($passenger->passengerType == 'ADULT' && $counter_number == 1) ? 'DocumentHolder="true"' : '').'>
                                    <GivenName>'.strtoupper($passenger->passengerTitle).' '.$givenName.'</GivenName>
                                    <Surname>'.$surname.'</Surname>
                                </PersonName>
                                <VendorPrefs>
                                    <Airline Hosted="false"/>
                                </VendorPrefs>
                            </AdvancePassenger>';
                            $counter_number++;
                        }
                        $priceQuote .= "</PriceQuoteInfo>";
                        $customerContactNumberInfo .= '</ContactNumbers>';
                    }

                    $agencyTicketType = "7TAW"; // ticket at will;

                    $EnhancedAirBookRQ = '
                        <PassengerDetailsRQ xmlns="http://services.sabre.com/sp/pd/v3_3" version="3.3.0" IgnoreOnError="false" HaltOnError="false" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
                            <PostProcessing IgnoreAfter="false" RedisplayReservation="true" UnmaskCreditCard="true" xmlns="http://services.sabre.com/sp/pd/v3_3">
                                <EndTransactionRQ>
                                    <EndTransaction Ind="true" />
                                    <Source ReceivedFrom="CTC Test TRAVEL"/>
                                </EndTransactionRQ>
                             </PostProcessing>
                            <PreProcessing xmlns="http://services.sabre.com/sp/pd/v3_3" IgnoreBefore="false">
                                <UniqueID ID="" />
                            </PreProcessing>
                            '.$priceQuote.'
                            <SpecialReqDetails>
                                <SpecialServiceRQ>
                                    <SpecialServiceInfo>
                                        '.$APIs.'
                                    </SpecialServiceInfo>
                                </SpecialServiceRQ>
                            </SpecialReqDetails>

                            <TravelItineraryAddInfoRQ xmlns="http://services.sabre.com/sp/pd/v3_3">
                                <AgencyInfo>
                                    <Ticketing TicketType="'.$agencyTicketType.'"/>
                                </AgencyInfo>
                                <CustomerInfo>
                                '.$customerContactNumberInfo.'
                                '.$emailContact.'
                                '.$customerContactNameInfo.'
                                </CustomerInfo>
                            </TravelItineraryAddInfoRQ>
                        </PassengerDetailsRQ>';
                    $xml = $service->Execute("PassengerDetailsRQ",$EnhancedAirBookRQ, 'OTA', 'Air');
                    if( $xml ) {
                        $parseResult = simplexml_load_string($xml);
                        $arrayFinal  = json_decode(json_encode($parseResult), true);

                        return $arrayFinal['ItineraryRef']['@attributes']['ID'] ? $arrayFinal['ItineraryRef']['@attributes']['ID'] : '';
                    } else {
                        echo '1 - '.htmlspecialchars($service->error);
                    }
                }
                else {
                    echo '2 - '.htmlspecialchars($service->error);
               }
        }
        else {
            echo '3 - '.htmlspecialchars($service->error);
        }
    }
    else {
        echo '4 - '.htmlspecialchars($service->error);
    }
}


function readItinerary($pnr = "")
{
    $service = new SWSWebService("ihsan.tay@ctc.com.sg","8888","CTC78866","8HYD","https://webservices.sabre.com/websvc");
    if($service->SessionCreate())
    {
        if($service->SessionValidate())
        {
            $readItineraryRQ = '<TravelItineraryReadRQ xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns="http://webservices.sabre.com/sabreXML/2011/10" Version="2.2.0">
    <MessagingDetails>
    <Transaction Code="PNR"/>
    </MessagingDetails>
    <UniqueID ID="'.$pnr.'"/>
</TravelItineraryReadRQ>';
            $xml = $service->Execute("TravelItineraryReadLLSRQ", $readItineraryRQ,'OTA', 'Air');
            echo '<xmp>'.$readItineraryRQ.'</xmp>';

            if( $xml ) {
                $parseResult = simplexml_load_string($xml);
                $arrayFinal  = json_decode(json_encode($parseResult), true);
                $countArrayFinal = count($arrayFinal);

                echo '<pre>';
                var_dump($arrayFinal);
            } else {
                echo '2 - '.htmlspecialchars($service->error);
            }

        } else {
            echo '3 - '.htmlspecialchars($service->error);
        }
    } else {
        echo '4 - '.htmlspecialchars($service->error);
    }
}

/* bto 15 maret 2017, to handle multi flight return, either transit departure or transit return or both */
function book_flight_multiflight(
                $depFlightEquip = "", $arvFlightEquip = "",
                $departureDateFromString, $departureTimeFromString,
                $departureDateToString, $departureTimeToString,
                $departureCityCodeFromString, $departureCityCodeToString,
                $departureFlightCodeString,
                $departureFlightresBookDesigCodeString,
                $departureFlightAirEquipTypeString,
                $departureFlightMarriageGrpString,

                $arrivalDateFromString = "", $arrivalTimeFromString = "",
                $arrivalDateToString = "", $arrivalTimeToString = "",
                $arrivalCityCodeFromString = "", $arrivalCityCodeToString = "",
                $arrivalFlightCodeString = "",
                $arrivalFlightresBookDesigCodeString  = "",
                $arrivalFlightAirEquipTypeString  = "",
                $arrivalFlightMarriageGrpString  = "",

                $totalAdult, $totalChild, $totalInfant,
                $contactPerson_email,
                $contactPerson_phone,
                $contactPerson_nationality,
                $passengerDetails,
                $remarks = ""
            )
{
    /* departure part */
    $DepDateFromArray = explode("~", $departureDateFromString);
    $DepTimeFromArray = explode("~", $departureTimeFromString);
    $DepEquipArr =  explode("~", $depFlightEquip);
    $ArvEquipArr =  explode("~", $arvFlightEquip);

    $DepDateToArray = explode("~", $departureDateToString);
    $DepTimeToArray = explode("~", $departureTimeToString);

    $DepCityCodeFromArray = explode("~", $departureCityCodeFromString);
    $DepCityCodeToArray = explode("~", $departureCityCodeToString);
    $DepFlightCodeArray = explode("~", $departureFlightCodeString);

    $DepFlightCode = array();
    $DepFlightNo = array();

    for ($idxCode = 0; $idxCode < count($DepFlightCodeArray); $idxCode++)
    {
        $codeExplodeArr = explode(" ", $DepFlightCodeArray[$idxCode]);
        $DepFlightCode[$idxCode] = $codeExplodeArr[0];
        $DepFlightNo[$idxCode] = $codeExplodeArr[1];
    }
    $DepFlightrResBookDesigCodeArray = explode("~", $departureFlightresBookDesigCodeString);
    $DepFlightAirEquipTypeArray = explode("~", $departureFlightAirEquipTypeString);
    $DepFlightMarriageGrpArray = explode("~", $departureFlightMarriageGrpString);

    /* arrival part */
    $ArvDateFromArray = explode("~", $arrivalDateFromString);
    $ArvTimeFromArray = explode("~", $arrivalTimeFromString);

    $ArvDateToArray = explode("~", $arrivalDateToString);
    $ArvTimeToArray = explode("~", $arrivalTimeToString);

    $ArvCityCodeFromArray = explode("~", $arrivalCityCodeFromString);
    $ArvCityCodeToArray = explode("~", $arrivalCityCodeToString);
    $ArvFlightCodeArray = explode("~", $arrivalFlightCodeString);

    if(count($ArvFlightCodeArray) >= 1 && $ArvFlightCodeArray[0] != "") {
        $ArvFlightCode = array();
        $ArvFlightNo = array();
        for ($idxCode = 0; $idxCode < count($ArvFlightCodeArray); $idxCode++)
        {
            $codeExplodeArr = explode(" ", $ArvFlightCodeArray[$idxCode]);
            $ArvFlightCode[$idxCode] = $codeExplodeArr[0];
            $ArvFlightNo[$idxCode] = $codeExplodeArr[1];
        }
        $ArvFlightrResBookDesigCodeArray = explode("~", $arrivalFlightresBookDesigCodeString);
        $ArvFlightAirEquipTypeArray = explode("~", $arrivalFlightAirEquipTypeString);
        $ArvFlightMarriageGrpArray = explode("~", $arrivalFlightMarriageGrpString);
    }

    //header("Content-type: text/xml");
    $childExist        = "";
    $infantExist       = "";
    if( $totalChild != 0 ) {
        $childExist = '<PassengerType Code="CNN" Quantity="'.$totalChild.'" />';
    }
    if( $totalInfant != 0 )
    {
        /* INF = infant without seat
        INS = infant with seat*/
        $infantExist = '<PassengerType Code="INF" Quantity="'.$totalInfant.'" />';
    }

    /* we don't count infant with code INF for number of party*/
    $numberInParty     = $totalAdult+$totalChild;//+$totalInfant;

    $service = new SWSWebService("ihsan.tay@ctc.com.sg","8888","CTC78866","8HYD","https://webservices.sabre.com/websvc");
    if($service->SessionCreate())
    {
        if($service->SessionValidate())
        {
            $flightSegmentString = "";
            /* make a flight segment for departure */
            $flgCode = "";
            for($idxSeg = 0; $idxSeg < count($DepFlightCodeArray); $idxSeg++) {
              /* just take 1 code airflight, all same */
              $flgCode = $DepFlightCode[$idxSeg];

                $flightSegmentString .= '
                        <FlightSegment DepartureDateTime="'.$DepDateFromArray[$idxSeg].'T'.$DepTimeFromArray[$idxSeg].'" ArrivalDateTime="'.$DepDateToArray[$idxSeg].'T'.$DepTimeToArray[$idxSeg].'" FlightNumber="'.$DepFlightNo[$idxSeg].'" NumberInParty="'.$numberInParty.'" ResBookDesigCode="'.$DepFlightrResBookDesigCodeArray[$idxSeg].'" Status="NN">
                            <DestinationLocation LocationCode="'.$DepCityCodeToArray[$idxSeg].'" />';
                        if($DepEquipArr[$idxSeg] != "") {
                            $flightSegmentString .= '<Equipment AirEquipType="'.$DepEquipArr[$idxSeg].'"/>';
                        }
                        $flightSegmentString .= '
                            <MarketingAirline Code="'.$DepFlightCode[$idxSeg].'" FlightNumber="'.$DepFlightNo[$idxSeg].'" />
                            <MarriageGrp>'.$DepFlightMarriageGrpArray[$idxSeg].'</MarriageGrp>
                            <OperatingAirline Code="'.$DepFlightCode[$idxSeg].'" />
                            <OriginLocation LocationCode="'.$DepCityCodeFromArray[$idxSeg].'"/>
                        </FlightSegment>';
            }

            /* next, is to, make a flight segment for arrival */
            if(count($ArvFlightCodeArray) >= 1 && $ArvFlightCodeArray[0] != "") {
                for($idxSeg = 0; $idxSeg < count($ArvFlightCodeArray); $idxSeg++) {
                    $flightSegmentString .= '
                            <FlightSegment DepartureDateTime="'.$ArvDateFromArray[$idxSeg].'T'.$ArvTimeFromArray[$idxSeg].'" ArrivalDateTime="'.$ArvDateToArray[$idxSeg].'T'.$ArvTimeToArray[$idxSeg].'" FlightNumber="'.$ArvFlightNo[$idxSeg].'" NumberInParty="'.$numberInParty.'" ResBookDesigCode="'.$ArvFlightrResBookDesigCodeArray[$idxSeg].'" Status="NN">
                                <DestinationLocation LocationCode="'.$ArvCityCodeToArray[$idxSeg].'" />';

                                if($ArvEquipArr[$idxSeg] != "") {
                                    $flightSegmentString .= '<Equipment AirEquipType="'.$ArvEquipArr[$idxSeg].'"/>';
                                }
                                $flightSegmentString .= '
                                <MarketingAirline Code="'.$ArvFlightCode[$idxSeg].'" FlightNumber="'.$ArvFlightNo[$idxSeg].'" />
                                <MarriageGrp>'.$ArvFlightMarriageGrpArray[$idxSeg].'</MarriageGrp>
                                <OperatingAirline Code="'.$ArvFlightCode[$idxSeg].'" />
                                <OriginLocation LocationCode="'.$ArvCityCodeFromArray[$idxSeg].'"/>
                            </FlightSegment>';
                }
            }

            $EnhancedAirBookRQ = '
                      <EnhancedAirBookRQ HaltOnError="true" version="3.7.0" xmlns="http://services.sabre.com/sp/eab/v3_7">
                         <OTA_AirBookRQ>
                            <HaltOnStatus Code="NO"/>
                            <HaltOnStatus Code="NN"/>
                            <HaltOnStatus Code="UC"/>
                            <HaltOnStatus Code="US"/>
                            <HaltOnStatus Code="UN"/>
                            <HaltOnStatus Code="LL"/>
                            <HaltOnStatus Code="HL"/>
                            <HaltOnStatus Code="WL"/>
                             <OriginDestinationInformation>
                             '.$flightSegmentString.'
                            </OriginDestinationInformation>
                            <RedisplayReservation NumAttempts="3" WaitInterval="5000" />
                         </OTA_AirBookRQ>
                         <OTA_AirPriceRQ>
                            <PriceRequestInformation Retain="true">
                               <OptionalQualifiers>
                                  <PricingQualifiers>
                                     <PassengerType Code="ADT" Quantity="'.$totalAdult.'" />'
                                     .$childExist.$infantExist.'
                                  </PricingQualifiers>
                               </OptionalQualifiers>
                            </PriceRequestInformation>
                         </OTA_AirPriceRQ>
                        <PostProcessing IgnoreAfter="false" xmlns="http://services.sabre.com/sp/eab/v3_7">
                            <RedisplayReservation WaitInterval="1000"/>
                         </PostProcessing>
                        <PreProcessing xmlns="http://services.sabre.com/sp/eab/v3_7" />
                      </EnhancedAirBookRQ>';
            /*die();*/
            $xml = $service->Execute("EnhancedAirBookRQ",$EnhancedAirBookRQ,'OTA', 'Air');

            if( $xml ) {
                /*$parseResult = simplexml_load_string($xml);
                $arrayFinal  = json_decode(json_encode($parseResult), true);
                $countArrayFinal = count($arrayFinal);*/

                /*echo $xml;
                echo '<pre>';
                var_dump($parseResult);
                var_dump($arrayFinal);*/
                /* get passenger detail */
                /* init data */
                $priceQuoteInfo = ''; $isInfant = '';
                $remarksPassenger = "";

                if( $passengerDetails == TRUE ) {
                  $counter_number = 1;

                  /* every detail PD is different */
                  $specialServicePassengerInfo = '';
                  $secureServicePassengerInfo ='';
                  $serviceAdultInfo = '';
                  $serviceChildrenInfo = '';
                  $serviceInfantInfo = '';
                  $infantParentNameNumber = '1.1';
                  $tempIPNN = '';
                  $contactNumberInfo = '';
                  $contactEmailInfo = '';
                  $personInfo = '';
                  $passengerRemarksInfo = "";

                  foreach ( $passengerDetails AS $passenger ) {
                        $psgTitle = strtoupper($passenger->passengerTitle);
                        $rec = 1;
                        switch($passenger->passengerType) {
                          case 'ADULT' :$rec = 1; break;
                          case 'CHILD' : $rec = 2; break;
                          case 'INFANT' :
                            if($totalChild > 0) {
                                $rec = 3;
                            } else {
                                $rec = 2;
                            }
                            break;
                          default: break;
                        }

                      $priceQuoteInfo .= '<Link NameNumber="'.$counter_number.'.1" Record="'.$rec.'" />';
                      $isInfant = 'Infant="false"'; /* used for adult and children */
                      $dob = $passenger->passengerDOB;
                      $pdtype = 'ADT'; /* use to define passenger type in PD */
                      $passengerType = $passenger->passengerType;
                      $nameRef = '';

                      /* get passenger age, especially children and infant, very very need this */
                      $today   = new DateTime('today');
                      $birthdate = new DateTime($dob);
                      $passengerAge = $birthdate->diff($today)->y;
                      $passengerAge = $passengerAge < 10 ? '0'.$passengerAge : $passengerAge;

                      $passName = strtoupper(trim($passenger->passengerName));
                      $passNameArr = explode (" ", $passName);

                      if(count($passNameArr) == 1) {
                          $surname = $passName;
                          $givenName = $passName;
                      } else {
                          $givenName = array_shift($passNameArr);
                          if(count($passNameArr) > 0) {
                              $surname = implode("", $passNameArr);
                          } else {
                              $surname = $givenName;
                          }
                      }

                      $remarksPassenger .= "Name : ".$givenName. " ".$surname;
                      $remarksPassenger .= "; Passport No : ".$passenger->passengerPassportNo.", Passport Expiry Date: ". $passenger->passengerPassportExpiryDate.";";



                      /*$givenName = strtoupper(trim($passenger->passenger_givenname));
                      $surname = strtoupper(trim($passenger->passenger_surname));
                      $arrGN = explode(" ", $givenName);
                      if (count($arrGN)) {
                          $givenName = implode("", $arrGN);
                      }
                      $arrSN = explode(" ", $surname);
                      if (count($arrSN)) {
                          $surname = implode("", $arrSN);
                      }*/

                      /* get country code of passport and citizenship */
                      $nationalitycountryCode = "";
                      $passissuecountryCode = "";
                      $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

                      //query mysql
                      $queryRes = mysqli_query(
                          $connection,
                          "
                              SELECT * FROM country WHERE country_name = '".$passenger->passengerPassportIssueCountry."' LIMIT 0,1
                          "
                      );
                      if( mysqli_num_rows($queryRes) > 0 ) {
                          $queryRow = mysqli_fetch_array($queryRes, MYSQL_ASSOC);
                          $nationalitycountryCode = $queryRow["country_code"];
                      }

                      //query mysql
                      $queryRes = mysqli_query(
                          $connection,
                          "
                              SELECT * FROM country WHERE country_name = '".$passenger->passengerNationality."' LIMIT 0,1
                          "
                      );
                      if( mysqli_num_rows($queryRes) > 0 ) {
                          $queryRow = mysqli_fetch_array($queryRes, MYSQL_ASSOC);
                          $passissuecountryCode =  $queryRow["country_code"];
                      }
                      /* END */

                      $gender = strtolower($passenger->passengerTitle) == 'mr' || strtolower($passenger->passengerTitle) == 'master'  || strtolower($passenger->passengerTitle) == 'mstr' ? 'M' : 'F';


                      switch($passenger->passengerType) {
                          case 'ADULT' :
                              $passengerRemarksInfo.= '<Remark Code="H" SegmentNumber="A" Type="General">
                                  <Text>'.($passenger->passenger_remarks != ''? $passenger->passenger_remarks.'-'.$counter_number.'.1' : 'No Remarks').'</Text>
                              </Remark>';

                              if ($tempIPNN == '') {
                                  $tempIPNN = $counter_number.'.1';
                                  $infantParentNameNumber = $tempIPNN;
                              }
                              /* get contact person country phone code based nationality */
                              /*$queryRes = mysqli_query(
                                  $connection,
                                  "
                                      SELECT * FROM countries WHERE nicename = '".$contactPerson_nationality."' LIMIT 0,1
                                  "
                              );
                              if( mysqli_num_rows($queryRes) > 0 ) {
                                  $queryRow = mysqli_fetch_array($queryRes, MYSQL_ASSOC);
                                  $phoneCodeArea = $queryRow["phonecode"];
                              }*/

                              $specialServicePassengerInfo .= '<AdvancePassenger SegmentNumber="A">
                                  <Document ExpirationDate="'.$passenger->passengerPassportExpiryDate.'" Number="'.$passenger->passengerPassportNo.'" Type="P">
                                      <IssueCountry>'.$passissuecountryCode.'</IssueCountry>
                                      <NationalityCountry>'.$nationalitycountryCode.'</NationalityCountry>
                                  </Document>
                                  <PersonName DateOfBirth="'.$dob.'" Gender="'.$gender.'" NameNumber="'.$counter_number.'.1" DocumentHolder="true">
                                      <GivenName>'.$givenName.$psgTitle.'</GivenName>';
                              /*if($middleName != "") {
                                  $specialServicePassengerInfo .= '<MiddleName>'.$middleName.'</MiddleName>';
                              }*/
                              $specialServicePassengerInfo .= '<Surname>'.$surname.'</Surname>
                                                                  </PersonName>
                                                              </AdvancePassenger>';
                              $secureServicePassengerInfo .= '<SecureFlight SegmentNumber="A">
                                <PersonName DateOfBirth="'.$dob.'" Gender="'.$gender.'" NameNumber="'.$counter_number.'.1">
                                    <GivenName>'.$givenName.'</GivenName>
                                    <Surname>'.$surname.'</Surname>
                                </PersonName>
                                <VendorPrefs>
                                    <Airline Hosted="false"/>
                                </VendorPrefs>
                            </SecureFlight>';

                              /*$serviceAdultInfo .= '
                              <Service SSR_Code="OSI" >
                                  <PersonName NameNumber="'.$counter_number.'.1" />
                                  <Text>PASSENGER NAME SHOULD BE '.$surname.'/'.$givenName.' '.$psgTitle.'</Text>

                                  <VendorPrefs>
                                      <Airline Code="'.$flgCode.'" Hosted="false"/>
                                  </VendorPrefs>
                              </Service>';*/

                              $phoneNumber = preg_replace('/[^0-9]/','',$contactPerson_phone);

                              if(strlen($phoneNumber) > 10) {
                                  $countryCode = substr($phoneNumber, 0, strlen($phoneNumber)-10);
                                  $areaCode = substr($phoneNumber, -10, 3);
                                  $nextThree = substr($phoneNumber, -7, 3);
                                  $lastFour = substr($phoneNumber, -4, 4);

                                  $phoneNumber = $areaCode.$nextThree.'-'.$lastFour;
                              }
                              else if(strlen($phoneNumber) == 10) {
                                  $areaCode = substr($phoneNumber, 0, 3);
                                  $nextThree = substr($phoneNumber, 3, 3);
                                  $lastFour = substr($phoneNumber, 6, 4);

                                  $phoneNumber = $areaCode.$nextThree.'-'.$lastFour;
                              }
                              else if(strlen($phoneNumber) > 7 && strlen($phoneNumber) < 10) {
                                  $nextThree = substr($phoneNumber, 0, 3);
                                  $lastFour = substr($phoneNumber, 3, 5);

                                  $phoneNumber = $nextThree.'-'.$lastFour;
                              }
                              else if(strlen($phoneNumber) == 7) {
                                  $nextThree = substr($phoneNumber, 0, 3);
                                  $lastFour = substr($phoneNumber, 3, 4);

                                  $phoneNumber = $nextThree.'-'.$lastFour;
                              }

                              /*$contactNumberInfo .= '<ContactNumber NameNumber="'.$counter_number.'.1" Phone="9 '.$phoneNumber.' '.$passenger->passengerTitle.' '.$givenName.' '.$surname.'" PhoneUseType="H" />';*/
                              $contactNumberInfo .= '<ContactNumber NameNumber="'.$counter_number.'.1" Phone="'.$phoneNumber.'" PhoneUseType="H" />';
                              $contactEmailInfo = '<Email Address="'.$contactPerson_email.'" NameNumber="'.$counter_number.'.1" ShortText="CTC Ticket" Type="BC"></Email>';
                              $personInfo .= '<PersonName '.$isInfant.' NameNumber="'.$counter_number.'.1" PassengerType="'.$pdtype.'">
                                  <GivenName>'.$givenName.$psgTitle.'</GivenName>
                                  <Surname>'.$surname.'</Surname>
                              </PersonName>';

                              break;
                          case 'CHILD' :
                              $passengerRemarksInfo.= '<Remark Code="H" SegmentNumber="A" Type="General">
                                  <Text>'.($passenger->passenger_remarks != ''? $passenger->passenger_remarks.'-'.$counter_number.'.1' : 'No Remarks').'</Text>
                              </Remark>';

                              $pdtype = 'CNN';//CNN
                              $nameRef = 'NameReference="C'.$passengerAge.'"';
                              $specialServicePassengerInfo .= '<AdvancePassenger SegmentNumber="A">
                              <Document ExpirationDate="'.$passenger->passengerPassportExpiryDate.'" Number="'.$passenger->passengerPassportNo.'" Type="P">
                                  <IssueCountry>'.$passissuecountryCode.'</IssueCountry>
                                  <NationalityCountry>'.$nationalitycountryCode.'</NationalityCountry>
                              </Document>
                              <PersonName DateOfBirth="'.$dob.'" Gender="'.$gender.'" NameNumber="'.$counter_number.'.1" >
                                  <GivenName>'.$givenName.$psgTitle.'</GivenName>';
                              /*if($middleName != "") {
                                  $specialServicePassengerInfo .= '<MiddleName>'.$middleName.'</MiddleName>';
                              }*/
                              $specialServicePassengerInfo .= '<Surname>'.$surname.'</Surname>
                                                              </PersonName>
                                                          </AdvancePassenger>';
                              $secureServicePassengerInfo .= '<SecureFlight SegmentNumber="A" >
                                  <PersonName DateOfBirth="'.$dob.'" Gender="'.$gender.'" NameNumber="'.$counter_number.'.1">
                                      <GivenName>'.$givenName.'</GivenName>
                                      <Surname>'.$surname.'</Surname>
                                  </PersonName>
                                  <VendorPrefs>
                                  <Airline Hosted="false"/></VendorPrefs>
                              </SecureFlight>';
                              $serviceChildrenInfo .=
                                  /*<Service SSR_Code="CHLD" >
                                      <PersonName NameNumber="'.$counter_number.'.1" />
                                      <Text>'.strtoupper(date("dMy", strtotime($dob))).'</Text>
                                  </Service>';
                                  <Service SSR_Code="OSI" >
                                  <PersonName NameNumber="'.$counter_number.'.1" />
                                  <Text>PASSENGER NAME SHOULD BE '.$surname.'/'.$givenName.' '.$psgTitle.'</Text>
                                  <VendorPrefs>
                                      <Airline Code="'.$flightCode.'" />
                                  </VendorPrefs>
                              </Service>
                              */

                              /*<Service SSR_Code="OSI">
                                  <PersonName NameNumber="'.$counter_number.'.1" />
                                  <Text>PASSENGER NAME SHOULD BE '.$surname.'/'.$givenName.' '.$psgTitle.'</Text>

                                  <VendorPrefs>
                                      <Airline Code="'.$flgCode.'" Hosted="false"/>
                                  </VendorPrefs>
                              </Service>*/
                              '
                              <Service SSR_Code="CHLD" SegmentNumber="A">
                                  <PersonName NameNumber="'.$counter_number.'.1"  />
                                  <Text>'.strtoupper(date("dMy", strtotime($dob))).'</Text>
                                  <VendorPrefs>
                                      <Airline Hosted="false" />
                                    </VendorPrefs>
                              </Service>
                              ';

                              $personInfo .= '<PersonName '.$isInfant.' NameNumber="'.$counter_number.'.1" PassengerType="'.$pdtype.'" '.$nameRef.'>
                                  <GivenName>'.$givenName.$psgTitle.'</GivenName>
                                  <Surname>'.$surname.'</Surname>
                              </PersonName>';

                              break;
                          case 'INFANT' :
                              $passengerRemarksInfo.= '<Remark Code="H" SegmentNumber="A" Type="General">
                                  <Text>'.($passenger->passenger_remarks != ''? $passenger->passenger_remarks .'-'.$counter_number.'.1' : 'No Remarks').'</Text>
                              </Remark>';

                              $pdtype = 'INF';
                              $isInfant = 'Infant="true"';
                              $passengerAge = $passengerAge == "00" ? "01" : $passengerAge;
                              $nameRef = 'NameReference="I'.$passengerAge.'"';
                              $gender = strtolower($passenger->passengerTitle) == 'mr' || strtolower($passenger->passengerTitle) == 'master' ? 'MI' : 'FI';
                              $specialServicePassengerInfo .= '<AdvancePassenger SegmentNumber="A">
                                                              <Document ExpirationDate="'.$passenger->passengerPassportExpiryDate.'" Number="'.$passenger->passengerPassportNo.'" Type="P">
                                                                  <IssueCountry>'.$passissuecountryCode.'</IssueCountry>
                                                                  <NationalityCountry>'.$nationalitycountryCode.'</NationalityCountry>
                                                              </Document>
                                                              <PersonName DateOfBirth="'.$dob.'" Gender="'.$gender.'" NameNumber="'.$infantParentNameNumber.'" >
                                                                  <GivenName>'.$givenName.$psgTitle.'</GivenName>';
                                /*if($middleName != "") {
                                  $specialServicePassengerInfo .= '<MiddleName>'.$middleName.'</MiddleName>';
                                }*/
                                $specialServicePassengerInfo .= '<Surname>'.$surname.'</Surname>
                                                              </PersonName>
                                                          </AdvancePassenger>';
                                $secureServicePassengerInfo .= '<SecureFlight SegmentNumber="A" >
                                  <PersonName DateOfBirth="'.$dob.'" Gender="'.$gender.'" NameNumber="'.$infantParentNameNumber.'">
                                      <GivenName>'.$givenName.'</GivenName>
                                      <Surname>'.$surname.'</Surname>
                                  </PersonName>
                                  <VendorPrefs>
                                  <Airline Hosted="false"/></VendorPrefs>
                              </SecureFlight>';

                              /*<Service SSR_Code="OSI" >
                                  <PersonName NameNumber="'.$counter_number.'.1" />
                                  <Text>PASSENGER NAME SHOULD BE '.$surname.'/'.$givenName.' '.$psgTitle.'</Text>
                                  <VendorPrefs>
                                      <Airline Code="'.$flgCode.'" Hosted="false"/>
                                  </VendorPrefs>
                              </Service>*/

                              /*
                              <Service SSR_Code="OSI" >
                                      <PersonName NameNumber="'.$infantParentNameNumber.'" />
                                      <Text>PASSENGER NAME SHOULD BE '.$surname.'/'.$givenName.' '.$psgTitle.'</Text>

                                      <VendorPrefs>
                                          <Airline Code="'.$flgCode.'" Hosted="false"/>
                                      </VendorPrefs>
                                  </Service>*/

                              $serviceInfantInfo .= '
                                  <Service SegmentNumber="A" SSR_Code="INFT">
                                      <PersonName NameNumber="'.$infantParentNameNumber.'" />
                                      <Text>'.strtoupper($surname).'/'.strtoupper($givenName).' '.$psgTitle.'/'.strtoupper(date("dMy", strtotime($dob))).'</Text>
                                      <VendorPrefs>
                                        <Airline Hosted="false" />
                                      </VendorPrefs>
                                  </Service>';

                              $personInfo .= '<PersonName '.$isInfant.' NameNumber="'.$counter_number.'.1" PassengerType="'.$pdtype.'" '.$nameRef.'>
                                  <GivenName>'.$givenName.$psgTitle.'</GivenName>
                                  <Surname>'.$surname.'</Surname>
                              </PersonName>';
                              break;
                          case 'STUDENT' :
                              break;
                          case 'AGENT' :
                              break;
                          case 'TOURS' :
                              break;
                          case 'MILITARY' :
                              break;
                              default : break;
                      }
                      $counter_number++;
                  }

                  $specialServicePassengerInfo .= $secureServicePassengerInfo . $serviceAdultInfo . $serviceChildrenInfo . $serviceInfantInfo;

                  //EndTransaction Ind=false to return no PNR
                  $PDBookRQ = '<PassengerDetailsRQ xmlns="http://services.sabre.com/sp/pd/v3_3" version="3.3.0" IgnoreOnError="false" HaltOnError="true" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
                      <PostProcessing IgnoreAfter="false" RedisplayReservation="true" UnmaskCreditCard="true" xmlns="http://services.sabre.com/sp/pd/v3_3">
                          <EndTransactionRQ>
                              <EndTransaction Ind="true" />
                              <Source ReceivedFrom="CTC TRAVEL"/>
                          </EndTransactionRQ>
                       </PostProcessing>
                      <PreProcessing xmlns="http://services.sabre.com/sp/pd/v3_3" IgnoreBefore="false">
                          <UniqueID ID="" />
                      </PreProcessing>
                      <PriceQuoteInfo>
                          '.$priceQuoteInfo.'
                      </PriceQuoteInfo>
                      <SpecialReqDetails>
                      <AddRemarkRQ>
                          <RemarkInfo>
                              '.$passengerRemarksInfo.'
                          </RemarkInfo>
                      </AddRemarkRQ>
                          <SpecialServiceRQ>
                              <SpecialServiceInfo>
                                  '.$specialServicePassengerInfo.'
                              </SpecialServiceInfo>
                          </SpecialServiceRQ>
                      </SpecialReqDetails>
                      <TravelItineraryAddInfoRQ xmlns="http://services.sabre.com/sp/pd/v3_3">
                          <AgencyInfo>
                                <Address>
                                      <AddressLine>COMMONWEALTH TRAVEL SERVICE CORPORATION PTE LTD</AddressLine>
                                      <CityName>CHINATOWN POINT, SINGAPORE</CityName>
                                      <CountryCode>SG</CountryCode>
                                      <PostalCode>059413</PostalCode>
                                      <StreetNmbr>133 NEW BRIDGE ROAD 03-03</StreetNmbr>
                                  </Address>
                              <Ticketing TicketType="7TAW"/>
                          </AgencyInfo>
                          <CustomerInfo>
                              <ContactNumbers>
                                  '.$contactNumberInfo.'
                              </ContactNumbers>
                              '.$contactEmailInfo.'
                              '.$personInfo.'
                          </CustomerInfo>
                      </TravelItineraryAddInfoRQ>
                  </PassengerDetailsRQ>';
                 /* end PD true */
                  //$xml = $service->Execute("PassengerDetailsRQ",$PDBookRQ, 'OTA', 'Air');

                  $xml = $service->Execute("PassengerDetailsRQ",$PDBookRQ, 'OTA', 'Air');
                  /*
                  echo '1<br>';
                  echo '<xmp>'.$EnhancedAirBookRQ.'</xmp>';
                  echo '<xmp>'.$PDBookRQ.'</xmp>';
                  if( $xml ) {
                      $parseResult = simplexml_load_string($xml);
                      $arrayFinal  = json_decode(json_encode($parseResult), true);
                      var_dump($arrayFinal);
                  } else {
                    echo htmlspecialchars($service->error);
                  }
                  die();*/

                  if( $xml ) {
                      $parseResult = simplexml_load_string($xml);
                      $arrayFinal  = json_decode(json_encode($parseResult), true);

                      $countAF = count($arrayFinal);
                      /*
                      echo $xml;
                      echo '<pre>';
                      var_dump($parseResult);
                      var_dump($arrayFinal);
                      */

                      $txt  = "[".date("Y-m-d H:i:s")."] [Multi-PD][PD] Output ". print_r($arrayFinal, true);
                      $txt  .= "[".date("Y-m-d H:i:s")."] [Multi-PD][PD] XML ". $xml;

                      //log file
                      $myfile = fopen(sinstanceurl."assets/api-logs/logs.txt", "a") or die("Unable to open file!");
                      // $txt  = "[".date("Y-m-d H:i:s")."] - ".$output;
                      fwrite($myfile, "\n". $txt);
                      fclose($myfile);

                      return $countAF && array_key_exists('ItineraryRef', $arrayFinal) ? $arrayFinal['ItineraryRef']['@attributes']['ID'] : 'error';
                  } else {
                      $txt  = "[".date("Y-m-d H:i:s")."] [Multi-PD][EAB1] ". htmlspecialchars($service->error);
                      //log file
                      $myfile = fopen(sinstanceurl."assets/api-logs/logs.txt", "a") or die("Unable to open file!");
                      // $txt  = "[".date("Y-m-d H:i:s")."] - ".$output;
                      fwrite($myfile, "\n". $txt);
                      fclose($myfile);
                      return false;
                  }
                } else {
                  $txt  = "[".date("Y-m-d H:i:s")."] [Multi-PD][PD] No Passenger Details";

                  //log file
                  $myfile = fopen(sinstanceurl."assets/api-logs/logs.txt", "a") or die("Unable to open file!");
                  // $txt  = "[".date("Y-m-d H:i:s")."] - ".$output;
                  fwrite($myfile, "\n". $txt);
                  fclose($myfile);
                  return 'error';
                }
            }
            else {
                $txt  = "[".date("Y-m-d H:i:s")."] [Multi-PD][PD-2]". htmlspecialchars($service->error);

                //log file
                $myfile = fopen(sinstanceurl."assets/api-logs/logs.txt", "a") or die("Unable to open file!");
                // $txt  = "[".date("Y-m-d H:i:s")."] - ".$output;
                fwrite($myfile, "\n". $txt);
                fclose($myfile);
                return 'error';
           }
        }
        else {
            $txt  = "[".date("Y-m-d H:i:s")."] [Multi-PD][EAB3] ". htmlspecialchars($service->error);
            //log file
            $myfile = fopen(sinstanceurl."assets/api-logs/logs.txt", "a") or die("Unable to open file!");
            // $txt  = "[".date("Y-m-d H:i:s")."] - ".$output;
            fwrite($myfile, "\n". $txt);
            fclose($myfile);
            return false;
        }
    }
    else {
      $txt  = "[".date("Y-m-d H:i:s")."] [Multi-PD][EAB4] ". htmlspecialchars($service->error);
      //log file
      $myfile = fopen(sinstanceurl."assets/api-logs/logs.txt", "a") or die("Unable to open file!");
      // $txt  = "[".date("Y-m-d H:i:s")."] - ".$output;
      fwrite($myfile, "\n". $txt);
      fclose($myfile);
      return false;
        //echo '4 - '.htmlspecialchars($service->error);
    }


}
/* end 15 maret 2017 bto */
function testFl($destinationLocation, $originLocation, $departureDate, $adultNo, $childNo, $infantNo, $flightClass)
{
    $seatRequested = $adultNo+$childNo;//+$infantNo;
    $childExist  = "";
    $infantExist = "";
    if( $childNo != 0 ) {
        $childExist = '<PassengerTypeQuantity Code="CNN" Quantity="'.$childNo.'" />';
    }
    if( $infantNo != 0 ) {
        $infantExist = '<PassengerTypeQuantity Code="INF" Quantity="'.$infantNo.'" />';
    }
    $service = new SWSWebService("ihsan.tay@ctc.com.sg","8888","CTC78866","8HYD","https://webservices.sabre.com/websvc");
    if($service->SessionCreate())
    {
       if($service->SessionValidate())
       {
           $OTA_AirLowFareSearchRQ = '
                <OTA_AirLowFareSearchRQ xmlns="http://www.opentravel.org/OTA/2003/05" ResponseType="OTA" Version="3.4.0" AvailableFlightsOnly="true">
                    <POS>
                        <Source PseudoCityCode="8HYD">
                            <RequestorID ID="1" Type="1">
                                <CompanyName Code="TN" />
                            </RequestorID>
                        </Source>
                    </POS>
                    <OriginDestinationInformation RPH="1">
                        <DepartureDateTime>'.$departureDate.'</DepartureDateTime>
                        <OriginLocation LocationCode="'.$originLocation.'" />
                        <DestinationLocation LocationCode="'.$destinationLocation.'" />
                        <TPA_Extensions>
                            <SegmentType Code="O" />
                            <IncludeVendorPref Code="AA"/>
                            <IncludeVendorPref Code="AC"/>
                            <IncludeVendorPref Code="AF"/>
                            <IncludeVendorPref Code="AI"/>
                            <IncludeVendorPref Code="BA"/>
                            <IncludeVendorPref Code="BI"/>
                            <IncludeVendorPref Code="BR"/>
                            <IncludeVendorPref Code="CA"/>
                            <IncludeVendorPref Code="CI"/>
                            <IncludeVendorPref Code="CX"/>
                            <IncludeVendorPref Code="CZ"/>
                            <IncludeVendorPref Code="DG"/>
                            <IncludeVendorPref Code="DL"/>
                            <IncludeVendorPref Code="EK"/>
                            <IncludeVendorPref Code="EY"/>
                            <IncludeVendorPref Code="FJ"/>
                            <IncludeVendorPref Code="GA"/>
                            <IncludeVendorPref Code="GF"/>
                            <IncludeVendorPref Code="IT"/>
                            <IncludeVendorPref Code="JL"/>
                            <IncludeVendorPref Code="KE"/>
                            <IncludeVendorPref Code="KL"/>
                            <IncludeVendorPref Code="LA"/>
                            <IncludeVendorPref Code="LH"/>
                            <IncludeVendorPref Code="LX"/>
                            <IncludeVendorPref Code="MF"/>
                            <IncludeVendorPref Code="MH"/>
                            <IncludeVendorPref Code="MI"/>
                            <IncludeVendorPref Code="MK"/>
                            <IncludeVendorPref Code="MU"/>
                            <IncludeVendorPref Code="NH"/>
                            <IncludeVendorPref Code="NZ"/>
                            <IncludeVendorPref Code="OD"/>
                            <IncludeVendorPref Code="OZ"/>
                            <IncludeVendorPref Code="PG"/>
                            <IncludeVendorPref Code="PR"/>
                            <IncludeVendorPref Code="PX"/>
                            <IncludeVendorPref Code="QF"/>
                            <IncludeVendorPref Code="QR"/>
                            <IncludeVendorPref Code="QV"/>
                            <IncludeVendorPref Code="SK"/>
                            <IncludeVendorPref Code="SQ"/>
                            <IncludeVendorPref Code="SU"/>
                            <IncludeVendorPref Code="TG"/>
                            <IncludeVendorPref Code="TK"/>
                            ';
                      if($infantNo == 0) {
                        $OTA_AirLowFareSearchRQ .= '<IncludeVendorPref Code="TR"/><IncludeVendorPref Code="TT"/>
                            ';}
                          else if($childNo == 0) {
                              $OTA_BargainMaxFinder .= '
                          <IncludeVendorPref Code="OD"/>
                                  ';
                            }
                      else {

                      }
                      $OTA_AirLowFareSearchRQ .= '
                            <IncludeVendorPref Code="TZ"/><IncludeVendorPref Code="UA"/>
                            <IncludeVendorPref Code="UB"/>
                            <IncludeVendorPref Code="UL"/>
                            <IncludeVendorPref Code="VA"/>
                            <IncludeVendorPref Code="VN"/>
                            <IncludeVendorPref Code="WY"/>
                            <IncludeVendorPref Code="8M"/>
                            <IncludeVendorPref Code="9W"/>
                        </TPA_Extensions>
                        </TPA_Extensions>
                    </OriginDestinationInformation>
                    <TravelPreferences ValidInterlineTicket="false" SmokingAllowed="false" ETicketDesired="false" MaxStopsQuantity="2">
                       <CabinPref PreferLevel="Only" Cabin="'.$flightClass.'"/>
                        <TPA_Extensions>
                            <TripType Value="OneWay" />
                            <LongConnectTime Min="780" Max="1200" Enable="true" />
                            <ExcludeCallDirectCarriers Enabled="true" />
                        </TPA_Extensions>
                    </TravelPreferences>
                    <TravelerInfoSummary>
                        <SeatsRequested>'.$seatRequested.'</SeatsRequested>
                        <AirTravelerAvail>
                            <PassengerTypeQuantity Code="ADT" Quantity="'.$adultNo.'" />
                            '.$childExist.'
                            '.$infantExist.'
                        </AirTravelerAvail>
                        <PriceRequestInformation NegotiatedFaresOnly="false" CurrencyCode="SGD">
                        </PriceRequestInformation>
                    </TravelerInfoSummary>
                    <TPA_Extensions>
                        <IntelliSellTransaction>
                            <RequestType Name="150ITINS" />
                            <CompressResponse Value="false"/>
                        </IntelliSellTransaction>
                    </TPA_Extensions>
                </OTA_AirLowFareSearchRQ>​';
            $xml = $service->Execute("BargainFinderMaxRQ",$OTA_AirLowFareSearchRQ,"OTA","Air");
            echo '<xmp>'.$OTA_AirLowFareSearchRQ.'</xmp>';

            $parseResult            = simplexml_load_string($xml);
              $arrayFinalFlight       = json_decode(json_encode($parseResult), true);

              echo '<pre>';
              var_dump($arrayFinalFlight);
              die();

            if( $xml ) {

                //$result_test = XMLtoArray($xml);
                return $xml;
            }
            else {
                echo  htmlspecialchars($service->error);
            }
        }
        else {
            echo htmlspecialchars($service->error);
       }
    }
    else {
        echo htmlspecialchars($service->error);
    }
}
function book_flight_segmentRETURN(
                $dateFrom, $timeFrom, $destinationLocationCode, $flightCode, $flightNo, $originLocationCode,
                $ArrivaldateFrom, $ArrivaltimeFrom,
                $ArrivaldestinationLocationCode, $ArrivalflightCode, $ArrivalflightNo,
                $ArrivaloriginLocationCode,
                $totalAdult, $totalChild, $totalInfant, $marriageGroup, $flightClass, $passengerDetails,
                $PNR_ID = "",
                $contactPerson_email,
                $contactPerson_phone
            )
{
    //header("Content-type: text/xml");
    $numberInParty     = $totalAdult+$totalChild+$totalInfant;
    $childExist        = "";
    $infantExist       = "";
    if( $totalChild != 0 ) {
        $childExist = '<PassengerTypeQuantity Code="C07" Quantity="'.$totalChild.'" />';
    }
    if( $totalInfant != 0 ) {
        $infantExist = '<PassengerTypeQuantity Code="INS" Quantity="'.$totalInfant.'" />';
    }
    $service = new SWSWebService("ihsan.tay@ctc.com.sg","8888","CTC78866","8HYD","https://webservices.sabre.com/websvc");
    if($service->SessionCreate())
    {
        if($service->SessionValidate())
        {
            $EnhancedAirBookRQ = '
                    <EnhancedAirBookRQ HaltOnError="true" version="3.7.0" xmlns="http://services.sabre.com/sp/eab/v3_7">
                         <OTA_AirBookRQ>
                            <HaltOnStatus Code="NO"/>
                            <HaltOnStatus Code="NN"/>
                            <HaltOnStatus Code="UC"/>
                            <HaltOnStatus Code="US"/>
                            <HaltOnStatus Code="UN"/>
                            <HaltOnStatus Code="LL"/>
                            <HaltOnStatus Code="HL"/>
                            <HaltOnStatus Code="WL"/>
                             <OriginDestinationInformation>
                                <FlightSegment DepartureDateTime="'.$dateFrom.'T'.$timeFrom.'" FlightNumber="'.$flightNo.'" NumberInParty="'.$numberInParty.'" ResBookDesigCode="'.$flightClass.'" Status="NN">
                                    <DestinationLocation LocationCode="'.$destinationLocationCode.'" />
                                    <MarketingAirline Code="'.$flightCode.'" FlightNumber="'.$flightNo.'" />
                                    <MarriageGrp>'.$marriageGroup.'</MarriageGrp>
                                    <OperatingAirline Code="'.$flightCode.'" />
                                    <OriginLocation LocationCode="'.$originLocationCode.'"/>
                                </FlightSegment>
                                <FlightSegment DepartureDateTime="'.$ArrivaldateFrom.'T'.$ArrivaltimeFrom.'" FlightNumber="'.$ArrivalflightNo.'" NumberInParty="'.$numberInParty.'" ResBookDesigCode="'.$flightClass.'" Status="NN">
                                    <DestinationLocation LocationCode="'.$ArrivaldestinationLocationCode.'" />
                                    <MarketingAirline Code="'.$ArrivalflightCode.'" FlightNumber="'.$ArrivalflightNo.'" />
                                    <MarriageGrp>'.$marriageGroup.'</MarriageGrp>
                                    <OperatingAirline Code="'.$ArrivalflightCode.'" />
                                    <OriginLocation LocationCode="'.$ArrivaloriginLocationCode.'"/>
                                </FlightSegment>
                            </OriginDestinationInformation>
                            <RedisplayReservation NumAttempts="3" WaitInterval="5000" />
                         </OTA_AirBookRQ>
                         <OTA_AirPriceRQ>
                            <PriceRequestInformation Retain="true">
                               <OptionalQualifiers>
                               <FlightQualifiers>
                                    <VendorPrefs>
                                        <Airline Code="'.$ArrivalflightCode.'"/>
                                    </VendorPrefs>
                                </FlightQualifiers>
                                  <PricingQualifiers>
                                     <PassengerType Code="ADT" Quantity="'.$totalAdult.'" />'
                                     .$childExist.$infantExist.'
                                  </PricingQualifiers>
                               </OptionalQualifiers>
                            </PriceRequestInformation>
                         </OTA_AirPriceRQ>
                        <PostProcessing IgnoreAfter="false" xmlns="http://services.sabre.com/sp/eab/v3_7">
                            <RedisplayReservation/>
                         </PostProcessing>
                        <PreProcessing xmlns="http://services.sabre.com/sp/eab/v3_7" />
                      </EnhancedAirBookRQ>';

            $xml = $service->Execute("EnhancedAirBookRQ",$EnhancedAirBookRQ,'OTA', 'Air');
                if( $xml ) {
                    $parseResult = simplexml_load_string($xml);
                    $arrayFinal  = json_decode(json_encode($parseResult), true);
                    $countArrayFinal = count($arrayFinal);
                    /*echo '<h5>EnhancedAirBookRS</h5>';
                    echo "<pre>";
                    print_r($arrayFinal);
                    echo "</pre>";
                    die();*/

                    /* get passenger detail */
                    $priceQuote = "";
                    $customerContactNumberInfo = '';
                    $customerContactNameInfo = '';
                    $APIs = ""; //advance passenger informations

                    if( $passengerDetails == TRUE ) {
                        $counter_number = 1;
                        $priceQuote = "<PriceQuoteInfo>";
                        $customerContactNumberInfo = '<ContactNumbers>';
                        $emailContact = '';

                        foreach( $passengerDetails AS $passenger ) {
                            $priceQuote .= '<Link HostedCarrier="false" NameNumber="'.$counter_number.'.1" Record="'.$counter_number.'"/>';
                            $ptype = 'ADT';
                            switch($passenger->passengerType) {
                                case 'ADULT' :
                                        $ptype = 'ADT';
                                    break;
                                case 'CHILD' :
                                    $birthdate = new DateTime($passenger->passengerDOB);
                                    $today   = new DateTime('today');
                                    $age = $birthdate->diff($today)->y;
                                    $age = $age < 10 ? '0'.$age : $age;
                                    $ptype = 'C'.$age;
                                    break;
                                case 'INFANT' : $ptype = 'INS';
                                    break;
                                case 'STUDENT' :
                                    break;
                                case 'AGENT' :
                                    break;
                                case 'TOURS' :
                                    break;
                                case 'MILITARY' :
                                    break;
                                    default : break;

                            }

                            /* "PhoneUseType" is used to specify if the number is agency, "A," home, "H," business, "B," or fax, "F." */
                            $emailContact .= '<Email Address="'.$contactPerson_email.'" NameNumber="'.$counter_number.'.1" ShortText="CTC Ticket" Type="BC"/>';
                            $customerContactNumberInfo .= '<ContactNumber NameNumber="'.$counter_number.'.1" Phone="012-555-1212" PhoneUseType="H" />';

                            $passName = $passenger->passengerName;
                            $passNameArr = explode (" ", $passName);
                            $givenName = array_pop($passNameArr);
                            if (count($passNameArr) == 0) {
                                $surname = $givenName;
                            } else {
                                $surname = implode (" ", $passNameArr);
                            }

                            $customerContactNameInfo .= '
                                    <PersonName Infant="false" NameNumber="'.$counter_number.'.1" PassengerType="'.$ptype.'">
                                        <GivenName>'.$givenName.'</GivenName>
                                        <Surname>'.$surname.'</Surname>
                                    </PersonName>
                                    ';

                            $issuecountryCode = "";
                            $passcountryCode = "";
                            $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
                            //query mysql
                            $queryRes = mysqli_query(
                                $connection,
                                "
                                    SELECT * FROM country WHERE country_name = '".$passenger->passengerPassportIssueCountry."' LIMIT 0,1
                                "
                            );
                            if( mysqli_num_rows($queryRes) > 0 ) {
                                $queryRow = mysqli_fetch_array($queryRes, MYSQL_ASSOC);
                                $issuecountryCode = $queryRow["country_code"];
                            }

                            //query mysql
                            $queryRes = mysqli_query(
                                $connection,
                                "
                                    SELECT * FROM country WHERE country_name = '".$passenger->passengerNationality."' LIMIT 0,1
                                "
                            );
                            if( mysqli_num_rows($queryRes) > 0 ) {
                                $queryRow = mysqli_fetch_array($queryRes, MYSQL_ASSOC);
                                $passcountryCode =  $queryRow["country_code"];
                            }

                            $gender = strtolower($passenger->passengerTitle) == 'mr' || strtolower($passenger->passengerTitle) == 'master' ? 'M' : 'F';
                            $APIs .= '<AdvancePassenger SegmentNumber="A">
                                <Document ExpirationDate="'.$passenger->passengerPassportExpiryDate.'" Number="'.$passenger->passengerPassportNo.'" Type="P">
                                    <IssueCountry>'.$issuecountryCode.'</IssueCountry>
                                    <NationalityCountry>'.$passcountryCode.'</NationalityCountry>
                                </Document>
                                <PersonName DateOfBirth="'.$passenger->passengerDOB.'" Gender="'.$gender.'" NameNumber="'.$counter_number.'.1" '. (($passenger->passengerType == 'ADULT' && $counter_number == 1) ? 'DocumentHolder="true"' : '').'>
                                    <GivenName>'.strtoupper($passenger->passengerTitle).' '.$givenName.'</GivenName>
                                    <Surname>'.$surname.'</Surname>
                                </PersonName>
                                <VendorPrefs>
                                    <Airline Hosted="false"/>
                                </VendorPrefs>
                            </AdvancePassenger>';
                            $counter_number++;
                        }
                        $priceQuote .= "</PriceQuoteInfo>";
                        $customerContactNumberInfo .= '</ContactNumbers>';
                    }

                    $agencyTicketType = "7TAW"; // ticket at will;

                    $EnhancedAirBookRQ = '
                        <PassengerDetailsRQ xmlns="http://services.sabre.com/sp/pd/v3_3" version="3.3.0" IgnoreOnError="false" HaltOnError="false" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
                            <PostProcessing IgnoreAfter="false" RedisplayReservation="true" UnmaskCreditCard="true" xmlns="http://services.sabre.com/sp/pd/v3_3">
                                <EndTransactionRQ>
                                    <EndTransaction Ind="true" />
                                    <Source ReceivedFrom="CTC Test TRAVEL"/>
                                </EndTransactionRQ>
                             </PostProcessing>
                            <PreProcessing xmlns="http://services.sabre.com/sp/pd/v3_3" IgnoreBefore="false">
                                <UniqueID ID="" />
                            </PreProcessing>
                            '.$priceQuote.'
                            <SpecialReqDetails>
                                <SpecialServiceRQ>
                                    <SpecialServiceInfo>
                                        '.$APIs.'
                                    </SpecialServiceInfo>
                                </SpecialServiceRQ>
                            </SpecialReqDetails>

                            <TravelItineraryAddInfoRQ xmlns="http://services.sabre.com/sp/pd/v3_3">
                                <AgencyInfo>
                                    <Ticketing TicketType="'.$agencyTicketType.'"/>
                                </AgencyInfo>
                                <CustomerInfo>
                                '.$customerContactNumberInfo.'
                                '.$emailContact.'
                                '.$customerContactNameInfo.'
                                </CustomerInfo>
                            </TravelItineraryAddInfoRQ>
                        </PassengerDetailsRQ>';
                    $xml = $service->Execute("PassengerDetailsRQ",$EnhancedAirBookRQ, 'OTA', 'Air');
                    if( $xml ) {
                        $parseResult = simplexml_load_string($xml);
                        $arrayFinal  = json_decode(json_encode($parseResult), true);

                        //$txt  = "[".date("Y-m-d H:i:s")."] [Multi-PD][SBR] ". print_r($arrayFinal, true);
                        $txt  = "[".date("Y-m-d H:i:s")."] [Multi-PD][SBR]XML : ". $xml;
                        //log file
                        $myfile = fopen(sinstanceurl."assets/api-logs/logs.txt", "a") or die("Unable to open file!");
                        // $txt  = "[".date("Y-m-d H:i:s")."] - ".$output;
                        fwrite($myfile, "\n". $txt);
                        fclose($myfile);
                        //end of log file

                        return $arrayFinal['ItineraryRef']['@attributes']['ID'] ? $arrayFinal['ItineraryRef']['@attributes']['ID'] : '';
                    } else {
                        $txt  = "[".date("Y-m-d H:i:s")."] [Multi-PD][Err1] ". htmlspecialchars($service->error);
                        //log file
                        $myfile = fopen(sinstanceurl."assets/api-logs/logs.txt", "a") or die("Unable to open file!");
                        // $txt  = "[".date("Y-m-d H:i:s")."] - ".$output;
                        fwrite($myfile, "\n". $txt);
                        fclose($myfile);
                        //end of log file
                        return false;
                    }
                }
                else {
                    $txt  = "[".date("Y-m-d H:i:s")."] [Multi-PD][Err2] ". htmlspecialchars($service->error);
                    //log file
                    $myfile = fopen(sinstanceurl."assets/api-logs/logs.txt", "a") or die("Unable to open file!");
                    //$txt  = "[".date("Y-m-d H:i:s")."] - ".$output;
                    fwrite($myfile, "\n". $txt);
                    fclose($myfile);
                    //end of log file
                    return false;
               }
        }
        else {
            $txt  = "[".date("Y-m-d H:i:s")."] [Multi-PD][Err3] ". htmlspecialchars($service->error);
            //log file
            $myfile = fopen(sinstanceurl."assets/api-logs/logs.txt", "a") or die("Unable to open file!");
            //$txt  = "[".date("Y-m-d H:i:s")."] - ".$output;
            fwrite($myfile, "\n". $txt);
            fclose($myfile);
            //end of log file
            return false;

        }
    }
    else {
        //log file
        $myfile = fopen(sinstanceurl."assets/api-logs/logs.txt", "a") or die("Unable to open file!");
        $txt  = "[".date("Y-m-d H:i:s")."] [Multi][Err4] ". htmlspecialchars($service->error);
        fwrite($myfile, "\n". $txt);
        fclose($myfile);
        //end of log file
        return false;
    }
}