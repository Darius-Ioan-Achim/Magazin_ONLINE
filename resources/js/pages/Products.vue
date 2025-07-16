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

const handleClick = () => {
    // Adaugă funcționalitatea dorită aici
    console.log('Button clicked!');
};
</script>

<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 relative overflow-hidden">
    <!-- Elemente decorative de fundal -->
    <div class="absolute top-0 left-0 w-full h-full">
      <div class="absolute top-10 left-10 w-32 h-32 bg-blue-200 rounded-full opacity-30 animate-pulse"></div>
      <div class="absolute bottom-20 right-20 w-24 h-24 bg-purple-200 rounded-full opacity-40 animate-bounce"></div>
      <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-indigo-200 rounded-full opacity-50 animate-ping"></div>
    </div>
    
    <!-- Cardul principal -->
    <div class="relative bg-white/80 backdrop-blur-sm p-8 rounded-2xl shadow-2xl text-center border border-white/20 max-w-md w-full mx-4 transform transition-all duration-300 hover:scale-105 hover:shadow-3xl">
      <!-- Icon decorativ -->
      <div class="mx-auto mb-6 w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center shadow-lg transform transition-transform duration-300 hover:rotate-12">
        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
        </svg>
      </div>
      
      <!-- Titlu cu gradient -->
      <h2 class="text-3xl font-bold mb-4 bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent animate-fade-in">
        Salut, utilizator!
      </h2>
      
      <!-- Mesaj cu stil îmbunătățit -->
      <p class="text-gray-600 mb-8 text-lg leading-relaxed">
        Acesta este un mesaj simplu de test cu un design modern și elegant.
      </p>
      
      <!-- Buton cu animații și efecte -->
      <button
        class="group relative bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-3 rounded-xl font-semibold shadow-lg transform transition-all duration-300 hover:scale-105 hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-blue-300 focus:ring-opacity-50 overflow-hidden"
        @click="handleClick"
      >
        <!-- Efect de strălucire -->
        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
        
        <!-- Textul butonului -->
        <span class="relative flex items-center justify-center gap-2">
          <svg class="w-5 h-5 transform group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
          </svg>
          Click aici
        </span>
      </button>
      
      <!-- Indicatori decorativi -->
      <div class="flex justify-center mt-6 space-x-2">
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
</style>