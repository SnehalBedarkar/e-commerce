<div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addAddressModalLabel">Change Address</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="address_form" class="address-form">
            <div class="d-flex mb-3">
                <div class="flex-fill me-2">
                    <div class="form-group">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter your name">
                    </div>
                </div>
                <div class="flex-fill ms-2">
                    <div class="form-group">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="text" id="phone_number" name="phone_number" class="form-control" placeholder="Enter your phone number">
                    </div>
                </div>
            </div>
            <div class="d-flex mb-3">
                <div class="flex-fill me-2">
                    <div class="form-group">
                        <label for="postal_code" class="form-label">Pin Code</label>
                        <input type="text" id="postal_code" name="postal_code" class="form-control" placeholder="Enter your pin code">
                    </div>
                </div>
                <div class="flex-fill ms-2">
                    <div class="form-group mb-3">
                        <label for="locality" class="form-label">Locality</label>
                        <input type="text" id="locality" name="locality" class="form-control" placeholder="Enter locality">
                    </div>
                </div>
            </div>
            <div class="form-group mb-2">
                <label for="address" class="form-label">Address</label>
                <input type="text" id="address" name="address" class="form-control p-3" placeholder="Enter your address">
            </div>
            <div class="d-flex mb-3">
                <div class="flex-fill me-2">
                    <div class="form-group mb-3">
                        <label for="city" class="form-label">City/District/Town</label>
                        <input type="text" id="city" name="city" class="form-control" placeholder="Enter city/district/town">
                    </div>
                </div>
                <div class="flex-fill ms-2">
                    <div class="form-group mb-3">
                        <label for="state" class="form-label">State</label>
                        <select name="state" id="state" class="form-select " size="5" aria-label="size 5 select example">
                            <option value="">Select a State</option>
                            <option value="AN">Andaman and Nicobar Islands</option>
                            <option value="AP">Andhra Pradesh</option>
                            <option value="AR">Arunachal Pradesh</option>
                            <option value="AS">Assam</option>
                            <option value="BR">Bihar</option>
                            <option value="CH">Chandigarh</option>
                            <option value="CT">Chhattisgarh</option>
                            <option value="DN">Dadra and Nagar Haveli and Daman and Diu</option>
                            <option value="DD">Daman and Diu</option>
                            <option value="DL">Delhi</option>
                            <option value="GA">Goa</option>
                            <option value="GJ">Gujarat</option>
                            <option value="HR">Haryana</option>
                            <option value="HP">Himachal Pradesh</option>
                            <option value="JH">Jharkhand</option>
                            <option value="KA">Karnataka</option>
                            <option value="KL">Kerala</option>
                            <option value="LA">Ladakh</option>
                            <option value="LD">Lakshadweep</option>
                            <option value="MP">Madhya Pradesh</option>
                            <option value="MH">Maharashtra</option>
                            <option value="MN">Manipur</option>
                            <option value="ML">Meghalaya</option>
                            <option value="MZ">Mizoram</option>
                            <option value="NL">Nagaland</option>
                            <option value="OD">Odisha</option>
                            <option value="PY">Puducherry</option>
                            <option value="PB">Punjab</option>
                            <option value="RJ">Rajasthan</option>
                            <option value="SK">Sikkim</option>
                            <option value="TN">Tamil Nadu</option>
                            <option value="TG">Telangana</option>
                            <option value="TR">Tripura</option>
                            <option value="UP">Uttar Pradesh</option>
                            <option value="UT">Uttarakhand</option>
                            <option value="WB">West Bengal</option>
                        </select>
                    </div>

                </div>
            </div>
            <div class="d-flex mb-3">
                <div class="flex-fill me-2">
                    <div class="form-group mb-3">
                        <label for="landmark" class="form-lable">Landmark</label>
                        <input type="text" name="landmark" id="landmark" placeholder="Landmark" class="form-control mt-2">
                    </div>
                </div>
                <div class="flex-fill ms-2">
                    <div class="form-group mb-3">
                        <label for="alt_phone_number" class="form-label">Alternate Phone Number</label>
                        <input type="text" name="alternate_phone_number" id="alt_phone_number" class="form-control" placeholder="Enter alternate phone number">
                    </div>
                </div>
            </div>
            <div class="form-group mb-3">
                <h5>Address Type</h5>
                <div class="form-check">
                    <input type="radio" name="type" id="home" value="home" class="form-check-input">
                    <label for="home" class="form-check-label">Home</label>
                </div>
                <div class="form-check">
                    <input type="radio" name="type" id="work" value="work" class="form-check-input">
                    <label for="work" class="form-check-label">Work</label>
                </div>
            </div>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="save_deliver">Submit</button>
        </div>
      </div>
    </div>
  </div>


  <div class="modal fade" id="editAddressModal" tabindex="-1" aria-labelledby="editAddressModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editAddressModalLabel">Change Address</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="edit_address_form" class="address-form">
            <input type="hidden" name="address_id" id="edit_address_id">
            <div class="d-flex mb-3">
                <div class="flex-fill me-2">
                    <div class="form-group">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="edit_name" class="form-control" placeholder="Enter your name">
                    </div>
                </div>
                <div class="flex-fill ms-2">
                    <div class="form-group">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="text" id="edit_phone_number" name="phone_number" class="form-control" placeholder="Enter your phone number">
                    </div>
                </div>
            </div>
            <div class="d-flex mb-3">
                <div class="flex-fill me-2">
                    <div class="form-group">
                        <label for="postal_code" class="form-label">Pin Code</label>
                        <input type="text" id="edit_postal_code" name="postal_code" class="form-control" placeholder="Enter your pin code">
                    </div>
                </div>
                <div class="flex-fill ms-2">
                    <div class="form-group mb-3">
                        <label for="locality" class="form-label">Locality</label>
                        <input type="text" id="edit_locality" name="locality" class="form-control" placeholder="Enter locality">
                    </div>
                </div>
            </div>
            <div class="form-group mb-2">
                <label for="address" class="form-label">Address</label>
                <input type="text" id="edit_address" name="address" class="form-control p-3" placeholder="Enter your address">
            </div>
            <div class="d-flex mb-3">
                <div class="flex-fill me-2">
                    <div class="form-group mb-3">
                        <label for="city" class="form-label">City/District/Town</label>
                        <input type="text" id="edit_city" name="city" class="form-control" placeholder="Enter city/district/town">
                    </div>
                </div>
                <div class="flex-fill ms-2">
                    <div class="form-group mb-3">
                        <label for="state" class="form-label">State</label>
                        <select name="state" id="edit_state" class="form-select">
                            <option value="">Select a State</option>
                            <option value="AN">Andaman and Nicobar Islands</option>
                            <option value="AP">Andhra Pradesh</option>
                            <option value="AR">Arunachal Pradesh</option>
                            <option value="AS">Assam</option>
                            <option value="BR">Bihar</option>
                            <option value="CH">Chandigarh</option>
                            <option value="CT">Chhattisgarh</option>
                            <option value="DN">Dadra and Nagar Haveli and Daman and Diu</option>
                            <option value="DD">Daman and Diu</option>
                            <option value="DL">Delhi</option>
                            <option value="GA">Goa</option>
                            <option value="GJ">Gujarat</option>
                            <option value="HR">Haryana</option>
                            <option value="HP">Himachal Pradesh</option>
                            <option value="JH">Jharkhand</option>
                            <option value="KA">Karnataka</option>
                            <option value="KL">Kerala</option>
                            <option value="LA">Ladakh</option>
                            <option value="LD">Lakshadweep</option>
                            <option value="MP">Madhya Pradesh</option>
                            <option value="MH">Maharashtra</option>
                            <option value="MN">Manipur</option>
                            <option value="ML">Meghalaya</option>
                            <option value="MZ">Mizoram</option>
                            <option value="NL">Nagaland</option>
                            <option value="OD">Odisha</option>
                            <option value="PY">Puducherry</option>
                            <option value="PB">Punjab</option>
                            <option value="RJ">Rajasthan</option>
                            <option value="SK">Sikkim</option>
                            <option value="TN">Tamil Nadu</option>
                            <option value="TG">Telangana</option>
                            <option value="TR">Tripura</option>
                            <option value="UP">Uttar Pradesh</option>
                            <option value="UT">Uttarakhand</option>
                            <option value="WB">West Bengal</option>
                        </select>
                    </div>

                </div>
            </div>
            <div class="d-flex mb-3">
                <div class="flex-fill me-2">
                    <div class="form-group mb-3">
                        <label for="landmark" class="form-lable">Landmark</label>
                        <input type="text" name="landmark" id="edit_landmark" placeholder="Landmark" class="form-control mt-2">
                    </div>
                </div>
                <div class="flex-fill ms-2">
                    <div class="form-group mb-3">
                        <label for="alt_phone_number" class="form-label">Alternate Phone Number</label>
                        <input type="text" name="alternate_phone_number" id="edit_alt_phone_number" class="form-control" placeholder="Enter alternate phone number">
                    </div>
                </div>
            </div>
            <div class="form-group mb-3">
                <h5>Address Type</h5>
                <div class="form-check">
                    <input type="radio" name="type" id="edit_home" value="home" class="form-check-input">
                    <label for="home" class="form-check-label">Home</label>
                </div>
                <div class="form-check">
                    <input type="radio" name="type" id="edit_work" value="work" class="form-check-input">
                    <label for="work" class="form-check-label">Work</label>
                </div>
            </div>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="save_changes">Submit</button>
        </div>
      </div>
    </div>
  </div>
