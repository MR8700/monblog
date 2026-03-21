# Changelog

## Version 2.0.0

Release date: 2026-03-21
Status: beta

## Major additions

### Global admin UX

- Toast notification system
- Reusable confirmation modal
- Loading spinner component

### Category management

- Create, edit and delete categories
- List view with article counts

### Tag management

- Create, edit and delete tags
- Color picker and color preview
- List view with article counts

### Post management

- Improved post list
- Complete create form
- Complete edit form
- Detailed show page

## Technical changes

### Architecture

- Unified route naming with `admin.posts.*`, `admin.categories.*` and `admin.tags.*`
- Reusable Blade components
- Centralized notifications

### Controllers

- Updated admin controllers to use the new view paths
- Updated route name references

### Styling

- Consistent Tailwind utility usage
- Shared glass effect surfaces
- Responsive layouts across admin views

## Security

- Admin route protection
- CSRF protection on forms
- Server-side validation
- Policy-based authorization

## Performance

- Pagination on long lists
- Explicit relationship loading
- Minimal JavaScript footprint

## Known limitations

- Some advanced AJAX flows are still pending
- Bulk actions are not implemented yet
- Cross-browser verification still needs manual testing

## Next steps

- Manual end-to-end testing
- Email notifications
- Additional API refinements
- Final production hardening
