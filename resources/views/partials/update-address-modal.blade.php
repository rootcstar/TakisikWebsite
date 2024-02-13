<div class="form-default">
    <div  class="form-default needs-validation" id="update_address_form">
        @csrf
        <div class="form-group form-group-address">
            <label class="control-label">ADRES TÜRÜ*</label>
            <select class="form-control form-update-address-fields" id="address_type" name="address_type" required>
                @if($data['address_type'] == 1)
                    <option value="1" selected>Kargo Adresi</option>
                    <option value="2" >Fatura Adresi</option>
                @endif
                @if($data['address_type'] == 2)
                    <option value="1" >Kargo Adresi</option>
                    <option value="2" selected>Fatura Adresi</option>
                @endif
            </select>
        </div>
        <div class="form-group form-group-address">
            <label for="address_title" class="control-label">ADRES BAŞLIĞI*</label>
            <input type="text" class="form-control form-update-address-fields" id="address_title"   name="address_title"  pattern="[a-zA-Z]{3}[a-zA-Z ]{1,30}" value="{{$data->address_title}}" required>
        </div>
        <div class="row">
            <div class="form-group form-group-address col-md-6">
                <label for="city" class="control-label">İL*</label>
                <select class="form-control form-update-address-fields" id="city" name="city" required>
                    <option value="{{$data->city}}"  selected>{{$data->city}} </option>
                </select>
            </div>
            <div class="form-group form-group-address col-md-6">
                <label for="district" class="control-label">İLÇE*</label>
                <select class="form-control form-update-address-fields" id="district"  name="district" disabled="disabled" required>
                    <option value="{{$data->district}}" selected>{{$data->district}}</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group form-group-address col-md-6">
                <label for="neighbourhood" class="control-label">MAHALLE*</label>
                <select class="form-control form-update-address-fields" id="neighbourhood" name="neighbourhood" disabled="disabled" required>
                    <option value="{{$data->neighbourhood}}" selected>{{$data->neighbourhood}}</option>
                </select>
            </div>
            <div class="form-group form-group-address col-md-6">
                <label for="zip" class="control-label">ZIP*</label>
                <input type="text" class="form-control form-update-address-fields" id="zip" name="zip" value="{{$data->zip}}" required>
            </div>
        </div>
        <div class="form-group form-group-address">
            <label for="address" class="control-label">ADRES*</label>
            <input type="text" class="form-control form-update-address-fields" id="address" name="address" value="{{$data->address}}" required>
        </div>
        <input type="text" class=" form-update-address-fields" value="{{Session::get('website.user.user_info')->user_id}}" id="user_id" name="user_id" required hidden>
        <button  class="btn w-100" onclick="UpdateAddress()">ADRES EKLE</button>
    </div>
</div>
</div>
