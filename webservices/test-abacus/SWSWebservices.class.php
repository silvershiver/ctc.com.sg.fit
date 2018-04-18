<?php
define('PHP_SWS_PATH', (dirname(__FILE__) . "/"));
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
			          ."	<eb:MessageHeader xmlns:eb='http://www.ebxml.org/namespaces/messageHeader'>\n"
			          ."		<eb:From><eb:PartyId eb:type='urn:x12.org.IO5:01'>{$this->from}</eb:PartyId></eb:From>\n"
			          ."		<eb:To><eb:PartyId eb:type='urn:x12.org.IO5:01'>webservices.sabre.com</eb:PartyId></eb:To>\n"
			          ."		<eb:ConversationId>{$this->conversation_id}</eb:ConversationId>\n"
				      ."		<eb:Service eb:type='$eb_type'>$eb_service</eb:Service>\n"
				      ."		<eb:Action>$action</eb:Action>\n"
					  ."        <eb:CPAID>{$this->ipcc}</eb:CPAID>"
			          ."		<eb:MessageData>\n"
		              ."			<eb:MessageId>{$message_id}</eb:MessageId>\n"
				      ."			<eb:Timestamp>{$timestamp}</eb:Timestamp>\n"
  				      ."			<eb:TimeToLive>{$timetolive}</eb:TimeToLive>\n"
		              ."		</eb:MessageData>\n"
					  ."	</eb:MessageHeader>\n"
                      ."	<wsse:Security xmlns:wsse='http://schemas.xmlsoap.org/ws/2002/12/secext'>{$Security}</wsse:Security>\n"
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
		    $rs_dom = DOMDocument::loadXML($response->message);

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

function test()
{
	$service = new SWSWebService("ihsan.tay@ctc.com.sg","8888","CTC78866","8HYD","https://webservices.sabre.com/websvc");
	if($service->SessionCreate())
	{
	   if($service->SessionValidate())
	   {
		   $OTA_AirAvailRQ=<<<EOT
			   <OTA_AirAvailRQ xmlns="http://webservices.sabre.com/sabreXML/2011/10" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" Version="2.3.0">
				   	<OriginDestinationInformation>
				      	<FlightSegment DepartureDateTime="06-21">
				         	<DestinationLocation LocationCode="BKK"/>
						 	<OriginLocation LocationCode="SIN"/>
						</FlightSegment>
					</OriginDestinationInformation>
				</OTA_AirAvailRQ>
EOT;
		  	$xml = $service->Execute("OTA_AirAvailLLSRQ",$OTA_AirAvailRQ,"OTA","Air");
		  	if( $xml ) {
				$abc = htmlspecialchars($xml);
				echo "<pre>";
				print_r(XMLtoArray($xml));
				echo "</pre>";
				/*
				$simple = $xml;
				$p = xml_parser_create();
				xml_parse_into_struct($p, $simple, $vals, $index);
				xml_parser_free($p);
				echo "<pre>";
				print_r($vals);
				echo "</pre>";
				*/
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
test();
?>
