<?php
class ValidateXml{
    private $_suporttedFormats = ['text/xml'];
    private $_suporttedSize = '2097152'; // size 2 MB
    private $_xml_upload_path = 'uploads/';
    private $_customerAge = '18';
    public $_convertXmltoarray = array();
    public $_message = array();
    public $_fileMessage = array();

    public function validateFile($file)
    {

        if (empty($file['type']))
        {
            $this->_fileMessage[0]="400 Bad Request";
            $this->_fileMessage[1]="No file was found";
            return $this->_fileMessage;
        }

        if (in_array($file['type'],$this->_suporttedFormats) == false)
        {
            $this->_fileMessage[0]="415 Unsupported Media Type";
            $this->_fileMessage[1]="Extension not allowed, please choose a xml.";
            return $this->_fileMessage;
        }

        if($file['size'] > $this->_suporttedSize)
        {
            $this->_fileMessage[0]="413 Payload Too Large";
            $this->_fileMessage[1]="File size must be excately 2 MB";
            return $this->_fileMessage;
        }

        if (empty($this->_fileMessage)) 
        {
            $this->_fileMessage[0]="SUCCESS";
            $this->_fileMessage[1]="File can be uploaded";
            return $this->_fileMessage;
        }
        else 
        {
            return $this->_fileMessage;
        }
    }

    public function UploadXml($file_xml)
    {
        move_uploaded_file($file_xml['tmp_name'],$this->_xml_upload_path.$file_xml['name']);
        return pathinfo($this->_xml_upload_path.$file_xml['name']);
    }

    public function convertxmltoarray($path)
    {
        $load_xml = simplexml_load_file($path['dirname'].'/'.$path['basename']);
        $this->_convertXmltoarray = json_decode(json_encode($load_xml), true);

        function array_change_key_case_recursive($arr)
        {
            return array_map(function($item){
                if(is_array($item))
                    $item = array_change_key_case_recursive($item);
                return $item;
            },array_change_key_case($arr));
        }

        return array_change_key_case_recursive($this->_convertXmltoarray);

    }

    public function readXml($doc_array)
    {              
        if (array_key_exists("doc_date",$doc_array) && array_key_exists("doc_ref",$doc_array) && array_key_exists("doc_data",$doc_array) )
        {
            $this->_message[0]="SUCCESS";
            $this->_message[1]="File uploaded!";
            return $this->_message;
        }
        else 
        {
            $this->_message[0]="409 Conflict";
            $this->_message[1]="Column field match";
            return $this->_message;
        }
    }

    public function validateCustomer($dob)
    {
        //check if array is empty
        if (empty($dob))
        {
            return false;
        }
        else
        {
            $birthday = strtotime($dob);
            $ageLimit = strtotime('-18 years');
            if ($birthday < $ageLimit)
            {
                // they're old enough
                return true;
            }
            else
            {
                // too young
                return false;
            } 
        }
        
    }

    public function validateNumbershare($numshares)
    {
        if (empty($numshares))
        {
            return false;
        }
        else
        {
            if(is_int($numshares) ==1 && $numshares > 0 )
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }

    public function validateShareprice($shareprice)
    {
        if (empty($shareprice))
        {
            return false;
        }
        else
        {
            $parts = explode(".", $shareprice);
            $num_decimals = strlen($parts[1]);

            if ($num_decimals == 2 && $shareprice > 0)
            {
                return true;
            }
            else 
            { 
                return false;
            }
        }
    }

}

?>