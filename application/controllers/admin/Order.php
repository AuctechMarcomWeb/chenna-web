<?php defined('BASEPATH') or exit('No direct script access allowed');
class Order extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->library('email');
    $this->load->library('session');
    $this->load->helper('message');
    $this->load->model('Order_model');
    $this->load->library('pagination');
  }


  public function applyedCoupon($id)
  {
    $data['index']      = 'Coupon';
    $data['index2']     = '';
    $data['title']      = 'Manage Coupon';
    $data['getData']    = $this->db->query("select * from order_master where coupon_code_id=" . $id . " order by id DESC")->result_array();
    $this->load->view('include/header', $data);
    $this->load->view('Coupon/applyedCoupon');
    $this->load->view('include/footer');
  }

  public function deleteOrder($id)
  {

    $this->db->where('id', $id);
    $this->db->delete('order_master');

    $this->db->where('order_master_id', $id);
    $this->db->delete('purchase_master');

    $this->db->select('product_master_id');
    $purchase = $this->db->get_where('purchase_master', array('order_master_id' => $id))->result_array();
    foreach ($purchase as $key => $value) {
      $getQty = $this->db->query("SELECT quantity FROM purchase_master where order_master_id=" . $id . " AND product_master_id=" . $value['product_master_id'] . "")->row_array();

      $this->db->select('quantity');
      $proQty = $this->db->get_where('sub_product_master', array('id' => $value['product_master_id']))->row_array();
      $field['quantity'] = $proQty['quantity'] + $getQty['quantity'];
      $this->db->where('id', $value['product_master_id']);
      $this->db->update('purchase_master', $field);
    }

    $this->session->set_flashdata('activate', getCustomAlert('S', ' Order Deleted Successfully.'));
    redirect('admin/Order');
  }




  public function trackOrder()
  {
    $html = '';
    $waybill_number = $this->input->post('waybill_number');

    $rate_cal['awb_number_list']         = $waybill_number;
    $rate_cal['access_token']            = '28b4d9246917ac19f5f9cea9861bc731';
    $rate_cal['secret_key']              = 'df1b745f66e9b39f81b70b8bc2ad4689';

    $array_data['data']                 = $rate_cal;

    $json_data   = json_encode($array_data);

    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL             => "https://manage.ithinklogistics.com/api_v3/order/track.json",
      CURLOPT_RETURNTRANSFER  => true,
      CURLOPT_ENCODING        => "",
      CURLOPT_MAXREDIRS       => 10,
      CURLOPT_TIMEOUT         => 30,
      CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST   => "POST",
      CURLOPT_POSTFIELDS      => $json_data,
      CURLOPT_HTTPHEADER      => array(
        "cache-control: no-cache",
        "content-type: application/json"
      ),
    ));

    $response = curl_exec($curl);
    $err      = curl_error($curl);
    curl_close($curl);
    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      $res_array = json_decode($response, true);

      foreach ($res_array['data'][$waybill_number]['scan_details'] as $key => $value) {
        $html .= '<div class="row">
         <div class="col-md-6">' . $value['status_date_time'] . '</div>
           <div class="col-md-5">
            <div class="trk-order-stat">
              ' . $value['status'] . '
            </div>
          </div>
          <br>
          <div class="col-md-12">
             <div class="trk-address float-none float-sm-right">' . $value['status_location'] . '<img src="https://manage-cdn.ithinklogistics.com/manage/theme2/assets/images/track-order.svg" class="trk-address-icon">
            </div>
          </div>';
        if (!empty($value['status_remark'])) {


          $html .= '<div class="col-md-12">
            <div class="trk-doc-text">
              <img src="https://manage-cdn.ithinklogistics.com/manage/theme2/assets/images/icon-tracking-details.png" class="trk-doc-text-icon">&nbsp;&nbsp;&nbsp;
              ' . $value['status_remark'] . '
            </div>
          </div>';
        }
        $html .= '</div>
        <hr style="margin-top: 10px;">
        <br>';
      }

      echo $html;
    }
  }


  public function assignCorier()
  {
    $html = '';
    $order_id = $this->input->post('order_id');

    $order    = $this->db->get_where('order_master', array('id' => $order_id))->row_array();

    if ($order['payment_type'] == '1') {
      $payment_method = 'cod';
    } else {
      $payment_method = 'Prepaid';
    }

    $address_data = $this->db->get_where('order_address_master', array('order_master_id' => $order['id']))->row_array();


    $this->db->select('product_master_id,quantity');
    $purchase = $this->db->get_where('purchase_master', array('order_master_id' => $order_id))->result_array();

    $weight         = '0';
    $packet_weight  = '0';
    $packet_height  = '0';
    $packet_length  = '0';

    foreach ($purchase as $key => $purchaseData) {
      $this->db->select('weight,packet_weight,packet_height,packet_length');
      $product = $this->db->get_where('sub_product_master', array('id' => $purchaseData['product_master_id']))->row_array();

      $weight += $product['weight'] * $purchaseData['quantity'];
      $packet_height += $product['packet_height'] * $purchaseData['quantity'];
      $packet_length          = $product['packet_length'];
      $packet_weight          = $product['packet_weight'];
    }


    $rate_cal['from_pincode']            = '226001';
    $rate_cal['to_pincode']              = $address_data['pincode'];
    $rate_cal['shipping_length_cms']     = $packet_length;
    $rate_cal['shipping_width_cms']      = $packet_weight;
    $rate_cal['shipping_height_cms']     = $packet_height;
    $rate_cal['shipping_weight_kg']      = $weight;
    $rate_cal['order_type']              = 'forward';
    $rate_cal['payment_method']          = $payment_method;
    $rate_cal['product_mrp']             = $order['final_price'];
    $rate_cal['access_token']            = '28b4d9246917ac19f5f9cea9861bc731';
    $rate_cal['secret_key']              = 'df1b745f66e9b39f81b70b8bc2ad4689';

    $array_data['data']                 = $rate_cal;

    $json_data   = json_encode($array_data);



    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL             => "https://manage.ithinklogistics.com/api_v3/rate/check.json",
      CURLOPT_RETURNTRANSFER  => true,
      CURLOPT_ENCODING        => "",
      CURLOPT_MAXREDIRS       => 10,
      CURLOPT_TIMEOUT         => 30,
      CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST   => "POST",
      CURLOPT_POSTFIELDS      => $json_data,
      CURLOPT_HTTPHEADER      => array(
        "cache-control: no-cache",
        "content-type: application/json"
      ),
    ));

    $response = curl_exec($curl);
    $err      = curl_error($curl);
    curl_close($curl);
    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      $res_array = json_decode($response, true);


      if (!empty($res_array['data'])) {

        $count = '1';
        foreach ($res_array['data'] as $key => $arrayData) {

          if (empty($arrayData['logistic_service_type'])) {
            $service = 'N/A';
          } else {

            $service = $arrayData['logistic_service_type'];
          }

          $html .= '<div class="panel panel-default" style="cursor: pointer;background-color:#99cc00;" >
                     <div class="panel-body" onclick="getServiceInfo(' . $order_id . ',' . $count . ')">
                      <input type="hidden" id="name_' . $count . '" value="' . $arrayData['logistic_name'] . '">
                      <input type="hidden" id="rate_' . $count . '" value="' . $arrayData['rate'] . '">
                      <input type="hidden" id="service_' . $count . '" value="' . $arrayData['logistic_service_type'] . '">
                      <div class="row">
                       <div class="col-md-3">
                       <b>Name:</b>&nbsp;&nbsp;' . $arrayData['logistic_name'] . '
                       </div>
                       <div class="col-md-3">
                         <b>Service:</b>&nbsp;&nbsp;' . $service . '
                       </div>
                       <div class="col-md-3">
                       <b>Prepaid:</b>&nbsp;&nbsp;' . $arrayData['prepaid'] . '
                       </div>
                       <div class="col-md-3">
                       <b>Payment Type:</b>&nbsp;&nbsp;' . $arrayData['cod'] . '
                       </div>
                       </div>
                       <br>

                      <div class="row">
                       <div class="col-md-3"><b>Pickup:</b>&nbsp;&nbsp;' . $arrayData['pickup'] . '</div>
                       <div class="col-md-3"><b>Rev Pickup:</b>&nbsp;&nbsp;' . $arrayData['rev_pickup'] . '</div>
                       <div class="col-md-3"><b>Rate:</b>&nbsp;&nbsp;Rs. ' . $arrayData['rate'] . '</div>
                   
                      </div>

                     </div>
                     </div>';

          $count++;
        }
      } else {


        $html .= '<p><h4>' . $res_array['message'] . '</h4></p>';
      }

      echo $html;
      exit;
    }
  }


  /*Array ( [from_pincode] => 226001 [to_pincode] => 226010 [shipping_length_cms] => 16 [shipping_width_cms] => 14 [shipping_height_cms] => 12 [shipping_weight_kg] => 0.6 [order_type] => forward [payment_method] => cod [product_mrp] => 540 [access_token] => 28b4d9246917ac19f5f9cea9861bc731 [secret_key] => df1b745f66e9b39f81b70b8bc2ad4689 )*/

  /*{"data":{"from_pincode":"226001","to_pincode":"226010","shipping_length_cms":"16","shipping_width_cms":"14","shipping_height_cms":12,"shipping_weight_kg":0.6,"order_type":"forward","payment_method":"cod","product_mrp":"-1257","access_token":"28b4d9246917ac19f5f9cea9861bc731","secret_key":"df1b745f66e9b39f81b70b8bc2ad4689"}}*/



public function index()
{
    is_not_logged_in();

    $limit   = 10;
    $pageNo  = $this->input->get('per_page') ?: 1;
    $offset  = ($pageNo - 1) * $limit;

    $keywords      = $this->input->post('keywords');
    $fromDate      = $this->input->post('fromDate');
    $toDate        = $this->input->post('toDate');
    $order_status  = $this->input->post('order_status');
    $delete_status = $this->input->post('delete_status');

    // COD Orders
    $this->db->from('order_master');
    $this->db->where('payment_type', 1);
    $this->db->where('action_payment', ($delete_status == 'delete') ? 'delete' : 'Yes');

    if ($keywords) $this->db->like('order_number', $keywords);
    if ($order_status) $this->db->where('status', $order_status);
    if ($fromDate && $toDate) {
        $this->db->where("DATE(add_date) >=", $fromDate);
        $this->db->where("DATE(add_date) <=", $toDate);
    }
    $codOrders = $this->db->get()->result_array();

    // Online Orders
    $this->db->from('order_master2');
    $this->db->where('payment_type', 2);
    if ($keywords) $this->db->like('order_number', $keywords);
    if ($order_status) $this->db->where('status', $order_status);
    if ($fromDate && $toDate) {
        $this->db->where("DATE(add_date) >=", $fromDate);
        $this->db->where("DATE(add_date) <=", $toDate);
    }
    $onlineOrders = $this->db->get()->result_array();

    // Merge and sort
    $orders = array_merge($codOrders, $onlineOrders);
    usort($orders, fn($a,$b) => strtotime($b['add_date']) - strtotime($a['add_date']));

    $totalRecords = count($orders);
    $results = array_slice($orders, $offset, $limit);

    $data = [
        'results' => $results,
        'pano'    => $pageNo,
        'entries' => "Showing " . ($offset + 1) . " to " . ($offset + count($results)) . " of $totalRecords entries",
        'title'   => 'Manage Orders'
    ];

    $this->load->view('include/header', $data);
    $this->load->view('Order/OrderList', $data);
    $this->load->view('include/footer');
}


public function ViewOrder($id = '', $payment_type = '')
{
    is_not_logged_in();

    $data['title'] = 'Manage Order';

    // Determine table by payment type
    if ($payment_type == 1) {
        $orderTbl    = 'order_master';
        $purchaseTbl = 'purchase_master';
        $addressTbl  = 'order_address_master';
        $orderType   = 'offline';
    } elseif ($payment_type == 2) {
        $orderTbl    = 'order_master2';
        $purchaseTbl = 'purchase_master2';
        $addressTbl  = 'order_address_master2';
        $orderType   = 'online';
    } else {
        show_404();
    }

    $order = $this->db->get_where($orderTbl, ['id' => $id])->row_array();
    if (empty($order)) show_404();

    $data['getData'] = $order;
    $data['orderType'] = $orderType;

    // Fetch purchase data
    $purchaseData = $this->db->where('order_master_id', $id)->get($purchaseTbl)->result_array();
    $data['purchaseData'] = $purchaseData;
    $data['product_ids'] = array_column($purchaseData, 'product_master_id');

    // Fetch shipping address
    $address_data = $this->db->where('order_master_id', $id)->get($addressTbl)->row_array();
    $data['address_data'] = $address_data;

    $this->load->view('include/header', $data);
    $this->load->view('Order/product_detail', $data);
    $this->load->view('include/footer');
}






  public function AddOrder()
  {

    is_not_logged_in();
    $data['index']      = 'Orders';
    $data['index2']     = '';
    $data['title']      = 'Manage Orders';
    $this->load->view('include/header', $data);
    $this->load->view('Order/addOfflineOrder');
    $this->load->view('include/footer');
  }

  public function getSingleOrderData($id = '')
  {
    return $this->db->query('SELECT * FROM `purchase_master` Where id =' . $id . ' ')->row_array();
  }

// public function ViewOrder($id = '')
// {
//     is_not_logged_in();

//     $data['index']  = 'UpdtOrders';
//     $data['index2'] = '';
//     $data['title']  = 'Manage Order';

//     // Fetch COD order first
//     $order = $this->db
//         ->select("*, UNIX_TIMESTAMP(add_date) as add_date")
//         ->get_where('order_master', ['id' => $id])
//         ->row_array();
//     $orderType = 'offline';

//     // Fallback: Online order
//     if (empty($order)) {
//         $order = $this->db
//             ->select("*, UNIX_TIMESTAMP(add_date) as add_date")
//             ->get_where('order_master2', ['id' => $id])
//             ->row_array();
//         $orderType = 'online';
//     }

//     if (empty($order)) {
//         show_404();
//     }

//     $data['getData'] = $order;
//     $data['orderType'] = $orderType;

//     // Get purchase data
//     if ($orderType == 'offline') {
//         $purchaseData = $this->db
//             ->where('order_master_id', $id)
//             ->get('purchase_master')
//             ->result_array();
//     } else {
//         $purchaseData = $this->db
//             ->where('order_master_id', $id)
//             ->get('purchase_master2')
//             ->result_array();
//     }

//     $data['purchaseData'] = $purchaseData;
//     $data['product_ids']  = array_column($purchaseData, 'product_master_id');

//     $this->load->view('include/header', $data);
//     $this->load->view('Order/product_detail', $data);
//     $this->load->view('include/footer');
// }


  public function ViewDetails($id = '')
  {
    is_not_logged_in();
    $data['index']          = 'UpdtOrders';
    $data['index2']         = '';
    $data['title']          = 'View Order Details';
    $data['getData']        = $this->db->get_where('order_master', array('id' => $id))->row_array();
    $this->load->view('include/header', $data);
    $this->load->view('Order/VieworderDetails');
    $this->load->view('include/footer');
  }

  public function updatePaymentStatus($id)
  {
    $this->Order_model->updateActionPaymentStatus($id);
    redirect('admin/Order');
  }


  public function UpdateOrderStatus($orderid = '', $vendor_id = '')
  {
    // $OrderDetail = allData2('order_master','id',$orderid); 
    $data = $this->input->post();
    $field = array();
    $field['order_id']    = $orderid;
    $field['vendor_id']   = $vendor_id;
    $field['StatusUpdate']  = $data['StatusUpdate'];
    $field['remark']      = $data['remark'];

    // print_r($data);
    // die();
    $row  = $this->Order_model->UpdateOrderData($field);




    if ($row > 0) {
      $OrderDetail  = allData2('order_master', 'id', $orderid);
      $SendSMSAlert = $this->SendSMSAlert($data['StatusUpdate'], $OrderDetail);

      $this->session->set_flashdata('activate', getCustomAlert('S', ' Order has been Update Successfully.'));
      redirect('admin/Order/');
    } else {
      $this->session->set_flashdata('activate', getCustomAlert('D', '!Opps Something is worng.Please try again.'));
      redirect('admin/Order/');
    }
  }



public function SendSMSAlert($alertType, $orderDetail)
{
    if (empty($orderDetail)) return false;

    // Get user info
    $mobile  = singlerowparameter('mobile', 'id', $orderDetail['user_master_id'], 'user_master');
    $emailid = singlerowparameter('email_id', 'id', $orderDetail['user_master_id'], 'user_master');
    $user    = singlerowparameter('username', 'id', $orderDetail['user_master_id'], 'user_master');

    // Detect order type to choose purchase table
    $payment_type = $orderDetail['payment_type'] ?? 1; // default offline
    $purchaseTbl  = ($payment_type == 2) ? 'purchase_master2' : 'purchase_master';
    $addressTbl   = ($payment_type == 2) ? 'order_address_master2' : 'order_address_master';

    $purchaseData = $this->db->get_where($purchaseTbl, ['order_master_id' => $orderDetail['id']])->result_array();
    $address_info = $this->db->get_where($addressTbl, ['order_master_id' => $orderDetail['id']])->row_array();

    if (empty($purchaseData)) return false;

    foreach ($purchaseData as $purchase) {
        $product = $this->db->get_where('sub_product_master', ['id' => $purchase['product_master_id']])->row_array();

        // IMAGE URL
        $img_link = base_url('assets/product_images/no-image.png');
        if (!empty($product['main_image'])) {
            $parsed = parse_url($product['main_image']);
            if (!empty($parsed['host'])) {
                $img_link = 'https://' . $parsed['host'] . $parsed['path'];
            } else {
                $img_link = base_url('assets/product_images/' . $product['main_image']);
            }
        }

        // ======= FIX: Convert string date to timestamp =======
        $add_date_ts   = is_numeric($purchase['add_date']) ? $purchase['add_date'] : strtotime($purchase['add_date']);
        $placed_date   = gmdate("d-m-Y", $add_date_ts);
        $delivery_date = date('d-m-Y', strtotime('+8 days', $add_date_ts));

        // Prepare order info
        $order_no      = $orderDetail['order_number'];
        $product_title = $product['product_name'];
        $size          = $purchase['size'];
        $color         = $purchase['color'];
        $qty           = $purchase['quantity'];
        $price         = $orderDetail['total_price'] ?? $purchase['final_price'];
        $total         = $orderDetail['final_price'];
        $address       = $address_info['address'] ?? '';
        $c_name        = $user;
        $c_address     = $address;

        $message = '';
        $subject = '';
        $email_body = '';

        // ====== Alert Type Messages ======
        switch ($alertType) {
            case 1: // Order Accepted
                $message = "Dear customer, Your Order no. - $order_no has been Accepted and is being processed. Thanks. Visit https://dukekart.in";
                $subject = "Your order no $order_no has been Accepted";
                $this->load->helper('/email/order_shipped');
                $email_body = order_shipped(
                    'Order Accepted', $order_no, $user,
                    $message, $img_link, $product_title, $size, $color, $qty,
                    $price, "Free", 0, $total, $address, $delivery_date, $placed_date
                );
                break;

            case 2: // Order Shipped
                $message = "Your order no. $order_no of $product_title has been dispatched. Visit https://dukekart.in for more info.";
                $subject = "Your order no $order_no has been shipped";
                $this->load->helper('/email/temp4');
                $email_body = temp4('Order Shipped', $order_no, $user, $message, $img_link, $product_title, $size, $color, $qty, $price, "Free", 0, $total, $delivery_date, $placed_date, $address);
                break;

            case 3: // Order Delivered
                $message = "Dear $user, your order no. $order_no has been delivered successfully. Thanks for shopping with Dukekart!";
                $subject = "Your order no $order_no has been delivered";
                $this->load->helper('/email/temp5');
                $email_body = temp5('Order Delivered', $user, $message, 'https://dukekart.in/');
                break;

            case 4: // Order Cancelled
                $message = "Dear customer, Your Order no. - $order_no has been cancelled. Contact support for more info.";
                $subject = "Your order no $order_no has been cancelled";
                $this->load->helper('/email/temp5');
                $email_body = temp5('Order Cancelled', $user, $message, 'https://dukekart.in/');
                break;

            case 5: // Confirmed by Seller
                $message = "Dear $user, your order no. $order_no has been confirmed by the seller.";
                $subject = "Your order no $order_no is confirmed by Seller";
                $this->load->helper('/email/temp1');
                $email_body = temp1('Order Confirmed', $order_no, $user, $message, $img_link, $product_title, $size, $color, $qty, $price, "Free", 0, $total, $c_name, $c_address);
                break;

            case 6: // Rejected by Seller
                $message = "Dear $user, your order no. $order_no has been rejected by the seller.";
                $subject = "Your order no $order_no is rejected by Seller";
                $this->load->helper('/email/temp1');
                $email_body = temp1('Order Rejected', $order_no, $user, $message, $img_link, $product_title, $size, $color, $qty, $price, "Free", 0, $total, $c_name, $c_address);
                break;
        }

        // Send email & SMS
        if ($message != '') {
            sentCommonEmail($emailid, $email_body, $subject);
            sendSMS($mobile, $message, '1000000000000000000'); // Replace with proper template ID
        }
    }

    return true;
}





  public function CancelOrderByUser()
  {
    $data  = $this->input->post();
    $field = array();
    $field['order_id']    = $data['order_id'];
    $field['StatusUpdate']  = $data['StatusUpdate'];
    $field['activity']    = 1;
    $row  = $this->Order_model->UpdateOrderData($field);
    echo $row;
  }

  public function sentCommonEmail2($email, $smsmessage, $sub)
  {
    // ++++++++++++++
    $to = $email;
    $subject = $sub;
    $message .= "Note - This is a System Generated Mail, please do not reply.\r\n";
    $headers = "From:" . "support@dukekart.in" . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";
    mail($to, $subject, $smsmessage, $headers);
    return 1;
  }


  public function ApproveReturnRequest($product_id, $oder_id)
  {


    $product_info = $this->db->get_where('sub_product_master', array('id' => $product_id))->row_array();

    $check = $this->db->query("SELECT id FROM purchase_master where order_master_id=" . $oder_id . " AND status='1'")->num_rows();

    $oder = $this->db->get_where('order_master', array('id' => $oder_id))->row_array();

    $user_info = $this->db->get_where('user_master', array('id' => $oder['user_master_id']))->row_array();


    $oder_number = $oder['order_number'];

    if ($check == '1') {

      /*Order Master*/

      $status['status'] = '8';
      $this->db->where('id', $oder_id);
      $this->db->update('order_master', $status);

      /*Update Purchase Status*/
      $statuss['status'] = '8';
      $this->db->where(array('product_master_id' => $product_id, 'order_master_id' => $oder_id));
      $this->db->update('purchase_master', $statuss);

      $smstxt = "Dear " . $user_info['username'] . " your order no. " . $oder_number . " return request Successfully Approved.RegardsDukekart Real Time Private Limited (www.dukekart.in)";

      sendSMS($user_info['mobile'], $smstxt, '1007563476963767461');
      sentCommonEmail($user_info['email_id'], $smstxt, "Return request approved");
    } else {

      /*Update Purchase Status*/
      $statuss['status'] = '8';
      $this->db->where(array('product_master_id' => $product_id, 'order_master_id' => $oder_id));
      $this->db->update('purchase_master', $statuss);

      $smstxt = "Dear " . $user_info['username'] . " your order no. " . $oder_number . " return request Successfully Approved.RegardsDukekart Real Time Private Limited (www.dukekart.in)";

      sendSMS($user_info['mobile'], $smstxt, '1007563476963767461');
      sentCommonEmail($user_info['email_id'], $smstxt, "Return request approved");
    }

    $this->session->set_flashdata('activate', getCustomAlert('S', ' Product Return Request Approved Successfully.'));
    redirect(base_url() . "admin/Order/viewOrder/" . $oder['id']);
  }



  public function addCorierOrder()
  {

    $weight         = '0';
    $packet_weight  = '0';
    $packet_height  = '0';
    $packet_length  = '0';

    $order_id    = $this->input->post('order_id');
    $name        = $this->input->post('name');
    $rate        = $this->input->post('rate');
    $service     = $this->input->post('service');

    $this->db->select('id,payment_type,order_number,add_date,final_price,user_master_id');
    $order     = $this->db->get_where('order_master', array('id' => $order_id))->row_array();

    $this->db->select('email_id,username');
    $user_info = $this->db->get_where('user_master', array('id' => $order['user_master_id']))->row_array();


    $address_data = $this->db->get_where('order_address_master', array('order_master_id' => $order['id']))->row_array();

    $this->db->select('shop_id,product_master_id,quantity,final_price,quantity');
    $purchase = $this->db->get_where('purchase_master', array('order_master_id' => $order_id))->result_array();




    $shop_array = array();
    foreach ($purchase as $key => $purchaseD) {
      $shop_array[] = $purchaseD['shop_id'];
    }

    $shop_ids_array = array_unique($shop_array);


    $count = '1';

    foreach ($shop_ids_array as $key => $shop_idd) {
      $this->db->select('warehouse_id');
      $shop_detail = $this->db->get_where('shop_master', array('id' => $shop_idd))->row_array();


      $this->db->select('product_master_id');
      $productArray = $this->db->get_where('purchase_master', array('shop_id' => $shop_idd, 'order_master_id' => $order_id))->result_array();

      $product_ids = array_column($productArray, 'product_master_id');

      $this->db->select('*');
      $this->db->where('order_master_id', $order_id);
      $this->db->where_in('product_master_id', $product_ids);
      $productData = $this->db->get('purchase_master')->result_array();
      $order_amount = '0';
      foreach ($productData as $key => $productD) {
        $order_amount += $productD['final_price'] * $productD['quantity'];
      }

      if ($order['payment_type'] == '1') {
        $payment_mode = 'COD';
        $cod_amount   = $order_amount;
      } else {
        $payment_mode = 'Prepaid';
        $cod_amount   = '0';
      }

      $fields['waybill']                         = '';
      $fields['order']                           = $order['order_number'] . '_' . $shop_idd;
      $fields['sub_order']                       = $order['order_number'] . '_' . $shop_idd;
      $fields['order_date']                      = date("d-m-Y", $order['add_date']);
      $fields['total_amount']                    = $order_amount;
      $fields['name']                            = $address_data['contact_person'];
      $fields['company_name']                    = 'DUKEKART PRIVATE LIMITED';
      $fields['add']                             = $address_data['address'];
      $fields['add2']                            = $address_data['localty'];
      $fields['add3']                            = '';
      $fields['pin']                             = $address_data['pincode'];
      $fields['city']                            = $address_data['city'];
      $fields['state']                           = $address_data['state'];
      $fields['country']                         = 'India';
      $fields['phone']                           = $address_data['mobile_number'];
      $fields['alt_phone']                       = $address_data['mobile_number'];
      $fields['email']                           = $user_info['email_id'];
      $fields['is_billing_same_as_shipping']               = 'yes';
      $fields['billing_name']                              = '';
      $fields['billing_company_name']                      = '';
      $fields['billing_add']                               = '';
      $fields['billing_add2']                              = '';
      $fields['billing_add3']                              = '';
      $fields['billing_pin']                               = '';
      $fields['billing_city']                              = '';
      $fields['billing_state']                             = '';
      $fields['billing_country']                           = '';
      $fields['billing_phone']                             = '';
      $fields['billing_alt_phone']                         = '';
      $fields['billing_email']                             = '';





      $cod_amount = '0';
      foreach ($productData as $key => $purchaseData) {

        $product_info = $this->db->get_where('sub_product_master', array('id' => $purchaseData['product_master_id']))->row_array();


        $weight += $product_info['weight'] * $purchaseData['quantity'];
        $packet_height += $product_info['packet_height'] * $purchaseData['quantity'];
        $packet_length          = $product_info['packet_length'];
        $packet_weight          = $product_info['packet_weight'];
        $cod_amount            = $purchaseData['final_price'] * $purchaseData['quantity'];
        $product['product_name']               =   $product_info['product_name'];
        $product['product_sku']                =   $product_info['sku_code'];
        $product['product_quantity']           =   $purchaseData['quantity'];
        $product['product_price']              =   $purchaseData['final_price'];
        $product['product_tax_rate']           =   '0';
        $product['product_hsn_code']           =   $product_info['product_hsn'];
        $product['product_discount']           =   '0';
        $hold[]                                =   $product;
      }


      $fields['shipment_length']                           =   $packet_length;
      $fields['shipment_width']                            =   $packet_weight;
      $fields['shipment_height']                           =   $packet_height;
      $fields['weight']                                    =   $weight;
      $fields['shipping_charges']                          =   '0';
      $fields['giftwrap_charges']                          =   '0';
      $fields['transaction_charges']                       =   '0';
      $fields['total_discount']                            =   '0';
      $fields['first_attemp_discount']                     =   '0';
      $fields['cod_charges']                               =   '0';
      $fields['advance_amount']                            =   '0';
      $fields['cod_amount']                                =   $cod_amount;
      $fields['payment_mode']                              =   $payment_mode;
      $fields['reseller_name']                             =   '';
      $fields['eway_bill_number']                          =   '';
      $fields['gst_number']                                =   '';
      $fields['return_address_id']                         =  $shop_detail['warehouse_id'];

      $fields['products']                                   = $hold;

      $hold_data[]                                           = $fields;
      $all_data['shipments']                                 = $hold_data;
      $all_data['pickup_address_id']                         = $shop_detail['warehouse_id'];
      $all_data['access_token']                              = '28b4d9246917ac19f5f9cea9861bc731';
      $all_data['secret_key']                                = 'df1b745f66e9b39f81b70b8bc2ad4689';
      $all_data['logistics']                                 =  $name;
      $all_data['s_type']                                    = $service;
      $all_data['order_type']                                = '';

      $response['data']                                      = $all_data;

      $json_data                                             = json_encode($response);



      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL             => "https://manage.ithinklogistics.com/api_v3/order/add.json",
        CURLOPT_RETURNTRANSFER  => true,
        CURLOPT_ENCODING        => "",
        CURLOPT_MAXREDIRS       => 10,
        CURLOPT_TIMEOUT         => 30,
        CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST   => "POST",
        CURLOPT_POSTFIELDS      => $json_data,
        CURLOPT_HTTPHEADER      => array(
          "cache-control: no-cache",
          "content-type: application/json"
        ),
      ));

      $response = curl_exec($curl);
      $err      = curl_error($curl);
      curl_close($curl);
      if ($err) {

        $resp['message'] = $err;
        $resp['status']  = '3';
        echo json_encode($resp);
        exit;
      } else {

        $array_response = json_decode($response, true);


        if (!empty($array_response['data']['1']['status'])) {

          if ($array_response['data']['1']['status'] == 'success') {

            if ($count == '1') {

              $fieldsss['logistic_status']   = $array_response['status'];
              $fieldsss['waybill']           = $array_response['data']['1']['waybill'];
              $fieldsss['reference_number']  = $array_response['data']['1']['refnum'];
              $fieldsss['logistic_name']     = $array_response['data']['1']['logistic_name'];
              $this->db->where('order_number', $order['order_number']);
              $this->db->update('order_master', $fieldsss);

              $this->saveCorierLabel($order_id, $shop_idd, $array_response['data']['1']['waybill'], $count, $user_info['username']);
            } else if ($count == '2') {

              $fieldsss['logistic_status1']   = $array_response['status'];
              $fieldsss['waybill1']           = $array_response['data']['1']['waybill'];
              $fieldsss['reference_number1']  = $array_response['data']['1']['refnum'];
              $fieldsss['logistic_name1']     = $array_response['data']['1']['logistic_name'];
              $this->db->where('order_number', $order['order_number']);
              $this->db->update('order_master', $fieldsss);

              $this->saveCorierLabel($order_id, $shop_idd, $array_response['data']['1']['waybill'], $count, $user_info['username']);
            } else if ($count == '3') {

              $fieldsss['logistic_status2']   = $array_response['status'];
              $fieldsss['waybill2']           = $array_response['data']['1']['waybill'];
              $fieldsss['reference_number2']  = $array_response['data']['1']['refnum'];
              $fieldsss['logistic_name2']     = $array_response['data']['1']['logistic_name'];
              $this->db->where('order_number', $order['order_number']);
              $this->db->update('order_master', $fieldsss);
              $this->saveCorierLabel($order_id, $shop_idd, $array_response['data']['1']['waybill'], $count, $user_info['username']);
            } else if ($count == '4') {

              $fieldsss['logistic_status3']   = $array_response['status'];
              $fieldsss['waybill3']           = $array_response['data']['1']['waybill'];
              $fieldsss['reference_number3']  = $array_response['data']['1']['refnum'];
              $fieldsss['logistic_name3']     = $array_response['data']['1']['logistic_name'];
              $this->db->where('order_number', $order['order_number']);
              $this->db->update('order_master', $fieldsss);

              $this->saveCorierLabel($order_id, $shop_idd, $array_response['data']['1']['waybill'], $count, $user_info['username']);
            } else if ($count == '5') {

              $fieldsss['logistic_status4']   = $array_response['status'];
              $fieldsss['waybill4']           = $array_response['data']['1']['waybill'];
              $fieldsss['reference_number4']  = $array_response['data']['1']['refnum'];
              $fieldsss['logistic_name4']     = $array_response['data']['1']['logistic_name'];
              $this->db->where('order_number', $order['order_number']);
              $this->db->update('order_master', $fieldsss);
              $this->saveCorierLabel($order_id, $shop_idd, $array_response['data']['1']['waybill'], $count, $user_info['username']);
            } else if ($count == '6') {

              $fieldsss['logistic_status5']   = $array_response['status'];
              $fieldsss['waybill5']           = $array_response['data']['1']['waybill'];
              $fieldsss['reference_number5']  = $array_response['data']['1']['refnum'];
              $fieldsss['logistic_name5']     = $array_response['data']['1']['logistic_name'];
              $this->db->where('order_number', $order['order_number']);
              $this->db->update('order_master', $fieldsss);

              $this->saveCorierLabel($order_id, $shop_idd, $array_response['data']['1']['waybill'], $count, $user_info['username']);
            } else if ($count == '7') {

              $fieldsss['logistic_status6']   = $array_response['status'];
              $fieldsss['waybill6']           = $array_response['data']['1']['waybill'];
              $fieldsss['reference_number6']  = $array_response['data']['1']['refnum'];
              $fieldsss['logistic_name6']     = $array_response['data']['1']['logistic_name'];
              $this->db->where('order_number', $order['order_number']);
              $this->db->update('order_master', $fieldsss);
              $this->saveCorierLabel($order_id, $shop_idd, $array_response['data']['1']['waybill'], $count, $user_info['username']);
            } else if ($count == '8') {

              $fieldsss['logistic_status7']   = $array_response['status'];
              $fieldsss['waybill7']           = $array_response['data']['1']['waybill'];
              $fieldsss['reference_number7']  = $array_response['data']['1']['refnum'];
              $fieldsss['logistic_name7']     = $array_response['data']['1']['logistic_name'];
              $this->db->where('order_number', $order['order_number']);
              $this->db->update('order_master', $fieldsss);
              $this->saveCorierLabel($order_id, $shop_idd, $array_response['data']['1']['waybill'], $count, $user_info['username']);
            }


            $resp['message'] = 'Order assign Successfully';
            $resp['status']  = '1';
          } else {

            if (!empty($array_response['html_message'])) {

              $resp['message'] = $array_response['html_message'];
              $resp['status']  = '2';
            } else {

              $resp['message'] = $array_response['data'][1]['remark'];
              $resp['status']  = '2';
            }
          }


          echo json_encode($resp);
          exit;
        } else {

          $resp['message'] = $array_response['html_message'];
          $resp['status']  = '3';
          echo json_encode($resp);
          exit;
        }
      }

      $count++;
    }
  }


  public function saveCorierLabel($order_id, $shop_id, $waybill, $count, $username)
  {

    $rate_cal['awb_numbers']                   = $waybill;
    $rate_cal['page_size']                     = 'A4';
    $rate_cal['access_token']                  = '28b4d9246917ac19f5f9cea9861bc731';
    $rate_cal['secret_key']                    = 'df1b745f66e9b39f81b70b8bc2ad4689';
    $rate_cal['display_cod_prepaid']           = '';
    $rate_cal['display_shipper_mobile']        = '';
    $rate_cal['display_shipper_address']       = '';

    $array_data['data']                 = $rate_cal;

    $json_data   = json_encode($array_data);



    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL             => "https://manage.ithinklogistics.com/api_v3/shipping/label.json",
      CURLOPT_RETURNTRANSFER  => true,
      CURLOPT_ENCODING        => "",
      CURLOPT_MAXREDIRS       => 10,
      CURLOPT_TIMEOUT         => 30,
      CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST   => "POST",
      CURLOPT_POSTFIELDS      => $json_data,
      CURLOPT_HTTPHEADER      => array(
        "cache-control: no-cache",
        "content-type: application/json"
      ),
    ));

    $response = curl_exec($curl);
    $err      = curl_error($curl);
    curl_close($curl);

    $array_response = json_decode($response, true);

    if ($array_response['status'] == 'success') {
      if ($count == '1') {

        $shipping_labe['shipping_label'] = $array_response['file_name'];
      } else if ($count == '2') {

        $shipping_labe['shipping_label1'] = $array_response['file_name'];
      } else if ($count == '3') {

        $shipping_labe['shipping_label2'] = $array_response['file_name'];
      } else if ($count == '4') {

        $shipping_labe['shipping_label3'] = $array_response['file_name'];
      } else if ($count == '5') {

        $shipping_labe['shipping_label4'] = $array_response['file_name'];
      } else if ($count == '6') {

        $shipping_labe['shipping_label5'] = $array_response['file_name'];
      } else if ($count == '7') {

        $shipping_labe['shipping_label6'] = $array_response['file_name'];
      } else if ($count == '8') {

        $shipping_labe['shipping_label7'] = $array_response['file_name'];
      }

      $this->db->where('id', $order_id);
      $this->db->update('order_master', $shipping_labe);
      $this->sendSellerMail($order_id, $shop_id, $username, $array_response['file_name']);
    }
  }

  public function sendSellerMail($order_id, $shop_id, $username, $shiingLink)
  {
    $this->db->select('user_master_id,order_number');
    $order = $this->db->get_where('order_master', array('id' => $order_id))->row_array();

    $this->db->select('vendor_id,email_id');
    $shop_info = $this->db->get_where('shop_master', array('id' => $shop_id))->row_array();

    $this->db->select('name');
    $staff = $this->db->get_where('staff_master', array('id' => $shop_info['vendor_id']))->row_array();

    $email_message = '
Dear ' . $staff['name'] . '

You have received an order on #' . $order['order_number'] . '.

Please do click on this ' . $shiingLink . ' link and download the Shipping label then Confirm the order if available and get it ready soon by pasting that shipping label on packet.

Thanks and regards
Team Dukekart';


    sentCommonEmail2($shop_info['email_id'], $email_message, 'Shipping Label');
  }



  public function reverseCorierOrder()
  {

    $weight         = '0';
    $packet_weight  = '0';
    $packet_height  = '0';
    $packet_length  = '0';

    $order_id    = $this->input->post('order_id');
    $name        = $this->input->post('name');
    $rate        = $this->input->post('rate');
    $service     = $this->input->post('service');

    $this->db->select('id,payment_type,order_number,add_date,final_price,user_master_id');
    $order     = $this->db->get_where('order_master', array('id' => $order_id))->row_array();

    $this->db->select('email_id');
    $user_info = $this->db->get_where('user_master', array('id' => $order['user_master_id']))->row_array();

    $address_data = $this->db->get_where('order_address_master', array('order_master_id' => $order['id']))->row_array();

    $this->db->select('product_master_id,quantity,final_price,quantity');
    $purchase = $this->db->get_where('purchase_master', array('order_master_id' => $order_id, 'status' => '8'))->result_array();



    $payment_mode = 'Prepaid';

    $fields['waybill']                         = '';
    $fields['order']                           = $order['order_number'];
    $fields['sub_order']                       = $order['order_number'];
    $fields['order_date']                      = date("d-m-Y", $order['add_date']);
    $fields['total_amount']                    = $order['final_price'];
    $fields['name']                            = $address_data['contact_person'];
    $fields['company_name']                    = 'DUKEKART PRIVATE LIMITED';
    $fields['add']                             = $address_data['address'] . ', ' . $address_data['localty'] . ', ' . $address_data['landmark'];
    $fields['add2']                            = '';
    $fields['add3']                            = '';
    $fields['pin']                             = $address_data['pincode'];
    $fields['city']                            = $address_data['city'];
    $fields['state']                           = $address_data['state'];
    $fields['country']                         = 'India';
    $fields['phone']                           = $address_data['mobile_number'];
    $fields['alt_phone']                       = $address_data['mobile_number'];
    $fields['email']                           = $user_info['email_id'];
    $fields['is_billing_same_as_shipping']               = 'yes';
    $fields['billing_name']                              = '';
    $fields['billing_company_name']                      = '';
    $fields['billing_add']                               = '';
    $fields['billing_add2']                              = '';
    $fields['billing_add3']                              = '';
    $fields['billing_pin']                               = '';
    $fields['billing_city']                              = '';
    $fields['billing_state']                             = '';
    $fields['billing_country']                           = '';
    $fields['billing_phone']                             = '';
    $fields['billing_alt_phone']                         = '';
    $fields['billing_email']                             = '';

    foreach ($purchase as $key => $purchaseData) {

      $product_info = $this->db->get_where('sub_product_master', array('id' => $purchaseData['product_master_id']))->row_array();
      $weight += $product_info['weight'] * $purchaseData['quantity'];
      $packet_height += $product_info['packet_height'] * $purchaseData['quantity'];
      $packet_length          = $product_info['packet_length'];
      $packet_weight          = $product_info['packet_weight'];
      $product['product_name']               =   $product_info['product_name'];
      $product['product_sku']                =   $product_info['sku_code'];
      $product['product_quantity']           =   $purchaseData['quantity'];
      $product['product_price']              =   $purchaseData['final_price'];
      $product['product_tax_rate']           =   '0';
      $product['product_hsn_code']           =   $product_info['product_hsn'];
      $product['product_discount']           =   '0';
      $hold[]                                =   $product;
    }


    $fields['shipment_length']                           =   $packet_length;
    $fields['shipment_width']                            =   $packet_weight;
    $fields['shipment_height']                           =   $packet_height;
    $fields['weight']                                    =   $weight;
    $fields['shipping_charges']                          =   '0';
    $fields['giftwrap_charges']                          =   '0';
    $fields['transaction_charges']                       =   '0';
    $fields['total_discount']                            =   '0';
    $fields['first_attemp_discount']                     =   '0';
    $fields['cod_charges']                               =   '0';
    $fields['advance_amount']                            =   '0';
    $fields['cod_amount']                                =   $cod_amount;
    $fields['payment_mode']                              =   $payment_mode;
    $fields['reseller_name']                             =   '';
    $fields['eway_bill_number']                          =   '';
    $fields['gst_number']                                =   '';
    $fields['return_address_id']                         =   '1289';

    $fields['products']                                    = $hold;

    $hold_data[]                                           = $fields;
    $all_data['shipments']                                 = $hold_data;
    $all_data['pickup_address_id']                         = '1289';
    $all_data['access_token']                              = '28b4d9246917ac19f5f9cea9861bc731';
    $all_data['secret_key']                                = 'df1b745f66e9b39f81b70b8bc2ad4689';
    $all_data['logistics']                                 =  $name;
    $all_data['s_type']                                    = $service;
    $all_data['order_type']                                = 'reverse';

    $response['data']                                      = $all_data;

    $json_data                                             = json_encode($response);




    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL             => "https://manage.ithinklogistics.com/api_v3/order/add.json",
      CURLOPT_RETURNTRANSFER  => true,
      CURLOPT_ENCODING        => "",
      CURLOPT_MAXREDIRS       => 10,
      CURLOPT_TIMEOUT         => 30,
      CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST   => "POST",
      CURLOPT_POSTFIELDS      => $json_data,
      CURLOPT_HTTPHEADER      => array(
        "cache-control: no-cache",
        "content-type: application/json"
      ),
    ));

    $response = curl_exec($curl);
    $err      = curl_error($curl);
    curl_close($curl);
    if ($err) {
      echo "cURL Error #:" . $err;
    } else {

      $array_response = json_decode($response, true);

      if ($array_response['status'] == 'success') {

        $fieldsss['return_logistic_status']   = $array_response['status'];
        $fieldsss['return_waybill']           = $array_response['data']['1']['waybill'];
        $fieldsss['return_reference_number']  = $array_response['data']['1']['refnum'];
        $fieldsss['return_logistic_name']     = $array_response['data']['1']['logistic_name'];
        $this->db->where('order_number', $order['order_number']);
        $this->db->update('order_master', $fieldsss);

        $resp['message'] = 'Courier assign Successfully';
        $resp['status']  = '1';
      } else {

        if (!empty($array_response['html_message'])) {

          $resp['message'] = $array_response['html_message'];
          $resp['status']  = '2';
        } else {

          $resp['message'] = $array_response['data'][1]['remark'];
          $resp['status']  = '2';
        }
      }


      echo json_encode($resp);
      exit;
    }
  }
}
