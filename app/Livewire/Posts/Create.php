<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;

class Create extends Component
{

    use WithFileUploads;
    //image
    #[Rule('required', message: 'Masukkan Gambar Post')]
    #[Rule('image', message: 'File Harus Gambar')]
    #[Rule('max:1024', message: 'Ukuran File Maksimal 1MB')]

    public $image;
    //title
    #[Rule('required', message: 'Masukkan Judul Post')]

    public $title;

    //content
    #[Rule('required', message: 'Masukkan Isi Post')]
    #[Rule('min:3', message: 'Isi Post Minimal 3 Karakter')]
    
    public $content;

    public function store()
    {
        $this->validate();

        //store image in storage/app/public/posts
        $imagePath = $this->image->store('posts', 'public');

        // Ambil hanya nama file tanpa path
        $imageName = basename($imagePath);
    
        // Simpan ke database hanya nama filenya
        Post::create([
            'image' => $imageName, // Hanya nama file
            'title' => $this->title,
            'content' => $this->content,
        ]);

        //flash message
        session()->flash('message', 'Data Berhasil Disimpan.');

        //redirect
        return redirect()->route('posts.index');
    }
    
    public function render()
    {
        return view('livewire.posts.create');
    }
}
