<?php class Order_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }
  public function getPurchaseSummary($vendorId)
  {
    $summary = [
      'total_orders'     => 0,
      'pending_orders'   => 0,
      'accepted_orders'  => 0,
      'cancelled_orders' => 0,
      'shipped_orders'   => 0,
      'delivered_orders' => 0,
      'completed_orders' => 0 // optional: delivered as completed
    ];

    $this->db->select('status, COUNT(*) as count');
    $this->db->from('purchase_master');
    $this->db->where('vendor_id', $vendorId);
    $this->db->group_by('status');
    $query = $this->db->get();

    if ($query->num_rows() > 0) {
      foreach ($query->result() as $row) {
        $summary['total_orders'] += $row->count;

        switch ($row->status) {
          case 1:
            $summary['pending_orders'] = $row->count;
            break;
          case 2:
            $summary['cancelled_orders'] = $row->count;
            break;
          case 3:
            $summary['accepted_orders'] = $row->count;
            break;
          case 4:
            $summary['shipped_orders'] = $row->count;
            break;
          case 5:
            $summary['delivered_orders'] = $row->count;
            $summary['completed_orders'] = $row->count;
            break;
        }
      }
    }

    return $summary;
  }


  // Total products added by vendor
  public function TotalGetProducts($vendorId)
  {
    $this->db->where('added_type', 2);
    $this->db->where('addedBy', $vendorId);
    $this->db->select('COUNT(DISTINCT product_code) as total');
    $query = $this->db->get('sub_product_master');
    return $query->row()->total ?? 0;
  }

  public function updateActionPaymentStatus($id)
  {
    $data = array(
      'action_payment' => 'delete'
    );

    $this->db->where('id', $id);
    return $this->db->update('order_master', $data);
  }

  public function getOrderList($type = '', $id = '')
  {
    $this->db->order_by('id', 'Desc');
    if ($type == '1') {
      return $this->db->query('SELECT  id    FROM order_master order by id Desc')->result_array();
    } else {
      return $this->db->query('SELECT DISTINCT  order_master_id FROM `purchase_master` Where vendor_master_id ="' . $id . '" order by order_master_id Desc ')->result_array();
    }
  }
  public function GetSingleData($id = '', $table = '', $field = '')
  {

    $sql = $this->db->query('SELECT * FROM `' . $table . '` Where id =' . $id . '')->row_array();
    return $sql[$field];
  }


  public function Getlocation($order_id = '', $selectField)
  {
    $query = $this->db->query("SELECT * from order_master  as OM left join user_address_master as UAM   on UAM.`id` = OM.`address_master_id` where OM.`id` = " . $order_id . "")->row_array();
    return $query[$selectField];
  }

  public function GetUserName($order_id = '', $selectField)
  {
    $query = $this->db->query("SELECT * from order_master  as OM left join user_master as UAM on UAM.`id` = OM.`user_master_id` where OM.`id` = " . $order_id . "")->row_array(); #echo $this->db->last_query(); exit;
    //echo $query[$selectField]; exit;
    return $query[$selectField];
  }

  public function AllOrderDetail($order_id = '')
  {
    $query = $this->db->query("SELECT * from order_master  where id = " . $order_id . "")->row_array();

    #echo $query['payment_type']; exit;
    return $query;
  }





  public function GetSingleData2($id = '', $table = '', $field = '')
  {

    $sql = $this->db->query('SELECT * FROM `' . $table . '` Where order_master_id =' . $id . '')->row_array();
    return $sql[$field];
  }

  public function GetUserAddres($id = '', $diliver = '')
  {
    if (!empty($diliver)) {
      $sql = $this->db->query('SELECT * FROM `user_delivery_address` Where id =' . $id . '')->row_array();
    } else {
      $sql = $this->db->query('SELECT * FROM `user_address_master` Where id =' . $id . '')->row_array();
    }


    return $sql;
  }

  public function GetOrderStatus($id = '', $table = '', $field = '')
  {
    $sql = $this->db->query('SELECT * FROM `' . $table . '` Where id =' . $id . '')->row_array();
    return $sql[$field];
  }

  public function GetProductImages($id = '', $table = '', $field = '')
  {

    $sql = $this->db->query('SELECT * FROM `' . $table . '` Where  `product_master_id` =' . $id . '')->row_array();

    return $sql[$field];
  }

  public function GetProductStatus($orderid = '', $type = '', $field = '', $vendor_id = '')
  {
    // echo $orderid."/".$type."/".$
    if ($type == '1') {
      $SQL = " SELECT * FROM `purchase_master` WHERE order_master_id = '" . $orderid . "'";
    }
    if ($type == '2') {
      $SQL = " SELECT * FROM `purchase_master` WHERE order_master_id = '" . $orderid . "'  AND vendor_master_id = '" . $vendor_id . "' ";
    }
    $status = $this->db->query($SQL)->row_array();
    return $status[$field];
  }
  public function CountProduct($orderid = '', $type = '', $field = '', $vendor_id = '')
  {


    if ($type == '1') {
      $SQL = " SELECT Sum(" . $field . ") as items FROM `purchase_master` WHERE order_master_id = '" . $orderid . "'";
    }
    if ($type == '2') {
      $SQL = " SELECT Sum(" . $field . ") as items FROM `purchase_master` WHERE order_master_id ='" . $orderid . "'  AND vendor_master_id = '" . $vendor_id . "' ";
    }
    $status = $this->db->query($SQL)->row_array();

    return $status['items'];
  }





  public function getSingleOrderData($orderid = '', $type = '', $vendor_id = '')
  {
    if ($type == '1') {
      $SQL = " SELECT * FROM `purchase_master` WHERE order_master_id = '" . $orderid . "'";
    } elseif ($type == '2') {
      $SQL = " SELECT * FROM `purchase_master` WHERE order_master_id = '" . $orderid . "'  AND vendor_master_id = '" . $vendor_id . "' ";
    }

    return $this->db->query($SQL)->result_array();
  }

  public function getSingleOrderData2($orderid = '', $type = '', $vendor_id = '')
  {

    $SQL = $this->db->get_where('order_master', array('id' => $orderid))->row_array();
    //echo $this->db->last_query(); exit;
    $getDetail = $this->db->get_where('transaction_history', array('txn_id' => $SQL['order_number']))->row_array();
    //echo $this->db->last_query(); exit;
    //print_r($getDetail); exit;

    return $getDetail;
  }

  public function GetAddress($id = '')
  {
    $SQL = " SELECT * FROM `order_master` WHERE id = '" . $id . "'";
    return $this->db->query($SQL)->row_array();
  }


  public function GetOrderPaymentType($id = '')
  {
    $SQL = " SELECT Om.`id`as Od_id,Om.`address_master_id`as shiping_add_id, Um.* FROM `order_master` as Om LEFT JOIN `user_master` as Um on Om.`user_master_id` = Um.`id` WHERE Om.`id` = '" . $id . "'";
    return $this->db->query($SQL)->row_array();
  }

  ##########################################################
  ######## OLD QUERY FOR VIEW ORDER PRODUCT ################
  ##########################################################

  /* public function getSingleOrderData($id='')
   {

     $slq = " SELECT PM.`id` AS  Purchase_id, PM.`vendor_master_id`, PM.`order_master_id`, PM.`product_master_id`, PM.`discount_type`, PM.`price`, PM.`final_price`, PM.`status` AS Purchase_status , PM.`quantity`, OM.`order_number`, OM.`user_master_id`, OM.`address_master_id`, OM.`total_price` AS Order_total_price, OM.`final_price` AS Order_final_price, Om.`payment_type`, AM.`name` AS Vendor_name , AM.`phone_no` AS Vendor_Contact, UM.`username` AS User_name, UAM.`name` AS Address_to, UAM.`phone_no`AS Address_phone_no , UAM.`pincode` AS Address_pincode, UAM.`locality` AS Address_locality , UAM.`area_streat_address` AS Address_area, UAM.`landmark_optional` AS Address_Landmark, UAM.`state_master_id`, SM.`state_name`, PDM.`product_name`, PDM.`price` As product_price 
           FROM `purchase_master` AS PM LEFT JOIN `Order_master` AS OM ON PM.`order_master_id` = OM.`id` 
           LEFT JOIN `admin_master` AS AM ON PM.`vendor_master_id` = AM.`id`
           LEFT JOIN `product_master` AS PDM ON PM.`product_master_id` = PDM.`id`
           LEFT JOIN `user_master` AS UM ON OM.`user_master_id` = UM.`id`
           LEFT JOIN `user_address_master` AS UAM ON OM.`address_master_id` = UAM.`id` 
           LEFT JOIN `state_master` AS SM ON UAM.`state_master_id` = SM.`id` 

            WHERE PM.`id` = '".$id."'";
           $exex =$this->db->query($slq)->row_array();

           return $exex; 

     //return $this->db->query('SELECT * FROM `purchase_master` Where id ='.$id.' ')->row_array();
   }*/


  public function UpdateOrderData($request)
  {
    $arrayName = array();
    $arrayName['status'] = $request['StatusUpdate'];
    $arrayName['modify_date'] = time();

    $activity = 0;
    if (!empty($request['activity'])) {
      $activity = $request['activity'];
    }

    /*print_r($request);
    die();*/
    $orde_logstatus = $request['StatusUpdate'];

    $this->db->where(array('order_master_id' => $request['order_id']));  #, 'vendor_master_id' => $request['vendor_id']
    $this->db->update('purchase_master', $arrayName);  #, 'vendor_master_id' => $request['vendor_id']

    if ($request['StatusUpdate'] == 5) {
      $this->db->where('id', $request['order_id']);
      $modify_date = time();
      $this->db->update('order_master', array('status' => 5, 'modify_date' => $modify_date, 'activity' => $activity));
      $orde_logstatus = 5;
    }

    if ($request['StatusUpdate'] == 6) {
      $this->db->where('id', $request['order_id']);
      $modify_date = time();
      $this->db->update('order_master', array('status' => 6, 'modify_date' => $modify_date, 'activity' => $activity));
      $orde_logstatus = 6;
    }
    if ($request['StatusUpdate'] == 2) {
      $this->db->where('id', $request['order_id']);
      $modify_date = time();
      $this->db->update('order_master', array('status' => 2, 'modify_date' => $modify_date, 'activity' => $activity));
      $orde_logstatus = 2;
    }

    if ($request['StatusUpdate'] == 4) {
      $this->db->where('id', $request['order_id']);
      $modify_date = time();
      $this->db->update('order_master', array('status' => 4, 'modify_date' => $modify_date, 'activity' => $activity));
      $orde_logstatus = 4;
    }

    if ($request['StatusUpdate'] == 3) {
      $this->db->where('id', $request['order_id']);
      $modify_date = time();
      $this->db->update('order_master', array('status' => 3, 'modify_date' => $modify_date, 'activity' => $activity));
      $orde_logstatus = 3;
    }

    $save_log = array(
      'order_master_id' => $request['order_id'],
      'order_status' => $orde_logstatus,
      'remark' => ucfirst($request['remark']),
      'status' => 1,
      'add_date' => time(),
      'modify_date' => time()
    );
    $this->db->insert('order_log_history', $save_log);
    return $this->db->affected_rows();
  }


  public function OrderStatus($order_id)
  {
    $this->db->select('status');
    $query = $this->db->get_where('order_master', array('id' => $order_id))->row_array();
    return $query['status'];
  }
  public function GetVersions()
  {
    $check = $this->db->get('settings')->result_array();

    $fields = array();
    foreach ($check as $key => $value) {

      $fields['version'] = $value['app_verison'];
      $fields['install_type'] = $value['type'];
      $fields[STATUS] = "1";
      $array[] = $fields;
    }

    if (COUNT($check) > 0) {
      $arr['Detail'] = $array;
      generateServerResponse(S, 'S', $arr);
    } else {
      generateServerResponse('0', 'E');
    }
  }

  public function getDataByrowArray($table, $colname, $id)
  {
    return $this->db->get_where($table, array($colname => $id))->row_array();
    // echo $this->db->last_query();ex
  }

  public function GetShareEarnvalue()
  {
    $check = $this->db->get('settings')->result_array();

    $fields = array();
    foreach ($check as $key => $value) {

      $fields['user_amount'] = $value['referel_to_get'];
      $fields['minimumPurchase'] = $value['min_first_purchase_amt'];
      $fields['banner'] = base_url() . 'assets/banner_images/' . $value['banner'];
      $array[] = $fields;
    }

    if (COUNT($check) > 0) {
      $arr['Detail'] = $array;
      generateServerResponse(S, 'S', $arr);
    } else {
      generateServerResponse('0', 'E');
    }
  }
  public function GetData($table, $condition, $order, $id)
  {
    if (!empty($id)) {
      $data = $this->db->get_where($table, $condition)->row_array();
    } else {
      if (!empty($order)) {
        $this->db->order_by($order['column'], $order['columnData']);
      }
      $data = $this->db->get_where($table, $condition)->result_array();
    }
    return $data;
  }
  public function selectColumn($column, $table, $condition, $id = '')
  {
    $this->db->select($column);
    $this->db->where($condition);
    if (!empty($id)) {
      $data = $this->db->get($table)->row_array();
    } else {
      $data = $this->db->get($table)->result_array();
    }
    return $data;
  }


  public function getShippAdd($id)
  {
    $this->db->select('district_city_town,address1');
    return $this->db->get_where('user_addressmaster', array('id' => $id))->row_array();
  }


  // ratna code 
  public function getOrderSummary()
  {
    $summary = [];


    $summary['delivered_orders'] = $this->db->where('status', 3)
      ->from('order_master')
      ->count_all_results();


    $summary['pending_orders'] = $this->db->where('status !=', 3)
      ->from('order_master')
      ->count_all_results();
    $summary['failed_orders'] = $this->db->where('status', 2)
      ->from('order_master')
      ->count_all_results();

    $summary['cancelled_orders'] = $this->db->where('status', 4)
      ->from('order_master')
      ->count_all_results();


    $summary['shipped_orders'] = $this->db->where('status', 5)
      ->from('order_master')
      ->count_all_results();


    $summary['waiting_approval_orders'] = $this->db->where('status', 1)
      ->from('order_master')
      ->count_all_results();


    $summary['rejected_orders'] = $this->db->where('status', 6)
      ->from('order_master')
      ->count_all_results();

    $summary['total_orders'] = $this->db->count_all('order_master');

    return $summary;
  }
}
