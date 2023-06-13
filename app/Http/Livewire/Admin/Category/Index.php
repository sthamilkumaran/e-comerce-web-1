<?php

namespace App\Http\Livewire\Admin\Category;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $cate_gories, $name, $slug, $image, $descripition, $meta_title, $meta_keyword, $meta_descripition, $category_id, $status;

    protected $listeners = [
        'deleteCategory'=>'destroy'
    ];
    // Validation Rules
    protected $rules = [
        'name'=>'required',
        'slug'=>'required',
        'image'=>'required',
        'descripition'=>'required',
        'meta_title'=>'required',
        'meta_keyword'=>'required',
        'meta_descripition'=>'required',
    ];

    public function resetFields(){
        $this->name = '';
        $this->slug = '';
        $this->descripition = '';
        $this->image = '';
        $this->meta_title = '';
        $this->meta_keyword = '';
        $this->meta_descripition = '';
        $this->status = '';
    }
    public function edit($id){
        $categories = Category::findOrFail($id);
        $this->name = $categories->name;
        $this->slug = $categories->slug;
        // $this->image = $categories->image;
        $this->descripition = $categories->descripition;
        $this->status = $categories->status;
        $this->meta_title = $categories->meta_title;
        $this->meta_keyword = $categories->meta_keyword;
        $this->meta_descripition = $categories->meta_descripition;
        $this->category_id = $categories->id;

    }
    public function cancel()    {

        $this->resetFields();
    }
    public function update(){
        // Validate request
        $this->validate();
        try{
            // Update category
            Category::find($this->category_id)->fill([
                'name'=>$this->name,
                'slug'=>$this->slug,
                'image'=>$this->image,
                'descripition'=>$this->descripition,
                'status'=>$this->status,
                'meta_title'=>$this->description,
                'meta_keyword'=>$this->meta_keyword,
                'meta_descripition'=>$this->meta_descripition,
            ])->save();
            session()->flash('success','Category Updated Successfully!!');

            $this->cancel();
        }catch(\Exception $e){
            session()->flash('error','Something goes wrong while updating category!!');
            $this->cancel();
        }
    }
    // public function destroy($id){
    //     try{
    //         Categories::find($id)->delete();
    //         session()->flash('success',"Category Deleted Successfully!!");
    //     }catch(\Exception $e){
    //         session()->flash('error',"Something goes wrong while deleting category!!");
    //     }
    // }
    public function render()
    {
        // $this->cate_gories = Category::select('id','slug','descripition','image','meta_title','meta_keyword','meta_descripition','status')->get();
        $categories = Category::orderBy('id','DESC')->paginate(2);
        return view('livewire.admin.category.index',['categories' => $categories]);
    }
}
