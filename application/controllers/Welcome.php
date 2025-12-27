<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $this->load->view('product');
  }

      public function get_products()
    {
        $search = $this->input->get('search');
        $page   = $this->input->get('page');

        $limit = 5;
        $offset = ($page) ? ($page - 1) * $limit : 0;

        $total = $this->Main_model->count_products($search);

          $pagination_data = $this->setup_pagination(
            site_url('Master/products_list'),
            $total,
            20,
            3
        );
      
        $data = [
            'products' => $this->Main_model->get_products($limit, $offset, $search),
            'pagination' => $pagination_data['pagination_links'],
        ];

        echo json_encode($data);
    }


  public function save_product()
{
    $data = $this->input->post();

    if (empty($data['product_name']) || !is_numeric($data['price'])) {
        echo json_encode([
            'status' => false,
            'message' => 'Invalid input data'
        ]);
        return;
    }

    if (!empty($data['id'])) {
        $this->Main_model->update_product($data['id'], $data);
        $msg = 'Product updated successfully';
    } else {
        $this->Main_model->insert_product($data);
        $msg = 'Product added successfully';
    }

    echo json_encode([
        'status' => true,
        'message' => $msg
    ]);
}


}
