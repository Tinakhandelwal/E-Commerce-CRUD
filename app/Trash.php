<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trash extends Model
{
    protected $table = 'trash';
    public $timestamps = true;
    protected $fillable = ['id','parent_id', 'name', 'created_at'];

    public function getcategory($id){
        $categories = \DB::table('trash')->where("parent_id", $id)->get()->toArray();
        $i=0;
        foreach($categories as $main_cat){
            $categories[$i]->sub = $this->sub_category($main_cat->id);
            $i++;
        }
        return $categories;
    }

    public function sub_category($ids){
        $categories = \DB::table('trash')->where("parent_id", $ids)->get()->toArray();
        $i=0;
        foreach($categories as $sub_cat){
            $categories[$i]->sub = $this->sub_category($sub_cat->id);
            
            $i++;
        }
        return $categories;       
    }
}
