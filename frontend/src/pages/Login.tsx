import { useState, ChangeEvent, FormEvent, ReactNode } from 'react';
import { getAppData } from '../utils/appData';
import { Loader2 } from 'lucide-react';
import { Ripple, AuthTabs, TechOrbitDisplay } from '../components/blocks/modern-animated-sign-in';

type FormData = {
  credential: string;
  password: string;
};

interface OrbitIcon {
  component: () => ReactNode;
  className: string;
  duration?: number;
  delay?: number;
  radius?: number;
  path?: boolean;
  reverse?: boolean;
}

const iconsArray: OrbitIcon[] = [
  {
    component: () => (
      <img
        width={30}
        height={30}
        src='https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/html5/html5-original.svg'
        alt='HTML5'
        className='w-[30px] h-[30px] object-contain'
      />
    ),
    className: 'size-[30px] border-none bg-transparent',
    duration: 20,
    delay: 20,
    radius: 100,
    path: false,
    reverse: false,
  },
  {
    component: () => (
      <img
        width={30}
        height={30}
        src='https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/css3/css3-original.svg'
        alt='CSS3'
        className='w-[30px] h-[30px] object-contain'
      />
    ),
    className: 'size-[30px] border-none bg-transparent',
    duration: 20,
    delay: 10,
    radius: 100,
    path: false,
    reverse: false,
  },
  {
    component: () => (
      <img
        width={50}
        height={50}
        src='https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/typescript/typescript-original.svg'
        alt='TypeScript'
        className='w-[50px] h-[50px] object-contain'
      />
    ),
    className: 'size-[50px] border-none bg-transparent',
    radius: 210,
    duration: 20,
    path: false,
    reverse: false,
  },
  {
    component: () => (
      <img
        width={50}
        height={50}
        src='https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/javascript/javascript-original.svg'
        alt='JavaScript'
        className='w-[50px] h-[50px] object-contain'
      />
    ),
    className: 'size-[50px] border-none bg-transparent',
    radius: 210,
    duration: 20,
    delay: 20,
    path: false,
    reverse: false,
  },
  {
    component: () => (
      <img
        width={30}
        height={30}
        src='https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/tailwindcss/tailwindcss-original.svg'
        alt='TailwindCSS'
        className='w-[30px] h-[30px] object-contain'
      />
    ),
    className: 'size-[30px] border-none bg-transparent',
    duration: 20,
    delay: 20,
    radius: 150,
    path: false,
    reverse: true,
  },
  {
    component: () => (
      <img
        width={30}
        height={30}
        src='https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/react/react-original.svg'
        alt='React'
        className='w-[30px] h-[30px] object-contain'
      />
    ),
    className: 'size-[30px] border-none bg-transparent',
    duration: 20,
    delay: 10,
    radius: 150,
    path: false,
    reverse: true,
  },
  {
    component: () => (
      <img
        width={50}
        height={50}
        src='https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/vitejs/vitejs-original.svg'
        alt='Vite'
        className='w-[50px] h-[50px] object-contain'
      />
    ),
    className: 'size-[50px] border-none bg-transparent',
    radius: 270,
    duration: 20,
    path: false,
    reverse: true,
  },
  {
    component: () => (
      <img
        width={50}
        height={50}
        src='https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/php/php-original.svg'
        alt='PHP'
        className='w-[50px] h-[50px] object-contain'
      />
    ),
    className: 'size-[50px] border-none bg-transparent',
    radius: 270,
    duration: 20,
    delay: 60,
    path: false,
    reverse: true,
  },
  {
    component: () => (
      <img
        width={50}
        height={50}
        src='https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/mysql/mysql-original.svg'
        alt='MySQL'
        className='w-[50px] h-[50px] object-contain'
      />
    ),
    className: 'size-[50px] border-none bg-transparent',
    radius: 320,
    duration: 20,
    delay: 20,
    path: false,
    reverse: false,
  },
];

export const Login: React.FC = () => {
  const appData = getAppData();
  const [formData, setFormData] = useState<FormData>({
    credential: '',
    password: '',
  });
  const [loading, setLoading] = useState(false);
  const [errorMsg, setErrorMsg] = useState('');

  const handleInputChange = (
    event: ChangeEvent<HTMLInputElement>,
    name: keyof FormData
  ) => {
    setFormData((prev) => ({ ...prev, [name]: event.target.value }));
  };

  const handleSubmit = async (_event: FormEvent<HTMLFormElement>) => {
    setLoading(true);
    setErrorMsg('');

    const formDataToSend = new FormData();
    formDataToSend.append('credential', formData.credential);
    formDataToSend.append('password', formData.password);

    const csrfHeader =
      document.querySelector('meta[name="csrf-header"]')?.getAttribute('content') || '';
    const csrfToken =
      document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    try {
      const response = await fetch(`${appData.apiUrl}/login/auth`, {
        method: 'POST',
        headers: { [csrfHeader]: csrfToken },
        body: formDataToSend,
      });

      if (response.redirected) {
        window.location.href = response.url;
      } else {
        const text = await response.text();
        if (text.includes('alert-error') || text.includes('⚠️')) {
          setErrorMsg('Username/Email atau Password salah.');
        } else {
          window.location.reload();
        }
      }
    } catch (err) {
      setErrorMsg('Gagal terhubung ke server. Silakan coba lagi.');
      console.error(err);
    } finally {
      setLoading(false);
    }
  };

  const formFields = {
    header: 'Selamat Datang',
    subHeader: 'Masuk ke Kyu-Pay — Sistem Informasi Penggajian',
    fields: [
      {
        label: 'Username atau Email',
        required: true,
        type: 'text' as const,
        placeholder: 'Masukkan username atau email',
        onChange: (event: ChangeEvent<HTMLInputElement>) =>
          handleInputChange(event, 'credential'),
      },
      {
        label: 'Password',
        required: true,
        type: 'password' as const,
        placeholder: 'Masukkan password',
        onChange: (event: ChangeEvent<HTMLInputElement>) =>
          handleInputChange(event, 'password'),
      },
    ],
    submitButton: loading ? 'Memproses...' : 'Masuk ke Sistem',
    textVariantButton: 'Lupa password?',
  };

  const goToForgotPassword = (
    event: React.MouseEvent<HTMLButtonElement>
  ) => {
    event.preventDefault();
    console.log('forgot password');
  };

  return (
    <div className='min-h-screen flex relative overflow-hidden bg-white dark:bg-[#070b14]'>
      {/* Left Side — Orbit Display */}
      <div className='hidden lg:flex flex-col justify-center w-1/2 relative'>
        {/* Background glow for left panel */}
        <div className='absolute inset-0 z-0'>
          <div className='absolute top-[-10%] left-[-10%] w-[600px] h-[600px] rounded-full bg-violet-900/10 blur-[120px] animate-pulse-glow' />
          <div
            className='absolute bottom-[-10%] right-[-10%] w-[500px] h-[500px] rounded-full bg-cyan-900/10 blur-[120px] animate-pulse-glow'
            style={{ animationDelay: '3s' }}
          />
        </div>
        <Ripple mainCircleSize={100} />
        <TechOrbitDisplay iconsArray={iconsArray} text='Kyu-Pay' />
      </div>

      {/* Right Side — Login Form */}
      <div className='w-full lg:w-1/2 flex flex-col justify-center items-center px-6 lg:px-16 relative z-10'>
        {/* Mobile brand header */}
        <div className='lg:hidden text-center mb-8'>
          <h1 className='text-3xl font-extrabold tracking-wider bg-clip-text text-transparent bg-gradient-to-r from-violet-400 via-fuchsia-400 to-cyan-400 mb-1'>
            Kyu-Pay
          </h1>
          <div className='inline-flex items-center gap-2 px-3 py-1 rounded-full bg-violet-500/10 border border-violet-500/20 text-xs font-semibold text-violet-300'>
            <span className='w-1.5 h-1.5 rounded-full bg-violet-400 animate-ping' />
            SISTEM INFORMASI PENGGAJIAN
          </div>
        </div>

        {/* Loading overlay */}
        {loading && (
          <div className='absolute inset-0 flex items-center justify-center bg-white/60 dark:bg-black/60 z-50'>
            <Loader2 className='w-8 h-8 animate-spin text-violet-500' />
          </div>
        )}

        <AuthTabs
          formFields={formFields}
          goTo={goToForgotPassword}
          handleSubmit={handleSubmit}
          errorField={errorMsg}
        />

        {/* Version Info */}
        <div className='mt-8 text-center'>
          <span className='text-xs text-slate-500 dark:text-slate-500 font-mono tracking-wider'>
            Kyu-Pay &nbsp;·&nbsp; v1.0 MVP
          </span>
        </div>
      </div>
    </div>
  );
};
