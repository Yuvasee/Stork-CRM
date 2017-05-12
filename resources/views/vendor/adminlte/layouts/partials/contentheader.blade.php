<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        @yield('contentheader_title', trans('adminlte_lang::message.page_h_default'))
        <small>@yield('contentheader_description')</small>
    </h1>
    <ol class="breadcrumb">
    	@yield('breadcrumbs')
    </ol>
</section>