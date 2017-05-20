<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ url (mix('/js/app.js')) }}" type="text/javascript"></script>
<script src="{{ url (mix('/js/all.js')) }}"></script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->
<script>
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>
<script>
	function setSidebarCookie(sc = 0) {
		var d = new Date;
		d.setDate(d.getDate() + 30);
    	document.cookie = "sidebarCollapsed=" + sc.toString() + "; expires=" + d.toUTCString() + "; path=/";
	}

    $('body').on('expanded.pushMenu', function(){
		setSidebarCookie(0)
    });
    $('body').on('collapsed.pushMenu', function(){
		setSidebarCookie(1)
    });
</script>