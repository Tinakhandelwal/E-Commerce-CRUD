<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
  use SoftDeletes;

  protected $table = 'categories';
  public $timestamps = true;
  protected $fillable = ['parent_id', 'name', 'created_at'];

    public function getcategory(){
        $categories = \DB::table('categories')->where("parent_id", 0)->get()->toArray();
        $i=0;
        foreach($categories as $main_cat){
            $categories[$i]->sub = $this->sub_category($main_cat->id);
            $i++;
        }
        return $categories;
    }

    public function sub_category($ids){
        $categories = \DB::table('categories')->where("parent_id", $ids)->get()->toArray();
        $i=0;
        foreach($categories as $sub_cat){
            $categories[$i]->sub = $this->sub_category($sub_cat->id);
            
            $i++;
        }
        return $categories;       
    }
}
