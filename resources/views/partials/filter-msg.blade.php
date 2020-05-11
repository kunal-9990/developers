@php
$exclusiveTo =  ucfirst(strtolower(str_replace("Product.","", $exclusiveTo)));
if($exclusiveTo == 'Wp'){
    $exclusiveTo = 'Working Papers';
}
if($exclusiveTo == 'Analyticsai'){
    $exclusiveTo = 'Analytics.AI';
}
if($exclusiveTo == 'Caanalyticsai'){
    $exclusiveTo = 'AnalyticsAI';
}
if($exclusiveTo == 'Auditcan'){
    $exclusiveTo = 'Audit';
}
@endphp

<div class="filtermsg col-sm-9">
    This content is exclusively related to {{$exclusiveTo}} and has been filtered out. Select the PRODUCTS <i class="fas fa-filter"></i> dropdown in the top navigation to modify your filter settings.
</div>