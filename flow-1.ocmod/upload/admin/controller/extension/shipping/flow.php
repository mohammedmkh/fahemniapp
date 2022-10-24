<?php

class ControllerExtensionShippingFlow extends Controller
{
    private $error = array();

    public function index()
    {
        $this->load->language('extension/shipping/flow');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('shipping_flow', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=shipping',
                true));
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['key'])) {
            $data['error_key'] = $this->error['key'];
        } else {
            $data['error_key'] = '';
        }

        if (isset($this->error['name'])) {
            $data['error_name'] = $this->error['name'];
        } else {
            $data['error_name'] = '';
        }

        if (isset($this->error['email'])) {
            $data['error_email'] = $this->error['email'];
        } else {
            $data['error_email'] = '';
        }

        if (isset($this->error['city'])) {
            $data['error_city'] = $this->error['city'];
        } else {
            $data['error_city'] = '';
        }

        if (isset($this->error['address'])) {
            $data['error_address'] = $this->error['postcode'];
        } else {
            $data['error_address'] = '';
        }

        if (isset($this->error['telephone'])) {
            $data['error_telephone'] = $this->error['telephone'];
        } else {
            $data['error_telephone'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=shipping', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/shipping/flow', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['action'] = $this->url->link('extension/shipping/flow', 'user_token=' . $this->session->data['user_token'], true);

        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=shipping', true);

        if (isset($this->request->post['shipping_flow_key'])) {
            $data['shipping_flow_key'] = $this->request->post['shipping_flow_key'];
        } else {
            $data['shipping_flow_key'] = $this->config->get('shipping_flow_key');
        }

        if (isset($this->request->post['shipping_flow_collection_name'])) {
            $data['shipping_flow_collection_name'] = $this->request->post['shipping_flow_collection_name'];
        } else {
            $data['shipping_flow_collection_name'] = $this->config->get('shipping_flow_collection_name');
        }

        if (isset($this->request->post['shipping_flow_collection_email'])) {
            $data['shipping_flow_collection_email'] = $this->request->post['shipping_flow_collection_email'];
        } else {
            $data['shipping_flow_collection_email'] = $this->config->get('shipping_flow_collection_email');
        }

        if (isset($this->request->post['shipping_flow_collection_city'])) {
            $data['shipping_flow_collection_city'] = $this->request->post['shipping_flow_collection_city'];
        } else {
            $data['shipping_flow_collection_city'] = $this->config->get('shipping_flow_collection_city');
        }

        if (isset($this->request->post['shipping_flow_collection_address'])) {
            $data['shipping_flow_collection_address'] = $this->request->post['shipping_flow_collection_address'];
        } else {
            $data['shipping_flow_collection_address'] = $this->config->get('shipping_flow_collection_address');
        }

        if (isset($this->request->post['shipping_flow_collection_region'])) {
            $data['shipping_flow_collection_region'] = $this->request->post['shipping_flow_collection_region'];
        } else {
            $data['shipping_flow_collection_region'] = $this->config->get('shipping_flow_collection_region');
        }

        if (isset($this->request->post['shipping_flow_collection_postcode'])) {
            $data['shipping_flow_collection_postcode'] = $this->request->post['shipping_flow_collection_postcode'];
        } else {
            $data['shipping_flow_collection_postcode'] = $this->config->get('shipping_flow_collection_postcode');
        }

        if (isset($this->request->post['shipping_flow_collection_telephone'])) {
            $data['shipping_flow_collection_telephone'] = $this->request->post['shipping_flow_collection_telephone'];
        } else {
            $data['shipping_flow_collection_telephone'] = $this->config->get('shipping_flow_collection_telephone');
        }

        if (isset($this->request->post['shipping_flow_live'])) {
            $data['shipping_flow_live'] = $this->request->post['shipping_flow_live'];
        } else {
            $data['shipping_flow_live'] = $this->config->get('shipping_flow_live');
        }

        if (isset($this->request->post['shipping_flow_order_status'])) {
            $data['shipping_flow_order_status'] = $this->request->post['shipping_flow_order_status'];
        } else {
            $data['shipping_flow_order_status'] = $this->config->get('shipping_flow_order_status');
        }

        if (isset($this->request->post['shipping_flow_shipping_order_status'])) {
            $data['shipping_flow_shipping_order_status'] = $this->request->post['shipping_flow_shipping_order_status'];
        } else {
            $data['shipping_flow_shipping_order_status'] = $this->config->get('shipping_flow_shipping_order_status');
        }

        $data['cities'] = $this->cities();

        $this->load->model('localisation/order_status');

        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/shipping/flow', $data));
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/shipping/flow')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (empty($this->request->post['shipping_flow_key'])) {
            $this->error['key'] = $this->language->get('error_key');
        }

        if (empty($this->request->post['shipping_flow_collection_name'])) {
            $this->error['name'] = $this->language->get('error_name');
        }

        if ((utf8_strlen($this->request->post['shipping_flow_collection_email']) > 96) || !filter_var($this->request->post['shipping_flow_collection_email'], FILTER_VALIDATE_EMAIL)) {
            $this->error['email'] = $this->language->get('error_email');
        }

        if (empty($this->request->post['shipping_flow_collection_city'])) {
            $this->error['city'] = $this->language->get('error_city');
        }

        if (empty($this->request->post['shipping_flow_collection_address'])) {
            $this->error['address'] = $this->language->get('error_address');
        }

        if (empty($this->request->post['shipping_flow_collection_telephone']) || !is_numeric($this->request->post['shipping_flow_collection_telephone'])) {
            $this->error['telephone'] = $this->language->get('error_telephone');
        }

        return !$this->error;
    }

    protected function cities()
    {
        if ($this->config->get('shipping_flow_live')) {
            $url = 'https://aymakan.com.sa/api/v2/cities';
        } else {
            $url = 'https://dev.aymakan.com.sa/api/v2/cities';
        }

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($curl), true);

        curl_close($curl);

        if ($response['success']) {

            return $response['data']['cities'];
        }

        return false;

    }

    public function form() {
        $this->load->model('sale/order');

        if (isset($this->request->get['order_id'])) {
            $order_id = $this->request->get['order_id'];
        } else {
            $order_id = 0;
        }

        $this->load->language('extension/shipping/flow');

        $order_info = $this->model_sale_order->getOrder($order_id);

        if ($order_info) {
            $data['customer_name'] = $order_info['shipping_firstname'] . ' ' . $order_info['shipping_lastname'];
            $data['customer_email'] = $order_info['email'];
            $data['customer_address'] = $order_info['shipping_address_1'] . ($order_info['shipping_address_2'] ? ' ' . $order_info['shipping_address_1'] : '');
            $data['customer_region'] = $order_info['shipping_zone'];
            $data['customer_telephone'] = $order_info['telephone'];
            $data['customer_postcode'] = $order_info['shipping_postcode'];
            $data['cities'] = $this->cities();
            $data['reference'] = $order_id;
            $data['order_id'] = $order_id;
            $data['currency'] = $order_info['currency_code'];
            $data['declared_value'] = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);
            $data['delivery_country'] = 'SA';
            $data['is_cod'] = 0;

            $this->load->model('localisation/country');

            $country_info = $this->model_localisation_country->getCountry($order_info['shipping_country_id']);

            if($country_info) {
                $data['delivery_country'] = $country_info ['iso_code_2'];
            }

            $data['items_count'] = 0;
            $products = $this->model_sale_order->getOrderProducts($order_id);

            foreach ($products as $product) {
                $data['items_count'] += $product['quantity'];
            }
            $data['pieces'] = $data['items_count'];

            $this->response->setOutput($this->load->view('extension/shipping/flow_form', $data));
        }

    }

    public function create() {
        $json = [];

        $this->load->language('extension/shipping/flow');


        if(isset($this->request->post)) {


            if (empty($this->request->post['delivery_name'])) {
                $json['error']['delivery_name'] = $this->language->get('error_name');
            }



            if (empty($this->request->post['delivery_city'])) {
                $json['error']['delivery_city'] = $this->language->get('error_city');
            }

            if (empty($this->request->post['delivery_address'])) {
                $json['error']['delivery_address'] = $this->language->get('error_address');
            }

            if (empty($this->request->post['delivery_phone']) || !is_numeric($this->request->post['delivery_phone'])) {
                $json['error']['delivery_phone'] = $this->language->get('error_telephone');
            }

            if (empty($this->request->post['reference'])) {
                $json['error']['reference'] = $this->language->get('error_reference');
            }



            if (empty($this->request->post['commodity-value'])) {
                $json['error']['commodity-value'] = 'مطلوب انواع منتجات الشحنة';
            }



            if (!$json) {

                $this->load->model('user/user');

                $user_info = $this->model_user_user->getUser($this->user->getId());

                if ($user_info) {
                    $requested_by = $user_info['firstname'] . ' ' . $user_info['lastname'];
                } else {
                    $requested_by = '';
                }
                $order_info = $this->request->post;

                $cities = $this->cities();

                $collection_city = '';
                foreach ($cities as $city) {

                    if($city['id'] == $this->config->get('shipping_flow_collection_city')) {
                        $collection_city = $city['city_en'];
                        break;
                    }
                }


                $basic_data = [
                    // "reference_number"=>$order_info['reference'] ,
                    "customer_code" => "HIDAYACENTER" ,
                    "service_type_id" => "PREMIUM" ,
                    "load_type" => "NON-DOCUMENT" ,
                    "declared_value" => "",
                    "weight_unit" => "kg",
                    "weight" => $order_info['packageWeight'],
                    "num_pieces" => $order_info['numberOfItems'],
                    "is_risk_surcharge_applicable" => $order_info['is_risk_surcharge_applicable'] == 'true' ? true: false
                ] ;

                if($order_info['is_cod'] == 1){
                    $basic_data['cod_amount'] = $order_info['cod_amount'] ;
                }

                $origin_details = [
                    "name"=> $this->config->get('shipping_flow_collection_name') ,
                    "phone"=> $this->config->get('shipping_flow_collection_telephone'),
                    "address_line_1"=> $this->config->get('shipping_flow_collection_address'),
                    "pincode"=> $this->config->get('shipping_flow_collection_postcode'),
                    "state"=> $this->config->get('shipping_flow_collection_region') ,
                    "city" => $cities[ $this->config->get('shipping_flow_collection_city')]['city_en']
                ];



                $return_details = $origin_details ;



                $destination_details = [
                    "name"=> "Shipsy",
                    "phone"=> $order_info['delivery_phone'],
                    "address_line_1"=> $order_info['delivery_address'],
                    "pincode"=> $order_info['city'],
                    "city"=> $order_info['city'],
                    "state"=> "KSA"
                ];



                $this->load->model('sale/order');
                $this->load->model('catalog/product');
                $products = $this->model_sale_order->getOrderProducts($order_info['order_id']);

                $pieces_detail = [] ;
                foreach ($products as $product) {
                    $p = $this->model_catalog_product->getProduct($product['product_id']);
                    $d = [
                        "description"=> $product['model'],
                        "declared_value"=> $product['price'],
                        "weight"=> $p['weight'],
                        "height"=> $p['height'],
                        "length"=>$p['length'],
                        "width" => $p['width'],
                        "quantity" => $product['quantity'],
                        "product_code" => $product['order_product_id'],
                        "dimension_unit" => "cm",
                        "weight_unit" => "kg"
                    ];
                    $pieces_detail[] = (object)  $d ;
                }

                $basic_data['origin_details'] = (Object) $origin_details  ;
                $basic_data['return_details '] = (Object) $return_details  ;
                $basic_data ['destination_details'] = (Object) $destination_details ;
                $basic_data ['pieces_detail'] = $pieces_detail  ;

                $data['consignments'][]=   $basic_data;
                $data_json = json_encode( $data) ;
                // var_dump( $data_json); exit;




                if ($this->config->get('shipping_flow_live')) {
                    $url = 'http://app.shipsy.in/api/customer/integration/consignment/softdata';
                } else {
                    $url = 'http://demodashboardapi.shipsy.in/api/customer/integration/consignment/softdata';
                }




                $curl = curl_init($url);

                /*
                curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json',
                    'Accept: application/json', 'Authorization:' . $this->config->get('shipping_flow_key')));
                */

                curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json',
                    'Accept: application/json', 'api-key:' . $this->config->get('shipping_flow_key')));

                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS,  $data_json );
                $response = json_decode(curl_exec($curl), true);




                if(isset($response['status']) && $response['status']==true) {
                    $json['success'] =  $this->language->get('text_success_create');
                    $json['comment'] = sprintf($this->language->get('text_tracking_number'),$response['data'][0]['reference_number']);


                    $json['pdf_label'] =  $this->getPDFlabel( $response['data'][0]['reference_number']);
                    //$json['pdf_label'] = 'https://demodashboardapi.shipsy.in/api/customer/integration/consignment/shippinglabel/stream?reference_number='.;
                    // $json['pdf_label'] =
                    $this->load->model('sale/order');

                    $this->model_sale_order->saveFlowShipping((int)$order_info['order_id'], $json['pdf_label']);

                }else{
                    $json['warning'] =   $response  ;
                }

                curl_close($curl);

            }

        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));

    }



    public function filepdf() {


        $ref = $this->request->get['ref'];
        $filename = DIR_UPLOAD. $ref.'.pdf' ;
        //  $m =  file_exists ( DIR_UPLOAD. $ref.'.pdf' );
        if(file_exists($filename)) {

//Define header information
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header("Cache-Control: no-cache, must-revalidate");
            header("Expires: 0");
            header('Content-Disposition: attachment; filename="'.basename($filename).'"');
            header('Content-Length: ' . filesize($filename));
            header('Pragma: public');

//Clear system output buffer
            flush();

//Read the size of the file
            readfile($filename);

//Terminate from the script
            die();
        }
        else{
            echo "File does not exist.";
        }




    }

    public function getPDFlabel($ref) {







        //


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://demodashboardapi.shipsy.in/api/customer/integration/consignment/shippinglabel/stream?reference_number=".$ref,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Postman-Token: 40592a93-ebfb-4404-ac0b-93c1a9119f73",
                "api-key: ".$this->config->get('shipping_flow_key'),
                "cache-control: no-cache,no-cache"
            ),
        ));

        $save_file_loc = DIR_UPLOAD . $ref.'.pdf' ;
        $fp = fopen($save_file_loc, 'wb');



// It set an option for a cURL transfer
        curl_setopt( $curl, CURLOPT_FILE, $fp);
        curl_setopt( $curl, CURLOPT_HEADER, 0);

// Perform a cURL session
        curl_exec( $curl);

        // var_dump(   $m ); exit;

// Closes a cURL session and frees all resources
        curl_close( $curl);

// Close file
        fclose($fp);

        $url = $this->url->link('extension/shipping/flow/filepdf', 'user_token=' . $this->session->data['user_token'] . '&ref='.$ref,
            true) ;

        return $url ;



        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }



    }

    public function install() {
        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "order_flow` (
          `order_id` int(11) NOT NULL,
          `link` varchar(255) NOT NULL,
          PRIMARY KEY (`order_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    }

    public function uninstall() {
        $this->db->query("DROP TABLE `" . DB_PREFIX . "order_flow`");
    }

    public function converToTateTimeFlow($datetime){

        // strtotime
        $date_new = date('Y-m-d',strtotime($datetime));
        $time_new = date('H:i:s',strtotime($datetime));


        //  var_dump( $date_new , $time_new ,  $datetime ); exit;

        $all_date_time =  $date_new.'T'. $time_new.'.000Z';
        return $all_date_time;

    }
}