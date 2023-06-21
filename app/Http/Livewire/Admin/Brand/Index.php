<?php

namespace App\Http\Livewire\Admin\Brand;

use Illuminate\Support\Str;
use Livewire\Component;
use App\Models\Brand;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $name, $slug, $status, $brand_id;
    public $search = '';

    public function rules() {
        return[
            'name' => 'required|string',
            'slug' => 'required|string',
            'status' => 'nullable'
        ];
    }

    public function resetFields() {
        $this->name = '';
        $this->slug = '';
        $this->status = '';
    }
    public function closeModal() {
        $this->resetFields();
    }
    public function store() {
        $validateData = $this->validate();

        Brand::create([
            'name' => $this->name,
            'slug' => Str::slug($this->slug),
            'status' => $this->status == true ? '1':'0',
        ]);
        session()->flash('message','Brand Added Successfully');
        $this->resetFields();
        return back();
    }

    public function edit(int $brand_id) {
        $brand = Brand::findOrFail($brand_id);
        $this->name = $brand->name;
        $this->slug = $brand->slug;
        $this->status = $brand->status;
    }
    public function update(){
        $brand = Brand::find($this->brand_id);
        $brand->update([
           'name' => $this->name,
           'slug' =>$this->slug,
           'status' => $this->status == true ? '1':'0',
        ]);

        session()->flash('message', 'Brand Updated Successfully.');
        $this->resetFields();
    }
    public function render()
    {
        $brands = Brand::where('name', 'like', '%'.$this->search.'%')->orwhere('id', 'like', '%'.$this->search.'%')->orderBy('id','DESC')->paginate(2);
        return view('livewire.admin.brand.index',['brands' => $brands]);

    }
}
