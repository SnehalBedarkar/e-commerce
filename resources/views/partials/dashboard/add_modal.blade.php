<div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="createProdutcModalLabel">Add Product</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="createProductForm">
              <div class="form-group mb-2">
                <label for="name" class="form-label">Product Name</label>
                <div class="input-group">
                    <input type="text" id="name" name="name" class="form-control mb-2" value="{{ old('name') }}">
                </div>
                <div class="invalid-feedback" id="name_error">
                    <!-- Error message will be displayed here -->
                </div>
              </div>
              <div class="form-group  mb-2">
                <label for="price" class="form-label">Price</label>
                <div class="input-group">
                  <input type="text" name="price" id="price" class="form-control mb-2" value="{{ old('price') }}">
                </div>
                <div class="invalid-feedback" id="price_error">

                </div>
              </div>
              <div class="form-group  mb-2">
                <label for="description" class="form-label">Description</label>
                <div class="input-group">
                  <input type="text" name="description" id="description" class="form-control mb-2" value="{{ old('description') }}">
                </div>
                <div class="invalid-feedback">
                  
                </div>
              </div>
              <div class="form-group  mb-2">
                <label for="stock_quantity" class="form-lable">Stock Quantity</label>
                <div class="input-group">
                  <input type="text" class="form-control mb-2" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity') }}">
                </div>
                <div class="invalid-feedback">

                </div>
              </div>
              <div class="form-group  mb-2">
                <label for="category_id" class="form-lable">Category</label>
                <div class="input-group">
                    <select name="category_id" id="category_id" class="form-control  mb-2">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') === $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
              </div>
              <div class="form-group  mb-2">
                <label for="image" class="form-label">Image</label>
                <div class="input-group">
                  <input type="file" name="image" id="image" class="form-control  mb-2">
                </div>
              </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="add_product">Add Product</button>
        </div>
      </div>
    </div>
  </div>