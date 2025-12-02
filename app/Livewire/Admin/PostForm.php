<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Services\ImageService;

class PostForm extends Component
{
    use WithFileUploads;

    public $postId = null;
    public $title = '';
    public $content = '';
    public $excerpt = '';
    public $category_id = '';
    public $selectedTags = [];
    public $featured_image;
    public $existingImage = null;
    public $status = 'draft';
    public $publish_at = '';
    public $meta_title = '';
    public $meta_description = '';

    protected function rules()
    {
        return [
            'title' => 'required|min:3|max:255',
            'content' => 'required|min:10',
            'excerpt' => 'nullable|max:500',
            'category_id' => 'nullable|exists:categories,id',
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published,scheduled',
            'publish_at' => 'nullable|date',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable|max:500',
        ];
    }

    public function mount($postId = null)
    {
        if ($postId) {
            $this->postId = $postId;
            $post = Post::with('tags')->findOrFail($postId);

            $this->title = $post->title;
            $this->content = $post->content;
            $this->excerpt = $post->excerpt;
            $this->category_id = $post->category_id;
            $this->selectedTags = $post->tags->pluck('id')->toArray();
            $this->existingImage = $post->featured_image;
            $this->status = $post->status;
            $this->publish_at = $post->publish_at?->format('Y-m-d\TH:i');
            $this->meta_title = $post->meta_title;
            $this->meta_description = $post->meta_description;
        }
    }

    public function save()
    {
        $this->validate();

        $imageService = new ImageService();
        $imagePath = $this->existingImage;

        if ($this->featured_image) {
            if ($this->existingImage) {
                $imageService->delete($this->existingImage);
            }
            $imageData = $imageService->upload($this->featured_image, 'posts');
            $imagePath = $imageData['file_path'];
        }

        $data = [
            'title' => $this->title,
            'content' => $this->content,
            'excerpt' => $this->excerpt,
            'category_id' => $this->category_id ?: null,
            'user_id' => auth()->id(),
            'featured_image' => $imagePath,
            'status' => $this->status,
            'publish_at' => $this->status === 'scheduled' ? $this->publish_at : null,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
        ];

        if ($this->postId) {
            // Update existing post
            $post = Post::findOrFail($this->postId);
            $post->update($data);
            $post->tags()->sync($this->selectedTags);
            session()->flash('message', 'Post updated successfully.');
        } else {
            // Create new post
            $post = Post::create($data);
            if (!empty($this->selectedTags)) {
                $post->tags()->attach($this->selectedTags);
            }
            session()->flash('message', 'Post created successfully.');
        }

        return redirect()->route('admin.posts');
    }

    public function render()
    {
        return view('livewire.admin.post-form', [
            'categories' => Category::all(),
            'tags' => Tag::all(),
        ]);
    }
}
