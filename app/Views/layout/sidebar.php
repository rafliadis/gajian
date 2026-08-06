<div class="sidebar">
    <h3>Menu Admin</h3>
    <a href="/dashboard">Dashboard</a>
    <a href="/jabatan">Data Jabatan</a>
    <a href="/karyawan">Data Karyawan</a>
    
    <div class="logout-section" style="margin-top: auto; padding: 20px;">
        <a href="<?= base_url('login/logout') ?>"
           onclick="return confirm('Apakah Anda yakin ingin keluar?')">
           Keluar
        </a>
    </div>
</div>