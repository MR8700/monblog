{{-- Loading Spinner réutilisable --}}
<div class="flex items-center justify-center gap-3">
  <div class="inline-flex h-8 w-8 animate-spin rounded-full border-4" 
    :class="{
      'border-primary border-t-transparent': '{{ $variant }}' === 'primary',
      'border-success border-t-transparent': '{{ $variant }}' === 'success',
      'border-danger border-t-transparent': '{{ $variant }}' === 'danger',
      'border-slate-300 border-t-slate-700': '{{ $variant }}' === 'muted'
    }">
  </div>
  @if($text ?? null)
    <span class="text-sm font-medium text-slate-600">{{ $text }}</span>
  @endif
</div>
