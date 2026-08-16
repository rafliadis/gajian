/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class',
  content: [
    "./index.html",
    "./src/**/*.{js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        darkBg: '#090d16',
        darkCard: '#0f172a',
        darkSidebar: '#070b13',
        neonPurple: '#a855f7',
        neonIndigo: '#6366f1',
        neonCyan: '#06b6d4',
      },
      boxShadow: {
        glowPurple: '0 0 15px rgba(168, 85, 247, 0.4)',
        glowCyan: '0 0 15px rgba(6, 182, 212, 0.4)',
      }
    },
  },
  plugins: [],
}
