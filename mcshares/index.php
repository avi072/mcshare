
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <title>Upload Xml</title>
  </head>
  <body>

    <div class="container">
        <div class="row">
            <div class="col-md-6 mt-5 mx-auto">
            
                <div class="card ">
                    <div class="card-header text-center ">
                    Upload Xml
                    </div>
                    <div class="card-body">
                        <form action="index.php" method="post" enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="custom-file">
                                    <input type="file" name="xml_file" id="xml_file" class="custom-file-input" id="customFile">
                                    <label class="custom-file-label" for="customFile" >Choose Xml File</label>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary mt-3 text-left">Upload</button>
                            </div>
                        </form>
                        <script>
                            $('.custom-file-input').on('change', function() { 
                                let fileName = $(this).val().split('\\').pop(); 
                                $(this).next('.custom-file-label').addClass("selected").html(fileName); 
                            });
                        </script>

                        <?php
                            // show error reporting
                            ini_set('display_errors', 1);
                            error_reporting(E_ALL);

                            require 'class/validateXml.class.php';
                            require 'class/dataBase.class.php';
                            require 'class/addXmldetails.class.php';
                            require 'class/addCustomer.class.php';
                            require 'class/addContactdetails.class.php';
                            require 'class/addmailaddres.class.php';
                            require 'class/addSharesdetails.class.php';
                            require 'class/adderror.class.php';

                            if(isset($_FILES['xml_file']))
                            {
                                //db connection
                                $database = new Database();
                                $db = $database->getConnection();
                                $adderror = new Adderror($db);

                                $xml = new ValidateXml();
                                $checkXml = $xml->validateFile($_FILES['xml_file']);

                                

                                if ($checkXml[0]!='SUCCESS')
                                {
                                    //error with the file
                                    $adderror->error_code =$checkXml[0];
                                    $adderror->message =$checkXml[1];

                                    if ($adderror->inserterror())
                                    {
                                        $adderror->errormessage($checkXml[0]);
                                    }
                                    
                                }
                                else 
                                {
                                    // xml upload 
                                    $xmlPath = $xml->UploadXml($_FILES['xml_file']);

                                    //convert xml to array
                                    $xmlArray = $xml->convertxmltoarray($xmlPath);

                                    //check if xmlarray has column reqired
                                    $checkcolumn= $xml->readXml($xmlArray);

                                    if ($checkcolumn[0]!='SUCCESS')
                                    {
                                        //insert into error table

                                        //error with the file
                                        $adderror->error_code =$checkcolumn[0];
                                        $adderror->message =$checkcolumn[1];
                                        if ($adderror->inserterror())
                                        {
                                            $adderror->errormessage($checkcolumn[0]);
                                        }

                                    }
                                    else
                                    {
                                        //insert xml details
                                        $addXmldetails = new AddXmlDetails($db);
                                        $doc_date_convert = DateTime::createFromFormat('d/m/Y H:i:s A', $xmlArray['doc_date']);
                                        $doc_date = (string)$doc_date_convert->format('Y-m-d H:i:s');
                                        $addXmldetails->doc_name = $_FILES['xml_file']['name'];
                                        $addXmldetails->doc_date = $doc_date;
                                        $addXmldetails->doc_ref = $xmlArray['doc_ref'];
                                        $insertXmldetails = $addXmldetails->insertxmldetails();

                                        if($insertXmldetails == true)
                                        {
                                            $arrayDataItem_Customer = $xmlArray['doc_data']['dataitem_customer'];

                                            for ($i=0; $i < sizeof($arrayDataItem_Customer) ; $i++)
                                            { 
                                                $customer_id = $arrayDataItem_Customer[$i]['customer_id'];
                                                $customer_type = $arrayDataItem_Customer[$i]['customer_type'];
                                                $date_of_birth = $arrayDataItem_Customer[$i]['date_of_birth'];
                                                $date_incorp = $arrayDataItem_Customer[$i]['date_incorp'];
                                                $registration_no = $arrayDataItem_Customer[$i]['registration_no'];
                                                $mailing_address = $arrayDataItem_Customer[$i]['mailing_address'];
                                                $contact_details = $arrayDataItem_Customer[$i]['contact_details'];
                                                $shares_details = $arrayDataItem_Customer[$i]['shares_details'];
                                                $num_shares = (int)$shares_details['num_shares'];
                                                $share_price = $shares_details['share_price'];

                                                if($xml->validateCustomer($date_of_birth) && $xml->validateNumbershare($num_shares) && $xml->validateShareprice($share_price))
                                                {
                                                    $addcustomer = new Addcustomer($db);
                                                    $addcustomer->customer_id = is_array($customer_id) ? '' : $customer_id;
                                                    $addcustomer->customer_type = is_array($customer_type) ? '' : $customer_type;
                                                    $addcustomer->date_of_birth = is_array($date_of_birth) ? '' : date("Y-m-d", strtotime(str_replace('/', '-', $date_of_birth)));
                                                    $addcustomer->date_incorp = is_array($date_incorp) ? '' : date("Y-m-d", strtotime(str_replace('/', '-', $date_of_birth)));
                                                    $addcustomer->registration_no = is_array($registration_no) ? '' : $registration_no;
                                                    $insertCustomer = $addcustomer->insertcustomer();

                                                    if($insertCustomer == true)
                                                    {
                                                        if(!empty($mailing_address))
                                                        {
                                                            $addmailaddres = new Addmailaddres($db);
                                                            $addmailaddres->customer_id = is_array($customer_id) ? '' : $customer_id;
                                                            $addmailaddres->address_line1 = is_array($mailing_address['address_line1']) ? '' : $mailing_address['address_line1'];
                                                            $addmailaddres->address_line2 = is_array($mailing_address['address_line2']) ? '' : $mailing_address['address_line2'];
                                                            $addmailaddres->town_city = is_array($mailing_address['town_city']) ? '' : $mailing_address['town_city'];
                                                            $addmailaddres->country = is_array($mailing_address['country']) ? '' : $mailing_address['country'];
                                                            $insertMailaddres = $addmailaddres->insertmailaddres();
                                                        }

                                                        if(!empty($contact_details))
                                                        {
                                                            $addcontactdetails = new Addcontactdetails($db);
                                                            $addcontactdetails->customer_id = is_array($customer_id) ? '' : $customer_id;
                                                            $addcontactdetails->contact_name = is_array($contact_details['contact_name']) ? '' : $contact_details['contact_name'];
                                                            $addcontactdetails->contact_number = is_array($contact_details['contact_number']) ? '' : $contact_details['contact_number'];
                                                            $insertContactdetails = $addcontactdetails->insertcontactdetails();
                                                        }

                                                        if(!empty($shares_details))
                                                        {
                                                            $addsharesdetails = new Addsharedetails($db);
                                                            $addsharesdetails->customer_id = is_array($customer_id) ? '' : $customer_id;
                                                            $addsharesdetails->num_shares = is_array($shares_details['num_shares']) ? '' : $shares_details['num_shares'];
                                                            $addsharesdetails->share_price = is_array($shares_details['share_price']) ? '' : $shares_details['share_price'];
                                                            $insertContactdetails = $addsharesdetails->insertsharedetails();
                                                        }

                                                        $adderror->successmessage($checkcolumn[1]);

                                                    }
                                                
                                                }

                                            }

                                        }

                                    }

                                }

                            }
                            
                        ?>
                        
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

  </body>
</html>
