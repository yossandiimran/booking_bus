<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-primary">
                <li class="nav-item {{ request()->is('admin/beranda') || request()->is('admin/beranda/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.index') }}">
                        <i class="fas fa-home"></i>
                        <p>Beranda</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Master Data</h4>
                </li>
                @if(permission([1,2,3,5]))
                <li class="nav-item {{ request()->is('admin/master/bus') || request()->is('admin/master/bus/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.master.bus.index') }}">
                        <i class="fas fa-bus"></i>
                        <p>Bus</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('admin/master/sopir') || request()->is('admin/master/sopir/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.master.sopir.index') }}">
                        <i class="fas fa-users"></i>
                        <p>Sopir</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('admin/master/tempat') || request()->is('admin/master/tempat/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.master.tempat.index') }}">
                        <i class="fas fa-map"></i>
                        <p>Tempat</p>
                    </a>
                </li>
                @endif
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Transaksi</h4>
                </li>
                <li class="nav-item {{ request()->is('admin/transaksi') || request()->is('admin/transaksi/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.transaksi.index') }}">
                        <i class="fas fa-paste"></i>
                        <p>Transaksi</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('admin/laporan') || request()->is('admin/laporan/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.laporan.index') }}">
                        <i class="fas fa-file-pdf"></i>
                        <p>Laporan</p>
                    </a>
                </li>
                @if(permission([1,2,3,5]))
                 
                @endif
            </ul>
        </div>
    </div>
</div>