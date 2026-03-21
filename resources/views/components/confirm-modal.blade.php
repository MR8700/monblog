{{-- Confirmation Modal réutilisable --}}
@push('modals')
<div 
  x-data="confirmDialog()" 
  @open-confirm.window="open($event.detail)"
  class="fixed inset-0 z-50 flex items-center justify-center pointer-events-none"
>
  <!-- Backdrop -->
  <div 
    x-show="isOpen"
    x-transition
    @click="isOpen = false"
    class="absolute inset-0 bg-black/50 backdrop-blur-sm pointer-events-auto"
  ></div>

  <!-- Modal -->
  <div 
    x-show="isOpen"
    x-transition
    class="relative bg-white rounded-3xl shadow-2xl max-w-sm w-full mx-4 pointer-events-auto p-6 space-y-4"
  >
    <!-- Icon -->
    <div class="text-center">
      <div 
        class="inline-flex h-16 w-16 items-center justify-center rounded-full"
        :class="iconClass"
      >
        <i :class="iconType" class="text-2xl"></i>
      </div>
    </div>

    <!-- Title -->
    <h3 class="text-lg font-semibold text-center" x-text="title"></h3>

    <!-- Message -->
    <p class="text-slate-600 text-center text-sm" x-text="message"></p>

    <!-- Buttons -->
    <div class="flex gap-3 pt-4">
      <button 
        @click="isOpen = false"
        class="flex-1 px-4 py-2 rounded-xl border border-slate-200 font-medium hover:bg-slate-50 transition"
      >
        Annuler
      </button>
      <button 
        @click="confirm()"
        :disabled="isLoading"
        class="flex-1 px-4 py-2 rounded-xl font-medium text-white transition disabled:opacity-50"
        :class="buttonClass"
      >
        <span x-show="!isLoading" x-text="confirmText"></span>
        <span x-show="isLoading" class="flex items-center justify-center gap-2">
          <i class="fas fa-spinner animate-spin"></i>
          Traitement...
        </span>
      </button>
    </div>
  </div>
</div>

<script>
function confirmDialog() {
  return {
    isOpen: false,
    isLoading: false,
    title: '',
    message: '',
    confirmText: 'Confirmer',
    type: 'warning',
    callback: null,
    
    get iconClass() {
      const classes = {
        'danger': 'bg-red-100 text-red-600',
        'success': 'bg-green-100 text-green-600',
        'info': 'bg-blue-100 text-blue-600',
        'warning': 'bg-yellow-100 text-yellow-600'
      };
      return classes[this.type] || classes['warning'];
    },
    
    get iconType() {
      const icons = {
        'danger': 'fas fa-exclamation-triangle',
        'success': 'fas fa-check',
        'info': 'fas fa-info-circle',
        'warning': 'fas fa-question-circle'
      };
      return icons[this.type] || icons['warning'];
    },
    
    get buttonClass() {
      const classes = {
        'danger': 'bg-red-600 hover:bg-red-700',
        'success': 'bg-green-600 hover:bg-green-700',
        'info': 'bg-blue-600 hover:bg-blue-700',
        'warning': 'bg-yellow-600 hover:bg-yellow-700'
      };
      return classes[this.type] || classes['warning'];
    },
    
    open(config) {
      this.title = config.title || 'Confirmation';
      this.message = config.message || '';
      this.confirmText = config.confirmText || 'Confirmer';
      this.type = config.type || 'warning';
      this.callback = config.callback || null;
      this.isOpen = true;
      this.isLoading = false;
    },
    
    confirm() {
      if (this.callback && typeof this.callback === 'function') {
        this.isLoading = true;
        const result = this.callback();
        
        // Si c'est une promesse, attendre sa résolution
        if (result && typeof result.then === 'function') {
          result.then(() => {
            this.isLoading = false;
            this.isOpen = false;
          }).catch((error) => {
            console.error('Erreur:', error);
            this.isLoading = false;
          });
        } else {
          // Sinon fermer immédiatement
          this.isLoading = false;
          this.isOpen = false;
        }
      }
    }
  };
}
</script>
@endpush
