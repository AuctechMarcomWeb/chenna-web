<?php
class Website_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();

    }
    public function get_coupon_by_code($code)
    {
        $today = date('Y-m-d H:i:s');

        $this->db->where('coupon_code', $code);
        $this->db->where('status', 1);
        $this->db->where('start_date <=', $today);
        $this->db->where('end_date >=', $today);

        return $this->db->get('coupon_manager_master')->row_array();
    }


    /*Feture Product*/
    public function get_gst($product_id)
    {
        $this->db->select('gst');
        $this->db->from('sub_product_master');
        $this->db->where('id', $product_id);
        $query = $this->db->get();
        return $query->row();
    }
    public function getFetureProduct()
    {
        $this->db->select('product_ids');
        $tag1 = $this->db->get_where('tag_master', array('id' => '3'))->row_array();
        $product_ids = json_decode($tag1['product_ids'], true);

        $this->db->select('id,sub_category_id,product_name,price,final_price,quantity,main_image');
        $this->db->where_in('id', $product_ids);
        $this->db->where('status', 1);
        $this->db->group_by('sku_code');
        $this->db->limit(12);
        return $this->db->get('sub_product_master')->result_array();


    }
    public function getProductsByTagIdWithRating($product_ids)
    {
        if (empty($product_ids))
        {
            return [];
        }

        $this->db->select('id, sub_category_id, product_name, price, final_price, quantity, main_image');
        $this->db->where_in('id', $product_ids);
        $this->db->where('status', 1);
        $this->db->group_by('sku_code');
        $this->db->limit(12);
        $products = $this->db->get('sub_product_master')->result_array();

        foreach ($products as &$product)
        {
            $avgRatingRow = $this->db->select_avg('rating')
                ->where('product_id', $product['id'])
                ->where('status', 1)
                ->get('customer_review')
                ->row();

            $product['average_rating'] = round($avgRatingRow->rating ?? 0, 1);

            $product['total_reviews'] = $this->db->where('product_id', $product['id'])
                ->where('status', 1)
                ->count_all_results('customer_review');
        }
        unset($product);

        return $products;
    }

    public function getAllTagSections()
    {
        $sections = [];

        $tags = $this->db->where('status', 1)
            ->order_by('id', 'ASC')
            ->get('tag_master')
            ->result_array();

        foreach ($tags as $tag)
        {
            if (empty($tag['product_ids']))
                continue;

            $product_ids = json_decode($tag['product_ids'], true);
            if (empty($product_ids))
                continue;

            // Fetch products
            $this->db->select('id, product_name, price, final_price, main_image');
            $this->db->where_in('id', $product_ids);
            $this->db->where('status', 1);
            $this->db->limit(12);
            $products = $this->db->get('sub_product_master')->result_array();

            if (empty($products))
                continue;

            // Rating
            foreach ($products as &$product)
            {
                $avg = $this->db->select_avg('rating')
                    ->where('product_id', $product['id'])
                    ->where('status', 1)
                    ->get('customer_review')
                    ->row();

                $product['average_rating'] = round($avg->rating ?? 0, 1);
            }

            $sections[] = [
                'tag_id' => $tag['id'],
                'tag_name' => $tag['name'],
                'products' => $products
            ];
        }

        return $sections;
    }



    public function getCollectionByTagName($tag_name)
    {
        $this->db->select('product_ids');
        $tag = $this->db->get_where('tag_master', ['name' => $tag_name, 'status' => 1])->row_array();

        if (empty($tag) || empty($tag['product_ids']))
            return [];

        $product_ids = json_decode($tag['product_ids'], true);

        if (empty($product_ids))
            return [];

        $this->db->select('id, sub_category_id, product_name, price, final_price, quantity, main_image');
        $this->db->where_in('id', $product_ids);
        $this->db->where('status', 1);
        $this->db->group_by('sku_code');
        $this->db->limit(12);

        return $this->db->get('sub_product_master')->result_array();
    }



    public function getDataByTag($tag, $id)
    {

        $this->db->select('product_ids');
        $tag1 = $this->db->get_where('tag_master', array('id' => $id))->row_array();
        $product_ids = json_decode($tag1['product_ids'], true);
        $this->db->select('id,sub_category_id,product_name,price,final_price,main_image');
        $this->db->where_in('id', $product_ids);
        return $this->db->get_where('sub_product_master', array('status' => 1))->result_array();

    }




    /*Top Best Sell Product*/

    public function getwomensAccessories()
    {
        $this->db->select('product_ids');
        $tag1 = $this->db->get_where('tag_master', array('id' => '4'))->row_array();
        $product_ids = json_decode($tag1['product_ids'], true);

        $this->db->select('id,sub_category_id,product_name,price,final_price,quantity,main_image');
        $this->db->where_in('id', $product_ids);
        $this->db->where('status', 1);
        $this->db->group_by('sku_code'); // or group_by('id') if id is same for variations
        $this->db->limit(12);
        return $this->db->get('sub_product_master')->result_array();


    }


    public function getTopSellProduct()
    {
        $this->db->select('product_ids');
        $tag1 = $this->db->get_where('tag_master', array('id' => '4'))->row_array();
        $product_ids = json_decode($tag1['product_ids'], true);

        $this->db->select('id,sub_category_id,product_name,price,final_price,quantity,main_image');
        $this->db->where_in('id', $product_ids);
        $this->db->where('status', 1);
        $this->db->group_by('sku_code'); // or group_by('id') if id is same for variations
        $this->db->limit(12);
        return $this->db->get('sub_product_master')->result_array();


    }
    /*Prodcut For You*/


    public function getProductForYou()
    {

        $this->db->select('product_ids');
        $tag1 = $this->db->get_where('tag_master', array('id' => '1'))->row_array();
        $product_ids = json_decode($tag1['product_ids'], true);

        $this->db->select('id,sub_category_id,product_name,price,final_price,quantity,main_image');
        $this->db->where_in('id', $product_ids);
        $this->db->where('status', 1);
        $this->db->group_by('sku_code'); // or group_by('id') if id is same for variations
        $this->db->limit(12);
        return $this->db->get('sub_product_master')->result_array();



    }

    /*Mens Collection*/


    public function getmensCollection()
    {

        $this->db->select('product_ids');
        $tag1 = $this->db->get_where('tag_master', array('id' => '2'))->row_array();
        $product_ids = json_decode($tag1['product_ids'], true);

        $this->db->select('id,sub_category_id,product_name,price,final_price,quantity,main_image');
        $this->db->where_in('id', $product_ids);
        $this->db->where('status', 1);
        $this->db->group_by('sku_code'); // or group_by('id') if id is same for variations
        $this->db->limit(12);
        return $this->db->get('sub_product_master')->result_array();


    }

    /*Womens Collection*/


    public function getwomensCollection()
    {

        $this->db->select('product_ids');
        $tag1 = $this->db->get_where('tag_master', array('id' => '3'))->row_array();
        $product_ids = json_decode($tag1['product_ids'], true);

        $this->db->select('id,sub_category_id,product_name,price,final_price,quantity,main_image');
        $this->db->where_in('id', $product_ids);
        $this->db->where('status', 1);
        $this->db->group_by('sku_code'); // or group_by('id') if id is same for variations
        $this->db->limit(12);
        return $this->db->get('sub_product_master')->result_array();


    }

    /*Footware Collection*/


    public function getfootWear()
    {

        $this->db->select('product_ids');
        $tag1 = $this->db->get_where('tag_master', array('id' => '14'))->row_array();
        $product_ids = json_decode($tag1['product_ids'], true);

        $this->db->select('id,sub_category_id,product_name,price,final_price,quantity,main_image');
        $this->db->where_in('id', $product_ids);
        $this->db->where('status', 1);
        $this->db->group_by('sku_code'); // or group_by('id') if id is same for variations
        $this->db->limit(12);
        return $this->db->get('sub_product_master')->result_array();


    }

    public function getkidscollection()
    {

        $this->db->select('product_ids');
        $tag1 = $this->db->get_where('tag_master', array('id' => '13'))->row_array();
        $product_ids = json_decode($tag1['product_ids'], true);

        $this->db->select('id,sub_category_id,product_name,price,final_price,quantity,main_image');
        $this->db->where_in('id', $product_ids);
        $this->db->where('status', 1);
        $this->db->group_by('sku_code'); // or group_by('id') if id is same for variations
        $this->db->limit(12);
        return $this->db->get('sub_product_master')->result_array();


    }

    /*Product Details*/

    public function productDetails($id)
    {
        return $this->db->get_where('sub_product_master', array('id' => $id))->row_array();
    }


    public function getProductColor($product_code)
    {
        return $this->db->select('color, color_code')
            ->where('product_code', $product_code)
            ->group_by('color, color_code')
            ->get('sub_product_master')
            ->result_array();
    }


    public function getAllProductSizes($product_code)
    {
        return $this->db->select('size')
            ->where('product_code', $product_code)
            ->group_by('size')
            ->get('sub_product_master')
            ->result_array();
    }


    public function getProductSize($product_code, $color_code)
    {
        return $this->db->select('size')
            ->where('product_code', $product_code)
            ->where('color_code', $color_code)
            ->group_by('size')
            ->get('sub_product_master')
            ->result_array();
    }


    public function get_sub_product_by_id($id)
    {
        return $this->db->where('id', $id)->get('sub_product_master')->row_array();
    }


    public function get_jails_by_city($city_id)
    {
        return $this->db->get_where('jail', array('city_id' => $city_id))->result_array();
    }


    public function getBannerList()
    {
        $this->db->select('banner_image');
        return $this->db->get_where('banner_master', array('status' => '1'))->result_array();
    }

    public function getMainCategoryList()
    {
        $this->db->select('id,name');
        return $this->db->get_where('parent_category_master', array('status' => '1'))->result_array();
    }

    public function getCategoryList($id)
    {
        $this->db->select('id,category_name');
        return $this->db->get_where('category_master', array('status' => '1', 'mai_id' => $id))->result_array();
    }

    public function getSubCategoryList($id)
    {
        $this->db->select('id,sub_category_name');
        return $this->db->get_where('sub_category_master', array('status' => '1', 'category_master_id' => $id))->result_array();
    }


    public function getAllUserAddress($id)
    {
        return $this->db->get_where('user_address_master', array('user_master_id' => $id))->row_array();
    }



    public function getDataBySearch($keywords)
    {

        $this->db->select('id,sub_category_id,product_name,price,final_price,main_image');
        $this->db->group_by('product_code');
        $this->db->like('product_name', $keywords);
        $this->db->order_by('id', 'DESC');
        return $this->db->get_where('sub_product_master', array('status' => '1'))->result_array();

    }


    public function getDataBySubCate($main, $category)
    {


        $main = str_replace('-', ' ', strtolower($main));


        $mainCategory = $this->db->select('id')
            ->from('parent_category_master')
            ->where("name LIKE '%$main%'")
            ->get()->row_array();

        $category = str_replace('-', ' ', strtolower($category));

        $category = $this->db->select('id')
            ->from('category_master')
            ->where("category_name LIKE '%$category%'")
            ->get()->row_array();


        $this->db->select('id,sub_category_id,product_name,price,final_price,main_image');
        $this->db->order_by('id', 'DESC');
        return $this->db->get_where('sub_product_master', array('status' => '1', 'category_id' => $category['id'], 'parent_category_id' => $mainCategory['id']))->result_array();


    }
    public function get_total_orders_by_user($user_id)
    {
        $this->db->where('user_master_id', $user_id);
        $this->db->from('order_master');
        return $this->db->count_all_results();
    }

    public function get_total_wishlist_by_user($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->from('wish_list_master');
        return $this->db->count_all_results();
    }



    public function is_already_subscribed($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('newsletter_subscribers');
        return $query->num_rows() > 0;
    }

    public function subscribe_user($email)
    {
        $data = [
            'email' => $email,
            'created_at' => date('Y-m-d H:i:s')
        ];
        return $this->db->insert('newsletter_subscribers', $data);
    }


    public function get_by_mobile($mobile)
    {
        return $this->db->get_where('user_master', ['mobile' => $mobile])->row();
    }

    public function update_otp($mobile, $otp)
    {
        $this->db->where('mobile', $mobile);
        return $this->db->update('user_master', ['otp' => $otp]);
    }

    public function insert_user_with_otp($mobile, $otp)
    {
        return $this->db->insert('user_master', [
            'mobile' => $mobile,
            'otp' => $otp,
            'add_date' => date('Y-m-d H:i:s')
        ]);
    }

    public function verify_otp($mobile, $otp)
    {
        return $this->db->get_where('user_master', [
            'mobile' => $mobile,
            'otp' => $otp
        ])->row_array();
    }



}
?>