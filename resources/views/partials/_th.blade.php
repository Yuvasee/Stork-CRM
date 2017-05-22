{{-- If already sorting by this field --}}
@if($sorting['by'] == $field)
	{{-- Link to inverse sorting direction --}}
    <a href="?sort_by={{ $field }}&sort_order={!! ($sorting['order'] == 'asc') ? 'desc' : 'asc' !!}">
        {{ trans('adminlte_lang::message.' . $field) }}
        <i class="fa fa-sort-{!! ($sorting['order'] == 'asc') ? 'up' : 'down' !!}" aria-hidden="true"></i>
    </a>
@else
    <a href="?sort_by={{ $field }}&sort_order={{ $def_order }}">{{ trans('adminlte_lang::message.' . $field) }}</a>
@endif
