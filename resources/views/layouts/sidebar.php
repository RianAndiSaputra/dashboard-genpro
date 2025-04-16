<div class="sidebar fixed top-0 left-0 h-screen w-[120px] bg-[#800020] text-white">
    <div class="logo font-bold text-xl text-center py-4 text-[#FFBF00]">GEN<br>PRO</div>
    
    <a href="/dashboard" class="sidebar-item flex flex-col items-center py-4 px-0 text-white no-underline text-xs {{ request()->is('dashboard') ? 'bg-white/10' : '' }}">
        <i data-lucide="layout-dashboard" class="w-5 h-5 mb-1"></i>
        Dashboard
    </a>
    
    <a href="/define-company" class="sidebar-item flex flex-col items-center py-4 px-0 text-white no-underline text-xs {{ request()->is('define-company') ? 'bg-white/10' : '' }}">
        <i data-lucide="building" class="w-5 h-5 mb-1"></i>
        Define Company
    </a>
    
    <a href="/summary-financial" class="sidebar-item flex flex-col items-center py-4 px-0 text-white no-underline text-xs {{ request()->is('summary-financial') ? 'bg-white/10' : '' }}">
        <i data-lucide="chart-pie" class="w-5 h-5 mb-1"></i>
        Summary Financial
    </a>
    
    <a href="/financial-report" class="sidebar-item flex flex-col items-center py-4 px-0 text-white no-underline text-xs {{ request()->is('financial-report') ? 'bg-white/10' : '' }}">
        <i data-lucide="file-text" class="w-5 h-5 mb-1"></i>
        Financial Report
    </a>
    
    <div class="absolute bottom-4 w-full flex justify-center">
        <button class="bg-red-900 text-white px-4 py-2 rounded flex items-center">
            <i data-lucide="log-out" class="w-4 h-4 mr-1"></i>
            Sign Out
        </button>
    </div>
</div>