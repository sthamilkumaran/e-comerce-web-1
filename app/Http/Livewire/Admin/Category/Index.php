<?php

namespace App\Http\Livewire\Admin\Category;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\File;

class Index extends Component
{

    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public  $name, $slug, $image, $descripition, $meta_title, $meta_keyword, $meta_descripition, $category_id, $status;
    public $old_image, $new_image;
    protected $categories;
    public $search = '';

    // Validation Rules
    protected $rules = [
        'name'=>'required',
        'slug'=>'required',
        'image'=>'required|mimes:png,jpg,jpeg',
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
        $this->descripition = $category->descripition;
        $this->old_image = $category->image;
        $this->status = $category->status;
        $this->meta_title = $category->meta_title;
        $this->meta_keyword = $category->meta_keyword;
        $this->meta_descripition = $category->meta_descripition;

        // dd($this->name);
        // == true ? '1':'2'

    }
    public function cancel()    {

        $this->resetFields();
    }
    public function update(){


        $category = Category::find($this->category_id);
        $destination = public_path('uploads/category');
        
        // if($this->image){
        //     $file = $category->image;
        //     $ext = $file->getClientOriginalExtension();
        //     $fileName = time().'.'.$ext;
        //     $file->move('uploads/category',$fileName);
        //     $this->image = $fileName;
        // }
        $category->update([
           'name' => $this->name,
           'slug' =>$this->slug,
           'descripition' => $this->descripition,
           'status' => $this->status == true ? '1':'2',
           'image' => $this->fileName,
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
        $categories = Category::where('name', 'like', '%'.$this->search.'%')->orderBy('id','DESC')->paginate(1);
        return view('livewire.admin.category.index',compact('categories'),);

    }
}
