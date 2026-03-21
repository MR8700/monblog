# Admin panel documentation

## Overview

This document summarizes the reusable parts of the MonBlog admin panel and the main workflows available to administrators.

## Global components

### Alert component

- File: `resources/views/components/alert.blade.php`
- Purpose: show success, info, warning or danger toast messages
- Supports optional title and auto dismiss

```blade
<x-alert type="success" title="Succes">
  Votre article a ete cree avec succes.
</x-alert>
```

### Loading component

- File: `resources/views/components/loading.blade.php`
- Purpose: display a lightweight loading spinner
- Supports variants and optional text

```blade
<x-loading variant="primary" text="Chargement..." />
```

### Confirm modal component

- File: `resources/views/components/confirm-modal.blade.php`
- Included globally in the main layout
- Used for destructive actions

```javascript
window.dispatchEvent(new CustomEvent('open-confirm', {
  detail: {
    title: 'Confirmer la suppression',
    message: 'Cette action est irreversible.',
    confirmText: 'Supprimer',
    cancelText: 'Annuler',
    type: 'danger',
    callback: async () => true
  }
}));
```

## Admin views

### Categories

- `admin.categories.index`: list categories and article counts
- `admin.categories.create`: create a category
- `admin.categories.edit`: update a category

### Tags

- `admin.tags.index`: list tags, colors and usage counts
- `admin.tags.create`: create a tag with a color
- `admin.tags.edit`: update a tag

### Posts

- `admin.posts.index`: list posts with status, visibility and actions
- `admin.posts.create`: full creation form
- `admin.posts.edit`: full update form
- `admin.posts.show`: post detail view with media and metadata

### Orders

- `admin.orders.index`: orders list with status overview
- `admin.orders.show`: order detail page
- `orders.confirmation`: public confirmation page

## Layout integration

The main layout includes:

- Session flash message rendering
- Validation error rendering
- Global confirm modal mounting

```blade
@if(session('success'))
  <x-alert type="success">{{ session('success') }}</x-alert>
@endif

<x-confirm-modal />
```

## UI conventions

### Navigation link

```blade
<a href="{{ route('admin.posts.index') }}" class="inline-flex items-center gap-2 text-primary">
  <i class="fas fa-chevron-left"></i> Retour
</a>
```

### Status badge

```blade
<span class="px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-700">
  Publie
</span>
```

### Action button

```blade
<a href="{{ route('admin.posts.edit', $post) }}" class="inline-block px-3 py-1 rounded-lg bg-blue-100 text-blue-700">
  Editer
</a>
```

## Security notes

- Admin routes are protected
- CSRF tokens are used on forms
- Form Request validation is enabled
- Policies are used for restricted resources

## Performance notes

- Lists are paginated
- Relations are loaded explicitly where needed
- The frontend stays lightweight with Tailwind and Alpine.js
