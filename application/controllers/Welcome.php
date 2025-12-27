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
    $type   = $this->input->get('type');
    $limit = 5;
    $offset = ($page) ? ($page - 1) * $limit : 0;

    $total = $this->Main_model->count_products($search,$type);

    $pagination_data = $this->setup_pagination(
      site_url('Master/products_list'),
      $total,
      20,
      3
    );

    $data = [
      'products' => $this->Main_model->get_products($limit, $offset, $search,$type),
      'pagination' => $pagination_data['pagination_links'],
    ];

    echo json_encode($data);
  }


  public function save_product()
  {
    $data = $this->input->post();

    if (empty($data['product_name']) || empty($data['product_code']) || !is_numeric($data['price'])) {
      echo json_encode([
        'status' => false,
        'message' => 'Invalid input data'
      ]);
      return;
    }

    $existing = $this->Main_model->check_product_code($data['product_code'], $data['id'] ?? null);

    if ($existing) {

      if (!empty($existing->deleted_at)) {
        echo json_encode([
          'status' => false,
          'message' => 'This product code exists but the product is deleted. Please restore it or use another code.'
        ]);
        return;
      }
      echo json_encode([
        'status' => false,
        'message' => 'Product code already exists. Please use a unique product code.'
      ]);
      return;
    }

    if (!empty($data['id'])) {
      if ($this->Main_model->update_product($data['id'], $data)) {
        $msg = 'Product updated successfully';
      } else {
        $msg = 'Filed to update Product';
      }
    } else {
      if ($this->Main_model->insert_product($data)) {
        $msg = 'Product added successfully';
      } else {
        $msg = 'Filed to add Product';
      }
    }

    echo json_encode([
      'status' => true,
      'message' => $msg
    ]);
  }

  public function delete_product($id)
  {
    if (empty($id)) {
      echo json_encode([
        'status' => false,
        'message' => 'Invalid product ID'
      ]);
      return;
    }

    $deleted = $this->Main_model->delete_product($id);

    if ($deleted) {
      echo json_encode([
        'status' => true,
        'message' => 'Product deleted successfully'
      ]);
    } else {
      echo json_encode([
        'status' => false,
        'message' => 'Unable to delete product'
      ]);
    }
  }

  public function restore_product($id)
  {
    if (empty($id)) {
      echo json_encode([
        'status' => false,
        'message' => 'Invalid product ID'
      ]);
      return;
    }

    if ($this->Main_model->restore_product($id)) {
      echo json_encode([
        'status' => true,
        'message' => 'Product restored successfully'
      ]);
    } else {
      echo json_encode([
        'status' => false,
        'message' => 'Failed to restore product'
      ]);
    }
  }
}
