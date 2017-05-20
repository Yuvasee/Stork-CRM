@if ($flag == "check")
    <i class="fa fa-check text-green" aria-hidden="true"></i>
@elseif ($flag == "today")
    <i class="fa fa-exclamation-circle text-yellow" aria-hidden="true"></i>
@elseif ($flag == "overdue")
    <i class="fa fa-exclamation-circle text-red" aria-hidden="true"></i>
@elseif ($flag == "future")
    <i class="fa fa-spinner" aria-hidden="true"></i>
@endif
