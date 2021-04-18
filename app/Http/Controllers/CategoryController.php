<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Trash;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $category = new Category;

        $categories = $category->getcategory();
        // print_r($categories);die();
        return view('projects.index', compact('categories'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Category::create($request->all());

        return redirect()->route('category.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('projects.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('projects.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $category->update($request->all());

        return redirect()->route('category.index')
            ->with('success', 'Product category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $categories = $this->sub_cate($category->id);
        // $categories->delete();

        return redirect()->route('category.index')
            ->with('success', 'Product Category deleted successfully');
    }
    public function sub_cate($ids){
        $categories = \DB::table('categories')->Where("id",$ids)->get()->toArray();
        $i=0;
        foreach($categories as $sub_cat){
            $cat_parentid = $sub_cat->parent_id;
            $categories[$i]->sub = $this->nested_cat($sub_cat->id);
            $trash = new Trash;
            $trash->id = $sub_cat->id;
            $trash->parent_id = $cat_parentid;
            $trash->name = $sub_cat->name;
            $trash->save();
            $i++; 
        }
        $res = \DB::table('categories')->Where("id",$ids)->delete();
        return $categories;       
    }
    public function nested_cat($ids){
        $categories = \DB::table('categories')->Where("parent_id",$ids)->get()->toArray();
        $i=0;
        foreach($categories as $sub_cat){
            $cat_parentid = $sub_cat->parent_id;
            $categories[$i]->sub = $this->nested_cat($sub_cat->id);
            $trash = new Trash;
            $trash->id = $sub_cat->id;
            $trash->parent_id = $cat_parentid;
            $trash->name = $sub_cat->name;
            $trash->save();
            $i++;
        }
        $res = \DB::table('categories')->Where("parent_id",$ids)->delete();
        return $categories;       
    }

    public function getDeleteProjects() 
    {
        $root_id = Trash::min('parent_id');
        $category = new Trash;
        $categories = $category->getcategory($root_id);
        return view('projects.deletedprojects', compact('categories'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function restoreDeletedProjects($id) 
    {
        $categories = $this->trash_sub_cate($id);
        return redirect()->route('category.index')
            ->with('success', 'You successfully restored the Item');
    }

    public function deletePermanently($id)
    {
        $categories = $this->del_trash_sub_cate($id);

        return redirect()->route('category.index')
            ->with('success', 'You successfully deleted the item from the Recycle Bin');
    }
    public function trash_sub_cate($ids){
        $categories = \DB::table('trash')->Where("id",$ids)->get()->toArray();
        $i=0;
        foreach($categories as $sub_cat){
            $cat_parentid = $sub_cat->parent_id;
            $categories[$i]->sub = $this->trash_nested_cat($sub_cat->id);
            $trash = new Category;
            $trash->id = $sub_cat->id;
            $trash->parent_id = $cat_parentid;
            $trash->name = $sub_cat->name;
            $trash->save();
            $i++; 
        }
        $res = \DB::table('trash')->Where("id",$ids)->delete();
        return $categories;       
    }
    public function trash_nested_cat($ids){
        $categories = \DB::table('trash')->Where("parent_id",$ids)->get()->toArray();
        $i=0;
        foreach($categories as $sub_cat){
            $cat_parentid = $sub_cat->parent_id;
            $categories[$i]->sub = $this->trash_nested_cat($sub_cat->id);
            $trash = new Category;
            $trash->id = $sub_cat->id;
            $trash->parent_id = $cat_parentid;
            $trash->name = $sub_cat->name;
            $trash->save();
            $i++;
        }
        $res = \DB::table('trash')->Where("parent_id",$ids)->delete();
        return $categories;       
    }
    public function del_trash_sub_cate($ids){
        $categories = \DB::table('trash')->Where("id",$ids)->get()->toArray();
        $i=0;
        foreach($categories as $sub_cat){
            $categories[$i]->sub = $this->del_trash_nested_cat($sub_cat->id);
            $i++; 
        }
        $res = \DB::table('trash')->Where("id",$ids)->delete();
        return $categories;       
    }
    public function del_trash_nested_cat($ids){
        $categories = \DB::table('trash')->Where("parent_id",$ids)->get()->toArray();
        $i=0;
        foreach($categories as $sub_cat){
            $categories[$i]->sub = $this->del_trash_nested_cat($sub_cat->id);
            $i++;
        }
        $res = \DB::table('trash')->Where("parent_id",$ids)->delete();
        return $categories;       
    }
}
