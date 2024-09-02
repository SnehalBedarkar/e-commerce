<div class="modal fade" id="viewProductModal" tabindex="-1" aria-labelledby="viewProductModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="viewProductModalLabel"></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <div class="form-group mb-2">
              <label for="name" class="form-label">Product Name</label>
              <div class="input-group">
                  <input type="text" id="product_name" name="name" class="form-control mb-2" readonly>
              </div>
            </div>
            <div class="form-group  mb-2">
              <label for="price" class="form-label">Price</label>
              <div class="input-group">
                <input type="text" name="price" id="product_price" class="form-control mb-2" readonly>
              </div>
            </div>
            <div class="form-group  mb-2">
              <label for="description" class="form-label">Description</label>
              <div class="input-group">
                <input type="text" name="description" id="product_description" class="form-control mb-2" readonly>
              </div>
            </div>
            <div class="form-group  mb-2">
              <label for="stock_quantity" class="form-lable">Stock Quantity</label>
              <div class="input-group">
                <input type="text" class="form-control mb-2" id="product_stock_quantity" name="stock_quantity" readonly>
              </div>
            </div>
            {{-- <div class="form-group  mb-2">
              <label for="category_id" class="form-lable">Category</label>
              <div class="input-group">
                  <select name="category_id" id="product_category_id" class="form-control  mb-2" disabled>
                      @foreach ($categories as $category)
                          <option value="{{ $category->id }}">{{ $category->name }}</option>
                      @endforeach
                  </select>
              </div>
            </div> --}}
            <div class="form-group  mb-2">
              <label for="image" class="form-label">Image</label>
              <img id="product_image" src="" alt="Product Image" class="img-fluid mb-3" width="30px">
              <input type="text" id="image_product_name" name="" class="form-control mb-2" readonly>
            </div>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="viewBrandModal" tabindex="-1" aria-labelledby="viewBrandModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="viewBrandModalLabel"></h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
              <div class="form-group mb-2">
                <label for="name" class="form-label">Brand Name</label>
                <div class="input-group">
                    <input type="text" id="product_name" name="name" class="form-control mb-2" readonly>
                </div>
              </div>
              <div class="form-group  mb-2">
                <label for="description" class="form-label">Description</label>
                <div class="input-group">
                  <input type="text" name="description" id="product_description" class="form-control mb-2" readonly>
                </div>
              </div>
              <div class="form-group  mb-2">
                <label for="logo" class="form-label">Image</label>
                <img id="brand-logo" src="" alt="Brand Logo" class="img-fluid mb-3" width="30px">
                <input type="text" id="brand_logo" name="" class="form-control mb-2" readonly>
              </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>



