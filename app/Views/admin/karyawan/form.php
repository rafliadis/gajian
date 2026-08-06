<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title"><?= esc($title) ?></h2>
        <a href="<?= base_url('admin/karyawan') ?>" class="btn btn-ghost btn-sm">⬅️ Kembali</a>
    </div>

    <form action="<?= $karyawan ? base_url('admin/karyawan/update/' . $karyawan['id_karyawan']) : base_url('admin/karyawan/save') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 32px;">
            <!-- KOLOM KIRI: data diri -->
            <div>
                <h3 style="font-size: 15px; color: var(--primary-light); border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: 8px; margin-bottom: 16px;">👤 Informasi Pribadi</h3>
                
                <div class="form-group">
                    <label class="form-label" for="nama_karyawan">Nama Lengkap <span style="color:var(--danger)">*</span></label>
                    <input type="text" class="form-control" id="nama_karyawan" name="nama_karyawan" value="<?= old('nama_karyawan', $karyawan['nama_karyawan'] ?? '') ?>" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="nik">NIK (Nomor Induk Kependudukan)</label>
                        <input type="text" class="form-control" id="nik" name="nik" value="<?= old('nik', $karyawan['nik'] ?? '') ?>" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="npwp">NPWP</label>
                        <input type="text" class="form-control" id="npwp" name="npwp" value="<?= old('npwp', $karyawan['npwp'] ?? '') ?>" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="jenis_kelamin">Jenis Kelamin</label>
                        <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                            <option value="L" <?= old('jenis_kelamin', $karyawan['jenis_kelamin'] ?? 'L') === 'L' ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="P" <?= old('jenis_kelamin', $karyawan['jenis_kelamin'] ?? '') === 'P' ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="tanggal_lahir">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= old('tanggal_lahir', $karyawan['tanggal_lahir'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="alamat">Alamat Lengkap</label>
                    <textarea class="form-control" id="alamat" name="alamat"><?= old('alamat', $karyawan['alamat'] ?? '') ?></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="no_hp">No. HP / WhatsApp</label>
                        <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?= old('no_hp', $karyawan['no_hp'] ?? '') ?>" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="email">Alamat Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= old('email', $karyawan['email'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="foto">Foto Profil</label>
                    <?php if ($karyawan && $karyawan['foto']): ?>
                        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 10px;">
                            <img src="<?= base_url('uploads/karyawan/' . $karyawan['foto']) ?>" alt="Foto Karyawan" style="width: 50px; height: 50px; border-radius: 8px; object-fit: cover; border: 1px solid var(--card-border);">
                            <span style="font-size: 12px; color: var(--text-dim);">Akan diganti jika Anda mengunggah foto baru.</span>
                        </div>
                    <?php endif; ?>
                    <input type="file" class="form-control" id="foto" name="foto" accept="image/*" style="padding: 8px;">
                </div>
            </div>

            <!-- KOLOM KANAN: kepegawaian & keuangan -->
            <div>
                <h3 style="font-size: 15px; color: var(--primary-light); border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: 8px; margin-bottom: 16px;">💼 Kepegawaian & Finansial</h3>

                <div class="form-group">
                    <label class="form-label" for="id_jabatan">Jabatan Kepegawaian <span style="color:var(--danger)">*</span></label>
                    <select class="form-control" id="id_jabatan" name="id_jabatan" required>
                        <option value="">-- Pilih Jabatan --</option>
                        <?php foreach ($jabatan as $j): ?>
                            <option value="<?= $j['id_jabatan'] ?>" <?= old('id_jabatan', $karyawan['id_jabatan'] ?? '') == $j['id_jabatan'] ? 'selected' : '' ?>>
                                <?= esc($j['nama_jabatan']) ?> (<?= esc($j['nama_departemen'] ?? 'No Dept') ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="tanggal_masuk">Tanggal Masuk Kerja <span style="color:var(--danger)">*</span></label>
                        <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk" value="<?= old('tanggal_masuk', $karyawan['tanggal_masuk'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="status_pernikahan">Status Pernikahan (PTKP)</label>
                        <select class="form-control" id="status_pernikahan" name="status_pernikahan">
                            <option value="TK" <?= old('status_pernikahan', $karyawan['status_pernikahan'] ?? 'TK') === 'TK' ? 'selected' : '' ?>>TK (Tidak Kawin)</option>
                            <option value="K0" <?= old('status_pernikahan', $karyawan['status_pernikahan'] ?? '') === 'K0' ? 'selected' : '' ?>>K0 (Kawin, 0 Tanggungan)</option>
                            <option value="K1" <?= old('status_pernikahan', $karyawan['status_pernikahan'] ?? '') === 'K1' ? 'selected' : '' ?>>K1 (Kawin, 1 Tanggungan)</option>
                            <option value="K2" <?= old('status_pernikahan', $karyawan['status_pernikahan'] ?? '') === 'K2' ? 'selected' : '' ?>>K2 (Kawin, 2 Tanggungan)</option>
                            <option value="K3" <?= old('status_pernikahan', $karyawan['status_pernikahan'] ?? '') === 'K3' ? 'selected' : '' ?>>K3 (Kawin, 3 Tanggungan)</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="nama_bank">Nama Bank</label>
                        <input type="text" class="form-control" id="nama_bank" name="nama_bank" placeholder="Contoh: BCA, Mandiri" value="<?= old('nama_bank', $karyawan['nama_bank'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="no_rekening">Nomor Rekening</label>
                        <input type="text" class="form-control" id="no_rekening" name="no_rekening" value="<?= old('no_rekening', $karyawan['no_rekening'] ?? '') ?>" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="no_bpjs_kesehatan">No. BPJS Kesehatan</label>
                        <input type="text" class="form-control" id="no_bpjs_kesehatan" name="no_bpjs_kesehatan" value="<?= old('no_bpjs_kesehatan', $karyawan['no_bpjs_kesehatan'] ?? '') ?>" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="no_bpjs_tk">No. BPJS Ketenagakerjaan</label>
                        <input type="text" class="form-control" id="no_bpjs_tk" name="no_bpjs_tk" value="<?= old('no_bpjs_tk', $karyawan['no_bpjs_tk'] ?? '') ?>" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>
                </div>

                <?php if ($karyawan): ?>
                    <div class="form-group">
                        <label class="form-label" for="status">Status Kepegawaian</label>
                        <select class="form-control" id="status" name="status">
                            <option value="aktif" <?= old('status', $karyawan['status'] ?? 'aktif') === 'aktif' ? 'selected' : '' ?>>Aktif</option>
                            <option value="nonaktif" <?= old('status', $karyawan['status'] ?? '') === 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                        </select>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div style="margin-top: 24px; border-top: 1px solid rgba(255,255,255,0.06); padding-top: 20px; display: flex; justify-content: flex-end; gap: 12px;">
            <a href="<?= base_url('admin/karyawan') ?>" class="btn btn-ghost">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Karyawan</button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
