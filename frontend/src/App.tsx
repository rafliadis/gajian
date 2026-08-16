import { getAppData } from './utils/appData';
import { Login } from './pages/Login';
import { AdminDashboard } from './pages/AdminDashboard';
import { KaryawanPortal } from './pages/KaryawanPortal';

function App() {
  const appData = getAppData();

  // Client-side Session Routing Fallback
  if (!appData.isLoggedIn) {
    return <Login />;
  }

  if (appData.user?.role === 'admin') {
    return <AdminDashboard />;
  }

  if (appData.user?.role === 'karyawan') {
    return <KaryawanPortal />;
  }

  // Fallback default (tampilkan login jika role tidak dikenali)
  return <Login />;
}

export default App;
