@extends('layouts.admin')

@section('title', isset($category) ? 'Edit Category' : 'Create Category')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>{{ isset($category) ? 'Edit Category' : 'Create Category' }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ isset($category) ? route('admin.categories.update', $category->id) : route('admin.categories.store') }}" method="POST">
            @csrf
            @if(isset($category))
                @method('PUT')
            @endif
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name *</label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="{{ old('name', $category->name ?? '') }}" required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug (Optional)</label>
                        <input type="text" class="form-control" id="slug" name="slug" 
                               value="{{ old('slug', $category->slug ?? '') }}">
                        <div class="form-text">URL-friendly version (auto-generated from name)</div>
                        @error('slug')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    {{ isset($category) ? 'Update' : 'Create' }} Category
                </button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
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
        const oldSlug = '{{ $category->slug ?? "" }}';
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