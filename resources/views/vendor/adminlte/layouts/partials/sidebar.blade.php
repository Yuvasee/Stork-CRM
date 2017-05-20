<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ Gravatar::get($user->email) }}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('adminlte_lang::message.online') }}</a>
                </div>
            </div>
        @endif

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <!-- Optionally, you can add icons to the links -->
            <li class="header">{{ trans('adminlte_lang::message.sidebar_h_work') }}</li>
            <li><a href="/actions"><i class='fa fa-clock-o'></i> <span>{{ trans('adminlte_lang::message.actions') }}</span></a></li>
            <li><a href="/clients"><i class='fa fa-smile-o'></i> <span>{{ trans('adminlte_lang::message.clients') }}</span></a></li>
            @if(auth()->user()->isAdmin())
                <li class="header">{{ trans('adminlte_lang::message.sidebar_h_stats') }}</li>
                <li><a href="/stats/overdue"><i class="fa fa-exclamation-circle"></i> <span>{{ trans('adminlte_lang::message.stat_overdue') }}</span></a></li>
                <li><a href="/stats/output"><i class="fa fa-phone-square"></i> <span>{{ trans('adminlte_lang::message.stat_output') }}</span></a></li>
                <li><a href="/stats/clients"><i class="fa fa-heart-o"></i> <span>{{ trans('adminlte_lang::message.stat_clients') }}</span></a></li>
                <li class="header">{{ trans('adminlte_lang::message.sidebar_h_admin') }}</li>
                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-edit"></i> <span>{{ trans('adminlte_lang::message.directories') }}</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="/action-types"><i class="fa fa-circle-o"></i> <span>{{ trans('adminlte_lang::message.actiontypes') }}</span></a></li>
                    <li><a href="/client-types"><i class="fa fa-circle-o"></i> <span>{{ trans('adminlte_lang::message.clienttypes') }}</span></a></li>
                    <li><a href="/client-statuses"><i class="fa fa-circle-o"></i> <span>{{ trans('adminlte_lang::message.clientstatuses') }}</span></a></li>
                    <li><a href="/client-sources"><i class="fa fa-circle-o"></i> <span>{{ trans('adminlte_lang::message.clientsourses') }}</span></a></li>
                    <li><a href="/product-groups"><i class="fa fa-circle-o"></i> <span>{{ trans('adminlte_lang::message.productgroups') }}</span></a></li>
                    <li><a href="/user-roles"><i class="fa fa-circle-o"></i> <span>{{ trans('adminlte_lang::message.userroles') }}</span></a></li>
                  </ul>
                </li>
                <li><a href="/users"><i class="fa fa-user"></i> <span>{{ trans('adminlte_lang::message.users') }}</span></a></li>
                <li><a href="/import"><i class="fa fa-arrow-circle-down"></i> <span>{{ trans('adminlte_lang::message.import') }}</span></a></li>
            @endif
            </li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
