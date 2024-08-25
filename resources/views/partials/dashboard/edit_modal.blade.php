<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editProductModalLabel">Add Product</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <form id="editProductForm">
            <input type="hidden" id="edit_product_id" name="id">
            <div class="form-group mb-2">
              <label for="edit_name" class="form-label">Product Name</label>
              <div class="input-group">
                  <input type="text" id="edit_name" name="name" class="form-control mb-2" value="{{ old('name') }}">
              </div>
              <div class="invalid-feedback" id="edit_name_error">
                  <!-- Error message will be displayed here -->
              </div>
            </div>
            <div class="form-group  mb-2">
              <label for="edit_price" class="form-label">Price</label>
              <div class="input-group">
                <input type="text" name="price" id="edit_price" class="form-control mb-2" value="{{ old('price') }}">
              </div>
              <div class="invalid-feedback" id="edit_price_error">

              </div>
            </div>
            <div class="form-group  mb-2">
              <label for="edit_description" class="form-label">Description</label>
              <div class="input-group">
                <input type="text" name="description" id="edit_description" class="form-control mb-2" value="{{ old('description') }}">
              </div>
              <div class="invalid-feedback" >
                
              </div>
            </div>
            <div class="form-group  mb-2">
              <label for="edit_stock_quantity" class="form-lable">Stock Quantity</label>
              <div class="input-group">
                <input type="text" class="form-control mb-2" id="edit_stock_quantity" name="stock_quantity" value="{{ old('stock_quantity') }}">
              </div>
              <div class="invalid-feedback" id="edit_stock_quantity_error">

              </div>
            </div>
            <div class="form-group  mb-2">
              <label for="edit_category_id" class="form-lable">Category</label>
              <div class="input-group">
                  <select name="category_id" id="edit_category_id" class="form-control  mb-2">
                      @foreach ($categories as $category)
                          <option value="{{ $category->id }}" {{ old('category_id') === $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                      @endforeach
                  </select>
              </div>
            </div>
            <div class="form-group  mb-2">
              <div>
                  <label for="current_image" class="form-lable">Current Image</label>
                  <img src="" id="current_image" alt="" width="60px">
              </div>
            </div>
            <div class="form-group">
              <label for="edit_image" class="form-label">Image</label>
              <div class="input-group">
                <input type="file" name="image" id="edit_image" class="form-control  mb-2">
              </div>
              <div class="form-lable" for="new_image_preview"> New Image</div>
              <img id="new_image_preview" src="" alt="New Image Preview" width="60px" style="display:none;">
              <div class="invalid-feedback" id="edit_image_error">
                  
              </div>
            </div>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save_changes">Save Changes</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="editCategroyModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editCategoryModalLabel">Add Product</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <form id="editCategoryForm">
            <input type="hidden" id="edit_category_id" name="id">
            <div class="form-group mb-2">
              <label for="edit_name" class="form-label">Product Name</label>
              <div class="input-group">
                  <input type="text" id="edit_name" name="name" class="form-control mb-2" value="{{ old('name') }}">
              </div>
              <div class="invalid-feedback" id="edit_name_error">
                  <!-- Error message will be displayed here -->
              </div>
            </div>
            <div class="form-group  mb-2">
              <label for="edit_price" class="form-label">Price</label>
              <div class="input-group">
                <input type="text" name="price" id="edit_price" class="form-control mb-2" value="{{ old('price') }}">
              </div>
              <div class="invalid-feedback" id="edit_price_error">

              </div>
            </div>
            <div class="form-group  mb-2">
              <label for="edit_description" class="form-label">Description</label>
              <div class="input-group">
                <input type="text" name="description" id="edit_description" class="form-control mb-2" value="{{ old('description') }}">
              </div>
              <div class="invalid-feedback" >
                
              </div>
            </div>
            <div class="form-group  mb-2">
              <label for="edit_stock_quantity" class="form-lable">Stock Quantity</label>
              <div class="input-group">
                <input type="text" class="form-control mb-2" id="edit_stock_quantity" name="stock_quantity" value="{{ old('stock_quantity') }}">
              </div>
              <div class="invalid-feedback" id="edit_stock_quantity_error">

              </div>
            </div>
            <div class="form-group  mb-2">
              <label for="edit_category_id" class="form-lable">Category</label>
              <div class="input-group">
                  <select name="category_id" id="edit_category_id" class="form-control  mb-2">
                      @foreach ($categories as $category)
                          <option value="{{ $category->id }}" {{ old('category_id') === $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                      @endforeach
                  </select>
              </div>
            </div>
            <div class="form-group  mb-2">
              <div>
                  <label for="current_image" class="form-lable">Current Image</label>
                  <img src="" id="current_image" alt="" width="60px">
              </div>
            </div>
            <div class="form-group">
              <label for="edit_image" class="form-label">Image</label>
              <div class="input-group">
                <input type="file" name="image" id="edit_image" class="form-control  mb-2">
              </div>
              <div class="form-lable" for="new_image_preview"> New Image</div>
              <img id="new_image_preview" src="" alt="New Image Preview" width="60px" style="display:none;">
              <div class="invalid-feedback" id="edit_image_error">
                  
              </div>
            </div>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save_changes">Save Changes</button>
      </div>
    </div>
  </div>
</div>