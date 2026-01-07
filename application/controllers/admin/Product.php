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
    // $vendor_id = 11; // Replace this with the actual vendor_id

    // $this->db->select('sub_product_master.*');
// $this->db->from('shop_master');
// $this->db->join('sub_product_master', 'shop_master.id = sub_product_master.shop_id');
// $this->db->where('shop_master.vendor_id', $id);

    $this->db->select('sub_product_master.*, shop_master.bussiness_name, parent_category_master.name, category_master.category_name, sub_category_master.sub_category_name');
    $this->db->from('shop_master');
    $this->db->join('sub_product_master', 'shop_master.id = sub_product_master.shop_id');
    // $this->db->join('brand_master', 'sub_product_master.brand_id = brand_master.id', 'left');
    $this->db->join('parent_category_master', 'sub_product_master.parent_category_id = parent_category_master.id', 'left');
    $this->db->join('category_master', 'sub_product_master.category_id = category_master.id', 'left');
    $this->db->join('sub_category_master', 'sub_product_master.sub_category_id = sub_category_master.id', 'left');
    $this->db->where('shop_master.vendor_id', $id);
    $this->db->where('sub_product_master.status', 1);

    $data['getData'] = $this->db->get()->result_array();

    // echo json_encode($data);
    $this->load->view('include/header', array('index' => 'product'));
    $this->load->view('Product/AllProductListVendor', $data);
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

    // Base query
    $this->db->from('sub_product_master');
    $this->db->select('size, color, id, shop_id, sub_category_id, product_code, sku_code, product_name, price, final_price, quantity, verify_status');

    if ($adminData['Type'] === '1')
    {
      // Super Admin
      if (!empty($vendor_id))
      {
        $shops = $this->db->get_where('shop_master', ['vendor_id' => $vendor_id])->result_array();
        $shop_array = array_column($shops, 'id');
        if (!empty($shop_array))
        {
          $this->db->where_in('shop_id', $shop_array);
        } else
        {
          // If vendor has no shops, return empty
          $this->db->where('id', 0);
        }
      }

      if (!empty($shop_id))
      {
        $this->db->where('shop_id', $shop_id);
      }

      if (!empty($keywords))
      {
        $this->db->like('product_name', $keywords);
      }

    } else
    {
      // Vendor/Admin Type 2
      $this->db->where('added_type', '2');
      $this->db->where('addedBy', $adminData['Id']);

      if (!empty($shop_id))
      {
        $this->db->where('shop_id', $shop_id);
      }
    }

    // Get total count
    $totalRecords = $this->db->count_all_results('', false); // false keeps the query

    // Apply order and limit for pagination
    $this->db->order_by('id', 'desc');
    $this->db->limit($limit, $offset);
    $AllRecord = $this->db->get()->result_array();

    $entries = 'Showing ' . ($offset + 1) . ' to ' . ($offset + count($AllRecord)) . ' of ' . $totalRecords . ' entries';

    // Pagination config
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

    // Shop & Vendor lists
    if ($adminData['Type'] == '1')
    {
      $data['shopList'] = $this->db->get_where('shop_master', ['status' => '1'])->result_array();
    } else
    {
      $data['shopList'] = $this->db->get_where('shop_master', ['status' => '1', 'type' => '2', 'addedBy' => $adminData['Id']])->result_array();
    }
    $data['vendorList'] = $this->db->get_where('staff_master', ['status' => '1'])->result_array();

    // Pass data to view
    $data += [
      'totalResult' => $totalRecords,
      'shop_id' => $shop_id,
      'vendor_id' => $vendor_id,
      'results' => $AllRecord,
      'pano' => $pageNo,
      'links' => $links,
      'index2' => '',
      'v_id' => '',
      'index' => 'Product',
      'entries' => $entries,
      'title' => 'Manage Products'
    ];

    $this->load->view('include/header', $data);
    $this->load->view('Product/ProductList', $data);
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

  public function final_submit()
  {
    $adminData = $this->session->userdata('adminData');
    $data = $this->input->post();
    //echo "<pre>";print_r($data);exit();
    $basic_info = $this->db->get_where('tab_general_information', array('type' => '1'))->row_array();

    $this->db->select('mai_id');
    $parent = $this->db->get_where('category_master', array('id' => $basic_info['category_id']))->row_array();


    $sizeArray = $this->db->get_where('tab_color_size_master', array('type' => '1'))->result_array();

    $str = preg_replace('/\D/', '', $basic_info['sku_code']);


    foreach ($sizeArray as $key => $value)
    {

      $image_info = $this->db->get_where('tab_color_master', array('color' => $value['color']))->row_array();

      $common['sku_code'] = $basic_info['sku_code'];
      $common['color_code'] = $str . '_' . $basic_info['shop_id'] . '_' . $value['color'];
      $common['shop_id'] = $basic_info['shop_id'];
      $common['parent_category_id'] = $basic_info['parent_id'];
      $common['category_id'] = $basic_info['category_id'];
      $common['sub_category_id'] = $basic_info['sub_category_id'];
      $common['product_name'] = $basic_info['product_name'];
      $common['weight'] = $basic_info['weight'];
      $common['packet_length'] = $basic_info['packet_length'];
      $common['packet_weight'] = $basic_info['packet_weight'];
      $common['packet_height'] = $basic_info['packet_height'];
      $common['product_code'] = $str . '_' . $basic_info['shop_id'];



      $common['product_description'] = $basic_info['product_description'];
      ;
      $common['brand'] = $data['brand'];
      //$common['sleev_length']              = $data['sleev_length'];
      //$common['neckline']                  = $data['neckline'];
      //$common['prints_patterns']           = $data['prints_patterns'];
      //$common['blouse_piece']              = $data['blouse_piece'];
      $common['occasion'] = $data['occasion'];
      //$common['combo']                     = $data['combo'];
      $common['fit'] = $data['fit'];
      //$common['collor']                    = $data['collor'];
      $common['fabric'] = $data['fabric'];
      //$common['fabric_care']               = $data['fabric_care'];
      $common['pack_of'] = $data['pack_of'];
      //$common['type']                      = $data['type'];
      //$common['style']                     = $data['style'];
      $common['length'] = $data['length'];
      //$common['art_work']                  = $data['art_work'];
      //$common['stretchable']               = $data['stretchable'];
      //$common['back_type']                 = $data['back_type'];
      $common['ideal_for'] = $data['ideal_for'];
      //$common['highlights']                = $data['highlights'];
      $common['product_hsn'] = $data['product_hsn'];
      //$common['country']                   = $data['country'];
      //$common['style_code']                = $data['style_code'];



      //$common['closer']                     = $data['closer'];
      //$common['boot_height']                = $data['boot_height'];
      //$common['heel_type']                  = $data['heel_type'];
      //$common['heel_height']                = $data['heel_height'];
      //$common['toe_shap']                   = $data['toe_shap'];
      //$common['upper_material']             = $data['upper_material'];
      //$common['sole_material']              = $data['sole_material'];
      //$common['inner_material']             = $data['inner_material'];
      //$common['shoes_type']                 = $data['shoes_type'];



      $common['color'] = $value['color'];
      $common['price'] = $value['price'];
      $common['final_price'] = $value['final_price'];
      $common['quantity'] = $value['qty'];
      $common['size'] = $value['size'];
      $common['gst'] = $value['gst'];

      $common['main_image'] = $image_info['main_image'];
      $common['image1'] = $image_info['image1'];
      $common['image2'] = $image_info['image2'];
      $common['image3'] = $image_info['image3'];
      $common['image4'] = $image_info['image4'];
      $common['image5'] = $image_info['image5'];
      $common['status'] = '2';
      $common['verify_status'] = '2';
      $common['pro_description'] = $data['pro_description'];
      ;
      if ($adminData['Type'] == '1')
      {

        $common['added_type'] = '1';
        $common['addedBy'] = '1';

      } else
      {

        $common['added_type'] = '2';
        $common['addedBy'] = $adminData['Id'];
      }


      $this->db->insert('sub_product_master', $common);


    }
    $this->db->where_not_in('id', '5555555555555555555555');
    $this->db->delete('tab_color_master');
    $this->db->where_not_in('id', '5555555555555555555555');
    $this->db->delete('tab_color_size_master');
    $this->db->where_not_in('id', '5555555555555555555555');
    $this->db->delete('tab_general_information');
    $this->db->where_not_in('id', '5555555555555555555555');
    $this->db->delete('tab_size_master');

    $this->session->set_flashdata('activate', getCustomAlert('S', 'Product  added successfully.'));
    redirect('admin/Product');

  }



  public function final_submit2($id)
  {

    $data = $this->input->post();

    $basic_info = $this->db->get_where('tab_general_information', array('product_id' => $id))->row_array();

    $this->db->select('mai_id');
    $parent = $this->db->get_where('category_master', array('id' => $basic_info['category_id']))->row_array();


    $sizeArray = $this->db->get_where('tab_color_size_master', array('product_id' => $id))->result_array();
    $str = preg_replace('/\D/', '', $basic_info['sku_code']);



    foreach ($sizeArray as $key => $value)
    {

      $image_info = $this->db->get_where('tab_color_master', array('color' => $value['color'], 'product_id' => $id))->row_array();

      $common['sku_code'] = $basic_info['sku_code'];
      $common['color_code'] = $str . '_' . $basic_info['shop_id'] . '_' . $value['color'];
      $common['shop_id'] = $basic_info['shop_id'];
      $common['parent_category_id'] = $basic_info['parent_id'];
      $common['category_id'] = $basic_info['category_id'];
      $common['sub_category_id'] = $basic_info['sub_category_id'];
      $common['product_name'] = $basic_info['product_name'];
      $common['weight'] = $basic_info['weight'];
      $common['packet_length'] = $basic_info['packet_length'];
      $common['packet_weight'] = $basic_info['packet_weight'];
      $common['packet_height'] = $basic_info['packet_height'];
      $common['product_code'] = $str . '_' . $basic_info['shop_id'];




      $common['product_description'] = $basic_info['product_description'];
      ;
      $common['brand'] = @$data['brand'];
      // $common['sleev_length']              = @$data['sleev_length'];
      // $common['neckline']                  = @$data['neckline'];
      // $common['prints_patterns']           = @$data['prints_patterns'];
      // $common['blouse_piece']              = @$data['blouse_piece'];
      $common['occasion'] = @$data['occasion'];
      // $common['combo']                     = @$data['combo'];
      $common['fit'] = @$data['fit'];
      // $common['collor']                    = @$data['collor'];
      $common['fabric'] = @$data['fabric'];
      // $common['fabric_care']               = @$data['fabric_care'];
      $common['pack_of'] = @$data['pack_of'];
      // $common['type']                      = @$data['type'];
      // $common['style']                     = @$data['style'];
      $common['length'] = @$data['length'];
      // $common['art_work']                  = @$data['art_work'];
      // $common['stretchable']               = @$data['stretchable'];
      // $common['back_type']                 = @$data['back_type'];
      $common['ideal_for'] = @$data['ideal_for'];
      // $common['highlights']                = @$data['highlights'];
      $common['product_hsn'] = @$data['product_hsn'];
      // $common['country']                   = @$data['country'];
      // $common['style_code']                = @$data['style_code'];

      // $common['closer']                    = @$data['closer'];
      // $common['boot_height']               = @$data['boot_height'];
      // $common['heel_type']                 = @$data['heel_type'];
      // $common['heel_height']               = @$data['heel_height'];
      // $common['toe_shap']                  = @$data['toe_shap'];
      //  $common['upper_material']            = @$data['upper_material'];
      //  $common['sole_material']             = @$data['sole_material'];
      //  $common['inner_material']            = @$data['inner_material'];
      //  $common['shoes_type']                = @$data['shoes_type'];
      $common['pro_description'] = @$data['pro_description'];

      $common['color'] = $value['color'];
      $common['price'] = $value['price'];
      $common['final_price'] = $value['final_price'];
      $common['quantity'] = $value['qty'];
      $common['size'] = $value['size'];
      $common['gst'] = $value['gst'];
      $common['main_image'] = $image_info['main_image'];
      $common['image1'] = $image_info['image1'];
      $common['image2'] = $image_info['image2'];
      $common['image3'] = $image_info['image3'];
      $common['image4'] = $image_info['image4'];
      $common['image5'] = $image_info['image5'];

      //echo "<pre>";print_r($common);exit();

      $common['status'] = '3';
      $common['verify_status'] = '2';

      $this->db->where('id', $value['pro_id']);
      $this->db->update('sub_product_master', $common);


    }

    $this->db->where_not_in('id', '5555555555555555555555');
    $this->db->delete('tab_color_master');

    $this->db->where_not_in('id', '5555555555555555555555');
    $this->db->delete('tab_color_size_master');

    $this->db->where_not_in('id', '5555555555555555555555');
    $this->db->delete('tab_general_information');

    $this->db->where_not_in('id', '5555555555555555555555');
    $this->db->delete('tab_size_master');

    $this->session->set_flashdata('activate', getCustomAlert('S', 'Product  Update successfully.'));
    redirect('admin/Product');

  }




  public function AddProduct()
  {
    $tab = @$_GET['tab'];
    if (empty($tab))
    {
      $this->db->where_not_in('id', '5555555555555555555555');
      $this->db->delete('tab_color_master');
      $this->db->where_not_in('id', '5555555555555555555555');
      $this->db->delete('tab_color_size_master');
      $this->db->where_not_in('id', '5555555555555555555555');
      $this->db->delete('tab_general_information');
      $this->db->where_not_in('id', '5555555555555555555555');
      $this->db->delete('tab_size_master');
    }


    $data = $this->input->post();
    $adminData = $this->session->userdata('adminData');

    if (empty($data))
    {

      $data['index'] = 'AddProduct';
      $data['index2'] = '';
      $data['title'] = 'Manage Product';
      $data['getParCatgy'] = $this->Product_model->getParCatgyList();
      $data['getCatgy'] = $this->Product_model->getCatgyList();
      $data['getBasicInfo'] = $this->Product_model->getBasicInfo();
      $data['getSizeColor'] = $this->Product_model->getSizeColor();
      $data['unit'] = $this->Product_model->GetUnit();

      if ($adminData['Type'] == '1')
      {
        $data['shopList'] = $this->db->get_where('shop_master', array('status' => '1'))->result_array();
      } else
      {
        $data['shopList'] = $this->db->get_where('shop_master', array('status' => '1', 'type' => '2', 'addedBy' => $adminData['Id']))->result_array();
      }

      $this->load->view('include/header', $data);
      $this->load->view('Product/AddProduct');
      $this->load->view('include/footer');


    } else
    {

      $fileName = $_FILES["thumbnail"]["name"];
      $extension = explode('.', $fileName);
      $extension = strtolower(end($extension));
      $uniqueName = 'Product_' . uniqid() . '.' . $extension;
      $type = $_FILES["thumbnail"]["type"];
      $size = $_FILES["thumbnail"]["size"];
      $tmp_name = $_FILES['thumbnail']['tmp_name'];
      $targetlocation = PRODUCT_DIRECTORY . $uniqueName;
      if (!empty($fileName))
      {
        move_uploaded_file($tmp_name, $targetlocation);
        $data['main_image'] = utf8_encode(trim($uniqueName));
      }


      $fileName = $_FILES["image1"]["name"];
      $extension = explode('.', $fileName);
      $extension = strtolower(end($extension));
      $uniqueName = 'Product_' . uniqid() . '.' . $extension;
      $type = $_FILES["image1"]["type"];
      $size = $_FILES["image1"]["size"];
      $tmp_name = $_FILES['image1']['tmp_name'];
      $targetlocation = PRODUCT_DIRECTORY . $uniqueName;
      if (!empty($fileName))
      {
        move_uploaded_file($tmp_name, $targetlocation);
        $data['image1'] = utf8_encode(trim($uniqueName));
      }


      $fileName = $_FILES["image2"]["name"];
      $extension = explode('.', $fileName);
      $extension = strtolower(end($extension));
      $uniqueName = 'Product_' . uniqid() . '.' . $extension;
      $type = $_FILES["image2"]["type"];
      $size = $_FILES["image2"]["size"];
      $tmp_name = $_FILES['image2']['tmp_name'];
      $targetlocation = PRODUCT_DIRECTORY . $uniqueName;
      if (!empty($fileName))
      {
        move_uploaded_file($tmp_name, $targetlocation);
        $data['image2'] = utf8_encode(trim($uniqueName));
      }


      $fileName = $_FILES["image3"]["name"];
      $extension = explode('.', $fileName);
      $extension = strtolower(end($extension));
      $uniqueName = 'Product_' . uniqid() . '.' . $extension;
      $type = $_FILES["image3"]["type"];
      $size = $_FILES["image3"]["size"];
      $tmp_name = $_FILES['image3']['tmp_name'];
      $targetlocation = PRODUCT_DIRECTORY . $uniqueName;
      if (!empty($fileName))
      {
        move_uploaded_file($tmp_name, $targetlocation);
        $data['image3'] = utf8_encode(trim($uniqueName));
      }

      $fileName = $_FILES["image4"]["name"];
      $extension = explode('.', $fileName);
      $extension = strtolower(end($extension));
      $uniqueName = 'Product_' . uniqid() . '.' . $extension;
      $type = $_FILES["image4"]["type"];
      $size = $_FILES["image4"]["size"];
      $tmp_name = $_FILES['image4']['tmp_name'];
      $targetlocation = PRODUCT_DIRECTORY . $uniqueName;
      if (!empty($fileName))
      {
        move_uploaded_file($tmp_name, $targetlocation);
        $data['image4'] = utf8_encode(trim($uniqueName));
      }

      $fields['product_name'] = $data['product_name'];
      $fields['product_description'] = $data['product_description'];
      $fields['price'] = $data['price'];
      $fields['final_price'] = $data['final_price'];
      $fields['quantity'] = $data['quantity'];
      $fields['size'] = $data['size'];
      $fields['color'] = $data['color'];
      $fields['sleev_length'] = $data['sleev_length'];
      $fields['brand'] = $data['brand'];
      $fields['neckline'] = $data['neckline'];
      $fields['prints_patterns'] = $data['prints_patterns'];
      $fields['blouse_piece'] = $data['blouse_piece'];
      $fields['occasion'] = $data['occasion'];
      $fields['combo'] = $data['combo'];
      $fields['fit'] = $data['fit'];
      $fields['collor'] = $data['collor'];
      $fields['fabric'] = $data['fabric'];
      $fields['fabric_care'] = $data['fabric_care'];
      $fields['pack_of'] = $data['pack_of'];
      $fields['type'] = $data['type'];

      $fields['style'] = $data['style'];
      $fields['length'] = $data['length'];
      $fields['art_work'] = $data['art_work'];
      $fields['stretchable'] = $data['stretchable'];
      $fields['back_type'] = $data['back_type'];
      $fields['ideal_for'] = $data['ideal_for'];
      $fields['generic_name'] = $data['generic_name'];
      $fields['highlights'] = $data['highlights'];
      $fields['weight'] = $data['weight'];
      $fields['dimensional'] = $data['dimensional'];
      $fields['volumetric_weight'] = $data['volumetric_weight'];
      $fields['product_hsn'] = $data['product_hsn'];
      $fields['country'] = $data['country'];
      $fields['style_code'] = $data['style_code'];
      $fields['main_image'] = $data['main_image'];
      $fields['image1'] = $data['image1'];
      $fields['image2'] = $data['image2'];
      $fields['image3'] = $data['image3'];
      $fields['image4'] = $data['image4'];

      if ($adminData['Type'] == '1')
      {

        $fields['verify_status'] = '1';
        $fields['added_type'] = '1';
        $fields['addedBy'] = '1';

      } else
      {

        $fields['verify_status'] = '2';
        $fields['added_type'] = '2';
        $fields['addedBy'] = $adminData['Id'];

      }

      $fields['add_date'] = time();
      $fields['modify_date'] = time();
      $fields['status'] = '3';

      $row = $this->db->insert('product_master', $fields);

      if ($row > 0)
      {
        $this->session->set_flashdata('activate', getCustomAlert('S', ' Product has been add Successfully.'));
        redirect('admin/Product/');
      } else
      {
        $this->session->set_flashdata('activate', getCustomAlert('S', '!Opps Something is worng.Please try again.'));
        redirect('admin/Product/');
      }

      $data['getBasicInfo'] = [
        'mai_id' => $this->input->get('parent_id') ?: '',
        'category_id' => $this->input->get('category_id') ?: '',
        'sub_category_id' => $this->input->get('sub_category_id') ?: ''
      ];

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






  public function UpdateProduct($id = '')
  {

    $this->setUpdataData($id);
    //echo "<pre>";print_r($id);exit();
    $adminData = $this->session->userdata('adminData');

    $data['index'] = 'UpdtProduct';
    $data['index2'] = '';
    $data['title'] = 'Update Product';

    if ($adminData['Type'] == '1')
    {

      $data['shopList'] = $this->db->get_where('shop_master', array('status' => '1'))->result_array();

    } else
    {

      $data['shopList'] = $this->db->get_where('shop_master', array('status' => '1', 'type' => '2', 'addedBy' => $adminData['Id']))->result_array();
    }
    $data['getParCatgy'] = $this->Product_model->getParCatgyList();
    $data['getCatgy'] = $this->Product_model->getCatgyList();
    $data['getBasicInfo'] = $this->Product_model->getBasicInfo1($id);
    $data['getSizeColor'] = $this->Product_model->getSizeColor1($id);
    $data['unit'] = $this->Product_model->GetUnit($id);
    $data['getData'] = $this->db->get_where('sub_product_master', array('id' => $id))->row_array();
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
                       <select class="form-control select2" multiple="" id="related_size' . $id . '" name="size' . ($id - 1) . '[]" style="width: 100%;">
                       <option value="XS">XS</option>
                              <option value="S">S </option>
                              <option value="M">M</option>
                              <option value="L">L</option>
                              <option value="XL">XL </option>
                              <option value="XXL">XXL</option>
                              <option value="3XL">3XL</option>
                              <option value="4XL">4XL</option>
                              <option value="Free Size">Free Size</option>
                              <option value="28">28</option>
                              <option value="30">30 </option>
                              <option value="32">32</option>
                              <option value="34">34</option>
                              <option value="36">36 </option>
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

}
