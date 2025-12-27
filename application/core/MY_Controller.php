<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
        $this->load->library('pagination');
    }

    /**
     * Reusable pagination method
     * @param string $base_url
     * @param int $total_rows
     * @param int $per_page
     * @param int $uri_segment
     * @return array
     */
    protected function setup_pagination($base_url, $total_rows, $per_page = 10, $uri_segment = 3) 
    {
        $config = [
            'base_url' => $base_url,
            'total_rows' => $total_rows,
            'per_page' => $per_page,
            'uri_segment' => $uri_segment,
            'use_page_numbers' => TRUE,
            'full_tag_open' => '<nav><ul class="pagination justify-content-center">',
            'full_tag_close' => '</ul></nav>',
            'first_link' => '&laquo;',
            'last_link' => '&raquo;',
            'first_tag_open' => '<li class="page-item">',
            'first_tag_close' => '</li>',
            'prev_link' => '&lsaquo;',
            'prev_tag_open' => '<li class="page-item">',
            'prev_tag_close' => '</li>',
            'next_link' => '&rsaquo;',
            'next_tag_open' => '<li class="page-item">',
            'next_tag_close' => '</li>',
            'last_tag_open' => '<li class="page-item">',
            'last_tag_close' => '</li>',
            'cur_tag_open' => '<li class="page-item active"><a class="page-link">',
            'cur_tag_close' => '</a></li>',
            'num_tag_open' => '<li class="page-item">',
            'num_tag_close' => '</li>',
            'attributes' => ['class' => 'page-link']
        ];

        $this->pagination->initialize($config);

        $page = ($this->uri->segment($uri_segment)) ? $this->uri->segment($uri_segment) : 1;
        $offset = ($page - 1) * $per_page;

        return [
            'pagination_links' => $this->pagination->create_links(),
            'offset' => $offset,
            'per_page' => $per_page,
            'current_page' => $page
        ];
    }
}
