<?php

namespace App\Http\Livewire\Admin\Category;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public  $name, $slug, $image, $descripition, $meta_title, $meta_keyword, $meta_descripition, $category_id, $status;


    // Validation Rules
    protected $rules = [
        'name'=>'required',
        'slug'=>'required',
        // 'image'=>'required',
        'descripition'=>'required',
        'meta_title'=>'required',
        'meta_keyword'=>'required',
        'meta_descripition'=>'required',
    ];

    public function resetFields(){
        $this->name = '';
        $this->slug = '';
        $this->descripition = '';
        // $this->image = '';
        $this->meta_title = '';
        $this->meta_keyword = '';
        $this->meta_descripition = '';
        // $this->status = '';
    }
    public function edit(int $category_id){
        $category = Category::find($category_id);
        $this->category_id = $category->id;
        $this->name = $category->name;
        $this->slug = $category->slug;
        // $this->image = $categories->image;
        $this->descripition = $category->descripition;
        // $this->status = $category->status;
        $this->meta_title = $category->meta_title;
        $this->meta_keyword = $category->meta_keyword;
        $this->meta_descripition = $category->meta_descripition;


    }
    public function cancel()    {

        $this->resetFields();
    }
    public function update(){
        // Validate request

        try{
            // Update category
            Category::where('id',$this->category_id)->update([
                'name' => $this->name,
                'slug' => $this->slug,
                // 'image'=>$this->image,
                'descripition' => $this->descripition,
                // 'status'=>$this->status,
                'meta_title' => $this->description,
                'meta_keyword' => $this->meta_keyword,
                'meta_descripition' => $this->meta_descripition,
            ]);

            $this->cancel();
        }catch(\Exception $e){
            session()->flash('error','Something goes wrong while updating category!!');
            dd($this->category_id);
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

        $categories = Category::orderBy('id','DESC')->paginate(2);
        return view('livewire.admin.category.index',['categories' => $categories]);
    }
}
