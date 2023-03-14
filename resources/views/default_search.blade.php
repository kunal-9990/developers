<!DOCTYPE html>
<html xmlns:MadCap="http://www.madcapsoftware.com/Schemas/MadCap.xsd" lang="en-us" xml:lang="en-us"
      class="searchTopic templateTopic" 
      search-type="Stem" 
      data-mc-help-system-file-name="Default.xml" 
      data-mc-path-to-help-system="" 
      data-mc-target-type="WebHelp2"
      data-mc-runtime-file-type="Topic;Search;Default" 
      data-mc-preload-images="false" 
      data-mc-in-preview-mode="false" 
      data-mc-toc-path="">
 
 <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @yield('meta')
  
  	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-KX6JHHN');</script>
	<!-- End Google Tag Manager -->

    <link href="{{ mix('/css/app_search.css') }}" rel="stylesheet" type="text/css">
    
    {{-- FontAwesome icons --}}
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/brands.css" integrity="sha384-rf1bqOAj3+pw6NqYrtaE1/4Se2NBwkIfeYbsFdtiR6TQz0acWiwJbv1IM/Nt/ite" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/fontawesome.css" integrity="sha384-1rquJLNOM3ijoueaaeS5m+McXPJCGdr5HcA03/VHXxcp2kX2sUrQDmFc3jR5i/C7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/solid.css" integrity="sha384-VGP9aw4WtGH/uPAOseYxZ+Vz/vaTb1ehm1bwx92Fm8dTrE+3boLfF1SpAtB1z7HW" crossorigin="anonymous">
</head>
<body>      
  	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KX6JHHN"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
    <div class="page-wrap">
        @include('partials.header')
        @include('partials.header-mobile')

        <main id="main">
            @yield('content')
        </main>
    </div>
        @include('partials.cookie-consent')
        @include('partials.footer')

    <script src="{{ mix('/js/mk2/app.js') }}"></script>
    <script src="{{ mix('/js/mk4/app.js') }}"></script>
    <script src="/documentation_files/2020/webapps/31/Content/en/Resources/Scripts/custom.modernizr.js">
    </script>
    <script src="/documentation_files/2020/webapps/31/Content/en/Resources/Scripts/jquery.min.js">
    </script>
    <script src="/documentation_files/2020/webapps/31/Content/en/Resources/Scripts/require.min.js">
    </script>
    <script src="/documentation_files/2020/webapps/31/Content/en/Resources/Scripts/require.config.js">
    </script>
    <script src="/documentation_files/2020/webapps/31/Content/en/Resources/Scripts/foundation.min.js">
    </script>
    <script src="/documentation_files/2020/webapps/31/Content/en/Resources/Scripts/plugins.min.js">
    </script>
    <script src="/documentation_files/2020/webapps/31/Content/en/Resources/Scripts/MadCapAll.js">
    </script>
</body>
</html>

