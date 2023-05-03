
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">{{LanguageChange(ucwords(str_replace("_"," ",str_replace("admin_panel_"," ",Route::currentRouteName()))))}}</h4>

        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        @if(Route::currentRouteName() != 'admin_panel_dashboard')
                            <li class="breadcrumb-item"><a href="{{route('admin_panel_dashboard')}}">Home</a></li>
                        @endif
                        <li class="breadcrumb-item active">{{ucwords(str_replace("_"," ",str_replace("admin_panel_"," ",Route::currentRouteName())))}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
