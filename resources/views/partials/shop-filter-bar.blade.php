<div class="tt-btn-col-close">
    <a href="#">Close</a>
</div>
<div class="tt-collapse open tt-filter-detach-option">
    <div class="tt-collapse-content">
        <div class="filters-mobile">
            <div class="filters-row-select">

            </div>
        </div>
    </div>
</div>
<div class="tt-collapse open">
    <h3 class="tt-collapse-title">KATEGORİLER</h3>
    <div class="tt-collapse-content">
        <ul class="tt-list-row" id="tag_filter">
            @foreach(Session::get('website.shopping.tags') as $tag)

                <li class="text-uppercase tag-list  @if($tag->tag_id == Session::get('website.selected_tag')) active @endif" onclick="GetTag('{{ encrypt($tag->tag_id) }}','{{ encrypt(0) }}')">{{ $tag->display_name }}</li>
            @endforeach

        </ul>
    </div>
</div>
<div class="tt-collapse open">
    <h3 class="tt-collapse-title">ALT KATEGORİLER</h3>
    <div class="tt-collapse-content">
        <ul class="tt-list-row" id="sub_tag_filter">
            @php
                $sub_tags = DB::select("SELECT * FROM v_tag_to_sub_tags WHERE tag_id='".Session::get('website.selected_tag')."'");
            @endphp
            <li class="text-uppercase tag-list  active "  onclick="GetSubTag('{{ encrypt(Session::get('website.selected_tag')) }}',0)">ALL</li>
            @foreach(Session::get('website.sub_tag_filter_bar') as $sub_tag)

                <li class="text-uppercase tag-list " onclick="GetSubTag('{{ encrypt(Session::get('website.selected_tag')) }}','{{ encrypt($sub_tag->sub_tag_id) }}')">
                    {{ $sub_tag->sub_tag_display_name }}
                </li>
            @endforeach

        </ul>
    </div>
</div>
