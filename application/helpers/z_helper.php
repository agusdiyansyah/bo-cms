<?php
function notification_proses($type="success",$title="Berhasil", $msg = "Berhasil", $template="adminLTE"){
    if ($template == "adminLTE") {
        $html = '
        <div class="alert alert-'.$type.' alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> '.$title.'</h4>
            '.$msg.'
        </div>';
    }
    return $html;
}
function combobox_dynamic($name,$table,$field,$pk,$selected="",$placeholder="::Pilih Data::",$class="form-control"){
    $ci = get_instance();
    $cmb = "<select name='$name' id='$name' class='$class $name'>";
    $cmb .= "<option value=''>".$placeholder."</option>";
    if (is_object($table)) {
        $data = $table->result();
    }
    else {
        $data = $ci->db->order_by($field, 'asc');
        $data = $ci->db->get($table)->result();
    }
    foreach ($data as $d){
        $cmb .="<option value='".$d->$pk."'";
        $cmb .= $selected==$d->$pk?" selected='selected'":'';
        $cmb .=">".$d->$field."</option>";
    }
    $cmb .="</select>";
    return $cmb;
}
function combobox_category($id_type, $selected="", $name="id_category", $class="form-control"){
    $ci =& get_instance();
    $cmb = "<select name='$name' id='$name' class='$class $name'>";
    $cmb .= "<option value=''>Pilih Kategori</option>";
    $data = $ci->db->where('id_type', $id_type);
    $data = $ci->db->get('category')->result();
    foreach ($data as $d){
        $cmb .="<option value='".$d->id_category."'";
        $cmb .= $selected==$d->id_category?" selected='selected'":'';
        $cmb .=">".$d->category."</option>";
    }
    $cmb .="</select>";
    return $cmb;
}
function indoDateFormat ($waktu="", $format="") {
    //{tanggalIndoTiga tgl=0000-00-00 00:00:00 format="l, d/m/Y H:i:s"}
    if ($waktu != "" || $format != "") {
        if($waktu == "0000-00-00" || !$waktu || $waktu == "0000-00-00 00:00:00") {
            $rep = "";
        } else {
            if(preg_match('/-/', $waktu)) {
                $tahun = substr($waktu,0,4);
                $bulan = substr($waktu,5,2);
                $tanggal = substr($waktu,8,2);
            } else {
                $tahun = substr($waktu,0,4);
                $bulan = substr($waktu,4,2);
                $tanggal = substr($waktu,6,2);
            }
            $jam = substr($waktu,11,2);
            $menit= substr($waktu,14,2);
            $detik = substr($waktu,17,2);
            $hari_en = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
            $hari_id = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu");
            $bulan_en = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            $bulan_id = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
            $ret = @date($format, @mktime($jam, $menit, $detik, $bulan, $tanggal, $tahun));
            $replace_hari = str_replace($hari_en, $hari_id, $ret);
            $rep = str_replace($bulan_en, $bulan_id, $replace_hari);
            $rep = nl2br($rep);
        }
        return $rep;
    }
}
function masa_kerja($datestart, $dateend)
{
    $datestart = new DateTime($datestart);
    $dateend = new DateTime($dateend);
    $interval = $dateend->diff($datestart);
    $format = $interval->format('%y|%m');
    $explode = explode("|", $format);
    $masa_kerja['tahun'] = $explode[0];
    $masa_kerja['bulan'] = $explode[1];
    return $masa_kerja;
}
function format_duit($xx) {
    if (empty($xx)){
        return $xx;
    }else {
        $x = trim($xx);
        $b = number_format($x, 0, ",", ".");
        return $b;
    }
}
function form_select ($option = array()) {

    $hasil = "";

    if (count($option) > 0) {
        $conf = @$option['config'];
        $list = @$option['list'];
        $selected = @$option['selected'];
        $extra = @$option['extra'];

        $hasil = form_dropdown($conf, $list, $selected, $extra);
    }

    return $hasil;
}
function _id () {
    return md5(uniqid(rand(), true));
}
function webinfo()
{
    $return = array();
    $CI =& get_instance();
    $q = $CI->db
            ->select("label, value")
            ->where("tipe", "web_info")
            ->get('meta');
    foreach ($q->result() as $r) {
        $return[$r->label] = $r->value;
    }
    return $return;
}