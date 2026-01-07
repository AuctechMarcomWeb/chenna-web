<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Web extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->database();
    $this->load->library('cart');
    $this->load->model('Website_model', 'web_model');
    $this->load->model('User_master_model');
    $this->load->model('Review_model');
    $this->load->library('pagination');

  }

  public function change_mobile_number()
  {
    $new_mobile = $this->input->post('new_mobile');
    $old_mobile = $this->input->post('old_mobile');
    $fields['mobile'] = $new_mobile;
    $this->db->where('mobile', $old_mobile);
    $row = $this->db->update('user_master', $fields);

    if ($row > 0)
    {
      echo '1';
      exit;
    } else
    {
      echo '2';
      exit;
    }

  }

  public function sendVerificationSMS()
  {
    // Get the mobile number, product ID, and OTP from POST data
    $mobile_num = $this->input->post('mobile_num');
    // $product_id = $this->input->post('pro_id');
    $mobile_otp = $this->input->post('otp');
    $mobile = $mobile_num;
    // Check if the mobile number is valid (10 digits) and OTP is provided
    if (preg_match('/^\d{10}$/', $mobile_num) && !empty($mobile_otp))
    {

      // Prepare the SMS text
      $text = 'Dear Customer, Your Mobile Verification OTP is: ' . $mobile_otp . '. Please enter this OTP to verify your mobile number. From www.Dukekart.in Regards, Dukekart Real Time Private Limited';

      // Send the SMS
      sendSMS($mobile_num, $text, '1007086055987083292');

      // Return a success response
      $this->output
        ->set_status_header(200)
        ->set_content_type('application/json')
        ->set_output(json_encode(['status' => 'Success', 'message' => 'SMS sent successfully']));
    } else
    {
      // Return an error response for invalid mobile number or missing OTP
      $this->output
        ->set_status_header(400)
        ->set_content_type('application/json')
        ->set_output(json_encode(['status' => 'Error', 'message' => 'Invalid mobile number or OTP']));
    }
  }


  public function AddUserCartData()
  {
    // Get the mobile number, product ID, and OTP from POST data
    $mobile_num = $this->input->post('mobile_num');
    $product_id = $this->input->post('pro_id');
    $mobile_otp = $this->input->post('otp');
    $mobile = $mobile_num;

    // Prepare data for insertion
    $data = array(
      'PRODUCT_ID' => $product_id,
      'USER_MOBILE' => $mobile_num,
    );

    // Insert data into ORDER_QUERY table
    $this->db->insert('ORDER_QUERY', $data);


  }

  public function sendVerificationSMS_old()
  {
    // Get the mobile number from POST data
    $mobile_num = $this->input->post('mobile_num');
    $product_id = $this->input->post('pro_id');

    // Extract only digits from the mobile number
    $mobile = $mobile_num;
    $mobile_otp = $this->input->post('otp');

    // Check if the mobile number is valid (10 digits)
    if (strlen($mobile) === 10 && strlen($mobile_otp) != 0)
    {
      // You can also get other parameters like $message and $template from POST data if needed
      $data = array(
        'PRODUCT_ID' => $product_id,
        'USER_MOBILE' => $mobile_num,
      );

      // Insert data into ORDER_QUERY table
      //  $this->ORDER_QUERY->insert($data);
      $this->db->insert('ORDER_QUERY', $data);
      $text = 'Dear Customer Your Mobile Verification OTP is: ' . $mobile_otp . ' Please enter this OTP to verify your mobile number. From www.Dukekart.inRegardsDukekart Real Time Private Limited';

      sendSMS($mobile_num, $text, '1007086055987083292');

      $this->output
        ->set_status_header(200)
        ->set_content_type('application/json')
        ->set_output(json_encode(['status' => 'Success', 'message' => 'SMS sent successfully']));
    } else
    {
      // Return an error response for invalid mobile number
      $this->output
        ->set_status_header(400)
        ->set_content_type('application/json')
        ->set_output(json_encode(['status' => 'Error', 'message' => 'Invalid mobile number']));
    }
  }


  public function product_search()
  {
    $search_input = $this->input->post('search_data');
    $search_data = trim($search_input);
    $output = '';
    $this->db->select('product_name');
    $this->db->like('product_name', $search_data);
    $this->db->group_by('product_code');
    $res = $this->db->get_where('sub_product_master', array('status' => '1'))->result_array();
    $output = '<ul class="list-unstyled search_list">';

    if ($res)
    {
      foreach ($res as $row)
      {
        $output .= '<li class="li_list">' . $row["product_name"] . '</li>';
      }
    } else
    {
      $output .= '<li class="li_list">Search Was Not Found</li>';
    }
    $output .= '</ul>';
    echo $output;

  }

  public function add_to_cart()
  {
    $pro_id = (int) $this->input->post('pro_id');
    $qty = (int) $this->input->post('quantity');

    if ($qty < 1)
      $qty = 1;

    $product_info = $this->db->get_where('sub_product_master', ['id' => $pro_id])->row_array();

    if (!$product_info)
    {
      echo json_encode(['cart_val' => $this->cart->total_items(), 'qty' => 'false']);
      return;
    }


    $total_item = $this->cart->contents();
    $pro_qty = 0;
    foreach ($total_item as $value)
    {
      if ($pro_id == $value['id'])
      {
        $pro_qty = $value['qty'];
      }
    }

    if ($product_info['quantity'] >= ($pro_qty + $qty))
    {


      $name_clean = str_replace(
        ['"', "'", "(", ")", "#", "&", "|", "/", "-", "_", "@", "$", "*", "!", "?", "%", "+", "=", "~", "`", "^", "<", ">", "{", "}", "[", "]", ";", ":", ",", ".", "\\"],
        '',
        $product_info['product_name']
      );


      $data = array(
        'id' => $product_info['id'],
        'qty' => $qty,
        'size' => $product_info['size'],
        'color' => $product_info['color'],
        'brand' => $product_info['brand'],
        'price' => $product_info['price'],
        'final_price' => $product_info['final_price'],
        'name' => $name_clean,
        'image' => $product_info['main_image']
      );

      $this->cart->insert($data);

      echo json_encode([
        'cart_val' => $this->cart->total_items(),
        'qty' => 'true'
      ]);

    } else
    {
      echo json_encode([
        'cart_val' => $this->cart->total_items(),
        'qty' => 'false'
      ]);
    }
  }


  // in old function quantity if fix which is 1 
  public function add_to_cart_old()
  {

    $pro_id = $this->input->post('pro_id');

    $total_item = $this->cart->contents();
    $pro_qty = 0;
    foreach ($total_item as $value)
    {
      if ($pro_id == $value['id'])
      {
        $pro_qty = $value['qty'];
      }

    }

    $pro_id = $this->input->post('pro_id');

    $product_info = $this->db->get_where('sub_product_master', array('id' => $pro_id))->row_array();


    if ($product_info['quantity'] > $pro_qty)
    {

      if (!empty($product_info))
      {
        $qty = 1;
      }

      $data = array(
        'id' => $product_info['id'],
        'qty' => $qty,
        'size' => $product_info['size'],
        'color' => $product_info['color'],
        'brand' => $product_info['brand'],
        'price' => $product_info['price'],
        'final_price' => $product_info['final_price'],
        'name' => str_replace(['(', ')'], '', $product_info['product_name']),
        'image' => $product_info['main_image']
      );

      $insert_Data = $this->cart->insert($data);

      $data_val['cart_val'] = $this->cart->total_items();
      $data_val['qty'] = 'true';
      $data_val['data'] = $insert_Data;

      $cart_total = $this->cart->total_items();
      echo json_encode($data_val);

    } else
    {

      $data_val['cart_val'] = $this->cart->total_items();
      $data_val['qty'] = 'false';
      echo json_encode($data_val);
    }


  }

  public function cart_icon_partial()
  {
    $this->load->view('web/cart_icon');
  }

  public function right_cart_icon_partial()
  {
    $this->load->view('web/right_cart_icon');
  }

  public function user_cart_data()
  {
    $this->load->view('web/user_cart');
  }

  public function category_list($id)
  {
    $data['getData'] = $this->db->select('id, category_name, app_icon')
      ->from('category_master')
      ->where('mai_id', $id)
      ->where('status', 1)
      ->get()
      ->result_array();

    if ($id == 2)
    {
      $data['p_cat'] = "fresh-fruits";
    } else if ($id == 3)
    {
      $data["p_cat"] = "fresh-vegetables";
    } else if ($id == 7)
    {
      $data['p_cat'] = "chicken-meat";
    } else if ($id == 12)
    {
      $data['p_cat'] = "kalanamak-rice";
    } else if ($id == 16)
    {
      $data['p_cat'] = "spices";
    } else if ($id == 13)
    {
      $data['p_cat'] = "dairy-items";
    } else
    {
      $data['p_cat'] = "dry-fruits";
    }

    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['title'] = 'Category | Dukekart';


    $this->load->view('web/include/header', $data);
    $this->load->view('web/category_items');
    $this->load->view('web/include/footer');
  }

  public function index()
  {
    $userData = $this->session->userdata('User');

    // Wishlist count
    $data['wishlist_count'] = !empty($userData) ? $this->web_model->get_total_wishlist_by_user($userData['id']) : 0;

    // Product Data
    $data['fetureProduct'] = $this->web_model->getFetureProduct();
    $data['topSellProduct'] = $this->web_model->getTopSellProduct();
    $data['productForYou'] = $this->web_model->getProductForYou();
    $data['mensCollection'] = $this->web_model->getmensCollection();
    $data['womensCollection'] = $this->web_model->getwomensCollection();
    $data['footWear'] = $this->web_model->getfootWear();
    $data['kidscollection'] = $this->web_model->getkidscollection();
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();

    // ✅ Fetch Parent & Child Categories
    $data['categories'] = $this->db
      ->select('p.id as parent_id, p.name as parent_name, c.id as category_id, c.category_name, c.app_icon')
      ->from('parent_category_master p')
      ->join('category_master c', 'c.mai_id = p.id', 'left')
      ->where('p.status', '1')
      ->where('c.status', '1')
      ->order_by('p.id', 'ASC')
      ->order_by('c.id', 'ASC')
      ->get()
      ->result_array();

    $data['title'] = 'Welcome to Dukekart | Shop Online with Best Offers‎';

    // Load views
    $this->load->view('web/include/header', $data);
    $this->load->view('web/home');
    $this->load->view('web/include/footer');
  }


  public function vegetable_item_list()
  {
    $parent_category_id = 3;

    $this->db->select('*');
    $this->db->from('sub_product_master');
    $this->db->where('parent_category_id', $parent_category_id);
    $this->db->where('status', 1);

    $result = $this->db->get()->result_array();
    $data['getData'] = $result;
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['title'] = "Vegetables | Dukekart";
    $this->load->view('web/include/header', $data);
    $this->load->view('web/category_product_list');
    $this->load->view('web/include/cart_footer');
  }

  public function chicken_item_list()
  {
    $parent_category_id = 7;

    $this->db->select('*');
    $this->db->from('sub_product_master');
    $this->db->where('parent_category_id', $parent_category_id);
    $this->db->where('status', 1);

    $result = $this->db->get()->result_array();
    $data['getData'] = $result;
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['title'] = "Vegetables | Dukekart";
    $this->load->view('web/include/header', $data);
    $this->load->view('web/category_product_list');
    $this->load->view('web/include/cart_footer');
  }

  public function grocery_item_list()
  {
    $parent_category_id = 14;

    $this->db->select('*');
    $this->db->from('sub_product_master');
    $this->db->where('parent_category_id', $parent_category_id);
    $this->db->where('status', 1);

    $result = $this->db->get()->result_array();
    $data['getData'] = $result;
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['title'] = "Vegetables | Dukekart";
    $this->load->view('web/include/header', $data);
    $this->load->view('web/category_product_list');
    $this->load->view('web/include/cart_footer');
  }

  public function search_product_list()
  {
    $keywords = trim(@$_GET['gsearch']);
    $bannerList = $this->web_model->getBannerList();
    $MainCategoryList = $this->web_model->getMainCategoryList();
    $limit = 12;
    $pageNo = !empty($_GET['per_page']) ? (int) $_GET['per_page'] : 1;
    $offset = ($pageNo - 1) * $limit;

    // Count total unique products matching the keyword
    $this->db->select('product_name');
    $this->db->from('sub_product_master');
    $this->db->where('status', '1');
    if (!empty($keywords))
    {
      $this->db->like('product_name', $keywords);
    }
    $this->db->group_by('product_name');
    $totalRecords = $this->db->count_all_results(); // ← reset automatically

    // Pagination config
    $config["base_url"] = base_url("web/search_product_list?gsearch=" . urlencode($keywords));
    $config["total_rows"] = $totalRecords;
    $config["per_page"] = $limit;
    $config['use_page_numbers'] = TRUE;
    $config['page_query_string'] = TRUE;
    $config['enable_query_strings'] = TRUE;
    $config['num_links'] = 2;
    $config['cur_tag_open'] = '&nbsp;<li class="active"><a>';
    $config['cur_tag_close'] = '</a></li>';
    $config['next_link'] = 'Next';
    $config['prev_link'] = 'Previous';
    $this->pagination->initialize($config);
    $links = explode('&nbsp;', $this->pagination->create_links());

    // Fetch products with grouped variations
    $this->db->select("
        MIN(id) as id,
        product_name,
        MIN(price) as price,
        MIN(final_price) as final_price,
        MIN(main_image) as main_image,
        SUM(quantity) as total_qty
    ");
    $this->db->from('sub_product_master');
    $this->db->where('status', '1');
    if (!empty($keywords))
    {
      $this->db->like('product_name', $keywords);
    }
    $this->db->group_by('product_name');
    $this->db->order_by('id', 'DESC');
    $this->db->limit($limit, $offset);
    $AllRecord = $this->db->get()->result_array();

    // Fetch all variations for each product
    foreach ($AllRecord as &$product)
    {
      $product['variations'] = $this->db->select('id,size,color,final_price,price, quantity')
        ->from('sub_product_master')
        ->where('status', '1')
        ->where('product_name', $product['product_name'])
        ->get()
        ->result_array();
    }

    // Load viewss
    $this->load->view('web/include/header', [
      'search_data' => $keywords,
      'totalResult' => $totalRecords,
      'getData' => $AllRecord,
      'pano' => $pageNo,
      'links' => $links,
      'bannerList' => $bannerList,
      'MainCategoryList' => $MainCategoryList,
      'title' => 'Searching Product'
    ]);

    $this->load->view('web/seacrh_product_list');
    $this->load->view('web/include/footer');
  }




  public function get_product_suggestions()
  {
    $search = $this->input->post('search');

    $this->db->select('product_name');
    $this->db->from('sub_product_master');
    $this->db->like('product_name', $search);
    $this->db->limit(10);
    $query = $this->db->get();

    foreach ($query->result_array() as $row)
    {
      echo '<div class="suggestion-item" style="padding: 8px; cursor: pointer; border-bottom: 1px solid #eee;">' . htmlspecialchars($row['product_name']) . '</div>';
    }
  }


  public function save_message()
  {
    $this->load->library('user_agent');
    $data = array(
      'full_name' => $this->input->post('full_name', true),
      'email' => $this->input->post('email', true),
      'phone' => $this->input->post('phone', true),
      'message' => $this->input->post('message', true),
      'created_at' => date('Y-m-d H:i:s')
    );

    $this->db->insert('user_messages', $data);
    $this->session->set_flashdata('msg', 'Message sent successfully!');
    redirect($this->agent->referrer());
  }






  public function category_product_list_old($main, $category)
  {


    // echo "<pre>";print_r($category);exit();

    $categoryArray = explode("-", $category);
    $categoryArray2 = str_replace("-", " ", $category);
    ;
    $bannerList = $this->web_model->getBannerList();
    $MainCategoryList = $this->web_model->getMainCategoryList();



    if (empty($_GET['keyword']))
    {

      $a = $this->web_model->getDataBySubCate($main, $categoryArray['0']);

      $config["base_url"] = base_url('' . $main . '/' . $categoryArray['0'] . '?keyword=');



    } else if (!empty($_GET['keyword']))
    {

      $keyword = $_GET['keyword'];

      $a = $this->web_model->getDataBySubCate($main, $categoryArray['0']);

      $config["base_url"] = base_url('' . $main . '/' . $categoryArray['0'] . '?keyword=');
    }




    $totalRecords = count($a);
    $limit = 12;

    $config["total_rows"] = $totalRecords;
    $config["per_page"] = $limit;
    $config['use_page_numbers'] = TRUE;
    $config['page_query_string'] = TRUE;
    $config['enable_query_strings'] = TRUE;
    $config['num_links'] = 2;
    $config['cur_tag_open'] = '&nbsp;<li class="active"><a>';
    $config['cur_tag_close'] = '</a></li>';
    $config['next_link'] = 'Next';
    $config['prev_link'] = 'Previous';
    $this->pagination->initialize($config);
    $str_links = $this->pagination->create_links();
    $links = explode('&nbsp;', $str_links);
    $pageNo = "";
    $offset = 0;

    if (!empty($_GET['per_page']))
    {
      $pageNo = $_GET['per_page'];
      $offset = ($pageNo - 1) * $limit;
    }

    if (empty($_GET['keyword']))
    {
      $men = $main;
      $category = $categoryArray['0'];

      $main = str_replace('-', ' ', strtolower($main));
      $category = str_replace('-', ' ', strtolower($category));


      $mainCategory = $this->db->select('id')
        ->from('parent_category_master')
        ->where('status', '1')
        ->where("name LIKE '%$main%'")
        ->get()->row_array();



      $category = $this->db->select('id')
        ->from('category_master')
        ->where('mai_id', $mainCategory['id'])
        ->where('status', '1')
        ->where("category_name LIKE '%$category%'")
        ->get()->row_array();



      $this->db->select('id,sub_category_id,product_name,price,final_price,size,color,quantity,main_image');
      $this->db->order_by('id', 'DESC');

      $this->db->limit($limit, $offset);
      $AllRecord = $this->db->get_where('sub_product_master', array('status' => '1', 'category_id' => $category['id'], 'parent_category_id' => $mainCategory['id']))->result_array();


    } else if (!empty($_GET['keyword']))
    {

      $keyword = $_GET['keyword'];

      $men = $main;
      $category = $categoryArray['0'];

      $main = str_replace('-', ' ', strtolower($main));
      $category = str_replace('-', ' ', strtolower($category));


      $mainCategory = $this->db->select('id')
        ->from('parent_category_master')
        ->where("name LIKE '%$main%'")
        ->get()->row_array();

      $category = $this->db->select('id')
        ->from('category_master')
        ->where("category_name LIKE '%$category%'")
        ->get()->row_array();


      $this->db->select('id,sub_category_id,product_name,price,final_price,size,color,quantity,main_image');
      $this->db->order_by('id', 'DESC');
      $this->db->limit($limit, $offset);
      $AllRecord = $this->db->get_where('sub_product_master', array('status' => '1', 'category_id' => $category['id'], 'parent_category_id' => $mainCategory['id']))->result_array();


    }



    $this->load->view(
      'web/include/header',
      array(
        'totalResult' => $totalRecords,
        'getData' => $AllRecord,
        'pano' => $pageNo,
        'links' => $links,
        'index2' => '',
        'bannerList' => $bannerList,
        'MainCategoryList' => $MainCategoryList,
        'title' => $main . ' | ' . $categoryArray['0'] . ' | Dukekart',
        'index2' => ''
      )
    );

    $this->load->view('web/category_product_list');
    $this->load->view('web/include/footer');
  }

  // new function

  public function category_product_list($main, $category)
  {
    // -------------------- User & Wishlist --------------------
    $userData = $this->session->userdata('User');
    $user_id = !empty($userData) ? $userData['id'] : null;

    // Wishlist count
    $wishlist_count = !empty($user_id)
      ? $this->web_model->get_total_wishlist_by_user($user_id)
      : 0;

    // -------------------- Category, Banner & Main Categories --------------------
    $categoryArray = explode("-", $category);
    $bannerList = $this->web_model->getBannerList();
    $MainCategoryList = $this->web_model->getMainCategoryList();

    // -------------------- Pagination --------------------
    $limit = 12;
    $pageNo = (!empty($_GET['per_page'])) ? $_GET['per_page'] : 1;
    $offset = ($pageNo - 1) * $limit;

    // Get Main & Category IDs
    $mainName = str_replace('-', ' ', strtolower($main));
    $cateName = str_replace('-', ' ', strtolower($categoryArray[0]));

    $mainCategory = $this->db->select('id')
      ->from('parent_category_master')
      ->where('status', '1')
      ->like('name', $mainName)
      ->get()->row_array();

    $categoryRow = $this->db->select('id')
      ->from('category_master')
      ->where('mai_id', $mainCategory['id'])
      ->where('status', '1')
      ->like('category_name', $cateName)
      ->get()->row_array();

    $mainCategoryId = !empty($mainCategory['id']) ? $mainCategory['id'] : 0;
    $categoryId = !empty($categoryRow['id']) ? $categoryRow['id'] : 0;

    // -------------------- Total unique products --------------------
    $this->db->select('COUNT(DISTINCT product_name) as total');
    $this->db->from('sub_product_master');
    $this->db->where('status', '1');
    $this->db->where('category_id', $categoryId);
    $this->db->where('parent_category_id', $mainCategoryId);
    if (!empty($_GET['keyword']))
    {
      $this->db->like('product_name', $_GET['keyword']);
    }
    $totalRecords = $this->db->get()->row()->total;

    // -------------------- Fetch products --------------------
    $this->db->select('id, product_name, price, final_price, main_image, quantity');
    $this->db->from('sub_product_master');
    $this->db->where('status', '1');
    $this->db->where('category_id', $categoryId);
    $this->db->where('parent_category_id', $mainCategoryId);
    if (!empty($_GET['keyword']))
    {
      $this->db->like('product_name', $_GET['keyword']);
    }
    $this->db->order_by('id', 'DESC');
    $this->db->group_by('product_name');
    $this->db->limit($limit, $offset);
    $AllRecord = $this->db->get()->result_array();

    // -------------------- Fetch all variations per product --------------------
    foreach ($AllRecord as &$product)
    {
      $product['variations'] = $this->db->select('id, size, color, final_price, quantity')
        ->from('sub_product_master')
        ->where('status', '1')
        ->where('product_name', $product['product_name'])
        ->get()
        ->result_array();
    }

    // -------------------- Pagination config --------------------
    $config["base_url"] = base_url($main . '/' . $categoryArray[0] . '?keyword=' . (!empty($_GET['keyword']) ? $_GET['keyword'] : ''));
    $config["total_rows"] = $totalRecords;
    $config["per_page"] = $limit;
    $config['use_page_numbers'] = TRUE;
    $config['page_query_string'] = TRUE;
    $config['enable_query_strings'] = TRUE;
    $config['num_links'] = 2;
    $config['cur_tag_open'] = '&nbsp;<li class="active"><a>';
    $config['cur_tag_close'] = '</a></li>';
    $config['next_link'] = 'Next';
    $config['prev_link'] = 'Previous';
    $this->pagination->initialize($config);

    $str_links = $this->pagination->create_links();
    $links = explode('&nbsp;', $str_links);

    // -------------------- Load views --------------------
    $this->load->view('web/include/header', [
      'totalResult' => $totalRecords,
      'getData' => $AllRecord,
      'pano' => $pageNo,
      'links' => $links,
      'bannerList' => $bannerList,
      'MainCategoryList' => $MainCategoryList,
      'user_id' => $user_id,
      'wishlist_count' => $wishlist_count, // ✅ Pass wishlist count
      'title' => ucfirst($main) . ' | ' . ucfirst($categoryArray[0]) . ' | Dukekart'
    ]);

    $this->load->view('web/category_product_list');
    $this->load->view('web/include/footer');
  }



  // new function


  public function sub_category_product_list($main, $category, $sub)
  {
    // -------------------- User & Wishlist --------------------
    $userData = $this->session->userdata('User');
    $user_id = !empty($userData) ? $userData['id'] : null;

    // Wishlist count
    $wishlist_count = !empty($user_id)
      ? $this->web_model->get_total_wishlist_by_user($user_id)
      : 0;

    // -------------------- Convert slug to readable names --------------------
    $mainSlug = str_replace('-', ' ', strtolower($main));
    $categorySlug = str_replace('-', ' ', strtolower($category));
    $subSlug = str_replace('-', ' ', strtolower($sub));

    // -------------------- Banner & Main Categories --------------------
    $bannerList = $this->web_model->getBannerList();
    $MainCategoryList = $this->web_model->getMainCategoryList();

    // -------------------- Pagination setup --------------------
    $limit = 12;
    $pageNo = !empty($_GET['per_page']) ? (int) $_GET['per_page'] : 1;
    $offset = ($pageNo - 1) * $limit;

    // -------------------- Get category IDs --------------------
    $mainCategory = $this->db->select('id')->from('parent_category_master')
      ->where('status', '1')->like('name', $mainSlug)->get()->row_array();

    $categoryRow = $this->db->select('id')->from('category_master')
      ->where('mai_id', $mainCategory['id'])->where('status', '1')
      ->like('category_name', $categorySlug)->get()->row_array();

    $subCategoryRow = $this->db->select('id')->from('sub_category_master')
      ->where('category_master_id', $categoryRow['id'])->where('status', '1')
      ->where('sub_category_name', $subSlug)->get()->row_array();

    // -------------------- Fetch products grouped by name --------------------
    $this->db->select("
        MIN(id) as id,
        product_name,
        MIN(price) as price,
        MIN(final_price) as final_price,
        MIN(main_image) as main_image,
        SUM(quantity) as total_qty
    ");
    $this->db->from('sub_product_master');
    $this->db->where('status', '1');
    $this->db->where('parent_category_id', $mainCategory['id']);
    $this->db->where('category_id', $categoryRow['id']);
    $this->db->where('sub_category_id', $subCategoryRow['id']);

    if (!empty($_GET['keyword']))
    {
      $keyword = trim($_GET['keyword']);
      $this->db->group_start()
        ->like('product_name', $keyword)
        ->or_like('color', $keyword)
        ->or_like('size', $keyword)
        ->group_end();
    }

    $this->db->group_by('product_name');
    $totalRecords = $this->db->count_all_results('', FALSE);

    // -------------------- Pagination config --------------------
    $config["base_url"] = base_url("$main/$category/$sub?keyword=" . (!empty($_GET['keyword']) ? $_GET['keyword'] : ''));
    $config["total_rows"] = $totalRecords;
    $config["per_page"] = $limit;
    $config['use_page_numbers'] = TRUE;
    $config['page_query_string'] = TRUE;
    $config['enable_query_strings'] = TRUE;
    $config['num_links'] = 2;
    $config['cur_tag_open'] = '&nbsp;<li class="active"><a>';
    $config['cur_tag_close'] = '</a></li>';
    $config['next_link'] = 'Next';
    $config['prev_link'] = 'Previous';
    $this->pagination->initialize($config);

    $this->db->order_by('id', 'DESC');
    $this->db->limit($limit, $offset);
    $AllRecord = $this->db->get()->result_array();

    // -------------------- Fetch variations per product --------------------
    foreach ($AllRecord as &$product)
    {
      $product['variations'] = $this->db->select('id, size, color, final_price, price, quantity')
        ->from('sub_product_master')
        ->where('status', '1')
        ->where('parent_category_id', $mainCategory['id'])
        ->where('category_id', $categoryRow['id'])
        ->where('sub_category_id', $subCategoryRow['id'])
        ->where('product_name', $product['product_name'])
        ->order_by('id', 'ASC')
        ->get()->result_array();

      if (!empty($product['variations']))
      {
        $firstVar = $product['variations'][0];
        $product['default_size'] = $firstVar['size'];
        $product['default_color'] = $firstVar['color'];
        $product['default_final_price'] = $firstVar['final_price'];
        $product['default_price'] = $firstVar['price'];
        $product['default_variation_id'] = $firstVar['id'];
      }
    }

    // -------------------- Load views --------------------
    $this->load->view('web/include/header', [
      'getData' => $AllRecord,
      'totalResult' => $totalRecords,
      'pano' => $pageNo,
      'links' => explode('&nbsp;', $this->pagination->create_links()),
      'bannerList' => $bannerList,
      'MainCategoryList' => $MainCategoryList,
      'user_id' => $user_id,
      'wishlist_count' => $wishlist_count, // ✅ Pass wishlist count
      'title' => ucfirst($mainSlug) . ' | ' . ucfirst($categorySlug) . ' | ' . ucfirst($subSlug) . ' | Dukekart'
    ]);

    $this->load->view('web/sub_category_product_list');
    $this->load->view('web/include/footer');
  }







  public function home_product_list($tag, $id)
  {
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['getData'] = $this->web_model->getDataByTag($tag, $id);
    $data['title'] = $tag . ' products | Dukekart';
    $this->load->view('web/include/header', $data);
    $this->load->view('web/tag_product_list');
    $this->load->view('web/include/footer');

  }


  public function order_detail($order_id)
  {

    $userData = $this->session->userdata('User');
    $data['userInfo'] = $this->db->get_where('user_master', array('id' => $userData['id']))->row_array();
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['getData'] = $this->db->get_where('purchase_master', array('order_master_id' => $order_id))->result_array();

    $data['pdf_link'] = $this->db->select('pdf_link')
      ->get_where('order_master', array('id' => $order_id))
      ->row()
      ->pdf_link;
    $data['title'] = 'Order Details | Dukekart ';
    $this->load->view('web/include/header', $data);
    $this->load->view('web/order_details');
    $this->load->view('web/include/footer');

  }


  public function order_invoice($order_id_encoded)
  {
    $order_id = base64_decode($order_id_encoded);


    $order = $this->db->get_where('order_master', ['id' => $order_id])->row_array();


    $this->db->select('p.*, s.product_name, s.main_image,s.product_hsn, s.gst, s.sku_code, s.color, s.size');
    $this->db->from('purchase_master as p');
    $this->db->join('sub_product_master as s', 's.id = p.product_master_id', 'left');
    $this->db->where('p.order_master_id', $order_id);
    $purchase_items = $this->db->get()->result_array();


    if (empty($purchase_items))
    {
      $this->db->select('p.*, s.product_name, s.main_image,s.product_hsn, s.sku_code,s.gst, s.color, s.size');
      $this->db->from('purchase_master2 as p');
      $this->db->join('sub_product_master as s', 's.id = p.product_master_id', 'left');
      $this->db->where('p.order_master_id', $order_id);
      $purchase_items = $this->db->get()->result_array();
    }


    $address = $this->db->get_where('order_address_master', ['order_master_id' => $order_id])->row_array();


    if (!$order)
    {
      log_message('error', 'Order not found: ' . $order_id);
    }
    if (empty($purchase_items))
    {
      log_message('error', 'No purchase items found for order: ' . $order_id);
    }
    if (!$address)
    {
      log_message('error', 'No shipping address found for order: ' . $order_id);
    }


    $data['order'] = $order;
    $data['purchase_items'] = $purchase_items;
    $data['address'] = $address;
    $data['order_id_encoded'] = $order_id_encoded;
    $data['title'] = 'Order Details | Dukekart';


    $this->load->view('web/order_invoice', $data);


  }

  public function order_details($order_id_encoded)
  {
    $order_id = base64_decode($order_id_encoded);

    // Fetch order details
    $order = $this->db->get_where('order_master', ['id' => $order_id])->row_array();

    // --- PURCHASE_MASTER table data ---
    $this->db->select('p.*, s.product_name, s.main_image, s.color, s.gst, s.size');
    $this->db->from('purchase_master as p');
    $this->db->join('sub_product_master as s', 's.id = p.product_master_id', 'left');
    $this->db->where('p.order_master_id', $order_id);
    $purchase_items1 = $this->db->get()->result_array();

    // --- PURCHASE_MASTER2 table data ---
    $this->db->select('p.*, s.product_name, s.main_image, s.color, s.gst, s.size');
    $this->db->from('purchase_master2 as p');
    $this->db->join('sub_product_master as s', 's.id = p.product_master_id', 'left');
    $this->db->where('p.order_master_id', $order_id);
    $purchase_items2 = $this->db->get()->result_array();

    // --- Merge dono tables ka data ---
    $purchase_items = array_merge($purchase_items1, $purchase_items2);

    // --- Order address data ---
    $address = $this->db->get_where('order_address_master', ['order_master_id' => $order_id])->row_array();

    // --- Error logging (optional) ---
    if (!$order)
    {
      log_message('error', 'Order not found: ' . $order_id);
    }
    if (empty($purchase_items))
    {
      log_message('error', 'No purchase items found for order: ' . $order_id);
    }
    if (!$address)
    {
      log_message('error', 'No shipping address found for order: ' . $order_id);
    }

    // --- View Data ---
    $data['order'] = $order;
    $data['purchase_items'] = $purchase_items;
    $data['address'] = $address;
    $data['order_id_encoded'] = $order_id_encoded;
    $data['title'] = 'Order Details | Jail Store';

    // --- Load Views ---
    $this->load->view('web/include/header', $data);
    $this->load->view('web/order_details', $data);
    $this->load->view('web/include/footer');
  }



  public function product_detail($id = "")
  {
    // -------------------- User & Wishlist --------------------
    $userData = $this->session->userdata('User');
    $user_id = !empty($userData) ? $userData['id'] : null;

    $wishlist_count = !empty($user_id)
      ? $this->web_model->get_total_wishlist_by_user($user_id)
      : 0;

    // -------------------- Product Data --------------------
    $product_id = $this->uri->segment(2);
    $data['getData'] = $this->web_model->productDetails($product_id);

    if (empty($data['getData']))
      show_404();

    $data['product'] = $data['getData'];

    // -------------------- Brand Name --------------------
    if (!empty($data['getData']['brand_id']))
    {
      $brand = $this->db->get_where('brand_master', ['id' => $data['getData']['brand_id']])->row_array();
      $data['product']['brand_name'] = $brand ? $brand['brand_name'] : 'N/A';
    } else
    {
      $data['product']['brand_name'] = 'N/A';
    }

    // -------------------- Product Variations --------------------
    $data['variations'] = $this->db
      ->select('id, size, color, quantity, price, final_price, main_image, product_code, image1, image2, image3, image4, image5')
      ->where('product_code', $data['getData']['product_code'])
      ->where('status', '1')
      ->get('sub_product_master')
      ->result_array();

    $data['colorData'] = array_values(array_unique(array_column($data['variations'], 'color')));
    $data['sizeData'] = array_values(array_unique(array_column($data['variations'], 'size')));

    // -------------------- Banners & Categories --------------------
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['wishlist_count'] = $wishlist_count; // ✅ Pass wishlist count
    $data['title'] = str_replace(' ', '-', strtolower($data['getData']['product_name']));

    // -------------------- Related Products --------------------
    $current_product_code = $data['getData']['product_code'] ?? null;
    $category_id = $data['getData']['category_id'] ?? null;

    $relatedProducts = [];

    if ($category_id && $current_product_code)
    {
      // ✅ Step 1: Fetch all products in same category, except current product code
      $related = $this->db->select('id, product_name, product_code, main_image, final_price, price, quantity')
        ->where('status', '1')
        ->where('category_id', $category_id)
        ->where('product_code !=', $current_product_code)
        ->order_by('id', 'DESC')
        ->limit(12)
        ->get('sub_product_master')
        ->result_array();

      // ✅ Step 2: Remove duplicate product_codes and get max quantity
      $uniqueProducts = [];
      foreach ($related as $prod)
      {
        if (!isset($uniqueProducts[$prod['product_code']]))
        {
          $maxQty = $this->db->select_max('quantity')
            ->where('product_code', $prod['product_code'])
            ->where('status', '1')
            ->get('sub_product_master')
            ->row()->quantity;

          $prod['total_qty'] = $maxQty;
          $uniqueProducts[$prod['product_code']] = $prod;
        }
      }

      $relatedProducts = array_values($uniqueProducts);

      // ✅ Step 3: Remove the *exact current product* if same ID somehow exists
      $relatedProducts = array_filter($relatedProducts, function ($p) use ($current_product_code, $product_id) {
        return $p['product_code'] !== $current_product_code && $p['id'] !== $product_id;
      });
    }

    $data['relatedProducts'] = $relatedProducts;


    // -------------------- Reviews --------------------
    $data['reviews'] = $this->db->select('user_name,rating,review_text,created_at')
      ->where('product_id', $product_id)
      ->where('status', 1)
      ->order_by('created_at', 'DESC')
      ->get('customer_review')
      ->result();

    $data['average_rating'] = $this->db->select_avg('rating')
      ->where('product_id', $product_id)
      ->get('customer_review')
      ->row()->rating ?? 0;

    // -------------------- Load Views --------------------
    $this->load->view('web/include/header', $data);
    $this->load->view('web/product_detail', $data);
    $this->load->view('web/include/footer');
  }




  public function get_sub_product_ajax()
  {
    $id = $this->input->post('id');
    $product = $this->web_model->get_sub_product_by_id($id);

    if ($product)
    {
      $base_url = base_url('assets/product_images/');

      // Images check करके full path बना दो
      $product['main_image'] = $product['main_image'] ? $base_url . $product['main_image'] : '';
      $product['image1'] = $product['image1'] ? $base_url . $product['image1'] : '';
      $product['image2'] = $product['image2'] ? $base_url . $product['image2'] : '';
      $product['image3'] = $product['image3'] ? $base_url . $product['image3'] : '';
      $product['image4'] = $product['image4'] ? $base_url . $product['image4'] : '';
      $product['image5'] = $product['image5'] ? $base_url . $product['image5'] : '';

      echo json_encode(['success' => true, 'product' => $product]);
    } else
    {
      echo json_encode(['success' => false]);
    }
  }


  public function checkout_payment_old()
  {
    if (count($this->cart->contents()) == 0)
    {
      redirect(base_url());
    }

    $userData = $this->session->userdata('User');
    $address_id = $this->input->post('address_id');

    $selected_address = $this->db->get_where('user_address_master', ['id' => $address_id])->row_array();

    // Create Order
    $order_data = [
      'user_master_id' => $userData['id'],

    ];
    $this->db->insert('order_master', $order_data);
    $order_id = $this->db->insert_id();

    // Insert selected address into order_address_master
    $order_address_data = [
      'order_master_id' => $order_id,
      'title' => $selected_address['title'],
      'contact_person' => $selected_address['contact_person'],
      'mobile_number' => $selected_address['mobile_number'],
      'alternate_number' => $selected_address['alternate_number'],
      'address' => $selected_address['address'],
      'localty' => $selected_address['localty'],
      'landmark' => $selected_address['landmark'],
      'city' => $selected_address['city'],
      'state' => $selected_address['state'],
      'pincode' => $selected_address['pincode'],
      'add_date' => $selected_address['add_date'],
      'modify_date' => $selected_address['modify_date'],

    ];
    $this->db->insert('order_address_master', $order_address_data);


    redirect('web/order_success/' . base64_encode($order_id));
  }





  public function save_address_id()
  {
    $userData = $this->session->userdata('User');
    $address_id = $this->input->post('address_id');

    $fields['address_id'] = $address_id;
    $fields['user_master_id'] = $userData['id'];

    $check = $this->db->get_where('save_address_id', array('user_master_id' => $userData['id']))->num_rows();

    if ($check == '0')
    {
      $this->db->insert('save_address_id', $fields);
    } else
    {
      $this->db->where('user_master_id', $userData['id']);
      $this->db->update('save_address_id', $fields);
    }

  }

  public function account_wishlist()
  {
    $userData = $this->session->userdata('User');
    $data['userInfo'] = $this->db->get_where('user_master', array('id' => $userData['id']))->row_array();
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['getData'] = $this->db->get_where('wish_list_master', array('user_id' => $userData['id']))->result_array();
    $data['title'] = 'Wish List Details | Dukekart';
    $this->load->view('web/include/header', $data);
    $this->load->view('web/account_wishlist');
    $this->load->view('web/include/footer');
  }


  public function account_order()
  {
    $userData = $this->session->userdata('User');

    $data['userInfo'] = $this->db->get_where('user_master', array('id' => $userData['id']))->row_array();
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $this->db->order_by('id', 'DESC');
    $data['getData'] = $this->db->get_where('order_master', array('user_master_id' => $userData['id'], 'action_payment' => "Yes"))->result_array();
    $data['title'] = 'Order List | Dukekart';
    $this->load->view('web/include/header', $data);
    $this->load->view('web/account_order');
    $this->load->view('web/include/footer');
  }


  public function order_history($o_id)
  {
    $o_res = $this->db->get_where('purchase_master', array('order_master_id' => $o_id))->result_array();

    $html = '';
    foreach ($o_res as $value)
    {

      $pro_res = $this->db->get_where('sub_product_master', array('id' => $value['product_master_id']))->row_array();

      $array_url = parse_url($pro_res['main_image']);
      $img_url = 'https://' . $array_url['host'] . '' . $array_url['path'] . '?raw=1';



      $html .= ' <div class="d-sm-flex justify-content-between mb-4 pb-3 pb-sm-2 border-bottom">
              <div class="media d-block d-sm-flex text-center text-sm-left"><a class="d-inline-block mx-auto mr-sm-4" href="' . base_url() . 'web/product_detail/' . $value['product_master_id'] . '" style="width: 10rem;">
              <img src="' . $img_url . '" alt="Product" style="width:200px;height:135px;">
              </a>
                <div class="media-body pt-2">
                  <h3 class="product-title font-size-base mb-2">' . $value['product_name'] . '</h3>

                  <div class="font-size-sm"><span class="text-muted mr-2">size:</span>' . $value['size'] . ' </div>
                  <div class="font-size-sm"><span class="text-muted mr-2">weight:</span>' . $value['color'] . ' </div>
                  
                  <div class="font-size-lg text-accent pt-2">' . $value['price'] . '&nbsp;<i class="fa fa-inr"></i></div>
                </div>

              </div>
              <div class="pt-2 pl-sm-3 mx-auto mx-sm-0 text-center">
                <div class="text-muted mb-2">Quantity:</div>' . $value['quantity'] . ' </div>';

      if ($value['status'] == '3')
      {

        $html .= '<a href="' . base_url() . 'web/returnSingleOrder/' . $value['id'] . '/' . $value['product_master_id'] . '" style="margin-top: 100px;">
                <p class="btn btn-sm btn-warning" onclick="return confirm(Are you sure you want to delete this item?);">Return Request</p>
                </a>';

      } else if ($value['status'] == '8')
      {
        $html .= '<p class="btn btn-sm btn-success">Return</p>';
      }

      $html .= '<div class="pt-2 pl-sm-3 mx-auto mx-sm-0 text-center">
                <div class="text-muted mb-2">Subtotal</div>' . $value['final_price'] . '&nbsp;<i class="fa fa-inr"></i> 
              </div>
            </div>';


    }

    echo json_encode($html);

  }


  public function my_wallet()
  {
    $userData = $this->session->userdata('User');
    $data['userInfo'] = $this->db->get_where('user_master', array('id' => $userData['id']))->row_array();
    // $data['bannerList']         = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['getWalletData'] = $this->db->get_where('wallet_master', array('user_master_id' => $userData['id']))->row_array();

    $data['title'] = 'Wallet Details | Dukekart';

    $this->load->view('web/include/header', $data);
    $this->load->view('web/account_wallet', $data);
    $this->load->view('web/include/footer');
  }



  public function add_amount_in_wallet()
  {
    $user_ses = $this->session->userdata('User');
    $user_id = $user_ses['id'];

    $req_amt = $this->input->post('amount');

    $this->db->where('id', $user_id);
    $userData = $this->db->get('user_master')->row_array();

    $order_number = substr(str_shuffle("1234567890"), '0', '4');

    $dataa = array();
    $dataa['final_price'] = $req_amt;
    // $dataa['order_id']          = $order['order_number'];
    $dataa['order_id'] = $order_number;
    $dataa['amount'] = $req_amt;
    $dataa['redirect_url'] = base_url('web/GatewayRedirect');
    $dataa['cancel_url'] = base_url('web/CancelGatewayRedirect');
    $dataa['webhook'] = base_url('web/GatewayHookRedirect');
    $dataa['language'] = 'EN';
    $dataa['billing_name'] = $userData['username'];
    $dataa['billing_address'] = $userData['address'];
    $dataa['billing_city'] = $userData['city'];
    $dataa['billing_state'] = $userData['state'];
    $dataa['billing_zip'] = $userData['pincode'];
    $dataa['billing_country'] = 'India';
    $dataa['billing_tel'] = $userData['mobile'];
    $dataa['billing_email'] = $userData['email_id'];
    $dataa['merchant_param1'] = 'Dukekart add money';


    $this->load->view('paymentGateway/instomojo', $dataa);
  }


  public function become_a_vendor()
  {
    $data = $this->input->post();

    if (empty($data))
    {
      $data['bannerList'] = $this->web_model->getBannerList();
      $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
      $data['title'] = 'Become a vendor | Dukekart  ';
      $this->load->view('web/include/header', $data);
      $this->load->view('web/seller');
      $this->load->view('web/include/footer');

    } else
    {

      $check_mobile = $this->db->get_where('staff_master', array('mobile' => $data['mobile']))->num_rows();
      $check_email = $this->db->get_where('staff_master', array('email' => $data['email']))->num_rows();

      if ($check_mobile > 0)
      {
        $message = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong><h3>Fail!<h3></strong>This mobile no is already registered with us. Please go to seller login page to access your dashboard</div>';

        $this->session->set_flashdata('message', $message);
        redirect(site_url('web/success/'), 'refresh');
      } else if ($check_email > 0)
      {

        $message = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong><h3>Fail!<h3></strong>Email Already Exits.Please try another.</div>';

        $this->session->set_flashdata('message', $message);
        redirect(site_url('web/success/'), 'refresh');



      } else
      {

        $data['seller_code'] = mb_substr(strtoupper($data['name']), 0, 3) . '' . substr($data['mobile'], -4);
        $data['add_date'] = time();
        $data['modify_date'] = time();
        $data['status'] = '1';
        $row = $this->db->insert('staff_master', $data);
        $insert_id = $this->db->insert_id();

        //New TEXT*****

        $text = "Your seller account has been successfully registered with Dukekart. Kindly visit https://Dukekart.in/seller to start uploading your products on Dukekart and start earning Regards Dukekart Real Time Private Limited";


        //$text="Seller registration Test"; 
        // ***OLD TEXT*****   
        //$text="Congratulations! You have successfully registered your seller account with us.\r\nUser name : ".$data['name'];



        // sendSMS($data['mobile'],$text);

        sendSMS($data['mobile'], $text, '1007050631475099664');

        $email_message = 'Dear ' . $data['name'] . ',
 
          Congratulations and welcome to a whole new world of online marketplace 
          You have provisionally created your Dukekart seller  account. 
          Kindly complete your seller profile and connect with us to expand your business.  

          Your Login id is ' . $data['mobile'] . '';


        sentCommonEmail($data['email'], $email_message, 'Dukekarte Registration Successfully.');
        $message = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong><h3>Success!</h3></strong>Thanks for registering with us. Now you have to complete your profile and KYC after that you can start listing your product.</div>';

        $this->session->set_flashdata('message', $message);
        redirect(site_url('web/success/' . $insert_id), 'refresh');

      }






    }

  }



  function sendSMS($mobile, $message, $template)
  {

    $url = "http://sms.txly.in/vb/apikey.php?apikey=glNySZAajwGzc6mO&senderid=DUKRLT&templateid=" . $template . "&number=" . $mobile . "&message=" . urlencode($message);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_exec($ch);


    return 1;

  }



  public function account_ticket()
  {
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $this->load->view('web/include/header', $data);
    $this->load->view('web/account_ticket');
    $this->load->view('web/include/footer');
  }

  public function wishlist()
  {
    $userData = $this->session->userdata('User');

    $data['userInfo'] = $this->db->get_where('user_master', array('id' => $userData['id']))->row_array();
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();

    $data['get_total_orders'] = $this->web_model->get_total_orders_by_user($userData['id']);

    // Use consistent key
    $data['wishlist_count'] = $this->web_model->get_total_wishlist_by_user($userData['id']);

    $data['wishListData'] = $this->db->get_where('wish_list_master', array('user_id' => $userData['id']))->result_array();

    $data['title'] = 'Account Profile | Jail Store';

    $this->load->view('web/include/header', $data);
    $this->load->view('web/wishlist');
    $this->load->view('web/include/footer');
  }



  public function account_profile()
  {

    $data = $this->input->post();
    $userData = $this->session->userdata('User');

    if (empty($data))
    {
      $data['userInfo'] = $this->db->get_where('user_master', array('id' => $userData['id']))->row_array();
      $data['bannerList'] = $this->web_model->getBannerList();
      $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
      $data['get_total_orders'] = $this->web_model->get_total_orders_by_user($userData['id']);
      $data['get_total_wishlist'] = $this->web_model->get_total_wishlist_by_user($userData['id']);
      //$data['getData'] = $this->db->get_where('order_master', array('user_master_id' => $userData['id'], 'action_payment' => "Yes"))->result_array();
      $this->db->from('order_master');
      $this->db->where(array(
        'user_master_id' => $userData['id'],
        'action_payment' => 'Yes'
      ));
      $this->db->order_by('id', 'DESC');
      $data['getData'] = $this->db->get()->result_array();
      $data['address_data'] = $this->db->get_where('user_address_master', array('user_master_id' => $userData['id']))->result_array();
      $data['wishListData'] = $this->db->get_where('wish_list_master', array('user_id' => $userData['id']))->result_array();
      $data['title'] = 'Account Profile | Dukekart';
      $this->load->view('web/include/header', $data);
      $this->load->view('web/account_profile');
      $this->load->view('web/include/footer');
    } else
    {

      $fileName = $_FILES["profile"]["name"];
      $extension = explode('.', $fileName);
      $extension = strtolower(end($extension));
      $uniqueName = 'Profile_' . uniqid() . '.' . $extension;
      $type = $_FILES["profile"]["type"];
      $size = $_FILES["profile"]["size"];
      $tmp_name = $_FILES['profile']['tmp_name'];
      $targetlocation = PROFILE_DIRECTORY . $uniqueName;
      if (!empty($fileName))
      {
        move_uploaded_file($tmp_name, $targetlocation);
        $data['profile_pic'] = utf8_encode(trim($uniqueName));
      }

      $this->db->where('id', $userData['id']);
      $row = $this->db->update('user_master', $data);
      $userDatasession = $this->session->userdata('User');
      $userDatasession['username'] = $data['username'];
      $this->session->set_userdata('User', $userDatasession);

      if ($row > 0)
      {

        $user_ses = $this->session->set_userdata('username', $data['username']);
        $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button>Profile Update successfully.</div></div>');
        //redirect('web/account_profile');
        redirect($_SERVER['HTTP_REFERER']);
      }


    }
  }

  public function delete_jail_address($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('user_address_master');
    echo 'success';
  }

  public function account_address()
  {
    $data = $this->input->post();
    $userData = $this->session->userdata('User');
    if (empty($data))
    {
      $data['userInfo'] = $this->db->get_where('user_master', array('id' => $userData['id']))->row_array();
      $data['bannerList'] = $this->web_model->getBannerList();
      $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
      $data['getData'] = $this->web_model->getAllUserAddress($userData['id']);
      $data['address_data'] = $this->db->get_where('user_address_master', array('user_master_id' => $userData['id']))->result_array();
      $data['title'] = 'Account Address List | Dukekart';
      $this->load->view('web/include/header', $data);
      $this->load->view('web/account_address');
      $this->load->view('web/include/footer');

    } else
    {


      $address = $this->db->get_where('user_address_master', array('user_master_id' => $userData['id']))->row_array();
      $data['user_master_id'] = $userData['id'];
      $data['add_date'] = time();
      $data['modify_date'] = time();

      if (empty($address))
      {

        $row = $this->db->insert('user_address_master', $data);

      } else
      {

        $this->db->where('user_master_id', $userData['id']);
        $row = $this->db->update('user_address_master', $data);
      }


      if ($row > 0)
      {

        $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button>Address Update successfully.</div></div>');
        redirect('profile');
      }


    }

  }

  public function subscribe_user()
  {


    $email = $this->input->post('email', TRUE);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
      echo json_encode(['status' => 'error', 'message' => 'Invalid email address.']);
      return;
    }

    if ($this->web_model->is_already_subscribed($email))
    {
      echo json_encode(['status' => 'info', 'message' => 'This email is already subscribed.']);
      return;
    }

    if ($this->web_model->subscribe_user($email))
    {
      echo json_encode(['status' => 'success', 'message' => 'You have successfully subscribed.']);
    } else
    {
      echo json_encode(['status' => 'error', 'message' => 'Subscription failed. Please try again.']);
    }
  }


  public function add_address()
  {
    $data = $this->input->post();
    $userData = $this->session->userdata('User');
    if (empty($data))
    {
      $data['userInfo'] = $this->db->get_where('user_master', array('id' => $userData['id']))->row_array();
      $data['bannerList'] = $this->web_model->getBannerList();
      $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
      $data['getData'] = $this->web_model->getAllUserAddress($userData['id']);
      $data['address_data'] = $this->db->get_where('user_address_master', array('user_master_id' => $userData['id']))->row_array();
      $data['title'] = 'Add Address | Dukekart';
      $this->load->view('web/include/header', $data);
      $this->load->view('web/add_address');
      $this->load->view('web/include/footer');

    } else
    {

      $data['user_master_id'] = $userData['id'];
      $data['add_date'] = time();
      $data['modify_date'] = time();


      $row = $this->db->insert('user_address_master', $data);


      if ($row > 0)
      {

        $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button>Address Added successfully.</div></div>');
        redirect('address');
      }


    }

  }


  public function save_addr()
  {
    $this->load->library('user_agent');
    $data = $this->input->post();
    $userData = $this->session->userdata('User');

    $data['user_master_id'] = $userData['id'];
    $data['add_date'] = time();
    $data['modify_date'] = time();


    $row = $this->db->insert('user_address_master', $data);


    if ($row > 0)
    {

      $this->session->set_flashdata('activatee', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button>Address Added successfully.</div></div>');
      // redirect('web/checkout');
      redirect($this->agent->referrer());
    }

  }




  public function update_address($id)
  {
    $data = $this->input->post();
    $userData = $this->session->userdata('User');
    if (empty($data))
    {
      $data['userInfo'] = $this->db->get_where('user_master', array('id' => $userData['id']))->row_array();
      $data['bannerList'] = $this->web_model->getBannerList();
      $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
      $data['getData'] = $this->web_model->getAllUserAddress($userData['id']);
      $data['address_data'] = $this->db->get_where('user_address_master', array('id' => $id))->row_array();
      $data['title'] = 'Update Address  | Dukekart';
      $this->load->view('web/include/header', $data);
      $this->load->view('web/update_address');
      $this->load->view('web/include/footer');

    } else
    {

      $data['modify_date'] = time();

      $this->db->where('id', $id);
      $row = $this->db->update('user_address_master', $data);


      if ($row > 0)
      {

        $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button>Address Update successfully.</div></div>');
        redirect('web/account_profile');
      }


    }

  }

  public function edit_address()
  {
    $postData = $this->input->post(); // fetch post data

    if (!empty($postData))
    {
      $id = $postData['id'];
      $updateData = [
        'title' => $postData['title'],
        'contact_person' => $postData['contact_person'],
        'address' => $postData['address'],
        'localty' => $postData['localty'],
        'landmark' => $postData['landmark'],
        'state' => $postData['state'],
        'city' => $postData['city'],
        'pincode' => $postData['pincode'],
        'mobile_number' => $postData['mobile_number'],
        'modify_date' => time()
      ];

      $this->db->where('id', $id);
      $this->db->update('user_address_master', $updateData);

      $this->session->set_flashdata('success', 'Address updated successfully');
      redirect('web/account_profile');
    } else
    {
      show_error("No data received for update.");
    }
  }



  public function cancelOrder($order_id)
  {

    $getOrderdata = $this->db->select('status')->get_where('order_master', ['id' => $order_id])->row_array();
    // echo "<pre>";print_r($getOrderdata);exit();
    if ($getOrderdata['status'] == '5')
    {
      $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success">
        <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button>
        To cancel the Order please contact our Customer support.</div></div>');
      redirect('order-list');
    }

    $fields['status'] = '4';
    $this->db->where('id', $order_id);
    $row = $this->db->update('order_master', $fields);
    $this->db->where('order_master_id', $order_id);
    $this->db->update('purchase_master', $fields);


    $query = $this->db
      ->select('order_master.order_number, user_master.username, user_master.mobile, user_master.email_id')
      ->from('order_master')
      ->join('user_master', 'user_master.id = order_master.user_master_id', 'inner')
      ->where('order_master.id', $order_id)
      ->where('order_master.id', $order_id)
      ->get();

    if ($query->num_rows() > 0)
    {
      $result = $query->row();
      $order_number = $result->order_number;
      $user = $result->username;
      $emailid = $result->email_id;
      $mobile = $result->mobile;
      $message = "Dear customer, Your Order no. -" . $order_number . ", has been cancelled and please contact with our Support team.Thanks .Regards , Dukekart Real Time Private Limited , www.Dukekart.in ";
      $tempID = '1007492296258821177';

      $this->load->helper('/email/temp5');
      $status = "Order Cancelled";
      $email_text = "Your order no. " . $order_number . " has been cancelled and please contact with our Support team.Thanks .Regards , Dukekart Real Time Private Limited , www.Dukekart.in ";
      $email_body = temp5($status, $user, $email_text, "https://Dukekart.in");
      $subject = "Your order no " . $order_number . " has been delivered";
      sentCommonEmail($emailid, $email_body, $subject);
      sendSMS($mobile, $message, $tempID);
    }


    if ($row > 0)
    {
      $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button>Order Cancel successfully.</div></div>');
      redirect('order-list');
    }


  }


  public function returnOrder($order_id)
  {

    $fields['status'] = '7';
    $this->db->where('id', $order_id);
    $row = $this->db->update('order_master', $fields);
    $this->db->where('order_master_id', $order_id);
    $this->db->update('purchase_master', $fields);

    if ($row > 0)
    {

      $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button>Order Return Request Send successfully.</div></div>');
      redirect('web/order_detail/' . $order_id);
    }


  }

  public function returnSingleOrder($order_id, $product_id)
  {
    $fields['status'] = '7';
    $this->db->where(array('order_master_id' => $order_id, 'product_master_id' => $product_id));
    $row = $this->db->update('purchase_master', $fields);

    $check = $this->db->get_where('purchase_master', array('order_master_id' => $order_id, 'status' => '3'))->num_rows();

    if ($check == '1')
    {
      $fields['status'] = '7';
      $this->db->where('id', $order_id);
      $this->update('order_master', $fields);
    }


    if ($row > 0)
    {

      $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button>Return Request Send successfully.</div></div>');
      redirect('web/order_detail/' . $order_id);
    }

  }


  public function add_to_wishlist()
  {
    $pro_id = $this->input->post('pro_id');
    $user_id = $this->input->post('user_id');

    $wishList_res = $this->User_master_model->add_wishlist_data($user_id, $pro_id);


    $wish_row = $this->db->get_where('wish_list_master', ['user_id' => $user_id])->num_rows();


    $res['wish_row'] = $wish_row;

    if ($wishList_res === 'added')
    {
      $res['success'] = true;
      $res['message'] = 'Product added to wishlist.';
    } elseif ($wishList_res === 'exists')
    {
      $res['success'] = false;
      $res['message'] = 'Product already in wishlist.';
    } else
    {
      $res['success'] = false;
      $res['message'] = 'Something went wrong. Please try again.';
    }

    echo json_encode($res);
  }






  public function check_pincode()
  {
    $pincode = $this->input->post('pincode');
    // $fields['pincode'] = $pincode;
    // $fields['access_token'] = '28b4d9246917ac19f5f9cea9861bc731';
    // $fields['secret_key'] = 'df1b745f66e9b39f81b70b8bc2ad4689';

    // $array_data['data'] = $fields;

    // $json_data = json_encode($array_data);

    // $curl = curl_init();
    // curl_setopt_array($curl, array(
    //   CURLOPT_URL => "https://manage.ithinklogistics.com/api_v3/pincode/check.json",
    //   CURLOPT_RETURNTRANSFER => true,
    //   CURLOPT_ENCODING => "",
    //   CURLOPT_MAXREDIRS => 10,
    //   CURLOPT_TIMEOUT => 30,
    //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //   CURLOPT_CUSTOMREQUEST => "POST",
    //   CURLOPT_POSTFIELDS => $json_data,
    //   CURLOPT_HTTPHEADER => array(
    //     "cache-control: no-cache",
    //     "content-type: application/json"
    //   ),
    // )
    // );


    // $response = curl_exec($curl);
    // $err = curl_error($curl);
    // curl_close($curl);
    // if ($err) {
    //   echo '2';
    //   exit;
    // } else {
    //   $json_respons = json_decode($response, true);
    //   $city_name = $json_respons['data'][$pincode]['city_name'];
    //   if (!empty($city_name)) {
    //     echo '1';
    //     exit;
    //   } else {
    //     echo '2';
    //     exit;
    //   }
    // }

    $query = $this->db->get_where('pin_code_master', array('pin_code' => $pincode, 'status' => 1));

    // Check if the query returned any rows
    if ($query->num_rows() > 0)
    {
      // The pin code exists in the table and is active
      // $data = array('status')
      echo 1;
      exit;
    } else
    {
      echo 2;
      exit;
    }

  }







  public function remove_wishlist_old($id)
  {
    $this->db->where('id', $id);
    $res = $this->db->delete('wish_list_master');
    if ($res)
    {
      $this->session->set_flashdata('activate', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button>Item removed from your Wishlist successfully.</div></div>');
      redirect('web/account_wishlist');

    } else
    {

      $this->session->set_flashdata('error', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button>Somthing went wrong.</div></div>');
      redirect('web/account_wishlist');

    }
  }

  public function remove_wishlist()
  {
    $this->output->set_content_type('application/json');

    $product_id = $this->input->post('product_id');
    $user_id = $this->input->post('user_id');

    if ($product_id && $user_id)
    {
      $this->db->where('product_id', $product_id);
      $this->db->where('user_id', $user_id);
      $res = $this->db->delete('wish_list_master');

      if ($res)
      {
        echo json_encode([
          'status' => 'success',
          'message' => 'Item removed from your Wishlist successfully.'
        ]);
      } else
      {
        echo json_encode([
          'status' => 'error',
          'message' => 'Something went wrong while removing the item.'
        ]);
      }
    } else
    {
      echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request data.'
      ]);
    }
  }




  public function delete_address($address_id)
  {
    if ($address_id)
    {
      $this->db->where('id', $address_id);
      $deleted = $this->db->delete('user_address_master');
      if ($deleted)
      {
        echo json_encode(['status' => 'success', 'message' => 'Address deleted successfully.']);
      } else
      {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete address.']);
      }
    } else
    {
      echo json_encode(['status' => 'error', 'message' => 'Invalid address ID.']);
    }
  }


  public function check_otp()
  {
    $mobile = $this->input->post('mobile');
    $otp = $this->input->post('otp');

    $check = $this->db->get_where('user_master', array('mobile' => $mobile, 'otp' => $otp))->row_array();

    if (!empty($check))
    {
      echo '1';
      exit();
    } else
    {

      echo '2';
      exit();
    }


  }




  public function account_payment()
  {
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['title'] = 'Account Payment | Dukekart';
    $this->load->view('web/include/header', $data);
    $this->load->view('web/account_payment');
    $this->load->view('web/include/footer');
  }


  public function blog()
  {
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['title'] = 'Blog | Dukekart';
    $this->load->view('web/include/header', $data);
    $this->load->view('web/blog');
    $this->load->view('web/include/footer');
  }

  public function account_delete_req()
  {
    // $data['bannerList'] = $this->web_model->getBannerList();
    // $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    // $data['title'] = 'Blog | Dukekart';
    // $this->load->view('web/include/header');
    $this->load->view('web/delete_acc_req');
    // $this->load->view('web/include/footer');
  }

  public function blog_list()
  {
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['title'] = 'Blog List | Dukekart';
    $this->load->view('web/include/header', $data);
    $this->load->view('web/blog_list');
    $this->load->view('web/include/footer');
  }


  public function forgot_password()
  {
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['title'] = 'Forgot Password | Dukekart';
    $this->load->view('web/include/header', $data);
    $this->load->view('web/forgot_password');
    $this->load->view('web/include/footer');
  }

  public function login_registration()
  {
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['title'] = 'Login Registration | Dukekart';
    $this->load->view('web/include/header', $data);
    $this->load->view('web/login_registration');
    $this->load->view('web/include/footer');
  }


  public function cart()
  {
    $userData = $this->session->userdata('User');

    if (!empty($userData))
    {
      $user_id = $userData['id'];
      $data['wishlist_count'] = $this->web_model->get_total_wishlist_by_user($user_id);
    } else
    {
      $user_id = 0;
      $data['wishlist_count'] = 0;
    }

    $cart_items = $this->cart->contents();
    $gst_list = [];

    foreach ($cart_items as $item)
    {
      $gst_data = $this->web_model->get_gst($item['id']);
      $gst_list[$item['id']] = !empty($gst_data) ? $gst_data->gst : 0;
    }

    $data['gst_list'] = $gst_list;

    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['title'] = 'Cart List | Dukekart';

    $this->load->view('web/include/header', $data);
    $this->load->view('web/cart');
    $this->load->view('web/include/footer');
  }


  public function checkout()
  {
    $userData = $this->session->userdata('User');

    if (empty($userData))
    {
      redirect('web/login');
    }

    $user_id = $userData['id'];

    // Wishlist count & user info
    $data['wishlist_count'] = $this->web_model->get_total_wishlist_by_user($user_id);
    $data['userInfo'] = $this->db->get_where('user_master', ['id' => $user_id])->row_array();
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['getData'] = $this->db->get_where('user_address_master', ['user_master_id' => $user_id])->result_array();
    $data['address_data'] = $this->db->get_where('user_address_master', ['user_master_id' => $user_id])->row_array();
    $data['title'] = 'Checkout | Dukekart';

    $checkout_items = [];

    // -------------------- Handle Buy Now --------------------
    $buyNow = $this->session->userdata('buy_now');
    if (!empty($buyNow))
    {
      $product = $this->db->get_where('sub_product_master', ['id' => $buyNow['pro_id']])->row_array();
      $gst_percent = !empty($product['gst']) ? $product['gst'] : 0;

      $checkout_items[] = [
        'id' => $product['id'],
        'name' => $product['product_name'],
        'final_price' => $product['final_price'],
        'image' => $product['main_image'],
        'size' => $product['size'],
        'qty' => $buyNow['qty'],
        'gst' => $gst_percent,
      ];

    } else
    {
      // -------------------- Fallback to Cart --------------------
      foreach ($this->cart->contents() as $item)
      {
        $product = $this->db->get_where('sub_product_master', ['id' => $item['id']])->row_array();
        $gst_percent = !empty($product['gst']) ? $product['gst'] : 0;

        $checkout_items[] = [
          'id' => $item['id'],
          'name' => $item['name'],
          'final_price' => $item['final_price'],
          'image' => $item['image'],
          'size' => $item['size'] ?? '',
          'qty' => $item['qty'],
          'gst' => $gst_percent,
        ];
      }
    }

    $data['checkout_items'] = $checkout_items;
    $this->session->set_userdata('checkout_items', $checkout_items);

    // -------------------- Load Views --------------------
    $this->load->view('web/include/header', $data);
    $this->load->view('web/checkout', $data);
    $this->load->view('web/include/footer');
  }



  // ==========================
// BUY NOW SESSION STORE
// ==========================
  public function buy_now_session()
  {
    $pro_id = $this->input->post('pro_id');
    $qty = $this->input->post('quantity');

    $this->session->set_userdata('buy_now', [
      'pro_id' => $pro_id,
      'qty' => $qty
    ]);

    echo json_encode(['status' => 'success']);
  }



  // ==========================
// CHECKOUT PAYMENT PAGE
// ==========================
  public function checkout_payment()
  {
    $userData = $this->session->userdata('User');
    if (empty($userData))
      redirect('web/login');

    $user_id = $userData['id'];

    // Get POSTed data
    $address_id = $this->input->post('address_id'); // selected address
    $paymentType = $this->input->post('paymentType') ?? 1;
    $tid = $this->input->post('tid');

    if (empty($address_id))
    {
      $this->session->set_flashdata('error', 'Please select a delivery address.');
      redirect('web/checkout'); // redirect back if no address selected
    }

    // Fetch the selected address
    $data['address_data'] = $this->db->get_where('user_address_master', [
      'id' => $address_id,
      'user_master_id' => $user_id
    ])->row_array();

    // Fetch checkout items from session
    $data['checkout_items'] = $this->session->userdata('checkout_items');

    // Pass additional data
    $data['title'] = 'Payment | Dukekart';
    $data['paymentType'] = $paymentType;
    $data['tid'] = $tid;

    // Load view
    $this->load->view('web/include/header', $data);
    $this->load->view('web/checkout_payment', $data);
    $this->load->view('web/include/footer');
  }




  public function get_wishlist_count()
  {
    $userData = $this->session->userdata('User');
    $count = 0;
    if (!empty($userData))
    {
      $count = $this->db->where('user_id', $userData['id'])
        ->from('wishlist_master')
        ->count_all_results();
    }
    echo json_encode(['count' => $count]);
  }



  public function about()
  {
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['title'] = 'About-Us | Dukekart';
    $this->load->view('web/include/header', $data);
    $this->load->view('web/about');
    $this->load->view('web/include/footer');
  }


  public function tersms_conditions()
  {

    $data['title'] = 'Terms & Conditions | Dukekart';
    $this->load->view('web/include/header', $data);
    $this->load->view('web/tersms_conditions');
    $this->load->view('web/include/footer');
  }


  public function contact()
  {
    $data = $this->input->post();
    if (empty($data))
    {
      $data['bannerList'] = $this->web_model->getBannerList();
      $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
      $data['title'] = 'Contact-Us | Dukekart';
      $this->load->view('web/include/header', $data);
      $this->load->view('web/contact');
      $this->load->view('web/include/footer');
    } else
    {

      $row = $this->db->insert('enquiry_master', $data);

      if ($row > 0)
      {

        $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button>Thanks! For contacting Dukekart.
          We will contact you soon</div></div>');
        redirect('web/contact');
      }

    }


  }


  public function faq()
  {
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['title'] = 'FAQ | Dukekart';
    $this->load->view('web/include/header', $data);
    $this->load->view('web/faq');
    $this->load->view('web/include/footer');
  }

  public function help()
  {
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['title'] = 'Help | Dukekart';
    $this->load->view('web/include/header', $data);
    $this->load->view('web/help');
    $this->load->view('web/include/footer');
  }

  public function faq_help_request()
  {
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['title'] = 'FAQ Help Request | Dukekart';
    $this->load->view('web/include/header', $data);
    $this->load->view('web/faq_help_request');
    $this->load->view('web/include/footer');
  }


  public function terms_condition()
  {
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['title'] = 'Term Conditions | Dukekart';
    $this->load->view('web/include/header', $data);
    $this->load->view('web/terms&condition');
    $this->load->view('web/include/footer');
  }

  public function terms_conditions()
  {
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['title'] = 'Privacy Policy | Dukekart';
    $this->load->view('web/include/header', $data);
    $this->load->view('web/terms_conditions');
    $this->load->view('web/include/footer');
  }

  public function privacy_policy()
  {
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['title'] = 'Privacy Policy | Dukekart';
    $this->load->view('web/include/header', $data);
    $this->load->view('web/privacy_policy');
    $this->load->view('web/include/footer');
  }

  public function refund_policy()
  {
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['title'] = 'Refund Policy | Dukekart';
    $this->load->view('web/include/header', $data);
    $this->load->view('web/refund_policy');
    $this->load->view('web/include/footer');
  }

  public function cancellation_policy()
  {
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['title'] = 'Privacy Policy | Dukekart';
    $this->load->view('web/include/header', $data);
    $this->load->view('web/cancellation_policy');
    $this->load->view('web/include/footer');
  }

  //

  public function get_counts()
  {
    $wishlist_count = 0;
    $cart_count = count($this->cart->contents());

    if ($this->session->userdata('user_id'))
    {
      $user_id = $this->session->userdata('user_id');
      $wishlist_count = $this->db->where('user_id', $user_id)->count_all_results('wishlist_table');
    }

    echo json_encode([
      'wishlist_count' => $wishlist_count,
      'cart_count' => $cart_count
    ]);
  }



  public function success($id = '')
  {

    $data['getData'] = $this->db->get_where('staff_master', array('id' => $id))->row_array();
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['title'] = 'Order Success | Dukekart';
    $this->load->view('web/include/header', $data);
    $this->load->view('web/registration_success');
    $this->load->view('web/include/footer');
  }


  public function logout()
  {
    $this->session->unset_userdata('User');
    redirect('web');

  }


  public function change_pass()
  {
    $data = $this->input->post();
    $fields['password'] = $data['newPassword'];
    $this->db->where('mobile', $data['user_mobile']);
    $row = $this->db->update('user_master', $fields);
    $this->session->set_flashdata('activate', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button>Password Change Successfully.</div></div>');
    redirect(base_url());

  }


  public function send_sms_email()
  {
    $chars = "0123456789";
    $mobile_otp = substr(str_shuffle($chars), 0, 4);

    $templateId = '1307161817881828513';

    $chars = "0123456789";
    $email_otp = substr(str_shuffle($chars), 0, 4);

    $serller_id = $this->input->post('seller_id');
    $this->db->select('name,mobile,email');
    $staff = $this->db->get_where('staff_master', array('id' => $serller_id))->row_array();

    $this->db->where('id', $serller_id);
    $this->db->update('staff_master', array('mobile_otp' => $mobile_otp, 'email_otp' => $email_otp));

    //  $text = 'Dear '.$staff['name'].' Your Mobile Verification OTP is: '.$mobile_otp;


    $text = 'Dear ' . $staff['name'] . ' Your Mobile Verification OTP is: ' . $mobile_otp . ' Please enter this OTP to verify your mobile number. From www.Dukekart.inRegardsDukekart Real Time Private Limited';

    $this->load->helper('/email/temp9');
    $status = 'Email Verification';
    $user = $staff['name'];
    $email_text = $email_otp . ' is your email verification OTP. Please use this otp for the verification of your email id with Dukekart.';
    $email_body = temp9($status, $user, $email_text);

    $subject = 'Email Verification OTP';

    sendSMS($staff['mobile'], $text, '1007086055987083292');

    //  $email_message = 'Dear '.$staff['name'].' Your TEst Email Verification OTP is: '.$email_otp;
    //  sentCommonEmail($staff['email'],$email_message,'Account Verification OTP.');


    sentCommonEmail($staff['email'], $email_body, $subject);


  }


  public function verify_mobile()
  {

    $serller_id = $this->input->post('seller_id');
    $otp = $this->input->post('otp');
    $this->db->select('mobile_otp,email_verify');
    $staff = $this->db->get_where('staff_master', array('id' => $serller_id))->row_array();

    if ($staff['mobile_otp'] == $otp)
    {
      $this->db->where('id', $serller_id);
      $this->db->update('staff_master', array('mobile_verify' => '1'));
      $message['mobile_verify'] = '1';
      $message['email_verify'] = $staff['email_verify'];
      $message['type'] = '1';
    } else
    {
      $message['mobile_verify'] = '2';
      $message['email_verify'] = $staff['email_verify'];
      $message['type'] = '2';
    }
    echo json_encode($message);
    exit;

  }



  public function verify_email()
  {
    $serller_id = $this->input->post('seller_id');
    $otp = $this->input->post('otp');
    $this->db->select('email_otp,mobile_verify');
    $staff = $this->db->get_where('staff_master', array('id' => $serller_id))->row_array();
    if ($staff['email_otp'] == $otp)
    {
      $this->db->where('id', $serller_id);
      $this->db->update('staff_master', array('email_verify' => '1'));

      $message['mobile_verify'] = $staff['mobile_verify'];
      $message['email_verify'] = '1';
      $message['type'] = '1';

    } else
    {

      $message['mobile_verify'] = $staff['mobile_verify'];
      $message['email_verify'] = '2';
      $message['type'] = '2';

    }

    echo json_encode($message);
    exit;

  }


  public function save_shipping_add()
  {

    $userData = $this->session->userdata('User');
    $data = $this->input->post();
    $fields['user_master_id'] = $userData['id'];
    $fields['title'] = $data['title'];
    $fields['contact_person'] = $data['contact_person'];
    $fields['mobile_number'] = $data['mobile_number'];
    $fields['alternate_number'] = $data['alternate_number'];
    $fields['address'] = $data['address'];
    $fields['localty'] = $data['localty'];
    $fields['landmark'] = $data['landmark'];
    $fields['pincode'] = $data['pincode'];
    $fields['city'] = $data['city'];
    $fields['state'] = $data['state'];
    $fields['add_date'] = time();
    $fields['modify_date'] = time();

    $address_data = $this->db->get_where('user_address_master', array('user_master_id' => $userData['id']))->row_array();

    if (empty($address_data))
    {

      $row = $this->db->insert('user_address_master', $fields);

    } else
    {

      $this->db->where('user_master_id', $userData['id']);
      $row = $this->db->update('user_address_master', $fields);

    }



    if ($row > 0)
    {

      $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button>Address Added successfully.</div></div>');
      redirect('web/checkout_payment');
    }

  }


  public function delete_addr($address_id)
  {
    $this->db->where('id', $address_id);
    $row = $this->db->delete('user_address_master');
    if ($row > 0)
    {
      $this->session->set_flashdata('activatee', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button>Address deleted successfully.</div></div>');
      redirect('web/checkout');
    }
  }

  public function order_complete_old()
  {
    // echo "<pre>";print_r($this->input->post());exit();
    $tid = $this->input->post('tid');
    $userData = $this->session->userdata('User');
    $total_item = $this->cart->contents();
    $data = $this->input->post();
    $link = time() . "-invoice.pdf";
    $total_price = '0';
    $gst = '0';
    foreach ($total_item as $key => $value)
    {
      $total_price += $value['final_price'] * $value['qty'];
      $this->db->select('sub_category_id');
      $product_sub_cate = $this->db->get_where('sub_product_master', array('id' => $value['id']))->row_array();
      $this->db->select('cgst');
      $product_sub_cate = $this->db->get_where('sub_category_master', array('id' => $product_sub_cate['sub_category_id']))->row_array();
      $gst_calculation = ($product_sub_cate['cgst'] / 100) * $value['final_price'] * $value['qty'];
      $gst += $gst_calculation;
    }

    $this->db->select('min_order_bal,shipping_amount');
    $OrderSettings = $this->db->get_where('settings', array('id' => '1'))->row_array();
    $shipping = '0';


    if ($total_price > $OrderSettings['min_order_bal'])
    {
      $shipping = '0';
    } else
    {
      $shipping = $OrderSettings['shipping_amount'];
    }
    $total_price = $total_price + $shipping + $gst;
    // $total_price = $total_price;
    // echo "<pre>";print_r($total_price);exit();

    $order['order_number'] = 'ORD' . time();
    $order['user_master_id'] = $userData['id'];
    $order['pdf_link'] = base_url() . 'assets/invoice/' . $link;
    $order['total_price'] = $total_price;
    $order['final_price'] = $total_price;
    $order['payment_type'] = $data['paymentType'];
    if ($data['paymentType'] == '1')
    {
      $order['action_payment'] = "Yes";
    } else
    {
      $order['action_payment'] = "No";
    }
    $order['shippment_charge'] = $shipping;
    $order['gst'] = $gst;
    $order['status'] = '1';
    $order['add_date'] = time();
    $order['modify_date'] = time();

    $this->db->insert('order_master', $order);
    $lastId = $this->db->insert_id();
    $order = $this->db->get_where('order_master', array('id' => $lastId))->row_array();
    $this->db->select('mobile,email_id,username');
    $user_info = $this->db->get_where('user_master', array('id' => $order['user_master_id']))->row_array();
    $shop_ids = array();

    foreach ($total_item as $key => $value)
    {

      $sql = "UPDATE sub_product_master SET quantity = quantity - '" . $value['qty'] . "' WHERE id ='" . $value['id'] . "' ";
      $this->db->query($sql);

      $this->db->select('product_name,shop_id,sku_code,product_code,main_image');
      $product = $this->db->get_where('sub_product_master', array('id' => $value['id']))->row_array();

      //echo $this->db->last_query(); exit;
      //print_r($product['shop_id']);exit;
      $purchase = array();

      $purchase['order_master_id'] = $lastId;
      $purchase['shop_id'] = $product['shop_id'];
      $purchase['product_master_id'] = $value['id'];
      $purchase['product_name'] = $value['name'];
      $purchase['price'] = $value['price'];
      $purchase['final_price'] = $value['final_price'];// * $value['qty']
      $purchase['quantity'] = $value['qty'];
      $purchase['size'] = $value['size'];
      $purchase['color'] = $value['color'];
      $purchase['status'] = '1';
      $purchase['add_date'] = time();
      $purchase['modify_date'] = time();
      $this->db->insert('purchase_master', $purchase);

      $this->db->select('vendor_id');
      $shop = $this->db->get_where('shop_master', array('id' => $product['shop_id']))->row_array();

      $this->db->select('mobile,name,email');
      $staff = $this->db->get_where('staff_master', array('id' => $shop['vendor_id']))->row_array();

      $size = $purchase['size'];
      $color = $purchase['color'];
      $qty = $purchase['quantity'];
      /*Admin Place Order message*/
      $admin_message = "Dukekart has received an order on Product name: " . $product['product_name'] . ", Seller Mobile no: " . $staff['mobile'] . ".  Regards, Dukekart Real Time Private Limited , www.Dukekart.in";
      /*Seller Place Order Message*/
      $seller_login_link = "https://Dukekart.in/seller-login";
      $seller_message = "You have received an order on " . $order['order_number'] . " of " . $product['product_name'] . ". Check this link https://Dukekart.in/seller-login and confirm the order from your side. For help contact+91 9876543210-From Dukekart Real Time Private Limited";
      if ($data['paymentType'] == '1')
      {
        // sendSMS('9935149155', $admin_message, '1007850092609093226'); comment by danish
        sendSMS('7460833766', $admin_message, '1007850092609093226');
       // sendSMS($staff['mobile'], $seller_message, '1007123141312662937');  comment by danish
        foreach ($purchase as $key => $purchase)
        {
          //$product2 = $this->db->get_where('sub_product_master',array('id'=>$purchase['product_master_id']))->row_array();
          $array_url = parse_url($product['main_image']);
          if (empty($array_url['host']))
          {
            $img_url = base_url() . '/assets/product_images/' . $product['main_image'];
          } else
          {
            $img_url = 'https://' . $array_url['host'] . '' . $array_url['path'] . '?raw=1';
          }
        }

        $addr = $this->db->get_where('save_address_id', array('user_master_id' => $userData['id']))->row_array();

        if (empty($addr))
        {
          $address_data = $this->db->get_where('user_address_master', array('user_master_id' => $userData['id']))->row_array();
        } else
        {
          $addr = $this->db->get_where('save_address_id', array('user_master_id' => $userData['id']))->row_array();
          $address_data = $this->db->get_where('user_address_master', array('id' => $addr['address_id']))->row_array();
        }
        $status = "Order Recieved";
        $order_no = $order['order_number'];
        $user = $staff['name'];
        $email_text = "You have recieved an order from Dukekart.in. Order details are given below please let us know once order is ready";

        $img_link = $img_url;

        $product_title = $product['product_name'];
        // $size=              $purchase['size'];
        // $color=             $purchase['color'];
        // $qty=               $purchase['quantity'];

        $c_name = $userData['username'];
        $c_address = $address_data['address'];

        $emailid = $staff['email'];

        $product_code = $product['product_code'];
        $sku_code = $product['sku_code'];
        $date = date("d-m-Y");

        $this->load->helper('/email/temp2');
        $email_body = temp2($status, $order_no, $user, $email_text, $img_link, $product_title, $size, $color, $qty, $product_code, $sku_code, $date, $c_name, $c_address);
        //$subject="Your have recieved order #order no " .$order_no."";  
        //$subject="Hey ".$user."! You have an order #".$order_no." from Dukekart.in";
        $subject = "You have an order #" . $order_no . " from Dukekart.in";
      }
    }

    $addr = $this->db->get_where('save_address_id', array('user_master_id' => $userData['id']))->row_array();
    if (empty($addr))
    {
      $address_data = $this->db->get_where('user_address_master', array('user_master_id' => $userData['id']))->row_array();
    } else
    {
      $addr = $this->db->get_where('save_address_id', array('user_master_id' => $userData['id']))->row_array();
      $address_data = $this->db->get_where('user_address_master', array('id' => $addr['address_id']))->row_array();
    }

    $fields['order_master_id'] = $lastId;
    $fields['title'] = $address_data['title'];
    $fields['contact_person'] = $address_data['contact_person'];
    $fields['mobile_number'] = $address_data['mobile_number'];
    $fields['alternate_number'] = $address_data['alternate_number'];
    $fields['address'] = $address_data['address'];
    $fields['localty'] = $address_data['localty'];
    $fields['landmark'] = $address_data['landmark'];
    $fields['pincode'] = $address_data['pincode'];
    $fields['city'] = $address_data['city'];
    $fields['state'] = $address_data['state'];
    $fields['add_date'] = time();
    $fields['modify_date'] = time();

    $row = $this->db->insert('order_address_master', $fields);

    $this->db->where('user_master_id', $userData['id']);
    $this->db->delete('save_address_id');
    $this->pdfGenrate($lastId, $link);

    if ($data['paymentType'] == '1')
    {
      /*Place Order Customer Sms.*/
      //  OLD     //  $customer_message = "Dear ".$user_info['username'].", Your order no. ".$order['order_number']." has been placed successfully. We will update you soon as your order is ready for shipping. Thanks for shopping with us"; 
      // sendSMS('9935149155', $admin_message, '1007850092609093226');  comment by danish
      sendSMS('7460833766', $admin_message, '1007850092609093226');
      $customer_message = "Dear " . $user_info['username'] . " Thanks for your order. We've received your order and will update you soon as the seller confirms your orderRegardsDukakart Real Time Private Limited";
      //sendSMS($staff['mobile'], $seller_message, '1007123141312662937'); comment by danish
      // sendSMS('7905491970', $customer_message, '1007287118749920707'); comment by danish
      sendSMS($user_info['mobile'], $customer_message, '1007287118749920707');
      //**************  Order Placed Email To Seller and Admin *************************************** 
      $this->load->library('email_send');
      $this->email_send->send_email($emailid, $email_body, $subject);
      sentCommonEmail($emailid, $email_body, $subject);
      //************** Order Placed Email To Customer *************************************    
      $this->order_place_temp($lastId);
      /*Place Order Seller Sms*/
    }

    if ($data['paymentType'] == '2')
    {
      $time = time();
      $data = array();
      $data['final_price'] = $total_price + $order['shippment_charge'];
      $data['shipping_charge'] = '0';
      $data['userId'] = $userId;
      $data['currency'] = 'INR';
      $data['merchant_id'] = '2764260';
      $data['order_id'] = $order['order_number'];
      $data['tid'] = $tid;
      $data['amount'] = $total_price;
      $data['redirect_url'] = base_url('Web/GatewayRedirect');
      $data['cancel_url'] = base_url('Web/GatewayRedirect');
      $data['language'] = 'EN';
      $data['billing_name'] = $address_data['contact_person'];
      $data['billing_address'] = $address_data['address'];
      $data['billing_city'] = $address_data['city'];
      $data['billing_state'] = $address_data['state'];
      $data['billing_zip'] = $address_data['pincode'];
      $data['billing_country'] = 'India';
      $data['billing_tel'] = $address_data['mobile_number'];
      $data['billing_email'] = $userData['email'];
      $data['merchant_param1'] = 'Dukekart REAL TIME PRIVATE LIMITED';
      // echo "<pre>";print_r($data);exit();
      $this->load->view('paymentGateway/ccavRequestHandler', $data);
    } else
    {
      $this->cart->destroy();
      $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button>Order Booked successfully.</div></div>');
      redirect('web/order_success/' . base64_encode($lastId));
    }
  }

  public function order_complete()
  {
    $tid = $this->input->post('tid');
    $data = $this->input->post();

    $userData = $this->session->userdata('User');
    if (empty($userData))
      redirect('web/login');
    $userId = $userData['id'];

    $buyNow = $this->session->userdata('buy_now');

    // 1️⃣ Prepare items to process
    if (!empty($buyNow['pro_id']))
    {
      $prod = $this->db->get_where('sub_product_master', ['id' => $buyNow['pro_id']])->row_array();
      if (empty($prod))
      {
        $this->session->set_flashdata('activate_m', '<div class="alert alert-danger">Product not found.</div>');
        redirect('web/checkout');
      }
      $total_items = [
        [
          'id' => $prod['id'],
          'name' => $prod['product_name'],
          'price' => $prod['price'] ?? $prod['final_price'],
          'final_price' => $prod['final_price'],
          'qty' => (int) $buyNow['qty'],
          'size' => $prod['size'] ?? '',
          'color' => $prod['color'] ?? '',
          'image' => $prod['main_image'] ?? ''
        ]
      ];
      $is_buy_now = true;
    } else
    {
      $cart_contents = $this->cart->contents();
      if (empty($cart_contents))
      {
        $this->session->set_flashdata('activate_m', '<div class="alert alert-danger">Your cart is empty.</div>');
        redirect(base_url());
      }
      $total_items = [];
      foreach ($cart_contents as $c)
      {
        $total_items[] = [
          'id' => $c['id'],
          'name' => $c['name'],
          'price' => $c['price'] ?? $c['final_price'],
          'final_price' => $c['final_price'],
          'qty' => $c['qty'],
          'size' => $c['size'] ?? '',
          'color' => $c['color'] ?? '',
          'image' => $c['image'] ?? ''
        ];
      }
      $is_buy_now = false;
    }

    // 2️⃣ Calculate totals
    $total_price = 0;
    $gst_total = 0;
    foreach ($total_items as $itm)
    {
      $line = $itm['final_price'] * $itm['qty'];
      $total_price += $line;

      $sp = $this->db->select('sub_category_id')->get_where('sub_product_master', ['id' => $itm['id']])->row_array();
      $cgst = 0;
      if (!empty($sp['sub_category_id']))
      {
        $subcat = $this->db->select('cgst')->get_where('sub_category_master', ['id' => $sp['sub_category_id']])->row_array();
        $cgst = !empty($subcat['cgst']) ? (float) $subcat['cgst'] : 0;
      }
      $gst_total += ($cgst / 100) * $itm['final_price'] * $itm['qty'];
    }

    // 3️⃣ Shipping
    $OrderSettings = $this->db->get_where('settings', ['id' => '1'])->row_array();
    $shipping = 0;
    if (!empty($OrderSettings))
    {
      $min_bal = (float) $OrderSettings['min_order_bal'];
      $ship_amt = (float) $OrderSettings['shipping_amount'];
      $shipping = ($total_price > $min_bal) ? 0 : $ship_amt;
    }

    $grand_total = $total_price + $gst_total + $shipping;

    // 4️⃣ Prepare order
    $validPaymentTypes = [1, 2, 3];
    $paymentType = in_array((int) ($data['paymentType'] ?? 1), $validPaymentTypes) ? (int) $data['paymentType'] : 1;

    $order_number = 'ORD' . time();
    $order = [
      'order_number' => $order_number,
      'user_master_id' => $userId,
      'pdf_link' => base_url('assets/invoice/' . $order_number . "-invoice.pdf"),
      'total_price' => $grand_total,
      'final_price' => $grand_total,
      'payment_type' => $paymentType,
      'address_master_id' => $data['address_id'] ?? null,
      'action_payment' => ($paymentType == 1) ? "Yes" : "No",
      'shippment_charge' => $shipping,
      'gst' => $gst_total,
      'status' => '1',
      'add_date' => time(),
      'modify_date' => time()
    ];

    // 5️⃣ Insert order
    if ($paymentType == 1)
      $this->db->insert('order_master', $order);
    else
      $this->db->insert('order_master2', $order);

    $lastId = $this->db->insert_id();

    // 6️⃣ Insert purchase items
    foreach ($total_items as $itm)
    {
      $this->db->query("UPDATE sub_product_master SET quantity = quantity - " . (int) $itm['qty'] . " WHERE id = " . (int) $itm['id']);

      $product = $this->db->select('product_name,shop_id,main_image')->get_where('sub_product_master', ['id' => $itm['id']])->row_array();
      $shop = $this->db->select('vendor_id')->get_where('shop_master', ['id' => $product['shop_id'] ?? 0])->row_array();

      $purchase = [
        'order_master_id' => $lastId,
        'shop_id' => $product['shop_id'] ?? null,
        'vendor_master_id' => $shop['vendor_id'] ?? null,
        'product_master_id' => $itm['id'],
        'product_name' => $itm['name'],
        'price' => $itm['price'],
        'final_price' => $itm['final_price'],
        'quantity' => $itm['qty'],
        'size' => $itm['size'],
        'color' => $itm['color'],
        'status' => '1',
        'add_date' => time(),
        'modify_date' => time()
      ];

      if ($paymentType == 1)
        $this->db->insert('purchase_master', $purchase);
      else
        $this->db->insert('purchase_master2', $purchase);
    }

    // 7️⃣ Save address
    $address_data = $this->db->get_where('user_address_master', ['id' => $data['address_id']])->row_array();
    $fields = [
      'order_master_id' => $lastId,
      'title' => $address_data['title'] ?? '',
      'contact_person' => $address_data['contact_person'] ?? '',
      'mobile_number' => $address_data['mobile_number'] ?? '',
      'alternate_number' => $address_data['alternate_number'] ?? '',
      'address' => $address_data['address'] ?? '',
      'localty' => $address_data['localty'] ?? '',
      'landmark' => $address_data['landmark'] ?? '',
      'pincode' => $address_data['pincode'] ?? '',
      'city' => $address_data['city'] ?? '',
      'state' => $address_data['state'] ?? '',
      'add_date' => time(),
      'modify_date' => time()
    ];

    if ($paymentType == 1)
      $this->db->insert('order_address_master', $fields);
    else
      $this->db->insert('order_address_master2', $fields);

    // 8️⃣ Handle payment gateway
    if ($paymentType == 2)
    {
      // Online payment
      $gatewayData = [
        'final_price' => $grand_total,
        'shipping_charge' => $shipping,
        'userId' => $userId,
        'currency' => 'INR',
        'merchant_id' => '2764260',
        'order_id' => $order_number,
        'tid' => $tid,
        'amount' => $grand_total,
        'redirect_url' => base_url('Web/GatewayRedirect'),
        'cancel_url' => base_url('Web/GatewayRedirect'),
        'language' => 'EN',
        'billing_name' => $address_data['contact_person'] ?? '',
        'billing_address' => $address_data['address'] ?? '',
        'billing_city' => $address_data['city'] ?? '',
        'billing_state' => $address_data['state'] ?? '',
        'billing_zip' => $address_data['pincode'] ?? '',
        'billing_country' => 'India',
        'billing_tel' => $address_data['mobile_number'] ?? '',
        'billing_email' => $userData['email'] ?? '',
        'merchant_param1' => 'Dukekart REAL TIME PRIVATE LIMITED'
      ];

      $this->load->view('paymentGateway/ccavRequestHandler', $gatewayData);
      return; // stop further execution
    }

    // 9️⃣ COD or offline payment
    $this->cart->destroy();
    $this->session->unset_userdata(['buy_now', 'checkout_items']);
    redirect('web/order_success/' . base64_encode($lastId));
  }




  public function cancel_order()
  {
    $order_id = $this->input->post('order_id');

    $order = $this->db->get_where('order_master', ['id' => $order_id])->row_array();

    if (!$order)
    {
      echo json_encode(['status' => 'error', 'message' => 'Order not found!']);
      return;
    }

    // Allow cancel only if Pending (1) or Confirmed by seller (3 or 5)
    if (!in_array($order['status'], [1, 3, 5]))
    {
      echo json_encode(['status' => 'error', 'message' => 'This order cannot be cancelled!']);
      return;
    }

    $this->db->where('id', $order_id);
    $this->db->update('order_master', ['status' => 4]); // 2 = Cancelled

    echo json_encode(['status' => 'success', 'message' => 'Your order has been cancelled successfully.']);
  }




  function pdfGenrate($pakage_master_id, $pdfFilePath)
  {
    error_reporting(0);
    $OrderDetail = $this->db->order_by('id', 'desc')->get_where('order_master', array('id' => $pakage_master_id))->row_array();
    $getProduct = $this->db->get_where('purchase_master', array('order_master_id' => $pakage_master_id))->result_array();
    $getAddress = $this->db->get_where('order_address_master', array('order_master_id' => $pakage_master_id))->row_array();
    $getShippingVal = $this->db->get_where('settings', array('id' => '1'))->row_array();
    $gst = $OrderDetail['gst'];
    $link = time() . "-invoice.pdf";
    $html = '';
    $html .= '<style> 
                    table {
                        border-collapse: collapse;
                    }
                    td, th {
                      border: 1px solid #dddddd;
                      text-align: left;
                      padding: 8px;
                    }</style>
                    <h1 style="text-align:center;font-size:34px"><u>Invoice</u></h1>';
    $html .= '<div style="float:left;width:100%; margin-top:20px;">
                    <div style="float:left;width:70%">
                        <div class="image">
                            <h3>Dukekart Real Time Pvt.Ltd.</h3>
                        </div>
                        <div style="margin-left: 30px; top: -60px" > 
                            <div style="margin-left: 140px !important;"></div>
                        </div>
                    </div>
                    <div style="float:left;width:30%;">
                        <div>
                            <b style="font-size:15px;"> Order No &nbsp;:</b>&nbsp;
                            ' . $OrderDetail['order_number'] . '
                        </div>
                        <br>
                        <b style="font-size:15px;"> Order Date :</b>&nbsp;' . date('d-m-Y', $OrderDetail['add_date']) . '
                    </div>
                  </div>';

    $total1 = 0;
    $total = 0;
    $i = 1;
    foreach ($getProduct as $key => $value)
    {
      $total += $value['final_price'] * $value['quantity'];
    }

    $TotalValue = $total;
    // $html .= '<div style="width:100%; margin-top:10px;"><div style="width:70%;float:left;"><b>Delivery Address : </b><br> ' . ucwords($getAddress['title']) . '<br>' . $getAddress['contact_person'] . ', ' . $getAddress['address'] . ', ' . $getAddress['localty'] . '<br>' . $getAddress['city'] . ', ' . $getAddress['state'] . ' .<br> <b>Pincode</b> ' . $getAddress['pincode'] . '<br> <b>Mob. No.</b>' . $getAddress['mobile_number'] . '</div>
    $html .= '<div style="width:100%; margin-top:10px;"><div style="width:70%;float:left;"><b>Delivery Address : </b><br>' . $getAddress['contact_person'] . ', ' . $getAddress['address'] . ', ' . $getAddress['localty'] . '<br>' . $getAddress['city'] . ', ' . $getAddress['state'] . ' .<br> <b>Pincode</b> ' . $getAddress['pincode'] . '<br> <b>Mob. No.</b>' . $getAddress['mobile_number'] . '</div>
        <div style="width:30%;float:right"><b font-size:13px;> Total Item&nbsp;&nbsp;&nbsp;: </b>' . count($getProduct) . '<br><br><b font-size:13px;> Total Value Rs : </b>' . $TotalValue . '/- </div></div>';

    $html .= '<div style="float:left;width:100%; margin-top:50px;"><table border="0" width="100%"><tr><th width="70px;">Sr. No.</th><th>Product&nbsp;List</th><th>Unit&nbsp;Price</th><th>Qty</th><th>Size</th><th>Weight</th><th>HSN</th><th>Total Amount</th></tr>';
    $total1 = 0;
    $total = 0;
    $i = 1;

    foreach ($getProduct as $key => $value)
    {
      $hsnArr = $this->db->get_where('sub_product_master', array('id' => $value['product_master_id']))->row_array();
      $html .= '<tr><td>' . $i . '.</td><td>' . $value['product_name'] . '</td><td>' . $value['final_price'] . '</td><td>' . $value['quantity'] . '</td><td>' . $value['size'] . '</td><td>' . $value['color'] . '</td><td>' . $hsnArr['product_hsn'] . '</td><td>Rs. ' . $value['final_price'] * $value['quantity'] . '/-</td></tr>';
      $i++;
      $total += $value['final_price'] * $value['quantity'];
    }


    $shippingAmount = $OrderDetail['shippment_charge'];
    $TotalValue = $total + $shippingAmount + $gst;

    $html .= '<tr><td colspan="7">Total</td><td>Rs. ' . $total . '/-</td></tr>';

    $html .= '</table></div>';
    $html .= '<div style="float:left;width:100%; margin-top:25px;"><div style="float:left;width:60%"></div><div style="float:right;width:40%"><table><tr><td><p style="font-size:14px;"><b>Total</b></p></td><td>' . $total . '/-</td></tr> <tr><td><p style="font-size:14px;">GST :</p></td><td>' . $gst . '/-</td></tr><tr><td><p style="font-size:14px;">Shipping & Delivery Charge </p></td><td>' . $shippingAmount . '/-</td></tr><tr><td><p style="font-size:14px;">Grand Total </p></td><td><b>' . $TotalValue . '/-</b></td></tr></table>

        <p style="color:red">Note: Including Shipping Charges and taxes.</p></div></div>';

    $html .= '<center> <div>
        <center><span style="font-weight: 600;font-size: 18px;">Thank you.....  <br> <span style="font-size: 15px;font-weight: 700;color: #005512;"> Order By Dukekart Real Time Pvt.Ltd.</span>
        <br>
        <span style="font-size: 15px;font-weight: 600;">+91 7460833766</span>
        <br>
        <span style="font-size: 15px;font-weight: 600;">Dukekart110@gmail.com</span>
        </span>
        </center>
        </div> </center>';

    // $html .= '<div style="float:left;width:80%;margin-left:30%"><table><tr><td><p style="font-size:16px;">Thank you...</p>Order By - </td><td><div class="image" style="margin-top:4px;"><br><h4><i>Dukekart Pvt. Ltd.</i></h4></div><div style="top: -60px">
    //     </div></td></tr></table></div>
    //   ';

    $html .= '<br><p style="text-align:center;">(This is a system generated invoice and does not require a signature.)</p>';
    // echo "<pre>";print_r($html);exit();

    $pdfFilePath = INVOICE_DIRECTORY . $pdfFilePath;

    $this->load->library('m_pdf');
    $this->m_pdf->pdf->autoScriptToLang = true;
    $this->m_pdf->pdf->autoLangToFont = true;
    $PDFContent = mb_convert_encoding($html, 'utf-8', 'A4-C');
    $this->m_pdf->pdf->WriteHTML($PDFContent);
    $this->m_pdf->pdf->Output($pdfFilePath, "F");
  }




  public function order_place_temp($order_id)
  {

    $OrderDetail = $this->db->get_where('order_master', array('id' => $order_id))->row_array();
    $user_info = $this->db->get_where('user_master', array('id' => $OrderDetail['user_master_id']))->row_array();
    $purchase = $this->db->get_where('purchase_master', array('order_master_id' => $order_id))->result_array();
    $address_info = $this->db->get_where('order_address_master', array('order_master_id' => $order_id))->row_array();



    //***********  Order Placed Email to Customer *******************

    // foreach ($purchase as $key => $purchase) {

    //   $product = $this->db->get_where('sub_product_master', array('id' => $purchase['product_master_id']))->row_array();

    //   $array_url = parse_url($product['main_image']);

    //   if (empty($array_url['host'])) {
    //     $img_url = base_url() . '/assets/product_images/' . $product['main_image'];
    //   } else {
    //     $img_url = 'https://' . $array_url['host'] . '' . $array_url['path'] . '?raw=1';
    //   }




    // }



    //$this->load->library('email_send');

    $status = "Order Placed";
    $order_no = $OrderDetail['order_number'];
    $user = $user_info['username'];
    // $email_text = "Thank You for shopping with Dukekart. We would like to let you know that your order has been placed and we are waiting for your order confirmation by the seller. If you would like to view the status of order please visit YOUR ORDERS on Dukekart.in";

    // $img_link = $img_url;

    // $product_title = $product['product_name'];
    // $size = $purchase['size'];
    // $color = $purchase['color'];
    // $qty = $purchase['quantity'];

    // $price = $OrderDetail['total_price'];
    // $shipping = "Free";
    // $discount = '0';
    // $total = $OrderDetail['final_price'];
    // $c_name = $user;
    // $c_address = $address_info['address'];

    //$address_info['city']
//$address_info['state']
    $emailid = $user_info['email_id'];

    //Value passing through array
//$order_details= [];



    $this->load->helper('/email/temp1');
    // $email_body = temp1($status, $order_no, $user, $email_text, $img_link, $product_title, $size, $color, $qty, $price, $shipping, $discount, $total, $c_name, $c_address);
    $subject = "Your order no " . $order_no . " placed successful";

    //  $this->email_send->send_email($emailid,$email_body,$subject);

    // sentCommonEmail($emailid, $email_body, $subject);


    //************************ End order placed ********************************************
    $html = '';



    $html .= '<div class="container" style="margin: 0 70px;background-color: white;margin-top:20px;border:4px solid rgb(239,126,45);height: auto;padding: 20px;border-radius: 10px;font-size: 15px;">
    <img class="img-fluid" src="https://Dukekart.in/My-Img/INCONS/SO-logo.png" alt="Dukekart" style="position: absolute;top: 0;height: 42px;width: 200px;">
    <div class="billing-head" style="margin: 0px;float: right;font-size: 15px;font-weight: 500;">
      <div class="row" >
        <div class="col-12"><p style="margin: 0px;float: right;font-size: 15px;font-weight: 500;">Order Placed</p></div>
        <div class="col-12"><p style="margin: 0px;float: right;font-size: 15px;font-weight: 500;">Order No. <span>' . $OrderDetail['order_number'] . '</span></p></div>
      </div>  
    </div>
    <div class="row" style="padding:1em 1em 0;">
      <div class="col-12"><span style="font-size:17px;
      font-weight: 500;">Hello ' . $user_info['username'] . ',</span><p style="text-indent: 3em;">Your order no. ' . $OrderDetail['order_number'] . ' has been confirmed by the seller and ready for the shipping. Once your shipment is ready we will notify you with order tracking details.</p></div>
      <!--  <div class="col-12"><p>Order No. <span>' . $OrderDetail['order_number'] . '</span></p></div> -->
    </div>
    <section style=" padding: 0px 10% 0 10%; margin: 5px 0px 10px;">
    <h3>Order Details <span style="font-size:17px;font-weight: 700;padding-left: 10em;"><h3>';


    foreach ($purchase as $key => $purchase)
    {

      $product = $this->db->get_where('sub_product_master', array('id' => $purchase['product_master_id']))->row_array();

      $array_url = parse_url($product['main_image']);

      if (empty($array_url['host']))
      {
        $img_url = base_url() . '/assets/product_images/' . $product['main_image'];
      } else
      {
        $img_url = 'https://' . $array_url['host'] . '' . $array_url['path'] . '?raw=1';
      }

      $html .= '
        <ul style="display: flex;list-style-type: none">
          <li>
          <img class="product-img" src="' . $img_url . '" alt="Product Image" style="height: 150px;width: 185px;border: 0.01em solid #666;padding: 8px;border-radius: 10px;">
          </li>
          <li style="padding-left: 5em;">
            <p style="font-size:15px;font-weight: 600;">' . $product['product_name'] . '</p>
            <p style="font-size:15px;font-weight: 600;">Size: ' . $purchase['size'] . '</p>
            <p style="font-size:15px;font-weight: 600;">Color: ' . $purchase['color'] . '</p>
            <p style="font-size:15px;font-weight: 600;">QTY: ' . $purchase['quantity'] . '</p>
          </li>
        </ul>';


    }
    $html .= '</section>
          <table style="width:100%; padding: 0px 10% 0 13%; margin: 5px 0px 10px;">
        
          <tr>
            <td><span style="font-size:19px;font-weight: 500;">Price</span></td>
            <td style="padding-left: 10em"> ' . $OrderDetail['total_price'] . '</td>

          </tr>
          <tr>
            <td><span style="font-size:19px;font-weight: 500;">Shipping Charges</span></td>
            <td style="padding-left: 10em"> 0</td>
          </tr>
          <tr>
            <td><span style="font-size:19px;font-weight: 500;">Discount</span></td>
            <td style="padding-left: 10em"> 0</td>
          </tr>
          <tr>
            <td><span style="font-size:19px;font-weight: 500;">Total</span></td>
            <td  style="padding-left: 10em"> ' . $OrderDetail['final_price'] . '</td>
          </tr>
        </table>


        <table style="width:100%; padding: 0px 10% 0 11%; margin: 5px 0px 10px;border: 1.5px solid rgb(239,126,45); padding-bottom: 17px;background: #f5f5f5;">
          <tr>
            <td><img src="https://Dukekart.in/assets/flow.png" alt="Request Flow" style="height: 65px;width:55%;margin-bottom: 10px;"></td>
            <td><span style="padding-top:1em;font-size:15px;font-weight: 500;">Delivery Details</span></td>
          </tr>
          <tr>
            <td><span style="font-size:15px;font-weight: 600;padding-left: 20px;">Expected Delivery: ' . date('d M, Y', strtotime('+10 day', $OrderDetail['add_date'])) . '</span></td>
            <td><span style="font-size:15px;font-weight: 500;">User Name: <span>' . $user_info['username'] . '</span></p></span>
            </tr>
          <tr>
            <td><span style="font-size:15px;font-weight: 600;padding-left: 20px;"> Order Placed On (' . date(
        "d M, Y",
        $OrderDetail['add_date']
      ) . ')</span></td>
            <td><span style="font-size:15px;font-weight: 500;">Address:<span>' . $address_info['address'] . '</span></span></td>
          </tr>
          <tr>
            <td></td>
            <td><span style="font-size:15px;font-weight: 500;">Location:<span>' . $address_info['city'] . ',' . $address_info['state'] . '</span></span></td>
          </tr>
        </table>
      
       <table style="width:100%;padding: 0px 10% 0 13%; margin: 5px 0px 10px;">
          
          <tr>
            <td><img src="https://Dukekart.in/My-Img/INCONS/SO-logo.png" alt="Dukekart" style="height: 38px;width: 100px;"></td>
            <td><img src="https://Dukekart.in/assets/google_play.png" alt="Dukekart" style="width:100px;margin-top:-12px;"></td>
            <td><a href="https://www.facebook.com/infoDukekart"><img src="https://Dukekart.in/assets/facebook.png" alt="Dukekart" style="height: 36px;width: 42px;background: transparent;margin-right: 16px;"></a>
              <a href="https://www.instagram.com/Dukekart_official"><img src="https://Dukekart.in/assets/instagram.png" alt="Dukekart" style="height: 36px;width: 42px;background: transparent;margin-right: 16px;"></a>
              <a href="https://twitter.com/infoDukekart"><img src="https://Dukekart.in/assets/twitter.jpg" alt="Dukekart" style="height: 36px;width: 42px;background: transparent;margin-right: 16px;"></a></td>
          </tr>
        </table>
      </div>';



    $this->sentCommonEmail2($user_info['email_id'], $html, 'Order Place Successfully.');

  }

  function sentCommonEmail2($email, $smsmessage, $sub)
  {
    // ++++++++++++++
    $to = $email;
    $subject = $sub;
    $message .= "Note - This is a System Generated Mail, please do not reply.\r\n";
    $headers = "From:" . "support@Dukekart.in" . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";
    mail($to, $subject, $smsmessage, $headers);
    return 1;
  }



  public function setCorierData($order_id)
  {


    $total_item = $this->cart->contents();

    $userData = $this->session->userdata('User');

    $order = $this->db->get_where('order_master', array('id' => $lastId))->row_array();

    $address_data = $this->db->get_where('user_address_master', array('user_master_id' => $userData['id']))->row_array();

    $rate_cal['from_pincode'] = '226001';
    $rate_cal['to_pincode'] = '226010';
    $rate_cal['shipping_length_cms'] = '11';
    $rate_cal['shipping_width_cms'] = '8';
    $rate_cal['shipping_height_cms'] = '2';
    $rate_cal['shipping_weight_kg'] = '0.2';
    $rate_cal['order_type'] = 'forward';
    $rate_cal['payment_method'] = 'cod';
    $rate_cal['product_mrp'] = '1200';
    $rate_cal['access_token'] = '28b4d9246917ac19f5f9cea9861bc731';
    $rate_cal['secret_key'] = 'df1b745f66e9b39f81b70b8bc2ad4689';

    $response['data'] = $rate_cal;

    print_r(json_encode($response));
    exit;

  }

  public function GatewayRedirect()
  {
    $this->load->view('paymentGateway/ccavResponseHandler');
  }

  public function GatewayAppRedirect()
  {
    $this->load->view('paymentGateway/ccavResponseHandler2');
  }



public function order_success($order_id)
{
    // Decode the order ID
    $decoded_order_id = base64_decode($order_id);

    // Default table names
    $tables = [
        'order' => 'order_master',
        'address' => 'order_address_master',
        'purchase' => 'purchase_master'
    ];

    // Try first table
    $order = $this->db->get_where($tables['order'], ['id' => $decoded_order_id])->row_array();

    // If empty, try second table
    if (empty($order)) {
        $tables['order'] = 'order_master2';
        $tables['address'] = 'order_address_master2';
        $tables['purchase'] = 'purchase_master2';

        $order = $this->db->get_where($tables['order'], ['id' => $decoded_order_id])->row_array();
    }

    // If still empty, show 404
    if (empty($order)) {
        show_404();
    }

    // Fetch address
    $address_data = $this->db->get_where($tables['address'], ['order_master_id' => $decoded_order_id])->row_array();

    // Fetch purchased items
    $purchase_items = $this->db->get_where($tables['purchase'], ['order_master_id' => $decoded_order_id])->result_array();

    // Payment type mapping
    $paymentTypeMap = [
        1 => 'Cash on Delivery',
        2 => 'Online Payment',
        3 => 'Wallet'
    ];

    // Force cast to int to avoid string/int mismatch
    $payment_type = isset($order['payment_type']) ? (int)$order['payment_type'] : 0;
    $paymentTypeName = $paymentTypeMap[$payment_type] ?? 'Unknown';

    // Prepare data for view
    $data = [
        'title' => 'Order Success | Dukekart',
        'order_data' => $order,
        'address_data' => $address_data,
        'purchase_items' => $purchase_items,
        'paymentTypeName' => $paymentTypeName
    ];

    // Load views
    $this->load->view('web/include/header', $data);
    $this->load->view('web/order_complete', $data);
    $this->load->view('web/include/footer', $data);
}









  public function order_success2($order_id)
  {

    $orderData = $this->db->get_where('order_master', array('order_number' => $order_id))->row_array();

    $userData = $this->session->userdata('User');
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['address_data'] = $this->db->get_where('order_address_master', array('order_master_id' => $orderData['id']))->row_array();
    $data['order_data'] = $orderData;
    $data['title'] = 'Order Sucess | Dukekart';
    $this->load->view('web/include/header', $data);
    $this->load->view('web/order_complete');
    $this->load->view('web/include/footer');

  }

  function pdfGenrate_old21032024($pakage_master_id, $pdfFilePath)
  {

    error_reporting(0);
    $OrderDetail = $this->db->order_by('id', 'desc')->get_where('order_master', array('id' => $pakage_master_id))->row_array();

    $getProduct = $this->db->get_where('purchase_master', array('order_master_id' => $pakage_master_id))->result_array();


    $getAddress = $this->db->get_where('order_address_master', array('order_master_id' => $pakage_master_id))->row_array();


    $getShippingVal = $this->db->get_where('settings', array('id' => '1'))->row_array();

    $gst = $OrderDetail['gst'];


    $link = time() . "-invoice.pdf";
    $html = '';
    $html .= '<style> 
    table {
        border-collapse: collapse;
    }
    td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}  </style><h1 style="text-align:center;font-size:34px"><u>Invoice</u></h1>';
    $html .= '<div style="float:left;width:100%; margin-top:20px;"><div style="float:left;width:70%"><div class="image"><h3>Dukekart Real Time Pvt.Ltd.</h3></div><div style="margin-left: 30px; top: -60px" > 
                <div style="margin-left: 140px !important;"></div></div></div><div style="float:left;width:30%;"><div><b style="font-size:15px;"> Order No &nbsp;:</b></b>&nbsp;' . $OrderDetail['order_number'] . '</div><br><b style="font-size:15px;"> Order Date :</b>&nbsp;' . date('d-m-Y', $OrderDetail['add_date']) . ' </div>
         </div></div>';

    $total1 = 0;
    $total = 0;
    $i = 1;
    foreach ($getProduct as $key => $value)
    {

      $total += $value['final_price'] * $value['quantity'];

    }

    $TotalValue = $total;




    $html .= '<div style="width:100%; margin-top:10px;"><div style="width:70%;float:left;"><b>Delivery Address : </b><br> ' . ucwords($getAddress['title']) . '<br>' . $getAddress['contact_person'] . ', ' . $getAddress['address'] . ', ' . $getAddress['localty'] . '<br>' . $getAddress['city'] . ', ' . $getAddress['state'] . ' .<br> <b>Pincode</b> ' . $getAddress['pincode'] . '<br> <b>Mob. No.</b>' . $getAddress['mobile_number'] . '</div>
        <div style="width:30%;float:right"><b font-size:13px;> Total Item&nbsp;&nbsp;&nbsp;: </b>' . count($getProduct) . '<br><br><b font-size:13px;> Total Value Rs : </b>' . $TotalValue . '/- </div></div>';




    $html .= '<div style="float:left;width:100%; margin-top:50px;"><table border="0" width="100%"><tr><th width="70px;">Sr. No.</th><th>Product&nbsp;List</th><th>Unit&nbsp;Price</th><th>Qty</th><th>Size</th><th>Weight</th><th>HSN</th><th>Total Amount</th></tr>';
    $total1 = 0;
    $total = 0;
    $i = 1;

    foreach ($getProduct as $key => $value)
    {
      $hsnArr = $this->db->get_where('sub_product_master', array('id' => $value['product_master_id']))->row_array();
      $html .= '<tr><td>' . $i . '.</td><td>' . $value['product_name'] . '</td><td>' . $value['final_price'] . '</td><td>' . $value['quantity'] . '</td><td>' . $value['size'] . '</td><td>' . $value['color'] . '</td><td>' . $hsnArr['product_hsn'] . '</td><td>Rs. ' . $value['final_price'] * $value['quantity'] . '/-</td></tr>';


      $i++;
      $total += $value['final_price'] * $value['quantity'];

    }


    $shippingAmount = $OrderDetail['shippment_charge'];
    $TotalValue = $total + $shippingAmount + $gst;

    $html .= '<tr><td colspan="7">Total</td><td>Rs. ' . $total . '/-</td></tr>';

    $html .= '</table></div>';
    $html .= '<div style="float:left;width:100%; margin-top:25px;"><div style="float:left;width:60%"></div><div style="float:right;width:40%"><table><tr><td><p style="font-size:14px;"><b>Total</b></p></td><td>' . $total . '/-</td></tr> <tr><td><p style="font-size:14px;">GST :</p></td><td>' . $gst . '/-</td></tr><tr><td><p style="font-size:14px;">Shipping & Delivery Charge </p></td><td>' . $shippingAmount . '/-</td></tr><tr><td><p style="font-size:14px;">Grand Total </p></td><td><b>' . $TotalValue . '/-</b></td></tr></table>

        <p style="color:red">Note: Including Shipping Charges and taxes.</p></div></div>';


    $html .= '<center> <div>
        <center><span style="font-weight: 600;font-size: 18px;">Thank you.....  <br> <span style="font-size: 15px;font-weight: 700;color: #005512;"> Order By Dukekart Real Time Pvt.Ltd.</span>
        <br>
        <span style="font-size: 15px;font-weight: 600;">+91 7460833766</span>
        <br>
        <span style="font-size: 15px;font-weight: 600;">Dukekart110@gmail.com</span>
        </span>
        
        </center>
 </div> </center>';

    // $html .= '<div style="float:left;width:80%;margin-left:30%"><table><tr><td><p style="font-size:16px;">Thank you...</p>Order By - </td><td><div class="image" style="margin-top:4px;"><br><h4><i>Dukekart Pvt. Ltd.</i></h4></div><div style="top: -60px">
    //     </div></td></tr></table></div>
    //   ';

    $html .= '<br><p style="text-align:center;">(This is a system generated invoice and does not require a signature.)</p>';
    $pdfFilePath = INVOICE_DIRECTORY . $pdfFilePath;

    $this->load->library('m_pdf');
    $this->m_pdf->pdf->autoScriptToLang = true;
    $this->m_pdf->pdf->autoLangToFont = true;
    $PDFContent = mb_convert_encoding($html, 'utf-8', 'A4-C');
    $this->m_pdf->pdf->WriteHTML($PDFContent);
    $this->m_pdf->pdf->Output($pdfFilePath, "F");
  }



  // apply copoun

  public function apply_voucher()
  {
    $user_ses = $this->session->userdata('User');
    $u_id = $user_ses['id'];
    $data = $this->input->post();

    $voucher_code = $data['voucher_code'];
    $type = $data['type'];
    $voucherData = $this->db->get_where('voucher_master', array('voucher_code' => $voucher_code))->row_array();

    $voucher_uses_limit = $voucherData['no_of_uses'];
    $check_cart_amt = $voucherData['min_cart_value'];
    $voucher_id = $voucherData['id'];
    $voucher_value = $voucherData['voucher_value'];
    $oldCartAmt = $this->cart->total();


    if (!empty($voucherData))
    {

      $totalCartAmt = $this->cart->total();

      if ($totalCartAmt > $check_cart_amt)
      {

        $check_vouch = $this->db->select_sum('voucher_uses')
          ->from('voucher_validity_master')
          ->where('voucher_id', $voucher_id)
          ->get();
        $check_vouch_valdity = $check_vouch->result_array();

        $vouch_valdity = $check_vouch_valdity[0]['voucher_uses'];

        if ($vouch_valdity < $voucher_uses_limit)
        {

          $this->db->where('user_id', $u_id);

          $this->db->where('voucher_id', $voucher_id);

          $check_user_voucher_use = $this->db->get('voucher_validity_master')->row_array();

          if ($check_user_voucher_use)
          {



            $newCartAmt = $_SESSION['cart_contents']['cart_total'] = $totalCartAmt - $voucherData['voucher_value'];

            $vouchValData = array(
              'voucher_uses' => $check_user_voucher_use['voucher_uses'] + 1
            );

            $this->db->where('id', $check_user_voucher_use['id']);
            $this->db->update('voucher_validity_master', $vouchValData);
            // <img src='".base_url()."/assets/emoji/congratulation.png' height='50px' width='50px'>&nbsp;
            $this->session->set_flashdata("Voucher_Succ", "<img src='" . base_url() . "/assets/emoji/congratulation.png' height='50px' width='50px'>&nbsp;congratulation.!  You get OFF <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $oldCartAmt . "-" . $voucherData['voucher_value'] . "&nbsp;=&nbsp;" . $newCartAmt . "&nbsp;<i class='fa fa-rupee'></i>");



          } else
          {

            $newCartAmt = $_SESSION['cart_contents']['cart_total'] = $totalCartAmt - $voucherData['voucher_value'];

            $vouchValData = array(
              'user_id' => $u_id,
              'voucher_id' => $voucher_id,
              'voucher_uses' => 1
            );
            $this->db->insert('voucher_validity_master', $vouchValData);

            $this->session->set_flashdata("Voucher_Succ", "<img src='" . base_url() . "/assets/emoji/congratulation.png' height='50px' width='50px'>&nbsp;congratulation.!  You get &nbsp;&nbsp;&nbsp;&nbsp; OFF&nbsp;" . $oldCartAmt . "-" . $voucherData['voucher_value'] . "&nbsp;=&nbsp;" . $newCartAmt . "&nbsp;<i class='fa fa-rupee'></i>");

          }

        } else
        {
          $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button><img src="' . base_url() . '/assets/emoji/expire.png" height="50px" width="50px">Opps..Voucher Expired</div></div>');
          redirect('web/checkout_payment');
        }

        $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button><img src="' . base_url() . '/assets/emoji/happy.png" height="50px" width="50px">&nbsp;Voucher Applied successfully.</div></div>');
        // $voucher_succ = $voucher_id;
        // $voucher_succ = $voucher_id;
        redirect('web/checkout_payment/voucher');
      } else
      {
        $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button><img src="' . base_url() . '/assets/emoji/lowcart_amt.png" height="50px" width="50px">Please limit your cart amount up to ' . $check_cart_amt . '&nbsp;<i class="fa fa-rupee"></i></div></div>');
        redirect('web/checkout_payment');
      }
    } else
    {
      $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button><img src="' . base_url() . '/assets/emoji/thinking.png" height="50px" width="50px">Voucher Code is Invalid,Please try again.</div></div>');
      redirect('web/checkout_payment');
    }
  }











  // Apply Coupon code start here


  public function apply_coupon()
  {
    $user_ses = $this->session->userdata('User');

    $u_id = $user_ses['id'];
    $data = $this->input->post();

    $coupon_code = $data['coupon_code'];
    $payment_mode = $data['payment_mode'];

    if ($payment_mode == '1')
    {
      $payment_mode = 'cod';
    } else
    {
      $payment_mode = 'online';
    }

    $couponData = $this->db->get_where('coupon_master', array('coupon_code' => $coupon_code, 'status' => '1'))->row_array();


    $applyCouponOn = json_decode($couponData['apply_coupon']);

    $coupon_uses_limit = $couponData['max_total_usage'];

    // $coupon_end_date = $couponData['end_date'];  
    $coupon_end_date = date("Y-m-d", $couponData['end_date']);

    $current_date = date("Y-m-d", time());

    $product_price_range = $couponData['product_price_range'];

    $coupon_discount_type = $couponData['coupon_discount_type'];

    $apply_discountOn = $couponData['apply_discount'];

    $coupon_type = $couponData['coupon_type'];

    $minimum_discount_value = $couponData['min_dis_val'];

    $check_cart_amt = $couponData['minimum_applicable_amount'];

    $coupon_id = $couponData['id'];

    $oldCartAmt = $this->cart->total();
    $totalCartAmt = $this->cart->total();

    if (!empty($couponData))
    {

      if ($couponData['applicable_payment_mode'] == $payment_mode)
      {

        if ($coupon_end_date >= $current_date)
        {

          $cartAllData = $this->cart->contents();


          //for apply discount OverAll Product

          if ($apply_discountOn == '1')
          {
            if ($totalCartAmt > $check_cart_amt)
            {

              $proId = array();
              foreach ($cartAllData as $cartData)
              {
                $proId[] = $cartData['id'];

              }

              //if($arrayRec = array_intersect($proId,$applyCouponOn)){

              $this->db->select('*');
              $this->db->from('sub_product_master');
              $this->db->where_in('id', $proId);
              $this->db->where('final_price >', $product_price_range);
              $filter_pro_rec = $this->db->get()->result_array();

              if ($filter_pro_rec)
              {

                $check_coupon = $this->db->select_sum('coupon_uses')
                  ->from('coupon_validity_master')
                  ->where('coupon_id', $coupon_id)
                  ->get();
                $check_coupon_valdity = $check_coupon->result_array();

                $coupon_valdity = $check_coupon_valdity[0]['coupon_uses'];

                if ($coupon_valdity < $coupon_uses_limit)
                {

                  $this->db->where('user_id', $u_id);

                  $this->db->where('coupon_id', $coupon_id);

                  $check_user_coupon_use = $this->db->get('coupon_validity_master')->row_array();

                  if ($check_user_coupon_use)
                  {

                    if ($coupon_discount_type == 1)
                    { // 1= FLAT Discount, 2= percentage


                      if ($coupon_type == 1)
                      { // 1=  Discountable Amount, 2= cashback
                        $newCartAmt = $_SESSION['cart_contents']['cart_total'] = $totalCartAmt - $couponData['coupn_discount_val'];

                        // $dd = $_SESSION["Coupon_Succ"] = "Coupon Applied Successfully You get ".$oldCartAmt."-".$couponData['coupn_discount_val']."=".$newCartAmt."";

                        $this->session->set_flashdata("Coupon_Succ", "<b>Discount:</b>&nbsp;&nbsp;&nbsp;&nbsp;-" . $couponData['coupn_discount_val'] . "&nbsp;<i class='fa fa-rupee'></i>");

                      } else
                      {

                        $userWallet = $this->db->get_where('wallet_master', array('user_master_id' => $u_id))->row_array();

                        if ($userWallet)
                        {
                          $walletAmt = $userWallet['wallet_amount'] + $couponData['coupn_discount_val'];

                          $updateWalletData = array(
                            'wallet_amount' => $walletAmt,
                            'add_date' => time()
                          );
                          $this->db->where('user_master_id', $u_id);
                          $this->db->update('wallet_master', $updateWalletData);

                          $this->session->set_flashdata("Coupon_Succ", "Get &nbsp;&nbsp;" . $couponData['coupn_discount_val'] . "&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");

                        } else
                        {

                          $walletAmt = array(
                            'user_master_id' => $u_id,
                            'wallet_amount' => $couponData['coupn_discount_val'],
                            'status' => '1',
                            'add_date' => time()
                          );

                          $this->db->insert('wallet_master', $walletAmt);

                          $this->session->set_flashdata("Coupon_Succ", "Get &nbsp;&nbsp;" . $couponData['coupn_discount_val'] . "&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");
                        }

                      }

                    } else
                    {

                      if ($coupon_type == 1)
                      { // 1=  Discountable Amount, 2= cashback

                        // $discountAmt = $totalCartAmt*$couponData['coupn_discount_val']/100;
                        $discountAmt = $filter_pro_rec[0]['final_price'] * $couponData['coupn_discount_val'] / 100;

                        $discountAmt = round($discountAmt);

                        if ($discountAmt > $minimum_discount_value)
                        {

                          $discountAmt = $minimum_discount_value;

                          $newCartAmt = $_SESSION['cart_contents']['cart_total'] = $totalCartAmt - $discountAmt;

                        } else
                        {

                          $newCartAmt = $_SESSION['cart_contents']['cart_total'] = $totalCartAmt - $discountAmt;

                        }


                        // $this->session->set_flashdata("Coupon_Succ", "<img src='".base_url()."/assets/emoji/congratulation.png' height='50px' width='50px'>&nbsp;congratulation.!  You get &nbsp;&nbsp;&nbsp;&nbsp; OFF&nbsp;".$oldCartAmt."-".$discountAmt."&nbsp;=&nbsp;".$newCartAmt."&nbsp;<i class='fa fa-rupee'></i>");

                        $this->session->set_flashdata("Coupon_Succ", "Discount:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-" . $discountAmt . "&nbsp;<i class='fa fa-rupee'></i>");

                      } else
                      {
                        // $discountAmt = $totalCartAmt*$couponData['coupn_discount_val']/100;
                        $discountAmt = $filter_pro_rec[0]['final_price'] * $couponData['coupn_discount_val'] / 100;

                        $discountAmt = round($discountAmt);

                        if ($discountAmt > $minimum_discount_value)
                        {

                          $discountAmt = $minimum_discount_value;

                          // $newCartAmt  = $_SESSION['cart_contents']['cart_total']=$totalCartAmt-$discountAmt; 

                        }

                        $userWallet = $this->db->get_where('wallet_master', array('user_master_id' => $u_id))->row_array();

                        if ($userWallet)
                        {
                          $walletAmt = $userWallet['wallet_amount'] + $discountAmt;

                          $updateWalletData = array(
                            'wallet_amount' => $walletAmt,
                            'add_date' => time()
                          );
                          $this->db->where('user_master_id', $u_id);
                          $this->db->update('wallet_master', $updateWalletData);

                          // $this->session->set_flashdata("Coupon_Succ", "<img src='".base_url()."/assets/emoji/congratulation.png' height='50px' width='50px'>&nbsp;congratulation.! You get <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$discountAmt."&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");

                          $this->session->set_flashdata("Coupon_Succ", "Get &nbsp;&nbsp;" . $discountAmt . "&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");

                        } else
                        {
                          $walletAmt = array(
                            'user_master_id' => $u_id,
                            'wallet_amount' => $discountAmt,
                            'status' => '1',
                            'add_date' => time()
                          );
                          $this->db->insert('wallet_master', $walletAmt);

                          $this->session->set_flashdata("Coupon_Succ", "Get &nbsp;&nbsp;" . $discountAmt . "&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");
                        }
                      }

                    }
                    $couponValData = array(
                      'coupon_uses' => $check_user_coupon_use['coupon_uses'] + 1
                    );

                    $this->db->where('id', $check_user_coupon_use['id']);
                    $this->db->update('coupon_validity_master', $couponValData);

                  } else
                  { //user coupon uses condition close

                    if ($coupon_discount_type == 1)
                    { // 1= FLAT Discount, 2= percantage

                      if ($coupon_type == 1)
                      { // 1=  Discountable Amount, 2= cashback

                        $newCartAmt = $_SESSION['cart_contents']['cart_total'] = $totalCartAmt - $couponData['coupn_discount_val'];

                        // $this->session->set_flashdata("Coupon_Succ", "<img src='".base_url()."/assets/emoji/congratulation.png' height='50px' width='50px'>&nbsp;congratulation.!  You get &nbsp;&nbsp;&nbsp;&nbsp; OFF&nbsp;".$oldCartAmt."-".$couponData['coupn_discount_val']."&nbsp;=&nbsp;".$newCartAmt."&nbsp;<i class='fa fa-rupee'></i>");

                        $this->session->set_flashdata("Coupon_Succ", "Discount:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-" . $couponData['coupn_discount_val'] . "&nbsp;<i class='fa fa-rupee'></i>");

                      } else
                      {

                        $userWallet = $this->db->get_where('wallet_master', array('user_master_id' => $u_id))->row_array();

                        if ($userWallet)
                        {
                          $walletAmt = $userWallet['wallet_amount'] + $couponData['coupn_discount_val'];

                          $updateWalletData = array(
                            'wallet_amount' => $walletAmt,
                            'add_date' => time()
                          );
                          $this->db->where('user_master_id', $u_id);
                          $this->db->update('wallet_master', $updateWalletData);

                          // $this->session->set_flashdata("Coupon_Succ", "<img src='".base_url()."/assets/emoji/congratulation.png' height='50px' width='50px'>&nbsp;congratulation.! You get <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$couponData['coupn_discount_val']."&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");

                          $this->session->set_flashdata("Coupon_Succ", "Get &nbsp;&nbsp;" . $couponData['coupn_discount_val'] . "&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");
                        } else
                        {

                          $walletAmt = array(
                            'user_master_id' => $u_id,
                            'wallet_amount' => $couponData['coupn_discount_val'],
                            'status' => '1',
                            'add_date' => time()
                          );

                          $this->db->insert('wallet_master', $walletAmt);

                          // $this->session->set_flashdata("Coupon_Succ", "<img src='".base_url()."/assets/emoji/congratulation.png' height='50px' width='50px'>&nbsp;congratulation.! You get <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$couponData['coupn_discount_val']."&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");
                          $this->session->set_flashdata("Coupon_Succ", "Get &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $couponData['coupn_discount_val'] . "&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");
                        }

                      }

                    } else
                    {

                      if ($coupon_type == 1)
                      { // 1=  Discountable Amount

                        // $discountAmt = $totalCartAmt*$couponData['coupn_discount_val']/100;
                        $discountAmt = $filter_pro_rec[0]['final_price'] * $couponData['coupn_discount_val'] / 100;
                        $discountAmt = round($discountAmt);
                        if ($discountAmt > $minimum_discount_value)
                        {

                          $discountAmt = $minimum_discount_value;

                          $newCartAmt = $_SESSION['cart_contents']['cart_total'] = $totalCartAmt - $discountAmt;

                        } else
                        {

                          $newCartAmt = $_SESSION['cart_contents']['cart_total'] = $totalCartAmt - $discountAmt;

                        }


                        // $this->session->set_flashdata("Coupon_Succ", "<img src='".base_url()."/assets/emoji/congratulation.png' height='50px' width='50px'>&nbsp;congratulation.!  You get &nbsp;&nbsp;&nbsp;&nbsp; OFF&nbsp;".$oldCartAmt."-".$discountAmt."&nbsp;=&nbsp;".$newCartAmt."&nbsp;<i class='fa fa-rupee'></i>");

                        $this->session->set_flashdata("Coupon_Succ", "Discount:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-" . $discountAmt . "&nbsp;<i class='fa fa-rupee'></i>");

                      } else
                      {
                        // $discountAmt = $totalCartAmt*$couponData['coupn_discount_val']/100;
                        $discountAmt = $filter_pro_rec[0]['final_price'] * $couponData['coupn_discount_val'] / 100;
                        $discountAmt = round($discountAmt);
                        if ($discountAmt > $minimum_discount_value)
                        {

                          $discountAmt = $minimum_discount_value;

                        }

                        $userWallet = $this->db->get_where('wallet_master', array('user_master_id' => $u_id))->row_array();

                        if ($userWallet)
                        {
                          $walletAmt = $userWallet['wallet_amount'] + $discountAmt;

                          $updateWalletData = array(
                            'wallet_amount' => $walletAmt,
                            'add_date' => time()
                          );
                          $this->db->where('user_master_id', $u_id);
                          $this->db->update('wallet_master', $updateWalletData);

                          // $this->session->set_flashdata("Coupon_Succ", "<img src='".base_url()."/assets/emoji/congratulation.png' height='50px' width='50px'>&nbsp;congratulation.! You get <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$discountAmt."&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");

                          $this->session->set_flashdata("Coupon_Succ", "Get &nbsp;&nbsp;" . $discountAmt . "&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");

                        } else
                        {
                          $walletAmt = array(
                            'user_master_id' => $u_id,
                            'wallet_amount' => $discountAmt,
                            'status' => '1',
                            'add_date' => time()
                          );
                          $this->db->insert('wallet_master', $walletAmt);

                          // $this->session->set_flashdata("Coupon_Succ", "<img src='".base_url()."/assets/emoji/congratulation.png' height='50px' width='50px'>&nbsp;congratulation.! You get <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$discountAmt."&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");

                          $this->session->set_flashdata("Coupon_Succ", "Get &nbsp;&nbsp;" . $discountAmt . "&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");

                        }
                      }

                    }

                    $couponValData = array(
                      'user_id' => $u_id,
                      'coupon_id' => $coupon_id,
                      'coupon_uses' => 1
                    );
                    $this->db->insert('coupon_validity_master', $couponValData);
                  }
                  // coupon applied successfully msg

                  $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button><img src="' . base_url() . '/assets/emoji/happy.png" height="50px" width="50px">Coupon Applied successfully.</div></div>');
                  redirect('web/checkout_payment/coupon');


                } else
                { //coupon validity condition close

                  $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button><img src="' . base_url() . '/assets/emoji/expire.png" height="50px" width="50px">Opps..Coupon Expired</div></div>');
                  redirect('web/checkout_payment');
                }

              } else
              { //filter product condition close
                $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button><img src="' . base_url() . '/assets/emoji/confuse.png" height="50px" width="50px">You have not taken any product in such price range, for which this coupon is valid</div></div>');
                redirect('web/checkout_payment');
              }

              // }else{  //Customer elegible for coupon or not condition close

              //  $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button><img src="'.base_url().'/assets/emoji/confuse.png" height="50px" width="50px">Sorry, This coupon is not valid for these product.</div></div>'); 
              //    redirect('web/checkout_payment');

              //  }

            } else
            { //cart limit condition close

              $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button><img src="' . base_url() . '/assets/emoji/lowcart_amt.png" height="50px" width="50px">Please limit your cart amount up to ' . $check_cart_amt . '&nbsp;<i class="fa fa-rupee"></i></div></div>');
              redirect('web/checkout_payment');
            }

          }





          //check category type
          else if ($apply_discountOn == '2')
          {

            if ($totalCartAmt > $check_cart_amt)
            {

              $catId = array();
              $proId = array();
              foreach ($cartAllData as $cartData)
              {
                $pro_id = $cartData['id'];
                $proRec = $this->db->get_where('sub_product_master', array('id' => $pro_id))->row_array();

                $catId[] = $proRec['category_id'];
                $proId[] = $pro_id;
              }

              if ($arrayRec = array_intersect($catId, $applyCouponOn))
              {

                $this->db->select('*');
                $this->db->from('sub_product_master');
                $this->db->where_in('category_id', $arrayRec);
                $this->db->where_in('id', $proId);
                // $this->db->where('final_price <',$product_price_range);
                $this->db->where('final_price >', $product_price_range);
                $filter_pro_rec = $this->db->get()->result_array();

                if ($filter_pro_rec)
                {

                  // if($totalCartAmt > $check_cart_amt){

                  $check_coupon = $this->db->select_sum('coupon_uses')
                    ->from('coupon_validity_master')
                    ->where('coupon_id', $coupon_id)
                    ->get();
                  $check_coupon_valdity = $check_coupon->result_array();

                  $coupon_valdity = $check_coupon_valdity[0]['coupon_uses'];

                  if ($coupon_valdity < $coupon_uses_limit)
                  {

                    $this->db->where('user_id', $u_id);

                    $this->db->where('coupon_id', $coupon_id);

                    $check_user_coupon_use = $this->db->get('coupon_validity_master')->row_array();

                    if ($check_user_coupon_use)
                    {

                      if ($coupon_discount_type == 1)
                      { // 1 = FLAT Discount, 2= percantage
                        if ($coupon_type == 1)
                        { // 1=  Discountable Amount, 2= cashback

                          $newCartAmt = $_SESSION['cart_contents']['cart_total'] = $totalCartAmt - $couponData['coupn_discount_val'];

                          // $this->session->set_flashdata("Coupon_Succ", "<img src='".base_url()."/assets/emoji/congratulation.png' height='50px' width='50px'>&nbsp;congratulation.!  You get &nbsp;&nbsp;&nbsp;&nbsp; OFF&nbsp;".$oldCartAmt."-".$couponData['coupn_discount_val']."&nbsp;=&nbsp;".$newCartAmt."&nbsp;<i class='fa fa-rupee'></i>");

                          $this->session->set_flashdata("Coupon_Succ", "Discount:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-" . $couponData['coupn_discount_val'] . "&nbsp;<i class='fa fa-rupee'></i>");

                        } else
                        {

                          $userWallet = $this->db->get_where('wallet_master', array('user_master_id' => $u_id))->row_array();

                          if ($userWallet)
                          {
                            $walletAmt = $userWallet['wallet_amount'] + $couponData['coupn_discount_val'];

                            $updateWalletData = array(
                              'wallet_amount' => $walletAmt,
                              'add_date' => time()
                            );
                            $this->db->where('user_master_id', $u_id);
                            $this->db->update('wallet_master', $updateWalletData);

                            // $this->session->set_flashdata("Coupon_Succ", "<img src='".base_url()."/assets/emoji/congratulation.png' height='50px' width='50px'>&nbsp;congratulation.! You get <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$couponData['coupn_discount_val']."&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");

                            $this->session->set_flashdata("Coupon_Succ", "Get &nbsp;&nbsp;" . $couponData['coupn_discount_val'] . "&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");

                          } else
                          {

                            $walletAmt = array(
                              'user_master_id' => $u_id,
                              'wallet_amount' => $couponData['coupn_discount_val'],
                              'status' => '1',
                              'add_date' => time()
                            );

                            $this->db->insert('wallet_master', $walletAmt);

                            $this->session->set_flashdata("Coupon_Succ", "Get &nbsp;&nbsp;" . $couponData['coupn_discount_val'] . "&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");

                          }

                        }

                      } else
                      {

                        if ($coupon_type == 1)
                        { // 1=  Discountable Amount, 2= cashback

                          $discountAmt = $filter_pro_rec[0]['final_price'] * $couponData['coupn_discount_val'] / 100;

                          $discountAmt = round($discountAmt);

                          if ($discountAmt > $minimum_discount_value)
                          {

                            $discountAmt = $minimum_discount_value;

                            $newCartAmt = $_SESSION['cart_contents']['cart_total'] = $totalCartAmt - $discountAmt;

                          } else
                          {

                            $newCartAmt = $_SESSION['cart_contents']['cart_total'] = $totalCartAmt - $discountAmt;

                          }

                          // $discountAmt = $totalCartAmt*$couponData['coupn_discount_val']/100;

                          // $this->session->set_flashdata("Coupon_Succ", "<img src='".base_url()."/assets/emoji/congratulation.png' height='50px' width='50px'>&nbsp;congratulation.!  You get &nbsp;&nbsp;&nbsp;&nbsp; OFF&nbsp;".$oldCartAmt."-".$discountAmt."&nbsp;=&nbsp;".$newCartAmt."&nbsp;<i class='fa fa-rupee'></i>");


                          $this->session->set_flashdata("Coupon_Succ", "<b>Discount:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-" . $discountAmt . "&nbsp;<i class='fa fa-rupee'></i>");

                        } else
                        {

                          $discountAmt = $filter_pro_rec[0]['final_price'] * $couponData['coupn_discount_val'] / 100;
                          $discountAmt = round($discountAmt);
                          if ($discountAmt > $minimum_discount_value)
                          {

                            $discountAmt = $minimum_discount_value;

                          }

                          // $discountAmt = $totalCartAmt*$couponData['coupn_discount_val']/100;
                          $userWallet = $this->db->get_where('wallet_master', array('user_master_id' => $u_id))->row_array();

                          if ($userWallet)
                          {
                            // $walletAmt = $userWallet['wallet_amount']+$couponData['coupn_discount_val'];
                            $walletAmt = $userWallet['wallet_amount'] + $discountAmt;

                            $updateWalletData = array(
                              'wallet_amount' => $walletAmt,
                              'add_date' => time()
                            );
                            $this->db->where('user_master_id', $u_id);
                            $this->db->update('wallet_master', $updateWalletData);


                            $this->session->set_flashdata("Coupon_Succ", "Get &nbsp;&nbsp;" . $discountAmt . "&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");
                          } else
                          {
                            $walletAmt = array(
                              'user_master_id' => $u_id,
                              'wallet_amount' => $discountAmt,
                              'status' => '1',
                              'add_date' => time()
                            );
                            $this->db->insert('wallet_master', $walletAmt);

                            // $this->session->set_flashdata("Coupon_Succ", "<img src='".base_url()."/assets/emoji/congratulation.png' height='50px' width='50px'>&nbsp;congratulation.! You get <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$discountAmt."&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");

                            $this->session->set_flashdata("Coupon_Succ", "Get &nbsp;&nbsp;" . $discountAmt . "&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");

                          }
                        }
                      }

                      $couponValData = array(
                        'coupon_uses' => $check_user_coupon_use['coupon_uses'] + 1
                      );

                      $this->db->where('id', $check_user_coupon_use['id']);
                      $this->db->update('coupon_validity_master', $couponValData);


                    } else
                    { //user coupon uses condition close

                      if ($coupon_discount_type == 1)
                      { // 1 = FLAT Discount, 2= percantage

                        if ($coupon_type == 1)
                        { // 1=  Discountable Amount, 2= cashback

                          $newCartAmt = $_SESSION['cart_contents']['cart_total'] = $totalCartAmt - $couponData['coupn_discount_val'];

                          // $this->session->set_flashdata("Coupon_Succ", "<img src='".base_url()."/assets/emoji/congratulation.png' height='50px' width='50px'>&nbsp;congratulation.!  You get &nbsp;&nbsp;&nbsp;&nbsp; OFF&nbsp;".$oldCartAmt."-".$couponData['coupn_discount_val']."&nbsp;=&nbsp;".$newCartAmt."&nbsp;<i class='fa fa-rupee'></i>");

                          $this->session->set_flashdata("Coupon_Succ", "Discount:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-" . $couponData['coupn_discount_val'] . "&nbsp;<i class='fa fa-rupee'></i>");

                        } else
                        {

                          $userWallet = $this->db->get_where('wallet_master', array('user_master_id' => $u_id))->row_array();

                          if ($userWallet)
                          {
                            $walletAmt = $userWallet['wallet_amount'] + $couponData['coupn_discount_val'];

                            $updateWalletData = array(
                              'wallet_amount' => $walletAmt,
                              'add_date' => time()
                            );
                            $this->db->where('user_master_id', $u_id);
                            $this->db->update('wallet_master', $updateWalletData);

                            // $this->session->set_flashdata("Coupon_Succ", "<img src='".base_url()."/assets/emoji/congratulation.png' height='50px' width='50px'>&nbsp;congratulation.! You get <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$couponData['coupn_discount_val']."&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");

                            $this->session->set_flashdata("Coupon_Succ", "Get &nbsp;&nbsp;" . $couponData['coupn_discount_val'] . "&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");
                          } else
                          {

                            $walletAmt = array(
                              'user_master_id' => $u_id,
                              'wallet_amount' => $couponData['coupn_discount_val'],
                              'status' => '1',
                              'add_date' => time()
                            );

                            $this->db->insert('wallet_master', $walletAmt);

                            // $this->session->set_flashdata("Coupon_Succ", "<img src='".base_url()."/assets/emoji/congratulation.png' height='50px' width='50px'>&nbsp;congratulation.! You get <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$couponData['coupn_discount_val']."&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");

                            $this->session->set_flashdata("Coupon_Succ", "Get &nbsp;&nbsp;" . $couponData['coupn_discount_val'] . "&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");
                          }

                        }

                      } else
                      {

                        if ($coupon_type == 1)
                        { // 1=  Discountable Amount, 2= cashback

                          // $discountAmt = $totalCartAmt*$couponData['coupn_discount_val']/100;
                          $discountAmt = $filter_pro_rec[0]['final_price'] * $couponData['coupn_discount_val'] / 100;
                          $discountAmt = round($discountAmt);
                          if ($discountAmt > $minimum_discount_value)
                          {

                            $discountAmt = $minimum_discount_value;

                            $newCartAmt = $_SESSION['cart_contents']['cart_total'] = $totalCartAmt - $discountAmt;

                          } else
                          {

                            $newCartAmt = $_SESSION['cart_contents']['cart_total'] = $totalCartAmt - $discountAmt;

                          }


                          // $this->session->set_flashdata("Coupon_Succ", "<img src='".base_url()."/assets/emoji/congratulation.png' height='50px' width='50px'>&nbsp;congratulation.!  You get &nbsp;&nbsp;&nbsp;&nbsp; OFF&nbsp;".$oldCartAmt."-".$discountAmt."&nbsp;=&nbsp;".$newCartAmt."&nbsp;<i class='fa fa-rupee'></i>");

                          // $this->session->set_flashdata("Coupon_Succ", "<b>Discount:</b>&nbsp;&nbsp;&nbsp;&nbsp;-".$discountAmt."&nbsp;<i class='fa fa-rupee'></i>");

                          $this->session->set_flashdata("Coupon_Succ", "Discount:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-" . $discountAmt . "&nbsp;<i class='fa fa-rupee'></i>");


                        } else
                        {
                          // $discountAmt = $totalCartAmt*$couponData['coupn_discount_val']/100;
                          $discountAmt = $filter_pro_rec[0]['final_price'] * $couponData['coupn_discount_val'] / 100;
                          $discountAmt = round($discountAmt);
                          if ($discountAmt > $minimum_discount_value)
                          {

                            $discountAmt = $minimum_discount_value;

                          }
                          $userWallet = $this->db->get_where('wallet_master', array('user_master_id' => $u_id))->row_array();

                          if ($userWallet)
                          {
                            // $walletAmt = $userWallet['wallet_amount']+$couponData['coupn_discount_val'];
                            $walletAmt = $userWallet['wallet_amount'] + $discountAmt;

                            $updateWalletData = array(
                              'wallet_amount' => $walletAmt,
                              'add_date' => time()
                            );
                            $this->db->where('user_master_id', $u_id);
                            $this->db->update('wallet_master', $updateWalletData);

                            // $this->session->set_flashdata("Coupon_Succ", "<img src='".base_url()."/assets/emoji/congratulation.png' height='50px' width='50px'>&nbsp;congratulation.! You get <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$discountAmt."&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");

                            $this->session->set_flashdata("Coupon_Succ", "Get &nbsp;&nbsp;" . $discountAmt . "&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");
                          } else
                          {
                            $walletAmt = array(
                              'user_master_id' => $u_id,
                              'wallet_amount' => $discountAmt,
                              'status' => '1',
                              'add_date' => time()
                            );
                            $this->db->insert('wallet_master', $walletAmt);

                            // $this->session->set_flashdata("Coupon_Succ", "<img src='".base_url()."/assets/emoji/congratulation.png' height='50px' width='50px'>&nbsp;congratulation.! You get <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$discountAmt."&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");

                            $this->session->set_flashdata("Coupon_Succ", "Get &nbsp;&nbsp;" . $discountAmt . "&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");

                          }
                        }
                      }

                      $couponValData = array(
                        'user_id' => $u_id,
                        'coupon_id' => $coupon_id,
                        'coupon_uses' => 1
                      );
                      $this->db->insert('coupon_validity_master', $couponValData);
                    }
                    // coupon applied successfully msg

                    $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button><img src="' . base_url() . '/assets/emoji/happy.png" height="50px" width="50px">Coupon Applied successfully.</div></div>');
                    // $coupon_succ = $coupon_id;
                    redirect('web/checkout_payment/coupon');

                  } else
                  { //coupon validity condition close

                    $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button><img src="' . base_url() . '/assets/emoji/expire.png" height="50px" width="50px">Opps..Coupon Expired</div></div>');
                    redirect('web/checkout_payment');
                  }

                } else
                { //filter product condition close
                  $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button><img src="' . base_url() . '/assets/emoji/confuse.png" height="50px" width="50px">You have not taken any product in such price range, for which this coupon is valid</div></div>');
                  redirect('web/checkout_payment');
                }

              } else
              { //category exist or not condition close

                $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button><img src="' . base_url() . '/assets/emoji/confuse.png" height="50px" width="50px">Coupon Not applicable for this type category.</div></div>');
                redirect('web/checkout_payment');

              }

            } else
            { //cart limit condition close

              $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button><img src="' . base_url() . '/assets/emoji/lowcart_amt.png" height="50px" width="50px">Please limit your cart amount up to ' . $check_cart_amt . '&nbsp;<i class="fa fa-rupee"></i></div></div>');
              redirect('web/checkout_payment');
            }

          } // apply discount on category condition close





          // apply discount on sub category
          else if ($apply_discountOn == '3')
          {

            if ($totalCartAmt > $check_cart_amt)
            {
              $userData = $this->session->userdata('User');

              // Wishlist count
              $data['wishlist_count'] = !empty($userData) ? $this->web_model->get_total_wishlist_by_user($userData['id']) : 0;
              $subCatId = array();
              $proId = array();
              foreach ($cartAllData as $cartData)
              {
                $pro_id = $cartData['id'];
                $proRec = $this->db->get_where('sub_product_master', array('id' => $pro_id))->row_array();

                $subCatId[] = $proRec['sub_category_id'];
                $proId[] = $pro_id;
              }

              if ($arrayRec = array_intersect($subCatId, $applyCouponOn))
              {

                $this->db->select('*');
                $this->db->from('sub_product_master');
                $this->db->where_in('sub_category_id', $arrayRec);
                $this->db->where_in('id', $proId);
                // $this->db->where('final_price <',$product_price_range);
                $this->db->where('final_price >', $product_price_range);
                $filter_pro_rec = $this->db->get()->result_array();

                if ($filter_pro_rec)
                {
                  // if($totalCartAmt > $check_cart_amt){

                  $check_coupon = $this->db->select_sum('coupon_uses')
                    ->from('coupon_validity_master')
                    ->where('coupon_id', $coupon_id)
                    ->get();
                  $check_coupon_valdity = $check_coupon->result_array();

                  $coupon_valdity = $check_coupon_valdity[0]['coupon_uses'];

                  if ($coupon_valdity < $coupon_uses_limit)
                  {

                    $this->db->where('user_id', $u_id);

                    $this->db->where('coupon_id', $coupon_id);

                    $check_user_coupon_use = $this->db->get('coupon_validity_master')->row_array();

                    if ($check_user_coupon_use)
                    {

                      if ($coupon_discount_type == 1)
                      { // 1 = FLAT Discount,  2= percantage


                        if ($coupon_type == 1)
                        { // 1=  Discountable Amount, 2= cashback

                          $newCartAmt = $_SESSION['cart_contents']['cart_total'] = $totalCartAmt - $couponData['coupn_discount_val'];

                          $this->session->set_flashdata("Coupon_Succ", "Discount:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-" . $couponData['coupn_discount_val'] . "&nbsp;<i class='fa fa-rupee'></i>");

                        } else
                        {

                          $userWallet = $this->db->get_where('wallet_master', array('user_master_id' => $u_id))->row_array();

                          if ($userWallet)
                          {
                            $walletAmt = $userWallet['wallet_amount'] + $couponData['coupn_discount_val'];

                            $updateWalletData = array(
                              'wallet_amount' => $walletAmt,
                              'add_date' => time()
                            );
                            $this->db->where('user_master_id', $u_id);
                            $this->db->update('wallet_master', $updateWalletData);

                            $this->session->set_flashdata("Coupon_Succ", "Get &nbsp;&nbsp;" . $couponData['coupn_discount_val'] . "&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");

                          } else
                          {

                            $walletAmt = array(
                              'user_master_id' => $u_id,
                              'wallet_amount' => $couponData['coupn_discount_val'],
                              'status' => '1',
                              'add_date' => time()
                            );

                            $this->db->insert('wallet_master', $walletAmt);

                            $this->session->set_flashdata("Coupon_Succ", "Get &nbsp;&nbsp;" . $couponData['coupn_discount_val'] . "&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");
                          }
                        }

                      } else
                      {

                        if ($coupon_type == 1)
                        { // 1=  Discountable Amount, 2= cashback

                          // $discountAmt = $totalCartAmt*$couponData['coupn_discount_val']/100;
                          $discountAmt = $filter_pro_rec[0]['final_price'] * $couponData['coupn_discount_val'] / 100;
                          $discountAmt = round($discountAmt);
                          if ($discountAmt > $minimum_discount_value)
                          {

                            $discountAmt = $minimum_discount_value;

                            $newCartAmt = $_SESSION['cart_contents']['cart_total'] = $totalCartAmt - $discountAmt;

                          } else
                          {

                            $newCartAmt = $_SESSION['cart_contents']['cart_total'] = $totalCartAmt - $discountAmt;

                          }

                          $this->session->set_flashdata("Coupon_Succ", "Discount:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-" . $discountAmt . "&nbsp;<i class='fa fa-rupee'></i>");

                        } else
                        {
                          // $discountAmt = $totalCartAmt*$couponData['coupn_discount_val']/100;
                          $discountAmt = $filter_pro_rec[0]['final_price'] * $couponData['coupn_discount_val'] / 100;
                          $discountAmt = round($discountAmt);
                          if ($discountAmt > $minimum_discount_value)
                          {

                            $discountAmt = $minimum_discount_value;

                          }

                          $userWallet = $this->db->get_where('wallet_master', array('user_master_id' => $u_id))->row_array();

                          if ($userWallet)
                          {
                            $walletAmt = $userWallet['wallet_amount'] + $discountAmt;
                            // $walletAmt = $userWallet['wallet_amount']+$couponData['coupn_discount_val'];

                            $updateWalletData = array(
                              'wallet_amount' => $walletAmt,
                              'add_date' => time()
                            );
                            $this->db->where('user_master_id', $u_id);
                            $this->db->update('wallet_master', $updateWalletData);

                            $this->session->set_flashdata("Coupon_Succ", "Get &nbsp;&nbsp;" . $discountAmt . "&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");

                          } else
                          {
                            $walletAmt = array(
                              'user_master_id' => $u_id,
                              'wallet_amount' => $discountAmt,
                              'status' => '1',
                              'add_date' => time()
                            );
                            $this->db->insert('wallet_master', $walletAmt);

                            $this->session->set_flashdata("Coupon_Succ", "Get &nbsp;&nbsp;" . $discountAmt . "&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");
                          }
                        }
                      }

                      $couponValData = array(
                        'coupon_uses' => $check_user_coupon_use['coupon_uses'] + 1
                      );

                      $this->db->where('id', $check_user_coupon_use['id']);
                      $this->db->update('coupon_validity_master', $couponValData);

                    } else
                    { //user coupon uses condition close

                      if ($coupon_discount_type == 1)
                      { // 1 = FLAT Discount, 2= percentage

                        if ($coupon_type == 1)
                        { // 1=  Discountable Amount, 2= cashback

                          $newCartAmt = $_SESSION['cart_contents']['cart_total'] = $totalCartAmt - $couponData['coupn_discount_val'];

                          $this->session->set_flashdata("Coupon_Succ", "Discount:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-" . $couponData['coupn_discount_val'] . "&nbsp;<i class='fa fa-rupee'></i>");
                        } else
                        {

                          $userWallet = $this->db->get_where('wallet_master', array('user_master_id' => $u_id))->row_array();

                          if ($userWallet)
                          {
                            $walletAmt = $userWallet['wallet_amount'] + $couponData['coupn_discount_val'];

                            $updateWalletData = array(
                              'wallet_amount' => $walletAmt,
                              'add_date' => time()
                            );
                            $this->db->where('user_master_id', $u_id);
                            $this->db->update('wallet_master', $updateWalletData);

                            // $this->session->set_flashdata("Coupon_Succ", "<img src='".base_url()."/assets/emoji/congratulation.png' height='50px' width='50px'>&nbsp;congratulation.! You get <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$couponData['coupn_discount_val']."&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");

                            $this->session->set_flashdata("Coupon_Succ", "Get &nbsp;&nbsp;" . $couponData['coupn_discount_val'] . "&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");

                          } else
                          {

                            $walletAmt = array(
                              'user_master_id' => $u_id,
                              'wallet_amount' => $couponData['coupn_discount_val'],
                              'status' => '1',
                              'add_date' => time()
                            );

                            $this->db->insert('wallet_master', $walletAmt);

                            // $this->session->set_flashdata("Coupon_Succ", "<img src='".base_url()."/assets/emoji/congratulation.png' height='50px' width='50px'>&nbsp;congratulation.! You get <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$couponData['coupn_discount_val']."&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");

                            $this->session->set_flashdata("Coupon_Succ", "Get &nbsp;&nbsp;" . $couponData['coupn_discount_val'] . "&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");
                          }
                        }

                      } else
                      {

                        if ($coupon_type == 1)
                        { // 1=  Discountable Amount, 2= cashback

                          $discountAmt = $filter_pro_rec[0]['final_price'] * $couponData['coupn_discount_val'] / 100;
                          $discountAmt = round($discountAmt);
                          if ($discountAmt > $minimum_discount_value)
                          {

                            $discountAmt = $minimum_discount_value;

                            $newCartAmt = $_SESSION['cart_contents']['cart_total'] = $totalCartAmt - $discountAmt;

                          } else
                          {

                            $newCartAmt = $_SESSION['cart_contents']['cart_total'] = $totalCartAmt - $discountAmt;

                          }

                          // $discountAmt = $totalCartAmt*$couponData['coupn_discount_val']/100;

                          // $this->session->set_flashdata("Coupon_Succ", "<img src='".base_url()."/assets/emoji/congratulation.png' height='50px' width='50px'>&nbsp;congratulation.!  You get &nbsp;&nbsp;&nbsp;&nbsp; OFF&nbsp;".$oldCartAmt."-".$discountAmt."&nbsp;=&nbsp;".$newCartAmt."&nbsp;<i class='fa fa-rupee'></i>");

                          $this->session->set_flashdata("Coupon_Succ", "Discount:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-" . $discountAmt . "&nbsp;<i class='fa fa-rupee'></i>");

                        } else
                        {
                          $discountAmt = $filter_pro_rec[0]['final_price'] * $couponData['coupn_discount_val'] / 100;
                          $discountAmt = round($discountAmt);
                          if ($discountAmt > $minimum_discount_value)
                          {

                            $discountAmt = $minimum_discount_value;

                          }
                          // $discountAmt = $totalCartAmt*$couponData['coupn_discount_val']/100;
                          $userWallet = $this->db->get_where('wallet_master', array('user_master_id' => $u_id))->row_array();

                          if ($userWallet)
                          {
                            $walletAmt = $userWallet['wallet_amount'] + $discountAmt;

                            $updateWalletData = array(
                              'wallet_amount' => $walletAmt,
                              'add_date' => time()
                            );
                            $this->db->where('user_master_id', $u_id);
                            $this->db->update('wallet_master', $updateWalletData);

                            $this->session->set_flashdata("Coupon_Succ", "Get &nbsp;&nbsp;" . $discountAmt . "&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");

                          } else
                          {
                            $walletAmt = array(
                              'user_master_id' => $u_id,
                              'wallet_amount' => $discountAmt,
                              'status' => '1',
                              'add_date' => time()
                            );
                            $this->db->insert('wallet_master', $walletAmt);

                            $this->session->set_flashdata("Coupon_Succ", "Get &nbsp;&nbsp;" . $discountAmt . "&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");
                          }
                        }

                      }
                      $couponValData = array(
                        'user_id' => $u_id,
                        'coupon_id' => $coupon_id,
                        'coupon_uses' => 1
                      );
                      $this->db->insert('coupon_validity_master', $couponValData);
                    }
                    // coupon applied successfully msg

                    $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button><img src="' . base_url() . '/assets/emoji/happy.png" height="50px" width="50px">Coupon Applied successfully.</div></div>');
                    $coupon_succ = $coupon_id;
                    redirect('web/checkout_payment/coupon/' . $coupon_succ);

                  } else
                  { //coupon validity condition close

                    $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button><img src="' . base_url() . '/assets/emoji/expire.png" height="50px" width="50px">Opps..Coupon Expired</div></div>');
                    redirect('web/checkout_payment');
                  }

                } else
                { //filter product condition close
                  $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button><img src="' . base_url() . '/assets/emoji/confuse.png" height="50px" width="50px">You have not taken any product in such price range, for which this coupon is valid</div></div>');
                  redirect('web/checkout_payment');
                }

              } else
              { //category exist or not condition close

                $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button><img src="' . base_url() . '/assets/emoji/confuse.png" height="50px" width="50px">Coupon Not applicable for this type sub category.</div></div>');
                redirect('web/checkout_payment');

              }

            } else
            { //cart limit condition close

              $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button><img src="' . base_url() . '/assets/emoji/lowcart_amt.png" height="50px" width="50px">Please limit your cart amount up to ' . $check_cart_amt . '&nbsp;<i class="fa fa-rupee"></i></div></div>');
              redirect('web/checkout_payment');
            }

          } // apply discount on sub category close





          // apply discount for Customer
          else if ($apply_discountOn == '4')
          {

            if ($totalCartAmt > $check_cart_amt)
            {

              $proId = array();
              foreach ($cartAllData as $cartData)
              {
                $proId[] = $cartData['id'];

              }

              if ($arrayRec = in_array($u_id, $applyCouponOn))
              {

                $this->db->select('*');
                $this->db->from('sub_product_master');
                $this->db->where_in('id', $proId);
                // $this->db->where('final_price <',$product_price_range);
                $this->db->where('final_price >', $product_price_range);
                $filter_pro_rec = $this->db->get()->result_array();

                if ($filter_pro_rec)
                {

                  $check_coupon = $this->db->select_sum('coupon_uses')
                    ->from('coupon_validity_master')
                    ->where('coupon_id', $coupon_id)
                    ->get();
                  $check_coupon_valdity = $check_coupon->result_array();

                  $coupon_valdity = $check_coupon_valdity[0]['coupon_uses'];

                  if ($coupon_valdity < $coupon_uses_limit)
                  {

                    $this->db->where('user_id', $u_id);

                    $this->db->where('coupon_id', $coupon_id);

                    $check_user_coupon_use = $this->db->get('coupon_validity_master')->row_array();

                    if ($check_user_coupon_use)
                    {

                      if ($coupon_discount_type == 1)
                      { // 1= FLAT Discount, 2= Percantage

                        if ($coupon_type == 1)
                        { // 1=  Discountable Amount, 2= cashback

                          // $_SESSION['cart_contents']['cart_total']=$totalCartAmt-$couponData['coupn_discount_val'];

                          $newCartAmt = $_SESSION['cart_contents']['cart_total'] = $totalCartAmt - $couponData['coupn_discount_val'];

                          $this->session->set_flashdata("Coupon_Succ", "Discount:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-" . $couponData['coupn_discount_val'] . "&nbsp;<i class='fa fa-rupee'></i>");

                        } else
                        {

                          $userWallet = $this->db->get_where('wallet_master', array('user_master_id' => $u_id))->row_array();

                          if ($userWallet)
                          {
                            $walletAmt = $userWallet['wallet_amount'] + $couponData['coupn_discount_val'];

                            $updateWalletData = array(
                              'wallet_amount' => $walletAmt,
                              'add_date' => time()
                            );
                            $this->db->where('user_master_id', $u_id);
                            $this->db->update('wallet_master', $updateWalletData);

                            $this->session->set_flashdata("Coupon_Succ", "Get &nbsp;&nbsp;" . $couponData['coupn_discount_val'] . "&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");

                          } else
                          {

                            $walletAmt = array(
                              'user_master_id' => $u_id,
                              'wallet_amount' => $couponData['coupn_discount_val'],
                              'status' => '1',
                              'add_date' => time()
                            );

                            $this->db->insert('wallet_master', $walletAmt);

                            $this->session->set_flashdata("Coupon_Succ", "Get &nbsp;&nbsp;" . $couponData['coupn_discount_val'] . "&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");
                          }
                        }

                      } else
                      {

                        if ($coupon_type == 1)
                        { // 1=  Discountable Amount, 2= cashback

                          // $discountAmt = $totalCartAmt*$couponData['coupn_discount_val']/100;
                          $discountAmt = $filter_pro_rec[0]['final_price'] * $couponData['coupn_discount_val'] / 100;
                          $discountAmt = round($discountAmt);
                          if ($discountAmt > $minimum_discount_value)
                          {

                            $discountAmt = $minimum_discount_value;

                            $newCartAmt = $_SESSION['cart_contents']['cart_total'] = $totalCartAmt - $discountAmt;

                          } else
                          {

                            $newCartAmt = $_SESSION['cart_contents']['cart_total'] = $totalCartAmt - $discountAmt;

                          }

                          $this->session->set_flashdata("Coupon_Succ", "Discount:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-" . $discountAmt . "&nbsp;<i class='fa fa-rupee'></i>");

                        } else
                        {
                          // $discountAmt = $totalCartAmt*$couponData['coupn_discount_val']/100;
                          $discountAmt = $filter_pro_rec[0]['final_price'] * $couponData['coupn_discount_val'] / 100;
                          $discountAmt = round($discountAmt);
                          if ($discountAmt > $minimum_discount_value)
                          {

                            $discountAmt = $minimum_discount_value;

                          }
                          $userWallet = $this->db->get_where('wallet_master', array('user_master_id' => $u_id))->row_array();

                          if ($userWallet)
                          {
                            $walletAmt = $userWallet['wallet_amount'] + $discountAmt;

                            $updateWalletData = array(
                              'wallet_amount' => $walletAmt,
                              'add_date' => time()
                            );
                            $this->db->where('user_master_id', $u_id);
                            $this->db->update('wallet_master', $updateWalletData);

                            $this->session->set_flashdata("Coupon_Succ", "Get &nbsp;&nbsp;" . $discountAmt . "&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");

                          } else
                          {
                            $walletAmt = array(
                              'user_master_id' => $u_id,
                              'wallet_amount' => $discountAmt,
                              'status' => '1',
                              'add_date' => time()
                            );
                            $this->db->insert('wallet_master', $walletAmt);

                            $this->session->set_flashdata("Coupon_Succ", "Get &nbsp;&nbsp;" . $discountAmt . "&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");
                          }
                        }
                      }

                      $couponValData = array(
                        'coupon_uses' => $check_user_coupon_use['coupon_uses'] + 1
                      );

                      $this->db->where('id', $check_user_coupon_use['id']);
                      $this->db->update('coupon_validity_master', $couponValData);

                    } else
                    { //user coupon uses condition close

                      if ($coupon_discount_type == 1)
                      { // 1= FLAT Discount, 2= Percentage

                        if ($coupon_type == 1)
                        { // 1=  Discountable Amount, 2= cashback

                          $newCartAmt = $_SESSION['cart_contents']['cart_total'] = $totalCartAmt - $couponData['coupn_discount_val'];

                          $this->session->set_flashdata("Coupon_Succ", "Discount:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-" . $couponData['coupn_discount_val'] . "&nbsp;<i class='fa fa-rupee'></i>");
                        } else
                        {

                          $userWallet = $this->db->get_where('wallet_master', array('user_master_id' => $u_id))->row_array();

                          if ($userWallet)
                          {
                            $walletAmt = $userWallet['wallet_amount'] + $couponData['coupn_discount_val'];

                            $updateWalletData = array(
                              'wallet_amount' => $walletAmt,
                              'add_date' => time()
                            );
                            $this->db->where('user_master_id', $u_id);
                            $this->db->update('wallet_master', $updateWalletData);

                            // $this->session->set_flashdata("Coupon_Succ", "<img src='".base_url()."/assets/emoji/congratulation.png' height='50px' width='50px'>&nbsp;congratulation.! You get <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$couponData['coupn_discount_val']."&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");

                            $this->session->set_flashdata("Coupon_Succ", "Get &nbsp;&nbsp;" . $couponData['coupn_discount_val'] . "&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");

                          } else
                          {

                            $walletAmt = array(
                              'user_master_id' => $u_id,
                              'wallet_amount' => $couponData['coupn_discount_val'],
                              'status' => '1',
                              'add_date' => time()
                            );

                            $this->db->insert('wallet_master', $walletAmt);

                            $this->session->set_flashdata("Coupon_Succ", "Get &nbsp;&nbsp;" . $couponData['coupn_discount_val'] . "&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");
                          }
                        }

                      } else
                      {

                        if ($coupon_type == 1)
                        { // 1=  Discountable Amount, 2= cashback

                          $discountAmt = $filter_pro_rec[0]['final_price'] * $couponData['coupn_discount_val'] / 100;
                          $discountAmt = round($discountAmt);
                          if ($discountAmt > $minimum_discount_value)
                          {

                            $discountAmt = $minimum_discount_value;

                            $newCartAmt = $_SESSION['cart_contents']['cart_total'] = $totalCartAmt - $discountAmt;

                          } else
                          {

                            $newCartAmt = $_SESSION['cart_contents']['cart_total'] = $totalCartAmt - $discountAmt;

                          }

                          // $discountAmt = $totalCartAmt*$couponData['coupn_discount_val']/100;


                          $this->session->set_flashdata("Coupon_Succ", "Discount:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-" . $discountAmt . "&nbsp;<i class='fa fa-rupee'></i>");

                        } else
                        {
                          // $discountAmt = $totalCartAmt*$couponData['coupn_discount_val']/100;
                          $discountAmt = $filter_pro_rec[0]['final_price'] * $couponData['coupn_discount_val'] / 100;
                          $discountAmt = round($discountAmt);
                          if ($discountAmt > $minimum_discount_value)
                          {

                            $discountAmt = $minimum_discount_value;

                          }
                          $userWallet = $this->db->get_where('wallet_master', array('user_master_id' => $u_id))->row_array();

                          if ($userWallet)
                          {
                            $walletAmt = $userWallet['wallet_amount'] + $discountAmt;

                            $updateWalletData = array(
                              'wallet_amount' => $walletAmt,
                              'add_date' => time()
                            );
                            $this->db->where('user_master_id', $u_id);
                            $this->db->update('wallet_master', $updateWalletData);

                            $this->session->set_flashdata("Coupon_Succ", "Get &nbsp;&nbsp;" . $discountAmt . "&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");

                          } else
                          {
                            $walletAmt = array(
                              'user_master_id' => $u_id,
                              'wallet_amount' => $discountAmt,
                              'status' => '1',
                              'add_date' => time()
                            );
                            $this->db->insert('wallet_master', $walletAmt);

                            $this->session->set_flashdata("Coupon_Succ", "Get &nbsp;&nbsp;" . $discountAmt . "&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");
                          }
                        }
                      }
                      $couponValData = array(
                        'user_id' => $u_id,
                        'coupon_id' => $coupon_id,
                        'coupon_uses' => 1
                      );
                      $this->db->insert('coupon_validity_master', $couponValData);
                    }
                    // coupon applied successfully msg

                    $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button><img src="' . base_url() . '/assets/emoji/happy.png" height="50px" width="50px">Coupon Applied successfully.</div></div>');
                    // $coupon_succ = $coupon_id;
                    redirect('web/checkout_payment/coupon');

                  } else
                  { //coupon validity condition close

                    $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button><img src="' . base_url() . '/assets/emoji/expire.png" height="50px" width="50px">Opps..Coupon Expired</div></div>');
                    redirect('web/checkout_payment');
                  }

                } else
                { //filter product condition close
                  $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button><img src="' . base_url() . '/assets/emoji/confuse.png" height="50px" width="50px">You have not taken any product in such price range, for which this coupon is valid</div></div>');
                  redirect('web/checkout_payment');
                }

              } else
              { //Customer elegible for coupon or not condition close

                $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button><img src="' . base_url() . '/assets/emoji/confuse.png" height="50px" width="50px">Sorry, This coupon is for membership users only.</div></div>');
                redirect('web/checkout_payment');

              }

            } else
            { //cart limit condition close

              $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button><img src="' . base_url() . '/assets/emoji/lowcart_amt.png" height="50px" width="50px">Please limit your cart amount up to ' . $check_cart_amt . '&nbsp;<i class="fa fa-rupee"></i></div></div>');
              redirect('web/checkout_payment');
            }

          }


          //apply discount for Product
          else if ($apply_discountOn == '5')
          {

            if ($totalCartAmt > $check_cart_amt)
            {

              $proId = array();
              foreach ($cartAllData as $cartData)
              {
                $proId[] = $cartData['id'];

              }

              if ($arrayRec = array_intersect($proId, $applyCouponOn))
              {

                $this->db->select('*');
                $this->db->from('sub_product_master');
                $this->db->where_in('id', $proId);
                // $this->db->where('final_price <',$product_price_range);
                $this->db->where('final_price >', $product_price_range);
                $filter_pro_rec = $this->db->get()->result_array();

                if ($filter_pro_rec)
                {

                  $check_coupon = $this->db->select_sum('coupon_uses')
                    ->from('coupon_validity_master')
                    ->where('coupon_id', $coupon_id)
                    ->get();
                  $check_coupon_valdity = $check_coupon->result_array();

                  $coupon_valdity = $check_coupon_valdity[0]['coupon_uses'];

                  if ($coupon_valdity < $coupon_uses_limit)
                  {

                    $this->db->where('user_id', $u_id);

                    $this->db->where('coupon_id', $coupon_id);

                    $check_user_coupon_use = $this->db->get('coupon_validity_master')->row_array();

                    if ($check_user_coupon_use)
                    {

                      if ($coupon_discount_type == 1)
                      { // 1= FLAT discount, 2= percantage discount 

                        if ($coupon_type == 1)
                        { // 1=  Discountable Amount, 2= cashback

                          $newCartAmt = $_SESSION['cart_contents']['cart_total'] = $totalCartAmt - $couponData['coupn_discount_val'];

                          // $this->session->set_flashdata("Coupon_Succ", "<img src='".base_url()."/assets/emoji/congratulation.png' height='50px' width='50px'>&nbsp;congratulation.!  You get &nbsp;&nbsp;&nbsp;&nbsp; OFF&nbsp;".$oldCartAmt."-".$couponData['coupn_discount_val']."&nbsp;=&nbsp;".$newCartAmt."&nbsp;<i class='fa fa-rupee'></i>");

                          $this->session->set_flashdata("Coupon_Succ", "Discount:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-" . $couponData['coupn_discount_val'] . "&nbsp;<i class='fa fa-rupee'></i>");
                        } else
                        {

                          $userWallet = $this->db->get_where('wallet_master', array('user_master_id' => $u_id))->row_array();

                          if ($userWallet)
                          {
                            $walletAmt = $userWallet['wallet_amount'] + $couponData['coupn_discount_val'];

                            $updateWalletData = array(
                              'wallet_amount' => $walletAmt,
                              'add_date' => time()
                            );
                            $this->db->where('user_master_id', $u_id);
                            $this->db->update('wallet_master', $updateWalletData);

                            $this->session->set_flashdata("Coupon_Succ", "Get &nbsp;&nbsp;" . $couponData['coupn_discount_val'] . "&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");

                          } else
                          {

                            $walletAmt = array(
                              'user_master_id' => $u_id,
                              'wallet_amount' => $couponData['coupn_discount_val'],
                              'status' => '1',
                              'add_date' => time()
                            );

                            $this->db->insert('wallet_master', $walletAmt);

                            $this->session->set_flashdata("Coupon_Succ", "Get &nbsp;&nbsp;" . $couponData['coupn_discount_val'] . "&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");
                          }
                        }

                      } else
                      {

                        if ($coupon_type == 1)
                        { // 1=  Discountable Amount, 2= cashback

                          // $discountAmt = $totalCartAmt*$couponData['coupn_discount_val']/100;
                          $discountAmt = $filter_pro_rec[0]['final_price'] * $couponData['coupn_discount_val'] / 100;
                          $discountAmt = round($discountAmt);
                          if ($discountAmt > $minimum_discount_value)
                          {

                            $discountAmt = $minimum_discount_value;

                            $newCartAmt = $_SESSION['cart_contents']['cart_total'] = $totalCartAmt - $discountAmt;

                          } else
                          {

                            $newCartAmt = $_SESSION['cart_contents']['cart_total'] = $totalCartAmt - $discountAmt;

                          }


                          $this->session->set_flashdata("Coupon_Succ", "Discount:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-" . $discountAmt . "&nbsp;<i class='fa fa-rupee'></i>");

                        } else
                        {
                          // $discountAmt = $totalCartAmt*$couponData['coupn_discount_val']/100;
                          $discountAmt = $filter_pro_rec[0]['final_price'] * $couponData['coupn_discount_val'] / 100;
                          $discountAmt = round($discountAmt);
                          if ($discountAmt > $minimum_discount_value)
                          {

                            $discountAmt = $minimum_discount_value;

                          }
                          $userWallet = $this->db->get_where('wallet_master', array('user_master_id' => $u_id))->row_array();

                          if ($userWallet)
                          {
                            $walletAmt = $userWallet['wallet_amount'] + $discountAmt;

                            $updateWalletData = array(
                              'wallet_amount' => $walletAmt,
                              'add_date' => time()
                            );
                            $this->db->where('user_master_id', $u_id);
                            $this->db->update('wallet_master', $updateWalletData);

                            // $this->session->set_flashdata("Coupon_Succ", "<img src='".base_url()."/assets/emoji/congratulation.png' height='50px' width='50px'>&nbsp;congratulation.! You get <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$discountAmt."&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");

                            $this->session->set_flashdata("Coupon_Succ", "Get &nbsp;&nbsp;" . $discountAmt . "&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");

                          } else
                          {
                            $walletAmt = array(
                              'user_master_id' => $u_id,
                              'wallet_amount' => $discountAmt,
                              'status' => '1',
                              'add_date' => time()
                            );
                            $this->db->insert('wallet_master', $walletAmt);

                            $this->session->set_flashdata("Coupon_Succ", "Get &nbsp;&nbsp;" . $discountAmt . "&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");
                          }
                        }

                      }

                      $couponValData = array(
                        'coupon_uses' => $check_user_coupon_use['coupon_uses'] + 1
                      );

                      $this->db->where('id', $check_user_coupon_use['id']);
                      $this->db->update('coupon_validity_master', $couponValData);

                    } else
                    { //user coupon uses condition close

                      if ($coupon_discount_type == 1)
                      { // 1= FLAT Discount, 2= Percantage Discount

                        if ($coupon_type == 1)
                        { // 1=  Discountable Amount, 2= cashback

                          $newCartAmt = $_SESSION['cart_contents']['cart_total'] = $totalCartAmt - $couponData['coupn_discount_val'];

                          $this->session->set_flashdata("Coupon_Succ", "Discount:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-" . $couponData['coupn_discount_val'] . "&nbsp;<i class='fa fa-rupee'></i>");

                        } else
                        {
                          $userWallet = $this->db->get_where('wallet_master', array('user_master_id' => $u_id))->row_array();

                          if ($userWallet)
                          {
                            $walletAmt = $userWallet['wallet_amount'] + $couponData['coupn_discount_val'];

                            $updateWalletData = array(
                              'wallet_amount' => $walletAmt,
                              'add_date' => time()
                            );
                            $this->db->where('user_master_id', $u_id);
                            $this->db->update('wallet_master', $updateWalletData);

                            $this->session->set_flashdata("Coupon_Succ", "Get &nbsp;&nbsp;" . $couponData['coupn_discount_val'] . "&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");

                          } else
                          {

                            $walletAmt = array(
                              'user_master_id' => $u_id,
                              'wallet_amount' => $couponData['coupn_discount_val'],
                              'status' => '1',
                              'add_date' => time()
                            );

                            $this->db->insert('wallet_master', $walletAmt);

                            $this->session->set_flashdata("Coupon_Succ", "Get &nbsp;&nbsp;" . $couponData['coupn_discount_val'] . "&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");
                          }
                        }


                      } else
                      {

                        if ($coupon_type == 1)
                        { // 1=  Discountable Amount, 2= cashback

                          // $discountAmt = $totalCartAmt*$couponData['coupn_discount_val']/100;
                          $discountAmt = $filter_pro_rec[0]['final_price'] * $couponData['coupn_discount_val'] / 100;
                          $discountAmt = round($discountAmt);
                          if ($discountAmt > $minimum_discount_value)
                          {

                            $discountAmt = $minimum_discount_value;

                            $newCartAmt = $_SESSION['cart_contents']['cart_total'] = $totalCartAmt - $discountAmt;

                          } else
                          {

                            $newCartAmt = $_SESSION['cart_contents']['cart_total'] = $totalCartAmt - $discountAmt;

                          }

                          $this->session->set_flashdata("Coupon_Succ", "Discount:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-" . $discountAmt . "&nbsp;<i class='fa fa-rupee'></i>");

                        } else
                        {
                          // $discountAmt = $totalCartAmt*$couponData['coupn_discount_val']/100;
                          $discountAmt = $filter_pro_rec[0]['final_price'] * $couponData['coupn_discount_val'] / 100;
                          $discountAmt = round($discountAmt);
                          if ($discountAmt > $minimum_discount_value)
                          {

                            $discountAmt = $minimum_discount_value;

                          }

                          $userWallet = $this->db->get_where('wallet_master', array('user_master_id' => $u_id))->row_array();

                          if ($userWallet)
                          {
                            $walletAmt = $userWallet['wallet_amount'] + $discountAmt;

                            $updateWalletData = array(
                              'wallet_amount' => $walletAmt,
                              'add_date' => time()
                            );
                            $this->db->where('user_master_id', $u_id);
                            $this->db->update('wallet_master', $updateWalletData);

                            $this->session->set_flashdata("Coupon_Succ", "Get &nbsp;&nbsp;" . $discountAmt . "&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");

                          } else
                          {
                            $walletAmt = array(
                              'user_master_id' => $u_id,
                              'wallet_amount' => $discountAmt,
                              'status' => '1',
                              'add_date' => time()
                            );
                            $this->db->insert('wallet_master', $walletAmt);

                            $this->session->set_flashdata("Coupon_Succ", "Get &nbsp;&nbsp;" . $discountAmt . "&nbsp;<i class='fa fa-rupee'></i>&nbsp;in your wallet");
                          }
                        }

                      }
                      $couponValData = array(
                        'user_id' => $u_id,
                        'coupon_id' => $coupon_id,
                        'coupon_uses' => 1
                      );
                      $this->db->insert('coupon_validity_master', $couponValData);
                    }
                    // coupon applied successfully msg

                    $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button><img src="' . base_url() . '/assets/emoji/happy.png" height="50px" width="50px">Coupon Applied successfully.</div></div>');
                    // $coupon_succ = $coupon_id;
                    redirect('web/checkout_payment/coupon');

                  } else
                  { //coupon validity condition close

                    $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button><img src="' . base_url() . '/assets/emoji/expire.png" height="50px" width="50px">Opps..Coupon Expired</div></div>');
                    redirect('web/checkout_payment');
                  }

                } else
                { //filter product condition close
                  $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button><img src="' . base_url() . '/assets/emoji/confuse.png" height="50px" width="50px">You have not taken any product in such price range, for which this coupon is valid</div></div>');
                  redirect('web/checkout_payment');
                }

              } else
              { //Customer elegible for coupon or not condition close

                $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button><img src="' . base_url() . '/assets/emoji/confuse.png" height="50px" width="50px">Sorry, This coupon is not valid for these product.</div></div>');
                redirect('web/checkout_payment');

              }

            } else
            { //cart limit condition close

              $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button><img src="' . base_url() . '/assets/emoji/lowcart_amt.png" height="50px" width="50px">Please limit your cart amount up to ' . $check_cart_amt . '&nbsp;<i class="fa fa-rupee"></i></div></div>');
              redirect('web/checkout_payment');
            }

          } else
          { //apply discount on condition close

            $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button><img src="' . base_url() . '/assets/emoji/confuse.png" height="50px" width="50px">This coupon is not valid for this categories.</div></div>');
            redirect('web/checkout_payment');

          }

        } else
        {
          $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button><img src="' . base_url() . '/assets/emoji/expire.png" height="50px" width="50px">Opps..Coupon Expired</div></div>');
          redirect('web/checkout_payment');
        }


      } else
      { //wrong Payment mode condition close

        $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button><img src="' . base_url() . '/assets/emoji/confuse.png" height="50px" width="50px">Coupon is not for ' . $payment_mode . ' payment method.</div></div>');
        redirect('web/checkout_payment');
      }

    } else
    { //coupon exist or not condition close

      $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button><img src="' . base_url() . '/assets/emoji/thinking.png" height="50px" width="50px">Coupon Code is Invalid,Please try again.</div></div>');
      redirect('web/checkout_payment');
    }


  }


  public function use_wallet_amt()
  {
    $userData = $this->session->userdata('User');
    $data = $this->input->post();
    $inputAmt = $data['wallet_amt'];
    $userWallet = $this->db->get_where('wallet_master', array('user_master_id' => $userData['id']))->row_array();

    if ($userWallet['wallet_amount'] > $inputAmt)
    {

      $leftWalletAmt = $userWallet['wallet_amount'] - $inputAmt;
      $walletData = array(
        'wallet_amount' => $leftWalletAmt,
        'add_date' => time()
      );

      $this->db->where('user_master_id', $userData['id']);
      $this->db->update('wallet_master', $walletData);

      $totalCartAmt = $this->cart->total();

      $newCartAmt = $_SESSION['cart_contents']['cart_total'] = $totalCartAmt - $inputAmt;

      $this->session->set_flashdata("wallet_use_Succ", "You use successfully <u> <b>" . $inputAmt . "</b></u>&nbsp;<i class='fa fa-rupee'></i> from your wallet, let's continue your shopping.");

      redirect('web/checkout_payment/walletUses');

    } else
    {
      $this->session->set_flashdata("wallet_use_faild", "Looks like you don't have enough balance in your wallet");

      redirect('web/checkout_payment/walletUsesFalse');
    }

  }



  public function send_otp()
  {
    $input = json_decode(file_get_contents('php://input'), true);
    $mobile = $input['mobile'];
    $otp = $input['otp'];

    $user = $this->web_model->get_by_mobile($mobile);
    
     // Prepare the SMS text
      $text = 'Dear Customer, Your Mobile Verification OTP is: ' . $otp . '. Please enter this OTP to verify your mobile number. From www.Dukekart.inRegardsDukekart Real Time Private Limited';

      // Send the SMS
      sendSMS($mobile, $text, '1007086055987083292');


    if ($user)
    {
      $this->web_model->update_otp($mobile, $otp);
    } else
    {
      $this->web_model->insert_user_with_otp($mobile, $otp);
    }

    // You can integrate SMS sending here as needed
    echo json_encode(['status' => 'success']);
  }

  public function verify_otp()
  {
    // Get JSON input
    $input = json_decode(file_get_contents('php://input'), true);
    $mobile = $input['mobile'] ?? '';
    $otp = $input['otp'] ?? '';

    // Verify OTP using the model
    $user_res = $this->web_model->verify_otp($mobile, $otp);

    // Check if user exists
    if (!empty($user_res))
    {
      // Prepare session data
      $user_data = [
        "id" => $user_res["id"],
        "email" => $user_res["email_id"],
        "username" => $user_res["username"],
      ];

      // Set session
      $this->session->set_userdata("User", $user_data);

      // Return success response
      $this->output
        ->set_status_header(200)
        ->set_content_type("application/json")
        ->set_output(json_encode([
          "status" => "Success",
          "message" => "Login successful"
        ]));
    } else
    {
      // Invalid OTP response
      $this->output
        ->set_status_header(401)
        ->set_content_type("application/json")
        ->set_output(json_encode([
          "status" => "error",
          "message" => "Invalid OTP"
        ]));
    }
  }

}