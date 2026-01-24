<?php defined('BASEPATH') or exit('No direct script access allowed');
class Product extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('email');
    $this->load->library('session');
    $this->load->helper('message');
    $this->load->model('Product_model');
     $this->load->model('Subscription_model');
    /*$this->load->library('excel');*/
    $this->load->library('pagination');
    is_not_logged_in();
  }


  public function changeQty()
  {
    $html = '';
    $product_code = $this->input->post('product_code');
    $quantity = $this->input->post('quantity');
    $this->db->select('product_code');
    $product = $this->db->get_where('sub_product_master', array('id' => $product_code))->row_array();

    $html .= '<div class="row">
            <div class="col-md-12">
              <label>Total Product Quantity</label>
              <input type="number" value="' . $quantity . '" class="form-control" readonly="">
              <input type="hidden" value="' . $product['product_code'] . '" name="product_code">
            </div>
          </div><br>

          <div class="row">
          <div class="col-md-12">
              <label>Change Product Quantity</label>
              <input type="number"  class="form-control" name="qty" required="">
            </div>
          </div><br>

           <div class="row">
             <div class="col-md-12">
              <button type="submit" class="btn btn-default" style="float: right;">Submit</button>
            </div>
            </div>';

    echo $html;
    exit;

  }

  public function all_product_list()
  {
    $this->db->select(
      'sub_product_master.*,
      shop_master.bussiness_name,
      brand_master.brand_name,
      parent_category_master.name as parent_category_name,
      category_master.category_name,
      sub_category_master.sub_category_name'
    );

    $this->db->from('sub_product_master');
    $this->db->join('shop_master', 'sub_product_master.shop_id = shop_master.id', 'left');
    $this->db->join('brand_master', 'sub_product_master.brand_id = brand_master.id', 'left');
    $this->db->join('parent_category_master', 'sub_product_master.parent_category_id = parent_category_master.id', 'left');
    $this->db->join('category_master', 'sub_product_master.category_id = category_master.id', 'left');
    $this->db->join('sub_category_master', 'sub_product_master.sub_category_id = sub_category_master.id', 'left');
    $this->db->where('sub_product_master.status', 1);
    $data['getData'] = $this->db->get()->result_array();

    $this->load->view('include/header');
    $this->load->view('Product/AllProductList', $data);
    $this->load->view('include/footer');
  }


  public function all_product_list_vendor($id)
  {
    // Select products and related info including vendor shop_name
    $this->db->select('sub_product_master.*, 
                       vendors.shop_name as vendor_shop_name, 
                       parent_category_master.name as parent_category_name, 
                       category_master.category_name, 
                       sub_category_master.sub_category_name');

    $this->db->from('sub_product_master');

    // Join vendors table to get shop_name
    $this->db->join('vendors', 'sub_product_master.vendor_id = vendors.id', 'left');

    $this->db->join('parent_category_master', 'sub_product_master.parent_category_id = parent_category_master.id', 'left');
    $this->db->join('category_master', 'sub_product_master.category_id = category_master.id', 'left');
    $this->db->join('sub_category_master', 'sub_product_master.sub_category_id = sub_category_master.id', 'left');

    $this->db->where('sub_product_master.vendor_id', $id);
    $this->db->where('sub_product_master.status', 1);

    $data['getData'] = $this->db->get()->result_array();

    // Load views
    $this->load->view('include/header', array('index' => 'product'));
    $this->load->view('Product/AllProductListVendor', $data);
    $this->load->view('include/footer');
  }

  public function AllVendorProductListByPromoter($promoter_id)
  {
    $vendorIds = $this->db->select('id')
      ->from('vendors')
      ->where('promoter_id', $promoter_id)
      ->where('status', 1)
      ->get()
      ->result_array();

    $vendorIds = array_column($vendorIds, 'id');

    $data['totalVendors'] = count($vendorIds);
    if (empty($vendorIds))
    {
      $data['getData'] = [];
    } else
    {
      $this->db->select('
            sp.id as product_id,
            sp.product_name,
            sp.quantity,
            sp.final_price,
            sp.price,
            sp.brand,
            sp.added_type,
            sp.promoter_id,
            sp.vendor_id,
            v.shop_name as vendor_shop_name,
            p.shop_name as promoter_shop_name,
            pc.name as parent_category_name,
            c.category_name,
            sc.sub_category_name
        ');
      $this->db->from('sub_product_master sp');

      $this->db->join('vendors v', 'sp.vendor_id = v.id', 'left');
      $this->db->join('promoters p', 'sp.promoter_id = p.id', 'left');
      $this->db->join('parent_category_master pc', 'sp.parent_category_id = pc.id', 'left');
      $this->db->join('category_master c', 'sp.category_id = c.id', 'left');
      $this->db->join('sub_category_master sc', 'sp.sub_category_id = sc.id', 'left');

      $this->db->where_in('sp.vendor_id', $vendorIds);
      $this->db->where('sp.status', 1);

      $data['getData'] = $this->db->get()->result_array();
    }
    $data['title'] = 'All Vendor Product List';
    // 3️⃣ Load views
    $this->load->view('include/header', $data);
    $this->load->view('Product/AllVendorProductListByPromoter', $data);
    $this->load->view('include/footer');
  }



  public function changePassword()
  {
    $data = $this->input->post();
    $field['quantity'] = $data['qty'];
    $this->db->where('product_code', $data['product_code']);
    $row = $this->db->update('sub_product_master', $field);
    $this->session->set_flashdata('activate', getCustomAlert('S', 'Product  Quantity Update successfully.'));
    redirect('admin/Product/index');

  }

  public function verify_product()
  {
    $value = $this->input->post('value');
    $product_id = $this->input->post('product_id');
    $product = $this->db->get_where('sub_product_master', array('id' => $product_id))->row_array();

    if ($value == '1')
    {

      $field['verify_status'] = '2';
      $field['status'] = '2';
      $this->db->where('product_code', $product['product_code']);
      $row = $this->db->update('sub_product_master', $field);
      echo '2';

    } else
    {

      $field['verify_status'] = '1';
      $field['status'] = '1';
      $this->db->where('product_code', $product['product_code']);
      $row = $this->db->update('sub_product_master', $field);
      echo '1';
    }



  }



  public function uploadBulkproductInExcel()
  {
    $chars = "0123456789";
    $unique_id = substr(str_shuffle($chars), 0, 6);
    $adminData = $this->session->userdata('adminData');
    $data = $this->input->post();

    if (isset($_FILES["excel"]["name"]))
    {
      $excel = $_FILES["excel"]["name"];
      $excel_array = explode(".", $excel);
      $myStr = $excel_array['0'];
      $name = substr($myStr, 0, 3);




      ini_set('memory_limit', '2048M');
      $allowedFileType = ['application/vnd.ms-excel', 'text/xls', 'text/xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
      if (in_array($_FILES["excel"]["type"], $allowedFileType))
      {

        $targetPath = EXCEL_DIRECTORY . $_FILES['excel']['name'];
        move_uploaded_file($_FILES['excel']['tmp_name'], $targetPath);
        $object = PHPExcel_IOFactory::load($targetPath);

        $unique_id = $num = rand('99999999', '10000000');
        $column_name = array();
        $hold_error = array();
        $hold_column_value = array();

        $db_colunm = array('category_id' => 'Category', 'sub_category_id' => 'Sub Category', 'product_code' => 'Product_Code', 'sku_code' => 'SKU_Code', 'product_name' => 'Product Title', 'product_description' => 'Product Description', 'final_price' => 'Selling Price (In Rs)', 'price' => 'MRP (In Rs)', 'quantity' => 'Quantity', 'size' => 'Size', 'color' => 'Color', 'top_color' => 'Top Color', 'bottom_color' => 'Bottom Color', 'dupatta_color' => 'Dupatta Color', 'brand' => 'Brand', 'prints_patterns' => 'Prints & Pattern', 'occasion' => 'Occasion', 'art_work' => 'Art Work', 'style' => 'Style', 'length' => 'Length', 'top_length' => 'Top Length', 'bottom_length' => 'Bottom Length', 'dupatta_length' => 'Dupatta Length', 'saree_length' => 'Saree Length (In Mtr.)', 'blouse_piece' => 'Blouse Piece', 'waist' => 'Waist', 'reversible' => 'Reversible', 'pocket_type' => 'Pocket Type', 'shoes_type' => 'Shoes Type', 'upper_material' => 'Upper Material', 'sole_material' => 'Sole Material', 'inner_material' => 'Inner Material', 'boot_height' => 'Boot Height', 'heel_type' => 'Heels Type', 'heel_height' => 'Heel Height', 'toe_shap' => 'Toe Shape', 'closer' => 'Clouser Type', 'stretchable' => 'Stretchable', 'back_type' => 'Back Type', 'fit' => 'Fit', 'neckline' => 'Neck', 'with_hood' => 'With Hood', 'sleev_length' => 'Sleeves', 'collor' => 'Collar', 'type' => 'Type', 'fabric' => 'Fabric', 'top_fabric' => 'Top Fabric', 'bottom_fabric' => 'Bottom Fabric', 'duptta_fabric' => 'Dupatta Fabric', 'fabric_care' => 'Fabric Care', 'combo' => 'Combo', 'pack_of' => 'Pack Of', 'ideal_for' => 'Ideal For', 'generic_name' => 'Generic Name', 'highlights' => 'Highlight', 'weight' => 'Weight (Kg)', 'packet_length' => 'Packet Length (cm)', 'packet_weight' => 'Packet Width (cm)', 'packet_height' => 'Packet Height (cm)', 'country' => 'Country Of Origin', 'product_hsn' => 'Product HSN Code(2 4 6 8 Digits)', 'style_code' => 'Style Code', 'main_image' => 'Main Image Link', 'image1' => 'Sub Image Link-1', 'image2' => 'Sub Image Link-2', 'image3' => 'Sub Image Link-3', 'image4' => 'Sub Image Link-4', 'image5' => 'Sub Image Link-5');




        foreach ($object->getWorksheetIterator() as $worksheet)
        {
          $highestRow = $worksheet->getHighestRow();
          $highestColumn = $worksheet->getHighestColumn();



          $error = array();
          $column_value = array();
          $strt_count = '1';
          for ($row = 1; $row < 1000; $row++)
          {

            if ($row == 1)
            {


              $column_name[] = trim($worksheet->getCellByColumnAndRow(0, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(1, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(2, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(3, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(4, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(5, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(6, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(7, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(8, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(9, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(10, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(11, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(12, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(13, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(14, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(15, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(16, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(17, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(18, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(19, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(20, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(21, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(22, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(23, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(24, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(25, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(26, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(27, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(28, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(29, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(30, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(31, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(32, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(33, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(34, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(35, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(36, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(37, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(38, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(39, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(40, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(41, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(42, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(43, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(44, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(45, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(46, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(47, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(48, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(49, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(50, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(51, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(52, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(53, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(54, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(55, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(56, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(57, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(58, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(59, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(60, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(61, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(62, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(63, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(64, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(65, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(66, $row)->getValue());
              $column_name[] = trim($worksheet->getCellByColumnAndRow(67, $row)->getValue());




              $dbColumn = $this->chnage_column_value($column_name, $db_colunm);

            } else
            {




              $column_value[$dbColumn[0]] = trim($worksheet->getCellByColumnAndRow(0, $row)->getValue());
              $column_value[$dbColumn[1]] = trim($worksheet->getCellByColumnAndRow(1, $row)->getValue());
              $column_value[$dbColumn[2]] = trim($worksheet->getCellByColumnAndRow(2, $row)->getValue());
              $column_value[$dbColumn[3]] = trim($worksheet->getCellByColumnAndRow(3, $row)->getValue());
              $column_value[$dbColumn[4]] = trim($worksheet->getCellByColumnAndRow(4, $row)->getValue());
              $column_value[$dbColumn[5]] = trim($worksheet->getCellByColumnAndRow(5, $row)->getValue());
              $column_value[$dbColumn[6]] = trim($worksheet->getCellByColumnAndRow(6, $row)->getValue());
              $column_value[$dbColumn[7]] = trim($worksheet->getCellByColumnAndRow(7, $row)->getValue());
              $column_value[$dbColumn[8]] = trim($worksheet->getCellByColumnAndRow(8, $row)->getValue());
              $column_value[$dbColumn[9]] = trim($worksheet->getCellByColumnAndRow(9, $row)->getValue());
              $column_value[$dbColumn[10]] = trim($worksheet->getCellByColumnAndRow(10, $row)->getValue());
              $column_value[$dbColumn[11]] = trim($worksheet->getCellByColumnAndRow(11, $row)->getValue());
              $column_value[$dbColumn[12]] = trim($worksheet->getCellByColumnAndRow(12, $row)->getValue());
              $column_value[$dbColumn[13]] = trim($worksheet->getCellByColumnAndRow(13, $row)->getValue());
              $column_value[$dbColumn[14]] = trim($worksheet->getCellByColumnAndRow(14, $row)->getValue());
              $column_value[$dbColumn[15]] = trim($worksheet->getCellByColumnAndRow(15, $row)->getValue());
              $column_value[$dbColumn[16]] = trim($worksheet->getCellByColumnAndRow(16, $row)->getValue());
              $column_value[$dbColumn[17]] = trim($worksheet->getCellByColumnAndRow(17, $row)->getValue());
              $column_value[$dbColumn[18]] = trim($worksheet->getCellByColumnAndRow(18, $row)->getValue());
              $column_value[$dbColumn[19]] = trim($worksheet->getCellByColumnAndRow(19, $row)->getValue());
              $column_value[$dbColumn[20]] = trim($worksheet->getCellByColumnAndRow(20, $row)->getValue());
              $column_value[$dbColumn[21]] = trim($worksheet->getCellByColumnAndRow(21, $row)->getValue());
              $column_value[$dbColumn[22]] = trim($worksheet->getCellByColumnAndRow(22, $row)->getValue());
              $column_value[$dbColumn[23]] = trim($worksheet->getCellByColumnAndRow(23, $row)->getValue());
              $column_value[$dbColumn[24]] = trim($worksheet->getCellByColumnAndRow(24, $row)->getValue());
              $column_value[$dbColumn[25]] = trim($worksheet->getCellByColumnAndRow(25, $row)->getValue());
              $column_value[$dbColumn[26]] = trim($worksheet->getCellByColumnAndRow(26, $row)->getValue());
              $column_value[$dbColumn[27]] = trim($worksheet->getCellByColumnAndRow(27, $row)->getValue());
              $column_value[$dbColumn[28]] = trim($worksheet->getCellByColumnAndRow(28, $row)->getValue());
              $column_value[$dbColumn[29]] = trim($worksheet->getCellByColumnAndRow(29, $row)->getValue());
              $column_value[$dbColumn[30]] = trim($worksheet->getCellByColumnAndRow(30, $row)->getValue());
              $column_value[$dbColumn[31]] = trim($worksheet->getCellByColumnAndRow(31, $row)->getValue());
              $column_value[$dbColumn[32]] = trim($worksheet->getCellByColumnAndRow(32, $row)->getValue());
              $column_value[$dbColumn[33]] = trim($worksheet->getCellByColumnAndRow(33, $row)->getValue());
              $column_value[$dbColumn[34]] = trim($worksheet->getCellByColumnAndRow(34, $row)->getValue());

              $column_value[$dbColumn[35]] = trim($worksheet->getCellByColumnAndRow(35, $row)->getValue());
              $column_value[$dbColumn[36]] = trim($worksheet->getCellByColumnAndRow(36, $row)->getValue());
              $column_value[$dbColumn[37]] = trim($worksheet->getCellByColumnAndRow(37, $row)->getValue());
              $column_value[$dbColumn[38]] = trim($worksheet->getCellByColumnAndRow(38, $row)->getValue());
              $column_value[$dbColumn[39]] = trim($worksheet->getCellByColumnAndRow(39, $row)->getValue());
              $column_value[$dbColumn[40]] = trim($worksheet->getCellByColumnAndRow(40, $row)->getValue());

              $column_value[$dbColumn[41]] = trim($worksheet->getCellByColumnAndRow(41, $row)->getValue());
              $column_value[$dbColumn[42]] = trim($worksheet->getCellByColumnAndRow(42, $row)->getValue());

              $column_value[$dbColumn[43]] = trim($worksheet->getCellByColumnAndRow(43, $row)->getValue());
              $column_value[$dbColumn[44]] = trim($worksheet->getCellByColumnAndRow(44, $row)->getValue());
              $column_value[$dbColumn[45]] = trim($worksheet->getCellByColumnAndRow(45, $row)->getValue());
              $column_value[$dbColumn[46]] = trim($worksheet->getCellByColumnAndRow(46, $row)->getValue());
              $column_value[$dbColumn[47]] = trim($worksheet->getCellByColumnAndRow(47, $row)->getValue());
              $column_value[$dbColumn[48]] = trim($worksheet->getCellByColumnAndRow(48, $row)->getValue());
              $column_value[$dbColumn[49]] = trim($worksheet->getCellByColumnAndRow(49, $row)->getValue());
              $column_value[$dbColumn[50]] = trim($worksheet->getCellByColumnAndRow(50, $row)->getValue());
              $column_value[$dbColumn[51]] = trim($worksheet->getCellByColumnAndRow(51, $row)->getValue());
              $column_value[$dbColumn[52]] = trim($worksheet->getCellByColumnAndRow(52, $row)->getValue());
              $column_value[$dbColumn[53]] = trim($worksheet->getCellByColumnAndRow(53, $row)->getValue());
              $column_value[$dbColumn[54]] = trim($worksheet->getCellByColumnAndRow(54, $row)->getValue());
              $column_value[$dbColumn[55]] = trim($worksheet->getCellByColumnAndRow(55, $row)->getValue());
              $column_value[$dbColumn[56]] = trim($worksheet->getCellByColumnAndRow(56, $row)->getValue());
              $column_value[$dbColumn[57]] = trim($worksheet->getCellByColumnAndRow(57, $row)->getValue());
              $column_value[$dbColumn[58]] = trim($worksheet->getCellByColumnAndRow(58, $row)->getValue());
              $column_value[$dbColumn[59]] = trim($worksheet->getCellByColumnAndRow(59, $row)->getValue());
              $column_value[$dbColumn[60]] = trim($worksheet->getCellByColumnAndRow(60, $row)->getValue());
              $column_value[$dbColumn[61]] = trim($worksheet->getCellByColumnAndRow(61, $row)->getValue());
              $column_value[$dbColumn[62]] = trim($worksheet->getCellByColumnAndRow(62, $row)->getValue());
              $column_value[$dbColumn[63]] = trim($worksheet->getCellByColumnAndRow(63, $row)->getValue());
              $column_value[$dbColumn[64]] = trim($worksheet->getCellByColumnAndRow(64, $row)->getValue());
              $column_value[$dbColumn[65]] = trim($worksheet->getCellByColumnAndRow(65, $row)->getValue());
              $column_value[$dbColumn[66]] = trim($worksheet->getCellByColumnAndRow(66, $row)->getValue());

              $column_value[$dbColumn[67]] = trim($worksheet->getCellByColumnAndRow(67, $row)->getValue());
              unset($column_value['0']);


              $category_name = $column_value['category_id'];
              $sub_category_name = $column_value['sub_category_id'];
              $product_name = $column_value['product_name'];
              $color = (!empty($column_value['color'])) ? $column_value['color'] : '';




              if ($highestRow >= $strt_count)
              {

                if (!empty($category_name))
                {



                  $this->db->select('id');
                  $category_check = $this->db->get_where('category_master', array('category_name' => $category_name))->row_array();




                  $this->db->select('id,category_master_id');
                  $sub_cate_check = $this->db->get_where('sub_category_master', array('sub_category_name' => $sub_category_name, 'category_master_id' => $category_check['id']))->row_array();








                  /*Category Blank Check Condition*/

                  if (empty($category_name))
                  {

                    $this->db->where('unique_id', $unique_id);
                    $this->db->delete('sub_product_master');

                    $hold_error[] = 'Row No.- ' . $strt_count . ' Contains an error: “Category field can not be blank. For more details contact us.”';

                  }



                  /*Category not match Condition*/

                  if (empty($category_check))
                  {

                    $this->db->where('unique_id', $unique_id);
                    $this->db->delete('sub_product_master');

                    $hold_error[] = 'Row No.- ' . $strt_count . ' Contains an error: “Please fill the category name according to the given list of category on the website. For more details contact us.”';

                  }




                  /*Sub Category Blank Check Condition*/

                  if (empty($sub_category_name))
                  {

                    $this->db->where('unique_id', $unique_id);
                    $this->db->delete('sub_product_master');
                    $hold_error[] = 'Row No.- ' . $strt_count . ' Contain an error: “Sub category field can not be blank. For more details contact us.”';


                  }



                  /*Sub Category not match Condition*/

                  if (empty($sub_cate_check))
                  {

                    $this->db->where('unique_id', $unique_id);
                    $this->db->delete('sub_product_master');
                    $hold_error[] = 'Row No.- ' . $strt_count . ' Contain an error: “Please fill the Sub category name according to the given list of sub category on the website. For more details contact us.”';


                  }

                }
              }

              $prp = $column_value['product_code'];
              $sku = $column_value['sku_code'];

              $prp_code = explode("_", $prp);
              $prp_code1 = @$prp_code['0'];
              $prp_code2 = @$prp_code['1'];

              if (empty($prp_code['1']))
              {

                $sku_codee = 'UNKNOWN';

              } else
              {

                $sku_codee = $sku;
              }

              $product_code = explode("_", $prp);
              $str = preg_replace('/\D/', '', $sku);


              $column_value['shop_id'] = $data['shop_id'];
              $column_value['parent_category_id'] = $data['parent_id'];
              $column_value['category_id'] = $sub_cate_check['category_master_id'];
              $column_value['sub_category_id'] = $sub_cate_check['id'];
              $column_value['sku_code'] = $sku_codee;
              $column_value['color_code'] = $prp_code1 . '_' . $prp_code2 . '_' . $color;
              $column_value['product_code'] = $prp_code1 . '_' . $prp_code2;
              $column_value['unique_id'] = $unique_id;

              #################################  *All Excel Validation* ##############################


              if ($highestRow >= $strt_count)
              {

                if (!empty($category_name))
                {




                  /*Product code blank check condition*/

                  if (empty($prp))
                  {

                    $this->db->where('unique_id', $unique_id);
                    $this->db->delete('sub_product_master');

                    $hold_error[] = 'Row No.- ' . $strt_count . ' Contain an error: “Product code field can not be blank. For more details contact us”';
                  }





                  /*Main Image  blank check condition*/

                  if (empty($column_value['main_image']))
                  {

                    $this->db->where('unique_id', $unique_id);
                    $this->db->delete('sub_product_master');

                    $hold_error[] = 'Row No.- ' . $strt_count . ' Contains an error: “Main image field can not be blank. For more details contact us”';
                  }



                  /*Country  blank check condition*/

                  if (empty($column_value['country']))
                  {

                    $this->db->where('unique_id', $unique_id);
                    $this->db->delete('sub_product_master');

                    $hold_error[] = 'Row No.- ' . $strt_count . ' Contains an error: “Country of origin field can not be blank. For more details contact us”';
                  }



                  /*Quantity  blank check condition*/

                  if (empty($column_value['quantity']))
                  {

                    $this->db->where('unique_id', $unique_id);
                    $this->db->delete('sub_product_master');

                    $hold_error[] = 'Row No.- ' . $strt_count . ' Contains an error: “Quantity field can not be blank. For more details contact us”';

                  }

                  $quantityyy = is_numeric($column_value['quantity']);



                  /*Quantity  numeric check condition*/

                  if (!empty($column_value['quantity']))
                  {

                    if ($quantityyy != 1)
                    {

                      $this->db->where('unique_id', $unique_id);
                      $this->db->delete('sub_product_master');

                      $hold_error[] = 'Row No.- ' . $strt_count . ' Contains an error: “Quantity should be in numeric form. For more details contact us”';
                    }

                  }



                  /*Weight Blank check condition*/

                  if (empty($column_value['weight']))
                  {

                    $this->db->where('unique_id', $unique_id);
                    $this->db->delete('sub_product_master');


                    $hold_error[] = 'Row No.- ' . $strt_count . ' Contains an error: “Please fill the Weight according to the set pattern mentioned in help sheet. For more details contact us”';

                  }





                  /*Weight  numeric check condition*/

                  if (!empty($column_value['weight']))
                  {

                    $weighttt = is_numeric($column_value['weight']);

                    if ($weighttt != 1)
                    {

                      $this->db->where('unique_id', $unique_id);
                      $this->db->delete('sub_product_master');

                      $hold_error[] = 'Row No.- ' . $strt_count . ' Contains an error: “Weight should be in numeric form and value should be in Kilogram i.e for example, 450 Gram it should be 0.450. For more details contact us”';
                    }

                  }






                  /*Packet Length Blank check condition*/

                  if (empty($column_value['packet_length']))
                  {

                    $this->db->where('unique_id', $unique_id);
                    $this->db->delete('sub_product_master');

                    $hold_error[] = 'Row No.- ' . $strt_count . ' Contains an error: “Packet length field can not be blank. For more details contact us”';
                  }



                  /*Packet length  numeric check condition*/

                  if (!empty($column_value['packet_length']))
                  {

                    $packet_length = is_numeric($column_value['packet_length']);

                    if ($packet_length != 1)
                    {

                      $this->db->where('unique_id', $unique_id);
                      $this->db->delete('sub_product_master');

                      $hold_error[] = 'Row No.- ' . $strt_count . ' Contains an error: “Packet Length should be in numeric form and value should be in Centimeter. For more details contact us”';
                    }
                  }



                  /*Packet width  blank check condition*/
                  if (empty($column_value['packet_weight']))
                  {

                    $this->db->where('unique_id', $unique_id);
                    $this->db->delete('sub_product_master');

                    $hold_error[] = 'Row No.- ' . $strt_count . ' Contains an error: “Packet width field can not be blank. For more details contact us”';
                  }



                  /*Packet width  numeric check condition*/

                  if (!empty($column_value['packet_weight']))
                  {

                    $packet_width = is_numeric($column_value['packet_weight']);

                    if ($packet_width != 1)
                    {


                      $this->db->where('unique_id', $unique_id);
                      $this->db->delete('sub_product_master');

                      $hold_error[] = 'Row No.- ' . $strt_count . ' Contains an error: “Packet width should be in numeric form and value should be in Centimeter. For more details contact us”';
                    }
                  }







                  /*Packet Height  Blank check condition*/

                  if (empty($column_value['packet_height']))
                  {

                    $this->db->where('unique_id', $unique_id);
                    $this->db->delete('sub_product_master');

                    $hold_error[] = 'Row No.- ' . $strt_count . ' Contains an error: “Packet height field can not be blank. For more details contact us”';
                  }





                  /*Packet Height  numeric check condition*/
                  $packet_height = is_numeric($column_value['packet_height']);

                  if ($packet_height != 1)
                  {

                    $this->db->where('unique_id', $unique_id);
                    $this->db->delete('sub_product_master');

                    $hold_error[] = 'Row No.- ' . $strt_count . ' Contains an error: “Packet Height should be in numeric form and value should be in Centimeter. For more details contact us”';
                  }





                  /*Selling Price  Blank check condition*/

                  if (empty($column_value['final_price']))
                  {

                    $this->db->where('unique_id', $unique_id);
                    $this->db->delete('sub_product_master');

                    $hold_error[] = 'Row No.- ' . $strt_count . ' Contain an error: “Selling price field can not be blank. For more details contact us”';

                  }


                  /*Selling Price  Numeric check condition*/

                  if (!empty($column_value['final_price']))
                  {

                    $final_price = is_numeric($column_value['final_price']);

                    if ($final_price != 1)
                    {

                      $this->db->where('unique_id', $unique_id);
                      $this->db->delete('sub_product_master');

                      $hold_error[] = 'Row No.- ' . $strt_count . ' Contain an error: “Selling Price should be in numeric form. For more details contact us.”';


                    }

                  }



                  /*MRP  Blank check condition*/

                  if (empty($column_value['price']))
                  {

                    $this->db->where('unique_id', $unique_id);
                    $this->db->delete('sub_product_master');

                    $hold_error[] = 'Row No.- ' . $strt_count . ' Contains an error: “MRP according field can not be blank. For more details contact us”';

                  }


                  /*MRP  Numeric check condition*/

                  if (!empty($column_value['price']))
                  {

                    $price = is_numeric($column_value['price']);

                    if ($price != 1)
                    {

                      $this->db->where('unique_id', $unique_id);
                      $this->db->delete('sub_product_master');

                      $hold_error[] = 'Row No.- ' . $strt_count . ' Contains an error: “MRP should be in numeric form. For more details contact us”';
                    }

                  }


                  /*SP AND  MRP Price Diffrence check condition*/

                  if (!empty($column_value['final_price']) and !empty($column_value['price']))
                  {

                    if ($column_value['price'] < $column_value['final_price'])
                    {

                      $this->db->where('unique_id', $unique_id);
                      $this->db->delete('sub_product_master');

                      $hold_error[] = 'Row No.- ' . $strt_count . ' Contains an error: “MRP should not be less than the selling price. For more details contact us”';

                    }
                  }

                }

              }






              ############################################### End All Validation ###############




              if ($adminData['Type'] == '1')
              {

                $column_value['verify_status'] = '1';
                $column_value['added_type'] = '1';
                $column_value['addedBy'] = '1';
                $column_value['status'] = '1';
              } else
              {

                $column_value['verify_status'] = '2';
                $column_value['added_type'] = '2';
                $column_value['addedBy'] = $adminData['Id'];
                $column_value['status'] = '2';
              }

              $column_value['add_date'] = time();
              $column_value['modify_date'] = time();

              $hold_column_value[] = $column_value;

              if ($highestRow == $strt_count)
              {

                if (!empty($hold_error[0]))
                {

                  $error_html = '';
                  $error_html .= '<ul>';
                  foreach ($hold_error as $key => $hold_error_value)
                  {
                    if (!empty($hold_error_value))
                    {
                      $error_html .= '<li>' . $hold_error_value . '<li>';
                    }

                  }

                  $error_html .= '</ul>';


                  $this->session->set_flashdata('activate', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button>' . $error_html . '</div></div>');
                  redirect('admin/Product/AddBulkProduct/');


                } else
                {



                  $this->saveExcelData($hold_column_value);





                }



              }



            }














            $strt_count++;
          }
          exit;




        }

      }
    }

  }



  public function saveExcelData($hold_column_value_array)
  {

    foreach ($hold_column_value_array as $key => $column_value)
    {
      if (!empty($column_value['product_name']))
      {

        $this->db->insert('sub_product_master', $column_value);

      }
    }

    $this->session->set_flashdata('activate', getCustomAlert('S', 'Product  Uploaded successfully.'));
    redirect('admin/Product/AddBulkProduct/');


  }







  public function chnage_column_value($column_name, $db_colunm)
  {
    //print_r($column_name);die;
    $newarray = array();
    $count = count($column_name);
    foreach ($column_name as $key => $value)
    {
      $newarray[] = array_search($value, $db_colunm);
    }
    return $newarray;
  }






  public function upload_file()
  {
    $adminData = $this->session->userdata('adminData');
    $this->db->select('mobile');
    $staff = $this->db->get_where('staff_master', array('id' => $adminData['Id']))->row_array();
    $fileName = $_FILES["excel"]["name"];
    $extension = explode('.', $fileName);
    $extension = strtolower(end($extension));
    $uniqueName = $adminData['Name'] . '_' . time() . '.' . $extension;
    $type = $_FILES["excel"]["type"];
    $size = $_FILES["excel"]["size"];
    $tmp_name = $_FILES['excel']['tmp_name'];
    $targetlocation = EXCEL_DIRECTORY . $uniqueName;
    if (!empty($fileName))
    {
      move_uploaded_file($tmp_name, $targetlocation);
    }

    $msg = 'Dear admin, Product Upload by:  ' . $adminData['Name'] . ', Mobile number: ' . $staff['mobile'];
    sendSMS('9721262642', $msg);
    sendSMS('9807626339', $msg);
    $this->session->set_flashdata('activate', getCustomAlert('S', 'product  uploaded successfully wait for admin approval.'));
    redirect('admin/Product/AddBulkProduct/');
  }







  public function index($v_id = '')
  {
    $adminData = $this->session->userdata('adminData');
    $pageNo = !empty($_GET['per_page']) ? $_GET['per_page'] : 1;
    $limit = 20;
    $offset = ($pageNo - 1) * $limit;

    $shop_id = $this->input->post('shop_id');
    $vendor_id = $this->input->post('vendor_id');
    $keywords = $this->input->post('keywords');

    /* ===============================
       BASE QUERY
       =============================== */
    $this->db->from('sub_product_master as sp');
    $this->db->select('sp.id, sp.shop_id, sp.vendor_id, sp.promoter_id, sp.sub_category_id, sp.category_id, sp.product_code, sp.sku_code, 
                       sp.product_name, sp.price, sp.size, sp.color, sp.final_price, sp.quantity, sp.verify_status, sp.added_type, sp.addedBy,
                       s.name as shop_name, v.name as vendor_name, v.shop_name,v.vendor_logo, sc.sub_category_name, cc.category_name, pc.name,
                       p.name as promoter_name, p.shop_name, p.promoter_logo,');

    // Join shops and vendors
    $this->db->join('shop_master as s', 's.id = sp.shop_id', 'left');
    $this->db->join('vendors as v', 'v.id = sp.vendor_id', 'left');
    $this->db->join('promoters as p', 'p.id = sp.promoter_id', 'left');
    $this->db->join('parent_category_master as pc', 'pc.id = sp.parent_category_id', 'left');
    $this->db->join('sub_category_master as sc', 'sc.id = sp.sub_category_id', 'left');
    $this->db->join('category_master as cc', 'cc.id = sp.category_id', 'left');

    /* ===============================
       ROLE BASED FILTERING
       =============================== */

    // ================= ADMIN =================
    if ($adminData['Type'] == '1')
    {
      // Filter by Vendor → get all shops for that vendor
      if (!empty($vendor_id))
      {
        $shops = $this->db->get_where('shop_master', ['vendor_id' => $vendor_id])->result_array();
        $shop_array = array_column($shops, 'id');

        if (!empty($shop_array))
        {
          $this->db->where_in('sp.shop_id', $shop_array);
        } else
        {
          $this->db->where('sp.id', 0); // No records
        }
      }

      // Filter by Shop
      if (!empty($shop_id))
      {
        $this->db->where('sp.shop_id', $shop_id);
      }

      // Search by Keyword
      if (!empty($keywords))
      {
        $this->db->like('sp.product_name', $keywords);
      }
    }

    // ================= VENDOR =================
    elseif ($adminData['Type'] == '2')
    {
      $this->db->where('sp.vendor_id', $adminData['Id']);
      $this->db->where('sp.added_type', '2');

      if (!empty($shop_id))
      {
        $this->db->where('sp.shop_id', $shop_id);
      }

      if (!empty($keywords))
      {
        $this->db->like('sp.product_name', $keywords);
      }
    }

    // ================= PROMOTER =================
    elseif ($adminData['Type'] == '3')
    {
      $this->db->where('sp.promoter_id', $adminData['Id']);
      $this->db->where('sp.added_type', '3');

      if (!empty($vendor_id))
      {
        $this->db->where('sp.vendor_id', $vendor_id);
      }

      if (!empty($shop_id))
      {
        $this->db->where('sp.shop_id', $shop_id);
      }

      if (!empty($keywords))
      {
        $this->db->like('sp.product_name', $keywords);
      }
    }

    /* ===============================
       TOTAL COUNT
       =============================== */
    $totalRecords = $this->db->count_all_results('', false); // Keep query for pagination

    /* ===============================
       PAGINATION
       =============================== */
    $this->db->order_by('sp.id', 'desc');
    $this->db->limit($limit, $offset);
    $AllRecord = $this->db->get()->result_array();

    $entries = 'Showing ' . ($offset + 1) . ' to ' . ($offset + count($AllRecord)) . ' of ' . $totalRecords . ' entries';

    $config["base_url"] = base_url('admin/Product/index?keyword=');
    $config["total_rows"] = $totalRecords;
    $config["per_page"] = $limit;
    $config['use_page_numbers'] = TRUE;
    $config['page_query_string'] = TRUE;
    $config['num_links'] = 3;
    $config['cur_tag_open'] = '&nbsp;<li class="active"><a>';
    $config['cur_tag_close'] = '</a></li>';
    $config['next_link'] = 'Next';
    $config['prev_link'] = 'Previous';

    $this->pagination->initialize($config);
    $str_links = $this->pagination->create_links();
    $links = explode('&nbsp;', $str_links);

    /* ===============================
       SHOP & VENDOR LISTS (FILTER DROPDOWNS)
       =============================== */
    if ($adminData['Type'] == '1')
    {
      $data['shopList'] = $this->db->get_where('shop_master', ['status' => '1'])->result_array();
      $data['vendorList'] = $this->db->get_where('vendors', ['status' => '1'])->result_array();
    } elseif ($adminData['Type'] == '2')
    {
      $data['shopList'] = $this->db->get_where('shop_master', ['status' => '1', 'vendor_id' => $adminData['Id']])->result_array();
      $data['vendorList'] = [];
    } elseif ($adminData['Type'] == '3')
    {
      $data['vendorList'] = $this->db->get_where('vendors', ['status' => '1', 'promoter_id' => $adminData['Id']])->result_array();

      $this->db->select('shop_master.*');
      $this->db->from('shop_master');
      $this->db->join('vendors', 'vendors.id = shop_master.vendor_id');
      $this->db->where('vendors.promoter_id', $adminData['Id']);
      $this->db->where('shop_master.status', '1');
      $data['shopList'] = $this->db->get()->result_array();
    }

    /* ===============================
       SEND DATA TO VIEW
       =============================== */
    $data += [
      'totalResult' => $totalRecords,
      'shop_id' => $shop_id,
      'vendor_id' => $vendor_id,
      'results' => $AllRecord,
      'pano' => $pageNo,
      'links' => $links,
      'index2' => '',
      'v_id' => $v_id,
      'index' => 'Product',
      'entries' => $entries,
      'title' => 'Manage Products'
    ];

    $this->load->view('include/header', $data);
    $this->load->view('Product/ProductList', $data);
    $this->load->view('include/footer');
  }

  public function VendorProductList($v_id = '')
  {
    $adminData = $this->session->userdata('adminData');
    $pageNo = !empty($_GET['per_page']) ? $_GET['per_page'] : 1;
    $limit = 20;
    $offset = ($pageNo - 1) * $limit;

    $shop_id = $this->input->post('shop_id');
    $vendor_id = $this->input->post('vendor_id');
    $keywords = $this->input->post('keywords');

    /* ===============================
       BASE QUERY
       =============================== */
    $this->db->from('sub_product_master as sp');
    $this->db->select('sp.id, sp.shop_id, sp.vendor_id, sp.promoter_id, sp.sub_category_id, sp.category_id, sp.product_code, sp.sku_code, 
                       sp.product_name, sp.price, sp.size, sp.color, sp.final_price, sp.quantity, sp.verify_status, sp.added_type, sp.addedBy,
                       s.name as shop_name, v.name as vendor_name,v.shop_name, v.vendor_logo, sc.sub_category_name, cc.category_name, pc.name');

    // Join shops and vendors
    $this->db->join('shop_master as s', 's.id = sp.shop_id', 'left');
    $this->db->join('vendors as v', 'v.id = sp.vendor_id', 'left');
    $this->db->join('parent_category_master as pc', 'pc.id = sp.parent_category_id', 'left');
    $this->db->join('sub_category_master as sc', 'sc.id = sp.sub_category_id', 'left');
    $this->db->join('category_master as cc', 'cc.id = sp.category_id', 'left');

    // ================= ADMIN =================
    if ($adminData['Type'] == '1')
    {
      // Filter by Vendor → get all shops for that vendor
      if (!empty($vendor_id))
      {
        $shops = $this->db->get_where('shop_master', ['vendor_id' => $vendor_id])->result_array();
        $shop_array = array_column($shops, 'id');

        if (!empty($shop_array))
        {
          $this->db->where_in('sp.shop_id', $shop_array);
        } else
        {
          $this->db->where('sp.id', 0); // No records
        }
      }

      // Filter by Shop
      if (!empty($shop_id))
      {
        $this->db->where('sp.shop_id', $shop_id);
      }

      // Search by Keyword
      if (!empty($keywords))
      {
        $this->db->like('sp.product_name', $keywords);
      }
    }

    // ================= VENDOR =================
    elseif ($adminData['Type'] == '2')
    {
      $this->db->where('sp.vendor_id', $adminData['Id']);
      $this->db->where('sp.added_type', '2');

      if (!empty($shop_id))
      {
        $this->db->where('sp.shop_id', $shop_id);
      }

      if (!empty($keywords))
      {
        $this->db->like('sp.product_name', $keywords);
      }
    }

    // ================= PROMOTER =================
    elseif ($adminData['Type'] == '3')
    {
      $this->db->where('sp.promoter_id', $adminData['Id']);
      $this->db->where('sp.added_type', '3');

      if (!empty($vendor_id))
      {
        $this->db->where('sp.vendor_id', $vendor_id);
      }

      if (!empty($shop_id))
      {
        $this->db->where('sp.shop_id', $shop_id);
      }

      if (!empty($keywords))
      {
        $this->db->like('sp.product_name', $keywords);
      }
    }

    /* ===============================
       TOTAL COUNT
       =============================== */
    $totalRecords = $this->db->count_all_results('', false);

    /* ===============================
       PAGINATION
       =============================== */
    $this->db->order_by('sp.id', 'desc');
    $this->db->limit($limit, $offset);
    $AllRecord = $this->db->get()->result_array();

    $entries = 'Showing ' . ($offset + 1) . ' to ' . ($offset + count($AllRecord)) . ' of ' . $totalRecords . ' entries';

    $config["base_url"] = base_url('admin/Product/VendorProductList?keyword=');
    $config["total_rows"] = $totalRecords;
    $config["per_page"] = $limit;
    $config['use_page_numbers'] = TRUE;
    $config['page_query_string'] = TRUE;
    $config['num_links'] = 3;
    $config['cur_tag_open'] = '&nbsp;<li class="active"><a>';
    $config['cur_tag_close'] = '</a></li>';
    $config['next_link'] = 'Next';
    $config['prev_link'] = 'Previous';

    $this->pagination->initialize($config);
    $str_links = $this->pagination->create_links();
    $links = explode('&nbsp;', $str_links);

    /* ===============================
       SHOP & VENDOR LISTS (FILTER DROPDOWNS)
       =============================== */
    if ($adminData['Type'] == '1')
    {
      $data['shopList'] = $this->db->get_where('shop_master', ['status' => '1'])->result_array();
      $data['vendorList'] = $this->db->get_where('vendors', ['status' => '1'])->result_array();
    } elseif ($adminData['Type'] == '2')
    {
      $data['shopList'] = $this->db->get_where('shop_master', ['status' => '1', 'vendor_id' => $adminData['Id']])->result_array();
      $data['vendorList'] = [];
    } elseif ($adminData['Type'] == '3')
    {
      $data['vendorList'] = $this->db->get_where('vendors', ['status' => '1', 'promoter_id' => $adminData['Id']])->result_array();

      $this->db->select('shop_master.*');
      $this->db->from('shop_master');
      $this->db->join('vendors', 'vendors.id = shop_master.vendor_id');
      $this->db->where('vendors.promoter_id', $adminData['Id']);
      $this->db->where('shop_master.status', '1');
      $data['shopList'] = $this->db->get()->result_array();
    }

    /* ===============================
       SEND DATA TO VIEW
       =============================== */
    $data += [
      'totalResult' => $totalRecords,
      'shop_id' => $shop_id,
      'vendor_id' => $vendor_id,
      'results' => $AllRecord,
      'pano' => $pageNo,
      'links' => $links,
      'index2' => '',
      'v_id' => $v_id,
      'index' => 'Product',
      'entries' => $entries,
      'title' => 'Manage Products'
    ];

    $this->load->view('include/header', $data);
    $this->load->view('Product/VendorProductList', $data);
    $this->load->view('include/footer');
  }


  public function PromoterProductList($p_id = '')
  {
    $adminData = $this->session->userdata('adminData');
    if (!$adminData)
    {
      redirect('admin/login');
    }
    $data['adminData'] = $adminData;

        $active_subscription = $this->Subscription_model->getActiveSubscription($adminData['Id'], 'promoter');
        $pending_request = $this->Subscription_model->getPendingSubscriptionRequest($adminData['Id'], 'promoter');
        $data['show_subscription_popup'] = (empty($active_subscription) && empty($pending_request)) ? 1 : 0;

        $data['plans'] = $this->db->where('status',1)->get('admin_subscription_plans_master')->result_array();
        $data['default_plan'] = [];



    /* ===============================
       PAGINATION
       =============================== */
    $pageNo = !empty($_GET['per_page']) ? $_GET['per_page'] : 1;
    $limit = 20;
    $offset = ($pageNo - 1) * $limit;

    $shop_id = $this->input->post('shop_id');
    $vendor_id = $this->input->post('vendor_id');
    $keywords = $this->input->post('keywords');

    /* ===============================
       BASE QUERY
       =============================== */
    $this->db->from('sub_product_master as sp');
    $this->db->select('
        sp.*,
        s.name as shop_name,
        v.shop_name as vendor_shop_name,
        p.shop_name as promoter_shop_name,
        sc.sub_category_name,
        cc.category_name,
        pc.name as parent_category_name
    ');

    $this->db->join('shop_master s', 's.id = sp.shop_id', 'left');
    $this->db->join('vendors v', 'v.id = sp.vendor_id', 'left');
    $this->db->join('promoters p', 'p.id = sp.promoter_id', 'left');
    $this->db->join('parent_category_master pc', 'pc.id = sp.parent_category_id', 'left');
    $this->db->join('sub_category_master sc', 'sc.id = sp.sub_category_id', 'left');
    $this->db->join('category_master cc', 'cc.id = sp.category_id', 'left');

    /* ===============================
       PROMOTER FILTER
       =============================== */
    if ($adminData['Type'] == 3)
    {
      $this->db->where('sp.promoter_id', $adminData['Id']);
      $this->db->where('sp.added_type', 3);

      if (!empty($vendor_id))
      {
        $this->db->where('sp.vendor_id', $vendor_id);
      }

      if (!empty($shop_id))
      {
        $this->db->where('sp.shop_id', $shop_id);
      }

      if (!empty($keywords))
      {
        $this->db->like('sp.product_name', $keywords);
      }
    }

    /* ===============================
       COUNT
       =============================== */
    $totalRecords = $this->db->count_all_results('', false);

    /* ===============================
       FETCH DATA
       =============================== */
    $this->db->order_by('sp.id', 'desc');
    $this->db->limit($limit, $offset);
    $AllRecord = $this->db->get()->result_array();

    $entries = 'Showing ' . ($offset + 1) . ' to ' .
      ($offset + count($AllRecord)) . ' of ' . $totalRecords . ' entries';

    /* ===============================
       PAGINATION LINKS
       =============================== */
    $this->load->library('pagination');

    $config['base_url'] = base_url('admin/Product/PromoterProductList');
    $config['total_rows'] = $totalRecords;
    $config['per_page'] = $limit;
    $config['use_page_numbers'] = TRUE;
    $config['page_query_string'] = TRUE;

    $this->pagination->initialize($config);
    $links = explode('&nbsp;', $this->pagination->create_links());

    /* ===============================
       SHOP LIST
       =============================== */
    $data['shopList'] = $this->db
      ->select('sp.shop_id, s.name as shop_name')
      ->from('sub_product_master sp')
      ->join('shop_master s', 's.id = sp.shop_id', 'left')
      ->where('sp.promoter_id', $adminData['Id'])
      ->group_by('sp.shop_id')
      ->get()
      ->result_array();

    /* ===============================
       SEND DATA
       =============================== */
    $data += [
      'results' => $AllRecord,
      'totalResult' => $totalRecords,
      'links' => $links,
      'entries' => $entries,
      'index' => 'Product',
      'title' => 'Manage Products'
    ];

    $this->load->view('include/header', $data);
    $this->load->view('Product/PromoterProductList', $data);
    $this->load->view('include/footer');
  }




  function updateproductstatus()
  {
    $user_id = $_POST['user_id'];
    $status = $_POST['status'];
    $newStatus = '';

    if ($status == '1')
    {
      $newStatus = '2';
    } else if ($status == '2')
    {
      $newStatus = '1';
    }

    $row = array('approving_status' => $newStatus);
    $this->db->where('id', $user_id);
    $this->db->update('product_master', $row);
    echo 1;
  }



  public function save_general_info()
  {
    $data = $this->input->post();
    $fields['shop_id'] = $data['shop_id'];
    $fields['parent_id'] = $data['par_cat_master_ID'];
    $fields['category_id'] = $data['cat_master_ID'];
    $fields['sub_category_id'] = $data['sub_master_ID'];
    $fields['product_name'] = $data['ProductName'];
    $fields['sku_code'] = $data['sku_code'];
    $fields['product_description'] = $data['product_description'];

    if (empty($data['id']))
    {
      $this->db->insert('tab_general_information', $fields);
    } else
    {
      $this->db->where('id', $data['id']);
      $this->db->update('tab_general_information', $fields);
    }

    redirect('admin/Product/AddProduct/?tab=2');

  }


  public function save_general_info2($id)
  {
    $data = $this->input->post();
    $fields['shop_id'] = $data['shop_id'];
    $fields['parent_id'] = $data['par_cat_master_ID'];
    $fields['category_id'] = $data['CatId'];
    $fields['sub_category_id'] = $data['SubCat'];
    $fields['product_name'] = $data['ProductName'];
    $fields['sku_code'] = $data['sku_code'];
    $fields['product_description'] = $data['product_description'];

    if (empty($data['id']))
    {
      $this->db->insert('tab_general_information', $fields);
    } else
    {
      $this->db->where('id', $data['id']);
      $this->db->update('tab_general_information', $fields);
    }

    redirect('admin/Product/UpdateProduct/' . $id . '?tab=2');

  }

  public function save_color_size()
  {
    $data = $this->input->post();

    $this->db->where_not_in('id', '555555555555555555555555555555555555555555555');
    $this->db->delete('tab_color_master');

    $this->db->where_not_in('id', '55555555555555555555555555555555555555555555555');
    $this->db->delete('tab_size_master');

    $color_item = count($data['color']);

    for ($i = 0; $i < $color_item; $i++)
    {

      $fields['color'] = $data['color'][$i];

      $this->db->insert('tab_color_master', $fields);

      $insert_id = $this->db->insert_id();

      $size_item = count($data['size' . $i]);

      for ($j = 0; $j < $size_item; $j++)
      {

        $field['color_id'] = $insert_id;
        $field['size'] = $data['size' . $i][$j];
        $this->db->insert('tab_size_master', $field);

      }
    }

    redirect('admin/Product/AddProduct/?tab=3');

  }



  // public function save_color_size2($id)
// {
//     $colors = $this->input->post('color');
//     $sizes = $this->input->post('size');
//     $color_ids = $this->input->post('color_id'); 

  //     foreach ($colors as $index => $color)
//     {
//         $color = trim($color);

  //         $size_array = isset($sizes[$index]) ? $sizes[$index] : [];
//         $size = is_array($size_array) ? implode(',', $size_array) : $size_array;

  //         $pro_id = $color_ids[$index];


  //         $this->db->where('pro_id', $pro_id);
//         $this->db->update('tab_color_size_master', [
//             'color' => $color,
//             'size' => $size
//         ]);


  //         $this->db->where('pro_id', $pro_id);
//         $this->db->update('tab_color_master', [
//             'color' => $color
//         ]);


  //         $this->db->where('pro_id', $pro_id);
//         $this->db->update('tab_size_master', [
//             'color_id' => $color,
//             'size' => $size
//         ]);


  //         $this->db->where('id', $pro_id);
//         $this->db->update('sub_product_master', [
//             'color' => $color,
//             'size' => $size
//         ]);
//     }

  //     $this->session->set_flashdata('success', 'Color & Size updated successfully.');
//     redirect('admin/Product/UpdateProduct/' . $id . '?tab=3');
// }




  public function save_color_size2($id)
  {
    $colors = $this->input->post('color');
    $sizes = $this->input->post('size');
    $color_ids = $this->input->post('color_id'); // existing rows ID

    foreach ($colors as $index => $color)
    {
      $color = trim($color);

      // read size array safely
      $size_array = isset($sizes[$index]) ? $sizes[$index] : [];
      $size = is_array($size_array) ? implode(',', $size_array) : $size_array;

      // existing row id (for update)
      $pro_id = isset($color_ids[$index]) ? $color_ids[$index] : '';

      // ===============================
      // UPDATE EXISTING ROW
      // ===============================
      if (!empty($pro_id))
      {
        // tab_color_size_master
        $this->db->where('pro_id', $pro_id);
        $this->db->update('tab_color_size_master', [
          'color' => $color,
          'size' => $size
        ]);

        // tab_color_master
        $this->db->where('pro_id', $pro_id);
        $this->db->update('tab_color_master', [
          'color' => $color
        ]);

        // tab_size_master
        $this->db->where('pro_id', $pro_id);
        $this->db->update('tab_size_master', [
          'color_id' => $color,
          'size' => $size
        ]);

        // sub_product_master
        $this->db->where('id', $pro_id);
        $this->db->update('sub_product_master', [
          'color' => $color,
          'size' => $size
        ]);
      } else
      {
        // ===============================
        // INSERT NEW ROW
        // ===============================

        // 1. Insert into sub_product_master
        $this->db->insert('sub_product_master', [

          'color' => $color,
          'size' => $size
        ]);
        $new_id = $this->db->insert_id();

        // 2. tab_color_size_master
        $this->db->insert('tab_color_size_master', [
          'product_id' => $id,
          'pro_id' => $new_id,
          'color' => $color,
          'size' => $size
        ]);

        // 3. tab_color_master
        $this->db->insert('tab_color_master', [
          'product_id' => $id,
          'pro_id' => $new_id,
          'color' => $color
        ]);

        // 4. tab_size_master
        $this->db->insert('tab_size_master', [
          'product_id' => $id,
          'pro_id' => $new_id,
          'color_id' => $color,
          'size' => $size
        ]);
      }
    }

    $this->session->set_flashdata('success', 'Color & Size updated successfully.');
    redirect('admin/Product/UpdateProduct/' . $id . '?tab=3');
  }




  public function color_size()
  {
    $data = $this->input->post();
    $item = count($data['color']);

    $this->db->where_not_in('id', '55555555555555555555555555555555555555555555555');
    $this->db->delete('tab_color_size_master');

    for ($i = 0; $i < $item; $i++)
    {

      $field['color'] = $data['color'][$i];
      $field['size'] = $data['size'][$i];
      $field['final_price'] = $data['sp'][$i];
      $field['price'] = $data['mrp'][$i];
      $field['qty'] = $data['qty'][$i];
      $field['gst'] = $data['gst'][$i];
      $this->db->insert('tab_color_size_master', $field);

    }

    redirect('admin/Product/AddProduct/?tab=4');

  }



  public function color_size2($id)
  {
    $data = $this->input->post();
    $itemCount = count($data['color'] ?? []);

    for ($i = 0; $i < $itemCount; $i++)
    {
      $color = $data['color'][$i] ?? '';
      $size = $data['size'][$i] ?? '';
      $sp = $data['sp'][$i] ?? 0;
      $mrp = $data['mrp'][$i] ?? 0;
      $qty = $data['qty'][$i] ?? 0;
      $gst = $data['gst'][$i] ?? 0;


      $field = [
        'final_price' => $sp,
        'price' => $mrp,
        'qty' => $qty,
        'type' => '2',
        'product_id' => $id
      ];
      if ($this->db->field_exists('gst', 'tab_color_size_master'))
      {
        $field['gst'] = $gst;
      }
      $exist = $this->db->get_where('tab_color_size_master', [
        'product_id' => $id,
        'color' => $color,
        'size' => $size
      ])->row_array();

      if ($exist)
      {
        $this->db->where('id', $exist['id']);
        $this->db->update('tab_color_size_master', $field);
      } else
      {
        $field['pro_id'] = $id;
        $field['color'] = $color;
        $field['size'] = $size;
        $this->db->insert('tab_color_size_master', $field);
      }

      // Update sub_product_master
      $product_code = $this->db->get_where('sub_product_master', ['id' => $id])->row('product_code');
      $updateSubProduct = [
        'price' => $mrp,
        'final_price' => $sp,
        'quantity' => $qty
      ];
      if ($this->db->field_exists('gst', 'sub_product_master'))
      {
        $updateSubProduct['gst'] = $gst;
      }

      $this->db->where([
        'product_code' => $product_code,
        'color' => $color,
        'size' => $size
      ])->update('sub_product_master', $updateSubProduct);
    }

    $this->session->set_flashdata('success', 'Color-size and GST updated successfully.');
    redirect('admin/Product/UpdateProduct/' . $id . '?tab=4');
  }
















  public function color_size_images()
  {
    $data = $this->input->post();
    $item = count($data['color_id']);


    $hold = array();
    for ($i = 0; $i < $item; $i++)
    {

      $hold[] = $data['color_id'][$i];

      $fileName = $_FILES["thumbnail"]["name"][$i];
      $extension = explode('.', $fileName);
      $extension = strtolower(end($extension));
      $uniqueName = 'prod_' . uniqid() . '.' . $extension;
      $type = $_FILES["thumbnail"]["type"][$i];
      $size = $_FILES["thumbnail"]["size"][$i];
      $tmp_name = $_FILES['thumbnail']['tmp_name'][$i];
      $targetlocation = PRODUCT_DIRECTORY . $uniqueName;

      if (!empty($fileName))
      {
        move_uploaded_file($tmp_name, $targetlocation);
        $fields['main_image'] = utf8_encode(trim($uniqueName));
      }


      if (!empty($_FILES["thumbnail"]["name"][$i]))
      {
        $this->db->where('id', $data['color_id'][$i]);
        $this->db->update('tab_color_master', $fields);

      }

      $this->uploadMultiImg($i, $data);


    }



    redirect('admin/Product/AddProduct/?tab=5');

  }

  public function uploadMultiImg($i, $data)
  {

    $count = 0;

    foreach ($_FILES['images' . $i]['name'] as $item => $item_name)
    {

      $fileName = $_FILES['images' . $i]['name'][$item];
      $extension = pathinfo($fileName, PATHINFO_EXTENSION);
      $uniqueName = 'prod_' . uniqid() . '.' . $extension;
      $targetLocation = PRODUCT_DIRECTORY . $uniqueName;
      $tmpName = $_FILES['images' . $i]['tmp_name'][$item];

      if (!empty($fileName))
      {

        move_uploaded_file($tmpName, $targetLocation);

        $fieldToUpdate = array('image' . ($count + 1) => utf8_encode(trim($uniqueName)));

        $this->db->where('id', $data['color_id'][$i]);
        $this->db->update('tab_color_master', $fieldToUpdate);

        $count++;
      }
    }
  }










  public function color_size_images2($id)
  {
    $data = $this->input->post();
    $item = count($data['color_id']);

    for ($i = 0; $i < $item; $i++)
    {


      $fileName = $_FILES["thumbnail"]["name"][$i];
      $extension = explode('.', $fileName);
      $extension = strtolower(end($extension));
      $uniqueName = 'prod_' . uniqid() . '.' . $extension;
      $type = $_FILES["thumbnail"]["type"][$i];
      $size = $_FILES["thumbnail"]["size"][$i];
      $tmp_name = $_FILES['thumbnail']['tmp_name'][$i];
      $targetlocation = PRODUCT_DIRECTORY . $uniqueName;

      if (!empty($fileName))
      {
        move_uploaded_file($tmp_name, $targetlocation);
        $fields['main_image'] = utf8_encode(trim($uniqueName));
      }

      $this->uploadMultiImg2($i, $data);



      if (!empty($_FILES["thumbnail"]["name"][$i]))
      {
        $this->db->where('id', $data['color_id'][$i]);
        $this->db->update('tab_color_master', $fields);

      }
    }

    redirect('admin/Product/UpdateProduct/' . $id . '?tab=5');

  }

  public function uploadMultiImg2($i, $data)
  {

    $count = '1';

    if (!empty($_FILES['images' . $i]['name']))
    {

      foreach ($_FILES['images' . $i]['name'] as $item => $item_name)
      {

        $fileName = $_FILES['images' . $i]['name'][$item];
        $extension = explode('.', $fileName);
        $extension = strtolower(end($extension));
        $uniqueName = 'prod_' . uniqid() . '.' . $extension;
        $type = $_FILES['images' . $i]["type"][$item];
        $size = $_FILES['images' . $i]["size"][$item];
        $tmp_name = $_FILES['images' . $i]['tmp_name'][$item];
        $targetlocation = PRODUCT_DIRECTORY . $uniqueName;

        if (!empty($fileName))
        {


          if ($count == '1')
          {

            move_uploaded_file($tmp_name, $targetlocation);
            $field1['image1'] = utf8_encode(trim($uniqueName));

            $this->db->where('id', $data['color_id'][$i]);
            $this->db->update('tab_color_master', $field1);

          } else if ($count == '2')
          {

            move_uploaded_file($tmp_name, $targetlocation);
            $field2['image2'] = utf8_encode(trim($uniqueName));

            $this->db->where('id', $data['color_id'][$i]);
            $this->db->update('tab_color_master', $field2);

          } else if ($count == '3')
          {

            move_uploaded_file($tmp_name, $targetlocation);
            $field3['image3'] = utf8_encode(trim($uniqueName));

            $this->db->where('id', $data['color_id'][$i]);
            $this->db->update('tab_color_master', $field3);

          } else if ($count == '4')
          {

            move_uploaded_file($tmp_name, $targetlocation);
            $field4['image4'] = utf8_encode(trim($uniqueName));

            $this->db->where('id', $data['color_id'][$i]);
            $this->db->update('tab_color_master', $field4);

          } else if ($count == '5')
          {
            move_uploaded_file($tmp_name, $targetlocation);
            $field5['image5'] = utf8_encode(trim($uniqueName));

            $this->db->where('id', $data['color_id'][$i]);
            $this->db->update('tab_color_master', $field5);

          }

        }

        $count++;
      }
    }
  }




  public function save_shipping()
  {
    $data = $this->input->post();
    $fields['weight'] = $data['weight'];
    $fields['packet_length'] = $data['packet_length'];
    $fields['packet_weight'] = $data['packet_weight'];
    $fields['packet_height'] = $data['packet_height'];
    $this->db->where('id', $data['id']);
    $this->db->update('tab_general_information', $fields);
    redirect('admin/Product/AddProduct/?tab=6');

  }
  public function save_shipping2($id)
  {
    $data = $this->input->post();
    $fields['weight'] = $data['weight'];
    $fields['packet_length'] = $data['packet_length'];
    $fields['packet_weight'] = $data['packet_weight'];
    $fields['packet_height'] = $data['packet_height'];
    $this->db->where('id', $data['id']);
    $this->db->update('tab_general_information', $fields);
    redirect('admin/Product/UpdateProduct/' . $id . '?tab=6');

  }

  // public function final_submit()
  // {
  //   $adminData = $this->session->userdata('adminData');
  //   $data = $this->input->post();
  //   //echo "<pre>";print_r($data);exit();
  //   $basic_info = $this->db->get_where('tab_general_information', array('type' => '1'))->row_array();

  //   $this->db->select('mai_id');
  //   $parent = $this->db->get_where('category_master', array('id' => $basic_info['category_id']))->row_array();


  //   $sizeArray = $this->db->get_where('tab_color_size_master', array('type' => '1'))->result_array();

  //   $str = preg_replace('/\D/', '', $basic_info['sku_code']);


  //   foreach ($sizeArray as $key => $value)
  //   {

  //     $image_info = $this->db->get_where('tab_color_master', array('color' => $value['color']))->row_array();

  //     $common['sku_code'] = $basic_info['sku_code'];
  //     $common['color_code'] = $str . '_' . $basic_info['shop_id'] . '_' . $value['color'];
  //     $common['shop_id'] = $basic_info['shop_id'];
  //     $common['parent_category_id'] = $basic_info['parent_id'];
  //     $common['category_id'] = $basic_info['category_id'];
  //     $common['sub_category_id'] = $basic_info['sub_category_id'];
  //     $common['product_name'] = $basic_info['product_name'];
  //     $common['weight'] = $basic_info['weight'];
  //     $common['packet_length'] = $basic_info['packet_length'];
  //     $common['packet_weight'] = $basic_info['packet_weight'];
  //     $common['packet_height'] = $basic_info['packet_height'];
  //     $common['product_code'] = $str . '_' . $basic_info['shop_id'];



  //     $common['product_description'] = $basic_info['product_description'];
  //     ;
  //     $common['brand'] = $data['brand'];
  //     //$common['sleev_length']              = $data['sleev_length'];
  //     //$common['neckline']                  = $data['neckline'];
  //     //$common['prints_patterns']           = $data['prints_patterns'];
  //     //$common['blouse_piece']              = $data['blouse_piece'];
  //     $common['occasion'] = $data['occasion'];
  //     //$common['combo']                     = $data['combo'];
  //     $common['fit'] = $data['fit'];
  //     //$common['collor']                    = $data['collor'];
  //     $common['fabric'] = $data['fabric'];
  //     //$common['fabric_care']               = $data['fabric_care'];
  //     $common['pack_of'] = $data['pack_of'];
  //     //$common['type']                      = $data['type'];
  //     //$common['style']                     = $data['style'];
  //     $common['length'] = $data['length'];
  //     //$common['art_work']                  = $data['art_work'];
  //     //$common['stretchable']               = $data['stretchable'];
  //     //$common['back_type']                 = $data['back_type'];
  //     $common['ideal_for'] = $data['ideal_for'];
  //     //$common['highlights']                = $data['highlights'];
  //     $common['product_hsn'] = $data['product_hsn'];
  //     //$common['country']                   = $data['country'];
  //     //$common['style_code']                = $data['style_code'];



  //     //$common['closer']                     = $data['closer'];
  //     //$common['boot_height']                = $data['boot_height'];
  //     //$common['heel_type']                  = $data['heel_type'];
  //     //$common['heel_height']                = $data['heel_height'];
  //     //$common['toe_shap']                   = $data['toe_shap'];
  //     //$common['upper_material']             = $data['upper_material'];
  //     //$common['sole_material']              = $data['sole_material'];
  //     //$common['inner_material']             = $data['inner_material'];
  //     //$common['shoes_type']                 = $data['shoes_type'];



  //     $common['color'] = $value['color'];
  //     $common['price'] = $value['price'];
  //     $common['final_price'] = $value['final_price'];
  //     $common['quantity'] = $value['qty'];
  //     $common['size'] = $value['size'];
  //     $common['gst'] = $value['gst'];

  //     $common['main_image'] = $image_info['main_image'];
  //     $common['image1'] = $image_info['image1'];
  //     $common['image2'] = $image_info['image2'];
  //     $common['image3'] = $image_info['image3'];
  //     $common['image4'] = $image_info['image4'];
  //     $common['image5'] = $image_info['image5'];
  //     $common['status'] = '2';
  //     $common['verify_status'] = '2';
  //     $common['pro_description'] = $data['pro_description'];
  //     ;
  //     if ($adminData['Type'] == '1')
  //     {

  //       $common['added_type'] = '1';
  //       $common['addedBy'] = '1';

  //     } else
  //     {

  //       $common['added_type'] = '2';
  //       $common['addedBy'] = $adminData['Id'];
  //     }


  //     $this->db->insert('sub_product_master', $common);


  //   }
  //   $this->db->where_not_in('id', '5555555555555555555555');
  //   $this->db->delete('tab_color_master');
  //   $this->db->where_not_in('id', '5555555555555555555555');
  //   $this->db->delete('tab_color_size_master');
  //   $this->db->where_not_in('id', '5555555555555555555555');
  //   $this->db->delete('tab_general_information');
  //   $this->db->where_not_in('id', '5555555555555555555555');
  //   $this->db->delete('tab_size_master');

  //   $this->session->set_flashdata('activate', getCustomAlert('S', 'Product  added successfully.'));
  //   redirect('admin/Product');

  // }

  private function generate_unique_id($prefix = 'PRD')
  {
    return $prefix . time() . rand(1000, 9999);
  }

  // public function final_submit()
  // {
  //   $adminData = $this->session->userdata('adminData');
  //   $data = $this->input->post();

  //   // ===== BASIC PRODUCT INFO =====
  //   $basic_info = $this->db->get_where('tab_general_information', ['type' => '1'])->row_array();
  //   if (empty($basic_info))
  //   {
  //     $this->session->set_flashdata('activate', getCustomAlert('E', 'Basic product information not found.'));
  //     redirect('admin/Product');
  //     exit;
  //   }

  //   // ===== COLOR-SIZE DATA =====
  //   $sizeArray = $this->db->get_where('tab_color_size_master', ['type' => '1'])->result_array();
  //   if (empty($sizeArray))
  //   {
  //     $this->session->set_flashdata('activate', getCustomAlert('E', 'Please add at least one color & size.'));
  //     redirect('admin/Product');
  //     exit;
  //   }

  //   // ===== GET VENDOR & PROMOTER DIRECTLY FROM VENDORS TABLE =====
  //   $vendor_id = 0;
  //   $promoter_id = 0;

  //   if (!empty($basic_info['shop_id']))
  //   {
  //     $vendor = $this->db->select('id, promoter_id')
  //       ->from('vendors')
  //       ->where('shop_name', $basic_info['shop_id']) // Assuming shop_name or adjust column
  //       ->or_where('id', $basic_info['shop_id'])
  //       ->get()
  //       ->row_array();

  //     if (!empty($vendor))
  //     {
  //       $vendor_id = $vendor['id'];
  //       $promoter_id = !empty($vendor['promoter_id']) ? $vendor['promoter_id'] : 0;
  //     }
  //   }

  //   // ===== SKU numeric part =====
  //   $str = preg_replace('/\D/', '', $basic_info['sku_code']);

  //   foreach ($sizeArray as $value)
  //   {

  //     // ===== GET IMAGES BY COLOR =====
  //     $image_info = $this->db->get_where('tab_color_master', ['color' => $value['color']])->row_array();

  //     $common = [];

  //     // ===== BASIC PRODUCT INFO =====
  //     $common['sku_code'] = $basic_info['sku_code'];
  //     $common['color_code'] = $str . '_' . $basic_info['shop_id'] . '_' . $value['color'];
  //     $common['shop_id'] = $basic_info['shop_id'];
  //     $common['parent_category_id'] = $basic_info['parent_id'];
  //     $common['category_id'] = $basic_info['category_id'];
  //     $common['sub_category_id'] = $basic_info['sub_category_id'];
  //     $common['product_name'] = $basic_info['product_name'];
  //     $common['weight'] = $basic_info['weight'];
  //     $common['packet_length'] = $basic_info['packet_length'];
  //     $common['packet_weight'] = $basic_info['packet_weight'];
  //     $common['packet_height'] = $basic_info['packet_height'];
  //     $common['product_code'] = $str . '_' . $basic_info['shop_id'];
  //     $common['product_description'] = $basic_info['product_description'];

  //     // ===== EXTRA FIELDS =====
  //     $common['brand'] = @$data['brand'];
  //     $common['occasion'] = @$data['occasion'];
  //     $common['fit'] = @$data['fit'];
  //     $common['fabric'] = @$data['fabric'];
  //     $common['pack_of'] = @$data['pack_of'];
  //     $common['length'] = @$data['length'];
  //     $common['ideal_for'] = @$data['ideal_for'];
  //     $common['product_hsn'] = @$data['product_hsn'];
  //     $common['pro_description'] = @$data['pro_description'];

  //     // ===== PRICE / SIZE / COLOR =====
  //     $common['color'] = $value['color'];
  //     $common['price'] = $value['price'];
  //     $common['final_price'] = $value['final_price'];
  //     $common['quantity'] = $value['qty'];
  //     $common['size'] = $value['size'];
  //     $common['gst'] = $value['gst'];
  //     // ===== EXTRA CATEGORY FIELDS =====

  //     // ----- Fashion & Clothing -----
  //     $common['sleeve_length'] = @$data['sleeve_length'];
  //     $common['neckline'] = @$data['neckline'];
  //     $common['prints_patterns'] = @$data['prints_patterns'];
  //     $common['combo'] = @$data['combo'];
  //     $common['back_type'] = @$data['back_type'];

  //     // ----- Electronics -----
  //     $common['model_number_electronics'] = @$data['model_number_electronics'];
  //     $common['os'] = @$data['os'];
  //     $common['cpu_model'] = @$data['cpu_model'];
  //     $common['cpu_speed'] = @$data['cpu_speed'];
  //     $common['ram'] = @$data['ram'];
  //     $common['storage'] = @$data['storage'];
  //     $common['screen_size'] = @$data['screen_size'];
  //     $common['resolution'] = @$data['resolution'];
  //     $common['battery_capacity'] = @$data['battery_capacity'];
  //     $common['connectivity'] = @$data['connectivity'];
  //     $common['camera'] = @$data['camera'];
  //     $common['special_features_electronics'] = @$data['special_features_electronics'];
  //     $common['audio_jack'] = @$data['audio_jack'];
  //     $common['gps'] = @$data['gps'];
  //     $common['warranty_electronics'] = @$data['warranty_electronics'];

  //     // ----- Beauty & Personal Care -----
  //     $common['product_type_beauty'] = @$data['product_type_beauty'];
  //     $common['gender'] = @$data['gender'];
  //     $common['skin_type'] = @$data['skin_type'];
  //     $common['volume'] = @$data['volume'];
  //     $common['ingredients'] = @$data['ingredients'];
  //     $common['expiry_date'] = @$data['expiry_date'];
  //     $common['fragrance'] = @$data['fragrance'];
  //     // $common['pack_of_beauty'] = @$data['pack_of_beauty'];

  //     // ----- Appliances -----
  //     $common['model_number_appliances'] = @$data['model_number_appliances'];
  //     $common['brand_appliances'] = @$data['brand_appliances'];
  //     $common['power'] = @$data['power'];
  //     $common['voltage'] = @$data['voltage'];
  //     $common['capacity'] = @$data['capacity'];
  //     $common['color_appliances'] = @$data['color_appliances'];
  //     $common['weight_appliances'] = @$data['weight_appliances'];
  //     $common['dimensions'] = @$data['dimensions'];
  //     $common['special_features_appliances'] = @$data['special_features_appliances'];
  //     $common['warranty_appliances'] = @$data['warranty_appliances'];

  //     // ----- Stationery -----
  //     $common['product_type_stationery'] = @$data['product_type_stationery'];
  //     $common['brand_stationery'] = @$data['brand_stationery'];
  //     // $common['material_stationery'] = @$data['material_stationery'];
  //     $common['size_stationery'] = @$data['size_stationery'];
  //     $common['color_stationery'] = @$data['color_stationery'];
  //     $common['pack_of_stationery'] = @$data['pack_of_stationery'];
  //     // $common['usage_stationery'] = @$data['usage_stationery'];
  //     $common['weight_stationery'] = @$data['weight_stationery'];

  //     // ----- Automotive & Accessories -----
  //     $common['part_type'] = @$data['part_type'];
  //     $common['brand_automotive'] = @$data['brand_automotive'];
  //     $common['model_compatibility'] = @$data['model_compatibility'];
  //     $common['material_automotive'] = @$data['material_automotive'];
  //     $common['color_automotive'] = @$data['color_automotive'];
  //     $common['size_automotive'] = @$data['size_automotive'];
  //     $common['weight_automotive'] = @$data['weight_automotive'];
  //     $common['installation_type'] = @$data['installation_type'];
  //     $common['warranty_automotive'] = @$data['warranty_automotive'];


  //     // ===== IMAGES =====
  //     $common['main_image'] = !empty($image_info['main_image']) ? $image_info['main_image'] : NULL;
  //     $common['image1'] = !empty($image_info['image1']) ? $image_info['image1'] : NULL;
  //     $common['image2'] = !empty($image_info['image2']) ? $image_info['image2'] : NULL;
  //     $common['image3'] = !empty($image_info['image3']) ? $image_info['image3'] : NULL;
  //     $common['image4'] = !empty($image_info['image4']) ? $image_info['image4'] : NULL;
  //     $common['image5'] = !empty($image_info['image5']) ? $image_info['image5'] : NULL;

  //     // ===== STATUS =====
  //     $common['status'] = '1';
  //     $common['add_date'] = date('Y-m-d H:i:s');
  //     $common['modify_date'] = date('Y-m-d H:i:s');

  //     // ===== UNIQUE ID =====
  //     $common['unique_id'] = $this->generate_unique_id('PRD');

  //     // ===== LOGIN USER TYPE =====
  //     switch ($adminData['Type'])
  //     {
  //       case '1': // Admin
  //         $common['added_type'] = '1';
  //         $common['addedBy'] = !empty($adminData['Id']) ? $adminData['Id'] : 0;
  //         $common['vendor_id'] = 0;
  //         $common['promoter_id'] = 0;
  //         $common['verify_status'] = '1';
  //         break;

  //       case '2': // Vendor
  //         $common['added_type'] = '2';
  //         $common['addedBy'] = $vendor_id;
  //         $common['vendor_id'] = $vendor_id;
  //         $common['promoter_id'] = 0;
  //         $common['verify_status'] = '0';
  //         break;

  //       case '3': // Promoter
  //         $common['added_type'] = '3';
  //         $common['addedBy'] = $promoter_id;
  //         $common['vendor_id'] = $vendor_id;
  //         $common['promoter_id'] = $promoter_id;
  //         $common['verify_status'] = '0';
  //         break;

  //       default: // fallback
  //         $common['added_type'] = 0;
  //         $common['addedBy'] = 0;
  //         $common['vendor_id'] = 0;
  //         $common['promoter_id'] = 0;
  //         $common['verify_status'] = '0';
  //     }

  //     // ===== INSERT =====
  //     $this->db->insert('sub_product_master', $common);
  //   }

  //   // ===== CLEAR TEMP TABLES =====
  //   $this->db->where_not_in('id', '5555555555555555555555')->delete('tab_color_master');
  //   $this->db->where_not_in('id', '5555555555555555555555')->delete('tab_color_size_master');
  //   $this->db->where_not_in('id', '5555555555555555555555')->delete('tab_general_information');
  //   $this->db->where_not_in('id', '5555555555555555555555')->delete('tab_size_master');

  //   $this->session->set_flashdata('activate', getCustomAlert('S', 'Product added successfully. Waiting for admin approval.'));
  //   redirect('admin/Product');
  // }


//   public function final_submit()
// {
//     $adminData = $this->session->userdata('adminData');
//     $data = $this->input->post();

//       // ===== GET BASIC PRODUCT INFO =====
//     $basic_info = $this->db->get_where('tab_general_information', ['type' => '1'])->row_array();
//     if (empty($basic_info)) {
//         $this->session->set_flashdata('activate', getCustomAlert('E', 'Basic product information not found.'));
//         redirect('admin/Product');
//         exit;
//     }

//       // ===== GET COLOR-SIZE INFO =====
//     $sizeArray = $this->db->get_where('tab_color_size_master', ['type' => '1'])->result_array();
//     if (empty($sizeArray)) {
//         $this->session->set_flashdata('activate', getCustomAlert('E', 'Please add at least one color & size.'));
//         redirect('admin/Product');
//         exit;
//     }

//       // ===== GET VENDOR =====
//     $vendor_id = 0;
//     $promoter_id = 0;
//     if (!empty($basic_info['shop_id'])) {
//         $vendor = $this->db->select('id, promoter_id')->from('vendors')
//             ->where('shop_name', $basic_info['shop_id'])
//             ->or_where('id', $basic_info['shop_id'])
//             ->get()->row_array();
//         if (!empty($vendor)) {
//             $vendor_id = $vendor['id'];
//             $promoter_id = !empty($vendor['promoter_id']) ? $vendor['promoter_id'] : 0;
//         }
//     }

//       // ===== GET ACTIVE SUBSCRIPTION =====
//     $subscription = $this->db->get_where('vendor_subscriptions_master', [
//         'vendor_id' => $vendor_id,
//         'status' => 1,
//         'approval_status' => 1
//     ])->row_array();

//       if (empty($subscription)) {
//         $this->session->set_flashdata('activate', getCustomAlert('E', 'No active subscription found. Please purchase a plan.'));
//         redirect('admin/Product');
//         exit;
//     }

//       // ===== SKU numeric part =====
//     $str = preg_replace('/\D/', '', $basic_info['sku_code']);

//       foreach ($sizeArray as $value) {

//           // ===== GET IMAGES BY COLOR =====
//         $image_info = $this->db->get_where('tab_color_master', ['color' => $value['color']])->row_array();

//           $common = [];
//         $common['sku_code'] = $basic_info['sku_code'];
//         $common['color_code'] = $str . '_' . $basic_info['shop_id'] . '_' . $value['color'];
//         $common['shop_id'] = $basic_info['shop_id'];
//         $common['parent_category_id'] = $basic_info['parent_id'];
//         $common['category_id'] = $basic_info['category_id'];
//         $common['sub_category_id'] = $basic_info['sub_category_id'];
//         $common['product_name'] = $basic_info['product_name'];
//         $common['product_description'] = $basic_info['product_description'];
//         $common['weight'] = $basic_info['weight'];
//         $common['packet_length'] = $basic_info['packet_length'];
//         $common['packet_weight'] = $basic_info['packet_weight'];
//         $common['packet_height'] = $basic_info['packet_height'];
//         $common['product_code'] = $str . '_' . $basic_info['shop_id'];

//           // Extra Fields
//         $extraFields = ['brand','occasion','fit','fabric','pack_of','length','ideal_for','product_hsn'];
//         foreach ($extraFields as $f) $common[$f] = @$data[$f];

//           // Price / Size / Color
//         $common['color'] = $value['color'];
//         $common['price'] = $value['price'];
//         $common['final_price'] = $value['final_price'];
//         $common['quantity'] = $value['qty'];
//         $common['size'] = $value['size'];
//         $common['gst'] = $value['gst'];

//           // Images
//         $common['main_image'] = @$image_info['main_image'];
//         $common['image1'] = @$image_info['image1'];
//         $common['image2'] = @$image_info['image2'];
//         $common['image3'] = @$image_info['image3'];
//         $common['image4'] = @$image_info['image4'];
//         $common['image5'] = @$image_info['image5'];

//           // Status & Dates
//         $common['status'] = 1;
//         $common['add_date'] = date('Y-m-d H:i:s');
//         $common['modify_date'] = date('Y-m-d H:i:s');
//         $common['unique_id'] = $this->generate_unique_id('PRD');
//         $common['subscription_type'] = $subscription['plan_type'];

//           // User Type
//         switch ($adminData['Type']) {
//             case '1': // Admin
//                 $common['added_type'] = 1;
//                 $common['addedBy'] = $adminData['Id'] ?? 0;
//                 $common['vendor_id'] = 0;
//                 $common['promoter_id'] = 0;
//                 $common['verify_status'] = 1;
//                 break;
//             case '2': // Vendor
//                 $common['added_type'] = 2;
//                 $common['addedBy'] = $vendor_id;
//                 $common['vendor_id'] = $vendor_id;
//                 $common['promoter_id'] = 0;
//                 $common['verify_status'] = 0;
//                 break;
//             case '3': // Promoter
//                 $common['added_type'] = 3;
//                 $common['addedBy'] = $promoter_id;
//                 $common['vendor_id'] = $vendor_id;
//                 $common['promoter_id'] = $promoter_id;
//                 $common['verify_status'] = 0;
//                 break;
//         }

//           // ===== INSERT PRODUCT =====
//         $this->db->insert('sub_product_master', $common);
//         $product_id = $this->db->insert_id();

//           // ===== UPDATE Subscription =====
//         if ($subscription['plan_type'] == 1) { // Monthly → increment products_used
//             $this->db->set('products_used', 'products_used+1', FALSE)
//                 ->where('id', $subscription['id'])
//                 ->update('vendor_subscriptions_master');

//               // If products_used reaches product_limit → set status expired
//             $sub = $this->db->get_where('vendor_subscriptions_master',['id'=>$subscription['id']])->row_array();
//             if ($sub['products_used'] >= $sub['product_limit']) {
//                 $this->db->update('vendor_subscriptions_master',['status'=>0],['id'=>$subscription['id']]);
//             }
//         } else { // Per Product → calculate admin commission
//             $commission = $value['final_price'] * 0.10; // 10%
//             $vendor_earning = $value['final_price'] - $commission;

//               $this->db->insert('admin_earnings_master', [
//                 'vendor_id' => $vendor_id,
//                 'product_id' => $product_id,
//                 'commission_amount' => $commission,
//                 'created_at' => date('Y-m-d H:i:s')
//             ]);

//               $common['vendor_earning'] = $vendor_earning;
//         }

//           // ===== INSERT EXTRA FIELDS =====
//         if (!empty($data['pro_description'])) {
//             foreach ($data['pro_description'] as $desc) {
//                 if (!empty(trim($desc))) {
//                     $this->db->insert('product_extra_fields', [
//                         'product_id' => $product_id,
//                         'field_name' => 'pro_description',
//                         'field_value' => trim($desc)
//                     ]);
//                 }
//             }
//         }

//           if (!empty($data['field_name']) && !empty($data['field_value'])) {
//             foreach ($data['field_name'] as $index => $field) {
//                 $f_name = trim($field);
//                 $f_value = trim($data['field_value'][$index]);
//                 if ($f_name && $f_value) {
//                     $this->db->insert('product_extra_fields', [
//                         'product_id' => $product_id,
//                         'field_name' => $f_name,
//                         'field_value' => $f_value
//                     ]);
//                 }
//             }
//         }
//     }

//       // Clear temp tables
//     $this->db->truncate('tab_color_master');
//     $this->db->truncate('tab_color_size_master');
//     $this->db->truncate('tab_general_information');
//     $this->db->truncate('tab_size_master');

//       $this->session->set_flashdata('activate', getCustomAlert('S','Product added successfully. Waiting for admin approval.'));
//     redirect('admin/Product');
// }
public function final_submit()
{
    $adminData = $this->session->userdata('adminData');
    $data = $this->input->post();

    // ===== GET BASIC PRODUCT INFO =====
    $basic_info = $this->db->get_where('tab_general_information', ['type' => '1'])->row_array();
    if (empty($basic_info)) {
        $this->session->set_flashdata('activate', getCustomAlert('E', 'Basic product information not found.'));
        redirect('admin/Product');
        exit;
    }

    // ===== GET COLOR-SIZE INFO =====
    $sizeArray = $this->db->get_where('tab_color_size_master', ['type' => '1'])->result_array();
    if (empty($sizeArray)) {
        $this->session->set_flashdata('activate', getCustomAlert('E', 'Please add at least one color & size.'));
        redirect('admin/Product');
        exit;
    }

    // ===== GET VENDOR / PROMOTER =====
    $vendor_id = 0;
    $promoter_id = 0;
    $shop_id = $basic_info['shop_id'] ?? null;
    $promoter_shop_name = null;

    if ($adminData['Type'] == 3) { // Promoter
        $promoter_id = $adminData['Id'];
        $promoter = $this->db->select('shop_name')->from('promoters')->where('id', $promoter_id)->get()->row_array();
        $promoter_shop_name = $promoter['shop_name'] ?? null;
        $shop_id = null; // promoter product
    } else { // Vendor / Admin
        if (!empty($shop_id)) {
            $shop = $this->db->get_where('shop_master', ['id' => $shop_id])->row_array();
            $vendor_id = $shop['vendor_id'] ?? 0;

            if ($vendor_id) {
                $vendor = $this->db->select('promoter_id')->from('vendors')->where('id', $vendor_id)->get()->row_array();
                $promoter_id = $vendor['promoter_id'] ?? 0;

                if ($promoter_id) {
                    $promoter = $this->db->select('shop_name')->from('promoters')->where('id', $promoter_id)->get()->row_array();
                    $promoter_shop_name = $promoter['shop_name'] ?? null;
                }
            }
        }
    }

    // ===== GET ACTIVE SUBSCRIPTION (Vendor Only) =====
    $subscription = null;
    if ($adminData['Type'] == 2) { // Vendor
        $subscription = $this->db
            ->where('vendor_id', $vendor_id)
            ->where('status', 1)
            ->where('approval_status', 1)
            ->order_by('id', 'DESC')
            ->get('vendor_subscriptions_master')
            ->row_array();

        if (empty($subscription)) {
            $this->session->set_flashdata('activate', getCustomAlert('E', 'No active subscription found. Please purchase a plan.'));
            redirect('admin/Product');
            exit;
        }
    }

    // ===== SKU numeric part =====
    $str = preg_replace('/\D/', '', $basic_info['sku_code']);

    // ===== START TRANSACTION =====
    $this->db->trans_start();

    foreach ($sizeArray as $value) {

        // ===== GET IMAGES BY COLOR =====
        $image_info = $this->db->get_where('tab_color_master', ['color' => $value['color']])->row_array();

        // ===== COMMON PRODUCT DATA =====
        $common = [];
        $common['sku_code'] = $basic_info['sku_code'];
        $common['color_code'] = $str . '_' . ($shop_id ?? 0) . '_' . $value['color'];
        $common['shop_id'] = $shop_id ?? 0;
        $common['vendor_id'] = $vendor_id ?? 0;
        $common['promoter_id'] = $promoter_id ?? 0;
        $common['promoter_shop_name'] = $promoter_shop_name;
        $common['parent_category_id'] = $basic_info['parent_id'];
        $common['category_id'] = $basic_info['category_id'];
        $common['sub_category_id'] = $basic_info['sub_category_id'];
        $common['product_name'] = $basic_info['product_name'];
        $common['product_description'] = $basic_info['product_description'];
        $common['weight'] = $basic_info['weight'];
        $common['packet_length'] = $basic_info['packet_length'];
        $common['packet_weight'] = $basic_info['packet_weight'];
        $common['packet_height'] = $basic_info['packet_height'];
        $common['product_code'] = $str . '_' . ($shop_id ?? 0);

        // Extra Fields
        $extraFields = ['brand','occasion','fit','fabric','pack_of','length','ideal_for','product_hsn'];
        foreach ($extraFields as $f) $common[$f] = $data[$f] ?? null;

        // Price / Size / Color
        $common['color'] = $value['color'];
        $common['price'] = $value['price'];
        $common['final_price'] = $value['final_price'];
        $common['quantity'] = $value['qty'];
        $common['size'] = $value['size'];
        $common['gst'] = $value['gst'];

        // Images
        $common['main_image'] = $image_info['main_image'] ?? null;
        $common['image1'] = $image_info['image1'] ?? null;
        $common['image2'] = $image_info['image2'] ?? null;
        $common['image3'] = $image_info['image3'] ?? null;
        $common['image4'] = $image_info['image4'] ?? null;
        $common['image5'] = $image_info['image5'] ?? null;

        // Status & Dates
        $common['status'] = 1;
        $common['add_date'] = date('Y-m-d H:i:s');
        $common['modify_date'] = date('Y-m-d H:i:s');
        $common['unique_id'] = $this->generate_unique_id('PRD');
        $common['subscription_type'] = $subscription['plan_type'] ?? 0;

        // ===== USER TYPE =====
        switch ($adminData['Type']) {
            case 1: // Admin
                $common['added_type'] = 1;
                $common['addedBy'] = $adminData['Id'];
                $common['verify_status'] = 1;
                break;
            case 2: // Vendor
                $common['added_type'] = 2;
                $common['addedBy'] = $vendor_id;
                $common['verify_status'] = 0;
                break;
            case 3: // Promoter
                $common['added_type'] = 3;
                $common['addedBy'] = $promoter_id;
                $common['verify_status'] = 0;
                break;
        }

        // ===== INSERT PRODUCT =====
        $this->db->insert('sub_product_master', $common);
        $product_id = $this->db->insert_id();

        // ===== UPDATE SUBSCRIPTION =====
        if (!empty($subscription)) {
            if ($subscription['plan_type'] == 1) { // Monthly
                $this->db->set('products_used', 'products_used+1', FALSE)
                    ->where('id', $subscription['id'])
                    ->update('vendor_subscriptions_master');

                // If products_used >= limit → expire
                $sub = $this->db->get_where('vendor_subscriptions_master', ['id' => $subscription['id']])->row_array();
                if ($sub['products_used'] >= $sub['product_limit']) {
                    $this->db->update('vendor_subscriptions_master', ['status' => 0], ['id' => $subscription['id']]);
                }
            } else { // Per Product
                $commission_percent = $subscription['commission_percent'] ?? 10;
                $commission = $value['final_price'] * ($commission_percent/100);
                $vendor_earning = $value['final_price'] - $commission;

                $this->db->insert('admin_earnings_master', [
                    'vendor_id' => $vendor_id,
                    'product_id' => $product_id,
                    'commission_amount' => $commission,
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                $this->db->set('vendor_earning', $vendor_earning)
                    ->where('id', $product_id)
                    ->update('sub_product_master');
            }
        }

        // ===== EXTRA FIELDS =====
        // 1️⃣ Product Description
        if (!empty($data['pro_description']) && is_array($data['pro_description'])) {
            foreach ($data['pro_description'] as $desc) {
                $desc = trim($desc);
                if ($desc !== '') {
                    $this->db->insert('product_extra_fields', [
                        'product_id'  => $product_id,
                        'field_name'  => 'pro_description',
                        'field_value' => $desc,
                        'created_at'  => date('Y-m-d H:i:s')
                    ]);
                }
            }
        }

        // 2️⃣ Custom Fields
        if (!empty($data['field_name']) && !empty($data['field_value'])) {
            foreach ($data['field_name'] as $key => $field) {
                $field = trim($field);
                $value = trim($data['field_value'][$key] ?? '');
                if ($field !== '' && $value !== '') {
                    $this->db->insert('product_extra_fields', [
                        'product_id'  => $product_id,
                        'field_name'  => $field,
                        'field_value' => $value,
                        'created_at'  => date('Y-m-d H:i:s')
                    ]);
                }
            }
        }
    }

    // ===== COMMIT =====
    $this->db->trans_complete();

    // ===== CLEAR TEMP TABLES =====
    $this->db->truncate('tab_color_master');
    $this->db->truncate('tab_color_size_master');
    $this->db->truncate('tab_general_information');
    $this->db->truncate('tab_size_master');

    $this->session->set_flashdata('activate', getCustomAlert('S','Product added successfully. Waiting for admin approval.'));
    redirect('admin/Product');
}


  // public function final_submit()
  // {
  //   $adminData = $this->session->userdata('adminData');
  //   $data = $this->input->post();

  //   // ===== GET BASIC PRODUCT INFO =====
  //   $basic_info = $this->db->get_where('tab_general_information', ['type' => '1'])->row_array();
  //   if (empty($basic_info))
  //   {
  //     $this->session->set_flashdata('activate', getCustomAlert('E', 'Basic product information not found.'));
  //     redirect('admin/Product');
  //     exit;
  //   }

  //   // ===== GET COLOR-SIZE INFO =====
  //   $sizeArray = $this->db->get_where('tab_color_size_master', ['type' => '1'])->result_array();
  //   if (empty($sizeArray))
  //   {
  //     $this->session->set_flashdata('activate', getCustomAlert('E', 'Please add at least one color & size.'));
  //     redirect('admin/Product');
  //     exit;
  //   }

  //   // ===== SET SHOP / VENDOR / PROMOTER =====
  //   $vendor_id = 0;
  //   $promoter_id = 0;
  //   $shop_id = $basic_info['shop_id'] ?? null;
  //   $promoter_shop_name = null;

  //   if ($adminData['Type'] == 3)
  //   { // Promoter
  //     $promoter_id = $adminData['Id'];
  //     $promoter = $this->db
  //       ->select('shop_name')
  //       ->from('promoters')
  //       ->where('id', $promoter_id)
  //       ->where('status', 1)
  //       ->get()
  //       ->row_array();

  //     $promoter_shop_name = $promoter['shop_name'] ?? null;
  //     $shop_id = null; // promoter products may not have a shop_master
  //   } else
  //   { // Vendor or Admin
  //     if (!empty($shop_id))
  //     {
  //       $shop = $this->db->get_where('shop_master', ['id' => $shop_id])->row_array();
  //       $vendor_id = $shop['vendor_id'] ?? 0;

  //       if ($vendor_id)
  //       {
  //         $vendor = $this->db->select('promoter_id')->from('vendors')->where('id', $vendor_id)->get()->row_array();
  //         $promoter_id = $vendor['promoter_id'] ?? 0;

  //         if ($promoter_id)
  //         {
  //           $promoter = $this->db->select('shop_name')->from('promoters')->where('id', $promoter_id)->get()->row_array();
  //           $promoter_shop_name = $promoter['shop_name'] ?? null;
  //         }
  //       }
  //     }
  //   }

  //   // ===== GET ACTIVE SUBSCRIPTION (VENDOR ONLY) =====
  //   $subscription = null;
  //   if ($adminData['Type'] == 2)
  //   { // Vendor
  //     $subscription = $this->db
  //       ->where('vendor_id', $vendor_id)
  //       ->where('status', 1)
  //       ->where('approval_status', 1)
  //       ->order_by('id', 'DESC')
  //       ->get('vendor_subscriptions_master')
  //       ->row_array();

  //     if (empty($subscription))
  //     {
  //       $this->session->set_flashdata('activate', getCustomAlert('E', 'No active subscription found. Please purchase a plan.'));
  //       redirect('admin/Product');
  //       exit;
  //     }
  //   }

  //   // ===== SKU numeric part =====
  //   $str = preg_replace('/\D/', '', $basic_info['sku_code']);

  //   foreach ($sizeArray as $value)
  //   {

  //     // ===== GET IMAGES BY COLOR =====
  //     $image_info = $this->db->get_where('tab_color_master', ['color' => $value['color']])->row_array();

  //     // ===== COMMON PRODUCT DATA =====
  //     $common = [];
  //     $common['sku_code'] = $basic_info['sku_code'];
  //     $common['color_code'] = $str . '_' . ($shop_id ?? 0) . '_' . $value['color'];
  //     $common['shop_id'] = $shop_id ?? 0;
  //     $common['vendor_id'] = $vendor_id ?? 0;
  //     $common['promoter_id'] = $promoter_id ?? 0;
  //     $common['promoter_shop_name'] = $promoter_shop_name;
  //     $common['parent_category_id'] = $basic_info['parent_id'];
  //     $common['category_id'] = $basic_info['category_id'];
  //     $common['sub_category_id'] = $basic_info['sub_category_id'];
  //     $common['product_name'] = $basic_info['product_name'];
  //     $common['product_description'] = $basic_info['product_description'];
  //     $common['weight'] = $basic_info['weight'];
  //     $common['packet_length'] = $basic_info['packet_length'];
  //     $common['packet_weight'] = $basic_info['packet_weight'];
  //     $common['packet_height'] = $basic_info['packet_height'];
  //     $common['product_code'] = $str . '_' . ($shop_id ?? 0);

  //     // Extra Fields
  //     $extraFields = ['brand', 'occasion', 'fit', 'fabric', 'pack_of', 'length', 'ideal_for', 'product_hsn'];
  //     foreach ($extraFields as $f)
  //       $common[$f] = @$data[$f];

  //     // Price / Size / Color
  //     $common['color'] = $value['color'];
  //     $common['price'] = $value['price'];
  //     $common['final_price'] = $value['final_price'];
  //     $common['quantity'] = $value['qty'];
  //     $common['size'] = $value['size'];
  //     $common['gst'] = $value['gst'];

  //     // Images
  //     $common['main_image'] = @$image_info['main_image'];
  //     $common['image1'] = @$image_info['image1'];
  //     $common['image2'] = @$image_info['image2'];
  //     $common['image3'] = @$image_info['image3'];
  //     $common['image4'] = @$image_info['image4'];
  //     $common['image5'] = @$image_info['image5'];

  //     // Status & Dates
  //     $common['status'] = 1;
  //     $common['add_date'] = date('Y-m-d H:i:s');
  //     $common['modify_date'] = date('Y-m-d H:i:s');
  //     $common['unique_id'] = $this->generate_unique_id('PRD');
  //     $common['subscription_type'] = $subscription['plan_type'] ?? 0; // 0 if promoter

  //     // ===== USER TYPE =====
  //     switch ($adminData['Type'])
  //     {
  //       case '1': // Admin
  //         $common['added_type'] = 1;
  //         $common['addedBy'] = $adminData['Id'] ?? 0;
  //         $common['verify_status'] = 1;
  //         break;
  //       case '2': // Vendor
  //         $common['added_type'] = 2;
  //         $common['addedBy'] = $vendor_id;
  //         $common['verify_status'] = 0;
  //         break;
  //       case '3': // Promoter
  //         $common['added_type'] = 3;
  //         $common['addedBy'] = $promoter_id;
  //         $common['verify_status'] = 0;
  //         break;
  //     }

  //     // ===== INSERT PRODUCT =====
  //     $this->db->insert('sub_product_master', $common);
  //     $product_id = $this->db->insert_id();

  //     // ===== UPDATE SUBSCRIPTION =====
  //     if (!empty($subscription))
  //     {
  //       if ($subscription['plan_type'] == 1)
  //       { // Monthly
  //         $this->db->set('products_used', 'products_used+1', FALSE)
  //           ->where('id', $subscription['id'])
  //           ->update('vendor_subscriptions_master');

  //         $sub = $this->db->get_where('vendor_subscriptions_master', ['id' => $subscription['id']])->row_array();
  //         if ($sub['products_used'] >= $sub['product_limit'])
  //         {
  //           $this->db->update('vendor_subscriptions_master', ['status' => 0], ['id' => $subscription['id']]);
  //         }
  //       } else
  //       { // Per Product
  //         $commission_percent = $subscription['commission_percent'] ?? 10;
  //         $commission = $value['final_price'] * ($commission_percent / 100);
  //         $vendor_earning = $value['final_price'] - $commission;

  //         $this->db->insert('admin_earnings_master', [
  //           'vendor_id' => $vendor_id,
  //           'product_id' => $product_id,
  //           'commission_amount' => $commission,
  //           'created_at' => date('Y-m-d H:i:s')
  //         ]);

  //         $this->db->set('vendor_earning', $vendor_earning)
  //           ->where('id', $product_id)
  //           ->update('sub_product_master');
  //       }
  //     }

  //     // ===== INSERT EXTRA FIELDS =====
  //     if (!empty($data['pro_description']))
  //     {
  //       foreach ($data['pro_description'] as $desc)
  //       {
  //         if (!empty(trim($desc)))
  //         {
  //           $this->db->insert('product_extra_fields', [
  //             'product_id' => $product_id,
  //             'field_name' => 'pro_description',
  //             'field_value' => trim($desc)
  //           ]);
  //         }
  //       }
  //     }

  //     if (!empty($data['field_name']) && !empty($data['field_value']))
  //     {
  //       foreach ($data['field_name'] as $index => $field)
  //       {
  //         $f_name = trim($field);
  //         $f_value = trim($data['field_value'][$index]);
  //         if ($f_name && $f_value)
  //         {
  //           $this->db->insert('product_extra_fields', [
  //             'product_id' => $product_id,
  //             'field_name' => $f_name,
  //             'field_value' => $f_value
  //           ]);
  //         }
  //       }
  //     }
  //   }

  //   // ===== CLEAR TEMP TABLES =====
  //   $this->db->truncate('tab_color_master');
  //   $this->db->truncate('tab_color_size_master');
  //   $this->db->truncate('tab_general_information');
  //   $this->db->truncate('tab_size_master');

  //   $this->session->set_flashdata('activate', getCustomAlert('S', 'Product added successfully. Waiting for admin approval.'));
  //   redirect('admin/Product');
  // }






  // public function final_submit2($id)
  // {
  //   $adminData = $this->session->userdata('adminData'); // Login user data
  //   $data = $this->input->post();

  //   // ================= GET BASIC PRODUCT INFO =================
  //   $basic_info = $this->db->get_where('tab_general_information', ['product_id' => $id])->row_array();
  //   if (empty($basic_info))
  //   {
  //     $this->session->set_flashdata('activate', getCustomAlert('E', 'Invalid Product!'));
  //     redirect('admin/Product');
  //     return;
  //   }

  //   // ================= GET PRODUCT MAIN RECORD =================
  //   $productInfo = $this->db->get_where('sub_product_master', ['id' => $id])->row_array();
  //   if (empty($productInfo))
  //   {
  //     $this->session->set_flashdata('activate', getCustomAlert('E', 'Product not found!'));
  //     redirect('admin/Product');
  //     return;
  //   }

  //   // ================= GET ACTIVE SUBSCRIPTION =================
  //   $subscription = $this->db->get_where('vendor_subscriptions_master', [
  //     'vendor_id' => $productInfo['vendor_id'],
  //     'status' => 1,
  //     'approval_status' => 1
  //   ])->row_array();

  //   if (empty($subscription))
  //   {
  //     $this->session->set_flashdata('activate', getCustomAlert('E', 'Vendor has no active subscription.'));
  //     redirect('admin/Product');
  //     return;
  //   }

  //   // ================= ROLE BASED SECURITY =================
  //   $vendor_id = $productInfo['vendor_id'];
  //   $promoter_id = $productInfo['promoter_id'];
  //   $added_type = $adminData['Type'];
  //   $addedBy = $adminData['Id'];

  //   // ================= SKU NUMERIC PART =================
  //   $str = preg_replace('/\D/', '', $basic_info['sku_code']);

  //   // ================= GET SIZE/COLOR VARIANTS =================
  //   $sizeArray = $this->db->get_where('tab_color_size_master', ['product_id' => $id])->result_array();
  //   if (empty($sizeArray))
  //   {
  //     $this->session->set_flashdata('activate', getCustomAlert('E', 'Please add at least one color & size.'));
  //     redirect('admin/Product');
  //     return;
  //   }

  //   // ================= START TRANSACTION =================
  //   $this->db->trans_start();
  //   $unique_id = $this->generate_unique_id('PRD');

  //   foreach ($sizeArray as $value)
  //   {
  //     $image_info = $this->db->get_where('tab_color_master', [
  //       'color' => $value['color'],
  //       'product_id' => $id
  //     ])->row_array();

  //     $common = [
  //       'sku_code' => $basic_info['sku_code'],
  //       'color_code' => $str . '_' . $basic_info['shop_id'] . '_' . $value['color'],
  //       'shop_id' => $basic_info['shop_id'],
  //       'vendor_id' => $vendor_id,
  //       'promoter_id' => $promoter_id,
  //       'added_type' => $added_type,
  //       'addedBy' => $addedBy,
  //       'parent_category_id' => $basic_info['parent_id'],
  //       'category_id' => $basic_info['category_id'],
  //       'sub_category_id' => $basic_info['sub_category_id'],
  //       'product_name' => $basic_info['product_name'],
  //       'weight' => $basic_info['weight'],
  //       'packet_length' => $basic_info['packet_length'],
  //       'packet_weight' => $basic_info['packet_weight'],
  //       'packet_height' => $basic_info['packet_height'],
  //       'product_code' => $str . '_' . $basic_info['shop_id'],
  //       'product_description' => $basic_info['product_description'],
  //       'brand' => $data['brand'] ?? null,
  //       'occasion' => $data['occasion'] ?? null,
  //       'fit' => $data['fit'] ?? null,
  //       'fabric' => $data['fabric'] ?? null,
  //       'pack_of' => $data['pack_of'] ?? null,
  //       'length' => $data['length'] ?? null,
  //       'ideal_for' => $data['ideal_for'] ?? null,
  //       'product_hsn' => $data['product_hsn'] ?? null,
  //       'pro_description' => $data['pro_description'] ?? null,
  //       'color' => $value['color'],
  //       'price' => $value['price'],
  //       'final_price' => $value['final_price'],
  //       'quantity' => $value['qty'],
  //       'size' => $value['size'],
  //       'gst' => $value['gst'],
  //       'main_image' => $image_info['main_image'] ?? null,
  //       'image1' => $image_info['image1'] ?? null,
  //       'image2' => $image_info['image2'] ?? null,
  //       'image3' => $image_info['image3'] ?? null,
  //       'image4' => $image_info['image4'] ?? null,
  //       'image5' => $image_info['image5'] ?? null,
  //       'unique_id' => $unique_id,
  //       'status' => 3, // Updated
  //       'verify_status' => 2, // Re-approval required
  //       'modify_date' => date('Y-m-d H:i:s')
  //     ];

  //     // ================= UPDATE PRODUCT =================
  //     $this->db->where('id', $value['pro_id'])->update('sub_product_master', $common);
  //     $product_id = $value['pro_id'];

  //     // ================= HANDLE SUBSCRIPTION =================
  //     if ($subscription['plan_type'] == 1)
  //     {
  //       // Monthly → increment products_used
  //       $this->db->set('products_used', 'products_used+1', FALSE)
  //         ->where('id', $subscription['id'])
  //         ->update('vendor_subscriptions_master');

  //       // Check if product limit reached
  //       $sub = $this->db->get_where('vendor_subscriptions_master', ['id' => $subscription['id']])->row_array();
  //       if ($sub['products_used'] >= $sub['product_limit'])
  //       {
  //         $this->db->update('vendor_subscriptions_master', ['status' => 0], ['id' => $subscription['id']]);
  //       }
  //     } else
  //     {
  //       // Per Product → calculate admin commission 10%
  //       $commission = $value['final_price'] * 0.10;
  //       $vendor_earning = $value['final_price'] - $commission;

  //       $this->db->insert('admin_earnings_master', [
  //         'vendor_id' => $vendor_id,
  //         'product_id' => $product_id,
  //         'commission_amount' => $commission,
  //         'created_at' => date('Y-m-d H:i:s')
  //       ]);
  //     }
  //   }

  //   // ================= HANDLE PRODUCT EXTRA FIELDS =================
  //   if (!empty($data['field_name']) && !empty($data['field_value']))
  //   {
  //     foreach ($data['field_name'] as $k => $field_name)
  //     {
  //       $field_value = $data['field_value'][$k] ?? null;
  //       if (empty($field_name))
  //         continue;

  //       $existing = $this->db->get_where('product_extra_fields', [
  //         'product_id' => $id,
  //         'field_name' => $field_name
  //       ])->row_array();

  //       if ($existing)
  //       {
  //         $this->db->where('id', $existing['id'])->update('product_extra_fields', [
  //           'field_value' => $field_value
  //         ]);
  //       } else
  //       {
  //         $this->db->insert('product_extra_fields', [
  //           'product_id' => $id,
  //           'field_name' => $field_name,
  //           'field_value' => $field_value
  //         ]);
  //       }
  //     }
  //   }

  //   // ================= COMMIT TRANSACTION =================
  //   $this->db->trans_complete();

  //   // ================= CLEAR TEMP TABLES =================
  //   $this->db->where_not_in('id', '5555555555555555555555')->delete('tab_color_master');
  //   $this->db->where_not_in('id', '5555555555555555555555')->delete('tab_color_size_master');
  //   $this->db->where_not_in('id', '5555555555555555555555')->delete('tab_general_information');
  //   $this->db->where_not_in('id', '5555555555555555555555')->delete('tab_size_master');

  //   $this->session->set_flashdata('activate', getCustomAlert('S', 'Product updated successfully! Subscription & commission handled.'));
  //   redirect('admin/Product');
  // }


  // public function AddProduct()
  // {
  //   $tab = $this->input->get('tab');
  //   $adminData = $this->session->userdata('adminData');

  //   /* ===============================
  //      CLEAR TEMP TABLES (FIRST LOAD)
  //      =============================== */
  //   if (empty($tab))
  //   {
  //     $this->db->where_not_in('id', '5555555555555555555555')->delete('tab_color_master');
  //     $this->db->where_not_in('id', '5555555555555555555555')->delete('tab_color_size_master');
  //     $this->db->where_not_in('id', '5555555555555555555555')->delete('tab_general_information');
  //     $this->db->where_not_in('id', '5555555555555555555555')->delete('tab_size_master');
  //   }

  //   $post = $this->input->post();

  //   /* ===============================
  //      FORM LOAD
  //      =============================== */
  //   if (empty($post))
  //   {

  //     $data['index'] = 'AddProduct';
  //     $data['index2'] = '';
  //     $data['title'] = 'Manage Product';

  //     $data['getParCatgy'] = $this->Product_model->getParCatgyList();
  //     $data['getCatgy'] = $this->Product_model->getCatgyList();
  //     $data['getBasicInfo'] = $this->Product_model->getBasicInfo();
  //     $data['getSizeColor'] = $this->Product_model->getSizeColor();

  //     /* ===============================
  //        SHOP DROPDOWN LOGIC
  //        =============================== */

  //     // ADMIN
  //     if ($adminData['Type'] == '1')
  //     {
  //       // ADMIN → All shops
  //       $data['shopList'] = $this->db
  //         ->select('id, name')
  //         ->from('shop_master')
  //         ->where('status', '1')
  //         ->get()
  //         ->result_array();
  //     }

  //     /* ===================== VENDOR ===================== */ elseif ($adminData['Type'] == '2')
  //     {
  //       // Vendor → Only own shop
  //       $data['shopList'] = $this->db
  //         ->select('id, shop_name')
  //         ->from('vendors')
  //         ->where('status', '1')
  //         ->where('id', $adminData['Id'])
  //         ->get()
  //         ->result_array();
  //     }

  //     /* ===================== PROMOTER ===================== */ elseif ($adminData['Type'] == '3')
  //     {
  //       // Promoter → All vendors under him
  //       $data['shopList'] = $this->db
  //         ->select('id, shop_name')
  //         ->from('vendors')
  //         ->where('promoter_id', $adminData['Id'])
  //         ->where('status', '1')
  //         ->get()
  //         ->result_array();
  //     } else
  //     {
  //       $data['shopList'] = [];
  //     }


  //     $this->load->view('include/header', $data);
  //     $this->load->view('Product/AddProduct');
  //     $this->load->view('include/footer');
  //   }

  //   /* ===============================
  //      FORM SUBMIT
  //      =============================== */ else
  //   {

  //     /* ===============================
  //        IMAGE UPLOAD
  //        =============================== */
  //     $images = ['thumbnail', 'image1', 'image2', 'image3', 'image4'];
  //     foreach ($images as $img)
  //     {
  //       if (!empty($_FILES[$img]['name']))
  //       {
  //         $ext = pathinfo($_FILES[$img]['name'], PATHINFO_EXTENSION);
  //         $newName = 'Product_' . uniqid() . '.' . $ext;
  //         move_uploaded_file($_FILES[$img]['tmp_name'], PRODUCT_DIRECTORY . $newName);
  //         $post[$img] = $newName;
  //       }
  //     }

  //     /* ===============================
  //        GET VENDOR & PROMOTER FROM SHOP
  //        =============================== */
  //     $shop = $this->db
  //       ->select('vendor_id')
  //       ->from('shop_master')
  //       ->where('id', $post['shop_id'])
  //       ->get()
  //       ->row_array();

  //     $vendor_id = @$shop['vendor_id'];
  //     $promoter_id = null;

  //     if (!empty($vendor_id))
  //     {
  //       $vendor = $this->db
  //         ->select('promoter_id')
  //         ->from('vendors')
  //         ->where('id', $vendor_id)
  //         ->get()
  //         ->row_array();

  //       $promoter_id = @$vendor['promoter_id'];
  //     }

  //     /* ===============================
  //        PREPARE DATA
  //        =============================== */
  //     $fields = [
  //       'shop_id' => $post['shop_id'],
  //       'vendor_id' => $vendor_id,
  //       'promoter_id' => $promoter_id,

  //       'product_name' => $post['ProductName'],
  //       'product_description' => $post['product_description'],

  //       'main_image' => @$post['thumbnail'],
  //       'image1' => @$post['image1'],
  //       'image2' => @$post['image2'],
  //       'image3' => @$post['image3'],
  //       'image4' => @$post['image4'],

  //       'unique_id' => uniqid('PROD_'),
  //       'status' => 1,
  //       'add_date' => date('Y-m-d H:i:s'),
  //       'modify_date' => date('Y-m-d H:i:s')
  //     ];

  //     /* ===============================
  //        ROLE BASED SETTINGS
  //        =============================== */
  //     if ($adminData['Type'] == '1')
  //     {
  //       $fields['verify_status'] = 1; // Approved
  //       $fields['added_type'] = 1; // Admin
  //       $fields['addedBy'] = $adminData['Id'];
  //     } elseif ($adminData['Type'] == '2')
  //     {
  //       $fields['verify_status'] = 0; // Pending
  //       $fields['added_type'] = 2; // Vendor
  //       $fields['addedBy'] = $adminData['Id'];
  //     } elseif ($adminData['Type'] == '3')
  //     {
  //       $fields['verify_status'] = 0; // Pending
  //       $fields['added_type'] = 3; // Promoter
  //       $fields['addedBy'] = $adminData['Id'];
  //     }

  //     /* ===============================
  //        INSERT
  //        =============================== */
  //     $insert = $this->db->insert('sub_product_master', $fields);

  //     if ($insert)
  //     {
  //       $this->session->set_flashdata('activate', getCustomAlert('S', 'Product added successfully.'));
  //     } else
  //     {
  //       $this->session->set_flashdata('activate', getCustomAlert('E', 'Something went wrong.'));
  //     }

  //     redirect('admin/Product/');
  //   }
  // }


  // public function final_submit2($id)
  // {
  //   $adminData = $this->session->userdata('adminData');
  //   $data = $this->input->post();

  //   // 1️⃣ Product check
  //   $productInfo = $this->db
  //     ->get_where('sub_product_master', ['id' => $id])
  //     ->row_array();

  //   if (empty($productInfo))
  //   {
  //     $this->session->set_flashdata('activate', getCustomAlert('E', 'Product not found'));
  //     redirect('admin/Product');
  //     return;
  //   }

  //   // ===============================
  //   // 2️⃣ SHOP / VENDOR / PROMOTER SETUP
  //   // ===============================

  //   $shop_id = 0;
  //   $vendor_id = null;
  //   $promoter_id = null;
  //   $promoter_shop_name = null;

  //   // 🔴 CASE 1: PROMOTER LOGIN
  //   if ($adminData['Type'] == 3)
  //   {

  //     // promoter apna product update kar raha hai
  //     $promoter_id = $adminData['Id'];

  //     $promoter = $this->db
  //       ->select('shop_name')
  //       ->from('promoters')
  //       ->where('id', $promoter_id)
  //       ->get()
  //       ->row_array();

  //     $promoter_shop_name = $promoter['shop_name'] ?? null;

  //     $shop_id = 0;
  //     $vendor_id = null;
  //   }

  //   // 🔵 CASE 2: ADMIN / VENDOR LOGIN
  //   else
  //   {

  //     $shop_input = $data['shop_id'] ?? null;

  //     if (!empty($shop_input))
  //     {

  //       // 🔴 PROMOTER PRODUCT (Admin ne promoter select kiya)
  //       if (strpos($shop_input, 'p_') === 0)
  //       {

  //         $promoter_id = (int) str_replace('p_', '', $shop_input);

  //         $promoter = $this->db
  //           ->select('shop_name')
  //           ->from('promoters')
  //           ->where('id', $promoter_id)
  //           ->get()
  //           ->row_array();

  //         $promoter_shop_name = $promoter['shop_name'] ?? null;

  //         $shop_id = 0;
  //         $vendor_id = null;
  //       }
  //       // 🔵 VENDOR PRODUCT
  //       else
  //       {

  //         $shop_id = (int) $shop_input;

  //         $shop = $this->db
  //           ->select('vendor_id')
  //           ->from('shop_master')
  //           ->where('id', $shop_id)
  //           ->get()
  //           ->row_array();

  //         $vendor_id = $shop['vendor_id'] ?? null;

  //         if ($vendor_id)
  //         {
  //           $vendor = $this->db
  //             ->select('promoter_id')
  //             ->from('vendors')
  //             ->where('id', $vendor_id)
  //             ->get()
  //             ->row_array();

  //           $promoter_id = $vendor['promoter_id'] ?? null;

  //           if ($promoter_id)
  //           {
  //             $promoter = $this->db
  //               ->select('shop_name')
  //               ->from('promoters')
  //               ->where('id', $promoter_id)
  //               ->get()
  //               ->row_array();

  //             $promoter_shop_name = $promoter['shop_name'] ?? null;
  //           }
  //         }
  //       }
  //     }
  //   }

  //   // ===============================
  //   // 3️⃣ SIZE / COLOR CHECK
  //   // ===============================
  //   $sizeArray = $this->db
  //     ->get_where('tab_color_size_master', ['product_id' => $id])
  //     ->result_array();

  //   if (empty($sizeArray))
  //   {
  //     $this->session->set_flashdata('activate', getCustomAlert('E', 'Please add color & size'));
  //     redirect('admin/Product');
  //     return;
  //   }

  //   // ===============================
  //   // 4️⃣ BASIC INFO
  //   // ===============================
  //   $basic_info = $this->db
  //     ->get_where('tab_general_information', ['product_id' => $id])
  //     ->row_array();

  //   // ===============================
  //   // 5️⃣ VENDOR SUBSCRIPTION
  //   // ===============================
  //   $subscription = null;
  //   if ($vendor_id)
  //   {
  //     $subscription = $this->db->get_where('vendor_subscriptions_master', [
  //       'vendor_id' => $vendor_id,
  //       'status' => 1,
  //       'approval_status' => 1
  //     ])->row_array();
  //   }

  //   // ===============================
  //   // 6️⃣ UPDATE PRODUCTS
  //   // ===============================
  //   $this->db->trans_start();
  //   $unique_id = $this->generate_unique_id('PRD');

  //   foreach ($sizeArray as $value)
  //   {

  //     $image_info = $this->db
  //       ->get_where('tab_color_master', [
  //         'product_id' => $id,
  //         'color' => $value['color']
  //       ])->row_array();

  //     $updateData = [
  //       'shop_id' => $shop_id,
  //       'vendor_id' => $vendor_id,
  //       'promoter_id' => $promoter_id,
  //       'promoter_shop_name' => $promoter_shop_name,
  //       'added_type' => $adminData['Type'],
  //       'addedBy' => $adminData['Id'],
  //       'parent_category_id' => $basic_info['parent_id'],
  //       'category_id' => $basic_info['category_id'],
  //       'sub_category_id' => $basic_info['sub_category_id'],
  //       'product_name' => $basic_info['product_name'],
  //       'product_description' => $basic_info['product_description'],
  //       'price' => $value['price'],
  //       'final_price' => $value['final_price'],
  //       'quantity' => $value['qty'],
  //       'gst' => $value['gst'],
  //       'color' => $value['color'],
  //       'size' => $value['size'],
  //       'main_image' => $image_info['main_image'] ?? null,
  //       'image1' => $image_info['image1'] ?? null,
  //       'image2' => $image_info['image2'] ?? null,
  //       'image3' => $image_info['image3'] ?? null,
  //       'image4' => $image_info['image4'] ?? null,
  //       'image5' => $image_info['image5'] ?? null,
  //       'unique_id' => $unique_id,
  //       'status' => 3,
  //       'verify_status' => 2,
  //       'modify_date' => date('Y-m-d H:i:s')
  //     ];

  //     $this->db->where('id', $value['pro_id'])
  //       ->update('sub_product_master', $updateData);

  //     // 💰 Commission
  //     if (!empty($subscription) && $subscription['plan_type'] == 2)
  //     {
  //       $commission = $value['final_price'] * ($subscription['commission_percent'] ?? 10) / 100;
  //       $vendor_earning = $value['final_price'] - $commission;

  //       $this->db->set('vendor_earning', $vendor_earning)
  //         ->where('id', $value['pro_id'])
  //         ->update('sub_product_master');
  //     }
  //   }

  //   $this->db->trans_complete();

  //   $this->session->set_flashdata('activate', getCustomAlert('S', 'Product updated successfully'));
  //   redirect('admin/Product');
  // }

// public function final_submit2($id)
// {
//     $adminData = $this->session->userdata('adminData');
//     $data = $this->input->post();

//     // ===============================
//     // 1️⃣ Product Check
//     // ===============================
//     $productInfo = $this->db
//         ->get_where('sub_product_master', ['id' => $id])
//         ->row_array();

//     if (empty($productInfo)) {
//         $this->session->set_flashdata('activate', getCustomAlert('E', 'Product not found'));
//         redirect('admin/Product');
//         return;
//     }

//     // ===============================
//     // 2️⃣ SHOP / VENDOR / PROMOTER SETUP
//     // ===============================
//     $shop_id = 0;
//     $vendor_id = null;
//     $promoter_id = null;
//     $promoter_shop_name = null;

//     // 🔴 PROMOTER LOGIN
//     if ($adminData['Type'] == 3) {

//         $promoter_id = $adminData['Id'];

//         $promoter = $this->db->select('shop_name')
//             ->from('promoters')
//             ->where('id', $promoter_id)
//             ->get()->row_array();

//         $promoter_shop_name = $promoter['shop_name'] ?? null;

//     } else {

//         // 🔵 ADMIN / VENDOR
//         $shop_input = $data['shop_id'] ?? null;

//         if ($shop_input) {

//             // 🔴 PROMOTER PRODUCT SELECTED
//             if (strpos($shop_input, 'p_') === 0) {

//                 $promoter_id = (int)str_replace('p_', '', $shop_input);

//                 $promoter = $this->db->select('shop_name')
//                     ->from('promoters')
//                     ->where('id', $promoter_id)
//                     ->get()->row_array();

//                 $promoter_shop_name = $promoter['shop_name'] ?? null;

//             } else {

//                 // 🔵 VENDOR PRODUCT
//                 $shop_id = (int)$shop_input;

//                 $shop = $this->db->select('vendor_id')
//                     ->from('shop_master')
//                     ->where('id', $shop_id)
//                     ->get()->row_array();

//                 $vendor_id = $shop['vendor_id'] ?? null;

//                 if ($vendor_id) {
//                     $vendor = $this->db->select('promoter_id')
//                         ->from('vendors')
//                         ->where('id', $vendor_id)
//                         ->get()->row_array();

//                     $promoter_id = $vendor['promoter_id'] ?? null;

//                     if ($promoter_id) {
//                         $promoter = $this->db->select('shop_name')
//                             ->from('promoters')
//                             ->where('id', $promoter_id)
//                             ->get()->row_array();

//                         $promoter_shop_name = $promoter['shop_name'] ?? null;
//                     }
//                 }
//             }
//         }
//     }

//     // 🔒 Promoter → Vendor Update Lock
//     $isPromoterUpdatingVendor = ($adminData['Type'] == 3 && !empty($vendor_id));

//     // ===============================
//     // 3️⃣ SIZE / COLOR CHECK
//     // ===============================
//     $sizeArray = $this->db
//         ->get_where('tab_color_size_master', ['product_id' => $id])
//         ->result_array();

//     if (empty($sizeArray)) {
//         $this->session->set_flashdata('activate', getCustomAlert('E', 'Please add color & size'));
//         redirect('admin/Product');
//         return;
//     }

//     // ===============================
//     // 4️⃣ BASIC INFO
//     // ===============================
//     $basic_info = $this->db
//         ->get_where('tab_general_information', ['product_id' => $id])
//         ->row_array();

//     // ===============================
//     // 5️⃣ Vendor Subscription
//     // ===============================
//     $subscription = null;
//     if ($vendor_id) {
//         $subscription = $this->db->get_where('vendor_subscriptions_master', [
//             'vendor_id' => $vendor_id,
//             'status' => 1,
//             'approval_status' => 1
//         ])->row_array();
//     }

//     // ===============================
//     // 6️⃣ UPDATE PRODUCTS
//     // ===============================
//     $this->db->trans_start();
//     $unique_id = $this->generate_unique_id('PRD');

//     foreach ($sizeArray as $value) {

//         $image_info = $this->db->get_where('tab_color_master', [
//             'product_id' => $id,
//             'color' => $value['color']
//         ])->row_array();

//         // 🔒 PRICE CONTROL
//         if ($isPromoterUpdatingVendor) {
//             $price = $productInfo['price'];
//             $final_price = $productInfo['final_price'];
//         } else {
//             $price = $value['price'];
//             $final_price = $value['final_price'];
//         }

//         // 💰 COMMISSION % ONLY (NO EARNING HERE)
//         $commission_percent = 0;
//         if (!empty($subscription) && $subscription['plan_type'] == 2) {
//             $commission_percent = $subscription['commission_percent'] ?? 0;
//         }

//         $updateData = [
//             'shop_id' => $shop_id,
//             'vendor_id' => $vendor_id,
//             'promoter_id' => $promoter_id,
//             'promoter_shop_name' => $promoter_shop_name,

//             'added_type' => $adminData['Type'],
//             'addedBy' => $adminData['Id'],

//             'parent_category_id' => $basic_info['parent_id'],
//             'category_id' => $basic_info['category_id'],
//             'sub_category_id' => $basic_info['sub_category_id'],

//             'product_name' => $basic_info['product_name'],
//             'product_description' => $basic_info['product_description'],

//             'price' => $price,
//             'final_price' => $final_price,

//             'quantity' => $value['qty'],
//             'gst' => $value['gst'],
//             'color' => $value['color'],
//             'size' => $value['size'],

//             'main_image' => $image_info['main_image'] ?? null,
//             'image1' => $image_info['image1'] ?? null,
//             'image2' => $image_info['image2'] ?? null,
//             'image3' => $image_info['image3'] ?? null,
//             'image4' => $image_info['image4'] ?? null,
//             'image5' => $image_info['image5'] ?? null,

//             'commission_percent' => $commission_percent,
//             'unique_id' => $unique_id,
//             'status' => 3,
//             'verify_status' => 2,
//             'modify_date' => date('Y-m-d H:i:s')
//         ];

//         $this->db->where('id', $value['pro_id'])
//                  ->update('sub_product_master', $updateData);
//     }
//     if (!empty($data['field_name']) && !empty($data['field_value']))
//     {
//       foreach ($data['field_name'] as $k => $field_name)
//       {
//         $field_value = $data['field_value'][$k] ?? null;
//         if (empty($field_name))
//           continue;

//         $existing = $this->db->get_where('product_extra_fields', [
//           'product_id' => $id,
//           'field_name' => $field_name
//         ])->row_array();

//         if ($existing)
//         {
//           $this->db->where('id', $existing['id'])->update('product_extra_fields', [
//             'field_value' => $field_value
//           ]);
//         } else
//         {
//           $this->db->insert('product_extra_fields', [
//             'product_id' => $id,
//             'field_name' => $field_name,
//             'field_value' => $field_value
//           ]);
//         }
//       }
//     }

//     $this->db->trans_complete();

//     $this->session->set_flashdata('activate', getCustomAlert('S', 'Product updated successfully'));
//     redirect('admin/Product');
// }

public function final_submit2($id)
{
    $adminData = $this->session->userdata('adminData');
    $data = $this->input->post();

    // ===============================
    // 1️⃣ Product Check
    // ===============================
    $productInfo = $this->db->get_where('sub_product_master', ['id' => $id])->row_array();
    if (empty($productInfo)) {
        $this->session->set_flashdata('activate', getCustomAlert('E', 'Product not found'));
        redirect('admin/Product');
        return;
    }

    // ===============================
    // 2️⃣ SHOP / VENDOR / PROMOTER SETUP
    // ===============================
    $shop_id = $productInfo['shop_id']; // default = existing product
    $vendor_id = $productInfo['vendor_id']; 
    $promoter_id = $productInfo['promoter_id'];
    $promoter_shop_name = $productInfo['promoter_shop_name'];

    if ($adminData['Type'] == 3) { // Promoter
        $promoter_id = $adminData['Id'];
        $promoter = $this->db->select('shop_name')->from('promoters')->where('id', $promoter_id)->get()->row_array();
        $promoter_shop_name = $promoter['shop_name'] ?? null;
        $shop_id = 0; // promoter products may not have shop
        $vendor_id = 0;
    } else { // Admin / Vendor
        if (!empty($data['shop_id'])) {
            $shop_input = $data['shop_id'];
            if (strpos($shop_input, 'p_') === 0) { // promoter product selected
                $promoter_id = (int)str_replace('p_', '', $shop_input);
                $promoter = $this->db->select('shop_name')->from('promoters')->where('id', $promoter_id)->get()->row_array();
                $promoter_shop_name = $promoter['shop_name'] ?? null;
                $shop_id = 0;
                $vendor_id = 0;
            } else { // vendor product
                $shop_id = (int)$shop_input;
                $shop = $this->db->select('vendor_id')->from('shop_master')->where('id', $shop_id)->get()->row_array();
                $vendor_id = $shop['vendor_id'] ?? 0;
                if ($vendor_id) {
                    $vendor = $this->db->select('promoter_id')->from('vendors')->where('id', $vendor_id)->get()->row_array();
                    $promoter_id = $vendor['promoter_id'] ?? 0;
                    if ($promoter_id) {
                        $promoter = $this->db->select('shop_name')->from('promoters')->where('id', $promoter_id)->get()->row_array();
                        $promoter_shop_name = $promoter['shop_name'] ?? null;
                    }
                }
            }
        }
    }

    $isPromoterUpdatingVendor = ($adminData['Type'] == 3 && !empty($vendor_id));

    // ===============================
    // 3️⃣ SIZE / COLOR CHECK
    // ===============================
    $sizeArray = $this->db->get_where('tab_color_size_master', ['product_id' => $id])->result_array();
    if (empty($sizeArray)) {
        $this->session->set_flashdata('activate', getCustomAlert('E', 'Please add color & size'));
        redirect('admin/Product');
        return;
    }

    // ===============================
    // 4️⃣ BASIC INFO
    // ===============================
    $basic_info = $this->db->get_where('tab_general_information', ['product_id' => $id])->row_array();

    // ===============================
    // 5️⃣ Vendor Subscription
    // ===============================
    $subscription = null;
    if ($vendor_id) {
        $subscription = $this->db->get_where('vendor_subscriptions_master', [
            'vendor_id' => $vendor_id,
            'status' => 1,
            'approval_status' => 1
        ])->row_array();
    }

    // ===============================
    // 6️⃣ UPDATE PRODUCTS
    // ===============================
    $this->db->trans_start();
    $unique_id = $this->generate_unique_id('PRD');

    foreach ($sizeArray as $value) {

        $image_info = $this->db->get_where('tab_color_master', [
            'product_id' => $id,
            'color' => $value['color']
        ])->row_array();

        // 🔒 PRICE CONTROL
        if ($isPromoterUpdatingVendor) {
            $price = $productInfo['price'];
            $final_price = $productInfo['final_price'];
        } else {
            $price = $value['price'];
            $final_price = $value['final_price'];
        }

        // 💰 COMMISSION
        $commission_percent = 0;
        if (!empty($subscription) && $subscription['plan_type'] == 2) {
            $commission_percent = $subscription['commission_percent'] ?? 0;
        }

        $updateData = [
            'shop_id' => $shop_id,
            'vendor_id' => $vendor_id,
            'promoter_id' => $promoter_id,
            'promoter_shop_name' => $promoter_shop_name,

            'added_type' => $adminData['Type'],
            'addedBy' => $adminData['Id'],

            'parent_category_id' => $basic_info['parent_id'],
            'category_id' => $basic_info['category_id'],
            'sub_category_id' => $basic_info['sub_category_id'],

            'product_name' => $basic_info['product_name'],
            'product_description' => $basic_info['product_description'],

            'price' => $price,
            'final_price' => $final_price,

            'quantity' => $value['qty'],
            'gst' => $value['gst'],
            'color' => $value['color'],
            'size' => $value['size'],

            'main_image' => $image_info['main_image'] ?? null,
            'image1' => $image_info['image1'] ?? null,
            'image2' => $image_info['image2'] ?? null,
            'image3' => $image_info['image3'] ?? null,
            'image4' => $image_info['image4'] ?? null,
            'image5' => $image_info['image5'] ?? null,

            'commission_percent' => $commission_percent,
            'unique_id' => $unique_id,
            'status' => 3,
            'verify_status' => 2,
            'modify_date' => date('Y-m-d H:i:s')
        ];

        $this->db->where('id', $value['pro_id'])->update('sub_product_master', $updateData);
    }

    // ===============================
    // 7️⃣ EXTRA FIELDS UPDATE
    // ===============================
    if (!empty($data['field_name']) && !empty($data['field_value'])) {
        foreach ($data['field_name'] as $k => $field_name) {
            $field_value = $data['field_value'][$k] ?? null;
            if (empty($field_name)) continue;

            $existing = $this->db->get_where('product_extra_fields', [
                'product_id' => $id,
                'field_name' => $field_name
            ])->row_array();

            if ($existing) {
                $this->db->where('id', $existing['id'])->update('product_extra_fields', [
                    'field_value' => $field_value
                ]);
            } else {
                $this->db->insert('product_extra_fields', [
                    'product_id' => $id,
                    'field_name' => $field_name,
                    'field_value' => $field_value
                ]);
            }
        }
    }

    $this->db->trans_complete();

    $this->session->set_flashdata('activate', getCustomAlert('S', 'Product updated successfully'));
    redirect('admin/Product');
}

  public function AddProduct()
  {
    $tab = $this->input->get('tab');
    $adminData = $this->session->userdata('adminData');
    $this->load->model('Subscription_model');


    /* ===============================
       CLEAR TEMP TABLES (FIRST LOAD)
       =============================== */
    if (empty($tab))
    {
      $this->db->where_not_in('id', '5555555555555555555555')->delete('tab_color_master');
      $this->db->where_not_in('id', '5555555555555555555555')->delete('tab_color_size_master');
      $this->db->where_not_in('id', '5555555555555555555555')->delete('tab_general_information');
      $this->db->where_not_in('id', '5555555555555555555555')->delete('tab_size_master');
    }

    $post = $this->input->post();

    /* ===============================
       VENDOR SUBSCRIPTION CHECK
       =============================== */
    if ($adminData['Type'] == 2) // Vendor
    {
      $this->load->model('Subscription_model');
      $subscription = $this->Subscription_model->getActiveSubscription($adminData['Id']);

      if (!$subscription)
      {
        $this->session->set_flashdata('error', 'You cannot add products until your subscription is approved by Admin.');
        redirect('admin/Dashboard');
        return;
      }
    }
     if ($adminData['Type'] == 3) // Promoter
    {
        $active_subscription = $this->Subscription_model->getActiveSubscription($adminData['Id'], 'promoter');
        $pending_request = $this->Subscription_model->getPendingSubscriptionRequest($adminData['Id'], 'promoter');

        if (empty($active_subscription) && !empty($pending_request))
        {
            // Subscription requested but not approved yet
            $this->session->set_flashdata('error', 'Your subscription request is pending. You cannot add products until Admin approves your plan.');
            redirect('admin/Dashboard');
            return;
        }
        elseif (empty($active_subscription) && empty($pending_request))
        {
            // No subscription at all
            $this->session->set_flashdata('error', 'You must select a subscription plan before adding products.');
            redirect('admin/Dashboard');
            return;
        }

        $data['show_subscription_popup'] = (empty($active_subscription) && empty($pending_request)) ? 1 : 0;
    }


    /* ===============================
       FORM LOAD
       =============================== */
    if (empty($post))
    {
      $data['index'] = 'AddProduct';
      $data['index2'] = '';
      $data['title'] = 'Manage Product';

      $data['getParCatgy'] = $this->Product_model->getParCatgyList();
      $data['getCatgy'] = $this->Product_model->getCatgyList();
      $data['getBasicInfo'] = $this->Product_model->getBasicInfo();
      $data['getSizeColor'] = $this->Product_model->getSizeColor();

      /* ===============================
         SHOP DROPDOWN LOGIC
         =============================== */

      // if ($adminData['Type'] == '1') {
      //     // Admin → All shops
      //     $data['shopList'] = $this->db
      //         ->select('id, name')
      //         ->from('shop_master')
      //         ->where('status', '1')
      //         ->get()
      //         ->result_array();
      // } elseif ($adminData['Type'] == '2') {
      //     // Vendor → Only own shop
      //     $data['shopList'] = $this->db
      //         ->select('id, shop_name')
      //         ->from('vendors')
      //         ->where('status', '1')
      //         ->where('id', $adminData['Id'])
      //         ->get()
      //         ->result_array();
      // } elseif ($adminData['Type'] == '3') {
      //     // Promoter → All vendors under him
      //     $data['shopList'] = $this->db
      //         ->select('id, shop_name')
      //         ->from('vendors')
      //         ->where('promoter_id', $adminData['Id'])
      //         ->where('status', '1')
      //         ->get()
      //         ->result_array();
      // } else {
      //     $data['shopList'] = [];
      // }
/* ===============================
   SHOP DROPDOWN LOGIC
   =============================== */

      if ($adminData['Type'] == '1')
      {
        // Admin → All shops
        $data['shopList'] = $this->db
          ->select('id, name')
          ->from('shop_master')
          ->where('status', '1')
          ->get()
          ->result_array();
      } elseif ($adminData['Type'] == '2')
      {
        // Vendor → Only own shop
        $data['shopList'] = $this->db
          ->select('id, shop_name')
          ->from('vendors')
          ->where('status', '1')
          ->where('id', $adminData['Id'])
          ->get()
          ->result_array();
      } elseif ($adminData['Type'] == '3')
      {
        // Promoter → Own shop + all vendors under him
        $promoterShop = $this->db
          ->select('id, shop_name')
          ->from('promoters')
          ->where('id', $adminData['Id'])
          ->get()
          ->row_array();

        $vendorsShops = $this->db
          ->select('id, shop_name')
          ->from('vendors')
          ->where('promoter_id', $adminData['Id'])
          ->where('status', '1')
          ->get()
          ->result_array();

        // Merge promoter shop + vendor shops
        $data['shopList'] = [];

        if (!empty($promoterShop))
        {
          $data['shopList'][] = $promoterShop;
        }

        if (!empty($vendorsShops))
        {
          $data['shopList'] = array_merge($data['shopList'], $vendorsShops);
        }
      } else
      {
        $data['shopList'] = [];
      }

      $this->load->view('include/header', $data);
      $this->load->view('Product/AddProduct');
      $this->load->view('include/footer');
      return;
    }

    /* ===============================
       FORM SUBMIT
       =============================== */ else
    {
      /* ===============================
         IMAGE UPLOAD
         =============================== */
      $images = ['thumbnail', 'image1', 'image2', 'image3', 'image4'];
      foreach ($images as $img)
      {
        if (!empty($_FILES[$img]['name']))
        {
          $ext = pathinfo($_FILES[$img]['name'], PATHINFO_EXTENSION);
          $newName = 'Product_' . uniqid() . '.' . $ext;
          move_uploaded_file($_FILES[$img]['tmp_name'], PRODUCT_DIRECTORY . $newName);
          $post[$img] = $newName;
        }
      }

      /* ===============================
         GET VENDOR & PROMOTER FROM SHOP
         =============================== */
      $shop = $this->db
        ->select('vendor_id')
        ->from('shop_master')
        ->where('id', $post['shop_id'])
        ->get()
        ->row_array();

      $vendor_id = @$shop['vendor_id'];
      $promoter_id = null;

      if (!empty($vendor_id))
      {
        $vendor = $this->db
          ->select('promoter_id')
          ->from('vendors')
          ->where('id', $vendor_id)
          ->get()
          ->row_array();

        $promoter_id = @$vendor['promoter_id'];
      }

      /* ===============================
         PREPARE DATA
         =============================== */
      $fields = [
        'shop_id' => $post['shop_id'],
        'vendor_id' => $vendor_id,
        'promoter_id' => $promoter_id,
        'product_name' => $post['ProductName'],
        'product_description' => $post['product_description'],
        'main_image' => @$post['thumbnail'],
        'image1' => @$post['image1'],
        'image2' => @$post['image2'],
        'image3' => @$post['image3'],
        'image4' => @$post['image4'],
        'unique_id' => uniqid('PROD_'),
        'status' => 1,
        'add_date' => date('Y-m-d H:i:s'),
        'modify_date' => date('Y-m-d H:i:s')
      ];

      /* ===============================
         ROLE BASED SETTINGS
         =============================== */
      if ($adminData['Type'] == '1')
      {
        $fields['verify_status'] = 1; // Approved
        $fields['added_type'] = 1; // Admin
        $fields['addedBy'] = $adminData['Id'];
      } elseif ($adminData['Type'] == '2')
      {
        $fields['verify_status'] = 0; // Pending (vendor product)
        $fields['added_type'] = 2; // Vendor
        $fields['addedBy'] = $adminData['Id'];
      } elseif ($adminData['Type'] == '3')
      {
        $fields['verify_status'] = 0; // Pending
        $fields['added_type'] = 3; // Promoter
        $fields['addedBy'] = $adminData['Id'];
      }

      /* ===============================
         INSERT
         =============================== */
      $insert = $this->db->insert('sub_product_master', $fields);

      if ($insert)
      {
        $this->session->set_flashdata('activate', getCustomAlert('S', 'Product added successfully.'));
      } else
      {
        $this->session->set_flashdata('activate', getCustomAlert('E', 'Something went wrong.'));
      }

      redirect('admin/Product/');
    }
  }



  // -----------------------------------------
  public function ajaxGetCategoriesByParent_v2($parent_id = null)
  {
    $list = [];
    if (is_numeric($parent_id))
    {
      $list = $this->Product_model->getCategoriesByParent_v2($parent_id);
    }

    $html = "<option value=''>Select Category</option>";
    foreach ($list as $row)
    {
      $html .= "<option value='{$row['id']}'>" . ucfirst($row['category_name']) . "</option>";
    }
    echo $html;
  }

  // --------------
  public function ajaxGetSubcategoriesByCategory_v2($cat_id = null)
  {
    $list = [];
    if (is_numeric($cat_id))
    {
      $list = $this->Product_model->getSubcategoriesByCategory_v2($cat_id);
    }

    $html = "<option value=''>Select Sub Category</option>";
    foreach ($list as $row)
    {
      $html .= "<option value='{$row['id']}'>" . ucfirst($row['sub_category_name']) . "</option>";
    }
    echo $html;
  }
  // -----------------------------------------------

  public function AddBulkProduct()
  {
    $adminData = $this->session->userdata('adminData');
    $data['index'] = 'bulk';
    $data['index2'] = '';
    $data['title'] = 'Manage Bulk Product';

    if ($adminData['Type'] == '1')
    {

      $data['shopList'] = $this->db->get_where('shop_master', array('status' => '1'))->result_array();
    } else
    {

      $data['shopList'] = $this->db->get_where('shop_master', array('status' => '1', 'type' => '2', 'addedBy' => $adminData['Id']))->result_array();

    }

    $data['getCatgy'] = $this->db->get_where('parent_category_master', array('status' => '1'))->result_array();
    ;
    $this->load->view('include/header', $data);
    $this->load->view('Product/AddBulkProduct');
    $this->load->view('include/footer');
  }




  public function getCatgry($id = '', $cat = '')
  {
    $this->db->order_by('category_name', 'Asc');
    $Data = $this->db->get_where('category_master', array('categoryy_master_id' => $id, 'status' => '1'))->result_array();
    $html = '';
    $html .= '<option value="">Select Category</option>';
    @$select = '';
    foreach ($Data as $value)
    {
      if ($cat == $value['id'])
      {
        $select = 'selected';
      } else
      {
        $select = '';
      }
      $html .= '<option value ="' . $value['id'] . '" ' . $select . ' >' . $value['category_name'] . '</option>';
    }
    echo $html;
  }




  public function getsubCatgy($id = '', $sub_cat = '')
  {
    $this->db->order_by('sub_category_name', 'Asc');
    $Data = $this->db->get_where('sub_category_master', array('category_master_id' => $id, 'status' => '1'))->result_array();
    $html = '';
    $html .= '<option value="">Select Sub Category</option>';
    @$select = '';
    foreach ($Data as $value)
    {
      if ($sub_cat == $value['id'])
      {
        $select = 'selected';
      } else
      {
        $select = '';
      }
      $html .= '<option value ="' . $value['id'] . '" ' . $select . ' >' . $value['sub_category_name'] . '</option>';
    }
    echo $html;
  }
  public function getbrand($id = '')
  {
    $this->db->order_by('brand_name', 'Asc');
    $Data = $this->db->get_where('brand_master', array('sub_category_master_id' => $id, 'status' => '1'))->result_array();
    $html = '';
    $html .= '<option value ="">Select Brand</option>';
    foreach ($Data as $value)
    {

      $html .= '<option value ="' . $value['id'] . '"  >' . $value['brand_name'] . '</option>';
    }
    echo $html;
  }



  public function finalPrice($price = '', $amt = '', $type = "")
  {
    if ($type == 1)
    {
      $fm = $price - $amt;
    } else
    {

      $Pamt = ($amt / 100) * $price;
      $fm = $price - $Pamt;
    }
    echo $fm;
  }

  public function AddProductData()
  {
    $data = $this->input->post();
    $row = $this->Product_model->AddProductData($data);
    if ($row > 0)
    {
      $this->session->set_flashdata('activate', getCustomAlert('S', ' Product has been add Successfully.'));
      redirect('admin/Product/');
    } else
    {
      $this->session->set_flashdata('activate', getCustomAlert('S', '!Opps Something is worng.Please try again.'));
      redirect('admin/Product/');
    }
  }

  public function delete_product($id)
  {
    $this->db->where('id', $id);
    $row = $this->db->delete('sub_product_master');
    if ($row > 0)
    {
      $this->session->set_flashdata('activate', getCustomAlert('S', ' Product has been deleted Successfully.'));
      redirect('admin/Product/');
    } else
    {
      $this->session->set_flashdata('activate', getCustomAlert('S', '!Opps Something is worng.Please try again.'));
      redirect('admin/Product/');
    }

  }





  public function update_action()
  {

    $shop_id = $this->input->post('shop_id');
    $action_id = $this->input->post('action');
    $product_ids = $this->input->post('set_checked_id');
    $main_product_code = $this->input->post('results');
    $main_product_array = explode(",", $main_product_code);
    $selcted_product_code = str_replace(",1", "", $product_ids);
    $product_array = explode(",", $selcted_product_code);

    if ($action_id == '1')
    {

      $fields['verify_status'] = '1';
      $fields['status'] = '1';
      $this->db->where('shop_id', $shop_id);
      $row = $this->db->update('sub_product_master', $fields);
      $this->db->group_by('product_code');
      $count_prodcut = $this->db->get_where('sub_product_master', array('shop_id', $shop_id))->num_rows();

      if ($row > 0)
      {
        $this->session->set_flashdata('activate', getCustomAlert('S', 'Verify ' . $count_prodcut . ' Product Successfully.'));
        redirect('admin/Product/index');
      } else
      {
        $this->session->set_flashdata('activate', getCustomAlert('D', '!Opps Something is worng.Please try again.'));
        redirect('admin/Product/index');

      }


    } else if ($action_id == '2')
    {

      $fields['verify_status'] = '1';
      $fields['status'] = '1';
      $this->db->where_in('product_code', $product_array);
      $row = $this->db->update('sub_product_master', $fields);

      if ($row > 0)
      {
        $this->session->set_flashdata('activate', getCustomAlert('S', 'Verify ' . count($product_array) . ' Product Successfully.'));
        redirect('admin/Product/index');
      } else
      {
        $this->session->set_flashdata('activate', getCustomAlert('D', '!Opps Something is worng.Please try again.'));
        redirect('admin/Product/index');

      }

    } else if ($action_id == '3')
    {

      $fields['verify_status'] = '2';
      $fields['status'] = '2';
      $this->db->where('shop_id', $shop_id);
      $row = $this->db->update('sub_product_master', $fields);
      $this->db->group_by('product_code');
      $count_prodcut = $this->db->get_where('sub_product_master', array('shop_id', $shop_id))->num_rows();
      if ($row > 0)
      {
        $this->session->set_flashdata('activate', getCustomAlert('S', 'Unverify ' . $count_prodcut . ' Product Successfully.'));
        redirect('admin/Product/index');
      } else
      {
        $this->session->set_flashdata('activate', getCustomAlert('D', '!Opps Something is worng.Please try again.'));
        redirect('admin/Product/index');

      }

    } else if ($action_id == '4')
    {

      $fields['verify_status'] = '2';
      $fields['status'] = '2';
      $this->db->where_in('product_code', $product_array);
      $row = $this->db->update('sub_product_master', $fields);

      if ($row > 0)
      {
        $this->session->set_flashdata('activate', getCustomAlert('S', 'Unverify ' . count($product_array) . ' Product Successfully.'));
        redirect('admin/Product/index');
      } else
      {
        $this->session->set_flashdata('activate', getCustomAlert('D', '!Opps Something is worng.Please try again.'));
        redirect('admin/Product/index');

      }

    } else if ($action_id == '5')
    {
      $this->db->where_in('product_code', $product_array);
      $row = $this->db->delete('sub_product_master');

      if ($row > 0)
      {
        $this->session->set_flashdata('activate', getCustomAlert('S', 'Delete ' . count($product_array) . ' Product Successfully.'));
        redirect('admin/Product/index');
      } else
      {
        $this->session->set_flashdata('activate', getCustomAlert('D', '!Opps Something is worng.Please try again.'));
        redirect('admin/Product/index');

      }


    } else if ($action_id == '6')
    {
      $this->db->group_by('product_code');
      $count_prodcut = $this->db->get_where('sub_product_master', array('shop_id' => $shop_id))->num_rows();

      $this->db->where('shop_id', $shop_id);
      $row = $this->db->delete('sub_product_master');
      if ($row > 0)
      {
        $this->session->set_flashdata('activate', getCustomAlert('S', 'Delete ' . $count_prodcut . ' Product Successfully.'));
        redirect('admin/Product/index');
      } else
      {
        $this->session->set_flashdata('activate', getCustomAlert('D', '!Opps Something is worng.Please try again.'));
        redirect('admin/Product/index');

      }


    }


  }






  // public function UpdateProduct($id = '')
  // {
  //   $this->setUpdataData($id);

  //   $adminData = $this->session->userdata('adminData');

  //   $data['index'] = 'UpdtProduct';
  //   $data['index2'] = '';
  //   $data['title'] = 'Update Product';

  //   /* ================= GET PRODUCT INFO ================= */
  //   $product = $this->db->get_where('sub_product_master', array('id' => $id))->row_array();

  //   if (empty($product))
  //   {
  //     $this->session->set_flashdata('activate', getCustomAlert('E', 'Invalid Product'));
  //     redirect('admin/Product');
  //   }

  //   /* ================= ROLE BASED SHOP LIST ================= */

  //   // ================= ADMIN =================
  //   if ($adminData['Type'] == '1')
  //   {
  //     // Admin can see all shops from shop_master
  //     $data['shopList'] = $this->db
  //       ->select('id, bussiness_name as shop_name')
  //       ->from('shop_master')
  //       ->where('status', '1')
  //       ->get()
  //       ->result_array();
  //   }

  //   // ================= VENDOR =================
  //   elseif ($adminData['Type'] == '2')
  //   {
  //     // Vendor can update only his products
  //     if ($product['vendor_id'] != $adminData['Id'])
  //     {
  //       $this->session->set_flashdata('activate', getCustomAlert('E', 'Unauthorized Access'));
  //       redirect('admin/Product');
  //     }

  //     // Vendor shop name directly from vendors table
  //     $data['shopList'] = $this->db
  //       ->select('id, shop_name')
  //       ->from('vendors')
  //       ->where('status', '1')
  //       ->where('id', $adminData['Id'])
  //       ->get()
  //       ->result_array();
  //   }

  //   // ================= PROMOTER =================
  //   elseif ($adminData['Type'] == '3')
  //   {
  //     // Promoter can update only his vendors' products
  //     if ($product['promoter_id'] != $adminData['Id'])
  //     {
  //       $this->session->set_flashdata('activate', getCustomAlert('E', 'Unauthorized Access'));
  //       redirect('admin/Product');
  //     }

  //     // Promoter sees all shops of his vendors
  //     $data['shopList'] = $this->db
  //       ->select('vendors.id, vendors.shop_name')
  //       ->from('vendors')
  //       ->where('vendors.status', '1')
  //       ->where('vendors.promoter_id', $adminData['Id'])
  //       ->get()
  //       ->result_array();
  //   } else
  //   {
  //     $data['shopList'] = [];
  //   }

  //   /* ================= OTHER DATA ================= */
  //   $data['getParCatgy'] = $this->Product_model->getParCatgyList();
  //   $data['getCatgy'] = $this->Product_model->getCatgyList();
  //   $data['getBasicInfo'] = $this->Product_model->getBasicInfo1($id);
  //   $data['getSizeColor'] = $this->Product_model->getSizeColor1($id);
  //   $data['getData'] = $product;

  //   /* ================= LOAD VIEWS ================= */
  //   $this->load->view('include/header', $data);
  //   $this->load->view('Product/UpdateProduct', $data);
  //   $this->load->view('include/footer');
  // }

  public function UpdateProduct($id = '')
  {
    $this->setUpdataData($id);
    $adminData = $this->session->userdata('adminData');

    $data['index'] = 'UpdtProduct';
    $data['index2'] = '';
    $data['title'] = 'Update Product';

    /* ================= GET PRODUCT INFO ================= */
    $product = $this->db->get_where('sub_product_master', ['id' => $id])->row_array();
    if (empty($product))
    {
      $this->session->set_flashdata('activate', getCustomAlert('E', 'Invalid Product'));
      redirect('admin/Product');
    }

    /* ================= ROLE BASED SHOP LIST ================= */
    if ($adminData['Type'] == '1')
    {
      $data['shopList'] = $this->db
        ->select('id, bussiness_name as shop_name')
        ->from('shop_master')
        ->where('status', '1')
        ->get()
        ->result_array();
    } elseif ($adminData['Type'] == '2')
    {
      if ($product['vendor_id'] != $adminData['Id'])
      {
        $this->session->set_flashdata('activate', getCustomAlert('E', 'Unauthorized Access'));
        redirect('admin/Product');
      }
      $data['shopList'] = $this->db
        ->select('id, shop_name')
        ->from('vendors')
        ->where('status', '1')
        ->where('id', $adminData['Id'])
        ->get()
        ->result_array();
    } elseif ($adminData['Type'] == '3')
    {
      if ($product['promoter_id'] != $adminData['Id'])
      {
        $this->session->set_flashdata('activate', getCustomAlert('E', 'Unauthorized Access'));
        redirect('admin/Product');
      }
      $data['shopList'] = $this->db
        ->select('vendors.id, vendors.shop_name')
        ->from('vendors')
        ->where('vendors.status', '1')
        ->where('vendors.promoter_id', $adminData['Id'])
        ->get()
        ->result_array();
    } else
    {
      $data['shopList'] = [];
    }

    /* ================= OTHER DATA ================= */
    $data['getParCatgy'] = $this->Product_model->getParCatgyList();
    $data['getCatgy'] = $this->Product_model->getCatgyList();
    $data['getBasicInfo'] = $this->Product_model->getBasicInfo1($id);
    $data['getSizeColor'] = $this->Product_model->getSizeColor1($id);
    $data['getData'] = $product;

    // ================= EXISTING EXTRA FIELDS =================
    $data['dynamicFields'] = $this->db
      ->where('product_id', $id)
      ->get('product_extra_fields')
      ->result_array();

    /* ================= LOAD VIEWS ================= */
    $this->load->view('include/header', $data);
    $this->load->view('Product/UpdateProduct', $data);
    $this->load->view('include/footer');
  }


  public function setUpdataData($pro_id)
  {

    $product_info = $this->db->get_where('sub_product_master', array('id' => $pro_id))->row_array();

    $basic_info['shop_id'] = $product_info['shop_id'];
    $basic_info['parent_id'] = $product_info['parent_category_id'];
    $basic_info['category_id'] = $product_info['category_id'];
    $basic_info['sub_category_id'] = $product_info['sub_category_id'];
    $basic_info['product_name'] = $product_info['product_name'];
    $basic_info['sku_code'] = $product_info['sku_code'];
    $basic_info['weight'] = $product_info['weight'];
    $basic_info['packet_length'] = $product_info['packet_length'];
    $basic_info['packet_weight'] = $product_info['packet_weight'];
    $basic_info['packet_height'] = $product_info['packet_height'];
    $basic_info['product_description'] = $product_info['product_description'];
    $basic_info['type'] = '2';

    $basic_info['product_id'] = $product_info['id'];

    $check_general_info = $this->db->get_where('tab_general_information', array('product_id' => $product_info['id']))->row_array();

    if (empty($check_general_info))
    {

      $this->db->insert('tab_general_information', $basic_info);
    }


    $check_color_size = $this->db->get_where('tab_color_size_master', array('product_id' => $product_info['id']))->row_array();

    $check_size = $this->db->get_where('tab_size_master', array('product_id' => $product_info['id']))->row_array();

    $check_color = $this->db->get_where('tab_color_master', array('product_id' => $product_info['id']))->row_array();



    $this->db->select('id,size,color,price,final_price,quantity,gst');

    $total_product = $this->db->get_where('sub_product_master', array('product_code' => $product_info['product_code']))->result_array();



    /*Tab Color Size Master*/

    foreach ($total_product as $key => $product)
    {

      $color_size['color'] = $product['color'];
      $color_size['size'] = $product['size'];
      $color_size['price'] = $product['price'];
      $color_size['final_price'] = $product['final_price'];
      $color_size['qty'] = $product['quantity'];
      $color_size['gst'] = $product['gst'];
      $color_size['type'] = '2';
      $color_size['product_id'] = $product_info['id'];
      $color_size['pro_id'] = $product['id'];


      if (empty($check_color_size))
      {

        $this->db->insert('tab_color_size_master', $color_size);

      }

      $field['color_id'] = $product['color'];
      $field['size'] = $product['size'];
      $field['type'] = '2';
      $field['product_id'] = $product_info['id'];
      $field['pro_id'] = $product['id'];
      if (empty($check_size))
      {

        $this->db->insert('tab_size_master', $field);

      }


    }


    /*tab Image Insert By Color */

    $this->db->select('DISTINCT(color) as color,color_code');
    $colorData = $this->db->get_where('sub_product_master', array('product_code' => $product_info['product_code']))->result_array();



    foreach ($colorData as $key => $colorValue)
    {

      $this->db->select('id,main_image,image1,image2,image3,image4,image5');
      $pro_id = $this->db->get_where('sub_product_master', array('color_code' => $colorValue['color_code'], 'color' => $colorValue['color']))->row_array();

      $color_info['color'] = $colorValue['color'];
      $color_info['main_image'] = $pro_id['main_image'];
      $color_info['image1'] = $pro_id['image1'];
      $color_info['image2'] = $pro_id['image2'];
      $color_info['image3'] = $pro_id['image3'];
      $color_info['image4'] = $pro_id['image4'];
      $color_info['image5'] = $pro_id['image5'];
      $color_info['type'] = '2';
      $color_info['product_id'] = $product_info['id'];
      $color_info['pro_id'] = $pro_id['id'];

      if (empty($check_color))
      {

        $this->db->insert('tab_color_master', $color_info);
      }


      $lastId = $this->db->insert_id();




    }



    /*Tab Size Master*/







  }










  public function getsubCatgy2($id = '', $id2 = '')
  {

    $Data = $this->db->get_where('sub_category_master', array('category_master_id' => $id, 'status' => '1'))->result_array();

    //$Data = $this->db->get_where('sub_category_master')->result_array();
    $html = '';

    foreach ($Data as $value)
    {
      if ($value['id'] == $id2)
      {
        $html .= '<option value ="' . $value['id'] . '"  selected="Selected" >' . $value['sub_category_name'] . '</option>';
      } else
      {

        $html .= '<option value ="' . $value['id'] . '"   >' . $value['sub_category_name'] . '</option>';
      }


    }
    echo $html;
  }


  public function getbrand2($id = '', $id2 = '')
  {


    $Data = $this->db->get_where('brand_master', array('sub_category_master_id' => $id, 'status' => '1'))->result_array();
    $html = '';
    $html .= '<option value ="">Select Brand</option>';
    foreach ($Data as $value)
    {
      if ($value['id'] == $id2)
      {
        $html .= '<option value ="' . $value['id'] . '"  selected="Selected" >' . $value['brand_name'] . '</option>';
      } else
      {
        $html .= '<option value ="' . $value['id'] . '"  >' . $value['brand_name'] . '</option>';
      }
    }
    echo $html;
  }

  public function deleteSingleImages()
  {
    $id = $this->uri->segment(4);
    $Data = $this->db->query("SELECT * FROM `product_images_master` WHERE id = '" . $id . "' ")->row_array();

    unlink(PRODUCT_DIRECTORY . $Data['product_image']);

    $result = $this->Product_model->del_Images($id);
    echo $result;


  }


  public function UpdateProductData($id = '')
  {
    $adminData = $this->session->userdata('adminData');
    $data = $this->input->post();
    $data['id'] = $id;
    /*echo "<pre>";
    print_r($data); exit;*/
    $row = $this->Product_model->UpdateProductData($data, $adminData['Id']);
    if ($row > 0)
    {
      $this->session->set_flashdata('activate', getCustomAlert('S', ' Product has been Update Successfully.'));
      redirect('admin/Product/');
    } else
    {
      $this->session->set_flashdata('activate', getCustomAlert('S', '!Opps Something is worng.Please try again.'));
      redirect('admin/Product/');
    }
  }

  public function ProductStatus($id = '')
  {
    $id = $this->uri->segment(4);
    $sql = $this->db->query("SELECT * from product_master where id= '" . $id . "'")->row_array();
    //print_r($sql); exit;

    $arrayName = array();
    $arrayName['status'] = ($sql['status'] == 1) ? '2' : '1';
    $this->db->where('id', $id);
    $this->db->update('product_master', $arrayName);
    echo $arrayName['status'];
  }


  public function getproductDeal()
  {
    $id = $this->uri->segment(4);
    $SQL = "SELECT * FROM product_master where id = '" . $id . "'";
    $query = $this->db->query($SQL)->row_array();
    print_r($query);
  }

  public function AddDeal()
  {
    $data = $this->input->post();

    $check = $this->Product_model->updateDeal($data);
    if ($check > 0)
    {
      echo '1';
    } else
    {
      echo '2';
    }
  }
  public function updateCashback()
  {
    $data = $this->input->post();

    $check = $this->Product_model->updateCashback($data);
    if ($check > 0)
    {
      echo '1';
    } else
    {
      echo '2';
    }
  }

  public function keywordByData($v_id = '')
  {

    $config = array();
    $config["base_url"] = base_url() . "admin/Product/keywordByData";
    $config["total_rows"] = $this->Product_model->record_counter('product_master');
    $config["per_page"] = "15";
    $config["uri_segment"] = "4";

    $this->pagination->initialize($config);

    $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
    $data['results'] = $this->Product_model->byKeword_AllProduct($config["per_page"], $page);
    $data["links"] = $this->pagination->create_links();

    $data['index'] = 'Product';
    $data['index2'] = '';
    $data['title'] = 'Manage Product';
    $data['v_id'] = ($v_id != "") ? $v_id : '';

    $this->load->view('include/header', $data);
    $this->load->view('Product/ProductList');
    $this->load->view('include/footer');
  }

  public function action2()
  {
    $this->load->view('getData');
  }
  public function AddSubProduct($productId)
  {

    $data = $this->input->post();
    $fields = array();
    $fields['product_discount_type'] = $data['DiscounType'];
    $fields['product_discount_amount'] = $data['amountPer'];
    $fields['price'] = $data['prod_price'];
    $fields['final_price'] = $data['prod_fprice'];
    $fields['weight_litr'] = $data['whtLtr'];
    $fields['unit'] = $data['unit'];
    $fields['quantity'] = $data['qty'];
    $fields['reference'] = $productId;
    $fields['cgst_amount'] = !empty($data['cgst_amount']) ? $data['cgst_amount'] : '0';
    $fields['sgst_amount'] = !empty($data['sgst_amount']) ? $data['sgst_amount'] : '0';
    $fields['total_tax_amt'] = !empty($data['total_tax_amt']) ? $data['total_tax_amt'] : '0';
    $fields['unit_price'] = !empty($data['unit_price']) ? $data['unit_price'] : '0';
    $fields['add_date'] = time();
    $fields['modify_date'] = time();
    $fields['status'] = '1';

    $row = $this->Product_model->AddSubProductData($fields);
    $url = base_url() . 'admin/Product/UpdateProduct/' . $productId;
    if ($row > 0)
    {
      $this->session->set_flashdata('activate', getCustomAlert('S', 'Sub Product Data has been add Successfully.'));
      redirect($url);
    } else
    {
      $this->session->set_flashdata('activate', getCustomAlert('S', '!Opps Something is worng.Please try again.'));
      redirect($url);
    }


  }

  public function RemoveDeal()
  {
    $id = $this->input->post('id');
    $fields = array();
    $fields['deal_of_day_start'] = '';
    $fields['deal_of_day_end'] = '';
    $fields['dod_discount_type'] = '';
    $fields['dod_amount'] = '';
    $this->db->where('id', $id);
    $this->db->update('product_master', $fields);
  }


  public function action3()
  {
    $this->load->view('dataForEditSubProduct');
  }

  public function editSubProduct($subProductId)
  {

    $data = $this->input->post();
    $fields = array();
    $fields['product_discount_type'] = $data['DiscounType'];
    $fields['product_discount_amount'] = $data['amountPer'];
    $fields['price'] = $data['prod_price'];
    $fields['final_price'] = $data['prod_fprice'];
    $fields['weight_litr'] = $data['whtLtr'];
    $fields['unit'] = $data['unit'];
    $fields['quantity'] = $data['qty'];
    $fields['cgst_amount'] = $data['cgst_amount'];
    $fields['sgst_amount'] = $data['sgst_amount'];
    $fields['total_tax_amt'] = $data['total_tax_amt'];
    $fields['unit_price'] = $data['unit_price'];
    $fields['modify_date'] = time();
    $getParentId = $this->db->get_where('product_master', array('id' => $subProductId))->row_array();
    $row = $this->Product_model->editSubProductData($fields, $subProductId);
    $url = base_url() . 'admin/Product/UpdateProduct/' . $getParentId['reference'];
    if ($row > 0)
    {
      $this->session->set_flashdata('activate', getCustomAlert('S', 'Sub Product Data Successfully Updated.'));
      redirect($url);
    } else
    {
      $this->session->set_flashdata('activate', getCustomAlert('S', '!Opps Something is worng.Please try again.'));
      redirect($url);
    }
  }

  public function addMoreProduct()
  {

    $id = $this->input->post('id');
    $html = "";
    $html .= '<div id="remove_' . $id . '">
                 <div class="row" style="margin-left: 10px;"> 
                    <div class="col-sm-4">
                       <label>Color <span class="err_color">*</span></label>
                        <input type="text" class="form-control" name="color[]" placeholder="Color" required>
                    </div>

                    <div class="col-sm-4">
                      <label>Size <span class="err_color">*</span></label>
                       <select class="form-control select2" multiple id="related_size<?= $id ?>" name="size<?= ($id - 1) ?>[]" style="width: 100%;">
                        <!-- Clothing -->
                        <option value="XS">XS</option>
                        <option value="S">S</option>
                        <option value="M">M</option>
                        <option value="L">L</option>
                        <option value="XL">XL</option>
                        <option value="XXL">XXL</option>
                        <option value="3XL">3XL</option>
                        <option value="4XL">4XL</option>
                        <option value="Free Size">Free Size</option>

                        <!-- Pants/Jeans -->
                        <option value="28">28</option>
                        <option value="30">30</option>
                        <option value="32">32</option>
                        <option value="34">34</option>
                        <option value="36">36</option>
                        <option value="38">38</option>
                        <option value="40">40</option>
                        <option value="42">42</option>
                        <option value="Onesize">Onesize</option>

                        <!-- Footwear -->
                        <option value="UK3">UK3</option>
                        <option value="UK4">UK4</option>
                        <option value="UK5">UK5</option>
                        <option value="UK6">UK6</option>
                        <option value="UK7">UK7</option>
                        <option value="UK8">UK8</option>
                        <option value="UK9">UK9</option>
                        <option value="UK10">UK10</option>
                        <option value="UK11">UK11</option>

                        <!-- Kids -->
                        <option value="1 – 1.5 years">1 – 1.5 years</option>
                        <option value="2 – 2.5 years">2 – 2.5 years</option>
                        <option value="3 – 3.5 years">3 – 3.5 years</option>
                        <option value="4 – 4.5 years">4 – 4.5 years</option>
                        <option value="5 – 5.5 years">5 – 5.5 years</option>
                        <option value="6 – 7 years">6 – 7 years</option>
                        <option value="8 – 9 years">8 – 9 years</option>
                        <option value="10 – 11 years">10 – 11 years</option>
                        <option value="12 – 13 years">12 – 13 years</option>

                        <!-- Mobile / Tablet Screen Sizes (inches) -->
                        <option value="4.0 inch">4.0 inch</option>
                        <option value="4.5 inch">4.5 inch</option>
                        <option value="5.0 inch">5.0 inch</option>
                        <option value="5.5 inch">5.5 inch</option>
                        <option value="6.0 inch">6.0 inch</option>
                        <option value="6.1 inch">6.1 inch</option>
                        <option value="6.2 inch">6.2 inch</option>
                        <option value="6.5 inch">6.5 inch</option>
                        <option value="6.7 inch">6.7 inch</option>
                        <option value="6.8 inch">6.8 inch</option>
                        <option value="7.0 inch">7.0 inch</option>
                        <option value="7.5 inch">7.5 inch</option>
                        <option value="8.0 inch">8.0 inch</option>
                        <option value="8.5 inch">8.5 inch</option>
                        <option value="9.0 inch">9.0 inch</option>
                        <option value="10.0 inch">10.0 inch</option>
                        <option value="10.5 inch">10.5 inch</option>
                        <option value="11.0 inch">11.0 inch</option>
                        <option value="12.0 inch">12.0 inch</option>
                    </select>

                    </div>

                     <div class="col-sm-4">
                        <span  class="btn btn-danger" style="float: right;" onclick="remove_row(' . $id . ')" >Remove</span>
                    </div>
                </div><br></div>
                 <div id="add_more_' . $id . '">
                   <div class="row" style="margin-left: 10px;"> 
                    <button type="button" class="btn btn-info pull-right"  onclick="addMoreProduct(' . ($id + 1) . ');">Add More</button>
                  </div><br> 


              </div>';


    echo $html;
    exit;
  }

  public function addMoreProd()
  {
    $id = $this->input->post('id');
    $html = "";
    $html .= '<div id="remove_' . $id . '">
                 <div class="row" style="margin-left: 10px;"> 
                    <div class="col-sm-4">
                       <label>Color <span class="err_color">*</span></label>
                        <input type="text" class="form-control" name="color[]" placeholder="Color" required>
                    </div>

                    <div class="col-sm-4">
                      <label>Size <span class="err_color">*</span></label>

                      <!-- FIXED HERE: name="size[]" instead of size' . ($id - 1) . '[] -->
                      <select class="form-control select2" multiple="" id="related_size' . $id . '" name="size[]" style="width: 100%;">
                             <option value="XS">XS</option>
                             <option value="S">S</option>
                             <option value="M">M</option>
                             <option value="L">L</option>
                             <option value="XL">XL</option>
                             <option value="XXL">XXL</option>
                             <option value="3XL">3XL</option>
                             <option value="4XL">4XL</option>
                             <option value="Free Size">Free Size</option>
                             <option value="28">28</option>
                             <option value="30">30</option>
                             <option value="32">32</option>
                             <option value="34">34</option>
                             <option value="36">36</option>
                             <option value="38">38</option>
                             <option value="40">40</option>
                             <option value="42">42</option>
                             <option value="Onesize">Onesize</option>
                             <option value="UK3">UK3</option>
                             <option value="UK4">UK4</option>
                             <option value="UK5">UK5</option>
                             <option value="UK6">UK6</option>
                             <option value="UK7">UK7</option>
                             <option value="UK8">UK8</option>
                             <option value="UK9">UK9</option>
                             <option value="UK10">UK10</option>
                             <option value="UK11">UK11</option>
                             <option value="1 – 1.5 years">1 – 1.5 years</option>
                             <option value="2 – 2.5 years">2 – 2.5 years</option>
                             <option value="3 – 3.5 years">3 – 3.5 years</option>
                             <option value="4 – 4.5 years">4 – 4.5 years</option>
                             <option value="5 – 5.5 years">5 – 5.5 years</option>
                             <option value="6 – 7 years">6 – 7 years</option>
                             <option value="8 – 9 years">8 – 9 years</option>
                             <option value="10 – 11 years">10 – 11 years</option>
                             <option value="12 – 13 years">12 – 13 years</option>
                             <!-- Mobile / Tablet Screen Sizes (inches) -->
                              <option value="4.0 inch">4.0 inch</option>
                              <option value="4.5 inch">4.5 inch</option>
                              <option value="5.0 inch">5.0 inch</option>
                              <option value="5.5 inch">5.5 inch</option>
                              <option value="6.0 inch">6.0 inch</option>
                              <option value="6.1 inch">6.1 inch</option>
                              <option value="6.2 inch">6.2 inch</option>
                              <option value="6.5 inch">6.5 inch</option>
                              <option value="6.7 inch">6.7 inch</option>
                              <option value="6.8 inch">6.8 inch</option>
                              <option value="7.0 inch">7.0 inch</option>
                              <option value="7.5 inch">7.5 inch</option>
                              <option value="8.0 inch">8.0 inch</option>
                              <option value="8.5 inch">8.5 inch</option>
                              <option value="9.0 inch">9.0 inch</option>
                              <option value="10.0 inch">10.0 inch</option>
                              <option value="10.5 inch">10.5 inch</option>
                              <option value="11.0 inch">11.0 inch</option>
                              <option value="12.0 inch">12.0 inch</option>
                      </select>
                    </div>

                    <div class="col-sm-4">
                        <span class="btn btn-danger" style="float: right;" onclick="remove_row(' . $id . ')" >Remove</span>
                    </div>
                </div><br></div>

                 <div id="add_more_' . $id . '">
                   <div class="row" style="margin-left: 10px;"> 
                    <button type="button" class="btn btn-info pull-right" onclick="addMoreProd(' . ($id + 1) . ');">Add More</button>
                  </div><br> 
              </div>';

    echo $html;
    exit;
  }

  public function delete_dynamic_field()
  {
    $id = $this->input->post('id');

    if (!empty($id))
    {
      $this->db->where('id', $id);
      $delete = $this->db->delete('product_extra_fields');

      if ($delete)
      {
        echo 'success';
      } else
      {
        echo 'error';
      }
    } else
    {
      echo 'error';
    }
  }



}
