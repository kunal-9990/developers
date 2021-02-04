<h5>{{ __('strings.recently_viewed') }}</h5>
<ul class="nav">
    @foreach (array_reverse($recent) as $topic)
        @php
            $splitUrl = explode("/", $topic);
            $title = end($splitUrl);
            $title = str_replace('-', ' ', $title);
            $title = str_replace('_', ' ', $title);
            $title = str_replace('.html', '', $title);
            $title = str_replace('.htm', '', $title);
            $title = str_replace('%20', ' ', $title);
            if($title == 'webapps'){
                $title = 'Cloud Index';
            }
        @endphp
        <li><a href="{{$topic}}">{{$title}}</a></li>
    @endforeach
</ul>