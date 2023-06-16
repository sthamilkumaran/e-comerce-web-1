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
    protected $categories;

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
        $this->image = '';
        $this->meta_title = '';
        $this->meta_keyword = '';
        $this->meta_descripition = '';
        $this->status = '';
    }
    public function edit($id){
        $category = Category::findOrFail($id);
        $this->category_id = $id;
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

        $category = Category::find($this->category_id);
        $category->update([
           'name' => $this->name,
           'slug' =>$this->slug,
           'descripition' => $this->descripition,
           'meta_title' => $this->meta_title,
           'meta_keyword' => $this->meta_keyword,
           'meta_descripition' => $this->meta_descripition,
        ]);

        session()->flash('message', 'Post Updated Successfully.');
        $this->resetFields();
    }

    public function delete($id)
    {
        Category::find($id)->delete();
        session()->flash('message', 'Post Deleted Successfully.');
    }

    public function render()
    {
        // $searchTerm = '%'.$this->searchTerm.'%';
        $categories = Category::orderBy('id','DESC')->paginate(2);
        return view('livewire.admin.category.index',compact('categories'));

    }
}
