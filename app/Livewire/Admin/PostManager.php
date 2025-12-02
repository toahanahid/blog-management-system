<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Services\ImageService;

class PostManager extends Component
{
    use WithPagination, WithFileUploads;

    public $title, $content, $excerpt, $category_id, $selectedTags = [];
    public $featured_image, $status = 'draft', $publish_at;
    public $meta_title, $meta_description, $meta_image;
    public $postId, $isEditing = false;
    public $search = '', $filterStatus = '';

    protected $rules = [
        'title' => 'required|min:3|max:255',
        'content' => 'required',
        'excerpt' => 'nullable|max:500',
        'category_id' => 'nullable|exists:categories,id',
        'featured_image' => 'nullable|image|max:2048',
        'status' => 'required|in:draft,published,scheduled',
        'publish_at' => 'nullable|date',
        'meta_title' => 'nullable|max:255',
        'meta_description' => 'nullable|max:500',
    ];

    public function mount()
    {
        // Initialize
    }

    public function resetForm()
    {
        $this->reset([
            'title',
            'content',
            'excerpt',
            'category_id',
            'selectedTags',
            'featured_image',
            'status',
            'publish_at',
            'meta_title',
            'meta_description',
            'postId',
            'isEditing'
        ]);
        $this->status = 'draft';
        $this->resetValidation();
    }

    public function create()
    {
        return redirect()->route('admin.posts.create');
    }

    public function save()
    {
        $this->validate();

        $imageService = new ImageService();
        $imagePath = null;

        if ($this->featured_image) {
            $imageData = $imageService->upload($this->featured_image, 'posts');
            $imagePath = $imageData['file_path'];
        }

        $post = Post::create([
            'title' => $this->title,
            'content' => $this->content,
            'excerpt' => $this->excerpt,
            'category_id' => $this->category_id,
            'user_id' => auth()->id(),
            'featured_image' => $imagePath,
            'status' => $this->status,
            'publish_at' => $this->status === 'scheduled' ? $this->publish_at : null,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
        ]);

        if (!empty($this->selectedTags)) {
            $post->tags()->attach($this->selectedTags);
        }

        session()->flash('message', 'Post created successfully.');
        return redirect()->route('admin.posts');
    }

    public function edit($id)
    {
        $post = Post::with('tags')->findOrFail($id);
        $this->postId = $post->id;
        $this->title = $post->title;
        $this->content = $post->content;
        $this->excerpt = $post->excerpt;
        $this->category_id = $post->category_id;
        $this->selectedTags = $post->tags->pluck('id')->toArray();
        $this->status = $post->status;
        $this->publish_at = $post->publish_at?->format('Y-m-d\TH:i');
        $this->meta_title = $post->meta_title;
        $this->meta_description = $post->meta_description;
        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate();

        $post = Post::findOrFail($this->postId);
        $imageService = new ImageService();

        $data = [
            'title' => $this->title,
            'content' => $this->content,
            'excerpt' => $this->excerpt,
            'category_id' => $this->category_id,
            'status' => $this->status,
            'publish_at' => $this->status === 'scheduled' ? $this->publish_at : null,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
        ];

        if ($this->featured_image) {
            if ($post->featured_image) {
                $imageService->delete($post->featured_image);
            }
            $imageData = $imageService->upload($this->featured_image, 'posts');
            $data['featured_image'] = $imageData['file_path'];
        }

        $post->update($data);
        $post->tags()->sync($this->selectedTags);

        session()->flash('message', 'Post updated successfully.');
        return redirect()->route('admin.posts');
    }

    public function delete($id)
    {
        $post = Post::findOrFail($id);
        if ($post->featured_image) {
            $imageService = new ImageService();
            $imageService->delete($post->featured_image);
        }
        $post->delete();
        session()->flash('message', 'Post deleted successfully.');
    }

    public function render()
    {
        $query = Post::with(['category', 'user'])->withCount('comments');

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        return view('livewire.admin.post-manager', [
            'posts' => $query->latest()->paginate(10),
            'categories' => Category::all(),
            'tags' => Tag::all(),
        ])->layout('layouts.admin');
    }
}
