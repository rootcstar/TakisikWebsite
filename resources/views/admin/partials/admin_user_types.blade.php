<?php /**USING FOR ASSIGN PERMISSION TO USER TYPE*/?>

<ul class="list-group">

    @if($admin_user_types->isEmpty())
        <li class="list-group-item">No User Types found</li>
    @else
        <li class="list-group-item">User Types</li>
        @php($i=1)
        @foreach($admin_user_types as $admin_user_type)
            <li class="list-group-item">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" name="admin_user_type_id" id="customCheck{{$i}}" value="{{$admin_user_type->admin_user_type_id}}" @if($admin_user_type->is_checked) checked @endif >
                    <label class="custom-control-label" for="customCheck{{$i}}">{{$admin_user_type->admin_user_type_name}}</label>
                </div>
            </li>
            @php($i++)
        @endforeach
    @endif





</ul>
