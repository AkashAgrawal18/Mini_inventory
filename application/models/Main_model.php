<?php date_default_timezone_set('Asia/Kolkata');

class Main_model extends CI_model
{
    public function get_products($limit, $offset, $search = '', $type = '')
    {
        if ($search) {
            $this->db->group_start()
                ->like('product_code', $search)
                ->or_like('product_name', $search)
                ->or_like('category', $search)
                ->group_end();
        }
        if ($type == 'active') {
            $this->db->where('deleted_at', NULL);
        } else if ($type == 'deleted') {
            $this->db->where('deleted_at IS NOT NULL', null, false);
        }

        return $this->db->limit($limit, $offset)
            ->order_by('id', 'DESC')
            ->get('products')
            ->result();
    }

    public function count_products($search = '', $type = '')
    {
        if ($search) {
            $this->db->group_start()
                ->like('product_code', $search)
                ->or_like('product_name', $search)
                ->or_like('category', $search)
                ->group_end();
        }

        return $this->db
            ->where('deleted_at', NULL)
            ->count_all_results('products');
    }

    public function insert_product($data)
    {
        unset($data['id']);
        return $this->db->insert('products', $data);
    }

    public function update_product($id, $data)
    {
        unset($data['id']);
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->where('id', $id)->update('products', $data);
    }

    public function delete_product($id)
    {
        return $this->db->where('id', $id)
            ->update('products', ['deleted_at' => date('Y-m-d H:i:s')]);
    }

    public function check_product_code($product_code, $id = null)
    {
        $this->db->where('product_code', $product_code);

        if (!empty($id)) {
            $this->db->where('id !=', $id); // edit case
        }

        return $this->db->get('products')->row();
    }

    public function get_deleted_products()
    {
        return $this->db
            ->where('deleted_at IS NOT NULL', null, false)
            ->get('products')
            ->result();
    }

    public function restore_product($id)
    {
        return $this->db
            ->where('id', $id)
            ->update('products', [
                'deleted_at' => NULL,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
    }
}
