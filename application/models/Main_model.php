<?php date_default_timezone_set('Asia/Kolkata');

class Main_model extends CI_model
{
    public function get_products($limit, $offset, $search = '')
    {
        if ($search) {
            $this->db->group_start()
                ->like('product_name', $search)
                ->or_like('category', $search)
                ->group_end();
        }

        return $this->db
            ->where('deleted_at', NULL)
            ->limit($limit, $offset)
            ->order_by('id', 'DESC')
            ->get('products')
            ->result();
    }

    public function count_products($search = '')
    {
        if ($search) {
            $this->db->group_start()
                ->like('product_name', $search)
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
}
