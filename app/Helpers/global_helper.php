<?php

use App\Models\Admin\MasterAppMenu;

function generatePassword($value)
{
    $length = strlen($value);
    $hidden = "";
    for ($i=0; $i < $length; $i++) { 
        $hidden .= "*";
    }
    return $hidden;
}

function permission($list)
{
    if(in_array(Auth::user()->group_user,$list)) return true;
    return false;
}

function groupText($value)
{
    $group = [1 => "Admin", 2 => "Kepala Pabrik", 3 => "Management", 4 => "Public User", 5 => "Function"];
    return $group[$value] ?? "Belum memiliki hak akses";
}

function isEmpty($value)
{
    return empty(trim($value ?? ""));
}

function getChildrenPermission($value, $firstPermission)
{
    $ret = '';
    if($value != []){
        foreach($value as $val){
            if($val->type == "Folder"){
                $ret .= '<li id="bf_1">';
                $ret .= '<span class="plus">&nbsp;</span>&nbsp;';
                if(in_array(getIdMenuCode($val->code, $val->id), $firstPermission)){
                    $ret .= '<input type="checkbox" id="c_bs_1" name="permission_access[]" value="'.getIdMenuCode($val->code, $val->id).'" selected/>';
                }else{
                    $ret .= '<input type="checkbox" id="c_bs_1" name="permission_access[]" value="'.getIdMenuCode($val->code, $val->id).'"/>';
                }
                $ret .= '<span> &nbsp;&nbsp;'.$val->code.'</span>';
                $ret .= '<ul id="" style="display: show" class="">';
                $ret .= afterPermission($val->children, $firstPermission);
                $ret .= '</ul>';
                $ret .= '</li>';
            }
            
        }
    }
    echo $ret;
}

function afterPermission($value, $firstPermission)
{
    $ret = '';
    if($value != []){
        foreach($value as $val){
            if($val->type == "Folder"){
                $ret .= '<li id="bf_1">';
                $ret .= '<span class="plus">&nbsp;</span>&nbsp;';
                if(in_array(getIdMenuCode($val->code, $val->id), $firstPermission)){
                    $ret .= '<input type="checkbox" id="c_bs_1" name="permission_access[]" value="'.getIdMenuCode($val->code, $val->id).'" selected/>';
                }else{
                    $ret .= '<input type="checkbox" id="c_bs_1" name="permission_access[]" value="'.getIdMenuCode($val->code, $val->id).'"/>';
                }
                $ret .= '<span>&nbsp;&nbsp;&nbsp;'.$val->code.'</span>';
                $ret .= '<ul id="" style="display: show" class="">';
                $ret .= afterPermission($val->children, $firstPermission);
                $ret .= '</ul>';
                $ret .= '</li>';
            }
    }
    }
    return $ret;
}

function getIdMenuCode($code, $id)
{
    $data = MasterAppMenu::where('code', $code.$id)
    ->first();

    if($data){
        return $data->id;
    }else{
        return '-';
    }
}

function formatRupiah($angka)
{
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

?>