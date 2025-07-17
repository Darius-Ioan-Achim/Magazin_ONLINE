<script setup lang="ts">
// Importuri comentate temporar pentru a evita erorile
// import AppLayout from '@/layouts/AppLayout.vue';
// import { type BreadcrumbItem } from '@/types';
// import { Head } from '@inertiajs/vue3';

// const breadcrumbs: BreadcrumbItem[] = [
//     {
//         title: 'Products',
//         href: '/products',
//     },
// ];

const handleBookClick = (bookId: number) => {
    // Adaugă funcționalitatea dorită pentru cărți
    console.log(`Book ${bookId} clicked!`);
};

const handleAddBook = () => {
    // Funcționalitate pentru adăugarea unei noi cărți
    console.log('Add new book clicked!');
};

// Aici vei adăuga datele pentru cărți
// const books = ref([
//     { id: 1, title: 'Titlu Carte 1', author: 'Autor 1', description: 'Descriere scurtă...' },
//     { id: 2, title: 'Titlu Carte 2', author: 'Autor 2', description: 'Descriere scurtă...' },
// ]);
</script>

<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 relative overflow-hidden">
    <!-- Elemente decorative de fundal -->
    <div class="absolute top-0 left-0 w-full h-full">
      <div class="absolute top-10 left-10 w-32 h-32 bg-blue-200 rounded-full opacity-30 animate-pulse"></div>
      <div class="absolute bottom-20 right-20 w-24 h-24 bg-purple-200 rounded-full opacity-40 animate-bounce"></div>
      <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-indigo-200 rounded-full opacity-50 animate-ping"></div>
      <div class="absolute top-1/3 right-1/4 w-20 h-20 bg-pink-200 rounded-full opacity-30 animate-float"></div>
    </div>
    
    <!-- Header -->
    <div class="relative z-10 pt-8 pb-6 text-center">
      <h1 class="text-4xl md:text-5xl font-bold mb-4 bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent animate-fade-in">
        Biblioteca Ta
      </h1>
      <p class="text-gray-600 text-lg max-w-2xl mx-auto px-4">
        Descoperă și organizează-ți colecția de cărți într-un mod elegant și modern
      </p>
    </div>

    <!-- Buton pentru adăugarea unei cărți noi -->
    <div class="relative z-10 flex justify-center mb-8">
      <button
        class="group relative bg-gradient-to-r from-green-500 to-emerald-600 text-white px-8 py-3 rounded-xl font-semibold shadow-lg transform transition-all duration-300 hover:scale-105 hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-green-300 focus:ring-opacity-50 overflow-hidden"
        @click="handleAddBook"
      >
        <!-- Efect de strălucire -->
        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
        
        <!-- Textul butonului -->
        <span class="relative flex items-center justify-center gap-2">
          <svg class="w-5 h-5 transform group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          Adaugă Carte Nouă
        </span>
      </button>
    </div>

    <!-- Grid pentru cărți -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 pb-16">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        
        <!-- Card pentru carte - Exemplu 1 -->
        <div class="group relative bg-white/80 backdrop-blur-sm p-6 rounded-2xl shadow-lg border border-white/20 transform transition-all duration-300 hover:scale-105 hover:shadow-2xl cursor-pointer">
          <!-- Placeholder pentru imaginea cărții -->
          <div class="aspect-[3/4] mb-4 bg-gradient-to-br from-blue-400 to-purple-500 rounded-lg flex items-center justify-center shadow-md transform transition-transform duration-300 group-hover:scale-105">
            <svg class="w-12 h-12 text-white opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
          </div>
          
          <!-- Informații carte -->
          <h3 class="text-lg font-semibold mb-2 text-gray-800 group-hover:text-blue-600 transition-colors duration-300">
            Titlu Carte 1
          </h3>
          <p class="text-sm text-gray-600 mb-2">Autor: Nume Autor</p>
          <p class="text-sm text-gray-500 mb-4 line-clamp-3">
            Descriere scurtă a cărții care va fi afișată în card...
          </p>
          
          <!-- Buton pentru carte -->
          <button
            class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white py-2 px-4 rounded-lg font-medium shadow-md transform transition-all duration-300 hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-opacity-50"
            @click="handleBookClick(1)"
          >
            Vezi Detalii
          </button>
        </div>

        <!-- Card pentru carte - Exemplu 2 -->
        <div class="group relative bg-white/80 backdrop-blur-sm p-6 rounded-2xl shadow-lg border border-white/20 transform transition-all duration-300 hover:scale-105 hover:shadow-2xl cursor-pointer">
          <!-- Placeholder pentru imaginea cărții -->
          <div class="aspect-[3/4] mb-4 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-lg flex items-center justify-center shadow-md transform transition-transform duration-300 group-hover:scale-105">
            <svg class="w-12 h-12 text-white opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
          </div>
          
          <!-- Informații carte -->
          <h3 class="text-lg font-semibold mb-2 text-gray-800 group-hover:text-emerald-600 transition-colors duration-300">
            Titlu Carte 2
          </h3>
          <p class="text-sm text-gray-600 mb-2">Autor: Nume Autor</p>
          <p class="text-sm text-gray-500 mb-4 line-clamp-3">
            Descriere scurtă a cărții care va fi afișată în card...
          </p>
          
          <!-- Buton pentru carte -->
          <button
            class="w-full bg-gradient-to-r from-emerald-500 to-teal-600 text-white py-2 px-4 rounded-lg font-medium shadow-md transform transition-all duration-300 hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-emerald-300 focus:ring-opacity-50"
            @click="handleBookClick(2)"
          >
            Vezi Detalii
          </button>
        </div>

        <!-- Card pentru carte - Exemplu 3 -->
        <div class="group relative bg-white/80 backdrop-blur-sm p-6 rounded-2xl shadow-lg border border-white/20 transform transition-all duration-300 hover:scale-105 hover:shadow-2xl cursor-pointer">
          <!-- Placeholder pentru imaginea cărții -->
          <div class="aspect-[3/4] mb-4 bg-gradient-to-br from-rose-400 to-pink-500 rounded-lg flex items-center justify-center shadow-md transform transition-transform duration-300 group-hover:scale-105">
            <svg class="w-12 h-12 text-white opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
          </div>
          
          <!-- Informații carte -->
          <h3 class="text-lg font-semibold mb-2 text-gray-800 group-hover:text-rose-600 transition-colors duration-300">
            Titlu Carte 3
          </h3>
          <p class="text-sm text-gray-600 mb-2">Autor: Nume Autor</p>
          <p class="text-sm text-gray-500 mb-4 line-clamp-3">
            Descriere scurtă a cărții care va fi afișată în card...
          </p>
          
          <!-- Buton pentru carte -->
          <button
            class="w-full bg-gradient-to-r from-rose-500 to-pink-600 text-white py-2 px-4 rounded-lg font-medium shadow-md transform transition-all duration-300 hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-rose-300 focus:ring-opacity-50"
            @click="handleBookClick(3)"
          >
            Vezi Detalii
          </button>
        </div>

        <!-- Card pentru carte - Exemplu 4 -->
        <div class="group relative bg-white/80 backdrop-blur-sm p-6 rounded-2xl shadow-lg border border-white/20 transform transition-all duration-300 hover:scale-105 hover:shadow-2xl cursor-pointer">
          <!-- Placeholder pentru imaginea cărții -->
          <div class="aspect-[3/4] mb-4 bg-gradient-to-br from-amber-400 to-orange-500 rounded-lg flex items-center justify-center shadow-md transform transition-transform duration-300 group-hover:scale-105">
            <svg class="w-12 h-12 text-white opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
          </div>
          
          <!-- Informații carte -->
          <h3 class="text-lg font-semibold mb-2 text-gray-800 group-hover:text-amber-600 transition-colors duration-300">
            Titlu Carte 4
          </h3>
          <p class="text-sm text-gray-600 mb-2">Autor: Nume Autor</p>
          <p class="text-sm text-gray-500 mb-4 line-clamp-3">
            Descriere scurtă a cărții care va fi afișată în card...
          </p>
          
          <!-- Buton pentru carte -->
          <button
            class="w-full bg-gradient-to-r from-amber-500 to-orange-600 text-white py-2 px-4 rounded-lg font-medium shadow-md transform transition-all duration-300 hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-amber-300 focus:ring-opacity-50"
            @click="handleBookClick(4)"
          >
            Vezi Detalii
          </button>
        </div>

      </div>
    </div>

    <!-- Indicatori decorativi din footer -->
    <div class="relative z-10 flex justify-center pb-8">
      <div class="flex space-x-2">
        <div class="w-2 h-2 bg-blue-400 rounded-full animate-pulse"></div>
        <div class="w-2 h-2 bg-purple-400 rounded-full animate-pulse" style="animation-delay: 0.2s"></div>
        <div class="w-2 h-2 bg-indigo-400 rounded-full animate-pulse" style="animation-delay: 0.4s"></div>
      </div>
    </div>
  </div>
</template>

<style scoped>
@keyframes fade-in {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fade-in {
  animation: fade-in 0.6s ease-out;
}

/* Efect de umbră personalizat */
.shadow-3xl {
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25), 0 0 0 1px rgba(255, 255, 255, 0.1);
}

/* Animație pentru elementele de fundal */
@keyframes float {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-20px); }
}

.animate-float {
  animation: float 3s ease-in-out infinite;
}

/* Utility pentru text truncat */
.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>