export interface User {
  id: number | null;
  username: string | null;
  email: string | null;
  role: 'admin' | 'karyawan' | null;
  id_karyawan: number | null;
  nama_karyawan: string | null;
}

export interface Stats {
  activeEmployees: number;
  totalPeriods: number;
  completedPeriods: number;
  runningPayroll: number;
}

export interface LogAktivitas {
  waktu: string;
  user: string;
  aksi: string;
  modul: string;
  keterangan: string;
}

export interface ProfilKaryawan {
  foto: string | null;
  nama: string;
  nik: string;
  jabatan: string;
  departemen: string;
  bank: string;
  ptkp: string;
}

export interface RiwayatSlip {
  id_penggajian: string;
  nomor: string;
  periode: string;
  bulan_tahun: string;
  tanggal_terbit: string;
  gaji_bersih: number;
}

export interface AppData {
  isLoggedIn: boolean;
  user: User | null;
  apiUrl: string;
  stats?: Stats;
  aktivitas?: LogAktivitas[];
  profilKaryawan?: ProfilKaryawan | null;
  riwayatSlip?: RiwayatSlip[];
}

declare global {
  interface Window {
    __APP_DATA__?: AppData;
  }
}

// Default fallback data for development/preview
const defaultAppData: AppData = {
  isLoggedIn: false,
  user: null,
  apiUrl: window.location.origin,
  stats: {
    activeEmployees: 12,
    totalPeriods: 5,
    completedPeriods: 4,
    runningPayroll: 1,
  },
  aktivitas: [
    { waktu: '2026-08-11 08:30:22', user: 'admin', aksi: 'Finalisasi Payroll', modul: 'payroll_periode', keterangan: 'Finalisasi periode Juli 2026' },
    { waktu: '2026-08-10 14:15:10', user: 'admin', aksi: 'Create', modul: 'karyawan', keterangan: 'Menambahkan karyawan baru: Rafli Adi S' },
    { waktu: '2026-08-09 09:00:00', user: 'system', aksi: 'Reset Password', modul: 'users', keterangan: 'Reset password karyawan ID: 3' },
  ],
  profilKaryawan: {
    foto: null,
    nama: 'Rafli Adi Septiyan',
    nik: '3273210908980003',
    jabatan: 'Senior Software Engineer',
    departemen: 'Technology / IT',
    bank: 'Bank Central Asia (BCA) - 8720192831',
    ptkp: 'TK/0 (Belum Kawin, Tanpa Tanggungan)'
  },
  riwayatSlip: [
    { id_penggajian: '12', nomor: 'PAY/202607/001', periode: 'Juli 2026', bulan_tahun: '07/2026', tanggal_terbit: '2026-07-28', gaji_bersih: 9500000 },
    { id_penggajian: '8', nomor: 'PAY/202606/001', periode: 'Juni 2026', bulan_tahun: '06/2026', tanggal_terbit: '2026-06-28', gaji_bersih: 9200000 },
    { id_penggajian: '4', nomor: 'PAY/202605/001', periode: 'Mei 2026', bulan_tahun: '05/2026', tanggal_terbit: '2026-05-28', gaji_bersih: 9200000 },
  ]
};

export const getAppData = (): AppData => {
  if (typeof window !== 'undefined' && window.__APP_DATA__) {
    // Merge database statistics and details with URL
    return {
      ...defaultAppData,
      ...window.__APP_DATA__,
    };
  }
  return defaultAppData;
};
