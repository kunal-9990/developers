<title>{{ $title or 'CaseWare Developers' }}</title>

<meta property="og:url" content="{{ $url or '' }}">
<meta property="og:title" content="{{ $og_title or '' }}">
<meta property="og:description" name="description" content="{{ $og_description or '' }}">
<meta property="og:image" content="/path/to/image.jpg" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

{{-- While WIP on live server to prevent indexing --}}
@if(env('APP_ENV') != "production")
<meta name="robots" content="noindex">
@endif
<link rel="canonical" href="{{ $canonical or ''}}" />
<link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">

{{-- FontAwesome icons --}}
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/brands.css" integrity="sha384-rf1bqOAj3+pw6NqYrtaE1/4Se2NBwkIfeYbsFdtiR6TQz0acWiwJbv1IM/Nt/ite" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/fontawesome.css" integrity="sha384-1rquJLNOM3ijoueaaeS5m+McXPJCGdr5HcA03/VHXxcp2kX2sUrQDmFc3jR5i/C7" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/solid.css" integrity="sha384-VGP9aw4WtGH/uPAOseYxZ+Vz/vaTb1ehm1bwx92Fm8dTrE+3boLfF1SpAtB1z7HW" crossorigin="anonymous">

{{-- json ld --}}
<script type="application/ld+json">
	{
	  "@context": "http://schema.org/",
	  "@type": "WebSite",
	  "name": "CaseWare Documentation",
	  "url": "docs.caseware.com",
	  "potentialAction": {
		"@type": "SearchAction",
		"target": "https://docs.caseware.com/2018/webapps/29/de/search?search=test#search-{search_term_string}",
		"query-input": "required name=search_term_string"
	  }
	}
</script>


{{-- Tell Google about localized versions of our pages --}}

@if(env('APP_ENV') == "production")
	{{-- google analytics --}}
	@php
	isset(Route::current()->parameters()["product"]) ? $product = Route::current()->parameters()["product"] : $product = '';
	@endphp
	@if($product == 'workingpaper' || $product  == 'audit')
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-79260220-1"></script>
		<script>
			window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-79260220-1');
		</script>
	@else
		<script>/* <![CDATA[ */
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
			ga('create', 'UA-97702818-1', 'auto', 'Global');
			ga('create', 'UA-97702818-2', 'auto', 'Cloud');
			ga('Global.send', 'pageview', { 'page': location.pathname + location.search + location.hash});
			ga('Cloud.send', 'pageview', { 'page': location.pathname + location.search + location.hash});
		/* ]]> */</script>
	@endif
	{{-- google analytics end--}}
@endif


<script src="https://cdn.jsdelivr.net/gh/google/code-prettify@master/loader/run_prettify.js"></script>
