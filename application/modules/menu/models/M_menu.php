<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_menu extends CI_Model {

	public $table = '';
    public $id = 'id_menu';
    public $order = 'DESC';
	
	protected $M_admin = "";

    public function __construct() {
    	parent::__construct();
		$CI =& get_instance();
		$CI->load->model('Administrator/M_admin');
		$this->M_admin = $CI->M_admin;
		
		$tb = $this->config->load("database_table", true);
        $this->table = $tb['tb_menu_admin'];
    }
    // get all
    public function data($post, $debug = false) {
		$this->db->start_cache();

            // filter
            if (!empty($post['name'])) {
                $this->db->like('name', $post['name'], 'both');
            }
			if (!empty($post['combobox_parent'])) {
				$this->db->where('is_parent', $post['combobox_parent']);
			}

            // order
			$this->db->order_by('is_parent');
			$this->db->order_by('order');
            $this->db->order_by('id_menu', 'DESC');

            // join

        $this->db->stop_cache();

            // get num rows
            $this->db->select('id_menu');
            $rowCount = $this->db->get($this->table)->num_rows();

            // get result
            $this->db->select('m.*, mm.name parent');
			$this->db->from("$this->table m");
			$this->db->join("$this->table mm", 'm.is_parent = mm.id_menu', 'left');
            $this->db->limit($post['length'], $post['start']);

            $val = $this->db->get()->result();

        $this->db->flush_cache();

        $output['draw']            = $post['draw'];
        $output['recordsTotal']    = $rowCount;
        $output['recordsFiltered'] = $rowCount;
		$output['data']            = array();

		if ($debug) {
		    $output['sql']             = $this->db->last_query();
		}

        $no = 1 + $post['start'];

        $base = base_url('menu/admin');
		
		foreach ($val as $data) {

            $btnAksi = "";

            $btnAksi .= "
            <li>
                <a href='{$base}/edit/$data->id_menu' id='btn-edit'>
                    Ubah
                </a>
            </li>
            ";

            $btnAksi .= "
            <li>
                <a href='#' id='btn-hapus' data-id='$data->id_menu'>
                    Hapus
                </a>
            </li>
            ";
			
			$btnAksi .= "
            <li>
                <a href='{$base}/order/up/$data->id_menu' id='btn-edit'>
                    Up
                </a>
            </li>
            ";
			
			$btnAksi .= "
            <li>
                <a href='{$base}/order/down/$data->id_menu' id='btn-edit'>
                    Down
                </a>
            </li>
            ";

            $aksi = "
			<div class='btn-group'>
				<button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
					<i class='fa fa-gear'></i>
				</button>
				<ul class='dropdown-menu pull-right'>
					$btnAksi
				</ul>
			</div>
			";
			
			$icon = ($data->is_parent > 0) ? "" : "<i class='$data->icon'></i>";

            $baris = array(
                $no,
                $aksi,
				$data->name,
				$data->link,
				$icon,
				$data->order,
				$this->isActiveLabel($data->is_active),
				$this->isParentLabel($data->is_parent, $data->parent),
				$this->M_admin->getLevel($data->level)
            );

            array_push($output['data'], $baris);

            $no++;
        }

        return json_encode($output);
    }
	
	protected function isActiveLabel ($val) {
		if ($val == 1) {
			return "Aktif";
		} else {
			return "Non Aktif";
		}
	}
	
	protected function isParentLabel ($val, $parent) {
		if ($val == 0) {
			return "Menu Utama";
		} else {
			return "<b>$parent</b>";
		}
	}
	
	public function getLastOrder ($id_parent = 0) {
		if ($id_parent > 0) {
			$this->db->where("is_parent", $id_parent);
		}
		
		$sql = $this->db
			->select("order")
			->order_by("order", "DESC")
			->get($this->table, 1);
		
		$data = $sql->row();
		
		$order = (empty($data->order)) ? 0 : $data->order;
		
		return $order + 1;
	}

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

    function query_recursive(){
        $levelAccess = $this->session->userdata('level');
        $whereLevel = "menu_admin.level <= ".$levelAccess;
        $string = "select
            menu_admin.*,
            (select count(distinct c1.id_menu) from menu_admin as c1 where c1.is_parent = menu_admin.id_menu) as child
        from menu_admin WHERE menu_admin.is_active = 1 AND ".$whereLevel." ORDER BY menu_admin.order";
        $query = $this->db->query($string);
        return $query;
    }
    function recursive($parent = 0, $level = 0){
        $query = $this->query_recursive();
        $class = ($level == 0) ? "sidebar-menu" : "treeview-menu" ;
        $ret = '<ul class ="'.$class.'">';
        foreach ($query->result() as $menu){
			$class = str_replace(" ", "", $menu->name);
            if($menu->is_parent == $parent)
            {
                $link_name = "<i class='".$menu->icon."'></i><span>".$menu->name."</span>";
                if($menu->child > 0){
                    $link_name .= "<i class='fa fa-angle-left pull-right'></i>";
                    $ret .= "<li class='treeview mn-$class'>".anchor($menu->link, $link_name);
                    $ret .= $this->recursive($menu->id_menu, $level+1);
                }
                else {
                    $ret .= "<li class='mn-$class'>".anchor($menu->link, $link_name);
                }
                $ret .= "</li>";
            }
        }
        return $ret .= "</ul>";
    }
    function getParent(){
        $this->db->where('is_parent', 0);
        $this->db->order_by('order');
        return $this->db->get('menu_admin');
    }
    private function filter()
    {
        $cari_name = $this->session->userdata('Menu_cari_name');
        $cari_parent = $this->session->userdata('Menu_cari_parent');
        if ($cari_name != "") {
            $this->db->like('name', $cari_name, 'both');
        }
        if ($cari_parent) {
            $this->db->where('is_parent', $cari_parent);
        }
    }
}

/* End of file m_menu.php */
/* Location: ./application/modules/menu/models/m_menu.php */
