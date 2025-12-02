<div>
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Media Library</h2>
        </div>

        @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Upload Section -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Upload Images</h5>
                <input type="file" wire:model="uploadedFiles" multiple accept="image/*" class="form-control mb-3">
                @error('uploadedFiles.*') <div class="text-danger">{{ $message }}</div> @enderror

                @if($uploadedFiles)
                    <button wire:click="upload" class="btn btn-primary">
                        <i class="bi bi-cloud-upload"></i> Upload Files
                    </button>
                @endif
            </div>
        </div>

        <!-- Media Grid -->
        <div class="row">
            @forelse($mediaFiles as $media)
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <img src="{{ Storage::url($media->file_path) }}" class="card-img-top"
                            style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <p class="small mb-1"><strong>{{ $media->file_name }}</strong></p>
                            <p class="small text-muted mb-2">{{ number_format($media->file_size / 1024, 2) }} KB</p>
                            <input type="text" wire:model="altText.{{ $media->id }}"
                                class="form-control form-control-sm mb-2" placeholder="Alt text"
                                value="{{ $media->alt_text }}">
                            <div class="btn-group btn-group-sm w-100">
                                <button wire:click="updateAlt({{ $media->id }})" class="btn btn-primary">Save</button>
                                <button wire:click="delete({{ $media->id }})" onclick="return confirm('Are you sure?')"
                                    class="btn btn-danger">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">No media files uploaded yet.</div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $mediaFiles->links() }}
        </div>
    </div>
</div>