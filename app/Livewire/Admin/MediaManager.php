<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Media;
use App\Services\ImageService;

class MediaManager extends Component
{
    use WithPagination, WithFileUploads;

    public $uploadedFiles = [];
    public $altText = [];

    protected $rules = [
        'uploadedFiles.*' => 'image|max:2048',
    ];

    public function upload()
    {
        $this->validate();

        $imageService = new ImageService();

        foreach ($this->uploadedFiles as $file) {
            $data = $imageService->upload($file, 'media');

            Media::create([
                'user_id' => auth()->id(),
                'file_name' => $data['file_name'],
                'file_path' => $data['file_path'],
                'file_type' => $data['file_type'],
                'file_size' => $data['file_size'],
            ]);
        }

        session()->flash('message', 'Files uploaded successfully.');
        $this->reset(['uploadedFiles']);
    }

    public function delete($id)
    {
        $media = Media::findOrFail($id);

        $imageService = new ImageService();
        $imageService->delete($media->file_path);

        $media->delete();
        session()->flash('message', 'Media deleted successfully.');
    }

    public function updateAlt($id)
    {
        $media = Media::findOrFail($id);
        $media->update(['alt_text' => $this->altText[$id] ?? '']);
        session()->flash('message', 'Alt text updated successfully.');
    }

    public function render()
    {
        return view('livewire.admin.media-manager', [
            'mediaFiles' => Media::with('user')->latest()->paginate(12)
        ])->layout('layouts.admin');
    }
}
