import { getAppData } from '../utils/appData';
import {
  Users, Calendar, Activity, Layers,
  FolderPlus, DollarSign,
  Plus, Play, Key, FileBarChart, LogOut, LayoutDashboard, ChevronRight
} from 'lucide-react';
import { motion } from 'motion/react';

export const AdminDashboard: React.FC = () => {
  const appData = getAppData();
  const stats = appData.stats;
  const logs = appData.aktivitas || [];

  const handleLogout = () => {
    window.location.href = `${appData.apiUrl}/login/logout`;
  };

  // Navigasi Master Data & Penggajian yang terhubung ke controller asli
  // di backend CI4 untuk fallback jika diklik.
  const handleNav = (path: string) => {
    window.location.href = `${appData.apiUrl}/${path}`;
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
              <span className="text-[10px] text-violet-400 font-semibold tracking-widest uppercase">Admin Panel</span>
            </div>
          </div>

          {/* Nav List */}
          <nav className="space-y-6">
            <div>
              <span className="text-[10px] font-bold uppercase tracking-wider text-slate-500 block mb-3 px-3">Utama</span>
              <button
                onClick={() => handleNav('admin/dashboard')}
                className="w-full flex items-center gap-3 px-4 py-3 rounded-xl bg-violet-600/10 text-violet-400 border border-violet-500/20 text-sm font-semibold transition"
              >
                <LayoutDashboard className="w-4 h-4" /> Dashboard
              </button>
            </div>

            <div>
              <span className="text-[10px] font-bold uppercase tracking-wider text-slate-500 block mb-3 px-3">Master Data</span>
              <div className="space-y-1">
                {[
                  { label: 'Departemen', path: 'admin/departemen' },
                  { label: 'Jabatan', path: 'admin/jabatan' },
                  { label: 'Data Karyawan', path: 'admin/karyawan' },
                ].map(item => (
                  <button
                    key={item.label}
                    onClick={() => handleNav(item.path)}
                    className="w-full flex items-center justify-between px-4 py-2.5 rounded-xl text-slate-400 hover:text-slate-200 hover:bg-slate-800/40 text-sm font-medium transition text-left"
                  >
                    <span>{item.label}</span>
                    <ChevronRight className="w-3.5 h-3.5 opacity-45" />
                  </button>
                ))}
              </div>
            </div>

            <div>
              <span className="text-[10px] font-bold uppercase tracking-wider text-slate-500 block mb-3 px-3">Penggajian</span>
              <div className="space-y-1">
                {[
                  { label: 'Komponen Gaji', path: 'admin/komponen-gaji' },
                  { label: 'Proses Gaji (Payroll)', path: 'admin/payroll' },
                  { label: 'Slip Gaji', path: 'admin/slip-gaji' },
                  { label: 'Laporan Laba/Rugi', path: 'admin/laporan' },
                ].map(item => (
                  <button
                    key={item.label}
                    onClick={() => handleNav(item.path)}
                    className="w-full flex items-center justify-between px-4 py-2.5 rounded-xl text-slate-400 hover:text-slate-200 hover:bg-slate-800/40 text-sm font-medium transition text-left"
                  >
                    <span>{item.label}</span>
                    <ChevronRight className="w-3.5 h-3.5 opacity-45" />
                  </button>
                ))}
              </div>
            </div>
          </nav>
        </div>

        {/* User Profile / Logout */}
        <div className="border-t border-slate-800/40 pt-6">
          <div className="flex items-center gap-3 p-3 bg-slate-900/50 border border-slate-800/40 rounded-2xl mb-4">
            <div className="w-10 h-10 rounded-full bg-gradient-to-tr from-violet-600 to-indigo-600 flex items-center justify-center font-bold text-white uppercase text-sm">
              {appData.user?.username?.[0] || 'A'}
            </div>
            <div className="truncate">
              <div className="font-semibold text-sm truncate">{appData.user?.username || 'Administrator'}</div>
              <span className="text-[10px] text-violet-400 font-medium tracking-wider uppercase">Super Admin</span>
            </div>
          </div>
          <button
            onClick={handleLogout}
            className="flex items-center justify-center gap-2 w-full py-3 bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 border border-rose-500/20 rounded-xl transition duration-200 text-sm font-semibold"
          >
            <LogOut className="w-4 h-4" /> Keluar dari Sistem
          </button>
        </div>
      </aside>

      {/* ── MAIN CONTENT ── */}
      <main className="flex-1 overflow-y-auto p-10 bg-[#070b13]">

        {/* Header */}
        <header className="flex justify-between items-center mb-10">
          <div>
            <h1 className="text-3xl font-extrabold text-white tracking-tight font-sans">
              Dashboard Ringkasan
            </h1>
            <p className="text-slate-400 text-sm mt-1">Sistem Informasi Penggajian Kyu-Pay</p>
          </div>
          <div className="flex items-center gap-3">
            <button
              onClick={() => handleNav('admin/akun/ubah-password')}
              className="px-4 py-2.5 rounded-xl border border-slate-800 hover:border-slate-700 bg-slate-900/50 hover:bg-slate-900 text-slate-300 text-xs font-semibold flex items-center gap-2 transition"
            >
              <Key className="w-3.5 h-3.5" /> Ubah Password
            </button>
          </div>
        </header>

        {/* ── CARD STATISTIK RINGKASAN ── */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
          {[
            { label: 'Karyawan Aktif', value: stats?.activeEmployees || 0, icon: Users, color: 'text-violet-400', bg: 'bg-violet-500/10', border: 'border-violet-500/20' },
            { label: 'Periode Selesai', value: stats?.completedPeriods || 0, icon: Calendar, color: 'text-cyan-400', bg: 'bg-cyan-500/10', border: 'border-cyan-500/20' },
            { label: 'Penggajian Berjalan', value: stats?.runningPayroll || 0, icon: Activity, color: 'text-emerald-400', bg: 'bg-emerald-500/10', border: 'border-emerald-500/20' },
            { label: 'Total Periode', value: stats?.totalPeriods || 0, icon: Layers, color: 'text-fuchsia-400', bg: 'bg-fuchsia-500/10', border: 'border-fuchsia-500/20' },
          ].map((stat, idx) => (
            <motion.div
              initial={{ opacity: 0, y: 15 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ delay: idx * 0.1, duration: 0.4 }}
              key={stat.label}
              className={`p-6 rounded-2xl bg-[#0f172a]/70 border ${stat.border} shadow-xl flex items-center justify-between group hover:scale-[1.02] hover:shadow-2xl transition duration-300`}
            >
              <div>
                <span className="text-xs font-semibold text-slate-400 uppercase tracking-wider">{stat.label}</span>
                <p className="text-3xl font-extrabold text-white mt-2 font-mono">{stat.value}</p>
              </div>
              <div className={`w-12 h-12 rounded-xl ${stat.bg} ${stat.color} flex items-center justify-center transition-transform duration-300 group-hover:rotate-6`}>
                <stat.icon className="w-6 h-6" />
              </div>
            </motion.div>
          ))}
        </div>

        {/* ── PANEL STATUS & AKSI CEPAT ── */}
        <div className="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">

          {/* Status Penggajian Aktif */}
          <div className="lg:col-span-2 p-8 rounded-3xl bg-slate-900/60 border border-violet-500/10 shadow-2xl relative overflow-hidden flex flex-col justify-between">
            <div className="absolute top-0 right-0 w-64 h-64 bg-violet-600/5 rounded-full blur-3xl pointer-events-none" />
            <div>
              <div className="flex items-center gap-2 mb-4">
                <span className="w-2.5 h-2.5 rounded-full bg-violet-400 animate-pulse" />
                <span className="text-xs font-bold uppercase text-violet-400 tracking-widest">Siklus Penggajian Berjalan</span>
              </div>
              <h3 className="text-2xl font-extrabold text-white mb-2">Periode Agustus 2026</h3>
              <p className="text-slate-400 text-sm leading-relaxed max-w-lg mb-6">
                Proses rekap gaji bulan berjalan sedang berlangsung sebagai draf. Harap periksa lembar absensi, potongan komponen, dan tunjangan sebelum melakukan finalisasi slip gaji karyawan.
              </p>
            </div>
            <div className="flex flex-wrap gap-4 border-t border-slate-800/60 pt-6 mt-6">
              <button
                onClick={() => handleNav('admin/payroll')}
                className="px-6 py-3 rounded-xl bg-gradient-to-r from-violet-600 to-fuchsia-600 hover:from-violet-500 hover:to-fuchsia-500 text-white font-bold text-sm shadow-lg shadow-violet-500/25 hover:shadow-violet-500/35 transition flex items-center gap-2"
              >
                <Play className="w-4 h-4 fill-white" /> Proses & Finalisasi Gaji
              </button>
              <button
                onClick={() => handleNav('admin/slip-gaji')}
                className="px-6 py-3 rounded-xl border border-slate-800 bg-[#070b13] hover:border-slate-700 text-slate-300 font-semibold text-sm transition"
              >
                Review Draf Slip
              </button>
            </div>
          </div>

          {/* Aksi Cepat */}
          <div className="p-8 rounded-3xl bg-slate-900/60 border border-slate-800/40 shadow-2xl">
            <h3 className="text-lg font-bold text-white mb-6 font-sans">Aksi Cepat</h3>
            <div className="grid grid-cols-2 gap-4">
              {[
                { label: 'Karyawan Baru', icon: Plus, path: 'admin/karyawan/create', color: 'from-violet-600 to-indigo-600', shadow: 'shadow-violet-500/10' },
                { label: 'Proses Payroll', icon: DollarSign, path: 'admin/payroll/buat', color: 'from-cyan-600 to-emerald-600', shadow: 'shadow-cyan-500/10' },
                { label: 'Komponen Gaji', icon: FolderPlus, path: 'admin/komponen-gaji', color: 'from-fuchsia-600 to-pink-600', shadow: 'shadow-fuchsia-500/10' },
                { label: 'Lihat Laporan', icon: FileBarChart, path: 'admin/laporan', color: 'from-orange-600 to-amber-600', shadow: 'shadow-orange-500/10' },
              ].map(item => (
                <button
                  key={item.label}
                  onClick={() => handleNav(item.path)}
                  className="flex flex-col items-center justify-center p-5 rounded-2xl bg-[#070b13] border border-slate-800/60 hover:border-slate-700 hover:bg-[#0c1220]/60 transition duration-300 group text-center"
                >
                  <div className={`w-10 h-10 rounded-xl bg-gradient-to-br ${item.color} ${item.shadow} flex items-center justify-center text-white mb-3 group-hover:scale-110 transition duration-300`}>
                    <item.icon className="w-5 h-5" />
                  </div>
                  <span className="text-xs font-semibold text-slate-300 tracking-wide">{item.label}</span>
                </button>
              ))}
            </div>
          </div>
        </div>

        {/* ── TABEL AKTIVITAS TERKINI (AUDIT LOG) ── */}
        <div className="p-8 rounded-3xl bg-slate-900/60 border border-slate-800/40 shadow-2xl">
          <div className="flex justify-between items-center mb-6">
            <div>
              <h3 className="text-lg font-bold text-white font-sans">Aktivitas Terkini</h3>
              <p className="text-slate-500 text-xs mt-1">Audit log aktivitas user pada sistem</p>
            </div>
            <span className="px-3 py-1 text-[10px] font-bold text-cyan-400 bg-cyan-500/10 border border-cyan-500/20 rounded-full font-mono">
              REALTIME AUDIT
            </span>
          </div>

          <div className="overflow-x-auto">
            <table className="w-full text-left border-collapse">
              <thead>
                <tr className="border-b border-slate-800/80 text-[11px] font-bold text-slate-500 uppercase tracking-widest">
                  <th className="py-4 px-4">Waktu</th>
                  <th className="py-4 px-4">User</th>
                  <th className="py-4 px-4">Aksi</th>
                  <th className="py-4 px-4">Modul</th>
                  <th className="py-4 px-4">Keterangan</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-slate-800/40 text-sm">
                {logs.length === 0 ? (
                  <tr>
                    <td colSpan={5} className="py-8 text-center text-slate-500 text-xs">
                      Belum ada rekaman aktivitas log terbaru.
                    </td>
                  </tr>
                ) : (
                  logs.map((log, idx) => (
                    <tr key={idx} className="hover:bg-slate-800/10 transition">
                      <td className="py-4 px-4 text-xs font-mono text-slate-500">{log.waktu}</td>
                      <td className="py-4 px-4 font-semibold text-slate-300">{log.user}</td>
                      <td className="py-4 px-4">
                        <span className={`px-2 py-0.5 rounded text-[10px] font-bold ${
                          log.aksi === 'Finalisasi Payroll' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' :
                          log.aksi === 'Create' ? 'bg-violet-500/10 text-violet-400 border border-violet-500/20' :
                          'bg-slate-800 text-slate-400 border border-slate-700/50'
                        }`}>
                          {log.aksi}
                        </span>
                      </td>
                      <td className="py-4 px-4 font-mono text-xs text-slate-400">{log.modul}</td>
                      <td className="py-4 px-4 text-xs text-slate-400 max-w-xs truncate" title={log.keterangan}>
                        {log.keterangan}
                      </td>
                    </tr>
                  ))
                )}
              </tbody>
            </table>
          </div>
        </div>

      </main>
    </div>
  );
};
