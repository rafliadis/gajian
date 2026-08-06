<!-- Contoh di dalam file header atau navbar -->
<div class="navbar-menu">
    <!-- Menu lainnya (Jabatan, Karyawan, dll) -->
    
    <!-- Tombol Logout -->
    <a href="<?= base_url('login/logout') ?>"
       class="logout-btn"
       onclick="return confirm('Apakah Anda yakin ingin keluar dari sistem?')">
       Keluar
    </a>
</div>