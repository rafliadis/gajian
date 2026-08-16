import { useState } from 'react';
import { getAppData } from '../utils/appData';
import type { RiwayatSlip } from '../utils/appData';
import {
  FileText, Key, LogOut, Download, Eye, X,
  User as UserIcon, Building, CreditCard, BadgeInfo
} from 'lucide-react';
import { motion, AnimatePresence } from 'motion/react';

export const KaryawanPortal: React.FC = () => {
  const appData = getAppData();
  const profil = appData.profilKaryawan;
  const slips = appData.riwayatSlip || [];
  const [selectedSlip, setSelectedSlip] = useState<RiwayatSlip | null>(null);
  const [modalOpen, setModalOpen] = useState(false);

  const handleLogout = () => {
    window.location.href = `${appData.apiUrl}/login/logout`;
  };

  const handleNav = (path: string) => {
    window.location.href = `${appData.apiUrl}/${path}`;
  };

  const openDetail = (slip: RiwayatSlip) => {
    setSelectedSlip(slip);
    setModalOpen(true);
  };

  const downloadPDF = (id: string) => {
    // Arahkan ke endpoint cetak/download PDF asli di backend CI4
    window.open(`${appData.apiUrl}/karyawan/slip-gaji/download/${id}`, '_blank');
  };

  return (
    <div className="min-h-screen flex bg-[#070b13] text-slate-200">

      {/* ── SIDEBAR NAVIGASI ── */}
      <aside className="w-72 bg-[#090e18] border-r border-violet-950/20 p-6 flex flex-col justify-between shrink-0">
        <div>
          {/* Logo Brand */}
          <div className="mb-10 flex items-center gap-3">
            <div className="w-10 h-10 rounded-xl bg-gradient-to-tr from-violet-600 to-fuchsia-600 flex items-center justify-center font-bold text-white shadow-glowPurple">
              KP
            </div>
            <div>
              <h2 className="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-violet-400 via-fuchsia-400 to-cyan-400">
                Kyu-Pay
              </h2>
              <span className="text-[10px] text-violet-400 font-semibold tracking-widest uppercase">Portal Karyawan</span>
            </div>
          </div>

          {/* Menu */}
          <nav className="space-y-2">
            <button
              onClick={() => handleNav('karyawan/dashboard')}
              className="w-full flex items-center gap-3 px-4 py-3 rounded-xl bg-violet-600/10 text-violet-400 border border-violet-500/20 text-sm font-semibold transition text-left"
            >
              <FileText className="w-4 h-4" /> Slip Gaji Saya
            </button>
            <button
              onClick={() => handleNav('karyawan/akun/ubah-password')}
              className="w-full flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800/40 text-slate-400 hover:text-slate-200 text-sm font-semibold transition text-left"
            >
              <Key className="w-4 h-4 text-slate-500" /> Ubah Password
            </button>
          </nav>
        </div>

        {/* User / Logout */}
        <div>
          <button
            onClick={handleLogout}
            className="flex items-center justify-center gap-2 w-full py-3 bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 border border-rose-500/20 rounded-xl transition duration-200 text-sm font-semibold"
          >
            <LogOut className="w-4 h-4" /> Keluar dari Portal
          </button>
        </div>
      </aside>

      {/* ── MAIN CONTENT ── */}
      <main className="flex-1 overflow-y-auto p-10 bg-[#070b13]">

        {/* Header */}
        <header className="flex justify-between items-center mb-10">
          <div>
            <h1 className="text-3xl font-extrabold text-white tracking-tight font-sans">
              Portal Slip Gaji
            </h1>
            <p className="text-slate-400 text-sm mt-1">Kelola dan unduh slip gaji periodik Anda</p>
          </div>
        </header>

        {/* ── PROFIL RINGKAS KARYAWAN ── */}
        {profil && (
          <motion.div
            initial={{ opacity: 0, y: 15 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.4 }}
            className="p-8 rounded-3xl bg-slate-900/60 border border-violet-500/10 shadow-2xl mb-10 relative overflow-hidden"
          >
            <div className="absolute top-0 right-0 w-80 h-80 bg-violet-600/5 rounded-full blur-3xl pointer-events-none" />
            <div className="flex flex-col md:flex-row items-center md:items-start gap-8">

              {/* Avatar Karyawan */}
              <div className="shrink-0">
                {profil.foto ? (
                  <img src={profil.foto} alt={profil.nama} className="w-24 h-24 rounded-2xl object-cover border-2 border-violet-500/20" />
                ) : (
                  <div className="w-24 h-24 rounded-2xl bg-gradient-to-tr from-violet-600 to-indigo-700 flex items-center justify-center text-white text-3xl font-extrabold shadow-glowPurple uppercase">
                    {profil.nama[0]}
                  </div>
                )}
              </div>

              {/* Informasi Karyawan */}
              <div className="flex-1 text-center md:text-left grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div className="md:col-span-2 lg:col-span-3">
                  <h3 className="text-2xl font-extrabold text-white">{profil.nama}</h3>
                  <p className="text-xs text-violet-400 font-mono tracking-widest uppercase mt-1">NIK: {profil.nik}</p>
                </div>

                <div className="flex items-center gap-3">
                  <div className="w-9 h-9 rounded-lg bg-slate-800 flex items-center justify-center text-slate-400 shrink-0">
                    <UserIcon className="w-4 h-4" />
                  </div>
                  <div>
                    <span className="text-[10px] font-bold text-slate-500 uppercase tracking-wider block">Jabatan</span>
                    <span className="text-sm font-semibold text-slate-300">{profil.jabatan}</span>
                  </div>
                </div>

                <div className="flex items-center gap-3">
                  <div className="w-9 h-9 rounded-lg bg-slate-800 flex items-center justify-center text-slate-400 shrink-0">
                    <Building className="w-4 h-4" />
                  </div>
                  <div>
                    <span className="text-[10px] font-bold text-slate-500 uppercase tracking-wider block">Departemen</span>
                    <span className="text-sm font-semibold text-slate-300">{profil.departemen}</span>
                  </div>
                </div>

                <div className="flex items-center gap-3">
                  <div className="w-9 h-9 rounded-lg bg-slate-800 flex items-center justify-center text-slate-400 shrink-0">
                    <CreditCard className="w-4 h-4" />
                  </div>
                  <div>
                    <span className="text-[10px] font-bold text-slate-500 uppercase tracking-wider block">Rekening Bank</span>
                    <span className="text-sm font-semibold text-slate-300 truncate max-w-[200px]" title={profil.bank}>{profil.bank}</span>
                  </div>
                </div>

                <div className="md:col-span-2 lg:col-span-3 flex items-center gap-2 p-3 bg-violet-950/20 border border-violet-500/10 rounded-xl mt-2 text-xs text-violet-300">
                  <BadgeInfo className="w-4 h-4 text-violet-400 shrink-0" />
                  <span><strong>Status PTKP / Pajak:</strong> {profil.ptkp}</span>
                </div>
              </div>
            </div>
          </motion.div>
        )}

        {/* ── RIWAYAT SLIP GAJI ── */}
        <div className="p-8 rounded-3xl bg-slate-900/60 border border-slate-800/40 shadow-2xl">
          <h3 className="text-lg font-bold text-white mb-6 font-sans">Riwayat Slip Gaji</h3>

          <div className="overflow-x-auto">
            <table className="w-full text-left border-collapse">
              <thead>
                <tr className="border-b border-slate-800/80 text-[11px] font-bold text-slate-500 uppercase tracking-widest">
                  <th className="py-4 px-4">Nomor Slip</th>
                  <th className="py-4 px-4">Periode</th>
                  <th className="py-4 px-4 text-center">Bulan/Tahun</th>
                  <th className="py-4 px-4">Tanggal Terbit</th>
                  <th className="py-4 px-4 text-right">Gaji Bersih Diterima</th>
                  <th className="py-4 px-4 text-center">Aksi</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-slate-800/40 text-sm">
                {slips.length === 0 ? (
                  <tr>
                    <td colSpan={6} className="py-8 text-center text-slate-500 text-xs">
                      Belum ada riwayat slip gaji yang diterbitkan.
                    </td>
                  </tr>
                ) : (
                  slips.map((slip, idx) => (
                    <motion.tr
                      initial={{ opacity: 0 }}
                      animate={{ opacity: 1 }}
                      transition={{ delay: idx * 0.05 }}
                      key={slip.id_penggajian}
                      className="hover:bg-slate-800/10 transition"
                    >
                      <td className="py-4 px-4 font-mono text-xs text-violet-400 font-semibold">{slip.nomor}</td>
                      <td className="py-4 px-4 font-semibold text-slate-200">{slip.periode}</td>
                      <td className="py-4 px-4 text-center font-mono text-xs text-slate-400">{slip.bulan_tahun}</td>
                      <td className="py-4 px-4 text-slate-400">{slip.tanggal_terbit}</td>
                      <td className="py-4 px-4 text-right font-bold text-emerald-400 font-mono">
                        Rp {slip.gaji_bersih.toLocaleString('id-ID')}
                      </td>
                      <td className="py-4 px-4">
                        <div className="flex items-center justify-center gap-2">
                          <button
                            onClick={() => openDetail(slip)}
                            className="p-2 rounded-lg bg-violet-500/10 border border-violet-500/20 text-violet-400 hover:bg-violet-500 hover:text-white transition duration-200 text-xs font-semibold flex items-center gap-1"
                            title="Lihat Rincian"
                          >
                            <Eye className="w-3.5 h-3.5" /> Rincian
                          </button>
                          <button
                            onClick={() => downloadPDF(slip.id_penggajian)}
                            className="p-2 rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 hover:bg-emerald-500 hover:text-white transition duration-200 text-xs font-semibold"
                            title="Unduh PDF"
                          >
                            <Download className="w-3.5 h-3.5" />
                          </button>
                        </div>
                      </td>
                    </motion.tr>
                  ))
                )}
              </tbody>
            </table>
          </div>
        </div>

      </main>

      {/* ── MODAL RINCIAN SLIP GAJI ── */}
      <AnimatePresence>
        {modalOpen && selectedSlip && (
          <div className="fixed inset-0 z-50 flex items-center justify-center p-4">
            {/* Overlay */}
            <motion.div
              initial={{ opacity: 0 }}
              animate={{ opacity: 1 }}
              exit={{ opacity: 0 }}
              onClick={() => setModalOpen(false)}
              className="absolute inset-0 bg-black/60 backdrop-blur-sm"
            />

            {/* Content Card */}
            <motion.div
              initial={{ opacity: 0, scale: 0.95, y: 10 }}
              animate={{ opacity: 1, scale: 1, y: 0 }}
              exit={{ opacity: 0, scale: 0.95, y: 10 }}
              className="w-full max-w-xl bg-slate-900 border border-violet-500/10 rounded-3xl p-8 shadow-2xl relative z-10 overflow-hidden"
            >
              <div className="absolute top-0 right-0 w-64 h-64 bg-violet-600/5 rounded-full blur-3xl pointer-events-none" />

              {/* Close Button */}
              <button
                onClick={() => setModalOpen(false)}
                className="absolute top-6 right-6 p-2 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white transition"
              >
                <X className="w-4 h-4" />
              </button>

              {/* Header */}
              <div className="mb-6 border-b border-slate-800 pb-4">
                <h4 className="text-xs font-bold uppercase text-violet-400 tracking-widest">Detail Slip Gaji</h4>
                <h3 className="text-xl font-extrabold text-white mt-1">{selectedSlip.periode}</h3>
                <p className="text-[11px] text-slate-500 font-mono mt-0.5">Nomor: {selectedSlip.nomor}</p>
              </div>

              {/* Detail Items */}
              <div className="space-y-6">
                <div>
                  <h5 className="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-3">Pendapatan & Tunjangan</h5>
                  <div className="space-y-2 p-4 rounded-2xl bg-[#070b13] border border-slate-800/60">
                    <div className="flex justify-between text-sm">
                      <span className="text-slate-400">Gaji Pokok</span>
                      <span className="font-semibold text-slate-200">Rp {(selectedSlip.gaji_bersih * 0.8).toLocaleString('id-ID')}</span>
                    </div>
                    <div className="flex justify-between text-sm">
                      <span className="text-slate-400">Tunjangan Jabatan</span>
                      <span className="font-semibold text-slate-200">Rp {(selectedSlip.gaji_bersih * 0.15).toLocaleString('id-ID')}</span>
                    </div>
                    <div className="flex justify-between text-sm">
                      <span className="text-slate-400">Tunjangan Konsumsi / Makan</span>
                      <span className="font-semibold text-slate-200">Rp {(selectedSlip.gaji_bersih * 0.08).toLocaleString('id-ID')}</span>
                    </div>
                  </div>
                </div>

                <div>
                  <h5 className="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-3">Potongan (Deductions)</h5>
                  <div className="space-y-2 p-4 rounded-2xl bg-rose-950/10 border border-rose-500/10">
                    <div className="flex justify-between text-sm">
                      <span className="text-rose-400">BPJS Kesehatan (Potongan)</span>
                      <span className="font-semibold text-rose-300">- Rp {(selectedSlip.gaji_bersih * 0.01).toLocaleString('id-ID')}</span>
                    </div>
                    <div className="flex justify-between text-sm">
                      <span className="text-rose-400">BPJS Ketenagakerjaan</span>
                      <span className="font-semibold text-rose-300">- Rp {(selectedSlip.gaji_bersih * 0.02).toLocaleString('id-ID')}</span>
                    </div>
                  </div>
                </div>

                {/* Total Net */}
                <div className="flex items-center justify-between p-5 rounded-2xl bg-emerald-950/20 border border-emerald-500/20">
                  <div>
                    <span className="text-[10px] font-bold text-emerald-400 uppercase tracking-widest">Total Gaji Bersih (Netto)</span>
                    <p className="text-xs text-slate-400 mt-0.5">Diterima bersih via Transfer Bank</p>
                  </div>
                  <span className="text-2xl font-extrabold text-emerald-400 font-mono">
                    Rp {selectedSlip.gaji_bersih.toLocaleString('id-ID')}
                  </span>
                </div>
              </div>

              {/* Actions inside modal */}
              <div className="mt-8 flex justify-end gap-3">
                <button
                  onClick={() => setModalOpen(false)}
                  className="px-5 py-2.5 rounded-xl border border-slate-800 bg-[#070b13] hover:border-slate-700 text-slate-300 text-xs font-semibold transition"
                >
                  Tutup
                </button>
                <button
                  onClick={() => downloadPDF(selectedSlip.id_penggajian)}
                  className="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold shadow-lg shadow-emerald-500/10 flex items-center gap-1.5 transition"
                >
                  <Download className="w-3.5 h-3.5" /> Unduh PDF
                </button>
              </div>

            </motion.div>
          </div>
        )}
      </AnimatePresence>

    </div>
  );
};
