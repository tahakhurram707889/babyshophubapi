@extends('layouts.admin')

@section('title', isset($product) ? 'Edit Product' : 'Create Product')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>{{ isset($product) ? 'Edit Product' : 'Create Product' }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ isset($product) ? route('admin.products.update', $product->id) : route('admin.products.store') }}" 
              method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($product))
                @method('PUT')
            @endif
            
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name *</label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="{{ old('name', $product->name ?? '') }}" required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description *</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description', $product->description ?? '') }}</textarea>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="price" class="form-label">Price *</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" class="form-control" id="price" name="price" 
                                           value="{{ old('price', $product->price ?? '') }}" required>
                                </div>
                                @error('price')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="stock" class="form-label">Stock Quantity *</label>
                                <input type="number" class="form-control" id="stock" name="stock" 
                                       value="{{ old('stock', $product->stock ?? '') }}" required>
                                @error('stock')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category *</label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                    {{ (isset($product) && $product->category_id == $category->id) ? 'selected' : (old('category_id') == $category->id ? 'selected' : '') }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="image" class="form-label">Product Image *</label>
                        
                        @if(isset($product) && $product->image)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="Current Image" 
                                     class="img-fluid rounded mb-2" style="max-height: 200px;">
                                <p class="text-muted small">Current Image</p>
                            </div>
                            <p class="text-muted small">Upload new image to replace</p>
                        @endif
                        
                        <input type="file" class="form-control" id="image" name="image" 
                               {{ !isset($product) ? 'required' : '' }}>
                        @error('image')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Allowed: JPG, PNG, WEBP. Max: 2MB
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        {{ isset($product) ? 'Update Product' : 'Create Product' }}
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection