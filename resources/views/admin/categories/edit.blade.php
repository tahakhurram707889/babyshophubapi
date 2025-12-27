@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Edit Category</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name *</label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="{{ old('name', $category->name) }}" required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug (Optional)</label>
                        <input type="text" class="form-control" id="slug" name="slug" 
                               value="{{ old('slug', $category->slug) }}">
                        <div class="form-text">URL-friendly version (auto-generated from name)</div>
                        @error('slug')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <div class="card">
                    <div class="card-body bg-light">
                        <h6>Category Information</h6>
                        <p class="mb-1"><strong>Created:</strong> {{ $category->created_at->format('M d, Y H:i') }}</p>
                        <p class="mb-0"><strong>Last Updated:</strong> {{ $category->updated_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Update Category
                </button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // Auto-generate slug from name
    document.getElementById('name').addEventListener('input', function() {
        const name = this.value;
        const slugInput = document.getElementById('slug');
        
        // Only auto-generate if slug is empty or matches old slug
        const oldSlug = '{{ $category->slug }}';
        if (!slugInput.value || slugInput.value === oldSlug) {
            // Generate slug from name
            const slug = name.toLowerCase()
                .replace(/[^\w\s-]/g, '') // Remove special characters
                .replace(/\s+/g, '-')     // Replace spaces with hyphens
                .replace(/--+/g, '-')     // Replace multiple hyphens with single
                .trim();
            
            slugInput.value = slug;
        }
    });
</script>
@endsection