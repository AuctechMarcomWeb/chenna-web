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
    $this->load->helper(['url', 'text']);
    // $this->load->config('phonepe');
  }

  // Registration

  public function vendor_registration()
  {
    $userData = $this->session->userdata('User');
    $data['wishlist_count'] = !empty($userData) ? $this->web_model->get_total_wishlist_by_user($userData['id']) : 0;
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['title'] = 'Vendor Registration | Chenna';
    $this->load->view('web/include/header', $data);
    $this->load->view('web/vendor_registration');
    $this->load->view('web/include/footer');
  }

  public function promoter_registration()
  {
    $userData = $this->session->userdata('User');
    $data['wishlist_count'] = !empty($userData) ? $this->web_model->get_total_wishlist_by_user($userData['id']) : 0;
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['title'] = 'Become Promoter | Chenna';
    $this->load->view('web/include/header', $data);
    $this->load->view('web/promoter_registration');
    $this->load->view('web/include/footer');
  }

  // Registration
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

    $mobile_num = $this->input->post('mobile_num');

    $mobile_otp = $this->input->post('otp');
    $mobile = $mobile_num;

    if (preg_match('/^\d{10}$/', $mobile_num) && !empty($mobile_otp))
    {

      $text = 'Dear Customer, Your Mobile Verification OTP is: ' . $mobile_otp . '. Please enter this OTP to verify your mobile number. From www.Chenna.in Regards, Chenna Real Time Private Limited';

      sendSMS($mobile_num, $text, '1007086055987083292');

      $this->output
        ->set_status_header(200)
        ->set_content_type('application/json')
        ->set_output(json_encode(['status' => 'Success', 'message' => 'SMS sent successfully']));
    } else
    {

      $this->output
        ->set_status_header(400)
        ->set_content_type('application/json')
        ->set_output(json_encode(['status' => 'Error', 'message' => 'Invalid mobile number or OTP']));
    }
  }
  public function AddUserCartData()
  {

    $mobile_num = $this->input->post('mobile_num');
    $product_id = $this->input->post('pro_id');
    $mobile_otp = $this->input->post('otp');
    $mobile = $mobile_num;

    $data = array(
      'PRODUCT_ID' => $product_id,
      'USER_MOBILE' => $mobile_num,
    );

    $this->db->insert('ORDER_QUERY', $data);
  }
  public function sendVerificationSMS_old()
  {

    $mobile_num = $this->input->post('mobile_num');
    $product_id = $this->input->post('pro_id');

    $mobile = $mobile_num;
    $mobile_otp = $this->input->post('otp');

    if (strlen($mobile) === 10 && strlen($mobile_otp) != 0)
    {

      $data = array(
        'PRODUCT_ID' => $product_id,
        'USER_MOBILE' => $mobile_num,
      );
      // Insert data into ORDER_QUERY table
      // $this->ORDER_QUERY->insert($data);
      $this->db->insert('ORDER_QUERY', $data);
      $text = 'Dear Customer Your Mobile Verification OTP is: ' . $mobile_otp . ' Please enter this OTP to verify your mobile number. From www.Chenna.inRegardsChenna Real Time Private Limited';
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

    // Fetch product info
    $product_info = $this->db->get_where('sub_product_master', ['id' => $pro_id])->row_array();

    if (!$product_info)
    {
      echo json_encode([
        'cart_val' => $this->cart->total_items(),
        'qty' => 'false'
      ]);
      return;
    }

    // Check if product already in cart to get existing qty
    $total_item = $this->cart->contents();
    $pro_qty = 0;
    foreach ($total_item as $value)
    {
      if ($pro_id == $value['id'])
      {
        $pro_qty = $value['qty'];
      }
    }

    // Check stock
    if ($product_info['quantity'] >= ($pro_qty + $qty))
    {
      // Clean product name
      $name_clean = str_replace(
        ['"', "'", "(", ")", "#", "&", "|", "/", "-", "_", "@", "$", "*", "!", "?", "%", "+", "=", "~", "`", "^", "<", ">", "{", "}", "[", "]", ";", ":", ",", ".", "\\"],
        '',
        $product_info['product_name']
      );

      // Prepare cart data
      $data = [
        'id' => $product_info['id'],
        'qty' => $qty,
        'size' => $product_info['size'],
        'color' => $product_info['color'],
        'brand' => $product_info['brand'],
        'price' => $product_info['price'],
        'final_price' => $product_info['final_price'],
        'gst' => $product_info['gst'],
        'name' => $name_clean,
        'image' => $product_info['main_image'],

        // 🔹 Add vendor_id & promoter_id
        'vendor_id' => $product_info['vendor_id'],
        'promoter_id' => $product_info['promoter_id']
      ];

      // Insert into cart
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
    $data['title'] = 'Category | Chenna';
    $this->load->view('web/include/header', $data);
    $this->load->view('web/category_items');
    $this->load->view('web/include/footer');
  }
  public function index()
  {
    $userData = $this->session->userdata('User');

    $data['wishlist_count'] = !empty($userData) ? $this->web_model->get_total_wishlist_by_user($userData['id']) : 0;
    $data['sections'] = $this->web_model->getAllTagSections();
    $data['tagIndex'] = 0;

    $data['categories'] = $this->db->select('p.id as parent_id, p.name as parent_name, c.id as category_id, c.category_name, c.app_icon')
      ->from('parent_category_master p')
      ->join('category_master c', 'c.mai_id = p.id', 'left')
      ->where('p.status', '1')
      ->where('c.status', '1')
      ->order_by('p.id', 'ASC')
      ->order_by('c.id', 'ASC')
      ->get()
      ->result_array();

    $ads = $this->db->where('status', 1)
      ->where_in('img_section', ['fixed', 'bottom'])
      ->order_by('add_date', 'ASC')
      ->get('advertisement')
      ->result_array();

    $data['states'] = $this->web_model->get_all_states();
    $data['products'] = $this->web_model->get_default_home_products();

    $data['fixedAds'] = array_filter($ads, fn($ad) => $ad['img_section'] === 'fixed');
    $data['bottomAds'] = array_filter($ads, fn($ad) => $ad['img_section'] === 'bottom');

    $data['title'] = 'Welcome to Chenna | Shop Online with Best Offers‎';

    $this->load->view('web/include/header', $data);
    $this->load->view('web/home', $data);
    $this->load->view('web/include/footer', $data);
  }

  public function get_city()
  {
    $state = $this->input->post('state');
    $cities = $this->web_model->get_city_by_state($state);

    echo '<option value="">Select City</option>';
    foreach ($cities as $ct)
    {
      echo '<option value="' . $ct . '">' . $ct . '</option>';
    }
  }

  public function get_home_products()
  {
    $state = $this->input->post('state');
    $city = $this->input->post('city');

    $products = $this->web_model->get_state_city_products($state, $city);

    if (!empty($products))
    {
      foreach ($products as $pro)
      { ?>
        <div>
          <div class="product-image special-box" id="special-box">
            <a href="<?= base_url('product/' . $pro['slug']) ?>">
              <img src="<?= base_url('assets/product_images/' . $pro['main_image']) ?>"
                class="img-fluid special-box blur-up lazyloaded" alt="">
            </a>
          </div>

          <div class="product-detail text-center">


            <a href="<?= base_url('product/' . $pro['slug']) ?>">
              <h3 class="name w-100 mx-auto text-center text-title"><?= $pro['product_name'] ?></h3>
            </a>

            <h3 class="price theme-color">
              ₹<?= $pro['final_price'] ?>
              <?php if (!empty($pro['mrp_price']) && $pro['mrp_price'] > $pro['final_price'])
              { ?>
                <del class="delete-price">₹<?= $pro['mrp_price'] ?></del>
              <?php } ?>
            </h3>
          </div>
        </div>
      <?php }
    } else
    {
      echo '<div class="text-center text-danger p-3">No product found</div>';
    }
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
    $data['title'] = "Vegetables | Chenna";
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
    $data['title'] = "Vegetables | Chenna";
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
    $data['title'] = "Vegetables | Chenna";
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


    $this->db->select('product_name');
    $this->db->from('sub_product_master');
    $this->db->where('status', '1');
    if (!empty($keywords))
    {
      $this->db->like('product_name', $keywords);
    }
    $this->db->group_by('product_name');
    $totalRecords = $this->db->count_all_results();

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


    foreach ($AllRecord as &$product)
    {
      $product['variations'] = $this->db->select('id,size,color,final_price,price, quantity')
        ->from('sub_product_master')
        ->where('status', '1')
        ->where('product_name', $product['product_name'])
        ->get()
        ->result_array();

      $ratingData = $this->db->select('AVG(rating) as avg_rating, COUNT(id) as total_reviews')
        ->where('product_id', $product['id'])
        ->where('status', 1)
        ->get('customer_review')
        ->row_array();

      $product['average_rating'] = round($ratingData['avg_rating'] ?? 0, 1);
      $product['total_reviews'] = $ratingData['total_reviews'] ?? 0;
    }


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
        'title' => $main . ' | ' . $categoryArray['0'] . ' | Chenna',
        'index2' => ''
      )
    );
    $this->load->view('web/category_product_list');
    $this->load->view('web/include/footer');
  }


  // Category Products List Page
  public function category_product_list($mainSlug, $categorySlug)
  {
    $user_id = $this->session->userdata('User')['id'] ?? null;

    // Get main category
    $mainCategory = $this->db->get_where('parent_category_master', [
      'slug' => $mainSlug,
      'status' => 1
    ])->row_array();
    if (!$mainCategory)
      show_404();

    // Get category
    $categoryRow = $this->db->get_where('category_master', [
      'mai_id' => $mainCategory['id'],
      'slug' => $categorySlug,
      'status' => 1
    ])->row_array();
    if (!$categoryRow)
      show_404();

    // Categories & subcategories
    $categories = $this->db->select('id, category_name, slug')
      ->where('mai_id', $mainCategory['id'])
      ->where('status', 1)
      ->get('category_master')
      ->result_array();

    foreach ($categories as &$cat)
    {
      $cat['subcategories'] = $this->db->select('id, sub_category_name, slug')
        ->where('category_master_id', $cat['id'])
        ->where('status', 1)
        ->get('sub_category_master')
        ->result_array();
    }

    // Price range (ONLY approved + verified products)
    $priceRange = $this->db->select('MIN(final_price) as min_price, MAX(final_price) as max_price')
      ->from('sub_product_master')
      ->where([
        'status' => 1,
        'seller_approve_status' => 1,
        'verify_status' => 1,
        'parent_category_id' => $mainCategory['id'],
        'category_id' => $categoryRow['id']
      ])
      ->get()->row_array();

    $data = [
      'user_id' => $user_id,
      'mainCategory' => $mainCategory,
      'categoryRow' => $categoryRow,
      'mainCategoryId' => $mainCategory['id'],
      'categoryId' => $categoryRow['id'],
      'categories' => $categories,
      'min_price_range' => $priceRange['min_price'] ?? 0,
      'max_price_range' => $priceRange['max_price'] ?? 100000,
      'title' => $categoryRow['category_name'] . ' - ' . $mainCategory['name']
    ];

    $this->load->view('web/include/header', $data);
    $this->load->view('web/category_product_list', $data);
    $this->load->view('web/include/footer');
  }


  // AJAX - Filter products
  public function ajax_filter_products()
  {
    $user_id = $this->session->userdata('User')['id'] ?? null;

    $mainCategoryId = $this->input->post('mainCategoryId');
    $categoryId = $this->input->post('categoryId');
    $subCategoryId = $this->input->post('subCategoryId');
    $min_price = $this->input->post('min_price');
    $max_price = $this->input->post('max_price');
    $size = $this->input->post('size');
    $rating = $this->input->post('rating');
    $page = $this->input->post('page') ?: 1;

    $limit = 12;
    $offset = ($page - 1) * $limit;

    /* ========= SUB QUERY (LATEST SKU) ========= */
    $subQuery = $this->db->select('sku_code, MAX(id) as max_id')
      ->from('sub_product_master')
      ->where('status', 1)
      ->where('verify_status', 1)
      ->where('seller_approve_status', 1);

    if ($mainCategoryId)
      $subQuery->where('parent_category_id', $mainCategoryId);

    if ($categoryId)
      $subQuery->where_in('category_id', explode(',', $categoryId));

    if ($subCategoryId)
      $subQuery->where_in('sub_category_id', explode(',', $subCategoryId));

    if ($size)
      $subQuery->where_in('size', explode(',', $size));

    $subQuery->group_by('sku_code');
    $subQueryStr = $subQuery->get_compiled_select();

    /* ========= MAIN QUERY ========= */
    $this->db->select("
        sp.id,
        sp.sku_code,
        sp.product_name,
        sp.price,
        sp.final_price,
        sp.main_image,
        sp.size,
        sp.cash_on_delivery,
        sp.seller_approve_status,
        sp.verify_status,
        COALESCE(AVG(cr.rating),0) as avg_rating
    ");

    $this->db->from("sub_product_master sp");
    $this->db->join("($subQueryStr) latest", "sp.id = latest.max_id", "inner");
    $this->db->join("customer_review cr", "sp.id = cr.product_id AND cr.status = 1", "left");

    $this->db->where('sp.status', 1);
    $this->db->where('sp.verify_status', 1);
    $this->db->where('sp.seller_approve_status', 1);

    if ($min_price !== null && $max_price !== null)
      $this->db->where('sp.final_price >=', $min_price)
        ->where('sp.final_price <=', $max_price);

    $this->db->group_by('sp.id');

    if (!empty($rating))
      $this->db->having('avg_rating >=', $rating);

    /* ========= TOTAL ========= */
    $clone = clone $this->db;
    $total = $clone->get()->num_rows();

    /* ========= DATA ========= */
    $this->db->limit($limit, $offset);
    $result = $this->db->get()->result_array();

    /* ========= WISHLIST ========= */
    $wishlist_ids = [];
    if ($user_id)
    {
      $wishlist_ids = array_column(
        $this->db->select('product_id')
          ->from('wish_list_master')
          ->where('user_id', $user_id)
          ->get()->result_array(),
        'product_id'
      );
    }

    $products = [];
    foreach ($result as $p)
    {
      $products[] = [
        'id' => $p['id'],
        'sku_code' => $p['sku_code'],
        'product_name' => $p['product_name'],
        'price' => $p['price'],
        'final_price' => $p['final_price'],
        'main_image' => $p['main_image'],
        'size' => $p['size'],
        'avg' => round($p['avg_rating'], 1),
        'cash_on_delivery' => (int) $p['cash_on_delivery'],
        'seller_approve_status' => (int) $p['seller_approve_status'],
        'verify_status' => (int) $p['verify_status'],
        'in_wishlist' => in_array($p['id'], $wishlist_ids)
      ];
    }

    echo json_encode([
      'products' => $products,
      'total' => $total,
      'limit' => $limit
    ]);
  }







  // Sub-category product list page
  public function sub_category_product_list($mainSlug, $categorySlug, $subSlug)
  {
    $userData = $this->session->userdata('User');
    $user_id = !empty($userData) ? $userData['id'] : null;

    $wishlist_count = $user_id
      ? $this->web_model->get_total_wishlist_by_user($user_id)
      : 0;

    /* ================= SLUG TO ID ================= */
    $mainCategory = $this->db->get_where('parent_category_master', [
      'slug' => $mainSlug,
      'status' => 1
    ])->row_array();

    $categoryRow = $this->db->get_where('category_master', [
      'slug' => $categorySlug,
      'mai_id' => $mainCategory['id'] ?? 0,
      'status' => 1
    ])->row_array();

    $subCategoryRow = $this->db->get_where('sub_category_master', [
      'slug' => $subSlug,
      'category_master_id' => $categoryRow['id'] ?? 0,
      'status' => 1
    ])->row_array();

    if (!$mainCategory || !$categoryRow || !$subCategoryRow)
      show_404();

    $mainCategoryId = $mainCategory['id'];
    $categoryId = $categoryRow['id'];
    $subCategoryId = $subCategoryRow['id'];

    /* ================= PRICE RANGE (ONLY VALID PRODUCTS) ================= */
    $priceRange = $this->db->select('MIN(final_price) as min_price, MAX(final_price) as max_price')
      ->from('sub_product_master')
      ->where([
        'status' => 1,
        'verify_status' => 1,
        'seller_approve_status' => 1,
        'parent_category_id' => $mainCategoryId,
        'category_id' => $categoryId,
        'sub_category_id' => $subCategoryId
      ])
      ->get()
      ->row_array();

    /* ================= CATEGORY TREE ================= */
    $categories = $this->db->select('id, category_name, slug')
      ->from('category_master')
      ->where('status', 1)
      ->where('mai_id', $mainCategoryId)
      ->get()->result_array();

    foreach ($categories as &$cat)
    {
      $cat['subcategories'] = $this->db->select('id, sub_category_name, slug')
        ->from('sub_category_master')
        ->where('status', 1)
        ->where('category_master_id', $cat['id'])
        ->get()->result_array();
    }

    $data = [
      'user_id' => $user_id,
      'wishlist_count' => $wishlist_count,
      'mainCategoryId' => $mainCategoryId,
      'categoryId' => $categoryId,
      'subCategoryId' => $subCategoryId,
      'categories' => $categories,
      'min_price_range' => (int) ($priceRange['min_price'] ?? 0),
      'max_price_range' => (int) ($priceRange['max_price'] ?? 0),
      'title' => ucfirst($mainSlug) . ' | ' . ucfirst($categorySlug) . ' | ' . ucfirst($subSlug)
    ];

    $this->load->view('web/include/header', $data);
    $this->load->view('web/sub_category_product_list', $data);
    $this->load->view('web/include/footer');
  }



  // AJAX filter
  public function ajax_filter_subcategory_products()
  {
    $user_id = $this->session->userdata('User')['id'] ?? 0;

    $mainCategoryId = $this->input->post('mainCategoryId');
    $categoryId = $this->input->post('categoryId');
    $subCategoryId = $this->input->post('subCategoryId');
    $min_price = (float) $this->input->post('min_price');
    $max_price = (float) $this->input->post('max_price');
    $size = $this->input->post('size');
    $rating = $this->input->post('rating');
    $page = (int) $this->input->post('page') ?: 1;
    $perPage = 12;

    /* ================= BASE QUERY ================= */
    $this->db->from('sub_product_master')
      ->where([
        'status' => 1,
        'verify_status' => 1,
        'seller_approve_status' => 1,
      ])
      ->group_by('sku_code');

    if ($mainCategoryId)
      $this->db->where('parent_category_id', $mainCategoryId);
    if ($categoryId)
      $this->db->where_in('category_id', explode(',', $categoryId));
    if ($subCategoryId)
      $this->db->where_in('sub_category_id', explode(',', $subCategoryId));
    if ($size)
      $this->db->where_in('size', explode(',', $size));
    if ($min_price)
      $this->db->where('final_price >=', $min_price);
    if ($max_price)
      $this->db->where('final_price <=', $max_price);

    $allProducts = $this->db->order_by('id', 'DESC')->get()->result_array();

    /* ================= AVG RATING ================= */
    $ids = array_column($allProducts, 'id');
    $avgRatings = [];

    if ($ids)
    {
      $ratings = $this->db->select('product_id, ROUND(AVG(rating),1) avg')
        ->from('customer_review')
        ->where('status', 1)
        ->where_in('product_id', $ids)
        ->group_by('product_id')
        ->get()->result_array();

      foreach ($ratings as $r)
        $avgRatings[$r['product_id']] = $r['avg'];
    }

    foreach ($allProducts as &$p)
    {
      $p['avg'] = $avgRatings[$p['id']] ?? 0;
      $p['in_wishlist'] = $user_id
        ? $this->db->where([
          'user_id' => $user_id,
          'product_id' => $p['id']
        ])->count_all_results('wish_list_master') > 0
        : 0;
    }
    unset($p);

    /* ================= RATING FILTER ================= */
    if ($rating)
    {
      $allProducts = array_values(array_filter($allProducts, function ($p) use ($rating) {
        return floor($p['avg']) >= (int) $rating;
      }));
    }

    /* ================= PAGINATION ================= */
    $total = count($allProducts);
    $offset = ($page - 1) * $perPage;
    $products = array_slice($allProducts, $offset, $perPage);

    /* ================= SIZE LIST ================= */
    $sizes = $this->db->distinct()
      ->select('size')
      ->from('sub_product_master')
      ->where([
        'status' => 1,
        'verify_status' => 1,
        'seller_approve_status' => 1,
        'cash_on_delivery' => 1
      ])
      ->get()->result_array();

    /* ================= RESPONSE ================= */
    echo json_encode([
      'products' => $products,
      'total' => $total,
      'limit' => $perPage,
      'sizes' => array_column($sizes, 'size')
    ]);
  }


  public function home_product_list($tag, $id)
  {
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['getData'] = $this->web_model->getDataByTag($tag, $id);
    $data['title'] = $tag . ' products | Chenna';
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
    $data['title'] = 'Order Details | Chenna ';
    $this->load->view('web/include/header', $data);
    $this->load->view('web/order_details');
    $this->load->view('web/include/footer');
  }
  public function order_invoice($order_id_encoded, $type = '1')
  {
    $order_id = base64_decode($order_id_encoded);

    if ($type === '2')
    {
      $purchase_table = 'purchase_master2';
      $order_table = 'order_master2';
      $address_table = 'order_address_master2';
    } else
    {
      $purchase_table = 'purchase_master';
      $order_table = 'order_master';
      $address_table = 'order_address_master';
    }

    $order = $this->db->get_where($order_table, ['id' => $order_id])->row_array();
    $purchase_items = $this->db->get_where($purchase_table, ['order_master_id' => $order_id])->result_array();
    $address = $this->db->get_where($address_table, ['order_master_id' => $order_id])->row_array();

    $order['order_date'] = (!empty($order['add_date']) && $order['add_date'] != '0000-00-00 00:00:00')
      ? date('d-m-Y', strtotime($order['add_date']))
      : 'N/A';

    $data = [
      'order' => $order,
      'purchase_items' => $purchase_items,
      'address' => $address,
      'order_id_encoded' => $order_id_encoded,
      'title' => 'Order Invoice | Dukekart'
    ];

    $this->load->view('web/order_invoice', $data);
  }


  public function order_details($order_id_encoded, $type = '1')
  {
    $userData = $this->session->userdata('User');
    $data['wishlist_count'] = !empty($userData) ? $this->web_model->get_total_wishlist_by_user($userData['id']) : 0;
    $order_id = base64_decode($order_id_encoded);

    // Determine which tables to use
    if ($type === '2')
    {
      $purchase_table = 'purchase_master2';
      $order_table = 'order_master2';
      $address_table = 'order_address_master2';
    } else
    {
      $purchase_table = 'purchase_master';
      $order_table = 'order_master';
      $address_table = 'order_address_master';
    }

    // Fetch order
    $order = $this->db->get_where($order_table, ['id' => $order_id])->row_array();
    if (!$order)
    {
      show_404();
      return;
    }

    // Fetch purchase items
    $purchase_items = $this->db->get_where($purchase_table, ['order_master_id' => $order_id])->result_array();

    // Fetch shipping address
    $address = $this->db->get_where($address_table, ['order_master_id' => $order_id])->row_array();

    $data = [
      'order' => $order,
      'purchase_items' => $purchase_items,
      'address' => $address,
      'order_id_encoded' => $order_id_encoded,
      'title' => 'Order Details | Chenna'
    ];

    // Add timestamp for sorting/filtering if needed
    $data['order']['add_date_timestamp'] = strtotime($order['add_date']);

    // Load view
    $this->load->view('web/include/header', $data);
    $this->load->view('web/order_details', $data);
    $this->load->view('web/include/footer');
  }


  // public function product_detail()
  // {
  //   $userData = $this->session->userdata('User');
  //   $user_id = !empty($userData) ? $userData['id'] : null;

  //   $wishlist_count = !empty($user_id)
  //     ? $this->web_model->get_total_wishlist_by_user($user_id)
  //     : 0;

  //   // Product ID from URL
  //   $product_id = $this->uri->segment(2);

  //   // 🔹 PRODUCT DATA
  //   $data['getData'] = $this->web_model->productDetails($product_id);
  //   if (empty($data['getData']))
  //   {
  //     show_404();
  //   }
  //   $data['product'] = $data['getData'];

  //   // 🔹 BRAND NAME
  //   if (!empty($data['getData']['brand_id']))
  //   {
  //     $brand = $this->db
  //       ->get_where('brand_master', ['id' => $data['getData']['brand_id']])
  //       ->row_array();
  //     $data['product']['brand_name'] = $brand['brand_name'] ?? 'N/A';
  //   } else
  //   {
  //     $data['product']['brand_name'] = 'N/A';
  //   }

  //   // 🔹 VARIATIONS
  //   $data['variations'] = $this->db
  //     ->select('id, vendor_id, promoter_id, size, color, quantity, price, final_price,
  //               main_image, product_code, image1, image2, image3, image4, image5')
  //     ->where('product_code', $data['getData']['product_code'])
  //     ->where('status', 1)
  //     ->get('sub_product_master')
  //     ->result_array();

  //   $data['colorData'] = array_values(array_unique(array_column($data['variations'], 'color')));
  //   $data['sizeData'] = array_values(array_unique(array_column($data['variations'], 'size')));
  //   $data['extra_fields'] = $this->web_model->getProductExtraFields($product_id);

  //   // =====================================================
  //   // 🔹 VENDOR + SHOP DATA
  //   // =====================================================
  //   $vendorData = [];
  //   if (!empty($data['getData']['vendor_id']))
  //   {
  //     $vendorData = $this->db
  //       ->select('v.id AS vendor_id, v.vendor_logo, v.shop_name, v.state, v.city')
  //       ->from('vendors v')
  //       ->join('shop_master sm', 'sm.id = v.id', 'left')
  //       ->where('v.id', $data['getData']['vendor_id'])
  //       ->get()
  //       ->row_array();
  //   }
  //   $data['vendorData'] = $vendorData;

  //   // =====================================================
  //   // 🔹 PROMOTER DATA
  //   // =====================================================
  //   $promoterData = [];
  //   if (!empty($data['getData']['promoter_id']))
  //   {
  //     $promoterData = $this->db
  //       ->select('p.id AS promoter_id, p.name AS promoter_name, p.email, p.state, p.city,p.promoter_logo')
  //       ->from('promoters p')
  //       ->where('p.id', $data['getData']['promoter_id'])
  //       ->get()
  //       ->row_array();
  //   }
  //   $data['promoterData'] = $promoterData;

  //   // 🔹 RELATED PRODUCTS
  //   $current_product_code = $data['getData']['product_code'];
  //   $sub_category_id = $data['getData']['sub_category_id'];
  //   $relatedProducts = [];

  //   if ($sub_category_id && $current_product_code)
  //   {
  //     $related = $this->db
  //       ->select('id, product_name, product_code, main_image, final_price, price, quantity')
  //       ->where('status', 1)
  //       ->where('sub_category_id', $sub_category_id)
  //       ->where('product_code !=', $current_product_code)
  //       ->order_by('id', 'DESC')
  //       ->limit(12)
  //       ->get('sub_product_master')
  //       ->result_array();

  //     $unique = [];
  //     foreach ($related as $prod)
  //     {
  //       if (!isset($unique[$prod['product_code']]))
  //       {
  //         $prod['total_qty'] = $this->db
  //           ->select_max('quantity')
  //           ->where('product_code', $prod['product_code'])
  //           ->where('status', 1)
  //           ->get('sub_product_master')
  //           ->row()->quantity ?? 0;

  //         $prod['average_rating'] = round(
  //           $this->db->select_avg('rating')
  //             ->where('product_id', $prod['id'])
  //             ->get('customer_review')
  //             ->row()->rating ?? 0,
  //           1
  //         );
  //         $unique[$prod['product_code']] = $prod;
  //       }
  //     }
  //     $relatedProducts = array_values($unique);
  //   }
  //   $data['relatedProducts'] = $relatedProducts;

  //   // 🔹 REVIEWS
  //   $data['reviews'] = $this->db->query("
  //       SELECT cr.*, 
  //           SUM(CASE WHEN rld.action='like' THEN 1 ELSE 0 END) AS like_count,
  //           SUM(CASE WHEN rld.action='dislike' THEN 1 ELSE 0 END) AS dislike_count
  //       FROM customer_review cr
  //       LEFT JOIN review_like_dislike rld ON rld.review_id = cr.id
  //       WHERE cr.product_id = ?
  //       AND cr.status = 1
  //       GROUP BY cr.id
  //       ORDER BY cr.created_at DESC
  //   ", [$product_id])->result();

  //   $data['average_rating'] = $this->db
  //     ->select_avg('rating')
  //     ->where('product_id', $product_id)
  //     ->get('customer_review')
  //     ->row()->rating ?? 0;

  //   // 🔹 COMMON DATA
  //   $data['bannerList'] = $this->web_model->getBannerList();
  //   $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
  //   $data['wishlist_count'] = $wishlist_count;
  //   $data['title'] = url_title($data['getData']['product_name'], '-', true);

  //   // 🔹 LOAD VIEW
  //   $this->load->view('web/include/header', $data);
  //   $this->load->view('web/product_detail', $data);
  //   $this->load->view('web/include/footer');
  // }


  public function product_detail()
  {
    $userData = $this->session->userdata('User');
    $user_id = !empty($userData) ? $userData['id'] : null;

    $wishlist_count = $user_id
      ? $this->web_model->get_total_wishlist_by_user($user_id)
      : 0;

    // Product ID
    $product_id = (int) $this->uri->segment(2);

    /* =====================================================
       🔒 MAIN PRODUCT (SECURITY FILTERS)
    ====================================================== */
    $product = $this->db
      ->where([
        'id' => $product_id,
        'status' => 1,
        'verify_status' => 1,
        'seller_approve_status' => 1
      ])
      ->get('sub_product_master')
      ->row_array();

    if (!$product)
      show_404();

    $data['product'] = $product;
    $data['getData'] = $product;

    /* =====================================================
       🔹 BRAND
    ====================================================== */
    if (!empty($product['brand_id']))
    {
      $brand = $this->db->get_where('brand_master', [
        'id' => $product['brand_id'],
        'status' => 1
      ])->row_array();

      $data['product']['brand_name'] = $brand['brand_name'] ?? 'N/A';
    } else
    {
      $data['product']['brand_name'] = 'N/A';
    }

    /* =====================================================
       🔹 VARIATIONS (ONLY APPROVED)
    ====================================================== */
    $data['variations'] = $this->db
      ->select('id, vendor_id, promoter_id, size, color, quantity, price,
                 final_price, main_image, product_code,
                 image1,image2,image3,image4,image5,cash_on_delivery')
      ->from('sub_product_master')
      ->where([
        'product_code' => $product['product_code'],
        'status' => 1,
        'verify_status' => 1,
        'seller_approve_status' => 1
      ])
      ->order_by('final_price', 'ASC')
      ->get()
      ->result_array();

    $data['colorData'] = array_values(array_unique(array_column($data['variations'], 'color')));
    $data['sizeData'] = array_values(array_unique(array_column($data['variations'], 'size')));

    // COD availability (any variation has COD)
    $data['cod_available'] = in_array(1, array_column($data['variations'], 'cash_on_delivery'));

    /* =====================================================
       🔹 EXTRA FIELDS
    ====================================================== */
    $data['extra_fields'] = $this->web_model->getProductExtraFields($product_id);

    /* =====================================================
       🔹 VENDOR DATA
    ====================================================== */
    $data['vendorData'] = [];
    if (!empty($product['vendor_id']))
    {
      $data['vendorData'] = $this->db
        ->select('v.id,v.vendor_logo,v.shop_name,v.state,v.city')
        ->from('vendors v')
        ->where('v.id', $product['vendor_id'])
        ->get()
        ->row_array();
    }

    /* =====================================================
       🔹 PROMOTER DATA
    ====================================================== */
    $data['promoterData'] = [];
    if (!empty($product['promoter_id']))
    {
      $data['promoterData'] = $this->db
        ->select('id,name,email,state,city,promoter_logo')
        ->from('promoters')
        ->where('id', $product['promoter_id'])
        ->get()
        ->row_array();
    }

    /* =====================================================
       🔹 RELATED PRODUCTS (APPROVED ONLY)
    ====================================================== */
    $relatedProducts = [];
    $related = $this->db
      ->select('id,product_name,product_code,main_image,final_price,price')
      ->from('sub_product_master')
      ->where([
        'status' => 1,
        'verify_status' => 1,
        'seller_approve_status' => 1,
        'sub_category_id' => $product['sub_category_id']
      ])
      ->where('product_code !=', $product['product_code'])
      ->group_by('product_code')
      ->order_by('id', 'DESC')
      ->limit(12)
      ->get()
      ->result_array();

    foreach ($related as &$rp)
    {
      $rp['average_rating'] = round(
        $this->db->select_avg('rating')
          ->where('product_id', $rp['id'])
          ->where('status', 1)
          ->get('customer_review')
          ->row()->rating ?? 0,
        1
      );
    }

    $data['relatedProducts'] = $related;

    /* =====================================================
       🔹 REVIEWS
    ====================================================== */
    $data['reviews'] = $this->db->query("
        SELECT cr.*,
            SUM(CASE WHEN rld.action='like' THEN 1 ELSE 0 END) like_count,
            SUM(CASE WHEN rld.action='dislike' THEN 1 ELSE 0 END) dislike_count
        FROM customer_review cr
        LEFT JOIN review_like_dislike rld ON rld.review_id = cr.id
        WHERE cr.product_id = ?
        AND cr.status = 1
        GROUP BY cr.id
        ORDER BY cr.created_at DESC
    ", [$product_id])->result();

    $data['average_rating'] = round(
      $this->db->select_avg('rating')
        ->where('product_id', $product_id)
        ->where('status', 1)
        ->get('customer_review')
        ->row()->rating ?? 0,
      1
    );

    /* =====================================================
       🔹 COMMON DATA
    ====================================================== */
    $data['wishlist_count'] = $wishlist_count;
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['title'] = url_title($product['product_name'], '-', true);

    /* =====================================================
       🔹 VIEW
    ====================================================== */
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
    $data['title'] = 'Wish List Details | Chenna';
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
    $data['title'] = 'Order List | Chenna';
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
    // $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['getWalletData'] = $this->db->get_where('wallet_master', array('user_master_id' => $userData['id']))->row_array();
    $data['title'] = 'Wallet Details | Chenna';
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
    // $dataa['order_id'] = $order['order_number'];
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
    $dataa['merchant_param1'] = 'Chenna add money';
    $this->load->view('paymentGateway/instomojo', $dataa);
  }
  public function become_a_vendor()
  {
    $data = $this->input->post();
    if (empty($data))
    {
      $data['bannerList'] = $this->web_model->getBannerList();
      $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
      $data['title'] = 'Become a vendor | Chenna ';
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
        $text = "Your seller account has been successfully registered with Chenna. Kindly visit https://Chenna.in/seller to start uploading your products on Chenna and start earning Regards Chenna Real Time Private Limited";
        //$text="Seller registration Test";
        // ***OLD TEXT*****
        //$text="Congratulations! You have successfully registered your seller account with us.\r\nUser name : ".$data['name'];
        // sendSMS($data['mobile'],$text);
        sendSMS($data['mobile'], $text, '1007050631475099664');
        $email_message = 'Dear ' . $data['name'] . ',
          Congratulations and welcome to a whole new world of online marketplace
          You have provisionally created your Chenna seller account.
          Kindly complete your seller profile and connect with us to expand your business.
          Your Login id is ' . $data['mobile'] . '';
        sentCommonEmail($data['email'], $email_message, 'Chennae Registration Successfully.');
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

    if (empty($userData))
    {
      redirect(base_url('login'));
      return;
    }

    $user_id = $userData['id'];

    $data['userInfo'] = $this->db->get_where('user_master', ['id' => $user_id])->row_array();
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['get_total_orders'] = $this->web_model->get_total_orders_by_user($user_id);
    $data['wishlist_count'] = $this->web_model->get_total_wishlist_by_user($user_id);


    $wishListData = $this->db->get_where('wish_list_master', ['user_id' => $user_id])->result_array();

    foreach ($wishListData as &$value)
    {
      $product_id = $value['product_id'];

      $product = $this->db->get_where('sub_product_master', ['id' => $product_id, 'status' => 1])->row_array();

      if ($product)
      {

        $ratingData = $this->db
          ->select('AVG(rating) as avg_rating, COUNT(id) as total_reviews')
          ->where('product_id', $product_id)
          ->where('status', 1)
          ->get('customer_review')
          ->row_array();

        $avg_rating = round($ratingData['avg_rating'] ?? 0, 1);
        $avg_rating = round($avg_rating * 2) / 2;

        $product['average_rating'] = $avg_rating;
        $product['total_reviews'] = $ratingData['total_reviews'] ?? 0;

        $value['product'] = $product;
      }
    }

    $data['wishListData'] = $wishListData;
    $data['title'] = 'My Wishlist | Jail Store';

    $this->load->view('web/include/header', $data);
    $this->load->view('web/wishlist', $data);
    $this->load->view('web/include/footer');
  }
  public function account_profile()
  {
    $data = $this->input->post();
    $userData = $this->session->userdata('User');

    if (empty($data))
    {
      // User info
      $data['userInfo'] = $this->db->get_where('user_master', ['id' => $userData['id']])->row_array();
      $data['bannerList'] = $this->web_model->getBannerList();
      $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
      $data['get_total_orders'] = $this->web_model->get_total_orders_by_user($userData['id']);

      // Wishlist count
      $this->db->where('user_id', $userData['id']);
      $data['wishlist_count'] = $this->db->get('wish_list_master')->num_rows();

      // Fetch offline orders
      $this->db->from('order_master');
      $this->db->where(['user_master_id' => $userData['id'], 'action_payment' => 'Yes']);
      $this->db->order_by('id', 'DESC');
      $offlineOrders = $this->db->get()->result_array();

      // Fetch online orders
      $this->db->from('order_master2');
      $this->db->where(['user_master_id' => $userData['id']]);
      $this->db->order_by('id', 'DESC');
      $onlineOrders = $this->db->get()->result_array();

      // Merge both orders
      // Merge both orders with a 'type' flag
      $offlineOrders = array_map(fn($o) => array_merge($o, ['order_type' => 'offline']), $offlineOrders);
      $onlineOrders = array_map(fn($o) => array_merge($o, ['order_type' => 'online']), $onlineOrders);

      // Merge them
      $data['getData'] = array_merge($offlineOrders, $onlineOrders);


      // User addresses
      $data['address_data'] = $this->db->get_where('user_address_master', ['user_master_id' => $userData['id']])->result_array();

      // Wishlist items
      $data['wishListData'] = $this->db->get_where('wish_list_master', ['user_id' => $userData['id']])->result_array();

      $data['title'] = 'Account Profile | Chenna';

      $this->load->view('web/include/header', $data);
      $this->load->view('web/account_profile');
      $this->load->view('web/include/footer');
    } else
    {
      // Handle profile update
      $fileName = $_FILES["profile"]["name"] ?? '';
      if (!empty($fileName))
      {
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $uniqueName = 'Profile_' . uniqid() . '.' . $extension;
        $tmp_name = $_FILES['profile']['tmp_name'];
        $targetlocation = PROFILE_DIRECTORY . $uniqueName;
        move_uploaded_file($tmp_name, $targetlocation);
        $data['profile_pic'] = utf8_encode(trim($uniqueName));

        // Update session immediately
        $userDataSession = $this->session->userdata('User');
        $userDataSession['profile_pic'] = $data['profile_pic'];
        $this->session->set_userdata('User', $userDataSession);
      }

      $this->db->where('id', $userData['id']);
      $row = $this->db->update('user_master', $data);

      // Update username in session
      $userDatasession = $this->session->userdata('User');
      $userDatasession['username'] = $data['username'];
      $this->session->set_userdata('User', $userDatasession);

      if ($row > 0)
      {
        $this->session->set_flashdata('activate_m', '<div class="alert alert-success alert-dismissible">Profile updated successfully.</div>');
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
      $data['title'] = 'Account Address List | Chenna';
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
      $data['title'] = 'Add Address | Chenna';
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
      $data['title'] = 'Update Address | Chenna';
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
    $postData = $this->input->post();
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
      $message = "Dear customer, Your Order no. -" . $order_number . ", has been cancelled and please contact with our Support team.Thanks .Regards , Chenna Real Time Private Limited , www.Chenna.in ";
      $tempID = '1007492296258821177';
      $this->load->helper('/email/temp5');
      $status = "Order Cancelled";
      $email_text = "Your order no. " . $order_number . " has been cancelled and please contact with our Support team.Thanks .Regards , Chenna Real Time Private Limited , www.Chenna.in ";
      $email_body = temp5($status, $user, $email_text, "https://Chenna.in");
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
    // CURLOPT_URL => "https://manage.ithinklogistics.com/api_v3/pincode/check.json",
    // CURLOPT_RETURNTRANSFER => true,
    // CURLOPT_ENCODING => "",
    // CURLOPT_MAXREDIRS => 10,
    // CURLOPT_TIMEOUT => 30,
    // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    // CURLOPT_CUSTOMREQUEST => "POST",
    // CURLOPT_POSTFIELDS => $json_data,
    // CURLOPT_HTTPHEADER => array(
    // "cache-control: no-cache",
    // "content-type: application/json"
    // ),
    // )
    // );
    // $response = curl_exec($curl);
    // $err = curl_error($curl);
    // curl_close($curl);
    // if ($err) {
    // echo '2';
    // exit;
    // } else {
    // $json_respons = json_decode($response, true);
    // $city_name = $json_respons['data'][$pincode]['city_name'];
    // if (!empty($city_name)) {
    // echo '1';
    // exit;
    // } else {
    // echo '2';
    // exit;
    // }
    // }
    $query = $this->db->get_where('pin_code_master', array('pin_code' => $pincode, 'status' => 1));

    if ($query->num_rows() > 0)
    {

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
    $data['title'] = 'Account Payment | Chenna';
    $this->load->view('web/include/header', $data);
    $this->load->view('web/account_payment');
    $this->load->view('web/include/footer');
  }
  public function blog()
  {
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['title'] = 'Blog | Chenna';
    $this->load->view('web/include/header', $data);
    $this->load->view('web/blog');
    $this->load->view('web/include/footer');
  }
  public function account_delete_req()
  {

    $this->load->view('web/delete_acc_req');
  }
  public function blog_list()
  {
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['title'] = 'Blog List | Chenna';
    $this->load->view('web/include/header', $data);
    $this->load->view('web/blog_list');
    $this->load->view('web/include/footer');
  }
  public function forgot_password()
  {
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['title'] = 'Forgot Password | Chenna';
    $this->load->view('web/include/header', $data);
    $this->load->view('web/forgot_password');
    $this->load->view('web/include/footer');
  }
  public function login_registration()
  {
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['title'] = 'Login Registration | Chenna';
    $this->load->view('web/include/header', $data);
    $this->load->view('web/login_registration');
    $this->load->view('web/include/footer');
  }
  public function cart()
  {
    $userData = $this->session->userdata('User');
    $user_id = !empty($userData) ? $userData['id'] : 0;

    $data['wishlist_count'] = !empty($user_id)
      ? $this->web_model->get_total_wishlist_by_user($user_id)
      : 0;

    $cart_items = $this->cart->contents();
    $gst_list = [];
    $product_ids = [];

    foreach ($cart_items as $item)
    {
      $gst_data = $this->web_model->get_gst($item['id']);
      $gst_list[$item['id']] = $gst_data ? $gst_data->gst : 0;
      $product_ids[] = $item['id'];
    }

    $data['gst_list'] = $gst_list;

    // Fetch Active Coupons Only
    $today = date('Y-m-d H:i:s');

    $this->db->where('status', 1);
    $this->db->where('start_date <=', $today);
    $this->db->where('end_date >=', $today);
    $all_coupons = $this->db->get('coupon_manager_master')->result_array();

    $valid = [];

    foreach ($all_coupons as $c)
    {
      if (!empty($c['product_ids']))
      {
        $cp = explode(',', $c['product_ids']);
        if (array_intersect($product_ids, $cp))
        {
          $valid[] = $c;
        }
      } else
      {
        $valid[] = $c;
      }
    }

    $data['coupons'] = $valid;
    $data['applied_coupon'] = $this->session->userdata('applied_coupon');

    $this->load->view('web/include/header', $data);
    $this->load->view('web/cart', $data);
    $this->load->view('web/include/footer');
  }



  public function applycoupon()
  {
    $code = $this->input->post('coupon_code');
    $userData = $this->session->userdata('User');
    $user_id = $userData['id'] ?? 0;

    if (empty($code))
    {
      echo json_encode(['status' => 'error', 'message' => 'Enter coupon code']);
      return;
    }

    $coupon = $this->web_model->get_coupon_by_code($code);

    if (!$coupon)
    {
      echo json_encode(['status' => 'error', 'message' => 'Invalid or expired coupon']);
      return;
    }

    $today = date('Y-m-d H:i:s');
    if ($coupon['start_date'] > $today || $coupon['end_date'] < $today || $coupon['status'] != 1)
    {
      echo json_encode(['status' => 'error', 'message' => 'Coupon expired or inactive']);
      return;
    }

    if (!empty($user_id))
    {
      $used = $this->db->get_where('coupon_validity_master', [
        'user_id' => $user_id,
        'coupon_id' => $coupon['id']
      ])->row_array();

      if ($used)
      {
        echo json_encode(['status' => 'error', 'message' => 'You have already used this coupon']);
        return;
      }
    }


    $totalUsed = $this->db->where('coupon_id', $coupon['id'])
      ->from('coupon_validity_master')
      ->count_all_results();
    if ($totalUsed >= $coupon['usage_limit_total'])
    {
      echo json_encode(['status' => 'error', 'message' => 'Coupon usage limit reached']);
      return;
    }
    $this->session->set_userdata('applied_coupon', $coupon);
    echo json_encode(['status' => 'success', 'message' => 'Coupon applied']);
  }




  public function removecoupon()
  {
    $this->session->unset_userdata('applied_coupon');
    echo json_encode(['status' => 'success']);
  }


  // public function checkout()
  // {
  //   $userData = $this->session->userdata('User');
  //   if (empty($userData))
  //   {
  //     redirect('web/login');
  //   }
  //   $user_id = $userData['id'];

  //   // ---------------------------
  //   // 1) Header & basic data
  //   // ---------------------------
  //   $data['wishlist_count'] = $this->web_model->get_total_wishlist_by_user($user_id);
  //   $data['userInfo'] = $this->db->get_where('user_master', ['id' => $user_id])->row_array();
  //   $data['bannerList'] = $this->web_model->getBannerList();
  //   $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
  //   $data['getData'] = $this->db->get_where('user_address_master', ['user_master_id' => $user_id])->result_array();
  //   $data['address_data'] = $this->db->get_where('user_address_master', ['user_master_id' => $user_id])->row_array();
  //   $data['title'] = 'Checkout | Chenna';

  //   // ---------------------------
  //   // 2) Checkout items
  //   // ---------------------------
  //   $checkout_items = [];
  //   $buyNow = $this->session->userdata('buy_now');

  //   if (!empty($buyNow))
  //   {
  //     $product = $this->db->get_where('sub_product_master', ['id' => $buyNow['pro_id']])->row_array();
  //     $gst_percent = !empty($product['gst']) ? $product['gst'] : 0;
  //     $checkout_items[] = [
  //       'id' => $product['id'],
  //       'name' => $product['product_name'],
  //       'final_price' => $product['final_price'],
  //       'image' => $product['main_image'],
  //       'size' => $product['size'],
  //       'qty' => $buyNow['qty'],
  //       'gst' => $gst_percent,
  //       'vendor_id' => $product['vendor_id'] ?? null,
  //       'promoter_id' => $product['promoter_id'] ?? null
  //     ];
  //   } else
  //   {
  //     foreach ($this->cart->contents() as $item)
  //     {
  //       $product = $this->db->get_where('sub_product_master', ['id' => $item['id']])->row_array();
  //       $gst_percent = !empty($product['gst']) ? $product['gst'] : 0;
  //       $checkout_items[] = [
  //         'id' => $item['id'],
  //         'name' => $item['name'],
  //         'final_price' => $item['final_price'],
  //         'image' => $item['image'],
  //         'size' => $item['size'] ?? '',
  //         'qty' => $item['qty'],
  //         'gst' => $gst_percent,
  //         'vendor_id' => $product['vendor_id'] ?? null,
  //         'promoter_id' => $product['promoter_id'] ?? null
  //       ];
  //     }
  //   }

  //   $data['checkout_items'] = $checkout_items;
  //   $this->session->set_userdata('checkout_items', $checkout_items);

  //   // ---------------------------
  //   // 3) Coupon handling
  //   // ---------------------------
  //   $coupon = $this->session->userdata('applied_coupon') ?? null;
  //   $total_cost = 0;

  //   foreach ($checkout_items as $item)
  //   {
  //     $total_cost += $item['final_price'] * $item['qty'];
  //   }

  //   $coupon_discount = 0;
  //   if (!empty($coupon))
  //   {
  //     if ($coupon['discount_type'] == 'percent')
  //     {
  //       $coupon_discount = ($coupon['discount_value'] / 100) * $total_cost;
  //       if (!empty($coupon['max_discount_amount']) && $coupon_discount > $coupon['max_discount_amount'])
  //       {
  //         $coupon_discount = $coupon['max_discount_amount'];
  //       }
  //     } else
  //     {
  //       $coupon_discount = $coupon['discount_value'];
  //     }
  //   }

  //   $subtotal_after_coupon = $total_cost - $coupon_discount;

  //   // ---------------------------
  //   // 4) GST calculation on discounted subtotal
  //   // ---------------------------
  //   $gst_total = 0;
  //   foreach ($checkout_items as $item)
  //   {
  //     $item_total = $item['final_price'] * $item['qty'];
  //     $item_discount = ($item_total / $total_cost) * $coupon_discount; // proportional discount
  //     $gst_percent = $item['gst'] ?? 18;
  //     $gst_total += ($item_total - $item_discount) * ($gst_percent / 100);
  //   }

  //   // ---------------------------
  //   // 5) Shipping
  //   // ---------------------------
  //   $OrderSettings = $this->db->get_where('settings', ['id' => '1'])->row_array();
  //   $shipping = ($subtotal_after_coupon > $OrderSettings['min_order_bal']) ? 0 : $OrderSettings['shipping_amount'];

  //   $grand_total = $subtotal_after_coupon + $gst_total + $shipping;

  //   // ---------------------------
  //   // 6) Pass all totals to view
  //   // ---------------------------
  //   $data['total_cost'] = $total_cost;
  //   $data['coupon_discount'] = $coupon_discount;
  //   $data['subtotal_after_coupon'] = $subtotal_after_coupon;
  //   $data['gst_total'] = $gst_total;
  //   $data['shipping'] = $shipping;
  //   $data['grand_total'] = $grand_total;

  //   $this->load->view('web/include/header', $data);
  //   $this->load->view('web/checkout', $data);
  //   $this->load->view('web/include/footer');
  // }



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

  // public function checkout()
  // {
  //   $userData = $this->session->userdata('User');
  //   if (empty($userData))
  //   {
  //     redirect('web/login');
  //   }
  //   $user_id = $userData['id'];

  //   // Header ke liye common data
  //   $data['wishlist_count'] = $this->web_model->get_total_wishlist_by_user($user_id);
  //   $data['userInfo'] = $this->db->get_where('user_master', ['id' => $user_id])->row_array();
  //   $data['bannerList'] = $this->web_model->getBannerList();
  //   $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
  //   $data['getData'] = $this->db->get_where('user_address_master', ['user_master_id' => $user_id])->result_array();
  //   $data['title'] = 'Checkout | Chenna';

  //   // ===================== CHECKOUT ITEMS BANAYE =====================
  //   $checkout_items = [];
  //   $buyNow = $this->session->userdata('buy_now');

  //   if (!empty($buyNow) && !empty($buyNow['pro_id']))
  //   {
  //     $product = $this->db->get_where('sub_product_master', ['id' => $buyNow['pro_id']])->row_array();
  //     if ($product)
  //     {
  //       $checkout_items[] = [
  //         'id' => $product['id'],
  //         'name' => $product['product_name'],
  //         'final_price' => $product['final_price'],
  //         'image' => $product['main_image'],
  //         'size' => $product['size'] ?? '',
  //         'qty' => (int) $buyNow['qty'],
  //         'gst' => $product['gst'] ?? 0,
  //         'vendor_id' => $product['vendor_id'] ?? null,
  //         'promoter_id' => $product['promoter_id'] ?? null
  //       ];
  //     }
  //   } else
  //   {
  //     foreach ($this->cart->contents() as $item)
  //     {
  //       $product = $this->db->get_where('sub_product_master', ['id' => $item['id']])->row_array();
  //       if ($product)
  //       {
  //         $checkout_items[] = [
  //           'id' => $item['id'],
  //           'name' => $item['name'],
  //           'final_price' => $item['final_price'],
  //           'image' => $item['image'],
  //           'size' => $item['size'] ?? '',
  //           'qty' => $item['qty'],
  //           'gst' => $product['gst'] ?? 0,
  //           'vendor_id' => $product['vendor_id'] ?? null,
  //           'promoter_id' => $product['promoter_id'] ?? null
  //         ];
  //       }
  //     }
  //   }

  //   // Agar cart khali hai to home pe bhej do
  //   if (empty($checkout_items))
  //   {
  //     redirect('web/cart');
  //   }

  //   // Session mein save karo taaki payment page pe use ho sake
  //   $this->session->set_userdata('checkout_items', $checkout_items);

  //   // ===================== CALCULATIONS =====================
  //   $total_cost = 0;
  //   foreach ($checkout_items as $item)
  //   {
  //     $total_cost += $item['final_price'] * $item['qty'];
  //   }

  //   // Coupon
  //   $applied_coupon = $this->session->userdata('applied_coupon');
  //   $coupon_discount = 0;
  //   if (!empty($applied_coupon))
  //   {
  //     if ($applied_coupon['discount_type'] == 'percent')
  //     {
  //       $coupon_discount = ($applied_coupon['discount_value'] / 100) * $total_cost;
  //       if (!empty($applied_coupon['max_discount_amount']) && $coupon_discount > $applied_coupon['max_discount_amount'])
  //       {
  //         $coupon_discount = $applied_coupon['max_discount_amount'];
  //       }
  //     } else
  //     {
  //       $coupon_discount = $applied_coupon['discount_value'];
  //     }
  //   }

  //   $subtotal_after_coupon = $total_cost - $coupon_discount;

  //   // GST calculation (discounted price pe)
  //   $gst_total = 0;
  //   foreach ($checkout_items as $item)
  //   {
  //     $item_total = $item['final_price'] * $item['qty'];
  //     $item_discount = ($total_cost > 0) ? ($item_total / $total_cost) * $coupon_discount : 0;
  //     $gst_total += ($item_total - $item_discount) * ($item['gst'] / 100);
  //   }

  //   // Shipping
  //   $settings = $this->db->get_where('settings', ['id' => 1])->row_array();
  //   $shipping = ($subtotal_after_coupon >= $settings['min_order_bal']) ? 0 : $settings['shipping_amount'];

  //   $grand_total = $subtotal_after_coupon + $gst_total + $shipping;

  //   // View ko data pass karo
  //   $data['checkout_items'] = $checkout_items;
  //   $data['total_cost'] = $total_cost;
  //   $data['coupon_discount'] = $coupon_discount;
  //   $data['subtotal_after_coupon'] = $subtotal_after_coupon;
  //   $data['gst_total'] = $gst_total;
  //   $data['shipping'] = $shipping;
  //   $data['grand_total'] = $grand_total;
  //   $data['applied_coupon'] = $applied_coupon;

  //   $this->load->view('web/include/header', $data);
  //   $this->load->view('web/checkout', $data);
  //   $this->load->view('web/include/footer');
  // }

  // public function checkout_payment()
  // {
  //   $userData = $this->session->userdata('User');
  //   $data['wishlist_count'] = !empty($userData) ? $this->web_model->get_total_wishlist_by_user($userData['id']) : 0;
  //   if (empty($userData))
  //   {
  //     redirect('web/login');
  //   }

  //   $user_id = $userData['id'];
  //   $address_id = $this->input->post('address_id');
  //   $paymentType = $this->input->post('paymentType') ?? 1; // 1=COD, 2=Online
  //   $tid = $this->input->post('tid'); // Frontend se aayega online payment ke liye

  //   if (empty($address_id))
  //   {
  //     $this->session->set_flashdata('error', 'Please select a delivery address.');
  //     redirect('web/checkout');
  //   }

  //   // Address verify karo
  //   $address = $this->db->get_where('user_address_master', [
  //     'id' => $address_id,
  //     'user_master_id' => $user_id
  //   ])->row_array();

  //   if (empty($address))
  //   {
  //     $this->session->set_flashdata('error', 'Invalid address selected.');
  //     redirect('web/checkout');
  //   }

  //   // Checkout items session se lo (checkout() mein save kiya tha)
  //   $checkout_items = $this->session->userdata('checkout_items') ?? [];
  //   if (empty($checkout_items))
  //   {
  //     redirect('web/checkout');
  //   }

  //   // Same calculations as checkout() — duplicate avoid karne ke liye function bana sakte ho baad mein
  //   $total_cost = 0;
  //   foreach ($checkout_items as $item)
  //   {
  //     $total_cost += $item['final_price'] * $item['qty'];
  //   }

  //   $applied_coupon = $this->session->userdata('applied_coupon');
  //   $coupon_discount = 0;
  //   if (!empty($applied_coupon))
  //   {
  //     if ($applied_coupon['discount_type'] == 'percent')
  //     {
  //       $coupon_discount = ($applied_coupon['discount_value'] / 100) * $total_cost;
  //       if (!empty($applied_coupon['max_discount_amount']) && $coupon_discount > $applied_coupon['max_discount_amount'])
  //       {
  //         $coupon_discount = $applied_coupon['max_discount_amount'];
  //       }
  //     } else
  //     {
  //       $coupon_discount = $applied_coupon['discount_value'];
  //     }
  //   }

  //   $subtotal_after_coupon = $total_cost - $coupon_discount;

  //   $gst_total = 0;
  //   foreach ($checkout_items as $item)
  //   {
  //     $item_total = $item['final_price'] * $item['qty'];
  //     $item_discount = ($total_cost > 0) ? ($item_total / $total_cost) * $coupon_discount : 0;
  //     $gst_total += ($item_total - $item_discount) * ($item['gst'] / 100);
  //   }

  //   $settings = $this->db->get_where('settings', ['id' => 1])->row_array();
  //   $shipping = ($subtotal_after_coupon >= $settings['min_order_bal']) ? 0 : $settings['shipping_amount'];

  //   $grand_total = $subtotal_after_coupon + $gst_total + $shipping;

  //   // Data view ko pass karo
  //   $data = [
  //     'title' => 'Payment | Chenna',
  //     'address_data' => $address,
  //     'checkout_items' => $checkout_items,
  //     'applied_coupon' => $applied_coupon,
  //     'coupon_discount_amount' => $coupon_discount,
  //     'subtotal_after_coupon' => $subtotal_after_coupon,
  //     'gst_total' => $gst_total,
  //     'shipping' => $shipping,
  //     'grand_total' => $grand_total,
  //     'paymentType' => $paymentType,
  //     'tid' => $tid
  //   ];

  //   $this->load->view('web/include/header', $data);
  //   $this->load->view('web/checkout_payment', $data);
  //   $this->load->view('web/include/footer');
  // }

  public function checkout()
  {
    $userData = $this->session->userdata('User');
    if (empty($userData))
    {
      redirect('web/login');
    }

    $user_id = $userData['id'];

    /* ================= HEADER DATA ================= */
    $data['wishlist_count'] = $this->web_model->get_total_wishlist_by_user($user_id);
    $data['userInfo'] = $this->db->get_where('user_master', ['id' => $user_id])->row_array();
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['getData'] = $this->db
      ->get_where('user_address_master', ['user_master_id' => $user_id])
      ->result_array();
    $data['title'] = 'Checkout | Chenna';

    /* ================= BUILD CHECKOUT ITEMS ================= */
    $checkout_items = [];
    $buyNow = $this->session->userdata('buy_now');

    if (!empty($buyNow) && !empty($buyNow['pro_id']))
    {

      $product = $this->db->where([
        'id' => $buyNow['pro_id'],
        'status' => 1,
        'seller_approve_status' => 1,
        'verify_status' => 1
      ])->get('sub_product_master')->row_array();

      if ($product)
      {
        $checkout_items[] = [
          'id' => $product['id'],
          'name' => $product['product_name'],
          'final_price' => $product['final_price'],
          'image' => $product['main_image'],
          'size' => $product['size'] ?? '',
          'qty' => (int) $buyNow['qty'],
          'gst' => $product['gst'] ?? 0,
          'vendor_id' => $product['vendor_id'] ?? null,
          'promoter_id' => $product['promoter_id'] ?? null,
          'cash_on_delivery' => $product['cash_on_delivery']
        ];
      }

    } else
    {

      foreach ($this->cart->contents() as $item)
      {

        $product = $this->db->where([
          'id' => $item['id'],
          'status' => 1,
          'seller_approve_status' => 1,
          'verify_status' => 1
        ])->get('sub_product_master')->row_array();

        if (!$product)
        {
          continue;
        }

        $checkout_items[] = [
          'id' => $product['id'],
          'name' => $product['product_name'],
          'final_price' => $product['final_price'],
          'image' => $product['main_image'],
          'size' => $item['size'] ?? '',
          'qty' => $item['qty'],
          'gst' => $product['gst'] ?? 0,
          'vendor_id' => $product['vendor_id'] ?? null,
          'promoter_id' => $product['promoter_id'] ?? null,
          'cash_on_delivery' => $product['cash_on_delivery']
        ];
      }
    }

    if (empty($checkout_items))
    {
      redirect('web/cart');
    }

    /* ================= COD AVAILABILITY CHECK ================= */
    $cod_available = true;
    foreach ($checkout_items as $item)
    {
      if ($item['cash_on_delivery'] == 0)
      {
        $cod_available = false;
        break;
      }
    }

    // Save for payment page
    $this->session->set_userdata('checkout_items', $checkout_items);
    $this->session->set_userdata('cod_available', $cod_available);

    /* ================= CALCULATIONS ================= */
    $total_cost = 0;
    foreach ($checkout_items as $item)
    {
      $total_cost += $item['final_price'] * $item['qty'];
    }

    $applied_coupon = $this->session->userdata('applied_coupon');
    $coupon_discount = 0;

    if (!empty($applied_coupon))
    {
      if ($applied_coupon['discount_type'] == 'percent')
      {
        $coupon_discount = ($applied_coupon['discount_value'] / 100) * $total_cost;
        if (
          !empty($applied_coupon['max_discount_amount']) &&
          $coupon_discount > $applied_coupon['max_discount_amount']
        )
        {
          $coupon_discount = $applied_coupon['max_discount_amount'];
        }
      } else
      {
        $coupon_discount = $applied_coupon['discount_value'];
      }
    }

    $subtotal_after_coupon = $total_cost - $coupon_discount;

    $gst_total = 0;
    foreach ($checkout_items as $item)
    {
      $item_total = $item['final_price'] * $item['qty'];
      $item_discount = ($total_cost > 0)
        ? ($item_total / $total_cost) * $coupon_discount
        : 0;
      $gst_total += ($item_total - $item_discount) * ($item['gst'] / 100);
    }

    $settings = $this->db->get_where('settings', ['id' => 1])->row_array();
    $shipping = ($subtotal_after_coupon >= $settings['min_order_bal'])
      ? 0
      : $settings['shipping_amount'];

    $grand_total = $subtotal_after_coupon + $gst_total + $shipping;

    /* ================= PASS TO VIEW ================= */
    $data['checkout_items'] = $checkout_items;
    $data['total_cost'] = $total_cost;
    $data['coupon_discount'] = $coupon_discount;
    $data['subtotal_after_coupon'] = $subtotal_after_coupon;
    $data['gst_total'] = $gst_total;
    $data['shipping'] = $shipping;
    $data['grand_total'] = $grand_total;
    $data['applied_coupon'] = $applied_coupon;
    $data['cod_available'] = $cod_available;

    $this->load->view('web/include/header', $data);
    $this->load->view('web/checkout', $data);
    $this->load->view('web/include/footer');
  }

  public function checkout_payment()
  {
    $userData = $this->session->userdata('User');
    if (empty($userData))
    {
      redirect('web/login');
    }

    $user_id = $userData['id'];
    $data['wishlist_count'] = $this->web_model->get_total_wishlist_by_user($user_id);

    $address_id = $this->input->post('address_id');
    $paymentType = $this->input->post('paymentType') ?? 1; // 1=COD, 2=Online
    $tid = $this->input->post('tid');

    if (empty($address_id))
    {
      redirect('web/checkout');
    }

    $address = $this->db->get_where('user_address_master', [
      'id' => $address_id,
      'user_master_id' => $user_id
    ])->row_array();

    if (empty($address))
    {
      redirect('web/checkout');
    }

    $checkout_items = $this->session->userdata('checkout_items') ?? [];
    if (empty($checkout_items))
    {
      redirect('web/checkout');
    }

    /* ================= COD AVAILABILITY CHECK ================= */
    $cod_available = true;

    foreach ($checkout_items as $item)
    {
      // sub_product_master se cash_on_delivery aata hona chahiye
      if (isset($item['cash_on_delivery']) && $item['cash_on_delivery'] == 0)
      {
        $cod_available = false;
        break;
      }
    }

    // Agar COD select hai but allowed nahi
    if ($paymentType == 1 && !$cod_available)
    {
      $paymentType = 2; // force online
    }

    /* ================= CALCULATIONS ================= */
    $total_cost = 0;
    foreach ($checkout_items as $item)
    {
      $total_cost += $item['final_price'] * $item['qty'];
    }

    $coupon = $this->session->userdata('applied_coupon');
    $coupon_discount = 0;

    if (!empty($coupon))
    {
      if ($coupon['discount_type'] == 'percent')
      {
        $coupon_discount = ($coupon['discount_value'] / 100) * $total_cost;
        if (!empty($coupon['max_discount_amount']) && $coupon_discount > $coupon['max_discount_amount'])
        {
          $coupon_discount = $coupon['max_discount_amount'];
        }
      } else
      {
        $coupon_discount = $coupon['discount_value'];
      }
    }

    $subtotal_after_coupon = $total_cost - $coupon_discount;

    $gst_total = 0;
    foreach ($checkout_items as $item)
    {
      $item_total = $item['final_price'] * $item['qty'];
      $item_discount = ($total_cost > 0)
        ? ($item_total / $total_cost) * $coupon_discount
        : 0;

      $gst_total += ($item_total - $item_discount) * ($item['gst'] / 100);
    }

    $settings = $this->db->get_where('settings', ['id' => 1])->row_array();
    $shipping = ($subtotal_after_coupon >= $settings['min_order_bal'])
      ? 0
      : $settings['shipping_amount'];

    $grand_total = $subtotal_after_coupon + $gst_total + $shipping;

    $data += [
      'title' => 'Payment | Chenna',
      'address_data' => $address,
      'checkout_items' => $checkout_items,
      'coupon_discount_amount' => $coupon_discount,
      'subtotal_after_coupon' => $subtotal_after_coupon,
      'gst_total' => $gst_total,
      'shipping' => $shipping,
      'grand_total' => $grand_total,
      'paymentType' => $paymentType,
      'tid' => $tid,
      'cod_available' => $cod_available
    ];

    $this->load->view('web/include/header', $data);
    $this->load->view('web/checkout_payment', $data);
    $this->load->view('web/include/footer');
  }


  public function get_wishlist_count()
  {
    $userData = $this->session->userdata('User');

    if (empty($userData) || empty($userData['id']))
    {
      echo json_encode(['count' => 0]);
      return;
    }

    $user_id = $userData['id'];

    $count = $this->db->where('user_id', $user_id)
      ->count_all_results('wishlist'); // ✔ correct table

    echo json_encode(['count' => $count]);
  }

  public function vendorlist()
  {
    $userData = $this->session->userdata('User');
    $data['wishlist_count'] = !empty($userData) ? $this->web_model->get_total_wishlist_by_user($userData['id']) : 0;
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['vendors'] = $this->web_model->get_vendors_with_product_count();


    // ✅ Correct DISTINCT usage
    $states = $this->db->distinct()->select('state')->from('vendors')->where('status', 1)->get()->result_array();
    $cities = $this->db->distinct()->select('city')->from('vendors')->where('status', 1)->get()->result_array();

    $data['states'] = array_column($states, 'state');
    $data['cities'] = array_column($cities, 'city');

    $data['title'] = 'Vendor-List | Chenna';
    $this->load->view('web/include/header', $data);
    $this->load->view('web/vendorlist', $data);
    $this->load->view('web/include/footer');
  }

  public function filter_vendors()
  {
    $state = $this->input->post('state');
    $city = $this->input->post('city');
    $search = $this->input->post('search');
    $vendors = $this->web_model->get_vendors_with_product_count($state, $city, $search);
    $html = $this->load->view('web/vendorsingle', ['vendors' => $vendors], true);

    echo json_encode(['html' => $html]);
  }

  // Load Vendor Products Section (AJAX)
  public function vendor_products_section()
  {
    $vendor_id = $this->input->post('vendor_id');

    if (!$vendor_id)
    {
      echo '<p class="text-danger text-center">Vendor not found</p>';
      return;
    }

    $data['vendor_id'] = $vendor_id;
    $data['categories'] = $this->web_model->get_categories();
    $data['sub_categories'] = $this->web_model->get_sub_categories();
    $data['sizes'] = $this->web_model->get_vendor_all_sizes($vendor_id);
    $data['products'] = $this->web_model->get_vendor_products($vendor_id);

    $this->load->view('web/vendor_products_section', $data);
  }
  public function get_subcategories_by_category()
  {
    $category_ids = $this->input->post('category_ids');

    if (empty($category_ids))
    {
      echo json_encode([]);
      return;
    }

    $data = $this->db
      ->where_in('category_master_id', $category_ids) // ✅ FIXED
      ->where('status', 1)
      ->get('sub_category_master')
      ->result_array();

    echo json_encode($data);
  }





  // Filter Vendor Products (AJAX)

  public function filter_vendor_products()
  {
    // Read filter inputs from POST
    $filter = [
      'vendor_id' => $this->input->post('vendor_id'),
      'category_id' => $this->input->post('category'),
      'sub_category' => $this->input->post('sub_category'),
      'size' => $this->input->post('size'),
      'price' => $this->input->post('price'),
      'rating' => $this->input->post('rating')
    ];

    // Vendor ID is required
    if (empty($filter['vendor_id']))
    {
      echo '<p class="text-danger text-center">Vendor missing</p>';
      return;
    }

    // Get filtered products from model
    $data['products'] = $this->web_model->filter_vendor_products($filter);

    // Load the partial view
    $this->load->view('web/vendor_product_list', $data);
  }






  /* FILTER PRODUCTS */

  public function tersms_conditions()
  {
    $data['title'] = 'Terms & Conditions | Chenna';
    $this->load->view('web/include/header', $data);
    $this->load->view('web/tersms_conditions');
    $this->load->view('web/include/footer');
  }

  public function about()
  {
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['title'] = 'About-Us | Chenna';
    $this->load->view('web/include/header', $data);
    $this->load->view('web/about');
    $this->load->view('web/include/footer');
  }
  public function contact()
  {
    $data = $this->input->post();
    if (empty($data))
    {
      $data['bannerList'] = $this->web_model->getBannerList();
      $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
      $data['title'] = 'Contact-Us | Chenna';
      $this->load->view('web/include/header', $data);
      $this->load->view('web/contact');
      $this->load->view('web/include/footer');
    } else
    {
      $row = $this->db->insert('enquiry_master', $data);
      if ($row > 0)
      {
        $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button>Thanks! For contacting Chenna.
          We will contact you soon</div></div>');
        redirect('web/contact');
      }
    }
  }
  public function faq()
  {
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['title'] = 'FAQ | Chenna';
    $this->load->view('web/include/header', $data);
    $this->load->view('web/faq');
    $this->load->view('web/include/footer');
  }
  public function help()
  {
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['title'] = 'Help | Chenna';
    $this->load->view('web/include/header', $data);
    $this->load->view('web/help');
    $this->load->view('web/include/footer');
  }
  public function faq_help_request()
  {
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['title'] = 'FAQ Help Request | Chenna';
    $this->load->view('web/include/header', $data);
    $this->load->view('web/faq_help_request');
    $this->load->view('web/include/footer');
  }
  public function terms_condition()
  {
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['title'] = 'Term Conditions | Chenna';
    $this->load->view('web/include/header', $data);
    $this->load->view('web/terms&condition');
    $this->load->view('web/include/footer');
  }
  public function terms_conditions()
  {
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['title'] = 'Privacy Policy | Chenna';
    $this->load->view('web/include/header', $data);
    $this->load->view('web/terms_conditions');
    $this->load->view('web/include/footer');
  }
  public function privacy_policy()
  {
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['title'] = 'Privacy Policy | Chenna';
    $this->load->view('web/include/header', $data);
    $this->load->view('web/privacy_policy');
    $this->load->view('web/include/footer');
  }
  public function refund_policy()
  {
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['title'] = 'Refund Policy | Chenna';
    $this->load->view('web/include/header', $data);
    $this->load->view('web/refund_policy');
    $this->load->view('web/include/footer');
  }
  public function cancellation_policy()
  {
    $data['bannerList'] = $this->web_model->getBannerList();
    $data['MainCategoryList'] = $this->web_model->getMainCategoryList();
    $data['title'] = 'Privacy Policy | Chenna';
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
    $data['title'] = 'Order Success | Chenna';
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

    $text = 'Dear ' . $staff['name'] . ' Your Mobile Verification OTP is: ' . $mobile_otp . ' Please enter this OTP to verify your mobile number. From www.Chenna.inRegardsChenna Real Time Private Limited';
    $this->load->helper('/email/temp9');
    $status = 'Email Verification';
    $user = $staff['name'];
    $email_text = $email_otp . ' is your email verification OTP. Please use this otp for the verification of your email id with Chenna.';
    $email_body = temp9($status, $user, $email_text);
    $subject = 'Email Verification OTP';
    sendSMS($staff['mobile'], $text, '1007086055987083292');

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

  // public function order_complete()
  // {
  //   $data = $this->input->post();
  //   $userData = $this->session->userdata('User');

  //   /* ================= USER CHECK ================= */
  //   if (empty($userData))
  //   {
  //     redirect('web/login');
  //     return;
  //   }

  //   $userId = $userData['id'];
  //   $buyNow = $this->session->userdata('buy_now');
  //   $applied_coupon = $this->session->userdata('applied_coupon');
  //   $coupon_discount_amount = 0;

  //   /* ================= PAYMENT TYPE ================= */
  //   $paymentType = (int) ($data['paymentType'] ?? 1); // 1 = COD, 2 = Online

  //   /* ================= TABLE SELECTION ================= */
  //   $order_table = ($paymentType === 2) ? 'order_master2' : 'order_master';
  //   $purchase_table = ($paymentType === 2) ? 'purchase_master2' : 'purchase_master';
  //   $address_table = ($paymentType === 2) ? 'order_address_master2' : 'order_address_master';

  //   /* ================= GET ITEMS ================= */
  //   $total_items = [];
  //   if (!empty($buyNow['pro_id']))
  //   {
  //     $prod = $this->db->get_where('sub_product_master', ['id' => $buyNow['pro_id']])->row_array();
  //     if (empty($prod))
  //     {
  //       redirect('web/cart');
  //       return;
  //     }
  //     $total_items[] = [
  //       'id' => $prod['id'],
  //       'name' => $prod['product_name'],
  //       'price' => $prod['price'],
  //       'final_price' => $prod['final_price'],
  //       'gst' => $prod['gst'],
  //       'qty' => (int) $buyNow['qty'],
  //       'size' => $prod['size'],
  //       'color' => $prod['color'],
  //       'main_image' => $prod['main_image'],
  //       'product_hsn' => $prod['product_hsn'],
  //       'sku_code' => $prod['sku_code'],
  //       'vendor_id' => $prod['vendor_id'],
  //       'promoter_id' => $prod['promoter_id']
  //     ];
  //   } else
  //   {
  //     $cart_contents = $this->cart->contents();
  //     if (empty($cart_contents))
  //     {
  //       redirect(base_url());
  //       return;
  //     }
  //     foreach ($cart_contents as $c)
  //     {
  //       $prod = $this->db->get_where('sub_product_master', ['id' => $c['id']])->row_array();
  //       if (empty($prod))
  //       {
  //         redirect('web/cart');
  //         return;
  //       }
  //       $total_items[] = [
  //         'id' => $c['id'],
  //         'name' => $c['name'],
  //         'price' => $c['price'],
  //         'final_price' => $c['final_price'],
  //         'gst' => $prod['gst'],
  //         'qty' => $c['qty'],
  //         'size' => $prod['size'],
  //         'color' => $prod['color'],
  //         'main_image' => $prod['main_image'],
  //         'product_hsn' => $prod['product_hsn'],
  //         'sku_code' => $prod['sku_code'],
  //         'vendor_id' => $prod['vendor_id'],
  //         'promoter_id' => $prod['promoter_id']
  //       ];
  //     }
  //   }

  //   /* ================= TOTAL ================= */
  //   $total_price = 0;
  //   foreach ($total_items as $itm)
  //   {
  //     $total_price += $itm['final_price'] * $itm['qty'];
  //   }

  //   /* ================= COUPON ================= */
  //   if (!empty($applied_coupon))
  //   {
  //     if ($applied_coupon['discount_type'] === 'percent')
  //     {
  //       $coupon_discount_amount = ($applied_coupon['discount_value'] / 100) * $total_price;
  //       if (
  //         !empty($applied_coupon['max_discount_amount']) &&
  //         $coupon_discount_amount > $applied_coupon['max_discount_amount']
  //       )
  //       {
  //         $coupon_discount_amount = $applied_coupon['max_discount_amount'];
  //       }
  //     } else
  //     {
  //       $coupon_discount_amount = $applied_coupon['discount_value'];
  //     }
  //   }
  //   $subtotal_after_coupon = $total_price - $coupon_discount_amount;

  //   /* ================= GST ================= */
  //   $gst_total = 0;
  //   foreach ($total_items as $itm)
  //   {
  //     $item_total = $itm['final_price'] * $itm['qty'];
  //     $item_discount = ($total_price > 0) ? ($item_total / $total_price) * $coupon_discount_amount : 0;
  //     $gst_total += (($item_total - $item_discount) * $itm['gst'] / 100);
  //   }

  //   /* ================= SHIPPING ================= */
  //   $settings = $this->db->get_where('settings', ['id' => 1])->row_array();
  //   $shipping = ($subtotal_after_coupon > $settings['min_order_bal']) ? 0 : $settings['shipping_amount'];
  //   $grand_total = $subtotal_after_coupon + $gst_total + $shipping;

  //   /* ================= TRANSACTION ID ================= */
  //   $transaction_id = '';
  //   $phonepe_merchant_txn_id = '';
  //   if ($paymentType === 2)
  //   {
  //     $phonepe_merchant_txn_id = 'DN' . date('YmdHis') . strtoupper(bin2hex(random_bytes(5)));
  //     $this->session->set_userdata('phonepe_merchant_txn_id', $phonepe_merchant_txn_id);
  //     $transaction_id = $phonepe_merchant_txn_id;
  //   }

  //   /* ================= ORDER INSERT ================= */
  //   $order_number = 'ORD' . time();
  //   $order = [
  //     'order_number' => $order_number,
  //     'transaction_id' => $transaction_id,
  //     'phonepe_merchant_txn_id' => $phonepe_merchant_txn_id,
  //     'user_master_id' => $userId,
  //     'total_price' => $grand_total,
  //     'final_price' => $grand_total,
  //     'payment_type' => $paymentType,
  //     'address_master_id' => $data['address_id'],
  //     'action_payment' => ($paymentType == 1) ? 'Yes' : 'No',
  //     'shippment_charge' => $shipping,
  //     'gst' => $gst_total,
  //     'coupon_code_id' => $applied_coupon['id'] ?? null,
  //     'coupon_discount' => $coupon_discount_amount,
  //     'payment_status' => ($paymentType == 1) ? 'SUCCESS' : 'PENDING',
  //     'status' => ($paymentType == 1) ? 1 : 0,
  //     'add_date' => date('Y-m-d H:i:s'),
  //     'modify_date' => date('Y-m-d H:i:s')
  //   ];
  //   $this->db->insert($order_table, $order);
  //   $lastId = $this->db->insert_id();

  //   /* ================= PURCHASE & EARNINGS INSERT ================= */
  //   foreach ($total_items as $itm)
  //   {
  //     $this->db->query("UPDATE sub_product_master SET quantity = quantity - {$itm['qty']} WHERE id = {$itm['id']}");

  //     $this->db->insert($purchase_table, [
  //       'order_master_id' => $lastId,
  //       'vendor_id' => $itm['vendor_id'],
  //       'promoter_id' => $itm['promoter_id'],
  //       'product_master_id' => $itm['id'],
  //       'product_name' => $itm['name'],
  //       'price' => $itm['price'],
  //       'final_price' => $itm['final_price'],
  //       'quantity' => $itm['qty'],
  //       'size' => $itm['size'],
  //       'color' => $itm['color'],
  //       'gst' => $itm['gst'],
  //       'main_image' => $itm['main_image'],
  //       'product_hsn' => $itm['product_hsn'],
  //       'sku_code' => $itm['sku_code'],
  //       'add_date' => date('Y-m-d H:i:s'),
  //       'modify_date' => date('Y-m-d H:i:s'),
  //       'status' => 1
  //     ]);

  //     /* ================= ADMIN EARNING ================= */
  //     $commission = 0;

  //     // Vendor subscription (monthly / per product)
  //     $vendor_sub = $this->db->get_where('vendor_subscriptions_master', ['vendor_id' => $itm['vendor_id'], 'status' => 1])->row_array();
  //     if ($vendor_sub)
  //     {
  //       if ($vendor_sub['plan_type'] == 2 && $vendor_sub['commission_percent'] > 0)
  //       { // per product
  //         $commission += ($itm['final_price'] * $vendor_sub['commission_percent'] / 100) * $itm['qty'];
  //       }
  //     }

  //     // Promoter subscription (monthly / per product)
  //     $promoter_sub = $this->db->get_where('promoter_subscriptions_master', ['promoter_id' => $itm['promoter_id'], 'status' => 1])->row_array();
  //     $promoter_commission = 0;
  //     if ($promoter_sub)
  //     {
  //       if ($promoter_sub['plan_type'] == 2 && $promoter_sub['commission_percent'] > 0)
  //       { // per product
  //         $promoter_commission = ($itm['final_price'] * $promoter_sub['commission_percent'] / 100) * $itm['qty'];

  //         // insert into promoter_earnings_master
  //         $this->db->insert('promoter_earnings_master', [
  //           'promoter_id' => $itm['promoter_id'],
  //           'vendor_id' => $itm['vendor_id'],
  //           'product_id' => $itm['id'],
  //           'order_id' => $lastId,
  //           'qty' => $itm['qty'],
  //           'product_price' => $itm['final_price'],
  //           'commission_percent' => $promoter_sub['commission_percent'],
  //           'commission_amount' => $promoter_commission,
  //           'earning_amount' => $promoter_commission,
  //           'status' => 0
  //         ]);
  //       }
  //     }

  //     // insert admin earning
  //     if ($commission > 0)
  //     {
  //       $this->db->insert('admin_earnings_master', [
  //         'vendor_id' => $itm['vendor_id'],
  //         'promoter_id' => $itm['promoter_id'],
  //         'product_id' => $itm['id'],
  //         'commission_amount' => $commission,
  //         'created_at' => date('Y-m-d H:i:s')
  //       ]);
  //     }

  //     // insert vendor earning
  //     $vendor_earning = ($itm['final_price'] * $itm['qty']) - $commission;
  //     $this->db->insert('vendor_earnings_master', [
  //       'vendor_id' => $itm['vendor_id'],
  //       'promoter_id' => $itm['promoter_id'],
  //       'product_id' => $itm['id'],
  //       'order_id' => $lastId,
  //       'qty' => $itm['qty'],
  //       'earning_amount' => $vendor_earning,
  //       'created_at' => date('Y-m-d H:i:s')
  //     ]);
  //   }

  //   /* ================= ADDRESS INSERT ================= */
  //   $address = $this->db->get_where('user_address_master', ['id' => $data['address_id']])->row_array();
  //   if (empty($address))
  //   {
  //     redirect('web/checkout');
  //     return;
  //   }
  //   $this->db->insert($address_table, [
  //     'order_master_id' => $lastId,
  //     'title' => $address['title'],
  //     'contact_person' => $address['contact_person'],
  //     'mobile_number' => $address['mobile_number'],
  //     'address' => $address['address'],
  //     'city' => $address['city'],
  //     'state' => $address['state'],
  //     'pincode' => $address['pincode'],
  //     'add_date' => date('Y-m-d H:i:s')
  //   ]);

  //   /* ================= PHONEPE REDIRECT ================= */
  //   if ($paymentType == 2)
  //   {
  //     $this->load->view('payment/phonepe_redirect', [
  //       'ref_id' => $phonepe_merchant_txn_id,
  //       'amount' => $grand_total,
  //       'payment_type' => 'order'
  //     ]);
  //     return;
  //   }

  //   /* ================= COD SUCCESS ================= */
  //   $this->cart->destroy();
  //   $this->session->unset_userdata(['buy_now', 'applied_coupon']);
  //   redirect('web/order_success/' . base64_encode($lastId));
  // }

  // public function order_complete()
  // {
  //   $data = $this->input->post();
  //   $userData = $this->session->userdata('User');

  //   $data['wishlist_count'] = !empty($userData) ? $this->web_model->get_total_wishlist_by_user($userData['id']) : 0;
  //   if (empty($userData))
  //   {
  //     redirect('web/login');
  //     return;
  //   }

  //   $userId = $userData['id'];
  //   $buyNow = $this->session->userdata('buy_now');
  //   $applied_coupon = $this->session->userdata('applied_coupon');
  //   $coupon_discount_amount = 0;

  //   $paymentType = (int) ($data['paymentType'] ?? 1); // 1=COD,2=Online

  //   $order_table = ($paymentType === 2) ? 'order_master2' : 'order_master';
  //   $purchase_table = ($paymentType === 2) ? 'purchase_master2' : 'purchase_master';
  //   $address_table = ($paymentType === 2) ? 'order_address_master2' : 'order_address_master';

  //   /* ================= ITEMS ================= */
  //   $total_items = [];

  //   if (!empty($buyNow['pro_id']))
  //   {
  //     $prod = $this->db->get_where('sub_product_master', ['id' => $buyNow['pro_id']])->row_array();
  //     if (!$prod)
  //       redirect('web/cart');

  //     $total_items[] = [
  //       'id' => $prod['id'],
  //       'name' => $prod['product_name'],
  //       'price' => $prod['price'],
  //       'final_price' => $prod['final_price'],
  //       'gst' => $prod['gst'],
  //       'qty' => (int) $buyNow['qty'],
  //       'size' => $prod['size'],
  //       'color' => $prod['color'],
  //       'main_image' => $prod['main_image'],
  //       'product_hsn' => $prod['product_hsn'],
  //       'sku_code' => $prod['sku_code'],
  //       'vendor_id' => $prod['vendor_id'],
  //       'promoter_id' => $prod['promoter_id']
  //     ];
  //   } else
  //   {
  //     $cart = $this->cart->contents();
  //     if (empty($cart))
  //       redirect(base_url());

  //     foreach ($cart as $c)
  //     {
  //       $prod = $this->db->get_where('sub_product_master', ['id' => $c['id']])->row_array();
  //       if (!$prod)
  //         redirect('web/cart');

  //       $total_items[] = [
  //         'id' => $c['id'],
  //         'name' => $c['name'],
  //         'price' => $c['price'],
  //         'final_price' => $c['final_price'],
  //         'gst' => $prod['gst'],
  //         'qty' => $c['qty'],
  //         'size' => $prod['size'],
  //         'color' => $prod['color'],
  //         'main_image' => $prod['main_image'],
  //         'product_hsn' => $prod['product_hsn'],
  //         'sku_code' => $prod['sku_code'],
  //         'vendor_id' => $prod['vendor_id'],
  //         'promoter_id' => $prod['promoter_id']
  //       ];
  //     }
  //   }

  //   /* ================= TOTAL ================= */
  //   $total_price = 0;
  //   foreach ($total_items as $itm)
  //   {
  //     $total_price += $itm['final_price'] * $itm['qty'];
  //   }

  //   /* ================= COUPON ================= */
  //   if (!empty($applied_coupon))
  //   {
  //     if ($applied_coupon['discount_type'] === 'percent')
  //     {
  //       $coupon_discount_amount = ($applied_coupon['discount_value'] / 100) * $total_price;
  //       if (
  //         !empty($applied_coupon['max_discount_amount']) &&
  //         $coupon_discount_amount > $applied_coupon['max_discount_amount']
  //       )
  //       {
  //         $coupon_discount_amount = $applied_coupon['max_discount_amount'];
  //       }
  //     } else
  //     {
  //       $coupon_discount_amount = $applied_coupon['discount_value'];
  //     }
  //   }

  //   $subtotal_after_coupon = $total_price - $coupon_discount_amount;

  //   /* ================= GST ================= */
  //   $gst_total = 0;
  //   foreach ($total_items as $itm)
  //   {
  //     $item_total = $itm['final_price'] * $itm['qty'];
  //     $item_discount = ($total_price > 0) ? ($item_total / $total_price) * $coupon_discount_amount : 0;
  //     $gst_total += (($item_total - $item_discount) * $itm['gst'] / 100);
  //   }

  //   /* ================= SHIPPING ================= */
  //   $settings = $this->db->get_where('settings', ['id' => 1])->row_array();
  //   $shipping = ($subtotal_after_coupon > $settings['min_order_bal']) ? 0 : $settings['shipping_amount'];
  //   $grand_total = $subtotal_after_coupon + $gst_total + $shipping;

  //   /* ================= TRANSACTION ================= */
  //   $transaction_id = '';
  //   $phonepe_merchant_txn_id = '';
  //   if ($paymentType === 2)
  //   {
  //     $phonepe_merchant_txn_id = 'DN' . date('YmdHis') . strtoupper(bin2hex(random_bytes(5)));
  //     $this->session->set_userdata('phonepe_merchant_txn_id', $phonepe_merchant_txn_id);
  //     $transaction_id = $phonepe_merchant_txn_id;
  //   }

  //   /* ================= ORDER INSERT ================= */
  //   $order_number = 'ORD' . time();

  //   $order = [
  //     'order_number' => $order_number,
  //     'transaction_id' => $transaction_id,
  //     'phonepe_merchant_txn_id' => $phonepe_merchant_txn_id,
  //     'user_master_id' => $userId,
  //     'total_price' => $grand_total,
  //     'final_price' => $grand_total,
  //     'payment_type' => $paymentType,
  //     'address_master_id' => $data['address_id'],
  //     'action_payment' => ($paymentType == 1) ? 'Yes' : 'No',
  //     'shippment_charge' => $shipping,
  //     'gst' => $gst_total,
  //     'coupon_code_id' => $applied_coupon['id'] ?? null,
  //     'coupon_discount' => $coupon_discount_amount,
  //     'payment_status' => ($paymentType == 1) ? 'SUCCESS' : 'PENDING',
  //     'status' => ($paymentType == 1) ? 1 : 0,
  //     'add_date' => date('Y-m-d H:i:s'),
  //     'modify_date' => date('Y-m-d H:i:s')
  //   ];

  //   $this->db->insert($order_table, $order);
  //   $lastId = $this->db->insert_id();

  //   /* ================= TOTAL EARNINGS ================= */
  //   $total_admin_earning = 0;
  //   $total_vendor_earning = 0;
  //   $total_promoter_earning = 0;


  //   /* ================= PURCHASE LOOP ================= */
  //   foreach ($total_items as $itm)
  //   {
  //     // ===== STOCK UPDATE =====
  //     $this->db->query(
  //       "UPDATE sub_product_master 
  //        SET quantity = quantity - {$itm['qty']} 
  //        WHERE id = {$itm['id']}"
  //     );

  //     // ===== BASE CALCULATIONS =====
  //     $base_amount = $itm['final_price'] * $itm['qty'];   // without GST
  //     $gst_amount = ($base_amount * $itm['gst']) / 100;  // GST value
  //     $gross_amount = $base_amount + $gst_amount;         // with GST

  //     // ===== PURCHASE INSERT =====
  //     $this->db->insert($purchase_table, [
  //       'order_master_id' => $lastId,
  //       'vendor_id' => $itm['vendor_id'],
  //       'promoter_id' => $itm['promoter_id'],
  //       'product_master_id' => $itm['id'],
  //       'product_name' => $itm['name'],
  //       'price' => $itm['price'],
  //       'final_price' => $itm['final_price'],
  //       'quantity' => $itm['qty'],
  //       'size' => $itm['size'],
  //       'color' => $itm['color'],
  //       'gst' => $itm['gst'],

  //       'main_image' => $itm['main_image'],
  //       'product_hsn' => $itm['product_hsn'],
  //       'sku_code' => $itm['sku_code'],
  //       'add_date' => date('Y-m-d H:i:s'),
  //       'modify_date' => date('Y-m-d H:i:s'),
  //       'status' => 1
  //     ]);

  //     // ===== COMMISSIONS =====
  //     $admin_commission = 0;
  //     $promoter_commission = 0;

  //     // --- Admin / Vendor Subscription ---
  //     $vendor_sub = $this->db->get_where('vendor_subscriptions_master', [
  //       'vendor_id' => $itm['vendor_id'],
  //       'status' => 1
  //     ])->row_array();

  //     if (!empty($vendor_sub) && $vendor_sub['commission_percent'] > 0)
  //     {
  //       $admin_commission =
  //         ($base_amount * $vendor_sub['commission_percent']) / 100;
  //     }

  //     // --- Promoter Subscription ---
  //     $promoter_sub = $this->db->get_where('promoter_subscriptions_master', [
  //       'promoter_id' => $itm['promoter_id'],
  //       'status' => 1
  //     ])->row_array();

  //     if (!empty($promoter_sub) && $promoter_sub['commission_percent'] > 0)
  //     {
  //       $promoter_commission =
  //         ($base_amount * $promoter_sub['commission_percent']) / 100;

  //       // NOW GOES TO ADMIN
  //       $this->db->insert('admin_earnings_master', [
  //         'vendor_id' => $itm['vendor_id'],
  //         'promoter_id' => $itm['promoter_id'],
  //         'product_id' => $itm['id'],
  //         'commission_amount' => $promoter_commission,
  //         'created_at' => date('Y-m-d H:i:s')
  //       ]);
  //     }


  //     // ===== ADMIN EARNING =====
  //     if ($admin_commission > 0)
  //     {
  //       $this->db->insert('admin_earnings_master', [
  //         'vendor_id' => $itm['vendor_id'],
  //         'promoter_id' => $itm['promoter_id'],
  //         'product_id' => $itm['id'],
  //         'commission_amount' => $admin_commission,
  //         'created_at' => date('Y-m-d H:i:s')
  //       ]);
  //     }

  //     // ===== VENDOR EARNING (GST INCLUDED) =====
  //     $vendor_earning =
  //       $gross_amount - $admin_commission - $promoter_commission;

  //     $this->db->insert('vendor_earnings_master', [
  //       'vendor_id' => $itm['vendor_id'],
  //       'promoter_id' => $itm['promoter_id'],
  //       'product_id' => $itm['id'],
  //       'order_id' => $lastId,
  //       'qty' => $itm['qty'],

  //       'earning_amount' => $vendor_earning,
  //       'status' => 0,
  //       'created_at' => date('Y-m-d H:i:s')
  //     ]);

  //     // ===== TOTALS =====
  //     $total_admin_earning += $admin_commission;
  //     $total_vendor_earning += $vendor_earning;
  //     $total_promoter_earning += $promoter_commission;
  //   }


  //   /* ================= ADDRESS ================= */
  //   $address = $this->db->get_where('user_address_master', ['id' => $data['address_id']])->row_array();
  //   if (!$address)
  //     redirect('web/checkout');

  //   $this->db->insert($address_table, [
  //     'order_master_id' => $lastId,
  //     'title' => $address['title'],
  //     'contact_person' => $address['contact_person'],
  //     'mobile_number' => $address['mobile_number'],
  //     'address' => $address['address'],
  //     'city' => $address['city'],
  //     'state' => $address['state'],
  //     'pincode' => $address['pincode'],
  //     'add_date' => date('Y-m-d H:i:s')
  //   ]);

  //   /* ================= PHONEPE ================= */
  //   if ($paymentType == 2)
  //   {
  //     $this->load->view('payment/phonepe_redirect', [
  //       'ref_id' => $phonepe_merchant_txn_id,
  //       'amount' => $grand_total,
  //       'payment_type' => 'order'
  //     ]);
  //     return;
  //   }

  //   $this->cart->destroy();
  //   $this->session->unset_userdata(['buy_now', 'applied_coupon']);
  //   redirect('web/order_success/' . base64_encode($lastId));
  // }

public function order_complete()
{
    $data = $this->input->post();
    $userData = $this->session->userdata('User');

    if (empty($userData)) {
        redirect('web/login');
        return;
    }

    $userId = $userData['id'];
    $buyNow = $this->session->userdata('buy_now');
    $applied_coupon = $this->session->userdata('applied_coupon');
    $coupon_discount_amount = 0;

    $paymentType = (int) ($data['paymentType'] ?? 1);

    $order_table = ($paymentType === 2) ? 'order_master2' : 'order_master';
    $purchase_table = ($paymentType === 2) ? 'purchase_master2' : 'purchase_master';
    $address_table = ($paymentType === 2) ? 'order_address_master2' : 'order_address_master';

    /* ================= ITEMS ================= */
    $total_items = [];

    if (!empty($buyNow['pro_id'])) {
        $prod = $this->db->get_where('sub_product_master', ['id' => $buyNow['pro_id']])->row_array();
        if (!$prod) redirect('web/cart');

        $total_items[] = [
            'id' => $prod['id'],
            'name' => $prod['product_name'],
            'price' => $prod['price'],
            'final_price' => $prod['final_price'],
            'gst' => $prod['gst'],
            'qty' => (int) $buyNow['qty'],
            'size' => $prod['size'],
            'color' => $prod['color'],
            'main_image' => $prod['main_image'],
            'product_hsn' => $prod['product_hsn'],
            'sku_code' => $prod['sku_code'],
            'vendor_id' => $prod['vendor_id'],
            'promoter_id' => $prod['promoter_id']
        ];
    } else {
        $cart = $this->cart->contents();
        if (empty($cart)) redirect(base_url());

        foreach ($cart as $c) {
            $prod = $this->db->get_where('sub_product_master', ['id' => $c['id']])->row_array();
            if (!$prod) redirect('web/cart');

            $total_items[] = [
                'id' => $c['id'],
                'name' => $c['name'],
                'price' => $c['price'],
                'final_price' => $c['final_price'],
                'gst' => $prod['gst'],
                'qty' => $c['qty'],
                'size' => $prod['size'],
                'color' => $prod['color'],
                'main_image' => $prod['main_image'],
                'product_hsn' => $prod['product_hsn'],
                'sku_code' => $prod['sku_code'],
                'vendor_id' => $prod['vendor_id'],
                'promoter_id' => $prod['promoter_id']
            ];
        }
    }

    /* ================= TOTAL ================= */
    $total_price = 0;
    foreach ($total_items as $itm) {
        $total_price += $itm['final_price'] * $itm['qty'];
    }

    /* ================= COUPON ================= */
    if (!empty($applied_coupon)) {
        if ($applied_coupon['discount_type'] === 'percent') {
            $coupon_discount_amount = ($applied_coupon['discount_value'] / 100) * $total_price;
            if (!empty($applied_coupon['max_discount_amount']) &&
                $coupon_discount_amount > $applied_coupon['max_discount_amount']) {
                $coupon_discount_amount = $applied_coupon['max_discount_amount'];
            }
        } else {
            $coupon_discount_amount = $applied_coupon['discount_value'];
        }
    }

    $subtotal_after_coupon = $total_price - $coupon_discount_amount;

    /* ================= GST ================= */
    $gst_total = 0;
    foreach ($total_items as $itm) {
        $item_total = $itm['final_price'] * $itm['qty'];
        $item_discount = ($total_price > 0) ? ($item_total / $total_price) * $coupon_discount_amount : 0;
        $gst_total += (($item_total - $item_discount) * $itm['gst'] / 100);
    }

    /* ================= SHIPPING ================= */
    $settings = $this->db->get_where('settings', ['id' => 1])->row_array();
    $shipping = ($subtotal_after_coupon > $settings['min_order_bal']) ? 0 : $settings['shipping_amount'];

    $grand_total = $subtotal_after_coupon + $gst_total + $shipping;

    /* ================= ONLINE PAYMENT ================= */
    $transaction_id = '';
    $phonepe_merchant_txn_id = '';

    if ($paymentType === 2) {
        $phonepe_merchant_txn_id = 'DN' . date('YmdHis') . strtoupper(bin2hex(random_bytes(5)));
        $this->session->set_userdata('phonepe_merchant_txn_id', $phonepe_merchant_txn_id);
        $transaction_id = $phonepe_merchant_txn_id;
    }

    /* ================= ORDER INSERT ================= */
    $order_number = 'ORD' . time();

    $order = [
        'order_number' => $order_number,
        'transaction_id' => $transaction_id,
        'phonepe_merchant_txn_id' => $phonepe_merchant_txn_id,
        'user_master_id' => $userId,
        'total_price' => $grand_total,
        'final_price' => $grand_total,
        'payment_type' => $paymentType,
        'address_master_id' => $data['address_id'],
        'action_payment' => ($paymentType == 1) ? 'Yes' : 'No',
        'shippment_charge' => $shipping,
        'gst' => $gst_total,
        'coupon_code_id' => $applied_coupon['id'] ?? null,
        'coupon_discount' => $coupon_discount_amount,
        'payment_status' => ($paymentType == 1) ? 'SUCCESS' : 'PENDING',
        'status' => ($paymentType == 1) ? 1 : 0,
        'add_date' => date('Y-m-d H:i:s'),
        'modify_date' => date('Y-m-d H:i:s')
    ];

    $this->db->insert($order_table, $order);
    $lastId = $this->db->insert_id();

    foreach ($total_items as $itm) {

        // stock
        $this->db->query("UPDATE sub_product_master SET quantity = quantity - {$itm['qty']} WHERE id = {$itm['id']}");

        $base_amount = $itm['final_price'] * $itm['qty'];
        $gst_amount = ($base_amount * $itm['gst']) / 100;
        $gross_amount = $base_amount + $gst_amount;

        // purchase insert
        $this->db->insert($purchase_table, [
            'order_master_id' => $lastId,
            'vendor_id' => $itm['vendor_id'],
            'promoter_id' => $itm['promoter_id'],
            'product_master_id' => $itm['id'],
            'product_name' => $itm['name'],
            'price' => $itm['price'],
            'final_price' => $itm['final_price'],
            'quantity' => $itm['qty'],
            'size' => $itm['size'],
            'color' => $itm['color'],
            'gst' => $itm['gst'],
            'main_image' => $itm['main_image'],
            'product_hsn' => $itm['product_hsn'],
            'sku_code' => $itm['sku_code'],
            'add_date' => date('Y-m-d H:i:s'),
            'modify_date' => date('Y-m-d H:i:s'),
            'status' => 1
        ]);

        /* ================= ADMIN COMMISSION FROM VENDOR ================= */
        $vendor_sub = $this->db->get_where('vendor_subscriptions_master', [
            'vendor_id' => $itm['vendor_id'],
            'status' => 1
        ])->row_array();

        $admin_from_vendor = (!empty($vendor_sub))
            ? ($base_amount * $vendor_sub['commission_percent']) / 100 : 0;

        /* ================= ADMIN COMMISSION FROM PROMOTER ================= */
        $promoter_sub = $this->db->get_where('promoter_subscriptions_master', [
            'promoter_id' => $itm['promoter_id'],
            'status' => 1
        ])->row_array();

        $admin_from_promoter = (!empty($promoter_sub))
            ? ($base_amount * $promoter_sub['commission_percent']) / 100 : 0;

        $total_admin_commission = $admin_from_vendor + $admin_from_promoter;

        /* ================= ADMIN EARNING INSERT ================= */
        if ($total_admin_commission > 0) {
            $this->db->insert('admin_earnings_master', [
                'vendor_id' => $itm['vendor_id'],
                'promoter_id' => $itm['promoter_id'],
                'product_id' => $itm['id'],
                'commission_amount' => $total_admin_commission,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        /* ================= VENDOR EARNING ================= */
        $vendor_earning = $gross_amount - $total_admin_commission;

        $this->db->insert('vendor_earnings_master', [
            'vendor_id' => $itm['vendor_id'],
            'promoter_id' => $itm['promoter_id'],
            'product_id' => $itm['id'],
            'order_id' => $lastId,
            'qty' => $itm['qty'],
            'earning_amount' => $vendor_earning,
            'status' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    /* ================= ADDRESS ================= */
    $address = $this->db->get_where('user_address_master', ['id' => $data['address_id']])->row_array();
    if (!$address) redirect('web/checkout');

    $this->db->insert($address_table, [
        'order_master_id' => $lastId,
        'title' => $address['title'],
        'contact_person' => $address['contact_person'],
        'mobile_number' => $address['mobile_number'],
        'address' => $address['address'],
        'city' => $address['city'],
        'state' => $address['state'],
        'pincode' => $address['pincode'],
        'add_date' => date('Y-m-d H:i:s')
    ]);

    /* ================= PAYMENT REDIRECT ================= */
    if ($paymentType == 2) {
        $this->load->view('payment/phonepe_redirect', [
            'ref_id' => $phonepe_merchant_txn_id,
            'amount' => $grand_total,
            'payment_type' => 'order'
        ]);
        return;
    }

    $this->cart->destroy();
    $this->session->unset_userdata(['buy_now', 'applied_coupon']);

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
                            <h3>Chenna Real Time Pvt.Ltd.</h3>
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
        <center><span style="font-weight: 600;font-size: 18px;">Thank you..... <br> <span style="font-size: 15px;font-weight: 700;color: #005512;"> Order By Chenna Real Time Pvt.Ltd.</span>
        <br>
        <span style="font-size: 15px;font-weight: 600;">+91 7460833766</span>
        <br>
        <span style="font-size: 15px;font-weight: 600;">Chenna110@gmail.com</span>
        </span>
        </center>
        </div> </center>';
    // $html .= '<div style="float:left;width:80%;margin-left:30%"><table><tr><td><p style="font-size:16px;">Thank you...</p>Order By - </td><td><div class="image" style="margin-top:4px;"><br><h4><i>Chenna Pvt. Ltd.</i></h4></div><div style="top: -60px">
    // </div></td></tr></table></div>
    // ';
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
    //*********** Order Placed Email to Customer *******************
    // foreach ($purchase as $key => $purchase) {
    // $product = $this->db->get_where('sub_product_master', array('id' => $purchase['product_master_id']))->row_array();
    // $array_url = parse_url($product['main_image']);
    // if (empty($array_url['host'])) {
    // $img_url = base_url() . '/assets/product_images/' . $product['main_image'];
    // } else {
    // $img_url = 'https://' . $array_url['host'] . '' . $array_url['path'] . '?raw=1';
    // }
    // }
    //$this->load->library('email_send');
    $status = "Order Placed";
    $order_no = $OrderDetail['order_number'];
    $user = $user_info['username'];
    // $email_text = "Thank You for shopping with Chenna. We would like to let you know that your order has been placed and we are waiting for your order confirmation by the seller. If you would like to view the status of order please visit YOUR ORDERS on Chenna.in";
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
    // $this->email_send->send_email($emailid,$email_body,$subject);
    // sentCommonEmail($emailid, $email_body, $subject);
    //************************ End order placed ********************************************
    $html = '';
    $html .= '<div class="container" style="margin: 0 70px;background-color: white;margin-top:20px;border:4px solid rgb(239,126,45);height: auto;padding: 20px;border-radius: 10px;font-size: 15px;">
    <img class="img-fluid" src="https://Chenna.in/My-Img/INCONS/SO-logo.png" alt="Chenna" style="position: absolute;top: 0;height: 42px;width: 200px;">
    <div class="billing-head" style="margin: 0px;float: right;font-size: 15px;font-weight: 500;">
      <div class="row" >
        <div class="col-12"><p style="margin: 0px;float: right;font-size: 15px;font-weight: 500;">Order Placed</p></div>
        <div class="col-12"><p style="margin: 0px;float: right;font-size: 15px;font-weight: 500;">Order No. <span>' . $OrderDetail['order_number'] . '</span></p></div>
      </div>
    </div>
    <div class="row" style="padding:1em 1em 0;">
      <div class="col-12"><span style="font-size:17px;
      font-weight: 500;">Hello ' . $user_info['username'] . ',</span><p style="text-indent: 3em;">Your order no. ' . $OrderDetail['order_number'] . ' has been confirmed by the seller and ready for the shipping. Once your shipment is ready we will notify you with order tracking details.</p></div>
      <!-- <div class="col-12"><p>Order No. <span>' . $OrderDetail['order_number'] . '</span></p></div> -->
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
            <td style="padding-left: 10em"> ' . $OrderDetail['final_price'] . '</td>
          </tr>
        </table>
        <table style="width:100%; padding: 0px 10% 0 11%; margin: 5px 0px 10px;border: 1.5px solid rgb(239,126,45); padding-bottom: 17px;background: #f5f5f5;">
          <tr>
            <td><img src="https://Chenna.in/assets/flow.png" alt="Request Flow" style="height: 65px;width:55%;margin-bottom: 10px;"></td>
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
            <td><img src="https://Chenna.in/My-Img/INCONS/SO-logo.png" alt="Chenna" style="height: 38px;width: 100px;"></td>
            <td><img src="https://Chenna.in/assets/google_play.png" alt="Chenna" style="width:100px;margin-top:-12px;"></td>
            <td><a href="https://www.facebook.com/infoChenna"><img src="https://Chenna.in/assets/facebook.png" alt="Chenna" style="height: 36px;width: 42px;background: transparent;margin-right: 16px;"></a>
              <a href="https://www.instagram.com/Chenna_official"><img src="https://Chenna.in/assets/instagram.png" alt="Chenna" style="height: 36px;width: 42px;background: transparent;margin-right: 16px;"></a>
              <a href="https://twitter.com/infoChenna"><img src="https://Chenna.in/assets/twitter.jpg" alt="Chenna" style="height: 36px;width: 42px;background: transparent;margin-right: 16px;"></a></td>
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
    $headers = "From:" . "support@Chenna.in" . "\r\n";
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
    $userData = $this->session->userdata('User');

    $data['wishlist_count'] = !empty($userData)
      ? $this->web_model->get_total_wishlist_by_user($userData['id'])
      : 0;

    $decoded_order_id = base64_decode($order_id);

    // Default tables
    $tables = [
      'order' => 'order_master',
      'address' => 'order_address_master',
      'purchase' => 'purchase_master'
    ];

    // Fetch order
    $order = $this->db->get_where($tables['order'], [
      'id' => $decoded_order_id
    ])->row_array();

    // If not found → fallback tables
    if (empty($order))
    {
      $tables = [
        'order' => 'order_master2',
        'address' => 'order_address_master2',
        'purchase' => 'purchase_master2'
      ];

      $order = $this->db->get_where($tables['order'], [
        'id' => $decoded_order_id
      ])->row_array();
    }

    if (empty($order))
    {
      show_404();
    }

    // Address
    $address_data = $this->db->get_where($tables['address'], [
      'order_master_id' => $decoded_order_id
    ])->row_array();

    // Purchase items
    $purchase_items = $this->db->get_where($tables['purchase'], [
      'order_master_id' => $decoded_order_id
    ])->result_array();

    // Payment type
    $paymentTypeMap = [
      1 => 'Cash on Delivery',
      2 => 'Online Payment',
      3 => 'Wallet'
    ];

    $paymentTypeName = $paymentTypeMap[$order['payment_type']] ?? 'Unknown';

    // COD Status
    $cod_status = ($order['cash_on_delivery'] == 1)
      ? 'Available'
      : 'Not Available';

    // Seller Approval Status
    $seller_status = ($order['seller_approve'] == 1)
      ? 'Approved'
      : 'Not Approved';

    $data['title'] = 'Order Success | Chenna';
    $data['order_data'] = $order;
    $data['address_data'] = $address_data;
    $data['purchase_items'] = $purchase_items;
    $data['paymentTypeName'] = $paymentTypeName;
    $data['cod_status'] = $cod_status;
    $data['seller_status'] = $seller_status;

    $this->load->view('web/include/header', $data);
    $this->load->view('web/order_complete', $data);
    $this->load->view('web/include/footer');
  }

  public function order_success2($order_number)
  {
    $userData = $this->session->userdata('User');
    $data['wishlist_count'] = !empty($userData) ? $this->web_model->get_total_wishlist_by_user($userData['id']) : 0;
    $order = $this->db->get_where('order_master2', ['order_number' => $order_number])->row_array();

    if (empty($order))
    {
      $order = $this->db->get_where('order_master', ['order_number' => $order_number])->row_array();
    }
    if (empty($order))
    {
      show_404();
      return;
    }

    $address = $this->db->get_where('order_address_master2', ['order_master_id' => $order['id']])->row_array();
    if (empty($address))
    {
      $address = $this->db->get_where('order_address_master', ['order_master_id' => $order['id']])->row_array();
    }
    $items = $this->db->get_where('purchase_master2', ['order_master_id' => $order['id']])->result_array();
    if (empty($items))
    {
      $items = $this->db->get_where('purchase_master', ['order_master_id' => $order['id']])->result_array();
    }

    $paymentTypeMap = [
      1 => 'Cash on Delivery',
      2 => 'Online Payment',
      3 => 'Wallet'
    ];
    $paymentTypeName = $paymentTypeMap[(int) ($order['payment_type'] ?? 0)] ?? 'Unknown';

    $data = [
      'title' => 'Order Success | Chenna',
      'order_data' => $order,
      'address_data' => $address,
      'purchase_items' => $items,
      'paymentTypeName' => $paymentTypeName,
      'bannerList' => $this->web_model->getBannerList(),
      'MainCategoryList' => $this->web_model->getMainCategoryList()
    ];
    $this->load->view('web/include/header', $data);
    $this->load->view('web/order_complete', $data);
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
} </style><h1 style="text-align:center;font-size:34px"><u>Invoice</u></h1>';
    $html .= '<div style="float:left;width:100%; margin-top:20px;"><div style="float:left;width:70%"><div class="image"><h3>Chenna Real Time Pvt.Ltd.</h3></div><div style="margin-left: 30px; top: -60px" >
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
        <center><span style="font-weight: 600;font-size: 18px;">Thank you..... <br> <span style="font-size: 15px;font-weight: 700;color: #005512;"> Order By Chenna Real Time Pvt.Ltd.</span>
        <br>
        <span style="font-size: 15px;font-weight: 600;">+91 7460833766</span>
        <br>
        <span style="font-size: 15px;font-weight: 600;">Chenna110@gmail.com</span>
        </span>
       
        </center>
 </div> </center>';
    // $html .= '<div style="float:left;width:80%;margin-left:30%"><table><tr><td><p style="font-size:16px;">Thank you...</p>Order By - </td><td><div class="image" style="margin-top:4px;"><br><h4><i>Chenna Pvt. Ltd.</i></h4></div><div style="top: -60px">
    // </div></td></tr></table></div>
    // ';
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
            $this->session->set_flashdata("Voucher_Succ", "<img src='" . base_url() . "/assets/emoji/congratulation.png' height='50px' width='50px'>&nbsp;congratulation.! You get OFF <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $oldCartAmt . "-" . $voucherData['voucher_value'] . "&nbsp;=&nbsp;" . $newCartAmt . "&nbsp;<i class='fa fa-rupee'></i>");
          } else
          {
            $newCartAmt = $_SESSION['cart_contents']['cart_total'] = $totalCartAmt - $voucherData['voucher_value'];
            $vouchValData = array(
              'user_id' => $u_id,
              'voucher_id' => $voucher_id,
              'voucher_uses' => 1
            );
            $this->db->insert('voucher_validity_master', $vouchValData);
            $this->session->set_flashdata("Voucher_Succ", "<img src='" . base_url() . "/assets/emoji/congratulation.png' height='50px' width='50px'>&nbsp;congratulation.! You get &nbsp;&nbsp;&nbsp;&nbsp; OFF&nbsp;" . $oldCartAmt . "-" . $voucherData['voucher_value'] . "&nbsp;=&nbsp;" . $newCartAmt . "&nbsp;<i class='fa fa-rupee'></i>");
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
                      { // 1= Discountable Amount, 2= cashback
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
                      { // 1= Discountable Amount, 2= cashback
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
                        // $this->session->set_flashdata("Coupon_Succ", "<img src='".base_url()."/assets/emoji/congratulation.png' height='50px' width='50px'>&nbsp;congratulation.! You get &nbsp;&nbsp;&nbsp;&nbsp; OFF&nbsp;".$oldCartAmt."-".$discountAmt."&nbsp;=&nbsp;".$newCartAmt."&nbsp;<i class='fa fa-rupee'></i>");
                        $this->session->set_flashdata("Coupon_Succ", "Discount:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-" . $discountAmt . "&nbsp;<i class='fa fa-rupee'></i>");
                      } else
                      {
                        // $discountAmt = $totalCartAmt*$couponData['coupn_discount_val']/100;
                        $discountAmt = $filter_pro_rec[0]['final_price'] * $couponData['coupn_discount_val'] / 100;
                        $discountAmt = round($discountAmt);
                        if ($discountAmt > $minimum_discount_value)
                        {
                          $discountAmt = $minimum_discount_value;
                          // $newCartAmt = $_SESSION['cart_contents']['cart_total']=$totalCartAmt-$discountAmt;
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
                      { // 1= Discountable Amount, 2= cashback
                        $newCartAmt = $_SESSION['cart_contents']['cart_total'] = $totalCartAmt - $couponData['coupn_discount_val'];
                        // $this->session->set_flashdata("Coupon_Succ", "<img src='".base_url()."/assets/emoji/congratulation.png' height='50px' width='50px'>&nbsp;congratulation.! You get &nbsp;&nbsp;&nbsp;&nbsp; OFF&nbsp;".$oldCartAmt."-".$couponData['coupn_discount_val']."&nbsp;=&nbsp;".$newCartAmt."&nbsp;<i class='fa fa-rupee'></i>");
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
                      { // 1= Discountable Amount
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
                        // $this->session->set_flashdata("Coupon_Succ", "<img src='".base_url()."/assets/emoji/congratulation.png' height='50px' width='50px'>&nbsp;congratulation.! You get &nbsp;&nbsp;&nbsp;&nbsp; OFF&nbsp;".$oldCartAmt."-".$discountAmt."&nbsp;=&nbsp;".$newCartAmt."&nbsp;<i class='fa fa-rupee'></i>");
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
              // }else{ //Customer elegible for coupon or not condition close
              // $this->session->set_flashdata('activate_m', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button><img src="'.base_url().'/assets/emoji/confuse.png" height="50px" width="50px">Sorry, This coupon is not valid for these product.</div></div>');
              // redirect('web/checkout_payment');
              // }
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
                        { // 1= Discountable Amount, 2= cashback
                          $newCartAmt = $_SESSION['cart_contents']['cart_total'] = $totalCartAmt - $couponData['coupn_discount_val'];
                          // $this->session->set_flashdata("Coupon_Succ", "<img src='".base_url()."/assets/emoji/congratulation.png' height='50px' width='50px'>&nbsp;congratulation.! You get &nbsp;&nbsp;&nbsp;&nbsp; OFF&nbsp;".$oldCartAmt."-".$couponData['coupn_discount_val']."&nbsp;=&nbsp;".$newCartAmt."&nbsp;<i class='fa fa-rupee'></i>");
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
                        { // 1= Discountable Amount, 2= cashback
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
                          // $this->session->set_flashdata("Coupon_Succ", "<img src='".base_url()."/assets/emoji/congratulation.png' height='50px' width='50px'>&nbsp;congratulation.! You get &nbsp;&nbsp;&nbsp;&nbsp; OFF&nbsp;".$oldCartAmt."-".$discountAmt."&nbsp;=&nbsp;".$newCartAmt."&nbsp;<i class='fa fa-rupee'></i>");
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
                        { // 1= Discountable Amount, 2= cashback
                          $newCartAmt = $_SESSION['cart_contents']['cart_total'] = $totalCartAmt - $couponData['coupn_discount_val'];
                          // $this->session->set_flashdata("Coupon_Succ", "<img src='".base_url()."/assets/emoji/congratulation.png' height='50px' width='50px'>&nbsp;congratulation.! You get &nbsp;&nbsp;&nbsp;&nbsp; OFF&nbsp;".$oldCartAmt."-".$couponData['coupn_discount_val']."&nbsp;=&nbsp;".$newCartAmt."&nbsp;<i class='fa fa-rupee'></i>");
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
                        { // 1= Discountable Amount, 2= cashback
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
                          // $this->session->set_flashdata("Coupon_Succ", "<img src='".base_url()."/assets/emoji/congratulation.png' height='50px' width='50px'>&nbsp;congratulation.! You get &nbsp;&nbsp;&nbsp;&nbsp; OFF&nbsp;".$oldCartAmt."-".$discountAmt."&nbsp;=&nbsp;".$newCartAmt."&nbsp;<i class='fa fa-rupee'></i>");
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
                      { // 1 = FLAT Discount, 2= percantage
                        if ($coupon_type == 1)
                        { // 1= Discountable Amount, 2= cashback
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
                        { // 1= Discountable Amount, 2= cashback
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
                        { // 1= Discountable Amount, 2= cashback
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
                        { // 1= Discountable Amount, 2= cashback
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
                          // $this->session->set_flashdata("Coupon_Succ", "<img src='".base_url()."/assets/emoji/congratulation.png' height='50px' width='50px'>&nbsp;congratulation.! You get &nbsp;&nbsp;&nbsp;&nbsp; OFF&nbsp;".$oldCartAmt."-".$discountAmt."&nbsp;=&nbsp;".$newCartAmt."&nbsp;<i class='fa fa-rupee'></i>");
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
                        { // 1= Discountable Amount, 2= cashback
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
                        { // 1= Discountable Amount, 2= cashback
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
                        { // 1= Discountable Amount, 2= cashback
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
                        { // 1= Discountable Amount, 2= cashback
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
                        { // 1= Discountable Amount, 2= cashback
                          $newCartAmt = $_SESSION['cart_contents']['cart_total'] = $totalCartAmt - $couponData['coupn_discount_val'];
                          // $this->session->set_flashdata("Coupon_Succ", "<img src='".base_url()."/assets/emoji/congratulation.png' height='50px' width='50px'>&nbsp;congratulation.! You get &nbsp;&nbsp;&nbsp;&nbsp; OFF&nbsp;".$oldCartAmt."-".$couponData['coupn_discount_val']."&nbsp;=&nbsp;".$newCartAmt."&nbsp;<i class='fa fa-rupee'></i>");
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
                        { // 1= Discountable Amount, 2= cashback
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
                        { // 1= Discountable Amount, 2= cashback
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
                        { // 1= Discountable Amount, 2= cashback
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

    // Send SMS (implement sendSMS function)
    $text = 'Your OTP is: ' . $otp;
    sendSMS($mobile, $text, '1007086055987083292');

    if ($user)
    {
      $this->web_model->update_otp($mobile, $otp);
    } else
    {
      $this->web_model->insert_user_with_otp($mobile, $otp);
    }

    echo json_encode(['status' => 'success']);
  }

  public function verify_otp()
  {
    $input = json_decode(file_get_contents('php://input'), true);
    $mobile = $input['mobile'] ?? '';
    $otp = $input['otp'] ?? '';
    $redirect = $input['redirect'] ?? base_url();

    $user_res = $this->web_model->verify_otp($mobile, $otp);

    if (!empty($user_res))
    {
      $user_data = [
        "id" => $user_res["id"],
        "email" => $user_res["email_id"],
        "username" => $user_res["username"],
      ];
      $this->session->set_userdata("User", $user_data);

      echo json_encode([
        "status" => "Success",
        "message" => "Login successful",
        "redirect" => $redirect
      ]);
    } else
    {
      echo json_encode([
        "status" => "error",
        "message" => "Invalid OTP"
      ]);
    }
  }



}
