<?php /**USING FOR ASSIGN NEW ADMIN USER SHOWING THE ALLOWED PERMISSIONS ONLY*/?>

<ul class="list-group">

    @if($permissions->isEmpty())
        <li class="list-group-item">İzin bulanamadı</li>
    @else
        <li class="list-group-item">İzinler</li>

    @endif

    @foreach($permissions as $permission)
        <li class="list-group-item">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="permissions" value="{{$permission->permission_id}}" checked readonly>
                <label class="custom-control-label" for="customCheck3">{{ $permission->permission_name }}</label>
            </div>
        </li>
    @endforeach


</ul>
