<?php
namespace App\Framework\Api;

use App\Logger;

class Rest
{
    public function response($data, $resource = null)
    {
        $headers = getallheaders();
        Logger::debug(print_r($headers, true));
        if (! $headers) {
            $this->toJson($data, $resource);
        }

        $accept = $headers['Accept'] ?? 'application/json';
        if (stripos($accept, 'application/xml') !== false) {
            $this->toXml($data, $resource);
        }
            
        $this->toJson($data, $resource);
        
    }

    /**
     * Convert data array to JSON and output it
     *
     * @param array $data The data to convert
     */
    public function toJson($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Convert data array to XML and output it
     *
     * @param array $data The data to convert
     * @param string|null $resource Optional root element name
     */
    public function toXml($data, $resource = null)
    {
        header('Content-Type: application/xml');
        $root = $resource ? "<{$resource}/>" : '<response/>';
        $xml = new \SimpleXMLElement($root);
        $this->_convertToXml($data, $xml);
        echo $xml->asXML();
        exit;
    }

    /**
     * Helper function to recursively convert an array to XML
     *
     * @param array $data The data to convert
     * @param \SimpleXMLElement $xml The XML element to append data to
     */
    private function _convertToXml($data, \SimpleXMLElement &$xml) 
    {
        foreach ($data as $key => $value) {
            if (is_numeric($key)) {
                $key = "item";
            }

            if (is_array($value)) {
                $subnode = $xml->addChild($key);
                $this->_convertToXml($value, $subnode);
            } else {
                $xml->addChild($key, htmlspecialchars($value));
            }
        }
    }
}