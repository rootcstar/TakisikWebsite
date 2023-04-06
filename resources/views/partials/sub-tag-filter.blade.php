

    <li class="text-uppercase tag-list @if(Session::get('website.selected_sub_tag') == 0) active @endif"  onclick="GetSubTag('{{ encrypt(Session::get('website.selected_tag')) }}','{{ encrypt(0) }}')">ALL</li>
    @foreach($sub_tags as $sub_tag)

        <li class="text-uppercase tag-list @if($sub_tag->sub_tag_id == Session::get('website.selected_sub_tag')) active @endif" onclick="GetSubTag('{{ encrypt(Session::get('website.selected_tag')) }}','{{ encrypt($sub_tag->sub_tag_id) }}')">
            {{ $sub_tag->sub_tag_display_name }}
        </li>
    @endforeach

