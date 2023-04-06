<!-- need to remove -->
<li class="nav-item">
    <a href="{{url('/admin/home')}}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Home</p>
    </a>
</li>

<?php
 $db_tables = DB::select('show tables');
 $not_to_show_table = array('tags','sub_tags');

$show_tables = array('companies','admin_users','users');


?>


<!--
<li class="nav-item">
    <a href="{{url('/admin/personal')}}" class="nav-link {{ Request::is('personal') ? 'active' : '' }}">
        <i class="nav-icon fas fa-edit"></i>
        <p>Bireysel Müşteriler</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{url('/admin/company')}}" class="nav-link {{ Request::is('company') ? 'active' : '' }}">
        <i class="nav-icon fas fa-edit"></i>
        <p>Kurumsal Müşteriler</p>
    </a>
</li>
-->
<li class="nav-item">
    <a href="{{url('/admin/tag_details')}}" class="nav-link {{ Request::is('tag_details') ? 'active' : '' }}">
        <i class="nav-icon fas fa-edit"></i>
        <p>Tag Detayları</p>
    </a>
</li>
@foreach($db_tables as $table)
    @foreach($table as $key=>$value)

        @if(in_array($value,$not_to_show_table))
            @continue;

        @endif
        @if(in_array($value,$show_tables))

        <!-- need to remove -->
        <li class="nav-item">
            <a href="{{url('/admin/'.$value)}}" class="nav-link {{ Request::is($value) ? 'active' : '' }}">
                <i class="nav-icon fas fa-edit"></i>
                <p>{{ LanguageChange(FixName($value)) }}</p>
            </a>
        </li>
        @endif
    @endforeach
@endforeach



