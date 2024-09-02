<div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="createProductModalLabel">Add Product</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createProductForm" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-2">
                        <label for="name" class="form-label">Product Name</label>
                        <input type="text" id="name" name="name" class="form-control mb-2" value="{{ old('name') }}">
                        <div class="invalid-feedback" id="name_error"></div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="price" class="form-label">Price</label>
                        <input type="text" name="price" id="price" class="form-control mb-2" value="{{ old('price') }}">
                        <div class="invalid-feedback" id="price_error"></div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="sale_price" class="form-lable">Sale Price</label>
                        <input type="text" name="sale_price" id="sale_price" class="form-control mb-2" value="{{ old('sale_price') }}">
                        <div class="invalid-feedback" id="sale_price_error"></div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" name="description" id="description" class="form-control mb-2" value="{{ old('description') }}">
                        <div class="invalid-feedback" id="description_error"></div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="stock_quantity" class="form-label">Stock Quantity</label>
                        <input type="text" class="form-control mb-2" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity') }}">
                        <div class="invalid-feedback" id="stock_quantity_error"></div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="category_id" class="form-label">Category</label>
                        <select name="category_id" id="category_id" class="form-select">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') === $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="category_id_error"></div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="brand_id" class="form-lable">Brand</label>
                        <select name="brand_id" id="brand_id" class="form-select">
                            @foreach ($brands as $brand )
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" name="image" id="image" class="form-control mb-2">
                        <div class="invalid-feedback" id="image_error">Image type is not valid</div>
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

  <div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="createCategoryModalLabel">Add Category</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="createCategoryForm">
              <div class="form-group mb-2">
                <label for="name" class="form-label">Category Name</label>
                <div class="input-group">
                    <input type="text" id="name" name="name" class="form-control mb-2" value="{{ old('name') }}">
                </div>
                <div class="invalid-feedback" id="name_error">
                    <!-- Error message will be displayed here -->
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
                <label for="image" class="form-label">Image</label>
                <div class="input-group">
                  <input type="file" name="image" id="image" class="form-control  mb-2">
                </div>
                <div class="invalid-feedback" id="image_error">
                    Image type is not valid
                </div>
              </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="add_category">Add Category</button>
        </div>
      </div>
    </div>
  </div>


  <div class="modal fade" id="createBrandModal" tabindex="-1" aria-labelledby="createBrandModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="createBrandModalLabel">Add Brand</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="createBrandForm">
              <div class="form-group mb-2">
                <label for="name" class="form-label">Brand Name</label>
                <div class="input-group">
                    <input type="text" id="name" name="name" class="form-control mb-2" value="{{ old('name') }}">
                </div>
                <div class="invalid-feedback" id="name_error">
                    <!-- Error message will be displayed here -->
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
                <label for="logo" class="form-label">Image</label>
                <div class="input-group">
                  <input type="file" name="logo" id="image" class="form-control  mb-2">
                </div>
                <div class="invalid-feedback" id="image_error">
                    Image type is not valid
                </div>
              </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="add-brand">Add Brand</button>
        </div>
      </div>
    </div>
  </div>

 



