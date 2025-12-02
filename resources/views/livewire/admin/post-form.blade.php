<div>
    <div class="container-fluid">
        @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form wire:submit.prevent="save">
            <div class="row">
                <!-- Main Content Column -->
                <div class="col-md-8">
                    <!-- Title -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Post Title *</label>
                                <input type="text" wire:model="title"
                                    class="form-control form-control-lg @error('title') is-invalid @enderror"
                                    placeholder="Enter post title">
                                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Content Editor -->
                    <div class="card mb-3">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Content *</h5>
                        </div>
                        <div class="card-body">
                            <div wire:ignore>
                                <div id="quill-editor" style="height: 400px;"></div>
                            </div>
                            <input type="hidden" wire:model="content" id="quill-content">
                            @error('content') <div class="text-danger mt-2">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <!-- Excerpt -->
                    <div class="card mb-3">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Excerpt</h5>
                        </div>
                        <div class="card-body">
                            <textarea wire:model="excerpt" rows="3"
                                class="form-control @error('excerpt') is-invalid @enderror"
                                placeholder="Brief summary of the post (optional)"></textarea>
                            @error('excerpt') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted">Short description that appears in blog listings</small>
                        </div>
                    </div>

                    <!-- SEO Settings -->
                    <div class="card mb-3">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="bi bi-search"></i> SEO Settings</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Meta Title</label>
                                <input type="text" wire:model="meta_title"
                                    class="form-control @error('meta_title') is-invalid @enderror"
                                    placeholder="SEO title (defaults to post title)">
                                @error('meta_title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Meta Description</label>
                                <textarea wire:model="meta_description" rows="2"
                                    class="form-control @error('meta_description') is-invalid @enderror"
                                    placeholder="Brief description for search engines"></textarea>
                                @error('meta_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Column -->
                <div class="col-md-4">
                    <!-- Publish Settings -->
                    <div class="card mb-3">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Publish</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Status *</label>
                                <select wire:model="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="draft">Draft</option>
                                    <option value="published">Published</option>
                                    <option value="scheduled">Scheduled</option>
                                </select>
                                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            @if($status === 'scheduled')
                                <div class="mb-3">
                                    <label class="form-label">Publish Date & Time</label>
                                    <input type="datetime-local" wire:model="publish_at"
                                        class="form-control @error('publish_at') is-invalid @enderror">
                                    @error('publish_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            @endif

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> {{ $postId ? 'Update Post' : 'Create Post' }}
                                </button>
                                <a href="{{ route('admin.posts') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Category -->
                    <div class="card mb-3">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Category</h5>
                        </div>
                        <div class="card-body">
                            <select wire:model="category_id"
                                class="form-select @error('category_id') is-invalid @enderror">
                                <option value="">-- Select Category --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <!-- Tags -->
                    <div class="card mb-3">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Tags</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-check-list" style="max-height: 200px; overflow-y: auto;">
                                @foreach($tags as $tag)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" wire:model="selectedTags"
                                            value="{{ $tag->id }}" id="tag{{ $tag->id }}">
                                        <label class="form-check-label" for="tag{{ $tag->id }}">
                                            {{ $tag->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Featured Image -->
                    <div class="card mb-3">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Featured Image</h5>
                        </div>
                        <div class="card-body">
                            @if($existingImage && !$featured_image)
                                <div class="mb-2">
                                    <img src="{{ Storage::url($existingImage) }}" class="img-fluid rounded"
                                        alt="Current featured image">
                                    <p class="text-muted small mt-1">Current image</p>
                                </div>
                            @endif

                            @if($featured_image)
                                <div class="mb-2">
                                    <img src="{{ $featured_image->temporaryUrl() }}" class="img-fluid rounded"
                                        alt="New featured image">
                                    <p class="text-success small mt-1">New image preview</p>
                                </div>
                            @endif

                            <input type="file" wire:model="featured_image"
                                class="form-control @error('featured_image') is-invalid @enderror" accept="image/*">
                            @error('featured_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted">Max: 2MB. Recommended: 1200x630px</small>

                            <div wire:loading wire:target="featured_image" class="mt-2">
                                <div class="spinner-border spinner-border-sm" role="status">
                                    <span class="visually-hidden">Uploading...</span>
                                </div>
                                Uploading...
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Initialize Quill editor
                var quill = new Quill('#quill-editor', {
                    theme: 'snow',
                    placeholder: 'Write your post content here...',
                    modules: {
                        toolbar: [
                            [{ 'header': [1, 2, 3, false] }],
                            ['bold', 'italic', 'underline', 'strike'],
                            ['blockquote', 'code-block'],
                            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                            [{ 'indent': '-1' }, { 'indent': '+1' }],
                            ['link', 'image'],
                            [{ 'color': [] }, { 'background': [] }],
                            [{ 'align': [] }],
                            ['clean']
                        ]
                    }
                });

                // Set initial content if editing
                var content = @js($content);
                if (content) {
                    quill.root.innerHTML = content;
                }

                // Update Livewire property when content changes
                quill.on('text-change', function () {
                    var html = quill.root.innerHTML;
                    @this.set('content', html);
                });
            });
        </script>
    @endpush
</div>