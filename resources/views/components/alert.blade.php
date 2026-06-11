{{-- Toast/Alert réutilisable avec Alpine.js --}}
<div 
  x-data="{ show: true }" 
  x-init="setTimeout(() => show = false, $el.dataset.duration || 4000)"
  x-show="show"
  x-transition:enter="transition ease-out duration-300"
  x-transition:enter-start="opacity-0 transform translate-y-2"
  x-transition:enter-end="opacity-100 transform translate-y-0"
  x-transition:leave="transition ease-in duration-200"
  x-transition:leave-start="opacity-100 transform translate-y-0"
  x-transition:leave-end="opacity-0 transform translate-y-2"
  class="fixed top-6 right-6 z-50 w-96 max-w-[calc(100vw-2rem)] rounded-2xl shadow-xl backdrop-blur-sm border p-4 flex items-start gap-4"
  :class="{
    'bg-green-50/95 border-green-200 text-green-900': '{{ $type }}' === 'success',
    'bg-red-50/95 border-red-200 text-red-900': '{{ $type }}' === 'danger',
    'bg-blue-50/95 border-blue-200 text-blue-900': '{{ $type }}' === 'info',
    'bg-yellow-50/95 border-yellow-200 text-yellow-900': '{{ $type }}' === 'warning'
  }"
>
  <div class="shrink-0 text-lg">
    @switch($type)
      @case('success')
        <i class="fas fa-check-circle text-green-500"></i>
      @break
      @case('danger')
        <i class="fas fa-exclamation-circle text-red-500"></i>
      @break
      @case('info')
        <i class="fas fa-info-circle text-blue-500"></i>
      @break
      @case('warning')
        <i class="fas fa-warning text-yellow-500"></i>
      @break
    @endswitch
  </div>
  
  <div class="flex-1 min-w-0">
    @if($title ?? null)
      <p class="font-semibold mb-1">{{ $title }}</p>
    @endif
    <p class="text-sm opacity-90">{{ $slot }}</p>
  </div>

  <button 
    @click="show = false"
    class="shrink-0 opacity-50 hover:opacity-100 transition"
    aria-label="Fermer"
  >
    <i class="fas fa-times"></i>
  </button>

  <!-- Progress bar d'auto-fermeture -->
  <div 
    class="absolute bottom-0 left-0 h-1 rounded-b-full opacity-50"
    :class="{
      'bg-green-500': '{{ $type }}' === 'success',
      'bg-red-500': '{{ $type }}' === 'danger',
      'bg-blue-500': '{{ $type }}' === 'info',
      'bg-yellow-500': '{{ $type }}' === 'warning'
    }"
    x-init="
      let width = 100;
      const interval = setInterval(() => {
        width -= 2;
        if (width <= 0) clearInterval(interval);
        $el.style.width = width + '%';
      }, 40)
    "
  ></div>
</div>
