// kalau kamu punya resources/js/bootstrap.js bawaan laravel, boleh import juga
try { await import('./bootstrap.js'); } catch(e) { /* ignore jika file tidak ada */ }

// ini yang mengaktifkan Tailwind
import '../css/app.css';
